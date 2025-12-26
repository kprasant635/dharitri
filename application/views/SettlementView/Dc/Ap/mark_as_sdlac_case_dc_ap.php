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
    .checkBoxD{

        width: 20px;
        height: 20px;
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



</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementAP') ?></span>
                <hr>
                <span><?php echo $this->lang->line('markAsSDLACCases') ?></span>
            </div>

            <div class="reza-body">
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                    <thead>
                    <tr>
                        <th>All <input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                        <th>SL No.</th>
                        <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                        <tr id="caseNoData">
                            <td>
                                <input  type="checkbox" class="checkBoxD selectMark" value="<?php echo $case->case_no; ?>" id="" name="selectMark[]">
                            </td>
                            <td><?php echo $i ?> </td>
                            <td >
                                <?php echo $case->case_no; ?><br>
                                <span class='small font-italic red'><?php if ($case->applid) {
                                        echo "Basundhara:" . $case->applid;
                                    } ?> </span>
                            </td>
                            <td class="center"><i class='fa fa-calendar'></i> Submitted On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                            <td class="center">
                                <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/SettlementApDc/getSettlementApApplicationDetails/?case=<?php echo $case->case_no; ?>">
                                    <?php echo $this->lang->line('process'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>

                <br>

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" align="left">
                        <button class="rezaButt buttInfo" id="sendToSDLAC">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <?php echo $this->lang->line('sendToSDLAC') ?>
                        </button>
                    </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>
    </div>
</div>



<!-- Modal Mark as SDLAC -->
<div class="modal" role="dialog" id="sendToSDLACModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Recommended Cases For Make Proposal
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Hearing Date</label>
                            <input type="date" class="form-control" name="w3date" id="date" required > </input>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-top: 15px">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="sendRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="sendToSDLACModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="sendToSDLACModalYes">SUBMIT</button>
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


    // ****************************************************************
    // send to SDLAC
    $(document).on('click','#sendToSDLAC',function ()
    {
        $('#sendToSDLACModal').modal('show');
    });

    $(document).on('click','#sendToSDLACModalNo',function ()
    {
        $('#sendToSDLACModal').modal('hide');
    });

    $(document).on('click','#noticeSaveModalNo',function ()
    {
        $('#viewNoticeModal').modal('hide');
    });

    $("#checkedAll").click(function(){
        if(this.checked){
            $('.selectMark').each(function(){
                this.checked = true;
                $('.selectMark').prop('checked', true);
            })
        }else{
            $('.selectMark').each(function(){
                this.checked = false;
                $('.selectMark').prop('checked', false);
            })
        }
    });


    // get notice view
    $(document).on('click','#sendToSDLACModalYes',function ()
    {
        $('#sendToSDLACModal').modal('hide');

        var remarks     = $("#sendRemarks").val();
        var hearingDate = $("#date").val();

        if(remarks == '')
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        var selectedList = [];

        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        if (selectedList.length > 0)
        {
            const applicant = {
                selectedList: selectedList,
                remarks: remarks,
                hearingDate: hearingDate
            };

            $.ajax({
                url: BASE_URL + "/SettlementApDc/sendAllMarkAppToSDLACByDc",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 4)
                    {
                        showErrorMessage("No SDLAC/CDLAC Member available. Click on Back to menu and add SDLAC/CDLAC Member in Step 2 of the list and then process..");
                    }
                    else if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
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
                                '<td>' + val + '</td>' +
                                '</tr>';

                            sl = sl + 1;
                        });
                        $('#caseTable').html(table);

                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 10)
                    {
                        var appNoArea = data.application;
                        var showMgsArea = 'Applied area cannot exceed total chitha area ! (' + appNoArea +' )';
                        showErrorMessage(showMgsArea);
                    }
                    else if (data.responseType == 9)
                    {
                        var appNo = data.application;
                        var showMgs = 'Application (' + appNo +' )Already Send to SDLAC Committee !';
                        showErrorMessage(showMgs);
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


    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }



    // save notice and send case to sdlac
    $(document).on('click','#noticeSaveModalYes',function ()
    {
        $('#sendToSDLACModal').modal('hide');

        var remarks     = $("#sendRemarks").val();
        var hearingDate = $("#date").val();

        var htmlString =$( "#printableArea" ).html();
        var htmlString = b64EncodeUnicode(htmlString);
        var proposal_id =$("#proposalSequenceNoVal").val();

        if(remarks == '')
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        var selectedList = [];

        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        if (selectedList.length > 0)
        {
            $('#viewNoticeModal').modal('hide');

            const applicant = {
                selectedList: selectedList,
                remarks: remarks,
                hearingDate: hearingDate,
                htmlstring_text : htmlString,
                proposal_id : proposal_id
            };

            $.ajax({
                url: BASE_URL + "/SettlementApDc/generateNoticeSendAllMarkAppToSDLACByDcAp",
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
                        showSuccessMessage("Application successfully send to SDLAC");
                        window.location = window.location;
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
        else
        {
            showErrorMessage("Please Select Case !");
        }

    });

</script>