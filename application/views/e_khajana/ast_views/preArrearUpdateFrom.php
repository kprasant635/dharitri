<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class='container ' style="margin-top:20px">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>">index</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">Pre-Update-Arrear-Form</li>
  </ol>
</nav>

<div class="container-fluid form-top login">
    <div class="col-lg-12">
        <div class="card mt-2">
            <div class="card-body">
                <div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
                    <h5 class="p-2 text-white shadow mt-2 text-center" style="margin-bottom:0px!important;background-color:#1c666a">
                        SELECT LOCATION FOR ARREAR PRE UPDATION
                    </h5>
                    <div class="card-text mt-2 lm-report">
                        <form class="form-horizontal" id="arrear_pre_updation_form" method="POST" action="<?php echo base_url() . 'index.php/EkhajanaAstController/submitArrear?autoYear=' . EKHAJANA_TEHSILDARI_AUTO_YEAR_CONFIG; ?>">
                            <input type='hidden' name="dist_code" value="<?=$dist_code?>" id="dist_code">
                            <input type='hidden' name="subdiv_code" value="<?=$subdiv_code?>" id="subdiv_code">
                            <input type='hidden' name="cir_code" value="<?=$cir_code?>" id="cir_code">
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "District"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%">
                                        <option selected><?=$this->utilityclass->getDistrictName($dist_code)?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Sub Division"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%">
                                        <option selected><?=$this->utilityclass->getSubDivName($dist_code,$subdiv_code)?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Circle"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%">
                                        <option selected><?=$this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code)?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                                    <?php echo "Mouza"?>
                                </div>
                                <div class="col-sm-4">
                                    <select class="js-single js-states form-control" style="width: 85%" id="mouza_pargona_code" onchange="mouzaOnChange()" name="mouza_pargona_code">
                                        <option value="00" selected>-ALL-MOUZAS-</option>  
                                        <?php foreach ($mouzas as $mouza):?>
                                            <option value="<?=$mouza->mouza_pargona_code?>"?>(<?=$mouza->loc_name?>)</option>
                                        <?php endforeach;?>     
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>


<script>

//  In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-single').select2();
})

</script>


                        
               
                            
                        
               
                        

    
