<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 0);

class Request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/CoofficeConversionModel');
        $this->load->helper(array('form', 'url'));
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
    
    public function BackLog() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['villages'] = $data;
        
        //var_dump($district);
        // $this->load->view('../views/BackLogRequest/RequestForm', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'BackLogRequest/RequestForm';
        $this->load->view('layouts/main',$district);
    }
    
    public function SaveRequest() {
			//$db=  $this->session->userdata('db');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $request_for = $this->input->post('request_for');
            
            $check = "Select count(*) as count from    backlog_request where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' "
                . "and lot_no='$lot_no' and vill_townprt_code = '$vill_code' and operation = 'P'  and status != 'D'  and request_for = '$request_for'";
            $check_exist = $this->db->query($check)->row()->count;
            
            if($check_exist == '0'){
                $request_backlog = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => date('Y'),
                    'request_for' => $request_for,
                    'lm_code' => $this->session->userdata('user_code'),
                    'status' => 'P',
                    'request_date' => date('Y-m-d'),
                    'operation' => 'P',
                );
                //var_dump($request_backlog);
                $this->db->insert('backlog_request', $request_backlog);//******************
            }
        }
        redirect(base_url() . "index.php/utility/backentry_utilities");
    }
    
    public function PendingRequest(){
			$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        
        $PendingRequest = $this->db->query("select * from    backlog_request where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and operation = 'P' ")->result();
        $data['pending_request'] = $PendingRequest;
        
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackLogRequest/RequestCases', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'BackLogRequest/RequestCases';
        $this->load->view('layouts/main',$data);
    }
    
    public function Activate() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $type = $this->input->get('type');
        
        $activate = "Update backlog_request set status = 'A' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and lot_no='$lot_no' and request_for = '$type' and operation = 'P'";
        $this->db->query($activate);
        redirect(base_url() . "index.php/Request/PendingRequest");
    }
    
    public function Deactivate() {
		//$db=  $this->session->userdata('db');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $type = $this->input->get('type');
        
        $deactivate = "Update backlog_request set status = 'D',operation = 'E' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and lot_no='$lot_no' and request_for = '$type' and operation = 'P'";
        $this->db->query($deactivate);
        redirect(base_url() . "index.php/Request/PendingRequest");
    }
    
}
