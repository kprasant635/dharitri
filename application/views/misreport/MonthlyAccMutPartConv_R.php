<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10  panel panel-default panel-body  col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e"> <?php echo $this->lang->line('monthly_account_of_mutation_partition_conversion_cases');?></h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_land_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/MisReportController1/saveMonthlyMutPartConv' ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('district');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control districtselect" readonly id="select" name="subdiv_code" required>
                                   <option selected disabled>Select District</option>
                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option value="<?php echo $dist_code; ?>" >
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-sm-4">
                                <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                     <option selected disabled>Select Sub-divsion</option>
                                </select>
                               
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('circle');?> </label>
                            <div class="col-sm-4">
                                <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                </select>
                               
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('year');?></label>
                            <div class="col-sm-4">
                                <select class="form-control " id="select" required name="year">
                                    <option disabled selected><?php echo $this->lang->line('select_year');?></option>
                                    <option>2022</option>
									<option>2021</option>
                                    <option>2020</option>
                                    <option>2019</option>
                                    <option>2018</option>
									<option>2017</option>
                                    <option>2016</option>
                                    <option>2015</option>
                                    <option>2014</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('month');?></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="select" required name="month_name">
                                    <option disabled selected><?php echo $this->lang->line('select_month');?></option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-5 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                <button id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
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
</script>