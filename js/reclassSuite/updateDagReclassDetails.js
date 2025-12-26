
    var applicantModalUpdate = document.getElementById("updateDagReclassDetails");
    // Get the <span> element that closes the modal
    var spanApplicantUpdate = document.getElementsByClassName("close-edit-applicant")[0];

    // alert(spanApplicant);

    function updateDagReclassDetails(dag_no){

        // var applicantModal = document.getElementById("updateDagReclassDetails");
    // Get the <span> element that closes the modal
        // var spanApplicant = document.getElementsByClassName("close-edit-applicant")[0];
        //console.log('xyz');
        //****to display the modal */
         document.getElementById('reclassificationfitYes').checked = false;
         document.getElementById('reclassificationfitNo').checked = false;
         const textarea = document.getElementById('remark');
         textarea.value = '';

        applicantModalUpdate.style.display = "block";

        spanApplicantUpdate.onclick = function() {
            Swal.fire({
                text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: "#B82929",
            }).then((result) => {
                if (result.isConfirmed) {
                    applicantModalUpdate.style.display = "none";
                }
            })
        }
    
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == applicantModalUpdate) {
                Swal.fire({
                    text: 'Closing this modal without saving will erase any edited data ! Are you sure ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: "#B82929",
                }).then((result) => {
                    if (result.isConfirmed) {
                        applicantModalUpdate.style.display = "none";
                    }
                })
            }
        }
        
        var dag_no = $.trim($('#dag_no'+dag_no).val());
        $('#dag_no').val(dag_no);    
    }

    function updateApplicantDetailsReclassfit(){
        var is_reclass = $("input[name='reclassification_nonagri']:checked").val();

        var formData = new FormData();
        var case_no = $.trim($('#case_no').val());
        var dag_no = $.trim($('#dag_no').val());
        
        //validation for the update
        if(is_reclass == '' || is_reclass==undefined)
        {
            alert('This Field is required !');
            $('#is_reclass').focus();
            return false;
        }

        if(is_reclass=='no')
        {
            var remark = $.trim($('#remark').val());
            if(remark == '' || remark==undefined)
            {
                alert('The Remark Field is required !');
                $('#remark').focus();
                return false;
            }

            formData.append('remark', remark);
        }

    
        formData.append('is_reclass', is_reclass);
        formData.append('case_no', case_no);
        formData.append('dag_no', dag_no);


        //prepare for updation
        // var postData = {
        //     'is_prime' : is_prime,
        //     'is_unfit' : is_unfit,
        //     'is_notcult' : is_notcult,
        //     'is_reclass' : is_reclass,
        //     'is_masterplan' : is_masterplan,
        //     'case_no' : case_no,
        //     'dag_no' : dag_no
        // };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'ReclassSuite/updateDagNonagristatusDetails',
            type: "POST",
            processData: false, // important
            contentType: false, // important
            dataType: "json",
            data: formData,
            success: function(data) {
                // arr = JSON.parse(data);
                $.unblockUI();
                if(data.responseType == 0){
                    showErrorMessage(data.msg);
                    return false;
                }
                else{
                    applicantModalUpdate.style.display = "none";
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
                            applicantModalUpdate.style.display = "none";
                            // $('#pdar_name'+applicant_d_id).val(arr.appnData.pdar_name);
                            // $('#pdar_guardian'+applicant_d_id).val(arr.appnData.pdar_guardian);
                            // $('#eng_pdar_name'+applicant_d_id).val(arr.appnData.eng_pdar_name);
                            // $('#eng_pdar_guardian'+applicant_d_id).val(arr.appnData.eng_pdar_guardian);
                            // $('#pdar_rel_guar'+applicant_d_id).val(arr.appnData.pdar_rel_guar);
                            // $('#pdar_gender'+applicant_d_id).val(arr.appnData.pdar_gender);
                            // $('#dob'+applicant_d_id).val(arr.appnData.dob);
                            // $('#marital_status'+applicant_d_id).val(arr.appnData.marital_status);
                            // $('#pdar_mobile'+applicant_d_id).val(arr.appnData.pdar_mobile);
                            // $('#pdar_add1'+applicant_d_id).val(arr.appnData.pdar_add1);
                            // $('#pdar_add2'+applicant_d_id).val(arr.appnData.pdar_add2);
                        }
                    })
                }
            }
        });

    }


    // function updateDagReclassDetails(dag_no){
    //     //****to display the modal */
    //     //e.preventDefault(); 
    //     var dag_no = $.trim($('#dag_no'+dag_no).val());
    //     var case_no = $.trim($('#case_no').val());
        
    //     $('#dag_no').val(dag_no);
    //     var formData = new FormData();
    //     formData.append('dag_no', dag_no);
    //     formData.append('case_no', case_no);

    //      $.ajax({
    //         url: baseurl+'ReclassSuite/updateDagNonagristatusDetails',
    //         type: "POST",
    //         processData: false, // important
    //         contentType: false, // important
    //         dataType: "json",
    //         data: formData,
    //         success: function(data) {
    //             // arr = JSON.parse(data);
    //             $.unblockUI();
    //             if(data.responseType == 0){
    //                 showErrorMessage(data.msg);
    //                 return false;
    //             }
    //             else{
    //                 applicantModal.style.display = "none";
    //                 Swal.fire({
    //                         text: data.msg,
    //                         icon: 'success',
    //                         confirmButtonText: 'OK',
    //                         customClass: {
    //                             actions: 'my-actions',
    //                             confirmButton: 'order-2',
    //                         }
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                     // const radio = document.querySelector(
    //                     // `input[name="agritononagri_verified${dag_no}"][value="${data.updatedValue}"]`
    //                     // );
    //                     // if (radio) {
    //                     //     radio.checked = true;
    //                     // }
    //                     }
    //                 })
    //             }
    //         }
    //     });

    // }