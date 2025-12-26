//arrear update form submit
function mouzadarAddFormHandle(){
    event.preventDefault();
    $('#maf_error_div').hide();
    $('#maf_validation_error_msg').empty();
    var formdata = $('#mouzadar_add_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaMouzadarController/addMouzadar",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBoxEK'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {      
            if(data.result == 'validation_error'){
                $.unblockUI();
                alert("Validation-Error...!!");                
                for (let i = 0; i < data.msg.length; i++) {
                    $('#maf_validation_error_msg').append(data.msg[i]);
                }
                $('#maf_error_div').show();
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'USER_EXISTS'){
                $.unblockUI();
                alert(data.msg);
                return;                
            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                Swal.fire({
                    title: 'Mouzdar Added Sucessfully..!',
                    text: "Now Mouzadar Can Login In ILRMS Basundhara portal..!",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Home'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href = baseurl + "EkhajanaCoController/index";
                    }
                })
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI();
}