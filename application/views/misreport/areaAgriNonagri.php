<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: #2e4d8e"> Area of Agricultural and Non-Agricultural Land</h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_land_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/MisReportControllerPartha/saveAreaAgriNonAgri' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option readonly value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-sm-4">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-sm-4">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
									<option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                    <?php foreach ($mouza as $moz): ?>
											<?php
											$mouza_code = $moz->mouza_pargona_code;
											$mouza_name = $moz->loc_name;
											?>
											<option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
										<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('from');?></label>
                            <div class="col-sm-2">
                                <select class="form-control" id="year" required name="start_year">
                                    <option  selected><?php echo $this->lang->line('select_year');?></option>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-1 control-label"><?php echo $this->lang->line('to');?></label>
                            <div class="col-sm-2">
                                <select class="form-control" id="upyear" required name="end_year">
                                    <option  selected><?php echo $this->lang->line('select_year');?></option>
                                </select>
                            </div>

                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-5 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/MisReport"><i class='fa fa-home'></i> <?php echo $this->lang->line('back_to_main_menu') ?></a>
							</div>
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    var select = document.getElementById('year'),
    year = new Date().getFullYear(),
    html = '<option>Select Year</option>';
	for(i = year; i >= year-30; i--) {
	  html += '<option value="' + i + '">' + i + '</option>';
	}
	select.innerHTML = html;	
        
    var select = document.getElementById('upyear'),
    year = new Date().getFullYear(),
    html = '<option>Select Year</option>';
	for(i = year; i >= year-30; i--) {
	  html += '<option value="' + i + '">' + i + '</option>';
	}
	select.innerHTML = html;
</script>
