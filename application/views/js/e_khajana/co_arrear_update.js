$(document).ready( function () {
    //data table initialisation
    $('#arrear_update_view_table').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    //select 2 initialisation
    $(".js-single").select2({
        theme: "classic",
        width: 'resolve'
    });
    //date field initialisation
    $('#last_pay_date').datepick({dateFormat: 'yyyy-mm-dd'});
});
//getting village list on mouza selection 
function getVillageList(){  
    //***************select-reset*************/
    $('#village_uuid').empty();
    $('#patta_type_code').empty();
    $('#patta_numbers').empty();
    $('#pattadars').empty();
    $('#village_uuid').append('<option value="" disabled selected>-SELECT-VILLAGE-</option>');
    $('#patta_type_code').append('<option value="" disabled selected>-SELECT-PATTA-TYPE-</option>');
    $('#patta_numbers').append('<option value="" disabled selected>-SELECT-PATTA-NO-</option>');
    $('#pattadars').append('<option value="" disabled selected>-SELECT-PATTADAR-</option>');
    //***************************************/
    var mouza_code = $('#ek_mouza_code').val();
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/getVllageList",
        type: 'POST',
        data: {'mouza_code' : mouza_code},
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
            if(data.length === 0){
                alert("No Village Found ..!, Please Select Different Mouza!");
                return;
            }else{
                for(var i=0; i<data.length; i++) {
                    $('#village_uuid').append('<option value="'+data[i].uuid+'">'+data[i].loc_name+'('+ data[i].locname_eng+')</option>');
                }
                $.unblockUI();  
            }            
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI(); 
}
//function village on change 
function villageOnChange(){
    //***************select-reset*************/
    $('#patta_type_code').empty();
    $('#patta_numbers').empty();
    $('#pattadars').empty();
    $('#patta_type_code').append('<option value="" disabled selected>-SELECT-PATTA-TYPE-</option>');
    $('#patta_numbers').append('<option value="" disabled selected>-SELECT-PATTA-NO-</option>');
    $('#pattadars').append('<option value="" disabled selected>-SELECT-PATTADAR-</option>');
    //***************************************/
    var mouza_code = $('#ek_mouza_code').val();
    var village_uuid = $('#village_uuid').val();
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/getPattaTypes",
        type: 'POST',
        data: {'mouza_code':mouza_code, 'village_uuid': village_uuid},
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
            for(var i=0; i<data.length; i++) {
                $('#patta_type_code').append('<option value="'+data[i].type_code+'">'+data[i].patta_type+'('+ data[i].pattatype_eng+')</option>');
            }
            $.unblockUI();
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI(); 
}
//getting patta no
function getPattaNo(){
    //***************select-reset*************/
    $('#patta_numbers').empty();
    $('#pattadars').empty();
    $('#patta_numbers').append('<option value="" disabled selected>-SELECT-PATTA-NO-</option>');
    $('#pattadars').append('<option value="" disabled selected>-SELECT-PATTADAR-</option>');
    //***************************************/
    var village_uuid = $('#village_uuid').val();
    var patta_type_code = $('#patta_type_code').val();
    if(village_uuid == "" || patta_type_code == ""){
        alert("Please Select Village And Patta-Type..!!");
        return;
    }
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/getPataNumbers",
        type: 'POST',
        data: {'village_uuid' : village_uuid, 'patta_type_code' : patta_type_code},
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
            if(data.length === 0){
                alert("No Patta Found ..!, Please Select Different Patta Type Or Village!");
                return;
            }else{
                for(var i=0; i<data.length; i++) {
                    $('#patta_numbers').append('<option value="'+data[i].patta_no+'">'+data[i].patta_no+'</option>');
                }
                $.unblockUI();  
            }            
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI(); 
}
//getting pattadars
function getPattadars(){
    // //***************select-reset*************/
    // $('#pattadars').empty();
    // $('#pattadars').append('<option value="" disabled selected>-SELECT-PATTADAR-</option>');
    // //***************************************/
    // var village_uuid = $('#village_uuid').val();
    // var patta_type_code = $('#patta_type_code').val();
    // var patta_no = $('#patta_numbers').val();
    // if(village_uuid == "" || patta_type_code == "" || patta_no == ""){
    //     alert("Please Select Village And Patta-Type And Patta-No..!!");
    //     return;
    // }
    // $.ajax({
    //     url: baseurl + "MouzadarArrearUpdateController/getPattadars",
    //     type: 'POST',
    //     data: {'village_uuid' : village_uuid, 'patta_type_code' : patta_type_code, 'patta_no' : patta_no},
    //     dataType: 'json',
    //     beforeSend: function () {
    //         $.blockUI({
    //             message: $('#displayBoxEK'),
    //             css: {
    //                 border:'none',
    //                 backgroundColor:'transparent'
    //             }
    //         });
    //     },
    //     success: function (data) {      
    //         if(data.length === 0){
    //             alert("No Patta Found ..!, Please Select Different Patta No Or Village!");
    //             return;
    //         }else{
    //             for(var i=0; i<data.length; i++) {               
    //                 var value = data[i].pdar_id+'_'+data[i].pdar_name+'_'+data[i].pdar_father;     
    //                 $('#pattadars').append('<option value="'+value+'">'+data[i].pdar_name + '(' + data[i].pdar_father+ ')' +'</option>');
    //                 value = "";
    //             }
    //             $.unblockUI();  
    //         }            
    //     },
    //     error: function (jqXHR, exception) {
    //         $.unblockUI();
    //         alert('Could not Complete your Request ..!, Please Try Again later..!');
    //     }  
    // });
    // $.unblockUI();
}
//pattadar on change handle 
function pattadarOnChangeHandle(){
    alert("pattadar on chnage");
}
//payment self or other handle 
$("#paymentByOtherRadio").click(function(){
    $("#payee_details_div").show('slide', '', 400);
});
$("#paymentBySelfRadio").click(function(){
    $("#payee_details_div").hide('slide', '', 400);
});
//arrear update form submit
function coArrearUpdate(){
    event.preventDefault();
    $('#cauf_error_div').hide();
    $('#cauf_validation_error_msg').empty();
    var formdata = $('#mouzadar_arrear_update_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/arrearUpdateFormSubmit",
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
                alert("Validation-Error, Please Submit the form correctly!");
                $('#cauf_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#cauf_validation_error_msg').append(data.msg[i]);
                }
                return;
            }
            //*******************/
            if(!data.result){
                alert(data.msg);
                return;
            }else if(data.result){
                Swal.fire({
                    title: 'Arrer Updated Sucessfully!',
                    text: "Details can be viewd in the view details section",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Home'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href = baseurl + "EkhajanaCoArrearUpdateController/index";
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
//view arrear update modal 
function viewArrearDetails(jama_wasil_transaction_id){
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/getArrearDetailsFromJWTid",
        type: 'POST',
        data: {'jama_wasil_transaction_id' : jama_wasil_transaction_id},
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
            var village_name = $('#arrear_updated_village_name_'+jama_wasil_transaction_id).text();
            var mouza_name = $('#arrear_updated_mouza_name_'+jama_wasil_transaction_id).text();
            $('#arrear_update_view_modal_villgae_name').text(village_name);
            $('#arrear_update_view_modal_mouza_name').text(mouza_name);
            $('#arrear_update_view_modal_financial_year').text(data.financial_year);
            $('#arrear_update_view_modal_patta_no').text(data.patta_no);
            $('#arrear_update_view_modal_revenue').text(data.revenue);
            $('#arrear_update_view_modal_local_tax').text(data.local_tax);
            $('#arrear_update_view_modal_opening_balance').text(data.opening_balance);
            $('#arrear_update_view_modal_due_payment').text(data.due_payment);
            $('#arrear_update_view_modal_lrpm').text(data.last_revenue_payment_amount);
            $('#arrear_update_view_modal_lltpa').text(data.last_local_tax_payment_amount);
            const modal = $('#arrear_update_view_modal').modal({
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
    $.unblockUI();
}

//arrear view modal close
function arrearUpdateModalClose(){
    $('#arrear_update_view_modal_villgae_name').text("");
    $('#arrear_update_view_modal_pattadar_name').text("");
    $('#arrear_update_view_modal_financial_year').text("");
    $('#arrear_update_view_modal_patta_no').text("");
    $('#arrear_update_view_modal_revenue').text("");
    $('#arrear_update_view_modal_local_tax').text("");
    $('#arrear_update_view_modal_opening_balance').text("");
    $('#arrear_update_view_modal_due_payment').text("");
    $('#arrear_update_view_modal_lrpm').text("");
    $('#arrear_update_view_modal_lltpa').text("");
    $('#arrear_update_view_modal').fadeOut('slow').modal('hide');
}

//getting current revenue and local tax
function geCurrenttRevenueAndTax(){
    $('#current_revenue').val("");
    $('#current_local_tax').val("");   
    var village_uuid = $('#village_uuid').val();
    var patta_type_code = $('#patta_type_code').val();
    var patta_no = $('#patta_numbers').val();
    if(village_uuid == "" || patta_type_code == "" || patta_no == ""){
        alert("Please Select Village And Patta-Type And Patta-No..!!");
        return;
    }
    $.ajax({
        url: baseurl + "EkhajanaCoArrearUpdateController/getCurrentRevenueAndLocalTax",
        type: 'POST',
        data: {'village_uuid' : village_uuid, 'patta_type_code' : patta_type_code, 'patta_no' : patta_no},
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
            if(data.flag === false){
                alert("Record Not Found In Current Doul..!, Please Try Again Later..!");
                return;
            }
            
            if(data.flag === true){
                //alert("Revenue " + data.result.dag_revenue);
                $('#current_revenue').val(data.result.dag_revenue);
                //alert("Local Tax " + data.result.dag_local_tax);
                $('#current_local_tax').val(data.result.dag_local_tax);                
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }  
    });
    $.unblockUI();
}

