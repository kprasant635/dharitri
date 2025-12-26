
    var addApplicantModal = document.getElementById("addTenantApplicantDetails");

    function openTenantApplicant(){
        //****to display the modal */
        addApplicantModal.style.display = "block";
    
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

    $('.close-add-tenant-applicant').click(function(){
        addApplicantModal.style.display = "none";
    })

    function addTenantApplicant(){

        // e.preventDefault();

        var formData = new FormData();
        formData.append('case_no', $('#case_no').val());
        formData.append('applicant_name_ass', $('#add_tenant_applicant_name_ass').val());
        formData.append('applicant_name_eng', $('#add_tenant_applicant_name_eng').val());
        formData.append('guardian_name_ass', $('#add_tenant_guardian_name_ass').val());
        formData.append('guardian_name_eng', $('#add_tenant_guardian_name_eng').val());
        formData.append('relation', $('#add_tenant_relation').val());
        formData.append('gender', $('#add_tenant_gender').val());
        formData.append('dob', $('#add_tenant_dob').val());
        formData.append('marital_status', $('#add_tenant_marital_status').val());
        formData.append('mobile', $('#add_tenant_mobile').val());
        formData.append('per_address', $('#add_tenant_per_address').val());
        formData.append('pre_address', $('#add_tenant_pre_address').val());

        var fileInput = $('#add_tenant_upload_noc')[0];
        if(fileInput.files.length > 0){
            formData.append('noc_file', fileInput.files[0]);
        }

        //validation for applicant add

        if($('#add_tenant_applicant_name_ass').val() == ''){
            alert('Applicant Name in assamese is required !');
            $('#add_tenant_applicant_name_ass').focus();
            return false;
        }
        if($('#add_tenant_applicant_name_eng').val() == ''){
            alert('Applicant Name in english is required !');
            $('#add_tenant_applicant_name_eng').focus();
            return false;
        }
        if($('#add_tenant_guardian_name_ass').val() == ''){
            alert('Guardian Name in assamese is required !');
            $('#add_tenant_guardian_name_ass').focus();
            return false;
        }
        if($('#add_tenant_guardian_name_eng').val() == ''){
            alert('Guardian Name in english is required !');
            $('#add_tenant_guardian_name_eng').focus();
            return false;
        }
        if($('#add_tenant_relation').val() == ''){
            alert('Relation is required !');
            $('#add_tenant_relation').focus();
            return false;
        }
        if($('#add_tenant_gender').val() == ''){
            alert('Gender is required !');
            $('#add_tenant_gender').focus();
            return false;
        }
        if($('#add_tenant_dob').val() == ''){
            alert('DOB is required !');
            $('#add_tenant_dob').focus();
            return false;
        }

        if($('#add_tenant_marital_status').val() == ''){
            alert('Marital status Field is required !');
            $('#add_tenant_marital_status').focus();
            return false;
        }  
     
        if($('#add_tenant_mobile').val() == ''){
            alert('Mobile is required !');
            $('#add_tenant_mobile').focus();
            return false;
        }
        if($('#add_tenant_per_address').val() == ''){
            alert('Present address is required !');
            $('#add_tenant_per_address').focus();
            return false;
        }
        if($('#add_tenant_pre_address').val() == ''){
            alert('Permanent address is required !');
            $('#add_tenant_pre_address').focus();
            return false;
        }
        if(fileInput.files.length == 0){
            alert('NOC upload is mandatory !');
            $('#add_tenant_upload_noc').focus();
            return false;
        }

        // $.blockUI({
        //     message: $('#displayBox'),
        //     css: {
        //         border:'none',
        //         backgroundColor:'transparent'
        //     }
        // });

        $.ajax({
            url: baseurl+'SettlementTenantUrban/addApplicantDetails',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",

            success: function(data) {

                // console.log(data);
               
                // $.unblockUI();
                if(data.responseType == 0){
                    showErrorMessage(data.msg);
                }
                else{
                    addApplicantModal.style.display = "none";
                    Swal.fire({
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            addApplicantModal.style.display = "none";
                            $("#applicantData").append('<table id="appRow'+data.appnData.id+'" class="table table-bordered"><tbody><tr><th rowspan="6" style="vertical-align : middle;text-align:center;">'+data.appnData.count+'</th> '+
                            '<th>Applicant Name (Assamese)</th><td>'+
                            '<input type="text" name="pdar_name'+data.appnData.id+'" id="pdar_name'+data.appnData.id+'" readonly="" value='+data.appnData.pdar_name+' class="form-control input-sm"></td>'+
                            '<th>Guardian Name (Assamese)</th><td>'+
                            '<input type="text" name="pdar_guardian'+data.appnData.id+'" id="pdar_guardian'+data.appnData.id+'" readonly="" value='+data.appnData.pdar_guardian+' class="form-control input-sm"></td></tr>'+
                            '<tr><th>Applicant Name (English)</th><td>'+
                            '<input type="text" name="eng_pdar_name'+data.appnData.id+'" id="eng_pdar_name'+data.appnData.id+'" readonly="" class="form-control" value='+data.appnData.eng_pdar_name+'></td>'+
                            '<th>Guardian Name (English)</th><td>'+
                            '<input type="text" readonly="" name="eng_pdar_guardian'+data.appnData.id+'" id="eng_pdar_guardian'+data.appnData.id+'" class="form-control" value='+data.appnData.eng_pdar_guardian+'></td></tr>'+
                            '<tr><th>Relation</th><td><select disabled="" name="pdar_rel_guar'+data.appnData.id+'" id="pdar_rel_guar'+data.appnData.id+'" class="form-control">'+
                            '<option value='+data.appnData.pdar_rel_guar+'>'+data.appnData.relation_name+'</option></select></td><th>Gender</th>'+
                            '<td><select disabled="" name="pdar_gender'+data.appnData.id+'" id="pdar_gender'+data.appnData.id+'" class="form-control input_editable_background">'+
                            '<option value='+data.appnData.pdar_gender+'>'+data.appnData.gender+'</option></select></td></tr><tr><th>DOB</th>'+
                            '<td><input type="text" readonly="" id="dob'+data.appnData.id+'" name="dob'+data.appnData.id+'" value='+data.appnData.dob+' class="form-control input-sm"></td>'+
                            '</strong></td></tr>'+
                            '<tr><th>Mobile</th><td><input type="text" readonly="" name="pdar_mobile'+data.appnData.id+'" id="pdar_mobile'+data.appnData.id+'" value='+data.appnData.pdar_mobile+' class="form-control input-sm"></td>'+
                            '<th>Permanent address</th><td><input type="text" readonly="" name="pdar_add1'+data.appnData.id+'" id="pdar_add1'+data.appnData.id+'" value='+data.appnData.pdar_add1+' class="form-control input-sm"></td></tr>'+
                            '<tr><th>Present address</th><td><input type="text" readonly="" name="pdar_add2'+data.appnData.id+'" id="pdar_add2'+data.appnData.id+'" value='+data.appnData.pdar_add2+' class="form-control input-sm"></td></tr>'+
                            '<tr><td>'+
                            '<button type="button" onclick="confirmTenantDeleteApplicant('+data.appnData.id+');" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i><strong>Delete</strong></button>'+
                            '</td></tr></tbody></table>');

                            $('#add_tenant_applicant_name_ass').val('');
                            $('#add_tenant_applicant_name_eng').val('');
                            $('#add_tenant_guardian_name_ass').val('');
                            $('#add_tenant_guardian_name_eng').val('');
                            $('#add_tenant_mobile').val('');
                            $('#add_tenant_per_address').val('');
                            $('#add_tenant_pre_address').val('');
                            $('#add_tenant_relation').val('');
                            $('#add_tenant_gender').val('');
                            $('#add_tenant_marital_status').val('');
                            $('#add_tenant_dob').val('');
                            
                        }
                    })
                }
            }
        });

    }

// applicant delete
function confirmTenantDeleteApplicant(id)
{
  case_no = $('#case_no').val();
  // $("#appRow" + id).remove();
  if(confirm("Are you sure you want to delete this Record?")){
    $.ajax({
      type: "POST",
      url: baseurl+'SettlementTenantUrban/delApplicantDetails',
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