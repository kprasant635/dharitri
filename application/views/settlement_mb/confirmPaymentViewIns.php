<script>
    $(function () {
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });
    })
</script>

<style>
    .custom-table th, td
    {
        padding-left : 8px;
        padding-right : 8px;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1);
    }
</style>

<!-- <form
  action="<?php echo base_url()?>index.php/SettlementMbCo/chithaUpdate"
  method="post"
> -->
<form action="#" method="post"> 

  <input type="hidden" name="total_premium" value="<?=$total_premium?>"> 
  <input type="hidden" name="paid_amount" value="<?=$paid_amount;?>"> 
  <input type="hidden" name="remaining_amount" value="<?=$remaining_amount;?>"> 
  <input type="hidden" name="tenure" value="<?=$tenure;?>"> 
  <input type="hidden" name="installment_amount" value="<?=$installment_amount;?>"> 
  <input type="hidden" name="payment_date" value="<?php if($payment_date){ echo $payment_date;}?>"> 

  <div class="container shadow bg-white">
    <div class="row mb-3">
      <h5 class="p-4 shadow" style="background: #ff681d">
        <span class="text-white p-2">
          <i class="fa fa-hand-o-right" aria-hidden="true"></i>
          Payment confirmation/LRA verification Details for the case no (<?=$case_no;?>)
        </span>
      </h5>

      <?php if ($this->session->flashdata('message')) : ?>
      <div class="alert alert-success">
        <strong><?= $this->session->flashdata('message'); ?></strong>
      </div>
      <?php endif; ?>
    </div>
    <!-- <input type="text" name="case_no" id='case_no' value="<?=$case_no;?>" />
 -->
    <div class="row px-4 justify-content-center">
      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #77bd2b">
          <div class="col-12 text-white">
            <h5>Application Details</h5>
            <small>
              <strong>
                Case No:
                <?=$case_no;?>
              </strong>
            </small>
          </div>
        </div>
        <div class="row bg-white p-3">
          <div class="col-12 text-center">
            <h6>
              APPLICANT APPLICATION NUMBER
              <i class="fa fa-level-down" aria-hidden="true"></i>
            </h6>
            <h5><?=$case_no_rtps;?></h5>
          </div>
        </div>
      </div>

      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Payment Status</h5>
            <small>
              <strong>
                Date of Payment:
                <?=$payment_date;?>
              </strong>
            </small>
            <!-- <a class="btn btn-danger btn-sm ml-2" id="btnCancelPremium">Cancelled Premium Notice</a> -->
          </div>
        </div>

        <div class="row p-3">
          <div class="row">
          <?php
            if(trim($payment_status) == 'y'){
            ?>

              <span><strong>Total Premium Amount : <?=$total_premium?></strong></span><br>
              <span><strong>Amount Paid : <?=$paid_amount." (".$percentage."%)";?></strong></span><br>

              <?php
              if((int)$percentage != 100){
                ?>
                <span><strong>Remaining Amount : <?php if($remaining_amount){ echo $remaining_amount;}?></strong></span><br>
                <span><strong>Tenure : <?php if($tenure){ echo $tenure;}?></strong></span><br>
                <span><strong>Installment Amount : <?php if($installment_amount){ echo $installment_amount;}?></strong></span><br>
              <?php
              }
              ?>
          
            <?php
            }
            ?>
          </div>
          <div class="col-12 text-center">
            <?php
            if(trim($payment_status) == 'y'){
            ?>                          
            <i class="fa fa-check fa-4x text-success" aria-hidden="true"></i>
            <h6>PAYMENT RECEIVED</h6>
            <?php 

            if(!$PaymentFlagConsider)
            {
                echo "<h6 style='color:red'>Payment is not required for allotments related to state government infrastructure projects.</h6>";
            }
            ?>

            <?php
            }else{
            ?>
            <i
              class="fa fa-times-circle-o fa-4x text-danger"
              aria-hidden="true"
            ></i>
            <h6>PAYMENT NOT RECEIVED</h6>

            <!-- ****************Manual Payment Update Section************** -->
            <!-- <br> -->
            <span class="font-weight-bold text-danger">NOTE: </span><span>Please verify challan before updating manual payment</span>
            
            <a href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php" id="verifyPayment" target="verifyChallen" class="btn btn-sm btn-primary">Verify challan</a>

            <br>
            <span class="font-weight-bold text-danger">NOTE: </span><span>If Payment Is Done Manually, Please Update The Details By Clicking The Button</span>
            <br>            
            <button
                id="udpatePayment"
                disabled
                class="btn btn-sm btn-warning" role="button" 
                onclick="updateManualPaymentDetails()">
                <i class="fa fa-edit"></i>
                Update Manual Payment Details
            </button>
            <div id="manualPaymentUpdateModal" class="modal" role="dialog">
                <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
                    <div class="modal-content">
                        <div class="card-header bg-warning text-white text-center h6 p-3">
                            MANUAL PAYMENT DETAILS FOR CASE NO : (<?=$case_no;?>)
                        </div>
                        <div class="card-header bg-secondary text-white text-center h6" style="font-weight:bold">
                            <span>
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                NOTE: PLEASE FILL THE DETAILS FORM THE CHALLAN
                            </span>
                        </div>                        
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4" style="text-align: right;">
                                    <label>GRN-NO</label>
                                </div>
                                <div class="col-lg-6">
                                    <input class="form-control" id='grn_no' name='grn_no'
                                    type="text" placeholder="GRN-NO"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4" style="text-align: right;">
                                    <label>AMOUNT</label>
                                </div>
                                <div class="col-lg-6">
                                    <input class="form-control" id='amount' name='amount'
                                    type="text" placeholder="AMOUNT"/>                            
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4" style="text-align: right;">
                                    <label>PAYMENT-DATE</label>
                                </div>
                                <div class="col-lg-6">
                                    <input class="form-control" id='manual_payment_date' name='manual_payment_date'
                                    type="text" placeholder="PAYMENT-DATE" readonly name='manual_payment_date'/>                            
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4" style="text-align: right;">
                                    <label>UPLOAD-CHALLAN</label>
                                </div>
                                <div class="col-lg-6">
                                    <input class="form-control" id='manual_chalan' name='manual_chalan'
                                    type="file" placeholder="PAYMENT-DATE"/>                            
                                </div>
                            </div>
                        </div>                          
                        <div class="row" align="center" style="align-items: center; margin-bottom: 15px;"> 
                            <hr>
                            <div class="col-lg-12 col-md-12" align="center">
                                <button class="btn btn-success btn-sm" onclick="manualPaymentDetailsSubmitHandle()"><i class="fa fa-check" aria-hidden="true"></i> SUBMIT</button>                            
                                <button class="btn btn-danger btn-sm" onclick="closeManualPaymentUpdateModal()"><i class="fa fa-close"></i> CLOSE</button>                            
                            </div>
                        </div>    
                        <!-- validation-errors-div -->
                        <div class="col-lg-12" id="manual_chalan_update_validation_error_div" style="display:none;margin-top:1rem">
                            <div class="card-header h5 bg-danger text-white text-center">
                                VALIDATION ERRORS
                            </div>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="text-center" style="color:red !important" id="manual_chalan_update_validation_error_msg">
                                </strong>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <style>
                .datepick-popup{
                    z-index: 10000!important;
                    position: fixed;
                    left: 0px;
                    right: 0px;;
                }
            </style>
            <script>
                $(document).ready( function () {        
                    $('#manual_payment_date').datepick({dateFormat: 'yyyy-mm-dd'});
                });
                function updateManualPaymentDetails(){
                    event.preventDefault();
                    const modal = $('#manualPaymentUpdateModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    modal.fadeIn('slow').modal('show');
                }           
                function closeManualPaymentUpdateModal(){
                    event.preventDefault();
                    $('#manualPaymentUpdateModal').fadeOut('slow').modal('hide');
                }   
                function manualPaymentDetailsSubmitHandle(){
                    event.preventDefault();                    
                    var manualChallanForm = new FormData();
                    manualChallanForm.append("manual_chalan", manual_chalan.files[0]);
                    manualChallanForm.append("grn_no", $('#grn_no').val());
                    manualChallanForm.append("amount", $('#amount').val());
                    manualChallanForm.append("payment_date", $('#manual_payment_date').val());
                    manualChallanForm.append("case_no", '<?=$case_no;?>');           
                    $('#manual_chalan_update_validation_error_div').hide();    
                    $('#manual_chalan_update_validation_error_msg').empty();     
                    $.ajax({
                        url: baseurl + "SettlementInstitutionCo/manualPaymentDetailsSubmitHandle",
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: manualChallanForm,
                        contentType: false,
                        cache: false,
                        processData:false,
                        dataType: 'json',
                        beforeSend: function () {
                            $.blockUI({
                                message: $('#displayBox'),
                                css: {
                                    border:'none',
                                    backgroundColor:'transparent'
                                }
                            });
                        },
                        success: function (data) {
                            if(data.result == 'VALIDATION-ERROR'){
                                $.unblockUI();
                                $('#manual_chalan_update_validation_error_div').show();
                                for (let i = 0; i < data.msg.length; i++) {                                    
                                    $('#manual_chalan_update_validation_error_msg').append(data.msg[i]);
                                }
                                return;
                            }else if(data.result == 'FILE-VALIDATION-ERROR'){
                                $.unblockUI();
                                alert(data.msg);
                                return;
                            }else if(data.result == 'SUCCESS'){                                
                                $.unblockUI();
                                alert(data.msg);
                                location.reload();
                            }else{
                                $.unblockUI();
                                alert(data.msg);
                                return;
                            }
                        },
                        error: function (jqXHR, exception) {
                            $.unblockUI();
                            alert('Could not Complete your Request ..!, Please Try Again later..!');
                        }
                    });
                } 
            </script>
            
            <!-- ****************Manual Payment Update Section************** -->

            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!-- LM verification report -->
    <?php if($lraVerificationUsed == true): ?>
    <div class="row">
      <div class="col-md-12 panel panel-body">
              <?php
                if($alm->chitha_processing_details == 0)
                {
                  ?>
                    <h3 class="alert-danger">Final verification approval check is pending at LRA!</h3>
                  <?php
                }
                elseif($alm->chitha_processing_details == 1)
                {
                  ?>

                  <h3 class="pl-2 mt-2 text-danger text-shadow">#LRA Verfication Report</h3>

                  <?php
                    if($nomTrans != false)
                    {
                      ?>
                      <!-- <h5 class="text-center"><u>Nominee Details</u></h5> -->

                      <table class="table table-bordered">
                        <tr>
                          <th class="text-center bg-info" colspan="6">Nominee Details</th>
                        </tr>
                        <tr>
                          <th>SL</th>
                          <th>Nominee name</th>
                          <th>Relation with Nominee</th>
                          <th>Address of Nominee</th>
                          <th>Mobile number</th>
                          <th>Request for</th>
                        </tr>
                      <?php 
                        $sl_no = 1;
                        foreach($nomTrans as $nom)
                        {
                          ?>
                           <tr>
                              <td><?=$sl_no++?></td>
                              <td><?=$nom->nominee_name?></td>
                              <td><?=$this->utilityclass->getrelationByID($nom->relation)?></td>
                              <td><?=$nom->address?></td>
                              <td><?=$nom->mobile_no?></td>
                              <td><?php if($nom->delete_id != 0){echo '<span class="alert-danger"><b>DELETE</b></span>';}else{echo '<span class="alert-warning"><b>ADD</b></span>';} ?></td>
                            </tr>
                          <?php
                        }
                        ?>
                      </table>

                    <?php
                    }
                  ?>
                  <!-- <h5 class="text-center"><u>Dag Related Details</u></h5> -->
                  <table class="table table-bordered mt-1">

                    <?php

                      if($dagDetails)
                      {
                        foreach($dagDetails as $dagRow)
                        {
                          ?>
                          <tr>
                            <th class="text-center bg-info" colspan="2">Dag Related Details DAG NO : <?=$dagRow->dag_no?></th>
                          </tr>
                          <!-- <tr>
                            <th>Proposed Patta Type </th>
                            <td><?=$this->utilityclass->getPattaNameUpdated($dagRow->new_patta_type_code)?></td>
                          </tr> -->
                          
                          <tr>
                            <th>Possession from </th>
                            <td><?=$dagRow->new_possession_from?></td>
                          </tr>

                          <tr>
                            <th>Land Purpose </th>
                            <td><?=$dagRow->land_purpose?></td>
                          </tr>

                          <tr>
                            <th>Final Settlement Area </th>
                            <td><?=$dagRow->final_settlement_area?></td>
                          </tr>
                          <?php 
                          if($dagRow->road_side_reservation != false)
                          {
                            ?>
                              <tr>
                                <th>Reservation Area </th>
                                <td><?=$dagRow->road_side_reservation?></td>
                              </tr>
                            <?php
                          }                         
                          ?>
                          <tr>
                            <th>Existing land type (As per Chitha Record) </th>
                            <td><?php if($dagRow->new_existing_land_type)
                            {
                                foreach (LAND_TYPES as $key => $value) {
                                    if($value['id'] == $dagRow->new_existing_land_type)
                                    {
                                        echo $value['name'];
                                    }
                                }

                            }?></td>
                          </tr>
                          <tr>
                            <th>Proposed Landclass for Project/Infrastructure </th>
                            <td><?php if($dagRow->new_landclass_home){echo $this->utilityclass->getLandClassCodeNew($dagRow->new_landclass_home);}?></td>
                          </tr>

                          <tr>
                            <th>Land Revenue </th>
                            <td><?=$dagRow->newHomeRevenue?></td>
                          </tr>
                          <tr>
                            <th>Local Tax </th>
                            <td><?=$dagRow->newHomeLocalTax?></td>
                          </tr>

                          <!-- <tr>
                            <th>Proposed Landclass for Agriculture </th>
                            <td><?php if($dagRow->new_landclass_agri){echo $this->utilityclass->getLandClassCode($dagRow->new_landclass_agri);}?></td>
                          </tr> -->

                          <!-- <tr>
                            <th>Agriculture Land Revenue </th>
                            <td><?=$dagRow->newAgriRevenue?></td>
                          </tr>
                          <tr>
                            <th>Agriculture Local Tax </th>
                            <td><?=$dagRow->newAgrilocalTax?></td>
                          </tr> -->

                          <tr>
                            <th colspan="2" class="text-center ">
                              Landmark
                            </th>
                          </tr>
                          <tr>
                            <th>EAST:</th>
                            <td><?=$dagRow->new_landmark->east?></td>
                          </tr>

                          <tr>
                            <th>WEST:</th>
                            <td><?=$dagRow->new_landmark->west?></td>
                          </tr>

                          <tr>
                            <th>NORTH:</th>
                            <td><?=$dagRow->new_landmark->north?></td>
                          </tr>

                          <tr>
                            <th>SOUTH:</th>
                            <td><?=$dagRow->new_landmark->south?></td>
                          </tr>

                        <?php
                        }
                      }
                    ?>
                  </table>
                  <?php
                }
                elseif($alm->chitha_processing_details == 2)
                {
                    ?>
                    <h3 class="pl-2 mt-2 text-shadow text-success">#LRA Verfication Report(Approved)
                        <?php
                        if($alm->order_passed == null OR strtoupper(trim($alm->order_passed)) != 'Y'){
                            ?>

                            <!-- <button type="button" class="btn btn-warning btn-sm" onclick="editPattaType('<?=$alm->case_no?>')">Edit Patta Type</button> -->

                        <?php }?>

                        <?php
                        if($update_land_class == true){
                            ?>
                                <!-- <button type="button" class="btn btn-warning btn-sm" onclick="updateLandClass('<?=$alm->case_no?>')">Update land class</button> -->
                            <?php
                        }
                        
                        ?>
                    </h3>

                    
                  <!-- <h5 class="text-center"><u>Dag Related Details</u></h5> -->
                  <table class="table table-bordered mt-1">

                    <?php
                      if($dagDetails)
                      {
                        foreach($dagDetails as $dagRow)
                        {
                          ?>
                          <tr>
                            <th class="text-center bg-info" colspan="2">Dag Related Details DAG NO : <?=$dagRow->dag_no?></th>
                          </tr>
                          <!-- <tr>
                            <th>Proposed Patta Type </th>
                            <td><?=$this->utilityclass->getPattaNameUpdated($dagRow->new_patta_type)?></td>
                          </tr> -->
                          <tr>
                            <th>Land Purpose </th>
                            <td><?=$land_purpose_allot_co;?></td>
                          </tr>
                          
                          <tr>
                            <th>Possession from </th>
                            <td><?=$dagRow->new_possession?></td>
                          </tr>
                          
                          <tr>
                            <th>Final Settlement Area </th>
                            <td><?=$dagRow->final_settlement_area?></td>
                          </tr>
                          <?php 
                          if($dagRow->road_side_reservation != false)
                          {
                            ?>
                              <tr>
                                <th>Reservation Area </th>
                                <td><?=$dagRow->road_side_reservation?></td>
                              </tr>
                            <?php
                          }                         
                          ?>

                          <tr>
                            <th>Existing land type (As per Chitha Record) </th>
                            <td><?php if($dagRow->new_existing_land_type)
                            {
                                foreach (LAND_TYPES as $key => $value) {
                                    if($value['id'] == $dagRow->new_existing_land_type)
                                    {
                                        echo $value['name'];
                                    }
                                }

                            }?></td>
                          </tr>

                          <tr>
                            <th>Proposed Landclass for Project/Infrastructure </th>
                            <td><?php if($dagRow->new_land_class_home){echo $this->utilityclass->getLandClassCodeNew($dagRow->new_land_class_home);}?></td>
                          </tr>

                          <tr>
                            <th>Land Revenue </th>
                            <td><?=$dagRow->new_home_land_revenue?></td>
                          </tr>
                          <tr>
                            <th>Local Tax </th>
                            <td><?=$dagRow->new_home_land_local_tax?></td>
                          </tr>

                          <!-- <tr>
                            <th>Proposed Landclass for Agriculture </th>
                            <td><?php if($dagRow->new_land_class_agri){echo $this->utilityclass->getLandClassCodeNew($dagRow->new_land_class_agri);}?></td>
                          </tr>

                          <tr>
                            <th>Agriculture Land Revenue </th>
                            <td><?=$dagRow->new_agri_land_revenue?></td>
                          </tr>
                          <tr>
                            <th>Agriculture Local Tax </th>
                            <td><?=$dagRow->new_agri_land_local_tax?></td>
                          </tr> -->

                          <tr>
                            <th colspan="2" class="text-center ">
                              Landmark
                            </th>
                          </tr>
                          <tr>
                            <th>EAST:</th>
                            <td><?=$dagRow->landmark->east?></td>
                          </tr>

                          <tr>
                            <th>WEST:</th>
                            <td><?=$dagRow->landmark->west?></td>
                          </tr>

                          <tr>
                            <th>NORTH:</th>
                            <td><?=$dagRow->landmark->north?></td>
                          </tr>

                          <tr>
                            <th>SOUTH:</th>
                            <td><?=$dagRow->landmark->south?></td>
                          </tr>

                        <?php
                        }
                      }
                    ?>
                  </table>


                  <?php
                }
              ?>


              <?php
                if($alm->chitha_processing_details == 1)
                {
                ?>
                  <h4 class="text-center mt-2">
                    <button type="button" onclick="finalVerificationModal('<?=$alm->case_no?>');" class="btn btn-sm btn-warning"><b>Edit Verification Report</b></button>
                    <button type="button" onclick="finalApprove('<?=$alm->case_no?>')" class="btn btn-sm btn-success"><b>Approve Report</b></button>
                  </h4>
                <?php
                }
                else if($alm->chitha_processing_details == 2)
                {
                  ?>
                    <h4 class="text-center mt-2">
                      <span class="alert-success"><b>APPROVED</b></span>
                    </h4>

                  <?php
                }
              ?>

          
      </div>
    </div>
    <?php endif; ?>
  



  </div>
</form>

<div class="modal" role="dialog" id="verifyReportModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="approvalForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Please Enter the following details</h5>
                </div>
                <div class="modal-body" align="center">
                  <div id="nomHead">

                  </div>

                  <div id="tableNomineeExt">

                  </div>
                  <div id="tableNominee">

                  </div>

                  <div id="tableAppend">

                  </div>
                  <div id="tableAppendLandPurpose">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  id="verifyReportModalNo">CANCEL</button>
                    <button type="submit" class="btn btn-primary"   id="verifyReportModalYes">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
</script>
<style>
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 80%;
            margin: 1.75rem auto;
        }
    }
</style>

<script>

    $(document).on('click','#verifyReportModalNo',function ()
    {
        $('#verifyReportModal').modal('hide');
    });
   
    function finalVerificationModal(case_no)
    {
        $('#nomHead').html('');
        $('#tableNomineeExt').html('');
        $('#tableNominee').html('');
        $('#tableAppend').html('');
        $('#tableAppendLandPurpose').html('');

        $('#verifyReportModal').modal('show');

        var postData = {
            'case_no': case_no
        };
        
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementInstitutionCo/getFinalVerificationData',
            type: "POST",
            data: postData,
            success: function(data) 
            {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType == 0)
                {
                    $('#verifyReportModal').modal('hide');
                    showErrorMessage(arr.msg);
                    return false;
                }

                //****nominee details */
                // var headH = '<tr>'+
                //                 '<th class="text-center" colspan="5">Family Details &nbsp; &nbsp;  <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add member</button>'+
                //                             '</th>'+
                //             '</tr>';
                var headH = '';

                $('#nomHead').html(headH);

                if(arr.nominee != false)
                {
                    var nomHead = '<tr>'+
                            '<th>Nominee name</th>'+
                            '<th>Relation with Nominee</th>'+
                            '<th>Address of Nominee</th>'+
                            '<th>Mobile number</th>'+
                            '<th>Action</th>'+
                        '</tr>';

                    var trNom = '';

                    //****already existing nominee */
                    for(i=0; i<arr.nominee.length; i++)
                    {
                        trNom +=  '<tr>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].nominee_name+'" class="form-control"></td>'+
                                    '<td>'+
                                    '<input type="text" readonly name="kin_name" value="'+arr.nominee[i].relation_decoded+'" class="form-control">'+
                                    '<input type="hidden" readonly name="kin_name" value="'+arr.nominee[i].relation+'" class="form-control">'+
                                    '</td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].address+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].mobile_no+'" class="form-control"></td>'+

                                    '<td>'+
                                        '<button type="button" onclick="confirmDeleteFamily('+arr.nominee[i].id+');" class="btn btn-sm btn-danger">Delete</button>'+
                                    '</td>'+
                            '</tr>'; 
                    }

                    $('#tableNomineeExt').html('<table class="table">'+nomHead+trNom+'</table>');
                }
                // else
                // {
                ////******added nonimees */
                if(arr.transactionNom != false)
                {
                    var nomHead = '<tr>'+
                            '<th>Nominee name</th>'+
                            '<th>Relation with Nominee</th>'+
                            '<th>Address of Nominee</th>'+
                            '<th>Mobile number</th>'+
                            '<th>Action</th>'+
                        '</tr>';

                    var trNom = '';

                    var tr_color = '';
                    var famDel = '';
                    
                    for(i=0; i<arr.transactionNom.length; i++)
                    {
                        if(arr.transactionNom[i].delete_id != 0)
                        {
                            tr_color =  '<tr style="background:#FFBBBB">';
                            famDel = '<button type="button" onclick="confirmDeleteFamilyLmInserted('+arr.transactionNom[i].id+');" class="btn btn-sm btn-danger">Remove</button>';
                        }
                        else
                        {
                            tr_color =  '<tr style="background:#A8FFA8">';
                            famDel = '<button type="button" onclick="confirmDeleteFamilyLmInserted('+arr.transactionNom[i].id+');" class="btn btn-sm btn-danger">Remove</button>';
                        }

                        trNom +=  tr_color+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].nominee_name+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly value="'+arr.transactionNom[i].relation_decoded+'" class="form-control">'+
                                    '<input type="hidden" readonly name="kin_name" value="'+arr.transactionNom[i].relation+'" class="form-control">'+
                                    '</td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].address+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].mobile_no+'" class="form-control"></td>'+

                                    '<td>'+
                                        famDel +
                                    '</td>'+
                            '</tr>'; 
                    }

                    $('#tableNominee').html('<table class="table">'+nomHead+trNom+'</table>');

                }
                // else
                // {
                //     // $('#tableNominee').html('<table class="table">'+headH+'</table>');
                // }

                // }

                //******dag related details */
                var tr = '';
                var trIns = ''; 

                tr += '<input id="user_dist_code" type="hidden" value="'+arr.user_data.user_dist_code+'">'+
                            '<input id="user_subdiv_code" type="hidden" value="'+arr.user_data.user_subdiv_code+'">'+
                            '<input id="user_cir_code" type="hidden" value="'+arr.user_data.user_cir_code+'">'+
                            '<input id="user_mouza_pargona_code" type="hidden" value="'+arr.user_data.user_mouza_pargona_code+'">'+
                            '<input id="user_lot_no" type="hidden" value="'+arr.user_data.user_lot_no+'">'+
                            '<input id="case_no_id" name="case_no" type="hidden" value="'+case_no+'">'+
                            '<input id="chitha_processing_details" type="hidden" value="'+arr.basicRow.chitha_processing_details+'">';
  
                
                // var clickCount = 1;
                for(i=0; i<arr.dagResult.length; i++)
                {

                    tr += '<input id="landmark_dist_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dist_east+'">'+
                            '<input id="landmark_subdiv_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_subdiv_east+'">'+
                            '<input id="landmark_cir_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_cir_east+'">'+
                            '<input id="landmark_mouza_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_mouza_east+'">'+
                            '<input id="landmark_lot_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_lot_east+'">'+
                            '<input id="landmark_village_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_village_east+'">'+
                            '<input id="landmark_dag_ent_east'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dag_east+'">'+

                            '<input id="landmark_dist_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dist_west+'">'+
                            '<input id="landmark_subdiv_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_subdiv_west+'">'+
                            '<input id="landmark_cir_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_cir_west+'">'+
                            '<input id="landmark_mouza_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_mouza_west+'">'+
                            '<input id="landmark_lot_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_lot_west+'">'+
                            '<input id="landmark_village_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_village_west+'">'+
                            '<input id="landmark_dag_ent_west'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dag_west+'">'+
                            
                            '<input id="landmark_dist_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dist_north+'">'+
                            '<input id="landmark_subdiv_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_subdiv_north+'">'+
                            '<input id="landmark_cir_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_cir_north+'">'+
                            '<input id="landmark_mouza_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_mouza_north+'">'+
                            '<input id="landmark_lot_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_lot_north+'">'+
                            '<input id="landmark_village_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_village_north+'">'+
                            '<input id="landmark_dag_ent_north'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dag_north+'">'+
                            
                            '<input id="landmark_dist_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dist_south+'">'+
                            '<input id="landmark_subdiv_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_subdiv_south+'">'+
                            '<input id="landmark_cir_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_cir_south+'">'+
                            '<input id="landmark_mouza_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_mouza_south+'">'+
                            '<input id="landmark_lot_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_lot_south+'">'+
                            '<input id="landmark_village_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_village_south+'">'+
                            '<input id="landmark_dag_ent_south'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].landmark_dag_south+'">'+


                            '<input id="new_inserted_landclass_home'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].new_inserted_landclass_home+'">'+
                            '<input id="new_inserted_landclass_agri'+arr.dagResult[i].dag_no+'" type="hidden" value="'+arr.dagResult[i].new_inserted_landclass_agri+'">';



                    var dist_option = ''
                    var dist_option_east = '';
                    var dist_option_west = '';
                    var dist_option_north = '';
                    var dist_option_south = '';

                    for(k=0; k<arr.dist_array.length; k++)
                    {

                        if(arr.basicRow.chitha_processing_details == 1)
                        {

                            if(arr.dagResult[i].landmark_dist_east == arr.dist_array[k].dist_code)
                            {
                                dist_option_east += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                            }
                            else
                            {
                                dist_option_east += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                            }
                            
                            if(arr.dagResult[i].landmark_dist_west == arr.dist_array[k].dist_code)
                            {
                                dist_option_west += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                            }
                            else
                            {
                                dist_option_west += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                            }
                            
                            if(arr.dagResult[i].landmark_dist_north == arr.dist_array[k].dist_code)
                            {
                                dist_option_north += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                            }
                            else
                            {
                                dist_option_north += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                            }
                            
                            if(arr.dagResult[i].landmark_dist_south == arr.dist_array[k].dist_code)
                            {
                                dist_option_south += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                            }
                            else
                            {
                                dist_option_south += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                            }
                        }
                        else if(arr.basicRow.chitha_processing_details == 0)
                        {
                            if(arr.user_data.user_dist_code == arr.dist_array[k].dist_code)
                            {
                                dist_option += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                            }
                            else
                            {
                                dist_option += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                            }
                        }
                    }


                    var optionHome = '';
                    var optionAgri = '';
                    for(j=0; j<arr.land_class_code.length; j++)
                    {
                        class_code = arr.land_class_code[j].id;
                        land_type = arr.land_class_code[j].name;

                        if(arr.basicRow.chitha_processing_details == 1)
                        {

                            //****for homestead */
                            // if(arr.land_class_code[j].class_code_cat == '02')
                            // {

                                if(arr.dagResult[i].landTypeFinal == 1 || arr.dagResult[i].landTypeFinal == 3)
                                {
                                    if(arr.dagResult[i].new_inserted_landclass_home == class_code)
                                    {
                                        optionHome += '<option value="'+class_code+'" selected>'+land_type+'</option>';
                                    }
                                    else
                                    {
                                        optionHome += '<option value="'+class_code+'">'+land_type+'</option>';
                                    }  
                                }
                                else
                                {
                                    optionHome += '';
                                } 
                            // }

                            //****for agriculture */
                            // if(arr.land_class_code[j].class_code_cat == '01')
                            // {

                            //     if(arr.dagResult[i].landTypeFinal == 2 || arr.dagResult[i].landTypeFinal == 3)
                            //     {
                            //         if(arr.dagResult[i].new_inserted_landclass_agri == class_code)
                            //         {
                            //             optionAgri += '<option value="'+class_code+'" selected>'+land_type+'</option>';
                            //         }
                            //         else
                            //         {
                            //             optionAgri += '<option value="'+class_code+'">'+land_type+'</option>';
                            //         }
                            //     }
                            //     else
                            //     {
                            //         optionAgri += '';
                            //     }
                               
                            // }

                        }

                    }
                    
                    tr += '<th class="text-center bg-info" colspan="4"><strong>Dag No: '+arr.dagResult[i].dag_no+' :::: Old Land Class: '+arr.dagResult[i].old_class_name+'</strong></th>';

                    var roadside_reservation = '';

                    if(arr.dagResult[i].road_side_reservation != false)
                    {
                        roadside_reservation = '<th>Reservation Area</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].road_side_reservation+'" class="form-control"></td>';
                    }

                    tr += '<tr>'+
                                '<th>Final Settlement Area</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].final_settlement_area+'" class="form-control"></td>'+
                           '</tr>';

                    tr += roadside_reservation;

                    tr += '<tr>'+
                                '<th>Landmark Entered</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].landmark_entered+'" class="form-control"></td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select East side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_east'+arr.dagResult[i].dag_no+'" id="landmark_dist_east'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option_east+
                                    '</select>'+
                                    '<select name="landmark_subdiv_east'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_east'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_east'+arr.dagResult[i].dag_no+'" id="landmark_cir_east'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_east'+arr.dagResult[i].dag_no+'" id="landmark_mouza_east'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_east'+arr.dagResult[i].dag_no+'" id="landmark_lot_east'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_east'+arr.dagResult[i].dag_no+'" id="landmark_village_east'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_east'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_east'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select West side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_west'+arr.dagResult[i].dag_no+'" id="landmark_dist_west'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                      dist_option_west+
                                    '</select>'+
                                    '<select name="landmark_subdiv_west'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_west'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_west'+arr.dagResult[i].dag_no+'" id="landmark_cir_west'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_west'+arr.dagResult[i].dag_no+'" id="landmark_mouza_west'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_west'+arr.dagResult[i].dag_no+'" id="landmark_lot_west'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_west'+arr.dagResult[i].dag_no+'" id="landmark_village_west'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_west'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_west'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select North side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_north'+arr.dagResult[i].dag_no+'" id="landmark_dist_north'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                      dist_option_north+
                                    '</select>'+
                                    '<select name="landmark_subdiv_north'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_north'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_north'+arr.dagResult[i].dag_no+'" id="landmark_cir_north'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_north'+arr.dagResult[i].dag_no+'" id="landmark_mouza_north'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_north'+arr.dagResult[i].dag_no+'" id="landmark_lot_north'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_north'+arr.dagResult[i].dag_no+'" id="landmark_village_north'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_north'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_north'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select South side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_south'+arr.dagResult[i].dag_no+'" id="landmark_dist_south'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option_south+
                                    '</select>'+
                                    '<select name="landmark_subdiv_south'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_south'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'south\','+arr.dagResult[i].dag_no+');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_south'+arr.dagResult[i].dag_no+'" id="landmark_cir_south'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_south'+arr.dagResult[i].dag_no+'" id="landmark_mouza_south'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_south'+arr.dagResult[i].dag_no+'" id="landmark_lot_south'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_south'+arr.dagResult[i].dag_no+'" id="landmark_village_south'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_south'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_south'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    
                           var landClassRevHome = '';
                           
                           if(arr.dagResult[i].new_home_land_revenue != false)
                            {
                                landClassRevHome = '<input type="number" id="revenue_home'+arr.dagResult[i].old_dag+'" name="revenue_home'+arr.dagResult[i].dag_no+'" value="'+arr.dagResult[i].new_home_land_revenue+'" placeholder="Enter Revenue" class="form-control">';
                            }
                            else
                            {
                                landClassRevHome = '<input type="number" id="revenue_home'+arr.dagResult[i].old_dag+'" name="revenue_home'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control">';
                            }

                            var landClassLocalTaxHome = '';

                            if(arr.dagResult[i].new_home_land_local_tax != false)
                            {
                                landClassLocalTaxHome = '<input type="number" name="local_tax_home'+arr.dagResult[i].dag_no+'" id="local_tax_home'+arr.dagResult[i].old_dag+'" value="'+arr.dagResult[i].new_home_land_local_tax+'" placeholder="Enter Local Tax" class="form-control">'
                            }
                            else
                            {
                                landClassLocalTaxHome = '<input type="number" name="local_tax_home'+arr.dagResult[i].dag_no+'" id="local_tax_home'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control">'
                            }

                            var landClassRevAgri = '';

                            if(arr.dagResult[i].new_agri_land_revenue != false)
                            {
                                landClassRevAgri = '<input type="number" id="revenue_agri'+arr.dagResult[i].dag_no+'" name="revenue_agri'+arr.dagResult[i].dag_no+'" value="'+arr.dagResult[i].new_agri_land_revenue+'" placeholder="Enter Revenue" class="form-control">'
                            }
                            else
                            {
                                landClassRevAgri = '<input type="number" id="revenue_agri'+arr.dagResult[i].dag_no+'" name="revenue_agri'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control">'
                            }

                            var landClassLocalTaxAgri = ''

                            if(arr.dagResult[i].new_agri_land_local_tax != false)
                            {
                                landClassLocalTaxAgri = '<input type="number" name="local_tax_agri'+arr.dagResult[i].dag_no+'" id="local_tax_agri'+arr.dagResult[i].dag_no+'" value="'+arr.dagResult[i].new_agri_land_local_tax+'" placeholder="Enter Local Tax" class="form-control">'
                            }
                            else
                            {
                                landClassLocalTaxAgri = '<input type="number" name="local_tax_agri'+arr.dagResult[i].dag_no+'" id="local_tax_agri'+arr.dagResult[i].dag_no+'" placeholder="Enter Local Tax" class="form-control">'
                            }

                            var land_type_existing = '';
             
                            for(k=0; k<arr.land_type_existing.length; k++)
                            {
                                var selected1 = '';
                                if(arr.dagResult[i].existing_land_type == arr.land_type_existing[k].id)
                                {
                                    selected1 = "selected";
                                }
                                land_type_existing += '<option value="'+arr.land_type_existing[k].id+'" '+ selected1+'>'+arr.land_type_existing[k].name+'</option>';
                            }

                            tr += '<tr><th colspan="4" style="color:#e90909;text-align:center;font-size:18px">'+arr.dagResult[i].old_class_name+
                                    'Update the land class/type information as per the existing classification in the Chitha. </th></tr>';

                    
                           tr += '<tr>'+

                                '<th>'+
                                        '<label>Land Type</label>  '+
                                        '<select class="form-control" name="existing_land_type'+arr.dagResult[i].dag_no+'"  id="existing_land_type'+arr.dagResult[i].old_dag+'">'+
                                            '<option value="">Select land type...</option>'+
                                            land_type_existing+
                                        '</select>'+
                                    '</th>'+

                                '<th >'+
                                    '<label>Proposed land type</label> '+
                                    '<select name="land_class_code_homestead'+arr.dagResult[i].dag_no+'" class="form-control"  id="land_class_code_homestead'+arr.dagResult[i].old_dag+'">'+
                                        '<option value="">Select land class...</option>'+
                                          optionHome+
                                    '</select>'+
                                '</th>'+

                                '<th>'+
                                    '<label>Revenue</label>'+ 
                                    landClassRevHome+
                                '</th>'+

                                '<th>'+
                                    '<label>Local Tax</label>'+
                                    landClassLocalTaxHome+
                                '</th>'+

                            '</tr>';


                           //  '<tr>'+
                           //      '<th colspan="2">'+
                           //          '<label>New land Class Agriculture</label>'+
                           //          '<select name="land_class_code_agriculture'+arr.dagResult[i].dag_no+'" class="form-control" onchange="getRevenueAgri(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_agriculture'+arr.dagResult[i].old_dag+'">'+
                           //              '<option value="">Select land class...</option>'+
                           //                optionAgri+
                           //          '</select>'+
                           //      '</th>'+

                           //      '<th>'+
                           //          '<label>Revenue</label>'+ 
                           //          landClassRevAgri+
                           //      '</th>'+

                           //      '<th>'+
                           //          '<label>Local Tax</label>'+ 
                           //          landClassLocalTaxAgri+
                           //      '</th>'+

                           // '</tr>';

                    // clickCount++;

                }

                // tr +='<input type="hidden" id="clickCount_id" value="'+clickCount+'">';

                var patta_option = '';
                for(i=0; i<arr.patta_details.length; i++)
                {
                    if(arr.basicRow.chitha_processing_details == 1)
                    {
                        if(arr.basicRow.new_inserted_patta_type_code == arr.patta_details[i].id)
                        {
                            patta_option += '<option value="'+arr.patta_details[i].id+'" selected>'+arr.patta_details[i].name+'</option>';

                        }
                        else
                        {
                            patta_option += '<option value="'+arr.patta_details[i].id+'">'+arr.patta_details[i].name+'</option>';

                        }
                    }
                }
                

                var possession = '';
           
                if(arr.basicRow.chitha_processing_details == 1)
                {
                    possession = '<input type="date" name="possession_from" value="'+arr.basicRow.new_inserted_possession_from+'" class="form-control" placeholder="Enter possession from...">';
                }
                else
                {
                    possession = '<input type="date" name="possession_from" class="form-control" placeholder="Enter possession from...">';
                }


                tr +=  '<tr>'+
                              '<th colspan="4" class="bg-info"></th>'+
                        '</tr>'+
                        '<tr>'+
                                // '<th>Enter Patta Type</th>'+
                                // '<td>'+
                                //     '<select name="new_patta_type" class="form-control">'+
                                //         '<option value="">Select Patta Type...</option>'+
                                //         patta_option+
                                //     '</select>'+
                                // '</td>'+
                                '<th>Possession From</th>'+
                                '<td>'+
                                  possession+
                                '</td>'+
                           '</tr>';

                $('#tableAppend').html('<table class="table">'+tr+'</table>');

                var land_purpose = '';
                

                var land_purpose = '';
            
                for(i=0; i<arr.land_purpose.length; i++)
                {
                    var selected = '';
                    if(arr.basicRow.land_purpose == arr.land_purpose[i].id)
                    {
                        selected = "selected";
                    }
                    land_purpose += '<option value="'+arr.land_purpose[i].id+'" '+ selected+'>'+arr.land_purpose[i].category_name+'</option>';
                }


                var other_land_purpose = '';
            

                for(i=0; i<arr.other_land_purpose.length; i++)
                {
                    var selected = '';
                    if(arr.basicRow.other_land_purpose == arr.other_land_purpose[i].id)
                    {
                        selected = "selected";
                    }
                    other_land_purpose += '<option value="'+arr.other_land_purpose[i].id+'" '+ selected+'>'+arr.other_land_purpose[i].category_name+'</option>';
                }

                trIns +=  '<tr>'+
                            '<th colspan="5" class="bg-info">Land Purpose Information </th>'+
                        '</tr>'+
                
                            '<tr>'+
                                '<th>Enter Land Purpose</th>'+
                                '<td>'+
                                    '<select name="land_purpose" class="form-select">'+
                                        '<option value="">Select Land Purpose...</option>'+
                                        land_purpose+
                                    '</select>'+
                                '</td>'+
                                '<th>Other Details</th>'+
                                '<td>'+
                                    '<select name="other_details" class="form-select">'+
                                            '<option value="">Other Land Purpose...</option>'+
                                            other_land_purpose+
                                    '</select>'+
                                    
                                '</td>'+
                           '</tr>';

                $('#tableAppendLandPurpose').html('<table class="table">'+trIns+'</table>');

                for(i=0; i<arr.dagResult.length; i++)
                {
                    landmark_dist('east', arr.dagResult[i].dag_no);
                    landmark_dist('west', arr.dagResult[i].dag_no);
                    landmark_dist('north', arr.dagResult[i].dag_no);
                    landmark_dist('south', arr.dagResult[i].dag_no);
                }
            }

        });


    }
</script>


<script>

    function landmark_dist(side, dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();

        var user_subdiv_code = $('#user_subdiv_code').val();

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();


        $.ajax({
            url: baseurl + "SettlementMbLm/getSubdiv/" + district,
            success: function(data) {
                var arrdata = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Subdivision --</option>";
                for (var i = 0; i < arrdata.length; i++) 
                {
                    if(chitha_processing_details == 1)
                    {
                        if(landmark_subdiv_ent == arrdata[i].subdiv_code)
                        {
                            template +=
                                '<option value="'+arrdata[i].subdiv_code+'" selected>'+
                                    arrdata[i].loc_name +' (' +arrdata[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                arrdata[i].subdiv_code +
                                "'>" +
                                arrdata[i].loc_name +
                                " (" +
                                arrdata[i].locname_eng +
                                ")</option>";
                        }
                    }
                    else
                    {
                        if(user_subdiv_code == arrdata[i].subdiv_code)
                        {
                            template +=
                                '<option value="'+arrdata[i].subdiv_code+'" selected>'+
                                    arrdata[i].loc_name +' (' +arrdata[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                arrdata[i].subdiv_code +
                                "'>" +
                                arrdata[i].loc_name +
                                " (" +
                                arrdata[i].locname_eng +
                                ")</option>";
                        }
                    }

                  

                }
                $("#landmark_subdiv_"+side+dag_no).html(template);

                landmark_subdiv(side, dag_no);

            },
            error: function(error) {
            },
        });

    };

    function landmark_subdiv(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();

        var user_cir_code = $('#user_cir_code').val();

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();

        $.ajax({
            url: baseurl + "SettlementMbLm/getCircle/" + district+ "/"+ subdiv,
            success: function(data) {
                var Circle = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Circle --</option>";
                for (var i = 0; i < Circle.length; i++) 
                {

                  if(chitha_processing_details == 1)
                  {
                      if(landmark_cir_ent == Circle[i].cir_code)
                      {
                          template +=
                              '<option value="'+Circle[i].cir_code+'" selected>'+
                                  Circle[i].loc_name +' (' +Circle[i].locname_eng +')'+
                              "</option>";
                      }
                      else
                      {
                          template +=
                              "<option value='" +
                              Circle[i].cir_code +
                              "'>" +
                              Circle[i].loc_name +
                              " (" +
                              Circle[i].locname_eng +
                              ")</option>";
                      }
                  }
                  else
                  {
                      if(user_cir_code == Circle[i].cir_code)
                      {
                          template +=
                              '<option value="'+Circle[i].cir_code+'" selected>'+
                                  Circle[i].loc_name +' (' +Circle[i].locname_eng +')'+
                              "</option>";
                      }
                      else
                      {
                          template +=
                              "<option value='" +
                              Circle[i].cir_code +
                              "'>" +
                              Circle[i].loc_name +
                              " (" +
                              Circle[i].locname_eng +
                              ")</option>";
                      }
                  }

                   
                }
                $("#landmark_cir_"+side+dag_no).html(template);
                
                landmark_cir(side, dag_no);
            },
            error: function(error) {
            },
        });

    };

    function landmark_cir(side, dag_no) 
    {

        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val();

        var user_mouza_pargona_code = $('#user_mouza_pargona_code').val();

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();

        $.ajax({
            url: baseurl + "SettlementMbLm/getMouza/" + district+ "/"+ subdiv+"/"+ cir,
            success: function(data) {
                var Mouza = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Mouza --</option>";
                for (var i = 0; i < Mouza.length; i++) 
                {

                    if(chitha_processing_details == 1)
                    {
                        if(landmark_mouza_ent == Mouza[i].mouza_pargona_code)
                        {
                            template +=
                                '<option value="'+Mouza[i].mouza_pargona_code+'" selected>'+
                                    Mouza[i].loc_name +' (' +Mouza[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                Mouza[i].mouza_pargona_code +
                                "'>" +
                                Mouza[i].loc_name +
                                " (" +
                                Mouza[i].locname_eng +
                                ")</option>";
                        }
                    }
                    else
                    {
                        if(user_mouza_pargona_code == Mouza[i].mouza_pargona_code)
                        {
                            template +=
                                '<option value="'+Mouza[i].mouza_pargona_code+'" selected>'+
                                    Mouza[i].loc_name +' (' +Mouza[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                Mouza[i].mouza_pargona_code +
                                "'>" +
                                Mouza[i].loc_name +
                                " (" +
                                Mouza[i].locname_eng +
                                ")</option>";
                        }
                    }

                    
                }
                $("#landmark_mouza_"+side+dag_no).html(template);

                landmark_mouza(side, dag_no);

            },
            error: function(error) {
            },
        });

    };

    function landmark_mouza(side,dag_no) 
    {

        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 

        var user_lot_no = $('#user_lot_no').val();

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();

        $.ajax({
            url: baseurl + "SettlementMbLm/getLot/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza,
            success: function(data) {
                var Lot = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Lot --</option>";
                for (var i = 0; i < Lot.length; i++) 
                {

                    if(chitha_processing_details == 1)
                    {
                        if(landmark_lot_ent == Lot[i].lot_no)
                        {
                            template +=
                                '<option value="'+Lot[i].lot_no+'" selected>'+
                                    Lot[i].loc_name +' (' +Lot[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                Lot[i].lot_no +
                                "'>" +
                                Lot[i].loc_name +
                                " (" +
                                Lot[i].locname_eng +
                                ")</option>";
                        }
                    }
                    else
                    {
                        if(user_lot_no == Lot[i].lot_no)
                        {
                            template +=
                                '<option value="'+Lot[i].lot_no+'" selected>'+
                                    Lot[i].loc_name +' (' +Lot[i].locname_eng +')'+
                                "</option>";
                        }
                        else
                        {
                            template +=
                                "<option value='" +
                                Lot[i].lot_no +
                                "'>" +
                                Lot[i].loc_name +
                                " (" +
                                Lot[i].locname_eng +
                                ")</option>";
                        }
                    }

                }
                $("#landmark_lot_"+side+dag_no).html(template);

                landmark_lot(side, dag_no);

            },
            error: function(error) {
            },
        });
    };

    function landmark_lot(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 
        var lot = $('#landmark_lot_'+side+dag_no).val(); 

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();


        $.ajax({
            url: baseurl + "SettlementMbLm/getVillage/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot,
            success: function(data) {
                var Village = JSON.parse(data);

                var template = "<option selected value=''>-- Select Village --</option>";
                for (var i = 0; i < Village.length; i++) 
                {
                    if(chitha_processing_details == 1)
                    {
                        if(landmark_village_ent == Village[i].vill_townprt_code)
                        {
                            template +=
                              "<option value='" +
                              Village[i].vill_townprt_code +
                              "' selected>" +
                              Village[i].loc_name +
                              " (" +
                              Village[i].locname_eng +
                              ")</option>";
                        }
                        else
                        {
                            template +=
                              "<option value='" +
                              Village[i].vill_townprt_code +
                              "'>" +
                              Village[i].loc_name +
                              " (" +
                              Village[i].locname_eng +
                              ")</option>";
                        }
                    }
                    else
                    {
                        template +=
                          "<option value='" +
                          Village[i].vill_townprt_code +
                          "'>" +
                          Village[i].loc_name +
                          " (" +
                          Village[i].locname_eng +
                          ")</option>";
                    }
                    
                }
                $("#landmark_village_"+side+dag_no).html(template);

                landmark_village(side, dag_no);
            },
            error: function(error) {
            },
        });
    };

    function landmark_village(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 
        var lot = $('#landmark_lot_'+side+dag_no).val(); 
        var village = $('#landmark_village_'+side+dag_no).val(); 

        var chitha_processing_details = $('#chitha_processing_details').val();
        
        var landmark_dist_ent = $('#landmark_dist_ent_'+side+dag_no).val();
        var landmark_subdiv_ent = $('#landmark_subdiv_ent_'+side+dag_no).val();
        var landmark_cir_ent = $('#landmark_cir_ent_'+side+dag_no).val();
        var landmark_mouza_ent = $('#landmark_mouza_ent_'+side+dag_no).val();
        var landmark_lot_ent = $('#landmark_lot_ent_'+side+dag_no).val();
        var landmark_village_ent = $('#landmark_village_ent_'+side+dag_no).val();
        var landmark_dag_ent = $('#landmark_dag_ent_'+side+dag_no).val();

        $.ajax({
            url: baseurl + "SettlementMbLm/getAllDags/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot+"/"+ village,
            success: function(data) {
                var Dags = JSON.parse(data);

                var template = "<option selected value=''>-- Select Dag --</option>";
                for (var i = 0; i < Dags.length; i++) 
                {
                    if(chitha_processing_details == 1)
                    {
                        if(landmark_dag_ent == Dags[i].dag_no)
                        {
                            template +=
                              "<option value='" +
                              Dags[i].dag_no +
                              "' selected>" +
                              Dags[i].dag_no +
                              "</option>";
                        }
                        else
                        {
                            template +=
                              "<option value='" +
                              Dags[i].dag_no +
                              "'>" +
                              Dags[i].dag_no +
                              "</option>";
                        }
                    }
                    else
                    {
                        template +=
                          "<option value='" +
                          Dags[i].dag_no +
                          "'>" +
                          Dags[i].dag_no +
                          "</option>";
                    }
                    
                }
                $("#landmark_dag_no_"+side+dag_no).html(template);
            },
            error: function(error) {
            },
        });
    };

</script>


<style>
    @media (min-width: 576px){
        .modal-dialog-family {
            max-width: 50%;
            margin: 1.75rem auto;
        }
    }
</style>

<div class="modal" role="dialog" id="addFamilyModal">
    <div class="modal-dialog-family" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enter Family Details</h5>
            </div>
            <div class="modal-body" align="center">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td>
                        <input type="text" id="add_kin_name" name="add_kin_name" placeholder="Name" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <input type="text" id="add_kin_address" name="add_kin_address" placeholder="Address" class="form-control">
                        </td>
                        
                    </tr>
                    <tr>
                        <th>Relation</th>
                        <td>
                            <select id="add_kin_relation" class="form-control" name="add_kin_relation">
                                
                            </select>
                        </td>
                        
                    </tr>
            
                    <tr>
                        <th>Mobile</th>
                        <td>
                            <input type="number" maxlength="10" id="add_kin_contact_no" class="form-control" name="add_kin_contact_no" placeholder="Mobile Number">
                        </td>
                        
                    </tr>
                    
                </table>
                
                <!-- <div class="row justify-content-center">
                    <button type="button" onclick="addFamilyDetails();" class="btn btn-sm btn-danger col-3">Add</button>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="familyModalCancel">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addFamilyDetails();" id="familyModalSave">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- add family details -->
<script>
    $(document).on('click','#familyModalCancel',function ()
    {
        $('#addFamilyModal').hide();
    });

    function addFamily()
    {   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbLm/getGuardianRelation',
            type: "POST",
            success: function(data) 
            {
                $.unblockUI();
                
                $('#addFamilyModal').show();

                arr = JSON.parse(data);

                if(arr.guar_rel == false)
                {
                    alert('Something went wrong!');
                    return false;
                }

                var option_rel = "<option selected value='' disabled>-- Select Relation --</option>";

                for(i=0; i<arr.guar_rel.length; i++)
                {
                    option_rel += '<option value="'+arr.guar_rel[i].id+'">'+arr.guar_rel[i].guard_rel_desc_as+'</option>'
                }

                $('#add_kin_relation').html(option_rel);
            }
        })
    }

    function addFamilyDetails(){
        var case_no = $.trim($('#case_no_id').val());
        var nominee_name = $.trim($('#add_kin_name').val());
        var address = $.trim($('#add_kin_address').val());
        var relation = $.trim($('#add_kin_relation').val());
        var mobile_no = $.trim($('#add_kin_contact_no').val());
        
        //validation for the update
        if(nominee_name == ''){
            alert('Name Field is required !');
            $('#add_kin_name').focus();
            return false;
        }
        if(address == ''){
            alert('Address Field is required !');
            $('#add_kin_address').focus();
            return false;
        }
        if(relation == ''){
            alert('Relation Field is required !');
            $('#add_kin_relation').focus();
            return false;
        }
        if(mobile_no == ''){
            alert('Mobile number Field is required !');
            $('#add_kin_contact_no').focus();
            return false;
        }
        if(mobile_no.length != 10){
            alert('Not a Valid Mobile number!');
            $('#add_kin_contact_no').focus();
            return false;
        }

        //prepare for updation
        var postData = {
            'case_no' : case_no,
            'nominee_name' : nominee_name,
            'address' : address,
            'relation' : relation,
            'mobile_no' : mobile_no
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbLm/addFamilyDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) 
                        {
                            $('#add_kin_name').val('');
                            $('#add_kin_address').val('');
                            $('#add_kin_contact_no').val('');
                            $('#add_kin_relation').val('');

                            $('#addFamilyModal').hide();
                            finalVerificationModal(case_no);
                        }
                    })
                }
            }
        });
    }

    // family delete
    function confirmDeleteFamily(id)
    {
        case_no = $('#case_no_id').val();

        if(confirm("Are you sure you want to delete this Record?"))
        {
            $.ajax({
                type: "POST",
                url: baseurl+'SettlementMbLm/delFamilyDetailsExisted',
                async: false,
                // dataType: 'json',
                data: { id: id, case_no:case_no },
                success: function (response) 
                {
                    const data = JSON.parse(response);
                    // console.log(data);
                    if(data.status == 0)
                    {
                        showErrorMessage("something went wrong!!");
                    }
                    else 
                    {              
                        showSuccessMessage("Nominee Deleted!!");
                        finalVerificationModal(case_no);
                    }         
                }
            });
        }
        else {
            // loading.out();
        }
    }
    // family delete
    function confirmDeleteFamilyLmInserted(id)
    {
        case_no = $('#case_no_id').val();

        if(confirm("Are you sure you want to delete this Record?"))
        {
            $.ajax({
                type: "POST",
                url: baseurl+'SettlementMbLm/delFamilyDetails',
                async: false,
                // dataType: 'json',
                data: { id: id, case_no:case_no },
                success: function (response) 
                {
                    const data = JSON.parse(response);
                    // console.log(data);
                    if(data.status == 0)
                    {
                        showErrorMessage("something went wrong!!");
                    }
                    else 
                    {              
                        showSuccessMessage("Nominee Deleted!!");
                        finalVerificationModal(case_no);
                    }         
                }
            });
        }
        else {
            // loading.out();
        }
    }

</script>
 

<script>

    $('#approvalForm').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to save the entered details?"))
        {
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl + "SettlementInstitutionCo/chithaProcessingDetails",
            type: 'POST',
            data: $("#approvalForm").serialize(),
            dataType: 'json',
            success: function (data) {

                $('#verifyReportModal').modal('hide');

                $.unblockUI();
                if(data.responseType == 2)
                {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success ml-2',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: data.msg,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        reverseButtons: false
                    }).then((result) => {
                        if (result . isConfirmed) {
                            window.location = window.location;
                        }
                    })
                }
                else
                {
                    showErrorMessage(data.msg); 
                }
            }
        });
    });
</script>


<script>
  function finalApprove(case_no)
  {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to approve this report?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                var postData = {
                  'case_no': case_no
                };

                $.blockUI({
                        message: $('#displayBox'),
                        css: {
                            border:'none',
                            backgroundColor:'transparent'
                        }
                    });

                $.ajax({
                    url: baseurl+'SettlementInstitutionCo/coApproveLmReport',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);

                        $.unblockUI();

                        if(arr.responseType != 2)
                        {
                            showErrorMessage(arr.msg);
                            return false;
                        }
                        else
                        {
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) 
                                {
                                    window.location = window.location;
                                }
                            })
                        }
                    }
                });

            }
        })
    
  }
</script>

<!-- getting the revenue details  -->
<script>
    function getRevenueHome(dag_no, case_no)
    {
        var land_class = $('#land_class_code_homestead'+dag_no).val();

        var postData = {
            'land_class_code' : land_class,
            'dag_no' : dag_no,
            'case_no' : case_no
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        })

        $.ajax({
            url: baseurl + "SettlementMbLm/getRevenueDetails",
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (data) {
                $.unblockUI();

                if(data.responseType == 2)
                {
                    // console.log(data.revenue);
                    $('#revenue_home'+dag_no).val(data.revenue);
                    $('#local_tax_home'+dag_no).val(data.local_tax);
                    $('#revenue_home'+dag_no).attr('readonly', false);
                    $('#local_tax_home'+dag_no).attr('readonly', false);
                }
                else
                {
                    $('#revenue_home'+dag_no).val('');
                    $('#local_tax_home'+dag_no).val('');
                    $('#revenue_home'+dag_no).attr('readonly', false);
                    $('#local_tax_home'+dag_no).attr('readonly', false);
                }
            }
        });
    }

    function getRevenueAgri(dag_no, case_no)
    {
        var land_class = $('#land_class_code_agriculture'+dag_no).val();

        var postData = {
            'land_class_code' : land_class,
            'dag_no' : dag_no,
            'case_no' : case_no
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        })

        $.ajax({
            url: baseurl + "SettlementMbLm/getRevenueDetails",
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (data) {
                $.unblockUI();

                if(data.responseType == 2)
                {
                    // console.log(data.revenue);
                    $('#revenue_agri'+dag_no).val(data.revenue);
                    $('#local_tax_agri'+dag_no).val(data.local_tax);
                    $('#revenue_agri'+dag_no).attr('readonly', false);
                    $('#local_tax_agri'+dag_no).attr('readonly', false);
                }
                else
                {
                    $('#revenue_agri'+dag_no).val('');
                    $('#local_tax_agri'+dag_no).val('');
                    $('#revenue_agri'+dag_no).attr('readonly', false);
                    $('#local_tax_agri'+dag_no).attr('readonly', false);
                }
            }
        });
    }
</script>

<style>
    @media (min-width: 576px){
        .modal-dialog-chitha {
            max-width: 70%;
            margin: 1.75rem auto;
        }
    }
</style>

<div class="modal" role="dialog" id="chithaUpdateModal">
    <div class="modal-dialog-chitha" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
            </div> -->
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-12 text-center p-2 shadow-sm mb-3" style="background: #FFC000;">
                        <b>UPDATE CHITHA</b>
                    </div>
                </div>

                <form id="chithaUpdateFinal">
                    <div id="chithaUpdateContent">

                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="chithaUpdateModalCancel">Cancel</button>
                <!-- <button type="button" class="btn btn-primary" id="chithaUpdateModalYes">Save</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    function finalChithaUpdate(case_no)
    {

        var postData = {
            'case_no' : case_no,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbCo/chithaUpdateDetails',
            type: "POST",
            data: postData,
            success: function(data) 
            {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }

                $('#chithaUpdateModal').show();
                $('#chithaUpdateContent').html(arr.content);

            }
        })
    }


    $(document).on('click','#chithaUpdateModalCancel',function ()
    {
        $('#chithaUpdateModal').hide();
    })

    $(document).on('click','#chithaUpdateModalYes',function ()
    {

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbCo/checkIfBifurcateAreaExceed',
            type: "POST",
            // dataType: 'json',
            data: $("#chithaUpdateFinal").serialize(),
            success: function(data) 
            {
                $.unblockUI();
                arr = JSON.parse(data);
                
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }

            }
        })
    })

</script>

<script>
    $(document).on('click', '#verifyPayment', function(){
        $('#udpatePayment').removeAttr('disabled');
    })
</script>

<div class="modal" role="dialog" id="editPattaTypeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLongTitle">Edit patta type</h5>
            </div>
            <div class="modal-body" align="">
                <div class="row justify-content-center">
                    <input type="hidden" id="case_no_edit_patta">

                    <div id="pattaTypeId" class="col-6">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="editPattaTypeModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="editPattaTypeModalYes">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function editPattaType(case_no){
        $('#editPattaTypeModal').show();

        var postData = {
            'case_no' : case_no
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbCo/choosePattaType',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2){
                    showErrorMessage(arr.msg);
                }
                else{
                    $('#case_no_edit_patta').val(arr.case_no);
                    var option = ''
                    for(i = 0; i<arr.data.length; i++){
                        option += '<option value="'+arr.data[i].type_code+'">'+arr.data[i].patta_type+'</option>';
                    }

                    $('#pattaTypeId').html('<select class="form-control" name="patta_type_code_new" id="patta_type_code_new">'+option+'</select>');

                }
            }
        });
    }

    $('#editPattaTypeModalNo').on('click', function(){
        $('#editPattaTypeModal').hide();
    })

    $('#editPattaTypeModalYes').on('click', function(){
        var case_no = $('#case_no_edit_patta').val();
        var patta_type_code_new = $('#patta_type_code_new').val();

        var postData = {
            'case_no' : case_no,
            'patta_type_code_new' :patta_type_code_new
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbCo/updatePattaType',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2){
                    showErrorMessage(arr.msg);
                }
                else{
                    
                    Swal.fire({
                                text: arr.msg,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    actions: 'my-actions',
                                    confirmButton: 'order-2',
                                }
                        }).then((result) => {
                            if (result.isConfirmed) 
                            {
                                window.location = window.location;
                            }
                        })

                }
            }
        })

    })
</script>

<style>
    #udpateLandClass {
        /* display: flex; */
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        width: 700px!important;
    }

</style>
<div class="modal" role="dialog" id="udpateLandClass">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLongTitle">Update landclass</h5>
            </div>
            <form id="land_class_update">

                <div class="modal-body" align="">
                    <div class="row justify-content-center">
                        <!-- <input type="hidden" id="case_no_edit_patta"> -->
                            <div id="landClassID" class="col-12"></div>
        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  id="udpateLandClassNo">CLOSE</button>
                    <button type="submit" class="btn btn-primary"   id="udpateLandClassYes">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>

    $('#udpateLandClassNo').on('click', function(){
        $('#udpateLandClass').hide();
    })

    function updateLandClass(case_no){
        $('#udpateLandClass').show();

        var postData = {
            'case_no': case_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbLm/getFinalVerificationData',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();

                
                if(arr.responseType == 0)
                {
                    $('#udpateLandClass').modal('hide');
                    showErrorMessage(arr.msg);
                    return false;
                }

                tr = '';
                tr = '<tr><th colspan="4" class="alert-warning">Please select both landclass as the applicant has applied for both home+agri land...</th></tr>';
                for(i=0; i<arr.dagResult.length; i++)
                {
                    var option_agri_class_code = '';
                    var option_home_class_code = '';
                    for(j=0; j<arr.land_class_code.length; j++)
                    {
                        class_code = arr.land_class_code[j].class_code;
                        land_type = arr.land_class_code[j].land_type;

                        //****For agriculture */
                        if(arr.land_class_code[j].class_code_cat == '01')
                        {
                            if(arr.dagResult[i].landTypeFinal == 2 || arr.dagResult[i].landTypeFinal == 3)
                            {
                                if(arr.dagResult[i].new_land_class_agri != '' && arr.dagResult[i].new_land_class_agri == class_code){
                                    option_agri_class_code += '<option value="'+class_code+'" selected>'+land_type+'</option>';
                                }else{
                                    option_agri_class_code += '<option value="'+class_code+'">'+land_type+'</option>';
                                }

                            }
                            else
                            {
                                option_agri_class_code += '';
                            }
                        }

                        //****for homestead */
                        if(arr.land_class_code[j].class_code_cat == '02')
                        {
                            if(arr.dagResult[i].landTypeFinal == 1 || arr.dagResult[i].landTypeFinal == 3)
                            {
                                if(arr.dagResult[i].new_land_class_home != '' && arr.dagResult[i].new_land_class_home == class_code){
                                    option_home_class_code += '<option value="'+class_code+'" selected>'+land_type+'</option>';
                                }else{
                                    option_home_class_code += '<option value="'+class_code+'">'+land_type+'</option>';
                                }
                            }
                            else
                            {
                                option_home_class_code += '';
                            }
                        }
                    }

                    if(arr.dagResult[i].new_home_land_revenue != ''){
                        var home_land_rev = '<th>'+
                                                '<label>Revenue</label>'+ 
                                                '<input type="number" id="revenue_home'+arr.dagResult[i].old_dag+'" name="revenue_home'+arr.dagResult[i].dag_no+'" value="'+arr.dagResult[i].new_home_land_revenue+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                            '</th>';
                    }else{
                        var home_land_rev = '<th>'+
                                                '<label>Revenue</label>'+ 
                                                '<input type="number" id="revenue_home'+arr.dagResult[i].old_dag+'" name="revenue_home'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                            '</th>';
                    }
                    if(arr.dagResult[i].new_agri_land_revenue != ''){
                        var agri_land_rev =  '<th>'+
                                                '<label>Revenue</label>'+ 
                                                '<input type="number" id="revenue_agri'+arr.dagResult[i].old_dag+'" name="revenue_agri'+arr.dagResult[i].dag_no+'" value="'+arr.dagResult[i].new_agri_land_revenue+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                            '</th>';

                    }else{
                        var agri_land_rev =  '<th>'+
                                                '<label>Revenue</label>'+ 
                                                '<input type="number" id="revenue_agri'+arr.dagResult[i].old_dag+'" name="revenue_agri'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                            '</th>';
                    }
                    if(arr.dagResult[i].new_home_land_local_tax != ''){
                        var home_local_tax =   '<th><label>Local Tax</label> <input type="number" name="local_tax_home'+arr.dagResult[i].dag_no+'" id="local_tax_home'+arr.dagResult[i].old_dag+'" value="'+arr.dagResult[i].new_home_land_local_tax+'" placeholder="Enter Local Tax" class="form-control" readonly></th>';
                    }else{
                        var home_local_tax =   '<th><label>Local Tax</label> <input type="number" name="local_tax_home'+arr.dagResult[i].dag_no+'" id="local_tax_home'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control" readonly></th>';
                    }
                    if(arr.dagResult[i].new_agri_land_local_tax != ''){
                        var agri_local_tax =    '<th><label>Local Tax</label> <input type="number" name="local_tax_agri'+arr.dagResult[i].dag_no+'" id="local_tax_agri'+arr.dagResult[i].old_dag+'" value="'+arr.dagResult[i].new_agri_land_local_tax+'" placeholder="Enter Local Tax" class="form-control" readonly></th>';
                    }else{
                        var agri_local_tax =    '<th><label>Local Tax</label> <input type="number" name="local_tax_agri'+arr.dagResult[i].dag_no+'" id="local_tax_agri'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control" readonly></th>';
                    }

                   
                    
                    if(arr.dagResult[i].landTypeFinal == 3 && (arr.dagResult[i].new_land_class_agri == '' || arr.dagResult[i].new_land_class_home == ''))
                    {
                        tr += '<tr><input type="hidden" value="'+arr.dagResult[i].case_no+'" name="case_no_det"><th colspan="4"><b>Dag no : '+arr.dagResult[i].dag_no+'</b></th></tr>';
                        
                        tr += '<tr>'+
                            // '<th>New land Class Homestead</th>'+
                            '<th colspan="2">'+
                                '<label>New land Class Homestead</label> '+
                                '<select class="form-control" name="land_class_code_homestead'+arr.dagResult[i].dag_no+'" onchange="getRevenueHome(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_homestead'+arr.dagResult[i].old_dag+'">'+
                                    '<option value="">Select land class...</option>'+
                                    option_home_class_code+
                                '</select>'+
                            '</th>'+

                            home_land_rev+
                            home_local_tax+
                        '</tr>';

                        tr += '<tr>'+
                            // '<th>New land Class Agriculture</th>'+
                            '<th colspan="2">'+
                                '<label>New land Class Agriculture</label>'+
                                '<select class="form-control" name="land_class_code_agriculture'+arr.dagResult[i].dag_no+'" onchange="getRevenueAgri(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_agriculture'+arr.dagResult[i].old_dag+'">'+
                                    '<option value="">Select land class...</option>'+
                                    option_agri_class_code+
                                '</select>'+
                            '</th>'+

                            agri_land_rev+

                            agri_local_tax+

                        '</tr>';
                    }                        
                }

                $('#landClassID').html('<table class="table">'+tr+'</table>');
            }
        });


        

    }
</script>

<script>
    // $('#land_class_update').submit(function (e) {

    //     e.preventDefault();
    //     if(!confirm("Are you sure you want to update entered details?"))
    //     {
    //         return false;
    //     }

    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });

    //     $.ajax({
    //         url: baseurl + "SettlementMbCo/updateLandClass",
    //         type: 'POST',
    //         data: $("#land_class_update").serialize(),
    //         dataType: 'json',
    //         success: function (data) {

    //             $('#udpateLandClass').modal('hide');

    //             $.unblockUI();
    //             if(data.responseType == 2)
    //             {
    //                 const swalWithBootstrapButtons = Swal.mixin({
    //                     customClass: {
    //                         confirmButton: 'btn btn-success ml-2',
    //                         cancelButton: 'btn btn-danger'
    //                     },
    //                     buttonsStyling: false
    //                 })

    //                 swalWithBootstrapButtons.fire({
    //                     title: data.msg,
    //                     icon: 'success',
    //                     showCancelButton: false,
    //                     confirmButtonText: 'Ok',
    //                     reverseButtons: false
    //                 }).then((result) => {
    //                     if (result . isConfirmed) {
    //                         window.location = window.location;
    //                     }
    //                 })
    //             }
    //             else
    //             {
    //                 showErrorMessage(data.msg); 
    //             }
    //         }
    //     });
    // });
</script>