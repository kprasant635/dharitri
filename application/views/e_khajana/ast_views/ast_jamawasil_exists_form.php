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
         <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Jamawasil-Exists-Form)</li>
    </ol>
</nav>
<!-- <?=var_dump($ekBasicDetails)?> -->
<div class="container-fluid form-top login">
    <div class="row">               
        <div class="col-lg-1"></div>
            <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
                <div class="card-body">
                <div class="panel panel-info">
                    <div class="panel-heading text-center bg-success">
                        <h3 class="panel-title text-white">
                            ARREAR ALREADY UPDATED FOR PATTA NO (<?=$ekBasicDetails->patta_no?>)
                        </h3>
                    </div>
                    <div class="panel-heading bg-warning text-center">
                        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
                            <b>NOTE :</b> AFTER FORWARDING THE CASE, KHAJANA-RECEIPT FOR THE CASE <b>(<?=$ekBasicDetails->case_no?>)</b><br> CAN BE DOWNLOADED.
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <button class="btn btn-info btn-sm" onclick="astJwExistsCaseDispose('<?=$ekBasicDetails->id?>')"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                DISPOSE
                        </button>
                        <a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>"
                            class="btn btn-danger btn-sm text-white" role="button" 
                            style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                BACK TO HOME PAGE 
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

    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>
