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

    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
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


</style>


<div class="row" style='padding-top: 15px; margin-bottom: 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas" style="text-decoration: none">
            Khas Land /
        </a>
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/offlinePendingMeetingList" style="text-decoration: none">
            Pending Meeting List /
        </a>
        Meeting Details

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px">
            <div class="reza-card">
                <div class="reza-title">
                    <span>Meeting Details</span>
                </div>

                <div class="reza-body">
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <tbody>
                        <tr>
                            <td style="width: 25%">Meeting Name</td>
                            <td style="width: 25%; font-weight: bold"><?php echo $meetings->meeting_name ?></td>
                            <td style="width: 25%">Meeting Created By</td>
                            <td style="width: 25%; font-weight: bold"><?php echo $meetings->created_by ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Meeting Date</td>
                            <td style="width: 25%; font-weight: bold"><?php echo date('d-m-Y', strtotime($meetings->meeting_date)); ?></td>
                            <td style="width: 25%">Meeting Status</td>
                            <td style="width: 25%; font-weight: bold">
                                <?php if($meetings->meeting_status == 2): ?>
                                    Send to Department
                                <?php elseif($meetings->meeting_status == 1): ?>
                                    Pending with ADC
                                <?php else: ?>
                                    Under Process
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Meeting Venue</td>
                            <td style="width: 25%; font-weight: bold"><?php echo $meetings->venue ?></td>
                            <td style="width: 25%">Service</td>
                            <td style="width: 25%; font-weight: bold">
                                <?php if($meetings->service_code == OFFLINE_KHAS_LAND_ID): ?>
                                    Offline Khas Land
                                <?php else: ?>
                                    ---
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Remarks </td>
                            <td style="width: 75%" colspan="3"><?php echo $meetings->remarks  ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="reza-title">
                    <hr>
                    <span>Case Details</span>
                </div>

                <div class="reza-body">

                    <?php if ($casesCount == 0) : ?>
                        <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                    <?php else : ?>
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <tr>
                                <th>SL No.</th>
                                <th><label class="control-label">Application No</label></th>
                                <th class="center"><label class="control-label">SDLAC Recommendation</th>
                                <th class="center"><label class="control-label">SDLAC Recommendation Date</th>
                                <th class="center"><label class="control-label">Action</label></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ; foreach ($cases as $case): $i++ ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $case->case_no ?></td>
                                    <td style="font-weight: bold">
                                        <?php if($case->sdlac_rec == 1): ?>
                                            Recommended
                                        <?php elseif($case->sdlac_rec == 2): ?>
                                            Not Recommended
                                        <?php else: ?>
                                            Not Mention
                                        <?php endif; ?></td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($case->sdlac_rec_date )); ?>
                                    </td>
                                    <td>
                                        <?php $application_no = $this->offlineutility->encryptJwtcase($case->case_no); ?>
                                        <a target="_blank" class="btn btn-success" href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/getMyKhasApplicationDetails/?app=<?php echo $application_no; ?>">
                                            <i class="fa fa-eye"></i> <?php echo $this->lang->line('viewApp'); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                </div>

                <input type="hidden" id="meetingId" name="meetingId" value="<?php echo $meetings->id ?>">
                <br>

                <?php if($meetings->meeting_status == 1): ?>
                    <div class="col-lg-12 col-md-12 col-sm-12" align="right" style="padding-bottom: 30px">
                        <button class="rezaButt buttPrimary" id="meetingForward" >
                            <i class="fa fa-share"></i>&nbsp;Meeting Forward to Department
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Modal Forward this meeting to department -->
<div class="modal" role="dialog" id="submitApplicationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to forward this meeting to department</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="submitApplicationModalYes">Yes, Forward</button>
            </div>
        </div>
    </div>
</div>

<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
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

    // application submit confirmation
    $(document).on('click','#meetingForward',function ()
    {
        $('#submitApplicationModal').modal('show');
    });

    $(document).on('click','#submitApplicationModalNo',function ()
    {
        $('#submitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#submitApplicationModalYes',function ()
    {
        var meetingId = $('#meetingId').val();
        $('#submitApplicationModal').modal('hide');
        if (meetingId == '')
        {
            showErrorMessage("There is some problem !");
        }
        const applicant = {
            meetingId: meetingId
        };
        $.ajax({
            url: BASE_URL + "/OfflineSettlementCommonController/offlineMeetingForwardToDept",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {
                    var appNo = data.application;
                    var showMgs = 'Application (' + appNo +' ) Already Send to Offline Meeting !';
                    showErrorMessage(showMgs);
                }
                else if (data.responseType == 3)
                {
                    showSuccessMessage("Meeting successfully forwarded to Department");
                    window.location = window.location;
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });

    });


</script>