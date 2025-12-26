<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm bg-info">
                    <h2 style="text-align: center;">
                        <?php 
                        if($this->session->userdata('ismultiple')==true){
                            $type_of_dag = "( Multiple Dag )";
                        }else{
                            $type_of_dag = "( Single Dag )";
                        }
                        
                        if($this->session->userdata('mut_type')==01){
                            echo "Field Mutation Transfer Type Form For ".$type_of_dag;
                        }else{
                            echo "Field Partition Transfer Type Form For ".$type_of_dag;
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pattadar_details_for_field_mutation_of_dag') ?> <?php echo $dag; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($pattadar_cron_no == 1): ?>
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><p>Enter Pattadar Details for Dag No  <?php echo $dag; ?>;</p></h6>
                            </div>
                        <?php endif; ?>
                        <?php
                        $action = "";
                        if ($mut_type == '01') {
                            $action = base_url() . "index.php/lmmutation/savePattadarDetails";
                        } else if ($mut_type == '02') {
                            $action = base_url() . "index.php/lmmutation/savePattadarForPartition";
                        }
                        ?>
                        <form class='form-horizontal no-trigger prevent_ajax' id='pattadardetails' action="<?php echo $action; ?>" method="post">
                            <input type="hidden" id="current_dag" name="current_dag" value="<?php echo $dag; ?>"/>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadar_no') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" readonly class="form-control" value= <?php echo $pattadar_cron_no; ?> name="pdar_cron_no" id="pdar_cron_no" placeholder="পট্টাদাৰ নং">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php if ($mut_type == '01'): ?>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_pattadar') ?></label>
                                <?php else: ?>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_partition_applicants') ?></label>
                                <?php endif; ?>
                                <div class="col-sm-3">
                                    <select type="text" class="form-control pattadar_name" name="pdar_name" id="pdar_name" required>
                                        <option selected><?php echo $this->lang->line('select_pattadar') ?></option>
                                        <?php foreach ($pattadars as $pattadar): ?>
                                            <option value='<?php echo $pattadar->pdar_id; ?>'><?php echo $pattadar->pdar_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if ($mut_type == '01'): ?>
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('inplace_alongwith') ?> </label>
                                    <div class="col-sm-3">
                                        <select class="form-control inplace" name="striked_out" required>
                                            <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith') ?></option>
                                            <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                                            <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_guardian" id="guardian_name" placeholder="Guardian Name" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('relation') ?></label>
                                <div class="col-sm-3">
                                    <select class="form-control relation-type" name="pdar_rel_guar" required>
                                        <option selected disabled><?php echo $this->lang->line('select_relation') ?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="45" class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="45" class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            <?php if ($mut_type == '02'): ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('pattadars_land_share') ?></label>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="6" class="form-control" name="pdar_dag_por_b" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('bigha') ?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="2" class="form-control" name="pdar_dag_por_k" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('katha') ?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="6" class="form-control" name="pdar_dag_por_lc" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('lessa') ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <center>
                                    <label class="control-label uni_text center red">Note* : Please Save Pattadars before proceeding to the next Stage</label>
                                    <div class="col-lg-12">
                                        <button type="submit" id='submitpartitionland' class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Pattadar</button>
                                        <?php if ($dag == -1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/lmmutation/saveall" disabled class="btn btn-primary" onclick="return confirm('Are you sure you want to submit this case')">
                                                <i class="fa fa-arrow-check"></i>&nbsp;<?php echo $this->lang->line('save_all') ?>
                                            </a>
                                            <?php else: ?>
                                            <?php if ($pattadar_cron_no > 1): ?>
                                            <a href='<?php echo base_url() . 'index.php/lmmutation/pattadardetails?inc=1' ?>'  class="btn btn-primary">
                                                <i class='fa fa-check'></i>&nbsp;
                                                <?php if (!$this->session->userdata('isMutiple')): ?>
                                                    <?php echo "Proceed To Next Stage"; ?>
                                                <?php else: ?>
                                                    <?php echo "Continue With Next Dag"; ?>
                                                <?php endif; ?>
                                            </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                    </div>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


