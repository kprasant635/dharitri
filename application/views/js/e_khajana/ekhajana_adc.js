$(document).ready( function () {
    //data table initialisation
    $('#ek_adc_pending_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 12,
        "autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download text-white"></i> <span class="text-white">Download As Excel</span>',
                titleAttr: 'Excel',
                title: "Account Verification Details",
            }, 
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-success btn-sm');
            btns.removeClass('dt-button');
        }
    });
});

function AdcDisposeCase(){
event.preventDefault();
    var formdata = $('#ek_adc_pending_case_display_form').serialize();
    $.ajax({
        url: baseurl + "EkhajanaAdc/AdcDisposeCase",
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
                $('#coArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    $('#coArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaAdc/index";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}

function rejectCase(case_no){
    event.preventDefault();
    showRejectModalMb2(case_no,'19');
    return;
}

// For modal display reject
function showRejectModalMb2(case_no,service_code){
    $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    $('#rejectModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectMb2Controller/getRejectModal',
        type: 'post',
        data: {service_code: service_code},
        dataType: 'json',
        success: function(data){
            $('#rejectform').trigger('reset');
            let button = '';
            let table = '';
            $.each(data, function (key, val) {
            button = '<input type="checkbox" value="'+val.reject_code+'" '+
                'class="btnChecked reject_option" name="reject_code[]"';
            table +=
                '<tr style="font-size:16px">'+
                '<td align="center">' + button + '</td>' +
                '<td>' + val.remark + '</td>' +
                '</tr>'
            });
            $('#service_code').val(service_code);
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtml').html(case_no);
            $('#reject_option').html(table);
            $('#rejectModal').modal('show');
            $.unblockUI();
        },
        error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
}

//submit the rejected case mouzadari system
$('#rejectformEkhajanaDpEstate').submit(function (e) {
    e.preventDefault();
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    var service_code = $('#service_code').val();
    //var pattadar_identified = $('#pattadar_identified').val();
    var adc_pattadar_identification_flag = $('[name=adc_pattadar_identification_flag]:checked').val();
    var case_no = $('#dharitreeCaseNo').val();
    let reject_code = $('#reject_option').val();
    let remark = $('#reject_remark').val();
    let ref_no = $('#ref_no').val();
    let url=baseurl+'EkhajanaAdc/rejectCaseDpEstate';
    //alert(pattadar_identified);
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: $("#rejectformEkhajanaDpEstate").serialize()+
            "&service_code=" + service_code+
            "&remark=" + remark +
            "&case_no=" + case_no +
            "&adc_pattadar_identification_flag=" + adc_pattadar_identification_flag,
        
        success: function(data){
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                alert("validation_error");
                $('.errorMsg').html(data.msg);
            }else if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                $('.errorMsg').html(data.msg);

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaAdc/index";
            }

        },error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
});


$('#close_reject_modal_mouzadari').click(function () {
    $('#rejectModal').modal('hide');
});

