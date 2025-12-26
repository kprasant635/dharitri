
$(document).ready( function () {
    //data table initialisation
    $('#ek_ast_pending_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    //date field initialisation
    $('#last_pay_date').datepick({dateFormat: 'yyyy-mm-dd'});
});

//payment self or other handle 
$("#paymentByOtherRadio").click(function(){
    $("#payee_details_div").show('slide', '', 400);
});
$("#paymentBySelfRadio").click(function(){
    $("#payee_details_div").hide('slide', '', 400);
});

//arrear update form submit
function astArrearUpdate(){
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
        
        $('#astArr_error_div').hide();
        $('#astArr_validation_error_msg').empty();
        var formdata = $('#ast_arrear_update_form').serialize();
        $.ajax({
            url: baseurl + "EkhajanaAstController/arrearUpdateFormSubmit",
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
                    $('#astArr_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#astArr_validation_error_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    alert(data.msg);
                    return;

                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    Swal.fire({
                        title: 'Case Disposed Successfully!',
                        text: "Now Citizen Can Pay The Amount In Repayment Mode",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Home'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = baseurl + "EkhajanaAstController/index";
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

//ast case dispose for already registerd case 
function astJwExistsCaseDispose(ek_details_id){
    $.ajax({
        url: baseurl + "EkhajanaAstController/jwExistsCaseDispose",
        type: 'POST',
        data: {"ek_details_id" : ek_details_id},
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
            //*******************/
            if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                Swal.fire({
                    title: 'Case Disposed Successfully!',
                    text: "Now Citizen Can Pay The Amount In Repayment Mode",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Home'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href = baseurl + "EkhajanaAstController/index";
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

function revertCase(case_no){
    event.preventDefault();
    showRevertModalMb2(case_no,'19');
    return;
}

// For modal display reject
function showRevertModalMb2(case_no,service_code){
    $.blockUI({
        message: $('#displayBoxEK'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    const modal = $('#Ek_revert_modal').modal({
        backdrop: 'static',
        keyboard: false,
    });
    modal.fadeIn('slow').modal('show');
    $.unblockUI();
}

//revert remark close
function EkRevertModalClose(){
    //alert('close');
    $('#Ek_revert_rmk').text('');
    $('#Ek_revert_rmk_form_validation_error_msg').empty();
    $('#Ek_revert_rmk_form_validation_error_div').hide();
    document.getElementById("Ek_revert_rmk_form").reset();
    $('#Ek_revert_modal').fadeOut('slow').modal('hide');
}

//revert remark submit handle
function EkRevertFormSubmit(){
    var remark = $('#Ek_revert_rmk').val();
    var ek_basic_id = $('#ek_basic_id').val();
    var application_no = $('#application_no').val();
    var ld_application_no = $('#ld_application_no').val();
    var case_no = $('#case_no').val();
    var patta_no = $('#patta_no').val();
    $('#Ek_revert_rmk_form_validation_error_msg').empty();
    $('#Ek_revert_rmk_form_validation_error_div').hide();
    $.ajax({
        url: baseurl + "EkhajanaAstController/updateRevertCase",
        type: 'POST',
        data: {'ek_basic_id':ek_basic_id,
               'application_no': application_no ,
               'ld_application_no':ld_application_no,
               'case_no':case_no,
               'remark' :remark,
               'patta_no': patta_no
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
            //validation_error_handle
            if(data.result == 'validation_error'){
                alert("Validation-Error, Please Submit the form correctly!");
                $('#Ek_revert_rmk_form_validation_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#Ek_revert_rmk_form_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                alert(data.msg);
                return;
            }else if(data.result == "SUCCESS"){
                $.unblockUI();
                Swal.fire({
                    title: 'Case('+ld_application_no+ ') Reverted Sucessfully!',
                    text: "This case will be available with CO",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Home'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href = baseurl + "EkhajanaAstController/index";
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
}


//****************************NEW CODES***********/
//function mouza on change 
function mouzaOnChange(){
    //***************select-reset*************/
    $('#lots').empty();
    $('#lots').append('<option value="00" selected>-ALL-LOTS-</option>');
    //***************************************/
    var dist_code = $('#dist_code').val();
    var subdiv_code = $('#subdiv_code').val();
    var cir_code = $('#cir_code').val();
    var mouza_pargona_code = $('#mouza_pargona_code').val();
    
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }else if(cir_code == '00'){
        alert("Please select a Circle");
        return;
    }else if(mouza_pargona_code == '00'){
        alert("Please select a Mouza");
        return;
    }
    $.ajax({ 
        url: baseurl + "EkhajanaAstController/getAllLots",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code,'mouza_pargona_code':mouza_pargona_code},
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
                $('#lots').append('<option value="'+data[i].lot_no+'">'+ data[i].loc_name+'</option>');
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

//function mouza on change 
function lotOnChange(){
    //***************select-reset*************/
    $('#patta_type_code').append('<option value="00" selected>-ALL-PATTA-TYPE-</option>');
    //***************************************/
    var dist_code = $('#dist_code').val();
    var subdiv_code = $('#subdiv_code').val();
    var cir_code = $('#cir_code').val();
    var mouza_pargona_code = $('#mouza_pargona_code').val();
    var lot_no = $('#lots').val();
  
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }else if(cir_code == '00'){
        alert("Please select a Circle");
        return;
    }else if(mouza_pargona_code == '00'){
        alert("Please select a Mouza");
        return;
    }
    else if(lot_no == '00'){
        alert("Please select a Lot");
        return;
    }
    $.ajax({ 
        url: baseurl + "EkhajanaAstController/getAllVillages",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code,'mouza_pargona_code':mouza_pargona_code,'lot_no':lot_no},
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
                $('#villages').append('<option value="'+data[i].vill_townprt_code+'">'+ data[i].loc_name+'</option>');
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

//function village on change 
function VillageOnChange(){
    //***************select-reset*************/
    $('#patta_type_code').empty();
    $('#patta_type_code').append('<option value="00" selected>-ALL-PATTA-TYPE-</option>');
    //***************************************/
    var dist_code = $('#dist_code').val();
    var subdiv_code = $('#subdiv_code').val();
    var cir_code = $('#cir_code').val();
    var mouza_pargona_code = $('#mouza_pargona_code').val();
    var lot_no = $('#lots').val();
    var vill_townprt_code = $('#villages').val();
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }else if(cir_code == '00'){
        alert("Please select a Circle");
        return;
    }else if(mouza_pargona_code == '00'){
        alert("Please select a Mouza");
        return;
    }else if(lot_no == '00'){
        alert("Please select a Lot");
        return;
    }else if(vill_townprt_code == '00000'){
        alert("Please select a Village");
        return;
    }

    $.ajax({ 
        url: baseurl + "EkhajanaAstController/getPattaTypes",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code,'mouza_pargona_code':mouza_pargona_code,'lot_no':lot_no,'vill_townprt_code':vill_townprt_code},
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

//function village on change 
function getPattaNo(){
    //***************select-reset*************/
    $('#patta_no').empty();
    $('#patta_no').append('<option value="00" selected>-ALL-PATTA-</option>');
    //***************************************/
    var dist_code = $('#dist_code').val();
    var subdiv_code = $('#subdiv_code').val();
    var cir_code = $('#cir_code').val();
    var mouza_pargona_code = $('#mouza_pargona_code').val();
    var lot_no = $('#lots').val();
    var vill_townprt_code = $('#villages').val();
    var patta_type_code = $('#patta_type_code').val();
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }else if(cir_code == '00'){
        alert("Please select a Circle");
        return;
    }else if(mouza_pargona_code == '00'){
        alert("Please select a Mouza");
        return;
    }else if(lot_no == '00'){
        alert("Please select a Lot");
        return;
    }else if(vill_townprt_code == '00000'){
        alert("Please select a Village");
        return;
    }else if(patta_type_code == null){
        alert("Please select a Patta Type");
        return;
    }

    $.ajax({ 
        url: baseurl + "EkhajanaAstController/getPattaNo",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code,'mouza_pargona_code':mouza_pargona_code,'lot_no':lot_no,'vill_townprt_code':vill_townprt_code,'patta_type_code':patta_type_code},
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
                $('#patta_no').append('<option value="'+data[i].patta_no+'">'+data[i].patta_no+'</option>');
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

function EkArearPreUpdationSubmit(){
    event.preventDefault();
    var formdata = $('#arrear_pre_updation_form_fillup').serialize();
    $('#ek_arrear_pre_updation_validation_error_msg').empty();
    $('#ek_arrear_pre_updation_validation_error_div').hide();
    $.ajax({
        url: baseurl + "EkhajanaAstController/submitInsertedArrear",
        type: 'POST',
        data:  formdata ,
       
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
                $('#ek_arrear_pre_updation_validation_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#ek_arrear_pre_updation_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;
            }else if(data.result == 'INPUT-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;
            }else if(data.result == "SUCCESS"){
                $.unblockUI();
                Swal.fire({
                    title: 'Arrear for the Patta Updated Successfully..!!!',
                    icon: 'success',
                    confirmButtonColor: '#3085D6',
                    confirmButtonText: 'Home'
                }).then((result) => {
                if (result.isConfirmed) {
                        //alert("In The Confiremed");
                        window.location = baseurl + "EkhajanaAstController/pre_arrear_index";
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
}