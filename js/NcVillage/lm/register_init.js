// this is the first registration of the application
function registrationInit(application_no)
{
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
        url: baseurl+'NcLmKhaslandController/registration',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2)
            {
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
            else
            {
                window.location.href = baseurl+"NcLmKhaslandController/firstProceeding?an="+application_no;
            }
            //*****redirect to the lm 1st proceeding page */
            // NcVillageService/NcKhas/NcKhaslandFirstProceedingView
        }
    });
}