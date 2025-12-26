
<div class="modal" role="dialog" id="deptForwardRemarkModalNormal">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Revert to ADC for Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Remarks&nbsp;<span class="text-red">*</span></label>
                            <textarea rows="5" class="form-control" 
                            id="dc_revert_rem" required placeholder=" Please enter remarks"></textarea>
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeDcRevertRemarkModalNormal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDcRevertRemarkNormal">Save & Revert to ADC</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

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
        $('#deptForwardRemarkModalNormal').modal('show');
    });

    $("#closeDcRevertRemarkModalNormal").on('click', function(){
        $('#deptForwardRemarkModalNormal').modal('hide');
    });

    $('#saveDcRevertRemarkNormal').on('click', function()
    {

      var dc_revert_rem    = $('#dc_revert_rem').val();
      var case_no_notice = $('#case_no_notice').val();

      if(dc_revert_rem == null || dc_revert_rem == '')
      {
          alert("Remarks is mandatory !!! ");
          $('#dc_revert_rem').focus();
          return false;
      }
      else if(case_no_notice == null || case_no_notice == '')
      {
          alert("Invalid case no !!! ");
          $('#case_no_notice').focus();
          return false;
      }

      Swal.fire({
        icon              : 'warning',
        backdrop          : true,
        allowOutsideClick : false,
        text              : 'Are you sure, you want to revert the case to ADC ?',
        showCancelButton  : true,
        confirmButtonText : 'CONFIRM',
      }).then((result) => {
        if (result.isConfirmed) 
        {
          const params = {
            case_no       : case_no_notice,
            dc_revert_rem : dc_revert_rem,
          };
          $.ajax({
            url         : baseurl+'TeaGrantControllerDc/revertToAdcByDC',
            type        : "POST",
            dataType    : "json",
            contentType : "application/json",
            success: function(data) 
            {  
              console.log(data);

              if(data.responseType == 1){
                showErrorMessage(data.message);
              }
              else if(data.responseType == 2){
                
                Swal.fire({
                    backdrop          : true,
                    allowOutsideClick : false,
                    text              : data.message,
                    confirmButtonText : 'OK',
                    customClass : {
                        actions       : 'my-actions',
                        confirmButton : 'order-2',
                    }
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location = window.location;
                  }
              });

              }
              else
              {
                showErrorMessage("#356: Some issue occured on forwarding the case to department !!!");
              }
            }, error: function (err) {
              showErrorMessage("#360: Some issue occured on forwarding the case to department !!!");
            },
            data: JSON.stringify(params)
          });
        }
      });
    });

</script>