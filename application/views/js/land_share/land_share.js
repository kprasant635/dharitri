//***********************Land Share Details Add-methods*****************************/

// land Share dynamic text fileds for add form modal 
function GetDynamicTextBox(count) {
    var row =  '<td><input name = "en_name[]" type="text" value = "" class="form-control" /></td>'
        +  '<td><input name = "en_english_name[]" type="text" value = "" class="form-control" /></td>'
             +   '<td>'
                    + '<select name="en_gender[]" class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions()
                    + '</select>'
            +  '</td>' 
        + '<td><input name = "en_area_bigha[]" type="text" value = "" class="form-control" /></td>'
        + '<td><input name = "en_area_katha[]" type="text" value = "" class="form-control" /></td>'
        +  '<td><input name = "en_area_lessa[]" type="text" value = "" class="form-control" /></td>'     
        +   '<td><button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button></td>'
        return row;
}

//land share add form submit handle

//***********************update-methods*****************************/

// land Share Pattadar add in update modal form
$(function () {
    var enc_updateform_row_count;
    $("#updateBtnAdd").bind("click", function () {
        var div = $("<tr />");
        div.html(GetDynamicTextBoxForUpdate(enc_updateform_row_count));
        $("#TextBoxContainerUpdateForm").append(div);
        $('#pattadar_table_id_'+enc_updateform_row_count).val("00");  
        enc_updateform_row_count++;
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("tr").remove();
    });
});

// land Share update modal dynamic section 
function GetDynamicTextBoxForUpdate(count){
    var row =
        '<td><input id ="update_indivisual_name_' + count + '"  name="update_indivisual_name[]" type="text" readonly value = "" class="form-control" /></td>'
        +   '<td><input id ="update_english_name_'+count +'" name="update_english_name[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="update_father_name_'+count +'" name="update_father_name[]" type="text" readonly value = "" class="form-control" /></td>'
        +   '<td><input id ="update_father_english_name_'+count +'" name="update_father_english_name[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="update_indivisual_dob_'+count +'" name="update_indivisual_dob[]" type="date" value = "" class="form-control" /></td>'   
            +   '<td>'
                    + '<select id = "update_en_gender_'+count +'" name="update_en_gender[]" class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions()
                    + '</select>'
        + '</td>' 
        +   '<td><input id ="update_share_area_b_'+count +'" name="update_share_area_b[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="update_share_area_k_'+count +'" name="update_share_area_k[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="update_share_area_lc_'+count +'" name="update_share_area_lc[]" type="text" value = "" class="form-control" /></td>'     
        +   '<input id ="pattadar_table_id_'+count +'" name = "pattadar_table_id[]" type="hidden" value = "" class="form-control" />'
        // +   '<td><button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button></td>'
    return row;
}

// land share update details modal close 
function land_share_update_details_modal_close(){
    $('#lb_validation_error_div_update_form').hide();
    $('#lb_validation_error_msg_update_form').empty();
    $('#update_lb_en_area_b').val('');
    $('#update_lb_en_area_k').val('');
    $('#update_lb_en_area_l').val('');
    $('#update_lb_en_area_g').val('');
    $('#update_lb_en_area_kr').val('');
    document.getElementById("land_share_update_details_form").reset();
    $('#indivisual_update_details_table tbody').empty();
    $('#land_share_update_details_modal').fadeOut('slow').modal('hide');    
    //location.reload();
}

// displaying the land share edit form 
function getLandShareEditFormModal(dag_no,dag_area_update_b,dag_area_update_k,dag_area_update_lc){
    $('#land_share_update_form_dag_no').val(dag_no);
    $('#land_share_update_form_dag_area_b').val(dag_area_update_b);
    $('#land_share_update_form_dag_area_k').val(dag_area_update_k);
    $('#land_share_update_form_dag_area_lc').val(dag_area_update_lc);
    var formdata = $('#land_share_update_details_form').serialize();
    $.ajax({
        url: baseurl + "LandShareUpdation/getLandShareDetailsForEdit",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {   
            $('#lb_update_dag_no_header').text(dag_no);
            $('#lb_update_dag_area_b_header').text(dag_area_update_b);
            $('#lb_update_dag_area_k_header').text(dag_area_update_k);
            $('#lb_update_dag_area_lc_header').text(dag_area_update_lc);

            $('#indivisual_update_details_table tbody').empty();
            for (let i = 0; i < data.land_share_indivisual_details.length; i++) {
                enc_updateform_row_count = i;
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForUpdate(i));
                $("#TextBoxContainerUpdateForm").append(div);
                $('#update_indivisual_name_'+i).val(data.land_share_indivisual_details[i].name);
                $('#update_english_name_' + i).val(data.land_share_indivisual_details[i].english_name);
                $('#update_father_name_' + i).val(data.land_share_indivisual_details[i].father_name);
                $('#update_father_english_name_'+i).val(data.land_share_indivisual_details[i].father_english_name);              
                $('#update_indivisual_dob_' + i).val(data.land_share_indivisual_details[i].pdar_dob);        
                //selects 
                $('#update_en_gender_' + i + ' option[value="' + data.land_share_indivisual_details[i].gender + '"]').prop("selected", "selected");         
                $('#update_share_area_b_'+i).val(data.land_share_indivisual_details[i].share_area_b);              
                $('#update_share_area_k_'+i).val(data.land_share_indivisual_details[i].share_area_k);              
                $('#update_share_area_lc_'+i).val(data.land_share_indivisual_details[i].share_area_lc);                 
                //hidden fields
                $('#pattadar_table_id_'+i).val(data.land_share_indivisual_details[i].id);
                
            }
            const modal = $('#land_share_update_details_modal').modal({
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

//handling the land Share update form 
function land_share_update_form_submit(){
    event.preventDefault();    
    var rowCount = $('#indivisual_update_details_table tr').length;
    $('#no_of_indivisuals_update_form').val(rowCount-2);
    var formdata = $('#land_share_update_details_form').serialize();  
    $('#lb_validation_error_div_update_form').hide();
    $('#lb_validation_error_msg_update_form').empty();
    $.ajax({
        url: baseurl + "LandShareUpdation/landShareDetailsReUpdateLM",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();
            if(data.result == 'logical_validation_error'){
                alert(data.msg);
                return;
            }
            if(data.result == 'validation_error'){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Validation-Error, Please Submit the form correctly!',
                })
                $('#lb_validation_error_div_update_form').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#lb_validation_error_msg_update_form').append(data.msg[i]);
                }
                return;
            }
            //*******************/
            if(!data.result){
                alert(data.msg);
                return;
            }else if(data.result){
                alert(data.msg);
                location.reload();
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
             Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Could not Complete your Request ..!, Please Try Again later..!',
                })
        }
    });
}

// **********************Common-Methods*******************
//getting all the master table gender list
function getAllGenderList(){
    var gender_list;
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandShareUpdation/getGenderList",
        type: 'POST',
        data: "",
        dataType: 'json',
        success: function (data) {
            $.unblockUI();            
            gender_list = data;    
        }
    });
    return gender_list;
}

//getting all the master table caste list
function getAllCasteList(){
    var caste_list;
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandShareUpdation/getCasteList",
        type: 'POST',
        data: "",
        dataType: 'json',
        success: function (data) {
            $.unblockUI();            
            caste_list = data;    
        }
    });
    return caste_list;
}

//gender list append method
function appendGenderOptions(){
    var gender_list = getAllGenderList();

    var str = "";
    for(var i=0; i<gender_list.length; i++) {
        str+='<option value="'+gender_list[i].id+'">'+gender_list[i].gen_name_eng+'('+gender_list[i].gen_name_ass+')</option>';
    }
    return str;
}

//caste list append method
function appendCasteOptions(){
    var caste_list = getAllCasteList();    
    var str = "";
    for(var i=0; i<caste_list.length; i++) {
        str+='<option value="'+caste_list[i].caste_id+'">'+caste_list[i].caset_name_eng+'</option>';
    }
    return str;
}

// **********************Land Share LM-View-Methods Begin*******************
function viewLandShareDetailsForm(dag_no,dag_area_bigha,dag_area_katha,dag_area_lessa){
    $('#lb_view_form_dag_no').val(dag_no);
    var formdata = $('#land_share_view_details_form').serialize();
    $.ajax({
        url: baseurl + "LandShareUpdation/getLandShareDetails",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();            
                $('#lb_view_dag_no_header').text(dag_no);
                $('#lb_view_dag_area_b_header').text(dag_area_bigha);
                $('#lb_view_dag_area_k_header').text(dag_area_katha);
                $('#lb_view_dag_area_lc_header').text(dag_area_lessa);

                $('#land_bank_view_form_area_insert_div').show();
                //area
                $('#view_lb_en_area_b').val(data.land_share_details[0].en_area_b);
                $('#view_lb_en_area_k').val(data.land_share_details[0].en_area_k);
                $('#view_lb_en_area_l').val(data.land_share_details[0].en_area_lc);
                $('#view_lb_en_area_g').val(data.land_share_details[0].en_area_g);
                $('#view_lb_en_area_kr').val(data.land_share_details[0].en_area_kr);
            
            $('#indivisual_view_details_table tbody').empty();
            for (let i = 0; i < data.land_share_indivisual_details.length; i++) {
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForView(i));
                $("#TextBoxContainerViewForm").append(div);
                $('#view_en_indivisual_name_' + i).val(data.land_share_indivisual_details[i].name);
                $('#view_en_english_name_' + i).val(data.land_share_indivisual_details[i].english_name);
                $('#view_en_indivisual_father_name_' + i).val(data.land_share_indivisual_details[i].father_name);
                $('#view_en_indivisual_father_english_name_' + i).val(data.land_share_indivisual_details[i].father_english_name);
                $('#view_en_indivisual_dob_' + i).val(data.land_share_indivisual_details[i].pdar_dob);
                $('#view_en_gender_'+i+' option[value="'+ data.land_share_indivisual_details[i].gender+'"]').prop("selected", "selected");
                $('#view_en_share_area_b_' + i).val(data.land_share_indivisual_details[i].share_area_b);            
                $('#view_en_share_area_k_' + i).val(data.land_share_indivisual_details[i].share_area_k);            
                $('#view_en_share_area_lc_' + i).val(data.land_share_indivisual_details[i].share_area_lc);                          
                               
            }
            const modal = $('#land_share_view_details_modal').modal({
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

// LM view Details Modal Close
function land_share_view_details_modal_close(){
    $('#land_share_view_details_modal').fadeOut('slow').modal('hide');
    document.getElementById("land_share_view_details_form").reset();
}

//dynamic text fileds for land share Details view LM End
function GetDynamicTextBoxForView(count) {
    var row =  '<td><input id ="view_en_indivisual_name_'+count +'"  disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_english_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_father_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_father_english_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_dob_' + count + '" disabled type="date" value = "" class="form-control" /></td>'
            +   '<td>'
                    + '<select id = "view_en_gender_'+count +'" disabled class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions()
                    + '</select>'
        + '</td>' 
        + '<td><input id ="view_en_share_area_b_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="view_en_share_area_k_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="view_en_share_area_lc_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        return row;
}


// displaying the land Share Add form 
function getLandShareAddFormModal(dag_no,patta_no,dag_area_b,dag_area_k,dag_area_lc){
    $('#land_share_add_form_dag_no').val(dag_no);
    $('#land_share_add_form_patta_no').val(patta_no);

    $('#land_share_add_form_dag_area_b').val(dag_area_b);
    $('#land_share_add_form_dag_area_k').val(dag_area_k);
    $('#land_share_add_form_dag_area_lc').val(dag_area_lc);
    var formdata = $('#land_share_add_details_form').serialize();
    $.ajax({
        url: baseurl + "LandShareUpdation/getLandShareDetailsForAdd",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();            
            $('#lb_add_dag_no_header').text(dag_no);
            $('#land_share_add_form_dag_area_b_header').text(dag_area_b);
            $('#land_share_add_form_dag_area_k_header').text(dag_area_k);
            $('#land_share_add_form_dag_area_lc_header').text(dag_area_lc);
            $('#indivisual_add_details_table tbody').empty();
            for (let i = 0; i < data.chitha_pattadar.length; i++) {
                enc_addform_row_count = i;
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForAdd(i));
                $("#TextBoxContainerAddForm").append(div);
                //**********testing***********/
                //****************************/
                $('#add_pattadar_id_'+i).val(data.chitha_pattadar[i].pdar_id);
                $('#add_pattadar_name_'+i).val(data.chitha_pattadar[i].pdar_name);
                $('#add_pattadar_father_name_'+i).val(data.chitha_pattadar[i].pdar_father);             
                //selects 
                $('#add_pattadar_gender_' + i + ' option[value="' + data.chitha_pattadar[i].gender + '"]').prop("selected", "selected");         
                $('#add_share_area_b_'+i).val(data.chitha_pattadar[i].share_area_b);              
                $('#add_share_area_k_'+i).val(data.chitha_pattadar[i].share_area_k);              
                $('#add_share_area_lc_'+i).val(data.chitha_pattadar[i].share_area_lc);              
                
                //hidden fields
                $('#pattadar_table_id_'+i).val(data.chitha_pattadar[i].id);                
            }
            const modal = $('#land_share_add_details_modal').modal({
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
// Dag Area Numberonly
$(document).ready(function () {
  //called when key is pressed in textbox
    $('#add_share_area_b_'+i).keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
// Dag Area Numberonly
// Append Add Field Modal content
function GetDynamicTextBoxForAdd(count){
    var row =
        '<td><input id ="add_pattadar_name_' + count + '"  name="add_pattadar_name[]" type="text" readonly  value = "" class="form-control" /></td>'
        +   '<td><input id ="add_pattadar_english_name_'+count +'" name="add_pattadar_english_name[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="add_pattadar_father_name_'+count +'" name="add_pattadar_father_name[]" type="text" readonly  value = "" class="form-control" /></td>'
        +   '<td><input id ="add_pattadar_father_english_name_'+count +'" name="add_pattadar_father_english_name[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="add_pattadar_dob_'+count +'" name="add_pattadar_dob[]" type="date" value = "" class="form-control" /></td>'
            +   '<td>'
                    + '<select id = "add_pattadar_gender_'+count +'" name="add_pattadar_gender[]" class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions()
                    + '</select>'
        + '</td>' 
        +   '<td><input id ="add_share_area_b_'+count +'" name="add_share_area_b[]" type="text" value = "" class="form-control numberonly"  minlength="1" maxlength="6" /></td>'
        +   '<td><input id ="add_share_area_k_'+count +'" name="add_share_area_k[]" type="text" value = "" class="form-control numberonly" minlength="1" maxlength="6"/></td>'
        + '<td><input id ="add_share_area_lc_' + count + '" name="add_share_area_lc[]" type="text" value = "" class="form-control numberonly" minlength="1" maxlength="10"/></td>' 
        +   '<input id ="add_pattadar_id_'+count +'" name = "add_pattadar_id[]" type="hidden"  value = "" class="form-control" />'
        return row;
}

// Land Share Add Details Form Submit function
function land_share_add_form_submit(){
    event.preventDefault();    
    var rowCount = $('#pattadar_add_details_table tr').length;
    $('#no_of_indivisuals_add_form').val(rowCount-2);
    var formdata = $('#land_share_add_details_form').serialize();  
    $('#lb_validation_error_div_add_form').hide();
    $('#lb_validation_error_msg_add_form').empty();
    $.ajax({
        url: baseurl + "LandShareUpdation/landSharePattadarDetailsAdd",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            $.unblockUI();
            //validation_error_handle
            if(data.result == 'logical_validation_error'){
                alert(data.msg);
                return;
            }
            if (data.result == 'validation_error') {
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Validation-Error, Please Submit the form correctly!',
                })
                $('#lb_validation_error_div_add_form').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#lb_validation_error_msg_add_form').append(data.msg[i]);
                }
                return;
            }
            //*******************/
            if(!data.result){
                alert(data.msg);
                return;
            }else if(data.result){
                alert(data.msg);
                location.reload();
                return;
            }
            //*******************/
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Could not Complete your Request ..!, Please Try Again later..!',
                })
            // alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

// Land Share Add Details Form Submit End

// land share add details modal close 
function land_share_add_details_modal_close(){
    $('#lb_validation_error_div_add_form').hide();
    $('#lb_validation_error_msg_add_form').empty();
    document.getElementById("land_share_add_details_form").reset();
    $('#pattadar_add_details_table tbody').empty();
    //*******************//
    $('#land_share_add_details_modal').fadeOut('slow').modal('hide');    
    //location.reload();
}
// **********************LM-View-Methods End*******************


// **********************CO-View-Methods Begin*******************
function viewLandShareDetailsFormCO(dag_no,vill_code,share_area_b,share_area_k,share_area_lc,lot_name,mouza_name,village_name){
    $('#lb_view_form_dag_no').val(dag_no);
    $('#lb_view_form_vill_code').val(vill_code);

    var formdata = $('#land_share_view_details_form_co').serialize();
    $.ajax({
        url: baseurl + "LandShareUpdation/getLandShareDetailsatCOSide",
        type: 'POST',
        data: formdata,
        dataType: 'json',
        success: function (data) {
            // $.unblockUI();            
            $('#lb_view_dag_no_co_header').text(dag_no);
            $('#lb_view_vill_code_co_header').text(vill_code);
            $('#lb_view_lot_name_co_header').text(lot_name);
            $('#lb_view_mouza_name_co_header').text(mouza_name);
            $('#lb_view_village_name_co_header').text(village_name);
            $('#lb_co_view_dag_area_b_header').text(share_area_b);
            $('#lb_co_view_dag_area_k_header').text(share_area_k);
            $('#lb_co_view_dag_area_lc_header').text(share_area_lc);

                $('#land_bank_view_form_area_insert_div').show();
                //area
                $('#view_lb_en_area_b').val(data.land_share_details[0].en_area_b);
                $('#view_lb_en_area_k').val(data.land_share_details[0].en_area_k);
                $('#view_lb_en_area_l').val(data.land_share_details[0].en_area_lc);
                $('#view_lb_en_area_g').val(data.land_share_details[0].en_area_g);
                $('#view_lb_en_area_kr').val(data.land_share_details[0].en_area_kr);
            
            $('#indivisual_view_details_table tbody').empty();
            for (let i = 0; i < data.land_share_indivisual_details.length; i++) {
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForViewCO(i));
                $("#TextBoxContainerViewForm").append(div);
                $('#view_en_indivisual_name_' + i).val(data.land_share_indivisual_details[i].name);
                $('#view_en_english_name_' + i).val(data.land_share_indivisual_details[i].english_name);
                $('#view_en_indivisual_father_name_' + i).val(data.land_share_indivisual_details[i].father_name);
                $('#view_en_indivisual_father_english_name_' + i).val(data.land_share_indivisual_details[i].father_english_name);
                $('#view_en_indivisual_dob_' + i).val(data.land_share_indivisual_details[i].pdar_dob);
                $('#view_en_gender_'+i+' option[value="'+ data.land_share_indivisual_details[i].gender+'"]').prop("selected", "selected");
                $('#view_en_share_area_b_' + i).val(data.land_share_indivisual_details[i].share_area_b);            
                $('#view_en_share_area_k_' + i).val(data.land_share_indivisual_details[i].share_area_k);            
                $('#view_en_share_area_lc_' + i).val(data.land_share_indivisual_details[i].share_area_lc);                                                       
            }
            const modal = $('#land_share_view_details_modal').modal({
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

//dynamic text fileds for land share Details view at CO End
function GetDynamicTextBoxForViewCO(count) {
    var row =  '<td><input id ="view_en_indivisual_name_'+count +'"  disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_english_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_father_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_father_english_name_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        + '<td><input id ="view_en_indivisual_dob_' + count + '" disabled type="date" value = "" class="form-control" /></td>'
            +   '<td>'
                    + '<select id = "view_en_gender_'+count +'" disabled class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions()
                    + '</select>'
        + '</td>' 
        + '<td><input id ="view_en_share_area_b_' + count + '" disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="view_en_share_area_k_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="view_en_share_area_lc_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        return row;
}

// CO view Details Modal Close
function land_share_view_details_modal_close(){
    $('#land_share_view_details_modal').fadeOut('slow').modal('hide');
    document.getElementById("land_share_view_details_form").reset();
}
// **********************CO-View-Methods End*******************