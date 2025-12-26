
<div class="modal" id="noticeDocFileUploadModal" role="dialog">
    <div class="modal-dialog" style="max-width: 80%;">
        <div class="modal-content" style="border: none">
            <div class="modal-header" style="color:#fff; background-color:#2196F3; font-weight: bold; border: none">Upload other related documents
                <button type="button" class="btn btn-sm" id="multipleUploadClose" style="background-color: white; color: black">Close</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-sx-10">
                        <div class="form-group">
                            <label>Document Name</label>
                        </div>
                    </div><div class="col-lg-3 col-md-3 col-sm-4 col-sx-10">
                        <div class="form-group">
                            <input type="text" class="form-control" required id="doc_name" name="doc_name" style="width: 100%" placeholder="Enter document Name" maxlength="99">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                        <div class="form-group">

                            <input type="file" id="mul_file" required name="mul_file" class="file__input" accept="image/png, image/jpeg, application/pdf">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                        <button type="button" class="btn btn-success" id="docFileUpload">Upload</button>
                        <input type="hidden" name="application_id" id="application_id" value="<?=$case_no?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

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
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    $(document).ready(function(){
      $('#noticeDocFileUploadModal').modal('show');
      $('#mul_file').val('');
      $('#doc_name').val('');
    });

    $("#multipleUploadClose").on('click', function(){
      $('#noticeDocFileUploadModal').modal('hide');
    });

    function generateRandomString(length) {
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      let result = '';
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      return result;
    }

    $("#docFileUpload").on('click',function(argument){
      var uploadedFile = new FormData();
      uploadedFile.append("mul_file", mul_file.files[0]);
      uploadedFile.append("doc_name", $("#doc_name").val());
      uploadedFile.append("application_id", $("#application_id").val());

      $.ajax({
        url: baseurl + "MultipleFileUploadMB3/multipleFileSave",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: "json",
        error: (error) => {
          showErrorMessage("Something has gone wrong. Kindly Retry1");
        },
        data: uploadedFile,
        success: function(data) {
          if (data.responseType == 1) {
            data.validation.forEach(function(validation) {
              var errMsg = "#" + validation.field + "Err";
              $(errMsg).text("⚠️ " + validation.message);
            });
          } 
          else if(data.responseType == 2)
          {
            Swal.fire({
                backdrop:true,
                allowOutsideClick: false,
                text: 'The file has been successfully updated. Click the "View" button to access the file and proceed to the LRA tab.',
                confirmButtonText: 'OK',
                customClass: {
                  actions: 'my-actions',
                  confirmButton: 'order-2',
                }
              }).then((result) => {
              if (result.isConfirmed) {
                $('#noticeDocFileUploadModal').modal('hide');
                location.reload();
              }
            });
          }
          else{
            showErrorMessage("Something has gone wrong. Kindly Retry");
          }
        },
      });
    });

</script>

