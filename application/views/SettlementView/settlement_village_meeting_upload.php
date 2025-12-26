<!-- Masud's CSS-->
<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .rezaInfo {
        background-color: #03a9f4;
    }
    .rezaClose {
        background-color: #EF5350;
    }
    .rezaPrint {
        background-color: #673AB7;
    }
    .rezaPrim {
        background-color: #9C27B0;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        color: #FFF;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }

    .checkBoxD{

        width: 20px;
        height: 20px;
    }


    .divCard {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        margin-bottom: 20px;
    }

    .tdPrint{
        background-color: white!important;
        border: 1px solid black;
        color: black!important;
        font-size: 12px;
    }

    .table-bordered>tbody>tr>td,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>td,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>thead>tr>th
    {
        border: 1px solid black!important;
    }


</style>

<div class="row" style='padding: 20px 35px 0px 0px' align="left">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

        <input type="hidden" id="uuid" value="<?php echo $uuid ?>">

        <span style="padding-left: 35px">
            Process /
            Settlement MB /
        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <?php echo $this->lang->line('villageMeetingSidebar') ?>
        </a>
        / Upload Report
        </span>


        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Go one step Back</button>
        </a>
    </div>
</div>

<div class="row" style='padding: 10px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if($this->session->flashdata('success')) { ?>

            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>


        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('villageMeetingCase') ?></span>
                <hr>

            </div>

            <div class="reza-body">
                <h5>Area Details</h5>
                <table class="table table-bordered" style="width: 100%">
                    <tbody>
                    <tr>
                        <td style="width: 20%">District</td>
                        <td style="width: 30%"><?php echo $dist_name->loc_name ?></td>

                        <td style="width: 20%">Sub Division</td>
                        <td style="width: 30%"><?php echo $subDiv_name->loc_name ?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Circle</td>
                        <td style="width: 30%"><?php echo $circle_name->loc_name ?></td>

                        <td style="width: 20%">Mouza</td>
                        <td style="width: 30%"><?php echo $mouza_name->loc_name ?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Lot</td>
                        <td style="width: 30%"><?php echo $lot_name->loc_name ?></td>

                        <td style="width: 20%">Village</td>
                        <td style="width: 30%"><?php echo $village_name ?></td>
                    </tr>

                    </tbody>
                </table>

                <br>


                <?php if($check != 0): ?>
                    <h5>Meeting  Details</h5>
                    <table class="table table-bordered" style="width: 100%">
                        <tr>
                            <td style="width: 30%">Meeting Name</td>
                            <td style="width: 70%; font-weight: bold"><?php echo $uploadedData->meeting_name ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Meeting Date</td>
                            <td style="width: 70%"><?php echo $uploadedData->meeting_date ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Venue</td>
                            <td style="width: 70%"><?php echo $uploadedData->meeting_venue ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Uploaded Report</td>
                            <td style="width: 70%">
                                <a class="rezaButt rezaPrim sm" target="_blank" href="<?php echo base_url();echo $uploadedData->upload_file ?>">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Remarks</td>
                            <td style="width: 70%" colspan="3"><?php echo $uploadedData->meeting_remarks ?></td>
                        </tr>
                    </table>
                <?php endif; ?>

                <br>

                <?php if($check == 0): ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <button type="button"  id="openUploadReportModal" class="rezaButt rezaPrim">
                                <i class="fa fa-forward"></i>
                                upload Report
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>



    </div>
</div>

<div class="row" style='padding: 0px 35px 30px 0px' align="left">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Go one step Back</button>
        </a>
    </div>
</div>


<!-- Modal for Upload document  -->
<div class="modal" role="dialog" id="finalUploadReportModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Upload VLMC Meeting Report
                </h5>
                <i class="fa fa-close fa-2x text-red uploadReportModalNo" style="cursor:pointer;"></i>
            </div>

            <div class="modal-body">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Meeting Date <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="datetime-local" class="form-control"
                                       name="meeting_date" id="meeting_date">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Upload Meeting Report<span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="file" class="form-control" id="upload_report" name="upload_report">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Venue of Meeting  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="text" class="form-control"
                                       name="meeting_venue" id="meeting_venue" placeholder="Enter Venue of meeting held">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Remarks  <span style="font-weight: bold; font-size: 18px; color: red"></span></label>
                                <input type="text" class="form-control"
                                       name="meeting_remarks" id="meeting_remarks" placeholder="Enter Remarks">
                            </div>
                        </div>

                    </div>&nbsp;

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: 25px">
                        <button type="submit"  class="rezaButt rezaClose uploadReportModalNo">
                            <i class="fa fa-times-circle-o" aria-hidden="true"></i> Close
                        </button>
                        <button type="submit" id="uploadReportModalYes" class="rezaButt rezaPrint">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i> Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Masud Script-->

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>


    var BASE_URL = $("#getBaseURL").val();
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
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


    function loader(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    }


    $("#openUploadReportModal").click(function(){
        $('#finalUploadReportModal').modal('show');
    });

    $("#uploadReportModalYes").click(function()
    {
        var data = [];

        if($('#meeting_date').val() == '') {
            showErrorMessage('Meeting Date is mandatory');
            $('#meeting_date').focus();
            return false;
        }

        if($('#upload_report').val() == '') {
            showErrorMessage('Upload Report is mandatory');
            $('#upload_attendance').focus();
            return false;
        }

        if($('#meeting_venue').val() == '') {
            showErrorMessage('Meeting venue is mandatory');
            $('#meeting_venue').focus();
            return false;
        }

        loader();

        var uploadedFile = new FormData();
        uploadedFile.append("upload_report", $('#upload_report')[0].files[0]);
        uploadedFile.append("meeting_date", $('#meeting_date').val());
        uploadedFile.append("meeting_venue",  $('#meeting_venue').val());
        uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());
        uploadedFile.append("uuid", $('#uuid').val());

        uploadedFile.append("data", JSON.stringify(data));


        $.ajax({
            url: BASE_URL + "/SettlementCommon/saveReportCaseListForVillageMeeting",
            type: "post",
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData:false,
            success: function (data)
            {
                $.unblockUI();
                $('#finalUploadReportModal').modal('hide');
                var data = JSON.parse(data);

                if (data.response == 1) { //for error message
                    showErrorMessage(data.message);
                }
                else if (data.response == 2)
                {
                    Swal.fire({
                        backdrop:true,
                        allowOutsideClick: false,
                        text: data.message,
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then(function(result) {
                        if(result.isConfirmed){
                            window.location = BASE_URL + "/SettlementCommon/getVillageListForVillageMeetingApi";
                        }
                    });

                }
                else
                {
                    showErrorMessage(" SOMETHING WENT WRONG !");
                }
            },
            data: uploadedFile

        });



    });

    //close modal
    $('.uploadReportModalNo').click(function(){
        $('#finalUploadReportModal').modal('hide');
    });


</script>


