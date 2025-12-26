<?php

if (!defined('BASEPATH'))
 exit('No direct script access allowed');

class CitizenController extends CI_Controller {

 public function __construct() {
  parent::__construct();
  $this->load->model('mutation/cofieldmutationmodel');
  $this->load->model('APCancellation/APCancellationModel');
  $this->load->model('mutation/mutationmodel');
  $this->load->model('basundhara/basundharamodel');
  $this->load->model('rtps/rtpsmodel');
  $this->load->model('jamabandi/JamabandiModel');
  $this->load->model('CitizenCentric_Model');
  $this->load->model('validation/AuthorizationModel');
  $this->load->model('validation/FormValidationModel');
}

public function dbswitch(){       
  $CI=&get_instance();
  if($this->session->userdata('dist_code') == "02"){
   $this->db=$CI->load->database('dha3', TRUE);    
 } else if($this->session->userdata('dist_code') == "05"){
   $this->db=$CI->load->database('dha1', TRUE);    
 } else if($this->session->userdata('dist_code') == "10"){
   $this->db=$CI->load->database('dha24', TRUE);       
 } else if($this->session->userdata('dist_code') == "13"){
   $this->db=$CI->load->database('dha2', TRUE);    
 }  else if($this->session->userdata('dist_code') == "17"){
   $this->db=$CI->load->database('dha4', TRUE);    
 }  else if($this->session->userdata('dist_code') == "15"){
   $this->db=$CI->load->database('dha5', TRUE);    
 }  else if($this->session->userdata('dist_code') == "14"){
   $this->db=$CI->load->database('dha6', TRUE);    
 }  else if($this->session->userdata('dist_code') == "07"){
   $this->db=$CI->load->database('dha7', TRUE);    
 }  else if($this->session->userdata('dist_code') == "03"){
   $this->db=$CI->load->database('dha8', TRUE);    
 }  else if($this->session->userdata('dist_code') == "18"){
   $this->db=$CI->load->database('dha9', TRUE);    
 }  else if($this->session->userdata('dist_code') == "12"){
   $this->db=$CI->load->database('dha13', TRUE);   
 }  else if($this->session->userdata('dist_code') == "24"){
   $this->db=$CI->load->database('dha10', TRUE);   
 }  else if($this->session->userdata('dist_code') == "06"){
   $this->db=$CI->load->database('dha11', TRUE);   
 }  else if($this->session->userdata('dist_code') == "11"){
   $this->db=$CI->load->database('dha12', TRUE);   
 }  else if($this->session->userdata('dist_code') == "12"){
   $this->db=$CI->load->database('dha13', TRUE);   
 }  else if($this->session->userdata('dist_code') == "16"){
   $this->db=$CI->load->database('dha14', TRUE);   
 }  else if($this->session->userdata('dist_code') == "32"){
   $this->db=$CI->load->database('dha15', TRUE);   
 }  else if($this->session->userdata('dist_code') == "33"){
   $this->db=$CI->load->database('dha16', TRUE);   
 }  else if($this->session->userdata('dist_code') == "34"){
   $this->db=$CI->load->database('dha17', TRUE);   
 }  else if($this->session->userdata('dist_code') == "21"){
   $this->db=$CI->load->database('dha18', TRUE);   
 }  else if($this->session->userdata('dist_code') == "08"){
   $this->db=$CI->load->database('dha19', TRUE);   
 }  else if($this->session->userdata('dist_code') == "35"){
   $this->db=$CI->load->database('dha20', TRUE);   
 }  else if($this->session->userdata('dist_code') == "36"){
   $this->db=$CI->load->database('dha21', TRUE);   
 }  else if($this->session->userdata('dist_code') == "37"){
   $this->db=$CI->load->database('dha22', TRUE);   
 }  else if($this->session->userdata('dist_code') == "25"){
   $this->db=$CI->load->database('dha23', TRUE);   
 }                                                                                                                                                                                                              
}



public function index() {
  $data['_view'] = 'citizen/Asstt_first_reg';
  $this->load->view('layouts/main',$data);
}

public function RegisterApplicant() {
  $data = array();
  // $dist_code = $this->session->userdata('dist_code');
  // $subdiv_code = $this->session->userdata('subdiv_code');
  // $cir_code = $this->session->userdata('cir_code');

  $data['names'] = $this->mutationmodel->getDistricts();
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
  $data['d'] = $dist_code;
  $data['s'] = $subdiv_code;
  $data['c'] = $cir_code;
  $data['mouzas'] = $mouzas;

  if(RTPS_CERT_ON_OFF=='1'){
   $sql = "select * from cert_type where cert_code not in ('01','07')";
  }else{
    $sql = "select * from cert_type ";
  }
 $data['certtype'] = $this->db->query($sql)->result();
 $sql = "Select * from patta_code where type_code!='0000'";
 $data['patttype'] = $this->db->query($sql)->result();
 $data['_view'] = 'citizen/apply_reg';
 $this->load->view('layouts/main',$data);
}

public function Applicant() {
  //filtering
  if(!isset($_POST['dist_code']) || !isset($_POST['subdiv_code']) || !isset($_POST['circle_code']) || !isset($_POST['mouza_code']) || !isset($_POST['lot_no']) || !isset($_POST['vill_code']) || !isset($_POST['cert_type']) || !isset($_POST['date_entry']) || !isset($_POST['patta_code']) || !isset($_POST['patta_no']) || !isset($_POST['cert_fees']) || !isset($_POST['revenue']) || $_POST['dist_code']=='' || $_POST['subdiv_code']=='' || $_POST['circle_code']=='' || $_POST['mouza_code']=='' || $_POST['lot_no']=='' || $_POST['vill_code']=='' || $_POST['cert_type']=='' || $_POST['date_entry']=='' || $_POST['patta_code']=='' || $_POST['patta_no']=='' || $_POST['cert_fees']=='' || $_POST['revenue']=='') {
    //ERRAPPREGAST0001
    log_message('error', 'The required fields are empty. Error: ERRAPPREGAST0001');
    $this->session->set_flashdata('message', 'The required fields are empty. Error: ERRAPPREGAST0001');
    redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
    return false;
  }

  //syntax validation
  $res = checkRequestSpecChar($_POST, [], ['cert_type' => 'Application type']);
  if($res['status']=='n') {
      //ERRAPPREGAST0002
      log_message('error', $res['messages'] .'Error: ERRAPPREGAST0002');
      $this->session->set_flashdata('message', $res['messages'] .'Error: ERRAPPREGAST0002');
      redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
      return false;
  }

   //check for Malicious
   $validquery = checkRequestValidQuery($_POST);
   if($validquery['status']=='n') {
     //ERRAPPREGAST0006
     log_message('error', $validquery['messages'] .'Error: ERRAPPREGAST0006');
     $this->session->set_flashdata('message', 'Input parameters contain malicious characters. Error: ERRAPPREGAST0006');
      redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
      return false;
   }
  
  // form validation
  $formResult = $this->FormValidationModel->formValidationForPost($_POST, [
    'dist_code'=>'District Code|required|digit',
    'subdiv_code'=>'Subdiv Code|required|digit',
    'circle_code'=>'Circle Code|required|digit',
    'mouza_code'=>'Mouza Pargona Code|required|digit',
    'lot_no'=>'Lot No.|required|digit',
    'vill_code'=>'Village Code|required|digit',
    'cert_type'=>'Certificate Type|required',
    'date_entry'=>'Date Entry|required|date',
    'patta_code'=>'Patta Code|required|digit',
    'patta_no'=>'Patta No.|required|digit',
    'cert_fees'=>'Certificate fees|required|2_digit_decimal',
    'revenue'=>'Revenue|required|char'
  ]);
  // $formResult = postParamFormValidation($_POST, [
  //   'cert_type'=>'',
  //   'date_entry'=>'date',
  //   'dist_code'=>'digit',
  //   'subdiv_code'=>'digit',
  //   'circle_code'=>'digit',
  //   'mouza_code'=>'digit',
  //   'lot_no'=>'digit',
  //   'vill_code'=>'digit',
  //   'patta_code'=>'digit',
  //   'patta_no'=>'digit',
  //   'cert_fees'=>'2_digit_decimal',
  //   'revenue'=>'char'
  // ]);
  if($formResult['status']=='n') {
    //ERRAPPREGAST0003
    log_message('error', 'Message: '. $formResult['message'] .', Data: '. json_encode($formResult['data']) .'. Error: ERRAPPREGAST0003');
    $this->session->set_flashdata('message', $formResult['message'] .'. Error: ERRAPPREGAST0003');
    redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
  }

  // authorization
  $response = $this->AuthorizationModel->isAuthorized(100, 'AST', $_POST);
  if($response['status']=='n') {
    //ERRAPPREGAST0004
    log_message('error', $response['messages'] .' Error: ERRAPPREGAST0004');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRAPPREGAST0005');
    redirect(base_url('index.php/home'));
  }
  //authentication
  //ERRAPPREGAST0004
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData)) {
  //   log_message('error', 'User not logged in! Error: ERRAPPREGAST0004');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRAPPREGAST0004');
  //   redirect(base_url('index.php/home'));
  // }

  //authorization
  //ERRAPPREGAST0005
  // if($sessionData['user_desig_code']!='AST' || $sessionData['dist_code']!=$_POST['dist_code'] || $sessionData['subdiv_code']!=$_POST['subdiv_code'] || $sessionData['cir_code']!=$_POST['circle_code']) {
  //   log_message('error', 'User not authorized! Error: ERRAPPREGAST0005');
  //   $this->session->set_flashdata('message', 'User not authorized! Error: ERRAPPREGAST0005');
  //   redirect(base_url('index.php/home'));
  // }

  $data = array();
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');

  $mouza_pargona_code = $this->input->post('mouza_code');
  $lot_no = $this->input->post('lot_no');
  $vill_townprt_code = $this->input->post('vill_code');
  $certificate_name = $this->input->post('cert_type');
  $cer_name = explode("#", $certificate_name);
  $patta_no = trim($this->input->post('patta_no'));
  $patta_type_code = $this->input->post('patta_code');
  $cert_fees = $this->input->post('cert_fees');
  $revenue = $this->input->post('revenue');
  $date_entry = $this->input->post('date_entry');
  $mutCaseNo  =  $this->input->post('mutCaseNo');
  $details = array(
   'mouza_pargona_code' => $mouza_pargona_code,
   'lot_no' => $lot_no,
   'vill_townprt_code' => $vill_townprt_code,
   'cert_code' => $cer_name[0],
   'cert_type' => $cer_name[1],
   'delivery_date' => $cer_name[2],
   'patta_no' => $patta_no,
   'patta_type_code' => $patta_type_code,
   'cert_fees' => $cert_fees,
   'revenue' => $revenue,
   'date_entry' => $date_entry,
   'mutCaseNo' => $mutCaseNo
 );
  $this->session->set_userdata($details);

  $patta_no = trim($patta_no);
  $sql = "Select pdar_id,pdar_name,pdar_father,pdar_aadharno,pdar_mobile,pdar_pan_no from jama_pattadar WHERE "
  . "dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? "
  . "and lot_no = ? and vill_townprt_code = ? and patta_type_code=? and "
  . "TRIM(patta_no)=? and (p_flag!='1' or p_flag is null) order by cast(pdar_id as int) ASC";

  $data['pattaDar'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no))->result();
  // echo '<pre>';
  // var_dump($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no);
  // die();
  $sql = "Select * from master_guard_rel";
  $data['guardRel'] = $this->db->query($sql)->result();
  $data['_view'] = 'citizen/applicant_pattadar';
  $this->load->view('layouts/main',$data);
}

public function getfee($cer_code) {
  if($cer_code=='' || $cer_code=='00') {
    $json[]=array('error'=>'Empty Input');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }
  if(!preg_match('/^[0-9]*$/', $cer_code)) {
    $json[]=array('error'=>'Invalid Input Request');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }
  //authentication
  $sessionData = $this->session->all_userdata();
  if(empty($sessionData)) {
    $json[]=array('error'=>'User not Authenticated!');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }

  $db=  $this->session->userdata('db');
  $q = "select * from cert_type where cert_code=?";
  $data = $this->db->query($q, array($cer_code));
  $data = $data->result();
  $json = array();
  foreach ($data as $object) {
   $json[] = array('cert_fees' => number_format($object->cert_fees, 2));
  }
  echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

function getAllMutCase($pp,$m,$l,$v){
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $sql="   SELECT pb.case_no as case_no from    petition_basic as pb INNER JOIN  petition_dag_details as pd
  ON pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code where pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$m' and pb.lot_no='$l' and pb.vill_townprt_code='$v' and  pb.mut_type='03' and (pb.status= 'F' or pb.status=  'D') and pd.patta_no='$pp'  order by pb.year_no ";
  $data = $this->db->query($sql);
  $data = $data->result();
  $json = array();
  foreach ($data as $object) {
   $json[] = array('case_no' => $object->case_no);
 }
 echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

public function getPdarData($pdar_id) {
  if($pdar_id=='') {
    $json[]=array('error'=>'Empty Input');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }
  if(!preg_match('/^[0-9]*$/', $pdar_id)) {
    $json[]=array('error'=>'Invalid Input Request');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }
  //authentication
  $sessionData = $this->session->all_userdata();
  if(empty($sessionData)) {
    $json[]=array('error'=>'User not Authenticated!');
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    exit;
  }
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $patta_no = trim($this->session->userdata('patta_no'));
  $patta_type_code = $this->session->userdata('patta_type_code');
  $sql = "Select * from jama_pattadar WHERE dist_code = ? and subdiv_code = ? and cir_code = ? and"
  . " mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and"
  . " patta_type_code=? and TRIM(patta_no)=? and pdar_id=? and (p_flag!='1' or p_flag is null) order by pdar_id  ";
        //echo $sql;
  $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no, $pdar_id))->result();
  $json = array();
  foreach ($data as $object) {
   $pdar_guard_reln = 'u';
   $json[] = array('pdar_id' => $object->pdar_id, 'pdar_name' => $object->pdar_name,
    'pdar_father' => $object->pdar_father, 'pdar_guard_reln' => $pdar_guard_reln,
    'pdar_aadharno' => $object->pdar_aadharno, 'pdar_mobile' => $object->pdar_mobile, 'pdar_nrcno' => $object->pdar_nrcno);
 }
 echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

private function getPdarInfos($pdar_id) {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $patta_no = trim($this->session->userdata('patta_no'));
  $patta_type_code = $this->session->userdata('patta_type_code');
  $sql = "Select * from jama_pattadar WHERE dist_code = ? and subdiv_code = ? and cir_code = ? and"
  . " mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and"
  . " patta_type_code=? and TRIM(patta_no)=? and pdar_id=? and (p_flag!='1' or p_flag is null) order by pdar_id  ";
        //echo $sql;
  $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type_code, $patta_no, $pdar_id))->result();
  $json = array();
  foreach ($data as $object) {
   $pdar_guard_reln = 'u';
   $json[] = array('pdar_id' => $object->pdar_id, 'pdar_name' => $object->pdar_name,
    'pdar_father' => $object->pdar_father, 'pdar_guard_reln' => $pdar_guard_reln,
    'pdar_aadharno' => $object->pdar_aadharno, 'pdar_mobile' => $object->pdar_mobile, 'pdar_nrcno' => $object->pdar_nrcno);
  }
  return $json;
//  echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

public function ApplicantRecipet(){
  if(!isset($_POST['pdar_id']) || $_POST['pdar_id']=='') {
    //ERRAPPREGASTPATTD0001
    log_message('error', 'Input fields are empty. Error: ERRAPPREGASTPATTD0001');
    $this->session->set_flashdata('message', "Input fields are empty. Error: ERRAPPREGASTPATTD0001");
    redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
    exit;
  }
  
  //syntax validation
  $res = checkRequestSpecChar($_POST);
  if($res['status']=='n') {
      //ERRAPPREGASTPATTD0002
      log_message('error', 'Post Parameter contain special character. Error: ERRAPPREGASTPATTD0002');
      $this->session->set_flashdata('message', "Post Parameter contain special character. Error: ERRAPPREGASTPATTD0002");
      redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
      exit;
  }

  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRAPPREGASTPATTD0008
    log_message('error', $validquery['messages'] .'Error: ERRAPPREGASTPATTD0008');
    $this->session->set_flashdata('message', 'Input Contains malicious characters. Error: ERRAPPREGASTPATTD0008');
     redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
     exit;
  }

  // form validation
  $formResult = $this->FormValidationModel->formValidationForPost($_POST, [
    'pdar_id'=>'Pattadar Id|required|digit',
    'mobile_no'=>'Mobile No.|mobile_number'
  ]);
  // $formResult = postParamFormValidation($_POST, [
  //   // 'pdar_name'=>'',
  //   'pdar_id'=>'digit',
  //   // 'guard_rel'=>'',
  //   // 'aadhar_no'=>'',
  //   // 'pan_no'=>'',
  //   'mobile_no'=>'digit',
  //   // 'relation'=>'char'
  // ]);
  if($formResult['status']=='n') {
    //ERRAPPREGASTPATTD0003
    log_message('error', 'Message: '. $formResult['message'] .', Data: '. json_encode($formResult['data']) .'. Error: ERRAPPREGASTPATTD0003');
    $this->session->set_flashdata('message', $formResult['message'] .'. Error: ERRAPPREGASTPATTD0003');
    redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
  }

  // if(strlen($_POST['mobile_no'])!=10) {
  //   //ERRAPPREGASTPATTD0004
  //   log_message('error', 'Mobile No. must be of length 10. Error: ERRAPPREGASTPATTD0004');
  //   $this->session->set_flashdata('message', 'Mobile No. must be of length 10. Error: ERRAPPREGASTPATTD0004');
  //   redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
  // }

  //authentication
  //ERRAPPREGASTPATTD0005
  $sessionData = $this->session->all_userdata();
  if(empty($sessionData)) {
    log_message('error', 'User not logged in! Error: ERRAPPREGASTPATTD0005');
    $this->session->set_flashdata('message', 'User not logged in! Error: ERRAPPREGASTPATTD0005');
    redirect(base_url('index.php/home'));
  }
  //authorization
  if($sessionData['user_desig_code']!='AST') {
    //ERRAPPREGASTPATTD0006
    log_message('error', 'User not Authorized! Error: ERRAPPREGASTPATTD0006');
    $this->session->set_flashdata('message', 'User not Authorized! Error: ERRAPPREGASTPATTD0006');
    redirect(base_url('index.php/home'));
  }
  $pattadarInfo = $this->getPdarInfos($_POST['pdar_id']);
  if(empty($pattadarInfo)) {
    //ERRAPPREGASTPATTD0007
    log_message('error', 'Wrong Pattadar Info. Error: ERRAPPREGASTPATTD0007');
    $this->session->set_flashdata('message', 'Wrong Pattadar Info. Error: ERRAPPREGASTPATTD0007');
    redirect(base_url('index.php/citizencontroller/RegisterApplicant'));
  }
  
  $data = array();
  // $data['pdar_name'] = $pdar_name = $this->input->post('pdar_name');
  $data['pdar_name'] = $pdar_name = $pattadarInfo[0]['pdar_name'];
  // $data['guard_rel'] = $guard_rel = $this->input->post('guard_rel');
  $data['guard_rel'] = $guard_rel = $pattadarInfo[0]['pdar_father'];
  // $data['relation'] = $relation = $this->input->post('relation');
  $data['relation'] = $relation = $pattadarInfo[0]['pdar_guard_reln'];
  $data['pdar_mobile'] = $pdarMobile = $this->input->post('mobile_no');
  $pdar_id = $this->input->post('pdar_id');
  // $pdar_aadhar = $this->input->post('aadhar_no');
  // $pdar_mobile = $this->input->post('mobile_no');
  // $pdar_pan = $this->input->post('pan_no');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $cert_type = $this->session->userdata('cert_code');
  $mutCaseNo = $this->session->userdata('mutCaseNo');
  $year_no = date('Y');
  $fee_amount = $this->session->userdata('cert_fees');
  $patta_no = trim($this->session->userdata('patta_no'));
  $patta_type_code = $this->session->userdata('patta_type_code');
  $apply_date = date('Y-m-d G:i:s');
  $due_date = $this->utilityclass->getDaysAfter($this->session->userdata('delivery_date'));
  $receipt_gen_yn = 'Y';
  $status = 'M';
  $user_code = $this->session->userdata('user_code');
  $date_entry = date('Y-m-d G:i:s');
  $rev_yn = $this->session->userdata('revenue');
  $location = $this->utilityclass->getLocationfromSession();
  $dist = $this->utilityclass->getDistrictName($dist_code);
  $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
  $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
  $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
  $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
  $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

  $cername = $this->utilityclass->getCertCode($cert_type);
  $rev_name = $this->utilityclass->getRevenuLoc($dist_code, $subdiv_code, $cir_code);
  $case_name=$this->basundharamodel->genearteCaseName();
 // $petition_no=$this->basundharamodel->genearteCertPetitionNo();

  $seq_pet=year_no.'000';
  $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteCertPetitionNo();
  $appln_no = $cername . "/" . $petition_no . "/" . $year_no;


  $data['cert_no']=$cert_no =$case_name.$petition_no."/".$cername;

  $data['location'] = array(
   'distname' => $dist,
   'subname' => $sub,
   'cirname' => $cir,
   'mouza_pargona_code' => $mouza_name,
   'lot_no' => $lotname,
   'vill_townprt_code' => $vill_name,
   'case_no' => $appln_no
  );
  $q = "Select count(*) as id from cert_application where dist_code=? 
  and cir_code=? and subdiv_code=? and cert_no=?";
  $num_rows = $this->db->query($q, array($dist_code, $cir_code, $subdiv_code, $cert_no))->row()->id;
  if ($num_rows != 0) {
   $msg = "Error Found in processing. Please Try Again. Duplicate Entry found with the application no $appln_no !!";
   $this->session->set_flashdata('message', $msg);
   redirect(base_url() . 'index.php/home');
   exit;
  }
 $insert = array(
   'dist_code' => $dist_code,
   'subdiv_code' => $subdiv_code,
   'cir_code' => $cir_code,
   'mouza_pargona_code' => $mouza_pargona_code,
   'lot_no' => $lot_no,
   'vill_townprt_code' => $vill_townprt_code,
   'cert_type' => $cert_type,
   'appln_no' => $appln_no,
   'cert_no' => $cert_no,
   'year_no' => $year_no,
   'fee_amount' => $fee_amount,
   'patta_no' => trim($patta_no),
   'patta_type_code' => $patta_type_code,
   'pdar_id' => $pdar_id,
   'appln_name' => $pdar_name,
   'appln_guard' => $guard_rel,
   'guard_reln' => $relation,
   'apply_date' => $apply_date,
   'next_due_date' => $due_date,
   'receipt_gen_yn' => $receipt_gen_yn,
   'status' => $status,
   'user_code' => $user_code,
   'date_entry' => $date_entry,
   'rev_yn' => $rev_yn,
   'mut_case_no' => $mutCaseNo,
   'pdar_aadharno' => $this->session->userdata('aadhar_no'),
  //  'pdar_mobile' => $this->session->userdata('mobileNo'),
   'pdar_mobile' => $pdarMobile,
   'pdar_pan' => $this->session->userdata('pdar_pan')
 );

  if($cert_type=='07'){
    $insert['lm_checked_yn']='Y';
    $insert['status']='C';
  }

  $this->db->insert("cert_application", $insert);

    //////////Dashboard////////////////
  $this->Dashboard($cert_no);
          /////////////////////////
  $rows = $this->db->affected_rows();
  if ($rows == 1) {
    if ($cert_type == '02') {
      //For land holding
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);
    } elseif ($cert_type == '03') {
      //For income Certificate
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);

    } elseif ($cert_type == '01') {
      //For jamabandi nakal
      $data['_view'] = 'citizen/applicant_receipet_probationary';
      $this->load->view('layouts/main',$data);

    } elseif ($cert_type == '04') {
      //For land valuation
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);

    } elseif ($cert_type == '05') {
      //For annual patta
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);

    } elseif ($cert_type == '06') {
      //For Periodic Patta
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);

    }elseif ($cert_type == '07') {
      //For Periodic Patta
      $data['_view'] = 'citizen/applicant_receipet';
      $this->load->view('layouts/main',$data);
    }
  }
}
public function SaveCitizenCentric() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->post('cert_no');
  $msg = "Application has been Successfully Registered . Application No. ##" . $cert_no;
  $this->session->set_flashdata('message', $msg);
  redirect(base_url() . 'index.php/home');
}
public function SecondAssttStep1() {
  $data['_view'] = 'Citizen/AssttGenerateCert';
  $this->load->view('layouts/main',$data);
}
public function AssttPrintCert() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->get('cert_no');
  $cert_type = $this->input->get('certtype');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $define_date = define_date;
  $data = array();
  $sql = "Select * from cert_application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
  $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
  $mouza_pargona_code = $certDtls->mouza_pargona_code;
  $lot_no = $certDtls->lot_no;
  $vill_townprt_code = $certDtls->vill_townprt_code;
  $tot_price = 0;
  if ($cert_type != '03' and $cert_type != '01' and $cert_type != '04' and $cert_type != '07') {
    $sql = "Select * from cert_dag_details where dist_code='$dist_code' "
    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
    $data['dagDtls'] = $certDag = $this->db->query($sql)->result();
    foreach ($certDag as $certDag) {
      $bigha = $certDag->a_dag_area_b;
      $katha = $certDag->a_dag_area_k;
      $lessa = $certDag->a_dag_area_lc;
      $lv_katha_price = $certDtls->lv_katha_price;
      $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
      $tot_price = round($tot_katha * $lv_katha_price, 2);
    }
    $sql = "Select * from chitha_basic where dist_code='$dist_code' "
    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
    . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
    . "patta_type_code='$certDtls->patta_type_code'  ";
    $data['cb'] = $this->db->query($sql)->row();
  }

if ($cert_type == '07') {
 $query = "select * from    petition_proceeding where case_no = '$certDtls->mut_case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
 . "and cir_code='$cir_code'";
 $data['cases'] = $this->db->query($query)->result();
}
if ($cert_type == '04') {
 $sql = "Select * from    cert_dag_details where dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
 $data['dagDtls'] = $certDag = $this->db->query($sql)->row();
            //foreach($certDag as $certDag){
 $bigha = $certDag->a_dag_area_b;
 $katha = $certDag->a_dag_area_k;
 $lessa = $certDag->a_dag_area_lc;
 $lv_katha_price = $certDtls->lv_katha_price;
 $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
 $tot_price = round($tot_katha * $lv_katha_price, 2);
            //}
 $sql = "Select * from    chitha_basic where dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
 . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
 . "patta_type_code='$certDtls->patta_type_code'  ";
 $data['cb'] = $this->db->query($sql)->row();
}

$sql = "Select * from    loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
$name = $this->db->query($sql)->result();
foreach ($name as $n) {
 $q = "select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
 and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
 $data['users'] = $this->db->query($q)->result();
}

$location = $this->utilityclass->getLocationfromSession();
$dist = $this->utilityclass->getDistrictName($dist_code);
$sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
$cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
$mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
$lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
$vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //The following line added by Bijoy Mazumder, DIO, Bongaigaon on 26/04/2017 to count no of Pattadar against a Patta No.
$sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
. "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
. " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
. "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

$dataCNT = $this->db->query($sqlCNT)->row();
$data['location'] = array(
 'distname' => $dist,
 'subname' => $sub,
 'cirname' => $cir,
 'mouza_pargona_code' => $mouza_name,
 'lot_no' => $lotname,
 'vill_townprt_code' => $vill_name,
 'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 //added by Bijoy
          );
$this->load->helper('qrcode');
$base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
$data['qrcode'] = $base_64;
if ($cert_type == '02') {
 $data['_view'] = 'citizen/AssttPrintCert';

} elseif ($cert_type == '03') {
  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
  {
  $data['_view'] = 'citizen/AssttPrintCertIC_kar';
  }
  else{
  $data['_view'] = 'citizen/AssttPrintCertIC';
  }
} elseif ($cert_type == '01') {
 $data['_view'] = 'citizen/AssttPrintCertJB';
} elseif ($cert_type == '04') {
 $data['_view'] = 'citizen/AssttPrintCertLV';
} elseif ($cert_type == '05') {
 $data['_view'] = 'citizen/AssttPrintCertAP';
} elseif ($cert_type == '06') {
 $data['_view'] = 'citizen/AssttPrintCertPP';
}elseif ($cert_type == '07') {
 $data['_view'] = 'citizen/AssttPrintCertOS';
}
$this->load->view('layouts/main',$data);
}

public function AssttPrintCertPageCount() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->get('cert_no');
  $cert_type = $this->input->get('certtype');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $define_date = define_date;
  $data = array();
  $sql = "Select * from    cert_application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
  $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
  $mouza_pargona_code = $certDtls->mouza_pargona_code;
  $lot_no = $certDtls->lot_no;
  $vill_townprt_code = $certDtls->vill_townprt_code;
  $tot_price = 0;
  if ($cert_type != '03' and $cert_type != '01' and $cert_type != '04') {
   $sql = "Select * from    cert_dag_details where dist_code='$dist_code' "
   . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
   $data['dagDtls'] = $certDag = $this->db->query($sql)->result();
   foreach ($certDag as $certDag) {
    $bigha = $certDag->a_dag_area_b;
    $katha = $certDag->a_dag_area_k;
    $lessa = $certDag->a_dag_area_lc;
    $lv_katha_price = $certDtls->lv_katha_price;
    $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
    $tot_price = round($tot_katha * $lv_katha_price, 2);
  }
  $sql = "Select * from    chitha_basic where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
  . "patta_type_code='$certDtls->patta_type_code'  ";
  $data['cb'] = $this->db->query($sql)->row();
}

if ($cert_type == '04') {
 $sql = "Select * from    cert_dag_details where dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
 $data['dagDtls'] = $certDag = $this->db->query($sql)->row();
 $bigha = $certDag->a_dag_area_b;
 $katha = $certDag->a_dag_area_k;
 $lessa = $certDag->a_dag_area_lc;
 $lv_katha_price = $certDtls->lv_katha_price;
 $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
 $tot_price = round($tot_katha * $lv_katha_price, 2);
            //}
 $sql = "Select * from    chitha_basic where dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
 . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
 . "patta_type_code='$certDtls->patta_type_code'  ";
 $data['cb'] = $this->db->query($sql)->row();
}

$sql = "Select * from    loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
$name = $this->db->query($sql)->result();
foreach ($name as $n) {
 $q = "select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
 and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
 $data['users'] = $this->db->query($q)->result();
}

$location = $this->utilityclass->getLocationfromSession();
$dist = $this->utilityclass->getDistrictName($dist_code);
$sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
$cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
$mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
$lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
$vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //The following line added by Bijoy Mazumder, DIO, Bongaigaon on 26/04/2017 to count no of Pattadar against a Patta No.
$sqlCNT = "Select count(*) as c1 from    jama_pattadar where dist_code='$dist_code' "
. "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
. " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
. "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

$dataCNT = $this->db->query($sqlCNT)->row();
        //$dataCNT = $this->db->query($sqlstr)->row();
        //-------------------------------------------------------------------------
$data['location'] = array(
 'distname' => $dist,
 'subname' => $sub,
 'cirname' => $cir,
 'mouza_pargona_code' => $mouza_name,
 'lot_no' => $lotname,
 'vill_townprt_code' => $vill_name,
 'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 //added by Bijoy
          );
$this->load->helper('qrcode');
$base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
$data['qrcode'] = $base_64;
if ($cert_type == '01') {
 $data['_view'] = 'Citizen/AssttPrintCertPageCount';
} else {
 redirect(base_url() . 'index.php/home');
 exit();
}
$this->load->view('layouts/main',$data);
}

public function CaseDelivered() {
  $db=  $this->session->userdata('db');
  $case_no = $this->input->post('case_no');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $arr = array(
   'status' => 'D',
   'user_code' => $user_code
 );
  $this->db->where('cert_no', $case_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->update("cert_application", $arr);
        //////////////////////
  $this->DashboardDataFinal($case_no);
        /////////////////////////
  $msg = "Certificate Delivered. Application No. ##" . $case_no;
  $this->session->set_flashdata('message', $msg);
  redirect(base_url() . 'index.php/home');
  exit();
}

public function pendingJamaBondi() {
  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
  $case_no = $this->input->post('case_no');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $q = "Select ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no where cert_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
  $data['certapp'] = $this->db->query($q)->row();
  $data['_view'] = 'citizen/Pendingreasonjamabondi';
  $this->load->view('layouts/main',$data);
}

public function UpdateJamabandingpending() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->post('cert_no');
  $user_code = $this->session->userdata('user_code');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');

  $q = "Select ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no where cert_no='$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

  $certapp = $this->db->query($q)->row();


  $data = array(
   'dist_code' => $dist_code,
   'subdiv_code' => $subdiv_code,
   'cir_code' => $cir_code,
   'mouza_pargona_code' => $certapp->mouza_pargona_code,
   'lot_no' => $certapp->lot_no,
   'vill_townprt_code' => $certapp->vill_townprt_code,
   'appln_no' => $certapp->appln_no,
   'pending_by' => $user_code,
   'reason_pending' => $this->input->post('pendingreason'),
   'next_due_date' => $certapp->next_due_date,
   'disposed_yn' => $certapp->status,
   'cert_no' => $cert_no,
   'year_no' => $certapp->year_no,
   'pending_date' => date('Y-m-d G:i:s')
 );

  $this->db->insert("cert_pending", $data);
  redirect(base_url() . 'index.php/home');
}

public function UpdateJamaBondi() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->post('cert_no');
  $fee_amount = $this->input->post('fee_amt');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');

  $dist = $this->utilityclass->getDistrictName($dist_code);
  $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

  $q = "Select * from    cert_application where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
  $result = $this->db->query($q)->row();
  $cername = $this->utilityclass->getCertName($result->cert_type);
  $data = array(
   'status' => 'D',
   'user_code' => $user_code,
   'current_date' => date('Y-m-d G:i:s'),
   'next_due_date' => $result->next_due_date,
   'number_of_pages' => $this->input->post('number_of_pages'),
   'total_fee_amt' => $this->input->post('fee_amt'),
   'cert_no' => $cert_no,
   'applicant_name' => $result->appln_name,
   'appln_guard' => $result->appln_guard,
   'cert_type' => $cername,
   'district' => $dist,
   'circle' => $cir,
   'mobile_no' => $result->pdar_mobile,
 );
  $data['_view'] = 'citizen/applicant_receipet_jamabandi';
  $this->load->view('layouts/main',$data);
}

public function UpdateJamabandiFinal() {
  $db=  $this->session->userdata('db');
  $cert_no = $this->input->get('cert_no');
  $fee_amount = $this->input->get('fee_amt');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');

  $data = array(
   'status' => 'D',
   'user_code' => $user_code,
   'next_due_date' => date('Y-m-d G:i:s'),
   'fee_amount' => $fee_amount
 );
        //var_dump($data);
  $this->db->where('cert_no', $cert_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->update("cert_application", $data);
         /////////////////////////
  $this->DashboardDataFinal($cert_no);
        ///////////////////////////
  $this->session->set_flashdata('message', 'Record Of Rights Delivered Successfully !!');
  redirect(base_url() . 'index.php/home');
}

public function LMStep1(){
  $this->load->library('pagination');
  $data = array();
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');

  $cases = $this->db->query("SELECT ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no  WHERE dist_code=? "
   . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
   . " lot_no=? and LM_Checked_yn is null ", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
  $data['cases'] = $cases;
  $data['_view'] = 'Citizen/PendingCases';
  $this->load->view('layouts/main',$data);
}

public function LMStep2() {
  $cert_no = $this->input->get('cert_no');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $data['data']  = $this->db->query("Select ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no where dist_code=? "
   . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
   . " lot_no=? and cert_no=? ", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $cert_no))->row();
  $db = $data['data'];
  $values = array(
   'appln_no' => $db->appln_no, 'cert_no' => $db->cert_no,
   'apply_date' => $db->apply_date, 'next_due_date' => $db->next_due_date,
   'vill_townprt_code' => $db->vill_townprt_code, 'cert_codeNo' => $db->cert_type, 
   'patta_type_code' => $db->patta_type_code, 'application_ref_no' => $db->application_ref_no, 'applid' => $db->applid,'basundhara'=>$db->basundhara);

  $sql = "Select * from  cert_co_lm_past_comment where dist_code=? "
  . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
  . " lot_no=? and appln_no=? order by sl_no desc";
  $data['coComment'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $db->appln_no))->row();
  $data['attachment']=array();
  if($db->application_ref_no){
    $url =RTPS_LINK. "mutation_order/mutation_order_attachment_details.php?application_ref_no=" . $petition->application_ref_no . "&applid=" . $petition->applid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);  
    $data['attachment'] = $output;
  }


  $application_no="select * from basundhar_application where dharitree=? ";
  $data['app'] = $this->db->query($application_no, array($cert_no))->row();
  $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($cert_no);

  $data['basuCase']=null;
  $data['basuCase']=$basundharaExist=$this->rtpsmodel->checkExistBasundhar($cert_no);
  if($basundharaExist){
    $data['query']=null;
    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($cert_no);
    $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($cert_no))->result();
    $data['query']=$this->rtpsmodel->QueryPost($basundharaExist);
  }
 
  $this->session->set_userdata($values);

  $data['_view'] = 'Citizen/LMstep2';
  $this->load->view('layouts/main',$data);
}

public function LMStep3($message='') {
  $cert_codeNo = $this->session->userdata('cert_codeNo');
  switch ($cert_codeNo) {
   case 01:
    if($message=='') {
      $redirect = "../views/Citizen/LMJB";
    }
    else{
      $this->session->set_flashdata('message', $message);
      $redirect = "../views/Citizen/LMJB";
    }
   break;
   case 02:
    if($message=='') {
      redirect(base_url() . 'index.php/CitizenController/LMLH');
    }
    else{
      $this->session->set_flashdata('message', $message);
      redirect(base_url() . 'index.php/CitizenController/LMLH');
    }
   break;
   case 03:
    if($message=='') {
      $redirect = "../views/Citizen/LMIC";
    }
    else{
      $this->session->set_flashdata('message', $message);
      $redirect = "../views/Citizen/LMIC";
    }
   break;
   case 04:
    if($message=='') {
      redirect(base_url() . 'index.php/CitizenController/LMLV');
    }
    else{
      $this->session->set_flashdata('message', $message);
      redirect(base_url() . 'index.php/CitizenController/LMLV');
    }
   break;
   case 05:
    if($message=='') {
      redirect(base_url() . 'index.php/CitizenController/LMAP');
    }
    else{
      $this->session->set_flashdata('message', $message);
      redirect(base_url() . 'index.php/CitizenController/LMAP');
    }
   break;
   case 06:
    if($message=='') {
      redirect(base_url() . 'index.php/CitizenController/LMPP');
    }
    else{
      $this->session->set_flashdata('message', $message);
      redirect(base_url() . 'index.php/CitizenController/LMPP');
    }
   break;
   case 07:
    if($message=='') {
      redirect(base_url() . 'index.php/CitizenController/LMOS');
    }
    else{
      $this->session->set_flashdata('message', $message);
      redirect(base_url() . 'index.php/CitizenController/LMOS');
    }
   break;
   default:
   break;
 }
 $data['_view'] = $redirect;
 $this->load->view('layouts/main',$data);
}

function LMJBPending() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $cert_no = $this->session->userdata('cert_no');
  $user_code = $this->session->userdata('user_code');
  $reason = $this->input->post('pending_reason');
  $option = $this->input->post('options');
  $application_no = $this->session->userdata('basundhara');

  $query = "Select * from    cert_application where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
  and cir_code='$cir_code' and cert_no='$cert_no'";
  $cert_app = $this->db->query($query)->row();
  $data = array(
   'dist_code' => $cert_app->dist_code,
   'subdiv_code' => $cert_app->subdiv_code,
   'cir_code' => $cert_app->cir_code,
   'mouza_pargona_code' => $cert_app->mouza_pargona_code,
   'lot_no' => $cert_app->lot_no,
   'vill_townprt_code' => $cert_app->vill_townprt_code,
   'appln_no' => $cert_no,
   'pending_by' => $user_code,
   'reason_pending' => $reason,
   'next_due_date' => date('Y-m-d'),
   'disposed_yn' => $option,
   'cert_no' => $cert_no,
   'year_no' => date('Y'),
   'pending_date' => date('Y-m-d')
 );

  $this->db->insert("cert_pending", $data);
  $arr = array('lm_checked_yn' => 'Y', 'status' => $option);
  $this->db->where('cert_no', $cert_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->update("cert_application", $arr);

  if($application_no){
   $rmk='Forwarded to CO';
   $status='M';
   $task='LM';
   $pen='CO';
   $case=$case_no;
   $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
 }


 $this->session->set_flashdata('message', 'Application Status have successfully Updated !!');
 redirect(base_url() . 'index.php/home');
}        

function LMLV() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('cert_no');
  $patta_no = trim($this->session->userdata('patta_no'));
  $sql = "Select patta_no from    Cert_Application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and cert_no='$appln_no' ";
        // echo $sql;
  $patta = $this->db->query($sql)->row();

  $sql = "Select * from    Chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta->patta_no')";
  $data['dags'] = $this->db->query($sql)->result();
  $data['_view'] = 'Citizen/LMLV';
  $this->load->view('layouts/main',$data);
}

function LMPP() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('cert_no');
  $patta_no = trim($this->session->userdata('patta_no'));
  $sql = "Select patta_no from    Cert_Application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and cert_no='$appln_no' ";
        // echo $sql;
  $patta = $this->db->query($sql)->row();

  $sql = "Select * from    Chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta->patta_no')";
  $data['dags'] = $this->db->query($sql)->result();
  $data['_view'] = 'citizen/lmpp';
  $this->load->view('layouts/main',$data);
}

function LMLH(){
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('cert_no');
  $patta_no = trim($this->session->userdata('patta_no'));
  $sql = "Select patta_no from Cert_Application where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
  . "and lot_no=? and vill_townprt_code=? and cert_no=? ";
        // echo $sql;
  $patta = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $appln_no))->row();

  $sql = "Select * from Chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
  . "and lot_no=? and vill_townprt_code=? and TRIM(patta_no)=trim(?)";
  $data['dags'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta->patta_no))->result();
  $data['_view'] = 'Citizen/LMLH';
  $this->load->view('layouts/main',$data);
}

function LMAP() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('cert_no');
  $patta_no = trim($this->session->userdata('patta_no'));
  $sql = "Select patta_no from    Cert_Application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and cert_no='$appln_no' ";
        // echo $sql;
  $patta = $this->db->query($sql)->row();

  $sql = "Select * from    Chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta->patta_no')";
  $data['dags'] = $this->db->query($sql)->result();
  $data['_view'] = 'citizen/lmap';
  $this->load->view('layouts/main',$data);
}

public function LMJB() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  $application_ref_no = $this->session->userdata('application_ref_no');
  $application_no = $this->session->userdata('basundhara');
  $applid = $this->session->userdata('applid');
      //var_dump($this->session->all_userdata());

  $arr = array('lm_checked_yn' => 'Y', 'status' => 'C');
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);
        ///////////Dashboard/////////////////
  $case_no=$this->session->userdata('cert_no');
  $penUser='CO';$rmrk='Submitted By CO';
  $this->DashboardData($case_no,$penUser,$rmrk);
      //echo ($this->db->_error_message());
  if($application_ref_no){
   $curl_handle = curl_init();
   curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_status_update.php");
   curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    'applid' => $applid,
    'application_ref_no' => $application_ref_no,
    'rmk' => 'Appliction Forwarder To Circle Officer',
    'status' => 'S',
    'task' => 'LM',
  )));
   $result = curl_exec($curl_handle);
 }


 if($application_no){
   $rmk='Forwarded to CO';
   $status='M';
   $task='LM';
   $pen='CO';
   $case=$case_no;
   $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
 }
 redirect(base_url() . 'index.php/home');
}

public function LMPPSubmit() {
  if(!isset($_POST['no_year']) || !isset($_POST['date_upto']) || !isset($_POST['f_install']) || !isset($_POST['f_ins_rs']) || !isset($_POST['s_install']) || !isset($_POST['s_ins_rs']) || !isset($_POST['dag']) || !isset($_POST['bigha']) || !isset($_POST['katha']) || !isset($_POST['lessa']) || $_POST['no_year']=='' || $_POST['date_upto']=='' || $_POST['f_install']=='' || $_POST['f_ins_rs']=='' || $_POST['s_install']=='' || $_POST['s_ins_rs']=='' || $_POST['dag']=='' || $_POST['bigha']=='' || $_POST['katha']=='' || $_POST['lessa']=='') {
    //ERRCCSPPLM0001
    log_message('error', 'The required fields are empty. Error: ERRCCSPPLM0001');
    $this->LMStep3('The required fields are empty. Error: ERRCCSPPLM0001');
  }
  //syntax validation
  $res = checkRequestSpecChar($_POST, [], ['no_year' => 'No. of year', 'date_upto' => 'Date Upto', 'f_install' => 'First Installment Year', 'f_ins_rs' => 'First Installment amount', 's_install' => 'Second installment', 's_ins_rs' => 'Second installment Amount', 'dag' => 'Dag', 'bigha' => 'Bigha', 'katha' => 'Katha', 'lessa' => 'Lessa']);
  if($res['status']=='n') {
      //ERRCCSPPLM0002
      log_message('error', $res['messages'] .'Error: ERRCCSPPLM0002');
      $this->LMStep3('Input Parameter has special character. Error: ERRCCSPPLM0002');
  }
  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRCCSPPLM0006
    log_message('error', $validquery['messages'] .'Error: ERRCCSPPLM0006');
    $this->LMStep3('Input Parameter has malicious character. Error: ERRCCSPPLM0006');
  }

  //form validation
  $result = $this->FormValidationModel->formValidationForPost($_POST, [
    'no_year'=>'No. of year|required|digit',
    'date_upto'=>'Date Upto|required|date',
    'f_install'=>'First Installment Date|required|date',
    's_install'=>'Second Installment Date|required|date',
    'f_ins_rs'=>'First Installment Amount|required|2_digit_decimal',
    's_ins_rs'=>'Second Installment Amount|required|2_digit_decimal',
    'dag'=>'Dag|required|digit',
    'bigha'=>'Bigha|required|digit',
    'katha'=>'Katha|required|katha',
    'lessa'=>'Lessa|required|lessa'
  ]);
  // $result = postParamFormValidation($_POST, [
  //   'no_year'=>'digit',
  //   'date_upto'=>'date',
  //   'f_install'=>'date',
  //   's_install'=>'date',
  //   'f_ins_rs'=>'2_digit_decimal',
  //   's_ins_rs'=>'2_digit_decimal',
  //   'dag'=>'digit',
  //   'bigha'=>'digit',
  //   'katha'=>'katha',
  //   'lessa'=>'lessa'
  // ]);
  if($result['status']=='n') {
    //ERRCCSPPLM0003
    log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .'. Error: ERRCCSPPLM0003');
    $this->LMStep3($result['message'] .' Error: ERRCCSPPLM0003');
  }

  // if($_POST['katha']>=5) {
  //   //ERRCCSPPLM0007
  //   log_message('error', 'Katha entered is greater than or equal to 5. Error: ERRCCSPPLM0007');
  //   $this->LMStep3('The katha cant be greater than or equal to 5. Error: ERRCCSPPLM0007');
  // }

  // if($_POST['lessa']>=20) {
  //   //ERRCCSPPLM0008
  //   log_message('error', 'Lessa entered is greater than or equal to 20. Error: ERRCCSPPLM0008');
  //   $this->LMStep3('The Lessa cant be greater than or equal to 20. Error: ERRCCSPPLM0008');
  // }

  $finstall = str_replace('/', '-', $_POST['f_install']);
  $sinstall = str_replace('/', '-', $_POST['s_install']);

  if(strtotime($finstall)>strtotime($sinstall)) {
    //ERRCCSPPLM0009
    log_message('error', '2nd Installment cannot be less than 1st Installment. Error: ERRCCSPPLM0009');
    $this->LMStep3('2nd Installment cannot be less than 1st Installment. Error: ERRCCSPPLM0009');
  }

  //authorization
  $cert_no = $this->session->userdata('cert_no');
  $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $cert_no);
  if($response['status']=='n') {
    //ERRCCSPPLM0004
    log_message('error', $response['messages'] .' Error: ERRCCSPPLM0004');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSPPLM0004');
    redirect(base_url('index.php/home'));
  }

  //authentication
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData) || !$sessionData['user_code']) {
  //   //ERRCCSPPLM0004
  //   log_message('error', 'User not logged in! Error: ERRCCSPPLM0004');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSPPLM0004');
  //   redirect(base_url('index.php/home'));
  // }

  //authorization
  // $appln_no = $this->session->userdata('appln_no');
  // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $cert_no);
  // if($sessionData['user_desig_code']!='LM' || empty($certInfo) || $sessionData['dist_code']!=$certInfo[0]->dist_code || $sessionData['subdiv_code']!=$certInfo[0]->subdiv_code || $sessionData['cir_code']!=$certInfo[0]->cir_code || $sessionData['mouza_pargona_code']!=$certInfo[0]->mouza_pargona_code || $sessionData['lot_no']!=$certInfo[0]->lot_no) {
  //   //ERRCCSPPLM0005
  //   log_message('error', 'User not Authorized! Error: ERRCCSPPLM0005');
  //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSPPLM0005');
  //   redirect(base_url('index.php/home'));
  // }

  $db=  $this->session->userdata('db');
  $data = array();
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  // $cert_no = $this->session->userdata('cert_no');

  $no_of_years = $this->input->post('no_year');
  $to_date = $this->input->post('date_upto');
  $a1 = explode('/', $to_date);
  $to_date = $a1[2] . "-" . $a1[1] . "-" . $a1[0];

  $first_installment = $this->input->post('f_install');
  $first_installment_rs = $this->input->post('f_ins_rs');
  $sec_installment = $this->input->post('s_install');
  $sec_installment_rs = $this->input->post('s_ins_rs');

  $a2 = explode('/', $first_installment);
  $first_installment = $a2[2] . "-" . $a2[1] . "-" . $a2[0];

  $a3 = explode('/', $sec_installment);
  $sec_installment = $a3[2] . "-" . $a3[1] . "-" . $a3[0];

  $dag_no = $this->input->post('dag');
  $bigha = $this->input->post('bigha');
  $katha = $this->input->post('katha');
  $lessa = $this->input->post('lessa');
  $gonda = $this->input->post('gonda');
  $kranti = $this->input->post('kranti');

  $data['send'] = $arr = array(
   'no_of_years' => $no_of_years,
   'to_date' => $to_date,
   'first_installment' => $first_installment_rs,
   'first_installment_date' => $first_installment,
   'second_installment' => $sec_installment_rs,
   'second_installment_date' => $sec_installment
 );
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);
  $sql = "Select * from    Cert_Application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and appln_no='$appln_no' ";
        //echo $sql;
  $data['certD'] = $db = $this->db->query($sql)->row();

  $sql = "Select * from    chitha_basic where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$db->patta_no') and dag_no='$dag_no' and patta_type_code='$db->patta_type_code' ";

  $lcode = $this->db->query($sql)->row();
  $c_bigha = $lcode->dag_area_b;
  $c_katha = $lcode->dag_area_k;
  $c_lc = $lcode->dag_area_lc;

  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
  {
    $c_ganda = $lcode->dag_area_g;
    $chitha_totoal = ($c_bigha * 320 * 20) + ($c_katha * 320) + ($c_lc * 20) + $c_ganda;
    $post_total = ($bigha * 320 * 20) + ($katha * 320) + ($lessa * 20) + $ganda;
  }
  else{
     $chitha_totoal = ($c_bigha * 5 * 20) + ($c_katha * 20) + $c_lc;
     $post_total = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
  }
 
  $arr_size = sizeof($lcode);
  if ($chitha_totoal < $post_total) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if ($arr_size == 0) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if ($post_total == 0 or $chitha_totoal == 0) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 $this->db->where('cert_no', $cert_no);
 $this->db->where('dist_code', $dist_code);
 $this->db->where('subdiv_code', $subdiv_code);
 $this->db->where('cir_code', $cir_code);
 $this->db->where('mouza_pargona_code', $mouza_pargona_code);
 $this->db->where('lot_no', $lot_no);
 $this->db->where('vill_townprt_code', $vill_townprt_code);
 $this->db->delete('cert_dag_details');
 $data['valu'] = $values = array(
   'dist_code' => $dist_code,
   'subdiv_code' => $subdiv_code,
   'cir_code' => $cir_code,
   'mouza_pargona_code' => $mouza_pargona_code,
   'lot_no' => $lot_no,
   'vill_townprt_code' => $vill_townprt_code,
   'cert_no' => $db->cert_no,
   'pdar_id' => $db->pdar_id,
   'patta_no' => trim($db->patta_no),
   'patta_type_code' => $db->patta_type_code,
   'land_class_code' => $lcode->land_class_code,
   'dag_no' => $dag_no,
   'a_dag_area_b' => $bigha,
   'a_dag_area_k' => $katha,
   'a_dag_area_lc' => $lessa,
   'a_dag_area_g' => $gonda,
   'a_dag_area_kr' => $kranti,
   'a_dag_revenue' => '0'
 );
 $this->db->insert("cert_dag_details", $values);
 $location = $this->utilityclass->getLocationfromSession();
 $dist = $this->utilityclass->getDistrictName($dist_code);
 $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
 $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
 $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
 $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
//        
 $data['location'] = array(
   'distname' => $dist,
   'subname' => $sub,
   'cirname' => $cir,
   'mouza_pargona_code' => $mouza_name,
   'lot_no' => $lotname,
   'vill_townprt_code' => $vill_name
 );
 $data['_view'] = 'citizen/LMstep4PP';
 $this->load->view('layouts/main',$data);
}

public function LMPPFinalSubmit() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');

  $arr = array(
   'lm_checked_yn' => 'Y',
   'status' => 'C');
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);
         ////////////////////////////
  $cert_no=$this->session->userdata('cert_no');
  $penUser='CO';
  $rmrk='Order Passed By LM';
  $this->DashboardData($cert_no,$penUser,$rmrk); 
        /////////////  
  $this->session->set_flashdata('message', $rmrk);
  redirect(base_url() . 'index.php/home');
}

public function LMSubmitAP() {
  if(!isset($_POST['no_year']) || !isset($_POST['date_revenue']) || !isset($_POST['rev_year']) || !isset($_POST['dag']) || !isset($_POST['bigha']) || !isset($_POST['katha']) || !isset($_POST['lessa']) || $_POST['no_year']=='' || $_POST['date_revenue']=='' || $_POST['rev_year']=='' || $_POST['dag']=='' || $_POST['bigha']=='' || $_POST['katha']=='' || $_POST['lessa']=='') {
    //ERRCCSAPLM0001
    log_message('error', 'The required fields are empty. Error: ERRCCSAPLM0001');
    $this->LMStep3('The required fields are empty. Error: ERRCCSAPLM0001');
  }
  //syntax validation
  $res = checkRequestSpecChar($_POST, [], ['no_year' => 'No. of year', 'date_revenue' => 'Date', 'rev_year' => 'Year', 'dag' => 'Dag', 'bigha' => 'Bigha', 'katha' => 'Katha', 'lessa' => 'Lessa']);
  if($res['status']=='n') {
      //ERRCCSAPLM0002
      log_message('error', $res['messages'] .'Error: ERRCCSAPLM0002');
      $this->LMStep3('Input Parameter has special character. Error: ERRCCSAPLM0002');
  }

  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRCCSAPLM0006
    log_message('error', $validquery['messages'] .'Error: ERRCCSAPLM0006');
    $this->LMStep3('Input Parameter has malicious character. Error: ERRCCSAPLM0006');
  }

  //form validation
  $result = $this->FormValidationModel->formValidationForPost($_POST, [
    'no_year'=>'No. of year|required|digit',
    'date_revenue'=>'Revenue Date|required|date',
    'rev_year'=>'Revenue Year|required|digit',
    'dag'=>'Dag|required|digit',
    'bigha'=>'Bigha|required|digit',
    'katha'=>'Katha|required|katha',
    'lessa'=>'Lessa|required|lessa'
  ]);
  // $result = postParamFormValidation($_POST, [
  //   'no_year'=>'digit',
  //   'date_revenue'=>'date',
  //   'rev_year'=>'digit',
  //   'dag'=>'digit',
  //   'bigha'=>'digit',
  //   'katha'=>'katha',
  //   'lessa'=>'lessa'
  // ]);
  if($result['status']=='n') {
    //ERRCCSAPLM0003
    log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .'. Error: ERRCCSAPLM0003');
    $this->LMStep3($result['message'] .' Error: ERRCCSAPLM0003');
  }

  // if($_POST['katha']>=5) {
  //   //ERRCCSAPLM0007
  //   log_message('error', 'Katha entered is greater than or equal to 5. Error: ERRCCSAPLM0007');
  //   $this->LMStep3('The katha cant be greater than or equal to 5. Error: ERRCCSAPLM0007');
  // }

  // if($_POST['lessa']>=20) {
  //   //ERRCCSAPLM0008
  //   log_message('error', 'Katha entered is greater than or equal to 20. Error: ERRCCSAPLM0008');
  //   $this->LMStep3('The katha cant be greater than or equal to 20. Error: ERRCCSAPLM0008');
  // }

  //authentication
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData) || !$sessionData['user_code']) {
  //   //ERRCCSAPLM0004
  //   log_message('error', 'User not logged in! Error: ERRCCSAPLM0004');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSAPLM0004');
  //   redirect(base_url('index.php/home'));
  // }

  //authorization
  $appln_no = $this->session->userdata('appln_no');
  $cert_no = $this->session->userdata('cert_no');

  $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $cert_no);
  if($response['status']=='n') {
    //ERRCCSAPLM0004
    log_message('error', $response['messages'] .' Error: ERRCCSAPLM0004');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSAPLM0004');
    redirect(base_url('index.php/home'));
  }

  // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $cert_no);
  // if($sessionData['user_desig_code']!='LM' || empty($certInfo) || $sessionData['dist_code']!=$certInfo[0]->dist_code || $sessionData['subdiv_code']!=$certInfo[0]->subdiv_code || $sessionData['cir_code']!=$certInfo[0]->cir_code || $sessionData['mouza_pargona_code']!=$certInfo[0]->mouza_pargona_code || $sessionData['lot_no']!=$certInfo[0]->lot_no) {
  //   //ERRCCSAPLM0005
  //   log_message('error', 'User not Authorized! Error: ERRCCSAPLM0005');
  //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSAPLM0005');
  //   redirect(base_url('index.php/home'));
  // }
  
  $db=  $this->session->userdata('db');
  $data = array();
  $no_of_years = $this->input->post('no_year');
  $to_date = date('Y-m-d', strtotime($this->input->post('date_revenue')));
  $r_year = $this->input->post('rev_year');
  $dag_no = $this->input->post('dag');
  $bigha = $this->input->post('bigha');
  $katha = $this->input->post('katha');
  $lessa = $this->input->post('lessa');
  $gonda = $this->input->post('gonda');
  $kranti = $this->input->post('kranti');

  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');

  $data['send'] = $arr = array('no_of_years' => $no_of_years,
   'to_date' => $to_date,
   'r_year' => $r_year);
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);

  $sql = "Select * from    Cert_Application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and appln_no='$appln_no' ";
        //echo $sql;
  $data['certD'] = $db = $this->db->query($sql)->row();

  $sql = "Select * from    chitha_basic where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$db->patta_no') and dag_no='$dag_no' and patta_type_code='$db->patta_type_code' ";
        // echo $sql;
  $lcode = $this->db->query($sql)->row();
  $c_bigha = $lcode->dag_area_b;
  $c_katha = $lcode->dag_area_k;
  $c_lc = $lcode->dag_area_lc;

  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
  {
    $c_ganda = $lcode->dag_area_g;
    $chitha_totoal = ($c_bigha * 320 * 20) + ($c_katha * 320) + ($c_lc * 20) + $c_ganda;
    $post_total = ($bigha * 320 * 20) + ($katha * 320) + ($lessa * 20) + $ganda;
  }
  else{
    $chitha_totoal = ($c_bigha * 5 * 20) + ($c_katha * 20) + $c_lc;
    $post_total = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
  }
  $arr_size = sizeof($lcode);

  if ($chitha_totoal < $post_total) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if ($arr_size == 0) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if ($post_total == 0 or $chitha_totoal == 0) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 $this->db->where('cert_no', $cert_no);
 $this->db->where('dist_code', $dist_code);
 $this->db->where('subdiv_code', $subdiv_code);
 $this->db->where('cir_code', $cir_code);
 $this->db->where('mouza_pargona_code', $mouza_pargona_code);
 $this->db->where('lot_no', $lot_no);
 $this->db->where('vill_townprt_code', $vill_townprt_code);
 $this->db->delete('cert_dag_details');

 $data['valu'] = $values = array(
   'dist_code' => $dist_code,
   'subdiv_code' => $subdiv_code,
   'cir_code' => $cir_code,
   'mouza_pargona_code' => $mouza_pargona_code,
   'lot_no' => $lot_no,
   'vill_townprt_code' => $vill_townprt_code,
   'cert_no' => $db->cert_no,
   'pdar_id' => $db->pdar_id,
   'patta_no' => trim($db->patta_no),
   'patta_type_code' => $db->patta_type_code,
   'land_class_code' => $lcode->land_class_code,
   'dag_no' => $dag_no,
   'a_dag_area_b' => $bigha,
   'a_dag_area_k' => $katha,
   'a_dag_area_lc' => $lessa,
   'a_dag_area_g' => $gonda,
   'a_dag_area_kr' => $kranti,
   'a_dag_revenue' => '0'
 );

 $location = $this->utilityclass->getLocationfromSession();
 $dist = $this->utilityclass->getDistrictName($dist_code);
 $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
 $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
 $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
 $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
 $data['location'] = array(
   'distname' => $dist,
   'subname' => $sub,
   'cirname' => $cir,
   'mouza_pargona_code' => $mouza_name,
   'lot_no' => $lotname,
   'vill_townprt_code' => $vill_name
 );
 $this->db->insert("cert_dag_details", $values);
 $data['_view'] = 'citizen/LMstep4AP';
 $this->load->view('layouts/main',$data);
}

public function LMFinalSubmitAP() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  $arr = array(
   'lm_checked_yn' => 'Y',
   'status' => 'C');
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);
         ///////////////////////////
  $cert_no=$this->session->userdata('cert_no');
  $penUser='CO';
  $rmrk='Order Passed By LM';
  $this->DashboardData($cert_no,$penUser,$rmrk);
  $this->session->set_flashdata('message', $rmrk);
  redirect(base_url() . 'index.php/home');
}

public function LMLVSubmit() {
  if(!isset($_POST['dag']) || !isset($_POST['bigha']) || !isset($_POST['katha']) || !isset($_POST['lessa']) || $_POST['dag']=='' || $_POST['bigha']=='' || $_POST['katha']=='' || $_POST['lessa']=='') {
    //ERRCCSLVLM0001
    log_message('error', 'The required fields are empty. Error: ERRCCSLVLM0001');
    $this->LMStep3('The required fields are empty. Error: ERRCCSLVLM0001');
  }
  $checkSpclChar = checkRequestSpecChar($_POST);
  if($checkSpclChar['status']=='n') {
      //ERRCCSLVLM0002
      log_message('error', $checkSpclChar['messages'] .'Error: ERRCCSLVLM0002');
      $this->LMStep3('Input Parameter has special character. Error: ERRCCSLVLM0002');
  }

  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRCCSLVLM0006
    log_message('error', $validquery['messages'] .'Error: ERRCCSLVLM0006');
    $this->LMStep3('Input Parameter contains malicious characters. Error: ERRCCSLVLM0006');
  }

  //form validation
  $result = $this->FormValidationModel->formValidationForPost($_POST, [
    'dag'=>'Dag|required|digit',
    'bigha'=>'Bigha|required|digit',
    'katha'=>'Katha|required|katha',
    'lessa'=>'Lessa|required|lessa'
  ]);
  // $result = postParamFormValidation($_POST, [
  //   'dag'=>'digit',
  //   'bigha'=>'digit',
  //   'katha'=>'katha',
  //   'lessa'=>'lessa'
  // ]);
  if($result['status']=='n') {
    //ERRCCSLVLM0003
    log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .'. Error: ERRCCSLVLM0003');
    $this->LMStep3($result['message'] .'Error: ERRCCSLVLM0003');
  }

  // if($_POST['katha']>=5) {
  //   //ERRCCSLVLM0006
  //   log_message('error', 'Katha value is greater than or equal to 5. Error: ERRCCSLVLM0006');
  //   $this->LMStep3('Katha value cant be greater than or equal to 5. Error: ERRCCSLVLM0006');
  // }

  // if($_POST['lessa']>=20) {
  //   //ERRCCSLVLM0007
  //   log_message('error', 'Lessa value is greater than or equal to 20. Error: ERRCCSLVLM0007');
  //   $this->LMStep3('Lessa value cant be greater than or equal to 20. Error: ERRCCSLVLM0007');
  // }

  //authentication
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData) || !$sessionData['user_code']) {
  //   //ERRCCSLVLM0004
  //   log_message('error', 'User not logged in! Error: ERRCCSLVLM0004');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSLVLM0004');
  //   redirect(base_url('index.php/home'));
  // }

  //authorization
  $appln_no = $this->session->userdata('appln_no');
  $cert_no = $this->session->userdata('cert_no');
  $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $cert_no);
  if($response['status']=='n') {
    log_message('error', $response['messages'] .' Error: ERRCCSLVLM0004');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSLVLM0004');
    redirect(base_url('index.php/home'));
  }
  // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $cert_no);
  // if($sessionData['user_desig_code']!='LM' || empty($certInfo) || $sessionData['dist_code']!=$certInfo[0]->dist_code || $sessionData['subdiv_code']!=$certInfo[0]->subdiv_code || $sessionData['cir_code']!=$certInfo[0]->cir_code || $sessionData['mouza_pargona_code']!=$certInfo[0]->mouza_pargona_code || $sessionData['lot_no']!=$certInfo[0]->lot_no) {
  //   //ERRCCSLVLM0005
  //   log_message('error', 'User not Authorized! Error: ERRCCSLVLM0005');
  //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSLVLM0005');
  //   redirect(base_url('index.php/home'));
  // }

  $db=  $this->session->userdata('db');
  $dag_no = $this->input->post('dag');
  $a_dag_area_b = $this->input->post('bigha');
  $a_dag_area_k = $this->input->post('katha');
  $a_dag_area_lc = $this->input->post('lessa');
  $a_dag_area_g = $this->input->post('gonda');
  $a_dag_area_kr = $this->input->post('kranti');

  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  // $cert_no = $this->session->userdata('cert_no');
  // $appln_no = $this->session->userdata('appln_no');

  $sql = "Select * from Cert_Application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and appln_no='$appln_no' ";
  $data['certD'] = $db = $this->db->query($sql)->row();

  $sql = "Select * from chitha_basic where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' and TRIM(patta_no)=trim('$db->patta_no') and "
  . "patta_type_code='$db->patta_type_code'  ";

  $cb = $data['cb'] = $this->db->query($sql)->row();
  $c_bigha = $cb->dag_area_b;
  $c_katha = $cb->dag_area_k;
  $c_lc = $cb->dag_area_lc;
  $chitha_totoal = ($c_bigha * 5 * 20) + ($c_katha * 20) + $c_lc;
  $post_total = ($a_dag_area_b * 5 * 20) + ($a_dag_area_k * 20) + $a_dag_area_lc;

  $arr_size = sizeof($cb);
  if ($post_total == 0 or $chitha_totoal == 0) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if ($chitha_totoal < $post_total) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }
 if (!$arr_size) {
   redirect(base_url() . 'index.php/CitizenController/Error');
   exit();
 }


 $this->db->where('cert_no', $cert_no);
 $this->db->where('dist_code', $dist_code);
 $this->db->where('subdiv_code', $subdiv_code);
 $this->db->where('cir_code', $cir_code);
 $this->db->where('mouza_pargona_code', $mouza_pargona_code);
 $this->db->where('lot_no', $lot_no);
 $this->db->where('vill_townprt_code', $vill_townprt_code);
 $this->db->delete('cert_dag_details');
 $values = array(
   'dist_code' => $dist_code,
   'subdiv_code' => $subdiv_code,
   'cir_code' => $cir_code,
   'mouza_pargona_code' => $mouza_pargona_code,
   'lot_no' => $lot_no,
   'vill_townprt_code' => $vill_townprt_code,
   'cert_no' => $db->cert_no,
   'pdar_id' => $db->pdar_id,
   'patta_no' => trim($db->patta_no),
   'patta_type_code' => $db->patta_type_code,
   'land_class_code' => $cb->land_class_code,
   'dag_no' => $dag_no,
   'a_dag_area_b' => $a_dag_area_b,
   'a_dag_area_k' => $a_dag_area_k,
   'a_dag_area_lc' => $a_dag_area_lc,
   'a_dag_area_g' => $a_dag_area_g,
   'a_dag_area_kr' => $a_dag_area_kr
 );
 $this->db->insert("cert_dag_details", $values);
 $data['_view'] = 'citizen/LMLVSubmit';
 $this->load->view('layouts/main',$data);
}

public function LMICRedirect() {

}

public function LMSubmitIC() {
  $cert_no = $this->session->userdata('cert_no');
  if(!isset($_POST['crop_code']) || !isset($_POST['unit_produce']) || !isset($_POST['unit_price']) || !isset($_POST['other_income']) || $_POST['crop_code']=='' || $_POST['unit_produce']=='' || $_POST['unit_price']=='' || $_POST['other_income']=='') {
    //ERRCCSICLM0001
    log_message('error', 'The required fields are empty. Error: ERRCCSICLM0001');
    $this->session->set_flashdata('message', 'The required fields are empty. Error: ERRCCSICLM0001');
    redirect(base_url('index.php/CitizenController/LMStep2?cert_no='. $cert_no));
    exit;
  }
  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRCCSICLM0005
    log_message('error', $validquery['messages'] .'Error: ERRCCSICLM0005');
    $this->session->set_flashdata('message', 'Input Parameter contains malicious characters. Error: ERRCCSICLM0005');
    redirect(base_url('index.php/CitizenController/LMStep2?cert_no='. $cert_no));
    // $this->LMStep3('Input Parameter contains malicious characters. Error: ERRCCSICLM0005');
    exit;
  }
  //form validation
  $result = $this->FormValidationModel->formValidationForPost($_POST, [
    'crop_code'=>'Crop Code|required|digit',
    'unit_produce'=>'Unit Produce|required|2_digit_decimal',
    'unit_price'=>'Unit Price|required|2_digit_decimal',
    'other_income'=>'Other Income|required|2_digit_decimal'
  ]);
  // $result = postParamFormValidation($_POST, [
  //   'crop_code'=>'digit',
  //   'unit_produce'=>'2_digit_decimal',
  //   'unit_price'=>'2_digit_decimal',
  //   'other_income'=>'2_digit_decimal'
  // ]);
  if($result['status']=='n') {
    //ERRCCSICLM0002
    log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .'. Error: ERRCCSICLM0002');
    $this->session->set_flashdata('message', $result['message'] .' Error: ERRCCSICLM0002');
    redirect(base_url('index.php/CitizenController/LMStep2?cert_no='. $cert_no));
    // $this->LMStep3($result['message'] .'. Error: ERRCCSICLM0002');
    exit;
  }
  //authentication
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData) || !$sessionData['user_code']) {
  //   //ERRCCSICLM0003
  //   log_message('error', 'User not logged in! Error: ERRCCSICLM0003');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSICLM0003');
  //   redirect(base_url('index.php/home'));
  // }
  //authorization
  $appln_no = $this->session->userdata('appln_no');
  $certno = $this->session->userdata('cert_no');
  $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $certno);
  if($response['status']=='n') {
    //ERRCCSICLM0003
    log_message('error', $response['messages'] .' Error: ERRCCSICLM0003');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSICLM0003');
    redirect(base_url('index.php/home'));
  }
  // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $certno);
  // if($sessionData['user_desig_code']!='LM' || $certInfo[0]->dist_code!=$sessionData['dist_code'] || $certInfo[0]->subdiv_code!=$sessionData['subdiv_code'] || $certInfo[0]->cir_code!=$sessionData['cir_code'] || $certInfo[0]->mouza_pargona_code!=$sessionData['mouza_pargona_code'] || $certInfo[0]->lot_no!=$sessionData['lot_no']) {
  //   //ERRCCSICLM0004
  //   log_message('error', 'User not Authorized! Error: ERRCCSICLM0004');
  //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSICLM0004');
  //   redirect(base_url('index.php/home'));
  // }

  $db=  $this->session->userdata('db');
  $data = array();
  $inc_crop = $this->input->post('crop_code');
  $unit_produce = $this->input->post('unit_produce');
  $unit_price = $this->input->post('unit_price');
  $inc_other = $this->input->post('other_income');
  $inc_total = ($unit_price * $unit_produce ) + $inc_other;
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');

  $location = $this->utilityclass->getLocationfromSession();
  $dist = $this->utilityclass->getDistrictName($dist_code);
  $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
  $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
  $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
  $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
  $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
  $data['location'] = array(
   'dist_name' => $dist,
   'subdiv_Name' => $sub,
   'cir_name' => $cir,
   'mouza_name' => $mouza_name,
   'lot_name' => $lotname,
   'villname' => $vill_name,
   'totalinc' => $inc_total
 );
  $sql = "Select * from Cert_Application where dist_code=? "
  . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
  . " lot_no=? and appln_no=? ";
  $data['applicant'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $appln_no))->row();
  $arr = array(
   'inc_crop' => $inc_crop,
   'inc_unit_produced' => $unit_produce,
   'inc_unit_price' => $unit_price,
   'inc_other' => $inc_other,
   'inc_total' => $inc_total
 );

  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);

  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
  {
  $data['_view'] = 'citizen/LMICPrint_kar';
  }
  else
  {
  $data['_view'] = 'citizen/LMICPrint';
  }

  $this->load->view('layouts/main',$data);
}

public function FinalStepIC() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');

  $arr = array(
   'lm_checked_yn' => 'Y',
   'status' => 'C',
 );
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);

         ///////////////////////////
  $cert_no=$this->session->userdata('cert_no');
  $penUser='CO';
  $rmrk='Order Passed By LM';
  $this->session->set_flashdata('message', $rmrk);
  redirect(base_url() . 'index.php/home');
}

public function LmStep4() {
  $data = array();
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  $year_no = date('Y');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['dag']) || !isset($_POST['bigha']) || !isset($_POST['katha']) || !isset($_POST['lessa']) || empty($_POST['dag']) || empty($_POST['bigha']) || empty($_POST['katha']) || empty($_POST['lessa'])) {
      //ERRCCSLM0001
      log_message('error', 'The required fields are empty. Error: ERRCCSLM0001');
      $this->LMStep3('The required fields are empty. Error: ERRCCSLM0001');
      exit;
      // $this->session->set_flashdata('message', 'The required fields are empty. Error: ERRCCSLM0001');
      // redirect(base_url('index.php/citizencontroller/LMStep3'));
    }
    //syntax and Form validation
    $syntaxAllow = true;
    for($i=0; $i<count($_POST['dag']); $i++) {
      if(!preg_match('/^[0-9]*$/', $_POST['dag'][$i])) {
        $syntaxAllow = false;
        break;
      }
      if(!preg_match('/^[0-9]*$/', $_POST['bigha'][$i])) {
        $syntaxAllow = false;
        break;
      }
      if(!preg_match('/^[0-9]*$/', $_POST['katha'][$i])) {
        $syntaxAllow = false;
        break;
      }
      if(!preg_match('/^[0-9]*?(\.[0-9][0-9]?[0-9]?[0-9]?)?$/', $_POST['lessa'][$i])) {
        $syntaxAllow = false;
        break;
      }
      if($_POST['katha'][$i]>=5) {
        $syntaxAllow = false;
        break;
      }
      if($_POST['lessa'][$i]>=20) {
        $syntaxAllow = false;
        break;
      }
    }
    if(!$syntaxAllow) {
      //ERRCCSLM0002
      log_message('error', 'The parameters contain illegal characters or katha is >=5 or lessa >=20. Error: ERRCCSLM0002');
      $this->LMStep3('The parameters contain illegal characters or katha is >=5 or lessa >=20. Error: ERRCCSLM0002');
      exit;
      // $this->session->set_flashdata('message', 'The parameters contain illegal characters. Error: ERRCCSLM0002');
      // redirect(base_url('index.php/citizencontroller/LMStep3'));
    }

    //check for Malicious
    $validquery = checkRequestValidQuery($_POST);
    if($validquery['status']=='n') {
      //ERRCCSLM0006
      log_message('error', $validquery['messages'] .'Error: ERRCCSLM0006');
      $this->LMStep3('Input Parameter contains malicious characters. Error: ERRCCSLM0006');
      exit();
    }

    //authentication and authorization
    $sessionData = $this->session->all_userdata();
    $certno = $sessionData['cert_no'];
    $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $certno);
    if($response['status']=='n') {
      //ERRCCSLM0003
      log_message('error', $response['messages'] .' Error: ERRCCSLM0003');
      $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSLM0003');
      redirect(base_url('index.php/home'));
    }
    
    //authentication
    // $sessionData = $this->session->all_userdata();
    // if(empty($sessionData)) {
    //     //ERRCCSLM0003
    //     log_message('error', 'User not logged in! Error: ERRCCSLM0003');
    //     $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSLM0003');
    //     redirect(base_url('index.php/home'));
    // }
    
    // $certInfo = $this->db->query("SELECT * FROM cert_application WHERE appln_no=? AND cert_no=?", array($appln_no, $certno))->result();
    // if($sessionData['user_desig_code']!='LM' || $sessionData['dist_code']!=$certInfo[0]->dist_code || $sessionData['subdiv_code']!=$certInfo[0]->subdiv_code || $sessionData['cir_code']!=$certInfo[0]->cir_code || $sessionData['mouza_pargona_code']!=$certInfo[0]->mouza_pargona_code || $sessionData['lot_no']!=$certInfo[0]->lot_no) {
    //   //ERRCCSLM0004
    //   log_message('error', 'User not Authorized! Error: ERRCCSLM0004');
    //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSLM0004');
    //   redirect(base_url('index.php/home'));
    // }

    // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $certno);
    $this->db->trans_begin();
    $dag_no = $this->input->post('dag');
    $b = $this->input->post('bigha');
    $k = $this->input->post('katha');
    $l = $this->input->post('lessa');

    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
    {
      $gonda = $this->input->post('ganda');
      $kranti = 0;
    }
    else{
      $gonda=$ganda = 0;
      $kranti = 0;
    }
   
    array_unique($dag_no);
    $size = sizeof($dag_no);
    $break = false;
    for ($i = 0; $i < $size; $i++) {
      $dag_noo = $dag_no[$i];
      $bigha = $b[$i];
      $katha = $k[$i];
      $lessa = $l[$i];
      $sql = "Select * from cert_application where dist_code=? "
      . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
      . " lot_no=? and vill_townprt_code=? and appln_no=? ";
      $data['certD'] = $db = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $appln_no))->row();

      $sql = "Select * from chitha_basic where dist_code=? "
      . "and subdiv_code=? and cir_code=? and mouza_pargona_code=? and"
      . " lot_no=? and vill_townprt_code=? and dag_no=? and TRIM(patta_no)=trim(?) and "
      . "patta_type_code=?";
                  //echo $sql;
      $sqlData = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_noo, $db->patta_no, $db->patta_type_code));
      $cb = $sqlData->row();
      if(empty($cb)) {
        $break = true;
        break;
      }
      $data['cb'] = $sqlData->row();
      $c_bigha = $cb->dag_area_b;
      $c_katha = $cb->dag_area_k;
      $c_lc = $cb->dag_area_lc;

      if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
      {
        $ganda=$gonda[$i];
        $c_ganda = $cb->dag_area_g;

        $chitha_totoal = ($c_bigha * 6400) + ($c_katha * 320) + ($c_lc * 20) + $c_ganda;
        $post_total = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
        // $arr_size = sizeof($cb);
        // if ($chitha_totoal < $post_total) {
        // exit();
        // }
      }
      else{
        $chitha_totoal = ($c_bigha * 5 * 20) + ($c_katha * 20) + $c_lc;
        $post_total = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        // $arr_size = sizeof($cb);
        // if ($chitha_totoal < $post_total) {
        // exit();
        // }
      }

      $values = array(
        'dist_code' => $dist_code,
        'subdiv_code' => $subdiv_code,
        'cir_code' => $cir_code,
        'mouza_pargona_code' => $mouza_pargona_code,
        'lot_no' => $lot_no,
        'vill_townprt_code' => $vill_townprt_code,
        'cert_no' => $db->cert_no,
        'pdar_id' => $db->pdar_id,
        'patta_no' => trim($db->patta_no),
        'patta_type_code' => $db->patta_type_code,
        'land_class_code' => $cb->land_class_code,
        'dag_no' => $dag_noo,
        'a_dag_area_b' => $bigha,
        'a_dag_area_k' => $katha,
        'a_dag_area_lc' => $lessa,
        'a_dag_area_g' => $gonda,
        'a_dag_area_kr' => $kranti
      );
      $data['dags'][] = array(
        'land_class_code' => $cb->land_class_code,
        'dag_no' => $dag_noo,
        'bigha' => $bigha,
        'katha' => $katha,
        'lessa' => $lessa,
        'ganda' => $ganda
      );
      $this->db->insert("cert_dag_details", $values);
      //echo $this->db->last_query();
      //log_message('error',$this->db->last_query());
    }
    if($break) {
      $this->db->trans_rollback();
      //ERRCCSLM0005
      $this->LMStep3('Wrong dag No. Error: ERRCCSLM0005');
      exit;
    }
    $location = $this->utilityclass->getLocationfromSession();
    $dist = $this->utilityclass->getDistrictName($dist_code);
    $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
    $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
    $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
    $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
    $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
    $data['location'] = array(
      'distname' => $dist,
      'subname' => $sub,
      'cirname' => $cir,
      'mouza_pargona_code' => $mouza_name,
      'lot_no' => $lotname,
      'vill_townprt_code' => $vill_name
    );
    $this->db->trans_commit();
  }

  $data['_view'] = 'Citizen/LMstep4';
  $this->load->view('layouts/main',$data);
}

public function LMSubmitLV() {

  if(!isset($_POST['FDeedReg']) || !isset($_POST['FDeedVal']) || !isset($_POST['LandPrice']) || !isset($_POST['COOrderNo']) || !isset($_POST['COOrderdate']) || !isset($_POST['purpose']) || !isset($_POST['memonumber']) || $_POST['FDeedReg']=='' || $_POST['FDeedVal']=='' ||  $_POST['LandPrice']=='' || $_POST['COOrderNo']=='' || $_POST['COOrderdate']=='' || $_POST['purpose']=='' || $_POST['memonumber']=='') {
    //ERRCCSLV2LM0001
    log_message('error', 'The required fields are empty. Error: ERRCCSLV2LM0001');
    $this->LMStep3('The required fields are empty. Error: ERRCCSLV2LM0001');
    exit;
  }


  //Add by Manashjyoti Deka on 2025-06-19 start 
  if(floatval(trim($_POST['FDeedVal']))<0 ){
    log_message('error', 'The 1st Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
    $this->LMStep3('The 1st Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
    exit;
  }
  $sum=floatval(trim($_POST['FDeedVal']));
  if(isset($_POST['SDeedReg']) ){
    if(!isset($_POST['sDeedVal'])){
      log_message('error', 'Enter 2nd Deed Value. Error: ERRCCSLV2LM0001');
      $this->LMStep3('Enter 2nd Deed Value. Error: ERRCCSLV2LM0001');
      exit;
    }
    if(floatval(trim($_POST['sDeedVal']))<0){
      log_message('error', 'The 2nd Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
      $this->LMStep3('The 2nd Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
      exit;
    }
    $sum+=floatval(trim($_POST['sDeedVal']));
  }
  
  if(isset($_POST['TDeedReg']) ){
    if(!isset($_POST['TDeedVal'])){
      log_message('error', 'Enter 3rd Deed Value. Error: ERRCCSLV2LM0001');
      $this->LMStep3('Enter 3rd Deed Value. Error: ERRCCSLV2LM0001');
      exit;
    }
    if(trim(floatval($_POST['TDeedVal']))<0){
      log_message('error', 'The 3rd Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
      $this->LMStep3('The 3rd Deed Value must be greater than zero. Error: ERRCCSLV2LM0001');
      exit;
    }
    $sum+=floatval(trim($_POST['TDeedVal']));
  }
  if($sum==0){
    log_message('error', 'Land Price Value must be greater than zero. Error: ERRCCSLV2LM0001');
      $this->LMStep3('Land Price Value must be greater than zero. Error: ERRCCSLV2LM0001');
      exit;
  }
  //Add by Manashjyoti Deka on 2025-06-19 end 

  //syntax validation
  $checkSpclChar = checkRequestSpecChar($_POST);
  if($checkSpclChar['status']=='n') {
      //ERRCCSLV2LM0002
      log_message('error', $checkSpclChar['messages'] .'Error: ERRCCSLV2LM0002');
      $this->LMStep3('Input Parameter has special character. Error: ERRCCSLV2LM0002');
      exit;
  }

  //check for Malicious
  $validquery = checkRequestValidQuery($_POST);
  if($validquery['status']=='n') {
    //ERRCCSLV2LM0003
    log_message('error', $validquery['messages'] .'Error: ERRCCSLV2LM0003');
    $this->LMStep3('Input Parameter contains malicious characters. Error: ERRCCSLV2LM0003');
    exit;
  }
  
  //form validation
  $result = $this->FormValidationModel->formValidationForPost($_POST, [
    'FDeedReg'=>'First Deed Reg.|required',
    'FDeedVal'=>'First Deed Value|required|2_digit_decimal',
    'LandPrice'=>'Land Price|required|2_digit_decimal',
    'COOrderNo'=>'CO Order No.|required',
    'COOrderdate'=>'CO Order Date|required',
    'purpose'=>'Purpose|required',
    'memonumber'=>'Memo No.|required|case_no',
    'sDeedVal'=>'Second Deed Value|2_digit_decimal',
    'TDeedVal'=>'Third Deed Value|2_digit_decimal',
  ]);
  // $result = postParamFormValidation($_POST, [
  //   'FDeedReg'=>'',
  //   'SDeedReg'=>'',
  //   'TDeedReg'=>'',
  //   'FDeedVal'=>'2_digit_decimal',
  //   'sDeedVal'=>'2_digit_decimal',
  //   'TDeedVal'=>'2_digit_decimal',
  //   'LandPrice'=>'2_digit_decimal',
  //   'COOrderNo'=>'',
  //   'COOrderdate'=>'date',
  //   'purpose'=>'',
  //   'memonumber'=>'case_no',
  //   'lv_copies'=>''
  // ]);
  if($result['status']=='n') {
    //ERRCCSLV2LM0004
    log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .'. Error: ERRCCSLV2LM0004');
    $this->LMStep3($result['message'] .'Error: ERRCCSLV2LM0004');
    exit;
  }

  //authentication
  // $sessionData = $this->session->all_userdata();
  // if(empty($sessionData) || !$sessionData['user_code']) {
  //   //ERRCCSLV2LM0005
  //   log_message('error', 'User not logged in! Error: ERRCCSLV2LM0005');
  //   $this->session->set_flashdata('message', 'User not logged in! Error: ERRCCSLV2LM0005');
  //   redirect(base_url('index.php/home'));
  //   exit;
  // }

  //authenticating and authorization
  $appln_no = $this->session->userdata('appln_no');
  $cert_no = $this->session->userdata('cert_no');

  $response = $this->AuthorizationModel->isAuthorized(100, 'LM', $cert_no);
  if($response['status']=='n') {
    //ERRCCSLV2LM0005
    log_message('error', $response['messages'] .' Error: ERRCCSLV2LM0005');
    $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSLV2LM0005');
    redirect(base_url('index.php/home'));
    exit;
  }
  // echo '<pre>';
  // var_dump($response);
  // die();
  // $certInfo = $this->CitizenCentric_Model->certInfo($appln_no, $cert_no);

  // if($sessionData['user_desig_code']!='LM' || empty($certInfo) || $sessionData['dist_code']!=$certInfo[0]->dist_code || $sessionData['subdiv_code']!=$certInfo[0]->subdiv_code || $sessionData['cir_code']!=$certInfo[0]->cir_code || $sessionData['mouza_pargona_code']!=$certInfo[0]->mouza_pargona_code || $sessionData['lot_no']!=$certInfo[0]->lot_no) {
  //   //ERRCCSLV2LM0006
  //   log_message('error', 'User not Authorized! Error: ERRCCSLVLM0005');
  //   $this->session->set_flashdata('message', 'User not Authorized! Error: ERRCCSLV2LM0006');
  //   redirect(base_url('index.php/home'));
  // }

  
  $db=  $this->session->userdata('db');
  $data = array();
  $deedno1 = $this->input->post('FDeedReg');
  $deedno2 = $this->input->post('SDeedReg');
  $deedno3 = $this->input->post('TDeedReg');
  $value1 = $this->input->post('FDeedVal');
  $value2 = $this->input->post('sDeedVal');
  $value3 = $this->input->post('TDeedVal');
  $deedno_value1 = $deedno1 . "-" . $value1;
  $deedno_value2 = $deedno2 . "-" . $value2;
  $deedno_value3 = $deedno3 . "-" . $value3;
  $lv_katha_price = $sum;//this->input->post('LandPrice');    //Add by Manashjyoti Deka on 2025-06-19
  $lv_co_ord_no = $this->input->post('COOrderNo');
  $lv_co_ord_date = $this->input->post('COOrderdate');

  $a = explode('/', $lv_co_ord_date);
  if ($lv_co_ord_date == null) {
   $lv_co_ord_date = '1970-01-01 00:00:00';
 } else {
   $lv_co_ord_date = $a[2] . "-" . $a[1] . "-" . $a[0];
 }
 $lv_purpose = $this->input->post('purpose');
 $lv_memo_no = $this->input->post('memonumber');
 $lv_copies_to = $this->input->post('lv_copies');

 $dist_code = $this->session->userdata('dist_code');
 $subdiv_code = $this->session->userdata('subdiv_code');
 $cir_code = $this->session->userdata('cir_code');
 $user_code = $this->session->userdata('user_code');
 $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
 $lot_no = $this->session->userdata('lot_no');
 $vill_townprt_code = $this->session->userdata('vill_townprt_code');
//  $appln_no = $this->session->userdata('appln_no');
 $data['sendValue'] = $arr = array(
   'deedno_value1' => $deedno_value1,
   'deedno_value2' => $deedno_value2,
   'deedno_value3' => $deedno_value3,
   'lv_katha_price' => $lv_katha_price,
   'lv_co_ord_no' => $lv_co_ord_no,
   'lv_co_ord_date' => $lv_co_ord_date,
   'lv_purpose' => $lv_purpose,
   'lv_memo_no' => $lv_memo_no,
   'lv_copies_to' => $lv_copies_to
 );

 $this->db->where('appln_no', $appln_no);
 $this->db->where('dist_code', $dist_code);
 $this->db->where('subdiv_code', $subdiv_code);
 $this->db->where('cir_code', $cir_code);
 $this->db->where('mouza_pargona_code', $mouza_pargona_code);
 $this->db->where('lot_no', $lot_no);
 $this->db->where('vill_townprt_code', $vill_townprt_code);
 $this->db->update("cert_application", $arr);

 $sql = "Select * from    Cert_Application where dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
 . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and appln_no='$appln_no' ";
 $data['certD'] = $db = $this->db->query($sql)->row();

 $sql = "Select * from cert_dag_details WHERE dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$db->cert_no'";
 $cDag = $data['certDag'] = $this->db->query($sql)->row();
 $bigha = $cDag->a_dag_area_b;
 $katha = $cDag->a_dag_area_k;
 $lessa = $cDag->a_dag_area_lc;
 $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
 $tot_price = round($tot_katha * $lv_katha_price, 2);

 $location = $this->utilityclass->getLocationfromSession();
 $dist = $this->utilityclass->getDistrictName($dist_code);
 $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
 $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
 $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
 $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
 $data['location'] = array(
   'distname' => $dist,
   'subname' => $sub,
   'cirname' => $cir,
   'mouza_pargona_code' => $mouza_name,
   'lot_no' => $lotname,
   'vill_townprt_code' => $vill_name,
   'tot_price' => $tot_price
 );
 if(!isset($this->session)){
    $this->session->set_flashdata('message', "Some Technical Issue occurs, try again");
    redirect(base_url() . "index.php/home");
 }
 $data['_view'] = 'citizen/LMPrintLV';
 $this->load->view('layouts/main',$data);
}

public function FinalStepLV() {
  $db=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  $arr = array('lm_checked_yn' => 'Y', 'status' => 'C');
  $this->db->where('appln_no', $appln_no);
  $this->db->where('dist_code', $dist_code);
  $this->db->where('subdiv_code', $subdiv_code);
  $this->db->where('cir_code', $cir_code);
  $this->db->where('mouza_pargona_code', $mouza_pargona_code);
  $this->db->where('lot_no', $lot_no);
  $this->db->where('vill_townprt_code', $vill_townprt_code);
  $this->db->update("cert_application", $arr);
        ///////////////////////////
  $cert_no=$this->session->userdata('cert_no');
  $penUser='CO';
  $rmrk='Order Passed By LM';
  $this->DashboardData($cert_no,$penUser,$rmrk); 
  $this->session->set_flashdata('message', $rmrk);
  redirect(base_url() . 'index.php/home');
}

public function FinalStepLH(){
$dist_code = $this->session->userdata('dist_code');
$subdiv_code = $this->session->userdata('subdiv_code');
$cir_code = $this->session->userdata('cir_code');
$user_code = $this->session->userdata('user_code');
$mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
$lot_no = $this->session->userdata('lot_no');
$vill_townprt_code = $this->session->userdata('vill_townprt_code');
$appln_no = $this->session->userdata('appln_no');
$date_entry = date('Y-m-d G:i:s');
$arr = array('lm_checked_yn' => 'Y', 'status' => 'C', 'date_entry' => $date_entry);
$this->db->where('appln_no', $appln_no);
$this->db->where('dist_code', $dist_code);
$this->db->where('subdiv_code', $subdiv_code);
$this->db->where('cir_code', $cir_code);
$this->db->where('mouza_pargona_code', $mouza_pargona_code);
$this->db->where('lot_no', $lot_no);
$this->db->where('vill_townprt_code', $vill_townprt_code);
$this->db->update("cert_application", $arr);
        ///////////////////////////
$cert_no=$this->session->userdata('cert_no');
$penUser='CO';
$rmrk='Order Passed By LM';
$this->DashboardData($cert_no,$penUser,$rmrk);
$this->session->set_flashdata('message', $rmrk);
redirect(base_url() . 'index.php/home');
}

    //  LM END
    // CO Start 
public function COStep1(){
$this->load->library('pagination');
$data = array();
$dist_code = $this->session->userdata('dist_code');
$subdiv_code = $this->session->userdata('subdiv_code');
$cir_code = $this->session->userdata('cir_code');
$user_code = $this->session->userdata('user_code');
$define_date = define_date;
$cases = $this->db->query("SELECT ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no  WHERE dist_code='$dist_code' "
 . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
 . " LM_Checked_yn='Y' and CO_Checked_yn is null and apply_date>='$define_date'  ")->result();
$data['cases'] = $cases;
$data['_view'] = 'Citizen/COPendingCases';
$this->load->view('layouts/main',$data);
}

public function COStep2() {
  $data = array();
  $cert_no = $this->input->get('cert_no');
  $cert_code = $this->input->get('cert_code');
  $values = array('cert_no' => $cert_no, 'cert_code' => $cert_code);
  $this->session->set_userdata($values);

  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $sql = "Select * from Cert_Application WHERE dist_code=? "
  . "and subdiv_code=? and cir_code=? and cert_no=? and cert_type=?";
  $db = $data['certApp'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $cert_no, $cert_code))->row();
  $tot_price = 0;
  if (($cert_code != '01')) {
    if (($cert_code != '03') and ( $cert_code != '04')) {
      $sql = "Select * from cert_dag_details WHERE dist_code=? "
      . "and subdiv_code=? and cir_code=? and cert_no=?";
      $cDag = $data['certDag'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $db->cert_no))->result();
                  //var_dump($data['certDag']);
      foreach ($cDag as $cDag) {
        $bigha = $cDag->a_dag_area_b;
        $katha = $cDag->a_dag_area_k;
        $lessa = $cDag->a_dag_area_lc;
        $lv_katha_price = $db->lv_katha_price;
        $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
        $tot_price = round($tot_katha * $lv_katha_price, 2);
      }
    }
  }
  if ($cert_code == '04') {
  $sql = "Select * from cert_dag_details where dist_code=? "
  . "and subdiv_code=? and cir_code=? and cert_no=? "; 
    $data['certDag'] = $certDag = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $db->cert_no))->row(); //$data['dagDtls'] 26/8/20
    $bigha = $certDag->a_dag_area_b;
    $katha = $certDag->a_dag_area_k;
    $lessa = $certDag->a_dag_area_lc;
    $lv_katha_price = $db->lv_katha_price;
    $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
    $tot_price = round($tot_katha * $lv_katha_price, 2);
  }
  if ($cert_code == '01') {
    $q = "Select * from cert_pending where dist_code=? "
    . "and subdiv_code=? and cir_code=? and cert_no=?";
    $data['jamapenreason'] = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code, $db->cert_no))->row();
  }

  $location = $this->utilityclass->getLocationFromSession();
  $dist = $this->utilityclass->getDistrictName($db->dist_code);
  $sub = $this->utilityclass->getSubDivName($db->dist_code, $db->subdiv_code);
  $cir = $this->utilityclass->getCircleName($db->dist_code, $db->subdiv_code, $db->cir_code);
  $mouza_name = $this->utilityclass->getMouzaName($db->dist_code, $db->subdiv_code, $db->cir_code, $db->mouza_pargona_code);
  $lotname = $this->utilityclass->getLotName($db->dist_code, $db->subdiv_code, $db->cir_code, $db->mouza_pargona_code, $db->lot_no);
  $vill_name = $this->utilityclass->getVillageName($db->dist_code, $db->subdiv_code, $db->cir_code, $db->mouza_pargona_code, $db->lot_no, $db->vill_townprt_code);
  $data['location'] = array(
    'distname' => $dist,
    'subname' => $sub,
    'cirname' => $cir,
    'mouzaname' => $mouza_name,
    'lotnoame' => $lotname,
    'villname' => $vill_name,
    'tot_price' => $tot_price
  );
  $data['_view'] = 'Citizen/COStep2';
  $this->load->view('layouts/main',$data);
}

  public function COStep3(){
    $cert_no = $this->session->userdata('cert_no');
    $cert_code = $this->session->userdata('cert_code');
    //syntax validation
    $checkSpclChar = checkRequestSpecChar($_POST);
    if($checkSpclChar['status']=='n') {
      //ERRCCSCO0006
      log_message('error', 'Input Parameter has illegal character. Error: ERRCCSCO0006');
      $this->session->set_flashdata('message', 'Input Parameter has illegal character. Error: ERRCCSCO0006');
      redirect(base_url('index.php/CitizenController/COStep2?cert_no='. $cert_no .'&cert_code='. $cert_code));
    }

    //check for Malicious
    $validquery = checkRequestValidQuery($_POST);
    if($validquery['status']=='n') {
      //ERRCCSCO0007
      log_message('error', $validquery['messages'] .'Error: ERRCCSCO0007');
      $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRCCSCO0007');
      redirect(base_url('index.php/CitizenController/COStep2?cert_no='. $cert_no .'&cert_code='. $cert_code));
    }

    //authentication
    // $sessionData=$this->session->all_userdata();
    // if(empty($sessionData) || !$sessionData['user_code']) {
    //   //ERRCCSCO0001
    //   log_message('error', 'The user is not logged in. Error: ERRCCSCO0001');
    //   $this->session->set_flashdata('message', 'The user is not logged in. Error: ERRCCSCO0001');
    //   redirect(base_url('index.php/home'));
    // }
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $co_comment = $this->input->post('COApprove');
    $user_code = $this->session->userdata('user_code');
    $comment_date = date('Y-m-d G:i:s');

    // $res = $this->CitizenCentric_Model->certInfoFromCode($cert_code, $cert_no, $dist_code, $subdiv_code, $cir_code);
    //authorization
    $response = $this->AuthorizationModel->isAuthorized(100, 'CO', $cert_no);
    if($response['status']=='n') {
      //ERRCCSCO0001
      log_message('error', $response['messages'] .' Error: ERRCCSCO0001');
      $this->session->set_flashdata('message', $response['messages'] .' Error: ERRCCSCO0001');
      redirect(base_url('index.php/home'));
    }
    // if($sessionData['user_desig_code']!='CO' || empty($res)){
    //   //ERRCCSCO0002
    //   log_message('error', 'User not Authorized. Error: ERRCCSCO0002');
    //   $this->session->set_flashdata('message', 'User not Authorized. Error: ERRCCSCO0002');
    //   redirect(base_url('index.php/home'));
    // }
    if (isset($_POST['FwdAst'])) {
      if($co_comment!='approved') {
        //ERRCCSCO0003
        log_message('error', 'CO comment is empty. Error: ERRCCSCO0003');
        $this->session->set_flashdata('message', 'CO comment is empty. Error: ERRCCSCO0003');
        redirect(base_url('index.php/CitizenController/COStep2?cert_no='. $cert_no .'&cert_code='. $cert_code));
      }
      $arr = array(
        'co_checked_yn' => 'Y',
        'status' => 'R',
        'user_code' => $user_code,
        'co_comment' => $co_comment,
        'comment_date' => $comment_date
      );
      $this->db->where('cert_no', $cert_no);
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->update("cert_application", $arr);
        ////////////////////////////////////////////
      $penUser='AST';
      $rmrk='Order Passed By CO';
      $this->DashboardData($cert_no,$penUser,$rmrk);
        /////////////////////////////////////////////
      $msg = "Certificate is ready Now. Forwarded it to the Assistant For Print. Application No. ##" . $cert_no;
      $this->session->set_flashdata('message', $msg);
      redirect(base_url() . 'index.php/home');
    }
    if (isset($_POST['FwdLM'])) {
      if(!isset($_POST['co_comment']) || $_POST['co_comment']=='') {
        //ERRCCSCO0004
        log_message('error', 'CO comment is empty. Error: ERRCCSCO0004');
        $this->session->set_flashdata('message', 'CO comment is empty. Error: ERRCCSCO0004');
        redirect(base_url('index.php/CitizenController/COStep2?cert_no='. $cert_no .'&cert_code='. $cert_code));
      }
      $co_comment = $this->input->post('co_comment');
      $sql = "Select * from cert_application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no'";
      $db = $this->db->query($sql)->row();
      $arr = array(
        'lm_checked_yn' => null,
        'co_checked_yn' => null,
        'status' => 'M',
        'co_comment' => $co_comment,
        'comment_date' => $comment_date
      );
      $this->db->where('cert_no', $cert_no);
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->update("cert_application", $arr);
          //////////////////////////////////
      $penUser='LM';
      $rmrk='Revert Back to LM by CO';
      $this->DashboardData($cert_no,$penUser,$rmrk);
          /////////////////////////////////////
      $sql = "select MAX(sl_no +1 ) as c from cert_co_lm_past_comment";
      $row = $this->db->query($sql)->row()->c;
      if ($row == null) {
        $row = 1;
      }
          //var_dump($db);
      $values = array('sl_no' => $row,
        'dist_code' => $db->dist_code,
        'subdiv_code' => $db->subdiv_code,
        'cir_code' => $db->cir_code,
        'mouza_pargona_code' => $db->mouza_pargona_code,
        'lot_no' => $db->lot_no,
        'vill_townprt_code' => $db->vill_townprt_code,
        'cert_type' => $db->cert_type,
        'appln_no' => $db->appln_no,
        'cert_no' => $db->cert_no,
        'year_no' => $db->year_no,
        'fee_amount' => $db->fee_amount,
        'patta_no' => trim($db->patta_no),
        'patta_type_code' => $db->patta_type_code,
        'pdar_id' => $db->pdar_id,
        'appln_name' => $db->appln_name,
        'appln_guard' => $db->appln_guard,
        'guard_reln' => $db->guard_reln,
        'inc_crop' => $db->inc_crop,
        'inc_unit_produced' => $db->inc_unit_produced,
        'inc_unit_price' => $db->inc_unit_price,
        'inc_other' => $db->inc_other,
        'inc_total' => $db->inc_total,
        'lv_katha_price' => $db->lv_katha_price,
        'lv_co_ord_no' => $db->lv_co_ord_no,
        'lv_co_ord_date' => $db->lv_co_ord_date,
        'lv_purpose' => $db->lv_purpose,
        'lv_memo_no' => $db->lv_memo_no,
        'lv_copies_to' => $db->lv_copies_to,
        'apply_date' => $db->apply_date,
        'due_date' => $db->next_due_date,
        'next_due_date' => null,
        'receipt_gen_yn' => $db->receipt_gen_yn,
        'status' => null,
        'user_code' => $db->user_code,
        'date_entry' => $db->date_entry,
        'co_comment' => $co_comment,
        'comment_date' => $comment_date
      );
      $this->db->insert("cert_co_lm_past_comment", $values);
      $msg = "Backward to LM report. Application No. ##" . $db->cert_no;
      $this->session->set_flashdata('message', $msg);
      redirect(base_url() . 'index.php/home');
          //exit;
    }
    if (isset($_POST['RejCO'])) {
      if(!isset($_POST['co_comment']) || $_POST['co_comment']=='') {
        //ERRCCSCO0005
        log_message('error', 'CO comment is empty. Error: ERRCCSCO0005');
        $this->session->set_flashdata('message', 'CO comment is empty. Error: ERRCCSCO0005');
        redirect(base_url('index.php/CitizenController/COStep2?cert_no='. $cert_no .'&cert_code='. $cert_code));
      }
      $co_comment = $this->input->post('co_comment');
      $sql = "Select * from cert_application where dist_code='$dist_code' 
      and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no'";
      $db = $this->db->query($sql)->row();
      $arr = array(
        'lm_checked_yn' => 'Y',
        'co_checked_yn' => 'Y',
        'status' => 'D',
        'co_comment' => $co_comment,
        'comment_date' => date('Y-m-d')
      );
      $this->db->where('cert_no', $cert_no);
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->update("cert_application", $arr);

      $this->DashboardDataFinal($cert_no);
              //////
      $values = array(
        'dist_code' => $db->dist_code,
        'subdiv_code' => $db->subdiv_code,
        'cir_code' => $db->cir_code,
        'mouza_pargona_code' => $db->mouza_pargona_code,
        'lot_no' => $db->lot_no,
        'vill_townprt_code' => $db->vill_townprt_code,
        'appln_no' => $db->appln_no,
        'pending_by' => $this->session->userdata('user_code'),
        'reason_pending' => $co_comment,
        'next_due_date' => date('Y-m-d'),
        'disposed_yn' => 'D',
        'cert_no' => $db->cert_no,
        'year_no' => date('Y'),
        'pending_date' => date('Y-m-d')
      );
      $this->db->insert("cert_pending", $values);
      $msg = "Application Rejected. Application No. ##" . $cert_no;
      $this->session->set_flashdata('message', $msg);
      redirect(base_url() . 'index.php/home');
      exit;
    }
  }

   public function CheckStatus() {
    $data = array();
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $define_date = define_date;
        //$year_no = year_no;
    $sql = "Select * from    cert_application where dist_code='$dist_code' 
    and subdiv_code='$subdiv_code' and cir_code='$cir_code' and apply_date>='$define_date'  ";
    $data['caseD'] = $this->db->query($sql)->result();
    $data['_view'] = 'Citizen/statuscheck';
    $this->load->view('layouts/main',$data);
  }

    // CO End 
  public function getAddYearAfter($diff) {
    $db=  $this->session->userdata('db');
    $diffr = ($diff * 365) + 1;
    $today = date('Y-m-d');
    $nextdate = date('d/m/Y', strtotime($today . ' + ' . $diffr . ' days'));
    $json = array();
    $json[] = array('display_year' => $nextdate);
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
  }

  public function ChithaSelectPatta(){
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('cert_no');
  $patta_no = trim($this->session->userdata('patta_no'));

  $sql = "Select * from    Cert_Application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and cert_no='$appln_no' ";
  $patta = $this->db->query($sql)->row();
  $sql = "Select * from    Chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
  . "and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta->patta_no')";
  $data['dag'] = $this->db->query($sql)->result();
  $data['_view'] = 'Citizen/DagSelectPatta';
  $this->load->view('layouts/main',$data);
}

public function Error() {
  $db=  $this->session->userdata('db');
  $data['_view'] = 'citizen/error';
  $this->load->view('layouts/main',$data);
}

public function LMValidation($d) {
      //$dbb=  $this->session->userdata('db');
  $dist_code = $this->session->userdata('dist_code');
  $subdiv_code = $this->session->userdata('subdiv_code');
  $cir_code = $this->session->userdata('cir_code');
  $user_code = $this->session->userdata('user_code');
  $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
  $lot_no = $this->session->userdata('lot_no');
  $vill_townprt_code = $this->session->userdata('vill_townprt_code');
  $appln_no = $this->session->userdata('appln_no');
  $cert_no = $this->session->userdata('cert_no');
  $sql = "Select * from  Cert_Application where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and appln_no='$appln_no' ";
        //echo $sql;
  $data['certD'] = $db = $this->db->query($sql)->row();

  $sql = "Select * from  chitha_basic where dist_code='$dist_code' "
  . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
  . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$db->patta_no') and dag_no='$d' and patta_type_code='$db->patta_type_code' ";
        // echo $sql;
  $lcode = $this->db->query($sql)->row();
  $c_bigha = $lcode->dag_area_b;
  $c_katha = $lcode->dag_area_k;
  $c_lc = $lcode->dag_area_lc;
  $c_ganda=$lcode->dag_area_g;

  echo json_encode(array('bigha' => $c_bigha, 'katha' => $c_katha, 'lessa' => $c_lc, 'ganda' => $c_ganda));
}

public function saveJamabandiByPattano() {
  if (isset($_GET['case_no'])) {
   $cert_no = $this->input->get('case_no');
   $dist_code = $this->session->userdata('dist_code');
   $subdiv_code = $this->session->userdata('subdiv_code');
   $cir_code = $this->session->userdata('cir_code');
   if ($cert_no != null) {
                // echo "adadas";
    $t_reclassification = $this->db->query("Select * from    cert_application where cert_no = '$cert_no' and dist_code='$dist_code' 
     and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
                //var_dump($t_reclassification);
    $dist_code = $t_reclassification->dist_code;
    $subdiv_code = $t_reclassification->subdiv_code;
    $circle_code = $t_reclassification->cir_code;
    $mouza_code = $t_reclassification->mouza_pargona_code;
    $lot_no = $t_reclassification->lot_no;
    $vill_code = $t_reclassification->vill_townprt_code;
    $pattatypeCode = $t_reclassification->patta_type_code;
    $patta_no = trim($t_reclassification->patta_no);
    $user_code = $this->input->post('user_code');
  }
  $this->load->helper('qrcode');
  $main = array();
  $jamainfo = array();
  $pattatype = array(
    'patta_type' => $pattatypeCode,
    'patta_no' => $patta_no
  );
  $this->session->set_userdata($pattatype);

  $this->load->model('misreport/MisModel');

  $districtdata = $this->MisModel->getDistrictName($dist_code);
  $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
  $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
  $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
  $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
  $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
  $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);

  $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
  $maindata['pattainfo'] = $pattatype;
  $pno = trim($patta_no);
  $main['daginfo'] = array();

  $get_patta_info = "select count(*) as count from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
  . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno'";

  $get_patta_info = $this->db->query($get_patta_info)->row()->count;

  if ($get_patta_info != "") {
    $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
    . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
    . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
    . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by dag_no";

    $main['daginfo'] = $this->db->query($query)->result();
    $daginfo_counted = count($main['daginfo']);

    if ($daginfo_counted != "") {
     $query = "select patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
     . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
     . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
     . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";

     $main['pattadarinf'] = $this->db->query($query)->result();
   } else {
            //If dag and patta for old patta does not exist.
     $main['pattadarinf'] = null;
     $main['daginfo'] = null;
   }
   $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
   . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
   . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
   . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
   . "TRIM(patta_no)='$pno' order by rmk_line_no ";
   $main['remarkinf'] = $this->db->query($query)->result();

   $query = "select old_patta_no from    jama_patta WHERE "
   . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
   . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
   . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
   . "TRIM(patta_no)='$pno' ";
   $main['oldpno'] = $this->db->query($query)->result();

   $main = array_merge($maindata, $main);

   $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
   $this->load->view('layouts/main',$main);
 } else {
  $data['_view'] = 'jamabandi/no_jamabandi';
  $this->load->view('layouts/main',$data);

}

}
}

public function saveJamabandi() {
  $db=  $this->session->userdata('db');
  if (isset($_POST['Submit'])) {
   $cert_no = $this->input->post('cert_no');
   $dist_code = $this->session->userdata('dist_code');
   $subdiv_code = $this->session->userdata('subdiv_code');
   $cir_code = $this->session->userdata('cir_code');
   $pdar_alignment = '1';
   if ($cert_no != null) {
    $t_reclassification = $this->db->query("Select * from    cert_application where cert_no = '$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();

    $dist_code = $t_reclassification->dist_code;
    $subdiv_code = $t_reclassification->subdiv_code;
    $circle_code = $t_reclassification->cir_code;
    $mouza_code = $t_reclassification->mouza_pargona_code;
    $lot_no = $t_reclassification->lot_no;
    $vill_code = $t_reclassification->vill_townprt_code;
    $pattatypeCode = $t_reclassification->patta_type_code;
    $patta_no = $t_reclassification->patta_no;
    $comment_date = $t_reclassification->comment_date;
    $couser_code = $t_reclassification->user_code;
    $user_code = $this->input->post('user_code');
  }
  $this->load->helper('qrcode');
  $main = array();
  $jamainfo = array();
  $pattatype = array(
    'patta_type' => $pattatypeCode,
    'patta_no' => $patta_no,
    'case_no' => $cert_no,
    'submission_date' => $comment_date
  );


  $this->session->set_userdata($pattatype);
  $this->load->model('misreport/MisModel');

  $districtdata = $this->MisModel->getDistrictName($dist_code);
  $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
  $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
  $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
  $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
  $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
  $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
  $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
  $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
  $maindata['pattainfo'] = $pattatype;
  $maindata['username'] = $username;
  $pno = $patta_no;
  $main['daginfo'] = array();
  $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
  . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
  . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
  . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
  $main['daginfo'] = $daginfo = $this->db->query($query)->result();
  foreach ($daginfo as $p) {
    $b = $p->dag_area_b;
    $k = $p->dag_area_k;
    $lc = round($p->dag_area_lc, 2);
  }
  $daginfo_counted = count($main['daginfo']);

  $main['sort_pdar_by']='1';
  if ($daginfo_counted != "") {
    if ($pdar_alignment == '0') {
     $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
     . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
     . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
     . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
     $q = $this->db->query($query)->result();

     $q1 = array();

   }
   if ($pdar_alignment == '1') {
     $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
     . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
     . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
     . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
     $q = $this->db->query($query)->result();

     $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
     . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
     . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
     . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

     $q1 = $this->db->query($query1)->result();
   }
   $main['pattadarinf'] = array_merge($q,$q1);

   $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
   . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
   . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
   . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
   . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                //echo $query . "<br>";
   $main['remarkinf'] = $this->db->query($query)->result();
   $query = "select old_patta_no from    jama_patta WHERE "
   . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
   . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
   . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
   . "TRIM(patta_no)=TRIM('$pno') ";

   $main['oldpno'] = $this->db->query($query)->result();

   $q = " select pdar_name,pdar_father,pdar_add1 from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
   . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
   $pattadarname = $this->db->query($q)->row();
   $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

   $base_64 = printQR($pname);
   $main['qrcode'] = $base_64;

   $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
   $main['qrBasic'] = $basic;

   $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
   $main['qrCONAME'] = $coQR;

   $main = array_merge($maindata, $main);
   $main['sort_pdar_by']=1;
   $main['_view'] = 'jamabandi/save_jamabandi_by_selecting_pattano_print';
   $this->load->view('layouts/main',$main);
 } else {
  $main['_view'] = 'jamabandi/no_jamabandi';
  $this->load->view('layouts/main',$main);
}

}
}


    //////////////////////////////////////
function Dashboard($case_no){
  $this->dbb = $this->load->database('dash', TRUE);
  $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.cert_no as case_no,pb.patta_no,pb.patta_type_code,pb.appln_name as pet_name,pb.appln_guard as guard_name,pb.guard_reln as guard_rel,pb.status,pb.date_entry,pb.user_code from cert_application pb  where  pb.cert_no='$case_no' ";
  $data=$this->db->query($sql)->row_array();
  $type='CR';
  $base= array(
   'dist_code'=> $data['dist_code'],
   'subdiv_code' =>$data['subdiv_code'],
   'cir_code'=>$data['cir_code'],
   'mouza_pargona_code'=>$data['mouza_pargona_code'],
   'lot_no'=>$data['lot_no'],
   'vill_townprt_code'=>$data['vill_townprt_code'],
   'case_no'=>$data['case_no'],
   'date_of_reg'=>$data['date_entry'],
   'dag_no'=>'NA',
   'patta_type_code' =>$data['patta_type_code'],
   'patta_no' =>$data['patta_no'],
   'status' =>'P',
   'pending_with_user' =>'LM',
   'case_type' =>$type,
   'date_of_insert'=>date("Y-m-d h:i:s")
 );
  $this->dbb->insert('dashboard_data',$base);

  unset($base['dag_no']);
  unset($base['patta_type_code']);
  unset($base['patta_no']);

  $this->db->insert('dashboard_data',$base);

  $applicant= array(
   'case_no' => $case_no,
   'applicant_name' => $data['pet_name'],
   'guardian_name' => $data['guard_name'],
   'gender' => $data['guard_rel'] );
  $this->dbb->insert('dashboard_applicant',$applicant);
  $action= array(
   'case_no' => $case_no,
   'user_code' => $this->session->userdata('user_code'),
   'date_of_action_taken' => date('Y-m-d'),
   'user_designation' => $this->session->userdata('user_desig_code'),
   'remark' => 'Registered By Assistant',
 );
  $this->dbb->insert('dashboard_action',$action);
}
function DashboardData($case_no,$penUser,$rmrk){
        //////////////Update Dashboard Database///////////////////////
  $this->dbb = $this->load->database('dash', TRUE);
  $base=array(
   'pending_with_user' => $penUser,
   'date_of_update'=>date("Y-m-d h:i:s")
 );
  $this->dbb->where('case_no',$case_no);
  $this->dbb->update('dashboard_data',$base);

  $this->db->where('case_no',$case_no);
  $this->db->update('dashboard_data',$base);

  $action= array(
   'case_no' => $case_no,
   'user_code' => $this->session->userdata('user_code'),
   'date_of_action_taken' => date('Y-m-d'),
   'user_designation' => $this->session->userdata('user_desig_code'),
   'remark' => $rmrk,
 );
  $this->dbb->insert('dashboard_action',$action);
            /////////////////////////////////////
}
function DashboardDataFinal($case_no){
        //////////////Update Dashboard Database///////////////////////
  $this->dbb = $this->load->database('dash', TRUE);
  $base=array(
   'final_order_date' => date('Y-m-d'),
   'pending_with_user'=>'NA',
   'status'=>'F',
   'remark'=>'Final Order Passed',
   'date_of_update'=>date("Y-m-d h:i:s")
 );
  $this->dbb->where('case_no',$case_no);
  $this->dbb->update('dashboard_data',$base);

  $this->db->where('case_no',$case_no);
  $this->db->update('dashboard_data',$base);

  $action= array(
   'case_no' => $case_no,
   'user_code' => $this->session->userdata('user_code'),
   'date_of_action_taken' => date('Y-m-d'),
   'user_designation' => $this->session->userdata('user_desig_code'),
   'remark' => 'Final Order Passed',
 );
  $this->dbb->insert('dashboard_action',$action);
            /////////////////////////////////////
}

function requestCircle($service){
        //var_dump($_SESSION);
        $this->load->model('rtps/rtpsmodel');
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $data['dist_code'] = $d;
        $data['subdiv_code'] = $s;
        $data['cir_code'] = $c;
        $data['service_code'] = $service;
        $apiData = $this->rtpsmodel->allVilageAndStatus($d,$s,$c,$service);
        $data['pending'] = $apiData->location;
        $villageList = array();
        foreach ($data['pending'] as $key => $value) {
            $villageList[$key]['village_code'] = $value->mouza_code."-".$value->lot_no."-".$value->village_code;
            $villageList[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code,$value->lot_no,$value->village_code);
            $villageList[$key]['rurban'] = $value->is_urban == 'Y' ? 'Urban' : 'Rural';
         }
        $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageList)));
        $data['villageList'] =  $uniqueVillage;
        $mouzaList = array();
        foreach ($data['pending'] as $key => $value) {
            $mouzaList[$key]['mouza_code'] = $value->mouza_code;
            $mouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code);
            $mouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code,$value->lot_no);
            $mouzaList[$key]['lot_no'] = $value->lot_no;
         }
        $uniqueMouza = array_map("unserialize", array_unique(array_map("serialize", $mouzaList)));
        $data['mouzaList'] =  $uniqueMouza;
        $category = array();
        $data['pending'] = $apiData->status;
        foreach ($data['pending'] as $key => $value) {
            if (($value->pending_with_officer=='NA' || $value->pending_with_officer=='Approved' || $value->pending_with_officer=='F') && $value->status=='F')
            {
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Delivered';
                $category[$key]['sts'] = 'F';

            }
            else if ($value->pending_with_officer =='NA' && $value->status='R')
            {
               $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Rejected'; 
                $category[$key]['sts'] = 'R';
            }
            else if($value->status=='Q'){
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Query Sent';
                $category[$key]['sts'] = 'Q';
            } 
            else {
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Pending'; 
                $category[$key]['sts'] = null;
            }
         }
        $unique = array_map("unserialize", array_unique(array_map("serialize", $category)));
        $data['category'] =  $unique;
        $data['title'] = 'Application List';
        $data['_view'] = 'citizen/new_pagination_for_ror_dsc';
        $this->load->view('layouts/main',$data);
    }


    public function viewPendingCasesAPIROR()
    {
            $service = $this->input->post('service_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
            $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
            $is_cat = $this->input->post('is_category');
            $is_rural = $this->input->post('rural');
            $pending_at = $this->input->post('pending_at');
            $pending_st = $this->input->post('pendingSts');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_mouza_code = $this->input->post('vill_mouza_code');
            $vill_lot_no = $this->input->post('vill_lot_no');
            $village_code = $this->input->post('village_code');
            //echo RTPS_API_LINK."viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service";
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."viewPendingCasesByCircleROR/$dist_code/$subdiv_code/$cir_code/$service");
            // curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/rtpsmb2/Api/viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'start'             => $start,
                'length'            => $length,
                'order'             => $order,
                'searchByCol_0'     => $searchByCol_0,
                'searchByCol_1'     => $searchByCol_1,
                'is_cat'            => $is_cat,
                // 'is_rural'          => $is_rural,
                'pending_at'        => $pending_at,
                'pending_st'        => $pending_st,
                'mouza_code'        => $mouza_code,
                'lot_no'            => $lot_no,
                'vill_mouza_code'   => $vill_mouza_code,
                'vill_lot_no'       => $vill_lot_no,
                'village_code'      => $village_code
            )));
            $result = curl_exec($curl_handle);
            $results = json_decode($result);
            // echo "<pre>";
            // var_dump($results);
            $service_type=null;
            if(isset($results)){
            $data_rows = $results->data_results;
                foreach($data_rows as $rows){
                    if(($rows->service_code == '11') && ($rows->pending_with_officer=='CO')){
                        $view_link = '<a href='.base_url().'index.php/citizencontroller/jamabandiDscPost?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Forward</a>';
                    }else if(($rows->service_code == '11') && ($rows->pending_with_officer=='NA' || $rows->pending_with_officer=='Approved' || $rows->pending_with_officer=='F') && $rows->status=='F'){
                        $view_link = 'Order Passed';
                    }else{
                        $view_link = '--';
                    }

                    if (($rows->pending_with_officer=='NA' || $rows->pending_with_officer=='Approved' || $rows->pending_with_officer=='F') && $rows->status=='F')
                    {
                        $category = $rows->pending_with_officer." - Delivered";
                    }
                    else if ($rows->pending_with_officer =='NA' && $rows->status='R' )
                    {
                       $category = $rows->pending_with_officer." - Rejected"; 
                    }
                    else if($rows->status=='Q')
                    {
                        if($rows->pending_with_officer=='LM'){
                            $rows->pending_with_officer='LRA';
                        }
                        else if($rows->pending_with_officer=='SK'){
                            $rows->pending_with_officer='LRS';
                        }

                        else
                        {
                            $rows->pending_with_officer=$rows->pending_with_officer;
                        }

                        $category = $rows->pending_with_officer." - Query Sent";
                    } 
                    else 
                    {
                        if($rows->pending_with_officer=='LM'){
                            $rows->pending_with_officer='LRA';
                        }
                        else if($rows->pending_with_officer=='SK'){
                            $rows->pending_with_officer='LRS';
                        }

                        else
                        {
                            $rows->pending_with_officer=$rows->pending_with_officer;
                        }
                        
                        $category = $rows->pending_with_officer." - Pending"; 
                    }

                    $json[] = array(
                        '<span class="px-3"><strong>'.$rows->application_no.'</strong></span>',
                        $rows->date_submission,
                        $rows->service."<br>".$service_type,
                        $rows->rurban. " - ".$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code,$rows->lot_no,$rows->village_code),
                        $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code). " - ".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code,$rows->lot_no),
                        $category,
                        $view_link,
                    );
                }
                $total_records = $results->total_records;
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $total_records,
                    'recordsFiltered'   => $total_records,
                    'data'              => $json
                );
                echo json_encode($response);
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        }


    function jamabandiDscPost(){
        $application_no=$this->input->get('app');
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);

        //var_dump($application_no);exit;
        if($recordExist)
        {
              $dharitree_case = $this->db->query("select dharitree from basundhar_application where basundhara ='$application_no'");
              $cert_no_dhar = $dharitree_case->row();


              $sql = $this->db->query("select * from cert_application where cert_no ='$cert_no_dhar->dharitree'");
              $result = $sql->row();
              $cert_no = $result->cert_no;
              $dist_code = $result->dist_code;
              $subdiv_code = $result->subdiv_code;
              $cir_code = $result->cir_code;
              $pdar_alignment = '1';

              if ($cert_no != null) {
                $t_reclassification = $this->db->query("Select * from cert_application where cert_no = '$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;
                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = $t_reclassification->patta_no;
                $comment_date = $t_reclassification->comment_date;
                $couser_code = $this->session->userdata('user_code');
                $user_code = $this->session->userdata('user_code');
                $application_ref_no = $t_reclassification->application_ref_no;
              }

              // var_dump($couser_code);exit;
              $this->load->helper('qrcode');
              $main = array();
              $jamainfo = array();
              $pattatype = array(
                  'patta_type' => $pattatypeCode,
                  'patta_no' => $patta_no,
                  'case_no' => $cert_no,
                  'submission_date' => $comment_date
              );
                
              ////view jb////
            $this->session->set_userdata($pattatype);
            $this->load->model('misreport/MisModel');

            $districtdata = $this->MisModel->getDistrictName($dist_code);
            $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
            $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
            $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
            $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
            $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
            $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
            $maindata['pattainfo'] = $pattatype;
            $main['application_ref_no'] = $application_ref_no;
            $maindata['username'] = $username;
            $pno = $patta_no;
            $main['daginfo'] = array();

            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from "
            . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
            . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
            . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
            $main['daginfo'] = $daginfo = $this->db->query($query)->result();
            foreach ($daginfo as $p) {
                $b = $p->dag_area_b;
                $k = $p->dag_area_k;
                $lc = round($p->dag_area_lc, 2);
                $g=$p->dag_area_g;
            }
            $daginfo_counted = count($main['daginfo']);
            // var_dump($main['daginfo']);exit;

            $main['sort_pdar_by'] = '1';
            if ($daginfo_counted != "") {

                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                    $q = $this->db->query($query)->result();

                    $q1 = array();
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                    $q = $this->db->query($query)->result();

                    $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                    $q1 = $this->db->query($query1)->result();
                }
                $main['pattadarinf'] = array_merge($q, $q1);

                $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                $main['remarkinf'] = $this->db->query($query)->result();
                $query = "select old_patta_no from jama_patta WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') ";

                $main['oldpno'] = $this->db->query($query)->result();

                $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
                $pattadarname = $this->db->query($q)->row();
                $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

                $base_64 = printQR($pname);
                $main['qrcode'] = $base_64;

                $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
                $main['qrBasic'] = $basic;

                $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
                $main['qrCONAME'] = $coQR;

                $main = array_merge($maindata, $main);
                $main['sort_pdar_by'] = 1;

                //#START PLB

                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $main['_view'] = 'citizen/save_jamabandi_by_selecting_pattano_print_kar';
                }
                else{
                     $main['_view'] = 'citizen/save_jamabandi_by_selecting_pattano_print_dsc';   
                }
                
                //#END PLB

                //$main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print';
                $this->load->view('layouts/main',$main);
              ////end jb/////

              }
        }

        else
        {

        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output->application;
        $data['pattaInfo']=$output->mutation[0];
        $data['firstParty']=$output->applicants[0];
        $data['document']=$output->documents;
        $data['query']=$output->query;
        // var_dump($data['pattaInfo']);exit;
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        $this->db->trans_begin();

        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $year_no = date('Y');
        $cert_type = '01';
        $cername = $this->utilityclass->getCertCode($cert_type);
       // $petition_no=$this->rtpsmodel->genearteCertPetitionNo();

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteCertPetitionNo();


        $appln_no = $cername . "/" . $petition_no . "/" . $year_no;
        $data['cert_no']=$cert_no =$case_name.$petition_no."/".$cername;

        $insert = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'cert_type' =>'01',
            'appln_no' => $appln_no,
            'cert_no' => $cert_no,
            'year_no' => date('Y'),
            'fee_amount' => $this->input->post('cert_fees'),
            'patta_no' => $data['pattaInfo']->patta_no,
            'patta_type_code' => $data['pattaInfo']->patta_type_code,
            'pdar_id' => $data['pattaInfo']->chitha_pdar_id,
            'appln_name' => $this->input->post('pdar_name'),
            'appln_guard' => $this->input->post('guard_name'),
            'guard_reln' => $this->utilityclass->relationRevertBasu($data['app']->dist_code,$data['firstParty']->pat_gurdian_rel_id),
            'apply_date' => $data['app']->date_submission,
            'next_due_date' => date('Y-m-d G:i:s'),
            'receipt_gen_yn' => 'Y',
            'status' => 'M',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'rev_yn' =>  $this->session->userdata('revenue'),
            'pdar_aadharno' => '',
            'pdar_mobile' => $this->input->post('mobile_no'),
            'pdar_pan' =>'',
            'mode_of_registration' => 'citizen',
            'application_ref_no' => $application_no,
            'applid' => '',
        );
        //var_dump($insert);exit;
        $insCertAppl=$this->db->insert('cert_application', $insert);

        // echo $this->db->last_query();
        // $this->db->trans_rollback();
        // exit;

        if($insCertAppl != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ001: Insertion failed in cert_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ001: Registration of RoR-jamabandi failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        $basundhara=array(
                'dharitree'=>$cert_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuROR = $this->db->insert('basundhar_application',$basundhara);

        if($insBasuROR != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ002: Registration of RoR-jamabandi by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }
        else
            {
              $this->db->trans_commit();
              $sql = $this->db->query("select * from cert_application where cert_no ='$cert_no'");
              $result = $sql->row();
              // var_dump($result->dist_code);exit;
              $cert_no = $result->cert_no;
              $dist_code = $result->dist_code;
              $subdiv_code = $result->subdiv_code;
              $cir_code = $result->cir_code;
              $pdar_alignment = '1';

              if ($cert_no != null) {
                $t_reclassification = $this->db->query("Select * from cert_application where cert_no = '$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;
                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = $t_reclassification->patta_no;
                $comment_date = $t_reclassification->comment_date;
                $couser_code = $this->session->userdata('user_code');
                $user_code = $this->session->userdata('user_code');
                $application_ref_no = $t_reclassification->application_ref_no;
              }

              // var_dump($couser_code);exit;
              $this->load->helper('qrcode');
              $main = array();
              $jamainfo = array();
              $pattatype = array(
                  'patta_type' => $pattatypeCode,
                  'patta_no' => $patta_no,
                  'case_no' => $cert_no,
                  'submission_date' => $comment_date
              );

              // var_dump($pattatype);exit;
                
              ////view jb////
            $this->session->set_userdata($pattatype);
            $this->session->set_userdata($application_ref_no);
            $this->load->model('misreport/MisModel');

            $districtdata = $this->MisModel->getDistrictName($dist_code);
            $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
            $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
            $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
            $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
            $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
            $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
            $maindata['pattainfo'] = $pattatype;
            $main['application_ref_no'] = $application_ref_no;
            $maindata['username'] = $username;
            $pno = $patta_no;
            $main['daginfo'] = array();

            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from "
            . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
            . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
            . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
            $main['daginfo'] = $daginfo = $this->db->query($query)->result();
            foreach ($daginfo as $p) {
                $b = $p->dag_area_b;
                $k = $p->dag_area_k;
                $lc = round($p->dag_area_lc, 2);
                $g=$p->dag_area_g;
            }
            $daginfo_counted = count($main['daginfo']);
            // var_dump($main['daginfo']);exit;

            $main['sort_pdar_by'] = '1';
            if ($daginfo_counted != "") {

                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                    $q = $this->db->query($query)->result();

                    $q1 = array();
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                    $q = $this->db->query($query)->result();

                    $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                    $q1 = $this->db->query($query1)->result();
                }
                $main['pattadarinf'] = array_merge($q, $q1);

                $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                $main['remarkinf'] = $this->db->query($query)->result();
                $query = "select old_patta_no from jama_patta WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') ";

                $main['oldpno'] = $this->db->query($query)->result();

                $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
                $pattadarname = $this->db->query($q)->row();
                $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

                $base_64 = printQR($pname);
                $main['qrcode'] = $base_64;

                $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
                $main['qrBasic'] = $basic;

                $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
                $main['qrCONAME'] = $coQR;

                $main = array_merge($maindata, $main);
                $main['sort_pdar_by'] = 1;

                //#START PLB

                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $main['_view'] = 'citizen/save_jamabandi_by_selecting_pattano_print_kar';
                }
                else{
                     $main['_view'] = 'citizen/save_jamabandi_by_selecting_pattano_print_dsc';   
                }
                
                //#END PLB

                //$main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print';
                $this->load->view('layouts/main',$main);
              ////end jb/////

              }
            }
        }
    }

    public function dscbaseencode()
    {
      $data = json_decode(file_get_contents("php://input"), true); 
      // var_dump($data['post']);
      // return;
  
      $params = array(
          'data' => $data['post'],
      );
                /////////API//////////
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "https://dharitreestage.assam.gov.in/html-to-pdf-v1/");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($params));
        log_message('error', 'A1: calling ngdrs api with params: '.json_encode($params));
        $result = curl_exec($curl_handle);
        if (curl_errno($curl_handle)) 
        {
            $error_msg = curl_error($curl_handle);
            log_message('error',"#ERROR4319===getbase64jamabandi for date--".date('Y-m-d')."--".json_encode($error_msg));
        }
        $result = json_decode($result);

        //var_dump($result->data);

        $data=array(
                    'success'=>"true",
                    'data'=>$result->data
                );
        echo json_encode($data);
    }
    public function savePushSignFiletoRtps()
    {
      $pdfData            = $this->input->post('pdfData');
      $application_ref_no = $this->input->post('application_ref_no');
      $q = "Select * from basundhar_application where basundhara=?";
      $caseDetails = $this->db->query($q,array($application_ref_no))->row();
      if(empty($caseDetails))
      {
        return false;
      }
      $upload_path   = UPLOAD_BASE.'/ROR_FILES/'; 
      if (is_dir($upload_path) === false){
          mkdir($upload_path);
      }
      $case_no = $caseDetails->dharitree;
      $timestamp = date('Ymd_His'); 
      $random_string = substr(md5(time()), 0, 6); // Random hash for uniqueness
      $file_name = "ROR_{$timestamp}_{$random_string}.html";
      log_message('error',"FILE SAVED".$application_ref_no);
      $file_path = $upload_path."/".$file_name;
      if(file_put_contents($file_path, $pdfData))
      {
        $document= array(
            'case_no'   => $case_no,
            'file_name' => 'ROR_SIGNED_FILE',
            'user_code' => $this->session->userdata('user_code'),
            'fetch_file_name' => $file_name,
            'file_type'  => 'application/html',
            'file_path'  => $file_path,
            'date_entry' => date('Y-m-d h:i:s'),
            'mut_type'   => 'R',
            'applid'     => $application_ref_no
        );
        // save data in attachment file
        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
        if($addMoreDocQuery != 1)
        {
           return false;
        }
        /////////api calling//////////////
        $rmk='Uploads certificate';
        $status='F';
        $task='CO';
        $pen='NA';
        $case=$case_no;
        $result= $this->rtpsmodel->postApiDocBasundhara($application_no,$case,$rmk,$status,$task,$pen,$pdfData);
        if($result->status=='true')
        {
          return true;
        }
        else
        {
          return false;
        }
        /////////END///////////////////////

      }
      else
      {
        return false;
      }
    }

}
