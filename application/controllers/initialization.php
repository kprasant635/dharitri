<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class initialization extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url'));
        $this->load->model('ApplicationPermission');
    }

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ123456789@#$%";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
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



    public function useraccount() {
        $allowed = ['CO','ADC','DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $random_password = $this->randomPassword();
        $sql="Select * from location where subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?";
        $mouzaList=$this->db->query($sql,array('01','01','00','00'))->result_array();
        foreach($mouzaList as $mou){
            $sql1="Select * from location where subdiv_code=? and cir_code=? and mouza_pargona_code=? 
            and lot_no!=? and vill_townprt_code=? ";
            $lotList=$this->db->query($sql,array('01','01',$mou['mouza_pargona_code'],'00','00000'))->result_array();
        }
        //echo $random_password;
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'auto_password' => null
        );
        $user_desig_code = $this->session->userdata('user_desig_code');
        if($user_desig_code=='CO'){
            $prive='mut';
            $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = '$prive' order by priv_code")->result();
        }
        else if($user_desig_code=='ADC' || $user_desig_code=='DC' || $user_desig_code=='SDO' ){
            $prive='adm';
            $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = '$prive' order by priv_code")->result();
            $data['dist_head']=$this->db->query("select concat(dist_code,'-',subdiv_code,'-',cir_code) as loc,loc_name 
                from location where subdiv_code in 
                (select subdiv_code from location where district_headquater is not null) 
                and cir_code<>'00' and mouza_pargona_code='00'")->result_array();
        }
        else
        {
            $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = 'adm' OR priv_code = 'mut' order by priv_code")->result();
        }
        $this->load->config('password_policy');
        $data['policy'] = $this->config->item('password_policy');
        // var_dump($data);
        $data['_view'] = 'initialization/co_create_account';
        $this->load->view('layouts/main',$data);
    }

    // public function getDesignations($role) {

    //     if ($role == 'mut') {
    //         $designation = $this->db->query("select * from master_user_designation where privilege = '$role'");
    //     } else {
    //         $designation = $this->db->query("select * from master_user_designation where privilege = '$role'");
    //     }
    //     $data = $designation->result();
    //     $json = array();
    //     foreach ($data as $object) {
    //         $json[] = array('user_desig_code' => trim($object->user_desig_code), 'user_desig_as' => trim($object->user_desig_as));
    //     }
    //     echo json_encode($json);
    // }

    // public function getDesignations($role) {
    //     //$db=  $this->session->userdata('db');
    //     $user_desig_code = $this->session->userdata('user_desig_code');
    //     // if ($role == 'mut') {
    //     //     $designation = $this->db->query("select * from   master_user_designation where privilege = '$role'");
    //     // }

    //     if ($user_desig_code == 'CO') {
    //         $designation = $this->db->query("select * from   master_user_designation where user_desig_code ='LM' or user_desig_code='SK' or user_desig_code='AST' or user_desig_code='DEO'  or user_desig_code='MOU'");
    //     }

    //     else if ($user_desig_code == 'ADC' || $user_desig_code == 'SDO') {
    //         $designation = $this->db->query("select * from   master_user_designation where user_desig_code ='CO' or user_desig_code='BO' or user_desig_code='SDLC' or user_desig_code='TN' ");
    //     }

    //     else if ($user_desig_code == 'DC') {
    //         $designation = $this->db->query("select * from   master_user_designation where user_desig_code ='ADC' or user_desig_code ='SDO' ");
    //     }

    //      else {
    //        // var_dump($this->session->userdata('user_desig_code'));
    //         $designation = $this->db->query("select * from   master_user_designation where privilege = '$role'");
    //     }


    //     $data = $designation->result();
    //     $json = array();
    //     foreach ($data as $object) {
    //         $json[] = array('user_desig_code' => trim($object->user_desig_code), 'user_desig_as' => trim($object->user_desig_as));
    //     }
    //     echo json_encode($json);
    // }

    //updated after adding consultant account(DCN)
    public function getDesignations($role) {
        //$db=  $this->session->userdata('db');
        $user_desig_code = $this->session->userdata('user_desig_code');
        // if ($role == 'mut') {
        //     $designation = $this->db->query("select * from   master_user_designation where privilege = '$role'");
        // }
        if ($user_desig_code == 'CO') {
            $designation = $this->db->query("select * from   master_user_designation where trim(user_desig_code)='LM' or trim(user_desig_code)='SK' or trim(user_desig_code)='CDA' or trim(user_desig_code)='DEO'  or trim(user_desig_code)='MOU' or trim(user_desig_code)='AST'");
        }
        else if ($user_desig_code == 'ADC' || $user_desig_code == 'SDO') {
            $designation = $this->db->query("select * from   master_user_designation where trim(user_desig_code) ='CO' or trim(user_desig_code)='BO' or trim(user_desig_code)='SDLC' or trim(user_desig_code)='NC' or trim(user_desig_code)='TN' or trim(user_desig_code)='DCN' or trim(user_desig_code) ='ADA'");
        }
        else if ($user_desig_code == 'DC') {
            $designation = $this->db->query("select * from   master_user_designation where trim(user_desig_code) ='ADC' or trim(user_desig_code) ='SDO' or trim(user_desig_code) ='DDA'");
        }
        else {
            // var_dump($this->session->userdata('user_desig_code'));
            $designation = $this->db->query("select * from   master_user_designation where privilege = '$role'");
        }
        $data = $designation->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('user_desig_code' => trim($object->user_desig_code), 'user_desig_as' => trim($object->user_desig_as));
        }
        echo json_encode($json);
    }

    public function getSkName($distcode, $subdivcode, $circode) {
        $sk = $this->db->query("select * FROM users AS u JOIN loginuser_table AS lg ON u.dist_code = lg.dist_code and u.subdiv_code = lg.subdiv_code and u.cir_code = lg.cir_code "
            . "and u.user_code = lg.user_code where u.dist_code = '$distcode' and u.subdiv_code = '$subdivcode' and u.cir_code = '$circode' "
            . "and trim(u.user_desig_code) = 'SK' and lg.dis_enb_option='E'");
        $data = $sk->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('user_code' => $object->user_code, 'username' => $object->username);
        }
        echo json_encode($json);
    }

    public function save_account()
    {
        $this->load->helper('security');
        $error=array();
        if(isset($_POST['designation']) && $_POST['designation'] == '' || !isset($_POST['designation'])){
            $error[]=(array('responseType' => 1,'message' => 'designation is required'));
            echo json_encode($error);
            return;
        }
        
        if(isset($_POST['user_name']) && $_POST['user_name'] == '' || !isset($_POST['user_name']))
            $error[]=(array('responseType' => 1,'message' => 'Username is required'));

        if($_POST['designation']=='ADC' ||  $_POST['designation']=='BO' || $_POST['designation']=='DC'){
            if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
                $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        }
        if($_POST['designation']=='SDO' ){
            if(isset($_POST['subdiv_code']) && $_POST['subdiv_code'] == '' || !isset($_POST['subdiv_code']))
                $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));
        }
        if($_POST['designation']=='CO' || $_POST['designation']=='LM' || $_POST['designation']=='SK'|| $_POST['designation']=='CDA'){
            if(isset($_POST['subdiv_code']) && $_POST['subdiv_code'] == '' || !isset($_POST['subdiv_code']))
                $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));

            if(isset($_POST['circle_code']) && $_POST['circle_code'] == '' || !isset($_POST['circle_code']))
                $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));
        }
        if($_POST['designation']=='MOU' ){
            if(isset($_POST['subdiv_code']) && $_POST['subdiv_code'] == '' || !isset($_POST['subdiv_code']))
                $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));

            if(isset($_POST['circle_code']) && $_POST['circle_code'] == '' || !isset($_POST['circle_code']))
                $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));

            if(isset($_POST['mouza_code']) && $_POST['mouza_code'] == '' || !isset($_POST['mouza_code']))
                $error[]=(array('responseType' => 1,'message' => 'mouza_code is required'));
        }
        if($_POST['designation']=='LM'){
            if(isset($_POST['mouza_code']) && $_POST['mouza_code'] == '' || !isset($_POST['mouza_code']))
                $error[]=(array('responseType' => 1,'message' => 'mouza_code is required'));

            if(isset($_POST['lot_no']) && $_POST['lot_no'] == '' || !isset($_POST['lot_no']))
                $error[]=(array('responseType' => 1,'message' => 'lot_no is required'));
        }
        if(isset($_POST['phone_no']) && $_POST['phone_no'] == '' || !isset($_POST['phone_no']))
            $error[]=(array('responseType' => 1,'message' => 'phone_no is required'));
        $user_desig_code=$_POST['designation'];

        if(isset($_POST['date_of_joining']) && $_POST['date_of_joining'] == '' || !isset($_POST['date_of_joining']))
            $error[]=(array('responseType' => 1,'message' => 'date_of_joining is required'));

        if(isset($_POST['type']) && $_POST['type'] == '' || !isset($_POST['type']))
            $error[]=(array('responseType' => 1,'message' => 'type is required'));

        if($_POST['type']=='A' && $_POST['designation']=='ADC'){
            if(isset($_POST['adc-attached']) && $_POST['adc-attached'] == '' || !isset($_POST['adc-attached']))
                $error[]=(array('responseType' => 1,'message' => 'Attached Circle is required'));
        }
        if(isset($_POST['new_pass']) && $_POST['new_pass'] == '' || !isset($_POST['new_pass']))
            $error[]=(array('responseType' => 1,'message' => 'Password is required'));

        if($error){
            echo json_encode($error);
            return;
        }
        ///////////USERNAME PLOICY/////////////
        $this->load->config('password_policy');
        $this->load->helper('password');
        $usernamePolicy = $this->config->item('username_policy');
        $username = $this->input->post('user_name');
        $uErrors = validate_username_policy($username, $usernamePolicy);

        if (!empty($uErrors)) {
            echo json_encode(['responseType' => 1,'errors' => $uErrors]);
            return;
        }
        //////////Password Ploicy/////////////
        
        $password = $this->input->post('new_pass');
        $policy = $this->config->item('password_policy');
        $errors = validate_password_policy($password, $policy);
        if (!empty($errors)) {
            echo json_encode(['responseType' => 1,'errors' => $errors]);
            return;
        }
        ///////////////////////
        
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        if($this->session->userdata('dist_code')!=$dist_code || $this->session->userdata('subdiv_code')!=$subdiv_code || $this->session->userdata('cir_code')!=$circle_code){
            echo json_encode(['responseType' => 1,'errors' => 'NOT-AUTHORIZED']);
            return;
        }
        $phone_no = $this->input->post('phone_no');
        $user_desig_code = trim($this->input->post('designation'), " ");
        //echo $user_desig_code;
        $mouza_pargona_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $insert=null;
        if ($mouza_pargona_code == null) {
            $mouza_pargona_code = '00';
        }
        if (($subdiv_code == null) || ($subdiv_code == '0')) {
            $subdiv_code = '00';
        }
        if (($circle_code == null) || ($circle_code == '0')) {
            $circle_code = '00';
        }
        if (($lot_no == null) || ($lot_no == '0')) {
            $lot_no = '00';
        }
        // $noc = $this->input->post('noc');
        // $bhunaksha = $this->input->post('bhunaksha');

        $date_of_joining = $this->input->post('date_of_joining');
        $date_o_j = date('Y-m-d', strtotime($date_of_joining));
        $date_of_relese = $this->input->post('date_of_relese');
        $date_o_r = date('Y-m-d', strtotime($date_of_relese));


        if($this->input->post('designation')=='SDO'){

            $sql="Select * from location where dist_code=? and subdiv_code=? and cir_code='00' and district_headquater ='Y'";
            $data=$this->db->query($sql,array($dist_code,$subdiv_code));
            //echo $data->num_rows();
            if($data->num_rows()>=1){
                $this->session->set_flashdata('message', "It's assigned as District HQ. You cann't create user for District HQ");
                redirect(base_url() . "index.php/home");
            }
            $sql="Select * from loginuser_table where dist_code=? and subdiv_code=? and user_code like 'SDO%' and dis_enb_option='E' ";
            $data=$this->db->query($sql,array($dist_code,$subdiv_code));
            //echo $data->num_rows();
            if($data->num_rows()>=1){
                $this->session->set_flashdata('message', "There is an active user already exists in the selected Subdivision !!");
                redirect(base_url() . "index.php/home");
            }
        }
        if ($user_desig_code != 'LM') {
            for ($i = 1; $i < 300; $i++) {
                // if ($user_desig_code == 'AST') {
                //     $user_code = "AS" . +$i;
                //     $existance = $this->db->query("select count(user_code) as d from users where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and user_code = '$user_code'")->row()->d;
                //     if ($existance == '0') {
                //         break;
                //     }
                // }
                if (($user_desig_code == 'BOP') || ($user_desig_code == 'BOC')) {
                    $user_code = "BO" . +$i;
                    $existance = $this->db->query("select count(user_code) as d from users where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and user_code = '$user_code'")->row()->d;
                    if ($existance == '0') {
                        break;
                    }
                } else {
                    $user_code = "$user_desig_code" . +$i;
                    $existance = $this->db->query("select count(user_code) as d from users where dist_code = '$dist_code' and user_code = '$user_code'")->row()->d;
                    if ($existance == '0') {
                        break;
                    }
                }
            }
            $user_code_for_users = $user_code;
            $this->db->trans_begin();
            $users = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'username' => $this->input->post('name'),
                'user_code' => $user_code_for_users,
                'user_desig_code' => $this->input->post('designation'),
                'status' => $this->input->post('type'),
                'emailid' => $this->input->post('emailID'),
                'date_from' => $date_o_j,
                'date_to' => $date_o_r,
                'phone_no' => $phone_no,
                // 'display_name' =>$this->input->post('display_name'),
                // 'user_type' =>$this->input->post('display_name'),
            );




            ///////////Validation////////////////////
            $display_name=$this->input->post('display_name');
            $user_type=$this->input->post('user_type');
            if(($this->input->post('designation')=='SDLC') || ($this->input->post('designation')=='NC'))
            {
                if($user_type==null || empty($this->input->post('user_type'))){
                    $this->session->set_flashdata('message', "Please Select User-Type");
                    show_error('Please Select SDLC Member-Type');
                    return;
                }
                if(($display_name==null) || empty($this->input->post('user_type'))){
                    $this->session->set_flashdata('message', "Display Name Required for SDLC Member");
                    // echo '20';
                    show_error('Display Name Required for SDLC Member');
                    return;
                }
                $users['display_name']=$this->input->post('display_name');
                $users['user_type']=$this->input->post('user_type');
            }


            $this->db->insert('users', $users);
            if($this->db->affected_rows()!=1){
                log_message('error',"##USERINSERT001".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in User Creation . Please try Again");
                redirect(base_url() . "index.php/home");
            }
            $loginuser_table = array(
                'use_name' => $this->input->post('user_name'),
                'user_code' => $user_code_for_users,
                'priv' => $this->input->post('role'),
                'date_of_creation' => date('Y-m-d'),
                'dis_enb_option' => $this->input->post('status'),
                'first_login' => 'Y',
                'activity' => '1',
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'password' => do_hash($this->input->post('new_pass')),
                'prev_password1' => $this->utilityclass->encryptData($this->input->post('new_pass'))
            );

            // if(($this->input->post('designation')=='MOU')  || ($this->input->post('designation')=='SDLC') || ($this->input->post('designation')=='NC') || $user_desig_code == 'DDA' || $user_desig_code == 'ADA')
            $userDesignations = ['MOU', 'SDLC', 'NC'];
            //$userRoles = ['DDA', 'ADA'];
            if (in_array($this->input->post('designation'), $userDesignations))
            {
                //////////////////////////////
                $loginuser_table['user_map']='y';
                ///////////////Insert in Central auth///////////////////
                $insert= array(
                    'dhar_user'=>$this->input->post('user_name'),
                    'dhar_code'=>$user_code_for_users,
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$subdiv_code,
                    'cir_code'=>$circle_code,
                    'mouza_pargona_code'=>$mouza_pargona_code,
                    'lot_no'=>$lot_no,
                    'mapped_by'=> $this->input->post('user_name'),
                    'date_of_map'=>date('Y-m-d'),
                    'password' => do_hash($this->input->post('new_pass')),
                    'prev_password1' => $this->utilityclass->encryptData($this->input->post('new_pass')),
                    'emailid' => $this->input->post('emailID'),
                );
                /////////////////////////////////
            }
            $usercode = $this->session->userdata('user_code');
            if($user_desig_code == 'DDA' || $user_desig_code == 'ADA' || $user_desig_code == 'CDA' || $user_desig_code == 'ADC' || $user_desig_code == 'CO'){
                
                try{
                    $this->ApplicationPermission->store($this->db, $user_code_for_users, 1, 0);
                } catch(Exception $e){
                    return response_json(['success' => false, 'message' => $e->getMessage()], 403);
                }

                $loginuser_table['parent_code'] = $usercode;
                $loginuser_table['permission_allowed'] = 1;
            }
            $loginuser_table['created_by'] = $usercode;
            $this->db->insert('loginuser_table', $loginuser_table);
            // echo $this->db->last_query();
            // exit;

            if($this->db->affected_rows()!=1){
                log_message('error',"##USERINSERT002".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in User Creation . Please try Again");
                redirect(base_url() . "index.php/home");
            }

            if($insert){
                $this->dbb=$this->load->database('auth', TRUE);
                $this->dbb->trans_begin();
                $this->dbb->insert('central_auth',$insert);
                if($this->dbb->affected_rows()!=1){
                    log_message('error',"##AUTH002".$this->dbb->last_query());
                    $this->dbb->trans_rollback();
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in User Creation . Please try Again");
                    redirect(base_url() . "index.php/home");
                }


                if($this->input->post('designation')=='MOU' || $this->input->post('designation')=='SDLC' || $this->input->post('designation')=='NC')
                {
                    $response=$this->apiCalForIlrmsMouUser($user_code_for_users,$this->input->post('designation'));
                    $response=json_decode($response);
                    log_message('error',json_encode($response));
                    if($response->result == "Y"){
                        $this->dbb->trans_commit();
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Successfull in User Creation !!");
                        redirect(base_url() . "index.php/home");
                    }else if($response->result == "N" || ($response->result == "USER_EXISTS")){
                        $this->dbb->trans_rollback();
                        $this->db->trans_rollback();
                        if($response->result == "USER_EXISTS"){
                            $this->session->set_flashdata('message', "Error in User Creation . User may already exists or another user is already enabled for the Mouza !!");
                            redirect(base_url() . "index.php/home");
                        }else
                            $this->session->set_flashdata('message', "Error in User Creation !!");
                        log_message('error',json_encode( $this->session));
                        redirect(base_url() . "index.php/home");
                    }
                }else{
                    // $this->dbb->trans_commit();
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Successfull in User Creation !!");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        else
        {
            for ($i = 1; $i < 100; $i++)
            {
                $lm_code = "M" . +$i;
                //echo $user_desig_code . $user_code . "<br>";
                $existance_lm = $this->db->query("select count(lm_code) as d from lm_code where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code = '$mouza_pargona_code' and lm_code = '$lm_code'")->row()->d;
                if ($existance_lm == '0') {
                    break;
                }
            }
            $user_code_for_lm = $lm_code;
            $lm_code = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('circle_code'),
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'lm_name' => $this->input->post('name'),
                'lm_code' => $user_code_for_lm,
                'status' => $this->input->post('status'),
                'corres_sk_code' => $this->input->post('sk_name'),
                'dt_from' => $date_o_j,
                'dt_to' => $date_o_r,
                'phone_no' => $phone_no
            );
            $this->db->insert('lm_code', $lm_code);
            if($this->db->affected_rows()!=1){
                log_message('error',"##USERLMINSERT002".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in User Creation . Please try Again");
                redirect(base_url() . "index.php/home");
            }
            $loginuser_table = array(
                'use_name' => $this->input->post('user_name'),
                'user_code' => $user_code_for_lm,
                'priv' => $this->input->post('role'),
                'date_of_creation' => date('Y-m-d'),
                'dis_enb_option' => $this->input->post('status'),
                'first_login' => 'Y',
                'activity' => '1',
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('circle_code'),
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'password' => do_hash($this->input->post('new_pass')),
                'prev_password1' => $this->utilityclass->encryptData($this->input->post('new_pass')),
            );
            $this->db->insert('loginuser_table', $loginuser_table);
            if($this->db->affected_rows()!=1){
                log_message('error',"##USERLMINSERT003".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in User Creation . Please try Again");
                redirect(base_url() . "index.php/home");
            }
        }
        $user_desig_code = $this->session->userdata('user_desig_code');
        if (($user_desig_code == 'DC') or ($user_desig_code == 'CO') or ($user_desig_code == 'ADC') or ($user_desig_code == 'ADM')){
            ////////////Mapping Circles ADC Attached////////////////////
            if($_POST['type']=='A' && $_POST['designation']=='ADC'){
                for($i=0;$i<count($this->input->post('adc-attached'));$i++)
                {
                    $circle_lists=explode('-', $_POST['adc-attached'][$i]);
                    $attached=
                        [
                            'username' => $this->input->post('name'),
                            'user_code' => $user_code_for_users,
                            'dist_code' =>$circle_lists[0],
                            'subdiv_code' =>$circle_lists[1],
                            'cir_code' =>$circle_lists[2],
                        ];
                    $this->db->insert('user_attached_mapping',$attached);
                    if($this->db->affected_rows()!=1){
                        log_message('error',"##ADC-MAPPED001".$this->dbb->last_query());
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in User Creation (ADC-MAPPED001) . Please try Again");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ////////////////////////////////
            if($this->db->trans_status() === TRUE){
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "User " . $this->input->post('name') . " Successfully Created.");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Failed in user creation");
                redirect(base_url() . "index.php/home");
            }
        } else {
            redirect(base_url() . "index.php/login/logout");
        }
    }

    public function viewaccount() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->result();
        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;
            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            $c = $this->db->query($q)->row()->c;
            if ($c == 0) {
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                $designation = $desg->user_desig_as;
                $result_data = $this->db->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $prriv = trim($u->priv);
                $role = $this->db->query("Select * from privilege where priv_code = '$prriv'")->row();
                $re = array(
                    'name' => $result_data->lm_name,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => $u->mouza_pargona_code,
                    'lot_no' => $u->lot_no,
                    'user_desig_code' => $c->user_desig_code
                );
            } else {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = 'Admin';
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => '00',
                    'lot_no' => '00',
                    'user_desig_code' => $result_data->user_desig_code
                );
            }
            $abc[] = $re;
        }
        $data['user_details'] = $abc;
        $data['_view'] = 'initialization/view_account';
        $this->load->view('layouts/main',$data);
    }

    public function viewaccount_master() {
        $dist_code = $this->session->userdata('dist_code');
        $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and cir_code = '00' and user_code not like 'ADM%'")->result();
        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;
            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            $c = $this->db->query($q)->row()->c;
            if ($c == 1) {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = 'Admin';
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                //echo "Select * from privilege where priv_code = '$u->priv'";
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => '00',
                    'lot_no' => '00',
                    'password' => $u->prev_password1,
                );
                //var_dump($re);    
            } else {
                $this->session->set_flashdata('message', "Sorry No Data Found...!");
                redirect(base_url() . "index.php/home");
                //var_dump($re);
            }
            $abc[] = $re;
        }
        $data['user_details'] = $abc;
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/view_account_dio', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'initialization/view_account_dio';
        $this->load->view('layouts/main',$data);
    }


    public function all_active_enabled_users() {
            // Allowed designations
        $allowed = ['ADC', 'DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        if($user_desig_code=='ADC' || $user_desig_code=='SDO')
        {
            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and ((user_code like 'CO%') or (user_code like 'BO%') or (user_code like 'SDLC%')) and dis_enb_option='E' order by user_code " )->result();
            // echo $this->db->last_query();
        }
        elseif ($user_desig_code=='DC') {
            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and cir_code = '00' and (user_code like 'ADC%' or (user_code like 'SDO%')) and dis_enb_option='E' ")->result();
        }
        $re=array();
        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;
            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $c = $this->db->query($q)->row()->c;
            if ($c == 1) {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = 'Admin';
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'type' => $result_data->status,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => '00',
                    'lot_no' => '00',
                    'password' => $u->prev_password1,
                    'user_desig_code' => $result_data->user_desig_code,
                );
            }
            $abc[] = $re;
        }
        // var_dump($abc);
        $data['user_details'] = $abc;
        $data['_view'] = 'initialization/view_account';
        $this->load->view('layouts/main',$data);
    }


    public function disable_other_users_adc() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $date= date('Y-m-d H:i:s');
        //echo $dist_code;
        $this->db->trans_begin();
        $sql = "update loginuser_table set dis_enb_option='D' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);
        if($this->db->affected_rows()==1){
            $this->dbb=$this->load->database('auth',true);
            $sql="Select * from loginuser_table where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
            $sql1="Select * from users where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $usersArray=$this->db->query($sql1);
            log_message('error',$this->db->last_query());
            if($usersArray->num_rows()==1)
            {

                $sqlUsers = "update users set date_to='$date' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
                $this->db->query($sqlUsers);

                if($this->db->affected_rows()!=1)
                {
                    $this->db->trans_rollback();
                    show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE003","401",$heading="Error-401");
                    return;
                }

                $usersArrayData=$usersArray->row_array();
                if($usersArrayData['user_desig_code']=='MOU' || $usersArrayData['user_desig_code']=='SDLC'){
                    $this->dbb->trans_begin();
                    $loginData=$this->db->query($sql)->row_array();

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."enableDisableAccount",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $loginData['use_name'],
                            'is_enabled' => 'D',
                            'dist_code' => $dist_code,
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"APIfromBasundhara:".$response);
                    // log_message('error',"APIfromBasundhara:".json_encode(array(
                    //         'unique_user_id' => $dataRow['use_name'],
                    //         'password' => $make_password,
                    //     )));
                    if($httpcode == 200){
                        $response_obj = json_decode($response);
                        if($response_obj->result == "N"){
                            $this->db->trans_rollback();
                            $this->dbb->trans_rollback();
                            log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                            show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                        //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                        show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                        return;
                    }
                    if($response_obj->result == "Y" && $response_obj->dist_count == 0){
                        $centralData="Update central_auth set active_deactive='D' where dhar_user='$loginData[use_name]' and dhar_code='$user_code'";
                        $this->dbb->query($centralData);
                        $auth_table=$this->dbb->affected_rows();
                    }else{
                        $auth_table=1;
                    }
                    ///////////Affective codes//////////////////
                    if($auth_table==1){
                        $this->dbb->trans_commit();
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        show_error($response_obj->msg."Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                        return;
                    }
                }
                $this->db->trans_commit();
            }
        }
        //*********************
        redirect(base_url() . "index.php/initialization/all_active_enabled_users");
    }


    public function enable_other_users_adc() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        //echo $dist_code;
        $this->db->trans_begin();
        $sql = "update loginuser_table set dis_enb_option='E' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);  //*********************
        $this->db->query($sql);
        if($this->db->affected_rows()==1){
            $this->dbb=$this->load->database('auth',true);
            $sql="Select * from loginuser_table where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
            $sql1="Select * from users where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $usersArray=$this->db->query($sql1);
            log_message('error',$this->db->last_query());
            if($usersArray->num_rows()==1){
                $usersArrayData=$usersArray->row_array();
                if($usersArrayData['user_desig_code']=='MOU' || $usersArrayData['user_desig_code']=='SDLC'){
                    $this->dbb->trans_begin();
                    $loginData=$this->db->query($sql)->row_array();
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."enableDisableAccount",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $loginData['use_name'],
                            'is_enabled' => 'E'
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"APIfromBasundhara:".$response);
                    // log_message('error',"APIfromBasundhara:".json_encode(array(
                    //         'unique_user_id' => $dataRow['use_name'],
                    //         'password' => $make_password,
                    //     )));
                    if($httpcode == 200){
                        $response_obj = json_decode($response);

                        if($response_obj->result == "N"){
                            $this->db->trans_rollback();
                            $this->dbb->trans_rollback();
                            log_message("error", "#ENABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #ENABLE002");
                            show_error("Internal Server Error, Please Try Again Later..., Error Code #ENABLE002","401",$heading="Error-401");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        log_message("error", "#ENABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                        //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #ENABLE002");
                        show_error("Internal Server Error, Please Try Again Later..., Error Code #ENABLE002","401",$heading="Error-401");
                        return;
                    }
                    ///////////Affective codes//////////////////
                    $centralData="Update central_auth set active_deactive='E' where dhar_user='$loginData[use_name]' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                    $this->dbb->query($centralData);
                    if($this->dbb->affected_rows()==1){
                        $this->dbb->trans_commit();
                        $this->db->trans_commit();
                    }
                }
                $this->db->trans_commit();
            }
        }
        redirect(base_url() . "index.php/initialization/all_inactive_disabled_users");
    }



    Public function user1() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );

        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;

        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
//echo $query;
        $data['subdiv'] = $query->result();
//var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code != 'ADM1' Order By cir_code"; //and user_code LIKE 'CO%' 
            $users = $this->dbb->query($all_users)->result();

            foreach ($users as $u) {
                $dist_code = $u->dist_code;
                $subdiv_code = $u->subdiv_code;
                $cir_code = $u->cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;

                $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;
                if ($c == 0) {
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                    $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
// now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                    $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                    $prriv = trim($u->priv);
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                    $password = $u->prev_password1;

                    if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                        $corres_sk_code = $result_data->corres_sk_code;
                    } else {
                        $corres_sk_code = '00';
                    }

                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);	
                } else {

                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    $password = $u->prev_password1;
                    $corres_sk_code = '01';
                    $check_sk = '01';
                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);
                }
                $abc[] = $re;
            }
            $data['user_details'] = $abc;
        } else {
            $data['user_details'] = '';
        }
//var_dump($data);
        // $this->load->view('header');
        // $this->load->view('initialization/all_active_enabled_users', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/all_active_enabled_users';
        $this->load->view('layouts/main',$data);
    }


    public function all_inactive_disabled_users() {
            // Allowed designations
        $allowed = ['ADC', 'DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $dist_code = $this->session->userdata('dist_code');
        $user_desig_code=$this->session->userdata('user_desig_code');

        if($user_desig_code=='ADC' || $user_desig_code=='SDO')
        {
            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and ((user_code like 'CO%') or (user_code like 'BO%') or (user_code like 'SDLC%')) and dis_enb_option='D' " )->result();
        }

        elseif ($user_desig_code=='DC') {

            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and cir_code = '00' and user_code like 'ADC%' and dis_enb_option='D'")->result();
        }

        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;

            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";

            $c = $this->db->query($q)->row()->c;
            if ($c == 1) {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();

                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = 'Admin';
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
//echo "Select * from privilege where priv_code = '$u->priv'";
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => '00',
                    'lot_no' => '00',

                    'password' => $u->prev_password1,
                );

            }

//var_dump($re);    
//             } else {
//                 $this->session->set_flashdata('message', "Sorry No Data Found...!");
//                 redirect(base_url() . "index.php/home");
// //var_dump($re);
//             }
            $abc[] = $re;
        }


        $data['user_details'] = $abc;
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/all_inactive_disabled_users', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/all_inactive_disabled_users';
        $this->load->view('layouts/main',$data);
    }

    Public function all_active_enabled_users_dio() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );

        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;

        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
//echo $query;
        $data['subdiv'] = $query->result();
//var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code != 'ADM1' Order By cir_code"; //and user_code LIKE 'CO%' 
            $users = $this->dbb->query($all_users)->result();

            foreach ($users as $u) {
                $dist_code = $u->dist_code;
                $subdiv_code = $u->subdiv_code;
                $cir_code = $u->cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;

                $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;
                if ($c == 0) {
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                    $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
// now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                    $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                    $prriv = trim($u->priv);
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                    $password = $u->prev_password1;

                    if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                        $corres_sk_code = $result_data->corres_sk_code;
                    } else {
                        $corres_sk_code = '00';
                    }

                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);    
                } else {

                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    $password = $u->prev_password1;
                    $corres_sk_code = '01';
                    $check_sk = '01';
                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);
                }
                $abc[] = $re;
            }
            $data['user_details'] = $abc;
        } else {
            $data['user_details'] = '';
        }
//var_dump($data);
        // $this->load->view('header');
        // $this->load->view('initialization/all_active_enabled_users', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/all_active_enabled_users';
        $this->load->view('layouts/main',$data);
    }


    Public function all_inactive_disabled_users_dio() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );

        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;


        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
//echo $query;
        $data['subdiv'] = $query->result();
//var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='D' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' order By cir_code"; //and user_code LIKE 'CO%' 
            //var_dump($all_users);
            $users = $this->dbb->query($all_users)->result();
            $i = 0;
            foreach ($users as $u) {
                $dist_code = $u->dist_code;
                $subdiv_code = $u->subdiv_code;
                $cir_code = $u->cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;

                $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;
                if ($c == 0) {
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                    $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
// now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                    $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                    $prriv = trim($u->priv);
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                    $password = $u->prev_password1;

                    if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                        $corres_sk_code = $result_data->corres_sk_code;
                    } else {
                        $corres_sk_code = '00';
                    }

                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);    
                } else {

                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    $password = $u->prev_password1;
                    $corres_sk_code = '01';
                    $check_sk = '01';
                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);
                }
                $abc[] = $re;
            }
            $data['user_details'] = $abc;
        } else {
            $data['user_details'] = '';
        }
        // $this->load->view('header');
        // $this->load->view('initialization/all_inactive_disabled_users_dio', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/all_inactive_disabled_users_dio';
        $this->load->view('layouts/main',$data);
    }



    Public function disableuser() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );

        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;


        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
//echo $query;
        $data['subdiv'] = $query->result();
//var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='D' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' order By cir_code"; //and user_code LIKE 'CO%' 
            //var_dump($all_users);
            $users = $this->dbb->query($all_users)->result();
            $i = 0;
            foreach ($users as $u) {
                $dist_code = $dist;

                $subdiv_code = $suvdiv_code;
                $cir_code = $cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;
                $q = "select count(*) as c from users where user_code = '$u->user_code' and  user_desig_code in (Select user_desig_code from master_user_designation) and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;

//echo $i."<br>";

                if ($c != 0) {
//echo $q."First";
                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    $password = $u->prev_password1;
                    $corres_sk_code = '01';
                    $check_sk = '01';
                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        'password' => "*****", //$password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);
                } else {
//echo "<br>";
                    $q = "select count(*) as c from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' "
                        . "and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                    $c = $this->dbb->query($q)->row()->c;
                    if ($c != 0) {
//echo $c."Second";
                        $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code='LM' ")->row();
                        $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
// now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                        $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                            . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                        $prriv = trim($u->priv);
                        $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                        $password = $u->prev_password1;

                        if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                            $corres_sk_code = $result_data->corres_sk_code;
                        } else {
                            $corres_sk_code = '00';
                        }

                        $re = array(
                            'name' => $result_data->lm_name,
                            'desig' => $desg->user_desig_as,
                            'password' => "*****", //$password,
                            'primary_login' => $u->use_name,
                            'role' => $role->priv_desc,
                            'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                            'status' => $u->dis_enb_option,
                            'user_code' => $u->user_code,
                            'dist_code' => $u->dist_code,
                            'subdiv_code' => $u->subdiv_code,
                            'cir_code' => $u->cir_code,
                            'mouza_pargona_code' => $u->mouza_pargona_code,
                            'lot_no' => $u->lot_no,
                            'corres_sk_code' => $corres_sk_code,
                            'sk_mapping' => $check_sk
                        );
//var_dump($re);
                    }//else{
// //var_dump($this->session->all_userdata());
// //var_dump($db);
// //var_dump($dbb);
// $q="Select * from loginuser_table where user_code='$u->user_code' and  dis_enb_option='D' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' order By cir_code";
// echo $q."<br>"."<br>";
// $result=$this->db->query($q)->row();
// var_dump($result);
// if(sizeof($result)>0){
// $re = array(
// 'name' => $result->use_name,
// 'desig' => $result->user_code,
// 'password' => "*****",//$password,
// 'primary_login' => $result->use_name,
// 'role' => $result->priv,
// 'date_of_joining' => date('d-m-Y', strtotime($result->date_of_creation)),
// 'status' => 'D',
// 'user_code' => $result->user_code,
// 'dist_code' => $result->dist_code,
// 'subdiv_code' => $result->subdiv_code,
// 'cir_code' => $result->cir_code,
// 'mouza_pargona_code' => $result->mouza_pargona_code,
// 'lot_no' => $result->lot_no,
// 'corres_sk_code' => 'NA',
// 'sk_mapping' => 'NA'
// );
// //var_dump($re);
// }
// //$re='';
// }
//var_dump($re);	
                }
                $abc[] = $re;
                $i++;
            }
            $data['user_details'] = $abc; // array_map("unserialize", array_unique(array_map("serialize", $abc)));
        } else {
            $data['user_details'] = '';
        }
//var_dump($data);
        // $this->load->view('header');
        // $this->load->view('initialization/all_inactive_disabled_users', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/all_inactive_disabled_users';
        $this->load->view('layouts/main',$data);
    }

    Public function all_active_enabled_users_co() {

            // Allowed designations
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $dist = $this->session->userdata('dist_code');
        $suvdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $abc=array();
        $all_users = "Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and  user_code NOT LIKE 'CO%' and priv='mut' Order By cir_code"; //and user_code LIKE 'CO%' 

        $users = $this->db->query($all_users)->result();

        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;
            $first_login = $u->first_login;

            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            $c = $this->db->query($q)->row()->c;
            if ($c == 0) {
                // 0 means the user is a lot mondol
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                $result_data = $this->db->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                    . "cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'  ")->row();
                //var_dump($result_data);
                // now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                    . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                $prriv = trim($u->priv);
                $role = $this->db->query("Select * from privilege where priv_code = '$prriv'")->row();
                $password = $u->prev_password1;

                if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                    $corres_sk_code = $result_data->corres_sk_code;
                } else {
                    $corres_sk_code = '00';
                }

                $re = array(
                    'name' => $result_data->lm_name,
                    'desig' => $desg->user_desig_as,
                    'password' => "*****", //$password,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => $u->mouza_pargona_code,
                    'lot_no' => $u->lot_no,
                    'corres_sk_code' => $corres_sk_code,
                    'sk_mapping' => $check_sk
                );
                //////////////////////////////////////////

            }
            else {
                // for all other users
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row();
                log_message('error',$this->db->last_query());
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                $password = $u->prev_password1;
                $corres_sk_code = '01';
                $check_sk = '01';

                $re = array(
                    'name' => $result_data->username,
                    'desig' => $desg->user_desig_as,
                    'password' => "*****", //$password,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => $u->mouza_pargona_code,
                    'lot_no' => $u->lot_no,
                    'corres_sk_code' => $corres_sk_code,
                    'sk_mapping' => $check_sk
                );
            }
            $abc[] = $re;
        }

        $data['user_details'] = $abc;
//var_dump($data);
        // $this->load->view('header');
        // $this->load->view('initialization/all_active_enabled_users_co', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/all_active_enabled_users_co';
        $this->load->view('layouts/main',$data);
    }

    // Public function all_inactive_disabled_users_co() {
    //         // Allowed designations
    //     $allowed = ['CO'];
    //     $user_desig_code = $this->session->userdata('user_desig_code');

    //     // Restrict access if not in allowed list
    //     if ( ! in_array($user_desig_code, $allowed)) {
    //         echo json_encode(['error' => 'Unauthorized access']);
    //         exit; // or die();
    //     }
    //     $dist = $this->session->userdata('dist_code');
    //     $suvdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $abc=array();

    //     $all_users = "Select * from loginuser_table where dis_enb_option='D' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code NOT LIKE 'CO%' and priv='mut' Order By cir_code"; //and user_code LIKE 'CO%' 
    //     $users = $this->db->query($all_users)->result();

    //     foreach ($users as $u) {
    //         $dist_code = $u->dist_code;
    //         $subdiv_code = $u->subdiv_code;
    //         $cir_code = $u->cir_code;
    //         $mouza_pargona_code = $u->mouza_pargona_code;
    //         $lot_no = $u->lot_no;
    //         $first_login = $u->first_login;

    //         $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
    //         $c = $this->db->query($q)->row()->c;
    //         if ($c == 0) {
    //             // 0 means the user is a lot mondol
    //             $desg = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
    //             $result_data = $this->db->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
    //             //var_dump($result_data);
    //             // now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
    //             $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
    //                 . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'");
    //             if( $check_sk->num_rows()>0){
    //                 $check_sk=$check_sk->row()->check_sk;
    //             }
    //             $prriv = trim($u->priv);
    //             $role = $this->db->query("Select * from privilege where priv_code = '$prriv'")->row();
    //             $password = $u->prev_password1;
    //             if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
    //                 $corres_sk_code = $result_data->corres_sk_code;
    //             } else {
    //                 $corres_sk_code = '00';
    //             }

    //             $re = array(
    //                 'name' => $result_data->lm_name,
    //                 'desig' => $desg->user_desig_as,
    //                 'password' => "*****", //$password,
    //                 'primary_login' => $u->use_name,
    //                 'role' => $role->priv_desc,
    //                 'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
    //                 'status' => $u->dis_enb_option,
    //                 'user_code' => $u->user_code,
    //                 'dist_code' => $u->dist_code,
    //                 'subdiv_code' => $u->subdiv_code,
    //                 'cir_code' => $u->cir_code,
    //                 'mouza_pargona_code' => $u->mouza_pargona_code,
    //                 'lot_no' => $u->lot_no,
    //                 'corres_sk_code' => $corres_sk_code,
    //                 'sk_mapping' => $check_sk
    //             );
    //         } else {
    //             // for all other users
    //             $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
    //             $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
    //             $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
    //             $password = $u->prev_password1;
    //             $corres_sk_code = '01';
    //             $check_sk = '01';
    //             $re = array(
    //                 'name' => $result_data->username,
    //                 'desig' => $desg->user_desig_as,
    //                 'password' => "*****", //$password,
    //                 'primary_login' => $u->use_name,
    //                 'role' => $role->priv_desc,
    //                 'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
    //                 'status' => $u->dis_enb_option,
    //                 'user_code' => $u->user_code,
    //                 'dist_code' => $u->dist_code,
    //                 'subdiv_code' => $u->subdiv_code,
    //                 'cir_code' => $u->cir_code,
    //                 'mouza_pargona_code' => $u->mouza_pargona_code,
    //                 'lot_no' => '00',
    //                 'corres_sk_code' => $corres_sk_code,
    //                 'sk_mapping' => $check_sk
    //             );
    //             //var_dump($re);
    //         }
    //         $abc[] = $re;
    //     }
    //     $data['user_details'] = $abc;
    //     //var_dump($data);
    //     // $this->load->view('header');
    //     // $this->load->view('initialization/all_inactive_disabled_users_co', $data);
    //     // $this->load->view('footer');


    //     $data['_view'] = 'initialization/all_inactive_disabled_users_co';
    //     $this->load->view('layouts/main',$data);
    // }

    // public function get_inactive_disabled_users_ajax()
    // {
    //     $allowed = ['CO'];
    //     $user_desig_code = $this->session->userdata('user_desig_code');

    //     if (!in_array($user_desig_code, $allowed)) {
    //         echo json_encode(['error' => 'Unauthorized access']);
    //         exit;
    //     }

    //     $dist = $this->session->userdata('dist_code');
    //     $suvdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');

    //     // DataTables parameters
    //     $draw = intval($this->input->post("draw"));
    //     $start = intval($this->input->post("start"));
    //     $length = intval($this->input->post("length"));
    //     $search = $this->input->post("search")['value'];

    //     $base_query = "
    //         SELECT * FROM loginuser_table 
    //         WHERE dis_enb_option='D'
    //         AND dist_code='$dist'
    //         AND subdiv_code='$suvdiv_code'
    //         AND cir_code='$cir_code'
    //         AND user_code NOT LIKE 'CO%'
    //         AND priv='mut'
    //     ";

    //     if (!empty($search)) {
    //         $base_query .= " AND (use_name ILIKE '%$search%' OR user_code ILIKE '%$search%')";
    //     }

    //     $count_query = $this->db->query($base_query)->num_rows();

    //     $paged_query = $base_query . " ORDER BY cir_code LIMIT $length OFFSET $start";
    //     $users = $this->db->query($paged_query)->result();

    //     $data = [];
    //     foreach ($users as $u) {
    //         // Determine designation, role, mouza, etc. (simplified for brevity)
    //         $status = "<span style='color:red;'>Disabled</span>";
    //         $name = $u->use_name;
    //         $role = $this->db->query("SELECT priv_desc FROM privilege WHERE priv_code = '{$u->priv}'")->row()->priv_desc ?? '';
    //         $disable_date = $this->utilityclass->getDisableUserDate(
    //             $u->use_name, $u->user_code, $u->dist_code,
    //             $u->subdiv_code, $u->cir_code,
    //             $u->mouza_pargona_code, $u->lot_no
    //         );

    //         $edit_url = base_url("index.php/initialization/co_edit_account?user_code={$u->user_code}&dist_code={$u->dist_code}&subdiv_code={$u->subdiv_code}&cir_code={$u->cir_code}&mouza_pargona_code={$u->mouza_pargona_code}&lot_no={$u->lot_no}");

    //         $actions = "<a href='$edit_url' title='Edit User'>
    //             <span class='glyphicon glyphicon-pencil' style='color:blue;'></span></a>";

    //         $data[] = [
    //             $status,
    //             $name,
    //             $u->use_name,
    //             $disable_date,
    //             'N/A', // designation
    //             $this->utilityclass->getCircleName($u->dist_code, $u->subdiv_code, $u->cir_code),
    //             'N/A',
    //             $actions
    //         ];
    //     }

    //     echo json_encode([
    //         "draw" => $draw,
    //         "recordsTotal" => $count_query,
    //         "recordsFiltered" => $count_query,
    //         "data" => $data
    //     ]);
    // }


    public function all_inactive_disabled_users_co()
    {
        // Restrict access
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        if (!in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit;
        }

        // Just load the view (no data fetching)
        $data['_view'] = 'initialization/all_inactive_disabled_users_co';
        $this->load->view('layouts/main', $data);
    }


    public function get_inactive_disabled_users_ajax()
    {
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        if (!in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit;
        }

        $dist = $this->session->userdata('dist_code');
        $suvdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // DataTables params
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search")['value'];

        // Base query
        $base_query = "
            SELECT * FROM loginuser_table 
            WHERE dis_enb_option='D'
            AND dist_code='$dist'
            AND subdiv_code='$suvdiv_code'
            AND cir_code='$cir_code'
            AND user_code NOT LIKE 'CO%'
            AND priv='mut'
        ";

        if (!empty($search)) {
            $base_query .= " AND (use_name ILIKE '%$search%' OR user_code ILIKE '%$search%')";
        }

        $totalFiltered = $this->db->query($base_query)->num_rows();

        $paged_query = $base_query . " ORDER BY cir_code LIMIT $length OFFSET $start";
        $users = $this->db->query($paged_query)->result();

        $data = [];
        foreach ($users as $u) {
            // Fetch details from related tables (short version)
            $desig = $this->db->query("SELECT user_desig_as FROM master_user_designation WHERE user_desig_code='LM'")->row()->user_desig_as ?? 'N/A';
            $role = $this->db->query("SELECT priv_desc FROM privilege WHERE priv_code='{$u->priv}'")->row()->priv_desc ?? 'N/A';
            $disable_date = $this->utilityclass->getDisableUserDate(
                $u->use_name, $u->user_code, $u->dist_code,
                $u->subdiv_code, $u->cir_code,
                $u->mouza_pargona_code, $u->lot_no
            );

            $status = "<span style='color:red;'>Disabled</span>";

            $edit_url = base_url("index.php/initialization/co_edit_account?user_code={$u->user_code}&dist_code={$u->dist_code}&subdiv_code={$u->subdiv_code}&cir_code={$u->cir_code}&mouza_pargona_code={$u->mouza_pargona_code}&lot_no={$u->lot_no}");
            $actions = "<a href='$edit_url' title='Edit User'><span class='glyphicon glyphicon-pencil' style='color:blue;'></span></a>";

            $mouza_name = ($u->mouza_pargona_code == '00')
                ? ''
                : $this->utilityclass->getMouzaName($u->dist_code, $u->subdiv_code, $u->cir_code, $u->mouza_pargona_code);

            $circle_name = $this->utilityclass->getCircleName($u->dist_code, $u->subdiv_code, $u->cir_code);

            $data[] = [
                'status' => $status,
                'name' => $u->use_name,
                'login' => $u->use_name,
                'disable_date' => $disable_date,
                'designation' => $desig,
                'circle' => $circle_name,
                'mouza' => $mouza_name,
                'action' => $actions
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalFiltered,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }



    public function edit_accounts() {
            // Allowed designations
        $allowed = ['CO', 'DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
//var_dump($this->session->all_userdata());
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $q = "select count(*) as c from users where user_code='$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
        $c = $this->db->query($q)->row()->c;
        if ($c == 0) {
            $result_data1 = $this->db->query("Select * from lm_code where lm_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM' ")->row();
//echo $result_data1->corres_sk_code;

            if ((substr($result_data1->corres_sk_code, 0, 2) === 'SK')) {
                $result_data5 = $this->db->query("Select * from users where user_code = '$result_data1->corres_sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $sk_name = $result_data5->username;
                $sk_code = $result_data5->user_code;
            } else {
                $sk_name = '';
                $sk_code = '';
            }

            $designation = $result_data4->user_desig_as;
            $name = $result_data1->lm_name;
            $joining_date = date('d-m-Y', strtotime($result_data1->dt_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->dt_to));
            $desig_code = 'LM';
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        } else {
            $result_data1 = $this->db->query("Select * from users where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
//echo "Select * from users where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = '$user_code' and dist_code = '$dist_code' and "
                . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();

            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data1->user_desig_code' ")->row();
//var_dump ($result_data4);
            if (empty($result_data4)) {
                $designation = 'Admin';
            } else {
                $designation = $result_data4->user_desig_as;
            }
            $name = $result_data1->username;
            $joining_date = date('d-m-Y', strtotime($result_data1->date_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->date_to));
            $sk_name = "00";
            $sk_code = "00";
            $desig_code = $result_data1->user_desig_code;
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        }

        $dist_name = $this->utilityclass->getDistrictName($result_data2->dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($result_data2->dist_code, $result_data2->subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code, $result_data2->lot_no);

//echo $result_data2->dist_code." ".$result_data2->subdiv_code." ".$result_data2->cir_code." ".$result_data2->mouza_pargona_code." ".$result_data2->lot_no;
//echo $mouza_pargona_code;

        $result_data3 = $this->db->query("Select * from privilege where priv_code = '$result_data2->priv'")->row();
        if ($result_data2->dis_enb_option == 'E') {
            $status = "Enabled";
        } else {
            $status = "Disabled";
        }
        if ($result_data1->status == 'O') {
            $type = "à¦¸à§?à¦¥à¦¾à¦¨à§€à¦¯à¦¼";
        } elseif ($result_data1->status == 'P') {
            $type = "à¦†à¦¨à§° à¦¶à§?à¦¹à¦²à¦¤";
        } else {
            $type = "à¦¸à¦‚à¦²à¦—à§?à¦¨";
        }
        $data['info'] = array(
            'name' => $name,
            'user_code' => $user_code,
            'role' => $result_data3->priv_desc,
            'role_code' => $result_data2->priv,
            'status' => $status,
            'status_code' => $result_data2->dis_enb_option,
            'designation' => $designation,
            'designation_code' => $desig_code,
            'joining_date' => $joining_date,
            'relese_date' => $relese_date,
            'user_name' => $result_data2->use_name,
            'dist_name' => $dist_name,
            'dist_code' => $result_data2->dist_code,
            'subdiv_name' => $sub_div_name,
            'subdiv_code' => $result_data2->subdiv_code,
            'cir_name' => $cir_name,
            'cir_code' => $result_data2->cir_code,
            'mouza_pargona_name' => $mouza_pargona_code,
            'mouza_pargona_code' => $result_data2->mouza_pargona_code,
            'lot_no' => $lot_no,
            'lot_no_code' => $result_data2->lot_no,
            'type' => $type,
            'type_code' => $result_data1->status,
            'sk_name' => $sk_name,
            'sk_code' => $sk_code,
            'phone_no' => $phone_no,
            'hashed_password_old' => $hashed_password_old
        );
//var_dump($data);

        $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = 'adm' OR priv_code = 'mut' order by priv_code")->result();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
//var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/edit_accounts', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/edit_accounts';
        $this->load->view('layouts/main',$data);
    }

    public function co_edit_account() {
        //var_dump($this->session->all_userdata());
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $q = "select count(*) as c from users where user_code='$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
        $c = $this->db->query($q)->row()->c;
        if ($c == 0) {
            $result_data1 = $this->db->query("Select * from lm_code where lm_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM' ")->row();
            //echo $result_data1->corres_sk_code;

            if ((substr($result_data1->corres_sk_code, 0, 2) === 'SK')) {
                $result_data5 = $this->db->query("Select * from users where user_code = '$result_data1->corres_sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $sk_name = $result_data5->username;
                $sk_code = $result_data5->user_code;
            } else {
                $sk_name = '';
                $sk_code = '';
            }

            $designation = $result_data4->user_desig_as;
            $name = $result_data1->lm_name;
            $joining_date = date('d-m-Y', strtotime($result_data1->dt_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->dt_to));
            $desig_code = 'LM';
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        } else {
            $result_data1 = $this->db->query("Select * from users where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
//echo "Select * from users where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data1->user_desig_code' ")->row();
//var_dump ($result_data4);
            if (empty($result_data4)) {
                $designation = 'Admin';
            } else {
                $designation = $result_data4->user_desig_as;
            }
            $name = $result_data1->username;
            $joining_date = date('d-m-Y', strtotime($result_data1->date_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->date_to));
            $sk_name = "00";
            $sk_code = "00";
            $desig_code = $result_data1->user_desig_code;
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        }

        $dist_name = $this->utilityclass->getDistrictName($result_data2->dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($result_data2->dist_code, $result_data2->subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code);
        $lot_no_name = $this->utilityclass->getLotName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code, $result_data2->lot_no);

        $result_data3 = $this->db->query("Select * from privilege where priv_code = '$result_data2->priv'")->row();
        if ($result_data2->dis_enb_option == 'E') {
            $status = "Enabled";
        } else {
            $status = "Disabled";
        }
        if ($result_data1->status == 'O') {
            $type = "à¦¸à§?à¦¥à¦¾à¦¨à§€à¦¯à¦¼";
        } elseif ($result_data1->status == 'P') {
            $type = "à¦†à¦¨à§° à¦¶à§?à¦¹à¦²à¦¤";
        } else {
            $type = "à¦¸à¦‚à¦²à¦—à§?à¦¨";
        }
        $data['info'] = array(
            'name' => $name,
            'user_code' => $user_code,
            'role' => $result_data3->priv_desc,
            'role_code' => $result_data2->priv,
            'status' => $status,
            'status_code' => $result_data2->dis_enb_option,
            'designation' => $designation,
            'designation_code' => $desig_code,
            'joining_date' => $joining_date,
            'relese_date' => $relese_date,
            'user_name' => $result_data2->use_name,
            'dist_name' => $dist_name,
            'dist_code' => $result_data2->dist_code,
            'subdiv_name' => $sub_div_name,
            'subdiv_code' => $result_data2->subdiv_code,
            'cir_name' => $cir_name,
            'cir_code' => $result_data2->cir_code,
            'mouza_pargona_name' => $mouza_pargona_code,
            'mouza_pargona_code' => $result_data2->mouza_pargona_code,
            'lot_no' => $lot_no_name,
            'lot_no_code' => $result_data2->lot_no,
            'type' => $type,
            'type_code' => $result_data1->status,
            'sk_name' => $sk_name,
            'sk_code' => $sk_code,
            'phone_no' => $phone_no,
            'hashed_password_old' => $hashed_password_old
        );
        //var_dump($data);

        $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = 'adm' OR priv_code = 'mut' order by priv_code")->result();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/co_edit_account', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/co_edit_account';
        $this->load->view('layouts/main',$data);
    }

    public function co_update_account() {

        $name = $this->input->post('name');
        $role = trim($this->input->post('role'), " ");
        $status = $this->input->post('status');
        $user_desig_code = trim($this->input->post('designation'), " ");
        $type = $this->input->post('type');
        $date_of_joining = $this->input->post('date_of_joining');
        $date_o_j = date('Y-m-d', strtotime($date_of_joining));
        $date_of_relese = $this->input->post('date_of_relese');
        $date_o_r = date('Y-m-d', strtotime($date_of_relese));
        $user_name = $this->input->post('user_name');
        $new_password = $this->input->post('new_pass');
        $enc_password =$this->utilityclass->encryptData($new_password);
        $hashed_password = $str = do_hash($new_password);
        $user_code_id = $this->input->post('user_id');
        $test = array(
            'user_code' => $this->input->post('user_id'),
            'name' => $this->input->post('name'),
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status'),
            'designation' => $this->input->post('designation'),
            'type' => $this->input->post('type'),
            'dist_code' => $this->input->post('dist_code'),
            'subdiv_code' => $this->input->post('subdiv_code'),
            'circle_code' => $this->input->post('circle_code'),
            'mouza_pargona_code' => $this->input->post('mouza_code'),
            'lot_no' => $this->input->post('lot_no'),
            'sk_code' => $this->input->post('sk_name'),
            'date_of_joining' => $this->input->post('date_of_joining'),
            'date_o_j' => date('Y-m-d', strtotime($date_of_joining)),
            'date_of_relese' => $this->input->post('date_of_relese'),
            'date_o_r' => date('Y-m-d', strtotime($date_of_relese)),
            'user_name' => $this->input->post('user_name'),
            'new_password' => $this->input->post('new_pass'),
            'dist_code_new' => $this->input->post('dist_code_new'),
            'subdiv_code_new' => $this->input->post('subdiv_code_new'),
            'circle_code_new' => $this->input->post('circle_code_new'),
            'mouza_pargona_code_new' => $this->input->post('mouza_code_new'),
            'lot_no_new' => $this->input->post('lot_no_new'),
            'sk_code_new' => $this->input->post('sk_name_new'),
        );
        if ($test['dist_code_new'] == '0') {
//echo "purona";
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            if ($mouza_pargona_code == null) {
                $mouza_pargona_code = '00';
            }
            $lot_no = $this->input->post('lot_no');
            if ($lot_no == null) {
                $lot_no = '00';
            }
            $sk_code = $this->input->post('sk_name');
            if ($user_desig_code != 'LM') {
                $users = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'username' => $name,
                    'user_code' => $user_code_id,
                    'user_desig_code' => $user_desig_code,
                    'status' => $type,
                    'date_from' => $date_o_j,
                    'date_to' => $date_o_r
                );
//var_dump($users);
                $update_user = "update users set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', username = '$name', user_desig_code = '$user_desig_code',"
                    . " status = '$type'  where user_code='$user_code_id'  ";
                $this->db->query($update_user); //*********************

                $loginuser_table = array(
                    'use_name' => $user_name,
                    'user_code' => $user_code_id,
                    'priv' => $role,
                    'date_of_creation' => date('Y-m-d'),
                    'dis_enb_option' => $status,
                    'first_login' => 'Y',
                    //'activity' => ' ',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no
                );
//var_dump($loginuser_table);
                $update_loginuser = "update loginuser_table set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no', use_name = '$user_name', priv = '$role', date_of_creation = '" . $loginuser_table['date_of_creation'] . "', "
                    . "dis_enb_option = '$status', prev_password1 = '$enc_password', password = '$hashed_password' where user_code='$user_code_id'  ";
                $this->db->query($update_loginuser); //*********************
            } else {
                $lm_code = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'lm_name' => $name,
                    'lm_code' => $user_code_id,
                    'status' => $type,
                    'corres_sk_code' => $sk_code,
                    'dt_from' => $date_o_j,
                    'dt_to' => $date_o_r
                );
//var_dump($lm_code);
                $update_lm = "update lm_code set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no'  lm_name = '$name', status = '$type', "
                    . "corres_sk_code = '$sk_code' where lm_code='$user_code_id'  ";
                $this->db->query($update_lm); //*********************

                $loginuser_table = array(
                    'use_name' => $user_name,
                    'user_code' => $user_code_id,
                    'priv' => $role,
                    'date_of_creation' => date('Y-m-d'),
                    'dis_enb_option' => $status,
                    'first_login' => 'Y',
                    'activity' => ' ',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no
                );
//var_dump($loginuser_table);
                $update_loginuser = "update loginuser_table set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no', use_name = '$user_name', priv = '$role', date_of_creation = '" . $loginuser_table['date_of_creation'] . "', "
                    . "dis_enb_option = '$status',first_login='N', prev_password1 = '$enc_password', password = '$hashed_password' where user_code='$user_code_id' dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no'";
                $this->db->query($update_loginuser); //*********************
            }
        } else {
//echo "notun";
            $dist_code = $this->input->post('dist_code_new');
            $subdiv_code = $this->input->post('subdiv_code_new');
            $circle_code = $this->input->post('circle_code_new');
            $mouza_pargona_code = $this->input->post('mouza_code_new');
            $mouza_pargona_code = $this->input->post('mouza_code');
            if ($mouza_pargona_code == null) {
                $mouza_pargona_code = '00';
            }
            $lot_no = $this->input->post('lot_no_new');
            if ($lot_no == null) {
                $lot_no = '00';
            }
            $sk_code = $this->input->post('sk_name_new');

            if ($user_desig_code != 'LM') {
                $user_code = $this->db->query("select max(user_code) as user_code from users where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and user_desig_code = '$user_desig_code' and user_code is not null limit 1")->row()->user_code;
                if ($user_code == null) {
                    $user_code = $user_desig_code . "1";
                } else {
                    // if ($user_desig_code == 'AST') {
                    //     $user_code = explode('AS', $user_code);
                    //     $user_code = $user_code['1'];
                    //     $user_code += 1;
                    //     $user_code = "AS" . $user_code;
                    // } else {
                        $user_code = explode($user_desig_code, $user_code);
                        $user_code = $user_code['1'];
                        $user_code += 1;
                        $user_code = $user_desig_code . $user_code;
                    // }
                }
                $user_code_for_users = $user_code;
                $users = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'username' => $name,
                    'user_code' => $user_code_for_users,
                    'user_desig_code' => $user_desig_code,
                    'status' => $type,
                    'date_from' => $date_o_j,
                    'date_to' => $date_o_r
                );
//var_dump($users);
                $update_user = "update users set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', username = '$name', user_desig_code = '$user_desig_code',"
                    . " status = '$type', user_code = '$user_code_for_users'  where user_code='$user_code_id'  ";
                $this->db->query($update_user); //*********************

                $loginuser_table = array(
                    'use_name' => $user_name,
                    'user_code' => $user_code_for_users,
                    'priv' => $role,
                    'date_of_creation' => date('Y-m-d'),
                    'dis_enb_option' => $status,
                    'first_login' => 'Y',
                    //'activity' => ' ',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no
                );
//var_dump($loginuser_table);
                $update_loginuser = "update loginuser_table set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no', use_name = '$user_name', priv = '$role', date_of_creation = '" . $loginuser_table['date_of_creation'] . "', "
                    . "dis_enb_option = '$status',first_login='N', user_code = '$user_code_for_users', prev_password1 = '$enc_password', password = '$hashed_password' where user_code='$user_code_id'  ";
                $this->db->query($update_loginuser); //*********************
            } else {
                $lm_code = $this->db->query("select max(lm_code) as lm_code from lm_code where dist_code = '$dist_code' "
                    . "and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' ")->row()->lm_code;
                if ($lm_code == null) {
                    $lm_code = "M1";
                } else {
                    $lm_code = explode('M', $lm_code);
                    $lm_code = $lm_code['1'];
                    $lm_code += 1;
                    $lm_code = "M" . $lm_code;
                }
                $user_code_for_lm = $lm_code;
                $lm_code = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'lm_name' => $name,
                    'lm_code' => $user_code_for_lm,
                    'status' => $type,
                    'corres_sk_code' => $sk_code,
                    'dt_from' => $date_o_j,
                    'dt_to' => $date_o_r
                );
//var_dump($lm_code);
                $delete_user = "Delete from users where user_code = '$user_code_id'";
                $this->db->query($delete_user); //*********************
                $this->db->insert('lm_code', $lm_code);

                $loginuser_table = array(
                    'use_name' => $user_name,
                    'user_code' => $user_code_for_lm,
                    'priv' => $role,
                    'date_of_creation' => date('Y-m-d'),
                    'dis_enb_option' => $status,
                    'first_login' => 'Y',
                    'activity' => ' ',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no
                );
//var_dump($loginuser_table);
                $update_loginuser = "update loginuser_table set dist_code = '$dist_code', subdiv_code = '$subdiv_code', cir_code = '$circle_code', "
                    . "mouza_pargona_code = '$mouza_pargona_code', lot_no = '$lot_no', use_name = '$user_name', priv = '$role', date_of_creation = '" . $loginuser_table['date_of_creation'] . "', "
                    . "dis_enb_option = '$status', first_login='N',user_code = '$user_code_for_lm', prev_password1 = '$enc_password', password = '$hashed_password' where user_code='$user_code_id'  ";
                $this->db->query($update_loginuser); //*********************
            }
        }
        $this->session->set_flashdata('message', "User Detail has been Successfully Updated.");
        redirect(base_url() . "index.php/home");
//redirect(base_url() . "index.php/Login/resetPassword");
    }

    public function update_location() {
        $user_code_id = $this->input->get('user_id');
        $dist_code = $this->input->get('dist_code_new');
        $subdiv_code = $this->input->get('subdiv_code_new');
        $cir_code = $this->input->get('circle_code_new');
        $mouza_pargona_code = $this->input->get('mouza_code_new');
        $lot_no = $this->input->get('lot_no_new');
        $sk_name_new = $this->input->get('sk_name_new');

        $update_lm = "update lm_code set corres_sk_code = '$sk_name_new' where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and lm_code='$user_code_id'";
        echo $update_lm;
        $this->db->query($update_lm); //*********************
        $this->session->set_flashdata('message', "Thank you. User Location Updated Successfully.");
        redirect(base_url() . "index.php/home");
    }

    public function update_account() {
        if(RESET_PASS_ENABLED == 1){
            //var_dump($_POST);
            $this->load->helper('security');
            //var_dump($this->session->all_userdata());
            $user_code_id = $this->input->post('user_id');
            $dist_code = $this->input->post('dist_code_new');
            $subdiv_code = $this->input->post('subdiv_code_new');
            $cir_code = $this->input->post('circle_code_new');
            $mouza_pargona_code = $this->input->post('mouza_code_new');
            $lot_no = $this->input->post('lot_no_new');
            date_default_timezone_set('asia/Kolkata');
            $date = date('Y-m-d H:i:s');

            $name = $this->input->post('name');
            $phone_no = $this->input->post('phone_no');
            $phone_no = $this->input->post('username');
            $password = $this->input->post('new_pass');
            $enc_password = $this->utilityclass->encryptData($password);
            $new_password = do_hash($this->input->post('new_pass'));
            $update_loginuser = "update loginuser_table set password='$new_password', prev_password1 = '$enc_password',"
                . "date_password_changed='$date', first_login = '' where user_code='$user_code_id' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and"
                . " cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";
            $this->db->query($update_loginuser); //*********************

            ////central_auth/////////
            $this->dbb=$this->load->database('auth', TRUE);
            $new_password=md5($this->input->post('new_pass'));


            $query2 = "update central_auth set password='$new_password', prev_password1 = '$enc_password',"
                . "password_change='$date' where "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and dhar_code = '$user_code_id'";

            $this->dbb->query($query2);

            $this->session->set_flashdata('message', "Thank you. Password Changed Successfully.");
            redirect(base_url() . "index.php/home");
        }
        else
        {
            $this->session->set_flashdata('message', "PASSWORD UPDATE MECHANISM UNDER MAINTENANCE...PLEASE WAIT SOMETIME..");
            redirect(base_url() . "index.php/home");
        }
    }

    public function update_account1() {
        //var_dump($_GET);
        $this->load->helper('security');
        //var_dump($this->session->all_userdata());
        $user_code_id = $this->input->get('user_id');
        $dist_code = $this->input->get('dist_code_new');
        $subdiv_code = $this->input->get('subdiv_code_new');
        $cir_code = $this->input->get('circle_code_new');
        $mouza_pargona_code = $this->input->get('mouza_code_new');
        $lot_no = $this->input->get('lot_no_new');
        $designation_code = $this->input->get('user_desig');

        // $name = $this->input->get('name');
        $phone_no = $this->input->get('phone_no');
        $use_name = $this->input->get('username');

        $this->dbb=$this->load->database('auth',true);
        $this->db->trans_begin();
        $this->dbb->trans_begin();
        if ($designation_code == 'LM') {
            $update_users = "update lm_code set phone_no='$phone_no' where lm_code='$user_code_id' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and"
                . " cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
            // echo $update_users;
            // die;
            $this->db->query($update_users); //*********************
        } else {
            $update_users = "update users set phone_no='$phone_no' where user_code='$user_code_id' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and"
                . " cir_code = '$cir_code'";
            //echo $update_users;
            $this->db->query($update_users); //*********************
        }

        $centralData="Update central_auth set mobile='$phone_no' where dhar_code='$user_code_id' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->dbb->query($centralData);
        log_message('error','#ERROR:09541 update Successfully in Dharitree...');

        if($this->dbb->affected_rows()==1 && $this->db->affected_rows()==1){

            if(ENABLE_MOUZADAR_MOBILE_UPDATE == 1)
            {
                log_message('error','#ERROR:09542 Inserting for API and going to update in department End...');

                $sql2 = "Select * from loginuser_table where use_name = '$use_name' and user_code = '$user_code_id' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                $loginData=$this->db->query($sql2)->row_array();
                if($loginData['use_name'] == null || !isset($loginData['use_name']))
                {
                    log_message('error','#ERROR:0954 User Details updation failed...');
                    $this->session->set_flashdata('message', "#ERROR:0954 User Details updation failed...");
                    $this->dbb->trans_rollback();
                    $this->db->trans_rollback();
                    redirect(base_url() . "index.php/home");
                }
                log_message('error','Designation==========='.$designation_code);
                if($designation_code=='MOU')
                {

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."updateMobileNoDetailsMouzadar",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $loginData['use_name'],
                            'dist_code' => $dist_code,
                            'mobile_no' => $phone_no,
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"update_account1====API==mouzadar update:".json_encode($response));
                 
                    if($httpcode == 200){
                        $response_obj = json_decode($response);
                        if($response_obj->result == "N"){
                            $this->db->trans_rollback();
                            $this->dbb->trans_rollback();
                            $this->session->set_flashdata('message', "#ERROR:2402 Department end not updated...");
                            log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."updateMobileNoDetailsMouzadar");
                            redirect(base_url() . "index.php/home");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."updateMobileNoDetailsMouzadar");
                        $this->session->set_flashdata('message', "#ERROR:24012 Department end not updated...");
                        // show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
            }

            
            $this->session->set_flashdata('message', "User Details has been Updated Successfully...");
            $this->dbb->trans_commit();
            $this->db->trans_commit();
        }else
        {
            $this->session->set_flashdata('message', "#ERROR:2341 User Details updation failed...");
            $this->dbb->trans_rollback();
            $this->db->trans_rollback();
        }
        redirect(base_url() . "index.php/home");

    }

    public function delete_account() {
        $user_code = $this->input->get('user_code');

        $update_loginuser = "update loginuser_table set dis_enb_option = 'D' where user_code='$user_code'  ";
//$this->db->query($update_loginuser); //*********************
//redirect(base_url() . "index.php/Login/resetPassword");
    }

    public function master_code() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/master_code');
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/master_code';
        $this->load->view('layouts/main',$data);
    }

    public function master_code_entry() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/master_code_entry');
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/master_code_entry';
        $this->load->view('layouts/main',$data);
    }

    public function master_code_edit() {
        $table_result = $this->db->query("select * from meta_chitha_master order by table_no asc")->result();
        $data['table_result'] = $table_result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/master_code_edit', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/master_code_edit';
        $this->load->view('layouts/main',$data);
    }

    public function LClassTypePlug() {
        $LRCTables = $_REQUEST['LRCTables'];
        $data['datas'] = array(
            'table_name' => $LRCTables
        );

        if ($LRCTables == "patta_code") {
            $master_result = $this->db->query("select * from patta_code order by patta_code asc")->result();
            $data['master_result'] = $master_result;

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/initialization/patta_code_entry_form', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'initialization/patta_code_entry_form';
            $this->load->view('layouts/main',$data);
        } else {
            $fiel_name = "select column_name from information_schema.columns where table_name='$LRCTables'";
            $result = $this->db->query($fiel_name)->result();
            $fileds = array();
            foreach ($result AS $r) {
                $fileds[].=$r->column_name;
            }
            $code = $fileds['0'];
            $type = $fileds['1'];

            $master_result = $this->db->query("select $code as code, $type as type from $LRCTables order by $code asc")->result();
            $data['master_result'] = $master_result;
//var_dump($master_result);
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/initialization/other_code_entry_form', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'initialization/other_code_entry_form';
            $this->load->view('layouts/main',$data);
        }
    }

    public function afterEntry() {
        $table_name = $this->input->post('table_name');
        $code = $this->input->post('Code');
        $type = $this->input->post('Type');
        $data['datas'] = array(
            'table_name' => $table_name
        );
        $fiel_name = "select column_name from information_schema.columns where table_name='$table_name'";
        $result = $this->db->query($fiel_name)->result();
//var_dump($result);
        $fileds = array();
        foreach ($result AS $r) {
            $fileds[].=$r->column_name;
        }
        $coloum_code = $fileds['0'];
        $coloum_type = $fileds['1'];
        $check = $this->db->query("Select $coloum_code from $table_name where $coloum_code = '$code'")->row();
        $count = count($check);
//echo $count;
        if ($count != '0') {
            echo "<script>javascript:alert('Code Already Exists'); window.location = '" . base_url() . "index.php/initialization/LClassTypePlug?LRCTables=" . $table_name . "'</script>";
        } else {
            $table_insert = array(
                $fileds['0'] => $code,
                $fileds['1'] => $type
            );
            $this->db->insert($table_name, $table_insert);
            // $this->load->view('../views/header');
            // $this->load->view('../views/initialization/test', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'initialization/test';
            $this->load->view('layouts/main',$data);
        }
    }

    public function afterEntry_pattacode() {
        $table_name = $this->input->post('table_name');
        $code = $this->input->post('type_code');
        $type = $this->input->post('patta_type');
        $name = $this->input->post('mutation');
        $conversion = $this->input->post('conversion');
        $jamabandi = $this->input->post('jamabandi');
        $data['datas'] = array(
            'table_name' => $table_name
        );
        $fiel_name = "select column_name from information_schema.columns where table_name='$table_name'";
        $result = $this->db->query($fiel_name)->result();
//var_dump($result);
        $fileds = array();
        foreach ($result AS $r) {
            $fileds[].=$r->column_name;
        }
        $coloum_code = $fileds['0'];
        $coloum_type = $fileds['1'];
        $check = $this->db->query("Select $coloum_code from $table_name where $coloum_code = '$code'")->row();
        $count = count($check);
//echo $count;
        if ($count != '0') {
            echo "<script>javascript:alert('Code Already Exists'); window.location = '" . base_url() . "index.php/initialization/LClassTypePlug?LRCTables=" . $table_name . "'</script>";
        } else {
            $table_insert = array(
                $fileds['0'] => $code,
                $fileds['1'] => $type,
                $fileds['2'] => $name,
                $fileds['3'] => $conversion,
                $fileds['4'] => $jamabandi
            );
            $this->db->insert($table_name, $table_insert);
            // $this->load->view('../views/header');
            // $this->load->view('../views/initialization/test', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'initialization/test';
            $this->load->view('layouts/main',$data);
        }
    }

    public function EditCodePlug() {
        $LRCTables = $_REQUEST['LRCTables'];
        $data['datas'] = array(
            'table_name' => $LRCTables
        );
        $fiel_name = "select column_name from information_schema.columns where table_name='$LRCTables'";
        $result = $this->db->query($fiel_name)->result();
        $fileds = array();
        foreach ($result AS $r) {
            $fileds[].=$r->column_name;
        }
        $code = $fileds['0'];
        $type = $fileds['1'];

        $master_result = $this->db->query("select $code as code, $type as type from $LRCTables order by $code asc")->result();
        $data['master_result'] = $master_result;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/other_code_edit_form', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/other_code_edit_form';
        $this->load->view('layouts/main',$data);
    }

    public function afterEdit() {
        $table_name = $this->input->post('table_name');
        $code = $this->input->post('Code');
        $type = $this->input->post('Type');
        $data['datas'] = array(
            'table_name' => $table_name
        );
        $fiel_name = "select column_name from information_schema.columns where table_name='$table_name'";
        $result = $this->db->query($fiel_name)->result();
//var_dump($result);
        $fileds = array();
        foreach ($result AS $r) {
            $fileds[].=$r->column_name;
        }
//var_dump($fileds);
        $code_col = $fileds['0'];
        $type_col = $fileds['1'];

        $table_update = "Update $table_name set $type_col = '$type' where $code_col = '$code'";
//echo "Update $table_name set $type_col = '$type' where $code_col = '$code'";
        $this->db->query($table_update); //*********************
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/test1', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/test1';
        $this->load->view('layouts/main',$data);
    }

    public function afterEdit_pattacode() {
        $table_name = $this->input->post('table_name');
        $code = $this->input->post('type_code');
        $type = $this->input->post('patta_type');
        $name = $this->input->post('mutation');
        $conversion = $this->input->post('conversion');
        $jamabandi = $this->input->post('jamabandi');

        $fiel_name = "select column_name from information_schema.columns where table_name='$table_name'";
        $result = $this->db->query($fiel_name)->result();
//var_dump($result);
        $fileds = array();
        foreach ($result AS $r) {
            $fileds[].=$r->column_name;
        }
//var_dump($fileds);
//echo $fileds['0'];
        $table_insert = array(
            $fileds['0'] => $code,
            $fileds['1'] => $type,
            $fileds['2'] => $name,
            $fileds['3'] => $conversion,
            $fileds['4'] => $jamabandi
        );
        $this->db->insert($table_name, $table_insert);
        exit();
    }

    public function master_code_view() {
        $table_result = $this->db->query("select * from meta_chitha_master order by table_no asc")->result();
        $data['table_result'] = $table_result;
//var_dump($table_result);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/master_code_view', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/master_code_view';
        $this->load->view('layouts/main',$data);
    }

    public function view_table() {
       echo $LRCTables = $this->input->post('LRCTables');
        $data['table_name'] = $LRCTables;
        $table_result = $this->db->query("select * from $LRCTables")->result();
        $data['table_result'] = $table_result;
//var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        if ($LRCTables == 'lm_code') {
            //$this->load->view('../views/initialization/viewMasterLM', $data);

            $data['_view'] = 'initialization/viewMasterLM';
            $this->load->view('layouts/main',$data);

        } elseif ($LRCTables == 'users') {
            //$this->load->view('../views/initialization/viewMasterUsers', $data);

            $data['_view'] = 'initialization/viewMasterUsers';
            $this->load->view('layouts/main',$data);
        } elseif ($LRCTables == 'cert_revenue_location') {
            //$this->load->view('../views/initialization/viewMasterRLoc', $data);

            $data['_view'] = 'initialization/viewMasterRLoc';
            $this->load->view('layouts/main',$data);
        } elseif ($LRCTables == 'patta_code') {

            $data['_view'] = 'initialization/viewpatta_code';
            $this->load->view('layouts/main',$data);
            //$this->load->view('../views/initialization/viewpatta_code', $data);
        } elseif ($LRCTables == 'landclass_code') {
            $master_result = $this->db->query("select class_code as code, land_type as type from landclass_code order by class_code asc")->result();
            $data['master_result'] = $master_result;
            $data['_view'] = 'initialization/view_master';
            $this->load->view('layouts/main',$data);
            //$this->load->view('../views/initialization/viewpatta_code', $data);
        }  else {
            $fiel_name = "select column_name from information_schema.columns where table_name='$LRCTables'"; // order by attnum asc";
            $result = $this->db->query($fiel_name)->result();
            $fileds = array();
//var_dump($result);
            foreach ($result AS $r) {
                $fileds[].=$r->column_name;
            }
            $code = $fileds['0'];
            $type = $fileds['1'];
//$code = $fileds['1'];
//$type = $fileds['0'];

            $master_result = $this->db->query("select $code as code, $type as type from $LRCTables order by $code asc")->result();
            $data['master_result'] = $master_result;
            //$this->load->view('../views/initialization/view_master', $data);
            $data['_view'] = 'initialization/view_master';
            $this->load->view('layouts/main',$data);
        }
        // $this->load->view('../views/footer');
    }

    public function location() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
//echo $dist_code."-".$subdiv_code."-".$cir_code;
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);

        $data = $this->mutationmodel->getDistricts();
        $data['names'] = $data;

        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/location', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/location';
        $this->load->view('layouts/main',$data);
    }

    public function add_district($dist_name, $code, $subdiv_name, $circ_code, $mouza_code, $lot_code, $village_code) {
        $dist_name = rawurldecode($dist_name);
        $sql = "Select exists(select * from location where dist_code = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $code,
            'subdiv_code' => $subdiv_name,
            'cir_code' => $circ_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_code,
            'vill_townprt_code' => $village_code,
            'loc_name' => $dist_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $dist_name . " Added As District";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "District Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function add_subdiv($dist_c, $subdiv_name, $code, $circ_code, $mouza_code, $lot_code, $village_code) {
        $subdiv_name = rawurldecode($subdiv_name);
        $sql = "Select exists(select * from location where dist_code = '$dist_c' and subdiv_code = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $dist_c,
            'subdiv_code' => $code,
            'cir_code' => $circ_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_code,
            'vill_townprt_code' => $village_code,
            'loc_name' => $subdiv_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $subdiv_name . " Added As Sub Division";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "Sub Division Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function add_circle($dist_c, $subdiv_code, $circ_name, $code, $mouza_code, $lot_code, $village_code) {
        $circ_name = rawurldecode($circ_name);
        $sql = "Select exists(select * from location where dist_code = '$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $dist_c,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_code,
            'vill_townprt_code' => $village_code,
            'loc_name' => $circ_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $circ_name . " Added As Circle";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "Circle Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function add_mouza($dist_c, $subdiv_code, $circ_code, $mouza_name, $code, $lot_code, $village_code) {
        $mouza_name = rawurldecode($mouza_name);
        $sql = "Select exists(select * from location where dist_code = '$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$circ_code' and mouza_pargona_code = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $dist_c,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circ_code,
            'mouza_pargona_code' => $code,
            'lot_no' => $lot_code,
            'vill_townprt_code' => $village_code,
            'loc_name' => $mouza_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $mouza_name . " Added As Mouza Pargona";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "Mouza Pargona Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function add_lot($dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_name, $code, $village_code) {
        $lot_name = rawurldecode($lot_name);
        $sql = "Select exists(select * from location where dist_code = '$dist_c' and subdiv_code = '$subdiv_code' "
            . "and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $dist_c,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circ_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $code,
            'vill_townprt_code' => $village_code,
            'loc_name' => $lot_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $lot_name . " Added As Lot";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "Lot Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function add_village($dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_code, $village_name, $code) {
        $village_name = rawurldecode($village_name);
        $sql = "Select exists(select * from location where dist_code = '$dist_c' and subdiv_code = '$subdiv_code' "
            . "and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_code' and vill_townprt_code = '$code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'dist_code' => $dist_c,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circ_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_code,
            'vill_townprt_code' => $code,
            'loc_name' => $village_name
        );
        if ($sql->exists == 'f') {
            $this->db->insert('location', $insert);
            $msg = $village_name . " Added As Town / Village";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "Town / Village Code Already Exists";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function district_delete() {
        $dist_code = $this->input->get('dist_code');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function subdivision_delete() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('Subdiv_code');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function circle_delete() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('Subdiv_code');
        $Cir_code = $this->input->get('Cir_code');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$Cir_code' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function mouza_delete() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('Subdiv_code');
        $Cir_code = $this->input->get('Cir_code');
        $mouza_pargona_code = $this->input->get('Mouza_Pargona_code');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$Cir_code' and mouza_pargona_code = '$mouza_pargona_code' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function lot_delete() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('Subdiv_code');
        $Cir_code = $this->input->get('Cir_code');
        $mouza_pargona_code = $this->input->get('Mouza_Pargona_code');
        $Lot_no = $this->input->get('Lot_no');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$Cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$Lot_no' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function village_delete() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('Subdiv_code');
        $Cir_code = $this->input->get('Cir_code');
        $mouza_pargona_code = $this->input->get('Mouza_Pargona_code');
        $Lot_no = $this->input->get('Lot_no');
        $Vill_townprt_code = $this->input->get('Vill_townprt_code');

        $sql = $this->db->query("DELETE FROM location WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$Cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$Lot_no' and vill_townprt_code = '$Vill_townprt_code' ");
        redirect(base_url() . "index.php/initialization/location");
    }

    public function modify_district($dist_name, $code, $subdiv_code, $circ_code, $mouza_code, $lot_code, $village_code) {
        $dist_name = rawurldecode($dist_name);
        $update_q = $this->db->query("update location set loc_name='$dist_name' where dist_code='$code' and subdiv_code = '$subdiv_code' and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_code' and vill_townprt_code = '$village_code' ");

        $msg = $dist_name . " Updated As District Name";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function modify_subdiv($dist_c, $subdiv_name, $code, $circ_code, $mouza_code, $lot_code, $village_code) {
        $subdiv_name = rawurldecode($subdiv_name);
        $update_q = $this->db->query("update location set loc_name='$subdiv_name' where dist_code='$dist_c' and subdiv_code = '$code' and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_code' and vill_townprt_code = '$village_code' ");

        $msg = $subdiv_name . " Updated As Sub Division Name";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function modify_circle($dist_c, $subdiv_code, $circ_name, $code, $mouza_code, $lot_code, $village_code) {
        $circ_name = rawurldecode($circ_name);
        $update_q = $this->db->query("update location set loc_name='$circ_name' where dist_code='$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_code' and vill_townprt_code = '$village_code' ");

        $msg = $circ_name . " Updated As Circle Name";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function modify_mouza($dist_c, $subdiv_code, $circ_code, $mouza_name, $code, $lot_code, $village_code) {
        $mouza_name = rawurldecode($mouza_name);
        $update_q = $this->db->query("update location set loc_name='$mouza_name' where dist_code='$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$circ_code' and mouza_pargona_code = '$code' and lot_no = '$lot_code' and vill_townprt_code = '$village_code' ");

        $msg = $mouza_name . " Updated As Mouza Pargona Name";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function modify_lot($dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_name, $code, $village_code) {
        $lot_name = rawurldecode($lot_name);
        $update_q = $this->db->query("update location set loc_name='$lot_name' where dist_code='$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$code' and vill_townprt_code = '$village_code' ");

        $msg = $lot_name . " Updated As Lot Number";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function modify_village($dist_c, $subdiv_code, $circ_code, $mouza_code, $lot_code, $village_name, $code) {
        $village_name = rawurldecode($village_name);
        $update_q = $this->db->query("update location set loc_name='$village_name' where dist_code='$dist_c' and subdiv_code = '$subdiv_code' and cir_code = '$circ_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_code' and vill_townprt_code = '$code' ");
        $village_name = str_replace("%20", " ", $village_name);
        $msg = $village_name . " Updated As Village / Town Name";
        $json = array();
        $json[] = array('msg' => $msg);
        echo json_encode($json);
    }

    public function view_location_codes() {
        $user_desig = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $table_result = $this->db->query("select * from location where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ORDER BY Dist_code, Subdiv_code, Cir_code, Mouza_Pargona_code, Lot_no, Vill_townprt_code")->result();
//var_dump($table_result);

        foreach ($table_result as $result) {
            if (($result->dist_code <> "00") && ($result->subdiv_code == "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "District";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Subdivision";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Circle";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Mouza Pargona";
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no <> "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Lot";
            } else {
                $loc_type = "Village / Town";
            }
            $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code' and lot_no = '$result->lot_no' and vill_townprt_code = '$result->vill_townprt_code' ")->row()->dag;
//var_dump($total_dag);
            $result_data[] = array(
                'dist_code' => $result->dist_code,
                'subdiv_code' => $result->subdiv_code,
                'cir_code' => $result->cir_code,
                'mouza_pargona_code' => $result->mouza_pargona_code,
                'lot_no' => $result->lot_no,
                'vill_townprt_code' => $result->vill_townprt_code,
                'loc_name' => $result->loc_name,
                'loc_type' => $loc_type,
                'dags' => $total_dag
            );
//var_dump($result_data);
        }
        $data['table_result'] = $result_data;
//var_dump($table_result);
        $districts = $this->db->query("select Distinct dist_code as district from location")->result();
        $totaldags = '0';
        $totallot = '0';
        $totalmouza = '0';
        $totalcir = '0';
        $totalsubdiv = '0';
        $totalvillage = '0';
        foreach ($districts as $ds) {
            $dags = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$ds->district' ")->row()->dag;
            $lot = $this->db->query("SELECT count(*) as lot from location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code = '00000'")->row()->lot;
            $mouza = $this->db->query("select count(dist_code) as mouza from location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->mouza;
            $cir = $this->db->query("select count(dist_code) as cir from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code<>'00' and mouza_pargona_code='00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->cir;
            $subdiv = $this->db->query("select count(dist_code) as subdiv from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000' ")->row()->subdiv;
            $village = $this->db->query("select count(dist_code) as village from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code <> '00' and mouza_pargona_code <> '00' and lot_no <> '00' and vill_townprt_code <> '00000' ")->row()->village;


            $totaldags = $totaldags + $dags;
            $totallot = $totallot + $lot;
            $totalmouza = $totalmouza + $mouza;
            $totalcir = $totalcir + $cir;
            $totalsubdiv = $totalsubdiv + $subdiv;
            $totalvillage = $totalvillage + $village;
        }


        $data['totalresult'] = array(
            'total_dags' => $totaldags,
            'total_subdivs' => $totalsubdiv,
            'totalcir' => $totalcir,
            'totalmouza' => $totalmouza,
            'totallot' => $totallot,
            'totalvillage' => $totalvillage,
            'usercode' => $user_desig
        );

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/view_location_codes', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/view_location_codes';
        $this->load->view('layouts/main',$data);

    }

    public function view_master_location_codes() {
        $user_desig = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $table_result = $this->db->query("select * from location where dist_code='$dist_code' ORDER BY Dist_code, Subdiv_code, Cir_code, Mouza_Pargona_code, Lot_no, Vill_townprt_code")->result();
//var_dump($table_result);

        foreach ($table_result as $result) {
            if (($result->dist_code <> "00") && ($result->subdiv_code == "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "District";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code'")->row()->dag;
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code == "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Subdivision";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code'")->row()->dag;
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code == "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Circle";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code'")->row()->dag;
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no == "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Mouza Pargona";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code'")->row()->dag;
            } elseif (($result->dist_code <> "00") && ($result->subdiv_code <> "00") && ($result->cir_code <> "00") && ($result->mouza_pargona_code <> "00") && ($result->lot_no <> "00") && ($result->vill_townprt_code == "00000")) {
                $loc_type = "Lot";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code' and lot_no = '$result->lot_no'")->row()->dag;
            } else {
                $loc_type = "Village / Town";
                $total_dag = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$result->dist_code' and subdiv_code = '$result->subdiv_code' and cir_code = '$result->cir_code' and mouza_pargona_code = '$result->mouza_pargona_code' and lot_no = '$result->lot_no' and vill_townprt_code = '$result->vill_townprt_code' ")->row()->dag;
            }

            $result_data[] = array(
                'dist_code' => $result->dist_code,
                'subdiv_code' => $result->subdiv_code,
                'cir_code' => $result->cir_code,
                'mouza_pargona_code' => $result->mouza_pargona_code,
                'lot_no' => $result->lot_no,
                'vill_townprt_code' => $result->vill_townprt_code,
                'loc_name' => $result->loc_name,
                'loc_type' => $loc_type,
                'dags' => $total_dag
            );
//var_dump($result_data);
        }
        $data['table_result'] = $result_data;
//var_dump($table_result);
        $districts = $this->db->query("select Distinct dist_code as district from location")->result();
        $totaldags = '0';
        $totallot = '0';
        $totalmouza = '0';
        $totalcir = '0';
        $totalsubdiv = '0';
        $totalvillage = '0';
        foreach ($districts as $ds) {
            $dags = $this->db->query("select count(dist_code) as dag from chitha_basic where dist_code='$ds->district' ")->row()->dag;
            $lot = $this->db->query("SELECT count(*) as lot from location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code = '00000'")->row()->lot;
            $mouza = $this->db->query("select count(dist_code) as mouza from location where Dist_code='$ds->district' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->mouza;
            $cir = $this->db->query("select count(dist_code) as cir from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code<>'00' and mouza_pargona_code='00' and lot_no = '00' and vill_townprt_code = '00000'")->row()->cir;
            $subdiv = $this->db->query("select count(dist_code) as subdiv from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000' ")->row()->subdiv;
            $village = $this->db->query("select count(dist_code) as village from location where Dist_code='$ds->district' and subdiv_code<>'00' and cir_code <> '00' and mouza_pargona_code <> '00' and lot_no <> '00' and vill_townprt_code <> '00000' ")->row()->village;


            $totaldags = $totaldags + $dags;
            $totallot = $totallot + $lot;
            $totalmouza = $totalmouza + $mouza;
            $totalcir = $totalcir + $cir;
            $totalsubdiv = $totalsubdiv + $subdiv;
            $totalvillage = $totalvillage + $village;
        }


        $data['totalresult'] = array(
            'total_dags' => $totaldags,
            'total_subdivs' => $totalsubdiv,
            'totalcir' => $totalcir,
            'totalmouza' => $totalmouza,
            'totallot' => $totallot,
            'totalvillage' => $totalvillage,
            'usercode' => $user_desig
        );

        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/initialization/view_master_location_codes', $data);
        $this->load->view('../views/footer');
    }

    public function disable_users() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');

        $date= date('Y-m-d H:i:s');
        //echo $dist_code;
        $this->db->trans_begin();
        $sql = "update loginuser_table set dis_enb_option='D' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);
        if($this->db->affected_rows()==1){
            $this->dbb=$this->load->database('auth',true);
            if($lot_no!='00')
            {
                $sql1="Select *,'LM' as user_desig_code from lm_code where lm_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";

                $sqlUsers = "update lm_code set dt_to='$date' where lm_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";
                $this->db->query($sqlUsers);
                if($this->db->affected_rows()!=1)
                {
                    $this->db->trans_rollback();
                    show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE003","401",$heading="Error-401");
                    return;
                }

            }
            else
            {
                $sql1="Select * from users where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";

                $sqlUsers = "update users set date_to='$date' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
                $this->db->query($sqlUsers);

                if($this->db->affected_rows()!=1)
                {
                    $this->db->trans_rollback();
                    show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE003","401",$heading="Error-401");
                    return;
                }

            }
            $usersArray=$this->db->query($sql1);
            //log_message('error',$this->db->last_query());
            if($usersArray->num_rows()==1)
            {
                $usersArrayData=$usersArray->row_array();
                $sql2 = "Select * from loginuser_table where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                $loginData=$this->db->query($sql2)->row_array();
                if($usersArrayData['user_desig_code']=='MOU' || $usersArrayData['user_desig_code']=='SDLC'){

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."enableDisableAccount",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $loginData['use_name'],
                            'is_enabled' => 'D',
                            'dist_code' => $dist_code,
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"APIfromBasundhara:".$response);
                    // log_message('error',"APIfromBasundhara:".json_encode(array(
                    //         'unique_user_id' => $dataRow['use_name'],
                    //         'password' => $make_password,
                    //     )));
                    if($httpcode == 200){
                        $response_obj = json_decode($response);
                        //var_dump($response_obj);
                        if($response_obj->result == "N"){
                            $this->db->trans_rollback();
                            $this->dbb->trans_rollback();
                            log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."enableDisableAccount");
                            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                            // show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."enableDisableAccount");
                        //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                        show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                        return;
                    }
                }
                ///////////Affective codes//////////////////
                $sqlAuthTable="Select * from central_auth where dhar_user='$loginData[use_name]' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";
                $authDataExist=$this->dbb->query($sqlAuthTable);
                if($authDataExist->num_rows() ==1)
                {
                    $this->dbb->trans_begin();
                    $centralData="Update central_auth set active_deactive='D' where dhar_user='$loginData[use_name]' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                    $this->dbb->query($centralData);
                    if($this->dbb->affected_rows()==1){
                        $this->dbb->trans_commit();
                        $this->db->trans_commit();
                    }
                }
                if($this->db->affected_rows()==1){
                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                    $this->dbb->trans_rollback();
                    show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                    return;
                }
                //$this->db->trans_commit();
            }
        }
        redirect(base_url() . "index.php/initialization/all_active_enabled_users_co");
    }

    public function enable_users() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        //echo $dist_code;
        $this->db->trans_begin();
        $sql = "update loginuser_table set dis_enb_option='E' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);
        //log_message('error',$this->db->last_query());
        if($this->db->affected_rows()==1){
            $this->dbb=$this->load->database('auth',true);
            $sql="Select * from loginuser_table where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
            $sql1="Select * from users where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $usersArray=$this->db->query($sql1);
            //log_message('error',$this->db->last_query());
            if($usersArray->num_rows()==1)
            {
                $usersArrayData=$usersArray->row_array();
                if($usersArrayData['user_desig_code']=='MOU' || $usersArrayData['user_desig_code']=='SDLC'){
                    $this->dbb->trans_begin();
                    $loginData=$this->db->query($sql)->row_array();

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."enableDisableAccount",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $loginData['use_name'],
                            'is_enabled' => 'E',
                            'dist_code'  => $dist_code
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"APIfromBasundhara:".$response);
                    // log_message('error',"APIfromBasundhara:".json_encode(array(
                    //         'unique_user_id' => $dataRow['use_name'],
                    //         'password' => $make_password,
                    //     )));
                    if($httpcode == 200){
                        $response_obj = json_decode($response);
                        if($response_obj->result == "N"){
                            $this->db->trans_rollback();
                            $this->dbb->trans_rollback();
                            log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."enableDisableAccount");
                            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                            show_error($response_obj->msg." ### Error Code #DISABLE002","401",$heading="Error-401");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        $this->db->trans_rollback();
                        $this->dbb->trans_rollback();
                        log_message("error", "#DISABLE002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."enableDisableAccount");
                        //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002");
                        show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                        return;
                    }
                }

                //$this->db->trans_commit();
            }
            ///////////Affective codes//////////////////
            $loginData=$this->db->query($sql)->row_array();
            $sqlAuthTable="Select * from central_auth where dhar_user='$loginData[use_name]' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";
            $authDataExist=$this->dbb->query($sqlAuthTable);
            if($authDataExist->num_rows() ==1)
            {
                $centralData="Update central_auth set active_deactive='E' where dhar_user='$loginData[use_name]' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
                $this->dbb->query($centralData);
                if($this->dbb->affected_rows()==1){
                    $this->dbb->trans_commit();
                    $this->db->trans_commit();
                }
            }
            if($this->db->affected_rows()==1){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
                $this->dbb->trans_rollback();
                show_error("Internal Server Error, Please Try Again Later..., Error Code #DISABLE002","401",$heading="Error-401");
                return;
            }
        }
        //*********************
        redirect(base_url() . "index.php/initialization/all_inactive_disabled_users_co");
    }

    public function disable_users_nic() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
//echo $dist_code;
        $sql = "update loginuser_table set dis_enb_option='D' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);  //*********************
        redirect(base_url() . "index.php/initialization/all_active_enabled_users_dio");
    }

    public function remove_users_nic() {
        $user_code = $this->input->get('use_name');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
//echo $dist_code;
        echo $sql = "Delete from loginuser_table where use_name = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);  //*********************
//redirect(base_url() . "index.php/initialization/all_inactive_disabled_users");
    }

    public function enable_users_nic() {
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
//echo $dist_code;
        $sql = "update loginuser_table set dis_enb_option='E' where user_code = '$user_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'";
        $this->db->query($sql);  //*********************
        redirect(base_url() . "index.php/initialization/all_inactive_disabled_users_dio");
    }


    public function getdohashedpassword($e) {
        $this->load->helper('security');
        $ee = rawurldecode($e);
        $result = do_hash($ee);
        echo json_encode($result);
    }

    public function firstloginpasswordchange() {
//var_dump($this->session->all_userdata());
//var_dump($this->input->POST());
        $this->load->helper('security');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        date_default_timezone_set('asia/Kolkata');
        $date = date('Y-m-d H:i:s');

        $use_name = $this->input->post('username');
        $oldpasswordhash = $this->input->post('oldpasswordhash');
        $oldpassword = $this->input->post('oldpassword');
        $new_pass = $this->input->post('new_pass');
        $enc_pass = $this->utilityclass->encryptData($new_pass);
        $newpasswordhashed = do_hash($new_pass);
        $re_type_pass = $this->input->post('re_type_pass');
        $user_id = $this->input->post('user_id');


        $update_loginuser = "update loginuser_table set use_name = '$use_name', password = '$newpasswordhashed', prev_password1 = '$enc_pass', "
            . "date_password_changed='$date', first_login = '' where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
            . "cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and user_code='$user_id'";
//echo $update_loginuser;
        $this->db->query($update_loginuser); //*********************
        $data = array(
            'activity' => '',
            'date_of_last_password_change' => $date,
        );
//$this->session->set_userdata($data);
        $this->session->set_flashdata('message', "Thank you. Password Changed Successfully.");
        redirect(base_url() . "index.php/home");
    }

    public function getvalidusername($newusername = null)
    {
        header('Content-Type: application/json'); // ensure JSON output
        $username = trim(rawurldecode($newusername));

        if (empty($username)) {
            echo json_encode(['exists' => 0, 'error' => 'Invalid username']);
            return;
        }

        // 1️⃣ Check in local DB
        $this->db->like('use_name', $username, 'after');
        $this->db->from('loginuser_table');
        $localCount = $this->db->count_all_results();


        log_message('error', "LOCAL#### {$localCount} ### username={$username}".json_encode($this->db->last_query()));

        if ($localCount > 0) {
            echo json_encode(['exists' => 1]);
            return;
        }

        // 2️⃣ Check in central_auth DB
        $this->dbb = $this->load->database('auth', TRUE);
        $this->dbb->like('dhar_user', $username, 'after');
        $this->dbb->from('central_auth');
        $centralCount = $this->dbb->count_all_results();

        log_message('error', "CENTRAL#### {$centralCount} ### username={$username}".json_encode($this->dbb->last_query()));

        echo json_encode(['exists' => $centralCount > 0 ? 1 : 0]);
    }
    // $user1=array(
    //     'pass'=>md5('qwe@123');
    //  );

    public function reset_password() {

            // Allowed designations
        $allowed = ['CO', 'DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->helper('security');
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');

        $users = $this->db->query("select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and user_code = '$user_code'")->result();

        foreach ($users as $user) {
            $make_password = 'test@123';

            $this->db->trans_begin();



            $resetPasswordDateTime = date('Y-m-d H:i:s');
            $passwordResetDate = date('Y-m-d');

            $this->dbb=$this->load->database('auth', TRUE);

            //condition check for new login used or not==================

            $sqlForCheckCentralAuth = "select * from central_auth where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and dhar_code = '$user_code'";
            $checkValCentralAuth = $this->dbb->query($sqlForCheckCentralAuth)->row();

            if(!isset($checkValCentralAuth) || empty($checkValCentralAuth))
            {
                log_message('error','#ERROR0678 : C1:=============central Auth=='.json_encode($this->dbb->last_query()));
                $this->session->set_flashdata('message','#ERROR0678 : USER DETAILS NOT FOUND IN DHARITREE');
                redirect('/home');
            }
            //old method use for password reset============
            log_message('error','MB009 : ==reset_password===centralAuthUpdateornotCount=='.json_encode($checkValCentralAuth));
            if($checkValCentralAuth->password_change_flag == 0)
            {
                $enc_pass = $this->utilityclass->encryptData($make_password);
                $login_user_table_password = $str = do_hash($make_password);
                $central_auth_password = md5($make_password);
            }
            else if($checkValCentralAuth->password_change_flag == 1 )
            {
                // //new set up with bcrypt password===============
                // $login_user_table_password = $this->bcryptPassWord($make_password);
                // $central_auth_password     = $this->bcryptPassWord($make_password);
                $this->session->set_flashdata('message','#WARNING : COULD NOT PROCEED...USER NEED TO COMPLETE THE PROCESS OF FORGOT PASSWORD WHILE LOGIN IN DHARITREE.');
                redirect('/home');
            }


            //handling password suffle for previous password handling==================
            $getSufflePasswordStringArray =array();
            $loginUserTableUpdateString = '';
            $CentraTableUpdateString = '';

            $getSufflePasswordStringArray = $this->getCurrentPasswordCentralandLoginUser($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);

            if($getSufflePasswordStringArray['responseType'] == 1)
            {
                log_message('error','#ERROR0678 : C2:=============getSufflePasswordStringArray=='.json_encode($getSufflePasswordStringArray));
                $this->session->set_flashdata('message',$getSufflePasswordStringArray['msg']);
                redirect('/home');
            }



            $loginUserTableUpdateString = $getSufflePasswordStringArray['login'];
            $CentraTableUpdateString    = $getSufflePasswordStringArray['central'];

            $query1 = "update loginuser_table set password='$login_user_table_password', $loginUserTableUpdateString,dis_enb_option='E',activity='1',first_login='Y',date_password_changed = '$resetPasswordDateTime'  where "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and user_code = '$user_code'";
            $this->db->query($query1);
            log_message('error','#ERROR0678 : UPDTE:LOGINUSERTABLE:========='.json_encode($this->db->last_query()));
            // $this->dbb=$this->load->database('auth', TRUE);

            $query2 = "update central_auth set password='$central_auth_password' , $CentraTableUpdateString ,activity='1', password_change = '$passwordResetDate' where "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and dhar_code = '$user_code'";
            $this->dbb->query($query2);


            log_message('error','#ERROR0678 : UPDTE:CENTRALAUTH:==============='.json_encode($this->dbb->last_query()));


            if($this->db->affected_rows()==1 && $this->dbb->affected_rows()==1){
                $sql="Select * from users where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and user_code = '$user_code' ";
                $data=$this->db->query($sql)->row_array();
                $sql="Select * from loginuser_table where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code = '$user_code' ";
                $dataRow=$this->db->query($sql)->row_array();
                if($data['user_desig_code']=='SDLC' || $data['user_desig_code']=='MOU'){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."changePasswordIlrms",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'unique_user_id' => $dataRow['use_name'],
                            'password' => $make_password,
                        ),
                    ));
                    $response = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $response_obj = json_decode($response);
                    log_message('error',"APIfromBasundhara:".$response);
                    // log_message('error',"APIfromBasundhara:".json_encode(array(
                    //         'unique_user_id' => $dataRow['use_name'],
                    //         'password' => $make_password,
                    //     )));
                    if($httpcode == 200){
                        $response_obj = json_decode($response);
                        if($response_obj->result == "N"){
                            log_message("error", "#PASSWORD0002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #PASSWORD0002");
                            show_error("Internal Server Error, Please Try Again Later..., Error Code #PASSWORD0002","401",$heading="Error-401");
                            return;
                        }
                        curl_close($curl);
                    }else{
                        log_message("error", "#PASSWORD0002, Curl Error(200) In Api ".SDLC_MOUZADAR_PASSWORD."changePasswordIlrms");
                        //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #PASSWORD0002");
                        show_error("Internal Server Error, Please Try Again Later..., Error Code #PASSWORD0002","401",$heading="Error-401");
                        return;
                    }
                }
                $this->db->trans_commit();
                $this->dbb->trans_commit();
            }else{
                $this->db->trans_rollback();
                $this->dbb->trans_rollback();
                show_error("Internal Server Error, Please Try Again Later..., Error Code #PASSWORD0006","401",$heading="Error-500");
                //redirect('/home');
            }
        }
        $this->session->set_flashdata('message','Password has been reset');
        redirect('/home');
        //redirect('initialization/passwordreset');
    }


    public function lm_transfer() {
        //var_dump($this->session->all_userdata());
        echo json_encode("Please Disabled the User and Create a new Account");
        return ;
        die;
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $q = "select count(*) as c from users where user_code='$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
        $c = $this->db->query($q)->row()->c;
        if ($c == 0) {
            $result_data1 = $this->db->query("Select * from lm_code where lm_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = '$user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ")->row();
            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = 'LM' ")->row();
//echo $result_data1->corres_sk_code;

            if ((substr($result_data1->corres_sk_code, 0, 2) === 'SK')) {
                $result_data5 = $this->db->query("Select * from users where user_code = '$result_data1->corres_sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $sk_name = $result_data5->username;
                $sk_code = $result_data5->user_code;
            } else {
                $sk_name = '';
                $sk_code = '';
            }

            $designation = $result_data4->user_desig_as;
            $name = $result_data1->lm_name;
            $joining_date = date('d-m-Y', strtotime($result_data1->dt_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->dt_to));
            $desig_code = 'LM';
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        }

        $dist_name = $this->utilityclass->getDistrictName($result_data2->dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($result_data2->dist_code, $result_data2->subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code);
        $lot_no_name = $this->utilityclass->getLotName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code, $result_data2->lot_no);

        $result_data3 = $this->db->query("Select * from privilege where priv_code = '$result_data2->priv'")->row();
        if ($result_data2->dis_enb_option == 'E') {
            $status = "Enabled";
        } else {
            $status = "Disabled";
        }
        if ($result_data1->status == 'O') {
            $type = "à¦¸à§?à¦¥à¦¾à¦¨à§€à¦¯à¦¼";
        } elseif ($result_data1->status == 'P') {
            $type = "à¦†à¦¨à§° à¦¶à§?à¦¹à¦²à¦¤";
        } else {
            $type = "à¦¸à¦‚à¦²à¦—à§?à¦¨";
        }
        $data['info'] = array(
            'name' => $name,
            'user_code' => $user_code,
            'role' => $result_data3->priv_desc,
            'role_code' => $result_data2->priv,
            'status' => $status,
            'status_code' => $result_data2->dis_enb_option,
            'designation' => $designation,
            'designation_code' => $desig_code,
            'joining_date' => $joining_date,
            'relese_date' => $relese_date,
            'user_name' => $result_data2->use_name,
            'dist_name' => $dist_name,
            'dist_code' => $result_data2->dist_code,
            'subdiv_name' => $sub_div_name,
            'subdiv_code' => $result_data2->subdiv_code,
            'cir_name' => $cir_name,
            'cir_code' => $result_data2->cir_code,
            'mouza_pargona_name' => $mouza_pargona_code,
            'mouza_pargona_code' => $result_data2->mouza_pargona_code,
            'lot_no' => $lot_no_name,
            'lot_no_code' => $result_data2->lot_no,
            'type' => $type,
            'type_code' => $result_data1->status,
            'sk_name' => $sk_name,
            'sk_code' => $sk_code,
            'phone_no' => $phone_no,
            'hashed_password_old' => $hashed_password_old
        );
//var_dump($data);

        $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = 'adm' OR priv_code = 'mut' order by priv_code")->result();
        $data['lotlists'] = $this->db->query("Select * from location where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code='$result_data2->mouza_pargona_code' and lot_no!='00' and vill_townprt_code='00000' ")->result();
//echo "Select * from location where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code='$result_data2->mouza_pargona_code' and lot_no!='00' and vill_townprt_code='00000' ";
//var_dump($data['lotlists']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/lm_transfer', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/lm_transfer';
        $this->load->view('layouts/main',$data);
    }

    function updatelotLM() {
        $user_code = $this->input->post('user_code');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $update_lot = $this->input->post('update_lot');
        $this->db->trans_begin();
        $q = "select * from lm_code where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$update_lot' and lm_code='$user_code' ";
        $numrows = $this->db->query($q)->num_rows();
        if ($numrows == 0) {
            $q = "Select * from lm_code where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and lm_code='$user_code' ";
            $data = $this->db->query($q)->row();
            unset($data->lmuser);
            $data->dt_from=date('Y-m-d H:i:s');
            $data->lot_no = $update_lot;
            $this->db->insert('lm_code', $data);
            if($this->db->affected_rows()==1){
                $q = "Update loginuser_table set lot_no='$update_lot' where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and user_code='$user_code' ";
                $this->db->query($q);
                $this->dbb=$this->load->database('auth', TRUE);
                $sql = "Update central_auth set lot_no='$update_lot' where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and dhar_code='$user_code' ";
                $this->dbb->query($sql);
                if($this->db->affected_rows()==1 && $this->dbb->affected_rows()==1){
                    $this->db->trans_commit();
                    $this->dbb->trans_commit();
                }else{
                    $this->db->trans_rollback();
                    $this->dbb->trans_rollback();
                }
            }
            redirect('/initialization/all_active_enabled_users_co');
        } else {
            $this->session->set_flashdata('message', 'Plese Create a new user !! There are some issues to transfer this LM');
            redirect('/home');
        }
    }

    function checkuserlist() {
        $q = "SElect * from loginuser_table where user_code in (select lm_code from lm_code) or user_code in (select user_code from users) ";
        $result = $this->db->query($q)->result();
        var_dump($result);
    }

    function menubarcontrol() {
        $menu_permission = "select * from user_permission order by id";
        $data['result_menu'] = $this->db->query($menu_permission)->result();

        $all_designation = "select * from master_user_designation order by privilege";
        $data['result_designation'] = $this->db->query($all_designation)->result();

        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/initialization/menubarcontrol', $data);
        $this->load->view('../views/footer');
    }

    public function Update_user_permission() {
        $users = $this->input->post('users');
        $id = $this->input->post('id');
        $query = "Update user_permission set user_desig_code = '$users' where id = '$id' ";
        $result = $this->db->query($query);
        echo $result;
    }

    public function my_so_auth() {
        $controllers = array();
        $this->load->helper('file');
        $files = get_dir_file_info(APPPATH . 'controllers', FALSE);
//$i = 0;
        foreach (array_keys($files) as $file) {
            $controllers[] = str_replace(EXT, '', $file);
//$i++;
        }
        $data['results'] = $controllers; // Array with all our controllers
//var_dump($controllers);
        $main = array_merge($data);
        $this->load->view('header');
        $this->load->view('SKofficeconversion/set_permission', $data);
        $this->load->view('footer');
    }

    function set_Permission_users() {

//echo $this->input->post('Controller');
        $this->load->library('controllerlist');
//var_dump($this->controllerlist->getControllers());

        $controller = $this->input->post('Controller');
        $controllername = $controller;
//$this->load->helper('file');
// Load its methods / actions
        $actionMethods = get_class_methods($controller);
//echo $actionMethods;
        $subdircontrollername = $controller;
        if (!class_exists($controllername)) {
            $this->load->file($controller);
        }
        $aMethods = get_class_methods($controller);
        $aUserMethods = array();
        foreach ($aMethods as $method) {
            if ($method != '__construct' && $method != 'get_instance' && $method != $controller) {
                $aUserMethods[] = $method;
            }
        }
//var_dump($aUserMethods);
        $data['controllers'] = $controller;
        $data['methodes'] = $aUserMethods; // Array with all our controllers
        $main = array_merge($data);
        $this->load->view('header');
        $this->load->view('SKofficeconversion/set_Permission_users', $data);
        $this->load->view('footer');
    }

    function set_users($controller, $method, $users) {
        $user_desig_code = strtoupper($users);
        $controller_name = $controller;
        $function_name = $method;
        $sql = "Select exists(select * from user_permission where controller_name = '$controller_name' and function_name = '$function_name' and user_desig_code = '$user_desig_code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'controller_name' => $controller_name,
            'function_name' => $function_name,
            'user_desig_code' => $user_desig_code
        );
        if ($sql->exists == 'f') {
            $this->db->insert('user_permission', $insert);
            $msg = "User Authorized";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "User Already Authorized";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    public function backup_for_doul() {
        $this->load->view('header');
        $this->load->view('initialization/backup_for_jamadoul');
        $this->load->view('footer');
    }

    Public function backup_for_chitha() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $sub_div_code = $this->db->query("select * from location where dist_code = '$dist_code' and subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and vill_townprt_code='00000' and lot_no='00'", array($dist_code));
        $sub_div_code = $sub_div_code->result();
        foreach ($sub_div_code as $sub_div) {
            $subdiv = $sub_div->subdiv_code;
            $subdiv_name = $sub_div->loc_name;
            $circle_code = $this->db->query("select * from location where dist_code = '$dist_code' and subdiv_code = '$subdiv' and cir_code!='00' and mouza_pargona_code='00' and vill_townprt_code='00000' and lot_no='00'", array($dist_code, $subdiv));
            $circle_code = $circle_code->result();
            foreach ($circle_code as $cir) {
                $chitha_basic_record = $this->db->query("Select count(*) as c from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv' and cir_code='$cir->cir_code'")->row()->c;

                $chitha_basic_doul_record = $this->db->query("Select count(*) as c from chitha_basic_doul where dist_code='$dist_code' and subdiv_code='$subdiv' and cir_code='$cir->cir_code'")->row()->c;

                $v = array(
                    'dist_code' => $dist_code,
                    'dist_name' => $dist_name,
                    'subdiv_code' => $subdiv,
                    'subdiv_name' => $subdiv_name,
                    'cir_code' => $cir->cir_code,
                    'cir_name' => $cir->loc_name,
                    'chitha_basic_record' => $chitha_basic_record,
                    'chitha_basic_doul_record' => $chitha_basic_doul_record
                );
                $a[] = $v;
            }
        }
        $data['circle'] = $a;
        $this->load->view('header');
        $this->load->view('initialization/backup_for_doul', $data);
        $this->load->view('footer');
    }

    public function start_the_backup() {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1024M');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');

        $chitha_basic_record = $this->db->query("Select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='01' and  lot_no='01' and vill_townprt_code='10002' and dag_no = '174'")->result(); //limit 1000 offset 0  and dag_no = '3' and patta_no='2544'
        foreach ($chitha_basic_record as $c_details) {
            $c_details->col8 = $this->getcol8($dist_code, $c_details->subdiv_code, $c_details->cir_code, $c_details->mouza_pargona_code, $c_details->lot_no, $c_details->vill_townprt_code, $c_details->dag_no, $c_details->patta_type_code);
            $tenants_and_subtenants = $this->getcol9($dist_code, $c_details->subdiv_code, $c_details->cir_code, $c_details->mouza_pargona_code, $c_details->lot_no, $c_details->vill_townprt_code, $c_details->dag_no, $c_details->patta_type_code, $c_details->patta_no);
            $col9 = '';

            if (isset($tenants_and_subtenants[$c_details->dag_no])) {
                if (!empty($tenants_and_subtenants[$c_details->dag_no]['tenant'])) {
                    foreach ($tenants_and_subtenants[$c_details->dag_no]['tenant'] as $tenantdesc):
                        $tenantName = $tenantdesc['tenant_name'];
                        if ($tenantdesc['tenants_father'] != '') {
                            $tenantsFather = $tenantdesc['tenants_father'];
                        } else {
                            $tenantsFather = "";
                        }
                        if ($tenantdesc['tenants_add1'] != "") {
                            $tenantsadd1 = $tenantdesc['tenants_add1'];
                        } else {
                            $tenantsadd1 = "";
                        }
                        if ($tenantdesc['tenants_add2'] != "") {
                            $tenantsadd2 = $tenantdesc['tenants_add2'];
                        } else {
                            $tenantsadd2 = "";
                        }
                        if ($tenantdesc['status'] == 0) {
                            $col9 = $col9 . '' . $tenantName . '<br>(' . $tenantsFather . ")" . '<br>' . $tenantsadd1 . '<br>' . $tenantsadd2 . "<br>---<br>";
                        } else {
                            $col9 = $col9 . '' . "<s>" . $tenantName . '<br>(' . $tenantsFather . ")" . '<br>' . $tenantsadd1 . '<br>' . $tenantsadd2 . "</s><br>---<br>";
                        }
                    endforeach;
                }
            }

            $col10 = '';
            if (isset($tenants_and_subtenants[$c_details->dag_no])) {
                if (!empty($tenants_and_subtenants[$c_details->dag_no]['tenant'])) {
                    foreach ($tenants_and_subtenants[$c_details->dag_no]['tenant'] as $tenantdesc):
                        if ($tenantdesc['tenant_type'] != "") {
                            $type_of_tenant = $tenantdesc['tenant_type'];
                        } else {
                            $type_of_tenant = "";
                        }

                        if ($tenantdesc['khatian_no'] != "") {
                            $khatian_no = $tenantdesc['khatian_no'];
                        } else {
                            $khatian_no = "";
                        }
                        $col10 = $col10 . '' . $type_of_tenant . '<br>' . $khatian_no;
                        $col10 = $col10 . "<br>---<br>";
                    endforeach;
                }
            }

            $col11 = '';
            if (isset($tenants_and_subtenants[$c_details->dag_no])) {
                if (!empty($tenants_and_subtenants[$c_details->dag_no]['tenant'])) {
                    foreach ($tenants_and_subtenants[$c_details->dag_no]['subtenant'] as $subtenant):
                        if ($subtenant['subtenant_name'] != "") {
                            $subtenantName = $subtenant['subtenant_name'];
                        } else {
                            $subtenantName = "";
                        }
                        if ($subtenant['subtenants_father'] != "") {
                            $subtenantfatherName = $subtenant['subtenants_father'];
                        } else {
                            $subtenantfatherName = "";
                        }
                        if ($subtenant['subtenants_add1'] != "") {
                            $subtenantadd1 = $subtenant['subtenants_add1'];
                        } else {
                            $subtenantadd1 = "";
                        }
                        if ($subtenant['subtenants_add2'] != "") {
                            $subtenantadd2 = $subtenant['subtenants_add2'];
                        } else {
                            $subtenantadd2 = "";
                        }
                        if ($subtenant['subtenants_add3'] != "") {
                            $subtenantadd3 = $subtenant['subtenants_add3'];
                        } else {
                            $subtenantadd3 = "";
                        }

                    endforeach;
                }
            }

            $col31remarks = $this->getcol31($dist_code, $c_details->subdiv_code, $c_details->cir_code, $c_details->mouza_pargona_code, $c_details->lot_no, $c_details->vill_townprt_code, $c_details->dag_no);
            $data1[$c_details->dag_no]['col31'][] = $col31remarks;
            $order_count = 1;
            $col31 = "";
            foreach ($data1[$c_details->dag_no]['col31'] as $remark):
                foreach ($remark as $r):
                    if (sizeof($r) > 0):
//Name Correction
                        if ($r['ord_type_code'] == '06'):
                            $col31 = $col31 . '' . "<p class='text-danger'><u>চক্র বিষয়া'ৰ :  </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তাৰিখ'ৰ " . $r['innerdata52'][0]->ord_no . " হুকুম নং নাম সংশোধনীকৰণ হুকুমমৰ্মে এই দাগৰ " . $r['innerdata52'][0]->infavor_of_name . "'ৰ  নাম  " . $r['innerdata52'][0]->infavor_of_corrected_name . " কৰা হ'ল  |</p>";
                            $col31 = $col31 . '' . "<p class='hide'>ভূমিলেখ্য সহায়ক : " . $r['lmname'] . "</p><p><u class='text-danger'>চক্র বিষয়া :</u><br>(" . $r['username'] . ")</p>";
                        endif;
//Name Cancellation
                        if ($r['ord_type_code'] == '07'):
                            $col31 = $col31 . '' . "<p class='text-danger'><u>চক্র বিষয়া'ৰ : </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তাৰিখ'ৰ " . $r['order_no'] . " হুকুম নং নাম কৰ্তন  হুকুমমৰ্মে এই দাগৰ পটাদাৰ " . $r['infavor_of_name'] . "'  ৰ  আবেদন মৰ্মে পটাদাৰ " . $r['name_delete'] . "ৰ  নাম কৰ্তন কৰা হ'ল  |</p>";
                            $col31 = $col31 . '' . "<p class='hide'>ভূমিলেখ্য সহায়ক : " . $r['lmname'] . "</p><p><u class='text-danger'>চক্র বিষয়া :</u><br>(" . $r['username'] . ")</p>";
                        endif;
//Reclassification
                        if ($r['remark_type_code'] == '08'):
                            $col31 = $col31 . '' . "<p class='text-danger'><u>হুকুম নং : </u></p><p>" . $r['case_no'] . " শ্রেণী সংশোধনীকৰণ প্রস্তাব উপায়ুক্ত মহোদয়ে " . date('d-m-Y', strtotime($r['dc_approval_date'])) . " তাৰিখে দিয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পট্টাৰ " . $r['dag_no'] . " নং দাগৰ শ্রেণী " . $r['present_land_class'] . "'ৰ পৰা " . $r['proposed_land_class'] . " লৈ পৰিবৰ্তন কৰা হ'ল ।</p>";
                        endif;
//NR Cases
                        if ($r['remark_type_code'] == '09'):
                            $col31 = $col31 . '' . "<p class='text-danger'><u>হুকুম নং : </u></p><p> চক্র বিষয়া'ৰ " . $r['case_no'] . " নং NR গোচৰৰ প্ৰস্তাৱৰ " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . "  তাৰিখে দিয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পট্টা আৰু " . $r['dag_no'] . "  নং দাগৰ পট্টাৰ প্ৰকাৰ একচণাৰ পৰা চৰকাৰীলৈ পৰিবৰ্ত্তন কৰাৰ হুকুম " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['final_date']))) . " তাৰিখে দিয়া হল ।</p>";
                            $col31 = $col31 . '' . "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(" . $r['lm_name'] . ")</p><p><u class='text-danger'>চক্র বিষয়া :</u><br>(" . $r['username'] . ")</p>";
                        endif;
//Office Mutation
                        if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')):
                            $order_type = $r['ord_type_code'];
                            $col31 = $col31 . '' . "<u class='text-danger'>হুকুম নং : " . $order_count++ . "<br></u>
                            <p>চক্র বিষয়া'ৰ  <br>  " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . " তাৰিখ'ৰ " . $this->utilityclass->getOfficeMutType($order_type) . " নং  " . $r['ord_no'] . " 'ৰ হুকুমমৰ্মে এই দাগৰ ";

                            if ($r['by_right_of'] == '11') {
                                $col31 = $col31 . '' . " অংশৰ জমিত ";
                            } else {
                                $col31 = $col31 . '' . $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                                $col31 = $col31 . '' . $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                                $col31 = $col31 . '' . $this->utilityclass->cassnum(number_format($r['lessa'], 2)) . " লেছা মাটি ";
                            }
                            $col31 = $col31 . '' . $this->utilityclass->getTransferType($r['by_right_of']) . " ";
                            $count = 1;
                            $howmany = sizeof($r['alongwith_name']) - 1;
                            foreach ($r['alongwith_name'] as $al):
                                $col31 = $col31 . '' . $al['alongwithname'];
                                if ($count < sizeof($r['alongwith_name']) - 1) {
                                    $col31 = $col31 . '' . " , ";
                                    $count++;
                                } elseif ($count == sizeof($r['alongwith_name']) - 1) {
                                    $col31 = $col31 . '' . " আৰু ";
                                    $count++;
                                } else {
                                    $col31 = $col31 . '' . " ";
                                }
                            endforeach;
                            if (sizeof($r['alongwith_name']) != '0') {
                                $col31 = $col31 . '' . "'ৰ লগত ";
                            }

                            $count = 1;
                            $howmany = sizeof($r['inplace_of_name']) - 1;
                            foreach ($r['inplace_of_name'] as $al):
                                $col31 = $col31 . $al['inplace_of_name'];
                                if ($count < sizeof($r['inplace_of_name']) - 1) {
                                    $col31 = $col31 . '' . " , ";
                                    $count++;
                                } elseif ($count == sizeof($r['inplace_of_name']) - 1) {
                                    $col31 = $col31 . '' . " আৰু ";
                                    $count++;
                                } else {
                                    $col31 = $col31 . '' . " ";
                                }
                            endforeach;
                            if (sizeof($r['inplace_of_name']) != '0') {
                                $col31 = $col31 . '' . "' ৰ স্হলত ";
                            }
                            $count = 1;
                            $howmany = sizeof($r['infav']) - 1;
                            foreach ($r['infav'] as $in):
                                $col31 = $col31 . '' . $in['infavor_of_name'];
                                if ($count < sizeof($r['infav']) - 1) {
                                    $col31 = $col31 . '' . " , ";
                                    $count++;
                                } elseif ($count == sizeof($r['infav']) - 1) {
                                    $col31 = $col31 . '' . " আৰু ";
                                    $count++;
                                } else {
                                    $col31 = $col31 . '' . " ";
                                }
                            endforeach;

                            if ($r['ord_type_code'] == '03'):
                                $col31 = $col31 . '' . 'ৰ নামত নামজাৰী কৰা হ’ল |';
                            endif;
                            $col31 = $col31 . '' . "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(" . $r['lm_name'] . ")</p>
                            <p><u class='text-danger'>চক্র বিষয়া :</u><br>(" . $r['username'] . ")</p>
                <p>";
                            if ($r['reg_deal_no'] != "") {
                                $col31 = $col31 . '' . "Reg No (" . $this->utilityclass->cassnum($r['reg_deal_no']) . ")";
                            }
                            $col31 = $col31 . '' . "</p>
                <p>";
                            if ($r['reg_date'] != "") {
                                $col31 = $col31 . '' . "Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                            }
                            $col31 = $col31 . '' . "</p>
                <hr>";
                        endif;
                        if ($r['ord_type_code'] == '01'):
                            $col31 = $col31 . '' . "<u class='text-danger'>হুকুম নং:" . $order_count++ . "</u><br><p>" . $r['ord_passby_desig'] . "ৰ  </p><p>" . $r['ord_no'] . "   নং   ";
                            $order_type = $r['ord_type_code'];
                            $col31 = $col31 . '' . $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                            $col31 = $col31 . '' . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . "  তাৰিখৰ হুকুমমৰ্মে ";

                            if ($r['premi_chal_recpt'] != '003'):
//var_dump($r);
                                $col31 = $col31 . '' . $this->utilityclass->cassnum($r['patta_no']) . " নং একচনা পট্টাৰ আৰু " . $this->utilityclass->cassnum($r['dag_no']) . " নং দাগৰ  ";
                                if (($r['premi_chal_name'] == "") || ($r['premi_chal_name'] == "None")) {
                                    $col31 = $col31 . '' . $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা মাটিৰ প্রিমিয়াম " . round($r['premium'], 2) . " টকা যোগে ";
                                } else {
                                    $col31 = $col31 . '' . $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা মাটিৰ প্রিমিয়াম " . round($r['premium'], 2) . " টকা " . $r['premi_chal_recpt_no'] . " নং " . $r['premi_chal_name'] . " যোগে ";
                                }

                                $count = 1;
                                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                                foreach ($r['ord_onbehalf_of'] as $in):
                                    $col31 = $col31 . '' . $in['app_name'];
                                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                                        $col31 = $col31 . '' . " , ";
                                        $count++;
                                    } elseif ($count == sizeof($r['ord_onbehalf_of']) - 1) {
                                        $col31 = $col31 . '' . " আৰু ";
                                        $count++;
                                    } else {
                                        $col31 = $col31 . '' . " ";
                                    }
                                endforeach;
                                $col31 = $col31 . '' . " ৰ পৰা আদায় হোৱাত ";
                            endif;
                            $count = 1;
                            $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                            foreach ($r['ord_onbehalf_of'] as $in):
                                $col31 = $col31 . '' . $in['app_name'];
                                if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                                    $col31 = $col31 . '' . " , ";
                                    $count++;
                                } elseif ($count == sizeof($r['ord_onbehalf_of']) - 1) {
                                    $col31 = $col31 . '' . " আৰু ";
                                    $count++;
                                } else {
                                    $col31 = $col31 . '' . " ";
                                }
                            endforeach;
                            $col31 = $col31 . '' . "ৰ নামত " . $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা মাটি  পৃঠক " . $this->utilityclass->cassnum($r['new_patta_no']) . " নং " . $r['patta_type'] . "  পট্টা আৰু " . $this->utilityclass->cassnum($r['new_dag_no']) . " নং দাগে ম্যাদীকৰণ কৰা হল | </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(" . $r['lm_name'] . ")</p>
                <p><u class='text-danger'>চক্র বিষয়া :</u><br>(" . $r['username'] . ")</p>";
                        endif;

                        if (($r['remark_type_code'] == '10') && ($r['ord_type_code'] == '10')):
                            $col31 = $col31 . '' . "<p>হুকুম নং :" . $r['history_no'] . "<br>উপায়ুক্ত মহোদয়ৰ " . $r['ord_no'] . " নং আৱন্টন বন্দৱস্তী গোচৰৰ " . date('d/m/Y', strtotime($r['date_entry'])) . "  ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "  নং দাগৰ  " . $r['allottee_land_b'] . " বিঘা  " . $r['allottee_land_k'] . "  কঠা  " . $r['allottee_land_lc'] . " লেছা মাটিৰ  " . $r['new_dag'] . "  নং দাগ আৰু  " . $r['new_patta'] . " নং নতুন খেৰাজ ম্যাদী পট্টা ভূক্ত কৰা হল । " . date('Y') . " চনত দৌল ভূক্ত হব । </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(" . $r['lm_name'] . ")</p>
                <p><u class='text-danger'>চক্র বিষয়া  :</u><br>(" . $r['username'] . ")</p>";
                        endif;

                        if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '04')):
                            $howmany = sizeof($r['infav']);
                            if ($howmany != null) {
                                $col31 = $col31 . '' . "<p><u class='text-danger'>হুকুম নং : " . $order_count++ . "</u></p>
                    <p>চক্র বিষয়া'ৰ  " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . "তাৰিখৰ  ";
                                $order_type = $r['ord_type_code'];
                                $col31 = $col31 . '' . $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                                $col31 = $col31 . '' . $r['ord_no'] . " ৰ হুকুমমৰ্মে এই দাগৰ ";
                                $col31 = $col31 . '' . $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                                $col31 = $col31 . '' . $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                                $col31 = $col31 . '' . $this->utilityclass->cassnum(number_format($r['lessa'], 2)) . " লেছা মাটি ";

                                $count = 1;
                                $howmany = sizeof($r['infav']);
                                foreach ($r['infav'] as $in):
                                    $col31 = $col31 . '' . $in['infavor_of_name'];
                                    if ($count < sizeof($r['infav']) - 1) {
                                        $col31 = $col31 . '' . " , ";
                                        $count++;
                                    } elseif ($count == sizeof($r['infav']) - 1) {
                                        $col31 = $col31 . '' . " আৰু ";
                                        $count++;
                                    } else {
                                        $col31 = $col31 . '' . " ";
                                    }
                                endforeach;
                                $col31 = $col31 . '' . "'ৰ নামত " . $this->utilityclass->cassnum($r['new_patta_no']) . " নং  পট্টা আৰু " . $this->utilityclass->cassnum($r['new_dag_no']) . " নং দাগ কৰা হল |";
                                if ($r['ord_type_code'] == '04'):

                                endif;
                                $col31 = $col31 . '' . "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :-</u><br>(" . $r['lm_name'] . ")</p>
                                <p><u class='text-danger'>চক্র বিষয়া :-</u><br>(" . $r['username'] . ")</p><hr>";
                            }
                        endif;
                        if ($r['ord_type_code'] == '01'):
                            if ($r['premi_chal_recpt'] == '003'):
                                $col31 = $col31 . '' . "<hr><p class='text-danger'><u>টোকা :</u></p> আবেদনকাৰীয়ে প্রিমিয়াম আদায় নিদিয়া বাবে " . round($r['premium'], 2) . " টকা ৰাজহৰ বকেয়া হিচাবে আদায় লোৱা হওঁক ।";
                            endif;
                        endif;
                    endif;

                endforeach;
            endforeach;


            $lmnotes = $this->getLmNotes($dist_code, $c_details->subdiv_code, $c_details->cir_code, $c_details->mouza_pargona_code, $c_details->lot_no, $c_details->vill_townprt_code, $c_details->dag_no);
            $data1[$c_details->dag_no]['lmnotes'] = $lmnotes;
            $lm_n = "";
            if (isset($data1['lmnote'])) {
                $lm_n = $lm_n . '' . "<u class='text-danger'>মণ্ডলৰ টোকা</u>";
                foreach ($data1[$c_details->dag_no]['lmnote'] as $key => $enc):
                    $lm_n = $lm_n . '' . "<p>" . $chithainf['lmnote'][$key]['lm_note'] . "----" . $chithainf['lmnote'][$key]['lm_code'] . "</p>";
                endforeach;
            }

            $innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status FROM sro_note where "
                . "dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";

            $innerdata_sro_note = $this->db->query($innerquery_sro)->result();
            foreach ($innerdata_sro_note as $sro) {
                $data1[$c_details->dag_no]['sro'][] = array(
                    'dag_no' => $c_details->dag_no,
                    'dag_area_b' => $sro->dag_area_b,
                    'dag_area_k' => $sro->dag_area_k,
                    'dag_area_lc' => $sro->dag_area_lc,
                    'reg_to_name' => $sro->reg_to_name,
                    'reg_from_name' => $sro->reg_from_name,
                    'name_of_sro' => $sro->name_of_sro,
                    'deed_no' => $sro->deed_no,
                    'date_of_deed' => $sro->date_of_deed,
                    'status' => $sro->status
                );
            }
            $sro_hukum_no = 1;
            $sro = "";
            if (isset($chithainf['sro'])) {
                $size_of_sro_order = sizeof($chithainf['sro']);
                $sro = $sro . '' . "<u class='text-danger'>SRO টোকা</u>";
                foreach ($chithainf['sro'] as $key => $sr):
                    $newDatesro = date("d-m-Y", strtotime($chithainf['sro'][$key]['date_of_deed']));
                    $headingsro = '(SR -' . $chithainf['sro'][$key]['name_of_sro'] . ')';
                    $sro = $sro . '' . '<p>' . $headingsro . '&nbsp;' . '&nbsp;' . 'এই দাগৰ (' . $chithainf['sro'][$key]['dag_no'] . ' নং)  জমীত পটাদাৰ ' . $chithainf['sro'][$key]['reg_from_name'] . ' আৰু ক্ৰেতা / দানলওঁতা ' . $chithainf['sro'][$key]['reg_to_name'] . ' ৰ মাজত ' . '<br>(' . $chithainf['sro'][$key]['dag_area_b'] . 'B - ' . $chithainf['sro'][$key]['dag_area_k'] . 'K - ' . $chithainf['sro'][$key]['dag_area_lc'] . 'L)' . ' মাটিৰ <br> ৰেঃ দলিল <br>( Deed No.) ' . $chithainf['sro'][$key]['deed_no'] . ' নং <br>' . $newDatesro . ' তাৰিখে ' . ' পঞ্জীয়ন হয় |</p>';

                    if ($chithainf['sro'][$key]['status'] == '1') {
                        $sro = $sro . '' . "<p class='red'><u>Status :</u><br> ( চক্র বিষয়াই নামজাৰীৰ পঞ্জীয়নৰ বাবে আদেশ দিছে | )";
                    } elseif ($chithainf['sro'][$key]['status'] == '2') {
                        $sro = $sro . '' . "<p class='red'><u>Status :</u><br> ( সহায়কে পঞ্জীয়ন কৰিলে | )";
                    } elseif ($chithainf['sro'][$key]['status'] == '3') {
                        $sro = $sro . '' . "<p class='red'><u>Status :</u><br> ( নামজাৰী হৈ গৈছে | )";
                    }

                    if ($sro_hukum_no < $size_of_sro_order) {
                        $sro = $sro . '' . "<hr style='border-bottom: 2px solid #b3b0b0;'>";
                    }
                    $sro_hukum_no++;
                endforeach;
            }

            $innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_used_for,encro_evic_date FROM chitha_rmk_encro where "
                . "dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";

            $innerdata58 = $this->db->query($innerquery58)->result();
            foreach ($innerdata58 as $encro) {

                $encro_land_used_for = $encro->encro_land_used_for;

                $innerquery_encroland = "SELECT used_for from encro_land_used_for where code='$encro_land_used_for' ";
                $innerdata_encroland = $this->db->query($innerquery_encroland)->result();
                foreach ($innerdata_encroland as $encro_land) {

                    $data1[$dag_no]['encro'][] = array(
                        'encro_evicted_yn' => $encro->encro_evicted_yn,
                        'encro_name' => $encro->encro_name,
                        'encro_since' => $encro->encro_since,
                        'encro_land_b' => $encro->encro_land_b,
                        'encro_land_k' => $encro->encro_land_k,
                        'encro_land_lc' => $encro->encro_land_lc,
                        'encro_land_used_for' => $encro->encro_land_used_for,
                        'encro_evic_date' => $encro->encro_evic_date,
                        'land_used_by_encro' => $encro_land->used_for
                    );
                }
            }
            $enco = "";
            if (isset($chithainf['encro'])) {
                $encro_hukum_no = 1;
                $size_of_encro_order = sizeof($chithainf['encro']);
                $enco = $enco . '' . "<u class='text-danger'>বেদখলকাৰীৰ টোকা</u>";
                foreach ($chithainf['encro'] as $key => $enc):
                    $newDate = date("d-m-Y", strtotime($chithainf['encro'][$key]['encro_since']));
                    $enco = $enco . '' . '<p>' . $chithainf['encro'][$key]['encro_name'] . 'য়ে' . '&nbsp;' . '(' . $chithainf['encro'][$key]['encro_land_b'] . '-' . $chithainf['encro'][$key]['encro_land_k'] . '-' . $chithainf['encro'][$key]['encro_land_lc'] . ')' . 'মাটি' . '&nbsp;' . $newDate . 'তাৰিখৰ পৰা' . '&nbsp;' . $chithainf['encro'][$key]['land_used_by_encro'] . 'কাৰণত ব্যৱহাৰ কৰি আছে</p>';
                endforeach;
                if ($encro_hukum_no < $size_of_encro_order) {
                    $enco = $enco . '' . "<hr style='border-bottom: 2px solid #b3b0b0;'>";
                }
                $encro_hukum_no++;
            }

            $chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,archeo_hist_site_desc from chitha_acho_hist where dist_code='$dist_code' "
                . "and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no'";
//  ////echo $chithaarcheo;
            $innerdataarcheo = $this->db->query($chithaarcheo)->result();
//var_dump($innerdataarcheo);
            foreach ($innerdataarcheo as $archeoinfo) {
                $archeo_code = $archeoinfo->archeo_hist_code;
                $archeo_area_b = $archeoinfo->hist_land_area_b;
                $archeo_area_k = $archeoinfo->hist_land_area_k;
                $archeo_area_lc = $archeoinfo->hist_land_area_lc;
                $archeo_area_description = $archeoinfo->archeo_hist_site_desc;
                $archeo_siteCd = "select archeo_hist_desc from archeo_hist_site_code where archeo_hist_code='$archeo_code' ";

                $innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
                foreach ($innerdataarcheo_cd as $archeo_cd) {
                    $hist_description = $archeo_cd->archeo_hist_desc;
                    $data1[$c_details->dag_no]['archeo'][] = array(
                        'hist_description_nme' => $hist_description,
                        'archeo_hist_code' => $archeo_code,
                        'archeo_b' => $archeo_area_b,
                        'archeo_k' => $archeo_area_k,
                        'archeo_lc' => $archeo_area_lc,
                        'archeo_decribed' => $archeo_area_description
                    );
                }
            }
            $arco = "";
            if (!empty($data1[$c_details->dag_no]['archeo'])) {
                foreach ($data1[$c_details->dag_no]['archeo'] as $key => $archeo):
                    $arco = $arco . '' . '<u>' . $data1[$c_details->dag_no]['archeo'][$key]['hist_description_nme'] . ': </u><br>' . $data1[$c_details->dag_no]['archeo'][$key]['archeo_decribed'] . '<br>' . '(' . $data1[$c_details->dag_no]['archeo'][$key]['archeo_b'] . '-' . $data1[$c_details->dag_no]['archeo'][$key]['archeo_k'] . '-' . $data1[$c_details->dag_no]['archeo'][$key]['archeo_lc'] . ')' . '';
                endforeach;
            }

            $backlogquery = "select * from backlog_orders where dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and "
                . "mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' and vill_townprt_code='$c_details->vill_townprt_code' and "
                . "dag_no ='$c_details->dag_no' and patta_type_code='$c_details->patta_type_code' and category=2";
            $dataBacklog31 = $this->db->query($backlogquery)->result();
            $data1[$c_details->dag_no]['backlogs31'][] = $dataBacklog31;
            $bk = "";
            foreach ($data1[$c_details->dag_no]['backlogs31'] as $backlog) {
                foreach ($backlog as $b) {
                    $bk = $bk . '' . "<u>" . "৩১ নং স্তম্ভত পোনপটীয়া প্ৰৱেশ" . "</u><br>";
                    $bk = $bk . '' . "<p>$b->remark</p>";
                    $bk = $bk . '' . "-----------------------------";
                }
            }

            $backlog_court_order = "select * from backlog_orders where dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' "
                . " and patta_type_code='$c_details->patta_type_code' and category=0";
            $data_court = $this->db->query($backlog_court_order)->result();
            $data1[$c_details->dag_no]['backlog_court_order'][] = $data_court;
            $bko = "";
            foreach ($data1[$c_details->dag_no]['backlog_court_order'] as $court_order) {
                foreach ($court_order as $b) {
                    $bko = $bko . '' . "<u>" . "১১৮ Court Order" . "</u><br>";
                    $bko = $bko . '' . "<p>$b->remark</p>";
                    $bko = $bko . '' . "-----------------------------";
                }
            }


            $innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from chitha_noncrop where dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no'"; // and yn='2017'";
            $innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();


            foreach ($innerdatanoncrp as $noncrop) {

                $type_of_used_noncrp = $noncrop->type_of_used_noncrop;
                $noncrp_b = $noncrop->noncrop_land_area_b;
                $noncrop_k = $noncrop->noncrop_land_area_k;
                $noncrop_lc = $noncrop->noncrop_land_area_lc;
                $innerquery19 = "select noncrop_type from used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
                $innerdata19 = $this->db->query($innerquery19)->result();

//////var_dump($innerdata19);
                foreach ($innerdata19 as $noncrptyp) {
                    $noncrop_type = $noncrptyp->noncrop_type;


                    $data1[$c_details->dag_no]['noncrp'][] = array(
                        'year' => '2017',
                        'type_of_used_noncrp' => $noncrop_type,
                        'noncrp_b' => $noncrp_b,
                        'noncrop_k' => $noncrop_k,
                        'noncrop_lc' => $noncrop_lc
                    );
                }
            }
            $nc1 = "";
            if (!empty($data1[$c_details->dag_no]['noncrp'])) {
                foreach ($data1[$c_details->dag_no]['noncrp'] as $key => $noncrop):
                    $nc1 = $nc1 . '' . $data1[$c_details->dag_no]['noncrp'][$key]['type_of_used_noncrp'];
                endforeach;
            }
            $nc2 = "";
            if (!empty($data1[$c_details->dag_no]['noncrp'])) {
                foreach ($data1[$c_details->dag_no]['noncrp'] as $key => $noncrop):
                    $nc2 = $nc2 . '' . $data1[$c_details->dag_no]['noncrp'][$key]['noncrp_b'] . '-' . $data1[$c_details->dag_no]['noncrp'][$key]['noncrop_k'] . '-' . $data1[$c_details->dag_no]['noncrp'][$key]['noncrop_lc'] . '<br>';

                endforeach;
            }

            $innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_categ_code from chitha_mcrop where dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' and crop_code<>'057' "; //and yearno='2018'
            $innerdatacrp = $this->db->query($innerquerycrp)->result();
            foreach ($innerdatacrp as $mcropdetails) {
                $source_of_water = $mcropdetails->source_of_water;
                $crop_code = $mcropdetails->crop_code;
                $crop_land_area_b = $mcropdetails->crop_land_area_b;
                $crop_land_area_k = $mcropdetails->crop_land_area_k;
                $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
                $crop_category = $mcropdetails->crop_categ_code;
                $innerquerywatersrc = "select source from source_water where water_source_code = '$source_of_water'";
                $innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
                foreach ($innerdatawatersrc as $watersrc) {

                    $sourceOFwater = $watersrc->source;
                    $innerqueryCropCateg = "select crop_categ_desc from crop_category_code where crop_categ_code = '$crop_category'";
                    $innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
                    foreach ($innerdataCropcateg as $CropDesc) {
                        $CropDesc_inChitha = $CropDesc->crop_categ_desc;


                        $innerquerymcrop = "select crop_name from crop_code where crop_code = '$crop_code'";
                        $innerdatamcrop = $this->db->query($innerquerymcrop)->result();
                        foreach ($innerdatamcrop as $cropinfo) {
                            $cropname = $cropinfo->crop_name;


                            $data1[$c_details->dag_no]['mcrp'][] = array(
                                'sourceofwater' => $sourceOFwater,
                                'cropname' => $cropname,
                                'mcrp_b' => $crop_land_area_b,
                                'mcrop_k' => $crop_land_area_k,
                                'mcrop_lc' => $crop_land_area_lc,
                                'crop_category' => $CropDesc_inChitha
                            );
                        }
                    }
                }
            }
            $mc1 = "";
            if (!empty($data1[$c_details->dag_no]['mcrp'])) {
                foreach ($data1[$c_details->dag_no]['mcrp'] as $key => $mcrop):
//if (sizeof($chithainf['noncrp']) > 0) {
                    $mc1 = $mc1 . '' . $data1[$c_details->dag_no]['mcrp'][$key]['sourceofwater'] . '<br>';
// }

                endforeach;
            }
            $mc2 = "";
            if (!empty($data1[$c_details->dag_no]['mcrp'])) {
                foreach ($data1[$c_details->dag_no]['mcrp'] as $key => $mcrop):

                    $mc2 = $mc2 . '' . $data1[$c_details->dag_no]['mcrp'][$key]['cropname'] . '<br>' .
                        '(' . $data1[$c_details->dag_no]['mcrp'][$key]['crop_category'] . ')<br>';
                endforeach;
            }
            $mc3 = "";
            if (!empty($data1[$c_details->dag_no]['mcrp'])) {
                foreach ($data1[$c_details->dag_no]['mcrp'] as $key => $mcrop):

                    $mc3 = $mc3 . '' . $data1[$c_details->dag_no]['mcrp'][$key]['mcrp_b'] . '-' . $data1[$c_details->dag_no]['mcrp'][$key]['mcrop_k'] . '-' . $data1[$c_details->dag_no]['mcrp'][$key]['mcrop_lc'] . '<br>';
                endforeach;
            }


            $innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc from chitha_mcrop where dist_code='$dist_code' and "
                . "subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' and crop_code = '057' "; //and yearno='2018'

            $innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();

            foreach ($innerdatacrp_ekadhig as $ekadhig) {
                $data1[$c_details->dag_no]['mcrp_akeadhig'][] = array(
                    'bigha' => $ekadhig->crop_land_area_b,
                    'katha' => $ekadhig->crop_land_area_k,
                    'lesa' => $ekadhig->crop_land_area_lc
                );
            }
            $mc4 = "";
            if (!empty($data1[$c_details->dag_no]['mcrp_akeadhig'])) {
                foreach ($data1[$c_details->dag_no]['mcrp_akeadhig'] as $key => $mcrp_akeadhig):

                    $mc4 = $mc4 . '' . $data1[$c_details->dag_no]['mcrp_akeadhig'][$key]['bigha'] . '-' . $data1[$c_details->dag_no]['mcrp_akeadhig'][$key]['katha'] . '-' . $data1[$c_details->dag_no]['mcrp_akeadhig'][$key]['lesa'] . '<br>';
                endforeach;
            }


            $innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc from chitha_fruit where dist_code='$dist_code' and subdiv_code='$c_details->subdiv_code' and cir_code='$c_details->cir_code' and mouza_pargona_code='$c_details->mouza_pargona_code' and  lot_no='$c_details->lot_no' "
                . "and vill_townprt_code='$c_details->vill_townprt_code' and dag_no ='$c_details->dag_no' ORDER BY Fruit_plant_ID";

            $innerdata23 = $this->db->query($innerquery23)->result();
            foreach ($innerdata23 as $chithafruitinf) {

                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
                $no_of_fruit_plants = $chithafruitinf->no_of_plants;
                $fruit_bigha = $chithafruitinf->fruit_land_area_b;
                $fruit_katha = $chithafruitinf->fruit_land_area_k;
                $fruit_lesa = $chithafruitinf->fruit_land_area_lc;
                $innerquery24 = "select fruit_name from fruit_tree_code where fruit_code='$fruit_plants_name'";
                $innerdata24 = $this->db->query($innerquery24)->result();
                foreach ($innerdata24 as $fruitinfo) {
                    $fruit_name = $fruitinfo->fruit_name;
                    $data1[$c_details->dag_no]['fruit'][] = array(
                        'fruitname' => $fruit_name,
                        'no_of_plants' => $no_of_fruit_plants,
                        'fbigha' => $fruit_bigha,
                        'fkatha' => $fruit_katha,
                        'flesa' => $fruit_lesa
                    );
                }
            }
            $fut = "";
            if (!empty($data1[$c_details->dag_no]['fruit'])) {
                foreach ($data1[$c_details->dag_no]['fruit'] as $key => $fruit):

                    $fut = $fut . '' . $data1[$c_details->dag_no]['fruit'][$key]['fruitname'] . '<br>' . $data1[$c_details->dag_no]['fruit'][$key]['no_of_plants'] . '<br>' . '(' . $data1[$c_details->dag_no]['fruit'][$key]['fbigha'] . '-' . $data1[$c_details->dag_no]['fruit'][$key]['fkatha'] . '-' . $data1[$c_details->dag_no]['fruit'][$key]['flesa'] . ')' . '<br>';
                endforeach;
            }
            $c_details->col9 = $col9;
            $c_details->col10 = $col10;
            $c_details->col11 = $col11;
            $c_details->col12 = $nc1; //$col12;
            $c_details->col13 = $nc2; //$col13;
            $c_details->col14 = $mc1; //$col14;
            $c_details->col15 = $mc2; //$col15;
            $c_details->col16 = $mc3; //$col16;
            $c_details->col17 = $mc4; //$col17;
            $c_details->col30 = $fut; //$col30;
            $c_details->col31 = $sro . '' . $col31 . '' . $bk . '' . $bko . '' . $lm_n . '' . $enco . '' . $arco;
            $c_details->year_no = '2017';
//var_dump($c_details);
            $this->db->insert('chitha_basic_doul', $c_details);
            unset($c_details);
        }
    }

    public function getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $query = "select lm_note ,lm_code from chitha_rmk_lmnote where dist_code='$district_code' " .
            " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and vill_townprt_code='$village_code' and dag_no='$dag_no' ";
        $lmnotes = $this->db->query($query)->result();
        return $lmnotes;
    }

    public function getcol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
        $data[] = array();
        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from chitha_rmk_gen where  "
            . "dist_code='$district_code' "
            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
            . " (dag_no ='$dag_no') order by rmk_type_hist_no";
//echo $innerquery26;
        $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;


            if ($rmk_type_code == "01") {
                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                    . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc  "
                    . " from chitha_rmk_ordbasic where  dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                    . " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";
//echo $innerquery27;
                $innerdata27 = $this->db->query($innerquery27)->result();

                foreach ($innerdata27 as $chitharmk_ord_basic) {
                    $dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
                    $order_date = $chitharmk_ord_basic->ord_date;
                    $ord_no = $chitharmk_ord_basic->ord_no;
                    $case_no = $chitharmk_ord_basic->case_no;
                    $ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
                    $lm_code = $chitharmk_ord_basic->lm_code;
                    $co_code = $chitharmk_ord_basic->co_code;
                    $order_passby_designation = $chitharmk_ord_basic->ord_passby_desig;
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;


                    $get_designation = $this->db->query("select user_desig_as as designation from master_user_designation "
                        . "where user_desig_code = '$order_passby_designation'")->row()->designation;

                    if ($ord_type_code == '01') {
                        $innerquery28 = " select patta_no,new_patta_type FROM chitha_rmk_convorder where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                            . "and (dag_no ='$new_dag_no' or new_dag_no='$new_dag_no') and "
                            . "rmk_type_hist_no='$rmk_type_hist_no' ";

//////echo $innerquery28;
                        $innerdata28 = $this->db->query($innerquery28)->result();
// ////var_dump($innerdata28);
                        $patta_no = "";
                        $patta_type_code = "";
                        $patta_type = "";
                        $premium = "";
                        $premi_chal_recpt_no = "";
                        $premi_chal_recpt = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $land_area_b = "";
                        $land_area_k = "";
                        $land_area_lc = "";
                        $username = "";
                        $lm_name = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $chalan_name = "";
                        foreach ($innerdata28 as $rmkconvorder) {
                            $patta_no = trim($rmkconvorder->patta_no);
                            $patta_type_code = $rmkconvorder->new_patta_type;
                            $innerquery29 = "select patta_type FROM patta_code where type_code='$patta_type_code'";
                            $innerdata29 = $this->db->query($innerquery29)->result();
                            foreach ($innerdata29 as $pattatype) {
                                $patta_type = $pattatype->patta_type;
                            }
                        }

                        $innerquery30 = "select distinct (premium) as premium,premi_chal_recpt_no "
                            . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                            . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                            . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null order by premi_chal_recpt_no";

                        $innerdata30 = $this->db->query($innerquery30)->result();
                        foreach ($innerdata30 as $premiuminfo) {
                            $premium = $premiuminfo->premium;
                            $premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
//$premi_chal_recpt = $premiuminfo->premium;

                            $innerquery31 = "select chalan_name from premium_chalan_receipt where code='$premi_chal_recpt'";
                            $innerdata31 = $this->db->query($innerquery31)->result();
                            foreach ($innerdata31 as $premiumchalanrecpt) {
                                $chalan_name = $premiumchalanrecpt->chalan_name;
                            }
                        }

                        $innerquery32 = "select premi_chal_recpt, dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
                            . " dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                            . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                            . " rmk_type_hist_no='$rmk_type_hist_no'  ";
                        $innerdata32 = $this->db->query($innerquery32)->result();
                        $applicants = array();
                        foreach ($innerdata32 as $rmk_conv) {
                            $premi_chal_recpt = $rmk_conv->premi_chal_recpt;
                            $dag_no = $rmk_conv->dag_no;
                            $new_patta_no = trim($rmk_conv->new_patta_no);
                            $new_dag_no = $rmk_conv->new_dag_no;
                            $ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;
                            $innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
                                . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
//////echo $innerquery33;
                            $innerdata33 = $this->db->query($innerquery33)->result();
                            foreach ($innerdata33 as $bklconvorder) {
                                $land_area_b = $bklconvorder->land_area_b;
                                $land_area_k = $bklconvorder->land_area_k;
                                $land_area_lc = $bklconvorder->land_area_lc;
                            }
                            $applicants[] = array(
                                'app_name' => $ord_onbehalf_of,
                                'dag_no' => $dag_no,
                                'new_dag_no' => $new_dag_no,
                                'new_patta_no' => $new_patta_no,
                            );
                        }

                        $innerquery34 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'";
//echo $innerquery34;
                        $innerdata34 = $this->db->query($innerquery34)->result();
////echo "<br>$innerquery34";
                        foreach ($innerdata34 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        /* if(($order_passby_designation == 'DC') || ($order_passby_designation == 'ADC'))
                          {
                          $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                          . " and subdiv_code='00' and cir_code='00' and user_code ='$co_code'";
                          }
                          else
                          {
                          $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                          . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                          } */
                        $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata35 = $this->db->query($innerquery35)->result();
                        foreach ($innerdata35 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        if (($premi_chal_recpt != null) && (strlen($premi_chal_recpt) == 3)) {
                            $PremiumType35 = "select chalan_name FROM premium_chalan_receipt where code ='$premi_chal_recpt'";
                            $PremiumType35 = $this->db->query($PremiumType35)->result();
                            foreach ($PremiumType35 as $ptype) {
                                $premium_type = $ptype->chalan_name;
//////var_dump($username);
                            }
                        } else {
                            $premium_type = '';
                        }
                        if ($land_area_b == '') {
                            $land_area_b = '0';
                        }
                        if ($land_area_k == '') {
                            $land_area_k = '0';
                        }
                        if ($land_area_lc == '') {
                            $land_area_lc = '0.00';
                        }
                        $data[] = array(
                            'patta_no' => "$patta_no",
                            'premi_chal_name' => "$premium_type",
                            'patta_type_code' => "$patta_type_code",
                            'patta_type' => "$patta_type",
                            'premium' => "$premium",
                            'premi_chal_recpt_no' => "$premi_chal_recpt_no",
                            'premi_chal_recpt' => "$premi_chal_recpt",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'ord_onbehalf_of' => $applicants,
                            'land_area_b' => "$land_area_b",
                            'land_area_k' => "$land_area_k",
                            'land_area_lc' => "$land_area_lc",
                            'username' => "$username",
                            'lm_name' => "$lm_name",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'chalan_name' => "$chalan_name",
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => '01',
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'ord_passby_desig' => $get_designation
                        );
//var_dump($data);
                    }

                    if ($ord_type_code == "02") {

                        $innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from chitha_rmk_allottee  where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata36 = $this->db->query($innerquery36)->result();
                        $ord_date = "";
                        $dag_no = "";
                        $ord_ref_let_no = "";
                        $allottee_name = "";
                        $allottee_land_code = "";
                        $allottee_land_b = "";
                        $allottee_land_k = "";
                        $allottee_land_lc = "";
                        $type = "";
                        $lm_name = "";
                        $status = "";
                        foreach ($innerdata36 as $allotee) {
                            $ord_date = $allotee->ord_date;
                            $dag_no = $allotee->dag_no;
                            $ord_ref_let_no = $allotee->ord_ref_let_no;
                            $allottee_name = $allotee->allottee_name;
                            $allottee_land_code = $allotee->allottee_land_code;
                            $allottee_land_b = $allotee->allottee_land_b;
                            $allottee_land_k = $allotee->allottee_land_k;
                            $allottee_land_lc = $allotee->allottee_land_lc;

                            $innerquery37 = "select  type from  ord_on_gl_type_code where type_code='$allottee_land_code'";
                            $innerdata37 = $this->db->query($innerquery37)->result();
                            foreach ($innerdata37 as $ord_on_typ) {
                                $type = $ord_on_typ->type;
                            }
                        }


                        $innerquery38 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata38 = $this->db->query($innerquery38)->result();
                        foreach ($innerdata38 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery39 = " select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata39 = $this->db->query($innerquery39)->result();
                        foreach ($innerdata39 as $userinfo) {
                            $username = $userinfo->username;
                        }
                        $data[] = array(
                            'ord_date' => $ord_date,
                            'dag_no' => $dag_no,
                            'ord_ref_let_no' => $ord_ref_let_no,
                            'allottee_name' => $allottee_name,
                            'allottee_land_code' => $allottee_land_code,
                            'allottee_land_b' => $allottee_land_b,
                            'allottee_land_k' => $allottee_land_k,
                            'allottee_land_lc' => $allottee_land_lc,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name
                        );
                    }

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
                            . " new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
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

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from chitha_rmk_ordbasic "
                            . " where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no'";
                        $m_area = $this->db->query($innerquery45)->row();
                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;

                        $data[] = array(
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
                            'order_date' => $order_date
                        );
                    }


                    if ($ord_type_code == "04") {

                        $innerquery45 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata45 = $this->db->query($innerquery45)->result();
                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";
                        $infav = array();
                        foreach ($innerdata45 as $infav_of) {
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
                        } //infav query bracket



                        $innerquery46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata46 = $this->db->query($innerquery46)->result();
                        $lm_name = "";
                        foreach ($innerdata46 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery47 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata47 = $this->db->query($innerquery47)->result();
                        $username = "";
                        $status = "";
                        foreach ($innerdata47 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'bigha' => $m_dag_area_b,
                            'katha' => $m_dag_area_k,
                            'lessa' => $m_dag_area_lc
                        );
                    }

                    if ($ord_type_code == "05") {
                        $innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,case_type_code from chitha_rmk_other_opp_party where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";
                        $name_for = "";
                        $name_for_land_b = "";
                        $name_for_land_k = "";
                        $name_for_land_lc = "";
                        $case_type_code = "";
                        $case_type_name = "";
                        $lm_name = "";
                        $username = "";
                        $status = "";
                        $innerdata48 = $this->db->query($innerquery48)->result();
                        foreach ($innerdata48 as $opp_party) {
                            $name_for = $opp_party->name_for;
                            $name_for_land_b = $opp_party->name_for_land_b;
                            $name_for_land_k = $opp_party->name_for_land_k;
                            $name_for_land_lc = $opp_party->name_for_land_lc;
                            $case_type_code = $opp_party->case_type_code;

                            $innerquery49 = "select case_type_name from case_type_code where case_type_code='$case_type_code'";
                            $innerdata49 = $this->db->query($innerquery49)->result();
                            foreach ($innerdata49 as $casename) {
                                $case_type_name = $casename->case_type_name;
                            }
                        }


//lminf for case 5

                        $innerquery50 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                        $innerdata50 = $this->db->query($innerquery50)->result();
                        foreach ($innerdata50 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery51 = " select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";


                        $innerdata51 = $this->db->query($innerquery51)->result();
                        foreach ($innerdata51 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data[] = array(
                            'name_for' => $name_for,
                            'name_for_land_b' => $name_for_land_b,
                            'name_for_land_k' => $name_for_land_k,
                            'name_for_land_lc' => $name_for_land_lc,
                            'case_type_code' => $case_type_code,
                            'case_type_name' => $case_type_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'order_type_code' => $ord_type_code,
                        );
                    }

                    if ($ord_type_code == "06") {
                        $innerquery52 = "select ord_date,ord_no,by_right_of,infavor_of_corrected_name,user_code,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                            " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen')  and ord_no= '$ord_no' ";

                        $innerdata52 = $this->db->query($innerquery52)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $new_dag_no = "";
                        $new_patta_no = "";

                        foreach ($innerdata52 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;

                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = trim($infav_of->new_patta_no);
                            $co_code = $infav_of->user_code;
                            $ord_date = $infav_of->ord_date;
                        } //infav query bracket



                        $innerquery53 = "select lm_name FROM LM_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";

                        $innerdata53 = $this->db->query($innerquery53)->result();

                        $lm_name = "";
                        foreach ($innerdata53 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }
//echo $lm_name;
                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        $innerdata54 = $this->db->query($innerquery54)->result();
                        $username = "";
                        $status = "";
                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data[] = array(
                            'innerdata52' => $innerdata52,
                            'by_right_of' => $by_right_of,
                            'infavor_of_corrected_name' => $infavor_of_corrected_name,
                            'infavor_of_name' => $infavor_of_name,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'username' => $username,
                            'orderdate' => $ord_date
                        );
                    }

                    if ($ord_type_code == "07") {
                        $innerquery52 = "select ord_date,ord_no,by_right_of,user_code,infavor_of_name  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                            " and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
                        $innerdata52 = $this->db->query($innerquery52)->result();
                        $by_right_of = "";
                        $infavor_of_name = "";
                        $name_delete = '';
                        foreach ($innerdata52 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $co_code = $infav_of->user_code;
                            $ord_date = $infav_of->ord_date;
                        } //infav query bracket

                        $ordparty = "Select name_for from chitha_rmk_other_opp_party where  dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                            " and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
                        $innerdata59 = $this->db->query($ordparty)->result();
                        foreach ($innerdata59 as $ordparty) {
                            $name_delete = $ordparty->name_for;
                        } //infav query bracket

                        $innerquery53 = "select lm_name FROM LM_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";

                        $innerdata53 = $this->db->query($innerquery53)->result();

                        $lm_name = "";
                        foreach ($innerdata53 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }
//echo $lm_name;
                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        $innerdata54 = $this->db->query($innerquery54)->result();
                        $username = "";
                        $status = "";
                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }
                        $data['namecancel'] = array(
                            'by_right_of' => $by_right_of,
                            'order_no' => $ord_no,
                            'name_delete' => $name_delete,
                            'infavor_of_name' => $infavor_of_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'username' => $username,
                            'orderdate' => $ord_date
                        );
                    }
                }
            }
//for remark type code 02
            if ($rmk_type_code == '02') {
                $innerquery56 = "select  lm_note,lm_note_date,lm_code FROM chitha_rmk_lmnote where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";

                $innerdata56 = $this->db->query($innerquery56)->result();
                foreach ($innerdata56 as $lmnote) {
                    $lm_note = $lmnote->lm_note;
                    $lm_note_date = $lmnote->lm_note_date;
                    $lm_code = $lmnote->lm_code;
                }
                /*
                  $lmnote02 = array(
                  'lm_note' => $lm_note,
                  'lm_note_date' => $lm_note_date,
                  'lm_code' => $lm_code
                  );
                  $data['lmnote02'] = $lmnote02;
                 */
            }

//

            if ($rmk_type_code == '03') {



                $innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";


                $innerdata57 = $this->db->query($innerquery57)->result();

                foreach ($innerdata57 as $sknoteinf) {

                    $sk_note = $sknoteinf->sk_note;
                    $sk_note_date = $sknoteinf->sk_note_date;
                }
            }

            if ($rmk_type_code == '04') {

                $innerquery58 = "SELECT encro_evicted_yn,encro_name FROM chitha_rmk_encro where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";

                $innerdata58 = $this->db->query($innerquery58)->result();
                foreach ($innerdata58 as $encro) {
                    $encro_evicted_yn = $encro->encro_evicted_yn;
                    $encro_name = $encro->encro_name;
                }
            }
//reclassification

            if ($rmk_type_code == '08') {

                $innerquery59 = "SELECT patta_no,patta_type_code,present_land_class,proposed_land_class,proposed_land_revenue,proposed_land_localtax, revenue_diff,"
                    . "dc_approval_date, case_no, dag_no FROM chitha_rmk_reclassification where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";

                $innerdata59 = $this->db->query($innerquery59)->result();

                foreach ($innerdata59 as $reclass) {
                    $present_class = $this->db->query("Select land_type from landclass_code where class_code = '$reclass->present_land_class'")->row()->land_type;
                    $proposed_class = $this->db->query("Select land_type from landclass_code where class_code = '$reclass->proposed_land_class'")->row()->land_type;
                    $patta_no = trim($reclass->patta_no);
                    $patta_type_code = $reclass->patta_type_code;
                    $present_land_class = $present_class;
                    $proposed_land_class = $proposed_class;
                    $proposed_land_revenue = $reclass->proposed_land_revenue;
                    $proposed_land_localtax = $reclass->proposed_land_localtax;
                    $revenue_diff = $reclass->revenue_diff;
                    $dc_approval_date = $reclass->dc_approval_date;
                    $remark_type_code = $rmk_type_code;
                    $ord_type_code = '00';
                    $case_no = $reclass->case_no;
                    $dag_no = $reclass->dag_no;

                    $data[] = array(
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type_code,
                        'present_land_class' => $present_land_class,
                        'proposed_land_class' => $proposed_land_class,
                        'proposed_land_revenue' => $proposed_land_revenue,
                        'proposed_land_localtax' => $proposed_land_localtax,
                        'revenue_diff' => $revenue_diff,
                        'dc_approval_date' => $dc_approval_date,
                        'remark_type_code' => $remark_type_code,
                        'ord_type_code' => $ord_type_code,
                        'case_no' => $case_no,
                        'dag_no' => $dag_no
                    );
                }
//$data['reclass'][] = $reclass;
//var_dump($data['reclass']);
            }

            if ($rmk_type_code == '09') {

                $innerquery69 = "select * FROM apt_chitha_rmk_ordbasic as apt,apcancel_dag_details as ap where apt.dist_code='$district_code' "
                    . " and apt.subdiv_code='$subdivision_code' and apt.cir_code='$circlecode' and apt.case_no = ap.case_no and"
                    . " apt.mouza_pargona_code='$mouzacode' and  apt.lot_no='$lot_code' and apt.vill_townprt_code='$village_code' and apt.dag_no ='$dagnoRemarkgen'";

                $innerdata69 = $this->db->query($innerquery69)->result();

                foreach ($innerdata69 as $apcancel) {
                    $patta_no = trim($apcancel->patta_no);
                    $order_date = $apcancel->co_ord_date;
                    $remark_type_code = $rmk_type_code;
                    $ord_type_code = '00';
                    $case_no = $apcancel->case_no;
                    $dag_no = $apcancel->dag_no;
                    $lm_code = $apcancel->lm_code;
                    $co_code = $apcancel->co_code;
                    $final_date = $apcancel->iscorrected_inco_date;
                }

                $innerqueryLM46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
                $innerqueryLM46 = $this->db->query($innerqueryLM46)->result();
                $lm_name = "";
                foreach ($innerqueryLM46 as $lminfo) {
                    $lm_name = $lminfo->lm_name;
                }

                $innerqueryCO47 = "select username FROM users where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                $innerqueryCO47 = $this->db->query($innerqueryCO47)->row();
                $username = "";
                $apcancel = array(
                    'patta_no' => $patta_no,
                    'order_date' => $order_date,
                    'remark_type_code' => $remark_type_code,
                    'ord_type_code' => $ord_type_code,
                    'case_no' => $case_no,
                    'dag_no' => $dag_no,
                    'lm_name' => $lm_name,
                    'username' => $innerqueryCO47->username,
                    'final_date' => $final_date
                );
                $data['apcancel'] = $apcancel;
            }
//for remark type code 10
            if ($rmk_type_code == '10') {
                $innerquery59 = "select ord_no,allottee_land_b,allottee_land_k,allottee_land_lc,allottee_name,date_entry, old_dag,patta_no,dag_no FROM chitha_rmk_allottee where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no'  ";
                $innerdata59 = $this->db->query($innerquery59)->result();
                $q = "Select lm_code,co_code from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();
//var_dump($lmco);
                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
//var_dump($lm_name);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);
//var_dump($username);
                $ord_type_code = 10;
                foreach ($innerdata59 as $allotee) {
                    $ord_no = $allotee->ord_no;
                    $allottee_land_b = $allotee->allottee_land_b;
                    $allottee_land_k = $allotee->allottee_land_k;
                    $allottee_land_lc = $allotee->allottee_land_lc;
                    $allottee_name = $allotee->allottee_name;
                    $date_entry = $allotee->date_entry;
                    $olddag = $allotee->old_dag;
                    $patta = $allotee->patta_no;
                    $dag = $allotee->dag_no;
                }
                $actopp = array(
                    'ord_no' => $ord_no,
                    'history_no' => $rmk_type_hist_no,
                    'old_dag' => $olddag,
                    'new_dag' => $dag,
                    'new_patta' => $patta,
                    'ord_type_code' => $ord_type_code,
                    'remark_type_code' => $rmk_type_code,
                    'allottee_land_b' => $allottee_land_b,
                    'allottee_land_k' => $allottee_land_k,
                    'allottee_land_lc' => $allottee_land_lc,
                    'allottee_name' => $allottee_name,
                    'date_entry' => $date_entry,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                );
                $data['allotee'] = $actopp;
            }
        }
        return $data;
    }

    public function getcol8($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no, $patta_code) {
        $data1 = array();
        $innerquery4 = "select col8order_cron_no,order_type_code,user_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,"
            . "co_ord_date,deed_reg_no,deed_value,deed_date from Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
            . "and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no='$dag_no' ) ";

        $innerdata4 = $this->db->query($innerquery4)->result();

// this is the start to col8 order details
        foreach ($innerdata4 as $col8OrderDetails) {
//var_dump($col8OrderDetails);
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
            $innerquery5 = "select order_type from master_field_mut_type where  order_type_code = '$order_type_code' ";
            $innerdata5 = $this->db->query($innerquery5)->row();
            $ordertype = $innerdata5->order_type;
            $innerquery6 = "select inplace_of_name,inplaceof_alongwith from chitha_col8_inplace where dist_code='$district_code' and subdiv_code='$subdivision_code' "
                . "and cir_code='$circlecode' and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' "
                . "and Col8Order_cron_no='$col8order_cron_no' ORDER BY inplace_of_id";

            $innerdata6 = $this->db->query($innerquery6)->result();
            $inplace_data = array();

            $innerquery7 = "select trans_desc_as from nature_trans_code where trans_code = '$nature_trans_code'";
            foreach ($innerdata6 as $inplace) {
                $inplace_data[] = array(
                    'inplace_of_name' => $inplace->inplace_of_name,
                    'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                );
            }

            $occup_data = array();
            $innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from "
                . " chitha_col8_occup where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                . " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no'   ORDER BY occupant_id";

            $innerdata8 = $this->db->query($innerquery8)->result();

            foreach ($innerdata8 as $occupant) {
                $occupant_name = $occupant->occupant_name;
                $occupant_fmh_name = $occupant->occupant_fmh_name;
                $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                $new_patta_no = trim($occupant->new_patta_no);
                $new_dag_no = $occupant->new_dag_no;
                $hus_wife = $occupant->hus_wife;

                $innerquery9 = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$occupant_fmh_flag'";
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

            $innerquery10 = "select lm_name from lm_code  where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
//echo $innerquery10;
            $innerdata10 = $this->db->query($innerquery10)->result();


            foreach ($innerdata10 as $lm) {
                $lm_name = $lm->lm_name;
            }

            if ($user_code != 'admn') {
                $innerquery11 = "select username,status from users where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";

                $innerdata11 = $this->db->query($innerquery11)->result();
                if ($innerdata11) {
                    foreach ($innerdata11 as $users) {
                        $username = $users->username;
                        $status = $users->status;
                    }
                } else {
                    $username = '';
                    $status = 'O';
                }
            } else {
                $username = '';
                $status = 'O';
            }

            $innerquery12 = "select * from field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' ";
            $innerdata12 = $this->db->query($innerquery12)->result();

            foreach ($innerdata12 as $objection) {
//var_dump($objection);
                $q = "select col8order_cron_no,dag_no from chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
                $col8_cronNo = $this->db->query($q)->row();
                $q = "select occupant_name from chitha_col8_occup where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and 
							col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
                $result = $this->db->query($q)->result();
                $fname = " ";
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

            $innerquery13 = "select * from field_mut_petitioner where case_no='$case_no' ";
            $innerdata13 = $this->db->query($innerquery13)->result();

            if ($order_type_code == '01') {

                $innerquery14 = " select deed_reg_no,deed_value,deed_date from chitha_col8_order
                      where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
//echo $innerquery14;	
                $innerdata14 = $this->db->query($innerquery14)->result();
                foreach ($innerdata14 as $deedinf) {
                    $deed_reg_no = $deedinf->deed_reg_no;
                    $deed_value = $deedinf->deed_value;
                    $deed_date = $deedinf->deed_date;
                }
            }

////echo $col8OrderDetails->co_ord_date;

            $data1[$dag_no]['col8'][] = array(
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
                'username' => $username
            );
        }
        return $data1;
    }

    public function getcol9($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no, $patta_code, $patta_no) {
        $data1 = array();
        $innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from chitha_dag_pattadar where dist_code='$district_code' and subdiv_code='$subdivision_code' "
            . "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' and "
            . "TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";

        $innerdata = $this->db->query($innerquery)->result();

        $data1[$dag_no]['pattadars'] = array();
        foreach ($innerdata as $data) {
            $pdar_id = $data->pdar_id;
            $patta_no = trim($data->patta_no);

            $data1[$dag_no]['tenant'] = array();
            $data1[$dag_no]['subtenant'] = array();
            $innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from chitha_pattadar where dist_code='$district_code' "
                . "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                . "and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
            $innerdata2 = $this->db->query($innerquery2)->result();

            foreach ($innerdata2 as $pdardata) {
                $pdar_guardRelation = $pdardata->pdar_guard_reln;
                $innerquery3 = "select * from master_guard_rel where guard_rel = '$pdar_guardRelation'";
                $innerdata3 = $this->db->query($innerquery3)->result();

                foreach ($innerdata3 as $guard_rel_desc) {
                    $relation = $guard_rel_desc->guard_rel_desc_as;
                }


                $data1[$dag_no]['pattadars'][] = array(
                    'p_flag' => $data->p_flag,
                    'dag_por_b' => $data->dag_por_b,
                    'dag_por_k' => $data->dag_por_k,
                    'dag_por_lc' => $data->dag_por_lc,
                    'pdar_name' => $pdardata->pdar_name,
                    'guard_reln_desc_as' => $relation,
                    'new_pdar_name' => $pdardata->new_pdar_name,
                    'pdar_father' => $pdardata->pdar_father,
                    'pdar_relation' => $pdardata->pdar_guard_reln,
                    'pdar_address1' => $pdardata->pdar_add1,
                    'pdar_address2' => $pdardata->pdar_add2,
                    'pdar_address3' => $pdardata->pdar_add3,
                    'pdar_guard_reln' => $pdardata->pdar_guard_reln,
                    'pdar_id' => $pdar_id
                );
            }





            $innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,tenants_add3,type_of_tenant,khatian_no,revenue_tenant,crop_rate,tenant_id,status from chitha_tenant where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' order by tenant_id";

            $innerdata15 = $this->db->query($innerquery15)->result();

            foreach ($innerdata15 as $tenant) {


                if ($tenant->type_of_tenant == null) {
                    $tenant_typ = "00";
                } else {
                    $tenant_typ = $tenant->type_of_tenant;
                }
                $tenant_name = $tenant->tenant_name;
                $tenants_father = $tenant->tenants_father;
                $tenants_add1 = $tenant->tenants_add1;
                $tenants_add2 = $tenant->tenants_add2;
                $tenants_add3 = $tenant->tenants_add3;
                $type_of_tenant = $tenant_typ;
                $khatian_no = $tenant->khatian_no;
                $status = $tenant->status;
                $revenue_tenant = $tenant->revenue_tenant;
                $crop_rate = $tenant->crop_rate;
                $tenant_id = $tenant->tenant_id;

                if ($tenant->type_of_tenant == null) {
                    $tenant_typ = "00";
                } else {
                    $tenant_typ = $tenant->type_of_tenant;
                }
                $tenant_name = $tenant->tenant_name;
                $tenants_father = $tenant->tenants_father;
                $tenants_add1 = $tenant->tenants_add1;
                $tenants_add2 = $tenant->tenants_add2;
                $tenants_add3 = $tenant->tenants_add3;
                $type_of_tenant = $tenant_typ;
                $khatian_no = $tenant->khatian_no;
                $status = $tenant->status;
                $revenue_tenant = $tenant->revenue_tenant;
                $crop_rate = $tenant->crop_rate;
                $tenant_id = $tenant->tenant_id;

                if ($tenant->type_of_tenant == "00") {
                    $tenant_typ = "";
                } else {
                    $tenant_typ = $tenant->type_of_tenant;
                }
                $tenant_name = $tenant->tenant_name;
                $tenants_father = $tenant->tenants_father;
                $tenants_add1 = $tenant->tenants_add1;
                $tenants_add2 = $tenant->tenants_add2;
                $tenants_add3 = $tenant->tenants_add3;
                $type_of_tenant = $tenant_typ;
                $khatian_no = $tenant->khatian_no;
                $status = $tenant->status;
                $revenue_tenant = $tenant->revenue_tenant;
                $crop_rate = $tenant->crop_rate;
                $tenant_id = $tenant->tenant_id;


                $innerquery16 = "Select tenant_type from Tenant_type where type_code ='$type_of_tenant'";
                $innerdata16 = $this->db->query($innerquery16)->result();

                foreach ($innerdata16 as $tenanttype) {
                    $tenant_type = $tenanttype->tenant_type;


                    $data1[$dag_no]['tenant'][] = array(
                        'tenant_name' => $tenant->tenant_name,
                        'tenants_father' => $tenant->tenants_father,
                        'tenants_add1' => $tenant->tenants_add1,
                        'tenants_add2' => $tenant->tenants_add2,
                        'tenants_add3' => $tenant->tenants_add3,
                        'type_of_tenant' => $tenant->type_of_tenant,
                        'khatian_no' => $tenant->khatian_no,
                        'status' => $tenant->status,
                        'revenue_tenant' => $tenant->revenue_tenant,
                        'crop_rate' => $tenant->crop_rate,
                        'tenant_type' => $tenanttype->tenant_type,
                    );
                }


                $innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from Chitha_Subtenant where  dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";

                $innerdata17 = $this->db->query($innerquery17)->result();
                $subtenant_name = "";
                $subtenants_father = "";
                $subtenants_add1 = "";
                $subtenants_add2 = "";
                $subtenants_add = "";
                foreach ($innerdata17 as $subtenant) {
                    $subtenant_name = $subtenant->subtenant_name;
                    $subtenants_father = $subtenant->subtenants_father;
                    $subtenants_add1 = $subtenant->subtenants_add1;
                    $subtenants_add2 = $subtenant->subtenants_add2;
                    $subtenants_add3 = $subtenant->subtenants_add3;

                    $data1[$dag_no]['subtenant'][] = array(
                        'subtenant_name' => $subtenant->subtenant_name,
                        'subtenants_father' => $subtenant->subtenants_father,
                        'subtenants_add1' => $subtenant->subtenants_add1,
                        'subtenants_add2' => $subtenant->subtenants_add2,
                        'subtenants_add3' => $subtenant->subtenants_add3,
                    );
                }
            }
        }

        return $data1;
    }
    function  passwordreset(){

            // Allowed designations
        $allowed = ['CO', 'DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $dist_code = $this->session->userdata('dist_code');
        $suvdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $user_desig_code=$this->session->userdata('user_desig_code');


        if($user_desig_code=='ADC' || $user_desig_code=='SDO')
        {
            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and ((user_code like 'CO%') or (user_code like 'BO%') or (user_code like 'SDLC%')) and dis_enb_option='E' " )->result();
        }

        elseif ($user_desig_code=='DC') {

            $users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and cir_code = '00' and user_code like 'ADC%' and dis_enb_option='E'")->result();
        }
        elseif ($user_desig_code=='CO') {
            $users = $this->db->query("Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist_code' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code NOT LIKE 'CO%' and priv='mut' Order By cir_code")->result();
        }



        // $users = $this->db->query("Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist_code' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code NOT LIKE 'CO%' and priv='mut' Order By cir_code")->result();
        //$users = $this->db->query("SELECT * from loginuser_table where dist_code='$dist_code' and dis_enb_option='E' and (user_code like 'AS%' or user_code like 'CO%' or user_code like 'LM%' or user_code like 'SK%') ")->result();

        foreach ($users as $u) {
            $dist_code = $u->dist_code;
            $subdiv_code = $u->subdiv_code;
            $cir_code = $u->cir_code;
            $mouza_pargona_code = $u->mouza_pargona_code;
            $lot_no = $u->lot_no;
            $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $c = $this->db->query($q)->row()->c;
            if (($dist_code!='00') and ($subdiv_code!='00') and ($cir_code!='00') and ($lot_no=='00')) {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = $u->user_code . " May Be JUNK A/C";
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'password' => $u->prev_password1,
                );
                $abc[] = $re;
            }
            else if(($mouza_pargona_code!='00') and ($lot_no!='00')) {

                //echo "Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'
                //and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ";
                $result_data = $this->db->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'
                and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'   ")->row();
                //$desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                $designation = ' ভূমিলেখ্য সহায়ক';
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
                if($result_data){
                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $designation,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no,
                        'password' => $u->prev_password1,
                    );
                }
                $abc[] = $re;
            }


            else if ($c == 1) {
                $result_data = $this->db->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();

                $desg = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                if (empty($desg)) {
                    $designation = 'Admin';
                } else {
                    $designation = $desg->user_desig_as;
                }
                $role = $this->db->query("Select * from privilege where priv_code = '$u->priv'")->row();
//echo "Select * from privilege where priv_code = '$u->priv'";
                $re = array(
                    'name' => $result_data->username,
                    'desig' => $designation,
                    'primary_login' => $u->use_name,
                    'role' => $role->priv_desc,
                    'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                    'status' => $u->dis_enb_option,
                    'user_code' => $u->user_code,
                    'dist_code' => $u->dist_code,
                    'subdiv_code' => $u->subdiv_code,
                    'cir_code' => $u->cir_code,
                    'mouza_pargona_code' => $u->mouza_pargona_code,
                    'lot_no' => $u->lot_no,
                    'password' => $u->prev_password1,
                );
                $abc[] = $re;

            }

        }
        //var_dump($abc);
        $data['user_details'] = $abc;

        //$this->session->set_flashdata('message','Password has been reset');
        // redirect('/home');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/initialization/passwordreset', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'initialization/passwordreset';
        $this->load->view('layouts/main',$data);
    }

    Public function passwordreset_dio() {
        $dist_code = $this->session->userdata('dist_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);

        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );

        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;


        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
//echo $query;
        $data['subdiv'] = $query->result();
//var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code != 'ADM1' Order By cir_code"; //and user_code LIKE 'CO%' 
            $users = $this->dbb->query($all_users)->result();

            foreach ($users as $u) {
                $dist_code = $u->dist_code;
                $subdiv_code = $u->subdiv_code;
                $cir_code = $u->cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;

                $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;
                if ($c == 0) {
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                    $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
// now we need to check if the coprresponding sk is old. if yes than assign the new enabled sk
                    $check_sk = $this->db->query("Select count(*) as check_sk from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
                        . "cir_code = '$cir_code' and user_code = '$result_data->corres_sk_code' and dis_enb_option = 'E'")->row()->check_sk;
                    $prriv = trim($u->priv);
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                    $password = $u->prev_password1;

                    if ((substr($result_data->corres_sk_code, 0, 2) === 'SK')) {
                        $corres_sk_code = $result_data->corres_sk_code;
                    } else {
                        $corres_sk_code = '00';
                    }

                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);    
                } else {

                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    $password = $u->prev_password1;
                    $corres_sk_code = '01';
                    $check_sk = '01';
                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        'password' => $password,
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => $u->lot_no,
                        'corres_sk_code' => $corres_sk_code,
                        'sk_mapping' => $check_sk
                    );
//var_dump($re);
                }
                $abc[] = $re;
            }
            $data['user_details'] = $abc;
        } else {
            $data['user_details'] = '';
        }
//var_dump($data);
        // $this->load->view('header');
        // $this->load->view('initialization/passwordreset_dio', $data);
        // $this->load->view('footer');

        $data['_view'] = 'initialization/passwordreset_dio';
        $this->load->view('layouts/main',$data);
    }
    /////////////API CALL for user ILRMS user///////////////////
    function apiCalForIlrmsMouUser($usercode,$desig){
        // if(isset($_POST['user_type'])){
        //     $Type=$this->input->post('user_type');
        // }else{
        //     $Type='NA';
        // }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code')==null?'00':$this->input->post('subdiv_code'),
                'cir_code' =>  $this->input->post('circle_code')==null?'00':$this->input->post('circle_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code')==null?'00':$this->input->post('mouza_code'),
                'name' => $this->input->post('name'),
                'user_name' => $this->input->post('user_name'),
                'mobile_no' => $this->input->post('phone_no'),
                'designation'=>$desig,
                'lot_no'=>$this->input->post('lot_no')==null?'00':$this->input->post('lot_no'),
                'password'=>$this->input->post('new_pass'),
                'user_code' => $usercode,
                'email' => $this->input->post('emailID'),
                'type' =>$this->input->post('user_type')==null?'NA':$this->input->post('user_type'),
                'address' => '--',
                'display_name' => $this->input->post('display_name'),
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response_obj = json_decode($response);
        log_message('error',"APIfromBasundhara:".$response);
        if($httpcode == 200){
            $response_obj = json_decode($response);
            if($response_obj->result == "Y"){
                //echo json_encode(['result' => 'SUCCESS', 'msg' => "Mouzdar Added Successfully..!!"]);
                return $response;
            }elseif($response_obj->result == "USER_EXISTS"){
                return $response;
            }elseif($response_obj->result == "N"){
                return $response;
            }else{
                log_message("error", "#EKCRLMOU0001, Curl Error(Y) In Api ".EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API);
                echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLMOU0001");
                return $response;
            }
            curl_close($curl);
        }else{
            log_message("error", "#EKCRLMOU0002, Curl Error(200) In Api ".EKHAJANA_DOWNLOAD_MOUZADAR_ADD_API);
            //echo json_encode("Internal Server Error, Please Try Again Later..., Error Code #EKCRLMOU0002");
            show_error("Internal Server Error, Please Try Again Later..., Error Code #EKCRLMOU0002","401",$heading="Error-500");
            return;
        }
    }
    function getUsersInfo($uniqueUserId){
        $sql="Select u.*,lg.use_name from users u join loginuser_table lg on u.dist_code=lg.dist_code
        and u.subdiv_code=lg.subdiv_code and u.cir_code=lg.cir_code and u.user_code=lg.user_code  where lg.use_name=?";
        $data=$this->db->query($sql,array($uniqueUserId));
        log_message('error',$this->db->last_query());
        if($data->num_rows()==0){
            echo json_encode(array(
                'msg'=>'NO DATA FOUND/ERROR IN PROCESSING',
                'response'=>1
            ));
            return;
        }
        $result_data=$data->row_array();
        echo json_encode(array(
            'msg'=>$result_data,
            'response'=>2
        ));
        return;
    }
    function getSelectedCircle($user_code){
        $data = array();
        $sql="Select concat(dist_code,'-',subdiv_code,'-',cir_code) as loc1 from user_attached_mapping where user_code = ? ";
        $data1=$this->db->query($sql,array($user_code));
        log_message('error',$this->db->last_query());
        if($data1->num_rows()==0){
            $data['error'] = array(
                'msg'=>'NO DATA FOUND/ERROR IN PROCESSING',
                'response'=>1
            );
        }
        $result_data=$data1->result();
        $dist_head=$this->db->query("select concat(dist_code,'-',subdiv_code,'-',cir_code) as loc,loc_name 
                from location where subdiv_code in 
                (select subdiv_code from location where district_headquater is not null) 
                and cir_code<>'00' and mouza_pargona_code='00'")->result_array();
        foreach($dist_head as $key=>$val){
            $isInArray = in_array($val['loc'], array_column($result_data, 'loc1'));
            if($isInArray == true){
                $dist_head[$key]['checked'] = 'y';
            }else{
                $dist_head[$key]['checked'] = 'n';
            }

        }
        $data['dist_head'] = $dist_head;
        $this->load->view('initialization/update_mapping',$data);

    }
    function updateInformation(){
        // var_dump($_POST);
        $name=$this->input->post('name');
        $dname=$this->input->post('dname');
        $email=$this->input->post('email');
        $mobile=$this->input->post('mobile');
        $dist_code=$this->input->post('dist_code');
        $user_code=$this->input->post('user_code');
        $user_type=$this->input->post('user_type');
        $unique_id_post=$this->input->post('unique_id_post');
        $sql="Select * from users where dist_code=? and user_code=?";
        $data=$this->db->query($sql,array($dist_code,$user_code));
        $this->db->trans_begin();
        if($data->num_rows()==1){
            $array=array(
                'display_name'=>$dname,
                'phone_no'=>$mobile,
                'user_type'=>$user_type,
            );
            $this->db->where('dist_code',$dist_code);
            $this->db->where('user_code',$user_code);
            $this->db->update('users',$array);
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                echo json_encode(array('response'=>2,'error'=>'API Error-401'));
                return;
            }
            /////////////////////////////
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => SDLC_MOUZADAR_PASSWORD."updateProfile",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'unique_user_id' => $unique_id_post,
                    'type' => $user_type,
                    'dist_code' => $dist_code,
                    'display_name'=>$dname,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response_obj = json_decode($response);
            log_message('error',"APIfromBasundhara:".$response);
            if($httpcode == 200){
                $response_obj = json_decode($response);
                if($response_obj->result == "N"){
                    $this->db->trans_rollback();
                    echo json_encode(array('response'=>2,'error'=>'API Error-401'));
                    return;
                }
                curl_close($curl);
            }
            $this->db->trans_commit();
            echo json_encode(array('response'=>1,'msg'=>'Updated Successfully'));
            return;
            ////////////////////////////
        }
    }

    /////SRO creation from DC end///////////
    public function srouser() {
            // Allowed designations
        $allowed = ['DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $data['_view'] = 'initialization/srouserform';
        $this->load->view('layouts/main',$data);
    }
    public function create() {
        // Load the create_log view
        $this->load->view('initialization/create_log');
    }
    function updateattchedCircle(){
        // var_dump($_POST);
        for($i=0;$i<count($this->input->post('adc-attached'));$i++)
        {
            $circle_lists=explode('-', $_POST['adc-attached'][$i]);
            $attached=
                [
                    // 'username' => $this->input->post('name'),
                    'user_code' => $this->input->post('adc_user'),
                    'dist_code' =>$circle_lists[0],
                    'subdiv_code' =>$circle_lists[1],
                    'cir_code' =>$circle_lists[2],
                ];
            $this->db->insert('user_attached_mapping',$attached);
            if($this->db->affected_rows()!=1){
                log_message('error',"##ADC-MAPPED001".$this->dbb->last_query());
                $this->db->trans_rollback();
                echo json_encode(array('response'=>2,'error'=>'Error in new circle-mapping'));
                return;
            }
        }
        echo json_encode(array('response'=>1,'msg'=>'Updated Successfully'));
        return;
    }
    function updateattchedCO(){
        if(empty($_POST['allot_lot'])){
            echo json_encode(array('response'=>2,'error'=>'Lot Not selected'));
            return;
        }
        $rollback=false;
        $lists=explode('-',$_POST['allot_lot'][0]);
        $this->db->trans_begin();
        ///////Remove previous record///////
        $cocode=$this->input->post('co_user');
        $sql1="Delete from user_attached_mapping where user_code=? and dist_code=? and subdiv_code=? and cir_code=?
        ";
        $this->db->query($sql1,array($this->input->post('co_user'),$lists[0],$lists[1],$lists[2]));
        log_message('error',"DELETEAPI001".$this->db->last_query());
        ////////////////////

        for($i=0;$i<count($this->input->post('allot_lot'));$i++)
        {
            $circle_lists=explode('-', $_POST['allot_lot'][$i]);
            $attached=
                [
                    // 'username' => $this->input->post('name'),
                    'user_code' => $this->input->post('co_user'),
                    'dist_code' =>$circle_lists[0],
                    'subdiv_code' =>$circle_lists[1],
                    'cir_code' =>$circle_lists[2],
                    'mouza_pargona_code' =>$circle_lists[3],
                    'lot_no' =>$circle_lists[4],
                ];
            //////////////Checking already mapped
            $sql="Select * from user_attached_mapping uam
                join loginuser_table lg on
                uam.dist_code=lg.dist_code and uam.subdiv_code=lg.subdiv_code and uam.cir_code=lg.cir_code and uam.user_code=lg.user_code 
                where lg.dis_enb_option='E' and uam.dist_code=? and uam.subdiv_code=? and uam.cir_code=?
                and uam.mouza_pargona_code=? and uam.lot_no=? ";
            $data=$this->db->query($sql,array($circle_lists[0],$circle_lists[1],$circle_lists[2],$circle_lists[3],$circle_lists[4]));
            log_message('error',"##CO-MAPPED111".$this->db->last_query());
            if($data->num_rows()>0){
                $rollback=true;
                log_message('error',"##CO-MAPPED111".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(array('response'=>2,'error'=>'Lot already mapped'));
                return;
            }
            $this->db->insert('user_attached_mapping',$attached);
            if($this->db->affected_rows()!=1){
                $rollback=true;
                log_message('error',"##CO-MAPPED001".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(array('response'=>2,'error'=>'Error in new Lot-mapping'));
                return;
            }
        }
        if($rollback==false){
            $this->db->trans_commit();
            echo json_encode(array('response'=>1,'msg'=>'Updated Successfully'));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('response'=>2,'msg'=>'Error found'));
            return;
        }

    }

    function updateattchedADC(){
        if(empty($_POST['allot_circle'])){
            echo json_encode(array('response'=>2,'error'=>'Circle Not selected'));
            return;
        }
        $rollback=false;
        $lists=explode('-',$_POST['allot_circle'][0]);
        $this->db->trans_begin();
        ///////Remove previous record///////
        $cocode=$this->input->post('adc_user');
        $sql1="Delete from user_attached_mapping where user_code=?";
        $this->db->query($sql1,array($this->input->post('adc_user')));
        //log_message('error',"MB:01--DELETEAPI001".$this->db->last_query());
        ////////////////////

        for($i=0;$i<count($this->input->post('allot_circle'));$i++)
        {
            $circle_lists=explode('-', $_POST['allot_circle'][$i]);
            $attached=
                [
                    // 'username' => $this->input->post('name'),
                    'user_code' => $this->input->post('adc_user'),
                    'dist_code' =>$circle_lists[0],
                    'subdiv_code' =>$circle_lists[1],
                    'cir_code' =>$circle_lists[2],
                    'mouza_pargona_code' =>$circle_lists[3],
                    'lot_no' =>$circle_lists[4],
                ];

            //////////////Checking already mapped
            $sql="Select uam.* from user_attached_mapping uam
                join loginuser_table lg on
                uam.dist_code=lg.dist_code and uam.user_code=lg.user_code 
                where lg.dis_enb_option='E' and uam.dist_code=? and uam.subdiv_code=? and uam.cir_code=?
                and uam.mouza_pargona_code=? and uam.lot_no=? ";
            $mappedResult =$this->db->query($sql,array($circle_lists[0],$circle_lists[1],$circle_lists[2],$circle_lists[3],$circle_lists[4]));
            log_message('error',"MB:02--CO-MAPPED11121".$this->db->last_query());
            if($mappedResult->num_rows()>0){
                $circleListAlreadyMapped = null;
                $mappedCircleList = $mappedResult->result();
                foreach ($mappedCircleList as $key => $value) {
                    $circleListAlreadyMapped.= $this->utilityclass->getCircleName($value->dist_code, $value->subdiv_code, $value->cir_code);
                }
                $rollback=true;
                // log_message('error',"MB:03--CO-MAPPED111".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(array('response'=>3,'error'=>'ERROR001:Circle already mapped','circles' => $circleListAlreadyMapped));
                return;
            }
            $this->db->insert('user_attached_mapping',$attached);
            //log_message('error',"MB:02--CO-MAPPED11122".$this->db->last_query());    
            if($this->db->affected_rows()!=1){
                $rollback=true;
                //log_message('error',"MB:04--CO-MAPPED00123".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(array('response'=>1,'error'=>'ERROR002:Error in new Circle-mapping'));
                return;
            }
        }
        if($rollback==false){
            $this->db->trans_commit();
            echo json_encode(array('response'=>2,'msg'=>'SUCCESS001 :Updated Successfully'));
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(array('response'=>1,'msg'=>'ERROR003: Error found'));
            return;
        }

    }
    function assginLotCO($user_code,$d,$s,$c){
        $data = array();
        $sql="Select concat(dist_code,'-',subdiv_code,'-',cir_code,'-',mouza_pargona_code,'-',lot_no) as loc1 from user_attached_mapping where user_code = ? and dist_code=? and subdiv_code=? and cir_code=? ";
        $data1=$this->db->query($sql,array($user_code,$d,$s,$c));
        // log_message('error',$this->db->last_query());
        // if($data1->num_rows()==0){
        //     $data['error'] = array(
        //         'msg'=>'NO DATA FOUND/ERROR IN PROCESSING',
        //         'response'=>1
        //     );
        // }
        $result_data=$data1->result();
        $data['coname']=$this->utilityclass->getSelectedCOName($d,$s,$c,$user_code);
        $dist_head=$this->db->query("select concat((select loc_name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code =t.mouza_pargona_code and lot_no='00' ),'-',loc_name) as mapping,
            concat(t.dist_code,'-',t.subdiv_code,'-',t.cir_code,'-',t.mouza_pargona_code,'-',t.lot_no) as 
            loc
            from location t where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code='00000' order by mouza_pargona_code,lot_no",array($d,$s,$c))->result_array();

        foreach($dist_head as $key=>$val){
            $isInArray = in_array($val['loc'], array_column($result_data, 'loc1'));
            if($isInArray == true){
                $dist_head[$key]['checked'] = 'y';
            }else{
                $dist_head[$key]['checked'] = 'n';
            }

        }
        $data['dist_head'] = $dist_head;
        // var_dump($data);
        $this->load->view('initialization/update_lotmapping',$data);
    }

    function assginCircleADC($user_code,$d,$s,$c){
        $data = array();
        $sql="Select concat(dist_code,'-',subdiv_code,'-',cir_code,'-',mouza_pargona_code,'-',lot_no) as loc1 from user_attached_mapping where user_code = ?";
        $data1=$this->db->query($sql,array($user_code));
        //log_message('error','MB01:--ALREADY MAPPED--'.$this->db->last_query());

        $result_data=$data1->result();

        $data['coname']=$this->utilityclass->getSelectedCOName($d,$s,$c,$user_code);
        $dist_head=$this->db->query("select concat((select loc_name from location where dist_code=t.dist_code and subdiv_code=t.subdiv_code and cir_code='00'),'-',loc_name) as mapping,
            concat(t.dist_code,'-',t.subdiv_code,'-',t.cir_code,'-',t.mouza_pargona_code,'-',t.lot_no) as 
            loc
        from location t where dist_code=? and subdiv_code!=? and cir_code!=? and mouza_pargona_code ='00'  and lot_no='00' and vill_townprt_code='00000' order by mouza_pargona_code,lot_no",array($d,$s,$c))->result_array();
        //log_message('error','--user_astt--'.$this->db->last_query());
        foreach($dist_head as $key=>$val){
            $isInArray = in_array($val['loc'], array_column($result_data, 'loc1'));
            if($isInArray == true){
                $dist_head[$key]['checked'] = 'y';
            }else{
                $dist_head[$key]['checked'] = 'n';
            }

        }
        $data['dist_head'] = $dist_head;
        // var_dump($data);
        $this->load->view('initialization/update_circlemapping',$data);
    }

    public function bcryptPassWord($plain_text)
    {
        $options = [
            'cost' => 12,
        ];
        $enc_pass = password_hash($plain_text, PASSWORD_BCRYPT, $options);
        return $enc_pass;
    }
    public function getCurrentPasswordCentralandLoginUser($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code){

        $loginUserPasswordList   = array();
        $CentralUserPasswordList = array();
        $sqlLogin = "select password,prev_password1,prev_password2,prev_password3 from loginuser_table where "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
            . "and lot_no = '$lot_no' and user_code = '$user_code'";
        $loginUserPasswordList = $this->db->query($sqlLogin)->row();

        if(empty($loginUserPasswordList))
        {
            log_message("error",'MB099: #ERROR093 : PASSWORD RESET NOT WORKING...');
            return array('responseType' => 1,'msg' => '#ERROR093 : PASSWORD RESET NOT WORKING...');
        }
        $this->dbb=$this->load->database('auth', TRUE);
        $sqlCentral = "select password,prev_password1,prev_password2,prev_password3 from central_auth where "
            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
            . "and lot_no = '$lot_no' and dhar_code = '$user_code'";
        $CentralUserPasswordList = $this->dbb->query($sqlCentral)->row();
        if(empty($CentralUserPasswordList))
        {
            log_message("error",'MB099: #ERROR094 : PASSWORD RESET NOT WORKING...');
            return array('responseType' => 1,'msg' => '#ERROR094 : PASSWORD RESET NOT WORKING...');
        }

        $updateQueryStringForLogin = " prev_password1 ='$loginUserPasswordList->password',prev_password2 = '$loginUserPasswordList->prev_password1',prev_password3 = '$loginUserPasswordList->prev_password2' ";
        $updateQueryStringForCentral = " prev_password1 ='$CentralUserPasswordList->password',prev_password2 = '$CentralUserPasswordList->prev_password1',prev_password3 = '$CentralUserPasswordList->prev_password2' ";

        return array('responseType' => 2 ,'login' => $updateQueryStringForLogin,'central' => $updateQueryStringForCentral);
    }



    //pass word update module -------------after reset or password expired***********
    public function password_update_module()
    {
        $response = array('responseType' => 1,'msg' => 'Update password failed');
        $dist_code    = $this->input->post('dist_code_new');
        $subdiv_code  = $this->input->post('subdiv_code_new');
        $cir_code     = $this->input->post('circle_code_new');
        $mouza_pargona_code   = $this->input->post('mouza_code_new');
        $lot_no       = $this->input->post('lot_no_new');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $user_code    = $this->session->userdata('user_code');

        //PASSWORD ENCRYPTION*************
        $encryptedPass    = $this->bcryptPassWord($new_password);
        $encryptedOldPass = $this->bcryptPassWord($old_password);


        //getOldPasswordValidation******************
        $sql = 'select password from loginuser_table where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and user_code = ?';
        $row = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code))->row();
        if(!empty($row))
        {
            if($row->password != $encryptedOldPass)
            {
                log_message('error','#PassWordError-01 Old password not valid');
                $response['msg'] = 'Old password not valid';
            }
        }
        else
        {
            log_message('error','#PassWordError-02 Old password not valid');
            $response['msg'] = 'User not found as registered';
        }

        $this->dbb=$this->load->database('auth', TRUE);
        $this->db->trans_begin();
        $this->dbb->trans_begin();
        $sqlCentral = 'select password from central_auth where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and dhar_code = ?';
        $rowCentral = $this->dbb->query($sqlCentral,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code))->row();
        if(!empty($rowCentral))
        {
            if($rowCentral->password != $encryptedOldPass)
            {
                log_message('error','#PassWordError-03 Old password not valid');
                $response['msg'] = 'Old password not valid';
            }
        }
        else
        {
            log_message('error','#PassWordError-04 Old password not valid');
            $response['msg'] = 'User not found as registered';
        }



        //UPDATE IN LOGINUSER*****************
        $date = date('Y-m-d H:i:s');
        $password_change_date =date('Y-m-d');
        $this->db->query('update loginuser_table set password = ?, date_password_changed = ?,password_change_flag = ?  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and user_code = ?',array($encryptedPass,$date,1,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code));

        if($this->db->affected_rows() != 1){
            $this->db->trans_rollback();
            $this->dbb->trans_rollback();
            log_message('error','#PassWordError-05 Password update failed'.$this->db->last_query());
            $response['msg'] = '#PassWordError-05 Password update failed';
        }

        //UPDATE IN CENTRAL AUTH**************
        $this->dbb->query('update central_auth set password = ?, password_change = ?,password_change_flag = ?  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and dhar_code = ?',array($encryptedPass,$password_change_date,1,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code));

        if($this->dbb->affected_rows() != 1){
            $this->dbb->trans_rollback();
            $this->db->trans_rollback();
            log_message('error','#PassWordError-06 Password update failed'.$this->db->last_query());
            $response['msg'] = '#PassWordError-06 Password update failed';
        }

        if($this->db->trans_status() === FALSE || $this->dbb->trans_status() === FALSE)
        {
            $this->dbb->trans_rollback();
            $this->db->trans_rollback();
        }else{
            $response['responseType'] = 2;
            $this->dbb->trans_commit();
            $this->db->trans_commit();
        }

        echo  json_encode($response);
        return;

    }

    public function edit_mobile_details() {
        //var_dump($this->session->all_userdata());
        $user_code = $this->input->get('user_code');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $q = "select count(*) as c from users where user_code=? and dist_code = ? and subdiv_code = ? and cir_code = ?";
        $c = $this->db->query($q,array($user_code,$dist_code,$subdiv_code,$cir_code))->row()->c;
        if ($c == 0) {
            $result_data1 = $this->db->query("Select * from lm_code where lm_code = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? ",array($user_code,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no))->row();



            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = ? and dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code =? and lot_no = ? ",array($user_code,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no))->row();
            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = ?",array('LM'))->row();
            //echo $result_data1->corres_sk_code;

            if ((substr($result_data1->corres_sk_code, 0, 2) === 'SK')) {
                $result_data5 = $this->db->query("Select * from users where user_code = '$result_data1->corres_sk_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                $sk_name = $result_data5->username;
                $sk_code = $result_data5->user_code;
            } else {
                $sk_name = '';
                $sk_code = '';
            }

            $designation = $result_data4->user_desig_as;
            $name = $result_data1->lm_name;
            $joining_date = date('d-m-Y', strtotime($result_data1->dt_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->dt_to));
            $desig_code = 'LM';
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        } else {
            $result_data1 = $this->db->query("Select * from users where user_code = ? and dist_code = ? and subdiv_code = ? and cir_code = ?",array($user_code,$dist_code,$subdiv_code,$cir_code))->row();

            $result_data2 = $this->db->query("Select * from loginuser_table where user_code = ? and dist_code = ? and "
                            . "subdiv_code = ? and cir_code = ?",array($user_code,$dist_code,$subdiv_code,$cir_code))->row();

            $result_data4 = $this->db->query("Select * from master_user_designation where user_desig_code = '$result_data1->user_desig_code' ")->row();
            //var_dump ($result_data4);
            if (empty($result_data4)) {
                $designation = 'Admin';
            } else {
                $designation = $result_data4->user_desig_as;
            }
            $name = $result_data1->username;
            $joining_date = date('d-m-Y', strtotime($result_data1->date_from));
            $relese_date = date('d-m-Y', strtotime($result_data1->date_to));
            $sk_name = "00";
            $sk_code = "00";
            $desig_code = $result_data1->user_desig_code;
            $phone_no = $result_data1->phone_no;
            $hashed_password_old = $result_data2->password;
        }

        $dist_name = $this->utilityclass->getDistrictName($result_data2->dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($result_data2->dist_code, $result_data2->subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($result_data2->dist_code, $result_data2->subdiv_code, $result_data2->cir_code, $result_data2->mouza_pargona_code, $result_data2->lot_no);

        //echo $result_data2->dist_code." ".$result_data2->subdiv_code." ".$result_data2->cir_code." ".$result_data2->mouza_pargona_code." ".$result_data2->lot_no;
        //echo $mouza_pargona_code;

        $result_data3 = $this->db->query("Select * from privilege where priv_code = '$result_data2->priv'")->row();
        if ($result_data2->dis_enb_option == 'E') {
            $status = "Enabled";
        } else {
            $status = "Disabled";
        }
        if ($result_data1->status == 'O') {
            $type = "à¦¸à§?à¦¥à¦¾à¦¨à§€à¦¯à¦¼";
        } elseif ($result_data1->status == 'P') {
            $type = "à¦†à¦¨à§° à¦¶à§?à¦¹à¦²à¦¤";
        } else {
            $type = "à¦¸à¦‚à¦²à¦—à§?à¦¨";
        }
        $data['info'] = array(
            'name' => $name,
            'user_code' => $user_code,
            'role' => $result_data3->priv_desc,
            'role_code' => $result_data2->priv,
            'status' => $status,
            'status_code' => $result_data2->dis_enb_option,
            'designation' => $designation,
            'designation_code' => $desig_code,
            'joining_date' => $joining_date,
            'relese_date' => $relese_date,
            'user_name' => $result_data2->use_name,
            'dist_name' => $dist_name,
            'dist_code' => $result_data2->dist_code,
            'subdiv_name' => $sub_div_name,
            'subdiv_code' => $result_data2->subdiv_code,
            'cir_name' => $cir_name,
            'cir_code' => $result_data2->cir_code,
            'mouza_pargona_name' => $mouza_pargona_code,
            'mouza_pargona_code' => $result_data2->mouza_pargona_code,
            'lot_no' => $lot_no,
            'lot_no_code' => $result_data2->lot_no,
            'type' => $type,
            'type_code' => $result_data1->status,
            'sk_name' => $sk_name,
            'sk_code' => $sk_code,
            'phone_no' => $phone_no,
            'hashed_password_old' => $hashed_password_old
        );
        //var_dump($data);

        $data['privilege'] = $this->db->query("SELECT * from privilege where priv_code = 'adm' OR priv_code = 'mut' order by priv_code")->result();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );


        $data['_view'] = 'initialization/edit_mobile_details';
        $this->load->view('layouts/main',$data);
    }

    public function update_mobile_details() {
        $this->load->helper('security');
        $user_code_id = $this->input->get('user_id');
        $dist_code = $this->input->get('dist_code_new');
        $subdiv_code = $this->input->get('subdiv_code_new');
        $cir_code = $this->input->get('circle_code_new');
        $mouza_pargona_code = $this->input->get('mouza_code_new');
        $lot_no = $this->input->get('lot_no_new');
        $designation_code = $this->input->get('user_desig');

        $name = $this->input->get('name');
        $phone_no = $this->input->get('phone_no');
        $use_name = $this->input->get('username');
        
        $this->dbb=$this->load->database('auth',true);
        $this->db->trans_begin();
        $this->dbb->trans_begin();
        if ($designation_code == 'CO') {
            
             $update_users = "update users set phone_no=? where user_code=? and dist_code = ? and subdiv_code = ? and  cir_code = ?";
            $this->db->query($update_users,array($phone_no,$user_code_id,$dist_code,$subdiv_code,$cir_code)); 



            $centralData="Update central_auth set mobile=? where dhar_code=? and dist_code=? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?";
            $this->dbb->query($centralData,array($phone_no,$user_code_id,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no));
        }
        

        if($this->dbb->affected_rows()==1 && $this->db->affected_rows()==1){
            $this->session->set_flashdata('message', "Mobile No. has been Updated Successfully...");
            $this->dbb->trans_commit();
            $this->db->trans_commit();
        }else
        {
            $this->session->set_flashdata('message', "#ERROR:2341 Mobile No. updation failed...");
            $this->dbb->trans_rollback();
            $this->db->trans_rollback();
        }
        redirect(base_url() . "index.php/home");
        
        
    }

}
