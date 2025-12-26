<?php
class MisReportController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('misreport/misreport');
        $this->load->model('misreport/MisModel');
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
    public  function DisplayReport() {
        // $db=  $this->session->userdata('db');
        //   $this->load->helper('html');
        //   $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata);
        $data['query'] = $this->misreport->getPosts($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $main=  array_merge($maindata,$data);
        //print_r($data);
        // $this->load->view('misreport/saveestimaterevenue', $main);
        // $this->load->view('footer');

        $main['_view'] = 'misreport/saveestimaterevenue';
        $this->load->view('layouts/main',$main);

    }
    public function CropWiseLandArea()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');
        $start_year=$this->input->post('select_year');
        $end_year=$this->input->post('select_year')."-12"."-31";
        $select_year=$this->input->post('select_year');
        $send_year=array('year'  => $select_year );

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata,$send_year);
        $data['query']=$cropdata = $this->misreport->getCropLand($dist_code, $subdiv_code, $circle_code,$mouza_code,$start_year);
        //var_dump($cropdata);
        $sql="SELECT * FROM crop_code ";
        $data['result']=$this->db->query($sql)->result();
        //var_dump($cropdata);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/savecroplandarea', $main);
        // $this->load->view('footer');  

        $main['_view'] = 'misreport/savecroplandarea';
        $this->load->view('layouts/main',$main);
    }
    /*
     Data is missing...
     */
    public function RevenueTeaEstate()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata);
        $data['query'] = $this->misreport->RevenueTea($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/savelandrevenueteaestatereport', $main);
        // $this->load->view('footer');  

        $main['_view'] = 'misreport/savelandrevenueteaestatereport';
        $this->load->view('layouts/main',$main);
    }
    /*
     Unfinished
     */
    /*
    Cityzen Report Start
     */
    public function MonthlyCitizen()
    {
        // $this->load->helper('html');
        //  $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $select_year=$this->input->post('select_yr');
        $month_name=$this->input->post('month_name');

        $send_year=array('year'  => $select_year,
            'month' =>$month_name );

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);


        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$send_year);
        $data['query'] = $this->misreport->getMonthlyCityzenRpt($dist_code, $subdiv_code, $circle_code,$select_year,$month_name);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/saveCitizenCentricService', $main);
        // $this->load->view('footer'); 

        $main['_view'] = 'misreport/saveCitizenCentricService';
        $this->load->view('layouts/main',$main);


    }
    public function MonthlyCitizenYearly()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $select_year=$this->input->post('select_yr');
        //$month_name=$this->input->post('month_name');
        $send_year=array('year'  => $select_year);

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);


        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$send_year);
        $data['query'] = $this->misreport->getYearlyCityzenRpt($dist_code, $subdiv_code, $circle_code,$select_year);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/saveCitizenCentricServiceYearly', $main);
        // $this->load->view('footer');

        $main['_view'] = 'misreport/saveCitizenCentricServiceYearly';
        $this->load->view('layouts/main',$main);

    }
    /*
     Revenue of Nisfi Kheraj
     */
    public function RevenueNisfi()
    {
        // $this->load->helper('html');
        //  $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata);
        $data['query'] = $this->misreport->RevenueTea($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/savelandrevenuenisfikheraj', $main);
        // $this->load->view('footer');  

        $main['_view'] = 'misreport/savelandrevenuenisfikheraj';
        $this->load->view('layouts/main',$main);
    }
    /*
     * End Function
     * Start Report of Revenue Lakheraj ReportLaKheraj
     */
    public function ReportLaKheraj()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata);
        $data['query'] = $this->misreport->RevenueLaKheraj($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/savelandrevenuelakheraj', $main);
        // $this->load->view('footer');  

        $main['_view'] = 'misreport/savelandrevenuelakheraj';
        $this->load->view('layouts/main',$main);
    }
    /*
     * Finished --------   Start Doul Report    ------------
     */
    public function saveDoulReport()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');
        $lot_no=$this->input->post('lot_no');
        $patta_type=$this->input->post('patta_type');
        $postyear=$this->input->post('year');
        $year=  explode('-', $postyear);
        $previousYear=$year[0]-1;
        $currentYear=$year[0];


        $s_year=array('year'  => $postyear,'lot'=>$lot_no);

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata,$s_year);
        $data['query'] = $this->misreport->DoulReport($dist_code, $subdiv_code, $circle_code,$mouza_code,$lot_no,$patta_type,$previousYear,$currentYear);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/saveDoulReport',$main);
        // $this->load->view('footer'); 

        $main['_view'] = 'misreport/saveDoulReport';
        $this->load->view('layouts/main',$main);
    }
    public function saveDoulReportDPE()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');
        $lot_no=$this->input->post('lot_no');
        $patta_type=$this->input->post('patta_type');
        $year=$this->input->post('year');
        $s_year=array('year'  => $year,'lot'=>$lot_no);

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata,$s_year);
        $data['query'] = $this->misreport->DoulReportDPE($dist_code, $subdiv_code, $circle_code,$mouza_code,$lot_no,$year);
        // var_dump($data);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/saveDoulReportDPE',$main);
        // $this->load->view('footer');

        $main['_view'] = 'misreport/saveDoulReportDPE';
        $this->load->view('layouts/main',$main);
    }
    /*
 * Function Finished
 * Function Strat for Land Area of New Lease Rule Grant(NLR Grant)
 */
    public function LandAreaNLR()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $circle_code=$this->input->post('circle_code');
        $mouza_code=$this->input->post('mouza_code');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code,$mouza_code);

        //merge all the data
        $maindata['namedata']=array_merge($districtdata,$subdivdata,$circledata,$mouzadata);
        $data['query'] = $this->misreport->LandAreaNLR($dist_code, $subdiv_code, $circle_code,$mouza_code);
        $main=  array_merge($maindata,$data);
        // $this->load->view('misreport/saveLandAreaNLR',$main);
        // $this->load->view('footer');  


        $main['_view'] = 'misreport/saveLandAreaNLR';
        $this->load->view('layouts/main',$main);
    }
    public function DoulReportDPE()
    {
        $district=array();
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
        $data1 = $this->mutationmodel->getPattaType();
        $district['pattas'] = $data1;
        // $this->load->view('../views/misreport/DoulReportDirectPaying',$district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'misreport/DoulReportDirectPaying';
        $this->load->view('layouts/main',$district);
    }
    public function MiscMonthlyReport()
    {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $select_yr=$this->input->post('select_yr');
        $month_name=$this->input->post('month_name');

        if($month_name=='00')
        {
            $sql="SELECT count(*) FROM  misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and Year_no='$select_yr' and  misc_case_type='07' ";
            $sqll="SELECT count(*) FROM  misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and Year_no='$select_yr' and  misc_case_type='06' ";
        }else{
            $sql="SELECT count(*) FROM  misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and Year_no='$select_yr' and  misc_case_type='07' and date_part ('month', submission_date) = '$month_name' ";
            $sqll="SELECT count(*) FROM  misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and Year_no='$select_yr' and  misc_case_type='06' and date_part ('month',submission_date)= '$month_name' ";
        }
        $data['MiscNamechange']=$this->db->query($sql)->row();

        $data['MiscDeletepattadar']=$this->db->query($sqll)->row();
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'year' => $select_yr,
            'month' =>$month_name
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/miscmonthlyreport',$data);
        // $this->load->view('../views/footer'); 

        $data['_view'] = 'misreport/miscmonthlyreport';
        $this->load->view('layouts/main',$data);
    }
    function dcFieldMutationCheck(){
        //$this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/dcFieldMutationCheck');
        // $this->load->view('../views/footer');


        $data['_view'] = 'misreport/dcFieldMutationCheck';
        $this->load->view('layouts/main',$data);
    }
    function dcDeleteMutationCheck(){
        // $this->load->helper('html');
        //       $this->load->view('../views/header');
        //       $this->load->view('../views/misreport/dcDeleteMutationCheck');
        //       $this->load->view('../views/footer');

        $data['_view'] = 'misreport/dcDeleteMutationCheck';
        $this->load->view('layouts/main',$data);
    }
    function dcFieldMutationOrder(){
        //$db=  $this->session->userdata('db');
        if(isset($_POST)){
            $date=date('Y-m-d',strtotime($this->input->post('date')));
            $date_upto=date('Y-m-d',strtotime($this->input->post('date_upto')));
            $sql="SElect dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
			 lm_note_date,co_ord_date,case_no,col8order_cron_no,dag_no from    chitha_col8_order where date(lm_note_date)>='$date' and date(lm_note_date)<='$date_upto' and order_type_code='01' ";
            $data=$this->db->query($sql)->result();
            if($data){
                foreach($data as $row){
                    $sql="SElect occupant_id,occupant_name,occupant_fmh_name,occupant_fmh_flag from    chitha_col8_occup 
					 where dist_code='$row->dist_code' and subdiv_code='$row->subdiv_code' and cir_code='$row->cir_code' and mouza_pargona_code='$row->mouza_pargona_code'
						and lot_no='$row->lot_no' and vill_townprt_code='$row->vill_townprt_code'  and dag_no='$row->dag_no' and 	col8order_cron_no='$row->col8order_cron_no' ";
                    $occupant=$this->db->query($sql)->result();
                    foreach($occupant as $occ){
                        $dataa['result'][$row->case_no."#".$occ->occupant_id."#".$row->dag_no]=array(
                            'dist'=>$row->dist_code,
                            'sub'=>$row->subdiv_code,
                            'cir'=>$row->cir_code,
                            'mou'=>$row->mouza_pargona_code,
                            'lot'=>$row->lot_no,
                            'vill'=>$row->vill_townprt_code,
                            'dag_no'=>$row->dag_no,
                            'entrydate'=>$row->lm_note_date,
                            'finaldate'=>$row->co_ord_date,
                            'occupant'=>$occ->occupant_name,
                            'gurdian'=>$occ->occupant_fmh_name,
                            'relation'=>$occ->occupant_fmh_flag,
                        );
                        //var_dump($dataa);
                    }
                }
            }
            //var_dump($dataa);
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/misreport/viewdcFieldMutation',$dataa);
            // $this->load->view('../views/footer');

            $dataa['_view'] = 'misreport/viewdcFieldMutation';
            $this->load->view('layouts/main',$dataa);

        }
    }
    function dcDeleteMutationOrder(){
        if(isset($_POST)){
            $date=date('Y-m-d',strtotime($this->input->post('date')));
            $date_upto=date('Y-m-d',strtotime($this->input->post('date_upto')));
            $sql="SElect dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,
			add_off_name,dispose_reason,case_no,if_dispose_date,date_entry from    field_mut_basic where date(date_entry)>='$date' and date(date_entry)<='$date_upto' and mut_type='01' and is_dispose='Y' ";
            $data['result']=$this->db->query($sql)->result();

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/misreport/viewdcDeleteMutation',$data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'misreport/viewdcDeleteMutation';
            $this->load->view('layouts/main',$data);

        }
    }
    function DeedViewList(){
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql="Select * from sro_note where dist_code='$dist_code' 
		 and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='0'  ";
        $data['sronote']=$this->db->query($sql)->result();
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/sro',$data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'home/sro';
        $this->load->view('layouts/main',$data);

    }
    function DCDeedViewList(){
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql="SELECT * FROM  sro_note WHERE dist_code='$dist_code' and (deed_type='SALE' or deed_type='GIFT' )  ";
        $data['sronote']=$this->db->query($sql)->result();
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/misreport/sro_dc',$data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'misreport/sro_dc';
        $this->load->view('layouts/main',$data);

    }
}
