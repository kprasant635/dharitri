<script>
    $(document).ready(function () {
        $('#myModalsara').modal({backdrop: 'static', keyboard: false}) 
    });
    
    function Checkusername()
    {
        var newusername = encodeURIComponent(document.getElementById("username").value);
        //var newusername = encodeURIComponent(document.form.username.value);
        //alert (newusername);
        $.ajax({
            url: baseurl + "initialization/getvalidusername/" + newusername,
            //alert(url);
            success: function (d) {
                var usercount = JSON.parse(d);
                //alert(usercount);
                //alert (code);
                if (usercount > '0')//please cahnge this soon
                {
                    document.getElementById("msg_user_exists").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-9 control-label\"><p style=\" color: #ff0000; align:center\">User Exists. Please give any New Name</p></label>";
                }
                else
                {
                    $("#msg_user_exists").hide();
                }
            }
        });
    }
    function CheckPassword()
    {
        var old = document.getElementById("hashed").value;
        var retype_old = encodeURIComponent(document.getElementById("oldpassword").value);
        var paswd = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
        var new_pwd = document.getElementById("new_pass").value;
        var retype_pwd = document.getElementById("re_type_pass").value;
        //alert(retype_old);
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
                            document.getElementById("msg").innerHTML = "<button type=\"submit\" class=\"btn btn-success btn-block\"><i class='fa fa-check'></i>&nbsp; Change Password and Username Now</button>";
                            //document.getElementById("sub").visible="hidden";
                            //startButton.disabled = false;
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
<!-- Modal HTML -->
<div id="myModalsara" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title center" style="color: #b92065;font-weight: bold !important;">Welcome <?php echo $my_info->username; ?></h4>
            </div>
            <form class='form-horizontal' name="form" method="POST" action="<?php echo base_url() . 'index.php/initialization/firstloginpasswordchange' ?>">
                <div class="modal-body">
                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                        <h6 class="red uni_text"><b>NOTE : Please Change Your Password ( Mandatory ).</b></h6>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('user_name'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" id="username" onblur="return Checkusername();" value="<?php echo $my_info->use_name; ?>" required>
                        </div>
                        <div id="msg_user_exists"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Old Password</label>
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" id="hashed" name="oldpasswordhash" value="<?php echo $my_info->hashed_password; ?>">
                            <input type="password" class="form-control checkname" id="oldpassword" name="oldpassword" required placeholder="*****">
                        </div>
                        <label for="inputEmail3" class="col-sm-4 control-label">New Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control " id="new_pass" name='new_pass' required placeholder="*****">
                        </div>
                        <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('re_password'); ?></label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control " name='re_type_pass' id='re_type_pass' required placeholder="*****">
                            <input type="hidden" name="user_id" value="<?php echo $my_info->user_code; ?>" >
                        </div>        
                    </div>
                    <div class="form-group validate_question">
                        <label for="inputEmail3" class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-6">
                            <input type="button" onclick="CheckPassword();" class="btn btn-success" value='<?php echo $this->lang->line('Validate_Password');?>'>
                        </div>
                    </div>
                    <div class="form-group validate_result" style="display:none">
                        <label for="inputEmail3" class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-8">
                            <label for="inputEmail3" class="control-label green">OK...! Password has been Validated.</label>
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                </div>
                <div class="modal-footer">
                    <label for="inputEmail3" class="col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-8n center">
                        <div id="msg"></div>
                    </div>
                    <label for="inputEmail3" class="col-sm-12 control-label note">
                        <p style="color: #0093ff;font-size: 13px;">Password should have 8 to 12 characters, at least 1 digit and 1 special character(!@#$%^&*).</p>
                    </label>
                    <hr style="border-bottom: 2px solid #000;">
                </div>
            </form> 
        </div>
    </div>
</div>