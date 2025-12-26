
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="col-lg-8 col-lg-offset-2">
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Disposed Cases Display</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                
                <div id='form_error_html' style='color:red;text-align:center;'></div>
                
                <div class="panel-body">
                    
                    <form class="form-horizontal unicode" name="form" method='post' id='disposed-cases-form' action="<?php echo base_url() . 'index.php/disposed-cases/show' ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select  class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option value="<?php echo $dist_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select  class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <option value="<?php echo $subdiv_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <?php
                                $d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code);
                                ?>
                                <select  class="form-control circleselect" id="select" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                    <?php foreach ($d as $name) { ?>
                                        <option value="<?php echo $name->cir_code; ?>"  >
                                            <?php echo $name->loc_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="select" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label">Service</label>
                            <div class="col-lg-9">
                                <select class="form-control service_type_name" id="service_type" required="required" name="service_type">
                                    <option disabled="" selected="">Select Service</option>
                                    <option value="">NONE</option>
                                    <option value="field">FIELD PARTITION</option>
                                    <option value="office">OFFICE PARTITION</option>
                                    <option value="field_mut">FIELD MUTATION</option>
                                    <option value="office_mut">OFFICE MUTATION</option>
                                    <option value="allotment">ALLOTMENT</option>
                                    <option value="area_correction">AREA CORRECTION</option>
                                    <option value="land_reclassification">LAND RECLASSIFICATION</option>
                                    <!--<option value="name_correction">NAME CORRECTION</option>-->
                                    
                            </select>
                            </div>
                        </div>
                        <div class="panel-heading"><span class="panel-title">Select Date Range</span></div>
                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label">From Date:</label>
                            <div class="col-lg-4">
                                <input type="" class="form-control" id="popupDatepicker" name="fm-date">
                            </div>
                            <label for="select" class="col-lg-2 control-label">To Date:</label>
                            <div class="col-lg-4">
                            <input type="" class="form-control" id="popupDatepicker1" name="to-date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return submit_check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
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

        
<script>
    function submit_check(){
        event.preventDefault();
        $('#form_error_html').html('');
        
        var error = '';
        if($('.circleselect').val() == '' || $('.circleselect').val() == null){
            error += 'Please select Circle<br/>';
        }
        if($('.mouzaselect').val() == ''  || $('.mouzaselect').val() == null){
            error += 'Please select Mouza<br/>';
        }
        if($('.lotselect').val() == ''  || $('.lotselect').val() == null){
            error += 'Please select Lot<br/>';
        }
        if($('.villageselect').val() == ''  || $('.villageselect').val() == null){
            error += 'Please select Village<br/>';
        }
        if($('.service_type_name').val() == ''  || $('.service_type_name').val() == null){
            error += 'Please select Service<br/>';
        }
        if(error == ''){
            document.getElementById("disposed-cases-form").submit();    
        } else {
            $('#form_error_html').html(error);
        }
        
    }
    
</script>