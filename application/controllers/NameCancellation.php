<?php

class NameCancellation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('APCancellation/APCancellationModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('misreport/MisModel');
        $this->load->library('session');
        $this->load->model('Escalationmodel');
        $this->load->model('NameCorrection/NameCorrectionModel');
        $this->load->model('NameCancellation/NameCancellationModel');
		  $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('AgriStackCaseHistory');
        if(ENABLED_BLOCKCHAIN == 1)
            {
                $this->load->model('propChain/PropChainModel');
                $this->load->model('propChain/PropChainCommonModel');
            }
        

        //NameCancellation
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
    public function ASTStep1() {
        if(RTPS_CERT_ON_OFF=='1'){
            $this->session->set_flashdata('message', 'Not Authorised');
            redirect(base_url() . "index.php/home/index");
            return; 
        }
        $data['names'] = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['vill_townprt_code'] = $dist_code;
        $data['dist'] = $this->MisModel->getDistrictName($dist_code);
        $data['subdiv'] = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $data['circle'] = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['mouzalist'] = $this->MisModel->getMouzaList($dist_code, $subdiv_code, $cir_code);
        $data['patta'] = $this->APCancellationModel->getAllPatta();
        $data['supporting_doc'] = $this->NameCorrectionModel->getSupportingDoc();
        $q = $this->db->query("select * from  users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_desig_code='CO'");
        $c = $q->result();
        foreach ($c as $x) {
            $users = "Select user_code as user_c from  loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $select = $this->db->query($users)->row();
            if (@count($select) == '1') {
                $convertions[] = array(
                    'co_name' => $x->username,
                    'user_desig_code' => $x->user_desig_code,
                    'user_code' => $select->user_c
                );
                $data['user'] = $convertions;
            }
        }
		 $this->form_validation->set_rules('ord_date', 'Order Date', 'required');
		 $this->form_validation->set_rules('official', 'Select Officer Name', 'required');
		 $this->form_validation->set_rules('mouza_code', 'Mouza Name','required');
		 $this->form_validation->set_rules('lot_no', 'Lot Number', 'required');
		 $this->form_validation->set_rules('vill_code', 'Village Code', 'required');
		 $this->form_validation->set_rules('patta_type_code', 'Select Patta Type', 'required');
		 $this->form_validation->set_rules('patta_no', 'Patta Number', 'required');
		 $this->form_validation->set_rules('dag_no', 'Dage Number', 'required');
		 $this->form_validation->set_rules('doc_name', 'Documents', 'required');
		if ($this->form_validation->run() == FALSE) {
		// $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/NameCancellation/ASTStep1', $data);
  //       $this->load->view('../views/footer');


        $data['_view'] = 'NameCancellation/ASTStep1';
        $this->load->view('layouts/main',$data);
		}

        else{
        if (isset($_POST['ASTSTEP1Submit'])) {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $case_type = '07';
            $ord_date1 = $this->input->post('ord_date');
            $ord_date = date("Y-m-d", strtotime($ord_date1));
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type_code = $this->input->post('patta_type_code');
            $dag_no_int = $this->input->post('dag_no');
            $doc_name = $this->input->post('doc_name');
            $doc_code = implode(",", $doc_name);
            $official = $this->input->post('official');
            //generate year and pettition no 
            $year_no = year_no;
            $define_date = define_date;
   //          $q = "Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
   //          $abbrname = $this->db->query($q)->row();
   //          $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
   //          //echo $cir_dist_name;
   //          $petition_no = $this->db->query("select max(misc_case_petition_no)+1 as count from    misc_case_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row()->count;
   //          if ($petition_no == null) {
   //              $petition_no = 1;
   //          } 
   //          $petition_no_case = $this->db->query("select count(misc_case_petition_no)+1 as petition_no from    misc_case_basic where dist_code = '$dist_code' and "
   //                          . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code'
			// 				and year_no='$year_no' and misc_case_type='07' ")->row()->petition_no;
			// if($petition_no_case==null){
			// 	$petition_no_case = 1;
			// }
			// $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
   //          $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/MiND";
            $case_name=$this->basundharamodel->genearteCaseName();
            $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteMiscPetitionNo();

            $case_no=$case_name.$petition_no."/MiND";
            $sqldag = "Select dag_no as c from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and lot_no='$lot_no' and "
                    . "patta_type_code= '$patta_type_code' and dag_no_int = '$dag_no_int'"; // and dag_no_int = '$dag_no_int'

            $dag_no = $this->db->query($sqldag)->row()->c;
            $land = $this->NameCorrectionModel->getAvailLand($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);
            if ($land == null || $land == '') {
                echo '<script>alert("Opps..! Sorry you have choose a wrong patta no.");</script>';
                redirect('NameCancellation/ASTStep1', 'refresh');
            } else {
                $userdata = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'misc_case_petition_no' => $petition_no,
                    'misc_case_no' => $case_no,
                    'misc_case_type' => $case_type,
                    'patta_no' => trim($patta_no),
                    'patta_type_code' => $patta_type_code,
                    'submission_date' => $ord_date,
                    'supported_doc_yn' => 'Y',
                    'supported_doc_code' => $doc_code,
                    'fresh_yn' => 'Y',
                    'status' => '01',
                    'operation' => 'E',
                    'proceeding_yn' => 'Y',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_operation' => $ord_date,
                    'add_to_officer' => $official,
                    'dag_no' => $dag_no
                );
                //var_dump($userdata);
                $this->session->set_userdata($userdata);
                $this->db->insert("misc_case_basic", $userdata);
                redirect(base_url() . "index.php/NameCancellation/ASTStep2");
            }
        }
		}
	}
    public function ASTStep2() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_townprt_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no_int = $this->session->userdata('dag_no');
        $dag_no = $dag_no_int;
        $misc_case_no = $this->session->userdata('misc_case_no');
        $misc_case_petition_no = $this->session->userdata('misc_case_petition_no');
        $data['relation'] = $this->APCancellationModel->getRelation();
        $data['pdar_info'] = $this->NameCorrectionModel->getPdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $dag_no);
        $this->form_validation->set_rules('pdar_id', 'Pattadar', 'required');
        $this->form_validation->set_rules('petition_pdar_name_old', 'Pattadar Name', 'required');
        //$this->form_validation->set_rules('pdar_father', 'Gurdian Name', 'required');
        //$this->form_validation->set_rules('pdar_guard_reln', 'Select Relation', 'required');
		if ($this->form_validation->run() == FALSE) {
		// $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/NameCancellation/ASTStep2', $data);
  //       $this->load->view('../views/footer');


        $data['_view'] = 'NameCancellation/ASTStep2';
        $this->load->view('layouts/main',$data);
		}else{
        if (isset($_POST['ASTSTEP2Submit'])) {
			$petition_pdar_name_old = $this->input->post('petition_pdar_name_old');
            $pdar_id = $this->input->post('pdar_id');
            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'petition_pdar_id' => $pdar_id,
                'misc_case_no' => $misc_case_no,
                'petition_pdar_name_old' => $petition_pdar_name_old,
                'submission_date' => date('Y-m-d'),
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'misc_case_petition_no' => $misc_case_petition_no
            );
            $this->db->insert("misc_case_first_party", $userdata);
            redirect(base_url() . "index.php/NameCancellation/ASTStep4");
        }
		}
	}
    public function ASTStep4() {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_townprt_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $misc_case_no = $this->session->userdata('misc_case_no');
        $dag_no = $this->session->userdata('dag_no');
        $data['relation'] = $this->APCancellationModel->getRelation();
        $data['pdar_info'] = $this->NameCancellationModel->getPdarInfo1($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $misc_case_no,$dag_no);
		//var_dump($data['pdar_info']);
		$this->form_validation->set_rules('pdar_id', 'Pattadar', 'required');
        $this->form_validation->set_rules('pdar_father', 'Gurdian Name', 'required');
        $this->form_validation->set_rules('opp_comment', 'Remarks', 'required');
        $this->form_validation->set_rules('pdar_guard_reln', 'Select Relation','required' );
		if ($this->form_validation->run() == FALSE) {
		// $this->load->helper('html');
  //       $this->load->view('../views/header');
  //       $this->load->view('../views/NameCancellation/ASTStep4', $data);
		// $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/ASTStep4';
        $this->load->view('layouts/main',$data);
		}else{
        if (isset($_POST['ASTSTEP2Submit'])) {
            $opp_comment = $this->input->post('opp_comment');
            $pdar_id = $this->input->post('pdar_id');
            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'opp_pdar_id' => $pdar_id,
                'misc_case_no' => $misc_case_no,
                'opp_comment' => $opp_comment,
                'submission_date' => date('Y-m-d'),
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E'
            );
            $this->db->insert("misc_case_scnd_party", $userdata);
            ///////////////////////////////
            $this->Dashboard($misc_case_no);
			$this->session->set_flashdata('message', 'Case No ' . $misc_case_no . ' Successfully Registered for Name Cancellation!!');
            redirect(base_url() . "index.php/home/index");
			}
		}
    }
	public function COStep1() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');

      $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $user_code = $this->session->userdata('user_code');
		$dist_code=$this->session->userdata('dist_code');
		$subdiv_code=$this->session->userdata('subdiv_code');
		$cir_code=$this->session->userdata('cir_code');
        $case_array = array();
        // $data['MisCases'] = $this->db->query("select mcb.misc_case_type,mcb.misc_case_no,mcb.submission_date,ba.basundhara from misc_case_basic mcb 
        //     left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where status='01' and lm_note_yn is null and sk_note_yn is null "
        //                     . "and notice_generated_yn is null and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and add_to_officer='$user_code' and fresh_yn='Y'")->result();
        // $this->load->view('../views/NameCancellation/COStep1', $data);
        // $this->load->view('../views/footer');

        $sql="(select distinct on (ba.basundhara) ba.basundhara, * from misc_case_basic fmb left 
              join basundhar_application ba on fmb.misc_case_no=ba.dharitree where ba.basundhara !='' and status='01' and lm_note_yn is null and sk_note_yn is null 
                             and notice_generated_yn is null and fresh_yn='Y' and dist_code=? and subdiv_code=? 
                            and cir_code=? and add_to_officer = ? )
            union (
            select ba.basundhara, * from misc_case_basic fmb left 
              join basundhar_application ba on fmb.misc_case_no=ba.dharitree where ba.basundhara is null 
            and  status='01' and lm_note_yn is null and sk_note_yn is null 
                             and notice_generated_yn is null and fresh_yn='Y' and dist_code=? and subdiv_code=? 
                            and cir_code=? and add_to_officer = ?  )";
        $data['MisCases'] = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $user_code, $dist_code, $subdiv_code, $cir_code, $user_code))->result();

        log_message('error','========'.$this->db->last_query());

        
        
         if(ESCALATION_ENABLE == 1){
            foreach($data['MisCases'] as $rows) {
               if($rows->es_flag == '1'){
                  $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
                  log_message('error', '#351: From escalation_detail_table : '.json_encode($escRow));

                  if(!empty($escRow) && $escRow != null){
                     $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
                     log_message('error', '#355: Escalation details : '.json_encode($escData));
                     $rows->escalation_date = $escData->escalation_date;
                     $rows->escalation_zone = $escData->escalation_zone;
                     $rows->assigned_date   = $escData->assigned_date;
                  }else{
                     $rows->escalation_date = 'NA';
                     $rows->escalation_zone = 'NA';
                  }

                  
               }
               else {
                  $rows->escalation_date = 'NA';
                  $rows->escalation_zone = 'NA';
               }
            }
        }
         


        $data['_view'] = 'NameCancellation/COStep1';
        $this->load->view('layouts/main',$data);
    }
    public function COStep2() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');

      $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
      if($_GET['misc_case_no'] == null)
      {
         echo json_encode('Sorry !! You are not Authorized to access the content!!');
         return;
      }

      $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $misc_case_no = $this->input->get('misc_case_no');
		
        $data['miscCaseInfo'] = $this->NameCancellationModel->NameCancellation($misc_case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;

        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $application_no="select * from basundhar_application where dharitree=? ";
        $data['app'] = $app_details = $this->db->query($application_no, array($misc_case_no))->row();
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }
        $data['Petitioner'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
        $sql1 = "select patta_no from misc_case_basic where misc_case_no=? and misc_case_petition_no = ?";
        $result1 = $this->db->query($sql1, array($misc_case_no, $misc_case_petition_no));
        $patta_no = $result1->row()->patta_no;
        $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);
		  $data['selfDecData'] = null;
        $data['base64_decoded_adhar_file'] = null;
        $data['showFlag']= false;
        if(ESCALATION_ENABLE == 1 &&  $data['miscCaseInfo']->es_flag == 1){

            $data['selfDecData'] = json_decode($data['Petitioner']->self_declaration);
            $data['showFlag'] = true;
            if($data['Petitioner']->auth_type !=null){
               $statusAadhar = "<i class='fa fa-check'></i> ".$data['Petitioner']->auth_type. " Verified";
               $engName = "";
           }else{
               $statusAadhar = 'N/A';
               $engName = null;
           }
              $data['status'] = $statusAadhar;
              $data['engName'] = $engName;

               $application_no_sql="select * from basundhar_application where dharitree='$misc_case_no' ";
               $data['application'] = $this->db->query($application_no_sql)->row();

              $data['base64_decoded_adhar_file'] = "";
              if (!empty($data['Petitioner']) && $data['Petitioner'] !=null && trim($data['Petitioner']->auth_type) == 'AADHAAR' ):

                      $adhar_photo_link = $data['Petitioner']->photo;
                      if($adhar_photo_link == null)
                      {
                          $url = RTPS_API_LINK."getApplicantPhoto";
                          $arrayData =array(
                              'application_no' => $data['application']->basundhara,
                          );
                          //*****API call again for aadhar photo missing */
                          $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                          if($aadhaarPhotoReCall != 'n')
                          {
                              $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                              $aadhar_path = AADHAAR_UPLOAD_DIR. $data['Petitioner']->id_ref_no . '.json';
                              $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                              $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                              fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                              fclose($aadhaar_file_to_write_base64);
                              
                              $id_ref_no = $data['Petitioner']->id_ref_no;

                              $query = "update misc_case_first_party set photo = '$aadhar_path' where misc_case_no='$misc_case_no' and id_ref_no = '$id_ref_no' and auth_type is not null";
                              $this->db->query($query);
                             
                              $adhar_photo_link = $aadhar_path;
                              
                          }
                          else
                          {
                              echo json_encode(array('ERROR885784: API Response fail!'));
                              return false;
                          }


                      }
                      //**********reopening the updated file */
                      $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                      $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                      fclose($open_adhar_file);
                      // decoding the base64 encoding file variable
                      $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
            
                  
                  endif;
              }



      //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
         $this->load->model('propChain/PropChainModel');
        $patta_no = $data['miscCaseInfo']->patta_no;

        $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $data['miscCaseInfo']->dag_no);

        $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);

        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
            $this->PropChainModel->updateCmpFlag($misc_case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
            // if mismatch case get the view mismatch case button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($misc_case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);
        }

        $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
        $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

        if ($data['ulpinCheck'] == 1) {
            $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
            if (isset($data['old_ulpin']))
                $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
            else
                $data['old_ulpin'] = "";
        }

        // if property does not exists get create asset button
        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
            $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
        }
        $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
        $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
        $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
        $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];


        // hidden fields
        $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
        $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
        $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
        $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

        // bhunaksha area cmp
        $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
        $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
        $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
        $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
       }

        //FOR AADHAAR DETAILS-----------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //----END OF AADHAR DETAILS----------------


         //ESCALATED CASES REMARK ENTRY FORM==============
         if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1)
         {
             $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
             $data['remainingTime'] = $remainingTime;
             $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
             if(isset($escRemarkData) && !empty($escRemarkData))
             {
                 $data['escRemarkData'] = $escRemarkData;
             }
         }
         ///END REMARKS/////////


        $data['_view'] = 'NameCancellation/COStep2';
        $this->load->view('layouts/main',$data);
    }
	// function RejectOrder(){
	// 	$case_no=$this->input->get('misc_case_no');
	// 	$dist_code=$this->session->userdata('dist_code');
	// 	$subdiv_code=$this->session->userdata('subdiv_code');
	// 	$cir_code=$this->session->userdata('cir_code');
	// 	$user_code=$this->session->userdata('user_code');
	// 	$data=array(
	// 				'user_code'=>$user_code,
	// 				'status'=>'F',
	// 				'date_of_operation'=>date('Y-m-d')
	// 	);
	// 	$this->db->where('dist_code',$dist_code);
	// 	$this->db->where('subdiv_code',$subdiv_code);
	// 	$this->db->where('cir_code',$cir_code);
	// 	$this->db->where('misc_case_no',$case_no);
	// 	$this->db->update("misc_case_basic", $data); 
 //         ///////////////////////////////////
 //        $this->DashboardDataFinal($misc_case_no);
 //        //////////////////////


	// 	$this->session->set_flashdata('message', 'Application Rejected Successfully!!');
 //        redirect(base_url() . "index.php/home/index");
	// }

    function RejectOrder(){
        $application_no=$this->input->post('application_no');
        //$date_entry = date('Y-m-d');
        if($application_no)
                {
                    $case_no=$this->input->post('misc_case_no');
                    $dist_code=$this->session->userdata('dist_code');
                    $subdiv_code=$this->session->userdata('subdiv_code');
                    $cir_code=$this->session->userdata('cir_code');
                    $user_code=$this->session->userdata('user_code');
                    $data=array(
                        'user_code'=>$user_code,
                        'status'=>'F',
                        'date_of_operation'=>date('Y-m-d')
                    );
                    $this->db->where('dist_code',$dist_code);
                    $this->db->where('subdiv_code',$subdiv_code);
                    $this->db->where('cir_code',$cir_code);
                    $this->db->where('misc_case_no',$case_no);
                    $this->db->update("misc_case_basic", $data); 
                    $this->basundharamodel->RejectOrder();
                } else{
            
                    $case_no=$this->input->get('misc_case_no');
                    $dist_code=$this->session->userdata('dist_code');
                    $subdiv_code=$this->session->userdata('subdiv_code');
                    $cir_code=$this->session->userdata('cir_code');
                    $user_code=$this->session->userdata('user_code');
                    $data=array(
                        'user_code'=>$user_code,
                        'status'=>'F',
                        'date_of_operation'=>date('Y-m-d')
                    );
                    $this->db->where('dist_code',$dist_code);
                    $this->db->where('subdiv_code',$subdiv_code);
                    $this->db->where('cir_code',$cir_code);
                    $this->db->where('misc_case_no',$case_no);
                    $this->db->update("misc_case_basic", $data); 
            }
         ///////////////////////////////////
        $this->DashboardDataReject($misc_case_no);
        //////////////////////


        $this->session->set_flashdata('message', 'Application Rejected Successfully!!');
        redirect(base_url() . "index.php/home/index");
    }


	public function COStep2_save_old_25_3_22() {
		//$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no')  ;      
        $next_date_of_hearing1 = $this->input->post('next_date_of_hearing');
        $next_date_of_hearing = date("Y-m-d", strtotime($next_date_of_hearing1));

        $p1 = $this->input->post('p1');
        $p2 = $this->input->post('p2');
        $process_note = $p1 . " " . $next_date_of_hearing . " " . $p2;
        $note_date = date('Y-m-d');
        $time_to_present = $this->input->post('next_date_time');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;

        $user_code = $this->session->userdata('user_code');
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;

        $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result = $this->db->query($sql);
        $note_no = ($result->row()->note_no) + 1;
        $status = '18';
        $operation = 'E';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $process_note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );

        $this->db->insert("misc_case_process_reports", $userdata);
        // status 18 is after circle officer passes the order
        $updateSqlBasic = "update  misc_case_basic set proceeding_yn='Y',next_date_of_hearing='$next_date_of_hearing',time_to_present='$time_to_present',fresh_yn='Y', "
                . " status='18', date_of_operation='$note_date' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $this->db->query($updateSqlBasic);

        $updateSqlFirstParty = "update  misc_case_first_party set operation='l'  where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $this->db->query($updateSqlFirstParty);
        ///////////////////////////////////
        $penUser='LM';
        $rmrk="CO submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////
        $application_no = $this->input->POST('application_no');

        // $basundhara=$this->db->query("select basundhara from basundhar_application where dharitree='$misc_case_no' ")->row()->basundhara;

        if($application_no){
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'Verified by CO',
                'status' => 'M',
                'task' => 'CO',
                'pen'=>'LM',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }


        $this->session->set_flashdata('message', 'Name Correction Order Has Passed  !!  Now LM and SK Verify Applicant Details !!');
        redirect(base_url() . "index.php/home/index");
    }

    public function ViewNCorrPetition() {
		//$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $data['miscCaseInfo'] = $this->NameCancellationModel->getNameCorrCaseInfo($misc_case_no);
		//var_dump($data);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        //first party
        //$data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo1($misc_case_no, $patta_no,$misc_case_petition_no);
        $data['pet'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
        //var_dump($data['pet']);
		$data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);
        
        //var_dump($data['secondparty']);
        //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        // $this->load->view('../views/NameCancellation/ViewNCorrPetition', $data);
        // $this->load->view('../views/footer');
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
         $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['_view'] = 'NameCancellation/ViewNCorrPetition';
        $this->load->view('layouts/main',$data);
    }

    public function ASTNoticeGenerate() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $data['MisCases'] = $this->db->query("select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from    misc_case_basic where status='18' and lm_note_yn is null and sk_note_yn is null and notice_generated_yn is null and misc_case_type='07'")->result();
        // $this->load->view('../views/NameCancellation/ASTNoticeGenerate', $data);
        // $this->load->view('../views/footer');
         $data['_view'] = 'NameCancellation/ASTNoticeGenerate';
        $this->load->view('layouts/main',$data);
    }

    public function ASTNoticeGenerate1() {

        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);

        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        //$supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        //$data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        //$data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo1($misc_case_no, $patta_no,$petition_no);
        $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);

        $data['coOrderdate'] = $this->NameCancellationModel->getCOorderDate($misc_case_no);
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        // $this->load->view('../views/NameCancellation/ASTNoticeGenerate1', $data);
        // $this->load->view('../views/footer');
        $user_code = $data['miscCaseInfo']->add_to_officer;
        
        $time_to_present = $data['miscCaseInfo']->time_to_present;

        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $user_code);
        $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($misc_case_no);
       

        $data['_view'] = 'NameCancellation/ASTNoticeGenerate1';
        $this->load->view('layouts/main',$data);

        $date = date('Y-m-d');
        $user_code = $this->session->userdata('user_code');

      
        $updateSql = "update  misc_case_basic set notice_generated_yn='Y', notice_generated_date='$date',date_of_operation='$date', user_code='$user_code' where misc_case_no='$misc_case_no'";
        $this->db->query($updateSql);

         //ESCALATION CODE INTEGRATION================SANMRI
         $executionDate = date('Y-m-d');
         $queryForUpdate = "select notice_generated_yn,next_date_of_hearing,es_flag from misc_case_basic"
             ." where misc_case_no=?";

         $hearingDateDetails = $this->db->query($queryForUpdate,array($misc_case_no))->row();
         // var_dump($hearingDateDetails);
         // die;
         log_message('error',"#0987:MISC_CASE_DETAILS==========".json_encode($hearingDateDetails));
         // check for notice re-generation===============
         if($hearingDateDetails->notice_generated_yn == null){

            
               if($hearingDateDetails->es_flag == 1 && ESCALATION_ENABLE ==1){
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                $escalationUpdateStatus = $this->Escalationmodel->escalationDANoticeNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$misc_case_no,$user_code,$hearingDateDetails->next_date_of_hearing);

                log_message("error", "#ESC848, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                if($escalationUpdateStatus['responseType'] == 0){
                    // $this->db->trans_rollback();
                    log_message("error", "#ESC848, transaction-error in method 'NameCancellation/ASTNoticeGenerate1' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. NCAN-Error Code(#ESC848)");
                    redirect(base_url() . "index.php/home");
                }

                ///////////////END ESCALATION//////////////
            }
         }
         /////////////END/////////////////
         


    }

    public function ASTOrderSheet() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $data['ConfirmNoticeGenerate'] = $this->db->query("select misc_case_type,misc_case_no,submission_date,misc_case_petition_no from    misc_case_basic where dag_no is not null and notice_generated_yn='Y' and notice_generated_date is not null and status='18'")->result();
        //$data['ConfirmNoticeGenerate'] = $case_array;
        // $this->load->view('../views/NameCancellation/ASTOrderSheet', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/ASTOrderSheet';
        $this->load->view('layouts/main',$data);
    }
    public function ASTOrderSheet1(){
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $misc_petition_no = $this->input->get('p');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$misc_petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        //$data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $data['co_order'] = $this->NameCancellationModel->getCOOrder($misc_case_no);
        //var_dump($data['co_order']);
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        
        // $this->load->view('../views/NameCancellation/ASTOrderSheet1', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'NameCancellation/ASTOrderSheet1';
        $this->load->view('layouts/main',$data);
    }
    
    public function ASTOrderSheet1_save() {
		//$db=  $this->session->userdata('db');
		//var_dump($_POST);
        $misc_case_no = $this->input->post('misc_case_no');
        $misc_petition_no = $this->input->post('misc_petition_no');
        $ast_report = $this->input->post('ast_report');
        $note_date = date('Y-m-d');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$misc_petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
//        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
//        $year_no = $data['miscCaseInfo']->year_no;
        $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$misc_case_no'";
        $result = $this->db->query($sql);
        $note_no = ($result->row()->note_no) + 1;
        $status = '02';
        $operation = 'a';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $ast_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation
        );
        
        $this->db->insert("misc_case_process_reports", $userdata);
        $updateSqlBasic = "update   misc_case_basic set notice_served_yn='Y', status='$status', date_of_operation='$note_date',  "
                . " user_code='$user_code' where misc_case_no='$misc_case_no' ";
        $this->db->query($updateSqlBasic);
        $this->session->set_flashdata('message', 'Action taken report Submitted !!');
        redirect(base_url() . "index.php/home/index");
    }
	 public function LMStep2() {
         $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
		 $miscCaseSecond = $this->NameCancellationModel->getNameSecPartyInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
		// $data['secondparty']=$this->utilityclass->getnameByPdarId($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$data['miscCaseInfo']->patta_no,$patta_type_code,$miscCaseSecond->opp_pdar_id);
		//var_dump($data['secondparty']);
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $sql1 = "select patta_no from    misc_case_basic where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result1 = $this->db->query($sql1);
        $patta_no = $result1->row()->patta_no;
        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        //$data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);
        $data['Petitioner'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
		$this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $app_details = $this->db->query($application_no)->row();

        $data['selfDecData'] = null;
        $data['base64_decoded_adhar_file'] = null;
        $data['showFlag']= false;
        if(ESCALATION_ENABLE == 1 &&  $data['miscCaseInfo']->es_flag == 1){
            $data['showFlag'] = true;
            $data['selfDecData'] = json_decode($data['Petitioner']->self_declaration);
            $data['showFlag'] = true;
               if($data['Petitioner']->auth_type !=null){
                  $statusAadhar = "<i class='fa fa-check'></i> ".$data['Petitioner']->auth_type. " Verified";
                  $engName = "";
              }else{
                  $statusAadhar = 'N/A';
                  $engName = null;
              }
              $data['status'] = $statusAadhar;
              $data['engName'] = $engName;

              $data['base64_decoded_adhar_file'] = "";
              if (!empty($data['Petitioner']) && $data['Petitioner'] !=null && trim($data['Petitioner']->auth_type) == 'AADHAAR' ):

                      $adhar_photo_link = $data['Petitioner']->photo;
                      if($adhar_photo_link == null)
                      {
                          $url = RTPS_API_LINK."getApplicantPhoto";
                          $arrayData =array(
                              'application_no' => $data['app']->basundhara,
                          );
                          //*****API call again for aadhar photo missing */
                          $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                          if($aadhaarPhotoReCall != 'n')
                          {
                              $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                              $aadhar_path = AADHAAR_UPLOAD_DIR. $data['Petitioner']->id_ref_no . '.json';
                              $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                              $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                              fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                              fclose($aadhaar_file_to_write_base64);
                              
                              $id_ref_no = $data['Petitioner']->id_ref_no;

                              $query = "update misc_case_first_party set photo = '$aadhar_path' where misc_case_no='$misc_case_no' and id_ref_no = '$id_ref_no' and auth_type is not null";
                              $this->db->query($query);
                             
                              $adhar_photo_link = $aadhar_path;
                              
                          }
                          else
                          {
                              echo json_encode(array('ERROR885784: API Response fail!'));
                              return false;
                          }


                      }
                      //**********reopening the updated file */
                      $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                      $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                      fclose($open_adhar_file);
                      // decoding the base64 encoding file variable
                      $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
            
                  
                  endif;
         }
               

        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }

         $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);

         $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($misc_case_no);

        //var_dump($data);
        // $this->load->view('../views/NameCancellation/LMStep2', $data);
        // $this->load->view('../views/footer');

        //FOR AADHAAR DETAILS-----------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //----END OF AADHAR DETAILS----------------

        //ESCALATED CASES REMARK ENTRY FORM==============
         if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1)
         {
             $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
             $data['remainingTime'] = $remainingTime;
             $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
             if(isset($escRemarkData) && !empty($escRemarkData))
             {
                 $data['escRemarkData'] = $escRemarkData;
             }
         }
         ///END REMARKS/////////


        $data['_view'] = 'NameCancellation/LMStep2';
        $this->load->view('layouts/main',$data);
    }
	public function SKStep2() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
		$miscCaseSecond = $this->NameCancellationModel->getNameSecPartyInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
		// $data['secondparty']=$this->utilityclass->getnameByPdarId($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$data['miscCaseInfo']->patta_no,$patta_type_code,$miscCaseSecond->opp_pdar_id);
		//var_dump($data['secondparty']);
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $sql1 = "select patta_no from    misc_case_basic where misc_case_no=? and misc_case_petition_no = ?";
        $result1 = $this->db->query($sql1, array($misc_case_no, $petition_no));
        $patta_no = $result1->row()->patta_no;
        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        //$data['Petitioner'] = $this->NameCorrectionModel->getPetitionerInfo($misc_case_no, $patta_no, $petition_no);
        $data['Petitioner'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
		$data['lm_report'] = $this->NameCorrectionModel->getLmreport($misc_case_no,$petition_no);
		$this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $application_no="select * from basundhar_application where dharitree=? ";
        $data['app'] = $app_details = $this->db->query($application_no, array($misc_case_no))->row();
       // var_dump($data);

         $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }

         $dag_no = $data['miscCaseInfo']->dag_no;
          $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);
        
        $data['sup_doc']=$this->mutationmodel->getDocument($misc_case_no);

        //FOR AADHAAR DETAILS-----------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //----END OF AADHAR DETAILS----------------

        $data['_view'] = 'NameCancellation/SKStep2';
        $this->load->view('layouts/main',$data);
    }
	
    public function COFinalOrderMiscCase2(){
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }

        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $this->db->query($application_no)->row();

         $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        // $this->load->view('../views/NameCancellation/COFinalOrderMiscCase2', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/COFinalOrderMiscCase2';
        $this->load->view('layouts/main',$data);
    }
    public function ViewASTReport(){
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        //var_dump($data['miscCaseInfo']);
        $data['ast_report']=  $this->NameCancellationModel->getASTReport($misc_case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        // $this->load->view('../views/NameCancellation/ViewASTReport', $data);
        // $this->load->view('../views/footer');

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);

        $data['_view'] = 'NameCancellation/ViewASTReport';
        $this->load->view('layouts/main',$data);
    }
    public function COFinalOrderMiscCase2_save(){
		//$db=  $this->session->userdata('db');
        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('petition_no');
        $co_report = $this->input->post('co_report');
        $note_date = date('Y-m-d');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
        $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$misc_case_no'";
        $result = $this->db->query($sql);
        $note_no = ($result->row()->note_no) + 1;
        $status = '10';
        $operation = 'c';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $co_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation
        );
        $this->session->set_userdata($userdata);
        $this->db->insert("misc_case_process_reports", $userdata);
		$this->session->set_userdata('petition_no',$petition_no);
        $updateSqlBasic = "update   misc_case_basic set  date_of_operation='$note_date',  "
                . " status='$status', user_code='$user_code' where misc_case_no='$misc_case_no' ";
        $this->db->query($updateSqlBasic);
        
        redirect(base_url() . "index.php/NameCancellation/OrderBasic/".$petition_no);
    }
    public function OrderBasic($petition_no){
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
		//var_dump($this->session->all_userdata());
        $misc_case_no = $this->session->userdata('misc_case_no');
       // $petition_no = $this->session->userdata('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $patta_type_code=$data['miscCaseInfo']->patta_type_code;
        //find the pdar_id
        $pdardata=$this->NameCorrectionModel->getPdarIDMisc($misc_case_no,$petition_no);
        $pdar_id=$pdardata->petition_pdar_id;
        $pdar_name=$pdardata->petition_pdar_name_old;
        $dag_no=$data['miscCaseInfo']->dag_no;
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no'=>$dag_no,
            'year_no'=>$year_no,
            'petition_no'=>$misc_case_petition_no,
            'case_no'=>$misc_case_no,
            'patta_no'=>trim($patta_no),
            'patta_type_code'=>$patta_type_code,
            'pdar_id'=>$pdar_id
        );
        $this->session->set_userdata($userata);
        $add_to_officer=$data['miscCaseInfo']->add_to_officer;
        $data['orderNo']=  $this->NameCorrectionModel->getOrderNo();
        $data['landtype']=  $this->APCancellationModel->getLandType();
        $data['LMList'] = $this->APCancellationModel->getLMList($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['SKList'] = $this->APCancellationModel->getSKList($dist_code, $subdiv_code, $cir_code);
        $data['COList'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code,$add_to_officer);
        $data['LmSignDate'] = $this->NameCorrectionModel->getLMSignDate($misc_case_no);
        $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
        $data['COSignDate'] = $this->NameCorrectionModel->getCOSignDate($misc_case_no);
        // $this->load->view('../views/NameCancellation/OrderBasic', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/OrderBasic';
        $this->load->view('layouts/main',$data);
    }
    public function OrderBasic_save(){
        
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_townprt_code');
        $dag_no=$this->session->userdata('dag_no');
        $year_no=$this->session->userdata('year_no');
        $petition_no=$this->session->userdata('petition_no');
        $case_no=$this->session->userdata('case_no');
        
        $ord_no=$this->input->post('ord_no');
        $ord_date1=$this->input->post('ord_date');
        
        $ord_date= date("Y-m-d", strtotime($ord_date1));
        
        
        $ord_type_code=$this->input->post('ord_type_code');
        $ord_passby_sign_yn=$this->input->post('ord_passby_sign_yn');
        //$case_no=$this->input->post('case_no');
        $ord_on_gl_type=$this->input->post('ord_on_gl_type');
        $ord_passby_desig=$this->input->post('ord_passby_desig');
        $ord_ref_let_no=$this->input->post('ord_ref_let_no');
        $lm_code=$this->input->post('lm_code');
        $lm_sign=$this->input->post('lm_sign');
        $lm_sign_date1=$this->input->post('lm_sign_date');
        
         $lm_sign_date= date("Y-m-d", strtotime($lm_sign_date1));
         
        $sk_code=$this->input->post('sk_code');
        $sk_sign=$this->input->post('sk_sign');
        $sk_sign_date1=  $this->input->post('sk_sign_date');
        
         $sk_sign_date= date("Y-m-d", strtotime($sk_sign_date1));
         
         
        $co_code=$this->input->post('co_code');
        $co_sign=$this->input->post('co_sign');
        $co_sign_date1=  $this->input->post('co_sign_date');
        
         $co_sign_date= date("Y-m-d", strtotime($co_sign_date1));
         
         
        $wrt1=$this->input->post('wrt1');
        $wrt2=$this->input->post('wrt2');
        $wrt3=$this->input->post('wrt3');
        $wrt4=$this->input->post('wrt4');
        $wrt5=$this->input->post('wrt5');
        
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no'=>$dag_no,
            'year_no'=>$year_no,
            'petition_no'=>$petition_no,
            'ord_no'=>$ord_no,
            'ord_date'=>$ord_date,
            'ord_type_code'=>$ord_type_code,
            'case_no'=>$case_no,
//            'ord_on_gl_type'=>$ord_on_gl_type,
            'ord_passby_sign_yn'=>$ord_passby_sign_yn,
            'ord_passby_desig'=>$ord_passby_desig,
            'ord_ref_let_no'=>$ord_ref_let_no,
            'lm_code'=>$lm_code,
            'lm_sign_yn'=>$lm_sign,
            'lm_sign_date'=>$lm_sign_date,
             'sk_code'=>$sk_code,
            'sk_sign_yn'=>$sk_sign,
            'sk_sign_date'=>$sk_sign_date,
            'co_code'=>$co_code,
            'co_sign_yn'=>$co_sign,
            'co_ord_date'=>$co_sign_date,
            'wrt_order1'=>$wrt1,
            'wrt_order2'=>$wrt2,
            'wrt_order3'=>$wrt3,
            'wrt_order4'=>$wrt4,
            'wrt_order5'=>$wrt5
        );
        $this->session->set_userdata($userata);
        $this->db->insert("t_chitha_rmk_ordbasic", $userata);
        redirect(base_url() . "index.php/NameCancellation/InFavorOf");
    }
    public function InFavorOf(){
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        
        $misc_case_no = $this->session->userdata('misc_case_no');
        $petition_no=$this->session->userdata('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code=$data['miscCaseInfo']->patta_type_code;
        //need to be change
        $data['info']=$this->NameCancellationModel->getPdarIDMisc($misc_case_no);
        $row=count($data['info']);
        if($row==0){
            redirect(base_url() . "index.php/NameCancellation/SecondParty");
        }
        $pdar_id=$data['info']->petition_pdar_id;
        $pdar_name=$data['info']->petition_pdar_name_old;
        $infavor_of_corrected_name=$data['info']->petition_pdar_name_new;
        //need to be change//need to be change
        //$data['pdarinfo']=$this->NameCorrectionModel->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$vill_code,$patta_no,$patta_type_code, $pdar_id);
        $data['pdarinfo'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
		//var_dump($data['pdarinfo']);
		$data['inFavID']=  $this->NameCorrectionModel->getMiscID($misc_case_no);
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' =>$subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no'=>$this->session->userdata('dag_no'),
            'year_no'=>$year_no,
            'petition_no'=>$misc_case_petition_no,
            'infavor_of_id'=>'infavid', //
            'ord_no'=>$this->session->userdata('ord_no'),
            'ord_date'=>$this->session->userdata('ord_date'),
            'patta_type_code'=>$patta_type_code,
            'patta_no'=>trim($patta_no),
                'pdar_id'=>  $pdar_id,
                'infavor_of_name'=>$pdar_name,
                'infavor_of_guardian'=>$data['pdarinfo']->pdar_father,
                'infav_of_guar_relation'=>$data['pdarinfo']->pdar_guard_reln,
                'infavor_of_add1'=>$data['pdarinfo']->pdar_add1,
                'infavor_of_add2'=>$data['pdarinfo']->pdar_add2,
                'by_right_of'=>'06',
                'land_area_b'=>0,
                'land_area_k'=>0,
                'land_area_lc'=>0,
                'land_area_g'=>0,
                'land_area_kr'=>0,
                'infavor_of_corrected_name'=>$infavor_of_corrected_name
            );
          //  var_dump($userata);
        $data['landType']=$this->APCancellationModel->getPattaName($patta_type_code);
        // $this->load->view('../views/NameCancellation/InFavorOf',$data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/InFavorOf';
        $this->load->view('layouts/main',$data);
        
    }
    public function InFavorOf_save(){
        $misc_case_no = $this->session->userdata('misc_case_no');
		$petition_no=$this->session->userdata('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code=$data['miscCaseInfo']->patta_type_code;
        
        $data['info']=$this->NameCancellationModel->getPdarIDMisc($misc_case_no);
        $pdar_id=$data['info']->petition_pdar_id;
//        $pdar_name=$data['info']->petition_pdar_name_old;
//        $infavor_of_corrected_name=$data['info']->petition_pdar_name_new;
        
        $data['pdarinfo']=$this->NameCorrectionModel->PdarInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,$vill_code,$patta_no,$patta_type_code, $pdar_id);
        
        $data['inFavID']=  $this->NameCorrectionModel->getMiscID($misc_case_no);
        $userata = array(
            'dist_code' => $dist_code,
            'subdiv_code' =>$subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'dag_no'=>$this->session->userdata('dag_no'),
            'year_no'=>$year_no,
            'petition_no'=>$misc_case_petition_no,
            'infavor_of_id'=>  $this->input->post('infavor_of_id'),
            'ord_no'=>$this->session->userdata('ord_no'),
            'ord_date'=>$this->session->userdata('ord_date'),
            'patta_type_code'=>$patta_type_code,
            'patta_no'=>trim($patta_no),
                'pdar_id'=>  $pdar_id,
                'infavor_of_name'=>$this->input->post('infavor_of_name'),
                'infavor_of_guardian'=>$this->input->post('infavor_of_guardian'),
                'infav_of_guar_relation'=>$this->input->post('infav_of_guar_relation'),
                'infavor_of_add1'=>$this->input->post('infavor_of_add1'),
                'infavor_of_add2'=>$this->input->post('infavor_of_add2'),
                'by_right_of'=>'07',
                'land_area_b'=>0,
                'land_area_k'=>0,
                'land_area_lc'=>0,
                'land_area_g'=>0,
                'land_area_kr'=>0,
                'revenue'=>0
            );
            //var_dump($userata);
            
            $today=date('Y-m-d');
            $user_code=$this->session->userdata('user_code');
            $this->db->insert("t_chitha_rmk_infavor_of", $userata);
            $updateSql="update  misc_case_first_party set user_code='$user_code', operation='E' where misc_case_no='$misc_case_no'";
            $this->db->query($updateSql);
            
            $updateSql1="update  misc_case_basic set status='10', user_code='$user_code', date_of_operation='$today' where misc_case_no='$misc_case_no'";
            $this->db->query($updateSql1);

            redirect(base_url() . "index.php/NameCancellation/InFavorOf");
    }
    public function SecondParty(){
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        
        $misc_case_no = $this->session->userdata('misc_case_no');
        $petition_no = $this->session->userdata('petition_no');
		
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code=$data['miscCaseInfo']->patta_type_code;
        $dag_no=$data['miscCaseInfo']->dag_no;
        //need to be change
        //$data['info']=$this->NameCancellationModel->getPdarIDMiscSecondParty($misc_case_no);
        $data['pdarinfo'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);
        $data['inFavID']=  $this->NameCorrectionModel->getMiscID($misc_case_no);
        
        $data['_view'] = 'NameCancellation/SecondParty';
        $this->load->view('layouts/main',$data);
    }
    public function SecondParty_save(){
        $misc_case_no = $this->session->userdata('misc_case_no');
        $petition_no = $this->session->userdata('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;
        $patta_no = TRIM($data['miscCaseInfo']->patta_no);
        $patta_type_code=$data['miscCaseInfo']->patta_type_code;
        $dag_no=$data['miscCaseInfo']->dag_no;
        //need to be change
        $data['info']=$this->NameCancellationModel->getPdarIDMiscSecondParty($misc_case_no);
        //var_dump($data['info']);
        $row=count($data['info']);
        // if($row==0){
        //     //echo "No data123123";
        //     redirect(base_url() . "index.php/NameCancellation/NameCancellation_finish");
        // }
        $pdar_id=$data['info']->opp_pdar_id;
        $data['inFavID']=  $this->NameCorrectionModel->getMiscID($misc_case_no);
        $data['pdarinfo']=$pinfo = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);
            foreach($pinfo as $p){
                $userata = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' =>$subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no'=>$this->session->userdata('dag_no'),
                    'ord_no'=>$misc_case_no,
                    'ord_date'=>date('Y-m-d'),
                    'name_for_id'=>$p->pdar_id, //
                    'name_for'=>$p->pdar_name,
                    'name_for_guardian'=>$p->pdar_father,
                    'name_for_guar_relation'=>$p->pdar_guard_reln,
                    'case_type_code'=>$this->input->post('case_type_code'),     
                    'name_for_land_b'=>0,
                    'name_for_land_k'=>0,
                    'name_for_land_lc'=>0,
                    'name_for_land_g'=>0,
                    'name_for_land_kr'=>0,
                    'case_no'=>$misc_case_no
                );
                $this->db->insert("t_chitha_rmk_other_opp_party", $userata);
            }
           //var_dump($userata);
           $user_code=$this->session->userdata('user_code');
           $updateSql1="update   misc_case_basic set  user_code='$user_code', operation='E' where misc_case_no='$misc_case_no'";
           $this->db->query($updateSql1);
		   $this->updateChitha($misc_case_no,$misc_case_petition_no);
            ////////////////////
           $this->DashboardDataFinal($misc_case_no);

           $basundhara=$this->db->query("select basundhara from basundhar_application where dharitree='$misc_case_no' ")->row()->basundhara;

           if($basundhara)
            {
               $rtps=$this->rtpsmodel->checkRtpsService($basundhara);
               if($rtps=='RTPS'){
                   $apilink=RTPS_API_LINK;
               }else{
                   $apilink=API_LINK;
               }
               $curl_handle = curl_init();
               curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
               curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
               curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
               curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                   'application' => $basundhara,
                   'dharitree' => $misc_case_no,
                   'rmk' => 'Approved',
                   'status' => 'F',
                   'task' => 'CO',
                   'pen'=>'NA',
                   'penat'=>'Circle office'
               )));
               $result = curl_exec($curl_handle);
           }

		   redirect(base_url() . "index.php/NameCancellation/NameCancellation_finish");
           //redirect(base_url() . "index.php/NameCancellation/SecondParty");
    }
    public function NameCancellation_finish(){
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/NameCancellation/NameCancellation_finish');
        // $this->load->view('../views/footer');

        $data['_view'] = 'NameCancellation/NameCancellation_finish';
        $this->load->view('layouts/main',$data);
    }
	public function updateChitha($case_no,$misc_case_petition_no) {
		$db=  $this->session->userdata('db');
        //$case_no='GOL/GOL/2017-18/2/MiND';
       // $misc_case_petition_no='2';
		$sql="Select case_no from    t_chitha_rmk_other_opp_party where case_no='$case_no' AND iscorrected_inco is null ";
        $q = "select * from    misc_case_basic mcb,t_chitha_rmk_infavor_of c8 where " .
                "mcb.dist_code = c8.dist_code and mcb.subdiv_code = c8.subdiv_code and mcb.cir_code= c8.cir_code and " .
                "mcb.lot_no = c8.lot_no and mcb.mouza_pargona_code = c8.mouza_pargona_code and mcb.vill_townprt_code = " .
                "c8.vill_townprt_code and mcb.misc_case_no=c8.ord_no and TRIM(mcb.patta_no) = TRIM(c8.patta_no) and c8.iscorrected_inco is null and c8.ord_no='$case_no' and c8.petition_no = '$misc_case_petition_no' and c8.ord_no in ($sql) ";

        $data = $this->db->query($q)->result();
        $ord_cron_no = 1;
        foreach ($data as $d) {

			$dist_code = $d->dist_code;
            $subdiv_code = $d->subdiv_code;
            $cir_code = $d->cir_code;
            $lot_no = $d->lot_no;
            $mouza_pargona_code = $d->mouza_pargona_code;
            $vill_townprt_code = $d->vill_townprt_code;
            $dag_no = $d->dag_no;
            $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
                    . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code'";
            $rmk_type_hist_no = $this->db->query($q)->row()->c2;
            echo $rmk_type_hist_no . "<br>";

            if ($rmk_type_hist_no == null) {
                $rmk_type_hist_no = 1;
            }
            //echo $d->pdar_id;
            //echo $d->infavor_of_corrected_name;
            

            $query = "select * from    t_chitha_rmk_infavor_of where ord_no='$d->ord_no'";
            $infve = $this->db->query($query)->result();
            foreach ($infve as $infv) {
                unset($infv->year_no);
                unset($infv->petition_no);
                unset($infv->pdar_id);
                unset($infv->revenue);
                unset($infv->iscorrected_inco);
                unset($infv->iscorrected_inco_date);
                unset($infv->iscorrected_rkg_record);
                unset($infv->iscorrected_rkg_date);
                unset($infv->infavor_is_copdar);
                unset($infv->make_mdb);
                unset($infv->new_pattadar);
                unset($infv->iscorrected_inco_date);
                $infv->rmk_type_hist_no = $rmk_type_hist_no;
                $infv->ord_cron_no = $ord_cron_no++;
                $infv->user_code = $this->session->userdata('user_code');
                $infv->date_entry = date('Y-m-d');
                $infv->operation = 'E';
                $this->db->insert("chitha_rmk_infavor_of", $infv);
                $query = "update  t_chitha_rmk_infavor_of set iscorrected_inco='Y' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
                        " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and ord_no='$case_no' and petition_no = '$misc_case_petition_no'";
                $this->db->query($query);
            }
			$query = "select * from    t_chitha_rmk_other_opp_party where case_no='$d->ord_no'";
            $ordparty = $this->db->query($query)->result();
            foreach ($ordparty as $infv) {
                unset($infv->iscorrected_inco);
                unset($infv->iscorrected_inco_date);
                unset($infv->iscorrected_rkg_record);
                unset($infv->iscorrected_rkg_date);
                unset($infv->infavor_is_copdar);
                unset($infv->make_mdb);
                unset($infv->new_pattadar);
                unset($infv->case_no);
                $infv->rmk_type_hist_no = $rmk_type_hist_no;
                $infv->ord_cron_no = $ord_cron_no++;
                $infv->user_code = $this->session->userdata('user_code');
                $infv->date_entry = date('Y-m-d');
                $infv->operation = 'E';
				//var_dump($infv);
                $this->db->insert("chitha_rmk_other_opp_party", $infv);
                $query = "update  t_chitha_rmk_other_opp_party set iscorrected_inco='Y' where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
                        " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and case_no='$d->ord_no' ";
                $this->db->query($query);
			//    $query = "update  chitha_dag_pattadar set p_flag='1',jama_yn=null where TRIM(patta_no)=trim('$d->patta_no') and " .
            //         "  pdar_id=$infv->name_for_id and dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' " .
            //         " and lot_no='$d->lot_no' and  mouza_pargona_code='$d->mouza_pargona_code' and dag_no='$dag_no' and vill_townprt_code='$d->vill_townprt_code'";
            //     $this->db->query($query);
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
                'dag_no'             => $details->dag_no,
                'patta_type_code'    => $details->patta_type_code,
                'pdar_id'            => $inplace->pdar_id,
            ];

            // Trim patta_no before using in where
            $where['patta_no'] = trim($details->patta_no);

            // Call model update
            $this->Chitha_basic_model->update_table($table, $params, $where);

            }
            $d = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'ord_no' => $case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '07',
                'ord_cron_no' => $ord_cron_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => 'CO',
                'co_sign_yn' => 'Y',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => 0.0,
                'm_dag_area_k' => 0.0,
                'm_dag_area_lc' => 0.0,
                'm_dag_area_g' => 0.0,
                'm_dag_area_kr' => 0.0,
                'area_left_b' => 0.0,
                'area_left_k ' => 0.0,
                'area_left_lc' => 0.0,
                'area_left_g' => 0.0,
                'area_left_kr' => 0.0,
            );
			
            $this->db->insert("chitha_rmk_ordbasic", $d);
            $d = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
            );
            $this->db->insert("chitha_rmk_gen", $d);
            // $this->db->query("update  chitha_basic set jama_yn=null where dist_code='$d[dist_code]' and subdiv_code='$d[subdiv_code]' and cir_code='$d[cir_code]' " .
            //         " and lot_no='$d[lot_no]' and  mouza_pargona_code='$d[mouza_pargona_code]' and vill_townprt_code='$d[vill_townprt_code]'");
            $table = "chitha_basic";
            $data = ['jama_yn' => null];

            $where = [
                'dist_code'          => $d['dist_code'],
                'subdiv_code'        => $d['subdiv_code'],
                'cir_code'           => $d['cir_code'],
                'lot_no'             => $d['lot_no'],
                'mouza_pargona_code' => $d['mouza_pargona_code'],
                'vill_townprt_code'  => $d['vill_townprt_code']
            ];
            $result_cb = $this->Chitha_basic_model->update_table($table, $params, $where);
        }
    }
	public function getPdarData($pdar_id) {
		//$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_townprt_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $data = $this->NameCorrectionModel->getPdarDataJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code, $pdar_id);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('pdar_id' => $object->pdar_id, 'pdar_name' => $object->pdar_name, 'pdar_father' => $object->pdar_father, 'pdar_add1' => $object->pdar_add1, 'pdar_add2' => $object->pdar_add2, 'pdar_guard_reln' => $object->pdar_guard_reln);
        }
        echo json_encode($json);
    }


     /////////////////////////
      public function COFinalOrderMiscCase1($type) {

         $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        // $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $user_code = $this->session->userdata('user_code');
        $config['base_url'] = base_url() . '/index.php/NameCorrection/COFinalOrderMiscCase1/';
        $data['countMiscCase'] = $this->NameCorrectionModel->getFinalOrderMisc($user_code);
        $cases['TotMisc'] = $this->NameCorrectionModel->getFinalOrderMiscDeletion($user_code)->result();
        $case_array = array();
        foreach ($cases['TotMisc'] as $c) {
            $q = $this->db->query("select misc_case_type,misc_case_no,submission_date,es_flag,is_escalated from    misc_case_basic where status='02' and lm_note_yn='Y' and sk_note_yn='Y'")->row();
            array_push($case_array, $c);
        }
        $data['MisCases'] = $case_array;
        $data['type'] = $type;


        if(ESCALATION_ENABLE == 1){
            foreach($data['MisCases'] as $rows) {
               if($rows->es_flag == '1'){
                  $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);
                  log_message('error', '#1595: From escalation_detail_table : '.json_encode($escRow));
                  if(!empty($escRow) && $escRow != null)  {
                     $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
                     log_message('error', '#1600: Escalation details : '.json_encode($escData));
                     $rows->escalation_date = $escData->escalation_date;
                     $rows->escalation_zone = $escData->escalation_zone;
                     $rows->assigned_date   = $escData->assigned_date;
                  }
                  else {
                     $rows->escalation_date = 'NA';
                     $rows->escalation_zone = 'NA';
                  }
               }
               else {
                  $rows->escalation_date = 'NA';
                  $rows->escalation_zone = 'NA';
               }
            }
        }

        // $this->load->view('../views/NameCorrection/COFinalOrderMiscCase1', $data);
        // $this->load->view('../views/footer');
        // $data['_view'] = 'NameCorrection/COFinalOrderMiscCase1';==changes for escalation
        $data['_view'] = 'NameCancellation/COFinalOrderMiscCase1';
        $this->load->view('layouts/main',$data);
    }
    ///////

     function Dashboard($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no  where pb.misc_case_no='$case_no' ";
            $data=$this->db->query($sql)->row_array();
            $type='MC';
            $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'CO',
                  'case_type' =>$type,
                  'date_of_insert'=>date("Y-m-d h:i:s")
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
             
            
            $applicant= array(
                'case_no' => $data['case_no'],
                'applicant_name' => $data['pet_name'],
                'guardian_name' => 'NA',
                'gender' => 'NA' );
            $this->dbb->insert('dashboard_applicant',$applicant);
            $action= array(
                'case_no' =>$data['case_no'],
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date('Y-m-d'),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => 'Registered By Assistant',
                 );
             $this->dbb->insert('dashboard_action',$action);
        }
        function DashboardData($case_no,$penUser,$rmrk){
            //////////////Update Dashboard Database///////////////////////
                    $this->dbb = $this->load->database('dash', TRUE);
                    $base=array(
                        'pending_with_user' => $penUser,
                        'date_of_update'=>date("Y-m-d h:i:s")
                    );
                    $this->dbb->where('case_no',$case_no);
                    $this->dbb->update('dashboard_data',$base);


                $this->db->where('case_no',$case_no);
                $this->db->update('dashboard_data',$base);

                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date('Y-m-d'),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => $rmrk,
                         );
                    $this->dbb->insert('dashboard_action',$action);
                /////////////////////////////////////
        }
        function DashboardDataFinal($case_no){
            //////////////Update Dashboard Database///////////////////////
                        $this->dbb = $this->load->database('dash', TRUE);
                        $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'F',
                            'remark'=>'Final Order Passed',
                            'date_of_update'=>date("Y-m-d h:i:s")
                        );
                        $this->dbb->where('case_no',$case_no);
                        $this->dbb->update('dashboard_data',$base);


                $this->db->where('case_no',$case_no);
                $this->db->update('dashboard_data',$base);

                        $action= array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_of_action_taken' => date('Y-m-d'),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => 'Final Order Passed',
                             );
                        $this->dbb->insert('dashboard_action',$action);
                /////////////////////////////////////
        }

        function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'R',
                            'remark'=>'Case Rejected',
                            'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $this->db->where('case_no',$case_no);
                $this->db->update('dashboard_data',$base);
                // $action= array(
                //     'case_no' => $case_no,
                //     'user_code' => $this->session->userdata('user_code'),
                //     'date_of_action_taken' => date('Y-m-d'),
                //     'user_designation' => $this->session->userdata('user_desig_code'),
                //     'remark' => 'Rejected',
                //      );
                // $this->dbb->insert('dashboard_action',$action);
            }
            //////////21-03-2022////////////////
public function finalOrderCONameCancellation()
    {

      $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
      if($_GET['misc_case_no'] == null)
      {
         echo json_encode('Sorry !! You are not Authorized to access the content!!');
         return;
      }

      $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');

        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no,$petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);

        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }

        $application_no="SELECT * FROM basundhar_application WHERE dharitree=?";
        $data['app'] = $app_details = $this->db->query($application_no, array($misc_case_no))->row();

        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        
        $dag_no=$data['miscCaseInfo']->dag_no;
        $patta_no=$data['miscCaseInfo']->patta_no;

        $query = "SELECT mc.user_code FROM misc_case_process_reports mc 
        JOIN misc_case_basic mb ON mb.misc_case_no=mc.misc_case_no WHERE 
        mb.misc_case_no=? and mc.operation=?";

        $lmcode = $this->db->query($query, array($misc_case_no, 'l'))->row()->user_code;
         if($data['miscCaseInfo']->es_flag == 0){
            $skcode = $this->db->query($query, array($misc_case_no, 's'))->row()->user_code;
            $data['skname'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $skcode);
            $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
            $data['sk_report'] = $this->NameCorrectionModel->getSKReport($misc_case_no,$petition_no);
         }

        $data['lmname'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lmcode);
        $data['skname'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $skcode);

        $data['LmSignDate'] = $this->NameCorrectionModel->getLMSignDate($misc_case_no);
        $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
        //////////////////////////////////////////////////////////
        $data['ast_report']=  $this->NameCancellationModel->getASTReport($misc_case_no);
        $data['lm_report'] = $this->NameCorrectionModel->getLMReport($misc_case_no,$petition_no);
        $data['sk_report'] = $this->NameCorrectionModel->getSKReport($misc_case_no,$petition_no);
        //////////////////////////////////////////////////////////

        $data['es_flag'] = $data['miscCaseInfo']->es_flag;
        
        /////////////////  /////////////////////////////////////////
        if($data['miscCaseInfo']->es_flag == 1 && ESCALATION_ENABLE == 1){
            $data['skname'] = null;
            $data['sk_report'] = null;
            $data['SkSignDate'] = null;
        }else{
            $skcode = $this->db->query($query, array($misc_case_no, 's'))->row()->user_code;
            $data['skname'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $skcode);
            $data['SkSignDate'] = $this->NameCorrectionModel->getSKSignDate($misc_case_no);
            $data['sk_report'] = $this->NameCorrectionModel->getSKReport($misc_case_no,$petition_no);
        }
        $data['sup_doc']=$this->mutationmodel->getDocument($misc_case_no);

        $data['pet'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);

        $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);

        //AADHAAR DETAIL DISPLAY-------------------------
        $app_no = $app_details->basundhara;//from basundhar_application
        $output = $this->AuthorizationModel->checkApiAuth('serviceResponse?application_no=', $app_no);
        if($output) {
            $data['selfDecData'] = null;
            $data['aadhaarData'] = null;
            $data['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $data['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->applicants as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $data['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $data['aadhaarPhoto'] = $output->photo;
            }
        }
        //END OF AADHAAR DETAILS------------------------------


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
        $this->load->model('propChain/PropChainModel');
        // echo "<pre>";
        // var_dump($data['Petitioner']);
        // die;
        // var_dump($propData['dist_code']);

        $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);

        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $data['miscCaseInfo']->dag_no);

        $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);


        if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
            $this->PropChainModel->updateCmpFlag($misc_case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
            // if mismatch case get the view mismatch case button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($misc_case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,  $patta_no, $data['miscCaseInfo']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $patta_type_code);
        }

        $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
        $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

        if ($data['ulpinCheck'] == 1) {
            $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
            if (isset($checkPropAndChithaAndUlpn['old_ulpin']))
                $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
            else
                $data['old_ulpin'] = "";
        }

        // if property does not exists get create asset button
        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
            $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
        }
        $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
        $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
        $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
        $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];

        // hidden fields
        $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
        $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
        $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
        $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

         // bhunaksha area cmp
         $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
         $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
         $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
         $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }

         //ESCALATED CASES REMARK ENTRY FORM==============
         if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1)
         {
             $remainingTime = $this->Escalationmodel->calculateRemainingTime($misc_case_no,$this->session->userdata('user_desig_code'));
             $data['remainingTime'] = $remainingTime;
             $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($misc_case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
             if(isset($escRemarkData) && !empty($escRemarkData))
             {
                 $data['escRemarkData'] = $escRemarkData;
             }
         }
         ///END REMARKS/////////


        $data['_view'] = 'NameCancellation/finalOrderPassCONameCancel';
        $this->load->view('layouts/main',$data);    
    
    }


    public function finalOrderCONameCancellation_save()
    {

      $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        //checking for empty remark field
        $this->form_validation->set_rules('co_report', 'Remarks', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message',"CO Remark field is required");
            redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
            //check for Malicious
            $validquery = checkRequestValidQuery($_POST, [], ['infavor_of_name' => true, 'co_report' => true]);
            if($validquery['status']=='n') {
                //ERRNMECANCCO0011
                log_message('error', $validquery['messages'] .'Error: ERRNMECANCCO0011');
                $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECANCCO0011');
                redirect(base_url('index.php/NameCancellation/COFinalOrderMiscCase1/07'));
            }
            //syntax validation
            //ERRNMECANCCO0007 $checkSpclChar['messages'] .
            $checkSpclChar = checkRequestSpecChar($_POST, [], [], ['infavor_of_name' => true, 'co_report' => true]);
            // echo '<pre>';
            // var_dump($_POST, $checkSpclChar);
            // die();
            if($checkSpclChar['status']=='n') {
                log_message('error', 'Input Parameter has illegal character. Error: ERRNMECANCCO0007');
                $this->session->set_flashdata('message', 'Input Parameter has illegal character. Error: ERRNMECANCCO0007');
                redirect(base_url('index.php/NameCancellation/COFinalOrderMiscCase1/07'));
            }
            //form validation
            //ERRNMECANCCO0008
            $formResult = $this->FormValidationModel->formValidationForPost($_POST, [
                'application_no'=>'Application No|required|application_no',
                'co_report'=>'CO Report|required',
                'ord_type_code'=>'Order Type Code|digit',
                // 'ord_passby_desig'=>'',
                'dag_no'=>'Dag No.|digit',
                // 'lm_code'=>'',
                'lm_sign_date'=>'LM Sign Date|date',
                // 'sk_code'=>'',
                'sk_sign_date'=>'SK Sign Date|date',
                // 'ord_ref_let_no'=>'',
                'misc_case_no'=>'Misc Case No.|case_no',
                'misc_case_petition_no'=>'Misc Case Petition No.|digit',
                'ord_passby_sign_yn'=>'Order Passby Sign|char',
                'lm_sign'=>'LM Sign|char',
                'sk_sign'=>'SK Sign|char',
                'co_sign'=>'CO Sign|char',
                'ord_date'=>'Order Date|date',
                // 'infavor_of_name'=>''
            ]);
            // $formResult = postParamFormValidation($_POST, [
            //     'application_no'=>'application_no',
            //     'ord_type_code'=>'digit',
            //     'ord_passby_desig'=>'',
            //     'dag_no'=>'digit',
            //     'lm_code'=>'',
            //     'lm_sign_date'=>'date',
            //     'sk_code'=>'',
            //     'sk_sign_date'=>'date',
            //     'ord_ref_let_no'=>'',
            //     'co_report'=>'',
            //     'misc_case_no'=>'case_no',
            //     'misc_case_petition_no'=>'digit',
            //     'ord_passby_sign_yn'=>'char',
            //     'lm_sign'=>'char',
            //     'sk_sign'=>'char',
            //     'co_sign'=>'char',
            //     'ord_date'=>'date',
            //     'infavor_of_name'=>''
            // ]);
            if($formResult['status']=='n') {
                log_message('error', 'Message: '. $formResult['message'] .', Data: '. json_encode($formResult['data']) .'. Error: ERRNMECANCCO0008');
                $this->session->set_flashdata('message', $formResult['message'] .'. Error: ERRNMECANCCO0008');
                redirect(base_url('index.php/NameCancellation/COFinalOrderMiscCase1/07'));
            }

            //authorization
            $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'CO', $_POST['misc_case_no']);
            if($response['status']=='n') {
                //ERRNMECANCCO0009
                log_message('error', $response['messages'] .' Error: ERRNMECANCCO0009');
                $this->session->set_flashdata('message', $response['messages'].' Error: ERRNMECANCCO0009');
                redirect(base_url('index.php/home'));
            }
            //authentication
            //ERRNMECANCCO0009
            // $sessionData = $this->session->all_userdata();
            // if(empty($sessionData)) {
            //     log_message('error', 'User not logged in! Error: ERRNMECANCCO0009');
            //     $this->session->set_flashdata('message', 'User not logged in! Error: ERRNMECANCCO0009');
            //     redirect(base_url('index.php/home'));
            // }

            //authorization
            //ERRNMECANCCO0010
            
            // if($sessionData['user_desig_code']!='CO' || $sessionData['dist_code']!=$miscCaseInfo->dist_code || $sessionData['subdiv_code']!=$miscCaseInfo->subdiv_code || $sessionData['cir_code']!=$miscCaseInfo->cir_code) {
            //     log_message('error', 'User not authorized! Error: ERRNMECANCCO0010');
            //     $this->session->set_flashdata('message', 'User not authorized! Error: ERRNMECANCCO0010');
            //     redirect(base_url('index.php/home'));
            // }


            $miscCaseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
            $val = $this->input->post();
            
            $misc_case_no = $val['misc_case_no'];
            $petition_no = $val['misc_case_petition_no'];

            $redirectUrl = base_url().'index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='.$misc_case_no.'&petition_no='.$petition_no;

            $co_report = $val['co_report'];
            $letter_no = $val['ord_ref_let_no'];
            $note_date = date('Y-m-d');

            // $miscCaseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
            $dist_code = $miscCaseInfo->dist_code;
            $subdiv_code = $miscCaseInfo->subdiv_code;
            $cir_code = $miscCaseInfo->cir_code;
            $mouza_pargona_code = $miscCaseInfo->mouza_pargona_code;
            $lot_no = $miscCaseInfo->lot_no;
            $vill_code = $miscCaseInfo->vill_townprt_code;
            $patta_type_code = $miscCaseInfo->patta_type_code;
            $pattaType = $this->APCancellationModel->getPattaName($patta_type_code);
            $dag_no = trim($miscCaseInfo->dag_no);
            $patta_no = trim($miscCaseInfo->patta_no);
            $year_no = $miscCaseInfo->year_no;
            $user_code = $this->session->userdata('user_code');

            $info = $this->NameCancellationModel->getPdarIDMisc($misc_case_no);
            $pdar_id = $info->petition_pdar_id;

            $inFavID = $this->NameCorrectionModel->getMiscID($misc_case_no);

            $secondParty = $this->NameCancellationModel->get2ndPartyInfo($dist_code, 
            $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, 
            $dag_no, $patta_type_code, $misc_case_no);

            $this->db->trans_begin();


            //==========check dag pending in blockchain or not=================
              if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
              {
                  $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$dag_no);
                  if($checkVal === false)
                  {
                      $this->db->trans_rollback();
                      $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6166 : You cannot procced as dag no is pending for property chain update...");
                      redirect(base_url() . "index.php/home");
                  }
              }
            ///=============end CODE=====================

            //check data if already exist in misc_case_basic
            $misc_case_basic = $this->db->query("SELECT misc_case_no FROM 
            misc_case_basic WHERE status=? AND user_code=? AND operation=?
            AND misc_case_no=? ", array('10', $user_code, 'E', $misc_case_no));
            if($misc_case_basic->num_rows() > 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#EXISTMCBOO1: Data alaready exist in 
                misc_case_basic for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#EXISTMCBOO1: Same detail already available for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

            //check data if already exist in misc_case_process_reports
            // $misc_case_process_reports = $this->db->query("SELECT misc_case_no FROM 
            // misc_case_process_reports WHERE dist_code=? AND subdiv_code=? AND cir_code=?
            // AND misc_case_no=? AND co_fresh_proceeding=? AND user_code=? AND operation=? 
            // AND note_no!=?",
            // array($dist_code, $subdiv_code, $cir_code, $misc_case_no, 'Y', $user_code, 'E', '1'));

            // if($misc_case_process_reports->num_rows() > 0)
            // {
            //     $this->db->trans_rollback();
            //     log_message('error', '#EXISTMCPR2: Data alaready available in 
            //     misc_case_process_reports for misc case no : '.$misc_case_no);
            //     $this->session->set_flashdata('message',"#EXISTMCPR2: Same detail already available for case no : ".$misc_case_no);
            //     redirect($redirectUrl);
            //     return false;
            // }


            //check data if already exist in t_chitha_rmk_ordbasic
            $t_chitha_rmk_ordbasic = $this->db->query("SELECT ord_no FROM 
            t_chitha_rmk_ordbasic WHERE dist_code=? AND subdiv_code=? AND cir_code=?
            AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
            AND ord_no=? AND dag_no=? AND year_no=?",
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_code, $misc_case_no, $dag_no, $year_no));

            if($t_chitha_rmk_ordbasic->num_rows() > 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#EXISTTCROB3: Data alaready exist in 
                t_chitha_rmk_ordbasic for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#EXISTTCROB3: Same detail already available for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }


            //check data if already exist in t_chitha_rmk_infavor_of
            $t_chitha_rmk_infavor_of = $this->db->query("SELECT ord_no FROM 
            t_chitha_rmk_infavor_of WHERE dist_code=? AND subdiv_code=? AND cir_code=?
            AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
            AND ord_no=? AND dag_no=? AND year_no=?",
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
            $vill_code, $misc_case_no, $dag_no, $year_no));

            if($t_chitha_rmk_infavor_of->num_rows() > 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#EXISTTCRIFO4: Data alaready exist in 
                t_chitha_rmk_infavor_of for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#EXISTTCRIFO4: Same detail already available for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

            $sql = "SELECT max(note_no)+1 AS note_no FROM misc_case_process_reports 
            WHERE misc_case_no = ?";
            $result = $this->db->query($sql, array($misc_case_no))->row();
            $note_no = $result->note_no;
            
            //insertion in misc_case_process_reports
            $processReport = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $misc_case_no,
                'co_fresh_proceeding' => 'Y',
                'process_note' => $co_report,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => 'c'
            ];
            $ins = $this->db->insert("misc_case_process_reports", $processReport);
            if($ins != 1){
                $this->db->trans_rollback();
                log_message('error', '#NDMCPR001: Insertion failed in misc_case_process_reports 
                for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#NDMCPR001: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

         $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$co_report);


          if($proInsert==false || $proInsert===false)
           {
               log_message('error', "#MISCCO001:".$this->db->last_query());
               $this->db->trans_rollback();       
               $this->session->set_flashdata('message', "Updation failed(#MISCCO001)".$misc_case_no);
               redirect(base_url() . "index.php/home");
           }

            //insertion in t_chitha_rmk_ordbasic
            $tchithaOrdBasic = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'ord_no' => $misc_case_no,
                'case_no' => $misc_case_no,
                'ord_passby_sign_yn' => $val['ord_passby_sign_yn'],
                'ord_passby_desig' => $val['ord_passby_desig'],
                'ord_ref_let_no' => $letter_no,
                'lm_code' => $val['lm_code'],
                'lm_sign_yn' => $val['lm_sign'],
                'lm_sign_date' => date('Y-m-d',strtotime($val['lm_sign_date'])),
                'sk_code' => $val['sk_code'],
                'sk_sign_yn' => $val['sk_sign'],
                'sk_sign_date' => date('Y-m-d',strtotime($val['sk_sign_date'])),
                'co_code' => $user_code,
                'co_sign_yn' => $val['co_sign'],
                'co_ord_date' => date('Y-m-d G:i:s'),
                'ord_date' => date('Y-m-d',strtotime($val['ord_date'])),
                'ord_type_code' => $val['ord_type_code']
            ];
            $tchithaIns = $this->db->insert("t_chitha_rmk_ordbasic", $tchithaOrdBasic);
            if($tchithaIns != 1){
                $this->db->trans_rollback();
                log_message('error', '#NDTCRO002: Insertion failed in t_chitha_rmk_ordbasic 
                for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#NDTCRO002: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

            //insertion in t_chitha_rmk_infavor_of
            $tchithaInfavor = [
                'dist_code' => $dist_code,
                'subdiv_code' =>$subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_no,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'infavor_of_id'=> $inFavID+1,
                'ord_no' => $misc_case_no,
                'ord_date' => date('Y-m-d G:i:s'),
                'patta_type_code' => $patta_type_code,
                'patta_no' => $patta_no,
                'pdar_id'=>  $pdar_id,
                'infavor_of_name' => $val['infavor_of_name'],
                'by_right_of'=>'07',
                'land_area_b'=>0,
                'land_area_k'=>0,
                'land_area_lc'=>0,
                'land_area_g'=>0,
                'land_area_kr'=>0,
                'revenue'=>0,
                'self_declaration' => $info->self_declaration,
                'id_ref_no' => $info->id_ref_no,
                'auth_type' => $info->auth_type,
                'photo' => $info->photo
            ];
            $tchithaInfavorIns = $this->db->insert("t_chitha_rmk_infavor_of", $tchithaInfavor);
            if($tchithaInfavorIns != 1){
                $this->db->trans_rollback();
                log_message('error', '#NDTCRIO003: Insertion failed in t_chitha_rmk_infavor_of 
                for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#NDTCRIO003: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

            //insertion in t_chitha_rmk_other_opp_party
            foreach($secondParty as $pdar){
                $tchithaOpp = [
                    'dist_code' => $dist_code,
                    'subdiv_code' =>$subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $dag_no,
                    'ord_no' => $misc_case_no,
                    'ord_date' => date('Y-m-d',strtotime($val['ord_date'])),
                    'name_for_id' => $pdar->pdar_id, //
                    'name_for' => $pdar->pdar_name,
                    'name_for_guardian' => $pdar->pdar_father,
                    'name_for_guar_relation' => $pdar->pdar_guard_reln,
                    'case_type_code' => '07',     
                    'name_for_land_b' => 0,
                    'name_for_land_k' => 0,
                    'name_for_land_lc' => 0,
                    'name_for_land_g' => 0,
                    'name_for_land_kr' => 0,
                    'case_no' => $misc_case_no
                ];
                $tchithaOppIns = $this->db->insert("t_chitha_rmk_other_opp_party", $tchithaOpp);
                //echo $this->db->last_query();return;
                if($tchithaOppIns != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#NDTCROOP004: Insertion failed in t_chitha_rmk_other_opp_party for misc case no : '.$misc_case_no);
                    $this->session->set_flashdata('message',"#NDTCROOP004: Final Submission failed for case no : ".$misc_case_no);
                    redirect($redirectUrl);
                    return false;
                }
            }

            //Additional File Upload Integration done ---------02022023----
                //START//------
                if(isset($_FILES['fileUpload']['name'])){
                    $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
                    $fileCount = count($_FILES['fileUpload']['name']);
                    // validation for file type and file size
                    for($i = 0; $i < $fileCount; $i++)
                    {
                        if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i])
                        {
                            $name = $_FILES['fileUpload']['name'][$i];
                            $size = $_FILES['fileUpload']['size'][$i];
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $ext  = $exp[1];
                                if($name != NULL)
                                {
                                    if($ext == NULL)
                                    {
                                        // todo error show extension missing
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                    {
                                        // todo error show file allow type not match
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                    if($size > UPLOAD_MAX_SIZE)
                                    {
                                        $this->db->trans_rollback();
                                        $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                        redirect(base_url() . "index.php/home");
                                    }
                                }
                                else
                                {
                                    $this->db->trans_rollback();
                                    $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                                    redirect(base_url() . "index.php/home");
                                }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                }
                    ///////////////////Insert attached file////////////////////////
                    if(isset($_FILES['fileUpload']['name'])){
                        for($i = 0; $i < $fileCount; $i++)
                        {
                            $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                            $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                            $exp  = explode("/",$mime);
                            $onlyExtension  = $exp[1];
                            $replaceCase=str_replace("/","-",$misc_case_no);
                            $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                            $config['upload_path']   = MANUAL_ATTACHMENT_MISCASE;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']  = UPLOAD_MAX_SIZE;
                            $config['file_name'] = $fileRename;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file'))
                            {
                                $document= array(
                                    'case_no'   => $misc_case_no,
                                    'file_name' => $_POST['fileText'][$i],
                                    'user_code' => $this->session->userdata('user_code'),
                                    // 'fetch_file_name' => $_FILES['file']['name'],
                                    'fetch_file_name' => $_POST['fileText'][$i],
                                    'file_type'  => $_FILES['file']['type'],
                                    'file_path'  => MANUAL_ATTACHMENT_MISCASE. $fileRename,
                                    'date_entry' => date('Y-m-d h:i:s'),
                                    'mut_type'   => 'NC',
                                );
                                // save data in attachment file
                                $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                                if($addMoreDocQuery != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRNCORC0003: Insertion failed in supportive document  Case No '.$misc_case_no);
                                    $this->session->set_flashdata('error_data', "#ERRNCORC0003: Uploading Falied of Name Correction case no : ".$misc_case_no);
                                    redirect(base_url() . "index.php/home");
                                    return false;
                                }
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                // todo error show
                                // redirect to respected route with error mgs
                                log_message('error', '#ERRNCORC0004: Uploading failed in supportive document Case No '.$misc_case_no);
                                $this->session->set_flashdata('error_data', "#ERRNCORC0004: Uploading Failed of Name Correction for case no : ".$misc_case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                    }

            //update in misc_case_basic
            $updateBasic = [
                'date_of_operation' => $note_date,
                'status' => '10',
                'user_code' => $user_code,
                'operation' => 'E'
            ];
            $this->db->where('misc_case_no', $misc_case_no);
            $this->db->update('misc_case_basic', $updateBasic);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#NDMCB005: Updation failed in misc_case_basic 
                for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#NDMCB005: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }

            $updateFirstParty = [
                'user_code' => $user_code,
                'operation' => 'E'
            ];
            $this->db->where('misc_case_no', $misc_case_no);
            $this->db->update('misc_case_first_party', $updateFirstParty);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#NDMCFP006: Updation failed in misc_case_first_party 
                for misc case no : '.$misc_case_no);
                $this->session->set_flashdata('message',"#NDMCFP006: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }
            $this->AgriStackCaseHistory->CreateLogFile($dist_code, $misc_case_no);
            $ok = $this->updateChithaNameStrikeOut($misc_case_no, $petition_no);
            if ($ok != true)
            {
                $this->db->trans_rollback();
                log_message("error"," #NDAUC007: Issue occured in updating Chitha for case no: ". $misc_case_no);            
                $this->session->set_flashdata('message',"#NDAUC007: Final Submission failed for case no : ".$misc_case_no);
                redirect($redirectUrl);
                return false;
            }
            // $this->db->trans_commit();

            //ESCALATION ==============
            
              if(ESCALATION_ENABLE == 1 && $miscCaseInfo->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1)
              {

                  $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($misc_case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                  if($responseEsc['responseType'] == 1)
                  {
                      $this->db->trans_rollback();
                      $data=array(
                          'error'=>"#ERRFPARTESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                      );
                      echo json_encode($data);
                      return false;
                  }

              }
              ///END+==================


            //ESCALATION START==================
            if($miscCaseInfo->es_flag == 1 && ESCALATION_ENABLE == 1){
               $executionDate = $this->input->post('executionDate');

               $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$misc_case_no,$user_code);
               log_message("error", "#ESC2646, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

               if($escalationUpdateStatus['responseType'] == 0){
                   $this->db->trans_rollback();
                   log_message("error", "#ESC2646, transaction-error in method 'NameCancellation/finalOrderCONameCancellation_save' with case-no :". $misc_case_no);
                   $this->session->set_flashdata('message', "Something went wrong. NCAN-Error Code(#ESC2646)");
                   redirect(base_url() . "index.php/home");
               }
            }

            //////////////////////////////////////////////////////////////////////////// property chain code /////////////////////////////////////////////////////////////
            $save_chain_data = true;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                  $this->load->model('propChain/PropChainModel');
                  $ulpinFlag = $this->input->post('ulpinCheckFlag');
                  $compareFlag = $this->input->post('compareCheckFlag');


                  if($compareFlag == 'Y' && $ulpinFlag ==1)
                  {
                     $ulpin = $this->input->post('ulpin');
                     $revenue = $this->input->post('chain_revenue');
                     $local_tax = $this->input->post('chain_local_tax');

                     $old_ulpin = $this->input->post('old_ulpin');
                     if ($old_ulpin == null)
                         $old_ulpin = "";

                     $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_code;

                     $certmnemonic = CERTMNEMONIC_NAMECANCEL;

                     $chain_dag = $dag_no;
                     $chain_patta = $patta_no;

                     $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $chain_patta, $chain_dag, $ulpin);

                     $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                     $bigha_chain = $land_area->dag_area_b;
                     $katha_chain = $land_area->dag_area_k;
                     $lessa_chain = $land_area->dag_area_lc;
                     $ganda_chain = $land_area->dag_area_g;

                     $land_class_code = $this->PropChainModel->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                     $property_signature = "base64 encoded signature";
                     $property_signer_key = "base64 encoded public key";

                     $office_code = $this->session->userdata('cir_code');

                     $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no);

                     // since below parameters are not applicable sent empty string
                     $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";
                     // 
                     $update_params = array(
                         'pattadar_details' => $pattadar_details,
                         'location_id' => $location_id,
                         'property_id' => $property_id,
                         'reference_id' => $misc_case_no,
                         'dag_no' => $chain_dag,
                         'patta_no' => $chain_patta,
                         'patta_type_code' => $patta_type_code,
                         'land_class_code' => $land_class_code,
                         'bigha_chain' => $bigha_chain,
                         'katha_chain' => $katha_chain,
                         'lessa_chain' => $lessa_chain,
                         'ganda_chain' => $ganda_chain,
                         'certmnemonic' => $certmnemonic,
                         'property_signature' => $property_signature,
                         'property_signer_key' => $property_signer_key,
                         'office_code' => $office_code,
                         'user_code' => $user_code,
                         'ulpin' => $ulpin,
                         'old_ulpin' => $old_ulpin,
                         'revenue' => $revenue,
                         'local_tax' => $local_tax,
                         'new_patta_no' => $new_patta_no,
                         'new_dag_no' => $new_dag_no,
                         'old_revenue' => $old_revenue,
                         'old_local_tax' => $old_local_tax,
                         'old_land_class_code' => $old_land_class,
                         'new_bigha' => $new_bigha,
                         'new_katha' => $new_katha,
                         'new_lessa' => $new_lessa,
                         'new_ganda' => $new_ganda
                     );
                     $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);

                     $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_update_data), $misc_case_no);
               }
            }

            


            if($ok){
              
              // var_dump($save_chain_data);die;
               if($save_chain_data)
               {

                   $this->db->trans_commit();
                   $this->AgriStackCaseHistory->CreateLog($dist_code,$misc_case_no);
                   $success = $this->DashboardDataFinal($misc_case_no);
                   $basundhara=$this->db->query("SELECT basundhara FROM basundhar_application 
                   WHERE dharitree=?", array($misc_case_no))->row()->basundhara;

                   if($basundhara)
                   {
                        $rtps=$this->rtpsmodel->checkRtpsService($basundhara);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                       $curl_handle = curl_init();
                       curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                       curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                       curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                       curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                       curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                       'application' => $basundhara,
                       'dharitree' => $misc_case_no,
                       'rmk' => 'Approved',
                       'status' => 'F',
                       'task' => 'CO',
                       'pen'=>'NA',
                       'penat'=>'Circle office'
                       )));
                       $result = curl_exec($curl_handle);
                   }

                  $location = array(
                                'd'=> $dist_code,
                                's' => $subdiv_code,
                                'c' => $cir_code,
                                'm' => $mouza_pargona_code,
                                'l' => $lot_no,
                                'v' => $vill_code,
                            );
                    $this->session->set_userdata(array('loc' => $location));
                    $popUpmsg="<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                    $msgggg= "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
                    //echo $msgggg;

                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {

                        if($ulpinFlag == 1 && $compareFlag == 'Y'){
                         redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code . '/' . urlencode(base64_encode($misc_case_no)));   
                      }
                    }
                    redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);
              
                      
                  }else
                  {
                      $this->session->set_flashdata('message', "Chitha Could not be updated for case no $misc_case_no. Contact Helpdesk with case no");
                      redirect($redirectUrl);
                  }
            }
        }
    }

    public function updateChithaNameStrikeOut($case_no, $misc_case_petition_no) {

        $redirectUrl = base_url().'index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='.$case_no.'&petition_no='.$misc_case_petition_no;
        
        $sql="SELECT case_no FROM t_chitha_rmk_other_opp_party WHERE 
        case_no='$case_no' AND iscorrected_inco is null ";

        $q = "SELECT * FROM misc_case_basic mcb, t_chitha_rmk_infavor_of c8 WHERE
        mcb.dist_code = c8.dist_code AND mcb.subdiv_code = c8.subdiv_code AND 
        mcb.cir_code= c8.cir_code AND mcb.lot_no = c8.lot_no AND 
        mcb.mouza_pargona_code = c8.mouza_pargona_code AND 
        mcb.vill_townprt_code = c8.vill_townprt_code AND mcb.misc_case_no=c8.ord_no AND 
        TRIM(mcb.patta_no) = TRIM(c8.patta_no) AND c8.iscorrected_inco IS NULL AND 
        c8.ord_no='$case_no' AND c8.petition_no = '$misc_case_petition_no' AND 
        c8.ord_no IN ($sql) ";

        $data = $this->db->query($q)->result();
        $ord_cron_no = 1;
        foreach ($data as $d) {
            $dist_code = $d->dist_code;
            $subdiv_code = $d->subdiv_code;
            $cir_code = $d->cir_code;
            $lot_no = $d->lot_no;
            $mouza_pargona_code = $d->mouza_pargona_code;
            $vill_townprt_code = $d->vill_townprt_code;
            $dag_no = $d->dag_no;
            $patta_no = $d->patta_no;
            $pdar_id_for_aadhaar = $d->pdar_id;
            $patta_type_code = $d->patta_type_code;
            $auth_type = $d->auth_type;
            $ref_no = $d->id_ref_no;
            $photo = $d->photo; 

            $q = "SELECT max(rmk_type_hist_no)+1 AS c2 FROM chitha_rmk_gen 
            WHERE dist_code=? and subdiv_code=? and cir_code=? AND lot_no=? 
            AND vill_townprt_code=? and mouza_pargona_code=?";
            $rmk_type_hist_no = $this->db->query($q, array($dist_code, $subdiv_code, $cir_code,
            $lot_no, $vill_townprt_code, $mouza_pargona_code))->row()->c2;
            
            if ($rmk_type_hist_no == null) {
                $rmk_type_hist_no = 1;
            }
            
            $query = $this->db->query("SELECT * FROM t_chitha_rmk_infavor_of WHERE 
            ord_no=?", array($d->ord_no));

            if($query->num_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRTCRIFO001: No data found in t_chitha_rmk_infavor_of 
                for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRTCRIFO001: Final submission failed 
                for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }

            $infve = $query->result();
            foreach ($infve as $infv) {
                unset($infv->year_no);
                unset($infv->petition_no);
                unset($infv->pdar_id);
                unset($infv->revenue);
                unset($infv->iscorrected_inco);
                unset($infv->iscorrected_inco_date);
                unset($infv->iscorrected_rkg_record);
                unset($infv->iscorrected_rkg_date);
                unset($infv->infavor_is_copdar);
                unset($infv->make_mdb);
                unset($infv->new_pattadar);
                unset($infv->iscorrected_inco_date);
                $infv->rmk_type_hist_no = $rmk_type_hist_no;
                $infv->ord_cron_no = $ord_cron_no++;
                $infv->user_code = $this->session->userdata('user_code');
                $infv->date_entry = date('Y-m-d');
                $infv->operation = 'E';

                $infvIns = $this->db->insert("chitha_rmk_infavor_of", $infv);
                if($infvIns != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCRIFO002: Insertion failed in chitha_rmk_infavor_of for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRCRIFO002: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }

                $query = "UPDATE t_chitha_rmk_infavor_of SET iscorrected_inco='Y' WHERE 
                dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND  
                mouza_pargona_code=? AND vill_townprt_code=? AND ord_no=? AND petition_no=?";
                $this->db->query($query, array($d->dist_code, $d->subdiv_code, $d->cir_code,
                $d->lot_no, $d->mouza_pargona_code, $d->vill_townprt_code, $case_no, 
                $misc_case_petition_no));
                
                if($this->db->affected_rows() <= 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRTCRIFO003: Updation failed in t_chitha_rmk_infavor_of for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRTCRIFO003: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;   
                }
            }
            $query = $this->db->query("SELECT * FROM t_chitha_rmk_other_opp_party 
            WHERE case_no=?", array($d->ord_no));
            if($query->num_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRTCROOP004: No data found in
                t_chitha_rmk_other_opp_party for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRTCROOP004: Final submission failed 
                for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }

            $ordparty = $query->result();
            foreach ($ordparty as $infv) {
                unset($infv->iscorrected_inco);
                unset($infv->iscorrected_inco_date);
                unset($infv->iscorrected_rkg_record);
                unset($infv->iscorrected_rkg_date);
                unset($infv->infavor_is_copdar);
                unset($infv->make_mdb);
                unset($infv->new_pattadar);
                unset($infv->case_no);
                $infv->rmk_type_hist_no = $rmk_type_hist_no;
                $infv->ord_cron_no = $ord_cron_no++;
                $infv->user_code = $this->session->userdata('user_code');
                $infv->date_entry = date('Y-m-d');
                $infv->operation = 'E';
                //var_dump($infv);
                $chithaROOPIns = $this->db->insert("chitha_rmk_other_opp_party", $infv);
                if($chithaROOPIns != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCROOP005: Insertion failed in chitha_rmk_other_opp_party for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRCROOP005: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }

                $this->db->query("UPDATE t_chitha_rmk_other_opp_party SET
                iscorrected_inco='Y' WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
                AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? 
                AND case_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, 
                $d->lot_no, $d->mouza_pargona_code, $d->vill_townprt_code, $d->ord_no));

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRTCROOP006: Updation failed in t_chitha_rmk_other_opp_party for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRTCROOP006: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }

                $this->db->query("UPDATE chitha_dag_pattadar SET p_flag='1', jama_yn=null 
                WHERE TRIM(patta_no)=trim(?) AND pdar_id=? AND dist_code=? 
                AND subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? 
                AND dag_no=? and vill_townprt_code=? ",
                array($d->patta_no, $infv->name_for_id, $d->dist_code, $d->subdiv_code, 
                $d->cir_code, $d->lot_no, $d->mouza_pargona_code, $dag_no, 
                $d->vill_townprt_code));

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCDP007: Updation failed in chitha_dag_pattadar
                    for case no : '.$case_no);
                    $this->session->set_flashdata('message',"#ERRCDP007: Final submission failed for case no : ".$case_no);
                    redirect($redirectUrl);
                    return false;
                }
            }

            $test="select lm_code as lm_code from t_chitha_rmk_ordbasic where ord_no='$case_no' ";
            $data = $this->db->query($test)->row()->lm_code;

            $d = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'ord_no' => $case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '07',
                'ord_cron_no' => $ord_cron_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => 'CO',
                'co_sign_yn' => 'Y',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => 0.0,
                'm_dag_area_k' => 0.0,
                'm_dag_area_lc' => 0.0,
                'm_dag_area_g' => 0.0,
                'm_dag_area_kr' => 0.0,
                'area_left_b' => 0.0,
                'area_left_k ' => 0.0,
                'area_left_lc' => 0.0,
                'area_left_g' => 0.0,
                'area_left_kr' => 0.0,
                'lm_code'=>$data,
            );            
            $chithaROBins = $this->db->insert("chitha_rmk_ordbasic", $d);
            if($chithaROBins != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCROB008: Insertion failed in chitha_rmk_ordbasic for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRCROB008: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }
            $d = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'mouza_pargona_code' => $mouza_pargona_code,
                'vill_townprt_code' => $vill_townprt_code,
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
            );
            $chithaRGins = $this->db->insert("chitha_rmk_gen", $d);
            if($chithaRGins != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCRG009: Insertion failed in chitha_rmk_gen for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRCRG009: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }

            // $this->db->query("UPDATE chitha_basic SET jama_yn=null WHERE 
            // dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND 
            // mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=?", 
            // array($d['dist_code'], $d['subdiv_code'], $d['cir_code'], $d['lot_no'], 
            // $d['mouza_pargona_code'], $d['vill_townprt_code'], $dag_no));
            // echo $this->db->last_query();
            // return;die;exit();
            $table = 'chitha_basic';

            $params = [
                'jama_yn' => null, // or '' if you want empty string as in your example
            ];

            $where = [
                'dist_code'          => $d['dist_code'],
                'subdiv_code'        => $d['subdiv_code'],
                'cir_code'           => $d['cir_code'],
                'lot_no'             => $d['lot_no'],
                'mouza_pargona_code' => $d['mouza_pargona_code'],
                'vill_townprt_code'  => $d['vill_townprt_code'],
                'dag_no'             => $dag_no,
            ];

            // Then call your model method, assuming it uses CodeIgniter's Active Record to update
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

            if($result <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCB010: Updation failed in chitha_basic
                for case no : '.$case_no);
                $this->session->set_flashdata('message',"#ERRCB010: Final submission failed for case no : ".$case_no);
                redirect($redirectUrl);
                return false;
            }
            //changes done for aadhaar data updated against pattdar id---------03122022
            log_message('error',$auth_type);
            log_message('error',$patta_no);
            log_message('error',$patta_type_code);
            log_message('error',$pdar_id_for_aadhaar);
            log_message('error',$photo);
            if(isset($auth_type)){
               if($auth_type == 'AADHAAR'){
                  $aadharNo = $ref_no;
                  $panNo = null;
                  $photo = $photo;
                }elseif($auth_type == 'PAN'){
                  $aadharNo = null;
                  $panNo = $ref_no;
                  $photo = null;
                }
               if($aadharNo != null || $panNo != null){
                //   $this->db->query("UPDATE chitha_pattadar SET pdar_aadharno='$aadharNo',pdar_pan_no='$panNo',pdar_photo=null WHERE 
                //   dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND 
                //   mouza_pargona_code=? AND vill_townprt_code=? AND pdar_id=? AND patta_no= ? AND patta_type_code =?", 
                //   array($d['dist_code'], $d['subdiv_code'], $d['cir_code'], $d['lot_no'], 
                //   $d['mouza_pargona_code'], $d['vill_townprt_code'], $pdar_id_for_aadhaar,$patta_no,$patta_type_code));

                $table = 'chitha_pattadar';
                $params = [
                    'pdar_aadharno' => $aadharNo,
                    'pdar_pan_no'   => $panNo,
                    'pdar_photo'    => null,
                    'f1_case_no'         => $case_no,
                ];
                $where = [
                    'dist_code'          => $d['dist_code'],
                    'subdiv_code'        => $d['subdiv_code'],
                    'cir_code'           => $d['cir_code'],
                    'lot_no'             => $d['lot_no'],
                    'mouza_pargona_code' => $d['mouza_pargona_code'],
                    'vill_townprt_code'  => $d['vill_townprt_code'],
                    'pdar_id'            => $pdar_id_for_aadhaar,
                    'patta_no'           => trim($patta_no),
                    'patta_type_code'    => $patta_type_code,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);
                // echo $this->db->last_query();die;
                  if($result <= 0)
                  {
                      $this->db->trans_rollback();
                      log_message('error', '#ERRCB010: Updation failed in chitha_pattadar
                      for case no : '.$case_no);
                      $this->session->set_flashdata('message',"#ERRCB010: Final submission failed in aadhaar information for case no : ".$case_no);
                      redirect($redirectUrl);
                      return false;
                  }
               }
               
            }
            
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {            
            return true;
        }
    }

    public function JamaUpdate($case, $dist, $subdiv, $cir, $mouza, $lot, $vill, $pn, $ptype_code)
    {
        $location = [
            'd'=> $dist,
            's' => $subdiv,
            'c' => $cir,
            'm' => $mouza,
            'l' => $lot,
            'v' => $vill,
        ];
        
        $this->session->set_userdata(array('loc' => $location));
        $popUpmsg = "<h4>Order for Case No $case Successfully Saved. Chitha has been Updated !!! Updating JamaBandi Now<h4>";
        $msg = "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
        redirect('JamaBandi/step3/' .$pn .'/'. $ptype_code);
    }
    public function COStep2_save() {

      $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //$db=  $this->session->userdata('db');
        if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
            //ERRNMECANCCO0001
            log_message('error', 'Required parameters are empty. Error: ERRNMECANCCO0001');
            $this->session->set_flashdata('message',"Required parameters are empty. Error: ERRNMECANCCO0001");
            redirect(base_url('index.php/NameCancellation/COStep1'));
            return false;
        }
        if(!isset($_POST['application_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['next_date_of_hearing']) || !isset($_POST['next_date_time']) || $_POST['application_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['next_date_of_hearing']=='' || $_POST['next_date_time']=='') {
            //ERRNMECANCCO0002
            log_message('error', 'Required parameters are empty. Error: ERRNMECANCCO0002');
            $this->session->set_flashdata('message',"Required parameters are empty. Error: ERRNMECANCCO0002");
            redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
            return false;
        }
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECANCCO0007
            log_message('error', $validquery['messages'] .'Error: ERRNMECANCCO0007');
            $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECANCCO0007');
            redirect(base_url('index.php/NameCancellation/COStep1'));
        }

        // $_POST['p1'] = 'আবেদনকাৰীৰ আবেদন চোৱা হল  আবেদনকাৰীয়ে মাজুলী জিলাৰ কমলাবাৰী মৌজাৰ 1 নং বৰ৚ঞা গাঁওৰ 67 নং খেৰাজ ম্যাদী পট্টাৰ নাম কৰ্ত্তন বিচাৰিছে  আবেদনখন পঞ্জীভুক্ত গোচৰ ৰুজু কৰা হল  সংশ্লিস্ট লট মণ্ডলে প্রতিবেদন দিব আৰু সহায়কে দ্বিতীয় পক্ষলৈ জাননী জাৰি কৰিব'  আবেদনকাৰীৰ আবেদন চোৱা হল  আবেদনকাৰীয়ে মাজুলী জিলাৰ কমলাবাৰী মৌজাৰ কা৘তি বাৰী গাঁওৰ 96 নং খেৰাজ ম্যাদী পট্টাৰ নাম কৰ্ত্তন বিচাৰিছে  আবেদনখন পঞ্জীভুক্ত গোচৰ ৰুজু কৰা হল  সংশ্লিস্ট লট মণ্ডলে প্রতিবেদন দিব আৰু সহায়কে দ্বিতীয় পক্ষলৈ জাননী জাৰি কৰিব;
        $res = checkRequestSpecChar($_POST, ['p1'=>['৚', '৘', 'সং', 'নং']], [], ['p1'=>true]);
        if($res['status']=='n') {
            //ERRNMECANCCO0003
            log_message('error', $res['messages'] .'. Error: ERRNMECANCCO0003');
            $this->session->set_flashdata('message',"Parameter contain special character. Error: ERRNMECANCCO0003");
            redirect(base_url('index.php/NameCancellation/COStep1'));
            return false;
        }
        //form validation
        $result = $this->FormValidationModel->formValidationForPost($_POST, [
            'application_no'=>'Application No|required|application_no',
            'misc_case_no'=>'Misc Case No.|required|case_no',
            'misc_case_petition_no'=>'Misc Case Petition No.|required|digit',
            'next_date_of_hearing'=>'Next date of hearing|required|date',
            'next_date_time'=>'Next Date Time|required|time'
        ]);
        // $result = postParamFormValidation($_POST, [
        //     'application_no'=>'application_no',
        //     'misc_case_no'=>'case_no',
        //     'misc_case_petition_no'=>'digit',
        //     'next_date_of_hearing'=>'date',
        //     'next_date_time'=>'time',
        //     // 'p1'=>'only_non_special_character',
        //     // 'p2'=>'only_non_special_character',
        // ]);

        if($result['status']=='n') {
            //ERRNMECANCCO0004
            log_message('error', 'Message: '. $result['message'] .', Data: '. json_encode($result['data']) .' Error: ERRNMECANCCO0004');
            $this->session->set_flashdata('message',$result['message'] .' Error: ERRNMECANCCO0004');
            redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
            return false;
        }

        //authorization
        $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'CO', $_POST['misc_case_no']);
        if($response['status']=='n') {
            // ERRNMECANCCO0005
            log_message('error', $response['messages'] .' Error: ERRNMECANCCO0005');
            $this->session->set_flashdata('message', $response['messages'] ." Error: ERRNMECANCCO0005");
            redirect(base_url('index.php/home'));
        }
        
        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     // ERRNMECANCCO0005
        //     log_message('error', 'User not logged in. Error: ERRNMECANCCO0005');
        //     $this->session->set_flashdata('message', "User not logged in. Error: ERRNMECANCCO0005");
        //     redirect(base_url('index.php/home'));
        // }
        //user authorization
        // $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
        // if($sessionData['user_desig_code']!='CO' || $sessionData['dist_code']!=$caseInfo->dist_code || $sessionData['subdiv_code']!=$caseInfo->subdiv_code || $sessionData['cir_code']!=$caseInfo->cir_code) {
        //     // ERRNMECANCCO0006
        //     log_message('error', 'User not authorized. Error: ERRNMECANCCO0006');
        //     $this->session->set_flashdata('message', "User not authorized. Error: ERRNMECANCCO0006");
        //     redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='.$_POST['misc_case_no']));
        // }

        //syntax validation
        // $validAppNo = applicationNumberValidation($_POST['application_no']);
        // if(!empty($validAppNo)) {
        //     $this->session->set_flashdata('message',"Application No. contains illegal characters");
        //     redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
        //     return false;
        // }
        // $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        // if(!empty($validCaseNo)) {
        //     $this->session->set_flashdata('message',"Misc Case No. contains illegal characters");
        //     redirect(base_url('index.php/NameCancellation/COStep1'));
        //     return false;
        // }
        // if(!preg_match('/\d/', $_POST['misc_case_petition_no'])) {
        //     $this->session->set_flashdata('message',"Misc Case Petition No. must be numerical");
        //     redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
        //     return false;
        // }
        // if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['next_date_of_hearing']) && !preg_match('/^\d{2}-\d{2}-\d{4}$/', $_POST['next_date_of_hearing'])) {
        //     //ERRNMECORRCO0005
        //     $this->session->set_flashdata('message',"Input date not in format");
        //     redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
        //     return false;
        // }
        // if(!preg_match('/^\d{2}:\d{2}$/', $_POST['next_date_time']) && !preg_match('/^\d{2}:\d{2}:\d{2}$/', $_POST['next_date_time'])) {
        //     //ERRNMECORRCO0006
        //     $this->session->set_flashdata('message', "Input time not in format.");
        //     redirect(base_url('index.php/NameCancellation/COStep2?misc_case_no='. $_POST['misc_case_no']));
        //     return false;
        // }
        // $validp1 = specialCharacterCheckingInInput($_POST['p1']);

        $misc_case_no = $this->input->post('misc_case_no');
        $petition_no = $this->input->post('misc_case_petition_no')  ;      
        $next_date_of_hearing1 = $this->input->post('next_date_of_hearing');
        $next_date_of_hearing = date("Y-m-d", strtotime($next_date_of_hearing1));

        $p1 = $this->input->post('p1');
        $p2 = $this->input->post('p2');
        $process_note = $p1 . " " . $next_date_of_hearing . " " . $p2;
        $note_date = date('Y-m-d');
        $time_to_present = $this->input->post('next_date_time');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;

        $user_code = $this->session->userdata('user_code');
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $year_no = $data['miscCaseInfo']->year_no;

        $this->db->trans_begin();

        $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($misc_case_no, $petition_no));
        $note_no = ($result->row()->note_no) + 1;
        $status = '18';
        $operation = 'E';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $process_note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $ins = $this->db->insert("misc_case_process_reports", $userdata);
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERROR001: Insertion failed in misc_case_process_reports for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERROR001: Unable to process misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");
            return false;
        }

        $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$process_note);


          if($proInsert==false || $proInsert===false)
           {
               log_message('error', "#MISCCO002:".$this->db->last_query());
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Updation failed(#MISCCO002)".$misc_case_no);
               redirect(base_url() . "index.php/home");
           }

        // status 18 is after circle officer passes the order
        $updateSqlBasic = "update misc_case_basic set proceeding_yn='Y',next_date_of_hearing=?,time_to_present=?,fresh_yn='Y', "
                . " status='18', date_of_operation=? where misc_case_no=? and misc_case_petition_no = ?";
        $this->db->query($updateSqlBasic, array($next_date_of_hearing, $time_to_present, $note_date, $misc_case_no, $petition_no));
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERROR002: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERROR002: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");
            return false;
        }

        $updateSqlFirstParty = "update misc_case_first_party set operation='l' where misc_case_no=? and misc_case_petition_no = ?";
        $this->db->query($updateSqlFirstParty, array($misc_case_no, $petition_no));
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERROR003: Updation failed in misc_case_first_party for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERROR003: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");
            return false;
        }

        // var_dump($data['miscCaseInfo']->es_flag); die;

        //ESCALATION ==============
        if(ESCALATION_ENABLE == 1 && $data['miscCaseInfo']->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRFPARTESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================

        //ESCALATION CODE INTEGRATION================SANMRI

         $user_code = $this->session->userdata('user_code');
         if($data['miscCaseInfo']->es_flag == 1 && ESCALATION_ENABLE == 1){
               $executionDate = $this->input->post('executionDate');
               $escalationUpdateStatus = $this->Escalationmodel->escalationCOFirstProcedingNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$data['miscCaseInfo']->mouza_pargona_code,$data['miscCaseInfo']->lot_no,$data['miscCaseInfo']->misc_case_no,$user_code);

               // var_dump($escalationUpdateStatus); die;


               log_message("error", "#ESC3336, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
               if($escalationUpdateStatus['responseType'] == 0){

                  log_message("error", "#ESC3336, transaction-error in method 'NameCancellation/COStep2' with case-no :". $case_no);
                  $this->session->set_flashdata('message', "Something went wrong.NCAN- Error Code(#ESC3336)");
                  redirect(base_url() . "index.php/home");
               }
         }

        $this->db->trans_commit();
        ///////////////////////////////////
        $penUser='LM';
        $rmrk="CO submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////
        $application_no = $this->input->POST('application_no');

        // $basundhara=$this->db->query("select basundhara from basundhar_application where dharitree='$misc_case_no' ")->row()->basundhara;
        if($application_no){
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'Verified by CO',
                'status' => 'M',
                'task' => 'CO',
                'pen'=>'LM',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }

        if(ESCALATION_ENABLE == 1){
            $this->session->set_flashdata('message', 'Name Cancellation Order Has Passed  !!  First Notice will generate by Assistant and LM Verify Applicant Details !!');
        }else{
            $this->session->set_flashdata('message', 'Name Cancellation Order Has Passed  !!  Now LM and SK Verify Applicant Details !!');
        }
        
        redirect(base_url() . "index.php/home/index");
    }

    /////////////
    public function LMStepRe() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $config['base_url'] = base_url() . '/index.php/NameCancellation/lm_revert/';
        // $data['countMiscCase'] = $this->NameCorrectionModel->getMiscCaseLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $cases['TotMisc'] = $this->NameCancellationModel->getMiscCaseLMRe($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)->result();
        $case_array = array();
        //$var_dump($case_array);
        foreach ($cases['TotMisc'] as $c) {
            $q = $this->db->query("select misc_case_type,misc_case_no,submission_date,es_flag,is_escalated from    misc_case_basic where lm_note_yn is  null and next_date_of_hearing is not null and fresh_yn='Y'")->row();
            array_push($case_array, $c);
        }
        $data['MisCases'] = $case_array;

        if(ESCALATION_ENABLE == 1){
         foreach($data['MisCases'] as $rows) {

            if($rows->es_flag == '1'){

              $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);

              log_message('error', '#2785: From escalation_detail_table : '.json_encode($escRow)); 
              if(!empty($escRow) && $escRow !=null){
                  $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date)); 
                  log_message('error', '#2789: Escalation details : '.json_encode($escData)); 

                 $rows->escalation_date = $escData->escalation_date;
                 $rows->escalation_zone = $escData->escalation_zone;
                 $rows->assigned_date   = $escData->assigned_date;
              }else{
                  $rows->escalation_date = 'NA';
                  $rows->escalation_zone = 'NA';
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }
         }
      }
        $data['_view'] = 'NameCancellation/lm_revert';
        $this->load->view('layouts/main',$data);
    }

    public function LMStep2_revert() {
         $_GET['misc_case_no'] = dec_param($this->input->get('misc_case_no'), 'misc_case_no');
        if($_GET['misc_case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }
        $misc_case_no = $this->input->get('misc_case_no');
        $petition_no = $this->input->get('petition_no');
        $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $miscCaseSecond = $this->NameCancellationModel->getNameSecPartyInfo($misc_case_no, $petition_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $supported_doc_code = $data['miscCaseInfo']->supported_doc_code;
        $misc_case_petition_no = $data['miscCaseInfo']->misc_case_petition_no;
        $add_to_officer = $data['miscCaseInfo']->add_to_officer;
        $data['user_name'] = $this->utilityclass->getCOCode($dist_code, $subdiv_code, $cir_code, $add_to_officer);
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $sql1 = "select patta_no from    misc_case_basic where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result1 = $this->db->query($sql1);
        $patta_no = $result1->row()->patta_no;
        $data['SupportDoc'] = $this->NameCorrectionModel->getSupportedDoc($supported_doc_code);
        $data['Petitioner'] = $this->NameCancellationModel->getNameFirstPartyInfo($misc_case_no);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $application_no="select * from basundhar_application where dharitree='$misc_case_no' ";
        $data['app'] = $this->db->query($application_no)->row();

        $basundhara=$this->basundharamodel->checkExistBasundhar($misc_case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($misc_case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($misc_case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($misc_case_no);
            }
        }

        $data['secondparty'] = $this->NameCancellationModel->get2ndPartyInfo($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $misc_case_no);

        $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($misc_case_no);

        $coremark="select process_note from misc_case_process_reports where misc_case_no='$misc_case_no' and user_code like 'C%' and co_fresh_proceeding='N' order by note_no desc";
        $data['cormk']= $this->db->query($coremark)->row();

        $data['_view'] = 'NameCancellation/LMStep2_revert';
        $this->load->view('layouts/main',$data);
    }


    public function LMStep2_revertsave()
    {
        if(!isset($_POST['misc_case_no']) || !isset($_POST['misc_case_petition_no']) || !isset($_POST['lm_report']) || $_POST['misc_case_no']=='' || $_POST['misc_case_petition_no']=='' || $_POST['lm_report']=='') {
            //ERRNMECANCRVRTLM0001
            log_message('error', 'The required fields are empty. Error: ERRNMECANCRVRTLM0001');
            $response = array(
                'responseType'=>1,
                'msg'=>'The required fields are empty',
                'errorCode'=>'ERRNMECANCRVRTLM0001',
                'data'=>array(
                    'application_no'=>'',
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
        }

        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECANCRVRTLM0006
            log_message('error', $validquery['messages'] .'Error: ERRNMECANCRVRTLM0006');
            $response = array(
                'responseType'=>1,
                'msg'=>'The parameter contain malicious characters',
                'errorCode'=>'ERRNMECANCRVRTLM0006',
                'data'=>array(
                    'application_no'=>'',
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
        }

        //syntax validation
        $checkSpclChar = checkRequestSpecChar($_POST);
        if($checkSpclChar['status']=='n') {
            //ERRNMECANCRVRTLM0002
            log_message('error', 'The parameter contain special character. Error: ERRNMECANCRVRTLM0002');
            $response = array(
                'responseType'=>1,
                'msg'=>'The parameter contain special character',
                'errorCode'=>'ERRNMECANCRVRTLM0002',
                'data'=>array(
                    'application_no'=>'',
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
        }
        //form validation
        $formResult = $this->FormValidationModel->formValidationForPost($_POST, [
            'misc_case_no'=>'Misc Case No.|required|case_no',
            'misc_case_petition_no'=>'Misc Case Petition No.|required|digit',
            'lm_report'=>'LM Report|required'
        ]);
        // $formResult = postParamFormValidation($_POST, [
        //     'misc_case_no'=>'case_no',
        //     'misc_case_petition_no'=>'digit'
        // ]);
        if($formResult['status']=='n') {
            //ERRNMECANCRVRTLM0003
            log_message('error', 'Message: '. $formResult['message'] .', Data: '. json_encode($formResult['data']) .' Error: ERRNMECANCRVRTLM0003');
            $response = array(
                'responseType'=>1,
                'msg'=>'The parameter is not valid',
                'errorCode'=>'ERRNMECANCRVRTLM0003',
                'data'=>array(
                    'application_no'=>'',
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
        }

        //authorization
        $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'LM', $_POST['misc_case_no']);
        if($response['status']=='n') {
            //ERRNMECANCRVRTLM0004
            log_message('error', 'The user is not logged in. Error: ERRNMECANCRVRTLM0004');
            $res = array(
                'responseType'=>1,
                'msg'=>$response['messages'],
                'errorCode'=>'ERRNMECANCRVRTLM0004',
                'data'=>array(
                    'application_no'=>'',
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($res);
            exit;
        }
        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
            // //ERRNMECANCRVRTLM0004
            // log_message('error', 'The user is not logged in. Error: ERRNMECANCRVRTLM0004');
            // $response = array(
            //     'responseType'=>1,
            //     'msg'=>'The user is not logged in.',
            //     'errorCode'=>'ERRNMECANCRVRTLM0004',
            //     'data'=>array(
            //         'application_no'=>'',
            //         'redirectUrl'=>base_url('index.php/home')
            //     )
            // );
            // echo json_encode($response);
            // exit;
        // }

        //authorization
        // if($sessionData['user_desig_code']!='LM' || $sessionData['dist_code']!=$miscCaseInfo->dist_code || $sessionData['subdiv_code']!=$miscCaseInfo->subdiv_code || $sessionData['cir_code']!=$miscCaseInfo->cir_code || $sessionData['mouza_pargona_code']!=$miscCaseInfo->mouza_pargona_code || $sessionData['lot_no']!=$miscCaseInfo->lot_no) {
        //     //ERRNMECANCRVRTLM0005
        //     log_message('error', 'The user is not logged in. Error: ERRNMECANCRVRTLM0005');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'The user is not logged in.',
        //         'errorCode'=>'ERRNMECANCRVRTLM0005',
        //         'data'=>array(
        //             'application_no'=>'',
        //             'redirectUrl'=>base_url('index.php/home')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }

        $miscCaseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $_POST['misc_case_petition_no']);
        $json=null;
        $misc_case_no = $this->input->post('misc_case_no');
        $no = explode('/', $misc_case_no);

        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($misc_case_no))->row()->count;
        $sl = $count+1;

        $petition_no = $this->input->post('misc_case_petition_no');
        $lm_report = addslashes($this->input->post('lm_report'));
        $note_date = date('Y-m-d');
        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($misc_case_no, $petition_no);
        $data['miscCaseInfo'] = $miscCaseInfo;
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');

        $this->db->trans_begin();

        //////doc upload///////

        if($no[4]=='MiND'){
            $folder = UPLOAD_BASE_MISCASE.UPLOAD_SEPARATOR.$dist_code.'/';
            $petition_no = $petition_no;
        }
        $file = $petition_no.date('Y').'_'.$sl;
                
        $_FILES['file']['type'] = $_FILES['up_noc']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc']['size'];

        $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;

        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        }

        $config = array(
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );

        $check_file_type = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($check_file_type as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        // if(empty($_FILES['up_noc']['name']))
        // {
        //     $json['error_a'][] = array('err_msg' => ' Map upload is mandatory in case of trace map service.');
        // }

        if(!empty($_FILES['up_noc']['name']))
        {
            if(!$checkFileExt){
            $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
        }
        else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
        {
            $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
        }
        }
         

        if($json !=null or $json !='' )
        {
            //$this->db->trans_rollback();
            echo json_encode($json);
            return;
        }
        else
        {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $misc_case_no,
                    'user_code' => $user_code,
                    'file_name' => affidavit,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORSD001: Uploading insertion failed in supportive_document for case no :'. $misc_case_no);

                    $json = array(
                        'error_a'=>'#ERRORSD001: NOC upload failed for Case No ' . $misc_case_no
                    );
                    echo json_encode($json);
                    return false;


                    // $this->session->set_flashdata('message', '#ERRORSD001: NOC upload failed for Case No ' . $case_no);
                    // redirect($redirectURL);
                    // return;
                }
            }
        }

        $sql = "select MAX(note_no)+1 AS note_no from    misc_case_process_reports where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no'";
        $result = $this->db->query($sql)->row()->note_no;

        $appStatus = false;
        if(isset($_POST['application_no']) && $_POST['application_no']!='') {
            $checkApp = $this->FormValidationModel->formValidationForPost($_POST, [
                'application_no'=>'Application No.|required|application_no'
            ]);
            // $checkApp = postParamFormValidation($_POST, [
            //     'application_no'=>'application_no'
            // ]);
            if($checkApp['status']=='y') {
                $appStatus = true;
                $application_no = $this->input->post('application_no');
            }
        }

        $note_no = $result;
        $status = '02';
        $operation = 'l';
        $co_fresh_proceeding = 'Y';
        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $misc_case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $lm_report,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $ins = $this->db->insert("misc_case_process_reports", $userdata);
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLMR001: Insertion failed in misc_case_process_reports for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLMR001: Unable to process misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");   
            return false;
        }

        $proInsert = $this->mutationmodel->proceeding_order($misc_case_no,$lm_report);


          if($proInsert==false || $proInsert===false)
           {
               log_message('error', "#MISCLM002:".$this->db->last_query());
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Updation failed(#MISCLM002)".$misc_case_no);
               redirect(base_url() . "index.php/home");
           }

        $updateSqlBasic = "update   misc_case_basic set lm_note_yn='Y', operation='$operation', date_of_operation='$note_date',  "
                . " status='$status' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
        $this->db->query($updateSqlBasic);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLMR002: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLMR002: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }
        if($miscCaseInfo->es_flag == 1 && ESCALATION_ENABLE ==1){
            $updateSqlFirstParty = "update   misc_case_first_party set operation='f' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
         }else{
            $updateSqlFirstParty = "update   misc_case_first_party set operation='l' where misc_case_no='$misc_case_no' and misc_case_petition_no = '$petition_no' ";
         }
        $this->db->query($updateSqlFirstParty);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRORLMR003: Updation failed in misc_case_basic for misc case no: '.$misc_case_no);
            $this->session->set_flashdata('message',"#ERRORLMR003: Unable to forward misc case report for case no : ".$misc_case_no);
            redirect(base_url() . "index.php/home/index");    
            return false;
        }


         //ESCALATION CODE INTEGRATION================SANMRI

          if($miscCaseInfo->es_flag == 1 && ESCALATION_ENABLE ==1){
              $user_code = $this->session->userdata('user_code');
              $executionDate = $this->input->post('executionDate');
              $escalationUpdateStatus = $this->Escalationmodel->escalationLMRevertReportNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$misc_case_no,$user_code);

              log_message("error", "#ESC3819, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

              if($escalationUpdateStatus['responseType'] == 0){
                  $this->db->trans_rollback();
                  log_message("error", "#ESC3819, transaction-error in method 'NameCancellation/revertToLMOfficeMutationCO' with case-no :". $misc_case_no);
                  $this->session->set_flashdata('message', "Something went wrong.NCAN- Error Code(#ESC3819)");
                  redirect(base_url() . "index.php/home");
              }
              ///////////////END ESCALATION//////////////
          }


        $this->db->trans_commit();
         ///////////////////////////////////
        $penUser='SK';
        $rmrk="LM submitted his report";
        $this->DashboardData($misc_case_no,$penUser,$rmrk);
        //////////////////////


        if($appStatus)
        {
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $misc_case_no,
                'rmk' => 'LM report',
                'status' => 'M',
                'task' => 'LM',
                'pen'=>'SK',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
        }

        $json['success'] = 'true';
        $json['case_no'] = $misc_case_no;
        $json['redirect'] = base_url()."index.php/home/index";
        echo json_encode($json);
        return;
    }

///// 27-04-22 //// name cancellation report in basundhara ADC reject list
    function nameCancelReport(){

     $case_no = $this->input->get('app');
     $sql="Select dharitree from basundhar_application where basundhara='$case_no' "; 
     $dh=$this->db->query($sql)->row()->dharitree;
    
     if($dh){
      // $dharitree = $data->row()->dharitree;
       // $data['comments_co'] = $this->db->query("SELECT * FROM misc_case_process_reports 
       //         WHERE misc_case_no=? AND user_code like 'CO%'",$dh)->result();
       $data['comments_lm'] = $this->db->query("SELECT * FROM misc_case_process_reports 
           WHERE misc_case_no='$dh' AND user_code like 'M%'")->result();
       //$data['comments_sk'] = $this->db->query("SELECT * FROM misc_case_process_reports 
         //  WHERE misc_case_no=? AND user_code like 'SK%'",$dh)->result();
     }
     $this->load->view('NameCancellation/viewRejectReportNSTR',$data);
   }

   public function RevertLMNameCancellation(){
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $application_no = $this->input->get('application_no');
        $user_code=$this->session->userdata('user_code');


        //escalation implementation================
        $es_flag = $this->db->query("select es_flag from  misc_case_basic where "
                                        . " misc_case_no='$case_no'")->row()->es_flag;


        ////////END///////////////
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $flag =false;
            if($es_flag == 1 && ESCALATION_ENABLE == 1){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);

                $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);

                //remaining days of CO==============
                $originalAllocationCO   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_CO= $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocationCO);
                if($remaining_days_LM == 0){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
            $data['flag'] = $flag;
            $data['remainingDaysCO'] = $remaining_days_CO;
            $data['_view'] = 'NameCancellation/RevertLMNameCancellation';
            $this->load->view('layouts/main',$data);
        }
        else if ($this->input->server('REQUEST_METHOD') == 'POST') {


            $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no='$case_no'")->row()->misc_case_petition_no;

            $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);

            $note_date = date('Y-m-d');
            $dist_code = $data['miscCaseInfo']->dist_code;
            $subdiv_code = $data['miscCaseInfo']->subdiv_code;
            $cir_code = $data['miscCaseInfo']->cir_code;
            $user_code = $this->session->userdata('user_code');
            $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$case_no' and misc_case_petition_no = '$petition_no'";
            $result = $this->db->query($sql);
            $note_no = ($result->row()->note_no) + 1;
            $operation = 'c';
            $co_fresh_proceeding = 'N';
            $note=$this->input->post('revert_report_remarks_co');

            $userdata = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'note_no' => $note_no,
                'misc_case_no' => $case_no,
                'co_fresh_proceeding' => $co_fresh_proceeding,
                'process_note' => $note,
                'note_date' => $note_date,
                'user_code' => $user_code,
                'operation' => $operation,
                'misc_case_petition_no' => $petition_no

            );
            $this->db->insert("misc_case_process_reports", $userdata);


            //********escalation process for LM Revert*******
            if($data['miscCaseInfo']->es_flag == 1 && ESCALATION_ENABLE == 1){
                $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null WHERE misc_case_no = '$case_no'");
            }else{
                $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");
            }
            //*****************END*****************
            

            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no,
                'rmk' => 'forwared to LM',
                'status' => 'M',
                'task' => 'CO',
                'pen'=>'LM',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);

             //********escalation process for LM Revert*******
            if($data['miscCaseInfo']->es_flag == 1 && ESCALATION_ENABLE == 1){
                $user_code = $this->session->userdata('user_code');
                $allocation_days = null;
                if($this->input->post('allocate_day') !=null){
                    $allocation_days = $this->input->post('allocate_day');
                }
                $executionDate = $this->input->post('executionDate');
                $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$data['miscCaseInfo']->mouza_pargona_code,$data['miscCaseInfo']->lot_no,$allocation_days);

                log_message("error", "#ESC4014, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    // $this->db->trans_rollback();
                    log_message("error", "#ESC4014, transaction-error in method 'NameCancellation/RevertLMNameCancellation' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.NCAN- Error Code(#ESC4014)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }
            $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
            redirect(base_url() . "index.php/home");
                
         }
      }
    public function getPendingactionTakenReport() {

        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $query = "Select *,ba.basundhara from misc_case_basic mcb left join basundhar_application ba on mcb.misc_case_no=ba.dharitree where fresh_yn='Y' and proceeding_yn='Y' and notice_generated_yn = 'Y' and note_of_action is null and es_flag = 1 and dist_code = ? and subdiv_code = ? and cir_code = ? ";

        $cases = $this->db->query($query,array($dist_code,$subdiv_code,$cir_code))->result();
        $data['cases'] = $cases;

        foreach($data['cases'] as $rows) {

            if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->misc_case_no);

                log_message('error', '#1175: From escalation_detail_table : '.json_encode($escRow)); 
                if(!empty($escRow) && $escRow != null){
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->submission_date)); 

                    log_message('error', '#1179: Escalation details : '.json_encode($escData));

                    if($escRow->assigned_other_date == date('Y-m-d')) {
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;    
                    }
                    else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    } 
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }   
                               
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'NameCancellation/actionTaken';
        $this->load->view('layouts/main',$data);
    }
public function writeNote() {

   $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            //**************validation***************/
            $om_act = [
                [
                    'field' => 'case_no',
                    'label' => 'Case-No',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                
            ];
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_rules($om_act);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_act as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
            //***************************************/
            $this->db->trans_begin();  
            $notes = $this->input->post('note');
            $case_no = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code'); // $location['subdiv_code'];
            $cir_code = $this->session->userdata('cir_code'); // $location['cir_code'];
            $user_code = $this->session->userdata('user_code');
            $noteOfAction = $notes;

             $query1 = "select misc_case_petition_no from  misc_case_basic where misc_case_no=?";
             $petition_no= $this->db->query($query1,array($case_no))->row()->misc_case_petition_no;

             $sql = "select MAX(note_no) AS note_no from    misc_case_process_reports where misc_case_no='$case_no'";
                  $result = $this->db->query($sql);
                  $note_no = ($result->row()->note_no) + 1;
                  $operation = 'A';
                  $co_fresh_proceeding = 'N';
                  $note=$this->input->post('revert_report_remarks_co');

                  $userdata = array(
                      'dist_code' => $dist_code,
                      'subdiv_code' => $subdiv_code,
                      'cir_code' => $cir_code,
                      'note_no' => $note_no,
                      'misc_case_no' => $case_no,
                      'co_fresh_proceeding' => $co_fresh_proceeding,
                      'process_note' => $noteOfAction,
                      'note_date' => date('Y-m-d'),
                      'user_code' => $user_code,
                      'operation' => $operation,
                      'misc_case_petition_no' => $petition_no

                  );
               $this->db->insert("misc_case_process_reports", $userdata);
                $query = "update  misc_case_basic set note_of_action='Y' where misc_case_no='$case_no'";
                $this->db->query($query);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "NCANAAT001: Updation failed in table 'misc_case_basic' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(NCANAAT001)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    log_message('error', "NCANAAT002: transaction failed in table 'misc_case_basic','misc_case_process_reports' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(NCANAAT002)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }else{



                    //ESCALATION CODE INTEGRATION================SANMRI
                    $query1 = "select es_flag from misc_case_basic where misc_case_no='$case_no'";
                    $data = $this->db->query($query1)->row();
                    if($data->es_flag == 1 && ESCALATION_ENABLE ==1){
                        $executionDate = $this->input->post('executionDate');
                        $escalationUpdateStatus = $this->Escalationmodel->escalationDAActionNCAN($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);

                        log_message("error", "#ESC4163, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC4163, transaction-error in method 'officemutation/writenote' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong.NCAN- Error Code(#ESC4163)");
                            redirect(base_url() . "index.php/home");
                        }
                        
                    }
                    $this->db->trans_commit();
                    
                }  
                //////
                $penUser='CO';
                $rmrk='Action taken report given by Assistant';
                $this->DashboardData($case_no,$penUser,$rmrk);
                /////
                $this->session->set_flashdata(array('message' => "Action taken report given for case no $case_no"));
                redirect(base_url() . "index.php/home");
            
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code'); 
            $cir_code = $this->session->userdata('cir_code'); 
            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
            $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,submission_date,add_to_officer,next_date_of_hearing,misc_case_petition_no "
                    . "from    misc_case_basic where misc_case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
            
            $query = "select * from    misc_case_process_reports where misc_case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $details = $this->db->query($query)->result();
            $data['details'] = $details;
            
            $query1 = "select * from    misc_case_basic where misc_case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $petition_basic = $this->db->query($query1)->row();
            //var_dump($petition_basic);
            $data['location'] = array(
                'dist' => $dist_code_name,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'case_no' => $case_no,
                'date' => $location['submission_date'],
                'add_to' => $location['add_to_officer'],
                'case_no' => $case_no,
                'date_of_hearing' => $location['next_date_of_hearing'],
            );
            $data['_view'] = 'NameCancellation/writeNote';
            $this->load->view('layouts/main',$data);
        }
    }

    public function decodeBase64($encoded_string){
         $file_data= base64_decode($encoded_string);
         $file = finfo_open();
         $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
         $file_type = explode('/', $mime_type)[0];
         $extension = explode('/', $mime_type)[1];
         log_message("error","No error occured".json_encode($mime_type));
         return $mime_type;
     }

public function revertToLm(){
    if(isset($_POST['application_no']) && $_POST['application_no']!=''){
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRNMECORRCORVRT0014
            log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0014');
            $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0014');
            redirect(base_url('index.php/home'));
        }
        //syntax validation
        $validAppNo = applicationNumberValidation($_POST['application_no']);
        if(!empty($validAppNo)) {
            //ERRNMECANCCORVRT0001
            log_message('error', 'Application no. cant have special characters. Error: ERRNMECANCCORVRT0001');
            $this->session->set_flashdata("message", "Application no. cant have special characters. Error: ERRNMECANCCORVRT0001");
            redirect(base_url('index.php/home'));
        }
        if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
            //ERRNMECANCCORVRT0002
            log_message('error', 'Required Case no is empty. Error: ERRNMECANCCORVRT0002');
            $this->session->set_flashdata("message", "Required Case no is empty. Error: ERRNMECANCCORVRT0002");
            redirect(base_url('index.php/home'));
        }
        $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        if(!empty($validCaseNo)) {
            //ERRNMECANCCORVRT0003
            log_message('error', 'Case No. is not valid. Error: ERRNMECANCCORVRT0003');
            $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECANCCORVRT0003");
            redirect(base_url('index.php/home'));
        }

        $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
        if(!isset($_POST['co_revert_report']) || $_POST['co_revert_report']=='') {
            //ERRNMECANCCORVRT0004
            log_message('error', 'CO Revert Report is a required field. Error: ERRNMECANCCORVRT0004');
            $this->session->set_flashdata("message", "CO Revert Report is a required field. Error: ERRNMECANCCORVRT0004");
            redirect(base_url('index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
        }

        $validreport = specialCharacterCheckingInInput($_POST['co_revert_report'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validreport['status']=='n') {
            //ERRNMECANCCORVRT0005
            log_message('error', 'CO Revert Report has illegal characters. Error: ERRNMECANCCORVRT0005');
            $this->session->set_flashdata("message", "CO Revert Report has illegal characters. Error: ERRNMECANCCORVRT0005");
            redirect(base_url('index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
        }

        //authorization
        $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'CO', $_POST['misc_case_no']);
        if($response['status']=='n') {
            //ERRNMECANCCORVRT0006
            log_message('error', $response['messages'] .' Error: ERRNMECANCCORVRT0006');
            $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECANCCORVRT0006");
            redirect(base_url('index.php/home'));
        }

        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     //ERRNMECANCCORVRT0006
        //     log_message('error', 'User not authenticated. Error: ERRNMECANCCORVRT0006');
        //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECANCCORVRT0006");
        //     redirect(base_url('index.php/home'));
        // }
        //authorization
        // $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
        // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code'] || $sessionData['user_desig_code']!='CO'){
        //     //ERRNMECANCCORVRT0007
        //     log_message('error', 'User not authorized. Error: ERRNMECANCCORVRT0007');
        //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECANCCORVRT0007");
        //     redirect(base_url('index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
        // }

        $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
        $application_no=$this->input->post('application_no');
        $case_no = $this->input->post('misc_case_no');
        // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
        $petition_no = $petitionNo->misc_case_petition_no;

        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
        $data['miscCaseInfo'] = $caseInfo;
        $note_date = date('Y-m-d');
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
        $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($case_no, $petition_no));
        $note_no = ($result->row()->note_no) + 1;
        $operation = 'c';
        $co_fresh_proceeding = 'N';
        $note=$this->input->post('co_revert_report');

        $this->db->trans_begin();

        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no

        );
        $this->db->insert("misc_case_process_reports", $userdata);

        $proInsert = $this->mutationmodel->proceeding_order($case_no,$note);


       if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#MISCLMR001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#MISCLMR001)".$case_no);
            redirect(base_url() . "index.php/home");
        }
        
        $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");

        $penUser='LM';
        $rmrk='Revert to LM by CO';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
        if($rtps=='RTPS'){
            $apilink=RTPS_API_LINK;
        }else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $application_no,
            'dharitree' => $case_no,
            'rmk' => 'forwared to LM',
            'status' => 'M',
            'task' => 'CO',
            'pen'=>'LM',
            'penat'=>'Circle office'
        )));
        $result = curl_exec($curl_handle);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Something went wrong");
            redirect(base_url() . "index.php/home");
        }else{
            $this->db->trans_commit();
             $this->session->set_flashdata("message","LM Report Submitted Successfully...");
            redirect(base_url() . "index.php/home");
        }
    }
    else{
         //check for Malicious
         $validquery = checkRequestValidQuery($_POST);
         if($validquery['status']=='n') {
             //ERRNMECORRCORVRT0015
             log_message('error', $validquery['messages'] .'Error: ERRNMECORRCORVRT0015');
             $this->session->set_flashdata('message', 'Input Parameter has malicious characters. Error: ERRNMECORRCORVRT0015');
             redirect(base_url('index.php/home'));
         }
        if(!isset($_POST['misc_case_no']) || $_POST['misc_case_no']=='') {
            //ERRNMECANCCORVRT0008
            log_message('error', 'Required Case no cannot be empty. Error: ERRNMECANCCORVRT0008');
            $this->session->set_flashdata("message", "Required Case no cannot be empty. Error: ERRNMECANCCORVRT0008");
            redirect(base_url('index.php/home'));
        }

        //syntax validation
        $validCaseNo = caseNumberValidation($_POST['misc_case_no']);
        if(!empty($validCaseNo)) {
            //ERRNMECANCCORVRT0009
            log_message('error', 'Case No. is not valid. Error: ERRNMECANCCORVRT0009');
            $this->session->set_flashdata("message", "Case No. is not valid. Error: ERRNMECANCCORVRT0009");
            redirect(base_url('index.php/home'));
        }

        $petitionNo=$this->NameCorrectionModel->getPetitionNo($_POST['misc_case_no']);
        if(!isset($_POST['co_report1']) || $_POST['co_report1']=='') {
            //ERRNMECANCCORVRT0010
            log_message('error', 'CO Report is a required field. Error: ERRNMECANCCORVRT0010');
            $this->session->set_flashdata("message", "CO Report is a required field. Error: ERRNMECANCCORVRT0010");
            redirect(base_url('index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
        }

        $validreport = specialCharacterCheckingInInput($_POST['co_report1'], ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validreport['status']=='n') {
            //ERRNMECANCCORVRT0011
            log_message('error', 'CO Report has illegal characters. Error: ERRNMECANCCORVRT0011');
            $this->session->set_flashdata("message", "CO Report has illegal characters. Error: ERRNMECANCCORVRT0011");
            redirect(base_url('index.php/NameCancellation/finalOrderCONameCancellation?misc_case_no='. $_POST['misc_case_no'] .'&petition_no='. $petitionNo->misc_case_petition_no));
        }
        //authorization
        $response = $this->AuthorizationModel->isAuthorized(SERVICE_NAME_CANCEL, 'CO', $_POST['misc_case_no']);
        if($response['status']=='n') {
            //ERRNMECANCCORVRT0012
            log_message('error', $response['messages'] .' Error: ERRNMECANCCORVRT0012');
            $this->session->set_flashdata("message", $response['messages'] ." Error: ERRNMECANCCORVRT0012");
            redirect(base_url('index.php/home'));
        }
        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData)) {
        //     //ERRNMECANCCORVRT0012
        //     log_message('error', 'User not authenticated. Error: ERRNMECANCCORVRT0012');
        //     $this->session->set_flashdata("message", "User not authenticated. Error: ERRNMECANCCORVRT0012");
        //     redirect(base_url('index.php/home'));
        // }
        //authorization
        // if($caseInfo->dist_code!=$sessionData['dist_code'] || $caseInfo->subdiv_code!=$sessionData['subdiv_code'] || $caseInfo->cir_code!=$sessionData['cir_code']){
        //     //ERRNMECORRCORVRT0013
        //     log_message('error', 'User not authorized. Error: ERRNMECORRCORVRT0013');
        //     $this->session->set_flashdata("message", "User not authorized. Error: ERRNMECORRCORVRT0013");
        //     redirect(base_url('index.php/home'));
        // }

        $caseInfo = $this->NameCorrectionModel->getNameCorrCaseInfo($_POST['misc_case_no'], $petitionNo->misc_case_petition_no);
        $case_no=$this->input->post('misc_case_no');
        // $petition_no=$this->db->query("select misc_case_petition_no from misc_case_basic where misc_case_no=?", array($case_no))->row()->misc_case_petition_no;
        $petition_no=$petitionNo->misc_case_petition_no;
        // $data['miscCaseInfo'] = $this->NameCorrectionModel->getNameCorrCaseInfo($case_no, $petition_no);
        $data['miscCaseInfo'] = $caseInfo;
        $note_date = date('Y-m-d');
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
        $sql = "select MAX(note_no) AS note_no from misc_case_process_reports where misc_case_no=? and misc_case_petition_no = ?";
        $result = $this->db->query($sql, array($case_no, $petition_no));
        $note_no = ($result->row()->note_no) + 1;
        $operation = 'c';
        $co_fresh_proceeding = 'N';
        $note=$this->input->post('co_report1');

        $userdata = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'note_no' => $note_no,
            'misc_case_no' => $case_no,
            'co_fresh_proceeding' => $co_fresh_proceeding,
            'process_note' => $note,
            'note_date' => $note_date,
            'user_code' => $user_code,
            'operation' => $operation,
            'misc_case_petition_no' => $petition_no
        );
        $this->db->insert("misc_case_process_reports", $userdata);
        $this->db->query("UPDATE misc_case_basic SET status='L',lm_note_yn=null,sk_note_yn=null WHERE misc_case_no = '$case_no'");
        $penUser='LM';
        $rmrk='Revert to LM by CO';
        $this->DashboardData($case_no,$penUser,$rmrk);
   }

    $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
    redirect(base_url() . "index.php/home");
}

    // public function postParamFormValidation($post, $rules=[]) { //put this function in controller for post parameter validation and set the rules as 2nd parameter. Eg: postParamSyntaxValidation($_POST, ['application_no'=>'application_no', 'misc_case_no'=>'case_no', 'misc_case_petition_no'=>'digit', 'next_date_of_hearing'=>'date', 'next_date_time'=>'time', 'p1'=>'only_non_special_character', 'date_time_both'=>'datetime'])
    //     $result = [
    //         'status'=>'y',
    //         'message'=>'Post Parameters are OK'
    //     ];
    //     if(!empty($rules)) {
    //         foreach ($rules as $key => $value) {
    //             # code...
    //             if($value=='application_no') {
    //                 $response = applicationNumberValidation($post[$key]);
    //                 if(!empty($response)) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'Application no. has illegal character'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='case_no') {
    //                 $response = caseNumberValidation($post[$key]);
    //                 if(!empty($response)) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'Case No. has illegal character'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='digit'){
    //                 if(!preg_match('/^[0-9]*$/', $post[$key])) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'The post parameter is not a digit'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='time') {
    //                 if(!preg_match('/^[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key])) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'The post parameter is not in time format'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='date') {
    //                 if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $post[$key])) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'The post parameter is not in date format'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='datetime') {
    //                 if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $post[$key]) && !preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}\s[0-9]{2}:[0-9]{2}$/', $post[$key])) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'The post parameter is not in datetime format'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             else if($value=='char') {
    //                 if(!preg_match('/^.$/', $post[$key])) {
    //                     $result = [
    //                         'status'=>'n',
    //                         'message'=>'The post parameter is not in single character format'
    //                     ];
    //                     break;
    //                 }
    //             }
    //             // else if($value=='only_non_special_character') {
    //             //     $response = specialCharacterCheckingInInput($post[$key], ['.', '|']);
    //             //     if($response['status'] == 'n'){
    //             //         $result = [
    //             //             'status'=>'n',
    //             //             'message'=>'The post parameter contains illegal characters'
    //             //         ];
    //             //         break;
    //             //     }
    //             // }
    //             else {

    //             }
    //         }
    //     }
        
    //     return $result;
    // }
}