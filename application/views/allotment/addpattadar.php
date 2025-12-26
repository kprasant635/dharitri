<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Registration Of Allotment Certificate to PP Conversion</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="center panel-title">
                            Fill up application form
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php echo validation_errors(); ?>
						<?php
						$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
						echo form_open_multipart('Allotment/addpattadar',$attributes); ?>
						
						
							<div class="form-group">
                                <label for="select" class="col-lg-4 required control-label">Is Allotment For  ? </label>
								<div class="col-lg-1" style='margin-top: 8px;'>
                                    <input type="radio" class='chkPassport' name="name_stat" checked value='I' /> Individual   
                                </div>
								<div class="col-lg-1" style='margin-top: 8px;'>
                                     <input type="radio" class='chkPassport' name="name_stat" value='O' /> Orginasition
                                </div>
							</div>
						<hr>
							
					
						
                            <div class="form-group">
                                <label for="select" class="col-lg-2 required control-label">Applicant Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control " id="appname" required value="<?php echo set_value('applicant_name'); ?>" placeholder="Type Name"  required name="applicant_name" />
                                </div>
                                <label for="select" class="col-lg-2 required org_name control-label">Guardian Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control org " required value="<?php echo set_value('gurdian_name'); ?>" placeholder="Enter Guardian Name"  required name="gurdian_name" />
                                </div>
                                <label for="select" class="col-lg-2 required org_name control-label">Relationship</label>
                                <div class="col-lg-2">
                                 <select class="form-control org" value='0'  required name="relation">
                                    <?php
									foreach($relationship as $p){
                                    ?>
                                       <option  value="<?php echo $p->guard_rel;?>"><?php echo $p->guard_rel_desc_as;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
							<div class='form-group'>
							<label for="select" class="col-lg-2 required org_name control-label">Age</label>
                                <div class="col-lg-2">
                                    <input class="form-control numberonly org" maxlength=3 value="<?php echo set_value('age'); ?>" type="text" placeholder="Type Here"  required name="age" />
                            </div>
							<label for="select" class="col-lg-2 required org_name control-label">Gender</label>
                                <div class="col-lg-2">
                                    <select class="form-control org required" name='gender'>
											<?php foreach($gender as $g):?>
											<option value='<?=$g->id;?>'><?=$g->gen_name_ass?></option>
											<?php endforeach ?>
									</select>
                                </div>
							<label for="select" class="col-lg-2 org_name required control-label">Caste</label>
                                <div class="col-lg-2">
                                    <select class="form-control org" name='caste'>
											<option value=''>Select Option</option>
											<?php 
												foreach($caste_name as $cn){
											?>
											<option value='<?php echo $cn->caste_id ?>'><?php echo $cn->caset_name_eng ?></option>
												<?php } ?>
											
									</select>
                                </div>
							</div>
							<div class='form-group'>
							<label for="select" class="col-lg-4 org_name control-label">Name of Wife if Applicant is Husband</label>
                                <div class="col-lg-2">
                                    <input type='checkbox' class="form-control org" value='y' id="mycheckbox" name="applicant_hus_wife" />
                                </div>
							<span id="mycheckboxdiv" style="display:none">
							<label for="select" class="col-lg-3 red required control-label">Name of Wife/Husband</label>
                                <div class="col-lg-2">
                                    <input type='text' class="form-control" required name="name_hus_wife" />
                                </div>
							</span>
							</div>
						
							<div class="form-group hide">
                                <label class="col-lg-2 control-label hide required uni_text">Employment Type </label>
                                <div class="col-lg-2 hide">
                                    <input type="text" required="" placeholder="Type Here"  name="emp_type"  class="form-control"  >
                                </div>
								<label class="col-lg-2 hide control-label required uni_text">Income(per Yr.) </label>
                                <div class="col-lg-2">
                                    <input type="text" maxlength=10 required="" value="<?php echo set_value('income_per_yr'); ?>" placeholder="Type Here"  name="income_per_yr"  class="hide form-control"  >
                                </div>
								<label for="select" class="col-lg-1 required control-label">Nationality</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" value='Indian' placeholder="Type Here"  required name="nationality" />
                                </div>
                            </div>
							<div class="form-group">
                            </div>
                            <div class="form-group">
                                 <label for="select" class="col-lg-2 control-label">Mobile No.</label>
                                <div class="col-lg-2">
                                    <input class="form-control numberonly" maxlength=10 type="text" value="<?php echo set_value('mobile_no'); ?>" placeholder="Enter Mobile Number"  name="mobile_no" />
                                </div>
                                 <label class="col-lg-2 control-label uni_text">Aadhar No. </label>
                                <div class="col-lg-2">
                                    <input type="text" disabled placeholder="Aadhar Number"  name="aadhar"  class="form-control"  >
                                </div>
								<label class="col-lg-2 control-label uni_text">PAN No. </label>
                                <div class="col-lg-2">
                                    <input type="text" maxlength=12  placeholder="Enter PAN Number" value="<?php echo set_value('pan_no'); ?>"  name="pan"  class="form-control"  >
                                </div>
                            </div>
							<hr>							
							<div class="form-group" style="margin-top: 10px">
								<div class="col-lg-5 col-lg-offset-5">
									<button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
									<button id="MainIndex" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
								</div>
							</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
$('#mycheckbox').change(function() {
    $('#mycheckboxdiv').toggle();
});
$(document).ready(function(){	
		$('.chkPassport').click(function () {
			var val= $(this).val();
			if(val=='O'){
				$('.org').attr('disabled', 'disabled'); 
				//$('.org_name').style.textDecoration = 'line-through'; 
			}else{
				$('.org').attr('disabled', false); 
				
			}
			
           
        });
	
document.getElementById("RememberMe").checked = true;	

	
$(".numberonly").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });	
});

function disableTextBox(){
		document.appname.disabled=true;
		//document.test.txt2.disabled=true;	
		//addListeners();
	}
	

</script>

 <script type="text/javascript">
    $(function () {
        
    });
</script>
