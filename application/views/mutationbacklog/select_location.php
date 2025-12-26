<div class="row login form-top">

    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">

            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Location Select</li>
                <li class="secondtick">Applicant Details</li>
                <li class="thirdtick">Land Area</li>
                <li class="fourthtick">Pattadar Details</li>
            </ol>

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="<?php echo base_url()."index.php/mutationbacklog/mutationtype";?>">
                        <input name="mutationclass" value="office" id="mutationclass" type="hidden"/>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    
                                    <option value="<?php echo $d; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d); ?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d,$subdiv_code);?>
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                     <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                     <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($mouzas as $d):?>
                                    <option value='<?php echo $d->mouza_pargona_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="villageselect_office" required name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>

                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>