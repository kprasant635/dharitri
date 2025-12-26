<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">
        INSTALLMENT-PAYMENT-UPDATION-FORM
    </li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center">
        <h4 class="panel-title">
            MANUAL INSTALLMENT PAYMENT UPDATION FORM
        </h4>
    </div>    
    <div class="panel-heading bg-warning text-white text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            CASE-NO : <b><?=$case_no?></b>, APPLICATION-NO : <b><?=$sb_details->applid?></b>
        </h6>
    </div>    
    <div class="card-body">
        <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">         
            <!-- PAYMENT INFO DETAILS  -->
            <div class = "card-body">            
                <table class="table table-striped table-bordered">
                    <th colspan="6" class="text-center bg-dark text-white">
                        PAYMENT-INFORAMTION-(INITIAL 30% PAYMENT INFO)
                    </th>
                    <tr class="bg-secondary">
                        <td>TOTAL-PREMIUM</td>
                        <td>INSTALLMENT-AMOUNT</td>
                        <td>PAID-AMOUNT<br>(30% PAYMENT)</td>
                        <td>REMAINING-AMOUNT<br>(AFTER 30% PAYMENT)</td>
                    </tr>
                    <tr class="">
                        <td>Rs <?=$sp_details[0]->total_premium?></td>
                        <td>Rs <?=$sp_details[0]->installment_amount?></td>
                        <td>Rs <?=$sp_details[0]->paid_amount?></td>
                        <td>Rs <?=$sp_details[0]->remaining_amount?></td>
                    </tr>
                </table> 
            </div>
            <!-- INSTALLMENT DETAILS  -->
            <div class = "card-body">            
                <table class="table table-striped table-bordered">
                    <tr>
                        <th colspan="6" class="text-center bg-dark text-white">
                            INSTALLMENT PAYMENT INFORMATION 
                        </th>    
                    </tr>                    
                    <tr>
                        <th colspan="6" class="text-center bg-success text-white">
                            NO OF PAID INSTALLMENT IS <?=$installment_info->total_installment_paid?>
                        </th>
                    </tr>                    
                    <tr class="bg-secondary">                        
                        <td>INSTALLMENT-NO</td>                        
                        <td>NO OF PAID<br>INSTALLMENT</td>
                        <td>INSTALLMENT-AMOUNT</td>
                        <td>TOTAL AMOUNT<br>PAID(IN THIS INSTALLMENT)</td>
                        <td>GRN-NO</td>
                    </tr>
                    <?php foreach ($installment_info->si_paid_result as $row):?>
                        <tr class="">                            
                            <td><?=$row->installment_no?></td>
                            <td><?=$row->no_of_installment_paid?></td>
                            <td><?=$row->installment_amount?></td>
                            <td><?=$row->paid_installment_amount?></td>
                            <td><?=$row->grn_no?></td>
                        </tr>
                    <?php endforeach;?>
                </table> 
            </div>
            <!-- payment updation method selection -->
            <div class = "card-body">   
                <table class="table table-striped table-bordered">
                    <tr>
                        <th colspan="6" class="text-center bg-dark text-white">
                            MANUAL PAYMENT UPDATION METHOD
                        </th>    
                    </tr>        
                    <tr class="">                        
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="smipuR" id="smipuwpl" value="with_payment_link_radio" checked>
                                <label class="form-check-label" for="smipuwpl">
                                    OFFLINE PAYMENT WITH PAYMENT LINK
                                </label>
                            </div>
                        </td>                        
                        <?php
                            if(ENABLE_SETTLEMENT_MANUAL_INSTALLMENT_PAYMENT_WITHOUT_LINK == 1){
                                $radio_status = 'enabled';
                            }else{
                                $radio_status = 'disabled';
                            }
                             
                        ?>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="smipuR" id="smipuwOutpl" value="without_payment_link_radio" <?=$radio_status?>>
                                <label class="form-check-label" for="smipuwOutpl">
                                    OFFLINE PAYMENT WITHOUT PAYMENT LINK
                                </label>
                            </div>            
                        </td>
                    </tr>            
                </table>
            </div>
            <!-- MANUAL UPDATION FORM WITH PAYMENT LINK -->
            <div class = "card-body" style="display:none;" id="withPyamnetLinkDiv">            
                <?php if($installment_info->si_last_row_to_be_updated_flag == 1): ?>  
                    <form action="<?php echo base_url()?>index.php/SettlementInstallmentController/manualInstallmentPaymentSubmitHandle" 
                    id="manual_installment_payment_update_form" target="_blank" enctype="multipart/form-data" method="POST">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th colspan="6" class="text-center bg-dark text-white">
                                    PAYMENT UPDATION FORM 
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-center bg-success text-white">
                                    NOTE: KINDLY VERIFY THE CHALLAN IN E-GRAS BREFORE UPDATION<br>
                                    <u><a href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php" style="font-size:14px;font-weight:bold;" target="_verifyLink">CLICK HERE TO VERIFY THE CHALLAN</a></u>                                 
                                </th>
                            </tr>    
                            <tr>
                                <th colspan="6" class="text-center bg-dark text-danger">
                                    NOTE: THE PAID AMOUNT SHOULD BE MATCHED WITH THE CHALLAN AMOUNT
                                </th>
                            </tr>                 
                            <tr>
                                <td class="text-right">NO-OF-INSTALLMENT<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="no_of_installment" id="no_of_installment" placeholder="NO-OF-INSTALLMENT" 
                                    style="width:40%!important;" value="<?=$installment_info->si_last_row_to_be_updated->no_of_installment_paid?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">PAID-INSTALMENT-AMOUNT(RS)<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="paid_installment_amount" id="paid_installment_amount" placeholder="PAID-AMOUNT" style="width:40%!important;"
                                    value="<?=$installment_info->si_last_row_to_be_updated->paid_installment_amount?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">PAYMENT LINK<br>GENERATED DATE<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="payment_link_generated_date" id="payment_link_generated_date" placeholder="PAYMENT LINK GENERATED DATE" style="width:40%!important;"
                                    value="<?=$installment_info->si_last_row_to_be_updated->installment_payment_link_created_date?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">GRN-NO<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="grn_no" id="grn_no" placeholder="GRN-NO" style="width:40%!important;">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">PAYMENT DATE<br>(MENTIONED IN CHALLAN)<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" placeholder = "PAYMENT-DATE"  id="payment_date" name="payment_date" readonly style="width:40%!important;">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">UPLOAD-CHALLAN<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="file" class="form-control" style="width:40%!important;" name="t_challan" id="t_challan">
                                </td>
                            </tr>
                        </table> 
                        <!-- hidden fields -->
                        <input type="hidden" name="application_no" id="application_no" value="<?=$sb_details->applid?>">
                        <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
                        <input type="hidden" name="pre_remaining_amount" id="pre_remaining_amount" value='<?=$installment_info->si_last_row_to_be_updated->pre_remaining_amount?>'>
                        <input type="hidden" name="paid_installment_amount" id="pre_remaining_amount" value='<?=$installment_info->si_last_row_to_be_updated->pre_remaining_amount?>'>                        
                        <input type="hidden" name="pre_paid_amount" id="pre_paid_amount" value='<?=$installment_info->si_last_row_to_be_updated->pre_paid_amount?>'>                        
                        <input type="hidden" name="installment_amount" id="installment_amount" value='<?=$installment_info->si_last_row_to_be_updated->installment_amount?>'>                        
                        <input type="hidden" name="installment_no" id="installment_no" value='<?=$installment_info->si_last_row_to_be_updated->installment_no?>'>
                        <input type="hidden" name="total_premium" id="total_premium" value='<?=$installment_info->si_last_row_to_be_updated->total_premium?>'>
                    </form>                                
                    <div class="panel panel-secondary panel-form">
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
                        <div class="panel-heading text-center">                        
                            <button
                                class="btn btn-info btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                onclick="submit_manual_installment_details()">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                SUBMIT
                            </button>                      
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    </div>
                <?php else : ?>                                        
                    <?php if($installment_info->total_installment_paid == 5): ?>        
                        <div class="panel panel-success panel-form">
                            <div class="panel-heading text-center">                        
                                ALL THE INSTALLMENT HAS BEEN PAID FOR THIS APPLICATION NO. 
                            </div>
                        </div>
                        <div class="panel-heading text-center">                        
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    <?php else : ?> 
                        <div class="panel panel-danger panel-form">
                            <div class="panel-heading text-center">                        
                                PAYMENT LINK IS NOT GENERATED FOR THE REST <b><?=5-$installment_info->total_installment_paid?></b> INSTALLMENTS. FOR UPDATION OF MANUAL INSTALLMENT PAYMENTS,
                                THE CHALLAN SHOULD BE GENERATED FROM PAYMENT LINK AND THE AMOUNT SHOULD BE MATCHED. 
                            </div>
                        </div>
                        <div class="panel-heading text-center">                        
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    <?php endif ?>
                <?php endif ?>  
            </div>
            <!-- MANUAL UPDATION FORM WITHOUT PAYMENT LINK -->
            <div class = "card-body" style="display:none;" id="withOutPyamnetLinkDiv">            
                <?php if($installment_info->total_installment_paid != 5 && $installment_info->si_last_row_to_be_updated_flag != 1): ?>                      
                    <form action="<?php echo base_url()?>index.php/SettlementInstallmentController/manualInstallmentPaymentSubmitHandleWithoutPaymentLink" 
                    id="manual_installment_payment_update_form" target="_blank" enctype="multipart/form-data" method="POST">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th colspan="6" class="text-center bg-dark text-white">
                                    PAYMENT UPDATION FORM 
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-center bg-success text-white">
                                    NOTE: KINDLY VERIFY THE CHALLAN IN E-GRAS BREFORE UPDATION<br>
                                    <u><a href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php" style="font-size:14px;font-weight:bold;" target="_verifyLink">CLICK HERE TO VERIFY THE CHALLAN</a></u>                                 
                                </th>
                            </tr>    
                            <tr>
                                <th colspan="6" class="text-center bg-dark text-danger">
                                    NOTE: THE PAID AMOUNT SHOULD BE MATCHED WITH THE CHALLAN AMOUNT
                                </th>
                            </tr>                 
                            <tr>
                                <td class="text-right">NO-OF-INSTALLMENT<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="no_of_installment" id="no_of_installment" placeholder="NO-OF-INSTALLMENT" 
                                    style="width:40%!important;" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">PAID-INSTALMENT-AMOUNT(RS)<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="paid_installment_amount" id="paid_installment_amount" placeholder="PAID-AMOUNT" style="width:40%!important;"
                                    value="">
                                </td>
                            </tr>                               
                            <tr>
                                <td class="text-right">GRN-NO<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" name="grn_no" id="grn_no" placeholder="GRN-NO" style="width:40%!important;">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">PAYMENT DATE<br>(MENTIONED IN CHALLAN)<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="text" class="form-control" placeholder = "PAYMENT-DATE"  id="payment_date" name="payment_date" readonly style="width:40%!important;">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">UPLOAD-CHALLAN<span class="text-danger font-weight-bold" style="font-size:14px;">*</span></td>
                                <td>
                                    <input type="file" class="form-control" style="width:40%!important;" name="t_challan" id="t_challan">
                                </td>
                            </tr>
                        </table> 
                        <!-- hidden fields -->
                        <input type="hidden" name="application_no" id="application_no" value="<?=$sb_details->applid?>">
                        <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">                        
                    </form>                                
                    <div class="panel panel-secondary panel-form">
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
                        <div class="panel-heading text-center">                        
                            <button
                                class="btn btn-info btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                onclick="submit_manual_installment_details_without_payment_link()">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                SUBMIT
                            </button>                      
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    </div>
                <?php else : ?>                                        
                    <?php if($installment_info->total_installment_paid == 5): ?>        
                        <div class="panel panel-success panel-form">
                            <div class="panel-heading text-center">                        
                                ALL THE INSTALLMENT HAS BEEN PAID FOR THIS APPLICATION NO. 
                            </div>
                        </div>
                        <div class="panel-heading text-center">                        
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    <?php else : ?> 
                        <div class="panel panel-warning panel-form">
                            <div class="panel-heading text-center">                        
                                PAYMENT LINK IS ALREADY GENERATED FOR THIS CASE NO. KINDLY UPDATE THE PAYMENT FROM 'OFFLINE PAYMENT WITH PAYMENT LINK' OPTION.   
                            </div>
                        </div>
                        <div class="panel-heading text-center">                        
                            <a
                                href="<?=base_url()?>index.php/home"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                >
                                <i class="fa fa-home" aria-hidden="true"></i>
                                GO TO HOME
                            </a>
                        </div>
                    <?php endif ?>
                <?php endif ?>  
            </div>
        </div>
    </div>
</div>
<script>
    
    function displayPaymentMethodDiv(){
        var paymentLinkMethod = $("input[type='radio'][name='smipuR']:checked").val();
        if(paymentLinkMethod == "with_payment_link_radio"){
            $('#withPyamnetLinkDiv').show();
            $('#withOutPyamnetLinkDiv').hide();            
        }else if (paymentLinkMethod == 'without_payment_link_radio') {
            $('#withPyamnetLinkDiv').hide();
            $('#withOutPyamnetLinkDiv').show();
        }else{
            $('#withPyamnetLinkDiv').hide();
            $('#withOutPyamnetLinkDiv').hide();
        }
    }

    $(document).ready(function(){
        $('#payment_date').datepick({dateFormat: 'yyyy-mm-dd'});
        displayPaymentMethodDiv();        
    });

    $('input[type=radio][name=smipuR]').change(function() {
        displayPaymentMethodDiv(); 
    });

    function submit_manual_installment_details(){
        //$('#manual_installment_payment_update_form').submit();
        var manual_installment_payment_update_form = new FormData();
        manual_installment_payment_update_form.append("t_challan", t_challan.files[0]);
        manual_installment_payment_update_form.append("grn_no", $('#grn_no').val());
        // manual_installment_payment_update_form.append("si_last_row",$('#si_last_row').val());
        manual_installment_payment_update_form.append("payment_date",$('#payment_date').val());
        manual_installment_payment_update_form.append("application_no",$('#application_no').val());
        manual_installment_payment_update_form.append("case_no",$('#case_no').val());
        manual_installment_payment_update_form.append("no_of_installment",$('#no_of_installment').val());
        manual_installment_payment_update_form.append("paid_installment_amount",$('#paid_installment_amount').val());
        manual_installment_payment_update_form.append("payment_link_generated_date",$('#payment_link_generated_date').val());
        manual_installment_payment_update_form.append("pre_remaining_amount",$('#pre_remaining_amount').val());
        manual_installment_payment_update_form.append("pre_paid_amount",$('#pre_paid_amount').val());
        manual_installment_payment_update_form.append("installment_amount",$('#installment_amount').val());
        manual_installment_payment_update_form.append("installment_no",$('#installment_no').val());
        manual_installment_payment_update_form.append("total_premium",$('#total_premium').val());
        $('#manual_chalan_update_validation_error_div').hide();    
        $('#manual_chalan_update_validation_error_msg').empty();    
        $.ajax({
            url: baseurl + "SettlementInstallmentController/manualInstallmentPaymentSubmitHandle",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: manual_installment_payment_update_form,
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
                // alert(data);
                // console.log(data);
                // $.unblockUI();
                // return;
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

    function submit_manual_installment_details_without_payment_link(){
        //$('#manual_installment_payment_update_form').submit();
        var manual_installment_payment_update_form = new FormData();
        manual_installment_payment_update_form.append("t_challan", t_challan.files[0]);
        manual_installment_payment_update_form.append("grn_no", $('#grn_no').val());
        // manual_installment_payment_update_form.append("si_last_row",$('#si_last_row').val());
        manual_installment_payment_update_form.append("payment_date",$('#payment_date').val());
        manual_installment_payment_update_form.append("application_no",$('#application_no').val());
        manual_installment_payment_update_form.append("case_no",$('#case_no').val());
        manual_installment_payment_update_form.append("no_of_installment",$('#no_of_installment').val());
        manual_installment_payment_update_form.append("paid_installment_amount",$('#paid_installment_amount').val());        
        $('#manual_chalan_update_validation_error_div').hide();    
        $('#manual_chalan_update_validation_error_msg').empty(); 
        $.ajax({
            url: baseurl + "SettlementInstallmentController/manualInstallmentPaymentSubmitHandleWithoutPaymentLink",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: manual_installment_payment_update_form,
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
                // alert(data);
                // console.log(data);
                // $.unblockUI();
                // return;
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

