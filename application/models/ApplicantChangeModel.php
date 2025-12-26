<?php
class ApplicantChangeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->dist_code = $this->session->userdata('dist_code');
        $this->load->library('AES');
    }

    // get dharitree case no from rtps appl no
    public function getDharitreeCaseNoByRtpsNo($applNo)
    {
        $this->db->select('dharitree');
        $this->db->from('basundhar_application');
        $this->db->where('basundhara', $applNo);
        $data = $this->db->get();
        return $data->row()->dharitree;
    }

    // get from settlement applicant
    public function getFromSettlementApplicant($case_no)
    {
        $data = $this->db->select()->where('case_no', $case_no)->get('settlement_applicant');
        return $data;
    }

    // get settlement basic
    public function getFromSettlementBasic($case_no)
    {
        $data = $this->db->select()->where('case_no', $case_no)->get('settlement_basic');
        return $data;
    }

    // main applicant detail
    public function getMainApplicant($case_no)
    {
        $data = $this->db->select('*')
                ->where('case_no', $case_no)
                ->where('is_applicant', '1')
                ->where('pdar_type','B')
                ->get('settlement_applicant');                

        return $data->row();
    }

    // main applicant detail
    public function getOldMainApplicant($case_no)
    {
        $data = $this->db->select('*')
                ->where('case_no', $case_no)
                ->where('is_applicant', '1')
                ->where('del_status', '1')
                ->where('pdar_type','B')
                ->get('settlement_applicant');                

        return $data->row();
    }

    // encroacher detail
    public function getEncroacher($case_no)
    {
        $data = $this->db->select()
                ->where('pdar_type', 'EN')
                ->where('case_no', $case_no)
                ->get('settlement_applicant');
        return $data->row();
    }


    // joint applicant detail
    public function getJointApplicant($case_no)
    {
        $data = $this->db->select()
                ->where('is_applicant', 0)
                ->where('pdar_type', 'B')
                ->where('case_no', $case_no)
                ->get('settlement_applicant');
        return $data;
    }

    // ********************* added on 05092023 UPD **************
    public function getBasuApplIdFromCaseNo($case_no) {
        $applid = $this->db->query("SELECT basundhara FROM basundhar_application 
                        WHERE dharitree=?", array($case_no));
        // echo $this->db->last_query();
        if($applid->num_rows() <= 0){
            return $applid = '';
        }
        return $applid->row()->basundhara;
    }

    //for assamese input
    public function checkAssameseCharacterOnly($char){
        $len = mb_strlen($char, "utf8");
        $error = '';
        $asminput= '';
        for($i = 0; $i <= ($len -1); $i++){
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

    public function getFromProceeding($case_no)
    {
        $proceed = $this->db->query("SELECT max(proceeding_id) as proceeding_id FROM settlement_proceeding 
                        WHERE case_no=?", array($case_no));
        if($proceed->num_rows() <= 0){
            return $val = 1;
        }
        return $val = $proceed->row()->proceeding_id+1;
    }

    public function encryptAuthResponse($auth_response)
    {
        $originalString = str_replace("@","/",$auth_response);
        $res_aes        = new AES($originalString, ENCRYPTION_KEY);
        $response       = $res_aes->decrypt();
        $response       = json_decode($response);
        return $response;
    }

    //insert into settlement_proceeding
    public function insertSettlementProceeding($case_no)
    {
        $task = 'Old main applicant is replaced by New main applicant after ekyc verification';
        $insert = [
            'case_no'              => $case_no,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'note_on_order'        => $task,
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => 'R',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => MB_LOT_MONDOL,
            'office_to'            => MB_LOT_MONDOL,
            'proceeding_id'        => $this->getFromProceeding($case_no),
            'task'                 => $task,
        ];
        $ins = $this->db->insert('settlement_proceeding',$insert);
        return $ins;        
    }

    //insert into settlement_applicant
    public function insertSettlementApplicant($case_no, $postdata)
    {    

        // $count = $this->checkJointApplEkycDone($case_no);  // check for joint applicant

        // if($count->num_rows() == 0) // if joint applicant of ekyc not exist
        // {
        //     $appl = $this->getOldMainApplicant($case_no);
        // }
        // else {
        //     $appl = $this->getMainApplicant($case_no);
        // }

        // get main applicant
        $appl = $this->getMainApplicant($case_no);
        
        $auth = json_decode($postdata['auth_response']);

        if($postdata['ekyc_gender'] == 'M')
        {
            $gender = 1;
        }
        else if($postdata['ekyc_gender'] == 'F')
        {
            $gender = 2;
        }
        else
        {
            $gender = 3;
        }


        $insert = [
            'dist_code'          => $appl->dist_code,
            'subdiv_code'        => $appl->subdiv_code,
            'cir_code'           => $appl->cir_code,
            'mouza_pargona_code' => $appl->mouza_pargona_code,
            'lot_no'             => $appl->lot_no,
            'vill_townprt_code'  => $appl->vill_townprt_code,
            'user_code'          => $this->session->userdata('user_code'),
            'case_no'            => $case_no,
            'petition_no'        => $appl->petition_no,
            'operation'          => 'E',
            'dag_no'             => 0,
            'patta_no'           => 0,
            'patta_type_code'    => 0,
            'year_no'            => date('Y'),
            'date_entry'         => date('Y-m-d'),
            'pdar_id'            => '-1',
            'pdar_cron_no'       => $appl->pdar_cron_no,
            'pdar_name'          => $postdata['ekyc_appl_asm'],
            'pdar_guardian'      => $postdata['ekyc_guar_appl_asm'],
            'pdar_rel_guar'      => $postdata['ekyc_relation'],
            'pdar_add2'          => $postdata['ekyc_per_add'],
            'pdar_mobile'        => $postdata['ekyc_mobile'],
            'pdar_type'          => 'B',
            'is_applicant'       => 1,
            'marital_status'     => $postdata['ekyc_marital_status'],
            'eng_pdar_name'      => $auth->name_eng,
            'eng_pdar_guardian'  => $postdata['ekyc_pdar_guardian'],            
            'pdar_gender'        => $gender,
            'pdar_add1'          => $postdata['ekyc_address'],
            'identity_ref_no'    => isset($auth->aadhaar_token)?$auth->aadhaar_token:'',
            'identity_type'      => isset($auth->type)?$auth->type:'',            
            'dob'                => $postdata['ekyc_dob'],
        ];
        $ins = $this->db->insert('settlement_applicant', $insert);
        return $ins;
    }

    // insert into applicant deleted data
    public function insertIntoApplicantDelete($case_no)
    {
        // get from settlement basic
        $basic = $this->getFromSettlementBasic($case_no)->row();

        //get main applicant 
        $appl = $this->getMainApplicant($case_no);

        $insert = [
            'usercode'                => $this->session->userdata('user_code'),
            'application_no'          => $basic->applid,
            'case_no'                 => $case_no,
            'service_code'            => $basic->service_code,
            'changed_date'            => date('Y-m-d'),
            'created_at'              => date('Y-m-d h:i:s'),
            'old_applicant_json_data' => json_encode($appl),
        ];
        $ins = $this->db->insert('applicant_deleted_data', $insert);
        return $ins;
    }

    //delete main applicant
    public function deleteOldMainAppl($case_no, $oldId)
    {
        //get main applicant 
        $appl = $this->getMainApplicant($case_no);

        // var_dump($appl);

        $delete = $this->db->query("DELETE FROM settlement_applicant WHERE case_no=? AND 
            is_applicant=? AND pdar_type=? AND id=?", array($case_no, 1, 'B', $oldId));
        return $delete;
    }

    // update settlement_applicant
    public function updateSettlementApplicant($case_no)
    {
        //get main applicant 
        $appl = $this->getMainApplicant($case_no);

        $update = [
            'del_status' => 1,
        ]; 
        $this->db->where('is_applicant', 1);
        $this->db->where('case_no', $case_no);
        $this->db->where('pdar_type', 'B');
        $this->db->where('del_status', 0);
        $this->db->update('settlement_applicant', $update);
        return $this->db->affected_rows();
    }

    //added for ekyc verification (new applicant add)
    public function ekycAtBasundhara($appl_no)
    {
        // echo $appl_no; die;
        $token = $this->utilityclass->createTokenJwt();
        // echo $token; die;
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."ekycNewApplicantEntry");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'appl_no' => $appl_no,
            'ip'      => $this->utilityclass->get_client_ip(),
            'api_key' => API_KEY,
            'token'   => $token,
        )));
        $data=curl_exec($curl_handle);
        curl_close($curl_handle);
        return $data;
    }

    // aadhaar ekyc verify
    public function ekycVerify($application_no, $dist_code, $scode)
    {
        $this->load->library('AES');
        $dhar_no = $this->utilityclass->encryptJwtCase($application_no);

        $basu_no = $this->getBasuApplIdFromCaseNo($application_no);
        $back_link = '';
        if($scode == SETTLEMENT_KHAS_LAND_ID) // settlement of khas land
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementKhasLand/secondProceeding?case='.$dhar_no);
        }
        else if($scode == SETTLEMENT_TENANT_ID) // settlement of occupancy tenant
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementTenant/secondProceeding?case='.$dhar_no);
        }
        else if($scode == SETTLEMENT_AP_TRANSFER_ID) // settlement of AP
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementAp/secondProceeding?case='.$application_no);
        }
        else if($scode == SETTLEMENT_TRIBAL_COMMUNITY_ID) // settlement of tribal community
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementTribal/secondProceeding?case='.$dhar_no);
        }
        else if($scode == SETTLEMENT_PGR_VGR_LAND_ID) // settlement of pgr vgr
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementVgr/secondProceeding?case='.$dhar_no);
        }
        else if($scode == SETTLEMENT_SPECIAL_CULTIVATORS_ID) // settlement of sp cultivators
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementCultivator/secondProceeding?case='.$dhar_no);
        }
        else if($scode == NC_KHAS_LAND_ID) // settlement of sp cultivators
        {
            $back_link = rawurlencode(base_url().'index.php/NcKhasland/secondProceeding?case='.$dhar_no);
        }
        else if($scode == NC_CULTIVATOR_ID) // settlement of sp cultivators
        {
            $back_link = rawurlencode(base_url().'index.php/NcCultivationLmController/secondProceeding?case='.$dhar_no);
        }
        else if($scode == SETTLEMENT_TENANT_URBAN_ID) // settlement of sp cultivators
        {
            $back_link = rawurlencode(base_url().'index.php/SettlementTenantUrban/secondProceeding?case='.$dhar_no);
        }
        else if($scode == TEA_SERVICE_CODE) // Tea Grant
        {
            $back_link = rawurlencode(base_url().'index.php/TeaGrantControllerLm/secondProceeding?case='.$dhar_no);
        }
        // else if($scode == NC_TRIBAL_ID) // settlement of sp cultivators
        // {
        //     $back_link = rawurlencode(base_url().'index.php/SettlementCultivator/secondProceeding?case='.$dhar_no);
        // }

        $get_response_url = rawurlencode(base_url().'index.php/DharitreeApi/getResponseAfterEkyc');

        $arr = array('back_url'=>$back_link, 'dist_code'=>$dist_code, 'dhar_no'=>$application_no, 'basu_no'=>$basu_no);
        $aes = new AES(json_encode($arr), ENCRYPTION_KEY);
        $key = $aes->encrypt();

        $encrypted_data = [
            'case_no'         => $application_no,
            'auth_key'        => 'ilrmsSignUp',
            'response_url'    => $get_response_url,
            'service_code'    => $scode,
            'service_name'    => 'MB2',
            'additional_ekyc' => array(),
            'app_no'          => $basu_no,
            'external_data'   => $key,
        ];

        $aes = new AES(json_encode($encrypted_data), ENCRYPTION_KEY);
        return $post_enc_data = $aes->encrypt();
    }

    public function checkJointApplEkycDone($case_no)
    {
        return $query = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND ekyc_done=?", array($case_no,1));
    }

    public function jointApplicantUpdateAsMain($case_no, $postdata, $oldId)
    {
        // get basundhara case no
        $basu_no = $this->getBasuApplIdFromCaseNo($case_no);

        //get data from settlement basic
        $basic = $this->getFromSettlementBasic($case_no);

        // get old main applicant
        $oldMainAppl = $this->getMainApplicant($case_no);

        // var_dump($postdata);

        // $this->db->trans_begin();

        //insert into applicant_deleted_data
        $insOld = [
            'usercode'                  => $this->session->userdata('user_code'),
            'application_no'            => $basic->applid,
            'service_code'              => $basic->service_code,
            'changed_date'              => date('Y-m-d'),
            'created_at'                => date('Y-m-d h:i:s'),
            'case_no'                   => $case_no,
            'old_applicant_json_data'   => json_encode($oldMainAppl),
        ];
        $insertOldData = $this->db->insert('applicant_deleted_data', $insOld);
        // echo $this->db->last_query();
        if($insertOldData != 1)
        {
            $this->db->trans_rollback();
            log_message('error','#ERR411: Insertion failed in applicant_deleted_data '.$this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERR411: Unable to add new applicant.',
            ];
            return $json;
        }

        // delete main applicant
        $delMain = $this->db->query("DELETE FROM settlement_applicant WHERE case_no=? AND is_applicant=? AND pdar_type=? AND id=?", array($case_no, 1, 'B', $oldId));
        // echo $this->db->last_query();
        if($this->db->affected_rows() != 1 && $delMain != 1)
        {
            $this->db->trans_rollback();
            log_message('error','#ERR423: Deletion failed from settlement_applicant '.$this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERR423: Unable to add new applicant.',
            ];
            return $json;
        }

        //update selected joint applicant as main Applicant
        $update = $this->db->query("UPDATE settlement_applicant SET 
            is_applicant=?, 
            ekyc_done=?,
            marital_status=?,
            pdar_add1=?,
            pdar_add2=? 
            WHERE ekyc_done=? AND case_no=? AND pdar_type=? AND is_applicant=?",
            array(1, 2, $postdata['ekyc_marital_status'], $postdata['ekyc_address'],
                    $postdata['ekyc_per_add'], 1, $case_no, 'B', 0));
        // echo $this->db->last_query();
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error','#ERR437: Updation failed from settlement_applicant '.$this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERR437: Unable to add new applicant.',
            ];
            return $json;
        }

        $insProceed = $this->insertSettlementProceeding($case_no);
        // echo $this->db->last_query(); die;
        if($insProceed != 1)
        {
            $this->db->trans_rollback();
            log_message('error','#ERR485: Insertion failed in settlement_proceeding '.$this->db->last_query());
            $json = [
                'responseType' => 3,
                'message'      => '#ERR485: Unable to add new applicant.',
            ];
            return $json;
        }

        $json = [
            'responseType' => 1,
            'message'      => '#SUCC450: Success',
        ];
        return json_encode($json);
    }


    public function getDeceasedData($applid)
    {
        return $query = $this->db->query("SELECT DISTINCT(b.applid) FROM rejected_remark a JOIN                 settlement_basic b ON a.case_no = b.case_no 
                                WHERE a.reject_code IN ('373', '371', '372') AND b.applid = ?", 
                                    array($applid))->num_rows();
    }




}