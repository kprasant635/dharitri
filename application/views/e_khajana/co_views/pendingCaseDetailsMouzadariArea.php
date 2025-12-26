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
        <input type="hidden" name="ekh_mobile_no" id="ekh_mobile_no" value="<?= $caseDetails->pdar_mobile_no ?? '' ?>">
        <!-- document details  -->
        <?php $mouzadar_identified = $caseDetails->pattadar_identification_flag?>
        <?php $lm_identified = $caseDetails->lm_pattadar_identification_flag?>
        <input type="hidden" name="rtps_doc_id" id="rtps_doc_id" value="<?=$caseDetails->id?>">
        <?php
        $authType =$caseDetails->aadhaar_pan_type;
        ?>
        <input type="hidden" name="mou_report" value="<?=$caseDetails->mou_remark?>">
        <input type="hidden" name="lm_report" value="<?=$caseDetails->lm_remark?>">
        <!-- working -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-danger panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: center; font-weight: bold;">
                                <i class="fas fa-file-alt me-2"></i>
                                <span>E-Khajana Pending Case Details</span>                                
                            </h3>

                            <h3 class="panel-title mt-1" style="text-align: center; font-weight: bold;">                                
                                <span>
                                    <kbd>
                                        <i class="fas fa-hashtag me-1"></i> 
                                        Case-No : <?=$caseDetails->case_no?>
                                    </kbd>
                                </span>
                            </h3>

                        </div>
                        <div class="panel-body" style="font-size:18px!important;">
                            <table class="table table-striped table-bordered align-middle text-center">
                                <tr>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <strong>District:</strong> 
                                        <?=$this->utilityclass->getDistrictName($caseDetails->dist_code)?>
                                    </td>
                                    <td>
                                        <i class="fas fa-city text-primary me-1"></i>
                                        <strong>Subdivision:</strong> 
                                        <?=$this->utilityclass->getSubDivName($caseDetails->dist_code,$caseDetails->subdiv_code)?>
                                    </td>
                                    <td>
                                        <i class="fas fa-landmark text-success me-1"></i>
                                        <strong>Circle:</strong> 
                                        <?=$this->utilityclass->getCircleName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code)?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-map text-warning me-1"></i>
                                        <strong>Mouza:</strong> 
                                        <?=$this->utilityclass->getMouzaName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code)?>
                                    </td>
                                    <td>
                                        <i class="fas fa-layer-group text-info me-1"></i>
                                        <strong>Lot:</strong> 
                                        <?=$this->utilityclass->getLotName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no)?>
                                    </td>
                                    <td>
                                        <i class="fas fa-home text-secondary me-1"></i>
                                        <strong>Village:</strong> 
                                        <?=$this->utilityclass->getVillageName($caseDetails->dist_code,$caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code,$caseDetails->lot_no,$caseDetails->vill_townprt_code)?>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-bordered table-striped text-center align-middle">
                                <!-- Title Row -->
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center text-white bg-info h5">
                                            <i class="fas fa-user text-white me-2"></i> Pattadar Information
                                        </th>
                                    </tr>
                                    <tr class="bg-secondary text-white">
                                        <th><i class="fas fa-user me-1"></i> Name</th>
                                        <th><i class="fas fa-user-friends me-1"></i> Guardian</th>
                                        <th><i class="fas fa-phone-alt me-1"></i> Phone Number</th>
                                        <th><i class="fas fa-file-alt me-1"></i> Patta Type</th>
                                        <th><i class="fas fa-hashtag me-1"></i> Patta No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$caseDetails->pdar_name?></td>
                                        <td><?=$caseDetails->pdar_father_name?></td>
                                        <td><?=$caseDetails->mobile_no?></td>
                                        <td><?=$caseDetails->patta_type?></td>
                                        <td><?=$caseDetails->patta_no?></td>
                                    </tr>
                                </tbody>
                            </table>
                        
                        <table class="table table-bordered table-striped align-middle">
                            <!-- Table Title -->
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center text-white bg-info h5">
                                        <i class="fas fa-id-card me-2"></i> Applicant Details From <?=$authType?> Card
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-user me-1"></i> Name (English)
                                    </td>
                                    <td><?=$caseDetails->applicant_name_eng?></td>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-language me-1"></i> Name (Assamese)
                                    </td>
                                    <td><?=$caseDetails->applicant_name_asm?></td>
                                </tr>

                                <tr>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-user-friends me-1"></i> Guardian Relation
                                    </td>
                                    <td><?=$this->utilityclass->getEkhajanarelationByID($caseDetails->guardian_relation)?></td>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-user-tie me-1"></i> Guardian Name (Assamese)
                                    </td>
                                    <td><?= $caseDetails->guardian_name_asm ? $caseDetails->guardian_name_asm : 'NA' ?></td>
                                </tr>

                                <tr>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-birthday-cake me-1"></i> Date Of Birth
                                    </td>
                                    <td><?=$caseDetails->date_of_birth?></td>
                                    <td class="text-danger fw-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i> Address
                                    </td>
                                    <td><?=$caseDetails->address?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-striped table-bordered fw-bold">
                            <thead>
                                <tr>                     
                                    <th colspan="6" class="text-center bg-secondary text-white">
                                        Last Khajana Receipt :
                                        <a href="<?=base_url().'index.php/EkhajanaCoController/document?appl_no='.$caseDetails->ld_application_no?>"
                                        target="_blank" 
                                        class="btn btn-success btn-sm ms-2">
                                            <i class="fa fa-download me-1"></i> Download
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                        </table>

                        <!-- if additional documnet exists against the patta by mouzadar starts       -->
                        <?php if($additional_doc_by_mou != "NO-DATA-FOUND"):?>
                        <h5 class="text-center text-white" style="background-color:grey;padding:5px">ADDITIONAL DOCUMENT BY MOUZADAR</h5>
                        <div class="row m-3">
                            <div class="col-lg-10">
                                <input type="text" class="form-control" value="<?=$additional_doc_by_mou->file_name?>" readonly>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <a href="<?=base_url().'index.php/EkhajanaCoController/MouzadarAddlDocView/'.$additional_doc_by_mou->id?>"
                                    target="_blank" style="text-decoration:none;color:white;">
                                        View Document
                                    </a>
                                </button>
                            </div>
                        </div>
                        <?php endif ?>
                        <!-- if additional documnet exists against the patta by mouzadar ends       -->
                         <!-- if additional documnet exists against the patta by LM starts       -->
                        <?php if($additional_doc_by_lm != "NO-DATA-FOUND"):?>
                        <h5 class="text-center text-white" style="background-color:grey;padding:5px">ADDITIONAL DOCUMENT BY LM</h5>
                        <div class="row m-3">
                            <div class="col-lg-10">
                                <input type="text" class="form-control" value="<?=$additional_doc_by_lm->file_name?>" readonly>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <a href="<?=base_url().'index.php/EkhajanaCoController/viewAdditionalDocumentByLM?ld_application_no='.$caseDetails->ld_application_no?>"
                                    target="_blank" style="text-decoration:none;color:white;">
                                        View Document
                                    </a>
                                </button>
                            </div>
                        </div>
                        <?php endif ?>
                        <!-- if additional documnet exists against the patta by LM ends       -->
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #000000; color: #f00" colspan="6" class="text-center">
                                    JAMA WASIL STATUS : <?=$jama_wasil_status?>
                                </th>
                            </tr>
                        </table>  
                        <!-- <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #136a6f;color: #fff" colspan="6" class="text-center">
                                    DP-FLAGING-STATUS : <span style="color:yellow"><?=$dp_flag_status?></span>
                                </th>
                            </tr>
                            </thead>                            
                        </table>  -->
                        
                        <table class="table table-striped table-bordered fw-bold align-middle">
                            <!-- Table Title -->
                            <tr>
                                <td colspan="3" class="text-center text-white" style="background-color: #136a6f;">
                                    <i class="fas fa-info-circle me-2"></i> Status Information
                                </td>
                            </tr>

                            <tr>
                                <td><i class="fas fa-flag me-1 text-primary"></i> Dp-Flagging Status:</td>
                                <td><?=$dp_flag_status?></td>
                            </tr>

                            <tr>
                                <td><i class="fas fa-file-alt me-1 text-info"></i> e-CFR Generated:</td>
                                <td><?=$eCFRStatus?></td>
                            </tr>

                            <tr>
                                <td><i class="fas fa-user-check me-1 text-success"></i> Pattadar Identification By LM:</td>
                                <?php if($lm_identified =='Y'):?>
                                    <td class="text-success"><i class="fas fa-check-circle me-1"></i> Pattadar Identified</td>
                                <?php else:?>
                                    <td class="text-danger"><i class="fas fa-times-circle me-1"></i> Pattadar Not Identified</td>
                                <?php endif;?>
                            </tr>

                            <tr>
                                <td><i class="fas fa-user-tie me-1 text-warning"></i> Pattadar Identification By MOUZADAR:</td>
                                <?php if($mouzadar_identified =='Y'):?>
                                    <td class="text-success"><i class="fas fa-check-circle me-1"></i> Pattadar Identified</td>
                                <?php else:?>
                                    <td class="text-danger"><i class="fas fa-times-circle me-1"></i> Pattadar Not Identified</td>
                                <?php endif;?>
                            </tr>
                        </table>
               
                        <table class="table table-striped table-bordered text-bold">
                            <!-- <thead>
                            <tr>
                                <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                    LM Report
                                    <?php if($lm_identified =='Y'):?>
                                    <span style="color:red;background-color:yellow;border-radius:10px;padding:2px"><?='(Pattadar Identified)'?></span>
                                    <?php elseif($lm_identified =='N'):?>
                                    <span style="color:red;background-color:yellow;border-radius:10px;padding:2px"><?= '(Pattadar Not Identified)'?></span>
                                     <?php endif ?>
                                </th>
                            </tr>
                            </thead> -->
                            <tbody>
                            <!-- <tr>
                                <td>LM Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="lm_report" required readonly=""><?=$caseDetails->lm_remark?>
                                    </textarea>
                                </th>
                            </tr> -->
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered text-bold">
                            <!-- <thead>
                            <tr>
                                <th style="background-color: #136a6f; color: #fff" colspan="6" class="text-center">
                                    Mouzadar Report
                                    <?php if($mouzadar_identified =='Y'):?>
                                    <span style="color:red;background-color:yellow;border-radius:10px;padding:2px"><?='(Pattadar Identified)'?></span>
                                    <?php elseif($mouzadar_identified =='N'):?>
                                    <span style="color:red;background-color:yellow;border-radius:10px;padding:2px"><?= '(Pattadar Not Identified)'?></span>
                                    <?php endif ?>
                                </th>
                            </tr>
                            </thead> -->
                            <tbody>
                            <!-- <tr>
                                <td>Mouzadar Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="mou_report" required readonly=""><?=$caseDetails->mou_remark?>
                                    </textarea>
                                </th>
                            </tr> -->
                            <td style="text-align:center;background-color:#136a6f;color: #fff"colspan="3">Due Payment Calculated By Mouzadar</td>
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
                                    <td><?="Case Not Forwarded By Mouzadar"?></td>
                                <?php else:?>
                                    <td><?=$arrear_by_mouzadar->arrear?></td>
                                <?php endif;?>   
                            </tr>
                            </tbody>
                        </table>
                        <!-- getting patta status and arrear details -->
                        <?php
                            $patta_status = $this->EkhajanaHelperModel->getPattaStatus($caseDetails->dist_code,
                            $caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code, 
                            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code,
                            $caseDetails->patta_no);

                            $year_wise_arrear_details = $this->EkhajanaHelperModel->getYearWiseArrearDetails($caseDetails->dist_code,
                            $caseDetails->subdiv_code,$caseDetails->cir_code,$caseDetails->mouza_pargona_code, 
                            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code,
                            $caseDetails->patta_no);
                            // echo "<pre>";
                            // var_dump($year_wise_arrear_details);
                            // echo "</pre>";
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
                                        <div class="alert alert-danger" role="alert">
                                            NOTE:<br> 
                                            *If total area of the patta is 0, The Case can't be forwarded.<br>
                                            *If the patta is created after the doul submmision, The Case can't be forwrded.
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header h6 bg-primary text-center text-white">
                            REMARKS HISTORY OF THE CASE 
                            </div>
                            <div class="card card-body">
                            <table class="table table-striped table-bordered text-bold">
                                <thead>
                                    <td>Sl.No</td>
                                    <td>User</td>
                                    <td>Remarks</td>
                                    <td>Date</td>
                                <thead>
                                <tbody>
                                    <?php $counter = 1 ?>
                                    <?php foreach ($proceedingDetails as $row):?>
                                        <tr>
                                        <td><span class="badge bg-success"><?=$counter++.'.'?></span>&nbsp;</td> 
                                        <td><?php 
                                                if(substr($row->user_code,0,3) == 'MOU')
                                                    echo "MOUZADAR";
                                                elseif(substr($row->user_code,0,2) == 'CO') 
                                                    echo "CIRCLE OFFICER";
                                                 elseif(substr($row->user_code,0,1) == 'M')
                                                    echo "LRA";
                                            ?>
                                        </td> 
                                        <td>
                                            <?=$row->remark?>
                                        </td>
                                        <td>
                                            <?=$row->created_at?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                                    
                               
                            </table>
                            </div>
                        </div>
                        <!-- getting patta status -->
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
                                                <input class="form-check-input" type="radio" name="co_pattadar_identification_flag" value="Y" checked>
                                                YES
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="co_pattadar_identification_flag" value="N">
                                                NO
                                            </div>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                        </div>
                        <?php if($caseDetails->pdar_mobile_no != null || $caseDetails->pdar_mobile_no !=""):?>
                        <div class="card-header bg-gradient-primary text-white text-center py-3 shadow-sm rounded-top">
                            <h6 class="mb-0">
                                <i class="fas fa-phone-alt me-2"></i>
                                Pattadar Phone Number: 
                                <span class="fw-bold text-warning"><?=$caseDetails->pdar_mobile_no?></span>
                            </h6>
                        </div>

                        <!-- Note Section -->
                        <div class="text-center small fst-italic mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i> 
                            This phone number will be seeded into the Chitha after the disposal of the case.
                        </div>
                        <?php endif;?>

                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: #1e943c; color: #fff" colspan="6" class="text-center">
                                    CO Report(Approval-Remark-Only)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>CO Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="co_report" required></textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>

                        
                        <?php if($caseDetails->ast_remark != null):?>
                        <table class="table table-striped table-bordered text-bold">
                            <thead>
                            <tr>
                                <th style="background-color: red; color: #fff" colspan="6" class="text-center">
                                    ASSISTANT REVERTED REMARK
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>AST Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                <th colspan="5">
                                    <textarea class="form-control" rows=2 name="co_report" required><?=$caseDetails->ast_remark?></textarea>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
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
                        <?php if (EKHAJANA_MOUZADAR_CO_ACTIVE == 1): ?>
                        <div class="panel panel-secondary panel-form">
                            <div class="panel-heading text-center">
                                <button
                                    class="btn btn-danger btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="COrejectCaseMouzadariSystem('<?=$caseDetails->case_no?>')">
                                    <i class="glyphicon glyphicon-remove-sign"></i>
                                    REJECT CASE
                                </button>
                                <button
                                    class="btn btn-success btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="COdisposeCase()">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    DISPOSE
                                </button>
                                <?php if(EKHAJANA_REVERT_BY_CO_BUTTON_ACTIVE ==1):?>
                                <button
                                    class="btn btn-info btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;"
                                    onclick="CoRevertCaseMouzadariSystem('<?=$caseDetails->ld_application_no?>')">
                                    <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                    REVERT
                                </button>
                                <?php endif;?>
                                <a href="<?=base_url().'index.php/EkhajanaCoController/index'?>"
                                    class="btn btn-warning btn-sm text-white" role="button" 
                                    style="padding: 7px !important;font-size: 12px;font-weight: bold;">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    BACK TO HOME
                                </a>
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

    <div id="revertByCoMouzadari" class="modal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header text-center bg-warning text-white">
                    <h5 class="modal-title "><b>Revert By Circle Officer: </b>
                        <span class="white" id='revertCaseNoHtml'></span>
                    </h5>
                </div>
                <div class="modal-body">
                    <label>Revert Remark By Circle Officer</label>
                    <form id="revert_modal_mouzadari_system">
                    <input type="hidden" name="ld_application_no" id="ld_application_no_revert" value="<?=$caseDetails->ld_application_no?>">
                    <input type="hidden" name="application_no" id="application_no_revert" value="<?=$caseDetails->application_no?>">
                    <input type="hidden" name="case_no" id="case_no_revert" value="<?=$caseDetails->case_no?>">
                    <input type="hidden" name="patta_no" id="patta_no_revert" value="<?=$caseDetails->patta_no?>">
                    <textarea class="form-control mb-5" name="revert_reason" id="revert_reason"></textarea>
                    <div>
                        <?php if(EKHAJANA_REVERT_TO_LM_BY_CO_BUTTON_ACTIVE ==1):?>
                        <button class="btn btn-sm btn-success">
                        <i class="fa fa-reply-all" aria-hidden="true"></i>
                            Revert To LM
                        </button>
                        <?php endif;?>
                        <?php if(EKHAJANA_REVERT_TO_MOUZADAR_BY_CO_BUTTON_ACTIVE ==1):?>
                        <button class="btn btn-sm btn-info" onclick="revertToMouzadar()">
                        <i class="fa fa-share-square-o" aria-hidden="true"></i>
                            Revert To MOUZADAR
                        </button>
                        <?php endif;?>
                        <?php if(EKHAJANA_REVERT_TO_BOTH_LM_AND_MOUZADAR_BY_CO_BUTTON_ACTIVE ==1):?>
                        <button class="btn btn-sm btn-danger">
                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                            Revert To Both LM And Mouzadar
                        </button>
                        <?php endif;?>
                        </form>
                    </div> 
                    <!-- validation-errors-div -->
                    <div class="col-lg-12" id="coArr_error_div_revert" style="display:none;margin-top:1rem">
                        <div class="card-header h5 bg-danger text-white text-center">
                            VALIDATION ERRORS
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-center" style="color:red !important" id="coArr_validation_error_revert_msg">
                            </strong>
                        </div>
                    </div>
                    <!-- validation-error-div-end -->  
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .blockUI {
            z-index: 1200 !important;
        }
    </style>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>
<script>
    function revertToMouzadar()
    {
        event.preventDefault();
        var formdata = $('#revert_modal_mouzadari_system').serialize();
        $.ajax({
            url: baseurl + "EkhajanaCoController/revertToMouzadar",
            type: 'POST',
            data: formdata,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.result == 'VALIDATION-ERROR'){
                    $.unblockUI();
                    alert("Validation-Error...!!");
                    $('#coArr_error_div_revert').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#coArr_validation_error_revert_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    alert(data.msg);
                    return;

                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    Swal.fire({
                        title: 'Case Was Reverted To Mouzadar Successfully!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Home'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = baseurl + "EkhajanaCoController/index";
                        }
                    })
                    return;
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }
</script>

