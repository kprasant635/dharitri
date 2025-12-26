<div class="row login form-top">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick"><?php echo $this->lang->line('select_location');?></li>
                <li class="secondtick"><?php echo $this->lang->line('applicant_details');?></li>
                <li class="thirdtick"><?php echo $this->lang->line('land_area');?></li>
                <li class="fourthtick"><?php echo $this->lang->line('pattadar_details');?></li>
            </ol>
                        
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_vill_town');?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="<?php echo base_url()."index.php/cofieldmutation/showLocation";?>">
                        <input name="mutationclass" value="field" id="mutationclass" type="hidden"/>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district');?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                     <?php $dist_code=$this->session->userdata('dist_code');?>
                                    <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                     <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle');?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
                                    <?php foreach($mouzas as $d):?>
                                    <option value='<?php echo $d->mouza_pargona_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('lot_no');?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('select_lot_no');?></option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('vill_town');?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="village_select_field" required name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select_vill_town');?></option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('application_no/dag');?></label>
                            <div class="col-lg-9">
                                <select class="form-control application_no" id="select" required name="application_no">
                                     <option disabled selected>Select/Town</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                 <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit');?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>