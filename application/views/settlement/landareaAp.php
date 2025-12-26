<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Registration Of AP to PP Conversion</h2>
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
						echo form_open_multipart('Settlement/detailslandareaAp',$attributes); ?>
                            <h4 class="center red"><u>AP Details </u></h4>
							  <input type="hidden" readonly value="<?php echo $location['dist_code']; ?>" class="form-control districtselect" name="dist_code">
                        <input type="hidden" readonly value="<?php echo $location['subdiv_code']; ?>" class="form-control subdivselect" name="subdiv_code">
                        <input type="hidden" readonly value="<?php echo $location['cir_code']; ?>" class="form-control circleselect" name="cir_code">
                        <input type="hidden" readonly value="<?php echo $location['mouza_pargona_code']; ?>" class="form-control mouzaselect" name="mouza_pargona_code">
                        <input type="hidden" readonly value="<?php echo $location['lot_no']; ?>" class="form-control lotselect" name="lot_no">
                        <input type="hidden" readonly value="<?php echo $location['vill_code']; ?>" class="form-control villageselect" name="vill_townprt_code">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text "> AP/Order No  by DC</label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="certificate_no"  class="form-control "  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label">Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popupDatepicker' name="cert_date"  class="form-control"  >
                                </div>   
                            </div>
                            <div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Upload DC Order</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload1" id="fileupload">
                                    </div>
                                </div>
							
								<?php if(isset($error)){ echo "<p> File Not Supported. Filse should be less than 5MB. Only PDF Allowed. </p>";} ?>
                                <div class='hide img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
							</div>
                            </div>
							
							
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Upload Order From Revenue Department</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload2" id="fileupload">
                                    </div>
                                </div>
								<?php if(isset($error)){ echo "<p> File Not Supported. Filse should be less than 5MB. Only PDF Allowed. </p>";} ?>
                                <div class='hide img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
							</div>
                            </div>
							
								<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Upload Premium Against Allotment</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload3" id="fileupload">
                                    </div>
                                </div>
								<?php if(isset($error)){ echo "<p> File Not Supported. Filse should be less than 5MB. Only PDF Allowed. </p>";} ?>
                                <div class='hide img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
							</div>
                            </div>
							
							
							
							
							
							  <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text ">Govt. of Assam AP/Order No </label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="govtcertificate_no"  class="form-control "  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label ">Govt. of Assam Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popup2Datepicker' name="govtcert_date"  class="form-control "  >
                                </div>   
                            </div>
							
							  <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text ">Challan Certificate No. </label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="challancertificate_no"  class="form-control "  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label ">Challan Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popup3Datepicker' name="challancert_date"  class="form-control "  >
                                </div>   
                            </div>
							
							
						
                            <hr>
                            <h4 class="center red "><u>Schedule Of Land Alloted</u></h4>
                          <!--  <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">Whether Applicant(s) is/are legeal heir(s) of original allottee  </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" value="Y" checked="">
                                        <?php //echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" value="N" >
                                        <?php //echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                            </div> !-->
							<div class="form-group">
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">In Whose Name Settled  </label>
                                <div class="col-lg-4">
                                    <input type="text"  class="form-control" name="alot_whos_name"  value="" required>
                                </div>    
                            </div>
							
							
							     <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                            <div class="col-sm-3">
                                <select class="form-control pattatype_nmae" id="new_patta_type" name="patta_type" required >
                                    <option selected disabled><?php echo $this->lang->line('select_patta_type'); ?></option>
                                    <?php
                                    foreach ($patta_conv_type as $value) {
                                        echo "<option value='$value->type_code'>$value->patta_type</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
						
						
						   <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label required" ><?php echo $this->lang->line('patta_no'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                    <option>Select Patta No</option>
                                </select>
                            </div>
                        </div>
							
							<div class="form-group ">
                                <label for="inputEmail" class="col-lg-5 required  control-label uni_text">Dag Number <span class='green'>As per AP</span> </label>
								
                                <div class="col-lg-4">
									<!----<select class="form-control dag_number" name='dag_no'>
											
									</select>--->
                                    <!--<input type="text"  class="form-control" placeholder='Dag' value="<?php //echo set_value('dag_no'); ?>" required name="dag_no" required="" > !-->
									
							 <select class="form-control dag_no_saraS" id="dag_noAp" name="dag_noAp">
                                    <option>Dag No </option>
                                </select>
									
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
								
								  <select class="col-lg-4" name="type_govt_land" required>
                                        <option value="" selected>Select Reason</option>
                                        <option value="চিলিং চৰকাৰী">চিলিং চৰকাৰী</option>
                                         <option value="সাধাৰন চৰকাৰী">সাধাৰন চৰকাৰী</option>
										  <option value="এনাল চৰকাৰী">এনাল চৰকাৰী</option>
                                       
                                     </select>
								
									
                             <!--   <div class="col-lg-5">
                                    <input type="text" class="form-control"	name="type_govt_land" placeholder='Type Here' >
                                </div> !-->
							</div>
							 <div class="form-group">
                        <div class="col-sm-4">
                            <label for="inputEmail3" class="control-label pull-left" style="color: #990000;"><?php echo $this->lang->line('tick_if_whole_land_conversion'); ?> </label>
                        </div>
                        <div class="col-sm-1" style="background-color: #990000">
                            <input type="checkbox" id="PartialOrFull" class="form-control" name="PartialOrFull" value="Y"/>
                        </div>
                    </div>
							<div id="autoUpdate1" class="autoUpdate">
							
							<div class="form-group">
								<label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tb'  class="numberonly form-control" placeholder='Bigha' value="<?php echo set_value('tot_bigha'); ?>" name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  id='tk' class="numberonly form-control" placeholder='Katha' name="tot_katha" value="<?php echo set_value('tot_katha'); ?>" required=""  >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tl'  class="numberonly form-control" name="tot_lessa" placeholder='Lessa' value="<?php echo set_value('tot_lessa'); ?>" required="" >
                                </div>  
                            </div>
                            <div class="form-group">
							<label for="inputEmail" class="col-lg-3  control-label red">Area Settled   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control" id='sb' name="alot_bigha" value="<?php echo set_value('alot_bigha'); ?>"  placeholder='Bigha'>
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control"  id='sk' name="alot_katha" value="<?php echo set_value('alot_katha'); ?>" placeholder='Katha'>
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control check_empty" id='sl' name="alot_lessa" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Lessa'>
                                </div>  
                            </div>
							
							
							   <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('remaining_part_of_the_dag'); ?></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" id="rb" name='l_dag_area_b_P' placeholder="বিঘা" readonly>
                            </div>

                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control" id="rkatha" name='l_dag_area_k_P' placeholder="কঠা" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control" id="rl" name='l_dag_area_lc_P' placeholder="লেছা" readonly>
                            </div>
                        </div>
						</div>
						
			
						
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 col-lg-offset-2 control-label uni_text">Settled Under  </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name='alot_under' required>
											<option value=''>Select Option</option>
											<?php foreach($scheme_name as $scname){ ?>
											<option value='<?php echo $scname->sid;?>'><?php echo $scname->schemename_eng;?></option>
											<?php } ?>
									</select>
                                </div>
                                
                                <label for="inputEmail" class="col-lg-2 col-lg-offset-2 control-label uni_text">Premium </label>
                                <div class="col-lg-2">
                                        <input type="text" name="premium" id='premium' value=""  placeholder='Premium' required> Premium
                                </div>
							</div>
							
								
                                 
                   
							
                    </div>
					<hr>
                    <div class="form-group" style="margin-top: 10px">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button type="submit" name='submit'  class="btn btn-primary "><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
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




    $("#backlog_patta_type").change(function (e) {
        //alert('sda');
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $(this).val();
        //alert(distcode+" "+subdivcode+" "+circode+" "+mouzacode+" "+lotcode+" "+villcode+" "+patta_type_code);
        $.ajax({
            url: baseurl + "Utility/getDagsAP/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no,
            success: function (d) {
                var object = JSON.parse(d);
                //alert (object[i].dag_no_int);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {

                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_noAp']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });




/*$('#sb').change(function (e) {
        var mb = $(this).val();
        var tb = $('#tb').val();
        console.log(mb);
        console.log(tb);
        var left = tb - mb;
        if (left < 0) {
            alert('Exceeds!');
            $(this).val(0);
            return;
        }
      
	
    });


$('#sk').change(function (e) {
        var mk = $(this).val();
        var tk = $('#tk').val();
        console.log(mk);
        console.log(tk);
        var leftk = tk - mk;
        if (leftk < 0) {
            alert('Exceeds!');
            $(this).val(0);
            return;
        }
     });  
	

$('#sl').change(function (e) {
        var ml = $(this).val();
        var tl = $('#tl').val();
        console.log(mb);
        console.log(tb);
        var leftl = tl - ml;
        if (leftl < 0) {
            alert('Exceeds!');
            $(this).val(0);
            return;
        }

 });



*/




   $(function () {
        $("#PartialOrFull").click(function () {
            if ($(this).is(":checked")) {
				
				   var bigha =  $('#tb').val();
        var katha = $('#tk').val();
        var lessa = $('#tl').val();
		$('#sb').val(bigha);
        $('#sk').val(katha);
        $('#sl').val(lessa);
		
			$("#rb").val('0');
				$("#rkatha").val('0');
				$("#rl").val('0');
			
         
            } else {
             $("#sk").removeAttr("disabled");
                $("#sk").focus();
				$("#sb").removeAttr("disabled");
                $("#sb").focus();
				$("#sl").removeAttr("disabled");
                $("#sl").focus();
				$("#rb").val('');
				$("#rkatha").val('');
				$("#rl").val('');
			
				$("#sb").val('');
				$("#sk").val('');
				$("#sl").val('');
			
				
				
				
            }
			
			
        });
    });


  $(".check_empty").keyup(function(){
            var lessa_empty = $(this).val();
            var kotha_empty = $('#sk').val();
            var bigha_empty = $('#sb').val();
            if ((lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
                alert('Bigha-Katha-lessa for conversion cannot be 0-0-0 !');
                return;
            }
			calculateRemainingLandsettlement();
			
        });

		
		
		function calculateRemainingLandsettlement() {

        var bigha =  $('#tb').val();
        var katha = $('#tk').val();
        var lessa = $('#tl').val();
       

        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        console.log(window.sourcelessa);
        var mbigha = $('#sb').val();
        var mkatha = $('#sk').val();
        var mlessa = $('#sl').val();
       

        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        console.log(window.targetlessa);


        window.remaininglessa = sourcelessa - targetlessa;
        //alert(remaininglessa);

        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = remaininglessa - bigha_r * 100 - katha_r * 20;

//        $('#rb').val(remaininglessa/100);
//        $('#rkatha').val(katha - mkatha);
//        $('#rl').val(lessa - mlessa);
//        $('#rg').val(ganda - mg);
//        $('#rk').val(krantik - mk);

        $('#rb').val(bigha_r);
        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
      //  $('#rg').val(ganda - mg);
      //  $('#rk').val(krantik - mk);

        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
			$('#sb').val('');
         $('#sk').val('');
		 $('#sl').val('');
          
        }
         //alert(window.sourcelessa);
    }

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		






 $('.dag_no_saraS').change(function (e) {
        var dag_no = $(this).val();
		var dag_no=dag_no/100;
//alert(dag_no);

        $.ajax({
            url: baseurl + "Settlement/getLandAreaSettle/" + dag_no,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var dag = JSON.parse(data);
                $('#tb').val(dag[0].dag_area_b);
                $('#tk').val(dag[0].dag_area_k);
                $('#tl').val(dag[0].dag_area_lc);
                
              

            }
        });
    });










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