<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Json Data Sign</title>
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
        <div class="col-md-12">
            <div>
                <form id="form" method="POST" action="<?= base_url() ?>index.php/PropChainReport/dscUpdateTest">
                    <div class="form-group" style="padding: 14px;">
                        <h4>Details</h4>
                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="cname">Name</label> <input type="text" id="cname" name="cname" class="form-control input-sm" autocomplete="off" readonly="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="serialNum">Serial Number</label> <input type="text" id="serialNum" name="serialNum" class="form-control input-sm" autocomplete="off" readonly="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="validFrom">Valid from</label> <input type="text" id="validFrom" name="validFrom" class="form-control input-sm" autocomplete="off" readonly="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="validTo">Valid to</label> <input type="text" id="validTo" name="validTo" class="form-control input-sm" autocomplete="off" readonly="true" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="sts">Status</label> <input type="text" id="sts" name="sts" class="form-control input-sm" autocomplete="off" readonly="true" /> <input type="hidden" id="pan" name="pan" class="form-control input-sm" autocomplete="off" readonly="true" />
                            </div>
                        </div>

                        <div class="alert alert-info success_message" style="display: none;">
                            <strong><span id="success_msg_1">Signature Generated Successfully !</span></strong><span id="success_msg_2"> Please push data to property chain.</span>
                        </div>

                        <div class="row">
                            <div class="input-field col-md-12">
                                <label for="data">Data to Sign:</label><br />
                                <textarea class="form-control" placeholder="Enter any data to be signed here..." id="prop_data" name="prop_data" cols="50" rows="4" autocomplete="off" readonly="true" required><?= $property_data ?></textarea>
                                <br />
                            </div>
                        </div>


                        <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Certificate:</label><br />
                                <textarea class="form-control input-sm" id="cert" name="cert" cols="50" rows="4" autocomplete="off" readonly="true" required></textarea>
                                <br /> <input id="btnSign" type="button" value=" Sign " class="btn btn-success" />
                                <!-- <input id="btnDecryptVerifyWithCrt" type="button" value=" Decrypt & Verify with certificate " class="btn btn-danger" /> -->
                                <br />
                            </div>
                        </div>
                        <div class="buttondiv">
                            <span class="btn btn-success">
                                <i class="fa fa-pencil"></i> <input id="btnSign" type="button" value=" Sign Property Data " class="text-white" />
                            </span>
                        </div>

                        <!-- <div class="row">
                            <div class="input-field col-md-12">
                                <label for="cert">Certificate</label>
                                <textarea type="text" id="cert" name="cert" class="form-control input-sm" autocomplete="off" readonly="true" rows="5"></textarea>
                            </div>
                        </div> -->
                        <div class="row" style="display: none;">
                            <div class="input-field col-md-12">
                                <label for="data">Encrypted signature:</label><br />
                                <textarea class="form-control input-sm" id="lblSignature" cols="50" rows="8"></textarea></br>
                                <label for="data">Encrypted key:</label><br />
                                <textarea class="form-control input-sm" id="lblEncryptedKey" cols="50" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="submit" value="Submit">

                    <!-- <input id="push_data_to_prop_chain<?= $dag_no ?>" property-id="<?= $property_id ?>" prop-data="<?= $property_data ?>" type="button" value="Push to property chain" class="btn btn-primary" onclick="return createPropertyChain(<?= $dag_no ?>);" />  -->
                </form>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <label for="decryptedSignature">Decrypted Signature:</label> <br />
            <textarea placeholder="On clicking Decrypt and Verify button, the signature decrypted by DSCAPI server will be shown here..." id="decryptedSignature" cols="60" rows="8" disabled></textarea>
            <br /> <label for="verifiedSignature">Verification Data:</label> <br />
            <textarea placeholder="The signature verification result from DSCAPI server will be shown here..." id="verifiedSignature" cols="60" rows="8"></textarea>
        </div> -->
    </div>
    <div id="panel"></div>
    <script type="text/javascript">
        $(document).ready(function() {

            /////////////////////////////////////// get dsc details(start)////////////////////////////////////////////////////
            function getDSCDetails() {

                dscSigner.certificate(function(res) {
                    $('#cname').val(res.certificates[0].subject);
                    $('#pan').val(res.certificates[0].pan);
                    $('#serialNum').val(res.certificates[0].serialNumber);
                    $('#validFrom').val(res.certificates[0].notBefore);
                    $('#validTo').val(res.certificates[0].notAfter);
                    $('#cert').val(res.certificates[0].certificate);
                    $('#sts').val("ACTIVE");
                    $('#panel').hide();



                });
            }

            var serialNo = $('#serialNum').val();
            var cert = $('#cert').val();
            if (serialNo == "" && cert == "") {
                $.blockUI({
                    message: '<h5><img src="<?= base_url() ?>application/views/dsc/resources/images/please-wait-fb.gif" /> Initializing NICDSign.Please Wait...</h5>'
                });
            }
            setTimeout(
                function() {
                    if (serialNo == "" && cert == "") {
                        $(document).ajaxStop($.unblockUI);
                        getDSCDetails();
                    }
                }, 3000);

            //////////////////////////////////// get dsc details(end) //////////////////////////////////////////////////////



            var initConfig = {
                "preSignCallback": function() {
                    // do something before signing
                    // alert("Pre-sign event fired");
                    return true;
                },
                "postSignCallback": function(alias, sign, key) {
                    //do something after signing
                    $('#lblSignature').val(sign);
                    $('#lblEncryptedKey').val(key);

                    var property_signer_key = $('#property_signer_key').val(key);
                    // for push property chain 
                    if (property_signer_key != null) {
                        $('.buttondiv').hide();
                        $('.success_message').show();
                    } else {
                        $('.buttondiv').show();
                        $('.success_message').hide();
                    }


                },
                signType: 'data',

                //Set the cerificate serial number to skip certificate selection
                certificateData: $('#cert').val(),
                //Set the cerificate serial number to skip certificate selection
                //"certificateSno" : 13705892,
            };
            dscSigner.configure(initConfig);

            $('#cert').bind('input propertychange', function() {
                var initConfig = {
                    "preSignCallback": function() {
                        return true;
                    },
                    "postSignCallback": function(alias, sign, key) {
                        $('#lblSignature').val(sign);
                        $('#lblEncryptedKey').val(key);

                    },
                    signType: 'data',

                    //Set the cerificate serial number to skip certificate selection
                    certificateData: $('#cert').val(),
                    //Set the cerificate serial number to skip certificate selection
                    //"certificateSno" : 13705892,
                };
                dscSigner.configure(initConfig);
            });

            $('#btnSign').click(function() {
                $('#lblSignature').val('');
                $('#lblEncryptedKey').val('');
                var data = $("#prop_data").val();
                if (data != null || data != '') {
                    dscSigner.sign(data);
                }
            });




            // ucs-2 string to base64 encoded ascii
            function utoa(str) {
                return window.btoa(unescape(encodeURIComponent(str)));
            }
            // base64 encoded ascii to ucs-2 string
            function atou(str) {
                return decodeURIComponent(escape(window.atob(str)));
            }
        });
    </script>
</body>

</html>