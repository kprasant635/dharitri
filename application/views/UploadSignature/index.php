<div class="container bg-white shadow p-5">
    <h5 class="bg-warning p-2 text-white text-center">Upload Signature</h5>

    
    <div class="row justify-content-center mt-5">
        <div class="mb-3">
            <span style="width: 500; height:200;" >
                <?php
                    echo 'Previously upload signature - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    if($sign != false){
                        echo $sign;
                    }else{
                        echo '<span class="alert-danger p-1">Signature not uploaded yet!</span>';
                    }
                ?>
            </span>
        </div>


        <p class="alert-warning">
            * Note - Max file size 100KB;<br>
            * Dimonsion - 500*200<br>
            * Format allowed - .jpg/.jpeg/.png
        </p>

        <div class="col-6">
            <form id="signature_form" enctype="multipart/form-data">
                <input type="file" name="signature_file" class="form-control">
                <button type="submit" class="btn btn-success btn-sm mt-4 col-12">Upload and Review</button>
            </form>
        </div>
    </div>

</div>


<div class="modal" role="dialog" id="previewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Preview Signature</h5>
            </div>
            <input type="hidden" id="image_data">

            <div class="modal-body" align="" id="preview_sig">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="previewModalYes">Submit</button>
                <button type="button" class="btn btn-primary"   id="previewModalNo">Cancel</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
</script>
<script>
    $('#signature_form').submit(function (e) {
        e.preventDefault();
        if(!confirm("Are you sure you want to upload your signature?"))
        {
            return false;
        }

        var formData = new FormData($('#signature_form')[0]);
   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'UploadSignatureController/uploadSignatureReview',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            // dataType: 'json',
            success: function (data) {
                arr = JSON.parse(data);

               $.unblockUI();
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
                    }).then((result) => {
                        if (result.isConfirmed) {
                               window.location.reload();
                        }
                    })
                    return false;
                }
                else
                {
                    $('#previewModal').modal('show');
                    $('#preview_sig').html(arr.content);
                    $('#image_data').val(arr.image_data);

                }

            },
            error: function (error) {
                $.unblockUI();
                console.log(error);
                alert("Something went wrong");
            }

        })

    });

    $(document).on('click','#previewModalYes',function ()
    {
        var image_data = $('#image_data').val();
        $('#previewModal').modal('hide');

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'UploadSignatureController/saveSignature',
            type: 'POST',
            data: {'image_data': image_data},
            success: function (data) {
                $.unblockUI();
               
                arr = JSON.parse(data);
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }
                else
                {
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                               window.location.reload();
                        }
                    })

                }

            },
            error: function (error) {
                $.unblockUI();
                console.log(error);
                alert("Something went wrong");
            }

        })

    });


    $(document).on('click','#previewModalNo',function ()
    {
        $('#previewModal').modal('hide');
    });
</script>