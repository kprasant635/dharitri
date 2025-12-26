<div class="row login">       
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Jamabandi Edit Entry Module</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>                       
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location') ?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <?php
                                    if ($this->session->userdata('subdiv_code') == '00') {
                                        ?>
                                        <option  disabled>Select District</option>
                                        <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                        <option selected value="<?php echo $dist_code; ?>" >
                                            <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                        </option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $d; ?>"  selected>
                                            <?php echo $this->utilityclass->getDistrictName($d); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <?php
                                    $subdiv_code = $this->session->userdata('subdiv_code');
                                    if ($subdiv_code == '00') {
                                        ?>
                                        <option selected disabled>Select Sub-divsion</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $subdiv_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getSubDivName($d, $subdiv_code); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <?php
                                    $cir_code = $this->session->userdata('cir_code');
                                    if ($cir_code == '00') {
                                        ?>
                                        <option selected disabled>Select Circle</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $cir_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getCircleName($d, $subdiv_code, $cir_code); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('mouza'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach ($mouza as $d): ?>
										<option value='<?php echo $d->mouza_pargona_code; ?>'><?php echo $d->loc_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" required name="lot_no">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="select" required name="vill_code">
                                    <option disabled selected>Select Village/Town</option>

                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control" name="patta_type_code" required>
                                    <option selected disabled>Patta Type</option>
                                    <?php foreach ($patta_types as $pt): ?>
                                        <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_no') ?></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="patta_no" required >
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>