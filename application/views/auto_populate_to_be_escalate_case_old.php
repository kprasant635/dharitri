<?php 
    // $checkAutoEsc = $this->AutoEscalationmodel->checkIfAutoEscalateTakesPlace();
    // // log_message('error','*****'.json_encode($checkAutoEsc));
    // if($checkAutoEsc == 0) // auto escalation takes place if not done before on that day
    // {
    //   // $status1 = $this->AutoEscalationmodel->autoEscalateToRespectiveOfficer();
    //   // // log_message('error', "Auto Escalation Status ".json_encode($status1)); 
    //   // $this->AutoEscalationmodel->insertAutoEscalateData($status1);
    // } 

    $popUpOfToBeEscalatedList = $this->ToBeAutoEscModel->popUpOfToBeEscalatedList();
    if(!empty($popUpOfToBeEscalatedList) && isset($popUpOfToBeEscalatedList)) { 

      $user_desig_code = $this->session->userdata('user_desig_code') ;
      $user_code       = $this->session->userdata('user_code') ;
?>

  <style type="text/css">

    #table_scroll{
      overflow-x:scroll;
    }

  </style>

  <div class="modal" role="dialog" id="autoPopUpModal" data-backdrop="static" data-keyboard="false" style="z-index:999999">
    <div class="modal-dialog" role="document" style="max-width: 85%;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">To be escalated pending case(s)</h4>
          <h5 class="modal-title" style="color:red; font-weight: bold;">In case, if you don't take action in given remaining days, the case will auto escalate to next superior authority</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: red">Close &times;</span>
        </button>
        </div>

        <div class="modal-body">

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row" id="table_scroll">            

              <table class="datatable table table-stripped" id='toBeEscCase' width="100%">
                <thead>
                  <tr>
                    <th><label class="control-label">Case No</label></th>                
                    <th><label class="control-label">Mouza/Lot</label></th>
                    <th><label class="control-label">Village </label></th>
                    <th><label class="control-label">Submission Date</label></th>                
                    <th><label class="control-label">Remaining Days</label></th>
                    <th><label class="control-label">Zone Detail</label></th>
                    <th><label class="control-label">Escalate Date</label></th>
                  </tr>
                </thead>
                <tbody>  
                  <?php foreach($popUpOfToBeEscalatedList as $row) { 

                    // log_message('error', "#ERR56__Master_table: ".json_encode($popUpOfToBeEscalatedList));

                    // get service type
                    $stype = $this->ToBeAutoEscModel->explodeCaseNo($row->case_no);

                    $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($row->case_no);
                    // log_message('error', 'Rtps No: '.$rtps_no);

                    $res = $this->EscalationListModel->getFromMasterBasicTable($stype, $row->case_no)->row();

                    if($row->service_code == 6 || $row->case_no == 8)
                    {
                      $date_entry = date('M jS, Y',strtotime($res->submission_date));
                    }
                    else
                    {
                      $date_entry = date('M jS, Y',strtotime($res->date_entry));
                    }
                    // log_message('error', "#ERR65__Master_table: ".json_encode($res));

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

                  ?>
                    <tr>
                      <td>
                        <?=$row->case_no?><br><span class='small font-italic red'><?=$rtps_no?></span>
                      </td>
                      <td><?=$mouza_lot?></td>
                      <td><?=$village?></td>
                      <td><?=$date_entry?></td>
                      <td><?=$zone['remain_days']?></td>
                      <td><?=$zone['zone_color'].' '.$zone['escalation_zone']?></td>
                      <td><?=$zone['escalation_date']?></td>
                    </tr>
                  <?php } ?>                
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"> 

    $("#toBeEscCase").dataTable();
    $('#autoPopUpModal').modal('show');

  </script>

<?php } ?>
