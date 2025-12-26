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

    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttSuccess {
        color: #FFF;
        background-color: #388E3C;
    }
    .buttPrim {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #FF5252;
    }
    .rezaButt:hover {
        color: #0c0c0c;
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
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <?php if($this->session->userdata('message')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->userdata('message') ?></b>
                <br>
                <b><?php $this->session->set_userdata('message','') ?></b>
            </div>
        <?php } ?>

        <?php if($this->session->flashdata('message')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $service_name ?></span>
                <hr>
                <span>Modification Requested Nc Application Details</span>
                <hr>
            </div>

            <div class="reza-body">
                <div class="tableCard">
                    <table class="table table-bordered">
                        <h5>Application Details </h5>
                        <tr>
                            <th style="width: 20%">Case No.:</th>
                            <td class="text-warning" style="width: 30%">
                                <strong class="alert-warning">
                                    <?= $basic->case_no?>
                                </strong>
                            </td>
                            <th style="width: 20%">Application No.:</th>
                            <td class="text-warning" style="width: 30%">
                                <strong class="alert-warning">
                                    <?= $basic->applid?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>District Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?=$this->ncutility->getDistrictName($basic->dist_code)?>
                                </strong>
                            </td>
                            <th>Subdivision Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?=$this->ncutility->getSubDivName($basic->dist_code, $basic->subdiv_code)?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Circle Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?=$this->ncutility->getCircleName($basic->dist_code, $basic->subdiv_code, $basic->cir_code)?>
                                </strong>
                            </td>
                            <th>Mouza Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?=$this->ncutility->getMouzaName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code)?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Village Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?=$this->ncutility->getVillageName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code)?>
                                </strong>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered" >
                        <h5 style="margin-top: 35px">Modification Requested Details </h5>
                        <tr>
                            <th style="width: 20%">Requested By:</th>
                            <td class="text-warning" style="width: 30%">
                                <strong class="alert-warning">
                                    <?php $requestBy = $this->ncutility->getSelectedCOName(
                                        trim($requestedDetails->dist_code),
                                        trim($requestedDetails->subdiv_code),
                                        trim($requestedDetails->cir_code),
                                        trim($requestedDetails->pull_req_by));
                                    ?>
                                    <?php if($requestBy->username != '')
                                    {
                                        echo $requestBy->username;
                                    }
                                    else
                                    {
                                        echo $requestedDetails->pull_req_by;
                                    }
                                    ?>
                                </strong>
                            </td>
                            <th style="width: 20%">Requested Date:</th>
                            <td class="text-warning" style="width: 30%">
                                <strong class="alert-warning">
                                    <?=  date("d-m-Y", strtotime($requestedDetails->date_of_pull)); ?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Requested Pending With:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?= $requestedDetails->pending_request_officer?>
                                </strong>
                            </td>
                            <th>Application Pending With:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?= $basic->pending_officer ?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>CO Remarks: </th>
                            <td class="text-warning" colspan="3">
                                <strong class="alert-warning">
                                    <?= $requestedDetails->co_remarks?>
                                </strong>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered" >
                        <h5 style="margin-top: 35px">Proposal Details </h5>
                        <?php if($caseInProposal == 0): ?>
                            <tr>
                                <th style="width: 20%">Application Map with Proposal: </th>
                                <td class="text-warning" style="width: 30%" colspan="3">
                                    <strong >
                                        <b style="color: green"> No </b>
                                    </strong>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($caseInProposal != 0): ?>
                            <tr>
                                <th style="width: 20%">Application Map with Proposal: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong >
                                        <b style="color: red"> Yes </b>
                                    </strong>
                                </td>
                                <th style="width: 20%">Proposal Name: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong class="alert-warning">
                                        <?= $proposalDetails->proposal_name ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Proposal Case Status: </th>
                                <td class="text-warning">
                                    <strong class="alert-warning">
                                        <?php if($proposalCaseD->case_status == 1): ?>
                                            Approved
                                        <?php elseif($proposalCaseD->case_status == 2): ?>
                                            Rejected
                                        <?php else: ?>
                                            Pending
                                        <?php endif; ?>
                                    </strong>
                                </td>
                                <th>Proposal Case Remarks : </th>
                                <td class="text-warning">
                                    <strong class="alert-warning">
                                        <?= $proposalCaseD->template_remarks ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Proposal Created By: </th>
                                <td class="text-warning">
                                    <strong class="alert-warning">
                                        <?= $proposalDetails->created_by ?>
                                    </strong>
                                </td>
                                <th>Proposal Created Date: </th>
                                <td class="text-warning">
                                    <strong class="alert-warning">
                                        <?=  date("d-m-Y", strtotime($proposalDetails->created_at)); ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Proposal Remarks: </th>
                                <td class="text-warning" colspan="3">
                                    <strong class="alert-warning">
                                        <?= $proposalDetails->remarks?>
                                    </strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>

                    <table class="table table-bordered" >
                        <h5 style="margin-top: 35px">Meeting Details </h5>
                        <?php if($caseInMeeting == 0): ?>
                            <tr>
                                <th style="width: 20%">Application Map with Meeting: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong >
                                        <b style="color: green"> No </b>
                                    </strong>
                                </td>
                                <th style="width: 20%">Digital Minutes Signed: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong >
                                        <b style="color: green"> No </b>
                                    </strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if($caseInMeeting != 0): ?>
                            <tr>
                                <th style="width: 20%">Application Map with Meeting: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong class="">
                                        <b style="color: red"> Yes </b>
                                    </strong>
                                </td>
                                <th style="width: 20%">Meeting Name: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong class="alert-warning">
                                        <?= $meetingDetails->meeting_name ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 20%">Meeting Created Date: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong class="alert-warning">
                                        <?=  date("d-m-Y", strtotime($meetingDetails->created_at)); ?>
                                    </strong>
                                </td>
                                <th style="width: 20%">Meeting Venue: </th>
                                <td class="text-warning" style="width: 30%">
                                    <strong class="alert-warning">
                                        <?= $meetingDetails->meeting_venue ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 20%">Digital Minutes Signed: </th>
                                <td class="text-warning" style="width: 30%">
                                    <?php if($meetingDetails->digital_sign_status == 0): ?>
                                        <strong class="">
                                            <b style="color: green"> No </b>
                                        </strong>
                                    <?php else: ?>
                                        <strong class="">
                                            <b style="color: red"> Yes </b>
                                        </strong>
                                    <?php endif; ?>
                                </td>

                                <th style="width: 20%">Meeting Status: </th>
                                <td class="text-warning" style="width: 30%">
                                    <?php if($meetingDetails->dc_approve_status == 0): ?>
                                        <strong class="">
                                            <b style="color: green"> Pending </b>
                                        </strong>
                                    <?php else: ?>
                                        <strong class="">
                                            <b style="color: red"> Processed </b>
                                        </strong>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Meeting Remarks: </th>
                                <td class="text-warning" colspan="3">
                                    <strong class="alert-warning">
                                        <?= $meetingDetails->meeting_remarks?>
                                    </strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>

                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" align="right">
                        <?php if($rejectButtAccess == 1): ?>
                            <?php if($forwardButtAccess == 1): ?>
                                <button class="rezaButt buttPrim" id="forwardedRequest">
                                    <i class="fa fa-share" aria-hidden="true"></i> Forward To DC
                                </button>
                            <?php endif; ?>
                            <?php if($acceptButtAccess == 1): ?>
                                <button class="rezaButt buttSuccess" id="acceptedRequest">
                                    <i class="fa fa-check" aria-hidden="true"></i> Accept
                                </button>
                            <?php endif; ?>

                            <button class="rezaButt buttDanger" id="rejectedRequest">
                                <i class="fa fa-times" aria-hidden="true"></i> Reject
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>



<!-- Modal Forwarded Request -->
<div class="modal" role="dialog" id="forwardRequestModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Forward Modification Request </h5>
            </div>
            <div class="modal-body" align="">
                <div class="row" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5 style="color: #2E7D32; margin-bottom: 25px">You want to Forward modification request for  <br>
                        Case :
                        <span style="font-weight: bold"> <?php echo $basic->case_no ?> </span>
                        to DC
                    </h5>
                    <hr>
                </div>

                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="forwardRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px">
                <?php if($caseInProposal == 1): ?>
                    <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; color: #E53935">
                        Note: Case already map with proposal,
                        if DC accept this modification request, then this case would no longer be part of any Proposal
                        and case would revert back to CO.
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="forwardRequestModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="forwardRequestModalYes">FORWARD</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Request Rejected  -->
<div class="modal" role="dialog" id="rejectedRequestModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reject Modification Request </h5>
            </div>
            <div class="modal-body" align="">
                <div class="row" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5 style="color: #F44336; margin-bottom: 25px">You want to reject modification request for  <br>
                        Case :
                        <span style="font-weight: bold"> <?php echo $basic->case_no ?> </span>
                    </h5>
                    <hr>
                </div>

                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="rejectedRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="rejectedRequestModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="rejectedRequestModalYes">REJECT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Accepted  Request -->
<div class="modal" role="dialog" id="acceptedRequestModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Accept Modification Request </h5>
            </div>
            <div class="modal-body" align="">
                <div class="row" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5 style="color: #2E7D32; margin-bottom: 25px">You want to Accept modification request for  <br>
                        Case :
                        <span style="font-weight: bold"> <?php echo $basic->case_no ?> </span>
                    </h5>
                    <hr>
                </div>

                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="acceptRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px">
                <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; color: #E53935">

                    Note:
                    <?php if($caseInProposal == 1): ?>
                        Case already map with proposal,
                    <?php endif; ?>
                    If you Accept this modification request,
                    <?php if($this->session->userdata('user_desig_code') == 'DC'):  ?>
                        then this case would no longer be part of any Proposal and case would revert back to CO.
                    <?php else: ?>
                        this case would revert back to CO.
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="acceptedRequestModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="acceptedRequestModalYes">ACCEPT</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="caseNo" value="<?php echo $basic->case_no ?>">
<input type="hidden" id="requestId" value="<?php echo $requestedDetails->id ?>">
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
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


    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showConfirmButton: true,
        });
    }



    // ****************************************************************
    // Rejected Modification Request
    $(document).on('click','#rejectedRequest',function ()
    {
        $('#rejectedRequestModal').modal('show');
    });

    $(document).on('click','#rejectedRequestModalNo',function ()
    {
        $('#rejectedRequestModal').modal('hide');
    });

    $(document).on('click','#rejectedRequestModalYes',function ()
    {
        var remarks   = $("#rejectedRemarks").val();
        var requestId = $("#requestId").val();
        var caseNo    = $("#caseNo").val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        if(remarks != '')
        {
            const applicant = {
                caseNo    : caseNo,
                requestId : requestId,
                remarks   : remarks
            };

            $.ajax({
                url: BASE_URL + "/NcModification/modificationRequestReject",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#rejectedRequestModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if(data.responseType == 2)
                    {
                        Swal.fire({
                            text: data.message,
                            // confirmButtonText: 'OK',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Thank You',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                        location.reload();
                    }})
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



    // ****************************************************************
    // Forward Modification Request
    $(document).on('click','#forwardedRequest',function ()
    {
        $('#forwardRequestModal').modal('show');
    });

    $(document).on('click','#forwardRequestModalNo',function ()
    {
        $('#forwardRequestModal').modal('hide');
    });

    $(document).on('click','#forwardRequestModalYes',function ()
    {
        var remarks   = $("#forwardRemarks").val();
        var requestId = $("#requestId").val();
        var caseNo    = $("#caseNo").val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        if(remarks != '')
        {
            const applicant = {
                caseNo    : caseNo,
                requestId : requestId,
                remarks   : remarks
            };

            $.ajax({
                url: BASE_URL + "/NcModification/modificationRequestForwardToDC",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#forwardRequestModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if(data.responseType == 2)
                    {
                        Swal.fire({
                            text: data.message,
                            // confirmButtonText: 'OK',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Thank You',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                        location.reload();
                    }})
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



    // ****************************************************************
    // Accept Modification Request
    $(document).on('click','#acceptedRequest',function ()
    {
        $('#acceptedRequestModal').modal('show');
    });

    $(document).on('click','#acceptedRequestModalNo',function ()
    {
        $('#acceptedRequestModal').modal('hide');
    });

    $(document).on('click','#acceptedRequestModalYes',function ()
    {
        var remarks   = $("#acceptRemarks").val();
        var requestId = $("#requestId").val();
        var caseNo    = $("#caseNo").val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        if(remarks != '')
        {
            const applicant = {
                caseNo    : caseNo,
                requestId : requestId,
                remarks   : remarks
            };

            $.ajax({
                url: BASE_URL + "/NcModification/modificationRequestAcceptByAdcSdo",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#acceptedRequestModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if(data.responseType == 2)
                    {
                        Swal.fire({
                            text: data.message,
                            // confirmButtonText: 'OK',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Thank You',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                        location.reload();
                    }})
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                error:function(jqXHR, textStatus,errorThrown)
                {
                    $.unblockUI();
                    alert(textStatus);
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            $.unblockUI();
            showErrorMessage("Please Enter Some Remarks !");
        }
    });










</script>

