
<div class="modal" role="dialog" id="deptForwardRemarkModal">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Forward to Department for Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Remarks&nbsp;<span class="text-red">*</span>(<span class="text-red">This is a system-generated remark and may be subject to revision for accuracy or clarity !!!</span>)</label>
                            <textarea rows="5" class="form-control" 
                            id="dept_forward_rem" required placeholder=" Please enter remarks">Perused the report/proceedings of ADC and Circle officers found in order 
Hence recommended for conversion to periodic patta</textarea>
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>


                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="recommend"
                                value="<?=YES?>">
                                <label class="form-check-label" for="inlineRadio1">Can be Recommended</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recommend" id="notrecommend"
                                value="<?=NO?>">
                                <label class="form-check-label" for="inlineRadio1">Can not Recommended</label>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeRemarkModal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDeptForwardRemark">Save & Forward to Department</button>
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
        $('#deptForwardRemarkModal').modal('show');
    });

    $("#closeRemarkModal").on('click', function(){
        $('#deptForwardRemarkModal').modal('hide');
    });

    $('#saveDeptForwardRemark').on('click', function()
    {

      var dept_forward_rem    = $('#dept_forward_rem').val();
      var case_no_notice = $('#case_no_notice').val();
      var recommend      = $("input[name='recommend']:checked").val();

      if(dept_forward_rem == null || dept_forward_rem == '')
      {
          alert("Remarks is mandatory !!! ");
          $('#dept_forward_rem').focus();
          return false;
      }
      else if(case_no_notice == null || case_no_notice == '')
      {
          alert("Manipulation done with case no !!! ");
          $('#case_no_notice').focus();
          return false;
      }
      else if(recommend == null || recommend == '')
      {
          alert("Please select recommend / not recommend !!! ");
          $('#recommend').focus();
          return false;
      }

      Swal.fire({
        icon              : 'warning',
        backdrop          : true,
        allowOutsideClick : false,
        text              : 'Are you sure, you want to forward the case to Department ?',
        showCancelButton  : true,
        confirmButtonText : 'CONFIRM',
      }).then((result) => {
        if (result.isConfirmed) 
        {
          const params = {
            case_no          : case_no_notice,
            dept_forward_rem : dept_forward_rem,
            recommend        : recommend,
          };
          $.ajax({
            url         : baseurl+'TeaGrantControllerDc/forwardToDepartmentSingle',
            type        : "POST",
            dataType    : "json",
            contentType : "application/json",
            success: function(data) 
            {  
              // console.log(data);
                $('#saveDeptForwardRemark').hide();

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
                    window.location.reload();
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