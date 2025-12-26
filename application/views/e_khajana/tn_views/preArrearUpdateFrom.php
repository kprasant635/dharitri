<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?php $arrear_year = EKHAJANA_PRE_ARREAR_YEARS ?>
<div class='container ' style="margin-top:20px">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaArrearController/index'?>">index</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">Pre-Update-Arrear-Form</li>
  </ol>
</nav>
<input type='hidden' name="dist_code" value="<?=$dist_code?>" id="dist_code">
<style>
    .arrear{display:flex;gap:8px;}
    .showTotalRevenue{width:100%;padding:10px;box-sizing:border-box;display:flex;justify-content:space-between;
        gap: 10px;font-size: 18px;font-weight: bold;color: green;text-align: center;}
    .showTotalRevenue div{flex:1 1;background:#f7e9e9;padding:7px;border-radius:5px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;}
    .showTotalRevenue div p{margin-bottom:4px;}
    .showTotalRevenue div span{color:red;}
</style>

<div class="container-fluid form-top login">
    <div class="col-lg-12">
        <div class="card mt-2">
            <div class="card-body">
                <div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
                    <h5 class="p-2 text-white shadow mt-2 text-center" style="margin-bottom:0px!important;background-color:#1c666a">
                        SELECT LOCATION FOR ARREAR PRE UPDATION
                    </h5>
                    <div class="card-text mt-2 lm-report">
                        <form class="form-horizontal" id="arrear_pre_updation_form" method="POST" action="<?php echo base_url() . 'index.php/EkhajanaTn/submitArrear?autoYear=' . EKHAJANA_DIRECT_PAYING_AUTO_YEAR_CONFIG; ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "District"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" id="dist" name="dist">
                                        <option value="<?=$dist_code?>" selected><?=$this->utilityclass->getDistrictName($dist_code)?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Sub Division"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" id="subdivison" onchange="subdivisonOnChange()" name="subdivison">
                                        <option value="00" selected>-ALL-SUBDIVISIONS-</option>  
                                        <?php foreach ($subdivisions as $subdiv):?>
                                            <option value="<?=$subdiv->subdiv_code?>"?>(<?=$subdiv->loc_name?>)</option>
                                        <?php endforeach;?>     
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Circle"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" onchange="circleOnChange()" id="circles" name="circles">
                                        <option value="00" selected>-ALL-CIRCLES-</option>
                                    </select>
                                </div>
                            </div>
                                
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Mouza"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" onchange="mouzaOnChange()" id="mouzas" name="mouzas">
                                        <option value="00" selected>-ALL-MOUZAS-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Lot"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" onchange="lotOnChange()" id="lots" name="lots">
                                        <option value="00" selected>-ALL-LOTS-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo $this->lang->line('vill_town')?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" onchange="VillageOnChange()" id="villages" name="villages">
                                        <option value="00" selected>-ALL-VILLAGES-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo $this->lang->line('patta_type')?>
                                </div>
                                <div class="col-sm-4">
                                <select class="js-single js-states form-control" style="width: 85%" onchange="getPattaNo()" id="patta_type_code" name="patta_type_code">
                                        <option value="00" selected>-ALL-PATTA-TYPE-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo $this->lang->line('patta_no')?>
                                </div>
                                <div class="col-sm-4"> 
                                <select class="js-single js-states form-control" style="width: 85%" id="patta_no" name="patta_no">
                                        <option value="00" selected>-ALL-PATTA-NO-</option>
                                </select>                             
                                </div>
                            </div>
                            <div class="row mb-3"></div>
                            <hr>
                            <div class="text-center">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4" style="text-align:center">
                                            <div class="col-sm-12" style="display:flex" >
                                                <button type="submit" class="btn btn-sm text-white"  style="padding: 5px!important;font-size: 14px;font-weight: bold;background-color:#1e5727"><i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                        Insert Arrear
                                                </button>
                                                &nbsp;
                                                <button id="MainIndex" class="btn btn-sm uni_text btn-danger"><i class='fa fa-home'></i>&nbsp;Back</button>
                                            </div>
                                        </div>
                                        <div class="col-4"></div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!-- Modal for arrear pre updation starts  -->
                            <div class="modal align-middle" id="Ek_Arrear_Pre_Update" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" style="max-width:70%">
                                    <div class="modal-content">
                                        <div class="modal-header text-white text-bold text-center bg-success">
                                            <h5 class="modal-title w-100">
                                                <u>
                                                    Arrear Pre Updation <br>
                                                </u>
                                                <u>
                                                    <?php echo $this->lang->line('district')?>: <?= $dist_name?>,
                                                    <?php echo $this->lang->line('subdivision')?>: <?= $subdiv_name?>,
                                                    <?php echo $this->lang->line('circle')?>: <?= $cir_name?>,
                                                    Mouza: <?= $mouza_name?>
                                                </u>
                                                <br>
                                                <u>
                                                    Patta No : <span id="patta_no_modal_arr"></span>
                                                    Patta Type : <span id="patta_type_code_modal_arr"></span>
                                                </u>
                                            </h5>
                                        </div>
                                        <!-- <form id="ek_arrear_pre_updatipn_form"> -->
                                            <div class="modal-body">
                                                <div class="form-group mb-5">
                                                    <div class="row">
                                                        <div class="col-3 text-center">
                                                            <span style="font-weight:bolder">Revenue-Year-(ভাস্কৰাব্দ)</span>                                                                
                                                        </div>                                                            
                                                        <div class="col-3 text-center">
                                                            <span style="font-weight:bolder">Revenue</span>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <span style="font-weight:bolder">Local-Tax</span>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <span style="font-weight:bolder">Arrear</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <?php foreach ($arrear_year as $year):?>    
                                                            <div class="col-3 text-center p-1 text-primary">
                                                                <span style="font-weight:bolder"><?=$year.'-'.($year+1)?>(ভাস্কৰাব্দ-<?=$year-593?>)</span> 
                                                                <input type="hidden" name ='years[]' value='<?=$year.'-'.($year+1)?>'  readonly class="form-control">
                                                            </div>
                                                            <div class="col-9 text-center p-1">
                                                                
                                                                <div class="arrear cal_row" >
                                                                    <input onkeyup = "plus_a(this)" type ="number" min='0' required class="form-control sec_a" placeholder="Revenue Amount" rows="3" name="revenue[]" id="revenue_<?=$year?>">
                                                                    </input>
                                                                    <input onkeyup = "plus_a(this)" type ="number" min='0' required class="form-control sec_b" placeholder="Local Tax Amount" rows="3" name="tax[]" id="tax_<?=$year?>">
                                                                    </input>
                                                                    <input readonly type ="number" required class="form-control cal_sum" placeholder="Arrear Amount" rows="3" name="arrear[]" id="arrear_<?=$year?>">
                                                                    </input>
                                                                </div>
                                                                
                                                            </div>
                                                        <?php endforeach;?>
                                                        <br><br><br>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-2"></div>
                                                            <div class="col-8">                                                                                                                                                                                                           
                                                                <div class="showTotalRevenue">
                                                                    <div>
                                                                        <span style="font-weight:bolder;margin-top:10px;text-align:center">Total:</span> 
                                                                    </div>
                                                                    <div>
                                                                        <p>Revenue</p>
                                                                        <span type="text" id="testss"></span>
                                                                        <input type="hidden" id="testssi" class="form-control mt-2"  name="total_revenue"></input>
                                                                    </div>
                                                                    <div>
                                                                        <p>Local Tax</p>
                                                                        <span type="text" id="testsb"></span>
                                                                        <input type="hidden" id="testsbi" class="form-control mt-2"  name="total_tax"></input> 
                                                                    </div>
                                                                    <div>
                                                                        <p>Arrear</p>
                                                                        <span type="text" id="testsc"></span>
                                                                        <input type="hidden" id="testsci" class="form-control mt-2"  name="total_arrear"></input> 
                                                                    </div>
                                                                </div>
                                                            </div>      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- validation-errors-div -->
                                            <div class="col-lg-12" id="ek_arrear_pre_updation_validation_error_div" style="display:none;">
                                                <div class="alert alert-warning alert-dismissible" role="alert">
                                                    <strong class="text-center" style="color:red !important"
                                                        id="ek_arrear_pre_updation_validation_error_msg">
                                                    </strong>
                                                </div>
                                            </div>
                                            <!-- validation-error-div-end -->
                                            <hr>
                                            <div class="row" align="center" style="padding:10px;">
                                                <div class="col-lg-12" align="center">
                                                    <button type="button" class="btn btn-sm btn-success" onclick="EkArearPreUpdationSubmit()">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                            Submit
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="EkArearPreUpdationClose()">
                                                        <i class="glyphicon glyphicon-remove-sign"></i>
                                                            Close
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal for arrear pre updation ends -->
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_tn.js"></script>


<script>

//  In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-single').select2();
})

$('.sec_a, .sec_b').on('keyup', function(){
    const closest = $(this).closest('.cal_row');
    cal_sum(closest);
});

function cal_sum(closestEl){
    let a = $('.sec_a', closestEl).val(); 
    let b = $('.sec_b', closestEl).val();
    if(a === NaN){
        a = 0;
    }
    if(b === NaN){
        b = 0;
    }
    let total = parseFloat(a) + parseFloat(b);
    $('.cal_sum', closestEl).val(total);
    get_total();
}

function get_total(){
    let totalSecA = 0;
    let totalSecB = 0;
    let totalSecC = 0;
    let total = 0;
    $('.sec_a').each(function() {
        // console.log($(this).val());
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecA = totalSecA + parseFloat($(this).val());
        }
    });
    $('.sec_b').each(function() {
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecB = totalSecB + parseFloat($(this).val());
        }
    });  
    $('.cal_sum').each(function() {  
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecC = totalSecC + parseFloat($(this).val());
        }
    });

    $('#testss').text(totalSecA);
    $('#testsb').text(totalSecB);
    $('#testsc').text(totalSecC);
    $('#testssi').val(totalSecA);
    $('#testsbi').val(totalSecB);
    $('#testsci').val(totalSecC);
}

function plus_c()
{
    var cca = 0;
    <?php 
        foreach ($arrear_year as $year)
        {
            ?>
                var count = "<?php echo $year;?>";
                var val = $('#arrear_'+count).val();
                if(val == '')
                {
                    val = 0;
                }
                cca = parseFloat(cca) + parseFloat(val) ;

            <?php
        }

    ?>
    // alert(cca);
    $('#testss').val(cca);
}

</script>




                        
               
                            
                        
               
                        

    
