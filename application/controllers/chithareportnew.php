<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ChithaReportNew extends CI_Controller {

    public function index() {
		  $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('header');
        $session = $this->session->userdata('username');
        if ($session == 'lm') {
            $this->load->view('menu/menu1');
        } elseif ($session == 'sk') {
            $this->load->view('menu/menu2');
        } elseif ($session == 'oc') {
            $this->load->view('menu/menu3');
        }

        $this->load->view('chitha_report/report1new');
        $this->load->view('footer');
    }

    public function districtDetails() {
		  $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('header');
        $this->load->model('chitha/ChithaModel');
        $data = $this->ChithaModel->getDistrictName();
        $district['names'] = $data;
        $this->load->view('chitha_report/report1new', $district);
        $this->load->view('footer');
    }

    public function generateDagChitha() {
		  $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('header');

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
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData = array(
            'chitha_dist_code' => $dist_code,
            'chitha_subdiv_code' => $subdiv_code,
            'chitha_cir_code' => $circle_code,
            'chitha_mouza_pargona_code' => $mouza_code,
            'chitha_lot_no' => $lot_no,
            'chitha_vill_code' => $vill_code,
        );

       
        $this->session->set_userdata($locationData);

        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
        $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        //var_dump($chithadetailsmain);


        $this->load->view('chitha_report/report2new', $chithadetailsmain);
        $this->load->view('footer');
    }

    public function getDags($p) {
		  $db=  $this->session->userdata('db');
        $this->load->model('chitha/ChithaModel');

        $dist_code = $this->session->userdata('chitha_dist_code');
        $subdiv_code = $this->session->userdata('chitha_subdiv_code');
        $circle_code = $this->session->userdata('chitha_cir_code');
        $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
        $lot_no = $this->session->userdata('chitha_lot_no');
        $vill_code = $this->session->userdata('chitha_vill_code');

        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p);
        $json = array();
        foreach ($daginfo as $d) {
            $json[] = array(
                'dag' => $d->dag_no
            );
        }
        echo json_encode($json);
    }

    public function generateChitha() {
         $db=  $this->session->userdata('db');
        if(isset($_GET['case_no']))
        {
            $case_no = $this->input->get('case_no');
            if($case_no == 0)
            {
                //var_dump($this->session->all_userdata());
                $district_code =$this->session->userdata('dist_code');
                $subdivision_code =$this->session->userdata('subdiv_code');
                $circlecode =$this->session->userdata('cir_code');
                $mouzacode =$this->session->userdata('mouza_pargona_code');
                $lot_code =$this->session->userdata('lot_no');
                $village_code =$this->session->userdata('vill_code');
                $patta_code =$this->session->userdata('patta_type_code');
                $dag_no_lower =$this->session->userdata('dag_no');
                $dag_no_upper =$this->session->userdata('dag_no');
                
                
            }
            else{
            $petition_basic=$this->db->query("Select * from petition_basic where case_no = '$case_no'")->row();
            $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,"
                    . "patta_type_code from petition_dag_details where dist_code='$petition_basic->dist_code' and"
                    . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                    . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                    . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
            
            $district_code =$petition_basic->dist_code;
            $subdivision_code =$petition_basic->subdiv_code;
            $circlecode =$petition_basic->cir_code;
            $mouzacode =$petition_basic->mouza_pargona_code;
            $lot_code =$petition_basic->lot_no;
            $village_code =$petition_basic->vill_townprt_code;
            
            $patta_code =$landdetails['patta_type_code'];
            $dag_no_lower =$landdetails['dag_no'];
            $dag_no_upper =$landdetails['dag_no'];
            }
        }
        else
        {
            $location = $this->utilityclass->getLocationFromSession();
            //var_dump($location);
            $district_code = $this->session->userdata('chitha_dist_code');
            $subdivision_code = $this->session->userdata('chitha_subdiv_code');
            $circlecode = $this->session->userdata('chitha_cir_code');
            $mouzacode = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_code = $this->session->userdata('chitha_lot_no');
            $village_code = $this->session->userdata('chitha_vill_code');
        
            $patta_code = $this->input->post('patta_code');
            $dag_no_lower = $this->input->post('dag_no_lower');
            $dag_no_upper = $this->input->post('dag_no_upper');
        }
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName(
                $district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName( 
                $district_code, $subdivision_code, $circlecode, $mouzacode,$lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName(
                $district_code, $subdivision_code, $circlecode, $mouzacode,$lot_code,$village_code);


        $data['location'] = array(
            'dist' => $dist_name,
            'sub' => $subdiv_name,
            'cir' => $cir_name,
            'mouza' => $mouza_pargona_code_name,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code_name
        );



//$data['loc']=$location;
        // var_dump($data);
        $this->load->helper('html');
        $this->load->view('header');
        
//        
        // echo  $patta_code.'<br>'.$dag_no_lower.'<br>'.$dag_no_upper;
        $secondSelection = array(
            'patta_code' => $patta_code,
            'dag_no_lower' => $dag_no_lower,
            'dag_no_upper' => $dag_no_upper
        );
        //$maindataforchitha = array_merge($data,$secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
      // echo'hiii';
   //  var_dump($chithainfo1);  
            
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }
		
       
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        $this->load->view('chitha_report/saveChithaReport2', $maindataforchitha);
        $this->load->view('footer');
    }
    
    
      
    
    
    
    
    
    
     public function generateChithaCitizen() {
		   $db=  $this->session->userdata('db');
            $location = $this->utilityclass->getLocationFromSession();
            //var_dump($location);
            $district_code = $this->session->userdata('dist_code');
            $subdivision_code = $this->session->userdata('subdiv_code');
            $circlecode = $this->session->userdata('cir_code');
            $mouzacode =$this->session->userdata('mouza_pargona_code');
            $lot_code =$this->session->userdata('lot_no');
            $village_code = $this->session->userdata('vill_townprt_code');
 
            $patta_code = $this->session->userdata('patta_type_code');
           
            $dag_no_lower = $this->input->post('dag_no');
            $dag_no_upper = $this->input->post('dag_no');
       
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName(
                $district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName( 
                $district_code, $subdivision_code, $circlecode, $mouzacode,$lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName(
                $district_code, $subdivision_code, $circlecode, $mouzacode,$lot_code,$village_code);


        $data['location'] = array(
            'dist' => $dist_name,
            'sub' => $subdiv_name,
            'cir' => $cir_name,
            'mouza' => $mouza_pargona_code_name,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code_name
        );



		//$data['loc']=$location;
        // var_dump($data);
        $this->load->helper('html');
        $this->load->view('header');
       
        // echo  $patta_code.'<br>'.$dag_no_lower.'<br>'.$dag_no_upper;
        $secondSelection = array(
            'patta_code' => $patta_code,
            'dag_no_lower' => $dag_no_lower,
            'dag_no_upper' => $dag_no_upper
        );
        //$maindataforchitha = array_merge($data,$secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
       // var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
		//var_dump($chithainfo1);
        $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
        $this->load->view('footer');
    }
    
    

}
