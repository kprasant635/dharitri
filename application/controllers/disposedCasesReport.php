<?php 
//ini_set('max_execution_time', 0);
// session_start();
class disposedCasesReport extends CI_Controller
 {
     public function __construct() {
        parent::__construct();
        $this->dbswitch();
        $this->load->model('FieldMutBasic/FieldMutBasicModel');
        $this->load->model('basundhara/basundharamodel');
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

    public function districtDetails() {
        $this->dataswitch();
        unset($_SESSION['DISPOSED_SEARCH']);
        $counts['_view'] = 'disposed-cases/report1';
		$this->load->view('layouts/main',$counts);
    }
   
    public function disposedRejectedCases()
    {
        $this->load->library('pagination');
        
        if(!empty($_POST['dist_code']) && empty($_POST['searchCaseNo'])){
            $_SESSION['DISPOSED_SEARCH']['SEARCH']='1';
            $_SESSION['DISPOSED_SEARCH']['dist_code']=$_POST['dist_code'];
            $_SESSION['DISPOSED_SEARCH']['subdiv_code']=$_POST['subdiv_code'];
            $_SESSION['DISPOSED_SEARCH']['circle_code']=$_POST['circle_code'];
            $_SESSION['DISPOSED_SEARCH']['mouza_code']=$_POST['mouza_code'];
            $_SESSION['DISPOSED_SEARCH']['lot_no']=$_POST['lot_no'];
            $_SESSION['DISPOSED_SEARCH']['vill_code']=$_POST['vill_code'];
            $_SESSION['DISPOSED_SEARCH']['service_type']=$_POST['service_type'];
            $_SESSION['DISPOSED_SEARCH']['fm-date']=$_POST['fm-date'];
            $_SESSION['DISPOSED_SEARCH']['to-date']=$_POST['to-date'];
        }
        
        if(!empty($_POST['searchCaseNo'])){
            $_SESSION['DISPOSED_SEARCH']['searchCaseNo']=$_POST['searchCaseNo'];
        }
        
        if(!empty($_POST['submitSearchReset'])){
            $_SESSION['DISPOSED_SEARCH']['searchCaseNo'] = '';
        }
        
        $data['searchCaseNo'] = $_SESSION['DISPOSED_SEARCH']['searchCaseNo'];
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $page_limit = '25';
        
        $_SESSION['DISPOSED_SEARCH']['page'] = $page;
        $_SESSION['DISPOSED_SEARCH']['page_limit'] = $page_limit;
        
        $this->load->library('pagination');
        
        if(!empty($_SESSION['DISPOSED_SEARCH']['SEARCH'])){
            
            $data['service_type'] = $_SESSION['DISPOSED_SEARCH']['service_type'];
            switch ($data['service_type'])
            {
                case 'field':
                    //Field Partition
                    $data['cases'] = $this->FieldMutBasicModel->getAllRejectedDisposedFpartCases($_SESSION['DISPOSED_SEARCH']);
                    break;
                case 'office':
                        //Office Partition
                        $data['cases'] = $this->FieldMutBasicModel->getAllRejectedDisposedOpartCases($_SESSION['DISPOSED_SEARCH']);
                        break;
                case 'field_mut':
                    //Field MUTATION
                    $data['cases'] = $this->FieldMutBasicModel->getAllRejectedDisposedFmutCases($_SESSION['DISPOSED_SEARCH']);
                    break;
                case 'office_mut':
                        //Office MUTATION
                        $data['cases'] = $this->FieldMutBasicModel->getAllRejectedDisposedOmutCases($_SESSION['DISPOSED_SEARCH']);
                        break;
                case 'allotment':
                    //Allotment
                    $data['cases'] = $this->FieldMutBasicModel->getAllRejectedDisposedAllotments($_SESSION['DISPOSED_SEARCH']);
                    break;
               case 'area_correction':
                     //Area Correction
                     $data['cases'] = $this->FieldMutBasicModel->getAllRejectedAreaCorrection($_SESSION['DISPOSED_SEARCH']);
                     break;
               case 'land_reclassification':
                     //Land Reclassification
                     $data['cases'] = $this->FieldMutBasicModel->getAllRejectedLandReclassification($_SESSION['DISPOSED_SEARCH']);
                     break;
               case 'name_correction':
                  //Land Reclassification
                  $data['cases'] = $this->FieldMutBasicModel->getAllRejectedNameCorrection($_SESSION['DISPOSED_SEARCH']);
                  break;
               default:
                    //default is partition
            }
        }
        
        $total_records = $this->FieldMutBasicModel->get_record_count($_SESSION['DISPOSED_SEARCH']);
        
        $config = array();
        $config["base_url"] = base_url() . "/index.php/disposed-cases/show/";
        $config["total_rows"] = $total_records;
        $config["per_page"] = $page_limit;
        $config["uri_segment"] = 3;
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
        $data["links"] = $this->pagination->create_links();
        $data['total_records'] = $total_records;
        
        $data['_view'] = 'disposed-cases/disposed-cases';
        $this->load->view('layouts/main',$data);
    }

    public function dataswitch(){       
     $CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$CI->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$CI->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$CI->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$CI->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$CI->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$CI->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$CI->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$CI->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$CI->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$CI->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$CI->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$CI->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$CI->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$CI->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$CI->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$CI->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$CI->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$CI->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$CI->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$CI->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$CI->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$CI->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$CI->load->database('dha23', TRUE);   
     }                                                                                                                                                                                                              
}

}
