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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
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
        padding: 0 .8rem;
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
        margin-bottom: 15px;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }
    .noticePadding{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px
    }
    .reza-title-modal{
        font-weight: bold;
        font-size: 18px;
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #37474F;
    }

    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process /
            Settlement MB 3.0/
            <a href="<?= base_url()?>index.php/SettlementProposalControllerIns/revertMeetingListForAdc">Reverted Meeting </a> /
            <a href="<?=base_url().'index.php/SettlementProposalControllerIns/getProposalUnderRevertedMeetingForAdc/?meetingId='. $proposalDetails->proposal_meeting_id ?>"> Proposals</a> /
            SDLAC/CDLAC Report
            <a class="btn btn-sm btn-danger pull-right" href="<?=base_url().'index.php/SettlementProposalControllerIns/getProposalUnderRevertedMeetingForAdc/?meetingId='. $proposalDetails->proposal_meeting_id ?>"><i class="fa fa-backward"></i>&nbsp; Go Back</a>

        </div>



        <div class="reza-card">
            <div class="reza-title">
                <span>Cases Under Reverted Proposal (<?=$proposalDetails->proposal_name?>) By DC</span>
                <hr>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="proposalIdForward" value="<?php echo $proposal_no ?>">
                        <input type="hidden" id="service_code" value="<?=SLIJE_ID?>">
                        Case List
                    </div>

                </div>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode'  width="100%">
                        <thead>
                        <tr>
                            <th width="5%">SL No.</th>
                            <th width="25%"><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th width="15%" class="center"><label class="control-label">Circle Name <br> <?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th width="15%" class="center"><label class="control-label">Status</label></th>
                            <th width="20%" class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            <th width="20%" class="center"><label class="control-label">Remarks (If No) </label></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    <a href="<?php echo base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=').$case->case_no ?>" class="">
                                        <?php echo $case->case_no; ?>
                                    </a>
                                    <span class='small font-italic red'><?php if ($case->case_no) {
                                            echo "Basundhara:" . $this->utilityclass->getApplidFromCaseNo($case->case_no);
                                        } ?> </span>
                                </td>
                                <td class="center">
                                    <?php echo $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code) ?>
                                    <br>
                                    <i class='fa fa-calendar'></i> <?php echo date('d-m-Y', strtotime($case->created_at)); ?>
                                </td>
                                <?php if($case->status == PRO_CASE_STATUS_PENDING) : ?>
                                    <td class="center">
                                            <span style="color: #37474F">
                                                <i class="fa fa-spinner fa-pulse " aria-hidden="true"></i> &nbsp;Pending
                                            </span>
                                    </td>
                                    <td>
                                        <input type="hidden" value="<?php echo $case->case_no?>" id="case_no_<?=$case->id?>">
                                        <?php if($proposalDetails->meeting_create_status == 2): ?>
                                            <input type="radio" name="report_status_<?=$case->id?>" id="report_status_yes<?=$case->id?>" onclick="report_yes(<?=$case->id?>, '<?=$case->case_no?>')" value="1" checked>&nbsp;Recommend
                                            <br>
                                            <input type="radio" name="report_status_<?=$case->id?>" id="report_status_no<?=$case->id?>" value="2" onclick="report_no(<?=$case->id?>,'<?=$case->case_no?>')"  <?php if($rejected_remark_list == true){ if((in_array($case->id, $cases_id))){ echo "checked";}}?>>&nbsp;Not Recommend
                                            <input type="hidden" value="<?=$case->id?>"  name="serial_id" id="serial_id<?=$case->id?>" >

                                            <br>
                                            <a id="removeCaseId<?=$case->id?>" onclick="removeCaseFromProposalList(<?=$case->id?>, '<?=$case->case_no?>')"  style="color: #F44336; text-decoration: none; cursor: pointer">
                                                <i class="fa fa-remove"></i>
                                                <b>Revert to CO</b>
                                            </a>
                                        <?php else: ?>
                                            <input disabled type="radio" name="report_status_<?=$case->id?>" id="report_status_yes<?=$case->id?>"  checked>&nbsp;Recommend
                                            <br>
                                            <input disabled type="radio" name="report_status_<?=$case->id?>" id="report_status_no<?=$case->id?>"  <?php if($rejected_remark_list == true){ if((in_array($case->id, $cases_id))){ echo "checked";}}?>>&nbsp;Not Recommend
                                        <?php endif; ?>

                                    </td>
                                <?php elseif ($case->status == PRO_CASE_STATUS_APPROVE) : ?>
                                    <td class="center">
                                            <span style="color: #2E7D32">
                                                <i class="fa fa-check-square" aria-hidden="true"></i> &nbsp;Approved
                                            </span>
                                    </td>
                                    <td class="center">
                                        <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/SettlementMbSdo/viewApprovedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
                                            <?php echo $this->lang->line('viewApp'); ?>
                                        </a>
                                    </td>
                                <?php elseif ($case->status == PRO_CASE_STATUS_REJECT) : ?>
                                    <td class="center">
                                            <span style="color: #C62828">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp;Rejected
                                            </span>
                                    </td>
                                    <td class="center">
                                        <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/SettlementMbSdo/viewRejectedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
                                            <?php echo $this->lang->line('viewApp'); ?>
                                        </a>
                                    </td>
                                <?php elseif ($case->status == PRO_CASE_STATUS_REVERTED) : ?>
                                    <td class="center">
                                            <span style="color: #263238">
                                                 <i class="fa fa-level-down" aria-hidden="true"></i> &nbsp;Reverted
                                            </span>
                                    </td>
                                    <td class="center">
                                        <a class="btn btn-danger"  style="background-color: #263238" href="<?php echo base_url(); ?>index.php/SettlementMbSdo/viewRejectedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
                                            <?php echo $this->lang->line('viewApp'); ?>
                                        </a>
                                    </td>
                                <?php endif ;?>
                                <td>

                                    <?php if ($case->case_status == 0) { ?>
                                        <textarea rows='2' class="form-control" style="display: none;"
                                                  name="remarks<?=$case->id?>" id="remarks<?=$case->id?>">উপলব্ধ নহয়</textarea>
                                    <?php } else { ?>
                                        <textarea rows='2' class="form-control"
                                                  style="display: none;"
                                                  name="remarks<?=$case->id?>" id="remarks<?=$case->id?>">উপলব্ধ নহয়</textarea>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <br>

            </div>
        </div>
    </div>
</div>


<!-- Revert to co & remove from proposal list  -->
<div class="modal" role="dialog" id="removeFromProposalModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Application Revert To CO
                </h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5 style="color: #F44336">You want to revert the <br>
                    Case :
                    <span id="showAppId" style="font-weight: bold"></span>
                    <br>
                    to CO
                </h5>
                <hr>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-top: 15px" align="left">
                    <label for="w3review" style="font-weight: bold">Enter Your Remarks <span style="color: red; font-weight: bold; font-size: 18px">*</span></label>
                    <textarea class="form-control" name="w3review" id="revertRemarks" rows="4" required minlength="1"> </textarea>
                </div>
                <input type="hidden" id="selectProposalId" value="" readonly>
                <input type="hidden" id="proCaseId" value="" readonly>
                <input type="hidden" id="appId" value="" readonly>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px">
                <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px">
                    Note: If you Revert this application to CO, this case would not be part of your current proposal. Then you have to generate new proposal for this application.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="removeFromProposalModalNo">Close</button>
                <button type="button" class="btn btn-success"  id="removeFromProposalModalYes">Yes, Revert</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
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

    // ****************************************************************



    function report_yes(id, case_no)
    {
        $('#remarks'+id).hide();
        $('#remarks'+id).val('');

        if(!confirm('All existing reject remarks selected by ADC/SDO will be deleted ! Are you sure to proceed with recommenced option ?'))
        {
            $('#report_status_no'+id).prop('checked', true);
            return false;
        }
        else
        {
            $.ajax({
                url: BASE_URL + "/RejectMb2NewController/deleteRejectRemarkOnConfirm",
                dataType: "JSON",
                data: {case_no : case_no, service_code: $('#service_code').val()},
                type: "POST",
                success: function (data) {
                    if (data.response == 0) {
                        showWarningMessage(data.message);
                    }
                    if (data.response == 2) {
                        showSuccessMessage(data.message);
                    }
                },
            });
        }

    }

    function report_no(id, case_no) {
        // $('#remarks'+id).show();
        $('#dharitreeCaseNo').val(case_no);
        //****to be changed in view main */
        $('#caseNoHtml1').html(case_no);

        $('#closeRejectModalId').remove();

        $('#rejectformNew').append('<input type="hidden" value="'+id+'" id="closeRejectModalId">');

        showNewRejectModalMb2(case_no, '<?php echo SLIJE_ID ?>')
    }


    // revert message
    function removeCaseFromProposalList(id, case_no)
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var proCaseId = id;
        var applicationNo = case_no;
        var selectProposalId = $('#proposalIdForward').val();

        $("#selectProposalId").val(selectProposalId);
        $("#appId").val(applicationNo);
        $("#proCaseId").val(proCaseId);

        $("#showAppId").html(applicationNo);

        $.unblockUI();
        $('#removeFromProposalModal').modal('show');

    }


    // revert to co & remove from proposal list
    $('#removeFromProposalModalYes').click(function()
    {
        if(!confirm("Are you sure to process ?"))
        {
            return true;
        }
        else
        {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            var proCaseId = $('#proCaseId').val();
            var applicationNo = $('#appId').val();
            var selectProposalId = $('#selectProposalId').val();
            var revertRemarks = $('#revertRemarks').val();

            const applicant = {
                proCaseId: proCaseId,
                applicationNo: applicationNo,
                revertRemarks: revertRemarks,
                selectProposalId: selectProposalId
            };

            $.ajax({
                url: BASE_URL + "/SettlementCommonIns/applicationRemoveFromRevertedProposal",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 2)
                    {

                        Swal.fire({
                            backdrop: true,
                            allowOutsideClick: false,
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                        }).then(function(result) {
                            if(result.isConfirmed){
                                location.reload(true);
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


    $('#removeFromProposalModalNo').click(function()
    {
        $('#removeFromProposalModal').modal('hide');
    });





</script>