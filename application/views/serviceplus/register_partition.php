<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Register Office Partition Cases ( Online )</h2>
                </div>
            </div>
            <div class="col-lg-12">
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
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url() . "index.php/serviceplus/save_office_partition"; ?>">
                            <?php
                            foreach ($result as $key => $basic) :
							//var_dump($basic);
								?>
								<div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="dist_code" >
                                                    <option value="<?php echo $basic->dist_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getDistrictName($basic->dist_code); ?>
                                                    </option>
                                                </select>
                                            </div> 
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="subdiv_code" >
                                                    <option value="<?php echo $basic->subdiv_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getSubDivName($basic->dist_code, $basic->subdiv_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="cir_code">
                                                    <option value="<?php echo $basic->cir_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getCircleName($basic->dist_code, $basic->subdiv_code, $basic->cir_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="mouza_code">
                                                    <option value="<?php echo $basic->mouza_pargona_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getMouzaName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="lot_no">
                                                    <option value="<?php echo $basic->lot_no; ?>"  selected>
                                                        <?php echo $this->utilityclass->getLotLocationName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="vill_townprt_code">
                                                    <option value='<?php echo $basic->vill_townprt_code; ?>' selected>
                                                        <?php echo $this->utilityclass->getVillageName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div> 
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red"><?php echo $this->lang->line('dag_details'); ?></h2>
                                        <div class="form-group">
                                           
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control pattatype_nmae" id="new_patta_type" required name="patta_type">
                                                    <option value="<?php echo $basic->patta_type_code; ?>">
                                                        <?php echo $this->utilityclass->getPattaName($basic->patta_type_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                                    <option value="<?php echo $basic->patta_no; ?>">
                                                        <?php echo $basic->patta_no; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                            <div class="col-lg-3">
                                                <?php $dag_no = $this->utilityclass->get_dag_no_from_dag_no_int($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code,$basic->patta_no,$basic->patta_type_code,$basic->dag_no); ?>
                                                <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                                    <option value="<?php echo $dag_no; ?>">
                                                        <?php echo $dag_no; ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red">Deed Details (if any)</h2>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text1">Deed No</label>
                                            <div class="col-sm-3">
                                                <input type="text"  maxlength="30" class="form-control" name="reg_deed_no" value="<?php echo $basic->deed_no; ?>">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label hiden"><?php echo $this->lang->line('deed_value') ?></label>
                                            <div class="col-sm-3">
                                                <input type="text"  maxlength="19" class="form-control" data-inputmask="'mask': '9[999999999]'" name="reg_deed_value" value="<?php echo $basic->deed_value; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text2"><?php echo $this->lang->line('deed_date') ?></label>
                                            <div class="col-sm-3">
                                                <div class="input-group add-on col-md-12 date datepicker" data-date-format="yyyy-mm-dd">
                                                    <input type="text" id="placehold2" class="form-control dating" name="reg_deed_date" value="<?php echo $basic->deed_date; ?>">
                                                    <div class="input-group-btn">
                                                        <a class="btn btn-default"><i class="fa fa-calendar"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red"><?php echo $this->lang->line('land_details'); ?></h2>
                                        <!--Actual Land Area-->
                                        <table class="table table-bordered">
                                            <thead>
                                                <th></th>
                                                <th>বিঘা</th>
                                                <th>কঠা</th>
                                                <th>লেছা</th>
                                                <th>Gonda</th>
                                                <th>Kranti</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Land Area</td>
                                                    <td><input type="number"  class="form-control" value="<?php echo $basic->dag_area_b; ?>" readonly="" name='dag_area_b' placeholder="বিঘা"></td>
                                                    <td><input type="number"  class="form-control" value="<?php echo $basic->dag_area_k; ?>"  readonly="" name='dag_area_k' placeholder="কঠা"></td>
                                                    <td><input type="number"  class="form-control"  name='dag_area_lc' placeholder="লেছা" readonly="" value="<?php echo $basic->dag_area_lc; ?>"></td>
                                                    <td><input type="number"  class="form-control"  name='dag_area_g' placeholder="Gonda" readonly="" value="<?php echo $basic->dag_area_g; ?>"></td>
                                                    <td><input type="number"  class="form-control"  name='dag_area_kr' placeholder="Kranti" readonly="" value="<?php echo $basic->dag_area_kr; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>Partition Land Area</td>
                                                    <td><input type="number" maxlength="6" class="form-control" value="<?php echo $basic->p_dag_area_b; ?>" name='p_dag_area_b' placeholder="বিঘা"></td>
                                                    <td><input type="number" maxlength="2" class="form-control" value="<?php echo $basic->p_dag_area_k; ?>" name='p_dag_area_k' placeholder="কঠা"></td>
                                                    <td><input type="number" maxlength="7" class="form-control" value="<?php echo $basic->p_dag_area_lc; ?>" name='p_dag_area_lc' placeholder="লেছা"></td>
                                                    <td><input type="number"  class="form-control"  name='p_dag_area_g' placeholder="Gonda"  value="<?php echo $basic->p_dag_area_g; ?>"></td>
                                                    <td><input type="number"  class="form-control"  name='p_dag_area_kr' placeholder="Kranti"  value="<?php echo $basic->p_dag_area_kr; ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--Land Area To Be Mutated-->
                                    <hr style="border-bottom: 2px solid #000;">
                                    <fieldset>
                                        <h2 class="red">Applicant/Pattadar Information</h2>
                                        <?php
                                        foreach ($basic->pattadar_details  as $pattadars):
                                            //var_dump($pattadars);
                                            ?>
                                            <div id="itemRowsPattadars">
                                                <div class="col-lg-3">
                                                    <label class="center bold">Pattadar Name : </label><br>
													<input type="text" class="form-control" name="pdar_name[]" required value="<?php echo $pattadars->pdar_name; ?>"></label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center bold">Pattadar Guardian Name : </label><br>
													<input type="text" class="form-control" name="pdar_father[]" required value="<?php echo $pattadars->pdar_guardian; ?>"></label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center bold">Relation: </label><br>
                                                    <select class="form-control" name="relation" required>
														<option> Select Relation </option>
														<?php foreach ($guardRel as $rel) : ?>
															<option value="<?php echo $rel->guard_rel; ?>"> <?php echo $rel->guard_rel_desc_as; ?> </option>
															
														<?php endforeach; ?>
													</select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center bold">Mobile: </label><br>
                                                    <input type="text" class="form-control" name="pdar_mobile[]" value="<?=$pattadars->pdar_mobile?>">
                                                </div>
                                                <input type="hidden" class="form-control" name="pdar_id[]" value="<?php echo $pattadars->pdar_id; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </fieldset>
									<hr>
									<h2 class="red">Fee Paid During Registration</h2>
									<div class="callout alert alert-info uni_text" role="alert">
									 <?php 
										if($basic->fee_amount=='1000')
											$val="Urban Area";
										elseif($basic->fee_amount=='2000')
											$val='GMC Area';
										else
											$val="Rural Area";
										?>
									  Amount Paid RTPS during Registration : <i class='fa fa-inr'></i><?=$basic->fee_amount?> <kbd>User has selected <?=$val?></kbd>
									  <p class='small itlaic red'>Note: User charge of the service should be as per Office Memorandum ie. Rs.2000/- in GMC area, Rs.100/- in Rural areas, Rs.1000/- in Urban areas</p>
									</div>
									<hr style="border-bottom: 2px solid #000;">
                                    <fieldset>
                                        <h2 class="red">Other Attachments</h2>
                                        <?php
                                        foreach ($basic->attachment  as $attachment):
                                            //var_dump($attachment);
                                            ?>
											<h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $application_ref_no .'&type='. 2 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
											<?php 
										endforeach; 
										?>
										
                                    </fieldset>
                            <?php endforeach; ?>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required">Assign Officer</label>
                                <div class="col-sm-4">
                                    <select name="add_of_name" class="form-control" id="corequired" required>
                                        <option selected disabled><?php echo $this->lang->line('select_recieving_officer'); ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u->user_code; ?>"><?php echo $u->username; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php echo $this->lang->line('designation'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required>
                                        <option selected disabled><?php echo $this->lang->line('select_designation'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="application_ref_no" value="<?php echo $application_ref_no; ?>">
                            <input type="hidden" class="form-control" name="applid" value="<?php echo $applid; ?>">
							<hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" name="ASTSTEP2Submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/serviceplus/office_mutation_cases" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
						</form>
						<hr>
                        <div class="text-center">
							<a href="" class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modalContactForm">Click Here for Query to the Applicant RTPS Portal</a>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-----------------modal bstart------------->
<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method="POST" action="<?php echo base_url(); ?>index.php/serviceplus/partition_enclosure_query">
    <div class="modal-content">
	  
      <div class="modal-body mx-3">
        <div class="md-form">
		
		  <div class="modal-header text-center">
			<h4 class="modal-title w-100 font-weight-bold">Write to Applicant(s)</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="form-check col-lg-12">
              <span class="col-lg-6">
                <input class="form-check-input" type="radio"  name="queryop" onclick="disable()" value="q">
                <label class="form-check-label" for="inlineRadio1">Query</label>
              </span>
              <span class="col-lg-6">
                <input class="form-check-input" type="radio" checked name="queryop" onclick="enable()" value="pq">
                <label class="form-check-label" for="inlineRadio2">Payment Query</label>
              </span>
          </div>
		  <div class="form-group">
			<input class="form-control" type="number" required placeholder='Enter Amount' id="fee" name="fee" >
		  </div>
          <textarea type="text" name='query' class="md-textarea form-control" placeholder='Type Your Query' rows="4"></textarea>
          <label data-error="wrong" data-success="right" for="form8">Your message/Query</label>
		  <input type="hidden" class="form-control" readonly="" name="application_ref_no" value="<?php echo $application_ref_no; ?>"  >
          <input type="hidden" class="form-control" readonly="" name="applId" value="<?php echo $applid; ?>"  >
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-info">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
      </div>
    </div>
	</form>
  </div>
</div>
<script>
function disable() {
	document.getElementById("fee").disabled = true;
}
function enable() {
	document.getElementById("fee").disabled = false;
}
</script>

<!----------end---------->

