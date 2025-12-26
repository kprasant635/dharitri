<?php
class TeaGrantControllerLm extends CI_Controller
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
    $this->load->model('TeaGrant/LM/TeaGrantModel');
    $this->load->model('SettlementModel/SettlementVgrModel');
    $this->load->model('SettlementModel/SettlementCommonModel');
    $this->load->library('AES');
    $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
    $this->load->model('UtilsModel');
    $this->load->model('SettlementMb/SettlementCommonDcModel');
    $this->dbswitch();

    $allowed = ['LM'];
    $user_desig_code = $this->session->userdata('user_desig_code');

    // Restrict access if not in allowed list
    if ( ! in_array($user_desig_code, $allowed)) {
        echo json_encode(['error' => 'Unauthorized access']);
        exit; // or die();
    }

    if(HOLD_All_MB2_CASES_STATUS == 1)
    {
      if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
      {
        $this->session->set_flashdata('message', " Processing of Limited Conversion of Tea Grant MB 2.0 Cases has been stopped !");
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
    } else if ($this->session->userdata('dist_code') == "22") {
      $this->db = $this->load->database('dha41', true);
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

    $cases['cases']     = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and service_code=? and status=? and from_office=? and pending_officer=?  and date_entry >= ?", [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $service_code, 'R', 'CO', 'LM', $define_date])->result();
    // echo $this->db->last_query(); die;

    $cases['_view'] = 'TeaGrant/LM/RevertedTeaGrantLMList';
    $this->load->view('layouts/main', $cases);
  }

  // In case of Revert back from Circle officer CO
  public function secondProceeding()
  {
    $application_no = $this->input->get('app');
    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    $this->utilityclass->lmAuthBasic($application_no);

    if(trim($this->utilityclass->checkIfAlreadyUpdatedByLm($application_no)) != 'y'){
      $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
      redirect(base_url() . "index.php/home");
    }

    // check if data available in history table
    $fromHistory           = $this->TeaGrantModel->checkDataInTeaHistory($application_no);

    $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
    $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
    $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);
    
    $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

    $lmdata        = [];

    $dags          = $this->TeaGrantModel->getSettlementDag($application_no);
    $lmnotes       = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
    $proceedings   = $this->TeaGrantModel->getSettlementProceeding($application_no);
    $dhardocuments = $this->TeaGrantModel->getDocuments($application_no);
    $nominee       = $this->TeaGrantModel->getAllNomineeDetail($application_no);
    $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
    $deed_applicant= $this->TeaGrantModel->getAllDeedPattadar($application_no);
    $family_tree   = $this->TeaGrantModel->getAllFamilyTree($application_no);

    $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid=?",[$application_no])->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    $lmdata['application_no'] = $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

    $additional_property = $this->db->query("Select * from settlement_additional_property where applid=?",[$applid]);

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


    // check if data exist in additional property 
    $lmdata['additional_property']=$additional_property->result();

    // var_dump($lmdata['additional_property']); die;

    




      /// premium
      $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
      $lmdata['s_area'] = $s_area;

      $premiumData = $this->db->query("Select * from settlement_premium where case_no=? and is_final=?", [$application_no, 1])->row();
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

      // echo "dsfgbhnb"; die;



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

      $display_old_nature_revert=0;
      foreach ($dags as $dag_nature_check) {
        if (!is_null($dag_nature_check->nature_possession)){
          $display_old_nature_revert=1;

        }else{
          $display_old_nature_revert=0;
        }
      }


      $lmdata['display_old_nature_revert']=$display_old_nature_revert;

      $sql = "Select basundhara from basundhar_application where dharitree=? ";
      $basundhara = $this->db->query($sql, [$application_no])->row();
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
      $lmdata['document']    = $output->documents;
      $lmdata['query']       = $output->query;
      $lmdata['property']    = $output->property;
      $lmdata['aadhar']      = $output->aadhar;

      foreach ($output->selfDeclaration as $selfDec) {
        $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      // for guardian relation
      $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN (?,?)";

      $relation_executation = $this->db->query($query_for_guar_rel, ['5', '6']);
      $row = $relation_executation->num_rows();
      if ($row != 0) {
          $lmdata['guar_rel'] = $relation_executation->result();
      }

      $applid_vlb = $this->utilityclass->getApplidFromCaseNo($application_no);


      

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

      $premiumData = $this->db->query("Select * from settlement_premium where case_no=? and is_final=?", [$application_no, 1])->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end




      //get data from settlement_ap_lmnote
      $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
          case_no=?", [$application_no])->row()->is_landless;
      $lmdata['apLmNote'] = $apLmNote;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
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

      $authDb = $this->load->database('auth', TRUE);
      $lmdata['land_class'] = $authDb->query("SELECT * FROM landclass_code_central")->result();
      // var_dump($lmdata['land_class']); die;

      // var_dump($_SERVER['REQUEST_METHOD']); die;

      $distDb = $this->load->database('db2', TRUE);
      $lmdata['district_all'] = $distDb->query("SELECT * FROM district_details")->result();
      

      // echo "<pre>";
      // var_dump($lmdata['district_all']);
      // var_dump($this->db);
      // echo $this->db->last_query(); die;

      $lmdata['dag_count'] = count($dags);

      //**************-js- if request_method not an update */
      if($_SERVER['REQUEST_METHOD'] != 'POST'){
        $lmdata['_view'] = 'TeaGrant/LM/RevertedTeaGrantLMView';
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

        

        // if($mStat == true)
        // {
        //   foreach($lmdata['applicants_buyers'] as $applicantRow)
        //   {
        //     if($applicantRow->is_applicant != 1)
        //     {
        //       if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
        //       {
        //         $mStatErr = true;   
        //         break;
        //       }
        //     }
        //   }
        // }

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

        // if($mStatErr == true)
        // {
        //   $data = array(
        //     'error' => '#ERR14233: Spouse details has to be added if you select applicant as married!!!' .$case_no,
        //   );
        //   echo json_encode($data);
        //   return false;
        // }

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $is_prem_update = $this->input->post('prem_update');

        // var_dump($is_prem_update); die;

        if($fromHistory > 0 && $is_prem_update == 'NO')
        {
          $data = array(
            'error' => '#ERR500: Premium re calculation is mandatory for case ' .$case_no,
          );
          echo json_encode($data);
          return false;
        }
        // die;

        if($distCode == NULL)
        {
          redirect(base_url(). 'index.php/home/TeaGrantLandLm?service='.TEA_SERVICE_CODE);
        }
        if($case_no == NULL)
        {
          redirect(base_url(). 'index.php/home/TeaGrantLandLm?service='.TEA_SERVICE_CODE);
        }
        $this->load->library('form_validation');
        

        $basic             = $this->TeaGrantModel->getSettlementBasic($case_no);
        //  result
        $applicants_buyers = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
        $applicants_owners = $this->TeaGrantModel->getAllApplicantOwners($case_no);
        $main_applicant    = $this->TeaGrantModel->getMainBuyerApplicant($case_no);

        $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($case_no);

        $dags              = $this->TeaGrantModel->getSettlementDag($case_no);
        $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
        $proceedings       = $this->TeaGrantModel->getSettlementProceeding($case_no);
        $dhardocuments     = $this->TeaGrantModel->getDocuments($case_no);
        $nominee           = $this->TeaGrantModel->getAllNomineeDetail($case_no);

        $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($case_no);
        $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($case_no);
        $family_tree       = $this->TeaGrantModel->getAllFamilyTree($case_no);

        $d = $basic["dist_code"];
        $s = $basic["subdiv_code"];
        $c = $basic["cir_code"];
        $m = $basic["mouza_pargona_code"];
        $l = $basic["lot_no"];
        $v = $basic["vill_townprt_code"];

        /// premium
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
        $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

        $premiumData = $this->db->query("Select * from settlement_premium where case_no=? and is_final=?", [$case_no, 1])->row();
        $lmdata['premiumData'] = $premiumData;
        /// premium end

        $lmdata['basic']                  = $basic;
        $lmdata['geo_date']               = $geo_date;
        $lmdata['applicants_buyers']      = $applicants_buyers;
        $lmdata['applicants_owners']      = $applicants_owners;
        $lmdata['applicants_dag_details'] = $applicants_dag_details;
        $lmdata['main_applicant']         = $main_applicant;

        $lmdata['reservation']            = $this->SettlementVgrModel->getSettlementReservation($case_no);

        $lmdata['dags']                   = $dags;
        $lmdata['lmnotes']                = $lmnotes;
        $lmdata['proceedings']            = $proceedings;
        $lmdata['dhardocuments']          = $dhardocuments;
        $lmdata['nominee']                = $nominee;

        $lmdata['existing_pattadar']      = $existing_pattadar;
        $lmdata['deed_applicant']         = $deed_applicant;
        $lmdata['family_tree']            = $family_tree;

        //   calling API for self declaration data

        $sql = "Select basundhara from basundhar_application where dharitree=? ";
        $basundhara = $this->db->query($sql, [$case_no])->row();

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

        $lmdata['document'] = $output->documents;
        $lmdata['query']    = $output->query;
        $lmdata['property'] = $output->property;
        $lmdata['aadhar']   = $output->aadhar;
        $lmdata['nextKin']  = $output->nextKin;
        foreach($output->selfDeclaration as $selfDec){
          $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
          if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
            $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($applid);
            if($get_aadhaar_photo != 'n'){
              $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            }
          endif;
        endforeach;

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN (?,?)";

        $relation_executation = $this->db->query($query_for_guar_rel, ['5','6']);
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

        // For insertion of Limited Conversion of Tea Grant khasland
        $distCode = trim($this->input->post('dist_code'));
        // if ($distCode == null) {
        //     redirect(base_url(). 'index.php/basundhara2/settlementCases');
        // }
        // if ($application_no == null) {
        //     redirect(base_url(). 'index.php/basundhara2/settlementCases');
        // }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

        //********validation bypass */
        $validation_bypass = 0;

        if(isset($_POST['lm_note']) && $_POST['lm_note'] == '2')
        {
          if(isset($_POST['rejected_reasons']))
          {
            $validation_bypass_array = $this->getValidationBypass(TEA_SERVICE_CODE);
            // var_dump($validation_bypass_array); die;
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
            // $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
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
            $this->form_validation->set_rules('bonafide_transferee', 'Bonafied Transferee', 'trim|required');
            $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
            $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');


            if(trim($this->input->post('is_tribal_belt') == 'YES')){
              $this->form_validation->set_rules('tribal_belt_name', 'Tribal Belt Name', 'trim|required');
              $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
            }
            if(trim($this->input->post('is_tribal_belt') == 'NO')){
              $this->form_validation->set_rules('contravention', 'Contravention', 'trim|required');
            }


            // $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
            


            $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');

            // $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
            // $this->form_validation->set_rules('land_class', ' Present Land use type', 'trim|required');
            $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
            $this->form_validation->set_rules('land_falls_periphery', '10 no point', 'trim|required');
            $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
            $this->form_validation->set_rules('dispute_possession', 'Dispute regarding possession', 'trim|required');
            $this->form_validation->set_rules('lm_possession_entry', 'Possession Since', 'trim|required');

            $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
            $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
            $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
            // $this->form_validation->set_rules('land_exceed', 'Point No 20', 'trim|required');

            $this->form_validation->set_rules('roadside_reservation','','');

            $this->form_validation->set_rules('prem_update', 'Do you want to chnage the premium', 'trim|required');
            $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
            if($is_prem_update=='YES')
            {
              $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
              $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
            }

            $roadside_comment_check = $this->input->post('roadside_comment_check');
            $family_comment_check   = $this->input->post('family_comment_check');

            $totalDagAreaLessaValidation = 0;
            $totalAppliedAreaLessaValidation = 0;
            $appAreaMoreThanDagA = 0;
            $reserveMoreThanAppArea = 0;
            $familyMoreThanAppArea = 0;
            $totalRoadSideAreaLessaValidation = 0;
            $totalFamilyAreaLessaValidation = 0;

            $display_old_nature_check=0;
            $dag_no_array = [];
            foreach ($lmdata['dags'] as $dag_area_cal) {
                //******NCBTAD check  */
                $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

                if($ncBtadCheck > 0)
                {
                    //*******throw error for NCBTAD */
                    log_message('error', '#ERR730: This village is mapped as NCBTAD! '.$case_no);
                    $this->session->set_flashdata('message', "#ERR730: This village is mapped as NCBTAD! ".$case_no);
                    redirect(base_url() . "index.php/home");
                }


                $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');

                if (!is_null($dag_area_cal->nature_possession)){
                    $display_old_nature_check=0;

                }else{
                    $display_old_nature_check=1;

                }
                // for barak valley
                if (in_array($distCode, json_decode(BARAK_VALLEY))) {

                    $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');

                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);
                    $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dag_area_cal->dag_no), 0);

                    $appliedBighaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_b'.$dag_area_cal->dag_no), 0);
                    $appliedKathaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_k'.$dag_area_cal->dag_no), 0);
                    $appliedLessaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_lc'.$dag_area_cal->dag_no), 0);
                    $appliedGandaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_g'.$dag_area_cal->dag_no), 0);

                    $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                    $appliedAreaLessaValidation = ($appliedBighaValidation * 6400) + ($appliedKathaValidation * 320) + ($appliedLessaValidation * 20) + $appliedGandaValidation;

                    if ($dagAreaLessaValidation < $appliedAreaLessaValidation) {
                        $appAreaMoreThanDagA = 1;
                    }

                    $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                    $totalAppliedAreaLessaValidation += $appliedAreaLessaValidation;

                    if ($roadside_comment_check=='YES') {

                        $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                        $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                        $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('reserved_ganda'.$dag_area_cal->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('reserved_kranti'.$dag_area_cal->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
                        $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

                        $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                        if ($appliedAreaLessaValidation < $roadSideAreaLessaValidation) {
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

                        $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
                        $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

                        $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                        if ($appliedAreaLessaValidation < $familyAreaLessaValidation) {
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


                    $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
                    $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
                    $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);

                    $appliedBighaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_b'.$dag_area_cal->dag_no), 0);
                    $appliedKathaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_k'.$dag_area_cal->dag_no), 0);
                    $appliedLessaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_lc'.$dag_area_cal->dag_no), 0);

                    $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                    $appliedAreaLessaValidation = ($appliedBighaValidation * 100) + ($appliedKathaValidation * 20) + $appliedLessaValidation;

                    if ($dagAreaLessaValidation < $appliedAreaLessaValidation) {
                        $appAreaMoreThanDagA = 1;
                    }

                    $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                    $totalAppliedAreaLessaValidation += $appliedAreaLessaValidation;

                    if ($roadside_comment_check=='YES') {

                        $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
                        $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
                        $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
                        $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
                        $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

                        $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                        if ($appliedAreaLessaValidation < $roadSideAreaLessaValidation) {
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

                        $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
                        $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
                        $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

                        $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                        if ($appliedAreaLessaValidation < $familyAreaLessaValidation) {
                            $familyMoreThanAppArea = 1;
                        }

                        $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                    }
                }

                $dag_no_array[] = $dag_area_cal->dag_no;
            }

            //validate for geo tag photo incases of review cases
            $application_no_geo = $this->utilityclass->getApplidFromCaseNo($case_no);

            $sql_geo = $this->db->query('select dag_no from supportive_document where applid in (?, ?) and file_name = ?', array($case_no, $application_no_geo, 'Geo Tag Photo'));

            $geo_result = $sql_geo->result();

            $geo_dag_no_array = array_map(function($item) {
                return $item->dag_no;
            }, $geo_result);

            // new additional property calculation
            $singleAdditionalProToLessa = 0;
            $totalAdditionalProToLessa = 0;
            $additional_properties = $this->db->query("Select * from settlement_additional_property where applid=?",[$application_no])->result();

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

            // $checkUrbanCon = trim($this->input->post('is_urban'));

            if($this->input->post('landslide') == 'YES')
            {
              $checkUrbanCon = 'Y';
            }
            else
            {
              $checkUrbanCon = trim($this->input->post('is_urban'));
            }

            $land_exceed =0;
            // for barak valley
            if (in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                if (TEA_GRANT_MAX_HOMESTEAD * 6400 < $totalAppliedAreaLessaValidation) {

                  $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. TEA_GRANT_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');
                }
                if((TEA_GRANT_MAX_HOMESTEAD + TEA_GRANT_MAX_AGRI) * 6400 < ($totalAppliedAreaLessaValidation + $totalAdditionalProToLessa))
                {
                  $land_exceed =1;
                }

                // new premium addition
                if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                    $maxland_ganda ='';
                    if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

                        if(!empty($maxland_check->max_land)){
                            if($maxland_check->max_land =='40'){
                                $maxland_ganda = 2560;
                            }elseif($maxland_check->max_land =='60'){
                                $maxland_ganda = 3840;
                            }
                            if ($maxland_ganda < ($totalAppliedAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                            }


                        }

                    }
                    // else{
                    //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                    //         $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                    // }

                }

                if($checkUrbanCon == 'Y')
                {
                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){

                        $maxland_ganda ='';
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));

                            if(!empty($maxland_check->max_land)){
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }
                                if ($maxland_ganda < ($totalAppliedAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                        $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }


                            }

                        }
                        // else{
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ' .
                        //         $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                        // }

                    }

                }

            }
            else
            {
                if (TEA_GRANT_MAX_HOMESTEAD * 100 < $totalAppliedAreaLessaValidation) {

                    $this->form_validation->set_rules('khasMaxHomestead','Total applied Homestead area should not be more than '. TEA_GRANT_MAX_HOMESTEAD. ' Bigha !', 'required|callback_khasMaxHomestead');

                }
                if((TEA_GRANT_MAX_HOMESTEAD + TEA_GRANT_MAX_AGRI) * 100 < ($totalAppliedAreaLessaValidation + $totalAdditionalProToLessa))
                {
                    // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. (TEA_GRANT_MAX_HOMESTEAD + TEA_GRANT_MAX_AGRI) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                    $land_exceed =1;
                }

                // new premium addition
                if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                    if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                        $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                        if(!empty($maxland_check->max_land)){

                            if ($maxland_check->max_land < ($totalAppliedAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                            }

                        }

                    }
                    // else{
                    //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ', 'required|callback_totalAppliedAreaInUrban');
                    // }
                }

                if($checkUrbanCon == 'Y')
                {
                    // new premium addition
                    if($this->input->post('area_new'.$dag_area_cal->dag_no) !=10){
                        if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($totalAppliedAreaLessaValidation) - $totalRoadSideAreaLessaValidation) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Applied Area cannot exceed more than ' .
                                        $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        // else{
                        //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing ', 'required|callback_totalAppliedAreaInUrban');
                        // }
                    }
                }
            }

            if(isset($_POST['lm_note']) && $_POST['lm_note'] == '1' && $land_exceed == 1)
            {
                $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (TEA_GRANT_MAX_HOMESTEAD + TEA_GRANT_MAX_AGRI) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
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
                        $this->form_validation->set_rules('additional_doc_err','File additional doc','required');
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

                    if($_FILES['nrc_file_upload'.$i]['name'] && $_FILES['nrc_file_upload'.$i]['size'] && $_FILES['nrc_file_upload'.$i]['tmp_name'])
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
                            $this->form_validation->set_rules('nrc_file_upload'.$i,'File additional doc','required');
                        }
                    // code...
                }
            }

            // if($this->input->post('bonafide_transferee') == 'YES')
            // {
            //   if(empty($_FILES['dalil_upload']['name']))
            //   {
            //     $this->form_validation->set_rules('dalil_upload','Dalil File','required');
            //   }              
            // }

            // if(empty($_FILES['legal_heir_doc']['name']))
            // {
            //   $this->form_validation->set_rules('legal_heir_doc','Legal Heir`s File','required');
            // }
                        

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

        if($this->input->post('dispute_possession') == 'YES')
        {
          $this->form_validation->set_rules('dis_cat_type', 'Category Type', 'trim|required');
        }
        

        // $this->form_validation->set_rules('lm_possession_entry', 'Possession Since', 'trim|required');







        if ($this->form_validation->run() == FALSE)
        {
          $lmdata['all_errors']  = validation_errors();

          if(isset($fileCount)) {
            $lmdata['fileCount'] = $fileCount;
          }
          $lmdata['err_return']  = true;
          $lmdata['_view']       = 'TeaGrant/LM/RevertedTeaGrantLMView';
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

            $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = ? AND from_office = ?", [$case_no, 'LM'])->row()->ct;

            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);

            $phase_count = (int)$phase_count+1;
            $backup_array_lm = [
              'applid'      => $applid_backup,
              'case_no'     => $case_no,
              'from_office' => 'LM',
              'to_office'   => $pending_officer,
              'status'      => 'X',
              'phase'       => 'LM_'.$phase_count,
              'data'        => json_encode($_POST)
            ];

            $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);

            if($backup_insertion_lm != 1){
              $this->db->trans_rollback();
              log_message('error', '#BACKUP001452: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);
              $this->session->set_flashdata('message', "#BACKUP001452: Registration of Limited Conversion of Tea Grant failed for case no : ".$case_no);
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
              }
              else
              {
                if(count(array_unique($dag_arraay))<count($dag_arraay)){
                  $approved_by =$dag_by_approve;
                }else{
                  $approved_by ='GOVT';
                }
              }
            }


            $sql1 = "SELECT petition_no FROM settlement_basic WHERE case_no = ?";
            $result1 = $this->db->query($sql1, [$case_no]);
            if($result1->num_rows() > 0)
            {
                $petition_no = (int)$result1->row()->petition_no;
            }
            else
            {
              $this->db->trans_rollback();
              log_message('error', '#ERRSET1494: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
              $data = array(
                'error'=>"#ERRSET1494: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }

            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = ?";
            $result = $this->db->query($sql, [$case_no]);
            if($result->num_rows() > 0)
            {
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }
            else
            {
              $this->db->trans_rollback();
              log_message('error', '#ERRSET1509: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
              $data = array(
                'error'=>"#ERRSET1509: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }

            // echo "<pre>"; var_dump($_POST); die;

            $basic = array(
              'date_update'          => date('Y-m-d G:i:s'),
              'status'               => 'X',
              'user_code'            => $this->session->userdata('user_code'),
              'lm_code'              => $this->session->userdata('user_code'),
              'co_code'              => $this->input->post('co_code'),
              'period_possession'    => date('Y-m-d', strtotime($this->input->post('lm_possession_entry'))),
              'occupation_applicant' => $this->input->post('occupation_applicant'),
              'from_office'          => 'LM',
              'pending_officer'      => $pending_officer,
              'pending_office'       => $pending_officer,
              'approve_by'           => $approved_by
            );

            if ($is_prem_update=='NO'){
                unset($basic['approve_by']);
            }

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basic);

            // echo $this->db->last_query(); die;

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#SETUP1421: Updation failed in settlement_basic Dharitree Case No ' . $application_no);
                $data = array(
                    'error' => "#SETUP1421: Registration of Limited Conversion of Tea Grant basic failed for case no : " . $application_no,
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
                    $service_code = TEA_SERVICE_CODE;

                    $nrcFilesUploadStatus = $this->SettlementNRCFileUploadModel->uploadNrcFiles($case_no,$nrcDesc,$nrcFileArray,$nrcFileName,$service_code);
                    if($nrcFilesUploadStatus['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERRNRCDOC0001: Registration of Limited Conversion of Tea Grant failed for case no : ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }

                }
                //end=====================

                if($this->input->post('bonafide_transferee') == 'YES')
                {
                  $timestamp = date('mdYhis', time()).uniqid();
                  $dalil_file = $_FILES['dalil_upload'];
                  $dalil_name = 'dalil_upload'.$timestamp;

                  if(empty($_FILES['dalil_upload']['name']))
                  {
                    log_message('error', "#ERROR1551: bonafied selected as yes but dalil not uploaded for case no $case_no");
                    $this->db->trans_rollback();
                    $json = [
                      'errorMessage'=>"#ERROR1551: Upload of dalil is required as point no 2 is selected as YES for the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                  }

                  //upload trace map file by calling API
                  $dalil_api_file = $this->SettlementCommonModel->uploadFileByApiBase($dalil_file, $application_no, API_KEY, $dalil_name);

                  $dalil_json = json_decode($dalil_api_file);
                  // $dalil_upload_path = trim(UPLOAD_DIR_TEA.$timestamp.$dalil_file['name']);

                  // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".UPLOAD_DIR_TEA);
                  // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($dalil_upload_path));
                  // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($dalil_json));


                  $mime = $dalil_file['name'];
                  $exp  = explode(".",$mime);
                  $onlyExtension  = $exp[1];

                  $dalil_upload_path = UPLOAD_DIR_TEA.$timestamp.'dalil.'.$onlyExtension;

                  if($dalil_json->status == 4) // success
                  {
                    $documentDalil = array(
                      'case_no'         => $case_no,
                      'file_name'       => 'Dalil',
                      'user_code'       => $this->session->userdata('user_code'),
                      'fetch_file_name' => $dalil_file['name'],
                      'file_type'       => $dalil_file['type'],
                      'file_path'       => $dalil_upload_path,
                      'date_entry'      => date('Y-m-d H:i:s'),
                      'mut_type'        => TEA_SERVICE_CODE,
                      'api_doc_id'      => $dalil_json->docId,
                    );
                    $insert_dalil_doc = $this->db->insert('supportive_document', $documentDalil);
                    // log_message('error', '#TEA_UPLOAD============for case no : '. $this->db->last_query());

                    if ($insert_dalil_doc != 1) {
                      log_message('error', '#ERROR1594: Insertion failed in supportive_document for case no :'. $this->db->last_query());
                      $this->db->trans_rollback();

                      $json = [
                        'errorMessage'=>"#ERROR1594: Failed to forward the case for Case No : ".$case_no
                      ];
                      echo json_encode($json);
                      return false;
                    }
                  }
                  else {
                    log_message('error', 'Unable to upload Dalil file for case no '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERROR1607: Only PDF and Image files are allowed : ".$application_no);
                    redirect(base_url() . "index.php/home");
                  }

                  if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
                  {
                    // Dalil copy upload
                    $config['file_name']     = $dalil_name;
                    $config['upload_path']   = UPLOAD_DIR_TEA;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']      = 2000;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if(!move_uploaded_file($dalil_file['tmp_name'], $dalil_upload_path)){
                      log_message('error', 'Unable to move Dalil file for case no '.$case_no);
                      $this->db->trans_rollback();
                      $this->session->set_flashdata('message', "#ERROR4778: Only PDF and Image files are allowed : ".$application_no);
                      redirect(base_url() . "index.php/home");
                    }
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

                        $config['upload_path']   = UPLOAD_DIR_TEA;
                        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                        $config['max_size']  = UPLOAD_MAX_SIZE;;
                        $config['file_name'] = $fileRename;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('file'))
                        {
                            $document= array(
                              'case_no'         => $case_no,
                              'file_name'       => $_POST['fileText'][$i],
                              'user_code'       => $this->session->userdata('user_code'),
                              'fetch_file_name' => $_POST['fileText'][$i],
                              'file_type'       => $_FILES['file']['type'],
                              'file_path'       => UPLOAD_DIR_TEA . $fileRename,
                              'date_entry'      => date('Y-m-d H:i:s'),
                              'mut_type'        => TEA_SERVICE_CODE,
                            );

                            // save data in attachment file
                            $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                            if($addMoreDocQuery != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);

                                $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Limited Conversion of Tea Grant failed for case no : ".$case_no);
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

                            $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Limited Conversion of Tea Grant failed for case no : ".$case_no);
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
                                $config['upload_path']          = UPLOAD_DIR_TEA;
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
                $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(TEA_SERVICE_CODE);

                // var_dump($responseMasterObj); die;

                $comment = addslashes($this->input->post('lm_note'));

                $pro_class_lm = $this->input->post('protected_class_lm');
                $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');


                // chitha_verified  bonafide_transferee   bhumiputra_confirmation_lm
                // is_tribal_belt   protected_class_lm    possession_verification
                // $nature_entry_single   is_landless   land_class  landslide
                // land_falls_periphery   dispute_possession  lm_possession_entry
                // land_exceed  lra_deed_no               

                $dis_cat_type = null;
                if($this->input->post('dispute_possession') == 'YES')
                {
                  $dis_cat_type = $this->input->post('dis_cat_type');
                }

                foreach ($lmdata['dags'] as $land_classes) {
                  $land_class_arr[] = [
                    'dag_no'               => $land_classes->dag_no,
                    'prev_land_class_name' => $this->input->post('prev_land_class_name'.$land_classes->dag_no),
                    'prev_land_class_code' => $this->input->post('prev_land_class_code'.$land_classes->dag_no),
                    'land_class'           => $this->input->post('land_class'.$land_classes->dag_no) == 0 ? $this->input->post('land_class'.$land_classes->dag_no) : 0,
                  ];
                }

                $land_class = $land_class_arr;

                $lra_report_new = [
                  'chitha_verified'            => $this->input->post('chitha_verified'),
                  'bonafide_transferee'        => $this->input->post('bonafide_transferee'),
                  'bhumiputra_confirmation_lm' => $this->input->post('bhumiputra_confirmation_lm'),
                  'is_tribal_belt'             => $this->input->post('is_tribal_belt'),
                  'protected_class_lm'         => !empty($this->input->post('protected_class_lm')) ? $this->input->post('protected_class_lm') : '',
                  'possession_verification'    => $this->input->post('possession_verification'),
                  'is_landless'                => $this->input->post('is_landless'),
                  'land_class'                 => $land_class,
                  'landslide'                  => $this->input->post('landslide'),
                  'land_falls_periphery'       => $this->input->post('land_falls_periphery'),
                  'dispute_possession'         => $this->input->post('dispute_possession'),
                  'lm_possession_entry'        => date('Y-m-d', strtotime($this->input->post('lm_possession_entry'))),
                  'lra_deed_no'                => $this->input->post('lra_deed_no'),
                  'dis_cat_type'               => $dis_cat_type,  
                  'lra_possession_remark'      => $this->input->post('lra_possession_remark'),             
                  'lra_deed_date'              => $this->input->post('lra_deed_date'),             
                  'contravention'              => !empty($this->input->post('contravention')) ? $this->input->post('contravention') : '',             
                  'tribal_belt_name'           => !empty($this->input->post('tribal_belt_name')) ? $this->input->post('tribal_belt_name') : '',             
                ];

                $lmnote=array(
                  'chitha_verified'         => $this->input->post('chitha_verified'),
                  'is_tribal_belt'          => $this->input->post('is_tribal_belt'),
                  'possession_verification' => $this->input->post('possession_verification'),
                  'period_possession'       => date('Y-m-d', strtotime($this->input->post('lm_possession_entry'))),
                  'nature_possession'       => $nature_entry_single,
                  'is_landless'             => $this->input->post('is_landless'),
                  'land_falls'              => $this->input->post('land_falls'),
                  'falls_und_gmc'           => $this->input->post('falls_und_gmc'),
                  'roadside_reservation'    => $this->input->post('roadside_reservation'),
                  'trace_map_copy'          => 'NA',
                  'chitha_copy'             => 'NA',
                  'lm_note'                 => $comment,
                  'lm_remark_text'          => $this->input->post('lm_remark_text'),
                  'date_update'             => date('Y-m-d H:i:s'),
                  'case_no'                 => $case_no,
                  'status'                  => 'W',
                  'total_bigha'             => 0,
                  'total_Katha'             => 0,
                  'total_lessa'             => 0,
                  'total_ganda'             => 0,
                  'total_kranti'            => 0,
                  'landslide'               => $this->input->post('landslide'),
                  'protected_class_lm'      => $protected_class_lm,
                  'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
                  'lm_rejected_remarks'     => json_encode($responseMasterObj->reject_remarks),
                  'lm_tea_report'           => json_encode($lra_report_new),
                );

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_ap_lmnote', $lmnote);

                if ($this->db->affected_rows() == 0) {
                  $this->db->trans_rollback();
                  log_message('error', '#SETUP1692: Updation failed in settlement_ap_lmnote Dharitree Case No ' . $application_no);
                  $data = array(
                    'error' => "#SETUP1692: Registration of settlement_ap_lmnote failed for case no : " . $application_no,
                  );
                  echo json_encode($data);
                  return false;
                }

                // var_dump($reservation); die;
                $reservation = $this->SettlementVgrModel->getSettlementReservation($case_no);
                // var_dump($reservation); die;

                /// road side reserve area start /////
                if($reservation == true)
                {
                  // echo "dsfgh"; die;
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
                          'date_update' => date('Y-m-d H:i:s'),
                        );

                        $this->db->where('case_no', $case_no);
                        $this->db->where('type', 'R');
                        $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                        $this->db->update('settlement_reservation', $reservedarea_road);
                        // echo $th
                        if ($this->db->affected_rows() == 0) {
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP1717: Updation failed in settlement_reservation Dharitree Case No ' . $application_no);
                            $data = array(
                                'error' => "#SETUP1717: Registration of settlement_reservation failed for case no : " . $application_no,
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
                          log_message('error', '#RESUPDTT1745: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                          $data = array(
                              'error'=>"#RESUPDTT1745: Updation Limited Conversion of Tea Grant failed for case no : ".$application_no
                          );
                          echo json_encode($data);
                          return false;
                      }

                  }
                }


                else{
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
                        'date_entry'=>date('Y-m-d H:i:s'),
                        'date_update'=>date('Y-m-d H:i:s'),
                        'type'=>'R'
                      );

                      $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                      // echo $this->db->last_query(); die();
                      if ($reserveData != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#UPDTT1785: Update failed in settlement_reservation RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#UPDTT1785: Update failed for case no : ".$application_no
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
                            log_message('error', '#ERRSET1810: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET1810: Updation Limited Conversion of Tea Grant failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }

                    $sumMbAmount = 0;
                    $approved_by = '';
                    $count       = 0;


                    foreach ($lmdata['dags'] as $dag_premium) {

                      // echo "<pre>"; var_dump($dag_premium); die;

                      $count++;
                      if($count >1){
                        if ($approved_by != $this->input->post('approval'.$dag_premium->dag_no)){
                          $this->db->trans_rollback();
                          $this->session->set_flashdata('message', "Error #ERRAM1829: Limited Conversion of Tea Grant Application not submitted case no # $application_no");
                          log_message('error', '#ERRAM1829: Multiple User Approval, RTPS Case No '.$application_no);
                          redirect(base_url() . "index.php/home");
                        }
                      }

                      // premium verify start ******************
                      if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                        $area_in_bigha = 6400;
                      }else{
                        $area_in_bigha = 100;
                      }

                      $uuid = $this->db->query("SELECT uuid FROM settlement_basic WHERE case_no=?", array($case_no))->row()->uuid;
                      $dag_no = $dag_premium->dag_no;


                      // log_message("error", "PREMIUM_GHOTALA_dist_code===".json_encode($dag_premium->dist_code));
                      // log_message("error", "PREMIUM_GHOTALA_uuid===".json_encode($uuid));
                      // log_message("error", "PREMIUM_GHOTALA_dag_no===".json_encode($dag_no));

                      $is_full_pay=$this->input->post('paymode');
                      $prem_zonal = $this->utilityclass->getZonalValue($dag_premium->dist_code,$uuid,$dag_no);

                      $prem_area = $this->input->post('total_lessa'.$dag_no);
                      $prem_concession = "YES";

                      $percentage  = 10;
                      $zonal_lessa = $prem_zonal / $area_in_bigha;
                      $premium     = $prem_area * $zonal_lessa;
                      $finalamount = ceil($premium * $percentage / 100);

                      $sumMbAmount += $finalamount;

                      // premium verify end ******************
                      $fmd=array(
                        'case_no'         => $case_no,
                        'user_code'       => $this->session->userdata('user_code'),
                        'uuid'            => $basic['uuid'],
                        'dag_no'          => $dag_premium->dag_no,
                        'zonal_valuation' => $this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
                        'area_name'       => null,
                        'land_type'       => null,
                        'rate_type'       => null,
                        'rate'            => null,
                        'concession'      => null,
                        'amount_dag'      => $this->input->post('amount'.$dag_premium->dag_no),
                        'final_amount'    => $this->input->post('finalamount'),
                        'due_amount'      => $this->input->post('totaldue'),
                        'total_lessa'     => $this->input->post('total_lessa'.$dag_premium->dag_no),
                        'is_full_pay'     => $this->input->post('paymode'),
                        'is_final'        => 1,
                        'date_entry'      => date('Y-m-d H:i:s'),
                      );

                      $insPremium = $this->db->insert('settlement_premium', $fmd);

                      if ($insPremium != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002515: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0002515: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                      }

                      $approved_by = $this->input->post('approval'.$dag_premium->dag_no);
                    } // foreach end


                    // log_message("error", "PREMIUM_GHOTALA_prem_zonal===".$prem_zonal);
                    // log_message("error", "PREMIUM_GHOTALA_sumMbAmount===".$finalamount);
                    // log_message("error", "PREMIUM_GHOTALA_postdata===".$this->input->post('finalamount'));

                    // premium verify 2 start ******************
                    if($sumMbAmount != $this->input->post('finalamount')){
                        // var_dump("Amount mismatch!!!"); die;
                      $this->db->trans_rollback();
                      $this->session->set_flashdata('message', "Error #ERRAM1895: Limited Conversion of Tea Grant Application not submitted case no # $application_no");
                      log_message('error', '#ERRAM1895: Premium ghotala by LM, RTPS Case No '.$application_no);
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
                      $this->session->set_flashdata('message', "Error #ERRAM1912: Limited Conversion of Tea Grant Application not submitted case no # $case_no");
                      log_message('error', '#ERRAM1912: Premium ghotala by LM, RTPS Case No '.$case_no);
                      redirect(base_url() . "index.php/home");
                    }

                    // premium verify 2 end ******************
                }
                // else{
                //   // area check with premium table before update ******************
                //   $prem_settleemt_area   = 0;
                //   $total_settlement_area = $totalAppliedAreaLessaValidation + $totalRoadSideAreaLessaValidation;

                //   // var_dump($total_settlement_area); die;

                //   $prem_s_area = $this->db->query("Select total_lessa from settlement_premium where is_final=1 and case_no='$case_no'")->result();
                //   // echo $this->db->last_query(); die;
                //   foreach ($prem_s_area as $prem_s) {
                //     $prem_settleemt_area=$prem_settleemt_area+$prem_s->total_lessa;
                //   }
                //   // var_dump('total_settlement_area: '.$total_settlement_area); 
                //   // var_dump('prem_settleemt_area: '.$prem_settleemt_area); die;
                //   if ($total_settlement_area != $prem_settleemt_area) 
                //   {
                //     $this->db->trans_rollback();
                //     $this->session->set_flashdata('message', "Error #ERRAM00014: Limited Conversion of Tea Grant Application not submitted Area mismatch case no # $case_no");
                //     redirect(base_url() . "index.php/home");
                //   }
                //   // area check with premium table before update end ******************
                // }
                /// premium insert lm update end
            }

            if($validation_bypass == 1)
            {
                //****validation bypass required insertions  */
                $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                    TEA_SERVICE_CODE,
                    $case_no,
                    $application_no,
                    $lmdata['rejected_list']
                );
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=?", [$case_no])->row()->c;

            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insPetProceed = [
              'case_no'              => $case_no,
              'proceeding_id'        => $proceeding_id,
              'date_of_hearing'      => date('Y-m-d H:i:s'),
              'next_date_of_hearing' => date('Y-m-d H:i:s'),
              'note_on_order'        => $this->input->post('lm_remark_text'),
              'status'               => 'X',
              'user_code'            => $this->session->userdata('user_code'),
              'date_entry'           => date('Y-m-d H:i:s'),
              'operation'            => 'E',
              'ip'                   => $this->utilityclass->get_client_ip(),
              'office_from'          => 'LM',
              'office_to'            => $pending_officer,
              'task'                 => 'LM updated note submitted',
              'note_type'            => $this->input->post('lm_note'),
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
                $rmk    = 'Forwarded to '.$pending_officer;
                $status = 'M';
                $task   = 'LM';
                $pen    = 'CO';
                $case   = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                var_dump($rtps_status);
                if (trim($rtps_status) !="y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP1995: Limited Conversion of Tea Grant Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }

                // $this->DashboardInheritance($case_no['case_no']);
                //////
                $this->session->set_flashdata('message', "Case has been successfully forwarded to CO for case no # $case_no");
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

    $cases['cases']     = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and service_code=? and status=? and from_office=? and pending_officer=? and date_entry >= ?", [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $service_code, 'Z', 'CO', 'LM', $define_date])->result();

    $cases['_view'] = 'TeaGrant/LM/ForwardedByCoTeaGrantLMList';
    $this->load->view('layouts/main', $cases);
  }


  public function lmFirstProceeding($review_flag = false) 
  {
    $this->db=$this->load->database('db2', TRUE);
    $lmdata['district_all'] = $this->db->query("SELECT * FROM district_details")->result();

    $authDb = $this->load->database('auth', TRUE);
    $lmdata['land_class'] = $authDb->query("SELECT * FROM landclass_code_central")->result();

    $this->dbswitch();

    $application_no = $this->input->get('app');

    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid=?", [$application_no])->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
    $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (SELECT max(id) FROM supportive_document WHERE applid=? and dag_no is not null and file_name=? GROUP BY applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

    if($supportive_document_sql->num_rows() > 0)
    {
      $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
    }
    else
    {
      $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
    }

    //********************case registration FROM API start ********* */
    //********************check and insert if case not registered */
    $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
    //********************case registration FROM API end********* */
    //************************************************************************************** */
    ////******* case data fetch FROM db for Lm start */

    $startTime = microtime(true);
    try{
      $lmdata['review_flag'] = false;
      if($review_flag){
        $sql = $this->db->query('SELECT * FROM settlement_basic WHERE applid = ? and review_flag = ?', array($application_no, $review_flag));

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

      //*****LM view auth for this case */
      // $this->utilityclass->lmAuthBasic($case_no);
      $this->utilityclass->lmAuthFirstProceeding($case_no);
      //  row_array
      $basic             = $this->TeaGrantModel->getSettlementBasic($case_no);
      $applicants_buyers = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners = $this->TeaGrantModel->getAllApplicantOwners($case_no);
      $main_applicant    = $this->TeaGrantModel->getMainBuyerApplicant($case_no);

      $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($case_no);
      // echo $this->db->last_query();

      // var_dump($applicants_dag_details); die;

      $dags          = $this->TeaGrantModel->getSettlementDag($case_no);
      $lmnotes       = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
      $proceedings   = $this->TeaGrantModel->getSettlementProceeding($case_no);
      $dhardocuments = $this->TeaGrantModel->getDocuments($case_no);
      $nominee       = $this->TeaGrantModel->getAllNomineeDetail($case_no);
      $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($case_no);
      $deed_applicant= $this->TeaGrantModel->getAllDeedPattadar($case_no);
      $family_tree   = $this->TeaGrantModel->getAllFamilyTree($case_no);



      /// premium
      $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();
      // new premium addition
      // $lmdata['area_category'] = $this->SettlementCommonModel->getPremiumCategory();


      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? and is_final=?",[$case_no, 1])->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end

      $lmdata['basic']                  = $basic;
      $lmdata['geo_date']               = $geo_date;
      $lmdata['applicants_buyers']      = $applicants_buyers;
      $lmdata['applicants_owners']      = $applicants_owners;
      $lmdata['applicants_dag_details'] = $applicants_dag_details;
      $lmdata['main_applicant']         = $main_applicant;

      $lmdata['reservation']            = $this->SettlementVgrModel->getSettlementReservation($case_no);

      $lmdata['dags']                   = $dags;
      $lmdata['lmnotes']                = $lmnotes;
      $lmdata['proceedings']            = $proceedings;
      $lmdata['dhardocuments']          = $dhardocuments;
      $lmdata['nominee']                = $nominee;

      $lmdata['existing_pattadar']      = $existing_pattadar;
      $lmdata['deed_applicant']         = $deed_applicant;
      $lmdata['family_tree']            = $family_tree;

      //for dag not eligible
      $lmdata['dag_count']              = count($dags);

      //for encroacher not eligible
      // $lmdata['dag_count']=count($dags);

      $d=$basic["dist_code"];
      $s=$basic["subdiv_code"];
      $c=$basic["cir_code"];
      $m=$basic["mouza_pargona_code"];
      $l=$basic["lot_no"];
      $v=$basic["vill_townprt_code"];

      //*******getting the deleted settlement_dag_details data FROM settlement_deleted_data table */
      $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
      $deletedEncArray = array();
      foreach($deletedEnc as $encroacherDeleted_data)
      {
          $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
      }
      $lmdata['deleted_encroacher'] = $deletedEncArray;

      //***********getting the settlement_applicant occupiers data FROM settlement_deleted_data table */
      $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
      $deletedData = array();
      foreach($deletedDags as $deleteDag){
          $deletedData[] = json_decode($deleteDag->table_data);
      }
      $lmdata['deleted_dags'] = $deletedData;


      //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree=? ";
      $basundhara = $this->db->query($sql, [$case_no])->row();
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

      // echo "<pre>";
      // var_dump($output); die;

      $lmdata['document'] = $output->documents;
      $lmdata['query']    = $output->query;
      $lmdata['property'] = $output->property;
      $lmdata['aadhar']   = $output->aadhar;
      $lmdata['nextKin']  = $output->nextKin;
      foreach($output->selfDeclaration as $selfDec){
        $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      foreach($lmdata['applicants_buyers'] as $adhar_photo):
        if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
          $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($basundhara->basundhara);
          if($get_aadhaar_photo != 'n'){
            $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
          }
        endif;
      endforeach;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN (?,?)";

      $relation_executation = $this->db->query($query_for_guar_rel, ['5','6']);
      $row = $relation_executation->num_rows();

      if ($row != 0) {
        $lmdata['guar_rel'] = $relation_executation->result();
      }

      // /// vlb data 
      // if(isset($dags)){
      //   foreach($dags as $vlb_dag){
      //     $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($application_no, $vlb_dag->dag_no));

      //     if($sqlvlbcheck->num_rows() > 0){
      //       $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
      //     }
      //     else{
      //       $vlb_newly_added[] = false;
      //     }
      //   }
      //   $lmdata['vlb_newly_added'] = $vlb_newly_added;
      // }


      /// additional property for LM note
      $additional_property = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?",[$application_no]);
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
          //var_dump($lmdata['additional_property']); die;
      }

      $lmdata['case_no'] = $case_no;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
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

    //****getting tribe cat and under tribal belt data FROM backup */
    $getJsonBackup = $this->TeaGrantModel->getJsonDataFromBackup($case_no);

    // if(isset($getJsonBackup))
    // {
    //   if($getJsonBackup)
    //   {
    //     $json_settlement =  json_decode($getJsonBackup->data);

    //     foreach($json_settlement->settlements as $jsonSettle)
    //     {
    //       echo "<pre>";var_dump($jsonSettle); die;
    //       // echo "<pre>"; var_dump($jsonSettle->is_applicant); die;
    //       if($jsonSettle->is_applicant == 1)
    //       {
    //         $lmdata['backup_tribe_category']    = $jsonSettle->tribe_category;
    //         $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
    //       }
    //     }
    //   }
    // }

    //************check if SK is available*/
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

    $lmdata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);

    // $lmdata['prev_land_class_code'] = $this->db->query("SELECT * FROM landclass_code")->result();

    // $lmdata['prev_land_class_code'] = $this->TeaGrantModel->getPrevLandClassUseType($case_no);

    // $params = [
    //   'case_no'          => $case_no,
    //   'service_code'     => TEA_SERVICE_CODE,
    //   'remarks'          => 'Tea Grant',
    //   'accessed_entity'  => 'Aadhaar Name, Photo, Status',
    // ];
    // $this->load->model('EkycLogModel');
    // $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

    $lmdata['basu_appl_no'] = $application_no;
    
    // initial tea grant view through API
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $lmdata['_view'] = 'TeaGrant/LM/TeaGrantLM';
      $this->load->view('layouts/main',$lmdata);
    }
  }


  public function applicationTeaGrantRegistration($review_flag = false) 
  {
    $this->db=$this->load->database('db2', TRUE);
    $lmdata['district_all'] = $this->db->query("SELECT * FROM district_details")->result();

    $this->dbswitch();

    $application_no = $this->input->get('app');

    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid='$application_no'")->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
    $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (SELECT max(id) FROM supportive_document WHERE applid=? and dag_no is not null and file_name=? GROUP BY applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

    if($supportive_document_sql->num_rows() > 0)
    {
      $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
    }
    else
    {
      $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
    }

    //********************case registration FROM API start ********* */
    //********************check and insert if case not registered */
    $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);

    

    $startTime = microtime(true);
    try{
      $lmdata['review_flag'] = false;
      if($review_flag){
        $sql = $this->db->query('SELECT * FROM settlement_basic WHERE applid = ? and review_flag = ?', array($application_no, $review_flag));

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

      //*****LM view auth for this case */
      // $this->utilityclass->lmAuthBasic($case_no);
      $this->utilityclass->lmAuthFirstProceeding($case_no);
      //  row_array
      $basic             = $this->TeaGrantModel->getSettlementBasic($case_no);
      $applicants_buyers = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners = $this->TeaGrantModel->getAllApplicantOwners($case_no);
      $main_applicant    = $this->TeaGrantModel->getMainBuyerApplicant($case_no);

      $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($case_no);
      // echo $this->db->last_query();

      // var_dump($applicants_dag_details); die;

      $dags          = $this->TeaGrantModel->getSettlementDag($case_no);
      $lmnotes       = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
      $proceedings   = $this->TeaGrantModel->getSettlementProceeding($case_no);
      $dhardocuments = $this->TeaGrantModel->getDocuments($case_no);
      $nominee       = $this->TeaGrantModel->getAllNomineeDetail($case_no);
      $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($case_no);
      $deed_applicant= $this->TeaGrantModel->getAllDeedPattadar($case_no);
      $family_tree   = $this->TeaGrantModel->getAllFamilyTree($case_no);

      /// premium
      $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();
      // new premium addition
      // $lmdata['area_category'] = $this->SettlementCommonModel->getPremiumCategory();


      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? and is_final=?", [$case_no, 1])->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end

      $lmdata['basic']                  = $basic;
      $lmdata['geo_date']               = $geo_date;
      $lmdata['applicants_buyers']      = $applicants_buyers;
      $lmdata['applicants_owners']      = $applicants_owners;
      $lmdata['applicants_dag_details'] = $applicants_dag_details;

      $lmdata['reservation']            = $this->SettlementVgrModel->getSettlementReservation($case_no);

      $lmdata['dags']                   = $dags;
      $lmdata['lmnotes']                = $lmnotes;
      $lmdata['proceedings']            = $proceedings;
      $lmdata['dhardocuments']          = $dhardocuments;
      $lmdata['nominee']                = $nominee;
      $lmdata['main_applicant']         = $main_applicant;

      $lmdata['existing_pattadar']      = $existing_pattadar;
      $lmdata['deed_applicant']         = $deed_applicant;
      $lmdata['family_tree']            = $family_tree;

      //for dag not eligible
      $lmdata['dag_count']              = count($dags);

      //for encroacher not eligible
      // $lmdata['dag_count']=count($dags);

      $d=$basic["dist_code"];
      $s=$basic["subdiv_code"];
      $c=$basic["cir_code"];
      $m=$basic["mouza_pargona_code"];
      $l=$basic["lot_no"];
      $v=$basic["vill_townprt_code"];

      //*******getting the deleted settlement_dag_details data FROM settlement_deleted_data table */
      $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
      $deletedEncArray = array();
      foreach($deletedEnc as $encroacherDeleted_data)
      {
          $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
      }
      $lmdata['deleted_encroacher'] = $deletedEncArray;

      //***********getting the settlement_applicant occupiers data FROM settlement_deleted_data table */
      $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
      $deletedData = array();
      foreach($deletedDags as $deleteDag){
          $deletedData[] = json_decode($deleteDag->table_data);
      }
      $lmdata['deleted_dags'] = $deletedData;


      //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree=? ";
      $basundhara = $this->db->query($sql, [$case_no])->row();
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

      $lmdata['document'] = $output->documents;
      $lmdata['query']    = $output->query;
      $lmdata['property'] = $output->property;
      $lmdata['aadhar']   = $output->aadhar;
      $lmdata['nextKin']  = $output->nextKin;
      foreach($output->selfDeclaration as $selfDec){
        $lmdata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      foreach($lmdata['applicants_buyers'] as $adhar_photo):
        if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
          $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($application_no);
          if($get_aadhaar_photo != 'n'){
            $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
          }
        endif;
      endforeach;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN (?,?)";

      $relation_executation = $this->db->query($query_for_guar_rel, ['5','6']);
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
      $additional_property = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?",[$application_no]);
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
          //var_dump($lmdata['additional_property']); die;
      }

      $lmdata['case_no'] = $case_no;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
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

    //****getting tribe cat and under tribal belt data FROM backup */
    $getJsonBackup = $this->TeaGrantModel->getJsonDataFromBackup($case_no);

    // if(isset($getJsonBackup))
    // {
    //   if($getJsonBackup)
    //   {
    //     $json_settlement =  json_decode($getJsonBackup->data);

    //     foreach($json_settlement->settlements as $jsonSettle)
    //     {
    //       echo "<pre>";var_dump($jsonSettle); die;
    //       // echo "<pre>"; var_dump($jsonSettle->is_applicant); die;
    //       if($jsonSettle->is_applicant == 1)
    //       {
    //         $lmdata['backup_tribe_category']    = $jsonSettle->tribe_category;
    //         $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
    //       }
    //     }
    //   }
    // }

    //************check if SK is available*/
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

    $lmdata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);

    // echo "<pre>";
    // var_dump($lmdata); die;

    $authDb = $this->load->database('auth', TRUE);
    $lmdata['land_class'] = $authDb->query("SELECT * FROM landclass_code_central")->result();

    $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid=? order by id desc",[$case_no])->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    $lmdata['geo_date'] = $geo_date;

    $lmdata['case_no'] = $basic['case_no'];


    // initial tea grant view through API
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $lmdata['_view'] = 'TeaGrant/LM/TeaGrantLM';
      $this->load->view('layouts/main',$lmdata);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {      
      $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid=? order by id desc",[$case_no])->row();
      $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

      // var_dump($lmdata['applicants_buyers']);
      // die;


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

      

      // if($mStat == true)
      // {
      //   foreach($lmdata['applicants_buyers'] as $applicantRow)
      //   {
      //     if($applicantRow->is_applicant != 1)
      //     {
      //       if(!in_array($applicantRow->pdar_rel_guar, ['3','4']) )
      //       {
      //         $mStatErr = true;   
      //         break;
      //       }
      //     }
      //   }
      // }
      
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
      // if($mStatErr == true)
      // {
      //   $data = array(
      //     'error' => '#ERR14233: Spouse details has to be added if you SELECT applicant as married!!!' .$case_no,
      //   );
      //   echo json_encode($data);
      //   return false;
      // }

      //  row_array
      $basic              = $this->TeaGrantModel->getSettlementBasic($case_no);
      //  result
      $applicants_buyers  = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners  = $this->TeaGrantModel->getAllApplicantOwners($case_no);
      $main_applicant     = $this->TeaGrantModel->getMainBuyerApplicant($case_no);

      $dags               = $this->TeaGrantModel->getSettlementDag($case_no);
      $lmnotes            = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
      $proceedings        = $this->TeaGrantModel->getSettlementProceeding($case_no);
      $dhardocuments      = $this->TeaGrantModel->getDocuments($case_no);

      $d = $basic["dist_code"];
      $s = $basic["subdiv_code"];
      $c = $basic["cir_code"];
      $m = $basic["mouza_pargona_code"];
      $l = $basic["lot_no"];
      $v = $basic["vill_townprt_code"];

      /// premium
      $lmdata['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
      $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();

      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? and is_final=?",[$case_no,1])->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end

      $lmdata['basic']             = $basic;
      $lmdata['geo_date']          = $geo_date;
      $lmdata['applicants_buyers'] = $applicants_buyers;
      $lmdata['applicants_owners'] = $applicants_owners;
      $lmdata['main_applicant']    = $main_applicant;

      $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);

      // var_dump($lmdata['reservation']); die;

      $lmdata['dags']             = $dags;
      $lmdata['lmnotes']          = $lmnotes;
      $lmdata['proceedings']      = $proceedings;
      $lmdata['dhardocuments']    = $dhardocuments;  

      // var_dump($lmdata['proceedings']); die;      

        //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree=? ";
      $basundhara = $this->db->query($sql,[$case_no])->row();

      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $basundhara->basundhara,
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

      $output = json_decode($output);
      // echo "<pre>";var_dump($output); die;

      $lmdata['document'] = $output->documents;
      $lmdata['query']    = $output->query;
      $lmdata['property'] = $output->property;
      $lmdata['aadhar']   = $output->aadhar;
      $lmdata['nextKin']  = $output->nextKin;
      foreach($output->selfDeclaration as $selfDec){
        $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
      }

      foreach($lmdata['applicants_buyers'] as $adhar_photo):
        if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
          $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($application_no);
          if($get_aadhaar_photo != 'n'){
            $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
          }
        endif;
      endforeach;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN (?,?)";

      $relation_executation = $this->db->query($query_for_guar_rel,['5','6']);
      $row = $relation_executation->num_rows();
      if ($row != 0) {
        $lmdata['guar_rel'] = $relation_executation->result();
      }

      // var_dump($dags); die;

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

      // For insertion of Limited Conversion of Tea Grant khasland 
      $distCode = trim($this->input->post('dist_code'));
      if ($distCode == null) {
        redirect(base_url(). 'index.php/basundhara2/settlementCases');
      }
      if ($application_no == null) {
        redirect(base_url(). 'index.php/basundhara2/settlementCases');
      }
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

      //********validation bypass */
      $validation_bypass = 0;
      // $validation_bypass_array = array();

      // var_dump($_POST['lm_note']); die;

      if($_POST['lm_note'] == '2')
      {
          if(isset($_POST['rejected_reasons']))
          {

              $validation_bypass_array = $this->getValidationBypass(TEA_SERVICE_CODE);
              // var_dump($validation_bypass_array); die;

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

        $get_tag_dag_count = $this->db->query("SELECT count(t.applid) FROM (SELECT distinct on (applid, dag_no) applid, dag_no FROM supportive_document WHERE applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

        $total_dag_count = count($lmdata['dags']);

        // var_dump($get_tag_dag_count); die;

        if((int)$get_tag_dag_count != (int)$total_dag_count)
        {
          if(GEO_TAG_ACTIVE_STATUS == 1)
          {
            $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
          }
        }

        // echo "<br>"; var_dump($output); die;

        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case No', 'trim|required|min_length[2]');
        // $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
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
        // $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
        $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

        $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('bonafide_transferee', 'Bonafied Transferee', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
        // $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');

        if(trim($this->input->post('is_tribal_belt') == 'YES')){
          $this->form_validation->set_rules('tribal_belt_name', 'Tribal Belt Name', 'trim|required');
          $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
        }
        if(trim($this->input->post('is_tribal_belt') == 'NO')){
          $this->form_validation->set_rules('contravention', 'Contravention', 'trim|required');
        }


        $this->form_validation->set_rules('possession_verification', 'Possession Verified', 'trim|required');

        $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
        $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
        $this->form_validation->set_rules('land_falls_periphery', '10 no point', 'trim|required');
        $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
        $this->form_validation->set_rules('dispute_possession', 'Dispute regarding possession', 'trim|required');
        $this->form_validation->set_rules('lm_possession_entry', 'Possession Since', 'trim|required');

        $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
        // $this->form_validation->set_rules('land_exceed', 'Point No 20', 'trim|required');      

        $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');

        $this->form_validation->set_rules('roadside_reservation','','');

        $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
        $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');

        // var_dump($this->input->post('bonafide_transferee'));

        if($this->input->post('bonafide_transferee') == 'YES')
        {
          if(empty($_FILES['dalil_upload']['name']))
          {
            $this->form_validation->set_rules('dalil_upload','Dalil File','required');
          }
        }

        // if(empty($_FILES['legal_heir_doc']['name']))
        // {
        //   $this->form_validation->set_rules('legal_heir_doc','Legal Heir`s File','required');
        // }
  
        if($this->input->post('dispute_possession') == 'YES')
        {
          $this->form_validation->set_rules('dis_cat_type', 'Category Type', 'trim|required');
        }

        $roadside_comment_check = $this->input->post('roadside_comment_check');
        $family_comment_check   = $this->input->post('family_comment_check');

        $totalDagAreaLessaValidation      = 0;
        $totalAppliedAreaLessaValidation  = 0;
        $appAreaMoreThanDagA              = 0;
        $reserveMoreThanAppArea           = 0;
        $familyMoreThanAppArea            = 0;
        $totalRoadSideAreaLessaValidation = 0;
        $totalFamilyAreaLessaValidation   = 0;      

        foreach ($lmdata['dags'] as $dag_area_cal) {

          //******NCBTAD check  */
          $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($dag_area_cal->dist_code, $dag_area_cal->subdiv_code, $dag_area_cal->cir_code, $dag_area_cal->mouza_pargona_code, $dag_area_cal->lot_no, $dag_area_cal->vill_townprt_code, $dag_area_cal->dag_no);

        // var_dump($ncBtadCheck); die;       


          if($ncBtadCheck > 0)
          {
            //*******throw error for NCBTAD */
            log_message('error', '#ERR3938: This village is mapped as NCBTAD! '.$case_no);
            $this->session->set_flashdata('message', "#ERR3938: This village is mapped as NCBTAD! ".$case_no);
            redirect(base_url() . "index.php/home");
          }

          $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');
          // new premium addition
          // $this->form_validation->set_rules('area'.$dag_area_cal->dag_no, 'SELECT Area Type', 'trim|required');
          // $this->form_validation->set_rules('area_new'.$dag_area_cal->dag_no, 'SELECT Area Type', 'trim|required');

          foreach($lmdata['dags'] as $land_class_valid)
          {
            $this->form_validation->set_rules('land_class'.$land_class_valid->dag_no, ' Present Land use type', 'trim|required');
          }

          // for barak valley
          if (in_array($distCode, json_decode(BARAK_VALLEY))) 
          {
            if(empty($_FILES['trace_map_copy'.$dag_area_cal->dag_no]['name']))
            {
              $this->form_validation->set_rules('trace_map_copy'.$dag_area_cal->dag_no, 'Trace map document', 'required');
            }

            $this->form_validation->set_rules('landmark_east'.$dag_area_cal->dag_no, 'East Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_west'.$dag_area_cal->dag_no, 'West Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_north'.$dag_area_cal->dag_no, 'North Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_south'.$dag_area_cal->dag_no, 'South Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zonal_valuation_prem'.$dag_area_cal->dag_no, 'Zonal Value', 'trim|required|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);
            $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dag_area_cal->dag_no), 0);

            $appliedBighaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_b'.$dag_area_cal->dag_no), 0);
            $appliedKathaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_k'.$dag_area_cal->dag_no), 0);
            $appliedLessaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_lc'.$dag_area_cal->dag_no), 0);
            $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_home_g'.$dag_area_cal->dag_no), 0);

            $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
            $appliedAreaLessaValidation = ($appliedBighaValidation * 6400) + ($appliedKathaValidation * 320) + ($appliedLessaValidation * 20) + $gandaValidationHome;

            if ($dagAreaLessaValidation < $appliedAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
            }

            $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
            $totalAppliedAreaLessaValidation += $appliedAreaLessaValidation;

            if ($roadside_comment_check=='YES') {
              $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
              $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
              $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
              $this->form_validation->set_rules('reserved_ganda'.$dag_area_cal->dag_no, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
              $this->form_validation->set_rules('reserved_kranti'.$dag_area_cal->dag_no, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

              $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
              $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
              $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);
              $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dag_area_cal->dag_no), 0);

              $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

              if ($agrAreaLessaValidation + $appliedAreaLessaValidation < $roadSideAreaLessaValidation) {
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

              $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
              $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
              $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);
              $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$dag_area_cal->dag_no), 0);

              $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
              if ($agrAreaLessaValidation + $appliedAreaLessaValidation < $familyAreaLessaValidation) {
                  $familyMoreThanAppArea = 1;
              }

              $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
            }

            // new premium addition
            if(!empty($this->input->post('area_new'.$dag_area_cal->dag_no))){
              $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$dag_area_cal->dag_no));
              if(!empty($maxland_check->max_land)){

                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalAppliedAreaLessaValidation)) {
                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                // }
                if($maxland_check->max_land =='40'){
                  $maxland_ganda = 2560;
                }elseif($maxland_check->max_land =='60'){
                  $maxland_ganda = 3840;
                }

                if ($maxland_ganda < ($totalAgrAreaLessaValidation + $totalAppliedAreaLessaValidation) -  $totalRoadSideAreaLessaValidation) 
                {
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

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dag_area_cal->dag_no), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dag_area_cal->dag_no), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dag_area_cal->dag_no), 0);

            $appliedBighaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_b'.$dag_area_cal->dag_no), 0);
            $appliedKathaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_k'.$dag_area_cal->dag_no), 0);
            $appliedLessaValidation = $this->UtilsModel->defaultValue($this->input->post('enc_home_lc'.$dag_area_cal->dag_no), 0);

            $dagAreaLessaValidation     = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
            $appliedAreaLessaValidation = ($appliedBighaValidation * 100) + ($appliedKathaValidation * 20) + $appliedLessaValidation;

            if ($dagAreaLessaValidation < $appliedAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
            }

            $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
            $totalAppliedAreaLessaValidation += $appliedAreaLessaValidation;

            if ($roadside_comment_check=='YES') 
            {
              $this->form_validation->set_rules('reserved_dag_road'.$dag_area_cal->dag_no, 'Reserved Dag', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_patta_road'.$dag_area_cal->dag_no, 'Reserved Patta ', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_bigha'.$dag_area_cal->dag_no, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
              $this->form_validation->set_rules('reserved_katha'.$dag_area_cal->dag_no, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
              $this->form_validation->set_rules('reserved_lessa'.$dag_area_cal->dag_no, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

              $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dag_area_cal->dag_no), 0);
              $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dag_area_cal->dag_no), 0);
              $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dag_area_cal->dag_no), 0);

              $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

              if ($agrAreaLessaValidation + $appliedAreaLessaValidation < $roadSideAreaLessaValidation) {
                $reserveMoreThanAppArea = 1;
              }

              $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
            }

            // echo "<pre>"; var_dump($_POST); die;                    

            if ($family_comment_check=='YES') 
            {
              $this->form_validation->set_rules('reserved_dag_family'.$dag_area_cal->dag_no, 'Reserved Family Dag', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_patta_family'.$dag_area_cal->dag_no, 'Reserved Family Patta ', 'trim|required|is_natural');
              $this->form_validation->set_rules('reserved_bigha_family'.$dag_area_cal->dag_no, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
              $this->form_validation->set_rules('reserved_katha_family'.$dag_area_cal->dag_no, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
              $this->form_validation->set_rules('reserved_lessa_family'.$dag_area_cal->dag_no, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

              $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dag_area_cal->dag_no), 0);
              $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dag_area_cal->dag_no), 0);
              $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dag_area_cal->dag_no), 0);

              $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

              if ($agrAreaLessaValidation + $appliedAreaLessaValidation < $familyAreaLessaValidation) {
                  $familyMoreThanAppArea = 1;
              }

              $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
            }
          }
        }

        // new additional property calculation
        $singleAdditionalProToLessa = 0;
        $totalAdditionalProToLessa  = 0;
        $additional_properties      = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?",[$application_no])->result();

        // var_dump($additional_properties); die;

        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
          foreach ($additional_properties as $singleProperty)
          {
            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha,0);
            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha,0);
            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa,0);
            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda,0);

            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
          }
        }
        else
        {
          foreach ($additional_properties as $singleProperty)
          {
            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha,0);
            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha,0);
            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa,0);

            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
          }
        }

        if($this->input->post('landslide') == 'YES')
        {
          $checkUrbanCon = 'Y';
        }
        else
        {
          $checkUrbanCon = trim($this->input->post('is_urban'));
        }

        // $checkUrbanCon = trim($this->input->post('is_urban'));

        if ($reserveMoreThanAppArea == 1) {
          $this->form_validation->set_rules('reserveMoreThanAppArea','Total roadside reserved area should not be more than total applied area !', 'required|callback_reserveMoreThanAppArea');
        }

        if ($familyMoreThanAppArea == 1) {
          $this->form_validation->set_rules('familyMoreThanAppArea','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanAppArea');
        }

        if ($totalAppliedAreaLessaValidation == 0) {
          $this->form_validation->set_rules('totalAppliedAreaZeroCheck','Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
        }

        // var_dump($appAreaMoreThanDagA); die;
        if ($appAreaMoreThanDagA == 1) 
        {
          $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
        }

        $land_exceed = 0;

        // echo "<pre>"; var_dump($_POST); die;

        if($_POST['lm_note'] == '1' && $land_exceed == 1)
        {
            $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (TEA_GRANT_MAX_HOMESTEAD + TEA_GRANT_MAX_AGRI) . ' Bigha ! You can SELECT not recommend and proceed!!!', 'required|callback_land_exceed');
        }

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
                    $this->form_validation->set_rules('additional_doc_err','File additional doc','required');
                }
            }
        }
      }

      // var_dump($validation_bypass); die;

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
        // $this->form_validation->set_rules('co_code', 'SELECT SK/Circle Officer', 'trim|required');

        $this->form_validation->set_rules('co_code_reject', 'SELECT Circle Officer', 'trim|required');          
      }

      // echo "<pre>"; var_dump($lmdata['err_return']); die;

      $this->form_validation->set_rules('lm_possession_entry', 'Possession Since', 'trim|required');

      if ($this->form_validation->run() == false)
      {
        $lmdata['all_errors'] = validation_errors();
        if(isset($fileCount)){
          $lmdata['fileCount'] = $fileCount;
        }
        $lmdata['err_return'] = true;
        $lmdata['_view'] = 'TeaGrant/LM/TeaGrantLM';
        $this->load->view('layouts/main',$lmdata);
      }
      else
      {
        $this->db->trans_begin();

        //new premium condition

        foreach ($lmdata['dags'] as $dag_for_approve) {
          $dag_arraay[]   = $this->input->post('approval'.$dag_for_approve->dag_no);
          $dag_by_approve = $this->input->post('approval'.$dag_for_approve->dag_no);
        }
        $approved_by =null;
        if ($dag_by_approve !='' || $dag_by_approve !=null )
        {
          if(count($dag_arraay)==1){
            $approved_by =$dag_by_approve;
          }
          else
          {
            if(count(array_unique($dag_arraay))<count($dag_arraay)) {
              $approved_by =$dag_by_approve;
            }
            else {
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


        // update settlement_dag_details for is_urban_rural
        $isUrbanUpdate = [
          'is_urban'    => $checkUrbanCon,
          'date_update' => date('Y-m-d G:i:s'),
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_dag_details', $isUrbanUpdate);

        $basicData = [
          'status'          => 'W',
          'lm_code'         => $this->session->userdata('user_code'),
          'submission_date' => date('Y-m-d G:i:s'),
          'from_office'     => 'LM',
          'pending_officer' => $pending_officer,
          'pending_office'  => $pending_officer,
          'sk_code'         => $sk_code,
          'co_code'         => $co_code,
          'approve_by'      => $approved_by,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicData);

        // echo $this->db->last_query(); die;

        if($this->db->affected_rows() <= 0)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
          $data = array(
            'error'=>"#ERROR0011: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
        }

        //update additional property
        $additional_property_check = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?",[$application_no]);

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
                'error'=>"#ERROR1836: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
          }
        }

        // insertion in backup table
        $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = ? AND from_office = ?",[$application_no, 'LM'])->row()->ct;
        $phase_count = (int)$phase_count+1;
        $backup_array_lm = [
          'applid'      => $application_no,
          'case_no'     => $case_no,
          'from_office' => 'LM',
          'to_office'   => $pending_officer,
          'status'      => 'W',
          'phase'       => 'LM_'.$phase_count,
          'data'        => json_encode($_POST)
        ];

        $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
        if($backup_insertion_lm != 1){
          $this->db->trans_rollback();
          log_message('error', '#BACKUP002: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

          $this->session->set_flashdata('message', "#BACKUP002: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no);
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
                'error'=>"#SETUP0001S: Registration of Limited Conversion of Tea Grant failed for case no : ".$geo_tag_loop->applid
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
              'east'  => $landmark_east,
              'west'  => $landmark_west,
              'north' => $landmark_north,
              'south' => $landmark_south,
            ];

            $fmddata= [
              'date_entry'        => date('Y-m-d'),
              'landmark'          => json_encode($landmark),
              'nature_possession' => $this->input->post('nature_possession'.$dagsland->dag_no),
              'lra_tea_land_class'=> $this->input->post('land_class'),
            ];
            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $dagsland->dag_no);
            $this->db->update('settlement_dag_details', $fmddata);

            // echo $this->db->last_query(); die;
            if($this->db->affected_rows() <= 0)
            {
              $this->db->trans_rollback();
              log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$application_no);
              $data = array(
                'error'=>"#ERROR0012: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }
          }

          // echo "<pre>"; var_dump($_FILES); die;

          // upload additional file
          if(isset($_FILES['fileUpload']['name'])){
            for($i = 0; $i < $fileCount; $i++)
            {
              $_FILES['file']['name']     = $_FILES['fileUpload']['name'][$i];
              $_FILES['file']['type']     = $_FILES['fileUpload']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
              $_FILES['file']['error']    = $_FILES['fileUpload']['error'][$i];
              $_FILES['file']['size']     = $_FILES['fileUpload']['size'][$i];

              $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
              $exp  = explode("/",$mime);
              $onlyExtension  = $exp[1];

              $fileRename =  $this->UUID4() . '.' . $onlyExtension;

              $config['upload_path']   = UPLOAD_DIR_TEA;
              $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
              $config['max_size']      = UPLOAD_MAX_SIZE;;
              $config['file_name']     = $fileRename;
              $this->load->library('upload', $config);
              $this->upload->initialize($config);
              if ($this->upload->do_upload('file'))
              {
                $document= array(
                  'case_no'         => $case_no,
                  'file_name'       => $_POST['fileText'][$i],
                  'user_code'       => $this->session->userdata('user_code'),
                  'fetch_file_name' => $_POST['fileText'][$i],
                  'file_type'       => $_FILES['file']['type'],
                  'file_path'       => trim(UPLOAD_DIR_TEA . $fileRename),
                  'date_entry'      => date('Y-m-d H:i:s'),
                  'mut_type'        => TEA_SERVICE_CODE,
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

          // $field_report_file = $_FILES['field_report'];

          // var_dump($field_report_file); die;

          // For uploading dag wise trace_map_copy
          foreach ($lmdata['dags'] as $dags_doc)
          {
            $timestamp = date('mdYhis', time()).uniqid();

            $trace_map_file = $_FILES['trace_map_copy'.$dags_doc->dag_no];
            $trace_file_name = 'trace_map_copy'.$timestamp;

            //upload trace map file by calling API
            $trace_map_api_file = $this->SettlementCommonModel->uploadFileByApiBase($trace_map_file, $application_no, API_KEY, $trace_file_name);

            $trace_json = json_decode($trace_map_api_file);
            

            $mime = $trace_map_file['name'];
            $exp  = explode(".",$mime);
            $onlyExtension  = $exp[1];

            $trace_upload_path = UPLOAD_DIR_TEA.$timestamp.'trace.'.$onlyExtension;

            // var_dump($trace_json->status); die;

            if($trace_json->status == 4) // success
            {
              $document= array(
                'case_no'         => $case_no,
                'file_name'       => 'Trace Map Copy',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => $trace_map_file['name'],
                'file_type'       => $trace_map_file['type'],
                'file_path'       => $trace_upload_path,
                'date_entry'      => date('Y-m-d H:i:s'),
                'mut_type'        => $this->input->post('service_code'),
                'dag_no'          => $this->input->post('dag_no_doc'.$dags_doc->dag_no),
                'api_doc_id'      => $trace_json->docId,
              );
              $insert_supportive_doc= $this->db->insert('supportive_document', $document);

              // echo $this->db->last_query(); die;

              if ($insert_supportive_doc != 1) {
                log_message('error', '#ERRORPPSSGG2224: Insertion failed in supportive_document for case no :'. $this->db->last_query());
                $this->db->trans_rollback();

                $json = [
                  'errorMessage'=>"#ERRORPPSSGG2224: Failed to forward the case for Case No : ".$case_no
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
                $config['upload_path']   = UPLOAD_DIR_TEA;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']      = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if(!move_uploaded_file($trace_map_file['tmp_name'], $trace_upload_path)){
                    log_message('error', 'Unable to move trace map file for case no '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERROR6844: Only PDF and Image files area allowed : ".$application_no);
                    redirect(base_url() . "index.php/home");
                }
            }
          }

          $timestamp = date('mdYhis', time()).uniqid();
          // For uploading field report                   

          //upload field report file by calling API
          // $field_file_name = 'field_report'.$timestamp;


          // $field_report_api_file = $this->SettlementCommonModel->uploadFileByApiBase($field_report_file, $application_no, API_KEY, $field_file_name);

          // $field_report_json = json_decode($field_report_api_file);
          // $field_report_path = UPLOAD_DIR_TEA.$timestamp.$field_report_file['name'];

          // if($field_report_json->status == 4) // success 
          // {
          //   $document= array(
          //     'case_no'         => $case_no,
          //     'file_name'       => 'Field Report',
          //     'user_code'       => $this->session->userdata('user_code'),
          //     'fetch_file_name' => $field_report_file['name'],
          //     'file_type'       => $field_report_file['type'],
          //     'file_path'       => $field_report_path,
          //     'date_entry'      => date('Y-m-d H:i:s'),
          //     'mut_type'        => $this->input->post('service_code'),
          //     'api_doc_id'      => $field_report_json->docId,
          //   );

          //   $insert_supportive_doc= $this->db->insert('supportive_document', $document);

          //   if ($insert_supportive_doc != 1) {
          //     $this->db->trans_rollback();
          //     log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
          //     $json = [
          //       'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
          //     ];
          //     echo json_encode($json);
          //     return false;
          //   }
          // }
          // else {
          //   log_message('error', 'Unable to upload field report file for case no '.$case_no);
          //   $this->db->trans_rollback();
          //   $this->session->set_flashdata('message', "#ERROR6893: Only PDF and Image files area allowed : ".$application_no);
          //   redirect(base_url() . "index.php/home");
          // }


          // if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
          // {
          //   $config2['file_name']     = $field_file_name;
          //   $config2['upload_path']   = UPLOAD_DIR_TEA;
          //   $config2['allowed_types'] = UPLOAD_ALLOW_TYPE;
          //   $config2['max_size']      = 2000;

          //   $this->load->library('upload', $config2);
          //   $this->upload->initialize($config2);

          //   if(!move_uploaded_file($field_report_file['tmp_name'], $field_report_path))
          //   {
          //     log_message('error', 'Unable to move field report file for case no '.$case_no);
          //     $this->db->trans_rollback();
          //     $this->session->set_flashdata('message', "#ERROR6914: Only PDF and Image files area allowed : ".$application_no);
          //     redirect(base_url() . "index.php/home");
          //   }
          // }

          //*********if LM if case of case rejected the rejected remarks */

          $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(TEA_SERVICE_CODE);

          // var_dump($responseMasterObj); die;

          $comment = addslashes($this->input->post('lm_note'));

          $pro_class_lm = $this->input->post('protected_class_lm');
          $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

          // chitha_verified  bonafide_transferee   bhumiputra_confirmation_lm
          // is_tribal_belt   protected_class_lm    possession_verification
          // $nature_entry_single   is_landless   land_class  landslide
          // land_falls_periphery   dispute_possession  lm_possession_entry
          // land_exceed  lra_deed_no

          // upload dalil
          if($this->input->post('bonafide_transferee') == 'YES')
          {
            $timestamp = date('mdYhis', time()).uniqid();
            $dalil_file = $_FILES['dalil_upload'];
            $dalil_name = 'dalil_upload'.$timestamp;

            if(empty($_FILES['dalil_upload']['name']))
            {
              log_message('error', "#ERROR4723: bonafied selected as yes but dalil not uploaded for case no $case_no");
              $this->db->trans_rollback();
              $json = [
                'errorMessage'=>"#ERROR4723: Upload of dalil is required as point no 2 is selected as YES for the case for Case No : ".$case_no
              ];
              echo json_encode($json);
              return false;
            }

            //upload trace map file by calling API
            $dalil_api_file = $this->SettlementCommonModel->uploadFileByApiBase($dalil_file, $application_no, API_KEY, $dalil_name);

            $dalil_json = json_decode($dalil_api_file);
            // $dalil_upload_path = trim(UPLOAD_DIR_TEA.$timestamp.$dalil_file['name']);

            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".UPLOAD_DIR_TEA);
            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($dalil_upload_path));
            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($dalil_json));


            $mime = $dalil_file['name'];
            $exp  = explode(".",$mime);
            $onlyExtension  = $exp[1];

            $dalil_upload_path = UPLOAD_DIR_TEA.$timestamp.'dalil.'.$onlyExtension;

            if($dalil_json->status == 4) // success
            {
              $documentDalil = array(
                'case_no'         => $case_no,
                'file_name'       => 'Dalil',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => $dalil_file['name'],
                'file_type'       => $dalil_file['type'],
                'file_path'       => $dalil_upload_path,
                'date_entry'      => date('Y-m-d H:i:s'),
                'mut_type'        => TEA_SERVICE_CODE,
                'api_doc_id'      => $dalil_json->docId,
              );
              $insert_dalil_doc = $this->db->insert('supportive_document', $documentDalil);
              // log_message('error', '#TEA_UPLOAD============for case no : '. $this->db->last_query());

              if ($insert_dalil_doc != 1) {
                log_message('error', '#ERROR4747: Insertion failed in supportive_document for case no :'. $this->db->last_query());
                $this->db->trans_rollback();

                $json = [
                  'errorMessage'=>"#ERROR4747: Failed to forward the case for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
              }
            }
            else {
              log_message('error', 'Unable to upload Dalil file for case no '.$case_no);
              $this->db->trans_rollback();
              $this->session->set_flashdata('message', "#ERROR4760: Only PDF and Image files are allowed : ".$application_no);
              redirect(base_url() . "index.php/home");
            }

            if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
            {
              // Dalil copy upload
              $config['file_name']     = $dalil_name;
              $config['upload_path']   = UPLOAD_DIR_TEA;
              $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
              $config['max_size']      = 2000;

              $this->load->library('upload', $config);
              $this->upload->initialize($config);

              if(!move_uploaded_file($dalil_file['tmp_name'], $dalil_upload_path)){
                log_message('error', 'Unable to move Dalil file for case no '.$case_no);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERROR4778: Only PDF and Image files are allowed : ".$application_no);
                redirect(base_url() . "index.php/home");
              }
            }
          }

          // upload legal heirs copy                
          $timestamp = date('mdYhis', time()).uniqid();
          $legal_heir_doc_file = $_FILES['legal_heir_doc'];

          // if(!empty($_FILES['legal_heir_doc']['name']))
          // {
          //   echo "I am not empty";
          // }
          // else
          // {
          //   echo "I am empty";
          // }
          // var_dump('File Name: '.$_FILES['legal_heir_doc']['name']); die;


          if(!empty($_FILES['legal_heir_doc']['name']))
          {
            $legal_heir_doc_name = 'legal_heir_doc_upload'.$timestamp;

            //upload trace map file by calling API
            $legal_heir_doc_api_file = $this->SettlementCommonModel->uploadFileByApiBase($legal_heir_doc_file, $application_no, API_KEY, $legal_heir_doc_name);

            $legal_heir_doc_json = json_decode($legal_heir_doc_api_file);

            $mime = $legal_heir_doc_file['name'];
            $exp  = explode(".",$mime);
            $onlyExtension  = $exp[1];

            $legal_heir_doc_upload_path = UPLOAD_DIR_TEA.$timestamp.'legal.'.$onlyExtension;

            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".UPLOAD_DIR_TEA);
            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($legal_heir_doc_upload_path));
            // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".json_encode($legal_heir_doc_json));

            if($legal_heir_doc_json->status == 4) // success
            {
              $documentlegal_heir_doc = array(
                'case_no'         => $case_no,
                'file_name'       => 'legal_heir_doc',
                'user_code'       => $this->session->userdata('user_code'),
                'fetch_file_name' => $legal_heir_doc_file['name'],
                'file_type'       => $legal_heir_doc_file['type'],
                'file_path'       => $legal_heir_doc_upload_path,
                'date_entry'      => date('Y-m-d H:i:s'),
                'mut_type'        => TEA_SERVICE_CODE,
                'api_doc_id'      => $legal_heir_doc_json->docId,
              );
              $insert_legal_heir_doc = $this->db->insert('supportive_document', $documentlegal_heir_doc);
              // log_message("error", "TEA_UPLOAD=========== for case no $case_no : ".$this->db->last_query());

              if ($insert_legal_heir_doc != 1) {
                log_message('error', '#ERROR4845: Insertion failed in supportive_document for case no :'. $this->db->last_query());
                $this->db->trans_rollback();

                $json = [
                  'errorMessage'=>"#ERROR4845: Failed to forward the case for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
              }
            }
            else {
              log_message('error', 'Unable to upload Dalil file for case no '.$case_no);
              $this->db->trans_rollback();
              $this->session->set_flashdata('message', "#ERROR4854: Only PDF and Image files area allowed : ".$application_no);
              redirect(base_url() . "index.php/home");
            }

            if(FILE_UPLOAD_REQUIRE_IN_DHARITREE == 1)  //
            {
              // Legal heir copy upload
              $config['file_name']     = $legal_heir_doc_name;
              $config['upload_path']   = UPLOAD_DIR_TEA;
              $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
              $config['max_size']      = 2000;

              $this->load->library('upload', $config);
              $this->upload->initialize($config);

              if(!move_uploaded_file($legal_heir_doc_file['tmp_name'], $legal_heir_doc_upload_path))
              {
                log_message('error', 'Unable to move Legal Heir file for case no '.$case_no);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERROR4873: Only PDF and Image files area allowed : ".$application_no);
                redirect(base_url() . "index.php/home");
              }
            }
          }


                            

          $dis_cat_type = null;
          if($this->input->post('dispute_possession') == 'YES')
          {
            $dis_cat_type = $this->input->post('dis_cat_type');
          }

          // die;


          foreach ($lmdata['dags'] as $land_classes) {
            $land_class_arr[] = [
              'dag_no'               => $land_classes->dag_no,
              'prev_land_class_name' => $this->input->post('prev_land_class_name'.$land_classes->dag_no),
              'prev_land_class_code' => $this->input->post('prev_land_class_code'.$land_classes->dag_no),
              'land_class'           => $this->input->post('land_class'.$land_classes->dag_no),
            ];
          }

          $land_class = $land_class_arr;

          $lra_report_new = [
            'chitha_verified'            => $this->input->post('chitha_verified'),
            'bonafide_transferee'        => $this->input->post('bonafide_transferee'),
            'bhumiputra_confirmation_lm' => $this->input->post('bhumiputra_confirmation_lm'),
            'is_tribal_belt'             => $this->input->post('is_tribal_belt'),
            'protected_class_lm'         => !empty($this->input->post('protected_class_lm')) ? $this->input->post('protected_class_lm') : null,
            'possession_verification'    => $this->input->post('possession_verification'),
            'is_landless'                => $this->input->post('is_landless'),
            'land_class'                 => $land_class,
            'landslide'                  => $this->input->post('landslide'),
            'land_falls_periphery'       => $this->input->post('land_falls_periphery'),
            'dispute_possession'         => $this->input->post('dispute_possession'),
            'lm_possession_entry'        => date('Y-m-d', strtotime($this->input->post('lm_possession_entry'))),
            'lra_deed_no'                => $this->input->post('lra_deed_no'),
            'dis_cat_type'               => $dis_cat_type,  
            'lra_possession_remark'      => $this->input->post('lra_possession_remark'),             
            'lra_deed_date'              => $this->input->post('lra_deed_date'),             
            'contravention'              => !empty($this->input->post('contravention')) ? $this->input->post('contravention') : null,
            'tribal_belt_name' => !empty($this->input->post('tribal_belt_name')) ? $this->input->post('tribal_belt_name') : null,             
          ];

          // <!-- is_tribal_belt   protected_class_lm    contravention    tribal_belt_name  -->

          $lmnote=array(
            'user_code'               => $this->session->userdata('user_code'),
            'chitha_verified'         => $this->input->post('chitha_verified'),
            'is_tribal_belt'          => $this->input->post('is_tribal_belt'),
            'possession_verification' => $this->input->post('possession_verification'),
            'period_possession'       => date('Y-m-d', strtotime($this->input->post('lm_possession_entry'))),
            'is_landless'             => $this->input->post('is_landless'),
            'land_falls'              => $this->input->post('land_falls'),
            'falls_und_gmc'           => $this->input->post('falls_und_gmc'),
            'roadside_reservation'    => $this->input->post('roadside_reservation'),
            'zonal_valuation'         => $this->input->post('zonal_valuation'),
            'trace_map_copy'          => 'NA',
            'chitha_copy'             => 'NA',
            'lm_note'                 => $comment,
            'lm_remark_text'          => $this->input->post('lm_remark_text'),
            'date_entry'              => date('Y-m-d H:i:s'),
            'case_no'                 => $case_no,
            'status'                  => 'W',
            'total_bigha'             => 0,
            'total_Katha'             => 0,
            'total_lessa'             => 0,
            'total_ganda'             => 0,
            'total_kranti'            => 0,
            'landslide'               => $this->input->post('landslide'),
            'protected_class_lm'      => $protected_class_lm,
            'bhumiputra_confirmation' => $this->input->post('bhumiputra_confirmation_lm'),
            'lm_rejected_remarks'     => json_encode($responseMasterObj->reject_remarks),
            'lm_tea_report'           => json_encode($lra_report_new),
          );

          $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
          // echo $this->db->last_query(); die;
          if ($insLmnote != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no.' and query is '.$this->db->last_query());
            $data = array(
              'error'=>"#ERRSET0005: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
          }
        }

        // update in Limited Conversion of Tea Grant applicant for possession period

        foreach ($lmdata['applicants'] as $setl) 
        {
          if($setl->is_applicant == 1)
          {
            $arr = [
              'period_possession' => $this->input->post('lm_possession_entry'),
            ];
            $where = [
              'case_no'      => $case_no,
              'is_applicant' => 1,
            ];
            $update = $this->db->update('settlement_applicant', $arr, $where);
            if($this->db->affected_rows() != 1)
            {
              $this->db->trans_rollback();
              log_message('error', '#ERRSET2364: Updation failed in settlement_applicant  Case No '.$case_no);
              $data = array(
                'error'=>"#ERRSET2364: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }
          }        
        }
        if($validation_bypass == 1)
        {
          $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
            TEA_SERVICE_CODE,
            $case_no,
            $application_no,
            $lmdata['rejected_list']
          );
        }

        // var_dump($validation_bypass); die;

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
                  'date_entry'=>date('Y-m-d H:i:s'),
                  'date_update'=>date('Y-m-d H:i:s'),
                  'type'=>'R'
              );

              $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
              // echo $this->db->last_query(); die();
              if ($reserveData != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                $data = array(
                  'error'=>"#ERRSET00052: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
              }
            }
          }

          if ($family_comment_check=='YES') {
            foreach ($lmdata['dags'] as $dags) {
              $reservedarea=array(
                'dist_code'         => $this->input->post('dist_code'),
                'subdiv_code'       => $this->input->post('subdiv_code'),
                'cir_code'          => $this->input->post('cir_code'),
                'mouza_pargona_code'=> $this->input->post('mouza_pargona_code'),
                'lot_no'            => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'dag_no'            => $this->input->post('reserved_dag_family'.$dags->dag_no),
                'patta_no'          => $this->input->post('reserved_patta_family'.$dags->dag_no),
                'bigha'             => $this->input->post('reserved_bigha_family'.$dags->dag_no),
                'katha'             => $this->input->post('reserved_katha_family'.$dags->dag_no),
                'lessa'             => $this->input->post('reserved_lessa_family'.$dags->dag_no),
                'ganda'             => $this->input->post('reserved_ganda_family'.$dags->dag_no),
                'kranti'            => $this->input->post('reserved_kranti_family'.$dags->dag_no),
                'case_no'           => $case_no,
                'applid'            => $this->input->post('applid'),
                'lm_code'           => $this->session->userdata('user_code'),
                'date_entry'        => date('Y-m-d H:i:s'),
                'date_update'       => date('Y-m-d H:i:s'),
                'type'              => 'F'
              );

              $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
              // echo $this->db->last_query(); die();
              if ($reserveData != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00053: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                $data = array(
                  'error'=> "#ERRSET00053: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
              }
            }
          }
          ///// family reserve area end //////

          //// premium insert start ******************
          $sumMbAmount = 0;
          $approved_by = '';
          $count       = 0;

          // echo "<pre>"; var_dump($lmdata['dags']); die;

          foreach ($lmdata['dags'] as $dag_premium) {

            // echo "<pre>"; var_dump($dag_premium); die;

            $count++;
            if($count >1){
              if ($approved_by != $this->input->post('approval'.$dag_premium->dag_no)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAM000199: Limited Conversion of Tea Grant Application not submitted case no # $application_no");
                log_message('error', '#ERRAM000199: Multiple User Approval, RTPS Case No '.$application_no);
                redirect(base_url() . "index.php/home");
              }
            }

            // premium verify start ******************
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
              $area_in_bigha = 6400;
            }else{
              $area_in_bigha = 100;
            }

            $uuid = $this->db->query("SELECT uuid FROM settlement_basic WHERE case_no=?", array($case_no))->row()->uuid;
            $dag_no = $dag_premium->dag_no;

            $is_full_pay=$this->input->post('paymode');
            // $prem_zonal = $this->utilityclass->getZonalValue($dag_premium->dist_code,$basic['uuid'],$dag_premium->dag_no);
            $prem_zonal = $this->utilityclass->getZonalValue($dag_premium->dist_code,$uuid,$dag_no);
            $prem_area = $this->input->post('total_lessa'.$dag_premium->dag_no);
            $prem_concession = "YES";

            $percentage = 10;
            $zonal_lessa = $prem_zonal / $area_in_bigha;
            $premium = $prem_area * $zonal_lessa;
            $finalamount = ceil($premium * $percentage / 100);

            $sumMbAmount += $finalamount;

            // premium verify end ******************

            $fmd=array(
              'case_no'         => $case_no,
              'user_code'       => $this->session->userdata('user_code'),
              'uuid'            => $basic['uuid'],
              'dag_no'          => $dag_premium->dag_no,
              'zonal_valuation' => $this->input->post('zonal_valuation_prem'.$dag_premium->dag_no),
              'area_name'       => null,
              'land_type'       => null,
              'rate_type'       => null,
              'rate'            => null,
              'concession'      => null,
              'amount_dag'      => $this->input->post('amount'.$dag_premium->dag_no),
              'final_amount'    => $this->input->post('finalamount'),
              'due_amount'      => $this->input->post('totaldue'),
              'total_lessa'     => $this->input->post('total_lessa'.$dag_premium->dag_no),
              'is_full_pay'     => $this->input->post('paymode'),
              'is_final'        => 1,
              'date_entry'      => date('Y-m-d H:i:s'),
            );

            $insPremium = $this->db->insert('settlement_premium', $fmd);

            if ($insPremium != 1) {
              $this->db->trans_rollback();
              log_message('error', '#ERRSET0002515: Insertion failed in settlement_premium RTPS Case No '.$application_no);
              $data = array(
                  'error'=>"#ERRSET0002515: Registration of Limited Conversion of Tea Grant failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }

            $approved_by = $this->input->post('approval'.$dag_premium->dag_no);
          } // foreach end

          // premium verify 2 start ******************
          if($sumMbAmount != $this->input->post('finalamount')){
              // var_dump("Amount mismatch!!!"); die;
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #ERRAM7206: Limited Conversion of Tea Grant Application not submitted case no # $application_no");
            log_message('error', '#ERRAM7206: Premium ghotala by LM, RTPS Case No '.$application_no);
            redirect(base_url() . "index.php/home");
          }
          if ($is_full_pay=="NO"){
            $discount = 10;
            $finaldue = ($sumMbAmount * $discount / 100);
            // $finaldueamount = round($finaldue,2);
            $finaldueamount = ceil($finaldue);
          }else if ($is_full_pay=="YES"){
            $finaldueamount= $sumMbAmount;
          }

          if($finaldueamount != $this->input->post('totaldue')){
            // var_dump("Due Amount mismatch!!!");
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #ERRAM0002: Limited Conversion of Tea Grant Application not submitted case no # $case_no");
            log_message('error', '#ERRAM0002: Premium ghotala by LM, RTPS Case No '.$application_no);
            redirect(base_url() . "index.php/home");
          }
          // premium verify 2 end ******************
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("SELECT max(proceeding_id)+1 as c FROM settlement_proceeding WHERE case_no=? ",[$case_no])->row()->c;

        if ($proceeding_id==null) {
          $proceeding_id=1;
        }

        $msg='';
        if($this->input->post('lm_note') == 1){ $msg = 'Can be recommened';}

        $note_on_order = $this->input->post('lm_remark_text')."<br>".$msg;

        $insPetProceed = [
          'case_no'              => $case_no,
          'proceeding_id'        => $proceeding_id,
          'date_of_hearing'      => date('Y-m-d H:i:s'),
          'next_date_of_hearing' => date('Y-m-d H:i:s'),
          'note_on_order'        => $note_on_order,
          'status'               => 'W',
          'user_code'            => $this->session->userdata('user_code'),
          'date_entry'           => date('Y-m-d H:i:s'),
          'operation'            => 'E',
          'ip'                   => $this->utilityclass->get_client_ip(),
          'office_from'          => 'LM',
          'office_to'            => $pending_officer,
          'task'                 => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if ($insertProceeding != 1) {
          $this->db->trans_rollback();
          log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
          $json = [
            'errorMessage' => "#ERRORPP: Failed to forward the case for Case No : ".$case_no
          ];
          echo json_encode($json);
          return false;
        }
        //////proceeding end//////

        ////settlement Khas LM Report insert end

        if ($this->db->trans_status()==false) {
          $this->db->trans_rollback();
          $data=array(
            'error'=>"Error in submitting. Please try Again"
          );
        } 
        else 
        {

          // define('API_LINK_MB3','https://basundhara.assam.gov.in/rtpsmb2demo/ApiMbThree/');
          
          //////////////POST To basundhara/////////////////////
          $rmk    = 'Forwarded to '.$pending_officer;
          $status = 'M';
          $task   = 'LM';
          $pen    = 'CO';
          // $pen=$pending_officer;
          $case   = $case_no;
          $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
          $rtps_status = json_decode($rtps_status);
          if (trim($rtps_status) != "y") {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error #ERRAPP0011: Limited Conversion of Tea Grant Application not submitted case no # $case_no");
            redirect(base_url() . "index.php/home");
          } 
          else {
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
    foreach(json_decode(VALIDATION_BYPASS_TEA_GRANT) as $cons_reasons)
    {
      if($cons_reasons->SERVICE_CODE == $service_code)
      {
        $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
      }
    }
    return $validation_bypass_array;
  }

  public function addProperty()
  {
    $validation         = null;
    $dist_code          = trim($this->input->post('additional_district'));
    $dist_name          = $this->input->post('additional_district_name');
    $cir_code           = trim($this->input->post('additional_circle'));
    $cir_name           = $this->input->post('additional_circle_name');
    $subdiv_code        = trim($this->input->post('subdiv_code'));
    $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
    $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
    $lot_no             = trim($this->input->post('lot_no'));
    $bigha              = trim($this->input->post('additional_bigha'));
    $katha              = trim($this->input->post('additional_katha'));
    $lessa              = trim($this->input->post('additional_lessa'));

    if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
      $ganda  = trim($this->input->post('additional_ganda'));
      $kranti = trim($this->input->post('additional_kranti'));
    } else {
      $ganda  = 0;
      $kranti = 0;
    }

    $ref_no                  = trim($this->input->post('ref_no'));
    $is_additional_urban     = trim($this->input->post('is_additional_urban'));
    $additional_village      = trim($this->input->post('additional_village'));
    $additional_dag          = trim($this->input->post('additional_dag'));
    $additional_patta        = trim($this->input->post('additional_patta'));
    $additional_village_code = trim($this->input->post('additional_village_code'));
    $case_no                 = trim($this->input->post('case_no'));

    $this->load->library('form_validation');

    $this->form_validation->set_rules('additional_district', 'District', 'required|numeric|trim|xss_clean');
    $this->form_validation->set_rules('additional_circle', 'Circle', 'required|trim|xss_clean');

    $this->form_validation->set_rules('additional_bigha', 'Bigha', 'required|is_natural|trim|greater_than[-1]|xss_clean');

    if (in_array($dist_code, json_decode(BARAK_VALLEY))) { // for barak valley
      $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[20]');
      $this->form_validation->set_rules('additional_lessa', 'Chatak', 'required|greater_than[-1]|less_than[16]');
      $this->form_validation->set_rules('additional_ganda', 'Ganda', 'required|numeric|greater_than[-1]|less_than[20]');
      $this->form_validation->set_rules('additional_kranti', 'Kranti', 'numeric|greater_than[-1]|less_than[12]');
    } else { // other than barak valley
      $this->form_validation->set_rules('additional_katha', 'Katha', 'required|is_natural|greater_than[-1]|less_than[5]');
      $this->form_validation->set_rules('additional_lessa', 'Lessa', 'required|greater_than[-1]|less_than[20]');
    }

    if ($this->form_validation->run() == false) {
      $this->form_validation->set_error_delimiters('', '');

      if (form_error('additional_district')) {
        $validation[] = array('field' => 'additional_district', 'message' => form_error('additional_district'));
      }
      if (form_error('additional_circle')) {
        $validation[] = array('field' => 'additional_circle', 'message' => form_error('additional_circle'));
      }
      if (form_error('additional_bigha')) {
        $validation[] = array('field' => 'additional_bigha', 'message' => form_error('additional_bigha'));
      }
      if (form_error('additional_katha')) {
        $validation[] = array('field' => 'additional_katha', 'message' => form_error('additional_katha'));
      }
      if (form_error('additional_lessa')) {
        $validation[] = array('field' => 'additional_lessa', 'message' => form_error('additional_lessa'));
      }
      if (form_error('additional_ganda')) {
        $validation[] = array('field' => 'additional_ganda', 'message' => form_error('additional_ganda'));
      }
      if (form_error('additional_kranti')) {
        $validation[] = array('field' => 'additional_kranti', 'message' => form_error('additional_kranti'));
      }
    }

    if ($validation != null) {
      echo json_encode(array(
        'responseType' => 1,
        'validation'   => $validation,
      ));
      return;
    } 
    else {

      $this->db->trans_begin();

      // insertion in backup table
      $backup_array_lm = [
        'applid' => $ref_no,
        'status' => 'I',
        'data'   => json_encode($_POST),
      ];

      $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
      if ($backup_insertion_lm != 1) {
        $this->db->trans_rollback();
        log_message('error', '#BACKUP002: Insertion failed in settlement_backup_json RTPS Case No ' . $ref_no);
        $json = [
          'responseType' => 3,
          'message'      => 'Data insertion fail in backup_json',
        ];
        echo json_encode($json);
        return false;
      }

      if ($additional_dag == '' || $additional_dag == null) {
        $this->db->trans_rollback();
        log_message('error', 'Dag not selected');
        $json = [
          'responseType' => 3,
          'message'      => 'Please Select Dag',
        ];
        echo json_encode($json);
        return false;
      }

      if ($additional_village_code == '' || $additional_village_code == null) {
        $this->db->trans_rollback();
        log_message('error', 'Village not selected');
        $json = [
          'responseType' => 3,
          'message'      => 'Please Select Village',
        ];
        echo json_encode($json);
        return false;
      }

      if ($additional_patta == '' || $additional_patta == null) {
        $this->db->trans_rollback();
        log_message('error', 'Patta is null');
        $json = [
          'responseType' => 3,
          'message'      => 'Patta can not be null',
        ];
        echo json_encode($json);
        return false;
      }

      $this->dbswitchmb2($dist_code);

      //uuid from location table
      $query = $this->db->query("SELECT uuid FROM location WHERE dist_code=? AND subdiv_code=?
      AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?",
          array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
              $lot_no, $vill_townprt_code));
      if ($query->num_rows() == 0) {
        $this->db->trans_rollback();
        log_message('error', 'Incorrect location selected. No uuid found' . $this->db->last_query());
        $json = [
          'responseType' => 3,
          'message'      => 'Incorrect Location selected. Kindly contact system administrator',
        ];
        echo json_encode($json);
        return false;
      }

      $this->dbswitch($this->session->userdata('dist_code'));

      //////////////// Save Applicant ///////////////
      $propertyadd = array(
        'applid'             => $ref_no,
        'case_no'            => $case_no,
        'dist_code'          => $dist_code,
        'subdiv_code'        => $subdiv_code,
        'cir_code'           => $cir_code,
        'mouza_pargona_code' => $mouza_pargona_code,
        'lot_no'             => $lot_no,
        'vill_townprt_code'  => $vill_townprt_code,
        'bigha'              => $bigha,
        'katha'              => $katha,
        'lessa'              => $lessa,
        'ganda'              => $ganda,
        'kranti'             => $kranti,
        'entry_date'         => date('Y-m-d H:i:s'),
        'is_rural'           => $is_additional_urban,
        'dag_no'             => trim($additional_dag),
        'patta_no'           => $additional_patta,
        'uuid'               => $query->row()->uuid,
        'applied_flag'       => MB_LOT_MONDOL,
        'dist_name'          => trim($dist_name),
        'cir_name'           => trim($cir_name),
        'vill_name'          => trim($additional_village),
      );

      // var_dump($this->db); die;

      $this->db->insert('settlement_additional_property', $propertyadd);

      if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        $response['status'] = 0;
        echo json_encode(['status' => 0]);
      } else {
        $property_id = $this->db->insert_id();
        $row = $this->db->select('*')->from('settlement_additional_property')->where('id', (int)$property_id)->get()->row_array();
        $this->db->trans_commit();
        echo json_encode(['status' => 200, 'result' => $row]);
        return;
      }
    }
  }

  public function propertydel()
  {
    $this->db->trans_begin();
    $property_id = $this->input->post('property_id');

    $row = $this->db->select('applid')->from('settlement_additional_property')->where('id', (int)$property_id)->get();
    if ($row->num_rows() == 0) {
      $this->db->trans_rollback();
      log_message('error', 'No detail available in settlement_additional_property ' . $this->db->last_query());
      $json = [
        'status'  => 3,
        'message' => 'Nothing to delete !!',
      ];
      echo json_encode($json);
      return false;
    }

    $applid = $row->row()->applid;

    $sql = "DELETE FROM settlement_additional_property WHERE id='$property_id'";
    $result = $this->db->query($sql);
    if ($this->db->affected_rows() != 1) {
      $this->db->trans_rollback();
      $response['status'] = 0;
      echo json_encode(['status' => 0]);
      log_message("error", "#PROP0001 Failed to delete property_id: " . $property_id);
      return;
    } else {
      $this->db->trans_commit();
      $result = $this->db->select('*')->from('settlement_additional_property')->where('applid', $applid)->get();
      echo json_encode(['status' => 200, 'result' => $result->row_array(), 'count' => $result->num_rows()]);
      return;
    }
  }

  public function dbswitchmb2($district)
  {
      //$CI=&get_instance();
      if ($district == "02") {
          $this->db = $this->load->database('dha3', true);
      } else if ($district == "05") {
          $this->db = $this->load->database('dha1', true);
      } else if ($district == "10") {
          $this->db = $this->load->database('dha24', true);
      } else if ($district == "13") {
          $this->db = $this->load->database('dha2', true);
      } else if ($district == "17") {
          $this->db = $this->load->database('dha4', true);
      } else if ($district == "15") {
          $this->db = $this->load->database('dha5', true);
      } else if ($district == "14") {
          $this->db = $this->load->database('dha6', true);
      } else if ($district == "07") {
          $this->db = $this->load->database('dha7', true);
      } else if ($district == "03") {
          $this->db = $this->load->database('dha8', true);
      } else if ($district == "18") {
          $this->db = $this->load->database('dha9', true);
      } else if ($district == "12") {
          $this->db = $this->load->database('dha13', true);
      } else if ($district == "24") {
          $this->db = $this->load->database('dha10', true);
      } else if ($district == "06") {
          $this->db = $this->load->database('dha11', true);
      } else if ($district == "11") {
          $this->db = $this->load->database('dha12', true);
      } else if ($district == "12") {
          $this->db = $this->load->database('dha13', true);
      } else if ($district == "16") {
          $this->db = $this->load->database('dha14', true);
      } else if ($district == "32") {
          $this->db = $this->load->database('dha15', true);
      } else if ($district == "33") {
          $this->db = $this->load->database('dha16', true);
      } else if ($district == "34") {
          $this->db = $this->load->database('dha17', true);
      } else if ($district == "21") {
          $this->db = $this->load->database('dha18', true);
      } else if ($district == "08") {
          $this->db = $this->load->database('dha19', true);
      } else if ($district == "35") {
          $this->db = $this->load->database('dha20', true);
      } else if ($district == "36") {
          $this->db = $this->load->database('dha21', true);
      } else if ($district == "37") {
          $this->db = $this->load->database('dha22', true);
      } else if ($district == "25") {
          $this->db = $this->load->database('dha23', true);
      }
  }

  public function switchDb()
  {
    $applid = trim($this->input->post('applid'));
    $getData = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid=?", array($applid))->num_rows();
    echo json_encode(['count' => $getData]);
    return;
  }

  private function UUID4()
  {
      $bytes = random_bytes(16);
      $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
      $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

      return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
  }

  //****update settlement_applicant*** */
  public function updateTeaApplicantDetails()
  {
    //****getting the data  */
    $applicant_tea_id = $this->input->post('applicant_tea_id');
    $case_no          = $this->input->post('case_no');

    //******backend validation */
    //***delimiter for not returning <p> tag */
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('applicant_tea_id', 'Applicant ID', 'trim|required');
    $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
    $this->form_validation->set_rules('applicant_tea_applicant_name_ass', 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
    $this->form_validation->set_rules('applicant_tea_applicant_name_eng', 'Pattadar English Name', 'trim|required|min_length[3]|max_length[70]');
    $this->form_validation->set_rules('applicant_tea_guardian_name_ass', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
    $this->form_validation->set_rules('applicant_tea_guardian_name_eng', 'Pattadar English Guardian', 'trim|min_length[3]|required|max_length[70]');
    $this->form_validation->set_rules('applicant_tea_relation', 'Pattadar Guardian Relation', 'trim|required');
    $this->form_validation->set_rules('applicant_tea_gender', 'Pattadar Gender ', 'trim|required');
    $this->form_validation->set_rules('applicant_tea_dob', 'DOB', 'required|max_length[70]');

    if ($this->input->post('applicant_tea_is_applicant') == 1) {
        $this->form_validation->set_rules('applicant_tea_marital_status', 'Marital Status.', 'trim|required|max_length[10]');
    }
    $this->form_validation->set_rules('applicant_tea_mobile', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
    $this->form_validation->set_rules('applicant_tea_per_address', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
    $this->form_validation->set_rules('applicant_tea_pre_address', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');

    if ($this->form_validation->run() == false) {
      $data = [
        'responseType' => 0,
        'msg'          => "#SETTLAPPBACK00012:" . validation_errors() . "#case_no : " . $case_no,
      ];
      echo json_encode($data);
      return false;
    }

    $this->db->trans_begin();

    if ($this->input->post('applicant_tea_is_applicant') == 1) {
      $marital_status = $this->input->post('applicant_tea_marital_status');
    } else {
      $marital_status = null;
    }

    $applicantDetailsArr = [
      'pdar_name'         => $this->input->post('applicant_tea_applicant_name_ass'),
      'eng_pdar_name'     => $this->input->post('applicant_tea_applicant_name_eng'),
      'pdar_guardian'     => $this->input->post('applicant_tea_guardian_name_ass'),
      'eng_pdar_guardian' => $this->input->post('applicant_tea_guardian_name_eng'),
      'pdar_rel_guar'     => $this->input->post('applicant_tea_relation'),
      'pdar_gender'       => $this->input->post('applicant_tea_gender'),
      'dob'               => $this->input->post('applicant_tea_dob'),
      'marital_status'    => $marital_status,
      'pdar_mobile'       => $this->input->post('applicant_tea_mobile'),
      'pdar_add1'         => $this->input->post('applicant_tea_per_address'),
      'pdar_add2'         => $this->input->post('applicant_tea_pre_address'),
    ];

    $this->db->where('case_no', $case_no);
    $this->db->where('id', $applicant_tea_id);
    $this->db->update('settlement_applicant', $applicantDetailsArr);

    //*******check if data updated */
    if ($this->db->affected_rows() == 0) {
      $this->db->trans_rollback();
      log_message('error', '#ERR4960: Update fail in settlement_applicant ' . $case_no);
      $data = [
        'responseType' => 0,
        'msg'          => "#ERR4960: Update fail in settlement_applicant : " . $case_no,
      ];
      echo json_encode($data);
      return false;
    }

    // insert into settlement_proceeding
    //////proceeding start//////
    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=? ",[$case_no])->row()->c;

    if ($proceeding_id == null) {
      $proceeding_id = 1;
    }

    $insPetProceed = [
      'case_no'              => $case_no,
      'proceeding_id'        => $proceeding_id,
      'date_of_hearing'      => date('Y-m-d H:i:s'),
      'next_date_of_hearing' => date('Y-m-d H:i:s'),
      'note_on_order'        => 'Edited Applicant details',
      'status'               => 'X',
      'user_code'            => $this->session->userdata('user_code'),
      'date_entry'           => date('Y-m-d H:i:s'),
      'operation'            => 'E',
      'ip'                   => $this->utilityclass->get_client_ip(),
      'office_from'          => 'LRA',
      'office_to'            => 'LRA',
      'task'                 => 'Applicant details updated',
      'note_type'            => $this->input->post('lm_note'),
    ];
    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

    // echo $this->db->last_query(); die();
    if ($insertProceeding != 1) {
      $this->db->trans_rollback();
      log_message('error', '#ERR4998: Update fail in settlement_proceeding ' . $case_no);
      $data = [
        'responseType' => 0,
        'msg'          => "#ERR4998: Update fail in settlement_proceeding : " . $case_no,
      ];
      echo json_encode($data);
      return false;
    }

    $this->db->trans_commit();
    //**** if data intserted successfully*/
    $data = [
      'responseType' => 2,
      'appnData'     => $applicantDetailsArr,
      'msg'          => "Applcant data updated successfully...",
    ];
    echo json_encode($data);

  }

  protected function checkPattaTypeInSettlementApplicant($case_no, $ptypecode)
  {
    return $sql = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND patta_type_code=? AND pdar_type IN (?, ?)", 
                    array($case_no, $ptypecode, 'EP', 'O'));
  }

  protected function checkPattaNoInSettlementApplicant($case_no, $ptypecode, $pno)
  {
    return $sql = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND patta_type_code=? AND patta_no=? 
                    AND pdar_type IN (?, ?)", array($case_no, $ptypecode, $pno, 'EP', 'O'));
  }

  // get patta type list
  public function getTeaGrantPattaTypeList()
  {
    $_POST  = json_decode(file_get_contents("php://input"), true);
    $json   = array();
    $dist   = $this->input->post('dist');
    $subdiv = $this->input->post('subdiv');
    $cir    = $this->input->post('cir');
    $mouza  = $this->input->post('mouza');
    $lot    = $this->input->post('lot');
    $vill   = $this->input->post('vill');

    $patta_type_list = $this->db->query("SELECT pc.type_code AS patta_type_code, pc.patta_type AS patta_name FROM chitha_basic cb 
                          JOIN patta_code pc on cb.patta_type_code = pc.type_code where cb.dist_code = ? AND cb.subdiv_code = ? 
                            AND cb.cir_code = ? AND cb.mouza_pargona_code = ? AND cb.lot_no = ? AND cb.vill_townprt_code = ? 
                              AND pc.tea_patta = ? GROUP BY pc.type_code, pc.patta_type", 
                                array($dist, $subdiv, $cir, $mouza, $lot, $vill, 'y'))->result();
    echo json_encode($patta_type_list);
    return;
  }

  // get patta no list
  public function getTeaGrantPattaNoList()
  {
    $_POST     = json_decode(file_get_contents("php://input"), true);
    $json      = array();
    $dist      = $this->input->post('dist');
    $subdiv    = $this->input->post('subdiv');
    $cir       = $this->input->post('cir');
    $mouza     = $this->input->post('mouza');
    $lot       = $this->input->post('lot');
    $vill      = $this->input->post('vill');
    $ptypecode = $this->input->post('ptypecode');
    $case_no   = $this->input->post('case_no');

    $data_exist = $this->checkPattaTypeInSettlementApplicant($case_no, $ptypecode)->num_rows();

    $patta_no_list = $this->db->query("SELECT cb.patta_no FROM chitha_basic cb WHERE cb.dist_code = ? AND cb.subdiv_code = ? AND 
                        cb.cir_code = ? AND cb.mouza_pargona_code = ? AND cb.lot_no =? AND cb.vill_townprt_code =? 
                          AND cb.patta_type_code =? GROUP BY cb.patta_no", 
                            array($dist, $subdiv, $cir, $mouza, $lot, $vill, $ptypecode))->result();
    echo json_encode([
      'data_exist'    => $data_exist, // if 0 then new patta type else old
      'patta_no_list' => $patta_no_list,
    ]);
    return;
  }

  // get dag list
  public function getTeaGrantDagList()
  {
    $_POST       = json_decode(file_get_contents("php://input"), true);
    $json        = array();
    $dist        = $this->input->post('dist');
    $subdiv      = $this->input->post('subdiv');
    $cir         = $this->input->post('cir');
    $mouza       = $this->input->post('mouza');
    $lot         = $this->input->post('lot');
    $vill        = $this->input->post('vill');
    $case_no     = $this->input->post('case_no');
    $patta_no    = $this->input->post('pno');
    $patta_type  = $this->input->post('ptypecode');

    $data_exist  = $this->checkPattaNoInSettlementApplicant($case_no, $patta_type, $patta_no)->num_rows();    

    $dag_list    = $this->db->query("SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,
                      dag_no, dag_no_int, patta_no, patta_type_code, dag_area_b AS bigha, dag_area_k AS katha, 
                        dag_area_lc AS lessa, dag_area_g AS ganda, dag_area_kr AS kranti FROM chitha_basic 
                          WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
                            AND vill_townprt_code =? AND patta_no=? AND patta_type_code=?", 
                              array($dist, $subdiv, $cir, $mouza, $lot, $vill, $patta_no, $patta_type))->result();
    echo json_encode([
      'data_exist' => $data_exist, // if 0 then new patta type else old
      'dag_list'   => $dag_list,
    ]);
    return;
  }

  // get pattadars list
  public function getTeaGrantPattadarsList()
  {
    $_POST      = json_decode(file_get_contents("php://input"), true);
    $json       = array();
    $dist       = $this->input->post('dist');
    $subdiv     = $this->input->post('subdiv');
    $cir        = $this->input->post('cir');
    $mouza      = $this->input->post('mouza');
    $lot        = $this->input->post('lot');
    $vill       = $this->input->post('vill');
    $scode      = $this->input->post('scode');
    $case_no    = $this->input->post('case_no');
    $dag_no_int = $this->input->post('dag');
    $patta_no   = $this->input->post('new_patta_no');
    $patta_type = $this->input->post('new_patta_type');

    // get dag no from chitha basic table
    $dag_no        = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND
                       mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no_int=?", 
                        array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no_int))->row()->dag_no;

    $pattadar_list = $this->db->query("SELECT cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2 
                        FROM chitha_dag_pattadar cdp JOIN chitha_pattadar cp ON cdp.dist_code = cp.dist_code AND 
                          cdp.subdiv_code = cp.subdiv_code AND cdp.cir_code = cp.cir_code AND cdp.mouza_pargona_code = cp.mouza_pargona_code 
                            AND cdp.lot_no = cp.lot_no AND cdp.vill_townprt_code = cp.vill_townprt_code AND cdp.patta_no = cp.patta_no 
                              AND cdp.patta_type_code = cp.patta_type_code AND cdp.pdar_id = cp.pdar_id where cdp.dist_code=? 
                                AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? AND cdp.lot_no =? 
                                  AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.patta_no=? AND cdp.patta_type_code=?", 
                                    array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no, $patta_no, $patta_type))->result();

    echo json_encode([
      'responseType'  => 2,
      'pattadar_list' => $pattadar_list,
    ]);
    return;
  }


  public function saveTeaGrantDagDetail()
  {
    $_POST                = json_decode(file_get_contents("php://input"), true);
    $case_no              = $this->input->post('case_no');
    $application_no       = $this->input->post('application_no');
    $district             = $this->input->post('district');
    $subdiv_code          = $this->input->post('subdiv_code');
    $circle               = $this->input->post('circle');
    $mouza_code           = $this->input->post('mouza_code');
    $lot_no               = $this->input->post('lot_no');
    $village              = $this->input->post('village');
    $service_code         = $this->input->post('service_code');
    $dag                  = $this->input->post('dag');
    $pattadar_not_exist   = $this->input->post('pattadar_not_exist');
    $applied_bigha        = $this->input->post('applied_bigha');
    $applied_katha        = $this->input->post('applied_katha');
    $applied_lessa        = $this->input->post('applied_lessa');
    $applied_ganda        = $this->input->post('applied_ganda');
    $pattadar_array       = $this->input->post('pattadar');
    // $rural_urban          = $this->input->post('rural_urban');
    $land_owner_id        = $this->input->post('land_owner_id');
    $new_dag_deed_no      = $this->input->post('new_dag_deed_no');
    $new_dag_name_in_asm  = $this->input->post('new_dag_name_in_asm');
    $new_dag_name_in_eng  = $this->input->post('new_dag_name_in_eng');
    $new_dag_gname_in_asm = $this->input->post('new_dag_gname_in_asm');
    $new_dag_gname_in_eng = $this->input->post('new_dag_gname_in_eng');
    $new_dag_relation     = $this->input->post('new_dag_relation');
    $new_dag_dob          = date('Y-m-d', strtotime($this->input->post('new_dag_dob')));
    $new_dag_gender       = $this->input->post('new_dag_gender');
    $new_dag_mobile       = $this->input->post('new_dag_mobile');
    $applied_detail       = $this->input->post('applied_detail');
    $patta_no             = $this->input->post('new_patta_no');
    $patta_type           = $this->input->post('new_patta_type');
    $clicked_from         = $this->input->post('clicked_from');


    // var_dump($rural_urban); die;


    // get dag no int
    $arr                  = explode('/', $dag);
    $dag_int              = $arr[0];
    $chitha_bigha         = $arr[1];
    $chitha_katha         = $arr[2];
    $chitha_lessa         = $arr[3];

    if (in_array($district, json_decode(BARAK_VALLEY)))
    {
      $chitha_ganda  = $arr[4];
      $chitha_kranti = 0;
    }

    // get rural or urban
    $rural_urban = $this->db->query("SELECT is_urban FROM settlement_dag_details WHERE case_no=? AND is_urban!=?  LIMIT 1", 
                      array($case_no,''))->row()->is_urban;
    
    if($rural_urban == '' || $rural_urban == null)
    {
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5224: Something went wrong, could not add dag detail !!!',
      ]);
      return;
    }

    // get dag no
    $dag_no  = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND
                 mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no_int=?", 
                  array($district, $subdiv_code, $circle, $mouza_code, $lot_no, $village, $dag_int))->row()->dag_no;

    if(empty($dag)){
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5145: Select Dag No !!!',
      ]);
      return;
    }

    if(empty($pattadar_not_exist) && empty($pattadar_array)){
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5166: Please select the pattadar !!!',
      ]);
      return;
    }

    if(empty($pattadar_array))
    {
      if($land_owner_id == '' || $land_owner_id == null)
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5164: All fields with asterick(*) is mandatory !!!',
        ]);
        return;
      }
      if(empty($land_owner_id)        || empty($new_dag_deed_no)      || empty($new_dag_name_in_asm) || empty($new_dag_name_in_eng) || 
         empty($new_dag_gname_in_asm) || empty($new_dag_gname_in_eng) || empty($new_dag_relation)    || empty($new_dag_dob)         || 
         empty($new_dag_gender)       || empty($new_dag_mobile))
      {
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5164: All fields with asterick(*) is mandatory !!!',
        ]);
        return;
      }
    } 

    // area validation
    if(in_array($district, BARAK_VALLEY)){
      $chitha_total_lessa  = $this->utilityclass->Total_ganda($chitha_bigha, $chitha_katha, $chitha_lessa, $chitha_ganda);
      $total_applid_lesssa = $this->utilityclass->Total_ganda($applied_bigha, $applied_katha, $applied_lessa, $applied_ganda);
    }else{
      $chitha_total_lessa  = $this->utilityclass->Total_Lessa($chitha_bigha, $chitha_katha, $chitha_lessa);
      $total_applid_lesssa = $this->utilityclass->Total_Lessa($applied_bigha, $applied_katha, $applied_lessa);
    }

    if($total_applid_lesssa > $chitha_total_lessa){
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5183: Applied area is greater then the area exist in the dag !!!',
      ]);
      return;
    }

    if($total_applid_lesssa <= 0){
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5191: Applied area cannot be zero !!!',
      ]);
      return;
    }

    // get detail from settlement_basic
    $fromBasic = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no))->row();

    // get detail from settlement_dag_details
    $getDetail = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=? LIMIT 1", array($case_no))->row();
    $add_1     = $getDetail->pdar_add1;
    $add_2     = $getDetail->pdar_add2;

    $pdar_cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 AS c FROM settlement_applicant WHERE case_no=?", 
                      array($case_no))->row()->c;

    if($pdar_cron_no == null) { $pdar_cron_no = 1; }

    if($applied_detail == 1) // modification with new patta type/code exist
    {
      $resp = $this->TeaGrantModel->addNewPattaDetail($case_no);
    }

    $this->db->trans_begin();

    // if enters as deed applicant and owner
    if (empty($pattadar_array)) {
      
      // insert in settlement_applicant
      $pdar_ins_array = [
        'dist_code'          => $district,
        'subdiv_code'        => $subdiv_code,
        'cir_code'           => $circle,
        'mouza_pargona_code' => $mouza_code,
        'lot_no'             => $lot_no,
        'vill_townprt_code'  => $village,
        'year_no'            => date('Y'),
        'petition_no'        => $fromBasic->petition_no,
        'dag_no'             => $dag_no,
        'patta_no'           => $patta_no,
        'patta_type_code'    => $patta_type,
        'pdar_id'            => '-1',
        'pdar_cron_no'       => $pdar_cron_no,
        'pdar_name'          => $new_dag_name_in_asm,
        'pdar_guardian'      => $new_dag_gname_in_asm,
        'pdar_rel_guar'      => $new_dag_relation,
        'user_code'          => $this->session->userdata('user_code'),
        'date_entry'         => date('Y-m-d H:i:s'),
        'operation'          => 'E',
        'pdar_gender'        => $new_dag_gender,
        'case_no'            => $case_no,
        'pdar_type'          => 'DA',
        'pdar_add1'          => $add_1,
        'pdar_add2'          => $add_2,
        'pdar_mobile'        => $new_dag_mobile,
        'is_applicant'       => 0,
        'dob'                => $new_dag_dob,
        'eng_pdar_name'      => $new_dag_name_in_eng,
        'eng_pdar_guardian'  => $new_dag_gname_in_eng,
        'appl_deed_no'       => $new_dag_deed_no,
      ];
      $insert_pattadar = $this->db->insert('settlement_applicant', $pdar_ins_array);

      if ($insert_pattadar != 1) {
        log_message("error", "#ERR5264: Insertion failed in settlement_applicant ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5264: Unable to save data !!!',
        ]);
        return;
      }

      // update settlement_basic with deed no
      $update = $this->db->query("UPDATE settlement_basic SET deed_no=? WHERE case_no=?", array($new_dag_deed_no, $case_no));
      if ($this->db->affected_rows() != 1) {
        log_message("error", "#ERR5281: Updation failed in settlement_basic ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5281: Unable to save data !!!',
        ]);
        return;
      }

      // insert owner detail
      $get_owner_sql = $this->db->query('SELECT * FROM chitha_pattadar WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
                          AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? 
                            AND pdar_id=?', array($district, $subdiv_code, $circle, $mouza_code, $lot_no, $village, $patta_no, $patta_type, $land_owner_id));

      if($get_owner_sql->num_rows() <= 0){
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5293: Owner not found!'
        ]);
        return;
      }

      $owner_row = $get_owner_sql->row();

      // check if for the same dag pdar_id already exist
      $checkForSameOwner = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? AND pdar_id=? 
                                AND dag_no=?", array($case_no, 'O', $land_owner_id, $dag_no));

      if($checkForSameOwner->num_rows() > 0){
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5362: Same Owner already exist for the selected dag !!!',
        ]);
        return;
      }

      // insert in settlement_applicant
      $owner_ins_array = [
        'dist_code'          => $district,
        'subdiv_code'        => $subdiv_code,
        'cir_code'           => $circle,
        'mouza_pargona_code' => $mouza_code,
        'lot_no'             => $lot_no,
        'vill_townprt_code'  => $village,
        'year_no'            => date('Y'),
        'petition_no'        => $fromBasic->petition_no,
        'dag_no'             => $dag_no,
        'patta_no'           => $patta_no,
        'patta_type_code'    => $patta_type,
        'pdar_id'            => $land_owner_id,
        'pdar_cron_no'       => $pdar_cron_no,
        'pdar_name'          => $owner_row->pdar_name,
        'pdar_guardian'      => $owner_row->pdar_father,
        'pdar_rel_guar'      => 0,
        'user_code'          => $this->session->userdata('user_code'),
        'date_entry'         => date('Y-m-d H:i:s'),
        'operation'          => 'E',
        'pdar_gender'        => $owner_row->pdar_gender,
        'case_no'            => $case_no,
        'pdar_type'          => 'O',
        'pdar_add1'          => $add_1,
        'pdar_add2'          => $add_2,
        'pdar_mobile'        => $owner_row->pdar_mobile,
        'is_applicant'       => 0,
      ];

      $insert_owner = $this->db->insert('settlement_applicant', $owner_ins_array);
      // echo $this->db->last_query(); die;

      if ($insert_owner != 1) {
        log_message("error", "#ERR5336: Insertion failed in settlement_applicant ".$this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR5336: Unable to save data !!!',
        ]);
        return;
      }
    }

    //if the pattadar exist
    if (empty($pattadar_not_exist)) {
      foreach ($pattadar_array as $pdar_id) {

        $get_pattadars_sql = $this->TeaGrantModel->getPattadar($district, $subdiv_code, $circle, $mouza_code, $lot_no, $village, $patta_no, $patta_type, $pdar_id);
        // echo $this->db->last_query(); die;

        if ($get_pattadars_sql->num_rows() <= 0) {
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR5192: No Pattadar detail found !!!',
          ]);
          return;
        }

        $pdar_row = $get_pattadars_sql->row();

        // check if for the same dag pdar_id already exist
        $checkForSamePattadar = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? AND pdar_id=? 
                                  AND dag_no=?", array($case_no, 'EP', $pdar_row->pdar_id, $dag_no));

        if($checkForSamePattadar->num_rows() > 0){
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR5362: Same pattadar already exist for the selected dag !!!',
          ]);
          return;
        }

        // insert in settlement_applicant
        $pdar_ins_array = [
          'dist_code'              => $district,
          'subdiv_code'            => $subdiv_code,
          'cir_code'               => $circle,
          'mouza_pargona_code'     => $mouza_code,
          'lot_no'                 => $lot_no,
          'vill_townprt_code'      => $village,
          'year_no'                => date('Y'),
          'petition_no'            => $fromBasic->petition_no,
          'dag_no'                 => $dag_no,
          'patta_no'               => $patta_no,
          'patta_type_code'        => $patta_type,
          'pdar_id'                => $pdar_row->pdar_id,
          'pdar_cron_no'           => $pdar_cron_no,
          'pdar_name'              => $pdar_row->pdar_name,
          'pdar_guardian'          => $pdar_row->pdar_father,
          'pdar_rel_guar'          => '0',
          'user_code'              => $this->session->userdata('user_code'),
          'date_entry'             => date('Y-m-d H:i:s'),
          'operation'              => 'E',
          'pdar_gender'            => '0',
          'case_no'                => $case_no,
          'pdar_type'              => 'EP',
          'pdar_add1'              => $add_1,
          'pdar_add2'              => $add_2,
          'relation_with_pattadar' => 'self',
        ];

        $insert_pattadar = $this->db->insert('settlement_applicant', $pdar_ins_array);
        // echo $this->db->last_query(); die;

        if ($insert_pattadar != 1) {
          log_message("error", "#ERR5252: Insertion failed in settlement_applicant ".$this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR5252: Unable to save data!',
          ]);
          return;
        }
      }
    }

    $applied_area = [
      'applied_bigha'  => $applied_bigha,
      'applied_katha'  => $applied_katha,
      'applied_lessa'  => $applied_lessa,
      'applied_ganda'  => $applied_ganda,
      'applied_kranti' => 0,
    ];

    //enter the area details
    $area_inser_array = [
      'dist_code'          => $district,
      'subdiv_code'        => $subdiv_code,
      'cir_code'           => $circle,
      'mouza_pargona_code' => $mouza_code,
      'lot_no'             => $lot_no,
      'vill_townprt_code'  => $village,
      'year_no'            => date('Y'),
      'petition_no'        => $fromBasic->petition_no,
      'dag_no'             => $dag_no,
      's_dag_area_b'       => $applied_bigha,
      's_dag_area_k'       => $applied_katha,
      's_dag_area_lc'      => $applied_lessa,
      's_dag_area_g'       => $applied_ganda,
      's_dag_area_kr'      => '0',
      'dag_area_b'         => $chitha_bigha,
      'dag_area_k'         => $chitha_katha,
      'dag_area_lc'        => $chitha_lessa,
      'dag_area_g'         => $chitha_ganda,
      'dag_area_kr'        => $chitha_kranti,
      'patta_no'           => $patta_no,
      'patta_type_code'    => $patta_type,
      'revenue'            => 0,
      'user_code'          => $this->session->userdata('user_code'),
      'date_entry'         => date('Y-m-d H:i:s'),
      'operation'          => 'E',
      'case_no'            => $case_no,
      'is_urban'           => $rural_urban,
      'land_type'          => 0,
      'encroachement_area' => json_encode($applied_area),
      'applied_b'          => $applied_bigha,
      'applied_k'          => $applied_katha,
      'applied_lc'         => $applied_lessa,
      'applied_g'          => $applied_ganda,
    ];

    $insert_area_details = $this->db->insert('settlement_dag_details', $area_inser_array);
        // echo $this->db->last_query(); die;

    if ($insert_area_details != 1) {
      log_message("error", "#ERR5440: Insertion failed in settlement_dag_details ".$this->db->last_query());
      $this->db->trans_rollback();
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5335: Unable to save data !!!',
      ]);
      return;
    }

    // insert into settlement_proceeding
    $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", 
                      array($case_no))->row()->c;

    if ($proceeding_id == null) {
      $proceeding_id = 1;
    }

    $pattadarEntered = empty($pattadar_not_exist) ? 'EP' : 'DA';

    $insPetProceed = [
      'case_no'              => $case_no,
      'proceeding_id'        => $proceeding_id,
      'date_of_hearing'      => date('Y-m-d H:i:s'),
      'next_date_of_hearing' => date('Y-m-d H:i:s'),
      'note_on_order'        => "New $pattadarEntered detail entered",
      'status'               => 'W',
      'user_code'            => $this->session->userdata('user_code'),
      'date_entry'           => date('Y-m-d H:i:s'),
      'operation'            => 'E',
      'ip'                   => $this->utilityclass->get_client_ip(),
      'office_from'          => 'LRA',
      'office_to'            => 'LRA',
      'task'                 => "LRA has entered new $pattadarEntered",
      'note_type'            => "LRA has entered new $pattadarEntered",
    ];
    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        // echo $this->db->last_query(); die;


    if ($insertProceeding != 1) {
      log_message("error", "#ERR5433: Insertion failed in settlement_proceeding ".$this->db->last_query());
      $this->db->trans_rollback();
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5433: Unable to save data!',
      ]);
      return;
    }

    // ============================ insert in settlement_area_history
    if (in_array($district, json_decode(BARAK_VALLEY)))
    {
      //***********actual Encroachment area ***************
      $actual_applied_area_lessa = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

      //***********total Actual Encroachment area*****************
      $total_actual_applied_area_lessa = (float)$actual_applied_area_lessa;
      $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_applied_area_lessa);
      // **********************************************

      //***********Settlement area that applicant will get settlement on***********
      $total_settlement_lessa_tea_grant = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

      //*****total Settlement area *************/
      $total_settlement_lessa = (float)$total_settlement_lessa_tea_grant;
      $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_lessa);

      //*************leftout area **************
      $leftOutAreaTeaGrantLessa = (float)$actual_applied_area_lessa - (float)$total_settlement_lessa_tea_grant;
      $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaTeaGrantLessa);

      //**********Total left out area***************
      $totalLeftOutArealessa = (float)$total_actual_applied_area_lessa - (float)$total_settlement_lessa;
      $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutArealessa);
    }
    else
    {
      //***********actual Encroachment area ***************
      $actual_applied_area_lessa = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

      //***********total Actual Encroachment area*****************
      $total_actual_applied_area_lessa = (float)$actual_applied_area_lessa;
      $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_applied_area_lessa);
      // **********************************************


      //***********Settlement area that applicant will get settlement on***********
      $total_settlement_lessa_tea_grant = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

      //*************Total settlement area */
      $total_settlement_lessa = (float)$total_settlement_lessa_tea_grant;
      $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

      //****************leftout area homestead**************
      $leftOutAreaTeaGrantLessa = (float)$actual_applied_area_lessa - (float)$total_settlement_lessa_tea_grant;
      $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaTeaGrantLessa);

      //**********Total left out area***************
      $totalLeftOutArealessa = (float)$total_actual_applied_area_lessa - (float)$total_settlement_lessa;
      $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
    }

    $uuid = $this->utilityclass->getUuid($district, $subdiv_code, $circle, $mouza_code, $lot_no, $village);
    // echo $uuid; die;
    $settlementAreaHistoryArr = [
      'application_no'                        => $application_no,
      'case_no'                               => $case_no,
      'dag_no'                                => $dag_no,
      'uuid'                                  => $uuid,
      'created_at'                            => date('Y-m-d'),
      'applied_area_home_bigha'               => $applied_bigha,
      'applied_area_home_katha'               => $applied_katha,
      'applied_area_home_lessa'               => $applied_lessa,
      'applied_area_home_ganda'               => $applied_ganda,
      'applied_area_home_kranti'              => 0,
      'applied_area_agri_bigha'               => 0,
      'applied_area_agri_katha'               => 0,
      'applied_area_agri_lessa'               => 0,
      'applied_area_agri_ganda'               => 0,
      'applied_area_agri_kranti'              => 0,
      'actual_encroachment_area_home_bigha'   => $applied_bigha,
      'actual_encroachment_area_home_katha'   => $applied_katha,
      'actual_encroachment_area_home_lessa'   => $applied_lessa,
      'actual_encroachment_area_home_ganda'   => $applied_ganda,
      'actual_encroachment_area_home_kranti'  => 0,
      'actual_encroachment_area_agri_bigha'   => 0,
      'actual_encroachment_area_agri_katha'   => 0,
      'actual_encroachment_area_agri_lessa'   => 0,
      'actual_encroachment_area_agri_ganda'   => 0,
      'actual_encroachment_area_agri_kranti'  => 0,
      'total_actual_encroachment_area_bigha'  => $totalAppliedAreaArr[0],
      'total_actual_encroachment_area_katha'  => $totalAppliedAreaArr[1],
      'total_actual_encroachment_area_lessa'  => $totalAppliedAreaArr[2],
      'total_actual_encroachment_area_ganda'  => $totalAppliedAreaArr[3],
      'total_actual_encroachment_area_kranti' => 0,
      'settlement_area_home_bigha'            => $applied_bigha,
      'settlement_area_home_katha'            => $applied_katha,
      'settlement_area_home_lessa'            => $applied_lessa,
      'settlement_area_home_ganda'            => $applied_ganda,
      'settlement_area_home_kranti'           => 0,
      'settlement_area_agri_bigha'            => 0,
      'settlement_area_agri_katha'            => 0,
      'settlement_area_agri_lessa'            => 0,
      'settlement_area_agri_ganda'            => 0,
      'settlement_area_agri_kranti'           => 0,
      'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
      'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
      'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
      'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
      'total_settlement_area_kranti'          => 0,
      'leftout_area_home_bigha'               => $leftOutAreaTeaGrantArr[0],
      'leftout_area_home_katha'               => $leftOutAreaTeaGrantArr[1],
      'leftout_area_home_lessa'               => $leftOutAreaTeaGrantArr[2],
      'leftout_area_home_ganda'               => $leftOutAreaTeaGrantArr[3],
      'leftout_area_home_kranti'              => 0,
      'leftout_area_agri_bigha'               => 0,
      'leftout_area_agri_katha'               => 0,
      'leftout_area_agri_lessa'               => 0,
      'leftout_area_agri_ganda'               => 0,
      'leftout_area_agri_kranti'              => 0,
      'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
      'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
      'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
      'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
      'total_leftout_area_kranti'             => 0,
    ];

    $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
        // echo $this->db->last_query(); die;

    if ($insertSetlArea != 1) {
      log_message("error", "#ERR5617: Insertion failed in settlement_area_history ".$this->db->last_query());
      $this->db->trans_rollback();
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5617: Unable to save data!',
      ]);
      return;
    }

    // insert new dag detail in history_tea_grant_modify
    $insHistroy = [
      'case_no'    => $case_no,
      'uuid'       => $uuid,
      'dag_no'     => $dag_no,
      'post_data'  => json_encode($_POST),
      'created_at' => date('Y-m-d'),
      'status'     => 1,
    ];
    $insertTeaGrantHistory = $this->db->insert('history_tea_grant_modify', $insHistroy);
        // echo $this->db->last_query(); die;

    if ($insertTeaGrantHistory != 1) {
      log_message("error", "#ERR5629: Insertion failed in history_tea_grant_modify ".$this->db->last_query());
      $this->db->trans_rollback();
      echo json_encode([
        'responseType' => 0,
        'msg'          => '#ERR5629: Unable to save data!',
      ]);
      return;
    }

    $this->db->trans_commit();
    echo json_encode([
      'responseType' => 2,
      'msg'          => 'Data has successfully saved...',
    ]);
    return;
  }


  public function pendingCaseListForFinalVerify()
  {
    $d = $this->session->userdata('dist_code');
    $s = $this->session->userdata('subdiv_code');
    $c = $this->session->userdata('cir_code');
    $m = $this->session->userdata('mouza_pargona_code');
    $l = $this->session->userdata('lot_no');

    $cases['cases']     = $this->TeaGrantModel->finalVerifyFromLraAfterPnGenerate($d, $s, $c, $m, $l)->result();

    $cases['_view'] = 'TeaGrant/LM/FinalVerificationPendingCaseList';
    $this->load->view('layouts/main', $cases);
  }

  public function getFinalVerificationDataTeaGrant()
  {
      $case_no = $this->input->post('case_no');
      $basicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

      if($basicSql->num_rows() <= 0)
      {
          log_message('error', '#ERR5908: No case number found!'. $this->db->last_query());
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR5908: No case number found!'
          ]);
          return false;
      }

      $data['basicRow'] = $basicSql->row();

      if($data['basicRow']->chitha_processing_details == 1)
      {
          log_message('error', '#ERR5920: No case number found!'. $this->db->last_query());
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR5920: Verification report already submitted!'
          ]);
          return false;
      }

      $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

      if($getDagsSql->num_rows() <= 0)
      {
          log_message('error', '#ERR5932: Case not found in settlemnet_dag_details'. $this->db->last_query());
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR5932: Dag details not found!'
          ]);
          return false;
      }

      $data['dagResult'] = $getDagsSql->result();

      foreach($data['dagResult'] as $dagRow)
      { 
          $dagRow->old_dag = $dagRow->dag_no;

          $landclass=$this->utilityclass->classCodeFromChitha($dagRow->dist_code,$dagRow->subdiv_code,$dagRow->cir_code,$dagRow->mouza_pargona_code,$dagRow->lot_no,$dagRow->vill_townprt_code,$dagRow->dag_no);
          if($landclass)
          {
              $className=$this->utilityclass->getLandClassCode($landclass);
          }

          $dagRow->old_class_name = $className;


          $premium_data_sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->old_dag));

          if($premium_data_sql->num_rows() <= 0)
          {
              log_message('error', '#ERR5975: Case not found in settlement_premium'. $this->db->last_query());
              echo json_encode([
                  'responseType'  => 0,
                  'msg'           => '#ERR5975: Premium data not found!'
              ]);
              return false;
          }

          $premiumRow = $premium_data_sql->row();
          
          if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) 
          {
              $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

              $dagRow->final_settlement_area = 'B: '.$total_settlement_area[0].' K: '.$total_settlement_area[1].' C: '.$total_settlement_area[2]. ' G: '.$total_settlement_area[3];
          }
          else
          {
              $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

              $dagRow->final_settlement_area = 'B: '.$total_settlement_area[0].' K: '.$total_settlement_area[1].' L: '.$total_settlement_area[2];
          }

          $landmark = json_decode($dagRow->landmark);

          $dagRow->landmark_entered = 'East - '. $landmark->east. ', West - ' .$landmark->west. ', North - '.$landmark->north. ', South - '.$landmark->south;

          //******reservation area details */
          $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->old_dag));

          if($reservation->num_rows() <= 0)
          {
              $dagRow->road_side_reservation = false;
          }
          else
          {
              $reservation = $reservation->result();

              foreach($reservation as $reservationRow)
              {
                  if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) 
                  {
                      $dagRow->road_side_reservation = 'B: '.$reservationRow->bigha.' K: '.$reservationRow->katha.' C: '.$reservationRow->lessa.' G: '.$reservationRow->ganda;
                  }
                  else
                  {
                      $dagRow->road_side_reservation = 'B: '.$reservationRow->bigha.' K: '.$reservationRow->katha.' L: '.$reservationRow->lessa;
                  }
              }
          }

          $landType = 1;

          // $home_b = $dagRow->home_b;  
          // $home_k = $dagRow->home_k;  
          // $home_lc = $dagRow->home_lc;  
          // $home_g = $dagRow->home_g;

          // $homestead = $home_b + $home_k + $home_lc + $home_g;

          $dagRow->landTypeFinal = $landType;

      }

      $data['dist_array'] = [
          ['dist_code' => '24', 'dist_name' => 'কামৰূপ মহানগৰ ( Kamrup Metro )'],
          ['dist_code' => '12', 'dist_name' => 'লক্ষীমপূৰ ( Lakhimpur )'],
          ['dist_code' => '16', 'dist_name' => 'শিৱসাগৰ ( Sibsagar )'],
          ['dist_code' => '18', 'dist_name' => 'তিনিচুকীয়া ( Tinsukia )'],
          ['dist_code' => '34', 'dist_name' => 'মাজুলী ( Majuli )'],
          ['dist_code' => '37', 'dist_name' => 'চৰাইদেউ ( Charaideo )'],
          ['dist_code' => '11', 'dist_name' => 'শোণিতপুৰ ( Sonitpur )'],
          ['dist_code' => '25', 'dist_name' => 'ধেমাজি ( Dhemaji )'],
          ['dist_code' => '35', 'dist_name' => 'বিশ্বনাথ ( Biswanath )'],
          ['dist_code' => '03', 'dist_name' => 'গোৱালপাৰা ( Goalpara )'],
          ['dist_code' => '14', 'dist_name' => 'গোলাঘাট ( Golaghat )'],
          ['dist_code' => '13', 'dist_name' => 'বঙাইগাঁও ( Bongaigaon )'],
          ['dist_code' => '08', 'dist_name' => 'দৰং ( Darrang )'],
          ['dist_code' => '17', 'dist_name' => 'ডিব্ৰুগড় ( Dibrugarh )'],
          ['dist_code' => '36', 'dist_name' => 'হোজাই ( Hojai )'],
          ['dist_code' => '32', 'dist_name' => 'মৰিগাওঁ ( Morigaon )'],
          ['dist_code' => '39', 'dist_name' => 'বজালী ( Bajali )'],
          ['dist_code' => '15', 'dist_name' => 'যোৰহাট ( Jorhat )'],
          ['dist_code' => '21', 'dist_name' => 'করিমগঞ্জ ( Karimganj )'],
          ['dist_code' => '10', 'dist_name' => 'ছিৰাং ( Chirang )'],
          ['dist_code' => '22', 'dist_name' => 'Hailakandi'],
          ['dist_code' => '23', 'dist_name' => 'Cachar'],
          ['dist_code' => '38', 'dist_name' => 'দক্ষিণ শালমাৰা ( South Salmara )'],
          ['dist_code' => '02', 'dist_name' => 'ধুবুৰী ( Dhubri )'],
          ['dist_code' => '05', 'dist_name' => 'বৰপেটা  ( Barpeta )'],
          ['dist_code' => '27', 'dist_name' => 'Udalguri'],
          ['dist_code' => '33', 'dist_name' => 'নগাওঁ ( Nagaon )'],
          ['dist_code' => '06', 'dist_name' => 'নলবাৰী ( Nalbari )'],
          ['dist_code' => '07', 'dist_name' => 'কামৰূপ ( Kamrup )'],
          ['dist_code' => '01', 'dist_name' => 'কোকৰাঝাৰ (Kokrajhar)'],
      ];

      $data['user_data'] = [
          'user_dist_code' => $this->session->userdata('dist_code'),
          'user_subdiv_code' => $this->session->userdata('subdiv_code'),
          'user_cir_code' => $this->session->userdata('cir_code'),
          'user_mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
          'user_lot_no' => $this->session->userdata('lot_no'),
      ];

      $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();
      $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'))->result();


      $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

      $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($case_no, $case_no));
      
      if($nominee->num_rows() <= 0)
      {
          $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($application_no, $application_no));
      }

      if($nominee->num_rows() <= 0)
      {
          $data['nominee'] = false;
      }
      else
      {
          $data['nominee'] = $nominee->result();

          foreach($data['nominee'] as $nomRow)
          {
              $nomRow->relation_decoded = $this->utilityclass->getrelationByID($nomRow->relation);
          }
      }

      $addededNomSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));
      
      if($addededNomSql->num_rows() <= 0)
      {
          $data['transactionNom'] = false;
      }
      else
      {
          $data['transactionNom'] = $addededNomSql->result();

          foreach($data['transactionNom'] as $nomTranRow)
          {
              $nomTranRow->relation_decoded = $this->utilityclass->getrelationByID($nomTranRow->relation);
          }

      }

      echo json_encode($data);

  }

  public function getSubdivTeaGrant($district)
  {
      $this->dbswitchmb2($district);
      $subdiv = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
      from location where dist_code='$district' and subdiv_code != '00' and cir_code='00' and  mouza_pargona_code='00' and
      vill_townprt_code='00000' and lot_no='00' order by loc_name ");

      $data = $subdiv->result();
      $json = array();
      foreach ($data as $object) {
          /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
          ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ))
          {
          continue;
          }*/
          $json[] = array('subdiv_code' => trim($object->subdiv_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
      }
      //var_dump($json);
      echo json_encode($json);
      //$this->dbswitch();
  }


  public function getCircleTeaGrant($district, $subdiv)
  {
      $this->dbswitchmb2($district);
      $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
      from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code!='00' and  mouza_pargona_code='00' and
      vill_townprt_code='00000' and lot_no='00' order by loc_name ");

      $data = $circle->result();
      $json = array();
      foreach ($data as $object) {
          /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
          ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ))
          {
          continue;
          }*/
          $json[] = array('cir_code' => trim($object->cir_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
      }
      //var_dump($json);
      echo json_encode($json);
      //$this->dbswitch();
  }

  public function getMouzaTeaGrant($district, $subdiv, $circle)
  {
      $this->dbswitchmb2($district);
      $mouza = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
      from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code!='00' and
      vill_townprt_code='00000' and lot_no='00' order by loc_name ");

      $data = $mouza->result();
      $json = array();
      foreach ($data as $object) {
          /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
          ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ))
          {
          continue;
          }*/
          $json[] = array('mouza_pargona_code' => trim($object->mouza_pargona_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
      }
      //var_dump($json);
      echo json_encode($json);
      //$this->dbswitch();
  }

  public function getLotTeaGrant($district, $subdiv, $circle, $mouza)
  {
      $this->dbswitchmb2($district);
      $lot = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
      from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code='$mouza' and vill_townprt_code='00000' and lot_no!='00' order by loc_name ");

      $data = $lot->result();
      $json = array();
      foreach ($data as $object) {
          /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
          ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ))
          {
          continue;
          }*/
          $json[] = array('lot_no' => trim($object->lot_no), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
      }
      //var_dump($json);
      echo json_encode($json);
      //$this->dbswitch();
  }

  public function getVillageTeaGrant($district, $subdiv, $circle, $mouza, $lot)
  {
      $this->dbswitchmb2($district);
      $village = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
      from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code='$mouza' and vill_townprt_code!='00000' and lot_no='$lot' order by loc_name ");

      $data = $village->result();
      $json = array();
      foreach ($data as $object) {
          /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
          ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
          ))
          {
          continue;
          }*/
          $json[] = array('vill_townprt_code' => trim($object->vill_townprt_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
      }
      //var_dump($json);
      echo json_encode($json);
      //$this->dbswitch();
  }

  public function getAllDagsTeaGrant($district, $subdiv, $circle, $mouza, $lot, $village)
  {

      $this->dbswitchmb2($district);

      $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
          . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle'
      and mouza_Pargona_code='$mouza' and lot_No='$lot' "
          . "and vill_townprt_code='$village' order by dag_no_int");

      $data = $dag->result();
      $json = array();
      foreach ($data as $object) {
          $json[] = array(
              'dag_no' => trim($object->dag_no),
              'dag_no_int' => trim($object->dag_no_int),
          );
      }
      echo json_encode($json);
      //$this->dbswitch();
  }

  public function getRevenueDetailsTeaGrant()
  {
      $land_class_code = $this->input->post('land_class_code');
      $case_no = $this->input->post('case_no');
      $dag_no = $this->input->post('dag_no');
      $dist_code = $this->session->userdata('dist_code');

      $urbanArray = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
      // $ruralArray = array(7,8,9,10,18,19,20,21,22);

      $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and dag_no = ?', array($case_no, $dag_no));

      if($getPremSql->num_rows() <= 0)
      {
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR1260: Premium not found for this dag!'
          ]);
      }

      $premRow = $getPremSql->row();

      $isUrban = 'Rural';
      if(in_array($premRow->area_name, $urbanArray))
      {
          $isUrban = 'Urban';
      }

      $landSql = $this->db->query('select * from revenue_land_class_wise where class_code = ? and ruralurban = ? order by date_entry desc limit 1', array($land_class_code, $isUrban));

      if($landSql->num_rows() <= 0)
      {
          $total_revenue = 15;
      }
      else
      {
          $landRow = $landSql->row();

          $dag_revenue_perbigha = (float)$landRow->dag_revenue_perbigha;
  
          //***calculating revenue in lessa */
          if (in_array($dist_code, json_decode(BARAK_VALLEY)))
          {
              $revenue_in_lessa = $dag_revenue_perbigha/6400;
          }
          else
          {
              $revenue_in_lessa = $dag_revenue_perbigha/100;
          }
  
          //*****total_settlemnet_area in lessa */
          $total_settlement_area_in_lessa = $premRow->total_lessa;
  
          //***calculating total revenue */
          $total_revenue = $total_settlement_area_in_lessa * $revenue_in_lessa;
  
          if($total_revenue < 15)
          {
              $total_revenue = 15;
          }
      }

      //*****calculating the local tax */
      $localTax = $total_revenue/4;

      echo json_encode([
          'responseType'   => 2,
          'revenue'       => $total_revenue,
          'local_tax'     => $localTax,
      ]);
      return;
  }

  public function chithaProcessingDetailsTeaGrant()
  {
      $case_no = $this->input->post('case_no');
      if(empty($case_no))
      {
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR805: Case number not found!',
          ]);
          return false;
      }

      $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

      if($getDagsSql->num_rows() <= 0)
      {
          log_message('error', '#ERR6382: Case not found in settlemnet_dag_details'. $this->db->last_query());
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR6382: Dag details not found!'
          ]);
          return false;
      }

      $data['dagResult'] = $getDagsSql->result();

      $new_patta_type = $this->input->post('new_patta_type');
      $possession_from = $this->input->post('possession_from');

      if(empty($new_patta_type) || empty($possession_from))
      {
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR831: Please enter all required fields!',
          ]);
          return false;
      }

      //****get basic data  */
      $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

      $batch_array = array();

      foreach($data['dagResult'] as $dagRow)
      {
          $landmark_dist_east = $this->input->post('landmark_dist_east'.$dagRow->dag_no);
          $landmark_subdiv_east = $this->input->post('landmark_subdiv_east'.$dagRow->dag_no);
          $landmark_cir_east = $this->input->post('landmark_cir_east'.$dagRow->dag_no);
          $landmark_mouza_east = $this->input->post('landmark_mouza_east'.$dagRow->dag_no);
          $landmark_lot_east = $this->input->post('landmark_lot_east'.$dagRow->dag_no);
          $landmark_village_east = $this->input->post('landmark_village_east'.$dagRow->dag_no);
          $landmark_dag_no_east = $this->input->post('landmark_dag_no_east'.$dagRow->dag_no);

          $landmark_dist_west = $this->input->post('landmark_dist_west'.$dagRow->dag_no);
          $landmark_subdiv_west = $this->input->post('landmark_subdiv_west'.$dagRow->dag_no);
          $landmark_cir_west = $this->input->post('landmark_cir_west'.$dagRow->dag_no);
          $landmark_mouza_west = $this->input->post('landmark_mouza_west'.$dagRow->dag_no);
          $landmark_lot_west = $this->input->post('landmark_lot_west'.$dagRow->dag_no);
          $landmark_village_west = $this->input->post('landmark_village_west'.$dagRow->dag_no);
          $landmark_dag_no_west = $this->input->post('landmark_dag_no_west'.$dagRow->dag_no);
          
          $landmark_dist_north = $this->input->post('landmark_dist_north'.$dagRow->dag_no);
          $landmark_subdiv_north = $this->input->post('landmark_subdiv_north'.$dagRow->dag_no);
          $landmark_cir_north = $this->input->post('landmark_cir_north'.$dagRow->dag_no);
          $landmark_mouza_north = $this->input->post('landmark_mouza_north'.$dagRow->dag_no);
          $landmark_lot_north = $this->input->post('landmark_lot_north'.$dagRow->dag_no);
          $landmark_village_north = $this->input->post('landmark_village_north'.$dagRow->dag_no);
          $landmark_dag_no_north = $this->input->post('landmark_dag_no_north'.$dagRow->dag_no);
          
          $landmark_dist_south = $this->input->post('landmark_dist_south'.$dagRow->dag_no);
          $landmark_subdiv_south = $this->input->post('landmark_subdiv_south'.$dagRow->dag_no);
          $landmark_cir_south = $this->input->post('landmark_cir_south'.$dagRow->dag_no);
          $landmark_mouza_south = $this->input->post('landmark_mouza_south'.$dagRow->dag_no);
          $landmark_lot_south = $this->input->post('landmark_lot_south'.$dagRow->dag_no);
          $landmark_village_south = $this->input->post('landmark_village_south'.$dagRow->dag_no);
          $landmark_dag_no_south = $this->input->post('landmark_dag_no_south'.$dagRow->dag_no);

          $land_class_code_tgpp = $this->input->post('land_class_code_tgpp'.$dagRow->dag_no);


          $revenue_tgpp = $this->input->post('revenue_tgpp'.$dagRow->dag_no);
          $local_tax_tgpp = $this->input->post('local_tax_tgpp'.$dagRow->dag_no);


          $landType = 1;

          // $home_b = $dagRow->home_b;  
          // $home_k = $dagRow->home_k;  
          // $home_lc = $dagRow->home_lc;  
          // $home_g = $dagRow->home_g;

          // $homestead = $home_b + $home_k + $home_lc + $home_g;

          if(empty($revenue_tgpp))
          {
              echo json_encode([
                  'responseType'  => 0,
                  'msg'           => '#ERR1050: Please Enter revenue details...',
              ]);
              return false;
          }

          if(!empty($revenue_tgpp))
          {
              if(empty($local_tax_tgpp))
              {
                  echo json_encode([
                      'responseType'  => 0,
                      'msg'           => '#ERR1061: Please Enter Local tax details...',
                  ]);
                  return false;
              }
          }

          $revenue_tgpp       = $this->UtilsModel->defaultValue($revenue_tgpp, 0);
          $local_tax_tgpp     = $this->UtilsModel->defaultValue($local_tax_tgpp, 0);


          if(empty($landmark_dist_east) || empty($landmark_subdiv_east) || empty($landmark_cir_east) || empty($landmark_mouza_east) || empty($landmark_lot_east) || empty($landmark_village_east) || empty($landmark_dag_no_east) || empty($landmark_dist_west) || empty($landmark_subdiv_west) || empty($landmark_cir_west) || empty($landmark_mouza_west) || empty($landmark_lot_west) || empty($landmark_village_west) || empty($landmark_dag_no_west) || empty($landmark_dist_north) || empty($landmark_subdiv_north) || empty($landmark_cir_north) || empty($landmark_mouza_north) || empty($landmark_lot_north) || empty($landmark_village_north) || empty($landmark_dag_no_north) || empty($landmark_dist_south) || empty($landmark_subdiv_south) || empty($landmark_cir_south) || empty($landmark_mouza_south) || empty($landmark_lot_south) || empty($landmark_village_south) || empty($landmark_dag_no_south))
          {
              echo json_encode([
                  'responseType'  => 0,
                  'msg'           => '#ERR870: Please enter all landmark details!',
              ]);
              return false;
          }


          $landmark_dist_east_name = $this->utilityclass->getDistrictName($landmark_dist_east);
          $landmark_subdiv_east_name = $this->utilityclass->getSubDivName($landmark_dist_east, $landmark_subdiv_east);
          $landmark_cir_east_name = $this->utilityclass->getCircleName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east);
          $landmark_mouza_east_name = $this->utilityclass->getMouzaName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east);
          $landmark_lot_east_name = $this->utilityclass->getLotName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east, $landmark_lot_east);
          $landmark_village_east_name = $this->utilityclass->getVillageName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east, $landmark_lot_east, $landmark_village_east);

          $landmark_dist_west_name = $this->utilityclass->getDistrictName($landmark_dist_west);
          $landmark_subdiv_west_name = $this->utilityclass->getSubDivName($landmark_dist_west, $landmark_subdiv_west);
          $landmark_cir_west_name = $this->utilityclass->getCircleName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west);
          $landmark_mouza_west_name = $this->utilityclass->getMouzaName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west);
          $landmark_lot_west_name = $this->utilityclass->getLotName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west, $landmark_lot_west);
          $landmark_village_west_name = $this->utilityclass->getVillageName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west, $landmark_lot_west, $landmark_village_west);

          $landmark_dist_north_name = $this->utilityclass->getDistrictName($landmark_dist_north);
          $landmark_subdiv_north_name = $this->utilityclass->getSubDivName($landmark_dist_north, $landmark_subdiv_north);
          $landmark_cir_north_name = $this->utilityclass->getCircleName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north);
          $landmark_mouza_north_name = $this->utilityclass->getMouzaName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north);
          $landmark_lot_north_name = $this->utilityclass->getLotName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north, $landmark_lot_north);
          $landmark_village_north_name = $this->utilityclass->getVillageName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north, $landmark_lot_north, $landmark_village_north);
          
          $landmark_dist_south_name = $this->utilityclass->getDistrictName($landmark_dist_south);
          $landmark_subdiv_south_name = $this->utilityclass->getSubDivName($landmark_dist_south, $landmark_subdiv_south);
          $landmark_cir_south_name = $this->utilityclass->getCircleName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south);
          $landmark_mouza_south_name = $this->utilityclass->getMouzaName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south);
          $landmark_lot_south_name = $this->utilityclass->getLotName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south, $landmark_lot_south);
          $landmark_village_south_name = $this->utilityclass->getVillageName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south, $landmark_lot_south, $landmark_village_south);

          
          $landmark_name = [
              'east' => $landmark_dist_east_name.', '. $landmark_subdiv_east_name.', '.$landmark_cir_east_name.', '.$landmark_mouza_east_name.', '.$landmark_lot_east_name.', '.$landmark_village_east_name.', '.$landmark_dag_no_east,
              
              'west' => $landmark_dist_west_name.', '. $landmark_subdiv_west_name.', '.$landmark_cir_west_name.', '.$landmark_mouza_west_name.', '.$landmark_lot_west_name.', '.$landmark_village_west_name.', '.$landmark_dag_no_west,
              
              'north' => $landmark_dist_north_name.', '. $landmark_subdiv_north_name.', '.$landmark_cir_north_name.', '.$landmark_mouza_north_name.', '.$landmark_lot_north_name.', '.$landmark_village_north_name.', '.$landmark_dag_no_north,

              'south' => $landmark_dist_south_name.', '. $landmark_subdiv_south_name.', '.$landmark_cir_south_name.', '.$landmark_mouza_south_name.', '.$landmark_lot_south_name.', '.$landmark_village_south_name.', '.$landmark_dag_no_south,
          ];

          $landmark_with_code = [
              'east' => [
                      'dist_code'             => $landmark_dist_east,
                      'subdiv_code'           => $landmark_subdiv_east,
                      'cir_code'              => $landmark_cir_east,
                      'mouza_pargona_code'    => $landmark_mouza_east,
                      'lot_no'                => $landmark_lot_east,
                      'vill_townprt_code'     => $landmark_village_east,
                      'dag_no'                => $landmark_dag_no_east,
                  ],
              
              'west' => [
                      'dist_code'             => $landmark_dist_west,
                      'subdiv_code'           => $landmark_subdiv_west,
                      'cir_code'              => $landmark_cir_west,
                      'mouza_pargona_code'    => $landmark_mouza_west,
                      'lot_no'                => $landmark_lot_west,
                      'vill_townprt_code'     => $landmark_village_west,
                      'dag_no'                => $landmark_dag_no_west,
                  ],
                  
              'north' => [
                      'dist_code'             => $landmark_dist_north,
                      'subdiv_code'           => $landmark_subdiv_north,
                      'cir_code'              => $landmark_cir_north,
                      'mouza_pargona_code'    => $landmark_mouza_north,
                      'lot_no'                => $landmark_lot_north,
                      'vill_townprt_code'     => $landmark_village_north,
                      'dag_no'                => $landmark_dag_no_north,
                  ],

              'south' => [
                      'dist_code'             => $landmark_dist_south,
                      'subdiv_code'           => $landmark_subdiv_south,
                      'cir_code'              => $landmark_cir_south,
                      'mouza_pargona_code'    => $landmark_mouza_south,
                      'lot_no'                => $landmark_lot_south,
                      'vill_townprt_code'     => $landmark_village_south,
                      'dag_no'                => $landmark_dag_no_south,
                  ],
          ];

          //****insert in settlement_approval_transaction */
          $insertArr = [
              'case_no'                   => $case_no,
              'dag_no'                    => $dagRow->dag_no,
              'patta_type_code'           => $new_patta_type,
              'possession_from'           => $possession_from,
              'landclass_home'            => $land_class_code_tgpp,
              'landmark_with_code'        => json_encode($landmark_with_code),
              'landmark'                  => json_encode($landmark_name),
              'date_entry'                => date('Y-m-d H:i:s'),             
              'new_home_land_revenue'     => $revenue_tgpp,
              'new_home_land_local_tax'   => $local_tax_tgpp,
              'new_total_revenue'         => (float)$revenue_tgpp,
              'new_total_tax'             => (float)$local_tax_tgpp,
          ];
          $batch_array[] = $insertArr;
      }
      
      $this->dbswitch();

      $this->db->trans_begin();

      $checkIfAlreadyEnt = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));
      
      if($checkIfAlreadyEnt->num_rows() > 0)
      {
          $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));

          if($this->db->affected_rows() != count($batch_array))
          {
              $this->db->trans_rollback();
              echo json_encode([
                  'responseType'  => 0,
                  'msg'           => '#ERR812: Something went wrong! Unable to process...',
              ]);
              return false;
          }
      }

      $insert_count = $this->db->insert_batch('settlement_approval_transaction',$batch_array);

      if(count($batch_array) != $insert_count)
      {
          $this->db->trans_rollback();
          echo json_encode([
              'responseType' => 0,
              'msg' => '#JS0053: Something went wrong!'
          ]);
          return false;
      }

      //*****update settlement_basic */

      $basicArr = [
          'chitha_processing_details' => 1,
          'date_update'               => date('Y-m-d H:i:s'),
          'pending_officer'           => 'ADC',
          'pending_office'            => 'DC',
      ];

      $this->db->where('case_no', $case_no);
      $this->db->update('settlement_basic', $basicArr);

      if($this->db->affected_rows() != 1)
      {
          $this->db->trans_rollback();
          log_message('error', '#ERR1000: Unable to update settlement_basic!'. $this->db->last_query());
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR1000: Unable to save data!',
          ]);
          return false;
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=? ",[$case_no])->row()->c;

      if ($proceeding_id == null) {
          $proceeding_id = 1;
      }

      $insPetProceed = [
          'case_no' => $case_no,
          'proceeding_id' => $proceeding_id,
          'date_of_hearing' => date('Y-m-d h:i:s'),
          'next_date_of_hearing' => date('Y-m-d h:i:s'),
          'note_on_order' => 'LM Re-verify report submitted',
          'status' => 'N',
          'user_code' => $this->session->userdata('user_code'),
          'date_entry' => date('Y-m-d h:i:s'),
          'operation' => 'E',
          'ip' => $this->utilityclass->get_client_ip(),
          'office_from' => 'LM',
          'office_to' => 'CO',
          'task' => 'LM Re-verify report submitted',
          // 'note_type' => $this->input->post('lm_note'),
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) 
      {
          $this->db->trans_rollback();
          echo json_encode([
              'responseType'  => 0,
              'msg'           => '#ERR2403: Unable to approve report!',
          ]);
          return false;
      }


      $this->db->trans_commit();
      echo json_encode([
          'responseType'  => 2,
          'msg'           => 'success',
      ]);
      return;
  }

 
}
