<div class="container-fluid form-top login">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('ap_cancellation');?></h2>
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
                        <form class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"  ><?php echo $this->lang->line('district');?></label>
                                <div class="col-lg-6" style="vertical-align: bottom;" >
                                    <input type="hidden" name="dist_code" class="districtselect" value="<?php echo $this->session->userdata('dist_code'); ?>"/>
                                    <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $dist[0]->district;?>"/>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('subdivision');?></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="subdiv_code" class="subdivselect" value="<?php echo $this->session->userdata('subdiv_code')?>"/>
                                    <input type="text" name="subd" class="form-control " readonly="readonly" value="<?php echo $subdiv[0]->subdiv; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('circle');?></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="circle_code" class="circleselect" value="<?php echo $this->session->userdata('cir_code')?>"/>
                                    <input type="text" name="cir" class="form-control " readonly="readonly" value="<?php echo $circle[0]->circle; ?>"/>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mouza');?></label>
                                <div class="col-lg-6">
                                   <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                        <?php foreach ($mouzalist AS $m) { ?>
                                                <option value="<?php echo $m->mouza_code; ?>"><?php echo $m->mouza; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('lot_no');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected><?php echo $this->lang->line('select_lot_no');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('vill_town');?></label>
                                <div class="col-sm-6">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected><?php echo $this->lang->line('select_vill_town');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-md btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

