// land bank datatable initialisation 
$(document).ready( function () {
    $('#landBank_district_wise').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });

    $('#landBank_dag_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });

    $('#landBank_pending_list_dt').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });

    $('#landBank_reverted_list_dt').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    
    $('#landBank_approved_list_dt').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    
});
// **********************Common-Methods*******************
//getting all the master table gender list
function getAllGenderList(){
    var gender_list;
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandBankLM/getGenderList",
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
        url: baseurl + "LandBankLM/getCasteList",
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
//getting type of land use
function getTypeOfLandUse(){
    var type_of_land_use;
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandBankLM/getTypeOfLandUse",
        type: 'POST',
        data: "",
        dataType: 'json',
        success: function (data) {
            $.unblockUI();          
            type_of_land_use = data;    
        }
    });
    return type_of_land_use;
}
//getting type of encraocher
function getTypeOfEncraocher(){
    var type_of_encroacher;
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandBankLM/getTypeOfEncroacher",
        type: 'POST',
        data: "",
        dataType: 'json',
        success: function (data) {
            $.unblockUI();          
            type_of_encroacher = data;    
        }
    });
    return type_of_encroacher;
}
//gender list append method
function appendGenderOptions(gender_list){
    //var gender_list = getAllGenderList();
    // ***************testing***************
    //console.log(gender_list);
    //return;
    // ***************testing***************
    var str = "";
    for(var i=0; i<gender_list.length; i++) {
        str+='<option value="'+gender_list[i].id+'">'+gender_list[i].gen_name_eng+'('+gender_list[i].gen_name_ass+')</option>';
    }
    return str;
}
//caste list append method
function appendCasteOptions(caste_list){
    //var caste_list = getAllCasteList();    
    // ***************testing***************
    //console.log(caste_list);
    //return;
    // ***************testing***************
    var str = "";
    for(var i=0; i<caste_list.length; i++) {
        str+='<option value="'+caste_list[i].caste_id+'">'+caste_list[i].caset_name_eng+'</option>';
    }
    return str;
}
//type of land use append method
function appendTypeOfLandUseOptions(type_of_land_use) {
    //var type_of_land_options = getTypeOfLandUse();
    //************************/
    //console.log(type_of_land_options);
    //return 
    //************************/
    /**Edited by Manashjyoti deka on 13-03-25 start */
    var str = "";
    var Institute_flag_value = $('input[name="lb_lm_update_form_Is_Institute_flag"]:checked').val();
    if (Institute_flag_value == 'Y') {
        str += '<option value=7>INSTITUTION</option>';
    }
    else {
        for (var i = 0; i < type_of_land_use.length; i++) {
            if (Institute_flag_value == 'N' && type_of_land_use[i].CODE == 7) {
                continue;
            }
            str += '<option value="' + type_of_land_use[i].CODE + '">' + type_of_land_use[i].NAME + '</option>';
        }
    }
    return str;
    
/**Edited by Manashjyoti deka on 13-03-25 end */
}

//type of encroacher append method
function appendTypeOfEncroacher(type_of_encroacher){
    var str = "";
    for(var i=0; i<type_of_encroacher.length; i++) {
        str+='<option value="'+type_of_encroacher[i].CODE+'">'+type_of_encroacher[i].NAME+'</option>';
    }
    return str;
}
//****************land-bank-lm-update-methods*************/
//getting the lb update form in the update section
function getLbLmUpdateForm(dag_no){
    $('#enc_excel_file_msg_div').hide();
    $('#enc_excel_file_msg_text').text('');
    $('#lb_lm_update_form_dag_no').val(dag_no);
    $('#lb_lm_update_form_dag_no_header').text(dag_no);
    var formdata = $('#lb_lm_update_details_form').serialize();
    $.ajax({
        url: baseurl + "LandBankLM/getLandBankDetailsForUpdate",
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
            var gender_list = JSON.parse(data[1]);
            var caste_list = JSON.parse(data[2]);
            var type_of_land_use = JSON.parse(data[3]);
            var type_of_encroacher = JSON.parse(data[4]);
            var data = data[0];           
            if(!data.result){
                let text = "Previous entry not found for this daag no, please fill the details!";
                if (confirm(text) != true) {
                    $.unblockUI();  
                    return;
                }
                $('#lb_lm_update_form_prev_data_exists_flag').val('N');
                $('#lb_lm_update_form_last_approval_time').val("00");
                $.unblockUI();  
                const modal = $('#lb_lm_update_details_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show')
            }else if(data.result){
                let text = "Data exists for this daag, If details are re-submited then status will be changed to pending for this daag!";
                if (confirm(text) != true) {
                    return;
                }
                //enc with excel file msg
                $('#enc_excel_file_msg_div').show();
                $('#enc_excel_file_msg_text').text('Kindly verify before uploading excel sheet. The data in the excel sheet would be added as additional encroacher only, it would not update existing data.');
                //fetching previous data to the modal                
                $('#lb_lm_update_form_prev_data_exists_flag').val('Y');
                $('#lb_lm_update_form_last_approval_time').val(data.land_bank_details[0].created_at);
                $('#lb_lm_update_form_existing_year').val(data.land_bank_details[0].year);
                var nature_of_reservation = data.land_bank_details[0].nature_of_reservation;    
                $('#lb_lm_update_nature_of_reservation option[value="'+nature_of_reservation+'"]').prop("selected", "selected");                            
                var whether_encroached = data.land_bank_details[0].whether_encroached;
                $('#lb_lm_update_form_area_select_id option[value="'+whether_encroached+'"]').prop("selected", "selected");                
                if(whether_encroached == 'Y' || whether_encroached == 'I'){
                    $('#lb_lm_update_form_area_insert_div').show();
                    //area
                    $('#lb_lm_update_form_en_area_b').val(data.land_bank_details[0].en_area_b);
                    $('#lb_lm_update_form_en_area_k').val(data.land_bank_details[0].en_area_k);
                    $('#lb_lm_update_form_en_area_l').val(data.land_bank_details[0].en_area_lc);
                    $('#lb_lm_update_form_en_area_g').val(data.land_bank_details[0].en_area_g);
                    $('#lb_lm_update_form_en_area_kr').val(data.land_bank_details[0].en_area_kr);
                    $("#lbLmUpdateFormEncAddbtn").prop("disabled", false); 
                    $("#encoracher_list_file").prop("disabled", false); 
                    $("#no_of_encoracher_in_file").prop("disabled", false);  
                }else{
                    $("#lbLmUpdateFormEncAddbtn").prop("disabled", true); 
                    $("#encoracher_list_file").prop("disabled", true); 
                    $("#no_of_encoracher_in_file").prop("disabled", true);  
                }                     
                //logitude and latitude fields
                $('#lb_lm_update_form_longitude').val(data.land_bank_details[0].longitude);
                $('#lb_lm_update_form_latitude').val(data.land_bank_details[0].latitude);
                $('#lb_lm_update_details_form_enc_table tbody').empty();
                for (let i = 0; i < data.land_bank_encroacher_details.length; i++) {
                    enc_updateform_row_count = i;
                    var div = $("<tr />");
                    div.html(GetDynamicTextBoxForUpdate(i, gender_list, caste_list, type_of_land_use, type_of_encroacher));
                    $("#lb_lm_update_form_text_box_container").append(div);
                    //**********testing***********/
                    //alert(data.land_bank_encroacher_details[i]);
                    //console.log(data.land_bank_encroacher_details[i]);
                    //****************************/
                    $('#lb_lm_update_form_en_name_'+i).val(data.land_bank_encroacher_details[i].name);
                    $('#lb_lm_update_form_en_father_name_'+i).val(data.land_bank_encroacher_details[i].fathers_name);                
                    $('#lb_lm_update_form_en_gender_'+i+' option[value="'+ data.land_bank_encroacher_details[i].gender+'"]').prop("selected", "selected");                
                    //$('#lb_lm_update_form_en_from_date_'+i).datepick({dateFormat: 'yyyy-mm-dd'});
                    $('#lb_lm_update_form_en_from_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_from);
                    //$('#lb_lm_update_form_en_to_date_'+i).datepick({dateFormat: 'yyyy-mm-dd'});
                    $('#lb_lm_update_form_en_to_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_to);
                    //selects 
                    $('#lb_lm_update_form_en_landless_indigenuous_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless_indigenous+'"]').prop("selected", "selected");
                    $('#lb_lm_update_form_en_landless_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless+'"]').prop("selected", "selected");
                    $('#lb_lm_update_form_en_caste_'+i+' option[value="'+ data.land_bank_encroacher_details[i].caste+'"]').prop("selected", "selected");                    
                    $('#lb_lm_update_form_en_erosion_'+i+' option[value="'+ data.land_bank_encroacher_details[i].erosion+'"]').prop("selected", "selected");
                    $('#lb_lm_update_form_en_landslide_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landslide+'"]').prop("selected", "selected");
                    $('#lb_lm_update_form_type_of_land_use_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_land_use+'"]').prop("selected", "selected");
                    $('#lb_lm_update_form_type_of_encroacher_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_encroacher+'"]').prop("selected", "selected");
                    //$('#lb_lm_update_form_en_entry_made_in_blank_page_'+i+' option[value="'+ data.land_bank_encroacher_details[i].entry_made_in_blank_page+'"]').prop("selected", "selected");                
                    //hidden fields
                    $('#lb_lm_update_form_en_id_'+i).val(data.land_bank_encroacher_details[i].id);                
                }
                $.unblockUI();  
                const modal = $('#lb_lm_update_details_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                modal.fadeIn('slow').modal('show');
            }            
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}
//lm update modal close 
function lbLmUpdateModalClose(){
    $('#lb_lm_update_form_area_insert_div').hide();
    $('#lb_lm_update_form_validation_error_div').hide();
    $('#lb_lm_update_form_validation_error_msg').empty();
    $('#lb_lm_update_form_en_area_b').val('');
    $('#lb_lm_update_form_en_area_k').val('');
    $('#lb_lm_update_form_en_area_l').val('');
    $('#lb_lm_update_form_en_area_g').val('');
    $('#lb_lm_update_form_en_area_kr').val('');
    document.getElementById("lb_lm_update_details_form").reset();
    $('#lb_lm_update_details_form_enc_table tbody').empty();
    //***select-reset****//
    $('#lb_lm_update_nature_of_reservation').prop('selectedIndex',0);
    $('#lb_lm_update_form_area_select_id').prop('selectedIndex',0);
    //*******************//
    $('#lb_lm_update_details_modal').fadeOut('slow').modal('hide');
}
//land bank whether encroach selecton on update form modal 
$(function () {
    $('#lb_lm_update_form_area_select_id').on('change', function() {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        if($('#lb_lm_update_form_area_select_id').val() == 'Y' || 
        $('#lb_lm_update_form_area_select_id').val() == 'I'){
            $('#lb_lm_update_form_area_insert_div').show();
            $("#lbLmUpdateFormEncAddbtn").prop("disabled", false);  
            $('#lb_lm_update_details_form_enc_table tbody').show(); 
            //excel bulk upload
            $("#encoracher_list_file").prop("disabled", false); 
            $("#no_of_encoracher_in_file").prop("disabled", false);           
            $.unblockUI();
        }else if($('#lb_lm_update_form_area_select_id').val() == 'N'){
            $('#lb_lm_update_form_area_insert_div').hide();
            $("#lbLmUpdateFormEncAddbtn").prop("disabled", true); 
            $('#lb_lm_update_details_form_enc_table tbody').hide();
            //excel bulk upload
            $("#encoracher_list_file").prop("disabled", true);   
            $("#no_of_encoracher_in_file").prop("disabled", true);   
            $.unblockUI();
        }else{
            $('#lb_lm_update_form_area_insert_div').hide();
            $("#lbLmUpdateFormEncAddbtn").prop("disabled", true); 
            $('#lb_lm_update_details_form_enc_table tbody').hide(); 
            //excel bulk upload
            $("#encoracher_list_file").prop("disabled", true); 
            $("#no_of_encoracher_in_file").prop("disabled", true); 
        }
        $.unblockUI();
        
    });
});





/** added by Manashjyoti Deka on 13-05-25 start */
// $(function () {
//     $("#lb_lm_update_nature_of_reservation").on("change", function () {
//         let nature = $(this).val(); // Get selected value

//         // Clear radio button selection
//         $('input[name="lb_lm_update_form_Is_Institute_flag"]').prop('checked', false);

//         if (nature == "1" || nature == "2" || nature == "10" || nature == "11") {
//             $("#lb_lm_update_form_Is_Institute_flag_div").show(); // Show div
//         } else {
//             $("#lb_lm_update_form_Is_Institute_flag_div").hide(); // Hide div
//         }
//     });
// });

/** added by Manashjyoti Deka on 13-05-25 end */


// land bank encrocher add in update modal form 
$(function () {
    $("#lbLmUpdateFormEncAddbtn").bind("click", function () {
        var rowCount = $('#lb_lm_update_details_form_enc_table tr').length;
        lb_lm_update_form_en_count = (rowCount-2)+1;
        var div = $("<tr />");
        var gender_list = getAllGenderList();
        var caste_list = getAllCasteList();
        var type_of_land_use = getTypeOfLandUse();
        var type_of_encroacher = getTypeOfEncraocher();
        div.html(GetDynamicTextBoxForUpdate(lb_lm_update_form_en_count,gender_list,caste_list,type_of_land_use, type_of_encroacher));
        $("#lb_lm_update_form_text_box_container").append(div);
        $('#lb_lm_update_form_en_id_'+lb_lm_update_form_en_count).val("00");  
        $('#lb_lm_update_form_en_from_date_'+lb_lm_update_form_en_count);//.datepick({dateFormat: 'yyyy-mm-dd'});
        $('#lb_lm_update_form_en_to_date_'+lb_lm_update_form_en_count);//.datepick({dateFormat: 'yyyy-mm-dd'}); 
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("tr").remove();
    });
});
// land bank update modal dynamic section 
function GetDynamicTextBoxForUpdate(count,gender_list, caste_list, type_of_land_use, type_of_encroacher){
    var row =  '<td><input id ="lb_lm_update_form_en_name_'+count +'"  name="lb_lm_update_form_en_name[]" type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="lb_lm_update_form_en_father_name_'+count +'" name="lb_lm_update_form_en_father_name[]" type="text" value = "" class="form-control" /></td>'        
            +   '<td>'
                    + '<select id = "lb_lm_update_form_en_gender_'+count +'" name="lb_lm_update_form_en_gender[]" class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions(gender_list)
                    + '</select>'
            +  '</td>' 
        +   '<td><input  id = "lb_lm_update_form_en_from_date_'+count+'" name = "lb_lm_update_form_en_from_date[]" type="text" value = "" class="form-control" placeholder = "YYYY-MM-DD"/></td>'
        +   '<td><input  id = "lb_lm_update_form_en_to_date_'+count+'" name = "lb_lm_update_form_en_to_date[]" type="text" value = "" class="form-control" placeholder = "YYYY-MM-DD"/></td>'
        +   '<td>'
                + '<select id = "lb_lm_update_form_en_landless_indigenuous_'+count +'" name="lb_lm_update_form_en_landless_indigenuous[]" class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +  '</td>' 
        +   '<td>'
                + '<select id = "lb_lm_update_form_en_landless_'+count +'" name="lb_lm_update_form_en_landless[]" class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>' 
        +   '<td>'
                + '<select id = "lb_lm_update_form_en_caste_'+count +'" name="lb_lm_update_form_en_caste[]" class="form-control">'
                +        '<option value="">SELECT</option>'
                +        appendCasteOptions(caste_list)
                + '</select>'
        +   '</td>'
        +   '<td>'
                + '<select id = "lb_lm_update_form_en_erosion_'+count +'" name="lb_lm_update_form_en_erosion[]" class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>'
        +   '<td>'
                + '<select id = "lb_lm_update_form_en_landslide_'+count +'" name="lb_lm_update_form_en_landslide[]" class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>'
        // +   '<td>'
        //         + '<select id = "lb_lm_update_form_en_entry_made_in_blank_page_'+count +'" name="lb_lm_update_form_en_entry_made_in_blank_page[]" class="form-control">'
        //         +        '<option value="">SELECT</option>'
        //         +        '<option value="Y">Yes</option>'
        //         +        '<option value="N">No</option>'
        //         + '</select>'
        // +   '</td>' 
        +   '<td>'
                + '<select id = "lb_lm_update_form_type_of_land_use_'+count +'" name="lb_lm_update_form_type_of_land_use[]" class="form-control">'
                +       '<option value="">SELECT</option>' 
                +        appendTypeOfLandUseOptions(type_of_land_use)
                + '</select>'
        +   '</td>' 
        +   '<td>'
                + '<select id = "lb_lm_update_form_type_of_encroacher_'+count +'" name="lb_lm_update_form_type_of_encroacher[]" class="form-control">'
                //+       '<option value="">SELECT</option>' 
                +        appendTypeOfEncroacher(type_of_encroacher)
                + '</select>'
        +   '</td>' 
        +   '<input id ="lb_lm_update_form_en_id_'+count +'" name = "lb_lm_update_form_en_id[]" type="hidden" value = "" class="form-control" />'
        +   '<td><button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button></td>'
        return row;
}
//handling the land bank update form 
function lbLmUpdateFormSubmit(){
    event.preventDefault();    
    $('#lb_lm_update_form_submit_button').hide();
    var rowCount = $('#lb_lm_update_details_form_enc_table tr').length;
    $('#lb_lm_update_details_form_no_of_encroacher').val(rowCount-2);
    //var formdata = $('#lb_lm_update_details_form').serialize();  
    var formData = new FormData($("#lb_lm_update_details_form")[0])
    $('#lb_lm_update_form_validation_error_div').hide();
    $('#lb_lm_update_form_validation_error_msg').empty();
    $.ajax({
        url: baseurl + "LandBankLM/landBankDetailsUpdate",
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
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
            //validation_error_handle
            if(data.result == 'logical_validation_error'){
                alert(data.msg);
                $('#lb_lm_update_form_submit_button').show();
                return;
            }
            if(data.result == 'validation_error'){
                alert("Validation-Error, Please Submit the form correctly!");
                $('#lb_lm_update_form_submit_button').show();
                $('#lb_lm_update_form_validation_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#lb_lm_update_form_validation_error_msg').append(data.msg[i]);
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
            alert('Could not Complete your Request ..!, Please Try Again later..!');
            $('#lb_lm_update_form_submit_button').show();
        }
    });
}

//********************land-bank-lm-view-methods**********//
function lbViewModal(lb_details_id, flag){
    
    $.ajaxSetup({async: false});
    $.ajax({
        url: baseurl + "LandBankLM/getLbDataForView",
        type: 'POST',
        data: {'lb_details_id' : lb_details_id, 'flag': flag},
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
            var gender_list = JSON.parse(data[1]);
            var caste_list = JSON.parse(data[2]);
            var type_of_land_use = JSON.parse(data[3]);
            var type_of_encroacher = JSON.parse(data[4]);
            var data = data[0];
            //modal header fields
            var village_name = $('#lb_view_village_name_'+lb_details_id).text();
            $('#lb_view_village_name_modal').text(village_name);
            $('#lb_lm_view_form_dag_no_header').text(data.land_bank_details[0].dag_no);
            $('#lb_view_modal_current_year').text(data.land_bank_details[0].year);
            //modal form fields
            var nature_of_reservation = data.land_bank_details[0].nature_of_reservation;    
            $('#lb_view_modal_nature_of_reservation option[value="'+nature_of_reservation+'"]').prop("selected", "selected");            
            var whether_encroached = data.land_bank_details[0].whether_encroached;
            $('#lb_view_modal_whether_encroached option[value="'+whether_encroached+'"]').prop("selected", "selected");            
            if(whether_encroached == 'Y' || whether_encroached == 'I'){
                $('#lb_view_modal_area_insert_div').show();
                //area
                $('#lb_view_modal_en_area_b').val(data.land_bank_details[0].en_area_b);
                $('#lb_view_modal_en_area_k').val(data.land_bank_details[0].en_area_k);
                $('#lb_view_modal_en_area_l').val(data.land_bank_details[0].en_area_lc);
                $("#updateBtnAdd").prop("disabled", false); 
            }    

            var flag_for_institute = data.land_bank_details[0].flag_for_institute;
            if (flag_for_institute == 'Y' || flag_for_institute == 'N') {
                $('#lb_lm_update_form_Is_Institute_flag_div').show();
                if (flag_for_institute == 'Y') {
                    $("#institute_yes").prop("checked", true);
                }
                else if (flag_for_institute == 'N') {
                    $("#institute_no").prop("checked", true);
                }
            }
   
            //logitude and latitude fields
            $('#lb_view_modal_longitude').val(data.land_bank_details[0].longitude);
            $('#lb_view_modal_latitude').val(data.land_bank_details[0].latitude);            
            //encroacher_details
            $('#lb_view_modal_enc_table tbody').empty();
            for (let i = 0; i < data.land_bank_encroacher_details.length; i++) {
                enc_updateform_row_count = i;
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForView(i,gender_list,caste_list,type_of_land_use,type_of_encroacher));
                $("#lb_view_modal_text_box_container").append(div);
                //**********testing***********/
                //alert(data.land_bank_encroacher_details[i]);
                //console.log(data.land_bank_encroacher_details[i]);
                //****************************/
                $('#lb_view_modal_en_name_'+i).val(data.land_bank_encroacher_details[i].name);
                $('#lb_view_modal_en_father_name_'+i).val(data.land_bank_encroacher_details[i].fathers_name);                
                $('#lb_view_modal_en_gender_'+i+' option[value="'+ data.land_bank_encroacher_details[i].gender+'"]').prop("selected", "selected");                                
                $('#lb_view_modal_en_from_date_'+i);//.datepick({dateFormat: 'yyyy-mm-dd'});
                $('#lb_view_modal_en_from_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_from);
                $('#lb_view_modal_en_to_date_'+i);//.datepick({dateFormat: 'yyyy-mm-dd'});
                $('#lb_view_modal_en_to_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_to);                
                $('#lb_view_modal_en_landless_indigenuous_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless_indigenous+'"]').prop("selected", "selected");
                $('#lb_view_modal_en_landless_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_caste_'+i+' option[value="'+ data.land_bank_encroacher_details[i].caste+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_erosion_'+i+' option[value="'+ data.land_bank_encroacher_details[i].erosion+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_landslide_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landslide+'"]').prop("selected", "selected");
                $('#lb_lm_update_form_type_of_encroacher_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_encroacher+'"]').prop("selected", "selected");
                //$('#view_en_entry_made_in_blank_page_'+i+' option[value="'+ data.land_bank_encroacher_details[i].entry_made_in_blank_page+'"]').prop("selected", "selected");                        
                $('#lb_view_modal_en_type_of_land_use_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_land_use+'"]').prop("selected", "selected");
                console.log("c "+ i);
            }
            $.unblockUI(); 
            const modal = $('#lb_lm_view_details_modal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show');            
            $('#lb_view_modal_enc_table').dataTable({
                "scrollX": true,
                "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
                "pageLength": 4,
                "bDestroy": true,
                //"autoWidth":false,
                responsive: true
            });
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI(); 
} 

//dynamic text fileds for land bank view 
function GetDynamicTextBoxForView(count, gender_list, caste_list, type_of_land_use,type_of_encroacher) {
    var row =  '<td><input id ="lb_view_modal_en_name_'+count +'"  disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="lb_view_modal_en_father_name_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        
            +   '<td>'
                    + '<select id = "lb_view_modal_en_gender_'+count +'" disabled class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions(gender_list)
                    + '</select>'
            +  '</td>' 
        +   '<td><input  id = "lb_view_modal_en_from_date_'+count+'" disabled type="text" value = "" class="form-control" placeholder = "YYYY-MM-DD"/></td>'
        +   '<td><input  id = "lb_view_modal_en_to_date_'+count+'" disabled type="text" value = "" class="form-control" placeholder = "YYYY-MM-DD"/></td>'
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_landless_indigenuous_'+count +'"  class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +  '</td>' 
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_landless_'+count +'"  class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>' 
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_caste_'+count +'"  class="form-control">'
                +        '<option value="">SELECT</option>'
                +        appendCasteOptions(caste_list)
                + '</select>'
        +   '</td>'
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_erosion_'+count +'"  class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>'
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_landslide_'+count +'"  class="form-control">'
                +        '<option value="">SELECT</option>'
                +        '<option value="Y">Yes</option>'
                +        '<option value="N">No</option>'
                + '</select>'
        +   '</td>'
        // +   '<td>'
        //         + '<select id = "view_en_entry_made_in_blank_page_'+count +'" disabled class="form-control">'
        //         +        '<option value="">SELECT</option>'
        //         +        '<option value="Y">Yes</option>'
        //         +        '<option value="N">No</option>'
        //         + '</select>'
        // +   '</td>' 
        +   '<td>'
                + '<select disabled id = "lb_view_modal_en_type_of_land_use_'+count +'"  class="form-control">'
                +       '<option value="">SELECT</option>'
                +       appendTypeOfLandUseOptions(type_of_land_use)
                + '</select>'
        +   '</td>'
        +   '<td>'
                + '<select id = "lb_lm_update_form_type_of_encroacher_'+count +'" name="lb_lm_update_form_type_of_encroacher[]" class="form-control">'
                +       '<option value="">SELECT</option>' 
                +        appendTypeOfEncroacher(type_of_encroacher)
                + '</select>'
        +   '</td>'
        +   '<td><button disabled type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button></td>'
        return row;
}

//lm update modal close 
function lbViewModalClose(){
    $('#lb_view_modal_area_insert_div').hide();
    $('#lb_view_modal_en_area_b').val('');
    $('#lb_view_modal_en_area_k').val('');
    $('#lb_view_modal_en_area_l').val('');
    $('#lb_view_modal_en_area_g').val('');
    $('#lb_view_modal_en_area_kr').val('');
    $('#lb_view_modal_en_area_kr').val('');
    $('#lb_view_modal_longitude').val('');
    $('#lb_view_modal_latitude').val('');    
    $('#lb_view_modal_enc_table tbody').empty();
    //***select-reset****//
    $('#lb_view_modal_nature_of_reservation').prop('selectedIndex',0);
    $('#lb_view_modal_whether_encroached').prop('selectedIndex',0);
    //*******************//
    $('#lb_view_modal_enc_table').DataTable().clear().destroy();
    $('#lb_lm_view_details_modal').fadeOut('slow').modal('hide');
}

//lb rejected remark display modal 
function viewRejectedRemark(lb_details_id){
    $.ajax({
        url: baseurl + "LandBankLM/getLbRejectedRemark",
        type: 'POST',
        data: {'lb_details_id' : lb_details_id},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBoxLB'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {      
            var village_name = $('#lb_view_village_name_'+lb_details_id).text();
            var dag_no = $('#lb_rejected_dag_no_'+lb_details_id).text();
            $('#lb_rejected_rmk_display_modal_village').text(village_name); 
            $('#lb_rejected_rmk_display_modal_dag_no').text(dag_no); 
            $('#lb_rejected_rmk_display_modal_rmk').text(data.remark); 
            const modal = $('#lb_rejected_rmk_display_modal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show');
            $.unblockUI();  
            return;
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI(); 
}

//lb rejected remark display modal close 
function lbRejecteRmkDisplaydModalClose(){
    $('#lb_rejected_rmk_display_modal_village').val(''); 
    $('#lb_rejected_rmk_display_modal_dag_no').val(''); 
    $('#lb_rejected_rmk_display_modal_rmk').text(''); 
    $('#lb_rejected_rmk_display_modal').fadeOut('slow').modal('hide');
}
