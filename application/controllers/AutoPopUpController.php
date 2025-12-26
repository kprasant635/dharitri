<?php
class AutoPopUpController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('ToBeAutoEscModel');        
    $this->load->model('EscalationListModel');
  }

  public function autoPopolatedEscCases()
  {
    $json   = null;
    $draw   = intval($this->input->post('draw'));
    $start  = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order  = $this->input->post('order');

    $popUpOfToBeEscalatedList = $this->ToBeAutoEscModel->getToBeEscalateCasesFromUserPagination($length, $start);
    $result = $this->ToBeAutoEscModel->popUpOfToBeEscalatedList();
    $total_records = count($result);

    if(!empty($popUpOfToBeEscalatedList) && isset($popUpOfToBeEscalatedList))
    { 

      $user_desig_code = $this->session->userdata('user_desig_code');
      $user_code       = $this->session->userdata('user_code');

      foreach($popUpOfToBeEscalatedList as $row) {

        $stype   = $this->ToBeAutoEscModel->explodeCaseNo($row->case_no);
        $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($row->case_no);
        $res     = $this->EscalationListModel->getFromMasterBasicTable($stype, $row->case_no)->row();

        if($row->service_code == 6 || $row->case_no == 8)
        {
          $date_entry = date('M jS, Y',strtotime($res->submission_date));
        }
        else
        {
          $date_entry = date('M jS, Y',strtotime($res->date_entry));
        }  

        if($row->service_code == 5)
        {
          $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $res->circle_code, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $res->circle_code, $res->mouza_pargona_code, $res->lot_no);

          $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $res->circle_code, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);
        }
        else {

          $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code, $res->lot_no);

          $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);
        }                

        // zone detail
        $zone = $this->ToBeAutoEscModel->getEscalationZone($row->case_no, $user_desig_code, $user_code);

        $json[] = array(
          $row->case_no."<br><span class='small font-italic red'>".$rtps_no."</span>",
          $mouza_lot,
          $village,
          $date_entry,
          $zone['remain_days'],
          $zone['zone_color'].' '.$zone['escalation_zone'],
          $zone['escalation_date']
        );
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
      $response                         = array();
      $response['sEcho']                = 0;
      $response['iTotalRecords']        = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData']               = [];
      echo json_encode($response);
    }
  }

}
?>