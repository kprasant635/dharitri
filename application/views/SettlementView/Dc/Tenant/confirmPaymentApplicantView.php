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

<form
  action="<?php echo base_url()?>index.php/SettlementTenantDc/confirmPaymentApplicant"
  method="post"
>
  <div class="container shadow bg-white">
    <div class="row mb-3">
      <h5 class="p-4 shadow" style="background: #1b707f">
        <span class="text-white p-2 shadow-sm">
          <i class="fa fa-hand-o-right" aria-hidden="true"></i>
          Payment confirmation for the case (<?=$case_no;?>)
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
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Applicantion Details</h5>
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
              APPLICANT CASE NUMBER
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
          </div>
        </div>

        <div class="row p-3">
          <div class="row">
            <?php
              if(trim(strtolower($payment_status)) == 'y'){
              ?>

                <span><strong>Total Premium Amount : <?php if($total_premium){ echo $total_premium;}?></strong></span><br>
                <span><strong>Amount Paid : <?php if($paid_amount){ echo $paid_amount." (".$percentage."%)";}?></strong></span><br>

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
            if(strtolower(trim($payment_status)) == 'y'){
            ?>
            <i class="fa fa-check fa-4x text-success" aria-hidden="true"></i>
            <h6>PAYMENT RECEIVED</h6>

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
                        url: baseurl + "SettlementMbCo/manualPaymentDetailsSubmitHandle",
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

<hr><br>


    <input type='hidden' name='case_no' id='case_no' value='<?=$case_no; ?>' >
  

    <div class="row justify-content-center mb-5 mt-4">
      <div class="col-md-6 text-center">
        <?php 
            if(strtolower(trim($payment_status)) == 'y'){
        ?>
        <input type='hidden' name='payment_confirmed' >
        <button type="submit" name="payment_confirmed" class="btn btn-danger">
          Confirm Payment
        </button>
        <?php }else{ ?>
          <h5 class="text-center text-danger alert-danger p-2">Payment not received...</h5>
        <?php }?>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
    $('.pattaselect').on('change', function(event){
            var name = $("#case_no").val();
            var dataString = 'case_no='+ name;
            var pattacode = $(this).val();
                $.ajax({
                    type        : 'POST', 
                    url         : baseurl+'SettlementMbCo/dagSelectOnPattachange', 
                    data        : {'case_no': name,'pattacode': pattacode}, 
                    dataType    : 'json', 
                    encode      : true,
                    beforeSend: function(){
                                $("#loading").show();
                                $('.btn-primary').hide();
                            },
                    success: function(data){
                      if(data.success!=null){
                        $("#loading").hide();
                        $('.btn-primary').show();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        $("#new_patta").val(data.new_patta);
                      }
                    },
                    error:function(data){
                        alert('Something went wrong');
                    }
                });
        });
</script>

<script>
    $(document).on('click', '#verifyPayment', function(){
        $('#udpatePayment').removeAttr('disabled');
    })
</script>
