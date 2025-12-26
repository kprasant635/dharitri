<?php

class BankController extends CI_Controller {

    
      public function __construct() {
        parent::__construct();
        $this->load->model('BankModel/Bankmodel');
    }
    public function bank_registration() {
        $this->load->helper('html');
        $this->load->view('header');
        $this->load->view('bank/bank_registration');
        $this->load->view('footer');
    }
    
     public function districtDetails() {
		   $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('header');

        $data = $this->Bankmodel->getDistrictName();
        $district['names'] = $data;
       // $district['patta'] = $this->JamabandiModel->getPattaType();
        $this->load->view('bank/location_selection', $district);
        $this->load->view('footer');
    }

    public function bank_registration_inserted() {
		  $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('header');
        $captcha_session = $this->session->userdata('str');
          if($this->input->post('cap')  == $captcha_session){
         $name1 = $this->input->post('name1');
        // $Bname = $this->input->post('name2');
           $Branchname1 = $this->input->post('branchname1');
       //  $Branchname = $this->input->post('branchname2');
            if($name1 == 'other')
                {
                    $Bname = $this->input->post('name2');
                }
                else
                {
                    $Bname = $this->input->post('name1');
                }
                 if($Branchname1 == 'other'){
                $Branchname = $this->input->post('branchname2');
            }
             else{
                   $Branchname = $this->input->post('branchname1');
             }
           $contactname = $this->input->post('Name');
       $contactphnum = $this->input->post('Phonenumber');
        $designation = $this->input->post('designation');
            $date_of_reg = $this->input->post('date');
         $ifsc = $this->input->post('ifsc');
        $mail = $this->input->post('mail');
         $radio = $this->input->post('aa');
       $login = $this->input->post('login');
       $password = $this->input->post('new_pass');
           $confrmpass = $this->input->post('re_type_pass');
             $question = $this->input->post('question');
              $answer = $this->input->post('answer');
                $status = 'Pending';
                  $confirm_code=md5(uniqid(rand()));
              // $captcha = $this->input->post('cap');
        $this->db->query("INSERT INTO user_reg(
            bank_name,date_of_registration, mail, radio, login, pass, confrmpass, question, answer,contact_number,status,confirm_msg,branch_name,contact_name,designation,ifsc_code,dist_code,subdiv_code,cir_code)
    VALUES ('$Bname','$date_of_reg','$mail','$radio','$login','$password','$confrmpass','$question','$answer','$contactphnum','$status','$confirm_code','$Branchname','$contactname','$designation','$ifsc','$dcode','$scode','$ccode')");
    }
    }
}

?>