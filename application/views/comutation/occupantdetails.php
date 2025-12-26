<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Field Mutation (Applicant Details)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('chitha_col8:_enter_occupant/applicant_of_details'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/cofieldmutation/saveOccupant'; ?>">
                            <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                            <input type="hidden" name='dist_code' value="<?php echo $dist_code; ?>"/>
                            <input type="hidden" name='subdiv_code' value="<?php echo $subdiv_code; ?>"/>
                            <input type="hidden" name='cir_code' value="<?php echo $cir_code; ?>"/>
                            <input type="hidden" name='mouza_pargona_code' value="<?php echo $mouza_pargona_code; ?>"/>
                            <input type="hidden" name='lot_no' value="<?php echo $lot_no; ?>"/>
                            <input type="hidden" name='vill_townprt_code' value="<?php echo $vill_townprt_code; ?>"/>
                            <input type='hidden' name='pdar_id' value="<?php echo $pdar_id; ?>"/>

                            <div class="form-group form-group-sm hide">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('occupant_id'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="occupant_id" value="<?php echo $occupant_id; ?>"/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('occupant_name'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name='occupant_name' value="<?php echo $petitioner->pet_name; ?>" />
                                </div>
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('guardian_name'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="occupant_fmh_name" value="<?php echo $petitioner->guard_name; ?>"/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('relation'); ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    $relation = 'unknown';
                                    $r_code = 'f';
                                    switch ($petitioner->guard_rel) {
                                        case 'f':
                                            $relation = $this->utilityclass->get_relation($petitioner->guard_rel);
                                            $r_code = 'f';
                                            break;
                                        case 'm':
                                            $relation = $this->utilityclass->get_relation($petitioner->guard_rel);
                                            $r_code = 'm';
                                            break;
                                        case 'h':
                                            $relation = $this->utilityclass->get_relation($petitioner->guard_rel);
                                            $r_code = 'h';
                                            break;
                                        case 'a':
                                            $relation = $this->utilityclass->get_relation($petitioner->guard_rel);
                                            $r_code = 'a';
                                            break;

                                        default:
                                            $relation = $this->utilityclass->get_relation($petitioner->guard_rel);
                                            $r_code = 'u';
                                            break;
                                    }
                                    ?>
                                    <input type="hidden" class="form-control" name="occupant_fmh_flag" value="<?php echo $r_code; ?>" readonly=""/>
                                    <input type="text" class="form-control" value="<?php echo $relation; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $petitioner->add1; ?>" name="occupant_add1" readonly=""/>
                                </div>
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('address2'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $petitioner->add2; ?>" name="occupant_add2" readonly=""/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm hide">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('address3'); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="" name="occupant_add3" readonly=""/>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text">Individual Land Area if Known of Defined.</h6>
                            </div>
                            <div class="form-group" style="margin: 10px;">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label red">Land Area : </label>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('bigha') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="land_area_b" value="<?php echo $petitioner->applied_b; ?>" readonly=""/>
                                </div>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('katha') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="land_area_k" value="<?php echo $petitioner->applied_k; ?>" readonly=""/>
                                </div>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('lessa') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="land_area_lc" value="<?php echo $petitioner->applied_lc; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="revenue" value="<?php echo $revenue->min_revenue; ?>" readonly=""/>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <button class="btn btn-warning" id='backtoLists'><i class="fa fa-arrow-left"></i> Back To Previous Case List(s)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#backtoLists').click(function(e){
        e.preventDefault();
        window.location.href=baseurl +'cofieldmutation/getPendingFMCases';
    });
</script>
