<?php if ($this->session->flashdata('message')): ?>
    <?php include 'message.php'; ?>
<?php endif; ?>
<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="col-lg-8 col-lg-offset-2">
    <div class="well well-sm mis_report mt-5" style="background-color:#fdd918;margin-bottom:0px;">
        <h3 style="text-align: center; font-size: 28px;">Amdani Report Form</h3>
        <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
    </div>
    <div class="panel panel-form">
        <div class="panel-body">
            <form id="amdaniReportForm">
                <input type="hidden" id="amdaniReportFormSubmitUrl" 
                value="<?php echo base_url() . 'index.php/EkhajanaReportController/amdaniReport' ?>">
                <!-- mouza-selection  -->
                <div class="row mt-1">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    MOUZA
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="ek_mouza_code" 
                                onchange="getVillageList()" name="ek_mouza_code">
                                    <option value="00" selected>-ALL-MOUZA-</option>   
                                    <?php foreach ($mouza_list as $mouza):?>
                                            <option value="<?=$mouza->mouza_pargona_code?>"><?=$mouza->loc_name?>(<?=$mouza->locname_eng?>)</option>
                                        <?php endforeach;?>                                 
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>     
                <!-- village-selection  -->
                <div class="row mt-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    VILLAGE
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="village_uuid" 
                                onchange="villageOnChange()" name="village_uuid">
                                    <option value="00" selected>-ALL-VILLAGE-</option>  
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>     
                <!-- patta-type-selection  -->
                <div class="row mt-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    PATTA TYPE
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" onchange="getPattaNo()" 
                                id="patta_type_code" name="patta_type_code">
                                    <option value="00" selected>-ALL-PATTA-TYPE-</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>  
                <!-- patta-no-selection  -->
                <div class="row mt-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    PATTA NO
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="patta_numbers" name="patta_no">
                                    <option value="00" selected>-ALL-PATTA-NO-</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    DATE(FROM-DATE)<span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-5 text-left">
                                <input class="form-control stdate" id="popupDatepicker" type="text" name="start_date" placeholder="dd-mm-yyyy">
                                <span class="help-block">Transaction start from date</span>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    DATE(TO-DATE)<span class="text-danger h4">*</span>
                                </label>
                            </div>
                            <div class="col-lg-5 text-left">
                                <input class="form-control stdate" id="popupDatepicker" type="text" name="to_date" placeholder="dd-mm-yyyy">
                                <span class="help-block">Transaction upto date</span>
                            </div>
                        </div>                    
                    </div>
                </div>
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="ekAr_error_div" style="display:none;margin-top:1rem">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important" id="ekAr_error_div_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <hr style="border-bottom: 2px solid #000;">
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-3">
                        <button type="submit" name="AMDANISubmit" class="btn btn-success" onclick="amdaniReportFormDetailsSubmit()"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                        <button type="reset" name="AMDANISu" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_report.js"></script>