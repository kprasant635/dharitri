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
    <form action="" id="ek_lm_pending_case_display_form">
        <!-- Application Details -->
        <input type="hidden" name="application_no" id="application_no" 
        value="<?=$pendingCaseLandDetails->application_no?>">
        <input type="hidden" name="ld_application_no" id="ld_application_no" 
        value="<?=$pendingCaseLandDetails->ld_application_no?>">
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
        <input type="hidden" name="pdar_name" id="pdar_name" value="<?=str_replace("\"", '', $pendingCaseLandDetails->pdar_name)?>">
        <input type="hidden" name="pdar_father_name" id="pdar_father_name" value="<?=str_replace("\"", '', $pendingCaseLandDetails->pdar_father_name)?>">
        <input type="hidden" name="patta_no" id="patta_no" value="<?=$pendingCaseLandDetails->patta_no?>">
        <input type="hidden" name="pan_type" id="pan_type" value="<?=$pendingCaseLandDetails->application_type?>">
        <input type="hidden" name="ekh_mobile_no" id="ekh_mobile_no" value="<?= $pendingCaseLandDetails->pdar_mobile_no ?? '' ?>">

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
        <?php
        $authType =$pendingCaseApplicantDetails->aadhaar_pan_type;
        ?>
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
                                Applicant Details From  <?=$authType?> Card
                            </th>
                            <tr>
                                <?php if($authType =="PAN"):?>
                                    <td class="text-danger font-weight-bold"><b>Name(English)</b></td>
                                    <td><?=$pendingCaseApplicantDetails->name_eng?></td>
                                    <td class="text-danger font-weight-bold">Name(Assamese)</td>
                                    <td><?=$pendingCaseApplicantDetails->name_asm?></td>
                                <?php elseif ($authType =="AADHAAR"):?> 
                                    <td rowspan="3"><?=$aadhaar_b64_decoded?></td>
                                    <td class="text-danger font-weight-bold"><b>Name(English)</b></td>
                                    <td><?=$pendingCaseApplicantDetails->name_eng?></td>
                                    <td class="text-danger font-weight-bold">Name(Assamese)</td>
                                    <td><?=$pendingCaseApplicantDetails->name_asm?></td>
                                <?php endif ?>     
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
                        <?php if(!isset($pendingCaseDocumentDetails->id)):?> 
                        <!-- File Upload code starts here -->
                        <h5 class="text-center text-white" style="background-color:grey;padding:5px">ADDITIONAL DOCUMENT UPLOAD SECTION</h5>
                        <div class="row mb-3" >
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
                                <div class="form-group">
                                    <label id="formControlFile"><?="Document Details"?></label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
                                <div class="form-group">
                                    <label id="formControlFile"><?="Select File"?></label>
                                    <span style="color:blue;text-align:center;font-size:14px"><br>Please upload file less than 2 MB in PDF format only </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-10">
                                <div class="form-group">
                                    <input type="text" class="form-control-file" id="uploadFile" name="fileText" style="width: 100%" minlength="3" maxlength="99" placeholder="Enter Document Name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="uploadFile1" name="fileUpload" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <span style="color:red;text-align:center;font-size:14px">* Upload document only if rtps doc id is missing for the application </span>
                         <!-- File Upload code ends here -->	
                         <?php endif;?>
                        <div class="card-header h6 bg-dark text-warning text-center">
                        PATTADAR IDENTIFICATION
                        </div>            
                        <div class="card card-body">
                            <div class="row mt-1">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-5 text-right">
                                            <label class="text-right">
                                                WHETHER PATTADAR IDENTIFIED: <span class="text-danger h4">*</span>
                                            </label>            
                                        </div>
                                        <div class="col-lg-6 text-left">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pattadar_identified" value="Y" checked>
                                                YES
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pattadar_identified" value="N">
                                                NO
                                            </div>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered text-bold">
                            <tbody>
                            <td style="text-align:center;background-color:#136a6f;color: #fff"colspan="3">Total Khajana For Tha Patta </td>
                            <tr>
                                <td>Revenue</td>
                                <td>Local Tax</td>
                                <td>Arrear</td>
                            </tr>
                            <tr>
                                <?php if($current_doul_demand =="NO-DATA-FOUND"):?>
                                    <td><?="NOT-FOUND"?></td>
                                    <td><?="NOT-FOUND"?></td>
                                <?php else:?>
                                    <td><?=$current_doul_demand->dag_revenue?></td>
                                    <td><?=$current_doul_demand->dag_local_tax?></td>
                                <?php endif;?>
                                <?php if($arrear_by_mouzadar =="NO-DATA-FOUND"):?>
                                    <td><?="Not Updated By Mouzadar"?></td>
                                <?php else:?>
                                    <td><?=$arrear_by_mouzadar->arrear?></td>
                                <?php endif?>   
                            </tr>
                            </tbody>
                        </table>
                        <!-- getting patta status and arrear details -->
                        <?php
                            $patta_status = $this->EkhajanaHelperModel->getPattaStatus($pendingCaseLandDetails->dist_code,
                            $pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code,$pendingCaseLandDetails->mouza_pargona_code, 
                            $pendingCaseLandDetails->lot_no, $pendingCaseLandDetails->vill_townprt_code, $pendingCaseLandDetails->patta_type_code,
                            $pendingCaseLandDetails->patta_no);

                            $year_wise_arrear_details = $this->EkhajanaHelperModel->getYearWiseArrearDetails($pendingCaseLandDetails->dist_code,
                            $pendingCaseLandDetails->subdiv_code,$pendingCaseLandDetails->cir_code,$pendingCaseLandDetails->mouza_pargona_code, 
                            $pendingCaseLandDetails->lot_no, $pendingCaseLandDetails->vill_townprt_code, $pendingCaseLandDetails->patta_type_code,
                            $pendingCaseLandDetails->patta_no);
                            // echo "<pre>";
                            // var_dump($year_wise_arrear_details);
                            // echo "</pre>";
                            // exit;
                        ?>                    
                        <!-- year wise arrear details  -->
                        <table class="table table-striped table-bordered text-bold" style="background-color: #136a6f">
                            <thead>
                                <tr>
                                    <th class="bg-secondary text-white text-center" colspan="6" class="text-center">
                                        YEAR WISE ARREAR BREAKDOWN(ADDED BY MOUZADAR)
                                        <a class="btn btn-success text-white btn-sm" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-eye"></i> VIEW
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                        </table>   
                        <div class="collapse" id="collapseExample1">
                            <div class="card card-body">
                                <div class="modal-dialog" role="document" style="max-width:80%">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <?php foreach ($year_wise_arrear_details as $year_wise_arrear):?>
                                                        <?php if($year_wise_arrear->year_revenue!=0 && $year_wise_arrear->year_tax!=0 && $year_wise_arrear->year_arrear!=0): ?>
                                                            <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                                <th scope="col">Year-<?=$year_wise_arrear->financial_year?></th>
                                                                <th scope="col">Revenue : Rs <?=$year_wise_arrear->year_revenue?></th>
                                                                <th scope="col">Local-Tax : Rs <?=$year_wise_arrear->year_tax?></th>
                                                                <th scope="col">Year-Wise-Total-Arrear : Rs <?=$year_wise_arrear->year_arrear?></th>
                                                            </tr>
                                                        <?php endif ?>   
                                                    <?php endforeach;?>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- getting patta status -->
                        <table class="table table-striped table-bordered text-bold" style="background-color: #136a6f">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white text-center" colspan="6" class="text-center">
                                        PATTA STATUS
                                        <a class="btn btn-success text-white btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-eye"></i> VIEW
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                        </table>   
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="modal-dialog" role="document" style="max-width:60%">
                                    <div class="modal-content">
                                    <div class="modal-header bg-info text-white text-center h5">                                    
                                        <u>Status Of The Patta No <?=$caseDetails->patta_no?>
                                        (District : <?=$this->utilityclass->getDistrictName($caseDetails->dist_code)?>,
                                        Circle : <?=$this->utilityclass->getCircleName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code)?>,
                                        Village Name: <?=$this->utilityclass->getVillageName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code)?>
                                        )</u>                                  
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                    <th scope="col">Patta Creation Date : <?=date('Y-m-d',strtotime($patta_status['chitha_basic']->date_entry))?></th>
                                                </tr>
                                                <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                    <th scope="col">Total Area Of The Patta : <?=$this->utilityclass->Total_Lessa($patta_status['chitha_basic']->dag_area_b, $patta_status['chitha_basic']->dag_area_k,$patta_status['chitha_basic']->dag_area_lc)?> Lessa</th>
                                                </tr>
                                                <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                    <th scope="col">Doul Submission Date : <?=$patta_status['current_doul_approve']->co_submission_date?></th>
                                                </tr>
                                                <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                    <th scope="col">Doul Aprroval Status : 
                                                        <?php if($patta_status['current_doul_approve']->status == 'A') :?>
                                                            Approved
                                                        <?php else: ?>
                                                            Not Approved                                                    
                                                        <?php endif; ?>  
                                                    </th>
                                                </tr>
                                                <tr style="background: #3d3d3d; font-weight:bold; color:white;">
                                                    <?php if($patta_status['current_doul_approve']->status == 'A') :?>
                                                        <th scope="col">Doul Aprroval Date : <?=$patta_status['current_doul_approve']->dc_adc_approve_date?></th>
                                                    <?php else: ?>
                                                        Not Approved                                                    
                                                    <?php endif; ?>  
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- getting patta status -->
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
                        <?php if($pendingCaseLandDetails->pdar_mobile_no != null || $pendingCaseLandDetails->pdar_mobile_no !=""):?>
                        <div class="card-header bg-gradient-primary text-white text-center py-3 shadow-sm rounded-top">
                            <h6 class="mb-0">
                                <i class="fas fa-phone-alt me-2"></i>
                                Pattadar Phone Number: 
                                <span class="fw-bold text-warning"><?=$pendingCaseLandDetails->pdar_mobile_no?></span>
                            </h6>
                        </div>

                        <!-- Note Section -->
                        <div class="text-center small fst-italic mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i> 
                            This phone number will be seeded into the Chitha after the disposal of the case.
                        </div>
                        <?php endif;?>
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
                                    onclick="forwardToCoForMouzadariSystem()">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    FORWARD TO CO
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

