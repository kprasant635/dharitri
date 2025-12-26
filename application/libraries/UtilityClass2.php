<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UtilityClass {

    public function __construct() {
        
    }

    public function setSession($data) {
        foreach ($data as $key => $value) {
            
        }
    }

    public function getLocationFromSession() {
        $CI = & get_instance();
        $CI->load->library('session');
        $location = array(
            'dist_code' => $CI->session->userdata('dist_code'),
            'subdiv_code' => $CI->session->userdata('subdiv_code'),
            'cir_code' => $CI->session->userdata('cir_code'),
            'lot_no' => $CI->session->userdata('lot_no'),
            'vill_townprt_code' => $CI->session->userdata('vill_code'),
            'mouza_pargona_code' => $CI->session->userdata('mouza_pargona_code')
        );
        return $location;
    }

    function Total_Lessa($bigha, $katha, $lessa) {
        $total_lessa = $lessa + ($katha * 20) + ($bigha * 100);
        return $total_lessa;
    }

    function TotalAre($total_lesa) {
        $centiarr = (10000 / 747) * $total_lesa;
        $totalAre = ($centiarr / 100);
        return $totalAre;
    }

    function get_Hec_Are_CAre($bigha, $katha, $lessa) {

        $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $centiarr = (10000 / 747) * $total_lesa;
        $hectar = $centiarr / 10000;

        $wholeHector = floor($hectar);      // 1
        $fraction1 = $hectar - $wholeHector; // .25
        $arr = 100 * $fraction1;
        $wholeArr = floor($arr);

        $fraction2 = $arr - $wholeArr;
        $arr2 = $fraction2 * 100;
        $wholeCArr = round($arr2, 2);

        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        return $hec_are_care;
    }

    function Total_Bigha_Katha_Lessa($total_lessa) {
        $bigha = $total_lessa / 100;
        $rem_lessa = $total_lessa % 100;
        $katha = $rem_lessa / 20;
        $r_lessa = $rem_lessa % 20;
        $mesaure = array();
        $mesaure[].=floor($bigha);
        $mesaure[].=floor($katha);
        $mesaure[].=round($r_lessa, 2);

        return $mesaure;
    }

    public function getDistrictName($dist_code) {
        $CI = & get_instance();

        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
                . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'";

        
        $district = $CI->db->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
                . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }
    
    public function getDistrictNamebydbload($dist_code) {
        $CI = & get_instance();
        
        $db = $CI->load->database($dist_code, TRUE);
        $CI->dbc = $db;

        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
                . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'";

        
        $district = $CI->dbc->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
                . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

//function created for displaying the subdivision name
    public function getSubDivName($dist_code, $subdiv_code) {
        $CI = & get_instance();
        $subdiv = $CI->db->query("select loc_name AS subdiv from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");
        return $subdiv->row()->subdiv;
    }

//function created for displaying the circle name
    public function getCircleNamebydbload($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        $db = $CI->load->database($dist_code, TRUE);
        $CI->dbc = $db;
        
        $circle = $CI->dbc->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }
    
    public function getCircleName($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        $circle = $CI->db->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

//function created for displaying the mouza name
    public function getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code) {
        $CI = & get_instance();
        $mouza = $CI->db->query("select loc_name AS mouza from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

//function for all the Circl
    public function getAllCircleName($dist_code, $subdiv_code) {
        $CI = & get_instance();
        $cir_code = $CI->db->query("select cir_code as cir_code ,loc_name as loc_name from location where dist_code ='$dist_code'  and "
                        . " subdiv_code='$subdiv_code' and cir_code !='00' and mouza_pargona_code='00' and "
                        . " vill_townprt_code='00000' and lot_no='00'")->result();

        return $cir_code;
    }

//function created for displaying the lot No
    public function getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no) {
        $CI = & get_instance();
        $lot = $CI->db->query("select lot_no from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . " vill_townprt_code='00000' and lot_no='$lot_no'");
        return $lot->row()->lot_no;
    }

//function created for displaying the village name
    public function getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";
		
        $village = $CI->db->query("select loc_name AS village from location where dist_code ='$dist_code'  and "
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function getTransferType($transcode) {
        $CI = & get_instance();
        $data = $CI->db->get_where('nature_trans_code', array('trans_code' => $transcode))->row()->trans_desc_as;
		
        return $data;
    }

    public function getMonth($month) {
        $month = trim($month);
        switch ($month) {
            case '01':
                $month = "January";
                break;
            case '02':
                $month = "February";
                break;
            case '03':
                $month = "March";
                break;
            case '04':
                $month = "April";
                break;
            case '05':
                $month = "May";
                break;
            case '06':
                $month = "June";
                break;
            case '07':
                $month = "July";
                break;
            case '08':
                $month = "August";
                break;
            case '09':
                $month = "September";
                break;
            case '10':
                $month = "October";
                break;
            case '11':
                $month = "November";
                break;
            case '12':
                $month = "December";
                break;
            case '00':
                $month = "Full Year";
                break;
            default:
                break;
        }
        return $month;
    }

//function created for find the first and last day of the month
//#################################################################
    public function First_Last_Date_of_Month($year, $month) {
        $start_date = $year . "-" . $month . "-01";
        if (($month == 1) || ($month == 3) || ($month == 5) || ($month == 7) || ($month == 8) || ($month == 10) || ($month == 12)) {
            $last_date = $year . "-" . $month . "-31";
        } elseif (($month == 4) || ($month == 6) || ($month == 9) || ($month == 11)) {
            $last_date = $year . "-" . $month . "-30";
        } elseif (($month == 2)) {
            $checkLeapYear = $year % 4;
            if ($checkLeapYear == 0) {
                $last_date = $year . "-" . $month . "-29";
            } else {
                $last_date = $year . "-" . $month . "-28";
            }
        }
        $First_Last = array();
        $First_Last[].=$start_date;
        $First_Last[].=$last_date;
        return $First_Last;
    }

//#################################################################

    public function get_name($pattadar) {
        $CI = & get_instance();
        $CI->load->library('session');
        $location = $this->getLocationFromSession();
//var_dump($location);
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $lot_no = $location['lot_no'];
        $mouza_pargona_code = $location['mouza_pargona_code'];
        $vill_townprt_code = $location['vill_townprt_code'];
        $dag_no = $CI->session->userdata['dag_no'];
        $patta_no = trim($CI->session->userdata['patta_no']);


        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join chitha_dag_pattadar d 
            on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no 
            and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id 
            where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code'
            and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' 
            and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='0202' and d.pdar_id='$pattadar'";
//echo $q;

        $query = $CI->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join chitha_dag_pattadar d 
            on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no 
            and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id 
            where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code'
            and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' 
            and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='0202' and d.pdar_id='$pattadar'");

        return $query->row()->pdar_name;
    }

    public function get_relation($relation) {
        $CI = & get_instance();
        $relation = strtoLower($relation);
        $query = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$relation'";

        $relation = $CI->db->query($query);
        $row = $relation->num_rows;
        if ($row != 0) {
            return $relation->row()->guard_rel_desc_as;
        }

        return "unkown";
    }

    public function getLapseDays($submission_date) {
//date created from the string
        $sub_date = date_create($submission_date);
        $today = date_create(date("Y-m-d"));
//difference counted
        $diff = date_diff($today, $sub_date);
        $date = $diff->format("%R%a");
//find the sign
        $d = $diff->format("%R%");
//take the integer value
        $days = intval($date);

        if ($d == '+') {
            $dif = "Due for " . $days . " days";
        } elseif ($d == '-') {
//explode by - sign
            $dd = explode("-", $days);
            $dif = "Lapsed by " . $dd[1] . " days";
        }

        return $dif;
    }

    public function getOfficeMutType($order) {
        $CI = & get_instance();
        $order = trim($order);
       
        $relation = $CI->db->query("select order_type from master_office_mut_type"
                        . " where order_type_code = '$order'")->row()->order_type;
        return $relation;
    }

    public function getMondalsName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        $q = "select lm_name,lm_code from lm_code"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
                . " and mouza_pargona_code='$m' and lot_no='$m'";

        $relation = $CI->db->query("select lm_name,lm_code from lm_code"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
                        . " and mouza_pargona_code='$m' and lot_no='$m'")->result();

        return $relation;
    }

    public function getSKName($d, $s, $c,$name="") {
        $CI = & get_instance();
        $q="select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                        . " ";
       
        if($name !=null){
            $relation = $CI->db->query("select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                        . " ")->result();
      
        }else{
            $relation = $CI->db->query("select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
                        . " ")->result();
        }
       

        return $relation;
    }

    public function getCOName($d, $s, $c,$name="") {
        
        $CI = & get_instance();
		if($name !=null){
                        $q="select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                        . " ";
                        
			$relation = $CI->db->query("select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                        . " ")->result();
		}else{
                        $q="select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " ";
                        
			$relation = $CI->db->query("select user_code,username from users"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " ")->result();
		}

        return $relation;
    }
    public function getSelectedAssttName($d, $s, $c, $l) {
        $CI = & get_instance();
        $query = "select username from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                . "user_code='$l'";

        return $CI->db->query($query)->row();
    }

    public function getSelectedMondalsName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        $query = "select lm_name,lm_code from lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                . "mouza_pargona_code='$m' and lot_no='$l'";
		
        return $CI->db->query($query)->row();
    }

    public function getDefinedSKName($d, $s, $c, $code) {
        $CI = & get_instance();      
        $query = "select user_code,username from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                . "user_code='$code'";
		
        return $CI->db->query($query)->row();
    }

    public function getDefinedMondalsName($d, $s, $c, $m, $l, $code) {
        $CI = & get_instance();
       
        $query = "select lm_name,lm_code from lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                . "mouza_pargona_code='$m' and lot_no='$l' and lm_code='$code'";
		
        return $CI->db->query($query)->row();
    }

    public function getSelectedSKName($d, $s, $c) {
        $CI = & get_instance();
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
                . " user_desig_code='SK'";
        return $CI->db->query($query)->row();
    }

    public function getSelectedCOName($d, $s, $c, $user) {
        $CI = & get_instance();
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
                . " user_code='$user'";

        return $CI->db->query($query)->row();
    }

    public function getPdarName($d, $s, $c, $m, $l, $v, $pid, $dag) {
        $CI = & get_instance();
        $query = "select pdar_name from chitha_pattadar cp join chitha_dag_pattadar dp on"
                . " cp.dist_code=dp.dist_code and cp.subdiv_code=dp.subdiv_code and cp.cir_code=dp.cir_code and "
                . " cp.mouza_pargona_code=dp.mouza_pargona_code and cp.lot_no = dp.lot_no and "
                . " cp.vill_townprt_code = dp.vill_townprt_code and TRIM(cp.patta_no)=TRIM(dp.patta_no) and"
                . " cp.patta_type_code = dp.patta_type_code and cp.pdar_id = dp.pdar_id and TRIM(cp.patta_no) = "
                . " TRIM(dp.patta_no) where dp.dag_no='$dag' and cp.pdar_id=$pid"
                . " and cp.dist_code='$d' and cp.subdiv_code='$s' and cp.cir_code='$c' and cp.mouza_pargona_code='$m' and"
                . " cp.lot_no='$l' and cp.vill_townprt_code='$v'"
                . "";

        return $CI->db->query($query)->row()->pdar_name;
    }

    public function getCertName($cert) {
        $CI = & get_instance();
        $query = "Select cert_type from cert_type where cert_code='$cert'";
        return $CI->db->query($query)->row()->cert_type;
    }

    public function getCertCode($cert) {
        $CI = & get_instance();
        $query = "Select cert_name_code from cert_type where cert_code='$cert'";
        return $CI->db->query($query)->row()->cert_name_code;
    }

    public function getRevenuLoc($d, $s, $c) {
        $CI = & get_instance();
        $query = "Select rev_name from cert_revenue_location where dist_code='$d' and subdiv_code='$s' and cir_code='$c' ";
        //echo $query;
        return $CI->db->query($query)->row()->rev_name;
    }

    public function getPattaName($d) {
        $CI = & get_instance();
        $query = "Select patta_type from patta_code where type_code='$d'";
        //echo $query;
        return $CI->db->query($query)->row()->patta_type;
    }

    public function getLandClassCode($d) {
        $CI = & get_instance();
        $query = "Select land_type from landclass_code where class_code='$d'";
        return $CI->db->query($query)->row()->land_type;
    }

    public function getLandClasses() {
        $CI = & get_instance();
        $query = "Select * from landclass_code";
        return $CI->db->query($query)->result();
    }

    public function getLmByCode($lm_code) {
        $CI = & get_instance();
        $sql = "select lm_name,lm_code from lm_code where lm_code='$lm_code'";
        return $CI->db->query($sql)->row();
    }

    public function getSKByCode($d, $s, $c, $sk_code) {
        $CI = & get_instance();

        $sql = "select username,user_code from users where user_code='$sk_code' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' ";
        return $CI->db->query($sql)->row();
    }

    public function getCOCode($d, $s, $c,$co_code) {
        $CI = & get_instance();
        $sql = "select username,user_code from users where user_code='$co_code' and dist_code='$d' and subdiv_code='$s' and cir_code='$c'";
        return $CI->db->query($sql)->row();
    }

    public function getPattaType($code) {
        $CI = & get_instance();
        $sql = "select patta_type from patta_code where type_code='$code'";
        return $CI->db->query($sql)->row()->patta_type;
    }

    public function getDaysAfter($diff) {
        $today = date('Y-m-d');
        $nextdate = date('Y-m-d', strtotime($today . ' + ' . $diff . ' days'));
        return $nextdate;
    }

    public function GetCaseStatus($code) {
        $CI = & get_instance();
        $sql = "SELECT * FROM case_status where status_code='$code'";
        //echo $sql;
        return $CI->db->query($sql)->row()->description;
    }

    public function MondalName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        $relation = $CI->db->query("select lm_name from lm_code"
                        . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
                        . " and mouza_pargona_code='$m' and lot_no='$l'")->row();
        return $relation;
    }

    function get_user_status($controllers, $v) {
        $CI = & get_instance();
        $controller_name = $controllers;
        $function_name = $v;
        $sql = "select user_desig_code from user_permission where controller_name = '$controller_name' and function_name = '$function_name'";
        $sql = $CI->db->query($sql)->result();
        //$result = $controllers."-".$v;
        return $sql;
    }

    function ByrightOf($d) {
        $CI = & get_instance();
        $sql = "select order_type from master_office_mut_type where order_type_code = '$d' ";
        $sql = $CI->db->query($sql)->row();
        //$result = $controllers."-".$v;
        return $sql;
    }

    function crop_category_code($n) {
        $CI = & get_instance();
        $sql = "select * from crop_category_code where crop_categ_code = '$n' ";
        $sql = $CI->db->query($sql)->row();
        return $sql;
    }

    function getMutationTypeObject($n) {
        $CI = & get_instance();
        $sql = "Select order_type from col8_order_type where order_type_code = '$n' ";
        $sql = $CI->db->query($sql)->row();
        return $sql;
    }
    function dagnumbr($d,$s,$c,$m,$l,$v,$p){
        $CI = & get_instance();
        $sql = "Select dag_no from petition_dag_details where dist_code ='$d' and subdiv_code='$s' and cir_code='$c' "
                . "and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and petition_no='$p' ";
        $sql = $CI->db->query($sql)->row();
        return $sql;
    }
    
    function ordinal_suffix_of($i) {
        $j = $i % 10;
        $k = $i % 100;
        if ($j == 1 && $k != 11) {
            return $i . "st";
        }
        elseif ($j == 2 && $k != 12) {
            return $i . "nd";
        }
        elseif ($j == 3 && $k != 13) {
            return $i . "rd";
        }
        else{
        return $i."th";
        }
    }

}
