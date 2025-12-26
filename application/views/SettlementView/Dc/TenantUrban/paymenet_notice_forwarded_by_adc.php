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
        background-color: #4CAF50;
    }
    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
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
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">


        <div class="reza-card">
            <div class="reza-title">
                <strong><?php echo $this->session->flashdata('message');?></strong>

                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <hr>
                <span>All payment notice pending cases</span>
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
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label">Hearing Remark Status</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr >
                                <td><?php echo $i ?> </td>
                                <td>
                                    <?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if ($case->applid) {
                                            echo "Basundhara:" . $case->applid;
                                        } ?> </span>
                                </td>
                                <td class="center"><i class='fa fa-calendar'></i> Submitted On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                <td class="center"><i class='fa fa-calendar'></i> 
                                    <?php 
                                        if(trim($case->note_action_yn) == 'y')
                                        {
                                            echo "<span class='alert-success'>Hearing remark Given by ADC</span>";
                                        }
                                        else
                                        {
                                            echo "-";
                                        }
                                    
                                    ?>
                                </td>
                                <td class="center">
                                    <?php //if($case->general_notice_dc == 'y'){ ?>
                                        <a class="rezaButt buttPrimary" href="<?php echo base_url(); ?>index.php/SettlementTenantUrbanDc/generatePaymentNoticeCaseView/?case=<?php echo $case->case_no; ?>">
                                            <i class="fa fa-cog" aria-hidden="true"></i>
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

<!-- Modal update hearing date -->
<div class="modal" role="dialog" id="generalNoticeModal">
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
                            <u>দখলীস্বত্ব থকা ৰায়তৰ মালিকীস্বত্ব আহৰণ</u>
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-12" style="font-size: 18px; font-weight:bold;">
                            আবেদনকাৰী ৰায়ত আৰু পট্টাদাৰৰ শুনানিৰ বাবে জাননী
                        </div>
                    </div><div class="row mt-5 px-5">
                        <div class="col-3">
                            জাননী নং -
                        </div>
                        <div class="col-3">
                            <span style="font-weight:bold; " id="case_no_show"></span>
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
                            'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী নিয়মাৱলী, ১৯৭২ৰ ১০ নং নিয়ম অনুসৰি জাৰি কৰা এই জাননীৰ জৰিয়তে আপোনালোকক জনোৱা  হ'ল যে,
                            ৰায়ত শ্ৰী <span style="font-weight:bold;" id="tableOwner"></span>

                            য়ে, পট্টাদাৰ শ্ৰী
                            <span id="tableBuyer" style="font-weight:bold;"></span>
                            ৰ,
                            <span style="font-weight:bold; " id="dist_name_show"></span>
                            জিলাৰ
                            <span style="font-weight:bold; " id="circle_name_show"></span>
                            ৰাজহ চক্ৰৰ
                            <span style="font-weight:bold; " id="mouza_name_show"></span>
                            মৌজাৰ
                            <span style="font-weight:bold; " id="village_show"></span>
                            গাৱঁৰ,

                            <span style="font-weight:bold; " id="patta_show"></span>
                            নং পট্টাৰ অন্তৰ্গত

                            <span style="font-weight:bold; " id="khatian_show"></span>
                            নং ৰায়তী খতিয়ানভুক্ত

                            <span style="font-weight:bold; " id="dag_show"></span> নং দাগৰ মুঠ
                            <span style="font-weight:bold; " id="bigha_show"></span> বিঘা
                            <span style="font-weight:bold; " id="katha_show"></span> কঠা
                            <span style="font-weight:bold; " id="lessa_show"></span> লেছা

                            জমিত 'অসম অস্থায়ী বন্দৱস্তি এলেকাৰ ৰায়তী আইন'ৰ অধীনত ২৩ নং ধাৰামতে মালিকীস্বত্ব লাভৰ বাবে আৱেদন কৰিছে। এই ক্ষেত্ৰত শুনানিৰ বাবে <b><span id="hearingDateShow"></span></b>
                            তাৰিখটো ধাৰ্য কৰা হৈছে। গতিকে আপোনালোকক যাৱতীয় নথিপত্ৰসহ উক্ত দিনত চক্ৰ বিষয়াৰ কাৰ্যালয়ত উপস্থিত থাকিবলৈ অনুৰোধ জনোৱা হ'ল।
                        </div>
                    </div>



                    <div class="row px-5">

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
                url: BASE_URL + "/SettlementTenantUrbanDc/generateGeneralNotice",
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
                        $("#case_no_show").html(data.notice_no);

                        $("#dist_name_show").html(data.dist_name.loc_name);
                        $("#circle_name_show").html(data.circle_name.loc_name);
                        $("#mouza_name_show").html(data.mouza_name.loc_name);
                        $("#village_show").html(data.village_name.loc_name);

                        $("#dag_show").html(data.get_dag_details.dag_no);
                        $("#bigha_show").html(data.get_dag_details.s_dag_area_b);
                        $("#katha_show").html(data.get_dag_details.s_dag_area_k);
                        $("#lessa_show").html(data.get_dag_details.s_dag_area_lc);
                        $("#patta_show").html(data.get_dag_details.patta_no);

                        $("#khatian_show").html(data.get_khatian.khatian_no);


                        var table = '';
                        $.each(data.get_buyers, function (i, val)
                        {
                            table +=
                                '<span>'+ '  '  + val['pdar_name']  + '  ,' +'</span>' ;
                        });
                        $('#tableBuyer').html(table);

                        var table1 = '';
                        $.each(data.get_owners, function (i, val)
                        {
                            table1 +=
                                '<span>'+ '  '  + val['pdar_name']  + '  ,' +'</span>' ;
                        });
                        $('#tableOwner').html(table1);
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
            url: BASE_URL + "/SettlementTenantUrbanDc/saveGeneralNoticeTenant",
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