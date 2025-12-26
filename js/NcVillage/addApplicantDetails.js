
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

function addApplicant()
{

    alert('ooo');
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
        'add_pre_address' : add_pre_address
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl + 'NcCommonController/addApplicantDetails',
        type: "POST",
        data: postData,
        success: function (data) {
            $.unblockUI();
            let arr;

            try {
                arr = JSON.parse(data);
            } catch (e) {
                showErrorMessage('Invalid server response.');
                return;
            }

            if (arr.responseType == 0) {
                showErrorMessage(arr.msg);
            }
            else if (arr.responseType == 2) {
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
                    location.reload(); // ✅ Reload after success
                }
            });
            }
            else {
                showErrorMessage(arr.msg);
            }
        },
        error: function (xhr, status, error) {
            $.unblockUI();
            showErrorMessage('Error: ' + error);
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
            url: baseurl+'NcCommonController/delApplicantDetails',
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