<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('list_of_plots_of_land_proposed_for_reclassification'); ?> </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('land_reclassification'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2><mark><?php echo $this->lang->line('present_dag_details'); ?></mark></h2>
                        <hr>
                        <form class='form-horizontal' method="post" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $Pcases->dag_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->patta_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['patta_type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['old_land_class']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_revenue, 2); ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_localtax, 2); ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('total_revenue'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_total_revenue, 2); ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('year_in_which_the_land_is_used_for_other_purpose'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->new_landuse_year; ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group alert alert-success">
                                <label for="inputEmail3" class="col-sm-4 control-label"><span class="ass-btn" style="line-height: 50px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?><?php echo $this->lang->line('land_area'); ?></span></label>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_b; ?>" readonly>
                                </div>

                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_k; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_lc, 2); ?>" readonly>
                                </div>
                                <!--<div class="col-sm-2">
                                    <p class="center bold"><?php //echo $this->lang->line('ganda');  ?></p>
                                    <input type="text" class="form-control" value="<?php //echo round($Pcases->dag_area_g, 2);   ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php //echo $this->lang->line('krantik');  ?></p>
                                    <input type="text" class="form-control" value="<?php //echo $Pcases->dag_area_kr;   ?>" readonly>
                                </div>-->
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('proposed_details'); ?></mark></h2>
                        <hr>
                        <form class='form-horizontal' method="post" action="<?php echo base_url(); ?>index.php/LandReclassification/SaveCoProcessRee">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('new_land_class'); ?></label>
                                <div class="col-sm-4">
                                    <select name="new_land_class" id="new_land_class" class="form-control" required>
                                        <option value="<?php echo $det['proposed_land_class_code']; ?>" selected><?php echo $det['proposed_land_class']; ?></option>
                                        <?php foreach ($land_class as $lnd_cls): ?>
                                            <option value="<?php echo $lnd_cls->class_code; ?>"><?php echo $lnd_cls->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="P_land_rev" class="form-control" value="<?php echo round($Pcases->proposed_land_revenue, 2); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="p_local_tax" class="form-control" value="<?php echo round($Pcases->proposed_land_localtax, 2); ?>">
                                </div>                                
                            </div>
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('revenue_difference'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->revenue_diff, 2); ?>" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('dc_recommendation');?></mark></h2>
                            <hr>
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><?php echo $Pcases->dc_approval; ?></h6>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group hide">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5" readonly> <?php echo $Pcases->co_recommendation; ?></textarea>
                                </div>
                            </div>
                            <h2><mark><?php echo $this->lang->line('circleofficers_recommendation_note');?></mark></h2>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_report" class="form-control" rows="5">  চক্র্ বিষয়াৰ প্রতিবেদন মৰ্মে মাটিৰ  শ্ৰেণী পৰিবৰ্ত্তনৰ  বাবে  হুকুম দিয়া হল । নথি সংশোধন  কৰা হওঁক  ।</textarea>
                                    <textarea name="co_report_suffix" class="form-control hidden" rows="5"><?php echo $location['co_name'].", ";?><?php echo "চক্র বিষয়া, ".$location['cir']; ?></textarea>
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-3">
                                    <button type="submit" class="btn btn-success" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                                    <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=" . $Pcases->proposal_no; ?>" class="btn btn-info" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_chitha'); ?>
                                    </a>
                                    <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=" . $Pcases->proposal_no; ?>" target="_blank" class="btn btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi'); ?>
                                    </a>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



