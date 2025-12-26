/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var baseurl = baseUrl;

if (!baseurl.includes("index.php"))
{
    if (!baseurl.endsWith("/"))
    {
        baseurl += "/";
    }
    baseurl = baseurl + "index.php/";
}

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



    //////////////// Reject MB2 Cases by Masud //////////////////////

    // Success Message
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
        // location.reload();
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
            // title: "Error!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }
    // Swal Message end


    $('#close_reject_modal_new').click(function ()
    {

        var case_no = $('#dharitreeCaseNo').val();
        var id = $('#closeRejectModalId').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'RejectMb2NewController/checkIfRejectedResonInserted',
            type: "POST",
            data: {'case_no':case_no},
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                $('#rejectNewModal').modal('hide');

                if(arr.responseType == 0)
                {
                    //******no data found */
                    $('#report_status_yes'+id).prop('checked', true);
                }
                else
                {
                    //******data found */
                    $('#report_status_no'+id).prop('checked', true);
                }
            }
        });

    });



    $('#close_reject_modal_new').click(function () {
        $('#rejectNewModal').modal('hide');
    });
    $("#checkedAll").click(function(){
        if(this.checked){
            $('.reject_option_new').each(function(){
                this.checked = true;
                $('.reject_option').prop('checked', true);
            })
        }else{
            $('.reject_option_new').each(function(){
                this.checked = false;
                $('.reject_option_new').prop('checked', false);
            })
        }
    });


    $('#rejectformNew').submit(function (e) {
        e.preventDefault();
        $.blockUI({
            message: $('#displayBoxNew'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });

        var remark    = '';
        var remarkOld = $('#reject_remark_old').val();
        var remarkNew = $('#reject_remarkNew').val();

        if (remarkNew)
        {
            remark = remarkNew;
        }
        else if (remarkOld)
        {
            remark = remarkOld;
        }
        else
        {
            alert("No remark provided.");
        }

        var service_code = $('#service_code').val();
        var case_no = $('#dharitreeCaseNo').val();
        var reject_code = $('#reject_option_new').val();
        var ref_no = $('#ref_no').val();
        var nocase = $('#nocase').val();
        var serialId = $("#closeRejectModalId").val(); //$('input').attr('name')

        var url=baseurl+'RejectMb2NewController/postRejectedReason';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $("#rejectformNew").serialize()+
            "&service_code=" + service_code+
            "&remark=" + remark +
            "&case_no=" + case_no +
            "&serialId=" + serialId,
            success: function(data){
                $.unblockUI();
                if(data.success === false){
                    $('.errorMsg').html(data.message);
                }
                if(data.success === true){
                    showSuccessMessage(data.message);
                    $('#rejectNewModal').modal('hide');
                    $('#remarks'+data.serial_id).show();
                    $('#remarks'+data.serial_id).val(data.remark_list);
                }

            },error: function (error) {
                $.unblockUI();
                showWarningMessage(data.message);
                // alert('Something went wrong.');
                // $.unblockUI();
            }
        });
    });


    // Submit rejected by SDO/ADC/DC
    $('#rejectDirectFormNew').submit(function (e) {
        afterSubmitSanitization();

        e.preventDefault();
        $.blockUI({
            message: $('#displayBoxNew'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });

        var remark    = '';
        var remarkOld = $('#reject_remark').val();
        var remarkNew = $('#reject_remarkNew').val();

        if (remarkNew)
        {
            remark = remarkNew;
        }
        else if (remarkOld)
        {
            remark = remarkOld;
        }
        else
        {
            alert("No remark provided.");
        }
        var service_code = $('#service_code').val();
        var case_no = $('#dharitreeCaseNo').val();
        var reject_code = $('#reject_direct_option_new').val();
        var ref_no = $('#ref_no').val();
        var nocase = $('#nocase').val();
        var serialId = $("#closeRejectModalId").val(); //$('input').attr('name')

        $('.errorMsg').html('');
        var newBaseUrl = baseurl;

        if (!baseurl.includes("index.php"))
        {
            if (!baseurl.endsWith("/"))
            {
                baseurl += "/";
            }
            newBaseUrl = baseurl + "index.php/";
        }
        var url=newBaseUrl+'RejectMb2NewController/postRejectedDirectReason';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $("#rejectDirectFormNew").serialize()+
            "&service_code=" + service_code+
            "&remark=" + remark +
            "&case_no=" + case_no +
            "&serialId=" + serialId,
            success: function(data)
            {
                $.unblockUI();
                if(data.success === false){
                    $('.errorMsg').html(data.message);
                }
                if(data.success === true){
                    showSuccessMessage(data.message);
                    $('#rejectDirectedModal').modal('hide');
                    $('.rezaButt').hide();
                    $('#remarks'+data.serial_id).show();
                    $('#remarks'+data.serial_id).val(data.remark_list);

                    if($.trim(data.user_desig_code) == 'CO')
                    {
                        window.location.href = newBaseUrl+'home';
                    }
                    else
                    {
                        location.reload();
                    }
                }

            }
            ,error: function (error) {
                $.unblockUI();
                showWarningMessage(data.message);
            }
        });
    });


});



// for rejected  hard code  mgs
// function showNewDirectRejectModalMb2(case_no,service_code){
//
//     showErrorMessage("Reject option Will be available soon.. !!!");
//
// }



// application rejected by SDO/ADC/DC Directly without Send to SDLAC
function showNewDirectRejectModalMb2(case_no,service_code){

    $.blockUI({
        message: $('#displayBoxNew'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    var newBaseUrl = baseurl;

    if (!baseurl.includes("index.php"))
    {
        if (!baseurl.endsWith("/"))
        {
            baseurl += "/";
        }
        newBaseUrl = baseurl + "index.php/";
    }
    $('#rejectDirectedModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: newBaseUrl+'RejectMb2NewController/getRejectModal',
        type: 'post',
        data: {service_code: service_code,case_no:case_no},
        success: function(data){
            arr = JSON.parse(data);
            // console.log(arr);
            $('#rejectDirectFormNew').trigger('reset');
            var button = '';
            var table = '';
            var headFlag = 0;
            var list=[];

            for(j=0; j<arr.head.length; j++) {
                var count = 0;

                for (i = 0; i < arr.data.length; i++)
                {

                    if(arr.data[i].chitha_flag != 0)
                    {
                        for (k=0; k < arr.dagsArray.length; k++)
                        {
                            var trShow = null;
                            if (arr.head[j].CODE == arr.data[i].remark_head) {
                                if (arr.data.length != 0) {

                                    var checkVal = arr.data[i].reject_code+arr.dagsArray[k].dag_no;

                                    if (($.inArray(checkVal, arr.masterArray) !== -1)){

                                        button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" ' +
                                            'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';

                                    }
                                    else
                                    {
                                        var checkVal2 = arr.data[i].reject_code;

                                        if (($.inArray(checkVal2, arr.masterArray) !== -1)){
                                            button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" ' +
                                                'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';
                                        }
                                        else
                                        {
                                            button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" class="btnChecked reject_option_new rr_reason_class_final" name="reject_code[]">';
                                        }
                                    }
                                }

                                if (count == 0) {
                                    count++;
                                    var trShow = '<tr style="font-size:16px">' +
                                        '<td colspan="3" style="font-weight:bold;color:#ff681d">' + arr.data[i].head + '</td>' +
                                        '</tr>';
                                }
                                table +=
                                    trShow +
                                    '<tr style="font-size:16px">' +
                                    '<td align="center">' + button + '</td>' +
                                    '<td>' + arr.data[i].remark + ' <span class="badge"> Dag No:'+ arr.dagsArray[k].dag_no+'</span></td>' +
                                    '<td id="additionalInput'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'"></td>' +
                                    '</tr>';
                            }
                        }
                    }
                    else
                    {

                        var trShow = null;
                        if (arr.head[j].CODE == arr.data[i].remark_head) {

                            if (arr.data.length != 0) {

                                if ($.inArray(arr.data[i].reject_code, arr.lm_rejected_remark) !== -1) {
                                    button = '<input type="checkbox" onclick="additionalInput('+arr.data[i].reject_code+', '+"'"+case_no+"'"+')" id="'+ arr.data[i].reject_code +'" value="' + arr.data[i].reject_code + '" ' +
                                        'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';
                                }
                                else {
                                    button = '<input type="checkbox" onclick="additionalInput('+arr.data[i].reject_code+', '+"'"+case_no+"'"+')" id="'+ arr.data[i].reject_code +'" value="' + arr.data[i].reject_code + '" class="btnChecked reject_option_new rr_reason_class_final" name="reject_code[]">';
                                }
                            }


                            if (count == 0) {
                                count++;
                                var trShow = '<tr style="font-size:16px">' +
                                    '<td colspan="3" style="font-weight:bold;color:#ff681d">' + arr.data[i].head + '</td>' +
                                    '</tr>';
                            }
                            table +=
                                trShow +
                                '<tr style="font-size:16px">' +
                                '<td align="center">' + button + '</td>' +
                                '<td>' + arr.data[i].remark + '</td>' +
                                '<td id="additionalInput'+arr.data[i].reject_code+'"></td>' +
                                '</tr>';
                        }
                    }

                }
            }


            // console.log(list);
            $('#service_code').val(service_code);
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtmlMR').html(case_no);
            $('#reject_direct_option_new').html(table);
            $('#rejectDirectedModal').modal('show');

            //******select option sub remark append in onload */
            $('input:checkbox.rr_reason_class_final').each(function (item) {
                if(this.checked)
                {
                    var reject_code = $(this).val();


                    var spArr = reject_code.split("_");

                    var reject_key = item;
                    additionalInput(spArr[0], case_no, spArr[1]);
                }
            });

            $.unblockUI();

        },
        error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
}


$(document).on('click','#close_reject_direct_modal_new', function()
{
    $('#rejectDirectedModal').modal('hide');
});



function additionalInput(reject_code, case_no, dag_no)
{
    var postData = {
        'reject_code': reject_code,
        'case_no': case_no,
        'dag_no': dag_no,
    }

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'SettlementCommon/getAdditionalInputIfAnyCODC',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);

            if(arr.responseType == 0)
            {
                showErrorMessage(arr.msg);
                return false;
            }

            if(arr.chithaFlag != 0)
            {
                if($('#'+reject_code+'_'+dag_no).is(':checked'))
                {
                    $('#additionalInput'+reject_code+'_'+dag_no).html(arr.inputContent);
                }
                else
                {
                    $('#additionalInput'+reject_code+'_'+dag_no).html('');
                }
            }
            else
            {
                if($('#'+reject_code).is(':checked'))
                {
                    $('#additionalInput'+reject_code).html(arr.inputContent);
                }
                else
                {
                    $('#additionalInput'+reject_code).html('');
                }
            }

        }
    });

}



// application Not_Recommended by SDLAC and send to DC for final Verification
function showNewRejectModalMb2(case_no,service_code)
{

    $.blockUI({
        message: $('#displayBoxNew'),
        css: {
            border:'none',
            backgroundColor:'transparent',
        }
    });
    $('#rejectNewModal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: baseurl+'RejectMb2NewController/getRejectModal',
        type: 'post',
        data: {service_code: service_code,case_no:case_no},
        success: function(data){
            arr = JSON.parse(data);
            // console.log(arr);
            $('#rejectformNew').trigger('reset');
            var button = '';
            var table = '';
            var headFlag = 0;
            var list=[];

            for(j=0; j<arr.head.length; j++) {
                var count = 0;

                for (i = 0; i < arr.data.length; i++)
                {

                    if(arr.data[i].chitha_flag != 0)
                    {
                        for (k=0; k < arr.dagsArray.length; k++)
                        {
                            var trShow = null;
                            if (arr.head[j].CODE == arr.data[i].remark_head) {
                                if (arr.data.length != 0) {

                                    var checkVal = arr.data[i].reject_code+arr.dagsArray[k].dag_no;

                                    if (($.inArray(checkVal, arr.masterArray) !== -1)){

                                        button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" ' +
                                            'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';

                                    }
                                    else
                                    {
                                        var checkVal2 = arr.data[i].reject_code;

                                        if (($.inArray(checkVal2, arr.masterArray) !== -1)){
                                            button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" ' +
                                                'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';
                                        }
                                        else
                                        {
                                            button = '<input type="checkbox" onclick="additionalInput('+"'"+arr.data[i].reject_code+"'"+', '+"'"+case_no+"'"+', '+"'"+arr.dagsArray[k].dag_no+"'"+')" id="'+ arr.data[i].reject_code +'_'+arr.dagsArray[k].dag_no+'" value="'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'" class="btnChecked reject_option_new rr_reason_class_final" name="reject_code[]">';
                                        }
                                    }
                                }

                                if (count == 0) {
                                    count++;
                                    var trShow = '<tr style="font-size:16px">' +
                                        '<td colspan="3" style="font-weight:bold;color:#ff681d">' + arr.data[i].head + '</td>' +
                                        '</tr>';
                                }
                                table +=
                                    trShow +
                                    '<tr style="font-size:16px">' +
                                    '<td align="center">' + button + '</td>' +
                                    '<td>' + arr.data[i].remark + ' <span class="badge"> Dag No:'+ arr.dagsArray[k].dag_no+'</span></td>' +
                                    '<td id="additionalInput'+arr.data[i].reject_code+'_'+arr.dagsArray[k].dag_no+'"></td>' +
                                    '</tr>';
                            }
                        }
                    }
                    else
                    {

                        var trShow = null;
                        if (arr.head[j].CODE == arr.data[i].remark_head) {

                            if (arr.data.length != 0) {

                                if ($.inArray(arr.data[i].reject_code, arr.lm_rejected_remark) !== -1) {
                                    button = '<input type="checkbox" onclick="additionalInput('+arr.data[i].reject_code+', '+"'"+case_no+"'"+')" id="'+ arr.data[i].reject_code +'" value="' + arr.data[i].reject_code + '" ' +
                                        'class="btnChecked reject_direct_option_new rr_reason_class_final" name="reject_code[]" checked = "checked">';
                                }
                                else {
                                    button = '<input type="checkbox" onclick="additionalInput('+arr.data[i].reject_code+', '+"'"+case_no+"'"+')" id="'+ arr.data[i].reject_code +'" value="' + arr.data[i].reject_code + '" class="btnChecked reject_option_new rr_reason_class_final" name="reject_code[]">';
                                }
                            }


                            if (count == 0) {
                                count++;
                                var trShow = '<tr style="font-size:16px">' +
                                    '<td colspan="3" style="font-weight:bold;color:#ff681d">' + arr.data[i].head + '</td>' +
                                    '</tr>';
                            }
                            table +=
                                trShow +
                                '<tr style="font-size:16px">' +
                                '<td align="center">' + button + '</td>' +
                                '<td>' + arr.data[i].remark + '</td>' +
                                '<td id="additionalInput'+arr.data[i].reject_code+'"></td>' +
                                '</tr>';
                        }
                    }

                }
            }

            // console.log(list);
            $('#service_code').val(service_code);
            $('#dharitreeCaseNo').val(case_no);
            $('#caseNoHtml').html(case_no);
            $('#reject_option_new').html(table);
            $('#rejectNewModal').modal('show');

            //******select option sub remark append in onload */
            $('input:checkbox.rr_reason_class_final').each(function (item) {
                if(this.checked)
                {
                    var reject_code = $(this).val();

                    var reject_key = item;
                    additionalInput(reject_code, case_no);
                }
            });

            $.unblockUI();
        },
        error: function (error) {
            alert('Something went wrong.');
            $.unblockUI();
        }
    });
}


function afterSubmitSanitization()
{

    if($("#co_rejection_agree").length != 0)
    {
        $('#co_rejection_agree').hide();
    }

    if($("#co_rejection_disagree").length != 0)
    {
        $('#co_rejection_disagree').hide();
    }

    if($("#frwrd_dc_btn").length != 0)
    {
        $('#frwrd_dc_btn').hide();
    }

    if($("#lm_revert_btn").length != 0)
    {
        $('#lm_revert_btn').hide();
    }

    if($("input[name=order_type]").length != 0)
    {
        $('input[name=order_type]').hide();
    }

    if($("#submit_reject_direct_modal_new").length != 0)
    {
        $("#submit_reject_direct_modal_new").hide();
    }

    if($("#close_reject_direct_modal_new").length != 0)
    {
        $("#close_reject_direct_modal_new").hide();
    }

    if($("#reject_button_direct").length != 0)
    {
        $("#reject_button_direct").hide();
    }

    if($("#disagreeWithLm").length != 0)
    {
        $("#disagreeWithLm").hide();
    }

}



