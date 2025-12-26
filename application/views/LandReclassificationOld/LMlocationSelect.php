<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"> <?php echo $this->lang->line('write_proposal_for_land_reclassification');?> </h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal" name="form" method='post' action="<?php echo base_url()."index.php/LandReclassification/LMConvertionType";?>">
                        <div class="form-group">
                            <label class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district');?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" >
                                    <?php $dist_code=$this->session->userdata('dist_code');?>
                                    <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" >
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle');?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select"  name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select"  name="mouza_code">
                                    <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                    <option value="<?php echo $mouza_code;?>"  selected>
                                        <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no');?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select"  name="lot_no">
                                    <?php 
                                    $lot_no=$this->session->userdata('lot_no');
                                    $lot_name=$this->utilityclass->getLotLocationName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no);
                                    ?>
                                    <option value="<?php echo $lot_no;?>"  selected>
                                        <?php echo $lot_name;?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town');?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="select"  name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
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