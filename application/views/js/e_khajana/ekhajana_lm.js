$(document).ready( function () {
    //data table initialisation
    $('#ek_lm_pending_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
});

function forwardToCo(){
    event.preventDefault();
    var formdata = new FormData(document.getElementById('ek_lm_pending_case_display_form'));
    $.ajax({
        url: baseurl + "EkhajanaLmController/forwardedToCo",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                $('#lmArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    alert("Validation Error..!")
                    $('#lmArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaLmController/index";
            }else if(data.result == 'FILE_UPLOAD_ERR'){
                $.unblockUI();
                alert(data.msg);
                //location.href =  baseurl + "EkhajanaLmController/index";
            }else{
                $.unblockUI();
                alert(data.msg);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

function forwardToCoForMouzadariSystem(){
    event.preventDefault();
    //var formdata = $('#ek_lm_pending_case_display_form').serialize();
    var formdata = new FormData(document.getElementById('ek_lm_pending_case_display_form'));
    $.ajax({
        url: baseurl + "EkhajanaLmController/forwardedToCoForMouzadariSystem",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                $('#lmArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    alert("Validation Error..!")
                    $('#lmArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaLmController/index";
            }else if(data.result == 'FILE_UPLOAD_ERR'){
                $.unblockUI();
                alert(data.msg);
                //location.href =  baseurl + "EkhajanaLmController/index";
            }else{
                $.unblockUI();
                alert(data.msg);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}


//************************DP ESTATE */
function forwardByLmForDpEstate()
{
    event.preventDefault();
    
    var formdata = $('#ek_lm_pending_case_display_form_for_dp_estate').serialize();
    $.ajax({
        url: baseurl + "EkhajanaLmController/forwardCaseByLmForDpEstate",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                $('#lmArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    alert("Validation Error..!")
                    $('#lmArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaLmController/index";
            }else{
                $.unblockUI();
                alert(data.msg);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    }); 
}
