
<div class="modal" role="dialog" id="reforwardSroModal">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Re forward to SRO for Case No : <?=$case_no?>
                </h5>
            </div>
            <div class="modal-body" >
                <form action="">
                    <div class="row">

                        <?php if(SEND_TO_MULTIPLE_SRO_DIST == 1) { ?>

                          <div class="col-md-3">
                              <span>Select District(s) For SRO verification</span>
                          </div>
                          <div class="col-md-9 col-lg-9 col-sm-9 col-xs-12">
                            <div class="list-group form__div" id="multi_dist_sro"
                            style="height:200px;overflow:auto;border: solid 3px #181842;">
                              <div class="border p-3 rounded">
                                <?php foreach(json_decode(DISTRICT_LIST_TO_SEND_SRO) as $dist) { ?>
                                  <div class="form-check">
                                    <input class="form-check-input multi_dist_sro" type="checkbox" value="<?=$dist->CODE?>">
                                    <label class="form-check-label" for="<?=$dist->CODE?>">
                                      <?=$dist->NAME?>
                                    </label>
                                  </div>
                                <?php } ?>
                                </div>
                            </div>
                          </div>
                        <?php } ?>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Deed No&nbsp;<span class="text-red">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Deed No" id="re_deed_no" 
                                name="re_deed_no">
                            <input type="hidden" id="re_case_no" value="<?=$case_no?>">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Deed Date&nbsp;<span class="text-red">*</span></label>
                            <input type="date" class="form-control" placeholder="Enter Deed Date" id="re_deed_date" 
                                name="re_deed_date">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSroReforward">Re-Forward to SRO</button>
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
        $('#reforwardSroModal').modal('show');
    });

    $("#closeModal").on('click', function(){
        $('#reforwardSroModal').modal('hide');
    });

    $('#saveSroReforward').on('click', function()
    {
      let selectedDistricts = [];
      $('.multi_dist_sro:checked').each(function () {
        selectedDistricts.push($(this).val());
      });

      var re_deed_no   = $('#re_deed_no').val();
      var re_deed_date = $('#re_deed_date').val();
      var re_case_no   = $('#re_case_no').val();

      if(re_deed_no == null || re_deed_no == '' || re_deed_no == 'NA')
      {
          alert("Deed No is mandatory !!! ");
          $('#re_deed_no').focus();
          return false;
      }
      else if(re_deed_date == null || re_deed_date == '')
      {
          alert("Deed Date is mandatory !!! ");
          $('#re_deed_date').focus();
          return false;
      }
      else if(re_case_no == null || re_case_no == '')
      {
          alert("Invalid case no !!! ");
          $('#re_case_no').focus();
          return false;
      }

      Swal.fire({
        icon              : 'warning',
        backdrop          : true,
        allowOutsideClick : false,
        text              : 'Are you sure, you want to re forward the case to SRO ?',
        showCancelButton  : true,
        confirmButtonText : 'CONFIRM',
      }).then((result) => {
        if (result.isConfirmed) 
        {
          const params = {
            re_deed_no   : re_deed_no,
            re_deed_date : re_deed_date,
            re_case_no   : re_case_no,
            multi_dist   : selectedDistricts,
          };

          $.ajax({
            url         : baseurl+'TeaGrantControllerCo/reforwardToSroFromList',
            type        : "POST",
            dataType    : "json",
            contentType : "application/json",
            success: function(data) 
            {  
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
                showErrorMessage("#148: Some issue occured on re forwarding the case to SRO !!!");
              }
            }, error: function (err) {
              showErrorMessage("#148: Some issue occured on re forwarding the case to SRO !!!");
            },
            data: JSON.stringify(params)
          });
        }
      });
    });

</script>