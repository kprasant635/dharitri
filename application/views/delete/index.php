<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">           
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url()."index.php/partition/mutationtype";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('district'); ?></label>
                            <div class="col-lg-7">
                                <select class="form-control input-sm districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $d;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d);?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <div class="col-lg-7">
                                <select class="form-control subdivselect input-sm" id="select" name="subdiv_code" required>
                                   <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d,$subdiv_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                            <div class="col-lg-7">
                                <select class="form-control input-sm circleselect" id="select" required name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                            <div class="col-lg-7">
                                <select class="form-control input-sm mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach($mouzas as $d):?>
                                    <option value='<?php echo $d->mouza_pargona_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                            <div class="col-lg-7">
                                <select class="form-control input-sm lotselect" id="select" required name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                            <div class="col-lg-7">
                                <select class="form-control input-sm villageselect" id="select" required name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Dag Number</label>
                            <div class="col-lg-7">
								<input type="text"  class="form-control" name='dag_no' />
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Patta Number</label>
                            <div class="col-lg-7">
								<input type="text"  class="form-control" name='dag_no' />
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Patta Type</label>
                            <div class="col-lg-7">
								<input type="text"  class="form-control" name='dag_no' />
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Pattadar Id</label>
                            <div class="col-lg-7">
								<input type="text"  class="form-control" name='dag_no' />
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