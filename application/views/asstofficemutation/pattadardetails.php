<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php  echo $this->lang->line('pattadar_details_for_office_mutation') ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pattadar_details_for_field_mutation_of_dag') ?> <kbd>Dag No. <?php echo $dag; ?></kbd>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' id='pattadardetails' action="" name="officemutationpattadardetails" method="post">
                            <input type="hidden" id="current_dag" name="current_dag" value="<?php echo $dag; ?>"/>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 uni_text control-label"><?php  echo $this->lang->line('pattadar_no') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 uni_text control-label required"><?php  echo $this->lang->line('select_pattadar') ?></label>
                                <div class="col-sm-3">
                                    <select type="text" class="form-control pattadar_name" required name="pdar_name" id="pdar_name" >
                                        <option selected><?php  echo $this->lang->line('select_pattadar') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php  echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" class="form-control" required name="pdar_guardian" id="guardian_name" placeholder="<?php  echo $this->lang->line('guardian_name') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php  echo $this->lang->line('relation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="pdar_rel_guar" required="">
                                        <option selected disabled><?php  echo $this->lang->line('select_relation') ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php  echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add1" id="applicantNam" placeholder="<?php  echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php  echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="pdar_add2" id="applicantNam" placeholder="<?php  echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <center>
                                    <label class="control-label uni_text center red">Note* : Please Save Pattadars before proceeding to the next Stage</label>
                                    <div class="col-lg-12">
                                        <button type="submit" id='submitpartitionland' class="btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Pattadar</button>
                                        <?php
                                        $next = base_url() . "index.php/officemutation/registrationpetition";
                                        ?>
                                        <a href='<?php echo $next; ?>' class="btn btn-info"><i class='fa fa-check'></i>&nbsp;Proceed To Next Stage</a>

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




