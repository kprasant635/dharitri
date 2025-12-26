<style>
    table tr {
        font-weight: bold !important;
        font-size: 16px !important;
    }
    body { padding-right: 0 !important }
</style>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCFR/cfrVerification'?>">E-Khajana-(CFR Details)</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-CFR Book Details : <?=$cfrBookDetails->cfr_book_number?>)</li>
    </ol>
</nav>
<div class="container-fluid login form-top">
    <form action="" id="ek_adc_pending_case_display_form">
        <!-- working -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-success panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: center; font-weight: bold;">
                                <u><span>CFR Book Details</span></u>                                
                            </h3>
                            <h3 class="panel-title mt-1" style="text-align: center; font-weight: bold;">                                
                                <span><kbd> CFR Book No: <span style="color:red"><?=$cfrBookDetails->cfr_book_number?> </kbd></span>&nbsp;
                            </h3>
                        </div>
                        <div class="panel-body" style="font-size:18px!important;">
                            <table class="table table-striped table-bordered text-center">
                                <tr>
                                    <td>
                                        DISTRICT 
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$this->utilityclass->getDistrictName($cfrBookDetails->dist_code)?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        CIRCLE 
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$this->utilityclass->getCircleName($cfrBookDetails->dist_code,$cfrBookDetails->subdiv_code,$cfrBookDetails->cir_code)?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        MOUZA 
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$this->utilityclass->getMouzaName($cfrBookDetails->dist_code,$cfrBookDetails->subdiv_code,$cfrBookDetails->cir_code,$cfrBookDetails->mouza_pargona_code)?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        CFR BOOK NO
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <span style="color:red"><?=$cfrBookDetails->cfr_book_number?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TOTAL NO OF PAGES<br>IN THE CFR BOOK
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$cfrBookDetails->no_of_cfr_pages_in_the_book?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        CFR PAGE START<br>SERAIL NO
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$cfrBookDetails->cfr_page_serial_no_start?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        CFR PAGE END<br>SERAIL NO
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <?=$cfrBookDetails->cfr_page_serial_no_end?>
                                        </span>                                        
                                    </td>
                                </tr>
                                <?php 
                                    $date = new DateTime($cfrBookDetails->created_at); // Example date and time
                                    $formattedDate = $date->format('l, F j, Y, h:i A'); 
                                ?>
                                <tr>
                                    <td>
                                        DATE OF ENTRY<br>BY TN BRNACH  
                                    </td>
                                    <td>
                                        <span style="color:red"><?=$formattedDate?></span></td>
                                    </td>                                        
                                </tr>   
                            </table> 
                            <table class="table table-striped table-bordered text-bold">
                                <thead>
                                <tr>
                                    <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                        TN Report
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TN Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                    <th colspan="5">
                                        <textarea class="form-control" rows=2 name="lm_report" required readonly=""><?=$cfrBookDetails->tn_remarks?>
                                        </textarea>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered text-bold">
                                <thead>
                                <tr>
                                    <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                        ADC Report
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>ADC Remarks: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                    <th colspan="5"><textarea class="form-control" rows=2 name="adc_remarks" required></textarea>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="col-lg-10 col-lg-offset-1">
                        <!-- validation-errors-div -->
                        <div class="col-lg-12" id="coArr_error_div" style="display:none;margin-top:1rem">
                            <div class="card-header h5 bg-danger text-white text-center">
                                VALIDATION ERRORS
                            </div>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="text-center" style="color:red !important" id="coArr_validation_error_msg">
                                </strong>
                            </div>
                        </div>
                        <!-- validation-error-div-end -->
                        <div class="panel panel-secondary panel-form">
                            <div class="panel-heading text-center">
                                <button
                                    class="btn btn-success btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="ApproveCfrBook('<?=$cfrBookDetails->id?>')">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    APPROVE
                                </button>
                                <button
                                    class="btn btn-danger btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="rejectCfrBook('<?=$cfrBookDetails->id?>')">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    REJECT
                                </button>
                                <a href="<?=base_url().'index.php/EkhajanaCoController/index'?>"
                                    class="btn btn-warning btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    BACK TO HOME
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- MOdal display code -->
<!-- 04-01-2025 -->
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/rejLoader.gif"></div>
    <div id="rejectModal" class="modal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>After rejection of a cfr book data, it can be re-entered by respective TN Branch Official: </b>
                        <span class="red" id='caseNoHtml'></span>
                    </h5>
                </div>
                <form id="rejectformCfr" method="post">
                    <div class="modal-body" id="rejectmodalbody">
                        <div class="form-group">
                            <label class="required">Reject Reason</label>
                            <div style="max-height: 200px; overflow-y: scroll;">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="reject_remark" name="adc_reject_remarks" placeholder="Enter Reject Reason" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="errorMsg text-bold text-red"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="service_code" value="19">
                        <input type="hidden" name="id" id="id" value="<?=$cfrBookDetails->id?>">
                        <button type="submit" id="submit_reject_modal" class="btn btn-danger" data-dismiss="modal">Submit Rejection</button>
                        <button type="button" id="close_reject_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="adc_error_div" style="display:none;margin-top:1rem">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important" id="adc_error_div_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
            </div>
            
        </div>
    </div>
    <style type="text/css">
        .blockUI {
            z-index: 1200 !important;
        }
    </style>
<script>
    function ApproveCfrBook(id)
    {
        event.preventDefault();
        var adc_remarks = $('[name="adc_remarks"]').val();
        const application = {
            id  : id ,                   
            adc_remarks  : adc_remarks                   
        };
        $.ajax({
            url: baseurl + "EkhajanaCFR/approveEcfrBook",
            type: 'POST',
            data: application,
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
                    alert("Validation-Error...!!");
                    $('#coArr_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#coArr_validation_error_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    alert(data.msg);
                    return;

                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    Swal.fire({
                        title: data.msg,
                        icon: 'success',
                        confirmButtonColor: '#3085D6',
                        confirmButtonText: 'Home'
                    }).then((result) => {
                    if (result.isConfirmed) {
                            window.location = baseurl + "EkhajanaCFR/pendingCfrRecordsForAdc";
                        }
                    })
                    return;
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }

    function rejectCfrBook(id){
        event.preventDefault();
        $('#rejectModal').modal('show');
        return;
    }

    $('#rejectformCfr').submit(function (e) {
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
        var id = $('#id').val();
        var adc_reject_remarks = $('[name="adc_reject_remarks"]').val();
        var adc_remarks = $('[name="adc_remarks"]').val();
        const application = {
            id  : id ,                   
            adc_reject_remarks  : adc_reject_remarks,                  
            adc_remarks  : adc_remarks                   
        };
        let url = baseurl+'EkhajanaCFR/rejectCfrBook';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: application,
            success: function(data){
                if(data.result == 'VALIDATION-ERROR'){
                    $.unblockUI();
                    alert("Validation-Error...!!");
                    $('#adc_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#adc_error_div_error_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    $('.errorMsg').html(data.message);

                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    alert(data.msg);
                    location.href =  baseurl + "EkhajanaCFR/pendingCfrRecordsForAdc";
                }
            },error: function (error) {
                alert('Something went wrong.');
                $.unblockUI();
            }
        });
    });

    $('#close_reject_modal').click(function () {
        $('#rejectModal').modal('hide');
    });
</script>


