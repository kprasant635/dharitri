<?php

class FindCases extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('findCases/FindCasesModel');
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

    //method to find the unavailable cases ......initial payment is R
    public function findUnavailableCases()
    {
        $data['_view'] = 'findCases/findCasesForm';
        $this->load->view('layouts/main',$data);
    }
 
    //method to get alll the data from basundhara
    public function getApplicationDetails()
    {
        $application_no = $_POST['application_no'];
        $application_type = $_POST['application_type'];
        if($application_type =='EKH'){
            $data['getApplicationDetails'] = $this->FindCasesModel->getApplicationDetails($application_no); 
            if($data['getApplicationDetails']['result']->application_details == null){
                echo "NO DATA FOUND AGAINST APPLICATION NO ==> ".$application_no;
                exit();
            }
            $data['_view'] = 'e_khajana/co_views/unavailableApplicationDetials';
            $this->load->view('layouts/main',$data);  
        }
        elseif($application_type =='BASU1'){
            $data['autoUpdateData'] = $this->FindCasesModel->autoUpadateBasundharaOneCases($application_no);
            if($data['autoUpdateData']['result'] =="SERVER-ERROR"){
                echo "Some Errror Occurred In Fetching Data of the Application No ==>  ".$application_no;
                exit();
            }
            elseif($data['autoUpdateData']['result'] == "SUCCESS"){
                $data['_view'] = 'findCases/autoFetchUpdatedData';
                $this->load->view('layouts/main',$data);
            }
        }else{
            echo json_encode("Some Error occured..!! #ERRGAD001");
            exit();
        }
    
    }

    //method to update the initial paymnt status in basundhara ekhajana services
    public function updateInitialPaymentStatus()
    {
        $rtps_ref_no = $_POST['rtps_ref_no'];
        $updateBasundhara = $this->FindCasesModel->updateBasundharaInitialPayment($rtps_ref_no);
        echo json_encode($updateBasundhara);
    }

    //method to update the initial paymnt status in basundhara one services
    public function updateInitialPaymentStatusBasundharaOne()
    {
        $application_no = $_POST['application_no'];
        $updateBasundhara = $this->FindCasesModel->updateBasundharaOneInitialPayment($application_no);
        echo json_encode($updateBasundhara);
    }

    public function autoFetchIniPay()
    {
        $application_no= $_POST['application_no'];
        if($application_no == null){
            $this->session->set_flashdata('message', 'Please Enter A Valid Application Number');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        if($_POST['app_type'] =="EKH"){
            $data['getUpdatedData'] = $this->FindCasesModel->getUpdatedData($application_no);

            if($data['getUpdatedData']['result'] =="SERVER-ERROR"){
                $this->session->set_flashdata('message', 'Some Error Occurred.. ! Please Try Again');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            if($data['getUpdatedData']['msg']->result =="N"){
                $this->session->set_flashdata('message', 'Failed To Search Data Against The Application No');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            $data['_view'] = 'findCases/autoFetchIniPayment';
            $this->load->view('layouts/main',$data);

        }else{
            $this->session->set_flashdata('message', 'Please select A Application Type');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }




}
?>