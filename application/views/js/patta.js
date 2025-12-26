/**** On change Application Type *******/
$(document).on('change', '#application_type', function (e) {
    e.preventDefault();
    $('#vill_code').prop('selectedIndex', 0);
    $('#patta_type').prop('selectedIndex', 0);
})

/**** Get Patta Type *******/
$(document).on('change', '#vill_code', function (e) {
    e.preventDefault();
    var vill_code = $(this).val();
    var application_type = $('#application_type').val();
    if(application_type == null || application_type=='')
    {
        alert("Please select application type.");
        $('#vill_code').prop('selectedIndex', 0);
        return;
    }
    $.ajax({
        url: baseurl + "Patta/getPattaType",
        type: 'POST',
        data: { vill_code:vill_code,application_type:application_type },
        dataType: 'json',
        beforeSend: function () {
            $('#patta_type').prop('selectedIndex', 0);
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            console.log(data);
            $.unblockUI();
            var patta_type = '';
            var option = '<option selected disabled>Select Patta Type</option>'
            $.each(data, function (index, value) {
                patta_type +=
                   '<option value="'+value['type_code']+'">'+value['patta_type']+'</option>'
            });
            $('#patta_type').html(option+patta_type);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#patta_type').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/**** Get Patta No *******/
$(document).on('change', '#patta_type', function (e) {
    e.preventDefault();
    var patta_type = $(this).val();
    var vill_code = $('#vill_code').val();
    $.ajax({
        url: baseurl + "Patta/getPattaNo",
        type: 'POST',
        data: { patta_type :patta_type,vill_code:vill_code },
        dataType: 'json',
        beforeSend: function () {
            $('#patta_no').prop('selectedIndex', 0);
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $.unblockUI();
            var patta_no = '';
            var option = '<option disabled selected>Select Patta No</option>';
            $.each(data, function (index, value) {
                patta_no +=
                    '<option value='+value['patta_no']+'>'+value['patta_no']+'</option>'
            });
            $('#patta_no').html(option+patta_no);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#patta_no').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/***** date *******/
$(function () {
    $('.dateNew').datepick({
        maxDate: 0,
        //dateFormat: 'dd-mm-yyyy'
        dateFormat: 'yyyy-mm-dd'
    });
});

/**** Get Dag Details *******/
$(document).on('change', '.dag_no_new', function (e) {
    e.preventDefault();
    var row_id = $(this).attr("data-id");
    var dag_no = $(this).val();
    var vill_code = $('#vill_code').val();
    $.ajax({
        url: baseurl + "Patta/getDagArea",
        type: 'POST',
        data: { dag_no :dag_no,vill_code:vill_code },
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $.unblockUI();
            if (jQuery.inArray(data.dag_no.dist_code, BARAK_VALLEY) !== -1) {
                $('#bigha'+row_id).html(data.dag_no.dag_area_b);
                $('#katha'+row_id).html(data.dag_no.dag_area_k);
                $('#lessa'+row_id).html(data.dag_no.dag_area_lc);
                $('#ganda'+row_id).html(data.dag_no.dag_area_g);
                $('#kranti'+row_id).html(data.dag_no.dag_area_kr);
            } else {
                $('#bigha'+row_id).html(data.dag_no.dag_area_b);
                $('#katha'+row_id).html(data.dag_no.dag_area_k);
                $('#lessa'+row_id).html(data.dag_no.dag_area_lc);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#dag_no').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})


/**** Get to date *******/
$(document).on('change', '#time_period', function (e) {
    e.preventDefault();
    var given_year = $(this).val();
    // if($.isNumeric(given_year))
    // {
        var date = new Date();
        date.setFullYear(date.getFullYear() + parseInt(given_year));
        var dd = date.getDate();
        var mm = date.getMonth();
        var y = date.getFullYear();
        var someFormattedDate = dd + '-'+ mm + '-'+ y;
        $('#upto_date').val(someFormattedDate);
    // }else {
    //     $('#upto_date').val('');
    //     $('#time_period').val('');
    //     alert("For how many years(s) allow only integer value.");
    // }

})

/********** Add more Dag ********/
$(document).on('click', '#add_dag', function (e) {
    e.preventDefault();
    var row_id = $('#row_id').val();
    var dist_code = $('#dist_code').val();
    var vill_code = $('#vill_code').val();
    var patta_type = $('#patta_type').val();
    var patta_no = $('#patta_no').val();
    $.ajax({
        url: baseurl + "Patta/getDagNo",
        type: 'POST',
        data: { vill_code:vill_code,patta_type:patta_type,patta_no:patta_no },
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $.unblockUI();
            var dag_no = '';
            var table = '';
            var area_head = '';
            if(data.dag === true)
            {
                $.each(data.dag_no, function (index, value) {
                    dag_no +='<option value='+ value["dag_no"] +'>'+ value["dag_no"] +'</option>'
                });

                if (jQuery.inArray(dist_code, BARAK_VALLEY) !== -1){
                    area_head ='<tr style="background-color: #769181; color: #fff">' +
                        '<th colspan="2">Bigha</th>' +
                        '<th colspan="2">Katha</th>' +
                        '<th colspan="2">Chatak</th>' +
                        '<th colspan="2">Ganda</th>' +
                        '<th colspan="2">Kranti</th>' +
                        '</tr>';

                    area_td = '<tr>' +
                        '<th colspan="2" id="bigha'+row_id+'">0</th>' +
                        '<th colspan="2" id="katha'+row_id+'">0</th>' +
                        '<th colspan="2" id="lessa'+row_id+'">0</th>' +
                        '<th colspan="2" id="ganda'+row_id+'">0</th>' +
                        '<th colspan="2" id="kranti'+row_id+'">0</th>' +
                        '</tr>';
                }else {
                    area_head ='<tr style="background-color: #769181; color: #fff">' +
                    '<th colspan="3">Bigha :</th>' +
                    '<th colspan="3">Katha</th>' +
                    '<th colspan="4">Lessa</th>' +
                    '</tr>';

                    area_td ='<tr>' +
                    '<th colspan="3" id="bigha'+row_id+'">0</th>' +
                    '<th colspan="3" id="katha'+row_id+'">0</th>' +
                    '<th colspan="4" id="lessa'+row_id+'">0</th>' +
                    '</tr>';
                }

                table =
                    '<table class="table table-striped table-bordered text-bold" id="div_'+row_id+'">' +
                    '<thead>' +
                    '<tr>' +
                    '    <th style="background-color: #769181; color: #fff" colspan="10">' +
                    '        Applicant Dag and Land Area '+
                    '    </th>' +
                    '</tr>' +
                    '<tr>' +
                    '    <th colspan="3" width="25%">Dag No : <span style="color:red;font-weight:bold; font-size: 18px;">*</span></th>' +
                    '    <th colspan="3" width="25%">' +
                    '        <select class="form-select dag_no_new" data-id="'+row_id+'" id="dag_no'+row_id+'" name="dag_no[]" required>' +
                    '            <option value="" selected>Select Dag No</option>' +
                    dag_no+
                    '        </select>' +
                    '    </th>' +
                    '    <th colspan="2">' +
                    '        <button type="button" class="btn btn-danger dag_row" data-id="'+row_id+'"><i' +
                    '                    class=\'fa fa-trash\'></i>  Delete Dag</button>' +
                    '    </th>' +
                    '    <th colspan="2"></th>' +
                    '</tr>' +
                    area_head +
                    area_td+
                    '</thead>' +
                    '</table>'
                $('#add_more_dag').append(table);
                $('#row_id').val(parseInt(row_id)+1);
            }else {
                alert('Something went wrong');
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/********** Remove Dag Div ********/
$(document).on('click', '.dag_row', function (e) {
    e.preventDefault();
    if(!confirm("Are you sure want to delete dag no."))
    {
        return;
    }
    var row_id = $(this).attr("data-id");
    $('#div_'+row_id).remove();
})

/***** save application *****/
//********* Tenant add ***********//
$("#save_patta_application").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to save application.")) {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    $.ajax({
        url: baseurl + "Patta/saveApplication",
        type: 'POST',
        data: $('#save_patta_application').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $('#form_errors').empty();
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                $('#form_errors').append(data.error);
                $.unblockUI();
                return;
            }
            if (data.validation === true) {
                if (data.error_save === true) {
                    $('#form_errors').html(data.error_msg);
                    $('#save_form_error_div').show();
                    $.unblockUI();
                    return;
                }
                if(data.save_data === true)
                {
                    $('#add_data_div').removeClass('hide');
                    $('#form_success').html('APPLICANT AND PATTA DETAILS INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();
                    window.location.href = baseurl + "Home/pattaLm";
                    return;
                }else {
                    $.unblockUI();
                    alert('Could not Complete your Request ..!, Please Try Again later..!');
                    return;
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/**** Get Pattadar details *******/
$(document).on('change', '#pattadar_name', function (e) {
    e.preventDefault();
    var pattadar_id = $(this).val();
    var patta_type = $('#patta_type').val();
    var patta_no = $('#patta_no').val();
    var vill_code = $('#vill_code').val();
    $.ajax({
        url: baseurl + "Patta/getPattadarDetails",
        type: 'POST',
        data: { pattadar_id:pattadar_id,
            patta_type:patta_type,
            patta_no :patta_no,
            vill_code:vill_code },
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $.unblockUI();
            $('#guardian_name').val(data);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#pattadar_name').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

//********* Reject Case ***********//
$("#reject_case").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to reject case.")) {
        return;
    }
    $('#save_form_error_div4').hide();
    $('#form_errors4').empty();
    $('#save_success_div4').hide();
    $.ajax({
        url: baseurl + "Patta/rejectPattaCase",
        type: 'POST',
        data: $('#reject_case').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('#final_submit_div4').hide();
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div4').show();
                $('#form_errors4').append(data.error);
                $('#final_submit_div4').show();
                $.unblockUI();
                return;
            }
            if (data.validation === true) {
                if (data.error_save === true) {
                    $('#form_errors4').html(data.error_msg);
                    $('#save_form_error_div4').show();
                    $('#final_submit_div4').show();
                    $.unblockUI();
                    return;
                }
                $('#form_success4').html('CASE SUCCESSFULLY REJECTED.');
                $('#save_success_div4').show();
                window.location.href = baseurl + "Patta/pattaListForCo";
            }
        },
        error: function (jqXHR, exception) {
            $('#final_submit_div4').show();
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

//********* Final Submit By CO ***********//
$("#co_save_patta_application").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to final order pass.")) {
        return;
    }
    $('#save_form_error_div3').hide();
    $('#form_errors3').empty();
    $('#save_success_div3').hide();
    $.ajax({
        url: baseurl + "Patta/submitFinalOrderByCo",
        type: 'POST',
        data: $('#co_save_patta_application').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('#final_submit_div').hide();
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div3').show();
                $('#form_errors3').append(data.error);
                $('#final_submit_div').show();
                $.unblockUI();
                return;
            }
            if (data.validation === true) {
                if (data.error_save === true) {
                    $('#form_errors3').html(data.error_msg);
                    $('#save_form_error_div3').show();
                    $('#final_submit_div').show();
                    $.unblockUI();
                    return;
                }
                $('#form_success3').html('ORDER SUCCESSFULLY PASSED.');
                $('#save_success_div3').show();
                window.location.href = baseurl + "Patta/viewPatta?case_no="+data.case_no;
            }
        },
        error: function (jqXHR, exception) {
            $('#final_submit_div').show();
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

//********** New-Method-Goalpara ***********//
$("#save_patta_application_goalpara").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to save application.")) {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    $.ajax({
        url: baseurl + "Patta/saveApplicationGoalpara",
        type: 'POST',
        data: $('#save_patta_application_goalpara').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (data) {
            $('#form_errors').empty();
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                $('#form_errors').append(data.error);
                $.unblockUI();
                return;
            }
            if (data.validation === true) {
                if (data.error_save === true) {
                    $('#form_errors').html(data.error_msg);
                    $('#save_form_error_div').show();
                    $.unblockUI();
                    return;
                }
                if(data.save_data === true)
                {
                    $('#add_data_div').removeClass('hide');
                    $('#form_success').html('APPLICANT AND PATTA DETAILS INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();
                    window.location.href = baseurl + "Home/pattaLm";
                    return;
                }else {
                    $.unblockUI();
                    alert('Could not Complete your Request ..!, Please Try Again later..!');
                    return;
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

