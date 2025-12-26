<form role="form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group">
            <div class="col-lg-2">
                <label>File Upload</label>
            </div>
            <div class="col-lg-5">
                <input type="text" name="doc_name" id="doc_name" class="form-control"
                placeholder="Document Name">
                <input type="hidden" name="application_no" id="application_no" class="form-control"
                placeholder="<?=$_GET['app']?>">
                <input type="hidden" name="service_name" id="service_name" class="form-control"
                value="DHARITREE_MB2">
            </div>
            <div class="col-lg-5">
                <input type="file" id="generic_upload_file" name="generic_upload_file" class="form-control" accept="image/png, image/jpeg, application/pdf">
            </div>    
            <div class="col-lg-4">
                <button type="button" id="uploadGenericFile" class="btn btn-sm btn-danger">Upload</button>
            </div>
        </div>

        <div class="form-group">

            <table id="otherFiles" class="table table-bordered">
                <thead>
                    <tr>
                        <th>File Name : </th>
                        <th>View</th>
                    </tr>
                </thead>
                <!-- <tbody>
                    <tr>
                        <th>Document Name</th>
                        <th>
                            <a href="#" id="viewFile" class="btn btn-danger btn-xs" 
                            onclick="viewFile(data.docId)">View File</a></th>
                    </tr>

                    $('#otherFiles').show();
                    var tr='<tr id="tri'+data.docId+'"><td>'
                        + 'File Name'
                        +'</td><td><a href="#" id="viewFile"'
                        +' class="btn btn-danger btn-xs" onclick="viewFile('+"'"+data.docId+"'"+')">View File</a></td></tr>';
                    $('#otherFiles').append(tr);
                </tbody> -->
            </table>
        </div>
    </div>
</form>



<script type="text/javascript">
    

    $("#uploadGenericFile").on('click',function(e){
        e.preventDefault();
        var uploadedFile = new FormData();
        uploadedFile.append("generic_upload_file", generic_upload_file.files[0]);
        uploadedFile.append("application_no", $("#application_no").val());
        uploadedFile.append("doc_name", $("#doc_name").val());
        uploadedFile.append("service_name", $("#service_name").val());

        jQuery.ajax({
            url: "http://localhost/dharitree/index.php/SettlementKhasLand/multipleFileSave",
            type: "POST",
            processData: false, // important
            contentType: false, // important
            dataType: "json",
            error: (error) => {
                showErrorMessage("Something has gone wrong. Kindly Retry1");
            },
            data: uploadedFile,
            success: function(data) {

                if(data.status == 4){
                    alert("Successfully Uploaded")
                    $('#otherFiles').show();
                    var tr='<tr id="tri'+data.docId+'"><td>'
                        + 'File Name'
                        +'</td><td><a href="#" id="viewFile"'
                        +' class="btn btn-danger btn-xs" onclick="viewFile('+"'"+data.docId+"','"+data.mime+"'"+')">View File</a></td></tr>';
                    $('#otherFiles').append(tr);
                }
                else{
                    alert("Something has gone wrong. Kindly Retry");
                }
            },
        });
    });


    function viewFile(doc_id, content) {
        
        // raw data
        // window.open("http://localhost/dharitree/index.php/SettlementKhasLand/fetchUploadFileApiRawFile?doc_id="+doc_id+"&content_type="+content);

        // base64 file
        window.open("http://localhost/dharitree/index.php/SettlementKhasLand/fetchUploadFileApiBaseFile?doc_id="+doc_id+"&content_type="+content);

    }

</script>