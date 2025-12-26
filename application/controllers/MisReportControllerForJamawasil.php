<?php

class MisReportControllerForJamawasil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
		$this->load->model('jamabandi/JamabandiModel');
    }

   /* public function JamaWasil() {
        $this->load->helper('html');
        $this->load->view('../views/header');
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
        $this->load->view('../views/misreport/JamaWasilBondita', $district);
        $this->load->view('../views/footer');
    }*/

    public function saveJamabandiByEnteringPattano() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
		$patta_no = $this->input->post('patta_no');
		$patta_type = $this->input->post('patta_type');

        $this->load->model('misreport/MisModel');
		$this->load->model('jamabandi/JamabandiModel');
       
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
		$pattatype=$this->MisModel->getpattatypeNameforJamabandi($patta_type);
		//merge all the data
		 //$this->session->set_userdata($patta_no);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata,$pattatype);
	   // $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);
      // print_r($maindata); 
        $this->load->model('misreport/MisReportModelBondita');
        $Jama_patta_info['patta_numbr'] = $this->MisReportModelBondita->getPattanoSingle($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code,$patta_no);
		//print_r($Jama_patta_info); 
        $Mainjamawasil = array_merge($maindata,$Jama_patta_info);
		//print_r($Mainjamawasil);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/saveJamaWasilSinglePatta',  $Mainjamawasil );
        // $this->load->view('../views/footer');
        //print_r($Jama_patta_info['patta_numbr'] );
       // $Mainjamawasil['_view'] = 'misreport/saveJamaWasilSinglePatta';
        $this->load->view('misreport/saveJamaWasilSinglePatta',$Mainjamawasil);
    }
      
	public function districtDetailsForEnteringPattano() {
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
        $district['patta'] = $this->JamabandiModel->getPattaType();
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('misreport/select_district_by_entering_a_pattano', $district);
        // $this->load->view('footer');
        $district['_view'] = 'misreport/select_district_by_entering_a_pattano';
        $this->load->view('layouts/main',$district);
    }
public function HelpForPgSetup()
     {
        $this->load->helper('html');
        $this->load->view('header');
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
        $district['patta'] = $this->JamabandiModel->getPattaType();
        $this->load->view('../views/misreport/jamawasil_help',$cir_name);
        $this->load->view('footer');
    }
public function districtDetailsForEnteringMultiplePattaNo() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
		$patta_type = $this->db->query("select type_code,patta_type from    patta_code")->result();
        $district['patta_type'] = $patta_type;
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $district['patta'] = $this->JamabandiModel->getPattaType();
        $district['_view'] = 'misreport/Jamawasil_multiple_patta.php';
        $this->load->view('layouts/main',$district);
    }
public function GetPattas(){
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_code');
        $patta_code=$this->input->post('patta_type');
        $rows=$this->input->post('rows');
        $districtdata =  $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata =  $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name =  $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code,$mouza_code, $lot_no);
        $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code,$mouza_code, $lot_no,$village_code);
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
            'rows' => $rows,
            'patta_code' => $patta_code,
        );
        
        $sql = "Select distinct on (subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,patta_no::int,patta_type_code) * from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no='$lot_no' and vill_townprt_code = '$village_code'  and patta_type_code='$patta_code' order by patta_no::int";
        $data['result'] = $this->db->query($sql)->result();
        $data['_view'] = 'misreport/JamawasilGetPattaNo';
        $this->load->view('layouts/main',$data);
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('../views/misreport/JamawasilGetPattaNo', $data);
        // $this->load->view('footer');
    }
	public function GenerateJamawasilMultiple(){
		$dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('vill_code');
        $patta_code=$this->input->post('patta_type');
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_code' => $mouza_code,
            'lot_code' => $lot_no,
            'village_code' => $village_code,
            'patta_type' => $patta_code,
        );
        //$data['_view'] = 'misreport/saveJamaWasilMultiplePatta';
        $this->load->view('misreport/saveJamaWasilMultiplePatta',$data);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('../views/misreport/saveJamaWasilMultiplePatta', $data);
        // $this->load->view('footer');
    }

}
