<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AsistantConversionMb extends CI_Controller {

    public function __construct() {
        parent::__construct();

         // Allowed designations
        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->helper(array('form', 'url'));
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('v2/PetitionBasicModel');
        $this->load->model('v2/PetitionProceedingModel');
        $this->load->model('v2/Services/Conversion/ConversionModel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('v2/BasundharApplicationModel');
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
		//$db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/asist_mutation');
        $this->load->view('../views/footer');
    }

    public function GoToAST() {
		//$db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $this->load->library('pagination');
        $process = $this->input->get('pro');

        if ($process == '1') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingNoticeGeneratedASTMb3($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingNoticeGeneratedASTMb3($user_code)->result();
        } elseif ($process == '2') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingActionTakenASTMb3($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingActionTakenASTMb3($user_code)->result();
        } elseif ($process == '3') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingPremiumAST($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingPremiumAST($user_code)->result();
        } elseif ($process == '4') {
            $config['total_rows'] = $this->ASTofficeConversionModel->countPendingPaymentAST($user_code);
            $cases['cases'] = $this->ASTofficeConversionModel->getPendingPaymentAST($user_code)->result();
        }

        $cases['process'] = $process;
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/ast_conversion_cases', $cases);
        //$this->load->view('../views/footer');
        $cases['_view'] = 'asstofficeconversion/ast_conversion_cases_mb';
        $this->load->view('layouts/main',$cases);

    }

    public function Conversion() {
        if(RTPS_CERT_ON_OFF=='1'){ 
            $this->session->set_flashdata('message', 'Not Authorised');
            redirect(base_url() . "index.php/home/index");
            return; 
        }
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        //$this->load->view('../views/header');
       //$this->load->view('../views/asstofficeconversion/select_location', $district);
        //$this->load->view('../views/footer');
        $district['_view'] = 'asstofficeconversion/select_location';
        $this->load->view('layouts/main',$district);

    }

    public function ConvertionType() {
		//$db=  $this->session->userdata('db');
        $convertions = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'required|isset');
        $this->form_validation->set_rules('mouza_code', 'Mouza Paragona Code', 'required|isset');
        if ($this->form_validation->run() == FALSE) {
            $this->Conversion();
        } else {
            $convertion_code = CONVERSION_CODE;
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $locationData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'convertion_code' => $convertion_code,
            );
            $this->session->set_userdata($locationData);
         $q = $this->db->query("select * from  users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (user_desig_code='CO' or user_desig_code='ASO')");
            $c = $q->result();

            foreach ($c as $x) {
              $users = "Select user_code as user_c from  loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";


                $select = $this->db->query($users)->row();

                

                if (@count($select) == '1') {
                    $convertions[] = array(
                        'co_name' => $x->username,
                        'user_desig_code' => $x->user_desig_code,
                        'user_code' => $select->user_c
                    );
                    $convertion['user'] = $convertions;
                }

                $convertion['user'] = $convertions;
            }
            $convertion['location'] = $locationData;

            $convertion['patta_conv_type'] = $this->db->query("SELECT * FROM   patta_code where conversion ='y'")->result();

            $convertion['type'] = $this->mutationmodel->getConvertionPattaType();
            //$this->load->view('../views/header');
           // $this->load->view('../views/asstofficeconversion/mutationtype', $convertion);
            //$this->load->view('../views/footer');

            $convertion['_view'] = 'asstofficeconversion/mutationtype';
            $this->load->view('layouts/main',$convertion);
        }
    }

    public function getDesignationTypeJSON($user_code) {
		  $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data = $this->db->query("select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code='$user_code'");
        $data = $data->result();
        foreach ($data as $d) {
            $designation1 = $d->user_desig_code;
            if ($designation1 == 'CO') {
                $designation = "Circle Officer ( চক্ৰ বিষয়া  )";
            } else if ($designation1 == 'ASO') {
                $designation = "সহকাৰী বন্দবস্তী প্ৰাধিকৰী ";
            }
        }
        echo json_encode($designation);
    }

    public function getConvertionPattaTypeJSON() {
		  $db=  $this->session->userdata('db');
        $data = $this->mutationmodel->getConvertionPattaType();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
        }
        echo json_encode($json);
    }

    public function saveConvertionTrnsfrDetails() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->input->post());
		//var_dump($this->session->all_userdata());
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $mut_type = $this->session->userdata('convertion_code');

        $add_of_co_code = $this->input->post('add_of_co_code');
        $name_of_co = $this->db->query("select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
		cir_code='$cir_code' and user_code='$add_of_co_code'")->row();
        $co_name = $name_of_co->username;
        $add_of_desig = $name_of_co->user_desig_code;
        $patta_no = trim($this->input->post('patta_no'));
        $patta_type = $this->input->post('patta_type');


        $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type' => $patta_type));
        $this->session->set_userdata(array('add_of_name' => $co_name, 'add_of_desig' => $add_of_desig, 'add_of_co_code' => $add_of_co_code));

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'mut_type' => $mut_type,
            'patta_type' => $patta_type,
            'patta_no' => $patta_no,
            'add_off_name' => $co_name,
            'add_off_desig' => $add_of_desig,
            //'petition_no' => $petition_no,
            //'case_no' => $case_no,
            'user_code' => $user_code,
            'operation' => 'E'
        );

        $this->load->model('relation/relationmodel');
        $data['relation'] = $this->relationmodel->getRelations();
        $this->load->model('patta/PattaModel');

        $data['dags'] = $this->PattaModel->getDagsByPattaNoConversion($patta_no, $patta_type, $dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code)->result();

        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/mutationlandarea', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'asstofficeconversion/mutationlandarea';
        $this->load->view('layouts/main',$data);
    }

    public function pattadarDetails() {
		$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $location = $this->utilityclass->getLocationFromSession();
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $dag_area_b = $this->input->post('dag_area_b');
        $dag_area_k = $this->input->post('dag_area_k');
        $dag_area_lc = $this->input->post('dag_area_lc');
        $applied_b = $this->input->post('m_dag_area_b');
        $applied_k = $this->input->post('m_dag_area_k');
        $applied_lc = $this->input->post('m_dag_area_lc');
        $applied_b_P = $this->input->post('m_dag_area_b_P');
        $applied_k_P = $this->input->post('m_dag_area_k_P');
        $applied_lc_P = $this->input->post('m_dag_area_lc_P');
        $left_b = $this->input->post('l_dag_area_b');
        $left_k = $this->input->post('l_dag_area_k');
        $left_lc = $this->input->post('l_dag_area_lc');
        $left_b_P = $this->input->post('l_dag_area_b_P');
        $left_k_P = $this->input->post('l_dag_area_k_P');
        $left_lc_P = $this->input->post('l_dag_area_lc_P');
        $PartialOrFull = $this->input->post('PartialOrFull');
        $land_valuation = $this->input->post('land_valuation');

        $this->session->set_userdata(array('dag_area_b' => $dag_area_b, 'dag_area_k' => $dag_area_k, 'dag_area_lc' => $dag_area_lc));
        $this->session->set_userdata(array('m_dag_area_b' => $applied_b, 'm_dag_area_k' => $applied_k, 'm_dag_area_lc' => $applied_lc));
        $this->session->set_userdata(array('m_dag_area_b_P' => $applied_b_P, 'm_dag_area_k_P' => $applied_k_P, 'm_dag_area_lc_P' => $applied_lc_P));
        $this->session->set_userdata(array('l_dag_area_b' => $left_b, 'l_dag_area_k' => $left_k, 'l_dag_area_lc' => $left_lc));
        $this->session->set_userdata(array('l_dag_area_b_P' => $left_b_P, 'l_dag_area_k_P' => $left_k_P, 'l_dag_area_lc_P' => $left_lc_P));
        $user_code = $this->session->userdata('user_code'); // should come from    session user designation code
        $date_entry = date('Y-m-d H:i:s');
        $operation = 'E';
        $year_no = date('Y');

        $this->session->set_userdata(array('date_entry' => $date_entry, 'land_valuation' => $land_valuation));
        $data = array();
        foreach ($_POST as $k => $v) {
            $data[$k] = $v;
        }
		$this->session->set_userdata('post',$data);
        $dag_no = $data['dag_no'];
        $this->session->set_userdata(array('dag_no' => $dag_no, 'user_code' => $user_code, 'operation' => $operation, 'year_no' => $year_no));


        $other = array(
            //'case_no' => $case_no, 
            //'petition_no' => $petition_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'operation' => $operation,
            'year_no' => $year_no,
            'Conversion_type' => $PartialOrFull
        );
        $merged = array_merge($other, $location, $data);
		
        if ($PartialOrFull == 'Y') {
            redirect(base_url() . "index.php/AsistantConversionMb_remove/pattadarselectOnFullPartition");
        } else {
            if (($left_b == $left_b_P) and ( $left_k == $left_k_P) and ( $left_lc == $left_lc_P)) {
                redirect(base_url() . "index.php/AsistantConversionMb_remove/pattadarselectOnFullPartition");
            }
            redirect(base_url() . "index.php/AsistantConversionMb_remove/pattadarselect");
        }
    }

    public function pattadarselectOnFullPartition() {
		//var_dump($this->session->all_userdata());
		//$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $mut_type = $this->session->userdata('convertion_code');
        //$this->session->set_userdata('patta_type_code' , $patta_type_code);

        $q1 = "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
                . "and p.patta_type_code='$patta_type_code' and p.pdar_id in(select pdar_id from    chitha_dag_pattadar p where p.dist_code='$dist_code' and "
                . "p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' "
                . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type_code' and (p_flag is null or p_flag='0') and dag_no = '$dag_no')";

        $data = $this->db->query($q1)->result();
        $pattadar = $data;
        $data['pdtails'] = $data;

        //$this->session->set_userdata('pattadar', $pattadar);
        $this->load->model('relation/relationmodel');
        $data['relation'] = $this->relationmodel->getRelations();
        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/pattadardetailsOnFullConversion', $data);
        //$this->load->view('../views/footer');


        $data['_view'] = 'asstofficeconversion/pattadardetailsOnFullConversion';
        $this->load->view('layouts/main',$data);
    }

    public function FinalSaveTest() {
		$data = array();
        $convertion_code = CONVERSION_CODE;
        
        $data['m_dag_area_b'] = $this->session->userdata('m_dag_area_b');
        $data['m_dag_area_k'] = $this->session->userdata('m_dag_area_k');
        $m_dag_area_lc = $this->session->userdata('m_dag_area_lc');
        $data['m_dag_area_lc'] = round($m_dag_area_lc, 2);
        $data['petitioner'] = $this->session->userdata('petitioner');
        $data['date_entry'] = $this->session->userdata('date_entry');
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;
        $data['patta_no'] = trim($this->session->userdata('patta_no'));
        $data['dag_no'] = $this->session->userdata('dag_no');
        $data['addressed_to'] = $this->session->userdata('add_of_name');
        $data['add_of_desig'] = $this->session->userdata('add_of_desig');
        $data['add_of_co_code'] = $this->session->userdata('add_of_co_code');
        $availibility = $this->input->post('availibility');
        $data['availibility'] = $availibility;
        $aksona = $this->session->userdata('patta_type');
		
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$aksona'")->row()->patta_type;

        $location = $this->utilityclass->getLocationFromSession();

        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );

        $cron_no = $this->input->post('pdar_cron_no');
        $pdar_id = $this->input->post('pdar_id');
        $pdar_name = $this->input->post('pdar_name');
        $pdar_guard_name = $this->input->post('pdar_guardian');
        $pdar_rel_guar = $this->input->post('guard_rel');
        $pdar_add1 = $this->input->post('pdar_add1');
        $pdar_add2 = $this->input->post('pdar_add2');
        $gender = $this->input->post('gender');
        $mothers_name = $this->input->post('mothers_name');
        $mobile_no = $this->input->post('mobile_number');
        $aadhar_no = $this->input->post('aadhar_no');
        $nrc_no = $this->input->post('nrc_no');
        $pan_no = $this->input->post('pan_no');
        $voter_id = $this->input->post('voter_id');
        $i = count($cron_no);

        for ($z = 0; $z < $i; $z++) {
            $datass = array(
                'pdar_cron_no' => $cron_no[$z],
                'pdar_id' => $pdar_id[$z],
                'pdar_name' => $pdar_name[$z],
                'pdar_guardian' => $pdar_guard_name[$z],
                'pdar_rel_guar' => $pdar_rel_guar[$z],
                'pdar_add1' => $pdar_add1[$z],
                'pdar_add2' => $pdar_add2[$z],
                'mothers_name' => $mothers_name[$z],
                'gender' => $gender[$z],
                'pdar_pan_no' => $pan_no[$z],
                'pdar_citizen_no' => $voter_id[$z],
                'pdar_aadharno' => $aadhar_no[$z],
                'pdar_mobile' => $mobile_no[$z],
                'pdar_nrcno' => $nrc_no[$z],
            );
            $used_questions[] = $datass;
        }
        $this->session->set_userdata('pattadar_d', $used_questions);
        $data['pattadarx'] = $this->session->userdata('pattadar_d');

       // $this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/reportOnFullconvertion', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'asstofficeconversion/reportOnFullconvertion';
        $this->load->view('layouts/main',$data);
    }

    public function save_create_rasidOnFullConv() {
       
		//$db=  $this->session->userdata('db');
        $data = array();
        $convertion_code = CONVERSION_CODE;
        $date_entry = date('Y-m-d H:i:s');
        $data['date'] = $date_entry;
        $data['case_no'] = $this->session->userdata('case_no');
        $data['m_dag_area_b'] = $this->session->userdata('m_dag_area_b');
        $data['m_dag_area_k'] = $this->session->userdata('m_dag_area_k');
        $data['m_dag_area_lc'] = $this->session->userdata('m_dag_area_lc');
        $data['date_entry'] = $this->session->userdata('date_entry');
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;
        $data['patta_no'] = trim($this->session->userdata('patta_no'));
        $data['dag_no'] = $this->session->userdata('dag_no');
        $data['addressed_to'] = $this->session->userdata('add_of_name');
        $data['add_of_desig'] = $this->session->userdata('add_of_desig');
        $data['add_of_co_code'] = $this->session->userdata('add_of_co_code');
        $data['availibility'] = $this->session->userdata('availibility');
        $aksona = $this->session->userdata('patta_type');

        $location = $this->utilityclass->getLocationFromSession();

        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'user_name' => $this->session->userdata('add_of_name')
        );

       $data['pattadar'] = $this->session->userdata('pattadar_d');

        //$this->load->view('../views/header');
       // $this->load->view('../views/asstofficeconversion/final_rasidOnFullConv', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'asstofficeconversion/final_rasidOnFullConv';
        $this->load->view('layouts/main',$data);
    }


    public function pattadarselect() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $mut_type = $this->session->userdata('convertion_code');
        $this->session->set_userdata(array('patta_type_code' => $patta_type_code));

        $q1 = "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
                . "and p.patta_type_code='$patta_type_code' and p.pdar_id in(select pdar_id from    chitha_dag_pattadar p where p.dist_code='$dist_code' and "
                . "p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' "
                . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type_code' and p_flag!='1' and dag_no = '$dag_no')";

        // echo "select * from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
        //         . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
        //         . "and p.patta_type_code='$patta_type_code' and p.pdar_id in(select pdar_id from    chitha_dag_pattadar p where p.dist_code='$dist_code' and "
        //         . "p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' "
        //         . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and p.patta_type_code='$patta_type_code' and p_flag!='1' and dag_no = '$dag_no'";



        $data = $this->db->query($q1)->result();


        $pattadar = $data;

        // echo "<pre>";
        // var_dump($pattadar);
        // exit;

        $data['pdtails'] = $data;

        //$this->session->set_userdata('pattadar', $pattadar);
        $this->load->model('relation/relationmodel');
        $data['relation'] = $this->relationmodel->getRelations();
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/pattadardetails', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficeconversion/pattadardetails';
        $this->load->view('layouts/main',$data);
    }




    


    public function reportconvertion() {
        
       
       //$this->dbswitch();
        $data = array();
        $convertion_code = CONVERSION_CODE;
        $data['m_dag_area_b'] = $this->session->userdata('m_dag_area_b');
        $data['m_dag_area_k'] = $this->session->userdata('m_dag_area_k');
        $m_dag_area_lc = $this->session->userdata('m_dag_area_lc');
        $data['m_dag_area_lc'] = round($m_dag_area_lc, 2);
        $data['petitioner'] = $this->session->userdata('petitioner');
        $data['date_entry'] = $this->session->userdata('date_entry');
        $data['conv_type'] = $this->db->query("select order_type from master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;
        $data['addressed_to'] = $this->session->userdata('add_of_name');
        $data['patta_no'] = trim($this->session->userdata('patta_no'));
        $data['dag_no'] = $this->session->userdata('dag_no');
        $data['add_of_desig'] = $this->session->userdata('add_of_desig');
        $availibility = $this->input->post('availibility');
        $data['availibility'] = $availibility;
        $aksona = $this->session->userdata('patta_type_code');


        $data['patta_type'] = $this->db->query("select patta_type from patta_code "
                        . " where type_code='$aksona'")->row()->patta_type;

        $location = $this->utilityclass->getLocationFromSession();

        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );

        $cron_no = $this->input->post('pdar_cron_no');
        $pdar_id = $this->input->post('pdar_id');
        $pdar_name = $this->input->post('pdar_name');
        $pdar_guard_name = $this->input->post('pdar_guardian');
        $pdar_rel_guar = $this->input->post('guard_rel');
        $pdar_add1 = $this->input->post('pdar_add1');
        $pdar_add2 = $this->input->post('pdar_add2');
        $gender = $this->input->post('gender');
        $mothers_name = $this->input->post('mothers_name');
        $mobile_no = $this->input->post('mobile_number');
        $aadhar_no = $this->input->post('aadhar_no');
        $nrc_no = $this->input->post('nrc_no');
        $pan_no = $this->input->post('pan_no');
        $voter_id = $this->input->post('voter_id');
        $i = count($cron_no);

        for ($z = 0; $z < $i; $z++) {
            $datass = array(
                'pdar_cron_no' => $cron_no[$z],
                'pdar_id' => $pdar_id[$z],
                'pdar_name' => $pdar_name[$z],
                'pdar_guardian' => $pdar_guard_name[$z],
                'pdar_rel_guar' => $pdar_rel_guar[$z],
                'pdar_add1' => $pdar_add1[$z],
                'pdar_add2' => $pdar_add2[$z],
                'mothers_name' => $mothers_name[$z],
                'gender' => $gender[$z],
                'pdar_pan_no' => $pan_no[$z],
                'pdar_citizen_no' => $voter_id[$z],
                'pdar_aadharno' => $aadhar_no[$z],
                'pdar_mobile' => $mobile_no[$z],
                'pdar_nrcno' => $nrc_no[$z],
            );
            //var_dump($datass);
            $used_questions[] = $datass;
        }
        $this->session->set_userdata('pattadar_d', $used_questions);
        $data['pattadarx'] = $this->session->userdata('pattadar_d');
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/reportconvertion', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'asstofficeconversion/reportconvertion';
        $this->load->view('layouts/main',$data);
    }

    public function save_create_rasid() {
  //$db=  $this->session->userdata('db');
        $date_entry = date('Y-m-d H:i:s');
        $data['date'] = $date_entry;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['location'] = array(
            'dist' => $dist_name,
            'sub' => $subdiv_code,
            'cir' => $cir_name,
            'date' => $data['date'],
            //'add_to' => $location['add_off_name'],
            'user_name' => $this->session->userdata('add_of_name')
        );
        $data['pattadar'] = $this->session->userdata('pattadar_d');
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/final_rasid', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'asstofficeconversion/final_rasid';
        $this->load->view('layouts/main',$data);
    }

    public function notice_generation() {
		
		$db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $mode = $this->input->get('mode');
        $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
        $this->session->set_userdata(array('lot_no' => $lot_no1));
        $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
                        . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
                        . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row_array();


        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'case_no' => $case_no,
            'next_date_of_hearing' => $location['next_date_of_hearing']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $landdetails['m_dag_area_lc'],
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails_applicant = $this->db->query("select * from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'")->result();
        $pattadardetails = $this->db->query("select pdar_name,pdar_father from chitha_pattadar a join chitha_dag_pattadar b on a.pdar_id=b.pdar_id and 
a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code and a.mouza_pargona_code=b.mouza_pargona_code and a.lot_no=b.lot_no and a.vill_townprt_code=b.vill_townprt_code and a.patta_no=b.patta_no
and a.patta_type_code =b.patta_type_code 
where (b.p_flag is null or b.p_flag='0') and a.dist_code='$petition_basic->dist_code' and a.subdiv_code='$petition_basic->subdiv_code' and a.cir_code='$petition_basic->cir_code' and a.lot_no='$petition_basic->lot_no' and a.vill_townprt_code='$petition_basic->vill_townprt_code' and a.mouza_pargona_code='$petition_basic->mouza_pargona_code' and b.dag_no='$landdetails[dag_no]' and TRIM(a.patta_no)=trim('$landdetails[patta_no]') and a.patta_type_code= '$landdetails[patta_type_code]'")->result();

        $data['pattadar'] = $pattadardetails;
        $data['pattadar1'] = $pattadardetails;
        $data['pattadar2'] = $pattadardetails_applicant;
        $data['mode'] = 0;
        if ($mode==1){
            $data['mode'] = 1;
        }
        $data['_view'] = 'asstofficeconversion/notice_generation_conversion_mb';
        $this->load->view('layouts/main',$data);

    }

    public function notice_generation_save() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->input->get('case_no');
        $date_entry = date('Y-m-d H:i:s');
        $user_code=$this->session->userdata('user_code'); 

        $this->db->trans_begin();

        $query_check_notice = $this->db->get_where('petition_basic', [
            'notice_generated_yn' => 'Y',
            'notice_served_yn'    => 'Y',
            'case_no' => $case_no
        ]);

        if ($query_check_notice->num_rows() > 0) {
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVASTGENNOT00059');
            $this->session->set_flashdata('message', "Notice already generated for Conversion Case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }

        $petitionBasicUpdate = $this->db->query("UPDATE Petition_Basic SET notice_generated_yn = 'Y', notice_served_yn='Y' WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        

        if(!$petitionBasicUpdate || $this->db->affected_rows() < 1) {
            // ERRCONVASTPREMNOTICE0005
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_basic table. Error: ERRCONVASTGENNOT0005');
            $this->session->set_flashdata('message', "Notice generated failed for Conversion Case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }
        

        //insert into petition_proceeding
        $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
        $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
            'co_order' => $getPreviousPetitionProceeding->co_order,
            'note_on_order' => 'General Notice Given By AST',
            'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert('petition_proceeding', $proceeding_data);
        // var_dump($insertPetitionProceeding); die;
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            // ERRCONVASTPREMNOTICE0006
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVASTGENNOT0006');
            $this->session->set_flashdata('message', "Notice generated failed for Conversion Case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }

        if($this->db->trans_status() == FALSE) {
          $this->db->trans_rollback();
          log_message('error', 'DB Transaction Failed. Error: ERRCONVASTGENNOT0007');
          $this->session->set_flashdata('message', "Notice generated failed for Conversion Case no # $case_no");
          redirect(base_url() . "index.php/home");
          exit();
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Notice generated for Conversion Case no # $case_no");
        redirect(base_url() . "index.php/home");
    }

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function notice_action_taken() {
		//$db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
        $this->session->set_userdata(array('lot_no' => $lot_no1));
        $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
        $case_no = $this->input->get('case_no');
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,petition_no"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
                        . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row_array();
        $petition_no = $location['petition_no'];
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code 
        from    petition_dag_details where dist_code='$dist_code1' and subdiv_code='$subdiv_code1'
        and cir_code='$cir_code1' and lot_no='$lot_no1' and 
        vill_townprt_code='$vill_townprt_code1' and mouza_pargona_code='$mouza_pargona_code1' 
        and petition_no='$petition_no'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'case_no' => $case_no,
            'date_of_hearing' => $location['next_date_of_hearing'],
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
        );

        $query = "select * from    petition_proceeding where case_no = '$case_no' "
                . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' order by proceeding_id";
        $data['cases'] = $this->db->query($query)->result();
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and "
                        . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->row();
        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $landdetails['m_dag_area_lc'],
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();

        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/action_taken_conversion', $data);
        //$this->load->view('../views/footer');

        if($petition_basic->co_order_conv_premium == null && $petition_basic->pay_notice_gen_yn == null) {
            //ast_first
            $data['post_url'] = 'index.php/AsistantConversionMb/action_taken_conversion_save';
        }
        else if(($petition_basic->co_order_conv_premium == 'P' || $petition_basic->co_order_conv_premium == null) && $petition_basic->pay_notice_gen_yn == 'Y') {
            //ast second
            $data['post_url'] = 'index.php/AsistantConversionMb/action_taken_conversion_save_ast2';
        }
        // else if ($petition_basic->co_order_conv_premium == null && $petition_basic->pay_notice_gen_yn == null && $petition_basic->bo_note_yn == 'Y') {
        //     $data['post_url'] = 'index.php/AsistantConversionMb_remove/action_taken_conversion_save_revrtDC';
        // }

        $data['_view'] = 'asstofficeconversion/action_taken_conversion_mb';
        $this->load->view('layouts/main',$data);
    }

   

    public function action_taken_conversion_save_ast2() {
        // form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'proceeding_id'=>'Proceeding Id|required|digit',
            'note_on_order'=>'Note|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVASTSECOND0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTSECOND0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVASTSECOND0001');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=2'));
        }

        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, [], [], ['note_on_order' => true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVASTSECOND0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTSECOND0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVASTSECOND0002');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=2'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['note_on_order' => true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVASTSECOND0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTSECOND0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVASTSECOND0003');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=2'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVASTSECOND0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVASTSECOND0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVASTSECOND0004');
            redirect(base_url('index.php/home'));
        }

        // echo '<pre>';
        // var_dump($_POST);
        // die();
       
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->input->post('case_no');
        $proceedings = $this->input->post('proceeding_id');
        $action_note = $_POST['note_on_order'];
        $action_note = str_replace("'", '', $action_note);
        $user_code = $this->session->userdata('user_code');
        $i = count($proceedings);

        

        for ($z = 0; $z < $i; $z++) {
            $this->db->query("UPDATE petition_proceeding SET note_on_order = '$action_note[$z]', user_code = '$user_code' WHERE proceeding_id = '$proceedings[$z]' and case_no = '$case_no' "
                    . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
        }
        $this->db->query("UPDATE Petition_Basic SET proceeding_yn = '1' WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

        $is_premium_paid = $this->db->query("select co_order_conv_premium"
        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
        . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();
        

        if($is_premium_paid->co_order_conv_premium == 'P'){

            $this->db->query("UPDATE Petition_Basic SET status = 'W' WHERE co_order_conv_premium = 'P' and case_no = '$case_no' "
            . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
            . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");
        }
        
        

        ////////////////////////////////////////
        $penUser='CO';
        $rmrk='Action Taken Report by AST';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $status='M';
        $task='AST';
        $pen='CO';
        // $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
        $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
        $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmrk,$status,$task,$pen);
        ////////////////////////////////////////
        $this->session->set_flashdata('message', "Action Taken Report Passed for Conversion case no # $case_no");
        redirect(base_url() . "index.php/home");
    }

    public function action_taken_conversion_save() {
        // form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No.|required|case_no',
            'proceeding_id'=>'Proceeding Id|required|digit',
            'action_taken_ast'=>'action_taken_ast|required'
            // 'note_on_order'=>'Note|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVAST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVAST0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVAST0001');
            redirect(base_url('index.php/AsistantConversionMb/GoToAST?pro=2'));
        }

        //syntax validation
        // $requestResponse = checkRequestSpecChar($_POST, [], [], ['note_on_order'=>true]);
        // if($requestResponse['status'] == 'n') {
        //     //ERRCONVAST0002
        //     log_message('error', $requestResponse['messages'] . '. Error: ERRCONVAST0002');
        //     $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVAST0002');
        //     redirect(base_url('index.php/AsistantConversionMb/GoToAST?pro=2'));
        // }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVAST0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVAST0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVAST0003');
            redirect(base_url('index.php/AsistantConversionMb/GoToAST?pro=2'));
        }

        //authorization
        // $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_FIRST);
        // if($authorization['status'] == 'n') {
        //     //ERRCONVAST0004
        //     log_message('error', $authorization['messages'] . '. Error: ERRCONVAST0004');
        //     $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVAST0004');
        //     redirect(base_url('index.php/home'));
        // }

        // echo '<pre>';
        // var_dump($_POST, $authorization);
        // die();
       
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');
        $proceedings = $this->input->post('proceeding_id');
        $action_note = $_POST['note_on_order'];
        $action_note = str_replace("'", '', $action_note);
        $user_code = $this->session->userdata('user_code');
        $i = count($proceedings);
        $action_taken_ast = $this->input->post('action_taken_ast');


        
        $this->db->trans_begin();
        // for ($z = 0; $z < $i; $z++) {
        //     $this->db->query("UPDATE petition_proceeding SET note_on_order = '$action_note[$z]', user_code = '$user_code' WHERE proceeding_id = '$proceedings[$z]' and case_no = '$case_no' "
        //             . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
        // }
        
        $updateBasic = $this->db->query("UPDATE Petition_Basic SET proceeding_yn = '1' WHERE case_no = '$case_no' "
        . "and dist_code='$dist_code'");

        if(!$updateBasic || $this->db->affected_rows() < 1) {
            log_message("error","Error - #ERRCONVAST001366. Action Taken Report update Failed in Petition_Basic.");
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRCONVAST001366: Action Taken Report Failed for case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();

        }

        $is_premium_paid = $this->db->query("select co_order_conv_premium"
        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code'")->row();
        

        if($is_premium_paid->co_order_conv_premium == 'P'){

            $updateBasicprem = $this->db->query("UPDATE Petition_Basic SET status = 'W' WHERE co_order_conv_premium = 'P' and case_no = '$case_no' "
            . "and dist_code='$dist_code'");

            if(!$updateBasicprem || $this->db->affected_rows() < 1) {
                log_message("error","Error - #ERRCONVAST001369. Action Taken Report update Failed in Petition_Basic.");
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRCONVAST001369: Action Taken Report Failed for case no # $case_no");
                redirect(base_url() . "index.php/home");
                exit();
    
            }
        }

        $path = UPLOAD_BASE_CONVERSIONDOCS.UPLOAD_SEPARATOR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }

         // File uploading (Notice)
         $petitionBasic = $this->PetitionBasicModel->get(['case_no'=>$case_no]);
         $count = $this->SupportiveDocumentModel->get(['case_no' => $case_no], 'COUNT(*)')->count;
         $sl = $count+1;
        //  $file = $petitionBasic->petition_no . time() . '_' . $sl;
         $file = $petitionBasic->petition_no .$dist_code. $this->UUID4() . '_' . $sl;
         $ext = pathinfo($_FILES['up_notice_conv']['name'], PATHINFO_EXTENSION);
         $_FILES['up_notice_conv']['name'] = $file . '.' . $ext;
         $config = array(
             'upload_path' => $path,
             'allowed_types' => FILE_TYPE,
             'max_size' => MAX_SIZE,
         );

         $this->load->library('upload', $config);
         $this->upload->initialize($config);
         if ($this->upload->do_upload('up_notice_conv')) 
         {
             $data = $this->upload->data();
             $insert_noc_data = [
                 'case_no' => $case_no,
                 'user_code' => $user_code,
                 'file_name' => "Notice",
                 'fetch_file_name' => $file.$data['file_ext'],
                 'file_type' => $data['file_type'],
                 'file_path' => $path.$file.$data['file_ext'],
                 'date_entry' => date('Y-m-d h:i:s'),
                 'mut_type' => '01',
             ];
             $insertNocStatus = $this->db->insert('supportive_document', $insert_noc_data);
             if(!$insertNocStatus || $this->db->affected_rows() < 1){
                 // ERRCONVLM0010
                 $this->db->trans_rollback();
                 log_message("error","Error - #ERRCONVLM0010. Notice upload data insertion failed in supportive_document for dist: " . $dist_code.", case no: ". $case_no);
                 $this->session->set_flashdata('message', "Unable to upload file Conversion case no # $case_no");
                 redirect(base_url() . "index.php/home");
                 exit();
             }
         }
         else
         {
                 $this->db->trans_rollback();
                 log_message("error","Error - #ERRCONVLM0011. Notice upload data insertion failed in supportive_document for dist: " . $dist_code.", case no: ". $case_no);
                 $this->session->set_flashdata('message', "Unable to upload file Conversion case no # $case_no");
                 redirect(base_url() . "index.php/home");
                 exit();

         }
         ////////////Notice ends here////////

         //insert into petition_proceeding
        $getPreviousPetitionProceeding = $this->PetitionProceedingModel->getProceeding($case_no);
        $proceeding_id = $this->ConversionModel->getMaxProceedingId($case_no);
        $proceeding_data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $getPreviousPetitionProceeding->date_of_hearing,
            'co_order' => $getPreviousPetitionProceeding->co_order,
            // 'note_on_order' => 'Note of action and Notice uploaded By AST',
            'note_on_order' => $action_taken_ast,
            'next_date_of_hearing' => $getPreviousPetitionProceeding->next_date_of_hearing,
            'status' => 'Done',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'dist_code' => $petitionBasic->dist_code,
            'subdiv_code' => $petitionBasic->subdiv_code,
            'cir_code' => $petitionBasic->cir_code,
            'mouza_pargona_code' => $petitionBasic->mouza_pargona_code,
            'lot_no' => $petitionBasic->lot_no,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insertPetitionProceeding = $this->db->insert('petition_proceeding', $proceeding_data);
        // var_dump($insertPetitionProceeding); die;
        if(!$insertPetitionProceeding || $this->db->affected_rows() < 1) {
            // ERRCONVASTPREMNOTICE0006
            $this->db->trans_rollback();
            log_message('error', 'Error in updation in petition_proceeding table. Error: ERRCONVASTNOT00036');
            $this->session->set_flashdata('message', "#ERRCONVASTNOT00036: Notice generated failed for Conversion Case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }

         if($this->db->trans_status() == FALSE) {
            // ERRCONVLMAPP0007
            $this->db->trans_rollback();
            log_message('error', 'DB Transaction failed. Error: #ERRCONVAST0007');
            $this->session->set_flashdata('message', "#ERRCONVAST0007: Action Taken Report Failed for Conversion case no # $case_no");
            redirect(base_url() . "index.php/home");
            exit();
        }


        $this->db->trans_commit();
        
        

        ////////////////////////////////////////
        $penUser='CO';
        $rmk='Action Taken Report by AST';
        $this->DashboardData($case_no,$penUser,$rmk);
        $status='M';
        $task='AST';
        $pen='CO';
        // $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
        $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
        $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmk,$status,$task,$pen);
        ////////////////////////////////////////
        $this->session->set_flashdata('message', "Action Taken Report Passed for Conversion case no # $case_no");
        redirect(base_url() . "index.php/home");
    }

    public function notice_premium() {
		//$db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
        $this->session->set_userdata(array('lot_no' => $lot_no1));
        $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1'")->row();


        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1'")->row_array();
        
        // $co_code=$location['add_off_name'];
        // $name_of_co = $this->db->query("select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
        // cir_code='$cir_code' and user_code='$co_code'")->row();
        // $co_name = $name_of_co->username;

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            // 'add_to' => $co_name,
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";

        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

        $prim_per_bigha = $lm_details['prim_per_bigha'];
        $prim_per_bigha = round($prim_per_bigha, 2);

        $prim_tot = $lm_details['prim_tot'];
        $prim_tot = round($prim_tot, 2);

        $data['lm_details'] = array(
            'dag_no' => $lm_details['dag_no'],
            'prim_per_bigha' => $prim_per_bigha,
            'conv_b' => $lm_details['conv_b'],
            'conv_k' => $lm_details['conv_k'],
            'conv_lc' => $lm_details['conv_lc'],
            'prim_tot' => $prim_tot,
            'premium_assesment' => $lm_details['premium_assesment']
        );
        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/notice_for_premium', $data);
        //$this->load->view('../views/footer');
        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        if(!$data['basundharaAttachment']) {
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }
        $data['_view'] = 'asstofficeconversion/notice_for_premium';
        $this->load->view('layouts/main',$data);
    }

    public function notice_for_premium_save() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No|required|case_no',
            'amount'=>'Amount|required|2_digit_decimal'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0001
            log_message('error', 'Message: '. $formValidation['message'] .',Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTPREMNOTICE0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVASTPREMNOTICE0001');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=3'));
        }
        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTPREMNOTICE0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVASTPREMNOTICE0002');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=3'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTPREMNOTICE0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVASTPREMNOTICE0003');
            redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=3'));
        }

        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_PREMIUM_NOTICE);
        if($authorization['status'] == 'n') {
            //ERRCONVASTPREMNOTICE0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVASTPREMNOTICE0004');
            $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVASTPREMNOTICE0004');
            redirect(base_url('index.php/home'));
        }
        // echo '<pre>';
        // var_dump($_POST);
        // die();

		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');

        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        log_message("info", "********************MPR: basundhara ".$basundhara);

        ////////////////////////////////////////
        $penUser='AST';
        $rmrk='Notice for premium by AST';
        $this->DashboardData($case_no,$penUser,$rmrk);
        if($basundhara){
            $status='M';
            $task='AST';
            $pen='CO';
            // $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmrk,$status,$task,$pen);
        }
        ////////////////////////////////////////

        /////////////Basundhara////////////////////
        if($basundhara){
            $amount=$this->input->post('amount');
            $rmk='Payment Notice Generated';
            $status='Q';
            $task='AST';
            $pen='AST';
            $case=$basundhara;
            //$this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
            // var_dump($amount); die();
            $success=$this->basundharamodel->payqueryRequest($basundhara,$amount);
            
            log_message("info", "************ success=".$success);
            if(intval($success) > 0){           
            //////////////////////
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, pay_notice_gen_yn='Y' WHERE case_no = '$case_no' "
                . "and dist_code='$dist_code'");
            //////////////////////////////////////

            $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
            redirect(base_url() . "index.php/home");
            }else{
            $this->session->set_flashdata('message', "Please Try Again !");
            redirect(base_url() . "index.php/home");
            } 
        }else{
            //////////////////////
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, pay_notice_gen_yn='Y' WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code'");
            //////////////////////////////////////

            $this->session->set_flashdata('message', "Notice Generated for Payment of Premium on Conversion Case # $case_no");
            redirect(base_url() . "index.php/home");
        }

    }

    public function confirmation_premium() {
		//$db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code1));
        $this->session->set_userdata(array('lot_no' => $lot_no1));
        $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code1));
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

        $prim_per_bigha = $lm_details['prim_per_bigha'];
        $prim_per_bigha = round($prim_per_bigha, 2);

        $prim_tot = $lm_details['prim_tot'];
        $prim_tot = round($prim_tot, 2);

        $data['lm_details'] = array(
            'dag_no' => $lm_details['dag_no'],
            'prim_per_bigha' => $prim_per_bigha,
            'conv_b' => $lm_details['conv_b'],
            'conv_k' => $lm_details['conv_k'],
            'conv_lc' => $lm_details['conv_lc'],
            'prim_tot' => $prim_tot,
            'premium_assesment' => $lm_details['premium_assesment']
        );
        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();

        $data['basundharaExist']=$this->basundharamodel->checkExistBasundhar($case_no);
        ////////Payment Track//////////
        $data['success']=json_decode($this->basundharamodel->paymentConfirmation($data['basundharaExist']));
        // var_dump($data['success']); die();
        ///////////////

        //$this->load->view('../views/header');
        //$this->load->view('../views/asstofficeconversion/confirmation_of_premium', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'asstofficeconversion/confirmation_of_premium';
        $this->load->view('layouts/main',$data);
    }

    public function confirmation_premium_save() {
        if(!isset($_POST['paymentBasu'])) {
            // form validation
            $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
                'case_no'=>'Case No.|required|case_no',
                'payment_type'=>'Type of Premium|digit',
                'chalan_no'=>'Challan No|digit',
            ]);
            if($formValidation['status'] == 'n') {
                //ERRCONVASTCONFIRM0001
                log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVASTCONFIRM0001');
                $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVASTCONFIRM0001');
                redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=4'));
            }

            //syntax validation
            $requestResponse = checkRequestSpecChar($_POST);
            if($requestResponse['status'] == 'n') {
                //ERRCONVASTCONFIRM0002
                log_message('error', $requestResponse['messages'] . '. Error: ERRCONVASTCONFIRM0002');
                $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVASTCONFIRM0002');
                redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=4'));
            }

            //malicious query validation
            $validResponse = checkRequestValidQuery($_POST);
            if($validResponse['status'] == 'n') {
                //ERRCONVASTCONFIRM0003
                log_message('error', $validResponse['messages'] . '. Error: ERRCONVASTCONFIRM0003');
                $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVASTCONFIRM0003');
                redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=4'));
            }

            //authorization
            $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'AST', $_POST['case_no'], CONV_AST_CONFIRM_PREMIUM);
            if($authorization['status'] == 'n') {
                //ERRCONVASTCONFIRM0004
                log_message('error', $authorization['messages'] . '. Error: ERRCONVASTCONFIRM0004');
                $this->session->set_flashdata('message', $authorization['messages'].'. Error: ERRCONVASTCONFIRM0004');
                redirect(base_url('index.php/home'));
            }

            // echo '<pre>';
            // var_dump($_POST);
            // die();
        }

		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');
        $payment_type = $this->input->post('payment_type');
        $chalan_no = $this->input->post('chalan_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code'")->row();
        if (isset($_POST['submit2'])) {
            //echo "one";
            $this->db->query("UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = NULL  WHERE case_no = '$case_no' "
                    . "and dist_code='$dist_code'");

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment not confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            // $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
            $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
            $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmrk,$status,$task,$pen);
            ////////////////////////////////////////

            $this->db->query("UPDATE petition_lm_note SET recpt_number = 'N' where case_no='$petition_basic->case_no' and petition_no='$petition_basic->petition_no' and co_reject is NULL");
            $this->session->set_flashdata('message', "Conversion Case no # $case_no will be sent back to Circle officer without Confirmation of Premium. Please Give the action taken report.");
        }
        if(isset($_POST['paymentBasu'])){

            $petition_basic_update2="UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code'";
            $this->db->query($petition_basic_update2); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0021: Unable to pass order !");
                log_message("error","#ASCON0021 Failed to update petition_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $petition_lm_note_update2="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '200', recpt_number = 'basundhara_payment' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
            $this->db->query($petition_lm_note_update2);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0022: Unable to pass order !");
                log_message("error","#ASCON0022 Failed to update petition_lm_note for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk='Payment Received';
            $status='M';
            $task='AST';
            $pen='CO';
            $this->session->set_flashdata('message', "Payment confirmed, submit action taken report !");
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                // $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
                $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmrk,$status,$task,$pen);
            }else{
                $this->db->trans_commit();
            }
            ////////////////////////////////////////
        }
        if (isset($_POST['submit1'])) {
            $formValid = $this->FormValidationModel->formValidationForPost($_POST, [
                'payment_type'=>'Type of Premium|required|digit',
                'chalan_no'=>'Challan No|required_on_condition(payment_type,notEquals,[003])|3_digit_decimal',
            ]);
            if($formValid['status'] == 'n') {
                //ERRCONVASTCONFIRM0005
                log_message('error', 'Message: '. $formValid['message'] .', Data: '. json_encode($formValid['data']) .'. Error: ERRCONVASTCONFIRM0005');
                $this->session->set_flashdata('message', $formValid['message'] .' Error: ERRCONVASTCONFIRM0005');
                redirect(base_url('index.php/AsistantConversionMb_remove/GoToAST?pro=4'));
            }

            $path = CONVERSION_PREMCHALLAN_BASE_DIR.UPLOAD_SEPARATOR;
            
            if(!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $this->db->trans_begin();
            // $config['upload_path'] = './ConversionDocs/PremChallan/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);

            //Premium challan upload validation starts here

            $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
            $sl = $count+1;
            // $path = './ConversionDocs/PremChallan/';
            
            $file = $petition_basic->petition_no.date('Y').'_'.$sl;
            
            $_FILES['file']['type'] = $_FILES['up_prem_conv']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['up_prem_conv']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['up_prem_conv']['error'];
            $_FILES['file']['size'] = $_FILES['up_prem_conv']['size'];

            $ext = pathinfo($_FILES['up_prem_conv']['name'], PATHINFO_EXTENSION);
            $_FILES['file']['name'] = $file.'.'.$ext;

            // var_dump($_FILES['file']); die();

            // $file_path = './ConversionDocs/PremChallan/';

            $config = array(
                // 'upload_path' => './ConversionDocs/PremChallan/',
                'upload_path' => $path,
                'allowed_types' => FILE_TYPE,
                'max_size' => MAX_SIZE,
            );
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'file_name' => NOC,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ASCON0010: Unable to pass order !");
                    log_message("error","#ASCON0010 Uploading Failed for dist:"
                                .$dist_code.", case no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }
            else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0009: Unable to pass order !");
                log_message("error","#ASCON0009 Uploading Failed for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////Premium challan ends here////////

            $petition_basic_update="UPDATE Petition_Basic SET co_order_conv_notice = NULL, co_order_conv_premium = 'P'  WHERE case_no = '$case_no' "
            . "and dist_code='$dist_code'";
            $this->db->query($petition_basic_update); // ********************
            // echo $this->db->last_query(); die;
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0011: Unable to pass order !");
                log_message("error","#ASCON0011 Failed to update petition_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $petition_lm_note_update="UPDATE petition_lm_note SET astt_confirm = 'Y', prem_pay_method = '$payment_type', recpt_number = '$chalan_no' where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL";
            $this->db->query($petition_lm_note_update);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ASCON0012: Unable to pass order !");
                log_message("error","#ASCON0012 Failed to update petition_lm_note for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Payment confirmed by AST';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $status='M';
            $task='AST';
            $pen='CO';
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $success=$this->basundharamodel->postApiManualPayment($case_no,$task);  
                log_message("info", "************ success=".$success);
                // $this->db->trans_rollback(); die();
                if(intval($success) > 0){
                    $this->db->trans_commit();
                    // $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status,$task,$pen);
                    $basundharApplication = $this->BasundharApplicationModel->checkExistBasundhar($case_no);
                    $this->basundharamodel->postApiBasundharaConvMb3($basundharApplication,$case_no,$rmrk,$status,$task,$pen);
                }else{
                    // $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ASCON0013: Unable to pass order !");
                    log_message("error","#ASCON0013 Failed to update payment confirmation for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }else{
                $this->db->trans_commit();
            }
            ////////////////////////////////////////
            $this->session->set_flashdata('message', "Payment of Premium Confirmed on Conversion Case no # ". $case_no);
        }
        redirect(base_url() . "index.php/home");
    }

    public function saveJamabandiByPattano() {
		//$db=  $this->session->userdata('db');
        $case_no = $this->input->GET('case_no');
        $proposal_no = $this->input->GET('proposal_no');
        $case_id = $this->input->GET('case_id');
        
        $caseNoValidate = caseNumberValidation($case_no);
        if(count($caseNoValidate)){
            show_error($caseNoValidate['message'], 401);
            return;
        }

        if ($case_no == '0') {
            //var_dump($this->session->all_userdata());
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $circle_code = $this->session->userdata('cir_code');
            $mouza_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');

            $pattatypeCode = $this->session->userdata('patta_type_code');
            $patta_no = trim($this->session->userdata('patta_no'));
        } elseif ($case_no == '1') {
            //this is for land reclassification
            // $case_id = $this->input->get('case_id');
            $caseIdValidate = caseNumberValidation($case_id, 'Case id');
            if(count($caseIdValidate)){
                show_error($caseIdValidate['message'], 401);
                return;
            }
            // $proposal_no = $this->input->get('proposal_no');
            
            $proposanNoValidate = proposalNumberValidation($proposal_no);
            if(count($proposanNoValidate)){
                show_error($proposanNoValidate['message'], 401);
                return;
            }

            $t_reclassification = $this->db->query("Select * from t_reclassification where proposal_no =? and case_no =?", array($proposal_no, $case_id))->row();
            if(!$t_reclassification){
                log_message('error', '#ERRTRECLASS10003: Data not found in t_reclassification table for proposal_no = ' . $proposal_no . ', case_no = ' . $case_id);
                show_error('#ERRTRECLASS10003: Unable to fetch data.', 404);
                return;
            }

            $dist_code = $t_reclassification->dist_code;
            $subdiv_code = $t_reclassification->subdiv_code;
            $circle_code = $t_reclassification->cir_code;
            $mouza_code = $t_reclassification->mouza_pargona_code;
            $lot_no = $t_reclassification->lot_no;
            $vill_code = $t_reclassification->vill_townprt_code;

            $pattatypeCode = $t_reclassification->patta_type_code;
            $patta_no = trim($t_reclassification->patta_no);
        } elseif ($case_no == '2') {
            //this is for Appeal Case 118
            // $case_id = $this->input->get('case_id');
            $caseIdValidate = caseNumberValidation($case_id);
            if(count($caseIdValidate)){
                show_error($caseIdValidate['message'], 401);
                return;
            }
            // $proposal_no = $this->input->get('proposal_no');
            
            $proposanNoValidate = proposalNumberValidation($proposal_no);
            if(count($proposanNoValidate)){
                show_error($proposanNoValidate['message'], 401);
                return;
            }

            $civil_appeal_basic = $this->db->query("Select * from civil_appeal_basic where petition_no =? and case_no =?", array($proposal_no, $case_id))->row();
            if(!$civil_appeal_basic){
                log_message('error', '#ERRCVLAPPBAS10001: Data not found in civil_appeal_basic table for petition_no = ' . $proposal_no . ', case_no = ' . $case_id);
                show_error('#ERRCVLAPPBAS10001: Unable to fetch data.', 404);
                return;
            }

            $dist_code = $civil_appeal_basic->dist_code;
            $subdiv_code = $civil_appeal_basic->subdiv_code;
            $circle_code = $civil_appeal_basic->cir_code;
            $mouza_code = $civil_appeal_basic->mouza_pargona_code;
            $lot_no = $civil_appeal_basic->lot_no;
            $vill_code = $civil_appeal_basic->vill_townprt_code;

            $pattatypeCode = $civil_appeal_basic->patta_type_code;
            $patta_no = trim($civil_appeal_basic->patta_no);
        } else {
            $petition_basic = $this->db->query("Select * from petition_basic where case_no =?", array($case_no))->row();
            if(!$petition_basic){
                log_message('error', '#ERRPETBAS10002: Data not found in petition_basic table for case_no = ' . $case_no);
                show_error('#ERRPETBAS10002: Unable to fetch data.', 404);
                return;
            }

            $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,"
                            . "patta_type_code from petition_dag_details where dist_code=? and"
                            . " subdiv_code=? and cir_code=? and "
                            . "lot_no=? and vill_townprt_code=? and "
                            . "mouza_pargona_code=? and petition_no=?", array($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->mouza_pargona_code, $petition_basic->petition_no))->row_array();

            $dist_code = $petition_basic->dist_code;
            $subdiv_code = $petition_basic->subdiv_code;
            $circle_code = $petition_basic->cir_code;
            $mouza_code = $petition_basic->mouza_pargona_code;
            $lot_no = $petition_basic->lot_no;
            $vill_code = $petition_basic->vill_townprt_code;

            $pattatypeCode = $landdetails['patta_type_code'];
            $patta_no = trim($landdetails['patta_no']);
        }
        
        // if (isset($_GET['case_no'])) {
        //     $case_no = $this->input->get('case_no');
        // }

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

        $get_patta_info = "select count(*) as count from    jama_patta WHERE dist_code=? and subdiv_code =? and cir_code=? and "
                . "mouza_pargona_code =? and lot_no =? and vill_townprt_code=? and patta_type_code=? and TRIM(patta_no)=?";

        $get_patta_info = $this->db->query($get_patta_info, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode, $pno))->row()->count;

        $pdar_alignment = '0'; //serialize by id
        if ($get_patta_info != "") {
            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                    . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code=? and jd.subdiv_code =? and jd.cir_code=? and "
                    . "jd.mouza_pargona_code =? and jd.lot_no =? and jd.vill_townprt_code=? and "
                    . "jd.patta_type_code=? and TRIM(jd.patta_no)=? order by dag_no";

            $main['daginfo'] = $this->db->query($query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode, $pno))->result();
            $daginfo_counted = count($main['daginfo']);

            $main['sort_pdar_by'] = $pdar_alignment;
            if ($daginfo_counted != "") {
                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                            . "from    jama_pattadar WHERE dist_code=? and subdiv_code =? and cir_code=? and "
                            . "mouza_pargona_code =? and lot_no =? and vill_townprt_code=? and "
                            . "patta_type_code=? and TRIM(patta_no)=? order by length(pdar_id), pdar_id";
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                            . "from    jama_pattadar WHERE dist_code=? and subdiv_code =? and cir_code=? and "
                            . "mouza_pargona_code =? and lot_no =? and vill_townprt_code=? and "
                            . "patta_type_code=? and TRIM(patta_no)=? order by pdar_sl_no asc";
                }
                $main['pattadarinf'] = $this->db->query($query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode, $pno))->result();
            } else {
                //If dag and patta for old patta does not exist.
                $main['pattadarinf'] = null;
                $main['daginfo'] = null;
            }
            $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                    . "dist_code=? and subdiv_code =? and cir_code=? and "
                    . "mouza_pargona_code =? and lot_no =? and "
                    . "vill_townprt_code=? and patta_type_code=? and "
                    . "TRIM(patta_no)=? order by rmk_line_no ";
            $main['remarkinf'] = $this->db->query($query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode, $pno))->result();
            
            $query = "select old_patta_no from    jama_patta WHERE "
            . "dist_code=? and subdiv_code =? and cir_code=? and "
            . "mouza_pargona_code =? and lot_no =? and "
            . "vill_townprt_code=? and patta_type_code=? and "
            . "TRIM(patta_no)=? ";
            $main['oldpno'] = $this->db->query($query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode, $pno))->result();

            $main = array_merge($maindata, $main);

            $this->load->helper('html');
            //$this->load->view('header');
            //$this->load->view('jamabandi/save_jamabandi_by_entering_a_pattano', $main);

            $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
            $this->load->view('layouts/main',$main);
        } else {
            //echo 'no jamabandi found';
            $this->load->helper('html');
            //$this->load->view('header');
            //$this->load->view('jamabandi/no_jamabandi');

            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main',$data);
        }
        $this->load->view('footer');
    }

    public function saveJamabandiByEnteringPattano() {
		  $db=  $this->session->userdata('db');
        //display jama by entering pattano new beigns here
        $main = array();
        $jamainfo = array();
        $dist_code = $this->input->get('dist');
        $subdiv_code = $this->input->get('sub_div');
        $circle_code = $this->input->get('cir');
        $mouza_code = $this->input->get('m');
        $lot_no = $this->input->get('l');
        $vill_code = $this->input->get('v');

        $pattatypeCode = $this->input->get('p');
        $pdar_alignment = '1';
        $patta_no = trim($this->input->get('patta_no'));

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

        if ($get_patta_info != 0) {
            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                    . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                    . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                    . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";

            $main['daginfo'] = $this->db->query($query)->result();
            $daginfo_counted = count($main['daginfo']);

            $main['sort_pdar_by'] = $pdar_alignment;
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
                $main['pattadarinf'] = array_merge($q, $q1);
            } else {
                //If dag and patta for old patta does not exist.
                $main['pattadarinf'] = null;
                $main['daginfo'] = null;
            }
            $query = "select patta_no,remark,rmk_line_no,entry_mode,user_code,dist_code,subdiv_code,cir_code,entry_date from    jama_remark WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' order by rmk_line_no ";
            $main['remarkinf'] = $this->db->query($query)->result();
            //var_dump($main['remarkinf']);

            $query = "select old_patta_no,entry_date from    jama_patta WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' ";
            $main['oldpno'] = $this->db->query($query)->result();

            $main = array_merge($maindata, $main);
            $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
            $this->load->view('layouts/main',$main);
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/save_jamabandi_by_entering_a_pattano', $main);
        } else {
            echo 'no jamabandi found';
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/no_jamabandi');
        }
        //$this->load->view('footer');
    }

    public function regenerate_notice() {
		$db=  $this->session->userdata('db');
        $main['_view'] = 'asstofficeconversion/regenerate_notice_form';
        $this->load->view('layouts/main',$main);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/regenerate_notice_form');
        // $this->load->view('../views/footer');
    }

    public function regenerate_notice_result() {
        // echo '<pre>';
        // var_dump($_POST);
        // die();
		  $db=  $this->session->userdata('db');
        //var_dump($this->input->post());
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $category = $this->input->post('category');
        $case_no = $this->input->post('case_no');
        $data['case_no'] = $case_no;

        if ($category == '1') { //1 = Notice Generation for Petitioners and Concerned Parties
            $query = "select count(*) as c from    petition_basic where case_no='$case_no' and not_fresh = 'Y' and user_code = '$user_code' and status = 'P' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $count = $this->db->query($query)->row()->c;
            //exit();
            if ($count > 0) {
                redirect(base_url() . "index.php/AsistantConversionMb_remove/notice_ree_generation?case_no=" . $case_no . "");
            } else {
                $data['_view'] = 'asstofficeconversion/notice_not_available';
                $this->load->view('layouts/main',$data);
                // $this->load->helper('html');
                // $this->load->view('../views/header');
                // $this->load->view('../views/asstofficeconversion/notice_not_available', $data);
                // $this->load->view('../views/footer');
            }
        } else {
            //0 = Notice Generation for payment of Premium
            $query = "select count(*) as c from    petition_basic where case_no='$case_no' and not_fresh = 'Y' and status = 'P' and user_code = '$user_code' and mut_type = '01' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $count = $this->db->query($query)->row()->c;
            //exit();
            if ($count > 0) {
                redirect(base_url() . "index.php/AsistantConversionMb_remove/notice_ree_premium?case_no=" . $case_no . "");
            } else {
                $data['_view'] = 'asstofficeconversion/notice_not_available';
                $this->load->view('layouts/main',$data);
                // $this->load->helper('html');
                // $this->load->view('../views/header');
                // $this->load->view('../views/asstofficeconversion/notice_not_available', $data);
                // $this->load->view('../views/footer');
            }
        }
    }

    public function notice_ree_generation() {
		  $db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row_array();


        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'case_no' => $case_no,
            'next_date_of_hearing' => $location['next_date_of_hearing']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $landdetails['m_dag_area_lc'],
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = $this->db->query("select * from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'")->result();

        $data['pattadar'] = $pattadardetails;
        $data['pattadar1'] = $pattadardetails;
        $data['pattadar2'] = $pattadardetails;
        $data['_view'] = 'asstofficeconversion/ree_notice_generation_conversion';
        $this->load->view('layouts/main',$data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/ree_notice_generation_conversion', $data);
        // $this->load->view('../views/footer');
    }

    public function notice_ree_premium() {
		  $db=  $this->session->userdata('db');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $data = array();
        $case_no = $this->input->get('case_no');
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row();
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,sk_comment"
                        . " from    petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'add_to' => $location['add_off_name'],
            'next_date' => $location['next_date_of_hearing'],
            'sk_comment' => $location['sk_comment']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);

        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code']
        );

        $data['patta_type'] = $this->db->query("select patta_type from    patta_code "
                        . " where type_code='$landdetails[patta_type_code]'")->row()->patta_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $lm_details = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and co_reject is NULL order by note_no desc limit 1")->row_array();

        $prim_per_bigha = $lm_details['prim_per_bigha'];
        $prim_per_bigha = round($prim_per_bigha, 2);

        $prim_tot = $lm_details['prim_tot'];
        $prim_tot = round($prim_tot, 2);

        $data['lm_details'] = array(
            'dag_no' => $lm_details['dag_no'],
            'prim_per_bigha' => $prim_per_bigha,
            'conv_b' => $lm_details['conv_b'],
            'conv_k' => $lm_details['conv_k'],
            'conv_lc' => $lm_details['conv_lc'],
            'prim_tot' => $prim_tot,
        );
        $data['_view'] = 'asstofficeconversion/ree_notice_for_premium';
        $this->load->view('layouts/main',$data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficeconversion/ree_notice_for_premium', $data);
        // $this->load->view('../views/footer');
    }



    function Dashboard($case_no)
    {

        //var_dump($this->session->all_userdata());

        $this->dbb = $this->load->database('dash', TRUE);

        $sql="select pb.*,dag_no,patta_no,patta_type_code from Petition_basic pb left join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.petition_no=pd.petition_no  where  pb.mut_type='01' and pb.case_no='$case_no' ";
        
        $type='CV';

        $data=$this->db->query($sql)->row_array();
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
              'pending_with_user' =>'CO',
              'case_type' =>$type,
              'date_of_insert'=>date("Y-m-d h:i:s")
                    );

            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);



        $sql="Select pdar_name as pet_name,pdar_guardian as guard_name,pdar_rel_guar as guard_rel from petitioner_part where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                    . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and petition_no='$data[petition_no]'  ";
        $petitioner=$this->db->query($sql)->result();
        foreach ($petitioner as $key => $value) {
            $applicant= array(
                'case_no' => $case_no,
                'applicant_name' => $value->pet_name,
                'guardian_name' => $value->guard_name,
                'gender' => $value->guard_rel );
            $this->dbb->insert('dashboard_applicant',$applicant);
        }
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
                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date('Y-m-d'),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => $rmrk,
                         );
                    $this->dbb->insert('dashboard_action',$action);

                    $this->db->where('case_no',$case_no);

                    $this->db->update('dashboard_data',$base);

                /////////////////////////////////////
        }
    // function DashboardDataReject($case_no){
    //     $this->dbb = $this->load->database('dash', TRUE);
    //             $base=array(
    //                         'final_order_date' => date('Y-m-d'),
    //                         'pending_with_user'=>'NA',
    //                         'status'=>'R',
    //                         'remark'=>'Case Rejected'
    //             );
    //             $this->dbb->where('case_no',$case_no);
    //             $this->dbb->update('dashboard_data',$base);
    //             $action= array(
    //                 'case_no' => $case_no,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_of_action_taken' => date('Y-m-d'),
    //                 'user_designation' => $this->session->userdata('user_desig_code'),
    //                 'remark' => 'Rejected',
    //                  );
    //             $this->dbb->insert('dashboard_action',$action);
    //         }

}