<script>
    $(function () {
        $('#userdet').click(function (e) {

            var old = document.getElementById("hashed").value;
            var code1 = prompt("Enter your password for Verification");
            var code = encodeURIComponent(code1).replace(/!/g, '%21');
            if (code === '')
            {
                alert("Sorry Please Enter Verification Password of this user..!");
                e.preventDefault();
            }
            else
            {
                $.ajax({
                    url: baseurl + "initialization/getdohashedpassword/" + code,
                    success: function (d) {
                        var hashcode = JSON.parse(d);
                        //alert(object);
                        //alert (code);
                        if (hashcode === old)//please cahnge this soon
                        {
                            //alert("here");
                            $('#formdetails').submit();

                        }
                        else
                        {
                            alert("Sorry Your Password doesnot Match..!");
                            e.preventDefault();
                        }
                    }
                });
            }


        });
    });
    
    $(function () {
        $('#userlocation').click(function (e) {

            var old = document.getElementById("hashed").value;
            var code1 = prompt("Enter your password for Verification");
            var code = encodeURIComponent(code1);

            if (code === '')
            {
                alert("Sorry Please Enter Verification Password of this user..!");
                e.preventDefault();
            }
            else
            {
                $.ajax({
                    url: baseurl + "initialization/getdohashedpassword/" + code,
                    success: function (d) {
                        var hashcode = JSON.parse(d);
                        //alert(object);
                        //alert (code);
                        if (hashcode === old)//please cahnge this soon
                        {
                            //alert("here");
                            $('#formlocation').submit();

                        }
                        else
                        {
                            alert("Sorry Your Password doesnot Match..!");
                            e.preventDefault();
                        }
                    }
                });
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
                        
                        
                        <form id='formdetails' class='form-horizontal' action="<?php echo base_url() . 'index.php/initialization/update_mobile_details' ?>">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><b>NOTE : You are only allowed to modify the Contact Number here. </b></h6>
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
                                    <input type="text" class="form-control" name="username" value="<?php echo $info['user_name']; ?>" required readonly>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="user_desig" value="<?php echo $info['designation_code']; ?>" >
                                    <input type="hidden" name="user_id" value="<?php echo $info['user_code']; ?>" >
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="button" id="userdet_update_mobile_no" class="btn btn-danger" value="Update Mobile No"/>
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
</script>

<script>

    
    $(document).on('click','#userdet_update_mobile_no', function () {
        $('#formdetails').submit();
    });


</script>
