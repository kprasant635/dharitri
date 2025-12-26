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
            Settlement MB /
            <a href="<?= base_url()?>index.php/SettlementMbADC/SettlementKhasLandDc">Khas Land</a> /
            <a href="<?= base_url()?>index.php/SettlementMbADC/getAllProposalListSdlacKhas">SDLAC/CDLAC Report</a>
            / Process

            <a href="<?= base_url()?>index.php/SettlementMbADC/getAllProposalListSdlacKhas">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Go one step Back</button>
            </a>
        </div>



        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('khasLand') ?></span>
                <hr>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="proposalIdForward" value="<?php echo $proposal_no ?>">
                        <input type="hidden" id="service_code" value="<?=SLIJE_ID?>">

                        <?php echo $this->lang->line('sendingToSDLACByDc') ?> <?php echo $proposal_no ?>
                    </div>


                </div>
            </div>

            <div class="reza-body">

                <?php

                if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode'   width="100%">
                        <thead>
                        <tr>
                            <th width="5%">SL No.</th>
                            <th width="25%"><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th width="15%" class="center"><label class="control-label">Circle Name <br><?php echo $this->lang->line('submission_date'); ?></label></th>
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
                                    <?php echo $case->case_no; ?><br>
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
                                        <?php if($proposalDetails->meeting_create_status == 0): ?>
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
                                        <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/SettlementMbADC/viewApprovedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
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
                                        <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/SettlementMbADC/viewRejectedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
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
                                        <a class="btn btn-danger"  style="background-color: #263238" href="<?php echo base_url(); ?>index.php/SettlementMbADC/viewRejectedAppDetailsKhas/?case=<?php echo $case->case_no; ?>">
                                            <?php echo $this->lang->line('viewApp'); ?>
                                        </a>
                                    </td>
                                <?php endif ;?>
                                <td>

                                    <?php if ($case->case_status == 0) { ?>
                                        <textarea rows='2' class="form-control" style="display: none;" name="remarks<?=$case->id?>" id="remarks<?=$case->id?>" readonly></textarea>
                                    <?php } else { ?>
                                        <textarea rows='2' class="form-control" style="display: none;" name="remarks<?=$case->id?>" id="remarks<?=$case->id?>" readonly></textarea>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>


                <br>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                        <?php if(SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON == 1) { ?>
                            <?php if($proposalDetails->final_verify_status == 0 && $proposalDetails->meeting_create_status == 0): ?>
                                <button  class="btn btn-md btn-primary" id="finalSubmit" >
                                    <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Forward For SDLAC/CDLAC Minutes
                                </button>
                            <?php endif; ?>
                            <?php if($proposalDetails->meeting_create_status == 1): ?>
                                <h5>This Proposal would be available under process SDLAC/CDLAC Minutes</h5>
                            <?php endif; ?>

                        <?php } else { ?>
                            <button  class="btn btn-md btn-primary" id="noProcess" >
                                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Forward For SDLAC/CDLAC Minutes
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <br>


            </div>
        </div>
    </div>
</div>



<!-- Modal update hearing date -->
<div class="modal" role="dialog" id="updateHearingDateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Update New Hearing Date
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">
                        <!-- <input type="hidden" id="proposalId" value="<?php echo $proposal_no ?>"> -->

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Hearing Date</label>
                            <input type="date" class="form-control" name="w3date" id="date" required  min="<?php echo date("Y-m-d");?>" > </input>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-top: 15px">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="sendRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="updateModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="updateModalYes">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal view notice -->
<div class="modal" role="dialog" id="viewNoticeModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body" id="printableArea">

                <div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            <u>আবেদনকাৰী ৰায়ত আৰু পট্টাদাৰৰ শুনানিৰ বাবে জাননী</u>
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            জাননী নং (Proposal ID)-
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold;" id="proposalSequenceNo"></span>
                            <input type="hidden" id="proposalSequenceNoVal" value="">
                        </div>
                    </div>
                    <div class="row mt-2 px-5">
                        <div class="col-3">
                            তাৰিখ -
                        </div>
                        <div class="col-3">
                            <b><?=date('d-m-Y')?></b>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-justify p-5">
                            'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী নিয়ম, ১৯৭২ৰ ১০ নং নিয়ম অনুসৰি জাৰি কৰাএই জাননীৰ জৰিয়তে আপোনালোকক জনোৱা  হ'ল যে, ৰায়ত শ্ৰীয়ে, পট্টাদাৰ শ্ৰী
                            ৰ, জমিত 'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী আইন'ৰ অধীনত ২৩ নং ধাৰামতে মালিকীস্বত্ব লাভৰ বাবে আৱেদন কৰিছে। এই ক্ষেত্ৰত শুনানিৰ বাবে <b><span id="hearingDateShow"></span></b> তাৰিখটো ধাৰ্য কৰা হৈছে। গতিকে আপোনালোকক যাৱতীয় নথিপত্ৰসহ উক্ত দিনত চক্ৰ বিষয়াৰ কাৰ্যালয়ত উপস্থিত থাকিবলৈ অনুৰোধ জনোৱা হ'ল।
                        </div>
                    </div>

                    <div class="row px-5">
                        <div class="reza-title-modal">
                            <?php echo $this->lang->line('caseList') ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 noticePadding px-5">

                            <table class="" style="font-weight:bold;">
                                <tbody id="caseTable">

                                </tbody>

                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 noticePadding">
                            <br>
                            <b>Remarks</b>      - <span id="remarksShow"></span>
                        </div>
                    </div>
                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            District Commissioner <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="noticeSaveModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="noticeSaveModalYes">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;SAVE NOTICE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for final submission -->
<div class="modal" role="dialog" id="finalSubmissionModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Process Status for Proposal No.
                    <br>
                    <b><?=$proposalDetails->proposal_name?></b>
                </h5>
                <i class="fa fa-close fa-2x text-red closeFinalModal" style="cursor:pointer;"></i>
            </div>
            <div class="modal-body" align="center">
                <br>
                <h5>This Proposal will be made final & will be listed under process SDLAC/CDLAC Minutes</h5>
                <br>
                <h3>Are You Sure !</h3>
            </div>
            <br><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeFinalModal" >NO</button>
                <button type="submit" id="onlineForwardToSdlac" class="btn btn-primary" >YES</button>
            </div>


        </div>
    </div>
</div>

<!-- Hardcoded mgs show -->
<div class="modal" role="dialog" id="hardcodedModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Proposal Forward to Process
                </h5>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-12 text-center" style="color: red; font-weight: bold">

                        SDLAC/CDLAC Meeting Minutes Template Not Available
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="hardcodedModalNo">CLOSE</button>
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
            timer: 8000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 50000,
            showCancelButton: true

        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 50000,
            showConfirmButton: true,
        });
    }


    // hardcoded mgs show
    $(document).on('click','#noProcess',function (){
        $('#hardcodedModal').modal('show');
    });
    // hardcoded mgs show
    $(document).on('click','#hardcodedModalNo',function (){
        $('#hardcodedModal').modal('hide');
    });



    // ****************************************************************
    // update hearing date
    $(document).on('click','#changeHearDate',function ()
    {
        $('#updateHearingDateModal').modal('show');
    });

    $(document).on('click','#updateModalNo',function ()
    {
        $('#updateHearingDateModal').modal('hide');
    });

    // get notice
    $(document).on('click','#updateModalYes',function ()
    {
        $('#updateHearingDateModal').modal('hide');

        var remarks     = $("#sendRemarks").val();
        var hearingDate = $("#date").val();
        var proposalNo  = $("#proposalId").val();

        if(remarks == '')
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }
        if(proposalNo == '')
        {
            showErrorMessage("There is some problem, Please refresh your browser !");
        }
        else
        {
            const applicant = {
                proposalNo: proposalNo,
                remarks: remarks,
                hearingDate: hearingDate

            };
            $.ajax({
                url: BASE_URL + "/SettlementMbADC/updateProposalHearingDateKhas",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 2)
                    {
                        $('#viewNoticeModal').modal({backdrop: 'static', keyboard: false});
                        $('#viewNoticeModal').modal('show');

                        $("#hearingDateShow").html(data.hearingDate);
                        $("#remarksShow").html(data.remarks);
                        $("#proposalSequenceNo").html(data.proposalSequenceNo);
                        $("#proposalSequenceNoVal").val(data.proposalSequenceNo);

                        var table = '';
                        var sl    = 1;
                        $.each(data.caseList, function (i, val) {

                            table +=
                                '<tr>'+
                                '<td>' + sl +'. &nbsp;' + '</td>' +
                                '<td>' + val['case_no'] + '</td>' +
                                '</tr>';

                            sl = sl + 1;
                        });
                        $('#caseTable').html(table);

                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
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


    $(document).on('click','#noticeSaveModalNo',function ()
    {
        $('#viewNoticeModal').modal('hide');
    });


    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }



    // save new notice todo
    $(document).on('click','#noticeSaveModalYes',function ()
    {
        $('#sendToSDLACModal').modal('hide');

        var remarks     = $("#sendRemarks").val();
        var hearingDate = $("#date").val();
        var proposalNo  = $("#proposalId").val();

        var htmlString =$( "#printableArea" ).html();
        var htmlString = b64EncodeUnicode(htmlString);

        if(remarks == '')
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        if (proposalNo != '')
        {
            $('#viewNoticeModal').modal('hide');

            const applicant = {
                remarks: remarks,
                hearingDate: hearingDate,
                proposalNo: proposalNo,
                htmlstring_text : htmlString
            };

            $.ajax({
                url: BASE_URL + "/SettlementMbADC/updateHearingDateGenerateNoticeKhas",
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
                        showSuccessMessage("Hearing Date Successfully Updated");
                        window.location = window.location;
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
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
        else
        {
            showErrorMessage("Please Select Case !");
        }

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
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("There might be some pending case(s) under this Proposal !");
                    }
                    else if (data.responseType == 5)
                    {
                        showSuccessMessage("Proposal successfully Forwarded to DC for Final Verification !");
                        window.location = window.location;
                    }
                    else if (data.responseType == 6)
                    {
                        showErrorMessage("Proposal already Forwarded to DC for Final Verification !");
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



    function report_yes(id, case_no) {
        $('#remarks'+id).hide();
        $('#remarks'+id).val('');

        if(!confirm('All existing reject remarks selected by ADC/SDO will be deleted ! Are you sure to proceed with recommened option ?'))
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

        showNewRejectModalMb2(case_no, '<?= SLIJE_ID ?>')
    }



    $(document).on('click','#finalSubmit',function() {
        prop_id = $('#proposalIdForward').val();
        $.ajax({
            url: BASE_URL + "/SettlementMbADC/checkForSdlacStatus",
            dataType: "JSON",
            data: {prop_id : prop_id},
            type: "POST",
            success: function (data) {
                if (data.response == 1) {
                    showWarningMessage(data.message);
                }
                if (data.response == 2) {
                    $('#finalSubmissionModal').modal('show');
                }
            },
        });
    });

    $('.closeFinalModal').click(function(){
        $('#finalSubmissionModal').modal('hide');
    });



    // proposal ready fot create meeting for sdlac members todo
    $('#onlineForwardToSdlac').click(function(){

        var data = [];
        var proposalNo  = $('#proposalIdForward').val();
        var service_code = $('#service_code').val();

        //var uploadedFile = new FormData();

        <?php foreach ($cases as $case) { ?>
        var report_status = $('input:radio[name=report_status_'+<?=$case->id?>+']:checked').val();
        if(report_status == '')
        {
            showErrorMessage('All checks are mandatory');
            return false;
        }
        var id = $("#serial_id<?php echo $case->id?>").val();
        var report_status = report_status;
        var remarks = $('#remarks<?php echo $case->id?>').val();
        var case_no = $('#case_no_<?php echo $case->id?>').val();


        allData = {id,report_status,remarks,case_no};
        data.push(allData);
        <?php } ?>


        const applicant = {
            data: data,
            proposal_id: proposalNo,
            service_code: service_code

        };

        $.ajax({
            url: BASE_URL + "/SettlementMbADC/sdlacReportOnlineApprove",
            type: "post",
            contentType: "application/json",
            dataType: "json",
            success: function (data)
            {
                $('#finalSubmissionModal').modal('hide');
                if (data.response == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 101)
                {
                    showErrorMessage(data.message);
                }
                else if (data.response == 2)
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
                    window.location = BASE_URL + "/SettlementMbADC/getAllProposalListSdlacKhas";
                }
                })
                }
                else
                {
                    showErrorMessage(" SOMETHING WENT WRONG !");
                }
            },
            data: JSON.stringify(applicant)

        });
    });



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
                url: BASE_URL + "/SettlementCommonDc/applicationRemoveFromProposal",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 101)
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