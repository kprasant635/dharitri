<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php include 'message.php'; ?>
                    <?php endif; ?>
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url() . "index.php/partition/mutation"; ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                            <div class="col-lg-3">
                                <select class="form-control  districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $d; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d); ?>
                                    </option>
                                </select>
                            </div> 
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <div class="col-lg-3">
                                <select class="form-control subdivselect " id="select" name="subdiv_code" required>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <option value="<?php echo $subdiv_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d, $subdiv_code); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                            <div class="col-lg-3">
                                <select class="form-control  circleselect" id="select" required name="circle_code">
                                    <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                    <option value="<?php echo $cir_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d, $subdiv_code, $cir_code); ?>
                                    </option>
                                </select>
                            </div>

                            <label for="select" class="col-lg-3 required control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                            <div class="col-lg-3">
                                <select class="form-control  mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach ($mouzas as $d): ?>
                                        <option value='<?php echo $d->mouza_pargona_code; ?>'><?php echo $d->loc_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
								<?php echo form_error('mouza_code', '<p class="red">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                            <div class="col-lg-3">
                                <select class="form-control  lotselect" id="select" required name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
								<?php echo form_error('lot_no', '<p class="red">', '</p>'); ?>
                            </div>
                            <label for="select" class="col-lg-3 required control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                            <div class="col-lg-3">
                                <select class="form-control  villageselect" id="select" required name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
								<?php echo form_error('vill_code', '<p class="red">', '</p>'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?> <i class="fa fa-star red"></i> </label>
                            <div class="col-sm-3">
                                <select class="form-control pattatype_nmae" name="patta_type">
                                    <option value=''><?php echo $this->lang->line('patta_type'); ?> </option>
                                    <?php foreach ($pattatype AS $patta) { ?>
                                        <option value="<?php echo $patta->type_code; ?>"><?php echo $patta->patta_type; ?></option>
                                    <?php } ?>
                                </select>
								<?php echo form_error('patta_type', '<p class="red">', '</p>'); ?>
                            </div>
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_no'); ?>  <i class="fa fa-star red"></i></label>
                            <div class="col-sm-3">
                                <select class="form-control pattanoselect" id="select" required name="patta_no">
                                    <option>Select Patta</option>
                                </select>
								<?php echo form_error('patta_no', '<p class="red">', '</p>'); ?>
                            </div>
                        </div>
                        <hr>
						<!---------
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('recieving_officer'); ?><i class="fa fa-star red"></i></label>
                            <div class="col-sm-2">
                                <select class="form-control applied_to" name="applied_to">
                                    <OPTION value = "" selected>Select Option</OPTION>
                                    <OPTION value = "CO">CO</OPTION>
                                </select>
								
                            </div>
                            <div class="col-sm-3">
                                <select id="ss" name="COName" class="form-control">
                                    <option>Select Name</option>
                                </select>
								
                            </div>    
                        </div>
						------------->
						<div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required">Assign Officer</label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" id="applicantNam" required=""
                                            placeholder="Addressed To" name="add_of_name">
                                        <option selected disabled=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u->user_code; ?>"><?php echo $u->username; ?></option>
                                        <?php endforeach; ?>
                                    </select>
									<?php echo form_error('CO Name', '<p class="red">', '</p>'); ?>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('designation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_designation') ?></option>
                                        <option value="CO"><?php echo $this->lang->line('circle_officer') ?></option>
                                    </select>
                                </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('remark'); ?></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="topseal" rows="4" cols="5"> বাটোৱাৰা বিচাৰি আবেদন দাখিল  কৰিছে । </textarea>
								<?php echo form_error('topseal', '<p class="red">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-7 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary  uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>