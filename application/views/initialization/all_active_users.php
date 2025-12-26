<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">All Enabled Users</h2>
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
                            <h6 class="red uni_text"><b>NOTE : Please Select Locations from the drop down and select your circle. Note that already changed password will be shown as "*******".</b></h6>
                        </div>
                        <form class='form center no-trigger' method="POST" action="<?php echo base_url() . 'index.php/login/all_active_users' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('district'); ?> </label>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select class="form-control district_wdb" readonly id="select" name="dist_code" required>
                                    <option selected disabled>Select District</option>
									<?php foreach($district as $d): ?>
                                    <option value="<?php echo $d->district_code; ?>"><?php echo $d->district_name; ?></option>
									<?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control subdivselect_wdb" readonly id="select" name="subdiv_code" required>
                                    <option selected disabled>Select Sub-divsion</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control circleselect_wdb" readonly id="circlea" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo "View All The Users" ?></button>
                            </div>
                        </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td>Full Name</td>
                                    <td>Login Name</td>
                                    <td>Password</td>
                                    <td>Designation</td>
                                    <td>Circle</td>
                                    <td>Mouza (For LM Only)</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                //var_dump($user_details);
                                if(empty($user_details))
                                {
                                    ?>
                                    <td colspan='6'>No Results Found. Select the location above.</td>
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
                                    ?>
                                    <tr>
                                        <td><?php echo $c['name']; ?></td>
                                        <td><?php echo $c['primary_login']; ?></td>
                                        <td><?php echo $c['password']; ?></td>
                                        <td><?php echo $c['desig']; ?></td>
                                        <td><?php echo $this->utilityclass->getCircleName($c['dist_code'], $c['subdiv_code'], $c['cir_code']); ?></td>
                                        <td><?php echo $mouza_pargona_code . "" . $lot; ?></td>
                                    </tr>
                                    <?php
                                }
                                
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <p align='center' class="uni_text">
                        [ <a href="<?php echo base_url(); ?>index.php/login"><?php echo $this->lang->line('home'); ?></a> ]
                    </p>
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
                // if (debug) {
                    // console.log(data);
                // }
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