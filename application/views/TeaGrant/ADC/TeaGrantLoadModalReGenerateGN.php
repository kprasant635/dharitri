<style>
  
  .datepick-popup{
    position: fixed;
    left:0 px;
    right:0 px;
    z-index:10000;
  }

</style>
<div class="modal" role="dialog" id="reGeneratehearingRemarksModal">
    <div class="modal-dialog" role="document" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">
                        <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                          Select your preference: Old hearing date or reschedule with a new one ? 
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input regen_preference" type="radio" name="regen_preference" id="regen_preference1" value="OLD"/>
                              <label class="form-check-label" for="inlineRadio1">Old</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input regen_preference" type="radio" name="regen_preference" id="regen_preference2" value="NEW"/>
                              <label class="form-check-label" for="inlineRadio2">New</label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                        <div class="old_gn_date" style="display:none">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Notice Generated Date</label>
                            <input class="form-control ymd" type="text" name="regen_old_notice_gen_date" id="regen_old_notice_gen_date" 
                              value="<?=$notice_generated_date?>" placeholder='yyyy-mm-dd'>
                          </div>

                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Next Date of Hearing</label>
                            <input class="form-control ymd" type="text" name="regen_old_next_hearing_date" 
                              id="regen_old_next_hearing_date" value="<?=$next_date_of_hearing?>" placeholder='yyyy-mm-dd'>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Remarks (if any)</label>
                            <textarea class="form-control" rows="5" type="text" name="regen_old_remarks" id="regen_old_remarks"></textarea>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        </div>


                        <div class="new_gn_date" style="display:none">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Hearing Date</label>
                            <input type="text" class="form-control ymd" name="regen_new_notice_gen_date" id="regen_new_notice_gen_date" min="<?php echo date("Y-m-d");?>" placeholder='yyyy-mm-dd' >

                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Remarks (if any)</label>
                            <textarea class="form-control" rows="5" type="text" name="regen_new_remarks" id="regen_new_remarks"></textarea>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        </div>                        

                        <div class="col-md-12 text-bold">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="recommend"
                                value="<?=YES?>" checked>
                                <label>Can be Recommended</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="notrecommend"
                                value="<?=NO?>">
                                <label>Can not Recommended</label>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeReGenerateModal">Close</button>
                <button type="button" class="btn btn-primary" id="regenerateNotice">Re Generate Notice</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal view notice -->
<div class="modal" role="dialog" id="viewRegenerateNoticeModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body" id="printableArea">

                <div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            <u>Notice for Limited Conversion of Tea Grant Land to Periodic Patta</u>
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
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
                          <b><span id="regen_date"></span></b>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-justify p-5">

                            প্ৰতি
                            <b>
                                <?php
                                $position = 0;
                                $length = count($applicants_buyers);
                                foreach($applicants_buyers as $app){
                                    if($position == $length - 1){
                                        echo $app->pdar_name;
                                    }elseif($position == $length - 2){
                                        echo $app->pdar_name.' আৰু ';
                                    }else{
                                        echo $app->pdar_name.', ';
                                    }
                                    $position++;
                                }
                                ?>
                            </b>
                            পিতা/ স্বামী
                            <b>
                                <?php
                                $position = 0;
                                $length = count($applicants_buyers);
                                foreach($applicants_buyers as $app){
                                    if($position == $length - 1){
                                        echo $app->pdar_guardian;
                                    }elseif($position == $length - 2){
                                        echo $app->pdar_guardian.' আৰু ';
                                    }else{
                                        echo $app->pdar_guardian.', ';
                                    }
                                    $position++;
                                }
                                ?>
                            </b>
                            <br>
                            <br>


                            ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ৩.০ ৰ অধীনত Limited Conversion of Tea Grant Land to Periodic Patta সেৱাৰ বাবে নিম্নোক্ত তপচিলভুক্ত ভূমিৰ বাবে <?=date('d/m/Y', strtotime($basic['submission_date']))?> তাৰিখে আবেদন নং <b><?=$basic['applid']?> (<?=$basic['case_no']?>)</b> যোগে দাখিল কৰিছে।

                            <br><br>

                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) { ?>

                                যিহেতু <span style="font-weight:bold; " id="village_show"></span> গাৱঁৰ <span style="font-weight:bold; " id="patta_show"></span> নং পাট্টাৰ <span style="font-weight:bold;" id="message_show"></span> Tea Grant মাটিত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন  বিচাৰি দৰ্খাস্ত দাখিল কৰিছে আৰু সেই মৰ্মে এক নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন গোচৰ এই আদালতত ৰেজিস্টাৰভূক্ত হৈছে ৷ এতেকে সৰ্বসাধাৰণক জনোৱা যায় যে , উক্ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন গোচৰ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপওি থাকে তেনেহ’লে নিজে কিম্বা অধিবক্তাৰ দ্বাৰা ইং <span id="hearingDateShow"></span> এই আদালতত হাজিৰ হৈ লিখিত ভাবে কাৰণ দৰ্শাবহি ৷ অন্যথাই একপক্ষীয় ভাবে বিচাৰ কৰি নিস্পত্তি কৰা হ’ৱ ৷

                            <?php } else { ?>

                                যিহেতু <span style="font-weight:bold; " id="village_show"></span> গাৱঁৰ <span style="font-weight:bold; " id="patta_show"></span> নং পাট্টাৰ <span style="font-weight:bold;" id="message_show"></span> Tea Grant মাটিত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন  বিচাৰি দৰ্খাস্ত দাখিল কৰিছে আৰু সেই মৰ্মে এক নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন গোচৰ এই আদালতত ৰেজিস্টাৰভূক্ত হৈছে ৷ এতেকে সৰ্বসাধাৰণক জনোৱা যায় যে , উক্ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন গোচৰ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপওি থাকে তেনেহ’লে নিজে কিম্বা অধিবক্তাৰ দ্বাৰা ইং <span id="hearingDateShow"></span> এই আদালতত হাজিৰ হৈ লিখিত ভাবে কাৰণ দৰ্শাবহি ৷ অন্যথাই একপক্ষীয় ভাবে বিচাৰ কৰি নিস্পত্তি কৰা হ’ৱ ৷

                            <?php } ?>


                            
                            <br><br>

                            আজি ইং <span id="regen_date1"></span> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হ’ল ৷
                            <br><br>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>জিলা</th>
                                    <th>ৰাজহ চক্ৰ</th>
                                    <th>মৌজা</th>
                                    <th>লাট</th>
                                    <th>গাওঁ</th>
                                    <th class="text-center">পট্টা নং</th>
                                    <th class="text-center">পট্টা প্ৰকাৰ</th>
                                    <th class="text-center">দাগ নং</th>
                                    <th>কালি</th>
                                </tr>
                                </thead>
                                <tbody id="tbody_area_detail"></tbody>
                            </table>
                            <br>

                            জাননী পাবলগীয়া গৰাকী /সৰ্বসাধাৰণ : <span style="font-weight:bold;" id="tableNameList"></span>
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
                <button type="button" class="btn btn-secondary"  id="regenNoticeSaveModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="regenNoticeSaveModalYes">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;SAVE NOTICE
                </button>
                <input type="hidden" name="hearing_remarks" id="hearing_remarks" value="">
                <input type="hidden" name="regen_preference" id="regen_preference" value="">
                <input type="hidden" id="recommend_check" value="">
                <input type="hidden" id="hearing_re_date" value="">
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

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

    $(document).ready(function(){
        $('#reGeneratehearingRemarksModal').modal('show');
    });

    $("#closeReGenerateModal").on('click', function(){
        $('#reGeneratehearingRemarksModal').modal('hide');
    });

    $("input[name=regen_preference]").on("click", function () 
    {
      if ($("input[name=regen_preference]:checked").val() == "OLD") {
        $('.old_gn_date').show();
        $('.new_gn_date').hide();
      }
      else if ($("input[name=regen_preference]:checked").val() == "NEW") {
        $('.old_gn_date').hide(); 
        $('.new_gn_date').show();   
      }
    });

    // get notice
    // $(document).on('click','#regenerateNotice',function (){


    $('#regenerateNotice').click(function(){
        // alert("sdfghjk");
      $('#reGeneratehearingRemarksModal').modal('hide');

      var case_no_notice              = $('#case_no_notice').val();
      var regen_preference            = $("input[name='regen_preference']:checked").val();
      var regen_old_notice_gen_date   = $('#regen_old_notice_gen_date').val();
      var regen_old_next_hearing_date = $('#regen_old_next_hearing_date').val();
      var regen_old_remarks           = $('#regen_old_remarks').val();
      var regen_new_notice_gen_date   = $('#regen_new_notice_gen_date').val();
      var regen_new_remarks           = $('#regen_new_remarks').val();
      var recommend                   = $("input[name='recommend']:checked").val();

      if(regen_preference == null || regen_preference == '')
      {
        alert("Please select the hearing preference !!! ");
        $('.regen_preference').focus();
        return false;
      }
      else if(recommend == null || recommend == '')
      {
        alert("Please select recommend / not recommend !!! ");
        $('.recommend').focus();
        return false;
      }
      else
      {
        const params = {
          case_no_notice              : case_no_notice,
          regen_preference            : regen_preference,
          regen_old_notice_gen_date   : regen_old_notice_gen_date,
          regen_old_next_hearing_date : regen_old_next_hearing_date,
          regen_old_remarks           : regen_old_remarks,
          regen_new_notice_gen_date   : regen_new_notice_gen_date,
          regen_new_remarks           : regen_new_remarks,
          recommend                   : recommend,
        };

        // console.log(params);

        $.ajax({
          url         : BASE_URL + "/TeaGrantControllerAdc/reGenerateGeneralNoticeTeaGrant",
          type        : "post",
          dataType    : "json",
          contentType : "application/json",
          success     : function (data) {

            if (data.responseType == 1)
            {
              showErrorMessage("There is some problem, Please try again");
            }
            else if (data.responseType == 2)
            {
              $('#viewRegenerateNoticeModal').modal({backdrop: 'static', keyboard: false});
              $('#viewRegenerateNoticeModal').modal('show');

              $("#hearingDateShow").html(data.next_regen_date);
              $("#case_no_show").html(data.notice_no);

              $("#dist_name_show").html(data.dist_name.loc_name);
              $("#circle_name_show").html(data.circle_name.loc_name);
              $("#mouza_name_show").html(data.mouza_name.loc_name);
              $("#village_show").html(data.village_name.loc_name);
              $("#patta_show").html(data.get_dag_details.patta_no);
              $("#hearing_remarks").val(data.adc_hearing_remarks);
              
              $("#regen_preference").val(data.regen_preference);
              $("#recommend_check").val(data.recommend);
              $("#hearing_re_date").val(data.hearing_date);
              $("#regen_date").html(data.regen_date);
              $("#regen_date1").html(data.regen_date);

              $('#tbody_area_detail').html(data.tableData);
              $('#message_show').html(data.msg_area);

              $('#tableNameList').html(data.name_list);

              var table = '';
              $.each(data.get_buyers, function (i, valBuy)
              {
                  table +=
                      '<span>'+ '  '  + valBuy['pdar_name']  + '  ,' +'</span>' ;
              });
              $('#tableBuyer').html(table);

              var table1 = '';
              $.each(data.get_owners, function (i, valOwn)
              {
                  table1 +=
                      '<span>'+ '  '  + valOwn['pdar_name']  + '  ,' +'</span>' ;
              });
              $('#tableOwner').html(table1);

              var table2 = '';
              $.each(data.existing_pattadars, function (i, valOwn)
              {
                  table2 +=
                      '<span>'+ '  '  + valOwn['pdar_name']  + '  ,' +'</span>' ;
              });
              $('#tableEp').html(table2);

              var table3 = '';
              $.each(data.deed_applicants, function (i, valOwn)
              {
                  table3 +=
                      '<span>'+ '  '  + valOwn['pdar_name']  + '  ,' +'</span>' ;
              });
              $('#tableDA').html(table3);
            }
            else if (data.responseType == 3)
            {
              showErrorMessage("Data not found !");
            }
            else if (data.responseType == 4)
            {
              showErrorMessage(data.msg);
            }
            else
            {
              showErrorMessage("SOMETHING WENT WRONG");
            }
          },
          data: JSON.stringify(params)
        });
      }
    });

    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });

    // save new notice
    $(document).on('click','#regenNoticeSaveModalYes',function ()
    {
        var htmlPrintArea    = $( "#printableArea" ).html();
        var htmlString       = b64EncodeUnicode(htmlPrintArea);
        var hearingDate      = $("#hearing_re_date").val();
        var case_no          = $("#case_no_notice").val();
        var regen_preference = $("#regen_preference").val();
        var recommend_check  = $("#recommend_check").val();
        var regen_date       = $("#regen_date").val();

        if(htmlString == '')
        {
            $('#viewRegenerateNoticeModal').modal('hide');
            showErrorMessage("SOMETHING WENT WRONG");
        }
        if(hearingDate == '')
        {
            showErrorMessage("Please Enter Hearing Date !");
        }

        $('#viewRegenerateNoticeModal').modal('hide');

        const applicant = {
            case_no          : case_no,
            hearingDate      : hearingDate,
            htmlstring_text  : htmlString,
            hearing_remarks  : $('#hearing_remarks').val(),
            regen_preference : regen_preference,
            recommend_check  : recommend_check,
            regen_date       : regen_date,
        };
        // console.log(applicant); return;

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border          :'none',
                backgroundColor :'transparent'
            }
        });

        $.ajax({
            url         : BASE_URL + "/TeaGrantControllerAdc/saveRegeneratedHearingRemarksByAdc",
            type        : "post",
            dataType    : "json",
            contentType : "application/json",
            success: function (data) {

                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {
                    Swal.fire({
                        backdrop          : true,
                        allowOutsideClick : false,
                        text              : "Hearing Date Successfully Updated",
                        confirmButtonText : 'OK',
                        customClass : {
                            actions       : 'my-actions',
                            confirmButton : 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                    // window.location.reload();

                          location.reload();

                    // window.location.href = BASE_URL + "/TeaGrantControllerAdc/viewAllGeneratedNoticeTeaGrantAdcCaseList";


                }
                });
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

    $(document).on('click','#regenNoticeSaveModalNo',function (){
        $('#viewRegenerateNoticeModal').modal('hide');
    });

    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }

</script>