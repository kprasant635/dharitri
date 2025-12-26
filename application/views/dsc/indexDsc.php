<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url() ?>application/views/dsc/resources/js/dsc-signer.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>application/views/dsc/resources/js/dscapi-conf.js" type="text/javascript"></script>
    <!-- <link type="text/css" rel="stylesheet" href="<?= base_url() ?>application/views/dsc/resources/css/dsc-signer.css"> -->
</head>

<body>

    <div class="container-fluid form-top login">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="panel-heading">
                    <i class="fa fa-id-card" aria-hidden="true"></i> <span>Add/Modify
                        Digital Signature</span>
                </div>
                <div class="well">
                    <form id="dsc" class="form-horizontal" role="form">
                        <h4>Digital Signature</h4>
                        <div class="form-group" style="padding: 14px;">

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
                                    <label for="cert">Certificate</label>
                                    <textarea type="text" id="cert" name="cert" class="form-control input-sm" autocomplete="off" readonly="true" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <label for="sts">Status</label> <input type="text" id="sts" name="sts" class="form-control input-sm" autocomplete="off" readonly="true" /> <input type="hidden" id="pan" name="pan" class="form-control input-sm" autocomplete="off" readonly="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-md-12">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 5px;"><i class="fa fa-save"></i> Save/Update</button>
                                    <a href="" class="btn btn-success float-right" style="margin-top: 5px;"><i class="fa fa-refresh"></i> Refresh</a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {

        // $('#loadCert').click(function() {
        //     var serialNo = $('#serialNum').val();
        //     var cert = $('#cert').val();
        //     if (serialNo == "" && cert == "") {
        //         $.blockUI({
        //             message: '<h5><img src="<?= base_url() ?>application/views/dsc/resources/images/please-wait-fb.gif" /> Initializing NICDSign.Please Wait...</h5>'
        //         });
        //         // loaderBlockUI('Initializing NICDSign.Please Wait');
        //     }
        //     setTimeout(
        //         function() {
        //             if (serialNo == "" && cert == "") {
        //                 $(document).ajaxStop($.unblockUI);
        //                 getDSCDetails();
        //             }
        //         }, 3000);
        // });

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
    });

    // save update certificate details
    $("#dsc").submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?= base_url() ?>index.php/DigitalCertificate/add_update_dsc",
            method: 'post',
            data: $("#dsc").serialize(),
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="<?= base_url() ?>application/views/dsc/resources/images/please-wait-fb.gif" /> Saving/Updating digital signature certificate.Please Wait...</h5>'
                });
            },
            success: function(d) {
                $.unblockUI();
                var object = JSON.parse(d);
                if (object.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: object.msg
                    })
                } else if (object.status == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: object.msg + 'Error Code: ' + object.error_code
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgXhr = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msgXhr
                })
            }
        });
    });
</script>