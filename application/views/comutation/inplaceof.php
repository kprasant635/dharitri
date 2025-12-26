<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Field Mutation (Inplace Of Details)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('chitha_col8:_enter_occupant/Inplace_of_details');?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/cofieldmutation/saveInPlaceOf'; ?>" >
                            <input type='hidden' name='case_no' value="<?php echo $case_no;?>"/>
                            <input type="hidden" name='dist_code' value="<?php echo $dist_code; ?>"/>
                            <input type="hidden" name='subdiv_code' value="<?php echo $subdiv_code; ?>"/>
                            <input type="hidden" name='cir_code' value="<?php echo $cir_code; ?>"/>
                            <input type="hidden" name='mouza_pargona_code' value="<?php echo $mouza_pargona_code; ?>"/>
                            <input type="hidden" name='lot_no' value="<?php echo $lot_no; ?>"/>
                            <input type="hidden" name='vill_townprt_code' value="<?php echo $vill_townprt_code; ?>"/>
                            <div class="form-group form-group-sm">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('dag_no');?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="dag_no" value="<?php echo $pattadar->dag_no;?>"/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label">Inplace/Alongwith</label>
                                <div class="col-sm-3">
                                    <?php
                                        $strikedout = (trim($pattadar->striked_out)=='1')?'স্হলত':'লগত';
                                    ?>
                                    <input type="text" class="form-control" readonly="" name='inplace' value="<?php echo $strikedout;?> "/>
                                </div>
                                <label for="inputEmail3" class="col-sm-3 uni_text control-label"><?php echo $this->lang->line('along_with_name');?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="inplace_of_name" value="<?php echo $pattadar->pdar_name;?>"/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm hide">
                                <label for="inputEmail3" class="col-sm-3 uni_text control-label"><?php echo $this->lang->line('along_with_id');?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" readonly="" name="alongwith_id" value="<?php echo $alongwith_id;?>"/>
                                </div>
                            </div>
                            <div class="form-group form-group-sm hide">
                                <label for="inputEmail3" class="col-sm-3 uni_text control-label"><?php echo $this->lang->line('land_area_left');?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="" name="occupant_add2" placeholder="bigha" readonly=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="" name="occupant_add2" placeholder="katha" readonly=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="" name="occupant_add2" placeholder="lessa" readonly=""/>
                                </div>
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

