<?php
//BRD0003: Improvement in Objection FMUT

class Objection extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->library('session');
        $this->load->model('AgriStackCaseHistory');
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

    public function index() {
		// $db=  $this->session->userdata('db');
  //       $this->load->helper('html');
  //       $this->load->view('../views/header');
        $data = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        $q = "Select * from col8_order_type";
        $district['order'] = $this->db->query($q)->result();
        $q = "Select type_code,patta_type  from    patta_code where mutation='a' ";
        $district['patta_code'] = $this->db->query($q)->result();

        // $this->load->view('../views/objection/select_location', $district);
        // $this->load->view('../views/footer');


        $district['_view'] = 'objection/select_location';
        $this->load->view('layouts/main',$district);
    }

    public function registerobjection() {
		//$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $dag_no = $this->input->post('dag_no');
        $mut_type = '03';//$this->input->post('mut_type');
        $patta_code = $this->input->post('patta_code');
        $patta_no = trim($this->input->post('patta_no'));
        $q = "Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
        //var_dump($cirname);
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        if ($mut_type == '03') {
            $q = "Select  count('objection_case_no')+1 as c  from    field_mut_objection where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
            // echo $q;
            $type = "OFMut";
        } else {
            $q = "Select  count('objection_case_no')+1 as c  from    field_mut_objection where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  ";
            $type = "OFPart";
        }
        $petition_no = $this->db->query($q)->row()->c;
        //$case_no=$case.$type;
        $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/" . $type;
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'dag_no' => $dag_no,
            'patta_no' => trim($patta_no),
            'mut_type' => $mut_type,
            'case_no' => $case_no,
            'patta_type_code' => $patta_code
        );
        $this->session->set_userdata($locationData);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/objection/objection_register');
        // $this->load->view('../views/footer');


        $data['_view'] = 'objection/objection_register';
        $this->load->view('layouts/main',$data);
    }

    public function registerconfirm() {
		//$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $case_no = $this->session->userdata('case_no');
        ////////////////////////
        $name = $this->input->post('applicant_name');
        $previous_case_no = $this->input->post('previous_case_no');
        $address = $this->input->post('address');
        $reason_objection = $this->input->post('reason_objection');
        $datetime2 = date('Y-m-d', strtotime($this->input->post('previous_date')));
        $datetime1 = date('Y-m-d');
        $date1 = date_create($datetime1);
        $date2 = date_create($datetime2);
        $diff12 = date_diff($date2, $date1);
        $data['diff'] = $diff12;
        $tot_days = $diff12->format('%R%a days');
        $date = array('diff' => $diff12);
        if ($tot_days < 1095) {
            $q = "Select case_no,date_entry from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and case_no='$previous_case_no' and vill_townprt_code='$vill_code'  ";
            $data['cdata'] = $cdata = $this->db->query($q)->row();
            //echo $cdata->date_entry;
            if ($cdata == null) {
                $this->session->set_flashdata('set_message', 'Either Case Number does not match or Case Number delete from    records ! ');
                redirect(base_url() . "index.php/objection/error");
            } else {
                $casedeatils = array(
                    'previous_case_no' => $previous_case_no,
                    'address' => $address,
                    'reason_objection' => $reason_objection,
                    'applicant' => $name,
                    'date_entry' => $cdata->date_entry
                );
                $this->session->set_userdata($casedeatils);
                // $this->load->helper('html');
                // $this->load->view('../views/header');
                // $this->load->view('../views/objection/objection_confirm', $data);
                // $this->load->view('../views/footer');

                $data['_view'] = 'objection/objection_confirm';
                $this->load->view('layouts/main',$data);
            }
        } else {
            $this->session->set_flashdata('set_message', 'Case registered before three years ago !');
            redirect(base_url() . "index.php/objection/error");
        }
    }

    public function registerfinalconfirm() {
		//$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $case_no = $this->session->userdata('case_no');
        $previous_case_no = $this->session->userdata('previous_case_no');
        $address = $this->session->userdata('address');
        $reason_objection = $this->session->userdata('reason_objection');
        $mut_type = $this->session->userdata('mut_type');
        $dag_no = $this->session->userdata('dag_no');
        $user_code = $this->session->userdata('user_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $date_entry = $this->session->userdata('date_entry');
        $name = $this->session->userdata('applicant');
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mp_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vt_code' => $vill_code,
            'dag_no' => $dag_no,
            'mut_type' => '03',
            'objection_case_no' => $case_no,
            'regist_date' => date('Y-m-d'),
            'entry_date' => $date_entry,
            'reason_for_objection' => $reason_objection,
            'prev_fm_ca_no' => $previous_case_no,
            'obj_flag' => null,
            'submission_date' => null,
            'obj_name' => $name,
            'obj_add' => $address,
            'astt_flag' => '1',
            'co_id' => null,
            'patta_no' => trim($patta_no)
        );
        //     var_dump($data);
        $this->db->insert('field_mut_objection', $data);
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        $this->session->set_flashdata('message', "New Case with Case number $case_no has Registered");
        //$this->load->view('../views/objection/objection_register_final');
        //$this->load->view('../views/footer');  
        redirect(base_url() . "index.php/home/index");
    }

    public function error() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/objection/objection_error');
        // $this->load->view('../views/footer');


        $data['_view'] = 'objection/objection_error';
        $this->load->view('layouts/main',$data);
    }

    //////////////CO Start///////////////
    public function COStep1() {
		$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $cases = $this->db->query("SELECT * FROM  field_mut_objection WHERE dist_code='$dist_code' "
                        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and obj_flag is null  ")->result();
        $data['cases'] = $cases;
        //var_dump($cases);
        // $this->load->view('../views/header');
        // $this->load->view('../views/objection/Pendingcase', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'objection/Pendingcase';
        $this->load->view('layouts/main',$data);
    }

    public function FinalOrder() {
		//$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "Select * from    field_mut_objection where objection_case_no='$case_no'  and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'        ";
        $data['fieldOb'] = $ob = $this->db->query($q)->row();

        $q = "Select * from    chitha_col8_order  where case_no='$ob->prev_fm_ca_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   ";
        $data['fieldmb'] = $mutb = $this->db->query($q)->row();
        // var_dump($mutb);
        $q = "Select occupant_name as pet_name,occupant_fmh_name as  guard_name,occupant_add1 as add1,occupant_add2 as add2 from    chitha_col8_occup where col8order_cron_no='$mutb->col8order_cron_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and dag_no='$mutb->dag_no' and cir_code='$cir_code' and mouza_pargona_code='$mutb->mouza_pargona_code' and lot_no='$mutb->lot_no' and  vill_townprt_code='$mutb->vill_townprt_code' ";
        $data['fieldmp'] = $this->db->query($q)->result();

        // $this->load->view('../views/header');
        // $this->load->view('../views/objection/passorder', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'objection/passorder';
        $this->load->view('layouts/main',$data);
    }

    public function Cofinalorder() {
        //$db=  $this->session->userdata('db');
       
         $order = $this->input->post('order');
         $dist_code = $this->session->userdata('dist_code');
         $subdiv_code = $this->session->userdata('subdiv_code');
         $cir_code = $this->session->userdata('cir_code');
         $user_code = $this->session->userdata('user_code');
         $case_no = $this->input->post('case_no');     
         $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
         $patta_no = trim($this->input->post('patta_no'));
         $date = date('Y-m-d');
         $q = "Select * from    field_mut_objection where objection_case_no='$case_no' ";
         $data['fieldmb'] = $mb = $this->db->query($q)->row();
         ////////////////////
         if($order == 1){
            $data=[
               "case_no" =>   $case_no,
               "proceeding_id" => 1,
               "date_of_hearing"	=>  $date,
               "co_order"	=> $this->input->post('remarks'),
               "note_on_order" =>  $date,
               "next_date_of_hearing" =>  $date,	
               "status"	=> 'Reject',
               "user_code"	=> $user_code,
               "date_entry" =>  $date,	
               "operation"	=> 'E',
               "dist_code"	=> $dist_code,
               "subdiv_code" => $subdiv_code,	
               "cir_code"	=> $cir_code,
               "ip"	=> $this->utilityclass->get_client_ip(),
            ];
            $this->db->insert('petition_proceeding',$data);
            $values = array(
               'obj_flag' => '2',
               'submission_date' => date('Y-m-d G:i:s'),
               'co_id' => $user_code,
               'chitha_correct_yn'=>'0'
            );
            $this->db->update('field_mut_objection', $values);

            $this->session->set_flashdata('message', "Successfully Rejected Order");
            redirect(base_url() . "index.php/home");
         
        }

      ////////////////////////////
        $values = array(
            'obj_flag' => '1',
            'submission_date' => date('Y-m-d G:i:s'),
            'co_id' => $user_code,
			   'chitha_correct_yn'=>'1'
        );
        $this->db->trans_begin();
        $this->db->where('objection_case_no', $case_no);
	     $this->db->update('field_mut_objection', $values);
        if($this->db->affected_rows()!=1){
            log_message('error',"OBJECTION099:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
        }
        //////////////
         $q = "Select * from    chitha_col8_order  where case_no='$mb->prev_fm_ca_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'   ";
         $data['fieldmb'] = $mutb = $this->db->query($q)->row();



         if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
           {
            
               $this->load->model('propChain/PropChainCommonModel');
               $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($dist_code,$subdiv_code,$cir_code,$mutb->mouza_pargona_code,$mutb->lot_no,$mutb->vill_townprt_code,$mutb->dag_no);

               if($block_status==true){

                   $this->session->set_flashdata('message', "Backlog Entry cannot be passed for the given Dag as it is in Property chain!!");
                   redirect(base_url() . "index.php/home");
                   return;
               }

           }
		
		    $q="Select max(col8order_cron_no)+1 as cron_no from    chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and dag_no='$mutb->dag_no' and cir_code='$cir_code' and 
		       mouza_pargona_code='$mutb->mouza_pargona_code' and lot_no='$mutb->lot_no' and  vill_townprt_code='$mutb->vill_townprt_code' and dag_no='$mutb->dag_no' ";
      		$cron_no=$this->db->query($q)->row()->cron_no;
            if($cron_no==null){
               log_message('error',"OBJECTION098:". json_encode($this->db->last_query())."CASE:".$case_no);
               $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
               $this->db->trans_rollback();
               redirect(base_url() . "index.php/home");
            }
      		//var_dump($mb);
      		$col8_order=array(
      		  'dist_code' =>$mutb->dist_code,
      		  'subdiv_code' =>$mutb->subdiv_code,
      		  'cir_code' =>$mutb->cir_code,
      		  'mouza_pargona_code' =>$mb->mp_code,
      		  'lot_no' =>$mb->lot_no,
      		  'vill_townprt_code' =>$mb->vt_code,
      		  'dag_no' =>$mb->dag_no,
      		  'col8order_cron_no' =>$cron_no,
      		  'order_pass_yn' =>'Y',
      		  'order_type_code' =>$mb->mut_type,
      		  'lm_code' =>'NA',
      		  'lm_sign_yn' =>'N',
      		  //'lm_note_date' =>'',
      		  'co_code' =>$user_code,
      		  'co_sign_yn' =>'Y',
      		  'co_ord_date' =>date('Y-m-d'),
      		  'user_code' =>$user_code,
      		  'date_entry' =>date('Y-m-d') ,
      		  'operation' =>'E',
      		  'mut_land_area_b' =>'0',
      		  'mut_land_area_k' =>'0',
      		  'mut_land_area_lc' =>'0',
      		  'mut_land_area_g' =>'0',
      		  'mut_land_area_kr' =>'0',
      		  'land_area_left_b' =>'0',
      		  'land_area_left_k' =>'0',
      		  'land_area_left_lc' =>'0',
      		  'land_area_left_g' =>'0',
      		  'land_area_left_kr' =>'0',
      		  'jama_updated' =>'n',
      		  'case_no' =>$case_no,
      		);
		  //var_dump($col8_order);
		  $this->db->insert('chitha_col8_order',$col8_order);
        if($this->db->affected_rows()!=1){
            log_message('error',"OBJECTION096:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
        }
        $exsistq = "Select pdar_id from chitha_pattadar where (pdar_name,pdar_father) in (Select occupant_name,occupant_fmh_name from chitha_col8_occup  where  col8order_cron_no='$mutb->col8order_cron_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and dag_no='$mutb->dag_no' and cir_code='$cir_code' and 
		  mouza_pargona_code='$mutb->mouza_pargona_code' and lot_no='$mutb->lot_no' and  vill_townprt_code='$mutb->vill_townprt_code' ) and dist_code='$dist_code' and subdiv_code='$subdiv_code' and trim(patta_no)='$mb->patta_no' and cir_code='$cir_code' and 
        mouza_pargona_code='$mutb->mouza_pargona_code' and trim(patta_no)='$mb->patta_no' and lot_no='$mutb->lot_no' and  vill_townprt_code='$mutb->vill_townprt_code'";
        //$data['fieldmp']=$this->db->query($q)->result();
        //////////Strike First Party information//////
        $q = "Update chitha_dag_pattadar set p_flag='1' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mb->mp_code' "
                . "and lot_no='$mb->lot_no' and vill_townprt_code = '$mb->vt_code' and dag_no ='$mb->dag_no' and TRIM(patta_no)='$patta_no' and pdar_id in ($exsistq)  ";
        $cdp = $this->db->query($q);
        if($this->db->affected_rows()<=0){
            log_message('error',"OBJECTION001:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
        }
        //////////////Unstrike Second Party Information////////////////
        $sql="Select pdar_id from field_mut_pattadar where case_no='$mb->prev_fm_ca_no' ";
        $q = "Update chitha_dag_pattadar set p_flag='0' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mb->mp_code' "
                . "and lot_no='$mb->lot_no' and vill_townprt_code = '$mb->vt_code' and dag_no ='$mb->dag_no' and TRIM(patta_no)='$patta_no' and pdar_id in ($sql)  ";
        $cdp = $this->db->query($q);
        if($this->db->affected_rows()<=0){

            log_message('error',"OBJECTION004:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
        }
        ///////////////////////////////////
         // $data1 = array(
         //        'jama_yn' => null
         // );
         // $cond1 = array(
         //       'dist_code' => $mutb->dist_code, 
         //       'subdiv_code' => $mutb->subdiv_code, 
         //       'cir_code' => $mutb->cir_code, 
         //       'mouza_pargona_code' => $mutb->mouza_pargona_code,
         //       'lot_no' => $mutb->lot_no,
         //       'vill_townprt_code' => $mutb->vill_townprt_code, 
         //       'dag_no'=>$mb->dag_no
         // );
         // $this->db->where($cond1);
         // $this->db->where('patta_no',$mb->patta_no);
         // $this->db->update('chitha_basic', $data1);
         $table = 'chitha_basic';
         $params = [
            'jama_yn' => null
         ];
         $where = [
            'dist_code' => $mutb->dist_code, 
               'subdiv_code' => $mutb->subdiv_code, 
               'cir_code' => $mutb->cir_code, 
               'mouza_pargona_code' => $mutb->mouza_pargona_code,
               'lot_no' => $mutb->lot_no,
               'vill_townprt_code' => $mutb->vill_townprt_code, 
               'dag_no'=>$mb->dag_no
         ];

         // Call model's reusable update method
         $result =$this->Chitha_basic_model->update_table($table, $params, $where);

         if($result<=0){
            log_message('error',"OBJECTION0002:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
         }
         /////////////////////////////
         $data2 = array(
                'chitha_up' => 'c',
                'user_code' => $user_code
         );
         $cond1 = array(
               'dist_code' => $mutb->dist_code, 
               'subdiv_code' => $mutb->subdiv_code, 
               'cir_code' => $mutb->cir_code, 
               'mouza_pargona_code' => $mutb->mouza_pargona_code,
               'lot_no' => $mutb->lot_no,
               'vill_townprt_code' => $mutb->vill_townprt_code, 
               'dag_no'=>$mb->dag_no
         );
         $this->db->where($cond1);
         $this->db->update('chitha_col8_occup', $data2);
         if($this->db->affected_rows()<=0){
            log_message('error',"OBJECTION0003:". json_encode($this->db->last_query())."CASE:".$case_no);
            $this->session->set_flashdata('message', "Error in Updating .. Please Try again");
            $this->db->trans_rollback();
            redirect(base_url() . "index.php/home");
         }
         $this->db->trans_commit();
         $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
         $this->load->model('jamabandi/jamabandiAutoUpdateModel');
         $patta_type=$this->db->query("Select patta_type_code as pt from field_mut_dag_details where case_no='$mb->prev_fm_ca_no' ")->row()->pt;
         $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($mb->patta_no, $patta_type, $mutb->dist_code, $mutb->subdiv_code,$mutb->cir_code, $mutb->mouza_pargona_code, $mutb->lot_no, $mutb->vill_townprt_code, $case_no);
         $this->session->set_flashdata('message', "Successfully Passed. Please check Chitha & Jamabandi");
         redirect(base_url() . "index.php/home");
    }

    public function Thanks() {
        // $this->load->view('../views/header');
        // $this->load->view('../views/objection/thanks');
        // $this->load->view('../views/footer');

        $data['_view'] = 'objection/thanks';
        $this->load->view('layouts/main',$data);
    }

}
