$(document).ready(function () {
    $('.tenant').prop('disabled', true);
    $('.khatian_basic').prop('disabled', true);
    $('.preview').prop('disabled', true);
});

//********* Tenant add ***********//
$("#add_tenant").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to save new tenant.")) {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    $.ajax({
        url: baseurl + "Khatian/saveTenant",
        type: 'POST',
        data: $('#add_tenant').serialize(),
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
            $('#form_errors').empty();
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                $('#form_errors').append(data.error);
                return;
            }
            if (data.success === true) {
                if (data.tenant_save === false) {
                    $('#form_errors').html(data.tenant_msg);
                    $('#save_form_error_div').show();
                    return;
                }
                $('#add_data_div').removeClass('hide');
                $('#form_success').html('TENANT INSERTED SUCCESSFULLY.');
                $('#save_success_div').show();

                $('#add_tenant').trigger("reset");

                var table = '';
                $.each(data.temp_tenant, function (index, value) {
                    index++;
                    if (value["tenants_add2"] == null) {
                        value["tenants_add2"] = '';
                    }
                    if (jQuery.inArray(value["dist_code"], BARAK_VALLEY) !== -1) {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L -' + value["ganda"] + 'G -' + value["kranti"] + 'Kr </b>';
                    } else {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L </b>';
                    }
                    table +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["tenant_name"] + '</td>' +
                        '<td>' + value["tenants_father"] + '</td>' +
                        '<td>' + value["tenant_type"] + '</td>' +
                        '<td>' + area + '</td>' +
                        '<td>' + value["tenants_add1"] + '</td>' +
                        '<td>' + value["tenants_add2"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_tenant">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#tenant_table_show').html(table);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/****** DELETE TENANT SINGLE ROW ********/
$(document).on('click', '.delete_tenant', function (e) {
    if (!confirm('Are you sure want to delete this tenant record?')) {
        return false;
    }
    var row_id = $(this).attr('data-id');
    var obj = this;
    $.ajax({
        url: baseurl + "Khatian/deleteTempTenant",
        type: "POST",
        data: {
            row_id: row_id,
            app_id: $('#app_id').val(),
        },
        dataType: "json",
        beforeSend: function () {
            $('#save_form_error_div').hide();
            $('#form_errors').empty();
            $('#save_success_div').hide();
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
            if (data.delete_tenant === true) {
                var table = '';
                $.each(data.tenant_details, function (index, value) {
                    if (value["tenants_add2"] == null) {
                        value["tenants_add2"] = '';
                    }
                    if (jQuery.inArray(value["dist_code"], BARAK_VALLEY) !== -1) {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L -' + value["ganda"] + 'G -' + value["kranti"] + 'Kr </b>';
                    } else {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L </b>';
                    }
                    index++;
                    table +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["tenant_name"] + '</td>' +
                        '<td>' + value["tenants_father"] + '</td>' +
                        '<td>' + value["tenant_type"] + '</td>' +
                        '<td>' + area + '</td>' +
                        '<td>' + value["tenants_add1"] + '</td>' +
                        '<td>' + value["tenants_add2"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_tenant">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#tenant_table_show').html(table);
                $('#form_success').html('TENANT DELETED SUCCESSFULLY.');
                $('#save_success_div').show();
            } else {
                alert(data.delete_tenant);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not complete your delete request..!');
        }
    });
});
/********* END DELETE ***************/

/*********** Tenant Next Button *************/
$(document).on('click', '#add_tenant_next', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseurl + "Khatian/tenantNextButton",
        type: 'POST',
        data: {app_id: $('#app_id').val(), vill_code: $('#vill_code').val()},
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
            if (data.tenant_row > 0) {
                var dag_list = '';
                $.each(data.chitha_dag, function (index, value) {
                    dag_list += '<option value="' + value["dag_no"] + '">' + value["dag_no"] + '</option>'
                });
                $('#dag_no')
                    .html('<option disabled selected>Select Dag No.</option>' + dag_list);

                $('.khatian_basic').prop('disabled', false);
                $('.khatian_basic').trigger('click');
                $('.tenant').prop('disabled', true);
                return;

            } else if ((data.tenant_row == 0) || (data.tenant_row == null)) {
                alert("First save the data then click Proceed to Next Stage.");
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not complete your request..!');
        }
    });
});
/************* END Tenant Area Next Button ************/

//********* Khatian Basic Data add ***********//
$("#add_khatian_basic").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to save Khatian Basic Data.")) {
        return;
    }
    $('#save_form_error_div2').hide();
    $('#form_errors2').empty();
    $('#save_success_div2').hide();
    $.ajax({
        url: baseurl + "Khatian/saveKhatianBasic",
        type: 'POST',
        data: $('#add_khatian_basic').serialize(),
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
            console.log();
            $.unblockUI();
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div2').show();
                $('#form_errors2').append(data.error);
                return;
            }
            if (data.success === true) {
                if (data.khatian_save === false) {
                    $('#form_errors2').html(data.khatian_msg);
                    $('#save_form_error_div2').show();
                    return;
                }
                $('#form_success2').html('KHATIAN BASIC DATA INSERTED SUCCESSFULLY.');
                $('#save_success_div2').show();

                $('#add_khatian_basic').trigger("reset");

                var table = '';
                $.each(data.temp_khatian, function (index, value) {
                    index++;
                    table +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["dag_no"] + '</td>' +
                        '<td>' + value["length_posession"] + '</td>' +
                        '<td>' + value["paid_cash_kind"] + '</td>' +
                        '<td>' + value["payable_cash_kind"] + '</td>' +
                        '<td>' + value["special_conditions"] + '</td>' +
                        '<td>' + value["tenant_status"] + '</td>' +
                        '<td>' + value["remarks"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_khatian">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#khatian_basic_table_show').html(table);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

/****** DELETE KHATIAN SINGLE ROW ********/
$(document).on('click', '.delete_khatian', function (e) {
    if (!confirm('Are you sure want to delete this Khatian Basic record?')) {
        return false;
    }
    var row_id = $(this).attr('data-id');
    var obj = this;
    $.ajax({
        url: baseurl + "Khatian/deleteTempKhatian",
        type: "POST",
        data: {
            row_id: row_id,
            app_id: $('#app_id').val(),
        },
        dataType: "json",
        beforeSend: function () {
            $('#save_form_error_div2').hide();
            $('#form_errors2').empty();
            $('#save_success_div2').hide();
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
            if (data.delete_khatian === true) {
                var table = '';
                $.each(data.khatian_details, function (index, value) {
                    index++;
                    table +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["dag_no"] + '</td>' +
                        '<td>' + value["length_posession"] + '</td>' +
                        '<td>' + value["paid_cash_kind"] + '</td>' +
                        '<td>' + value["payable_cash_kind"] + '</td>' +
                        '<td>' + value["special_conditions"] + '</td>' +
                        '<td>' + value["tenant_status"] + '</td>' +
                        '<td>' + value["remarks"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_khatian">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#khatian_basic_table_show').html(table);
                $('#form_success2').html('KHATIAN BASIC DATA DELETED SUCCESSFULLY.');
                $('#save_success_div2').show();
            } else {
                alert(data.delete_khatian);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not complete your delete request..!');
        }
    });
});
/********* END DELETE ***************/

/*********** Khatian Basic Next Button *************/
$(document).on('click', '#add_khatian_basic_next', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseurl + "Khatian/khatianNextButton",
        type: 'POST',
        data: {app_id: $('#app_id').val(), vill_code: $('#vill_code').val()},
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
            console.log(data);
            $.unblockUI();
            if (data.khatian_row > 0) {
                var khatian = '';
                var tenant = '';
                var khatian_doc = '';
                $.each(data.khatian_details, function (index, value) {
                    index++;
                    if (jQuery.inArray(value["dist_code"], BARAK_VALLEY) !== -1) {
                        var area = '<b>' + value["dag_area_b"] + 'B -' + value["dag_area_k"] + 'K -' + value["dag_area_lc"] + 'L -' + value["dag_area_g"] + 'G -' + value["dag_area_kr"] + 'Kr </b>';
                    } else {
                        var area = '<b>' + value["dag_area_b"] + 'B -' + value["dag_area_k"] + 'K -' + value["dag_area_lc"] + 'L </b>';
                    }
                    khatian +=
                        '<tr style="background-color: #f55d42; color: #fff">' +
                        '<td>SL No.:</td>' +
                        '<td width="70%"><b>' + index + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Dag No.:</td>' +
                        '<td width="70%"><b>' + value['dag_no'] + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Chitha Land Area:</td>' +
                        '<td width="70%">'+ area + '</td>'+
                        '</tr>' +
                        '<tr>' +
                        '<td>Length of Possession (Years):</td>' +
                        '<td width="70%">' + value['length_posession'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Status of Tenant(s):</td>' +
                        '<td width="70%">' + value['tenant_status'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Paid Cash Kind:</td>' +
                        '<td width="70%">' + value['paid_cash_kind'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Payable Cash/Kind:</td>' +
                        '<td width="70%">' + value['payable_cash_kind'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Special Conditions and incidence, right of way casement etc:</td>' +
                        '<td width="70%">' + value['special_conditions'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Remarks:</td>' +
                        '<td width="70%">' + value['remarks'] + '</td>' +
                        '</tr>'
                });
                // console.log("here"+khatian);
                $('#khatian_preview_table')
                    .html(khatian);

                $.each(data.documents, function (indexx, valuee) {
                    let randomPrefix = generateRandomString(5); 
                    let randomSuffix = generateRandomString(5); 
                    let file_link=baseurl+'MultipleFileUpload/viewfile/'+ randomPrefix + valuee['id'] + randomSuffix;
                    khatian_doc += `
                    <tr>
                        <td>${valuee['file_name']}</td>
                        <td width="70%"><b><a href="${file_link}" target="_blank">VIEW FILE</a></b></td>
                    </tr>`;
                })
                $('#khatian_updated_data').html(khatian_doc);

                $.each(data.tenant_details, function (index, value) {
                    if (value["tenants_add2"] == null) {
                        value["tenants_add2"] = '';
                    }
                    if (jQuery.inArray(value["dist_code"], BARAK_VALLEY) !== -1) {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L -' + value["ganda"] + 'G -' + value["kranti"] + 'Kr </b>';
                    } else {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L </b>';
                    }
                    index++;
                    tenant +=
                        '<tr style="background-color: #f55d42; color: #fff">' +
                        '<td>SL No.:</td>' +
                        '<td colspan="5"><b>' + index + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Name:</td>' +
                        '<td colspan="2">' + value['tenant_name'] + '</td>' +
                        '<td>Tenant Gurdian:</td>' +
                        '<td colspan="2">' + value['tenants_father'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Address:</td>' +
                        '<td colspan="5">' + value['tenants_add1'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Second Address:</td>' +
                        '<td colspan="5">' + value['tenants_add2'] + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Land Possession Area:</td>' +
                        '<td colspan="5">' + area + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Tenant Type:</td>' +
                        '<td colspan="5">' + value['tenant_type'] + '</td>' +
                        '</tr>'
                });
                $('#tenant_preview_table')
                    .html(tenant);

                $('.preview').prop('disabled', false);
                $('.preview').trigger('click');
                $('.khatian_basic').prop('disabled', true);
                return;

            } else if ((data.khatian_row == 0) || (data.khatian_row == null)) {
                alert("First save the data then click Proceed to Next Stage.");
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not complete your request..!');
        }
    });
});
/************* END Tenant Area Next Button ************/

/*********** Preview Back Button *************/
$(document).on('click', '#preview_back_button', function (e) {
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border: 'none',
            backgroundColor: 'transparent'
        }
    });
    $('.khatian_basic').prop('disabled', false);
    $('.khatian_basic').trigger('click');
    $('.preview').prop('disabled', true);
    $.unblockUI();
});

/*********** Khatian Back Button *************/
$(document).on('click', '#khatian_back_button', function (e) {
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border: 'none',
            backgroundColor: 'transparent'
        }
    });
    $('.tenant').prop('disabled', false);
    $('.tenant').trigger('click');
    $('.khatian_basic').prop('disabled', true);
    $.unblockUI();
});

//********* Final Submit By LM ***********//
$("#khatian_final_submit").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to final submit.")) {
        return;
    }
    $('#save_form_error_div3').hide();
    $('#form_errors3').empty();
    $('#save_success_div3').hide();
    $.ajax({
        url: baseurl + "Khatian/submitFinalKhatianByLm",
        type: 'POST',
        data: $('#khatian_final_submit').serialize(),
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
            if (data.success === true) {
                if (data.error_save === true) {
                    $('#form_errors3').html(data.error_msg);
                    $('#save_form_error_div3').show();
                    $.unblockUI();
                    return;
                }
                $('#form_success3').html('KHATIAN DETAILS SUCCESSFULLY SUBMITTED.');
                $('#save_success_div3').show();
                window.location.href = baseurl + "Home/khatianLm";
            }
        },
        error: function (jqXHR, exception) {
            $('#final_submit_div').show();
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})


//********* Final Submit By CO ***********//
$("#khatian_co_final_submit").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to final order pass.")) {
        return;
    }
    $('#save_form_error_div3').hide();
    $('#form_errors3').empty();
    $('#save_success_div3').hide();
    $.ajax({
        url: baseurl + "Khatian/submitFinalKhatianByCo",
        type: 'POST',
        data: $('#khatian_co_final_submit').serialize(),
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
            if (data.success === true) {
                if (data.error_save === true) {
                    $('#form_errors3').html(data.error_msg);
                    $('#save_form_error_div3').show();
                    $('#final_submit_div').show();
                    $.unblockUI();
                    return;
                }
                $('#form_success3').html('KHATIAN DETAILS SUCCESSFULLY SUBMITTED.');
                $('#save_success_div3').show();
                window.location.href = baseurl + "Khatian/khatianListForCo";
            }
        },
        error: function (jqXHR, exception) {
            $('#final_submit_div').show();
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})

//********* Reverted back to lm ***********//
$("#revert_back_to_lm").submit(function (e) {
    e.preventDefault()
    if (!confirm("Are you sure want to Revert back to LM.")) {
        return;
    }
    $('#save_form_error_div4').hide();
    $('#form_errors4').empty();
    $('#save_success_div4').hide();
    $.ajax({
        url: baseurl + "Khatian/revertedBackToLm",
        type: 'POST',
        data: $('#revert_back_to_lm').serialize(),
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
            if (data.success === true) {
                if (data.error_save === true) {
                    $('#form_errors4').html(data.error_msg);
                    $('#save_form_error_div4').show();
                    $.unblockUI();
                    return;
                }
                $('#form_success4').html('KHATIAN SUCCESSFULLY REVERTED BACK TO LM.');
                $('#save_success_div4').show();
                window.location.href = baseurl + "Khatian/khatianListForCo";
            }
        },
        error: function (jqXHR, exception) {
            $('#final_submit_div4').show();
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

/******* Insert data from main table to to Temp Table ******/
function insert_data_from_main_table_to_temp_table() {
    $.ajax({
        url: baseurl + "Khatian/insertIntoTemp",
        type: 'POST',
        data: {
            khatian_no: $('#khatian_no').val(),
            vill_code: $('#vill_code').val(),
            app_id: $('#app_id').val(),
        },
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
            if (data.error === true) {
                window.location.href = baseurl + "Khatian/khatianSelectLocationForLm";
                // alert("Validation-Error, Please validate the form correctly!");
                // $('#save_form_error_div4').show();
                // $('#form_errors4').append(data.error);
                // $('#final_submit_div4').show();
                // $.unblockUI();
                return;
            }
            if (data.error === false) {
                var khatian = '';
                var tenant = '';

                $.each(data.temp_tenant, function (index, value) {
                    index++;
                    if (value["tenants_add2"] == null) {
                        value["tenants_add2"] = '';
                    }
                    if (jQuery.inArray(value["dist_code"], BARAK_VALLEY) !== -1) {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L -' + value["ganda"] + 'G -' + value["kranti"] + 'Kr </b>';
                    } else {
                        var area = '<b>' + value["bigha"] + 'B -' + value["katha"] + 'K -' + value["lessa"] + 'L </b>';
                    }
                    tenant +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["tenant_name"] + '</td>' +
                        '<td>' + value["tenants_father"] + '</td>' +
                        '<td>' + value["tenant_type"] + '</td>' +
                        '<td>' + area + '</td>' +
                        '<td>' + value["tenants_add1"] + '</td>' +
                        '<td>' + value["tenants_add2"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_tenant">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#tenant_table_show').html(tenant);

                $.each(data.temp_khatian, function (index, value) {
                    index++;
                    khatian +=
                        '<tr>' +
                        '<td align="center">' + index + '</td>' +
                        '<td>' + value["khatian_no"] + '</td>' +
                        '<td>' + value["dag_no"] + '</td>' +
                        '<td>' + value["length_posession"] + '</td>' +
                        '<td>' + value["paid_cash_kind"] + '</td>' +
                        '<td>' + value["payable_cash_kind"] + '</td>' +
                        '<td>' + value["special_conditions"] + '</td>' +
                        '<td>' + value["tenant_status"] + '</td>' +
                        '<td>' + value["remarks"] + '</td>' +
                        '<td><span data-id="' + value["id"] + '" class="text-center delete_khatian">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span>' +
                        '</td>' +
                        '</tr>'
                });
                $('#khatian_basic_table_show').html(khatian);

                console.log(tenant);
                console.log(khatian);
                $.unblockUI();
            }
        },
        error: function (jqXHR, exception) {
            // $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
            window.location.href = baseurl + "Khatian/khatianSelectLocationForLm";
        }
    });
}

/**** Dag On Change *******/
$(document).on('change', '#dag_no', function (e) {
    e.preventDefault();
    var dag_no = $(this).val();
    var vill_code = $('#vill_code').val();
    var khatian_no = $('#khatian_no').val();
    $.ajax({
        url: baseurl + "Khatian/pattadarCheck",
        type: 'POST',
        data: { dag_no :dag_no,vill_code:vill_code,khatian_no:khatian_no },
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
            if (data.pattadar == '0') {
                alert("Land owner not found.");
                $('#dag_no').prop('selectedIndex', 0);
                return;
            }
            if (data.dag_count === true) {
                alert("Selected dag no already assigned with another khatian no: "+data.main_khatian_no);
                $('#dag_no').prop('selectedIndex', 0);
                return;
            }
            if (data.temp_dag_count === true) {
                alert("Selected dag no already assigned with another khatian no: "+data.temp_khatian_no+" which is pending with CO.");
                $('#dag_no').prop('selectedIndex', 0);
                return;
            }

            if (data.lm_temp_dag_count === true) {
                alert("Selected dag no already assigned with another khatian no: "+data.lm_temp_khatian_no+" which is pending with LM (Revert back from CO tab).");
                $('#dag_no').prop('selectedIndex', 0);
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#dag_no').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
})