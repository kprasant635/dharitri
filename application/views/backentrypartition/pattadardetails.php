<script>
	$(function(){
                
                <?php if($pattadar_cron_no==1):?>
                    $('#myModal').modal();
                <?php endif;?>
	})
</script>
<div class="row form-top login">  
<?php //var_dump($this->session->all_userdata()) ?>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('pattadar_details_for_field_mutation_of_dag')?> <?php echo $dag;?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <?php $action =base_url() . "index.php/Backlogpartition/savePattadarForPartition";?>
                        <form class='form-horizontal no-trigger prevent_ajax' id='pattadardetails' 
                              action="<?php echo $action; ?>" 
                              method="post">
                            <input type="hidden" id="current_dag" name="current_dag" value="<?php echo $dag;?>"/>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadar_no')?></label>
                                <div class="col-sm-4">
                                    <input type="text" readonly class="form-control" value= <?php echo $pattadar_cron_no;?> name="pdar_cron_no" id="pdar_cron_no" placeholder="পট্টাদাৰ নং">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_partition_applicants') ?></label>
                                <div class="col-sm-4">
                                
                                    <select type="text" class="form-control pattadar_name" name="pdar_name" id="pdar_name" required>
                                        <option selected><?php echo $this->lang->line('select_pattadar')?></option>
                                        <?php foreach($pattadars as $pattadar):?>
                                        <option value='<?php echo $pattadar->pdar_id;?>'><?php echo $pattadar->pdar_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <?php if($mut_type=='01'):?>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('inplace_alongwith') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control inplace" name="striked_out" required>
                                        <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith')?></option>
                                        <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                                        <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
                                    </select>
                                </div>
                                <?php endif;?>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name')?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_guardian" id="guardian_name" placeholder="Guardian Name" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('relation')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="pdar_rel_guar" required>
                                        <option selected disabled><?php echo $this->lang->line('select_relation')?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="45" class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php echo $this->lang->line('address1')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="45" class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php echo $this->lang->line('address2')?>">
                                </div>
                            </div>
                            <?php if($mut_type=='02'):?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('pattadars_land_share')?></label>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="6" class="form-control" name="pdar_dag_por_b" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('bigha')?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="2" class="form-control" name="pdar_dag_por_k" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('katha')?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="4" class="form-control" name="pdar_dag_por_lc" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('lessa')?>">
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                                    
                                    <?php if($dag==-1):?>
                                    <a href='<?php echo base_url();?>index.php/Backlogpartition/back_step_two' class="btn btn-danger"><i class='fa fa-save'></i>dddddd</a>
                                       <?php else:?>
                                        <?php if($pattadar_cron_no > 1):?>
                                        <a class="btn btn-danger"  href="<?php echo base_url() . 'index.php/Backlogpartition/back_step_two'?>">
                                            <?php echo $this->lang->line('next')?>
                                            <?php endif;?>
                                        </a>
                                        
                                    <?php endif;?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

   

</script>


