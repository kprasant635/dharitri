<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 " style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>Select Pattadar from the List</p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal'  action="<?php echo base_url(); ?>index.php/Backlogpartition/back_step_one" method="post">
                            
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('pattadar_no') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 uni_text control-label required"><?php echo $this->lang->line('select_pattadar') ?></label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control pattadar_name" required name="pdar_name" id="pdar_name" >
                                        <option selected><?php echo $this->lang->line('select_pattadar') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" class="form-control" required name="pdar_guardian" id="guardian_name" placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php echo $this->lang->line('relation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="pdar_rel_guar" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_relation') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




