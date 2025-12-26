<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SKconversionPartha extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Allowed designations
        $allowed = ['SK'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/SKofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('v2/SupportiveDocumentModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
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


    public function GoToSK() {
        $process = $this->input->get('pro');
        if ($process == '1') {
            $config['total_rows'] = $this->SKofficeConversionModel->countPendingConversionCasesSK();
            $cases['cases'] = $this->SKofficeConversionModel->getPendingConversionCasesSK()->result();
        }

        $cases['process'] = $process;
        
        $this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/SKofficeconversion/sk_conversion_cases', $cases);
        //$this->load->view('../views/footer');

        $cases['_view'] = 'SKofficeconversion/sk_conversion_cases';
        $this->load->view('layouts/main',$cases);
    }

    public function index() {
        $date = date('Y-m-d');
		//$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mouza_pargona_code' => $mouza_pargona_code));
        $this->session->set_userdata(array('lot_no' => $lot_no));
        $this->session->set_userdata(array('vill_townprt_code' => $vill_townprt_code));

        $petition_basic = $this->db->query("select * from  petition_basic where case_no='$case_no' "
                        . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                        . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

        $note_no = $this->db->query("select max(note_no) as note from  petition_lm_note where petition_no = '$petition_basic->petition_no' and "
                        . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' "
                        . "and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                        . "mouza_pargona_code='$petition_basic->mouza_pargona_code'")->result();
        $Note_no = $note_no[0]->note;
        
        $lm_detail = $this->db->query("Select * from  petition_lm_note where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code'"
                        . " and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                        . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' "
                        . "and note_no = '$Note_no'")->row_array();
        $land = $lm_detail['land_class_code'];
        $land_type = $this->db->query("Select * from  landclass_code where class_code = '$land'")->row();

        $lmname = $lm_detail['lm_code'];
        $name_of_lm = $this->db->query("select * from  lm_code where lm_code = '$lmname' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'  and mouza_pargona_code = '$mouza_pargona_code' and "
                        . "lot_no = '$lot_no'")->row();
        $name_of_lm = $name_of_lm->lm_name;
        $sk_code = $user_code;
        //echo "select * from users where user_code='$sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
        $skname = $this->db->query("select * from users where user_code='$sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code'")->row();
        $sk_name = $skname->username;

        $conv_lc = $lm_detail['conv_lc'];
        $conv_lc = round($conv_lc, 2);

        $prim_per_bigha = $lm_detail['prim_per_bigha'];
        $prim_per_bigha = round($prim_per_bigha, 2);

        $prim_tot = $lm_detail['prim_tot'];
        $prim_tot = round($prim_tot, 2);

        $data['lm_details'] = array(
            'dag_no' => $lm_detail['dag_no'],
            'note_no' => $lm_detail['note_no'],
            'partition_info' => $lm_detail['partition_info'],
            'date_entry' => $lm_detail['date_entry'],
            'applicant_patta_yn' => $lm_detail['applicant_patta_yn'],
            'occupied_yn' => $lm_detail['occupied_yn'],
            'val_tree_yn' => $lm_detail['val_tree_yn'],
            'dist_frm_town' => $lm_detail['dist_frm_town'],
            'inside_outside_town' => $lm_detail['inside_outside_town'],
            'land_class_code' => $land_type->land_type,
            'issuit_forconv_under105' => $lm_detail['issuit_forconv_under105'],
            'roadside_rsv_b' => $lm_detail['roadside_rsv_b'],
            'roadside_rsv_k' => $lm_detail['roadside_rsv_k'],
            'roadside_rsv_lc' => $lm_detail['roadside_rsv_lc'],
            'partial_untrans_b' => $lm_detail['partial_untrans_b'],
            'partial_untrans_k' => $lm_detail['partial_untrans_k'],
            'partial_untrans_lc' => $lm_detail['partial_untrans_lc'],
            'near_river_yn' => $lm_detail['near_river_yn'],
            'prim_per_bigha' => $prim_per_bigha,
            'conv_b' => $lm_detail['conv_b'],
            'conv_k' => $lm_detail['conv_k'],
            'conv_lc' => $conv_lc,
            'prim_tot' => $prim_tot,
            'lm_sign_yn' => $lm_detail['lm_sign_yn'],
            'lm_sign_date' => $lm_detail['lm_sign_date'],
            'case_no' => $case_no,
            'lm_code' => $lm_detail['lm_code'],
            'sk_name' => $sk_name,
            'sk_code' => $sk_code,
            'lm_name' => $name_of_lm,
            'jati_janajati_yn' => $lm_detail['jati_janajati_yn'],
            'jati_janajati_upload' => $lm_detail['jati_janajati_upload'],
            'freedom_fighter_yn' => $lm_detail['freedom_fighter_yn'],
            'freedom_fighter_upload' => $lm_detail['freedom_fighter_upload'],
            'widow_yn' => $lm_detail['widow_yn'],
            'widow_upload' => $lm_detail['widow_upload'],
            'premium_assesment' => $lm_detail['premium_assesment'],
            'premium_new_yn' => $lm_detail['premium_new_yn']
        );
        if($lm_detail['premium_new_yn'] == 1) {
            $data['conversion_premium_area'] = $this->db->query("SELECT * FROM conversion_premium_areas WHERE id=?", [$lm_detail['conversion_premium_areas_id']])->row();
            $data['conversion_premium_rate'] = $this->db->query("SELECT * FROM conversion_premium_rates WHERE id=?", [$lm_detail['conversion_premium_rates_id']])->row();
        }
        //var_dump($data);
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,add_off_name"
                        . " from   petition_basic where case_no='$case_no' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                        . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from   petition_dag_details where "
                        . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
                        . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                        . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' "
                        . "and petition_no='$petition_basic->petition_no'")->row_array();
        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $data['patta_type'] = $this->db->query("select patta_type from  patta_code "
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
            'add_to' => $location['add_off_name']
        );
        $convertion_code = CONVERSION_CODE;
        $data['conv_type'] = $this->db->query("select order_type from   master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from   petitioner_part where dist_code='$petition_basic->dist_code' "
                . "and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
                . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and "
                . "patta_type_code= '$landdetails[patta_type_code]'";
        $data['pattadar'] = $this->db->query($pattadardetails)->result();
        //var_dump($data);
        $this->load->helper('html');
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            $data['rtps']=$rtps;
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        else{
            $data['supportiveDocs'] = $this->SupportiveDocumentModel->getDocs($case_no);
        }
      //   if($petition_basic->bo_note_yn == 'Y') {
      //    $data['post_url'] = 'index.php/SKconversionPartha/SecondProcessRevrtDC';
      //   }
      //   else{
         $data['post_url'] = 'index.php/SKconversionPartha/SecondProcess';
      //   }
        $data['_view'] = 'SKofficeconversion/sk_first_process';
        $this->load->view('layouts/main',$data);
    }

//     public function SecondProcessRevrtDC() {
//       $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
//          'sk_notice'=>'SK Notice|required',
//          'sk_sign'=>'SK Sign|required|char',
//          'SK_code'=>'SK Code|required',
//          'SK_name'=>'SK Name|required',
//          'sk_date_of_entry'=>'SK Date of Entry|required|date',
//          'case_no'=>'Case No.|required|case_no',
//          'dag_no'=>'Dag No.|required|digit',
//          'note_no'=>'Note No.|required|digit',
//       ]);
//       if($formValidation['status'] == 'n') {
//          //ERRCONVSK0001
//          log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVSK0001');
//          $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVSK0001');
//          redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
//       }

//       //syntax validation
//      $requestResponse = checkRequestSpecChar($_POST);
//      if($requestResponse['status'] == 'n') {
//          //ERRCONVSK0002
//          log_message('error', $requestResponse['messages'] . '. Error: ERRCONVSK0002');
//          $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVSK0002');
//          redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
//      }

//      //malicious query validation
//      $validResponse = checkRequestValidQuery($_POST);
//      if($validResponse['status'] == 'n') {
//          //ERRCONVSK0003
//          log_message('error', $validResponse['messages'] . '. Error: ERRCONVSK0003');
//          $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVSK0003');
//          redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
//      }

//       //   authentication and authorization
//      $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'SK', $_POST['case_no'], CONV_SK_REVERT_DCEND);
//      if($authorization['status'] == 'n') {
//          //ERRCONVSK0004
//          log_message('error', $authorization['messages'] . '. Error: ERRCONVSK0004');
//          $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVSK0004');
//          redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
//      }
//      echo '<pre>';
//      var_dump($authorization, $_POST);
//      die();
     

//      $db = $this->session->userdata('db');
//      $dist_code = $this->session->userdata('dist_code');
//      $subdiv_code = $this->session->userdata('subdiv_code');
//      $cir_code = $this->session->userdata('cir_code');
//      $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
//      $lot_no = $this->session->userdata('lot_no');
//      $vill_townprt_code = $this->session->userdata('vill_townprt_code');
//      $case_no = $this->input->post('case_no');
//      $dag_no = $this->input->post('dag_no');
//      $note_no = $this->input->post('note_no');
//      $sk_date_of_entry = date('Y-m-d', strtotime($this->input->post('sk_date_of_entry')));
//      $SK_name = $this->input->post('SK_name');
//      $SK_code = $this->input->post('SK_code');
//      $sk_notice = $this->input->post('sk_notice');
//      $sk_notice = str_replace("'", '', $sk_notice);
//      $sk_sign = $this->input->post('sk_sign');

//      $this->db->trans_begin();

//    //   $petition_basic = $this->db->query("select * from   petition_basic where case_no='$case_no' "
//    //                   . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
//    //                   . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

//       $get_petition_basic = "select * from   petition_basic where case_no='$case_no' "
//       . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
//       . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
//       $result1 = $this->db->query($get_petition_basic);
//       if($result1->num_rows() > 0)
//       {
//             $petition_basic = $result1->row();
//       }
//       else
//       {
//             $this->db->trans_rollback();
//             log_message('error', '#ERRCONV00031: Unable to fetch data from petition_basic Case No '.$case_no);
//             $this->session->set_flashdata('message', '#ERRCONV00031: Unable to submit report case no '.$case_no);
//             redirect(base_url() . "index.php/home");
            
//       }

//      $this->db->query("UPDATE  Petition_lm_note SET sk_note_date = '$sk_date_of_entry', sk_note = '$sk_notice', user_code = '$SK_code', sk_sign_yn = '$sk_sign' "
//              . "WHERE dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
//              . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
//              . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
//              . "dag_no='$dag_no' and note_no='$note_no'");

//       if ($this->db->affected_rows() == 0) {
//          $this->db->trans_rollback();
//          log_message('error', '#ERRCONV00032: Updation failed in petition_basic Case No ' . $case_no);
//          $this->session->set_flashdata('message', '#ERRCONV00032: Unable to submit sk report case no '.$case_no);
//          redirect(base_url() . "index.php/home");
         
//       }

//       $ast_info = $this->db->query("SELECT users.username, loginuser_table.user_code, users.user_desig_code FROM users, loginuser_table WHERE users.dist_code = loginuser_table.dist_code AND users.subdiv_code = loginuser_table.subdiv_code AND users.cir_code = loginuser_table.cir_code AND users.user_code = loginuser_table.user_code AND users.user_desig_code = 'AST' AND users.dist_code='$dist_code' AND users.subdiv_code='$subdiv_code' AND users.cir_code='$cir_code' AND loginuser_table.dis_enb_option = 'E' AND loginuser_table.priv = 'mut' ORDER BY loginuser_table.date_of_creation DESC LIMIT 1")->row();

//      $this->db->query("UPDATE  Petition_Basic SET sk_comment = 'Y', user_code='$ast_info->user_code' WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
//              . "cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
//              . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

//       if ($this->db->affected_rows() == 0) {
//          $this->db->trans_rollback();
//          log_message('error', '#ERRCONV00033: Updation failed in petition_basic Case No ' . $case_no);
//          $this->session->set_flashdata('message', '#ERRCONV00033: Unable to submit sk report case no '.$case_no);
//          redirect(base_url() . "index.php/home");
         
//       }

//       if ($this->db->trans_status() == false) {
//          $this->db->trans_rollback();
//          log_message('error', '#ERRCONV00034: Unable to submit sk report Case No ' . $case_no);
//          $this->session->set_flashdata('message', '#ERRCONV00034: Unable to submit sk report case no '.$case_no);
//          redirect(base_url() . "index.php/home");
//       }
//       else
//       {
//             $this->db->trans_commit();
//             //////////
//             $penUser='AST';
//             $rmrk='Report by SK';
//             $this->DashboardData($case_no,$penUser,$rmrk);
//             $rmk=$rmrk;
//             $status='M';
//             $task='SK';
//             $pen='AST';
//             $case=$case_no;
//             $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
//             ///////

//             $this->session->set_flashdata('message', "Report on Conversion Case no # $case_no Updated and Forwarded to Assistant!!");
//             redirect(base_url() . "index.php/home");
//       }

      
//  }

    public function SecondProcess() {
         $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'sk_notice'=>'SK Notice|required',
            'sk_sign'=>'SK Sign|required|char',
            'SK_code'=>'SK Code|required',
            'SK_name'=>'SK Name|required',
            'sk_date_of_entry'=>'SK Date of Entry|required|date',
            'case_no'=>'Case No.|required|case_no',
            'dag_no'=>'Dag No.|required|digit',
            'note_no'=>'Note No.|required|digit',
         ]);
         if($formValidation['status'] == 'n') {
            //ERRCONVSK0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRCONVSK0001');
            $this->session->set_flashdata('message', $formValidation['message'] .' Error: ERRCONVSK0001');
            redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
         }

         //syntax validation
        $requestResponse = checkRequestSpecChar($_POST);
        if($requestResponse['status'] == 'n') {
            //ERRCONVSK0002
            log_message('error', $requestResponse['messages'] . '. Error: ERRCONVSK0002');
            $this->session->set_flashdata('message', 'Contains Illegal parameter values. Error: ERRCONVSK0002');
            redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
        }

        //malicious query validation
        $validResponse = checkRequestValidQuery($_POST);
        if($validResponse['status'] == 'n') {
            //ERRCONVSK0003
            log_message('error', $validResponse['messages'] . '. Error: ERRCONVSK0003');
            $this->session->set_flashdata('message', 'Contains Malicious parameter values. Error: ERRCONVSK0003');
            redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
        }

         //   authentication and authorization
        $authorization = $this->AuthorizationModel->isAuthorized(SERVICE_CONVERSION, 'SK', $_POST['case_no'], CONV_SK_FIRST);
        if($authorization['status'] == 'n') {
            //ERRCONVSK0004
            log_message('error', $authorization['messages'] . '. Error: ERRCONVSK0004');
            $this->session->set_flashdata('message', $authorization['messages'] .' Error: ERRCONVSK0004');
            redirect(base_url('index.php/SKconversionPartha/GoToSK?pro=1'));
        }
      //   echo '<pre>';
      //   var_dump($authorization);
      //   die();
        

        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $note_no = $this->input->post('note_no');
        $sk_date_of_entry = date('Y-m-d', strtotime($this->input->post('sk_date_of_entry')));
        $SK_name = $this->input->post('SK_name');
        $SK_code = $this->input->post('SK_code');
        $sk_notice = $this->input->post('sk_notice');
        $sk_notice = str_replace("'", '', $sk_notice);
        $sk_sign = $this->input->post('sk_sign');

        $this->db->trans_begin();

      //   $petition_basic = $this->db->query("select * from   petition_basic where case_no='$case_no' "
      //                   . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
      //                   . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row();

         $get_petition_basic = "select * from   petition_basic where case_no='$case_no' "
         . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
         . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
         $result1 = $this->db->query($get_petition_basic);
         if($result1->num_rows() > 0)
         {
               $petition_basic = $result1->row();
         }
         else
         {
               $this->db->trans_rollback();
               log_message('error', '#ERRCONV00031: Unable to fetch data from petition_basic Case No '.$case_no);
               $this->session->set_flashdata('message', '#ERRCONV00031: Unable to submit report case no '.$case_no);
               redirect(base_url() . "index.php/home");
               
         }

        $this->db->query("UPDATE  Petition_lm_note SET sk_note_date = '$sk_date_of_entry', sk_note = '$sk_notice', user_code = '$SK_code', sk_sign_yn = '$sk_sign' "
                . "WHERE dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and "
                . "cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' "
                . "and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and "
                . "dag_no='$dag_no' and note_no='$note_no'");

         if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV00032: Updation failed in petition_basic Case No ' . $case_no);
            $this->session->set_flashdata('message', '#ERRCONV00032: Unable to submit sk report case no '.$case_no);
            redirect(base_url() . "index.php/home");
            
         }

        $this->db->query("UPDATE  Petition_Basic SET sk_comment = 'Y' WHERE case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and "
                . "lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'");

         if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV00033: Updation failed in petition_basic Case No ' . $case_no);
            $this->session->set_flashdata('message', '#ERRCONV00033: Unable to submit sk report case no '.$case_no);
            redirect(base_url() . "index.php/home");
            
         }

         if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV00034: Unable to submit sk report Case No ' . $case_no);
            $this->session->set_flashdata('message', '#ERRCONV00034: Unable to submit sk report case no '.$case_no);
            redirect(base_url() . "index.php/home");
         }
         else
         {
               $this->db->trans_commit();
               //////////
               $penUser='AST';
               $rmrk='Report by SK';
               $this->DashboardData($case_no,$penUser,$rmrk);
               $rmk=$rmrk;
               $status='M';
               $task='SK';
               $pen='AST';
               $case=$case_no;
               $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
               ///////

               $this->session->set_flashdata('message', "Report on Conversion Case no # $case_no Updated and Forwarded to Assistant!!");
               redirect(base_url() . "index.php/home");
         }

         
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
                    ///////

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
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected',
                     );
                $this->dbb->insert('dashboard_action',$action);
            }


}
