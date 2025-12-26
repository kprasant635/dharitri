$(document).ready( function () {
    //data table initialisation
    $('#ek_lm_pending_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
    $('#last_pay_date1').datepick({dateFormat: 'yyyy-mm-dd'});
});

function tnCaseRegistrationForDpEstate(){
    event.preventDefault();
    var formdata = $('#dp_estate_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaTn/dpEstateCaseRegistration",
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
                $('#tnBranchArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#tnBranchArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaTn/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}



// ****************************************************************
//function subdivision on change 
function subdivisonOnChange(){
    //***************select-reset*************/
    $('#circles').empty();
    $('#circles').append('<option value="00" selected>-ALL-CIRCLES-</option>');
    //***************************************/
    var dist_code = $('#dist').val();
    var subdiv_code = $('#subdivison').val();
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }
    $.ajax({ 
        url: baseurl + "EkhajanaTn/getAllCircles",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code},
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
                $('#circles').append('<option value="'+data[i].cir_code+'">'+ data[i].loc_name+'</option>');
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

//function circle on change 
function circleOnChange(){
    //***************select-reset*************/
    $('#mouzas').empty();
    $('#mouzas').append('<option value="00" selected>-ALL-MOUZAS-</option>');
    //***************************************/
    var dist_code = $('#dist').val();
    var subdiv_code = $('#subdivison').val();
    var cir_code = $('#circles').val();
    if(dist_code == '00'){
        alert("Please select district");
        return;
    }else if(subdiv_code == '00'){
        alert("Please select a Subdivision");
        return;
    }else if(cir_code == '00'){
        alert("Please select a Circle");
        return;
    }
    $.ajax({ 
        url: baseurl + "EkhajanaTn/getAllMouzas",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code},
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
                $('#mouzas').append('<option value="'+data[i].mouza_pargona_code+'">'+ data[i].loc_name+'</option>');
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
function mouzaOnChange(){
    //***************select-reset*************/
    $('#lots').empty();
    $('#lots').append('<option value="00" selected>-ALL-LOTS-</option>');
    //***************************************/
    dist_code =$('#dist').val();
    subdiv_code =$('#subdivison').val();
    cir_code =$('#circles').val();
    mouza_pargona_code =$('#mouzas').val();
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
        url: baseurl + "EkhajanaTn/getAllLots",
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
    $('#villages').empty();
    $('#villages').append('<option value="00" selected>-ALL-VILLAGES-</option>');
    $('#patta_type_code').append('<option value="00" selected>-ALL-PATTA-TYPES-</option>');
    //***************************************/
    dist_code           = $('#dist').val();
    subdiv_code         = $('#subdivison').val();
    cir_code            = $('#circles').val();
    mouza_pargona_code  = $('#mouzas').val();
    lot_no              = $('#lots').val();
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
        url: baseurl + "EkhajanaTn/getAllVillages",
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
    dist_code           = $('#dist').val();
    subdiv_code         = $('#subdivison').val();
    cir_code            = $('#circles').val();
    mouza_pargona_code  = $('#mouzas').val();
    lot_no              = $('#lots').val();
    vill_townprt_code   = $('#villages').val();
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
        url: baseurl + "EkhajanaTn/getPattaTypes",
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
                $('#patta_type_code').append('<option value="'+data[i].type_code+'">'+ data[i].patta_type+'</option>');
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
    dist_code           = $('#dist').val();
    subdiv_code         = $('#subdivison').val();
    cir_code            = $('#circles').val();
    mouza_pargona_code  = $('#mouzas').val();
    lot_no              = $('#lots').val();
    vill_townprt_code   = $('#villages').val();
    patta_type_code     = $('#patta_type_code').val();
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
        url: baseurl + "EkhajanaTn/getPattaNo",
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

//modal open
function arrearPreUpdate(){
    event.preventDefault();
    var patta_no = $('#patta_no').val();
    $.ajax({ 
        url: baseurl + "EkhajanaTn/submitArrear",
        type: 'POST',
        data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code,'mouza_pargona_code':mouza_pargona_code,'lot_no':lot_no,'vill_townprt_code':vill_townprt_code,'patta_type_code':patta_type_code,'patta_no':patta_no},
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
                location.href =  baseurl + "EkhajanaTn/index";
            
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
        url: baseurl + "EkhajanaTn/submitInsertedArrear",
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
                        window.location = baseurl + "EkhajanaTn/preArrearIndex";
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


