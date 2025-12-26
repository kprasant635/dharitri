<?php 
class NocCompositeReportController extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('NocCompositeReport/NocCompositeModel');
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

    public function registered(){
      
      $data['registered_count'] = $this->NocCompositeModel->getRegisteredCountDistrictWise();
      $data['delivered_count'] =  $this->NocCompositeModel->getDeliveredCountDistrictWise();
      $data['reject_count'] =  $this->NocCompositeModel->getRejectedCountDistrictWise();
      $data['pending_count'] =  $data['registered_count']- ($data['delivered_count']+$data['reject_count']);


      $data['am_registered_count'] = $this->NocCompositeModel->getAmRegisteredCountDistrictWise();
      $data['amp_registered_count'] = $this->NocCompositeModel->getAmpRegisteredCountDistrictWise();

      $data['header'] = "Noc Composite Registered Application Details";
      $data['flag'] = "registered";
      $data['_view'] = 'noc_composite_report/index';  
      $this->load->view('layouts/main',$data);
    }

    public function pending(){
      $data['registered_count'] = $this->NocCompositeModel->getRegisteredCountDistrictWise();
      $data['delivered_count'] =  $this->NocCompositeModel->getDeliveredCountDistrictWise();
      $data['reject_count'] =  $this->NocCompositeModel->getRejectedCountDistrictWise();
      $data['pending_count'] =  $data['registered_count']- ($data['delivered_count']+$data['reject_count']);

      $amRegisteredCount = $this->NocCompositeModel->getAmRegisteredCountDistrictWise();
      $ampRegisteredCount = $this->NocCompositeModel->getAmpRegisteredCountDistrictWise();
      $amDeliveredCount = $this->NocCompositeModel->getAmDeliveredCountDistrictWise();
      $ampDeliveredCount = $this->NocCompositeModel->getAmpDeliveredCountDistrictWise();
      $amRejectedCount = $this->NocCompositeModel->getAmRejectedCountDistrictWise();
      $ampRejectedCount = $this->NocCompositeModel->getAmpRejectedCountDistrictWise();

      $data['am_registered_count'] = $amRegisteredCount-($amDeliveredCount+$amRejectedCount);
      $data['amp_registered_count'] = $ampRegisteredCount-($ampDeliveredCount+$ampRejectedCount);
      
      $data['flag'] = "pending";
      $data['header'] = "Noc Composite Pending Application Details";
      $data['_view'] = 'noc_composite_report/index';  
      $this->load->view('layouts/main',$data);
    }

    public function delivered(){
      $data['registered_count'] = $this->NocCompositeModel->getRegisteredCountDistrictWise();
      $data['delivered_count'] =  $this->NocCompositeModel->getDeliveredCountDistrictWise();
      $data['reject_count'] =  $this->NocCompositeModel->getRejectedCountDistrictWise();
      $data['pending_count'] =  $data['registered_count']- ($data['delivered_count']+$data['reject_count']);

      $data['am_registered_count'] = $this->NocCompositeModel->getAmDeliveredCountDistrictWise();
      $data['amp_registered_count'] = $this->NocCompositeModel->getAmpDeliveredCountDistrictWise();
      $data['flag'] = "delivered";
      $data['header'] = "Noc Composite Delivered Application Details";
      $data['_view'] = 'noc_composite_report/index';  
      $this->load->view('layouts/main',$data);
    }

    public function rejected(){
      $data['registered_count'] = $this->NocCompositeModel->getRegisteredCountDistrictWise();
      $data['delivered_count'] =  $this->NocCompositeModel->getDeliveredCountDistrictWise();
      $data['reject_count'] =  $this->NocCompositeModel->getRejectedCountDistrictWise();
      $data['pending_count'] =  $data['registered_count']- ($data['delivered_count']+$data['reject_count']);

      $data['am_registered_count'] = $this->NocCompositeModel->getAmRejectedCountDistrictWise();
      $data['amp_registered_count'] = $this->NocCompositeModel->getAmpRejectedCountDistrictWise();
      $data['flag'] = "rejected";
      $data['header'] = "Noc Composite Rejected Application Details";
      $data['_view'] = 'noc_composite_report/index';  
      $this->load->view('layouts/main',$data);
    }

    public function circle_am(){
      $flag = $_GET['flag'];
      if($flag == "registered"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmRegisteredCount();
        $data['header'] = "Circle Wise Auto Mutation Registered cases Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);
        
      }else if($flag == "delivered"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmDeliveredCount();
        // echo "<pre>";
        // var_dump($data['amResult']);
        // echo "</pre>";
        $data['header'] = "Circle Wise Auto Mutation Delivered cases Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);
      } else if($flag == "rejected"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmRejectedCount();
        $data['header'] = "Circle Wise Auto Mutation Rejected cases Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);
      }else if($flag == "pending"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmPendingCount();
        // echo "<pre>";
        // var_dump($data['amResult']);
        // echo "</pre>";
        $data['flag'] = "am";
        $data['header'] = "Circle Wise Auto Mutation Pending cases Report";
        $data['_view'] = 'noc_composite_report/circle_wise_pending_report';  
        $this->load->view('layouts/main',$data);
      }     
    }

    public function circle_amp(){
      $flag = $_GET['flag'];
      
      if($flag == "registered"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmpRegisteredCount();
        $data['header'] = "Circle Wise Auto Mutation Partition Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);        
      }else if($flag == "delivered"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmpDeliveredCount();        
        $data['header'] = "Circle Wise Auto Mutation Partition Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);
      } else if($flag == "rejected"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmpRejectedCount();
        $data['header'] = "Circle Wise Auto Mutation Partition Report";
        $data['_view'] = 'noc_composite_report/circle_wise_report';  
        $this->load->view('layouts/main',$data);
      }else if($flag == "pending"){
        $data['result'] = $this->NocCompositeModel->getCircleWiseAmpPendingCount();
        $data['header'] = "Circle Wise Auto Mutation Partition Pending cases Report";
        $data['flag'] = "amp";
        $data['_view'] = 'noc_composite_report/circle_wise_pending_report';  
        $this->load->view('layouts/main',$data);
        
      }     
    }

    public function lotwisepending($dist_code, $subdiv_code,$cir_code){
      //echo "lot wise pending method flag ".$_GET['flag'].$dist_code.$subdiv_code.$cir_code;
      if($_GET['flag'] == 'am'){
        $data['lotwisedetails'] = $this->NocCompositeModel->getAmLotWisePendingCount($dist_code, $subdiv_code,$cir_code);
        // echo "<pre>";
        // var_dump($data['lotwisedetails']);
        // echo "</pre>";        
        // exit;
        $data['header'] = "Lot Wise Pending Report For Auto Mutation Cases";
        $data['_view'] = 'noc_composite_report/lot_wise_pending_report';  
        $this->load->view('layouts/main',$data);    

      }else if($_GET['flag'] == 'amp'){
        $data['lotwisedetails'] = $this->NocCompositeModel->getAmpLotWisePendingCount($dist_code, $subdiv_code,$cir_code);
        // echo "<pre>";
        // var_dump($data['lotwisedetails']);
        // echo "</pre>";
        // exit;
        $data['header'] = "Lot Wise Pending Report For Auto Mutation Partition Cases";
        $data['_view'] = 'noc_composite_report/lot_wise_pending_report';  
        $this->load->view('layouts/main',$data);
      }  
    }
}
?>