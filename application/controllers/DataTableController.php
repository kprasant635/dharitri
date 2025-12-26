<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataTableController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and date(date_entry) >='$define_date'";
        $this->base_query_new = "fmb.dist_code = '$dist_code' and fmb.subdiv_code = '$subdiv_code' and fmb.cir_code = '$cir_code' and date(date_entry) >='$define_date'";
        $this->query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
        $this->load->model('Escalationmodel');
    }
    
 public function dbswitch(){       
     $CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$CI->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$CI->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$CI->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$CI->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$CI->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$CI->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$CI->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$CI->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$CI->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$CI->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$CI->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$CI->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$CI->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$CI->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$CI->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$CI->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$CI->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$CI->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$CI->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$CI->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$CI->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$CI->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$CI->load->database('dha23', TRUE);   
     } 
     else if($this->session->userdata('dist_code') == "39"){
        $this->db=$CI->load->database('dha39', TRUE);   
     }                                                                                                                                                                                                             
}
    function OmutCoSecondProceeding() {
		//$db=  $this->session->userdata('db');
        $this->load->model("PetitionBasic_Model");
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        if($mouza_code != null && $lot_no != null){
         $whereString = " and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'";
         }else{
            $whereString = null;
         }
        
        $clause = $this->base_query . $whereString." and not_fresh='Y' and status='P' and mut_type='03' and comp_serv_yn is null";
        
        $fetch_data = $this->PetitionBasic_Model->make_datatables($clause);
        $data = array();
        foreach ($fetch_data as $r) {
            $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

            $location = "Mouza : " . $mouza_pargona_code . "<br>" . $lot_no . "<br>" . $vill_townprt_code;

            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";

            $datetime1 = new DateTime();
            $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%R%a');
            $status = '';
            if ($r->status == 'P') {
                if ($days <= -1) {
                    $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                }
            }

            $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";

            if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
                $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> ভূমিলেখ্য সহায়কে প্ৰতিবেদন দিয়া নাই </p>";
            }
            if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
                $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
            }
            if ($r->sk_comment == '' or $r->sk_comment == null) {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> ভূমিলেখ্য পৰ্যবেক্ষকৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->proceeding_yn == '') {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->lm_note_yn == 'Y' and $r->notice_generated_yn == 'Y' and $r->proceeding_yn == '1') {
                $link1 = base_url() . "index.php/coofficemutation/proceeding2?case_no=" . enc_param('case_no', $r->case_no, 600) . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
                $status = $status . '<a class="btn btn-sm btn-success" href="' . $link1 . '">Write Report</a>&nbsp&nbsp';
            }
            $link2 = base_url() . "index.php/partition/setupdateProDate?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
            // $status = $status . '<a class="btn btn-sm btn-success" href="' . $link2 . '">Change Hearing Date </a>&nbsp&nbsp';
            //$link3 = base_url() . "index.php/partition/rejectOrder?case_no=" . $r->case_no ;
            $status = $status . '<button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('."'".$r->case_no."'".","."'".SERVICE_OFFICE_MUTATION."'" .')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>';

             if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                  {

                     $status .= '<button type="button" data-toggle="modal" data-target="#myModal" case_no="' . $r->case_no . '" dist_code="' . $r->dist_code . '" subdiv_code="' . $r->subdiv_code . '" cir_code="' . $r->cir_code . '" mouza_pargona_code="' . $r->mouza_pargona_code . '" lot_no="' . $r->lot_no . '" vill_townprt_code="' . $r->vill_townprt_code . '" class="chainReportOffice btn btn-sm btn-primary" style="margin:2px;">View Property Chain</button>';
                  }


            $basundhar=null;
            if($r->basundhara){
               $basundhar="<br><span class='small font-italic red'>Basundhara :" .$r->basundhara."</span>";
            }
            if($r->application_ref_no){
               $basundhar="<br><span class='small font-italic red'>RTPS :" .$r->application_ref_no."</span>";
            }
            
            $sub_array = array();
            $sub_array[] = $r->case_no .$basundhar;
            $sub_array[] = $location;
            $sub_array[] = $entry_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->PetitionBasic_Model->get_all_data($clause),
            "recordsFiltered" => $this->PetitionBasic_Model->get_filtered_data($clause),
            "data" => $data
        );
       // log_mecssage("error","bhrigu: output=".($this->db));
        //log_mecssage("error","bhrigu: output=".json_encode($output));
        echo json_encode($output);
    }

    function OfficePartSecondProceeding() {
      //$db=  $this->session->userdata('db');
         $this->load->model("PetitionBasic_Model");
         $mouza_code = $this->input->post('mouza_code');
         $lot_no = $this->input->post('lot_no');
         $zone_status = $this->input->post('zone_status');
         $draw = intval($this->input->post('draw'));
         $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
         $start = intval($this->input->post('start'));
         $length = intval($this->input->post('length'));
         $order = $this->input->post('order');
         $status_type = $this->input->post('status_type');
         if($mouza_code != null && $lot_no != null){
            $whereString = " and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'";
         }else{
            $whereString = null;
         }

         if($status_type == "Ready"){
            $whereString = " and lm_note_yn = 'Y' and sk_comment = 'Y' and proceeding_yn = '1'";
         } else if($status_type == 'Pending'){
            $whereString = " and (lm_note_yn != 'Y' or lm_note_yn IS NULL or sk_comment != 'Y' or sk_comment IS NULL or proceeding_yn != '1' or proceeding_yn IS NULL)";
         }else if($status_type == 'Escalated'){
            $whereString = "and es_flag = '1' and is_escalated = '1'";
         }

         
         $clause = $this->base_query . $whereString." and not_fresh='Y' and status='P' and mut_type='04'";

         if($zone_status != null || $zone_status != '') {

           $dist_code   = $this->session->userdata('dist_code');
           $subdiv_code = $this->session->userdata('subdiv_code');
           $cir_code    = $this->session->userdata('cir_code');   

           $results = $this->Escalationmodel->getSecondProceedPendingPartitionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, define_date, $zone_status, $searchByCol_0);
           // var_dump($results);
           if($results != null)
           {
                $fetch_data = $results['data_results'];
                $total_records = $results['total_records'];
                $recordsFiltered = $total_records;
           }
           else
           {
                $fetch_data = null;
                $total_records = 0;
                $recordsFiltered = 0;
           }

         }

         
         else {
           $fetch_data = $this->PetitionBasic_Model->make_datatables($clause);
           $total_records = $this->PetitionBasic_Model->get_all_data($clause);
           $recordsFiltered = $this->PetitionBasic_Model->get_filtered_data($clause);
         }

        $data = array();
        foreach ($fetch_data as $r) {

         if($r->es_flag ==1)
          {
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($r->case_no);

            if(isset($escRow->assigned_to) && $escRow->assigned_to != null)
            {
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($r->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $r->date_entry)); 

              // log_message('error', '#5531: Escalation details : '.json_encode($escData)); 

              if(($r->lm_note_yn == '' || $r->lm_note_yn == null) || ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) || ($r->sk_comment == '' or $r->sk_comment == null) || $r->proceeding_yn == '') 
              {
                $r->escalation_date = 'NA';
                $r->escalation_zone = 'NA';  
                $r->zone_color      = '';
              }
              else {
                $r->escalation_date = $escData->escalation_date;
                $r->escalation_zone = $escData->escalation_zone;
                $r->assigned_date   = $escData->assigned_date;  
                $r->zone_color      = $escData->zone_color;  
              }
            }
            else{
              $r->escalation_date = 'NA';
              $r->escalation_zone = 'NA';
              $r->zone_color      = '';
            }
          }
          else {
            $r->escalation_date = 'NA';
            $r->escalation_zone = 'NA';
            $r->zone_color      = '';
          }
            $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

            $location = "Mouza : " . $mouza_pargona_code . "<br>" . $lot_no . "<br>" . $vill_townprt_code;

            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->submission_date)) . "</p>";

            $datetime1 = new DateTime();
            $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%R%a');
            $status = '';
            if ($r->status == 'P') {
                if ($days <= -1) {
                    $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                }
            }

            $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";

            if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
                $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> ভূমিলেখ্য সহায়ক প্ৰতিবেদন দিয়া নাই </p>";
            }
            if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
                $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
            }
            if ($r->sk_comment == '' or $r->sk_comment == null) {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> ভূমিলেখ্য পৰ্যবেক্ষকৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->proceeding_yn == '') {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->lm_note_yn == 'Y' and $r->sk_comment == 'Y' and $r->proceeding_yn == '1') {

                if(ESCALATION_ENABLE ==1 && $r->is_escalated == 1)
                {
                    $status = "Escalated to Appellate Authority";
                }
                else
                {
                    $link1 = base_url() . "index.php/partition/COSecondProc?case_no=" . enc_param('case_no', $r->case_no, 600) . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
                    $status = $status . '<a class="btn btn-sm btn-success" href="' . $link1 . '">Write Report</a>&nbsp&nbsp';
                    $status = $status . '<button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('."'".$r->case_no."'".","."'".SERVICE_OFFICE_PARTITION."'" .')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>';
                }
                
            }




            $link2 = base_url() . "index.php/partition/setupdateProDate?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
            // $status = $status . '<a class="btn btn-sm btn-success" href="' . $link2 . '">Change Hearing Date </a>&nbsp&nbsp';
            //$link3 = base_url() . "index.php/partition/rejectOrder?case_no=" . $r->case_no ;
            
            $basundhar=null;
            if($r->basundhara){
               $basundhar="<br><span class='small font-italic red'>Basundhara :" .$r->basundhara."</span>";
            }
            if($r->application_ref_no){
               $basundhar="<br><span class='small font-italic red'>RTPS :" .$r->application_ref_no."</span>";
            }
            if (isset($r->basundhara) && $r->lm_note_yn == 'Y') {
               $linkRevert = base_url() . "index.php/Partition/revertback?case_no=" . $r->case_no. "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
               $status = $status . '<a class="btn btn-sm btn-danger" href="' . $linkRevert . '">Revert Back for Report </a>&nbsp&nbsp';
            }

          
            
            $linkRevert2 = base_url() . "index.php/lmmutation/proreportOpart?case_no=" . $r->case_no;
            $status .= '<a class="btn btn-sm btn-danger" href="' . $linkRevert2 . '" target="_blank">All Notes</a>&nbsp;&nbsp;';


            $sub_array = array();
            if(ESCALATION_ENABLE ==1){
               $sub_array[] = $r->escalation_zone;
               $sub_array[] = $r->escalation_date;
             }
            $sub_array[] = $r->case_no .$basundhar;
            $sub_array[] = $location;
            $sub_array[] = $entry_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->PetitionBasic_Model->get_all_data($clause),
            "recordsFiltered" => $this->PetitionBasic_Model->get_filtered_data($clause),
            "data" => $data
        );
       // log_mecssage("error","bhrigu: output=".($this->db));
        //log_mecssage("error","bhrigu: output=".json_encode($output));
        echo json_encode($output);
    }

    function CitizenCentricAst() {
		//$db=  $this->session->userdata('db');
        $this->load->model("CitizenCentric_Model");
        $define_date = define_date;
        // $define_date = '2021-09-01';
        $clause = $this->query . " and LM_Checked_yn='Y' and CO_Checked_yn ='Y' and Status='R' and apply_date >='$define_date'";
        $fetch_data = $this->CitizenCentric_Model->make_datatables($clause);
		
        $data = array();
		//var_dump($fetch_data);
        foreach ($fetch_data as $r) {
			
			$cert_type = $this->utilityclass->getCertName($r->cert_type);
            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";
            if(date('d-m-Y', strtotime($r->next_due_date)) == '01-01-1970'){
                $next_due_date = "<p class='text-success'>Not Declared</p>";
            } else {
                $next_due_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->next_due_date)) . "</p>";
            }
			//echo $r->mode_of_registration;
			if($r->mode_of_registration == 'citizen'){
				$link1 = base_url() . "index.php/serviceplus/AssttPrintCert?cert_no=" . $r->cert_no . "&certtype=" . $r->cert_type;
				//$link1 = base_url() . "index.php/CitizenController/AssttPrintCert?cert_no=" . $r->cert_no . "&certtype=" . $r->cert_type;
            } else {
				$link1 = base_url() . "index.php/CitizenController/AssttPrintCert?cert_no=" . $r->cert_no . "&certtype=" . $r->cert_type;
            }
            $status = '<a class="btn btn-success" href="' . $link1 . '">Print Report</a>';
            

            $sub_array = array();
            $sub_array[] = $r->cert_no;
            $sub_array[] = $cert_type;
            $sub_array[] = $entry_date;
            $sub_array[] = $next_due_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
		//var_dump($data);
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->CitizenCentric_Model->get_all_data($clause),
            "recordsFiltered" => $this->CitizenCentric_Model->get_filtered_data($clause),
            "data" => $data
        );
        echo json_encode($output);
   }


   function OfficePartSecondProceedingES() 
   {
      //$db=  $this->session->userdata('db');
      $this->load->model("PetitionBasic_Model");
      $mouza_code = $this->input->post('mouza_code');
      $lot_no = $this->input->post('lot_no');
      $zone_status = $this->input->post('zone_status');

      $draw = intval($this->input->post('draw'));
      $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
      $start = intval($this->input->post('start'));
      $length = intval($this->input->post('length'));
      $order = $this->input->post('order');

      if($mouza_code != null && $lot_no != null){
        $whereString = " and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'";
      }else{
        $whereString = null;
      }
        
      $clause = $this->base_query . $whereString." and not_fresh='Y' and status='P' and mut_type='04'";

      if($zone_status != null || $zone_status != '') {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');   

        $results = $this->Escalationmodel->getSecondProceedPendingPartitionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, define_date, $zone_status, $searchByCol_0);

        $fetch_data = $results['data_results'];
        $total_records = $results['total_records'];
        $recordsFiltered = $total_records;
      }
      else {
        $fetch_data = $this->PetitionBasic_Model->make_datatables($clause);
        $total_records = $this->PetitionBasic_Model->get_all_data($clause);
        $recordsFiltered = $this->PetitionBasic_Model->get_filtered_data($clause);
      }
      $data = array();

      if($total_records > 0){
        foreach ($fetch_data as $r) {

          if($r->es_flag ==1)
          {
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($r->case_no);

            if(isset($escRow->assigned_to) && $escRow->assigned_to != null)
            {
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($r->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $r->date_entry)); 

              // log_message('error', '#5531: Escalation details : '.json_encode($escData)); 

              if(($r->lm_note_yn == '' || $r->lm_note_yn == null) || ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) || ($r->sk_comment == '' or $r->sk_comment == null) || $r->proceeding_yn == '') 
              {
                $r->escalation_date = 'NA';
                $r->escalation_zone = 'NA';  
                $r->zone_color      = '';
              }
              else {
                $r->escalation_date = $escData->escalation_date;
                $r->escalation_zone = $escData->escalation_zone;
                $r->assigned_date   = $escData->assigned_date;  
                $r->zone_color      = $escData->zone_color;  
              }
            }
            else{
              $r->escalation_date = 'NA';
              $r->escalation_zone = 'NA';
              $r->zone_color      = '';
            }
          }
          else {
            $r->escalation_date = 'NA';
            $r->escalation_zone = 'NA';
            $r->zone_color      = '';
          }

          $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
          $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
          $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

          $location = "Mouza : " . $mouza_pargona_code . "<br>" . $lot_no . "<br>" . $vill_townprt_code;

          $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->submission_date)) . "</p>";

          $datetime1 = new DateTime();
          $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
          $interval = $datetime1->diff($datetime2);
          $days = $interval->format('%R%a');
          $status = '';
          if ($r->status == 'P') {
            if ($days <= -1) {
              $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
            }
          }

          $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";

          if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
            $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
          }
          if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
            $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
          }
          if ($r->sk_comment == '' or $r->sk_comment == null) {
            $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
          }
          if ($r->proceeding_yn == '') {
            $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
          }

          if ($r->lm_note_yn == 'Y' and $r->sk_comment == 'Y' and $r->proceeding_yn == '1') {
            $link1 = base_url() . "index.php/partition/COSecondProc?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
            $status = $status . '<a class="btn btn-sm btn-success" href="' . $link1 . '">Write Report</a>&nbsp&nbsp';
          }

          $link2 = base_url() . "index.php/partition/setupdateProDate?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
          // $status = $status . '<a class="btn btn-sm btn-success" href="' . $link2 . '">Change Hearing Date </a>&nbsp&nbsp';
          //$link3 = base_url() . "index.php/partition/rejectOrder?case_no=" . $r->case_no ;
          $status = $status . '<button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('."'".$r->case_no."'".","."'".SERVICE_OFFICE_PARTITION."'" .')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>';
          $basundhar=null;
          if($r->basundhara){
            $basundhar="<br><span class='small font-italic red'>Basundhara :" .$r->basundhara."</span>";
          }
          if($r->application_ref_no){
            $basundhar="<br><span class='small font-italic red'>RTPS :" .$r->application_ref_no."</span>";
          }
          if (isset($r->basundhara) && $r->lm_note_yn == 'Y') {
            $linkRevert = base_url() . "index.php/Partition/revertback?case_no=" . $r->case_no. "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
            $status = $status . '<a class="btn btn-sm btn-danger" href="' . $linkRevert . '">Revert Back for Report </a>&nbsp&nbsp';
          }
            
          $sub_array = array();
          if(ESCALATION_ENABLE ==1){
            $sub_array[] = $r->escalation_zone;
            $sub_array[] = $r->escalation_date;
          }
          $sub_array[] = $r->case_no .$basundhar;
          $sub_array[] = $location;
          $sub_array[] = $entry_date;
          $sub_array[] = $status;
          $data[] = $sub_array;
        }
      }
      else {
        $output = "";
      }
      $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $total_records,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $data
      );
      echo json_encode($output);      
   }

   function OmutCoSecondProceedingES() {
      //$db=  $this->session->userdata('db');
      $this->load->model("PetitionBasic_Model");
      $mouza_code = $this->input->post('mouza_code');
      $lot_no = $this->input->post('lot_no');
      $zone_status     = $this->input->post('zone_status');

      $draw = intval($this->input->post('draw'));
      $searchByCol_0 = $this->input->post('columns')[2]['search']['value'];
      $start = intval($this->input->post('start'));
      $length = intval($this->input->post('length'));
      $order = $this->input->post('order');
      $status_type = $this->input->post('status_type');

      if($mouza_code != null && $lot_no != null){
         $whereString = " and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'";
         }else{
            $whereString = null;
         }
      
         
         $join = false;
         if($status_type == "Ready"){
            $whereString = " and lm_note_yn = 'Y' and notice_generated_yn = 'Y' and proceeding_yn = '1'";
         } else if($status_type == 'Pending'){
            $whereString = " and (lm_note_yn != 'Y' or lm_note_yn IS NULL or notice_generated_yn != 'Y' or notice_generated_yn IS NULL or proceeding_yn != '1' or proceeding_yn IS NULL)";
         }else if($status_type == 'Escalated'){
            $whereString = "and es_flag = '1' and is_escalated = '1'";
         }else if($status_type == 'SRO'){
            $whereString = "and sph.sro_code is not null and sph.remark is not null ";
            $join = true;
         }
      
         
         $clause = $this->base_query_new . $whereString." and not_fresh='Y' and fmb.status='P' and mut_type='03' and comp_serv_yn is null";

         if($zone_status != null || $zone_status != '') {

            $dist_code   = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code    = $this->session->userdata('cir_code');   

            $results = $this->Escalationmodel->getSecondProceedPendingMutationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, define_date, $zone_status, $searchByCol_0);

            $fetch_data = $results['data_results'];
            $total_records = $results['total_records'];
            $recordsFiltered = $total_records;
         }
         else {
            $fetch_data = $this->PetitionBasic_Model->make_datatables($clause,$join);
            $total_records = $this->PetitionBasic_Model->get_all_data($clause,$join);
            $recordsFiltered = $this->PetitionBasic_Model->get_filtered_data($clause,$join);
         }

         $data = array();

         if($total_records > 0){
            //paste foreach here to process further   
            foreach ($fetch_data as $r) {


               if($r->es_flag ==1){
                  $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($r->case_no);
                  if(!empty($escRow))
                  {

                    if(isset($escRow->assigned_to) && $escRow->assigned_to != null)
                      {
                         $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($r->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $r->date_entry)); 

                         // log_message('error', '#5531: Escalation details : '.json_encode($escData)); 

                         if(($r->lm_note_yn == '' || $r->lm_note_yn == null) || ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) || ($r->sk_comment == '' or $r->sk_comment == null) || $r->proceeding_yn == '') 
                         {
                            $r->escalation_date = 'NA';
                            $r->escalation_zone = 'NA';  
                            $r->zone_color      = '';
                         }
                         else {
                            $r->escalation_date = $escData->escalation_date;
                            $r->escalation_zone = $escData->escalation_zone;
                            $r->assigned_date   = $escData->assigned_date;  
                            $r->zone_color      = $escData->zone_color;  
                         }
                      }else{
                         $r->escalation_date = 'NA';
                         $r->escalation_zone = 'NA';
                         $r->zone_color      = '';
                      }

                  }
                  else {
                      $r->escalation_date = 'NA';
                      $r->escalation_zone = 'NA';
                      $r->zone_color      = '';
                  }

                                    
               }
               else {
                  $r->escalation_date = 'NA';
                  $r->escalation_zone = 'NA';
                  $r->zone_color      = '';
               }

               $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
               $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
               $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

               $location = "Mouza : " . $mouza_pargona_code . "<br>" . $lot_no . "<br>" . $vill_townprt_code;

               $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";

               $datetime1 = new DateTime();
               $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
               $interval = $datetime1->diff($datetime2);
               $days = $interval->format('%R%a');
               $status = '';
               if ($r->status == 'P') {
                  if ($days <= -1) {
                     $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                  }
               }

               $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";

               if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
                  $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
               }
               if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
                  $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
               }
               if ($r->sk_comment == '' or $r->sk_comment == null) {
                  $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
               }
               if ($r->proceeding_yn == '') {
                  $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
               }


               if ($r->lm_note_yn == 'Y' and $r->notice_generated_yn == 'Y' and $r->proceeding_yn == '1') {
                if(ESCALATION_ENABLE ==1 && $r->is_escalated == 1)
                {
                    $status = "Escalated to Appellate Authority";
                }else
                {
                    $link1 = base_url() . "index.php/coofficemutation/proceeding2?case_no=" . enc_param('case_no', $r->case_no, 600) . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
                    $status = $status . '<a class="btn btn-sm btn-success" href="' . $link1 . '">Write Report</a>&nbsp&nbsp';
                }
                  
               }
               $link2 = base_url() . "index.php/partition/setupdateProDate?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
               // $status = $status . '<a class="btn btn-sm btn-success" href="' . $link2 . '">Change Hearing Date </a>&nbsp&nbsp';

                if(ESCALATION_ENABLE ==1 && ($r->is_escalated == 0 || $r->is_escalated == null))
                {
                    $status = $status . '<button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('."'".$r->case_no."'".","."'".SERVICE_OFFICE_MUTATION."'" .')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>';
                }
               //$link3 = base_url() . "index.php/partition/rejectOrder?case_no=" . $r->case_no ;
               
               $basundhar=null;

               if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                  {

                     $status .= '<button type="button" data-toggle="modal" data-target="#myModal" case_no="' . $r->case_no . '" dist_code="' . $r->dist_code . '" subdiv_code="' . $r->subdiv_code . '" cir_code="' . $r->cir_code . '" mouza_pargona_code="' . $r->mouza_pargona_code . '" lot_no="' . $r->lot_no . '" vill_townprt_code="' . $r->vill_townprt_code . '" class="chainReportOffice btn btn-sm btn-primary" style="margin:2px;">View Property Chain</button>';
                  }


               if($r->basundhara){
                  $basundhar="<br><span class='small font-italic red'>Basundhara :" .$r->basundhara."</span>";
               }
               if($r->application_ref_no){
                  $basundhar="<br><span class='small font-italic red'>RTPS :" .$r->application_ref_no."</span>";
               }

               $sub_array = array();
               if(ESCALATION_ENABLE ==1){
                  $sub_array[] = $r->escalation_zone;
                  $sub_array[] = $r->escalation_date;
               }
               $sub_array[] = $r->case_no .$basundhar;
               $sub_array[] = $location;
               $sub_array[] = $entry_date;
               $sub_array[] = $status;
               $data[] = $sub_array;
            }
         }

         else {
            $output = "";
         }

         $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
         );
      // log_mecssage("error","bhrigu: output=".($this->db));
      // log_message("error"," output=".json_encode($output));
      echo json_encode($output);
   }

    function OmutCoSecondProceedingRevive() {
        //$db=  $this->session->userdata('db');
        $this->load->model("PetitionBasic_Model");
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        if($mouza_code != null && $lot_no != null){
         $whereString = " and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'";
         }else{
            $whereString = null;
         }
        
        $clause = $this->base_query . $whereString." and case_no='MET/GUW/2023-24/20240014228/OMUT'";
        // $clause = $this->base_query . $whereString." and not_fresh='Y' and status='P' and mut_type='03' and comp_serv_yn is null";
        
        $fetch_data = $this->PetitionBasic_Model->make_datatables($clause);
        $data = array();
        foreach ($fetch_data as $r) {
            $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

            $location = "Mouza : " . $mouza_pargona_code . "<br>" . $lot_no . "<br>" . $vill_townprt_code;

            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";

            $datetime1 = new DateTime();
            $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%R%a');
            $status = '';
    

            
            $link2 = base_url() . "index.php/coofficemutation/reviveCaseNo?case_no=" . $r->case_no . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
            $status = $status . '<a class="btn btn-danger" href="' . $link2 . '">Revive Case</a>&nbsp&nbsp';
            //$link3 = base_url() . "index.php/partition/rejectOrder?case_no=" . $r->case_no ;


            $basundhar=null;
            if($r->basundhara){
               $basundhar="<br><span class='small font-italic red'>Basundhara :" .$r->basundhara."</span>";
            }
            if($r->application_ref_no){
               $basundhar="<br><span class='small font-italic red'>RTPS :" .$r->application_ref_no."</span>";
            }
            
            $sub_array = array();
            $sub_array[] = $r->case_no .$basundhar;
            $sub_array[] = $location;
            $sub_array[] = $entry_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->PetitionBasic_Model->get_all_data($clause),
            "recordsFiltered" => $this->PetitionBasic_Model->get_filtered_data($clause),
            "data" => $data
        );
       // log_mecssage("error","bhrigu: output=".($this->db));
        //log_mecssage("error","bhrigu: output=".json_encode($output));
        echo json_encode($output);
    }

}
?>