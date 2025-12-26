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
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold">
            <a href="<?php echo base_url() . 'index.php/EkhajanaAstController/pendingList'?>">
                E-Khajana-(Pending-list)
            </a>
        </li>
         <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Arrear-Details-Form)</li>
    </ol>
</nav>
<form id="ast_arrear_update_form">
    
    <input type="hidden" name="ek_basic_id" id="ek_basic_id" value="<?=$ekBasicDetails->id?>">
    <input type="hidden" name="application_no" id="application_no" value="<?=$ekBasicDetails->application_no?>">
    <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$ekBasicDetails->ld_application_no?>">
    <input type="hidden" name="case_no" id="case_no" value="<?=$ekBasicDetails->case_no?>">
    <input type="hidden" name="current_doul_year" id="current_doul_year" value="<?=$current_doul_year?>">
    <div class="row" style='margin-top:20px'>               
        <div class="col-lg-1"></div>
        <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
            <div class="card-header h5 bg-info text-white text-center">
                ARREAR DETAILS
            </div>
            <div class="card-header h6 bg-warning text-white text-center">
                CASE-NO: <?=$ekBasicDetails->case_no?>,
                PATTA-TYPE: <?=$ekBasicDetails->patta_type?>,
                PATTA-NO: <?=$ekBasicDetails->patta_no?>
            </div>
            <div class="card-header h6 bg-secondary text-white text-center">
                DISTRICT: <?=$this->utilityclass->getDistrictName($ekBasicDetails->dist_code)?>,
                SUBDIVISION: <?=$this->utilityclass->getSubDivName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code)?>,
                CIRCLE: <?=$this->utilityclass->getCircleName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code)?>,
                MOUZA: <?=$this->utilityclass->getMouzaName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                $ekBasicDetails->mouza_pargona_code)?>,
                LOT: <?=$this->utilityclass->getLotName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                $ekBasicDetails->mouza_pargona_code, $ekBasicDetails->lot_no)?>,
                VILLAGE: <?=$this->utilityclass->getVillageName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                $ekBasicDetails->mouza_pargona_code, $ekBasicDetails->lot_no,
                                $ekBasicDetails->vill_townprt_code)?>                               
                
            </div>
            <?php if ($doul_entry_flag): ?>
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
                                    <a href="<?=base_url().'index.php/EkhajanaCoController/document?appl_no='.$ekBasicDetails->ld_application_no?>"
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
                        <?php if (EKHAJANA_AST_PRE_ARREAR_UPDATE == 1):?>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        OPENING BALANCE/ ARREAR(RS) <span class="text-danger h4">*</span>
                                    </label>            
                                </div>
                                <div class="col-lg-6 text-left">
                                    <input type="text" class="form-control" name="openinig_balance" id="openinig_balance"
                                    readonly placeholder="-OPENING-BALANCE-" value="<?=$total_arrear?>">
                                </div>
                            </div>                    
                        </div>
                    <?php else : ?>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-5 text-right">
                                    <label class="text-right">
                                        OPENING BALANCE/ ARREAR(RS) <span class="text-danger h4">*</span>
                                    </label>            
                                </div>
                                <div class="col-lg-6 text-left">
                                    <input type="text" class="form-control" name="openinig_balance" id="openinig_balance"
                                    placeholder="-OPENING-BALANCE-">
                                </div>
                            </div>                    
                        </div>
                    <?php endif ; ?>
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
            <?php else: ?>
                <div class="card-header h6 bg-dark text-warning text-center mt-3">
                    REVENUE OR LOCAL TAX NOT FOUND FOR THE PATTA NO<?=$ekBasicDetails->patta_no?> IN GENERATED DOUL, KINDLY REVERT BACK TO CO. 
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="row hide">               
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
                                    <input class="form-check-input" type="radio" name="paymentBy" id="paymentBySelfRadio" value="self" checked>
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
                <div class="col-lg-12" id="astArr_error_div" style="display:none;">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="astArr_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <?php if ($doul_entry_flag): ?>
                            <button class="btn btn-success btn-sm" onclick="astArrearUpdate()"
                            style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    SUBMIT
                            </button>
                        <?php endif ?>
                        <a href="<?php echo base_url() . 'index.php/CoArrearUpdateController/index'?>"
                            class="btn btn-danger btn-sm text-white" role="button" 
                            style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            CANCEL
                        </a>
                        <button class="btn btn-warning btn-sm" onclick="revertCase('<?=$ekBasicDetails->ld_application_no?>')"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                REVERT TO CO
                        </button>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</form>

 <!-- land bank details update lm modal  -->
 <div class="modal align-middle" id="Ek_revert_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:50%">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-danger">                
                <h5 class="modal-title w-100">
                    <u>
                        Revert Case To CO <br>                                               
                        DISTRICT: <?=$this->utilityclass->getDistrictName($ekBasicDetails->dist_code)?>, 
                        CASE-NO: <?=$ekBasicDetails->case_no?>,
                        SUBDIVISION: <?=$this->utilityclass->getSubDivName($ekBasicDetails->dist_code, 
                                $ekBasicDetails->subdiv_code)?>,
                        CIRCLE: <?=$this->utilityclass->getCircleName($ekBasicDetails->dist_code, 
                                        $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code)?>,
                        MOUZA: <?=$this->utilityclass->getMouzaName($ekBasicDetails->dist_code, 
                                        $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                        $ekBasicDetails->mouza_pargona_code)?>,
                        LOT: <?=$this->utilityclass->getLotName($ekBasicDetails->dist_code, 
                                        $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                        $ekBasicDetails->mouza_pargona_code, $ekBasicDetails->lot_no)?>,
                        VILLAGE: <?=$this->utilityclass->getVillageName($ekBasicDetails->dist_code, 
                                        $ekBasicDetails->subdiv_code,$ekBasicDetails->cir_code, 
                                        $ekBasicDetails->mouza_pargona_code, $ekBasicDetails->lot_no,
                                        $ekBasicDetails->vill_townprt_code)?> 
                        
                    </u>                                     
                </h5>                                       
            </div>             
                <div class="modal-body">      
                    <form id="Ek_revert_rmk_form">
                        <div class="form-group mb-5">
                            <label class="col-sm-3 uni_text control-label text-right">
                                Remark :
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>                            
                            <div class="col-sm-8 mb-3">
                                <td>
                                    <textarea class="form-control" placeholder="--Revert-Remark--" rows="3" name="Ek_revert_rmk" id="Ek_revert_rmk"></textarea>
                                </td>
                            </div>
                        </div>  
                            <input type="hidden" name="ek_basic_id" id="ek_basic_id" value="<?=$ekBasicDetails->id?>">
                            <input type="hidden" name="application_no" id="application_no" value="<?=$ekBasicDetails->application_no?>">
                            <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$ekBasicDetails->ld_application_no?>">
                            <input type="hidden" name="case_no" id="case_no" value="<?=$ekBasicDetails->case_no?>">
                            <input type="hidden" name="patta_no" id="patta_no" value="<?=$ekBasicDetails->patta_no?>">
                    </form>                                                    
                </div>     
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="Ek_revert_rmk_form_validation_error_div" style="display:none;">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="Ek_revert_rmk_form_validation_error_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->                           
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-success" onclick="EkRevertFormSubmit()">
                            <i class="fa fa-check" aria-hidden="true"></i>
                                Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="EkRevertModalClose()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                Close
                        </button>
                    </div>                          
                </div>                
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>
