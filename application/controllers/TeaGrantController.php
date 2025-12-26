<?php
class TeaGrantController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('file');
    $this->load->helper('download');
    $this->load->model('basundhara/SettlementApiModel');    
    $this->load->model('SettlementModel/SettlementApModel');
    $this->load->model('TeaGrant/LM/TeaGrantModel');
    $this->load->model('SettlementModel/SettlementVgrModel');
    $this->load->model('SettlementModel/SettlementCommonModel');
    $this->load->library('AES');    
    $this->load->model('UtilsModel');
    $this->load->model('NcModel/NcCommonModel');
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

    // var_dump($recordExist); die;

    if(!$recordExist)
    {
      /// additional property for LM note
      $additional_property = $this->db->query("SELECT * FROM      settlement_additional_property WHERE applid='$application_no'");
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

      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $application_no,
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
      $backup = $output;

      $output = json_decode($output);

      // echo "<pre>";var_dump($output); die;

      //****************generate case number********************
      $case_name=$this->SettlementApiModel->genearteCaseName();
      if(empty($case_name))
      {
        $data = array(
          'error' => "Network Issue or Session Out. Please try Again"
        );
        echo json_encode($data);
        die();
      }
      //*******generating petition_no and case_no */
      $case_no['petition_no'] = $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
      $case_no['case_no']     = $case_name.$petition_no."/".TEA_PREFIX;
      $district['geo_date']   = $geo_date;
      $district['app']        = $output->application;
      $district['pattaNo']    = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

      $district['applicants']   = $output->applicants;
      $district['document']     = $output->documents;
      $district['query']        = $output->query;
      $district['property']     = $output->property;
      $district['settlements']  = $output->settlements;
      $district['encroachers']  = $output->encroachers;
      $district['owners']       = $output->owners;
      $district['riotee_noks']  = $output->riotee_noks;
      $district['aadhar']       = $output->aadhar;
      $district['nextKin']      = $output->nextKin;
      $district['teaDagDetail'] = $output->teadags;

      // get khatian number
      $d   = $district['app']->dist_code;
      $s   = $district['app']->subdiv_code;
      $c   = $district['app']->cir_code;
      $m   = $district['app']->mouza_code;
      $l   = $district['app']->lot_no;
      $v   = $district['app']->village_code;
      $dag = $district['app']->dag_no;

      $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
      $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

      $district['bhumi']  = $output->bhumi;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
      $row = $relation_executation->num_rows();

      if ($row != 0) {
        $district['guar_rel'] = $relation_executation->result();
      }

      if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
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

      $vlb_encc = [];
      if($output->encroachers == true)
      {
        $district['riotee'] = $output->encroachers;
        foreach($output->encroachers as $encroacher){
          $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

          $district['vlb_enc'] = $vlb_encroacher;

          if($vlb_encroacher == true){
            // getting the encroacher details
            $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
            $vlb_encc[] = $vlb_encroacher_in_dag;
          }else{
            $district['empty_err'] = "No Land Bank Details found!!";
          }
        }
        $district['vlb_enc_details']=$vlb_encc;
      }

      // aadhaar photo api
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $application_no,
      )));
      $get_aadhaar_photo = curl_exec($curl_handle);
      curl_close($curl_handle);

      if($get_aadhaar_photo != 'n'){
        $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
      }

      $this->db->trans_begin();

      // insertion in backup table (lm)
      $backup_array = [
        'applid'  => $application_no,
        'case_no' => $case_no['case_no'],
        'status'  => 'I',
        'data'    => $backup
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
      $checkAdditionalProperty = $this->db->query("SELECT * FROM 
                                    settlement_additional_property 
                                      WHERE applid=?", array($application_no));

      if($checkAdditionalProperty->num_rows() == 0){
        if(isset($output->property)) {
          foreach($output->property as $value) {
            $add_property = array(
              'case_no'            => $case_no['case_no'],
              'dist_code'          => $value->dist_code,
              'subdiv_code'        => $value->subdiv_code,
              'cir_code'           => $value->cir_code,
              'mouza_pargona_code' => $value->mouza_pargona_code,
              'lot_no'             => $value->lot_no,
              'vill_townprt_code'  => $value->vill_townprt_code,
              'bigha'              => $value->bigha,
              'katha'              => $value->katha,
              'lessa'              => $value->lessa,
              'chatak'             => $value->lessa,
              'ganda'              => $value->ganda,
              'kranti'             => $value->kranti,
              'entry_date'         => date('Y-m-d H:i:s'),
              'is_rural'           => $value->is_rural,
              'dag_no'             => $value->dag_no,
              'patta_no'           => $value->patta_no,
              'service_id'         => TEA_SERVICE_CODE,
              'applied_flag'       => CITIZEN,
              'dist_name'          => trim($value->dist_name),
              'cir_name'           => trim($value->cir_name),
              'vill_name'          => trim($value->vill_name),
              'applid'             => $application_no,
            );
            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

            if($insAddProperty != 1) {
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


      $pro_class          = $this->input->post('protected_class');
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

      // echo "<pre>";
      // var_dump($district['applicants'][0]); die;

      //********settlement_basic insertation */
      $basic=array(
        'dist_code'                   => $district['app']->dist_code,
        'subdiv_code'                 => $district['app']->subdiv_code,
        'cir_code'                    => $district['app']->cir_code,
        'mouza_pargona_code'          => $district['app']->mouza_code,
        'lot_no'                      => $district['app']->lot_no,
        'vill_townprt_code'           => $district['app']->village_code,
        'service_code'                => $district['app']->service_code,
        'ref_no'                      => $district['app']->ref_no,
        'case_no'                     => $case_no['case_no'],
        'trans_code'                  => 'F',/////////full
        'petition_no'                 => $case_no['petition_no'],
        'year_no'                     => date('Y'),
        'date_entry'                  => date('Y-m-d G:i:s'),
        'status'                      => 'Z',
        'user_code'                   => $this->session->userdata('user_code'),
        'submission_date'             => date('Y-m-d G:i:s'),
        'from_office'                 => 'API',
        'pending_officer'             => 'LM',
        'pending_office'              => 'CO',
        'occupation_applicant'        => $district['applicants'][0]->occupation,
        'applid'                      => $district['app']->application_no,
        'caste'                       => $district['applicants'][0]->caste,
        'uuid'                        => $district['app']->uuid,
        'protected_class'             => $protected_class_vr,
        'bhumiputra_confirmation'     => $bhumiputra_confirmation,
        'bhumiputra_certificate_no'   => $bhumiputra_certificate_no,
        'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
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

      // echo "<pre>"; var_dump($district['teaDagDetail']); die;

      ////settlement_dag_details insert start
      if ($district['teaDagDetail'] == false || empty($district['teaDagDetail']) || $district['teaDagDetail'] == '') {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET00443: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

          $data = array(
              'error'=>"#ERRSET00443: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
      }
      foreach ($district['teaDagDetail'] as $dags) {

        // var_dump($dags); die;

        $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

        // var_dump($district['class']); die;

        $applied_bigha  = $dags->bigha;
        $applied_katha  = $dags->katha;
        $applied_lessa  = $dags->lessa;
        $applied_ganda  = $dags->ganda;
        $applied_kranti = $dags->kranti;

        $applied_area = [
          'applied_bigha'  => $dags->bigha,
          'applied_katha'  => $dags->katha,
          'applied_lessa'  => $dags->lessa,
          'applied_ganda'  => $dags->ganda,
          'applied_kranti' => $dags->kranti,
        ];

        // echo "<pre>"; var_dump($dags); die;

        $fmd = array(
          'dist_code'           => $district['app']->dist_code,
          'subdiv_code'         => $district['app']->subdiv_code,
          'cir_code'            => $district['app']->cir_code,
          'mouza_pargona_code'  => $district['app']->mouza_code,
          'lot_no'              => $district['app']->lot_no,
          'vill_townprt_code'   => $district['app']->village_code,
          'user_code'           => $this->session->userdata('user_code'),
          'date_entry'          => date('Y-m-d'),
          'case_no'             => $case_no['case_no'],
          'petition_no'         => $case_no['petition_no'],
          'year_no'             => date('Y'),
          'new_land_class_code' => $district['class']->land_class_code,
          'dag_no'              => $dags->dag_no,
          'patta_no'            => $dags->patta_no,
          'patta_type_code'     => $dags->patta_type_code,
          'is_urban'            => $district['app']->is_urban,
          'land_type'           => 0,
          'revenue'             => 0,
          'operation'           => 'E',
          'encroachement_area'  => json_encode($applied_area),
        );

        $fmd['dag_area_b']  = $dags->chitha_bigha;
        $fmd['dag_area_k']  = $dags->chitha_katha;
        $fmd['dag_area_lc'] = $dags->chitha_lessa;
        $fmd['dag_area_g']  = $dags->chitha_ganda;
        $fmd['dag_area_kr'] = $dags->chitha_kranti;

        $fmd['applied_b']   = $dags->bigha;
        $fmd['applied_k']   = $dags->katha;
        $fmd['applied_lc']  = $dags->lessa;
        $fmd['applied_g']   = $dags->ganda;
        $fmd['applied_kr']  = $dags->kranti;

        //************Total Area Calculation -js- ******************
        if(in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
        {
          //******for Barak valley */
          $appliedArea    = $this->utilityclass->Total_ganda($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc'],$fmd['applied_g'],$fmd['applied_kr']);
          $totalAreaGanda = (float)$appliedArea;
          $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
        }
        else
        {
          $appliedArea    = $this->utilityclass->Total_Lessa($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc']);
          $totalAreaLessa = (float)$appliedArea;
          $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
        }

        $fmd['s_dag_area_b']  = $totalAreaArr[0];
        $fmd['s_dag_area_k']  = $totalAreaArr[1];
        $fmd['s_dag_area_lc'] = $totalAreaArr[2];
        $fmd['s_dag_area_g']  = $totalAreaArr[3];
        $fmd['s_dag_area_kr'] = 0;

        $landTypeUpdate = 0;

        $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
        // echo $this->db->last_query();die;
        // log_message('error',$this->db->last_query());

        if ($insSetDag != 1) {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
          $data = array(
            'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
        }

        //*******insertion in settlement_area_history**************
        if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
        {
          //***********actual Applied area ***************
          $actual_applied_area_ganda = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

          //***********total Actual Applied area*****************
          $total_actual_applied_area_ganda = (float)$actual_applied_area_ganda;
          $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_applied_area_ganda);
          // **********************************************


          //***********Settlement area that applicant will get settlement on***********
          $total_settlement_ganda_tea_grant = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

          //*****total Settlement area *************/
          $total_settlement_ganda = (float)$total_settlement_ganda_tea_grant;
          $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

          //*************leftout area **************
          $leftOutAreaTeaGrantGanda = (float)$actual_applied_area_ganda - (float)$total_actual_applied_area_ganda;
          $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaTeaGrantGanda);

          //**********Total left out area***************
          $totalLeftOutAreaGanda = (float)$total_actual_applied_area_ganda - (float)$total_settlement_ganda;
          $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
        }
        else
        {
          //***********actual Applied area ***************
          $actual_applied_area_lessa = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

          //***********total Actual Applied area*****************
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

        $settlementAreaHistoryArr = [
          'application_no'                        => $application_no,
          'case_no'                               => $case_no['case_no'],
          'dag_no'                                => $dags->dag_no,
          'uuid'                                  => $district['app']->uuid,
          'created_at'                            => date('Y-m-d'),
          'applied_area_home_bigha'               => $dags->bigha,
          'applied_area_home_katha'               => $dags->katha,
          'applied_area_home_lessa'               => $dags->lessa,
          'applied_area_home_ganda'               => $dags->ganda,
          'applied_area_home_kranti'              => $dags->kranti,
          'applied_area_agri_bigha'               => 0,
          'applied_area_agri_katha'               => 0,
          'applied_area_agri_lessa'               => 0,
          'applied_area_agri_ganda'               => 0,
          'applied_area_agri_kranti'              => 0,
          'actual_encroachment_area_home_bigha'   => $dags->bigha,
          'actual_encroachment_area_home_katha'   => $dags->katha,
          'actual_encroachment_area_home_lessa'   => $dags->lessa,
          'actual_encroachment_area_home_ganda'   => $dags->ganda,
          'actual_encroachment_area_home_kranti'  => $dags->kranti,
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
          'settlement_area_home_bigha'            => $dags->bigha,
          'settlement_area_home_katha'            => $dags->katha,
          'settlement_area_home_lessa'            => $dags->lessa,
          'settlement_area_home_ganda'            => $dags->ganda,
          'settlement_area_home_kranti'           => $dags->kranti,
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

        if ($insertSetlArea != 1) {
          $this->db->trans_rollback();
          log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
          $data = array(
            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no,
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
      foreach ($district['applicants'] as $setl) 
      {
        if($setl->is_applicant == 1)
        {
          $present_add   = $setl->entered_add1;
          $permanent_add = $setl->entered_add2;
        }        
      }

      // echo "<pre>"; var_dump($district['applicants']); die;

      foreach ($district['applicants'] as $setl) 
      {
        if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1') 
        {
          $timestamp = date('mdYhis', time()).uniqid();
          $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
          // creating and saving the base64 format payment notice to uploads/paymentNotice folder
          $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
          $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
          $aadhaar_encoded_file = $get_aadhaar_photo;
          fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
          fclose($aadhaar_file_to_write_base64);
        }
        else{
          $aadhar_path = '';
        }

        if($district['aadhar']->type == 'AADHAAR'){
          $identity_ref_no = $district['aadhar']->aadhaar_no;
        }else{
          $identity_ref_no = $district['aadhar']->pan_no;
        }

        // echo "<pre>"; var_dump($setl->is_applicant); var_dump($setl->possession_from); die;

        if($setl->pdar_type == 'B')
        {
          $applicant=array(
            'dist_code'           => $district['app']->dist_code,
            'subdiv_code'         => $district['app']->subdiv_code,
            'cir_code'            => $district['app']->cir_code,
            'mouza_pargona_code'  => $district['app']->mouza_code,
            'lot_no'              => $district['app']->lot_no,
            'vill_townprt_code'   => $district['app']->village_code,
            'user_code'           => $this->session->userdata('user_code'),
            'case_no'             => $case_no['case_no'],
            'petition_no'         => $case_no['petition_no'],
            'operation'           => 'E',
            'dag_no'              => 0,
            'patta_no'            => 0,
            'patta_type_code'     => 0,
            'year_no'             => date('Y'),
            'date_entry'          => date('Y-m-d'),
            'pdar_id'             => '-1',
            'pdar_cron_no'        => (int) $cron_no++,
            'pdar_name'           => $setl->pdar_name,
            'pdar_guardian'       => $setl->pdar_father,
            'eng_pdar_name'       => $setl->pdar_name_eng,
            'eng_pdar_guardian'   => $setl->pdar_father_eng,
            'pdar_rel_guar'       => $setl->relation,
            'pdar_gender'         => $setl->pdar_gender,
            'pdar_add1'           => $present_add,
            'pdar_add2'           => $permanent_add,
            'pdar_mobile'         => $setl->mobile_no,
            'pdar_type'           => $setl->pdar_type,
            'is_applicant'        => $setl->is_applicant,
            'identity_ref_no'     => $identity_ref_no,
            'identity_type'       => $district['aadhar']->type,
            'identity_doc_link'   => $aadhar_path,
            'marital_status'      => $setl->marital_status,
            'dob'                 => $setl->dob,
            'period_possession'   => $setl->is_applicant == 1 ? $setl->possession_from: '',
          );
        }

        $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
        // echo $this->db->last_query(); die();

        if ($insSetApplicant != 1) {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
          $data = array(
            'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
        }
      }

      // var_dump($district['settlements']); die;

      // insert other pdar type
      foreach ($district['settlements'] as $setl) 
      {
        if($setl->pdar_type != 'B')
        {
          $otherApplicant=array(
            'dist_code'           => $district['app']->dist_code,
            'subdiv_code'         => $district['app']->subdiv_code,
            'cir_code'            => $district['app']->cir_code,
            'mouza_pargona_code'  => $district['app']->mouza_code,
            'lot_no'              => $district['app']->lot_no,
            'vill_townprt_code'   => $district['app']->village_code,
            'user_code'           => $this->session->userdata('user_code'),
            'case_no'             => $case_no['case_no'],
            'petition_no'         => $case_no['petition_no'],
            'operation'           => 'E',
            'dag_no'              => $setl->dag_no,
            'patta_no'            => $setl->patta_no,
            'patta_type_code'     => $setl->patta_type_code,
            'year_no'             => date('Y'),
            'date_entry'          => date('Y-m-d'),
            'pdar_id'             => '-1',
            'pdar_cron_no'        => (int) $cron_no++,
            'pdar_name'           => $setl->pdar_name,
            'pdar_guardian'       => $setl->pdar_father,
            'eng_pdar_name'       => $setl->pdar_name_eng,
            'eng_pdar_guardian'   => $setl->pdar_father_eng,
            'pdar_rel_guar'       => 0,
            'pdar_gender'         => 0,
            'pdar_add1'           => $present_add,
            'pdar_add2'           => $permanent_add,
            'pdar_mobile'         => $setl->mobile_no,
            'pdar_type'           => $setl->pdar_type,
            'is_applicant'        => $setl->is_applicant,
            'identity_ref_no'     => $identity_ref_no,
            'identity_type'       => $district['aadhar']->type,
            'identity_doc_link'   => '',
            'marital_status'      => $setl->marital_status,
            'dob'                 => $setl->dob,
          );
                

          $insOtherApplicant = $this->db->insert('settlement_applicant', $otherApplicant);
          // echo $this->db->last_query(); 
          // var_dump($insOtherApplicant);

          if($insOtherApplicant != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET820: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
            $data = array(
              'error'=>"#ERRSET820: Registration of Settlement failed for case no : ".$application_no
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
            'case_no'       => $case_no['case_no'],
            'nominee_name'  => $nex_of_kin->next_of_kin_name,
            'address'       => $nex_of_kin->address,
            'mobile_no'     => $nex_of_kin->mobile_no,
            'relation'      => $nex_of_kin->relation_with_kin
          );
          $insNominee = $this->db->insert('settlement_nominee', $nominee_data);            

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
        'dharitree'     => $case_no['case_no'],
        'basundhara'    => $application_no,
        'date_reg'      => date('Y-m-d'),
        'reg_by'        => $this->session->userdata('user_code'),
        'app_status'    => 'M',
        'pending_with'  => 'LM'
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
      }
      else {
        $this->db->trans_commit();
      }
    }
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


      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no='$case_no' and is_final=1")->row();
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

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree='$case_no' ";
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
        if($adhar_photo->is_applicant == 1):
          if (trim($adhar_photo->identity_type) == 'AADHAAR'):
            $adhar_photo_link = $adhar_photo->identity_doc_link;
                // var_dump(file_exists($adhar_photo_link)); die;


            if(!file_exists($adhar_photo_link))
            {
              $url = API_LINK_MB3."getApplicantPhoto";
              $arrayData =array(
                'application_no' => $application_no,
              );
              //*****API call again for aadhar photo missing */
              $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);

              // var_dump($aadhaarPhotoReCall); die;
              if($aadhaarPhotoReCall == true)
              {
                $aadhar_path = $adhar_photo_link;

                // var_dump($aadhar_path);

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
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

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
      $additional_property = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid='$application_no'");
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


    // initial tea grant view through API
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $lmdata['_view'] = 'TeaGrant/LM/TeaGrantLM';
      $this->load->view('layouts/main',$lmdata);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      
      $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid='$case_no'")->row();
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
      if($mStatErr == true)
      {
        $data = array(
          'error' => '#ERR14233: Spouse details has to be added if you SELECT applicant as married!!!' .$case_no,
        );
        echo json_encode($data);
        return false;
      }

      //  row_array
      $basic              = $this->TeaGrantModel->getSettlementBasic($case_no);
      //  result
      $applicants_buyers  = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners  = $this->TeaGrantModel->getAllApplicantOwners($case_no);

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

      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no='$case_no' and is_final=1")->row();
      $lmdata['premiumData'] = $premiumData;
      /// premium end

      $lmdata['basic']             = $basic;
      $lmdata['geo_date']          = $geo_date;
      $lmdata['applicants_buyers'] = $applicants_buyers;
      $lmdata['applicants_owners'] = $applicants_owners;

      $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);

        // var_dump($lmdata['reservation']); die;


      $lmdata['dags']             = $dags;
      $lmdata['lmnotes']          = $lmnotes;
      $lmdata['proceedings']      = $proceedings;
      $lmdata['dhardocuments']    = $dhardocuments;  

      // var_dump($lmdata['proceedings']); die;      

        //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree='$case_no' ";
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
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
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

      // For insertion of settlement khasland 
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

      // var_dump($_POST['lm_note']); die;

      if($_POST['lm_note'] == '2')
      {
          if(isset($_POST['rejected_reasons']))
          {

              $validation_bypass_array = $this->getValidationBypass(TEA_SERVICE_CODE);

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
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Whether Tribal', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
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
            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
            redirect(base_url() . "index.php/home");
          }

          $this->form_validation->set_rules('nature_possession'.$dag_area_cal->dag_no, 'Nature of Possession', 'trim|required');
          // new premium addition
          // $this->form_validation->set_rules('area'.$dag_area_cal->dag_no, 'SELECT Area Type', 'trim|required');
          // $this->form_validation->set_rules('area_new'.$dag_area_cal->dag_no, 'SELECT Area Type', 'trim|required');

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
        $additional_properties      = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid='$application_no'")->result();

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

        $checkUrbanCon = trim($this->input->post('is_urban'));
        // var_dump($checkUrbanCon); die;

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
            $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (CULTIVATION_MAX_APPLIED + KHAS_MAX_AGRICULTURE) . ' Bigha ! You can SELECT not recommend and proceed!!!', 'required|callback_land_exceed');
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
                    $this->form_validation->set_rules('additional_doc_err','File','required');
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

          //************update in settlement_applicant */

          // echo "<pre>"; var_dump($lmdata['dags']); die;
        // echo "dsfghj"; die;
          // echo "<pre>"; var_dump($_POST); die;



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
            'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
        }

        //update additional property
        $additional_property_check = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid='$application_no'");

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
              'east'  => $landmark_east,
              'west'  => $landmark_west,
              'north' => $landmark_north,
              'south' => $landmark_south,
            ];

            $fmddata= [
              'date_entry'        => date('Y-m-d'),
              'landmark'          => json_encode($landmark),
              'nature_possession' => $this->input->post('nature_possession'.$dagsland->dag_no),
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
              $_FILES['file']['name']     = $_FILES['fileUpload']['name'][$i];
              $_FILES['file']['type']     = $_FILES['fileUpload']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
              $_FILES['file']['error']    = $_FILES['fileUpload']['error'][$i];
              $_FILES['file']['size']     = $_FILES['fileUpload']['size'][$i];

              $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
              $exp  = explode("/",$mime);
              $onlyExtension  = $exp[1];

              $fileRename =  $this->UUID4() . '.' . $onlyExtension;

              $config['upload_path']   = UPLOAD_DIR;
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
                  'file_path'       => UPLOAD_DIR . $fileRename,
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

          $field_report_file = $_FILES['field_report'];


          // For uploading dag wise trace_map_copy
          foreach ($lmdata['dags'] as $dags_doc)
          {
            $timestamp = date('mdYhis', time()).uniqid();

            $trace_map_file = $_FILES['trace_map_copy'.$dags_doc->dag_no];
            $trace_file_name = 'trace_map_copy'.$timestamp;

            //upload trace map file by calling API
            $trace_map_api_file = $this->SettlementCommonModel->uploadFileByApiBase($trace_map_file, $application_no, API_KEY, $trace_file_name);

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


          $field_report_api_file = $this->SettlementCommonModel->uploadFileByApiBase($field_report_file, $application_no, API_KEY, $field_file_name);

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
              'date_entry'      => date('Y-m-d H:i:s'),
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

            if(!move_uploaded_file($field_report_file['tmp_name'], $field_report_path))
            {
              log_message('error', 'Unable to move field report file for case no '.$case_no);
              $this->db->trans_rollback();
              $this->session->set_flashdata('message', "#ERRADDDOC000331: Only PDF and Image files area allowed : ".$application_no);
              redirect(base_url() . "index.php/home");
            }
          }

          //*********if LM if case of case rejected the rejected remarks */

          $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassFalse(TEA_SERVICE_CODE);

          $comment = addslashes($this->input->post('lm_note'));

          $pro_class_lm = $this->input->post('protected_class_lm');
          $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0) ? 0 : $this->input->post('protected_class_lm');

          $lmnote=array(
            'user_code'                 => $this->session->userdata('user_code'),
            'chitha_verified'           => $this->input->post('chitha_verified'),
            'vlb_verified'              => $this->input->post('vlb_verified'),
            'is_tribal_belt'            =>  $this->input->post('is_tribal_belt'),
            'possession_verification'   => $this->input->post('possession_verification'),
            'period_possession'         => $this->input->post('lm_possession_entry'),
            'is_landless'               => $this->input->post('is_landless'),
            'land_falls'                => $this->input->post('land_falls'),
            'falls_und_gmc'             => $this->input->post('falls_und_gmc'),
            'roadside_reservation'      => $this->input->post('roadside_reservation'),
            'zonal_valuation'           => $this->input->post('zonal_valuation'),
            'trace_map_copy'            => 'NA',
            'chitha_copy'               => 'NA',
            'lm_note'                   => $comment,
            'lm_remark_text'            => $this->input->post('lm_remark_text'),
            'date_entry'                => date('Y-m-d H:i:s'),
            'case_no'                   => $case_no,
            'status'                    => 'W',
            'total_bigha'               => $this->input->post('total_bigha'),
            'total_Katha'               => $this->input->post('total_Katha'),
            'total_lessa'               => $this->input->post('total_lessa'),
            'total_ganda'               => $this->input->post('total_ganda'),
            'total_kranti'              => $this->input->post('total_kranti'),
            'landslide'                 => $this->input->post('landslide'),
            'erosion'                   => $this->input->post('erosion'),
            'protected_class_lm'        => $protected_class_lm,
            'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
            'lm_rejected_remarks'       => json_encode($responseMasterObj->reject_remarks)
          );

          $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
          // echo $this->db->last_query();
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

        // update in settlement applicant for possession period

        foreach ($district['applicants'] as $setl) 
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
                'error'=>"#ERRSET2364: Registration of Settlement failed for case no : ".$application_no
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
                  'error'=> "#ERRSET00053: Registration of Settlement failed for case no : ".$application_no
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
                $this->session->set_flashdata('message', "Error #ERRAM000199: Settlement Application not submitted case no # $application_no");
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

            $is_full_pay=$this->input->post('paymode');
            $prem_zonal = $this->utilityclass->getZonalValue($dag_premium->dist_code,$basic['uuid'],$dag_premium->dag_no);
            $prem_area = $this->input->post('total_lessa'.$dag_premium->dag_no);
            $prem_concession = "YES";

            $percentage = 10;
            $zonal_lessa = $prem_zonal / 100;
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
                  'error'=>"#ERRSET0002515: Registration of Settlement failed for case no : ".$application_no
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
            $this->session->set_flashdata('message', "Error #ERRAM2529: Settlement Application not submitted case no # $application_no");
            log_message('error', '#ERRAM2529: Premium ghotala by LM, RTPS Case No '.$application_no);
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
            $this->session->set_flashdata('message', "Error #ERRAM0002: Settlement Application not submitted case no # $case_no");
            log_message('error', '#ERRAM0002: Premium ghotala by LM, RTPS Case No '.$application_no);
            redirect(base_url() . "index.php/home");
          }
          // premium verify 2 end ******************
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("SELECT max(proceeding_id)+1 as c FROM settlement_proceeding WHERE case_no='$case_no' ")->row()->c;

        if ($proceeding_id==null) {
          $proceeding_id=1;
        }

        $insPetProceed = [
          'case_no'              => $case_no,
          'proceeding_id'        => $proceeding_id,
          'date_of_hearing'      => date('Y-m-d H:i:s'),
          'next_date_of_hearing' => date('Y-m-d H:i:s'),
          'note_on_order'        => $this->input->post('lm_remark_text'),
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
            $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
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
  


  public function addLegalHeirDetails()
  {
    $case_no            = $this->input->post('case_no');
    $add_eng_name       = $this->input->post('add_eng_name');
    $add_asm_name       = $this->input->post('add_asm_name');
    $add_eng_gname      = $this->input->post('add_eng_gname');
    $add_asm_gname      = $this->input->post('add_asm_gname');
    $add_lh_relation    = $this->input->post('add_lh_relation');
    $add_lh_contact_no  = $this->input->post('add_lh_contact_no');
    $add_lh_address     = $this->input->post('add_lh_address');
    $add_lh_gender      = $this->input->post('add_lh_gender');
    $add_lh_life_status = $this->input->post('add_lh_life_status');

    //******backend validation */
    //***delimiter for not returning <p> tag */
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
    $this->form_validation->set_rules('add_eng_name', 'Name in English', 'trim|required');
    $this->form_validation->set_rules('add_asm_name', 'Name in Assamese', 'trim|required');
    $this->form_validation->set_rules('add_eng_gname', 'Name in English', 'trim|required');
    $this->form_validation->set_rules('add_asm_gname', 'Name in Assamese', 'trim|required');    
    $this->form_validation->set_rules('add_lh_relation', 'Relation', 'trim|required');
    $this->form_validation->set_rules('add_lh_gender', 'Gender', 'trim|required');
    $this->form_validation->set_rules('add_lh_contact_no', 'Mobile No.', 'trim|required|min_length[10]|max_length[10]');
    $this->form_validation->set_rules('add_lh_address', 'Address', 'trim|required|min_length[3]|max_length[200]');
    $this->form_validation->set_rules('add_lh_life_status', 'Life Status of the individual', 'trim|required');

    if ($this->form_validation->run() == false) {
      $data = array(
        'responseType' => 0,
        'msg'          => "#ERROR2675:" . validation_errors() . "#case_no : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    $name_assamese = $this->TeaGrantModel->checkAssameseCharacterOnly($add_asm_name);
    if($name_assamese != null || $name_assamese != ''){
      //$this->db->trans_rollback();
      log_message('error', '#ERROR2681: Assamese character not entered in Applicant detail Name in Assamese field '.$case_no);
      return json_encode(array(
        'responseType' => 0,
        'msg'          => '#ERROR2681: Only Assamese character allowed in Applicant detail Name in Assamese',
      ));
    }

    $gname_assamese = $this->TeaGrantModel->checkAssameseCharacterOnly($add_asm_gname);
    if($gname_assamese != null || $gname_assamese != ''){
      //$this->db->trans_rollback();
      log_message('error', '#ERROR2691: Assamese character not entered in Applicant detail Name in Assamese field '.$case_no);
      return json_encode(array(
        'responseType' => 0,
        'msg'          => '#ERROR2681: Only Assamese character allowed in Guardian detail Name in Assamese',
      ));
    }

    $appl = $this->TeaGrantModel->getAppliedApplicant($case_no);

    // get max pdar_cron_no
    $maxCronNo = $this->db->query("SELECT max(pdar_cron_no)+1 AS max_cron FROM 
                    settlement_applicant WHERE case_no=?", array($case_no))->row()->max_cron;

    // insert into settlement_applicant
    $nokDetailArr = [
      'dist_code'          => $appl->dist_code,
      'subdiv_code'        => $appl->subdiv_code,
      'cir_code'           => $appl->cir_code,
      'mouza_pargona_code' => $appl->mouza_pargona_code,
      'lot_no'             => $appl->lot_no,
      'vill_townprt_code'  => $appl->vill_townprt_code,
      'year_no'            => $appl->year_no,
      'petition_no'        => $appl->petition_no,
      'pdar_cron_no'       => $maxCronNo,
      'pdar_name'          => $add_asm_name,
      'pdar_guardian'      => $add_asm_gname,
      'pdar_rel_guar'      => $add_lh_relation,
      'pdar_add1'          => $add_lh_address,
      'pdar_add2'          => $add_lh_address,
      'dag_no'             => '',
      'pdar_id'            => '-1',
      'user_code'          => $this->session->userdata('user_code'),
      'date_entry'         => date('Y-m-d H:i:s'),
      'operation'          => 'E',
      'pdar_gender'        => $add_lh_gender,
      'pdar_mobile'        => $add_lh_contact_no,
      'case_no'            => $case_no,
      'pdar_type'          => 'B',
      'is_applicant'       => 0,
      'eng_pdar_name'      => $add_eng_name,
      'eng_pdar_guardian'  => $add_eng_gname,
      'flag_legal_heir'    => 'Y',
      'life_status'        => $add_lh_life_status,
    ];
    $insertHeir = $this->db->insert('settlement_applicant', $nokDetailArr);
    $id                            = $this->db->insert_id();
    $nokDetailArr['relation_name'] = $this->TeaGrantModel->appRelationById($add_lh_relation);
    $nokDetailArr['id']            = $id;

    if ($insertHeir != 1) {
      log_message('error', '#ERROR2743: Insertion failed in settlement_applicant : '.$this->db->last_query());
      $data = array(
        'responseType' => 0,
        'msg'          => "#ERROR2743: Unable to add legal heir detail : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    // get list o

    //**** if data inserted successfully */
    $data = array(
      'responseType' => 2,
      'appnData'     => $this->TeaGrantModel->getLegalHeirList($case_no),
      'msg'          => "Data of legal heir added successfully !!!",
    );
    echo json_encode($data);
  }


  // Delete family
  public function delLegalHeir()
  {
    $this->db->trans_begin();
    $id      = $this->input->post('id');
    $case_no = $this->input->post('case_no');

    //if condition if no id fond or already deleted
    $sql = "DELETE FROm settlement_applicant WHERE id=? AND case_no=?";
    $result = $this->db->query($sql, array($id, $case_no));
    if ($this->db->affected_rows() != 1) {
      $this->db->trans_rollback();
      $response['status'] = 0;
      echo json_encode(['status' => 0]);
      log_message("error", "#PROP0002 Failed to delete family: " . $id);
      return;
    } 
    else 
    {
      $this->db->trans_commit();

      //get count from table
      $count = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=?",
          array($case_no))->num_rows();
      $response['status'] = 200;
      echo json_encode(['status' => 200, 'count' => $count]);
      return;
    }
  }

  public function getLegalHeirList() 
  {
    echo json_encode(array(
      'appnData' => $this->TeaGrantModel->getLegalHeirList($this->input->post('case_no')),
    ));
  }

  // update area details from LRA end
  public function updateTeaGrantAreaDetails()
  {
    // var_dump($_POST);die;


    //****getting the data  */
    $case_no        = $this->input->post('area_update_case_no');
    $distCode       = $this->session->userdata('dist_code');
    $service_code   = $this->utilityclass->getServiceCode($case_no);
    $checkUrbanCon  = $this->input->post('area_update_urban_check');

    $totalHomeAreaLessaValidation = 0;
    $totalAgrAreaLessaValidation  = 0;
    $totalDagAreaLessaValidation  = 0;
    $totalDagAreaAppliedLessa     = 0;
    $appAreaMoreThanDagA          = 0;

    $id     = $this->input->post('area_update_id');
    $dag_no = $this->input->post('area_update_dag_no');

    //******backend validation */
    //***delimiter for not returning <p> tag */
    $this->form_validation->set_error_delimiters('', '');

    $singleAdditionalProToLessa = 0;
    $totalAdditionalProToLessa  = 0;

    $application_no        = $this->utilityclass->getApplidFromCaseNo($case_no,$dag_no);
    $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
    $appliedDags           = $this->SettlementCommonModel->getAllAppliedDagsByApplicant($case_no,$dag_no);

    // echo $this->db->last_query(); die;


    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
      foreach ($additional_properties as $singleProperty) {
        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
        $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
      }

      foreach ($appliedDags as $appliedDag)
      {
        $appliedBighaHome             = 0;
        $appliedKathaHome             = 0;
        $appliedLessaHome             = 0;
        $appliedGandaHome             = 0;
        $singleAppliedAreaToLessaHome = 0;

        $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
        $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
        $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);
        $appliedGandaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_ganda, 0);

        $singleAppliedAreaToLessaHome = ($appliedBighaHome * 6400) + ($appliedKathaHome * 320) + ($appliedLessaHome * 20) + $appliedGandaHome;

        $totalDagAreaAppliedLessa += $singleAppliedAreaToLessaHome;
      }
    }
    else
    {
      foreach ($additional_properties as $singleProperty) {
        $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
        $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
        $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
      }

      foreach ($appliedDags as $appliedDag)
      {
        $appliedBighaHome             = 0;
        $appliedKathaHome             = 0;
        $appliedLessaHome             = 0;
        $singleAppliedAreaToLessaHome = 0;

        $appliedBighaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
        $appliedKathaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_katha, 0);
        $appliedLessaHome = $this->UtilsModel->defaultValue($appliedDag->applied_area_home_lessa, 0);

        $singleAppliedAreaToLessaHome = ($appliedBighaHome * 100) + ($appliedKathaHome * 20) + $appliedLessaHome;

        $totalDagAreaAppliedLessa += $singleAppliedAreaToLessaHome;
      }
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
      $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
      $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
      $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
      $this->form_validation->set_rules('total_ganda_in_dag', 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
      $this->form_validation->set_rules('total_kranti_in_dag', 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

      $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
      $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
      $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
      $this->form_validation->set_rules('enc_ganda_home', 'Applied Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
      $this->form_validation->set_rules('enc_kranti_home', 'Applied Land Area  Homestead(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

      $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
      $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
      $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);
      $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0);

      $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_bigha_home'), 0);
      $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_katha_home'), 0);
      $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_lessa_home'), 0);
      $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0);

      $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
      $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;

      if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
        $appAreaMoreThanDagA = 1;
      }

      $totalDagAreaLessaValidation += $dagAreaLessaValidation;
      $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
    }
    else
    {
      $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
      $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
      $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

      $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
      $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
      $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

      $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
      $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
      $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);

      $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_bigha_home'), 0);
      $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_katha_home'), 0);
      $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('enc_lessa_home'), 0);

      $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
      $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;

      if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
        $appAreaMoreThanDagA = 1;
      }

      $totalDagAreaLessaValidation += $dagAreaLessaValidation;
      $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
    }

    $totalEditArea = $totalHomeAreaLessaValidation;

    $editAreaNotMoreThenApplied = 0;
    if($totalEditArea > $totalDagAreaAppliedLessa)
    {
      $editAreaNotMoreThenApplied = 1;
    }

    if(EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1)
    {
      if ($editAreaNotMoreThenApplied == 1)
      {
        $this->form_validation->set_rules('editAreaNotMoreThenAppliedCheck', 'Total edit area should not more then total applied area !', 'required|callback_editAreaNotMoreThenAppliedCheck');
      }
    }

    if ($totalHomeAreaLessaValidation == 0)
    {
      $this->form_validation->set_rules('totalAppliedAreaZeroCheck', 'Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
    }
    if ($appAreaMoreThanDagA == 1)
    {
      $this->form_validation->set_rules('appAreaMoreThanDagA', 'Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
      if (TEA_GRANT_MAX_APPLIED * 6400 < $totalAdditionalProToLessa) {
        $this->form_validation->set_rules('teaGrantMaxAppliedWithAddPro', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . TEA_GRANT_MAX_APPLIED . ' Bigha !', 'required|callback_teaGrantMaxAppliedWithAddPro');
      }
    }
    else
    {
      if (TEA_GRANT_MAX_APPLIED * 100 < $totalAdditionalProToLessa) {
        $this->form_validation->set_rules('teaGrantMaxAppliedWithAddPro', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . TEA_GRANT_MAX_APPLIED . ' Bigha !', 'required|callback_teaGrantMaxAppliedWithAddPro');
      }
    }

    if ($this->form_validation->run() == false) {
      $data = array(
        'responseType' => 0,
        'msg'          => "#AREAUPDT0001:" . validation_errors() . "#case_no : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    $this->db->trans_begin(); 

    //***Applied area update*/
    $encroachment_area = [
      'homestead' => [
        'bigha'   => $this->input->post('enc_bigha_home'),
        'katha'   => $this->input->post('enc_katha_home'),
        'lessa'   => $this->input->post('enc_lessa_home'),
        'ganda'   => $this->input->post('enc_ganda_home'),
        'kranti'  => $this->input->post('enc_kranti_home'),
      ],
    ];

    $areaUpdateArr = [
      'dag_area_b'         => $this->input->post('total_bigha_in_dag'),
      'dag_area_k'         => $this->input->post('total_katha_in_dag'),
      'dag_area_lc'        => $this->input->post('total_lessa_in_dag'),
      'dag_area_g'         => $this->UtilsModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
      'dag_area_kr'        => $this->UtilsModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),
      'encroachement_area' => json_encode($encroachment_area),
      'home_b'             => 0,
      'home_k'             => 0,
      'home_lc'            => 0,
      'home_g'             => 0,
      'home_kr'            => 0,
      'agri_b'             => 0,
      'agri_k'             => 0,
      'agri_lc'            => 0,
      'agri_g'             => 0,
      'agri_kr'            => 0,
      's_dag_area_b'       => $this->input->post('enc_bigha_home'),
      's_dag_area_k'       => $this->input->post('enc_katha_home'),
      's_dag_area_lc'      => $this->input->post('enc_lessa_home'),
      's_dag_area_g'       => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      's_dag_area_kr'      => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),
      'user_code'          => $this->session->userdata('user_code'),
      'year_no'            => date('Y'),
      'date_entry'         => date('Y-m-d'),
      'land_type'          => 0,
      'applied_b'          => $this->input->post('enc_bigha_home'),
      'applied_k'          => $this->input->post('enc_katha_home'),
      'applied_lc'         => $this->input->post('enc_lessa_home'),
      'applied_g'          => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'applied_kr'         => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),
    ];

    $this->db->where('case_no', $case_no);
    $this->db->where('id', $id);
    $this->db->where('dag_no', $dag_no);
    $this->db->update('settlement_dag_details', $areaUpdateArr);

    if ($this->db->affected_rows() != 1) {
      $this->db->trans_rollback();
      log_message('error', '#ERR3053: Update fail in settlement_dag_details ' . $case_no);
      $data = array(
        'responseType' => 0,
        'msg'          => "#ERR3053: Update fail in settlement_dag_details : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    //*******insertion in settlement_area_history**************

    $settlementAreaHistoryArr = [
      'created_at'                           => date('Y-m-d'),
      'actual_encroachment_area_home_bigha'  => $this->input->post('enc_bigha_home'),
      'actual_encroachment_area_home_katha'  => $this->input->post('enc_katha_home'),
      'actual_encroachment_area_home_lessa'  => $this->input->post('enc_lessa_home'),
      'actual_encroachment_area_home_ganda'  => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'actual_encroachment_area_home_kranti' => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),
      'actual_encroachment_area_agri_bigha'  => 0,
      'actual_encroachment_area_agri_katha'  => 0,
      'actual_encroachment_area_agri_lessa'  => 0,
      'actual_encroachment_area_agri_ganda'  => 0,
      'actual_encroachment_area_agri_kranti' => 0,
      'total_actual_encroachment_area_bigha' => 0,
      'total_actual_encroachment_area_katha' => 0,
      'total_actual_encroachment_area_lessa' => 0,
      'total_actual_encroachment_area_ganda' => 0,
      'total_actual_encroachment_area_kranti'=> 0,
      'settlement_area_home_bigha'           => $this->input->post('enc_bigha_home'),
      'settlement_area_home_katha'           => $this->input->post('enc_katha_home'),
      'settlement_area_home_lessa'           => $this->input->post('enc_lessa_home'),
      'settlement_area_home_ganda'           => $this->UtilsModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'settlement_area_home_kranti'          => $this->UtilsModel->defaultValue($this->input->post('enc_kranti_home'), 0),
      'settlement_area_agri_bigha'           => 0,
      'settlement_area_agri_katha'           => 0,
      'settlement_area_agri_lessa'           => 0,
      'settlement_area_agri_ganda'           => 0,
      'settlement_area_agri_kranti'          => 0,
      'total_settlement_area_bigha'          => 0,
      'total_settlement_area_katha'          => 0,
      'total_settlement_area_lessa'          => 0,
      'total_settlement_area_ganda'          => 0,
      'total_settlement_area_kranti'         => 0,
      'leftout_area_home_bigha'              => 0,
      'leftout_area_home_katha'              => 0,
      'leftout_area_home_lessa'              => 0,
      'leftout_area_home_ganda'              => 0,
      'leftout_area_home_kranti'             => 0,
      'leftout_area_agri_bigha'              => 0,
      'leftout_area_agri_katha'              => 0,
      'leftout_area_agri_lessa'              => 0,
      'leftout_area_agri_ganda'              => 0,
      'leftout_area_agri_kranti'             => 0,
      'total_leftout_area_bigha'             => 0,
      'total_leftout_area_katha'             => 0,
      'total_leftout_area_lessa'             => 0,
      'total_leftout_area_ganda'             => 0,
      'total_leftout_area_kranti'            => 0,
    ];

    $this->db->where('case_no', $case_no);
    $this->db->where('application_no', $application_no);
    $this->db->where('dag_no', $dag_no);
    $this->db->update('settlement_area_history', $settlementAreaHistoryArr);

    //*******check if data updated */
    if ($this->db->affected_rows() != 1) {
      $this->db->trans_rollback();
      log_message('error', '#ERR3121: Update fail in settlement_area_history ' . $case_no);
      $data = array(
          'responseType' => 0,
          'msg' => "#ERR3121: Update fail in settlement_area_history : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    $this->db->trans_commit();

    //*****getting the total applied area from db to check if it exceeds any area conditions*/
    $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));

    if ($sql->num_rows() <= 0) {
      $this->db->trans_rollback();
      $data = array(
        'responseType' => 0,
        'msg'          => "#FETCH0001: Error in fetching data from settlement_dag_details ! . $case_no",
      );
      echo json_encode($data);
      return false;
    }

    $fresh_area_details = $sql->result();

    $total_settlement_home_lessa = 0;
    $total_settlement_home_ganda = 0;
    $total_settlement_agri_ganda = 0;
    $total_settlement_agri_lessa = 0;
    foreach ($fresh_area_details as $fresh_area) {

      $settlement_area_home_bigha = (float)$fresh_area->applied_b;
      $settlement_area_home_kahta = (float)$fresh_area->applied_k;
      $settlement_area_home_lessa = (float)$fresh_area->applied_lc;
      $settlement_area_home_ganda = (float)$fresh_area->applied_g;

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
        //****total settlement area in all dags */
        $total_settlement_home_ganda = $total_settlement_home_ganda + $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa, $settlement_area_home_ganda);
      } 
      else 
      {        
        //****total settlement area in all dags */
        $total_settlement_home_lessa = $total_settlement_home_lessa + $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa);
      }
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY))) {
      $total_settlement_area_home_formated = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_home_ganda);
    } else {
      $total_settlement_area_home_formated = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_home_lessa);
    }

    //**** if data intserted successfully*/
    $data = array(
      'responseType'            => 2,
      'totalSettlementAreaHome' => $total_settlement_area_home_formated,
      'appnData'                => $areaUpdateArr,
      'msg'                     => "Area detail has successfully modified for dag no $dag_no",
    );
    echo json_encode($data);
  }

  public function editAreaNotMoreThenAppliedCheck()
  {
    return false;
  }

  public function totalAppliedAreaZeroCheck()
  {
    return false;
  }

  public function appAreaMoreThanDagA()
  {
    return false;
  }

  public function teaGrantMaxAppliedWithAddPro()
  {
    return false;
  }

  public function totalAppliedAreaInUrban()
  {
    return false;
  }

  public function cultivationMaxApplied()
  {
    return false;
  }

  public function totalAppliedAdditionalArea()
  {
    return false;
  }





  // newly added for area check

  public function selectDagArea()
  {
    //****getting the data  */
    $case_no = $this->input->post('case_no');
    $id      = $this->input->post('id');
    $dag_no  = $this->input->post('dag_no');

    $this->db->trans_begin();

    $this->db->select('*');
    $this->db->from('settlement_dag_details');
    $this->db->where('case_no', $case_no);
    $this->db->where('dag_no', $dag_no);
    $this->db->where('id', $id);
    $query = $this->db->get();

    // echo $this->db->last_query(); 

    if ($query->num_rows() > 0) {

      $data = $query->result_array();

      foreach ($data as $row) {

        $areaUpdateArr = [

          //****total dag area */
          'dag_area_b'    => $row['dag_area_b'],
          'dag_area_k'    => $row['dag_area_k'],
          'dag_area_lc'   => $row['dag_area_lc'],
          'dag_area_g'    => $row['dag_area_g'],
          'dag_area_kr'   => $row['dag_area_kr'],          

          's_dag_area_b'  => $row['applied_b'],
          's_dag_area_k'  => $row['applied_k'],
          's_dag_area_lc' => $row['applied_lc'],
          's_dag_area_g'  => $row['applied_g'],
          's_dag_area_kr' => $row['applied_kr'],
          
          'is_urban'      => $row['is_urban'],
        ];
      }
    }

    $data = array(
      'responseType' => 2,
      'appnData'     => $areaUpdateArr,
    );
    echo json_encode($data);
  }

  public function updateAreaDetails()
  {
    //****getting the data  */
    $case_no        = $this->input->post('area_update_case_no');
    $distCode       = $this->session->userdata('dist_code');
    $service_code   = TEA_SERVICE_CODE;
    $checkUrbanCon  = $this->input->post('area_update_urban_check');
    $land_area_type = $this->input->post('land_area_type');
    $id             = $this->input->post('area_update_id');
    $dag_no         = $this->input->post('area_update_dag_no');

    // var_dump($land_area_type); die;

    $mbLandNullArea = array(7, 8, 9, 10, 18, 20, 22);

    $totalHomeAreaLessaValidation = 0;
    $totalAgrAreaLessaValidation  = 0;
    $totalDagAreaLessaValidation  = 0;
    $totalDagAreaAppliedLessa     = 0;
    $appAreaMoreThanDagA          = 0;

    $dag_details = $this->db->query("Select * from settlement_dag_details where case_no='$case_no' and dag_no='$dag_no'")->result();
    foreach ($dag_details as $dagone) {
      $area_name = $this->utilityclass->getAreaCategory($dagone->dist_code, $dagone->subdiv_code, $dagone->cir_code, $dagone->mouza_pargona_code, $dagone->lot_no, $dagone->vill_townprt_code, $dagone->dag_no);
    }

    //******backend validation */
    //***delimiter for not returning <p> tag */
    $this->form_validation->set_error_delimiters('', '');

    $singleAdditionalProToLessa = 0;
    $totalAdditionalProToLessa  = 0;

    $application_no        = $this->ncutility->getApplidFromCaseNo($case_no,$dag_no);
    $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
    $appliedDags           = $this->NcCommonModel->getAllAppliedDagsByApplicant($case_no,$dag_no);

    // var_dump($appliedDags); die;

    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
      foreach ($additional_properties as $singleProperty) {
        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);
        $gandaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->ganda, 0);

        $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
      }

      foreach ($appliedDags as $appliedDag)
      {
        $appliedBighaAgri = 0;
        $appliedKathaAgri = 0;
        $appliedLessaAgri = 0;
        $appliedGandaAgri = 0;

        $appliedBighaHome = 0;
        $appliedKathaHome = 0;
        $appliedLessaHome = 0;
        $appliedGandaHome = 0;

        $singleAppliedAreaToLessaAgri = 0;
        $singleAppliedAreaToLessaHome = 0;

        $appliedBighaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
        $appliedKathaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_katha, 0);
        $appliedLessaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_lessa, 0);
        $appliedGandaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_ganda, 0);

        $singleAppliedAreaToLessaAgri = ($appliedBighaAgri * 6400) + ($appliedKathaAgri * 320) + ($appliedLessaAgri * 20) + $appliedGandaAgri;
        $singleAppliedAreaToLessaHome = ($appliedBighaHome * 6400) + ($appliedKathaHome * 320) + ($appliedLessaHome * 20) + $appliedGandaHome;

        $totalDagAreaAppliedLessa += ($singleAppliedAreaToLessaAgri + $singleAppliedAreaToLessaHome);
      }
    }
    else
    {
      foreach ($additional_properties as $singleProperty) {
        $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
        $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
        $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);

        $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
        $totalAdditionalProToLessa += $singleAdditionalProToLessa;
      }

      // echo "<pre>";
      // var_dump($appliedDags); die;

      foreach ($appliedDags as $appliedDag)
      {
        $appliedBighaHome = 0;
        $appliedKathaHome = 0;
        $appliedLessaHome = 0;

        $singleAppliedAreaToLessaAgri = 0;
        $singleAppliedAreaToLessaHome = 0;

        $appliedBighaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
        $appliedKathaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_katha, 0);
        $appliedLessaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_lessa, 0);

        $singleAppliedAreaToLessaHome = ($appliedBighaHome * 100) + ($appliedKathaHome * 20) + $appliedLessaHome;
        $totalDagAreaAppliedLessa += $singleAppliedAreaToLessaHome;
      }
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
        $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
        $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
        $this->form_validation->set_rules('total_ganda_in_dag', 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
        $this->form_validation->set_rules('total_kranti_in_dag', 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
        $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
        $this->form_validation->set_rules('enc_ganda_home', 'Applied Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
        $this->form_validation->set_rules('enc_kranti_home', 'Applied Land Area  Homestead(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);
        $gandaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_ganda_in_dag'), 0);

        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_bigha_home'), 0);
        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_katha_home'), 0);
        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_lessa_home'), 0);
        $gandaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0);

        $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;

        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
            $appAreaMoreThanDagA = 1;
        }

        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
    }
    else
    {
        $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
        $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
        $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
        $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
        $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);

        $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_bigha_home'), 0);
        $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_katha_home'), 0);
        $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_lessa_home'), 0);

        $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;

        if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
            $appAreaMoreThanDagA = 1;
        }

        $totalDagAreaLessaValidation += $dagAreaLessaValidation;
        $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
    }

    $totalEditArea = $totalHomeAreaLessaValidation;

    $editAreaNotMoreThenApplied = 0;
    if($totalEditArea > $totalDagAreaAppliedLessa)
    {
        $editAreaNotMoreThenApplied = 1;
    }

    if(EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1)
    {
      if ($editAreaNotMoreThenApplied == 1)
      {
        $this->form_validation->set_rules('editAreaNotMoreThenAppliedCheck', 'Total edit area should not more then total applied area !', 'required|callback_editAreaNotMoreThenAppliedCheck');
      }
    }

    if ($totalHomeAreaLessaValidation == 0)
    {
      $this->form_validation->set_rules('totalAppliedAreaZeroCheck', 'Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
    }
    if ($appAreaMoreThanDagA == 1)
    {
      $this->form_validation->set_rules('appAreaMoreThanDagA', 'Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
    }



    if (in_array($distCode, json_decode(BARAK_VALLEY)))
    {
      if (CULTIVATION_MAX_APPLIED * 6400 < $totalHomeAreaLessaValidation) {

        $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
      }
      if ((CULTIVATION_MAX_APPLIED ) * 6400 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
        $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (CULTIVATION_MAX_APPLIED) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
      }
    }
    else
    {
      if (CULTIVATION_MAX_APPLIED * 100 < $totalHomeAreaLessaValidation) {
        $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . CULTIVATION_MAX_APPLIED . ' Bigha !', 'required|callback_cultivationMaxApplied');
      }
      if ((CULTIVATION_MAX_APPLIED) * 100 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
        $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (CULTIVATION_MAX_APPLIED) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
      }
    }


    if ($this->form_validation->run() == false) {
      $data = array(
        'responseType' => 0,
        'msg'          => "#AREAUPDT0001:" . validation_errors() . "#case_no : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }

    $this->db->trans_begin();

    //****landType update HOMESTEAD/AGRICULTURE/BOTH */
    $homesteadLandExist = (float)$this->input->post('enc_bigha_home') + (float)$this->input->post('enc_katha_home') + (float)$this->input->post('enc_lessa_home') + (float)$this->input->post('enc_ganda_home') + (float)$this->input->post('enc_kranti_home');

    $landTypeUpdate = 0;
    if ($homesteadLandExist > 0) {
      $landTypeUpdate = 1;
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY))) {
        //***********actual Applied area ***************
        $actual_encroachment_area_home_ganda = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

        //***********total Actual Applied area*****************
        $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda;
        $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
        // **********************************************

        //***********Settlement area that applicant will get settlement on***********
        $total_settlement_ganda_home = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

        //*****total Settlement area *************/
        $total_settlement_ganda = (float)$total_settlement_ganda_home;
        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

        //*************leftout area homestead**************
        $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
        $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

        //**********Total left out area***************
        $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
        $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
    } else {
        //********actual Applied area**********
        $actual_encroachment_area_home_lessa = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

        //***********total Actual Applied area*****************
        $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa ;
        $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
        // **********************************************

        //*******Settlement area that applicant will get settlement on**********
        $total_settlement_lessa_home = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

        //*************Total settlement area */
        $total_settlement_lessa = (float)$total_settlement_lessa_home;
        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa);

        //****************leftout area homestead**************
        $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
        $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

        //**********Total left out area***************
        $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
        $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
    }

    // var_dump($total_settlement_lessa_home); die;
    //***Applied area update*/
    $encroachment_area = [
      'appliedArea' => [
        'bigha'   => $this->input->post('enc_bigha_home'),
        'katha'   => $this->input->post('enc_katha_home'),
        'lessa'   => $this->input->post('enc_lessa_home'),
        'ganda'   => $this->input->post('enc_ganda_home'),
        'kranti'  => $this->input->post('enc_kranti_home'),
      ],
    ];

    $areaUpdateArr = [
      //****total dag area */
      'dag_area_b'    => $this->input->post('total_bigha_in_dag'),
      'dag_area_k'    => $this->input->post('total_katha_in_dag'),
      'dag_area_lc'   => $this->input->post('total_lessa_in_dag'),
      'dag_area_g'    => $this->NcCommonModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
      'dag_area_kr'   => $this->NcCommonModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),

      //*****Applied area */
      'encroachement_area'  => json_encode($encroachment_area),

      //*****settlement area */
      'home_b'        => 0,
      'home_k'        => 0,
      'home_lc'       => 0,
      'home_g'        => 0,
      'home_kr'       => 0,
      'agri_b'        => 0,
      'agri_k'        => 0,
      'agri_lc'       => 0,
      'agri_g'        => 0,
      'agri_kr'       => 0,

      'applied_b'     => $this->input->post('enc_bigha_home'),
      'applied_k'     => $this->input->post('enc_katha_home'),
      'applied_lc'    => $this->input->post('enc_lessa_home'),
      'applied_g'     => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'applied_kr'    => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),

      's_dag_area_b'  => $totalSettlementAreaArr[0],
      's_dag_area_k'  => $totalSettlementAreaArr[1],
      's_dag_area_lc' => $totalSettlementAreaArr[2],
      's_dag_area_g'  => $totalSettlementAreaArr[3],
      's_dag_area_kr' => 0,

      //****user info update */
      'user_code'     => $this->session->userdata('user_code'),
      'year_no'       => date('Y'),
      'date_entry'    => date('Y-m-d'),
      'land_type'     => $landTypeUpdate,
    ];

    $this->db->where('case_no', $case_no);
    $this->db->where('id', $id);
    $this->db->where('dag_no', $dag_no);
    $this->db->update('settlement_dag_details', $areaUpdateArr);

    // echo $this->db->last_query();
    //*******check if data updated */
    if ($this->db->affected_rows() != 1) {
      $this->db->trans_rollback();
      log_message('error', '#UPDTAREDTLS3658: Update fail in settlement_dag_details ' . $case_no);
      $data = array(
        'responseType' => 0,
        'msg'          => "#UPDTAREDTLS3658: Update fail in settlement_dag_details : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }



    //checking settlement--reservation or not=====
    $total_settlement_reservation = 0;
    $reservation = $this->db->query("Select * from settlement_reservation where case_no='$case_no' and dag_no='$dag_no' and is_deleted =0")->row();
    if(!empty($reservation))
    {
      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
          $total_settlement_ganda_home = $this->ncutility->Total_ganda($reservation->bigha, $reservation->katha, $reservation->lessa, $reservation->ganda);
            $total_settlement_reservation = (float)$total_settlement_ganda_home;

      } else {

          $total_settlement_lessa_home = $this->ncutility->Total_Lessa($reservation->bigha, $reservation->katha, $reservation->lessa);
            //*************Total settlement area */
            $total_settlement_reservation = (float)$total_settlement_lessa_home;
            
      }
    }
    if(in_array($distCode, json_decode(BARAK_VALLEY))) {
      $total_settlement_lessa = $total_settlement_ganda;
    }else{
      $total_settlement_lessa = $total_settlement_lessa;
    }


    $total_settlement_lessa = $total_settlement_lessa - $total_settlement_reservation;
    if($total_settlement_lessa <= 0)
    {
      $this->db->trans_rollback();
      log_message('error', '#UPDTAREDTLS5461: Update fail in settlement_dag_details ' . $case_no);
      $data = array(
        'responseType' => 0,
        'msg'          => "#UPDTAREDTLS5461: Please verify the area details before proceed for the : " . $case_no,
      );
      echo json_encode($data);
      return false;
    }
    /////////end reservation check////////
    

    //******* premium update start**************
    $this->db->select('*');
    $this->db->from('settlement_premium');
    $this->db->where('is_final', 1);
    $this->db->where('case_no', $case_no);
    $this->db->where('dag_no', $dag_no);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      $data = $query->result_array();

      foreach ($data as $row) {

        $this->db->set('is_final', 0);
        $this->db->where('is_final', 1);
        $this->db->where('case_no', $case_no);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('settlement_premium');

        if ($this->db->affected_rows() == 0)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET5000311: Premium Updation failed for Case No '.$case_no);
          $data = array(
            'error'=>"#ERRSET5000311: Updation Settlement failed for case no : ".$case_no
          );
          echo json_encode($data);
          return false;
        }

        $dag_amount          = ($row['amount_dag'] / $row['total_lessa']) * $total_settlement_lessa;
        $final_amount        = ($row['final_amount'] - $row['amount_dag']) + $dag_amount;
        $row['amount_dag']   = $dag_amount;
        $row['final_amount'] = $final_amount;
        $row['due_amount']   = $final_amount;
        $row['total_lessa']  = $total_settlement_lessa;
        $row['user_code']    = $this->session->userdata('user_code');
        $row['date_entry']   = date('Y-m-d H:i:s');
        unset($row['pid']);
        $this->db->insert('settlement_premium', $row);

        if ($this->db->affected_rows() == 0)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET6000312: Premium Updation failed for Case No '.$case_no);
          $data = array(
            'error'=>"#ERRSET6000312: Updation Settlement failed for case no : ".$case_no
          );
          echo json_encode($data);
          return false;
        }

        $this->db->set('final_amount', $final_amount);
        $this->db->set('due_amount', $final_amount);
        $this->db->where('is_final', 1);
        $this->db->where('case_no', $case_no);
        // $this->db->where('dag_no', $dag_no);
        $this->db->update('settlement_premium');

        if ($this->db->affected_rows() == 0)
        {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET7000313: Premium Updation failed for Case No '.$case_no);
          $data = array(
            'error'=>"#ERRSET7000313: Updation Settlement failed for case no : ".$case_no
          );
          echo json_encode($data);
          return false;
        }
      }


      if ($this->db->affected_rows() == 0)
      {
        $this->db->trans_rollback();
        log_message('error', '#ERRSET9000311: Premium Updation failed for Case No '.$case_no);
        $data = array(
          'error'=>"#ERRSET9000311: Updation Settlement failed for case no : ".$case_no
        );
        echo json_encode($data);
        return false;
      }
    }

    //******* premium update end**************

    //*******insertion in settlement_area_history**************

    $settlementAreaHistoryArr = [
      'created_at'                            => date('Y-m-d'),
      //****Applied area */
      'actual_encroachment_area_home_bigha'   => $this->input->post('enc_bigha_home'),
      'actual_encroachment_area_home_katha'   => $this->input->post('enc_katha_home'),
      'actual_encroachment_area_home_lessa'   => $this->input->post('enc_lessa_home'),
      'actual_encroachment_area_home_ganda'   => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'actual_encroachment_area_home_kranti'  => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),

      'actual_encroachment_area_agri_bigha'   => 0,
      'actual_encroachment_area_agri_katha'   => 0,
      'actual_encroachment_area_agri_lessa'   => 0,
      'actual_encroachment_area_agri_ganda'   => 0,
      'actual_encroachment_area_agri_kranti'  => 0,

      //*****total Applied area */
      'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
      'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
      'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
      'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
      'total_actual_encroachment_area_kranti' => 0,
      //*******setttlement_area */
      'settlement_area_home_bigha'            => $this->input->post('enc_bigha_home'),
      'settlement_area_home_katha'            => $this->input->post('enc_katha_home'),
      'settlement_area_home_lessa'            => $this->input->post('enc_lessa_home'),
      'settlement_area_home_ganda'            => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
      'settlement_area_home_kranti'           => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),

      'settlement_area_agri_bigha'            => 0,
      'settlement_area_agri_katha'            => 0,
      'settlement_area_agri_lessa'            => 0,
      'settlement_area_agri_ganda'            => 0,
      'settlement_area_agri_kranti'           => 0,

      //*****total settlement_area */
      'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
      'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
      'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
      'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
      'total_settlement_area_kranti'          => 0,
      //******leftout area */
      'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
      'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
      'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
      'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
      'leftout_area_home_kranti'              => 0,
      'leftout_area_agri_bigha'               => 0,
      'leftout_area_agri_katha'               => 0,
      'leftout_area_agri_lessa'               => 0,
      'leftout_area_agri_ganda'               => 0,
      'leftout_area_agri_kranti'              => 0,
      //****total leftout area */
      'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
      'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
      'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
      'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
      'total_leftout_area_kranti'             => 0,
    ];

    $this->db->where('case_no', $case_no);
    $this->db->where('application_no', $application_no);
    $this->db->where('dag_no', $dag_no);
    $this->db->update('settlement_area_history', $settlementAreaHistoryArr);

    //*******check if data updated */
    if ($this->db->affected_rows() == 0) {
      $this->db->trans_rollback();
      log_message('error', '#UPDTAREDTLS3821: Update fail in settlement_area_history ' . $case_no);
      $data = array(
        'responseType' => 0,
        'msg'          => "#UPDTAREDTLS3821: Update fail in settlement_area_history : " . $case_no,
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
      'case_no'              => $case_no,
      'proceeding_id'        => $proceeding_id,
      'date_of_hearing'      => date('Y-m-d H:i:s'),
      'next_date_of_hearing' => date('Y-m-d H:i:s'),
      'note_on_order'        => 'Area Updated',
      'status'               => 'W',
      'user_code'            => $this->session->userdata('user_code'),
      'date_entry'           => date('Y-m-d H:i:s'),
      'operation'            => 'E',
      'ip'                   => $this->utilityclass->get_client_ip(),
      'office_from'          => 'CO',
      'office_to'            => 'CO',
      'task'                 => 'CO has changed the Area',
      'note_type'            => null,
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

    $this->db->trans_commit();

    //*****getting the total applied area from db to check if it exceeds any area conditions*/
    $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));

    if ($sql->num_rows() <= 0) {
      $this->db->trans_rollback();
      $data = array(
        'responseType' => 0,
        'msg'          => "#FETCH0001: Error in fetching data from settlement_dag_details ! . $case_no",
      );
      echo json_encode($data);
      return false;
    }

    $fresh_area_details = $sql->result();

    $total_settlement_home_lessa = 0;
    $total_settlement_home_ganda = 0;
    $total_settlement_agri_ganda = 0;
    $total_settlement_agri_lessa = 0;

    foreach ($fresh_area_details as $fresh_area) {

      $settlement_area_home_bigha = (float)$fresh_area->applied_b;
      $settlement_area_home_kahta = (float)$fresh_area->applied_k;
      $settlement_area_home_lessa = (float)$fresh_area->applied_lc;
      $settlement_area_home_ganda = (float)$fresh_area->applied_g;

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
        //****total settlement area in all dags */
        $total_settlement_home_ganda = $total_settlement_home_ganda + $this->ncutility->Total_ganda($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa, $settlement_area_home_ganda);
      } else {
        //****total settlement area in all dags */
        $total_settlement_home_lessa = $total_settlement_home_lessa + $this->ncutility->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa);
      }
    }

    if (in_array($distCode, json_decode(BARAK_VALLEY))) {
      $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_home_ganda);
    } else {
      $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_home_lessa);
    }

    //**** if data intserted successfully*/
    $data = array(
      'responseType'            => 2,
      'totalSettlementAreaHome' => $total_settlement_area_home_formated,
      'totalSettlementAreaAgri' => 0,
      'appnData'                => $areaUpdateArr,
      'msg'                     => "Area updated successfully...",
    );
    echo json_encode($data);
  }


  //****Add settlement_applicant*** */
  public function addApplicantDetails()
  {
      //****getting the data  */
      $case_no = $this->input->post('case_no');

      //******backend validation */
      //***delimiter for not returning <p> tag */
      $this->form_validation->set_error_delimiters('', '');
      $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
      $this->form_validation->set_rules('add_applicant_name_ass', 'Pattadar Name', 'trim|required');
      $this->form_validation->set_rules('add_applicant_name_eng', 'Pattadar English Name', 'trim|required');
      $this->form_validation->set_rules('add_guardian_name_ass', 'Pattadar Guardian', 'trim|required');
      $this->form_validation->set_rules('add_guardian_name_eng', 'Pattadar English Guardian', 'trim|required');
      $this->form_validation->set_rules('add_relation', 'Pattadar Guardian Relation', 'trim|required');
      $this->form_validation->set_rules('add_gender', 'Pattadar Gender ', 'trim|required');
      $this->form_validation->set_rules('add_dob', 'DOB', 'required');
      $this->form_validation->set_rules('add_marital_status', 'Marital Status.', 'trim|required');
      $this->form_validation->set_rules('add_mobile', 'Pattadar Mobile No.', 'trim|required');
      $this->form_validation->set_rules('add_per_address', 'Pattadar Address 1', 'trim|required');
      $this->form_validation->set_rules('add_pre_address', 'Pattadar Address 2', 'trim|required');

      if ($this->form_validation->run() == false) {
          $data = [
              'responseType' => 0,
              'msg'          => "#SETTLAPPBACK00013:" . validation_errors() . "#case_no : " . $case_no,
          ];
          echo json_encode($data);
          return false;
      }

      $this->db->trans_begin();

      $basicData = $this->db->select()->where('case_no', $case_no)->get('settlement_basic')->row();
      //*******pdar_cron number generation */
      $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no);

      //get count from table
      $count = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? and pdar_type=?",
          [$case_no, 'B'])->num_rows();

      $addApplicantDetailsArr = [
          'dist_code'          => $basicData->dist_code,
          'subdiv_code'        => $basicData->subdiv_code,
          'cir_code'           => $basicData->cir_code,
          'mouza_pargona_code' => $basicData->mouza_pargona_code,
          'lot_no'             => $basicData->lot_no,
          'vill_townprt_code'  => $basicData->vill_townprt_code,
          'user_code'          => $this->session->userdata('user_code'),
          'case_no'            => $case_no,
          'petition_no'        => $basicData->petition_no,
          'operation'          => 'E',
          'dag_no'             => 0,
          'patta_no'           => 0,
          'patta_type_code'    => 0,
          'year_no'            => date('Y'),
          'date_entry'         => date('Y-m-d'),
          'pdar_id'            => '-1',
          'pdar_cron_no'       => $cron_no,
          'pdar_type'          => 'B',
          'is_applicant'       => 0,
          'identity_ref_no'    => null,
          'identity_type'      => null,
          'identity_doc_link'  => null,
          'pdar_name'          => trim($this->input->post('add_applicant_name_ass')),
          'eng_pdar_name'      => trim($this->input->post('add_applicant_name_eng')),
          'pdar_guardian'      => trim($this->input->post('add_guardian_name_ass')),
          'eng_pdar_guardian'  => trim($this->input->post('add_guardian_name_eng')),
          'pdar_rel_guar'      => trim($this->input->post('add_relation')),
          'pdar_gender'        => trim($this->input->post('add_gender')),
          'dob'                => trim($this->input->post('add_dob')),
          'marital_status'     => trim($this->input->post('add_marital_status')),
          'pdar_mobile'        => trim($this->input->post('add_mobile')),
          'pdar_add1'          => trim($this->input->post('add_per_address')),
          'pdar_add2'          => trim($this->input->post('add_pre_address')),
      ];

      $addsSetApplicant = $this->db->insert('settlement_applicant', $addApplicantDetailsArr);
      // var_dump($this->db->last_query()); die;
      $id                                      = $this->db->insert_id();
      $addApplicantDetailsArr['relation_name'] = $this->utilityclass->get_relation_id($this->input->post('add_relation'));
      if ($this->input->post('add_gender') == "1") {
          $gender = 'Male';
      } else if ($this->input->post('add_gender') == "2") {
          $gender = 'Female';
      } else if ($this->input->post('add_gender') == "3") {
          $gender = 'Others';
      }
      $addApplicantDetailsArr['id']     = $id;
      $addApplicantDetailsArr['count']  = $count + 1;
      $addApplicantDetailsArr['gender'] = $gender;

      //*******check if data inserted */
      if ($addsSetApplicant != 1) {
          $this->db->trans_rollback();
          log_message('error', '#SETTLAPP00011: Insert failed in settlement_applicant ' . $case_no);
          $data = [
              'responseType' => 0,
              'msg'          => "#SETTLAPP00011: Insert failed in settlement_applicant : " . $case_no,
          ];
          echo json_encode($data);
          return false;
      }

      $this->db->trans_commit();
      //**** if data intserted successfully*/
      $data = [
          'responseType' => 2,
          'appnData'     => $addApplicantDetailsArr,
          'msg'          => "Applicant inserted successfully...",
      ];
      echo json_encode($data);

  }


  // Delete applicant
  public function delApplicantDetails()
  {
      $this->db->trans_begin();
      $id      = $this->input->post('id');
      $case_no = $this->input->post('case_no');

      $sql    = "delete from settlement_applicant where id='$id' and case_no='$case_no'";
      $result = $this->db->query($sql);
      if ($this->db->affected_rows() != 1) {
          $this->db->trans_rollback();
          $response['status'] = 0;
          echo json_encode(['status' => 0]);
          log_message("error", "#PROP00023 Failed to delete applicant: " . $id);
          return;
      } else {
          $this->db->trans_commit();

          //get count from table
          $count = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=?",
              [$case_no])->num_rows();

          $response['status'] = 200;
          echo json_encode(['status' => 200, 'count' => $count]);
          return;
      }
  }



}
