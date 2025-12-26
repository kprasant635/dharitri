<?php
class TeaGrantModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('ChithaUpdateModel');
    }

    public function getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no){
        $get_riotees = $this->db->select()
            ->where('dist_code',$d)
            ->where('subdiv_code',$s)
            ->where('cir_code',$c)
            ->where('mouza_pargona_code',$m)
            ->where('lot_no',$l)
            ->where('vill_townprt_code',$v)
            ->where('dag_no',$dag)
            ->where('khatian_no',$khatian_no)

            ->get('chitha_tenant');

        return $get_riotees->result();
    }

    // get all settlement basic
    public function getSettlementBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_basic');
        return $basic->row_array();
    }

    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }
    // get all applicant encroacher
    public function getAllApplicantDagDetails($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where("pdar_type IN ('EP','DA')")
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // get all applicant riotee nok
    public function getAllApplicantRioteeNok($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where_in('pdar_type', ['P','GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get all settlement tenant lm note
    public function getSettlementTenantLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('settlement_ap_lmnote');
        return $lmnotes->result();
    }

    // get all settlement proceeding
    public function getSettlementProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getDocuments($case)
    {
        $applicaiton_no = $this->utilityclass->getApplidFromCaseNo($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
            ->get('settlement_additional_property');

        return $property->result();
    }


    //17/01/2022
    // get main buyer applicant
    public function getMainApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->where('is_applicant', '1')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }

    // get all (EP) applicant
    public function getAllExistingPattadar($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EP')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all (DA) applicant
    public function getAllDeedPattadar($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'DA')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all ('P', 'GP', 'GGP') applicant
    public function getAllFamilyTree($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where("pdar_type IN ('P', 'GP', 'GGP')")
            ->get('settlement_applicant');
        return $applicants->result();
    }
    

    public function getJsonDataFromBackup($case_no)
    {
        $sql = $this->db->query("SELECT data FROM settlement_backup_json WHERE case_no = ? AND status = ?", array($case_no, 'I'));
        if($sql->num_rows() > 0){
            return $sql->row();
        }
        else
        {
            return false;
        }
    }

    // get all settlement deleted dags
    public function getDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details_deleted');

        return $dags->result();
    }


    function paymentConfirmation($basundhara){
        $caseRtpsBasu=$this->SettlementMbModel->checkRtpsService($basundhara);
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


    public function getApplierDetail($case)
    {
        return $query = $this->db->query("SELECT * FROM settlement_dag_details sdd join settlement_applicant sa ON sdd.case_no=sa.case_no WHERE sdd.case_no=? and sdd.dag_no=sa.dag_no",array($case))->result();
    }


    public function getAppliedApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->where('is_applicant', '1')
            ->get('settlement_applicant');
        return $applicants->row();
    }

    public function appRelationById($id) {
        return $query = $this->db->query("SELECT guard_rel_desc AS name 
                            FROM master_guard_rel WHERE id=?", array($id))->row()->name;
    }


    //for assamese input
    public function checkAssameseCharacterOnly($char)
    {
      $len      = mb_strlen($char, "utf8");
      $error    = '';
      $asminput = '';
      for($i = 0; $i <= ($len -1); $i++)
      {
        $asminput = mb_substr($char, $i,1);

        if($asminput != mb_convert_encoding('&#2433;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2434;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2435;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2437;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2438;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2439;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2440;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2441;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2442;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2443;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2444;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2447;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2448;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2451;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2452;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2453;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2454;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2455;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2456;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2457;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2458;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2459;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2460;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2461;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2462;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2463;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2464;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2465;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2466;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2467;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2468;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2469;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2470;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2471;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2472;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2474;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2475;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2476;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2477;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2478;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2479;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2480;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2482;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2486;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2487;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2488;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2489;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2492;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2494;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2495;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2496;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2497;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2498;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2499;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2500;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2503;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2504;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2507;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2508;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2509;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2519;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2524;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2525;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2527;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2528;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2529;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2530;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2531;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2534;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2535;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2536;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2537;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2538;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2539;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2540;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2541;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2542;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2543;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2544;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2545;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2546;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2547;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2548;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2549;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2550;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2551;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2552;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2553;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2554;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#2510;','UTF-8','HTML-ENTITIES') 
          && $asminput != mb_convert_encoding('&#32;','UTF-8','HTML-ENTITIES'))
        {
          $error = "Please enter only assamese characters!";
        }
      }
      return $error;
    }

    public function getLegalHeirList($case_no)
    {
        return $q = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND flag_legal_heir=?",
                        array($case_no, 'Y'))->result();
    }


    // get all settlement proceeding
    public function getAdditionalPropertyCount($case)
    {
        $property = $this->db->select()
            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
            ->get('settlement_additional_property');

        return $property->num_rows();
    }


    // get all settlement proceeding
    public function getSroRemark($case)
    {
        $sroRemark = $this->db->select()
            ->where('case_no',$case)
            ->where('action', 'Y')
            ->where('is_deed_valid', 'Y')
            ->get('sro_push_history');

        return $sroRemark->row();
    }


    public function getMainBuyerApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->where('is_applicant', '1')
            ->get('settlement_applicant');
        return $applicants->row();
    }

    // // message to display
    // public function getApplicantToBeSettled($case)
    // {
    //   $msg = '';
    //   $fromOtherBuyer = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? AND is_applicant=?", 
    //                         array($case, 'B', 0));

    //   $fromSettApplTable = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? AND is_applicant=?", 
    //                             array($case, 'B', 1));

    //   // check for existing applicant
    //   $getEp = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?", array($case, 'EP'));

    //   // check for deed applicant
    //   $getDa = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?", array($case, 'DA'));
      
    //   if($fromSettApplTable->row()->pdar_type == 'B' && $fromOtherBuyer->num_rows() == 0)
    //   {
    //     $msg = 'The outcome of this case will be a PARTITION, subsequently followed by CONVERSION';
    //   }
    //   if($fromSettApplTable->row()->pdar_type == 'B' && $fromOtherBuyer->num_rows() != 0)
    //   {
    //     $msg = 'The outcome of this case shall involve MUTATION with PARTITION, followed by a process of CONVERSION';
    //   }
    //   return $msg;
    // }

    public function checkIfSroVerified($case)
    {
      return $sroReport = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? AND 
                      sro_code IS NOT NULL AND action=?", array($case, 'Y'))->num_rows();
    }

    public function sroReplyRemarks($case)
    { 
      $msg = '';

        $sroReport = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? AND 
                       sro_code IS NOT NULL AND action IN (?, ?) ORDER BY slno DESC LIMIT 1", array($case, 'Y', 'N'));
        if($sroReport->num_rows() == 0)
        {
            $msg = "";
        }
        else
        {
            $sroReport = $sroReport->row();
            $msg = $sroReport->remark.'. Date: '.date('d/m/Y', strtotime($sroReport->date_of_update));
        }
        return $msg;
    }

    // get land class code from chitha basic
    public function getLandClassDetail($d, $s, $c, $m, $l, $v, $pn, $ptype, $dag)
    {
      return $cb = $this->db->query("SELECT cb.land_class_code, lc.land_type FROM chitha_basic cb JOIN landclass_code lc 
                      ON cb.land_class_code=lc.class_code WHERE cb.dist_code=? AND cb.subdiv_code=? AND cb.cir_code=? 
                        AND cb.mouza_pargona_code=? AND cb.lot_no=? AND cb.vill_townprt_code=? AND cb.patta_no=? 
                          AND cb.patta_type_code=? AND trim(cb.dag_no)=?", 
                            array($d, $s, $c, $m, $l, $v, $pn, $ptype, $dag))->row();
    }

    // get land class name by code
    public function getLandClassName($landCode)
    {
        return $q = $this->db->query("SELECT land_type FROM landclass_code WHERE class_code=?", array($landCode))->row()->land_type;
    }


    // get all settlement dag
    // public function getSettlementDag($case)
    // {
    //     $dags = $this->db->select()
    //         ->where('case_no',$case)
    //         ->get('settlement_dag_details');

    //     return $dags->result();
    // }


    // public function updateTeaGrantApplicantData()
    // {
    //   // ['35','08','25','02','17','03','14','36','15','24','21','12','34','32','33','06','16','11','37','18','07','10','38','13','05','39','22']

    //   // 12, 32, 24, 33, 17, 15,35, 14,22,18,11,16,08, 

    //   // [12, 24, 33, 17, 15, 35, 14, 22, 18, 32, 11, 16, 08, 37] // total district in rtps end where applied

    //   $dharDb = $this->load->database('morigaon', true);

    //   $secret_key = '#b$*))_++basun!!dhar_app^tree_php.create_';
    //   $timestamp  = date("Y-m-d H:i:s");
    //   $jwt        = new JWT();
    //   $key        = $secret_key;
    //   $payload    = array(
    //     "timestamp" => $timestamp
    //   );
    //   $token = $jwt->encode($payload, $key, 'HS256');

    //   $api_link = 'https://basundhara.assam.gov.in/rtpsmb/ApiMbThree/';
    //   $api_key  = 'DHARITREE_MB2';

    //   // get detail from settlement basic
    //   $fromBasic = $dharDb->query("SELECT * FROM settlement_basic WHERE service_code=? ", array('43'))->result();

    //   foreach($fromBasic as $row) // start of foreach 1
    //   {
    //     $case_no        = $row->case_no;
    //     $application_no = $row->applid;

    //     $curl_handle = curl_init();
    //     curl_setopt($curl_handle, CURLOPT_URL, $api_link."getAppDetails");
    //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //       'application_no' => $application_no,
    //       'api_key'        => $api_key,
    //       'token'          => $token
    //     )));

    //     $output = curl_exec($curl_handle);
    //     if(isset(json_decode($output)->responseType)){
    //       if(json_decode($output)->responseType == 3){
    //         echo json_decode($output)->data." - Unauthorized access!";
    //         return false;
    //       }
    //     }
    //     curl_close($curl_handle);
    //     $backup = $output;
    //     $output = json_decode($output);

    //     // get all applicants
    //     $allApplicants = $output->settlements;

    //     // check if the other applicants are available in dharitree table
    //     if(isset($allApplicants)) { // start of if 2

    //       $i = 0;

    //       foreach($allApplicants as $setl) // start of foreach2
    //       {
    //         $i++;

    //         // get max cron no
    //         $pdar_cron_no = $dharDb->query("SELECT max(pdar_cron_no)+1 as c FROM settlement_applicant WHERE case_no=?", 
    //                             array($case_no))->row()->c;

    //         if($setl->pdar_type == 'EP') // existing pattadar
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE pdar_id=? AND case_no=? AND pdar_type=? 
    //                               AND dag_no=?", array($setl->pdar_id, $case_no, 'EP', $setl->dag_no));

    //           if($checkSettAppl->num_rows() == 0) // if EP not available in dharitree end
    //           {
    //             // insert into settlement_applicant table
    //             $insertExistingPattadar = [
    //               'dist_code'             => $setl->dist_code,
    //               'subdiv_code'           => $setl->subdiv_code,
    //               'cir_code'              => $setl->cir_code,
    //               'mouza_pargona_code'    => $setl->mouza_pargona_code,
    //               'lot_no'                => $setl->lot_no,
    //               'vill_townprt_code'     => $setl->vill_townprt_code,
    //               'year_no'               => $row->year_no,
    //               'petition_no'           => $row->petition_no,
    //               'dag_no'                => $setl->dag_no,
    //               'patta_no'              => $setl->patta_no,
    //               'patta_type_code'       => $setl->patta_type_code,
    //               'pdar_id'               => $setl->pdar_id,
    //               'pdar_cron_no'          => $pdar_cron_no++,
    //               'pdar_name'             => $setl->pdar_name,
    //               'pdar_guardian'         => $setl->pdar_father,
    //               'pdar_rel_guar'         => 0,
    //               'pdar_add1'             => null,
    //               'pdar_add2'             => null,
    //               'user_code'             => $row->user_code,
    //               'date_entry'            => date('Y-m-d', strtotime($row->date_entry)),
    //               'operation'             => 'E',
    //               'pdar_gender'           => null,
    //               'pdar_mother'           => null,
    //               'striked_out'           => null,
    //               'pdar_mobile'           => null,
    //               'aadhar_no'             => null,
    //               'case_no'               => $case_no,
    //               'i_area_b'              => null,
    //               'i_area_k'              => null,
    //               'i_area_lc'             => null,
    //               'i_area_g'              => null,
    //               'i_area_kr'             => null,
    //               'pdar_type'             => 'EP', 
    //               'date_update'           => null,
    //               'inplace_alongwith'     => null,
    //               'riotee_id'             => null,
    //               'khatian_no'            => null,
    //               'enc_id'                => null,
    //               'period_possession'     => null,
    //               'caste'                 => null,
    //               'bpl'                   => null,
    //               'is_applicant'          => 0,
    //               'identity_ref_no'       => null,
    //               'identity_type'         => null,
    //               'identity_doc_link'     => null,
    //               'marital_status'        => null,
    //               'dob'                   => null,
    //               'eng_pdar_name'         => $setl->pdar_name_eng,
    //               'eng_pdar_guardian'     => $setl->pdar_father_eng,
    //               'encroacher_exist_vlb'  => null,
    //               'applicant_eligibility' => null,
    //               'ekyc_done'             => null,
    //               'del_status'            => null,
    //               'mask_id'               => null,
    //               'protected_category'    => null,
    //               'a_occupation'          => null,
    //               'flag_legal_heir'       => null,
    //               'life_status'           => null,
    //               'nc_encroacher'         => null,
    //               'living_status'         => $setl->living_status,
    //               'is_pattadar'           => $setl->is_pattadar,
    //               'date_of_death'         => $setl->date_of_death == null ? null : $setl->date_of_death,
    //             ]; 

    //             $insertExtPattadars = $dharDb->insert('settlement_applicant', $insertExistingPattadar);
    //             if($insertExtPattadars != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_EP : insertion failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             }
    //             log_message('error', "TEA_GRANT_APPL_DA : ($i) Successfully inserted deed applicant in settlement_applicant for case no $case_no");             
    //           }
    //         } // end of if EP

    //         if($setl->pdar_type == 'DA') // deed applicant
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? 
    //                               AND dag_no=?", array($case_no, 'DA', $setl->dag_no));

    //           if($checkSettAppl->num_rows() == 0) // if DA not available in dharitree end
    //           {
    //             // insert into settlement_applicant table
    //             $insertDeedApplicant = [
    //               'dist_code'             => $setl->dist_code,
    //               'subdiv_code'           => $setl->subdiv_code,
    //               'cir_code'              => $setl->cir_code,
    //               'mouza_pargona_code'    => $setl->mouza_pargona_code,
    //               'lot_no'                => $setl->lot_no,
    //               'vill_townprt_code'     => $setl->vill_townprt_code,
    //               'year_no'               => $row->year_no,
    //               'petition_no'           => $row->petition_no,
    //               'dag_no'                => $setl->dag_no,
    //               'patta_no'              => $setl->patta_no,
    //               'patta_type_code'       => $setl->patta_type_code,
    //               'pdar_id'               => $setl->pdar_id,
    //               'pdar_cron_no'          => $pdar_cron_no++,
    //               'pdar_name'             => $setl->pdar_name,
    //               'pdar_guardian'         => $setl->pdar_father,
    //               'pdar_rel_guar'         => $setl->relation,
    //               'pdar_add1'             => null,
    //               'pdar_add2'             => null,
    //               'user_code'             => $row->user_code,
    //               'date_entry'            => date('Y-m-d', strtotime($row->date_entry)),
    //               'operation'             => 'E',
    //               'pdar_gender'           => $setl->pdar_gender,
    //               'pdar_mother'           => null,
    //               'striked_out'           => null,
    //               'pdar_mobile'           => $setl->mobile,
    //               'aadhar_no'             => null,
    //               'case_no'               => $case_no,
    //               'i_area_b'              => null,
    //               'i_area_k'              => null,
    //               'i_area_lc'             => null,
    //               'i_area_g'              => null,
    //               'i_area_kr'             => null,
    //               'pdar_type'             => 'DA', 
    //               'date_update'           => null,
    //               'inplace_alongwith'     => null,
    //               'riotee_id'             => null,
    //               'khatian_no'            => null,
    //               'enc_id'                => null,
    //               'period_possession'     => null,
    //               'caste'                 => null,
    //               'bpl'                   => null,
    //               'is_applicant'          => 0,
    //               'identity_ref_no'       => null,
    //               'identity_type'         => null,
    //               'identity_doc_link'     => null,
    //               'marital_status'        => null,
    //               'dob'                   => null,
    //               'eng_pdar_name'         => $setl->pdar_name_eng,
    //               'eng_pdar_guardian'     => $setl->pdar_father_eng,
    //               'encroacher_exist_vlb'  => null,
    //               'applicant_eligibility' => null,
    //               'ekyc_done'             => null,
    //               'del_status'            => null,
    //               'mask_id'               => null,
    //               'protected_category'    => null,
    //               'a_occupation'          => null,
    //               'flag_legal_heir'       => null,
    //               'life_status'           => null,
    //               'nc_encroacher'         => null,
    //               'living_status'         => $setl->living_status,
    //               'is_pattadar'           => $setl->is_pattadar,
    //               'date_of_death'         => $setl->date_of_death == null ? null : $setl->date_of_death,
    //             ]; 

    //             $insertDeedAppl = $dharDb->insert('settlement_applicant', $insertDeedApplicant);
    //             if($insertDeedAppl != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_DA : insertion failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             } 
    //             log_message('error', "TEA_GRANT_APPL_DA : ($i) Successfully inserted deed applicant in settlement_applicant for case no $case_no");           
    //           }
    //         } // end of if DA


    //         if($setl->pdar_type == 'O') // Owner
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE pdar_id=? AND case_no=? AND pdar_type=? 
    //                               AND dag_no=?", array($setl->pdar_id, $case_no, 'O', $setl->dag_no));

    //           if($checkSettAppl->num_rows() == 0) // if O not available in dharitree end
    //           {
    //             // insert into settlement_applicant table
    //             $insertOwnerDetail = [
    //               'dist_code'             => $setl->dist_code,
    //               'subdiv_code'           => $setl->subdiv_code,
    //               'cir_code'              => $setl->cir_code,
    //               'mouza_pargona_code'    => $setl->mouza_pargona_code,
    //               'lot_no'                => $setl->lot_no,
    //               'vill_townprt_code'     => $setl->vill_townprt_code,
    //               'year_no'               => $row->year_no,
    //               'petition_no'           => $row->petition_no,
    //               'dag_no'                => $setl->dag_no,
    //               'patta_no'              => $setl->patta_no,
    //               'patta_type_code'       => $setl->patta_type_code,
    //               'pdar_id'               => $setl->pdar_id,
    //               'pdar_cron_no'          => $pdar_cron_no++,
    //               'pdar_name'             => $setl->pdar_name,
    //               'pdar_guardian'         => $setl->pdar_father == null ? null : $setl->pdar_father,
    //               'pdar_rel_guar'         => 0,
    //               'pdar_add1'             => null,
    //               'pdar_add2'             => null,
    //               'user_code'             => $row->user_code,
    //               'date_entry'            => date('Y-m-d', strtotime($row->date_entry)),
    //               'operation'             => 'E',
    //               'pdar_gender'           => null,
    //               'pdar_mother'           => null,
    //               'striked_out'           => null,
    //               'pdar_mobile'           => null,
    //               'aadhar_no'             => null,
    //               'case_no'               => $case_no,
    //               'i_area_b'              => null,
    //               'i_area_k'              => null,
    //               'i_area_lc'             => null,
    //               'i_area_g'              => null,
    //               'i_area_kr'             => null,
    //               'pdar_type'             => 'O', 
    //               'date_update'           => null,
    //               'inplace_alongwith'     => 'i',
    //               'riotee_id'             => null,
    //               'khatian_no'            => null,
    //               'enc_id'                => null,
    //               'period_possession'     => null,
    //               'caste'                 => null,
    //               'bpl'                   => null,
    //               'is_applicant'          => 0,
    //               'identity_ref_no'       => null,
    //               'identity_type'         => null,
    //               'identity_doc_link'     => null,
    //               'marital_status'        => null,
    //               'dob'                   => null,
    //               'eng_pdar_name'         => null,
    //               'eng_pdar_guardian'     => null,
    //               'encroacher_exist_vlb'  => null,
    //               'applicant_eligibility' => null,
    //               'ekyc_done'             => null,
    //               'del_status'            => null,
    //               'mask_id'               => null,
    //               'protected_category'    => null,
    //               'a_occupation'          => null,
    //               'flag_legal_heir'       => null,
    //               'life_status'           => null,
    //               'nc_encroacher'         => null,
    //               'living_status'         => null,
    //               'is_pattadar'           => $setl->is_pattadar,
    //               'date_of_death'         => null,
    //             ]; 

    //             $insertOwner = $dharDb->insert('settlement_applicant', $insertOwnerDetail);
    //             if($insertOwner != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_O : insertion failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             }
    //             log_message('error', "TEA_GRANT_APPL_O : ($i) Successfully inserted owner detail in settlement_applicant for case no $case_no");            
    //           }
    //         } // end of if O

    //         if($setl->pdar_type == 'GP') // grand parent
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?",
    //                           array($case_no, 'GP'));

    //           if($checkSettAppl->num_rows() == 0) // if GP not available in dharitree end
    //           {
    //             // insert into settlement_applicant table
    //             $insertGrandParentDetail = [
    //               'dist_code'             => $setl->dist_code,
    //               'subdiv_code'           => $setl->subdiv_code,
    //               'cir_code'              => $setl->cir_code,
    //               'mouza_pargona_code'    => $setl->mouza_pargona_code,
    //               'lot_no'                => $setl->lot_no,
    //               'vill_townprt_code'     => $setl->vill_townprt_code,
    //               'year_no'               => $row->year_no,
    //               'petition_no'           => $row->petition_no,
    //               'dag_no'                => 0,
    //               'patta_no'              => 0,
    //               'patta_type_code'       => 0,
    //               'pdar_id'               => $setl->pdar_id,
    //               'pdar_cron_no'          => $pdar_cron_no++,
    //               'pdar_name'             => $setl->pdar_name,
    //               'pdar_guardian'         => $setl->pdar_father,
    //               'pdar_rel_guar'         => $setl->relation,
    //               'pdar_add1'             => null,
    //               'pdar_add2'             => null,
    //               'user_code'             => $row->user_code,
    //               'date_entry'            => date('Y-m-d', strtotime($row->date_entry)),
    //               'operation'             => 'E',
    //               'pdar_gender'           => null,
    //               'pdar_mother'           => null,
    //               'striked_out'           => null,
    //               'pdar_mobile'           => $setl->mobile,
    //               'aadhar_no'             => null,
    //               'case_no'               => $case_no,
    //               'i_area_b'              => null,
    //               'i_area_k'              => null,
    //               'i_area_lc'             => null,
    //               'i_area_g'              => null,
    //               'i_area_kr'             => null,
    //               'pdar_type'             => 'GP', 
    //               'date_update'           => null,
    //               'inplace_alongwith'     => null,
    //               'riotee_id'             => null,
    //               'khatian_no'            => null,
    //               'enc_id'                => null,
    //               'period_possession'     => null,
    //               'caste'                 => null,
    //               'bpl'                   => null,
    //               'is_applicant'          => 0,
    //               'identity_ref_no'       => null,
    //               'identity_type'         => null,
    //               'identity_doc_link'     => null,
    //               'marital_status'        => null,
    //               'dob'                   => null,
    //               'eng_pdar_name'         => $setl->pdar_name_eng,
    //               'eng_pdar_guardian'     => $setl->pdar_father_eng,
    //               'encroacher_exist_vlb'  => null,
    //               'applicant_eligibility' => null,
    //               'ekyc_done'             => null,
    //               'del_status'            => null,
    //               'mask_id'               => null,
    //               'protected_category'    => null,
    //               'a_occupation'          => null,
    //               'flag_legal_heir'       => null,
    //               'life_status'           => null,
    //               'nc_encroacher'         => null,
    //               'living_status'         => $setl->living_status,
    //               'is_pattadar'           => $setl->is_pattadar,
    //               'date_of_death'         => $setl->date_of_death == null ? null : $setl->date_of_death,
    //             ]; 

    //             $insertGp = $dharDb->insert('settlement_applicant', $insertGrandParentDetail);
    //             if($insertGp != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_GP : insertion failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             }

    //             log_message('error', "TEA_GRANT_APPL_GP : ($i) Successfully inserted grand parent detail in settlement_applicant for case no $case_no");              
    //           }
    //         } // end of if GP

    //         if($setl->pdar_type == 'P') // grand parent
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?",
    //                           array($case_no, 'P'));

    //           if($checkSettAppl->num_rows() == 0) // if P not available in dharitree end
    //           {
    //             // insert into settlement_applicant table
    //             $insertParentDetail = [
    //               'dist_code'             => $setl->dist_code,
    //               'subdiv_code'           => $setl->subdiv_code,
    //               'cir_code'              => $setl->cir_code,
    //               'mouza_pargona_code'    => $setl->mouza_pargona_code,
    //               'lot_no'                => $setl->lot_no,
    //               'vill_townprt_code'     => $setl->vill_townprt_code,
    //               'year_no'               => $row->year_no,
    //               'petition_no'           => $row->petition_no,
    //               'dag_no'                => 0,
    //               'patta_no'              => 0,
    //               'patta_type_code'       => 0,
    //               'pdar_id'               => $setl->pdar_id,
    //               'pdar_cron_no'          => $pdar_cron_no++,
    //               'pdar_name'             => $setl->pdar_name,
    //               'pdar_guardian'         => $setl->pdar_father,
    //               'pdar_rel_guar'         => $setl->relation,
    //               'pdar_add1'             => null,
    //               'pdar_add2'             => null,
    //               'user_code'             => $row->user_code,
    //               'date_entry'            => date('Y-m-d', strtotime($row->date_entry)),
    //               'operation'             => 'E',
    //               'pdar_gender'           => null,
    //               'pdar_mother'           => null,
    //               'striked_out'           => null,
    //               'pdar_mobile'           => $setl->mobile,
    //               'aadhar_no'             => null,
    //               'case_no'               => $case_no,
    //               'i_area_b'              => null,
    //               'i_area_k'              => null,
    //               'i_area_lc'             => null,
    //               'i_area_g'              => null,
    //               'i_area_kr'             => null,
    //               'pdar_type'             => 'P', 
    //               'date_update'           => null,
    //               'inplace_alongwith'     => null,
    //               'riotee_id'             => null,
    //               'khatian_no'            => null,
    //               'enc_id'                => null,
    //               'period_possession'     => null,
    //               'caste'                 => null,
    //               'bpl'                   => null,
    //               'is_applicant'          => 0,
    //               'identity_ref_no'       => null,
    //               'identity_type'         => null,
    //               'identity_doc_link'     => null,
    //               'marital_status'        => null,
    //               'dob'                   => null,
    //               'eng_pdar_name'         => $setl->pdar_name_eng,
    //               'eng_pdar_guardian'     => $setl->pdar_father_eng,
    //               'encroacher_exist_vlb'  => null,
    //               'applicant_eligibility' => null,
    //               'ekyc_done'             => null,
    //               'del_status'            => null,
    //               'mask_id'               => null,
    //               'protected_category'    => null,
    //               'a_occupation'          => null,
    //               'flag_legal_heir'       => null,
    //               'life_status'           => null,
    //               'nc_encroacher'         => null,
    //               'living_status'         => $setl->living_status,
    //               'is_pattadar'           => $setl->is_pattadar,
    //               'date_of_death'         => $setl->date_of_death == null ? null : $setl->date_of_death,
    //             ]; 

    //             $insertGp = $dharDb->insert('settlement_applicant', $insertParentDetail);
    //             if($insertGp != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_P : insertion failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             }

    //             log_message('error', "TEA_GRANT_APPL_P : ($i) Successfully inserted parent detail in settlement_applicant for case no $case_no");              
    //           }
    //         } // end of if P

    //       } // end of foreach 2
    //     } // end of if 2

    //   } // end of foreach 1
    // }

    // public function updateRelationMainApplicant()
    // {
    //   // ['35','08','25','02','17','03','14','36','15','24','21','12','34','32','33','06','16','11','37','18','07','10','38','13','05','39','22']

    //   // [12, 24, 33, 17, 15, 35, 14, 22, 18, 32, 11, 16, 08, 37] // total district in rtps end where applied

    //   $dharDb = $this->load->database('morigaon', true);

    //   $secret_key = '#b$*))_++basun!!dhar_app^tree_php.create_';
    //   $timestamp  = date("Y-m-d H:i:s");
    //   $jwt        = new JWT();
    //   $key        = $secret_key;
    //   $payload    = array(
    //     "timestamp" => $timestamp
    //   );
    //   $token = $jwt->encode($payload, $key, 'HS256');

    //   $api_link = 'https://basundhara.assam.gov.in/rtpsmb/ApiMbThree/';
    //   $api_key  = 'DHARITREE_MB2';

    //   // get detail from settlement basic
    //   $fromBasic = $dharDb->query("SELECT * FROM settlement_basic WHERE service_code=?", array('43'))->result();

    //   foreach($fromBasic as $row) // start of foreach 1
    //   {
    //     $case_no        = $row->case_no;
    //     $application_no = $row->applid;

    //     $curl_handle = curl_init();
    //     curl_setopt($curl_handle, CURLOPT_URL, $api_link."getAppDetails");
    //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //       'application_no' => $application_no,
    //       'api_key'        => $api_key,
    //       'token'          => $token
    //     )));

    //     $output = curl_exec($curl_handle);
    //     if(isset(json_decode($output)->responseType)){
    //       if(json_decode($output)->responseType == 3){
    //         echo json_decode($output)->data." - Unauthorized access!";
    //         return false;
    //       }
    //     }
    //     curl_close($curl_handle);
    //     $backup = $output;
    //     $output = json_decode($output);

    //     // get all applicants
    //     $allApplicants = $output->settlements;

    //     // check if the other applicants are available in dharitree table
    //     if(isset($allApplicants)) { // start of if 2

    //       $i = 0;

    //       foreach($allApplicants as $setl) // start of foreach2
    //       {
    //         $i++;

    //         if($setl->pdar_type == 'B' && $setl->is_applicant == 1) // main applicant
    //         {
    //           // check if pdar_id is available in settlement_applicant table
    //           $checkSettAppl = $dharDb->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=? 
    //                               AND is_applicant=?", array($case_no, 'B', 1));

    //           if($checkSettAppl->num_rows() == 1) // if EP not available in dharitree end
    //           {
    //             $updateRelation = $dharDb->query("UPDATE settlement_applicant SET relation_with_pattadar=? WHERE case_no=? 
    //                                 AND is_applicant=? AND pdar_type=?", array($setl->relation_with_pattadar, $case_no, 1, 'B'));
    //             if($dharDb->affected_rows() != 1)
    //             {
    //               log_message('error', "TEA_GRANT_APPL_BUYER : Updation failed in settlement_applicant table for case no $case_no : ".$dharDb->last_query());
    //               return;
    //             }
    //             log_message('error', "TEA_GRANT_APPL_BUYER : ($i) Successfully updated relation of main applicant in settlement_applicant for case no $case_no");

    //             echo "TEA_GRANT_APPL_BUYER : ($i) Successfully updated relation of main applicant in settlement_applicant for case no $case_no";           
    //           }
    //         } // end of if main applicant


    //       } // end of foreach 2
    //     } // end of if 2

    //   } // end of foreach 1
    // }

    public function landClassName($code)
    {
        return $query = $this->db->query("SELECT * FROM land_class_groups WHERE land_class_code=?",array($code))->row();
    }

    public function checkAllReportGivenByLm($case_no)
    {
        return $q = $this->db->query("SELECT lm_tea_report FROM settlement_ap_lmnote WHERE case_no=?", array($case_no))->row();
    }

    public function aadhaarPhotoView($applNo)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $applNo,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $get_aadhaar_photo;
    }

    public function fromBasundharApplication($dharCaseNo)
    {
        return $query = $this->db->query("SELECT basundhara FROM basundhar_application WHERE dharitree=?", array($dharCaseNo))->row();
    }

    public  function decodeBase64($encoded_string){
        $file_data = base64_decode($encoded_string);
        $file      = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }

    public function checkSroJuridicationSaysNo($case)
    {
      return $sroReport = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? ORDER BY slno DESC LIMIT 1", array($case));
    }


    // public function viewDalilUploadedByLra_old($dharDb, $case_no)
    // {
    //   $documents = $dharDb->query("SELECT * FROM supportive_document 
    //                     WHERE case_no=? AND file_type IS NOT NULL AND file_name=?", array($case_no, 'Dalil'));

    //   if($documents->num_rows() <= 0){
    //     return [ 'status'   => 'n', ];
    //   }
    //   else
    //   {
    //     $resp      = $documents->row();
    //     $file_path = $resp->file_path;
    //     $content   = $resp->file_type;

    //     if (file_exists($file_path))
    //     {
    //       $file     = file_get_contents($file_path);
    //       $raw_data = base64_encode($file);

    //       $response = array(
    //         'responseType' => 2,
    //         'content_type' => $content,
    //         'data'         => $raw_data,
    //       );
    //       return [
    //         'response' => json_encode($response),
    //         'status'   => 'y',
    //       ];
    //     } 
    //     else 
    //     {
    //       $response = array(
    //         'responseType' => 1,
    //         'data'         => null,
    //       );
    //       return [
    //         'response' => json_encode($response),
    //         'status'   => 'n',
    //       ];
    //     }
        
    //   }
    // }

    public function viewDalilUploadedByLra($dharDb, $case_no)
    {
        // check if LRA has uploaded or not
        $documents = $dharDb->query("SELECT * FROM supportive_document WHERE case_no=? AND file_type IS NOT NULL AND file_name=?", array($case_no, 'Dalil'));

        if ($documents->num_rows() > 0) {

            $resp      = $documents->row();
            $file_path = $resp->file_path;
            $content   = $resp->file_type;


            if (file_exists($file_path)) {

                $file     = file_get_contents($file_path);
                $raw_data = base64_encode($file);

                $response = array(
                    'responseType' => 2,
                    'content_type' => $content,
                    'data'         => $raw_data,
                );
                return [
                    'response' => json_encode($response),
                    'status'   => 'y',
                ];
            } else {
                $response = array(
                    'responseType' => 1,
                    'data'         => null,
                );
                return [
                    'response' => json_encode($response),
                    'status'   => 'n',
                ];
            }
        } else {
            $query = $dharDb->query("SELECT * FROM basundhar_application WHERE dharitree=?", array($case_no));

            if ($query->num_rows() > 0) {
                $basundhara = $query->row()->basundhara;
                $url = API_LINK_MB3 . "viewuploadedDeedfile?case=" . $basundhara;

                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                $output = curl_exec($ch);

                if ($output === false) {
                    $response = array(
                        'responseType' => 1,
                        'error'        => 'Curl error: ' . curl_error($ch),
                    );
                    curl_close($ch);
                    return [
                        'response' => json_encode($response),
                        'status'   => 'n',
                    ];
                }

                curl_close($ch);

                return [
                    'response' => $output,
                    'status'   => 'y',
                ];
            } else {
                $response = array(
                    'responseType' => 1,
                    'data'         => null,
                );
                return [
                    'response' => json_encode($response),
                    'status'   => 'n',
                ];
            }
        }
    }





    public function viewDalilUploadedByLra_old($dharDb, $case_no)
    {

      // check if LRA


      $query = $dharDb->query("SELECT * FROM basundhar_application WHERE dharitree=?", array($case_no));      

      if($query->num_rows() > 0)
      {  



        $basundhara = $query->row()->basundhara;
        $url = API_LINK_MB3."viewuploadedDeedfile?case=" . $basundhara;
        
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($output);

        if(trim($data) == 'n')
        {
          
          $documents = $dharDb->query("SELECT * FROM supportive_document WHERE case_no=? AND file_type IS NOT NULL 
                          AND file_name=?", array($case_no, 'Dalil'));
          

          if($documents->num_rows() <= 0) {
            return [ 'status'   => 'n', ];
          }
          else
          {
            $resp      = $documents->row();
            $file_path = $resp->file_path;
            $content   = $resp->file_type;

            if (file_exists($file_path))
            {
              $file     = file_get_contents($file_path);
              $raw_data = base64_encode($file);

              $response = array(
                'responseType' => 2,
                'content_type' => $content,
                'data'         => $raw_data,
              );
              return [
                'response' => json_encode($response),
                'status'   => 'y',
              ];
            } 
            else 
            {
              $response = array(
                'responseType' => 1,
                'data'         => null,
              );
              return [
                'response' => json_encode($response),
                'status'   => 'n',
              ];
            }
            
          }
        }
        else
        { 
          return [
            'response' => $output,
            'status'   => 'y',
          ];
        }
      }
      else
      {
        $response = array(
          'responseType' => 1,
          'data'         => null,
        );
        return [
          'response' => json_encode($response),
          'status'   => 'n',
        ];
      }      
    }

    public function getPattadar($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $pdar_id)
    {
        return $this->db->query('SELECT * FROM chitha_pattadar WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND 
                  mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? AND patta_no = ? AND patta_type_code = ? AND pdar_id = ?',
                    array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $pdar_id));
    }


    public function checkDataInTeaHistory($case_no)
    {
        return $this->db->query('SELECT * FROM history_tea_grant_modify WHERE case_no = ?', array($case_no))->num_rows();
    }

    public function addNewPattaDetail($case_no)
    {        
      $modified_case_no = $case_no.'_1';

      $this->db->trans_begin();

      // get all details from settlement_basic
      $fromBasic = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no));
      if($fromBasic->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_basic', json_encode($fromBasic->row()));

        // update settlement_basic 
        $updateBasic = $this->db->query("UPDATE settlement_basic SET status=?, from_office=?, pending_officer=? WHERE case_no=?", 
                            array('Z', 'CO', 'LM', $case_no));
        if($this->db->affected_rows() != 1)
        {
          log_message('error', "#ERR1324: Updation failed in settlement_basic for case no $case_no". $this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR1324: Unable to save data!',
          ]);
          return;
        }
      }

      // get all details from settlement_dag_details
      $fromDag = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=?", array($case_no));
      if($fromDag->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_dag_details', json_encode($fromDag->result()));
        $this->updateTeaRelatedTable($case_no, 'settlement_dag_details', $modified_case_no, $fromDag->num_rows());
      }

      // get all details from settlement_applicant
      $fromAppl = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type IN (?,?,?)", 
                    array($case_no, 'EP', 'DA', 'O'));
      if($fromAppl->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_applicant', json_encode($fromAppl->result()));

        // update settlement_applicant
        $updateAppl = $this->db->query("UPDATE settlement_applicant SET case_no=? WHERE case_no=? AND pdar_type IN (?,?,?)", 
                            array($modified_case_no, $case_no, 'EP', 'DA', 'O'));
        if($this->db->affected_rows() != $fromAppl->num_rows())
        {
          log_message('error', "#ERR1351: Updation failed in settlement_applicant for case no $case_no". $this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR1351: Unable to save data!',
          ]);
          return;
        }
      }

      // get all details from settlement_area_history
      $fromHistory = $this->db->query("SELECT * FROM settlement_area_history WHERE case_no=?", array($case_no));
      if($fromHistory->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_area_history', json_encode($fromHistory->result()));
        $this->updateTeaRelatedTable($case_no, 'settlement_area_history', $modified_case_no, $fromHistory->num_rows());
      }

      // get all details from settlement_ap_lmnote
      $fromNote = $this->db->query("SELECT * FROM settlement_ap_lmnote WHERE case_no=?", array($case_no));
      if($fromNote->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_ap_lmnote', json_encode($fromNote->row()));
        $this->updateTeaRelatedTable($case_no, 'settlement_ap_lmnote', $modified_case_no, $fromNote->num_rows());
      }

      // get all details from settlement_premium
      $fromPrem = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=?", array($case_no));
      if($fromPrem->num_rows() > 0) {
        $this->insertTeaOldPattaHistory($case_no, 'settlement_premium', json_encode($fromPrem->result()));
        $this->updateTeaRelatedTable($case_no, 'settlement_premium', $modified_case_no, $fromPrem->num_rows());
      }

      $this->db->trans_commit();
      return;
    }

    protected function insertTeaOldPattaHistory($case_no, $table, $jsonData)
    {        
        $ins = [
            'case_no'    => $case_no,
            'tbl_name'   => $table,
            'post_data'  => $jsonData,
            'status'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $insert = $this->db->insert('history_tea_grant_old_patta_detail', $ins);
        if($insert != 1)
        {
          log_message('error', "#ERR1418: INSERTION failed in $table for case no $case_no". $this->db->last_query());
          $this->db->trans_rollback();
          echo json_encode([
            'responseType' => 0,
            'msg'          => '#ERR1418: Unable to save data!',
          ]);
          return;
        }
    }


    protected function updateTeaRelatedTable($case_no, $table, $modified_case_no, $rowCount)
    {        
      // update settlement_premium
      $updateOldData = $this->db->query("UPDATE $table SET case_no=? WHERE case_no=?", array($modified_case_no, $case_no));
      if($this->db->affected_rows() != $rowCount)
      {
        log_message('error', "#ERR1453: Updation failed in $table for case no $case_no". $this->db->last_query());
        $this->db->trans_rollback();
        echo json_encode([
          'responseType' => 0,
          'msg'          => '#ERR1453: Unable to save data!',
        ]);
        return;
      }
    }

    public function isApplicantMutated($case_no)
    {
      $isMutated = $this->db->query("SELECT sa.id, sd.dag_no, sa.pdar_name, sa.pdar_guardian, sa.is_applicant 
                    FROM settlement_applicant sa JOIN settlement_dag_details sd ON sa.case_no=sd.case_no
                      WHERE sa.pdar_type=? AND sa.case_no=? ORDER BY sd.dag_no", array('B', $case_no));
      return $isMutated->result();
    }

    public function listOfChithaOwners($case_no)
    {
      // get details from settlement_dag_details
      $fromDagDetails = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no=? LIMIT 1", array($case_no))->row();

      $dist       = $fromDagDetails->dist_code;
      $subdiv     = $fromDagDetails->subdiv_code; 
      $cir        = $fromDagDetails->cir_code; 
      $mouza      = $fromDagDetails->mouza_pargona_code; 
      $lot        = $fromDagDetails->lot_no; 
      $vill       = $fromDagDetails->vill_townprt_code; 
      $dag_no     = $fromDagDetails->dag_no; 
      $patta_no   = $fromDagDetails->patta_no; 
      $patta_type = $fromDagDetails->patta_type_code;

      $pattadar_list = $this->db->query("SELECT cp.pdar_id, cp.pdar_name, cp.pdar_father, cp.pdar_add1, cp.pdar_add2 
                        FROM chitha_dag_pattadar cdp JOIN chitha_pattadar cp ON cdp.dist_code = cp.dist_code AND 
                          cdp.subdiv_code = cp.subdiv_code AND cdp.cir_code = cp.cir_code AND cdp.mouza_pargona_code = cp.mouza_pargona_code AND cdp.lot_no = cp.lot_no AND cdp.vill_townprt_code = cp.vill_townprt_code 
                              AND cdp.patta_no = cp.patta_no AND cdp.patta_type_code = cp.patta_type_code AND cdp.pdar_id = cp.pdar_id
                                WHERE cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? 
                                  AND cdp.lot_no =? AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.patta_no=? 
                                    AND cdp.patta_type_code=?", 
                                      array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no, $patta_no, $patta_type));
      return $pattadar_list->result();
    }

    public function getApplicantToBeSettled($case)
    {
      $msg = '';
      $fromMutStatusTable = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case));

      if($fromMutStatusTable->num_rows() > 0)
      {
        // get details from settlement dag details
        $fromDagDetails = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type IN (?,?,?) LIMIT 1", 
                            [$case, 'EP', 'O', 'DA'])->row();
        // echo $this->db->last_query();

        $dist       = $fromDagDetails->dist_code;
        $subdiv     = $fromDagDetails->subdiv_code;
        $cir        = $fromDagDetails->cir_code;
        $mouza      = $fromDagDetails->mouza_pargona_code;
        $lot        = $fromDagDetails->lot_no;
        $vill       = $fromDagDetails->vill_townprt_code;
        $patta_no   = $fromDagDetails->patta_no;
        $patta_type = $fromDagDetails->patta_type_code;

        if($fromMutStatusTable->row()->option_choosen == 'NO')
        {
          $msg .= 'Outcome will be MUTATION with PARTITION, followed by a process of CONVERSION.'."<br>";
        }
        else
        {
          foreach($fromMutStatusTable->result() as $row)
          {
            $dag_no    = $row->dag_no;
            $chitha_id = $row->chitha_pdar_id;

            $ep_name = $this->db->query("SELECT cp.pdar_name 
                          FROM chitha_dag_pattadar cdp JOIN chitha_pattadar cp ON cdp.dist_code = cp.dist_code AND 
                            cdp.subdiv_code = cp.subdiv_code AND cdp.cir_code = cp.cir_code AND cdp.mouza_pargona_code = cp.mouza_pargona_code AND cdp.lot_no = cp.lot_no AND cdp.vill_townprt_code = cp.vill_townprt_code 
                                AND cdp.patta_no = cp.patta_no AND cdp.patta_type_code = cp.patta_type_code AND cdp.pdar_id = cp.pdar_id
                                  WHERE cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? 
                                    AND cdp.lot_no =? AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.patta_no=? 
                                      AND cdp.patta_type_code=? AND cp.pdar_id=?", 
                                        array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no, $patta_no, $patta_type, $chitha_id));

            if($row->chitha_pdar_id != 0)
            {
              if($ep_name->num_rows() > 0)
              {
                $ep_name = $ep_name->row()->pdar_name;
              }
              else
              {
                $ep_name = $row->pdar_name;
              }

              if($row->already_partitioned == 1)
              {
                  $msg .= $row->dag_no.': '.$ep_name.' The mutation and partition have already been completed. The next and only remaining step is the process of conversion.'."<br>";
              }
              else if($row->already_partitioned == 0 || $row->already_partitioned == null || $row->already_partitioned == '')
              {
                  $msg .= $row->dag_no.': '.$ep_name.' is already mutated. Outcome will be PARTITION, followed by a process of CONVERSION.'."<br>";
              }            
            }
            else if($row->chitha_pdar_id == 0)
            {
              $msg .= $row->dag_no.': '.$row->pdar_name.' is not mutated. Outcome will be MUTATION with PARTITION, followed by a process of CONVERSION.'."<br>";
            }
          }
        }
      }
      else
      {
        $msg .= 'This is the default message as the case status has not been verified for the outcome of the service. The outcome will be MUTATION with PARTITION, followed by the process of CONVERSION.'."<br>";
      }
      return $msg;
    }

    public function getMutatedStatusCount($case)
    {
      return $fromMutStatusTable = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case));
    }

    // public function getMutatedStatusWithNo($case)
    // {
    //   return $fromMutStatusTable = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no=?", array($case))->row()->option_choosen;
    // }

    public function getMutatedStatusWithNo($case)
    {
        $query = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no = ?", array($case));
        $row = $query->row();
        
        if ($row && isset($row->option_choosen)) {
            return $row->option_choosen;
        }

        return null; // or return a default value like '' or 'NO'
    }



    public function getLocationArray($case_no)
    {
        $query = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", [$case_no]);

        if ($query->num_rows() != 0) {
            $row = $query->row_array(); 

            // Extract location codes
            $dist_code    = $row['dist_code'];
            $subdiv_code  = $row['subdiv_code'];
            $cir_code     = $row['cir_code'];
            $mouza_code   = $row['mouza_pargona_code'];
            $lot_no       = $row['lot_no'];
            $village_code = $row['vill_townprt_code'];

            // Get names
            $district_name = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = '00' AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code])->row('locname_eng');
            $subdiv_name   = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code])->row('locname_eng');
            $cir_name      = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = '00' AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code])->row('locname_eng');
            $mouza_name    = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = '00' AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code])->row('locname_eng');
            $lot_name      = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = '00000' LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no])->row('locname_eng');
            $village_name  = $this->db->query("SELECT locname_eng FROM location WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? LIMIT 1", [$dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code])->row('locname_eng');

            $res = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? LIMIT 1", [$case_no])->row_array();

            return [
                'dist_code'          => $row['dist_code'],
                'subdiv_code'        => $row['subdiv_code'],
                'cir_code'           => $row['cir_code'],
                'mouza_pargona_code' => $row['mouza_pargona_code'],
                'lot_no'             => $row['lot_no'],
                'vill_townprt_code'  => $row['vill_townprt_code'],
                'patta_no'           => $res['patta_no'],
                'patta_type_code'    => $res['patta_type_code'],
                'uuid'               => $row['uuid'],
                'year_no'            => $row['year_no'],
                'petition_no'        => $row['petition_no'],
                'submission_date'    => $row['submission_date'],
                'service_code'       => '43',
                'ref_no'             => $row['ref_no'],
                'case_no'            => $row['case_no'],
                'applid'             => $row['applid'],
                'user_code'          => $row['user_code'],
                'date_entry'         => $row['date_entry'],
                'lm_code'            => $row['lm_code'],
                'co_code'            => $row['co_code'],
                'adc_code'           => $row['adc_code'],
                'dc_code'            => $row['dc_code'],
                'dept_code'          => $row['dept_code'],
                'dept_approval'      => $row['dept_approval'],
                'dc_approval'        => $row['dc_approval'],
                'dept_order_no'      => $row['dept_order_no'],
                'dept_order_date'    => $row['dept_order_date'],
                'district_name'      => $district_name,
                'subdiv_name'        => $subdiv_name,
                'cir_name'           => $cir_name,
                'mouza_name'         => $mouza_name,
                'lot_name'           => $lot_name,
                'village_name'       => $village_name,
            ];
        } else {
            return ['result' => 'Location not found'];
        }
    }

    public function getPattadarArray($case_no)
    {
        $query = $this->db->query("SELECT pdar_name, pdar_guardian, pdar_guardian, pdar_mobile, is_applicant, pdar_type, inplace_alongwith, period_possession, dob, eng_pdar_name, eng_pdar_guardian, relation_with_pattadar, pdar_rel_guar FROM settlement_applicant WHERE case_no = ?", [$case_no]);

        if (! $query) {
            // Debug error
            log_message('error', 'Database error: ' . $this->db->_error_message());
            return ['result' => 'Database query failed'];
        }

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return ['result' => 'Pattadar details not found'];
        }
    }

    public function getDagArray($case_no, $applicant_name)
    {
        $query = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", [$case_no]);
        if ($query->num_rows() != 0) {
            $results     = $query->result(); // Array of objects
            $finalOutput = [];

            foreach ($results as $rowObj) {
                $row = (array) $rowObj;

                // check for exiting dag

                $dist_code    = $rowObj->dist_code;
                $sub_div_code = $rowObj->subdiv_code;
                $cir_code     = $rowObj->cir_code;
                $mouza_code   = $rowObj->mouza_pargona_code;
                $lot_no       = $rowObj->lot_no;
                $vill_code    = $rowObj->vill_townprt_code;
                $dag          = $rowObj->dag_no;

                $verifyDag        = $this->ChithaUpdateModel->verifyChithaArea($case_no, $dag, $rowObj->s_dag_area_b, $rowObj->s_dag_area_k, $rowObj->s_dag_area_lc, $rowObj->s_dag_area_g);
                $clandbankDetails = $this->getLandBankDetails($dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag, $applicant_name);
                if ($clandbankDetails) {
                    $row['clandbank_details'] = $clandbankDetails;
                }

                if ($verifyDag) {
                    $row['new_dag_no']  = null;
                    $row['is_full_dag'] = 0;
                } else {
                    $row['new_dag_no']  = $row['dag_no'];
                    $row['is_full_dag'] = 1;
                }

                $allowedKeys = [
                    'dag_no', 's_dag_area_b', 's_dag_area_k', 's_dag_area_lc', 's_dag_area_g',
                    's_dag_area_kr', 'dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g', 'dag_area_kr',
                    'patta_no', 'patta_type_code', 'revenue',
                    // 'govt_land', 'govt_land_type', 'user_code', 'date_entry',
                    // 'operation', 'lm_flag_conv', 'case_no', 'id',
                    'new_dag_no', 'new_patta_no', 'new_patta_type_code',
                    'is_urban', 'new_dag_revenue', 'new_land_class_code', 'new_local_tax',
                    // 'date_update',
                    //  'home_b','home_k', 'home_lc', 'home_g', 'home_kr', 'agri_b', 'agri_k', 'agri_lc', 'agri_g', 'agri_kr',
                    //  'land_type',
                    // 'fbigha', 'fkatha', 'flessa', 'fganda', 'fkranti', 'encroachement_area',
                    // 'nr_bigha','nr_ganda', 'nr_katha', 'nr_kranti', 'nr_lessa',
                    // 'nature_possession',
                    'new_patta_type',
                    'new_possession', 'new_agri_land_revenue',
                    // 'new_home_land_revenue', 'new_agri_land_local_tax', 'new_home_land_local_tax', 'new_total_revenue',
                    // 'new_total_tax', 'nature_of_possession_other',
                    //  'applied_b', 'applied_k', 'applied_lc', 'applied_g',
                    // 'applied_kr', 
                    'ins_proposed_land_class', 'boundary', 'reservation', 'clandbank_details', 'is_full_dag',
                ];

                // Decode landmarks
                $landmark     = json_decode($row['landmark'] ?? '{}', true);
                $landmarkCode = json_decode($row['landmark_with_code'] ?? '{}', true);

                // Build boundary
                $boundary                         = [];
                $boundary['east']['description']  = $landmark['east'] ?? '';
                $boundary['west']['description']  = $landmark['west'] ?? '';
                $boundary['north']['description'] = $landmark['north'] ?? '';
                $boundary['south']['description'] = $landmark['south'] ?? '';

                $boundary['east']['dag_no']  = $landmarkCode['east']['dag_no'] ?? '';
                $boundary['west']['dag_no']  = $landmarkCode['west']['dag_no'] ?? '';
                $boundary['north']['dag_no'] = $landmarkCode['north']['dag_no'] ?? '';
                $boundary['south']['dag_no'] = $landmarkCode['south']['dag_no'] ?? '';

                $row['boundary'] = $boundary;

                $row['reservation'] = $this->getReservationArea($case_no, $row['dag_no']);

                $filtered_row = array_intersect_key($row, array_flip($allowedKeys));
                // $filtered_row = $row;
                $finalOutput[] = $filtered_row;
            }

            return $finalOutput;
        } else {
            return ['result' => 'Dag details not found'];
        }
    }

    public function getPremiumArray($case_no)
    {

        $query = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and is_final = 1 and grn_no is not null", [$case_no]);

        if (! $query) {
            // Log the database error
            log_message('error', 'Database error: ' . $this->db->_error_message());
            return ['result' => 'Database query failed'];
        }

        if ($query->num_rows() != 0) {
            $row = $query->row();
            return $row;
        } else {
            return ['result' => 'Premium details not found'];
        }
    }

    public function getOutcomeArray($case_no)
    {
      $result_array = [];

      // check if outcome selected as NO
      $mutatedTable = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE case_no = ?", [$case_no]);
      if($mutatedTable->row()->option_choosen == 'NO') // means no buyer is mutated here
      {
        // get all buyers dag wise
        $allBuyers = $this->db->query("SELECT * FROM settlement_applicant sa JOIN settlement_dag_details sd ON sa.case_no = sd.case_no
                      WHERE sa.case_no=? AND sa.pdar_type=?", [$case_no, 'B'])->result();

        foreach($allBuyers as $row)
        {
          $result_array[] = [
            'dag_no'            => $row->dag_no,
            'pdar_name'         => $row->pdar_name,
            'pdar_guardian'     => $row->pdar_guardian,
            'pdar_mobile'       => $row->pdar_mobile,
            'is_applicant'      => $row->is_applicant,
            'pdar_rel_guar'     => $row->pdar_rel_guar,
            'eng_pdar_name'     => $row->eng_pdar_name,
            'eng_pdar_guardian' => $row->eng_pdar_guardian,
            'outcome'           => 'N', // nothing done
            'chitha_id'         => '-1',
            'pdar_type'         => 'B',
            'message'           => 'Mutation and Partition followed by Conversion',
          ];
        }
      }
      else // if the question choosed as YES
      {
        $mutatedTable = $this->db->query("SELECT distinct on (t1.dag_no, t1.sett_appl_id) t1.*, t2.pdar_mobile, t2.is_applicant, t2.pdar_rel_guar, 
                          t2.eng_pdar_name, t2.eng_pdar_guardian FROM teagrant_is_mutated t1 JOIN settlement_applicant t2 ON t1.case_no=t2.case_no 
                            WHERE t1.case_no=? AND t2.pdar_type=?", [$case_no, 'B']);

        // log_message("error", "table_row_query".$this->db->last_query());

        foreach($mutatedTable->result() as $row)
        {
          if($row->chitha_pdar_id != 0)
          {
            $dag_no     = $row->dag_no;
            $chitha_id  = $row->chitha_pdar_id;

            $fromAppl   = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type IN (?,?,?) LIMIT 1", 
                            [$case_no, 'EP', 'O', 'DA'])->row();

            $dist       = $fromAppl->dist_code;
            $subdiv     = $fromAppl->subdiv_code;
            $cir        = $fromAppl->cir_code;
            $mouza      = $fromAppl->mouza_pargona_code;
            $lot        = $fromAppl->lot_no;
            $vill       = $fromAppl->vill_townprt_code;
            $patta_no   = $fromAppl->patta_no;
            $patta_type = $fromAppl->patta_type_code;

            $ep_name = $this->db->query("SELECT cp.pdar_name 
                          FROM chitha_dag_pattadar cdp JOIN chitha_pattadar cp ON cdp.dist_code = cp.dist_code AND 
                            cdp.subdiv_code = cp.subdiv_code AND cdp.cir_code = cp.cir_code AND cdp.mouza_pargona_code = cp.mouza_pargona_code AND cdp.lot_no = cp.lot_no AND cdp.vill_townprt_code = cp.vill_townprt_code 
                                AND cdp.patta_no = cp.patta_no AND cdp.patta_type_code = cp.patta_type_code AND cdp.pdar_id = cp.pdar_id
                                  WHERE cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? 
                                    AND cdp.lot_no =? AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.patta_no=? 
                                      AND cdp.patta_type_code=? AND cp.pdar_id=?", 
                                        array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no, $patta_no, $patta_type, $chitha_id));

            $ep_name = $ep_name->row()->pdar_name ?? null;
          }

          // check which existing pattadar has been choosen
          $isMutatedTable = $this->db->query("SELECT * FROM teagrant_is_mutated WHERE dag_no=? AND case_no=?", 
                                [$row->dag_no, $case_no]);

          if($isMutatedTable->num_rows() > 0)
          {
            $chitha_ids = [];
            $result = $isMutatedTable->result();

            foreach($result as $r)
            {
              $chitha_ids[] = $r->chitha_pdar_id;
            }
          }

          if(!empty($chitha_ids))
          {

            $fromAppl   = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type IN (?,?,?) LIMIT 1", 
                            [$case_no, 'EP', 'O', 'DA'])->row();

            $dist       = $fromAppl->dist_code;
            $subdiv     = $fromAppl->subdiv_code;
            $cir        = $fromAppl->cir_code;
            $mouza      = $fromAppl->mouza_pargona_code;
            $lot        = $fromAppl->lot_no;
            $vill       = $fromAppl->vill_townprt_code;
            $patta_no   = $fromAppl->patta_no;
            $patta_type = $fromAppl->patta_type_code;

            $chitha_ids = implode(',', $chitha_ids);  // "1,2,6,7,8"

            $ep_name = $this->db->query("SELECT cp.pdar_id, cp.pdar_name 
                        FROM chitha_dag_pattadar cdp JOIN chitha_pattadar cp ON cdp.dist_code = cp.dist_code AND 
                        cdp.subdiv_code = cp.subdiv_code AND cdp.cir_code = cp.cir_code AND 
                        cdp.mouza_pargona_code = cp.mouza_pargona_code AND cdp.lot_no = cp.lot_no AND 
                        cdp.vill_townprt_code = cp.vill_townprt_code 
                        AND cdp.patta_no = cp.patta_no AND cdp.patta_type_code = cp.patta_type_code AND cdp.pdar_id = cp.pdar_id
                        WHERE cdp.dist_code=? AND cdp.subdiv_code=? AND cdp.cir_code=? AND cdp.mouza_pargona_code=? 
                        AND cdp.lot_no =? AND cdp.vill_townprt_code=? AND cdp.dag_no=? AND cdp.patta_no=? 
                        AND cdp.patta_type_code=? AND cp.pdar_id IN ($chitha_ids)", 
                        array($dist, $subdiv, $cir, $mouza, $lot, $vill, $dag_no, $patta_no, $patta_type));

            $ep_selected = $ep_name->num_rows() > 0 ? json_encode($ep_name->result()) : null;
          }

          if($row->already_partitioned == 0 && $row->chitha_pdar_id != 0) // mutation done, only partition,conversion
          {
            $result_array[] = [
              'dag_no'            => $row->dag_no ?? null,
              'pdar_name'         => $row->pdar_name ?? null,
              'pdar_guardian'     => $row->pdar_guardian_name ?? null,
              'pdar_mobile'       => $row->pdar_mobile ?? null,
              'is_applicant'      => $row->is_applicant ?? null,
              'pdar_rel_guar'     => $row->pdar_rel_guar ?? null,
              'eng_pdar_name'     => $row->eng_pdar_name ?? null,
              'eng_pdar_guardian' => $row->eng_pdar_guardian ?? null,
              'outcome'           => 'M', // mutation done
              'chitha_id'         => $row->chitha_pdar_id ?? null,
              'pdar_type'         => 'B',
              'message'           => 'Partition followed by Conversion',
              'ep_selected'       => $ep_selected,
            ];
          }
          else if($row->already_partitioned == 1 && $row->chitha_pdar_id != 0) // mutation, partition done, only conversion
          {
            $result_array[] = [
              'dag_no'            => $row->dag_no ?? null,
              'pdar_name'         => $row->pdar_name ?? null,
              'pdar_guardian'     => $row->pdar_guardian_name ?? null,
              'pdar_mobile'       => $row->pdar_mobile ?? null,
              'is_applicant'      => $row->is_applicant ?? null,
              'pdar_rel_guar'     => $row->pdar_rel_guar ?? null,
              'eng_pdar_name'     => $row->eng_pdar_name ?? null,
              'eng_pdar_guardian' => $row->eng_pdar_guardian ?? null,
              'outcome'           => 'P', // partition done
              'chitha_id'         => $row->chitha_pdar_id ?? null,
              'pdar_type'         => 'B',
              'message'           => 'Conversion Only',
              'ep_selected'       => $ep_selected,
            ];
          }
          else if($row->already_partitioned == 0 && $row->chitha_pdar_id == 0) // mutation, partition done, only conversion
          {
            $result_array[] = [
              'dag_no'            => $row->dag_no ?? null,
              'pdar_name'         => $row->pdar_name ?? null,
              'pdar_guardian'     => $row->pdar_guardian_name ?? null,
              'pdar_mobile'       => $row->pdar_mobile ?? null,
              'is_applicant'      => $row->is_applicant ?? null,
              'pdar_rel_guar'     => $row->pdar_rel_guar ?? null,
              'eng_pdar_name'     => $row->eng_pdar_name ?? null,
              'eng_pdar_guardian' => $row->eng_pdar_guardian ?? null,
              'outcome'           => 'N', // partition done
              'chitha_id'         => '-1',
              'pdar_type'         => 'B',
              'message'           => 'Mutation & Partition followed by Conversion',
              'ep_selected'       => $ep_selected,
            ];
          }
        }
      }
      return $result_array;
    }

    public function getLandBankDetails($dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag, $applicant_name)
    {
        $query = $this->db->query("SELECT * FROM c_land_bank_details WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? AND dag_no = ?", [$dist_code, $sub_div_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag]);
        if (! $query) {
            // Debug error
            log_message('error', 'Database error: ' . $this->db->_error_message());
            return ['result' => 'Database query failed'];
        }
        if ($query->num_rows() != 0) {
            $row2 = $query->row();
            // check for the encrocher name
            $encrocher_name = $this->db->query("SELECT name FROM c_land_bank_encroacher_details WHERE c_land_bank_details_id = ?", [$row2->id]);
            if (! $encrocher_name) {
                $row2->encrocher_name = "";
                return false;
            }
            if ($encrocher_name->num_rows() != 0) {
                $row2->encrocher_name = $encrocher_name->row('name');
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function getReservationArea($case_no, $dag_no)
    {
        $query = $this->db->query("SELECT * FROM settlement_reservation WHERE case_no = ? and dag_no = ? and is_deleted = 0", [$case_no, $dag_no]);

        if (! $query) {
            // Debug error
            log_message('error', 'Database error: ' . $this->db->_error_message());
            return ['result' => 'Database query failed'];
        }

        if ($query->num_rows() != 0) {
            $row = (array) $query->row();

            $allowedKeys  = ['bigha', 'katha', 'lessa', 'ganda', 'kranti'];
            $filtered_row = array_intersect_key($row, array_flip($allowedKeys));
            return $filtered_row;
        } else {
            return ['bigha' => 0, 'katha' => 0, 'lessa' => 0, 'ganda' => 0, 'kranti' => 0];
        }
    }

    public function validateDataForCithaUpdate($data)
    {
        // var_dump($data);die;
        if (empty($data)) {
            return ['status' => false, 'message' => "Error: Main data array is empty."];
        }
        // 2. Validate case_no
        if (! isset($data['case_no']) || empty($data['case_no'])) {
            return ['status' => false, 'message' => "Error: case_no is missing or empty."];
        }
        // 3. Check required nested objects/arrays
        $requiredKeys = ['location', 'dag', 'pattadar', 'premium'];
        foreach ($requiredKeys as $key) {
            if (! isset($data[$key]) || empty($data[$key])) {
                return ['status' => false, 'message' => "Error: '$key' is missing or empty."];
            }
        }
        // Optional: deeper checks (e.g., inside location['settlement'])
        if (! isset($data['location']['settlement']) || empty($data['location']['settlement'])) {
            return ['status' => false, 'message' => "Error: 'location.settlement' is missing or empty."];
        }
        // Check Service code allowed or not
        $service_code = '43';
        if (! in_array($service_code, json_decode(CHITHA_UPDATE_ALLOWED_MB3))) {
            log_message('error', "UPDATE_Service_NOT_allowed");
            return ['status' => false, 'message' => "Error: Service code not allowed."];
        }
        return ['status' => true, 'message' => "Data is valid."];
    }

    public function settlementChithaUpdatev2($data)
    {
        // print_r($data);
        $validation = $this->validateDataForCithaUpdate($data);
        if ($validation['status'] == false) {
            return false;
        }

        dd($data); 

        $case_no            = $data['case_no'];
        $pattadars          = $data['pattadar'];
        $dags               = $data['dag'];
        $location           = $data['location']['settlement'] ?? [];
        $settlement_details = $data['pattadar']; // Since most nested fields come from $pattadar directly
        $premium            = $data['premium'];
        $user_code          = $this->session->userdata('user_code');

        $applicantData = $this->getSettlememtApplicant_data($case_no);
        $loc_arr       = [
            'dist_code'          => $location['dist_code'],
            'subdiv_code'        => $location['subdiv_code'],
            'cir_code'           => $location['cir_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code'],
            'lot_no'             => $location['lot_no'],
            'vill_townprt_code'  => $location['vill_townprt_code'],
        ];

        foreach ($dags as $dag) {

            if (isset($dag['reservation']) &&
                isset($dag['reservation']['bigha']) && $dag['reservation']['bigha'] != 0 &&
                isset($dag['reservation']['katha']) && $dag['reservation']['katha'] != 0 &&
                isset($dag['reservation']['lessa']) && $dag['reservation']['lessa'] != 0 &&
                isset($dag['reservation']['ganda']) && $dag['reservation']['ganda'] != 0
            ) {

                $road_side_reservation_bigha = $dag['reservation']['bigha'];
                $road_side_reservation_katha = $dag['reservation']['katha'];
                $road_side_reservation_lessa = $dag['reservation']['lessa'];
                $road_side_reservation_ganda = $dag['reservation']['ganda'];

                // $reservation=$this->roadSideReservation($road_side_reservation_bigha,$road_side_reservation_katha,$road_side_reservation_lessa,$road_side_reservation_ganda);
                ///////////////////////
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " চাতক " . $road_side_reservation_ganda . " গোণ্ডা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                } else {
                    $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " লেচা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                }
                $backlog_orders = [
                    'patta_no'        => $dag['patta_no'],
                    'patta_type_code' => $dag['patta_type_code'],
                    'dag_no'          => $dag['dag_no'],
                    'dag_no_int'      => $dag['dag_no'] . '00',
                    'remark'          => addslashes($rmk),
                    'category'        => 2,
                    'date_entry'      => date('Y-m-d'),
                    'user_code'       => $user_code,
                ];

                $backlog_orders = (array_merge($loc_arr, $backlog_orders));

                // merge with loc_arry and backlog_oders before insert
                $backlog_orders = $this->Chitha_basic_model->insert_table('backlog_orders', $backlog_orders);
                if ($backlog_orders == 0) {
                    log_message('error', "INSERT_backlog_orders" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }

            ///////////End of reservation/////////////////
            $rmk_type_hist_no = $this->ChithaUpdateModel->maxHistoryNoOrder($loc_arr, $dag['dag_no']);
            $remark_gen       = [
                'dag_no'           =>  $dag['dag_no'],
                'rmk_type_code'    => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code'        => $user_code,
                'date_entry'       => date('Y-m-d'),
                'operation'        => 'E',
                'jama_updated'     => null,
                'patta_no'         => $dag['new_patta_no'],
            ];
            $chitha_remark_gen_data = (array_merge($loc_arr, $remark_gen));
            $chitha_rmk_gen         = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
            if ($chitha_rmk_gen == 0) {
                log_message('error', "INSERT_CHITHA_RMK_GEN" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            //OLD DAG /////////////////
            if (trim((string) $dag['old_dag_no']) != trim((string) $dag['new_dag_no'])) {
                $chitha_remark_gen_data['dag_no'] = $dag['old_dag_no'];
                $chitha_rmk_gen                   = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }

            $order_basic = [
                'rmk_type_hist_no'   => $rmk_type_hist_no,
                'ord_no'             => $case_no,
                'ord_date'           => date('Y-m-d'),
                'ord_type_code'      => $location['service_code'],
                'ord_cron_no'        => $ord_cron_no++,
                'case_no'            => $case_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig'   => $this->session->userdata('user_desig_code'),
                'lm_code'            => $location['lm_code'],
                'lm_sign_yn'         => 'Y',
                'lm_sign_date'       => $location['lm_sign_date'],
                'co_code'            => $user_code,
                'co_sign_yn'         => 'Y',
                'co_ord_date'        => date('Y-m-d'),
                'user_code'          => $user_code,
                'date_entry'         => date('Y-m-d'),
                'operation'          => 'E',
                'm_dag_area_b'       => $dag['s_dag_area_b'],
                'm_dag_area_k'       => $dag['s_dag_area_k'],
                'm_dag_area_lc'      => $dag['s_dag_area_lc'],
                'm_dag_area_g'       => $dag['s_dag_area_g'],
                'm_dag_area_kr'      => 0,
                'area_left_b'        => '0',
                'area_left_k'        => '0',
                'area_left_lc'       => '0',
                'area_left_g'        => '0',
                'old_dag_area_b'     => null,
                'old_dag_area_k'     => null,
                'old_dag_area_lc'    => null,
                'old_dag_area_g'     => null,
                'rural_urban'        => $dag['is_urban'],
                'full_partial'       => $dag['is_full_dag'],
                'rtps_no'            => $location['applid'],
                'rtps_app_date'      => $location['date_entry'],
                'dag_revenue'        => $dag['new_land_revenue'],
                'dag_local_tax'      => $dag['new_land_local_tax'],
                'ord_impli_flag'     => 1,
                'full_dag'           => trim((string) $dag['dag_no']) != trim((string) $dag['new_dag_no']) ? 0 : $dag['is_full_dag'],
            ];

            if ($ap_old_area_ref == true) {
                $order_basic['old_dag_area_b']  = null;
                $order_basic['old_dag_area_k']  = null;
                $order_basic['old_dag_area_lc'] = null;
                $order_basic['old_dag_area_g']  = null;
            }

            $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
            $chitha_rmk_ordbasic      = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
            if ($chitha_rmk_ordbasic == 0) {
                log_message('error', "INSERT_CHITHA_RMK_ORDBASIC" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            ////////////OLD DAG///////////

            foreach ($pattadars as $key => $pattadar) {

                //craete insertion array
                $insertaionArray = [
                    'case_no'                  => $data['case_no'],
                    'dag_no'                   => $dag['dag_no'],
                    'applied_dag_no'           => $dag['dag_no'], // Assuming same as `dag_no` if no `applied_dag_no` available
                    'institute_name'           => $pattadar['ins_name_assamese'] ?? '',
                    'institute_name_eng'       => $pattadar['ins_name_co'] ?? '',
                    'registration_status'      => $pattadar['co_operative_registered'] ?? '',
                    'reg_no'                   => $pattadar['registration_no'] ?? '',
                    'reg_date'                 => $pattadar['registration_date'] ?? null,
                    'purpose_land_allotment'   => $pattadar['purpose_land_allot_co'] ?? '',
                    'other_purpose'            => $pattadar['other_purpose_land_allot_co'] ?? '',
                    'venture_status'           => $pattadar['under_venture_school'] ?? '',
                    'venture_type'             => $pattadar['venture_type'] ?? '',
                    'ngo_trust_localbodies'    => $pattadar['under_ngo_trust_localbodies'] ?? '',
                    'under_charter_activities' => $pattadar['under_charter_activities'] ?? '',
                    'reclassification'         => $premium->ins_reclass_amount ?? 0,
                    'govt_nongovt_undertaking' => $pattadar['ins_cat_type_co'] ?? '',
                    'department_name'          => $pattadar['dept_of_co_assamese'] ?? '',
                    'department_name_eng'      => $pattadar['dept_of_co'] ?? '',
                    'undertaking_board'        => $pattadar['undertaking_board_co'] ?? '',
                    'ministry'                 => $pattadar['ministry_of_co'] ?? '',
                    'applied_on_behalf_name'   => $pattadar['pdar_name'] ?? '',
                    'applied_on_behalf_desg'   => $pattadar['authorised_applicant_desig'] ?? '',
                    'applied_on_behalf_mobile' => $pattadar['authorised_applicant_phone_no'] ?? '',
                    'applied_on_behalf_email'  => $pattadar['authorised_applicant_emailid'] ?? '',
                    'date_entry'               => date('Y-m-d'),
                    'user_code'                => $user_code,
                ];

                try{

                }catch(Exception $e){

                }

                $insertaionArray           = (array_merge($loc_arr, $insertaionArray));
                $chitha_institute_allottee = $this->Chitha_basic_model->insert_table('chitha_institute_allottee', $insertaionArray);
                if ($chitha_institute_allottee == 0) {
                    log_message('error', "INSERT_chitha_institute_allottee" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }

                ////////////
                // insertinto chitha institute_allot after merginging loc array and insertion array

                // cdp cith dag pattadar and cp chitha patadar

                if ($location['is_settlement']) { //Case of Allotment Certificate

                    $chitha_pattadar = [
                        'patta_no'        => $dag['patta_no'],
                        'patta_type_code' => $dag['patta_type_code'],
                        'pdar_id'         => $final_pdarId,
                        'pdar_name'       => $pattadar['ins_name_assamese'],
                        'pdar_father'     => $pattadar['dept_of_co_assamese'],
                        'pdar_name_eng'   => $pattadar['ins_name_co'],
                        'pdar_guard_eng'  => $pattadar['dept_of_co'],
                        'pdar_add1'       => $applicantData['pdar_add1'],
                        'pdar_add2'       => $applicantData['pdar_add2'],
                        'dob'             => $applicantData['dob'],
                        'o1_case_no'      => $case_no,
                        //'pdar_pan_no' => $alp->alotee_pan_card,
                        'user_code'       => $user_code,
                        'date_entry'      => date('Y-m-d'),
                        'operation'       => 'E',
                        'jama_yn'         => 'n',
                        'pdar_guard_reln' => null,
                        'pdar_gender'     => null,
                        'pdar_minor_yn'   => null,
                        'pdar_minor_dob'  => null,
                        'pdar_caste'      => null,
                        // 'pdar_mother' => $slp['pdar_mother'],
                        // 'pdar_aadharno' => null,
                        'pdar_mobile'     => $pattadar['mobile'],
                        'new_pdar_name'   => 'N',
                        'pdar_occupation' => null,
                        'mask_id'         => $pattadar['mask_id'],
                    ];
                    $chitha_dag_pattadar = array_merge($loc_arr, $c_d_p);

                    // var_dump($slp['relation']);
                    if ($pattadar['identity_type'] == 'AADHAAR' && $pattadar['is_applicant'] == 1) {
                        $chitha_pattadar['pdar_aadharno'] = $pattadar['identity_ref_no'];
                    }
                    if ($pattadar['identity_type'] == 'PAN' && $pattadar['is_applicant'] == 1) {
                        $chitha_pattadar['pdar_pan_no'] = $pattadar['identity_ref_no'];
                    }
                    if ($pattadar['identity_type'] == 'DL' && $pattadar['is_applicant'] == 1) {
                        $chitha_pattadar['pdar_nrcno'] = $pattadar['identity_ref_no'];
                    }
                    // var_dump($chitha_pattadar);
                    // echo "<br>chitha_pattadar****************<br>";
                    $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);

                    // $final_pdarId = $pdar_id;
                    $c_d_p = [
                        'pdar_id'         => $final_pdarId,
                        'patta_no'        => $dag['patta_no'],
                        'patta_type_code' => $dag['patta_type_code'],
                        'dag_por_b'       => $dag['s_dag_area_b'],
                        'dag_por_k'       => $dag['s_dag_area_k'],
                        'dag_por_lc'      => $dag['s_dag_area_lc'],
                        'dag_por_g'       => $dag['s_dag_area_g'],
                        'dag_por_kr'      => 0,
                        'user_code'       => $user_code,
                        'date_entry'      => date('Y-m-d'),
                        'operation'       => 'E',
                        'p_flag'          => '0',
                        'jama_yn'         => 'N',
                    ];
                    $chitha_dag_pattadar = array_merge($loc_arr, $c_d_p);
                    // var_dump($chitha_dag_pattadar);
                    $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar);
                    if ($chitha_dag_pattadar == 0) {
                        log_message('error', "INSERT_chitha_dag_pattadar" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                }
                return true;
            }
        }
    }


    public function locationSelectReGeotagTea($service_code, $status)
    {
      $dist_code   = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code    = $this->session->userdata('cir_code');
      $Query       = "";
      if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
        $lot_string = $this->caseListUnderMappingLot();
        if ($lot_string != null) {
          $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
        }
      }
      $data = $this->db->query("SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic 
                WHERE service_code=? AND status!=? AND dist_code=? AND subdiv_code=? AND cir_code=? $Query 
                  GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no", 
                    [$service_code, $status, $dist_code, $subdiv_code, $cir_code]);
      return $data->result();
    }

    public function caseListUnderMappingLot()
    {
      $dist_code   = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code    = $this->session->userdata('cir_code');
      $user_code   = $this->session->userdata('user_code');
      //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========

      $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";

      $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));

      $lot_array = array();

      if($data->num_rows()> 1)
      {
          $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
          $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

          foreach ($data1->result() as $key => $value) {
              $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
          }
          //////////////////
      }
      $lot_string = null;
      if(!empty($lot_array) && $lot_array!=null){
          $lot_string = $this->convertLiteral($lot_array);
      }
      log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
      return $lot_string;
    }

    public function premiumReCalculationForTeaGrant($case_no)
    {
      $this->db->trans_begin();
      $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
      if ($dagsCheck->num_rows() > 0) 
      {
        $dagCheck = $dagsCheck->result();
      } 
      else
      {
        return [
          'responseType' => 0,
          'message'      => "#ERR2345: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2345: No details available in settlement_dag_details : $case_no".$this->db->last_query(),
        ];
      }

      $basic = $this->getSettlementBasic($case_no);
      if(empty($basic))
      {
        return [
          'responseType' => 0,
          'message'      => "#ERR2357: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2357: No details available in settlement_basic : $case_no".$this->db->last_query(),
        ];
      }

      if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
        $area_in_bigha = 6400;
      }else{
        $area_in_bigha = 100;
      }

      $sumMbAmount = 0;
      $sumMbArea   = 0;
      $finalamount = 0;
      $uuid        = $basic["uuid"];

      foreach ($dagCheck as $premiumdags) {

        $lastId = '';
        $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no=? and dag_no=? and is_final=?", 
                            [$case_no, $premiumdags->dag_no, 1]);

        if ($findLastPremium->num_rows() > 0) 
        {            
          $premData   = $findLastPremium->row();
          $lastId     = $premData->pid;
          $prem_zonal = $this->utilityclass->getZonalValue($premiumdags->dist_code, $uuid, $premiumdags->dag_no);
          $prem_rate  = $premData->rate;
          $prem_area  = $premData->total_lessa;
          $area_name  = $premData->area_name;
          $rate_type  = $premData->rate_type;
          $amount_dag = $premData->amount_dag;
          $due_amount = $premData->due_amount;
        } 
        else 
        {
          return [
            'responseType' => 0,
            'message'      => "#ERR2398: Failed to generate payment notice : $case_no",
            'log_message'  => "#ERR2398: Last premium not available for cases : $case_no".$this->db->last_query(),
          ];
        }

        $percentage  = 10;
        $zonal_lessa = $prem_zonal / $area_in_bigha;
        $premium     = $prem_area * $zonal_lessa;
        $finalamount = ceil($premium * $percentage / 100);

        $sumMbAmount += $finalamount;

        $premiumdata = array(
          'case_no'             => $case_no,
          'user_code'           => $this->session->userdata('user_code'),
          'uuid'                => $uuid,
          'dag_no'              => $premiumdags->dag_no,
          'zonal_valuation'     => $prem_zonal,
          'area_name'           => null,
          'land_type'           => null,
          'rate_type'           => null,
          'rate'                => null,
          'concession'          => null,
          'amount_dag'          => $finalamount,
          'final_amount'        => null,
          'due_amount'          => null,
          'total_lessa'         => $prem_area,
          'is_full_pay'         => 'YES',
          'is_final'            => 1,
          'date_entry'          => date('Y-m-d H:i:s'),
          'approve_by'          => $this->session->userdata('user_desig_code'),
          'old_zonal_valuation' => $premData->zonal_valuation,
        );

        $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
        if ($reInsPremium != 1) 
        {
          $this->db->trans_rollback();
          return [
            'responseType' => 0,
            'message'      => "#ERR2439: Failed to generate payment notice : $case_no",
            'log_message'  => "#ERR2439: Failed to insert data in settlement_premium : $case_no".$this->db->last_query(),
          ];
        }

        $sqlprem = $this->db->query("UPDATE settlement_premium SET is_final=? WHERE case_no=? AND pid=?", [0, $case_no, $lastId]);

        if ($this->db->affected_rows() == 0) 
        {
          $this->db->trans_rollback();
          return [
            'responseType' => 0,
            'message'      => "#ERR2451: Failed to generate payment notice : $case_no",
            'log_message'  => "#ERR2451: Failed to update data in settlement_premium : $case_no".$this->db->last_query(),
          ];
        }
      }

      $updatePremium = $this->db->query("UPDATE settlement_premium SET final_amount=?, due_amount=? WHERE case_no=? and is_final=?", 
                        [$sumMbAmount, $sumMbAmount, $case_no, 1]);

      if ($this->db->affected_rows() == 0) 
      {
        $this->db->trans_rollback();
        return [
          'responseType' => 0,
          'message'      => "#ERR2471: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2471: Failed to update data in settlement_premium : $case_no".$this->db->last_query(),
        ];
      }

      // check if amount matching or not
      $recalPremTable = $this->db->query("SELECT * FROM edited_premium_recalc_teagrant WHERE case_no=? AND is_final=?", [$case_no, 1])->num_rows();

      if($recalPremTable > 0)
      {
        // get sum of amount dag
        $getSum = $this->db->query("SELECT sum(amount_dag) AS total_amount FROM edited_premium_recalc_teagrant WHERE case_no=? AND is_final=?", [$case_no, 1])->row()->total_amount;

        // from premium table
        $fromPremium = $this->db->query("SELECT final_amount FROM settlement_premium WHERE case_no=? and is_final=?", 
                        [$case_no, 1])->row()->final_amount;

        if($getSum != $fromPremium)
        {
            $this->db->trans_rollback();
            return [
              'responseType' => 0,
              'message'      => "#ERR2481: Premium calculation not matching : $case_no",
              'log_message'  => "#ERR2481: Failed to update data in settlement_premium : $case_no".$this->db->last_query(),
            ];
        }
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", [$case_no])->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d h:i:s'),
        'next_date_of_hearing' => date('Y-m-d h:i:s'),
        'note_on_order'        => 'Premium updated due to policy changed',
        'status'               => 'M',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'ADC',
        'office_to'            => 'ADC',
        'task'                 => 'Premium updated',
        'note_type'            => 'Premium updated due to policy changed',
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
      if ($insertProceeding != 1) 
      {
        $this->db->trans_rollback();
        return [
          'responseType' => 0,
          'message'      => "#ERR2507: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2507: Failed to insert data in settlement_proceeding : $case_no".$this->db->last_query(),
        ];
      }

      $this->db->trans_commit();
      return [
        'responseType' => 2,
        'message'      => "Success",
      ];
    }

    public function finalAreaCheck($case_no)
    {
      $getBasicSql = $this->db->query('SELECT * FROM settlement_basic WHERE case_no = ?', [$case_no]);

      if ($getBasicSql->num_rows() <= 0) {
        return [
          'responseType' => 0,
          'message'      => "#ERR2512: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2512: No details available in settlement_basic : $case_no, ".$this->db->last_query(),
        ];
      }

      $getDagDetailsSql = $this->db->query('SELECT * FROM settlement_dag_details WHERE case_no = ?', [$case_no]);

      if ($getDagDetailsSql->num_rows() <= 0) {
        return [
          'responseType' => 0,
          'message'      => "#ERR2522: Failed to generate payment notice : $case_no",
          'log_message'  => "#ERR2522: No details available in settlement_dag_details : $case_no, ".$this->db->last_query(),
        ];
      }

      $dagResult = $getDagDetailsSql->result();

      $total_lessa             = 0;
      $total_s_dag_area_lessa  = 0;
      $total_reservation_lessa = 0;
      $total_premium_lessa     = 0;
      $total_chitha_lessa      = 0;

      foreach ($dagResult as $dagRow) 
      {
        $getChithaAreaSql = $this->db->query('SELECT * FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND 
                              mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?', 
                                [$dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, 
                                  $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no]);

        if ($getChithaAreaSql->num_rows() <= 0) {
          return [
            'responseType' => 0,
            'message'      => "#ERR2548: No dag detail found in chitha : $case_no",
            'log_message'  => "#ERR2548: No details available in chitha_basic : $case_no, ".$this->db->last_query(),
          ];
        }

        $chithaRow = $getChithaAreaSql->row();

        if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY))) 
        {
          //******getting the home + agri area */
          $applied_b           = $dagRow->applied_b;
          $applied_k           = $dagRow->applied_k;
          $applied_lc          = $dagRow->applied_lc;
          $applied_g           = $dagRow->applied_g;
          $total_applied_lessa = $this->utilityclass->Total_ganda($applied_b, $applied_k, $applied_lc, $applied_g);

          //****getting the s_dag_area */
          $s_dag_area_b     = $dagRow->s_dag_area_b;
          $s_dag_area_k     = $dagRow->s_dag_area_k;
          $s_dag_area_lc    = $dagRow->s_dag_area_lc;
          $s_dag_area_g     = $dagRow->s_dag_area_g;
          $s_dag_area_lessa = $this->utilityclass->Total_ganda($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc, $s_dag_area_g);

          //***getting chitha_lessa */
          $chita_b          = $chithaRow->dag_area_b;
          $chita_k          = $chithaRow->dag_area_k;
          $chita_lc         = $chithaRow->dag_area_lc;
          $chita_g          = $chithaRow->dag_area_g;
          $chitha_lessa     = $this->utilityclass->Total_ganda($chita_b, $chita_k, $chita_lc, $chita_g);

        } 
        else {
          $applied_b           = $dagRow->applied_b;
          $applied_k           = $dagRow->applied_k;
          $applied_lc          = $dagRow->applied_lc;
          $total_applied_lessa = $this->utilityclass->Total_Lessa($applied_b, $applied_k, $applied_lc);

          //****getting the s_dag_area */
          $s_dag_area_b        = $dagRow->s_dag_area_b;
          $s_dag_area_k        = $dagRow->s_dag_area_k;
          $s_dag_area_lc       = $dagRow->s_dag_area_lc;
          $s_dag_area_lessa    = $this->utilityclass->Total_Lessa($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc);

          //***getting chitha_lessa */
          $chita_b             = $chithaRow->dag_area_b;
          $chita_k             = $chithaRow->dag_area_k;
          $chita_lc            = $chithaRow->dag_area_lc;
          $chitha_lessa        = $this->utilityclass->Total_Lessa($chita_b, $chita_k, $chita_lc);
        }

        $total_lessa            += $total_applied_lessa;
        $total_s_dag_area_lessa += $s_dag_area_lessa;
        $total_chitha_lessa     += $chitha_lessa;
      }

      if ($total_lessa != $total_s_dag_area_lessa) {
        return [
          'responseType' => 0,
          'message'      => "#ERR2601: Failed to generate payment notice for case no: $case_no",
          'log_message'  => "#ERR2601: Area mismatched : $case_no",
        ];
      }

      //****check if area exceeds more than chitha area */
      if ($total_lessa > $total_chitha_lessa) {
        return [
          'responseType' => 0,
          'message'      => "#ERR2610: Applied area exceeds the limit of chitha area for case no: $case_no",
          'log_message'  => "#ERR2610: Applied area exceeds the limit of chitha area for case no : $case_no",
        ];
      }

      //********calculating the roadside reservation if available */
      $getReservationSql = $this->db->query('SELECT * FROM settlement_reservation WHERE case_no=? AND is_deleted=? AND type=?', 
                              [$case_no, '0', 'R']);

      if ($getReservationSql->num_rows() > 0) {
        $reservationResult = $getReservationSql->result();

        foreach ($reservationResult as $reservationRow) 
        {
          if (in_array($reservationRow->dist_code, json_decode(BARAK_VALLEY))) 
          {
            $reservation_bigha = $reservationRow->bigha;
            $reservation_katha = $reservationRow->katha;
            $reservation_lessa = $reservationRow->lessa;
            $reservation_ganda = $reservationRow->ganda;

            $reservation_in_lessa = $this->utilityclass->Total_ganda($reservation_bigha, $reservation_katha, $reservation_lessa, $reservation_ganda);
          } 
          else 
          {
            $reservation_bigha = $reservationRow->bigha;
            $reservation_katha = $reservationRow->katha;
            $reservation_lessa = $reservationRow->lessa;

            $reservation_in_lessa = $this->utilityclass->Total_Lessa($reservation_bigha, $reservation_katha, $reservation_lessa);
          }
          $total_reservation_lessa += $reservation_in_lessa;
        }
      }

      //******deducting the roadside reservation area */
      if ($total_reservation_lessa != 0) {
        $total_lessa = $total_lessa - $total_reservation_lessa;
      }

      $getPremiumSql = $this->db->query('SELECT * FROM settlement_premium WHERE case_no=? AND is_final=?', [$case_no, '1']);

      if ($getPremiumSql->num_rows() <= 0) {
        return [
          'responseType' => 0,
          'message'      => "#ERR2657: Failed to generate payment notice for case no: $case_no",
          'log_message'  => "#ERR2657: No data available in settlement_premium for case no : $case_no",
        ];
      }

      $premiumResult = $getPremiumSql->result();

      foreach ($premiumResult as $premiumRow) {
        $total_premium_lessa += $premiumRow->total_lessa;
      }

      if (abs($total_lessa - $total_premium_lessa) > 0.0001)
      {
        return [
          'responseType' => 0,
          'message'      => "#ERR2672: Failed to generate payment notice for case no: $case_no",
          'log_message'  => "#ERR2672: Area mismatched in settlement_dag_details & settlement_premium for case no : $case_no",
        ];
      }

      //****if no issues then return success */
      return array(
        'responseType' => 2,
        'message'      => 'Success',
      );
    }


    public function finalVerifyFromLraAfterPnGenerate($d, $s, $c, $m, $l)
    {
      return $this->db->query("SELECT distinct(sb.case_no), sb.service_code, sb.applid, 
            sb.dist_code, sb.subdiv_code, sb.cir_code, sb.mouza_pargona_code, sb.lot_no, sb.vill_townprt_code, 
            sb.date_entry, slm.lm_note, sb.chitha_processing_details, sb.submission_date 
            FROM settlement_basic sb 
            JOIN settlement_premium sp ON sb.case_no = sp.case_no 
            JOIN settlement_ap_lmnote slm ON sb.case_no = slm.case_no
            WHERE sb.dist_code=? AND sb.subdiv_code=? AND sb.cir_code=? AND sb.mouza_pargona_code=? AND sb.lot_no=?
            AND sb.service_code=? AND sb.pending_officer=? AND sb.status=? AND sb.dc_code IS NOT NULL AND 
            sb.pay_notice_gen_yn=? AND 
            EXISTS (SELECT 1 FROM settlement_notice sn2 WHERE sn2.case_no = sb.case_no AND sn2.notice_type=?)",
            [$d, $s, $c, $m, $l, '43', 'ADC', 'N', 'Y', 'PN']);
    }

}