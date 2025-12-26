<!---// Add land detail modal --->
<style type="text/css">
	html {
  font-size: 16px;
  background: #edeff0;
  font-family: "Open Sans", sans-serif;
}

h1 {
  font-size: 20px;
  margin-bottom: 20px;
  color: #fff;
}

.wrap {
  width: 500px;
  margin: auto;
  /*position: absolute;*/
/*  top: 50%;
  left: 50%;*/
  /*transform: translate(-50%, -50%);*/
  border-radius: 4px;
  background-color: #2e4261;
  box-shadow: 0 1px 2px 0 #c9ced1;
  padding: 1.25rem;
  margin-bottom: 1.25rem;
}

.file {
  position: relative;
  max-width: 22.5rem;
  font-size: 1.0625rem;
  font-weight: 600;
}
.file__input21, .file__value21 {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 3px;
  margin-bottom: 0.875rem;
  color: rgba(255, 255, 255, 0.3);
  padding: 0.9375rem 1.0625rem;
}
.file__input21--file {
  position: absolute;
  opacity: 0;
}
.file__input21--label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0;
  cursor: pointer;
}
.file__input21--label:after {
  content: attr(data-text-btn);
  border-radius: 3px;
  background-color: #536480;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.18);
  padding: 0.9375rem 1.0625rem;
  margin: -0.9375rem -1.0625rem;
  color: white;
  cursor: pointer;
}
.file__value21 {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: rgba(255, 255, 255, 0.6);
}
.file__value21:hover:after {
  color: white;
}
.file__value21:after {
  content: "X";
  cursor: pointer;
}
.file__value21:after:hover {
  color: white;
}
.file__remove {
  display: block;
  width: 20px;
  height: 20px;
  border: 1px solid #000;
}
/*.card {
  margin-top: 100px;
}
.btn-upload {
    padding: 10px 20px;
    margin-left: 10px;
}
.upload-input-group {
    margin-bottom: 10px;
}
.input-group>.custom-select:not(:last-child), .input-group>.form-control:last-child) {
  height: 45px;
}*/

</style>
<button type="button" id="multipleUpload" class="btn btn-info btn-danger">Upload more documents</button>
<table id="otherFiles" class="table table-bordered" style="display:none">
<tr>
<th>File Name : </th>
<th>Download </th>
<th>Action</th>
</tr>
</table>
<div class="modal" id="multipleFileUploadModal" role="dialog">
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
                            <input type="text" class="form-control" id="doc_name" name="doc_name" style="width: 100%" placeholder="Enter document Name" maxlength="99">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                        <div class="form-group">

                            <input type="file" id="mul_file" name="mul_file" class="file__input" accept="image/png, image/jpeg, application/pdf">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                        <button type="button" class="btn btn-success" id="mulFileUpload">Upload</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).on('click', '#multipleUpload', function(){
  $("#multipleFileUploadModal").modal('show');
  $('#mul_file').val('');
  $('#doc_name').val('');
});
$(document).on('click', '#multipleUploadClose', function(){
  $('#multipleFileUploadModal').modal('hide');
});
$("#mulFileUpload").on('click',function(argument){
    var uploadedFile = new FormData();
    uploadedFile.append("mul_file", mul_file.files[0]);
    uploadedFile.append("doc_name", $("#doc_name").val());
    // Get the full URL
    const url = new URL(window.location.href);

    // Get the case_no parameter
    const caseNo = url.searchParams.get("case_no");

    uploadedFile.append("application_id", caseNo);





    if (!baseurl.includes("index.php")) {
        if (!baseurl.endsWith("/")) {
            baseurl += "/";
        }
        baseurl += "index.php/";
    }


    jQuery.ajax({
        url: baseurl + "MultipleFileUploadMB3/multipleFileSave",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: "json",
        error: (error) => {
            alert("Something has gone wrong. Kindly Retry1");
        },
        data: uploadedFile,
        success: function(data) {
            if (data.responseType == 1) {
                data.validation.forEach(function(validation) {
                    var errMsg = "#" + validation.field + "Err";
                    $(errMsg).text("⚠️ " + validation.message);
                });
            }else if(data.responseType == 2){
                alert("Successfully Uploaded.");
                $('#multipleFileUploadModal').modal('hide');
                $('#otherFiles').show();
                let randomPrefix = generateRandomString(5);
                let randomSuffix = generateRandomString(5);
                let file_link='<?php echo base_url() ?>'+"index.php/MultipleFileUploadMB3/viewfile/"+ randomPrefix + data.doc_id + randomSuffix;
                var tr='<tr id="tri'+ data.doc_id +'"><td>'
                    +data.doc_file
                    +'</td><td><a href='+ file_link +' target="_blank">VIEW FILE'
                    +'</a></td><td><a href="#" id="removeOtherFile"'
                    +' class="btn btn-danger btn-xs" onclick="deleteFile('+data.doc_id+')">Remove File</a></td></tr>';

                $('#otherFiles').append(tr);
            }
            else{
                alert("Something has gone wrong. Kindly Retry");
            }
        },
    });
});
function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}
function deleteFile(doc_id){
  var trId = doc_id;
   $.ajax({
    type: 'post',
    url: baseurl + "MultipleFileUploadMB3/deleteFile",
    data: {doc_id:doc_id},
    dataType: 'JSON',
    success: function(data) {
      if(data.responseType == 2) {
        alert(data.message);
      }else{
        alert(data.message);
        $("#tri" + data.doc_id).remove();
      }
    },
    error: (error) => {
      alert("SOMETHING WENT WRONG !!!!");
    },
  });
}
</script>

