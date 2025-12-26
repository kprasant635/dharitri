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

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="font-size: 20px;">
      <strong>List of proposals to be approved</strong>

      <?php if($pendingCaseCount > 0 ) { ?>

        <a class="btn btn-sm btn-warning pull-right" href="<?=base_url().'index.php/SettlementProposalController/pendingProposalList'?>"><i class="fa fa-eye"></i>&nbsp;View Pending Proposals</a>

      <?php } ?>

    </div>

    <div class="reza-card">
      <div class="reza-title"></div>
      <div class="reza-body">

        
        <table class="datatable table table-stripped" id='datatable' width="100%">
          <thead>

            <tr>
              <th>All <input type="checkbox" class="checkBoxD" value="all" id="checkedAll"></th>
              <th>SL No.
                <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="0">
                  <option value="">Select Circle</option>
                  <?php if(isset($location)){ foreach($location as $cir){ ?>
                    <option value="<?=$cir['cir_code'].",".$cir['subdiv_code']?>"><?=$cir['cir_name']?></option>
                  <?php }}?>
                </select>
              </th>
              <th>Proposal No
                <input type="text" id="by_pro_no" name="by_pro_no"
                  class="form-control" placeholder="Search by Proposal No">
              </th>
              <th>Service Name
                <select class="form-control" name="by_service" id="by_service" data-column-index="0">
                  <option value="0">Search by Service</option>
                  <option value="13">Occupancy Tenant</option>
                  <option value="14">AP</option>
                  <option value="15">Tribal</option>
                  <option value="16">Khas Land</option>
                  <option value="17">Pgr Vgr</option>
                  <option value="18">Special Cultivators</option>
                </select>
              </th>
              <th class="center">Hearing Date
                <input type="text" id="by_case_no" name="by_case_no"
                  class="form-control" placeholder="Search by Case No">
              </th>
              <th class="center">Action
                <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
              </th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        


        <br>
        <div class="row">
          <?php if(SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON == 1) { ?>
            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
              <button class="btn btn-md btn-warning" id="addNomineeOfSdlacMembers">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Add Nominee of SDLAC/CDLAC Member
              </button>
              <button  class="btn btn-md btn-primary" id="openModalForFinalSubmit" >
                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Final forward to DC for approval
              </button>
            </div>
          <?php } else { ?>
            <button  class="btn btn-md btn-primary" id="noProcess" >
              <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Final forward to DC for approval
            </button>
          <?php } ?>
        </div>
        <br>

      </div>
    </div>
  </div>
</div>



<!-- Add Nominee of SDLAC/CDLAC Member -->
<div class="modal" role="dialog" id="nomineeAddModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="max-width: 30%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          Add Nominee of SDLAC/CDLAC Member
        </h5>
        <i class="fa fa-close fa-2x text-red closeNomineeModal" style="cursor:pointer;"></i>
      </div>

      <div class="modal-body">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <br>
          <div class="row">
            <div class="form-group">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>SDLAC/CDLAC Member</label>&nbsp;<span class="text-danger">*</span>
                <select class="form-control" id="added_sdlac_member">
                    <option value="NA">Select SDLAC/CDLAC Member</option>
                    <?php //$i=1; foreach($committeeList as $mem) { ?>
                        <option value="<?= $mem->user_code ?>"><?= $mem->name ?></option>
                        <?php //$i++; } ?>
                </select>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Nominee Name</label>&nbsp;<span class="text-danger">*</span>
                <input type="text" class="form-control" id="added_nominee_name"
                       placeholder="Enter Nominee Name">
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Nominee Contact No</label>&nbsp;<span class="text-danger">*</span>
                <input type="text" class="form-control" id="added_nominee_contact"
                       placeholder="Enter Nominee Contact No" maxlength="10">
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Nominee Email ID</label>
                <input type="text" class="form-control" id="added_nominee_email"
                       placeholder="eg. xyz@gmail.com">
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" id="insertNominee" class="btn btn-primary btn-sm">Add Nominee</button>
              </div>

            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer"></div>
    </div>
  </div>
</div>


<!-- Modal for final submission -->
<div class="modal" role="dialog" id="finalSubmissionModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          SDLAC/CDLAC Member who attended meeting
        </h5>
        <i class="fa fa-close fa-2x text-red closeFinalModal" style="cursor:pointer;"></i>
      </div>

      <div class="modal-body">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <br>
          <div class="row">
            <div class="form-group">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label>Meeting Date</label>
                
                <input type="datetime-local" class="form-control" 
                name="meeting_date" id="meeting_date">
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label>Upload Minutes</label>
                <input type="file" class="form-control" id="upload_minute_online" name="upload_minute_online">
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label>Attendance Sheet</label>
                <input type="file" class="form-control" id="upload_attendance" name="upload_attendance">
              </div>

            </div>

            <div class="form-group">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <label>Venue of Meeting</label>                                
                  <input type="text" class="form-control" 
                  name="meeting_venue" id="meeting_venue" placeholder="Enter Venue of meeting held">
              </div>

              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <label>Remarks</label>                                
                  <input type="text" class="form-control" 
                  name="meeting_remarks" id="meeting_remarks" placeholder="Enter Remarks">
              </div>
            </div>

          </div>&nbsp;

          <div class="row">

            <table class="datatable table table-stripped" id='datatable' width="100%">
              <thead>
              <tr>
                <th width="10%">Sl No</th>
                <th width="20%">SDLAC/CDLAC Member</th>
                <th width="20%">Select Nominee (if any)</th>
                <th width="20%" style="text-align:center">Meeting Attended</th>
              </tr>
              </thead>
              <tbody id="list_of_sdlac_commitee_members">

                <?php $i=1; foreach($committeeList as $row) { ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row->name?>
                      <input type="hidden" id="sdlac_user_<?=$row->user_code?>" value="<?=$row->user_code?>">
                    </td>

                    <td>
                      <select class="form-control" id="select_nominee_<?=$row->user_code?>">
                        <option value="0">Not Available</option>
                        <?php

                        //list of members
                        $nominee = $this->utilityclass->getNomineeOfSdlacMember($row->user_code, $this->session->userdata('dist_code'));
                        foreach($nominee as $nom) {

                          //for selected nominee
                          $checkedStatus = $this->utilityclass->getSelectedNomineeOfSdlac($proposal_no, $nom->id, SETTLEMENT_KHAS_LAND_ID);
                          ?>
                          <option <?=$checkedStatus?> value="<?=$nom->id?>"><?=$nom->nominee_name?></option>
                        <?php } ?>
                      </select>
                    </td>

                    <td style="text-align: center;">
                      <input type="radio" name="attend_status_<?=$row->user_code?>"
                             id="report_online<?=$i?>" value="<?=SDLAC_ATTEND_ONLINE?>" >&nbsp;<span style="color:green">
                          Online</span>

                      &nbsp;&nbsp;&nbsp;&nbsp;

                      <input type="radio" name="attend_status_<?=$row->user_code?>" checked
                             id="report_offline<?=$i?>" value="<?=SDLAC_ATTEND_OFFLINE?>" >&nbsp;<span style="color:red">Offline</span>
                    </td>

                  </tr>

                <?php $i++; } ?>
                
              </tbody>
            </table>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <button type="submit" id="forwardToDcForFinalApproval" class="btn btn-primary btn-sm">SEND PROPOSAL TO DC</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"></div>
    </div>
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


  //add nominee of SDLAC/CDLAC Member
  $('#addNomineeOfSdlacMembers').click(function(){
    $('#nomineeAddModal').modal('show');
  });

  //close nominee of SDLAC/CDLAC Member
  $('.closeNomineeModal').click(function(){
    $('#nomineeAddModal').modal('hide');
  });

  //insert nominee
  $('#insertNominee').click(function()
  {
    sdlac_mem     = $('#added_sdlac_member').val();
    nominee_name  = $('#added_nominee_name').val();
    nominee_cont  = $('#added_nominee_contact').val();
    nominee_email = $('#added_nominee_email').val();

    if(sdlac_mem == 'NA'){
      showWarningMessage("Select SDLAC/CDLAC Member");
      $('#added_sdlac_member').focus();
      return false;
    }

    if(nominee_name == ''){
      showWarningMessage("Enter Nominee Name");
      $('#added_nominee_name').focus();
      return false;
    }

    if(nominee_cont == ''){
      showWarningMessage("Enter Nominee Contact No");
      $('#added_nominee_contact').focus();
      return false;
    }

    const nominee_detail = {
      sdlac_mem     : sdlac_mem,
      nominee_name  : nominee_name,
      nominee_cont  : nominee_cont,
      nominee_email : nominee_email,
    };
    $.ajax({
      url: BASE_URL + "/SettlementProposalController/insertNomineeDetailOfSdlacMember",
      type: "post",
      dataType: "json",
      contentType: "application/json",
      success: function (data) {
        if (data.responseType == 1) {
          showErrorMessage(data.message);
        }
        else if (data.responseType == 2) {
          $('#nomineeAddModal').modal('hide');
          Swal.fire({
            text: data.message,
            confirmButtonText: 'OK',
            customClass: {
              actions: 'my-actions',
              confirmButton: 'order-2',
            }
          }).then((result) => {
            if (result.isConfirmed) {
              //window.location = ";
            }
          });
        }
      },
      data: JSON.stringify(nominee_detail)
    });
  });


  $('#datatable').DataTable();

  load_data();

  function load_data()
  { 
    var base_url      = "<?php echo base_url();?>";
    var proposal_no   = $('#by_pro_no').val();
    var service_name  = $('#by_service').val();
    var case_no       = $('#by_case_no').val();
    var cir_code      = $('#cir_id').val();

    if(cir_code != 0){
      var newcircle     = cir_code.split(",");
      cir_id            = $('#vill_id').val();
      var villcode      = cir_id.split(",");
      var circle        = newcircle[0];
      var subdiv        = newcircle[1];
      var mouza         = villcode[2];
      var lot           = villcode[3];
      var vill_id       = villcode[4];
    }

    $('#datatable').DataTable().destroy();

    var table = $('#datatable').DataTable({

      'pageLength' : 10,
      "processing" : true,
      "serverSide" : true,
      "searching"  : false,
      "ordering"   : false,
      "lengthMenu" : [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
      'language'   : {
        "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
      },
      'ajax'   : {
        url  : base_url+'index.php/SettlementProposalController/listOfProposalsAllServices',
        type : 'POST',
        data : {
          circle       : circle,
          subdiv       : subdiv,
          mouza        : mouza,
          lot          : lot,
          vill_id      : vill_id,
          case_no      : case_no,
          service_code : service_name,
          proposal_no  : proposal_no,
        },
        deferLoading     : 57,
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
          return '<input type="checkbox" class="checkBoxD selectMark" value='+text+' id='+text+' name="selectMark[]">';
        }
      }],
    });
  }

  $('.search_button').click(function(){
    load_data();
  });

  //close modal
  $('.closeFinalModal').click(function(){
    $('#finalSubmissionModal').modal('hide');
  });


  $("#openModalForFinalSubmit").click(function(){
      $('#finalSubmissionModal').modal('show');
  });
  
  //send proposal to dc
  $('#forwardToDcForFinalApproval').click(function(){    

    var nominee = [];

    if($('#meeting_date').val() == '') {
        showErrorMessage('Meeting Date is mandatory');
        $('#meeting_date').focus();
        return false;
    }

    if($('#upload_minute_online').val() == '') {
        showErrorMessage('Minute upload is mandatory');
        $('#upload_minute_online').focus();
        return false;
    }

    if($('#upload_attendance').val() == '') {
        showErrorMessage('Attendance Sheet is mandatory');
        $('#upload_attendance').focus();
        return false;
    }

    if($('#meeting_venue').val() == '') {
        showErrorMessage('Meeting venue is mandatory');
        $('#meeting_venue').focus();
        return false;
    }    

    if($('#meeting_remarks').val() == '') {
        showErrorMessage('Meeting remarks is mandatory');
        $('#meeting_remarks').focus();
        return false;
    }    

    var selectedList = [];

    $('.selectMark:checked').each(function(i){
        selectedList[i] = $(this).val();
    });

    var uploadedFile = new FormData();

    uploadedFile.append("upload_minute_online", $('#upload_minute_online')[0].files[0]);
    uploadedFile.append("upload_attendance", $('#upload_attendance')[0].files[0]);
    uploadedFile.append("meeting_date", $('#meeting_date').val());
    uploadedFile.append("meeting_venue", $('#meeting_venue').val());
    uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());

    //list of proposals selected
    uploadedFile.append("proposals", JSON.stringify(selectedCheckBoxArray));

    //sdlac_user select_nominee attend_status
    <?php foreach ($committeeList as $com) { ?>

      var sdlac_user = $('#sdlac_user_<?=$com->user_code?>').val();
      var select_nominee = $('#select_nominee_<?=$com->user_code?>').val();
      var attend_status = $('input:radio[name=attend_status_<?php echo $com->user_code?>]:checked').val();
      if(attend_status == '') {
          showErrorMessage('All checks are mandatory');
          return false;
      }
      nomineeData = {sdlac_user,select_nominee,attend_status};
      nominee.push(nomineeData);
    
    <?php } ?>

    uploadedFile.append("nominee", JSON.stringify(nominee));

    if (selectedList.length > 0) 
    {
      $.ajax({
        url: BASE_URL + "/SettlementProposalController/sendProposalsToDc",
        type: "post",
        enctype: 'multipart/form-data',
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {

          console.log(data);

          var data = JSON.parse(data);

          $('#finalSubmissionModal').modal('hide');

          if (data.response == 1) { //for error message
            showErrorMessage(data.message);
          }
          else if (data.response == 2) { //if success
            Swal.fire({
              text: data.message,
              confirmButtonText: 'OK',
              customClass: {
                actions: 'my-actions',
                confirmButton: 'order-2',
            }
            }).then((result) => {
              if (result.isConfirmed) {
                window.location = BASE_URL + "/SettlementProposalController/commonProposalListView";
              }
            });
          }
        },
        data: uploadedFile
      });
    }
    else {
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

  function openTab(id)
  {
    $.ajax({
      url: BASE_URL + "/SettlementProposalController/getCasesAgainstProposalNo",
      dataType: "JSON",
      data: {id : id},
      type: "POST",
      success: function(data) {
        console.log(data.response[0]['case_no']);
        var cases=[];
        $.each(data.response, function (i, val) {
          cases += '<br>' + val['case_no']
        });
        $('#list_of_cases_'+id).html(cases);
      }
    });
  }
  

</script>
