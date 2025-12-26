
<div class="container-fluid" id="">
    <?php if ($this->session->flashdata('msg')) { ?>
        <div class="col-md-12 alert alert-success alert-dismissable text-center">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($this->session->flashdata('msg'), ENT_QUOTES, "utf-8"); ?>
        </div>
    <?php } ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-info panel-form" style="margin-top: 35px; margin-bottom: 40px">
            <div class="panel-heading">
                <h3 class="panel-title">DSC Registration</h3>
            </div>
            <div class="panel-body" style="background:linear-gradient(40deg,#45cafc,#fbff66) !important;">
                <form class='form-horizontal' action="<?php echo base_url().'index.php/Dsc/register_dsc'; ?>" method="post">
                    <div class="row clearfix m-t-10" >
                        <h4 style="margin-left: 5px;color: #fff"> Token Details </h4>

                        <div class="col-md-12">
                            <table class="table table-striped">

                                <tr>
                                    <td><b>Party Name :</b></td>
                                    <td><h5 class="card-title" id="cname1" ></h5></td>
                                    <td colspan="3"><b>Certificate Number :</b></td><td><h6 id="serialNum1" ></h6></td>
                                </tr>
                                <tr>
                                    <td><b>Issuer Name :</b></td>
                                    <td><p class="card-text badge" id="issuer_name1"></p></td>
                                    <td><b>Valid From :</b></td>
                                    <td><p class="card-text badge badge-primary" id="validFrom1"></p></td>
                                    <td><b>Valid To : </b></td>
                                    <td><p class="card-text badge badge-danger" id="validTo1"></p></td>
                                </tr>

                            </table>

                            <p><button type="button" class="btn btn-xs btn-warning waves-effect verify_certificate"><i class="fa fa-check-circle"></i><span>Verify Certificate</span></button></p><p>
                                <button type="button" class="btn btn-xs btn-success waves-effect VERIFIED"><i class="fa fa-check-square-o"></i><span>Certificate Verified</span></button></p>&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="row clearfix">
                        <input id="cname" type="hidden" class="form-control" value="<?php echo htmlentities(set_value('cname'), ENT_QUOTES, "utf-8"); ?>" name="cname" required="required" readonly/>
                        <input id="issuer_name" type="hidden" class="form-control" value="<?php echo htmlentities(set_value('issuer_name'), ENT_QUOTES, "utf-8"); ?>" name="issuer_name" readonly required="required"/>
                        <input type="hidden" class="form-control" name="serialNum" id="serialNum" value="<?php echo htmlentities(set_value('serialNum'), ENT_QUOTES, "utf-8"); ?>" readonly required="required"/>
                        <input type="hidden" class="form-control" name="validFrom" id="validFrom" value="<?php echo htmlentities(set_value('validFrom'), ENT_QUOTES, "utf-8"); ?>" readonly maxlength="16" required="required"/>
                        <input type="hidden" class="form-control" value="<?php echo htmlentities(set_value('Valid_to'), ENT_QUOTES, "utf-8"); ?>" name="validTo" id="validTo" readonly required="required"/>
                        <input type="hidden" id="user_id" name="userid" value="<?php echo htmlentities($this->session->userdata('user_id'),ENT_QUOTES) ?>">
                        <input id="cert" type="hidden" class="form-control" value="" name="cert"  />
                        <input type="hidden" class="form-control" value="<?php echo htmlentities(set_value('sts'), ENT_QUOTES, "utf-8"); ?>" name="sts" id="sts" required="required" readonly/>

                        <div class="row clearfix">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary waves-effect view_"><i class="fa fa-check"></i><span>Enroll</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.VERIFIED').hide();
    $('.view_').hide();
    $('.verify_certificate').on('click', function () {
        var certificateData = $('#cert').val();
        var data = {action: "VERIFY" , cert_data: certificateData};
        $.ajax({
            url: dscapibaseurl + "certificate",
            type: "post",
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify(data),
            async: false
        }).done(function (data) {
            // console.log(data);
            // console.log(atob(data.data));
            if (data.status_cd == 1) {
                var jsonData = JSON.parse(atob(data.data))
                if(jsonData.isvalid === 'Y'){
                    isCertificateValid = true;
                    alert('Certificate is valid.');
                    $('.VERIFIED').show();
                    $('.view_').show();
                    $('.verify_certificate').hide();
                    //$('.otp-div').hide();
                }
                else{
                    isCertificateValid = false;
                    alert('Kindly Insert Your DSC Before Verify The Certificate.');
                    // window.location.href = baseurl + "index.php/dsc/register_dsc";
                }
            } else {
                isCertificateValid = false;
                return false;
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            isCertificateValid = false;
            alert('Server Error, Please Wait...');
            $('.VERIFIED').hide();
            $('.view_').hide();
            $('.verify_certificate').show();
            //$('.otp-div').hide();
        });
    });



    function sendOTP(mobile_no) {
        $(".mobile_error").html("").hide();
        var number = mobile_no;
        if (number.length == 10 && number != null) {
            var input = {
                "mobile_number" : number,
                "action" : "send_otp"
            };
            $.ajax({
                url :  baseurl + 'index.php/Dsc/sendSms',
                type : 'POST',
                data : input,
                success : function(response) {
                    alert('OTP sent');
                    let timerOn = true;
                    $("#mobileOtp").show();
                }
            });
        } else {
            $(".mobile_error").html('Please enter a valid mobile number!')
            $(".mobile_error").show();
        }
    }

    function verifyOTP(otp) {


        $(".mobile_error").html("").hide();
        var input = {
            "otp" : otp,
            "action" : "verify_otp"
        };
        if (otp.length == 6 && otp != null) {
            $.ajax({
                url : baseurl + 'index.php/Dsc/sendSms',
                type : 'POST',
                dataType : "json",
                data : input,
                success : function(response) {
                    if(response.status == 1){
                        $("." + response.type).html(response.message)
                        $("." + response.type).show();
                        $('.view_').show();
                    }else{
                        $('.view_').hide();
                        $("." + response.type).hide();
                    }

                },
                error : function() {
                    alert("ss");
                }
            });
        } else {
            $(".mobile_error").html('You have entered wrong OTP.')
            $(".mobile_error").show();
        }
    }




    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('timer').innerHTML = m + ':' + s;
        remaining -= 1;

        if(remaining >= 0 && timerOn) {
            setTimeout(function() {
                timer(remaining);
            }, 1000);
            return;
        }

        if(!timerOn) {
            // Do validate stuff here
            return;
        }

        // Do timeout stuff here
        alert('Timeout for otp');
        var mno = $("#mobileNo").val();
        sendOTP(mno);
        $("#mobileOtp").hide();
    }

    timer(120);
</script>
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
            timer: 5000,
            showCancelButton: true

        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showConfirmButton: true,
        });
    }
</script>
    
