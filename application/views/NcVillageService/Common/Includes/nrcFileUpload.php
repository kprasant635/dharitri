<!-- file have to upload by LM -->

<?php //echo "<pre>"; var_dump($citizen_nrc_doc); die; ?>

<?php if(NRC_FILE_UPLOAD_ENABLED==1 && isset($citizen_nrc_doc->docs_avail) && $citizen_nrc_doc->docs_avail==0){?>

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
        .form__input__error__msg {
            font-size: small;
            color: red;
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

</style>

<?php //echo "<pre>"; var_dump($citizen_nrc_doc); die;

    // var_dump($lm_nrc_doc->result()); die;
?>
    <div class="card" style="margin-top: 20px;margin-bottom: 30px;">
        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#collapseNRC" style="background-color: #284f08d6!important; color:white;">
            <i class="fa fa-file-pdf-o"></i> <b>Inconvertible Hereditary Linkage With 1951 NRC Data (Click me to upload NRC Data of Citizen)</b>
        </div>
        <div class="collapse" id="collapseNRC">
            <div class="card-body ">
                <div class="">
                    <input type='hidden' id='rtps_application_no' value='<?=$basic["applid"]?>'/>
                    <input type="hidden" name="service_code_rtps" id="service_code_rtps" 
                    value="<?=$basic["service_code"]?>">
                    <div class="card-body table-responsive" id="">  
                        <?php 

                        // var_dump($citizen_nrc_doc); 
                        if($citizen_nrc_doc->docs_avail == 0){ ?>
                            <div class="nrc_file_details">
                                <div class="row" style="padding:8px;border: 3px solid #ff681d;border-radius: 10px;">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-sx-10">
                                        <div class="form-group">
                                            <label>a) NRC 1951 Document </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-10">
                                        <div class="form-group">
                                            Do you want to add hereditary data ? 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline" style="display:none">
                                                <input class="form-check-input" type="radio" name="is_legacy_code" id="is_legacy_code1" value="<?=YES?>" >
                                                <label class="form-check-label" for="is_legacy_code1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline muzammil">
                                                <input class="form-check-input" type="radio" name="is_legacy_code" id="is_legacy_code0" value="<?=NO?>">
                                                <label class="form-check-label" for="is_legacy_code0">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row legacy_code_yes" style="padding:8px;display:none">
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <label>Enter the Legacy Code </label>
                                            <input type="text" class="form-control" id="legacy_code_details" name="legacy_code_details" style="width: 100%" placeholder="Enter the legacy code" maxlength="99">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <label>NRC Data </label>
                                             <input type="text" class="form-control" id="doc_name1"  name="doc_name1" style="width: 100%" placeholder="Auto fetch data" readonly>

                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                            <label>Relation </label>
                                             <select class="form-select" name="relationshipNOKYES" id="relationshipNOKYES">
                                                <option value="">--SELECT RELATIONSHIP--</option>
                                                <option value="4">Great Great Grand Parent</option>
                                                <option value="3">Great Grand Parent</option>
                                                <option value="2">Grand Parent</option>
                                             </select>
                                             
                                        </div>
                         
                                    </div>

                                    <div class="row legacy_code_no" style="padding:8px;display:none">
                                        <h4 style="color: #ff681d;">Warning: You have choosen ``YES``</h4>
                                        <h5>kindly enter the name of the person whose name was available in NRC 1951</h5>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <label>Enter the Name </label>
                                             <input type="text" class="form-control" id="doc_name2" onchange="getNameHolder(2,this.value)"  name="doc_name2" style="width: 100%" placeholder="Enter the person name " maxlength="99">
                                             <span id="doc_name2Err" class="form__input__error__msg"></span>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                            <label>Relation </label>
                                             <select class="form-select" name="relationshipNOKNO" id="relationshipNOKNO">
                                                <option value="">--SELECT RELATIONSHIP--</option>
                                                <option value="4">Great Great Grand Parent</option>
                                                <option value="3">Great Grand Parent</option>
                                                <option value="2">Grand Parent</option>
                                             </select>
                                             
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                            <label>Choose Identity</label>
                                            <select class="form-select" name="identityCategory2" id="identityCategory2">
                                                <?php foreach (json_decode(NRC_HEREDITARY_DOCLIST) as $value)
                                                { ?>
                                                   <option value="<?=$value->DOC_CODE;?>"><?=$value->DOC_NAME;?></option>
                                                 
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                            <label>Upload File</label>
                                            <input type="file" id="nrc_add_file2" name="nrc_add_file2" class="file__input" accept="image/png, image/jpeg, application/pdf">
                                            <span id="nrc_add_file2Err" class="form__input__error__msg"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row linkDocumentList" style="border: 2px solid #d7d1d1;margin-top: 16px;border-radius: 10px;display: none;">    
                                    <h5 style="border-bottom: 3px solid #ff681d;padding: 10px;color: #4b6b30;">List of required Linkage Documents. 
                                        <span style="font-size: 15px;color: red;"> (Name Should be present in the Uploaded Document) </span>
                                    </h5>    
                                    <div class="row linkDoc1 linkDocShowFlag" style="padding:8px;">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-10">
                                            <div class="form-group">
                                                <label>Linkage Document 1  </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="doc_name3"  onchange="getNameHolder(3,this.value)" name="doc_name3" style="width: 100%" placeholder="Name of the Document 1 Holder" maxlength="99">
                                                <span id="nrc2" style="color: #b91414;font-weight: bold;font-size: 15px;"></span>
                                                <span id="doc_name3Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                            
                                            <select class="form-select" name="identityCategory3" id="identityCategory3">
                                                <?php foreach (json_decode(NRC_HEREDITARY_DOCLIST) as $value)
                                                { ?>
                                               <option value="<?=$value->DOC_CODE;?>"><?=$value->DOC_NAME;?></option>
                                             
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <div class="form-group">
                                                
                                                <input type="file" id="nrc_add_file3" name="nrc_add_file3" class="file__input" accept="image/png, image/jpeg, application/pdf">
                                                <span id="nrc_add_file3Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row linkDoc2 linkDocShowFlag" style="padding:8px;">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-10">
                                            <div class="form-group">
                                                <label>Linkage Document 2  </label>
                                            </div> 
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="doc_name4"  onchange="getNameHolder(4,this.value)" name="doc_name4" style="width: 100%" placeholder="Name of the Document 2 Holder" maxlength="99">
                                                <span id="nrc3" style="color: #b91414;font-weight: bold;font-size: 15px;"></span>
                                                <span id="doc_name4Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                                <select class="form-select" name="identityCategory4" id="identityCategory4">
                                                <?php foreach (json_decode(NRC_HEREDITARY_DOCLIST) as $value)
                                                { ?>
                                                    <option value="<?=$value->DOC_CODE;?>"><?=$value->DOC_NAME;?></option>
                                             
                                                <?php }?>
                                                </select>
                                            </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <div class="form-group">
                                                
                                                <input type="file" id="nrc_add_file4" name="nrc_add_file4" class="file__input" accept="image/png, image/jpeg, application/pdf">
                                                <span id="nrc_add_file4Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row linkDoc3 linkDocShowFlag" style="padding:8px;">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-10">
                                            <div class="form-group">
                                                <label>Linkage Document 3  </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="doc_name5"  onchange="getNameHolder(5,this.value)" name="doc_name5" style="width: 100%" placeholder="Name of the Document 3 Holder" maxlength="99">
                                                <span id="nrc4" style="color: #b91414;font-weight: bold;font-size: 15px;"></span>
                                                <span id="doc_name5Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-sx-12">
                                                <select class="form-select" name="identityCategory5" id="identityCategory5">
                                                <?php foreach (json_decode(NRC_HEREDITARY_DOCLIST) as $value)
                                                    { ?>
                                                    <option value="<?=$value->DOC_CODE;?>"><?=$value->DOC_NAME;?></option>
                                             
                                                <?php }?>
                                                </select>
                                            </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12">
                                            <div class="form-group">
                                                
                                                <input type="file" id="nrc_add_file5" name="nrc_add_file5" class="file__input" accept="image/png, image/jpeg, application/pdf">
                                                <span id="nrc_add_file5Err" class="form__input__error__msg"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-bottom: 25px;text-align: right;">
                                        <button type="button" class="btn btn-success" id="mulFileUpload"><i class="fa fa-plus-circle"></i> Upload Linkage Data</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row nrc_files_tab_show" style="border: 2px solid rgb(215, 209, 209); margin-top: 16px; border-radius: 10px;">
                        <h5 style="border-bottom: 3px solid #ff681d;padding: 10px;color: #4b6b30;">List of uploaded Files</h5>
                        <div class="table-responsive" style="height: 200px;">
                        
                            <table id="otherNRCFiles" class="table table-bordered">
                                <tr>
                                    <th>Relation</th>
                                    <th>Document Holder Name : </th>
                                    <th>File Name : </th>
                                    <th>Identity</th>
                                    <th>Status</th>
                                </tr>

                                <?php if(isset($lm_nrc_doc) && ($lm_nrc_doc != '' || $lm_nrc_doc != null)) { ?>


                                <?php 
                                        foreach ($lm_nrc_doc->result() as $key => $value){

                                        $relation = 'APPLICANT';
                                        $type = 'NA';
                                        foreach (json_decode(NRC_HEREDITARY_DOCLIST) as $docname) {
                                            if($docname->DOC_CODE == $value->rel_identity)
                                            {
                                                $type = $docname->DOC_NAME;
                                            }
                                        }
                                        if($value->relation == 4){
                                            $relation = 'Great Great Grand Parent';
                                        }
                                        else if($value->relation == 3){
                                            $relation = 'Great Grand Parent';
                                        }
                                        else if($value->relation == 2){
                                            $relation = 'Grand Parent';
                                        }
                                        $title = '';
                                        if($value->parentName != 'Owner')
                                        {
                                            $title = " [ Son/Daughter of (".$value->parentName.") ]";
                                        } 
                                ?>
                                <tr>

                                    <td><?=$relation;?></td>
                                    <td><?=$value->doc_holder_name . $title;?></td>
                                    <td><?=$value->file_details;?></td>
                                    <td><?=$type;?></td>
                                    <td><b style="color:green">File Uploaded</b> </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </table>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">

var baseurl = "<?php echo base_url();?>";

// $('.nrc_files_tab_show').hide();
$('.linkDocShowFlag').hide();
$('.linkDocumentList').hide();
function getNameHolder(str,nameString) {
    $('#nrc'+str).html("( Son/Daughter of " + nameString + " )");
}

$("#mulFileUpload").on('click',function(argument){

    var uploadedFile = new FormData();
    uploadedFile.append("legacy_yes_or_no", $('input:radio[name=is_legacy_code]:checked').val());
    uploadedFile.append("doc_name1", null);
    uploadedFile.append("doc_name2", null);
    uploadedFile.append("id_cat1", null);
    uploadedFile.append("nrc_add_file1", null);
    uploadedFile.append("id_cat2", null);
    uploadedFile.append("legacy_code", null);
    if($('input:radio[name=is_legacy_code]:checked').val() == 1) 
    {
        uploadedFile.append("legacy_code", $("#legacy_code_details").val());
        uploadedFile.append("doc_name1", $("#doc_name1").val());
    }
    else
    {
        uploadedFile.append("doc_name2", $("#doc_name2").val());
        uploadedFile.append("nrc_add_file2", nrc_add_file2.files[0]);
        uploadedFile.append("id_cat2", $("#identityCategory2").val());
    }

    uploadedFile.append("relationship_no", $("#relationshipNOKNO").val());
    uploadedFile.append("relationship_yes", $("#relationshipNOKYES").val());

    uploadedFile.append("doc_name3", $("#doc_name3").val());
    uploadedFile.append("doc_name4", $("#doc_name4").val());
    uploadedFile.append("doc_name5", $("#doc_name5").val());

    uploadedFile.append("nrc_add_file3", nrc_add_file3.files[0]);
    uploadedFile.append("nrc_add_file4", nrc_add_file4.files[0]);
    uploadedFile.append("nrc_add_file5", nrc_add_file5.files[0]);
    
    uploadedFile.append("id_cat3", $("#identityCategory3").val());
    uploadedFile.append("id_cat4", $("#identityCategory4").val());
    uploadedFile.append("id_cat5", $("#identityCategory5").val());

    uploadedFile.append("application_id", $("#rtps_application_no").val());
    uploadedFile.append("service_code",$('#service_code_rtps').val());

    console.log(uploadedFile);

    jQuery.ajax({
        url: baseurl + "index.php/NrcDocController/nrcFileUpload",
        type: "POST",
        processData: false, // important
        contentType: false, // important
        dataType: "json",
        error: (error) => {
            
            showErrorMessage("Something has gone wrong. Kindly Retry1");
        },
        data: uploadedFile,
        success: function(data) {
            console.log(data);
            
            if (data.responseType == 1) {
                data.validation.forEach(function(validation) {
                    var errMsg = "#" + validation.field + "Err";
                    $(errMsg).text("⚠️ " + validation.message);
                });

                data.validationFiles.forEach(function(validationFiles) {
                    var errMsg1 = "#" + validationFiles.field + "Err";
                    $(errMsg1).text("⚠️ " + validationFiles.message);
                });
            }else if(data.responseType == 2){
              
                showSuccessMessage("Successfully Uploaded.");
                resetAppData();
                $('.nrc_files_tab_show').show('slow');
                $('#otherNRCFiles').append('');
                $('#otherNRCFiles').show();

                $('.nrc_file_details').hide();
                var tr;
                var title = '';
                data.doc_file.forEach(function(doc_file) {
                    var type = 'VOTER CARD';
                    var relation = 'APPLICANT';
                    if(doc_file.rel_identity == 'A'){
                        type = 'AADHAAR CARD';
                    }
                    else if(doc_file.rel_identity == 'P'){
                        type = 'PAN CARD';
                    }

                    if(doc_file.relation == 4){
                        relation = 'Great Great Grand Parent';
                    }
                    else if(doc_file.relation == 3){
                        relation = 'Great Grand Parent';
                    }
                    else if(doc_file.relation == 2){
                        relation = 'Grand Parent';
                    }
                    
                    if(doc_file.parentName != 'Owner')
                    {
                        title = " [ Son/Daughter of (" + doc_file.parentName + ") ]";
                    }

                    tr +='<tr id="tri'+doc_file.id+'"><td>'
                    + relation + '</td><td>'
                    +doc_file.doc_holder_name + title + '</td><td>'
                    +doc_file.file_details + '</td><td>'
                    +type
                    +'</td><td><b style="color:green">File Uploaded</b></td></tr>';

                });
                

                $('#otherNRCFiles').append(tr);
            }
            else{
                showErrorMessage("Something has gone wrong. Kindly Retry");
            }
        },
    });
});

</script>
<script type="text/javascript">
    
$("input:radio[name=is_legacy_code]").click(function() {
    resetAppData();
    if($('input:radio[name=is_legacy_code]:checked').val() == 1) {
        $(".legacy_code_yes").show('slow');
        $('.legacy_code_no').hide();
    } else {
        $(".legacy_code_no").show('slow');
        $('.legacy_code_yes').hide();
    }
});

$('#relationshipNOKNO').on('change',function(){
    $('.linkDocShowFlag').hide();
    $('.linkDocumentList').hide();
    var generationFlag = parseInt($(this).val());
    console.log(generationFlag);
    if(generationFlag){
        $('.linkDocumentList').show('slow');
        for (var i = 0; i < generationFlag; i++) {
            $('.linkDoc'+i).show('slow');
        }
    }
    else
    {
        showErrorMessage("SOMETHING IS NOT RIGHT !!!!RELOAD THE PAGE");
    }



});



$('#relationshipNOKYES').on('change',function(){
    $('.linkDocShowFlag').hide();
    $('.linkDocumentList').hide();
    var generationFlag = parseInt($(this).val());

    if(generationFlag){
        $('.linkDocumentList').show('slow');
        for (var i = 0; i < generationFlag; i++) {
            $('.linkDoc'+i).show('slow');
        }
    }
    else
    {
        showErrorMessage("SOMETHING IS NOT RIGHT !!!!RELOAD THE PAGE");
    }

});
$('#legacy_code_details').on('change',function() {
    if($(this).val() == '123')
    {
        $('#doc_name1').val('Tileswar Borah');
        $('#nrc2').html("Son/Daughter of Tileswar Borah");
    }
    
});




function resetAppData()
{
    $('#legacy_code_details').val('');
    $('#doc_name1').val('');
    $('#doc_name2').val('');
    $('#doc_name3').val('');
    $('#doc_name4').val('');
    $('#doc_name5').val('');
    $('#doc_name6').val('');

    $('.linkDocShowFlag').hide();
    $('.linkDocumentList').hide();

    $('#nrc2').html('');
    $('#nrc3').html('');
    $('#nrc4').html('');
    $('#nrc5').html('');
}
</script>



<?php } ?>



<!-- file uploaded by citizen -->
<?php include(APPPATH."views/SettlementView/include/nrcFileUploadByCitizen.php"); ?>




