<?php
class CaseTransferBo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->load->helper('file');
        $this->load->helper('download');
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
     }                                                                                                                                                                                                            
}
	function index(){
      $db=  $this->session->userdata('db');
      $dist_code = $this->session->userdata('dist_code');
      $dist_name = $this->utilityclass->getDistrictName($dist_code);
      $district['datas'] = array(
              'dist_code' => $dist_code,
              'dist_name' => $dist_name,
              // 'sub_div_name' => $sub_div_name,
              // 'cir_name' => $cir_name
          );
      $q="SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and dis_enb_option='E' and user_code like 'BO%' and priv='adm' ";
      $district['bolist']=$this->db->query($q)->result();
      //var_dump($district);
      // $this->load->view('../views/header');
      // $this->load->view('../views/transfer/index',$district);
      // $this->load->view('../views/footer');
      $district['_view'] = 'transfer/bo_transfer';
      $this->load->view('layouts/main',$district);
	}
	function Update(){
      $db=  $this->session->userdata('db');
      $bo_usercode=$this->input->post('user_code');
      $dist_code=$this->session->userdata('dist_code');
      $bo_name=$this->utilityclass->getDefinedBOName($dist_code,$bo_usercode);
      $this->db->query("Update petition_basic set user_code='$bo_usercode' where dist_code='$dist_code' and (status='P' or status is null) and user_code like 'BO%' and mut_type='01' and year_no >='2017' ");
      // $this->db->query("Update field_mut_basic set add_off_name='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (order_passed!='Y' or is_dispose is null ) and year_no >='2017' ");
      // $this->db->query("Update apcancel_petition_basic set add_off_name='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is null and year_no >='2017' ");
      // $this->db->query("Update misc_case_basic set add_to_officer='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='10' and year_no >='2017' "); 
      // $this->db->query("Update settlement_basic set co_code='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status in('W','R','X','C','M','N')");
      $this->session->set_flashdata('message', "BO updated!!!");
      redirect(base_url().'index.php/home');
	}
}