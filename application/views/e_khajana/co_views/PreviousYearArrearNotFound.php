<style>
    table tr {
        font-weight: bold !important;
        font-size: 16px !important;
    }
    body { padding-right: 0 !important }
</style>
<nav aria-label="breadcrumb">

    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingList'?>">E-Khajana-(Pending-list)</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-Case-Details : <?=$caseDetails->ld_application_no?>)</li>
    </ol>
</nav>

<div class="container-fluid login form-top">
    <form action="" id="ek_co_pending_case_display_form">
        <!-- Application Details -->
        <input type="hidden" name="application_no" id="application_no" 
        value="<?=$caseDetails->application_no?>">
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
        <input type="hidden" name="pattadar_identification_flag" id="pattadar_identification_flag" value="<?=$caseDetails->pattadar_identification_flag?>">
        <input type="hidden" name="lm_pattadar_identification_flag" id="lm_pattadar_identification_flag" value="<?=$caseDetails->lm_pattadar_identification_flag?>">
        <!-- document details  -->
        <?php $mouzadar_identified = $caseDetails->pattadar_identification_flag?>
        <?php $lm_identified = $caseDetails->lm_pattadar_identification_flag?>
        <input type="hidden" name="rtps_doc_id" id="rtps_doc_id" value="<?=$caseDetails->id?>">
        <?php
        $authType =$caseDetails->aadhaar_pan_type;
        ?>
        <!-- working -->
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered text-bold">
                    <tr>
                        <td style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                            Some Information Missing
                        </td>
                    </tr>
                    <tbody>
                        <td class="text-center">
                        Previous Years Arrear is Not Updated For This Patta,
                        </td>
                    </tbody>
                </table>
                
                <div class="col-lg-12 ">
                    <div class="col-lg-10 col-lg-offset-1">
                        <?php if (EKHAJANA_MOUZADAR_CO_ACTIVE == 1): ?>
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
                                    onclick="COrejectCaseMouzadariSystem('<?=$caseDetails->case_no?>')">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    REJECT CASE
                                </button>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- MOdal display code -->
<!-- 30-05-2022 -->
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/rejLoader.gif"></div>
    <div id="rejectModalMouzadari" class="modal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>গোচৰ নং: </b>
                        <span class="red" id='caseNoHtml'></span>
                    </h5>
                </div>
                <form id="rejectformEkhajanaMouzadari" method="post">
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
                        <input type="hidden" name="application_no" id="application_no" value="<?=$caseDetails->application_no?>">
                        <input type="hidden" name="patta_no" id="patta_no" value="<?=$caseDetails->patta_no?>">
                        <input type="hidden" name="case_no" id="case_no" value="<?=$caseDetails->case_no?>">
                        <input type="hidden" name="ld_application_no" id="ld_application_no" value="<?=$caseDetails->ld_application_no?>">
                        <input type="hidden" name="ek_details_id" id="ek_details_id" value="<?=$caseDetails->id?>">
                        <button type="submit" id="submit_reject_modal_mouzadari" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                        <button type="button" id="close_reject_modal_mouzadari" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>

