<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('pattadar_name_cancellation_second_party');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $this->session->userdata('misc_case_no'); ?> &nbsp;&nbsp;&nbsp;&nbsp; [<?php echo $this->lang->line('second_party_petitioner_name');?> ]
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Please Select the Name Of the Pattadar whose record have to be deleted from Database</b></h6>
							</div>
                            <hr/>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('petition_pattadar_name');?> </label>
                                <div class="col-lg-3">
                                    <select class="form-control pdar_info" id="select" name="pdar_id" required >
                                        <option value="" selected><?php echo $this->lang->line('select_pattadar');?></option>
                                        <?php foreach ($pdar_info AS $pdar) { ?>
                                            <option value="<?php echo $pdar->pdar_id; ?>"><?php echo $pdar->pdar_name; ?></option>                                      
                                        <?php } ?>
                                    </select>
									<?php echo form_error('pdar_id', '<p class="red">', '</p>'); ?>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('guardian_name');?></label>
                               <div class="col-lg-3 pdar_father">
                                    <input type="text" class="form-control" name="pdar_father" value="" placeholder="অপৰিচিত" />
									<?php echo form_error('pdar_father', '<p class="red">', '</p>'); ?>
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('relation');?></label>
                                <div class="col-lg-3 pdar_guard_reln">
                                    <select class="form-control" id="select" name="pdar_guard_reln" required >
                                        <option value="" selected><?php echo $this->lang->line('select_relation');?></option>
                                        <?php foreach ($relation AS $rel) { ?>
                                            <option value="<?php echo $rel->guard_rel; ?>"><?php echo $rel->guard_rel_desc; ?> [<?php echo $rel->guard_rel_desc_as; ?>]</option>                                       
                                        <?php } ?>
                                    </select>
									<?php echo form_error('pdar_guard_reln', '<p class="red">', '</p>'); ?>
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
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('remark');?></label>
                                <div class="col-lg-9 pdar_add2">
                                    <textarea name="opp_comment" class="form-control" rows="4"></textarea>
									<?php echo form_error('opp_comment', '<p class="red">', '</p>'); ?>								
                                </div>
                            </div>
                           <hr/>
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="ASTSTEP2Submit" class="btn btn-primary" ><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    
                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-info"><i class='fa fa-check'></i><?php echo $this->lang->line('reset');?></button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

