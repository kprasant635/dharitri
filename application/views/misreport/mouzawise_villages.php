<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="alert alert-dismissible alert-success">
                <h4>Mouza wise village List</h4>
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo $this->lang->line('select_land_location');?>
                    </h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/MisReportController1/mouzawise_villages1"; ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district');?></label>
                            <div class="col-lg-5">
                                <select class="form-control districtselect" id="select" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-lg-5">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle');?></label>
                            <div class="col-lg-5">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-lg-5">
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
                            <div class="col-lg-5 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>

                                <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>

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
        window.location="<?php echo base_url(); ?>index.php/MisReport/";
    };
</script>