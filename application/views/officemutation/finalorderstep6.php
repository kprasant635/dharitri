<div class="row login">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold rasid'><u><?php echo $this->lang->line('mutation_order_form');?> <span style='color: red;'>(Office Mutation Order Details)</span></u></p>
                </div>
            </div>
            <div class="panel-heading">
                <label class="col-sm-5 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                <label class="col-sm-2 rasid"><p class='bold uni_text text-center'>&nbsp;</p></label>
                <label class="col-sm-5 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y'); ?></label>
                <hr style="border-bottom: 2px solid #000;">
            </div>
            <div class="panel-body">
                <?php $action = base_url() . "index.php/coofficemutation/finalOrderStep6"; ?>
                <form class='form-horizontal' action="<?php echo $action; ?>" method="post">
                    <p class='bold uni_text text-center'>Along With / Inplace of Details</p>
                    <table class='table table-striped table-bordered' style="font-size: 20px;">
                        <tr>
                            <td><label>Pattadar Name</label></td>
                            <td><label>Gurdian Name</label></td>
                            <td><label>Relationship</label></td>
                            <td><label>Mutation Status</label></td>
                        </tr>
                    <?php 
                    if($data){
                            $button_css = '';
                            foreach($pattadars as $pattadar):
                            {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $count.". " ?><?php echo $pattadar->pdar_name; ?>
                                        <input type="hidden" class="form-control" name="alongwith_id[]" readonly="" value="<?php echo $pattadar->pdar_id; ?>" />
                                        <input type="hidden" class="form-control" name="alongwith_name[]" value="<?php echo $pattadar->pdar_name; ?>" >
                                    </td>
                                    <td>
                                        <?php echo $data->pdar_guardian; ?>
                                        <input type="hidden" class="form-control" name="alongwith_guardian[]" value="<?php echo $pattadar->pdar_guardian; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $this->utilityclass->get_relation($pattadar->pdar_rel_guar); ?>
                                        <input type="hidden" class="form-control" name="alongwith_rel_gur[]" value="<?php echo $pattadar->pdar_rel_guar; ?>" >
                                    </td>
                                    <td>	
                                        <select name="inplace_alongwith[]" class="form-control" required="">
                                            <option value="1" <?php
                                            if ($data->striked_out == '1') {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('inplace') ?></option>
                                            <option value="0" <?php
                                            if (($data->striked_out == '0') || ($data->striked_out == null) || ($data->striked_out == ' ')) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('along_with') ?></option>
                                        </select>
                                        
                                        <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                                        <input type="hidden" class="form-control" name="dist_code" value="<?php echo $data->dist_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $data->subdiv_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="cir_code" value="<?php echo $data->cir_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="mouza_pargona_code" value="<?php echo $data->mouza_pargona_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="lot_no" value="<?php echo $data->lot_no; ?>" readonly>
                                        <input type="hidden" class="form-control" name="vill_townprt_code" value="<?php echo $data->vill_townprt_code; ?>" readonly>
                                        <input type='hidden' name='dag_no' value='<?php echo $data->dag_no; ?>' />
                                        <input type='hidden' name='pdar_id' value='<?php echo $data->pdar_id; ?>' />
                                    </td>
                                </tr>
                                <?php
                                $count++;
                             }
                            endforeach;
                    } else {
                        $button_css = 'disabled';
                        ?>
                        <tr>
                            <td colspan="3"><label class="red">Seller Name ( Along With / Inplace of ) Details were not inserted during Registration. Insert Details now.</label></td>
                            <td><a href="<?php echo base_url(); ?>index.php/coofficemutation/ReAlongInplaceDetails?case_no=<?php echo $case_no.'&petition_no='.$petition_no; ?>" class="btn btn-success">
                                &nbsp; Insert Details Now
                            </a></td>
                        </tr>
                        <?php
                    }
                    ?>
                     </table>                  
                    <p class='bold uni_text text-center'><?php echo $this->lang->line('basic_order_details') ?></p>    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label"><?php echo $this->lang->line('order_no') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="ord_no" value="<?php echo $case_no; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" ><?php echo $this->lang->line('order_date') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="ord_date" value="<?php echo date('d-m-Y'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-bottom: 2px solid #000;">
                    <div class="col-lg-12">
                        <center>
                            <button type="submit" class="btn btn-primary" <?php echo $button_css;?>><i class='fa fa-check'></i>&nbsp; Pass Final Order</button>
                            <!--<a href="<?php echo base_url(); ?>index.php/coofficemutation/finalorderstep4?case_no=<?php echo $case_no; ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>-->
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>


