
    var applicantModal = document.getElementById("editTeaApplicantDetails");
    // Get the <span> element that closes the modal
    var spanApplicant = document.getElementsByClassName("close-edit-applicant")[0];

    function editApplicantRevertTea(id, is_applicant){

        // alert(id);
        // alert(is_applicant);

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
            $('#applicant_tea_applicant_name_eng').prop("readonly", true);            
        }
        
        var pdar_name         = $.trim($('#pdar_name'+id).val());
        var pdar_guardian     = $.trim($('#pdar_guardian'+id).val());
        var eng_pdar_name     = $.trim($('#eng_pdar_name'+id).val());
        var eng_pdar_guardian = $.trim($('#eng_pdar_guardian'+id).val());
        var pdar_rel_guar     = $.trim($('#pdar_rel_guar'+id).val());
        var pdar_gender       = $.trim($('#pdar_gender'+id).val());
        var dob               = $.trim($('#dob'+id).val());
        var marital_status    = $.trim($('#marital_status'+id).val());
        var pdar_mobile       = $.trim($('#pdar_mobile'+id).val());
        var pdar_add1         = $.trim($('#pdar_add1'+id).val());
        var pdar_add2         = $.trim($('#pdar_add2'+id).val());
        
        $('#applicant_tea_id').val(id);
        $('#applicant_tea_is_applicant').val(is_applicant);

        $('#applicant_tea_applicant_name_ass').val(pdar_name);
        $('#applicant_tea_applicant_name_eng').val(eng_pdar_name);
        $('#applicant_tea_guardian_name_ass').val(pdar_guardian);
        $('#applicant_tea_guardian_name_eng').val(eng_pdar_guardian);
        $('#applicant_tea_relation').val(pdar_rel_guar);
        $('#applicant_tea_gender').val(pdar_gender);
        $('#applicant_tea_dob').val(dob);
        $('#applicant_tea_marital_status').val(marital_status);
        $('#applicant_tea_mobile').val(pdar_mobile);
        $('#applicant_tea_per_address').val(pdar_add1);
        $('#applicant_tea_pre_address').val(pdar_add2);      
    }

    function updateTeaApplicantDetails(){
        var applicant_tea_id           = $.trim($('#applicant_tea_id').val());
        var applicant_tea_is_applicant = $.trim($('#applicant_tea_is_applicant').val());

        // alert(applicant_tea_is_applicant); return;

        var case_no = $.trim($('#case_no').val());
        var applicant_tea_applicant_name_ass = $.trim($('#applicant_tea_applicant_name_ass').val());
        var applicant_tea_applicant_name_eng = $.trim($('#applicant_tea_applicant_name_eng').val());
        var applicant_tea_guardian_name_ass  = $.trim($('#applicant_tea_guardian_name_ass').val());
        var applicant_tea_guardian_name_eng  = $.trim($('#applicant_tea_guardian_name_eng').val());
        var applicant_tea_relation           = $.trim($('#applicant_tea_relation').val());
        var applicant_tea_gender             = $.trim($('#applicant_tea_gender').val());
        var applicant_tea_dob                = $.trim($('#applicant_tea_dob').val());
        var applicant_tea_marital_status     = $.trim($('#applicant_tea_marital_status').val());
        var applicant_tea_mobile             = $.trim($('#applicant_tea_mobile').val());
        var applicant_tea_per_address        = $.trim($('#applicant_tea_per_address').val());
        var applicant_tea_pre_address        = $.trim($('#applicant_tea_pre_address').val());


        //validation for the update
        if(applicant_tea_id == ''){
            alert('This Field is required !');
            $('#applicant_tea_id').focus();
            return false;
        }
        if(applicant_tea_applicant_name_ass == ''){
            alert('This Field is required !');
            $('#applicant_tea_applicant_name_ass').focus();
            return false;
        }
        if(applicant_tea_applicant_name_eng == ''){
            alert('This Field is required !');
            $('#applicant_tea_applicant_name_eng').focus();
            return false;
        }
        if(applicant_tea_guardian_name_ass == ''){
            alert('This Field is required !');
            $('#applicant_tea_guardian_name_ass').focus();
            return false;
        }
        if(applicant_tea_guardian_name_eng == ''){
            alert('This Field is required !');
            $('#applicant_tea_guardian_name_eng').focus();
            return false;
        }
        if(applicant_tea_relation == ''){
            alert('This Field is required !');
            $('#applicant_tea_relation').focus();
            return false;
        }
        if(applicant_tea_gender == ''){
            alert('This Field is required !');
            $('#applicant_tea_gender').focus();
            return false;
        }
        if(applicant_tea_dob == ''){
            alert('This Field is required !');
            $('#applicant_tea_dob').focus();
            return false;
        }
        if(applicant_tea_is_applicant == 1){
            if(applicant_tea_marital_status == ''){
                alert('Marital status Field is required !');
                $('#applicant_tea_marital_status').focus();
                return false;
            }
        }
     
        if(applicant_tea_mobile == ''){
            alert('This Field is required !');
            $('#applicant_tea_mobile').focus();
            return false;
        }
        if(applicant_tea_per_address == ''){
            alert('This Field is required !');
            $('#applicant_tea_per_address').focus();
            return false;
        }
        if(applicant_tea_pre_address == ''){
            alert('This Field is required !');
            $('#applicant_tea_pre_address').focus();
            return false;
        }

        //prepare for updation
        var postData = {
            'applicant_tea_id'                 : applicant_tea_id,
            'applicant_tea_is_applicant'       : applicant_tea_is_applicant,
            'case_no'                          : case_no,
            'applicant_tea_applicant_name_ass' : applicant_tea_applicant_name_ass,
            'applicant_tea_applicant_name_eng' : applicant_tea_applicant_name_eng,
            'applicant_tea_guardian_name_ass'  : applicant_tea_guardian_name_ass,
            'applicant_tea_guardian_name_eng'  : applicant_tea_guardian_name_eng,
            'applicant_tea_relation'           : applicant_tea_relation,
            'applicant_tea_gender'             : applicant_tea_gender,
            'applicant_tea_dob'                : applicant_tea_dob,
            'applicant_tea_marital_status'     : applicant_tea_marital_status,
            'applicant_tea_mobile'             : applicant_tea_mobile,
            'applicant_tea_per_address'        : applicant_tea_per_address,
            'applicant_tea_pre_address'        : applicant_tea_pre_address,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'TeaGrantControllerLm/updateTeaApplicantDetails',
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
                            $('#pdar_name'+applicant_tea_id).val(arr.appnData.pdar_name);
                            $('#pdar_guardian'+applicant_tea_id).val(arr.appnData.pdar_guardian);
                            $('#eng_pdar_name'+applicant_tea_id).val(arr.appnData.eng_pdar_name);
                            $('#eng_pdar_guardian'+applicant_tea_id).val(arr.appnData.eng_pdar_guardian);
                            $('#pdar_rel_guar'+applicant_tea_id).val(arr.appnData.pdar_rel_guar);
                            $('#pdar_gender'+applicant_tea_id).val(arr.appnData.pdar_gender);
                            $('#dob'+applicant_tea_id).val(arr.appnData.dob);
                            $('#marital_status'+applicant_tea_id).val(arr.appnData.marital_status);
                            $('#pdar_mobile'+applicant_tea_id).val(arr.appnData.pdar_mobile);
                            $('#pdar_add1'+applicant_tea_id).val(arr.appnData.pdar_add1);
                            $('#pdar_add2'+applicant_tea_id).val(arr.appnData.pdar_add2);
                        }
                    })
                }
            }
        });

    }


    $('.tea_close_modal').on('click', function(){
        applicantModal.style.display = "none";
    })