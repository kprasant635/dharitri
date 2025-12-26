<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">MOUZADAR-ADD-FORM</li>
  </ol>
</nav>
<form id="mouzadar_add_form">
    <input type="hidden" class="form-control" name="dist_code" value="<?=$dist_code?>">
    <input type="hidden" class="form-control" name="subdiv_code" value="<?=$subdiv_code?>">
    <input type="hidden" class="form-control" name="cir_code" value="<?=$cir_code?>">
    <div class="row" style='margin-top:20px'>               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-secondary text-white text-center">
                MOUZADAR ADD FORM  
            </div>
            <div class="card-header h6 bg-primary text-white text-center font-weight-bold">
                DISTRICT: <?=$this->utilityclass->getDistrictName($dist_code)?>, 
                SUB-DIVISION: <?=$this->utilityclass->getSubDivName($dist_code,$subdiv_code)?>,  
                CIRCLE: <?=$this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code)?>
            </div>
            <div class="card-header h6 bg-red text-white text-center">
                NOTE: PASSWORD CAN BE CHANGED FROM MOUZADAR PROFILE 
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
                                <select class="form-control" style="width: 85%" name="mouza_pargona_code">
                                    <option value="" selected disabled>-SELECT-MOUZA-</option>
                                    <?php foreach ($mouza_list as $mouza):?>
                                        <option value="<?=$mouza->mouza_pargona_code?>"><?=$mouza->loc_name?>(<?=$mouza->locname_eng?>)</option>
                                    <?php endforeach;?>
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
            <div class="card-header h5 bg-secondary text-white text-center">
                MOUZADAR DETAILS
            </div>
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    NAME <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="name" placeholder="-NAME-">
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
                                    USER-NAME<span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="user_name" placeholder="-USER-NAME-">
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
                                    PASSWORD <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="password" placeholder="PASSWORD" VALUE="qwe@123" readonly>
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
                                    MOBILE NO
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="mobile_no" placeholder="-MOBILE-NO-">
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
                                    E-MAIL
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" name="email" placeholder="-E-MAIL-">
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
                                    ADDRESS
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control" placeholder = "-ADDRESS-" name="address">
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
            <div class="card-body">
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="maf_error_div" style="display:none;">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="maf_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <button class="btn btn-success btn-sm" onclick="mouzadarAddFormHandle()"
                            style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                SUBMIT
                        </button>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_mouzadar.js"></script>
