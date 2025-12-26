<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlockchainUtilityClass {

    public function __construct() {

        // $this->dbswitch();
    }

    public function setSession($data) {
        foreach ($data as $key => $value) {

        }
    }



    // **** code by Masud Reza

    // check Auth user DC
    public function checkUserAuthForCaseForDc($case_no)
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $ses_dist = $CI->session->userdata['dist_code'];
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_DEPUTY_COMM)
        {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $this->db->query($sql);

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
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_DEPUTY_COMM)
        {
            $this->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $this->db->trans_rollback();
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
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_ADD_DEPUTY_COMM)
        {
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $this->db->query($sql);

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
        $ses_sub  = $CI->session->userdata['subdiv_code'];
        $ses_user = $CI->session->userdata['user_desig_code'];

        if($ses_user != MB_ADD_DEPUTY_COMM)
        {
            $this->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $this->db->trans_rollback();
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
            $this->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'  AND subdiv_code = '$ses_sub'";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $this->db->trans_rollback();
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
            $this->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$ses_dist'  AND subdiv_code = '$ses_sub'";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 0)
        {
            $this->db->trans_rollback();
            $CI->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }
    }

    // *** End code by Masud Reza





    public function getLocationFromSession() {
        $CI = & get_instance();
        $CI->load->library('session');
        $dist_code=$CI->session->userdata('dist_code');
        $CI = & get_instance();
        $this->dbswitch($dist_code);
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

    // total ganda ....for Bengali version...13/6/18

    function Total_ganda($bigha, $katha, $lessa, $ganda) {
        $total_ganda = $ganda + ($lessa*20) + ($katha * 320) + ($bigha * 6400);
        return $total_ganda;
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
        $wholeCArr = sprintf('%0.4f', $arr2);

        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        return $hec_are_care;
    }

    //--------for Bengali version 13/6/18

    function get_Hec_Are_CAre2($bigha, $katha, $lessa,$ganda) {
        $total_ganda = $ganda + ($lessa*20) + ($katha * 320) + ($bigha * 6400);
        // $totalAre = round((13.37804/6400)*$total_ganda,5);
        //  $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $centiarr = (10000 / 747) * $total_ganda;
        $hectar = $centiarr / 10000;

        $wholeHector = floor($hectar);      // 1
        $fraction1 = $hectar - $wholeHector; // .25
        $arr = 100 * $fraction1;
        $wholeArr = floor($arr);

        $fraction2 = $arr - $wholeArr;
        $arr2 = $fraction2 * 100;
        $wholeCArr = round($arr2,2);

        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        return $hec_are_care;
    }

    // ---------

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

    //-------- for Bengali version 13/6/18
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
    //----------------

    public function getDistrictName($dist_code) {

        //var_dump($this->session->all_userdata());
        //$CI->load->library('session');
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'";


        $district = $this->db->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

    public function getDistrictNamebydbload($dist_code) {
        $CI = & get_instance();

        $db = $CI->load->database($dist_code, TRUE);
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'";


        $district = $this->dbc->query("select loc_name AS district from location where dist_code ='$dist_code'  and "
            . " subdiv_code='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $district->row()->district;
    }

//function created for displaying the subdivision name
    public function getSubDivName($dist_code, $subdiv_code) {
        $CI = & get_instance();

        $this->dbswitch($dist_code);
        $subdiv = $this->db->query("select loc_name AS subdiv from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $subdiv->row()->subdiv;
    }

//function created for displaying the circle name
    public function getCircleNamebydbload($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        //$ds=$CI->session->userdata['db'];
        $circle = $this->db->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

    public function getCircleName($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $this->dbswitch($dist_code);
        $circle = $this->db->query("select loc_name AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
    }

//function created for displaying the mouza name
    public function getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $mouza = $this->db->query("select loc_name AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

//function for all the Circl
    public function getAllCircleName($dist_code, $subdiv_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $cir_code = $this->db->query("select cir_code as cir_code ,loc_name as loc_name from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code !='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'")->result();

        return $cir_code;
    }

//function created for displaying the lot No
    public function getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $lot = $this->db->query("select loc_name from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='$lot_no'");
        return $lot->row()->loc_name;
    }

    //function created for displaying the lot Name
    public function getLotLocationName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $lot = $this->db->query("select loc_name from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='$lot_no'");
        return $lot->row()->loc_name;
    }

//function created for displaying the village name
    public function getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $this->db->query("select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }

    public function getTransferType($transcode) {
        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        $data = $this->db->get_where("nature_trans_code", array('trans_code' => $transcode))->row()->trans_desc_as;
        return $data;
    }
    public function mutType($transcode) {
        $CI = & get_instance();
        // $ds=$CI->session->userdata['dist_code'];
        // $this->dbswitch($ds);
        $data = $this->db->get_where("nature_trans_code", array('trans_type' => $transcode))->result_array();
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
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
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
        //$ds=$CI->session->userdata['db'];

        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join chitha_dag_pattadar d 
            on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no 
            and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id 
            where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code'
            and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' 
            and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='0202' and d.pdar_id='$pattadar'";
//echo $q;

        $query = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join chitha_dag_pattadar d 
            on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no 
            and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id 
            where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code'
            and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' 
            and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='0202' and d.pdar_id='$pattadar'");

        return $query->row()->pdar_name;
    }

    public function get_relation($relation) {
        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        $relation = strtoLower($relation);
        $query = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$relation'";

        $relation = $this->db->query($query);
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
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        //$ds=$CI->session->userdata['db'];
        $relation = $this->db->query("select order_type from master_office_mut_type"
            . " where order_type_code = '$order'")->row()->order_type;
        return $relation;
    }

    public function getMondalsName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        $q = "select lm_name,lm_code from lm_code"
            . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
            . " and mouza_pargona_code='$m' and lot_no='$m'";

        $relation = $this->db->query("select lm_name,lm_code from lm_code"
            . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
            . " and mouza_pargona_code='$m' and lot_no='$m'")->result();

        return $relation;
    }

    public function getSKName($d, $s, $c, $name = "") {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        $q = "select user_code,username from users"
            . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
            . " ";

        if ($name != null) {
            $relation = $this->db->query("select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                . " ")->result();
        } else {
            $relation = $this->db->query("select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
                . " ")->result();
        }


        return $relation;
    }

    public function getCOName($d, $s, $c, $name = "") {

        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        //$ds=$CI->session->userdata['db'];
        if ($name != null) {
            $q = "select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                . " ";

            $relation = $this->db->query("select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$name' "
                . " ")->result();
        } else {
            $q = "select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                . " ";

            $relation = $this->db->query("select user_code,username from users"
                . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                . " ")->result();
        }

        return $relation;
    }

    public function getSelectedAssttName($d, $s, $c, $l) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
            . "user_code='$l'";

        return $CI->db->query($query)->row();
    }

    public function getSelectedMondalsName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        $db = $CI->load->database($dist_code, TRUE);
        $CI->dbc = $db;
        $query = "select lm_name,lm_code from  lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
            . "mouza_pargona_code='$m' and lot_no='$l'";

        return $CI->db->query($query)->row();
    }

    public function getDefinedSKName($d, $s, $c, $code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select user_code,username from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
            . "user_code='$code'";

        return $CI->db->query($query)->row();
    }

    public function getDefinedMondalsName($d, $s, $c, $m, $l, $code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['database'];
        $query = "select lm_name,lm_code,lmuser from lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
            . "mouza_pargona_code='$m' and lot_no='$l' and lm_code='$code'";

        return $CI->db->query($query)->row();
    }

    public function getDefinedBOName($d, $user) {
        $CI = & get_instance();
        $query = "select username,user_code from users where dist_code='$d' and user_code='$user'";
        return $CI->db->query($query)->row();
    }

    public function getSelectedSKName($d, $s, $c) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_desig_code='SK'";
        return $CI->db->query($query)->row();
    }

    public function getSelectedCOName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";

        return $CI->db->query($query)->row();
    }

    public function getSelectedASOName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";

        return $CI->db->query($query)->row();
    }

    function getSelectedRkgName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";
        return $CI->db->query($query)->row();
    }

    function getSelectedRSName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";
        return $CI->db->query($query)->row();
    }

    function getSelectedjadName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";
        return $CI->db->query($query)->row();
    }

    function getSelectedsadName($d, $s, $c, $user) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select username,user_code from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and"
            . " user_code='$user'";
        return $CI->db->query($query)->row();
    }

    public function getPdarName($d, $s, $c, $m, $l, $v, $pid, $dag) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
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
        //$ds=$CI->session->userdata['db'];
        $query = "Select cert_type from cert_type where cert_code='$cert'";
        return $CI->db->query($query)->row()->cert_type;
    }

    public function getCertCode($cert) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select cert_name_code from cert_type where cert_code='$cert'";
        return $CI->db->query($query)->row()->cert_name_code;
    }

    public function getRevenuLoc($d, $s, $c) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select rev_name from cert_revenue_location where dist_code='$d' and subdiv_code='$s' and cir_code='$c' ";
        //echo $query;
        return $CI->db->query($query)->row()->rev_name;
    }

    public function getPattaName($d) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select patta_type from patta_code where type_code='$d'";
        //echo $query;
        return $CI->db->query($query)->row()->patta_type;
    }

    public function getLandClassCode($d) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select land_type from landclass_code where class_code='$d'";
        return $CI->db->query($query)->row()->land_type;
    }

    public function getLandClasses() {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "Select * from landclass_code";
        return $CI->db->query($query)->result();
    }

    public function getLmByCode($lm_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $sql = "select lm_name,lm_code from lm_code where lm_code='$lm_code'";
        return $CI->db->query($sql)->row();
    }

    public function getSKByCode($d, $s, $c, $sk_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $sql = "select username,user_code from users where user_code='$sk_code' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' ";
        return $CI->db->query($sql)->row();
    }

    public function getCOCode($d, $s, $c, $co_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $sql = "select username,user_code from users where user_code='$co_code' and dist_code='$d' and subdiv_code='$s' and cir_code='$c'";
        return $CI->db->query($sql)->row();
    }

    public function getPattaType($code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
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
        //$ds=$CI->session->userdata['db'];
        $relation = $CI->db->query("select lm_name from lm_code"
            . " where dist_code='$d' and subdiv_code='$s' and cir_code='$c' "
            . " and mouza_pargona_code='$m' and lot_no='$l'")->row();
        return $relation;
    }

    public function EnabledMondalName($d, $s, $c, $m, $l) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $relation = $CI->db->query("SELECT * FROM lm_code as c JOIN loginuser_table as t ON c.dist_code=t.dist_code and "
            . "c.subdiv_code = t.subdiv_code and c.cir_code = t.cir_code and c.mouza_pargona_code=t.mouza_pargona_code and c.lot_no=t.lot_no "
            . "and c.lm_code = t.user_code and t.dist_code='$d' and "
            . "t.subdiv_code='$s' and t.cir_code='$c' and t.mouza_pargona_code = '$m' and t.lot_no = '$l' and t.dis_enb_option='E'")->row();
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

    function dagnumbr($d, $s, $c, $m, $l, $v, $p) {
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
        } elseif ($j == 2 && $k != 12) {
            return $i . "nd";
        } elseif ($j == 3 && $k != 13) {
            return $i . "rd";
        } else {
            return $i . "th";
        }
    }

    public function getsk_mapping($sk_code) {
        $CI = & get_instance();
        $CI->load->library('session');
        $dist_code = $CI->session->userdata('dist_code');
        $subdiv_code = $CI->session->userdata('subdiv_code');
        $cir_code = $CI->session->userdata('cir_code');
        $check_sk = $CI->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
            . "cir_code = '$cir_code' and user_code = '$sk_code' and dis_enb_option = 'E'")->row()->check_sk;
        return $check_sk;
    }

    function allote_scheme_name($id) {
        $CI = & get_instance();
        $q = "Select scheme_name_ass as name from allote_scheme_name where sid='$id'";
        $scname = $CI->db->query($q)->row()->name;
        return $scname;
    }

    function dcname($d, $u) {
        $CI = & get_instance();
        $q = "Select username as name from users where dist_code='$d' and user_code='$u'";
        $dcname = $CI->db->query($q)->row()->name;
        return $dcname;
    }

    function caste_name($id) {
        $CI = & get_instance();
        $q = "Select caste_name_ass as name from master_caste where caste_id='$id'";
        $scname = $CI->db->query($q)->row()->name;
        return $scname;
    }

    function gender($id) {
        $CI = & get_instance();
        if(intval($id)){
            $q = "Select gen_name_ass as name from master_gender where id='$id' ";
        }else{
            $q = "SElect gen_name_ass as name from master_gender where lower(short_name)=lower('$id')";
        }
        $scname = $CI->db->query($q)->row()->name;
        return $scname;
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



    function maxpattaAP($d, $s, $c, $m, $l, $v, $pp) {
        $CI = & get_instance();
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
    function getPartitionPattaType() {
        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        //$ds=$CI->session->userdata['db'];
        $sql = "Select type_code,patta_type from patta_code where mutation='a' ";
        $sql = $CI->db->query($sql)->result();
        return $sql;
    }

    function allDags($d, $s, $c, $m, $l, $v, $pno, $pc) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select * from chitha_basic where dist_code= '$d' and subdiv_code='$s' and "
            . " cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and trim(patta_no)=trim('$pno') and patta_type_code='$pc'  ";
        $sql = $CI->db->query($query)->result();
        return $sql;
    }

    function getnameByPdarId($d, $s, $c, $m, $l, $v, $pno, $pc, $id) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select pdar_name as name from chitha_pattadar where dist_code= '$d' and subdiv_code='$s' and "
            . " cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and trim(patta_no)=trim('$pno') and patta_type_code='$pc' and pdar_id='$id'  ";
        $sql = $CI->db->query($query)->row()->name;
        return $sql;
    }

    function appRelation($r) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $query = "select guard_rel_desc_as as name from master_guard_rel where guard_rel='$r' ";
        $sql = $CI->db->query($query)->row()->name;
        return $sql;
    }

    function cassnum($convnum) {
        //$nm = $convnum;
        $nm = strval($convnum);

        mb_internal_encoding('UTF-8');
        $text = html_entity_decode($nm, ENT_QUOTES, "UTF-8");
        $nn = mb_strlen($text);

        $cr = '';
        $nums = array(array('0', '০'), array('1', '১'), array('2', '২'), array('3', '৩'), array('4', '৪'), array('5', '৫'), array('6', '৬'), array('7', '৭'), array('8', '৮'), array('9', '৯'), array('.', '.'), array(',', ','), array('-', '-'), array('/', '/'), array('খ', 'খ'), array('ক', 'ক'));
        $flag = 'false';
        for ($i = 0; $i < $nn; $i++) {
            for ($j = 0; $j < 16; $j++) {
                for ($m = 0; $m < 2; $m++) {
                    if ($nm[$i] == $nums[$j][0]) {
                        $cr = $cr . $nums[$j][1];
                        $flag = 'true';
                        //$count[0]='T';
                        break;
                    }
                    if ($flag == 'true') {
                        break;
                    }
                }
            }
        }
        return $cr;
    }

    function cassnumfordags($convnum) {
        $nm = TRIM($convnum);
        $value = explode(' ',$nm);
        //echo sizeof($value);
        if(sizeof($value) > 1){
            $end = end(explode(' ',$nm));
        } else {
            $end = '';
        }


        mb_internal_encoding('UTF-8');
        $text = html_entity_decode($nm, ENT_QUOTES, "UTF-8");
        $nn = mb_strlen($text);

        $cr = '';
        $nums = array(array('0', '০'), array('1', '১'), array('2', '২'), array('3', '৩'), array('4', '৪'), array('5', '৫'), array('6', '৬'), array('7', '৭'), array('8', '৮'), array('9', '৯'), array('.', '.'), array(',', ','), array('-', '-'), array('/', '/'), array('খ', 'খ'), array('ক', 'ক'));
        $flag = 'false';
        for ($i = 0; $i < $nn; $i++) {
            for ($j = 0; $j < 16; $j++) {
                for ($m = 0; $m < 2; $m++) {
                    if ($nm[$i] == $nums[$j][0]) {
                        $cr = $cr . $nums[$j][1];
                        $flag = 'true';
                        //$count[0]='T';
                        break;
                    }
                    if ($flag == 'true') {
                        break;
                    }
                }
            }
        }
        return $cr." ".$end;
    }

    public function getMenuPermission($utility_type) {

        //echo "SELECT user_desig_code as user_desig_code FROM  user_permission where function_name = '$utility_type' ";
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $menupermission = $CI->db->query("SELECT user_desig_code as user_desig_code FROM user_permission where function_name = '$utility_type' ")->row()->user_desig_code;
        return $menupermission;
    }

    public function getBacklogPermission($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$type) {
        $CI = & get_instance();

        $backlogperission = $CI->db->query("select status as status from backlog_request where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and request_for = '$type' and operation = 'P' ")->row();

        if(empty($backlogperission)){
            $backlogperission = 'D';
        } else {
            $backlogperission = $backlogperission->status;
        }
        return $backlogperission;
    }

    public function getCountBacklogPermission($dist_code, $subdiv_code, $cir_code) {
        $CI = & get_instance();

        $backlogCountperission = $CI->db->query("select count(*) as count from backlog_request where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "operation = 'P' and status = 'P' ")->row();
        return $backlogCountperission;
    }

    public function getCountBacklogMutation($dist_code, $subdiv_code, $cir_code) {
        $CI = & get_instance();

        $qF = "select count(*) as count from field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed = 'B'";
        $qF = $CI->db->query($qF)->row()->count;

        $qP = "select count(*) as count from petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type = '03' and order_passed = 'B' and status = 'B'";
        $qP = $CI->db->query($qP)->row()->count;

        $backlogMutCount = $qF + $qP;
        return $backlogMutCount;
    }

    public function getCountBacklogPartition($dist_code, $subdiv_code, $cir_code) {
        $CI = & get_instance();

        $qF = "select count(*) as count from t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (iscorrected_inco is null or iscorrected_inco='' ) and case_no like '%-BL' ";
        $qF = $CI->db->query($qF)->row()->count;

        $qP = "Select count(*) as count from t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (iscorrected_inco is null or iscorrected_inco='') and case_no like '%-BL' and case_no not like '%CONV-BL'  ";
        $qP = $CI->db->query($qP)->row()->count;

        $backlogPartCount = $qF+$qP;
        return $backlogPartCount;
    }

    public function getCountBacklogConversion($dist_code, $subdiv_code, $cir_code) {
        $CI = & get_instance();

        $qP = "select count(*) as count from petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type = '01' and order_passed = 'B' and status = 'B'";
        $qP = $CI->db->query($qP)->row()->count;

        $backlogMutCount = $qP;
        return $backlogMutCount;
    }

    public function getRequestFor($type){
        $request_for = '';
        switch ($type) {
            case 'M':
                $request_for = 'Field / Office Mutation';
                break;
            case 'C':
                $request_for = 'Land Conversion';
                break;
            case 'P':
                $request_for = 'Field / Office Partition';
                break;
            case 'R':
                $request_for = 'Land Reclassification';
                break;
        }
        return $request_for;
    }

    function checkExistData() {
        $q = "SElect petition_no from petition_basic status='P' and dist_code=''  and subdiv_code='' and cir_code='' and mouza_pargona_code='' and 
            lot_no=''  and vill_townprt_code='' ";
        $sql = "SElect * from field_mut_basic where dist_code=''  and subdiv_code='' and cir_code='' and mouza_pargona_code='' and 
            lot_no=''  and vill_townprt_code='' and dag_no='' and patta_no='' and (petition_no in $q )";
    }


    function generateToken($claims, $time, $ttl, $algorithm, $secret) {
        $algorithms = array('HS256' => 'sha256', 'HS384' => 'sha384', 'HS512' => 'sha512');
        $header = array();
        $header['typ'] = 'JWT';
        $header['alg'] = $algorithm;
        $token = array();
        $token[0] = rtrim(strtr(base64_encode(json_encode((object) $header)), '+/', '-_'), '=');
        $claims['iat'] = $time;
        $claims['exp'] = $time + $ttl;
        $token[1] = rtrim(strtr(base64_encode(json_encode((object) $claims)), '+/', '-_'), '=');
        if (!isset($algorithms[$algorithm]))
            return false;
        $hmac = $algorithms[$algorithm];
        $signature = hash_hmac($hmac, "$token[0].$token[1]", $secret, true);
        $token[2] = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        return implode('.', $token);
    }

    function get_strike_out_status($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$vill_townprt_code,$patta_type_code,$patta_no,$pdar_id) {
        $CI = & get_instance();

        $chitha_pattadar = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)='$patta_no' "
            . "and patta_type_code='$patta_type_code' and pdar_id = '$pdar_id' and p_flag = '1' ";
        return $CI->db->query($chitha_pattadar)->row()->count;
    }
    function get_dag_no_from_dag_no_int($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$vill_townprt_code,$patta_no,$patta_type_code,$dag_no) {
        $CI = & get_instance();
        $chitha_basic = "select dag_no as c from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=TRIM('$patta_no') "
            . "and patta_type_code='$patta_type_code' and dag_no_int = '$dag_no' ";
        return $CI->db->query($chitha_basic)->row()->c;
    }
    function getNocPriv($user,$d,$s,$c){
        $CI = & get_instance();
        $q="Select usnm as c from single_sign where user_code='$user' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' ";
        $c=$CI->db->query($q)->row()->c;
        if($c!=NULL){
            return $c;
        }else{
            return 0;
        }
    }

    public function dbswitch($dist_code){
        $CI=&get_instance();
        if($dist_code == "02"){
            $this->db=$CI->load->database('dha3', TRUE);
        } else if($dist_code == "05"){
            $this->db=$CI->load->database('dha1', TRUE);
        } else if($dist_code == "10"){
            $this->db=$CI->load->database('dha24', TRUE);
        } else if($dist_code == "13"){
            $this->db=$CI->load->database('dha2', TRUE);
        }  else if($dist_code == "17"){
            $this->db=$CI->load->database('dha4', TRUE);
        }  else if($dist_code == "15"){
            $this->db=$CI->load->database('dha5', TRUE);
        }  else if($dist_code == "14"){
            $this->db=$CI->load->database('dha6', TRUE);
        }  else if($dist_code == "07"){
            $this->db=$CI->load->database('dha7', TRUE);
        }  else if($dist_code == "03"){
            $this->db=$CI->load->database('dha8', TRUE);
        }  else if($dist_code == "18"){
            $this->db=$CI->load->database('dha9', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$CI->load->database('dha13', TRUE);
        }  else if($dist_code == "24"){
            $this->db=$CI->load->database('dha10', TRUE);
        }  else if($dist_code == "06"){
            $this->db=$CI->load->database('dha11', TRUE);
        }  else if($dist_code == "11"){
            $this->db=$CI->load->database('dha12', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$CI->load->database('dha13', TRUE);
        }  else if($dist_code == "16"){
            $this->db=$CI->load->database('dha14', TRUE);
        }  else if($dist_code == "32"){
            $this->db=$CI->load->database('dha15', TRUE);
        }  else if($dist_code == "33"){
            $this->db=$CI->load->database('dha16', TRUE);
        }  else if($dist_code == "34"){
            $this->db=$CI->load->database('dha17', TRUE);
        }  else if($dist_code == "21"){
            $this->db=$CI->load->database('dha18', TRUE);
        }  else if($dist_code == "08"){
            $this->db=$CI->load->database('dha19', TRUE);
        }  else if($dist_code == "35"){
            $this->db=$CI->load->database('dha20', TRUE);
        }  else if($dist_code == "36"){
            $this->db=$CI->load->database('dha21', TRUE);
        }  else if($dist_code == "37"){
            $this->db=$CI->load->database('dha22', TRUE);
        }  else if($dist_code == "25"){
            $this->db=$CI->load->database('dha23', TRUE);
        }  else if($dist_code == "39"){
            $this->db=$CI->load->database('dha39', TRUE);
        }else if($dist_code == "38"){
            $this->db=$CI->load->database('dha25', TRUE);
        }else if($dist_code == "22"){
            $this->db=$CI->load->database('dha41', TRUE);
        }else if($dist_code == "23"){
            $this->db=$CI->load->database('dha40', TRUE);
        }
    }
    ////////////////////
    function getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag) {
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select sum(dag_revenue+dag_local_tax) as sum,dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code from chitha_basic where dist_code= '$d' and subdiv_code='$s' and cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and  trim(dag_no)=trim('$dag') group by dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code  ";
        $sql = $this->db->query($query)->row();
        return $sql;
    }
    function appRelationbyID($d,$r) {
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select guard_rel_desc_as as name from master_guard_rel where id='$r' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }
    function relationRevertBasu($d,$r){
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select guard_rel as name from master_guard_rel where id='$r' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }
    function gnderRevertBasu($d,$r){
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select short_name as name from master_gender where id='$r' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }

    function assToeng($number){
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($bn, $en, $number);
    }
    public function getGender($g) {
        $CI = & get_instance();
        $query = "Select gen_name_ass from master_gender where short_name='$g'";
        return $CI->db->query($query)->row()->gen_name_ass;
    }

    public function encryptData($src_str)
    {
        $ciphering = "AES-128-CTR";
        $encryption_iv = '1234567891011121';
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        $encryption = openssl_encrypt($src_str, $ciphering,
            ENC_KEY, $options, $encryption_iv);

        return $encryption;
    }
    ////////////
    public function getAllMouzaDetails($d,$s,$c)
    {
        $CI = &get_instance();
        $this->dbswitch($d);
        $query = "Select mouza_pargona_code,loc_name from location where 
            dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code!=? and 
            lot_no=? and vill_townprt_code=?";
        return $this->db->query($query,array($d,$s,$c,'00','00','00000'))->result();
    }
    //checking entries whether to show for update in land bank
    public function checkUpdateStatus($dist_code, $subdiv_code, $circle_code, $mouza_code,$lot_no, $vill_code, $dag_no, $flag){
        if($flag == 2){
            //update
            $status_arr = array(LAND_BANK_STATUS_APPROVED,LAND_BANK_STATUS_REVERT_BACK);
            $this->db->select("*")
                ->limit(1)
                ->order_by('id',"DESC")
                ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                ->where('cir_code', $circle_code)->where('mouza_pargona_code',$mouza_code)
                ->where('lot_no',$lot_no)
                ->where('vill_townprt_code', $vill_code)->where('dag_no',trim($dag_no))
                ->where_in('status', $status_arr)
                ->from('land_bank_details');
            $query = $this->db->get();
            //echo $this->db->last_query();
            //return count($query->result());
            if(count($query->result()) != 0){
                return true;
            }else{
                return false;
            }
        }else{
            //add
            $this->db->select("*")
                ->limit(1)
                ->order_by('id',"DESC")
                ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                ->where('cir_code', $circle_code)->where('mouza_pargona_code',$mouza_code)
                ->where('lot_no',$lot_no)
                ->where('vill_townprt_code', $vill_code)->where('dag_no',trim($dag_no))
                ->from('land_bank_details');
            $query = $this->db->get();
            if($query->num_rows() != 0){
                $lb_details = $query->result();
                //echo json_encode($lb_details[0]);
                if($lb_details[0]->status==LAND_BANK_STATUS_REVERT_BACK){
                    $this->db->select("*")
                        ->limit(1)
                        ->order_by('id',"DESC")
                        ->where('dist_code', $dist_code)->where('subdiv_code',$subdiv_code)
                        ->where('cir_code', $circle_code)->where('mouza_pargona_code',$mouza_code)
                        ->where('lot_no',$lot_no)
                        ->where('vill_townprt_code', $vill_code)->where('dag_no',trim($dag_no))
                        ->from('c_land_bank_details');
                    $query = $this->db->get();
                    $c_lb_details = $query->result();
                    if(count($c_lb_details) == 0){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return true;
            }
        }
    }
    ///////////Zonal Value 17-06-22/////////////
    public function getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $CI = &get_instance();
        $this->dbswitch($dist_code);
        $villageCode = $this->db->query("select uuid AS village from location where dist_code ='$dist_code' and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $villageCode->row()->village;
    }


    public function getVillageType($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code)
    {
        $CI = &get_instance();
        $this->dbswitch($dist_code);
        $villageType = $this->db->query("select rural_urban AS type from location where dist_code ='$dist_code' and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");
        return $villageType->row()->type;
    }


    public function getZoneName($d)
    {
        $CI = &get_instance();
        $query = "Select zone_name from zonal_master where zone_code='$d'";
        return $CI->db->query($query)->row()->zone_name;
    }

    public function getSubclassName($d)
    {
        $CI = &get_instance();
        $query = "Select subclass_name from subclass_master where subclass_code='$d'";
        return $CI->db->query($query)->row()->subclass_name;
    }

    ////////////////////////////////////////
    //session userdata validation method
    //use "00" where field is not required
    public function validateSessionUserData($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no){
        //return $_SESSION['credentials']['mouza_pargona_code'];
        if
        (
            $dist_code != $_SESSION['credentials']['dist_code']
            ||  $subdiv_code != $_SESSION['credentials']['subdiv_code']
            ||  $circle_code != $_SESSION['credentials']['cir_code']
            ||  $mouza_code != $_SESSION['credentials']['mouza_pargona_code']
            ||  $lot_no != $_SESSION['credentials']['lot_no']
        ){
            return false;
        }else{
            return true;
        }

    }
    public function getVillageNameByruralUrban($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village,rural_urban from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $this->db->query("select loc_name AS village,rural_urban from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row();
    }
    public function getEncroacherDetails($id)
    {
        $CI = &get_instance();
        $sql = "select * from c_land_bank_encroacher_details where id='$id'";
        $result  = $CI->db->query($sql);
        // var_dump($result->num_rows());
        if  ($result->num_rows() > 0)
            $result = $result->row()->fathers_name;
        else
            $result = null;
        // if ($result == true)
        // return $result->row()->fathers_name;
        // else
        // $result = null;
        //return $result->row()->fathers_name;
        return $result;

    }

    // -js- 26-09-2022
    public function get_relation_id($relation) {
        $CI = & get_instance();
        $ds=$CI->session->userdata['dist_code'];
        $this->dbswitch($ds);
        $relation = strtoLower($relation);
        $query = "select guard_rel_desc_as from master_guard_rel where id = '$relation'";

        $relation = $this->db->query($query);
        $row = $relation->num_rows;
        if ($row != 0) {
            return $relation->row()->guard_rel_desc_as;
        }

        return "unkown";
    }

    function appRelationbyIDMB2($r) {
        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
        $query = "select guard_rel_desc as name from master_guard_rel where id='$r' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }
    function RelationbyIDMB2($r) {
        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
        $query = "select guard_rel_desc as name from master_guard_rel where id='$r' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }


    public function checkUserAuthForCaseForLm($dist,$s,$c,$m,$l){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
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

    public function checkUserAuthForCaseForCo($case_no){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
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
        // $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code' AND (co_code = '$session_user_code' or co_code is null)";
        $sql = "SELECT * FROM settlement_basic WHERE case_no = '$case_no' AND dist_code = '$session_dist_code' AND subdiv_code = '$session_subdiv_code' AND cir_code = '$session_cir_code'";

        $result = $this->db->query($sql);

        if ($result->num_rows() == 0) {
            $CI->session->set_flashdata('message', "#ERRCO403303 :Unauthorized access for case no # ".$case_no);
            log_message('error', '#ERRCO403303: Falied to forward to CO '.$this->db->last_query());
            redirect(base_url() . "index.php/home");
        }

    }

    public function checkUserAuthForCaseForSk($case_no){
        $CI = & get_instance();
        $CI->load->library('session');
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
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

        $result = $this->db->query($sql);

        if ($result->num_rows() == 0) {
            $CI->session->set_flashdata('message', "#ERRCO503303 : Unauthorized access for case no # ".$case_no);
            log_message('error', '#ERRCO503303: Falied to forward to CO '.$this->db->last_query());
            redirect(base_url() . "index.php/home");
        }

    }



    public function getApplidFromCaseNo($case_no) {

        $CI = & get_instance();
        $d=$CI->session->userdata['dist_code'];
        $this->dbswitch($d);
        $applid = $this->db->query("select applid from settlement_basic where case_no ='$case_no'");
        return $applid->row()->applid;
    }
    ///////////////////
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
    function getRevenuePerBigha($d,$s,$c,$code){
        $CI = & get_instance();
        $sql1="Select dag_revenue_perbigha,dag_local_tax_min from revenue_land_class_wise where dist_code=? and subdiv_code=? and cir_code=? and class_code=? order by year_no desc, dag_revenue_perbigha desc";
        $result = $CI->db->query($sql1,array($d, $s, $c, $code));
        if($result->num_rows()>0){
            return $result->row()->dag_revenue_perbigha;
        }else{
            return null;
        }
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
    function relationByID($id){
        $CI = & get_instance();
        $query = "select guard_rel as name from master_guard_rel where id='$id' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }

    function getrelationByID($id){
        $CI = & get_instance();
        $query = "select guard_rel_desc_as as name from master_guard_rel where id='$id' ";
        $sql = $this->db->query($query)->row()->name;
        return $sql;
    }
    //function created for displaying the village name by uuid-------19122022
    public function getVillageNameByUUID($uuid) {
        $CI = & get_instance();
        // $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $village = $CI->db->query("select loc_name AS village from location where uuid = ? ",array($uuid));
        return $village->row()->village;
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


    public function getEnglishMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $mouza = $this->db->query("select locname_eng AS mouza from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $mouza->row()->mouza;
    }

    public function getEnglishVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
        $CI = & get_instance();
        $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $q = "select loc_name AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'";

        $village = $this->db->query("select locname_eng AS village from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");

        return $village->row()->village;
    }
    public function getEnglishCircleName($dist_code, $subdiv_code, $circle_code) {
        $CI = & get_instance();
        //$ds=$CI->session->userdata['db'];
        $this->dbswitch($dist_code);
        $circle = $this->db->query("select locname_eng AS circle from location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");

        return $circle->row()->circle;
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


    public function getNomineeOfSdlacMember($ucode, $dist){

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT * FROM sdlac_nominee_list       
                              WHERE sdlac_user_code=? AND district=?", array($ucode, $dist));
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




    // get all dag no
    public function getAllDagDetailsWithCaseNo($caseNo)
    {
        $CI = & get_instance();
        $sql = $CI->db->query("SELECT dag_no,total_lessa FROM settlement_premium       
                              WHERE case_no=? AND is_final=?", array($caseNo, 1));
        if ($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return false;
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

    public function getNomineeNameOfSdlacUserByUserCode($ucode) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT nominee_name FROM sdlac_nominee_list WHERE sdlac_user_code=?", array($ucode));
        if ($sql->num_rows() > 0) {
            return $sql->row()->nominee_name;
        }
        else {
            return false;
        }
    }

    public function getNomineeNameOfNomineeId($numId) {

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT nominee_name FROM sdlac_nominee_list WHERE id=?", array($numId));
        if ($sql->num_rows() > 0) {
            return $sql->row()->nominee_name;
        }
        else {
            return false;
        }
    }




    public function meetingNameById($meetingId){

        $CI = & get_instance();
        $sql = $CI->db->query("SELECT meeting_name FROM proposal_meeting_list WHERE id=?", array($meetingId));
        if ($sql->num_rows() > 0) {
            return $sql->row()->meeting_name;
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

    public function getLocationFromUUID($uuid)
    {
        $CI = & get_instance();
        $sql = $CI->db->query("SELECT l.dist_code, l.subdiv_code, l.cir_code, l.mouza_pargona_code, l.lot_no, l.vill_townprt_code,
        (SELECT loc_name AS dist_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = '00'),
        (SELECT loc_name AS subdiv_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = l.subdiv_code AND t.cir_code = '00'),
        (SELECT loc_name AS cir_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = l.subdiv_code AND t.cir_code = l.cir_code AND t.mouza_pargona_code = '00'),
        (SELECT loc_name AS mouza_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = l.subdiv_code AND t.cir_code = l.cir_code AND t.mouza_pargona_code = l.mouza_pargona_code AND t.lot_no = '00'),
        (SELECT loc_name AS lot_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = l.subdiv_code AND t.cir_code = l.cir_code AND t.mouza_pargona_code = l.mouza_pargona_code AND t.lot_no = l.lot_no AND t.vill_townprt_code = '00000'),
        (SELECT loc_name AS village_name FROM location t WHERE t.dist_code= l.dist_code AND t.subdiv_code = l.subdiv_code AND t.cir_code = l.cir_code AND t.mouza_pargona_code = l.mouza_pargona_code AND t.lot_no = l.lot_no AND t.vill_townprt_code = l.vill_townprt_code) 
        FROM location l WHERE uuid = ?", array($uuid));

        if($sql->num_rows() > 0)
        {
            return $sql->row();
        }
        else
        {
            return false;
        }



    }



    // get lm reported area by dist_code, Application no.
    public function getLmReportedAreaByDistCodeAppNo($dist_code,$applicationNo,$dagNo)
    {

        $CI = & get_instance();
        $this->dbswitch($dist_code);

        $countCaseNo = $this->db->query("select case_no from settlement_basic where applid ='$applicationNo'");

        if($countCaseNo->num_rows() > 0)
        {
            $getCaseNo = $countCaseNo->row()->case_no;

            // $appDetails = $this->db->query("select case_no,home_b,home_k,home_lc,home_g,agri_b,agri_k,agri_lc,agri_g from settlement_dag_details where dist_code = ? and case_no= ? and dag_no=?", array($dist_code,$getCaseNo,$dagNo));


            $appDetails = $this->db->query("SELECT a.case_no,a.home_b,a.home_k,a.home_lc,a.home_g,a.agri_b,a.agri_k,a.agri_lc,a.agri_g,
                                            a.s_dag_area_b,a.s_dag_area_k,a.s_dag_area_lc,a.s_dag_area_g,b.service_code 
                                            from settlement_dag_details a 
                                            JOIN settlement_basic b ON a.case_no=b.case_no
                                            WHERE a.dist_code =? AND a.case_no=? AND a.dag_no=?",
                array($dist_code,$getCaseNo,$dagNo));


            $lmArea = $appDetails->result();
            return $lmArea;
        }
        else
        {
            return $lmArea = 'NA';
        }

    }


    // get lm Case No by dist_code, Application no.
    public function getCaseNoByApplId($dist_code,$applicationNo)
    {

        $CI = & get_instance();
        $this->dbswitch($dist_code);

        $countCaseNo = $this->db->query("select case_no from settlement_basic where applid ='$applicationNo'");

        if($countCaseNo->num_rows() > 0)
        {
            $getCaseNo = $countCaseNo->row()->case_no;

        }
        else
        {
            $getCaseNo = '';
        }

        return $getCaseNo ;
    }

    public function getChithaFlag($chithaUuid, $dag_no, $chitha_flag)
    {  
        $CI = & get_instance();

        $sql = $CI->db->query('SELECT dag_id FROM chitha_dag WHERE uuid = ? AND dag_no = ?', array($chithaUuid, $dag_no));

        if($sql->num_rows() <= 0)
        {
            return false;
        }

        $dag_id = $sql->row()->dag_id;

        $sqlDaswisesql = $CI->db->query('SELECT * FROM dagwise_flag WHERE dag_id = ? AND dag_flag_master_id = ?', array($dag_id, $chitha_flag));
        
        if($sqlDaswisesql->num_rows() <= 0)
        {
            return false;
        }

        return true;

    }

    public function getChithaFlagRemarks($chithaUuid, $dag_no)
    {  
        $CI = & get_instance();

        $sql = $CI->db->query('SELECT C.remark FROM chitha_dag A 
        JOIN dagwise_flag B ON A.dag_id = B.dag_id
        JOIN chitha_dag_flag_master C ON C.id = B.dag_flag_master_id
        WHERE A.uuid = ? AND A.dag_no = ?', array($chithaUuid, $dag_no));

        if($sql->num_rows() <= 0)
        {
            return false;
        }

        return $sql->result();

    }

    public function getZonalRowFetchAndInsert($dist_code, $uuid, $dag_no, $new_dag)
    {

        $CI = &get_instance();
        $q = "select * from dagwise_zone_info where dist_code='$dist_code' and unique_village_code='$uuid' and dag_no='" . trim($dag_no) . "'";
        $zonaldata = $CI->db->query($q)->num_rows();
        if ($zonaldata > 0) {
            $zonalRow = $CI->db->query($q)->row_array();
            if (isset($zonalRow) && $zonalRow != null) {
                unset($zonalRow['dag_no']);
                unset($zonalRow['created_at']);
                unset($zonalRow['modified_at']);
                $zonalRow['dag_no'] = $new_dag;
                $zonalRow['created_at'] = date('Y-m-d H:i:s');
                $zonalRow['modified_at'] = date('Y-m-d H:i:s');
                $insertFlag = $CI->db->insert('dagwise_zone_info', $zonalRow);
                if ($insertFlag != 1) {
                    log_message('error', "#ERROR1703: " . $new_dag . " INSERTION FAILED IN TABLE dagwise_zone_info " . json_encode($zonalRow));
                    return 'N';
                } else {
                    log_message('error', "#ERROR1703: " . $new_dag . " INSERTION DONE IN TABLE dagwise_zone_info " . json_encode($zonalRow));
                    return 'Y';
                }
            }
        } else {
            return null;
        }
    }
    public function getVillageNameByUUIDEng($uuid)
    {
        $CI = &get_instance();
        // $this->dbswitch($dist_code);
        //$ds=$CI->session->userdata['db'];
        $village = $this->db->query("select locname_eng AS village from location where uuid = ? ", array($uuid));
        return $village->row()->village;
    }
    function pattaNoFromChitha($d, $s, $c, $m, $l, $v, $dag)
    {
        $CI = &get_instance();
        $q = "Select patta_no, patta_type_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
        $result = $CI->db->query($q, array($d, $s, $c, $m, $l, $v, $dag));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return null;
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

            $CI->session->set_flashdata('message', "#ERRC00299: Case Already forwarded from LM. case no : ".$case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }
    }

    public function lmAuthFirstProceedingAp($case_no)
    {
        $CI = & get_instance();

        $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer ='LM' and status = 'V'";
        
        $dataFound=$CI->db->query($sqlCheckExist)->row();
        //echo json_encode($dataFound);
        if($dataFound->c <=0){

            $CI->session->set_flashdata('message', "#ERRC0014300: Case Already forwarded from LM. case no : ".$case_no);
            redirect(base_url() . "index.php/home");
            return false;
        }
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

     public function getBasuApplIdFromCaseNo($case_no) {

        $CI = & get_instance();
        $d = $CI->session->userdata['dist_code'];
        $this->dbswitch($d);
        $applid = $this->db->query("SELECT basundhara FROM basundhar_application 
                        WHERE dharitree=?", array($case_no));
        if($applid->num_rows() <= 0){
            return $applid = '';
        }
        return 'Basundhara : '.$applid->row()->basundhara;
    }

    function getAreaCategory($d, $s, $c, $m, $l, $v, $dag) {
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select area_flag from chitha_dag_all_flag_details_final where dist_code= '$d' and subdiv_code='$s' and cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and  trim(dag_no)=trim('$dag') and status='F' ";
        $sql = $this->db->query($query);

        if($sql->num_rows() <= 0)
        {
            return false;
        }

        return $sql->row()->area_flag;
    }

    function getAreaName($d, $s, $c, $m, $l, $v, $dag) {
        $CI = & get_instance();
        $this->dbswitch($d);
        $query = "select area from chitha_dag_all_flag_details_final cd join settlement_premium_area sa on cd.area_flag = sa.paid where dist_code= '$d' and subdiv_code='$s' and cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
            . " vill_townprt_code='$v' and  trim(dag_no)=trim('$dag') and status='F' ";
        $sql = $this->db->query($query);

        if($sql->num_rows() <= 0)
        {
            // return false;
            return "Please flag this dag Area type in Chitha before proceed!!!";
        }

        return $sql->row()->area;
    }


    // count sdlac approved cases circle wise by Masud
    public function countSdlacApproveCasesCircleWise($mId,$distCode,$subCode,$cirCode,$caseStatus)
    {

        $query = "select count(sb.case_no) as tot from proposal_meeting_list pm join settlement_proposal_list spl on pm.id = spl.proposal_meeting_id
                join  settlement_proposal_cases spc on spl.id = spc.proposal_id
                join settlement_basic sb on spc.case_no = sb.case_no 
                where pm.id = '$mId' and sb.dist_code = '$distCode' and sb.subdiv_code = '$subCode'
                and sb.cir_code = '$cirCode' and spc.case_status = $caseStatus";

        $sql = $this->db->query($query);
        $caseCount = $sql->row()->tot;

        return $caseCount;
    }

     public function checkIp($ip) {
        $ip=explode('.',$ip);
        $ip=$ip[0].'.'.$ip[1].'.'.$ip[2];

        if(in_array($ip, json_decode(RESTRICT_IP))){
            return true;
        }

        else{
            return false;
        }
    }

    public function generateLocId($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code)
    {
        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_code . $lot_no . $vill_code;

        return $location_id;
    }

     public function generateGisCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code)
    {
        $gisCode = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '_' . $mouza_pargona_code . '_' . $lot_no . '_' . $vill_townprt_code;;

        return $gisCode;
    }

    public function getGeoJsonAPI($state, $gisCode, $dagNo)
    {

        $smsGatewayUrl =  BHUNAKSHA_GEOJSON_API;
        $url = $smsGatewayUrl;

        $noCompress = "true";

        // $payload = urlencode($send_data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "state=" . $state . "&giscode=" . $gisCode .  "&plotno=" . $dagNo . "&noCompress=" . $noCompress);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = $output;

        // var_dump(BHUNAKSHA_GEOJSON_API, $result, $gisCode, $state, $dagNo);
        // die;
        return $result;
    }

     public function checkPropAndChitha($user_code, $office_code, $location_id, $patta_no, $dag_no, $pattadars, $bigha, $katha, $lessa, $ganda, $ulpin, $bhunaksha_area)
    {
        $cmpFlag = null; // compare flag values  between chitha and chain (Y->data matches, N->data mismatch, NE->property does not exist in property chain, will remain 'null' if unable to connect to property chain)

        $dist_code = substr($location_id, 0, 2);
        $subdiv_code = substr($location_id, 2, 2);
        $circle_code = substr($location_id, 4, 2);
        $mouza_code = substr($location_id, 6, 2);
        $lot_no = substr($location_id, 8, 2);
        $vill_code = substr($location_id, 10, 5);

        $get_prop_data =  $this->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no, $patta_no, $user_code, $office_code, $ulpin);

        $result = json_decode($get_prop_data);
        $oldulpin = '';


        // echo "<pre>";
        // var_dump($result);
        // die;
        // !!!!!!!!!!!!! chitha area and bhunaksha area comparision !!!!!!!!!!!!
        // convert the area and then compare
        // var_dump($bhunaksha_area);
        // die;
        if ($bhunaksha_area != null) {
            $bhu_area = explode('-', $bhunaksha_area);
            $bhu_total_lessa = $bhu_area[0] * 100 + $bhu_area[1] * 20 + number_format((float)$bhu_area[2], 4, '.', '');
            $chitha_total_lessa = $bigha * 100 + $katha * 20 + number_format((float)$lessa, 4, '.', '');
            // var_dump($bhunaksha_area, $bhu_total_lessa, $chitha_total_lessa);
            // die;
            if ($bhu_total_lessa == $chitha_total_lessa)
                $bhu_message = "1_Chitha area and bhunaksha area matching";
            else
                $bhu_message = "0_Chitha area and bhunaksha area not matching_" . $bhunaksha_area . "_$bigha-$katha-$lessa";
        } else {
            $bhu_message = "0_Bhunaksha area not found_0_$bigha-$katha-$lessa";
            // echo $bhu_message;
        }
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if ($result != null) {
            $chain_prop_data = json_decode($result->property_data);

            if ($result->result == 1) {
                $chainCmpArray = array();
                foreach ($chain_prop_data->pid as $chain) {
                    $nested = array(
                        'pdarid' => $chain->pdarid,
                        'pdarname' => trim($chain->pdarname),
                        'pdarfather' => trim($chain->pdarfather),
                        'pdarstrikeout' => trim($chain->pdarstrikeout)
                    );

                    $chainCmpArray[] = $nested;
                }

                $key_chain = array_column($chainCmpArray, 'pdarid');
                array_multisort($key_chain, SORT_ASC, $chainCmpArray);

                $chithaCmpArray = array();
                foreach ($pattadars as $chitha) {
                    $nested2 = array(
                        'pdarid' => $chitha->pdar_id,
                        'pdarname' => trim($chitha->pdar_name),
                        'pdarfather' => trim($chitha->pdar_father),
                        'pdarstrikeout' => trim($chitha->p_flag)

                    );
                    $chithaCmpArray[] = $nested2;
                }

                $key_chitha = array_column($chithaCmpArray, 'pdarid');
                array_multisort($key_chitha, SORT_ASC, $chithaCmpArray);


                $chainArea = array(
                    "bigha" => $chain_prop_data->bigha,
                    "katha" => $chain_prop_data->katha,
                    "lessa" => number_format((float)$chain_prop_data->lessa, 4, '.', ''),
                    // "ganda" => $chain_prop_data->ganda
                );

                $chithaArea = array(
                    "bigha" => $bigha,
                    "katha" => $katha,
                    "lessa" => number_format((float)$lessa, 4, '.', ''),
                    // "ganda" => $ganda,
                );


                if (isset($chain_prop_data->oldulpin)) {
                    $oldulpin = $chain_prop_data->oldulpin;
                } else {
                    $oldulpin = "";
                }



                $encodedChithaArea = base64_encode(json_encode($chithaArea));
                $encodedChainArea = base64_encode(json_encode($chainArea));
                $encodedChitha = base64_encode(json_encode($chithaCmpArray));
                $encodedChain = base64_encode(json_encode($chainCmpArray));
                // echo "<pre>";
                // var_dump($encodedChithaArea, $encodedChainArea);
                // die;
                if ($encodedChitha == $encodedChain &&  $encodedChithaArea == $encodedChainArea) {
                    $cmpFlag = "Y";
                    // $message = "<b><h4 class = 'bg-green text-white text-center' style='padding:4px;'><span><i class='fa fa-check'></i></span> Chitha data and property chain data is matching.</h4></b>";
                    $message = "<ul><li>Chitha data and property chain data is matching.</li><li>Spatial data of property chain and bhunaksha are matching</li><ul>";
                } else {
                    $cmpFlag = 'N';
                    // $message = "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class = 'fa fa-close'></i></span> There is a mismatch between chitha data and property chain data. This order cannot be passed</h4></b></p>";
                    $message = "There is a mismatch between chitha data and property chain data. This order cannot be passed";
                }
            } elseif ($result->result ==  0 && $result->error_code == "06102") {
                $cmpFlag = 'NE';
                // $message = "<b><h4 class = 'bg-warning text-white text-center' style='padding:4px;'><i class = 'fa fa-plus'></i> Property Chain Data does not exists. Please add the asset.</h4></b>";
                $message = "Property Chain Data does not exists. Please add the asset.";
            } else {
                // $message = "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-warning'></i></span> Unable to connect to property chain.</h4></b></p>";
                $message = "Unable to connect to property chain.";
            }
        } else {
            $message = "Unable to connect to property chain.";
        }

        $result = array(
            'compareFlag' => $cmpFlag,
            'message' => $message,
            'ulpin' => $ulpin,
            'oldulpin' => $oldulpin,
            'bhu_chitha_area_cmp_status' => $bhu_message
        );
        // var_dump($result);
        // die;
        // return $cmpFlag;
        return $result;
    }


    public function fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no, $patta_no, $user_code, $office_code, $ulpin)
    {
        // var_dump($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dag_no, $patta_no, $user_code, $office_code, $ulpin);

        $location_id = $dist_code . $subdiv_code . $circle_code . $mouza_code . $lot_no . $vill_code;
        // echo $location_id;

        $smsGatewayUrl =  PROP_CHAIN_API_NEW_V2 . "fetch.php";

        $send_data = array(
            "type" => LOC_TYPE_RURAL,
            "village_code" => $vill_code,
            "ulpin" => $ulpin,
            "office_code" => $office_code,
            "user_code" => $user_code,

        );

        // var_dump($send_data);
        // die;
        $payload = json_encode($send_data);

        $url = $smsGatewayUrl;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output);
        // var_dump($output);
        // die;
        if ($result != null) {
            if ($result->success == 1) {
                $property_data = base64_decode($result->decrypted->propertyData);
                $transactionDetails = $result->decrypted->txnRefList;
                $property_id = $result->decrypted->propertyId;
            } else {
                $property_data = '';
                $transactionDetails = '';
                $property_id = '';
            }

            $data = array(
                'result' => $result->success,
                'error_code' => $result->error_code,
                'error_msg' => $result->error_msg,
                'property_id' => $property_id,
                'property_data' => $property_data,
                'transaction_data' => $transactionDetails,
                'json_output' => $output
            );
        } else {
            $data = null;
        }

        // print_r($transactionDetails);
        // die;



        // print_r($data);
        // die;
        return json_encode($data);
    }


     public function generatePropertyId($loc_type, $village_code,  $patta_no, $dag_no, $ulpin)
    {
        // $property_id = $loc_type . '-' . $village_code . '-' . $patta_no . '-' . $dag_no . '-' . $ulpin;
        $property_id = $loc_type . '-' . $village_code . '-' . $ulpin;


        return $property_id;
    }

    public function getPropTransData($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId)
    {
        $smsGatewayUrl =  PROP_CHAIN_API_NEW_V2 . "get_transaction.php";
        $send_data = array(
            "office_code" => $office_code,
            "user_code" => $user_code,
            "propertyid" => $propertyId,
            "data" => $prop_data,
            "certmnemonic" => $certmnemonic,
            "referenceid" => $referenceId
        );

        $payload = json_encode($send_data);
        // echo "<pre>";
        // var_dump($send_data);
        $url = $smsGatewayUrl;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output);
        // var_dump($result);
        // die;
        return $result;
    }

    public function checkUlpin($gisCode, $state, $dag)
    {
        $checkUlpin = $this->getUlpin($gisCode, $state, $dag);
        // var_dump($checkUlpin);
        // die;
        $ulpinDetail = json_decode($checkUlpin);
        // var_dump($ulpinDetail);
        // die;
        if (!empty($ulpinDetail) && !isset($ulpinDetail->Status)) {
            if ($ulpinDetail->PNIU == null)
                $result = array(
                    'success' => 0,
                    // 'message' => "<b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-close'></i></span> Ulpin not found for the property. This order cannot be passed</h4></b>"
                    'message' => "Ulpin not found for the property. This order cannot be passed"

                );
            elseif ($ulpinDetail->PNIU != null)
                $result = array(
                    'success' => 1,
                    // 'message' => "<b><h4 class = 'bg-green text-white text-center' style='padding:4px;'><span><i class='fa fa-check'></i></span> Ulpin found for the property.</h4></b>",
                    'message' => "Ulpin found for the property.",

                    'ulpin' => $ulpinDetail->PNIU
                );
        } elseif (empty($ulpinDetail) || $ulpinDetail->Status == 'No Data Found') {
            $result = array(
                'success' => 0,
                // 'message' => "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class = 'fa fa-close'></i></span> Ulpin not found for the property. This order cannot be passed</h4></b></p>"
                'message' => "Ulpin not found for the property. This order cannot be passed"

            );
        } else {
            $result = array(
                'success' => 0,
                // 'message' => "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-warning'></i></span> Unable to connect to Bhunaksha API.</h4></b></p>"
                'message' => "Unable to connect to Bhunaksha API."

            );
        }

        return $result;
    }

    public function getUlpin($gisCode, $state, $dag)
    {
        $smsGatewayUrl =  BHUNAKSHA_API_ULPIN;
        $url = $smsGatewayUrl;

        // $payload = urlencode($send_data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "giscode=" . $gisCode . "&state=" . $state . "&kide=" . $dag);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = $output;

        // var_dump($result, $gisCode, $state, $dag);
        // die;
        return $result;
    }

    public function getCreatePropArray($pattadar_details, $location_id, $patta, $dag, $land_class_code, $patta_type_code, $bigha, $katha, $lessa, $ulpin, $old_ulpin, $revenue, $local_tax, $ganda)
    {

        $chain_pattadar = array();
        foreach ($pattadar_details as $pattadar) {
            // var_dump($pattadar->p_flag);
            // die;
            $nestedData = array(
                'pdarid' => $pattadar->pdar_id,
                'pdarname' => $pattadar->pdar_name,
                'pdarfather' => $pattadar->pdar_father,
                'pdarstrikeout' => $pattadar->p_flag
            );
            $chain_pattadar[] = $nestedData;
        }
        if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 0)
        {
            $revenue = '0.00';
            $local_tax = '0.00';
        }
        $property_data = array(
            "ulpin" => $ulpin,
            "oldulpin" => $old_ulpin,
            "location" => $location_id,
            "dagno" => $dag,
            "pattano" => $patta,
            "pattatype" => $patta_type_code,
            "landclass" => $land_class_code,
            "revenue" => $revenue,
            "localtax" => $local_tax,
            "bigha" => strval($bigha),
            "katha" => strval($katha),
            "lessa" => strval($lessa),
            "ganda" => strval($ganda),
            "pid" => $chain_pattadar
        );
        // var_dump($property_data);
        return $property_data;
    }


    public function getCreateChainArray($property_data, $propertyId, $property_sign, $property_sign_key, $certificate)
    {
        $property_record =   array(
            "propertyid" => $propertyId,
            'certificate' => $certificate,
            "property_data" => $property_data,
            "propertysignature" => $property_sign,
            "propertysignerkey" => $property_sign_key
        );

        return $property_record;
    }

    public function validatePropJson($json_update_data)
    {
        $update_data = json_decode($json_update_data, true);

        $temp_data = $update_data;

        $prop_data_position = array_search('property_data', array_keys($temp_data)); // get property_data index position
        $splice_property_data = array_splice($temp_data, $prop_data_position); // splice the array at property_data index position
        $property_data = $splice_property_data['property_data']; //get property data array

        $pattadar_data_pos = array_search('pid', array_keys($property_data)); // get pid index position
        $splice_pattadar_data = array_splice($property_data, $pattadar_data_pos); // splice the array at pid index position
        $pattadar_data = $splice_pattadar_data['pid']; //get pattadars data array

        // check null values
        $check_null_1 = array_search(null, $temp_data, true);
        $check_null_2 = array_search(null, $property_data, true);
        $check_null_3 = false;
        foreach ($pattadar_data as $pattadar) { //check null values for pattadar data array
            $check_null_pattadar = array_search(null, $pattadar, true);
            if ($check_null_pattadar != false) {
                $check_null_3 = $check_null_pattadar;
                break;
            }
        }

        if ($check_null_1 === false && $check_null_2 === false && $check_null_3 === false)
            return true;
        else
            return false;
    }

    public function getMapUpdateArrayN($map_data)
    {
        $chain_pattadar = array();
        foreach ($map_data->pattadar_details as $pattadar) {
            if (isset($pattadar->pdar_id) && isset($pattadar->pdar_name) && isset($pattadar->pdar_father) && isset($pattadar->p_flag))
                $nestedData = array(
                    'pdarid' => $pattadar->pdar_id,
                    'pdarname' => $pattadar->pdar_name,
                    'pdarfather' => $pattadar->pdar_father,
                    'pdarstrikeout' => $pattadar->p_flag
                );
            else
                $nestedData = array(
                    'pdarid' => $pattadar->pdarid,
                    'pdarname' => $pattadar->pdarname,
                    'pdarfather' => $pattadar->pdarfather,
                    'pdarstrikeout' => $pattadar->pdarstrikeout
                );
            $chain_pattadar[] = $nestedData;
        }

        $map_property_data['ulpin'] = $map_data->ulpin;
        $map_property_data['oldulpin'] = $map_data->old_ulpin;

        $map_property_data['location'] = $map_data->location_id;
        $map_property_data['dagno'] = $map_data->dag_no;
        $map_property_data['pattano'] = $map_data->patta_no;
        $map_property_data['pattatype'] = $map_data->patta_type_code;
        $map_property_data['landclass'] = $map_data->land_class_code;
        $map_property_data['revenue'] = $map_data->revenue;
        $map_property_data['localtax'] = $map_data->local_tax;
        $map_property_data['bigha'] = strval($map_data->bigha_chain);
        $map_property_data['katha'] = strval($map_data->katha_chain);
        $map_property_data['lessa'] = strval($map_data->lessa_chain);
        $map_property_data['ganda'] = strval($map_data->ganda_chain);
        $map_property_data['state'] = ASSAM_STATE_CODE;
        $map_property_data['geomtype'] = $map_data->geomType;
        $map_property_data['pid'] = $chain_pattadar;
        $map_property_data['mapcord'] = array(
            'coordinates' => $map_data->geo_json
        );


        $map_send_data = array(
            "property_id" =>    $map_data->property_id,
            "reference_id" =>  $map_data->reference_id,
            "certmnemonic" =>  $map_data->certmnemonic,
            "previous_hash" => $map_data->previous_hash,
            "property_signature" =>  $map_data->property_signature,
            "property_signer_key" =>  $map_data->property_signer_key,
            "office_code" =>   $map_data->office_code,
            "user_code" =>  $map_data->user_code,
            "property_data" => $map_property_data
        );

        return $map_send_data;
    }

    public function propChainCreateApiBulk_old($property_records, $user_code, $office_code)
    {
        $smsGatewayUrl =  PROP_CHAIN_API_NEW_V2 . "create.php";



        $send_data = array(
            "office_code" => $office_code,
            "user_code" => $user_code,
            "records" => $property_records
        );
        // echo "<pre>";
        // print_r($send_data);
        // var_dump($send_data);
        // die;
        $payload = json_encode($send_data);
        // echo "<pre>";
        // print_r($payload);
        // die;

        $url = $smsGatewayUrl;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // test output
        // $output = '{"success":1,"transaction_id":"f8652b1e5cfd58fcb1b6e0096de95ee92e82ac015fe749179e915dc9061482f0","message":"Asset created successfully with transaction Id: f8652b1e5cfd58fcb1b6e0096de95ee92e82ac015fe749179e915dc9061482f0","valid_list":"\"\"","invalid_list":"","timestamp":"14-03-2023 16:05:20","error_code":"","error_msg":""}';

        $result = json_decode($output);
        if ($result->success == 0 || $result->success == 2) {
            log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code . ". Send data: " . $payload);
        }

        // var_dump($output);
        // die;

        return $result;
    }

    public function propChainCreateApiBulk($property_records, $user_code, $office_code)
    {
        $smsGatewayUrl =  PROP_CHAIN_API_NEW_V2 . "create.php";
        $send_data = array(
            "office_code" => $office_code,
            "user_code" => $user_code,
            "records" => $property_records
        );
        // echo "<pre>";
        // print_r($send_data);
        // var_dump($send_data);
        // die;
        $payload = json_encode($send_data);
        log_message('error','ChainDataLogPayloadROR-------'.json_encode($payload));
        // echo "<pre>";
        // print_r($payload);
        // die;
        $url = $smsGatewayUrl;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode == 200){
            //return "curl successfull";
            // test output
            // $output = '{"success":1,"transaction_id":"f8652b1e5cfd58fcb1b6e0096de95ee92e82ac015fe749179e915dc9061482f0","message":"Asset created successfully with transaction Id: f8652b1e5cfd58fcb1b6e0096de95ee92e82ac015fe749179e915dc9061482f0","valid_list":"\"\"","invalid_list":"","timestamp":"14-03-2023 16:05:20","error_code":"","error_msg":""}';
            $result = json_decode($output);
            if(!isset($result->success) || empty($result->success)){
                log_message('error', '#PCBPAE001, api response error for '. $payload);
                return ['result'=>false, 'response'=>"Internal Server Error, Error-Code:#PCBPAE001"];                 
            }
            
            if ($result->success == 0 || $result->success == 2) {
                log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code . ". Send data: " . $payload);
            }
            return ['result'=>true, 'response'=>$result]; 
        }else{
            log_message("error", "#PCBPAE002, Curl Error(200) In Api ".$smsGatewayUrl);
            return ['result'=>false, 'response'=>"Block Chain Server Error..Please Try Again, Error-Code-#PCBPAE002"]; 
        }
    }

    public function propertyChainUpdateApi($send_data)
    {

        $smsGatewayUrl = PROP_CHAIN_API_NEW_V2 . "update.php";

        $payload = json_encode($send_data);

        log_message('error','ChainMapDataPayload---------------'.json_encode($payload));
        // $payload = $send_data;

        // echo "<pre>";
        // var_dump($payload);
        // die;

        $url = $smsGatewayUrl;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // test output
        // $output = '{"success":1,"transaction_id":"685326ac180f00d07dc41cfdf3e553e199699387f950fb6648a6ebe79cef6e62","message":"Asset updated successfully with transaction Id: 685326ac180f00d07dc41cfdf3e553e199699387f950fb6648a6ebe79cef6e62","timestamp":"15-03-2023 11:33:27","error_code":"","error_msg":""}';

        $result = json_decode($output);

        if ($result->success == 0) {
            log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code);
        }

        // var_dump($output);
        // die;
        return $result;
    }

    
    public function getUpdateChainArrayN($update_data)
    {
        //* parameters that are not applicable for a particular process send them as empty string
        $chain_pattadar = array();
        foreach ($update_data->pattadar_details as $pattadar) {

            $nestedData['pdarid'] = $pattadar->pdar_id;
            $nestedData['pdarname'] = trim($pattadar->pdar_name);
            $nestedData['pdarfather'] = trim($pattadar->pdar_father);
            // if ($pattadar->p_flag == null)
            //     $nestedData['pdarstrikeout'] = "0";
            // else
            $nestedData['pdarstrikeout'] = $pattadar->p_flag;

            $chain_pattadar[] = $nestedData;
        }

        $chain_property_data['ulpin'] = $update_data->ulpin;
        $chain_property_data['oldulpin'] = $update_data->old_ulpin;

        $chain_property_data['location'] = $update_data->location_id;
        $chain_property_data['dagno'] = $update_data->dag_no;
        $chain_property_data['pattano'] = $update_data->patta_no;

        if ($update_data->certmnemonic == 'PRT' || $update_data->certmnemonic == 'BLP') {
            $chain_property_data['newdagno'] = $update_data->new_dag_no;
            $chain_property_data['newpattano'] = $update_data->new_patta_no;
        }

        $chain_property_data['pattatype'] = $update_data->patta_type_code;
        $chain_property_data['landclass'] = $update_data->land_class_code;

        if ($update_data->certmnemonic == 'PRT' || $update_data->certmnemonic == 'BLP') {
            $chain_property_data['revenue'] = $update_data->old_revenue;
            $chain_property_data['localtax'] = $update_data->old_local_tax;
        } else {
            $chain_property_data['revenue'] = $update_data->revenue;
            $chain_property_data['localtax'] = $update_data->local_tax;
        }

        if ($update_data->certmnemonic == 'REC') {
            $chain_property_data['oldlandclass'] = $update_data->old_land_class_code;
            $chain_property_data['oldrevenue'] = $update_data->old_revenue;
            $chain_property_data['oldlocaltax'] = $update_data->old_local_tax;
        }

        if ($update_data->certmnemonic == 'PRT' || $update_data->certmnemonic == 'BLP') {
            $chain_property_data['newrevenue'] = $update_data->revenue;
            $chain_property_data['newlocaltax'] = $update_data->local_tax;
        }


        $chain_property_data['bigha'] = strval($update_data->bigha_chain);
        $chain_property_data['katha'] = strval($update_data->katha_chain);
        $chain_property_data['lessa'] = strval($update_data->lessa_chain);
        $chain_property_data['ganda'] = strval($update_data->ganda_chain);
        if ($update_data->certmnemonic == 'PRT' || $update_data->certmnemonic == 'BLP') {
            $chain_property_data['newbigha'] = strval($update_data->new_bigha);
            $chain_property_data['newkatha'] = strval($update_data->new_katha);
            $chain_property_data['newlessa'] = strval($update_data->new_lessa);
            $chain_property_data['newganda'] = strval($update_data->new_ganda);
        }
        $chain_property_data['pid'] = $chain_pattadar;

        // ##################### get previous property data and sha512 hash the data #################
        $dist_code = substr($update_data->location_id, 0, 2);
        $subdiv_code = substr($update_data->location_id, 2, 2);
        $circle_code = substr($update_data->location_id, 4, 2);
        $mouza_code = substr($update_data->location_id, 6, 2);
        $lot_no = substr($update_data->location_id, 8, 2);
        $vill_code = substr($update_data->location_id, 10, 5);
        $fetch_prop_data =  $this->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $update_data->dag_no, $update_data->patta_no,  $update_data->user_code,  $update_data->office_code, $update_data->ulpin);


        $chain_data = json_decode($fetch_prop_data);
        $previous_prop_data = json_decode($chain_data->property_data, true);
        $previous_hash = hash('sha512', base64_encode(json_encode($previous_prop_data)));
        // #############################################################################################
        // echo "<pre>";
        // if (isset($previous_prop_data['mapcord']) || isset($previous_prop_data['geomtype']) || isset($previous_prop_data['state'])) {
        //     unset($previous_prop_data['mapcord']);
        //     unset($previous_prop_data['geomtype']);
        //     unset($previous_prop_data['state']);
        // }
        // var_dump($previous_hash);
        // die;
        $chain_send_data = array(
            "property_id" =>    $update_data->property_id,
            "reference_id" =>  $update_data->reference_id,
            "certmnemonic" =>  $update_data->certmnemonic,
            "property_signature" =>  $update_data->property_signature,
            "property_signer_key" =>  $update_data->property_signer_key,
            "office_code" =>   $update_data->office_code,
            "user_code" =>  $update_data->user_code,
            "previous_hash" => $previous_hash,
            "property_data" => $chain_property_data
        );
        // echo "<pre>";
        // var_dump($chain_send_data);
        // die;
        return $chain_send_data;
    }

    public function getConvChainArrayN($update_data)
    {
        $chain_pattadar = array();
        foreach ($update_data->pattadar_details as $pattadar) {
            $nestedData = array(
                'pdarid' => $pattadar->pdar_id,
                'pdarname' => $pattadar->pdar_name,
                'pdarfather' => $pattadar->pdar_father,
                'pdarstrikeout' => $pattadar->p_flag
            );
            $chain_pattadar[] = $nestedData;
        }

        $chain_property_data['ulpin'] = $update_data->ulpin;
        $chain_property_data['oldulpin'] = $update_data->old_ulpin;

        $chain_property_data['location'] = $update_data->location_id;
        $chain_property_data['dagno'] = $update_data->dag_no;
        $chain_property_data['pattano'] = $update_data->patta_no;
        $chain_property_data['pattatype'] = $update_data->patta_type_code;
        $chain_property_data['newdagno'] = $update_data->new_dag_no;
        $chain_property_data['newpattano'] = $update_data->new_patta_no;
        $chain_property_data['newpattatype'] = $update_data->new_patta_type_code;
        $chain_property_data['landclass'] = $update_data->land_class_code;
        $chain_property_data['revenue'] = $update_data->old_revenue;
        $chain_property_data['localtax'] = $update_data->old_local_tax;
        $chain_property_data['newrevenue'] = $update_data->new_revenue;
        $chain_property_data['newlocaltax'] = $update_data->new_local_tax;

        $chain_property_data['bigha'] = strval($update_data->bigha_chain);
        $chain_property_data['katha'] = strval($update_data->katha_chain);
        $chain_property_data['lessa'] = strval($update_data->lessa_chain);
        $chain_property_data['ganda'] = strval($update_data->ganda_chain);
        $chain_property_data['pid'] = $chain_pattadar;

        // ##################### get previous property data and sha512 hash the data #################
        $dist_code = substr($update_data->location_id, 0, 2);
        $subdiv_code = substr($update_data->location_id, 2, 2);
        $circle_code = substr($update_data->location_id, 4, 2);
        $mouza_code = substr($update_data->location_id, 6, 2);
        $lot_no = substr($update_data->location_id, 8, 2);
        $vill_code = substr($update_data->location_id, 10, 5);
        $fetch_prop_data =  $this->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $update_data->dag_no, $update_data->patta_no,  $update_data->user_code,  $update_data->office_code, $update_data->ulpin);


        $chain_data = json_decode($fetch_prop_data);
        $previous_prop_data = json_decode($chain_data->property_data, true);
        $previous_hash = hash('sha512', base64_encode(json_encode($previous_prop_data)));
        // #############################################################################################

        $chain_send_data = array(
            "property_id" =>    $update_data->property_id,
            "reference_id" =>  $update_data->reference_id,
            "certmnemonic" =>  $update_data->certmnemonic,
            "property_signature" =>  $update_data->property_signature,
            "property_signer_key" =>  $update_data->property_signer_key,
            "office_code" =>   $update_data->office_code,
            "user_code" =>  $update_data->user_code,
            "previous_hash" => $previous_hash,
            "property_data" => $chain_property_data
        );

        return $chain_send_data;
    }

    public function propertyChainBulkUpdateApi($pay_load){

        //*******************************************************************/
        //dummy sample
        // $data2["success"] = 2;
        // $data2["transaction_id"]= "AS01568461";
        // $data2["message"]= "No of new assets updated: 0. No of invalid updates: 1";
        // $data2["valid_list"][0]= (object) array(
        //     'referenceId' => "VALID/PAT/2023-24/202300011758/FPART",
        //     'propertyId' => "R-10001-84EY10E5R74NH0",
        //     'certMnemonic' => "MUT"
        // );
        
        // $data2["invalid_list"][0] = (object) array(
        //     'referenceId' => "INVALID/PAT/2023-24/202300011758/FPART",
        //     'propertyId' => "R-10001-84EY10E5R74NH0",
        //     'errorCode' => "04109",
        //     'errorMsg' => "reference Id DAR/PAT/2023-24/202300011758/FPART with this property id R-10001-84EY10E5R74NH0 already exists",
        // );

        // $data2["timestamp"]= "28-12-2023 15:38:59";
        // $data2["error_code"]= "04109";
        // $data2["error_msg"]= "reference Id DAR/PAT/2023-24/202300011758/FPART with this property id R-10001-84EY10E5R74NH0 already exists";
        // return ['result'=>true, 'response'=>(object) $data2];             
        //*******************************************************************/
        $url = PROP_CHAIN_API_NEW_V2."update_bulk.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pay_load);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result = json_decode($output);
        //return $result;
        if($httpcode == 200){
            //return "curl successfull";
            return ['result'=>true, 'response'=>$result]; 
        }else{
            log_message("error", "#PCBUAE0001, Curl Error(200) In Api ".PROP_CHAIN_API_NEW_V2."update_bulk.php");
            return ['result'=>false, 'response'=>$result]; 
        }
    }


}
