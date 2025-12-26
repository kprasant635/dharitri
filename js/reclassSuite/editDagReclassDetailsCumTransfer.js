
    var applicantModal = document.getElementById("editDagReclassDetailsCumTransfer");
    //console.log(applicantModal);return;
    // Get the <span> element that closes the modal
    var spanApplicant = document.getElementsByClassName("close-edit-applicant")[0];

    // alert(spanApplicant);

    function editDagReclassDetailsCumTransfer(dag_no){
        var applicantModal = document.getElementById("editDagReclassDetailsCumTransfer");
        var spanApplicant = document.getElementsByClassName("close-edit-applicant")[0];
        //console.log('abc')
        //****to display the modal */
         document.getElementById('primeAgriYes').checked = false;
         document.getElementById('primeAgriNo').checked = false;
         document.getElementById('unfitYes').checked = false;
         document.getElementById('unfitNo').checked = false;
         document.getElementById('notUnderYes').checked = false;
         document.getElementById('notUnderNo').checked = false;
         //document.getElementById('recommendedDocument').checked = false;
         document.getElementById('reclassificationYes').checked = false;
         document.getElementById('reclassificationNo').checked = false;
         //document.getElementById('masterPlanYes').checked = false;
         //document.getElementById('masterPlanNo').checked = false;

         var fileInput = document.getElementById("recommendedDocument");
         fileInput.value = "";
         

        // const radio1 = document.getElementById('');
        // if (radio1) {
        //     radio1.checked = false;
        // }
        console.log(applicantModal);
        applicantModal.style.display = "block";

        //******hide/show marital_status according to the is_applicant */
        // if(is_applicant != 1){
        //     $('.marital-status-condition').hide();
        // }
        // if(is_applicant == 1){
        //     $('.marital-status-condition').show();
        // }

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
        
        var dag_no = $.trim($('#dag_no'+dag_no).val());
        // var pdar_name = $.trim($('#pdar_name'+id).val());
        // var pdar_guardian = $.trim($('#pdar_guardian'+id).val());
        // var eng_pdar_name = $.trim($('#eng_pdar_name'+id).val());
        // var eng_pdar_guardian = $.trim($('#eng_pdar_guardian'+id).val());
        // var pdar_rel_guar = $.trim($('#pdar_rel_guar'+id).val());
        // var pdar_gender = $.trim($('#pdar_gender'+id).val());
        // var dob = $.trim($('#dob'+id).val());
        // var marital_status = $.trim($('#marital_status'+id).val());
        // var pdar_mobile = $.trim($('#pdar_mobile'+id).val());
        // var pdar_add1 = $.trim($('#pdar_add1'+id).val());
        // var pdar_add2 = $.trim($('#pdar_add2'+id).val());
        
        //$('#applicant_d_id').val(id);
        //$('#applicant_d_is_applicant').val(is_applicant);

        $('#dag_no').val(dag_no);

        // $('#applicant_d_applicant_name_ass').val(pdar_name);
        // $('#applicant_d_applicant_name_eng').val(eng_pdar_name);
        // $('#applicant_d_guardian_name_ass').val(pdar_guardian);
        // $('#applicant_d_guardian_name_eng').val(eng_pdar_guardian);
        // $('#applicant_d_relation').val(pdar_rel_guar);
        // $('#applicant_d_gender').val(pdar_gender);
        // $('#applicant_d_dob').val(dob);
        // $('#applicant_d_marital_status').val(marital_status);
        // $('#applicant_d_mobile').val(pdar_mobile);
        // $('#applicant_d_per_address').val(pdar_add1);
        // $('#applicant_d_pre_address').val(pdar_add2);      
    }

    function updateApplicantDetailsCumTransfer(){
        var is_prime = $("input[name='primeAgriLand']:checked").val();

        var formData = new FormData();
        

        if(is_prime=='no')
        {
            var is_unfit = $("input[name='unfitForCultivation']:checked").val();
            var is_notcult = $("input[name='notUnderCultivation']:checked").val();
            var is_reclass = $("input[name='reclassification']:checked").val();
            var is_vicinity = $("input[name='notUnderCultivationVicinity']:checked").val();
            var remark= $("#remark").val();
            var remarkVicinity= $("#remarkVicinity").val();

            if(is_unfit=='yes')
            {

            var fileInput = $('#recommendedDocument')[0];
            if (fileInput.files.length === 0) {
                alert('Please select a file to upload.');
                return;
            }

            // Create FormData object
            
            // Append the file
            formData.append('recommendedDocument', fileInput.files[0]);

            if($("#remark").val().trim().length < 1)
            {
              alert("Please Enter Your Remark");
              return; 
            }

            var check_dept = [];
            $.each($("input[name='lineDept[]']:checked"), function() {
              check_dept.push($(this).val());
            });

            if (check_dept.length === 0) {
              alert("Select at least one Department");
              return;
            }

            }

            if(is_vicinity == '' || is_vicinity==undefined){
            alert('The Vicinity Field is required !');
            $('#is_vicinity').focus();
            return false;  
            }

            if(is_prime == '' || is_prime==undefined){
            alert('This Field is required !');
            $('#is_prime').focus();
            return false;
            }

            if(is_unfit == '' || is_unfit==undefined){
                alert('This unfit Field is required !');
                $('#is_unfit').focus();
                return false;
            }

            if(is_notcult == '' || is_notcult==undefined){
                alert('This notcult Field is required !');
                $('#is_notcult').focus();
                return false;
            }

            if(is_vicinity=='no')
            {

            if($("#remarkVicinity").val().trim().length < 1)
            {
              alert("Please Enter Your Remark for land use");
              return; 
            }

            }

        }

        if(is_prime=='yes')
        {
            var is_unfit = '';
            var is_notcult = '';
            var remark = '';
            var remarkVicinity = '';
            var is_vicinity = '';
            var check_dept = '';
            var is_reclass = $("input[name='reclassification']:checked").val();

            if(is_reclass == '' || is_reclass==undefined){
            alert('This reclass Field is required !');
            $('#is_reclass').focus();
            return false;
            }

        }


        
        //var is_masterplan = $("input[name='masterPlan']:checked").val();
        var case_no = $.trim($('#case_no').val());
        var dag_no = $.trim($('#dag_no').val());
        // alert(is_masterplan);return;


        //validation for the update
        if(is_prime == '' || is_prime==undefined){
            alert('This Field is required !');
            $('#is_prime').focus();
            return false;
        }

        

        formData.append('is_prime', is_prime);
        formData.append('is_unfit', is_unfit);
        formData.append('is_notcult', is_notcult);
        formData.append('is_reclass', is_reclass);
        formData.append('remark', remark);
        formData.append('remarkVicinity', remarkVicinity);
        formData.append('is_vicinity', is_vicinity);
        formData.append('check_dept', check_dept);
        //formData.append('is_masterplan', is_masterplan);
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
            url: baseurl+'ReclassSuiteCumTransfer/updateDagEligibleDetails',
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
                    applicantModal.style.display = "none";
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
                            applicantModal.style.display = "none";
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