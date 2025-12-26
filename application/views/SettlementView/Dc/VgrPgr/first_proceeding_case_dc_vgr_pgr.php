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
    .buttInfo {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        line-height: 35px;
        padding: 0 .8rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        /*text-transform: uppercase;*/
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
        margin-bottom: 5px!important;
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


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process / 
            Settlement MB / 
            <a href="<?= base_url()?>index.php/SettlementVgrPgrADC/SettlementVgrPgrLandDc">PGR VGR</a> / 
            <a href="<?= base_url()?>index.php/SettlementVgrPgrADC/viewAllVgrPgrFirstProceedingDCCaseList">First Proceeding</a>

            <a href="<?= base_url()?>index.php/SettlementVgrPgrADC/SettlementVgrPgrLandDc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('pgrVgrTitle') ?></span>
                <hr>
                <span><?php echo $this->lang->line('pendingSetCases') ?></span>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <!-- <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%"> -->
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

                            <th class="center"><?php echo $this->lang->line('submission_date'); ?>

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

                            
                            <th class="center">Action

                                <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>
                                    Search</button>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<!-- Modal Notice hearing date -->
<div class="modal" role="dialog" id="generalNoticeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Generate Public Notice
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Hearing Date</label>
                            <input type="date" class="form-control" name="w3date" id="date" required  min="<?php echo date("Y-m-d");?>" > </input>
                            <input type="hidden" id="case_no_notice">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="updateModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="updateModalYes">Generate Notice</button>
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
                            <u>জাননী</u>
                            <br>
                            <u>ৰাজহ আইনৰ ৯৫(A) নং ধাৰা অনুজায়ী জাননী</u>
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            প্ৰস্তাৱ নং -
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold; " id="case_no_show"></span>
                        </div>
                    </div>
                    <div class="row mt-2 px-5">
                        <div class="col-3">
                            দৰ্খস্তকাৰীঃ -
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold; " id="applicant_name_show"></span>
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
                            যিহেতুকে
                            <span style="font-weight:bold; " id="dist_name_show"></span>
                            জিলাৰ
                            <span style="font-weight:bold; " id="circle_name_show"></span>
                            ৰাজহ চক্ৰৰ
                            <span style="font-weight:bold; " id="mouza_name_show"></span>
                            মৌজাৰ
                            <span style="font-weight:bold; " id="village_show"></span>
                            গাৱঁৰ
                            <br><br>


                            <div id="caseTable">

                            </div>

                            <br>
                            মাটি সংৰক্ষিত
                            গাৱলীয়া গোপাচাৰৰ পৰা অসংৰক্ষিত কৰাৰ প্ৰস্তাৱ গ্ৰহন কৰা হৈছে এই মৰ্মে এই আদালতত এক প্ৰস্তাৱ ৰেজিষ্টাৰভূক্ত কৰা হৈছে ।
                            এতেকে সৰ্বসাধাৰনক জনোৱা যাই যে, উক্ত উক্ত অসংৰক্ষিত কৰাৰ প্ৰস্তাৱ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপত্তি থাকে তেনেহলে এই জাননী
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            উপায়ুক্ত <br>
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
        var service_code = <?= SETTLEMENT_PGR_VGR_LAND_ID ?>;
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
                url: base_url+'index.php/SettlementVgrPgrADC/firstProceedingPaginationAPI',
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

    $(document).on('click','.case_no',function ()
    {
        var case_no = $(this).val();
        $("#case_no_notice").val(case_no);
        $('#generalNoticeModal').modal('show');
    });



    $(document).on('click','#updateModalNo',function ()
    {
        $('#generalNoticeModal').modal('hide');
    });

    // get notice
    $(document).on('click','#updateModalYes',function ()
    {
        $('#generalNoticeModal').modal('hide');
        var hearingDate = $("#date").val();
        var case_no = $("#case_no_notice").val();

        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }
        else
        {
            const applicant = {
                hearingDate: hearingDate,
                case_no: case_no
            };
            $.ajax({
                url: BASE_URL + "/SettlementVgrPgrADC/generateGeneralNotice",
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
                        $('#viewNoticeModal').modal({backdrop: 'static', keyboard: false});
                        $('#viewNoticeModal').modal('show');

                        $("#hearingDateShow").html(data.hearing_date);
                        $("#applicant_name_show").html(data.applicantName.pdar_name);
                        $("#case_no_show").html(data.notice_no);

                        $("#dist_name_show").html(data.dist_name.loc_name);
                        $("#circle_name_show").html(data.circle_name.loc_name);
                        $("#mouza_name_show").html(data.mouza_name.loc_name);
                        $("#village_show").html(data.village_name.loc_name);

                        $("#dag_show").html(data.get_dag_details.dag_no);
                        $("#bigha_show").html(data.get_dag_details.s_dag_area_b);
                        $("#khatha_show").html(data.get_dag_details.s_dag_area_k);
                        $("#lessa_show").html(data.get_dag_details.s_dag_area_lc);

                        var table = '';
                        $.each(data.get_dag_details, function (i, val) {

                            table +=
                                '<div>'+
                                '<span>'  + '<b> ' + val['dag_no']  + '</b> ' + 'নং দাগৰ অংশ ' + '  ' +'</span>' +
                                '<span>'  + '<b> ' + val['bigha']  + '</b> ' + 'বিঘা' + '  ' +  '</span>' +
                                '<span>'  + '<b> ' + val['katha']  + '</b> ' + 'কঠা' + '  ' +  '</span>' +
                                '<span>'  + '<b> ' + val['lessa'] + '</b> '  + 'লেছা' + '  '  +  '</span>' +
                                '</div>';

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


    function b64EncodeUnicode(str)
    {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }

    // save new notice
    $(document).on('click','#noticeSaveModalYes',function ()
    {

        var htmlPrintArea = $( "#printableArea" ).html();
        var htmlString = b64EncodeUnicode(htmlPrintArea);
        var hearingDate = $("#date").val();
        var case_no = $("#case_no_notice").val();
        if(htmlString == '')
        {
            $('#viewNoticeModal').modal('hide');
            showErrorMessage("SOMETHING WENT WRONG");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        $('#viewNoticeModal').modal('hide');

        const applicant = {
            case_no: case_no,
            hearingDate: hearingDate,
            htmlstring_text : htmlString
        };

        $.ajax({
            url: BASE_URL + "/SettlementVgrPgrADC/saveGeneralNoticeVgrPgr",
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
                else if (data.responseType == 5)
                {
                    showSuccessMessage("Failed to save notice,, Please try again");
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




    });







</script>