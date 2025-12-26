<?php

date_default_timezone_set("Asia/Kolkata");
class LandclassController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('LandClassGroupModel');
        $this->load->model('LandClassModel');
        $this->load->helper(array('form', 'url'));
    }

    public function dbswitch($dist_code){       
        //$CI=&get_instance();
        $connection = null;
        if($dist_code == "02"){
            $connection = $this->load->database('dha3', TRUE);    
            // $this->db=$this->load->database('dha3', TRUE);    
        } else if($dist_code == "05"){
            $connection = $this->load->database('dha1', TRUE);    
            // $this->db=$this->load->database('dha1', TRUE);    
        } else if($dist_code == "10"){
            $connection = $this->load->database('dha24', TRUE);       
            // $this->db=$this->load->database('dha24', TRUE);       
        } else if($dist_code == "13"){
            $connection = $this->load->database('dha2', TRUE);    
            // $this->db=$this->load->database('dha2', TRUE);    
        }  else if($dist_code == "17"){
            $connection = $this->load->database('dha4', TRUE);    
            // $this->db=$this->load->database('dha4', TRUE);    
        }  else if($dist_code == "15"){
            $connection = $this->load->database('dha5', TRUE);    
            // $this->db=$this->load->database('dha5', TRUE);    
        }  else if($dist_code == "14"){
            $connection = $this->load->database('dha6', TRUE);    
            // $this->db=$this->load->database('dha6', TRUE);    
        }  else if($dist_code == "07"){
            $connection = $this->load->database('dha7', TRUE);    
            // $this->db=$this->load->database('dha7', TRUE);    
        }  else if($dist_code == "03"){
            $connection = $this->load->database('dha8', TRUE);    
            // $this->db=$this->load->database('dha8', TRUE);    
        }  else if($dist_code == "18"){
            $connection = $this->load->database('dha9', TRUE);    
            // $this->db=$this->load->database('dha9', TRUE);    
        }  else if($dist_code == "12"){
            $connection = $this->load->database('dha13', TRUE);   
            // $this->db=$this->load->database('dha13', TRUE);   
        }  else if($dist_code == "24"){
            $connection = $this->load->database('dha10', TRUE);   
            // $this->db=$this->load->database('dha10', TRUE);   
        }  else if($dist_code == "06"){
            $connection = $this->load->database('dha11', TRUE);   
            // $this->db=$this->load->database('dha11', TRUE);   
        }  else if($dist_code == "11"){
            $connection = $this->load->database('dha12', TRUE);   
            // $this->db=$this->load->database('dha12', TRUE);   
        }  else if($dist_code == "12"){
            $connection = $this->load->database('dha13', TRUE);   
            // $this->db=$this->load->database('dha13', TRUE);   
        }  else if($dist_code == "16"){
            $connection = $this->load->database('dha14', TRUE);   
            // $this->db=$this->load->database('dha14', TRUE);   
        }  else if($dist_code == "32"){
            $connection = $this->load->database('dha15', TRUE);   
            // $this->db=$this->load->database('dha15', TRUE);   
        }  else if($dist_code == "33"){
            $connection = $this->load->database('dha16', TRUE);   
            // $this->db=$this->load->database('dha16', TRUE);   
        }  else if($dist_code == "34"){
            $connection = $this->load->database('dha17', TRUE);   
            // $this->db=$this->load->database('dha17', TRUE);   
        }  else if($dist_code == "21"){
            $connection = $this->load->database('dha18', TRUE);   
            // $this->db=$this->load->database('dha18', TRUE);   
        }  else if($dist_code == "08"){
            $connection = $this->load->database('dha19', TRUE);   
            // $this->db=$this->load->database('dha19', TRUE);   
        }  else if($dist_code == "35"){
            $connection = $this->load->database('dha20', TRUE);   
            // $this->db=$this->load->database('dha20', TRUE);   
        }  else if($dist_code == "36"){
            $connection = $this->load->database('dha21', TRUE);   
            // $this->db=$this->load->database('dha21', TRUE);   
        }  else if($dist_code == "37"){
            $connection = $this->load->database('dha22', TRUE);   
            // $this->db=$this->load->database('dha22', TRUE);   
        }  else if($dist_code == "25"){
            $connection = $this->load->database('dha23', TRUE);   
            // $this->db = $this->load->database('dha23', TRUE);   
        } else if($dist_code == 'auth') {
            $connection = $this->load->database('auth', TRUE);   
        }
        
        return $connection;
    }

    public function index() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code != 'ADC'){
            show_404();
        }
        
        $landclasses = $this->LandClassModel->list();
        
        $land_cls_manage_security_code = $this->land_cls_manage_security_code();
        $this->session->set_userdata('land_cls_manage_security_code', $land_cls_manage_security_code);

        $data['land_classes'] = $landclasses;
        $data['land_cls_manage_security_code'] = $land_cls_manage_security_code;

        $data['_view'] = 'land_class/index';

        $this->load->view('layouts/main',$data);
    }

    public function destroy(){
        $code = $this->input->post('code');
        $landclass_code = $this->input->post('landclass');
        $session_code = $this->session->userdata('land_cls_manage_security_code');
        if(empty($code)){
            return response_json(['success' => false, 'message' => 'Code is required']);
        }elseif($session_code != $code){
            return response_json(['success' => false, 'message' => 'Please enter the correct code']);
        }

        if(empty($landclass_code)){
            return response_json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
        }

        $this->db->trans_begin();
        try{
            if(!$landclass = $this->LandClassModel->get_by_class_code($landclass_code)){
                return response_json(['success' => false, 'message' => 'No such land class found. Please try again later']);
            }

            $this->LandClassModel->is_landclass_deletable($landclass_code);
            $status = $this->LandClassModel->delete_landclass($landclass_code);

            if (!$status || $this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return response_json(['success' => true, 'message' => 'Land class deleted successfully']);
        }catch(Exception $e){
            $this->db->trans_rollback();
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => []];
            preg_match('/\{.*\}/', $e->getMessage(), $matches);
            if (!empty($matches)) {
                $full_data = json_decode($matches[0], true);
                $response = $full_data;
            }

            return response_json($response);
        }
    }
    
    private function land_cls_manage_security_code(){
        return rand(10000, 999999);
    }        
    
}
