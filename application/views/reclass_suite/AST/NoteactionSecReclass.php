
<form id="form_submit">
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="well well-sm">
                <h2 style="text-align: center;"> <kbd>Case No: <?php echo $pb->case_no ?> </kbd></h2>
            </div>

            <div class="panel panel-info">
                <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-lg-3 text-end">
                        <label for="remark" class="form-label fw-bold">Note Of action:</label>
                    </div>
                    <div class="col-lg-9">
                        <textarea id="remark" name="remark" rows="4" class="form-control shadow-sm" placeholder="Enter your remark here..." required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 text-end">
                        <label><u>Upload Additional Document</u></label>
                &nbsp;
                <i class="fa fa-info-circle text-red" 
                title="1. Uploaded file types should be jpeg|jpg|png|pdf only.
                2. Uploaded file size should not be more than 4MB"></i>
                    </div>
                    <div class="col-lg-9">
                    <table class="table table-striped table-bordered">
                    <tbody id='certi_tab'>
                        
                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc1" name="doc1" placeholder="Enter document name"  style="width: 100%; font-size: 1.1rem !important; padding: 10px;"/  value=""/></span>
                            </td>
                            <td><span class="text-bold"> <input type='file' style="width: 100%; font-size: 1.1rem !important; padding: 10px;"/  name="doc1_file" id="doc1_file"></span></td>
                            <td>
                                <button type="button" class="btn btn-lg btn-warning uploadOMutDocumentCO" id='1'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                                <input type="hidden" name="case_no" id="case_no" value="<?=$pb->case_no?>">
                            </td>
                            <td>
                                <?php if(!empty($doc1_id)) { if($doc1_id->id!='' || $doc1_id->id!=null) { ?>
                                <div id="div_death">
                                    <button class="btn btn-sm btn-info" type="button"><a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc1_id->id?>" target="_blank">VIEW <?=$doc1_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO removeDeath" id='1'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_1"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                    </div>
                </div>



                    
                </div>
                
                <div id="error_u_message"></div>
                <div class="center py-3" id="submit_btn">
                    <input type="hidden" name="case_no" value="<?= $pb->case_no ?>">
                    <button class="btn btn-success" type="submit">
                    <i class="fa fa-print"> </i> Save Note of Action</button>
                    <a href="" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $('.uploadOMutDocumentCO').click(function(){
        $('#alert_message').html('');
        $('#alert_message').hide();
        flag = $(this).attr('id');

        var doc_name = $('#doc1').val();
        var doc_file = $('#doc1_file')[0].files[0];

        //alert(doc_file);return;

        if(doc_name==false || doc_name=='false')
        {
            alert('Document name is mandatory!!');
            return;
        }

        if(doc_file==undefined || doc_file=='undefined')
        {
            alert('Document File is mandatory!!');
            return;
        }
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("doc1_file", $('#doc1_file')[0].files[0]);
            formdata.append("doc1", $('#doc1').val());
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        // formdata.append("dist_code", $('#dist_code').val());

        // console.log(formdata);

        $.ajax({
            url: baseurl + "ReclassSuiteControllerAst/uploadSupportiveDocsReclass/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }

                if(data.flag_set == '1'){
                     $('#div_death').html('');
                     $('#file_1').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#div_noc').html('');
                    $('#file_2').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentCO" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
            
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            },error: function(errors){
                $('#alert_message').html('');
                $('#alert_message').fadeIn();
                if(errors.status == 403){
                    let err_msg = errors.responseJSON.errors;
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }else{
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            }
        });
    });
</script>

<script>
    //// Submit Form ///
    $("#form_submit").submit(function (e) {
        e.preventDefault();
        if ( ! confirm('Are you sure want to give note of action?')){
            return;
        }
        var remark = $('#remark').val();
        if(remark == '' || remark == null)
        {
            alert('Please provide Remark..!');
            return;
        }
        $.ajax({
            url: baseurl + "ReclassSuiteControllerAst/SaveNoteofActionReclass",
            type: 'POST',
            data: $("#form_submit").serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('.loader').addClass('trans');
                $('.loader').removeClass('hide');
                $('#submit_btn').hide();
                $('#error_u_message').html('');
            },
            success: function (data) {
                console.log(data);
                $('.loader').addClass('hide');
                $('.loader').removeClass('trans');
                if(data.error === false)
                {
                    window.location.href = data.url;
                    return;
                }
                if(data.error === true)
                {
                    $('#submit_btn').show();
                    $('#error_u_message').html('');
                    $('#error_u_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">' +data.msg +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');

                    return;
                }
            },
            error: function (jqXHR, exception) {
                $('#submit_btn').show();
                $('.loader').addClass('hide');
                if(jqXHR.status == 403){
                    $('#error_u_message').html(`<div class="bg-gradient-danger p-2 rounded">${ jqXHR.responseJSON.errors }<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>`);
                }else{
                    alert('Error [##AUTOM0101]: Could not Complete your Request (AJAX ERROR)..!');
                }
            }
        });
    });

</script>