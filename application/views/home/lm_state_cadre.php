<div class="modal lm_state_cadre" id="lm_state_cadre" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title bg bg-warning" style="padding: 10px;">Important Notice</h4>
          <button type="button" id='modal-close' class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <div class="modal-body">
          <p class="bg bg-success" style="padding: 20px"><b>Declaration:</b><br>

          <kbd>Ref:</kbd> The Assam Land Records Subordinate Rules, 2023
          Rule -22 , Sub-Rule –(2)
          A member of existing dist-cadre</p>
          <p class="bg bg-info" style="padding: 20px">A member of existing district cadre shall be deemed to nave migrated to the state cadre prescribed in these rules except if the member of the existing cadre opts, within forty-five days from publication of these rules in the official gazette, for continuation in the district cadre on the ground of date of superannuation being within three years or any other ground, he/she may be allowed to continue in the same cadre without availing the pay and promotional benefits prescribed in these rules for the state cadre. </p>
          <p class="bg bg-info" style="padding: 20px">
            বিদ্যমান জিলা কেডাৰৰ এজন সদস্যক এই নিয়মবোৰত নিৰ্ধাৰিত ৰাজ্যিক কেডাৰলৈ প্ৰব্ৰজন কৰা বুলি গণ্য কৰা হ'ব, কেৱল যদি বিদ্যমান কেডাৰৰ সদস্যই চৰকাৰী গেজেটত এই নিয়মবোৰ প্ৰকাশ কৰাৰ পঞ্চল্লিশ দিনৰ ভিতৰত, তিনি বছৰবা আন যিকোনো ক্ষেত্ৰত অৱসৰৰ ভিত্তিত জিলা কেডাৰত অব্যাহত ৰখাৰ বাবে বাছনি কৰে।  তেওঁক ৰাজ্যিক কেডাৰৰ বাবে এই নিয়মবোৰত নিৰ্ধাৰিত দৰমহা আৰু প্ৰচাৰমূলক লাভালাভ প্ৰাপ্ত নকৰাকৈ একেটা কেডাৰত অব্যাহত ৰাখিবলৈ অনুমতি দিয়া হ'ব পাৰে।
          </p>
          <h4>Do you want to Apply for State Cadre ?</h4>
          <form>
            <div class="form-group" id='name-confirm'>
              <label class="radio-inline">
                <input type="radio" name="confirmation" value="yes">Yes
              </label>
              <label class="radio-inline">
                <input type="radio" name="confirmation" value="no">No
              </label>
            </div>
            <div class="form-group" id='no-reason' style="display:none">
              <select class="form-select" name="reason_y_n" id='selectReason'>
                <option value=''>Please Select The Reason</option>
                <option value="1"><?=lm_state_cadre?></option>
                <option value="3">Others</option>
              </select>
            </div>
            <div class="form-group" id='date_of_superannuation' style="display:none">
              <input type="text" maxlength="10" class="js-date form-control" id='date_of_super' name='date_of_superannuation' placeholder="DD/MM/YYYY">
            </div>
            <div class="form-group" id='reason_any'>
              <textarea class="form-control" id='TextBoxId' name='reason_any' rows="3" placeholder="Remark(s) if any"></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-xs">Confirm</button>
          </form>
        </div>
      </div>
      
    </div>
</div>
<script type="text/javascript">
  $(window).load(function()
  {
    var stateCadre=$('#stateCadre').val();
    if(stateCadre==0){
      $('#lm_state_cadre').modal({
        backdrop: 'static',
        keyboard: false
      });
      $("#lm_state_cadre").modal("show"); 
      $('#TextBoxId').attr('readonly', true);
    }
  });
  $('#modal-close').click(function(){
    $('#lm_state_cadre').modal('hide');
  });
  $('#selectReason').on('change', function()
  {
      let reason=this.value; 
      //alert(reason);
      if(reason==3){
        $('#TextBoxId').attr('readonly', false);
        $('#date_of_superannuation').hide();
      }else if(reason==1){
        $('#date_of_superannuation').show();
      }
      else{
        $('#TextBoxId').attr('readonly', true);
        $('#date_of_superannuation').hide();
      }
  });
  
  $("input[name='confirmation']").change(function(){
      let val=$("input[name='confirmation']:checked").val();
      if(val=='no'){
        $('#no-reason').show();
      }else if(val=='yes'){
        $('#no-reason').hide();
        $('#TextBoxId').attr('readonly', true);
      }
  });
  ////////////////////////////////////
  var input = document.querySelectorAll('.js-date')[0];
  var dateInputMask = function dateInputMask(elm) {
    elm.addEventListener('keypress', function(e) {
      if(e.keyCode < 47 || e.keyCode > 57) {
        e.preventDefault();
      }
      var len = elm.value.length;
      if(len !== 1 || len !== 3) {
        if(e.keyCode == 47) {
          e.preventDefault();
        }
      }
      if(len === 2) {
        elm.value += '/';
      }
      if(len === 5) {
        elm.value += '/';
      }
    });
  }; 
  dateInputMask(input);
  /////////////////////////////////////
  $("form").submit(function (event) {
    // $(".form-group").removeClass("has-error");
    // $(".help-block").remove();
    if($("input[name='confirmation']:checked").val()==null){
      alert('Please select One Option');
    }
    let formData = {
      confirmation: $("input[name='confirmation']:checked").val(),
      reason_y_n: $('#selectReason').find(":selected").val(),
      reason_any: $("#TextBoxId").val(),
      date_of_super: $("#date_of_super").val(),
    };
    //alert(formData);
    $.ajax({
        type: "POST",
        url: baseurl+'home/lmTransferConfirmation',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
      console.log(data);
      if (!data.success) {
        $('#lm_state_cadre').modal({
          backdrop: 'static',
          keyboard: false
        });
        $("#lm_state_cadre").modal("show"); 
        if (data.errors.confirm) {
          $("#name-confirm").addClass("has-error");
          $("#name-confirm").append('<div class="help-block">' + data.errors.confirm + '</div>');
        }
        if (data.errors.reason_y_n) {
          $("#no-reason").addClass("has-error");
          $("#no-reason").append(
            '<div class="help-block">' + data.errors.reason_y_n + "</div>"
          );
        }
        if (data.errors.reason_any) {
         $("#reason_any").addClass("has-error");
          $("#reason_any").append(
            '<div class="help-block">' + data.errors.reason_any + "</div>"
          );
        }
        if (data.errors.date_of_super) {
         $("#date_of_superannuation").addClass("has-error");
          $("#date_of_superannuation").append(
            '<div class="help-block">' + data.errors.date_of_super + "</div>"
          );
        }
      }else{
        $('#lm_state_cadre').modal('hide');
      }
      console.log(data);
    })
    .fail(function (data) {
        $("form").html(
          '<div class="alert alert-danger">Could not reach server, please try again later.</div>'
        );
        $('#lm_state_cadre').modal({
          backdrop: 'static',
          keyboard: false
        });
        $("#lm_state_cadre").modal("show");
      });
    event.preventDefault();
  });
</script>