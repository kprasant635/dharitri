/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 var baseurl = baseUrl;
 $(document).ready(function (e) {
    $(window).on('mouseover', (function () {
        window.onbeforeunload = null;
    }));
    $(window).on('mouseout', (function () {
        window.onbeforeunload = ConfirmLeave;
    }));
    function ConfirmLeave() {
        return "Are You Sure You Want to Quit Dharitree?";
    }
    var prevKey = "";
    $(document).keydown(function (e) {
        if (e.key == "F5") {
            window.onbeforeunload = ConfirmLeave;
        } else if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") {
            window.onbeforeunload = ConfirmLeave;
        } else if (e.key.toUpperCase() == "R" && prevKey == "CONTROL") {
            window.onbeforeunload = ConfirmLeave;
        } else if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
            window.onbeforeunload = ConfirmLeave;
        }
        prevKey = e.key.toUpperCase();
    });
    $('#plus').click(function () {
        var current = $('body').css('font-size');
        console.log((parseInt(current) + 1) + "px");
        $('body').css('font-size', (parseInt(current) + 1) + "px");
    })
    $('#minus').click(function () {
        var current = $('body').css('font-size');
        console.log((parseInt(current) - 1) + "px");
        $('body').css('font-size', (parseInt(current) - 1) + "px");
    })
    $('#hide').click(function (e) {
        console.log('click');
        if ($('.headerwrap').is(':visible')) {
            $('.headerwrap').hide('slow', function () {
                $('#hide').html('<i class="fa fa-arrow-circle-down"></i>');
            });
        } else {
            $('.headerwrap').show('slow');
        }
    });
    console.log('Ready ajax');
    $(":input").inputmask();
    $("form").validate();
    window.baseurl = baseurl;
    $("input[name='dag_no']").change(function (e) {
        var dag_no = $(this).val();
        $.ajax({
            url: baseurl + "ajaxcontroller/dagExists/" + dag_no,
            success: function (d) {
                var object = JSON.parse(d);
                if (!object.status) {
                    $("input[name='dag_no']").popover('show');
                } else {
                    $("input[name='dag_no']").popover('hide');
                    window.dagb = object.bigha;
                    $('#lblbigha').append(" ( " + window.dagb + " ) ");
                    window.dagk = object.katha;
                    $('#lblkatha').append(" ( " + window.dagk + " ) ");
                    window.daglc = object.lessa;
                    $('#lbllessa').append(" ( " + window.daglc + " ) ");
                    window.totallessa = window.dagb * 100 + window.dagk * 20 + window.daglc;
                }
            }
        });
    });
    $("input[name='applied_b']").change(function (e) {
        console.log("Changed");
        calculateRemainingLand();
    });
    $("input[name='applied_k']").change(function (e) {
        console.log("Changed");
        calculateRemainingLand();
    });
    $("input[name='applied_lc']").change(function (e) {
        console.log("Changed");
        calculateRemainingLand();
    });
    function calculateRemainingLand() {
        var bigha = window.dagb;
        var katha = window.dagk;
        var lessa = window.daglc;
        var ganda = $('input[name="applied_g"]').val();
        var krantik = $('input[name="applied_kr"]').val();
        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseFloat(lessa);
        console.log(window.sourcelessa);
        var mbigha = $('input[name="applied_b"]').val();
        console.log("Big" + mbigha);
        var mkatha = $('input[name="applied_k').val();
        var mlessa = $('input[name="applied_lc').val();
        var ganda = $('input[name="applied_g"]').val();
        var krantik = $('input[name="applied_kr"]').val();
        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseFloat(mlessa);
        console.log(window.targetlessa);
        window.remaininglessa = sourcelessa - targetlessa;
        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = remaininglessa - bigha_r * 100 - katha_r * 20;
        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    }
    $("select[name='add_of_name']").change(function (e) {
        console.log("change");
        $user_code = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getUserDesignation/" + $user_code,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option value=" + object.user_code + ">" + object.user_desig_code + "</option>";
                $("select[name='add_of_desig']").html(template);
            }
        });
    });
    $("#select_patta_type").change(function (e) {
        console.log("change");
        var patta_type_code = $(this).val();
        $.ajax({
            url: baseurl + "chithareport/getDags/" + patta_type_code,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no_lower']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });
    $("#select_patta_type_misc_case").change(function (e) {
        console.log("change");
        var patta_type_code = $(this).val();
        var dist_code = $('input[name="dist_code"]').val();
        var subdiv_code = $('input[name="subdiv_code"]').val();
        var cir_code = $('input[name="cir_code"]').val();
        var lot_no = $('select[name="lot_no"]').val();
        var mouza_pargona_code = $('select[name="mouza_code"]').val();
        var vill_code = $('select[name="vill_code"]').val();
        var pno = $('input[name="patta_no"]').val();
        $.ajax({
            url: baseurl + "chithareport/getDagMiscCase/" + patta_type_code + "/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code + "/" + pno,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no_lower']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });
    //bonditas dag number align
    $("#selectlw").change(function (e) {
        console.log("change");
        patta_type_code = $('#select_patta_type').val();
        selectlw = $(this).val();
        //  alert(patta_type_code);
        //alert(selectlw);
        $.ajax({
            url: baseurl + "chithareport/getDagslower/" + selectlw + "/" + patta_type_code,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                //$("select[name='dag_no_lower']").html(template);
                $("select[name='dag_no_upper']").html(template);
            }
        });
    });
    //bg
    //  $('select[name="dag_no_lower"]').change(function (e) {
    // var index = $("select[name='dag_no_lower']").prop('selectedIndex');
    //  $('select[name="dag_no_upper"]').prop('selectedIndex', index);
    //  });
    var count = 2;
    $('#addnewapplicant').click(function (e) {
        console.log('Clicked');
        var template = $('#template').clone();
        var j = $(template);
        $(j).find('input').val("");
        $(j).find('.n').attr("name", "applicant[" + count + "][name]");
        $(j).find('.g').attr("name", "applicant[" + count + "][g]");
        $(j).find('.r').attr("name", "applicant[" + count + "][r]");
        $(j).find('.a1').attr("name", "applicant[" + count + "][a1]");
        $(j).find('.a2').attr("name", "applicant[" + count + "][a2]");
        $(j).find('.b').attr("name", "applicant[" + count + "][b]");
        $(j).find('.k').attr("name", "applicant[" + count + "][k]");
        $(j).find('.lc').attr("name", "applicant[" + count + "][lc]");
        $(j).find('.gn').attr("name", "applicant[" + count + "][gn]");
        $(j).find('.kr').attr("name", "applicant[" + count + "][kr]");
        count++;
        console.log(template);
        $('#freshapplicants tbody').append(template);
    });
    $('input[name="mut_kr"]').change(function (e) {
        //alert('Change');
        calculateRemainingLand();
    });
    $('input[name="mut_b"]').change(function (e) {
        // alert('Change');
        calculateRemainingLand();
    });
    $('input[name="mut_k"]').change(function (e) {
        //alert('Change');
        calculateRemainingLand();
    });
    $('input[name="mut_lc"]').change(function (e) {
        //alert('Change');
        calculateRemainingLand();
    });
    $('input[name="mut_g"]').change(function (e) {
        //alert('Change');
        calculateRemainingLand();
    });
    $('select[name="pet_minor_yn"]').change(function (e) {
        var val = $(this).val();
        console.log(val);
        if (val === 'Y') {
            $('#dobyn').show();
        } else if (val === 'N') {
            $('#dobyn').hide();
        }
        console.log("yue");
    });
    $('input[name="co_pattadar"]').click(function (e) {
        if ('input[name="co_pattadar"]:checked') {
            var y = confirm("Are you sure the new applicant is a co-pattadar");
        }
        if (y) {
            $('#cop').toggle();
        }
    });
    $('select[name="copname"]').change(function (e) {
        var selected = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getPattadarInformaton/" + selected,
            success: function (d) {
                console.log(d);
                var object = JSON.parse(d);
                var guardian = object.pdar_father;
                var add1 = object.pdar_add1;
                var add2 = object.pdar_add2;
                var mother = object.pdar_mother;
                var gender = object.pdar_gender;
                var minor = object.pdar_minor_yn;
                var minorDob = object.pdar_minor_dob;
                var relation = object.pdar_guard_reln;
                var appname = object.pdar_name;
                console.log(guardian);
                $('#applicantNam').val(appname);
                $('#guard_name').val(guardian);
                $('#add1').val(add1);
                $('#add2').val(add2);
                $('#mother_name').val(mother);
                if (gender === 'M') {
                    var option = "<option value=" + 'M>' + "MALE</option>"
                    $('#gender').html(option);
                } else if (gender === 'F') {
                    var option = "<option value=" + 'F>' + "FEMALE</option>"
                    $('#gender').html(option);
                }
                if (relation === 'f') {
                    var option = "<option value=" + 'f>' + "Father</option>"
                    $('#relation').html(option);
                } else if (relation === 'm') {
                    var option = "<option value=" + 'm>' + "Mother</option>"
                    $('#relation').html(option);
                } else if (relation === 'h') {
                    var option = "<option value=" + 'h>' + "Husband</option>"
                    $('#relation').html(option);
                } else if (relation === 'w') {
                    var option = "<option value=" + 'w>' + "Wife</option>"
                    $('#relation').html(option);
                } else if (relation === 'a') {
                    var option = "<option value=" + 'a>' + "Suppt. Mother</option>"
                    $('#relation').html(option);
                }
                if (minor === 'Y') {
                    var option = "<option value=" + 'Y>' + "Yes</option>"
                    $('#minor').html(option);
                    $('#minor_dob').show();
                    $('#minor_dob').val(minorDob);
                } else if (minor === 'N') {
                    var option = "<option value=" + 'N>' + "No</option>"
                    $('#minor').html(option);
                }
            }
        });
    });
    $('#distr').change(function (e) {
        console.log($("#distr option:selected").text());
        var val = $("#distr option:selected").text();
        $('#districtname').val(val);
    });
    $('input[name="urban"]').click(function () {
        $('select[name="landclass"]').prop('disabled', false);
    });
    $('input[name="rural"]').click(function () {
        $('select[name="landclass"]').prop('disabled', false);
    });
    $('select[name="landclass"]').change(function () {
        var val = $(this).val();
        if ($('#u').prop('checked')) {
            var u = "u";
        } else {
            var u = "r";
        }
        console.log(u);
        $.ajax({
            url: baseurl + 'AjaxController/getRevenue' + '/' + val + '/' + u,
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                $('input[name="existing"]').val(obj.revenue);
            }
        });
    });
    
	////////////////30-05-2022//////////////////////
	$('#close_reject_modal').click(function () {
        $('#rejectModal').modal('hide');
    });
    $('#rejectform').submit(function (e) {
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
        var service_code = $('#service_code').val();
        var case_no = $('#dharitreeCaseNo').val();
        let reject_code = $('#reject_option').val();
        let remark = $('#reject_remark').val();
        let ref_no = $('#ref_no').val();
            ref_no = ref_no == '' ? 'NA' : ref_no;

        let nocase = $('#nocase').val();
        let url=baseurl+'RejectController/postRejectedReason';
        if(nocase=='y'){
            url=baseurl+'RejectController/postRejectedReasonNoCase';
        }

        let serializedFormData = $("#rejectform").serialize();

        var params = new URLSearchParams(serializedFormData);

        // Convert to a plain object
        var formDataObject = {};
        params.forEach(function(value, key) {
            if(key.includes('[]')){
                if(key in formDataObject){
                    formDataObject[key] = [...formDataObject[key], value];
                }else{
                    formDataObject[key] = [value];
                }

            }else{
                formDataObject[key] = value
            }
        });

        formDataObject['ref_no'] = ref_no;
        formDataObject['service_code'] = service_code;
        formDataObject['remark'] = remark;
        formDataObject['case_no'] = case_no;

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: formDataObject,
            // data: $("#rejectform").serialize()+
            //     "&service_code=" + service_code+
            //     "&remark=" + remark +
            //     "&case_no=" + case_no,
            success: function(data){
                if(data.success === false){
                    $.unblockUI();
                    $('.errorMsg').html(data.message);
                }
                if(data.success === true){
                    window.location = data.redirect;
                }
            },error: function (errorData) {
                if(errorData.status == 403){
                    const errorInJson = errorData.responseJSON.errors;
                    if(Object.keys(errorInJson).length){
                        msg = '';
                        $.each(errorInJson, function(index, value){
                            // $(`.${index}_error`).html(value);
                            msg += `<p>${value}</p>`;
                        });

                        $('.errorMsg').html(msg);
                    }else{
                        $('.errorMsg').html('Something went wrong. Please try again later.');
                    }
                }else{
                    // $('.errorMsg').html('Something went wrong. Please try again later.');
                    alert('Something went wrong.');
                }
                $.unblockUI();
            }
        });
    });

    $('#close_reject_modal').click(function () {
        $('#rejectModal').modal('hide');
    });
    $("#checkedAll").click(function(){
        if(this.checked){
            $('.reject_option').each(function(){
                this.checked = true;
                $('.reject_option').prop('checked', true);
            })
        }else{
            $('.reject_option').each(function(){
                this.checked = false;
                $('.reject_option').prop('checked', false);
            })
        }
    });

    $(document).on('change', '.reject_option', function(){
        const closestTbl = $(this).closest('table');
        let allChecked = true;
        $('.reject_option', closestTbl).each(function() {
            if(!$(this).is(':checked')){
                allChecked = false;
            }
        });

        if(allChecked){
            $('#checkedAll', closestTbl).prop('checked', true);
        }else{
            $('#checkedAll', closestTbl).prop('checked', false);
        }
    });
	//////////////////////////////////////
});
function showRejectModal(case_no,service_code){
    $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    $('#rejectModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectController/getRejectModal',
        type: 'post',
        data: {service_code: service_code,case_no:case_no},
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
            $('#caseNoHtmls').html(case_no);
            $('#reject_option').html(table);
            $('#rejectModal').modal('show');
            $.unblockUI();
        },
        error: function (errorData) {
            // alert('Something went wrong.');
            if(errorData.status == 403){
                const errorInJson = errorData.responseJSON.errors;
                if(Object.keys(errorInJson).length){
                    msg = '';
                    $.each(errorInJson, function(index, value){
                        // $(`.${index}_error`).html(value);
                        msg += `<p>${value}</p>`;
                    });
                    errorHtml = `<div class="alert alert-warning alert-dismissible show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong class="text-danger">
                                        ${msg}
                                    </strong>
                                </div>`;
                    $('.error_container').html(errorHtml);
                }else{
                    $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                }
            }else{
                $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
            }

            window.scrollTo(0, 0);
            
            $.unblockUI();
        }
    });
}
function showRejectModalNoCase(case_no,service_code){
    $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    $('#rejectModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectController/getRejectCat/'+service_code,
        type: 'get',       
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
            $('#nocase').val('y');
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtmls').html(case_no);
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

//////////////////////////////// property chain code //////////////////////////////////////////
function checkPropChain() {

    $.ajax({
        url: baseurl + "PropChainReport/getPropChainData",
        method: 'post',
        // data:$("#prop_chain_form").serialize(),
        data: {
            dist_code: $('#LmMutationSelectDistrict').val(),
            subdiv_code: $('#subdiv_code').val(),
            circle_code: $('#circle_code').val(),
            mouza_code: $('#mouza_code').val(),
            lot_no: $('#lot_no').val(),
            vill_code: $('#vill_code').val(),
            patta_code: $('#patta_no').val(),
            patta_type_code: $('#select_patta_type_chain').val(),
            dag_no: $('#selectlw').val(),
        },
        beforeSend: function () {
            loaderBlockUi('Fetching Data. Please Wait');
        },
        success: function (d) {
            // $('#loader').hide();
            $.unblockUI();
            console.log(d);
            if (d === 'null' || d === null) {
                $('.error_span_chain').css('background-color', 'red');
                $('.error_span_chain').css('color', 'white');
                $('.error_span_chain').html('Unable to connect to Property Chain');
                // alert(object.error_msg)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Unable to connect to Property Chain"
                })
            } else {
                var object = JSON.parse(d);
                if (object.result === 0) {
                    $('.error_span_chain').css('background-color', 'red');
                    $('.error_span_chain').css('color', 'white');
                    $('.error_span_chain').html(object.error_msg);
                    // alert(object.error_msg)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: object.error_msg
                    })
                } else if (object.result === 1) {
                    var property_data = object.property_data
                    var transaction_data = object.transaction_data
                    var property_id = object.property_id
                    console.log(property_id);
                    // window.location.replace(baseurl + "PropChainReport/generatePropertyChain/" + encodeURI(property_data)+"/"+"0")
                    $.ajax({
                        url: baseurl + "PropChainReport/generatePropertyChain",
                        method: 'post',
                        data: {
                            property_id: property_id,
                            property_data: property_data,
                            transaction_data: transaction_data
                        },
                        dataType: 'html',
                        success: function (data3) {
                            $('#show-prop-report').empty().html(data3);
                        }
                    });
                } else {
                    $('.error_span_chain').css('background-color', 'red');
                    $('.error_span_chain').css('color', 'white');
                    $('.error_span_chain').html('Unable to connect to Property Chain');
                    // alert(object.error_msg)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Unable to connect to Property Chain"
                    })
                }
            }
        }
    });

}

$(document).ready(function () {

    $("#select_patta_type_chain").change(function (e) {
        console.log("change");
        // var patta_type_code = $(this).val();
        $.ajax({
            url: baseurl + "PropChainReport/getDags/",
            method: 'post',
            data: $("#prop_chain_form").serialize(),
            success: function (d) {
                console.log(d);
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });
})

function loaderBlockUi(msg) {
    $.blockUI({
        message: '<div class="d-flex flex-column align-items-center justify-content-center" style="opacity:100%;"> <div class="row"></div> <div class="text-primary spinner-border" role="status"><span class="sr-only">Loading...</span></div></div><div class="row text-primary"><strong>' + msg + '...</strong></div></div> ',
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    },
    );
}

function enable(attr_id) {
    $("#" + attr_id).attr("disabled", false);
}

// function createPropertyChain(id){
//     var property_id = $('#'+id).attr('property-id');
//     var property_data = $('#'+id).attr('prop-data');

//     //    var prop_sign = $('#'+id).attr('prop-sign');
//     //    var prop_sign_key = $('#'+id).attr('prop-sign-key');

//     $('#dsc_sign_modal').modal('show');
//     $("#prop_data").val(property_data);


//     // $('#dsc_sign_modal').on('show.bs.modal', function(e) {  
//     //     });

// }

// $('.create_prop_btn').click(function() {
//  });

function createPropertyChain(dag_no) {
    var property_id = $('#push_data_to_prop_chain' + dag_no).attr('property-id');
    var property_data = $('#push_data_to_prop_chain' + dag_no).attr('prop-data');
    var prop_sign = $('#push_data_to_prop_chain' + dag_no).attr('prop-sign');
    var prop_sign_key = $('#push_data_to_prop_chain' + dag_no).attr('prop-sign-key');
    var digi_cert = $('#push_data_to_prop_chain' + dag_no).attr('digi-cert');

    //    if(typeof baseurl!== undefined){
    //     baseurl= $('#baseurl').val();
    //    }

    // console.log(property_id);
    // console.log(property_data);
    // console.log(prop_sign);
    // console.log(prop_sign_key);
    // console.log(digi_cert);


    $.ajax({
        url: baseurl + "PropChainReport/createChainData",
        method: 'post',
        // data:$("#prop_chain_form").serialize(),
        data: {
            property_id: property_id,
            property_data: property_data,
            prop_sign: prop_sign,
            prop_sign_key: prop_sign_key,
            digi_cert: digi_cert
        },
        dataType: 'json',
        beforeSend: function () {
            loaderBlockUi('Creating New Asset. Please Wait');
        },
        success: function (data) {
            $.unblockUI();
            console.log(data);
            if (data !== null) {
                if (data.success == 1) {
                    Swal.fire(
                        {
                            icon: 'success',
                            title: 'Success',
                            html: '<ul><li>' + data.message + '.</li><li>Now update the map in property chain.</li></ul>'
                        },
                    ).then(function () {

                        $('#dsc_sign_modal #dsc-form textarea#prop_data').val(data.property_data);
                        $('#dsc_sign_modal #dsc-form #btnSign').val(" Sign Map Data");
                        $('#dsc_sign_modal #dsc-form textarea#lblSignature').val('');
                        $('#dsc_sign_modal #dsc-form textarea#lblEncryptedKey').val('');

                        document.getElementById('push_data_div' + dag_no).setAttribute('hidden', true);
                        $('#dsc_sign_modal #dsc-form .success_message').hide();
                        $('#dsc_sign_modal #dsc-form .buttondiv').show();
                        // $('#push_bc_map').removeAttr('hidden');
                        document.getElementById('push_bc_map').setAttribute("onclick", "return updateBcMap()");
                        document.getElementById('push_bc_map').setAttribute("map-data", data.map_data);
                    })
                } else if (data.success == 0 || data.success == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message + ': ' + data.error_msg + '. Error code: ' + data.error_code
                    })
                }
            } else if (data === null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to connect to property chain'
                })
            }
        }
    })

}

function updatePropertyChain(form_id) {
    var case_no = $("#case_no").val();
    // console.log(form_id);
    $.ajax({
        url: baseurl + "PropChainReport/updatePropChainData",
        method: 'post',
        data: $("#" + form_id).serialize(),
        dataType: 'json',
        beforeSend: function () {
            loaderBlockUi('Updating Property Chain for case no ' + case_no + '. Please Wait');
        },
        success: function (data) {
            $.unblockUI();
            console.log(data);
            if (data !== null) {
                if (data.success == 1) {
                    Swal.fire(
                        {
                            icon: 'success',
                            title: 'Success',
                            html: '<ul><li>Case no: ' + case_no + ' passed successfully</li><li>Chitha updated successfully</li><li>' + data.message + '.</li></ul>'
                        },
                    ).then(function () {
                        window.location.replace(baseurl + "Home");
                    })
                } else if (data.success == 0 || data.success == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message + ': ' + data.error_msg + '. Error code: ' + data.error_code
                    }).then(function () {
                        window.location.replace(baseurl + "Home");
                    })
                }
            } else if (data === null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to connect to property chain'
                }).then(function () {
                    window.location.replace(baseurl + "Home");
                })
            }
        }
    })

}


$(document).on("click", ".modal-show-dsc", function (event) {
    event.preventDefault();
    var property_id = $(this).attr('property-id');
    var property_data = $(this).attr('prop-data');
    var dag_no = $(this).attr('dag-no');

    // $("#dsc_sign_modal").modal("show");
    $('#dsc_sign_modal').modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#modal-title").empty().append("Setting up to sign data of " + property_id + ".Please Wait....");
    $('#view-modal-body').empty().html(
        // "<div class='text-center container conLoader'><img class='imgLoader' src=''></div>"
        loaderBlockUi('Loading. Please Wait')
    );
    $.ajax({
        url: baseurl + "DigitalCertificate/signDsc",
        type: 'POST',
        data: {
            property_data: property_data,
            property_id: property_id,
            dag_no: dag_no
        },
        dataType: "html",
        success: function (data) {
            $.unblockUI();
            $('#dsc_sign_modal_body').empty().html(data);
            $("#modal-title").empty().append('Digital Signature');
        }
    });
    $("#dsc_sign_modal").modal("show");
});

function updateBcMap() {
    var certificate = $('#dsc_sign_modal #dsc-form textarea#cert').val()
    var prop_data = $('#dsc_sign_modal #dsc-form textarea#prop_data').val()
    var prop_sign = $('#dsc_sign_modal #dsc-form textarea#lblSignature').val();
    var prop_sign_key = $('#dsc_sign_modal #dsc-form textarea#lblEncryptedKey').val();
    var map_data = $('#dsc_sign_modal #dsc-form #push_bc_map').attr('map-data');
    $.ajax({
        url: baseurl + "PropChainReport/updateMapData",
        method: 'post',
        //  data:$("#dsc-form").serialize(),
        data: {
            certificate: certificate,
            map_data: map_data,
            prop_sign: prop_sign,
            prop_sign_key: prop_sign_key,
            prop_data: prop_data
        },
        dataType: 'json',
        beforeSend: function () {
            loaderBlockUi('Updating map in property chain. Please Wait');
        },
        success: function (data) {
            $.unblockUI();
            console.log(data);
            if (data !== null) {
                if (data.success == 1) {
                    // alert(data.message);
                    $('#dsc_sign_modal').modal('hide');

                    Swal.fire(
                        {
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        },
                        // function (){
                        //     location.reload();
                        // }
                    ).then(function () {
                        // location.reload();
                        $('#asset_create_table').DataTable().ajax.reload();
                    })
                } else if (data.success == 0 || data.success == 2) {
                    // alert(data.message+': '+data.error_msg+'. Error code: '+data.error_code);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message + ': ' + data.error_msg + '. Error code: ' + data.error_code
                    })
                }
            } else if (data === null) {
                // alert("Unable to connect to property chain");
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to connect to property chain'
                })
            }
        }
    })

}

function updateMap(id) {
    var property_id = $('#' + id).attr('property-id');
    var property_data = $('#' + id).attr('prop-data');
    var prop_sign = $('#' + id).attr('prop-sign');
    var prop_sign_key = $('#' + id).attr('prop-sign-key');

    $.ajax({
        url: baseurl + "PropChainReport/updateChainMap",
        method: 'post',
        // data:$("#prop_chain_form").serialize(),
        data: {
            property_id: property_id,
            property_data: property_data,
            prop_sign: prop_sign,
            prop_sign_key: prop_sign_key
        },
        dataType: 'json',
        beforeSend: function () {
            loaderBlockUi('Creating New Asset. Please Wait');
        },
        success: function (data) {
            $.unblockUI();
            console.log(data);
            if (data !== null) {
                if (data.success == 1) {
                    // alert(data.message);
                    Swal.fire(
                        {
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        },
                        // function (){
                        //     location.reload();
                        // }
                    ).then(function () {
                        location.reload();
                    })
                } else if (data.success == 0) {
                    // alert(data.message+': '+data.error_msg+'. Error code: '+data.error_code);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message + ': ' + data.error_msg + '. Error code: ' + data.error_code
                    })
                }
            } else if (data === null) {
                // alert("Unable to connect to property chain");
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to connect to property chain'
                })
            }
        }
    })

}

// function getTraceMap(){
//     var gis_code = $('#gis_code').val();
//     var dag_no = $('#dag_no').val();
//     console.log(gis_code);
//     console.log(dag_no);
//     $.ajax({
//         url: baseurl + "PropChainReport/getTraceMap",
//             method:'post',
//             data:{
//                 gis_code:gis_code,
//                 plot_no:dag_no
//             },
//             dataType:'json',
//             beforeSend: function() {
//                 $('#loader').show();
//                 $("#loader").html(
//                     '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span></div><br><p>Fetching Trace Map. Please Wait....</p></div>'
//                 );
//             },
//             success:function(data){
//                 $('#loader').hide();
//                 console.log(data.url);
//                 if(data.status ==1){
//                     // $('#trace_map_frame').show();
//                     var mapData=data.data
//                     var state=data.state
//                     // var url = data.url;
//                     // $('#trace_map_frame').attr('src', baseurl+'PropChainReport/test');
//                     // window.frames["trace_map_frame"].location = baseurl+'PropChainReport/test'
//                     // alert(data.msg);
//                     // window.open(baseurl+'PropChainReport/test');

//                     Swal.fire({
//                         icon:'success',
//                         title:'Success',
//                         text: data.msg
//                     })
//                 }else{
//                     $('#trace_map_frame').hide();

//                     // alert(data.msg);
//                     Swal.fire({
//                         icon:'error',
//                         title:'Error',
//                         text: data.msg
//                     })
//                 }
//             }
//        })
// }

// function getTraceMap() {
//     var gis_code = $('#gis_code').val();
//     var dag_no = $('#dag_no').val();
//     console.log(gis_code);
//     console.log(dag_no);

//     $.ajax({
//         url: baseurl + "PropChainReport/getTraceMap",
//         method: 'post',
//         data: {
//             gis_code: gis_code,
//             plot_no: dag_no
//         },
//         dataType: 'json',
//         beforeSend: function () {
//             loaderBlockUi('Checking Map. Please Wait');
//         },
//         success: function (data) {
//             // $('#loader').hide();
//             $.unblockUI();
//             console.log(data.url);
//             if (data.status == 1) {
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Success',
//                     text: data.msg
//                 }).then(function () {
//                     $.ajax({
//                         url: baseurl + "PropChainReport/test",
//                         method: 'post',
//                         dataType: 'html',
//                         data: {
//                             'mapData': data.data,
//                             'state': data.state
//                         }, beforeSend: function () {
//                             loaderBlockUi('Redirecting to Bhunaksha site. Please Wait');
//                         },
//                         success: function (data) {
//                             // console.log(data);
//                             // $('#loader').hide();
//                             $.unblockUI();
//                             var popup = window.open();
//                             popup.document.write(data);

//                             //    $('#prop_chain_report').hide();
//                             //    $('#show_map_bhunaksha').show();
//                             //    $('#show_map_bhunaksha').empty().html(data);

//                             // writeConsole(data);
//                             // function writeConsole(content) {
//                             //     top.consoleRef=window.open('','width=350,height=250');
//                             //     top.consoleRef.document.write(content)
//                             //     top.consoleRef.document.close()
//                             // }

//                         }
//                     })

//                 })
//             } else {
//                 $('#trace_map_frame').hide();

//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Error',
//                     text: data.msg
//                 })
//             }
//         }
//     })
// }

function getTraceMap() {
    var gis_code = $('#gis_code').val();
    var dag_no = $('#dag_no').val();
    var property_id = $('#view_trace_map').attr("property-id");
    var trans_data = $('#view_trace_map').attr('trans-data');
    var certmnemonic = $('#view_trace_map').attr("certmnemonic");
    var reference_id = $('#view_trace_map').attr("reference-id");
    console.log(trans_data);
    console.log(dag_no);

    $.ajax({
        url: baseurl + "PropChainReport/getTraceMap",
        method: 'post',
        data: {
            gis_code: gis_code,
            plot_no: dag_no,
            property_id: property_id,
            trans_data: trans_data,
            certmnemonic: certmnemonic,
            reference_id: reference_id
        },
        dataType: 'json',
        beforeSend: function () {
            loaderBlockUi('Checking Map. Please Wait');
        },
        success: function (data) {
            // $('#loader').hide();
            $.unblockUI();
            console.log(data.url);
            if (data.status == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg
                }).then(function () {
                    $.ajax({
                        url: baseurl + "PropChainReport/test",
                        method: 'post',
                        dataType: 'html',
                        data: {
                            'mapData': data.data,
                            'state': data.state
                        }, beforeSend: function () {
                            loaderBlockUi('Redirecting to Bhunaksha site. Please Wait');
                        },
                        success: function (data) {
                            // console.log(data);
                            // $('#loader').hide();
                            $.unblockUI();
                            var popup = window.open();
                            popup.document.write(data);

                            //    $('#prop_chain_report').hide();
                            //    $('#show_map_bhunaksha').show();
                            //    $('#show_map_bhunaksha').empty().html(data);

                            // writeConsole(data);
                            // function writeConsole(content) {
                            //     top.consoleRef=window.open('','width=350,height=250');
                            //     top.consoleRef.document.write(content)
                            //     top.consoleRef.document.close()
                            // }

                        }
                    })

                })
            } else {
                $('#trace_map_frame').hide();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg
                })
            }
        }
    })
}

function showChainProperty(id) {

    var dist_code = $('#' + id).attr('dist');
    var subdiv_code = $('#' + id).attr('subdiv');
    var circle_code = $('#' + id).attr('cir');
    var mouza_code = $('#' + id).attr('mouza');
    var lot_no = $('#' + id).attr('lot');
    var vill_code = $('#' + id).attr('vill');
    var patta_type_code = $('#' + id).attr('patta-type-code');
    var patta_no = $('#' + id).attr('patta-no');
    var ulpin = $('#' + id).attr('ulpin');
    var dag_no = $('#' + id).attr('dag-no');

    $.ajax({
        url: baseurl + "PropChainReport/getPropChainData",
        method: 'post',
        // data:$("#prop_chain_form").serialize(),
        data: {
            dist_code: dist_code,
            subdiv_code: subdiv_code,
            circle_code: circle_code,
            mouza_code: mouza_code,
            lot_no: lot_no,
            vill_code: vill_code,
            patta_code: patta_no,
            patta_type_code: patta_type_code,
            dag_no: dag_no,
            ulpin: ulpin
        },
        beforeSend: function () {
            loaderBlockUi('Fetching data from property chain');
        },
        success: function (d) {
            $('#loader').hide();
            $.unblockUI();
            // console.log(d.result);
            if (d === 'null' || d === null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Unable to connect to Property Chain"
                })
            } else {
                var object = JSON.parse(d);
                console.log(object);
                if (object.result === 0) {
                    $('.error_span_chain').css('background-color', 'red');
                    $('.error_span_chain').css('color', 'white');
                    $('.error_span_chain').html(object.error_msg);
                    // alert(object.error_msg)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: object.error_msg
                    })
                } else if (object.result === 1) {
                    var property_data = object.property_data
                    var transaction_data = object.transaction_data
                    var property_id = object.property_id
                    var ulpin_flag = object.ulpin_flag
                    console.log(property_id);
                    // window.location.replace(baseurl + "PropChainReport/generatePropertyChain/" + encodeURI(property_data)+"/"+"0")
                    $.ajax({
                        url: baseurl + "PropChainReport/generatePropertyChain",
                        method: 'post',
                        data: {
                            property_id: property_id,
                            property_data: property_data,
                            transaction_data: transaction_data,
                            ulpin_flag: ulpin_flag
                        },
                        dataType: 'html',
                        success: function (data3) {
                            $('#show-prop-report').empty().html(data3);
                            $('#back_btn').show();
                        }
                    });
                } else {
                    // alert("Unable to connect to property chain");

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Unable to connect to property chain"
                    })
                }
            }

        }
    });
}




function propChainModal(case_no, dist_code, subdiv_code, circle_code, mouza_code, lot_no, vill_code) {

    $('#myModal .modal-content').empty().html(
        '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
    $.ajax({
        url: baseurl + "PropChainReport/getCaseData",
        data: {
            case_no: case_no,
            vill_code: vill_code,
        },
        type: 'post',
        success: function (data1) {
            console.log(data1)
            var obj = JSON.parse(data1)
            var dag_no = obj.dag_no;
            var patta_code = obj.patta_no;
            $.ajax({
                url: baseurl + "PropChainReport/getPropChainData",
                type: 'post',
                data: {
                    case_no: case_no,
                    dist_code: dist_code,
                    subdiv_code: subdiv_code,
                    circle_code: circle_code,
                    mouza_code: mouza_code,
                    lot_no: lot_no,
                    vill_code: vill_code,
                    patta_code: patta_code,
                    dag_no: dag_no,
                },
                success: function (data2) {
                    var object = JSON.parse(data2);
                    console.log(object);
                    if (object.result === 0) {
                        console.log('abc');
                        $('#myModal .modal-content').css('background-color', 'red');
                        $('#myModal .modal-content').css('color', 'white');
                        $('#myModal .modal-content').html('<h1 class="text-center">' + object.error_msg + '</h1>');
                        $('#myModal').modal();
                    } else if (object.result === 1) {
                        var property_data = object.property_data
                        var transaction_data = object.transaction_data
                        console.log(property_data);
                        $.ajax({
                            url: baseurl + "PropChainReport/generatePropertyChain",
                            // dataType: 'html',
                            method: 'post',
                            data: {
                                property_data: property_data,
                                transaction_data: transaction_data

                            },
                            success: function (data3) {
                                $('#myModal .modal-content').html(data3);
                                $('#myModal').modal();
                            }
                        });
                    } else {
                        $('#myModal .modal-content').css('background-color', 'red');
                        $('#myModal .modal-content').css('color', 'white');
                        $('#myModal .modal-content').html('<h1 class="text-center"><i class="fa fa-warning"></i>Unable to connect to property chain</h1>');
                        $('#myModal').modal();
                    }

                }
            });
        }
    })

    propChainHideModal();
}

function propChainHideModal() {
    $('#myModal').on('hidden.bs.modal', function () {
        $('body').css('padding-right', 0);
        $('.modal-content').css('background-color', 'white');
        $('.modal-content').css('color', 'black');
    })
}

function msgPopUp() {
    var ulpin_flag = $('#ulpinFlag').val();
    var compare_flag = $('#compareFlag').val();
    var ulpin_msg = $('#ulpinMsg').val();
    var compare_msg = $('#compareMsg').val();
    ///////////edit for bhu area cmp ////////////
    var bhu_flag = $("#bhuCompareFlag").val();
    var bhu_msg = $("#bhuCompareMsg").val();
    var icon3 = 'warning';
    console.log(bhu_msg);
    console.log(compare_msg);
    console.log("MB01:----PASS1----");

    if (bhu_flag == 1)
        icon3 = success;
    // console.log(bhu_flag)
    ////////////////////////////////////////////
    var icon1 = 'warning';
    var icon2 = 'warning';

    if (compare_flag === 'Y')
        icon2 = 'success';
    else if (compare_flag === 'N')
        icon2 = 'error';
    else if (compare_flag === 'NE')
        icon2 = 'warning';

    if (ulpin_flag == 1)
        icon1 = 'success';
    else if (ulpin_flag == 0) {
        icon1 = 'error';
        icon2 = 'error';
        icon3 = 'error';

        compare_msg = 'Cannot add property to property chain';
        bhu_msg = 'Unable to fetch bhunaksha data'
    }
    else
        icon1 = 'warning';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Swal.fire({
        icon: icon1,
        // title: 'Error',
        text: ' ' + ulpin_msg,
        showConfirmButton: false,
        // background: '#7fb9b9',
        // button: false,
    }).then(function () {
        Swal.fire({
            icon: icon2,
            // title: 'Error',
            html: ' ' + compare_msg,
            showConfirmButton: false,
            // background: '#7fb9b9',
            // button: false,
        }).then(function () { //edit for bhu area cmp
            Swal.fire({
                icon: icon3,
                text: ' ' + bhu_msg,
                showConfirmButton: false,
                // background: '#7fb9b9',
            })
        })
    })
}

function onchangeDag() {
    console.log('abc');
    enable('prop_chain_submit');
    var dist_code = $('#LmMutationSelectDistrict').val();
    var subdiv_code = $('#subdiv_code').val();
    var circle_code = $('#circle_code').val();
    var mouza_code = $('#mouza_code').val();
    var lot_no = $('#lot_no').val();
    var vill_code = $('#vill_code').val();
    var patta_code = $('#select_patta_type_chain').val();
    var dag_no = $('#selectlw').val();

    getPattaNo(dist_code, subdiv_code, circle_code, mouza_code, lot_no, vill_code, patta_code, dag_no);
}

function getPattaNo(dist_code, subdiv_code, circle_code, mouza_code, lot_no, vill_code, patta_code, dag_no) {
    $.ajax({
        url: baseurl + "PropChainReport/getPattaNo",
        data: {
            dist_code: dist_code,
            subdiv_code: subdiv_code,
            circle_code: circle_code,
            mouza_code: mouza_code,
            lot_no: lot_no,
            vill_code: vill_code,
            patta_code: patta_code,
            dag_no: dag_no
        },
        type: 'post',
        success: function (data) {
            var obj = JSON.parse(data);
            console.log(obj.patta_no);

            document.getElementById("patta_no").value = obj.patta_no;
        }
    })
}

function pushRorData() {
    $.ajax({
        url: baseurl + "PropChainReport/push_prop_chain_asset_bulk/ror_push",
        method: 'get',
        beforeSend: function () {
            loaderBlockUi('Pushing ROR data in bulk. Please Wait.');
        },
        success: function (data) {
            $.unblockUI();
            Swal.fire({
                icon: 'warning',
                title: 'Message',
                html: '<p>' + data + '</p>'
            })

        }
    })
}

function pushMapData() {
    $.ajax({
        url: baseurl + "PropChainReport/push_prop_chain_asset_bulk/map_push",
        method: 'get',
        beforeSend: function () {
            loaderBlockUi('Pushing MAP data in bulk. Please Wait.');
        },
        success: function (data) {
            $.unblockUI();
            Swal.fire({
                icon: 'warning',
                title: 'Message',
                html: '<p>' + data + '</p>'
            })

        }
    })
}