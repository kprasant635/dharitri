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


    .buttWarning {
        color: #FFF;
        background-color: #E57373;
    }
    .rezaInfo {
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

<div class="row" style='padding-top: 15px; margin-bottom: 20px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas" style="text-decoration: none">
            Khas Land /
        </a>

        Make Meeting

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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="reza-card">
                <div class="reza-title">
                    <span><?php echo $this->lang->line('offlineSettlementPenList') ?></span>
                    <hr>
                    <span><?php echo $this->lang->line('offlineSettlementKhasLandTitle') ?></span>
                </div>

                <div class="reza-body">
                    <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                    <?php if ($pendingCaseCount == 0) : ?>
                        <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                    <?php else : ?>
                    <table class="datatable table table-stripped" id='datatable' width="100%">
                        <thead>
                        <tr>
                            <th>All <input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                            <th>SL No.</th>
                            <th>Circle Name
                                <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="2">
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
                                        data-column-index="3">
                                    <option value="">Select Village </option>
                                </select>
                            </th>
                            <th><?php echo $this->lang->line('submission_date'); ?>
                            </th>
                            <th class="center">SDLAC Recommendation

                                <select class="form-control" data-column-index="2" id="remark_cat_lm"
                                        name="remark_cat_lm">
                                    <option value="">Select</option>
                                    <option value="1"> Recommended</option>
                                    <option value="2">Not Recommended</option>
                                </select>
                            </th>

                            <th><?php echo $this->lang->line('case_no'); ?>
                                <input type="text" id="by_case_no" name="by_case_no"
                                       class="form-control" placeholder="Search by Case No">
                            </th>


                            <th class="center">Action
                                <button type="button" class="search_button btn btn-sm btn-primary form-control"><i class="fa fa-search" aria-hidden="true"></i>
                                    Search
                                </button>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>

                    <br>

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" align="left">
                            <?php if(OFFLINE_MEETING_ENABLE_BUTTON == 1): ?>

                                <button class="rezaButt rezaInfo" id="sendToSDLAC">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    Make Offline Meeting
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<!-- Modal Mark as SDLAC -->
<div class="modal" role="dialog" id="sendToSDLACModal">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Make Meeting From Selected Cases
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Meeting Date </label>
                            <input type="datetime-local" class="form-control" name="w3date" id="date"   >
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Venue Name</label>
                            <input type="text" class="form-control" placeholder="Enter venue..." name="venue_name" id="venue" >
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

<!--Masud Script-->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>

<script type="text/javascript">
    $('#datatable').DataTable();

    $('#cir_id').change(function()
    {
        var base_url = "<?php echo base_url();?>";
        cir_id       = $('#cir_id').val();
        var villcode = cir_id.split(",");
        var circle   = villcode[0];
        var subdiv   = villcode[1];

        $.ajax({
            url: base_url+'index.php/OfflineSettlementCommonController/offlineVillageListCommon',
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
        var service_code = <?= OFFLINE_KHAS_LAND_ID ?>;

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
        var remark_cat_lm  = $('#remark_cat_lm').val();

        $('#datatable').DataTable().destroy();
        var table = $('#datatable').DataTable({

            'pageLength': 10,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language': {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax':{
                url: base_url+'index.php/OfflineSettlementCommonController/makeMeetingOfflineCasesAjax',
                type:'POST',
                data: {
                    service    : service_code,
                    circle     : circle,
                    subdiv     : subdiv,
                    mouza      : mouza,
                    lot        : lot,
                    vill_id    : vill_id,
                    case_no    : case_no,
                    remark_cat_lm : remark_cat_lm
                },
                deferLoading: 57,
            },

            order: [[2, 'asc']],

            columnDefs: [{
                targets: 0,
                checkboxes: {
                    'selectRow': true
                },
                data: "is_visible",
                'render': function (data, type, row) {
                    let text = row[0];
                    const myArray = text.split("/");
                    var arr = myArray[3];
                    return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+arr+' name="selectMark[]">';
                }
            }],

        });
    }

    $('.search_button').click(function(){
        load_data();
    });

    var selectedCheckBoxArray = [];
    $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
        var checkBoxId = $(this).val();
        var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
        if(this.checked && rowIndex === -1) {
            selectedCheckBoxArray.push(checkBoxId);
        }
        else if (!this.checked && rowIndex !== -1) {
            selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
        }
    });



    $("#checkedAll").click(function(){
        if(this.checked){
            $('.selectMark').each(function(){
                this.checked = true;
                var id = $(this).val();
                if($.inArray(id, selectedCheckBoxArray) !== -1){
                    // $('.selectMark').prop('checked', false);
                }else{
                    selectedCheckBoxArray.push(id);
                    $('.selectMark').prop('checked', true);
                }
            })
        }else{
            $('.selectMark').each(function(){
                this.checked = false;
                var id = $(this).val();
                var rowIndex = $.inArray(id, selectedCheckBoxArray);
                if(rowIndex == -1){

                }else{
                    selectedCheckBoxArray.splice(rowIndex, 1);
                    $('.selectMark').prop('checked', false);
                }
            })
        }
    });


    $("#datatable").on('draw.dt', function() {
        for (var i = 0; i < selectedCheckBoxArray.length; i++) {
            checkboxId = selectedCheckBoxArray[i];
            const myArray = checkboxId.split("/");
            var arr = myArray[3];
            $('#' + arr).attr('checked', true);
        }
    });


</script>


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




    // get notice view
    $(document).on('click','#sendToSDLACModalYes',function ()
    {
        $('#sendToSDLACModal').modal('hide');

        var remarks     = $("#sendRemarks").val();
        var hearingDate = $("#date").val();
        var venue = $('#venue').val();

        var selectedList = [];
        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });
        if (selectedList.length > 0)
        {
            const applicant = {
                selectedList: selectedCheckBoxArray,
                remarks: remarks,
                hearingDate: hearingDate,
                venue: venue
            };

            $.ajax({
                url: BASE_URL + "/OfflineSettlementCommonController/saveOfflineMeeting",
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
                        showSuccessMessage("Application successfully forwarded to Meeting");
                        window.location = window.location;
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
        var proposal_id = $("#proposalSequenceNoVal").val();

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

        var selectedMem = [];
        $('.selectMember:checked').each(function(i){
            selectedMem[i] = $(this).val();
        });
        if (selectedMem.length = 0)
        {
            showErrorMessage("Please Select SDLAC/CDLAC Member !");
        }

        if (selectedList.length > 0)
        {
            $('#viewNoticeModal').modal('hide');

            const applicant = {
                selectedList: selectedCheckBoxArray,
                remarks: remarks,
                hearingDate: hearingDate,
                htmlstring_text : htmlString,
                proposal_id : proposal_id
            };

            $.ajax({
                url: BASE_URL + "/NcKhasLandAdc/generateNoticeSendAllMarkAppToSDLACByDcKhasAdc",
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

</script>


