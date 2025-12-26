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
    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
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
    .btn-info{

    }
    .checkBoxD{

        width: 20px;
        height: 20px;
    }
</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <a class="btn btn-sm btn-danger" href="<?=base_url().'index.php/SettlementMeetingControllerDc/meetingLandPage'?>"><i class="fa fa-backward"></i>&nbsp;Go Back</a>


        <div class="reza-card">
            <div class="reza-title"></div>
            <div class="reza-body">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" align="right">
                        <?php if($meeting->vgr_pgr_revert_status == 1): ?>
                            <b style="color: #FF5252;">Some cases are Reverted back from this Meeting.</b>
                        <?php endif; ?>
                    </div>
                </div>


                <table class="table table-bordered">
                    <thead><h5 style="color:black;">Meeting Information</h5></thead>
                    <thead>
                    <tr style="background-color:white;">
                        <th style="width: 15%!important;">Meeting ID</th>
                        <td style="width: 35%"><?=$meeting->meeting_name?></td>
                        <th style="width: 15%!important;">Meeting Venue</th>
                        <td style="width: 35%"><?=$meeting->meeting_venue?></td>
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

                <table class="datatable table table-stripped">
                    <thead><h5 style="color:black;margin-top: 45px">List of Proposals</h5></thead>
                    <thead>
                    <tr style="background-color:#1b4f4d; color: white;">
                        <th width="10%">Sl No</th>
                        <th width="20%">Proposal ID</th>
                        <th width="20%">Service</th>
                        <th width="20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $j=1; foreach($proposal_detail as $prop){ ?>
                        <tr>
                            <td><?=$j?></td>
                            <td><?=$prop->proposal_name?></td>
                            <td><?=$this->utilityclass->getServiceName($prop->service_code)?></td>
                            <td>
                                <a class="btn btn-sm btn-primary" target= "SDLACProposalNotice" href="<?=base_url()?>index.php/SettlementCommonDc/getProposalNotice/?case=<?=$prop->proposal_id?>">
                                    <i class="fa fa-file"></i>&nbsp;Notice
                                </a>
                            </td>
                        </tr>
                        <?php $j++; } ?>
                    </tbody>
                </table>

                <form id="bulkRevertByDC">
                    <table class="datatable table table-stripped" id='datatable' width="100%">
                        <thead><h5 style="color:black;margin-top: 45px">VGR/PGR Cases reverted to ADC/SDO</h5></thead>
                        <thead>
                        <tr>
                            <th>Select </th>
                            <th>Case No. </th>
                            <th>SDLAC Recommendation</th>
                            <th style="text-align: center">Remarks (* Mandatory)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1; foreach ($allCases as $cases) : ?>
                            <?php  foreach ($cases as $case) : ?>
                                <tr>
                                    <td style="width: 5%">
                                        <input type="checkbox" class="checkBoxD" name="case_no<?php echo $count; ?>" value="<?php echo $case->case_no ?>">
                                    </td>
                                    <td style="font-weight: bold; width: 28%;"><?php echo $case->case_no ?></td>
                                    <td style="width: 17%">
                                        <?php if(trim($case->case_status == 1)): ?>
                                            <b style="color: #388E3C; font-weight: bold">Recommended</b>
                                        <?php elseif(trim($case->case_status == 2)): ?>
                                            <b style="color: #FF5252; font-weight: bold">Not Recommended</b>
                                        <?php else: ?>
                                            Pending
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 50%">
                                        <textarea class="form-control" rows="2" name="revert_remark<?php echo $count; ?>" style="width: 100%" ></textarea>
                                    </td>
                                </tr>
                                <?php $count++ ;?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <input type="hidden" value="<?php echo $count; ?>" name="selectedCases">
                        <input type="hidden" value="<?php echo $meeting->id; ?>" name="meetingId">

                        </tbody>

                    </table>

                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px;">
                        <hr>
                        <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; color: #E53935">
                            Note: These cases are already mapped with proposal/meeting.
                            If you Revert selected cases, then this meeting would be on hold
                            until  all reverted case are not processed
                            <?php if($meeting->digital_sign_status != 0): ?>
                                <div style="margin-top: 10px; font-size: 17px">
                                    You have to resign the Digital Minutes using DSC Token.
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px; margin-bottom: 20px" align="right">
                        <?php if($meeting->vgr_pgr_revert_status == 1): ?>
                            <b style="color: #FF5252;">Some cases are Reverted back from this Meeting.</b>
                        <?php else: ?>
                            <button class="rezaButt " type="submit">
                                <i class="fa fa-level-down"></i> REVERT TO ADC/SDO
                            </button>
                        <?php endif; ?>

                    </div>
                </form>
            </div>
        </div>

        <a class="btn btn-sm btn-danger" href="<?=base_url().'index.php/SettlementMeetingControllerDc/meetingLandPage'?>"><i class="fa fa-backward"></i>&nbsp;Go Back</a>


    </div>
</div>

<!--// NEW JS BY MASUD REZA-->
<input type="hidden" name="meetingId" id="meetingId" value="<?=$meeting->id?>">
<input type="hidden" name="meetingName" id="meetingName" value="<?=$meeting->meeting_name?>">
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

    var BASE_URL = $("#getBaseURL").val();

    function loader(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    }

    function showSuccessMessage(text) {
        swal.fire({
            backdrop:true,
            allowOutsideClick: false,
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
            backdrop:true,
            allowOutsideClick: false,
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
            backdrop:true,
            allowOutsideClick: false,
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


    $('#bulkRevertByDC').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure ! you want to revert this selected case to ADC/SDO ?"))
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
            url: baseurl + "SettlementMeetingControllerDc/saveVgrPgrCasesForRevertDcData",
            type: 'POST',
            data: $("#bulkRevertByDC").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                if(data.responseType == 2) // success
                {
                    Swal.fire({
                        text: data.message,
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    })
                        .then((result) => {
                        if (result.isConfirmed) {
                    window.location = BASE_URL + "/SettlementMeetingControllerDc/meetingLandPage";
                }
                })
                }
                else if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    showErrorMessage('Something went wrong.');
                }
            },error: function (error) {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });


</script>
