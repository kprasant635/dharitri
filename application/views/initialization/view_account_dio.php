<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Disable this User?'))
            return (false);
        return (true);
    }
    function Confadd() {
        if (!confirm('Really want to Enable this User?'))
            return (false);
        return (true);
    }
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">All Other Users Accounts</h2>
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
                            <h6 class="red uni_text"><b>NOTE : Click on <span class="glyphicon glyphicon-pencil" aria-hidden="true" style='color: blue;'></span> 
                                    button to Reset Password (The Default password will be qwe@123) , <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span> 
                                    button to Disable User Account and <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style='color: green;'></span> button to Enable User Accounts.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold">Status</td>
                                    <td class="bold">Full Name</td>
                                    <td class="bold">Login Name</td>
                                    <td class="bold">Password</td>
                                    <td class="bold">Designation</td>
                                    <td class="bold">Reset Password</td>
                                    <td class="bold"><?php echo $this->lang->line('action'); ?></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                //var_dump($user_details);
                                if(empty($user_details))
                                {
                                    ?>
                                    <td colspan='7'>No Results Found. Select the location above.</td>
                                    <?php
                                }
                                else
                                {
                                    foreach ($user_details as $c) {
                                    if ($c['lot_no'] == '00') {
                                        $lot = '';
                                    } else {
                                        $lot_name=$this->utilityclass->getLotLocationName($c['dist_code'], $c['subdiv_code'], $c['cir_code'],$c['mouza_pargona_code'],$c['lot_no']);
                                        $lot = ', Lot : ' . $lot_name;
                                    }
                                    if ($c['mouza_pargona_code'] == '00') {
                                        $mouza_pargona_code = '';
                                    } else {
                                        $mouza_pargona_code = $this->utilityclass->getMouzaName($c['dist_code'], $c['subdiv_code'], $c['cir_code'],$c['mouza_pargona_code']);
                                    }
                                    if ($c['status'] == 'E') {
                                        $status = "<span style='color:green;'>Enabled</span>";
                                    } else {
                                        $status = "<span style='color:red;'>Disabled</span>";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo $c['name']; ?></td>
                                        <td><?php echo $c['primary_login']; ?></td>
                                        <td><?php echo "*****"//$c['password']; ?></td>
                                        <td><?php echo $c['desig']; ?></td>
                                        <td class="center">
                                            <a class='btn btn-info' href="<?php echo base_url() . 'index.php/initialization/reset_password?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Edit User">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Reset Password</a>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($c['status'] == 'E') {
                                                ?>
                                                <a onClick="return ConfDel()" href="<?php echo base_url() . 'index.php/initialization/disable_other_users?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Disable User"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span></a>
                                                <?php
                                            } else {
                                                ?>		
                                                <a onClick="return Confadd()" href="<?php echo base_url() . 'index.php/initialization/enable_other_users?user_code=' . $c['user_code'] . '&dist_code=' . $c['dist_code'] . '&subdiv_code=' . $c['subdiv_code'] . '&cir_code=' . $c['cir_code'] . '&mouza_pargona_code=' . $c['mouza_pargona_code'] . '&lot_no=' . $c['lot_no'] ?>" title="Enable User"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style='color: green;'></span></a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });
    
    $('.district_wdb').change(function (e) {
        var distCode = $(this).val();
        //alert("aa" + baseurl);
        console.log("aa" + baseurl);
        $.ajax({
            url: baseurl + "Utility/getSubdivJson_wdb/" + distCode,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                console.log(template);
                $('.subdivselect_wdb').html(template);
            }
        });
    });
    $('.subdivselect_wdb').change(function (e) {
        var subdivcode = $(this).val();
        var distcode = $('.district_wdb').val();
        $.ajax({
            url: baseurl + "Utility/getCirCodeJson_wdb/" + distcode + '/' + subdivcode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                console.log(template);
                $('.circleselect_wdb').html(template);
            }
        });
    });
</script>