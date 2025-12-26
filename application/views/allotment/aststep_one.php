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
						$attributes = array('Allotment/index','class' => 'form-horizontal', 'id' => 'myform');
						echo form_open_multipart('Allotment/index',$attributes); ?>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>

                                    </select>
                                </div>
								<label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control  mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouza as $moz): ?>
                                            <?php
                                            $mouza_code = $moz->mouza_pargona_code;
                                            $mouza_name = $moz->loc_name;
                                            ?>
                                            <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control  lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control villageselect" id="villageselect_allot" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 required control-label">Applicant Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control " required value="<?php echo set_value('applicant_name'); ?>" placeholder="Type Name"  required name="applicant_name" />
                                </div>
                                <label for="select" class="col-lg-2 required control-label">Guardian Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control " required value="<?php echo set_value('gurdian_name'); ?>" placeholder="Enter Guardian Name"  required name="gurdian_name" />
                                </div>
                                <label for="select" class="col-lg-2 required control-label">Relationship</label>
                                <div class="col-lg-2">
                                 <select class="form-control" value='0'  required name="relation">
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
							<label for="select" class="col-lg-2 required control-label">Age</label>
                                <div class="col-lg-2">
                                    <input class="form-control" value="<?php echo set_value('age'); ?>" type="text" placeholder="Type Here"  required name="age" />
                            </div>
							
							<label for="select" class="col-lg-2 required control-label">Gender</label>
                                <div class="col-lg-2">
                                    <select class="form-control required" name='gender'>
											<?php foreach($gender as $g):?>
											<option value='<?=$g->id;?>'><?=$g->gen_name_ass?></option>
											<?php endforeach ?>
									</select>
                                </div>
							<label for="select" class="col-lg-2 required control-label">Caste</label>
                                <div class="col-lg-2">
                                    <select class="form-control" name='caste'>
											<option>Select Option</option>
											<?php 
												foreach($caste_name as $cn){
											?>
											<option value='<?php echo $cn->caste_id ?>'><?php echo $cn->caset_name_eng ?></option>
												<?php } ?>
											
									</select>
                                </div>
							</div>
							<div class='form-group'>
							<label for="select" class="col-lg-4 control-label">Name of Wife if Applicant is Husband</label>
                                <div class="col-lg-2">
                                    <input type='checkbox' class="form-control" value='y' id="mycheckbox" name="applicant_hus_wife" />
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
                                    <input class="form-control" maxlength=10 type="text" value="<?php echo set_value('mobile_no'); ?>" placeholder="Enter Mobile Number"  name="mobile_no" />
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
							<div class="form-group hide">
                                 <label for="select" class="col-lg-2 control-label">Circle</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" placeholder="Type Here"  required name="" />
                                </div>
                                 <label class="col-lg-2 control-label uni_text">Mouza </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
								<label class="col-lg-2 control-label uni_text">Village </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
                            </div>

                            <hr>
                            <h4 class="center red"><u>Allotment Certificate Details </u></h4>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text">Allotment Certificate/Order No </label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="certificate_no"  class="form-control"  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label">Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popupDatepicker' name="cert_date"  class="form-control"  >
                                </div>   
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text">Upload Certificate </label>
                                <div class="col-lg-2">
                                    <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename"  class="form-control"  >
                                </div>
                                <div class='img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
							</div>
                            </div>
                            <hr>
                            <h4 class="center red "><u>Schedule Of Land Allotted</u></h4>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">Whether Applicant(s) is/are legeal heir(s) of original allottee  </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                            </div>
							<div class="form-group">
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">In Whose Name Allotted  </label>
                                <div class="col-lg-4">
                                    <input type="text"  class="form-control" name="alot_whos_name" required="" value="" >
                                </div>    
                            </div>
							<div class="form-group col-lg-offset-2 hide">
                                 <label for="select" class="col-lg-1 col-lg-offset-3 control-label">Circle</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" placeholder="Type Here"  required name="" />
                                </div>
                                 <label class="col-lg-1 control-label uni_text">Mouza </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
								<label class="col-lg-1 control-label uni_text">Village </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
                            </div>
							<div class="form-group ">
                                <label for="inputEmail" class="col-lg-5 required  control-label uni_text">Dag Number <span class='green'>As per Allotment certificate</span> </label>
								
                                <div class="col-lg-2">
									<!----<select class="form-control dag_number" name='dag_no'>
											
									</select>--->
                                    <input type="text"  class="form-control" placeholder='Dag' value="<?php echo set_value('dag_no'); ?>" required name="dag_no" required="" >
                                </div>
								<label for="inputEmail" class="col-lg-2 control-label hide uni_text">Patta Number  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="form-control hide" readonly id='pno' name="patta_no" placeholder='Patta' value="" >
                                </div>
								<label for="inputEmail" class="col-lg-2  control-label hide uni_text">Patta Type  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control hide" readonly id='pcode' name="p_type" placeholder='Patta Type' value="" >
                                </div>
                                  
                            </div>
							<div class="form-group">
								<p class='center red uni_text underline'>Type of Govt. Land</p>
								<label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tb'  class="form-control" placeholder='Bigha' value="<?php echo set_value('tot_bigha'); ?>" name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  id='tk' class="form-control" placeholder='Katha' name="tot_katha" value="<?php echo set_value('tot_katha'); ?>" required=""  >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tl'  class="form-control" name="tot_lessa" placeholder='Lessa' value="<?php echo set_value('tot_lessa'); ?>" required="" >
                                </div>  
                            </div>
                            <div class="form-group">
							<label for="inputEmail" class="col-lg-3  control-label red">Area Alloted   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_bigha" value="<?php echo set_value('alot_bigha'); ?>" required="" placeholder='Bigha' value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_katha" value="<?php echo set_value('alot_katha'); ?>" placeholder='Katha' required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_lessa" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Lessa' required="" value="" >
                                </div>  
                            </div>
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 col-lg-offset-2 control-label uni_text">Allotment Under  </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name='alot_under'>
											<option value='0'>Select Option</option>
											<?php foreach($scheme_name as $scname){ ?>
											<option value='<?php echo $scname->sid;?>'><?php echo $scname->schemename_eng;?></option>
											<?php } ?>
									</select>
                                </div>
                            </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script language="javascript" type="text/javascript">
$(function () {
    $("#fileupload").change(function () {
        $("#dvPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp|.pdf)$/;
        if (regex.test($(this).val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    $("#dvPreview").show();
                    $("#dvPreview").append("<img />");
					    imageMaxWidth: 30;
						imageMaxHeight: 30;
						imageCrop: true ;
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            
        } else {
            alert("Please upload a valid image file.");
        }
    });
});
</script>
<script type="text/javascript">
$('#mycheckbox').change(function() {
    $('#mycheckboxdiv').toggle();
});
$('#villageselect_allot').change(function (e) {
        var vill_code = $(this).val();
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var lot_no = $('.lotselect').val();
        console.log("Changer");
        $.ajax({
            url: baseurl + "Allotment/governmentland/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code,
            success: function (data) {
                //console.log(data);
                //alert("da")
                var name = JSON.parse(data);
                var template = "<option selected disabled>Select Dag</option>"
                for (var i = 0; i < name.length; i++) {
                    template += "<option value='" + name[i].dag_no +"'>"+name[i].dag_no + "</option>"
                }
                console.log(template);
                $('select.dag_number').html(template);
            }
        });
    });
$('#dag_land_area').change(function (e) {
        var dag_no = $(this).val();
		var vill_code = $('.villageselect').val();
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var lot_no = $('.lotselect').val();
        console.log("Changer");
        $.ajax({
            url: baseurl + "Allotment/landarea/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code+ "/" + dag_no,
            success: function (data) {
                console.log(data);
                var dag = JSON.parse(data);
				console.log(dag[0].bigha);
                $('#tb').val(dag[0].bigha);
                $('#tk').val(dag[0].katha);
                $('#tl').val(dag[0].lessa);
				$('#pno').val(dag[0].pno);
				$('#pcode').val(dag[0].pcode);
               // console.log(template);
               // $('select.dag_no').html(template);
            }
        });
    });
</script>
<style type="text/css">
#dvPreview
{
    height: 60px !important;
    width: 60px !important;
	z-index:1000;
    overflow: hidden;
}
</style>