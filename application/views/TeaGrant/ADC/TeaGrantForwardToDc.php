
<div class="modal" role="dialog" id="adcForwardRemarkModal">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Forward to DC for Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Remarks&nbsp;<span class="text-red">*</span> (<span class="text-red">This is a system-generated remark and may be subject to revision for accuracy or clarity !!! </span>)</label>

                            <textarea rows="5" class="form-control" 
                            id="adc_forward_rem" required placeholder=" Please enter remarks">No objection received during the stipulated time period.
Hence recommended for conversion of the land to periodic patta after reliazation of the premium as per notification no eCF No 565802/I/777772/2024 dated 20-10-2024
</textarea>
                            <input type="hidden" id="case_no_notice" value="<?=$case_no?>">
                        </div>

                        <div class="col-md-12 text-bold">
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
            <?php if($areaCheck == 1) { ?>

                <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                    Total Area Recommended for Settlement can’t exceed available Area in Chitha !
                </h5>
                <br>
                
            <?php } else { ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeAdcForwardRemarkModal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAdcForwardRemark">Save & Forward to DC</button>
                </div>
            <?php } ?>
            
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
        $('#adcForwardRemarkModal').modal('show');
    });

    $("#closeAdcForwardRemarkModal").on('click', function(){
        $('#adcForwardRemarkModal').modal('hide');
    });

    $('#saveAdcForwardRemark').on('click', function()
    {

      var adc_forward_rem    = $('#adc_forward_rem').val();
      var case_no_notice = $('#case_no_notice').val();
      var recommend      = $("input[name='recommend']:checked").val();

      if(adc_forward_rem == null || adc_forward_rem == '')
      {
          alert("Remarks is mandatory !!! ");
          $('#adc_forward_rem').focus();
          return false;
      }
      else if(case_no_notice == null || case_no_notice == '')
      {
          alert("Invalid case no !!! ");
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
        text              : 'Are you sure, you want to forward the case to DC ?',
        showCancelButton  : true,
        confirmButtonText : 'CONFIRM',
      }).then((result) => {
        if (result.isConfirmed) 
        {
          const params = {
            case_no         : case_no_notice,
            adc_forward_rem : adc_forward_rem,
            recommend       : recommend,
          };
          $.ajax({
            url         : baseurl+'TeaGrantControllerAdc/forwardToDc',
            type        : "POST",
            dataType    : "json",
            contentType : "application/json",
            success: function(data) 
            {  
              $('#saveAdcForwardRemark').hide();
              // console.log(data);

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