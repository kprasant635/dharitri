<?php

class MisReportModelPartha extends CI_Model {

    public function getAgri($dist_code, $subdiv_code, $circle_code, $mouza_code, $year1, $year2) {
        $db=  $this->session->userdata('db');
        $start    = new DateTime($year1);
        $end      = new DateTime($year2);
        $interval = DateInterval::createFromDateString('1 year');
        $period   = new DatePeriod($start, $interval, $end);
        $arrData["data"] = array();
        foreach ($period as $dt) {
            
            $start_year=$dt->format("Y")."-01"."-01";
            $end_year=$dt->format("Y")."-12"."-31";
            
            $rs_crop = $this->db->query("select to_char(date_entry,'YYYY')AS dates,SUM(crop_land_area_b) AS bigha, SUM(crop_land_area_k) AS kotha, SUM(crop_land_area_lc) AS lesa from   chitha_mcrop where dist_code ='$dist_code' and "
                . " subdiv_code ='$subdiv_code' and cir_code = '$circle_code' and "
                . " mouza_pargona_code = '$mouza_code' and date_entry between '$start_year' and '$end_year' group by to_char(date_entry,'YYYY') order by to_char(date_entry,'YYYY') ASC");

            $rs_result = $rs_crop->row();
            $count = sizeof($rs_result);

            if($count == '0')
            {
                $bigha = '-';
                $Kotha = '-';
                $lesa = '-';
            }
            else
            {
                $bigha = $rs_result->bigha;
                $Kotha = $rs_result->kotha;
                $lesa = $rs_result->lesa;
            }
            array_push($arrData["data"], array(
                    "dates" => $dt->format("Y"),
                    "bigha" => $bigha,
                    "kotha" => $Kotha,
                    "lesa" => $lesa
                        )
                );
        }
        return $arrData["data"];
    }

    public function getNonAgri($dist_code, $subdiv_code, $circle_code, $mouza_code, $year1, $year2) {
        $db=  $this->session->userdata('db');
        $start    = new DateTime($year1);
        $end      = new DateTime($year2);
        $interval = DateInterval::createFromDateString('1 year');
        $period   = new DatePeriod($start, $interval, $end);
        $arrData["data"] = array();
        foreach ($period as $dt) {
            
            $start_year=$dt->format("Y")."-01"."-01";
            $end_year=$dt->format("Y")."-12"."-31";
            
            $noncrop = $this->db->query("select to_char(date_entry,'YYYY')AS dates,SUM(noncrop_land_area_b) AS bigha, SUM(noncrop_land_area_k) AS kotha, SUM(noncrop_land_area_lc) AS lesa from   chitha_noncrop where dist_code ='$dist_code' and "
                . " subdiv_code ='$subdiv_code' and cir_code = '$circle_code' and "
                . " mouza_pargona_code = '$mouza_code' and date_entry between '$start_year' and '$end_year' group by to_char(date_entry,'YYYY') order by to_char(date_entry,'YYYY') ASC");
        
            $rs_result = $noncrop->row();
            $count = sizeof($rs_result);

            if($count == '0')
            {
                $bigha = '-';
                $Kotha = '-';
                $lesa = '-';
            }
            else
            {
                $bigha = $rs_result->bigha;
                $Kotha = $rs_result->kotha;
                $lesa = $rs_result->lesa;
            }
            array_push($arrData["data"], array(
                    "dates" => $dt->format("Y"),
                    "bigha" => $bigha,
                    "kotha" => $Kotha,
                    "lesa" => $lesa
                        )
                );
        }
        return $arrData["data"];
        
    }
    
    public function GetAgriNonAgriGraph($dist_code, $subdiv_code, $circle_code, $mouza_code, $year1, $year2){
		$db=  $this->session->userdata('db');
        $start    = new DateTime($year1);
        $end      = new DateTime($year2);
        $interval = DateInterval::createFromDateString('1 year');
        $period   = new DatePeriod($start, $interval, $end);
        $arrData["data"] = array();
        foreach ($period as $dt) {
            
            $start_year=$dt->format("Y")."-01"."-01";
            $end_year=$dt->format("Y")."-12"."-31";
            
            $noncrop = $this->db->query("select to_char(date_entry,'YYYY')AS dates,SUM(noncrop_land_area_b) AS bigha, SUM(noncrop_land_area_k) AS kotha, SUM(noncrop_land_area_lc) AS lesa from   chitha_noncrop where dist_code ='$dist_code' and "
                . " subdiv_code ='$subdiv_code' and cir_code = '$circle_code' and "
                . " mouza_pargona_code = '$mouza_code' and date_entry between '$start_year' and '$end_year' group by to_char(date_entry,'YYYY') order by to_char(date_entry,'YYYY') ASC");
            
            $rs_result = $noncrop->row();
            $count = sizeof($rs_result);
            if(($count == '0'))
            {
                $bigha_N = '0';
            }
            else
            {
                $bigha_N = $rs_result->bigha;
            }
            
            $rs_crop = $this->db->query("select to_char(date_entry,'YYYY')AS dates,SUM(crop_land_area_b) AS bigha, SUM(crop_land_area_k) AS kotha, SUM(crop_land_area_lc) AS lesa from   chitha_mcrop where dist_code ='$dist_code' and "
                . " subdiv_code ='$subdiv_code' and cir_code = '$circle_code' and "
                . " mouza_pargona_code = '$mouza_code' and date_entry between '$start_year' and '$end_year' group by to_char(date_entry,'YYYY') order by to_char(date_entry,'YYYY') ASC");
            
            $rs_result1 = $rs_crop->row();
            $count1 = sizeof($rs_result1);
            if(($count1 == '0'))
            {
                $bigha_A = '0';
            }
            else
            {
                $bigha_A = $rs_result1->bigha;
            }
            array_push($arrData["data"], array(
                    "dates" => $dt->format("Y"),
                    "bigha_A" => $bigha_A,
                    "bigha_N" => $bigha_N
                        )
                );
        }
        return $arrData["data"];
    }

    public function getVillageLandScenario($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
		$db=  $this->session->userdata('db');
        $lndscenario = $this->db->query("select dag_no, TRIM(patta_no), dag_area_b AS bigha, dag_area_k AS kotha, dag_area_lc AS lessa, dag_area_g AS ganda, dag_revenue
from   chitha_basic where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and 
lot_no = '$lot_no' and vill_townprt_code = '$vill_code' order by CAST(coalesce(dag_no_int, '0') AS integer)");
        return $lndscenario->result();
    }

    public function getVillageLandScenarioCount($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
		$db=  $this->session->userdata('db');
        $lndscenario = $this->db->query("select DISTINCT landclass_code.land_type AS type_of_land, landclass_code.class_code AS code from   landclass_code INNER JOIN chitha_basic on "
                . "chitha_basic.land_class_code = landclass_code.class_code and chitha_basic.dist_code ='$dist_code' and "
                . "chitha_basic.subdiv_code='$subdiv_code' and chitha_basic.cir_code='$circle_code' and chitha_basic.mouza_pargona_code='$mouza_code' "
                . "and chitha_basic.lot_no='$lot_no' and chitha_basic.vill_townprt_code='$vill_code' order by landclass_code.land_type");
        //return $lndscenario->result();
        $land = $lndscenario->result();
        $arrData["data"] = array();
        foreach($land as $land_type)
        {
            //echo $land_type->type_of_land;
            $lndscenariocount = $this->db->query("select count(dag_no) AS total_dag from   chitha_basic where dist_code ='$dist_code' and "
                    . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code = '$vill_code' and land_class_code = '$land_type->code' ");
            $t_count = $lndscenariocount->row();
            //var_dump($t_count);
            array_push($arrData["data"], array(
                    "label" => $land_type->type_of_land,
                    "value" => $t_count->total_dag
                        )
                );
        }
        return $arrData["data"];
//        $lndscenariocount = $this->db->query("select count(dag_no) AS total_dag, count(CASE WHEN patta_no != '0' THEN 1 ELSE NULL END) AS total_patta, 
//            SUM(dag_area_b) AS total_bigha, SUM(dag_area_k) AS total_kotha, SUM(dag_area_lc) AS total_lessa, SUM(dag_area_g) AS total_ganda, 
//            SUM(dag_revenue) AS total_revenue from   chitha_basic where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
//                . "mouza_pargona_code='$mouza_code'and lot_no = '$lot_no' and vill_townprt_code = '$vill_code'");
//        return $lndscenariocount->result();
    }
    
    public function getVillageLandScenarioCount1($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
		$db=  $this->session->userdata('db');
        $lndscenariocount = $this->db->query("select count(dag_no) AS total_dag, count(CASE WHEN TRIM(patta_no) != '0' THEN 1 ELSE NULL END) AS total_patta, 
            SUM(dag_area_b) AS total_bigha, SUM(dag_area_k) AS total_kotha, SUM(dag_area_lc) AS total_lessa, SUM(dag_area_g) AS total_ganda, 
            SUM(dag_revenue) AS total_revenue from   chitha_basic where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code='$mouza_code'and lot_no = '$lot_no' and vill_townprt_code = '$vill_code'");
        $q = "select count(dag_no) AS total_dag, count(CASE WHEN TRIM(patta_no) != '0' THEN 1 ELSE NULL END) AS total_patta, 
            SUM(dag_area_b) AS total_bigha, SUM(dag_area_k) AS total_kotha, SUM(dag_area_lc) AS total_lessa, SUM(dag_area_g) AS total_ganda, 
            SUM(dag_revenue) AS total_revenue from   chitha_basic where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code='$mouza_code'and lot_no = '$lot_no' and vill_townprt_code = '$vill_code'";

        return $lndscenariocount->result();
    }

    public function getTeaEstateLand($arr) {
		$db=  $this->session->userdata('db');

        $land_class_code = TEA_ESTATE_CLASS_CODE;
        $query = "select * from   chitha_basic  cb  where cb.dist_code='$arr[dist_code]'"
                . " and cb.subdiv_code='$arr[subdiv_code]' and cb.cir_code='$arr[cir_code]' and "
                . "cb.mouza_pargona_code='$arr[mouza_pargona_code]' and land_class_code='$land_class_code'";
        //echo $query;
        $outerdata = $this->db->query($query)->result();

        $innerdata = array();
        $estates = array();
        foreach ($outerdata as $location) {

            $innerquery = "select pdar_name, TRIM(patta_no) from   chitha_pattadar cb where cb.dist_code='$location->dist_code'"
                    . " and cb.subdiv_code='$location->subdiv_code' and cb.cir_code='$location->cir_code' and "
                    . "cb.mouza_pargona_code='$location->mouza_pargona_code'"
                    . " and cb.vill_townprt_code='$location->vill_townprt_code' "
                    . "and lot_no='$location->lot_no' and TRIM(patta_no)=trim('$location->patta_no') ";


            $innerdata = $this->db->query($innerquery)->result();

            foreach ($innerdata as $data) {

                $estates[] = array
                    (
                    'estatename' => $data->pdar_name,
                    'dag_no' => $location->dag_no,
                    'patta_no' => trim($location->patta_no),
                    'b' => $location->dag_area_b,
                    'k' => $location->dag_area_k,
                    'l' => $location->dag_area_lc
                );
            }
        }
        return $estates;
    }

    public function getConvData($dist_code, $subdiv_code, $circle_code, $year1, $month_name1) {
		$db=  $this->session->userdata('db');
        $month = $month_name1;
        $year = $year1;

        $First_Last = $this->utilityclass->First_Last_Date_of_Month($year, $month);

        $start_date = $First_Last[0] . " 00:00:00";
        $end_date = $First_Last[1] . " 23:59:59";


        $query1 = $this->db->query("SELECT count(*) total_case FROM  t_chitha_rmk_ordbasic "
                . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and Ord_date between '$start_date' and '$end_date' and Ord_type_code='01'");
        $Data1['order_passes'] = $query1->result();

        $query2 = $this->db->query("SELECT count(distinct ord_no) total_case FROM   t_chitha_rmk_ordbasic "
                . "where Dist_code='$dist_code' and Subdiv_code='$subdiv_code' "
                . "and Cir_code='$circle_code' and Ord_date between '$start_date' "
                . "and '$end_date' and Ord_type_code='01' and iscorrected_inco='Y' "
                . "and iscorrected_inco_date between '$start_date' and '$end_date'");
        $Data2['chitha_corrected'] = $query2->result();

        $query3 = $this->db->query("SELECT m_dag_area_B as bigha,m_dag_area_K as kotha,m_dag_area_LC as lessa,lot_no, vill_townprt_code, dag_no, rmk_type_hist_no,ord_cron_no,mouza_pargona_code 
FROM  Chitha_Rmk_Ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and Ord_date between '$start_date' and '$end_date' and Ord_type_code='01'");
        $outerdata = $query3->result();
        $Data3['area'] = $outerdata;
        $bigha = 0;
        $kotha = 0;
        $lessa = 0;
        $Totpremium = 0;
        $Totpatta = 0;
        foreach ($outerdata as $location) {
            $query4 = $this->db->query("SELECT SUM(DISTINCT premium) AS premium FROM  Chitha_Rmk_convorder 
where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and 
mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");
            $Data4 = $query4->row();

            $query5 = $this->db->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type FROM  Chitha_Rmk_convorder 
where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and 
mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");

            $Data5 = $query5->row();

            $premium = $Data4->premium;
            $patta = $Data5->new_patta_type;

            $Totpremium = $Totpremium + $premium;
            $Totpatta = $Totpatta + $patta;

            $bigha = $bigha + $location->bigha;
            $kotha = $kotha + $location->kotha;
            $lessa = $lessa + $location->lessa;
        }
        //echo $Totpremium;
        //echo $Totpatta;
        //exit;
        $result = array(
            'total_premium' => $Totpremium,
            'total_patta' => $Totpatta,
            'total_bigha' => $bigha,
            'total_kotha' => $kotha,
            'total_lessa' => $lessa
        );

        $result_array['final_result'] = $result;
        //print_r($result_array);
        $data = array_merge($Data1, $Data2, $Data3, $result_array);

        return $data;
    }

    public function getConvertionPremiumArrear($dist_code, $subdiv_code, $circle_code, $year1, $month_name1, $mouza_code) {
             $db=  $this->session->userdata('db');
		$month = $month_name1;
        $year = $year1;

        $First_Last = $this->utilityclass->First_Last_Date_of_Month($year, $month);

        $start_date = $First_Last[0] . " 00:00:00";
        $end_date = $First_Last[1] . " 23:59:59";

        $query1 = $this->db->query("SELECT * FROM  chitha_rmk_ordbasic "
                . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                . "and Ord_date between '$start_date' and '$end_date' and Ord_type_code='01'");
        $all_cases = $query1->result();
        $arear = array();
        foreach ($all_cases as $all_c) {
            $query2 = "select distinct(TRIM(new_patta_no)) as new_patta_no, (premium) as premium from   chitha_rmk_convorder "
                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                    . "and rmk_type_hist_no = '$all_c->rmk_type_hist_no' and dag_no = '$all_c->dag_no' and new_dag_no = '$all_c->new_dag_no' and premi_chal_recpt ='003'";
            $result = $this->db->query($query2)->result();

            $quw = "Select ord_onbehalf_of as pdars from   chitha_rmk_convorder where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                    . "and rmk_type_hist_no = '$all_c->rmk_type_hist_no' and dag_no = '$all_c->dag_no' and new_dag_no = '$all_c->new_dag_no' and premi_chal_recpt ='003'";
            $res = $this->db->query($quw)->result();
            //var_dump($res);
            foreach ($result as $data) {
                $lot_no = $all_c->lot_no;
                $vill_code = $all_c->vill_townprt_code;
                $village = $this->db->query("select loc_name AS village from   location where dist_code ='$dist_code'  and "
                        . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                        . " vill_townprt_code='$vill_code' and lot_no='$lot_no'");
                $villagedata = $village->row();
                $arear[] = array
                    (
                    'lot_no' => $all_c->lot_no,
                    'vill_townprt_code' => $villagedata->village,
                    'case_no' => $all_c->case_no,
                    'patta_no' => trim($data->new_patta_no),
                    'new_dag_no' => $all_c->new_dag_no,
                    'pattadars' => $res,
                    'm_dag_area_b' => $all_c->m_dag_area_b,
                    'm_dag_area_k' => $all_c->m_dag_area_k,
                    'm_dag_area_lc' => $all_c->m_dag_area_lc,
                    'min_revenue' => $data->premium
                );
            }
        }
        //var_dump($arear);
        return $arear;
    }

    public function getVillageLandScenarioLandClass($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code) {
           $db=  $this->session->userdata('db');
	  $lndscenario = $this->db->query("select landclass_code.land_type AS type_of_land,chitha_basic.dag_no, TRIM(chitha_basic.patta_no), 
            chitha_basic.dag_area_b AS bigha, chitha_basic.dag_area_k AS kotha, chitha_basic.dag_area_lc AS lessa, chitha_basic.dag_area_g AS ganda, 
            chitha_basic.dag_revenue from   landclass_code INNER JOIN chitha_basic on chitha_basic.land_class_code = landclass_code.class_code and 
            chitha_basic.dist_code ='$dist_code' and chitha_basic.subdiv_code='$subdiv_code' and chitha_basic.cir_code='$circle_code' and chitha_basic.mouza_pargona_code='$mouza_code' 
            and chitha_basic.lot_no='$lot_no' and chitha_basic.vill_townprt_code='$vill_code' order by landclass_code.land_type");
        return $lndscenario->result();
    }
    

}
