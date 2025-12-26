
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" >
                <li class="progtrckr-done ">Select Location</li>
                <li class="progtrckr-done ">Transfer Type</li>
                <li class="progtrckr-done ">Applicant Details</li>
                <li class="progtrckr-done ">Land Area</li>
                <li class="progtrckr-done ">Pattadar Details Fes</li>
            </ol>
        </div>
    </div>

    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('applicant_details_for_field_mutation')?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <?php
                        $action = "";
                        if ($mut_type == '01') {
                            $action = base_url() . "index.php/lmmutation/pattadarDetailsFresh";
                        } else if ($mut_type == '02') {
                            $action = base_url() . "index.php/lmmutation/pattadarDetailsFresh";
                        }
                        ?>
                        <form class='form-horizontal no-trigger preventAjax' id='pattadardetails' 
                              action="<?php echo $action; ?>" 
                              method="post">
                                <input type="hidden" class="form-control" 
                                           name='' id="current_dag"  value="<?php echo $this->session->userdata('dag_no');?>">
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadar_no')?></label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value= <?php echo $pattadar_cron_no; ?> name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php if ($mut_type == '01'): ?>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_pattadar')?></label>
                                <?php else: ?>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('select_partition_applicants')?></label>
                                <?php endif; ?>

                                <div class="col-sm-4">

                                    <select type="text" onchange="$('#pdar_name').val($('#pdar_id option:selected').text())" 
                                    class="form-control pattadar_name" name="pdar_id" id="pdar_id" required>
                                        <option selected><?php echo $this->lang->line('select_pattadar')?></option>
                                        <?php foreach ($pattadars as $pattadar): ?>
                                            <option value='<?php echo $pattadar->pdar_id; ?>'><?php echo $pattadar->pdar_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" id='pdar_name' name="pdar_name"></input>
                                </div>
                                <?php if ($mut_type == '01'): ?>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('inplace_alongwith')?></label>
                                    <div class="col-sm-4">
                                        <select class="form-control inplace" name="striked_out" required>
                                            <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith')?></option>
                                            <option value="1"><?php echo $this->lang->line('inplace')?></option>
                                            <option value="0"><?php echo $this->lang->line('alongwith')?></option>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name')?></label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="100" class="form-control" name="pdar_guardian" id="guardian_name" placeholder="<?php echo $this->lang->line('guardian_name')?>" required>
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
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php echo $this->lang->line('address1')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2')?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php echo $this->lang->line('address2')?>">
                                </div>
                            </div>
                            <?php if ($mut_type == '02'): ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadars_land_share')?></label>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="6" class="form-control" name="pdar_dag_por_b" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('bigha')?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="1" class="form-control" name="pdar_dag_por_k" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('katha')?>">
                                    </div>
                                    <div class="col-sm-2  uni_text">
                                        <input type="text" maxlength="4" class="form-control" name="pdar_dag_por_lc" id="applicantNam" value="0" placeholder="<?php echo $this->lang->line('lessa')?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                                    <?php if ($pattadar_next): ?>
                                        <a href='<?php echo base_url(); ?>index.php/lmmutation/saveall' onclick="return confirm('Are you sure you want to submit this case')"
                                           class="btn btn-danger"><i class='fa fa-save'></i><?php echo $this->lang->line('save_all')?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




