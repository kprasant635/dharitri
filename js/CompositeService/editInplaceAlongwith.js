
    var addApplicantModal = document.getElementById("editInplaceAlongDetails");
    // Get the <span> element that closes the modal
    var addSpanApplicant = document.getElementsByClassName("close-add-applicant")[0];

    function editInplaceAlongwith(dag_no){
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
        
        var inplacealong = $.trim($('#inplacealong' + dag_no + ' strong').first().text());
        $('#inplacealong').val(inplacealong);

        var pdar_id = $.trim($('#pdar_id'+dag_no).val());

        $('#pdar_id').val(pdar_id);

        $('#dag_no_prop').val(dag_no);
              
    }

    function editInplaceAlongwithData(){

        var formData = new FormData();

        var case_no = $.trim($('#case_no').val());
        var dag_no = $.trim($('#dag_no_prop').val());
        var pdar_id = $.trim($('#pdar_id').val());
        
        var selected = $('#striked_out').val();
        var selectedText = $('#proc_lc_name_office option:selected').text();
        //validation for applicant add

        // console.log(selectedClass);return;

        if(selected == ''){
            alert('Inplace/Alongwith is required !');
            $('#selected').focus();
            return false;
        }

        //data for applicant add
        // var postData = {
        //     'case_no' : case_no,
        //     'selectedClass' : selectedClass,
        //     'dag_no'  : dag_no,
        //     'selectedClassText' : selectedClassText
        // };

        formData.append('selected', selected);
        //formData.append('selectedClassText', selectedClassText);
        formData.append('case_no', case_no);
        formData.append('dag_no', dag_no);
        formData.append('pdar_id', pdar_id);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'CompositeService/updateInplaceAlongwithData',
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