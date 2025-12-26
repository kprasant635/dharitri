
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('pattadar_name_cancellation_first_party');?> </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?>  : <?php echo $this->session->userdata('misc_case_no'); ?> &nbsp;&nbsp;&nbsp;&nbsp;[<?php echo $this->lang->line('first_party_petitioner_name');?>]
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <span class="pdar_name">
                                <input type="hidden" class="form-control" name="petition_pdar_name_old" value=""/>
                            </span>
                            <hr/>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('petition_pattadar_name');?>  </label>
                                <div class="col-lg-3">
                                    <select class="form-control pdar_info" id="select" name="pdar_id" required >
                                        <option value="" selected><?php echo $this->lang->line('select_pattadar');?> </option>
                                        <?php foreach ($pdar_info AS $pdar) { ?>
                                            <option value="<?php echo $pdar->pdar_id; ?>"><?php echo $pdar->pdar_name; ?></option>                                       
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('guardian_name');?> </label>
                                <div class="col-lg-3 pdar_father">
                                    <input type="text" class="form-control" name="pdar_father" value="" placeholder="অপৰিচিত" />
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('relation');?></label>
                                <div class="col-lg-3 pdar_guard_reln">
                                    <input type="text" class="form-control" name="pdar_guard_reln" value="" placeholder="অপৰিচিত" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('address1');?></label>
                                <div class="col-lg-9 pdar_add1">
                                    <input type="text" class="form-control" name="pdar_add1"  placeholder="অপৰিচিত"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('address2');?></label>
                                <div class="col-lg-9 pdar_add2">
                                    <input type="text" class="form-control" name="pdar_add2" placeholder="অপৰিচিত">
                                </div>
                            </div>
                            <hr/>



                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button type="submit" name="ASTSTEP2Submit" class="btn btn-primary" ><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>

                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('reset');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/NameCancellation/ASTStep4" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp; <?php echo $this->lang->line('next');?>
                                    </a>
                                    <br/><br/>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

