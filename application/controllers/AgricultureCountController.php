<?php

ini_set('memory_limit', '-1');

class AgricultureCountController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('jamabandi/JamabandiModel');
        $this->load->model('AgricultureModel');
    }


    public function index(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        
        $data['records'] = $this->AgricultureModel->getDagsCount('list');
        $data['_view'] = 'AgricultureCount/index';
        $this->load->view('layouts/main',$data);
    }

    public function pattadarDetails(){
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $lot_no = $this->input->get('lot_no');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $vill_code = $this->input->get('vill_code');
        $data['uuid'] = $this->utilityclass->getUuid($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code);
        $data['parm'] = "?dist_code=".$dist_code."&subdiv_code=".$subdiv_code."&circle_code=".$cir_code."&mouza_code=".$mouza_code."&lot_no=".$lot_no."&vill_code=".$vill_code;
        $data['records'] = $this->AgricultureModel->getPattadarsCount($vill_code,$lot_no,$mouza_code,$cir_code,$subdiv_code,$dist_code,'list');
        $data['_view'] = 'AgricultureCount/pattadars-view';
        $this->load->view('layouts/main',$data);
    }

    public function downloadExcel(){
        $time = date("d-M-Y-h-i-s-A");
        $file_name = "Agriculture-Dags_".$time.".xlsx";
        $data = $data['records'] = $this->AgricultureModel->getDagsCount();
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
    }

    public function downloadExcelNew(){

        $vill_code = $this->input->get('vill_code');
        $lot_no = $this->input->get('lot_no');
        $mouza_code = $this->input->get('mouza_code');
        $cir_code = $this->input->get('circle_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $dist_code = $this->input->get('dist_code');
        $vill_name = $this->utilityclass->getVillageName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code);
        $query = "
            select dag_no,patta_no,(Select patta_type from patta_code where type_code=patta_type_code) as patta_type ,pdar_name,pdar_father as father_name from chitha_pattadars_mat_view
            where patta_type_code in (Select type_code from patta_code where jamabandi='y')
            AND vill_townprt_code='$vill_code' AND lot_no='$lot_no' AND  mouza_pargona_code='$mouza_code' AND  cir_code='$cir_code' 
            AND  subdiv_code ='$subdiv_code' AND  dist_code='$dist_code'
            order by dag_no,patta_no,patta_type_code,pdar_id
        ";
        $data = $this->AgricultureModel->getPattadarsCount($vill_code,$lot_no,$mouza_code,$cir_code,$subdiv_code,$dist_code);
        $time = date("d-M-Y-h-i-s-A");
        $file_name = $vill_name."(Agri-pattadar)".$time.".xlsx";
        
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
    }

}
