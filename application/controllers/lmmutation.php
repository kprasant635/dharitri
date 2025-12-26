<?php
//BRD0014: ByayPrak Report remove for RTPS Service(s) from LM End Auto submit
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LMMutation extends CI_Controller {

    var $user_code;
    var $config = array();
    var $language;
    var $append = '';
    var $base_query = "";

    public function __construct() {
        parent::__construct();
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('relation/relationmodel');
        $this->load->model('rtps/rtpsmodel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/basundharamodel');
        //var_dump($this->session->all_userdata());
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
    public function index() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/lm_mutation');
        // $this->load->view('../views/footer');
        $data['_view'] = 'lm_mutation';
        $this->load->view('layouts/main',$data);
    }
    public function mutation() {
        if(RTPS_CERT_ON_OFF=='1'){ 
            $this->session->set_flashdata('message', 'Not Authorised');
            redirect(base_url() . "index.php/home/index");
            return; 
        }
        else
        {
        
        if($this->session->unset_userdata('vill_code')){
            $this->session->unset_userdata('patta_no');
            $this->session->unset_userdata('mut_type');
            $this->session->unset_userdata('trans_code');
            $this->session->unset_userdata('patta_type');
            $this->session->unset_userdata('dag_no');
            $this->session->unset_userdata('vill_code');
        }
        $this->session->unset_userdata('appdet');
        $this->session->unset_userdata('dag_det');
        $this->session->unset_userdata('patdet');
        $this->session->unset_userdata('fmb');
        $this->session->unset_userdata('start');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));
        $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['villages'] = $data;
        // $this->load->view('../views/lmmutation/select_location', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'lmmutation/select_location';
        $this->load->view('layouts/main',$district);
    }
    }
    public function getUserDesignation($user_code) {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "select user_desig_code from  users where user_code='$user_code'";
        $result = $this->db->query($q)->row()->user_desig_code;
        $assamese = $this->db->query("select user_desig_as from  master_user_designation where user_desig_code='$result'")->row()->user_desig_as;
        $json = array(
            'user_desig_code' => $assamese,
            'user_code' => $result
        );
        echo json_encode($json);
    }

    public function isMultiple() {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/lmmutation/ismultiple');
        // $this->load->view('../views/footer');
        $data['_view'] = 'lmmutation/ismultiple';
        $this->load->view('layouts/main',$data);
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $ismultiple = false;
            if ($this->input->post('ismultiple') == 'true') {
                $ismultiple = true;
            }
            $this->session->set_userdata(array('ismultiple' => $ismultiple));
            $mutType = $this->session->userdata('fmb');
            
            $mutType = $mutType['mut_type'];

            if ($mutType == '02') {
                redirect(base_url() . "index.php/lmmutation/mutationlandarea?mut_type=02");
            } else {
                redirect(base_url() . "index.php/lmmutation/applicantdetails");
            }
        }
    }

    public function mutationType() {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        
        $mutation['dist_code'] = $dist_code;
        $mutation['subdiv_code'] = $subdiv_code;
        $mutation['cir_code'] = $cir_code;
        $mutation['mouza_code'] = $mouza_pargona_code;
        $mutation['lot_no'] = $lot_no;
        $mutation['vill_code'] = $vill_code;
        $this->form_validation->set_rules('vill_code', 'Username', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->mutation();
            return;
        }
        
        $locationData = array(
            'vill_code' => $vill_code,
        );
        if($this->session->userdata('vill_code')){
            $this->session->set_flashdata('message',"Error in Processing ! You might be trying from multiple session");
            redirect('/lmmutation/mutation');
        }
        $this->session->set_userdata($locationData);
        $mutation['type'] = $this->mutationmodel->getMutationType();
        $q = "select * from  loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and (priv='mut' or priv='adm') and user_code like 'CO%' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code = '$cir_code' and user_code='$u->user_code' ";
            $mutation['user'][] = $this->db->query("select * from  users where " . $query_string)->row();
        }
        $patt_type = $this->mutationmodel->getPattaType();
        $mutation['patta_type'] = $patt_type;
        
        $patt_type_without_aksona = $this->mutationmodel->getPattaTypeExcludingAksona();
        $mutation['patta_type_excluding_aksona'] = $patt_type_without_aksona;
        
        $mutation['_view'] = 'lmmutation/mutationtype';
        $this->load->view('layouts/main',$mutation);
    }

    public function mutationLandArea() {
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));

        $patta_type = $this->session->userdata('patta_type');
        $case_no = $this->session->userdata('case_no');
        ////var_dump($this->utilityclass->getLocationFromSession());
        $dags['dags'] = $this->PattaModel->getDagsByPattaNoPattaType($patta_no, $patta_type, $case_no)->result();
        $b = $this->session->userdata('applied_b');
        $k = $this->session->userdata('applied_k');
        $lc = $this->session->userdata('applied_lc');
        $sourcelessa = $b * 100 + $k * 20 + $lc;
        $dags['b'] = floor($sourcelessa / 100);
        $dags['k'] = floor(($sourcelessa - $dags['b'] * 100) / 20);
        $dags['lc'] = $sourcelessa - $dags['b'] * 100 - $dags['k'] * 20;
        $dags['mut_type'] = '02';
        if ($this->input->get('mut_type') == '02') {
            $dags['type'] = 02;
        } else {
            $dags['type'] = 01;
        }
        $dags['_view'] = 'lmmutation/mutationlandarea';
        $this->load->view('layouts/main',$dags);
    }

    public function getDagsByPattaNoPattaTypeJSON() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $case_no = $this->session->userdata('case_no');
        $dags = $this->PattaModel->getDagsByPattaNoPattaType($patta_no, $patta_type, $case_no)->result();
        $json = array();
        foreach ($dags as $object) {
            $json[] = array('dag_no' => $object->dag_no);
        }
        echo json_encode($json);
    }

    public function getDagsByPattaNoJSON() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        //$case_no = $this->session->userdata('case_no');
        $dags = $this->PattaModel->getDagsByPattaNo($patta_no, $patta_type)->result();
        $json = array();
        foreach ($dags as $object) {
            $json[] = array('dag_no' => $object->dag_no);
        }
        echo json_encode($json);
    }

    public function getPattadarFilteredJSON() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/PattaModel');
        $this->PattaModel->getPattadarFiltered();
    }

    public function getSubdivJson($distcode) {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getSubDivJSON($distcode);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'subdiv_code' => $object->subdiv_code);
        }
        echo json_encode($json);
    }

    public function getCirCodeJson($distcode, $subdivcode) {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getCirCodeJSON($distcode, $subdivcode);

        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'cir_code' => $object->cir_code);
        }
        echo json_encode($json);
    }

    public function getMouzaJson($distcode, $subdivcode, $circode) {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getMouzaJSON($distcode, $subdivcode, $circode);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'mouza_pargona_code' => $object->mouza_pargona_code);
        }
        echo json_encode($json);
    }

    public function getLotNoJson($distcode, $subdivcode, $circode, $mouzacode) {
        if($distcode=='' || $subdivcode=='' || $circode=='' || $mouzacode=='') {
            $json[]=array('error'=>'Empty Input');
            echo json_encode($json);
            exit;
        }
        if(!preg_match('/^[0-9]*$/', $distcode) || !preg_match('/^[0-9]*$/', $subdivcode) || !preg_match('/^[0-9]*$/', $circode) || !preg_match('/^[0-9]*$/', $mouzacode)) {
            $json[]=array('error'=>'Invalid Input Request');
            echo json_encode($json);
            exit;
        }
        //authentication
        $sessionData = $this->session->all_userdata();
        if(empty($sessionData)) {
            $json[]=array('error'=>'User not Authenticated!');
            echo json_encode($json);
            exit;
        }
        $db =  $this->session->userdata('db');
        $data = $this->mutationmodel->getLotNoJson($distcode, $subdivcode, $circode, $mouzacode);

        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'lot_no' => $object->lot_no);
        }
        echo json_encode($json);
    }

    public function getVillageCodeJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno) {
        if($distcode=='' || $subdivcode=='' || $circode=='' || $mouzacode=='' || $lotno=='') {
            $json[]=array('error'=>'Empty Input');
            echo json_encode($json);
            exit;
        }
        if(!preg_match('/^[0-9]*$/', $distcode) || !preg_match('/^[0-9]*$/', $subdivcode) || !preg_match('/^[0-9]*$/', $circode) || !preg_match('/^[0-9]*$/', $mouzacode) || !preg_match('/^[0-9]*$/', $lotno)) {
            $json[]=array('error'=>'Invalid Input Request');
            echo json_encode($json);
            exit;
        }
        //authentication
        $sessionData = $this->session->all_userdata();
        if(empty($sessionData)) {
            $json[]=array('error'=>'User not Authenticated!');
            echo json_encode($json);
            exit;
        }
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getVillageCodeJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'vill_townprt_code' => $object->vill_townprt_code);
        }
        echo json_encode($json);
    }

     public function getVillageCodeFlaggedJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno) {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getVillageCodeFlaggedJSON($distcode, $subdivcode, $circode, $mouzacode, $lotno);
        $json = array();
        foreach ($data as $object) {
            if($object->nc_btad=='c')
            {
                $villtype='(চৰ)';
            }
            else if($object->nc_btad=='n')
            {
                $villtype='(NC)';
            }
            else if($object->nc_btad=='b')
            {
                $villtype='(BTAD)';
            }
            else if($object->nc_btad=='e')
            {
                $villtype='(ERODED/No Existence)';
            }
            else if($object->nc_btad=='s')
            {
                $villtype='(SHIFTED)';
            }
            else if($object->nc_btad=='d')
            {
                $villtype='(DUPLICATE)';
            }
            else{
                $villtype='NA';
            }
            $json[] = array('loc_name' => $object->loc_name, 'vill_townprt_code' => $object->vill_townprt_code, 'villtype'=>$villtype);
        }
        echo json_encode($json);
    }

    public function getPattanoJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code) {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getPattanoJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('patta_code' => trim($object->patta_no), 'patta_no' => trim($object->patta_no));
        }
        echo json_encode($json);
    }

    public function getMutationTypeJSON() {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getMutationType();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('order_type_code' => $object->order_type_code, 'order_type' => $object->order_type);
        }
        echo json_encode($json);
    }

    public function getTransferTypeJSON() {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getTransferType();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('trans_code' => $object->trans_code, 'trans_desc_as' => $object->trans_desc_as);
        }
        echo json_encode($json);
    }

    public function getLandAreaJSON($dag_no) {
        $db=  $this->session->userdata('db');
        $landarea = $this->mutationmodel->getLandArea($dag_no);
        echo json_encode($landarea);
    }

    public function getMutatedLandAreaJSON() {
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $mutatedlandArea = array(
            'bigha' => 0,
            'katha' => 0,
            'lessa' => 0
        );
        echo json_encode($mutatedlandArea);
    }

    public function saveFieldMutatonBasic($proceed = 0) {
        $db=  $this->session->userdata('db');
        if ($proceed == 0) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $mut_type = $this->input->post('mutation_type');
            $patta_no = trim($this->input->post('patta_no'));
            $this->session->set_userdata(array('patta_no' => $patta_no));
            $this->session->set_userdata(array('mut_type' => $mut_type));
            $rajah_adalat = $this->input->post('rajah_adalat');
            $trans_code = $this->input->post('transfer_type');
            $this->session->set_userdata(array('trans_code' => $trans_code));
            $add_of_name = $this->input->post('add_of_name');
            $possesion_yn = $this->input->post('possession_yn');
            $dispute_yn = $this->input->post('dispute_yn');
            $operation = $this->input->post('operation');
            $deed_value = $this->input->post('reg_deed_value');
            $reg_deed_date = date('Y-m-d', strtotime($this->input->post('reg_deed_date')));
            $add_of_desig = $this->input->post('add_of_desig');
            $reg_deed_no = $this->input->post('reg_deed_no');
            $patta_type = $this->input->post('patta_type');
            date_default_timezone_set('Asia/Kolkata');
            $report_date = $timestamp = date('Y-m-d G:i:s');
            $date_entry = $timestamp = date('Y-m-d G:i:s');
            $append = $this->append;
            $case_no=$year_no=null;
            // $petition_no = $this->db->query("select max(petition_no) as petition_no from  field_mut_basic where $this->append and petition_no is not null limit 1")->row()->petition_no;
            // if ($petition_no == null) {
            //     $petition_no = 1;
            // } else {
            //     $petition_no+=1;
            // }
            if ($deed_value == null) {
                $deed_value = 0;
            }

            // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('Y') : date('Y') . "-" . date('Y', strtotime('+1 year'));

             $case_name=$this->basundharamodel->genearteCaseName();
             $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteFieldPetitionNo();


            if ($mut_type == '01') {
                $case_no=$case_name.$petition_no."/FMUT";
            } else if ($mut_type == '02') {
                $case_no=$case_name.$petition_no."/FPART";
            }
            $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type' => $patta_type,
                'deed_reg_no' => $reg_deed_no, 'deed_value' => $deed_value, 'deed_date' => $reg_deed_date));
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'mut_type' => $mut_type,
                'rajah_adalat' => $rajah_adalat,
                'trans_code' => $trans_code,
                'add_off_name' => $add_of_name,
                'add_off_desig' => $add_of_desig,
                'possession_yn' => $possesion_yn,
                'dispute_yn' => $dispute_yn,
                'operation' => $operation,
                'deed_value' => $deed_value,
                'reg_deed_date' => $reg_deed_date,
                'add_off_desig' => $add_of_desig,
                'report_date' => $report_date,
                'date_entry' => $date_entry,
                'reg_deed_no' => $reg_deed_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'user_code' => $this->user_code,
                'operation' => 'E'
            );
            if($this->session->userdata('fmb')){
                $this->session->set_flashdata('message',"Error in Processing ! You might be trying from multiple session");
                redirect('/lmmutation/mutation');
            }else{
                $this->session->set_userdata('fmb', $data);
            }

            redirect(base_url() . "index.php/ChithaJamaCompare/compare/$patta_no");
            return;
        }
        redirect(base_url() . "index.php/lmmutation/isMultiple");
    }

    public function applicantDetails() {
        $db=  $this->session->userdata('db');
        $this->load->model('relation/relationmodel');
        $this->load->model('patta/pattamodel');
        $data['relation'] = $this->relationmodel->getRelations();
        $data["pdars"] = $this->pattamodel->getPattadarsByPattaNo1();
        if ($this->input->get('next')) {
            $data['disabled'] = false;
        } else {
            $data['disabled'] = true;
        }
        if ($this->input->get('hus_wife')) {
            $data['husband_wife'] = true;
        } else {
            $data['husband_wife'] = false;
        }
        $data['_view'] = 'lmmutation/applicantdetails';
        $this->load->view('layouts/main',$data);
    }

    public function saveApplicantDetails() {
        $db=  $this->session->userdata('db');
        $data = array();
        $applied_b = $this->input->post('applied_b');
        $applied_k = $this->input->post('applied_k');
        $applied_lc = $this->input->post('applied_lc');
        $hus_wife = $this->input->post('hus_wife');
        if ($this->session->userdata('applied_b')) {
            $applied_b += $this->session->userdata('applied_b');
            $this->session->set_userdata(array('applied_b' => $applied_b));
        } else {
            $this->session->set_userdata(array('applied_b' => $applied_b));
        }
        if ($this->session->userdata('applied_k')) {
            $applied_k += $this->session->userdata('applied_k');
            $this->session->set_userdata(array('applied_k' => $applied_k));
        } else {
            $this->session->set_userdata(array('applied_k' => $applied_k));
        }
        if ($this->session->userdata('applied_lc')) {
            $applied_lc += $this->session->userdata('applied_lc');
            $this->session->set_userdata(array('applied_lc' => $applied_lc));
        } else {
            $this->session->set_userdata(array('applied_lc' => $applied_lc));
        }
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $husband_wife = false;
        if ($hus_wife == 'h') {
            $husband_wife = true;
        }
        if (isset($data['copname'])) {
            $data['pdar_id'] = $data['copname'];
        }
        $location = $this->utilityclass->getLocationFromSession();
        $merged = array_merge($data, $location);
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        $petition = $this->db->query("select count(pet_id) as pet_id from  field_mut_petitioner where pet_id is not null and case_no='$case_no' limit 1")->result();
        $pet_id = $petition[0]->pet_id + 1;
        $report_date = $timestamp = date('Y-m-d G:i:s');
        $date_entry = $timestamp = date('Y-m-d G:i:s');
        $year_no = year_no;
        $otherdata = array(
            'case_no' => $case_no,
            'petition_no' => $petition_no,
            'year_no' => $year_no,
            'pet_id' => $pet_id,
            'user_code' => $this->user_code,
            'date_entry' => $date_entry,
            'operation' => 'E',
            'hus_wife' => $hus_wife
        );
        $merged = array_merge($otherdata, $merged);
        if (!$this->session->userdata('appdet')) {
            $this->session->set_userdata('appdet', array());
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
        } else {
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
        }
        if ($husband_wife == true)
            redirect(base_url() . "index.php/lmmutation/applicantdetails?hus_wife=$husband_wife");
        else
            redirect(base_url() . "index.php/lmmutation/addmoreapplicat");
    }

    public function addmoreapplicat() {
        $db=  $this->session->userdata('db');
        $data['_view'] = 'lmmutation/addmoreapplicant';
        $this->load->view('layouts/main',$data);
    }

    public function saveMutationDagDetails() {

        $db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationFromSession();
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $deed_date = $this->session->userdata('deed_date');
        $deed_value = $this->session->userdata('deed_value');
        $deed_reg_no = $this->session->userdata('deed_reg_no');
        $user_code = $this->user_code;
        $date_entry = date('Y-m-d G:i:s');
        $operation = 'E';
        $year_no = year_no;
        $data = array();
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $dag_no = $data['dag_no'];
        $this->session->set_userdata(array('dag_no' => $dag_no));
        $other = array('case_no' => $case_no, 'petition_no' => $petition_no,
            'patta_no' => $patta_no, 'patta_type_code' => $patta_type_code,
            'user_code' => $user_code, 'date_entry' => $date_entry, 'operation' => $operation,
            'deed_date' => $deed_date, 'deed_value' => $deed_value, 'deed_reg_no' => $deed_reg_no, 'year_no' => $year_no
        );
        $merged = array_merge($other, $location, $data);
        if (!$this->session->userdata('dag_det')) {
            $this->session->set_userdata('dag_det', array());
            $dagdet = $this->session->userdata('dag_det');
            $dagdet[] = $merged;
            $this->session->set_userdata('dag_det', $dagdet);
        } else {
            $dagdet = $this->session->userdata('dag_det');
            $dagdet[] = $merged;
            $this->session->set_userdata('dag_det', $dagdet);
        }
        echo json_encode($this->session->userdata('ismultiple'));
    }

    public function pattadarDetails() {
        if ($this->input->get('inc')) {
            if (!$this->session->userdata('start')) {
                $this->session->set_userdata(array('start' => 0));
            }
            $start = $this->session->userdata('start');
            $start++;
            $this->session->set_userdata(array('start' => $start));
        } else {
            
        }
        $dags = $this->session->userdata('dag_det');

        $in = array();
        foreach ($dags as $d) {
            $in[] = $d['dag_no'];
        }
        $pattadar_cron_no = 1;
        // var_dump($this->session->all_userdata());
        if ($this->input->get('cron_no') == null)
            $pattadar_cron_no = 1;
        else
            $pattadar_cron_no = $this->input->get('cron_no');
        $this->load->model('patta/PattaModel');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $data['mut_type'] = $this->session->userdata('mut_type');
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') >= $size) {
            $data['dag'] = -1;
            $data['_view'] = 'lmmutation/saveall';
            $this->load->view('layouts/main',$data);
            return;
        } else {
            $data['dag'] = $in[$this->session->userdata('start')];
        }
        if ($data['mut_type'] == '01') {
            $data['pattadars'] = $this->PattaModel->getPattadarFiltered($pattadar_cron_no, $in[$this->session->userdata('start')])->result();
        } else if ($data['mut_type'] == '02') {
            $data['pattadars'] = $this->PattaModel->getPattadarFilteredForPartition()->result();
        }
        $data['pattadar_cron_no'] = $pattadar_cron_no;
        $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
        if ($this->session->userdata('start') >= $size) {
            $data['dag'] = -1;
        } else {
            $data['dag'] = $in[$this->session->userdata('start')];
        }
        $data['_view'] = 'lmmutation/pattadardetails';
        $this->load->view('layouts/main',$data);
    }

    public function savePattadarDetails() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->input->post('current_dag');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');
        $inc = $this->input->post('inc');
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        unset($data['inc']);
        $cron_no = $data['pdar_cron_no'] + 1;
        // echo $cron_no;
        $date_entry = date('Y-m-d G:i:s');
        $user_code = $this->user_code;
        $operation = 'E';
        $striked_out = $this->input->post('striked_out');
        $year = year_no;
        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag_no)->result();
        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;
        ////var_dump($pdar_name);
        $other = array(
            'date_entry' => $date_entry,
            'user_code' => $user_code,
            'operation' => $operation,
            'striked_out' => $striked_out,
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );
        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('patdet')) {
            $this->session->set_userdata('patdet', array());
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        } else {
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        }
        $this->session->userdata('patdet');
        //if ($this->db->insert('field_mut_pattadar', $merged)) {
        $this->session->set_userdata(array('pattadar_next' => true));
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') >= $size) {
            redirect(base_url() . "index.php/lmmutation/pattadardetails?cron_no=$cron_no&e=true");
        } else {
            redirect(base_url() . "index.php/lmmutation/pattadardetails?cron_no=$cron_no");
        }
    }

    public function savePattadarDetails1() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->input->post('current_dag');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $cron_no = $data['pdar_cron_no'] + 1;
        //$cron_no;
        $date_entry = date('Y-m-d G:i:s');
        $user_code = $this->user_code;
        $operation = 'E';
        $striked_out = $this->input->post('striked_out');
        $year = date('Y');
        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag_no)->result();
        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;
        ////var_dump($pdar_name);
        $other = array(
            'date_entry' => $date_entry,
            'user_code' => $user_code,
            'operation' => $operation,
            'striked_out' => $striked_out,
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );
        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('patdet')) {
            $this->session->set_userdata('patdet', array());
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        } else {
            $appdet = $this->session->userdata('patdet');
            $appdet[] = $merged;
            $this->session->set_userdata('patdet', $appdet);
        }
        $this->session->userdata('patdet');
        //if ($this->db->insert('field_mut_pattadar', $merged)) {
        $this->session->set_userdata(array('pattadar_next' => true));
        $size = sizeof($this->session->userdata('dag_det'));
        if ($this->session->userdata('start') > ($size - 1)) {
            redirect(base_url() . "index.php/lmmutation/pattadardetails?cron_no=$cron_no&e=true");
        } else {
            redirect(base_url() . "index.php/lmmutation/pattadardetails?cron_no=$cron_no");
        }
    }

    public function getPattatypeJSON() {
        $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getPattatypeJSON();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
        }
        echo json_encode($json);
    }

    public function getPattatypeByNoJSON($patta_no) {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $json = array();
        $data = $this->mutationmodel->getPattatypeByNoJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no);
        foreach ($data as $object) {
            $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
        }
        echo json_encode($json);
    }

    public function savePattadarForPartition() {
        $db=  $this->session->userdata('db');
        $this->load->model('patta/pattamodel');
        $location = $this->utilityclass->getLocationFromSession();
        $case_no = $this->session->userdata('case_no');
        $dag_no = $this->session->userdata('dag_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $petition_no = $this->session->userdata('petition_no');
        /* loop over post array to get data from  the form */
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
        $dag = $this->session->userdata('dag_det');
        $cron_no = $data['pdar_cron_no'] + 1;
        $user_code = $this->user_code;
        $operation = 'E';
        $year = date('Y');
        $pdar_name = $this->pattamodel->getPattadarNameById($data['pdar_name'], $dag[0]['dag_no'])->result();
        $data['pdar_id'] = $data['pdar_name'];
        $data['pdar_name'] = $pdar_name[0]->pdar_name;
        $other = array(
            'date_entry' => date('Y-m-d G:i:s'),
            'user_code' => $user_code,
            'operation' => $operation,
            'date_entry' => date('Y-m-d G:i:s'),
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'petition_no' => $petition_no,
            'dag_no' => $dag_no,
            'year_no' => $year
        );
        $merged = array_merge($location, $data, $other);
        if (!$this->session->userdata('appdet')) {
            $this->session->set_userdata('appdet', array());
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
            $this->session->set_userdata('pdaridarray', array());
            $pdararray = $this->session->userdata('pdaridarray');
            $pdararray[] = $data['pdar_id'];
            $this->session->set_userdata('pdaridarray', $pdararray);
        } else {
            $appdet = $this->session->userdata('appdet');
            $appdet[] = $merged;
            $this->session->set_userdata('appdet', $appdet);
            $pdararray = $this->session->userdata('pdaridarray');
            $pdararray[] = $data['pdar_id'];
            $this->session->set_userdata('pdaridarray', $pdararray);
        }

        //if ($this->db->insert('field_part_petitioner', $merged)) {
        $this->session->set_userdata(array('pattadar_next' => true));
        redirect(base_url() . "index.php/lmmutation/pattadardetails?cron_no=$cron_no");
        //}
    }

    public function copattaddarConsent() {
        $db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $config['base_url'] = base_url() . '/index.php/lmmutation/copattaddarConsent/';
        $count_query = "select count(*) as c from  field_mut_basic where order_passed is null and "
                . "mut_type='02'  ";
        $config['total_rows'] = $this->db->query($count_query)->row()->c;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        //echo "select * from  field_mut_basic "
        //               . "where mut_type='02' and p_consent is null and order_passed is null and $this->append ";
        //  exit;
        //var_dump($this->session->all_userdata());
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $patitioncases['cases'] = $this->db->query("select * from  field_mut_basic "
                        . "where mut_type='02' and p_consent is null and order_passed is null and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and $this->append ")->result();
        //$this->load->view('../views/header');
        //$this->load->view('menu/menu4');
        //$this->load->view('../views/lmmutation/copattadarconsent', $patitioncases);

        $patitioncases['_view'] = 'lmmutation/copattadarconsent';
        //$this->load->view('../views/footer');
        $this->load->view('layouts/main',$patitioncases);
    }

    public function takeconsent() {
       // $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $_POST;
            $year_no = year_no;
            //print_r($data);
            $consent_pattadar = array();
             foreach ($data['pdar']['consentid'] as $consent) {
                $temp = array(
                    'id' => $consent,
                    'name' => $data['pdar']['id'][$consent],
                    'comment' => $data['pdar']['comment'][$consent],
                );
                array_push($consent_pattadar, $temp);
            }
            ////var_dump($consent_pattadar);
            foreach ($consent_pattadar as $pattadar) {
                $data = array(
                    'dist_code' => $data['dist_code'],
                    'subdiv_code' => $data['subdiv_code'],
                    'cir_code' => $data['cir_code'],
                    'mouza_pargona_code' => $data['mouza_pargona_code'],
                    'lot_no' => $data['lot_no'],
                    'vill_townprt_code' => $data['vill_townprt_code'],
                    'patta_no' => trim($data['patta_no']),
                    'patta_type_code' => $data['patta_type_code'],
                    'case_no' => $data['case_no'],
                    'copattadar_id' => $pattadar['id'],
                    'copattadar_name' => $pattadar['name'],
                    'copattadar_comment' => $pattadar['comment'],
                    'mut_type' => '02',
                    'entry_date' => date('Y-m-d G:i:s'),
                    'date_of_order' => date('Y-m-d G:i:s'),
                    'consent' => 'y'
                );
                ////var_dump($data);
                $this->db->insert('copattadar_consent', $data);
                $q = "Update field_mut_basic set p_consent='Y' where dist_code='$data[dist_code]' and case_no='$data[case_no]'  and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and year_no='$year_no' ";
                $this->db->query($q);
                //exit;
                $this->session->set_flashdata('message', 'Consent Update Successfully');
                redirect(base_url() . "index.php/home");
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $location = $this->db->query("select * from  field_part_petitioner where case_no='$case_no'")->row();
            //echo "select * from  field_part_petitioner where case_no='$case_no'";
            $q = "select * from  chitha_pattadar p join chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and "
                    . "p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code "
                    . "and p.pdar_id = d.pdar_id where p.dist_code='$location->dist_code' and p.subdiv_code='$location->subdiv_code' and p.cir_code='$location->cir_code' "
                    . "and p.mouza_pargona_code='$location->mouza_pargona_code' and p.vill_townprt_code='$location->vill_townprt_code' and d.lot_no='$location->lot_no' "
                    . "and d.dag_no='$location->dag_no' and TRIM(p.patta_no)=trim('$location->patta_no') and p.patta_type_code='$location->patta_type_code' "
                    . "and p.pdar_id not in (select pdar_id from  field_part_petitioner where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' "
                    . "and cir_code='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and vill_townprt_code='$location->vill_townprt_code' "
                    . "and lot_no='$location->lot_no' and dag_no='$location->dag_no' and TRIM(patta_no)=trim('$location->patta_no') and patta_type_code='$location->patta_type_code')";
            //echo $q;
            $data = $this->db->query($q)->result();
            //$this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $d['pdars'] = $data;
            $d['case_no'] = $case_no;
            $d['location'] = $location;
            $d['d_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".DEATH_CERTIFICATE."' AND case_no=?", array($case_no))->row();
            $d['noc_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOC."' AND case_no=?", array($case_no))->row();
            $d['nok_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOK_CONSENT."' AND case_no=?", array($case_no))->row();

            //var_dump($d);
           //$this->load->view('../views/lmmutation/takeconsent', $d);
           $d['_view'] = 'lmmutation/takeconsent';
           $this->load->view('layouts/main',$d);
        }
    }

    public function getPendingOfficeMutationCases() {
        $db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $append = $this->append;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $cases = $this->db->query("select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE lm_note_date is null and  "
                        . " not_fresh='Y' and sk_comment is null and order_passed is"
                        . " null and mut_type='03' and status='P' and $append  and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'  "
                        . "order by mut_type,Year_no,Petition_no ")->result();
        $data['cases'] = $cases;

        foreach($data['cases'] as $rows) {

            if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                // log_message('error', '#1141: From escalation_detail_table : '.json_encode($escRow)); 

                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 

                // log_message('error', '#1146: Escalation details : '.json_encode($escData)); 

                $rows->escalation_date = $escData->escalation_date;
                $rows->escalation_zone = $escData->escalation_zone;
                $rows->assigned_date   = $escData->assigned_date;
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'lmmutation/pendingofficecases';
        $this->load->view('layouts/main',$data);
    }

    public function getPendingOfficePartitionCasesOld() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $defined = define_date;
        $cases = $this->db->query("SELECT *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04'"
                        . " and not_fresh='Y' and status='P' and date(date_entry)>='$defined' and (lm_note_yn is null ) and (lm_note_date is null) and (fmb.is_pending!='Y' or fmb.is_pending is null) order by year_no,petition_no ")->result();
        $data['cases'] = $cases;
        $data['_view'] = 'partition/pendingofficecases';
        $this->load->view('layouts/main',$data);

    }

    public function getPendingOfficePartitionCases() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $defined = define_date;
        $cases = $this->db->query("SELECT fmb.case_no as c_no,ba.basundhara, 
                    ed.*,fmb.*  from petition_basic fmb 
                    left join basundhar_application ba on fmb.case_no=ba.dharitree  
                    left join escalation_details ed on fmb.case_no=ed.case_no  
                    WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and  
                    cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' 
                    and lot_no='$lot_no' and fmb.mut_type='04' and fmb.not_fresh='Y' and fmb.status='P' 
                    and date(fmb.date_entry)>='$defined' and (fmb.lm_note_yn is null ) 
                    and (fmb.lm_note_date is null) and (fmb.is_pending!='Y' or fmb.is_pending is null) 
                    order by fmb.year_no,fmb.petition_no ")->result();
        // log_message('error', '#1082 : '.$this->db->last_query());
        $data['cases'] = $cases;
        if(ESCALATION_ENABLE == 1)
        {
            foreach($data['cases'] as $rows) {

                if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){

                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                    // log_message('error', '#1089: From escalation_detail_table : '.json_encode($escRow)); 

                    if(!empty($escRow) && $escRow != null){
                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                        // log_message('error', '#1094: Escalation details : '.json_encode($escData)); 

                        if(!empty($escRow) && $escRow != null){
                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date   = $escData->assigned_date;
                        }
                        else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
        }
        

        $data['_view'] = 'partition/pendingofficecases';
        $this->load->view('layouts/main',$data);

    }

    // edited on 17/9/2015 
    public function getPendingOfficeByayPrakCases() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $define_date = define_date;
        $c_q = "SELECT *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and date_entry>='$define_date' and lot_no='$lot_no' and mut_type='04' and status='P'  and not_fresh='Y' "
                . "and byayprak_yn is null ";
        $cases = $this->db->query($c_q)->result();
        $data['cases'] = $cases;
        $data['_view'] = 'partition/pendingofficebyayprkcases';
        $this->load->view('layouts/main',$data);
    }

    // edited on 17/9/2015  bhrigu
    public function getPendingOfficeConversionCases() {
        $db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/lmmutation/'
                . 'getPendingOfficeConversionCases';
        $c_q = "SELECT count(*) as c from  Petition_basic WHERE lm_note_date is null and  not_fresh='Y'"
                . " and sk_comment is null and order_passed is"
                . " null and mut_type='01' ";
        $config['total_rows'] = $this->db->query($c_q)->row()->c;
        $config['per_page'] = 5;
        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        $config['page_query_string'] = TRUE;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $cases = $this->db->query("SELECT * from  Petition_basic WHERE lm_note_date is null and  "
                        . " not_fresh='Y' and sk_comment is null and order_passed is"
                        . " null and mut_type='01' "
                        . "order by mut_type,Year_no,Petition_no  limit $config[per_page] offset $page")->result();
        $data['cases'] = $cases;
        // $this->load->view('../views/header');
        // //$this->load->view('menu/menu4');
        // $this->load->view('../views/lmmutation/pendingofficecases', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'lmmutation/pendingofficecases';
        $this->load->view('layouts/main',$data);
    }

    public function writeOfficeReport() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
            if($_GET['case_no'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }

            $allowed = ['LM'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }

            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $query = "select * from  petition_basic where case_no='$case_no' and $this->append";
            $petition = $this->db->query($query)->row();
            $petition_no = $petition->petition_no;
            $dags_query = "select * from  petition_dag_details where petition_no=$petition_no and $this->append";
            //echo $dags_query;
            $dags = $this->db->query($dags_query)->row();
            $this->load->model('patta/PattaModel');

            if(MULTIGENERATION_ACTIVE == 1){
                $append = $this->append;
                if($petition->is_multigeneration == 'M' || $petition->is_multigeneration =='S'){
                    $this->writeLMreport($case_no,$append);
                    return;
                }
            }

            // Added by Abhijit -- 2024-04-24
            
            if($petition->is_multidag == 'Y'){
                return $this->writeLMReportMultiDag($case_no);
            }

            $petition_no = $petition->petition_no;
            $dags_query = "select * from  petition_dag_details where petition_no=$petition_no and $this->append";
            //echo $dags_query;
            $dags = $this->db->query($dags_query)->row();
            $this->load->model('patta/PattaModel');
            $pattadar_cron_no = 0;
            $data['pattadars'] = $this->PattaModel->getPattadarOffice($case_no)->result();
            if (sizeof($data['pattadars']) <= 0) {
                $this->session->set_flashdata("message", 
                "First Party Information not found for Case No." . $case_no . " It cause may an error in final order");
                redirect(base_url() . "index.php/home");
            }
            $data['pattadar_cron_no'] = 0;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            $data['dags'] = $dags;
            $data['petition'] = $petition;
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $data['basundharaAttachment'] = null;
            $data['query'] = null;

            $data['nok_temp']= $this->mutationmodel->NokTempData($case_no);
            $data['genders'] = $this->mutationmodel->getGenders();
            $data['relation'] = $this->relationmodel->getRelations();

            if($basundharaExist){
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            }
            if($petition->mut_type == '03' && $petition->deed_no == null)
            {
                $data['tranfer_type'] = $this->utilityclass->mutType('i');
            }
            elseif($petition->mut_type == '03' && $petition->deed_no != null)
            {
                $data['tranfer_type'] = $this->utilityclass->mutType('o');
            }


            //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $petition->es_flag == 1  && $petition->out_of_esc == 0)
            {
                $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
                $data['remainingTime'] = $remainingTime;
                $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
                if(isset($escRemarkData) && !empty($escRemarkData))
                {
                    $data['escRemarkData'] = $escRemarkData;
                }
            }
            ///END REMARKS/////////

            $data['_view'] = 'lmmutation/officereport';
            $this->load->view('layouts/main',$data);
        }
    }

    // Added by Abhijit -- 2024-04-24
    private function writeLMReportMultiDag($case_no){
        $data['case_no'] = $case_no;
        $query = "select * from  petition_basic where case_no='$case_no' and $this->append";
        $petition = $this->db->query($query)->row();
        
        $petition_no = $petition->petition_no;
        $dags_query = "select * from  petition_dag_details where petition_no=$petition_no and $this->append";
        //echo $dags_query;
        $dags = $this->db->query($dags_query)->result();
        
        $this->load->model('patta/PattaModel');
        $pattadar_cron_no = 0;
        $data['pattadars'] = $this->PattaModel->getPattadarOfficeMultiDag($case_no);
    
        if (sizeof($data['pattadars']) <= 0) {
            $this->session->set_flashdata("message", 
            "First Party Information not found for Case No." . $case_no . " It cause may an error in final order");
            redirect(base_url() . "index.php/home");
        }
        $data['pattadar_cron_no'] = 0;
        $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
        $data['dags'] = $dags;
        $data['petition'] = $petition;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $data['basundharaAttachment'] = null;
        $data['query'] = null;
        if($basundharaExist){
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }

        if($petition->mut_type == '03' && $petition->deed_no == null)
        {
            $data['tranfer_type'] = $this->utilityclass->mutType('i');
        }
        elseif($petition->mut_type == '03' && $petition->deed_no != null)
        {
            $data['tranfer_type'] = $this->utilityclass->mutType('0');
        }
        $data['_view'] = 'lmmutation/multi-dag-officereport';
        $this->load->view('layouts/main',$data);
    }

    public function writeLMreport($case_no,$append){
        $data['case_no'] = $case_no;
        $query = "select * from  petition_basic where case_no='$case_no' and $append";
        $petition = $this->db->query($query)->row();
        $petition_no = $petition->petition_no;
        $dags_query = "select * from  petition_dag_details where petition_no=$petition_no and $append";
        // echo $dags_query;
        // $dags = $this->db->query($dags_query)->row(); //old code 06022023---
        $dags = $this->db->query($dags_query)->result();
        //var_dump($dags);die;
        $this->load->model('patta/PattaModel');
        $pattadar_cron_no = 0;
        $data['pattadars'] = $this->PattaModel->getPattadarOfficeForMultiGen($case_no);

        if (sizeof($data['pattadars']) <= 0) {
            $this->session->set_flashdata("message", 
            "First Party Information not found for Case No." . $case_no . " It cause may an error in final order");
            redirect(base_url() . "index.php/home");
        }
        $data['pattadar_cron_no'] = 0;
        $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
        $data['dags'] = $dags;
        $data['petition'] = $petition;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $data['basundharaAttachment'] = null;
        $data['query'] = null;
        if($basundharaExist){
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }

        if($petition->mut_type == '03' && $petition->deed_no == null)
        {
            $data['tranfer_type'] = $this->utilityclass->mutType('i');
        }
        elseif($petition->mut_type == '03' && $petition->deed_no != null)
        {
            $data['tranfer_type'] = $this->utilityclass->mutType('0');
        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $petition->es_flag == 1)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        
        $data['_view'] = 'lmmutation/officereportlm';
        $this->load->view('layouts/main',$data);

    }

    public function freshReportAll() {
        $db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $query = "select * from  field_mut_basic where co_flag_for_fresh_mut='Y'";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;
        // $this->load->view('../views/header');
        // //$this->load->view('menu/menu4');
        // $this->load->view('../views/lmmutation/freshreportcases', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'lmmutation/freshreportcases';
        $this->load->view('layouts/main',$data);
    }

    public function freshReportStep1() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            foreach ($_POST as $key => $v) {
                $data[$key] = $v;
            }
            $this->session->set_userdata($data);
            redirect(base_url() . "index.php/lmmutation/freshReportStep2");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $this->session->set_userdata(array('case_no' => $case_no));
            $mutation['type'] = $this->mutationmodel->getMutatedLandAreaJSONType();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and cir_code = '$cir_code' ";
            $mutation['user'] = $this->db->query("select * from  users where " . $query_string)->result();
            $existingMutation = "select mut_type from  field_mut_basic where case_no='$case_no'";
            $existingAddressedTo = "select add_off_name from  field_mut_basic where case_no='$case_no'";
            $existingTransferType = "select trans_code from  field_mut_basic where case_no='$case_no'";
            $existingPattaType = "select patta_type_code from  field_mut_dag_details where case_no='$case_no'";
            $existingDesignation = "select add_off_desig from  field_mut_basic where case_no='$case_no'";
            $existingRegistration = "select deed_reg_no from  field_mut_dag_details where case_no='$case_no'";
            $existingDeedValue = "select deed_value from  field_mut_dag_details where case_no='$case_no'";
            $existingDeedDate = "select deed_date from  field_mut_dag_details where case_no='$case_no'";
            $existingReportDate = "select date_entry from  field_mut_basic where case_no='$case_no'";
            $existingPattaNo = "select patta_no from  field_mut_dag_details where case_no='$case_no'";
            $existingRajah = "select rajah_adalat from  field_mut_basic where case_no='$case_no'";
            $existingPossesion = "select possession_yn from  field_mut_basic where case_no='$case_no'";
            $existingDispute = "select dispute_yn from  field_mut_basic where case_no='$case_no'";
            $existingVillQ = "select vill_townprt_code from  field_mut_dag_details where case_no='$case_no'";
            $existingPattaNoQ = "select patta_no from  field_mut_dag_details where case_no='$case_no'";
            $existingDagQ = "select dag_no from  field_mut_dag_details where case_no='$case_no'";
            $existingPattaTypeQ = "select patta_type_code from  field_mut_dag_details where case_no='$case_no'";
            $mutation['emuttype'] = $this->db->query($existingMutation)->row()->mut_type;
            $mutation['eAddressedTo'] = $this->db->query($existingAddressedTo)->row()->add_off_name;
            $mutation['eTransferType'] = $this->db->query($existingTransferType)->row()->trans_code;
            $mutation['ePattaType'] = $this->db->query($existingPattaType)->row()->patta_type_code;
            $mutation['eDesignation'] = $this->db->query($existingDesignation)->row()->add_off_desig;
            $mutation['eRegistration'] = $this->db->query($existingRegistration)->row()->deed_reg_no;
            $mutation['eDeedValue'] = $this->db->query($existingDeedValue)->row()->deed_value;
            $mutation['eDeedDate'] = $this->db->query($existingDeedDate)->row()->deed_date;
            $mutation['eReportDate'] = $this->db->query($existingReportDate)->row()->date_entry;
            $mutation['ePattaNo'] = $this->db->query($existingPattaNo)->row()->patta_no;
            $mutation['eRajah'] = $this->db->query($existingRajah)->row()->rajah_adalat;
            $mutation['ePossesion'] = $this->db->query($existingPossesion)->row()->possession_yn;
            $mutation['eDispute'] = $this->db->query($existingDispute)->row()->dispute_yn;
            $existingVill = $this->db->query($existingVillQ)->row()->vill_townprt_code;
            $existingPattaNo = $this->db->query($existingPattaNoQ)->row()->patta_no;
            $existingDag = $this->db->query($existingDagQ)->row()->dag_no;
            $existingPattaType = $this->db->query($existingPattaTypeQ)->row()->patta_type_code;
            $this->session->set_userdata(array('vill_code' => $existingVill));
            $this->session->set_userdata(array('patta_no' => trim($existingPattaNo)));
            $this->session->set_userdata(array('patta_type_code' => trim($existingPattaNo)));
            $this->session->set_userdata(array('dag_no' => $existingDag));
            $this->session->set_userdata(array('mutation_type' => $mutation['emuttype']));
            // $this->load->view('../views/header');
            // //$this->load->view('menu/menu4');
            // $this->load->view('../views/lmmutation/mutationtypefresh', $mutation);
            // $this->load->view('../views/footer');

            $mutation['_view'] = 'lmmutation/mutationtypefresh';
            $this->load->view('layouts/main',$mutation);
        }
    }

    public function freshReportStep2() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->session->userdata('case_no');
            //echo $case_no;
            $apps = "select * from  field_mut_petitioner where case_no='$case_no'";
            $applicants = $this->db->query($apps)->result();
            $data['applicants'] = $applicants;
            // $this->load->view('../views/header');
            // //$this->load->view('menu/menu4');
            // $this->load->view('../views/lmmutation/applicantsfresh', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'lmmutation/applicantsfresh';
            $this->load->view('layouts/main',$data);
        }
    }

    public function saveFreshApplicants() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $main = $this->input->post('applicant');
            $applicants = array();
            $total_b = 0;
            $total_k = 0;
            $total_lc = 0;
            foreach ($main as $m) {
                //echo $m['name'];
                $applicants[] = array(
                    'pet_name' => $m['name'],
                    'guard_name' => $m['g'],
                    'guard_rel' => $m['r'],
                    'add1' => $m['a1'],
                    'add2' => $m['a2'],
                    'applied_b' => $m['b'],
                    'applied_k' => $m['k'],
                    'applied_lc' => $m['lc'],
                    'pet_id' => $m['pet_id'],
                );
                $total_b+=$m['b'];
                $total_k+=$m['k'];
                $total_lc+=$m['lc'];
            }
            $this->session->set_userdata(array('applicants' => $applicants));
            $this->session->set_userdata(array('total_b' => $total_b, 'total_k' => $total_k, 'total_lc' => $total_lc));
            redirect(base_url() . "index.php/lmmutation/landareafresh");
        }
    }

    public function landAreaFresh() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->session->userdata('case_no');
            //echo $case_no;
            $q = "select * from  field_mut_dag_details where case_no='$case_no'";
            //echo $q;
            $dags = $this->db->query($q)->row();
            $data['dag'] = $dags;
            $this->load->view('../views/header');
            //$this->load->view('menu/menu4');
            $this->load->view('../views/lmmutation/mutationlandareafreshtest', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            foreach ($_POST as $key => $v) {
                $data[$key] = $v;
            }
            $this->session->set_userdata(array('dag' => $data));
            redirect(base_url() . "index.php/lmmutation/pattadarDetailsFresh");
        }
    }

    public function pattadarDetailsFresh() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
            if ($this->session->userdata('pat_det')) {
                $pat_det = $this->session->userdata('pat_det');
                $pat_det[] = $data;
                $this->session->set_userdata(array('pat_det' => $pat_det));
            } else {
                $temp = array();
                $temp[] = $data;
                $this->session->set_userdata(array('pat_det' => $temp));
            }
            $case_no = $this->session->userdata('case_no');
            //var_dump($this->session->all_userdata());
            if ($this->input->post('pdar_cron_no') == null)
                $pattadar_cron_no = 1;
            else
                $pattadar_cron_no = $this->input->post('pdar_cron_no') + 1;
            $data['mut_type'] = $this->session->userdata('mutation_type');
            if ($data['mut_type'] == '01') {
                $q = "select * from  field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1";
                //echo $q;
                $num = $this->db->query("select * from  field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1")->num_rows();
                if ($num <= 0) {
                    echo 'finished';
                } else {
                    $data['pattadars'] = $this->db->query("select * from  field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no-1")->result();
                }
            } else if ($data['mut_type'] == '02') {
                $data['pattadars'] = $this->db->query("select * from  field_mut_pattadar where case_no='$case_no'")->result();
            }
            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            // //var_dump($data['pattadars']);
            // $this->load->view('../views/header');
            // //$this->load->view('menu/menu4');
            // $this->load->view('../views/lmmutation/pattadardetailsfresh', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'lmmutation/pattadardetailsfresh';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $pattadar_cron_no = 1;
            $case_no = $this->session->userdata('case_no');
            if ($this->input->get('cron_no') == null)
                $pattadar_cron_no = 1;
            else
                $pattadar_cron_no = $this->input->get('cron_no');
            $data['mut_type'] = $this->session->userdata('mutation_type');
            // echo $data['mut_type'];
            if ($data['mut_type'] == '01') {
                $data['pattadars'] = $this->db->query("select * from  field_mut_pattadar where case_no='$case_no' offset $pattadar_cron_no -1")->result();
            } else if ($data['mut_type'] == '02') {
                $data['pattadars'] = $this->db->query("select * from  field_mut_pattadar where case_no='$case_no'")->result();
            }
            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            // //var_dump($data['pattadars']);
            // $this->load->view('../views/header');
            // //$this->load->view('menu/menu4');
            // $this->load->view('../views/lmmutation/pattadardetailsfresh', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'lmmutation/pattadardetailsfresh';
            $this->load->view('layouts/main',$data);
        }
    }

    public function savelAllFresh() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $basic_data = array(
            'user_code' => $this->session->userdata('user_code'),
            'case_no' => $this->session->userdata('case_no'),
            'trans_code' => $this->session->userdata('transfer_type'),
            'add_off_name' => $this->session->userdata('add_of_name'),
            'add_off_desig' => $this->session->userdata('add_of_desig'),
            'reg_deed_no' => $this->session->userdata('reg_deed_no'),
            'deed_value' => $this->session->userdata('reg_deed_value'),
            'reg_deed_date' => $this->session->userdata('reg_deed_date'),
            'report_date' => $this->session->userdata('report_date'),
            'rajah_adalat' => $this->session->userdata('rajah_adalat'),
            'possession_yn' => $this->session->userdata('possession_yn'),
            'mut_type' => $this->session->userdata('mutation_type'),
            ''
        );
        $this->db->where('case_no', $this->session->userdata('case_no'));
        $this->db->update('field_mut_basic', $basic_data);
        $pet_data = $this->session->userdata('applicants');
        foreach ($pet_data as $pet) {
            $petD = array(
                'pet_name' => $pet['pet_name'],
                'guard_name' => $pet['guard_name'],
                'guard_rel' => $pet['guard_rel'],
                'add1' => $pet['add1'],
                'add2' => $pet['add2'],
                'applied_b' => $pet['applied_b'],
                'applied_k' => $pet['applied_k'],
                'applied_lc' => $pet['applied_lc'],
                'pet_id' => $pet['pet_id']
            );
            $this->db->where('case_no', $this->session->userdata('case_no'));
            $this->db->update('field_mut_petitioner', $petD);
        }
        $pat_data = $this->session->userdata('pat_det');
        foreach ($pat_data as $pat) {
            //var_dump($pat);
            $patD = array(
                'pdar_cron_no' => $pat['pdar_cron_no'],
                'pdar_id' => $pat['pdar_id'],
                'pdar_name' => $pat['pdar_name'],
                'striked_out' => $pat['striked_out'],
                'pdar_guardian' => $pat['pdar_guardian'],
                'pdar_rel_guar' => $pat['pdar_rel_guar'],
                'pdar_add1' => $pat['pdar_add1'],
                'pdar_add2' => $pat['pdar_add2'],
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E'
            );
            $this->db->where(array('case_no' => $this->session->userdata('case_no'), 'pdar_id' => $pat['pdar_id'], 'pdar_cron_no' => $pat['pdar_cron_no']));
            $this->db->update('field_mut_pattadar', $patD);
        }
        $dat_det = $this->session->userdata('dag');
        $dagData = array(
            'dag_no' => $dat_det['dag_no'],
            'dag_area_b' => $dat_det['dag_area_b'],
            'dag_area_k' => $dat_det['dag_area_k'],
            'dag_area_lc' => $dat_det['dag_area_lc'],
            'dag_area_g' => $dat_det['dag_area_g'],
            'dag_area_kr' => $dat_det['dag_area_kr'],
            'm_dag_area_b' => $dat_det['m_dag_area_b'],
            'm_dag_area_k' => $dat_det['m_dag_area_k'],
            'm_dag_area_lc' => $dat_det['m_dag_area_lc'],
            'm_dag_area_g' => $dat_det['m_dag_area_lc'],
            'm_dag_area_kr' => $dat_det['m_dag_area_kr'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E'
        );
        $this->db->where(array('case_no' => $this->session->userdata('case_no'), 'dag_no' => $dat_det['dag_no']));
        $this->db->update('field_mut_dag_details', $dagData);
    }

    public function saveAll() {
        $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $fmb = $this->session->userdata('fmb');
        $dag_det = $this->session->userdata('dag_det');
        $appdet = $this->session->userdata('appdet');
        $patdet = $this->session->userdata('patdet');
        $mut = $this->session->userdata('mut_type');
        $casetype = "";
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = CHANGE_DATE;

        $case_name=$this->basundharamodel->genearteCaseName();
        $case_no['petition_no']=$petition_no_new=$this->basundharamodel->genearteFieldPetitionNo();
        $case_no = 0;
        if ($mut == '01') {
            $case_no=$case_name.$petition_no_new."/FMUT";
        } else if ($mut == '02') {
            $case_no=$case_name.$petition_no_new."/FPART";
        }
        $amount_fees = $this->db->query("select order_amount as amount from  master_fees_mut_type where order_type_code = '$mut'")->row()->amount;
        
        $fmb['fee_collection '] = $amount_fees;
        $fmb['case_no'] = $case_no;
        $fmb['year_no'] = year_no;
        $fmb['petition_no'] = $petition_no_new;
    //var_dump($fmb);
        $this->db->insert("field_mut_basic", $fmb); //************************************************************************************************ insert query
        if ($mut == '01') {
            $pet_id = 1;
            $fmp = 0;
            foreach ($appdet as $app) {
                $app['case_no'] = $case_no;
                $app['year_no'] = $year_no;
                $app['pet_id'] = $pet_id++;
                //echo $petition_no_new;
                $app['petition_no'] = $petition_no_new;
                if ($app['pet_minor_yn'] == 'N') {
                    unset($app['pet_minor_dob']);
                } else {
                    $app['pet_minor_dob'] = date('Y-m-d', strtotime($app['pet_minor_dob']));
                }
                if (isset($app['co_pattadar'])) {
                    $app['pdar_id'] = $app['copname'];
                    $app['new_pet_name'] = null;
                    unset($app['co_pattadar']);
                    unset($app['copname']);
                } else {
                    $app['new_pet_name'] = 'N';
                    unset($app['co_pattadar']);
                    unset($app['copname']);
                    $app['pdar_id'] = null;
                }
                //var_dump($app);
                
                $fmp=$this->db->insert("field_mut_petitioner", $app); 
                
                //************************************************************************************************ insert query
            }
            if($fmp!=1){
                   $this->db->trans_rollback();
                   $this->session->set_flashdata("message", "Case Cannot Be Registered. Missing First Party Details");
                   redirect(base_url() . "index.php/home");
                }
        } else if ($mut == '02') {
            $fpp=0;
            foreach ($appdet as $app) {
                $app['case_no'] = $case_no;
                $app['year_no'] = year_no;
                $app['petition_no'] = $petition_no_new;
//                unset($app['pet_id']);
                unset($app['hus_wife']);
                unset($app['current_dag']);
                //var_dump($app);
                
                $fpp=$this->db->insert("field_part_petitioner", $app);
                
                 //************************************************************************************************ insert query
            }
            if($fpp!=1){
               $this->db->trans_rollback();
               $this->session->set_flashdata("message", "Case Cannot Be Registered. Missing Second Party Details");
               redirect(base_url() . "index.php/home");
            }
        }
        //$dag_det['case_no'] = $case_no;
        if (isset($dag_det['min_revenue'])) {
            $this->db->query("update field_mut_basic set min_revenue=$dag_det[min_revenue] where case_no='$case_no'"); //************************
        }
        $fmd=0;
        foreach ($dag_det as $d) {
            if (isset($d['min_revenue'])) {
                $this->db->query("update field_mut_basic set min_revenue=$d[min_revenue] where case_no='$case_no'"); //************************
            } else {
                unset($dag_det['min_revenue']);
            }
            $d['case_no'] = $case_no;
            $d['m_dag_area_g'] = 0.0;
            $d['m_dag_area_kr'] = 0.0;
            $d['petition_no'] = $petition_no_new;
            unset($d['current_dag']);
            unset($d['min_revenue']);
            $fmd=$this->db->insert("field_mut_dag_details", $d); //************************************************************************************************ insert query
        }
        if($fmd!=1){
               $this->db->trans_rollback();
               $this->session->set_flashdata("message", "Case Cannot Be Registered. Missing dag Details");
               redirect(base_url() . "index.php/home");
            }
        if ($mut == '01') {
            $mut_state = 0;
            foreach ($patdet as $pat) {
                $pat['case_no'] = $case_no;
                $pat['petition_no'] = $petition_no_new;
                unset($pat['current_dag']);
                
                $mut_state=$this->db->insert("field_mut_pattadar", $pat); //************************************************************************************************ insert query
            }
            if ($mut_state != 1)
            {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata("message", "Case Cannot Be Registered. Missing Second Party Details");
                   redirect(base_url() . "index.php/home");
            }
        }

        

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
            $this->session->unset_userdata('appdet');
            $this->session->unset_userdata('dagdet');
            $this->session->unset_userdata('patdet');
            $this->session->unset_userdata('fmb');

            $this->Dashboard($case_no);

            // $this->load->view('../views/header');
            // $this->load->view('../views/lmmutation/applicant_receipet', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'lmmutation/applicant_receipet';
            $this->load->view('layouts/main',$data);

            $this->session->set_userdata(array('case_no' => $case_no));
            redirect(base_url() . "index.php/lmmutation/applicant_receipet");
        }
    }

    public function applicant_receipet() {
        $db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from  field_mut_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();

        $mutation_type_name = $this->db->query("select order_type as mut_name from  master_field_mut_type where order_type_code = '$result->mut_type'")->row()->mut_name;
        $mut_type = $result->mut_type;

        if ($mut_type == '02') {// if it is partition case
            $applicant_name = $this->db->query("select * from  field_part_petitioner where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                            . "case_no = '$case_no' and petition_no='$result->petition_no'")->result();
        } else {
            $applicant_name = $this->db->query("select * from  field_mut_petitioner where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                            . "case_no = '$case_no' and petition_no='$result->petition_no'")->result();
        }

        //var_dump($data);
        $amount_fees = $this->db->query("select order_amount as amount from  master_fees_mut_type where order_type_code = '$result->mut_type'")->row()->amount;
        $data = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
            'applicant_name' => $applicant_name
        );
        //var_dump($data);

        // $this->load->view('../views/header');
        // $this->load->view('../views/lmmutation/applicant_receipet', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'lmmutation/applicant_receipet';
        $this->load->view('layouts/main',$data);
    }

    public function canClose() {
        if (($this->session->userdata('end') != null) || ($this->session->userdata('end') != true)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function showInplaceAlongwith() {
        $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $pattadar_cron_no = 1;
            $case_no = $this->input->get('case_no');
            // //var_dump($this->session->all_userdata());
            if ($this->input->get('cron_no') == null)
                $pattadar_cron_no = 0;
            else
                $pattadar_cron_no = 0;
            $this->load->model('patta/PattaModel');
            $data['pattadars'] = $this->PattaModel->getPattadarOffice($case_no, $pattadar_cron_no)->result();
            if (sizeof($data['pattadars']) <= 0) {
                $this->session->set_flashdata("message", 
                "First Party Information not found for Case No." . $case_no . " It cause may an error in final order");
                redirect(base_url() . "index.php/home");
            }
            $data['pattadar_cron_no'] = $pattadar_cron_no;
            $data['pattadar_next'] = $this->session->userdata('pattadar_next') ? true : false;
            $data['case_no'] = $case_no;
            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/lmmutation/pattadardetailsoffice', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'lmmutation/pattadardetailsoffice';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
           // echo "hi"; die;
            $pattadar_cron_no = $this->input->post('pdar_cron_no');
            $pattadar_cron_no++;
            $case_no = $this->input->post('case_no');
            $pdar_id = $this->input->post('pdar_name');
            $petition_no = $this->db->query("select petition_no from  petition_basic where case_no='$case_no'")->row()->petition_no;
            $striked_out = $this->input->post('striked_out');
            if ($striked_out == '1') {
                $query = "update petition_pattadar set striked_out ='1' where"
                        . " petition_no=$petition_no and pdar_id=$pdar_id and $this->base_query";
            } else if ($striked_out == '0') {
                $query = "update petition_pattadar set striked_out ='0' "
                        . "where petition_no=$petition_no and pdar_id=$pdar_id and $this->base_query";
            }
            $this->db->query($query);
            $this->session->set_flashdata("message", "LM Report for Office Mutation Case No." . $case_no . " recorded");
            // //var_dump($_POST);
            redirect(base_url() . "index.php/lmmutation/showInplaceAlongwith?case_no=$case_no&cron_no=$pattadar_cron_no");
        }
    }

    public function getPattadarInformaton($pid) {
        $db=  $this->session->userdata('db');
        $pattaNo = trim($this->session->userdata('patta_no'));
        $pattaType = $this->session->userdata('patta_type');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $query = "select  pdar_name, pdar_father,pdar_add1,pdar_add2,pdar_gender,pdar_mother,pdar_minor_yn,pdar_minor_dob,pdar_guard_reln "
                . "from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no'  and TRIM(p.patta_no)=TRIM('$pattaNo') and p.pdar_id='$pid' 
            and p.patta_type_code='$pattaType'";
        $data = $this->db->query($query)->row();
        echo json_encode($data);
    }
    
    public function getPattadarInformatonSara($pid,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$pattaNo,$pattaType) {
        $db=  $this->session->userdata('db');
        
        $query = "select  pdar_name, pdar_father,pdar_add1,pdar_add2,pdar_gender,pdar_mother,pdar_minor_yn,pdar_minor_dob,pdar_guard_reln "
                . "from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no'  and TRIM(p.patta_no)=TRIM('$pattaNo') and p.pdar_id='$pid' 
            and p.patta_type_code='$pattaType'";
        $data = $this->db->query($query)->row();
        echo json_encode($data);
    }

    public function pendingmaps() {
        $db=  $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $append = $this->append;
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $defined = define_date;
            $cases = $this->db->query("SELECT * from  chitha_col8_order WHERE map_partition is null and order_type_code='02' and case_no != '' and "
                            . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                            . " and lot_no='$lot_no' and date(co_ord_date)>='$defined' "
                            . " order by case_no")->result();
         
            $data['cases'] = $cases;
            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/lmmutation/pendingmaps', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'lmmutation/pendingmaps';
            $this->load->view('layouts/main',$data);
        }
    }

    public function Suomotodeed() {
        $db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $q = "Select * from   sro_note where dist_code='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and status='1' and nature_of_land = 'r'";
        $data['sronote'] = $this->db->query($q)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/lmmutation/suomotodeed', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'lmmutation/suomotodeed';
        $this->load->view('layouts/main',$data);
    }

    public function RegisterSuomoto() {
        $db=  $this->session->userdata('db');
        $mutation = array();
        //$this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $deed_no = $this->input->get('deed');
        $mutation['transfertype'] = $this->getTransferType();
        $q = "Select * from  sro_note where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='1'  and deed_no='$deed_no' ";
        $data = $mutation['deeddata'] = $this->db->query($q)->row();
        $location = array(
            'dist_code' => $data->dist_code, 'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code, 'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no, 'vill_code' => $data->vill_townprt_code
        );
        $this->session->set_userdata($location);

        $sq = "select * from  loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and priv='adm' ";
        $users = $this->db->query($sq)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code = '$cir_code' and user_code='$u->user_code' ";
            $mutation['user'] = $this->db->query("select * from  users where " . $query_string)->result();
        }
        
        $mutation['get_transfer_type'] = $this->db->query("Select * from  nature_trans_code")->result();
        
        // $this->load->view('../views/lmmutation/deedmutationtype', $mutation);
        // $this->load->view('../views/footer');

        $mutation['_view'] = 'lmmutation/deedmutationtype';
        $this->load->view('layouts/main',$mutation);
    }

    public function getTransferType() {
        $this->load->model('mutation/mutationmodel');
        $data = $this->mutationmodel->getTransferType();
        return $data;
    }

    public function mapupdate() {
        $db=  $this->session->userdata('db');
        $append = $this->append;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $defined_date = define_date;
        $case_no = $this->input->get('case_no');
        $query = "update t_chitha_col8_order set map_partition='Y' where dist_code='$dist_code' and "
                . "cir_code='$cir_code' and subdiv_code='$subdiv_code' and case_no="
                . "'$case_no' and order_type_code='02'";
        //echo $query;          
        $this->db->query($query);
        $query = "update chitha_col8_order set map_partition='Y' where dist_code='$dist_code' and "
                . "cir_code='$cir_code' and subdiv_code='$subdiv_code' and case_no="
                . "'$case_no' and order_type_code='02'";
       // echo $query;
        $this->db->query($query);
        $this->session->set_flashdata(array('message' => 'Map update for Partition. CO can update Chitha JamaBandi'));
        redirect(base_url() . "index.php/lmmutation/pendingmaps");
    }


    function Dashboard($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select * from field_mut_basic fmb left join field_mut_dag_details fmd on fmb.case_no=fmd.case_no where fmb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='01'){
            $type='FM';
        }else{
            $type='FP';
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'SK',
              'case_type' =>$type,
              'date_of_insert'=>date("Y-m-d h:i:s")
            );
        
        $sql="Select pet_name,guard_name,guard_rel from field_mut_petitioner where case_no='$case_no' ";
        $petitioner=$this->db->query($sql)->result();
        foreach ($petitioner as $key => $value) {
            $applicant= array(
                'case_no' => $case_no,
                'applicant_name' => $value->pet_name,
                'guardian_name' => $value->guard_name,
                'gender' => $value->guard_rel );
            $this->dbb->insert('dashboard_applicant',$applicant);
        }

        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
        return;

        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'ip_address'=>$this->utilityclass->get_client_ip(),
            'remark' => 'Registered By Lot Mondal'
             );
        $this->dbb->insert('dashboard_action',$action);
        $this->db->insert('dashboard_action',$action);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
             $this->dbb->insert('dashboard_data',$base);
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

                    $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                    if ($ip == true)
                    return;

                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date("Y-m-d h:i:s"),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => $rmrk,
                        'ip_address'=>$this->utilityclass->get_client_ip()
                         );
                    $this->dbb->insert('dashboard_action',$action);
                    $this->db->insert('dashboard_action',$action);

                    $this->db->where('case_no',$case_no);

                    $this->db->update('dashboard_data',$base);
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

                        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
                        if ($ip == true)
                        return;

                        $action= array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_of_action_taken' => date("Y-m-d h:i:s"),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => 'Final Order Passed',
                             );
                        $this->dbb->insert('dashboard_action',$action);

                        $this->db->where('case_no',$case_no);

                        $this->db->update('dashboard_data',$base);
                /////////////////////////////////////
        }

    function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'R',
                            'remark'=>'Case Rejected',
                            'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date("Y-m-d h:i:s"),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
            }
    function PortTchitha(){
        //$sql="Select * from chitha_col8_order where order_type_code='02' and date_entry>='2017-04-02'";
        $sql="Select pb.submission_date,pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.vill_townprt_code,pb.case_no,chitha_rmk_ordbasic.ord_date from petition_basic pb join chitha_rmk_ordbasic on pb.case_no=chitha_rmk_ordbasic.case_no where chitha_rmk_ordbasic.ord_type_code='03' and pb.submission_date>='2017-04-02'";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
            $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['submission_date'],
                      'status' =>'F',
                      'pending_with_user' =>'NA',
                      'case_type' =>'OM',
                      'final_order_date'=>$data['ord_date']
                    );
                //var_dump($base);
                $this->db->insert('dashboard_data',$base);
        }
    }


    function portFieldCase(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $date_entry=define_date;
        $i=1;
        $sql="Select * from field_mut_basic fmb where fmb.date_entry>='2017-02-15' and mut_type='01'  ";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
            
        $i=$i+1;
                // if($data['mut_type']=='01'){
                //     $type='FM';
                //     //$sql="Select pet_name,guard_name,guard_rel from field_mut_petitioner where case_no='$data[case_no]' ";
                // }else{
                //     $type='FP';
                //     // $sql="Select pdar_name as pet_name,pdar_guardian  as guard_name,pdar_rel_guar as guard_rel from field_part_petitioner where case_no='$data[case_no]' ";
                // }
                
                
               
                
                $status='P';
                $pending_with_user='CO';
                $if_dispose_date=null;
                if($data['sk_note']){
                    $status='P';
                    $pending_with_user='CO';
                }

                if($data['order_passed']!=null){
                    $status='F';
                    $pending_with_user='NA';
                    $if_dispose_date=$data['date_of_order'];
                }

                if($data['order_passed']==null and $data['sk_note']!=null){
                    $status='P';
                    $pending_with_user='CO';
                }
                if($data['is_dispose']!=null and $data['order_passed']!=null){
                    $status='F';
                    $pending_with_user='NA';
                    $if_dispose_date=$data['if_dispose_date'];
                }
                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      'status' =>$status,
                      'pending_with_user' =>$pending_with_user,
                      'case_type' =>'FM',
                      'final_order_date'=>$if_dispose_date
                    );
                //var_dump($base);
                $this->db->insert('dashboard_data',$base);
            }
            echo "Ported Records." . $i;
        }


         function portFieldCasePendingPart(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $date_entry=define_date;
        $i=1;
        $sql="Select * from field_mut_basic fmb where fmb.date_entry>='2017-02-15' and mut_type='02' and order_passed is null  ";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
            
        $i=$i+1;
                // if($data['mut_type']=='01'){
                //     $type='FM';
                //     //$sql="Select pet_name,guard_name,guard_rel from field_mut_petitioner where case_no='$data[case_no]' ";
                // }else{
                //     $type='FP';
                //     // $sql="Select pdar_name as pet_name,pdar_guardian  as guard_name,pdar_rel_guar as guard_rel from field_part_petitioner where case_no='$data[case_no]' ";
                // }
                
                
               
                
                $status='P';
                $pending_with_user='CO';
                $if_dispose_date=null;
                if($data['sk_note']){
                    $status='P';
                    $pending_with_user='CO';
                }

                if($data['order_passed']!=null){
                    $status='F';
                    $pending_with_user='NA';
                    $if_dispose_date=$data['date_of_order'];
                }

                if($data['order_passed']==null and $data['sk_note']!=null){
                    $status='P';
                    $pending_with_user='CO';
                }
                if($data['is_dispose']!=null and $data['order_passed']!=null){
                    $status='F';
                    $pending_with_user='NA';
                    $if_dispose_date=$data['if_dispose_date'];
                }
                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      'status' =>$status,
                      'pending_with_user' =>$pending_with_user,
                      'case_type' =>'FP',
                      'final_order_date'=>$if_dispose_date
                    );
                //var_dump($base);
                $this->db->insert('dashboard_data',$base);
            }
            echo "Ported Records." . $i;
        }
        
        ///////////////// Office Mutation case port
        function portOfficeCase(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $i=1;
        $pending_status=null;
        $sql="Select * from petition_basic pb where  pb.mut_type='03' and pb.status!='F' and pb.date_entry>='2017-02-15' ";//and (pb.status='P' or pb.not_fresh is null or pb.status!='B') ";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
                $this->dbb = $this->load->database('dash', TRUE);
                $i=$i+1;
                if($data['mut_type']=='03'){
                    $type='OM';
                    // $sql="Select pet_name,guard_name,guard_rel from petitioner where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                    // . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and petition_no='$data[petition_no]'  ";
                }else{
                   
                }
                
                if($data['not_fresh']==null){
                    $pending_status='CO';
                    $data['status']='P';
                        
                }
                
                if($data['notice_generated_yn']==null and $data['not_fresh']=='Y'){
                        $pending_status='AST';   
                }
                if($data['proceeding_yn']==null and $data['not_fresh']=='Y' and $data['notice_generated_yn']!=null){
                    $pending_status='AST';
                }
                if($data['lm_note_yn']==null and $data['not_fresh']=='Y' and $data['notice_generated_yn']!=null){
                        $pending_status='LM';
                }
                if($data['sk_comment']==null and $data['not_fresh']=='Y' and $data['lm_note_yn']!=null){
                    $pending_status='SK';    
                }
                if($data['sk_comment']!=null and $data['proceeding_yn']!=null and $data['lm_note_yn']!=null and $data['notice_generated_yn']!=null){
                    $pending_status='CO';    
                }

                
                
                
                if($data['status']=='F'){
                    $pending_status='F';
                        
                }
                if($data['status']=='D'){
                    $pending_status='NA';
                    $data['status']='F';
                }
                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      //'dag_no'=>$data['dag_no'],
                      //'patta_type_code' =>$data['patta_type_code'],
                      //'patta_no' =>$data['patta_no'],
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>$type,
                    );
                //exit;
               // var_dump($base);
               $this->db->insert('dashboard_data',$base);
                
                }
                 echo "Ported Records." . $i;
            }
            
//             ///////////////// Office Partition case port
//         function portPartOfficeCase(){
//         ini_set('memory_limit', '-1');
//         set_time_limit(0);
//         $i=1;
//         $pending_status=null;
//         $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
//             where  pb.mut_type='04' and pb.date_entry>='2017-02-15' and pb.date_entry>='2017-02-15' ";//and (pb.status='P' or pb.not_fresh is null or pb.status!='B') ";
//         $variable=$this->db->query($sql)->result_array();
//         foreach ($variable as $key => $data) {
//                 $this->dbb = $this->load->database('dash', TRUE);
//                 $i=$i+1;
//                 if($data['mut_type']=='04'){
//                     $type='OP';
//                     // $sql="Select pdar_name as pet_name,pdar_guardian as guard_name,pdar_rel_guar as guard_rel from petitioner_part where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
//                     // . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and petition_no='$data[petition_no]'  ";
//                 }
//                 //var_dump($data);
//                 if($data['not_fresh']==null){
//                     $pending_status='CO';
//                     $data['status']='P';
                
//                 }


//                 if($data['notice_generated_yn']==null and $data['not_fresh']=='Y'){
//                         $pending_status='AST';   
//                 }
//                 if($data['byayprak_yn']==null and $data['not_fresh']=='Y'){
//                         $pending_status='LM';    
//                 }
//                 if($data['lm_note_yn']==null and $data['not_fresh']=='Y'){
//                         $pending_status='LM';
//                 }
//                 if($data['sk_comment']==null and $data['not_fresh']=='Y'){
//                     $pending_status='SK';    
//                 }
//                 if($data['pay_notice_gen_yn']==null and $data['byayprak_yn']!=null){
//                     $pending_status='AST';     
//                 }
//                 if($data['proceeding_yn']==null and $data['not_fresh']=='Y'){
//                     $pending_status='AST';
//                 }else{
//                     $pending_status='CO';
//                 }
                
                
//                 if($data['status']=='F'){
//                     $pending_status='F';
                        
//                 }
//                 if($data['status']=='D'){
//                     $pending_status='NA';
//                     $data['status']='F';
//                 }

//                 $base= array(
//                       'dist_code'=> $data['dist_code'],
//                       'subdiv_code' =>$data['subdiv_code'],
//                       'cir_code'=>$data['cir_code'],
//                       'mouza_pargona_code'=>$data['mouza_pargona_code'],
//                       'lot_no'=>$data['lot_no'],
//                       'vill_townprt_code'=>$data['vill_townprt_code'],
//                       'case_no'=>$data['case_no'],
//                       'date_of_reg'=>$data['date_entry'],
//                       'dag_no'=>$data['dag_no'],
//                       'patta_type_code' =>$data['patta_type_code'],
//                       'patta_no' =>$data['patta_no'],
//                       'status' =>$data['status'],
//                       'pending_with_user' =>$pending_status,
//                       'case_type' =>$type,
//                     );
//                 //exit;
//                 //var_dump($base);
//                 $this->db->insert('dashboard_data',$base);
                
                
//                 }
//                  echo "Ported Records." . $i;
//             }
        
//         //////////////Port Certificate Cases//////////////////////
        function citizenCert(){
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            $i=1;
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.cert_no as case_no,pb.status,pb.date_entry,pb.user_code,pb.comment_date from cert_application pb where pb.date_entry>='2017-02-15'  ";
            $variable=$this->db->query($sql)->result_array();
            foreach ($variable as $key => $data) {
                
            
                
                $i=$i+1;
                //$pending_status='CO';
                if($data['status']=='M'){
                    $data['status']='P';
                    $pending_status='LM'; 
                    
                }elseif($data['status']=='C'){
                    $pending_status='CO';
                    $data['status']='P';
                    
                }elseif($data['status']=='R'){
                    $pending_status='AST';
                    $data['status']='P';
                     
                }elseif($data['status']=='D'){
                    $pending_status='NA';
                    $data['status']='F';
                         
                }else{
                    $pending_status='NA';
                    $data['status']='F';
                }


            
                    $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      // 'dag_no'=>'NA',
                      // 'patta_type_code' =>$data['patta_type_code'],
                      // 'patta_no' =>$data['patta_no'],
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>'CR',
                      'final_order_date'=>$data['comment_date']
                    );
                    //exit;
                    //var_dump($base);
                    $this->db->insert('dashboard_data',$base);
            }
             echo "Ported Records." . $i;
        }
        
//         //////////////Port AC To PP///////////////////////////
        function actoPP(){
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            //set_time_limit(0);
            $i=1;
            $sql="Select pb.* from allotment_cert_basic pb where pb.date_entry>='2017-02-15'  ";
            $variable=$this->db->query($sql)->result_array();
            foreach ($variable as $key => $data) {
               
                $i=$i+1;
                $final_order_date=null;
                //var_dump($data);
                if($data['status']==null and $data['not_fresh']==null){
                    $data['status']='P';
                    $pending_status='CO'; 
                     
                }
                else if($data['co_code']!=null and $data['not_fresh']!=null){
                    $data['status']='P';
                    $pending_status='LM'; 
                     
                }
                else if($data['lm_code']!=null and $data['not_fresh']!=null){
                    $data['status']='P';
                    $pending_status='SK'; 
                     
                }
                elseif($data['sk_code']!=null and $data['not_fresh']!=null){
                    $data['status']='P';
                    $pending_status='CO'; 
                      
                }
                elseif($data['bo_code']!=null){
                    $data['status']='P';
                    $pending_status='DC'; 
                     
                }
                // if($data['dc_code']!=null){
                    // $data['status']='P';
                    // $pending_status='CO'; 
                      
                // }
                
                elseif($data['status']=='R' and $data['chitha_correct_yn']==null){
                    $data['status']='F';
                    $pending_status='NA';  
                    $final_order_date=$data['dc_entry_date'];
                }
                
                elseif($data['dc_code']!=null and $data['status']=='P'){
                    $data['status']='P';
                    $pending_status='CO'; 
                     
                }
                
                elseif($data['chitha_correct_yn']!=null){
                    $data['status']='F';
                    $pending_status='NA'; 
                    $final_order_date=$data['dc_entry_date'];
                    
                }
                $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['circle_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  
                  'status' =>$data['status'],
                  'pending_with_user' =>$pending_status,
                  'case_type' =>'AC',
                'final_order_date'=>$final_order_date
                );
               //var_dump($base);
                $this->db->insert('dashboard_data',$base);
              
            }
            echo "Ported " . $i;
        }
        
//          //////////////Port AC To PP///////////////////////////
        function apcancel(){
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            //set_time_limit(0);
            $i=1;
            $sql="Select pb.* from apcancel_petition_basic pb where pb.date_entry>='2017-02-15' ";
            $variable=$this->db->query($sql)->result_array();
            foreach ($variable as $key => $data) {
               
                $i=$i+1;

                $final_order_date=null;
                //var_dump($data);
                if($data['not_fresh']==null){
                    $data['status']='P';
                    $pending_status='LM'; 
                      
                }
                if($data['lm_note_yn']!=null){
                    $data['status']='P';
                    $pending_status='SK'; 
                    
                }
                if($data['sk_note_yn']!=null){
                    $data['status']='P';
                    $pending_status='CO'; 
                      
                }
                if($data['not_fresh']!=null and $data['next_date_of_hearing']!=null AND $data['notice_generated_yn']==null){
                    $data['status']='P';
                    $pending_status='AST'; 
                      
                }
                if($data['notice_generated_yn']!=null){
                    $data['status']='P';
                    $pending_status='CO'; 
                     
                }
                if($data['dc_approval_yn']!=null){
                    $data['status']='P';
                    $pending_status='CO'; 
                     
                }
                if($data['order_passed']!=null){
                    $data['status']='F';
                    $pending_status='NA'; 
                    $final_order_date=$data['co_chitha_corrected_date'];
                     
                }
               
                $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  // 'dag_no'=>$data['dag_no'],
                  // 'patta_type_code' =>$data['patta_type_code'],
                  // 'patta_no' =>$data['patta_no'],
                  'status' =>$data['status'],
                  'pending_with_user' =>$pending_status,
                  'case_type' =>'AP',
                  'final_order_date'=>$final_order_date
                );
                // var_dump($base);
                $this->db->insert('dashboard_data',$base);
               
            }

            echo "Ported " . $i;
        }
        
//         //////////////Port Misc Cases//////////////////////
        function miscCase(){
            
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            $i=1;
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no where pb.submission_date >='2017-02-15' ";
            $variable=$this->db->query($sql)->result_array();
            foreach ($variable as $key => $data) {
                
                $i=$i+1;
                $final_order_date=null;
                //$pending_status='CO';
                if($data['status']=='01'){
                    $data['status']='P';
                    $pending_status='CO'; 
                    
                }
                if($data['status']=='18'){
                    $pending_status='LM';
                    $data['status']='P';
                     
                }
                if($data['status']=='02' and $data['lm_note_yn']!=null){
                    $pending_status='SK';
                    $data['status']='P';
                     
                }
                if($data['status']=='02' and $data['sk_note_yn']!=null){
                    $pending_status='CO';
                    $data['status']='P';
                     
                }
                if($data['status']=='10'){
                    $pending_status='NA';
                    $data['status']='F';
                    $final_order_date=$data['date_of_operation'];

                        
                }
                
               
                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      // 'dag_no'=>$data['dag_no'],
                      // 'patta_type_code' =>$data['patta_type_code'],
                      // 'patta_no' =>$data['patta_no'],
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>'MC',
                      'final_order_date' =>$final_order_date
                    );
                    //exit;
                    // var_dump($base);
                $this->db->insert('dashboard_data',$base);
            }
             echo "Ported Records." . $i;
        }
        
//         //////////////////////////////////////Pallabi////////////////////////////////
        function portSettleCase(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $i=1;
        $sql="Select acb.* from allotment_cert_basic acb where acb.settlement_typ='s' and acb.date_entry >='2017-02-15' ";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
        

            $i=$i+1;

            $final_order_date=null;

            if($data['lm_note']==null){
                    $pending_status='LM';
                    $data['status']='P';
                }

                else if($data['chitha_correct_yn']==null or $data['chitha_correct_date']==null)
                {

                    $pending_status='CO';
                    $data['status']='P';
                    
                }

                else
                {
                    $pending_status='NA';
                    $data['status']='F';
                    $final_order_date=$data['chitha_correct_date'];
                        
                }

                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['circle_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      // 'dag_no'=>$data['dag_no'],
                      // 'patta_type_code' =>'NA',
                      // 'patta_no' =>'NA',
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>'SM',
                      'final_order_date'=>$final_order_date
                    );
                //var_dump($base);
                $this->db->insert('dashboard_data',$base);
                
                
                
                
            }
            echo "Ported Records." . $i;
        }




        function portReclassCase(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $i=1;
        $sql="select * from t_reclassification where lm_date >='2017-02-15'";
        $variable=$this->db->query($sql)->result_array();
        foreach ($variable as $key => $data) {
        
        $i=$i+1;

        $final_order_date=null;
                
        if($data['co_yn']==null){
                    $pending_status='CO';
                    $data['status']='P';
                        
                }

           elseif($data['adc_report']==null)
                {

                    $pending_status='ADC';
                    $data['status']='P';
                   

                }

               elseif($data['dc_yn']==null)
                {

                    $pending_status='DC';
                    $data['status']='P';
                    

                }

                 if($data['co_chitha_updated_yn']==null and $data['dc_yn'] !=null)
                {

                    $pending_status='DC';
                    $data['status']='P';
                    

                }

              if($data['co_chitha_updated_yn']!=null)
                {
                    $pending_status='NA';
                    $data['status']='F';

                    $final_order_date=$data['co_chitha_updated_date'];
                }




                $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['lm_date'],
                      'dag_no'=>$data['dag_no'],
                      'patta_type_code' =>$data['patta_type_code'],
                      'patta_no' =>$data['patta_no'],
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>'RC',
                      'final_order_date'=>$final_order_date
                    );
                //var_dump($base);
                $this->db->insert('dashboard_data',$base);
            
        }
            echo "Ported Records." . $i;
    }


function portConvCase(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $i=1;
        $pending_status=null;

        // $sql="select pb.dist_code,pb.user_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.vill_townprt_code,pb.date_entry,pb.case_no,dag_no,patta_no,patta_type_code,status,date_of_order from Petition_Basic pb left join petition_dag_details pd on pb.petition_no=pd.petition_no  where  pb.mut_type='01' and pb.status!='B' ";


       // $sql="select pb.*,dag_no,patta_no,patta_type_code from Petition_basic pb left join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.petition_no=pd.petition_no  where  pb.mut_type='01' and (pb.status!='B' or pb.status is null or pb.status='' ) and pb.date_entry >='2017-02-15' ";

       $sql="select pb.* from Petition_basic pb  where  pb.mut_type='01' and (pb.status!='B' or pb.status is null or pb.status='' ) and pb.date_entry >='2017-02-15'";

        $variable=$this->db->query($sql)->result_array();


        foreach ($variable as $key => $data) {
            $i=$i+1;
            
             $final_order_date=null;

            if($data['not_fresh']==null){
                    $pending_status='CO';
                    $data['status']='P';
                
                }

                if($data['notice_generated_yn']!=null and $data['lm_note_yn']==null )
                {

                    $pending_status='LM';

                }

        if($data['lm_note_yn']!=null  and $data['sk_comment']==null)
            {
                    $pending_status='SK';

             }
        if($data['sk_comment']!=null and $data['proceeding_yn']==null){
                $pending_status='AST';
                   
                }

            if($data['proceeding_yn']!=null){
                $pending_status='CO';

                }

                if($data['bo_notice_gen']!=null and $data['bo_note_yn']==null ){
                $pending_status='BO';

                }

                 if($data['bo_note_yn']!=null){
                $pending_status='DC';

                }



           if($data['status']=='W' and $data['co_chitha_corrected_yn']==null){
                    $pending_status='CO';
                    $data['status']='P';
                        
                }

              if($data['status']=='F'){
                    $pending_status='NA';
                    $final_order_date=$data['co_order_conv_date'];
                        
                }

               // if($data['co_order_conv_premium']=='P' and $data['trans_code']=='F')
               //  {
               //      $pending_status=$data['add_off_desig'];  

               //  }
  

            
            if($data['status']=='D'){
                    $pending_status='CO';

                }
            // if($data['dag_no']==null){
            //     $dag_no='NA';
            // }else{
            //     $dag_no=$data['dag_no'];
            // }
            
            // if($data['patta_type_code']==null){
            //     $patta_type_code='NA';
            // }else{
            //     $patta_type_code=$data['patta_type_code'];
            // }
            
            // if($data['patta_no']==null){
            //     $patta_no='NA';
            // }else{
            //     $patta_no=$data['patta_no'];
            // }

            $base= array(
                      'dist_code'=> $data['dist_code'],
                      'subdiv_code' =>$data['subdiv_code'],
                      'cir_code'=>$data['cir_code'],
                      'mouza_pargona_code'=>$data['mouza_pargona_code'],
                      'lot_no'=>$data['lot_no'],
                      'vill_townprt_code'=>$data['vill_townprt_code'],
                      'case_no'=>$data['case_no'],
                      'date_of_reg'=>$data['date_entry'],
                      // 'dag_no'=>$dag_no,
                      // 'patta_type_code' =>$patta_type_code,
                      // 'patta_no' =>$patta_no,
                      'status' =>$data['status'],
                      'pending_with_user' =>$pending_status,
                      'case_type' =>'CV',
                      'final_order_date'=>$final_order_date,
                      //'remark'=>'test',
                    );
               // var_dump($base);
                $this->db->insert('dashboard_data',$base);

               
        }
            
            echo "Ported Records." . $i;
    }
        
//////////////08-11-2021/////////////////
    function revertedcases(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date=define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where order_passed is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and is_dispose='L'  and date_entry >= '$define_date'")->result();

        foreach($cases['cases'] as $rows) {

            if($rows->es_flag == 1 && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                // log_message('error', '#3015: Escalation details : '.json_encode($escRow));

                if(!empty($escRow) && $escRow != null)
                {
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                    if(!empty($escData) && $escData != null)
                    {
                        // log_message('error', '#3019: Escalation details : '.json_encode($escData)); 
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }
                    else 
                    {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    } 
                }
                else 
                {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
            else 
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
            
        }

        $cases['_view'] = 'lmmutation/revertedcases';
        $this->load->view('layouts/main',$cases);
    }
    function SKrevertedcases(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date=define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from field_mut_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where order_passed is null and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and is_dispose='S'  and date_entry >= '$define_date'")->result();
        $cases['_view'] = 'lmmutation/revertedcases';
        $this->load->view('layouts/main',$cases);
    }
    public function proreport() {
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $query = "select * from petition_proceeding where case_no='$case_no'";
        $details = $this->db->query($query)->result();
        $data['details'] = $details;
        $this->load->helper('html');
        $this->load->view('../views/lmmutation/proreport', $data);
    }
    function freshLmReport(){
        $data['genders'] = $this->mutationmodel->getGenders();
        $data['relation'] = $this->relationmodel->getRelations();
        $data['time'] = time();
        $data['nok_temp']=$data['pattadar_list']=array();

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['field_mut_basic'] = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=? and is_dispose=?", array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 'L'))->row();
        if (!empty($data['field_mut_basic'])) {
            $field_mut_dag_details = $this->db->query("SELECT * FROM field_mut_dag_details WHERE case_no=?", array($case_no));
            $dag = $field_mut_dag_details->result();
            $data['dag'] = $dag;
            $data['dag_details'] = $field_mut_dag_details->result();
            if($data['field_mut_basic']->mut_type=='01'){
                $data['field_mut_pattadar'] = $this->db->query("SELECT * FROM field_mut_pattadar WHERE case_no=?", array($case_no))->result();
                $data['field_mut_petitioner'] = $this->db->query("SELECT * FROM field_mut_petitioner WHERE case_no=?", array($case_no))->result();
            }else{
               $data['field_mut_petitioner'] = $this->db->query("SELECT pdar_id as pet_id, pdar_name as pet_name, pdar_guardian as guard_name,pdar_add1 as add1,pdar_add2 as add2,pdar_dag_por_b as applied_b,pdar_dag_por_k as applied_k,pdar_dag_por_lc as applied_lc, pdar_dag_por_k as applied_kr FROM field_part_petitioner WHERE case_no=?", array($case_no))->result(); 
               $data['field_mut_pattadar']=array();
               $data['pattadar_list'] = $this->db->query("SELECT  distinct(A.pdar_id), A.pdar_name, 
                    A.pdar_father, A.pdar_add1, A.pdar_mobile FROM chitha_pattadar A JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND B.p_flag!=? AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (SELECT pdar_id FROM field_part_petitioner WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND case_no=? )", array($dag->dag_no, '1', $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
                    $dag->vill_townprt_code, $dag->patta_no, $dag->patta_type_code, 
                    $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
                    $dag->vill_townprt_code, $dag->patta_no, $dag->patta_type_code, $case_no))->result();
               //echo $this->db->last_query();
            }
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            $data['nok_temp']= $this->mutationmodel->NokTempData($case_no);
            ///var_dump($data['nok_temp']);
            $data['d_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".DEATH_CERTIFICATE."' AND case_no=?", array($case_no))->row();
            $data['noc_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOC."' AND case_no=?", array($case_no))->row();
            $data['nok_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOK_CONSENT."' AND case_no=?", array($case_no))->row();
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            if($basundharaExist){
                $data['query']=null;
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        } else {
            redirect('/home');
        }

        // $cases_arr = explode('/', $case_no);
        // $service_code = end($cases_arr);
        // if(MULTI_DAG_MUTATION_DEED_ACTIVE == 1 && $service_code == 'FMUT'){
        
        if($data['field_mut_basic']->is_multidag == 'Y' || in_array($data['field_mut_basic']->is_multigeneration, ['S', 'M'])){
            $data['_view'] = 'lmmutation/multi-dag-freshreport';
        }else{
            $data['_view'] = 'lmmutation/freshreport';
        }

        $this->load->view('layouts/main',$data);
    }
    //////////14-02-2022////////////
    function freshSkReport(){
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');

        // $data['_view'] = 'skmutation/freshskreport';
        // $this->load->view('layouts/main',$data);

        // Modified by Abhijit --2024-05-16
        // considering this method as for field mutation as it is not clear, for which service(s) it is being used 
        $field_mut_basic = $this->db->query('select * from field_mut_basic where case_no=?', array($case_no))->row();
        if($field_mut_basic){
            if($field_mut_basic->is_multidag == 'Y'){
                $data['_view'] = 'skmutation/freshskreport-multidag';
            }else{
                $data['_view'] = 'skmutation/freshskreport';
            }
            $this->load->view('layouts/main',$data);
        }
    }
    /////////////////////    
    // function freshReportBack(){
    //     $rmk=addslashes(trim($_POST['note_order']));
    //     $case_no=$_POST['case_no'];
    //     $revert_back=$this->session->userdata('user_desig_code');
    //     $user_code=$this->session->userdata('user_code');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $lot_no = $this->session->userdata('lot_no');

    //     if($revert_back=='LM'){
    //        $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
    //        $rmk=$rmk ."   লাট মণ্ডল : ".$lmname->lm_name;
    //        $update=array(
    //             'is_dispose'=>null,
    //             'user_code'=>$user_code
    //         );
    //        $remark=array('remark'=>$rmk);
    //        $this->db->where('case_no',$case_no);
    //        $this->db->update('field_mut_dag_details',$remark);
    //        $task="LM";
    //     }else if($revert_back=='SK'){
    //        $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
    //        $rmk=$rmk . "   ভূমিলেখ্য পৰ্যবেক্ষক : " . $skname->username ;
    //        $update=array(
    //             'is_dispose'=>null,
    //             'sk_note'=>$rmk,
    //             'sk_note_date'=>date('Y-m-d'),
    //             'sk_flag'=>'y',
    //             'sk_id'=>$user_code
    //         );
    //        $task="SK";
    //     }
    //     $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
    //     if($basundharaExist){
    //         $this->basundharamodel->insertproceeding($case_no,$rmk);
    //         $this->db->where('case_no',$case_no);
    //         $this->db->update('field_mut_basic',$update);
    //         //////////////POST To basundhara/////////////////////
    //         $application_no=$basundharaExist;
    //         $rmk='Forwarded to CO';
    //         $status='M';
    //         $pen='CO';
    //         $case=$case_no;
    //         $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
    //         //////////////////

    //         $this->DashboardData($case_no,$pen,$rmk);
    //     }
    //     $this->session->set_flashdata('message',"Case have been forwarded");
    //     redirect('/home');
    // }
    function freshReportBack(){
        //xss & security validation starts
        $errorMessageArr = [];
        $resp = checkRequestSpecChar($_POST,array(),array(),array('note_order' => true));
        if($resp['status'] == 'n'){
           $errorMessageArr=$resp['field_wise_message'];
        }
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }
            echo json_encode($validation);
            return false;

       }
        $resp = checkRequestValidQuery($_POST,array(),array('note_order' => true));
        if($resp['status'] == 'n'){
            // $errorMessageStr .= $resp['messages'];
            $errorMessageArr=$resp['field_wise_message'];
        }        
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }
            echo json_encode($validation);
            return false;;
       }
        //xss & security validation ends 
        $mutatedLandValidation = [
            [
                'field' => 'note_order',
                'label' => 'Remarks',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'mut_b_fp',
                'label' => 'Bigha',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_k_fp',
                'label' => 'Katha ',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_lc_fp',
                'label' => 'Lessa',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            // [
            //     'field' => 'mut_g_fp',
            //     'label' => 'Ganda',
            //     'rules' => 'trim|required|xss_clean',
            // ],
        ];
        $revert_back=$this->session->userdata('user_desig_code');
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($revert_back=='LM' && $this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($mutatedLandValidation as $rule){
            if (form_error($rule['field'])) {
                $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $this->db->trans_begin();

            $rmk=addslashes(trim($_POST['note_order']));
            $case_no=$_POST['case_no'];
            $revert_back=$this->session->userdata('user_desig_code');
            $user_code=$this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $mut_b_op = $this->input->post('mut_b_fp');
            $mut_k_op = $this->input->post('mut_k_fp');
            $mut_lc_op = $this->input->post('mut_lc_fp');
            $mut_g_op = $this->input->post('mut_g_fp')==null?0:$this->input->post('mut_g_fp');
            $mut_kr_op = $this->input->post('mut_kr_fp');

            if($revert_back=='LM'){
               $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
               $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;

                $dagCount=$this->db->query("select * from field_mut_dag_details where case_no = ?",array($case_no))->num_rows();
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps !='RTPS' && $dagCount == 1)
                {


                   $update_land=array(
                        'm_dag_area_b' => $mut_b_op,
                        'm_dag_area_k' => $mut_k_op,
                        'm_dag_area_lc' => $mut_lc_op,
                        'm_dag_area_g' => $mut_g_op,
                        'm_dag_area_kr' => $mut_kr_op,
                    );
                   $this->db->where(['case_no'=>$case_no, 'dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 
                    'lot_no'=>$lot_no]);
                   $this->db->update('field_mut_dag_details', $update_land);
                   if($this->db->affected_rows() != 1){
                        $this->db->trans_rollback();
                        log_message("error","#FPART002 Updation failed in field_mut_dag_details");
                        return false;
                    }
                }



                $update=array(
                    'is_dispose'=>null,
                    'user_code'=>$user_code,
                );
                $remark=array('remark'=>$rmk);
                $task="LM";
            }else if($revert_back=='SK'){
               $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
               $rmk=$rmk . "   কানানগোহ : " . $skname->username ;
               $update=array(
                    'is_dispose'=>null,
                    'sk_note'=>$rmk,
                    'sk_note_date'=>date('Y-m-d'),
                    'sk_flag'=>'y',
                    'sk_id'=>$user_code
                );
               $task="SK";
            }

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $this->basundharamodel->insertproceeding($case_no,$rmk);
                $this->db->where('case_no',$case_no);
                $this->db->update('field_mut_basic',$update);
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    log_message("error","#FPART002 Updation failed in field_mut_basic");
                    return false;
                }
                //////////////POST To basundhara/////////////////////
                $application_no=$basundharaExist;
                $rmk='Case has successfully forwarded to CO';
                $status='M';
                $pen='CO';
                $case=$case_no;
                
                $this->DashboardData($case_no,$pen,$rmk);   
                $this->session->set_flashdata('message',"Case has been forwarded");

                //ESCALATION FOR REVERT REPORT BY LM================14082023
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $executionDate = $this->input->post('executionDate');
                //ESCALATION CODE INTEGRATION================SANMRI
                $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?",array($case_no))->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                    $service_code= 1;
                    $serviceType = explode('/',$basundharaExist);
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }
                    $user_code = $this->session->userdata('user_code');
                    $escalationUpdateStatus = $this->Escalationmodel->escalationLMFieldMutReport($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                    log_message("error", "#ESC3361, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC3361, transaction-error in method 'LMMutation/freshReportBack' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESC3361)");
                        redirect(base_url() . "index.php/home");
                    }                
                }
                $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);

                
                $this->db->trans_commit();
                $validation['final'] = 'true';
            }
            if($task=="SK"){
                redirect('/home');
            }
        }
        echo json_encode($validation);
        return;       
    }
    
    // Added by Abhijit -- 2024-05-03
    public function freshReportBackMultiDag(){
        // dd($_POST);
        //xss & security validation starts
        $errorMessageArr = [];
        $resp = checkRequestSpecChar($_POST,array(),array(),array('note_order' => true));
        if($resp['status'] == 'n'){
           $errorMessageArr=$resp['field_wise_message'];
        }
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }

            if(is_ajax_request()){
                echo json_encode($validation);
                return false;
            }else{
                $this->session->set_flashdata('message_extra', $resp['messages']);
                return redirect($_SERVER['HTTP_REFERER']);
            }

       }
        $resp = checkRequestValidQuery($_POST,array(),array('note_order' => true));
        if($resp['status'] == 'n'){
            // $errorMessageStr .= $resp['messages'];
            $errorMessageArr=$resp['field_wise_message'];
        }        
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }

            if(is_ajax_request()){
                echo json_encode($validation);
                return false;
            }else{
                $this->session->set_flashdata('message_extra', $resp['messages']);
                return redirect($_SERVER['HTTP_REFERER']);
            }
       }
        //xss & security validation ends 
        $mutatedLandValidation = [
            [
                'field' => 'note_order',
                'label' => 'Remarks',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'mut_b_fp[]',
                'label' => 'Bigha',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_k_fp[]',
                'label' => 'Katha ',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_lc_fp[]',
                'label' => 'Lessa',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'mut_g_fp[]',
                'label' => 'Ganda',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'mut_dag[]',
                'label' => 'Dag',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $revert_back=$this->session->userdata('user_desig_code');
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($revert_back=='LM' && $this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($mutatedLandValidation as $rule){
            if (form_error($rule['field'])) {
                $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $this->db->trans_begin();

            $rmk=addslashes(trim($_POST['note_order']));
            $case_no=$_POST['case_no'];
            $revert_back=$this->session->userdata('user_desig_code');
            $user_code=$this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $mut_dag = $this->input->post('mut_dag');
            $mut_b_op = $this->input->post('mut_b_fp');
            $mut_k_op = $this->input->post('mut_k_fp');
            $mut_lc_op = $this->input->post('mut_lc_fp');
            $mut_g_op = $this->input->post('mut_g_fp')==null?0:$this->input->post('mut_g_fp');
            $mut_kr_op = $this->input->post('mut_kr_fp');

            if($revert_back=='LM'){
               $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
               $rmk=$rmk ."   লাট মণ্ডল : ".$lmname->lm_name;

                $dagCount=$this->db->query("select * from field_mut_dag_details where case_no = ?",array($case_no))->num_rows();
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps !='RTPS' && $dagCount == 1)
                {


                   $update_land=array(
                        'm_dag_area_b' => $mut_b_op[0],
                        'm_dag_area_k' => $mut_k_op[0],
                        'm_dag_area_lc' => $mut_lc_op[0],
                        'm_dag_area_g' => $mut_g_op[0],
                        'm_dag_area_kr' => $mut_kr_op[0],
                    );
                   $this->db->where(['case_no'=>$case_no, 'dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 
                    'lot_no'=>$lot_no]);
                   $this->db->update('field_mut_dag_details', $update_land);
                   if($this->db->affected_rows() != 1){
                        $this->db->trans_rollback();
                        log_message("error","#FPART002 Updation failed in field_mut_dag_details");
                        return false;
                    }
                }



                $update=array(
                    'is_dispose'=>null,
                    'user_code'=>$user_code,
                );
                $remark=array('remark'=>$rmk);
                $task="LM";
            }else if($revert_back=='SK'){
               $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
               $rmk=$rmk . "   ভূমিলেখ্য পৰ্যবেক্ষক : " . $skname->username ;
               $update=array(
                    'is_dispose'=>null,
                    'sk_note'=>$rmk,
                    'sk_note_date'=>date('Y-m-d'),
                    'sk_flag'=>'y',
                    'sk_id'=>$user_code
                );
               $task="SK";
            }

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $this->basundharamodel->insertproceeding($case_no,$rmk);
                $this->db->where('case_no',$case_no);
                $this->db->update('field_mut_basic',$update);
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    log_message("error","#FPART002 Updation failed in field_mut_basic");
                    return false;
                }
                //////////////POST To basundhara/////////////////////
                $application_no=$basundharaExist;
                $rmk='Case has successfully forwarded to CO';
                $status='M';
                $pen='CO';
                $case=$case_no;
                $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $this->DashboardData($case_no,$pen,$rmk);   
                $this->session->set_flashdata('message',"Case has been forwarded");

                //ESCALATION FOR REVERT REPORT BY LM================14082023
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $executionDate = $this->input->post('executionDate');
                //ESCALATION CODE INTEGRATION================SANMRI
                $es_flag = $this->db->query("select es_flag from  field_mut_basic where case_no=?",array($case_no))->row()->es_flag;
                if($es_flag == 1 && ESCALATION_ENABLE == 1){

                    $user_code = $this->session->userdata('user_code');
                    $escalationUpdateStatus = $this->Escalationmodel->escalationLMFieldMutReport($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                    log_message("error", "#ESC3361, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC3361, transaction-error in method 'LMMutation/freshReportBack' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESC3361)");
                        redirect(base_url() . "index.php/home");
                    }                
                }
                ///////////////END ESCALATION//////////////
                $this->db->trans_commit();
                $validation['final'] = 'true';
            }
            if($task=="SK"){
                redirect('/home');
            }
        }
        echo json_encode($validation);
        return;       
    }

    //////////////DRONA////////////////
    function FmAddApplicant()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $FmLmReport = array(
                array(
                    'field' => 'case_id',
                    'label' => 'Case No',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'name_asm',
                    'label' => 'Applicant Name',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'trim|required|alpha|xss_clean',
                ),
                array(
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'guardian_name_asm',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'relation',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|required|alpha|xss_clean',
                ),
                array(
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required|xss_clean',
                ),
            );

            $this->form_validation->set_rules($FmLmReport);
            $this->form_validation->set_message('integer', 'This %s is not valid');

            if ($this->form_validation->run() === FALSE) {
                $this->form_validation->set_error_delimiters('', '');
                foreach ($FmLmReport as $rule) {
                    if (form_error($rule['field'])) {
                        $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
                echo json_encode($validation);
                return;
            } else {
                $validation['validation_success'] = "true";
                $arr = $this->input->post();
                $arr['user_code']=$this->session->userdata('user_code');
                $arr['ip']=$this->utilityclass->get_client_ip();
                $validation['success'] = $this->mutationmodel->FmAddApplicant($arr);
                $validation['nok_tmp'] = $this->mutationmodel->NokTempData($arr['case_id']);
                $validation['msg'] = 'Applicant Inserted successfully';
                echo json_encode($validation);
                //return;
            }
        }
    }
    /////////////////////
    public function DeleteNokTmpFMApp()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $case_id = $this->input->post('case_id');
            $row_id = $this->input->post('row_id');

            $delete_fm_record = $this->mutationmodel->DeleteNokTmpFMApp($row_id, $case_id);

            echo json_encode($delete_fm_record);
        }
    }
    //////////19-02-2022/////////
    function fieldReport(){
        $case_no=$this->input->get('app');
        $sql="Select dharitree from basundhar_application where basundhara='$case_no' "; 
        $data=$this->db->query($sql)->num_rows();
        if($data>0){
            $case= $this->db->query($sql)->row()->dharitree;
            $send['case']=array('basundhara'=>$case_no,'dharitree'=>$case);
            $sql="Select fmb.dispose_reason as co_note,fmd.remark as lm_note,fmb.sk_note as sk_note from field_mut_basic fmb join field_mut_dag_details fmd on
fmb.case_no=fmd.case_no where fmb.case_no='$case' ";
            $send['result']=$this->db->query($sql)->row_array();
            $sql="select co_order from petition_proceeding where case_no='$case' order by proceeding_id";
            $pro=$this->db->query($sql)->num_rows();
            if($pro>0){
                $send['proceeding']= $this->db->query($sql)->result_array();
            }else{
                $send['proceeding']=array();
            }
            // $send['_view'] = 'lmmutation/rejectReportNote';
            // $this->load->view('layouts/main',$send);
            $this->load->view('lmmutation/rejectReportNote',$send);
        }else{
            echo "No Report Found";
        }
    }
    //////////02-03-2022/////////
    function officeReport(){
        $case_no=$this->input->get('app');
        $sql="Select dharitree from basundhar_application where basundhara='$case_no' "; 
        $data=$this->db->query($sql)->num_rows();
        if($data>0){
            $send['result']['co_note']=$send['result']['lm_note']=$send['result']['sk_note']=null;
            $case= $this->db->query($sql)->row()->dharitree;
            $val=(explode("/",$case));
            $petition=$val[3];            
            if (is_int($petition))
            {
               $sql="Select report_on_possession as lm_note,sk_note as sk_note FROM petition_lm_note WHERE PETITION_NO=$petition";
               $send['result']=$this->db->query($sql)->row_array();
            }
            $send['case']=array('basundhara'=>$case_no,'dharitree'=>$case);
            
            $sql="select * from petition_proceeding where case_no='$case' order by proceeding_id";
            $pro=$this->db->query($sql)->num_rows();
            if($pro>0){
                $send['proceeding']= $this->db->query($sql)->result_array();
            }else{
                $send['proceeding']=array();
            }
            $this->load->view('lmmutation/rejectReportNote',$send);
        }else{
            echo "No Report Found";
        }
    }
//for updation in basundhara_data_updation method
function updateDeedDetails($case_no, $pet_id){

        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        
        if($basundhara){
            $old_data = $this->db->query("SELECT * FROM field_mut_petitioner WHERE 
                    case_no=? AND pet_id=?", array($case_no, $pet_id))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundhara,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );

            // echo "insert into basundhara_data_updation(ip, case_no, basundhara, user_code, date_entry, changes_data) values
            // ('".$this->utilityclass->get_client_ip()."','".$case_no."','".$basundhara."','".$this->user_code."','".date('Y-m-d H:i:s')."','".json_encode($old_data)."')";
            // return;

            return $this->db->insert('basundhara_data_updation', $data);
        }
    }



// public function firstApplicantEditInfo()
//     {
//         if($_SERVER['REQUEST_METHOD'] == 'POST')
//         {   
//             $applicantValidation = [
//                 [
//                     'field' => 'pet_name',
//                     'label' => 'Applicant`s Name',
//                     'rules' => 'trim|required|xss_clean'
//                 ],
//                 [
//                     'field' => 'pet_gender',
//                     'label' => 'Gender',
//                     'rules' => 'trim|alpha|required|xss_clean',
//                 ],
//                 [
//                     'field' => 'guard_name',
//                     'label' => 'Guardian Name',
//                     'rules' => 'trim|xss_clean|required',
//                 ],
//                 [
//                     'field' => 'relation_guardian',
//                     'label' => 'Guardian Relation',
//                     'rules' => 'trim|alpha|xss_clean|required',
//                 ],
//                 [
//                     'field' => 'add1',
//                     'label' => 'Address 1',
//                     'rules' => 'trim|xss_clean|required',
//                 ],
//             ];

//             $validation= null;
//             $this->form_validation->set_rules($applicantValidation);
//             $this->form_validation->set_message('integer', 'This %s is not valid');
            
//             if ($this->form_validation->run('applicantValidation') == FALSE)
//             {
//                 $this->form_validation->set_error_delimiters('', '');
//                 foreach($applicantValidation as $rule){
//                 if (form_error($rule['field'])) {
//                     $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
//                     }
//                 }
//             }
//             else
//             {
//                 $this->db->trans_begin(); //transaction begin

//                 $arr = $this->input->post();
                
//                 $pet_id = $arr['pet_id'];
//                 $petition_no = $arr['petition_no'];
//                 $case_no = $arr['case_no'];
//                     $ins = $this->updateDeedDetails($case_no, $pet_id);
//                     if($ins === true)
//                     {
//                         $update_petitioner_data = [
//                             'pet_name' => $arr['pet_name'],
//                             'pet_gender' => $arr['pet_gender'],
//                             'guard_name' => $arr['guard_name'],
//                             'guard_rel' => $arr['relation_guardian'],                            
//                             'add1' => $arr['add1'],
//                             'pdar_mobile' => $arr['pdar_mobile'],
//                             'user_code' => $this->user_code,
//                             'date_entry' => date('Y-m-d G:i:s'),
//                         ];

//                         $update_pet = $this->db->where(['case_no' => $case_no, 'pet_id' => $pet_id])->update('field_mut_petitioner', $update_petitioner_data);

//                         if($update_pet === true){
                            
//                             $detail = $this->db->query("SELECT * FROM field_mut_petitioner WHERE case_no=?", array($case_no))->result();
//                             $validation['petitioner_update'] = "true";
//                             $validation['detail'] = $detail;
//                             $this->db->trans_commit();                                
//                         }
//                         else
//                         {
//                             $this->db->trans_rollback();
//                             $validation['petitioner_update'] = "false";
//                             return;
//                         }
//                     }
//                     else
//                     {
//                         $this->db->trans_rollback();  
//                         $validation['basundhara_ins'] = "false";
//                         return;
//                     }
//                 //}
//             }
//             echo json_encode($validation);
//         }
//     }


    ////////
    public function firstApplicantEditInfo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {   
            $applicantValidation = [
                [
                    'field' => 'pet_name',
                    'label' => 'Applicant`s Name',
                    'rules' => 'trim|required|xss_clean'
                ],
                [
                    'field' => 'pet_gender',
                    'label' => 'Gender',
                    'rules' => 'trim|alpha|required|xss_clean',
                ],
                [
                    'field' => 'guard_name',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'relation_guardian',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|alpha|xss_clean|required',
                ],
                [
                    'field' => 'add1',
                    'label' => 'Address 1',
                    'rules' => 'trim|xss_clean|required',
                ],
            ];

            $validation= null;
            $this->form_validation->set_rules($applicantValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            
            if ($this->form_validation->run('applicantValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($applicantValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
            }
            else
            {
                $this->db->trans_begin(); //transaction begin

                $arr = $this->input->post();
                
                $pet_id = $arr['pet_id'];
                $case_no = $arr['case_no'];

                if($arr['add2'] == '' || $arr['add2'] == null) {
                    $arr['add2'] = '';
                }

                $ins = $this->updateDeedDetails($case_no, $pet_id);
                if($ins === true)
                {
                    $update_petitioner_data = [
                        'pet_name' => $arr['pet_name'],
                        'pet_gender' => $arr['pet_gender'],
                        'guard_name' => $arr['guard_name'],
                        'guard_rel' => $arr['relation_guardian'],                            
                        'add1' => $arr['add1'],
                        'add2' => $arr['add2'],
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                    ];

                    $update_pet = $this->db->where(['case_no' => $case_no, 'pet_id' => $pet_id])->update('field_mut_petitioner', $update_petitioner_data);

                    if($update_pet === true){
                        
                        $detail = $this->db->query("SELECT * FROM field_mut_petitioner WHERE case_no=?", array($case_no))->result();
                        $validation['petitioner_update'] = "true";
                        $validation['detail'] = $detail;
                        $this->db->trans_commit();                                
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['petitioner_update'] = "false";
                        return;
                    }
                }
                else
                {
                    $this->db->trans_rollback();  
                    $validation['basundhara_ins'] = "false";
                    return;
                }
                //}
            }
            echo json_encode($validation);
        }
    }

    // public function downloadDocuments($id){
    //     $file = $this->db->query("SELECT * FROM supportive_document WHERE id=?", array($id))->row();
    //     $url = base_url().$file->file_path;
    //     header("Content-Type: ".$file->file_type."");
    //     readfile($url);
    // }
    ////////////////24-02-22//////////////////
    public function getPendingCORevertCases(){
        $db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $append = $this->append;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $cases = $this->db->query("SELECT *, ba.basundhara FROM petition_basic fmb LEFT JOIN
        basundhar_application ba ON fmb.case_no=ba.dharitree WHERE lm_note_date IS NULL AND
        lm_note_yn IS NULL AND is_pending = 'Y' and status!='D' AND $append AND lot_no=? AND
        mouza_pargona_code=? and fmb.mut_type='03' ORDER BY mut_type, year_no, petition_no", array($lot_no, $mouza_pargona_code))->result();

        foreach($cases as $rows) {

            if($rows->es_flag == 1 && ESCALATION_ENABLE == 1){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                // log_message('error', '#3015: Escalation details : '.json_encode($escRow));

                if(!empty($escRow) && $escRow != null)
                {
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                    if(!empty($escData) && $escData != null)
                    {
                        log_message('error', '#3019: Escalation details : '.json_encode($escData)); 

                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }
                    else 
                    {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    } 
                }
                else 
                {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
            else 
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['cases'] = $cases;
        $data['_view'] = 'lmmutation/revertPendingOMcases';
        $this->load->view('layouts/main',$data);
    }
    public function writeRevertOMReport() {
        $data['genders'] = $this->mutationmodel->getGenders();
        $data['relation'] = $this->relationmodel->getRelations();
        $data['time'] = time();
        $data['nok_temp']=array();
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $pet_no = explode('/',$case_no);
        $petition_no = $pet_no['3'];
        
        $data['petition_basic']=$petbasic = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
        
        $data['petition_pattadar'] = $this->db->query("SELECT * FROM petition_pattadar WHERE petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petbasic->petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
        
        $data['petitioner'] = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petbasic->petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
  
        $data['petition_dag_details'] = $this->db->query("SELECT * FROM petition_dag_details 
            WHERE petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petbasic->petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();

        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $data['nok_temp']= $this->mutationmodel->NokTempData($case_no);

        ///var_dump($data['nok_temp']);
        $data['d_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".DEATH_CERTIFICATE."' AND case_no=?", array($case_no))->row();
        $data['noc_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOC."' AND case_no=?", array($case_no))->row();
        $data['nok_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".NOK_CONSENT."' AND case_no=?", array($case_no))->row();
        
        if(isset($basundharaExist)){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        }
        // var_dump($data['petition_basic']);
        // die;
        // Added by Abhijit -- 2024-05-14
        if($data['petition_basic']->is_multidag == 'Y'){
            $data['_view'] = 'lmmutation/revertReportOMMultiDag';
        }elseif($data['petition_basic']->is_multigeneration == 'S' || $data['petition_basic']->is_multigeneration == 'M'){
            $data['_view'] = 'lmmutation/revertReportOMMultiGen'; // for multigeneration=====
        }else
        {
            $data['_view'] = 'lmmutation/revertReportOM';
        }
        
        $this->load->view('layouts/main',$data);
    }
    function deleteFMUTrevertCases(){
        $id = $_POST['id'];
        $case_no = $_POST['case_no'];
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $count = $this->db->query("SELECT * FROM field_mut_petitioner WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->num_rows();
        if($count == 1){ // one applicant available
            $json['delete'] = false;
        }
        else
        {
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $old_data = $this->db->query("SELECT * FROM field_mut_petitioner WHERE 
            case_no=? AND pet_id=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $id,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );                    
            $delete=$this->db->insert('basundhara_data_updation', $data);
            if($delete==true){
                $del = $this->db->query("DELETE FROM field_mut_petitioner WHERE pet_id=? AND case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($id, $case_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no));
            if($del == true){
                $detail = $this->db->query("SELECT * FROM field_mut_petitioner WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
                    $json['details'] = $detail;
                    echo json_encode($json); 
                    return;  
                }else{
                   $json['delete'] = false; 
                }
            }   
        }
        echo json_encode($json);
    }
    function deleteOfcMutationNOK(){
        $id = $_POST['id'];
        $case_no = $_POST['case_no'];
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $old_data = $this->db->query("SELECT * FROM nok_tmp WHERE 
        case_id=? AND serial_id=?", array($case_no, $id))->row();
        $data=array(
            'ip'=>$this->utilityclass->get_client_ip(),
            'case_no' => $case_no,
            'basundhara' => $basundharaExist,
            'user_code' => $this->user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($old_data),
        );                    

        $this->db->insert('basundhara_data_updation', $data);

        $del = $this->db->query("DELETE FROM nok_tmp WHERE serial_id=? AND case_id=?", 
        array($id, $case_no));
        
        if($del == true){
            $detail = $this->db->query("SELECT * FROM nok_tmp WHERE case_id=?", array($case_no))->result();
            $json['details'] = $detail;
            echo json_encode($json);
        }    
    }
    // function deleteOMutationRevertCases(){
    //     $id = $_POST['id'];
    //     $case_no = $_POST['case_no'];
    //     $a = explode('/',$case_no);
    //     $petition_no = $a['3'];
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $lot_no = $this->session->userdata('lot_no');
    //     $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? and dist_code=? and subdiv_code=? 
    //         and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row()->petition_no;

    //     $count = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? and dist_code=? and subdiv_code=? 
    //         and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->num_rows();
    //     if($count == 1){ // one applicant available
    //         $json['delete'] = false;
    //     }
    //     else
    //     {
    //         $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
    //         $old_data = $this->db->query("SELECT * FROM petitioner WHERE 
    //         petition_no=? AND pet_id=? and dist_code=? and subdiv_code=? 
    //         and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no, $id,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
    //         $data=array(
    //             'ip'=>$this->utilityclass->get_client_ip(),
    //             'case_no' => $case_no,
    //             'basundhara' => $basundharaExist,
    //             'user_code' => $this->user_code,
    //             'date_entry' => date('Y-m-d H:i:s'),
    //             'changes_data' => json_encode($old_data),
    //         );                    
    //        //echo json_encode($old_data);
    //        $delete= $this->db->insert('basundhara_data_updation', $data);
    //        //echo $this->db->last_query();
    //        if($delete==true){
    //             $del = $this->db->query("DELETE FROM petitioner WHERE pet_id=? AND petition_no=? and dist_code=? and subdiv_code=? 
    //         and cir_code=? and mouza_pargona_code=? and lot_no=?", array($id, $petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no));
    //             //echo $this->db->last_query();
    //             if($del == true){
    //                 $detail = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? and dist_code=? and subdiv_code=? 
    //         and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
    //                 $json['details'] = $detail;
    //                 echo json_encode($json); 
    //                 return;  
    //             }else{
    //                $json['delete'] = false; 
    //             }
    //        }

    //     }
    //     echo json_encode($json);
    // }
     function deleteOMutationRevertCases(){
        $id = $_POST['id'];
        $case_no = $_POST['case_no'];
        $a = explode('/',$case_no);
        $petition_no = $a['3'];
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row()->petition_no;

        $count = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->num_rows();
        //echo $this->db->last_query();
        
        if($count == 1){ // one applicant available
            $json['delete'] = false;
        }
        else
        {
            $this->db->trans_begin();

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $old_data = $this->db->query("SELECT * FROM petitioner WHERE 
            petition_no=? AND pet_id=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no, $id,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );                    
           //echo json_encode($old_data);
           $delete= $this->db->insert('basundhara_data_updation', $data);
           if ($delete != 1)
           {
              $this->db->trans_rollback();
              $json['delete'] = false;
              echo json_encode($json);
              return;
           }

           //echo $this->db->last_query();
           if($delete==true || $delete == 1){
                $del = $this->db->query("DELETE FROM petitioner WHERE pet_id=? AND petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($id, $petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no));
                //echo $this->db->last_query();
                if ($this->db->affected_rows() <=0)
                {
                     $this->db->trans_rollback();
                     $json['delete'] = false;
                     echo json_encode($json);
                     return;
                }
                
                if($del == true || $del == 1)
                {
                    $this->db->trans_commit();                    
                    $detail = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($petition_no,$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();
                    $json['details'] = $detail;
                    echo json_encode($json); 
                    return;  
                }else{
                   $json['delete'] = false; 
                }
           }
        }
        echo json_encode($json);
    }
    function OMutAddApplicant()
    {
        //xss & security validation starts
                $errorMessageArr = [];
                $resp = checkRequestSpecChar($_POST);
                if($resp['status'] == 'n'){
                $errorMessageArr=$resp['field_wise_message'];
                }
                if(count($errorMessageArr)){
                    $validation = [];
                    foreach($errorMessageArr as $field => $errorMessageSing){
                        $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
                    }
                    echo json_encode($validation);
                    return false;;
                }
                $resp = checkRequestValidQuery($_POST);
                if($resp['status'] == 'n'){
                    $errorMessageArr=$resp['field_wise_message'];
                }        
                if(count($errorMessageArr)){
                    $validation = [];
                    foreach($errorMessageArr as $field => $errorMessageSing){
                        $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
                    }
                    echo json_encode($validation);
                    return false;;
            }
        //xss & security validation ends 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $OMLmReport = [
                [
                    'field' => 'case_id',
                    'label' => 'Case No',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'name_asm',
                    'label' => 'Applicant Name',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'trim|required|alpha|xss_clean',
                ],
                [
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'guardian_name_asm',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'relation',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|required|alpha|xss_clean',
                ],
                [
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required|xss_clean',
                ],
            ];

            $this->form_validation->set_rules($OMLmReport);
            $this->form_validation->set_message('integer', 'This %s is not valid');

            if ($this->form_validation->run() === FALSE) {
                $this->form_validation->set_error_delimiters('', '');
                foreach ($OMLmReport as $rule) {
                    if (form_error($rule['field'])) {
                        $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
                echo json_encode($validation);
                return;
            } 
            else 
            {
                $validation['validation_success'] = "true";
                $arr = $this->input->post();
                $arr['user_code']=$this->session->userdata('user_code');
                $arr['ip']=$this->utilityclass->get_client_ip();
                $validation['success'] = $this->mutationmodel->addApplicantOMutation($arr);
                $validation['nok_tmp'] = $this->mutationmodel->NokTempData($arr['case_id']);
                $validation['msg'] = 'Applicant Inserted successfully';
                echo json_encode($validation);
                //return;
            }
        }
    }
    public function OMutUpdateReport(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        $rmk = addslashes(trim($_POST['note_order']));
        $case_no = $_POST['case_no'];
        $revert_back = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no'); 
        $this->db->trans_begin();       

        if($revert_back=='LM'){
            $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
            $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;
            $task="LM";
        }
        else if($revert_back=='SK'){
            $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
            $rmk=$rmk . "   ভূমিলেখ্য পৰ্যবেক্ষক : " . $skname->username ;
            $task="SK";
        }

        $proInsert = $this->mutationmodel->proceeding_order($case_no,$rmk);


       if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#OMUTLMR001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#OMUTLMR001)".$case_no);
            redirect(base_url() . "index.php/home");
        }


        $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $this->basundharamodel->insertproceeding($case_no,$rmk);
            $this->db->where('case_no',$case_no);
            $update = [
                'lm_note_yn' => 'Y',
                'lm_note_date' => date('Y-m-d h:i:s'),
                'is_pending' => '',
            ];
            $this->db->update('petition_basic', $update);




            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            //ESCALATION CODE INTEGRATION================SANMRI
            $data = $this->db->query("select es_flag,next_date_of_hearing,out_of_esc,proceeding_yn from  petition_basic where "
                        . " case_no='$case_no'")->row();
            if($data->es_flag == 1 && ESCALATION_ENABLE == 1 && $data->out_of_esc == 0){

                $user_code = $this->session->userdata('user_code');
                $hearing_date = date('Y-m-d',strtotime($data->next_date_of_hearing));

                $service_code = 1;
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                $serviceType = explode('/',$basundharaExist);
                if($serviceType[1] == 'MUTD')
                {
                    $service_code = 2;
                }
                ///check action taken happen or not/////
                ///if not then executionDate will be the assigned date otherwise hearing date will be assigned date///
                if($data->proceeding_yn == '1')
                {
                    $executionDate = date('Y-m-d H:i:s');
                }
                else
                {
                    $executionDate = $data->next_date_of_hearing;
                }

                $escalationUpdateStatus = $this->Escalationmodel->escalationLMRevertReport($service_code,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearing_date);
                log_message("error", "#ESC4238OMUT, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC4238OMUT, transaction-error in method 'lmmutation/OMutUpdateReport' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC4238OMUT)");
                    redirect(base_url() . "index.php/home");
                }
                
            }
            ///////////////END ESCALATION//////////////



            //////////////POST To basundhara/////////////////////
            $application_no=$basundharaExist;
            $rmk='Forwarded to CO';
            $status='M';
            $pen='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            //////////////////
            $this->DashboardData($case_no,$pen,$rmk); 


            // $this->session->set_flashdata('message',"Case have been forwarded");
            // redirect('/home');
        }

        if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","LM Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");
            }
    }
    public function removeSupportiveDocs()
    {
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');
        $flag = $this->input->post('flag');
        $val = explode('/',$case_no);

        $petition_no = $val[3];        

        $file_name = (($flag==1)?DEATH_CERTIFICATE:(($flag==2)?NOC:NOK_CONSENT));

        $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
        $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));
        if($delete == true) {
            unlink($getFile->file_path);
            $validation['flag'] = $flag;
        }
        echo json_encode($validation);
    }
    // public function uploadSupportiveDocs()
    // {
    //     $val = $this->input->post();
    //     $case_no = $val['case_no'];
    //     $flag = $val['flag'];
    //     $dist_code = $this->session->userdata('dist_code');//$val['dist_code'];

    //     $val = explode('/',$case_no);
    //     $petition_no = $val[3];
    //     $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;

    //     $name = (($flag==1)?'death_cer':(($flag==2)?'noc_file':'nok_file'));
    //     $sl = (($flag==1)?'1':(($flag==2)?'2':'3'));
    //     $file_name = (($flag==1)?DEATH_CERTIFICATE:(($flag==2)?NOC:NOK_CONSENT));

    //     if($val[4]=='FMUT'){
    //         $folder = 'fieldmutation/'.$dist_code.'/';
    //     }
    //     if($val[4]=='FPART'){
    //         $folder = 'fieldpartition/'.$dist_code.'/';
    //     }
    //     if($val[4]=='OMUT'){
    //         $folder = 'officemutation/'.$dist_code.'/';
    //     }

    //     $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
    //     $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;

    //     if(!file_exists('./uploads/'.$folder)){
    //         mkdir('./uploads/'.$folder, 0777, true);
    //         $path = './uploads/'.$folder;
    //     }
    //     else {
    //         $path = './uploads/'.$folder;   
    //     } 
    //     //echo $path;       
    //     $config = [
    //         'upload_path' => $path,
    //         'allowed_types' => FILE_TYPE,
    //         'max_size' => MAX_SIZE,
    //     ];
    //     $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
    //     $checkFileExt = false;
    //     foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
    //         if($ext == $file_type) {
    //             $checkFileExt = true;
    //             break;
    //         }
    //     }
    //     $validation=null;
    //     //log_message('error',json_encode($_FILES[$name]['size']));
    //     if(!$checkFileExt){
    //         $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
    //     }
    //     else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
    //     {
    //         $validation['error'][] = array('message' => ' Larger file size selected.');
    //     }
    //     else
    //     {   
    //         $this->load->library('upload', $config);
    //         $this->upload->initialize($config);

    //         $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND
    //         file_name=? AND user_code=?",array($case_no, $file_name, $this->user_code))->num_rows();

    //         if($count == 0)
    //         {
    //             if ($this->upload->do_upload($name)) 
    //             {
    //                 $up = $this->upload->data();
    //                 $img = [
    //                     'case_no' => $case_no,
    //                     'file_name' => $file_name,
    //                     'user_code' => $this->user_code,
    //                     'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
    //                     'file_type' => $up['file_type'],
    //                     'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
    //                     'date_entry' => date('Y-m-d h:i:s'),
    //                     'mut_type' => FIELD_MUT_TYPE,
    //                 ];
    //                 $ins = $this->db->insert('supportive_document', $img);
    //                 if($ins == true)
    //                 {
    //                     $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
    //                     $validation['img_upload'] = true;
    //                     $validation['flag_set'] = $flag;
    //                     $validation['doc_id'] = $id;
    //                     $validation['filename'] = $file_name;
    //                 }
    //                 else
    //                 {
    //                     $validation['img_upload'] = false;
    //                 }
    //             }//end do upload
    //             else{
    //                 $validation['img_upload'] = false;
    //             }
    //         }// end count if

    //         else { //overwrite previous one

    //             $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->file_path;
    //             unlink($file);
    //             if ($this->upload->do_upload($name)) 
    //             {
    //                 $up = $this->upload->data();
    //                 $overwrite = [
    //                     'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
    //                     'file_type' => $up['file_type'],
    //                     'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
    //                     'date_entry' => date('Y-m-d h:i:s'),
    //                     'mut_type' => FIELD_MUT_TYPE,
    //                 ];
    //                 $this->db->where(['case_no'=>$case_no, 'file_name'=>$file_name, 'user_code'=>$this->user_code]);
    //                 $this->db->update('supportive_document', $overwrite);
    //                 if($this->db->affected_rows() != 1)//if no updation made
    //                 {
    //                     $validation['img_upload'] = false;   
    //                 }
    //                 else
    //                 {
    //                     $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
    //                     $validation['img_upload'] = true;
    //                     $validation['flag_set'] = $flag;
    //                     $validation['doc_id'] = $id;
    //                     $validation['filename'] = $file_name;
    //                 }
    //             }
    //         }
    //     }
    //     echo json_encode($validation);        
    // }

    public function uploadSupportiveDocs()
    {
        $val = $this->input->post();
        $case_no = $val['case_no'];
        $flag = $val['flag'];
        $dist_code = $this->session->userdata('dist_code');//$val['dist_code'];

        $val = explode('/',$case_no);
        $petition_no = $val[3];        

        if($val[4]=='FMUT'){
            $folder = UPLOAD_BASE_FIELDMUT.UPLOAD_SEPARATOR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='FPART'){
            $folder = UPLOAD_BASE_FIELDPART.UPLOAD_SEPARATOR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='OMUT'){
            $folder = UPLOAD_BASE_OFFICEMUT.UPLOAD_SEPARATOR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='OPART'){
            $folder = UPLOAD_BASE_OFFICEPART.UPLOAD_SEPARATOR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if ($petition_no == null || $petition_no == '' || empty($petition_no))
        {
            $validation['img_upload'] = false;
            echo json_encode($validation);
            return;
        }

        $name = (($flag==1)?'death_cer':(($flag==2)?'noc_file':'nok_file'));
        $sl = (($flag==1)?'1':(($flag==2)?'2':'3'));
        $file_name = (($flag==1)?DEATH_CERTIFICATE:(($flag==2)?NOC:NOK_CONSENT));
        

        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;
        
        $path = $folder;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
            // $path = './uploads/'.$folder;
        }
        // else {
        //     $path = './uploads/'.$folder;   
        // } 
        // echo $path;       
        $config = [
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        ];
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        $validation=null;
        //log_message('error',json_encode($_FILES[$name]['size']));
        if(!$checkFileExt){
            $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
        }
        else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
        {
            $validation['error'][] = array('message' => ' Larger file size selected.');
        }
        else
        {   
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND
            file_name=? AND user_code=?",array($case_no, $file_name, $this->user_code))->num_rows();

            if($count == 0)
            {
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'file_name' => $file_name,
                        'user_code' => $this->user_code,
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => FIELD_MUT_TYPE,
                    ];
                    $ins = $this->db->insert('supportive_document', $img);
                    if($ins == true)
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                    else
                    {
                        $validation['img_upload'] = false;
                    }
                }//end do upload
                else{
                    $validation['img_upload'] = false;
                }
            }// end count if

            else { //overwrite previous one

                $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->file_path;
                unlink($file);
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $overwrite = [
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => FIELD_MUT_TYPE,
                    ];
                    $this->db->where(['case_no'=>$case_no, 'file_name'=>$file_name, 'user_code'=>$this->user_code]);
                    $this->db->update('supportive_document', $overwrite);
                    if($this->db->affected_rows() != 1)//if no updation made
                    {
                        $validation['img_upload'] = false;   
                    }
                    else
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                }
            }
        }
        echo json_encode($validation);        
    }

    public function firstApplicantOMutEditInfo_old()
    {
        $year_no = date('Y');
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {   
            $applicantValidation = [
                [
                    'field' => 'pet_name',
                    'label' => 'Applicant`s Name',
                    'rules' => 'trim|required|xss_clean'
                ],
                [
                    'field' => 'pet_gender',
                    'label' => 'Gender',
                    'rules' => 'trim|alpha|required|xss_clean',
                ],
                [
                    'field' => 'guard_name',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'relation_guardian',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|alpha|xss_clean|required',
                ],
                [
                    'field' => 'add1',
                    'label' => 'Address 1',
                    'rules' => 'trim|xss_clean|required',
                ],
            ];

            $validation= null;
            $this->form_validation->set_rules($applicantValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            
            if ($this->form_validation->run('applicantValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($applicantValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
            }
            else
            {
                $this->db->trans_begin(); //transaction begin

                $arr = $this->input->post();

                $pet_id = $arr['pet_id'];
                $case_no = $arr['case_no'];
                $petition_no = $arr['pet_no'];

                if($arr['add2'] == '' || $arr['add2'] == null) {
                    $arr['add2'] = '';   
                }
                
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                $old_data = $this->db->query("SELECT * FROM petitioner WHERE
                year_no=? AND petition_no=? AND pet_id=?", array($year_no, $petition_no, $pet_id))->row();
                $data=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundhara,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($old_data),
                );
                $ins = $this->db->insert('basundhara_data_updation', $data);

                if($ins === true)
                {
                    $update_petitioner_data = [
                        'pet_name' => $arr['pet_name'],
                        'pet_gender' => $arr['pet_gender'],
                        'guard_name' => $arr['guard_name'],
                        'guard_rel' => $arr['relation_guardian'],                            
                        'add1' => $arr['add1'],
                        'add2' => $arr['add2'],
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                    ];

                    $update_pet = $this->db->where(['petition_no' => $petition_no, 'pet_id' => $pet_id, 'year_no' => $year_no])->update('petitioner', $update_petitioner_data);

                    if($update_pet === true){
                        // echo "SELECT * FROM petitioner WHERE petition_no='$petition_no' AND year_no='$year_no'";
                        $detail = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND year_no=?", array($petition_no, $year_no))->result();
                        // var_dump($detail);
                        // return;
                        $validation['petitioner_update'] = "true";
                        $validation['detail'] = $detail;
                        $this->db->trans_commit();                                
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['petitioner_update'] = "false";
                        return;
                    }
                }
                else
                {
                    $this->db->trans_rollback();  
                    $validation['basundhara_ins'] = "false";
                    return;
                }
                //}
            }
            echo json_encode($validation);
        }
    }

     public function firstApplicantOMutEditInfo()
    {
        //$year_no = date('Y');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {   
            $applicantValidation = [
                [
                    'field' => 'pet_name',
                    'label' => 'Applicant`s Name',
                    'rules' => 'trim|required|xss_clean'
                ],
                [
                    'field' => 'pet_gender',
                    'label' => 'Gender',
                    'rules' => 'trim|alpha|required|xss_clean',
                ],
                [
                    'field' => 'guard_name',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'relation_guardian',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|alpha|xss_clean|required',
                ],
                [
                    'field' => 'add1',
                    'label' => 'Address 1',
                    'rules' => 'trim|xss_clean|required',
                ],
            ];

            $validation= null;
            $this->form_validation->set_rules($applicantValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            
            if ($this->form_validation->run('applicantValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($applicantValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
            }
            else
            {
                $this->db->trans_begin(); //transaction begin

                $arr = $this->input->post();

                $pet_id = $arr['pet_id'];
                $case_no = $arr['case_no'];
                $petition_no = $arr['pet_no'];

                if($arr['add2'] == '' || $arr['add2'] == null) {
                    $arr['add2'] = '';   
                }
                
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                $old_data = $this->db->query("SELECT * FROM petitioner WHERE
                  petition_no=? AND pet_id=? and subdiv_code=? and cir_code=?",
                       array($petition_no, $pet_id,$subdiv_code,$cir_code))->row();
                $data=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundhara,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($old_data),
                );
                $ins = $this->db->insert('basundhara_data_updation', $data);

                if($ins === true)
                {
                    $update_petitioner_data = [
                        'pet_name' => $arr['pet_name'],
                        'pet_gender' => $arr['pet_gender'],
                        'guard_name' => $arr['guard_name'],
                        'guard_rel' => $arr['relation_guardian'],                            
                        'add1' => $arr['add1'],
                        'add2' => $arr['add2'],
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                    ];

                    $update_pet = $this->db->where(['petition_no' => $petition_no, 'pet_id' => $pet_id,
                           'subdiv_code' => $subdiv_code,'cir_code' => $cir_code])->update('petitioner', $update_petitioner_data);

                    if($this->db->affected_rows() > 0){                        
                        $detail = $this->db->query("SELECT * FROM petitioner WHERE
                                    petition_no=? and subdiv_code=? and cir_code=?",
                                    array($petition_no, $subdiv_code,$cir_code))->result();
                        // var_dump($detail);
                        // return;
                        $validation['petitioner_update'] = "true";
                        $validation['detail'] = $detail;
                        $this->db->trans_commit();                                
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['petitioner_update'] = "false";
                        return;
                    }
                }
                else
                {
                    $this->db->trans_rollback();  
                    $validation['basundhara_ins'] = "false";
                    return;
                }
                //}
            }
            echo json_encode($validation);
        }
    }

    
    // Added by Abhijit --2024-05-21
    public function firstApplicantOMutEditInfoMultiDagGen()
    {
        //$year_no = date('Y');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {   
            $applicantValidation = [
                [
                    'field' => 'pet_name',
                    'label' => 'Applicant`s Name',
                    'rules' => 'trim|required|xss_clean'
                ],
                [
                    'field' => 'pet_gender',
                    'label' => 'Gender',
                    'rules' => 'trim|alpha|required|xss_clean',
                ],
                [
                    'field' => 'guard_name',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'relation_guardian',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|alpha|xss_clean|required',
                ],
                [
                    'field' => 'add1',
                    'label' => 'Address 1',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'marital_status',
                    'label' => 'Marital Status',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'occupation',
                    'label' => 'Occupation',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'pet_caste',
                    'label' => 'Caste',
                    'rules' => 'trim|xss_clean|required',
                ],
                [
                    'field' => 'id',
                    'label' => 'ID',
                    'rules' => 'trim|xss_clean|required',
                ],
            ];

            if($_POST['pet_caste'] != '6'){
                array_push($applicantValidation, [
                    'field' => 'pet_protected_class',
                    'label' => 'Protected Class',
                    'rules' => 'trim|xss_clean|required',
                ]);
            }
            
            $validation= null;
            $this->form_validation->set_rules($applicantValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            
            if ($this->form_validation->run('applicantValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($applicantValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
            }
            else
            {
                $this->db->trans_begin(); //transaction begin

                $arr = $this->input->post();

                $pet_id = $arr['pet_id'];
                $case_no = $arr['case_no'];
                $petition_no = $arr['pet_no'];
                $id = $arr['id'];

                if($arr['add2'] == '' || $arr['add2'] == null) {
                    $arr['add2'] = '';   
                }
                
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                $old_data = $this->db->query("SELECT * FROM petitioner WHERE
                  petition_no=? AND pet_id=? and subdiv_code=? and cir_code=?",
                       array($petition_no, $pet_id,$subdiv_code,$cir_code))->row();
                $data=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundhara,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($old_data),
                );
                $ins = $this->db->insert('basundhara_data_updation', $data);

                if($ins === true)
                {
                    $update_petitioner_data = [
                        'pet_name' => $arr['pet_name'],
                        'pet_gender' => $arr['pet_gender'],
                        'guard_name' => $arr['guard_name'],
                        'guard_rel' => $arr['relation_guardian'],                            
                        'add1' => $arr['add1'],
                        'add2' => $arr['add2'],
                        'marital_status' => $arr['marital_status'],
                        'applicant_occupation' => $arr['occupation'],
                        'caste_category' => $arr['pet_caste'],
                        'tribe_category' => isset($arr['pet_protected_class']) ? $arr['pet_protected_class'] : '',
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                    ];
                    
                    $update_pet = $this->db->where(['petition_no' => $petition_no, 'pet_id' => $pet_id, 'id' => $id,
                           'subdiv_code' => $subdiv_code,'cir_code' => $cir_code])->update('petitioner', $update_petitioner_data);

                    if($this->db->affected_rows() > 0){                        
                        $detail = $this->db->query("SELECT * FROM petitioner WHERE
                                    petition_no=? and subdiv_code=? and cir_code=?",
                                    array($petition_no, $subdiv_code,$cir_code))->result();
                        // var_dump($detail);
                        // return;
                        $validation['petitioner_update'] = "true";
                        $validation['detail'] = $detail;
                        $this->db->trans_commit();                                
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['petitioner_update'] = "false";
                        return;
                    }
                }
                else
                {
                    $this->db->trans_rollback();  
                    $validation['basundhara_ins'] = "false";
                    return;
                }
                //}
            }
            echo json_encode($validation);
        }
    }

    public function downloadDocuments($id=null){       
        if(isset($id)){ 
            ob_start(); 
            $result = $this->db->query("SELECT * FROM supportive_document WHERE id=?", array($id))->row_array();
            //"C:\\xampp\\htdocs\\DharitreeSVN_demo\\"
            // if ($_SERVER['HTTP_HOST'] =='10.177.0.34')
            // {
            //     $file = NOK_UPLOAD_PATH.$result['file_path'];
            // }
            // else
            // {
            //     $file = $result['file_path'];
            // }
            $content_type = $result['file_type'];

            $file = search_file_location($result['file_path'], false);
            
            if($file){
                $content_type = check_nd_get_content_type($content_type, $file);
                header('Content-Type: '.$content_type);
                header('Content-Length: ' . filesize($file));
                ob_get_clean();
                echo file_get_contents($file);
            }else{
                echo "No such file found";
            }

            // log_message("error", 'DOwnloaded file path: '.json_encode($file));
        }else{
            echo "No Data Found..";
        }
    }

    ////////////////END 24-02-22/////////////////////
    public function getPattadarDetail()
{
    $val = $this->input->post();
    $pet = $this->db->query("SELECT dist_code, subdiv_code, cir_code,
    mouza_pargona_code, lot_no, vill_townprt_code, patta_no, dag_no, 
    patta_type_code FROM field_mut_dag_details 
    WHERE case_no=?", array($val['case_no']))->row();
    //echo $this->db->last_query();

    $pattadar = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father,
    A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob
    FROM chitha_pattadar A
    JOIN chitha_dag_pattadar B
    ON
    A.dist_code=B.dist_code 
    AND A.subdiv_code=B.subdiv_code
    AND A.cir_code=B.cir_code
    AND A.mouza_pargona_code=B.mouza_pargona_code
    AND A.lot_no=B.lot_no
    AND A.vill_townprt_code=B.vill_townprt_code
    AND A.patta_no=B.patta_no
    AND A.patta_type_code=B.patta_type_code
    WHERE
    B.dag_no=? 
    AND B.p_flag!=?
    AND A.dist_code=? 
    AND A.subdiv_code=?
    AND A.cir_code=?
    AND A.mouza_pargona_code=?
    AND A.lot_no=?
    AND A.vill_townprt_code=?
    AND A.patta_no=?
    AND A.patta_type_code=? AND A.pdar_id=?", array($pet->dag_no, '1',
    $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, 
    $pet->lot_no, $pet->vill_townprt_code, $pet->patta_no, 
    $pet->patta_type_code, $val['id']))->row();

    $json['details'] = $pattadar;
    echo json_encode($json);
}

public function addAdditionalFirstParty()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $addPartyValidation = [
            [
                'field' => 'add_pattadar_FP',
                'label' => 'Pattadar',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'appl_name',
                'label' => 'Applicant ',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'guardian_name',
                'label' => 'Guardian Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'relation',
                'label' => 'Relation',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'dob',
                'label' => 'Date of Birth',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $validation= null;
        $this->form_validation->set_rules($addPartyValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('addPartyValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($addPartyValidation as $rule){
            if (form_error($rule['field'])) {
                $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        } 
        else 
        {
            $this->db->trans_begin();
            $val = $this->input->post();
            $date = date('Y-m-d', strtotime($val['dob']));

            $cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no 
            FROM field_part_petitioner WHERE case_no=?", array($val['case_no']))->row();

            $field_partition = $this->db->query("SELECT * FROM field_part_petitioner 
            WHERE case_no=?", array($val['case_no']));

            $petitioner = $field_partition->row();
            $data = clone $petitioner;
            $data->pdar_id = $val['add_pattadar_FP'];
            $data->pdar_cron_no = $cron_no->cron_no;
            $data->pdar_name = $val['appl_name'];
            $data->pdar_guardian = $val['guardian_name'];
            $data->pdar_rel_guar = $val['relation'];
            $data->pdar_add1 = $val['address'];
            $data->user_code = $this->session->userdata('user_code');
            $data->date_entry = date('Y-m-d h:i:s');
            $data->operation = 'E';
            $data->pdar_gender = $val['gender'];
            $data->case_no = $val['case_no'];
            $ins = $this->db->insert('field_part_petitioner', $data);
            
            if($ins != 1){
                $this->db->trans_rollback();
                log_message("error","#ERR001 Insertion failed in field_part_petitioner");
                return false;
            }

            $basundhara=$this->basundharamodel->checkExistBasundhar($val['case_no']);
            if($basundhara){
                $basuData=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $val['case_no'],
                    'basundhara' => $basundhara,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($data),
                );
                $basu_ins = $this->db->insert('basundhara_data_updation', $basuData);
            }

            if($basu_ins != 1){
                $this->db->trans_rollback();
                log_message("error","#ERR002 Insertion failed in basundhara_data_updation");
                return false;
            }


            $mut_type = $this->db->query("SELECT mut_type FROM field_mut_basic
            WHERE case_no=?", array($val['case_no']))->row();
            $validation['mut_type'] = $mut_type;

            $new_petitioner = $this->db->query("SELECT * FROM field_part_petitioner 
            WHERE case_no=?", array($val['case_no']));
            
            $validation['details'] = $new_petitioner->result();
            $data = $new_petitioner->row();

            $pattadar = $this->db->query("SELECT DISTINCT(A.pdar_id), A.pdar_name, A.pdar_father, A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob FROM chitha_pattadar A JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND B.p_flag!=? AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (SELECT pdar_id FROM field_part_petitioner WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND petition_no=? )", array($data->dag_no, '1', $data->dist_code, $data->subdiv_code, $data->cir_code,
            $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
            $data->patta_no, $data->patta_type_code, $data->dist_code, 
            $data->subdiv_code, $data->cir_code, 
            $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
            $data->patta_no, $data->patta_type_code, $data->petition_no))->result();
            
            $validation['pattadar_list'] = $pattadar;

            $this->db->trans_commit();
            
        }
        echo json_encode($validation);
        return;
    }
}

function deleteFirstPartyFPART()
{
    $id = $_POST['id'];
    $case_no = $_POST['case_no'];

    $field_part = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=?", array($case_no))->row();

    $dist_code = $field_part->dist_code;
    $subdiv_code = $field_part->subdiv_code;
    $cir_code = $field_part->cir_code;
    $mouza_pargona_code = $field_part->mouza_pargona_code;
    $lot_no = $field_part->lot_no;
    $vill_code = $field_part->vill_townprt_code;

    $append = " dist_code='$dist_code' AND subdiv_code='$subdiv_code' AND 
    cir_code='$cir_code' AND mouza_pargona_code='$mouza_pargona_code' AND 
    lot_no='$lot_no' AND vill_townprt_code='$vill_code'";

    $count = $this->db->query("SELECT * FROM field_part_petitioner WHERE case_no=? AND $append", array($case_no))->num_rows();

    if($count == 1){ // one applicant available
        $json['delete'] = false;
    }
    else
    {
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $old_data = $this->db->query("SELECT * FROM field_part_petitioner WHERE 
        case_no=? AND pdar_id=? and dist_code=? and subdiv_code=? 
        and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $id, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
        $data=array(
            'ip'=>$this->utilityclass->get_client_ip(),
            'case_no' => $case_no,
            'basundhara' => $basundharaExist,
            'user_code' => $this->user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($old_data),
        );                    
        $delete=$this->db->insert('basundhara_data_updation', $data);
        if($delete==true)
        {
            // echo "DELETE FROM field_part_petitioner WHERE pdar_id='$id' 
            // AND case_no='$case_no' and dist_code='$dist_code' and 
            // subdiv_code='$subdiv_code' AND cir_code='$cir_code' AND
            // mouza_pargona_code='$mouza_pargona_code' AND lot_no='$lot_no'";

            $del = $this->db->query("DELETE FROM field_part_petitioner WHERE pdar_id=? 
            AND case_no=? and dist_code=? and subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=?", array($id, $case_no, $dist_code, $subdiv_code,
            $cir_code, $mouza_pargona_code, $lot_no));
            // var_dump($del);
            // return;

            
            if($del == true)
            {
                $dag = $this->db->query("SELECT dag_no, patta_no, patta_type_code FROM field_mut_dag_details WHERE case_no=?", array($case_no))->row();

                $pattadar = $this->db->query("SELECT DISTINCT(A.pdar_id), A.pdar_name, 
                A.pdar_father, A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob FROM chitha_pattadar A JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND B.p_flag!=? AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (
                SELECT pdar_id FROM field_part_petitioner WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND case_no=? )", array($dag->dag_no, '1', $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_code, 
                $dag->patta_no, $dag->patta_type_code, $dist_code, 
                $subdiv_code, $cir_code, 
                $mouza_pargona_code, $lot_no, $vill_code, 
                $dag->patta_no, $dag->patta_type_code, $case_no))->result();
                
                $json['pattadar_list'] = $pattadar;

                $detail = $this->db->query("SELECT pdar_id as pet_id, pdar_name as pet_name,
                pdar_guardian as guard_name, pdar_add1 as add1, pdar_add2 as 
                add2, pdar_dag_por_b as applied_b, pdar_dag_por_k as applied_k,
                pdar_dag_por_lc as applied_lc, pdar_dag_por_k as applied_kr FROM 
                field_part_petitioner WHERE case_no=?", array($case_no))->result();
                $json['details'] = $detail;
                echo json_encode($json); 
                return;  
            }
            else
            {
               $json['delete'] = false; 
               return;
            }
        }   
    }
    echo json_encode($json);
    }


    ////////////    06-04-22 field mutation second party add & delete     /////////////
    //for loading data on pop up for second party add
    public function getSecondPartyApplicantDetailFM(){

        $val = $this->input->post();
        $table = 'field_mut_pattadar';

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();

        $details['sec_party'] = $this->mutationmodel->getSecondPartyPattadarList($val['dag'], $val['pno'], $val['ptype'], $val['dist'], $val['sub'], $val['cir'], $val['mouza'], $val['lot'], $val['vill'], $val['no'])->result();

        echo json_encode($details);
        return;
    }
    // addition of new second party for field mutation
    public function addAdditionalSecondPartyFM()
    {
        $addSecondPartyValidation = [
            [
                'field' => 'appl_sec_party_FM',
                'label' => 'Pattadar',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'guardian_name_sec_party_FM',
                'label' => 'Guardian Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'relation_sec_party_FM',
                'label' => 'Relation',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gender_sec_party_FM',
                'label' => 'Gender',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'dob_sec_party_FM',
                'label' => 'Date of Birth',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'address_sec_party_FM',
                'label' => 'Address',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'strikeout_sec_party_FM',
                'label' => 'Inplace/Alongwith',
                'rules' => 'trim|required|xss_clean|integer',
            ],
        ];
        $json= null;
        $this->form_validation->set_rules($addSecondPartyValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('addSecondPartyValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($addSecondPartyValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        } 
        else 
        {
            $table = 'field_mut_pattadar';
            $val = $this->input->post();
            $dob = date('Y-m-d', strtotime($val['dob_sec_party_FM']));
            $applicant_id = $val['appl_sec_party_FM'];
            $applicant_name = $val['applicant_name'];
            $guardian = $val['guardian_name_sec_party_FM'];
            $relation = $val['relation_sec_party_FM'];
            $gender = $val['gender_sec_party_FM'];
            $address = $val['address_sec_party_FM'];
            $strike = $val['strikeout_sec_party_FM'];
            $case_no = $val['case_no'];
            $dist = $val['dist'];
            $sub = $val['sub'];
            $cir = $val['cir'];
            $mouza = $val['mouza'];
            $lot = $val['lot'];
            $vill = $val['vill'];
            $dag = $val['dag'];
            $pno = $val['pn'];
            $ptype = $val['ptype'];

            //get mutated and chitha land detail
            $land = $this->db->query("SELECT * FROM field_mut_dag_details WHERE 
            case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? 
            AND patta_no=? AND patta_type_code=?", array($case_no, $dist, $sub, $cir, $mouza,
                $lot, $vill, $dag, $pno, $ptype))->row();

            $totalLand = ($land->dag_area_b*100)+($land->dag_area_k*20)+$land->dag_area_lc;
            $appliedLand = ($land->m_dag_area_b*100)+($land->m_dag_area_k*20)+$land->m_dag_area_lc;

            //get max cron number
            $cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no 
            FROM $table WHERE case_no=? AND dist_code=? AND 
            subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND
            lot_no=? AND vill_townprt_code=? AND dag_no=? AND patta_no=? AND
            patta_type_code=?", array($case_no, $dist, $sub, $cir, $mouza,
                $lot, $vill, $dag, $pno, $ptype))->row()->cron_no;

            //get second party detail
            $fm_second_party = $this->db->query("SELECT * FROM $table 
            WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? 
            AND patta_no=? AND patta_type_code=?", array($case_no, $dist, $sub, $cir, 
                $mouza, $lot, $vill, $dag, $pno, $ptype));

            $this->db->trans_begin();

            //check if applied area is equal ro total area
            // if($totalLand == $appliedLand && $strike==0){
            //     $this->db->trans_rollback();
            //     log_message('error', '#ERRFMSEC001: Both applied & total land area are same. Strikeout can`t be Alongwith for case no :'. $case_no);
            //     $json = [
            //         'message'=>"#ERRFMSEC001: Applied and Total land area are same. Alongwith can not be selected for Case No : ".$case_no
            //     ];
            //     echo json_encode($json);
            //     return false;
            // }

            //insertion in field_mut_pattadar
            if($cron_no == null || $cron_no == ''){
                $cron_no = 1;
            }
            else { $cron_no = $cron_no; }

            //insertion in field_mut_pattadar
            $data = [
                'dist_code' => $land->dist_code,
                'subdiv_code' => $land->subdiv_code,
                'cir_code' => $land->cir_code,
                'mouza_pargona_code' => $land->mouza_pargona_code,
                'lot_no' => $land->lot_no,
                'vill_townprt_code' => $land->vill_townprt_code,
                'year_no' => date('Y'),
                'petition_no' => $land->petition_no,
                'case_no' => $land->case_no,
                'dag_no' => $land->dag_no,
                'patta_no' => $land->patta_no,
                'patta_type_code' => $land->patta_type_code,
                'pdar_id' => $applicant_id,
                'pdar_cron_no' => $cron_no,
                'pdar_name' => $applicant_name,
                'pdar_guardian' => $guardian,
                'pdar_rel_guar' => $relation,
                'pdar_add1' => $address,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'striked_out' => $strike,
                'pdar_gender' => $gender,
                'pdar_minor_dob' => $dob
            ];
            $insFM = $this->db->insert($table, $data);
            if($insFM != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRFMSEC002: Insertion failed in $table 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRFMSEC002: Failed to add new Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            //insertion in basundhara_data_updation
            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $basuData=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundhara,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($data),
                );
                $basu_ins_FM = $this->db->insert('basundhara_data_updation', $basuData);
                if($basu_ins_FM != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMSEC003: Insertion failed in basundhara_data_updation 
                        for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERRFMSEC003: Failed to add new Second party for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            

            $this->db->trans_commit();

            //pattadar list
            $pattadarList = $this->mutationmodel->getSecondPartyPattadarList($dag, $pno, $ptype, $dist, $sub, $cir, $mouza, $lot, $vill, $case_no);

            //get second party detail
            $fm_second_party_get_details = $this->db->query("SELECT * FROM $table 
            WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? 
            AND patta_no=? AND patta_type_code=? ORDER BY pdar_cron_no ASC", 
            array($case_no, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pno, $ptype));

            $json = [
                'success' => 'true',
                'details' => $fm_second_party_get_details->result(),
                'pattadarList' => $pattadarList->result()
            ];
        }
        echo json_encode($json);
        return;
    }  // addAdditionalSecondPartyFM ends here
    //delete second party for field mutation
    public function deleteSecondPartyFM()
    {
        $json = null;
        $val = $this->input->post();
        $pid = $val['pid'];
        $dist = $val['dist'];
        $sub = $val['sub'];
        $cir = $val['cir'];
        $mouza = $val['mouza'];
        $lot = $val['lot'];
        $vill = $val['vill'];
        $dag = $val['dag'];
        $pno = $val['pno'];
        $ptype = $val['ptype'];
        $cron = $val['cron'];
        $case_no = $val['case_no'];
        $table = 'field_mut_pattadar';

        $append_FM = " dist_code='$dist' AND subdiv_code='$sub' AND cir_code='$cir' AND
        mouza_pargona_code='$mouza' AND lot_no='$lot' AND vill_townprt_code='$vill' 
        AND dag_no='$dag' AND patta_no='$pno' AND patta_type_code='$ptype' 
        AND case_no='$case_no'";

        $query = $this->db->query("SELECT petition_no FROM $table WHERE $append_FM");

        if($query->num_rows() == 1){ // one applicant available
            $json = [
                'message'=>"#ERRFMSEC004: All Second party can not be deleted...."
            ];
            echo json_encode($json);
            return false;
        }
        else
        {
            $this->db->trans_begin();
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            
            //get data to be deleted
            $old_data = $this->db->query("SELECT * FROM $table WHERE $append_FM AND pdar_id=? 
                AND pdar_cron_no=?", array($pid, $cron))->row();

            //insert into basundhara_data_updation
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );                    
            $insBasu=$this->db->insert('basundhara_data_updation', $data);
            if($insBasu != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRFMSEC005: Insertion failed in basundhara_data_updation 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRFMSEC005: Failed to delete Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            //delete second party from field_mut_pattadar
            $del = $this->db->query("DELETE FROM $table WHERE $append_FM AND pdar_id=? AND pdar_cron_no=?", array($pid, $cron));
            if($this->db->affected_rows() <= 0 && $del != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRFMSEC006: Deletion failed from $table 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRFMSEC006: Failed to delete Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;   
            }
        
            $this->db->trans_commit();

            //updated pattadar list in drop down to add
            $pattadarList = $this->mutationmodel->getSecondPartyPattadarList($dag, $pno, $ptype, $dist, $sub, $cir, $mouza, $lot, $vill, $case_no);

            //get second party detail
            $fm_second_party_get_details = $this->db->query("SELECT * FROM $table 
            WHERE $append_FM ORDER BY pdar_cron_no ASC");

            $json = [
                'success' => 'true',
                'details' => $fm_second_party_get_details->result(),
                'pattadarList' => $pattadarList->result(),
                'message' => 'Second Party has successfully deleted...'
            ];
        }
        echo json_encode($json);
        return;
    }//delete second party for field mutation ends here
    ////////////    06-04-22 field mutation second party add & delete ends here   /////////////



    ////////////    07-04-22 office mutation second party add & delete     /////////////
    //for loading data on pop up for second party add
    public function getSecondPartyApplicantDetailOM(){

        $val = $this->input->post();
        $table = 'field_mut_pattadar';

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();

        $details['sec_party'] = $this->mutationmodel->getSecondPartyPattadarListOM($val['dag'], $val['pno'], $val['ptype'], $val['dist'], $val['sub'], $val['cir'], $val['mouza'], $val['lot'], $val['vill'], $val['petition_no'])->result();

        echo json_encode($details);
        return;
    }
    //get pattadar's guardian detail
    public function getPattadarDetailsOfc(){
        
        $val = $this->input->post();
        
        $pattadar = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father,
        A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob
        FROM chitha_pattadar A
        JOIN chitha_dag_pattadar B
        ON
        A.dist_code=B.dist_code 
        AND A.subdiv_code=B.subdiv_code
        AND A.cir_code=B.cir_code
        AND A.mouza_pargona_code=B.mouza_pargona_code
        AND A.lot_no=B.lot_no
        AND A.vill_townprt_code=B.vill_townprt_code
        AND A.patta_no=B.patta_no
        AND A.patta_type_code=B.patta_type_code
        WHERE
        B.dag_no=? 
        AND B.p_flag!=?
        AND A.dist_code=? 
        AND A.subdiv_code=?
        AND A.cir_code=?
        AND A.mouza_pargona_code=?
        AND A.lot_no=?
        AND A.vill_townprt_code=?
        AND A.patta_no=?
        AND A.patta_type_code=? AND A.pdar_id=?", array($val['dag'], '1',
        $val['dist'], $val['sub'], $val['cir'], $val['mouza'], $val['lot'], 
        $val['vill'], $val['pn'], $val['ptype'], $val['id']))->row();

        $json['details'] = $pattadar;
        echo json_encode($json);
    }
    // addition of new second party for office mutation
    public function addAdditionalSecondPartyOM()
    {
        $addSecondPartyValidation = [
            [
                'field' => 'appl_sec_party_OM',
                'label' => 'Pattadar',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'guardian_name_sec_party_OM',
                'label' => 'Guardian Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'relation_sec_party_OM',
                'label' => 'Relation',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gender_sec_party_OM',
                'label' => 'Gender',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'dob_sec_party_OM',
                'label' => 'Date of Birth',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'address_sec_party_OM',
                'label' => 'Address',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'strikeout_sec_party_OM',
                'label' => 'Inplace/Alongwith',
                'rules' => 'trim|required|xss_clean|integer',
            ],
        ];
        $json= null;
        $this->form_validation->set_rules($addSecondPartyValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('addSecondPartyValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($addSecondPartyValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        } 
        else 
        {
            $table = 'petition_pattadar';
            $val = $this->input->post();
            $dob = date('Y-m-d', strtotime($val['dob_sec_party_OM']));
            $applicant_id = $val['appl_sec_party_OM'];
            $applicant_name = $val['applicant_name'];
            $guardian = $val['guardian_name_sec_party_OM'];
            $relation = $val['relation_sec_party_OM'];
            $gender = $val['gender_sec_party_OM'];
            $address = $val['address_sec_party_OM'];
            $strike = $val['strikeout_sec_party_OM'];
            $case_no = $val['case_no'];
            $dist = $val['dist'];
            $sub = $val['sub'];
            $cir = $val['cir'];
            $mouza = $val['mouza'];
            $lot = $val['lot'];
            $vill = $val['vill'];
            $dag = $val['dag'];
            $pno = $val['pn'];
            $ptype = $val['ptype'];

            $ar = explode('/', $case_no);
            $petition_no = $ar['3'];

            //get mutated and chitha land detail
            $petbasic = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $dist, $sub, $cir, $mouza, $lot))->row();

            $petition_no = $petbasic->petition_no;

            $land = $this->db->query("SELECT * FROM petition_dag_details WHERE 
            petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? 
            AND patta_no=? AND patta_type_code=?", array($petition_no, $dist, $sub, $cir, $mouza,
                $lot, $vill, $dag, $pno, $ptype))->row();

            $totalLand = ($land->dag_area_b*100)+($land->dag_area_k*20)+$land->dag_area_lc;
            $appliedLand = ($land->m_dag_area_b*100)+($land->m_dag_area_k*20)+$land->m_dag_area_lc;

            //get max cron number
            $cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no 
            FROM $table WHERE petition_no=? AND dist_code=? AND 
            subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND
            lot_no=? AND vill_townprt_code=? AND dag_no=? AND patta_no=? AND
            patta_type_code=?", array($petition_no, $dist, $sub, $cir, $mouza,
                $lot, $vill, $dag, $pno, $ptype))->row()->cron_no;

                        
            $this->db->trans_begin();

            //check if applied area is equal ro total area
            // if($totalLand == $appliedLand && $strike==0){
            //     $this->db->trans_rollback();
            //     log_message('error', '#ERROMSEC001: Both applied & total land area are same. Strikeout can`t be Alongwith for case no :'. $case_no);
            //     $json = [
            //         'message'=>"#ERROMSEC001: Applied and Total land area are same. Alongwith can not be selected for Case No : ".$case_no
            //     ];
            //     echo json_encode($json);
            //     return false;
            // }
           
            
            if ($cron_no == null || $cron_no == 0)
                $cron_no = 1;

            $data = array(
                'dist_code'=>$land->dist_code,
                'subdiv_code'=>$land->subdiv_code,
                'cir_code'=>$land->cir_code,
                'mouza_pargona_code'=>$land->mouza_pargona_code,
                'lot_no'=>$land->lot_no,
                'vill_townprt_code'=>$land->vill_townprt_code,
                'user_code'=>$this->session->userdata('user_code'),
                'petition_no'=>$land->petition_no,
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$land->dag_no,
                'patta_no'=>$land->patta_no,
                'patta_type_code'  => $land->patta_type_code ,
                'pdar_id' => $applicant_id,
                'pdar_cron_no' => $cron_no,
                'pdar_name' => $applicant_name,
                'pdar_guardian'=>$guardian,
                'pdar_rel_guar' => $relation,
                'striked_out' =>$strike,/////for inheritance//////
                'dag_no' =>$land->dag_no,                               
                'pdar_gender' => $gender,
                'pdar_add1' => $address,
                //'pdar_rel_guar' => 'f',
                //'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($land->dist_code,$pet->gurdian_relation_id),/////////////
                // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );

            $insOM = $this->db->insert($table, $data);
            if($insOM != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERROMSEC002: Insertion failed in $table 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERROMSEC002: Failed to add new Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            //insertion in basundhara_data_updation
            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $basuData=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundhara,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($data),
                );
                $basu_ins_OM = $this->db->insert('basundhara_data_updation', $basuData);
                if($basu_ins_OM != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMSEC003: Insertion failed in basundhara_data_updation 
                        for case no :'. $case_no);
                    $json = [
                        'message'=>"#ERROMSEC003: Failed to add new Second party for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            

            $this->db->trans_commit();

            //pattadar list
            $pattadarList = $this->mutationmodel->getSecondPartyPattadarListOM($dag, $pno, $ptype, $dist, $sub, $cir, $mouza, $lot, $vill, $petition_no);

            //get second party detail
            $om_second_party_get_details = $this->db->query("SELECT * FROM $table 
            WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? 
            AND patta_no=? AND patta_type_code=? ORDER BY pdar_cron_no ASC", 
            array($petition_no, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pno, $ptype));

            $json = [
                'success' => 'true',
                'details' => $om_second_party_get_details->result(),
                'pattadarList' => $pattadarList->result()
            ];
        }
        echo json_encode($json);
        return;
    }  // addAdditionalSecondPartyOM ends here
    //delete second party for field mutation
    public function deleteSecondPartyOM()
    {
        $json = null;
        $val = $this->input->post();
        $pid = $val['pid'];
        $dist = $val['dist'];
        $sub = $val['sub'];
        $cir = $val['cir'];
        $mouza = $val['mouza'];
        $lot = $val['lot'];
        $vill = $val['vill'];
        $dag = $val['dag'];
        $pno = $val['pno'];
        $ptype = $val['ptype'];
        $cron = $val['cron'];
        $case_no = $val['case_no'];

        $ar = explode('/', $case_no);
        $petition_no = $ar['3'];

        $table = 'petition_pattadar';

        $append_OM = " dist_code='$dist' AND subdiv_code='$sub' AND cir_code='$cir' AND
        mouza_pargona_code='$mouza' AND lot_no='$lot' AND vill_townprt_code='$vill' 
        AND dag_no='$dag' AND patta_no='$pno' AND patta_type_code='$ptype' 
        AND petition_no='$petition_no'";

        $query = $this->db->query("SELECT petition_no FROM $table WHERE $append_OM");

        if($query->num_rows() == 1){ // one applicant available
            $json = [
                'message'=>"#ERROMSEC004: All Second party can not be deleted...."
            ];
            echo json_encode($json);
            return false;
        }
        else
        {
            $this->db->trans_begin();
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            
            //get data to be deleted
            $old_data = $this->db->query("SELECT * FROM $table WHERE $append_OM AND pdar_id=? 
                AND pdar_cron_no=?", array($pid, $cron))->row();

            //insert into basundhara_data_updation
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );                    
            $insBasu=$this->db->insert('basundhara_data_updation', $data);
            if($insBasu != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERROMSEC005: Insertion failed in basundhara_data_updation 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRFMSEC005: Failed to delete Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            //delete second party from petition_pattadar
            $del = $this->db->query("DELETE FROM $table WHERE $append_OM AND pdar_id=? AND pdar_cron_no=?", array($pid, $cron));
            //echo $this->db->last_query();return;
            if($this->db->affected_rows() <= 0 && $del != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERROMSEC006: Deletion failed from $table 
                    for case no :'. $case_no);
                $json = [
                    'message'=>"#ERROMSEC006: Failed to delete Second party for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;   
            }
        
            $this->db->trans_commit();

            //updated pattadar list in drop down to add
            $pattadarList = $this->mutationmodel->getSecondPartyPattadarListOM($dag, $pno, $ptype, $dist, $sub, $cir, $mouza, $lot, $vill, $petition_no);

            //get second party detail
            $om_second_party_get_details = $this->db->query("SELECT * FROM $table 
            WHERE $append_OM ORDER BY pdar_cron_no ASC");

            $json = [
                'success' => 'true',
                'details' => $om_second_party_get_details->result(),
                'pattadarList' => $pattadarList->result(),
                'message' => 'Second Party has successfully deleted...'
            ];
        }
        echo json_encode($json);
        return;
    }//delete second party for office mutation ends here
    ////////////    07-04-22 office mutation second party add & delete ends here   /////////////
    function reclassBasuReport(){
        $case_no=$this->input->get('app');
        $sql="Select dharitree from basundhar_application where basundhara='$case_no' "; 
        $data=$this->db->query($sql)->num_rows();
        if($data>0){
            $dharitree=$this->db->query($sql)->row();
            $send['case']=array('basundhara'=>$case_no,'dharitree'=>$dharitree->dharitree);
            $sql="select * from t_reclassification where case_no='$dharitree->dharitree'";
            $pro=$this->db->query($sql)->num_rows();
            if($pro>0){
                $send['result']= $this->db->query($sql)->row_array();
            }else{
                $send['result']=array();
            }
            $this->load->view('lmmutation/rejectReportreclass',$send);
        }else{
            echo "No Report Found";
        }
    }

    public function writeofficereportNew(){
            //xss & security validation starts
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST,array(),array(),array('report_on_possession' => true));
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            $resp = checkRequestValidQuery($_POST,array(),array('report_on_possession' => true));
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }  
            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
           }
                //xss & security validation ends 
            $db=  $this->session->userdata('db');
            $data = array();
            foreach ($_POST as $key => $value){
                $data[$key] = $value;
            }
            $case_no=$data['case_no'];
            unset($data['case_no']);
            unset($data['pda_id_new']);
            unset($data['pda_name_new']);
            unset($data['striked_out']);
            unset($data['executionDate']);
            unset($data['esc_remark']);
            $tokenName=$this->security->get_csrf_token_name();
            unset($data[$tokenName]);
            $this->db->trans_begin();
            $trans_code_new = $this->input->post('trans_code');
            $m_dag_area_b = $this->input->post('mut_b');
            $m_dag_area_k = $this->input->post('mut_k');
            $m_dag_area_lc = $this->input->post('mut_lc');
            $m_dag_area_g = $this->input->post('mut_g');
            $m_dag_area_kr = $this->input->post('mut_kr');
            $petition_no = $this->input->post('petition_no');
            $q = "update petition_dag_details set m_dag_area_b='$m_dag_area_b', m_dag_area_k=$m_dag_area_k,"
                    . " m_dag_area_lc=$m_dag_area_lc, m_dag_area_g=$m_dag_area_g,m_dag_area_kr=$m_dag_area_kr where"
                    . " petition_no = $petition_no and $this->base_query";
            $this->db->query($q);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', "#OMUT001: Updation failed in table petition_dag_details with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Updation failed(#OMUT001)");
                redirect(base_url() . "index.php/home");
            }
            $data['lm_code'] = $this->session->userdata('user_code');
            $data['user_code'] = $this->session->userdata('user_code');
            $data['lm_sign_yn'] = 'Y';
            $data['operation'] = 'E';
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['year_no'] = year_no;
            $note_no = $this->db->query("select count(note_no)+1 as note_no from  petition_lm_note where "
                            . " petition_no=$petition_no and $this->base_query")->row()->note_no;
            $data['note_no'] = $note_no;
            $data['lm_sign_date'] = date('Y-m-d G:i:s');
            ////var_dump($data);
            $statusInsert = $this->db->insert("petition_lm_note", $data);
            if($statusInsert != 1)
            {
                $this->db->trans_rollback();
                log_message('error', "#OMUT002: Insertion failed in table petition_lm_note with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Insertion failed(#OMUT002)");
                redirect(base_url() . "index.php/home");
            }

           $proInsert = $this->mutationmodel->proceeding_order($case_no,$data['report_on_possession']);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OMUTLM001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUTLM001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  petition_basic where "
                            . " petition_no=$petition_no and $this->base_query")->row();
            if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 ){
                $updateLmNote = "update petition_basic set trans_code='$trans_code_new', sk_comment='Y',lm_note_yn='Y',lm_note_date='" . date('Y-m-d H:i:s') . "'  where petition_no = $petition_no and $this->base_query";
            }
            else
            {
                $updateLmNote = "update petition_basic set trans_code='$trans_code_new', lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
                . " where petition_no = $petition_no and $this->base_query";
            }
            $this->db->query($updateLmNote);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', "#OMUT003: Updation failed in table petition_basic with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Updation failed(#OMUT003)");
                redirect(base_url() . "index.php/home");
            }

            $case_no = $this->input->post('case_no');

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $es_flag_data->out_of_esc == 0)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROMUTESCREMARK4571 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================


            //Started functionality of inplace/alongwith data submission 26122022-----
            $pdar_id_new = $this->input->post('pda_id_new');
            $pda_name_new = $this->input->post('pda_name_new');
            $striked_out = $this->input->post('striked_out');
            $this->load->model('patta/PattaModel');
            $pattadarCount = $this->PattaModel->getPattadarOffice($case_no)->result();
            
            if(count($pattadarCount) != count($pdar_id_new)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Pattadar details not matched.(#OMUT005)");
                redirect(base_url() . "index.php/home");
            }
            if(count($pdar_id_new) == null || count($pdar_id_new) == '' || empty($pdar_id_new)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUT004)");
                redirect(base_url() . "index.php/home");
            }else{
                for ($i=0; $i < count($pdar_id_new) ; $i++) {
                    if($striked_out[$i] == null || $striked_out[$i] == ''){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Please select inplace/alogwith against each pattadar");
                        redirect(base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$case_no);
                    }
                    $pdarIdNew = $pdar_id_new[$i];
                    $pdarName = $pda_name_new[$i];
                    $strikeOut = $striked_out[$i];
                    if ($strikeOut == '1') {
                        $query = "update petition_pattadar set striked_out ='1' where"
                            . " petition_no=$petition_no and pdar_id=$pdarIdNew and $this->base_query";
                    } else if ($strikeOut == '0') {
                        $query = "update petition_pattadar set striked_out ='0' "
                                . "where petition_no=$petition_no and pdar_id=$pdarIdNew and $this->base_query";
                    }
                    $this->db->query($query);
                    if($this->db->affected_rows() != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', $this->db->last_query()."#OMUT006");
                        $this->session->set_flashdata('message', "Updation failed(#OMUT006)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }

            //end functionality----------
            //////////
            $penUser='SK';
            $rmrk='Report Submitted by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ////////////////////
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist)
            {

                $es_flag = $this->db->query("select es_flag from  petition_basic where "
                            . " petition_no=$petition_no and $this->base_query")->row()->es_flag;
                if($es_flag == 1 && ESCALATION_ENABLE == 1){
                    $rmk='Forwarded to CO';
                    $status='M';
                    $task='LM';
                    $pen='CO';
                    $case=$case_no;
                }
                else
                {
                    $rmk='Forwarded to SK';
                    $status='M';
                    $task='LM';
                    $pen='SK';
                    $case=$case_no;
                }
                
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{

                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                //ESCALATION CODE INTEGRATION================SANMRI
                $es_flag_data = $this->db->query("select es_flag,out_of_esc,proceeding_yn,next_date_of_hearing from  petition_basic where "
                            . " petition_no=$petition_no and $this->base_query")->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0)
                {
                    $user_code = $this->session->userdata('user_code');
                    $executionDate = $this->input->post('executionDate');
                    $service_code = 1;
                    $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                    $serviceType = explode('/',$basundharaExist);
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }
                    ///check action taken happen or not/////
                    ///if not then executionDate will be the assigned date otherwise hearing date will be assigned date///
                    if($es_flag_data->proceeding_yn == '1')
                    {
                        $executionDate = date('Y-m-d H:i:s');
                    }
                    else
                    {
                        $executionDate = $es_flag_data->next_date_of_hearing;
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationLMReport($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);


                    log_message("error", "#ESC5907, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC5907, transaction-error in method 'officemutation/writeofficereportNew' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC5907)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }
                if($basundharaExist)
                {
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }
                $this->db->trans_commit();
                $this->session->set_flashdata("message","LM Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");    
                
                
            }
            ///////////////////
        
    }
    // Added By Abhijit -- 2024-04-24
    public function writeofficereportNewMultiDag(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('report_on_possession' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('report_on_possession' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }  
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        $db=  $this->session->userdata('db');
        $data = array();
        foreach ($_POST as $key => $value){
            $data[$key] = $value;
        }
        
        $case_no = $this->input->post('case_no');
        unset($data['case_no']);
        unset($data['pda_id_new']);
        unset($data['pda_name_new']);
        unset($data['striked_out']);
        unset($data['pdar_dag']);
        $tokenName = $this->security->get_csrf_token_name();
        unset($data[$tokenName]);

        $query = "select * from  petition_basic where case_no='$case_no' and $this->append";
        $petition = $this->db->query($query)->row();
        
        if(!$petition){
            $this->session->set_flashdata('message',"No such case found.");
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if($petition->is_multidag != 'Y'){
            $this->session->set_flashdata('message',"This service is inactive for now.");
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $petition_no = $petition->petition_no;
        $dags_query = "select * from  petition_dag_details where petition_no=$petition_no and $this->append";
        $dags = $this->db->query($dags_query)->result();
        // ######## ~~~~


        $this->db->trans_begin();
        $trans_code_new = $this->input->post('trans_code_new');
        $m_dag_area_b = $this->input->post('mut_b');
        $m_dag_area_k = $this->input->post('mut_k');
        $m_dag_area_lc = $this->input->post('mut_lc');
        $m_dag_area_g = $this->input->post('mut_g');
        $m_dag_area_kr = $this->input->post('mut_kr');

        // $petition_no = $this->input->post('petition_no');

        foreach($dags as $key => $petition_dag_detail){
            $q = "update petition_dag_details set m_dag_area_b=?, m_dag_area_k=?,"
                    . " m_dag_area_lc=?, m_dag_area_g=?,m_dag_area_kr=? where"
                    . " petition_no = ? and id = ? and $this->base_query";
            $this->db->query($q, array($m_dag_area_b[$key], $m_dag_area_k[$key], $m_dag_area_lc[$key], $m_dag_area_g[$key], $m_dag_area_kr[$key], $petition_no, $petition_dag_detail->id));
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', "#MUTDOMUT001: Updation failed in table petition_dag_details with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Updation failed(#MUTDOMUT001)");
                redirect(base_url() . "index.php/home");
            }
        }
        $data['petition_no'] = $petition_no;
        $data['lm_code'] = $this->session->userdata('user_code');
        $data['user_code'] = $this->session->userdata('user_code');
        $data['lm_sign_yn'] = 'Y';
        $data['operation'] = 'E';
        $data['date_entry'] = date('Y-m-d G:i:s');
        $data['year_no'] = year_no;
        $data['lm_sign_date'] = date('Y-m-d G:i:s');

        $pet_lm_note_data = $data;
        foreach($data['dag_no'] as $key => $pet_lm_note){
            $pet_lm_note_data['dag_no'] = $data['dag_no'][$key];
            $pet_lm_note_data['mut_b'] = $data['mut_b'][$key];
            $pet_lm_note_data['mut_k'] = $data['mut_k'][$key];
            $pet_lm_note_data['mut_lc'] = $data['mut_lc'][$key];
            $pet_lm_note_data['mut_g'] = $data['mut_g'][$key];
            $pet_lm_note_data['mut_kr'] = $data['mut_kr'][$key];
            $pet_lm_note_data['area_left_b'] = $data['area_left_b'][$key];
            $pet_lm_note_data['area_left_k'] = $data['area_left_k'][$key];
            $pet_lm_note_data['area_left_lc'] = $data['area_left_lc'][$key];
            $pet_lm_note_data['area_left_g'] = $data['area_left_g'][$key];
            $pet_lm_note_data['area_left_kr'] = $data['area_left_kr'][$key];
            
            $note_no = $this->db->query("select count(note_no)+1 as note_no from  petition_lm_note where "
                            . " petition_no=$petition_no and $this->base_query")->row()->note_no;
            $pet_lm_note_data['note_no'] = $note_no;

            ////var_dump($data);
            $statusInsert = $this->db->insert("petition_lm_note", $pet_lm_note_data);
            if($statusInsert != 1)
            {
                $this->db->trans_rollback();
                log_message('error', "#MUTDOMUT002: Insertion failed in table petition_lm_note with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Insertion failed(#MUTDOMUT002)");
                redirect(base_url() . "index.php/home");
            }
            
        }

        $proInsert = $this->mutationmodel->proceeding_order($case_no,$data['report_on_possession']);

        if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#MUTDOMUTLM001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MUTDOMUTLM001)".$case_no);
            redirect(base_url() . "index.php/home");
        }


        $updateLmNote = "update petition_basic set trans_code='$trans_code_new', lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
                . " where petition_no = $petition_no and case_no = '$case_no' and $this->base_query";
        $this->db->query($updateLmNote);
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', "#MUTDOMUT003: Updation failed in table petition_basic with petition-no :". $petition_no);
            log_message('error', $this->db->last_query());
            $this->session->set_flashdata('message', "Updation failed(#MUTDOMUT003)");
            redirect(base_url() . "index.php/home");
        }

        //Started functionality of inplace/alongwith data submission 26122022-----
        $pdar_id_new = $this->input->post('pda_id_new');
        $pdar_dag = $this->input->post('pdar_dag');
        $pda_name_new = $this->input->post('pda_name_new');
        $striked_out = $this->input->post('striked_out');
        $this->load->model('patta/PattaModel');
        $pattadarCount = $this->PattaModel->getPattadarOfficeMultiDag($case_no);
        
        if(count($pattadarCount) != count($pdar_id_new)){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Pattadar details not matched.(#MUTDOMUT005)");
            redirect(base_url() . "index.php/home");
        }
        if(count($pdar_id_new) == null || count($pdar_id_new) == '' || empty($pdar_id_new)){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MUTDOMUT004)");
            redirect(base_url() . "index.php/home");
        }else{
            for ($i=0; $i < count($pdar_id_new) ; $i++) {
                if($striked_out[$i] == null || $striked_out[$i] == ''){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Please select inplace/alogwith against each pattadar");
                    redirect(base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$case_no);
                }
                $pdarIdNew = $pdar_id_new[$i];
                $pdarName = $pda_name_new[$i];
                $strikeOut = $striked_out[$i];
                $strk_dag = $pdar_dag[$i];
                if ($strikeOut == '1') {
                    // $query = "update petition_pattadar set striked_out ='1' "
                    //     . "where petition_no='$petition_no' and pdar_id='$pdarIdNew' and $this->base_query";
                    $query = "update petition_pattadar set striked_out ='1' "
                        . "where petition_no='$petition_no' and pdar_id='$pdarIdNew' and dag_no='$strk_dag' and $this->base_query";
                } else if ($strikeOut == '0') {
                    // $query = "update petition_pattadar set striked_out ='0' "
                    //     . "where petition_no='$petition_no' and pdar_id='$pdarIdNew'    and $this->base_query";
                    $query = "update petition_pattadar set striked_out ='0' "
                        . "where petition_no='$petition_no' and pdar_id='$pdarIdNew' and dag_no='$strk_dag' and $this->base_query";
                }
                $this->db->query($query);
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', $this->db->last_query()."#MUTDOMUT006");
                    $this->session->set_flashdata('message', "Updation failed(#MUTDOMUT006)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        
        //end functionality----------


        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        //ESCALATION CODE INTEGRATION================SANMRI
        $es_flag = $this->db->query("select es_flag from  petition_basic where petition_no=$petition_no and $this->base_query")->row()->es_flag;
        if($es_flag == 1 && ESCALATION_ENABLE == 1){
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            $service_code = 1;
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $serviceType = explode('/',$basundharaExist);
            if($serviceType[1] == 'MUTD')
            {
                $service_code = 2;
            }
            $escalationUpdateStatus = $this->Escalationmodel->escalationLMReport($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);


            log_message("error", "#ESC5907, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message("error", "#ESC5907, transaction-error in method 'officemutation/writeofficereportNew' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC5907)");
                redirect(base_url() . "index.php/home");
            }
            ///////////////END ESCALATION//////////////
        }


        //////////
        $penUser='SK';
        $rmrk='Report Submitted by LM';
        $this->DashboardData($case_no,$penUser,$rmrk);
        ////////////////////
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $rmk='Forwarded to SK';
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Something went wrong");
            redirect(base_url() . "index.php/home");
        }else{
            $this->db->trans_commit();
                $this->session->set_flashdata("message","LM Report Submitted Successfully...");
            redirect(base_url() . "index.php/home");
        }
        ///////////////////
    }

    public function writeofficereportMultiGen()
    {
            //xss & security validation starts
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST,array(),array(),array('report_on_possession' => true));
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            $resp = checkRequestValidQuery($_POST,array(),array('report_on_possession' => true));
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }  
            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            $db=  $this->session->userdata('db');
            $data = array();
            foreach ($_POST as $key => $value){
                $data[$key] = $value;
            }
            unset($data['case_no']);
            unset($data['pda_id_new']);
            unset($data['pda_name_new']);
            unset($data['striked_out']);
            unset($data['dag_no']);
            unset($data['mut_b']);
            unset($data['mut_k']);
            unset($data['mut_lc']);
            unset($data['mut_g']);
            unset($data['mut_kr']);
            $tokenName = $this->security->get_csrf_token_name();
            unset($data[$tokenName]);

            $this->db->trans_begin();
            $trans_code_new = $this->input->post('trans_code_new');
            $m_dag_area_b = $this->input->post('mut_b');
            $m_dag_area_k = $this->input->post('mut_k');
            $m_dag_area_lc = $this->input->post('mut_lc');
            $m_dag_area_g = $this->input->post('mut_g');
            $m_dag_area_kr = $this->input->post('mut_kr');

            $area_left_b = $this->input->post('area_left_b');
            $area_left_k = $this->input->post('area_left_k');
            $area_left_lc = $this->input->post('area_left_lc');
            $area_left_g = $this->input->post('area_left_g');
            $area_left_kr = $this->input->post('area_left_kr');

            $case_no = $this->input->post('case_no');

            $petition_no = $this->input->post('petition_no');
            $dag_no_list = $this->input->post('dag_no');
            for ($j=0; $j < count($dag_no_list) ; $j++) { 
               
                $q = "update petition_dag_details set m_dag_area_b=?, m_dag_area_k=?,"
                        . " m_dag_area_lc=?, m_dag_area_g=?,m_dag_area_kr=? where"
                        . " petition_no = ?  and dag_no = ? and $this->base_query";
                $this->db->query($q,array($m_dag_area_b[$j],$m_dag_area_k[$j],$m_dag_area_lc[$j],$m_dag_area_g[$j],$m_dag_area_kr[$j],$petition_no,$dag_no_list[$j]));
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMUT001: Updation failed in table petition_dag_details with petition-no :". $petition_no);
                    log_message('error', $this->db->last_query());
                    $this->session->set_flashdata('message', "Updation failed(#OMUT001)");
                    redirect(base_url() . "index.php/home");
                }
            }

            $data['lm_code'] = $this->session->userdata('user_code');
            $data['user_code'] = $this->session->userdata('user_code');
            $data['lm_sign_yn'] = 'Y';
            $data['operation'] = 'E';
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['year_no'] = year_no;
            $note_no = $this->db->query("select count(note_no)+1 as note_no from  petition_lm_note where "
                            . " petition_no=$petition_no and $this->base_query")->row()->note_no;
            $data['note_no'] = $note_no;
            $data['lm_sign_date'] = date('Y-m-d G:i:s');


            for ($k=0; $k < count($dag_no_list) ; $k++)
            { 
                unset($data['executionDate']);
                $data['dag_no'] = $dag_no_list[$k];
                $data['mut_b'] = $m_dag_area_b[$k];
                $data['mut_k'] = $m_dag_area_k[$k];
                $data['mut_lc'] = $m_dag_area_lc[$k];
                $data['mut_g'] = $m_dag_area_g[$k];
                $data['mut_kr'] = $m_dag_area_kr[$k];
                
                $data['area_left_b'] = $area_left_b[$k];
                $data['area_left_k'] = $area_left_k[$k];
                $data['area_left_lc'] = $area_left_lc[$k];
                $data['area_left_g'] = $area_left_g[$k];
                $data['area_left_kr'] = $area_left_kr[$k];

                $statusInsert = $this->db->insert("petition_lm_note", $data);
                if($statusInsert != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMUT002: Insertion failed in table petition_lm_note with petition-no :". $petition_no);
                    log_message('error', $this->db->last_query());
                    $this->session->set_flashdata('message', "Insertion failed(#OMUT002)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }
            
            // ~~~~~~~
            // $updateLmNote = "update petition_basic set lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
            //         . " where petition_no = $petition_no and case_no = '$case_no' and $this->base_query";
            // $this->db->query($updateLmNote);
            // if($this->db->affected_rows() != 1)
            // {
            //     $this->db->trans_rollback();
            //     log_message('error', "#MULGENOMUT003: Updation failed in table petition_basic with petition-no :". $petition_no);
            //     log_message('error', $this->db->last_query());
            //     $this->session->set_flashdata('message', "Updation failed(#MULGENOMUT003)");
            //     redirect(base_url() . "index.php/home");
            // }


            $proInsert = $this->mutationmodel->proceeding_order($case_no,$data['report_on_possession']);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OMUTLMMULTIGEN001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUTLMMULTIGEN001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            $es_flag = $this->db->query("select es_flag from  petition_basic where "
                            . " petition_no=$petition_no and $this->base_query")->row()->es_flag;
            if($es_flag == 1 && ESCALATION_ENABLE == 1){
                $updateLmNote = "update petition_basic set trans_code ='$trans_code_new',sk_comment='Y',lm_note_yn='Y',lm_note_date='" . date('Y-m-d H:i:s') . "'  where petition_no = $petition_no and $this->base_query";
            }
            else
            {
                $updateLmNote = "update petition_basic set trans_code ='$trans_code_new',lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
                . " where petition_no = $petition_no and $this->base_query";
            }
            $this->db->query($updateLmNote);
            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                log_message('error', "#OMUTMULTIGEN003: Updation failed in table petition_basic with petition-no :". $petition_no);
                log_message('error', $this->db->last_query());
                $this->session->set_flashdata('message', "Updation failed(#OMUTMULTIGEN003)");
                redirect(base_url() . "index.php/home");
            }

            $case_no = $this->input->post('case_no');

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $es_flag == 1 && ESCALATION_REMARK_ENABLE ==1)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROMUTESCREMARKMULTIGEN4571 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================

            //Started functionality of inplace/alongwith data submission 26122022-----
            $pdar_id_new = $this->input->post('pda_id_new');
            $pda_name_new = $this->input->post('pda_name_new');
            $striked_out = $this->input->post('striked_out');
            $this->load->model('patta/PattaModel');
            $pattadarCount = $this->PattaModel->getPattadarOfficeForMultiGen($case_no);
            
            if(count($pattadarCount) != count($pdar_id_new)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Pattadar details not matched.(#OMUT005)");
                redirect(base_url() . "index.php/home");
            }
            if(count($pdar_id_new) == null || count($pdar_id_new) == '' || empty($pdar_id_new)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUT004)");
                redirect(base_url() . "index.php/home");
            }else{
                for ($i=0; $i < count($pdar_id_new) ; $i++) {
                    if($striked_out[$i] == null || $striked_out[$i] == ''){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Please select inplace/alogwith against each pattadar");
                        redirect(base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$case_no);
                    }
                    $pdarIdNew = $pdar_id_new[$i];
                    $pdarName = $pda_name_new[$i];
                    $strikeOut = $striked_out[$i];
                    $dag_no_pt  = $dag_no_list[$i];
                    if ($strikeOut == '1') {
                        $query = "update petition_pattadar set striked_out ='1' where"
                            . " petition_no=$petition_no and dag_no = '$dag_no_pt' and pdar_id=$pdarIdNew and $this->base_query";
                    } else if ($strikeOut == '0') {
                        $query = "update petition_pattadar set striked_out ='0' "
                                . "where petition_no=$petition_no and  dag_no = '$dag_no_pt' and pdar_id=$pdarIdNew and $this->base_query";
                    }
                    $this->db->query($query);
                    if($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', $this->db->last_query()."#OMUT006");
                        $this->session->set_flashdata('message', "Updation failed(#OMUT006)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }

            //end functionality----------

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            //ESCALATION CODE INTEGRATION================SANMRI
            $es_flag = $this->db->query("select es_flag from  petition_basic where "
                        . " petition_no=$petition_no and $this->base_query")->row()->es_flag;
            if($es_flag == 1 && ESCALATION_ENABLE == 1){
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                $service_code = 1;
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                $serviceType = explode('/',$basundharaExist);
                if($serviceType[1] == 'MUTD')
                {
                    $service_code = 2;
                }
                $escalationUpdateStatus = $this->Escalationmodel->escalationLMReport($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);


                log_message("error", "#ESC5907, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC5907, transaction-error in method 'officemutation/writeofficereportNew' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC5907)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }
            //////////
            $penUser='SK';
            $rmrk='Report Submitted by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ////////////////////
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $rmk='Forwarded to SK';
                $status='M';
                $task='LM';
                $pen='SK';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","S001 : LM Report Submitted Successfully for the case no=".$case_no);
                redirect(base_url() . "index.php/home");
            }
            ///////////////////
        
    }

     public function proreportOpart() {
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $query = "select * from petition_proceeding where case_no='$case_no'";
        $details = $this->db->query($query)->result();
        $data['details'] = $details;
        $this->load->helper('html');
        //$this->load->view('../views/lmmutation/proreport', $data);

        $data['_view'] = 'lmmutation/proreport';
        $this->load->view('layouts/main',$data);
    }
}
