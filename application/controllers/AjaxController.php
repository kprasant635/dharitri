<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->dbswitch();
        $this->load->model('validation/FormValidationModel');
        $this->load->model('validation/AuthorizationModel');
    }
    
    public function message($id){
	   $db=  $this->session->userdata('db');
       $query = "select * from    messages where id = ?";
       $result = $this->db->query($query,array($id))->row();
       echo json_encode($result);
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



    public function getFieldMutationPetitions($d, $s, $c, $m, $l, $v) {
		  $db=  $this->session->userdata('db');
        $query = "select * from    t_chitha_col8_order where"
                . " dist_code='$d' and cir_code='$c' and subdiv_code='$s' and mouza_pargona_code='$m' and"
                . " lot_no='$l' and vill_townprt_code='$v' and iscorrected_inco is null";


        $data = $this->db->query($query)->result();
        $json = array();
        foreach ($data as $d) {
            $json[] = array('petition' => $d->petition_no, 'dag' => $d->dag_no);
        }
        echo json_encode($json);
    }
    
    public function getPataType($pn) {
		  $db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationFromSession();
        $d = $location['dist_code'];
        $s = $location['subdiv_code'];
        $c = $location['cir_code'];
        $l = $location['lot_no'];
        $m = $location['mouza_pargona_code'];
        $v = $location['vill_townprt_code'];
        $query = "select type_code,patta_type from    patta_code where type_code in (select patta_type_code from    chitha_basic 
                    where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and
                    mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and TRIM(patta_no)=trim('$pn'))";
       
        if (sizeof($this->db->query($query)->row()) == 0) {
            $json = array(
                'status' => FALSE
            );
            echo json_encode($json);
        } else {
            $json= array();
            $result = $this->db->query($query)->result();
            foreach ($result as $r) {
                $json[] = array(
                    'patta_type' => $this->db->query($query)->row()->patta_type,
                    'patta_code' => $this->db->query($query)->row()->type_code,
                    'status' => TRUE
                );
            }
            echo json_encode($json);
        }
    }

    public function dagExists($dag_no) {
		 // $db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationFromSession();
        $d = $location['dist_code'];
        $s = $location['subdiv_code'];
        $c = $location['cir_code'];
        $l = $location['lot_no'];
        $m = $location['mouza_pargona_code'];
        $v = $location['vill_townprt_code'];
        $patta_no = trim($this->session->userdata('patta_no'));
        $query = "select *  from    chitha_basic 
                    where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and
                    mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' "
                . " and dag_no='$dag_no'"; //and TRIM(patta_no)='$patta_no' 

        $count = $this->db->query($query)->row();

        if (sizeof($count) == 1) {
            $json = array(
                'status' => TRUE,
                'bigha' => $count->dag_area_b,
                'katha' => $count->dag_area_k,
                'lessa' => $count->dag_area_lc,
            );
            echo json_encode($json);
        } else {
            $json = array(
                'status' => FALSE
            );
            echo json_encode($json);
        }
    }

    public function getRevenue($landclass,$urban_rural){
		  $db=  $this->session->userdata('db');
        if($urban_rural ==='u')
            $dbResult = $this->db->query("SELECT revenue_per_bigha_urban as revenue from    landclass_revenue_reassesment where land_class_code =?", $landclass)->row();
        else 
            $dbResult = $this->db->query("SELECT revenue_per_bigha_rural as revenue from    landclass_revenue_reassesment where land_class_code =?", $landclass)->row();
        echo json_encode($dbResult);
    }

    public function getRefreshedCsrf(){
        $csrf_token = $this->security->get_csrf_hash();
        $csrf_key = $this->security->get_csrf_token_name();

        $responseArr = [
            'csrf_key' => $csrf_key,
            'csrf_token' => $csrf_token,
        ];

        echo json_encode($responseArr);
        exit;
    }
    // added by hriday - 25-04-2024
   public function getVillageDags() {
      $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
          'dist_code'=>'District Code|required|digit',
          'subdiv_code'=>'Subdivisional Code|required|digit',
          'cir_code'=>'Circle Code|required|digit',
          'mouza_pargona_code'=>'Mouza Pargona Code|required|digit',
          'lot_no'=>'Lot No.|required|digit',
          'vill_townprt_code'=>'Village Code|required|digit'
      ]);
      if($formValidation['status'] == 'n') {
          //CONVLMAPP0001
          log_message('error', $formValidation['message'] . 'Data: '. json_encode($formValidation['data']) .'. Error: CONVLMAPP0001');
          $response = [
              'responseType'=>1,
              'msg'=>$formValidation['message'],
              'data'=>$formValidation['data'],
              'errorCode'=>'CONVLMAPP0001'
          ];
          echo json_encode($response);
          exit;
      }

      $requestResponse = checkRequestSpecChar($_POST);
      if($requestResponse['status'] == 'n') {
          //CONVLMAPP0002
          log_message('error', $requestResponse['messages'] . '. Error: CONVLMAPP0002');
          $response = [
              'responseType'=>1,
              'msg'=>$requestResponse['messages'],
              'data'=>'',
              'errorCode'=>'CONVLMAPP0002'
          ];
          echo json_encode($response);
          exit;
      }

      $validResponse = checkRequestValidQuery($_POST);
      if($validResponse['status'] == 'n') {
          //CONVLMAPP0003
          log_message('error', $validResponse['messages'] . '. Error: CONVLMAPP0003');
          $response = [
              'responseType'=>1,
              'msg'=>$validResponse['messages'],
              'data'=>'',
              'errorCode'=>'CONVLMAPP0003'
          ];
          echo json_encode($response);
          exit;
      }

      $dist_code = $this->input->post('dist_code');
      $subdiv_code = $this->input->post('subdiv_code');
      $cir_code = $this->input->post('cir_code');
      $mouza_pargona_code = $this->input->post('mouza_pargona_code');
      $lot_no = $this->input->post('lot_no');
      $vill_townprt_code = $this->input->post('vill_townprt_code');

      $dags = $this->utilityclass->getVillageDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
      echo json_encode($dags);
      exit;
   }

   public function getDagDetails() {
      $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
         'dist_code'=>'District Code|required|digit',
         'subdiv_code'=>'Subdivisional Code|required|digit',
         'cir_code'=>'Circle Code|required|digit',
         'mouza_pargona_code'=>'Mouza Pargona Code|required|digit',
         'lot_no'=>'Lot No.|required|digit',
         'vill_townprt_code'=>'Village Code|required|digit',
         'dag_no'=>'Dag No.|required|digit'
     ]);
     if($formValidation['status'] == 'n') {
         //CONVLMAPP20001
         log_message('error', $formValidation['message'] . 'Data: '. json_encode($formValidation['data']) .'. Error: CONVLMAPP20001');
         $response = [
             'responseType'=>1,
             'msg'=>$formValidation['message'],
             'data'=>$formValidation['data'],
             'errorCode'=>'CONVLMAPP20001'
         ];
         echo json_encode($response);
         exit;
     }

     $requestResponse = checkRequestSpecChar($_POST);
     if($requestResponse['status'] == 'n') {
         //CONVLMAPP20002
         log_message('error', $requestResponse['messages'] . '. Error: CONVLMAPP20002');
         $response = [
             'responseType'=>1,
             'msg'=>$requestResponse['messages'],
             'data'=>'',
             'errorCode'=>'CONVLMAPP20002'
         ];
         echo json_encode($response);
         exit;
     }

     $validResponse = checkRequestValidQuery($_POST);
     if($validResponse['status'] == 'n') {
         //CONVLMAPP20003
         log_message('error', $validResponse['messages'] . '. Error: CONVLMAPP20003');
         $response = [
             'responseType'=>1,
             'msg'=>$validResponse['messages'],
             'data'=>'',
             'errorCode'=>'CONVLMAPP20003'
         ];
         echo json_encode($response);
         exit;
      }

      $dist_code = $this->input->post('dist_code');
      $subdiv_code = $this->input->post('subdiv_code');
      $cir_code = $this->input->post('cir_code');
      $mouza_pargona_code = $this->input->post('mouza_pargona_code');
      $lot_no = $this->input->post('lot_no');
      $vill_townprt_code = $this->input->post('vill_townprt_code');
      $dag_no = $this->input->post('dag_no');

      $dagDetails = $this->utilityclass->getDagDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no);
      echo json_encode($dagDetails);
      exit;
   }
    // end added  
    
    public function getFile() {
        $id = $this->input->get('id');
        $fetchRowData = $this->db->query("select file_path from supportive_document where id = ?",array($id))->row();
        $file_path_location = $fetchRowData->file_path;
        
        header('Content-Type: image/jpeg');
        header('Content-Type: image/jpg');
        header('Content-Type: image/png');
        header('Content-type: application/pdf');
        echo file_get_contents(base_url($file_path_location));
    }

}
