<script>
    var modal = document.getElementById("revivalModal");
    // Get the button that opens the modal_vgr
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal_vgr
    var span = document.getElementsByClassName("close-modal")[0];

    span.onclick = function() 
    {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal_vgr, close it
    window.onclick = function(event) 
    {
        if (event.target == modal) 
        {
            modal.style.display = "none";
        }
    }

    function caseRevivalList(case_no, service_code)
    {
        var postData = {
            'case_no' : case_no,
            'service_code' : service_code,
        };
   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementCommon/caseRevivalList',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    //*****open modal and display radio button to choose option */
                    modal.style.display = "block";

                    var data = '';

                    for(i=0; i < arr.list.length; i++)
                    {
                        data += "<div class='col-9'><input type='radio' onclick=\"appendRemarkText('"+arr.list[i].CODE+"')\" name='revial_reason' value='"+arr.list[i].CODE+"'> &nbsp; <label>"+arr.list[i].NAME+"</label></div>"
                    }

                    $('#divContent').html('<h5>'+
                                                // '<u>'+
                                                    'Select Revival Reason '+
                                                    '<br>'+
                                                    '<small style="color:red; font-weight:bold;">('+arr.case_no+')</small>'+
                                                // '</u>'+
                                            '</h5><hr>'+
                                            '<div class="row justify-content-center">'+
                                                ''+data+''+
                                            '</div>'+
                                            '<br>'+
                                            '<div id="remarkText"></div>'+
                                            '<br>'+
                                            '<div class="row">'+
                                                '<button type="button" onclick="caseRevival(\''+arr.case_no+'\', \''+arr.service_code+'\')" class="col-12 btn btn-primary btn-sm">Flag for Revival</button>'+
                                            '</div><br>');



                }
            }
        });
   
    }
</script>

<script>
    function appendRemarkText(reason_code)
    {
        var remarkText = ''; 

        if(reason_code == 1)
        {
            remarkText = "<textarea class='form-control p-2' name='revivalRemarkText' id='revivalRemarkText' rows='4' placeholder='Please enter remark'></textarea>";
        }

        $('#remarkText').html(remarkText);

    }
</script>

<script>
    function caseRevival(case_no, service_code)
    {
        if($('input[name=revial_reason]:checked').length <= 0)
        {
            showErrorMessage('Please select reason for revival!');
            return false;
        }
        if(case_no == '')
        {
            showErrorMessage('Case no error');
            return false;
        }

        var reason_code = $('input[name="revial_reason"]:checked').val();

        var revivalRemarkText = '';

        if(reason_code == 1)
        {
            revivalRemarkText = $('#revivalRemarkText').val();

            if(revivalRemarkText == '')
            {
                showErrorMessage('Please enter remark...');
                return false;
            }
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to flag this case for revival?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                var postData = {
                    'case_no' : case_no,
                    'service_code' : service_code,
                    'reason_code' : reason_code,
                    'revivalRemarkText' : revivalRemarkText
                };
        
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });

                $.ajax({
                    url: baseurl+'SettlementCommon/caseRevival',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        $.unblockUI();
                        arr = JSON.parse(data);
                        if(arr.responseType != 2)
                        {
                            showErrorMessage(arr.msg);
                        }
                        else
                        {
                            //*****open modal and display radio button to choose option */
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success ml-2',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            })

                            swalWithBootstrapButtons.fire({
                                title: arr.msg,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'OK',
                                // cancelButtonText: 'No, cancel!',
                                reverseButtons: true
                            }).then((result) => {
                                window.location.reload();
                            })

                        }
                    }
                });
            }
            else
            {
                swalWithBootstrapButtons.fire(
                    'Cancelled !!',
                )
            }
        })

    }
</script>
