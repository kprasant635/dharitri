<?php
class ConversionEscalationController extends CI_Controller {

  public function __construct() 
  {
    parent::__construct();
    $this->load->model('Escalationmodel');
    $this->load->model('ConversionEscalationModel');
    $this->load->helper(array('form', 'url'));
  }

  // search of conversion cases for CO
  public function searchByEscalationZoneConversionForCo()
  {
    $user_code      = $this->session->userdata('user_code');
    $dist_code      = $this->session->userdata('dist_code');
    $subdiv_code    = $this->session->userdata('subdiv_code');
    $cir_code       = $this->session->userdata('cir_code');
    $draw           = intval($this->input->post('draw'));
    $searchByCol_0  = $this->input->post('columns')[0]['search']['value'];
    $start          = intval($this->input->post('start'));
    $length         = intval($this->input->post('length'));
    $order          = $this->input->post('order');
    $define_date    = define_date;
    $zone_status    = $this->input->post('zone_status');
    $blockchain_btn = '';

    $results = $this->ConversionEscalationModel->getPendingConversionCasesForCo($dist_code, 
                  $subdiv_code, $cir_code, $start, $length, $order, $define_date, 
                    $searchByCol_0, $zone_status, $user_code);

    // log_message('error', '#3950 == Pending Cases of CO :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          // log_message("error","#3957: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            // log_message('error', '#3960: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              // log_message('error', '#3963: Escalation details : '.json_encode($escData));
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
          
          $case_type = 'Convertion Case';

          $link = base_url() . "index.php/COconversionPartha/FirstProcess?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;
          $basu_case = $rows->basundhara?"<br><span class='small font-italic red'>Basundhara:".$rows->basundhara."</span>":'';          
          $case_detail = "<a href=".$link.">".$rows->case_no.$basu_case."</a>";
          

          $location = '<br>Mouza : '.$this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code).'<br> Lot : '.$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no).'<br> Village : '.$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);

          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y', strtotime($rows->date_entry));

          $write_report_link = base_url()."index.php/COconversionPartha/FirstProcess?case_no=".$rows->case_no."&dist_code=".$rows->dist_code."&subdiv_code=".$rows->subdiv_code."&cir_code=".$rows->cir_code."&mouza_pargona_code=".$rows->mouza_pargona_code."&lot_no=".$rows->lot_no."&vill_townprt_code=".$rows->vill_townprt_code;

          $write_report_btn = "<a href=".$write_report_link." class='btn btn-success btn-block'>Write Report</a>";

          if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){

            $blockchain_btn = "<button type='button' data-toggle='modal' data-target='#myModal' case_no=".$rows->rows_no." dist_code=".$rows->dist_code." subdiv_code=".$rows->subdiv_code." cir_code=".$rows->cir_code." mouza_pargona_code=".$rows->mouza_pargona_code." lot_no=".$rows->lot_no." vill_townprt_code=".$rows->vill_townprt_code." class='chainReport btn-sm btn btn-primary'>View Property Chain</button>";
          }

          $message = 'Escalated to Appellate Authority';

          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $case_detail,
              $case_type.$location,
              $submission_date,
              $rows->is_escalated == 1 ? $message : $write_report_btn,
              $blockchain_btn,
            );
          }
          else {
            $json[] = array(
              $case_detail,
              $case_type.$location,
              $submission_date,
              $write_report_btn,
              $blockchain_btn,
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json
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


  // search of conversion cases for LM
  public function searchByEscalationZoneConversionForLm()
  {
    $user_code      = $this->session->userdata('user_code');
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

    $results = $this->ConversionEscalationModel->getPendingConversionCasesForLm($dist_code, $subdiv_code, 
                $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, 
                  $searchByCol_0, $zone_status, $user_code);

    // log_message('error', '#33 == Pending Cases of LM :'.json_encode($results));
    if(isset($results)){
      $data_rows = $results['data_results'];
      $total_records = $results['total_records'];
      if($total_records > 0){
        $i = 1;
        foreach($data_rows as $rows){
          // log_message("error","#3957: ==========".json_encode($rows));
          if($rows->es_flag == '1' && ESCALATION_ENABLE == 1){
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
            // log_message('error', '#3960: Escalation details : '.json_encode($escRow));
            if(!empty($escRow) && $escRow != null){
              $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));
              // log_message('error', '#3963: Escalation details : '.json_encode($escData));
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
          
          $case_type = 'Convertion Case';

          $link = base_url() . "index.php/LMconversionPartha/case_no=".$rows->case_no;

          $submission_date = '<i class="fa fa-calendar"></i> Submited On '.date('d-m-Y', strtotime($rows->date_entry));

          $basu_case = $rows->basundhara?"<br><span class='small font-italic red'>Basundhara:".$rows->basundhara."</span>":'';          
          $case_detail = "<a href=".$link.">".$rows->case_no.$basu_case."</a>";

          $write_report_btn = "<a href=".$link." class='btn btn-success'>Write Report</a>";

          $message = 'Escalated to Appellate Authority';

          if(ESCALATION_ENABLE == 1) {
            $json[] = array(
              $rows->escalation_zone,
              $rows->escalation_date,
              $case_detail,
              $case_type,
              $submission_date,
              $rows->is_escalated == 1 ? $message : $write_report_btn,
            );
          }
          else {
            $json[] = array(
              $case_detail,
              $case_type.$location,
              $submission_date,
              $write_report_btn,
            );
          }
          $i++;
        }
      }
      else {
          $json = "";
      }
      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json
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