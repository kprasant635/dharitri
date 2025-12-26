<?php
class legacyModel extends CI_Model
{
    var $dist_code;
    var $subdiv_code;
    var $cir_code;
    protected $table = 't_legacyupdation';

    function __construct() {
        parent::__construct();
        $db=  $this->session->userdata('db');
        $define_date = define_date;
        $year_no = year_no;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
    }  

    // public function getCountPendingLegacyCases() {

    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');

    //     $q = "SELECT count(*) AS count FROM t_legacyupdation WHERE status = 'P' AND 
    //         co_yn is null AND dc_yn is null AND dist_code=? AND subdiv_code=? AND cir_code=? ";
    //         return $cases = $this->db->query($q, 
    //             array($dist_code, $subdiv_code, $cir_code))->row()->count;       
    // }


    // public function getPendingLegacyCases($limit, $offset, $key=null) {

    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');        
    //     $define_date = define_date;
    //     $year_no = year_no;

    //     if($key) { // if searching keywords available

    //         $q = "SELECT *, ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
    //         basundhar_application ba ON fmb.case_no=ba.dharitree WHERE status = 'P' 
    //         AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
    //         AND cir_code=? AND (case_no LIKE '%$key%' OR ba.basundhara LIKE '%$key%')  
    //         ORDER BY proposal_no ASC LIMIT 10 OFFSET 0";
    //         $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
    //     }
    //     else // if searching keywords not available
    //     {
    //         $q = "SELECT *,ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
    //         basundhar_application ba ON fmb.case_no=ba.dharitree WHERE status = 'P' 
    //         AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
    //         AND cir_code=? ORDER BY proposal_no ASC LIMIT $limit OFFSET $offset";
    //         $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
    //     }
    //     return $cases;
    // }

    // Modified by Abhijit START -- 2024-03-04
    public function getCountPendingLegacyCases() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "SELECT count(*) AS count FROM t_legacyupdation WHERE lm_note is not null AND status = 'P' AND 
            co_yn is null AND dc_yn is null AND dist_code=? AND subdiv_code=? AND cir_code=? ";
            return $cases = $this->db->query($q, 
                array($dist_code, $subdiv_code, $cir_code))->row()->count;       
    }


    public function getPendingLegacyCases($limit, $offset, $key=null) {
        // Fetch case for CO

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');        
        $define_date = define_date;
        $year_no = year_no;

        if($key) { // if searching keywords available

            $q = "SELECT *, ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree  WHERE fmb.lm_note is not null AND status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
            AND cir_code=? AND (case_no LIKE '%$key%' OR ba.basundhara LIKE '%$key%')  
            ORDER BY proposal_no ASC LIMIT 10 OFFSET 0";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }
        else // if searching keywords not available
        {
            $q = "SELECT *,ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree WHERE fmb.lm_note is not null AND status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? 
            AND cir_code=? ORDER BY proposal_no ASC LIMIT $limit OFFSET $offset";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }
        return $cases;
    }

    public function getCountPendingLegacyCasesForAdcDc() {

        $dist_code = $this->session->userdata('dist_code');

        $q = "select count(*) as count from t_legacyupdation where status = 'P' and co_yn is not null and dc_yn is null and dist_code=?";
        return $cases = $this->db->query($q, array($dist_code))->row()->count;       
    }


    public function getPendingLegacyCasesForAdcDc($limit, $offset, $key=null) {
        // Fetch case for ADC/DC

        $dist_code = $this->session->userdata('dist_code');

        if($key) { // if searching keywords available

            $q = "SELECT *, ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree  WHERE fmb.lm_note is not null AND status = 'P' 
            AND co_yn IS NOT NULL AND dc_yn IS NULL AND dist_code=? AND (case_no LIKE '%$key%' OR ba.basundhara LIKE '%$key%')  
            ORDER BY proposal_no ASC LIMIT 10 OFFSET 0";
            $cases = $this->db->query($q, array($dist_code))->result();
        }
        else // if searching keywords not available
        {
            $q = "SELECT *,ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree WHERE fmb.lm_note is not null AND status = 'P' 
            AND co_yn IS NOT NULL AND dc_yn IS NULL AND dist_code=? ORDER BY proposal_no ASC LIMIT $limit OFFSET $offset";
            $cases = $this->db->query($q, array($dist_code))->result();
        }
        return $cases;
    }

    public function getCountRevertLegacyCasesForLm() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');  

        $q = "select count(*) as count from t_legacyupdation where status = 'P' and lm_note is null and co_yn is null and dc_yn is null and dist_code=? and subdiv_code=? and cir_code=?";
        return $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->row()->count;       
    }


    public function getRevertPendingLegacyCasesForLm($limit, $offset, $key=null) {
        // Fetch case for LM

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');  

        if($key) { // if searching keywords available

            $q = "SELECT *, ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree  WHERE fmb.lm_note is null AND status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? AND cir_code=? AND (case_no LIKE '%$key%' OR ba.basundhara LIKE '%$key%')  
            ORDER BY proposal_no ASC LIMIT 10 OFFSET 0";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }
        else // if searching keywords not available
        {
            $q = "SELECT *,ba.basundhara FROM t_legacyupdation fmb LEFT JOIN 
            basundhar_application ba ON fmb.case_no=ba.dharitree WHERE fmb.lm_note is null AND status = 'P' 
            AND co_yn IS NULL AND dc_yn IS NULL AND dist_code=? AND subdiv_code=? AND cir_code=? ORDER BY proposal_no ASC LIMIT $limit OFFSET $offset";
            $cases = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code))->result();
        }
        return $cases;
    }

    // Modified by Abhijit END -- 2024-03-04

    function getCountPendingRoRCases(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        if($user_desig_code == 'LM') {
            $sql="Select count(*) AS count from    edit_jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and user_code='$user_code'  and (entry_mode ='O' or entry_mode ='J') ";
        }else{
            $sql = "Select count(*) AS count from    edit_jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and status='P' and (entry_mode ='O' or entry_mode ='J')  ";
        }
        return $cases = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code))->row()->count;
        //echo $this->db->last_query();
    }
    public function getPendingRoRCases($limit, $offset, $key = null)
    {
        $dist_code      = $this->session->userdata('dist_code');
        $subdiv_code    = $this->session->userdata('subdiv_code');
        $cir_code       = $this->session->userdata('cir_code');        
        $user_desig_code= $this->session->userdata('user_desig_code');
        $user_code      = $this->session->userdata('user_code');
        $limit  = (int)$limit;
        $offset = (int)$offset;
        if ($key) {
            $like = '%' . $key . '%';
            if ($user_desig_code == 'LM') {
                $sql = "
                    SELECT *
                    FROM edit_jama_pattadar
                    WHERE dist_code = ?
                    AND subdiv_code = ?
                    AND cir_code = ?
                    AND user_code = ?
                    AND (entry_mode = 'O' OR entry_mode = 'J')
                    AND patta_no LIKE ?
                    ORDER BY id DESC
                    LIMIT 10 OFFSET 0
                ";

                $params = [
                    $dist_code, $subdiv_code, $cir_code,
                    $user_code, $like
                ];

            } else {

                $sql = "
                    SELECT *
                    FROM edit_jama_pattadar
                    WHERE dist_code = ?
                    AND subdiv_code = ?
                    AND cir_code = ?
                    AND status = 'P'
                    AND (entry_mode = 'O' OR entry_mode = 'J')
                    AND patta_no LIKE ?
                    ORDER BY id DESC
                    LIMIT 10 OFFSET 0
                ";

                $params = [
                    $dist_code, $subdiv_code, $cir_code,
                    $like
                ];
            }

            return $this->db->query($sql, $params)->result();
        }


        if ($user_desig_code == 'LM') {

            $sql = "
                SELECT *
                FROM edit_jama_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND user_code = ?
                AND (entry_mode = 'O' OR entry_mode = 'J')
                ORDER BY id DESC
                LIMIT $limit OFFSET $offset
            ";

            $params = [
                $dist_code, $subdiv_code, $cir_code,
                $user_code
            ];

        } else {

            $sql = "
                SELECT *
                FROM edit_jama_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND status = 'P'
                AND (entry_mode = 'O' OR entry_mode = 'J')
                ORDER BY id DESC
                LIMIT $limit OFFSET $offset
            ";

            $params = [
                $dist_code, $subdiv_code, $cir_code
            ];
        }

        return $this->db->query($sql, $params)->result();
    }


    public function revert($tLegacyupdation, $update_data, $api_param): array
    {
        $response = [
            'success' => true,
            'message' => 'Successfully reverted this case'
        ];

        $case_no = $tLegacyupdation->case_no;

        $basundhara_application = $this->db->where('dharitree', $case_no)->get('basundhar_application')->row();
        if($basundhara_application){
            // Case registered from RTPS
            $application_no = $basundhara_application->basundhara;
            $api_param = $api_param + ['application' => $application_no];

            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }

            $result = sendCurlRequest($apilink, 'POST', $api_param);
            if(!$result){
                log_message('error', '#ERRLDURVRT002: Something went wrong with the API for case no => ' . $case_no . ' Last Query => ' . $this->db->last_query());
                
                $response['success'] = false;
                $response['message'] = '#ERRLDURVRT002: Something went wrong. Please try again later.';
                
                return $response;
            }
        }

        $this->db->where('case_no', $case_no)->update('t_legacyupdation', $update_data);

        if($this->db->affected_rows() == 0){
            log_message('error', '#ERRLDURVRT001: Something went wrong for case no => ' . $case_no . ' Last Query => ' . $this->db->last_query());

            $response['success'] = false;
            $response['message'] = '#ERRLDURVRT001: Something went wrong. Please try again later.';
            
            return $response;

        }

        return $response;
    }

    public function get_row($condition, $connection = NULL){
        $db = $this->db;
        if(!empty($connection)){
            $db = $connection;
        }

        return $db->get_where($this->table, $condition)->row();
        // return $db->where($condition)->get($this->table)->row();
    }

    public function get_change_request_string($Pcases){
        $old_patta = $this->db->query("select * from patta_code where type_code =? ", array($Pcases->patta_type_code))->row();
        $old_land_class = $this->db->query("select * from landclass_code where class_code = '$Pcases->present_land_class' ")->row();

        $remark = $Pcases->dag_no . ", এই দাগৰ ";
        if($Pcases->suggested_dag_no != '')
        {    
            $remark = $remark.""."দাগ নং ".$Pcases->dag_no." পৰা ".$Pcases->suggested_dag_no.", ";
        }
        
        if($Pcases->suggested_patta_no != '')
        {
            $remark = $remark.""."পট্টা নং ".$Pcases->patta_no." পৰা ".$Pcases->suggested_patta_no.", ";
        }
        
        if($Pcases->suggested_patta_type != '0' && $Pcases->suggested_patta_type !='')
        {
            $new_patta = $this->db->query("select * from    patta_code where type_code =? ", array($Pcases->suggested_patta_type))->row();

            $remark = $remark.""."পট্টা প্ৰকাৰ ". $old_patta->patta_type ." পৰা " . $new_patta->patta_type . ", ";
        }
        
        if($Pcases->suggested_land_class != '0' && $Pcases->suggested_land_class != '')
        {
            $new_land_class = $this->db->query("select * from    landclass_code where class_code = ? ", array($Pcases->suggested_land_class))->row();
            $remark = $remark.""."মাঢি শ্ৰেণী ". $old_land_class->land_type ." পৰা " . $new_land_class->land_type . ", ";
        }
        
        if($Pcases->suggested_land_rev != '')
        {
            $remark = $remark.""."মাঢি ৰাজহ ". $Pcases->present_land_revenue . " পৰা ".$Pcases->suggested_land_rev.", ";
        }
        
        if($Pcases->suggested_loc_tax != '')
        {
            $remark = $remark.""."মাঢি স্হানীয় কৰ " . $Pcases->present_land_localtax . " পৰা ".$Pcases->suggested_loc_tax.", ";
        }
        
        if($Pcases->suggested_pattadarstrike != '')
        {
            $remark = $remark.""."কাটিব লগা পট্টাদাৰৰ  নাম ".$Pcases->suggested_pattadarstrike.", ";
        }
        
        
        //#START PLB
        
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
        if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != '') && ($Pcases->suggested_dag_area_g != '') && ($Pcases->suggested_dag_area_kr != ''))
        {
            $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." ছ ".$Pcases->dag_area_g." গ পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." ছ ".$Pcases->suggested_dag_area_g." গ ";
        }
        }else{
            if(($Pcases->suggested_dag_area_b != '') && ($Pcases->suggested_dag_area_k != '') && ($Pcases->suggested_dag_area_lc != ''))
                {
                    $remark = $remark.""."মাঢি কালি ".$Pcases->dag_area_b." বি ".$Pcases->dag_area_k." ক ".$Pcases->dag_area_lc." লে পৰা ".$Pcases->suggested_dag_area_b." বি ".$Pcases->suggested_dag_area_k." ক ".$Pcases->suggested_dag_area_lc." লে ";
                }
        }

        $remark .= ' সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷';

        return $remark;
    }
}
