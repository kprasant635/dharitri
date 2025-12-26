// land bank datatable initialisation 
$(document).ready( function () {
    $('#landBank_pending_list_dt_dc_view').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    // $('#circle_vlb, #village_vlb, #dags_vlb').change(function(){
    //         var suddiv_code = null;
    //         var cir_code = null;
    //         var circle_vlb = $('#circle_vlb').val();
    //         if(circle_vlb){
    //             var string = circle_vlb.split("-");
    //                 suddiv_code = string[0];
    //                 cir_code = string[1];
    //         }
    //         var village = $('#village_vlb').val();
    //         var dags_vlb = $('#dags_vlb').val();
    //         $('#landBank_pending_list_dt').DataTable().destroy();
    //         load_data(suddiv_code,cir_code,village,dags_vlb);
    //     });
    //     load_data();
    //     function load_data(suddiv_code,cir_code,village,dags_vlb)
    //     {
    //         // $('#dataTable1 thead th:nth-of-type(1)').each(function () {
    //         //     var title = $(this).text();
    //         //     $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
    //         // });
    //         // $('#dataTable1 thead th:nth-of-type(2)').each(function () {
    //         //     var title = $(this).text();
    //         //     $(this).html(title+' <input type="text" class="form-control input_search form-control-sm" placeholder="Search ' + title + '" />');
    //         // });
    //         var base_url = "<?php echo base_url();?>";
    //         var table = $('#landBank_pending_list_dt').DataTable({
    //             'pageLength':10,
    //             "processing": true,
    //             "serverSide": true,
    //             "ordering": false,
    //             "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
    //             'language': {
    //                         "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
    //                     },
    //             'ajax':{
    //                 url: base_url+'index.php/LandBankDC/viewPendingCasesDC',
    //                 type:'POST',
    //                 data: {
    //                     subdiv_code: subdiv_code,
    //                     cir_code: cir_code,
    //                     village_code:village,
    //                     dags : dags_vlb
    //                 },
    //                 deferLoading: 57,
    //             },
    //             order: [[2, 'asc']],
    //             columnDefs: [{
    //                 targets: "_all",
    //                 orderable: false,
    //                 "className": "dt-center", "targets":[ 0, 1, 2, 3, 4],
    //                 }]
    //         });
    //         table.columns().every(function () {
    //             var table = this;
    //             $('input', this.header()).on('keyup change', function () {
    //                 if (table.search() !== this.value) {
    //                         table.search(this.value).draw();
    //                 }
    //             });
    //         });
    //         // button search
    //         $('.search_button').on('click', function () {
    //             $('table thead tr th .input_search').each(function(){
                   
    //                 $(this).val('');
    //                  // table.column($(this).data('columnIndex')).search('');

    //             });
    //             // $('#dataTable1').DataTable().search().draw();
    //             //table.draw();
    //             $('#landBank_pending_list_dt').DataTable().destroy();
    //             load_data();
    //         });
    //     }
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
function appendTypeOfLandUseOptions(type_of_land_options){
    //var type_of_land_options = getTypeOfLandUse();
    //************************/
    //console.log(type_of_land_options);
    //return 
    //************************/
    var str = "";
    for(var i=0; i<type_of_land_options.length; i++) {
        str+='<option value="'+type_of_land_options[i].CODE+'">'+type_of_land_options[i].NAME+'</option>';
    }
    return str;
}
//type of encroacher append method
function appendTypeOfEncroacher(type_of_encroacher){
    var str = "";
    for(var i=0; i<type_of_encroacher.length; i++) {
        str+='<option value="'+type_of_encroacher[i].CODE+'">'+type_of_encroacher[i].NAME+'</option>';
    }
    return str;
}
//********************land-bank-lm-view-methods**********//
function lbViewModalByDC(lb_details_id){
    
    $.ajax({
        url: baseurl + "LandBankDC/getLbDataForView",
        type: 'POST',
        data: {'lb_details_id' : lb_details_id},
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
            // alert(type_of_encroacher);
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

            /**Added by Manashjyoti Deka on 18-03-25 Start */
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

            /**Added by Manashjyoti Deka on 18-03-25 End */   
            //logitude and latitude fields
            $('#lb_view_modal_longitude').val(data.land_bank_details[0].longitude);
            $('#lb_view_modal_latitude').val(data.land_bank_details[0].latitude);  
            $('#lb_approve_rmk_lb_details_id').val(lb_details_id);          
            //encroacher_details
            $('#lb_view_modal_enc_table tbody').empty();
            for (let i = 0; i < data.land_bank_encroacher_details.length; i++) {
                enc_updateform_row_count = i;
                var div = $("<tr />");
                div.html(GetDynamicTextBoxForView(i, gender_list, caste_list, type_of_land_use, type_of_encroacher));
                $("#lb_view_modal_text_box_container").append(div);
                //**********testing***********/
                //alert(data.land_bank_encroacher_details[i]);
                //console.log(data.land_bank_encroacher_details[i]);
                //****************************/

                if(data.land_bank_encroacher_details[i].application_no != null)
                {
                    $('#delete_enc_dc'+i).hide();
                }
                else
                {
                    
                    $('#delete_enc_dc'+i).val(data.land_bank_encroacher_details[i].id);
                }
                
                // $('#delete_enc_dc'+i).val(data.land_bank_encroacher_details[i].id);
                $('#lb_view_modal_en_name_'+i).val(data.land_bank_encroacher_details[i].name);
                $('#lb_view_modal_en_father_name_'+i).val(data.land_bank_encroacher_details[i].fathers_name);                
                $('#lb_view_modal_en_gender_'+i+' option[value="'+ data.land_bank_encroacher_details[i].gender+'"]').prop("selected", "selected");                                
                $('#lb_view_modal_en_from_date_'+i).datepick({dateFormat: 'yyyy-mm-dd'});
                $('#lb_view_modal_en_from_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_from);
                $('#lb_view_modal_en_to_date_'+i).datepick({dateFormat: 'yyyy-mm-dd'});
                $('#lb_view_modal_en_to_date_'+i).val(data.land_bank_encroacher_details[i].encroachment_to);                
                $('#lb_view_modal_en_landless_indigenuous_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless_indigenous+'"]').prop("selected", "selected");
                $('#lb_view_modal_en_landless_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landless+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_caste_'+i+' option[value="'+ data.land_bank_encroacher_details[i].caste+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_erosion_'+i+' option[value="'+ data.land_bank_encroacher_details[i].erosion+'"]').prop("selected", "selected");                
                $('#lb_view_modal_en_landslide_'+i+' option[value="'+ data.land_bank_encroacher_details[i].landslide+'"]').prop("selected", "selected");
                $('#lb_lm_update_form_type_of_encroacher_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_encroacher+'"]').prop("selected", "selected");
                //$('#view_en_entry_made_in_blank_page_'+i+' option[value="'+ data.land_bank_encroacher_details[i].entry_made_in_blank_page+'"]').prop("selected", "selected");                        
                $('#lb_view_modal_en_type_of_land_use_'+i+' option[value="'+ data.land_bank_encroacher_details[i].type_of_land_use+'"]').prop("selected", "selected");
                console.log("count " + i);
            }
            $.unblockUI();  
            const modal = $('#lb_dc_view_details_modal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show'); 
            // $('#lb_view_modal_enc_table').dataTable({
            //     "scrollX": true,
            //     "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
            //     "pageLength": 4,
            //     "bDestroy": true,
            //     //"autoWidth":false,
            //     responsive: true
            // });
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
} 
//dynamic text fileds for land bank view 
function GetDynamicTextBoxForView(count,gender_list, caste_list, type_of_land_use, type_of_encroacher) {
    var row =  '<td><input type="checkbox" class="deleteEncDC" id="delete_enc_dc'+count +'" onclick="checkboxes();" name="delete_enc_dc[]" ></td><td><input id ="lb_view_modal_en_name_'+count +'"  disabled type="text" value = "" class="form-control" /></td>'
        +   '<td><input id ="lb_view_modal_en_father_name_'+count +'" disabled type="text" value = "" class="form-control" /></td>'
        
            +   '<td>'
                    + '<select disabled id = "lb_view_modal_en_gender_'+count +'" class="form-control">'
                    +        '<option value="">SELECT</option>'
                    +         appendGenderOptions(gender_list)
                    + '</select>'
            +  '</td>' 
        +   '<td><input readonly id = "lb_view_modal_en_from_date_'+count+'" disabled type="text" value = "" class="form-control" placeholder = "FROM-DATE"/></td>'
        +   '<td><input readonly id = "lb_view_modal_en_to_date_'+count+'" disabled type="text" value = "" class="form-control" placeholder = "TO-DATE"/></td>'
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
                + '<select disabled id = "lb_lm_update_form_type_of_encroacher_'+count +'" name="lb_lm_update_form_type_of_encroacher[]" class="form-control">'
                +       '<option value="">SELECT</option>' 
                +        appendTypeOfEncroacher(type_of_encroacher)
                + '</select>'
        +   '</td>'
        // +   '<td><button disabled type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button></td>'
        return row;
}
//lm update modal close 
function lbViewModalCloseByDC(){
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
    $("#lb_approve_rmk").val('');
    $('#lb_approval_rmk_form_validation_error_msg').html('');
    $('#lb_approval_rmk_form_validation_error_div').hide();
    $("#lb_delete_rmk_dc").val('');
    $(".deletion_remark_dc").hide();
    $( "#approved" ).removeClass( "col-sm-4" ).addClass( "col-sm-10" );
    $('#lb_view_modal_enc_table').DataTable().clear().destroy();
    $('#lb_dc_view_details_modal').fadeOut('slow').modal('hide');
}
//********************Land-Bank-Details-Approve************/
//displaying approve modal 
function lbApproveByDC(lb_details_id, dag_no){
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });
    var village_name = $('#lb_approve_modal_vill_name_'+lb_details_id).text();
    $('#lb_approve_modal_village_name').text(village_name);
    $('#lb_approve_modal_dag_no').text(dag_no);
    $('#lb_approve_rmk_lb_details_id').val(lb_details_id);
    const modal = $('#lb_approve_modal_dc').modal({
        backdrop: 'static',
        keyboard: false,
    });
    modal.fadeIn('slow').modal('show');
    $.unblockUI();
}
//approve modal close
function lbApproveModalCloseDC(){
    $('#lb_approve_rmk').text('');
    document.getElementById("lb_approve_rmk_form_dc").reset();
    $('#lb_approve_modal_dc').fadeOut('slow').modal('hide');
}
//approve modal submit handle
function lbApproveFormSubmitDC(){
    var formdata = $('#lb_approve_rmk_form_dc').serialize();  
    $('#lb_approval_rmk_form_validation_error_msg').empty();
    $('#lb_approval_rmk_form_validation_error_div').hide();
    $.ajax({
        url: baseurl + "LandBankDC/landBankDetailsApprove",
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
            $.unblockUI();
            //validation_error_handle
            if(data.result == 'validation_error'){                
                alert("Validation-Error, Please Submit the form correctly!");
                $('#lb_approval_rmk_form_validation_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#lb_approval_rmk_form_validation_error_msg').append(data.msg[i]);
                }
                return;
            }
            //*******************/
            if(!data.result){
                alert(data.msg);
                return;
            }else if(data.result){
                alert(data.msg);
                // lb_refresh();
                // location.reload();
                var subdiv_code = null;
                var cir_code = null;
                var circle_vlb = $('#circle_vlb').val();
                if(circle_vlb){
                    var string = circle_vlb.split("-");
                        subdiv_code = string[0];
                        cir_code = string[1];
                }

                var village = $('#village_vlb').val();
                var dags_vlb = $('#dags_vlb').val();
                $('#landBank_pending_list_dt').DataTable().destroy();
                // lbApproveModalCloseDC();
                lbViewModalCloseByDC();
                load_data(subdiv_code,cir_code,village,dags_vlb);
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}
//********************Land-Bank-Details-Revert************/
//displaying revert remark modal
function lbRejectByDC(lb_details_id, dag_no){
    $('#lb_revert_rmk_form_validation_error_msg').empty();
    $('#lb_revert_rmk_form_validation_error_div').hide();
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });
    var village_name = $('#lb_view_village_name_'+lb_details_id).text();
    $('#lb_revert_modal_village_name').text(village_name);
    $('#lb_revert_modal_dag_no').text(dag_no);
    $('#lb_revert_rmk_lb_details_id').val(lb_details_id);
    const modal = $('#lb_revert_modal_dc').modal({
        backdrop: 'static',
        keyboard: false,
    });
    modal.fadeIn('slow').modal('show');
    $.unblockUI();
}
//revert remark close 
function lbRevertModalCloseByDC(){
    $('#lb_revert_rmk').text('');
    $('#lb_revert_rmk_form_validation_error_msg').empty();
    $('#lb_revert_rmk_form_validation_error_div').hide();
    document.getElementById("lb_revert_rmk_form_dc").reset();
    $('#lb_revert_modal_dc').fadeOut('slow').modal('hide');
}
//revert remark submit handle
function lbRevertFormSubmitByDC(){
    var formdata = $('#lb_revert_rmk_form_dc').serialize();  
    $('#lb_revert_rmk_form_validation_error_msg').empty();
    $('#lb_revert_rmk_form_validation_error_div').hide();
    $.ajax({
        url: baseurl + "LandBankDC/landBankDetailsRevert",
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
            $.unblockUI();
            //validation_error_handle
            if(data.result == 'validation_error'){                
                alert("Validation-Error, Please Submit the form correctly!");
                $('#lb_revert_rmk_form_validation_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#lb_revert_rmk_form_validation_error_msg').append(data.msg[i]);
                }
                return;
            }
            //*******************/
            if(!data.result){
                alert(data.msg);
                return;
            }else if(data.result){
                alert(data.msg);
                // location.reload();
                var subdiv_code = null;
                var cir_code = null;
                var circle_vlb = $('#circle_vlb').val();
                if(circle_vlb){
                    var string = circle_vlb.split("-");
                        subdiv_code = string[0];
                        cir_code = string[1];
                }

                var village = $('#village_vlb').val();
                var dags_vlb = $('#dags_vlb').val();
                $('#landBank_pending_list_dt').DataTable().destroy();
                lbRevertModalCloseByDC();
                load_data(subdiv_code,cir_code,village,dags_vlb);
                // lb_refresh();
                return;
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}
//refresh 
function lb_refresh(){
    $('#lb_pagination_form').submit();
    // var offset = $('#lbCoPageOffset').val();
    // if(offset !== 0){
    //     offset = offset-1;
    //     $('#lbCoPageOffset').val(offset);
    //     $('#lb_pagination_form').submit();
    // }else{
    //     $('#lb_pagination_form').submit();
    // }
}

//********************land-bank-lm-view-methods**********//
function lbViewCORemarkModalByDC(lb_details_id){
    $.ajax({
        url: baseurl + "LandBankDC/getCORemarks",
        type: 'POST',
        data: {'lb_details_id' : lb_details_id},
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
            var data = data[0];       
            var village_name = $('#lb_view_village_name_'+lb_details_id).text();
            var dag_no = $('#lb_view_dag_no_'+lb_details_id).text();
            $('#lb_view_village_name_modal_dc').text(village_name);
            $('#lb_lm_view_form_dag_no_header_dc').text(dag_no); 
            $('#co_remarks').html(data['remark']);
            $('#co_remarks_date').html(data['created_at']); 
            $.unblockUI();  
            const modal = $('#lb_co_remarks_form').modal({
                backdrop: 'static',
                keyboard: false,
            });
            modal.fadeIn('slow').modal('show');
          
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
}

function lbCORemarksModalClose(){
    $('#lb_co_remarks_form').fadeOut('slow').modal('hide');
}
