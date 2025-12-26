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

        <button type="button" id="go-back" class="btn btn-sm btn-danger">&nbsp;Go Back</button>

        <!-- <a class="btn btn-sm btn-danger" href="<?=base_url().'index.php/SettlementMeetingControllerDc/meetingLandPage'?>"><i class="fa fa-backward"></i>&nbsp;Go Back</a> -->


        <div class="reza-card">
            <div class="reza-title"></div>
            <div class="reza-body">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" align="right">
                        <button class="rezaButt" id="uploadAdditionalFile" >
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            Upload Additional Document
                        </button>
                    </div>
                </div>


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
                    <tr>
                        <th colspan="1" style="width: 175px">Additional Documents</th>
                        <td colspan="3">
                            <?php foreach ($additionalDoc as $docs): ?>

                                <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$docs->id;?>" style="padding-right: 20px">
                                    <i class="fa fa-paperclip"></i> <b><?=$docs->file_name;?></b>
                                </a>

                            <?php endforeach; ?>
                        </td>
                    </tr>
                    </thead>
                </table>

                <table class="datatable table table-stripped" id='datatable'>
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
                                Process
                            </td>

                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>

            </div>
        </div>

        <!-- <a class="btn btn-sm btn-danger" href="<?=base_url().'index.php/SettlementMeetingControllerDc/meetingLandPage'?>"><i class="fa fa-backward"></i>&nbsp;Go Back</a> -->

        <button type="button" id="go-back1" class="btn btn-sm btn-danger">&nbsp;Go Back</button>


    </div>
</div>

<!-- view Cases -->
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

<!-- upload file  -->
<div class="modal" role="dialog" id="uploadAdditionalFileModal">
    <div class="modal-dialog modal-lg" role="document" style="width: 50%!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Additional Document </h5>
            </div>
            <div class="modal-body" align="left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Document Type  <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <select class="form-control" name="gurdDocType" id="gurdDocType">
                            <option selected disabled>Select</option>
                            <option value="1">Guardian Minister Signed Minutes</option>
                            <option value="2">Others Document</option>
                        </select>
                        <br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Document Title  <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <input type="text" placeholder="Please enter the name of the document" class="form-control"  id="fileText"  name="fileText" required minlength="3" maxlength="99">
                        <br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Select File <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <input type="file" class="form-control" id="fileUpload" name="fileUpload" required >
                    </div>
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="uploadAdditionalFileModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="uploadAdditionalFileModalYes" style="margin-top: 0px;">Submit</button>
            </div>
        </div>
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
            url: BASE_URL + "/SettlementMeetingControllerDc/viewCasesAgainstProposalNo",
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

                    let table = '';
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


    // upload additional file
    $(document).on('click','#uploadAdditionalFile',function ()
    {
        $('#uploadAdditionalFileModal').modal('show');
    });

    $(document).on('click','#uploadAdditionalFileModalNo',function ()
    {
        $('#uploadAdditionalFileModal').modal('hide');
    });

    $(document).on('click','#uploadAdditionalFileModalYes',function ()
    {

        if($('#meetingId').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#meetingName').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#gurdDocType').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#fileName').val() == '')
        {
            showErrorMessage("Please enter the name of the document !");
            $('#fileText').focus();
            return false;
        }
        else if($('#fileUpload').val() == '')
        {
            showErrorMessage("Please enter the name of the document !");
            $('#fileUpload').focus();
            return false;
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

            var uploadedFile = new FormData();
            uploadedFile.append("fileUpload", $('#fileUpload')[0].files[0]);
            uploadedFile.append("meetingId", $('#meetingId').val());
            uploadedFile.append("meetingName", $('#meetingName').val());
            uploadedFile.append("fileName", $('#fileText').val());
            uploadedFile.append("gurdDocType", $('#gurdDocType').val());

            $.ajax({
                url: BASE_URL + "/SettlementMeetingControllerDc/postAdditionalFileUnderMeetingDc",
                type: "post",
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data)
                {
                    $.unblockUI();
                    var data = JSON.parse(data);

                    $('#uploadAdditionalFileModal').modal('hide');

                    if (data.response == 1) { //for error message
                        showErrorMessage(data.message);
                    }
                    if (data.response == 2) { //if success
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
                        //location.reload(true);
                    }

                },
                data: uploadedFile
            });
        }


    });


    function finalApprove(meetingId)
    {
        var redirect_url = BASE_URL + "/SettlementMeetingControllerDc/meetingLandPage";
        Swal.fire({
            backdrop:true,
            allowOutsideClick: false,
            icon: 'warning',
            text: " This is the final action. All proposals & cases will be approve/reject based on conditions apply. Are you sure to process for approving this meeting id ? ",
            showCancelButton: true,
            confirmButtonText: 'Yes',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
            }
        }).then((result) => {
            if (result.isConfirmed) {
        loader();
        const params = {
            meetingId: meetingId
        };
        $.ajax({
            url: BASE_URL + "/SettlementMeetingControllerDc/finalApproveOfMeetingDetail",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1) // failed
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2) // success
                {
                    Swal.fire({
                        backdrop:true,
                        allowOutsideClick: false,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location.href = redirect_url;
                }
                });
                }

                else if (data.responseType == 3) { //for redirect cases, API failed
                    Swal.fire({
                        backdrop:true,
                        allowOutsideClick: false,
                        text: data.message,
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = redirect_url;
                    }
                });
                }

            },error: function (error) {
                showErrorMessage('Something went wrong.');
                $.unblockUI();
            },
            data: JSON.stringify(params)
        });
    }
    });
    }

    document.getElementById("go-back").addEventListener("click", () => {
      history.back();
    });
    document.getElementById("go-back1").addEventListener("click", () => {
      history.back();
    });

</script>
