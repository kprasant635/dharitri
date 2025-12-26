<?php
class singleSignMapping extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
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
    function selectRole(){
    	$this->form_validation->set_rules('role_type', 'Select Role', 'trim|required');
    	$this->form_validation->set_rules('dist_code', 'Select District', 'trim|required');
    	$this->form_validation->set_rules('subdiv_code', 'Select Subdiv', 'trim|required');
    	$this->form_validation->set_rules('circle_code', 'Select Cirlcle', 'trim|required');
    	if ($this->form_validation->run() == FALSE) {
         //    $this->load->view('../views/header');
	        // $this->load->view('../views/mapping/role');
	        // $this->load->view('../views/footer');

            $data['_view'] = 'mapping/role';
            $this->load->view('layouts/main',$data);
        } else {
        	$this->session->set_userdata('role',$this->input->post('role_type'));
			//$this->session->set_userdata('dist_code',$this->input->post('dist_code'));
			$this->session->set_userdata('sub_code',$this->input->post('subdiv_code'));
			$this->session->set_userdata('circle_code',$this->input->post('circle_code'));
        	redirect('/singleSignMapping/allUsers');
        }
    	
    }
    function allUsers(){
    	$distcode=$this->session->userdata('dist_code');
        $suvdiv_code=$this->session->userdata('sub_code');
        $circlecode=$this->session->userdata('circle_code');
        $role=$this->session->userdata('role');
        ///////////////////
        // 1 ADC
        // 2 Assistant
        // 3 BO
        // 4 CO
        // 5 DC
        // 6 LM
        // 7 State Admin
        // 9 SK
        /////////////////////
        if($role==1)
        	$userType='ADC';
        elseif($role==2)
        	$userType='AS';
        elseif($role==3)
        	$userType='BO';
        elseif($role==4)
            $userType='CO';
        elseif($role==5)
            $userType='DC';
        elseif($role==6)
            $userType='M';
        elseif($role==7)
            $userType='ADM';
        elseif($role==9)
        	$userType='SK';
		$db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
        if($role==1 or $role==3 or $role==7 or $role==5){
            $suvdiv_code=$circlecode='00';
        }
		$q="Select * from loginuser_table where dist_code='$distcode' and subdiv_code='$suvdiv_code' and"
                    . " cir_code='$circlecode' and  dis_enb_option='E' and user_code like '$userType%' order by date_of_creation  ";
		$data['dharitree']=$this->dbb->query($q)->result();
    	$data['noc']=$this->NocUsers($this->session->userdata('role'));
        //var_dump($data['noc']);
    	// $this->load->view('../views/header');
     //    $this->load->view('../views/mapping/users_map',$data);
     //    $this->load->view('../views/footer');

        $data['_view'] = 'mapping/users_map';
        $this->load->view('layouts/main',$data);

    }
    function userMappingUpdate(){
    	//var_dump($_POST);
    	$username=$this->input->post('useNameD');
    	$noc=$this->input->post('nocUname');
    	//$user_code=$this->input->post('userCodeD');
    	$success= $this->UpdateNocUsersMap($username,$noc);
		$db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
    	//echo $success;
    	if($success){
    		$success=$this->UpdatedharUsersMap($username,$noc);
	    	if ($success) {
	    		$this->session->set_flashdata('message', "$username - $noc User Mapped Successfully");
    			redirect('/singleSignMapping/allUsers');
	    	}else{
	    		$this->session->set_flashdata('message', "Error . Please Contact ");
    			redirect('/singleSignMapping/selectrole');
	    	}
    		
    	}else{
    		$this->session->set_flashdata('message', "Error . Please Contact ");
    		redirect('/singleSignMapping/selectrole');
    	}
    		
    }
    //////////For Noc////////////
    function NocUsers($role){
        $distcode=$this->session->userdata('dist_code');
        $subdivcode=$this->session->userdata('sub_code');
        $circlecode=	$this->session->userdata('circle_code');
        $role=$this->session->userdata('role');
        if($role==1 or $role==3 or $role==7 or $role==5){
            $subdivcode=$circlecode='00';
        }
    	//$database_name = 'master';
        $db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
        //var_dump($this->dbb);
        $query="Select * from user1 where userstat='A' and distcode='$distcode' and  subdivcode='$subdivcode' and circlecode='$circlecode' and usroll='$role' ";
        $data=$this->dbb->query($query)->result();
        return $data;
    }
    function UpdateNocUsersMap($username,$noc){
        $distcode=$this->session->userdata('dist_code');
        $subdivcode=$this->session->userdata('sub_code');
        $circlecode=	$this->session->userdata('circle_code');
        $role=$this->session->userdata('role');
        $db = $this->load->database('noc', TRUE);
        if($role==1 or $role==3 or $role==7 or $role==5){
            $subdivcode=$circlecode='00';
        }
        $this->dbb = $db;
        //var_dump($this->dbb);
        $query="Update user1 set dharitree_user='$username' where distcode='$distcode' and  subdivcode='$subdivcode' and circlecode='$circlecode' and usroll='$role' and usnm='$noc' ";
        $data=$this->dbb->query($query);
        return $data;
    }
    function unmapped($user){
    	$distcode=$this->session->userdata('dist_code');
        $subdivcode=$this->session->userdata('sub_code');
        $circlecode=	$this->session->userdata('circle_code');
        $role=$this->session->userdata('role');
        if($role==1 or $role==3 or $role==7 or $role==5){
            $subdivcode=$circlecode='00';
        }
        $role=$this->session->userdata('role');
        $db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
        //var_dump($this->dbb);
        $query="Update user1 set dharitree_user=null where distcode='$distcode' and  subdivcode='$subdivcode' and circlecode='$circlecode' and usroll='$role' and dharitree_user='$user' ";
        $data=$this->dbb->query($query);
        ////////////////////////
        $query="Update loginuser_table set nocuser=null where dist_code='$distcode' and  subdiv_code='$subdivcode' and cir_code='$circlecode' and use_name='$user' ";
        $data=$this->dbb->query($query);
        redirect('/singleSignMapping/allUsers');
    }
    /////////////Dharitree//////////////////
     function UpdatedharUsersMap($username,$noc){
        $distcode=$this->session->userdata('dist_code');
        $subdivcode=$this->session->userdata('sub_code');
        $circlecode=	$this->session->userdata('circle_code');
        $role=$this->session->userdata('role');
        if($role==1 or $role==3 or $role==7 or $role==5){
            $subdivcode=$circlecode='00';
        }
		$db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
        //var_dump($this->dbb);
        $query="Update loginuser_table set nocuser='$noc' where dist_code='$distcode' and  subdiv_code='$subdivcode' and cir_code='$circlecode' and use_name='$username'";
        $data=$this->dbb->query($query);
        return $data;
    }
    //////////////Porting of Users//////////////////////////
    function portUser(){       
        $sql="Select * from loginuser_table where dis_enb_option='E' and  nocuser is null order by date_of_creation ";
        $data['dharitree']=$this->db->query($sql)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/mapping/activeusers',$data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'mapping/activeusers';
        $this->load->view('layouts/main',$data);
    }
    function userport($user_code,$tp,$d,$s,$c,$m,$l){
    	$sql="Select * from loginuser_table where dis_enb_option='E' and use_name='$user_code' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and nocuser is null order by date_of_creation ";
        $data=$this->db->query($sql)->row_array();
        $db = $this->load->database('noc', TRUE);
        $this->dbb = $db;
        $sucess= $this->dbb->insert('loginuser_table',$data);
        if($success){
        	if($tp=='M'){
        	$query = "select * from lm_code where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                . "mouza_pargona_code='$m' and lot_no='$l' and lm_code='$data[user_code]' ";
            $lm=$this->db->query($query)->row_array();
            $this->dbb->insert('lm_code',$lm);
	        }else{
	        	$query = "select * from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
	                . "user_code='$data[user_code]' ";
	            $user=$this->db->query($query)->row_array();
	            $this->dbb->insert('users',$user);
	        }
        }else{
        	error('404');
        }
        
        redirect('/singleSignMapping/portUser');
        //var_dump($data);
    }
}