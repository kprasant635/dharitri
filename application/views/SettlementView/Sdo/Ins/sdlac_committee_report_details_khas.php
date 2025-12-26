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
    .reza-adhikari{
        font-weight: bold;
        font-size: 18px;
        color: #37474F;
        padding-bottom: 5px;
        padding-left: 20px;
        padding-right: 20px;
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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process /
            Settlement MB /
            <a href="<?= base_url()?>index.php/SettlementMbADC/SettlementKhasLandDc">Khas Land</a> /
            <a href="<?= base_url()?>index.php/SettlementMbADC/getAllSdlacMemberApprovalProposalListKhas">SDLAC/CDLAC Member Status </a> / Details

            <a href="<?= base_url()?>index.php/SettlementMbADC/getAllSdlacMemberApprovalProposalListKhas">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Go Back One Step</button>
            </a>

        </div>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('khasLand') ?> SDLAC/CDLAC Member Status Details</span>
                <hr>
            </div>
            <?php if ($pendingCaseCount == 0) : ?>
                <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
            <?php else : ?>
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                <input type="hidden" id="proposalIdForward" value="<?php echo $cases->id ?>">


                <div class="reza-adhikari">
                    <span>Proposal Details</span>
                </div>
                <div class="reza-body">
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td width="35%">Proposal Number</td>
                            <td style="font-weight: bold"><?php echo $cases->id ?></td>
                        </tr>
                        <tr>
                            <td>Hearing Date</td>
                            <td style="font-weight: bold"><?php echo $cases->h_date ?></td>
                        </tr>
                        <tr>
                            <td>Created By</td>
                            <td style="font-weight: bold"><?php echo $cases->created_by ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="reza-adhikari">
                    <span>SDLAC/CDLAC Member Status Details</span>
                </div>

                <div class="reza-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Name</th>
                            <th>Phone No</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($reports as $report):  $i++ ?>
                            <tr>
                                <td width="60px"><?php echo $i ?> </td>
                                <td><?php echo $report->username ?> </td>
                                <td><?php echo $report->phone_no ?> </td>
                                <td>
                                    <?php if($report->status == SDLAC_MEMBER_REPORT_STATUS_PENDING) : ?>
                                        <i class="fa fa-spinner fa-pulse " aria-hidden="true"></i> &nbsp;Pending
                                    <?php elseif ($report->status == SDLAC_MEMBER_REPORT_STATUS_AGREE) : ?>
                                        <i class="fa fa-check-square text-green" aria-hidden="true"></i> &nbsp;Agreed
                                    <?php elseif ($report->status == SDLAC_MEMBER_REPORT_STATUS_DISAGREE) : ?>
                                        <i class="fa fa-times-circle text-red" aria-hidden="true"></i> &nbsp;Disagreed
                                    <?php endif ;?>
                                </td>
                                <td><?php echo $report->remarks ?> </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <br>

                    <?php if($getMemberStatus == 0) { ?>

                        <?php if($cases->final_verify_status == 0): ?>

                            <button  class="rezaButt buttPrimary" id="forwardToDCFinal" >
                                <i class="fa fa-share" aria-hidden="true"></i>
                                <?php echo $this->lang->line('forwardToDCFinalVerifyButt'); ?>
                            </button>
                        <?php elseif($cases->final_verify_status == 1): ?>
                            <span style="color: #EF5350; font-weight: bold; font-size: 18px">
                                <?php echo $this->lang->line('finalApprovalPendingDc'); ?>
                            </span>
                        <?php elseif($cases->final_verify_status == 2): ?>
                            <span style="color: #2E7D32; font-weight: bold; font-size: 18px">
                                <?php echo $this->lang->line('finalApprovalDone'); ?>
                            </span>

                        <?php endif; ?>
                    <?php } ?>  

                </div>

            <?php endif; ?>


        </div>

    </div>

</div>

<!-- Modal forward to dc for final verification -->
<div class="modal" role="dialog" id="finalVerifyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Confirmation
                </h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to Forward this Proposal for Final Verify</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="finalVerifyModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="finalVerifyModalYes">YES</button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>
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

    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    // ****************************************************************
    // forward to dc for final verification
    $(document).on('click','#forwardToDCFinal',function ()
    {
        $('#finalVerifyModal').modal('show');
    });

    $(document).on('click','#finalVerifyModalNo',function ()
    {
        $('#finalVerifyModal').modal('hide');
    });

    $(document).on('click','#finalVerifyModalYes',function ()
    {
        var proposalNo  = $("#proposalIdForward").val();
        $('#finalVerifyModal').modal('hide');
        if(proposalNo == '')
        {
            showErrorMessage("There is some problem, Please refresh your browser !");
        }
        else
        {
            const applicant = {
                proposalNo: proposalNo
            };
            $.ajax({
                url: BASE_URL + "/SettlementMbADC/proposalForwardToDcForFinalVerifyKhas",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        showErrorMessage("Data not found !");
                    }
                    // else if (data.responseType == 3)
                    // {
                    //     showErrorMessage("There might be some pending case(s) under this Proposal !");
                    // }
                    else if (data.responseType == 5)
                    {
                        showSuccessMessage("Proposal successfully Forwarded for Final Verification !");
                        window.location = window.location;
                    }
                    else if (data.responseType == 6)
                    {
                        showErrorMessage("Proposal already Forwarded for Final Verification !");
                        window.location = window.location;
                    }
                    else if (data.responseType == 10)
                    {
                        showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
                        window.location = window.location;
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
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

