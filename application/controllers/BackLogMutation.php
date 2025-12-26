<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 0);

class BackLogMutation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/CoofficeConversionModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
         $this->load->model('AgriStackCaseHistory');
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
    
    public function BackEntryMutation() {
		  // $db=  $this->session->userdata('db');
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));

        $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['villages'] = $data;
        
        $district['transfer_type'] = $this->mutationmodel->getTransferType();
        
        //$patt_type = $this->mutationmodel->getPattaTypeExcludingAksona();
        $patt_type = $this->mutationmodel->getPattaType();
        $district['patta_type_excluding_aksona'] = $patt_type;
        
        $query = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $district['lmname'] = $this->db->query($query)->result();

        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='SK'";
        $district['skname'] = $this->db->query($query)->result();

        $query = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='CO'";
        $district['coname'] = $this->db->query($query)->result();

        //var_dump($district);
        // $this->load->view('../views/BackEntryMutation/BackEntryLandMutation', $district);
        // $this->load->view('../views/footer');

        $district['_view'] = 'BackEntryMutation/BackEntryLandMutation';
        $this->load->view('layouts/main',$district);
    }
    
    public function check_case_no_exist(){
		 // $db=  $this->session->userdata('db');
        $case_no = $_GET['case_no'];
        $FieldOrOffice = $_GET['FieldOrOffice'];
        
        if($FieldOrOffice == 'F'){
            $suffix = '/FMUT-BL';
            $case_no = $case_no.$suffix;
            //echo "select count(*) as cb from    field_mut_basic where case_no='$case_no'";
            $check_case = $this->db->query("select count(*) as cb from    field_mut_basic where case_no='$case_no'")->row()->cb;
        } else {
            $suffix = '/OMUT-BL';
            $case_no = $case_no.$suffix;
            //echo "select count(*) as cb from    petition_basic where case_no='$case_no'";
            $check_case = $this->db->query("select count(*) as cb from    petition_basic where case_no='$case_no'")->row()->cb;
        }
        echo json_encode($check_case);
    }
    
    function BackLogRegister() {
		  //$db=  $this->session->userdata('db');
            $define_date = define_date;
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_code = $this->input->post('patta_type');
            $patta_no = trim($this->input->post('patta_no'));
            $dag_no_int = $this->input->post('dag_no');
            $year_no = $this->input->post('year_no');
            
            $transfer_type = $this->input->post('transfer_type');
            $reg_deed_no = $this->input->post('reg_deed_no');
            $deed_value = $this->input->post('reg_deed_value');
            $reg_deed_date = date('Y-m-d', strtotime($this->input->post('reg_deed_date')));

            $dag_area_b = $this->input->post('dag_area_b');
            $dag_area_k = $this->input->post('dag_area_k');
            $dag_area_lc = $this->input->post('dag_area_lc');

            $m_dag_area_b = $this->input->post('m_dag_area_b');
            $m_dag_area_k = $this->input->post('m_dag_area_k');
            $m_dag_area_lc = $this->input->post('m_dag_area_lc');

            $l_dag_area_b_P = $this->input->post('l_dag_area_b_P'); 
            $l_dag_area_k_P = $this->input->post('l_dag_area_k_P'); 
            $l_dag_area_lc_P = $this->input->post('l_dag_area_lc_P');

            if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $this->input->post('dag_area_g')==null?"0":$this->input->post('dag_area_g');
            $m_dag_area_g = $this->input->post('m_dag_area_kr')==null?"0":$this->input->post('m_dag_area_kr');
            $l_dag_area_g_P = $this->input->post('l_dag_area_g_P')==null?"0":$this->input->post('l_dag_area_g_P');

            }
            else{
                $dag_area_g = 0;
                $m_dag_area_g =0;
                $l_dag_area_g_P=0;
            }

            $case_no = $this->input->post('case_no');
            $FieldOrOffice = $this->input->post('FieldOrOffice');
            if($FieldOrOffice == 'F'){
                $suffix = '/FMUT-BL';
                //$petition_no=$this->basundharamodel->genearteFieldPetitionNo();
                $seq_pet=year_no.'000';
                $petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
                // $petition_no = $this->db->query("select max(petition_no) as petition_no from    field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                //     . "and date_entry>='$define_date' and petition_no is not null limit 1")->row()->petition_no;
            } else {
                $suffix = '/OMUT-BL';
               // $petition_no=$this->basundharamodel->genearteOfficePetitionNo();

                $seq_pet=year_no.'00';
                $petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
                // $petition_no = $this->db->query("select max(petition_no) as petition_no from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
                //     . "and date_entry>='$define_date' and petition_no is not null limit 1")->row()->petition_no;
            }
            
            if ($petition_no == null) {
                $petition_no = 1;
            } else {
                $petition_no+=1;
            }
            
            if ($deed_value == null) {
                $deed_value = 0;
            }
            
            $pitition_no = $petition_no;
            $order_date = $this->input->post('order_date');

            $conversion_data_backdate = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'patta_type_code' => $patta_code,
                'patta_no' => $patta_no,
                'dag_no_int' => $dag_no_int,
                'dag_area_b' => $dag_area_b,
                'dag_area_k' => $dag_area_k,
                'dag_area_lc' => $dag_area_lc,
                'dag_area_g' =>$dag_area_g,
                'l_dag_area_b_P' => $l_dag_area_b_P,
                'l_dag_area_k_P' => $l_dag_area_k_P,
                'l_dag_area_lc_P' => $l_dag_area_lc_P,
                'l_dag_area_g_P' => $l_dag_area_g_P,
                'm_dag_area_b' => $m_dag_area_b,
                'm_dag_area_k' => $m_dag_area_k,
                'm_dag_area_lc' => $m_dag_area_lc,
                'm_dag_area_g'  => $m_dag_area_g,
                'case_no' => $case_no . $suffix,
                'pitition_no' => $pitition_no, // exploded on / of the case no
                'ord_date' => $order_date,
                'FieldOrOffice' => $FieldOrOffice,
                'year_no' => $year_no,
                'reg_deed_no' => $reg_deed_no,
                'deed_value' => $deed_value,
                'reg_deed_date' => $reg_deed_date,
                'transfer_type' => $transfer_type
            );
            //var_dump($conversion_data_backdate);
            $this->session->set_userdata($conversion_data_backdate);

            $only_land_share = array(
                'bigha' => $m_dag_area_b,
                'kotha' => $m_dag_area_k,
                'lessa' => $m_dag_area_lc,
            );
            //var_dump($only_land_share);
            $this->session->set_userdata($only_land_share);
            redirect(base_url() . "index.php/BackLogMutation/BackLogMutationDetails");
        }
    }
    
    public function BackLogMutationDetails() {
		  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');

        $data['location'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_townprt_code,
        );

        $FieldOrOffice = $this->session->userdata('FieldOrOffice');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag_no_int = $this->session->userdata('dag_no_int');
        $patta_type_code = $this->session->userdata('patta_type_code');

        $patta_name = $this->db->query("select patta_type from    patta_code where type_code='$patta_type_code'")->row();

        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');

        $sqldag = "Select dag_no as c from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code' and dag_no_int = '$dag_no_int'"; // and dag_no_int = '$dag_no_int'

        $actual_dag_no = $this->db->query($sqldag)->row()->c;

        $data['datas'] = array(
            'patta_no' => $patta_no,
            'patta_type' => $patta_name->patta_type,
            'bigha' => $bigha,
            'kotha' => $kotha,
            'lessa' => round($lessa, 2),
            'dag_no' => $dag_no_int,
            'FieldOrOffice' => $FieldOrOffice,
            'actual_dag_no' => $actual_dag_no
        );
        
        $data['pattadar_details'] = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$actual_dag_no' and trim(p.patta_no)='$patta_no'  and p.patta_type_code='$patta_type_code'")->result(); //and d.p_flag!='1'

        $query1 = "select lm_name,lm_code from    lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . " and lot_no='$lot_no'";
        $data['lmname'] = $this->db->query($query1)->result();

        $query2 = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='SK'";
        $data['skname'] = $this->db->query($query2)->result();

        $query3 = "select username,user_code from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " user_desig_code='CO'";
        $data['coname'] = $this->db->query($query3)->result();

        $data['payment_type'] = $this->db->query("Select * from    premium_chalan_receipt")->result();

        $this->load->model('patta/PattaModel');
        //$this->load->view('../views/header');
        if($FieldOrOffice == 'F'){
                //$this->load->view('../views/BackEntryMutation/RegisterFieldMutation', $data);

                $data['_view'] = 'BackEntryMutation/RegisterFieldMutation';
                $this->load->view('layouts/main',$data);
        } else {
                //$this->load->view('../views/BackEntryMutation/RegisterOfficeMutation', $data);

                $data['_view'] = 'BackEntryMutation/RegisterOfficeMutation';
                $this->load->view('layouts/main',$data);  
        }
        //$this->load->view('../views/footer');
    }
    
    //---------------------------------------------------------------------------------------- Back log function for Field mutation starts here.
    public function RegisterFMutation() {
		 // $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        //var_dump($this->input->post());
        //var_dump($this->session->all_userdata());
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no_int = $this->session->userdata('dag_no_int');
        $patta_no = $this->session->userdata('patta_no');
        
        $mut_type = $this->session->userdata('FieldOrOffice');
        $case_no = $this->session->userdata('case_no');
        $report_date = $this->session->userdata('ord_date');
        $date_entry = $timestamp = date('Y-m-d G:i:s');
        
        $dag_no = $this->db->query("Select dag_no as dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code= '$patta_type_code' "
                . "and dag_no_int='$dag_no_int' and TRIM(patta_no) = '$patta_no'")->row()->dag_no;
        
        $define_date = define_date;
       
        // $petition_no_new = $this->db->query("select max(petition_no) as petition_no from    field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        //         . "and petition_no is not null limit 1")->row()->petition_no;
                
        // if ($petition_no_new == null) {
        //     $petition_no_new = 1;
        // } else {
        //     $petition_no_new += 1;
        // }
        //$petition_no_new=$this->basundharamodel->genearteOfficePetitionNo();

        $seq_pet=year_no.'00';
        $petition_no_new=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();

        // Add the applicants
        $applicant_name = $this->input->post('applicant_name');
        $guardian = $this->input->post('guardian');
        $add_1 = $this->input->post('add_1');
        $applicant_b = $this->input->post('inv_b');
        $applicant_k = $this->input->post('inv_k');
        $applicant_lc = $this->input->post('inv_lc');

        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
        $applicant_g = $this->input->post('inv_g')==null?"0":$this->input->post('inv_g');
        }
        else{
          $applicant_g='0';  
        }
        $hus_wife = '0';//$this->input->post('hus_wife');
//        if ($hus_wife == 'h') {
//            $husband_wife = true;
//        }
        $pet_minor_yn = '0';
        
        //Add field basic data
        $basicdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'mut_type' => '01', // 01 is for mutation.
            'rajah_adalat' => '',
            'trans_code' => $this->session->userdata('transfer_type'),
            'add_off_name' => $this->input->post('co_code'), // old co code
            'add_off_desig' => 'CO',
            'possession_yn' => '',
            'dispute_yn' => '',
            'order_passed' => 'B',
            'operation' => 'E',
            'deed_value' => $this->session->userdata('deed_value'),
            'reg_deed_date' => $this->session->userdata('reg_deed_date'), 
            'report_date' => $this->input->post('co_date'), 
            'date_entry' => $report_date,
            'reg_deed_no' => $this->session->userdata('reg_deed_no'), 
            'year_no' => $this->session->userdata('year_no'),
            'petition_no' => $petition_no_new,
            'case_no' => $case_no,
            'user_code' => $this->input->post('lm_code'), //old lm code
            'fee_collection ' => '',
            'date_of_order' => $this->input->post('co_date'),
        );
        //var_dump($basicdata);
        $this->db->insert('field_mut_basic', $basicdata); //************************
        
        
        $count_applicants = count($applicant_name);
        
        for ($i = 0; $i < $count_applicants; $i++) { 
            
                //$petition = $this->db->query("select count(pet_id) as pet_id from    field_mut_petitioner where pet_id is not null and case_no='$case_no' limit 1")->result();
                //$pet_id = $petition[0]->pet_id + 1;
                $pet_id = $i+1;
                
                if($applicant_b[$i]==null){
                    $app_b = '0';
                } else { $app_b = $applicant_b[$i]; }
                if($applicant_k[$i]==null){
                    $app_k = '0';
                } else { $app_k = $applicant_k[$i]; }
                if($applicant_lc[$i]==null){
                    $app_lc = '0';
                } else { $app_lc = $applicant_lc[$i]; }
                if($applicant_g[$i]==null){
                    $app_g = '0';
                } else { $app_g = $applicant_g[$i]; }
                
                $applicantdata = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'petition_no' => $petition_no_new,
                    'year_no' => $this->session->userdata('year_no'),
                    'pet_id' => $pet_id,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => $report_date,
                    'operation' => 'E',
                    'hus_wife' => $hus_wife,
                    'pet_name' => $applicant_name[$i],
                    'pet_gender' => '',
                    'guard_name' => $guardian[$i],
                    'guard_rel' => 'u',
                    'pet_mother' => '',
                    'pet_minor_yn' => $pet_minor_yn,
                    'add1' => $add_1[$i],
//                    'add2' => '',
//                    'pdar_mobile' => '',
//                    'pdar_aadharno' => '',
                    'applied_b' => $app_b,
                    'applied_k' => $app_k,
                    'applied_lc' => $app_lc,
                    //'applied_g' => $app_g,
                    'new_pet_name' => 'N',
                );
                //var_dump($applicantdata);
                $this->db->insert('field_mut_petitioner', $applicantdata); //************************
        }
        
        // Add dag details
        $dagdetailsdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'case_no' => $case_no, 
            'petition_no' => $petition_no_new,
            'patta_no' => $patta_no, 
            'patta_type_code' => $patta_type_code,
            'user_code' => $this->session->userdata('user_code'), 
            'date_entry' => $report_date, 
            'operation' => 'E',
            'deed_date' => $this->session->userdata('reg_deed_date'), 
            'deed_value' => $this->session->userdata('deed_value'), 
            'deed_reg_no' => $this->session->userdata('reg_deed_no'), 
            'year_no' => $this->session->userdata('year_no'),
            'dag_no' => $dag_no,
            'dag_area_b' => $this->session->userdata('dag_area_b'),
            'dag_area_k' => $this->session->userdata('dag_area_k'),
            'dag_area_lc' => $this->session->userdata('dag_area_lc'),
            'dag_area_g' => $this->session->userdata('dag_area_g'),
            'm_dag_area_b' => $this->session->userdata('m_dag_area_b'),
            'm_dag_area_k' => $this->session->userdata('m_dag_area_k'),
            'm_dag_area_lc' => $this->session->userdata('m_dag_area_lc'),
            'm_dag_area_g' => $this->session->userdata('m_dag_area_g'),
            'land_valuation' => '0',
            'remark' => '',
            'm_dag_area_kr' => '0',
        );
        //var_dump($dagdetailsdata);
        $this->db->insert('field_mut_dag_details', $dagdetailsdata); //************************
        
        // Add the pattadars
        $pdar_name = $this->input->post('pdar_name');
        $striked_out = $this->input->post('striked_out');
        $count_pattadars  = count($pdar_name);
        
        for ($j = 0; $j < $count_pattadars; $j++){
            $pdar_id = $pdar_name[$j];
            $pdar_cron_no = $j+1;
            $pdar_guard_reln = 'u';
            
            $pattadar = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join chitha_dag_pattadar d on 
                p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code 
                and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' and d.dag_no='$dag_no' and "
                    . "TRIM(p.patta_no)=trim('$patta_no')  and d.p_flag!='1' and p.patta_type_code='$patta_type_code' and p.pdar_id = '$pdar_id' ")->row();
            
            if($pattadar->pdar_guard_reln != null){
                $pdar_guard_reln = $pattadar->pdar_guard_reln;
            }
            $pattadardata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'pdar_cron_no' => $pdar_cron_no,
                'pdar_name' =>$pattadar->pdar_name,
                'striked_out' => $striked_out[$j],
                'pdar_guardian' => $pattadar->pdar_father,
                'pdar_rel_guar' => $pdar_guard_reln,
                'pdar_add1' => $pattadar->pdar_add1,
                'pdar_add2' => $pattadar->pdar_add2,
                'pdar_id' => $pdar_id,
                'date_entry' => $report_date,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'case_no' => $case_no,
                'patta_no' => $this->session->userdata('patta_no'),
                'patta_type_code' => $this->session->userdata('patta_type_code'),
                'petition_no' => $petition_no_new,
                'dag_no' => $dag_no,
                'year_no' => $this->session->userdata('year_no'),
            );
            //var_dump($pattadardata);
            $this->db->insert('field_mut_pattadar', $pattadardata); //************************
        }
        //exit();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata("message", "Field Mutation Case ".$case_no. " Registered Successfully.");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        }
    }
    
    public function FinalFOrder() {
		  $db=  $this->session->userdata('db');
        $data = array();
        $case_no = $this->input->get('case_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $mutation_type = $this->input->get('mut_type');
        
        $case_details = $this->db->query("select * from    field_mut_basic d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['case_details'] = $case_details;
        //var_dump($case_details);
        $petition_no = $case_details[0]->petition_no;
        $details = array(
                'case_no' => $case_details[0]->case_no, 'petition_no' => $case_details[0]->petition_no
            );
        $this->session->set_userdata($details);
        
        $dag_details = $this->db->query("select * from    field_mut_dag_details d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['dag_details'] = $dag_details;
        
        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code1;
        $data['subdiv_code'] = $subdiv_code1;
        $data['cir_code'] = $cir_code1;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;
        
        $field_mut_petitioner = $this->db->query("select * from    field_mut_petitioner d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no = '$petition_no'")->result();
        $data['field_mut_petitioner']=$field_mut_petitioner;
        
        $field_mut_pattadar = $this->db->query("select * from    field_mut_pattadar d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no = '$petition_no'")->result();
        $data['field_mut_pattadar']=$field_mut_pattadar;
        
        $dist_code = $this->utilityclass->getDistrictName($dist_code1);
        $subdiv_code = $this->utilityclass->getSubDivName($dist_code1, $subdiv_code1);
        $cir_code = $this->utilityclass->getCircleName($dist_code1, $subdiv_code1, $cir_code1);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1);
        $lot_no = $this->utilityclass->getLotName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1);
        $vill_townprt_code = $this->utilityclass->getVillageName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'mutation_type' => $mutation_type,
        );
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/casedetails', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'BackEntryMutation/casedetails';
        $this->load->view('layouts/main',$data);
     }
     
    public function UpdateFMutation() {
		  $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $this->db->trans_start();
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code1, $case_no);
        
        $dag_details = $this->db->query("select * from    field_mut_dag_details where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ")->row();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainCommonModel');
            $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($dag_details->dist_code,$dag_details->subdiv_code,
            $dag_details->cir_code,$dag_details->mouza_pargona_code,$dag_details->lot_no,$dag_details->vill_townprt_code,$dag_details->dag_no);

            if($block_status==true){

                $this->session->set_flashdata('message', "Backlog Entry cannot be passed for the given Dag as it is in Property chain!!");
                redirect(base_url() . "index.php/utility/backentry_utilities");
                return;
            }

        }

        
        
        $land_area_b = $dag_details->dag_area_b - $dag_details->m_dag_area_b;
        $land_area_k = $dag_details->dag_area_k - $dag_details->m_dag_area_k;
        $land_area_lc = $dag_details->dag_area_lc - $dag_details->m_dag_area_lc;
        $land_area_g = $dag_details->dag_area_g - $dag_details->m_dag_area_g;
        $land_area_kr = $dag_details->dag_area_kr - $dag_details->m_dag_area_kr;
        
        $field_mut_petitioner = "select * from    field_mut_petitioner where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
        $field_mut_pattadar = $this->db->query($field_mut_petitioner)->result();
        
        //checking the pattadars in jama_pattadar and chitha pattadar and also in chitha_dag_pattadars.
        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id) as cp from    chitha_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->cp;

        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id) as jp from    jama_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->jp;

        // for mutation
        if($pattadars_in_chitha_pattadar >= $pattadars_in_jama_pattadar){
            $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->pdar_id;
        } else {
            $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    jama_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->pdar_id;                        
        }

        if ($pdar_id == null) {
            $pdar_id = 1;
        }

        $pattadars_in_chitha_dag_pattadar = $this->db->query("select max(pdar_id) as cdp from    chitha_dag_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->cdp;

        if($pdar_id <= $pattadars_in_chitha_dag_pattadar){
            $pdar_id = $pattadars_in_chitha_dag_pattadar+1;
        }
        
        foreach($field_mut_pattadar as $applicant){
            $t_chitha_col8_occup = array(
                'dist_code' => $applicant->dist_code,
                'subdiv_code' => $applicant->subdiv_code,
                'cir_code' => $applicant->cir_code,
                'mouza_pargona_code' => $applicant->mouza_pargona_code,
                'lot_no' => $applicant->lot_no,
                'vill_townprt_code' => $applicant->vill_townprt_code,
                'pdar_id' => $pdar_id,
                'occupant_id' => $applicant->pet_id,
                'occupant_name' => $applicant->pet_name,
                'occupant_fmh_name' => $applicant->guard_name,
                'occupant_fmh_flag' => $applicant->guard_rel,
                'occupant_add1' => $applicant->add1,
                'occupant_add2' => $applicant->add2,
                //'occupant_add3' => $applicant->occupant_add3,
                'land_area_b' => $applicant->applied_b,
                'land_area_k' => $applicant->applied_k,
                'land_area_lc' => $applicant->applied_lc,
                //'revenue' => $applicant->revenue,
                'year_no' => $applicant->year_no,
                'petition_no' => $applicant->petition_no,
                'patta_no' => $dag_details->patta_no,
                'patta_type_code' => $dag_details->patta_type_code,
                'dag_no' => $dag_details->dag_no,
                'land_area_g' =>  $applicant->applied_g??0,
                'land_area_kr' => '0',
                'new_pattadar' => $applicant->new_pet_name,
            );
            //var_dump($t_chitha_col8_occup);
            $this->db->insert('t_chitha_col8_occup', $t_chitha_col8_occup);//************************
            $pdar_id = $pdar_id+1;
        }
        
        $pattadar_save = "select * from    field_mut_pattadar where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
        $pattadar_save = $this->db->query($pattadar_save)->result();
        
        foreach($pattadar_save as $pattadar){
            //var_dump($pattadar);
            $t_chitha_col8_inplace = array(
                'dist_code' => $pattadar->dist_code,
                'subdiv_code' => $pattadar->subdiv_code,
                'cir_code' => $pattadar->cir_code,
                'mouza_pargona_code' => $pattadar->mouza_pargona_code,
                'lot_no' => $pattadar->lot_no,
                'vill_townprt_code' => $pattadar->vill_townprt_code,
                'year_no' => $pattadar->year_no,
                'petition_no' => $pattadar->petition_no,
                'dag_no' => $pattadar->dag_no,
                'pdar_id' => $pattadar->pdar_id,
                'fmute_strike_out' => $pattadar->striked_out,
                'inplace_of_id' => $pattadar->pdar_cron_no,
                'inplace_of_name' => $pattadar->pdar_name,
                'land_area_b' => $land_area_b,
                'land_area_k' => $land_area_k,
                'land_area_lc' => $land_area_lc,
                'land_area_g' => $land_area_g,
                'land_area_kr' => $land_area_kr,
                'inplace_of_gender' => $pattadar->pdar_gender,
                'inplace_of_minor_yn' => $pattadar->pdar_minor_yn,
                'inplace_of_minor_dob' => $pattadar->pdar_minor_dob,
                'inplace_of_mother' => $pattadar->pdar_mother,
            );
            //var_dump($t_chitha_col8_inplace);
            $this->db->insert('t_chitha_col8_inplace', $t_chitha_col8_inplace);//*******************
        }
        

        $basic_details = "select * from    field_mut_basic where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
        $basic_details = $this->db->query($basic_details)->row();
         
        //var_dump($basic_details);
        $t_chitha_col8_order = array(
                'dist_code' => $basic_details->dist_code,
                'subdiv_code' => $basic_details->subdiv_code,
                'cir_code' => $basic_details->cir_code,
                'mouza_pargona_code' => $basic_details->mouza_pargona_code,
                'lot_no' => $basic_details->lot_no,
                'vill_townprt_code' => $basic_details->vill_townprt_code,
                'mut_land_area_b' => $dag_details->m_dag_area_b,
                'mut_land_area_k' => $dag_details->m_dag_area_k,
                'mut_land_area_lc' => $dag_details->m_dag_area_lc,
                'mut_land_area_g' => $dag_details->m_dag_area_g,
                'mut_land_area_kr' => $dag_details->m_dag_area_kr,
                'land_area_left_b' => $land_area_b,
                'land_area_left_k' => $land_area_k,
                'land_area_left_lc' => $land_area_lc,
                'land_area_left_g' => $land_area_g,
                'land_area_left_kr' => $land_area_kr,
                'rajah_adalat' => $basic_details->rajah_adalat,
                'nature_trans_code' => $basic_details->trans_code,
                'min_revenue' => $basic_details->min_revenue,
                'sk_code' => $basic_details->sk_id,
                'order_type_code' => $basic_details->mut_type,
                'case_no' => $dag_details->case_no,
                'year_no' => $dag_details->year_no,
                'petition_no' => $dag_details->petition_no,
                'dag_no' => $dag_details->dag_no,
                'deed_reg_no' => $dag_details->deed_reg_no,
                'deed_value' => $dag_details->deed_value,
                'deed_date' => $dag_details->deed_date,
                'lm_note_date' => $basic_details->report_date,
                'order_pass_yn' => 'Y',
                'lm_code' => $basic_details->user_code,
                'lm_sign_yn' => 'Y',
                'co_code' => $basic_details->add_off_name,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $basic_details->date_of_order,
                //'user_code' => $basic_details->add_off_name,
            );
            //var_dump($t_chitha_col8_order);
            $this->db->insert('t_chitha_col8_order', $t_chitha_col8_order);//******************
            $order_date = date('Y-m-d');
            $q = "update field_mut_basic set order_passed='y',report_date='$order_date' where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
            $this->db->query($q);//*********************
            
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could Not Pass Order. Error Code [T_TABLE_HAS_DATA].Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/utility/backentry_utilities");
                return false;
            }
            
            $ok = $this->autoFMutUpdate($basic_details->dist_code, $basic_details->subdiv_code, $basic_details->cir_code, $basic_details->mouza_pargona_code, $basic_details->lot_no, $basic_details->vill_townprt_code, $basic_details->petition_no, $dag_details->dag_no,$case_no);
            if ($ok) {
                $this->session->set_flashdata('message', "Back Log Field Mutation Order Has Been Passed");
            } else {
                $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/utility/backentry_utilities");
            }
            redirect(base_url() . "index.php/utility/backentry_utilities");
    }
    
    public function autoFMutUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no,$case_no=null) {
        $db=  $this->session->userdata('db');

	    $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        
        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from    t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' and iscorrected_inco is null";
        
        $t_data_order = $this->db->query($t_order_data_query)->result();
        
        foreach ($t_data_order as $ord) {
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $ord->co_code;
            $data['co_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = 'B';
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            
            $this->db->insert('chitha_col8_order', $data); //*******************
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //*******************
            
            $t_inplace_query = "select * from    t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
            $t_inplace_data = $this->db->query($t_inplace_query)->result();
            
            $t_occup_query = "select * from    t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                    . " and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query)->result();
            
            $chitha_basic_update = FALSE;
            foreach ($t_occup_data as $occ) {
                // $sql = "update chitha_basic set jama_yn=null"
                //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' ";

                // $this->db->query($sql); //*********************
                $table = 'chitha_basic';
                $params = ['jama_yn' => null];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'TRIM(patta_no)'     => trim($occ->patta_no), // requires raw handling in update function
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

                $this->db->trans_begin();
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->session->userdata('user_code');
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                
                $this->db->insert('chitha_col8_occup', $data); //*******************

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;
                
                if ($ord->order_type_code == '02') {
                    // for partition
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where dist_code='$dist_code' and "
                                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                                    . " mouza_pargona_code='$mouza_pargona_code' and "
                                    . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->new_patta_no')  "
                                    . " ")->row()->pdar_id;
                }
                
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no'] = $occ->new_dag_no;
                } else {
                    $dag_pattadar['dag_no'] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                //var_dump($dag_pattadar);

                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->session->userdata('user_code');
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';


                $chitha_basic_query = "select land_class_code from    chitha_basic "
                        . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                
                $result = $this->db->query($chitha_basic_query)->row();
                //var_dump($result);
                
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;

                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where "
                            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no";
                    $this->db->query($q); //***************************
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                            " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "E";
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);
                
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from    chitha_basic where"
                            . "  dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' ";

                    $data = $this->db->query($sql)->row();
                    
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    //var_dump($chitha_basic);
                    // $this->db->insert('chitha_basic', $chitha_basic); //************************
                    $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    //var_dump($dataNew);
                    $this->db->insert('chitha_col8_order', $dataNew); //***********************
                    

                    if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc *20 + $data->dag_area_g;
                    $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 6400);
                    $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                    $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320) / 20);
                    $left_g = $remaining_lessa - $left_b * 6400.0 - $left_k * 320.0 - $left_lc * 20.0;
                    $left_kr = 0;
                    }

                    else{
                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                    }
                    
                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue; 
                    
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update, "
                    //         . " dag_area_b=$left_b,dag_area_k=$left_k,dag_area_lc=$left_lc,"
                    //         . " dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' "
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql);//******************

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'        => null,
                        'dag_revenue'    => $dag_revenue_updates,
                        'dag_local_tax'  => $dag_local_tax_update,
                        'dag_area_b'     => $left_b,
                        'dag_area_k'     => $left_k,
                        'dag_area_lc'    => $left_lc,
                        'dag_area_g'     => $left_g,
                        'dag_area_kr'    => $left_kr,
                        'date_entry'     => $d,
                        'operation'      => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        // Use raw condition for TRIM(patta_no)
                        // You must handle this in your model’s `update_table` method
                        'RAW:TRIM(patta_no)' => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }
                
                $p_id = $dag_pattadar['pdar_id'];
                
                if ($ord->order_type_code == '02') {
                    $q = "select count(*) as count from    chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from    chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    $q = "select count(*) as count from    chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from    chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    //echo $q;
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                
                
                $occ->new_pattadar; // for partition it will always be new pattadar
                if (($occ->new_pattadar=='N')){
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);//**************
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    if(($cPattadarExists == 0)){
                        // $this->db->insert('chitha_pattadar', $chitha_pattadar);//***************
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    }
                }

                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//*********************
            }

            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//*********************
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1'
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $occup->pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {
                foreach ($t_inplace_data as $inplace) {
                    $data = array();

                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);


                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->session->userdata('user_code');
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = date('E');
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );

                    $queryCheck = "select count(*) as c from    chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and col8order_cron_no='$data[col8order_cron_no]' and "
                            . " inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                        //var_dump($data);
                        $this->db->insert('chitha_col8_inplace', $data);//****************

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                    $p_flag = '1';

                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                    // $update_query;
                    $corrected = date('Y-m-d G:i:s');
                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and dag_no='$dag_no'";

                    // $this->db->query($update_query); //*****************
                    $this->db->query($t_inplace_query); //*****************

                    $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query); //***************

                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
            $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            $this->db->query($order_update_query);
            return true;
        }
    }
    
    //----------------------------------------------------------------------------------- All Pending Case display for both field mutatin cases and office mutation cases
    public function PendingCases() {
		 // $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $qF = "select count(*) as count from    field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed = 'B'";
        $qF = $this->db->query($qF)->row()->count;
        
        $qP = "select count(*) as count from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed = 'B' and status = 'B' and mut_type = '03'";
        $qP = $this->db->query($qP)->row()->count;
        
        $config['total_rows'] = $qF+$qP;

        $q = "select * from    field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed = 'B' ORDER BY petition_no asc";
        $cases1 = $this->db->query($q)->result();
        
        $q1 = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type = '03' and order_passed = 'B' and status = 'B' ORDER BY petition_no asc";
        $cases2 = $this->db->query($q1)->result();
        
        $cases['cases'] = array_merge($cases1,$cases2);
        
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/MutationCases', $cases);
        // $this->load->view('../views/footer');

        $cases['_view'] = 'BackEntryMutation/MutationCases';
        $this->load->view('layouts/main',$cases);
    }
    
    //----------------------------------------------------------------------------------------------- Back log function for office mutation starts here.
    public function RegisterOMutation() {
		 // $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        //var_dump($this->input->post());
        //var_dump($this->session->all_userdata());
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no_int = $this->session->userdata('dag_no_int');
        $patta_no = $this->session->userdata('patta_no');

        // Added by Abhijit -- 2024-05-18
        $dag_area_b = $this->session->userdata('dag_area_b');
        $dag_area_k = $this->session->userdata('dag_area_k');
        $dag_area_lc = $this->session->userdata('dag_area_lc');
        $m_dag_area_b = $this->session->userdata('m_dag_area_b');
        $m_dag_area_k = $this->session->userdata('m_dag_area_k');
        $m_dag_area_lc = $this->session->userdata('m_dag_area_lc');
        
        $mut_type = $this->session->userdata('FieldOrOffice');
        $case_no = $this->session->userdata('case_no');
        $report_date = $this->session->userdata('ord_date');
        $date_entry = $timestamp = date('Y-m-d G:i:s');
        
        $dag_no = $this->db->query("Select dag_no as dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code= '$patta_type_code' "
                . "and dag_no_int='$dag_no_int' and TRIM(patta_no) = '$patta_no'")->row()->dag_no;
        
        $define_date = define_date;
        
        // $petition_no_new = $this->db->query("select max(petition_no) as petition_no from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        //         . "and petition_no is not null limit 1")->row()->petition_no;
        
        // if ($petition_no_new == null) {
        //     $petition_no_new = 1;
        // } else {
        //     $petition_no_new += 1;
        // }
       // $petition_no_new=$this->basundharamodel->genearteOfficePetitionNo();

        $seq_pet=year_no.'00';
        $petition_no_new=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        // Add the applicants
        $applicant_name = $this->input->post('applicant_name');
        $guardian = $this->input->post('guardian');
        $add_1 = $this->input->post('add_1');
        $applicant_b = $this->input->post('inv_b');
        $applicant_k = $this->input->post('inv_k');
        $applicant_lc = $this->input->post('inv_lc');
        $hus_wife = '0';//$this->input->post('hus_wife');
//        if ($hus_wife == 'h') {
//            $husband_wife = true;
//        }
        $pet_minor_yn = '0';
        $count_applicants = count($applicant_name);
        
        for ($i = 0; $i < $count_applicants; $i++) { 
                $pet_id = $i+1;
                
                if($applicant_b[$i]==null){
                    if($count_applicants == 1){
                        $app_b = $m_dag_area_b;
                    }else{
                        $app_b = '0';
                    }
                } else { $app_b = $applicant_b[$i]; }
                if($applicant_k[$i]==null){
                    if($count_applicants == 1){
                        $app_k = $m_dag_area_k;
                    }else{
                        $app_k = '0';
                    }
                } else { $app_k = $applicant_k[$i]; }
                if($applicant_lc[$i]==null){
                    if($count_applicants == 1){
                        $app_lc = $m_dag_area_lc;
                    }else{
                        $app_lc = '0';
                    }
                } else { $app_lc = $applicant_lc[$i]; }
                                
                $applicantdata = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'petition_no' => $petition_no_new,
                    'year_no' => $this->session->userdata('year_no'),
                    'pet_id' => $pet_id,
                    'guard_name' => $guardian[$i],
                    'guard_rel' => 'u',
                    'pet_name' => $applicant_name[$i],
                    //'pet_is_copdar' => $p['pet_is_copdar'],
                    'add1' => $add_1[$i],
                    'add2' => '',
                    'user_code' => $this->input->post('lm_code'),
                    'date_entry' => $report_date,
                    'operation' => 'E',
                    'new_pattadar' => 'N',
                    'pet_gender' => '',
                    'pet_mother' => '',
                    'pet_minor_yn' => '',
                    //'pet_minor_dob' => '',
                    'pdar_mobile' => '',
                    'applied_b' => $app_b,
                    'applied_k' => $app_k,
                    'applied_lc' => $app_lc,
            );
            // dd($applicantdata);
            $this->db->insert('petitioner', $applicantdata); //************
        }
        
        // Add the pattadars
        $pdar_name = $this->input->post('pdar_name');
        $striked_out = $this->input->post('striked_out');
        $count_pattadars  = count($pdar_name);
        
        for ($j = 0; $j < $count_pattadars; $j++){
            $pdar_id = $pdar_name[$j];
            $pdar_cron_no = $j+1;
            $pdar_guard_reln = 'u';
            
            $pattadar = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join chitha_dag_pattadar d on 
                p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code 
                and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' and d.dag_no='$dag_no' and "
                    . "TRIM(p.patta_no)=trim('$patta_no')  and d.p_flag!='1' and p.patta_type_code='$patta_type_code' and p.pdar_id = '$pdar_id' ")->row();
    
            if($pattadar->pdar_guard_reln != null){
                $pdar_guard_reln = $pattadar->pdar_guard_reln;
            }
            $pattadardata = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'year_no' => $this->session->userdata('year_no'),
                    'petition_no' => $petition_no_new,
                    'dag_no' => $dag_no,
                    'patta_no' => $this->session->userdata('patta_no'),
                    'patta_type_code' => $this->session->userdata('patta_type_code'),
                    'pdar_id' => $pdar_id,
                    'pdar_cron_no' => $pdar_cron_no,
                    'pdar_name' => $pattadar->pdar_name,
                    'pdar_guardian' => $pattadar->pdar_father,
                    'pdar_rel_guar' => $pdar_guard_reln,
                    'pdar_add1' => $pattadar->pdar_add1,
                    'pdar_add2' => $pattadar->pdar_add2,
                    'user_code' => $this->input->post('lm_code'),
                    'date_entry' => $report_date,
                    'operation' => 'E',
                    'striked_out' => $striked_out[$j],
            );
            //var_dump($pattadardata);
            $this->db->insert('petition_pattadar', $pattadardata); //************************
        }
        
        // Add dag details
        $dagdetailsdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => $this->session->userdata('year_no'),
                'petition_no' => $petition_no_new,
                // 'm_dag_area_b' => $this->session->userdata('m_dag_area_b'),
                // 'm_dag_area_k' => $this->session->userdata('m_dag_area_k'),
                // 'm_dag_area_lc' => $this->session->userdata('m_dag_area_lc'),
                'm_dag_area_b' => $m_dag_area_b,
                'm_dag_area_k' => $m_dag_area_k,
                'm_dag_area_lc' => $m_dag_area_lc,
                'm_dag_area_g' => '0.0000',
                'm_dag_area_kr' => '0',
                'dag_area_b' => $this->session->userdata('dag_area_b'),
                'dag_area_k' => $this->session->userdata('dag_area_k'),
                'dag_area_lc' => $this->session->userdata('dag_area_lc'),
                'dag_area_g' => '0.0000',
                'dag_area_kr' => '0',
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'user_code' => $this->input->post('lm_code'),
                'date_entry' => $report_date,
                'operation' => 'E',
                'dag_no' => $dag_no
            );
        //var_dump($dagdetailsdata);
        $this->db->insert('petition_dag_details', $dagdetailsdata);//************
        
        //Add Office Petition basic data
        $petition_basic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'year_no' => $this->session->userdata('year_no'),
            'petition_no' => $petition_no_new,
            'case_no' => $case_no,
            'submission_date' => $report_date,
            'mut_type' => '03',
            'trans_code' => $this->session->userdata('transfer_type'),
            'user_code' => $this->input->post('lm_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'deed_no' => $this->session->userdata('reg_deed_no'),
            'deed_value' => $this->session->userdata('deed_value'), 
            'deed_date' => date('Y-m-d', strtotime($this->session->userdata('deed_date'))),
            'order_passed' => 'B',
            'status' => 'B',
            'add_off_name' => $this->input->post('co_code'), 
            'co_user_code' => $this->input->post('co_code'),
            'date_of_order' => $this->input->post('co_date'),
        );
        //var_dump($petition_basic);
        $this->db->insert('petition_basic', $petition_basic); //************************
        //exit();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata("message", "Office Mutation Case ".$case_no. " Registered Successfully.");
            redirect(base_url() . "index.php/utility/backentry_utilities");
        }
    }
    
    public function FinalOOrder() {
		//  $db=  $this->session->userdata('db');
        $data = array();
        $case_no = $this->input->get('case_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $mutation_type = $this->input->get('mut_type');
        
        $case_details = $this->db->query("select * from    petition_basic d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['case_details'] = $case_details;
        //var_dump($case_details);
        $petition_no = $case_details[0]->petition_no;
        $details = array(
                'case_no' => $case_details[0]->case_no, 'petition_no' => $case_details[0]->petition_no
            );
        $this->session->set_userdata($details);
        
        $dag_details = $this->db->query("select * from    petition_dag_details d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['dag_details'] = $dag_details;
        
        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code1;
        $data['subdiv_code'] = $subdiv_code1;
        $data['cir_code'] = $cir_code1;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;
        
        $field_mut_petitioner = $this->db->query("select * from    petitioner d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no = '$petition_no'")->result();
        $data['field_mut_petitioner']=$field_mut_petitioner;
        
        $field_mut_pattadar = $this->db->query("select * from    petition_pattadar d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and petition_no = '$petition_no'")->result();
        $data['field_mut_pattadar']=$field_mut_pattadar;
        
        $dist_code = $this->utilityclass->getDistrictName($dist_code1);
        $subdiv_code = $this->utilityclass->getSubDivName($dist_code1, $subdiv_code1);
        $cir_code = $this->utilityclass->getCircleName($dist_code1, $subdiv_code1, $cir_code1);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1);
        $lot_no = $this->utilityclass->getLotName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1);
        $vill_townprt_code = $this->utilityclass->getVillageName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'mutation_type' => $mutation_type,
        );
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/casedetails', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'BackEntryMutation/casedetails';
        $this->load->view('layouts/main',$data);
     }
    
    public function UpdateOMutation() {
		 // $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $this->db->trans_start();
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code1, $case_no);
        $petition_basic = $this->db->query("select * from petition_basic where case_no=? and petition_no = ? and dist_code = ? and subdiv_code = ?", array($case_no, $petition_no, $dist_code1, $subdiv_code1))->row();
        $transfer_type = $petition_basic->trans_code;
        
        $dag_details = $this->db->query("select * from    petition_dag_details where petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ")->row();
                
        $land_area_b = $dag_details->dag_area_b - $dag_details->m_dag_area_b;
        $land_area_k = $dag_details->dag_area_k - $dag_details->m_dag_area_k;
        $land_area_lc = $dag_details->dag_area_lc - $dag_details->m_dag_area_lc;
        $land_area_g = $dag_details->dag_area_g - $dag_details->m_dag_area_g;
        $land_area_kr = $dag_details->dag_area_kr - $dag_details->m_dag_area_kr;
        
        $petitioner = "select * from    petitioner where petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' and  cir_code = '$cir_code1' ";
        $petitioner = $this->db->query($petitioner)->result();
        
        //checking the pattadars in jama_pattadar and chitha pattadar and also in chitha_dag_pattadars.
        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id) as cp from    chitha_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->cp;

        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id) as jp from    jama_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->jp;

        // for mutation
        if($pattadars_in_chitha_pattadar >= $pattadars_in_jama_pattadar){
            $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->pdar_id;
        } else {
            $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from    jama_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->pdar_id;                        
        }

        if ($pdar_id == null) {
            $pdar_id = 1;
        }

        $pattadars_in_chitha_dag_pattadar = $this->db->query("select max(pdar_id) as cdp from    chitha_dag_pattadar where dist_code='$dag_details->dist_code' and "
                . " subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and mouza_pargona_code='$dag_details->mouza_pargona_code' and"
                . " lot_no='$dag_details->lot_no' and vill_townprt_code='$dag_details->vill_townprt_code' and TRIM(patta_no)=trim('$dag_details->patta_no')")->row()->cdp;

        if($pdar_id <= $pattadars_in_chitha_dag_pattadar){
            $pdar_id = $pattadars_in_chitha_dag_pattadar+1;
        }
        
        foreach($petitioner as $applicant){
            //var_dump($applicant);
            $t_chitha_rmk_infavor_of = array(
                    'dist_code' => $applicant->dist_code,
                    'subdiv_code' => $applicant->subdiv_code,
                    'cir_code' => $applicant->cir_code,
                    'mouza_pargona_code' => $applicant->mouza_pargona_code,
                    'lot_no' => $applicant->lot_no,
                    'vill_townprt_code' => $applicant->vill_townprt_code,
                    'dag_no' =>$dag_details->dag_no,
                    'year_no' => $applicant->year_no,
                    'petition_no' => $applicant->petition_no,
                    'patta_type_code' => $dag_details->patta_type_code, 
                    'patta_no' => $dag_details->patta_no,
                    'ord_no' => $case_no,
                    'ord_date' => $applicant->date_entry,
                    //'pdar_id' => '',
                    'infavor_of_id' => $applicant->pet_id,
                    'infavor_of_name' => $applicant->pet_name, 
                    'infavor_of_guardian' => $applicant->guard_name,
                    'infav_of_guar_relation' => $applicant->guard_rel,
                    'infavor_of_add1' => $applicant->add1, 
                    'infavor_of_add2' => $applicant->add2, 
                    // 'by_right_of' => '01', 
                    'by_right_of' => $transfer_type, 
                    'land_area_b' => $applicant->applied_b, 
                    'land_area_k' => $applicant->applied_k,
                    'land_area_lc' => $applicant->applied_lc, 
                    'land_area_g' => '0', 
                    'land_area_kr' => '0',
                    'new_pattadar' => $applicant->new_pattadar,
                    'revenue' => '0'
            );
            //var_dump($t_chitha_rmk_infavor_of);
            $this->db->insert("t_chitha_rmk_infavor_of", $t_chitha_rmk_infavor_of); //**********************
            //$pdar_id = $pdar_id+1;
        }
        
        $pattadar_save = "select * from    petition_pattadar where petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' and  cir_code = '$cir_code1' ";
        $pattadar_save = $this->db->query($pattadar_save)->result();
        
        foreach($pattadar_save as $pattadar){
            //var_dump($pattadar);
            $petition_pattadar = array(
                'dist_code' => $pattadar->dist_code,
                'subdiv_code' => $pattadar->subdiv_code,
                'cir_code' => $pattadar->cir_code,
                'mouza_pargona_code' => $pattadar->mouza_pargona_code,
                'lot_no' => $pattadar->lot_no,
                'vill_townprt_code' => $pattadar->vill_townprt_code,
                'dag_no' => $pattadar->dag_no,
                'pdar_id' => $pattadar->pdar_id,
                'ord_no' => $case_no,
                'ord_date' => $applicant->date_entry,
                'year_no' => $pattadar->year_no,
                'petition_no' => $pattadar->petition_no,
            );
            
            if ($pattadar->striked_out === '1') {
                $petition_pattadar['inplace_of_name'] = $pattadar->pdar_name;
                $petition_pattadar['inplace_of_guardian'] = $pattadar->pdar_guardian;
                $petition_pattadar['inplace_of_relation'] = $pattadar->pdar_rel_guar;
                $petition_pattadar['inplace_of_id'] = $pattadar->pdar_id;
                $petition_pattadar['strike_out'] = $pattadar->striked_out;
                //var_dump($petition_pattadar);
                $this->db->insert('t_chitha_rmk_inplace_of', $petition_pattadar); //***************
            }
            if (($pattadar->striked_out === '0') || ($pattadar->striked_out === '')) {
                $petition_pattadar['alongwith_id'] = $pattadar->pdar_id;
                $petition_pattadar['alongwith_name'] = $pattadar->pdar_name;
                $petition_pattadar['alongwith_guardian'] = $pattadar->pdar_guardian;
                $petition_pattadar['alongwith_rel_gur'] = $pattadar->pdar_rel_guar;
                $petition_pattadar['striked_out'] = $pattadar->striked_out;
                //var_dump($petition_pattadar);
                $this->db->insert('t_chitha_rmk_alongwith', $petition_pattadar); //***************
            }
        }
                
         $basic_details = "select * from    petition_basic where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
        $basic_details = $this->db->query($basic_details)->row();
         
        //var_dump($basic_details);
        $t_chitha_rmk_ordbasic = array(
                'ord_no' => $basic_details->case_no,
                'ord_date' => $basic_details->submission_date,
                'lm_sign_yn' => 'Y',
                'ord_type_code' => $basic_details->mut_type,
                'lm_sign_date' => $basic_details->submission_date,
                'ord_passby_desig' => 'CO',
                'ord_passby_sign_yn' => 'Y',
                'sk_sign_yn' => 'Y',
                'case_no' => $basic_details->case_no,
                'co_ord_date' => $basic_details->date_of_order,
                'co_sign_yn' => 'Y',
                'co_code' => $basic_details->co_user_code,
                'lm_code' => $basic_details->user_code,
                'sk_code' =>'',
                'dist_code' => $basic_details->dist_code,
                'subdiv_code' => $basic_details->subdiv_code,
                'cir_code' => $basic_details->cir_code,
                'mouza_pargona_code' => $basic_details->mouza_pargona_code,
                'lot_no' => $basic_details->lot_no,
                'vill_townprt_code' => $basic_details->vill_townprt_code,
                'year_no' => $dag_details->year_no,
                'petition_no' => $dag_details->petition_no,
                'dag_no' => $dag_details->dag_no,
                'm_dag_area_b' => $dag_details->m_dag_area_b,
                'm_dag_area_k' => $dag_details->m_dag_area_k,
                'm_dag_area_lc' => $dag_details->m_dag_area_lc,
                'm_dag_area_g' => '0',
                'm_dag_area_kr' => '0',
                'min_revenue' => '0',
                'area_left_b' => $land_area_b,
                'area_left_k' => $land_area_k,
                'area_left_lc' => $land_area_lc,
                'area_left_g' => $land_area_g,
                'area_left_kr' => $land_area_kr,
                'sk_sign_date' => $basic_details->submission_date,
            );
            //var_dump($t_chitha_rmk_ordbasic);       
            $this->db->insert('t_chitha_rmk_ordbasic', $t_chitha_rmk_ordbasic);//****************  
            
            $order_date = date('Y-m-d');
            $q = "update petition_basic set order_passed='y',date_of_order='$order_date' where case_no='$case_no' and petition_no = '$petition_no' and dist_code = '$dist_code1' and subdiv_code = '$subdiv_code1' "
                . "and  cir_code = '$cir_code1' ";
            $this->db->query($q);//*********************
            
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could Not Pass Order. Error Code [T_TABLE_HAS_DATA].Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/utility/backentry_utilities");
                return false;
            }
            
            $ok = $this->autoOMutUpdate($basic_details->dist_code, $basic_details->subdiv_code, $basic_details->cir_code, $basic_details->mouza_pargona_code, $basic_details->lot_no, $basic_details->vill_townprt_code, $basic_details->petition_no, $dag_details->dag_no,$case_no);
            if ($ok) {
                $this->session->set_flashdata('message', "Back Log Office Mutation Order Has Been Passed");
            } else {
                $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/utility/backentry_utilities");
            }
            redirect(base_url() . "index.php/utility/backentry_utilities");
    }
    
    public function autoOMutUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no,$case_no=null) {
		  $db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $record_count = 0;
        
        $patta_no = "";
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

        $ord_cron_no = $this->db->query($q)->row()->c1;
        
        $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                . "and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
        
        $rmk_type_hist_no = $this->db->query($q)->row()->c2;
        
        if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                . "and vill_townprt_code='$vill_code' and ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' and dag_no='$dag_no' and iscorrected_inco is null";
        $orders = $this->db->query($order_query)->result();
        
        foreach ($orders as $order) {
            //copy alongwith information from    transaction to chitha
            $record_count++;
            $alongwith_q = "select * from    t_chitha_rmk_alongwith where ord_no='$order->ord_no'";
            $alongwith_d = $this->db->query($alongwith_q)->result();
            foreach ($alongwith_d as $along) {
                $ord_cron_no = $ord_cron_no;
                unset($along->year_no);
                unset($along->petition_no);
                unset($along->iscorrected_inco);
                unset($along->iscorrected_inco_date);
                unset($along->iscorrected_rkg_record);
                unset($along->iscorrected_rkg_date);
                unset($along->make_mdb);
                $along->rmk_type_hist_no = $rmk_type_hist_no;
                $along->ord_cron_no = $ord_cron_no;
                $along->user_code = $this->session->userdata('user_code');
                $along->operation = 'E';
                $along->date_entry = date('Y-m-d G:i:s');
                //var_dump($along);
                $this->db->insert('chitha_rmk_alongwith', $along); //*****************
            }
            
            $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no'";
            $inplace_d = $this->db->query($inplace_q)->result();
            foreach ($inplace_d as $inplace) {
                $petition_no = $inplace->petition_no;
                $ord_cron_no = $ord_cron_no;
                unset($inplace->year_no);
                unset($inplace->petition_no);
                unset($inplace->iscorrected_inco);
                unset($inplace->iscorrected_inco_date);
                unset($inplace->iscorrected_rkg_record);
                unset($inplace->iscorrected_rkg_date);
                unset($inplace->make_mdb);

                $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                $inplace->ord_cron_no = $ord_cron_no;
                $inplace->user_code = $this->session->userdata('user_code');
                $inplace->operation = 'E';
                $inplace->date_entry = date('Y-m-d G:i:s');
                //var_dump($inplace);
                
                $this->db->insert('chitha_rmk_inplace_of', $inplace);//**************
                $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'")->row();
                // $update_query = "update chitha_dag_pattadar set p_flag='1' where dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                //         . "cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' "
                //         . "and TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' and pdar_id=$inplace->pdar_id ";
                //echo $update_query;;
                $patta_no = trim($details->patta_no);
                // $this->db->query($update_query);

                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dist_code'          => $inplace->dist_code,
                    'subdiv_code'        => $inplace->subdiv_code,
                    'cir_code'           => $inplace->cir_code,
                    'mouza_pargona_code' => $inplace->mouza_pargona_code,
                    'lot_no'             => $inplace->lot_no,
                    'vill_townprt_code'  => $inplace->vill_townprt_code,
                    // Handle TRIM(patta_no) as raw condition (must be handled in your update method)
                    'RAW:TRIM(patta_no)' => trim($details->patta_no),
                    'dag_no'             => $details->dag_no,
                    'patta_type_code'    => $details->patta_type_code,
                    'pdar_id'            => $inplace->pdar_id,
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

            }

            $infavour_q = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no'";
            $infavour_d = $this->db->query($infavour_q)->result();
            foreach ($infavour_d as $infavour) {
                $infavour->user_code = $this->session->userdata('user_code');
                $infavour->operation = 'E';
                $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                $infavour->ord_cron_no = $ord_cron_no;
                $infavour->date_entry = date('Y-m-d G:i:s');
                unset($infavour->year_no);
                unset($infavour->petition_no);
                unset($infavour->iscorrected_inco);
                unset($infavour->iscorrected_inco_date);
                unset($infavour->iscorrected_rkg_record);
                unset($infavour->iscorrected_rkg_date);
                unset($infavour->make_mdb);
                unset($infavour->pdar_id);
                unset($infavour->revenue);
                unset($infavour->infavor_is_copdar);
                $new_pattadar = $infavour->new_pattadar;
                unset($infavour->new_pattadar);
                //var_dump($infavour);
                //save new pattadar in infavour of
                $this->db->insert('chitha_rmk_infavor_of', $infavour);

                $newObj = clone $infavour;
                $pattadar = array();
                $pattadar = array_merge($pattadar, $locationData);
                unset($pattadar['application_no']);

                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$infavour->patta_no') and "
                        . "patta_type_code='$infavour->patta_type_code'";
                $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

                //echo $pdar_id_query;
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $other_data = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'pdar_name' => $infavour->infavor_of_name,
                    'pdar_father' => $infavour->infavor_of_guardian,
                    'pdar_add1' => $infavour->infavor_of_add1,
                    'pdar_add2' => $infavour->infavor_of_add2,
                    'pdar_add3' => "",
                    'user_code' => $infavour->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                    'new_pdar_name' => $new_pattadar
                );
                $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'")->row();
                $patta_no = trim($details->patta_no);
                $pattadar = array_merge($pattadar, $other_data);
                // $this->db->insert('chitha_pattadar', $pattadar);
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);

                $dag_pattadar = array();
                $dag_pattadar = array_merge($dag_pattadar, $locationData);
                unset($dag_pattadar['application_no']);
                
                $dag_pattadar_other = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'dag_por_b' => $infavour->land_area_b,
                    'dag_por_k' => $infavour->land_area_k,
                    'dag_por_lc' => $infavour->land_area_lc,
                    'dag_por_g' => $infavour->land_area_g,
                    'dag_por_kr' => $infavour->land_area_kr,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'dag_no' => $infavour->dag_no,
                    'p_flag' => 0,
                );
                $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                // $q = "update chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and "
                //         . "TRIM(patta_no)=trim('$infavour->patta_no')";

                // $this->db->query($q);

                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill_code,
                    'dag_no'             => $infavour->dag_no,
                    // Handle TRIM(patta_no) as a raw condition
                    'RAW:TRIM(patta_no)' => trim($infavour->patta_no),
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

            }

            $order->user_code = $order->co_code;
            //$order->co_code = $this->session->userdata('user_code');
            $order->date_entry = $order->ord_date;
            $order->operation = 'B';
            //var_dump($order);
            unset($order->year_no);
            unset($order->petition_no);
            unset($order->year_no);
            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->isdataposted_torkg_db);
            unset($order->isorder_cancelled);
            unset($order->ifyes_reason1);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason4);
            unset($order->make_mdb);
            unset($order->min_revenue);
            unset($order->make_mdb);

            $rmk_gen = array(
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'jama_updated' => 'N',
                'patta_no' => trim($patta_no)
            );
            $rmk_gen = array_merge($locationData, $rmk_gen);
            unset($rmk_gen['application_no']);
            
            $this->db->insert('chitha_rmk_gen', $rmk_gen);
            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_type_hist_no;
            $order->co_code = $this->session->userdata('user_code');
            //var_dump($rmk_gen);
            $this->db->insert('chitha_rmk_ordbasic', $order);
            $q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
            $this->db->query($q);
            $rmk_type_hist_no++;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
            return true;
        }
    }
    
    //----------------------------------------------------------------------------------------------- Report for CO starts here.
    public function Report() {
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "select * from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and order_type_code = '01' and "
                . "operation = 'B' ORDER BY date_entry asc";
        $cases1 = $this->db->query($q)->result();
        
        $q1 = "select * from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_type_code = '03' and "
                . "operation = 'B' ORDER BY date_entry asc";
        $cases2 = $this->db->query($q1)->result();
        
        $cases['cases'] = array_merge($cases1,$cases2);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/GenerateReport', $cases);
        // $this->load->view('../views/footer');

        $cases['_view'] = 'BackEntryMutation/GenerateReport';
        $this->load->view('layouts/main',$cases);
    }
    
    //----------------------------------------------------------------------------------------------- Report for DC/ADC starts here.
    public function MaxReport() {
		  //$db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');

        $location = "select * from    location where cir_code != '00' and mouza_pargona_code = '00'";
        $location = $this->db->query($location)->result();
        
        foreach ($location as $loc){
            $total_count_Fmutation = '';
            $total_count_Omutation = '';
            $total_count_Fpartition = '';
            $total_count_Opartition = '';
            $order_type_code = '';
            $districtdata =  $this->utilityclass->getDistrictName($dist_code);
            $subdivdata = $this->utilityclass->getSubDivName($dist_code, $loc->subdiv_code);
            $circledata =  $this->utilityclass->getCircleName($dist_code, $loc->subdiv_code, $loc->cir_code);
            $q = "select count(*) as count from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and order_type_code = '01' "
                    . "and operation = 'B'";
            $cases1 = $this->db->query($q)->row()->count;
            if ($cases1 > 0) {
                $total_count_Fmutation = $cases1;
            }

            $q1 = "select count(*) as count from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and ord_type_code = '03' and "
                    . "operation = 'B'";
            $cases2 = $this->db->query($q1)->row()->count;
            if ($cases2 > 0) {
                $total_count_Omutation = $cases2;
            }
            $main = array
                (
                'dist_code' => $dist_code,
                'subdiv_code' => $loc->subdiv_code,
                'cir_code' => $loc->cir_code,
                'dist_name' => $districtdata,
                'subdiv_name' => $subdivdata,
                'cir_name' => $circledata,
                'total_count_Fmutation' => $total_count_Fmutation,
                'total_count_Omutation' => $total_count_Omutation,
                'total_count_Fpartition' => $total_count_Fpartition,
                'total_count_Opartition' =>$total_count_Opartition,
            );
            $result[]= $main;
        }
        $data['result']= $result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/GenerateMaxReport', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'BackEntryMutation/GenerateMaxReport';
        $this->load->view('layouts/main',$data);
    }
    
    public function MaxReportVill() {
		//  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->input->get('dist_code');
        $subdiv_code=$this->input->get('subdiv_code');
        $circle_code=$this->input->get('cir_code');
        $order_type_code=$this->input->get('order_type');
        
        if($order_type_code == 'FM'){
            $data['report_lebel'] = 'Field Mutation';
        } elseif ($order_type_code == 'OM') {
            $data['report_lebel'] = 'Office Mutation';
        } elseif ($order_type_code == 'FP') {
            $data['report_lebel'] = 'Field Partition';
        } elseif ($order_type_code == 'OP') {
            $data['report_lebel'] = 'Office Partition';
        }
        
        $location = "select * from    location where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code != '00' and lot_no != '00' "
                . "and vill_townprt_code != '00000'";
        $location = $this->db->query($location)->result();
        
        foreach ($location as $loc){
            $districtdata =  $this->utilityclass->getDistrictName($dist_code);
            $subdivdata = $this->utilityclass->getSubDivName($dist_code, $loc->subdiv_code);
            $circledata =  $this->utilityclass->getCircleName($dist_code, $loc->subdiv_code, $loc->cir_code);
            $mouzadata = $this->utilityclass->getMouzaName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code);
            $lotdata = $this->utilityclass->getLotName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no);
            $villdata = $this->utilityclass->getVillageName($dist_code, $loc->subdiv_code, $loc->cir_code, $loc->mouza_pargona_code, $loc->lot_no, $loc->vill_townprt_code);
           
            if($order_type_code == 'FM'){
                $q = "select count(*) as count from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and "
                        . "mouza_pargona_code='$loc->mouza_pargona_code' and lot_no = '$loc->lot_no' and vill_townprt_code = '$loc->vill_townprt_code' and  order_type_code = '01' "
                        . "and operation = 'B'";
                $cases1 = $this->db->query($q)->row()->count;
            } elseif ($order_type_code == 'OM') {
                $q = "select count(*) as count from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$loc->subdiv_code' and cir_code='$loc->cir_code' and "
                        . "mouza_pargona_code='$loc->mouza_pargona_code' and lot_no = '$loc->lot_no' and vill_townprt_code = '$loc->vill_townprt_code' and ord_type_code = '03' and "
                        . "operation = 'B'";
                $cases1 = $this->db->query($q)->row()->count;
            } elseif ($order_type_code == 'FP') {
                
            } elseif ($order_type_code == 'OP') {
                
            }
            
            if($cases1>0){
                $main = array
                    (
                    'dist_code' => $dist_code,
                    'subdiv_code' => $loc->subdiv_code,
                    'cir_code' => $loc->cir_code,
                    'mouza_pargona_code' => $loc->mouza_pargona_code, 
                    'lot_no' => $loc->lot_no, 
                    'vill_townprt_code' => $loc->vill_townprt_code,
                    'dist_name' => $districtdata,
                    'subdiv_name' => $subdivdata,
                    'cir_name' => $circledata,
                    'mouza_pargona_name' => $mouzadata, 
                    'lot_name' => $lotdata, 
                    'vill_townprt_name' => $villdata,
                    'order_type_code' => $order_type_code,
                    'total_count' => $cases1,
                    //$report_label = 'Field Mutation';
                );
                $result[]= $main;
            }
        }
        $data['result']= $result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/BackEntryMutation/GenerateMaxReportVill', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'BackEntryMutation/GenerateMaxReportVill';
        $this->load->view('layouts/main',$data);
        
    }
    
    public function FinalReport(){
		 // $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $district_code=$this->input->get('dist_code');
        $subdivision_code=$this->input->get('subdiv_code');
        $circlecode=$this->input->get('cir_code');
        $mouzacode=$this->input->get('mouza_pargona_code');
        $lot_code=$this->input->get('lot_no');
        $village_code=$this->input->get('vill_townprt_code');
        $order_type_code=$this->input->get('order_type');
        
        $this->load->helper('html');
        $this->load->view('../views/header');
        if($order_type_code == 'FM'){
            $chithainfo1['data'] = $this->getCol8($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);
            $this->load->view('../views/BackEntryMutation/Reportcol8', $chithainfo1);
        } elseif($order_type_code == 'OM'){
            $chithainfo1['data'] = $this->getCol31Remarks($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);
            $this->load->view('../views/BackEntryMutation/Reportcol31', $chithainfo1);
        }
        $this->load->view('../views/footer');
    }
    
    public function getCol8($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code){
		  $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        
        $innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,"
                . "co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code,dag_no from    Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
                . "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (operation='B' ) ";

        $innerdata4 = $this->db->query($innerquery4)->result();
        //var_dump($innerdata4);
        // this is the start to col8 order details
        foreach ($innerdata4 as $col8OrderDetails) {
                $col8order_cron_no = $col8OrderDetails->col8order_cron_no;
                $order_type_code = $col8OrderDetails->order_type_code;
                $nature_trans_code = $col8OrderDetails->nature_trans_code;
                $mut_land_area_b = $col8OrderDetails->mut_land_area_b;
                $mut_land_area_k = $col8OrderDetails->mut_land_area_k;
                $mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
                $user_code = $col8OrderDetails->user_code;
                $rajah_adalat = $col8OrderDetails->rajah_adalat;
                $lm_code = $col8OrderDetails->lm_code;
                $case_no = $col8OrderDetails->case_no;
                $co_ord_date = $col8OrderDetails->co_ord_date;
                $deed_value = $col8OrderDetails->deed_value;
                $deed_reg_no = $col8OrderDetails->deed_reg_no;
                $deed_date = $col8OrderDetails->deed_date;
                $co_code = $col8OrderDetails->co_code;
                $operation = $col8OrderDetails->operation;
                $dag_no = $col8OrderDetails->dag_no;

                $inplace_of_name = "";
                $inplaceof_alongwith = "";
                $occupant_name = "";
                $occupant_fmh_name = "";
                $occupant_fmh_flag = "";
                $new_patta_no = "";
                $new_dag_no = "";
                $hus_wife = "";
                $nature_trans_desc = "";
                $lm_name = "";
                $innerquery5 = "select order_type from    master_field_mut_type where  order_type_code = '$order_type_code' ";
                //////echo $innerquery5;
                $innerdata5 = $this->db->query($innerquery5)->row();
                $ordertype = $innerdata5->order_type;


                $innerquery6 = "select inplace_of_name,inplaceof_alongwith from    chitha_col8_inplace where dist_code='$district_code' and subdiv_code='$subdivision_code' and "
                        . "cir_code='$circlecode' and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and "
                        . "Col8Order_cron_no='$col8order_cron_no' ORDER BY inplace_of_id";

                $innerdata6 = $this->db->query($innerquery6)->result();
                $inplace_data = array();

                $innerquery7 = "select trans_desc_as from    nature_trans_code where trans_code = '$nature_trans_code'";
                foreach ($innerdata6 as $inplace) {
                    $inplace_data[] = array(
                        'inplace_of_name' => $inplace->inplace_of_name,
                        'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                    );
                }

                $occup_data = array();
                $innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from    chitha_col8_occup where dist_code='$district_code' "
                        . "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                        . "and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no'   ORDER BY occupant_id";
                $innerdata8 = $this->db->query($innerquery8)->result();

                foreach ($innerdata8 as $occupant) {
                    $occupant_name = $occupant->occupant_name;
                    $occupant_fmh_name = $occupant->occupant_fmh_name;
                    $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                    $new_patta_no = trim($occupant->new_patta_no);
                    $new_dag_no = $occupant->new_dag_no;
                    $hus_wife = $occupant->hus_wife;

                    $innerquery9 = "select guard_rel_desc_as from    master_guard_rel where guard_rel = '$occupant_fmh_flag'";
                    $innerdata9 = $this->db->query($innerquery9)->result();
                    $guard_rel_desc_as = "";
                    foreach ($innerdata9 as $guard_rel) {
                        $guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
                    }
                    $occup_data[] = array(
                        'occupant_name' => $occupant->occupant_name,
                        'occupant_fmh_name' => $occupant->occupant_fmh_name,
                        'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
                        'new_patta_no' => trim($occupant->new_patta_no),
                        'new_dag_no' => $occupant->new_dag_no,
                        'hus_wife' => $occupant->hus_wife,
                        'guard_rel_desc_as' => $guard_rel_desc_as
                    );
                }

                $innerquery10 = "select lm_name from    lm_code  where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
                //echo $innerquery10;
                $innerdata10 = $this->db->query($innerquery10)->result();


                foreach ($innerdata10 as $lm) {
                    $lm_name = $lm->lm_name;
                }

                $innerquery11 = "select username,status from    users where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";

                $innerdata11 = $this->db->query($innerquery11)->result();
                foreach ($innerdata11 as $users) {
                    $username = $users->username;
                    $status = $users->status;
                }

                if ($order_type_code == '03') {
                    $innerquery12 = "select * from    field_mut_objection where objection_case_no='$case_no' "; //and  obj_flag is not null and chitha_correct_yn='1' ";
                    $innerdata12 = $this->db->query($innerquery12)->result();

                    foreach ($innerdata12 as $objection) {
                        //var_dump($objection);
                        $q = "select col8order_cron_no,dag_no from    chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
                        $col8_cronNo = $this->db->query($q)->row();
                        $q = "select occupant_name from    chitha_col8_occup where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . "mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and col8order_cron_no='$col8_cronNo->col8order_cron_no' "
                                . "and dag_no='$col8_cronNo->dag_no'  ";
                        $result = $this->db->query($q)->result();
                        $fname = "";
                        foreach ($result as $name) {
                            $fname = $fname . $name->occupant_name . ",";
                        }
                        $data1[$dag_no]['objection'][] = array(
                            'mut_type' => $objection->mut_type,
                            'regist_date' => $objection->regist_date,
                            'objection_case_no' => $objection->objection_case_no,
                            'prev_fm_ca_no' => $objection->prev_fm_ca_no,
                            'submission_date' => $objection->entry_date,
                            'obj_name' => $objection->obj_name,
                            'co_id' => $objection->co_id,
                            'occupant' => $fname
                        );
                    }
                }
                $innerquery13 = "select * from    field_mut_petitioner where case_no='$case_no' ";
                $innerdata13 = $this->db->query($innerquery13)->result();

                if ($order_type_code == '01') {

                    $innerquery14 = " select deed_reg_no,deed_value,deed_date from    chitha_col8_order
                      where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
                    //echo $innerquery14;	
                    $innerdata14 = $this->db->query($innerquery14)->result();
                    foreach ($innerdata14 as $deedinf) {
                        $deed_reg_no = $deedinf->deed_reg_no;
                        $deed_value = $deedinf->deed_value;
                        $deed_date = $deedinf->deed_date;
                    }
                }
                
                $co_name = "select username from    users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                $co_name = $this->db->query($co_name)->result();
                foreach ($co_name as $co) {
                        $co_username = $co->username;
                }

                ////echo $col8OrderDetails->co_ord_date;
                if ($order_type_code != '03') {
                    $data1[$dag_no]['col8'][] = array(
                        'dist_code' => $district_code,
                        'subdiv_code' => $subdivision_code,
                        'cir_code' => $circlecode,
                        'mouza_pargona_code' => $mouzacode, 
                        'lot_no' => $lot_code, 
                        'vill_townprt_code' => $village_code,
                        'dag_no' => $col8OrderDetails->dag_no,
                        'co_ord_date' => $col8OrderDetails->co_ord_date,
                        'order_type_code' => $col8OrderDetails->order_type_code,
                        'case_no' => $col8OrderDetails->case_no,
                        'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
                        'order_type' => $ordertype,
                        'nature_trans_code' => $col8OrderDetails->nature_trans_code,
                        'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
                        'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
                        'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
                        'inplace' => $inplace_data,
                        'occup' => $occup_data,
                        'rajah' => $rajah_adalat,
                        'deed_value' => $deed_value,
                        'deed_reg_no' => $deed_reg_no,
                        'deed_date' => $deed_date,
                        'lm_name' => $lm_name,
                        'username' => $username,
                        'co_name' => $co_username,
                        'operation' => $operation
                    );
                }
            }
        return $data1;
    }
    
    public function getCol31Remarks($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code) {
		  $db=  $this->session->userdata('db');
        $data1 = array();
        $remark_type_code = '01';
        
        $district = $this->db->query("select dag_no,rmk_type_hist_no from    chitha_rmk_ordbasic where  dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . "mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (operation='B' ) order by ord_cron_no");
        $outerdata = $district->result();
        
        foreach ($outerdata as $chithadetails) {
            $d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $chithadetails->dag_no,$remark_type_code,$chithadetails->rmk_type_hist_no);
            $data1[$chithadetails->dag_no]['col31'][] = $d;
        }
        return $data1;
    }
    
    public function getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no, $rmk_type_code, $rmk_type_hist_no) {
         $db=  $this->session->userdata('db');
	   $data[] = array();
         $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from    chitha_rmk_gen where dist_code='$district_code' and subdiv_code='$subdivision_code' and "
                 . "cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dag_no') and "
                 . "rmk_type_hist_no = '$rmk_type_hist_no' order by rmk_type_hist_no";
        
         $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            if ($rmk_type_code == "01") {
                
                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                        . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,user_code,operation  "
                        . " from    chitha_rmk_ordbasic where  dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                        . " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";
                
                $innerdata27 = $this->db->query($innerquery27)->result();

                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $user_code = $chitharmk_ord_basic->user_code;
                    $operation = $chitharmk_ord_basic->operation;
                    $order_passby_designation = $chitharmk_ord_basic->ord_passby_desig;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;


                    $get_designation = $this->db->query("select user_desig_as as designation from    master_user_designation where user_desig_code = '$order_passby_designation'")->row()->designation;
                    
                    if ($ord_type_code == "03") {

                        $innerquery40 = "SELECT inplace_of_name FROM chitha_rmk_inplace_of  where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata40 = $this->db->query($innerquery40)->result();


                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $inplace_of_name = "";
                        $alongwithname = "";
                        $lm_name = "";
                        $status = "";
                        $username = "";
                        foreach ($innerdata40 as $inplace) {
                            $inplace_of_name = $inplace->inplace_of_name;
                        }

                        $innerquery41 = "select alongwith_name  FROM chitha_rmk_alongwith where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata41 = $this->db->query($innerquery41)->result();
                        $alongwitharray = array();
                        foreach ($innerdata41 as $alongwith) {

                            $alongwithname = $alongwith->alongwith_name;
                            $alongwitharray[] = array(
                                'alongwithname' => $alongwithname
                            );
                        }

                        $innerquery41 = "select inplace_of_name  FROM chitha_rmk_inplace_of where  dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata46 = $this->db->query($innerquery41)->result();
                        $inplaceofarray = array();
                        foreach ($innerdata46 as $inplace) {

                            $inplace_of_name = $inplace->inplace_of_name;
                            $inplaceofarray[] = array(
                                'inplace_of_name' => $inplace_of_name
                            );
                        }


                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                                . " new_patta_no  from    chitha_rmk_infavor_of where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                                . " and rmk_type_hist_no='$rmk_type_hist_no'"
                                . " and ord_no= '$ord_no' ";
                        //echo $innerquery42;
                        $innerdata42 = $this->db->query($innerquery42)->result();
                        $infav = array();
                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;

                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = trim($infav_of->new_patta_no);
                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        //infav query bracket

                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$chitharmk_ord_basic->lm_code'";
                        $innerdata43 = $this->db->query($innerquery43)->result();

                        foreach ($innerdata43 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery44 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        $innerdata44 = $this->db->query($innerquery44)->result();
                        foreach ($innerdata44 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from    chitha_rmk_ordbasic "
                                . " where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no'";
                        $m_area = $this->db->query($innerquery45)->row();
                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;
                        
                        $co_name = "select username from    users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                        $co_name = $this->db->query($co_name)->result();
                        foreach ($co_name as $co) {
                                $co_username = $co->username;
                        }

                        $data[] = array(
                            'dist_code' => $district_code,
                            'subdiv_code' => $subdivision_code,
                            'cir_code' => $circlecode,
                            'mouza_pargona_code' => $mouzacode, 
                            'lot_no' => $lot_code, 
                            'vill_townprt_code' => $village_code,
                            'dag_no' => $dag_no,
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'alongwith_name' => $alongwitharray,
                            'inplace_of_name' => $inplaceofarray,
                            'bigha' => $m_area_b,
                            'katha' => $m_area_k,
                            'lessa' => $m_area_lc,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'order_date' => $order_date,
                            'co_name' => $co_username,
                            'operation' => $operation
                        );
                    }

                    }
                }
        }
        return $data;
    }

    
}
