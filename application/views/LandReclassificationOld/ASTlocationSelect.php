
<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: #fff; font-size: 34px"><?php echo $this->lang->line('list_of_plots_of_land_proposed_for_reclassification');?> </h2>
            </div>
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick"><?php echo $this->lang->line('select_location');?></li>
                <li class="secondtick"><?php echo $this->lang->line('transfer_type');?></li>
            </ol>
                        
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_vill_town');?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal" name="form" method='post' action="<?php echo base_url()."index.php/LandReclassification/ConvertionType";?>">
                        <div class="form-group">
                        <label class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district');?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle');?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" name="mouza_code">
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
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no');?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('select_lot_no');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town');?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="select" name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select_vill_town');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                 <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                 <button type="reset" class="btn btn-danger"><i class='fa fa-check'></i><?php echo $this->lang->line('back');?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>