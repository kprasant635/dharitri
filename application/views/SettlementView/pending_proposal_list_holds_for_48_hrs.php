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
      <strong>Pending meeting(s) of proposals</strong>

      <a class="btn btn-sm btn-danger pull-right" href="<?=base_url().'index.php/SettlementProposalController/commonProposalListView'?>"><i class="fa fa-backward"></i>&nbsp; Go Back</a>

    </div>

    <div class="reza-card">
      <div class="reza-title"></div>
      <div class="reza-body">
        
        <table class="datatable table table-stripped" id='datatable' width="100%">
          <thead>
            <tr>              
              <th>SL No.</th>
              <th>Meeting ID</th>
              <th>Meeting Date</th>
              <th>To be Approved in</th>
              <th class="center">Action</th>
            </tr>
          </thead>

            <?php $i=1; foreach($cases as $row) { ?>
              <tr>
                <td><?=$i?></td>
                <td><?=$row->meeting_name?></td>
                <td><?=$row->meeting_date?></td>
                <td><?=$i?></td>
                <td>
                  <button type="button" class="btn btn-sm btn-success" 
                    onclick="btnView(<?=$row->id?>)">View</button>
                </td>
              </tr>
            <?php $i++; } ?>
          <tbody>
          </tbody>
        </table>
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

  function btnView(meeting_id){
    alert(meeting_id);

    const meeting_params = {
      meeting_id     : meeting_id,
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
      data: JSON.stringify(meeting_params)


  }

</script>
