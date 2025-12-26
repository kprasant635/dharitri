<?php

/* Authorhtuor: Bijoy Mazumder, DIO, Bongaigaon, Dated: 13/05/2017 */

class ControllerForRevenueUpdate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('jamabandi/JamabandiModel');
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

    public function SelectLocations() {
		 // $db=  $this->session->userdata('db');
   //      $this->load->helper('html');
   //      $this->load->view('header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $land_classes = $this->db->query("select class_code,land_type from    landclass_code where class_code IN ( select distinct land_class_code from    chitha_basic)")->result();
        $data['land_classes'] = $land_classes;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->view('../views/RevenueModification/show_location', $data);
        // $this->load->view('footer');
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $data['_view'] = 'RevenueModification/show_location_barak';
        }else{
            $data['_view'] = 'RevenueModification/show_location';
        }
        $this->load->view('layouts/main',$data);
    }

    public function SelectLocationsVill() {
		 // $db=  $this->session->userdata('db');
   //      $this->load->helper('html');
   //      $this->load->view('header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $land_classes = $this->db->query("select class_code,land_type from    landclass_code where class_code IN ( select distinct land_class_code from    chitha_basic)")->result();
        $data['land_classes'] = $land_classes;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->view('../views/RevenueModification/show_location_vill', $data);
        // $this->load->view('footer');
        $data['_view'] = 'RevenueModification/show_location_vill';
        $this->load->view('layouts/main',$data);
    }

    public function SelectLocationsDag() {
		 // $db=  $this->session->userdata('db');
   //      $this->load->helper('html');
   //      $this->load->view('header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $land_classes = $this->db->query("select class_code,land_type from    landclass_code where class_code IN ( select distinct land_class_code from    chitha_basic)")->result();
        $data['land_classes'] = $land_classes;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->view('../views/RevenueModification/show_location_dag', $data);
        // $this->load->view('footer');
        $data['_view'] = 'RevenueModification/show_location_dag';
        $this->load->view('layouts/main',$data);
    }

    public function GetDags() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_code');

        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code);


        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'lot_code' => $lot_no,
            'village_code' => $village_code,
            'dist_name' => $districtdata,
            'subdiv_name' => $subdivdata,
            'cir_name' => $circledata,
            'mouza_name' => $mouza_name,
            'lot_name' => $lot_name,
            'village_name' => $village_name,
        );

        $sql = "Select * from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no='$lot_no' and vill_townprt_code = '$village_code'  order by dag_no_int";
        $data['result'] = $this->db->query($sql)->result();
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('../views/RevenueModification/UpdateDagRevenue', $data);
        // $this->load->view('footer');
        $data['_view'] = 'RevenueModification/UpdateDagRevenue';
        $this->load->view('layouts/main',$data);
    }

    // public function SaveDagRevenue() {
	// 	 $db=  $this->session->userdata('db');
    //     if ($this->input->server('REQUEST_METHOD') == 'POST') { //First Braket
    //         $cdt = date("Y/m/d");
    //         $cyr = date("Y");
    //         $usercode = $this->session->userdata('user_code');
    //         $RevenuePerBigha = $this->input->post('revenuebigha');
    //         $minRevenue = $this->input->post('minRevenue');
    //         $dist_code = $this->input->post('dist_code');
    //         $subdiv_code = $this->input->post('subdiv_code');
    //         $circle_code = $this->input->post('cir_code');
    //         $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    //         $lot_no = $this->input->post('lot_no');
    //         $village_code = $this->input->post('vill_townprt_code');

    //         $dag_no_int = $this->input->post('dag_no_int');
    //         $dag_no = $this->input->post('dags');
    //         //$land_class_code = $this->input->post('land_class_code');
    //         $LessaAmount = ($RevenuePerBigha / 100);
    //         $RuralUrban = $this->input->post('RuralUrban');
    //         $HalfOfRev = ($minRevenue) / 2;
    //         $OneFourthRev = ($minRevenue) / 4;
    //         $ThreeFourthRev = ($minRevenue) * (3 / 4);
    //         $HalfOneFourth = ($minRevenue / 2) * (3 / 4);
    //         $fractional=$this->input->post('proportunate');

    //         $dag_no = str_replace("দাগ নং : ", "", $dag_no);
    //         $dag_no = explode(",", $dag_no);
    //         $dag_no_int = explode(",", $dag_no_int);
    //         $no_of_dags = count($dag_no_int);
    //         for ($i = 0; $i < $no_of_dags; $i++) { //Creating SQL dynamically ............Bijoy Mazumder, 07/09/2018
    //             if ($i == 0) {
    //                 $sql_dno = "dag_no_int=" . $dag_no_int[$i];
    //                 $sql_dnoJD = "TRIM(dag_no)=" . "'" . TRIM($dag_no[$i]) . "'";
    //             } else {
    //                 $sql_dno = $sql_dno . " OR dag_no_int=" . $dag_no_int[$i];
    //                 $sql_dnoJD = $sql_dnoJD . " OR TRIM(dag_no)=" . "'" . TRIM($dag_no[$i]) . "'";
    //             }
    //         }
    //         //for ($i = 0; $i < $no_of_dags; $i++) {  Bijoy 07/09/2018
    //         if (is_numeric($RevenuePerBigha) == FALSE || is_numeric($minRevenue) == FALSE) {
    //             echo "<p align=center><u><font size=4 color=red>SORRY!!!Only Numeric Value accepted.</font></u></p>";
    //         } else { //First Else Part
    //             if ($RevenuePerBigha <= 0 || $minRevenue < 0) {
    //                 echo "<p align=center><u><font size=4 color=blue>Revenue and Local Tax Should Not Smaller than 0</font></u></p>";
    //             } else { //Starting of 2nd Else Part					
    //                 /* ------------------------------------------------------- */
    //                 if ($RuralUrban == 'Rural') {
    //                     $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_local_tax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code'  and lot_no='$lot_no' and vill_townprt_code='$village_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)>100 and " . "(" . $sql_dno . ")");
    //                     $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_localtax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)>100 and " . "(" . $sql_dnoJD . ")");
    //                     //IF LAND AREA IS LESS THAN or EQUAL TO 1 BIGHA
    //                      if (empty($fractional)) {
    //                         $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue' , dag_local_tax = '$OneFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and patta_type_code!='0208' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)<=100 and " . "(" . $sql_dno . ") ");
    //                         $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = '$OneFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and patta_type_code!='0208' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <= 100 and " . "(" . $sql_dnoJD . ")");
    //                     } else {
    //                         $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_local_tax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)<=100 and " . "(" . $sql_dno . ")");
    //                         $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_localtax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)<=100 and " . "(" . $sql_dnoJD . ")");
    //                     }
    //                 } else if ($RuralUrban == 'Urban') {
    //                     // if Land Area is more than 1 Bigha 
    //                     $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_local_tax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) >100 and " . "(" . $sql_dno . ")");
    //                     $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_localtax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_class_code='$land_class_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) >100 and " . "(" . $sql_dnoJD . ")");
    //                     //IF LAND AREA IS LESS THAN and EQUAL TO  1 BIGHA
    //                     if (empty($fractional)) {
    //                         $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue' , dag_local_tax = '$OneFourthRev' where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <=100 and " . "(" . $sql_dno . ")");
    //                         $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_local_tax = '$OneFourthRev' where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <=100 and " . "(" . $sql_dnoJD . ")");
    //                     } else {
    //                         $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_local_tax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <=100 and " . "(" . $sql_dno . ")");
    //                         $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount, dag_localtax = ((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <=100 and " . "(" . $sql_dnoJD . ")");
    //                     }
    //                 } else if ($RuralUrban == 'NisphiKheraj') {
    //                     //*******For the Nisphi Kheraj-0208 -------IF LAND AREA IS  MORE THAN 1 Bigha
    //                     $this->db->query("UPDATE chitha_basic set dag_revenue=((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/2, dag_local_tax = (((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/2 *  0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and patta_type_code='0208' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) > 100 and " . "(" . $sql_dno . ")");
    //                     $this->db->query("UPDATE jama_dag set dag_revenue=((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/2, dag_localtax = (((dag_area_b * 100 + dag_area_k * 20 + dag_area_lc)* $LessaAmount)/2 * 0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and patta_type_code='0208' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) > 100 and " . "(" . $sql_dnoJD . ")");
    //                     // if Land Area is equal and less than 1 Bigha
    //                     $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue', dag_local_tax = $ThreeFourthRev where dist_code='$dist_code' and subdiv_code='$subdiv_code' 	and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and patta_type_code='0208' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <= 100 and " . "(" . $sql_dno . ")");
    //                     $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = $ThreeFourthRev where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and mouza_pargona_code = '$mouza_pargona_code' and patta_type_code='0208' and (dag_area_b * 100 + dag_area_k * 20 + dag_area_lc) <= 100 and " . "(" . $sql_dnoJD . ")");
                        
    //                 }
    //                 // For La Kheraj and Govt. Land the Revenue have to be set to 0 ------------
    //                 $sqlLaKheCh = "UPDATE chitha_basic set dag_revenue=0, dag_local_tax = 0 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and (patta_type_code='0209'  or patta_type_code='0205') and " . "(" . $sql_dno . ")";
    //                 $sqlLaKheJm = "UPDATE jama_dag set dag_revenue=0, dag_localtax = 0 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and (patta_type_code='0209'  or patta_type_code='0205') and " . "(" . $sql_dnoJD . ")";
    //                 $this->db->query($sqlLaKheCh);
    //                 $this->db->query($sqlLaKheJm);
    //                 /* ------------------------------------------------------- */
    //                 $this->session->set_flashdata('message', "Dag Wise Updation Of Revenue and Local Tax Done Successfully.");
    //                 redirect(base_url() . "index.php/home");
    //             }// End of the 2nd else Part
    //         } //First Else If Loop
    //         //} Bijoy
    //     } //Last Braket
    // }

    public function VerifyOldRevenue() {
		 // $db=  $this->session->userdata('db');
   //      $this->load->helper('html');
   //      $this->load->view('../views/RevenueModification/list_of_landclass_revenue_updated');
        $data['_view'] = 'RevenueModification/list_of_landclass_revenue_updated';
        $this->load->view('layouts/main',$data);
        //$this->load->view('footer');
    }

}
