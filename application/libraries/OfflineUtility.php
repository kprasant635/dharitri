<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class OfflineUtility {

    public function __construct()
    {
//        parent::__construct();

        // $this->dbswitch();
    }

    public function setSession($data)
    {
        foreach ($data as $key => $value)
        {

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


    // check Auth user
    public function checkUserAccessForOnlineProcessCommon()
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if(!in_array($ses_user, OFFLINE_SETTLEMENT_ACCESS))
        {
            redirect(base_url().'index.php/Home/index');
        }

    }

    // check Auth user
    public function checkUserAccessForOnlineRegistration()
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if(!in_array($ses_user, OFFLINE_SETTLEMENT_REGISTER_ACCESS))
        {
            redirect(base_url().'index.php/Home/index');
        }

    }


    // area convert to lessa
    function Total_Lessa($bigha, $katha, $lessa)
    {
        $total_lessa = $lessa + ($katha * 20) + ($bigha * 100);
        return $total_lessa;
    }

    // area convert to Ganda for Bengali version
    function Total_ganda($bigha, $katha, $lessa, $ganda)
    {
        $total_ganda = $ganda + ($lessa*20) + ($katha * 320) + ($bigha * 6400);
        return $total_ganda;
    }



    // area Calculation to lessa
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

    // area Calculation to Ganda for Bengali version
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

    // get client IP address
    public function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            //if user is from the proxy
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            // if user from the share internet
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            //if user is from the remote address
            return $_SERVER['REMOTE_ADDR'];
        }

    }


    // encrypt Case JWT
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

    // decrypt Case JWT
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



    public function getEnglishVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $CI->db->query("select locname_eng AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function getEnglishMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $mouza = $CI->db->query("select locname_eng AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

    public function getEnglishCircleName($dist_code, $subdiv_code, $circle_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $circle = $CI->db->query("select locname_eng AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

    public function getDistrictName($dist_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'";


        $district = $CI->db->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

    public function getSubDivName($dist_code, $subdiv_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $subdiv = $CI->db->query("select loc_name AS subdiv from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $subdiv->row()->subdiv;
    }

    public function getCircleName($dist_code, $subdiv_code, $circle_code)
    {
        $CI = & get_instance();
        $this->dbSwitchCode($dist_code);
        $circle = $CI->db->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }


}