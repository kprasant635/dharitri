<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class propertyCard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->helper(array('form', 'url'));
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('propertycard/landdetails');
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

    public function index() {
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
         
         $data['propertyPendingAST'] = $this->db->query("SELECT count(*) as c from  t_property_land WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and co_user_code = 'AST'")->row()->c;
         $data['_view'] = 'propertycard/astproperty';
         $this->load->view('layouts/main',$data);
    }

    public function ASTStep1(){
      $this->load->library('pagination');
      $data = array();
      $dist_code = $this->session->userdata('dist_code');
      $subdiv_code = $this->session->userdata('subdiv_code');
      $cir_code = $this->session->userdata('cir_code');
      $user_code = $this->session->userdata('user_code');
      $cases = $this->db->query("SELECT po.* from t_property_land po  WHERE dist_code='$dist_code' "
       . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
       . " co_user_code='AST' and status='N'")->result();
      $data['cases'] = $cases;
      $data['_view'] = 'propertycard/astpending_cases';
      $this->load->view('layouts/main',$data);
   }

    public function addproperty() {
        // var_dump("m here"); die();
        // if(RTPS_CERT_ON_OFF=='1'){ 
        //     $this->session->set_flashdata('message', 'Not Authorised');
        //     redirect(base_url() . "index.php/home/index");
        //     return; 
        // }
        
        // $dist_code = $this->session->userdata('dist_code');
        // $subdiv_code = $this->session->userdata('subdiv_code');
        // $cir_code = $this->session->userdata('cir_code');
        // //$this->session->set_userdata(array('pattadar' => array()));
        // $dist_name = $this->utilityclass->getDistrictName($dist_code);
        // $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        // $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        // $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        // $district['datas'] = array(
        //     'dist_code' => $dist_code,
        //     'subdiv_code' => $subdiv_code,
        //     'cir_code' => $cir_code,
        //     'dist_name' => $dist_name,
        //     'sub_div_name' => $sub_div_name,
        //     'cir_name' => $cir_name
        // );

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        
        $district['district'] = $this->landdetails->allDistrict();
        $district['landClass'] = $this->landdetails->allLandclass();

        $district['_view'] = 'propertycard/select_location';
        $this->load->view('layouts/main',$district);

        // $data['district'] = $this->landdetails->allDistrict();
        // // var_dump($data['district']); die();

        // $district['_view'] = 'propertycard/select_location';
        // $this->load->view('layouts/main',$data);

    }

    public function viewCard() {

      $district['_view'] = 'propertycard/card';
      $this->load->view('layouts/main',$district);

  }

    public function addLand()
    {
      // echo json_encode(array(
      //    'responseType' => 3,
      //    'error' => "Could not add applilandcant details"
      //  ));
      // exit;

      try {
             
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');      
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no'); 
        $block = $this->input->post('block');
        $gaon = $this->input->post('gaon');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        
        $patta_no_new = $this->input->post('patta_no_new');
        $dag_no = $this->input->post('dag_no');
        $dag_area_b = $this->input->post('dag_area_b');
        $dag_area_k = $this->input->post('dag_area_k');
        $dag_area_lc = $this->input->post('dag_area_lc');

        $dag_area_g = $this->input->post('dag_area_g');
        $dag_area_kr = $this->input->post('dag_area_kr');
        $sqft = $this->input->post('sqft');
        $land_class_code = $this->input->post('land_class_code');
        $dag_revenue = $this->input->post('dag_revenue');
        $local_rate = $this->input->post('local_rate');
        $zonal_value = $this->input->post('zonal_value');
        $remarks = $this->input->post('remarks');
        $ref_no = $this->input->post('ref_no');

      //   $this->load->library('form_validation');
      //   $this->form_validation->set_rules('bigha', 'bigha', 'required|numeric|trim|xss_clean');
      //   if ($this->form_validation->run() == FALSE) {

      //       $this->form_validation->set_error_delimiters('', '');
      //       $validation = [];
      //       if (form_error('bigha')) {
      //          $validation[] = array('field' => 'bigha', 'message' => form_error('bigha'));
      //       }
      //       return $validation;
            
      //   }

      //   $this->load->library('form_validation');
      //   $this->form_validation->set_rules('patta_no', 'patta no', 'required|trim|xss_clean');
      //   $this->form_validation->set_rules('local_rate', 'local_rate', 'required|numeric|trim|xss_clean');
      //   $this->form_validation->set_rules('zonal_value', 'zonal_value', 'required|numeric|trim|xss_clean');
      //   if ($this->form_validation->run() == FALSE) {

      //    $this->form_validation->set_error_delimiters('', '');
      //    $validation = [];
      //     if (form_error('patta_no')) {
      //       $validation[] = array('field' => 'patta_no', 'message' => form_error('patta_no'));
      //     }
      //     if (form_error('local_rate')) {
      //       $validation[] = array('field' => 'local_rate', 'message' => form_error('local_rate'));
      //     }
      //     if (form_error('zonal_value')) {
      //       $validation[] = array('field' => 'zonal_value', 'message' => form_error('zonal_value'));
      //     }
      //     return $validation;
      //   }

        $ql = $this->db->select('ref_no')->from('t_property_land')->where('ref_no',$ref_no)->get();

         if( $ql->num_rows() > 0 ) {
            echo json_encode(array(
               'responseType' => 4,
               'responsedata' => "Land details already submitted"
             ));
             return;

         }

        //get maxid from t_property_land table to generate case id
         $get_max_id = $this->landdetails->getMaxIdFromLand()->row()->lid;
         
         if($get_max_id == 0){
         $case_id = PROPERTY_CARD . '/' . $dist_code . '/' . date('Y') . '/1';
         }
         else {
         $get_max_id = $get_max_id + 1;
         $case_id = PROPERTY_CARD . '/' . $dist_code . '/' . date('Y') . '/' . $get_max_id;
         }
      
        $landdata = array(
          'ref_no' => $ref_no,
          'dist_code' => $dist_code,
          'subdiv_code' => $subdiv_code,
          'cir_code' => $cir_code,
          'mouza_pargona_code' =>  $mouza_pargona_code,
          'lot_no' => $lot_no,
          'block' => $block,
          'gaon' => $gaon,
          'vill_townprt_code' => $vill_townprt_code,
          'patta_no_new' => $patta_no_new,
          'dag_no' => $dag_no,
          'dag_area_b' => $dag_area_b,
          'dag_area_k' => $dag_area_k,
          'dag_area_lc' => $dag_area_lc,
          'dag_area_kr' => $dag_area_kr,
          'area_sqft' => $sqft,
          'land_class_code' => $land_class_code,
          'dag_revenue' => $dag_revenue,
          'local_rate' => $local_rate,
          'zonal_value' => $zonal_value,
          'remarks' => $remarks,
          'status' => "N",
          'case_no' => $case_id,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),

        );

        $this->db->insert("t_property_land", $landdata);
        $lid = $this->db->insert_id();
        $row = $this->landdetails->getLand($lid);
        echo json_encode(['responseType'=>2, 'responsedata'=>$row]);
         //log_message("error", "MPR: t_property_pattadar inserted: " . $pdar_id);
         // echo json_encode(['responseType'=>2]);
      //   echo json_encode(array(
      //     'responseType' => 2,
      //     'data' => $this->landdetails->getTPattadar($ref_no)
      //   ));
      
      } catch (Exception $e) {
         //alert the user.
      log_message("error", $e->getMessage());
         echo json_encode(array(
         'responseType' => 3,
         'error' => "Could not add applilandcant details"
         ));
      } finally {
         log_message("error", "################### END OF Property Card " . $this->router->fetch_method() . " #################");
      }
      
    }



    public function addMore()
    {
      try {
      //   $tmp_application_id = empty($this->input->post('tmp_application_id')) ? uniqid() : $this->input->post('tmp_application_id');
  
  
        // Pattadars       
         $chitha_pdar_id = empty($this->input->post('co_pattadar')) ? "-1" : $this->input->post('co_pattadar');
        
        $pdar_id = $this->input->post('pdar_id'); 
        $pdar_name = $this->input->post('pdar_name');
        $pdar_name_eng = $this->input->post('pdar_name_eng');      
        $pdar_gender = $this->input->post('pdar_gender');
        $pdar_dob = $this->input->post('pdar_dob');
        $pdar_fname = $this->input->post('pdar_fname');
        $pdar_sname = $this->input->post('pdar_sname');
        
        $pdar_caste = $this->input->post('pdar_caste');
        $pdar_occupation = $this->input->post('pdar_occupation');
        $pdar_address = $this->input->post('pdar_address');
        $pdar_mobile = $this->input->post('pdar_mobile');
        $ref_no = $this->input->post('ref_no');
        $case_no = $this->input->post('case_no');
        $lid = $this->input->post('lid');
      
      //   $sql = "select * from t_property_pattadar where ref_no=? order by pid";
      //   $all_t_pattadars = $db->query($sql,array($ref_no))->result();
      
      //   if (count($all_t_pattadars)){
      //     foreach($all_t_pattadars as $t_pattadar){
      //       if($t_pattadar->chitha_pdar_id == $chitha_pdar_id && $chitha_pdar_id != '-1'){
      //         echo json_encode(array(
      //           'responseType'=>3,
      //           'error'=>"The Applicant already added in the table."
      //         ));
      //         return;
      //       }
      //     }
      //   }
  
        $applicant = array(
          'ref_no' => $ref_no,
          'pdar_id' => $pdar_id,
          'pdar_name' => $pdar_name,
          'pdar_name_eng' => $pdar_name_eng,
          'pdar_gender' =>  $pdar_gender,
          'pdar_dob' => $pdar_dob,
          'pdar_fname' => $pdar_fname,
          'pdar_sname' => $pdar_sname,
          'pdar_caste' => $pdar_caste,
          'pdar_occupation' => $pdar_occupation,
          'pdar_address' => $pdar_address,
          'pdar_mobile' => $pdar_mobile,
          'status' => "N",
          'case_no' => $case_no,
          'lid' => $lid,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),

        );
        //log_message("error", "MPR: t_pattadar object: \n" . json_encode($applicant));
        $this->db->trans_begin();

        $isPattadar = $this->db->insert("t_property_pattadar", $applicant);
        if($isPattadar != 1 ){
            $this->db->trans_rollback();
            log_message('error', '#ERROR0002: Insertion failed in t_property_pattadar table');
            $json = [
            'responseType' => 3,
            'message' => '#ERROR0002: Failed to insert pattadar detail. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }else{
            $this->db->trans_commit();
            $pid = $this->db->insert_id();
            $row = $this->landdetails->getRow($pid);
            echo json_encode(['responseType'=>2, 'result'=>$row]);
               //log_message("error", "MPR: t_property_pattadar inserted: " . $pdar_id);
               // echo json_encode(['responseType'=>2]);
            //   echo json_encode(array(
            //     'responseType' => 2,
            //     'data' => $this->landdetails->getTPattadar($ref_no)
            //   ));

        }
  
        
        
      } catch (Exception $e) {
         //alert the user.
        log_message("error", $e->getMessage());
         echo json_encode(array(
           'responseType' => 3,
           'error' => "Could not add applicant details"
         ));
       } finally {
         log_message("error", "################### END OF Property Card " . $this->router->fetch_method() . " #################");
       }
      
    }

    public function delPattadar(){
      $this->db->trans_begin();
      $pid = $this->input->post('pid');
      //if condition if no id fond or already deleted 
      $sql = "delete from t_property_pattadar where pid='$pid'";
      $result = $this->db->query($sql);
      if($this->db->affected_rows() != 1 )
      {
          $this->db->trans_rollback();
          $response['status']=0;
          echo json_encode(['status'=>0]);
          log_message("error","#PROP0001 Failed to delete pid: ". $pid);
          return;
      } else {
          $this->db->trans_commit();
          $response['status']=200;
          echo json_encode(['status'=>200]);
          return;
      }
    }

    public function addHouseProperty()
    {
      try {
        $this->db->trans_begin();
        $house_type = $this->input->post('house_type');
        $house_area = $this->input->post('house_area');      
        $house_storey = $this->input->post('house_storey');
        $ref_no = $this->input->post('ref_no');
        $case_no = $this->input->post('case_no');
        $lid = $this->input->post('lid');
      
  
        $house_property = array(
          'ref_no' => $ref_no,
          'house_type' => $house_type,
          'house_area' => $house_area,
          'house_storey' =>  $house_storey,
          'status' => "N",
          'case_no' => $case_no,
          'lid' => $lid,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),

        );
  
        $isProperty = $this->db->insert("t_property_house", $house_property);
        if($isProperty != 1 ){
            $this->db->trans_rollback();
            log_message('error', '#ERROR0001: Insertion failed in t_property_house table');
            $json = [
            'responseType' => 3,
            'message' => '#ERROR0001: Failed to insert property detail. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }else{
            $this->db->trans_commit();
            $hid = $this->db->insert_id();
            $hproperty = $this->landdetails->getHouse($hid);
            echo json_encode(['responseType'=>2, 'property'=>$hproperty]);
            //log_message("error", "MPR: t_property_pattadar inserted: " . $pdar_id);

        }
        
         
      } catch (Exception $e) {
         //alert the user.
        log_message("error", $e->getMessage());
         echo json_encode(array(
           'responseType' => 3,
           'error' => "Could not add applicant details"
         ));
       } finally {
         log_message("error", "################### END OF Property Card " . $this->router->fetch_method() . " #################");
       }
      
    }

    public function delHouse(){
      $this->db->trans_begin();
      $hid = $this->input->post('hid');
      //if condition if no id fond or already deleted 
      $sql = "delete from t_property_house where hid='$hid'";
      $result = $this->db->query($sql);
      if($this->db->affected_rows() != 1 )
      {
          $this->db->trans_rollback();
          $response['status']=0;
          echo json_encode(['status'=>0]);
          log_message("error","#PROP0002 Failed to delete hid: ". $hid);
          return;
      } else {
          $this->db->trans_commit();
          $response['status']=200;
          echo json_encode(['status'=>200]);
          return;
      }
    }

    public function finalPropertyCardSubmit()
    {
        $this->db->trans_begin();
        $ref_no = $this->input->post('ref_no');
        $lid = $this->input->post('lid');
        $Updatesql1 = "update  t_property_land set status='P' where ref_no ='$ref_no' and lid=$lid";       
        $this->db->query($Updatesql1);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRPS0001: Updation failed in t_property_land');
            $json = [
              'responseType' => 3,
              'message' => '#ERRPS0001: Failed to upadte status in Property Land. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        $Updatesql2 = "update  t_property_pattadar set status='P' where ref_no ='$ref_no' and lid=$lid";       
        $this->db->query($Updatesql2);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRPS0002: Updation failed in t_property_pattadar');
            $json = [
              'responseType' => 3,
              'message' => '#ERRPS0002: Failed to upadte status in Property Pattadar. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        $Updatesql3 = "update  t_property_house set status='P' where ref_no ='$ref_no' and lid=$lid";       
        $this->db->query($Updatesql3);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRPS0003: Updation failed in t_property_house');
            $json = [
              'responseType' => 3,
              'message' => '#ERRPS0003: Failed to upadte status in Property House. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
         } else {
            $this->db->trans_commit();
            // $rowProperty = $this->landdetails->getPropertyCard($lid);
            $data['getProperty'] = $this->landdetails->getPropertyCard($lid);
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
               'case_no' => $case_no
           );
            // var_dump($rowProperty);
            // echo json_encode(array(
            //    'responseType' => 2,
            //    'data' => array("lid" => $lid, "ref_no" => $ref_no)
            // ));


            $data['_view'] = 'propertycard/card';
            $this->load->view('layouts/main',$data);
         }  
         
        
      
    }

    public function forwardtoco()
    {
        $this->db->trans_begin();
        $ref_no = $this->input->post('ref_no');
        $lid = $this->input->post('lid');
        $case_no = $this->input->post('case_no');
        $Updatesql1 = "update  t_property_land set status='P',co_user_code='CO' where ref_no ='$ref_no' and lid=$lid";       
        $this->db->query($Updatesql1);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRPS0001: Updation failed in t_property_land');
            $json = [
              'responseType' => 3,
              'message' => '#ERRPS0001: Failed to upadte status in Property Land. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
         } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Property Card details forwarded to Circle Office. Case no # $case_no");
            redirect(base_url() . "index.php/propertyCard/addproperty");
            // $data['_view'] = 'propertycard/card';
            // $this->load->view('layouts/main',$data);
         }  
         
        
      
    }
    
    public function testdata(){
            // $rowProperty = $this->landdetails->getPropertyCard(37);
            $data['getProperty'] = $this->landdetails->getPropertyCard(45);
            foreach ($data['getProperty'] AS $res){
               $dist_code =  $res->dist_code;
               $subdiv_code =  $res->subdiv_code;
               $circle_code =  $res->cir_code;
               $mouza_code =  $res->mouza_pargona_code;
               $lot_no =  $res->lot_no;
               $vill_code =  $res->vill_townprt_code;
               $block =  $res->block;
               $gaon =  $res->gaon;
            }
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
            $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            var_dump($data['getProperty']);
    }


    public function update() {
      $data = array();
      $case_no = $this->input->get('case_no');
      $lid = $this->input->get('lid');
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
      $data['_view'] = 'propertycard/update_card';
      $this->load->view('layouts/main',$data);
  
  }


  public function propertyCardUpdate()
    {
         $this->db->trans_begin();
         $ref_no = $this->input->post('ref_no');
         $case_no = $this->input->post('case_no');
         $lid = $this->input->post('lid');

         $house_type = $this->input->post('house_type');
         $house_area = $this->input->post('house_area');      
         $house_storey = $this->input->post('house_storey');
         $data = array(
            'house_type' => $house_type,
            'house_area' => $house_area,
            'house_storey' =>  $house_storey,
            'updated_at' => date('Y-m-d H:i:s'),

         );

         $pdar_name = $this->input->post('pdar_name');
         $pdar_name_eng = $this->input->post('pdar_name_eng');      
         $pdar_gender = $this->input->post('pdar_gender');
         $pdar_dob = $this->input->post('pdar_dob');
         $pdar_fname = $this->input->post('pdar_fname');
         $pdar_sname = $this->input->post('pdar_sname');
         
         $pdar_caste = $this->input->post('pdar_caste');
         $pdar_occupation = $this->input->post('pdar_occupation');
         $pdar_address = $this->input->post('pdar_address');
         $pdar_mobile = $this->input->post('pdar_mobile');
         $applicant = array(
            'pdar_name' => $pdar_name,
            'pdar_name_eng' => $pdar_name_eng,
            'pdar_gender' =>  $pdar_gender,
            'pdar_dob' => $pdar_dob,
            'pdar_fname' => $pdar_fname,
            'pdar_sname' => $pdar_sname,
            'pdar_caste' => $pdar_caste,
            'pdar_occupation' => $pdar_occupation,
            'pdar_address' => $pdar_address,
            'pdar_mobile' => $pdar_mobile,
            'updated_at' => date('Y-m-d H:i:s'),
  
          );

            $block = $this->input->post('block');
            $gaon = $this->input->post('gaon');
            
            $dag_area_b = $this->input->post('bigha');
            $dag_area_k = $this->input->post('katha');
            $dag_area_lc = $this->input->post('lessa');

            $dag_area_g = $this->input->post('ganda');
            $dag_area_kr = $this->input->post('kranti');
            $sqft = $this->input->post('sqft');
            $dag_revenue = $this->input->post('dag_revenue');
            $local_rate = $this->input->post('local_rate');
            $zonal_value = $this->input->post('zonal_value');
            $remarks = $this->input->post('remarks');
            $landdata = array(
               'block' => $block,
               'gaon' => $gaon,
               'dag_area_b' => $dag_area_b,
               'dag_area_k' => $dag_area_k,
               'dag_area_lc' => $dag_area_lc,
               'dag_area_kr' => $dag_area_kr,
               'area_sqft' => $sqft,
               'dag_revenue' => $dag_revenue,
               'local_rate' => $local_rate,
               'zonal_value' => $zonal_value,
               'remarks' => $remarks,
               'updated_at' => date('Y-m-d H:i:s'),
     
             );
     

         if(strlen($lid)) {
            // $this->landdetails->update($lid, $data);
            // $this->db->update("t_property_house", $data);
            // var_dump($data); die();
            $this->db->where('lid', $lid);
            $this->db->update('t_property_pattadar', $applicant);
            if($this->db->affected_rows() == 0){
               $this->db->trans_rollback();
               log_message('error', '#ERRPS0021: Updation failed in t_property_pattadar');
            }

            $this->db->where('lid', $lid);
            $this->db->update('t_property_land', $landdata);
            if($this->db->affected_rows() == 0){
               $this->db->trans_rollback();
               log_message('error', '#ERRPS0022: Updation failed in t_property_land');
            }

            $this->db->where('lid', $lid);
            $this->db->update('t_property_house', $data);
            if($this->db->affected_rows() == 0){
               $this->db->trans_rollback();
               log_message('error', '#ERRPS0023: Updation failed in t_property_house');
            }
         }
        

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
         } else {
            $this->db->trans_commit();

            $this->session->set_flashdata('message', "Property Card details updated successfully. Case no # $case_no");
            // $data['_view'] = 'propertycard/update?lid='.$lid.'';
            // redirect(base_url() . "index.php/propertyCard/update?lid='trim($lid)'");
            // $data['_view'] = 'propertycard/update_card';
            // $this->load->view('layouts/main',$data);


            $data['getProperty'] = $this->landdetails->getPropertyCard($lid);
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
               'case_no' => $case_no
           );
            


            $data['_view'] = 'propertycard/card';
            $this->load->view('layouts/main',$data);
         }  
         
        
      
    }

    
    
}