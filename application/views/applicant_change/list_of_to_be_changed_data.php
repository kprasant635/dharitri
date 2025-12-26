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
        <span>List of to be Changed Applicant</span>
      </div>

      <div class="reza-body">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

        <table class="datatable table table-stripped" id='datatable' width="100%">
          <thead>
            <tr>
              <th>SL No.</th>
              <th>Application/Case No</th>
              <th>Circle Name
                  <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="2">
                      <option value="">Select Circle</option>
                      <?php if(isset($location)){ foreach($location as $cir) { ?>
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

              <th class="center">Action
                  <button type="button" class="search_button btn btn-sm btn-primary form-control"><i class="fa fa-search" aria-hidden="true"></i>
                      Search</button>
              </th>

            </tr>
          </thead>
          <tbody>

            <tr>
              <td>1</td>
              <td>KAM/RAN/2023-24/3346/SKHAS</td>
              <td></td>
              <td></td>
              <td>

                <a href="<?=base_url().'index.php/ApplicantChangeController/applicantDetail?case='.$this->utilityclass->encryptJwtCase('KAM/RAN/2023-24/3346/SKHAS')?>" target="_changeAppl">                  
                  <button type="button" class="view_button btn btn-sm btn-danger form-control"><i class="fa fa-eye" aria-hidden="true"></i>View Detail</button>
                </a>
                
              </td>
            </tr>

          </tbody>

        </table>

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
                            <input type="datetime-local" class="form-control" name="w3date" id="date" required> </input>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Venue Name</label>
                            <input type="text" class="form-control" placeholder="Enter venue..." name="venue_name" id="venue" required>
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
                            GOVERNMENT OF ASSAM OFFICE OF THE DISTRICT COMMISSIONER:::::::::::::::::::::(<span class="noticeDistName"></span>) <br> (SETTLEMENT BRANCH)
                        </div>
                    </div>
                    <div class="row mt-5 px-5">

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12">
                                    No.
                                    <span style="font-weight:bold;" id="proposalSequenceNo"></span>
                                    <input type="hidden" id="proposalSequenceNoVal" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row justify-content-end">
                                <div class="col-4 text-right">
                                    Date <b><?=date('d-m-Y')?></b>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row px-5 mt-5">
                        <div class="col-12 text-justify">
                            <div class="row">
                                <div class="col-2">
                                    To,
                                </div>
                            </div>
                            <div class="row px-5">
                                <div class="row">
                                    <div class="col-12">
                                        <table>
                                            <tbody id="membersTable">

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-1">
                                    .Sub:
                                </div>
                                <div class="col-11">
                                    Regarding meeting of Land Advisory Committee under <span class="subDivName"></span> Sub-Division, <span class="noticeDistName"></span>district.
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-2">
                                    Sir/ Madam,
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        &nbsp; &nbsp; &nbsp; &nbsp; With reference to the subject cited above, I have the honour to inform you that the next meeting of Land Advisory Committee (SDLAC/CDLAC) of <span class="subDivName"></span> Sub-Division is scheduled to be held on <b><span id="hearingDateShow"></span></b> at <span class="timing"></span> in the Conference Hall, DC’s office, <span class="venue-name"></span>
                                        Therefore, you are requested to kindly make it convenient to attend the meeting accordingly.
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="row justify-content-end">
                                    <div class="col-3 text-center">
                                        Yours faithfully,
                                    </div>
                                </div>

                                <div class="row justify-content-end mt-5">
                                    <div class="col-3 text-center">
                                        District Commissioner,
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3 text-center">
                                        <span class="noticeDistName"></span> district
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row px-5" style="page-break-before: always;">
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
                    <div class="row mt-5">

                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner,
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                <span class="noticeDistName"></span> district
                            </div>
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


    // $('.view_button').click(function()
    // {
    //   alert("sdfghj");
    //   $.ajax({
    //     url: base_url+'index.php/ApplicantChangeController/applicantDetail',
    //     dataType: 'json',
    //     data: {
    //       subdiv_code: subdiv,
    //       cir_code: circle,
    //     },
    //     type: "POST",
    //     success: function(data) {

    //       // if(data.responseType == 1)
    //       // {
    //       //   var village_detail = "<option value=''>Select Village</option>";

    //       //   $.each(data.location, function (i, val) {
    //       //     village_detail +=
    //       //         "<option value='"+ val["cir_code"] +","+ val["subdiv_code"] +","+ val["mouza_pargona_code"] +","+ val["lot_no"] +","+ val["vill_townprt_code"] +"'>"+val["loc_name"]+"</option>";
    //       //   });
    //       //   $('#vill_id').html(village_detail);
    //       // }
    //     },
    //     error: function(error) { // runtime error message
    //       var village_detail = "<option value=''>Select Village</option>";
    //       $('#vill_id').html(village_detail);
    //     },
    //   });
    // });



    $('#datatable').DataTable();

    $('#cir_id').change(function()
    {
        var base_url = "<?php echo base_url();?>";
        // cir_id       = $('#cir_id').val();
        // var villcode = cir_id.split(",");

        // var circle   = villcode[0];
        // var subdiv   = villcode[1];
        // var mouza    = villcode[2];
        // var lot      = villcode[3];
        cir_id       = $('#cir_id').val();
        var villcode = cir_id.split(",");
        var circle   = villcode[0];
        var subdiv   = villcode[1];

        $.ajax({
            // url: base_url+'index.php/SettlementMbADC/getVillName',
            // dataType: "JSON",
            // data: {circle: circle, subdiv:subdiv, mouza:mouza, lot:lot},
            // type: "POST",
            url: base_url+'index.php/SettlementCommonDc/villageListCommon',
            dataType: 'json',
            data: {
                subdiv_code: subdiv,
                cir_code: circle,
            },
            type: "POST",
            success: function(data) {

                if(data.responseType == 1){

                    // var village_detail = "<option value=''>Select Village</option>";

                    // $.each(data.location, function (i, val) {
                    // village_detail +=
                    //     "<option value='"+ val["vill_townprt_code"] +"'>"+val["loc_name"]+"</option>";
                    // });
                    // $('#vill_id').html(village_detail);
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

    function load_data()
    {
      var base_url     = "<?php echo base_url();?>";

      cir_code      = $('#cir_id').val();
      var newcircle = cir_code.split(",");
      cir_id        = $('#vill_id').val();
      var villcode  = cir_id.split(",");
      var circle    = newcircle[0];
      var subdiv    = newcircle[1];
      var mouza     = villcode[2];
      var lot       = villcode[3];
      var vill_id   = villcode[4];
      var case_no   = $('#by_case_no').val();
      var rem_cat   = $('#remark_cat').val();

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
            url: base_url+'index.php/ApplicantChangeController/listOfApplicantToBeChanged',
            type:'POST',
            data: {
                service    : service_code,
                circle     : circle,
                subdiv     : subdiv,
                mouza      : mouza,
                lot        : lot,
                vill_id    : vill_id,
                case_no    : case_no,
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
                selectedList: selectedCheckBoxArray,
                remarks: remarks,
                hearingDate: hearingDate,
                venue: venue,
            };

            $.ajax({
                url: BASE_URL + "/SettlementMbDc/sendAllMarkAppToSDLACByDc",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {

                    if (data.responseType == 4)
                    {
                        showWarningMessage(data.message);
                    }
                    else if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 10)
                    {
                        var appNoArea = data.application;
                        var showMgsArea = 'Applied area cannot exceed total chitha area ! (' + appNoArea +' )';
                        showErrorMessage(showMgsArea);
                    }
                    else if (data.responseType == 2)
                    {
                        $('#viewNoticeModal').modal({backdrop: 'static', keyboard: false});
                        $('#viewNoticeModal').modal('show');

                        $("#hearingDateShow").html(data.hearingDate);
                        $(".timing").html(data.timing);

                        $("#remarksShow").html(data.remarks);
                        $("#proposalSequenceNo").html(data.proposalSequenceNo);
                        $("#proposalSequenceNoVal").val(data.proposalSequenceNo);
                        $(".noticeDistName").html(data.distName);
                        $(".subDivName").html(data.subDivName);
                        $(".venue-name").html(data.venue);

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


                        var tableMembers = '';
                        var slMembers    = 1;

                        $.each(data.commMembers, function (i, val) {
                            tableMembers +=
                                '<tr>'+
                                '<td>' + slMembers +'. &nbsp;' + '</td>' +
                                '<td>' + val.name +', ' + val.designation+'</td>' +
                                '</tr>';

                            slMembers = slMembers + 1;
                        });

                        $('#membersTable').html(tableMembers);


                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
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
                url: BASE_URL + "/SettlementMbDc/generateNoticeSendAllMarkAppToSDLACByDcKhas",
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