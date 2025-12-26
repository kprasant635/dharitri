<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Manual-Challan-Reverify</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>
    <div class="col-lg-2"></div>          
    <div class="col-lg-8 text-center">
        <div class="card-header bg-warning text-white text-center h6 p-3">
            MANUAL PAYMENT REVERIFICATION
        </div>
        <div class="card-header text-center h6 p-3 shadow-lg" style="background-color:white">
            <span class="font-weight-bold text-danger">NOTE: </span><span>Please verify challan before updating manual payment</span>
            <br><hr>        
            <a href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php" id="reVerifyPayment" target="reVrifyChallen" class="btn btn-sm btn-primary">Verify challan</a>        
            <button
                id="udpatePayment"
                disabled
                class="btn btn-sm btn-warning" role="button" 
                onclick="verifyManualPaymentDetails()">
                <i class="fa fa-edit"></i>
                MANUAL PAYMENT REVERIFY
            </button>
        </div>            
    </div>         
    <div id="manualPaymentUpdateModal" class="modal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
            <div class="modal-content">
                <div class="card-header bg-warning text-white text-center h6 p-3">
                    MANUAL PAYMENT REVERIFICATION
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
                            <label>RTPS-APPLICATION-NO</label>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" id='application_no' name='application_no'
                            type="text" placeholder="RTPS-APPLICATION-NO"/>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4" style="text-align: right;">
                            <label>GRN-NO</label>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" id='grn_no' name='grn_no'
                            type="text" placeholder="GRN-NO"/>
                        </div>
                    </div>
                    <!-- <div class="row mt-3">
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
                    </div> -->
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
        $(document).on('click', '#reVerifyPayment', function(){
            $('#udpatePayment').removeAttr('disabled');
        })
        $(document).ready( function () {        
            $('#manual_payment_date').datepick({dateFormat: 'yyyy-mm-dd'});
        });
        function verifyManualPaymentDetails(){
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
            manualChallanForm.append("application_no", $('#application_no').val());
            manualChallanForm.append("grn_no", $('#grn_no').val());
            manualChallanForm.append("amount", $('#amount').val());
            manualChallanForm.append("payment_date", $('#manual_payment_date').val());         
            $('#manual_chalan_update_validation_error_div').hide();    
            $('#manual_chalan_update_validation_error_msg').empty();     
            $.ajax({
                url: baseurl + "ManualChallanController/settlementManualChallanReVerifyHandle",
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
</div>