
    var addApplicantModal = document.getElementById("addApplicantDetails");
    // Get the <span> element that closes the modal
    var addSpanApplicant = document.getElementsByClassName("close-add-applicant")[0];

    function openApplicant(){
        //****to display the modal */
        addApplicantModal.style.display = "block";

        addSpanApplicant.onclick = function() {
            Swal.fire({
                text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: "#B82929",
            }).then((result) => {
                if (result.isConfirmed) {
                    addApplicantModal.style.display = "none";
                }
            })
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == addApplicantModal) {
                Swal.fire({
                    text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: "#B82929",
                }).then((result) => {
                    if (result.isConfirmed) {
                        addApplicantModal.style.display = "none";
                    }
                })
            }
        }
              
    }

    function addApplicant(){

        var case_no = $.trim($('#case_no').val());
        
        var add_applicant_name_ass = $.trim($('#add_applicant_name_ass').val());
        var add_applicant_name_eng = $.trim($('#add_applicant_name_eng').val());
        var add_guardian_name_ass = $.trim($('#add_guardian_name_ass').val());
        var add_guardian_name_eng = $.trim($('#add_guardian_name_eng').val());
        var add_relation = $.trim($('#add_relation').val());
        var add_gender = $.trim($('#add_gender').val());
        var add_dob = $.trim($('#add_dob').val());
        var add_marital_status = $.trim($('#add_marital_status').val());
        var add_mobile = $.trim($('#add_mobile').val());
        var add_per_address = $.trim($('#add_per_address').val());
        var add_pre_address = $.trim($('#add_pre_address').val());


        //validation for applicant add

        if(add_applicant_name_ass == ''){
            alert('This Field is required !');
            $('#add_applicant_name_ass').focus();
            return false;
        }
        if(add_applicant_name_eng == ''){
            alert('This Field is required !');
            $('#add_applicant_name_eng').focus();
            return false;
        }
        if(add_guardian_name_ass == ''){
            alert('This Field is required !');
            $('#add_guardian_name_ass').focus();
            return false;
        }
        if(add_guardian_name_eng == ''){
            alert('This Field is required !');
            $('#add_guardian_name_eng').focus();
            return false;
        }
        if(add_relation == ''){
            alert('This Field is required !');
            $('#add_relation').focus();
            return false;
        }
        if(add_gender == ''){
            alert('This Field is required !');
            $('#add_gender').focus();
            return false;
        }
        if(add_dob == ''){
            alert('This Field is required !');
            $('#add_dob').focus();
            return false;
        }

        if(add_marital_status == ''){
            alert('Marital status Field is required !');
            $('#add_marital_status').focus();
            return false;
        }  
     
        if(add_mobile == ''){
            alert('This Field is required !');
            $('#add_mobile').focus();
            return false;
        }
        if(add_per_address == ''){
            alert('This Field is required !');
            $('#add_per_address').focus();
            return false;
        }
        if(add_pre_address == ''){
            alert('This Field is required !');
            $('#add_pre_address').focus();
            return false;
        }

        //data for applicant add
        var postData = {
            'case_no' : case_no,
            'add_applicant_name_ass' : add_applicant_name_ass,
            'add_applicant_name_eng' : add_applicant_name_eng,
            'add_guardian_name_ass' : add_guardian_name_ass,
            'add_guardian_name_eng' : add_guardian_name_eng,
            'add_relation' : add_relation,
            'add_gender' : add_gender,
            'add_dob' : add_dob,
            'add_marital_status' : add_marital_status,
            'add_mobile' : add_mobile,
            'add_per_address' : add_per_address,
            'add_pre_address' : add_pre_address,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementCommon/addApplicantDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }
                else{
                    addApplicantModal.style.display = "none";
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            addApplicantModal.style.display = "none";
                            $("#applicantData").append('<table id="appRow'+arr.appnData.id+'" class="table table-bordered"><tbody><tr><th rowspan="6" style="vertical-align : middle;text-align:center;">'+arr.appnData.count+'</th> '+
                            '<th>Applicant Name (Assamese)</th><td>'+
                            '<input type="text" name="pdar_name'+arr.appnData.id+'" id="pdar_name'+arr.appnData.id+'" readonly="" value='+arr.appnData.pdar_name+' class="form-control input-sm"></td>'+
                            '<th>Guardian Name (Assamese)</th><td>'+
                            '<input type="text" name="pdar_guardian'+arr.appnData.id+'" id="pdar_guardian'+arr.appnData.id+'" readonly="" value='+arr.appnData.pdar_guardian+' class="form-control input-sm"></td></tr>'+
                            '<tr><th>Applicant Name (English)</th><td>'+
                            '<input type="text" name="eng_pdar_name'+arr.appnData.id+'" id="eng_pdar_name'+arr.appnData.id+'" readonly="" class="form-control" value='+arr.appnData.eng_pdar_name+'></td>'+
                            '<th>Guardian Name (English)</th><td>'+
                            '<input type="text" readonly="" name="eng_pdar_guardian'+arr.appnData.id+'" id="eng_pdar_guardian'+arr.appnData.id+'" class="form-control" value='+arr.appnData.eng_pdar_guardian+'></td></tr>'+
                            '<tr><th>Relation</th><td><select disabled="" name="pdar_rel_guar'+arr.appnData.id+'" id="pdar_rel_guar'+arr.appnData.id+'" class="form-control">'+
                            '<option value='+arr.appnData.pdar_rel_guar+'>'+arr.appnData.relation_name+'</option></select></td><th>Gender</th>'+
                            '<td><select disabled="" name="pdar_gender'+arr.appnData.id+'" id="pdar_gender'+arr.appnData.id+'" class="form-control input_editable_background">'+
                            '<option value='+arr.appnData.pdar_gender+'>'+arr.appnData.gender+'</option></select></td></tr><tr><th>DOB</th>'+
                            '<td><input type="text" readonly="" id="dob'+arr.appnData.id+'" name="dob'+arr.appnData.id+'" value='+arr.appnData.dob+' class="form-control input-sm"></td>'+
                            '</strong></td></tr>'+
                            '<tr><th>Mobile</th><td><input type="text" readonly="" name="pdar_mobile'+arr.appnData.id+'" id="pdar_mobile'+arr.appnData.id+'" value='+arr.appnData.pdar_mobile+' class="form-control input-sm"></td>'+
                            '<th>Permanent address</th><td><input type="text" readonly="" name="pdar_add1'+arr.appnData.id+'" id="pdar_add1'+arr.appnData.id+'" value='+arr.appnData.pdar_add1+' class="form-control input-sm"></td></tr>'+
                            '<tr><th>Present address</th><td><input type="text" readonly="" name="pdar_add2'+arr.appnData.id+'" id="pdar_add2'+arr.appnData.id+'" value='+arr.appnData.pdar_add2+' class="form-control input-sm"></td>'+
                            '<td colspan="2" style="vertical-align : middle;text-align:center;">'+
                            '<button type="button" onclick="editApplicant('+arr.appnData.id+', 0);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>'+
                            '<button type="button" onclick="openApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button>'+
                            '<button type="button" onclick="confirmDeleteApplicant('+arr.appnData.id+');" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i><strong>Delete</strong></button>'+
                            '</td></tr></tbody></table>');

                            $('#add_applicant_name_ass').val('');
                            $('#add_applicant_name_eng').val('');
                            $('#add_guardian_name_ass').val('');
                            $('#add_guardian_name_eng').val('');
                            $('#add_mobile').val('');
                            $('#add_per_address').val('');
                            $('#add_pre_address').val('');
                            $('#add_relation').val('');
                            $('#add_gender').val('');
                            $('#add_marital_status').val('');
                            $('#add_dob').val('');
                        }
                    })
                }
            }
        });

    }

// applicant delete
function confirmDeleteApplicant(id)
{
  case_no = $('#case_no').val();
  // $("#appRow" + id).remove();
  if(confirm("Are you sure you want to delete this Record?")){
    $.ajax({
      type: "POST",
      url: baseurl+'SettlementCommon/delApplicantDetails',
      async: false,
      // dataType: 'json',
      data: { id: id, case_no:case_no },
      success: function (response) {
        const data = JSON.parse(response);
        // console.log(data);
        if(data.status == 0)
        {
          showErrorMessage("something went wrong!!");
        }
        else {
          $("#appRow" + id).remove();                  
          showSuccessMessage("Applicant Deleted!!");
          // $("#next_of_kin_count option[value="+data.count+"]").prop('selected', 'selected');
        }         
      }
    });
  }
  else {
    // loading.out();
  }
}