<?php /* Author: Partha Sarathi, Dated-29/08/2018 */ ?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Update Revenue & Local Tax </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Utility
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2 class="red">Update Revenue & Local Tax of Particular Village Dag</h2>
                        <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/ControllerForRevenueUpdate/GetDags";?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control circleselect" id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('mouza') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control mouzaselect" id="select" name="mouza_code" required>
                                        <option disabled selected><?php echo $this->lang->line('select_mouza'); ?></option>
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
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('lot_no') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected><?php echo $this->lang->line('select_lot') ?></option>
                                    </select>
                                </div>  
                            </div>   
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text  control-label"><?php echo $this->lang->line('vill_town') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected><?php echo $this->lang->line('select_village') ?></option>
                                    </select>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">   
                            <div class="form-group">
                                <div class="col-sm-12 center" >
                                    <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>

                                    <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                    {?>
                                    You cannot procced as dag no is pending for property chain update... &nbsp;&nbsp; | &nbsp;&nbsp;
                                    <?php }else{?>
                                    <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?> & Save</button> &nbsp;&nbsp; | &nbsp;&nbsp;
                                    <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations" class="btn btn-sm btn-info"><i class='fa fa-link'></i>&nbsp;Click Here to Update Revenue based on Land Class</a>
                                <?php }?>
                                    <!--<a href="<?php //echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocationsVill" class="btn btn-sm btn-info"><i class='fa fa-link'></i>&nbsp;Click Here to Update Revenue of a Particular Village</a>-->
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

