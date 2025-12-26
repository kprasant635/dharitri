<script>
    $(function () {
        $('#userdet').click(function (e) {
               
            var result = confirm("Want to Update Primary Details?");
            if (result) {
                $('#formdetails').submit();
            }

        });
    });
    
    $(function () {
        $('#userlocation').click(function (e) {

            var result = confirm("Want to Update?");
            if (result) {
                $('#formlocation').submit();
            }
            
        });
    });
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('update_user_profile'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('users'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Basic Details and Location Details Cannot be Updated.</b></h6>
                        </div>
                        <form class='form-horizontal'>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('basic_details'); ?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="<?php echo $info['name']; ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group alert-success">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('role'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="role" value="<?php echo $info['role']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('status'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="status" value="<?php echo $info['status']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('designation'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="status" value="<?php echo $info['designation']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="designation_code" id="designation_code" value="<?php echo $info['designation_code']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('type'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="type" value="<?php echo $info['type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date_of_joining'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="joining_name" value="<?php echo $info['joining_date']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 hide control-label"><?php echo $this->lang->line('date_of_release'); ?></label>
                                <div class="col-sm-4 hide">
                                    <input type="text" class="form-control" name="relese_date" value="<?php echo $info['relese_date']; ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('location_details'); ?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="dist_code" value="<?php echo $info['dist_name']; ?>" readonly>
                                </div>
                                <?php
                                if ($info['subdiv_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="subdiv_code" value="<?php echo $info['subdiv_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($info['cir_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="cir_code" value="<?php echo $info['cir_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                if ($info['mouza_pargona_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="mouza_pargona_code" value="<?php echo $info['mouza_pargona_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($info['lot_no_code'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="lot_no" value="<?php echo $info['lot_no_code']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($info['sk_name'] != '00') {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('sk_name'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="" value="<?php echo $info['sk_name']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text">
                                <b>NOTE : Do You want to assign a new SK to the User. If Yes than 
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true" style='color: red;'></span> this Box. 
                                    <input type="checkbox" id="PartialOrFull" class="form-control" name="PartialOrFull" value="Y" style="float: right;margin-top: -30px !important;margin-right: -160px !important;"/></b>
                            </h6>
                        </div>
                        
                        <div id='new' style="display:none;">
                            
                            <form id='formlocation' class='form-horizontal' action="<?php echo base_url() . 'index.php/initialization/update_location' ?>">
                                <input type="hidden" class="form-control" name="dist_code_new" value="<?php echo $info['dist_code']; ?>" readonly>
                                <input type="hidden" class="form-control" name="subdiv_code_new" value="<?php echo $info['subdiv_code']; ?>" readonly>
                                <input type="hidden" class="form-control" name="circle_code_new" value="<?php echo $info['cir_code']; ?>" readonly>
                                <input type="hidden" class="form-control" name="mouza_code_new" value="<?php echo $info['mouza_pargona_code']; ?>" readonly>
                                <input type="hidden" class="form-control" name="lot_no_new" value="<?php echo $info['lot_no_code']; ?>" readonly>
                                <h2>
                                    <mark><?php echo $this->lang->line('change_primary_details'); ?></mark>
                                </h2>
                                <mark><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i> Make Sure You Select the same location as above Except The SK if its not assigned to any of the Lot Mondols.</mark>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                    <div class="col-sm-2">
                                        <select class="form-control districtselect" id="LmMutationSelectDistrict" name="" required>
                                            <option value='0'>-- Select District --</option>
                                            <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                        </select>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label" id="foo1" style="display:none;"><?php echo $this->lang->line('subdivision'); ?></label>
                                    <div class="col-sm-2" id="foo2" style="display:none;">
                                        <select class="form-control subdivselect" id="select" name="" required>
                                            <option value='00' selected>Select Sub-Division</option>
                                        </select>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label" id="foo3" style="display:none;"><?php echo $this->lang->line('circle'); ?></label>
                                    <div class="col-sm-2" id="foo4" style="display:none;">
                                        <select class="form-control circleselect" id="cir" required name="">
                                            <option value='00' selected>Select Circle</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label" id="foo5" style="display:none;"><?php echo $this->lang->line('mouza'); ?></label>
                                    <div class="col-sm-2" id="foo6" style="display:none;">
                                        <select class="form-control mouzaselect" id="select" required name="">
                                            <option value='00' selected>Select Mouza</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label" id="foo7" style="display:none;"><?php echo $this->lang->line('lot_no'); ?></label>
                                    <div class="col-sm-2" id="foo8" style="display:none;">
                                        <select class="form-control lotselect" id="lot" required name="">
                                            <option value='00' selected>Select Lot Number</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label" id="foo11" style="display:none;"><?php echo $this->lang->line('sk'); ?></label>
                                    <div class="col-sm-2" id="foo12" style="display:none;">
                                        <select class="form-control sk" id="select" required name="sk_name_new">
                                            <option value='' disabled selected>Select SK</option>
                                        </select>
                                    </div>
                                </div>
                                <center>
                                    <div class="col-sm-12">
                                        <input type="hidden" name="user_id" value="<?php echo $info['user_code']; ?>" >
                                    </div>
                                </center>
                                <br>
                            </form>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-2" style="margin-left: -9px;">
                                    <input type="button" id='userlocation' class="btn btn-success" value="Update SK Mapping"/>
                                </div>
                            </div>
                            <label id="mesg" class="col-sm-12 control-label">This is applicable only for Lot Mondol just to add their corresponding SK</label>
                            <hr style="border-bottom: 2px solid #000;">
                        </div>
                        
                        <form id='formdetails' class='form-horizontal' action="<?php echo base_url() . 'index.php/initialization/update_account1' ?>">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><b>NOTE : You are only allowed to modify the Name, User Name, Contact Number here. And to successfully do that you will be asked for that perticular users password. </b></h6>
                            </div>
                            <input type="hidden" class="form-control" name="dist_code_new" value="<?php echo $info['dist_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="subdiv_code_new" value="<?php echo $info['subdiv_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="circle_code_new" value="<?php echo $info['cir_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="mouza_code_new" value="<?php echo $info['mouza_pargona_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="lot_no_new" value="<?php echo $info['lot_no_code']; ?>" readonly>
                            <h2><mark><?php echo $this->lang->line('change_primary_details'); ?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="<?php echo $info['name']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mobile Number</label>
                                <div class="col-sm-4">
                                    <input type="number" id="phone_no" class="form-control" name="phone_no" value="<?php echo $info['phone_no']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('user_name'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" readonly name="username" value="<?php echo $info['user_name']; ?>" required>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="user_desig" value="<?php echo $info['designation_code']; ?>" >
                                    <input type="hidden" name="user_id" value="<?php echo $info['user_code']; ?>" >
                                </div>
                            </div>
                        </form>
                        <!-- <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-2" style="margin-left: -9px;">
                                <input type="button" id='userdet'  class="btn btn-success" value="<?php //echo $this->lang->line('update_primary_details'); ?>"/>
                            </div>
                        </div> -->

                        <?php if(OTP_MOBILE_UPDATE_ENABLE == 0){ ?>
                            <input type="button" id="userdet" class="btn btn-success" value="Update Primary Details"/>
                        <?php } ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-6" style="margin-left: -9px;">


                                <?php $class = ' style="display:block" '; ?>
                                <?php if(OTP_MOBILE_UPDATE_ENABLE == 1){ 
                                    $class = ' style="display:none" '; ?>
                                <div class="form-group otp_div">
                                        
                              
                                </div>
                                    <button type="button" name="getOtp" id="getOTP" onclick="getOtp()" class="btn btn-sm btn-danger"><i class="fa fa-check"></i> Get OTP</button>
                                    <button type="button" name="verifyOtp" id="verifyOtp" style="display:none" onclick="verifyOtp()" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Verify OTP</button>
                                    <span id="updatePrimaryButtonDiv"></span>
                                <?php } ?>
                                
                                


                            </div>
                        </div>






                        <hr style="border-bottom: 2px solid #000;">

                        <form class='form-horizontal hide' name="form" method="post" action="<?php echo base_url() . 'index.php/initialization/update_account' ?>">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><b>NOTE : You are only allowed to modify the User Password here.</b></h6>
                            </div>
                            <input type="hidden" class="form-control" name="dist_code_new" value="<?php echo $info['dist_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="subdiv_code_new" value="<?php echo $info['subdiv_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="circle_code_new" value="<?php echo $info['cir_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="mouza_code_new" value="<?php echo $info['mouza_pargona_code']; ?>" readonly>
                            <input type="hidden" class="form-control" name="lot_no_new" value="<?php echo $info['lot_no_code']; ?>" readonly>
                            <h2><mark><?php echo $this->lang->line('change_login_details'); ?></mark></h2>
                            <hr> 
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><p style=" color: #0093ff;">Password should have 8 to 12 characters, at least 1 digit and 1 special character(!@#$%^&*).</p></label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Old Password</label>
                                <div class="col-sm-2">
                                    <input type="hidden" class="form-control" id="hashed" name="oldpasswordhash" value="<?php echo $info['hashed_password_old']; ?>">
                                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" required placeholder="*****">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-2">
                                    <input type="password" class="form-control " id="new_pass" name='new_pass' required placeholder="*****">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('re_password'); ?></label>
                                <div class="col-sm-2">
                                    <input type="password" class="form-control " name='re_type_pass' id='re_type_pass' required placeholder="*****">
                                    <input type="hidden" name="user_id" value="<?php echo $info['user_code']; ?>" >
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 alert alert-warning rasid">
                                <div id="msg"></div>
                            </div>
                            <div class="form-group validate_question">
                                <label for="inputEmail3" class="col-sm-5 control-label">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="button" onclick="CheckPassword();" class="btn btn-success" value='<?php echo $this->lang->line('Validate_Password');?>'>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function showSuccessMessage(text) {
        Swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

        }

    function showErrorMessage(text) {
        Swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }


    function CheckPassword()
    {

        var old = document.getElementById("hashed").value;
        var retype_old = encodeURIComponent(document.getElementById("oldpassword").value).replace(/!/g, '%21');
        var paswd = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
        var new_pwd = document.getElementById("new_pass").value;
        var retype_pwd = document.getElementById("re_type_pass").value;

        $.ajax({
            url: baseurl + "initialization/getdohashedpassword/" + retype_old,
            //alert(url);
            success: function (d) {
                var hashcode = JSON.parse(d);
                //alert(hashcode);
                //alert (code);
                if (hashcode == old)//please cahnge this soon
                {
                    if (new_pwd == retype_pwd)
                    {
                        if (!retype_pwd.match(paswd))
                        {
                            $(".note").hide();
                            document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Password should have 8 to 12 characters, at least 1 digit and 1 special character(!@#$%^&*).</p></label>";
                        }
                        else
                        {
                            $(".validate_question").hide();
                            $(".validate_result").show();
                            $(".note").hide();
                            document.getElementById("msg").innerHTML = "<hr style='border-bottom: 2px solid #000;'>\n\
                        <button type=\"submit\" class=\"btn btn-success\"><i class='fa fa-check'></i>&nbsp; Update User Profile </button>\n\
                        <a href=\"<?php echo base_url(); ?>index.php/home/index\" class=\"btn btn-danger\"><i class=\"fa fa-arrow-left\"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></a><hr style='border-bottom: 2px solid #000;'>";
                        }
                    }
                    else
                    {
                        $(".note").hide();
                        document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">New Password Does Not Match.</p></label>";
                    }
                }
                else
                {
                    $(".note").hide();
                    document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Old Password Doesnot Match.</p></label>";
                }
            }
        });

    }
</script>

<script>
    $('#cir').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $(this).val();
        $.ajax({
            url: baseurl + "initialization/getSkName/" + distcode + '/' + subdivcode + '/' + circode,
            success: function (data) {
                // if (debug) {
                //     console.log(data);
                // }
                var sk = JSON.parse(data);
                var template = "<option selected value='00'>Select SK</option>";

                for (var i = 0; i < sk.length; i++) {
                    template += "<option value='" + sk[i].user_code + "'>" + sk[i].username + "</option>";
                }
                console.log(template);
                $('.sk').html(template);
            }
        });
    });



    $('#PartialOrFull').change(function () {
        var desig = document.getElementById("designation_code").value;// document.getElementById('').val();
        if (!this.checked)
        {
            //alert("not checked");
            $("#new").hide();
        }
        else
        {
            //alert("clicked");
            $('#new').show();
        }
        if ((desig == "LM"))
        {
            $("#foo1").show();
            $("#foo2").show();
            $("#foo3").show();
            $("#foo4").show();
            $("#foo5").show();
            $("#foo6").show();
            $("#foo7").show();
            $("#foo8").show();
            $("#foo9").show();
            $("#foo10").show();
            $("#foo11").show();
            $("#foo12").show();
            $("#mesg").hide();
        }
        else{
            $("#formlocation").hide();
            $("#userlocation").hide();
            $("#mesg").show();
        }
    });

    function getOtp(){
        var mobile_no = $('#phone_no').val();
        if(!mobile_no){
            showErrorMessage('Enter valid mobile no...');
            return;
        }
        $.ajax({
                type: "POST",
                url: baseurl+'SmsApiController/sendOTP',
                data: {mobile_no : mobile_no},
                dataType: "json",
            success: function (data) {
                console.log(data);
                if(data.responseType == 1 && data.code == '402'){
                    showSuccessMessage(data.msg);
                    $('#getOTP').hide();
                    $('#verifyOtpNumber').show();
                    $('.otp_div').html('<input type="text" class="form-control" maxlength="6" name="verifyOTPNumber" id="verifyOTPNumber" placeholder="Enter OTP here...">');
                    $('#verifyOtp').show();
                }else{
                    showErrorMessage(data.msg); 
                }
            },error: function (error) {
                showErrorMessage('Something went wrong.');
            }
              
        });
    }

    function verifyOtp(){
        var otp = $('#verifyOTPNumber').val();
        if(!otp){
            showErrorMessage('Enter valid OTP...');
            return;
        }
        $.ajax({
                type: "POST",
                url: baseurl+'SmsApiController/verifyOTP',
                data: {otp : otp},
                dataType: "json",
            success: function (data) {
                console.log(data);
                if(data.responseType == 2){
                    showSuccessMessage(data.msg);
                    $('#getOTP').hide();
                    $('#verifyOtpNumber').hide();
                    $('.otp_div').html('');
                    $('#verifyOtp').hide();
                    $('#updatePrimaryButtonDiv').html('<input type="button" id="userdet_update" class="btn btn-primary" value="Update Mobile No"/>');
                }else{
                    showErrorMessage(data.msg); 
                    $('#updatePrimaryButtonDiv').html('');
                }
            },error: function (error) {
                showErrorMessage('Something went wrong.');
            }
              
        });
    }

    
    $(document).on('click','#userdet_update', function () {
        $('#formdetails').submit();
    });
</script>