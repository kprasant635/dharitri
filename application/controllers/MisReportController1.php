<?php

//pranob

class MisReportController1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->library('session');
    $this->dbswitch();
    }
     public function dbswitch(){       
         //$CI=&get_instance();
         if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
         } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
          } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
         } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
         }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
         }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
         }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
         }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
         }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
         }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
         }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
         }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
         }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
         }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
         }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
         }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
         }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
         }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
         }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
         }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
         }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
         }                                                                                                 
    }

    //coding start for irregated and non-irregated land area
    public function irregated_nonirregated() {
		
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
        
        // $this->load->view('../views/misreport/irregated_nonirregated', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/irregated_nonirregated';
        $this->load->view('layouts/main',$district);
    }

    public function irregated_nonirregated1() {
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

        //write code for non crop data from "chitha_mcrop" table
        $cropdata['crop'] = $this->MisModel->getCrop($dist_code, $subdiv_code, $circle_code, $mouza_code);

        //write code for non crop data from "chitha_noncrop" table

        $noncropdata['noncrop'] = $this->MisModel->getNonCrop($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $main = array_merge($maindata, $cropdata, $noncropdata);

        // $this->load->view('../views/misreport/irregated_nonirregated1', $main);

        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/irregated_nonirregated1';
        $this->load->view('layouts/main',$main);
    }

    //coding end for irregated and non-irregated land area
    //########################################################################
    //coding start for village-wise tenant list


    public function village_wise_tenants() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/village_wise_tenants', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/village_wise_tenants';
        $this->load->view('layouts/main',$district);
    }

    public function village_wise_tenants1() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);


        $tenantdata['tenant'] = $this->MisModel->getTenantData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $main = array_merge($maindata, $tenantdata);
        // $this->load->view('../views/misreport/village_wise_tenants1', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/village_wise_tenants1';
        $this->load->view('layouts/main',$main);
    }

    //coding ends for village-wise tenant list
    //########################################################################
    //coding start for mouza-wise village list


    public function mouzawise_villages() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/mouzawise_villages', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/mouzawise_villages';
        $this->load->view('layouts/main',$district);
    }

    public function mouzawise_villages1() {
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


        $villagedata['village'] = $this->MisModel->getMouzawiseVillages($dist_code, $subdiv_code, $circle_code, $mouza_code);


        $main = array_merge($maindata, $villagedata);
        // $this->load->view('../views/misreport/mouzawise_villages1', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/mouzawise_villages1';
        $this->load->view('layouts/main',$main);
    }

    //########################################################################
    //coding start for mouza-wise No_Of_Tenants
    public function No_Of_Tenants() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/no_of_tenants', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/no_of_tenants';
        $this->load->view('layouts/main',$district);
    }

    public function No_Of_Tenants1() {
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

        $tenantdata['tenants'] = $this->MisModel->getTenantList($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $main = array_merge($tenantdata, $maindata);

        // $this->load->view('../views/misreport/no_of_tenants1', $main);

        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/no_of_tenants1';
        $this->load->view('layouts/main',$main);
    }

    //function created for mutation/partition/conversion cases
    //#################$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$%%%%%%%%%%%%%%%%%%%%##############
    public function MonthlyAccMutPartConv() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/MonthlyAccMutPartConv', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/MonthlyAccMutPartConv';
        $this->load->view('layouts/main',$district);
    }
    public function MonthlyAccMutPartConv_REV() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
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
        // $this->load->view('../views/misreport/MonthlyAccMutPartConv_R', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/MonthlyAccMutPartConv_R';
        $this->load->view('layouts/main',$district);
    }

    public function saveMonthlyMutPartConv() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
		//var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        //$subdiv_code = $this->session->userdata('subdiv_code');
        //$circle_code = $this->session->userdata('cir_code');
		//if(($subdiv_code =='00')&&($circle_code=='00')){
		$subdiv_code = $this->input->post('subdiv_code');
		$circle_code = $this->input->post('circle_code');
		//}
        $year = $this->input->post('year');

        $month_name = $this->input->post('month_name');
        $send_year = array('year' => $year, 'month' => $month_name);

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $send_year);

        //now sent all the variable to the model with all parameters
        $data=$MutPartData['mutpartconv'] = $this->MisModel->getMutPart($dist_code, $subdiv_code, $circle_code, $year, $month_name);
		
        $main = array_merge($MutPartData, $maindata);
		//var_dump($MutPartData);
        // $this->load->view('../views/misreport/saveMonthlyMutPartConv', $main);
        // //var_dump($main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/saveMonthlyMutPartConv';
        $this->load->view('layouts/main',$main);
    }

    //function created for AP PP SPP Mouza wise
    public function AP_PP_SPP_SAP() {
        //$this->load->helper('html');
		
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
		
		
		
        //$this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        // $this->load->view('../views/misreport/AP_PP_SPP_SAP', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'misreport/AP_PP_SPP_SAP';
        $this->load->view('layouts/main',$district);
    }

    public function AP_PP_SPP_SAP1() {
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

        $landarea2['land'] = $this->MisModel->getAP_PP_SPP_SAP_landarea($dist_code, $subdiv_code, $circle_code, $mouza_code);


        $main = array_merge($maindata, $landarea2);

        // $this->load->view('../views/misreport/AP_PP_SPP_SAP1', $main);

        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/AP_PP_SPP_SAP1';
        $this->load->view('layouts/main',$main);
    }

//function ends for AP PP SPP Mouza wise
//
    //function created for AP PP SPP Village wise

    public function AP_PP_SPP_SAP_Vill() {
        //$this->load->helper('html');
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
		
        //$this->load->view('../views/header');
        
        // $this->load->view('../views/misreport/AP_PP_SPP_SAP_Vill', $district);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/AP_PP_SPP_SAP_Vill';
        $this->load->view('layouts/main',$main);
    }

    public function AP_PP_SPP_SAP_Vill1() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);

        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);

        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);

        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //merge all the data
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);


        $landarea2['land'] = $this->MisModel->getAP_PP_SPP_SAP_landarea_vill($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $main = array_merge($maindata, $landarea2);
        // $this->load->view('../views/misreport/AP_PP_SPP_SAP_Vill1', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'misreport/AP_PP_SPP_SAP_Vill';
        $this->load->view('layouts/main',$main);
    }
    //function ends for AP PP SPP Village wise
}