$(document).ready(function() {
    var user_id = $('#user_id').val();
    var serialNo = $('#serialNum').val();
    var cert = $('#cert').val();
    if(serialNo=="" && cert==""){
        $.blockUI({ message: '<h6>Loading.Please Wait...</h6>' });
    }
    setTimeout(
        function()
        { if(serialNo=="" && cert=="")
        {
            // $(document).ajaxStop($.unblockUI);
            $.unblockUI();
            getDSCDetails();
        }
        }, 3000);
    function getDSCDetails() {
        dscSigner.certificate(function(res) {
            console.log(res);
            $('#cname').val(res.certificates[0].subject);
            $('#cname1').html(res.certificates[0].subject);
            var mystr = res.certificates[0].issuer;
            var myarr = mystr.split(",");
            $('#issuer_name').val('Department');
            $('#issuer_name1').html('Department');
            $('#pan').val();
            $('#serialNum').val(res.certificates[0].serialNumber);
            $('#validFrom').val(res.certificates[0].notBefore);
            $('#validTo').val(res.certificates[0].notAfter);
            $('#serialNum1').html(res.certificates[0].serialNumber);
            $('#validFrom1').html(res.certificates[0].notBefore);
            $('#validTo1').html(res.certificates[0].notAfter);
            $('#cert').val(res.certificates[0].certificate);
            $('#sts').val("ACTIVE");
            $('#panel').hide();
            // get_existing_dsc_details(user_id);

        });
    }
    //    function get_existing_dsc_details(user_id){


    //     var csrfrurbantoken = $('input[name="csrf_input_name"]').val();
    //     $.ajax({
    //         type: 'post',
    //         url: baseurl + 'index.php/dsc/find_dsc_details',
    //         data: {'user_id': user_id ,'csrfrurbantoken':csrfrurbantoken },
    //         cache: false,
    //         dataType: 'json',
    //         success: function (data)
    //         {
    //              if(data['st'] == 1) {

    //                 $('#aadhar_no').val(data['result'][0]['aadhar_no']);
    //                 $('#pan').val(data['result'][0]['pan_no']);
    //                 $('#designation').val(data['result'][0]['designation']);
    //                 $('#sub').val(data['result'][0]['sub_department']);
    //                 $('#street_name').val(data['result'][0]['street_name']);
    //                 $('#b_no').val(data['result'][0]['buliding_no']);
    //                 $('#postal_code').val(data['result'][0]['postal_code']);
    //                 $('#town_name').val(data['result'][0]['town_name']);
    //                 $('#phone_no').val(data['result'][0]['phone_no']);
    //                 $('#state_code_hidden').val(data['result'][0]['state_census_code']);
    //                 $('#district_code_hidden').val(data['result'][0]['district_census_code']);
    //                 $('#max_amount').val(data['result'][0]['max_amount_for_debit']);
    //                 $('#min_amount').val(data['result'][0]['min_amount_for_debit']);

    //             }
    //             else {
    //                $('#aadhar_no').val('');
    //                 $('#pan').val('');
    //                 $('#designation').val('');
    //                 $('#sub').val('');
    //                 $('#street_name').val('');
    //                 $('#b_no').val('');
    //                 $('#postal_code').val('');
    //                 $('#town_name').val('');
    //                 $('#phone_no').val('');
    //                 $('#state_code').val('');
    //                 $('#district_cod').val('');
    //                 $('#max_amount').val('');
    //                 $('#min_amount').val('');
    //             }
    //         }
    //     });
    // }

});

$(document).on('change', '.aadhar_no_dsc', function () {
    var input = $(this).val();
    $('#csrf_token').load(baseurl + 'index.php/common/get_csrf_token', function () {
        $('input[name = csrfrurbantoken]').val($('input[name="csrf_input_name"]').val());
    });
    var csrfrurbantoken = $('input[name="csrf_input_name"]').val();

    if(input != '' && input.length == 12){
        $.ajax({
            type: 'post',
            url: baseurl + 'index.php/dsc/check_exist_or_not_in_dsc',
            data: {'aadhar_no': input,'csrfrurbantoken':csrfrurbantoken},
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data['st'] == 1) {
                    $('.aadhar_error_dsc').html(data['msg']);
                    $('.view_').prop('disabled', false);
                } else {

                    $('.aadhar_no_dsc').val('');
                    $('.aadhar_error_dsc').html(data['msg']);
                    $('.view_').prop('disabled', true);
                }
            }
        });
    }
    else{
        alert('Invalid Aadhar Number.');
        $('.aadhar_no_dsc').val('');
    }

});
$(document).on('change', '.aadhar_no_dsc_for_checker', function () {
    var input = $(this).val();
    $('#csrf_token').load(baseurl + 'index.php/common/get_csrf_token', function () {
        $('input[name = csrfrurbantoken]').val($('input[name="csrf_input_name"]').val());
    });
    var csrfrurbantoken = $('input[name="csrf_input_name"]').val();

    if(input != '' && input.length == 12){
        $.ajax({
            type: 'post',
            url: baseurl + 'index.php/dsc/check_exist_or_not_in_dsc_for_checker',
            data: {'aadhar_no': input,'csrfrurbantoken':csrfrurbantoken},
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data['st'] == 1) {
                    $('.aadhar_error_dsc_checker').html(data['msg']);
                    $('.view_').prop('disabled', false);
                } else {

                    $('.aadhar_no_dsc_for_checker').val('');
                    $('.aadhar_error_dsc_checker').html(data['msg']);
                    $('.view_').prop('disabled', true);
                }
            }
        });
    }
    else{
        alert('Invalid Aadhar Number.');
        $('.aadhar_no_dsc').val('');
    }

});
function ViewCertificate(str){

    $('#close-btn').hide();
    var file_id = $('#file_id'+str).val();
    $('#csrf_token').load(baseurl + 'index.php/common/get_csrf_token', function () {
        $('input[name = csrfrurbantoken]').val($('input[name="csrf_input_name"]').val());
    });
    var csrfrurbantoken = $('input[name="csrf_input_name"]').val();
    if(file_id){
        $.ajax({
            type: 'post',
            url: baseurl + 'index.php/dsc/ViewCertificateDetails',
            data: {'file_id': file_id,'csrfrurbantoken':csrfrurbantoken},
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data['st'] == 1) {

                    $('#certificates'+str).html(data['result'][0]['dsc_enroll_id']);
                    $('#error_'+str).html(data['msg']);

                    $('#Vc'+str).hide();

                } else {

                    $('.certificates'+str).html('');
                }
            }
        });
    }

}

