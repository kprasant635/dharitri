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
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 640px;
            margin: 1.75rem auto;
        }
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


        <a class="btn btn-sm btn-danger" href="<?=base_url().'index.php/SettlementMeetingControllerDcIns/revertedMeetingByDepartmentForDC'?>"><i class="fa fa-backward"></i>&nbsp;Go Back</a>



        <div class="reza-card">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="reza-title">
                        All Reverted Cases By Department under Meeting (<?=isset($meetingName) ? $meetingName : 'N/A'; ?>)
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
                    <button  style="margin-right: 15px" class="rezaButt rezaPrim" type="button" onclick="openModalForRevertCases();">
                        <i class="fa fa-share"></i> Revert Cases To CO
                    </button>

                </div>
            </div>
            <hr style="margin-top: 0px!important;">

            <div class="reza-body">
                <?php if($caseCount == 0): ?>
                    <h5><br>No Cases Found !<br></h5>
                <?php else: ?>
                    <input type="hidden" name="meeting_id" id="meeting_id" value="<?=$meeting_id?>">
                    <input type="hidden" name="meeting_name" id="meeting_name" value="<?=trim($meetingName)?>">
                    <table class="datatable table table-stripped table-bordered" id='datatable_reverted_cases'>
                        <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="30%">Case No.</th>
                            <th width="50%">Remarks</th>
                            <th width="18%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;
                        foreach ($caselist as $caselist):  $i++  ?>

                            <tr>
                                <td><?php echo $i ?> </td>
                                <td style="font-weight: bold"><?php echo $caselist->case_no ?> </td>
                                <td><?php echo $caselist->note_on_order; ?> </td>
                                <td>
                                    <a href="<?php echo base_url() . "index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=".$caselist->case_no ?>" target="application-view" class="rezaButt rezaDag" >
                                        <i class="fa fa-eye"></i>
                                        View
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


<!-- Modal Accepted  Request -->
<div class="modal" role="dialog" id="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <form id="ajaxRevertedForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">All Cases Revert Back to CO </h5>
                </div>
                <div class="modal-body" align="">
                    <div class="row" align="center">
                        <h3>Are You Sure !</h3>
                        <br>
                        <h5 style="color: #2E7D32; margin-bottom: 25px"> You want to Revert all cases to CO
                            <br>
                            (Total No. of cases -  <?=isset($caseCount) ? $caseCount : 0;?>)
                            <input type="hidden" name="caseListRevert" id="caseListRevert">
                            <input type="hidden" name="meetingIdNew" id="meetingIdNew">
                        </h5>
                        <hr>
                    </div>

                    <form action="">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                                <textarea class="form-control"  name="dcRevertedRemarks" id="dcRevertedRemarks" rows="4" required minlength="1"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px">
                    <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; color: #E53935">

                        Note:
                        Cases already map with Proposal and Meeting,
                        If you revert,
                        then this cases would no longer be part of any Proposal and Meeting and case would revert back to CO.
                        <br>
                        <div style="margin-top: 10px; font-size: 17px">
                            You have to resign the Digital Minutes using DSC Token.
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="revertedModalNo">Close</button>
                    <button type="submit" class="btn btn-primary" id="revertedModalYes">Yes, Revert</button>
                </div>
            </div>
        </form>
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

    // show Reverted cases modal
    function openModalForRevertCases()
    {
        if($('#meeting_id').val() == null || $('#meeting_name').val() == null){
            alert("Something went wrong...");
            return false;
        }
        $.ajax({
            url: baseurl + "SettlementMeetingControllerDcIns/getAllDeptRevertedCases",
            type: 'post',
            dataType: 'json',
            data: {
                meeting_id: $('#meeting_id').val(),
                meeting_name: $('#meeting_name').val(),
            },
            success: function(data)
            {
                console.log(data.select_cases);

                if (data.responseType == 2)
                {
                    $("#caseListRevert").val(data.select_cases);
                    $("#meetingIdNew").val($('#meeting_id').val());
                }
                else
                {
                    showErrorMessage(data.msg);
                    location.reload();
                    return false;
                }
            },
        });

        $('#myLargeModalLabel').modal('show');
        var btn = document.getElementById("myBtn");
        // var span_close = document.getElementsByClassName("edit-enc-close")[0];

        // span_close.onclick = function()
        // {
        //     $("#caseListRevert").val('');
        //     $('#myLargeModalLabel').modal('hide');
        //
        // }
    }


    $('#ajaxRevertedForm').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to submit?"))
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
            url: baseurl + "SettlementMeetingControllerDcIns/finalDeptRevertedCaseRevertToCO",
            type: 'POST',
            data: $("#ajaxRevertedForm").serialize(),
            dataType: 'json',
            success: function (data)
            {
                $.unblockUI();
                if(data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if(data.responseType == 2)
                {
                    Swal.fire({
                        text: data.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Thank You',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location.href = baseurl+"SettlementMeetingControllerDcIns/revertedMeetingByDepartmentForDC";
                }})
                }
                else
                {
                    showErrorMessage(data.message);
                }
            },error: function (error)
            {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });


    $(document).on('click','#revertedModalNo',function ()
    {
        $('#myLargeModalLabel').modal('hide');
    });




    $('#search_by_filter').click(function(){
        $('#searchByFilterModal').modal('show');
    });

    $('#search_by_filter').click(function(){
        $('#searchByFilterModal').modal('show');
    });


    $('.search_button').click(function(){
        load_data();
    });

    $('#datatable_reverted_cases').DataTable();

    // load_data();






</script>
