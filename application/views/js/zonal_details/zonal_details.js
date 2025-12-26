
// land bank view modal 
function viewZoneDetailsForm(unique_village_code){
    $('#zd_view_form_vill_code').val(unique_village_code);
    var formdata = $('#zone_details_view_form').serialize();
    $.ajax({
        url: baseurl + "ZoneInformationController/getZoneDetails",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();   
            $('#zd_view_viill_code_header').text(unique_village_code);
            $('#indivisual_view_details_table tbody').empty();
            for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForView(i));
                $("#TextBoxContainerViewForm").append(div);
                $('#view_zone_name_' + i).val(data.villagewise_zone_info[i].zone_name);
                $('#view_subclass_name_' + i).val(data.villagewise_zone_info[i].subclass_name);
                $('#view_land_rate_' + i).val(data.villagewise_zone_info[i].land_rate);                                                        
            }
            const modal = $('#zone_details_view_modal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show')
        },
        error: function (jqXHR, exception) {
            // $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//dynamic text fileds for land bank view 
function GetDynamicTextBoxForView(count) {
    var row =  '<td><input id ="view_zone_name_'+count +'"  disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_subclass_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'             
        + '<td><input id ="view_land_rate_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        return row;
}

function zone_details_view_modal_close(){
    $('#zone_details_view_modal').fadeOut('slow').modal('hide');
    document.getElementById("zone_details_view_form").reset();
}

function getZoneDetailsEditFormModal(zone_code){
    $('#zone_details_update_form_zone_code').val(zone_code);
    var formdata = $('#zonal_value_update_details_form').serialize();
    $.ajax({
        url: baseurl + "ZoneInformationController/getZoneDetailsForEdit",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {      
            // $('#lb_update_vill_code_header').text(vill_code);

            $('#indivisual_update_details_table tbody').empty();
            for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                enc_updateform_row_count = i;
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForUpdate(i));
                $("#TextBoxContainerUpdateForm").append(div);
                $('#update_subclass_name_' + i).val(data.villagewise_zone_info[i].subclass_name);      
                $('#update_land_rate_'+i).val(data.villagewise_zone_info[i].land_rate);              
                //hidden fields
                $('#update_subclass_code_'+i).val(data.villagewise_zone_info[i].subclass_code);                
            }
            const modal = $('#zonal_value_update_details_modal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show')
        },
        error: function (jqXHR, exception) {
            // $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

function GetDynamicTextBoxForUpdate(count){

    var row =
        '<td><input id ="update_subclass_name_' + count + '" disabled name="update_subclass_name[]" type="text" value = ""  class="form-control" /></td>'
        + '<td><input id ="update_land_rate_' + count + '" name="update_land_rate[]" type="text" value = "" maxlength = "10" class="form-control" /></td>'
     +   '<input id ="update_subclass_code_'+count +'" name = "update_subclass_code[]" type="hidden" value = "" class="form-control" />'
        return row;
}

function zonal_value_update_details_modal_close(){
    $('#zonal_value_update_details_modal').fadeOut('slow').modal('hide');
    document.getElementById("zonal_value_update_details_form").reset();
}

function zonal_value_update_form_submit(){
    event.preventDefault();    
    var rowCount = $('#indivisual_update_details_table tr').length;
    $('#no_of_indivisuals_update_form').val(rowCount-2);
    var formdata = $('#zonal_value_update_details_form').serialize();  
    $.ajax({
        url: baseurl + "ZoneInformationController/reupdateVillageWiseZonalDetails",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function(data) {
                        console.log(data);
                        if (data.statusCode == 200) {
                            Swal.fire({
                                title: "Submitted",
                                text: "Zonal Information ReUpdated  successfully and sent for CO Approval",
                                type: "success",
                                timer: 50000
                            });
                            window.location.reload(true);
                        } else {
                            Swal.fire({
                                title: "Failed",
                                text: "Zonal Information Not Updated. Please Eneter Only Numeric values.",
                                type: "error",
                                timer: 50000
                            });
                        }
                    },
        error: function() {
                        Swal.fire({
                            title: "Failed",
                            text: "Zonal Information Not Updated. Please Eneter Only Numeric values.",
                            type: "warning",
                            timer: 50000
                        });
                    },
    });
}




// Newly Added 08/03/2023

// Zonal Details Edit Modal CO End
function editZonalDetailsCo(unique_village_code,mouza_name_co,lot_name_co,unique_village_name){
    $('#zd_edit_form_vill_code_co').val(unique_village_code);
    var formdata = $('#zonal_details_edit_form_co').serialize();
    $.ajax({
        url: baseurl + "ZoneInformationController/getZoneDetailsForEditCo",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();   
            $('#mouza_name_header_co').text(mouza_name_co);
            $('#lot_name_header_co').text(lot_name_co);
            $('#village_name_header_co').text(unique_village_name);

            $('#zonal_details_edit_table tbody').empty();
            for (let i = 0; i < data.villagewise_zone_info.length; i++) {
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForEditCo(i));
                $("#TextBoxContainerEditFormCo").append(div);
                $('#edit_villagewise_zonal_id_' + i).val(data.villagewise_zone_info[i].id);
                $('#edit_zone_name_co_' + i).val(data.villagewise_zone_info[i].zone_name);
                $('#edit_subclass_name_co_' + i).val(data.villagewise_zone_info[i].subclass_name);
                $('#edit_land_rate_co_' + i).val(data.villagewise_zone_info[i].land_rate);                                                        
            }
            const modal = $('#zonal_details_edit_modal_co').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show')
        },
        error: function (jqXHR, exception) {
            // $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

//dynamic text fileds for zonal Details Edit view 
function GetDynamicTextBoxForEditCo(count) {
    var row = '<input id ="edit_villagewise_zonal_id_'+count +'" name = "edit_villagewise_zonal_id[]"   type="hidden" value = "" class="form-control text-primary" />'
        + '<td><input id ="edit_zone_name_co_'+count +'" name = "edit_zone_name_co[]"  disabled type="text" value = "" class="form-control text-primary" /></td>'
        + '<td><input id ="edit_subclass_name_co_' + count + '" name = "edit_subclass_name_co[]" disabled type="text" value = "" class="form-control text-primary" /></td>'             
        + '<td><input id ="edit_land_rate_co_' + count + '" name = "edit_land_rate_co[]"  type="text" value = "" maxlength="15" class="form-control numberonly" placeholder="Enter Zonal Value" /></td>'
    return row;
}

function zonal_details_edit_modal_co_close(){
    $('#zonal_details_edit_modal_co').fadeOut('slow').modal('hide');
    document.getElementById("zonal_details_edit_form_co").reset();
}



 // Success Message
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 50000,
        });
        location.reload();
    }

    // Error Message
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 50000,
            showCancelButton: true
        });
    }

    // Warning Message
    function showWarningMessage(text) {
        swal.fire({
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: true,
            timer: 50000,
            // showCancelButton: true
        });
    }


// Update by CO Method
function zonal_details_update_form_co_submit() {
    event.preventDefault();
        var rowCount = $('#zonal_details_edit_table tr').length - 1;
        $('#no_of_rows_update_form').val(rowCount);
        var formdata = $('#zonal_details_edit_form_co').serialize();
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to Update these Zonal Value!",
            icon: 'info',
            html: '<p class="text-danger">*** Zonal Value edited by CO which are lesser than the value entered by LM will be sent to ADC for approval</p>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseurl + "ZoneInformationController/zonalInformationUpdateCO",
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            alert(data.message);
                            // showSuccessMessage(data.message);
                            $('#zonal_details_edit_modal_co').fadeOut('slow').modal('hide');
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    error: function() {
                        Swal.fire('Changes are not saved', '', 'warning')
                    },
                });
            }
        })
    }

