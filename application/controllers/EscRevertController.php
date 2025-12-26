<?php
class EscRevertController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('EscRevertModel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('AutoRegistrationmodel');      
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

    public function testAES(){
      $aes_flag = $this->AutoEscRevertModel->autoEscalatePendingCases();
      echo "<pre>";
      var_dump($aes_flag);
      echo "</pre>";
    }

    public function searchByEscalationZoneRevertedForLm()
    {
      $dist_code      = $this->session->userdata('dist_code');
      $subdiv_code    = $this->session->userdata('subdiv_code');
      $cir_code       = $this->session->userdata('cir_code');
      $lot_no         = $this->session->userdata('lot_no');
      $mouza          = $this->session->userdata('mouza_pargona_code');
      $draw           = intval($this->input->post('draw'));
      $searchByCol_0  = $this->input->post('columns')[0]['search']['value'];
      $start          = intval($this->input->post('start'));
      $length         = intval($this->input->post('length'));
      $order          = $this->input->post('order');
      $define_date    = define_date;
      $zone_status    = $this->input->post('zone_status');

      $results = $this->EscRevertModel->getPendingFieldRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

      // var_dump($results); die;

      if(isset($results)){
        $data_rows = $results['data_results'];
        $total_records = $results['total_records'];

        if($total_records > 0){
          foreach($data_rows as $rows){
        
            // log_message("error","#1068: ==========".json_encode($rows));
      
            if($rows->es_flag == '1'){

              $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
              if(!empty($escRow))
              {
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 

                  // log_message('error', '#1171: Escalation details : '.json_encode($escData)); 

                  $rows->escalation_date = $escData->escalation_date;
                  $rows->escalation_zone = $escData->escalation_zone;
                  $rows->assigned_date   = $escData->assigned_date;

              }
              else
              {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
              }
              
              
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }

            if ($rows->mut_type == '01') 
            {
              $lm_report_link = base_url()."index.php/skmutation/getLMReport1?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;

              $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report_link." class='skreport btn-sm btn btn-success'><i class='fa fa-envelope-open' aria-hidden='true'></i> Lot Mondol Report</a>";
            }
            else
            {
              $lm_report_link = base_url()."index.php/skmutation/getLMReportPartition?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;

              $lm_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$lm_report_link." class='skreport btn-sm btn btn-success'><i class='fa fa-envelope-open' aria-hidden='true'></i> Lot Mondol Report</a>";
            }

            $sk_report_link = base_url()."index.php/cofieldmutation/getSkNote?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;

            $sk_report_button = "<a type='button' data-toggle='modal' data-target='#myModal' href=".$sk_report_link." class='skreport btn-sm btn btn-success'><i class='fa fa-envelope-open' aria-hidden='true'></i> SK Report</a>";

            $all_note_link = base_url()."index.php/lmmutation/proreport?case_no=".$rows->case_no;

            $all_note_button = "<div style='height:5px;'>&nbsp;</div><a type='button' data-toggle='modal' data-target='#myModal' href=".$all_note_link." class='skreport btn-sm btn btn-success'><i class='fa fa-envelope-open' aria-hidden='true'></i> All Note(s)</a>";

            if($this->session->userdata('user_desig_code')=='LM')
            {
              $fresh_report_link = base_url()."index.php/lmmutation/freshLmReport?case_no=".$rows->case_no;

              $fresh_report_btn = "<a type='button' href=".$fresh_report_link." class='btn btn-sm btn-danger'><i class='fa fa-reply-all' aria-hidden='true'></i> Fresh Report</a>";
            }
            else 
            {
              $fresh_report_link = base_url()."index.php/lmmutation/freshskReport?case_no=".$rows->case_no;

              $fresh_report_btn = "<a type='button' href=".$fresh_report_link." class='btn btn-sm btn-danger'><i class='fa fa-reply-all' aria-hidden='true'></i> Fresh Report</a>";
            }

            $button = $lm_report_button.' '.$sk_report_button.' '.$all_note_button.' '.$fresh_report_btn;

            $report_date = '<p class="text-success"><i class="fa fa-calendar"></i> Hearing Date : '.date('M jS, Y',strtotime($rows->report_date)).'</p>';

            $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

            $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

            $json[] = array(

                $rows->escalation_zone,
                $rows->escalation_date,

                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                $location,

                $report_date,
                
                $button
            );
          }
        }
        else {
          $json = "";
        }  
        
        $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
        );
        echo json_encode($response);
      }
      else
      {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
      }
    }


    public function searchByEscalationZoneRevertedForOfficeLm()
    {
      $dist_code      = $this->session->userdata('dist_code');
      $subdiv_code    = $this->session->userdata('subdiv_code');
      $cir_code       = $this->session->userdata('cir_code');
      $lot_no         = $this->session->userdata('lot_no');
      $mouza          = $this->session->userdata('mouza_pargona_code');
      $draw           = intval($this->input->post('draw'));
      $searchByCol_0  = $this->input->post('columns')[0]['search']['value'];
      $start          = intval($this->input->post('start'));
      $length         = intval($this->input->post('length'));
      $order          = $this->input->post('order');
      $define_date    = define_date;
      $zone_status    = $this->input->post('zone_status');

      $results = $this->EscRevertModel->getPendingofficeRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

      // var_dump($results); die;

      if(isset($results)){
        $data_rows = $results['data_results'];
        $total_records = $results['total_records'];

        if($total_records > 0)
        {
          foreach($data_rows as $rows)
          {        
            log_message("error","#1068: ==========".json_encode($rows));
      
            if($rows->es_flag == '1'){

              $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

              if(!empty($escRow) && $escRow != null)
              {
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                log_message('error', '#2789: Escalation details : '.json_encode($escData)); 

                if(!empty($escRow) && $escRow != null)
                {
                  $rows->escalation_date = $escData->escalation_date;
                  $rows->escalation_zone = $escData->escalation_zone;
                  $rows->assigned_date   = $escData->assigned_date;
                }
                else {
                  $rows->escalation_date = 'NA';
                  $rows->escalation_zone = 'NA';
                }
              }
            }
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }

            $write_report_link = base_url()."index.php/lmmutation/writeRevertOMReport?case_no=".$rows->case_no;

            $write_report_btn = "<a href=".$write_report_link." class='btn btn-sm btn-block btn-primary'><i class='fa fa-pencil'></i> Write Report</a>"; 

            $report_date = '<p class="text-success"><i class="fa fa-calendar"></i> Hearing Date : '.date('M jS, Y',strtotime($rows->next_date_of_hearing)).'</p>';

            $location = 'Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

            $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;

            $json[] = array(

                $rows->escalation_zone,
                $rows->escalation_date,
                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                $location,
                $report_date,                
                $write_report_btn
            );
          }
        }
        else {
          $json = "";
        }  
        
        $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
        );
        echo json_encode($response);
      }
      else
      {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
      }
    }

    // office partition LM revert cases
    public function searchByEscalationZoneRevertedForOffPartLm()
    {
      $dist_code     = $this->session->userdata('dist_code');
      $subdiv_code   = $this->session->userdata('subdiv_code');
      $cir_code      = $this->session->userdata('cir_code');
      $lot_no        = $this->session->userdata('lot_no');
      $mouza         = $this->session->userdata('mouza_pargona_code');
      $draw          = intval($this->input->post('draw'));
      $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
      $start         = intval($this->input->post('start'));
      $length        = intval($this->input->post('length'));
      $order         = $this->input->post('order');
      $define_date   = define_date;
      $zone_status   = $this->input->post('zone_status');

      // var_dump($zone_status); die;

      $results = $this->EscRevertModel->getRevOfficePartitionCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

      if(isset($results)){
        $data_rows = $results['data_results'];
        $total_records = $results['total_records'];

        if($total_records > 0){
          foreach($data_rows as $rows){
        
            log_message("error","#329: ==========".json_encode($rows));
      
            if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

              $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

              if(!empty($escRow) && $escRow != null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
                log_message('error', '#337: Escalation details : '.json_encode($escData)); 

                if(!empty($escRow) && $escRow != null){
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
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }

            $link = base_url() . "index.php/lmmutation/writeOfficeReport?case_no=".$rows->case_no;

            $button = "<a href=".$link." class='btn btn-primary'><i class='fa fa-pencil'></i> Write Report</a>";

            $submission_date = '<i class="glyphicon glyphicon-calendar"></i> '.date('d/m/Y',strtotime($rows->submission_date)).'</p>';

            if ($rows->mut_type == '04') {
              $rep_link = base_url().'index.php/partition/LmPartitionRpt?petition_no='.$rows->petition_no.'&case_no='.$rows->case_no;
              $button = "<a class='btn btn-danger msg' href='".$rep_link."'>Write Report</a>";
            }
            $title = 'Office Partition';

            $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
            $json[] = array(

                $rows->escalation_zone,
                $rows->escalation_date,

                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                $title,

                $submission_date,
                
                $button
            );
          }
        }

        else {
            $json = "";
        }   
        
        $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
        );
        echo json_encode($response);
      }
      else
      {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
      }
    }


    // reclass LM revert
    public function searchByEscalationZoneRevertedReclassLm()
    {
      $dist_code     = $this->session->userdata('dist_code');
      $subdiv_code   = $this->session->userdata('subdiv_code');
      $cir_code      = $this->session->userdata('cir_code');
      $lot_no        = $this->session->userdata('lot_no');
      $mouza         = $this->session->userdata('mouza_pargona_code');
      $draw          = intval($this->input->post('draw'));
      $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
      $start         = intval($this->input->post('start'));
      $length        = intval($this->input->post('length'));
      $order         = $this->input->post('order');
      $define_date   = define_date;
      $zone_status   = $this->input->post('zone_status');

      $results = $this->EscRevertModel->getRevertReclassCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status);

      if(isset($results)){
        $data_rows = $results['data_results'];
        $total_records = $results['total_records'];

        if($total_records > 0){
          foreach($data_rows as $rows){
        
            log_message("error","#329: ==========".json_encode($rows));
      
            if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){

              $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

              if(!empty($escRow) && $escRow != null){
                $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
                log_message('error', '#337: Escalation details : '.json_encode($escData)); 

                if(!empty($escRow) && $escRow != null){
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
            else {
              $rows->escalation_date = 'NA';
              $rows->escalation_zone = 'NA';
            }

            $prop_link = base_url()."index.php/LandReclassification/ApprovedProposals?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;

            $prop_btn = "<a href=".$prop_link.">Proposal No : ".$rows->proposal_no."</a>";

            $submission_date = '<i class="fa fa-calendar"></i>Submitted On '.date('d/m/Y',strtotime($rows->lm_date)).'</p>';

            $link = base_url()."index.php/LandReclassification/ResponseLM?case_no=".$rows->case_no."&proposal_no=".$rows->proposal_no;

            $button = "<a href=".$link." class='btn btn-success'>Proceed</a>"; 

            $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
            $json[] = array(

              $rows->escalation_zone,
              $rows->escalation_date,
              $prop_btn,
              $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
              $rows->dag_no,
              $submission_date,              
              $button
            );
          }
        }

        else {
            $json = "";
        }   
        
        $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
        );
        echo json_encode($response);
      }
      else
      {
          $response = array();
          $response['sEcho']=0;
          $response['iTotalRecords']=0;
          $response['iTotalDisplayRecords']=0;
          $response['aaData']=[];
          echo json_encode($response);
      }
    }

    

}
?>