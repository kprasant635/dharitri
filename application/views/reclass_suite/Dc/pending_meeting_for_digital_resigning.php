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
    }
    .rezaInfo {
        color: #FFF;
        background-color: #FFC107;
    }

    .rezaPrim {
        color: #FFF;
        background-color: #9C27B0;
    }
    .rezaDag {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        /*min-width: 150px;*/
        line-height: 37px;
        padding: 0 .8rem;
        /*font-size: 15px;*/
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        /*letter-spacing: 0.8px;*/
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
        margin-bottom: 5px;
        margin-left: 3px;
    }
    .rezaText {
        font-size: 16px;
    }

    .checkBoxD{

        width: 20px;
        height: 20px;
    }
    .reza-m{
        margin: 5px;
    }
</style>



<div class="row" style='padding: 40px 50px 40px 20px'>

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



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="reza-card">
            <div class="reza-title">All Pending Meeting for Digital Resigning</div>

            <div class="reza-body">
                <br>
                <?php if($meetingCount == 0): ?>
                    <h5><br>No Meeting Found !<br></h5>
                <?php else: ?>
                    <table class="datatable table table-stripped table-bordered" id='datatable'>
                        <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="10%">Meeting ID</th>
                            <th width="20%">Meeting Venue <br> Date</th>
                            <th width="8%">Forwarded By</th>
                            <th width="70%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;  foreach ($meetings as $meeting):  $i++  ?>

                            <tr>
                                <td><?php echo $i ?> </td>
                                <td style="font-weight: bold"><?php echo $meeting->meeting_name ?> </td>
                                <td>
                                    <?php echo $meeting->meeting_venue ?>
                                    <br>
                                    <?php echo date('d-m-Y', strtotime($meeting->meeting_date)) ?>
                                </td>
                                <td><?php echo $meeting->created_by ?> </td>
                                <td>
                                    <?php if($meeting->vgr_pgr_revert_status == 1): ?>
                                        <b style="color: #FF5252;">Some cases are Reverted back from this Meeting.</b>
                                        <br>
                                    <?php else: ?>
                                        <?php if($meeting->digital_sign_update_status == 1): ?>
                                            <a class="rezaButt btn btn-sm btn-danger showMinutesGenerateModal" data-id='<?php echo $meeting->id; ?>' style="color: #FFF;">
                                                Resign Digital Minutes
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getDigitalMinutesWithMeetingId/?meetingId=<?php echo $meeting->id; ?>"
                                           class="rezaButt btn btn-sm " style="color: #FFF; background-color: #9C27B0;" target="DigitalMinutes">
                                            <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Old Digital Minutes
                                        </a>
                                        <?php if($meeting->file_minute_path != '' && $meeting->file_minute_path != NULL): ?>
                                            <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/viewSdlacUploadedMinute/?meetingId=<?php echo $meeting->id; ?>"
                                               class="rezaButt btn btn-sm" style="background-color :#03A9F4" target="SdlacMinutes" >
                                                <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Uploaded Minutes
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/viewSdlacAttendance/?meetingId=<?php echo $meeting->id; ?>"
                                           class="rezaButt btn btn-sm " style="background-color :#3F51B5" target="SdlacAttendance">
                                            <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Attendance
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getResigningProposalsAgainstMeetingId/?meetingId=<?php echo $meeting->id; ?>"
                                       class="rezaButt btn btn-sm " style="background-color :#4CAF50" >
                                        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View Detail
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Modal for minute generate  -->
<div class="modal" role="dialog" id="minutesGenerateModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-body" id="print_direct">

                <div class="container bg-white divCard pb-3 " id="html1" style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Minutes of the meeting of SDLAC/CDLAC held on
                            <span style="font-weight:bold;" class="meetingDate"></span>
                            at
                            <span style="font-weight:bold;" class="timing"></span>
                            in the
                            <span style="font-weight:bold;" class="meetingVenue"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-bottom: 10px; margin-top: 15px">
                                Members Present as per list at Annexure - A:
                                <br>
                                List of Proposals Considered at Annexure - B:
                            </div>
                        </div>
                    </div>

                    <br>


                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px">
                                The meeting was presided over by  District Commissioner <span style="font-weight:bold;" class="districtName"></span>
                                & Chairman, SDLAC/CDLAC.
                                She/He welcomed all the members present in the meeting and apprised the house about the objectives of the meeting.
                                Initiating the discussion, the Chairman placed the settlement proposals of the individuals for each Revenue Circle
                                under  <span style="font-weight:bold;" class="subDivName"></span> Sub-Division in front of
                                the SDLAC/CDLAC for discussion and consideration.

                                <br>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                After threadbare discussion, following settlement proposals submitted by the
                                Revenue Circle Officers under  <span style="font-weight:bold;" class="subDivName"></span>
                                Sub-Division are recommended
                                unanimously by the SDLAC/CDLAC subject to fulfillment of
                                extant guidelines laid down in Mission Basundhara, Land Policy, 2019 and verification of
                                all related records/documents.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDiv">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Not Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDivNot">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" align="center">
                            <div class="rezaText2">
                                The meeting (<span style="font-weight:bold;" class="meetingName"></span>) ended with vote of thanks from the chair.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5 mrigankaRight">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC
                                <br>
                                Date <b><?=date('d-m-Y')?></b>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-12">
                                Memo No <span style="font-weight:bold;" class="memoName"></span>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <br>
                                Copy to:-
                            </div>
                        </div>


                        <div style="margin-bottom: 20px; padding-left: 85px">
                            <table style="width: 100%">
                                <tbody id="dlcCopyTo">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5 mrigankaRight">
                            <div class="col-3 text-center">
                                District Commissioner &
                                <br>
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " id="html2" style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Members Present as per list at Annexure - A
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Members Present
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="membersTable">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="row justify-content-end mrigankaRight mt-5">
                            <div class="col-3 text-center">
                                District Commissioner &
                                <br>
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " id="html3" style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            List of Proposals Considered at Annexure - B
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Proposal List
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="proposalListTable">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row"  id="reservationTable" style="display: none">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                VGR/PGR Reservation/De-Reservation details (Application wise)
                            </div>
                            <div id="individualCasesTable" class="rezaText" style="padding: 10px">

                            </div>

                            <div class="reza-title" style="margin-top: 25px">
                                VGR/PGR Reservation details(Circle wise)
                            </div>
                            <div id="totalReservationTable" class="rezaText" style="padding: 10px">

                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="row justify-content-end mrigankaRight mt-5">
                            <div class="col-3 text-center">
                                District Commissioner &
                                <br>
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <input type="hidden" id="meetingIdForDigitalSign" value="">
            <input type="hidden" id="areaVerified" value="">
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: 25px">
                        <button type="submit" id="minutesGenerateModalNo" class="rezaButt rezaInfo">
                            Close
                        </button>
                        <?php if($meeting->digital_sign_update_status == 1): ?>
                            <button type="submit" id="minutesGenerateModalYes" class="rezaButt rezaDag">
                                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp; Verify Area
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<form id="pdfForm">
    <textarea id="pdfData" cols="60" rows="8" style="display: none;"  readonly="readonly"></textarea>
    <input type="hidden" id="signingReason"
           name="signingReason" maxlength="20" />
    <input type="hidden" id="signingLocation" name="signingLocation" maxlength="20" />
    <input type="hidden" id="stampingX" name="stampingX" maxlength="20" value="200" />
    <input type="hidden" id="stampingY" name="stampingY" maxlength="20"
           value="200" />
    <select name="tsaurls" id="tsaurls" onchange="myFunction()" style="display:none">
        <option value="http://sha256timestamp.ws.symantec.com/sha256/timestamp">
            http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
        <option value="http://timestamp.comodoca.com/rfc3161">http://timestamp.comodoca.com/rfc3161</option>
        <option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161</option>
        <option value="http://timestamp.digicert.com">http://timestamp.digicert.com</option>
        <option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
    </select>
    <input type="hidden" id="tsaURL" name="tsaURL" value="" maxlength="100" style="width: 400px;" />
    <input type="hidden" id="timeServerURL" name="timeServerURL"
           value="https://basundhara.assam.gov.in/dscapi/getServerTime" maxlength="100" style="width: 400px;" />
    <input id="submitPdf" type="Submit" style="display: none;">
    <a id="downloadDiv" href='#' type="application/pdf" download="SignedPdf.pdf"></a>
    <input id="verifyPdfBtn" type="button" value=" Verify Pdf "  class="btn btn-danger">
    <div id="htmlstring_text" ></div>
</form>

<div class="col-sm-4">
    <div class="well-sm">
        <textarea id="signedPdfData" cols="60" rows="8" style="display: none" ></textarea>
        <textarea id="sdfsdPdfData" cols="60" rows="8"  style="display: none"></textarea>
        <textarea id="lblEncryptedKey" cols="60" rows="4" disabled style="display: none"></textarea>
        <textarea id="verificationResponse" cols="60" rows="8" disabled style="display: none"></textarea>
    </div>
</div>
<div id="panel"></div>

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

    function showErrorMessageHtml(text) {
        swal.fire({
            title: "Error!",
            html: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            showCancelButton: true
        });
    }


    // show minutes
    $('.showMinutesGenerateModal').click(function()
    {

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var meetingId = $(this).data('id');

        if(meetingId == '')
        {
            showErrorMessage("SOMETHING WENT WRONG");
        }

        const applicant = {
            meetingId: meetingId
        };
        $('#areaVerified').val(0);

        $.ajax({
            url: BASE_URL + "/RelassSuiteMeetingControllerDc/generateResignDigitalMinutesDc",
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

                    $('#minutesGenerateModal').modal({backdrop: 'static', keyboard: false});
                    $('#minutesGenerateModal').modal('show');
                    $(".districtName").html(data.districtName);
                    $(".subDivName").html(data.subDivName);
                    $(".meetingDate").html(data.meetingDate);
                    $(".meetingName").html(data.meetingName);
                    $(".memoName").html(data.memoName);
                    $(".timing").html(data.timing);
                    $(".meetingVenue").html(data.meetingVenue);
                    $("#meeting_id").val(data.meetingId);
                    $("#meetingIdForDigitalSign").val(data.meetingId);


                    // all DLC copy to
                    var tableDlc = '';
                    var slDlc    = 1;
                    $.each(data.userDlcList, function (i, val) {
                        tableDlc +=
                            '<tr>'+
                            '<td style="width: 3%">' + val.sl_no +'. &nbsp;' + '</td>' +
                            '<td>' + val.user_name + ', ' + val.user_desg + '</td>' +
                            '</tr>';

                        slDlc = slDlc + 1;
                    });
                    $('#dlcCopyTo').html(tableDlc);

                    //mriganka + Masud ---------------
                    if ((data.reservationDetails.length) != 0)
                    {

                        $('#reservationTable').show();
                        //*****case wise details */
                        var tbody = '';
                        var sl = 1;
                        var thead_r = '<tr>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Case No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">De-reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</th>' +
                            '</tr>';

                        var tbody_c = '';
                        var sl_c = 1;
                        var thead_c = '<tr>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Circle Name</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</th>'+
                            '</tr>';

                        for (var i = data.reservationDetails.length - 1; i >= 0; i--) {
                            var dd = data.reservationDetails[i];

                            $.each(dd.reservationDetails, function (i, val) {

                                var bklg_r = '';

                                if (val.isBarakValley == 1) {
                                    bklg_r = 'B:' + val.reservation_bigha + ', K:' + val.reservation_katha + ', C:' + val.reservation_lessa + ', G:' + val.reservation_ganda;
                                }
                                else {
                                    bklg_r = 'B:' + val.reservation_bigha + ', K:' + val.reservation_katha + ', L:' + val.reservation_lessa;
                                }

                                tbody +=
                                    '<tr>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + sl + '. &nbsp;' + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.case_no + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.village_name + ', ' + val.lot_name + ', ' + val.mouza_name + ', ' + val.cir_name + ', ' + val.subdiv_name + ', ' + val.dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.reservation_village_name + ', ' + val.reservation_lot_name + ', ' + val.reservation_mouza_name + ', ' + val.reservation_cir_name + ', ' + val.reservation_subdiv_name + ', ' + val.reservation_dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + bklg_r + '</td>' +
                                    '</tr>';

                                sl = sl + 1;
                            });

                            //****circle wise reservation details */

                            $.each(dd.reservationByCircleDetails, function (i, val) {
                                var bklg = '';
                                if (val.isBV == 1) {
                                    bklg = 'B:' + val.bigha + ', K:' + val.katha + ', C:' + val.lessa + ', G:' + val.ganda;
                                }
                                else {
                                    bklg = 'B:' + val.bigha + ', K:' + val.katha + ', L:' + val.lessa;
                                }
                                tbody_c +=
                                    '<tr>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + sl_c + '. &nbsp;' + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.cir_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.cir_name + ', ' + val.subdiv_name + ', ' + val.dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + bklg + '</td>' +
                                    '</tr>';

                                sl_c = sl_c + 1;
                            });
                        }

                        $('#individualCasesTable').html("<table class='table table-bordered'>" + thead_r + tbody + "</table>");

                        $('#totalReservationTable').html("<table class='table table-bordered'>" + thead_c + tbody_c + "</table>");

                    }
                    else
                    {
                        $('#reservationTable').hide();
                    }


                    // all member list
                    var tableMembers = '';
                    var slMembers    = 1;

                    $.each(data.nominee, function (i, val) {
                        var memName = '';
                        if(val.display_name != '')
                        {
                            memName = val.display_name;
                        }
                        else
                        {
                            memName = val.name +', ' + val.designation;
                        }
                        tableMembers +=
                            '<tr>'+
                            '<td>' + slMembers +'. &nbsp;' + '</td>' +
                            '<td>' + memName +'</td>' +
                            '</tr>';

                        slMembers = slMembers + 1;
                    });
                    $('#membersTable').html(tableMembers);


                    var proposalTable = '';
                    var sln    = 1;
                    $.each(data.proposalDetails, function (i, val) {

                        proposalTable +=
                            '<tr>'+
                            '<td>' + sln +'. &nbsp;' + '</td>' +
                            '<td>' + val.proposal_name + '</td>' +
                            '</tr>';

                        sln = sln + 1;
                    });
                    $('#proposalListTable').html(proposalTable);

                    if (data.caseList != null && data.caseList !='')
                        displayRecommendCases(data.caseList);
                    else
                        $('#caseDiv').html('--NILL--');
                    if (data.caseDivNot != null && data.caseDivNot !='')
                        displayNotRecommendCases(data.caseDivNot);
                    else
                        $('#caseDivNot').html('--NILL--');


                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });
    });


    // hide minutes
    $("#minutesGenerateModalNo").click(function()
    {
        $('#minutesGenerateModal').modal('hide');
    });


    // final submit & send proposal to dc
    $('#minutesGenerateModalYes').click(function(){

        if(!confirm("Do you want to Verify, Resign the meeting ?"))
        {
            return true;
        }
        else
        {

            var meetingIdDigital = $('#meetingIdForDigitalSign').val();
            var meeting_id = $("#meeting_id").val();
            const meetings = { meetingId: meetingIdDigital};
            if ($('#areaVerified').val()==1)
            {
                Swal.fire({
                    backdrop:true,
                    allowOutsideClick: false,
                    text: 'Area Verification Successfull. Do you want to resign the document ?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Approve & Sign',
                }).then((result) => {
                    if (result.isConfirmed)
                {
                    convertViewToPdf(meetingIdDigital);
                    return;
                }
            });
                return;
            }
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: BASE_URL + "/RelassSuiteMeetingControllerDc/verifyAreaForResignMinutes",
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
                        showErrorMessageHtml(data.message);
                    }
                    else if (data.responseType == 102)
                    {
                        Swal.fire({
                            backdrop:true,
                            title: "#MRNP01162<br>There is no case under proposals",
                            type: "warning",
                            position: 'top',
                            customClass: 'swal-wide',
                            allowOutsideClick: false,
                            html: (data.message)+'<br><br>  ' +
                            '<h4 style="color: red">Do you want to remove the proposals ? </h4>',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Remove',
                        }).then((result) => {
                            if(result.isConfirmed)
                        {
                            deleteProposalWithZeroCases(data.proIds,data.message);
                            return;
                        }
                    });
                    }
                    else if(data.responseType == 2)
                    {
                        $('#areaVerified').val(1);
                        Swal.fire({
                            backdrop:true,
                            allowOutsideClick: false,
                            text: 'Area Verification Successfull. Do you want to resign the document ?',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Resign Digital Minutes',
                        }).then((result) => {
                            if (result.isConfirmed)
                        {
                            convertViewToPdf(meetingIdDigital);
                            return;
                        }
                    });
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.unblockUI();
                    console.log(errorThrown);
                    alert("Status: " + textStatus);
                },
                data: JSON.stringify(meetings)
            });
        }

    });


    // remove proposal with zero case
    function deleteProposalWithZeroCases(proIds,message)
    {
        if(!confirm("Are you sure !, You want to remove the proposals ?"))
        {
            return true;
        }
        else
        {
            if(proIds == '' && message == '')
            {
                showErrorMessage("There is no proposal for Remove");
            }
            const cases = {
                proposalIds  : proIds,
                proposalName : message
            };

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: BASE_URL + "/RelassSuiteMeetingControllerDc/deleteProposalWithZeroCasesByDc",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();

                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if(data.responseType == 2)
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
                                location.reload(true);
                            }
                        });
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.unblockUI();
                    console.log(errorThrown);
                    alert("Status: " + textStatus);
                },
                data: JSON.stringify(cases)
            });
        }

    }



    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }

    // all Recommended case
    function displayRecommendCases(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px; ">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Existing class</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Nature of Possession</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Proposed Class</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {
            if (slNo == 1)
            {
                $(".subDivName").html(val.subdivname);
            }
            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 14px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' width='100%' style=\"border-collapse:collapse\">"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.existing_class + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.proposed_class + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.nature_of_possession + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDiv').html(html_table);
    }

    // all Not Recommended case
    function displayNotRecommendCases(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px; ">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Existing class</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Nature of Possession</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Proposed Class</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {

            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 14px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' width='100%' style=\"border-collapse:collapse\">"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.existing_class + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.proposed_class + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.nature_of_possession + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDivNot').html(html_table);
    }

    // convert the pdf digital minutes
    function convertViewToPdf(meetingIdDigital)
    {
        var html1 = $("#html1").html();
        var html2 = $("#html2").html();
        var html3 = $("#html3").html();
        var htmlString = b64EncodeUnicode(html1);
        const applicant =
            {
                meetingIdDigital: meetingIdDigital,
                html1: htmlString,
                html2: html2,
                html3: html3,
            };
        $.ajax({
            url: BASE_URL + "/RelassSuiteMeetingControllerDc/digitalResignAndSavePdf",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                //$.unblockUI();

                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if(data.responseType == 2)
                {
                    if (data.base64pdfdata != null || data.base64pdfData != '') {
                        dscSigner.sign(data.base64pdfData);
                    }
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //$.unblockUI();
                console.log(errorThrown);
                alert("Status: " + textStatus);
            },
            data: JSON.stringify(applicant)
        });
    }





    $('#search_by_filter').click(function(){
        $('#searchByFilterModal').modal('show');
    });


    $('.search_button').click(function(){
        load_data();
    });

    $('#datatable').DataTable();

    load_data();



</script>

<script type="text/javascript">
    function myFunction() {
        var x = document.getElementById("tsaurls").value;
        if (x != 0) {
            document.getElementById("tsaURL").value = x;
        } else {
            document.getElementById("tsaURL").value = "";
        }
    }
    $(document)
        .ready(function(){

            $('#verifyPdfBtn').hide();

            var initConfig = {
                "preSignCallback" : function() {
                    // do something
                    // alert('you are going to a sign a digital minute...');
                    // based on the return sign will be invoked
                    return true;
                },
                "postSignCallback" : function(alias, sign, key) {
                    $('#signedPdfData').val(sign);
                    $('#lblEncryptedKey').val(key);

                    // Implement signed pdf upload and pdf Download here
                    var requestData = {
                        action : "DECRYPT",
                        en_sig : sign,
                        ek : key
                    };
                    $.ajax(
                        {
                            url : dscapibaseurl+ "/pdfsignature",
                            type : "post",
                            dataType : "json",
                            contentType : 'application/json',
                            data : JSON.stringify(requestData),
                            async : true
                        })
                        .done(
                            function(data) {
                                // $.unblockUI();
                                if (data.status_cd == 1) {

                                    var jsonData = JSON.parse(atob(data.data));
                                    // console.log(jsonData);
                                    if (jsonData.status === "SUCCESS") {
                                        var pdfData = jsonData.sig;
                                        $('#sdfsdPdfData').val(pdfData);
                                        saveDataPDF(pdfData);

                                    }

                                } else {
                                    if (data.error.error_cd == 1002) {
                                        alert(data.error.message);
                                        return false;
                                    } else {
                                        alert("Decryption Failed for Signed PDF File");
                                        return false;
                                    }

                                }
                            }).fail(
                        function(jqXHR, textStatus,
                                 errorThrown) {
                            //$.unblockUI();
                            alert(textStatus);
                        });
                },
                signType : 'pdf',
                mode : 'nostampingv2'
                //"certificateSno" : 13705892,
            };
            dscSigner.configure(initConfig);




            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var data = e.target.result;
                        var base64 = data
                            .replace(/^[^,]*,/, '');
                        $("#pdfData").val(base64);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#pdfFile").change(function() {
                readURL(this);
            });

            function saveDataPDF(signedPdfData)
            {
                Swal.fire({
                    backdrop:true,
                    allowOutsideClick: false,
                    text: 'The Minute is successfully resigned !',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Update Status',
                }).then((result) => {
                    if (result.isConfirmed)
                {
                    saveFinalDataPDF(signedPdfData);
                }
            });
                return;
            }
            function saveFinalDataPDF(signedPdfData)
            {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });

                var meetingId = $('#meetingIdForDigitalSign').val();

                var requestData = {
                    action : "SAVE",
                    pdfData : signedPdfData,
                    meetingId : meetingId
                };
                $.ajax({
                    url : baseurl+ "RelassSuiteMeetingControllerDc/resignedFinalUpdatedMeetingByDC",
                    type : "post",
                    dataType : "json",
                    contentType : 'application/json',
                    data : JSON.stringify(requestData),
                    async : true,

                }).done(function(data)
                {
                    $.unblockUI();
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                        reload();
                    }
                    if (data.responseType == 2) {
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
                        reload();
                    }

                })
                    .fail(function(
                        jqXHR,
                        textStatus,
                        errorThrown) {
                        alert(textStatus);
                    });
            }

        });
</script>
