<script src="<?php echo base_url(); ?>application/views/resources/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dsc-signer.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dscapi-conf.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/dsc-signer.css">

<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <p class="uni_text">
                        <span class="pull-left"><?php echo $this->utilityclass->getCertName($certDtls->cert_type); ?></span>
                        <span class="pull-right"><?php echo $this->lang->line('sr_no'); ?>:<?php echo $certDtls->cert_no; ?></span>
                    </p>
                    <?php //var_dump($jsonEncode); ?>
                    <hr>
                    <p class='uni_text red center'>Please Upload the Jamabandi and Deliver with Digital Signature.</p>
                    <div class="col-lg-12 update ">
                        <div class="alert alert-info">
                            <form id="pdfForm" class="form-horizontal unicode">
                                <label for="data">Choose Jamabandi : </label><br /> <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf" />
                                <!--<label for="pdfData">Pdf Data (Base64):</label> <br />-->
                                <textarea id="pdfData" cols="60" rows="8" readonly="readonly" class="hidden"><?=$jsonEncode?></textarea>
                                <br />
                                <input type="hidden" id="signingReason" name="signingReason" maxlength="20" />
                                <input type="hidden" id="signingLocation" name="signingLocation" maxlength="20" />
                                <input type="hidden" id="stampingX" name="stampingX" maxlength="20" value="200" />
                                <input type="hidden" id="stampingY" name="stampingY" maxlength="20" value="200" />
                                <input type="hidden" id="tsaURL" name="tsaURL" value="" maxlength="100" style="width: 400px;" />
                                <input type="hidden" id="timeServerURL" name="timeServerURL" value="http://10.177.15.210:9090/dscapi/getServerTime" maxlength="100" style="width: 400px;" />
                                <input id="signPdf" type="button" value="Digitaly Sign Pdf " class="btn btn-success"> 
                                <input id="submitPdf" type="Submit" style="display: none;"> 
                                <a id="downloadDiv" href='#' type="application/pdf" download="SignedPdf.pdf"></a> 
                                <input id="verifyPdfBtn" type="button" value=" Verify Pdf " class="btn btn-danger"> <br />
                            </form>
                            <div id="panel"></div>
                            <form class="form-horizontal unicode" action="<?php echo base_url(); ?>index.php/serviceplus/UpdateJamaBondi" method="POST" enctype="multipart/form-data">
                                <!--<label for="signedPdfData">Signed Pdf (Base64):</label> <br />-->
                                <input type="hidden" class="form-control" name='signedPdfData' readonly id='signedPdfData' >
                                <!--<textarea id="signedPdfData" cols="60" rows="8" disabled name="signedPdfData"></textarea>-->
                                <!--<br /> <label>Encryption Key:</label>-->
                                <textarea id="lblEncryptedKey" cols="60" rows="4" disabled class="hidden"></textarea>
                                <!--<br/> <label>Verification Response:</label>-->
                                <textarea id="verificationResponse" cols="60" rows="8" disabled class="hidden"></textarea>
                                
                                <input type="hidden" id='num_page' class="form-control col-lg-1" name="number_of_pages" required value="1">
                                <input type="hidden" class="form-control" name='fee_amt' readonly id='fees' required value="20.00"><br>
                                <button type="submit" id="buttons" class="btn btn-danger">Deliver Certificate</button>
                                <input type="hidden" value="<?php echo $certDtls->cert_no; ?>"  name="cert_no" >
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
<script>
    $('#num_page').keyup(function () {
        if ($("#num_page").val() == "0")
        {
            alert("Please type number of pages");
            var fees = 20;
            $('#fees').val(fees);
            $('#button').prop('disabled', true);
            return false;
        }

        if ($(this).val().length == 0) {
            $('#button').prop('disabled', true);
        } else {
            $('#button').prop('disabled', false);
            var fees = 0;
            var num_page = parseInt($('#num_page').val()) || 0;
            var count = num_page - 1;
            var fees = count * 10 + 20;
            $('#fees').val(fees);
        }
    });
    $('#button').prop('disabled', true);
    $('.clickenable').click(function () {
        $('#button').prop('disabled', false);

    });
</script>
<script type="text/javascript">
    function myFunction() {
        var x = document.getElementById("tsaurls").value;
        if (x != 0) {
            document.getElementById("tsaURL").value = x;
        } else {
            document.getElementById("tsaURL").value = "";
        }
    }
    $(document)
            .ready(
                    function () {

                        $('#verifyPdfBtn').hide();

                        var initConfig = {
                            "preSignCallback": function () {
                                // do something 
                                // based on the return sign will be invoked
                                return true;
                            },
                            "postSignCallback": function (alias, sign, key) {
                                $('#signedPdfData').val(sign);
                                $('#lblEncryptedKey').val(key);
                                // Implement signed pdf upload and pdf Download here
                                var requestData = {
                                    action: "DECRYPT",
                                    en_sig: sign,
                                    ek: key
                                };
                                $
                                        .ajax(
                                                {
                                                    url: dscapibaseurl
                                                            + "/pdfsignature",
                                                    type: "post",
                                                    dataType: "json",
                                                    contentType: 'application/json',
                                                    data: JSON
                                                            .stringify(requestData),
                                                    async: false
                                                })
                                        .done(
                                                function (data) {
                                                    if (data.status_cd == 1) {
                                                        //get data.data -> decode base64 -> get json->check status == SUCCESS
                                                        //get data.data.sig -> add pdf header and append to link
                                                        var jsonData = JSON
                                                                .parse(atob(data.data));
                                                        if (jsonData.status === "SUCCESS") {
                                                            $(
                                                                    '#verifyPdfBtn')
                                                                    .show();
                                                            //Set Class to download link
                                                            $(
                                                                    '#downloadDiv')
                                                                    .addClass(
                                                                            'btn btn-info');
                                                            //get pdf data
                                                            var pdfData = jsonData.sig;
                                                            var dlnk = document
                                                                    .getElementById('downloadDiv');
                                                            dlnk.href = 'data:application/pdf;base64,'
                                                                    + pdfData;
                                                            $(
                                                                    "#downloadDiv")
                                                                    .text(
                                                                            "Download Signed PDF File");

                                                        }

                                                    } else {
                                                        if (data.error.error_cd == 1002) {
                                                            alert(data.error.message);
                                                            return false;
                                                        } else {
                                                            alert("Decryption Failed for Signed PDF File");
                                                            return false;
                                                        }

                                                    }
                                                }).fail(
                                        function (jqXHR, textStatus,
                                                errorThrown) {
                                            alert(textStatus);
                                        });
                            },
                            signType: 'pdf',
                            mode: 'nostampingv2'
                                    //"certificateSno" : 13705892,
                        };
                        dscSigner.configure(initConfig);

                        $('#signPdf').click(function () {
                            var data = $("#pdfData").val();

                            if (data != null || data != '') {
                                dscSigner.sign(data);
                            }
                        });

                        $('#verifyPdfBtn')
                                .click(
                                        function () {
                                            var signedPdfData = $(
                                                    '#signedPdfData').val();
                                            var key = $('#lblEncryptedKey')
                                                    .val();

                                            // Implement Verify here
                                            var requestData = {
                                                action: "VERIFY",
                                                en_sig: signedPdfData,
                                                ek: key
                                            };
                                            $
                                                    .ajax(
                                                            {
                                                                url: dscapibaseurl
                                                                        + "/pdfsignature",
                                                                type: "post",
                                                                dataType: "json",
                                                                contentType: 'application/json',
                                                                data: JSON
                                                                        .stringify(requestData),
                                                                async: false
                                                            })
                                                    .done(
                                                            function (data) {
                                                                if (data.status_cd == 1) {
                                                                    //get pdfSignatureVerificationResponse
                                                                    $(
                                                                            '#verificationResponse')
                                                                            .val(
                                                                                    atob(data.data));
                                                                } else {
                                                                    alert("Verification Failed");
                                                                }

                                                            })
                                                    .fail(
                                                            function (
                                                                    jqXHR,
                                                                    textStatus,
                                                                    errorThrown) {
                                                                alert(textStatus);
                                                            });
                                        });

                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    var data = e.target.result;
                                    var base64 = data
                                            .replace(/^[^,]*,/, '');
                                    $("#pdfData").val(base64);
                                }

                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        $("#pdfFile").change(function () {
                            readURL(this);
                        });

                    });
</script>