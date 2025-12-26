	<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Registration For Name Cancellation </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Please Select the Name Of the Pattadar whose applying for records deletion.</b></h6>
                        </div>
                        <form class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark>First Party <?php echo $this->lang->line('pattadar_details'); ?></mark></h2>
                            <hr>
							<input type='checkbox' value="1" id='showhide' /> <span class='uni_text red'>Please click Here if Pattadar Not exist</span>
							<div class='exist'>
							<div class="form-group">
                                            <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('pattadar_name');?> </label>
                                            <?php //var_dump($pdar_info); ?>
                                            <div class="col-lg-4">
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
                                <label for="inputEmail" class="col-lg-3 control-label">Selected Pattadar Name </label>
                                <div class="col-lg-4 pdar_name">
                                    <input type="text" class="form-control" name="petition_pdar_name_old" placeholder="অপৰিচিত" readonly value=""/>
									<?php echo form_error('petition_pdar_name_old', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('guardian_name');?></label>
                               <div class="col-lg-3 pdar_father">
                                    <input type="text" readonly class="form-control" name="pdar_father" value="" placeholder="অপৰিচিত" />
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
                               <div class="col-lg-4 pdar_add1">
                                   <input type="text" class="form-control" name="pdar_add1"  placeholder="অপৰিচিত" readonly/>
                                </div>
                           </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('address2');?></label>
                                <div class="col-lg-4 pdar_add2">
                                    <input type="text" class="form-control" name="pdar_add2" placeholder="অপৰিচিত" readonly/>
                                </div>
                            </div>
							</div>
							<!---
							<div class='non-exist'>
								<div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label">Type Pattadar Name </label>
                                <div class="col-lg-4 pdar_name">
                                    <input type="text" class="form-control" name="pdar_id" value="1" />
                                    <input type="text" class="form-control" name="petition_pdar_name_old" placeholder="অপৰিচিত" />
									<?php echo form_error('petition_pdar_name_old', '<p class="red">', '</p>'); ?>
                                </div>
                            </div>
							</div>
							----->
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="ASTSTEP2Submit" class="btn btn-success" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
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
<script>
$(".non-exist").hide();
$("#showhide").click(function() {
    if($(this).is(":checked")) {
        $(".exist").hide();
        $(".non-exist").show();
    } else {
        $(".exist").show();
		$(".non-exist").hide();
    }
});
</script>

