<style>
    table tr {
        font-weight: bold !important;
        font-size: 16px !important;
    }
    body { padding-right: 0 !important }
</style>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAdc/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAdc/pendingList'?>">E-Khajana-(Pending-list)</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-Case-Details : <?=$caseDetails->ld_application_no?>)</li>
    </ol>
</nav>
<div class="container-fluid login form-top">
    <form action="" id="ek_adc_pending_case_display_form">
        <!-- Application Details -->
        <input type="hidden" name="application_no" id="application_no" value="<?=$caseDetails->application_no?>">
        <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$caseDetails->ld_application_no?>">
        <input type="hidden" name="case_no" id="case_no" value="<?=$caseDetails->case_no?>">
        <!-- location details -->
        <input type="hidden" name="dist_code" id="dist_code" value="<?=$caseDetails->dist_code?>">
        <input type="hidden" name="subdiv_code" id="subdiv_code" value="<?=$caseDetails->subdiv_code?>">
        <input type="hidden" name="cir_code" id="cir_code" value="<?=$caseDetails->cir_code?>">
        <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code" value="<?=$caseDetails->mouza_pargona_code?>">
        <input type="hidden" name="lot_no" id="lot_no" value="<?=$caseDetails->lot_no?>">
        <input type="hidden" name="vill_townprt_code" id="vill_townprt_code" value="<?=$caseDetails->vill_townprt_code?>">
        <input type="hidden" name="is_urban" id="is_urban" value="<?=$caseDetails->is_urban?>">
        <!-- patta details -->
        <input type="hidden" name="patta_type" id="patta_type" value="<?=$caseDetails->patta_type?>">
        <input type="hidden" name="patta_type_code" id="patta_type_code" value="<?=$caseDetails->patta_type_code?>">
        <input type="hidden" name="pdar_id" id="pdar_id" value="<?=$caseDetails->pdar_id?>">
        <input type="hidden" name="pdar_name" id="pdar_name" value="<?=$caseDetails->pdar_name?>">
        <input type="hidden" name="pdar_father_name" id="pdar_father_name" value="<?=$caseDetails->pdar_father_name?>">
        <input type="hidden" name="patta_no" id="patta_no" value="<?=$caseDetails->patta_no?>">
        <!-- applicant details -->
        <input type="hidden" name="applicant_name_eng" id="applicant_name_eng" value="<?=$caseDetails->applicant_name_eng?>">
        <input type="hidden" name="applicant_name_asm" id="applicant_name_asm" value="<?=$caseDetails->applicant_name_asm?>">
        <input type="hidden" name="guardian_name_eng" id="guardian_name_eng" value="<?=$caseDetails->guardian_name_eng?>">
        <input type="hidden" name="guardian_name_asm" id="guardian_name_asm" value="<?=$caseDetails->guardian_name_asm?>">
        <input type="hidden" name="guardian_relation" id="guardian_relation" value="<?=$caseDetails->guardian_relation?>">
        <input type="hidden" name="date_of_birth" id="date_of_birth" value="<?=$caseDetails->date_of_birth?>">
        <input type="hidden" name="gender" id="gender" value="<?=$caseDetails->gender?>">
        <input type="hidden" name="address" id="address" value="<?=$caseDetails->address?>">
        <input type="hidden" name="mobile_no" id="mobile_no" value="<?=$caseDetails->mobile_no?>">
        <input type="hidden" name="aadhaar_pan_ref_no" id="aadhaar_pan_ref_no" value="<?=$caseDetails->aadhaar_pan_ref_no?>">
        <input type="hidden" name="aadhaar_pan_type" id="aadhaar_pan_type" value="<?=$caseDetails->aadhaar_pan_type?>">
        <input type="hidden" name="ek_details_id" id="ek_details_id" value="<?=$caseDetails->id?>">
        <!-- document details  -->
        <input type="hidden" name="rtps_doc_id" id="rtps_doc_id" value="<?=$caseDetails->id?>">
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
                                <span><kbd> (Case-No : <?=$caseDetails->case_no?>) </kbd></span>
                            </h3>
                        </div>
                        <div class="panel-body" style="font-size:18px!important;">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>District Name: <?=$this->utilityclass->getDistrictName($caseDetails->dist_code)?></td>
                                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($caseDetails->dist_code,$caseDetails->subdiv_code)?></td>
                                    <td>Circle Name: <?=$this->utilityclass->getCircleName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code)?></td>
                                </tr>
                                <tr>
                                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code)?></td>
                                    <td>Lot Name: <?=$this->utilityclass->getLotName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no)?></td>
                                    <td>Village Name: <?=$this->utilityclass->getVillageName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code)?></td>
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
                                    <td><?=$caseDetails->pdar_name?></td>
                                    <td><?=$caseDetails->pdar_father_name?></td>
                                    <td><?=$caseDetails->mobile_no?></td>
                                    <td><?=$caseDetails->patta_type?></td>
                                    <td><?=$caseDetails->patta_no?></td>
                                </tr>
                            </table>                        
                        <table class="table table-bordered">
                            <th colspan="6" class="text-center bg-info">
                                Applicant Details From Aadhar Card
                            </th>
                            <tr>
                                <td class="text-danger font-weight-bold"><b>Name(English)</b></td>
                                <td><?=$caseDetails->applicant_name_eng?></td>
                                <td class="text-danger font-weight-bold">Name(Assamese)</td>
                                <td><?=$caseDetails->applicant_name_asm?></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold">Guardian Relation</td>
                                <td><?=$this->utilityclass->getEkhajanarelationByID($caseDetails->guardian_relation)?></td>
                                <td class="text-danger font-weight-bold">Guardian Name(Assamese)</td>
                                <td><?= $caseDetails->guardian_name_asm ? $caseDetails->guardian_name_asm : 'NA' ?></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold">Date Of Birth</td>
                                <td><?=$caseDetails->date_of_birth?></td>
                                <td class="text-danger font-weight-bold">Address</td>
                                <td><?=$caseDetails->address?></td>
                            </tr>
                        </table>  
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                                <tr>                     
                                    <th colspan="6" class="text-center bg-secondary">
                                        Last Khajana Receipt :
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <a href="<?=base_url().'index.php/EkhajanaCoController/document?appl_no='.$caseDetails->ld_application_no?>"
                                            target="_blank" style="text-decoration:none;color:white;">
                                                Download
                                            </a>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                        </table>      
                        <!-- <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #000000; color: #f00" colspan="6" class="text-center">
                                    JAMA WASIL STATUS : <?=$jama_wasil_status?>
                                </th>
                            </tr>
                        </table>        -->
                        <!-- getting patta status -->
                        <?php
                            $patta_status = $this->EkhajanaHelperModel->getPattaStatus($caseDetails->dist_code,
                            $caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code, 
                            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code,
                            $caseDetails->patta_no);
                            // echo "<pre>";
                            // var_dump($patta_status);
                            // echo "</pre>";
                        ?>
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th class="bg-primary text-white text-center" colspan="6" class="text-center">
                                    PATTA STATUS : 
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-eye" aria-hidden="true"></i> VIEW
                                    </button>
                                </th>
                            </tr>
                        </table>          
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <div class="alert alert-danger" role="alert">
                                        NOTE:<br> 
                                        *If total area of the patta is 0, The Case can't be forwarded.<br>
                                        *If the patta is created after the doul submmision, The Case can't be forwrded.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div> 
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
                                                <input class="form-check-input" type="radio" name="adc_pattadar_identification_flag" value="Y" checked>
                                                YES
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="adc_pattadar_identification_flag" value="N">
                                                NO
                                            </div>
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
                                    <textarea class="form-control" rows=2 name="lm_report" required readonly=""><?=$caseDetails->lm_remark?>
                                    </textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                    TN Branch Report
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>TN Branch Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="tn_report" required readonly=""><?=$caseDetails->tn_remark?>
                                    </textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <!-- Due payment breakdown div starts -->
                        <?php $due_payment = $arrear_data->current_revenue + $arrear_data->current_local_tax + $arrear_data->opening_balance + $arrear_data->surcharge?>
                        <div style="background-color: #136a6f; color: #fff">
                            <p>
                                Current revenue of the patta is RS <span style="color:Red;font-weight:700"><?=$arrear_data->current_revenue?></span> ,local tax Rs <span style="color:Red;font-weight:700"><?=$arrear_data->current_local_tax?></span> and Surcharge is Rs <span style="color:Red;font-weight:700"><?=$arrear_data->surcharge?></span>, Arrear Against the Patta is Rs <span style="color:Red;font-weight:700"> <?=$arrear_data->opening_balance?></span> and Total due payment is Rs <span style="color:Red;font-weight:700"><?=$due_payment?></span>. 
                            </p>
                        </div>
                        <!-- Due payment breakdown div ends -->
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #1e943c; color: #fff" colspan="6" class="text-center">
                                    CO Report
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>CO Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="co_report" required readonly=""><?=$caseDetails->co_remark?></textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color:#136a6f; color: #fff" colspan="6" class="text-center">
                                    ADC Report(Approval-Remark-Only)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>ADC Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="adc_report" required ></textarea>
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
                        <div class="col-lg-12" id="coArr_error_div" style="display:none;margin-top:1rem">
                            <div class="card-header h5 bg-danger text-white text-center">
                                VALIDATION ERRORS
                            </div>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <strong class="text-center" style="color:red !important" id="coArr_validation_error_msg">
                                </strong>
                            </div>
                        </div>
                        <!-- validation-error-div-end -->
                        <div class="panel panel-secondary panel-form">
                            <div class="panel-heading text-center">
                                <a href="<?=base_url().'index.php/EkhajanaCoController/index'?>"
                                    class="btn btn-warning btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    BACK TO HOME
                                </a>
                                <button
                                    class="btn btn-danger btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="rejectCase('<?=$caseDetails->case_no?>')">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    REJECT CASE
                                </button>
                                <button
                                    class="btn btn-success btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="AdcDisposeCase()">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    DISPOSE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- MOdal display code -->
<!-- 30-05-2022 -->
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/rejLoader.gif"></div>
    <div id="rejectModal" class="modal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>গোচৰ নং: </b>
                        <span class="red" id='caseNoHtml'></span>
                    </h5>
                </div>
                <form id="rejectformEkhajanaDpEstate" method="post">
                    <div class="modal-body" id="rejectmodalbody">
                        <div class="form-group">
                            <label class="required">Reject Reason</label>
                            <div style="max-height: 200px; overflow-y: scroll;">
                                <table class="table table-striped table-bordered">
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th width="10%" style="text-align: center">Check All&nbsp;
                                                <input type="checkbox" id="checkedAll" value="1">
                                            </th>
                                            <th width="90%">Reject Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reject_option"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Enter Reason (if any other)</label>
                            <textarea class="form-control" id="reject_remark" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="errorMsg text-bold text-red"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="service_code" value="19">
                        <input type="hidden" name="application_no" id="application_no" 
                        value="<?=$caseDetails->application_no?>">
                        <input type="hidden" name="patta_no" id="patta_no" value="<?=$caseDetails->patta_no?>">
                        <input type="hidden" name="case_no" id="case_no" value="<?=$caseDetails->case_no?>">
                        <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$caseDetails->ld_application_no?>">
                        <input type="hidden" name="ek_details_id" id="ek_details_id" value="<?=$caseDetails->id?>">
                        <button type="submit" id="submit_reject_modal" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                        <button type="button" id="close_reject_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="hidden" id="ref_no" name="ref_no"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style type="text/css">
        .blockUI {
            z-index: 1200 !important;
        }
    </style>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_adc.js"></script>

