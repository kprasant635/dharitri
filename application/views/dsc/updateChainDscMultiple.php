<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="resources/js/jquery.js"></script>
<script src="resources/js/bootstrap.min.js"></script> -->
    <script src="<?= base_url() ?>application/views/dsc/resources/js/dsc-signer.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>application/views/dsc/resources/js/dscapi-conf.js" type="text/javascript"></script>
    <!-- <link type="text/css" rel="stylesheet"
	href="resources/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"
	href="resources/css/dsc-signer.css">
</head> -->

<body>
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div>
             
                <form id="update-chain-dsc-form">
                    <input type="text" id="serialNumPropChain" name="serialNumPropChain" class="form-control input-sm" autocomplete="off" readonly="true" />
                    <div class="form-group" style="padding: 14px;">
                        <fieldset class="form-group border p-3">
                            <legend class="w-auto px-2">Certificate Details</legend>
                           <div class="row">
                                <div class="col-sm-4">
                                    <div class="well-sm" >
                                        <input type="hidden" id="case_no_signed">
                                        <form id="pdfForm">
                                            Batch Size: <br/>
                                            <input type="text" id="txtBatchSize" value="<?=$case_count?>" maxlength="3" />
                                            <input id="btnInitBatch" type="button" value="Initialize" class="btn btn-success"><br/>
                                            Batch Token: <br/>
                                            <textarea cols="30" rows="3" id="txtBatchToken" readonly="readonly"></textarea><br/>
                                            <label for="data">Choose Local File : </label><br />
                                            <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf" />
                                            <label for="pdfData">Pdf Data(Base64)):</label> <br />
                                            <textarea id="pdfData" placeholder="Choose pdf file above to show pdf data..."cols="60" rows="4" readonly="readonly">
                                            </textarea><br/>
                                            <label for="cert">Certificate for Signing:</label><br/>
                                            <textarea  id="cert"><?php echo $certificate; ?></textarea><br/>
                                            Reason : <input type="text" id="signingReason" name="signingReason" maxlength="20" /> <br />
                                            Location : <input type="text" id="signingLocation" name="signingLocation" maxlength="20" /> <br />
                                            stampingX : <input type="text" id="stampingX" name="stampingX" maxlength="20" value="150" /> <br />
                                            stampingY: <input type="text" id="stampingY" name="stampingY" maxlength="20" value="50" /><br />
                                            Select TSA URL :
                                            <select name="tsaurls" id="tsaurls" onchange="myFunction()">
                                                <option value="0">--------------------------SELECT---------------------------------</option>
                                                <option value="http://sha256timestamp.ws.symantec.com/sha256/timestamp"> http://sha256timestamp.ws.symantec.com/sha256/timestamp</option>
                                                <option value="http://timestamp.comodoca.com/rfc3161">http://timestamp.comodoca.com/rfc3161</option>
                                                <option value="http://tsa.startssl.com/rfc3161">http://tsa.startssl.com/rfc3161</option>
                                                <option value="http://timestamp.digicert.com">http://timestamp.digicert.com</option>
                                                <option value="http://tsa.safecreative.org">http://tsa.safecreative.org</option>
                                            </select> <br/>
                                            TSA URL (Optional) :
                                            <input type="text" id="tsaURL" name="tsaURL" value="" maxlength="100" style="width: 400px;" /> <br />
                                            Time Server URL (Optional) :
                                            <input type="text" id="timeServerURL" name="timeServerURL" value="<?=DIGITAL_SIGN_SERVER_TIME_URL?>" maxlength="100" style="width: 400px;" /><br />
                                            
                                            <input id="signPdf" type="button" value=" Sign Pdf " class="btn btn-success">
                                            <input id="submitPdf" type="Submit" style="display: none;"><a id="downloadDiv" href='#' type="application/pdf" download="SignedPdf.pdf"></a>
                                            <input id="btnDecryptVerify" type="button" value=" Decrypt Verify " class="btn btn-danger" />
                                            <input id="btnDecryptVerifyWithCrt" type="button" value=" Decrypt & Verify " class="btn btn-danger" />
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="well-sm" >
                                        <label for="signedPdfData">Signed Pdf Data(Base64):</label> <br />
                                        <textarea placeholder="After signing, the encrypted signature will be shown here..." id="signedPdfData" cols="60" rows="8" disabled></textarea> <br />
                                        <label>Encryption Key:</label>
                                        <textarea placeholder="The random key used for encrypting the signature will be shown here..." id="lblEncryptedKey" cols="60" rows="4" disabled></textarea> <br />
                                        <label>Verification Response:</label>
                                        <textarea placeholder="The signature verification result from DSCAPI server will be shown here..." id="verificationResponse" cols="60" rows="8" disabled></textarea>
                                    </div>
                                </div>
                                <div id='panel'></div>
                            </div>

                        </fieldset>
                        <div class="alert alert-info success_message" style="display: none;">
                            <strong><span id="success_msg_1">Signature Generated Successfully !</span></strong><span id="success_msg_2"> Updating property chain.</span>
                        </div>
                        <!-- <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Data to Sign:</label><br />
                                <textarea class="form-control" placeholder="Enter any data to be signed here..." id="prop_data" name="prop_data" cols="50" rows="4" autocomplete="off" readonly="true" required><?= $property_data ?></textarea>
                                <br />
                            </div>
                        </div> -->


                       <!--  <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Certificate:</label><br />
                                <textarea class="form-control input-sm" id="cert" name="cert" cols="50" rows="4" autocomplete="off" readonly="true" required></textarea>
                                 <input id="btnSign" type="button" value=" Sign Property Data " class="btn btn-success text-white" /> -->
                                <!-- <input id="btnDecryptVerifyWithCrt" type="button" value=" Decrypt & Verify with certificate " class="btn btn-danger" /> -->
                              <!--   <br />
                            </div>
                        </div> -->

                       <!--  <div class="buttondiv">
                            <span class="btn btn-success">
                                <i class="fa fa-pencil"></i> <input id="btnSign" type="button" value=" Sign Property Data & Pass Order" class="text-white" />
                            </span>
                        </div> -->

                        <input type="hidden" name="case_no" id="case_no" value="<?= $dhar_case_no ?>">
                        <input type="hidden" name="update_data" id="update_data" value="<?= $update_data ?>">
                        <input type="hidden" name="reference_no" id="reference_no" value="<?= $reference_no ?>">
                        <input type="hidden" name="previous_hash" id="previous_hash" value="<?= $previous_hash ?>">
                        <!-- <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Encrypted signature:</label><br />
                                <textarea class="form-control input-sm" id="lblSignature" name="lblSignature" cols="50" rows="8"></textarea></br>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Encrypted key:</label><br />
                                <textarea class="form-control input-sm" id="lblEncryptedKey" name="lblEncryptedKey" cols="50" rows="4"></textarea>
                            </div>
                        </div> -->
                    </div>
                    <!-- <span class="btn btn-primary" id="push_data_div" style="display:none;">
                        <i class="fa fa-send"></i><input id="push_data_to_prop_chain" type="button" value="Push to property chain" class="text-white" onclick="return updatePropertyChain('update-chain-dsc-form');" style="margin: 5px;" />
                    </span> -->
                    <!-- <input type="button" id="push_bc_map" class="btn btn-primary text-white" value="Update Map" hidden> -->
                </form>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <label for="decryptedSignature">Decrypted Signature:</label> <br />
            <textarea placeholder="On clicking Decrypt and Verify button, the signature decrypted by DSCAPI server will be shown here..." id="decryptedSignature" cols="60" rows="8" disabled></textarea>
            <br /> <label for="verifiedSignature">Verification Data:</label> <br />
            <textarea placeholder="The signature verification result from DSCAPI server will be shown here..." id="verifiedSignature" cols="60" rows="8"></textarea>
        </div> -->
        <div class="col"></div>

    </div>
    <div id="panel"></div>

<script>


    function generateAllPropertyDataForSign()
    {
        var batch_size = $("#txtBatchSize").val();
        $("#txtBatchToken").val(dscSigner.initbatch(batch_size));

        var base_url = "<?php echo base_url(); ?>";
        var case_no = $("#case_no").val();

        const applicant = {
            case_no: case_no,
        };
        console.log(applicant);
        $.ajax({
            url: base_url +'index.php/PropChainReport/bulkSignForMultipleDags',
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                if(data.responseType == 3){
                    showWarningMessage(data.msg);
                    //location.reload(true);
                    return;
                }else{
                    $("#serialNumPropChain").val('12345');

                    for (let index = 0; index < data.length; index++)
                    {
                        $("#case_no_signed").val(data[index].case_no);
                        autoBatchSign(data[index].property_data);
                    }
                }
            },
            data: JSON.stringify(applicant)
        });
    }


    function myFunction() {
        var x = document.getElementById("tsaurls").value;
        if (x != 0) {
            document.getElementById("tsaURL").value = x;
        } else {
            document.getElementById("tsaURL").value = "";
        }
    }
    function autoBatchSign(base64PDF){
        var data = base64PDF;
        if (data != null || data != '') 
        {
            token=$("#txtBatchToken").val()
            dscSigner.signpdfbatch(data,token);
            $("#txtBatchSize").val(dscSigner.batchsize());
            if (dscSigner.batchsize()==0) {
                $("#txtBatchSize").removeAttr("disabled");
                $("#btnInitBatch").removeAttr("disabled");
            }
        }
    }
    function signandSavePDF(pdfData,signedCaseno)
    {
        var requestData = {
            pdfData : pdfData,
            case_no : signedCaseno,
            };
           console.log(requestData);
            $.ajax({
                url: baseurl + "DigitalPatta/signAndSavePDF",
                type : "post",
                dataType : "json",
                contentType : 'application/json',
                data : JSON.stringify(requestData),
                // async : false,
                success:function(response) {
                    console.log(response);
                    if(response.flag =='N'){
                        showWarningMessage(response.msg);
                        $('#sentForDigitalSignModalOpen').modal('hide');
                        return;
                    }else if(response.flag == 'Y'){
                        alert("generated successfully");
                        showSuccessMessage(response.msg);
                        $('#sentForDigitalSignModalOpen').modal('hide');
                        return;
                    }else{
                        alert('Something went wrong.');
                    }
                    //*******************/
                },
                error: function (error) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }
    function autoDecryptAndSignAndSave(sign,key){
            $('#verificationResponse').val('');
            // Implement Verify here
            var requestData = {
                action : "DECRYPT_VERIFY_WITH_CERT",
                en_sig : sign,
                ek : key,
                certificate : $('#cert').val()
            };
            $.ajax({
                url : dscapibaseurl + "/pdfsignature",
                type : "post",
                dataType : "json",
                contentType : 'application/json',
                data : JSON.stringify(requestData),
                async : false
            }).done(function(data) {
                if (data.status_cd == 1) {
                    console.log("hiiiiiii");
                    var jsonData = JSON.parse(atob(data.data));
                    $('#decryptedSignature').val(jsonData.sig);
                    $('#decodedSignedXML').val(atob(jsonData.sig));
                    $('#verifiedSignature').val(atob(data.data));
                    $('#verificationResponse').val(atob(data.data));
                    //Set Class to download link
                    // $('#downloadDiv').addClass('btn btn-info');
                    //get pdf data
                    var pdfData = jsonData.sig;
                    // var dlnk = document.getElementById('downloadDiv');
                    // dlnk.href = 'data:application/pdf;base64,' + pdfData;
                    // $("#downloadDiv").text("Download Signed PDF File");
                    var signedCaseno = $('#case_no_signed').val();
                    signandSavePDF(pdfData,signedCaseno);
                } else {
                    $('#verificationResponse').val(JSON.stringify(data));
                    alert("Verification Failed");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            });
    }



    $(document).ready(function() {

       
            var serialNo = $('#serialNumPropChain').val();
            if (serialNo == "") {
                loadForNICDsign();
            }

            function loadForNICDsign(){
                $.blockUI({
                    message: '<h5><img src="<?= base_url() ?>application/views/dsc/resources/images/please-wait-fb.gif" /> Initializing NICDSign.Please Wait...</h5>'
                });
                setTimeout(function() {
                       
                            $(document).ajaxStop($.unblockUI);
                            generateAllPropertyDataForSign();
                      
                }, 3000);

            }


        $('#btnDecryptVerify').hide();
        $('#btnDecryptVerifyWithCrt').hide();
        // var initConfig = {
        //     "preSignCallback" : function() {
        //         // do something
        //         // based on the return sign will be invoked
        //         return true;
        //     },
        //     "postSignCallback" : function(alias, sign, key) {
        //         $('#signedPdfData').val(sign);
        //         $('#lblEncryptedKey').val(key);
        //         // $('#btnDecryptVerify').show();
        //         // $('#btnDecryptVerifyWithCrt').show();
        //         // autoDecryptAndSignAndSave(sign,key);
        //     },
        //     signType : 'pdf',
        //     mode : 'batch',
        //     certificateData : $('#cert').val()
        // };
        // dscSigner.configure(initConfig);
        // $('#cert').bind('input propertychange', function() {
        // function propChangeCert(){
            var initConfig = {
                "preSignCallback" : function() {
                    // do something before signing
                    //alert("Pre-sign event fired");
                    return true;
                },
                "postSignCallback" : function(alias, sign, key) {
                    //do something after signing
                    $('#signedPdfData').val(sign);
                    $('#lblEncryptedKey').val(key);
                    console.log("sign=========");
                    console.log(sign);
                    console.log(key);
                    //                                          $('#btnDecryptVerify').show();
                    // $('#btnDecryptVerifyWithCrt').show();
                    autoDecryptAndSignAndSave(sign,key);
                },
                signType : 'pdf',
                mode : 'batch',
                certificateData : $('#cert').val()
            };
            dscSigner.configure(initConfig);
        // }
        // });
        $('#btnDecryptVerify').click(function() {
            var sign = $('#signedPdfData').val();
            var key = $('#lblEncryptedKey').val();
            // Implement Decrypt Verify here
            var requestData = {
                action : "DECRYPT_VERIFY",
                en_sig : sign,
                ek : key
            };
            $.ajax({
                url : dscapibaseurl + "/pdfsignature",
                type : "post",
                dataType : "json",
                contentType : 'application/json',
                data : JSON.stringify(requestData),
                async : false
            }).done(function(data) {
                if (data.status_cd == 1) {
                    var jsonData = JSON.parse(atob(data.data));
                    $('#decryptedSignature').val(jsonData.sig);
                    $('#decodedSignedXML').val(atob(jsonData.sig));
                    $('#verifiedSignature').val(atob(data.data));
                    $('#verificationResponse').val(atob(data.data));
                    //Set Class to download link
                    $('#downloadDiv').addClass('btn btn-info');
                    //get pdf data
                    var pdfData = jsonData.sig;
                    var dlnk = document.getElementById('downloadDiv');
                    dlnk.href = 'data:application/pdf;base64,' + pdfData;
                    $("#downloadDiv").text("Download Signed PDF File");
                    $('#btnDecryptVerify').hide();
                    $('#btnDecryptVerifyWithCrt').hide();
                } else {
                    alert("Verification Failed");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            });
        });
        $('#btnDecryptVerifyWithCrt').click(function() {
            $('#verificationResponse').val('');
            var sign = $('#signedPdfData').val();
            var key = $('#lblEncryptedKey').val();
            // Implement Verify here
            var requestData = {
                action : "DECRYPT_VERIFY_WITH_CERT",
                en_sig : sign,
                ek : key,
                certificate : $('#cert').val()
            };
            $.ajax({
                url : dscapibaseurl + "/pdfsignature",
                type : "post",
                dataType : "json",
                contentType : 'application/json',
                data : JSON.stringify(requestData),
                async : false
            }).done(function(data) {
                if (data.status_cd == 1) {
                    var jsonData = JSON.parse(atob(data.data));
                    $('#decryptedSignature').val(jsonData.sig);
                    $('#decodedSignedXML').val(atob(jsonData.sig));
                    $('#verifiedSignature').val(atob(data.data));
                    $('#verificationResponse').val(atob(data.data));
                    //Set Class to download link
                    $('#downloadDiv').addClass('btn btn-info');
                    //get pdf data
                    var pdfData = jsonData.sig;
                    var dlnk = document.getElementById('downloadDiv');
                    dlnk.href = 'data:application/pdf;base64,' + pdfData;
                    $("#downloadDiv").text("Download Signed PDF File");
                    //                                      $('#btnDecryptVerify').hide();
                    //                                      $('#btnDecryptVerifyWithCrt').hide();
                } else {
                    $('#verificationResponse').val(JSON.stringify(data));
                    alert("Verification Failed");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var data = e.target.result;
                    var base64 = data.replace(/^[^,]*,/, '');
                    $("#pdfData").val(base64);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#pdfFile").change(function() {
            readURL(this);
        });
    });
</script>
    <style>
        span>i {
            color: white;
        }

        span>input {
            background: none;
            color: white;
            padding: 0;
            border: 0;
        }
    </style>
</body>

</html>