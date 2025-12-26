
<style type="text/css">
    .mis_report{
        background: #248cf7 !important;
       
        padding-top: 10px;
    }
    .cardH {
        padding: 0;
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
    box-shadow: 1px 1px 5px 0px rgba(82, 82, 82, 0.75);
    transition: all 150ms ease-in-out;
    }

    .col-lg-6{
        margin-bottom: 15px;
    }

</style>


<form method="post" action="<?php echo base_url(); ?>index.php/SuomotoReclassification/suomotoreclassPost" enctype="multipart/form-data">


<div class="row login">

    
        <div class="cardH col-md-12">
             <!-- <h2 style="text-align: center; font-size: 28px"> <?php echo $this->lang->line('write_proposal_for_land_suomoto_reclassification');?> </h2> -->
           <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: white; font-size: 21px; font-weight: bold !important;"> <?php echo $this->lang->line('write_proposal_for_land_suomoto_reclassification');?> </h2>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
        <?php include 'message.php'; ?>
    <?php endif; ?>
                        
            <div class="card-body">
                <div class="card-heading">
                    <h3 class="card-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <hr style="border-bottom: 3px solid #248cf7;">
                <div class="card-body">

                         <input type="hidden" name="base" id="base" value="<?=$base ?>">
                       

                <br>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="dist_code" class="form-control" id="d" required>
                                <?php $dist_code=$this->session->userdata('dist_code');?>
                                <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>
                  
                            </select>

                        <!-- </div> -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Sub-Div:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="subdiv_code"  class="form-control"  id="sd" required>
                               <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                            </select>
                        <!-- </div> -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="cir_code"  class="form-control" id="c"  required>
                               <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                    </option>
                            </select>
                        <!-- </div> -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="mouza_pargona_code"  class="form-control" id="m" required >
                                <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                    <option value="<?php echo $mouza_code;?>"  selected>
                                        <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_code);?>
                                    </option>
                            </select>
                        <!-- </div> -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Lot:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="lot_no"  class="form-control" id="l" required >
                                <?php 
                                    $lot_no=$this->session->userdata('lot_no');
                                    $lot_name=$this->utilityclass->getLotLocationName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no);
                                    ?>
                                    <option value="<?php echo $lot_no;?>"  selected>
                                        <?php echo $lot_name;?>
                                    </option>
                            </select>
                        <!-- </div> -->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="vill_townprt_code"  class="form-control" id="v" required>
                                <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                            </select>
                        <!-- </div> -->
                    </div>




                    <div class="card-heading">
                    <h3 class="card-title">Dag Details</h3>
                    </div>
                    <br>

                    <hr style="border-bottom: 3px solid #248cf7;">
                
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Dag No:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="dag_no"  class="form-control" id="dagno" required>
                                <option value="">Select No </option>
                            </select>
                        <!-- </div> -->
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    
                    <label for="inputEmail3" class="col-sm-3 control-label">Land Area:</label>
                    
                    
                    <div class="col-sm-3">
                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                        <input type="text" class="form-control" id='bigha' name='dag_area_b' placeholder="বিঘা" readonly>
                    </div>

                    <div class="col-sm-3">
                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                        <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="Katha" readonly>
                    </div>
                    <div class="col-sm-3">
                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                        <input type="text" class="form-control"  id='lessa' name='dag_area_lc' placeholder="Lessa" readonly>
                    </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Existing land Class<span style="color: red;font-weight: bold;"> *</span></label>

                            <input type="hidden" class="form-control" id='land_code' name='land_code' readonly>
                             <input type="text" class="form-control" id='land_type' name='land_type' readonly>
                        <!-- </div> -->
                    </div>
                    

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Present Land Class:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="land_type_present"  class="form-control" id="land_type_present" required>
                                <option value="">Select No </option>
                            </select>
                        <!-- </div> -->
                    </div>
                </div>
                <br>

                    <div class="card-heading">
                    <h3 class="card-title">Other Information</h3>
                    </div>
                 

                    <hr style="border-bottom: 3px solid #248cf7;">

                    <div class="form-group col-lg-12">
                    <label for="inputEmail3" class="col-sm-6 control-label">Is Land used for more than 10 years as Agri?</label>
                    <div class="radio-inline col-sm-6" >
                        <label class="col-sm-3"><input type="radio" class="squaredTwo" id="agri" name="is_ten" value="Y">  &nbsp; Yes</label>
                        <label class="col-sm-3"><input type="radio" class="squaredTwo" id="nonagri" name="is_ten" value="N"> &nbsp; No</label>
                    </div>
                    </div> 

                    <div class="form-group col-lg-12">
                    <label for="inputEmail3" class="col-sm-6 control-label">Want to apply for Partition?</label>
                    <div class="radio-inline col-sm-6" >
                        <label class="col-sm-3"><input type="radio" class="squaredTwo" id="ispart" name="is_part" value="Y"> &nbsp; Yes</label>
                        <label class="col-sm-3"><input type="radio" class="squaredTwo" id="nopart" name="is_part" value="N"> &nbsp;  No</label>
                    </div>
                    </div>  

                     

                     <table class="table table-striped table-bordered" id='partarea' style="display: none;">
                            <thead>
                                <th style="background-color: #136a6f; color: #fff" colspan="5">Land Area Details</th>
                            </thead>
                            <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th>Description</th>
                                    <th>Bigha</th>
                                    <th>Katha</th>
                                    <th>Lessa</th>
                                    <!-- <th>Ganda</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Area to be Partitioned</td>
                                    <td>
                                        <input type='number' maxlength="6" class="form-control"  placeholder='Bigha' name="part_bigha" id="part_bigha" required="" oninput="validateFloatInput(this)">
                                    </td>
                                    <td>
                                        <input type='number' maxlength="2" class="form-control" placeholder='Katha' name="part_katha" id="part_katha" required="" >
                                    </td>
                                    <td>
                                        <input type='number' maxlength="5"  class="form-control" name="part_lessa" placeholder='Lessa' id="part_lessa" required="" >
                                    </td>
                                    <!-- <td>
                                        <input type='number' maxlength="2" class="form-control" name="part_ganda" placeholder='Ganda' id="part_ganda" required="" >
                                    </td> -->
                                </tr>
                                
                            
                            </tbody>
                        </table>


                        <table class="table table-striped table-bordered" id='showpattadars' style="display: none;">
                            <thead>
                                <th style="background-color: #136a6f; color: #fff" colspan="5">Pattdars</th>
                            </thead>
                            <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th>Name</th>
                                    <th>Fathers Name</th>
                                </tr>
                            </thead>
                            <tbody id='pattadardetails'>
                               
                            </tbody>
                        </table>
                        <br>

                     
                      <div class="card" id='selectpattadars' style="display:none;">
                        <div class="card-heading">
                        <h3 class="card-title">Select Pattadar for Partition</h3>
                        </div>
                        <br>
                        <div class="list-group" id="deleted_pattadar" style="height:300px;overflow:auto;">
                            
                        </div>
                    </div>
                        <br>


                    <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label " style="text-align:left">Enter your remark</label>
                      <div class="col-sm-12">
                        <textarea class="form-control" id='reapply_remark' name='remark' placeholder="" rows="5">
                        </textarea>

                        <textarea name="remark_suffix" class="form-control hidden" rows="5"><?php echo $user->lm_name; ?></textarea>
                        <input type="hidden" name="lm_code" value="<?php echo $user->lm_code; ?>">
                      </div>
                      
                      </div>

                       <?php  include(APPPATH."views/common/addMoreDocumentView.php");?>



                </div>
                <center>
                <span id='loading'></span><span id='msg'></span>
                          <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                </center>
                    
                </div>
            </div>
        </div>
    </div>
</form>


<script src="<?= base_url('application/views/js/location.js') ?>"></script>

<script type="text/javascript">

    function validateFloatInput(input) {
      // Remove non-numeric characters and validate float
      input.value = input.value.replace(/[^0-9.]/g, '');

      // Split the input value by dot (.)
      var parts = input.value.split('.');

      // Allow only one dot in the input
      if (parts.length > 2) {
        input.value = parts[0] + '.' + parts.slice(1).join('');
      }
    }


    $(document).ready(function () {
        // $("#ispart").click(function () {
        //     $("#partarea").show();
        //    // $(".partarea").hide();
        // });
        $("input[type=radio][name=is_part]").change(function() {
            

            var ispart = $("input[name='is_part']:checked").val();
            //alert(ispart);

            if(ispart=='Y'){
                $("#partarea").show();
            }

            if(ispart=='N'){
            $("#partarea").hide();


            $('#part_bigha').val(" ");
            $('#part_katha').val(" ");
            $('#part_lessa').val(" ");
            $('#part_ganda').val(" ");

            $('#selectpattadars').hide();
            $('#showpattadars').hide();
        }

        });



    $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'SuomotoReclassification/suomotoreclassPost', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
                    },
            success: function(data){
              console.log(data);
              if(data.success!=null){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
              }
            },
        });
    });
    });
  


  function landCalculation() 
{
    var bigha = $('#bigha').val();
    var katha = $('#katha').val();
    var lessa = $('#lessa').val();  
   //var ganda = $('#ganda').val();
    //var krantik = $('#kr').val();
    window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
   // console.log('ghg'+window.sourcelessa);

    var mbigha = $('#part_bigha').val();
    var mkatha = $('#part_katha').val();
    var mlessa = $('#part_lessa').val();
  //  var mg = $('#part_ganda').val();
   // var mk = $('#mut_kr').val();
    window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);

   // console.log('xyz'+window.targetlessa);
    
    if (window.sourcelessa < window.targetlessa) {
        alert('Partition Land Area should be less than the area available in Chitha..');

        $('#part_bigha').val('');
        $('#part_katha').val('');
        $('#part_lessa').val('');
        //$('#part_ganda').val('');

        $('#showpattadars').hide();
        $('#selectpattadars').hide();
        
    }

    if (window.sourcelessa === window.targetlessa) {
        
        $('#showpattadars').show();
        $('#selectpattadars').hide();
    }

    if (window.sourcelessa > window.targetlessa) {
        $('#selectpattadars').show();
        $('#showpattadars').hide();
    }
    
    
    // if(parseInt(mkatha) >= 5)
    // {
    //     bigha_cal = Math.floor((mkatha*20)/100);
    //     bigha_value = (mkatha*20)/100;
    //     bigha1 = bigha_value.toFixed(2);

    //     decimalbigha = bigha1 - Math.floor(bigha1);
    //     kathareminder = decimalbigha.toFixed(2);

    //     katha_cal = (kathareminder*100)/20;

    //     var mbigha = $('#part_bigha').val(bigha_cal);
    //     var mkatha = $('#part_katha').val(katha_cal);
    //     var mlessa = $('#part_lessa').val(0);
    //     $('#part_ganda').val(0);

    //     window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
    //     window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);

    //     alert(targetlessa);

    //     if (window.sourcelessa === window.targetlessa) {
        
    //     $('#showpattadars').show();
    //     $('#selectpattadars').hide();
    //     }

    //     if (window.sourcelessa > window.targetlessa) {
    //         $('#selectpattadars').show();
    //         $('#showpattadars').hide();
    //     }


        
    // }

    //lessa katha calculation
    // if(parseInt(mlessa) >= 20)
    // {   
    //     katha_cal = Math.floor((mlessa)/20);
    //     katha_value = (mlessa)/20;
    //     katha1 = katha_value.toFixed(2);

    //     decimalkatha = katha1 - Math.floor(katha1);
    //     lessa_cal = decimalkatha.toFixed(2);

    //     $('#part_bigha').val(0);
    //     $('#part_katha').val(katha_cal);
    //     $('#part_lessa').val(lessa_cal);
    //     $('#part_ganda').val(0);
    //     // $('#mut_kr').val(0);
    //  }

    // //lessa bigha calculation
    // if(parseInt(mlessa) >= 100)
    // {   
    //     bigha_cal = Math.floor((mlessa)/100);
    //     bigha_value = (mlessa)/100;
    //     bigha1 = bigha_value.toFixed(2);

    //     decimalbigha = bigha1 - Math.floor(bigha1);
    //     kathareminder = decimalbigha.toFixed(2);

    //     katha_cal = Math.floor((kathareminder*20)/100);
    //     katha_value = (kathareminder*20)/100;
    //     katha1 = katha_value.toFixed(2);

    //     decimalkatha = katha1 - Math.floor(katha1);
    //     lessa_cal = decimalkatha.toFixed(2);

    //     $('#part_bigha').val(bigha_cal);
    //     $('#part_katha').val(katha_cal);
    //     $('#part_lessa').val(lessa_cal);
    //     $('#part_ganda').val(0);
    //     // $('#mut_kr').val(0);
    // }
}

$('#part_bigha').change(function(){
    landCalculation();

    $('.uncheckpdar').attr('checked', false); 
});
$('#part_ganda').change(function(){
    landCalculationKar();
});

$('#part_katha').change(function(){
    var mbigha = $('#part_bigha').val();
    var mkatha = $('#part_katha').val();
    var mlessa = $('#part_lessa').val();

    landCalculation();
     $('.uncheckpdar').attr('checked', false); 
    
    // if(parseInt(mkatha) >= 5)
    // {
    //     bigha_cal = Math.floor((mkatha*20)/100);
    //     bigha_value = (mkatha*20)/100;
    //     bigha1 = bigha_value.toFixed(2);

    //     decimalbigha = bigha1 - Math.floor(bigha1);
    //     kathareminder = decimalbigha.toFixed(2);

    //     katha_cal = (kathareminder*100)/20;

    //     $('#part_bigha').val(bigha_cal);
    //     $('#part_katha').val(katha_cal);
    //     $('#part_lessa').val(0);
    // }
});
$('#mut_k_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();

    landCalculationKar();
    
});

$('#part_lessa').change(function(){
    var mbigha = $('#part_bigha').val();
    var mkatha = $('#part_katha').val();
    var mlessa = $('#part_lessa').val();
    landCalculation();

    $('.uncheckpdar').attr('checked', false); 

    //lessa katha calculation
    // if(parseInt(mlessa) >= 20)
    // {   
    //     katha_cal = Math.floor((mlessa)/20);
    //     katha_value = (mlessa)/20;
    //     katha1 = katha_value.toFixed(2);

    //     decimalkatha = katha1 - Math.floor(katha1);
    //     lessa_cal = decimalkatha.toFixed(2);

    //     $('#part_bigha').val(0);
    //     $('#part_katha').val(katha_cal);
    //     $('#part_lessa').val(lessa_cal);
    // }

    // //lessa bigha calculation
    // if(parseInt(mlessa) >= 100)
    // {   
    //     bigha_cal = Math.floor((mlessa)/100);
    //     bigha_value = (mlessa)/100;
    //     bigha1 = bigha_value.toFixed(2);

    //     decimalbigha = bigha1 - Math.floor(bigha1);
    //     kathareminder = decimalbigha.toFixed(2);

    //     katha_cal = Math.floor((kathareminder*20)/100);
    //     katha_value = (kathareminder*20)/100;
    //     katha1 = katha_value.toFixed(2);

    //     decimalkatha = katha1 - Math.floor(katha1);
    //     lessa_cal = decimalkatha.toFixed(2);

    //     $('#part_bigha').val(bigha_cal);
    //     $('#part_katha').val(katha_cal);
    //     $('#part_lessa').val(lessa_cal);
    // }    
});

$('#mut_lc_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    landCalculationKar();
    //lessa katha calculation

});

$('#mut_g_kr').change(function(){
    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();
    landCalculationKar();
    //lessa katha calculation

});

function landCalculationKar() 
{
    var bigha = $('#b').val();
    var katha = $('#k').val();
    var lessa = $('#lc').val();  
    var ganda = $('#g').val();
    var krantik = $('#kr').val();
    window.sourcelessa = parseFloat(bigha)*6400 + parseFloat(katha)*320 + parseFloat(lessa)*20+parseFloat(ganda);
    console.log(window.sourcelessa);

    var mbigha = $('#mut_b_kr').val();
    var mkatha = $('#mut_k_kr').val();
    var mlessa = $('#mut_lc_kr').val();
    var mg = $('#mut_g_kr').val();
    var mk = $('#mut_kr_kr').val();
    window.targetlessa = parseFloat(mbigha)*6400 + parseFloat(mkatha)*320 + parseFloat(mlessa)*20+parseFloat(mg);
    
    if (window.sourcelessa < window.targetlessa) {
        alert('Partition Land Area should be less than the area available in Chitha..');

        $('#mut_b_kr').val(0);
        $('#mut_k_kr').val(0);
        $('#mut_lc_kr').val(0);
        $('#mut_g_kr').val(0);
        $('#mut_kr_kr').val(0);
    }

     if(parseInt(mkatha) >= 20)
        {
            alert("Maximum allowed size is 19");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }

        if(parseFloat(mlessa) >= 16)
        {
            alert("Maximum allowed size is 16");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }

        if(parseFloat(mg) >= 20)
        {   
            alert("Maximum allowed size is 20");
            $('#mut_b_kr').val(0);
            $('#mut_k_kr').val(0);
            $('#mut_lc_kr').val(0);
            $('#mut_g_kr').val(0);
        }
}
$("#seeJamaClick").click(function(event){
    $('#seeJama').submit();
});
</script>
