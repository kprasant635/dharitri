
    var addApplicantModal = document.getElementById("editPropClassDetails");
    // Get the <span> element that closes the modal
    var addSpanApplicant = document.getElementsByClassName("close-add-applicant")[0];

    function editPropClass(dag_no){
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
        
        var proc_lc_name = $.trim($('#proc_lc_name' + dag_no + ' strong').first().text());
        $('#proc_lc_name_applicant').val(proc_lc_name);

        var proc_lc_cat_id = $.trim($('#prop_lc_code'+dag_no).val());

        $('#dag_no_prop').val(dag_no);


       $.ajax({
        url: 'fetch_land_classes',
        method: 'POST',
        dataType: 'json',
        data: { cat_id: proc_lc_cat_id },
        success: function (response) {
            var $dropdown = $('#proc_lc_name_office');
            $dropdown.empty().append('<option value="">-- Select Proposed Class --</option>');

            response.forEach(function (item) {
                $dropdown.append('<option value="' + item.id + '">' + item.name_ass + '</option>');
            });
            //$dropdown.val(proc_lc_name);
        },
        error: function () {
            alert("Failed to load class list.");
        }
        });
              
    }

    function editPropClassData(){

        var formData = new FormData();

        var case_no = $.trim($('#case_no').val());
        var dag_no = $.trim($('#dag_no_prop').val());
        
        var selectedClass = $('#proc_lc_name_office').val();
        var selectedClassText = $('#proc_lc_name_office option:selected').text();
        //validation for applicant add

        if(selectedClass == ''){
            alert('Proposed class is required !');
            $('#selectedClass').focus();
            return false;
        }

        var fileInput = $('#nocDocument')[0];
        if (fileInput.files.length === 0) {
            alert('Please select a file to upload.');
            return;
        }

        //data for applicant add
        // var postData = {
        //     'case_no' : case_no,
        //     'selectedClass' : selectedClass,
        //     'dag_no'  : dag_no,
        //     'selectedClassText' : selectedClassText
        // };

        formData.append('nocDocument', fileInput.files[0]);
        formData.append('selectedClass', selectedClass);
        formData.append('selectedClassText', selectedClassText);
        formData.append('case_no', case_no);
        formData.append('dag_no', dag_no);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'ReclassSuiteControllerCO/updateProposedClassData',
            type: "POST",
            processData: false, // important
            contentType: false, // important
            dataType: "json",
            data: formData,
            success: function(data) {
                //arr = JSON.parse(data);
                $.unblockUI();
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
                            location.reload(true);
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