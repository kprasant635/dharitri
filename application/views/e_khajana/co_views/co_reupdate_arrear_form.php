<style>
    .blink {
        animation: blinker 1.2s linear infinite;
        color: yellow;
        font-family: sans-serif;
    }
    @keyframes blinker {
        100% {
            opacity: 0.1;
        }
    }
</style>

<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/arrearReUpdate'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold">
            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/arrearReUpdate'?>">
                E-Khajana-(Pending-list)
            </a>
        </li>
         <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Arrear-Re-Update-Form)</li>
    </ol>
</nav>
<form id="coRe_arrear_update_form">
    
    <input type="hidden" name="jama_wasil_id" id="jama_wasil_id" value="<?=$JamaWasilData->id?>">
    <input type="hidden" name="application_no" id="application_no" value="<?=$JamaWasilData->application_no?>">
    <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$JamaWasilData->ld_application_no?>">
    <input type="hidden" name="case_no" id="case_no" value="<?=$JamaWasilData->case_no?>">
    <input type="hidden" name="current_doul_year" id="current_doul_year" value="<?=$current_doul_year?>">
    <input type="hidden" name="due_payment_frontend" id="due_payment_frontend" value="">
    <div class="row" style='margin-top:20px'>               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-info text-white text-center">
                ARREAR DETAILS
            </div>
            <div class="card-header h6 bg-warning text-white text-center">
                CASE-NO: <?=$JamaWasilData->case_no?>,
                PATTA-NO: <?=$JamaWasilData->patta_no?>
            </div>
            <div class="card-header h6 bg-secondary text-white text-center">
                DISTRICT: <?=$this->utilityclass->getDistrictName($JamaWasilData->dist_code)?>,
                SUBDIVISION: <?=$this->utilityclass->getSubDivName($JamaWasilData->dist_code, 
                                $JamaWasilData->subdiv_code)?>,
                CIRCLE: <?=$this->utilityclass->getCircleName($JamaWasilData->dist_code, 
                                $JamaWasilData->subdiv_code,$JamaWasilData->cir_code)?>,
                MOUZA: <?=$this->utilityclass->getMouzaName($JamaWasilData->dist_code, 
                                $JamaWasilData->subdiv_code,$JamaWasilData->cir_code, 
                                $JamaWasilData->mouza_pargona_code)?>,
                LOT: <?=$this->utilityclass->getLotName($JamaWasilData->dist_code, 
                                $JamaWasilData->subdiv_code,$JamaWasilData->cir_code, 
                                $JamaWasilData->mouza_pargona_code, $JamaWasilData->lot_no)?>,
                VILLAGE: <?=$this->utilityclass->getVillageName($JamaWasilData->dist_code, 
                                $JamaWasilData->subdiv_code,$JamaWasilData->cir_code, 
                                $JamaWasilData->mouza_pargona_code, $JamaWasilData->lot_no,
                                $JamaWasilData->vill_townprt_code)?>                               
                
            </div>
            <div class="card-header h6 bg-red text-white text-center hide">
                NOTE: CURRENT REVENUE AND CURRENT LOCAL TAX WILL BE ADDED FROM CURRENT DOUL
            </div>
            <div class="card-header h6 bg-dark text-warning text-center">
                <p class="blink" style="margin:0px;">NOTE: CITIZEN DUE PAYMENT WILL BE OPENING BALANCE/ARREAR+REVENUE+LOCAL TAX</p>
            </div>
            <table class="table table-striped table-bordered text-bold">
                <thead>
                    <tr>                     
                        <th colspan="6" class="text-center bg-secondary">
                            Last Khajana Receipt :
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                <a href="<?=base_url().'index.php/EkhajanaCoController/document?appl_no='.$JamaWasilData->ld_application_no?>"
                                target="_blank" style="text-decoration:none;color:white;">
                                    Download
                                </a>
                            </button>
                        </th>
                    </tr>
                </thead>
            </table> 
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5 text-right">
                                <label class="text-right">
                                    OPENING BALANCE/ ARREAR(RS) <span class="text-danger h4">*</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" value="<?=$JamaWasilData->opening_balance?>" class="form-control" name="openinig_balance" id="openinig_balance"
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
                                    CURRENT REVENUE(RS) <span class="text-danger h4">*</span><br>
                                    <span class="text-primary h6">(REVENUE IS FETCHED FROM DOUL)</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control text-danger" id="current_revenue" name="current_revenue" 
                                placeholder="-CURRENT-REVENUE-" readonly value="<?=$current_revenue?>">
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
                                    CURRENT LOCAL TAX(RS)<span class="text-danger h4">*</span><br>
                                    <span class="text-primary h6">(LOCAL TAX IS FETCHED FROM DOUL)</span>
                                </label>            
                            </div>
                            <div class="col-lg-6 text-left">
                                <input type="text" class="form-control text-danger" id="current_local_tax" name="current_local_tax"
                                    placeholder="-CURRENT-LOCAL-TAX-" readonly value="<?=$current_local_tax?>">
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
                                <input type="text" value="<?=$JamaWasilData->entry_date?>" class="form-control" placeholder = "-LAST-PAY-DATE-" 
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
                                <input type="text" value="<?=$JamaWasilData->last_revenue_payment_amount?>" class="form-control" name="last_revenue_payment_amount"
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
                                <input type="text" value="<?=$JamaWasilData->last_local_tax_payment_amount?>" class="form-control" name="last_local_tax_payment_amount"
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
            <div class="card-body">
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="co_re_Arr_error_div" style="display:none;">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="co_re_Arr_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <button class="btn btn-success btn-sm" onclick="coReUpdateArrear()"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                RE-UPDATE
                        </button>
                        <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/arrearReUpdate'?>"
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
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>
