<style>
    table tr {
        font-weight: bold !important;
        font-size: 16px !important;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaLmController/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaLmController/pendingList'?>">E-Khajana-(Pending-list)</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-Case-Details : <?=$pendingCaseLandDetails->ld_application_no?>)</li>
    </ol>
</nav>
<div class="container-fluid login form-top">
    <form action="" id="ek_lm_pending_case_display_form_for_dp_estate">
        <!-- Application Details -->
        <input type="hidden" name="application_no" id="application_no" value="<?=$pendingCaseLandDetails->application_no?>">
        <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$pendingCaseLandDetails->ld_application_no?>">
        <!-- location details -->
        <input type="hidden" name="dist_code" id="dist_code" value="<?=$pendingCaseLandDetails->dist_code?>">
        <input type="hidden" name="subdiv_code" id="subdiv_code" value="<?=$pendingCaseLandDetails->subdiv_code?>">
        <input type="hidden" name="cir_code" id="cir_code" value="<?=$pendingCaseLandDetails->cir_code?>">
        <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code" value="<?=$pendingCaseLandDetails->mouza_pargona_code?>">
        <input type="hidden" name="lot_no" id="lot_no" value="<?=$pendingCaseLandDetails->lot_no?>">
        <input type="hidden" name="vill_townprt_code" id="vill_townprt_code" value="<?=$pendingCaseLandDetails->vill_townprt_code?>">
        <input type="hidden" name="is_urban" id="is_urban" value="<?=$pendingCaseLandDetails->is_urban?>">
        <!-- patta details -->
        <input type="hidden" name="patta_type" id="patta_type" value="<?=$pendingCaseLandDetails->patta_type?>">
        <input type="hidden" name="patta_type_code" id="patta_type_code" value="<?=$pendingCaseLandDetails->patta_type_code?>">
        <input type="hidden" name="pdar_id" id="pdar_id" value="<?=$pendingCaseLandDetails->pdar_id?>">
        <input type="hidden" name="pdar_name" id="pdar_name" value="<?=$pendingCaseLandDetails->pdar_name?>">
        <input type="hidden" name="pdar_father_name" id="pdar_father_name" value="<?=$pendingCaseLandDetails->pdar_father_name?>">
        <input type="hidden" name="patta_no" id="patta_no" value="<?=$pendingCaseLandDetails->patta_no?>">
        <input type="hidden" name="pan_type" id="pan_type" value="<?=$pendingCaseLandDetails->application_type?>">
        <!-- applicant details -->
        <input type="hidden" name="applicant_name_eng" id="applicant_name_eng" value="<?=$pendingCaseApplicantDetails->name_eng?>">
        <input type="hidden" name="applicant_name_asm" id="applicant_name_asm" value="<?=$pendingCaseApplicantDetails->name_asm?>">
        <input type="hidden" name="guardian_name_eng" id="guardian_name_eng" value="<?=$pendingCaseApplicantDetails->guardian_name_eng?>">
        <input type="hidden" name="guardian_name_asm" id="guardian_name_asm" value="<?=$pendingCaseApplicantDetails->guardian_name_asm?>">
        <input type="hidden" name="guardian_relation" id="guardian_relation" value="<?=$pendingCaseApplicantDetails->guardian_relation?>">
        <input type="hidden" name="date_of_birth" id="date_of_birth" value="<?=$pendingCaseApplicantDetails->date_of_birth?>">
        <input type="hidden" name="gender" id="gender" value="<?=$pendingCaseApplicantDetails->gender?>">
        <input type="hidden" name="address" id="address" value="<?=$pendingCaseApplicantDetails->address?>">
        <input type="hidden" name="mobile_no" id="mobile_no" value="<?=$pendingCaseApplicantDetails->mobile_no?>">
        <input type="hidden" name="aadhaar_pan_ref_no" id="aadhaar_pan_ref_no" value="<?=$pendingCaseApplicantDetails->aadhaar_pan_ref_no?>">
        <input type="hidden" name="aadhaar_pan_type" id="aadhaar_pan_type" value="<?=$pendingCaseApplicantDetails->aadhaar_pan_type?>">
        <!-- document details  -->
        <?php if(isset($pendingCaseDocumentDetails->id)):?>
            <input type="hidden" name="rtps_doc_id" id="rtps_doc_id" value="<?=$pendingCaseDocumentDetails->id?>">
        <?php else:?>
            <input type="hidden" name="rtps_doc_id" id="rtps_doc_id" value="">
        <?php endif;?>
        <!-- working -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-danger panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: center; font-weight: bold;">
                                <span>E-Khajana Pending Case Details</span>                                
                            </h3>
                            <h3 class="panel-title mt-1" style="text-align: center; font-weight: bold;">                                
                                <span><kbd> (Application-No : <?=$pendingCaseLandDetails->ld_application_no?>) </kbd></span>
                            </h3>
                        </div>
                        <div class="panel-body" style="font-size:18px!important;">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>District Name: <?=$this->utilityclass->getDistrictName($pendingCaseLandDetails->dist_code)?></td>
                                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($pendingCaseLandDetails->dist_code,$pendingCaseLandDetails->subdiv_code)?></td>
                                    <td>Circle Name: <?=$this->utilityclass->getCircleName($pendingCaseLandDetails->dist_code,$pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code)?></td>
                                </tr>
                                <tr>
                                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($pendingCaseLandDetails->dist_code,$pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code,$pendingCaseLandDetails->mouza_pargona_code)?></td>
                                    <td>Lot Name: <?=$this->utilityclass->getLotName($pendingCaseLandDetails->dist_code,$pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code,$pendingCaseLandDetails->mouza_pargona_code,$pendingCaseLandDetails->lot_no)?></td>
                                    <td>Village Name: <?=$this->utilityclass->getVillageName($pendingCaseLandDetails->dist_code,$pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code,$pendingCaseLandDetails->mouza_pargona_code,$pendingCaseLandDetails->lot_no,$pendingCaseLandDetails->vill_townprt_code)?></td>
                                </tr>
                            </table>
                            <table class="table">
                                <th colspan="6" class="text-center bg-info">
                                    Pattadar Information
                                </th>
                                <tr class="bg-secondary">
                                    <td>Name</td>
                                    <td>Gurdian</td>
                                    <td>Phone Number</td>
                                    <td>Patta Type</td>
                                    <td>Patta No</td>
                                </tr>
                                <tr class="">
                                    <td><?=$pendingCaseLandDetails->pdar_name?></td>
                                    <td><?=$pendingCaseLandDetails->pdar_father_name?></td>
                                    <td><?=$pendingCaseApplicantDetails->mobile_no?></td>
                                    <td><?=$pendingCaseLandDetails->patta_type?></td>
                                    <td><?=$pendingCaseLandDetails->patta_no?></td>
                                </tr>
                            </table>                        
                        <table class="table table-bordered">
                            <th colspan="6" class="text-center bg-info">
                                Applicant Details From Aadhar Card
                            </th>
                            <tr>
                                <td class="text-danger font-weight-bold"><b>Name(English)</b></td>
                                <td><?=$pendingCaseApplicantDetails->name_eng?></td>
                                <td class="text-danger font-weight-bold">Name(Assamese)</td>
                                <td><?=$pendingCaseApplicantDetails->name_asm?></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold">Guardian Relation</td>
                                <td><?=$this->utilityclass->getEkhajanarelationByID($pendingCaseApplicantDetails->guardian_relation)?></td>
                                <td class="text-danger font-weight-bold">Guardian Name(Assamese)</td>
                                <td><?= $pendingCaseApplicantDetails->guardian_name_asm ? $pendingCaseApplicantDetails->guardian_name_asm : 'NA' ?></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold">Date Of Birth</td>
                                <td><?=$pendingCaseApplicantDetails->date_of_birth?></td>
                                <td class="text-danger font-weight-bold">Address</td>
                                <td><?=$pendingCaseApplicantDetails->address?></td>
                            </tr>
                        </table>	
                        <?php if(isset($pendingCaseDocumentDetails->id)):?>                    
                            <table class="table table-striped table-bordered text-bold">
                                <thead>
                                    <tr>                     
                                        <th colspan="6" class="text-center bg-secondary">
                                            <?=$pendingCaseDocumentDetails->file_details?> :
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                <a href="<?=base_url().'index.php/EkhajanaLmController/document/'.$pendingCaseDocumentDetails->name?>"
                                                target="_blank" style="text-decoration:none;color:white;">
                                                    Download
                                                </a>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        <?php else: ?>
                            <table class="table table-striped table-bordered text-bold" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bg-secondary text-white">
                                            Last Khajana Receipt Is Not Uploaded For This Patta
                                            (Since It is Not Mandatory From 30-10-2024)
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        <?php endif;?>   
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                    LM Report
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>LM Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" placeholder='LM Report' rows=3 name="lm_report" required></textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                        <div class="col-lg-10 col-lg-offset-1">
                        <!-- validation-errors-div -->
                        <div class="col-lg-12" id="lmArr_error_div" style="display:none;margin-top:1rem">
                            <div class="card-header h5 bg-danger text-white text-center">
                                VALIDATION ERRORS
                            </div>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="text-center" style="color:red !important" id="lmArr_validation_error_msg">
                                </strong>
                            </div>
                        </div>
                        
                        <!-- validation-error-div-end -->
                        <div class="panel panel-secondary panel-form">
                            <div class="panel-heading text-center">
                                <a href="<?=base_url().'index.php/EkhajanaLmController/index'?>"
                                    class="btn btn-danger btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    BACK TO HOME PAGE
                                </a>
                                <button
                                    class="btn btn-info btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="forwardByLmForDpEstate()">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    FORWARD
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_lm.js"></script>


