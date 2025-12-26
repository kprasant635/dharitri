<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EkhajanaDoulController extends CI_Controller {

   
   public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('eKhajana/EkhajanaDoul/EkhajanaDoulModel');
      $this->dbswitch();
   }

   //script-validation-callback
   function check_script($str){

      if( strpos( trim(strtolower($str)), '<' ) !== false) {
         return FALSE;
      }

      if( strpos( trim(strtolower($str)), '>' ) !== false) {
         return FALSE;
      }
      
      if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
         return FALSE;
      }
      if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
         return FALSE;
      }
      return TRUE;
   }

   //date-validation-callback
   function date_valid($date){
      if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
         return false;
      
      $day = (int) substr($date, 8, 2);
      $month = (int) substr($date, 5, 2);
      $year = (int) substr($date, 0, 4);                        
      return checkdate($month, $day, $year);
   }

   //db switch method
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

   //displaying doul for all mouza
   public function viewDoulForAllMouza(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised!!");
         exit;
      }
      //**************************************************/
      $dist_code = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code = $this->session->userdata('cir_code');
      $doulExistsFlag = $this->EkhajanaDoulModel->checkDoulExists($dist_code,$subdiv_code,$cir_code);
      if(!$doulExistsFlag){
         $data['_view'] = 'e_khajana/ekhajana_doul/doul_error_page';
         $this->load->view('layouts/main',$data);   
         return;
      }
      $doulData = $this->EkhajanaDoulModel->generateDoulForAllMouza($dist_code,$subdiv_code,$cir_code);
      $data['doul_data_mouza_wise'] = $doulData['doul_details'];
      $data['total_patta'] = $doulData['total_cir_patta'];
      $data['total_cir_area_bigha'] = $doulData['total_cir_area_bigha'];
      $data['total_cir_area_katha'] = $doulData['total_cir_area_katha'];
      $data['total_cir_area_lessa'] = $doulData['total_cir_area_lessa'];
      $data['total_cir_revenue'] = $doulData['total_cir_revenue'];
      $data['total_cir_local_tax'] = $doulData['total_cir_local_tax'];
      $data['_view'] = 'e_khajana/ekhajana_doul/co_view_doul_mouza_wise';
      $this->load->view('layouts/main',$data);
   }

   //displaying doul for a mouza
   public function viewDoulMouzaWise($mouza_code){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised!!");
         exit;
      }
      //**************************************************/
      $dist_code = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code = $this->session->userdata('cir_code');
      $mouza_pargona_code = $mouza_code;
      //location names
      $data['district_name'] = $this->utilityclass->getDistrictName($dist_code);
      $data['subdiv_name'] = $this->utilityclass->getSubdivName($dist_code, $subdiv_code);
      $data['circle_name'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
      $data['mouza_name'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
      //**************************************************/
      $doul_data_all = $this->EkhajanaDoulModel->generateDoulDataMouzaWise($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code);
      $data['doul_data'] = $doul_data_all['doul_data'];
      $data['total_patta_all'] = $doul_data_all['total_patta_all'];
      $data['total_bigha_all'] = $doul_data_all['total_bigha_all'];
      $data['total_katha_all'] = $doul_data_all['total_katha_all'];
      $data['total_lessa_all'] = $doul_data_all['total_lessa_all'];
      $data['total_revenue_all'] = $doul_data_all['total_revenue_all'];
      $data['total_local_tax_all'] = $doul_data_all['total_local_tax_all'];
      $data['_view'] = 'e_khajana/ekhajana_doul/mouza_wise_doul';
      $this->load->view('layouts/main',$data);
   }
}