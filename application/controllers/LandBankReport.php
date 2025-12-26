<?php 
class LandBankReport extends CI_Controller
 {
   public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('LandBank/LandBankReportModel');
      $this->dbswitch();
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

   public function index(){
      $data['_view'] = 'land_bank_report/index';         
      $uniqueVillageIds =  $this->LandBankReportModel->getUniqueLandBankVillageIds();        
      $reportData = $this->LandBankReportModel->getLandBankReportDataFromVillageUUID($uniqueVillageIds);
      $data['reportData'] = $reportData;
      $this->load->view('layouts/main',$data);
   }

   public function LotWiseReport(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/   
      $lot_wise_report_data =  $this->LandBankReportModel->getLotWiseReport();
      $data['lot_wise_report_data'] = $lot_wise_report_data[0];
      $data['total_govt_dag_in_circle'] = $lot_wise_report_data[1]['total_govt_dag_in_circle'];
      $data['total_updated_by_lm_dag'] = $lot_wise_report_data[2]['total_updated_by_lm_dag'];
      $data['total_approved_by_co_dag'] = $lot_wise_report_data[3]['total_approved_by_co_dag'];
      $data['_view'] = 'land_bank_report/lot_wise';   
      $this->load->view('layouts/main',$data);
   }

   public function VillageWiseReport($mouza_code, $lot_no){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/ 
      $data['rpt_flag'] = 'CO';
      $data['village_wise_report_data'] =  $this->LandBankReportModel->getVillageWiseReport($mouza_code, $lot_no); 
      $data['_view'] = 'land_bank_report/village_wise';   
      $this->load->view('layouts/main',$data);
   }

   public function CircleWiseReport(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "DC" && $this->session->userdata('user_desig_code') != "ADC"){
         echo json_encode("Not Authorised..!, Please Login With Proper Credentials!");
         exit;
      }
      //**************************************************/ 
      $circle_wise_report_data =  $this->LandBankReportModel->getCircleWiseReport();      
      $data['circle_wise_report_data'] = $circle_wise_report_data[0];
      $data['total_govt_dag_in_district'] = $circle_wise_report_data[1]['total_govt_dag_in_district'];
      $data['total_updated_by_lm_dag'] = $circle_wise_report_data[2]['total_updated_by_lm_dag'];
      $data['total_approved_by_co_dag'] = $circle_wise_report_data[3]['total_approved_by_co_dag'];      
      $data['_view'] = 'land_bank_report/circle_wise';   
      $this->load->view('layouts/main',$data);
   }

   public function VillageWiseReportFromCircle($dist_code, $subdiv_code, $cir_code){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "DC" && $this->session->userdata('user_desig_code') != "ADC"){
         echo json_encode("Not Authorised..!, Please Login With Proper Credentials!");
         exit;
      }
      //**************************************************/ 
      $data['village_wise_report_data'] =  $this->LandBankReportModel->getVillageWiseReportFromCircle($dist_code, $subdiv_code, $cir_code);
      $data['rpt_flag'] = 'DC/ADC';
      $data['_view'] = 'land_bank_report/village_wise';   
      $this->load->view('layouts/main',$data);
   }

   public function LotWiseVgrPgrReport(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/ 
      $lot_wise_vgr_pgr_report_data =  $this->LandBankReportModel->getLotWiseVgrPgrReport();
      $data['lot_wise_vgr_pgr_report_data'] = $lot_wise_vgr_pgr_report_data['lot_wise_details'];
      $data['total_vgr_dags_with_encroacher_in_circle'] = $lot_wise_vgr_pgr_report_data['total_vgr_dags_with_encroacher_in_circle'];
      $data['total_pgr_dags_with_encroacher_in_circle'] = $lot_wise_vgr_pgr_report_data['total_pgr_dags_with_encroacher_in_circle'];
      // echo "<pre>";
      // var_dump($lot_wise_vgr_pgr_report_data);
      // echo "</pre>";
      // exit;
      $data['_view'] = 'land_bank_report/lot_wise_vgr_pgr_report';   
      $this->load->view('layouts/main',$data);
   }
   function allVillageReport(){
      if($this->session->userdata('user_desig_code') != "DC" && $this->session->userdata('user_desig_code') != "ADC"){
         echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
         exit;
      }
      $data =  $this->LandBankReportModel->getAllReport();
      $file_name="VLB_REPORT_".time().'.csv';
      $temp_file = tempnam(sys_get_temp_dir(), $file_name);
      $fh = fopen($temp_file, 'w');
      fputcsv($fh,array_keys($data[0]));
      foreach($data as $row)
        fputcsv($fh,$row);
      fclose($fh);
      header('Content-Type: text/csv');
      header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
      echo file_get_contents($temp_file);   
   }
   function vlbMenu(){
      if($this->session->userdata('user_desig_code') != "DC"  && $this->session->userdata('user_desig_code') != "ADC" ){
         echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
         exit;
      }
      $data['_view'] = 'land_bank_report/vlb_menu';   
      $this->load->view('layouts/main',$data);
   }
   function VillageNoVlbEntry(){
      if($this->session->userdata('user_desig_code') != "DC" && $this->session->userdata('user_desig_code') != "ADC" ){
         echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
         exit;
      }
      $data =  $this->LandBankReportModel->VillageNoVlbEntry();
      $file_name="VLB_REPORT_NOVLBENTRY_".time().'.csv';
      $temp_file = tempnam(sys_get_temp_dir(), $file_name);
      $fh = fopen($temp_file, 'w');
      fputcsv($fh,array_keys($data[0]));
      foreach($data as $row)
        fputcsv($fh,$row);
      fclose($fh);
      header('Content-Type: text/csv');
      header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
      echo file_get_contents($temp_file);   
   }
   function penVillageReport(){
      if($this->session->userdata('user_desig_code') != "DC"){
         echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
         exit;
      }
      $data =  $this->LandBankReportModel->getPenAllReport();
      $file_name="PEN_VLB_REPORT_".time().'.csv';
      $temp_file = tempnam(sys_get_temp_dir(), $file_name);
      $fh = fopen($temp_file, 'w');
      fputcsv($fh,array_keys($data[0]));
      foreach($data as $row)
        fputcsv($fh,$row);
      fclose($fh);
      header('Content-Type: text/csv');
      header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
      echo file_get_contents($temp_file);   
   }
   function circleVillageReport(){
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      $data =  $this->LandBankReportModel->getCircleReport();
      $file_name="VLB_REPORT_".time().'.csv';
      $temp_file = tempnam(sys_get_temp_dir(), $file_name);
      $fh = fopen($temp_file, 'w');
      fputcsv($fh,array_keys($data[0]));
      foreach($data as $row)
        fputcsv($fh,$row);
      fclose($fh);
      header('Content-Type: text/csv');
      header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
      echo file_get_contents($temp_file);   
   }

}