<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<style type="text/css">
    .mis_report{
        background:linear-gradient(45deg, #248cf7, #2d6ef6);
        padding-top: 10px;
        border-radius: 0px;
    }
    .cardH {
        padding: 0;
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color:#fafafa;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;;
    transition: all 150ms ease-in-out;
    }

    .col-lg-6{
        margin-bottom: 15px;
    }
    /*my css*/
    .card-title {margin-bottom:20px;font-weight: 600;font-size: x-large;}
    .nHeading{font-weight: 600;text-transform: uppercase;letter-spacing: 1px;
    font-size:18px;text-align:center;color:white;}
    .form-control{border-radius: 0px;background:white;margin-top: 2px;height: 45px;} 
    #page-content-wrapper{background:white}  
    label{font-weight:bold;font-size: 15px;letter-spacing: 0.4px;}         
    .card-body{padding-top:0px;}
    .landAr{display:grid; grid-template-columns:100px 325px; justify-content:space-between;align-items:center}
    .landAr div.three{display: flex;justify-content: end;gap: 15px;}
    .landAr div.three p{margin-bottom:12px;text-align:left;}
    .landAr #landArea{background: aquamarine;width: max-content;padding: 10px;box-sizing: border-box;font-size: 18px;font-weight: bold;height:50px;display: flex;align-items: center;position:relative;z-index: 1;color: darkred;border: 1px solid darkred;border-radius:8px;margin-top: 10px;
    }
    #landArea::after{position: absolute;right:-11px;background:aquamarine;width:20px;height:20px;content:"";z-index: -1;transform:rotate(45deg);border-right:1px solid darkred;border-top: 1px solid darkred;}
    .card-heading{margin-bottom:20px;}
    label{margin-bottom:10px;}
    .otherInfo{display: grid;grid-template-columns: 1fr 1fr;gap:65px;}
    .agril{display: flex;flex-direction: column;background:linear-gradient(45deg, #a3f0b0, #a1f2ed);box-sizing: border-box;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;padding: 15px;border-radius: 10px;}
    .radio-inline.myradio{display:flex;gap: 35px; font-weight: bold;}
    .radio-inline.myradio div span{margin-left:8px;font-weight:bold;}
    .radio-inline.myradio div input{box-shadow:none;}
    .partition{background:linear-gradient(45deg, #9cefeb, #9fc6f2)}
    .landAreaDetail tbody{font-size:20px !important;}
    .landAreaDetail tbody>tr>td{vertical-align: middle;font-weight:bold;}
    .landAreaDetail tbody>tr>td>input{height:38px;}
    .landAreaDetail th.Theading{background: linear-gradient(45deg, #8aee97, #3cf6c2);
    height: 45px; vertical-align: middle;font-size: 16px;}
    .bg-info {background: linear-gradient(45deg, #4e69ee, #993ce8);border-radius: 8px;color: white;font-weight: 600;letter-spacing: 1px;border-bottom: 3px solid #2826294a;}
    .bg-info button{margin-left: 20px;font-weight: bold; padding: 6px 10px;}
    center>button[type='submit']{padding: 8px 20px;font-size: 15px;font-weight: bold;outline: 4px solid #ffc10736;}
    center>button i{font-size:16px;margin-left:8px;}
    #fieldList button{background: #d64141;border-radius: 5px;width: 100px;margin-top: 35px;}
    #fieldList input{height:auto;}
    
    
</style>


<form method="post" action="<?php echo base_url(); ?>index.php/SuomotoReclassification/suomotoreclassPost" enctype="multipart/form-data">


<div class="row login">
        <div class="cardH col-md-12">
             <!-- <h2 style="text-align: center; font-size: 28px"> <?php echo $this->lang->line('write_proposal_for_land_suomoto_reclassification');?> </h2> -->
           <div class="well well-sm mis_report">
                <h2 class="nHeading"> <?php echo $this->lang->line('write_proposal_for_land_suomoto_reclassification');?> </h2>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
        <?php include 'message.php'; ?>
    <?php endif; ?>
    
            <div class="card-body">
                <div class="card-heading mt-3">
                    <h3 class="card-title"><i class="bi bi-pin-map-fill"></i> <?php echo $this->lang->line('select_location');?></h3>
                </div>
                <hr>
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
                    <div class="col-lg-6 col-md-6  col-sm-12 col-xs-12">
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

                    <div class="card-heading"style="margin-top:30px;">
                    <h3 class="card-title"><i class="bi bi-highlights"></i> Dag Details</h3>
                    <hr>
                    </div>
                   

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Dag No:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="dag_no"  class="form-control" id="dagno" required>
                                <option value="">Select No </option>
                            </select>
                        <!-- </div> -->
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="landAr">
                        <div>
                    <div id="landArea">Land Area:</div>
                    </div>
                    
                    <div class="three">
                        <div>
                            <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                            <input type="text" class="form-control" id='bigha' name='dag_area_b' placeholder="বিঘা" readonly>
                        </div>

                        <div>
                            <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                            <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="Katha" readonly>
                        </div>
                        <div>
                            <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                            <input type="text" class="form-control"  id='lessa' name='dag_area_lc' placeholder="Lessa" readonly>
                        </div>
                    </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Existing land Class<span style="color: red;font-weight: bold;"> *</span></label>

                            <input type="hidden" class="form-control" id='land_code' name='land_code' readonly>
                             <input type="text" class="form-control" id='land_type' name='land_type' readonly>
                        <!-- </div> -->
                    </div>
                    

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                        <!-- <div class="form-group"> -->
                            <label for="sel1">Present Land Class:<span style="color: red;font-weight: bold;"> *</span></label>
                            <select name="land_type_present"  class="form-control" id="land_type_present" required>
                                <option value="">Select No </option>
                            </select>
                        <!-- </div> -->
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                         <label for="sel1"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                                
                                    <input type="text" class="form-control" id="P_land" placeholder="Revenue" name="P_land_rev">
                               
                            </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                        <label for="sel1"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                        
                                    <input type="text" class="form-control" id="p_loc_tax" placeholder="" name="p_local_tax" readonly>
                     
                    </div>
                </div>
                

                    <div class="card-heading mt-5">
                    <h3 class="card-title"><i class="bi bi-info-circle-fill"></i> Other Information</h3>
                    </div>
                 
                    <div class="otherInfo">
                    
                        <div class="agril">
                            <label>Is Land used for more than 10 years as Agri?</label>
                            <div class="radio-inline myradio" >
                                <div>
                                    <input type="radio" class="squaredTwo" id="agri" name="is_ten" value="Y"><span>YES</span>
                                </div>
                                <div>
                                    <input type="radio" class="squaredTwo" id="nonagri" name="is_ten" value="N"><span>NO</span>
                                </div>
                            </div>
                        </div><!--eng agril-->
                    <div class="agril partition">
                    <label for="inputEmail3" class="control-label">Want to apply for Partition?</label>
                    <div class="radio-inline myradio" >
                        <div >
                            <input type="radio" class="squaredTwo" id="ispart" name="is_part" value="Y"> <span>YES</span>
                        </div>
                        <div>
                            <input type="radio" class="squaredTwo" id="nopart" name="is_part" value="N"> <span>NO</span>
                        </div>
                    </div>
                    </div> 
                    </div>

                     <table class="table table-striped table-bordered mt-5 landAreaDetail" id='partarea' style="display: none; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            <thead>
                                <th colspan="5" class="Theading"><i class="bi bi-pin-map-fill"></i> Land Area Details</th>
                            </thead>
                            <thead style="white-space:nowrap; width:100%;height:38px;">
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
                        <input type="hidden" name="pattadarcount" id="pattadarcount">
                     
                      <div class="card" id='selectpattadars' style="display:none;">
                        <div class="card-heading">
                        <h3 class="card-title">Select Pattadar for Partition</h3>
                        </div>
                        <br>
                        <div class="list-group" id="deleted_pattadar" style="height:300px;overflow:auto;">

                            
                        </div>
                    </div>
                       

                    <div class="form-group mt-4"> 
                    <label for="inputEmail3" class="col-sm-12 control-label " style="text-align:left"><i class="bi bi-clipboard-check-fill"></i> Enter your remark</label>
                      <div>
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
                    <button type="submit" class="btn btn-sm btn-primary">Forward <i class="bi bi-arrow-right-circle"></i></button>
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


        $('#P_land').keyup(function (e) {
        var P_land_rev = $(this).val();
        var loc_tax = (P_land_rev) / 4;
        var tot_rev = $('#tot_rev').val();
        //alert (loc_tax);
        var total = parseFloat(loc_tax) + parseFloat(P_land_rev);
        window.sourcelessa = total;
        console.log(window.sourcelessa);
        //alert (window.sourcelessa);
        $('#p_loc_tax').val(loc_tax);
        $('#rev_diff').val(parseFloat(window.sourcelessa - tot_rev).toFixed(2));
    });

        

        $('#deleted_pattadar').change(function (e) {
        var pattadarcount= $('#pattadarcount').val();

        var bigha = $('#bigha').val();
        var katha = $('#katha').val();
        var lessa = $('#lessa').val();  
       //var ganda = $('#ganda').val();
        //var krantik = $('#kr').val();
        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);

        var mbigha = $('#part_bigha').val();
        var mkatha = $('#part_katha').val();
        var mlessa = $('#part_lessa').val();
      //  var mg = $('#part_ganda').val();
       // var mk = $('#mut_kr').val();
        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);

        if(pattadarcount==1){
            if (window.sourcelessa > window.targetlessa) {

                alert('In case of single pattadar partial partition is not allowed!!');
                $('#part_bigha').val('');
                $('#part_katha').val('');
                $('#part_lessa').val('');
                $('#selectpattadars').hide();
                $('.uncheckpdar').attr('checked', false);
        }
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


