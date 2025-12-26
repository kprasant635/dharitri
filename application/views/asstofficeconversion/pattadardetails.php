<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('applicant_details_for_field_conversion'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pattadar / Applicants
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Select Gender and Relation for each Pattadar. Its Mandatory.</b></h6>
                        </div>
                    <form class='form-horizontal unicode' action="<?php echo base_url() . "index.php/AsistantMutationPartha/reportconvertion"; ?>"  method="post">
                        <?php
                        $i = 1;
                        foreach ($pdtails as $pd):
                            ?>
                            <fieldset><legend class='red uni_text'>Petitioner No <?php echo $i; ?></legend>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <input type="hidden" readonly class="form-control" name="pdar_cron_no[]" value="<?php echo $i; ?>">
                                        <input type="hidden" readonly class="form-control" name="pdar_id[]" value="<?php echo $pd->pdar_id; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('petitioner_name'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" readonly class="form-control" name="pdar_name[]" value="<?php echo $pd->pdar_name; ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('gender'); ?><span class="red">*</span></label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="gender[]" required>
                                            <option selected value="">-- <?php echo $this->lang->line('select_gender'); ?> --</option>
                                            <option value="M" ><?php echo $this->lang->line('male'); ?></option>
                                            <option value="F" ><?php echo $this->lang->line('female'); ?></option>
                                            <option value="T" ><?php echo $this->lang->line('transgender'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('guardian_name'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pdar_guardian[]" value="<?php echo $pd->pdar_father; ?>" placeholder="Guardian Name">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('relation'); ?><span class="red">*</span></label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="guard_rel[]" required>
                                            <option value="" selected><?php echo $this->lang->line('guardian_name'); ?></option>
                                            <?php foreach ($relation as $r): ?>
                                                <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('mothers_name'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control asm" name="mothers_name[]" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="mobile_number[]" placeholder="<10 digit mobile number>" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('nrc_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="nrc_no[]" id="pdar_add2" placeholder="NRC Number" >
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('adhar_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="aadhar_no[]" id="pdar_add1" placeholder="<12 digit aadhar number>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('pan_no'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pan_no[]" id="pdar_add1" placeholder="eg : AAAPL1234C" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('voter_id'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="voter_id[]" id="pdar_add2" placeholder="<10 digit voter ID number>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address1'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pdar_add1[]" id="pdar_add1" placeholder="Address Line 1">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address2'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pdar_add2[]" id="pdar_add2" placeholder="Address Line 2">
                                    </div>
                                </div>
                            </fieldset>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php
                            $i = $i + 1;
                        endforeach;
                        ?>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 uni_text control-label" style="color: #990000;">পুৰনা দাগত আবেদনকাৰীৰ মাটি বাকী থাকিব নেকি ?</label>
                            <div class="col-sm-2">
                                <select class="form-control col-sm-2" id="select" required name="availibility">
                                    <option disabled selected>Select</option>
                                    <option value="থাকিব" selected>থাকিব</option>
                                </select>
                            </div>
                            <button type="submit" name="ASTSTEP1Submit" class="btn btn-success"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button') ?></button>
                            <button type="" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!--<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px"><?php echo $this->lang->line('applicant_details_for_field_conversion'); ?></h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                        <h6 class="red uni_text"><b>NOTE : Select Gender and Relation for each Pattadar. Its Mandatory.</b></h6>
                    </div>
                    <form class='form-horizontal form_1 unicode' action="<?php echo base_url() . "index.php/AsistantMutationPartha/reportconvertion"; ?>"  method="post">
                    <?php
                    $i = 1;
                    foreach ($pdtails as $pd):
                        ?>
                        <fieldset><legend><?php echo $this->lang->line('petitioner_info'); ?></legend>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 control-label"><?php //echo $this->lang->line('sl_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="hidden" readonly class="form-control" name="pdar_cron_no[]" value="<?php echo $i; ?>">
                                    <input type="hidden" readonly class="form-control" name="pdar_id[]" value="<?php echo $pd->pdar_id; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('petitioner_name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" readonly class="form-control" name="pdar_name[]" value="<?php echo $pd->pdar_name; ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('gender'); ?><span class="red">*</span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="gender[]" required>
                                        <option selected disabled>-- <?php echo $this->lang->line('select_gender'); ?> --</option>
                                        <option value="M" ><?php echo $this->lang->line('male'); ?></option>
                                        <option value="F" ><?php echo $this->lang->line('female'); ?></option>
                                        <option value="T" ><?php echo $this->lang->line('transgender'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('guardian_name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pdar_guardian[]" value="<?php echo $pd->pdar_father; ?>" placeholder="Guardian Name">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('relation'); ?><span class="red">*</span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="guard_rel[]" required>
                                        <option value=" " selected disabled><?php echo $this->lang->line('guardian_name'); ?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('mothers_name'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control asm" name="mothers_name[]" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-2 control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_number[]" placeholder="<10 digit mobile number>" >
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('nrc_no'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nrc_no[]" id="pdar_add2" placeholder="NRC Number" >
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('adhar_no'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="aadhar_no[]" id="pdar_add1" placeholder="<12 digit aadhar number>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('pan_no'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pan_no[]" id="pdar_add1" placeholder="eg : AAAPL1234C" >
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('voter_id'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="voter_id[]" id="pdar_add2" placeholder="<10 digit voter ID number>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address1'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pdar_add1[]" id="pdar_add1" placeholder="Address Line 1">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('address2'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pdar_add2[]" id="pdar_add2" placeholder="Address Line 2">
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <?php
                        $i = $i + 1;
                    endforeach;
                    ?>

                    <div class="form-group">
                        
                        <label for="inputEmail3" class="col-sm-6 uni_text control-label" style="color: #990000;">পুৰনা দাগত আবেদনকাৰীৰ মাটি বাকী থাকিব নেকি ?</label>
                        <div class="col-sm-2">
                            <select class="form-control col-sm-2" id="select" required name="availibility">
                                <option disabled selected>Select</option>
                                <option value="থাকিব" selected>থাকিব</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                        <button type="" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back') ?></button>
                    </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>-->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {


        $('input').click(function (e) {
            if ($(this).hasClass('asm')) {
                console.log('ASm');
                pramukhIME.addLanguage(PramukhIndic);
                pramukhIME.enable();
                var lang = "pramukhindic:assamese";
                changeLanguage(lang);
            } else {
                var lang = "pramukhindic:english";
                changeLanguage(lang);
            }
        })
    });




</script>









