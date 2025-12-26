<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoArrearUpdateController/index'?>">ARREAR-UPDATE(CO)</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">ARREAR-UPDATE-FORM(CO)</li>
  </ol>
</nav>
<form id="mouzadar_arrear_update_form">
    <div class="row" style='margin-top:20px'>               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-info text-white text-center">
                PATTADAR SELECTION 
            </div>
            <div class="card-header h6 bg-red text-white text-center">
                NOTE: ARREAR CAN BE UPDATED ONLY IF ONLINE TRANSACTION DOESNOT START
            </div>
            <div class="card-body">
                <!-- mouza-selection  -->
                <div class="row mt-1">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    MOUZA <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="ek_mouza_code" 
                                onchange="getVillageList()" name="ek_mouza_code">
                                    <option value="" selected disabled>-SELECT-MOUZA-</option>   
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
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    VILLAGE <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="village_uuid" 
                                onchange="villageOnChange()" name="village_uuid">
                                    <option value="" selected disabled>-SELECT-VILLAGE-</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>     
                <!-- patta-type-selection  -->
                <div class="row mt-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    PATTA TYPE <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" onchange="getPattaNo()" 
                                id="patta_type_code" name="patta_type_code">
                                    <option value="" selected disabled>-SELECT-PATTA-TYPE-</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>  
                <!-- patta-no-selection  -->
                <div class="row mt-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    PATTA NO <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" id="patta_numbers" 
                                onchange="geCurrenttRevenueAndTax()" name="patta_no">
                                    <option value="" selected disabled>-SELECT-PATTA-NO-</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>
                <!-- pattadar-selection  -->
                <div class="row mt-3 hide">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    PATTADAR <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <select class="js-single js-states form-control" style="width: 85%" 
                                id="pattadars" name="pattadar" onchange="pattadarOnChangeHandle()">
                                    <option value="" selected disabled>-SELECT-PATTADAR--</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-info text-white text-center">
                KHAJANA DETAILS
            </div>
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    OPENING BALANCE(RS) <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="openinig_balance" id="openinig_balance"
                                placeholder="-OPENING-BALANCE-">
                            </div>
                        </div>                    
                    </div>
                </div>  
                <div class="row mt-3">
                    <div class="col-lg-1"></div>                                        
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    CURRENT REVENUE(RS) <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control text-danger" id="current_revenue" name="current_revenue" 
                                placeholder="-CURRENT-REVENUE-" readonly>
                            </div>
                        </div>                    
                    </div>
                </div>     
                <div class="row mt-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    CURRENT LOCAL TAX(RS)<span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control text-danger" id="current_local_tax" name="current_local_tax"
                                    placeholder="-CURRENT-LOCAL-TAX-" readonly>
                            </div>
                        </div>                    
                    </div>
                </div>     
                <div class="row mt-3">
                    <div class="col-lg-1"></div>                                        
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    LAST PAY DATE <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" placeholder = "-LAST-PAY-DATE-" 
                                id="last_pay_date" name="last_pay_date" readonly>
                            </div>
                        </div>                    
                    </div>
                </div>  
                <div class="row mt-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    LAST REVENUE PAYMENT AMOUNT(RS)<span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="last_revenue_payment_amount"
                                id="last_revenue_payment_amount" placeholder="-LAST-REVENUE-PAY-AMOUNT-">
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    LAST LOCAL TAX PAYMENT AMOUNT(RS) <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="last_local_tax_payment_amount"
                                id="last_local_tax_payment_amount" placeholder="LAST-LOCAL-TAX-PAY-AMOUNT">
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-info text-white text-center">
                LAST PAYEE DETAILS
            </div>
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    LAST PAYMENT BY <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="paymentBy" id="paymentBySelfRadio" value="self">
                                    SELF
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="paymentBy" id="paymentByOtherRadio" value="other">
                                    OTHER
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>  
                <!-- payment-details-div -->
                <div style="display: none;" id="payee_details_div">
                    <div class="row mt-1">
                        <div class="col-lg-1"></div>                                        
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        PAYEE NAME <span class="text-danger h4">*</span>
                                    </label>            
                                </div>
                                <div class="col-lg-6 text-left">
                                    <input type="text" class="form-control" name="payee_name" 
                                    placeholder="-PAYEE-NAME-">
                                </div>
                            </div>                    
                        </div>
                    </div>     
                    <div class="row mt-3">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        PAYEE RELATION <span class="text-danger h4">*</span>
                                    </label>            
                                </div>
                                <div class="col-lg-7 text-left">
                                    <select class="js-single js-states form-control" style="width: 85%" id="payee_relation" 
                                    name="payee_relation">
                                        <option value="" selected disabled>-SELECT-PAYEE-RELATION-</option>
                                        <?php foreach ($payee_relations as $payee_relation):?>
                                            <option value="<?=$payee_relation->id?>"><?=$payee_relation->guard_rel_desc_as?>(<?=$payee_relation->guard_rel_desc?>)</option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>                    
                        </div>
                    </div>     
                    <div class="row mt-3">
                        <div class="col-lg-1"></div>                                        
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        PAYEE CONTACT NO
                                    </label>            
                                </div>
                                <div class="col-lg-6 text-left">
                                    <input type="text" class="form-control" name = "payee_contact_no"
                                    placeholder="-PAYEE-CONTACT-NO-">
                                </div>
                            </div>                    
                        </div>
                    </div>  
                    <div class="row mt-3">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        PAYEE EMAIL                                
                                    </label>            
                                </div>
                                <div class="col-lg-6 text-left">
                                    <input type="text" class="form-control" name="payee_email" 
                                    placeholder="-PAYEE-EMAIL-">
                                </div>
                            </div>                    
                        </div>
                    </div>
                </div>            
                <!-- payment-details-div-end -->
            </div>
        </div>
    </div>
    <div class="row">               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-body">
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="cauf_error_div" style="display:none;">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="cauf_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <button class="btn btn-success btn-sm" onclick="coArrearUpdate()"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                SUBMIT
                        </button>
                        <a href="<?php echo base_url() . 'index.php/CoArrearUpdateController/index'?>"
                            class="btn btn-danger btn-sm text-white" role="button" 
                            style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            CANCEL
                        </a>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/co_arrear_update.js"></script>
