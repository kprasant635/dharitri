//*************** Get Sub Division **********//
$(function () {
    $('#district_code').change(function (e) {
        $('#add_data_div').addClass('hide');
        var distCode = $(this).val();
        $.ajax({
            url: baseurl + "AddLocationController/getSubdivJson/" + distCode,
            success: function (data) {
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                $('#subdiv_code').html(template);
            }
        });
    });
})

//*************** Get Circle **********//
$(function () {
    $('#subdiv_code').change(function (e) {
        $('#add_data_div').addClass('hide');
        var subdivcode = $(this).val();
        var distcode = $('#district_code').val();
        $.ajax({
            url: baseurl + "AddLocationController/getCircleJson/" + distcode+ "/"+subdivcode,
            success: function (data) {
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";
                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                $('#circle_code').html(template);
            }
        });
    });
})

//*************** Get Mouza **********//
$(function () {
    $('#circle_code').change(function (e) {
        $('#add_data_div').addClass('hide');
        var subdivcode = $('#subdiv_code').val();
        var distcode = $('#district_code').val();
        var circode = $(this).val();
        $.ajax({
            url: baseurl + "AddLocationController/getMouzaJson/" + distcode + '/' + subdivcode + '/' + circode,
            success: function (data) {
                var mouza = JSON.parse(data);
                var template = "<option selected disabled>Select Mouza</option>";
                for (var i = 0; i < mouza.length; i++) {
                    template += "<option value='" + mouza[i].mouza_pargona_code + "'>" + mouza[i].loc_name + "</option>";
                }
                $('#mouza_code').html(template);
            }
        });
    });
})

//*************** Get Lot **********//
$(function () {
    $('#mouza_code').change(function (e) {
        $('#add_data_div').addClass('hide');
        var subdivcode = $('#subdiv_code').val();
        var distcode = $('#district_code').val();
        var circode = $('#circle_code').val();
        var mouzacode = $(this).val();
        $.ajax({
            url: baseurl + "AddLocationController/getLotNoJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode,
            success: function (data) {
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Lot</option>";
                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].lot_no + "'>" + lot[i].loc_name + "</option>";
                }
                $('#lot_code').html(template);
            }
        });
    });
})

//*************** Lot On Change **********//
$(function () {
    $('#lot_code').change(function (e) {
        $('#add_data_div').addClass('hide');
    });
})

//********* validate_data ***********//
function validate_data() {
    $('#save_success_div').hide();
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $.ajax({
        url: baseurl + "AddLocationController/validateLocationData",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            lotcode :  $('#lot_code').val(),
        },
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
            $.unblockUI();
            $('#location_form_error_div').hide();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#location_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#location_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.success) {
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#villagesTable').DataTable().clear();
                $('#villagesTable').DataTable().destroy();
                $('#villagesTable').DataTable({
                    "data" : data.villages,
                    "columns": [
                        {"data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "uuid"},
                        {"data": "rural_urban",
                            "render": function (data, type, row) {
                                if (row.rural_urban === 'R') {
                                    return 'Rural';}
                                else {

                                    return 'Urban';
                                }
                            }
                        },
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" class="btn-danger rounded edit_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" class="btn-danger rounded remove_btn" ><i class="fa fa-trash"></i></button>';
                            }
                        },
                        
                    ]
                });
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit village add ***********//
function add_village_form_submit() {
    if(!confirm("Are you sure want to save new village."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var vill_check = 'Y';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewVillage",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            lotcode :  $('#lot_code').val(),
            vill_as_name :  $('#vill_as_name').val(),
            vill_eng_name :  $('#vill_eng_name').val(),
            rural_urban :  $('#rural_urban').val(),
            village_status :  $('#village_status').val(),
            is_map :  $('#is_map').val(),
            is_mc: $('#is_mc').val(),
            vill_check : vill_check,
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }
                if(data.vill_exist)
                {
                    for (let i = 0; i < data.vill_exist.length; i++) {
                        let id = i+1;
                        $('#vill_table_body').append('<tr>'+
                            '<td>'+id+'</td>'+
                            '<td>'+data.vill_exist[i].loc_name+'</td>'+
                            '<td>'+data.vill_exist[i].locname_eng+'</td>'+
                            '<td>'+data.vill_exist[i].uuid+'</td>'+
                            '</tr>');
                    }
                    $('#ifExist').fadeIn().modal('show');
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#villagesTable').DataTable().clear();
                    $('#villagesTable').DataTable().destroy();
                    $('#villagesTable').DataTable({
                        "data" : data.villages,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "rural_urban",
                                "render": function (data, type, row) {
                                    if (row.rural_urban === 'R') {
                                        return 'Rural';}
                                    else {

                                        return 'Urban';
                                    }
                                }
                            },
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" class="btn-danger rounded edit_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('VILLAGE INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#vill_as_name').val('');
                    $('#vill_eng_name').val('');
                    $("#rural_urban").prop('selectedIndex', 0);
                    $("#village_status").prop('selectedIndex', 0);
                    $("#is_map").prop('selectedIndex', 0);
                    $("#is_mc").prop('selectedIndex', 0);
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit village Modal Confirm ***********//
function comfirm_add_village_form_submit() {
    if(!confirm("Are you sure want to save new village."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#ifExist').fadeIn().modal('hide');
    $('#save_success_div').hide();
    var vill_check = 'N';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewVillage",
        type: 'POST',
        data: {
            distcode: $('#district_code').val(),
            subdivcode: $('#subdiv_code').val(),
            circode: $('#circle_code').val(),
            mouzacode: $('#mouza_code').val(),
            lotcode: $('#lot_code').val(),
            vill_as_name: $('#vill_as_name').val(),
            vill_eng_name: $('#vill_eng_name').val(),
            rural_urban: $('#rural_urban').val(),
            village_status: $('#village_status').val(),
            is_map: $('#is_map').val(),
            is_mc: $('#is_mc').val(),
            vill_check: vill_check,
        },
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
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if (data.error) {
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i] + '<br>');
                }
                return;
            }
            if(data.t_error)
            {
                $('#form_errors').html(data.t_error);
                $('#save_form_error_div').show();
                return;
            }
            if (data.validation === true) {
                if(data.t_error)
                {
                    $('#vill_table_body').html(data.t_error);
                    return;
                }
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#villagesTable').DataTable().clear();
                $('#villagesTable').DataTable().destroy();
                $('#villagesTable').DataTable({
                    "data": data.villages,
                    "columns": [
                        {
                            "data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "uuid"},
                        {"data": "rural_urban",
                            "render": function (data, type, row) {
                                if (row.rural_urban === 'R') {
                                    return 'Rural';
                                } else {

                                    return 'Urban';
                                }
                            }
                        },
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" class="btn-danger rounded edit_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                    ]
                });
                $('#form_success').html('VILLAGE INSERTED SUCCESSFULLY.');
                $('#save_success_div').show();

                $('#vill_as_name').val('');
                $('#vill_eng_name').val('');
                $("#rural_urban").prop('selectedIndex', 0);
                $("#village_status").prop('selectedIndex', 0);
                $("#is_map").prop('selectedIndex', 0);
                $("#is_mc").prop('selectedIndex', 0);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********** Close Modal ******************/
function modal_close() {
    $('#vill_table_body').empty();
    $('#ifExist').modal('hide');
}

/********** Close Modal ******************/
function edit_modal_close() {
    $('#EditModal').modal('hide');
}

/********* Village Edit View ************/
$(document).on('click', '.edit_btn', function (e) {
    e.preventDefault();
    $('#EditModal').modal({backdrop: 'static', keyboard: false});
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/editModalView",
        type: 'POST',
        data: {uuid: uuid},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
            $('#e_uuid').val('');
            $('#e_district_code').val('');
            $('#e_subdiv_code').val('');
            $('#e_circle_code').val('');
            $('#e_mouza_code').val('');
            $('#e_lot_code').val('');
            $('#e_vill_townprt_code').val('');

            $('#e_vill_as_name').val('');
            $('#e_vill_eng_name').val('');
            $("#e_rural_urban").prop('selectedIndex', 0);
            $("#e_village_status").prop('selectedIndex', 0);
            $("#e_is_map").prop('selectedIndex', 0);
            $("#e_is_mc").prop('selectedIndex', 0);
            $('#edit_form_error_div').hide();
            $('#edit_form_errors').empty();
            $("#nc_btad").prop('selectedIndex', 0);
            $("#is_periphary").prop('selectedIndex', 0);
            $("#is_tribal").prop('selectedIndex', 0);
        },
        success: function (data) {
            $.unblockUI();
            $('#e_uuid').val(data.village.uuid);
            $('#e_district_code').val(data.village.dist_code);
            $('#e_subdiv_code').val(data.village.subdiv_code);
            $('#e_circle_code').val(data.village.cir_code);
            $('#e_mouza_code').val(data.village.mouza_pargona_code);
            $('#e_lot_code').val(data.village.lot_no);
            $('#e_vill_townprt_code').val(data.village.vill_townprt_code);

            $('#e_vill_as_name').val(data.village.loc_name);
            $('#e_vill_eng_name').val(data.village.locname_eng);
            $("#e_rural_urban option[value="+data.village.rural_urban+"]").prop("selected", "selected");
            $("#e_village_status option[value="+data.village.village_status+"]").prop("selected", "selected");
            $("#e_is_map option[value="+data.village.is_map+"]").prop("selected", "selected");
            $("#e_is_mc option[value="+data.village.is_gmc+"]").prop("selected", "selected");
            $("#nc_btad").val(data.village.nc_btad ? data.village.nc_btad : 'None');
            $("#is_periphary").val(data.village.is_periphary);
            $("#is_tribal").val(data.village.is_tribal);
            $('#EditModal').fadeIn().modal('show');

        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})
/********* Village Remove ************/
$(document).on('click', '.remove_btn', function (e) {
    e.preventDefault();
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/removeVillage",
        type: 'POST',
        data: {
            uuid: uuid,
            distcode: $('#district_code').val(),
            subdivcode: $('#subdiv_code').val(),
            circode: $('#circle_code').val(),
            mouzacode: $('#mouza_code').val(),
            lotcode: $('#lot_code').val(),
        },
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
            $('#add_data_div').removeClass('hide');
            var i = 1;
            $('#villagesTable').DataTable().clear();
            $('#villagesTable').DataTable().destroy();
            $('#villagesTable').DataTable({
                "data" : data.villages,
                "columns": [
                    {"data": "loc_name",
                        "render": function (data, type, row) {
                            return i++;
                        }
                    },
                    {"data": "loc_name"},
                    {"data": "locname_eng"},
                    {"data": "uuid"},
                    {"data": "rural_urban",
                        "render": function (data, type, row) {
                            if (row.rural_urban === 'R') {
                                return 'Rural';}
                            else {

                                return 'Urban';
                            }
                        }
                    },
                    {"data": "uuid",
                        "render": function (data, type, row) {
                            return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                'class="btn-danger rounded edit_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                        }
                    },
                    {"data": "uuid",
                        "render": function (data, type, row) {
                            return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                'class="btn-danger rounded edit_btn" ><i class="fa fa-trash"></i></button>';
                        }
                    },
                ]
            });
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

/********* Village Edit Form Submit ************/
function edit_village_form_submit() {
    if(!confirm("Are you sure want to update village."))
    {
        return;
    }
    $('#edit_form_error_div').hide();
    $('#edit_form_errors').empty();
    $('#save_success_div').hide();
    var vill_check = 'Y';

    $.ajax({
        url: baseurl + "AddLocationController/editNewVillage",
        type: 'POST',
        data: {
            uuid : $('#e_uuid').val(),
            distcode : $('#e_district_code').val(),
            subdivcode : $('#e_subdiv_code').val(),
            circode : $('#e_circle_code').val(),
            mouzacode :  $('#e_mouza_code').val(),
            lotcode :  $('#e_lot_code').val(),
            vill_townprt_code :  $('#e_vill_townprt_code').val(),
            vill_as_name :  $('#e_vill_as_name').val(),
            vill_eng_name :  $('#e_vill_eng_name').val(),
            rural_urban :  $('#e_rural_urban').val(),
            village_status :  $('#e_village_status').val(),
            is_map :  $('#e_is_map').val(),
            is_mc: $('#e_is_mc').val(),
            vill_check : vill_check,
            nc_btad: $('#nc_btad').val(),
            is_periphary: $('#is_periphary').val(),
            is_tribal: $('#is_tribal').val(),
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#edit_form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#edit_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#edit_form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error) {
                    $('#edit_form_errors').html(data.t_error);
                    $('#edit_form_error_div').show();
                    return;
                } else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#villagesTable').DataTable().clear();
                    $('#villagesTable').DataTable().destroy();
                    $('#villagesTable').DataTable({
                        "data" : data.villages,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "rural_urban",
                                "render": function (data, type, row) {
                                    if (row.rural_urban === 'R') {
                                        return 'Rural';}
                                    else {

                                        return 'Urban';
                                    }
                                }
                            },
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                        'class="btn-danger rounded edit_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('VILLAGE UPDATED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#vill_as_name').val('');
                    $('#vill_eng_name').val('');
                    $("#rural_urban").prop('selectedIndex', 0);
                    $("#village_status").prop('selectedIndex', 0);
                    $("#is_map").prop('selectedIndex', 0);
                    $("#is_mc").prop('selectedIndex', 0);
                    $('#EditModal').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}


// -----------------------------------------------------------


//********* validate_lot_form ***********//
function validate_lot_data() {
    $('#save_success_div').hide();
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $.ajax({
        url: baseurl + "AddLocationController/validateLocationLotData",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
        },
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
            $.unblockUI();
            $('#location_form_error_div').hide();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#location_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#location_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.success) {
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#data_table').DataTable().clear();
                $('#data_table').DataTable().destroy();
                $('#data_table').DataTable({
                    "data" : data.lots,
                    "columns": [
                        {"data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "uuid"},
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                    'class="btn-danger rounded edit_lot_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                    ]
                });
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit lot add ***********//
function add_lot_form_submit() {
    if(!confirm("Are you sure want to save new lot."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewLot",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            lot_as_name :  $('#lot_as_name').val(),
            lot_eng_name :  $('#lot_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }
                if(data.exist)
                {
                    for (let i = 0; i < data.exist.length; i++) {
                        let id = i+1;
                        $('#exist_table_body').append('<tr>'+
                            '<td>'+id+'</td>'+
                            '<td>'+data.exist[i].loc_name+'</td>'+
                            '<td>'+data.exist[i].locname_eng+'</td>'+
                            '<td>'+data.exist[i].uuid+'</td>'+
                            '</tr>');
                    }
                    $('#ifExist').fadeIn().modal('show');
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.lots,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_lot_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('LOT INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#lot_as_name').val('');
                    $('#lot_eng_name').val('');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit Lot Modal Confirm ***********//
function comfirm_add_lot_form_submit() {
    if(!confirm("Are you sure want to save new lot."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'N';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewLot",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            lot_as_name :  $('#lot_as_name').val(),
            lot_eng_name :  $('#lot_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.lots,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_lot_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('LOT INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#lot_as_name').val('');
                    $('#lot_eng_name').val('');
                    $('#ifExist').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********* lot Edit Form Submit ************/
function edit_lot_form_submit() {
    if(!confirm("Are you sure want to update lot."))
    {
        return;
    }
    $('#edit_form_error_div').hide();
    $('#edit_form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';

    $.ajax({
        url: baseurl + "AddLocationController/editNewLot",
        type: 'POST',
        data: {
            uuid : $('#e_uuid').val(),
            distcode : $('#e_district_code').val(),
            subdivcode : $('#e_subdiv_code').val(),
            circode : $('#e_circle_code').val(),
            mouzacode :  $('#e_mouza_code').val(),
            lotcode :  $('#e_lot_code').val(),
            vill_townprt_code :  $('#e_vill_townprt_code').val(),
            lot_as_name :  $('#e_lot_as_name').val(),
            lot_eng_name :  $('#e_lot_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#edit_form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#edit_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#edit_form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error) {
                    $('#edit_form_errors').html(data.t_error);
                    $('#edit_form_error_div').show();
                    return;
                } else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.lots,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                        'class="btn-danger rounded edit_lot_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('LOT UPDATED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#lot_as_name').val('');
                    $('#lot_eng_name').val('');

                    $('#EditModal').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********* Lot Edit View ************/
$(document).on('click', '.edit_lot_btn', function (e) {
    e.preventDefault();
    $('#EditModal').modal({backdrop: 'static', keyboard: false});
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/editModalView",
        type: 'POST',
        data: {uuid: uuid},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
            $('#e_uuid').val('');
            $('#e_district_code').val('');
            $('#e_subdiv_code').val('');
            $('#e_circle_code').val('');
            $('#e_mouza_code').val('');
            $('#e_lot_code').val('');
            $('#e_vill_townprt_code').val('');
            $('#e_lot_as_name').val('');
            $('#e_lot_eng_name').val('');
            
            $('#edit_form_error_div').hide();
            $('#edit_form_errors').empty();
        },
        success: function (data) {
            $.unblockUI();
            $('#e_uuid').val(data.village.uuid);
            $('#e_district_code').val(data.village.dist_code);
            $('#e_subdiv_code').val(data.village.subdiv_code);
            $('#e_circle_code').val(data.village.cir_code);
            $('#e_mouza_code').val(data.village.mouza_pargona_code);
            $('#e_lot_code').val(data.village.lot_no);
            $('#e_vill_townprt_code').val(data.village.vill_townprt_code);

            $('#e_lot_as_name').val(data.village.loc_name);
            $('#e_lot_eng_name').val(data.village.locname_eng);
            $('#EditModal').fadeIn().modal('show');
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

// -----------------------------------------------------------

//********* validate_mouza_data ***********//
function validate_mouza_data() {
    $('#save_success_div').hide();
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $.ajax({
        url: baseurl + "AddLocationController/validateLocationMouzaData",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
        },
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
            $.unblockUI();
            $('#location_form_error_div').hide();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#location_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#location_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.success) {
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#data_table').DataTable().clear();
                $('#data_table').DataTable().destroy();
                $('#data_table').DataTable({
                    "data" : data.mouzas,
                    "columns": [
                        {"data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "uuid"},
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                    'class="btn-danger rounded edit_mouza_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                    ]
                });
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit Mouza add ***********//
function add_mouza_form_submit() {
    if(!confirm("Are you sure want to save new mouza."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewMouza",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouza_as_name :  $('#mouza_as_name').val(),
            mouza_eng_name :  $('#mouza_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }
                if(data.exist)
                {
                    for (let i = 0; i < data.exist.length; i++) {
                        let id = i+1;
                        $('#exist_table_body').append('<tr>'+
                            '<td>'+id+'</td>'+
                            '<td>'+data.exist[i].loc_name+'</td>'+
                            '<td>'+data.exist[i].locname_eng+'</td>'+
                            '<td>'+data.exist[i].uuid+'</td>'+
                            '</tr>');
                    }
                    $('#ifExist').fadeIn().modal('show');
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.mouzas,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_mouza_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('MOUZA INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#mouza_as_name').val('');
                    $('#mouza_eng_name').val('');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********* Mouza Edit View ************/
$(document).on('click', '.edit_mouza_btn', function (e) {
    e.preventDefault();
    $('#EditModal').modal({backdrop: 'static', keyboard: false});
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/editModalView",
        type: 'POST',
        data: {uuid: uuid},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
            $('#e_uuid').val('');
            $('#e_district_code').val('');
            $('#e_subdiv_code').val('');
            $('#e_circle_code').val('');
            $('#e_mouza_code').val('');
            $('#e_lot_code').val('');
            $('#e_vill_townprt_code').val('');
            $('#e_mouza_as_name').val('');
            $('#e_mouza_eng_name').val('');

            $('#edit_form_error_div').hide();
            $('#edit_form_errors').empty();
        },
        success: function (data) {
            $.unblockUI();
            $('#e_uuid').val(data.village.uuid);
            $('#e_district_code').val(data.village.dist_code);
            $('#e_subdiv_code').val(data.village.subdiv_code);
            $('#e_circle_code').val(data.village.cir_code);
            $('#e_mouza_code').val(data.village.mouza_pargona_code);
            $('#e_lot_code').val(data.village.lot_no);
            $('#e_vill_townprt_code').val(data.village.vill_townprt_code);

            $('#e_mouza_as_name').val(data.village.loc_name);
            $('#e_mouza_eng_name').val(data.village.locname_eng);
            $('#EditModal').fadeIn().modal('show');
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

/********* Mouza Edit Form Submit ************/
function edit_mouza_form_submit() {
    if(!confirm("Are you sure want to update mouza."))
    {
        return;
    }
    $('#edit_form_error_div').hide();
    $('#edit_form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';

    $.ajax({
        url: baseurl + "AddLocationController/editNewMouza",
        type: 'POST',
        data: {
            uuid : $('#e_uuid').val(),
            distcode : $('#e_district_code').val(),
            subdivcode : $('#e_subdiv_code').val(),
            circode : $('#e_circle_code').val(),
            mouzacode :  $('#e_mouza_code').val(),
            lotcode :  $('#e_lot_code').val(),
            vill_townprt_code :  $('#e_vill_townprt_code').val(),
            mouza_as_name :  $('#e_mouza_as_name').val(),
            mouza_eng_name :  $('#e_mouza_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#edit_form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#edit_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#edit_form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error) {
                    $('#edit_form_errors').html(data.t_error);
                    $('#edit_form_error_div').show();
                    return;
                } else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.mouzas,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                        'class="btn-danger rounded edit_mouza_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('MOUZA UPDATED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#mouza_as_name').val('');
                    $('#mouza_eng_name').val('');

                    $('#EditModal').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit Mouza Modal Confirm ***********//
function comfirm_add_mouza_form_submit() {
    if(!confirm("Are you sure want to save new mouza."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'N';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewMouza",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            mouza_as_name :  $('#mouza_as_name').val(),
            mouza_eng_name :  $('#mouza_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.mouzas,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_mouza_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('MOUZA INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#mouza_as_name').val('');
                    $('#mouza_eng_name').val('');
                    $('#ifExist').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

// -----------------------------------------------------------

//********* validate_Circle_data ***********//
function validate_circle_data() {
    $('#save_success_div').hide();
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $.ajax({
        url: baseurl + "AddLocationController/validateLocationCircleData",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
        },
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
            $.unblockUI();
            $('#location_form_error_div').hide();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#location_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#location_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.success) {
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#data_table').DataTable().clear();
                $('#data_table').DataTable().destroy();
                $('#data_table').DataTable({
                    "data" : data.circles,
                    "columns": [
                        {"data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "cir_abbr"},
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                    'class="btn-danger rounded edit_circle_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                    ]
                });
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit circle add ***********//
function add_circle_form_submit() {
    if(!confirm("Are you sure want to save new Circle."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewCircle",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circle_as_name :  $('#circle_as_name').val(),
            circle_eng_name :  $('#circle_eng_name').val(),
            cir_abbr: $('#cir_abbr').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }
                if(data.exist)
                {
                    for (let i = 0; i < data.exist.length; i++) {
                        let id = i+1;
                        $('#exist_table_body').append('<tr>'+
                            '<td>'+id+'</td>'+
                            '<td>'+data.exist[i].loc_name+'</td>'+
                            '<td>'+data.exist[i].locname_eng+'</td>'+
                            '<td>'+data.exist[i].cir_abbr+'</td>'+
                            '</tr>');
                    }
                    $('#ifExist').fadeIn().modal('show');
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.circles,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "cir_abbr"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_circle_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('CIRCLE INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#circle_as_name').val('');
                    $('#circle_eng_name').val('');
                    $('#cir_abbr').val('');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********* Circle Edit View ************/
$(document).on('click', '.edit_circle_btn', function (e) {
    e.preventDefault();
    $('#EditModal').modal({backdrop: 'static', keyboard: false});
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/editModalView",
        type: 'POST',
        data: {uuid: uuid},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
            $('#e_uuid').val('');
            $('#e_district_code').val('');
            $('#e_subdiv_code').val('');
            $('#e_circle_code').val('');
            $('#e_mouza_code').val('');
            $('#e_lot_code').val('');
            $('#e_vill_townprt_code').val('');
            $('#e_circle_as_name').val('');
            $('#e_circle_eng_name').val('');
            $('#e_cir_abbr').val('');

            $('#edit_form_error_div').hide();
            $('#edit_form_errors').empty();
        },
        success: function (data) {
            $.unblockUI();
            $('#e_uuid').val(data.village.uuid);
            $('#e_district_code').val(data.village.dist_code);
            $('#e_subdiv_code').val(data.village.subdiv_code);
            $('#e_circle_code').val(data.village.cir_code);
            $('#e_mouza_code').val(data.village.mouza_pargona_code);
            $('#e_lot_code').val(data.village.lot_no);
            $('#e_vill_townprt_code').val(data.village.vill_townprt_code);

            $('#e_circle_as_name').val(data.village.loc_name);
            $('#e_circle_eng_name').val(data.village.locname_eng);
            $('#e_cir_abbr').val(data.village.cir_abbr);
            $('#EditModal').fadeIn().modal('show');
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

/********* circle Edit Form Submit ************/
function edit_circle_form_submit() {
    if(!confirm("Are you sure want to update circle."))
    {
        return;
    }
    $('#edit_form_error_div').hide();
    $('#edit_form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';

    $.ajax({
        url: baseurl + "AddLocationController/editNewCircle",
        type: 'POST',
        data: {
            uuid : $('#e_uuid').val(),
            distcode : $('#e_district_code').val(),
            subdivcode : $('#e_subdiv_code').val(),
            circode : $('#e_circle_code').val(),
            mouzacode :  $('#e_mouza_code').val(),
            lotcode :  $('#e_lot_code').val(),
            vill_townprt_code :  $('#e_vill_townprt_code').val(),
            circle_as_name :  $('#e_circle_as_name').val(),
            circle_eng_name :  $('#e_circle_eng_name').val(),
            cir_abbr :  $('#e_cir_abbr').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#edit_form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#edit_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#edit_form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error) {
                    $('#edit_form_errors').html(data.t_error);
                    $('#edit_form_error_div').show();
                    return;
                } else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.circles,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "cir_abbr"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                        'class="btn-danger rounded edit_circle_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('CIRCLE UPDATED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#circle_as_name').val('');
                    $('#circle_eng_name').val('');
                    $('#cir_abbr').val('');

                    $('#EditModal').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit Circle Modal Confirm ***********//
function comfirm_add_circle_form_submit() {
    if(!confirm("Are you sure want to save new circle."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'N';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewCircle",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            circle_as_name :  $('#circle_as_name').val(),
            circle_eng_name :  $('#circle_eng_name').val(),
            cir_abbr :  $('#cir_abbr').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.circles,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "cir_abbr"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_circle_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('CIRCLE INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#circle_as_name').val('');
                    $('#circle_eng_name').val('');
                    $('#cir_abbr').val('');
                    $('#ifExist').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

// -----------------------------------------------------------

//********* validate_Subdiv_data ***********//
function validate_subdiv_data() {
    $('#save_success_div').hide();
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $.ajax({
        url: baseurl + "AddLocationController/validateLocationSubdivData",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
        },
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
            $.unblockUI();
            $('#location_form_error_div').hide();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#location_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#location_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.success) {
                $('#add_data_div').removeClass('hide');
                var i = 1;
                $('#data_table').DataTable().clear();
                $('#data_table').DataTable().destroy();
                $('#data_table').DataTable({
                    "data" : data.subdivs,
                    "columns": [
                        {"data": "loc_name",
                            "render": function (data, type, row) {
                                return i++;
                            }
                        },
                        {"data": "loc_name"},
                        {"data": "locname_eng"},
                        {"data": "uuid"},
                        {"data": "uuid",
                            "render": function (data, type, row) {
                                return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                    'class="btn-danger rounded edit_subdiv_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                            }
                        },
                    ]
                });
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit subdiv add ***********//
function add_subdiv_form_submit() {
    if(!confirm("Are you sure want to save new Sub Division."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewSubdiv",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdiv_as_name :  $('#subdiv_as_name').val(),
            subdiv_eng_name :  $('#subdiv_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }
                if(data.exist)
                {
                    for (let i = 0; i < data.exist.length; i++) {
                        let id = i+1;
                        $('#exist_table_body').append('<tr>'+
                            '<td>'+id+'</td>'+
                            '<td>'+data.exist[i].loc_name+'</td>'+
                            '<td>'+data.exist[i].locname_eng+'</td>'+
                            '<td>'+data.exist[i].uuid+'</td>'+
                            '</tr>');
                    }
                    $('#ifExist').fadeIn().modal('show');
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.subdivs,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_subdiv_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('SUB DIVISION INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#subdiv_as_name').val('');
                    $('#subdiv_eng_name').val('');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

/********* subdiv Edit View ************/
$(document).on('click', '.edit_subdiv_btn', function (e) {
    e.preventDefault();
    $('#EditModal').modal({backdrop: 'static', keyboard: false});
    var uuid = $(this).data("id");
    $.ajax({
        url: baseurl + "AddLocationController/editModalView",
        type: 'POST',
        data: {uuid: uuid},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
            $('#e_uuid').val('');
            $('#e_district_code').val('');
            $('#e_subdiv_code').val('');
            $('#e_circle_code').val('');
            $('#e_mouza_code').val('');
            $('#e_lot_code').val('');
            $('#e_vill_townprt_code').val('');
            $('#e_subdiv_as_name').val('');
            $('#e_subdiv_eng_name').val('');

            $('#edit_form_error_div').hide();
            $('#edit_form_errors').empty();
        },
        success: function (data) {
            $.unblockUI();
            $('#e_uuid').val(data.village.uuid);
            $('#e_district_code').val(data.village.dist_code);
            $('#e_subdiv_code').val(data.village.subdiv_code);
            $('#e_circle_code').val(data.village.cir_code);
            $('#e_mouza_code').val(data.village.mouza_pargona_code);
            $('#e_lot_code').val(data.village.lot_no);
            $('#e_vill_townprt_code').val(data.village.vill_townprt_code);

            $('#e_subdiv_as_name').val(data.village.loc_name);
            $('#e_subdiv_eng_name').val(data.village.locname_eng);
            $('#EditModal').fadeIn().modal('show');
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

})

/********* subdiv Edit Form Submit ************/
function edit_subdiv_form_submit() {
    if(!confirm("Are you sure want to update Sub Division."))
    {
        return;
    }
    $('#edit_form_error_div').hide();
    $('#edit_form_errors').empty();
    $('#save_success_div').hide();
    var check = 'Y';

    $.ajax({
        url: baseurl + "AddLocationController/editNewSubdiv",
        type: 'POST',
        data: {
            uuid : $('#e_uuid').val(),
            distcode : $('#e_district_code').val(),
            subdivcode : $('#e_subdiv_code').val(),
            circode : $('#e_circle_code').val(),
            mouzacode :  $('#e_mouza_code').val(),
            lotcode :  $('#e_lot_code').val(),
            vill_townprt_code :  $('#e_vill_townprt_code').val(),
            subdiv_as_name :  $('#e_subdiv_as_name').val(),
            subdiv_eng_name :  $('#e_subdiv_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#vill_table_body').empty();
            $('#location_errors').empty();
            $('#edit_form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#edit_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#edit_form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error) {
                    $('#edit_form_errors').html(data.t_error);
                    $('#edit_form_error_div').show();
                    return;
                } else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.subdivs,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'" ' +
                                        'class="btn-danger rounded edit_subdiv_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('SUB DIVISION UPDATED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#subdiv_as_name').val('');
                    $('#subdiv_eng_name').val('');

                    $('#EditModal').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//********* submit subdiv Modal Confirm ***********//
function comfirm_add_subdiv_form_submit() {
    if(!confirm("Are you sure want to save new Sub Division."))
    {
        return;
    }
    $('#save_form_error_div').hide();
    $('#form_errors').empty();
    $('#save_success_div').hide();
    var check = 'N';
    $.ajax({
        url: baseurl + "AddLocationController/saveNewSubdiv",
        type: 'POST',
        data: {
            distcode : $('#district_code').val(),
            subdivcode : $('#subdiv_code').val(),
            circode : $('#circle_code').val(),
            mouzacode :  $('#mouza_code').val(),
            subdiv_as_name :  $('#subdiv_as_name').val(),
            subdiv_eng_name :  $('#subdiv_eng_name').val(),
            check : check,
        },
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
            $.unblockUI();
            $('#exist_table_body').empty();
            $('#location_errors').empty();
            $('#form_errors').empty();
            //validation_error_handle
            if(data.error){
                alert("Validation-Error, Please validate the form correctly!");
                $('#save_form_error_div').show();
                for (let i = 0; i < data.error.length; i++) {
                    $('#form_errors').append(data.error[i]+'<br>');
                }
                return;
            }
            if(data.validation === true) {
                if(data.t_error)
                {
                    $('#form_errors').html(data.t_error);
                    $('#save_form_error_div').show();
                    return;
                }else{
                    $('#add_data_div').removeClass('hide');
                    var i = 1;
                    $('#data_table').DataTable().clear();
                    $('#data_table').DataTable().destroy();
                    $('#data_table').DataTable({
                        "data" : data.subdivs,
                        "columns": [
                            {"data": "loc_name",
                                "render": function (data, type, row) {
                                    return i++;
                                }
                            },
                            {"data": "loc_name"},
                            {"data": "locname_eng"},
                            {"data": "uuid"},
                            {"data": "uuid",
                                "render": function (data, type, row) {
                                    return '<button type="button" id="'+row.uuid+'" data-id="'+row.uuid+'"' +
                                        'class="btn-danger rounded edit_subdiv_btn" ><i class="fa fa-edit"></i> EDIT</button>';
                                }
                            },
                        ]
                    });
                    $('#form_success').html('SUB DIVISION INSERTED SUCCESSFULLY.');
                    $('#save_success_div').show();

                    $('#subdiv_as_name').val('');
                    $('#subdiv_eng_name').val('');
                    $('#ifExist').modal('hide');
                }
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

