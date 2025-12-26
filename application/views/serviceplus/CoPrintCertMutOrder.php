<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form');  ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
					<div class="row">
                            <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no'); ?> :<?php echo $certDtls->cert_no; ?> </p></div>
                            <div class="col-lg-5"><p class="uni_text text-center">
							<?php
							if($certDtls->application_ref_no){
								echo "অনলাইনত উল্লেখ নং : ".$certDtls->application_ref_no;
							}
							?> 
							</p></div>
                            <div class="col-lg-3"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date'); ?> : <?php echo date('d-m-Y', strtotime($certDtls->apply_date)); ?> </p></div>
                        </div>
                    <?php //var_dump($users); ?>
                    <hr style="border-bottom: 2px solid #000;">
					<form class="form-horizontal unicode">
                            <h2 class="red">Location Details</h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control districtselect" id="select" name="dist_code" required>
                                        <option value="<?php echo $certDtls->dist_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getDistrictName($certDtls->dist_code); ?>
                                        </option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value="<?php echo $certDtls->subdiv_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getSubDivName($certDtls->dist_code, $certDtls->subdiv_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control circleselect" id="select" required name="circle_code">
                                        <option value="<?php echo $certDtls->cir_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getCircleName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code); ?>
                                        </option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                                <div class="col-lg-4">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option value="<?php echo $certDtls->mouza_pargona_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getMouzaName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option value="<?php echo $certDtls->lot_no; ?>"  selected>
                                            <?php echo $this->utilityclass->getLotName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code, $certDtls->lot_no); ?>
                                        </option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control villageselect" id="select" required name="vill_name">
                                        <option value="<?php echo $certDtls->vill_townprt_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getVillageName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code, $certDtls->lot_no, $certDtls->vill_townprt_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control pattatype_nmae"  required name="patta_code">
                                        <?php $patta_type = $this->utilityclass->getpattaName($certDtls->patta_type_code); ?>?>
                                        <option value="<?php echo $certDtls->patta_type_code; ?>"><?php echo $patta_type; ?></option>
                                    </select>
                                </div>

                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-4">
                                    <input type="text" readonly="" class="form-control " name="patta_no" value="<?php echo $certDtls->patta_no; ?>">
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Applicant Details</h2>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Applicant Name</label>
                                <div class="col-lg-4">
                                    <input type="text" name="relation" class="form-control " readonly="" value="<?php echo $certDtls->appln_name; ?>">
                                </div>
                                <label for="inputEmail" class="col-lg-2 hide control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                <div class="col-lg-4 hide">
									<?php 
									$pdar_mobile=$certDtls->pdar_mobile;
									if($certDtls->pdar_mobile == '0'){
										$pdar_mobile = '';
									}
									?>
                                    <input type="text" name="mobile_no" class="form-control " value="<?php echo $pdar_mobile; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Gurdian Name</label>
                                <div class="col-lg-4">
                                    <input type="text" name="guard_name" class="form-control " readonly="" value="<?php echo $certDtls->appln_guard; ?>">
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('relation'); ?></label>
                                <div class="col-lg-4">
                                    <?php $relation = $this->utilityclass->get_relation($certDtls->guard_reln);?>
                                    <input type="text" name="relation" class="form-control" readonly="" value="<?php echo $relation; ?>"  >
                                </div>
                            </div>

                            <div class="form-group hide">
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('aadhar_no'); ?></label>
                                <div class="col-lg-4">
									<?php 
										$pdar_aadharno=$certDtls->pdar_aadharno;
										if($certDtls->pdar_aadharno == '0'){
											$pdar_aadharno = '';
										}
									?>
                                    <input type="text" name="aadhar_no" class="form-control " value="<?php echo $pdar_aadharno; ?>"  >
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('pan_no'); ?></label>
                                <div class="col-lg-4">
									<?php 
										$pdar_pan=$certDtls->pdar_pan;
										if($certDtls->pdar_pan == '0'){
											$pdar_pan = '';
										}
									?>
                                    <input type="text" name="pan_no" class="form-control " value="<?php echo $pdar_pan; ?>"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
							<h2 class="red">Other Attachments</h2>
							<?php 
							//var_dump($attachments);
							foreach ($attachments as $attachment):
								//var_dump($attachment);
								?>
								<h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $certDtls->application_ref_no .'&type='. 3 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
								<?php endforeach; ?>
							<hr style="border-bottom: 2px solid #000;">
                        </form>
                    <div class="col-lg-6 update">
                        <div class="alert alert-info" style="min-height: 160px;">
                            <form class="form-inline" action="<?php echo base_url(); ?>index.php/serviceplus/GenerateOS" method="POST" >
                                <legend class="uni_text text-center">
Plese Click here to Generate Order Sheet <br>&nbsp;</legend>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success clickenable col-lg-offset-4" name="Submit">Please Click here to Generate Order Sheet</button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="cert_no" >
                                    <input type="hidden" value="<?php echo $certDtls->cert_type; ?>" name="certtype" >
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="alert alert-info" style="min-height: 160px;">
                            <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/CitizenController/pendingJamaBondi" method="POST">
                                <legend class="uni_text"><?php echo $this->lang->line('keeping_pending_reason'); ?> </legend>
                                <div class="form-group col-lg-offset-4">
                                    <button type="submit" class="btn btn-success col-lg-offset-4"><?php echo $this->lang->line('reason_keep_pending'); ?></button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" />
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
		</div>        
	</div>
</div>
<script>
    $('#num_page').keyup(function () {
        if ($("#num_page").val() == "0")
        {
            alert("Please type number of pages");
            var fees = 20;
            $('#fees').val(fees);
            $('#button').prop('disabled', true);
            return false;
        }

        if ($(this).val().length == 0) {
            $('#button').prop('disabled', true);
        } else {
            $('#button').prop('disabled', false);
            var fees = 0;
            var num_page = parseInt($('#num_page').val()) || 0;
            var count = num_page - 1;
            var fees = count * 10 + 20;
            $('#fees').val(fees);
        }
    });
    $('#button').prop('disabled', true);
    $('.clickenable').click(function () {
        $('#button').prop('disabled', false);
    });
    
</script>
