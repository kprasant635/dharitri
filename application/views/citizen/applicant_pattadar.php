<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <p class="uni_text center text-primary" style="margin-bottom: 35px"> জমাবন্দীৰ নকল / মাটি থকাৰ / আয়ৰ / মাটিৰ মুল্যাংকন / নামজাৰী ওঁ অন্যান্য পত্রৰ বাবে আবেদন </p>
                     <p class="uni_text center" style="margin-bottom: 25px">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form');?></p>
                    <?php
                    //var_dump($this->session->all_userdata());
                    // var_dump($pattaDar);
                    ?>
                    <form class="form-horizontal unicode" action="<?php echo base_url(); ?>index.php/citizencontroller/ApplicantRecipet" method="POST" >
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-5 control-label"><?php echo $this->session->userdata('cert_type'); ?><?php echo $this->lang->line('applied_for_post');?></label>
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('date')?>:  </label>
                            <div class="col-lg-4">
                                <p class="uni_text">  <?php echo $this->session->userdata('date_entry'); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <p class=" uni_text center text-danger "><?php echo $this->lang->line('applicant_details');?></p>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('applicant_name_citizen');?></label>
                            <div class="col-lg-4">
                                <select class="form-control" id="pattadar_id">
                                    <option value="0">Select Pattadar</option>
                                    <?php  
									foreach ($pattaDar as $p):  ?>
                                        <option value="<?php echo $p->pdar_id; ?>"> <?php echo $p->pdar_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('applicant_name_citizen');?></label>
                            <div class="col-lg-4 pdar_name">
                                <!-- <input type="text" name="pdar_name" class="form-control " readonly=""  > -->
                                <input type="text" name="" class="form-control " readonly=""  >

                            </div>
                            <div class="col-lg-4 pdar_id">
                                <input type="hidden" name="pdar_id" class="form-control "  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('guardian_name_citizen');?></label>
                            <div class="col-lg-4 pdar_father">
                                <!-- <input type="text" name="guard_rel" class="form-control " readonly=""  > -->
                                <input type="text" name="" class="form-control " readonly=""  >
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php //echo $this->lang->line('aadhar_no');?></label>
                            <div class="col-lg-3 pdar_aadhar">
                                <input type="text" name="aadhar_no" class="form-control "  >
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php //echo $this->lang->line('pan_no');?></label>
                            <div class="col-lg-3 pdar_pan">
                                <input type="text" name="pan_no" maxlength="12" class="form-control "  >
                                
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('mobile_no');?></label>
                            <div class="col-lg-4 pdar_mobile">
                                <input type="text" name="mobile_no" id="quantity"  maxlength="10" class="form-control "   >
                                <span id="errmsg"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label">Relation with Gurdian<?php //echo $this->lang->line('relation');?></label>
                            <div class="col-lg-4 pdar_guard_reln">
                                <!-- <select class="form-control" name="relation"> -->
                                <select class="form-control" name="">
                                    <option> Select Relation </option>
                                    <?php foreach ($guardRel as $rel) : ?>
                                        <option value="<?php echo $rel->guard_rel; ?>"> <?php echo $rel->guard_rel_desc_as; ?> </option>
                                    <?php endforeach; ?>
									
                                </select>
								<span class="red help-block">Please Select Relationship if not occur</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button type="reset" class="btn btn-danger uni_text" id="openBtn"><i class="fa fa-reply"></i> <?php echo $this->lang->line('previous_menu');?> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
