<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NcUtility {

    public function __construct() {

        // $this->dbswitch();
    }

    public function setSession($data) {
        foreach ($data as $key => $value) {

        }
    }

    public function dbSwitchSession()
    {
        $CI = & get_instance();
        $CI->load->library('session');

        if($CI->session->userdata('dist_code') == "02"){
            $CI->db=$CI->load->database('dha3', TRUE);
        } else if($CI->session->userdata('dist_code') == "05"){
            $CI->db=$CI->load->database('dha1', TRUE);
        } else if($CI->session->userdata('dist_code') == "10"){
            $CI->db=$CI->load->database('dha24', TRUE);
        } else if($CI->session->userdata('dist_code') == "13"){
            $CI->db=$CI->load->database('dha2', TRUE);
        }  else if($CI->session->userdata('dist_code') == "17"){
            $CI->db=$CI->load->database('dha4', TRUE);
        }  else if($CI->session->userdata('dist_code') == "15"){
            $CI->db=$CI->load->database('dha5', TRUE);
        }  else if($CI->session->userdata('dist_code') == "14"){
            $CI->db=$CI->load->database('dha6', TRUE);
        }  else if($CI->session->userdata('dist_code') == "07"){
            $CI->db=$CI->load->database('dha7', TRUE);
        }  else if($CI->session->userdata('dist_code') == "03"){
            $CI->db=$CI->load->database('dha8', TRUE);
        }  else if($CI->session->userdata('dist_code') == "18"){
            $CI->db=$CI->load->database('dha9', TRUE);
        }  else if($CI->session->userdata('dist_code') == "12"){
            $CI->db=$CI->load->database('dha13', TRUE);
        }  else if($CI->session->userdata('dist_code') == "24"){
            $CI->db=$CI->load->database('dha10', TRUE);
        }  else if($CI->session->userdata('dist_code') == "06"){
            $CI->db=$CI->load->database('dha11', TRUE);
        }  else if($CI->session->userdata('dist_code') == "11"){
            $CI->db=$CI->load->database('dha12', TRUE);
        }  else if($CI->session->userdata('dist_code') == "12"){
            $CI->db=$CI->load->database('dha13', TRUE);
        }  else if($CI->session->userdata('dist_code') == "16"){
            $CI->db=$CI->load->database('dha14', TRUE);
        }  else if($CI->session->userdata('dist_code') == "32"){
            $CI->db=$CI->load->database('dha15', TRUE);
        }  else if($CI->session->userdata('dist_code') == "33"){
            $CI->db=$CI->load->database('dha16', TRUE);
        }  else if($CI->session->userdata('dist_code') == "34"){
            $CI->db=$CI->load->database('dha17', TRUE);
        }  else if($CI->session->userdata('dist_code') == "21"){
            $CI->db=$CI->load->database('dha18', TRUE);
        }  else if($CI->session->userdata('dist_code') == "08"){
            $CI->db=$CI->load->database('dha19', TRUE);
        }  else if($CI->session->userdata('dist_code') == "35"){
            $CI->db=$CI->load->database('dha20', TRUE);
        }  else if($CI->session->userdata('dist_code') == "36"){
            $CI->db=$CI->load->database('dha21', TRUE);
        }  else if($CI->session->userdata('dist_code') == "37"){
            $CI->db=$CI->load->database('dha22', TRUE);
        }  else if($CI->session->userdata('dist_code') == "25"){
            $CI->db=$CI->load->database('dha23', TRUE);
        } else if ($CI->session->userdata('dist_code') == "39") {
            $CI->db = $CI->load->database('dha39', true);
        } else if ($CI->session->userdata('dist_code') == "38") {
            $CI->db = $CI->load->database('dha25', true);
        }
    }

    public function dbSwitchCode($dist_code){
        $CI=&get_instance();
        if($dist_code == "02"){
            $CI->db=$CI->load->database('dha3', TRUE);
        } else if($dist_code == "05"){
            $CI->db=$CI->load->database('dha1', TRUE);
        } else if($dist_code == "10"){
            $CI->db=$CI->load->database('dha24', TRUE);
        } else if($dist_code == "13"){
            $CI->db=$CI->load->database('dha2', TRUE);
        }  else if($dist_code == "17"){
            $CI->db=$CI->load->database('dha4', TRUE);
        }  else if($dist_code == "15"){
            $CI->db=$CI->load->database('dha5', TRUE);
        }  else if($dist_code == "14"){
            $CI->db=$CI->load->database('dha6', TRUE);
        }  else if($dist_code == "07"){
            $CI->db=$CI->load->database('dha7', TRUE);
        }  else if($dist_code == "03"){
            $CI->db=$CI->load->database('dha8', TRUE);
        }  else if($dist_code == "18"){
            $CI->db=$CI->load->database('dha9', TRUE);
        }  else if($dist_code == "12"){
            $CI->db=$CI->load->database('dha13', TRUE);
        }  else if($dist_code == "24"){
            $CI->db=$CI->load->database('dha10', TRUE);
        }  else if($dist_code == "06"){
            $CI->db=$CI->load->database('dha11', TRUE);
        }  else if($dist_code == "11"){
            $CI->db=$CI->load->database('dha12', TRUE);
        }  else if($dist_code == "12"){
            $CI->db=$CI->load->database('dha13', TRUE);
        }  else if($dist_code == "16"){
            $CI->db=$CI->load->database('dha14', TRUE);
        }  else if($dist_code == "32"){
            $CI->db=$CI->load->database('dha15', TRUE);
        }  else if($dist_code == "33"){
            $CI->db=$CI->load->database('dha16', TRUE);
        }  else if($dist_code == "34"){
            $CI->db=$CI->load->database('dha17', TRUE);
        }  else if($dist_code == "21"){
            $CI->db=$CI->load->database('dha18', TRUE);
        }  else if($dist_code == "08"){
            $CI->db=$CI->load->database('dha19', TRUE);
        }  else if($dist_code == "35"){
            $CI->db=$CI->load->database('dha20', TRUE);
        }  else if($dist_code == "36"){
            $CI->db=$CI->load->database('dha21', TRUE);
        }  else if($dist_code == "37"){
            $CI->db=$CI->load->database('dha22', TRUE);
        }  else if($dist_code == "25"){
            $CI->db=$CI->load->database('dha23', TRUE);
        }  else if($dist_code == "39"){
            $CI->db=$CI->load->database('dha39', TRUE);
        }else if($dist_code == "38"){
            $CI->db=$CI->load->database('dha25', TRUE);
        }else if($dist_code == "22"){
            $CI->db=$CI->load->database('dha41', TRUE);
        }else if($dist_code == "23"){
            $CI->db=$CI->load->database('dha40', TRUE);
        }
    }

    function Total_ganda($bigha, $katha, $lessa, $ganda) {
        $total_ganda = $ganda + ($lessa*20) + ($katha * 320) + ($bigha * 6400);
        return $total_ganda;
    }

    function Total_Lessa($bigha, $katha, $lessa) {
        $total_lessa = $lessa + ($katha * 20) + ($bigha * 100);
        return $total_lessa;
    }

    function Total_Bigha_Katha_Lessa($total_lessa)
    {
        $mm = 0;
        if($total_lessa < 0)
        {
            $mm = 1;
            $total_lessa = abs($total_lessa);
        }
        $bigha = $total_lessa / 100;
        $rem_lessa = fmod($total_lessa, 100);
        $katha = $rem_lessa / 20;
        $r_lessa = fmod($rem_lessa, 20);
        $mesaure = array();
        $mesaure[].=($mm==1) ? -floor($bigha): floor($bigha);
        $mesaure[].=($mm==1) ? -floor($katha): floor($katha);
        $mesaure[].=($mm==1) ? -($r_lessa) : $r_lessa;
        $mesaure[].=0;
        return $mesaure;
    }

    function Total_Bigha_Katha_Lessa2($total_ganda)
    {
        $mm = 0;
        if($total_ganda < 0)
        {
            $mm = 1;
            $total_ganda = abs($total_ganda);
        }

        $bigha = $total_ganda / 6400;
        $rem_ganda = $total_ganda % 6400;
        $katha = $rem_ganda / 320;
        $rem_ganda2 = $rem_ganda % 320;
        $chatak = $rem_ganda2/20;
        $rem_ganda3 =  $rem_ganda2%20;


        $mesaure = array();
        $mesaure[].=($mm==1) ? -floor($bigha): floor($bigha);
        $mesaure[].=($mm==1) ? -floor($katha): floor($katha);
        $mesaure[].=($mm==1) ? -floor($chatak): floor($chatak);
        $mesaure[].=($mm==1) ? -(number_format($rem_ganda3,4)) : number_format($rem_ganda3,4);

        return $mesaure;
    }

    function createTokenJwt()
    {
        $timestamp = date("Y-m-d H:i:s");
        $CI = & get_instance();
        $CI->output->set_header("Access-Control-Allow-Origin:*");
        $jwt = new JWT();
        $key = SECRET_KEY;
        $payload = array(
            "timestamp" => $timestamp
        );
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    function getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag) {
        $CI = & get_instance();
        $this->dbSwitchCode($d);
        $query = "select sum(dag_revenue+dag_local_tax) as sum,dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code from chitha_basic where dist_code= '$d' and subdiv_code='$s' and cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and  trim(dag_no)=trim('$dag') group by dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code  ";
        $sql = $CI->db->query($query)->row();
        return $sql;
    }

    public function checkUserAuthForCaseForLm($dist,$s,$c,$m,$l){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $session_dist_code = $CI->session->userdata('dist_code');
        $session_subdiv_code = $CI->session->userdata('subdiv_code');
        $session_cir_code = $CI->session->userdata('cir_code');
        $session_mouza_pargona_code = $CI->session->userdata('mouza_pargona_code');
        $session_lot_no = $CI->session->userdata('lot_no');

        if(($session_dist_code == $dist) && ($session_subdiv_code == $s) && ($session_cir_code == $c) && ($session_mouza_pargona_code == $m) && ($session_lot_no == $l)){
            return true;
        }else{
            return false;
        }
    }

    public function lmAuthBasic($case_no)
    {
        $CI = & get_instance();

        $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer ='LM' and status = 'R'";
        
        $dataFound=$CI->db->query($sqlCheckExist)->row();
        //echo json_encode($dataFound);
        if($dataFound->c <=0){

            $CI->session->set_flashdata('message', "#ERRC00299: Case Already forwarded from LM. case no : ".$case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }
    }

    public function lmAuthFirstProceeding($case_no)
    {
        $CI = & get_instance();

        $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and status = 'Z'";
        
        $dataFound=$CI->db->query($sqlCheckExist)->row();
        //echo json_encode($dataFound);
        if($dataFound->c <=0){

            $CI->session->set_flashdata('message', "#ERRC0014299: Case Already forwarded from LM. case no : ".$case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }
    }

    public function curlPost($url, $arrayData)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($arrayData));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode !=200 || $result == null){
            return false;
        }
        else
        {
            return $result;
        }
    }

    public function getZonalValue($dist_code, $uuid, $dag_no) {

        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $q = "select unique_village_code,dag_no,zone_id,subclass_id from dagwise_zone_info where flag='1' and dist_code='$dist_code' and unique_village_code='$uuid' and trim(dag_no)='".trim($dag_no)."'";
        $zonaldata=$CI->db->query($q)->num_rows();

        if($zonaldata > 0){
            $zonaldata=$CI->db->query($q)->row();
            $zonalrate = $CI->db->query("select land_rate from villagewise_zone_info where flag='1' and unique_village_code='$zonaldata->unique_village_code' and
            zone_code='$zonaldata->zone_id' and subclass_code='$zonaldata->subclass_id'");
            return $zonalrate->row()->land_rate;
        }else{
            return null;
        }
    }

    function decryptJwtCase($token)
    {
        $CI = & get_instance();
        $jwt = new JWT();
        $key = SECRET_KEY;
        try
        {
        $decode = $jwt->decode($token,$key,'HS256');
            return $decode;
        }
        catch(\Exception $e)
        {
            $CI->session->set_flashdata('message', "#ERR2222: Invalid Case Number!");
            redirect(base_url() . "index.php/home");
            return false;
        }
    }

    public function checkIfAlreadyUpdatedByLm($case_no){
        $CI = & get_instance();
        $sql = $CI->db->query("SELECT pending_officer FROM settlement_basic WHERE case_no = '$case_no'");
        if ($sql->num_rows() > 0) {
            if($sql->row()->pending_officer == 'LM'){
                return 'y';
            }
            else
            {
                return 'n';
            }
        }
        else
        {
            return false;
        }
    }

    public function getApplidFromCaseNo($case_no) {

        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $applid = $CI->db->query("select applid from settlement_basic where case_no ='$case_no'");
        return $applid->row()->applid;
    }

    function encryptJwtCase($case_no)
    {
        $CI = & get_instance();
        $CI->output->set_header("Access-Control-Allow-Origin:*");
        $jwt = new JWT();
        $key = SECRET_KEY;
        $payload = $case_no;
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    function appRelationbyIDMB2($r) {
        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $query = "select guard_rel_desc as name from master_guard_rel where id='$r' ";
        $sql = $CI->db->query($query)->row()->name;
        return $sql;
    }

    public function getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code) {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $mouza = $CI->db->query("select loc_name AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

    public function getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no) {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $lot = $CI->db->query("select loc_name from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='$lot_no'");
        return $lot->row()->loc_name;
    }

    public function getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $CI->db->query("select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function getBasuApplIdFromCaseNo($case_no) {

        $CI = & get_instance();
        $d = $CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $applid = $CI->db->query("SELECT basundhara FROM basundhar_application 
                        WHERE dharitree=?", array($case_no));
        if($applid->num_rows() <= 0){
            return $applid = '';
        }
        return 'Basundhara : '.$applid->row()->basundhara;
    }




    function getServiceCode($case_no){
        $CI = & get_instance();
        $sql = $CI->db->query("SELECT service_code from settlement_basic where case_no = '$case_no'");

        if($sql->num_rows > 0 ){
            return $service_code = $sql->row()->service_code;
        }else{
            return false;
        }
    }

    public function get_relation_id($relation) {
        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($ds);
        $relation = strtoLower($relation);
        $query = "select guard_rel_desc_as from master_guard_rel where id = '$relation'";

        $relation = $CI->db->query($query);
        $row = $relation->num_rows;
        if ($row != 0) {
            return $relation->row()->guard_rel_desc_as;
        }

        return "unkown";
    }

    public function getEnglishVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $CI->db->query("select locname_eng AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function getEnglishMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code) {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $mouza = $CI->db->query("select locname_eng AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

    public function getEnglishCircleName($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $this->dbSwitchCode($dist_code);
        $circle = $CI->db->query("select locname_eng AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

    public function getDistrictName($dist_code) {

        //var_dump($this->session->all_userdata());
        //$CI->load->library('session');
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'";


        $district = $CI->db->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

    public function getSubDivName($dist_code, $subdiv_code) {
        $CI = & get_instance();

        $this->dbSwitchCode($dist_code);
        $subdiv = $CI->db->query("select loc_name AS subdiv from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $subdiv->row()->subdiv;
    }

    public function getCircleName($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $this->dbSwitchCode($dist_code);
        $circle = $CI->db->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

    function maxdag($d, $s, $c, $m, $l, $v) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $q = "Select max(dag_no_int) as new_dag from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'";
        $new_dag = $CI->db->query($q)->row()->new_dag;
        $new_dag = $new_dag / 100;
        $new_dag = $new_dag + 1;
        return $new_dag;
    }

    function maxpatta($d, $s, $c, $m, $l, $v, $pp) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $newpatta = 0;
        $q = "Select patta_no from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and patta_type_code='$pp' ";
        $patta_no = $CI->db->query($q)->result();
        foreach ($patta_no as $p) {
            $p = trim($p->patta_no);
            $p = (int) ($p);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }
        $newpatta = $newpatta + 1;
        return $newpatta;
    }

    function classCodeFromChitha($d, $s, $c, $m, $l, $v, $dag) {
        $CI = & get_instance();
        $newpatta = 0;
        $q = "Select land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
        $result = $CI->db->query($q,array($d, $s, $c, $m, $l, $v, $dag));
        if($result->num_rows()>0){
            return $result->row()->land_class_code;
        }else{
            return null;
        }
    }

    public function getLandClassCode($d) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select land_type from landclass_code where class_code='$d'";
        return $CI->db->query($query)->row()->land_type;
    }

    function getrelationByID($id){
        $CI = & get_instance();
        $query = "select guard_rel_desc_as as name from master_guard_rel where id='$id' ";
        $sql = $CI->db->query($query)->row()->name;
        return $sql;
    }

    public function authCheckCoSk($case_no, $user_desig_code)
    {
        $CI = & get_instance();

        if($user_desig_code == 'CO')
        {
            $query = $CI->db->query('select * from settlement_basic where case_no = ? and (pending_officer = ? OR pending_officer = ?)', array($case_no, $user_desig_code, 'SK'));
        }
        else
        {

            $query = $CI->db->query('select * from settlement_basic sb left join settlement_ap_lmnote sal on sb.case_no=sal.case_no where sal.lm_note =? and sb.status in(\'W\',\'X\') and sb.from_office=? and sb.case_no = ? and (sb.pending_officer = ? OR sb.pending_officer = ?)', array('1', 'LM', $case_no, $user_desig_code,'CO'));

        }
        
        if($query->num_rows() <= 0)
        {
            $CI->session->set_flashdata('message', "#ERR2235: Case already forwarded from CO!");
            redirect(base_url() . "index.php/home");
            return false;
        }

    }

    
    public function checkUserAuthForCaseForSk($case_no){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $session_dist_code = $CI->session->userdata('dist_code');
        $session_subdiv_code = $CI->session->userdata('subdiv_code');
        $session_cir_code = $CI->session->userdata('cir_code');
        $session_user_code = $CI->session->userdata('user_code');


        $session_mouza_pargona_code = $CI->session->userdata('mouza_pargona_code');
        $session_lot_no = $CI->session->userdata('lot_no');

        if(($session_mouza_pargona_code != '00') && ($session_lot_no != '00')){
            $CI->session->set_flashdata('message', "#ERRCO7503303 : Unauthorized access: You might be using multiple login. Kindly logout and login again!! case no # ".$case_no);
            redirect(base_url() . "index.php/home");

        }


        // $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code' AND sk_code = '$session_user_code'";
        // $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code' AND sk_code like '%SK%'";
        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code'";

        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0) {
            $CI->session->set_flashdata('message', "#ERRCO503303 : Unauthorized access for case no # ".$case_no);
            log_message('error', '#ERRCO503303: Falied to forward to CO '.$CI->db->last_query());
            redirect(base_url() . "index.php/home");
        }

    }

    public function checkUserAuthForCaseForCo($case_no){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbSwitchCode($d);
        $session_dist_code = $CI->session->userdata('dist_code');
        $session_subdiv_code = $CI->session->userdata('subdiv_code');
        $session_cir_code = $CI->session->userdata('cir_code');
        $session_user_code = $CI->session->userdata('user_code');


        $session_mouza_pargona_code = $CI->session->userdata('mouza_pargona_code');
        $session_lot_no = $CI->session->userdata('lot_no');

        // if(($session_mouza_pargona_code != '00') && ($session_lot_no != '00')){
        if ($CI->session->userdata('user_desig_code')!='CO'){
            $CI->session->set_flashdata('message', "#ERRCO103303 :Unauthorized access: You might be using multiple login. Kindly logout and login again!! case no # ".$case_no);
            log_message('error', '#ERRCO103303: Falied to forward to CO');
            redirect(base_url() . "index.php/home");

        }


        // $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code' AND co_code = '$session_user_code'";
        // $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code'";
        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code' AND (co_code = '$session_user_code' or co_code is null)";

        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0) {
            $CI->session->set_flashdata('message', "#ERRCO403303 :Unauthorized access for case no # ".$case_no);
            log_message('error', '#ERRCO403303: Falied to forward to CO '.$CI->db->last_query());
            redirect(base_url() . "index.php/home");
        }

    }



    
    // **** code by Masud Reza

    // check Auth user DC
    public function checkUserAuthForCaseForDc($case_no)
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_DEPUTY_COMM)
        {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0) {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

    }

    // check Auth user DC with Rollback
    public function checkUserAuthForCaseForDcWithRollback($case_no){

        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_DEPUTY_COMM)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }



    // check Auth user ADC
    public function checkUserAuthForCaseForAdc($case_no)
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_ADD_DEPUTY_COMM)
        {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }

    // check Auth user ADC  with Rollback
    public function checkUserAuthForCaseForAdcWithRollback($case_no)
    {

        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_ADD_DEPUTY_COMM)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }



    // check Auth user SDO
    public function checkUserAuthForCaseForSdo($case_no)
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_SUB_DIV_COMM)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'  AND subdiv_code = '$ses_sub'";
        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }

    // check Auth user SDO with Rollback
    public function checkUserAuthForCaseForSdoWithRollback($case_no)
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_SUB_DIV_COMM)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'  AND subdiv_code = '$ses_sub'";
        $result = $CI->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }

    //get service name by service code

    public function getServiceName($scode)
    {
        if($scode == SETTLEMENT_TENANT_ID) {
            return 'Occupancy Tenant';
        }
        if($scode == SETTLEMENT_AP_TRANSFER_ID) {
            return "AP";
        }
        if($scode == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
            return "Tribal Community";
        }
        if($scode == SETTLEMENT_KHAS_LAND_ID) {
            return "Khas Land";
        }
        if($scode == SETTLEMENT_PGR_VGR_LAND_ID) {
            return "PGR VGR";
        }
        if($scode == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
            return "Special Cultivators";
        }

        if($scode == NC_TRIBAL_ID) {
            return "NC Tribal Community";
        }
        if($scode == NC_KHAS_LAND_ID) {
            return "NC Khas Land";
        }
        if($scode == NC_CULTIVATOR_ID) {
            return "NC Special Cultivators";
        }
    }


    public function getNomineeOfSdlacMember($ucode, $dist){

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT * FROM sdlac_nominee_list       
                              WHERE sdlac_user_code=? AND district=? AND nc=?", array($ucode, $dist, 1));
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        else {
            return false;
        }
    }

    public function getSelectedNomineeOfSdlac($pno, $nom_id, $s_code) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT * FROM sdlac_nominee_proposal_list       
                              WHERE proposal_no=? AND nominee_id=? AND service_code=?",
            array($pno, $nom_id, $s_code));
        if ($sql->num_rows() > 0) {
            return 'selected';
        }
        else {
            return false;
        }
    }

    public function getUserNameByUserCode($ucode) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT use_name FROM loginuser_table WHERE user_code=?", array($ucode));
        if ($sql->num_rows() > 0) {
            return $sql->row()->use_name;
        }
        else {
            return false;
        }
    }

    public function getEmailIdByUserCode($ucode) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT emailid FROM users WHERE user_code=?", array($ucode));
        if ($sql->num_rows() > 0) {
            return $sql->row()->emailid;
        }
        else {
            return false;
        }
    }


    public function getNameOfUserByUserCode($ucode) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT username FROM users WHERE user_code=?", array($ucode));
        if ($sql->num_rows() > 0) {
            return $sql->row()->username;
        }
        else {
            return false;
        }
    }


    //get designation by usercode
    public function getDesignationNameByUserCode($usercode) {
        $CI = & get_instance();
        $sql = $CI->db->query("select A.user_desig_code, B.user_desig from users A
                    join master_user_designation B on A.user_desig_code=B.user_desig_code
                    where A.user_code=?", array($usercode));
        if ($sql->num_rows() > 0) {
            return $sql->row();
        }
        else {
            return false;
        }
    }


    public function getNomineeNameOfNomineeId($numId) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT nominee_name FROM sdlac_nominee_list WHERE id=? and nc=?", array($numId,1));
        if ($sql->num_rows() > 0) {
            return $sql->row()->nominee_name;
        }
        else {
            return false;
        }
    }


    // *** End code by Masud Reza

    public function errorResp($code, $msg, $log=null)
    {
        $CI = & get_instance();
        if($log == true)
        {
            log_message('error', '#'.$code.': '.$msg.'------>'.$CI->db->last_query());
        }

        return [
            'responseType'  => 0,
            'msg'           => '#'.$code.': '.$msg,
        ];
    }

    public function successResp($code, $msg, $log=null, $respType=null, $data=null)
    {
        if($log == true)
        {
            log_message('error', '#'.$code.': '.$msg);
        }
        if($respType == null)
            $respType = 2;
        else
            $respType = $respType;

        return [
            'responseType'  => $respType,
            'code'          => $code,
            'msg'           => '#'.$code.': '.$msg,
            'data'          => $data,
        ];
    }

    public function getIDs($case_id){
        $CI = & get_instance();
        $data = $CI->db->query('select * from settlement_basic where case_no = ?', array($case_id));
        if($data->num_rows() > 0)
        {
            return array(
                'case_no'           => $data->row()->case_no,
                'application_no'    => $data->row()->applid,
            );
        }
        else
        {
            $data1 = $CI->db->query('select * from settlement_basic where applid = ?', array($case_id));
            if($data1->num_rows() > 0)
            {
                return array(
                    'case_no'           => $data1->row()->case_no,
                    'application_no'    => $data1->row()->applid,
                );
            }
            else
            {
                return 3;

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

    public function getRelationById56($id)
    {
        $CI = & get_instance();
        $CI->db->where('id', $id);
        $CI->db->from('master_guard_rel');
        $query = $CI->db->get();
        return $query->row()->guard_rel_desc_as;
    }

    function defaultValue($input, $value)
    {
        if (empty($input)) return $value;

        return $input;
    }

    public function getSelectedCOName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";

        return $CI->db->query($query)->row();
    }

    // check assign ADC  with Rollback
    public function checkAssignAdcWithRollback($case_no)
    {

        $CI = & get_instance();
        $CI->load->library('session');
        $ses_user = $CI->session->userdata['user_code'];

        $sql = $CI->db->query('select adc_code from settlement_basic where case_no = ?', array($case_no));
        $result = $sql->row()->adc_code;

        if($ses_user != $result)
        {
            $CI->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }


}