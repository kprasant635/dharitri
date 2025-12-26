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


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <span><?php echo $this->lang->line('pgrVgrTitle') ?></span>
                        <hr>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
                        <span><?php echo $this->lang->line('proposalList') ?></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12" align="right">
                        <button class="rezaButt buttInfo" id="searchProId">
                            <i class="fa fa-search"></i> Search Proposal ID
                        </button>
                    </div>
                </div>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label">Hearing Date</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    Proposal No <?php echo $case->id; ?>
                                </td>

                                <td class="center">
                                    <i class='fa fa-calendar'></i>
                                     On <?php echo date('d-m-Y', strtotime($case->h_date)); ?>
                                </td>
                                <td class="center">
                                    <a class="btn btn-primary" target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getProposalNotice/?case=<?php echo $case->id; ?>">
                                        Print Notice
                                    </a>
                                    <a target="_blank" class="btn btn-info" style="background-color: #673AB7!important; color: white!important; border: none"
                                       href="<?php echo base_url(); ?>index.php/SettlementCommonDc/generateSdlacMinutesForProposal/?case=<?php echo $case->id; ?>">
                                        <?php echo $this->lang->line('generateMinutes'); ?>
                                    </a>
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/SettlementVgrPgrDc/getAllApplicationInReportSendByDcToSdlacVgrPgr/?case=<?php echo $case->id; ?>">
                                        <?php echo $this->lang->line('process'); ?>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>





    </div>
</div>


<!-- Proposal id search -->
<div class="modal" role="dialog" id="searchProIdModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Search Proposal Id With Case No.</h5>
            </div>
            <div class="modal-body" align="center">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="w3review" style="font-weight: bold">Search By Case ID</label>
                            <input class="form-control" name="" value="" id="caseId" placeholder=" KAM/PAL/2022-00/000/SAPNR"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center" style="margin-top: 15px">OR</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="w3review" style="font-weight: bold">Search By Application ID</label>
                            <input class="form-control" name="" value="" id="applicationId" placeholder=" RTPS/SAPH/2022/0000"/>
                        </div>
                    </div>
                    <div class="row" id="searchData">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center">
                            <hr>

                            <table class="" style="font-weight:bold; font-size: 18px">
                                <tbody id="caseTable">

                                </tbody>

                            </table>

                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="searchProIdModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="searchProIdModalYes">Search</button>
            </div>
        </div>
    </div>
</div>


<!--// NEW JS BY MASUD REZA-->
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



    // ****************************************************************
    // proposal id search by case no
    $(document).on('click','#searchProId',function ()
    {
        $('#searchProIdModal').modal({backdrop: 'static', keyboard: false});
        $('#searchProIdModal').modal('show');
    });

    $(document).on('click','#searchProIdModalNo',function ()
    {
        $('#searchProIdModal').modal('hide');
    });

    $(document).on('click','#searchProIdModalYes',function ()
    {
        const applicant = {
            caseNo: $("#caseId").val(),
            applicationNo: $("#applicationId").val(),
        };


        $.ajax({
            url: BASE_URL + "/SettlementCommonDc/searchProposalIdByAppCaseNo",
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

                    $('#searchProIdModal').modal({backdrop: 'static', keyboard: false});

                    var table = '';
                    var sl    = 1;
                    $.each(data.proposalIds, function (i, val) {

                        table +=
                            '<tr>'+
                            '<td style="font-size: 18px; font-weight: bold">' + sl +'. &nbsp;' + '</td>' +
                            '<td style="font-size: 18px; font-weight: bold">' + 'PROPOSAL ID - ' + val.proposal_id + '</td>' +
                            '</tr>';

                        sl = sl + 1;
                    });
                    $('#caseTable').html(table);
                }
                else if (data.responseType == 3)
                {
                    $('#searchProIdModal').modal('hide');
                    showErrorMessage("Data not found !");
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
