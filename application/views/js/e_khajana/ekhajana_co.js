$(document).ready( function () {
    //data table initialisation
    $('#ek_co_approved_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    $('#ek_co_pending_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    var revenue_year = $('#revenue-year').val();
    $('#co_yearly_amount_data').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 12,
        "autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download text-white"></i> <span class="text-white">Download As Excel</span>',
                titleAttr: 'Excel',
                title: "YEARLY E-KHAJANA REPORT "+revenue_year,
            }, 
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-success btn-sm');
            btns.removeClass('dt-button');
        }
    });
});


function forwardToAssistant(){
    event.preventDefault();
    var formdata = $('#ek_co_pending_case_display_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaCoController/forwardToAssistant",
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
                alert("Validation-Error...!!");
                $('#coArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#coArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}


function rejectCase(case_no){
    event.preventDefault();
    showRejectModalMb2(case_no,'19');
    return;
    // let text = "Are you sure you want to reject this case?";
    // if (confirm(text) != true) {
    //     return;
    // }
    // var formdata = $('#ek_co_pending_case_display_form').serialize();
    // $.ajax({
    //     url: baseurl + "EkhajanaCoController/rejectCase",
    //     type: 'POST',
    //     data: formdata,
    //     dataType: 'json',
    //     beforeSend: function () {
    //         $.blockUI({
    //             message: $('#displayBox'),
    //             css: {
    //                 border:'none',
    //                 backgroundColor:'transparent'
    //             }
    //         });
    //     },
    //     success: function (data) {
    //         if(data.result == 'VALIDATION-ERROR'){
    //             $.unblockUI();
    //             alert("Validation-Error...!!");
    //             $('#coArr_error_div').show();
    //             for (let i = 0; i < data.msg.length; i++) {
    //                 $('#coArr_validation_error_msg').append(data.msg[i]);
    //             }
    //             return;
    //         }else if(data.result == 'SERVER-ERROR'){
    //             $.unblockUI();
    //             alert(data.msg);
    //             return;

    //         }else if(data.result == 'SUCCESS'){
    //             $.unblockUI();
    //             alert(data.msg);
    //             location.href =  baseurl + "EkhajanaCoController/index";
    //         }
    //     },
    //     error: function (jqXHR, exception) {
    //         $.unblockUI();
    //         alert('Could not Complete your Request ..!, Please Try Again later..!');
    //     }
    // });
}

// For modal display reject
function showRejectModalMb2(case_no,service_code){
    $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    $('#rejectModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectMb2Controller/getRejectModal',
        type: 'post',
        data: {service_code: service_code},
        dataType: 'json',
        success: function(data){
            $('#rejectform').trigger('reset');
            let button = '';
            let table = '';
            $.each(data, function (key, val) {
            button = '<input type="checkbox" value="'+val.reject_code+'" '+
                'class="btnChecked reject_option" name="reject_code[]"';
            table +=
                '<tr style="font-size:16px">'+
                '<td align="center">' + button + '</td>' +
                '<td>' + val.remark + '</td>' +
                '</tr>'
            });
            $('#service_code').val(service_code);
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtml').html(case_no);
            $('#reject_option').html(table);
            $('#rejectModal').modal('show');
            $.unblockUI();
        },
        error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
}

$('#rejectformEkhajana').submit(function (e) {
    e.preventDefault();
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    var service_code = $('#service_code').val();
    var case_no = $('#dharitreeCaseNo').val();
    let reject_code = $('#reject_option').val();
    let remark = $('#reject_remark').val();
    let ref_no = $('#ref_no').val();
    let url=baseurl+'EkhajanaCoController/rejectCase';
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: $("#rejectformEkhajana").serialize()+
            "&service_code=" + service_code+
            "&remark=" + remark +
            "&case_no=" + case_no,
        success: function(data){
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                $('.errorMsg').html(data.message);
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                $('.errorMsg').html(data.message);

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }

        },error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
});
$('#close_reject_modal').click(function () {
    $('#rejectModal').modal('hide');
});

//arrear Reupdate form submit
function coReUpdateArrear(){
    event.preventDefault();
    var opening_balance = $('#openinig_balance').val();
    var current_revenue =$('#current_revenue').val();
    var current_local_tax = $('#current_local_tax').val();
    if(opening_balance == ""){
        alert("Please enter Opening Balance/Arrear..!");
        return;
    }
    if(current_revenue == ""){
        alert("Some Error Occured..!!, error-code: #EKHASTARR001");
        return;
    }
    if(current_local_tax == ""){
        alert("Some Error Occured..!!, error-code: #EKHASTARR002");
        return;
    }
    var due_payment = parseFloat(opening_balance)+ parseFloat(current_revenue) + parseFloat(current_local_tax);
    $('#due_payment_frontend').val(due_payment)
    let text = "Citizen Due Payment Will Be "+ due_payment+ " rs";
    Swal.fire({
        title: 'Are you sure?',
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Update Arrear!'
      }).then(function() {
        
        $('#co_re_Arr_error_div').hide();
        $('#co_re_Arr_validation_error_msg').empty();
        var formdata = $('#coRe_arrear_update_form').serialize();
        $.ajax({
            url: baseurl + "EkhajanaCoController/ReUpdateArrearSubmit",
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
                    $('#co_re_Arr_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#co_re_Arr_validation_error_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    alert(data.msg);
                    return;

                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    Swal.fire({
                        title: 'Arrer Re-Updated Sucessfully!',
                        text: "Now Citizen Can Pay The Amount In ARTPS/Basundhara",
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
    })
}

//function to dispose the case by co in mouzadari system
function COdisposeCase(){
    event.preventDefault();
    var formdata = $('#ek_co_pending_case_display_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaCoController/COdisposeCase",
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
                alert("Validation-Error...!!");
                $('#coArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#coArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//function to display the reject case modalmin mouzadari sytstem
function COrejectCaseMouzadariSystem(case_no){
    event.preventDefault();
    showRejectModalMouzadariSystem(case_no,'19');
    return;
}

// For modal display reject in mouzadari system
function showRejectModalMouzadariSystem(case_no,service_code){
    $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    $('#rejectModalMouzadari').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectMb2Controller/getRejectModal',
        type: 'post',
        data: {service_code: service_code},
        dataType: 'json',
        success: function(data){
            $('#rejectform').trigger('reset');
            let button = '';
            let table = '';
            $.each(data, function (key, val) {
            button = '<input type="checkbox" value="'+val.reject_code+'" '+
                'class="btnChecked reject_option" name="reject_code[]"';
            table +=
                '<tr style="font-size:16px">'+
                '<td align="center">' + button + '</td>' +
                '<td>' + val.remark + '</td>' +
                '</tr>'
            });
            
            $('#service_code').val(service_code);
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtml').html(case_no);
            $('#reject_option').html(table);
            $('#rejectModalMouzadari').modal('show');
            $.unblockUI();
        },
        error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
}

//submit the rejected case mouzadari system
$('#rejectformEkhajanaMouzadari').submit(function (e) {
    e.preventDefault();
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    var service_code = $('#service_code').val();
    //var pattadar_identified = $('#pattadar_identified').val();
    var co_pattadar_identification_flag = $('[name=co_pattadar_identification_flag]:checked').val();
    var case_no = $('#dharitreeCaseNo').val();
    let reject_code = $('#reject_option').val();
    let remark = $('#reject_remark').val();
    let ref_no = $('#ref_no').val();
    let url=baseurl+'EkhajanaCoController/rejectCaseMouzadariSystem';
    //alert(pattadar_identified);
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: $("#rejectformEkhajanaMouzadari").serialize()+
            "&service_code=" + service_code+
            "&remark=" + remark +
            "&case_no=" + case_no +
            "&co_pattadar_identification_flag=" + co_pattadar_identification_flag,
        
        success: function(data){
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                alert("validation_error");
                $('.errorMsg').html(data.msg);
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                $('.errorMsg').html(data.msg);

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }

        },error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
});
$('#close_reject_modal_mouzadari').click(function () {
    $('#rejectModalMouzadari').modal('hide');
});


//function to pass to adc dp estate
function forwardToAdc(){
    event.preventDefault();
    var formdata = $('#ek_co_pending_case_display_form-dp-estate').serialize();
    $.ajax({
        url: baseurl + "EkhajanaCoController/forwardToAdcDpEstate",
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
                alert("Validation-Error...!!");
                $('#coArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#coArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//function to pass to adc dp estate
function RevertToMouzadar(){
    event.preventDefault();
    var formdata = $('#ek_co_pending_case_display_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaCoController/revertToMouzadar",
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
                alert("Validation-Error...!!");
                $('#coArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#coArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaCoController/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//method to open modal of revert by co in mouzadari system
function CoRevertCaseMouzadariSystem(case_no)
{
    event.preventDefault();
    $('#revertCaseNoHtml').html(case_no);
    $('#revertByCoMouzadari').modal('show');
}
