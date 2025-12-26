

<table class="table table-bordered">
  <thead>                
    <tr>
      <th>Applicant Name</th>
      <th>Guardian Name</th>
      <th>To be as Main Applicant</th>
    </tr>
  </thead>
  <tbody>  
    <input type="hidden" name="selected_applicant" id="selected_applicant">



  <?php if(count($appl_list) > 0){

   foreach ($appl_list as $key => $value) { 
    // var_dump($appl_list) ; 
    if($value->is_applicant == 0 && $value->pdar_type == 'B') {?>
    <tr>
      <td><?=$value->pdar_name; ?></td>
      <td><?=$value->pdar_guardian; ?></td>
      <td>
        <div class="aQuestion">
          <input class="form-check-input"
                type="radio"
                name="is_main_appl"
                id="is_main_appl<?=$value->id; ?>"
                value="<?=$value->id; ?>"
        />
      </div>
        <!-- <label class="form-check-label" for="is_main_appl1" >Yes</label> -->

      </td>
    </tr>
  <?php }

}


}else{ ?>
    <div class="aQuestion">
      <input class="form-check-input" style="display:none" 
                type="radio"
                name="dummy21"
                id="dummy21"
                value=""
        />
    </div>
  <?php } ?>
            
  </tbody>
</table>
<div class="row">
  <button type="button" class="btn btn-primary" id="proceedfor_ekyc">Proceed for E-kyc</button>
</div>
<script type="text/javascript">




  $('#proceedfor_ekyc').on('click',function (argument) {

    var case_no = $('#case_no').val();
    var baseurl = $('#baseurl').val();

    var sel_appl = $('input:radio[name=is_main_appl]:checked').val();
    var listOfToBeEkycAppl = document.getElementById("listOfToBeEkycAppl");
    listOfToBeEkycAppl.style.display = "none";

    $('.aQuestion').each(function()
    {
      if($(this).find('input[type="radio"]:checked').length > 0)
      {
        // $('#selected_applicant').val(($('input:radio[name=is_main_appl]:checked').val()));
        
        const params = {
          case_no : case_no,
          baseurl : baseurl,
          sel_appl: sel_appl,
        };

        $.ajax({
            url: baseurl + "index.php/ApplicantChangeController/selectedJointAppl",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
              // console.log(data);
              if(data.responseType == 1)
              {
                $('#ekyc_form').submit();
              }
              else {
                showErrorMessage(data.message);
              }
            },
            error: function(data) {
              showErrorMessage("Some issue has occured on modifying main applicant. Kindly contact system administrator");
            },
            data: JSON.stringify(params)
          });
      }
      else // if no applicant selects
      {

        Swal.fire({
          icon              : 'warning',
          backdrop          : true,
          allowOutsideClick : false,
          text              : 'You have not selected any Joint Applicant from the list. In this case a new Applicant will be considered as the Main Applicant. Are you sure to proceed? Please Click Confirm to procced.',
          // showDenyButton    : true,
          showCancelButton  : true,
          confirmButtonText : 'Confirm',
          // denyButtonText    : 'Verify e-Kyc',
          customClass       : {
            actions         : 'my-actions',
            cancelButton    : 'order-1 right-gap',
            confirmButton   : 'order-2',
            // denyButton      : 'order-3',
          },
        }).then((result) => {
          if (result.isConfirmed) // for updation of new application
          {
            $('#ekyc_form').submit();
          }
        });
      }    
    });

    
    // body...
  });
</script>