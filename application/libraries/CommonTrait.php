<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait CommonTrait{
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
}