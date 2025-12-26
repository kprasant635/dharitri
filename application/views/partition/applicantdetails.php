<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('applicant_details'); ?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal form_1 unicode' action="<?php echo base_url()."index.php/partition/ApplicantDetails" ?>"  method="post">
                            <input type="hidden" id="current_dag" value="<?=$this->session->userdata('dags');?>"/>
                            <fieldset><legend><?php echo $this->lang->line('petitioner_info');?></legend>
                                <div class="form_block"> 
                                <div class="hide form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" id='applicant_name_label'><?php echo $this->lang->line('serial_number'); ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Sl No">
										<?php echo form_error('pdar_cron_no', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label required"><?php echo $this->lang->line('applicants_name'); ?></label>
                                    <div class="col-sm-3">
                                        <select type="text" class="form-control pattadarop" name="pdar_name" > 
										 <option value=''>Select Pattadar</option> 
											<?php foreach($pattadar as $p) :?>
													<option value='<?=$p->pdar_id?>'><?=$p->pdar_name?></option>
											<?php endforeach; ?>										 
                                        </select>
										<?php echo form_error('pdar_name', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-3 control-label" id='applicant_name_label'><?php echo $this->lang->line('gender'); ?><i class="fa fa-star red"></i></label>
                                    <div class="col-sm-3">
                                        <select class="form-control pdar_gender" name="pdar_gender">
                                            <option value=''><?php echo $this->lang->line('select_gender'); ?></option>
											<?php foreach($gender as $g) :?>
													<option value='<?=$g->short_name?>'><?=$g->gen_name_ass?></option>
											<?php endforeach; ?>
                                        </select>
										<?php echo form_error('pdar_gender', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 required control-label"> <?php echo $this->lang->line('guardian_name'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pdar_guardian" id="guardian_name" placeholder="<?php echo $this->lang->line('guardian_name'); ?>">
										<?php echo form_error('guardian_name', '<p class="red">', '</p>'); ?>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('relation'); ?><i class="fa fa-star red"></i></label>
                                    <div class="col-sm-3">
                                        <select class="form-control relation-type" name="pdar_rel_guar">
                                            <option value=''><?php echo $this->lang->line('select_relation') ?></option>
                                            <?php foreach ($relation as $r): ?>
                                                <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                            <?php endforeach; ?>
                                        </select>
										<?php echo form_error('pdar_rel_guar', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('mothers_name'); ?> </label>
                                    <div class="col-sm-4">
                                       <input type="text" class="form-control pdar_mother" id="pdar_mother" name="pdar_mother" placeholder="<?php echo $this->lang->line('mothers_name'); ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control pdar_mobile" id="pdar_mobile" maxlength='10' name="pdar_mobile" placeholder="<?php echo $this->lang->line('mobile_no'); ?>">
										<?php echo form_error('pdar_mobile', '<p class="red">', '</p>'); ?>
                                    </div>
                                </div>
                                 <div class="form-group hide">
                                     <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('aadhar_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control pdar_aadhar" maxlength="12" id="pdar_aadhar"  name="pdar_aadhar" placeholder="<?php echo $this->lang->line('aadhar_no'); ?>">
                                    </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('nrc_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control pdar_nrc" id="pdar_nrc" maxlength="10"  name="pdar_nrc" placeholder="<?php echo $this->lang->line('nrc_no'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('pan_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control pdar_pan" id="pdar_pan" maxlength="10"  name="pdar_pan" placeholder="<?php echo $this->lang->line('pan_no'); ?>">
                                    </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('voter_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control pdar_voterID"  id="pdar_voterID" maxlength="10" name="pdar_voterID" placeholder="<?php echo $this->lang->line('voter_no'); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address1'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="pdar_add1" id="pdar_add1" placeholder="<?php echo $this->lang->line('address1'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address2'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="pdar_add2" id="pdar_add2" placeholder="<?php echo $this->lang->line('address2'); ?>">
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail3" class="col-sm-7 control-label"><?php echo $this->lang->line('remaing_land_exist_not'); ?>  </label>
                                    <div class="col-sm-2 ">
                                        <?php
                                        //echo $this->session->userdata('complete_patition_yn');
                                        if($this->session->userdata('complete_patition_yn')=='Y') { ?>
                                         <select class="form-control" name="Remain_Land">
                                            <option value="N"> <?php echo $this->lang->line('complete_patition_n')?> </option>
                                         </select>
                                        <?php }
                                        if($this->session->userdata('complete_patition_yn')=='N')
                                        {
                                        ?>
                                        <select class="form-control" name="Remain_Land">
                                            <option value=""> <?php echo $this->lang->line('select'); ?>  </option>
                                             <option value="Y"> <?php echo $this->lang->line('complete_patition_y')?>   </option>
                                            <option value="N"> <?php echo $this->lang->line('complete_patition_n')?>  </option>
                                         </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                        <button type="submit" class="submitbtn btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
						<?php 
						//var_dump($this->session->all_userdata());
						if($this->session->userdata('pdaridarray')!=null){
						?>
						<a href='<?php echo base_url() . "index.php/partition/saveApplicantDetails"; ?> '   class="pull-right 	btn btn-danger uni_text"><i class='fa fa-hand-o-right'></i> Click Here for Next Page >> </a>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>