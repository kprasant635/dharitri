<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Registration Of Settlement Certificate to PP Conversion</h2>
                </div>
                <?php
                    if($this->session->flashdata('message')){
                  ?>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>
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
                        echo form_open_multipart('Settlement/detailslandarea',$attributes); ?>
                            <h4 class="center red"><u>Settlement Details </u></h4>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text "> Settlement Order No by DC</label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="certificate_no"  class="form-control "  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label">Date of Issue </label>            
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
                                <label for="inputEmail3" class="col-sm-4 control-label">Upload Premium against Settlement</label>
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
                                <label for="inputEmail" class="col-lg-3 control-label uni_text ">Govt. of Assam Settlement Order No </label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here"  name="govtcertificate_no"  class="form-control "  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label ">Govt. of Assam Date of Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" id='popup2Datepicker' name="govtcert_date"  class="form-control "  >
                                </div>   
                            </div>
                            
                        
                            <hr>
                            <h4 class="center red "><u>Schedule Of Land Settled</u></h4>
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
                            
                            <div class="form-group ">
                                <label for="inputEmail" class="col-lg-5 required  control-label uni_text">Dag Number <span class='green'>As per Settlement order</span> </label>
                                
                                <div class="col-lg-4">
                                    <!----<select class="form-control dag_number" name='dag_no'>
                                            
                                    </select>--->
                                    <!--<input type="text"  class="form-control" placeholder='Dag' value="<?php echo set_value('dag_no'); ?>" required name="dag_no" required="" > !-->
                                    
                                    <div class="col-sm-6">
                            <select class="form-control dag_no_saraS" id='dag_no' name='dag_no'>
                                <option>Select Dag </option>
                                <?php foreach ($govt_dag_no as $d): ?>
                                    <option><?php echo $d->dag_no; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                                    
                                    
                                    
                                    
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
                                  <select class="form-control " name="type_govt_land" required>
                                        <option value="" selected>Select Reason</option>
                                        <option value="চিলিং চৰকাৰী">চিলিং চৰকাৰী</option>
                                         <option value="সাধাৰন চৰকাৰী">সাধাৰন চৰকাৰী</option>
                                          <option value="এনাল চৰকাৰী">এনাল চৰকাৰী</option>
                                       
                                     </select>
                                </div>
                                    
                             <!--   <div class="col-lg-5">
                                    <input type="text" class="form-control" name="type_govt_land" placeholder='Type Here' >
                                </div> !-->
                            </div>
                        <?php
                          $dist_code = $this->session->userdata('dist_code');
                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-1">
                                    <input type="text" id='tb'  class="numberonly form-control" placeholder='Bigha' value="<?php echo set_value('tot_bigha'); ?>" name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-1">
                                    <input type="text"  id='tk' class="numberonly form-control" placeholder='Katha' name="tot_katha" value="<?php echo set_value('tot_katha'); ?>" required=""  >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                <div class="col-lg-1">
                                    <input type="text" id='tl'  class="numberonly form-control" name="tot_lessa" placeholder='Chatak' value="<?php echo set_value('tot_lessa'); ?>" required="" >
                                </div>  
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda  </label>
                                <div class="col-lg-1">
                                    <input type="text" id='tg'  class="numberonly form-control" name="tot_ganda" placeholder='Ganda' value="<?php echo set_value('tot_lessa'); ?>" required="" >
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputEmail" class="col-lg-3  control-label red">Area Settled   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="numberonly form-control" id='sb' name="alot_bigha" value="<?php echo set_value('alot_bigha'); ?>" required="" placeholder='Bigha' value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="numberonly form-control"  id='sk' name="alot_katha" value="<?php echo set_value('alot_katha'); ?>" placeholder='Katha' required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="numberonly form-control check_emptykr" id='sl' name="alot_lessa" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Chatak' required="" value="" >
                                </div>  
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="numberonly form-control check_emptykr" id='sg' name="alot_ganda" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Ganda' required="" value="" >
                                </div>  
                            </div>
                        <?php }else{?>
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
                                    <input type="text"  class="numberonly form-control" id='sb' name="alot_bigha" value="<?php echo set_value('alot_bigha'); ?>" required="" placeholder='Bigha' value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control"  id='sk' name="alot_katha" value="<?php echo set_value('alot_katha'); ?>" placeholder='Katha' required="" value="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="numberonly form-control check_empty" id='sl' name="alot_lessa" value="<?php echo set_value('alot_lessa'); ?>" placeholder='Lessa' required="" value="" >
                                </div>  
                            </div>

                        <?php }?>

                            
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
                                        <input type="text" name="premium" id='premium'  class="form-control"  value=""  placeholder='Premium' required> <span class='red'>Premium Amount</span>
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

     $(".check_emptykr").keyup(function(){
            var lessa_empty = $('#sl').val();
            var kotha_empty = $('#sk').val();
            var bigha_empty = $('#sb').val();
            var ganda_empty = $(this).val();
            if ((ganda_empty=='0') && (lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
                alert('Bigha-Katha-chatak-ganda for conversion cannot be 0-0-0-0 !');
                return;
            }
            calculateRemainingLandsettlementkarim();
            
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

       // $('#rb').val(bigha_r);
       // $('#rkatha').val(katha_r);
       // $('#rl').val(lessa_r);
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


     function calculateRemainingLandsettlementkarim() {

        var bigha =  $('#tb').val();
        var katha = $('#tk').val();
        var lessa = $('#tl').val();
        var ganda = $('#tg').val();
       

        window.sourcelessa = parseInt(bigha) * 6400 + parseInt(katha) * 320 + parseInt(lessa) * 20 + parseInt(ganda);
        console.log(window.sourcelessa);
        var mbigha = $('#sb').val();
        var mkatha = $('#sk').val();
        var mlessa = $('#sl').val();
        var mganda = $('#sg').val();
       

        window.targetlessa = parseInt(mbigha) * 6400 + parseInt(mkatha) * 320 + parseInt(mlessa) * 20 + parseInt(mganda);
        console.log(window.targetlessa);


        window.remaininglessa = sourcelessa - targetlessa;
        //alert(remaininglessa);

        $bigha_r = floor($remaining_lessa / 6400);
        $katha_r = floor(($remaining_lessa - $bigha_r * 6400) / 320);
        $lessa_r = floor(($remaining_lessa - $bigha_r * 6400 - $katha_r * 320)/20);
        $ganda_r = $remaining_lessa - $bigha_r * 6400 - $katha_r * 320 - $lessa_r * 20;

//        $('#rb').val(remaininglessa/100);
//        $('#rkatha').val(katha - mkatha);
//        $('#rl').val(lessa - mlessa);
//        $('#rg').val(ganda - mg);
//        $('#rk').val(krantik - mk);

       // $('#rb').val(bigha_r);
       // $('#rkatha').val(katha_r);
       // $('#rl').val(lessa_r);
      //  $('#rg').val(ganda - mg);
      //  $('#rk').val(krantik - mk);

        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
            $('#sb').val('');
         $('#sk').val('');
         $('#sl').val('');
         $('#sg').val('');
          
        }
         //alert(window.sourcelessa);
    }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        






 $('.dag_no_saraS').change(function (e) {
        var dag_no = $(this).val();
//alert(dag_no);

        $.ajax({
            url: baseurl + "Settlement/getLandAreaSettle/" + dag_no,
            success: function (data) {
                // if (debug) {
                //     console.log(data);
                // }
                var dag = JSON.parse(data);
                $('#tb').val(dag[0].dag_area_b);
                $('#tk').val(dag[0].dag_area_k);
                $('#tl').val(dag[0].dag_area_lc);
                $('#tg').val(dag[0].dag_area_g);
                
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