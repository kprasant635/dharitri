<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">			
			<div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">                       
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Please Select the user type of your circle. We are going to map users for Single Sign for Dharitree and NOC Software</b></h6>
                        </div>
                        <form class='form form-horizontal center no-trigger' method="POST" action="<?php echo base_url() . 'index.php/singleSignMapping/selectRole' ?>">
                        
							<div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-4">
                                <select  class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option selected disabled>Select District</option>
                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option value="<?php echo $dist_code; ?>" >
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-4">
                                <select  class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option selected disabled>Select Sub-divsion</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-4">
                                <select  class="form-control circleselect" id="select" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Select User Type</label>
							<div class="col-sm-4">
                             
                                <select class="form-control" readonly name="role_type" required>
                                    <option selected disabled>Select Role</option>
                                    <option value='1'>ADC</option>
                                    <option value='2'>Assistant</option>
                                    <option value='3'>Branch Officer</option>
                                    <option value='4'>Circle Officer</option>
                                    <option value='5'>DC</option>
                                    <option value='6'>Lot Mondal</option>
                                    <option value='7'>DIO</option>
                                    <option value='9'>SK</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
							<button type='submit' name='role' class='btn btn-sm btn-primary' >Submit</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>