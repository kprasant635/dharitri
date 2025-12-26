
    var applicantModal = document.getElementById("editApplicantDetails");
    // Get the <span> element that closes the modal
    var spanApplicant = document.getElementsByClassName("close-edit-applicant")[0];

    function editApplicant(id, is_applicant){
        //****to display the modal */
        applicantModal.style.display = "block";

        //******hide/show marital_status according to the is_applicant */
        if(is_applicant != 1){
            $('.marital-status-condition').hide();
        }
        if(is_applicant == 1){
            $('.marital-status-condition').show();
        }

        spanApplicant.onclick = function() {
            Swal.fire({
                text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: "#B82929",
            }).then((result) => {
                if (result.isConfirmed) {
                    applicantModal.style.display = "none";
                }
            })
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == applicantModal) {
                Swal.fire({
                    text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: "#B82929",
                }).then((result) => {
                    if (result.isConfirmed) {
                        applicantModal.style.display = "none";
                    }
                })
            }
        }

        if(is_applicant == 1)
        {
            $('#applicant_d_applicant_name_eng').prop("readonly", true);            
        }
        
        var pdar_name = $.trim($('#pdar_name'+id).val());
        var pdar_guardian = $.trim($('#pdar_guardian'+id).val());
        var eng_pdar_name = $.trim($('#eng_pdar_name'+id).val());
        var eng_pdar_guardian = $.trim($('#eng_pdar_guardian'+id).val());
        var pdar_rel_guar = $.trim($('#pdar_rel_guar'+id).val());
        var pdar_gender = $.trim($('#pdar_gender'+id).val());
        var dob = $.trim($('#dob'+id).val());
        var marital_status = $.trim($('#marital_status'+id).val());
        var pdar_mobile = $.trim($('#pdar_mobile'+id).val());
        var pdar_add1 = $.trim($('#pdar_add1'+id).val());
        var pdar_add2 = $.trim($('#pdar_add2'+id).val());
        
        $('#applicant_d_id').val(id);
        $('#applicant_d_is_applicant').val(is_applicant);

        $('#applicant_d_applicant_name_ass').val(pdar_name);
        $('#applicant_d_applicant_name_eng').val(eng_pdar_name);
        $('#applicant_d_guardian_name_ass').val(pdar_guardian);
        $('#applicant_d_guardian_name_eng').val(eng_pdar_guardian);
        $('#applicant_d_relation').val(pdar_rel_guar);
        $('#applicant_d_gender').val(pdar_gender);
        $('#applicant_d_dob').val(dob);
        $('#applicant_d_marital_status').val(marital_status);
        $('#applicant_d_mobile').val(pdar_mobile);
        $('#applicant_d_per_address').val(pdar_add1);
        $('#applicant_d_pre_address').val(pdar_add2);      
    }

    function updateApplicantDetails(){
        var applicant_d_id = $.trim($('#applicant_d_id').val());
        var applicant_d_is_applicant = $.trim($('#applicant_d_is_applicant').val());

        // alert(applicant_d_is_applicant); return;

        var case_no = $.trim($('#case_no').val());
        var applicant_d_applicant_name_ass = $.trim($('#applicant_d_applicant_name_ass').val());
        var applicant_d_applicant_name_eng = $.trim($('#applicant_d_applicant_name_eng').val());
        var applicant_d_guardian_name_ass = $.trim($('#applicant_d_guardian_name_ass').val());
        var applicant_d_guardian_name_eng = $.trim($('#applicant_d_guardian_name_eng').val());
        var applicant_d_relation = $.trim($('#applicant_d_relation').val());
        var applicant_d_gender = $.trim($('#applicant_d_gender').val());
        var applicant_d_dob = $.trim($('#applicant_d_dob').val());
        var applicant_d_marital_status = $.trim($('#applicant_d_marital_status').val());
        var applicant_d_mobile = $.trim($('#applicant_d_mobile').val());
        var applicant_d_per_address = $.trim($('#applicant_d_per_address').val());
        var applicant_d_pre_address = $.trim($('#applicant_d_pre_address').val());


        //validation for the update
        if(applicant_d_id == ''){
            alert('This Field is required !');
            $('#applicant_d_id').focus();
            return false;
        }
        if(applicant_d_applicant_name_ass == ''){
            alert('This Field is required !');
            $('#applicant_d_applicant_name_ass').focus();
            return false;
        }
        if(applicant_d_applicant_name_eng == ''){
            alert('This Field is required !');
            $('#applicant_d_applicant_name_eng').focus();
            return false;
        }
        if(applicant_d_guardian_name_ass == ''){
            alert('This Field is required !');
            $('#applicant_d_guardian_name_ass').focus();
            return false;
        }
        if(applicant_d_guardian_name_eng == ''){
            alert('This Field is required !');
            $('#applicant_d_guardian_name_eng').focus();
            return false;
        }
        if(applicant_d_relation == ''){
            alert('This Field is required !');
            $('#applicant_d_relation').focus();
            return false;
        }
        if(applicant_d_gender == ''){
            alert('This Field is required !');
            $('#applicant_d_gender').focus();
            return false;
        }
        if(applicant_d_dob == ''){
            alert('This Field is required !');
            $('#applicant_d_dob').focus();
            return false;
        }
        if(applicant_d_is_applicant == 1){
            if(applicant_d_marital_status == ''){
                alert('Marital status Field is required !');
                $('#applicant_d_marital_status').focus();
                return false;
            }
        }
     
        if(applicant_d_mobile == ''){
            alert('This Field is required !');
            $('#applicant_d_mobile').focus();
            return false;
        }
        if(applicant_d_per_address == ''){
            alert('This Field is required !');
            $('#applicant_d_per_address').focus();
            return false;
        }
        if(applicant_d_pre_address == ''){
            alert('This Field is required !');
            $('#applicant_d_pre_address').focus();
            return false;
        }

        //prepare for updation
        var postData = {
            'applicant_d_id' : applicant_d_id,
            'applicant_d_is_applicant' : applicant_d_is_applicant,
            'case_no' : case_no,
            'applicant_d_applicant_name_ass' : applicant_d_applicant_name_ass,
            'applicant_d_applicant_name_eng' : applicant_d_applicant_name_eng,
            'applicant_d_guardian_name_ass' : applicant_d_guardian_name_ass,
            'applicant_d_guardian_name_eng' : applicant_d_guardian_name_eng,
            'applicant_d_relation' : applicant_d_relation,
            'applicant_d_gender' : applicant_d_gender,
            'applicant_d_dob' : applicant_d_dob,
            'applicant_d_marital_status' : applicant_d_marital_status,
            'applicant_d_mobile' : applicant_d_mobile,
            'applicant_d_per_address' : applicant_d_per_address,
            'applicant_d_pre_address' : applicant_d_pre_address,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementCommon/updateApplicantDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }
                else{
                    applicantModal.style.display = "none";
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
                            applicantModal.style.display = "none";
                            $('#pdar_name'+applicant_d_id).val(arr.appnData.pdar_name);
                            $('#pdar_guardian'+applicant_d_id).val(arr.appnData.pdar_guardian);
                            $('#eng_pdar_name'+applicant_d_id).val(arr.appnData.eng_pdar_name);
                            $('#eng_pdar_guardian'+applicant_d_id).val(arr.appnData.eng_pdar_guardian);
                            $('#pdar_rel_guar'+applicant_d_id).val(arr.appnData.pdar_rel_guar);
                            $('#pdar_gender'+applicant_d_id).val(arr.appnData.pdar_gender);
                            $('#dob'+applicant_d_id).val(arr.appnData.dob);
                            $('#marital_status'+applicant_d_id).val(arr.appnData.marital_status);
                            $('#pdar_mobile'+applicant_d_id).val(arr.appnData.pdar_mobile);
                            $('#pdar_add1'+applicant_d_id).val(arr.appnData.pdar_add1);
                            $('#pdar_add2'+applicant_d_id).val(arr.appnData.pdar_add2);
                        }
                    })
                }
            }
        });

    }