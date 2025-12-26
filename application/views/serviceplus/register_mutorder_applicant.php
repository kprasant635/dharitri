<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Order Sheet' ৰ বাবে আবেদন পঞ্জীকৰণ ফৰ্ম ( Online )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6"><p class="uni_text">Location Details </p></div>
                            <div class="col-lg-6"><p class="uni_text text-center">
							<?php
							if($application_ref_no){
								echo "অনলাইনত উল্লেখ নং : ".$application_ref_no;
							}
							?> 
							</p></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url(); ?>index.php/serviceplus/saveMutOrder">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control districtselect" id="select" name="dist_code" required>
                                        <option value="<?php echo $dist_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                        </option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value="<?php echo $subdiv_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control circleselect" id="select" required name="circle_code">
                                        <option value="<?php echo $cir_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code); ?>
                                        </option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                                <div class="col-lg-4">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option value="<?php echo $mouza_pargona_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option value="<?php echo $lot_no; ?>"  selected>
                                            <?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); ?>
                                        </option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?> </label>
                                <div class="col-lg-4">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option value="<?php echo $vill_townprt_code; ?>"  selected>
                                            <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-4">
                                    <select class="form-control pattatype_nmae"  required name="patta_code">
                                        <?php
                                        foreach ($patttype as $p):
                                            $type_code = $p->type_code;
                                            $patta_type = $p->patta_type;
                                            ?>
                                            <option value="<?php echo $type_code; ?>"><?php echo $patta_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-4">
                                    <input type="text" readonly="" class="form-control " name="patta_no" value="<?php echo $patta_no; ?>">
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Reference No</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" readonly="" name="application_ref_no" value="<?php echo $application_ref_no; ?>"  >
                                    <input type="hidden" class="form-control" readonly="" name="applId" value="<?php echo $applid; ?>"  >
                                    <select class="form-control cert_code hide" name="cert_type">
                                        <?php foreach ($certtype as $c): ?>
                                            <option value="<?php echo $c->cert_code . "#" . $c->cert_type . '#' . $c->delivery_time; ?>"><?php echo $c->cert_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label">Submition Date : </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" readonly="" name="date_entry" value="<?php echo $apply_date; ?>"  >
                                </div>
                            </div>
							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label">Mutation Case No: </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" readonly="" name="mutation_caseNo" value="<?php echo $mutationCaseNo; ?>"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Applicant Details</h2>
							<table class='table table-bordered'>
								<tr>
									<td><span class='green'>Applicant Name :</span>  <?=$rtpsData[0]->applied_applicant_service_plus?></td>
									<td><span class='green'>Gender :</span>  <?=$rtpsData[0]->gender?></td>
									<td><span class='green'>Spouse Name :</span>  <?=$rtpsData[0]->spouse_name?></td>
									<td><span class='green'>Pan No:</span>  <?=$rtpsData[0]->pan?></td>
								</tr>
							</table>
							
                            <?php //foreach ($pattaDar as $p): ?>
							<div class="hide form-group">
                            <label for="inputEmail" class="col-lg-4 control-label">Mutation order to be issued in the name of</label>
                            <div class="col-lg-4">
								<input type="text" class="form-control" readonly="" name="pdar_id" value="<?php echo $pattaDar->pdar_id; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label">Mutation order to be issued in the name of</label>
                            <div class="col-lg-4 pdar_name">
                                <input type="text" name="pdar_name" class="form-control " value='<?php echo $pattaDar->pdar_name; ?>'  >

                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('guardian_name_citizen');?></label>
                            <div class="col-lg-4 pdar_father">
                                <input type="text" name="guard_rel" class="form-control " value='<?php echo $pattaDar->pdar_father; ?>'  >
                            </div>
                        </div>
                        <div class="hide form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('aadhar_no');?></label>
                            <div class="col-lg-3 pdar_aadhar">
                                <input type="text" name="aadhar_no" class="form-control "  >
                            </div>
                        </div>
                        <div class="hide form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('pan_no');?></label>
                            <div class="col-lg-3 pdar_pan">
                                <input type="text" name="pan_no" maxlength="12" class="form-control "  >
                                
                            </div>
                        </div>
                        <div class="hide form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('mobile_no');?></label>
                            <div class="col-lg-4 pdar_mobile">
                                <input type="text" name="mobile_no" id="quantity"  maxlength="10" class="form-control "   >
                                <span id="errmsg"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label">Relation with Gurdian<?php //echo $this->lang->line('relation');?></label>
                            <div class="col-lg-4 pdar_guard_reln">
                                <select class="form-control" name="relation">
                                    <option> Select Relation </option>
                                    <?php foreach ($guardRel as $rel) : ?>
                                        <option value="<?php echo $rel->guard_rel; ?>"> <?php echo $rel->guard_rel_desc_as; ?> </option>
                                    <?php endforeach; ?>
									
                                </select>
								<span class="red help-block">Please Select Relationship if not occur</span>
                            </div>
                        </div>    
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Service Fee</label>
                                <div class="col-lg-4">
                                    <input type="text" readonly="" class="form-control " name="cert_fees" value="20.00">
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('revenue_done'); ?></label>
                                <div class="col-lg-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="revenue" checked=""  value="Y">  <?php echo $this->lang->line('revenue_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" disabled="" name="revenue" value="N"> <?php echo $this->lang->line('revenue_no'); ?>
                                    </label>
                                </div>
                            </div>
							<hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Other Attachments</h2>
							<?php 
							foreach ($attachments as $attachment): 
								?>
								<h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $application_ref_no .'&type='. 3 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
							<?php endforeach; ?>
							<div class="text-center">
							  <a href="" class="btn btn-success btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modalContactForm">Click Here for Query to the Applicant
								</a>
							</div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <button type="reset" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/serviceplus/os_cases" class="btn btn-danger">
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
</div>
<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method="POST" action="<?php echo base_url(); ?>index.php/serviceplus/os_enclosure_query">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Write to Applicant(s)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form">
          <i class="fa fa-pencil prefix grey-text"></i>
          <textarea type="text" name='query' class="md-textarea form-control" rows="4"></textarea>
          <label data-error="wrong" data-success="right" for="form8">Your message/Query</label>
		  <input type="hidden" class="form-control" readonly="" name="application_ref_no" value="<?php echo $application_ref_no; ?>"  >
          <input type="hidden" class="form-control" readonly="" name="applId" value="<?php echo $applid; ?>"  >
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-unique">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
      </div>
    </div>
	</form>
  </div>
</div>
