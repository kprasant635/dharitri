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

<form action="<?php echo base_url()?>index.php/SettlementMbCo/chithaUpdate" method="post">
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


    <div class="row p-2 m-1">
        <div class="col-8">
            <h5><u>Payment History Details</u></h5>
        </div>
        <div class="col-4">
        <?php
                if($installmentArray != false)
                {
                    $endArr = end($installmentArray);

                   if($endArr['total_premium'] <= $endArr['paid_amount'])
                   {
                        $is_full_paid = '<span class="text-success">Fully Paid</span>';
                   }
                   else
                   {
                        $is_full_paid = '<span class="text-danger">Not fully paid</span>';
                   }
                }
            ?>
            <h5>Payment Status : <?=$is_full_paid?></h5>
        </div>

    </div>
    <div class="row bg-white p-3">
        <div class="col-12 text-center">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Case No</th>
                    <th>Application No</th>
                    <th>GRN NO</th>
                    <th>Payment Date</th>
                    <th>Total Premium</th>
                    <th>Paid Amount</th>
                    <th>Remaining Amount</th>
                </tr>

                <?php
                if($installmentArray != false)
                {
                    $sl = 1;
                    foreach($installmentArray as $row)
                    {
                        ?>

                        <tr>
                            <td><?=$sl++?></td>
                            <td><?=$row['case_no']?></td>
                            <td><?=$row['case_no_rtps']?></td>
                            <td><?=$row['grn_no']?></td>
                            <td><?=$row['payment_date']?></td>
                            <td><?=$row['total_premium']?></td>
                            <td><?=$row['paid_amount']?></td>
                            <td><?=$row['remaining_amount']?></td>
                        </tr>

                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <br>

    <?php
        if($installmentArray != false)
        {
            $endArr = end($installmentArray);

            if($endArr['total_premium'] > $endArr['paid_amount'])
            {
                ?>
                <div class="row justify-content-center">
                    <div class="col-8">
                        <span class="font-weight-bold text-danger">NOTE: </span><span>Please verify challan before updating manual payment</span>
                        <a href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php" id="verifyPayment" target="verifyChallen" class="btn btn-sm btn-primary">Verify challan</a>

                        <br>
                        <span class="font-weight-bold text-danger">NOTE: </span><span>If Payment Is Done Manually, Please Update The Details By Clicking The Button</span>
                        <br>
                        <br>            

                        <button
                            id="udpatePayment"
                            disabled
                            class="btn btn-sm btn-warning" role="button" 
                            onclick="updateManualPaymentDetails()">
                            <i class="fa fa-edit"></i>
                            Update Manual Payment Details
                        </button>
                    </div>
                </div>

        <?php
            }
        }
    ?>
    <br>
    <br>



  </div>
</form>


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
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
            url: baseurl + "SettlementMbCo/updateChallenManualPayment",
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
    $(document).on('click', '#verifyPayment', function(){
        $('#udpatePayment').removeAttr('disabled');
    })
</script>