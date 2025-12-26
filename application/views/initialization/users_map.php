<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Users Mapping</h2>
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
                            <h6 class="red uni_text"><b>NOTE : Please Select Locations from the drop down and select your circle. </b></h6>
                        </div>
                        <form class='form center no-trigger' method="POST" action="<?php echo base_url() . 'index.php/login/userMapping' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('district'); ?> </label>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                            <label for="inputEmail3" class="col-sm-2 control-label">Type</label>
                            <label for="inputEmail3" class="col-sm-2 control-label">&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select class="form-control district_wdb" readonly id="select" name="dist_code">
                                    <option selected disabled>Select District</option>
									<?php foreach($district as $d): ?>
                                    <option value="<?php echo $d->district_code; ?>"><?php echo $d->district_name; ?></option>
									<?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control subdivselect_wdb" readonly id="select" name="subdiv_code">
                                    <option selected disabled>Select Sub-divsion</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control circleselect_wdb" readonly id="circlea" name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                </select>
                            </div>
							<div class="col-sm-2">
                                <select class="form-control" readonly  name="user_type">
                                    <option >Select User Type</option>
                                    <option >C</option>
                                    <option >S</option>
                                    <option >B</option>
                                    <option >A</option>
                                    <option >D</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" name="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo "View Users" ?></button>
                            </div>
                        </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
						<form method='post' action='<?php echo base_url() . 'index.php/login/userMappingUpdate' ?>'>	
						<table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td>User Name</td>
                                    <td>User Code</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($dharitree as $d): ?>
								<tr>
										<td ><?=$d->use_name?></td>
										<td ><?=$d->user_code?></td>
										<td>
											<select name='nocUname'>
												<?php foreach($noc as $n):?>
													<option value='<?=$n->usnm?>'><?=$n->nameoff?></option>
												<?php endforeach; ?>	
											</select> 
											<input type='text' value='<?=$d->use_name?>' name='useNameD' class='form-control ' />
											<input type='text' value='<?=$d->user_code?>' name='userCodeD' class='form-control ' />
										</td>
								</tr>
								<?php endforeach; ?>	
                            </tbody>
                        </table>
						<table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($noc as $n):?>
							   <tr>
										<td><?=$n->nameoff?></td>
										<td><?=$n->usnm?></td>
										
										</td>
								</tr>
								<?php endforeach; ?>	
                            </tbody>
                        </table>
						<center><input type='submit' class='btn btn-success' name='submit' value='Update' ></center>
						</form>
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
	// $('.dh').change(function (e) {
        // var name = $(this).val();
        // //var useName = $('.useName').val();
        // // var userCode = $('.userCode').val();
		// // alert(name);
		// // alert(userCode);
		// // alert(useName);
        // //var distcode = $('.district_wdb').val();
        // $.ajax({
            // url: baseurl + "Utility/getCirCodeJson_wdb/" + distcode + '/' + subdivcode,
            // success: function (data) {

            // }
        // });
    // });
</script>