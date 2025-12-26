<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LMconversionPartha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Allowed designations
        $allowed = ['LM','LRA'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/LMofficeConversionModel');
        $this->load->library('form_validation');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
        //$this->load->model('ConversionEscalationModel');
        $this->load->model('v2/ConversionPremiumAreasModel');
        $this->load->model('v2/ConversionPremiumAreaPurposeTypeModel');
        $this->load->model('v2/ConversionPremiumRatesModel');
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
    
    public function GoToLM() {
        $this->dbswitch();
		//s$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $process=$this->input->get('pro');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        if($process == '1')
        {
        $config['total_rows'] = $this->LMofficeConversionModel->countPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
        $cases['cases'] = $this->LMofficeConversionModel->getPendingConversionLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no)->result();
        }
        
        $cases['process'] = $process;
        //var_dump($cases);
        $this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/lm_office_conversion/lm_conversion_cases', $cases);
        //$this->load->view('../views/footer');
        $cases['_view'] = 'lm_office_conversion/lm_conversion_cases';
        $this->load->view('layouts/main',$cases);
    }
    // added by hriday - 25-04-2024
    public function generateApplication() {
        $data['location'] = [
            'dist_code' => $this->session->userdata('dist_code'),
            'subdiv_code' => $this->session->userdata('subdiv_code'),
            'cir_code' => $this->session->userdata('cir_code'),
            'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'lot_no' => $this->session->userdata('lot_no'),
        ];
        $data['villages'] = $this->utilityclass->getVillages($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $this->session->userdata('mouza_pargona_code'), $this->session->userdata('lot_no'));

        $data['users'] = $this->rtpsmodel->usersForOffice($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'));

        $data['_view'] = 'lm_office_conversion/GenerateApplication';
        $this->load->view('layouts/main',$data);
    }
    // end added
    //added by hriday - 25-04-2024
    public function submitApplication() {
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'dist_code'=>'District Code|required|digit',
            'subdiv_code'=>'Subdivisional Code|required|digit',
            'cir_code'=>'Circle Code|required|digit',
            'mouza_pargona_code'=>'Mouza Pargona Code|required|digit',
            'lot_no'=>'Lot No.|required|digit',
            'vill_townprt_code'=>'Village code|required|digit',
            'dag_no'=>'Dag No|required|digit',
            'bigha'=>'Bigha|required|digit',
            'katha'=>'Katha|required|katha',
            'lessa'=>'Lessa|required|lessa',
            'circleofficer'=>'Circle Officer|required',
            'pattadars'=>'Pattadars|required|digit'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRCONVLMAPPSUBMIT001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVLMAPPSUBMIT001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error:  ERRCONVLMAPPSUBMIT001');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
            exit();
        }
        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['pattadars'=>['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']], [], ['pattadars'=>true]);
        if($requestResponse['status'] == 'n') {
            //ERRCONVLMAPPSUBMIT002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLMAPPSUBMIT002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVLMAPPSUBMIT002');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVLMAPPSUBMIT003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLMAPPSUBMIT003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVLMAPPSUBMIT003');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
        }

        if($_FILES['landdetails']['error'] == 4 || $_FILES['landrevenue']['error'] == 4 || $_FILES['annualpatta']['error'] == 4 || $_FILES['scheduleland']['error'] == 4 || $_FILES['chitha']['error'] == 4 || $_FILES['idproof']['error'] == 4) {
            //ERRCONVLMAPPSUBMIT004
            log_message('error', 'All files not uploaded. Error: ERRCONVLMAPPSUBMIT004');
            $this->session->set_flashdata('message', 'Files not uploaded. Error: ERRCONVLMAPPSUBMIT004');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
        }

        //extracting inputs
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');
        $bigha = $this->input->post('bigha');
        $katha = $this->input->post('katha');
        $lessa = $this->input->post('lessa');
        $circleofficer = $this->input->post('circleofficer');
        $pattadars = $this->input->post('pattadars');

        $path = CONVERSION_CHITHA_DOCUMENT_BASE_DIR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|pdf';
        $config['max_size'] = MAX_SIZE;
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $this->load->library('upload', $config);

        $landdetailsFile = [];
        $landrevenueFile = [];
        $annualpattaFile =  [];
        $schedulelandFile = [];
        $chithaFile = [];
        $idproofFile = [];

        if($_FILES['landdetails']['name'] != '' && $_FILES['landdetails']['name'] != null) {
            $this->upload->do_upload('landdetails');
            $landdetailsFile = $this->upload->data();
        }
        if($_FILES['landrevenue']['name'] != '' && $_FILES['landrevenue']['name'] != null) {
            $this->upload->do_upload('landrevenue');
            $landrevenueFile = $this->upload->data();
        } 
        if($_FILES['annualpatta']['name'] != '' && $_FILES['annualpatta']['name'] != null) {
            $this->upload->do_upload('annualpatta');
            $annualpattaFile = $this->upload->data();
        } 
        if($_FILES['scheduleland']['name'] != '' && $_FILES['scheduleland']['name'] != null) {
            $this->upload->do_upload('scheduleland');
            $schedulelandFile = $this->upload->data();
        } 
        if($_FILES['chitha']['name'] != '' && $_FILES['chitha']['name'] != null) {
            $this->upload->do_upload('chitha');
            $chithaFile = $this->upload->data();
        } 
        if($_FILES['idproof']['name'] != '' && $_FILES['idproof']['name'] != null) {
            $this->upload->do_upload('idproof');
            $idproofFile = $this->upload->data();
        }

        $this->db->trans_begin();

        $ast_code = $this->utilityclass->getAstCode($dist_code, $subdiv_code, $cir_code)->user_code;

        $dagDetails = $this->utilityclass->getDagDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no);

        $originalbigha = $dagDetails['dag_details']->dag_area_b;
        $originalkatha = $dagDetails['dag_details']->dag_area_k;
        $originallessa = $dagDetails['dag_details']->dag_area_lc;
        $patta_no = $dagDetails['dag_details']->patta_no;
        $patta_type_code = $dagDetails['dag_details']->patta_type_code;

        $originalarea = ($originalbigha * 5 * 20) + ($originalkatha * 20) + $originallessa;
        $currentarea = ($bigha * 5 * 20) + ($katha * 20) + $lessa;

        $partialpatta = 0;
        $trans_code = 'F';
        if($currentarea < $originalarea) {
            $partialpatta = 1;
            $trans_code = 'P';
        }

        $case_name = $this->rtpsmodel->genearteCaseName();
        $seq_pet = year_no.'00';
        $petition_no = $seq_pet . $this->rtpsmodel->genearteOfficePetitionNo();
        $case_no = $case_name . $petition_no . "/CONV";

        

        $basic=array(
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$cir_code,
            'mouza_pargona_code'=>$mouza_pargona_code,
            'lot_no'=>$lot_no,
            'vill_townprt_code'=>$vill_townprt_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no,
            'mut_type'=>'01', /////mut type
            'trans_code'=>$trans_code,/////////full
            'petition_no'=>$petition_no,
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$ast_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $circleofficer,
            'add_off_desig' =>'CO',
            'supported_doc' => 'Y',
            'operation' => 'E',
            'co_user_code' =>$circleofficer
            ///////// 
        );
        $insertPetitionBasic = $this->db->insert('petition_basic', $basic);
        if($insertPetitionBasic != 1) {
            //ERRCONVLMAPPSUBMIT005
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVLMAPPSUBMIT005: Insertion failed in petition_basic');
            $this->session->set_flashdata('message', 'Insertion failed in Petition Basic. Error: ERRCONVLMAPPSUBMIT005');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
        }

       

        $petitionDagDetails = array(
            'dist_code'=>$dist_code,
            'subdiv_code'=>$subdiv_code,
            'cir_code'=>$cir_code,
            'mouza_pargona_code'=>$mouza_pargona_code,
            'lot_no'=>$lot_no,
            'vill_townprt_code'=>$vill_townprt_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no,
            'petition_no'=>$petition_no,
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$dag_no,
            'patta_no'=>$patta_no,
            'patta_type_code'=>$patta_type_code,
            'm_dag_area_b'=>$bigha,
            'm_dag_area_k'=>$katha,
            'm_dag_area_lc'=>$lessa,
            'm_dag_area_g'=>'0.00',
            'm_dag_area_kr'=>'0',
            'dag_area_b'=>$originalbigha,
            'dag_area_k'=>$originalkatha,
            'dag_area_lc'=>$originallessa,
            'dag_area_g'=>'0',
            'dag_area_kr'=>'0',
            'revenue'=>0
        );
        $insertPetitionDagDetails = $this->db->insert('petition_dag_details', $petitionDagDetails);
        if($insertPetitionDagDetails != 1) {
            //ERRCONVLMAPPSUBMIT006
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVLMAPPSUBMIT006: Insertion failed in petition_dag_details');
            $this->session->set_flashdata('message', 'Insertion failed in Petition Dag. Error: ERRCONVLMAPPSUBMIT006');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
        }

        


        $count = 0;
        foreach ($pattadars as $pattadar) {
            $pattadarDetails = $this->utilityclass->getPattadarDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $patta_type_code, $pattadar);

            if($pattadarDetails->pdar_id == null || $pattadarDetails->pdar_name == null) {
                //ERRCONVLMAPPSUBMIT010
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVLMAPPSUBMIT010: '. $pattadarDetails->pdar_name .'is not found or it id is not found');
                $this->session->set_flashdata('message', 'Pattadar not available. Error: ERRCONVLMAPPSUBMIT010');
                redirect(base_url('index.php/LMconversionPartha/generateApplication'));
                exit;
            }

            $petitioner = array(
                'dist_code'=>$dist_code,
                'subdiv_code'=>$subdiv_code,
                'cir_code'=>$cir_code,
                'mouza_pargona_code'=>$mouza_pargona_code,
                'lot_no'=>$lot_no,
                'vill_townprt_code'=>$vill_townprt_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no,
                'petition_no'=>$petition_no,
                'operation'=>'E',
                'dag_no' =>$dag_no,
                'patta_no' =>$patta_no,
                'patta_type_code'=>$patta_type_code,
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$pattadarDetails->pdar_id,
                'pdar_cron_no'=>$count++,
                'pdar_name' =>$pattadarDetails->pdar_name,
                'pdar_guardian' =>($pattadarDetails->pdar_father) ? ($pattadarDetails->pdar_father) : '',
                'pdar_rel_guar' =>($pattadarDetails->pdar_guard_reln) ? ($pattadarDetails->pdar_guard_reln) : '',
                'pdar_gender'=>($pattadarDetails->pdar_gender) ? ($pattadarDetails->pdar_gender) : '',
                'pdar_add1' => ($pattadarDetails->pdar_add1) ? ($pattadarDetails->pdar_add1) : '',
                'pdar_add2' => ($pattadarDetails->pdar_add2) ? ($pattadarDetails->pdar_add2) : '',
                'pdar_mobile' => ($pattadarDetails->pdar_mobile) ? ($pattadarDetails->pdar_mobile) : '',
                // 'self_declaration' => $dec,
                // 'auth_type' => $auth_type,
                // 'id_ref_no'=> $id_ref_no,
                // 'photo'=> $photo
            );
            $insertPetitionerPart = $this->db->insert('petitioner_part',$petitioner);
            if($insertPetitionerPart != 1) {
                //ERRCONVLMAPPSUBMIT007
                $this->db->trans_rollback();
                log_message('error', '#ERRCONVLMAPPSUBMIT007: Insertion failed in petitioner_part');
                $this->session->set_flashdata('message', 'Insertion failed in Petitioner Part. Error: ERRCONVLMAPPSUBMIT007');
                redirect(base_url('index.php/LMconversionPartha/generateApplication'));
                exit;
            }
        }

        
        if(!empty($landdetailsFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'LAND_DETAILS',
                'file_type'=>$landdetailsFile['file_type'],
                'file_path'=>$path . $landdetailsFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertLandDetailsFile = $this->db->insert('supportive_document', $fileData);
        }
        if(!empty($landrevenueFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'LAND_REVENUE',
                'file_type'=>$landrevenueFile['file_type'],
                'file_path'=>$path . $landrevenueFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertLandRevenueFile = $this->db->insert('supportive_document', $fileData);
        }
        if(!empty($annualpattaFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'ANNUAL_PATTA',
                'file_type'=>$annualpattaFile['file_type'],
                'file_path'=>$path . $annualpattaFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertAnnualPattaFile = $this->db->insert('supportive_document', $fileData);
        }
        if(!empty($schedulelandFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'SCHEDULE_LAND',
                'file_type'=>$schedulelandFile['file_type'],
                'file_path'=>$path . $schedulelandFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertScheduleLandFile = $this->db->insert('supportive_document', $fileData);
        }
        if(!empty($chithaFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'CHITHA',
                'file_type'=>$chithaFile['file_type'],
                'file_path'=>$path . $chithaFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertChithaFile = $this->db->insert('supportive_document', $fileData);
        }
        if(!empty($idproofFile)) {
            $fileData = [
                'case_no'=> $case_no,
                'user_code'=>$this->session->userdata('user_code'),
                'file_name'=>'ID_PROOF',
                'file_type'=>$idproofFile['file_type'],
                'file_path'=>$path . $idproofFile['file_name'],
                'date_entry'=>date('Y-m-d h:i:s'),
                'mut_type'=>'NA'
            ];
            $insertIdProofFile = $this->db->insert('supportive_document', $fileData);
        }

       

        if($insertLandDetailsFile != 1 || $insertLandRevenueFile != 1 || $insertAnnualPattaFile != 1 || $insertScheduleLandFile != 1 || $insertChithaFile != 1 || $insertIdProofFile != 1) {
             //ERRCONVLMAPPSUBMIT008
             $this->db->trans_rollback();
             log_message('error', '#ERRCONVLMAPPSUBMIT008: All files not uploaded');
             $this->session->set_flashdata('message', 'All files not uploaded. Error: ERRCONVLMAPPSUBMIT008');
             redirect(base_url('index.php/LMconversionPartha/generateApplication'));
             exit;
        }

        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
            //ERRCONVLMAPPSUBMIT009
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVLMAPPSUBMIT009: Error in Submitting.');
            $this->session->set_flashdata('message', 'Error in Submitting. Error: ERRCONVLMAPPSUBMIT009');
            redirect(base_url('index.php/LMconversionPartha/generateApplication'));
            exit;
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Successfully Submitted. Case No generated is: '. $case_no);
        redirect(base_url('index.php/home'));
        exit;
    }
    // end added
    
    public function index() {
		//$db=  $this->session->userdata('db');
        $date = date('Y-m-d');
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        //echo $user_code." ".$dist_code." ".$subdiv_code." ".$cir_code." ".$mouza_pargona_code." ".$lot_no;
        $landClass = $this->mutationmodel->getLandClass();
        $data['land_class'] = $landClass;
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and is_mb3!=1")->row();
        //var_dump($petition_basic);
        $landdetails = $this->db->query("select * from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();
        //var_dump($landdetails);
        
        $dag_no = $landdetails['dag_no'];
        $patta_no = trim($landdetails['patta_no']);
        $patta_type_code = $landdetails['patta_type_code'];
        
        $actual_land_details = $this->db->query("Select * from    chitha_basic where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and dag_no='$dag_no' and patta_type_code = '$patta_type_code' and TRIM(patta_no) = '$patta_no'")->row();
        //newly added by hridayjit-------//
        $mutated_dag_area_b = $landdetails['m_dag_area_b'];
        $mutated_dag_area_k = $landdetails['m_dag_area_k'];
        $mutated_dag_area_lc = $landdetails['m_dag_area_lc'];
        $mutated_dag_area_g = $landdetails['m_dag_area_g'];
        $original_dag_area_b = $actual_land_details->dag_area_b;
        $original_dag_area_k = $actual_land_details->dag_area_k;
        $original_dag_area_lc = $actual_land_details->dag_area_lc;
        $original_dag_area_g = $actual_land_details->dag_area_g;
        //-------//
        $actual_land_details = $actual_land_details->land_class_code;
        $actual_land_name = $this->db->query("select * from    landclass_code where class_code = '$actual_land_details'")->row();
        $namelm = $this->db->query("select * from    lm_code where lm_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
        $lm_name=$namelm->lm_name;
        $lm_code=$user_code;
        
        $m_dag_area_lc = $landdetails['m_dag_area_lc'];
        $m_dag_area_lc = round($m_dag_area_lc, 2);
        $l_m_dag_area_lc = $landdetails['dag_area_lc'];
        $l_m_dag_area_lc = round($l_m_dag_area_lc, 2);
        if($landdetails['dag_area_b'] == '')
        {
            $l_m_dag_area_b = '0';
        }
        else {
            $l_m_dag_area_b = $landdetails['dag_area_b'];
        }
        if($landdetails['dag_area_k'] == '')
        {
            $l_m_dag_area_k = '0';
        }
        else {
            $l_m_dag_area_k = $landdetails['dag_area_k'];
        }
        
        $data['land_details'] = array(
            'dag' => $landdetails['dag_no'],
            'dag_area_b' => $landdetails['m_dag_area_b'],
            'dag_area_k' => $landdetails['m_dag_area_k'],
            'dag_area_lc' => $m_dag_area_lc,
            //newly added by hridayjit //
            'o_dag_area_b' => $mutated_dag_area_b,
            'o_dag_area_k' => $mutated_dag_area_k,
            'o_dag_area_lc' => $mutated_dag_area_lc,
            'o_dag_area_g' => $mutated_dag_area_g,
            //------------------------//
            'l_dag_area_b' => $l_m_dag_area_b,
            'l_dag_area_k' => $l_m_dag_area_k,
            'l_dag_area_lc' => $l_m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'case_no' => $case_no,
            'lm_name' => $lm_name,
            'lm_code' => $lm_code,
            'land_class_actual_name' => $actual_land_name->land_type,
            'land_class_code' => $actual_land_details
        );
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,add_off_name"
                . " from    petition_basic where case_no='$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and is_mb3!=1")->row_array();
        $isRural = $this->db->query("select rural_urban, uuid"
        . " from    location where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
        . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
        . "and mouza_pargona_code='$petition_basic->mouza_pargona_code'")->row_array();

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no'")->row_array();
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
            'date' => $date,
            'dag' => $landdetails['dag_no'],
            'm_dag_area_b' => $landdetails['m_dag_area_b'],
            'm_dag_area_k' => $landdetails['m_dag_area_k'],
            'm_dag_area_lc' => $m_dag_area_lc,
            'patta_no' => trim($landdetails['patta_no']),
            'patta_type' => $landdetails['patta_type_code'],
            'add_to' => $location['add_off_name'],
            'rural_urban' => $isRural['rural_urban'],
            'uuid' => $isRural['uuid'],
            'distcode' => $petition_basic->dist_code
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;
        
        $pattadardetails = "select id_ref_no,auth_type,pdar_id, pdar_gender, pdar_cron_no,pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2,pdar_mobile from    petitioner_part where dist_code='$petition_basic->dist_code' and "
                . "subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        $this->load->model('relation/relationmodel');
        /////////////////////
        $data['lm_details_final'] = $this->db->query("Select * from    petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' order by note_no desc limit 1")->result();
        //echo $this->db->last_query();
        ////////////////////
        $data['genders'] = $this->mutationmodel->getGenders();
        $data['relation'] = $this->relationmodel->getRelations();
        //get duplicate pdar_id
        $data['dup_pdar_id'] = $this->LMofficeConversionModel->getDuplicatePattadar($petition_basic->dist_code, $petition_basic->subdiv_code, 
        $petition_basic->cir_code, $petition_basic->mouza_pargona_code,
        $petition_basic->lot_no, $petition_basic->vill_townprt_code, $patta_no, 
        $patta_type_code, $dag_no, $case_no)->result();
        // newly added by hridayjit
        $original_area = $original_dag_area_lc + ($original_dag_area_k * 20) + ($original_dag_area_b * 20 * 5);
        $mutated_area = $mutated_dag_area_lc + ($mutated_dag_area_k * 20) + ($mutated_dag_area_b * 20 * 5);

        if($mutated_area < $original_area) {
            $data['is_partial'] = 1;
        }
        else{
            $data['is_partial'] = 0;
        }

        //new

        $conversionPremiumAreas = $this->ConversionPremiumAreasModel->get([], '*', 'multiple');
        $conversionPremiumAreaPurposeType = $this->ConversionPremiumAreaPurposeTypeModel->get([], '*', 'multiple');

        $data['premium_area_purpose'] = $conversionPremiumAreaPurposeType;
        $data['premium_areas'] = $conversionPremiumAreas;

        // echo '<pre>';
        // var_dump($conversionPremiumAreas, $conversionPremiumAreaPurposeType);
        // die;
        //
        if($petition_basic->sk_comment == 'Y') {
            $data['post_url'] = 'index.php/LMconversionPartha/SecondProcessRvrtCo';
        }
        else {
            $data['post_url'] = 'index.php/LMconversionPartha/SecondProcess';
        }

        // var_dump($data['lm_details_final']); die;
        $data['_view'] = 'lm_office_conversion/FirstProcess';
        $this->load->view('layouts/main',$data);
    }

    public function SecondProcessRvrtCo(){
        //Form Validation
        $formValidationCheck = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No|required|case_no',
            'dag_no'=>'Dag No|required|digit',
            'lm_name'=>'LM Name|required',
            'lm_code'=>'LM Code|required',
            'patta_type_code'=>'Patta Type|required|digit',
            'each_bigha_rate'=>'Bigha Rate|required|2_digit_decimal',
            'land_class'=>'Land Class|required|digit',
            'whetherOr'=>'Land Type|required',
            'premium_assesment'=>'Premium Assesment|required|digit',
            'total_premium'=>'Total Premium|required',
            'lm_notice'=>'LM Notice|required',
            'lm_sign'=>'LM Signature|required|char',
            'land_trans'=>'Land Transferred|required_on_condition(patta_type_code,equals,[0208])|char',
            'date_of_entry'=>'Date|required|date',
            'conv_b'=>'Bigha|required|digit',
            'conv_k'=>'Katha|required|katha',
            'conv_lc'=>'Lessa|required|lessa',
            'pattar_mati_hoi_ne'=>'Pattar Mati|char',
            'dokhol_ase_ne'=>'Dokhol Mati|char',
            'gos_gosoni'=>'Gos Gosoni|char',
            'miyadi_upojugi'=>'Miyadi Upojugi|char',
            'rastar_kaijo_b'=>'Rastar Kaijo Bigha|digit',
            'rastar_kaijo_k'=>'Rastar Kaijo Katha|katha',
            'rastar_kaijo_lc'=>'Rastar Kaijo Lessa|lessa',
            'nodir_kakhor'=>'Nodir Kakhor|char',
            'nodir_kaijo_b'=>'Nodir Kaijo Bigha|digit',
            'nodir_kaijo_k'=>'Nodir Kaijo Katha|katha',
            'nodir_kaijo_lc'=>'Nodir Kaijo Lessa|lessa',
            'partial_conv'=>'Partial Conversion|char',
            'partial_b'=>'Partial Bigha|digit',
            'partial_k'=>'Partial Katha|katha',
            'partial_lc'=>'Partial Lessa|lessa',
            'jati_janajati'=>'Jati Janajati|char',
            'freedom_fighter'=>'Freedom Fighter|char',
            'widow'=>'Widow|char',
        ]);
        if($formValidationCheck['status'] == 'n') {
            //ERRCONVLM0001
            log_message('error', 'Message: '. $formValidationCheck['message'] .', Data: '. json_encode($formValidationCheck['data']) .'. Error: ERRCONVLM0001');
            $this->session->set_flashdata('message', $formValidationCheck['message'] .' Error:  ERRCONVLM0001');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
            exit();
        }

        $patta_type_code = $this->input->post('patta_type_code');

        //File validation

        if(!isset($_FILES['up_noc_conv']['name']) || $_FILES['up_noc_conv']['name'] == '') {
            //ERRCONVLM0002
            log_message('error', 'NOC upload is a required field. Error: ERRCONVLM0002');
            $this->session->set_flashdata('message', 'NOC upload is a required field. Error: ERRCONVLM0002');
            redirect(base_url('index.php/LMconversionPartha?case_no='. $_POST['case_no']));
            exit();
        }

        if($patta_type_code == '0208') {
            if(!isset($_FILES['up_doc']['name']) || $_FILES['up_doc']['name'] == '') {
                //ERRCONVLM0006
                log_message('error', 'Nispi Kheraz Document upload is a required field. Error: ERRCONVLM0006');
                $this->session->set_flashdata('message', 'Nispi Kheraz Document upload is a required field. Error: ERRCONVLM0006');
                redirect(base_url('index.php/LMconversionPartha?case_no='. $_POST['case_no']));
                exit();
            }
        }
        
        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['lm_name'=>['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']], [], ['lm_notice'=>true, 'lm_name'=>true]);//, ['co_order'=>[' ঁ']]
        if($requestResponse['status'] == 'n') {
            //ERRCONVLM0003
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLM0003');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVLM0003');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['lm_notice'=>true, 'lm_name'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVLM0004
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLM0004');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVLM0004');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
        }

        //authentication and authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_POST['case_no'], CONV_LM_RVRT_CO_SECOND);
        if($authorization['status'] == 'n') {
            //ERRCONVLM0005
            log_message('error', $authorization['messages'] . '. Error: ERRCONVLM0005');
            $this->session->set_flashdata('message', $authorization['messages'] .'. Error: ERRCONVLM0005');
            redirect(base_url('index.php/home'));
        }
        
        // echo '<pre>';
        // var_dump($_POST);
        // die();
		//$db=  $this->session->userdata('db');

        $path = UPLOAD_BASE_CONVERSIONDOCS.UPLOAD_SEPARATOR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $this->db->trans_begin();
        // $config['upload_path'] = './ConversionDocs/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $this->load->library('upload', $config);
        
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');



        $check_premium_assesment = $this->input->post('premium_assesment');
        $check_total_premium = $this->input->post('total_premium');
        $check_whetherOr = $this->input->post('whetherOr');

        if($check_whetherOr == null || $check_total_premium == null || $check_whetherOr == null || $check_whetherOr == '' || $check_total_premium == '' || $check_whetherOr == ''){

            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMMRI001: Validation errors please check form details entry !");
            log_message("error","LMMRI001: Validation errors please check form details entry ! case no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }





        $entry_date =  date('Y-m-d',strtotime($this->input->post('date_of_entry')));
        
        $checkfile_jati_janajati = $_FILES['filename_jati_janajati']['name'];
        $checkfile_freedom_fighter = $_FILES['filename_freedom_fighter']['name'];
        $checkfile_widow = $_FILES['filename_widow']['name'];

 
        if ($checkfile_jati_janajati !== "") {
            $this->upload->do_upload('filename_jati_janajati');
            $upload_data = $this->upload->data();
            $file_name_jati_janajati = $upload_data['file_name'];
        }
        if ($checkfile_freedom_fighter !== "") {
            $this->upload->do_upload('filename_freedom_fighter');
            $upload_data = $this->upload->data();
            $file_name_freedom_fighter = $upload_data['file_name'];
        }
        if ($checkfile_widow !== "") {
            $this->upload->do_upload('filename_widow');
            $upload_data = $this->upload->data();
            $file_name_widow = $upload_data['file_name'];
        }
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and 
        dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and is_mb3!=1")->row();


        //NOC upload validation starts here
        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
        // $path = './ConversionDocs/';
        
        $file = $petition_basic->petition_no.date('Y').'_'.$sl;
        
        $_FILES['file']['type'] = $_FILES['up_noc_conv']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc_conv']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc_conv']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc_conv']['size'];

        $ext = pathinfo($_FILES['up_noc_conv']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;

        $config = array(
            // 'upload_path' => './ConversionDocs/',
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
                $this->session->set_flashdata('message', "LMCR0001: Unable to pass order !");
                log_message("error","#LMCR0001 Uploading Failed for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////NOC ends here////////

        //DOC upload validation starts here
        if($patta_type_code == '0208') {
            $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
            $sl = $count+1;
            // $path = './ConversionDocs/';
            
            $docfile = $petition_basic->petition_no.'_'.date('Y').'_nisfi_kheraz_'.$sl;
            
            $_FILES['file']['type'] = $_FILES['up_doc']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['up_doc']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['up_doc']['error'];
            $_FILES['file']['size'] = $_FILES['up_doc']['size'];
    
            $ext = pathinfo($_FILES['up_doc']['name'], PATHINFO_EXTENSION);
            $_FILES['file']['name'] = $docfile.'.'.$ext;
    
            $config = array(
                // 'upload_path' => './ConversionDocs/',
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
                    'file_name' => 'NISFI KHERAZ',
                    'fetch_file_name' => $docfile.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$docfile.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "NISPIKHERAZDOC0001: Unable to pass order !");
                    log_message("error","#NISPIKHERAZ0001 Uploading Failed for dist:"
                                .$dist_code.", case no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }
        }
        ////////////DOC ends here////////


        
        $note_no = $this->db->query("select max(note_no) as note_no from    petition_lm_note where petition_no = '$petition_basic->petition_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' limit 1")->row()->note_no;
        if ($note_no == null) {
            $note_no = 1;
        } else {
            $note_no += 1;
        }
        // $whetherOr = $this->input->post('whetherOr');
        // if($whetherOr == 'withintown')
        // {
        //     $distance = '0';
        //     //$inside_outside = 'i';
        //     $inside_outside = 'd';
        // }
        // if($whetherOr == 'within3km')
        // {
        //     $distance = '3';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'within10km')
        // {
        //     $distance = '10';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'within15km')
        // {
        //     $distance = '15';
        //     $inside_outside = 'g';
        // }
        // if($whetherOr == 'withinRev')
        // {
        //     $distance = '1';
        //     $inside_outside = 'o';
        // }
        // if($whetherOr == 'withinrural')
        // {
        //     $distance = '0';
        //     $inside_outside = 'o';
        // }
        // if($whetherOr == 'withinrevenuetown')
        // {
        //     $distance = '0';
        //     $inside_outside = 'r';
        // }
        // if($whetherOr == 'withintown5km')
        // {
        //     $distance = '5';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'withinmunicipal')
        // {
        //     $distance = '0';
        //     $inside_outside = 'm';
        // }
        // if($whetherOr == 'withinmunicipal5km')
        // {
        //     $distance = '5';
        //     $inside_outside = 'm';
        // }
        // if($whetherOr == 'withinghy')
        // {
        //     $distance = '0';
        //     $inside_outside = 'g';
        // }
        // if rastar hongrokhon thake than update the petition_dag_details
        //if(($this->input->post('rastar_kaijo_b')!="0") || ($this->input->post('rastar_kaijo_k')!="0") || ($this->input->post('rastar_kaijo_lc')!="0")){
        // newly added by hridayjit
        $rastarkakhoroldnew = '';
        $nodirkakhoroldnew = '';
        // 
        if(($this->input->post('rastar_kaijo_b')!="0") || ($this->input->post('rastar_kaijo_k')!="0") || ($this->input->post('rastar_kaijo_lc')!="0") || ($this->input->post('partial_b')!="0") || ($this->input->post('partial_k')!="0") || ($this->input->post('partial_lc')!="0")){
            
            // newly added by hridayjit
            if(isset($_POST['is_partial']) && $_POST['is_partial'] == "1" && ($this->input->post('rastar_kaijo_b')!="0" || $this->input->post('rastar_kaijo_k')!="0" || $this->input->post('rastar_kaijo_lc')!="0")) {
                $rastarkakhoroldnew = $this->input->post('rastarkakhoroldnew');
            }
            if(isset($_POST['is_partial']) && $_POST['is_partial'] == "1" && ($this->input->post('nodir_kaijo_b')!="0" || $this->input->post('nodir_kaijo_k')!="0" || $this->input->post('nodir_kaijo_lc')!="0")) {
                $nodirkakhoroldnew = $this->input->post('nodirkakhoroldnew');
            }
            // 
            $update_rasta1 = "Update  petition_basic set trans_code = 'P' where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and petition_no = '$petition_basic->petition_no'";

            $this->db->query($update_rasta1); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCR00016: Unable to pass order !");
                log_message("error","#LMCR00016 Failed to update lm trans_code in Petition_Basic for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $update_rasta2 = "update  petition_dag_details set m_dag_area_b='".$this->input->post('conv_b')."',m_dag_area_k='".$this->input->post('conv_k')."',m_dag_area_lc='".$this->input->post('conv_lc')."' where "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and petition_no = '$petition_basic->petition_no'";

            $this->db->query($update_rasta2); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCR0002: Unable to pass order !");
                log_message("error","#LMCR0002 Failed to update lm petition_dag_details for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);

        $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
            'premium_area_id' => $check_whetherOr,
            'premium_area_purpose_type_id' => $check_premium_assesment,
            'is_deleted' => 0
        ]);

        if(empty($premiumRateDetails)) {
            // ERRCONVLM0020
            $this->db->trans_rollback();
            log_message("error","Error - #ERRCONVLM0020. Could not find premium rate for this area");
            $this->session->set_flashdata('message', "#ERRCONVLM0020. Could not find premium rate for this area");
            redirect(base_url() . "index.php/home");
            return;
        }

        $petition_lm_note = array(
            'case_no'=>$petition_basic->case_no,
            'dist_code' => $petition_basic->dist_code, 
            'subdiv_code' => $petition_basic->subdiv_code,
            'cir_code' => $petition_basic->cir_code,
            'mouza_pargona_code' => $petition_basic->mouza_pargona_code,
            'lot_no' => $petition_basic->lot_no,
            'vill_townprt_code' => $petition_basic->vill_townprt_code,
            'year_no' => $petition_basic->year_no,
            'petition_no' => $petition_basic->petition_no,
            'dag_no' => $dag_no,
            'note_no' => $note_no,
            'partition_info' => $this->input->post('lm_notice'),
            'user_code' => $this->input->post('lm_code'),
            'date_entry' =>  date('Y-m-d',strtotime($this->input->post('date_of_entry'))),
            'operation' => 'E',
            'applicant_patta_yn' => $this->input->post('pattar_mati_hoi_ne'),
            'occupied_yn' => $this->input->post('dokhol_ase_ne'),
            'val_tree_yn' => $this->input->post('gos_gosoni'),
            // 'dist_frm_town' => $distance,
            // 'inside_outside_town' => $inside_outside,
            'land_class_code' => $this->input->post('land_class'),
            'issuit_forconv_under105' => $this->input->post('miyadi_upojugi'),
            'roadside_rsv_b' => $this->input->post('rastar_kaijo_b'),
            'roadside_rsv_k' => $this->input->post('rastar_kaijo_k'),
            'roadside_rsv_lc' => $this->input->post('rastar_kaijo_lc'),
            'partial_untrans_b' => $this->input->post('partial_b'),
            'partial_untrans_k' => $this->input->post('partial_k'),
            'partial_untrans_lc' => $this->input->post('partial_lc'),
            'near_river_yn' => $this->input->post('nodir_kakhor'),
            
            'conv_b' => $this->input->post('conv_b'),
            'conv_k' => $this->input->post('conv_k'),
            'conv_lc' => $this->input->post('conv_lc'),
            
            'lm_sign_yn' => $this->input->post('lm_sign'), 
            'land_trans_yn' => (isset($_POST['land_trans']) && $_POST['land_trans'] != '') ? $this->input->post('land_trans') : '',
            'lm_code' => $this->input->post('lm_code'),
            'lm_sign_date' =>  date('Y-m-d',strtotime($this->input->post('date_of_entry'))),
            'jati_janajati_yn' => $this->input->post('jati_janajati'),
            'jati_janajati_upload' => $file_name_jati_janajati,
            'freedom_fighter_yn' => $this->input->post('freedom_fighter'),
            'freedom_fighter_upload' => $file_name_freedom_fighter,
            'widow_yn' => $this->input->post('widow'),
            'widow_upload' => $file_name_widow,
            
            //premium
            'premium_assesment' => $check_premium_assesment,
            'prim_tot' => $check_total_premium,
            'prim_per_bigha' => $this->input->post('each_bigha_rate'),
            'conversion_premium_areas_id' => $check_whetherOr,
            'conversion_premium_rates_id' => $premiumRateDetails->id,
            'premium_new_yn' => 1,
            // newly added by hridayjit
            'roadside_old_new_dag_reservation' => $rastarkakhoroldnew,
            'riverside_old_new_dag_reservation' => $nodirkakhoroldnew
            // 
        );
        //$basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        // if($basundhara){
        //     $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
        //     if($rtps=='RTPS'){

        //     }else{
        //         if($inside_outside == 'o'){
        //             $petition_lm_note['prem_pay_method']='300';
        //             $petition_lm_note['prim_tot']=0;
        //         }

        //     }
        // }
        
        // if($basundhara){
        //     if($inside_outside == 'o'){
        //         $petition_lm_note['prem_pay_method']='300';
        //         $petition_lm_note['prim_tot']=0;
        //     }
        // }

        //var_dump ($petition_lm_note);
        //exit();
        $status1=$this->db->insert("petition_lm_note", $petition_lm_note);
        if($status1<1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "could not Process. Error Code(#CONL001)");
            redirect(base_url() . "index.php/home");
        }  
        
        $lm_note = "UPDATE  Petition_Basic SET proceeding_yn=null, co_order_conv_notice=null,co_order_conv_premium=null,co_order_conv_date=null, lm_note_yn = 'Y', lm_note_date = '$entry_date', sk_comment = NULL WHERE case_no = '$case_no' and dist_code='$petition_basic->dist_code' "
        . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
        . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";

        $this->db->query($lm_note); // ********************
        if($this->db->affected_rows() <=0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMCP0002: Unable to pass order !");
            log_message("error","#LMCP0002 Failed to update lm note in LM 1st proceeding in Petition_Basic for dist:"
                        .$dist_code.", petition no: ". $petition_basic->petition_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        // newly added by hridayjit
        $petitioner_part = $this->db->query("SELECT * FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND petition_no=?", [$petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->petition_no])->result();

        foreach ($petitioner_part as $value) {
            if(isset($_POST['inplacealong'. $value->pdar_id])) {
                $update_petitioner_part = $this->db->query("UPDATE petitioner_part SET inplace_alongwith=? WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND petition_no=? AND pdar_id=?", [$_POST['inplacealong'. $value->pdar_id], $petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->petition_no, $value->pdar_id]);
                if($this->db->affected_rows() <=0 ) {
                    //ERRCONVCORVRTLM0006
                    log_message('error', '#ERRCONVCORVRTLM0006/LMConversionPartha/SecondProcessRvrtCo. Could not update petitioner_part.');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', '#ERRCONVCORVRTLM0006 Could not update Inplace Alongwith');
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        // 

        
        $this->db->trans_commit();
         //////////
            $penUser='SK';
            $rmrk='Report by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $apiStatus = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if($apiStatus != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "API Error!");
                redirect(base_url() . "index.php/home");
            }

            $this->db->trans_commit();
        ///////
        $this->session->set_flashdata('message',"Report on Conversion Case no # $case_no Updated");
        redirect(base_url()."index.php/home");
        
    }
    
    public function SecondProcess(){
        //Form Validation
        $formValidationCheck = $this->FormValidationModel->formValidationForPost($_POST, [
            'case_no'=>'Case No|required|case_no',
            'dag_no'=>'Dag No|required|digit',
            'lm_name'=>'LM Name|required',
            'lm_code'=>'LM Code|required',
            'patta_type_code'=>'Patta Type|required|digit',
            'each_bigha_rate'=>'Bigha Rate|required|2_digit_decimal',
            'land_class'=>'Land Class|required|digit',
            'whetherOr'=>'Land Type|required',
            'premium_assesment'=>'Premium Assesment|required|digit',
            'total_premium'=>'Total Premium|required',
            'lm_notice'=>'LM Notice|required',
            'lm_sign'=>'LM Signature|required|char',
            'land_trans'=>'Land Transferred|required_on_condition(patta_type_code,equals,[0208])|char',
            'date_of_entry'=>'Date|required|date',
            'conv_b'=>'Bigha|required|digit',
            'conv_k'=>'Katha|required|katha',
            'conv_lc'=>'Lessa|required|lessa',
            'pattar_mati_hoi_ne'=>'Pattar Mati|char',
            'dokhol_ase_ne'=>'Dokhol Mati|char',
            'gos_gosoni'=>'Gos Gosoni|char',
            'miyadi_upojugi'=>'Miyadi Upojugi|char',
            'rastar_kaijo_b'=>'Rastar Kaijo Bigha|digit',
            'rastar_kaijo_k'=>'Rastar Kaijo Katha|katha',
            'rastar_kaijo_lc'=>'Rastar Kaijo Lessa|lessa',
            'nodir_kakhor'=>'Nodir Kakhor|char',
            'nodir_kaijo_b'=>'Nodir Kaijo Bigha|digit',
            'nodir_kaijo_k'=>'Nodir Kaijo Katha|katha',
            'nodir_kaijo_lc'=>'Nodir Kaijo Lessa|lessa',
            'partial_conv'=>'Partial Conversion|char',
            'partial_b'=>'Partial Bigha|digit',
            'partial_k'=>'Partial Katha|katha',
            'partial_lc'=>'Partial Lessa|lessa',
            'jati_janajati'=>'Jati Janajati|char',
            'freedom_fighter'=>'Freedom Fighter|char',
            'widow'=>'Widow|char',
        ]);
        if($formValidationCheck['status'] == 'n') {
            //ERRCONVLM0001
            log_message('error', 'Message: '. $formValidationCheck['message'] .', Data: '. json_encode($formValidationCheck['data']) .'. Error: ERRCONVLM0001');
            $this->session->set_flashdata('message', $formValidationCheck['message'] .' Error:  ERRCONVLM0001');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
            exit();
        }

        $patta_type_code = $this->input->post('patta_type_code');
        
        //File validation
        if(!isset($_FILES['up_noc_conv']['name']) || $_FILES['up_noc_conv']['name'] == '') {
            //ERRCONVLM0002
            log_message('error', 'NOC upload is a required field. Error: ERRCONVLM0002');
            $this->session->set_flashdata('message', 'NOC upload is a required field. Error: ERRCONVLM0002');
            redirect(base_url('index.php/LMconversionPartha?case_no='. $_POST['case_no']));
            exit();
        }

        if($patta_type_code == '0208') {
            if(!isset($_FILES['up_doc']['name']) || $_FILES['up_doc']['name'] == '') {
                //ERRCONVLM0006
                log_message('error', 'Nispi Kheraz Document upload is a required field. Error: ERRCONVLM0006');
                $this->session->set_flashdata('message', 'Nispi Kheraz Document upload is a required field. Error: ERRCONVLM0006');
                redirect(base_url('index.php/LMconversionPartha?case_no='. $_POST['case_no']));
                exit();
            }
        }
        
        //syntax validation
        $requestResponse = checkRequestSpecChar($_POST, ['lm_name'=>['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']], [], ['lm_notice'=>true, 'lm_name'=>true]);//, ['co_order'=>[' ঁ']]
        if($requestResponse['status'] == 'n') {
            //ERRCONVLM0003
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVLM0003');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVLM0003');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST, [], ['lm_notice'=>true, 'lm_name'=>true]);
        if($validResponse['status'] == 'n') {
            //ERRCONVLM0004
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVLM0004');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVLM0004');
            redirect(base_url('index.php/LMconversionPartha/GoToLM?pro=1'));
        }

        //authentication and authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'LM', $_POST['case_no'], CONV_LM_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVLM0005
            log_message('error', $authorization['messages'] . '. Error: ERRCONVLM0005');
            $this->session->set_flashdata('message', $authorization['messages'] .'. Error: ERRCONVLM0005');
            redirect(base_url('index.php/home'));
        }

        // echo '<pre>';
        // var_dump($_FILES);
        // die();
        
        // echo '<pre>';
        // var_dump($authorization, $_POST);
        // die();

        $path = UPLOAD_BASE_CONVERSIONDOCS.UPLOAD_SEPARATOR;
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }

		//$db=  $this->session->userdata('db');
        $this->db->trans_begin();
        // $config['upload_path'] = './ConversionDocs/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $this->load->library('upload', $config);
        
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');



        $check_premium_assesment = $this->input->post('premium_assesment');
        $check_total_premium = $this->input->post('total_premium');
        $check_whetherOr = $this->input->post('whetherOr');
        // $whetherOr = $this->input->post('whetherOr');

        if($check_whetherOr == null || $check_total_premium == null || $check_whetherOr == null || $check_whetherOr == '' || $check_total_premium == '' || $check_whetherOr == ''){

            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMMRI001: Validation errors please check form details entry !");
            log_message("error","LMMRI001: Validation errors please check form details entry ! case no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }





        $entry_date =  date('Y-m-d',strtotime($this->input->post('date_of_entry')));
        
        $checkfile_jati_janajati = $_FILES['filename_jati_janajati']['name'];
        $checkfile_freedom_fighter = $_FILES['filename_freedom_fighter']['name'];
        $checkfile_widow = $_FILES['filename_widow']['name'];

        
        if ($checkfile_jati_janajati !== "") {
            $this->upload->do_upload('filename_jati_janajati');
            $upload_data = $this->upload->data();
            $file_name_jati_janajati = $upload_data['file_name'];
        }
        if ($checkfile_freedom_fighter !== "") {
            $this->upload->do_upload('filename_freedom_fighter');
            $upload_data = $this->upload->data();
            $file_name_freedom_fighter = $upload_data['file_name'];
        }
        if ($checkfile_widow !== "") {
            $this->upload->do_upload('filename_widow');
            $upload_data = $this->upload->data();
            $file_name_widow = $upload_data['file_name'];
        }
        
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and 
        dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no'")->row();


        //NOC upload validation starts here

        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
        // $path = './ConversionDocs/';
        
        $file = $petition_basic->petition_no.date('Y').'_'.$sl;
        
        $_FILES['file']['type'] = $_FILES['up_noc_conv']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc_conv']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc_conv']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc_conv']['size'];

        $ext = pathinfo($_FILES['up_noc_conv']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;

        $config = array(
            // 'upload_path' => './ConversionDocs/',
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
                $this->session->set_flashdata('message', "LMCR0001: Unable to pass order !");
                log_message("error","#LMCR0001 Uploading Failed for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////NOC ends here////////


        //DOC upload validation starts here
        if($patta_type_code == '0208') {
            $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
            $sl = $count+1;
            // $path = './ConversionDocs/';
            
            $docfile = $petition_basic->petition_no.'_'.date('Y').'_nisfi_kheraz_'.$sl;
            
            $_FILES['file']['type'] = $_FILES['up_doc']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['up_doc']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['up_doc']['error'];
            $_FILES['file']['size'] = $_FILES['up_doc']['size'];
    
            $ext = pathinfo($_FILES['up_doc']['name'], PATHINFO_EXTENSION);
            $_FILES['file']['name'] = $docfile.'.'.$ext;
    
            $config = array(
                // 'upload_path' => './ConversionDocs/',
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
                    'file_name' => 'NISFI KHERAZ',
                    'fetch_file_name' => $docfile.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$docfile.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "NISPIKHERAZDOC0001: Unable to pass order !");
                    log_message("error","#NISPIKHERAZ0001 Uploading Failed for dist:"
                                .$dist_code.", case no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }
        }
        ////////////DOC ends here////////


        
        $note_no = $this->db->query("select max(note_no) as note_no from    petition_lm_note where petition_no = '$petition_basic->petition_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' limit 1")->row()->note_no;
        if ($note_no == null) {
            $note_no = 1;
        } else {
            $note_no += 1;
        }
        
        // if($whetherOr == 'withintown')
        // {
        //     $distance = '0';
        //     //$inside_outside = 'i';
        //     $inside_outside = 'd';
        // }
        // if($whetherOr == 'within3km')
        // {
        //     $distance = '3';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'within10km')
        // {
        //     $distance = '10';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'within15km')
        // {
        //     $distance = '15';
        //     $inside_outside = 'g';
        // }
        // if($whetherOr == 'withinRev')
        // {
        //     $distance = '1';
        //     $inside_outside = 'o';
        // }
        // if($whetherOr == 'withinrural')
        // {
        //     $distance = '0';
        //     $inside_outside = 'o';
        // }
        // if($whetherOr == 'withinrevenuetown')
        // {
        //     $distance = '0';
        //     $inside_outside = 'r';
        // }
        // if($whetherOr == 'withintown5km')
        // {
        //     $distance = '5';
        //     $inside_outside = 'i';
        // }
        // if($whetherOr == 'withinmunicipal')
        // {
        //     $distance = '0';
        //     $inside_outside = 'm';
        // }
        // if($whetherOr == 'withinmunicipal5km')
        // {
        //     $distance = '5';
        //     $inside_outside = 'm';
        // }
        // if($whetherOr == 'withinghy')
        // {
        //     $distance = '0';
        //     $inside_outside = 'g';
        // }
        // if rastar hongrokhon thake than update the petition_dag_details
        //if(($this->input->post('rastar_kaijo_b')!="0") || ($this->input->post('rastar_kaijo_k')!="0") || ($this->input->post('rastar_kaijo_lc')!="0")){
        //newly added by hridayjit
        $rastarkakhoroldnew = '';
        $nodirkakhoroldnew = '';
        // 
        if(($this->input->post('rastar_kaijo_b')!="0") || ($this->input->post('rastar_kaijo_k')!="0") || ($this->input->post('rastar_kaijo_lc')!="0") || ($this->input->post('partial_b')!="0") || ($this->input->post('partial_k')!="0") || ($this->input->post('partial_lc')!="0")){
            // newly added by hridayjit
            if(isset($_POST['is_partial']) && $_POST['is_partial'] == "1" && ($this->input->post('rastar_kaijo_b')!="0" || $this->input->post('rastar_kaijo_k')!="0" || $this->input->post('rastar_kaijo_lc')!="0")) {
                $rastarkakhoroldnew = $this->input->post('rastarkakhoroldnew');
            }
            if(isset($_POST['is_partial']) && $_POST['is_partial'] == "1" && ($this->input->post('nodir_kaijo_b')!="0" || $this->input->post('nodir_kaijo_k')!="0" || $this->input->post('nodir_kaijo_lc')!="0")) {
                $nodirkakhoroldnew = $this->input->post('nodirkakhoroldnew');
            }
            //
            
            $update_rasta1 = "Update  petition_basic set trans_code = 'P' where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and petition_no = '$petition_basic->petition_no'";

            $this->db->query($update_rasta1); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCR00016: Unable to pass order !");
                log_message("error","#LMCR00016 Failed to update lm trans_code in Petition_Basic for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $update_rasta2 = "update  petition_dag_details set m_dag_area_b='".$this->input->post('conv_b')."',m_dag_area_k='".$this->input->post('conv_k')."',m_dag_area_lc='".$this->input->post('conv_lc')."' where "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code ='$mouza_pargona_code' and lot_no='$lot_no' and petition_no = '$petition_basic->petition_no'";

            $this->db->query($update_rasta2); // ********************
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "LMCR0002: Unable to pass order !");
                log_message("error","#LMCR0002 Failed to update lm petition_dag_details for dist:"
                            .$dist_code.", case no: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        
        $premiumRateDetails = $this->ConversionPremiumRatesModel->get([
            'premium_area_id' => $check_whetherOr,
            'premium_area_purpose_type_id' => $check_premium_assesment,
            'is_deleted' => 0
        ]);

        if(empty($premiumRateDetails)) {
            // ERRCONVLM0020
            $this->db->trans_rollback();
            log_message("error","Error - #ERRCONVLM0020. Could not find premium rate for this area");
            $this->session->set_flashdata('message', "#ERRCONVLM0020. Could not find premium rate for this area");
            redirect(base_url() . "index.php/home");
            return;
        }

        $petition_lm_note = array(
            'case_no'=>$petition_basic->case_no,
            'dist_code' => $petition_basic->dist_code, 
            'subdiv_code' => $petition_basic->subdiv_code,
            'cir_code' => $petition_basic->cir_code,
            'mouza_pargona_code' => $petition_basic->mouza_pargona_code,
            'lot_no' => $petition_basic->lot_no,
            'vill_townprt_code' => $petition_basic->vill_townprt_code,
            'year_no' => $petition_basic->year_no,
            'petition_no' => $petition_basic->petition_no,
            'dag_no' => $dag_no,
            'note_no' => $note_no,
            'partition_info' => $this->input->post('lm_notice'),
            'user_code' => $this->input->post('lm_code'),
            'date_entry' =>  date('Y-m-d',strtotime($this->input->post('date_of_entry'))),
            'operation' => 'E',
            'applicant_patta_yn' => $this->input->post('pattar_mati_hoi_ne'),
            'occupied_yn' => $this->input->post('dokhol_ase_ne'),
            'val_tree_yn' => $this->input->post('gos_gosoni'),
            // 'dist_frm_town' => $distance,
            // 'inside_outside_town' => $inside_outside,
            'land_class_code' => $this->input->post('land_class'),
            'issuit_forconv_under105' => $this->input->post('miyadi_upojugi'),
            'roadside_rsv_b' => $this->input->post('rastar_kaijo_b'),
            'roadside_rsv_k' => $this->input->post('rastar_kaijo_k'),
            'roadside_rsv_lc' => $this->input->post('rastar_kaijo_lc'),
            'partial_untrans_b' => $this->input->post('partial_b'),
            'partial_untrans_k' => $this->input->post('partial_k'),
            'partial_untrans_lc' => $this->input->post('partial_lc'),
            'near_river_yn' => $this->input->post('nodir_kakhor'),
            
            'conv_b' => $this->input->post('conv_b'),
            'conv_k' => $this->input->post('conv_k'),
            'conv_lc' => $this->input->post('conv_lc'),
            
            'lm_sign_yn' => $this->input->post('lm_sign'), 
            'land_trans_yn' => (isset($_POST['land_trans']) && $_POST['land_trans'] != '') ? $this->input->post('land_trans') : '',
            'lm_code' => $this->input->post('lm_code'),
            'lm_sign_date' =>  date('Y-m-d',strtotime($this->input->post('date_of_entry'))),
            'jati_janajati_yn' => $this->input->post('jati_janajati'),
            'jati_janajati_upload' => $file_name_jati_janajati,
            'freedom_fighter_yn' => $this->input->post('freedom_fighter'),
            'freedom_fighter_upload' => $file_name_freedom_fighter,
            'widow_yn' => $this->input->post('widow'),
            'widow_upload' => $file_name_widow,
            //premium
            'premium_assesment' => $check_premium_assesment,
            'prim_tot' => $check_total_premium,
            'prim_per_bigha' => $this->input->post('each_bigha_rate'),
            'conversion_premium_areas_id' => $check_whetherOr,
            'conversion_premium_rates_id' => $premiumRateDetails->id,
            'premium_new_yn' => 1,
            // newly added by hridayjit
            'roadside_old_new_dag_reservation' => $rastarkakhoroldnew,
            'riverside_old_new_dag_reservation' => $nodirkakhoroldnew
            // 
        );
        
        // if($basundhara){
        //     $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
        //     if($rtps=='RTPS'){

        //     }else{
        //         if($inside_outside == 'o'){
        //             $petition_lm_note['prem_pay_method']='300';
        //             $petition_lm_note['prim_tot']=0;
        //         }

        //     }
        // }
        
       
        $status1=$this->db->insert("petition_lm_note", $petition_lm_note);
        if($status1<1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "could not Process. Error Code(#CONL001)");
            redirect(base_url() . "index.php/home");
        }  
        
        $lm_note = "UPDATE  Petition_Basic SET proceeding_yn=null, co_order_conv_notice=null,co_order_conv_premium=null,co_order_conv_date=null, lm_note_yn = 'Y', lm_note_date = '$entry_date', sk_comment = NULL WHERE case_no = '$case_no' and dist_code='$petition_basic->dist_code' "
        . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
        . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code'";

        $this->db->query($lm_note); // ********************
        if($this->db->affected_rows() <=0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "LMCP0002: Unable to pass order !");
            log_message("error","#LMCP0002 Failed to update lm note in LM 1st proceeding in Petition_Basic for dist:"
                        .$dist_code.", petition no: ". $petition_basic->petition_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        // newly added by hridayjit - 25-04-2024 
        $petitioner_part = $this->db->query("SELECT * FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND petition_no=?", [$petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->petition_no])->result();

        foreach ($petitioner_part as $value) {
            if(isset($_POST['inplacealong'. $value->pdar_id])) {
                $update_petitioner_part = $this->db->query("UPDATE petitioner_part SET inplace_alongwith=? WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND petition_no=? AND pdar_id=?", [$_POST['inplacealong'. $value->pdar_id], $petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code, $petition_basic->petition_no, $value->pdar_id]);
                if($this->db->affected_rows() <=0 ) {
                    //ERRCONVLM0006
                    log_message('error', '#ERRCONVLM0006/LMConversionPartha/SecondProcess. Could not update petitioner_part.');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', '#ERRCONVLM0006 Could not update Inplace Alongwith');
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        // 
         if($petition_basic->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            $serviceChoose = explode('/',$case_no);
            $next_date_of_hearing = $petition_basic->next_date_of_hearing.date(' H:i:s');

            // log_message("error", "#POSTPARAMS3353 :".json_encode($_POST));

            $escalationUpdateStatus = $this->ConversionEscalationModel->escalationLmConversionReport($executionDate, $petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $case_no, $user_code, $check_whetherOr);

            // log_message("error", "#ESC3356, transaction-error-STATUS======".json_encode($escalationUpdateStatus['responseType']));

            if($escalationUpdateStatus['responseType'] == 0)
            {
                $this->db->trans_rollback();
                // log_message("error", "#ESC3356, transaction-error in method 'NameCorrectionV2/namecorrectLMPost' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong. NCOR- Error Code(#ESC3356)");
                redirect(base_url() . "index.php/home");
            }
            ///////////////END ESCALATION//////////////
        }

        

        
        
         //////////
            $penUser='SK';
            $rmrk='Report by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $apiStatus = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if($apiStatus != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "API Error!");
                redirect(base_url() . "index.php/home");
            }

            $this->db->trans_commit();
        ///////
        $this->session->set_flashdata('message',"Report on Conversion Case no # $case_no Updated");
        redirect(base_url()."index.php/home");
        
    }
    
    public function Calculate_premium($percent,$bigha,$katha,$lessa,$zonal_rate,$jati_janajati,$freedom_fighter,$widow)
    {
        $percentage = $percent;
        $On_amount = $zonal_rate;
        
        if(($percentage == '40') || ($percentage == '20'))//if 40rupees and 20rupees
        {
            $amount=$percentage;
        }
        else
        {
            $amount=($percentage / 100) * $On_amount;
        }
        
        if(($jati_janajati == 'true') || ($freedom_fighter == 'true') || ($widow == 'true'))
        {
            $deduct_amount = (25/100) * $amount;
            $tot_amount = $amount - $deduct_amount;
        }
        else{
            $tot_amount = $amount;
        }
        
        
        $total_lessa = (int)$bigha * 100 + (int)$katha * 20 + (int)$lessa;
        $premium = $total_lessa * $tot_amount / 100;
        
        $json[] = array('premium' => $premium);
        echo json_encode($json);
    }

    function DashboardData($case_no,$penUser,$rmrk){
            //////////////Update Dashboard Database///////////////////////
                    $this->dbb = $this->load->database('dash', TRUE);
                    $base=array(
                        'pending_with_user' => $penUser
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

        function DashboardDataFinal($case_no){
            //////////////Update Dashboard Database///////////////////////
                        $this->dbb = $this->load->database('dash', TRUE);
                        $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'F',
                            'remark'=>'Final Order Passed'
                        );
                        $this->dbb->where('case_no',$case_no);
                        $this->dbb->update('dashboard_data',$base);
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

    function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'R',
                            'remark'=>'Case Rejected'
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
            }
            public function popUpNewApplicantConv()
    {
        $case_no = $this->input->post('case_no');   

        //get location, dag, patta details
        $q = $this->db->query("SELECT dist_code, subdiv_code, cir_code, 
        mouza_pargona_code, lot_no, vill_townprt_code, dag_no, patta_no, 
        patta_type_code FROM petition_dag_details WHERE case_no=?", $case_no)->row();

        //get pattadar list
        $getPattadar = $this->LMofficeConversionModel->getPattadar($q->dag_no, $q->dist_code, 
            $q->subdiv_code, $q->cir_code, $q->mouza_pargona_code, $q->lot_no, 
            $q->vill_townprt_code, $q->patta_no, $q->patta_type_code, $case_no);

        $json['success'] = 'true';
        $json['applicants'] = $getPattadar->result();
        echo json_encode($json);
        return;
    }
    //onchange applicant
    public function applicantChangeConv(){

        $dist = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir = $this->session->userdata('cir_code');
        $mouza = $this->session->userdata('mouza_pargona_code');
        $lot = $this->session->userdata('lot_no');

        $val = $this->input->post();
        $case_no = $val['case_no'];
        $dag_no = $val['dag_no'];
        $pn = $val['patta_no'];
        $ptype = $val['patta_type'];

        $vill = $this->db->query("SELECT vill_townprt_code FROM petition_basic WHERE case_no=?
            AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            AND lot_no=?", array($case_no, $dist, $sub, $cir, $mouza, $lot))->row()->vill_townprt_code;

        $json['pattadar'] = $this->LMofficeConversionModel->getPattadar($dag_no, $dist, $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $case_no)->row();
        echo json_encode($json);
        return;
    }
    //add new nok for conversion case        
    public function addNewApplicantConv()
    {
        $json = null;
        $applicantValidation = [
            [
                'field' => 'appl_name_conv',
                'label' => 'Applicant`s Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'guardian_name_conv',
                'label' => 'Guardian Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'rel_conv',
                'label' => 'Guardian Relation ',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gender_conv',
                'label' => 'Gender',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'dob_conv',
                'label' => 'Date of Birth',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'address_conv',
                'label' => 'Address',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($applicantValidation);
        if($this->form_validation->run('applicantValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($applicantValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $val = $this->input->post();
            $case_no = $val['case_no'];
            $dag_no = $val['dag_no'];
            $patta_no = $val['patta_no'];
            $patta_type = $val['patta_type'];

            //get location detail
            $loc = $this->db->query("SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,
                lot_no, vill_townprt_code FROM petition_dag_details WHERE case_no=? AND 
                dag_no=? AND patta_no=? AND patta_type_code=?", array($case_no, $dag_no, 
                    $patta_no, $patta_type))->row();
            
            //get max pdar_cron_no
            $cron = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no FROM petitioner_part 
                WHERE case_no=?", $case_no)->row()->cron_no;

            //get petitioner`s clone
            $petitioner = $this->db->query("SELECT * FROM petitioner_part 
            WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ", 
            array($case_no, $loc->dist_code, $loc->subdiv_code, $loc->cir_code, 
                $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code));

            $this->db->trans_begin();

            //insert into petitioner_part
            $pet = $petitioner->row();
            $data = clone $pet;
            $data->pdar_id = $val['appl_name_conv'];
            $data->pdar_cron_no = $cron;
            $data->pdar_name = $val['applicant_name'];
            $data->pdar_guardian = $val['guardian_name_conv'];
            $data->pdar_rel_guar = $val['rel_conv'];
            $data->pdar_add1 = $val['address_conv'];
            $data->user_code = $this->session->userdata('user_code');
            $data->date_entry = date('Y-m-d h:i:s');
            $data->operation = 'E';
            $data->pdar_gender = $val['gender_conv'];
            $data->case_no = $case_no;
            unset($data->id);
            $insert = $this->db->insert('petitioner_part', $data);
            if($insert != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV01: Insertion failed in petitioner_part for case no :'. $case_no);
                $json = [
                    'message'=>"#ERRCONV01: Failed to Add New Applicant for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
            $this->db->trans_commit();

            //get petitioner`s table display list
            $getdetails = $this->LMofficeConversionModel->getAllPetitioners($case_no, $loc->dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code, $dag_no, $patta_no);

            //get duplicate pdar_id
            $getDuplicatePattadar = $this->LMofficeConversionModel->getDuplicatePattadar($loc->dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code, $patta_no, $patta_type, $dag_no, $case_no);

            //pattadar list
            $pattadarList = $this->LMofficeConversionModel->getPattadar($dag_no, $loc->dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code, $patta_no, $patta_type, $case_no);
            
            $json = [
                'success' => 'true',
                'applicants' => $getdetails->result(),
                'duplicate' => $getDuplicatePattadar->result(),
                'message' => 'New Applicant successfully added...',
                'pattadarList' => $pattadarList->result()
            ];
        }
        echo json_encode($json);
        return false;
    } 
    //delete applicant
    public function deleteApplicantConv()
    {
        $val = $this->input->post();
        $case_no = $val['case_no'];
        $pid = $val['pid'];
        $pcron = $val['pcron'];
        $dag = $val['dag'];
        $pn = $val['patta'];
        $ptype = $val['patta_type'];
        $dist = $val['dist'];
        $sub = $val['sub'];
        $cir = $val['cir'];
        $mouza = $val['mouza'];
        $lot = $val['lot'];
        $vill = $val['vill'];

        //get applicant detail to be deleted
        $toBeDelete = $this->db->query("SELECT * FROM petitioner_part WHERE 
        case_no=? AND pdar_id=? AND pdar_cron_no=? AND dist_code=? AND 
        subdiv_code=? AND cir_code=? AND
        mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=? AND 
        patta_no=? AND patta_type_code=?", 
        array($case_no, $pid, $pcron, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pn, $ptype));

        $this->db->trans_begin();

        //insert into basundhara_data_updation
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        $data = [
            'ip'=>$this->utilityclass->get_client_ip(),
            'case_no' => $case_no,
            'basundhara' => $basundhara,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($toBeDelete->row()),
        ];
        $insBasu = $this->db->insert('basundhara_data_updation', $data);
        if($insBasu != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV04: Insertion failed in basundhara_data_updation 
                for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV04: Failed to delete the Applicant for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        //delete applicant from petitioner_part
        $deleteAppl = $this->db->query("DELETE FROM petitioner_part WHERE 
        case_no=? AND pdar_id=? AND pdar_cron_no=? AND dist_code=? AND 
        subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
        AND vill_townprt_code=? AND dag_no=? AND patta_no=? AND patta_type_code=?",
        array($case_no, $pid, $pcron, $dist, $sub, $cir, $mouza, $lot, $vill, $dag, $pn, $ptype));
        if($deleteAppl != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV05: Deletion from petitioner_part is failed
                for case no :'. $case_no);
            $json = [
                'message'=>"#ERRCONV05: Failed to delete the Applicant for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }

        $this->db->trans_commit();

        //get pattadar list
        $getPattadar = $this->LMofficeConversionModel->getPattadar($dag, $dist, 
            $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $case_no);
        //echo $this->db->last_query(); return;

        //get all petitioners
        $getdetails = $this->LMofficeConversionModel->getAllPetitioners($case_no, $dist, 
            $sub, $cir, $mouza, $lot, $vill, $dag, $pn);

        //get duplicate pdar_id
        $getDuplicatePattadar = $this->LMofficeConversionModel->getDuplicatePattadar($dist, 
        $sub, $cir, $mouza, $lot, $vill, $pn, $ptype, $dag, $case_no);
        //echo $this->db->last_query();return;

        $json = [
            'success' => 'true',
            'applicants' => $getdetails->result(),
            'pattadar' => $getPattadar->result(),
            'duplicate' => $getDuplicatePattadar->result(),
            'message' => 'Applicant Deleted Successfully'
        ];

        echo json_encode($json);
        return false;
    }  


    public function createWordDoc(){
        include 'PhpWord\PhpWord.php';
        $phpWord = new \PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Hello World');
         
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('MyDocument.docx');
    }
    
}