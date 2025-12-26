// this is the first registration of the application

function getIsApplicant(application_no){
    var postData = {
        'application_no': application_no
    };


    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getIsApplicant',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2){
                Swal.fire({
                        text: arr.msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                })
                return false;
            }
            else{
                var tr = '';
                tr = '<tr>'+
                        '<th>Name</th>'+
                        '<td class="warning-color">'+arr.data.pdar_name+' | '+arr.data.eng_pdar_name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Guardian</th>'+
                        '<td class="warning-color">'+arr.data.pdar_guardian+' | '+arr.data.eng_pdar_guardian+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Relation</th>'+
                        '<td class="warning-color">'+arr.data.guar_rel_name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Gender</th>'+
                        '<td class="warning-color">'+arr.data.gender_name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>DOB</th>'+
                        '<td class="warning-color">'+arr.data.dob+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Marital Status</th>'+
                        '<td class="warning-color">'+arr.data.marital_status_name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Mobile</th>'+
                        '<td class="warning-color">'+arr.data.pdar_mobile+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Permanent address</th>'+
                        '<td class="warning-color">'+arr.data.pdar_add1+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>Present address</th>'+
                        '<td class="warning-color">'+arr.data.pdar_add2+'</td>'+
                    '</tr>';

                $('#mainApplicant').html('<table class="table">'+tr+'</table>');
            }
        }
    });
}