<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_objection_head');?></h3>
                </div>
                <div class="panel-body">
				<marquee class='red hide'>Note : This Process will work only the case number registerd on dated  <?php echo define_date;?> or later on</marquee>
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url()."index.php/objection/registerobjection";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('district'); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $d;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d);?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                   <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d,$subdiv_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                            <div class="col-lg-5">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                            <div class="col-lg-5">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach($mouzas as $d):?>
                                    <option value='<?php echo $d->mouza_pargona_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                            <div class="col-lg-5">
                                <select class="form-control lotselect" id="select" required name="lot_no">
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
                            <div class="col-lg-5">
                                <select class="form-control villageselect" id="select" required name="vill_code">
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
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mutation_type'); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control "  name="mut_type" required>
                                    <option>Select Option</option>
                                    <?php foreach($order as $d) {?>
                                                <option value="<?php echo $d->order_type_code ?>" ><?php echo $d->order_type ?></option>
                                    <?php }?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                            <div class="col-lg-5">
                                <input class="form-control " required="" name='dag_no' />
                            </div> 
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                            <div class="col-lg-5">
                                <input class="form-control " required="" name='patta_no' />
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                            <div class="col-lg-5">
                               <select class="form-control" required name='patta_code'>
                                   <option class=""  id="select" required>Select Option</option>
                                    <?php foreach($patta_code as $p){ ?>
                                   <option  value="<?php echo $p->type_code ?>"><?php echo $p->patta_type ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="col-lg-5 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary  uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>