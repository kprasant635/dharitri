<?php

class MisReportControllerPartha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
    }

    public function AreaAgriNonAgri() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('misreport/areaAgriNonagri', $district);
        // $this->load->view('footer');
        $district['_view'] = 'misreport/areaAgriNonagri';
        $this->load->view('layouts/main',$district);
    }

    public function saveAreaAgriNonAgri() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $start_year = $this->input->post('start_year') . "-01" . "-01";
        $end_year = $this->input->post('end_year') . "-12" . "-31";

        $years = array(
            'start_year' => $start_year,
            'end_year' => $end_year
        );

        $yearsarray['years'] = $years;

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');

        //write code for non crop data from    "chitha_mcrop" table
        $cropdata['rs_crop_stat'] = $this->MisReportModelPartha->getAgri($dist_code, $subdiv_code, $circle_code, $mouza_code, $start_year, $end_year);
        //var_dump($cropdata);
        //write code for non crop data from    "chitha_noncrop" table
        $noncropdata['noncrop'] = $this->MisReportModelPartha->getNonAgri($dist_code, $subdiv_code, $circle_code, $mouza_code, $start_year, $end_year);

        $graphdata['graph_display'] = $this->MisReportModelPartha->GetAgriNonAgriGraph($dist_code, $subdiv_code, $circle_code, $mouza_code, $start_year, $end_year);
        //var_dump($graphdata);
        $main = array_merge($maindata, $cropdata, $noncropdata, $yearsarray, $graphdata);

        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('misreport/saveAreaAgriNonAgri', $main);
        // $this->load->view('footer');
        $main['_view'] = 'misreport/saveAreaAgriNonAgri';
        $this->load->view('layouts/main',$main);
    }

    public function saveVillWiseGovtLand() {
		
		$db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $gvt_area = array();

        $this->load->model('misreport/MisModel');

        $lot = array(
            'lot_no' => $lot_no
        );

        $lotarray['lot_num'] = $lot;

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $villagedata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');

        $g_lands = array('0209', '0212', '0213', '0214', '0215', '0218', '0219');
        $i = count($g_lands);
        for ($z = 0; $z < $i; $z++) {
            $land_class = $this->db->query("SELECT * from    patta_code where type_code ='$g_lands[$z]'")->row();
            $vill_area = $this->db->query("SELECT patta_code.patta_type AS type, SUM(chitha_basic.dag_area_b) AS bigha, "
                            . "SUM(chitha_basic.dag_area_k) AS kotha, SUM(chitha_basic.dag_area_lc) AS lessa FROM chitha_basic "
                            . "INNER JOIN patta_code ON chitha_basic.patta_type_code = patta_code.type_code "
                            . "where patta_code.type_code = '$g_lands[$z]' and chitha_basic.dist_code ='$dist_code' "
                            . "and chitha_basic.subdiv_code='$subdiv_code' and chitha_basic.cir_code='$circle_code' "
                            . "and chitha_basic.mouza_pargona_code='$mouza_code' and chitha_basic.lot_no='$lot_no' "
                            . "and chitha_basic.vill_townprt_code='$vill_code'group by patta_code.patta_type")->row();

            if (count($vill_area) == null) {
                $bigha = '-';
                $kotha = '-';
                $lessa = '-';
            } else {
                $bigha = $vill_area->bigha;
                $kotha = $vill_area->kotha;
                $lessa = $vill_area->lessa;
            }
            $gvt_area[] = array(
                'type' => $land_class->patta_type,
                'bigha' => $bigha,
                'kotha' => $kotha,
                'lessa' => $lessa
            );
            // var_dump($gvt_area);
        }
        $govt_area = array('govt' => $gvt_area);

        $main = array_merge($maindata, $lotarray, $govt_area);
        //var_dump($govt_area);
        //var_dump($main);
        $main['_view'] = 'misreport/saveVillWiseGovtLand';
        $this->load->view('layouts/main',$main);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveVillWiseGovtLand', $main);
        // $this->load->view('../views/footer');
    }

    public function savevillageland() {

$db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $lot = array(
            'lot_no' => $lot_no
        );

        $lotarray['lot_num'] = $lot;

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $villagedata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');

        //write code for non crop data from    "chitha_mcrop" table
        $vill_land_sce['scenario'] = $this->MisReportModelPartha->getVillageLandScenario($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $vill_land_sce_count['scenario_count'] = $this->MisReportModelPartha->getVillageLandScenarioCount1($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);


        $main = array_merge($maindata, $lotarray, $vill_land_sce, $vill_land_sce_count);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/savevillageland', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/savevillageland';
        $this->load->view('layouts/main',$main);
    }

    public function savevillagelandclass() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        //echo $dist_code." ".$subdiv_code." ".$circle_code." ".$mouza_code." ".$lot_no." ".$vill_code ;
        $this->load->model('misreport/MisModel');

        $lot = array(
            'lot_no' => $lot_no
        );

        $lotarray['lot_num'] = $lot;

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $villagedata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');

        //write code for non crop data from    "chitha_mcrop" table
        $vill_land_sce['scenario'] = $this->MisReportModelPartha->getVillageLandScenarioLandClass($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        //var_dump($vill_land_sce);
        $vill_land_sce_count['scenario_count'] = $this->MisReportModelPartha->getVillageLandScenarioCount($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        //var_dump($vill_land_sce_count);

        $main = array_merge($maindata, $lotarray, $vill_land_sce, $vill_land_sce_count);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/savevillagelandclass', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/savevillagelandclass';
        $this->load->view('layouts/main',$main);
    }

    public function saveTeaEstateReport() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_pargona_code');
        //echo $dist_code." ".$subdiv_code." ".$circle_code." ".$mouza_code ;
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');
        
        
        //$this->load->view('../views/header');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data['stats'] = $this->MisReportModelPartha->getTeaEstateLand($_POST);
            $data['landlocation'] = $this->MisReportModelPartha->getTeaEstateLand($_POST);
            $main = array_merge($maindata, $data);
            //var_dump($main);
            //$this->load->view('misreport/saveteaestatereport', $main);
            $main['_view'] = 'misreport/saveteaestatereport';
        } else {
            $this->load->model('mutation/mutationmodel');
            $data = $this->mutationmodel->getDistricts();
            $main['names'] = $data;
            //$this->load->view('misreport/misreportTeaEstate', $district);
            $main['_view'] = 'misreport/misreportTeaEstate';
        }
        $this->load->view('layouts/main',$main);
    }

    public function saveMonthlyReportConv() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $year1 = $this->input->post('year');
        $month_name1 = $this->input->post('month_name');

        $year = array(
            'year' => $year1
        );
        $yeararray['year'] = $year;

        $month_name = array(
            'month_name' => $month_name1
        );

        $month_namearray['month_name'] = $month_name;

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $year, $month_name);
        //print_r($maindata);

        $this->load->model('misreport/MisReportModelPartha');

        //now sent all the variable to the model with all parameters
        $ConvertionData['conv'] = $this->MisReportModelPartha->getConvData($dist_code, $subdiv_code, $circle_code, $year1, $month_name1);

        $main = array_merge($maindata, $month_namearray, $yeararray, $ConvertionData);
        //var_dump($main);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveMonthlyReportConv', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/saveMonthlyReportConv';
        $this->load->view('layouts/main',$main);
    }

    public function saveConversionArrearPremium() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $year1 = $this->input->post('year');
        $month_name1 = $this->input->post('month_name');
        $year = array(
            'year' => $year1
        );
        $yeararray['year'] = $year;

        $month_name = array(
            'month_name' => $month_name1
        );

        $month_namearray['month_name'] = $month_name;
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $year, $month_name, $mouzadata);
        //print_r($maindata);
        $this->load->model('misreport/MisReportModelPartha');
        //now sent all the variable to the model with all parameters
        $ConvertionPremiumArrear['conv'] = $this->MisReportModelPartha->getConvertionPremiumArrear($dist_code, $subdiv_code, $circle_code, $year1, $month_name1, $mouza_code);
        //var_dump($ConvertionPremiumArrear);
        $main = array_merge($maindata, $month_namearray, $yeararray, $ConvertionPremiumArrear);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveConversionArrearPremium', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/saveConversionArrearPremium';
        $this->load->view('layouts/main',$main);
    }

    function district_Statistics() {
		$db=  $this->session->userdata('db');
        $user_desig = $this->session->userdata('user_desig_code');

        $table_result = $this->db->query("select * from    location ORDER BY Dist_code, Subdiv_code, Cir_code, Mouza_Pargona_code, Lot_no, Vill_townprt_code")->result();
        //var_dump($table_result);

        foreach ($table_result as $result) {
            if (($result->dist_code <> "00") && ($result->subdiv_code == "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "District";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Subdivision";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Circle";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Mouza Pargona";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no <> "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Lot";
            } else {
                $loc_type = "Village / Town";
            }
            $total_dag = $this->db->query("select count(dist_code) as dag from    chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code' and lot_no = '$result->lot_no' and vill_townprt_code = '$result->vill_townprt_code' ")->row()->dag;
//echo "select count(dist_code) as dag from    chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code' and lot_no = '$result->lot_no' and vill_townprt_code = '$result->vill_townprt_code' ";            
//var_dump($total_dag);
            $result_data[] = array(
                'dist_code' => $result->dist_code,
                'subdiv_code' => $result->subdiv_code,
                'cir_code' => $result->cir_code,
                'mouza_pargona_code' => $result->mouza_pargona_code,
                'lot_no' => $result->lot_no,
                'vill_townprt_code' => $result->vill_townprt_code,
                'loc_name' => $result->loc_name,
                'loc_type' => $loc_type,
                'dags' => $total_dag
            );
            //var_dump($result_data);
        }
        $data['table_result'] = $result_data;
        //var_dump($table_result);
        $districts = $this->db->query("select Distinct dist_code as district from    location")->result();

        $totaldistricts = '0';
        $totalsubdiv = '0';
        $totalcir = '0';
        $totalmouza = '0';
        $totallot = '0';
        $totalvillage = '0';
        $totaldagsentry = '0';
        $totaldagremarks = '0';

        foreach ($districts as $ds) {
            $district = $this->db->query("select count(dist_code) as dist from    location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000' ")->row()->dist;
            $subdiv = $this->db->query("select count(dist_code) as subdiv from    location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000' ")->row()->subdiv;
            $cir = $this->db->query("select count(dist_code) as cir from    location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code<>'00' and mouza_pargona_code='00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->cir;
            $mouza = $this->db->query("select count(dist_code) as mouza from    location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->mouza;
            $lot = $this->db->query("SELECT count(*) as lot from    location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code = '00000'")->row()->lot;
            $village = $this->db->query("select count(dist_code) as village from    location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code <> '00' and mouza_pargona_code <> '00' and lot_no <> '00' and vill_townprt_code <> '00000' ")->row()->village;
            $dags_entry = $this->db->query("select count(dag_no) as dag from    chitha_basic where dist_code='$ds->district' ")->row()->dag;
            $dag_remarks = $this->db->query("select count(patta_no) as patta_no from    Jama_patta where dist_code='$ds->district' ")->row()->patta_no;

            $totaldistricts = $totaldistricts + $district;
            $totalsubdiv = $totalsubdiv + $subdiv;
            $totalcir = $totalcir + $cir;
            $totalmouza = $totalmouza + $mouza;
            $totallot = $totallot + $lot;
            $totalvillage = $totalvillage + $village;
            $totaldagsentry = $totaldagsentry + $dags_entry;
            $totaldagremarks = $totaldagremarks + $dag_remarks;
        }


        $data['totalresult'] = array(
            'total_dist' => $totaldistricts,
            'total_subdivs' => $totalsubdiv,
            'totalcir' => $totalcir,
            'totalmouza' => $totalmouza,
            'totallot' => $totallot,
            'totalvillage' => $totalvillage,
            'total_dags_entry' => $totaldagsentry,
            'total_dags_remark' => $totaldagremarks,
            'usercode' => $user_desig
        );

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/district_Statistics', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/district_Statistics';
        $this->load->view('layouts/main',$data);
    }

    public function apppsppsap_select_land_area_wise() {
		$db=  $this->session->userdata('db');
        $district[] = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        // $this->load->view('../views/misreport/apppsppsap_select_land_area_wise', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/apppsppsap_select_land_area_wise';
        $this->load->view('layouts/main',$district);
    }

    public function Save_apppsppsap_select_land_area_wise() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');


        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata);

        $landarea2['land'] = $this->MisModel->getAP_PP_SPP_SAP_landarea_area($dist_code, $subdiv_code, $circle_code, $mouza_code);


        $main = array_merge($maindata, $landarea2);

        // $this->load->view('../views/misreport/AP_PP_SPP_SAP_land_area', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/AP_PP_SPP_SAP_land_area';
        $this->load->view('layouts/main',$main);
    }

    public function ApToPp_StateLevel() {
		$db=  $this->session->userdata('db');
        //$dist = unserialize(databases) ;
        //var_dump($dist);

        $databsearray = array(
            array('Kamrup Metro', '24'),
            array('kamrup', '07'),
        );
        $size = sizeof($databsearray);
        
        for ($i = 0; $i < $size; $i++) {

            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            //var_dump($db);
            $query1 = $this->dbb->query("SELECT count(*) FROM  t_chitha_rmk_ordbasic where Ord_type_code='01'");
            $order_passesd = $query1->row();
            //query for total chitha updated
            $query2 = $this->dbb->query("SELECT count(distinct ord_no) FROM   t_chitha_rmk_ordbasic "
                    . "where Ord_type_code='01' and iscorrected_inco='Y'");
            $chitha_corrected = $query2->row();
            //query for total patta converted and total land
            $query3 = $this->dbb->query("SELECT * FROM  Chitha_Rmk_Ordbasic where Ord_type_code='01'");
            $outerdata = $query3->result();
            $bigha = 0;
            $kotha = 0;
            $lessa = 0;
            $Totpatta = 0;
            //var_dump($Data3);
            foreach ($outerdata as $location) {
                $query5 = $this->dbb->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type FROM  Chitha_Rmk_convorder 
    where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and 
    mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");

                $Data5 = $query5->row();
                $patta = $Data5->new_patta_type;
                $Totpatta = $Totpatta + $patta;

                $bigha = $bigha + $location->m_dag_area_b;
                $kotha = $kotha + $location->m_dag_area_k;
                $lessa = $lessa + $location->m_dag_area_lc;
            }
            $total_lesa_converted = ($bigha) * 100 + ($kotha) * 20 + ($lessa);
            $total_area_converted = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_converted);

            //query for total patta not converted and total land
            $query4 = $this->dbb->query("SELECT * FROM  patta_code where conversion='y'");
            $query4 = $query4->result();
            $bigha_l = 0;
            $kotha_l = 0;
            $lessa_l = 0;
            $Totpatta_l = 0;
            foreach ($query4 as $left) {
                $query6 = $this->dbb->query("Select count(patta_no) as total_patta_left, sum(dag_area_b) as bigha, "
                        . "sum(dag_area_k) as katha, sum(dag_area_lc) as lesa from    chitha_basic where patta_type_code = '$left->type_code'");

                $view = $query6->row();

                $patta_l = $view->total_patta_left;
                $Totpatta_l = $Totpatta_l + $patta_l;

                $bigha_l = $bigha_l + $view->bigha;
                $kotha_l = $kotha_l + $view->katha;
                $lessa_l = $lessa_l + $view->lesa;
            }
            $total_lesa_left = ($bigha_l) * 100 + ($kotha_l) * 20 + ($lessa_l);
            $total_area_left = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_left);

            $arrData[] = array(
                "dist_name" => $name,
                "dist_code" => $code,
                "order_passesd" => $order_passesd,
                "chitha_corrected" => $chitha_corrected,
                'total_patta_l' => $Totpatta_l,
                'total_bigha_l' => $total_area_left[0],
                'total_kotha_l' => $total_area_left[1],
                'total_lessa_l' => $total_area_left[2],
                'total_patta' => $Totpatta,
                'total_bigha' => $total_area_converted[0],
                'total_kotha' => $total_area_converted[1],
                'total_lessa' => $total_area_converted[2]
            );
        }
        $arrDatas = array('result' => $arrData);
        $main = array_merge($arrDatas);
        //var_dump($arrDatas);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/misreport/ApToPp_StateLevel', $main);
        $this->load->view('../views/footer');
    }

    public function ApToPp_DistrictLevel() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->input->get('dist_code');
        //echo $dist_code;
        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;
        
        $sub_divs = $this->dbb->query("SELECT * FROM  location WHERE dist_code='$dist_code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'");
        $sub_divsa = $sub_divs->result();
        //var_dump($sub_divs);
        foreach ($sub_divsa as $s_d) {
            //var_dump($s_d);
            //query for total order passed
            $Subdiv_code=$s_d->subdiv_code;
            //echo $Subdiv_code;
            $cir_code=$s_d->cir_code;
            $query1 = $this->dbb->query("SELECT count(*) FROM  t_chitha_rmk_ordbasic "
                    . "where dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01'");
            $order_passesd = $query1->row();
            //query for total chitha updated
            $query2 = $this->dbb->query("SELECT count(distinct ord_no) FROM   t_chitha_rmk_ordbasic "
                    . "where Dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01' and iscorrected_inco='Y'");
            $chitha_corrected = $query2->row();
            //query for total patta converted and total land
            $query3 = $this->dbb->query("SELECT * FROM Chitha_Rmk_Ordbasic where dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01'");
            $outerdata = $query3->result();
            $bigha = 0;
            $kotha = 0;
            $lessa = 0;
            $Totpatta = 0;
            //var_dump($Data3);
            foreach ($outerdata as $location) {
                $query5 = $this->dbb->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type FROM  Chitha_Rmk_convorder 
    where dist_code='$dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and 
    mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");

                $Data5 = $query5->row();
                $patta = $Data5->new_patta_type;
                $Totpatta = $Totpatta + $patta;

                $bigha = $bigha + $location->m_dag_area_b;
                $kotha = $kotha + $location->m_dag_area_k;
                $lessa = $lessa + $location->m_dag_area_lc;
            }
            $total_lesa_converted = ($bigha) * 100 + ($kotha) * 20 + ($lessa);
            $total_area_converted = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_converted);
//            $result = array(
//                'total_patta' => $Totpatta,
//                'total_bigha' => $total_area_converted[0],
//                'total_kotha' => $total_area_converted[1],
//                'total_lessa' => $total_area_converted[2]
//            );
            //query for total patta not converted and total land
            $query4 = $this->dbb->query("SELECT * FROM patta_code where conversion='y'");
            $query4 = $query4->result();
            $bigha_l = 0;
            $kotha_l = 0;
            $lessa_l = 0;
            $Totpatta_l = 0;
            foreach ($query4 as $left) {
                $query6 = $this->dbb->query("Select count(patta_no) as total_patta_left, sum(dag_area_b) as bigha, "
                        . "sum(dag_area_k) as katha, sum(dag_area_lc) as lesa from    chitha_basic where dist_code='$dist_code' and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and patta_type_code = '$left->type_code'");

                $view = $query6->row();

                $patta_l = $view->total_patta_left;
                $Totpatta_l = $Totpatta_l + $patta_l;

                $bigha_l = $bigha_l + $view->bigha;
                $kotha_l = $kotha_l + $view->katha;
                $lessa_l = $lessa_l + $view->lesa;
            }
            $total_lesa_left = ($bigha_l) * 100 + ($kotha_l) * 20 + ($lessa_l);
            $total_area_left = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_left);
//            $result = array(
//                'orderpassed' => $order_passesd,
//                'chitha_corrected' => $chitha_corrected,
//                'total_patta' => $Totpatta,
//                'total_bigha' => $total_area_converted[0],
//                'total_kotha' => $total_area_converted[1],
//                'total_lessa' => $total_area_converted[2],
//                'total_patta_l' => $Totpatta_l,
//                'total_bigha_l' => $total_area_left[0],
//                'total_kotha_l' => $total_area_left[1],
//                'total_lessa_l' => $total_area_left[2]
//            );
            $arrData[] = array(
                "dist_code" => $s_d->dist_code,
                "subdiv_code" => $s_d->subdiv_code,
                "circle_name" => $s_d->loc_name,
                "circle_code" => $s_d->cir_code,
                "order_passesd" => $order_passesd,
                "chitha_corrected" => $chitha_corrected,
                'total_patta_l' => $Totpatta_l,
                'total_bigha_l' => $total_area_left[0],
                'total_kotha_l' => $total_area_left[1],
                'total_lessa_l' => $total_area_left[2],
                'total_patta' => $Totpatta,
                'total_bigha' => $total_area_converted[0],
                'total_kotha' => $total_area_converted[1],
                'total_lessa' => $total_area_converted[2]
            );
        }
        $arrDatas = array('result' => $arrData, 'district' => $dist_code);
        $main = array_merge($arrDatas);
        //var_dump($arrDatas);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/ApToPp_DistrictLevel', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/ApToPp_DistrictLevel';
        $this->load->view('layouts/main',$main);
    }

    public function ApToPp_SubDivLevel() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $dist_code = $this->input->get('dist_code');

        $sub_divs = $this->db->query("select Distinct(Subdiv_code) from    location where dist_code='$dist_code' and Subdiv_code!='00'")->row();
        //var_dump($sub_divs);
        foreach ($sub_divs as $s_d) {
            //query for total order passed
            $query1 = $this->db->query("SELECT count(*) order_passed FROM  t_chitha_rmk_ordbasic "
                    . "where dist_code='$dist_code'  and Subdiv_code='$sub_divs->subdiv_code' and Ord_type_code='01'");
            $order_passesd = $query1->row();
            //query for total chitha updated
            $query2 = $this->db->query("SELECT count(distinct ord_no) chitha_corrected FROM   t_chitha_rmk_ordbasic "
                    . "where Dist_code='$dist_code'  and Subdiv_code='$sub_divs->subdiv_code' and Ord_type_code='01' and iscorrected_inco='Y'");
            $chitha_corrected = $query2->row();
            //query for total patta converted and total land
            $query3 = $this->db->query("SELECT * FROM  Chitha_Rmk_Ordbasic where dist_code='$dist_code'  and Subdiv_code='$sub_divs->subdiv_code' and Ord_type_code='01'");
            $outerdata = $query3->result();
            $bigha = 0;
            $kotha = 0;
            $lessa = 0;
            $Totpatta = 0;
            //var_dump($Data3);
            foreach ($outerdata as $location) {
                $query5 = $this->db->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type FROM  Chitha_Rmk_convorder 
    where dist_code='$dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and 
    mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");

                $Data5 = $query5->row();
                $patta = $Data5->new_patta_type;
                $Totpatta = $Totpatta + $patta;

                $bigha = $bigha + $location->m_dag_area_b;
                $kotha = $kotha + $location->m_dag_area_k;
                $lessa = $lessa + $location->m_dag_area_lc;
            }
            $total_lesa_converted = ($bigha) * 100 + ($kotha) * 20 + ($lessa);
            $total_area_converted = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_converted);
//            $result = array(
//                'total_patta' => $Totpatta,
//                'total_bigha' => $total_area_converted[0],
//                'total_kotha' => $total_area_converted[1],
//                'total_lessa' => $total_area_converted[2]
//            );
            //query for total patta not converted and total land
            $query4 = $this->db->query("SELECT * FROM  patta_code where conversion='y'");
            $query4 = $query4->result();
            $bigha_l = 0;
            $kotha_l = 0;
            $lessa_l = 0;
            $Totpatta_l = 0;
            foreach ($query4 as $left) {
                $query6 = $this->db->query("Select count(patta_no) as total_patta_left, sum(dag_area_b) as bigha, "
                        . "sum(dag_area_k) as katha, sum(dag_area_lc) as lesa from    chitha_basic where dist_code='$dist_code' and patta_type_code = '$left->type_code'");

                $view = $query6->row();

                $patta_l = $view->total_patta_left;
                $Totpatta_l = $Totpatta_l + $patta_l;

                $bigha_l = $bigha_l + $view->bigha;
                $kotha_l = $kotha_l + $view->katha;
                $lessa_l = $lessa_l + $view->lesa;
            }
            $total_lesa_left = ($bigha_l) * 100 + ($kotha_l) * 20 + ($lessa_l);
            $total_area_left = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_left);
            $result = array(
                'orderpassed' => $order_passesd,
                'chitha_corrected' => $chitha_corrected,
                'total_patta' => $Totpatta,
                'total_bigha' => $total_area_converted[0],
                'total_kotha' => $total_area_converted[1],
                'total_lessa' => $total_area_converted[2],
                'total_patta_l' => $Totpatta_l,
                'total_bigha_l' => $total_area_left[0],
                'total_kotha_l' => $total_area_left[1],
                'total_lessa_l' => $total_area_left[2]
            );
            var_dump($result);
        }
        $data['subdiv_data'] = $result;
        //var_dump($data);
        //var_dump($main);
        // $this->load->view('../views/misreport/ApToPp_SubdivLevel', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/ApToPp_SubdivLevel';
        $this->load->view('layouts/main',$data);
    }

    public function saledeed() {
$db=  $this->session->userdata('db');
        $data['dist'] = $databsearray = array(
            array('KamrupMetro', '24'),
            array('kamrup', '07'),
        );
        //  var_dump(unserialize(databases)) ;
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            $sql = "Select count(*) as c from    sro_note";
            $data['reg'][$name]['sro_note'] = $this->dbb->query($sql)->row();
            $sql = "Select count(*) as co from    sro_note where status='1'";
            $data['reg'][$name]['sro_note_co'] = $this->dbb->query($sql)->row();
        }

        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/misreport/saledeed', $data);
        $this->load->view('../views/footer');
    }

    public function saledeedcircle() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $dist_name = $this->input->get('d');
        $data['dist'] = $databsearray = array(
            array('KamrupMetro', '24'),
            array('kamrup', '07'),
            array('jorhat', '15'),
            array('goalpara', '03'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            if ($name == $dist_name) {
                $q = "SELECT * FROM  location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                    $sql = "Select count(*) as c from    sro_note where cir_code='$loc->cir_code'";
                    $data['circle'][$loc->loc_name]['sro_note'] = $this->dbb->query($sql)->row();

                    $sql = "Select count(*) as co from    sro_note where cir_code='$loc->cir_code' and status='1'";
                    $data['circle'][$loc->loc_name]['sro_note_co'] = $this->dbb->query($sql)->row();
                }
            }
        }
        // $this->load->view('../views/misreport/saledeedcircle', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'misreport/saledeedcircle';
        $this->load->view('layouts/main',$data);

    }

}
