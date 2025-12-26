<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"> Generate Doul </h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal" name="form" method='post' action="<?php echo base_url()."index.php/GenerateDoul/DoulReport";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Year</label>
                            <div class="col-lg-9">
                                <select class="form-control" required name="year_no">
                                    <option value="2017">2017-18</option>
                                    <option value="<?php echo date("Y"); ?>">Current Year</option>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                 <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>