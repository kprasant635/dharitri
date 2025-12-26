<style>
    .datepick-popup {
	    z-index: 9999!important;
    }
</style>

<script>
    $(function () 
    {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>

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
                            <input type="text" readonly class="form-control ymd" name="w3date" id="date" required  min="<?php echo date("Y-m-d");?>" > </input>
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
                            এতেকে সৰ্বসাধাৰনক জনোৱা যাই যে, উক্ত উক্ত অসংৰক্ষিত কৰাৰ প্ৰস্তাৱ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপত্তি থাকে তেনেহলে এই জাননী জাৰি হোৱাৰ ৩০ (ত্ৰিশ) দিনৰ ভিতৰত লিখিতভাবে এই আদালতত দৰ্শাব। অন্যথা বিচাৰ কৰি নিস্পত্তি কৰা হব।
                            <br>
                            <br>

                            &nbsp;&nbsp;&nbsp;&nbsp;  আজি ইং<b><?=date('d-m-Y')?></b> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হল।
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            <?php 
                            if($this->session->userdata('user_desig_code') == 'ADC')
                            {
                                echo 'অতিৰিক্ত উপায়ুক্ত ';
                            }
                            elseif ($this->session->userdata('user_desig_code') == 'SDO')
                            {
                                echo 'মহকুমাধিপতি ';
                            }
                            ?>

                            <br>
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

<!-- Modal Notice hearing date -->
<div class="modal" role="dialog" id="generalNoticeModalReservation">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Generate Reservation Public Notice
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Hearing Date</label>
                            <input type="text" readonly class="form-control ymd" name="w3date" id="dateReservation" required  min="<?php echo date("Y-m-d");?>" > </input>
                            <input type="hidden" id="case_no_noticeReservation">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="updateModalNoReservation">Close</button>
                <button type="button" class="btn btn-primary"   id="updateModalYesReservation">Generate Notice</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" role="dialog" id="viewNoticeModalReservation">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body" id="printableAreaReservation">

                <div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            <u>জাননী</u>
                            <br>
                            <u>অসম ভুমি ও ৰাজহ অধিনিয়ম ১৮৮৬ ৰ অধীনত প্ৰণিত নিয়মাৱলীৰ ৮৫ বিধি অনুযায়ী জাননী</u>
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            প্ৰস্তাৱ নং-
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold; " id="case_no_showReservation"></span>
                        </div>
                    </div>
                    <div class="row mt-2 px-5">
                        <div class="col-3">
                            দৰ্খস্তকাৰীঃ
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold; " id="applicant_name_showReservation"></span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-justify p-5">
                            যিহেতুকে
                            <span style="font-weight:bold; " id="dist_name_showReservation"></span>
                            জিলাৰ
                            <span style="font-weight:bold; " id="circle_name_showReservation"></span>
                            ৰাজহ চক্ৰৰ
                            <span style="font-weight:bold; " id="mouza_name_showReservation"></span>
                            মৌজাৰ
                            <span style="font-weight:bold; " id="village_showReservation"></span>
                            গাৱঁৰ
                            <br><br>


                            <div id="caseTableReservation">

                            </div>

                            <br>
                            মাটি গাৱলীয়া চৰণীয়া পথাৰ হিচাপে সংৰক্ষিত কৰাৰ প্ৰস্তাৱ গ্ৰহন কৰা হৈছে। এই মৰ্মে এই আদালতত এক প্ৰস্তাৱ ৰেজিষ্টাৰভূক্ত কৰা হৈছে । এতেকে সৰ্বসাধাৰণক জনোৱা যায় যে, উক্ত সংৰক্ষণ ৰ প্ৰস্তাৱ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপত্তি থাকে তেনেহলে এই জাননী জাৰি হোৱাৰ ৩০ (ত্ৰিশ) দিনৰ ভিতৰত লিখিতভাবে এই আদালতত কাৰণ দৰ্শাব। অন্যথা বিচাৰ কৰি নিস্পত্তি কৰা হব।
                            <br>
                            <br>

                            &nbsp;&nbsp;&nbsp;&nbsp;  আজি ইং<b><?=date('d-m-Y')?></b> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হল।
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            <?php 
                            if($this->session->userdata('user_desig_code') == 'ADC')
                            {
                                echo 'অতিৰিক্ত উপায়ুক্ত ';
                            }
                            elseif ($this->session->userdata('user_desig_code') == 'SDO')
                            {
                                echo 'মহকুমাধিপতি ';
                            }
                            ?>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="noticeSaveModalNoReservation">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="noticeSaveModalYesReservation">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;SAVE NOTICE
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    function generateNotice(case_no)
    {
        $('#caseModal').hide();
 
        $('#generalNoticeModal').show();
        $("#case_no_notice").val(case_no);
    }

    $("#updateModalNo").click(function()
    {
        $('#generalNoticeModal').hide();
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
            return false;
        }
        else
        {
            const applicant = {
                hearingDate: hearingDate,
                case_no: case_no
            };
            $.ajax({
                url: baseurl + "SettlementVgrPgrADC/generateGeneralNotice",
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
                        $('#viewNoticeModal').modal({backdrop: 'static', keyboard: false});
                        $('#viewNoticeModal').show();

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
                 
                        table = data.deReserveDetails;

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


</script>

<script>

    function b64EncodeUnicode(str)
    {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }

    $(document).on('click','#noticeSaveModalNo',function ()
    {
        $('#viewNoticeModal').hide();
    });
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
            return false;
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
            return false;
        }

        $('#viewNoticeModal').hide();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        const applicant = {
            case_no: case_no,
            hearingDate: hearingDate,
            htmlstring_text : htmlString
        };

        $.ajax({
            url: baseurl + "SettlementVgrPgrADC/saveGeneralNoticeVgrPgr",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $.unblockUI();

                if (data.responseType != 2)
                {
                    showErrorMessage(data.msg);
                    return false;
                }
                else
                {
                    showSuccessMessage("Notice successfully generated");
                    window.location.reload();

                }
            },
            data: JSON.stringify(applicant)

        });
    });

    // for reservation notice
    $(document).on('click','#noticeSaveModalYesReservation',function ()
    {

        var htmlPrintArea = $( "#printableAreaReservation" ).html();
        var htmlString = b64EncodeUnicode(htmlPrintArea);
        var hearingDate = $("#dateReservation").val();
        var case_no = $("#case_no_noticeReservation").val();
        if(htmlString == '')
        {
            $('#viewNoticeModalReservation').modal('hide');
            showErrorMessage("SOMETHING WENT WRONG");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        $('#Reservation').modal('hide');

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        const applicant = {
            case_no: case_no,
            hearingDate: hearingDate,
            htmlstring_text : htmlString
        };

        $.ajax({
            url: baseurl + "SettlementVgrPgrADC/saveGeneralNoticeVgrPgrReservation",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage("There is some problem, Please try again");
                }
                else if (data.responseType == 2)
                {
                    showSuccessMessage("Notice successfully generated");
                    window.location.reload();

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

    $(document).on('click','#updateModalYesReservation',function ()
    {
        $('#generalNoticeModalReservation').hide();
        var hearingDate = $("#dateReservation").val();
        var case_no = $("#case_no_noticeReservation").val();

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
                url: baseurl + "SettlementVgrPgrADC/generateGeneralNoticeReservation",
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
                        $('#viewNoticeModalReservation').modal({backdrop: 'static', keyboard: false});
                        $('#viewNoticeModalReservation').show();

                        $("#hearingDateShowReservation").html(data.hearing_date);
                        $("#applicant_name_showReservation").html(data.applicantName.pdar_name);
                        $("#case_no_showReservation").html(data.notice_no);

                        $("#dist_name_showReservation").html(data.dist_name.loc_name);
                        $("#circle_name_showReservation").html(data.circle_name.loc_name);
                        $("#mouza_name_showReservation").html(data.mouza_name.loc_name);
                        $("#village_showReservation").html(data.village_name.loc_name);

                        $("#dag_showReservation").html(data.get_dag_details.dag_no);
                        $("#bigha_showReservation").html(data.get_dag_details.s_dag_area_b);
                        $("#khatha_showReservation").html(data.get_dag_details.s_dag_area_k);
                        $("#lessa_showReservation").html(data.get_dag_details.s_dag_area_lc);

                        var table = '';
                 
                        table = data.deReserveDetails;

                        $('#caseTableReservation').html(table);

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

    $("#updateModalNoReservation").click(function()
    {
        $('#generalNoticeModalReservation').hide();
    });

    function generateNoticeReservation(case_no)
    {
        $('#generalNoticeModalReservation').show();
        $("#case_no_noticeReservation").val(case_no);
    }

    $(document).on('click','#noticeSaveModalNoReservation',function ()
    {
        $('#viewNoticeModalReservation').hide();
    });


</script>

