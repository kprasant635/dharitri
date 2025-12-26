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
						echo form_open_multipart('Allotment/detailslandarea',$attributes); ?>
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
								
								<!---<input id="input-ficons-1" name="inputficons1[]" multiple type="file" class="file-loading">--->
                                    <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename"  class="form-control"  >
									<span class='red'>Upload PDF Only</span>
                                </div>
								<?php if(isset($error)){ echo "<p> File Not Supported. Filse should be less than 5MB. Only PDF Allowed. </p>";
								} ?>
                                <div class='hide img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
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
                                        <input type="radio" name="alot_y_n" value="N" >
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
							
							<div class="form-group ">
                                <label for="inputEmail" class="col-lg-5 required  control-label uni_text">Dag Number <span class='green'>As per Allotment certificate</span> </label>
								
                                <div class="col-lg-2">
									<select class="form-control dag_no" name='dag_no'>
										<option>Select Dag</option>
										<?php foreach($govt_dag as $gd){
											echo "<option value='$gd->dag_no'>" . $gd->dag_no ."</option>" ;
										}
										?>
									</select>
                                   <!------ <input type="text"  class="form-control" placeholder='Dag' value="<?php echo set_value('dag_no'); ?>" required name="dag_no" required="" > --------->
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
								<label for="inputEmail" class="col-lg-4 control-label  uni_text">Type of Govt. Land</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control"	name="type_govt_land" placeholder='Type Here' >
                                </div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='b'  class="numberonly form-control" placeholder='Bigha' value="<?php echo set_value('tot_bigha'); ?>" name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  id='katha' class="numberonly form-control" placeholder='Katha' name="tot_katha" value="<?php echo set_value('tot_katha'); ?>" required=""  >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='l'  class="numberonly form-control" name="tot_lessa" placeholder='Lessa' value="<?php echo set_value('tot_lessa'); ?>" required="" >
                                </div>  
                            </div>
                            <div class="form-group">
							<label for="inputEmail" class="col-lg-3  control-label red">Area Alloted   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" name="alot_bigha" value="<?php echo set_value('alot_bigha'); ?>" required="" placeholder='Bigha' value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" name="alot_katha" value="<?php echo set_value('alot_katha'); ?>" placeholder='Katha' required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" name="alot_lessa" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Lessa' required="" value="" >
                                </div>  
                            </div>
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 col-lg-offset-2 control-label uni_text">Allotment Under  </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name='alot_under'>
											<option value=''>Select Option</option>
											<?php foreach($scheme_name as $scname){ ?>
											<option value='<?php echo $scname->sid;?>'><?php echo $scname->schemename_eng;?></option>
											<?php } ?>
									</select>
                                </div>
                            </div>
                    </div>
					<hr>
                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button type="submit" name='submit' class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
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
<script language="javascript" type="text/javascript">
$("#input-ficons-1").fileinput({
    uploadUrl: "/file-upload-batch/2",
    uploadAsync: true,
    previewFileIcon: '<i class="fa fa-file"></i>',
    allowedPreviewTypes: null, // set to empty, null or false to disable preview for all types
    previewFileIconSettings: {
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
    }
});
</script>
<script type="text/javascript">
$('#mycheckbox').change(function() {
    $('#mycheckboxdiv').toggle();
});
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