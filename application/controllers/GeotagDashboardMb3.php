<?php
class GeotagDashboardMb3 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('UtilsModel');
        $this->load->helper(array('form', 'url'));
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
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }
    ///////////////////////////////////

    function geotagDashboard(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $url = API_LINK_MB3."circleDashboardGeoCount/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        // echo "<pre>";
        //var_dump($district['output']);
        if($district['output']->data==null){
            show_error('Error-500: No Data Found');
            return;
        }
        // exit;
        $district['_view'] = 'basundhara3/geotag_dashboard_mb3';
        $this->load->view('layouts/main',$district);
    }

    public function geotagDashboardDistrict()
    {
        $d=$this->session->userdata('dist_code');
        $url = API_LINK_MB3."districtDashboardGeoCount/$d" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        if($district['output']->data==null){
            show_error('Error-500: No Data Found');
            return;
        }
        $district['_view'] = 'basundhara3/geotag_dashboard_district_mb3';
        $this->load->view('layouts/main',$district);
    }

    public function geotagDashboardSubDiv(){
        $d=$this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        

        $url = API_LINK_MB3."districtDashboardGeoCount/$d" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output); 
        if($district['output']->data==null){
            show_error('Error-500: No Data Found');
            return;
        }
        $subdiv = $this->utilityclass->getSubDivName($d, $s);
        $district['subdiv'] = $subdiv;
        $district['_view'] = 'basundhara3/geotag_dashboard_subdiv_mb3';
        $this->load->view('layouts/main',$district);
    }



    //Get Lotwise Basundhara 3.0 Geotag on Click Circle
    function geotagDashboardCountByLotDC(){
        $d=$this->session->userdata('dist_code');
        $s = $this->input->post('subdiv_code');
        $c = $this->input->post('cir_code');
        $draw = intval($this->input->post('draw'));

        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB3."lotByCircleGeoCount/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $cirDetails = json_decode($output);

        if (isset($cirDetails)) {
            $row_count = count($cirDetails->data);

            $i=1;
            foreach ($cirDetails->data as $cirData) {
                // var_dump( $cirData);
                // echo "<br>*********************<br>";
                $mandal_name =$this->utilityclass->getLmNameGeoTag($cirData->dist_code,$cirData->subdiv_code,$cirData->cir_code,$cirData->mouza_code,$cirData->lot_no);

                $mouza_name = '<small class="" > '.$cirData->mouza.' </small><br>' ;
                $lot_name = '<small class="" > '.$cirData->lot.' </small><br>' ;

                ///Svamitva
                if($cirData->svamitva_recieved == null){
                $svamitva_recieved = '<small class="" > 0 </small><br>';

                }else{
                $svamitva_recieved = '<small class="" >  '  .$cirData->svamitva_recieved . ' </small>';
                }

                if($cirData->svamitva_uploaded == null){
                $svamitva_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $svamitva_uploaded = '<small class="" >  '  .$cirData->svamitva_uploaded . ' </small>';
                }

                if($cirData->svamitva_pending == null){
                $svamitva_pending = '<small class="" > 0 </small><br>';
                }else{
                $svamitva_pending = '<small class="" >  '  .$cirData->svamitva_pending . ' </small>';
                }

                ///Bhoodan
                if($cirData->bhoodan_recieved == null){
                $bhoodan_recieved = '<small class="" > 0 </small><br>';

                }else{
                $bhoodan_recieved = '<small class="" >  '  .$cirData->bhoodan_recieved . ' </small>';
                }

                if($cirData->bhoodan_uploaded == null){
                $bhoodan_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $bhoodan_uploaded = '<small class="" >  '  .$cirData->bhoodan_uploaded . ' </small>';
                }

                if($cirData->bhoodan_pending == null){
                $bhoodan_pending = '<small class="" > 0 </small><br>';
                }else{
                $bhoodan_pending = '<small class="" >  '  .$cirData->bhoodan_pending . ' </small>';
                }

                ///Reclass
                if($cirData->reclass_recieved == null){
                $reclass_recieved = '<small class="" > 0 </small><br>';

                }else{
                $reclass_recieved = '<small class="" >  '  .$cirData->reclass_recieved . ' </small>';
                }

                if($cirData->reclass_uploaded == null){
                $reclass_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $reclass_uploaded = '<small class="" >  '  .$cirData->reclass_uploaded . ' </small>';
                }

                if($cirData->reclass_pending == null){
                $reclass_pending = '<small class="" > 0 </small><br>';
                }else{
                $reclass_pending = '<small class="" >  '  .$cirData->reclass_pending . ' </small>';
                }


                ///Tenant
                if($cirData->tenant_recieved == null){
                $tenant_recieved = '<small class="" > 0 </small><br>';

                }else{
                $tenant_recieved = '<small class="" >  '  .$cirData->tenant_recieved . ' </small>';
                }

                if($cirData->tenant_uploaded == null){
                $tenant_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $tenant_uploaded = '<small class="" >  '  .$cirData->tenant_uploaded . ' </small>';
                }

                if($cirData->tenant_pending == null){
                $tenant_pending = '<small class="" > 0 </small><br>';
                }else{
                $tenant_pending = '<small class="" >  '  .$cirData->tenant_pending . ' </small>';
                }

                ///Tea
                if($cirData->tea_recieved == null){
                $tea_recieved = '<small class="" > 0 </small><br>';

                }else{
                $tea_recieved = '<small class="" >  '  .$cirData->tea_recieved . ' </small>';
                }

                if($cirData->tea_uploaded == null){
                $tea_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $tea_uploaded = '<small class="" >  '  .$cirData->tea_uploaded . ' </small>';
                }

                if($cirData->tea_pending == null){
                $tea_pending = '<small class="" > 0 </small><br>';
                }else{
                $tea_pending = '<small class="" >  '  .$cirData->tea_pending . ' </small>';
                }

                ///ap
                if($cirData->ap_recieved == null){
                $ap_recieved = '<small class="" > 0 </small><br>';

                }else{
                $ap_recieved = '<small class="" >  '  .$cirData->ap_recieved . ' </small>';
                }

                if($cirData->ap_uploaded == null){
                $ap_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $ap_uploaded = '<small class="" >  '  .$cirData->ap_uploaded . ' </small>';
                }

                if($cirData->ap_pending == null){
                $ap_pending = '<small class="" > 0 </small><br>';
                }else{
                $ap_pending = '<small class="" >  '  .$cirData->ap_pending . ' </small>';
                }

                ///institution
                if($cirData->ins_recieved == null){
                $ins_recieved = '<small class="" > 0 </small><br>';

                }else{
                $ins_recieved = '<small class="" >  '  .$cirData->ins_recieved . ' </small>';
                }

                if($cirData->ins_uploaded == null){
                $ins_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $ins_uploaded = '<small class="" >  '  .$cirData->ins_uploaded . ' </small>';
                }

                if($cirData->ins_pending == null){
                $ins_pending = '<small class="" > 0 </small><br>';
                }else{
                $ins_pending = '<small class="" >  '  .$cirData->ins_pending . ' </small>';
                }
                
        
                $serial = '<small  class="" >'.$i++.'</small>';


                $json[] = array(
                    $serial,
                    $mouza_name,
                    $lot_name,   
                    $mandal_name,
                    $svamitva_recieved,
                    $svamitva_uploaded,
                    $svamitva_pending,

                    $bhoodan_recieved,
                    $bhoodan_uploaded,
                    $bhoodan_pending,

                    $reclass_recieved,
                    $reclass_uploaded,
                    $reclass_pending,

                    $tenant_recieved,
                    $tenant_uploaded,
                    $tenant_pending,

                    $tea_recieved,
                    $tea_uploaded,
                    $tea_pending,


                    $ap_recieved,
                    $ap_uploaded,
                    $ap_pending,

                    $ins_recieved,
                    $ins_uploaded,
                    $ins_pending,
                    

                );

            }
            $total_records = $row_count;
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
    }else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
}

    //Get Lotwise Basundhara 3.0 Geotag Count Details End



    //Get Lotwise Basundhara 3.0 Geotag on Click Circle at SDO end
    function geotagDashboardCountByLotSDO(){
        $d=$this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->input->post('cir_code');
        $draw = intval($this->input->post('draw'));

        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB3."lotByCircleGeoCount/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $cirDetails = json_decode($output);

        if (isset($cirDetails)) {
            $row_count = count($cirDetails->data);

            $i=1;
            foreach ($cirDetails->data as $cirData) {

                $mouza_name = '<small class="" > '.$cirData->mouza.' </small><br>' ;
                $lot_name = '<small class="" > '.$cirData->lot.' </small><br>' ;

                ///Svamitva
                if($cirData->svamitva_recieved == null){
                $svamitva_recieved = '<small class="" > 0 </small><br>';

                }else{
                $svamitva_recieved = '<small class="" >  '  .$cirData->svamitva_recieved . ' </small>';
                }

                if($cirData->svamitva_uploaded == null){
                $svamitva_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $svamitva_uploaded = '<small class="" >  '  .$cirData->svamitva_uploaded . ' </small>';
                }

                if($cirData->svamitva_pending == null){
                $svamitva_pending = '<small class="" > 0 </small><br>';
                }else{
                $svamitva_pending = '<small class="" >  '  .$cirData->svamitva_pending . ' </small>';
                }

                ///Bhoodan
                if($cirData->bhoodan_recieved == null){
                $bhoodan_recieved = '<small class="" > 0 </small><br>';

                }else{
                $bhoodan_recieved = '<small class="" >  '  .$cirData->bhoodan_recieved . ' </small>';
                }

                if($cirData->bhoodan_uploaded == null){
                $bhoodan_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $bhoodan_uploaded = '<small class="" >  '  .$cirData->bhoodan_uploaded . ' </small>';
                }

                if($cirData->bhoodan_pending == null){
                $bhoodan_pending = '<small class="" > 0 </small><br>';
                }else{
                $bhoodan_pending = '<small class="" >  '  .$cirData->bhoodan_pending . ' </small>';
                }

                ///Reclass
                if($cirData->reclass_recieved == null){
                $reclass_recieved = '<small class="" > 0 </small><br>';

                }else{
                $reclass_recieved = '<small class="" >  '  .$cirData->reclass_recieved . ' </small>';
                }

                if($cirData->reclass_uploaded == null){
                $reclass_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $reclass_uploaded = '<small class="" >  '  .$cirData->reclass_uploaded . ' </small>';
                }

                if($cirData->reclass_pending == null){
                $reclass_pending = '<small class="" > 0 </small><br>';
                }else{
                $reclass_pending = '<small class="" >  '  .$cirData->reclass_pending . ' </small>';
                }


                ///Tenant
                if($cirData->tenant_recieved == null){
                $tenant_recieved = '<small class="" > 0 </small><br>';

                }else{
                $tenant_recieved = '<small class="" >  '  .$cirData->tenant_recieved . ' </small>';
                }

                if($cirData->tenant_uploaded == null){
                $tenant_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $tenant_uploaded = '<small class="" >  '  .$cirData->tenant_uploaded . ' </small>';
                }

                if($cirData->tenant_pending == null){
                $tenant_pending = '<small class="" > 0 </small><br>';
                }else{
                $tenant_pending = '<small class="" >  '  .$cirData->tenant_pending . ' </small>';
                }

                ///TEA
                if($cirData->tea_recieved == null){
                $tea_recieved = '<small class="" > 0 </small><br>';

                }else{
                $tea_recieved = '<small class="" >  '  .$cirData->tea_recieved . ' </small>';
                }

                if($cirData->tea_uploaded == null){
                $tea_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $tea_uploaded = '<small class="" >  '  .$cirData->tea_uploaded . ' </small>';
                }

                if($cirData->tea_pending == null){
                $tea_pending = '<small class="" > 0 </small><br>';
                }else{
                $tea_pending = '<small class="" >  '  .$cirData->tea_pending . ' </small>';
                }

                ///AP
                if($cirData->ap_recieved == null){
                $ap_recieved = '<small class="" > 0 </small><br>';

                }else{
                $ap_recieved = '<small class="" >  '  .$cirData->ap_recieved . ' </small>';
                }

                if($cirData->ap_uploaded == null){
                $ap_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $ap_uploaded = '<small class="" >  '  .$cirData->ap_uploaded . ' </small>';
                }

                if($cirData->ap_pending == null){
                $ap_pending = '<small class="" > 0 </small><br>';
                }else{
                $ap_pending = '<small class="" >  '  .$cirData->ap_pending . ' </small>';
                }

                ///institution
                if($cirData->ins_recieved == null){
                $ins_recieved = '<small class="" > 0 </small><br>';

                }else{
                $ins_recieved = '<small class="" >  '  .$cirData->ins_recieved . ' </small>';
                }

                if($cirData->ins_uploaded == null){
                $ins_uploaded = '<small class="" > 0 </small><br>';
                }else{
                $ins_uploaded = '<small class="" >  '  .$cirData->ins_uploaded . ' </small>';
                }

                if($cirData->ins_pending == null){
                $ins_pending = '<small class="" > 0 </small><br>';
                }else{
                $ins_pending = '<small class="" >  '  .$cirData->ins_pending . ' </small>';
                }
                
        
                $serial = '<small  class="" >'.$i++.'</small>';


                $json[] = array(
                    $serial,
                    $mouza_name,
                    $lot_name,   
                    $svamitva_recieved,
                    $svamitva_uploaded,
                    $svamitva_pending,

                    $bhoodan_recieved,
                    $bhoodan_uploaded,
                    $bhoodan_pending,

                    $reclass_recieved,
                    $reclass_uploaded,
                    $reclass_pending,

                    $tenant_recieved,
                    $tenant_uploaded,
                    $tenant_pending,

                    $tea_recieved,
                    $tea_uploaded,
                    $tea_pending,


                    $ap_recieved,
                    $ap_uploaded,
                    $ap_pending,

                    $ins_recieved,
                    $ins_uploaded,
                    $ins_pending,
                    

                );

            }
            $total_records = $row_count;
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
    }else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
}

    //Get Lotwise Basundhara 3.0 Geotag Count Details End

}

