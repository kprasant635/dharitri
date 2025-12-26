<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e"> Monthly Statement on Citizen Centric Services</h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/MisReportController/MonthlyCitizenYearly' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control districtselect" readonly id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-sm-4">
                                <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('year');?></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="year" required name="select_yr">
                                    <option disabled selected><?php echo $this->lang->line('select_year');?></option>
                                    <option>2022</option>
									<option>2021</option>
                                    <option>2020</option>
									<option>2019</option>
                                    <option>2018</option>
                                    <option>2017</option>
                                    <option>2016</option>
                                    <option>2015</option>
                                </select>
                            </div>

                        </div>
                      
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button id="MainIndex" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu')?></button>
                            </div>
                        </div>
                    </form> 
					

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">   
	document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
    };
	var select = document.getElementById('year'),
						year = new Date().getFullYear(),
						html = '<option>Select Year</option>';
						for(i = year; i >= year-30; i--) {
						  html += '<option value="' + i + '">' + i + '</option>';
						}
						select.innerHTML = html;
   
</script>
