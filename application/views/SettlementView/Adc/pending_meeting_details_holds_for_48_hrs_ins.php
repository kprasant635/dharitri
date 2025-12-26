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
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        color: #FFF;
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

    td{
        font-size: 17px!important;;
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
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



        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="font-size: 20px;">
                <a class="btn btn-sm btn-danger pull-right" href="<?=base_url().'index.php/SettlementProposalControllerIns/pendingProposalList'?>"><i class="fa fa-backward"></i>&nbsp; Go Back</a>
            </div>
        </div>


        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->lang->line('PendingOnlineMeetingDetails') ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" align="right">
                        <?php if($forwardButt == 1): ?>
                            <button class="rezaButt rezaInfo" id="meetingFrowardToDc">
                                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;Meeting Forward to dc
                            </button>
                        <?php else: ?>
                            <span style="color: red">SDLAC Online Report is Pending</span>
                        <?php endif ?>
                    </div>
                </div>

                <hr>
            </div>
            <div class="reza-body">

                <table class="table table-bordered">
                    <thead><h5 style="color:black;">Meeting Information</h5></thead>
                    <thead>
                    <tr style="background-color:white;">
                        <th>Meeting ID</th>
                        <td><?=$meeting->meeting_name?></td>
                        <th>Meeting Venue</th>
                        <td><?=$meeting->meeting_venue?></td>
                    </tr>
                    <tr>
                        <th>Meeting Held On</th>
                        <td><?=date('d M Y', strtotime($meeting->meeting_date))?></td>
                        <th>Forwarded By</th>
                        <td><?=$meeting->created_by?></td>
                    </tr>
                    <tr>
                        <th colspan="1">Meeting Remarks</th>
                        <td colspan="3"><?=$meeting->meeting_remarks?></td>
                    </tr>
                    </thead>
                </table>

                <table class="table table-bordered" id='datatable'>
                    <thead><h5 style="color:black;margin-top: 45px">List of Proposals</h5></thead>
                    <thead>
                    <tr style="background-color:#1b4f4d; color: white;">
                        <th>Sl No</th>
                        <th>Proposal ID</th>
                        <th>Service</th>
                        <th align="center" style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $j=1; foreach($proposal_detail as $prop){ ?>
                        <tr>
                            <td><?=$j?></td>
                            <td><?=$prop->proposal_name?></td>
                            <td><?=$this->utilityclass->getServiceName($prop->service_code)?></td>
                            <td align="center">
                                <a class="btn btn-sm btn-primary" target= "SDLACProposalNotice" href="<?=base_url()?>index.php/SettlementCommonDc/getProposalNotice/?case=<?=$prop->proposal_id?>">
                                    <i class="fa fa-file"></i>&nbsp;Notice</a>

                                <button type="button" class="btn btn-danger btn-sm" onclick="btnCaseView(<?=$prop->proposal_id?>)"><i class="fa fa-eye"></i>&nbsp;View</button>
                            </td>
                        </tr>
                        <?php $j++; } ?>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead><h5 style="color:black;margin-top: 45px">SDLAC members who attended meeting</h5></thead>
                    <thead>
                    <tr style="background-color:#1b4f4d; color: white;">
                        <th style="text-align:center">#</th>
                        <th>Member Name</th>
                        <th style="text-align:center">Nominee Name</th>
                        <th>Email ID</th>
                        <th style="text-align:center">Attended Mode</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i=1;  foreach($sdlac_member as $mem) { ?>
                        <tr>
                            <td align="center"><?=$i?></td>
                            <td>
                                <?=$this->utilityclass->getNameOfUserByUserCode($mem->sdlac_member_code)?>

                                (<?=$this->utilityclass->getDesignationNameByUserCode($mem->sdlac_member_code)->user_desig?>)
                            </td>
                            <td align="center">
                                <?php if($mem->nominee_id==0) : ?>
                                    --
                                <?php else: ?>
                                    <?php echo $this->utilityclass->getNomineeNameOfNomineeId($mem->nominee_id) ?>
                                <?php endif; ?>
                            </td>
                            <td><?=$mem->emailid?></td>
                            <td align="center">
                                <?php if($mem->meeting_attend_status==2) : ?>
                                    Offline
                                <?php else: ?>
                                    <span style="color: red; font-weight: bold">Online</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <?php if($mem->status==1) : ?>
                                    Process
                                <?php else: ?>
                                    <span style="color: red; font-weight: bold">
                                        Pending
                                    </span>
                                <?php endif; ?>
                            </td>

                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<!-- view proposal cases -->
<div class="modal" role="dialog" id="viewCasesModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Proposal No: <span style="color:red" id="propno"></span></h5>
                <i class="fa fa-close fa-2x text-red closeModal" style="cursor:pointer;"></i>
            </div>

            <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <table class="table table-bordered table-stripped reset">
                            <thead><h4>List of Cases</h4></thead>
                            <thead>
                            <tr style="background-color:#1b4f4d; color: white;">
                                <th>Case No</th>
                                <th>Remarks</th>
                                <th>Reject Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="list_of_cases"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- meeting forward to dc  -->
<div class="modal" role="dialog" id="meetingFrowardToDcModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Confirmation
                </h5>
                <i class="fa fa-close fa-2x text-red meetingFrowardToDcNo" style="cursor:pointer;"></i>
            </div>

            <input type="hidden" id="meetingId" value="<?php echo $meeting->id?>">
            <div class="modal-body">
                <div class="modal-body" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5>You want to forward this Meeting (<?php echo  $meeting->meeting_name?>) to DC for Final Verify</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary meetingFrowardToDcNo">NO</button>
                    <button type="button" class="btn btn-primary"   id="meetingFrowardToDcYes">YES, FORWARD</button>
                </div>
            </div>
        </div>
    </div>

</div>


<!--// NEW JS BY MASUD REZA-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

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


    $('.closeModal').click(function() {
        $('.reset').trigger('reset');
        $('#viewCasesModal').modal('hide');
    });

    function btnCaseView(propId)
    {

        loader();
        const proposal_no = {
            propId : propId,
        };
        $.ajax({
            url: BASE_URL + "/SettlementProposalControllerIns/viewCasesAgainstProposalNo",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {

                $.unblockUI();
                $('#viewCasesModal').modal({backdrop: 'static', keyboard: false});
                $('#viewCasesModal').modal('show');

                if (data.response == 1) {
                    showErrorMessage(data.message);
                }
                else if (data.response == 2) {

                    var table = '';
                    $.each(data.tableCases, function (key, val) {

                        if(val.rejected_flag==1) { var rej_status = 'Rejected'; }
                        else { var rej_status = ''; }

                        table +=
                            '<tr style="font-size:16px">'+
                            '<td>' + val.case_no + '</td>' +
                            '<td>' + val.template_remarks + '</td>' +
                            '<td>' + rej_status + '</td>' +
                            '<td>' +
                            '<a target="_blank" href="<?php echo base_url("index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case="); ?>' + val.case_no + '" class="rezaButt ">View</a>'
                            + '</td>' +
                            '</tr>'
                    });
                    $('#list_of_cases').html(table);
                    $('#propno').html(data.proposal_name);
                }
            },error: function (error) {
                showErrorMessage('Something went wrong.');
                $.unblockUI();
            },
            data: JSON.stringify(proposal_no)
        });
    }


    // forward to dc for final verification
    $(document).on('click','#meetingFrowardToDc',function ()
    {
        $('#meetingFrowardToDcModal').modal('show');
    });

    $(document).on('click','.meetingFrowardToDcNo',function ()
    {
        $('#meetingFrowardToDcModal').modal('hide');
    });


    $(document).on('click','#meetingFrowardToDcYes',function ()
    {
        var meetingId  = $("#meetingId").val();
        $('#meetingFrowardToDcModal').modal('hide');
        loader();
        if(meetingId == '')
        {
            showErrorMessage("There is some problem, Please refresh your browser !");
        }
        else
        {
            const applicant = {
                meetingId: meetingId
            };
            $.ajax({
                url: BASE_URL + "/SettlementProposalControllerIns/forwardOnlineMeetingToDcForFinalVerification",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data)
                {
                    $.unblockUI();

                    if (data.response == 1)
                    {
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
                                window.location = BASE_URL + "/SettlementProposalControllerIns/pendingProposalList";
                            }
                        });
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }

    });



</script>
