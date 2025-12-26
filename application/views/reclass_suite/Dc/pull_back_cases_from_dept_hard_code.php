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

    .custom-modal-width {
        max-width: 900px;
    }
    @media (min-width: 768px) {
        .custom-modal-width {
            width: 90%;
            max-width: 900px;
        }
    }

</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">



        <div class="reza-card">
            <div class="reza-title">
                <span>Pending Cases with Department for Pullback – Reclassification Suite </span>
                <hr>
            </div>

            <div class="reza-body">


                <table class="datatable table table-stripped" id='datatable'>
                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Circle Name
                            <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="0">
                                <option value="">Select Circle</option>
                                <?php
                                if(isset($location)){ foreach($location as $cir){
                                    ?>
                                    <option value="<?=$cir['cir_code'].",".$cir['subdiv_code']?>"><?=$cir['cir_name']?></option>
                                <?php }}?>
                            </select>
                        </th>

                        <th>Village Name
                            <select name="vill_id" class="form-control input_search" id="vill_id"
                                    data-column-index="1">
                                <option value="">Select Village </option>
                            </select>
                        </th>


                        <th class="center">LM Remark

                            <select class="form-control" data-column-index="2" id="remark_cat_lm"
                                    name="remark_cat_lm">
                                <option value="">Select Remark Category</option>
                                <option value="1">Can be Recommended</option>
                                <option value="2">Can not be Recommended</option>
                            </select>

                        </th>

                        <th class="center">CO Remark

                            <select class="form-control" data-column-index="2" id="remark_cat"
                                    name="remark_cat">
                                <option value="">Select Remark Category</option>
                                <option value="1">Can be Recommended</option>
                                <option value="2">Can not be Recommended</option>
                            </select>

                        </th>

                        <th><?php echo $this->lang->line('case_no'); ?>
                            <input type="text" id="by_case_no" name="by_case_no"
                                   class="form-control" placeholder="Search by Case No">
                        </th>


                        <th class="center">
                            Action
                            <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>
                                Search
                            </button>
                        </th>


                    </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>


<!-- Pull back case modal -->
<div class="modal" role="dialog" id="pullBackCaseModal" >
    <div class="modal-dialog custom-modal-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation for Case Pullback from Department </h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>
                    You want to Pull back the Case Number - <span id="caseNumber"></span>
                    <br>
                    Under
                    <br>
                    Proposal ID - <b><span id="revertProposalName"></span>, &nbsp;</b>

                    Meeting ID -  <b><span id="revertMeetingName"></span></b>
                    <br>
                    from the Department end & Revert it back to the CO
                </h5>
                <br>

                <input type="hidden" id="revertedMeetingId" value="">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                    <label for="w3review" style="font-weight: bold">Enter Your Remarks <span style="font-size: 18px; color: red">*</span></label>
                    <textarea class="form-control" name="w3review" id="pullBackRemarks" rows="4" required minlength="3"> </textarea>
                </div>
                <hr>
                <div class="row">
                    <div style="font-size: 17px; color: #EF5350; font-weight: bold; margin-top: 10px; margin-bottom: 10px">
                        <b>Note</b>:
                        Cases already map with  <b>Proposal</b> & <b>Meeting</b>,
                        If you Pull back and Revert to CO,
                        then this cases would no longer be part of any Proposal and Meeting and case would revert back to CO.
                        <br>
                        <div style="margin-top: 10px; font-size: 17px">
                            You have to resign the Digital Minutes using DSC Token.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="pullBackCasesModalNo">NO</button>
                <button type="button" class="btn btn-danger"   id="pullBackCasesModalYes">YES, PULL BACK & REVERT TO CO</button>
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



    // pull back nad revert back co confirmation modal
    $('#datatable').on('click', '.pullBackCasesModal', function ()
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

        $("#revertedMeetingId").val();

        const applicant = {
            meetingId: meetingId
        };

        $.ajax({
            url: BASE_URL + "/RelassSuiteMeetingControllerDc/getPullBackCaseDetailsHardCode",
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
                    $('#pullBackCaseModal').modal({backdrop: 'static', keyboard: false});
                    $('#pullBackCaseModal').modal('show');

                    $("#revertMeetingName").html(data.revertMeetingName);
                    $("#revertProposalName").html(data.revertProposalName);
                    $("#caseNumber").html(data.caseNumber);
                    $("#revertedMeetingId").val(data.meetingId);
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },

            data: JSON.stringify(applicant)

        });

    });



    // pull back  no
    $("#pullBackCasesModalNo").click(function()
    {
        $('#pullBackCaseModal').modal('hide');
    });


    // pull back final submit & case revert to CO
    $('#pullBackCasesModalYes').click(function(){

        if(!confirm("Do you want to Pull back & Revert it back to the CO ? Once done, this action cannot be undone !!"))
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

            var meetingId = $("#revertedMeetingId").val();
            var remarks   = $("#pullBackRemarks").val();

            if(meetingId == '')
            {
                showErrorMessage("SOMETHING WENT WRONG");
            }

            const applicant =
                {
                    meetingId: meetingId,
                    remarks: remarks,
                };


            $.ajax({
                url: BASE_URL + "/RelassSuiteMeetingControllerDc/finalPullBackRevertToCoSubmitHardCode",
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
                        $('#nomineeAddModal').modal('hide');
                        Swal.fire({
                            backdrop:true,
                            allowOutsideClick: false,
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
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


</script>


<script>

    $('#datatable').DataTable();

    $('#cir_id').change(function()
    {
        var base_url = "<?php echo base_url();?>";
        cir_id       = $('#cir_id').val();
        var villcode = cir_id.split(",");
        var circle   = villcode[0];
        var subdiv   = villcode[1];

        $.ajax({
            url: base_url+'index.php/SettlementCommonDc/villageListCommon',
            dataType: 'json',
            data: {
                subdiv_code: subdiv,
                cir_code: circle,
            },
            type: "POST",
            success: function(data) {

                if(data.responseType == 1){
                    var village_detail = "<option value=''>Select Village</option>";

                    $.each(data.location, function (i, val) {
                        village_detail +=
                            "<option value='"+ val["cir_code"] +","+ val["subdiv_code"] +","+ val["mouza_pargona_code"] +","+ val["lot_no"] +","+ val["vill_townprt_code"] +"'>"+val["loc_name"]+"</option>";
                    });
                    $('#vill_id').html(village_detail);
                }
            },
            error: function(error) { // runtime error message
                var village_detail = "<option value=''>Select Village</option>";
                $('#vill_id').html(village_detail);
            },
        });
    });

    load_data();

    function load_data(){
        var base_url     = "<?php echo base_url();?>";
        var service_code = <?= RECLASS_ID ?>;
        cir_code       = $('#cir_id').val();
        var newcircle = cir_code.split(",");
        cir_id       = $('#vill_id').val();
        var villcode = cir_id.split(",");
        var circle   = newcircle[0];
        var subdiv   = newcircle[1];
        var mouza    = villcode[2];
        var lot      = villcode[3];
        var vill_id  = villcode[4];
        var case_no  = $('#by_case_no').val();
        var rem_cat  = $('#remark_cat').val();
        var remark_cat_lm  = $('#remark_cat_lm').val();

        $('#datatable').DataTable().destroy();
        var table = $('#datatable').DataTable({

            'pageLength':10,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language': {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax':{
                url: base_url+'index.php/RelassSuiteMeetingControllerDc/pullBackCasesWithDeptPaginationAPIHardCode',
                type:'POST',
                data: {
                    service    : service_code,
                    circle     : circle,
                    subdiv     : subdiv,
                    mouza      : mouza,
                    lot        : lot,
                    vill_id    : vill_id,
                    case_no    : case_no,
                    remark_cat : rem_cat,
                    remark_cat_lm : remark_cat_lm
                },
                deferLoading: 57,
            },

            order: [[2, 'asc']],
            columnDefs: [{
                targets: "_all",
                orderable: false,
                "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
            }]

        });
    }

    $('.search_button').click(function(){
        load_data();
    });

</script>