<?php
class Basundhara3 extends CI_Controller {

  public function __construct() 
  {
    parent::__construct();
    $this->load->model('patta/pattamodel');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('file');
    $this->load->helper('download');
    $this->load->model('basundhara/SettlementApiModel');
    $this->load->model('SettlementModel/SettlementApModel');
    $this->load->model('SettlementModel/SettlementTenantModel');
    $this->load->model('rtps/rtpsmodel');
    $this->load->model('SettlementModel/SettlementVgrModel');
    $this->load->model('UtilsModel');
    $this->dbswitch();
  }
  public function dbswitch()
  {
    if($this->session->userdata('dist_code') == "02") {
      $this->db=$this->load->database('dha3', TRUE);
    } else if($this->session->userdata('dist_code') == "05") {
      $this->db=$this->load->database('dha1', TRUE);
    } else if($this->session->userdata('dist_code') == "10") {
      $this->db=$this->load->database('dha24', TRUE);
    } else if($this->session->userdata('dist_code') == "13") {
      $this->db=$this->load->database('dha2', TRUE);
    }  else if($this->session->userdata('dist_code') == "17") {
      $this->db=$this->load->database('dha4', TRUE);
    }  else if($this->session->userdata('dist_code') == "15") {
      $this->db=$this->load->database('dha5', TRUE);
    }  else if($this->session->userdata('dist_code') == "14") {
      $this->db=$this->load->database('dha6', TRUE);
    }  else if($this->session->userdata('dist_code') == "07") {
      $this->db=$this->load->database('dha7', TRUE);
    }  else if($this->session->userdata('dist_code') == "03") {
      $this->db=$this->load->database('dha8', TRUE);
    }  else if($this->session->userdata('dist_code') == "18") {
      $this->db=$this->load->database('dha9', TRUE);
    }  else if($this->session->userdata('dist_code') == "12") {
      $this->db=$this->load->database('dha13', TRUE);
    }  else if($this->session->userdata('dist_code') == "24") {
      $this->db=$this->load->database('dha10', TRUE);
    }  else if($this->session->userdata('dist_code') == "06") {
      $this->db=$this->load->database('dha11', TRUE);
    }  else if($this->session->userdata('dist_code') == "11") {
      $this->db=$this->load->database('dha12', TRUE);
    }  else if($this->session->userdata('dist_code') == "12") {
      $this->db=$this->load->database('dha13', TRUE);
    }  else if($this->session->userdata('dist_code') == "16") {
      $this->db=$this->load->database('dha14', TRUE);
    }  else if($this->session->userdata('dist_code') == "32") {
      $this->db=$this->load->database('dha15', TRUE);
    }  else if($this->session->userdata('dist_code') == "33") {
      $this->db=$this->load->database('dha16', TRUE);
    }  else if($this->session->userdata('dist_code') == "34") {
      $this->db=$this->load->database('dha17', TRUE);
    }  else if($this->session->userdata('dist_code') == "21") {
      $this->db=$this->load->database('dha18', TRUE);
    }  else if($this->session->userdata('dist_code') == "08") {
      $this->db=$this->load->database('dha19', TRUE);
    }  else if($this->session->userdata('dist_code') == "35") {
      $this->db=$this->load->database('dha20', TRUE);
    }  else if($this->session->userdata('dist_code') == "36") {
      $this->db=$this->load->database('dha21', TRUE);
    }  else if($this->session->userdata('dist_code') == "37") {
      $this->db=$this->load->database('dha22', TRUE);
    }  else if($this->session->userdata('dist_code') == "25") {
      $this->db=$this->load->database('dha23', TRUE);
    } else if ($this->session->userdata('dist_code') == "39") {
      $this->db = $this->load->database('dha39', true);
    } else if ($this->session->userdata('dist_code') == "38") {
      $this->db = $this->load->database('dha25', true);
    }
  }

  public function settlementCases(){
    $d   = $this->session->userdata('dist_code');
    $s   = $this->session->userdata('subdiv_code');
    $c   = $this->session->userdata('cir_code');
    $m   = $this->session->userdata('mouza_pargona_code');
    $l   = $this->session->userdata('lot_no');
    $u   = $this->session->userdata('user_desig_code');

    $url = API_LINK_MB3."allSettlementCases/$d/$s/$c/$m/$l/$u" ;
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $output = curl_exec($ch);
    curl_close($ch);
    $district['output'] = json_decode($output);
    $district['_view']  = 'basundhara3/settlement_servicelistmb3';
    $this->load->view('layouts/main',$district);
  }

  public function request($service){

    $curl_handle = curl_init();

    $dist_code              = $this->session->userdata('dist_code');
    $subdiv_code            = $this->session->userdata('subdiv_code');
    $cir_code               = $this->session->userdata('cir_code');
    $mouza_pargona_code     = $this->session->userdata('mouza_pargona_code');
    $lot_no                 = $this->session->userdata('lot_no');

    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getSelectListPagination/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array()));

    $result                 = curl_exec($curl_handle);
    $results                = json_decode($result);
    $district['selectList'] = $results;
    $district['service']    = $service;
    $district['_view']      = 'basundhara3/request';
    $this->load->view('layouts/main',$district);
  }

  function document($doc){
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."attachment");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'name' => $doc
    )));
    $result = curl_exec($curl_handle);
    $result = json_decode($result);
    $output=$result->raw_data;
    $content_type=$result->mime_type;
    $check=explode("/",$content_type);
    if($check[1]=='pdf'){
        $output=base64_decode($output);
        header('Content-type: application/pdf');
        echo $output;
    }else{
        echo '<img src="data:'.$content_type.';base64,'.$output.'" />';
    }
}

function settlementCasesCountCOMB3(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB3."circleDashboard/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        // var_dump($output);
        // exit;
        $district['_view'] = 'basundhara3/settlement_cases_count_co_mb3';
        $this->load->view('layouts/main',$district);
    }


    public function settlementCasesforCO()
    {
      $d   = $this->session->userdata('dist_code');
      $s   = $this->session->userdata('subdiv_code');
      $c   = $this->session->userdata('cir_code');

      $url = API_LINK_MB3."allSettlementCasesForCO/$d/$s/$c" ;
      $ch  = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $output = curl_exec($ch);
      curl_close($ch);
      $district['output'] = json_decode($output);
      $district['_view']  = 'basundhara3/settlement_servicelistmb3_for_co';
      $this->load->view('layouts/main',$district);
    }

    public function requestcasesforCO($service){

    $curl_handle = curl_init();

    $dist_code              = $this->session->userdata('dist_code');
    $subdiv_code            = $this->session->userdata('subdiv_code');
    $cir_code               = $this->session->userdata('cir_code');

    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getSelectListPaginationforCO/$service/$dist_code/$subdiv_code/$cir_code");

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array()));

    $result                 = curl_exec($curl_handle);
    $results                = json_decode($result);
    $district['selectList'] = $results;
    $district['service']    = $service;
    $district['_view']      = 'basundhara3/request_for_co';
    $this->load->view('layouts/main',$district);
  }

  function settlementCasesCountCO(){
    $d=$this->session->userdata('dist_code');
    $s=$this->session->userdata('subdiv_code');
    $c=$this->session->userdata('cir_code');
    $this->session->unset_userdata('searchKeyword');
    $url = API_LINK_MB3."circleDashboard/$d/$s/$c" ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $output = curl_exec($ch);
    curl_close($ch);
    $district['output'] = json_decode($output);
    //var_dump($output);
    // exit;
    $district['_view'] = 'basundhara3/settlement_cases_count_co_mb3';
    $this->load->view('layouts/main',$district);
  }

  function getCaseDetailsByServiceLot($service){
    $file_name=time()."_locations.xlsx";
    $d=$this->session->userdata('dist_code');
    $s=$this->session->userdata('subdiv_code');
    $c=$this->session->userdata('cir_code');
    $m=$this->session->userdata('mouza_pargona_code');
    $l=$this->session->userdata('lot_no');
    $url = API_LINK_MB3."/getCaseDetailsByServiceLot/$service/$d/$s/$c/$m/$l" ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $output = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($output);
    if(empty($data))
    {
        echo json_encode(array("NO DATA FOUND"));
        die;
    }
    // var_dump($data);
    $this->load->model('UtilsModel');
    $this->UtilsModel->downloadExcelReport($file_name,$data);
}

}

