
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

$('.btnChangeMainApplicant').click(function(){
  
  var case_no  = $('#case_no').val();
  var baseurl = $('#baseurl').val();
  var scode    = $('#scode').val();

  const params = {
    case_no  : case_no,
    baseurl : baseurl,
    scode    : scode,
  };

  Swal.fire({
    icon              : 'warning',
    backdrop          : true,
    allowOutsideClick : false,
    text              : 'Do you want to update New Applicant detail ?',
    showDenyButton    : true,
    showCancelButton  : true,
    confirmButtonText : 'Update Applicant',
    denyButtonText    : 'Verify e-Kyc',
    customClass       : {
      actions         : 'my-actions',
      cancelButton    : 'order-1 right-gap',
      confirmButton   : 'order-2',
      denyButton      : 'order-3',
    },
  }).then((result) => {
    if (result.isConfirmed) // for updation of new application
    {
      $.ajax({
        url : baseurl + "index.php/ApplicantChangeController/requestToModifyAppl",
        type : "post",
        data : {case_no : case_no, baseurl : baseurl, scode : scode},
        success: function (data) 
        {
          var ekycVerifyModal = document.getElementById("ekycVerifyModal");
          ekycVerifyModal.style.display = "block";
          $('#show_ekyc_detail').html(data);


          // console.log(data);
          // $('#ekycVerifyModal').modal('show');
          // $('#show_ekyc_detail').html(data);
        },
        error: function(data) {
          showErrorMessage("Some issue has occured on modifying main applicant. Kindly contact system administrator");
        },
      });
    } 
    else if (result.isDenied) // for ekyc required
    { 
      $.ajax({
        url: baseurl + "index.php/ApplicantChangeController/ekycVerification",
        type: "post",
        data : {case_no : case_no, baseurl : baseurl, scode : scode},
        // dataType: "json",
        // contentType: "application/json",
        success: function (data) {

          var listOfToBeEkycAppl = document.getElementById("listOfToBeEkycAppl");
          listOfToBeEkycAppl.style.display = "block";

          // $('#listOfToBeEkycAppl').modal('show');
          $('#show_ekyc_appl_list').html(data);


          // console.log(data);
          // if(data.response == 1)
          // {
          //   if(data.jointAppl == 0 || data.jointAppl == null)
          //   {
          //     $('#ekyc_form').submit();
          //   }
          //   else if(data.jointAppl > 0)
          //   {
          //     // var listOfToBeEkycAppl = document.getElementById("listOfToBeEkycAppl");
          //     // listOfToBeEkycAppl.style.display = "block";

          //     $('#listOfToBeEkycAppl').modal('show');
              
          //   }
          // }
        },
        error: function(data) {
          showErrorMessage("Some issue has occured on modifying main applicant. Kindly contact system administrator");
        },
        //data: JSON.stringify(params)
      });
    }
  });
});


$('.addNewMainApplicant').click(function()
{
  //ekyc_pdar_type    ekyc_pdar_name  ekyc_pdar_guardian  ekyc_dob
  //ekyc_gender   ekyc_address    ekyc_appl_asm   ekyc_guar_appl_asm
  //ekyc_marital_status   ekyc_per_add    ekyc_mobile    ekyc_relation 

  var t = inputDataValidation(); // validation
  if(t != null)
  {
    showErrorMessage(t);
    return false;
  }  

  var baseurl            =  $('#baseurl').val();
  var case_no             = $('#case_no').val(); 

  // alert(case_no) ;
  var auth_response       = $('#auth_response').val();
  var ekyc_pdar_type      = $('#ekyc_pdar_type').val();
  var ekyc_pdar_name      = $('#ekyc_pdar_name').val();
  var ekyc_pdar_guardian  = $('#ekyc_pdar_guardian').val();
  var ekyc_dob            = $('.ekyc_dob').val();
  var ekyc_gender         = $('#ekyc_gender').val();
  var ekyc_address        = $('#ekyc_address').val();
  var ekyc_appl_asm       = $('#ekyc_appl_asm').val();
  var ekyc_guar_appl_asm  = $('#ekyc_guar_appl_asm').val();
  var ekyc_marital_status = $('#ekyc_marital_status').val();
  var ekyc_per_add        = $('#ekyc_per_add').val();
  var ekyc_mobile         = $('#ekyc_mobile').val();
  var ekyc_relation       = $('#ekyc_relation').val();
  var ekyc_occ            = $('#ekyc_occ').val();  

  const params = {
    baseurl            : baseurl,
    case_no             : case_no,
    auth_response       : auth_response,
    ekyc_pdar_type      : ekyc_pdar_type,
    ekyc_pdar_name      : ekyc_pdar_name,
    ekyc_pdar_guardian  : ekyc_pdar_guardian,
    ekyc_dob            : ekyc_dob,
    ekyc_gender         : ekyc_gender,
    ekyc_address        : ekyc_address,
    ekyc_appl_asm       : ekyc_appl_asm,
    ekyc_guar_appl_asm  : ekyc_guar_appl_asm,
    ekyc_marital_status : ekyc_marital_status,
    ekyc_per_add        : ekyc_per_add,
    ekyc_mobile         : ekyc_mobile,
    ekyc_relation       : ekyc_relation,
    ekyc_occ            : ekyc_occ,
  };

  console.log(params);

  Swal.fire({
    icon              : 'warning',
    backdrop          : true,
    allowOutsideClick : false,
    text              : 'After click on corfirm button, the previous detail of the applicant will be replaced by this new applicant. Are you sure to proceed ?',
    showCancelButton  : true,
    confirmButtonText : 'CONFIRM',
    // customClass       : {
    //   actions         : 'my-actions',
    //   cancelButton    : 'order-1 right-gap',
    //   confirmButton   : 'order-2',
    //   denyButton      : 'order-3',
    // },
  }).then((result) => {   

    $.ajax({
      url: baseurl + "index.php/ApplicantChangeController/addNewMainApplicant",
      type: "post",
      dataType: "json",
      contentType: "application/json",
      success: function (data) {
        // console.log(data);

        if(data.responseType == 3) // fail
        {
          showErrorMessage(data.message);
        }

        else if(data.responseType == 1) //success
        {
            Swal.fire({
              icon              : 'success',
              backdrop          : true,
              allowOutsideClick : false,
              text              : data.message,
              confirmButtonText : 'OK',
              customClass       : {
                  actions       : 'my-actions',
                  confirmButton : 'order-2',
              }
            }).then((result) => {
                if (result.isConfirmed) {
                  location.reload(true);
                }
                else if (result.isDismissed) {
                  showSuccessMessage("You have not changed main applicant");
                }
            });
        }
      },
      error: function(data) {
        showErrorMessage("Some issue has occured on applying main applicant. Kindly contact system administrator");
      },
      data: JSON.stringify(params)
    });

  });

});



function inputDataValidation()
{
  var s= null;
  if($('#ekyc_pdar_name').val() == '' || $('#ekyc_pdar_name').val() == null)
  {
    s ="Applicant name in english is required";
    return s;
  }
  else if($('#ekyc_pdar_guardian').val() == '' || $('#ekyc_pdar_guardian').val() == null)
  {
    s ="Applicant guardian name in english is required";
    return s;
  }
  else if($('.ekyc_dob').val() == '' || $('.ekyc_dob').val() == null)
  {
    s ="Applicant date of birth is required";
    return s;
  }
  else if($('#ekyc_gender').val() == '' || $('#ekyc_gender').val() == null)
  {
    s ="Applicant gender is required";
    return s;
  }
  else if($('#ekyc_address').val() == '' || $('#ekyc_address').val() == null)
  {
    s ="Applicant present address is required";
    return s;
  }  
  else if($('#ekyc_appl_asm').val() == '' || $('#ekyc_appl_asm').val() == null)
  {
    s = "Applicant name in assamese is required";
    return s;
  }
  else if($('#ekyc_guar_appl_asm').val() == '' || $('#ekyc_guar_appl_asm').val() == null)
  {
    s ="Applicant guardian name in assamese is required";
    return s;
  }
  else if($('#ekyc_marital_status').val() == '' || $('#ekyc_marital_status').val() == null)
  {
    s ="Applicant marital status is required";
    return s;
  }
  else if($('#ekyc_per_add').val() == '' || $('#ekyc_per_add').val() == null)
  {
    s ="Applicant permanent address is required";
    return s;
  }
  else if($('#ekyc_mobile').val() == '' || $('#ekyc_mobile').val() == null)
  {
    s ="Applicant mobile number is required";
    return s;
  }
  else if($('#ekyc_relation').val() == '' || $('#ekyc_relation').val() == null)
  {
    s ="Relation with guardian is required";
    return s;
  }
  else if($('#ekyc_occ').val() == '' || $('#ekyc_occ').val() == null)
  {
    s ="Occupation is required";
    return s;
  }
}




