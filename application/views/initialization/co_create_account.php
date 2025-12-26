<style>
#password-rules {
    background: #f9f9fb;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px 15px;
    margin-top: 8px;
    font-size: 13px;
    color: #444;
}
#password-rules li.valid { color: #28a745; }
#password-rules li.invalid { color: #dc3545; }
#password-rules li span { width: 16px; display: inline-block; }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('create_new_user_profile');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('new_account'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <?php if($this->session->userdata('user_desig_code')=='DC'){?>

                            <div class="text-right">
                                <a target="blank" href="<?php echo base_url() . "index.php/initialization/srouser"; ?>" class="btn btn-success">
                                    <i class='fa fa-eye'></i>&nbsp;Create SRO user
                                </a>
                            </div>
                        <?php }?>

                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems">
                            <h6 class="red uni_text"><b>NOTE : The Password Created for these users will be Auto Generated.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <form class='form-horizontal' name="form" method="post" action="<?php echo base_url() . 'index.php/initialization/save_account' ?>">
                            <h2><mark><?php echo $this->lang->line('basic_details');?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('name');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Please enter name" name="name" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">( In Assamese )</label>
                            </div>
                            <div class="form-group alert-success">
                                <label for="inputEmail3" class="col-sm-2 control-label">Role Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control role" name="role">
                                        <option selected disabled>Select Role</option>
                                        <?php foreach ($privilege as $prev): ?>
                                            <option value="<?php echo trim($prev->priv_code); ?>"><?php echo $prev->priv_desc; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('status');?></label>
                                <label class="col-sm-2 rasid">
                                    <input type="radio" name="status" id="inlineRadio2" class="control-label" value="E" checked> <?php echo $this->lang->line('enable');?>
                                </label>
                                <label class="col-sm-2 rasid">
                                    <input type="radio" name="status" id="inlineRadio3" class="control-label" value="D" > <?php echo $this->lang->line('disable');?>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="designation" id="state">
                                        <option selected disabled>-- Select Type --</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('type');?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="type">
                                        <option value="O" Selected >স্থায়ী</option>
                                        <option value="P" >আনৰ শ্হলত</option>
                                        <option value="A">সংলগ্ন</option>
                                    </select>
                                </div>
                            </div>
                            <!--  <div class="form-group alert-success">
                                 <div class="col-lg-12 alert-success" style="margin: 0 auto;float: none;text-align: center">
                                     <label class="checkbox-inline uni_text bold">
                                         <input type="checkbox" id="inlineCheckbox1" name='noc' value="y">Does have access in NOC?
                                     </label>
                                     <label class="checkbox-inline uni_text bold">
                                         <input type="checkbox"  id="inlineCheckbox2" name="bhunaksha" value="y">Does have access in Bhunaksha?
                                     </label>

                                 </div>
                             </div> -->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Contact Number</label>
                                <div class="col-sm-4">
                                    <input type="number" maxlength="10" minlength="10" placeholder="Contact Number" class="form-control" name="phone_no" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('date_of_joining');?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control " readonly="" id="popupDatepicker" required name="date_of_joining">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email ID</label>
                                <div class="col-sm-4">
                                    <input type="email" placeholder="Email ID" class="form-control" name="emailID">
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('location_details');?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('district');?></label>
                                <div class="col-sm-2">
                                    <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                        <option value="">-- Select --</option>
                                        <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                    </select>
                                </div>

                                <label for="inputEmail3" class="col-sm-2 control-label" id="foo1" style="display:none;"><?php echo $this->lang->line('subdivision');?></label>
                                <div class="col-sm-2" id="foo2" style="display:none;">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value='00' selected><?php echo $this->lang->line('select_subdivision');?></option>
                                    </select>
                                </div>

                                <label for="inputEmail3" class="col-sm-2 control-label" id="foo3" style="display:none;"><?php echo $this->lang->line('circle');?></label>
                                <div class="col-sm-2" id="foo4" style="display:none;">
                                    <select class="form-control circleselect" id="cir" required name="circle_code">
                                        <option value='00' selected><?php echo $this->lang->line('select_circle');?></option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label" id="foo5" style="display:none;"><?php echo $this->lang->line('mouza');?></label>
                                <div class="col-sm-2" id="foo6" style="display:none;">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option value='00' selected><?php echo $this->lang->line('select_mouza');?></option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label" id="foo7" style="display:none;"><?php echo $this->lang->line('lot_no');?></label>
                                <div class="col-sm-2" id="foo8" style="display:none;">
                                    <select class="form-control lotselect" id="lot" required name="lot_no">
                                        <option value='00' selected><?php echo $this->lang->line('select_lot_no');?></option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label" id="foo11" style="display:none;"><?php echo $this->lang->line('sk');?></label>
                                <div class="col-sm-2" id="foo12" style="display:none;">
                                    <select class="form-control sk" id="select" required name="sk_name">
                                        <option value='' disabled selected>Select SK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group display_name">
                                <label for="inputEmail3" class="col-sm-2 control-label" >Display Name</label>
                                <div class="col-sm-10" >
                                    <textarea name='display_name' class="form-control" rows="3" placeholder="SDLC member full description"></textarea>
                                </div>
                            </div>
                            <div class="form-group sldc_role">
                                <label for="inputEmail3" class="col-sm-2 control-label" >SDLAC Type</label>
                                <div class="col-sm-4" >
                                    <select class="form-control" name="user_type">
                                        <?php if(ADD_SDLAC_MEM_STATUS_NC == 1): ?>
                                            <option value="">Select NC SDLAC/CDLAC Member Type</option>
                                            <option value="NC_MP">MP</option>
                                            <option value="NC_MLA">MLA</option>
                                            <option value="NC_SDLC">MEMBER</option>
                                        <?php else : ?>
                                            <option value="">Select SDLAC/CDLAC Member Type</option>
                                            <option value="MP">MP</option>
                                            <option value="MLA">MLA</option>
                                            <option value="SDLC">MEMBER</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('primary_login_details');?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><p style=" color: #ff0000;">Please Re-Type the Password Shown Below and Make sure the User Name is Valid.</p></label>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('user_name');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control " id="username" name='user_name'  onblur="return Checkusername();" required>
                                    <div id="username-msg"></div>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('password');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control " id="new_pass" name='new_pass' value="<?php echo $datas['auto_password'];?>">
                                    <div id="password-rules" class="small" style="color:#27A82E;">
                                        <ul >
                                            <li>Minimum length: <?= $policy['min_length'] ?> characters</li>
                                            <li>Maximum length: <?= $policy['max_length'] ?> characters</li>
                                            <?php if ($policy['require_uppercase']): ?>
                                                <li>At least one uppercase letter (A-Z)</li><?php endif; ?>
                                            <?php if ($policy['require_lowercase']): ?>
                                                <li>At least one lowercase letter (a-z)</li><?php endif; ?>
                                            <?php if ($policy['require_number']): ?>
                                                <li>At least one number (0-9)</li><?php endif; ?>
                                            <?php if ($policy['require_special']): ?>
                                                <li>At least one special character (<?= htmlspecialchars($policy['allowed_specials']) ?>)</li><?php endif; ?>
                                        </ul>
                                    </div>
                                    <div id="password-strength"></div>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('re_password');?></label>
                                <div class="col-sm-2">
                                    <input type="password" class="form-control " name='re_type_pass' onKeyUp="CheckPassword();">
                                </div>
                                <div id="msg_user_exists" style="float:left"></div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12 alert alert-warning rasid">
                                <div id="msg"></div>
                            </div>
                            <hr style='border-bottom: 2px solid #000;'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });

    $('#cir').change(function(e){
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

    $('.role').change(function (e) {
        var role = $(this).val();
        //alert(role);
        $.ajax({
            url: baseurl + "initialization/getDesignations/" + role,
            success: function (data) {
                console.log(data);
                var Designation = JSON.parse(data);
                var template = "<option selected disabled>-- Select Designation --</option>"
                for (var i = 0; i < Designation.length; i++) {
                    template += "<option value='"+Designation[i].user_desig_code+"'>"+ Designation[i].user_desig_as+"</option>"
                }
                console.log(template);
                $('.designation').html(template);
            }
        });
    });

    $("#state").change(function (e) {
        // foo is the id of the other select box 
        //alert ($(this).val());
        if(($(this).val().trim() == "SDLC") || ($(this).val().trim() == "NC")){
            $('.sldc_role').show();
            $('.display_name').show();
        }else{
            $('.sldc_role').hide();
            $('.display_name').hide();
        }
        if (($(this).val().trim() == "CDA") || ($(this).val().trim() == "AST") || ($(this).val().trim() == "CO")  || ($(this).val().trim() == "SK") || ($(this).val().trim() == "SA") || ($(this).val().trim() == "ASO") || ($(this).val().trim() == "DEO")) {
            $("#foo1").show();
            $("#foo2").show();
            $("#foo3").show();
            $("#foo4").show();
            $("#foo5").hide();
            $("#foo6").hide();
            $("#foo7").hide();
            $("#foo8").hide();
            $("#foo9").hide();
            $("#foo10").hide();
            $("#foo11").hide();
            $("#foo12").hide();
        }
        else if (($(this).val().trim() == "SDO") || ($(this).val().trim() == "RKG")  )
        {
            $("#foo1").show();
            $("#foo2").show();
            $("#foo3").hide();
            $("#foo4").hide();
            $("#foo5").hide();
            $("#foo6").hide();
            $("#foo7").hide();
            $("#foo8").hide();
            $("#foo9").hide();
            $("#foo10").hide();
            $("#foo11").hide();
            $("#foo12").hide();
        }
        else if (($(this).val().trim() == "LM"))
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
        }else if (($(this).val().trim() == "MOU"))
        {
            $("#foo1").show();
            $("#foo2").show();
            $("#foo3").show();
            $("#foo4").show();
            $("#foo5").show();
            $("#foo6").show();
            $("#foo7").hide();
            $("#foo8").hide();
            $("#foo9").hide();
            $("#foo10").hide();
            $("#foo11").hide();
            $("#foo12").hide();
        }
        else
        {
            $("#foo1").hide();
            $("#foo2").hide();
            $("#foo3").hide();
            $("#foo4").hide();
            $("#foo5").hide();
            $("#foo6").hide();
            $("#foo7").hide();
            $("#foo8").hide();
            $("#foo9").hide();
            $("#foo10").hide();
            $("#foo11").hide();
            $("#foo12").hide();
        }
    });
    const policy = {
        min_length: 8,
        require_uppercase: true,
        require_lowercase: true,
        require_number: true,
        require_special: true
    };

    document.getElementById('new_pass').addEventListener('input', function() {
        const pwd = this.value;
        let strengthMsg = [];
        
        if (pwd.length < policy.min_length) strengthMsg.push(`Min ${policy.min_length} chars`);
        if (policy.require_uppercase && !/[A-Z]/.test(pwd)) strengthMsg.push("1 uppercase");
        if (policy.require_lowercase && !/[a-z]/.test(pwd)) strengthMsg.push("1 lowercase");
        if (policy.require_number && !/[0-9]/.test(pwd)) strengthMsg.push("1 number");
        if (policy.require_special && !/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(pwd)) strengthMsg.push("1 special char");
        
        const strengthDiv = document.getElementById('password-strength');
        if (strengthMsg.length > 0) {
            strengthDiv.innerHTML = "<span style='color:red;'>Weak: " + strengthMsg.join(', ') + "</span>";
        } else {
            strengthDiv.innerHTML = "<span style='color:green;'>Strong password ✓</span>";
        }
    });    

    function CheckPassword()
    {
        //alert("dasd");
        var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
        var new_pwd = document.form.new_pass.value;
        var retype_pwd = document.form.re_type_pass.value;
        if (new_pwd === retype_pwd)
        {
            if(!retype_pwd.match(paswd))
            {
                document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Password should have 8 to 12 characters, at least 1 digit and 1 special character(!@#$%^&*).</p></label>";
            }
            else
            {
                Checkusername();
                document.getElementById("msg").innerHTML = "<button type=\"submit\"  id=\"btnhide\" class=\"btn btn-success\"><i class='fa fa-check'></i>&nbsp; Update User Profile </button>\n\
                        <a href=\"<?php echo base_url(); ?>index.php/home/index\" class=\"btn btn-danger\"><i class=\"fa fa-arrow-left\"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></a>";
                //document.getElementById("sub").visible="hidden";
                //startButton.disabled = false;
            }
        }
        else
        {
            document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Password Does Not Match.</p></label>";
        }
    }

    function Checkusername() {
        const usernamePolicy = {
            min_length: 8, // set your minimum length
            require_special: true,
            allowed_specials: "_-.@"
        };

        // Escape special regex chars properly
        function escapeRegex(str) {
            return str.replace(/[-[\]/{}()*+?.\\^$|]/g, '\\$&');
        }

        // Get raw input (not encoded)
        const username = document.getElementById("username").value.trim();
        const msgDiv = document.getElementById('username-msg');
        let errors = [];

        // 1️⃣ Minimum length check
        if (username.length < usernamePolicy.min_length) {
            errors.push(`Must be at least ${usernamePolicy.min_length} characters`);
        }

        // 2️⃣ Special character check
        const specialRegex = new RegExp('[' + escapeRegex(usernamePolicy.allowed_specials) + ']');
        if (usernamePolicy.require_special && !specialRegex.test(username)) {
            errors.push(`Must contain at least one special character (${usernamePolicy.allowed_specials})`);
        }

        // 3️⃣ Show validation message if invalid
        if (errors.length > 0) {
            msgDiv.innerHTML = `<span style="color:red;">${errors.join(', ')}</span>`;
            $("#msg_user_exists").hide();
            $("#btnhide").hide();
            return;
        }

        // 4️⃣ If valid format, check availability via AJAX
        msgDiv.innerHTML = `<span style="color:orange;">Checking availability...</span>`;
        $.ajax({
            url: baseurl + "initialization/getvalidusername/" + encodeURIComponent(username),
            dataType: 'json', // jQuery parses JSON automatically
            success: function (response) {
                if (response.exists === 1) {
                    msgDiv.innerHTML = `<span style='color:red;'>Username already taken ✗</span>`;
                    $("#msg_user_exists").show().html(
                        `<label class="col-sm-12 control-label"><p style="color:#ff0000;">User Exists. Please choose a new name</p></label>`
                    );
                    $("#btnhide").hide();
                } else {
                    msgDiv.innerHTML = `<span style='color:green;'>Username available ✓</span>`;
                    $("#msg_user_exists").hide();
                    $("#btnhide").show();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
                msgDiv.innerHTML = `<span style="color:red;">Error checking username</span>`;
            }
        });
    }

</script>