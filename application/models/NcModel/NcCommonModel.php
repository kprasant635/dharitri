<?php
class NcCommonModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->model('NcModel/NcServiceModel');

    }


    public function dbswitch($dist_code)
    {
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        }else if ($dist_code == "auth") {
            $this->db = $this->load->database('auth', TRUE);
        }
        return $this->db;
    }


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // get Nc Settlement Basic Details by case no
    public function getNcBasicDetails($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();
    }










    public function locationSelect($service_code, $status){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $Query = "";
        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
            if($lot_string != null ){
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code AND pending_officer = 'CO' AND status = '$status' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);

        return $data->result();

    }


    // get premium amount
    public function getPremium($case)
    {
        // $premium = $this->db->select()
        //     ->where('case_no',$case)
        //     ->where('is_final', 1)
        //     ->get('settlement_premium');
        // return $premium->row();
        $premium = "SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case' and is_final=1";
        $data = $this->db->query($premium);
        return $data->result();

    }


    // get Urban
    function getUrbanForRevertBack($case_no){
        $query = "SELECT is_urban FROM settlement_dag_details WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    // 12/01/2023
    public function getAdditionalPropertyDetail($applid){
        $addProperty = $this->db->select()
            ->where('applid',$applid)
            ->get('settlement_additional_property');
        return $addProperty;
    }

    public function getPdarCronNo($case_no){
        $pdarCronNo = $this->db->select('pdar_cron_no')
            ->where('case_no',$case_no)
            ->get('settlement_applicant')->num_rows();
        if($pdarCronNo > 0) {
            $cron_no = $pdarCronNo + 1;
        } else {
            $cron_no = 1;
        }
        return $cron_no;
    }

    public function getCoName($d, $s, $c){
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code 
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E' 
            and u.user_desig_code = 'CO' and lt.dist_code='$d' 
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function getSkName($d, $s, $c)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code 
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E' 
            and u.user_desig_code = 'SK' and lt.dist_code='$d' 
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);

        if($data->num_rows() > 0)
        {
            return $data->result();
        }
        else
        {
            return 'n';
        }

    }

    public function getPremiumArea(){
        // $sql = "Select * from settlement_premium_area where not paid in(1,2,3,4,5,6,7,8,9) order by paid asc";
        $sql = "Select * from settlement_premium_area where paid in(1,3,4,5,7,9,10) order by paid asc";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function insertBasic($case_no,$petition_no)
    {
        $pro_class = $this->input->post('protected_class');
        $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');
        $insert_data = array(
            'dist_code'               => $this->input->post('dist_code'),
            'subdiv_code'             => $this->input->post('subdiv_code'),
            'cir_code'                => $this->input->post('cir_code'),
            'mouza_pargona_code'      => $this->input->post('mouza_pargona_code'),
            'lot_no'                  => $this->input->post('lot_no'),
            'vill_townprt_code'       => $this->input->post('vill_townprt_code'),
            'service_code'            => $this->input->post('service_code'),
            'ref_no'                  => $this->input->post('ref_no'),
            'case_no'                 => $case_no,
            'trans_code'              => 'F',/////////full
            'petition_no'             => $petition_no,
            'year_no'                 => date('Y'),
            'date_entry'              => date('Y-m-d G:i:s'),
            'status'                  => 'W',
            'user_code'               => $this->session->userdata('user_code'),
            'lm_code'                 => $this->session->userdata('user_code'),
            'submission_date'         => date('Y-m-d G:i:s'),
            'from_office'             => 'LM',
            'pending_officer'         => 'CO',
            'pending_office'          => 'CO',
            'period_possession'       => date('Y-m-d'),
            'occupation_applicant'    => $this->input->post('occupation_applicant'),
            'applid'                  => $this->input->post('applid'),
            'protected_class'         => $protected_class_vr,
            'tribal_belt'             => $this->input->post('tribal_belt'),
            'uuid'                    => $this->input->post('uuid'),
            'caste'                   => $this->input->post('caste'),
            'bhumiputra_confirmation'       => $this->input->post('bhumiputra_confirmation'),
            'bhumiputra_certificate_no'     => $this->input->post('bhumiputra_certificate_no'),
            'bhumiputra_certificate_type'   => $this->input->post('bhumiputra_certificate_type'),
            'co_code' => $this->input->post('co_code')
        );

        $status = $this->db->insert('settlement_basic', $insert_data);
        return ($status == true ? true : false);
    }

    public function headquarterCheck($dist_code, $subdiv_code){
        $sqlDistHeadQtr = $this->db->query("SELECT district_headquater FROM location WHERE dist_code = ?  AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND vill_townprt_code = '00000' AND lot_no = '00'", array($dist_code, $subdiv_code));

        if($sqlDistHeadQtr->num_rows() > 0){
            return $sqlDistHeadQtr->row()->district_headquater;
        }
        else
        {
            return false;
        }

    }

    public function checkStatusFromBasic($case_no)
    {
        $sql = $this->db->query("SELECT status FROM settlement_basic WHERE case_no = '$case_no'");

        if($sql->num_rows() > 0)
        {
            return $sql->row()->status;
        }
        else
        {
            return false;
        }

    }

    public function checkIfForwardedFromLm($case_no){
        $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='LM'";
        $dataFound=$this->db->query($sqlCheckExist)->row();

        if($dataFound->c >0){
            return 'y';
        }
        else
        {
            return 'n';
        }
    }

    public function userCheckSDO($dist_code, $subdiv_code){
        $sdoUserCheck = $this->db->query("SELECT * FROM loginuser_table WHERE dist_code = ? AND subdiv_code = ? AND dis_enb_option = ? AND user_code LIKE ? LIMIT 1", array($dist_code, $subdiv_code, 'E', '%SDO%'));

        if($sdoUserCheck->num_rows() > 0){
            return 'y';
        }
        else
        {
            return 'n';
        }
    }

    // get all case under selected proposal in send by SDO to SDLAC KHAS
    public function getAllAppInReportSendByDcToSdlac($proposal_no)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_cases');
        $this->db->where('proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }

    // get proposal details by id
    public function getProposalDetailsById($proId,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('status', 1);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $data = $this->db->get()->row();

        return $data;
    }

    public function checkIfAreaModified($case_no){
        $sql = $this->db->query("SELECT * FROM settlement_area_history WHERE case_no = ?", array($case_no));

        if($sql->num_rows() > 0){
            return $sql->result();
        }
        else
        {
            return false;
        }


    }

    public function checkSdlacMember($p_no) {
        return $this->db->query("SELECT * FROM settlement_sdlac_member_report WHERE 
                        proposal_no=?", array($p_no));
    }

    public function checkAvailabilitySdlcMemberDistrictWise($dist_code) {
        return $this->db->query("SELECT A.* FROM users A JOIN loginuser_table B
                    ON A.dist_code = B.dist_code AND A.user_code=B.user_code
                    WHERE A.user_desig_code LIKE '%SDLC%' 
                    AND B.dis_enb_option = ? AND A.dist_code = ?", array('E', $dist_code));
    }

    function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }

    public function checkCasesApprovedBy($data) {

        $arr = $this->convertLiteral($data);
        $query = $this->db->query("SELECT string_agg(is_urban,',') as type FROM settlement_dag_details 
                    WHERE case_no in (".$arr.")")->row();
        $arr = explode(',',$query->type);
        return count(array_unique($arr));
    }

    public function getCurrentBasicStatus($case_no)
    {
        $sql = $this->db->query("SELECT status FROM settlement_basic WHERE case_no = ?", array($case_no));

        if($sql->num_rows() > 0)
        {
            return $sql->row()->status;
        }
        else
        {
            return 'n';
        }
    }

    // get all settlement deleted dags
    public function getDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_dag_details')
            ->get('settlement_deleted_data');
        return $dags->result();
    }

    public function getDeletedEncroacher($case)
    {
        $enc = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_applicant')
            ->get('settlement_deleted_data');
        return $enc->result();
    }

    // show reject modal
    public function getRejectModal($service_code)
    {
        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, remark_head, service_code, reject_code, remark FROM reject_master WHERE flag=? and service_code=?", array('1', (string)$service_code));
        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return 'n';
        }
    }

    // get premium amount Tea
    public function getPremiumTea($case)
    {
        $premium = "SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case' and is_final=1";
        $data = $this->db->query($premium);
        return $data->result();

    }


    //check additional property available by user
    public function activeAdditionalPropertyDetailByCase($caseno) {
        $addActiveProperty = $this->db->select()
            ->where('(case_no = \''.$caseno.'\' or applid = \''.$caseno.'\')  and enable_status = \'1\'')
            ->get('settlement_additional_property');

        return $addActiveProperty;
    }

    function fetchPattadarAadharData($db,$aadhar){
        $this->dbswitch($db);
        $sql="Select
                (select loc_name from location where dist_code=p.dist_code and subdiv_code='00') district,
                (select loc_name from location where dist_code=p.dist_code and subdiv_code=p.subdiv_code and cir_code=p.cir_code and mouza_pargona_code='00') circle,
                (select loc_name from location where dist_code=p.dist_code and subdiv_code=p.subdiv_code and cir_code=p.cir_code and mouza_pargona_code=p.mouza_pargona_code and lot_no=p.lot_no and vill_townprt_code=p.vill_townprt_code) as village_name,
                string_agg(p.pdar_name || ' ( ' || p.pdar_father || ' ) ' ,',') as name,d.dag_no from  chitha_pattadar p join
                chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code
                and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                TRIM(p.patta_no) = TRIM(d.patta_no) and
                p.pdar_id = d.pdar_id
                where p.pdar_aadharno=? and (d.p_flag='0' or d.p_flag is null)
                group by p.dist_code,p.subdiv_code,p.cir_code,p.mouza_pargona_code,
                p.lot_no,p.vill_townprt_code,p.pdar_id,p.patta_type_code,d.dag_no
            ";
        $result=$this->db->query($sql,array($aadhar));
        if($result->num_rows()==0){
            return null;
        }else{
            return $result->result_array();
        }
    }

    function calculateNewPremium($case_no,$dag_no,$newlessa){

        $per_lessa_amount = 0;
        $sql="Select total_lessa,amount_dag,final_amount from settlement_premium where case_no=? and dag_no=?";
        $result=$this->db->query($sql,array($case_no, $dag_no));
        if($result->num_rows()==0){

            $data = array(
                'responseType' => 0,
                'msg' => "Premium Not Found...",
            );

        }else{
            $resultPrem = $result->row();
            $per_lessa_amount = $resultPrem->amount_dag / $resultPrem->total_lessa;
            $amount_dag = $per_lessa_amount * $newlessa;

            $data = array(
                'responseType' => 2,
                'total_lessa' => $newlessa,
                'amount_dag' => $amount_dag
            );
        }
        return json_encode($data);

    }


    //*************** FILE UPLOAD BY API, ADDED ON 28/06/2023 *************************

    public function createTokenJwtFileUpload()
    {
        $timestamp = date("Y-m-d H:i:s");
        $jwt = new JWT();
        $key = DHAR_AUTH_KEY;
        $payload = array(
            "timestamp" => $timestamp
        );
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }


    public function uploadFileByApiBase($files, $application_no, $service_name, $doc_name) {

        $_FILES_UPLOAD = $files;

        $file = file_get_contents($_FILES_UPLOAD['tmp_name']);
        $file_upload = base64_encode($file);

        if(isset($_FILES_UPLOAD['name']))
        {
            // create jwt token
            $token = $this->createTokenJwtFileUpload();

            // Create a CURLFile object
            $cfile = curl_file_create($file_upload,$_FILES_UPLOAD['type'],$_FILES_UPLOAD['name']);

            // var_dump($cfile);

            $postRequest = array(
                'file'           => $file_upload,
                'application_no' => $application_no,
                'service_name'   => $service_name,
                'token'          => $token,
                'doc_name'       => $doc_name,
            );

            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, API_FOR_UPLOAD_BASE);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);
            $data = curl_exec($cURL);

            $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
            curl_close($cURL);
            if($httpcode != 200) {
                return false;
            }
            return $data;
        }
    }


    public function downloadFileFromApiBase($documentID,$content_type) // base64 encoded data
    {

        $postRequest = array(
            'documentID'   => $documentID,
            'service_name' => API_KEY,
            'token'        => $this->createTokenJwtFileUpload(),
        );

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_FOR_FETCH_BASE);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($cURL, CURLOPT_TIMEOUT, 40);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $data = curl_exec($cURL);


        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($cURL);
        $curl_error = curl_error($cURL);
        if ($curl_errno > 0) {
            log_message('error',"ERRORNO".$curl_errno."ERROR".$curl_error."documentID".$documentID."time".time());
            return false;
            // echo "cURL Error ($curl_errno): $curl_error\n";
        }
        curl_close($cURL);
        if($httpcode != 200) {
            return false;
        }
        //   ob_clean();
        $res= json_decode($data);
        //   header("Content-type: ".$content_type);
        return $res;
        //   return base64_decode($res->base64_data);
    }



    //*************** FILE UPLOAD BY API, ENDS HERE *************************

    // get urban by LM  (falls Under GMC)
    public function getLandFallsUnderUrban($case_no)
    {
        return $this->db->select('falls_und_gmc')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();
    }

    public function getChithaFlaggedRemarks($dags, $rejected_list)
    {
        $dagFlagCheckChitha = '';
        foreach($dags as $cd)
        {
            foreach($rejected_list as $rej_list_key => $rej_list_chitha)
            {
                if($rej_list_chitha->chitha_flag != 0)
                {

                    $chithaUuid = $this->utilityclass->getVillageUUID($cd->dist_code, $cd->subdiv_code, $cd->cir_code, $cd->mouza_pargona_code, $cd->lot_no, $cd->vill_townprt_code);

                    $resp = $this->utilityclass->getChithaFlagRemarks((string)$chithaUuid, (string)$cd->dag_no, $rej_list_chitha->chitha_flag);
                    if($resp == true)
                    {
                        $frech = '';
                        foreach($resp as $pp)
                        {
                            $frech .= $pp->remark.", ";
                        }
                        $dagFlagCheckChitha .= "<div class='text-danger alert-warning pl-2 pr-2 pb-1'><b style='border-radius:2px; background:red; color:white; padding:3px;'>Dag No ".$cd->dag_no." </b> &nbsp; <i class='fa fa-arrow-right' aria-hidden='true'></i> <span style='background:yellow; color:black; font-weight:500;'>This dag is flagged in Chitha with the followings - ".$frech."</span></div>";
                        break;
                    }
                }
            }
        }
        return $dagFlagCheckChitha;
    }


    public function getAllAppliedDagsByApplicant($case_no,$dag_no)
    {
        $dags = $this->db->select()
            ->where('case_no',$case_no)
            ->where('dag_no',$dag_no)
            ->get('settlement_area_history');

        return $dags->result();
    }

    public function locationSelectCoRevertCases($service_code, $status){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code AND pending_officer = 'LM' AND status = 'R' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);

        return $data->result();

    }

    public function locationSelectCoForwardCases($service_code, $status){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code AND (pending_officer = 'ADC' or pending_officer = 'SDO') AND status = 'W' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);

        return $data->result();

    }

    public function locationSelectCoRejectCases($service_code, $status){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $user = $this->session->userdata('user_desig_code');

        if($this->session->userdata('user_desig_code') == 'CO')
        {
            $sql = "SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code FROM settlement_basic WHERE service_code = $service_code AND pending_officer = '$user' AND status = 'D' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code";
        }
        elseif($this->session->userdata('user_desig_code') == 'SDO')
        {
            $sql = "SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code FROM settlement_basic WHERE service_code = $service_code AND pending_officer = '$user' AND status = 'D' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' and subdiv_code != '00' AND cir_code != '00' GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code";
        }
        else
        {
            $sql = "SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code FROM settlement_basic WHERE service_code = $service_code AND pending_officer = '$user' AND status = 'D' AND dist_code = '$dist_code' and subdiv_code != '00' AND cir_code != '00' GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code";
        }

        $data = $this->db->query($sql);
        // echo $this->db->last_query();

        return $data->result();

    }

    public function lmRejectedValidationBypassTrueAP($service_code, $rejected_list)
    {
        if($_POST['lm_note'] == '2')
        {
            //*****creating rejected_reasons array for insertion */
            $rejected_reasons = $_POST['rejected_reasons'];

            if(isset($_POST['sub_rejected_reasons']))
            {
                $sub_rej_reasons = $_POST['sub_rejected_reasons'];
            }
            else
            {
                $sub_rej_reasons = array();
            }

            $reject_remarks_arr = array();

            $firstArray = array();
            $secondArray = array();

            $is_nr_settlement = '';

            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                if($rej_val == CHECK_IF_AP_TO_PP)
                {
                    $is_nr_settlement = 'AP to PP case';
                }

                $firstArray[] = $rej_key;
            }

            foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
            {
                $secondArray[] = $sub_rej_key;
            }

            $dif_array = array_diff($firstArray, $secondArray);

            foreach($dif_array as $key)
            {
                foreach($rejected_reasons as $rej_key => $rej_val)
                {
                    if($key == $rej_key)
                    {
                        $rd_val = explode('_', $rej_key);

                        if(isset($rd_val[1]))
                        {
                            $remark_dag_nost = $rd_val[1];
                        }
                        else
                        {
                            $remark_dag_nost = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rd_val[0],
                            'dag_no' => $remark_dag_nost,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => '',
                        ];
                    }
                }
            }


            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
                {
                    if($rej_key == $sub_rej_key)
                    {
                        $rdt_val = explode('_', $sub_rej_key);

                        if(isset($rdt_val[1]))
                        {
                            $remark_dag_no = $rdt_val[1];
                        }
                        else
                        {
                            $remark_dag_no = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rdt_val[0],
                            'dag_no' => $remark_dag_no,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => $sub_rej_val,
                        ];
                    }
                }
            }

            //*****for inserting in the lm rejected_reason */
            $reject_remarks = $reject_remarks_arr;

            //*******comma separated */
            $rr_array = array();
            foreach($reject_remarks as $rr)
            {
                foreach($rejected_list as $rr_db)
                {
                    if($rr_db->reject_code == $rr->reject_code)
                    {
                        $rr_array[] = $rr_db->remark. (($rr->sub_rejected_remark != '') ? ' (Sub-Reason: '.$rr->sub_rejected_remark.')' : '');
                    }
                }
            }

            $rejected_reason_string = "Rejected Reasons: ".implode ( ", ", $rr_array );
        }
        else
        {
            $reject_remarks = null;
            $rejected_reason_string = '';
        }

        return (object)[
            'reject_remarks' => $reject_remarks,
            'rejected_reason_string' => $rejected_reason_string,
            'is_nr_settlement' => $is_nr_settlement
        ];
    }

    public function lmRejectedValidationBypassTrue($service_code, $rejected_list)
    {
        if($_POST['lm_note'] == '2')
        {
            //*****creating rejected_reasons array for insertion */
            $rejected_reasons = $_POST['rejected_reasons'];

            if(isset($_POST['sub_rejected_reasons']))
            {
                $sub_rej_reasons = $_POST['sub_rejected_reasons'];
            }
            else
            {
                $sub_rej_reasons = array();
            }

            $reject_remarks_arr = array();

            $firstArray = array();
            $secondArray = array();

            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                $firstArray[] = $rej_key;
            }

            foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
            {
                $secondArray[] = $sub_rej_key;
            }

            $dif_array = array_diff($firstArray, $secondArray);

            foreach($dif_array as $key)
            {
                foreach($rejected_reasons as $rej_key => $rej_val)
                {
                    if($key == $rej_key)
                    {
                        $rd_val = explode('_', $rej_key);

                        if(isset($rd_val[1]))
                        {
                            $remark_dag_nost = $rd_val[1];
                        }
                        else
                        {
                            $remark_dag_nost = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rd_val[0],
                            'dag_no' => $remark_dag_nost,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => '',
                        ];
                    }
                }
            }

            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
                {
                    if($rej_key == $sub_rej_key)
                    {

                        $rdt_val = explode('_', $sub_rej_key);

                        if(isset($rdt_val[1]))
                        {
                            $remark_dag_no = $rdt_val[1];
                        }
                        else
                        {
                            $remark_dag_no = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rdt_val[0],
                            'dag_no' => $remark_dag_no,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => $sub_rej_val,
                        ];
                    }
                }
            }

            //*****for inserting in the lm rejected_reason */
            $reject_remarks = $reject_remarks_arr;

            //*******comma separated */
            $rr_array = array();
            foreach($reject_remarks as $rr)
            {
                foreach($rejected_list as $rr_db)
                {
                    if($rr_db->reject_code == $rr->reject_code)
                    {
                        $rr_array[] = $rr_db->remark. (($rr->sub_rejected_remark != '') ? ' (Sub-Reason: '.$rr->sub_rejected_remark.')' : '');
                    }
                }
            }

            $rejected_reason_string = "Rejected Reasons: ".implode ( ", ", $rr_array );

        }
        else
        {
            $reject_remarks = null;
            $rejected_reason_string = '';
        }

        return (object)[
            'reject_remarks' => $reject_remarks,
            'rejected_reason_string' => $rejected_reason_string
        ];
    }

    public function lmRejectedValidationBypassFalse($service_code)
    {
        if($_POST['lm_note'] == '2')
        {
            //*****creating rejected_reasons array for insertion */
            $rejected_reasons = $_POST['rejected_reasons'];

            if(isset($_POST['sub_rejected_reasons']))
            {
                $sub_rej_reasons = $_POST['sub_rejected_reasons'];
            }
            else
            {
                $sub_rej_reasons = array();
            }

            $reject_remarks_arr = array();

            $firstArray = array();
            $secondArray = array();

            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                $firstArray[] = $rej_key;
            }

            foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
            {
                $secondArray[] = $sub_rej_key;
            }

            $dif_array = array_diff($firstArray, $secondArray);

            foreach($dif_array as $key)
            {
                foreach($rejected_reasons as $rej_key => $rej_val)
                {
                    if($key == $rej_key)
                    {

                        $rd_val = explode('_', $rej_key);

                        if(isset($rd_val[1]))
                        {
                            $remark_dag_nost = $rd_val[1];
                        }
                        else
                        {
                            $remark_dag_nost = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rej_val,
                            'dag_no' => $remark_dag_nost,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => '',
                        ];
                    }
                }
            }


            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
                {
                    if($rej_key == $sub_rej_key)
                    {
                        $rdt_val = explode('_', $sub_rej_key);

                        if(isset($rdt_val[1]))
                        {
                            $remark_dag_no = $rdt_val[1];
                        }
                        else
                        {
                            $remark_dag_no = '';
                        }
                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rej_val,
                            'dag_no' => $remark_dag_no,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => $sub_rej_val,
                        ];
                    }
                }
            }

            //*****for inserting in the lm rejected_reason */
            $reject_remarks = $reject_remarks_arr;
        }
        else
        {
            $reject_remarks = null;
        }

        return (object)[
            'reject_remarks' => $reject_remarks,
        ];

    }

    public function firstProceedingValidationBypassTrue($service_code, $case_no, $application_no, $rejected_list)
    {
        if(strlen($_FILES['field_report']['name']) > 0)
        {
            $field_report_file = $_FILES['field_report'];

            $timestamp = date('mdYhis', time()).uniqid();
            // For uploading field report                   

            //upload field report file by calling API
            $field_file_name = 'field_report'.$timestamp;

            $field_report_api_file = $this->uploadFileByApiBase($field_report_file, $application_no, API_KEY, $field_file_name);

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
                    'date_entry'      => date('Y-m-d h:i:s'),
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
                $this->session->set_flashdata('message', "#ERRADDDOC00998503: Only PDF and Image files area allowed : ".$application_no);
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

                if(!move_uploaded_file($field_report_file['tmp_name'], $field_report_path)){
                    log_message('error', 'Unable to move field report file for case no '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRADDDOC000331: Only PDF and Image files area allowed : ".$application_no);
                    redirect(base_url() . "index.php/home");
                }
            }

        }

        // upload additional file
        if(isset($_FILES['fileUpload']['name'])){

            $fileCount = count($_FILES['fileUpload']['name']);

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
                        'mut_type'   => $service_code,
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

        //*****insert LM note and rejected reason only*/

        $comment = addslashes($this->input->post('lm_note'));

        if($service_code == SETTLEMENT_AP_TRANSFER_ID)
        {
            $responseObj = $this->lmRejectedValidationBypassTrueAP($service_code, $rejected_list);

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'). ' '.$responseObj->rejected_reason_string,
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'lm_rejected_remarks' => json_encode($responseObj->reject_remarks),
                // 'is_nr_settlement'=> $responseObj->is_nr_settlement,
                'is_nr_settlement'=> $this->input->post('is_nr_settlement'),
                'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
            );
        }
        else
        {
            $responseObj = $this->lmRejectedValidationBypassTrue($service_code, $rejected_list);

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'). ' '.$responseObj->rejected_reason_string,
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'lm_rejected_remarks' => json_encode($responseObj->reject_remarks),
            );
        }

        $insLmnoteValidBypass = $this->db->insert('settlement_ap_lmnote', $lmnote);

        if ($insLmnoteValidBypass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET003405: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET003405: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
    }

    public function secondProceedingValidationBypassTrue($service_code, $case_no, $application_no, $rejected_list)
    {
        //*******field report upload if any  */
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
        // upload additional file
        if(isset($_FILES['fileUpload']['name'])){

            $fileCount = count($_FILES['fileUpload']['name']);

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
                        'mut_type'   => $service_code,
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

        //*****insert LM note and rejected reason only*/

        $comment = addslashes($this->input->post('lm_note'));

        if($service_code == SETTLEMENT_AP_TRANSFER_ID)
        {
            $responseObj = $this->lmRejectedValidationBypassTrueAP($service_code, $rejected_list);

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'). ' '.$responseObj->rejected_reason_string,
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'lm_rejected_remarks' => json_encode($responseObj->reject_remarks),
                'is_nr_settlement'=> $responseObj->is_nr_settlement,
                'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
            );
        }
        else
        {
            $responseObj = $this->lmRejectedValidationBypassTrue($service_code, $rejected_list);

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'). ' '.$responseObj->rejected_reason_string,
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'lm_rejected_remarks' => json_encode($responseObj->reject_remarks),
            );
        }


        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_ap_lmnote', $lmnote);

        if ($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET00333405: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET00333405: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
    }

    public function apNoticeCases(){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = '14' AND (pending_officer = 'CO' or pending_officer = 'LM') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";
        $sql = "SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code FROM settlement_basic WHERE service_code = '14' AND (pending_officer = 'CO' or pending_officer = 'LM') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code";

        $data = $this->db->query($sql);

        return $data->result();

    }

    public function checkMaxAreaAllowed($prid)
    {

        $sql = $this->db->query("SELECT max_land FROM settlement_premium_rate WHERE paid = ? limit 1", array($prid));

        if($sql->num_rows() > 0){
            return $sql->row();
        }
        else
        {
            return false;
        }
    }

    public function fileCheckCopy($file)
    {
        if(file_exists($file))
        {
            $open_notice_file = fopen($file, "r") or die("Unable to open file!");
            $read_notice_file = fread($open_notice_file,filesize($file));
            fclose($open_notice_file);
            return $read_notice_file;
        }
        else
        {
            $copyFileContent = '';

            $server_link = 'http://10.177.0.35/'.DHAR_APP_NAME.'/'.$file;

            if(file_exists($server_link))
            {
                $openFile = fopen($server_link.$file, "r") or die("Unable to open file!");
                $copyFileContent = fread($openFile,filesize($file));
                fclose($openFile);
            }
            else
            {
                $server_link = 'http://10.177.0.34/'.DHAR_APP_NAME.'/'.$file;

                if(file_exists($server_link))
                {
                    $openFile = fopen($server_link.$file, "r") or die("Unable to open file!");
                    $copyFileContent = fread($openFile,filesize($file));
                    fclose($openFile);
                }
                else
                {
                    return false;
                }
            }

            $pasteFile = fopen($file, "w") or die("Unable to open file!");
            fwrite($pasteFile, $copyFileContent);
            fclose($pasteFile);

            return $pasteFile;
        }

    }

    public function caseListUnderMappingLot(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
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
        log_message("error","MB002: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
    }



    public function locationSelectReGeotag($service_code, $status){

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $Query = "";
        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
            if($lot_string != null ){
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }
        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code AND status != '$status' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";
        $data = $this->db->query($sql);
        return $data->result();

    }

    public function callRemoteFile($filepath, $url)
    {
        $filewriteurl=$url;

        if ($_SERVER['HTTP_HOST'] =='10.177.0.34')
        {
            $url = 'http://10.177.0.35/'.DHAR_APP_NAME.'/'.$url;
        }
        else
        {
            $url = 'http://10.177.0.34/'.DHAR_APP_NAME.'/'.$url;
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'path' => DHAR_APP_NAME.'/'.$filepath,
        )));

        $output = curl_exec($curl_handle);

        $base_64_file_path = $filewriteurl;

        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        fwrite($file_to_write_base64, $output);
        fclose($file_to_write_base64);

        if(file_exists($filewriteurl))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // public function getPremiumCategory(){
    //     $sql = "Select * from settlement_premium_category order by pcid asc";
    //     $data = $this->db->query($sql);
    //     return $data->result();
    // }

    public function ncBtadCheck($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $sql = $this->db->query("Select count(*) as count from (select *  from chitha_basic cb 
                                    where  cb.dist_code = ?
                                    and cb.subdiv_code = ?
                                    and cb.cir_code = ?
                                    and cb.mouza_pargona_code = ?
                                    and cb.lot_no = ?
                                    and cb.vill_townprt_code = ?
                                    and cb.dag_no = ?) t
                                    join location l on 
                                    t.dist_code = l.dist_code 
                                    and t.subdiv_code = l.subdiv_code 
                                    and t.cir_code = l.cir_code 
                                    and t.mouza_pargona_code = l.mouza_pargona_code 
                                    and t.lot_no = l.lot_no 
                                    and t.vill_townprt_code = l.vill_townprt_code 
                                    where  (l.nc_btad is not null or l.nc_btad='K')", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));
        return $sql->row()->count;
    }


    public function ncBtadCheckWithK($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $sql = $this->db->query("Select count(*) as count from (select *  from chitha_basic cb 
                                    where  cb.dist_code = ?
                                    and cb.subdiv_code = ?
                                    and cb.cir_code = ?
                                    and cb.mouza_pargona_code = ?
                                    and cb.lot_no = ?
                                    and cb.vill_townprt_code = ?
                                    and cb.dag_no = ?) t
                                    join location l on 
                                    t.dist_code = l.dist_code 
                                    and t.subdiv_code = l.subdiv_code 
                                    and t.cir_code = l.cir_code 
                                    and t.mouza_pargona_code = l.mouza_pargona_code 
                                    and t.lot_no = l.lot_no 
                                    and t.vill_townprt_code = l.vill_townprt_code 
                                    where l.nc_btad='K' ", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));
        return $sql->row()->count;
    }

    public function premiumReCalculation($case_no)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if($dagsCheck->num_rows() > 0)
        {
            $dagCheck = $dagsCheck->result();
        }
        else
        {
            return array('status'=>1,'message'=>'Dag not found..case no'.$case_no);
        }

        $basic = $this->NcServiceModel->getSettlementBasic($case_no);


        $sumMbAmount=0;
        $sumMbArea=0;
        $finalamount =0;
        foreach ($dagCheck as $premiumdags) {

            $lastId ='';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if($findLastPremium->num_rows() > 0)
            {
                //newly add value-----------
                // $sqlForZonalValue = $this->db->query("select dag_no,zone_id,subclass_id,
                // (select MAX(land_rate) as new_zonal_value from villagewise_zone_info where
                //     unique_village_code = dzi.unique_village_code and zone_code::varchar=dzi.zone_id and subclass_name like 'Residential%' )
                //             from dagwise_zone_info dzi where dzi.unique_village_code = '$basic[uuid]' and dzi.dag_no='$premiumdags->dag_no'");

                // log_message('error',"----------Zonal Value Query-------".$this->db->last_query());
                // $newZonalRow = $sqlForZonalValue->row();  
                // //get zonal value from max land_rate from settlement -----------
                // $premium_per_bigha = $newZonalRow->new_zonal_value;

                $premData = $findLastPremium->row();
                $lastId = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate =  $premData->rate;
                $concession_rate=25;
                $prem_area = $premData->total_lessa;
                $area_name = $premData->area_name;
                $rate_type = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
            }
            else
            {

                return array('status'=>1,'message'=>'Last premium not available for cases...Case no.'.$case_no);
            }

            $oldArea = array(1,2,3,4,5,6,7,8,9);
            $premPercentage = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
            $premRupees = array(7,8,9,10,18,19,20,21,22);

            if(in_array($area_name, $oldArea) && (($basic['dept_order_no'] == null || $basic['dept_order_no'] == '' || empty($basic['dept_order_no'])) || ($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))))
            {
                $area_name_check = $this->utilityclass->getAreaCategory($premiumdags->dist_code,$premiumdags->subdiv_code,$premiumdags->cir_code,$premiumdags->mouza_pargona_code,$premiumdags->lot_no,$premiumdags->vill_townprt_code,$premiumdags->dag_no);
                if(!in_array($area_name_check, $premRupees))
                {
                    return array('status'=>1,'message'=>'Old dag area flag found for this case, please use modification request...Case no.'.$case_no);
                }
            }

            $oldRupeesArea = array(7,8,9,10);
            $mbLandNullArea = array(7,8,9,10,18,20,22);

            $isRural=0;

            if(in_array($area_name, $oldArea))
            {


                $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code,$premiumdags->subdiv_code,$premiumdags->cir_code,$premiumdags->mouza_pargona_code,$premiumdags->lot_no,$premiumdags->vill_townprt_code,$premiumdags->dag_no);

                if($area_name == false)
                {
                    return array('status'=>1,'message'=>'New dag area flag not found!...Case no.'.$case_no);
                }

                if($prem_rate == 10){
                    $findrate=10;
                }elseif($prem_rate == 30){
                    $findrate=30;
                }elseif($prem_rate == 100){
                    $findrate=100;
                }

                if(!in_array($area_name, $mbLandNullArea))
                {
                    $getPrid = $this->db->query("SELECT prid FROM settlement_premium_rate WHERE paid = ? and rate= ?", array($area_name,$findrate));


                    if($getPrid->num_rows() <= 0)
                    {
                        return array('status'=>1,'message'=>'#ERR254144: Something went wrong!'.$case_no);
                    }

                    $prid = $getPrid->row()->prid;



                    $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($prid));

                    $rate_type = $prid;

                }else{
                    $isRural=1;
                }


            }
            else
            {
                $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($rate_type));
            }

            if($isRural!=1)
            {

                if($findLastArea->num_rows() > 0)
                {
                    $premArea = $findLastArea->row();
                }
                else
                {
                    return array('status'=>1,'message'=>'Max area not available for case no...'.$case_no);
                }

                $mb_land = $premArea->mb_land;
                $max_land = $premArea->max_land!=null? $premArea->max_land:0;
                if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))){

                    if($mb_land == 25){
                        $mb_land=1600;
                    }else if ($mb_land == 30){
                        $mb_land=1920;
                    }else if ($mb_land == 40){
                        $mb_land=2560;
                    }

                }
            }



            if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;

            }else{
                $area_in_bigha=100;
            }




            // if(in_array($area_name, $oldArea)){
            //     // return array('status'=>3,'message'=>'Old area flag found for this dag, case no: '.$case_no);


            // }

            if($isRural!=1)
            {

                if(in_array($area_name, $premRupees)){
                    return array('status'=>2,'message'=>null);
                }
            }


            if ($premData->concession=="YES"){
                if (in_array($area_name, $premPercentage)){
                    if($prem_area>$mb_land){
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount1 = ceil($premium * $discount / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    }else{
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount = ($premium * $discount / 100);
                        // $finalamount = round($amount,2);
                        $finalamount = ceil($amount);
                    }

                }
                else if(in_array($area_name, $premRupees)){
                    $prem_rate=100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $discount = $prem_rate - $concession_rate;
                    $amount = ($premium * $discount / 100);
                    $finalamount = ceil($amount);
                }

            }else if($premData->concession=="NO"){

                if (in_array($area_name, $premPercentage)){
                    if($prem_area>$mb_land){
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $amount1 = ceil($premium * $prem_rate / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);

                    }else{
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $amount = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                }
                else if(in_array($area_name, $premRupees)){
                    $prem_rate=100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $amount = ($premium * $prem_rate / 100);
                    $finalamount = ceil($amount);
                }
            }



            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (($amount_dag != $finalamount) || ($area_name != $premData->area_name)){

                $premiumdata=array(
                    'case_no'=>$case_no,
                    'user_code'=>$this->session->userdata('user_code'),
                    // 'uuid'=>$premdags->uuid,
                    'dag_no'=>$premData->dag_no,
                    'zonal_valuation'=>$premData->zonal_valuation,
                    'area_name'=>$area_name,
                    'land_type'=>$premData->land_type,
                    'rate_type'=>$rate_type,
                    'rate'=>$prem_rate,
                    'concession'=>$premData->concession,
                    'amount_dag'=>$finalamount,
                    'final_amount'=>null,
                    'due_amount'=>null,
                    'total_lessa'=>$prem_area,
                    'is_full_pay'=>$premData->is_full_pay,
                    'is_final'=>1,
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'approve_by'=>$premData->approve_by,
                    'zone_code'=>$premData->zone_code,
                    'subclass_code'=>$premData->subclass_code,
                    'old_zonal_valuation'=>$premData->old_zonal_valuation
                );

                $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                if ($reInsPremium != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET000102: Something went wrong Case No '.$case_no);
                }

                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                $updatePrem = $this->db->query($sqlprem);

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET900311: Something went wrong Case No  '.$case_no);
                }

            }



        }

        if(!in_array($area_name, $mbLandNullArea))
        {
            if($max_land!=0 && $sumMbArea>$max_land)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET98703161: Max area exceed RTPS Case No '.$case_no);
                return array('status'=>1,'message'=>'#ERRSET98703161: Max area exceed.. Case No  '.$case_no);
            }
        }


        if (($due_amount != $sumMbAmount) || ($area_name != $premData->area_name)){

            $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
            $updatePremium = $this->db->query($sqlPremUpdate);

            if ($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No '.$case_no);
                return array('status'=>1,'message'=>'#ERRSET900316661: Something went wrong Case No..'.$case_no);
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
                'note_on_order' => 'Premium updated due to policy changed',
                'status' => 'M',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Premium updated',
                'note_type' => 'Premium updated due to policy changed',
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP45333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                return array('status'=>1,'message'=>'#ERRORPP45333: Failed to forward the case for Case No : '.$case_no);
            }
            //////proceeding end//////

        }

    }

    // public function premiumReCalculation($case_no)
    // {
    //     $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
    //     if($dagsCheck->num_rows() > 0)
    //     {
    //         $dagCheck = $dagsCheck->result();
    //     }
    //     else
    //     {
    //         return array('status'=>1,'message'=>'Dag not found..case no'.$case_no);
    //     }

    //     $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);


    //     $sumMbAmount=0;
    //     $sumMbArea=0;
    //     $finalamount =0;
    //     foreach ($dagCheck as $premiumdags) {

    //         $lastId ='';
    //         $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
    //         if($findLastPremium->num_rows() > 0)
    //         {
    //             //newly add value-----------
    //             // $sqlForZonalValue = $this->db->query("select dag_no,zone_id,subclass_id,
    //             // (select MAX(land_rate) as new_zonal_value from villagewise_zone_info where
    //             //     unique_village_code = dzi.unique_village_code and zone_code::varchar=dzi.zone_id and subclass_name like 'Residential%' )
    //             //             from dagwise_zone_info dzi where dzi.unique_village_code = '$basic[uuid]' and dzi.dag_no='$premiumdags->dag_no'");

    //             // log_message('error',"----------Zonal Value Query-------".$this->db->last_query());
    //             // $newZonalRow = $sqlForZonalValue->row();  
    //             // //get zonal value from max land_rate from settlement -----------
    //             // $premium_per_bigha = $newZonalRow->new_zonal_value;

    //             $premData = $findLastPremium->row();
    //             $lastId = $premData->pid;
    //             $prem_zonal = $premData->zonal_valuation;
    //             $prem_rate =  $premData->rate;
    //             $concession_rate=25;
    //             $prem_area = $premData->total_lessa;
    //             $area_name = $premData->area_name;
    //             $rate_type = $premData->rate_type;
    //             $amount_dag = $premData->amount_dag;
    //             $due_amount = $premData->due_amount;
    //         }
    //         else
    //         {

    //             return array('status'=>1,'message'=>'Last premium not available for cases...Case no.'.$case_no);
    //         }

    //         $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($rate_type));
    //         if($findLastArea->num_rows() > 0)
    //         {
    //             $premArea = $findLastArea->row();
    //         }
    //         else
    //         {
    //             return array('status'=>1,'message'=>'Max area not available for case no...'.$case_no);
    //         }

    //         $mb_land = $premArea->mb_land;
    //         $max_land = $premArea->max_land!=null? $premArea->max_land:0;

    //         if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))){
    //             $area_in_bigha=6400;
    //             if($mb_land == 25){
    //                 $mb_land=1600;
    //             }else if ($mb_land == 30){
    //                 $mb_land=1920;
    //             }else if ($mb_land == 40){
    //                 $mb_land=2560;
    //             }
    //         }else{
    //             $area_in_bigha=100;
    //         }

    //         $oldArea = array(1,2,3,4,5,6);
    //         $premPercentage = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
    //         $premRupees = array(7,8,9,10,18,19,20,21,22);


    //         if(in_array($area_name, $oldArea)){
    //             // return array('status'=>3,'message'=>'Old area flag found for this dag, case no: '.$case_no);
    //             $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code,$premiumdags->subdiv_code,$premiumdags->cir_code,$premiumdags->mouza_pargona_code,$premiumdags->lot_no,$premiumdags->vill_townprt_code,$premiumdags->dag_no);

    //         }

    //         if(in_array($area_name, $premRupees)){
    //             return array('status'=>2,'message'=>null);
    //         }

    //         if ($premData->concession=="YES"){
    //             if (in_array($area_name, $premPercentage)){
    //                 if($prem_area>$mb_land){
    //                     $premium = $mb_land * $prem_zonal / $area_in_bigha;
    //                     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
    //                     $amount1 = ceil($premium * $discount / 100);

    //                     $access_area = $prem_area - $mb_land;
    //                     $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
    //                     $amount2 = ceil($premium2);

    //                     $finalamount = ceil($amount1 + $amount2);
    //                 }else{
    //                     $premium = $prem_area * $prem_zonal / $area_in_bigha;
    //                     $discount = $prem_rate-($prem_rate * $concession_rate / 100);
    //                     $amount = ($premium * $discount / 100);
    //                     // $finalamount = round($amount,2);
    //                     $finalamount = ceil($amount);
    //                 }

    //             }
    //             else if(in_array($area_name, $premRupees)){
    //                 $premium = $prem_area * $prem_rate / $area_in_bigha;
    //                 $discount = $prem_rate - $concession_rate;
    //                 $amount = ($premium * $discount / 100);
    //                 $finalamount = ceil($amount);
    //             }

    //         }else if($premData->concession=="NO"){

    //             if (in_array($area_name, $premPercentage)){
    //                 if($prem_area>$mb_land){
    //                     $premium = $mb_land * $prem_zonal / $area_in_bigha;
    //                     $amount1 = ceil($premium * $prem_rate / 100);

    //                     $access_area = $prem_area - $mb_land;
    //                     $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
    //                     $amount2 = ceil($premium2);

    //                     $finalamount = ceil($amount1 + $amount2);

    //                 }else{
    //                     $premium = $prem_area * $prem_zonal / $area_in_bigha;
    //                     $amount = ($premium * $prem_rate / 100);
    //                     $finalamount = ceil($amount);
    //                 }
    //             }
    //             else if(in_array($area_name, $premRupees)){
    //                 $premium = $prem_area * $prem_rate / $area_in_bigha;
    //                 $amount = ($premium * $prem_rate / 100);
    //                 $finalamount = ceil($amount);
    //             }
    //         }

    //         $sumMbAmount += $finalamount;
    //         $sumMbArea += $prem_area;

    //         if (($amount_dag != $finalamount) || ($area_name != $premData->area_name)){

    //             $premiumdata=array(
    //                 'case_no'=>$case_no,
    //                 'user_code'=>$this->session->userdata('user_code'),
    //                 // 'uuid'=>$premdags->uuid,
    //                 'dag_no'=>$premData->dag_no,
    //                 'zonal_valuation'=>$premData->zonal_valuation,
    //                 'area_name'=>$area_name,
    //                 'land_type'=>$premData->land_type,
    //                 'rate_type'=>$premData->rate_type,
    //                 'rate'=>$premData->rate,
    //                 'concession'=>$premData->concession,
    //                 'amount_dag'=>$finalamount,
    //                 'final_amount'=>null,
    //                 'due_amount'=>null,
    //                 'total_lessa'=>$prem_area,
    //                 'is_full_pay'=>$premData->is_full_pay,
    //                 'is_final'=>1,
    //                 'date_entry'=>date('Y-m-d h:i:s'),
    //                 'approve_by'=>$premData->approve_by,
    //                 'zone_code'=>$premData->zone_code,
    //                 'subclass_code'=>$premData->subclass_code,
    //                 'old_zonal_valuation'=>$premData->old_zonal_valuation
    //             );

    //             $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
    //             if ($reInsPremium != 1) {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
    //                 return array('status'=>1,'message'=>'#ERRSET000102: Something went wrong Case No '.$case_no);
    //             }

    //             $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
    //             $updatePrem = $this->db->query($sqlprem);

    //             if ($this->db->affected_rows() == 0)
    //             {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No '.$case_no);
    //                 return array('status'=>1,'message'=>'#ERRSET900311: Something went wrong Case No  '.$case_no);
    //             }

    //         }



    //     }

    //     if($max_land!=0 && $sumMbArea>$max_land)
    //     {
    //         $this->db->trans_rollback();
    //         log_message('error', '#ERRSET98703161: Max area exceed RTPS Case No '.$case_no);
    //         return array('status'=>1,'message'=>'#ERRSET98703161: Max area exceed.. Case No  '.$case_no);
    //     }

    //     if (($due_amount != $sumMbAmount) || ($area_name != $premData->area_name)){

    //         $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
    //         $updatePremium = $this->db->query($sqlPremUpdate);

    //         if ($this->db->affected_rows() == 0)
    //         {
    //             $this->db->trans_rollback();
    //             log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No '.$case_no);
    //             return array('status'=>1,'message'=>'#ERRSET900316661: Something went wrong Case No..'.$case_no);
    //         }

    //     }

    // }
    // public function premiumReCalculationTea($case_no)
    // {
    //     $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
    //     if($dagsCheck->num_rows() > 0)
    //     {
    //         $dagCheck = $dagsCheck->result();
    //     }
    //     else
    //     {
    //         return array('status'=>1,'message'=>'Dag not found..case no'.$case_no);
    //     }

    //     $sumMbAmount=0;
    //     $sumMbArea=0;
    //     $finalamount =0;
    //     foreach ($dagCheck as $premiumdags) {

    //         if(trim($premiumdags->is_urban) == 'Y')
    //         {
    //             return array('status'=>1,'message'=>'Urban flag found!'.$case_no);
    //         }

    //         $lastId ='';
    //         $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
    //         if($findLastPremium->num_rows() > 0)
    //         {
    //             $premData = $findLastPremium->row();
    //             $lastId = $premData->pid;
    //             $prem_zonal = $premData->zonal_valuation;
    //             $prem_rate =  $premData->rate;
    //             $concession_rate=25;
    //             $prem_area = $premData->total_lessa;
    //             $area_name = $premData->area_name;
    //             $rate_type = $premData->rate_type;
    //             $amount_dag = $premData->amount_dag;
    //             $due_amount = $premData->due_amount;
    //         }
    //         else
    //         {

    //             return array('status'=>1,'message'=>'Last premium not available for cases...Case no.'.$case_no);
    //         }

    //         if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY)))
    //         {
    //             $area_in_bigha=6400;
    //         }
    //         else
    //         {
    //             $area_in_bigha=100;
    //         }

    //         $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);

    //         if(trim($get_settlement_basic->cult_board) == 'TEA')
    //         {
    //             //********Rs. 1000 per bigha till 30 bigha and rest zonalvalue */
    //             $zonalValuePerLessa = $prem_zonal/$area_in_bigha;
    //             $amountPerLessa = 1000/$area_in_bigha;

    //             if($prem_area <= 3000)
    //             {
    //                 $finalamount = $prem_area * $amountPerLessa;
    //             }
    //             else
    //             {
    //                 $excessAmount = ($prem_area - 3000) * $zonalValuePerLessa;
    //                 $thirtyAmount = 3000 * $amountPerLessa;
    //                 $finalamount = $excessAmount + $thirtyAmount;
    //             }
    //         }
    //         else
    //         {
    //             //********30% of zonal value till 30 bigha and rest zonalvalue */
    //             $zonalValuePerLessa = $prem_zonal/$area_in_bigha;
    //             $thirtyPercentOfZonalValue = 30/100 * $zonalValuePerLessa;

    //             if($prem_area <= 3000)
    //             {
    //                 $finalamount = $prem_area * $thirtyPercentOfZonalValue;
    //             }
    //             else
    //             {
    //                 $excessAmount = ($prem_area - 3000) * $zonalValuePerLessa;
    //                 $thirtyAmount = 3000 * $thirtyPercentOfZonalValue;
    //                 $finalamount = $excessAmount + $thirtyAmount;
    //             }
    //         }

    //         $sumMbAmount += $finalamount;
    //         $sumMbArea += $prem_area;

    //         if ($amount_dag != $finalamount){

    //             $premiumdata=array(
    //                 'case_no'=>$case_no,
    //                 'user_code'=>$this->session->userdata('user_code'),
    //                 // 'uuid'=>$premdags->uuid,
    //                 'dag_no'=>$premData->dag_no,
    //                 'zonal_valuation'=>$premData->zonal_valuation,
    //                 'area_name'=>$premData->area_name,
    //                 'land_type'=>$premData->land_type,
    //                 'rate_type'=>$premData->rate_type,
    //                 'rate'=>$premData->rate,
    //                 'concession'=>$premData->concession,
    //                 'amount_dag'=>$finalamount,
    //                 'final_amount'=>null,
    //                 'due_amount'=>null,
    //                 'total_lessa'=>$prem_area,
    //                 'is_full_pay'=>$premData->is_full_pay,
    //                 'is_final'=>1,
    //                 'date_entry'=>date('Y-m-d h:i:s'),
    //                 'approve_by'=>$premData->approve_by,
    //             );

    //             $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
    //             if ($reInsPremium != 1) {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
    //                 return array('status'=>1,'message'=>'#ERRSET000102: Something went wrong Case No '.$case_no);
    //             }

    //             $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
    //             $updatePrem = $this->db->query($sqlprem);

    //             if ($this->db->affected_rows() == 0)
    //             {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No '.$case_no);
    //                 return array('status'=>1,'message'=>'#ERRSET900311: Something went wrong Case No  '.$case_no);
    //             }

    //         }



    //     }

    //     if ($due_amount != $sumMbAmount){

    //         $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
    //         $updatePremium = $this->db->query($sqlPremUpdate);

    //         if ($this->db->affected_rows() == 0)
    //         {
    //             $this->db->trans_rollback();
    //             log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No '.$case_no);
    //             return array('status'=>1,'message'=>'#ERRSET900316661: Something went wrong Case No..'.$case_no);
    //         }

    //     }




    // }

    public function premiumReCalculationTea($case_no)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if($dagsCheck->num_rows() > 0)
        {
            $dagCheck = $dagsCheck->result();
        }
        else
        {
            return array('status'=>1,'message'=>'#ERR1951: Dag not found..case no'.$case_no);
        }

        $basic = $this->NcServiceModel->getSettlementBasic($case_no);

        $sumMbAmount=0;
        $sumMbArea=0;
        $finalamount =0;
        $insertProceeding=0;
        foreach ($dagCheck as $premiumdags) {

            if(trim($premiumdags->is_urban) == 'Y')
            {
                return array('status'=>1,'message'=>'Urban flag found!'.$case_no);
            }

            $lastId ='';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if($findLastPremium->num_rows() > 0)
            {

                $newZonalValue = $this->utilityclass->getZonalValue($premiumdags->dist_code,$basic['uuid'],$premiumdags->dag_no);

                $premData = $findLastPremium->row();

                if($premData->zonal_valuation != $newZonalValue)
                {
                    $insertProceeding=1;
                }
                $lastId = $premData->pid;
                // $prem_zonal = $premData->zonal_valuation;
                $prem_zonal = $newZonalValue;
                $prem_rate =  $premData->rate;
                $concession_rate=25;
                $prem_area = $premData->total_lessa;
                $area_name = $premData->area_name;
                $rate_type = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
            }
            else
            {

                return array('status'=>1,'message'=>'Last premium not available for cases...Case no.'.$case_no);
            }

            if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY)))
            {
                $area_in_bigha=6400;
            }
            else
            {
                $area_in_bigha=100;
            }

            $get_settlement_basic = $this->NcServiceModel->getSettlementBasicCo($case_no);

            if(trim($get_settlement_basic->cult_board) == 'TEA')
            {
                //****Rs. 1000 per bigha till 30 bigha and rest zonalvalue */
                $zonalValuePerLessa = $prem_zonal/$area_in_bigha;
                $amountPerLessa = 1000/$area_in_bigha;

                if($prem_area <= 3000)
                {
                    $finalamount = $prem_area * $amountPerLessa;
                }
                else
                {
                    $excessAmount = ($prem_area - 3000) * $zonalValuePerLessa;
                    $thirtyAmount = 3000 * $amountPerLessa;
                    $finalamount = $excessAmount + $thirtyAmount;
                }
            }
            else
            {
                //****30% of zonal value till 30 bigha and rest zonalvalue */
                $zonalValuePerLessa = $prem_zonal/$area_in_bigha;
                $thirtyPercentOfZonalValue = 30/100 * $zonalValuePerLessa;

                if($prem_area <= 3000)
                {
                    $finalamount = $prem_area * $thirtyPercentOfZonalValue;
                }
                else
                {
                    $excessAmount = ($prem_area - 3000) * $zonalValuePerLessa;
                    $thirtyAmount = 3000 * $thirtyPercentOfZonalValue;
                    $finalamount = $excessAmount + $thirtyAmount;
                }
            }

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if ($amount_dag != $finalamount){
                $premiumdata=array(
                    'case_no'=>$case_no,
                    'user_code'=>$this->session->userdata('user_code'),
                    // 'uuid'=>$premdags->uuid,
                    'dag_no'=>$premData->dag_no,
                    // 'zonal_valuation'=>$premData->zonal_valuation,
                    'zonal_valuation'=>$newZonalValue,
                    'area_name'=>$premData->area_name,
                    'land_type'=>$premData->land_type,
                    'rate_type'=>$premData->rate_type,
                    'rate'=>$premData->rate,
                    'concession'=>$premData->concession,
                    'amount_dag'=>$finalamount,
                    'final_amount'=>null,
                    'due_amount'=>null,
                    'total_lessa'=>$prem_area,
                    'is_full_pay'=>$premData->is_full_pay,
                    'is_final'=>1,
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'approve_by'=>$premData->approve_by,
                );

                $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                if ($reInsPremium != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET000102: Something went wrong Case No '.$case_no);
                }

                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                $updatePrem = $this->db->query($sqlprem);

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET900311: Something went wrong Case No  '.$case_no);
                }
            }
        }

        if ($due_amount != $sumMbAmount)
        {
            $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
            $updatePremium = $this->db->query($sqlPremUpdate);

            if ($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No '.$case_no);
                return array('status'=>1,'message'=>'#ERRSET900316661: Something went wrong Case No..'.$case_no);
            }

            if($insertProceeding==1)
            {
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
                    'note_on_order' => 'Premium updated due to zonal value change',
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated',
                    'note_type' => 'Premium updated due to zonal value change',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status'=>1,'message'=>'#ERRORPP333: Failed to forward the case for Case No : '.$case_no);
                }
                //////proceeding end//////
            }

            return array('status'=>2,'message'=>'Successfully updated...');
        }
        else
        {
            return array('status'=>2,'message'=>'No changes found...');
        }


    }

    public function finalAreaCheck($case_no)
    {
        //***get settlement_basic data  */
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if($getBasicSql->num_rows() <= 0)
        {
            log_message('error', '#ERR1776: No case found in settlement_basic ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1776: Case number not found! ->'.$case_no
            );
        }

        $getDagDetailsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if($getDagDetailsSql->num_rows() <= 0)
        {
            log_message('error', '#ERR1777: No case found in settlement_dag_details ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1777: Case number not found! ->'.$case_no
            );
        }

        $dagResult = $getDagDetailsSql->result();

        $total_lessa = 0;
        $total_s_dag_area_lessa = 0;
        $total_reservation_lessa = 0;
        $total_premium_lessa = 0;
        $total_chitha_lessa = 0;

        foreach($dagResult as $dagRow)
        {
            //****check if chitha_area exceeds */
            //******if AP NR case than consider the new dag */
            if($getBasicSql->row()->service_code == '14')
            {
                if($dagRow->new_dag_no != null || !$dagRow->new_dag_no || $dagRow->new_dag_no != '')
                {
                    //****new dag_no for NR */
                    $new_dag_no = $dagRow->new_dag_no;

                    if(trim($new_dag_no))
                    {
                        $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->new_dag_no));
                    }
                    else
                    {
                        $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                    }
                }
                else
                {
                    $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                }
            }
            else
            {
                $getChithaAreaSql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
            }

            if($getChithaAreaSql->num_rows() <= 0)
            {
                log_message('error', '#ERR1797: No dag found in chitha_basic ->'.$case_no);
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1797: No dag found in chitha! '.$case_no
                );
            }

            $chithaRow = $getChithaAreaSql->row();

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY)))
            {
                //******getting the home + agri area */
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $total_home_lessa = $this->utilityclass->Total_ganda($home_b, $home_k, $home_lc, $home_g);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $total_agri_lessa = $this->utilityclass->Total_ganda($agri_b, $agri_k, $agri_lc, $agri_g);

                //****getting the s_dag_area */
                $s_dag_area_b = $dagRow->s_dag_area_b;
                $s_dag_area_k = $dagRow->s_dag_area_k;
                $s_dag_area_lc = $dagRow->s_dag_area_lc;
                $s_dag_area_g = $dagRow->s_dag_area_g;
                $s_dag_area_lessa = $this->utilityclass->Total_ganda($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc, $s_dag_area_g);

                //***getting chitha_lessa */
                $chita_b = $chithaRow->dag_area_b;
                $chita_k = $chithaRow->dag_area_k;
                $chita_lc = $chithaRow->dag_area_lc;
                $chita_g = $chithaRow->dag_area_g;
                $chitha_lessa = $this->utilityclass->Total_ganda($chita_b, $chita_k, $chita_lc, $chita_g);

            }
            else
            {
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $total_home_lessa = $this->utilityclass->Total_Lessa($home_b, $home_k, $home_lc);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $total_agri_lessa = $this->utilityclass->Total_Lessa($agri_b, $agri_k, $agri_lc);

                //****getting the s_dag_area */
                $s_dag_area_b = $dagRow->s_dag_area_b;
                $s_dag_area_k = $dagRow->s_dag_area_k;
                $s_dag_area_lc = $dagRow->s_dag_area_lc;
                $s_dag_area_lessa = $this->utilityclass->Total_Lessa($s_dag_area_b, $s_dag_area_k, $s_dag_area_lc);

                //***getting chitha_lessa */
                $chita_b = $chithaRow->dag_area_b;
                $chita_k = $chithaRow->dag_area_k;
                $chita_lc = $chithaRow->dag_area_lc;
                $chitha_lessa = $this->utilityclass->Total_Lessa($chita_b, $chita_k, $chita_lc);
            }

            $total_lessa += $total_home_lessa + $total_agri_lessa;
            $total_s_dag_area_lessa += $s_dag_area_lessa;
            $total_chitha_lessa += $chitha_lessa;
        }

        if($total_lessa != $total_s_dag_area_lessa)
        {
            log_message('error', '#ERR1840: s_dag_area and (agri+home) area mis-match ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1840: Something went wrong! Contact Admin...'
            );
        }

        //****check if area exceeds more than chitha area */
        if($total_lessa > $total_chitha_lessa)
        {
            log_message('error', '#ERR1878: Applied area exceeds more than chitha area ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1878: Applied area exceeds more than chitha area '.$case_no
            );
        }

        //*****getting the nr for AP cases */
        if($getBasicSql->row()->service_code == '14')
        {
            $total_nr_lessa = 0;

            foreach($dagResult as $dagRowNr)
            {
                if (in_array($dagRowNr->dist_code, json_decode(BARAK_VALLEY)))
                {
                    $nr_bigha = $dagRowNr->nr_bigha;
                    $nr_katha = $dagRowNr->nr_katha;
                    $nr_lessa = $dagRowNr->nr_lessa;
                    $nr_ganda = $dagRowNr->nr_ganda;
                    $nr_in_lessa = $this->utilityclass->Total_ganda($nr_bigha, $nr_katha, $nr_lessa, $nr_ganda);

                }
                else
                {
                    $nr_bigha = $dagRowNr->nr_bigha;
                    $nr_katha = $dagRowNr->nr_katha;
                    $nr_lessa = $dagRowNr->nr_lessa;
                    $nr_in_lessa = $this->utilityclass->Total_Lessa($nr_bigha, $nr_katha, $nr_lessa);
                }

                $total_nr_lessa += $nr_in_lessa;
            }

            if($total_nr_lessa < $total_lessa)
            {
                log_message('error', '#ERR1927: Settlement area bigger than NR area ->'.$case_no);
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1927: Please check the NR and settlement area, settlement area should be less than NR area! '.$case_no
                );
            }
        }

        //********calculating the roadside reservation if available */
        $getReservationSql = $this->db->query('select * from settlement_reservation where case_no = ? and is_deleted = ? and type = ?', array($case_no, '0', 'R'));

        if($getReservationSql->num_rows() > 0)
        {
            $reservationResult = $getReservationSql->result();

            foreach($reservationResult as $reservationRow)
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

                $total_reservation_lessa +=  $reservation_in_lessa;
            }
        }

        //******deducting the roadside reservation area */
        if($total_reservation_lessa != 0)
        {
            $total_lessa = $total_lessa - $total_reservation_lessa;
        }

        $getPremiumSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no, '1'));

        if($getPremiumSql->num_rows() <= 0)
        {
            log_message('error', '#ERR1851: No data found in settlement_premium table ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1851: Premium calculation not available, Please re-calculate the premium! '.$case_no
            );
        }

        $premiumResult = $getPremiumSql->result();

        foreach($premiumResult as $premiumRow)
        {
            $total_premium_lessa += $premiumRow->total_lessa;
        }

        if($total_lessa != $total_premium_lessa)
        {
            log_message('error', '#ERR1869: settlement_dag_details and settlement_premium area mis-match ->'.$case_no);
            return array(
                'responseType' => 0,
                'msg' => '#ERR1869: Something went wrong! Contact Admin...'
            );
        }

        //****if no issues then return success */
        return array(
            'responseType' => 2,
            'msg' => 'Success'
        );

    }


    // case Under Dept Or DC By WetLand for DC
    public function caseUnderDeptOrDCByWetLand($case_no)
    {
        $data = array();
        $wetLand = 0;
        $sql = $this->db->query('select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,
                    (select wet_land from chitha_dag_all_flag_details_final  where
                     dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code 
                     and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no) 
                    from settlement_dag_details s 
                     where case_no = ?',array($case_no));

        $data = $sql->result();

        if(!empty($data))
        {
            if(in_array(6, array_column($data, 'wet_land')))
            {
                $wetLand = 1;
            }
        }

        return $wetLand;
    }

    public function wetlandUpdateSettlementToDo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $getBasicSql = $this->db->query('select * from settlement_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ? and status not in (\'M\', \'N\', \'D\') and pull_request != ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, 1));

        if($getBasicSql->num_rows() > 0)
        {
            $basicCasesRes = $getBasicSql->result();

            foreach($basicCasesRes as $basicRow)
            {
                $this->wetlandUpdateToDoByCase($basicRow->case_no);
            }
        }
        else
        {
            return json_encode([
                'responseType'  => 2,
                'msg'           => 'No data found in settlement to update.'
            ]);
        }
    }


    public function wetlandUpdateToDoByCase($case_no)
    {
        $this->db->trans_begin();

        $getCaseApprovedBySql = $this->db->query('select * from settlement_premium a join settlement_premium_rate b on a.rate_type = b.prid where a.case_no = ? and a.is_final = ?', array($case_no, 1));

        if($getCaseApprovedBySql->num_rows() > 0)
        {
            $new_wet_land = $this->caseUnderDeptOrDCByWetLand($case_no);

            if($new_wet_land == 1)
            {
                $approvedBY = 'GOVT';
            }
            else
            {
                $premApprovRes = $getCaseApprovedBySql->result();

                foreach($premApprovRes as $premApprov)
                {
                    if($premApprov->approval == null || $premApprov->approval == '' || empty($premApprov->approval))
                    {
                        $getDag = $this->db->query('select * from settlement_dag_details where case_no = ? and dag_no = ?', array($premApprov->case_no, $premApprov->dag_no));

                        $apLmnote = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($premApprov->case_no));

                        if($getDag->num_rows() <= 0)
                        {
                            //****error */
                            $this->db->trans_rollback();
                            return json_encode([
                                'responseType'  => 0,
                                'msg'           => '#ERR2088: Data not found in Dag!'
                            ]);
                        }

                        if($apLmnote->num_rows() <= 0)
                        {
                            //****error */
                            $this->db->trans_rollback();
                            return json_encode([
                                'responseType'  => 0,
                                'msg'           => '#ERR2098: Data not found in LM report!'
                            ]);
                        }

                        $dag = $getDag->row();
                        $lmNote = $apLmnote->row();

                        if(strtoupper($dag->is_urban) == 'Y' || (strtoupper($dag->is_urban) == 'N' && strtoupper($lmNote->falls_und_gmc) == YES))
                        {
                            $approvedBY = 'GOVT'; //dpt
                        }

                        if($dag->is_urban == 'N' && $lmNote->falls_und_gmc != YES)
                        {
                            $approvedBY = 'DC'; // dc
                        }
                    }
                    else if($premApprov->approval != null || $premApprov->approval != '' || !empty($premApprov->approval))
                    {
                        $approvedBYArray[] = $premApprov->approval;
                        if(in_array('GOVT', $approvedBYArray))
                        {
                            $approvedBY = 'GOVT';
                        }
                        else
                        {
                            $approvedBY = 'DC';
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType'  => 0,
                            'msg'           => '#ERR2131: Something went wrong!'
                        ]);
                    }
                }
            }
        }
        else
        {
            $approvedBY = null;
            $new_wet_land = 0;
        }


        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if($getBasicSql->num_rows() <= 0)
        {
            $this->db->trans_rollback();
            return json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR2346: Unable to update wetland flag!'
            ]);
        }

        $basicRow = $getBasicSql->row();

        if($basicRow->approve_by != $approvedBY || $basicRow->is_wed_land != $new_wet_land)
        {
            $updateBasicArr = [
                'approve_by' => $approvedBY,
                'is_wed_land' => $new_wet_land,
            ];

            $this->db->where('case_no' , $case_no);
            $this->db->update('settlement_basic', $updateBasicArr);

            if($this->db->affected_rows() != 1)
            {
                //******show error update to update */
                $this->db->trans_rollback();
                return json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR2098: Unable to update wetland flag!'
                ]);
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

            if ($proceeding_id == null)
            {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => 'Chitha dag flag updated',
                'note_on_order' => 'Updated due to chitha flag updation for the dag',
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => $this->session->userdata('user_desig_code'),
                'office_to' => $this->session->userdata('user_desig_code'),
                'task' => 'Chitha dag flag updated',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);

            if ($insertProc != 1)
            {
                $this->db->trans_rollback();
                return json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR2177: Unable to update wetland flag!'
                ]);
            }

            $this->db->trans_commit();
        }

        return json_encode([
            'responseType'  => 2,
            'msg'           => 'Successfully updated...'
        ]);


    }


    public function premiumReCalculateInsert($case_no,$concession)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if($dagsCheck->num_rows() > 0)
        {
            $dagCheck = $dagsCheck->result();
        }
        else
        {
            return array('status'=>1,'message'=>'Dag not found..case no'.$case_no);
        }

        $basic = $this->NcServiceModel->getSettlementBasic($case_no);


        $sumMbAmount=0;
        $sumMbArea=0;
        $finalamount =0;
        foreach ($dagCheck as $premiumdags) {

            $lastId ='';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if($findLastPremium->num_rows() > 0)
            {
                //newly add value-----------
                // $sqlForZonalValue = $this->db->query("select dag_no,zone_id,subclass_id,
                // (select MAX(land_rate) as new_zonal_value from villagewise_zone_info where
                //     unique_village_code = dzi.unique_village_code and zone_code::varchar=dzi.zone_id and subclass_name like 'Residential%' )
                //             from dagwise_zone_info dzi where dzi.unique_village_code = '$basic[uuid]' and dzi.dag_no='$premiumdags->dag_no'");

                // log_message('error',"----------Zonal Value Query-------".$this->db->last_query());
                // $newZonalRow = $sqlForZonalValue->row();  
                // //get zonal value from max land_rate from settlement -----------
                // $premium_per_bigha = $newZonalRow->new_zonal_value;

                $premData = $findLastPremium->row();
                $lastId = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate =  $premData->rate;
                $concession_rate=25;
                $prem_area = $premData->total_lessa;
                $area_name = $premData->area_name;
                $rate_type = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
            }
            else
            {

                return array('status'=>1,'message'=>'Last premium not available for cases...Case no.'.$case_no);
            }

            $oldArea = array(1,2,3,4,5,6);

            $oldRupeesArea = array(7,8,9,10);

            $isRural=0;

            if(in_array($area_name, $oldArea))
            {


                $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code,$premiumdags->subdiv_code,$premiumdags->cir_code,$premiumdags->mouza_pargona_code,$premiumdags->lot_no,$premiumdags->vill_townprt_code,$premiumdags->dag_no);

                if($area_name == false)
                {
                    return array('status'=>1,'message'=>'New dag area flag not found!...Case no.'.$case_no);
                }

                if($prem_rate == 10){
                    $findrate=10;
                }elseif($prem_rate == 30){
                    $findrate=30;
                }elseif($prem_rate == 100){
                    $findrate=100;
                }

                if(!in_array($area_name, $oldRupeesArea))
                {
                    $getPrid = $this->db->query("SELECT prid FROM settlement_premium_rate WHERE paid = ? and rate= ?", array($area_name,$findrate));


                    if($getPrid->num_rows() <= 0)
                    {
                        return array('status'=>1,'message'=>'#ERR254144: Something went wrong!'.$case_no);
                    }

                    $prid = $getPrid->row()->prid;


                    $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($prid));

                    $rate_type = $prid;

                }else{
                    $isRural=1;
                }


            }
            else
            {
                $findLastArea = $this->db->query("SELECT mb_land,max_land FROM settlement_premium_rate WHERE prid = ?", array($rate_type));
            }

            if($isRural!=1)
            {
                if($findLastArea->num_rows() > 0)
                {
                    $premArea = $findLastArea->row();
                }
                else
                {
                    return array('status'=>1,'message'=>'Max area not available for case no...'.$case_no);
                }

                $mb_land = $premArea->mb_land;
                $max_land = $premArea->max_land!=null? $premArea->max_land:0;
                if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))){

                    if($mb_land == 25){
                        $mb_land=1600;
                    }else if ($mb_land == 30){
                        $mb_land=1920;
                    }else if ($mb_land == 40){
                        $mb_land=2560;
                    }

                }
            }



            if (in_array($premiumdags->dist_code, json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;

            }else{
                $area_in_bigha=100;
            }


            $premPercentage = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
            $premRupees = array(7,8,9,10,18,19,20,21,22);


            // if(in_array($area_name, $oldArea)){
            //     // return array('status'=>3,'message'=>'Old area flag found for this dag, case no: '.$case_no);


            // }

            if($isRural!=1 && $concession != 'NO')
            {

                if(in_array($area_name, $premRupees)){
                    return array('status'=>1,'message'=>null);
                }
            }

            if ($concession=="YES"){
                if (in_array($area_name, $premPercentage)){
                    if($prem_area>$mb_land){
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount1 = ceil($premium * $discount / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal*1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);
                    }else{
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                        $amount = ($premium * $discount / 100);
                        // $finalamount = round($amount,2);
                        $finalamount = ceil($amount);
                    }

                }
                else if(in_array($area_name, $premRupees)){
                    $prem_rate=100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $discount = $prem_rate - $concession_rate;
                    $amount = ($premium * $discount / 100);
                    $finalamount = ceil($amount);
                }

            }else if($concession=="NO"){

                if (in_array($area_name, $premPercentage)){
                    if($prem_area>$mb_land){
                        $premium = $mb_land * $prem_zonal / $area_in_bigha;
                        $amount1 = ceil($premium * $prem_rate / 100);

                        $access_area = $prem_area - $mb_land;
                        $premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                        $amount2 = ceil($premium2);

                        $finalamount = ceil($amount1 + $amount2);

                    }else{
                        $premium = $prem_area * $prem_zonal / $area_in_bigha;
                        $amount = ($premium * $prem_rate / 100);
                        $finalamount = ceil($amount);
                    }
                }
                else if(in_array($area_name, $premRupees)){
                    $prem_rate=100;
                    $premium = $prem_area * $prem_rate / $area_in_bigha;
                    $amount = ($premium * $prem_rate / 100);
                    $finalamount = ceil($amount);
                }
            }



            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (($amount_dag != $finalamount) || ($area_name != $premData->area_name) || $concession == 'NO'){

                $premiumdata=array(
                    'case_no'=>$case_no,
                    'user_code'=>$this->session->userdata('user_code'),
                    // 'uuid'=>$premdags->uuid,
                    'dag_no'=>$premData->dag_no,
                    'zonal_valuation'=>$premData->zonal_valuation,
                    'area_name'=>$area_name,
                    'land_type'=>$premData->land_type,
                    'rate_type'=>$rate_type,
                    'rate'=>$prem_rate,
                    'concession'=>$concession,
                    'amount_dag'=>$finalamount,
                    'final_amount'=>null,
                    'due_amount'=>null,
                    'total_lessa'=>$prem_area,
                    'is_full_pay'=>$premData->is_full_pay,
                    'is_final'=>1,
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'approve_by'=>$premData->approve_by,
                    'zone_code'=>$premData->zone_code,
                    'subclass_code'=>$premData->subclass_code,
                    'old_zonal_valuation'=>$premData->old_zonal_valuation
                );

                $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                if ($reInsPremium != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET000102: Something went wrong Case No '.$case_no);
                }

                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                $updatePrem = $this->db->query($sqlprem);

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900311: Updation failed in settlement_premium RTPS Case No '.$case_no);
                    return array('status'=>1,'message'=>'#ERRSET900311: Something went wrong Case No  '.$case_no);
                }

            }



        }

        if($max_land!=0 && $sumMbArea>$max_land)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET98703161: Max area exceed RTPS Case No '.$case_no);
            return array('status'=>1,'message'=>'#ERRSET98703161: Max area exceed.. Case No  '.$case_no);
        }

        if (($due_amount != $sumMbAmount) || ($area_name != $premData->area_name) || $concession == 'NO'){

            $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
            $updatePremium = $this->db->query($sqlPremUpdate);

            if ($this->db->affected_rows() == 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No '.$case_no);
                return array('status'=>1,'message'=>'#ERRSET900316661: Something went wrong Case No..'.$case_no);
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
                'note_on_order' => 'Premium updated due to wrong caste selection',
                'status' => 'M',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Premium updated',
                'note_type' => 'Premium updated due to wrong caste selection',
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP45333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                return array('status'=>1,'message'=>'#ERRORPP45333: Failed to forward the case for Case No : '.$case_no);
            }
            //////proceeding end//////
            return array('status'=>2,'message'=>'Premium successfully updated!');

        }
        else
        {
            return array('status'=>1,'message'=>'#ERRORPP45465: Something went wrong! Unable to process...');
        }

    }

    public function getChithaDagAreaDetailsByDagNo($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
            ->get('chitha_basic')
            ->row();
    }
    public function countSettlementApplicationByCaseNoInSdlacProList($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('nc', 1)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNoModification($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('nc', 1)
            ->get('settlement_proposal_cases')
            ->row();
    }

    // delete proposal case details
    public function deleteSettlementProposalCaseDetailsById($id)
    {
        $this->db->where('id', $id);
        $this->db->where('nc', 1);
        $this->db->delete('settlement_proposal_cases');
        return $this->db->trans_status();
    }

    // get  application id by case no
    public function getSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();

    }

    // count  application id by case no
    public function countSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->num_rows();
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

    // get all settlement dag
    public function getAppliedSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }

    // get basic details with case no
    public function getSettlementBasicData($case_no){
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    // get chitha dag details
    public function getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
            //            ->where('patta_type_code',$appPattaType)
            //            ->where('patta_no',$appPatta)
            ->get('chitha_basic')
            ->row();
    }

    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        //  $this->db->select('settlement_dag_details.*,settlement_basic.status');
        //  $this->db->from('settlement_dag_details');
        //  $this->db->join('settlement_basic','settlement_basic.case_no = settlement_dag_details.case_no');
        //  $this->db->where('settlement_basic.status !=','D');
        //  $this->db->where('settlement_basic.status !=','F');
        //  $this->db->where('settlement_basic.dc_proceeding',1);
        //  $this->db->where('settlement_dag_details.dist_code',$appDistrict);
        //  $this->db->where('settlement_dag_details.subdiv_code',$appSubDiv);
        //  $this->db->where('settlement_dag_details.cir_code',$appCircle);
        //  $this->db->where('settlement_dag_details.mouza_pargona_code',$appMouza);
        //  $this->db->where('settlement_dag_details.lot_no',$appLot);
        //  $this->db->where('settlement_dag_details.vill_townprt_code',$appVillage);
        //  $this->db->where('settlement_dag_details.dag_no',$appDag);
        //  $this->db->where('settlement_dag_details.patta_type_code',$appPattaType);
        //  $this->db->where('settlement_dag_details.patta_no',$appPatta);
        //  $applications = $this->db->get();


        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
        FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
        and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
        and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
        JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
        mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
        and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=1) settlement_basic
        ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }

    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationNotSubmit($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {
        //  $this->db->select('settlement_dag_details.*,settlement_basic.status');
        //  $this->db->from('settlement_dag_details');
        //  $this->db->join('settlement_basic','settlement_basic.case_no = settlement_dag_details.case_no');
        //  $this->db->where('settlement_basic.status !=','D');
        //  $this->db->where('settlement_basic.status !=','F');
        //  $this->db->where('settlement_basic.case_no !=',$application_no);
        //  $this->db->where('settlement_basic.dc_proceeding',0);
        //  $this->db->where('settlement_dag_details.dist_code',$appDistrict);
        //  $this->db->where('settlement_dag_details.subdiv_code',$appSubDiv);
        //  $this->db->where('settlement_dag_details.cir_code',$appCircle);
        //  $this->db->where('settlement_dag_details.mouza_pargona_code',$appMouza);
        //  $this->db->where('settlement_dag_details.lot_no',$appLot);
        //  $this->db->where('settlement_dag_details.vill_townprt_code',$appVillage);
        //  $this->db->where('settlement_dag_details.dag_no',$appDag);
        //  $this->db->where('settlement_dag_details.patta_type_code',$appPattaType);
        //  $this->db->where('settlement_dag_details.patta_no',$appPatta);
        //  $applications = $this->db->get();

        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
        FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
        and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
        and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
        JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
        mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
        and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=0) settlement_basic
        ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }

    function paymentConfirmation($basundhara){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."paymentStatus");
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
    function checkRtpsService($case){
        $sql="SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
        $dataFound=$this->db->query($sql, $case)->row();
        if($dataFound){
            $data = $dataFound->basundhara;
            $var = explode('/', $data);
            $service = $var['0'];
        }else{
            $service = null;
        }
        return $service;
    }

    public function getChithaUpdateDetails($case_no)
    {

        $getBasic = $this->db->query('select * from settlement_basic where case_no = ? and chitha_processing_details = ?', array($case_no, 2));

        if($getBasic->num_rows() <= 0)
        {
            return array(
                'responseType'      => 0,
                'msg'               => '#ERR3606: Chitha verification data not approved by CO!'
            );
        }

        $getDags = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if($getDags->num_rows() <= 0)
        {
            return array(
                'responseType'      => 0,
                'msg'               => '#ERR3606: Dag detail not found!'
            );
        }

        $basicRow = $getBasic->row();
        $dagResult = $getDags->result();

        $dagNewCount = 0;

        foreach($dagResult as $dagRow)
        {
            //***getting the area from premium table  */
            $getPremium = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ? and grn_no is not null', array($case_no, 1, $dagRow->dag_no));

            if($getPremium->num_rows() <= 0)
            {
                return array(
                    'responseType'      => 0,
                    'msg'               => '#ERR3596: Premium data not found!'
                );
            }

            //****getting the reservation */
            $getReservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and is_deleted = ? and dag_no = ?', array($case_no, 'R', 0, $dagRow->dag_no));

            if($getReservation->num_rows() > 0)
            {
                $reservationRow = $getReservation->row();

                $is_reservation = 1;

                $reservation_bigha = $reservationRow->bigha;
                $reservation_katha = $reservationRow->katha;
                $reservation_lessa = $reservationRow->lessa;
                $reservation_ganda = $reservationRow->ganda;

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
            }
            else
            {
                $is_reservation = 0;

                $reservation_bigha = 0;
                $reservation_katha = 0;
                $reservation_lessa = 0;
                $reservation_ganda = 0;

                $reservation_in_lessa = 0;
            }

            //****premium row */
            $premiumRow = $getPremium->row();

            $is_fully_paid = 0;
            if($premiumRow->paid_amount >= $premiumRow->final_amount)
            {
                $is_fully_paid = 1;
            }

            $urbanArray = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
            $ruralArray = array(7,8,9,10,18,19,20,21,22);

            $is_urban = 0;
            if(in_array($premiumRow->area_name, $urbanArray))
            {
                $is_urban = 1;
            }

            //****biforcating the area for home and agriculture */

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY)))
            {
                //******getting the home + agri area */
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $total_home_lessa = $this->utilityclass->Total_ganda($home_b, $home_k, $home_lc, $home_g);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $total_agri_lessa = $this->utilityclass->Total_ganda($agri_b, $agri_k, $agri_lc, $agri_g);
            }
            else
            {
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $total_home_lessa = $this->utilityclass->Total_Lessa($home_b, $home_k, $home_lc);

                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $total_agri_lessa = $this->utilityclass->Total_Lessa($agri_b, $agri_k, $agri_lc);
            }

            $ratio_home = floor($total_home_lessa / ($total_home_lessa + $total_agri_lessa) * $reservation_in_lessa);
            $ratio_agri = ceil($total_agri_lessa / ($total_home_lessa + $total_agri_lessa) * $reservation_in_lessa);

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY)))
            {
                $roadSideReservationBKL_home = $this->utilityclass->Total_Bigha_Katha_Lessa2($ratio_home);
                $roadSideReservationBKL_agri = $this->utilityclass->Total_Bigha_Katha_Lessa2($ratio_agri);
            }
            else
            {
                $roadSideReservationBKL_home = $this->utilityclass->Total_Bigha_Katha_Lessa($ratio_home);
                $roadSideReservationBKL_agri = $this->utilityclass->Total_Bigha_Katha_Lessa($ratio_agri);
            }


            $final_home_area = $total_home_lessa - $ratio_home;
            $final_agri_area = $total_agri_lessa - $ratio_agri;

            if($final_home_area > 0)
            {
                $landType = 1;
            }

            if($final_agri_area > 0)
            {
                $landType = 2;
            }

            if($final_home_area > 0 && $final_agri_area > 0)
            {
                $landType = 3;
            }


            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY)))
            {
                $homeBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_home_area);
                $agriBKL = $this->utilityclass->Total_Bigha_Katha_Lessa2($final_agri_area);
            }
            else
            {
                $homeBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($final_home_area);
                $agriBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($final_agri_area);
            }

            if (in_array($dagRow->dist_code, json_decode(BARAK_VALLEY)))
            {
                if($basicRow->service_code == '14')
                {
                    $chithaSql = $this->db->query('select sum((dag_area_b*6400) + (dag_area_k*320) + (dag_area_lc*20) + dag_area_g) as total_chitha_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->new_dag_no));
                }
                else
                {
                    $chithaSql = $this->db->query('select sum((dag_area_b*6400) + (dag_area_k*320) + (dag_area_lc*20) + dag_area_g) as total_chitha_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                }
            }
            else
            {
                if($basicRow->service_code == '14')
                {
                    $chithaSql = $this->db->query('select sum((dag_area_b*100) + (dag_area_k*20) + dag_area_lc) as total_chitha_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->new_dag_no));
                }
                else
                {
                    $chithaSql = $this->db->query('select sum((dag_area_b*100) + (dag_area_k*20) + dag_area_lc) as total_chitha_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no));
                }

            }

            if($chithaSql->num_rows() <= 0)
            {
                return array(
                    'responseType'      => 0,
                    'msg'               => '#ERR3752: Something went wrong! Unable to process'
                );
            }

            $chitha_lessa = $chithaSql->row()->total_chitha_lessa;

            if($basicRow->service_code == '14')
            {
                $isApAreaExceed = 0;
            }
            else
            {
                $isApAreaExceed = null;
                $exccedApAreaInLessa = null;
            }

            if($chitha_lessa == ($final_home_area+$final_agri_area))
            {
                $is_full_dag = 1;

                if($landType == 3)
                {
                    if($landType == 1 || $landType == 3)
                    {
                        if($basicRow->service_code == '14')
                        {
                            $new_dag_no_home = $dagRow->new_dag_no;
                        }
                        else
                        {
                            $new_dag_no_home = $dagRow->dag_no;
                        }
                    }
                    else
                    {
                        $new_dag_no_home = null;
                    }

                    if($landType == 2 || $landType == 3)
                    {
                        $new_dag_no_agri = $this->utilityclass->maxdag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code) + $dagNewCount++;
                    }
                    else
                    {
                        $new_dag_no_agri = null;
                    }
                }
                else
                {
                    if($landType == 1 || $landType == 3)
                    {
                        $new_dag_no_home = $this->utilityclass->maxdag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code) + $dagNewCount++;
                    }
                    else
                    {
                        $new_dag_no_home = null;
                    }

                    if($landType == 2 || $landType == 3)
                    {
                        $new_dag_no_agri = $this->utilityclass->maxdag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code) + $dagNewCount++;
                    }
                    else
                    {
                        $new_dag_no_agri = null;
                    }
                }

            }
            elseif($chitha_lessa > ($final_home_area+$final_agri_area))
            {
                if($basicRow->service_code == '14')
                {
                    $isApAreaExceed = 1;
                    $exccedApAreaInLessa = $chitha_lessa - ($final_home_area+$final_agri_area);
                }
                else
                {
                    $isApAreaExceed = null;
                    $exccedApAreaInLessa = null;
                }
                $is_full_dag = 0; // new dag to be generated here 

                if($landType == 1 || $landType == 3)
                {
                    $new_dag_no_home = $this->utilityclass->maxdag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code) + $dagNewCount++;
                }
                else
                {
                    $new_dag_no_home = null;
                }

                if($landType == 2 || $landType == 3)
                {
                    $new_dag_no_agri = $this->utilityclass->maxdag($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code) + $dagNewCount++;
                }
                else
                {
                    $new_dag_no_agri = null;
                }
            }
            else
            {
                return array(
                    'responseType'      => 0,
                    'msg'               => '#ERR3770: Something went wrong! Unable to process'
                );
            }

            //******getting the new patta no */
            $new_patta_no = $this->utilityclass->maxpatta($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->new_patta_type);

            //*******homestead */
            if($landType == 1 || $landType == 3)
            {
                $home_details = array(
                    'old_dag_no'                        => $dagRow->dag_no,
                    'new_dag_no'                        => $new_dag_no_home,
                    // 'new_dag_no'                        => $new_dag_no_agri,
                    'landmark'                          => $dagRow->landmark,
                    'landmark_with_code'                => $dagRow->landmark_with_code,
                    'new_patta_type'                    => $dagRow->new_patta_type,
                    'new_patta_no'                      => $new_patta_no,
                    'new_land_class'                    => $dagRow->new_land_class_home,
                    'possession_from'                   => $dagRow->new_possession,
                    'new_land_revenue'                  => $dagRow->new_home_land_revenue,
                    'new_land_local_tax'                => $dagRow->new_home_land_local_tax,
                    'grn_no'                            => $premiumRow->grn_no,
                    'dept_order_no'                     => $basicRow->dept_order_no,
                    'dept_order_date'                   => $basicRow->dept_order_date,
                    'final_premium_amount'              => $premiumRow->final_amount,
                    'paid_amount'                       => $premiumRow->paid_amount,
                    'is_fully_paid'                     => $is_fully_paid,
                    'payment_date'                      => $premiumRow->payment_date,
                    'is_urban'                          => $is_urban,
                    'is_reservation'                    => $is_reservation,
                    'is_full_dag'                       => $is_full_dag,
                    'settlement_bigha'                  => $homeBKL[0],
                    'settlement_katha'                  => $homeBKL[1],
                    'settlement_lessa'                  => $homeBKL[2],
                    'settlement_ganda'                  => $homeBKL[3],
                    'road_side_reservation_bigha'       => $roadSideReservationBKL_home[0],
                    'road_side_reservation_katha'       => $roadSideReservationBKL_home[1],
                    'road_side_reservation_lessa'       => $roadSideReservationBKL_home[2],
                    'road_side_reservation_ganda'       => $roadSideReservationBKL_home[3],
                    'isApAreaExceed'                    => $isApAreaExceed,
                    'exccedApAreaInLessa'               => $exccedApAreaInLessa,
                );
            }
            else
            {
                $home_details = null;
            }

            //*****agriculture */
            if($landType == 2 || $landType == 3)
            {
                $agri_details = array(
                    'old_dag_no'                        => $dagRow->dag_no,
                    // 'new_dag_no'                        => $new_dag_no_agri,
                    'new_dag_no'                        => $new_dag_no_agri,
                    'landmark'                          => $dagRow->landmark,
                    'landmark_with_code'                => $dagRow->landmark_with_code,
                    'new_patta_type'                    => $dagRow->new_patta_type,
                    'new_patta_no'                      => $new_patta_no,
                    'new_land_class'                    => $dagRow->new_land_class_agri,
                    'possession_from'                   => $dagRow->new_possession,
                    'new_land_revenue'                  => $dagRow->new_agri_land_revenue,
                    'new_land_local_tax'                => $dagRow->new_agri_land_local_tax,
                    'grn_no'                            => $premiumRow->grn_no,
                    'dept_order_no'                     => $basicRow->dept_order_no,
                    'dept_order_date'                   => $basicRow->dept_order_date,
                    'final_premium_amount'              => $premiumRow->final_amount,
                    'paid_amount'                       => $premiumRow->paid_amount,
                    'is_fully_paid'                     => $is_fully_paid,
                    'payment_date'                      => $premiumRow->payment_date,
                    'is_urban'                          => $is_urban,
                    'is_reservation'                    => $is_reservation,
                    'is_full_dag'                       => $is_full_dag,
                    'settlement_bigha'                  => $agriBKL[0],
                    'settlement_katha'                  => $agriBKL[1],
                    'settlement_lessa'                  => $agriBKL[2],
                    'settlement_ganda'                  => $agriBKL[3],
                    'road_side_reservation_bigha'       => $roadSideReservationBKL_agri[0],
                    'road_side_reservation_katha'       => $roadSideReservationBKL_agri[1],
                    'road_side_reservation_lessa'       => $roadSideReservationBKL_agri[2],
                    'road_side_reservation_ganda'       => $roadSideReservationBKL_agri[3],
                    'isApAreaExceed'                    => $isApAreaExceed,
                    'exccedApAreaInLessa'               => $exccedApAreaInLessa,
                );
            }
            else
            {
                $agri_details = null;
            }

            $chitaUpdateDagArray[] = array(
                'land_type'             => $landType,
                'old_dag_no'            => $dagRow->dag_no,
                'homestead_details'     => $home_details,
                'agriculture_details'   => $agri_details,
                'new_total_revenue'     => $dagRow->new_total_revenue,
                'new_total_tax'         => $dagRow->new_total_tax,
            );
        }

        //*****applicant array */
        $sqlApplicant = $this->db->query('select * from settlement_applicant where case_no = ?', array($case_no));

        if($sqlApplicant->num_rows() <= 0)
        {
            return array(
                'responseType'      => 0,
                'msg'               => '#ERR3905: Something went wrong! Unable to process'
            );
        }
        $applicantResult = $sqlApplicant->result();

        foreach($applicantResult as $applicantRow)
        {
            if(in_array($applicantRow->pdar_type, ['B','O','EN']))
            {
                $applicantArray[] = array(
                    'is_applicant'             => $applicantRow->is_applicant,
                    'applicant_assamese_name'  => $applicantRow->pdar_name,
                    'applicant_english_name'   => $applicantRow->eng_pdar_name,
                    'guardian_assamese_name'   => $applicantRow->pdar_guardian,
                    'guardian_english_name'    => $applicantRow->eng_pdar_guardian,
                    'relation'                 => $applicantRow->pdar_rel_guar,
                    'identity_type'            => $applicantRow->identity_type,
                    'identity_ref_no'          => $applicantRow->identity_ref_no,
                    'caste'                    => $basicRow->caste,
                    'gender'                   => $applicantRow->pdar_gender,
                    'mobile'                   => $applicantRow->pdar_mobile,
                    'present_address'          => $applicantRow->pdar_add1,
                    'permanent_address'        => $applicantRow->pdar_add2,
                    'pdar_type'                => $applicantRow->pdar_type,
                    'inplace_alongwith'        => $applicantRow->inplace_alongwith,
                );
            }
        }

        return array(
            'responseType'      => 2,
            'service_code'      => $basicRow->service_code,
            'dagArray'          => $chitaUpdateDagArray,
            'applicantArray'    => $applicantArray,
        );
    }

    public function isEncNewlyAdded($case_no)
    {
        $applid = $this->utilityclass->getApplidFromCaseNo($case_no);
        return $this->db->query('select * from settlement_land_bank_details where application_no in (\'$case_no\',\'$applid\')');
    }

    function defaultValue($input, $value)
    {
        if (empty($input)) return $value;

        return $input;
    }


    // to get Area Details (Assamese B + K + L)
    public function getAreaDetails($district, $subdiv, $circle, $mouza, $lot, $village, $dag)
    {
        $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no, 
        patta_type_code from chitha_basic where dist_code=? and cir_code=? and 
        subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=? 
        and lot_no=? and dag_no=?", array($district,$circle,$subdiv,$village,$mouza,$lot,$dag));
        $object = $area->row();

        $totalArea = 0;

        if(in_array($district, json_decode(BARAK_VALLEY)))
        {
            $bigha = $this->defaultValue(trim($object->dag_area_b),0);
            $katha = $this->defaultValue(trim($object->dag_area_k),0);
            $lessa = $this->defaultValue(trim($object->dag_area_lc),0);
            $ganda = $this->defaultValue(trim($object->dag_area_g),0);
            $totalArea = ($bigha * 6400) + ($katha * 320)  + ($lessa * 20) + $ganda;
            return $totalArea;
        }
        else
        {
            $bigha = $this->defaultValue(trim($object->dag_area_b),0);
            $katha = $this->defaultValue(trim($object->dag_area_k),0);
            $lessa = $this->defaultValue(trim($object->dag_area_lc),0);
            $totalArea = ($bigha * 100) + ($katha * 20)  + $lessa;
            return $totalArea;

        }

    }



    // get dist name
    public function getDistrictNameByDistCode($distCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code','00')
            ->get('location')
            ->row();

    }
    // get dist name english
    public function getEngDistrictNameByDistCode($distCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code',$distCode)
            ->where('subdiv_code','00')
            ->get('location')
            ->row();

    }

    // get subdiv name english
    public function getEngSubdivNameByDistCode($distCode, $subdiv_code)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$subdiv_code)
            ->where('cir_code', '00')
            ->where('mouza_pargona_code', '00')
            ->where('vill_townprt_code', '00000')
            ->where('lot_no', '00')
            ->get('location')
            ->row();

    }

    // get subdivision details
    public function getSubDivisionDetailsByDist($distCode,$diviCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code','00')
            ->get('location')
            ->row();
    }


    // get circle details
    public function getCircleDetailsByDistDivision($distCode,$diviCode,$circleCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code','00')
            ->get('location')
            ->row();
    }


    // get mouza details
    public function getMouzaDetailsByDistDivisionCircle($distCode,$diviCode,$circleCode,$mouzaCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no','00')
            ->get('location')
            ->row();
    }


    // get lot details
    public function getLotDetailsNameByDistDivisionCircleMouza($distCode,$diviCode,$circleCode,$mouzaCode,$lotCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no',$lotCode)
            ->where('vill_townprt_code','00000')
            ->get('location')
            ->row();
    }


    // get village details
    public function getVillageDetailsNameByDistDivisionCircleMouzaLot($distCode,$diviCode,$circleCode,$mouzaCode,$lotCode,$vilCode)
    {
        return $this->db->select('loc_name')
            ->where('dist_code',$distCode)
            ->where('subdiv_code',$diviCode)
            ->where('cir_code',$circleCode)
            ->where('mouza_pargona_code',$mouzaCode)
            ->where('lot_no',$lotCode)
            ->where('vill_townprt_code',$vilCode)
            ->get('location')
            ->row();
    }


    // get user name dc
    public function getUserNameDc($distCode)
    {
        $this->db->select('users.username');
        $this->db->from('users');
        $this->db->join('loginuser_table','loginuser_table.user_code = users.user_code');
        $this->db->where('users.dist_code',$distCode );
        $this->db->where('loginuser_table.dist_code',$distCode );
        $this->db->where('users.user_desig_code',MB_DEPUTY_COMM );
        $this->db->where('loginuser_table.dis_enb_option','E' );
        $this->db->order_by('loginuser_table.date_of_creation', 'desc');
        $data = $this->db->get()->row();
        return $data;
    }


    // get english circle name
    public function getEngCircleDetails($distCode, $diviCode, $circleCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code', $distCode)
            ->where('subdiv_code', $diviCode)
            ->where('cir_code', $circleCode)
            ->where('mouza_pargona_code', '00')
            ->get('location')
            ->row();
    }

    // get english lot name
    public function getEngLotDetails($distCode, $diviCode, $circleCode, $mouzaCode, $lotCode)
    {
        return $this->db->select('locname_eng')
            ->where('dist_code', $distCode)
            ->where('subdiv_code', $diviCode)
            ->where('cir_code', $circleCode)
            ->where('mouza_pargona_code', $mouzaCode)
            ->where('lot_no', $lotCode)
            ->get('location')
            ->row();
    }


    function downloadExcelReport($filename, $result_array)
    {
        require_once 'application/libraries/xlsxwriter.class.php';
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        // var_dump($result_array[0]);
        //$head_array[] = array_keys($result_array[0]);
        foreach($result_array[0] as $key=>$head)
        {
            $final_head[$key]='string';
        }
        $styles1 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold', 'fill'=>'#FFFF00',
            'halign'=>'center', 'border'=>'left,right,top,bottom');
        $styles7 = array( 'border'=>'left,right,top,bottom');
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //header("Content-Type: application/vnd.ms-excel");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        $writer = new XLSXWriter();
        $writer->setAuthor('Dharitree');
        $writer->writeSheetHeader('Sheet1', $final_head,$styles1);
        foreach($result_array as $row)
            $writer->writeSheetRow('Sheet1', (array)$row,$styles7);
        ob_end_clean();
        $writer->writeToStdOut();
        exit(0);
    }


    public function getVillageList($dist,$sub,$circle,$mza,$lot)
    {
        $data = $this->db->select('*')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where_not_in('vill_townprt_code','00000')
            ->get('location');

        return $data->result();


    }


    // get dag list
    public function getDagList($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code) {
        $q = ""
            . "Select dag_no, dag_no_int from   Chitha_Basic where "
            . "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
            . "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
            . "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
        $district = $this->db->query($q);
        return $district->result();
    }


    // get area details
    public function getAreaDetail($dist,$sub,$circle,$mza,$lot,$village_code,$dag_no)
    {

        $data = $this->db->select('dag_no,patta_no,patta_type_code,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,land_class_code')
            ->where('dist_code',$dist)
            ->where('subdiv_code',$sub)
            ->where('cir_code',$circle)
            ->where('mouza_pargona_code',$mza)
            ->where('lot_no',$lot)
            ->where('vill_townprt_code',$village_code)
            ->where('dag_no_int',$dag_no)
            ->get('chitha_basic');

        return $data->result();

    }


    // upload file
    function uploadFile($case_no){
        //////////////////////////////////
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
                            $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            redirect(base_url() . "index.php/home");
                        }
                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                        {
                            // todo error show file allow type not match
                            $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            redirect(base_url() . "index.php/home");
                        }
                        if($size > UPLOAD_MAX_SIZE)
                        {
                            $this->session->set_flashdata('message', "Maximum 10MB file size. Error Code(#FAPL003)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                else{
                    $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
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
                $replaceCase=str_replace("/","-",$case_no);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
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
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'REC',
                    );
                    // save data in attachment file

                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    log_message('error',$this->db->last_query());
                    if($addMoreDocQuery != 1)
                    {
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
                else
                {
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
        }
    }

    public function adcSelect($dist_code) {
        return $this->db->query("SELECT u.username, u.user_desig_code, u.user_code FROM users u, loginuser_table lut WHERE u.dist_code=lut.dist_code AND u.subdiv_code=lut.subdiv_code AND u.cir_code=lut.cir_code AND u.user_code=lut.user_code AND lut.priv='adm' AND lut.dis_enb_option='E' AND u.dist_code=? AND u.subdiv_code='00' AND u.cir_code='00' AND u.user_desig_code='ADC' ORDER BY lut.date_of_creation DESC", [$dist_code])->result();
    }

}