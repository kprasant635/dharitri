<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class copropertyCard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->helper(array('form', 'url'));
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('propertycard/landdetails');
    }

    // public function dbswitch(){       
    //  //$CI=&get_instance();
    //  if($this->session->userdata('dist_code') == "02"){
    //     $this->db=$this->load->database('dha3', TRUE);    
    //  } else if($this->session->userdata('dist_code') == "05"){
    //     $this->db=$this->load->database('dha1', TRUE);    
    //   } else if($this->session->userdata('dist_code') == "10"){
    //     $this->db=$this->load->database('dha24', TRUE);       
    //  } else if($this->session->userdata('dist_code') == "13"){
    //     $this->db=$this->load->database('dha2', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "17"){
    //     $this->db=$this->load->database('dha4', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "15"){
    //     $this->db=$this->load->database('dha5', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "14"){
    //     $this->db=$this->load->database('dha6', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "07"){
    //     $this->db=$this->load->database('dha7', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "03"){
    //     $this->db=$this->load->database('dha8', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "18"){
    //     $this->db=$this->load->database('dha9', TRUE);    
    //  }  else if($this->session->userdata('dist_code') == "12"){
    //     $this->db=$this->load->database('dha13', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "24"){
    //     $this->db=$this->load->database('dha10', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "06"){
    //     $this->db=$this->load->database('dha11', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "11"){
    //     $this->db=$this->load->database('dha12', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "12"){
    //     $this->db=$this->load->database('dha13', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "16"){
    //     $this->db=$this->load->database('dha14', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "32"){
    //     $this->db=$this->load->database('dha15', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "33"){
    //     $this->db=$this->load->database('dha16', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "34"){
    //     $this->db=$this->load->database('dha17', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "21"){
    //     $this->db=$this->load->database('dha18', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "08"){
    //     $this->db=$this->load->database('dha19', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "35"){
    //     $this->db=$this->load->database('dha20', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "36"){
    //     $this->db=$this->load->database('dha21', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "37"){
    //     $this->db=$this->load->database('dha22', TRUE);   
    //  }  else if($this->session->userdata('dist_code') == "25"){
    //     $this->db=$this->load->database('dha23', TRUE);   
    //  }                                                                                                                                                                                                            
    // }
    public function dbswitch($dist_code)
    {
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        }else if ($dist_code == "auth") {
            $this->db = $this->load->database('auth', TRUE);
        }
        return $this->db;
    }

    public function index() {
		var_dump("m here yes");
    }

    function property()
    {

        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';
        
        $data['propertyPendingCO'] = $this->db->query("SELECT count(*) as c from  t_property_land WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='P' and co_user_code = 'CO'")->row()->c;
        $data['_view'] = 'propertycard/coproperty';
        $this->load->view('layouts/main',$data);
    }

    public function COStep1(){
        $this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $cases = $this->db->query("SELECT po.* from t_property_land po  WHERE dist_code='$dist_code' "
         . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
         . " co_user_code='CO' and status='P'")->result();
        $data['cases'] = $cases;
        $data['_view'] = 'propertycard/copending_cases';
        $this->load->view('layouts/main',$data);
    }

    public function COStep2() {
        $data = array();
        $case_no = $this->input->get('case_no');
        $lid = $this->input->get('lid');
        // $cert_code = $this->input->get('cert_code');
        // $values = array('cert_no' => $cert_no, 'cert_code' => $cert_code);
        // $this->session->set_userdata($values);

        // $data['getProperty'] = $this->landdetails->getPropertyCardCo($case_no);
        $data['getProperty'] = $this->landdetails->getPropertyCardCo($lid);
        foreach ($data['getProperty'] AS $res){
            $dist_code =  $res->dist_code;
            $subdiv_code =  $res->subdiv_code;
            $circle_code =  $res->cir_code;
            $mouza_code =  $res->mouza_pargona_code;
            $lot_no =  $res->lot_no;
            $vill_code =  $res->vill_townprt_code;
            $block =  $res->block;
            $gaon =  $res->gaon;
            $case_no =  $res->case_no;
            $status =  $res->status;
        }
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $data['location'] = array(
            'dist_name' => $dist_name,
            'cir_name' => $cir_name,
            'mouza_name' => $mouza_name,
            'vill_name' => $vill_name,
            'block' => $block,
            'gaon' => $gaon,
            'lid' => $lid,
            'ref_no' => $ref_no,
            'case_no' => $case_no,
            'status' => $status
        );
        $data['_view'] = 'propertycard/cardco';
        $this->load->view('layouts/main',$data);
    
    }
    public function finalProperty(){

        if (isset($_POST['revert'])) {
            var_dump("m in revrt");
            $this->db->trans_begin();
            $lid = $this->input->post('lid');
            $case_no = $this->input->post('case_no');
            $Updatesql1 = "update  t_property_land set status='N',co_user_code='AST' where case_no ='$case_no' and lid=$lid";       
            $this->db->query($Updatesql1);
            if($this->db->affected_rows() == 0){
                $this->db->trans_rollback();
                log_message('error', '#ERRPS0011: Updation failed in t_property_land');
                $json = [
                'responseType' => 3,
                'message' => '#ERRPS0011: Failed to upadte status in Property Land. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Property Card details revert back to Lot Mondal. Case no # $case_no");
                redirect(base_url() . "index.php/copropertyCard/COStep1");
                // $data['_view'] = 'propertycard/card';
                // $this->load->view('layouts/main',$data);
            }  
        }
        if (isset($_POST['finalSubmit'])) {

            $case_no = $this->input->post('case_no');
            $lid = $this->input->post('lid');
            $this->db->query("UPDATE t_property_land SET status = 'F' WHERE case_no = '$case_no' and status = 'P' ");
            if($this->db->affected_rows()!=1){
                $this->session->set_flashdata('message', "Error.... #CONVPPDAC0004");
                redirect(base_url() . "index.php/home");
            }

            //data shift to central database
            
            $query = "select * from t_property_land where case_no='$case_no' and lid='$lid' and status='F'";
            $lands = $this->db->query($query)->result();

            $query2 = "select * from t_property_pattadar where case_no='$case_no' and lid='$lid'";
            $pattadars = $this->db->query($query2)->result();

            $query3 = "select * from t_property_house where case_no='$case_no' and lid='$lid'";
            $phouses = $this->db->query($query3)->result();
            
            $this->dbswitch('auth');
            $this->db->trans_begin();
            foreach ($lands as $land) {
                
                // $landdata = $land;
                unset($land->lid);

                //get maxid from property_land table to generate property card id
                $dist_code=$land->dist_code;
                $get_max_id = $this->landdetails->getMaxIdFromLandCentral()->row()->lid;
                
                if($get_max_id == 0){
                $case_id = PROPERTY_CARD . '/' . $dist_code . '/' . date('Y') . '/1';
                }
                else {
                $get_max_id = $get_max_id + 1;
                $case_id = PROPERTY_CARD . '/' . $dist_code . '/' . date('Y') . '/' . $get_max_id;
                }
                $land->pcard_no = $case_id;

                $tstatus1 =$this->db->insert("property_land", $land); //**************************
                // var_dump($this->db->last_query()); die();
                if ($tstatus1 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#PCG0001)");
                   log_message("error","#PCG0001 Insert filed in property_land table for case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }
                
            }
            //end of property land insert

            //start pattadar entry in central

            foreach ($pattadars as $pattadar) {
                unset($pattadar->pid);
                $tstatus2 =$this->db->insert("property_pattadar", $pattadar); //**************************
                // var_dump($this->db->last_query()); die();
                if ($tstatus2 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#PCG0002)");
                   log_message("error","#PCG0002 Insert filed in property_pattadar table for case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }

            }
            //end of pattadar entry in central

            //start house property entry in central

            foreach ($phouses as $phouse) {
                unset($phouse->hid);
                $tstatus3 =$this->db->insert("property_house", $phouse); //**************************
                // var_dump($this->db->last_query()); die();
                if ($tstatus3 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#PCG0003)");
                   log_message("error","#PCG0003 Insert filed in property_house table for case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                }

            }
            //end of house property entry in central

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                $this->db->trans_commit();

               //display card
               $dist_code = $this->session->userdata('dist_code');
               $this->dbswitch($dist_code);
                $data['getProperty'] = $this->landdetails->getPropertyCardCo($lid);
                // var_dump($data['getProperty']); die();
                foreach ($data['getProperty'] AS $res){
                    $dist_code =  $res->dist_code;
                    $subdiv_code =  $res->subdiv_code;
                    $circle_code =  $res->cir_code;
                    $mouza_code =  $res->mouza_pargona_code;
                    $lot_no =  $res->lot_no;
                    $vill_code =  $res->vill_townprt_code;
                    $block =  $res->block;
                    $gaon =  $res->gaon;
                    $case_no =  $res->case_no;
                    $status =  $res->status;
                }
                $dist_name = $this->utilityclass->getDistrictName($dist_code);
                $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
                $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
                $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
                $data['location'] = array(
                    'dist_name' => $dist_name,
                    'cir_name' => $cir_name,
                    'mouza_name' => $mouza_name,
                    'vill_name' => $vill_name,
                    'block' => $block,
                    'gaon' => $gaon,
                    'lid' => $lid,
                    'ref_no' => $ref_no,
                    'case_no' => $case_no,
                    'status' => $status
                );
                $data['_view'] = 'propertycard/cardco';
                $this->load->view('layouts/main',$data);
                // display card end

            }
            

            //end central data

            
        }
        
    }
}