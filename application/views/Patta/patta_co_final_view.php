<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 px-0">
    <div class="panel panel-info">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="panel-heading bg-success text-white">
                    <?php $patta_application_type = json_decode(PATTA_APPLICATION_TYPE);
                    if($patta_basic->patta_type == $patta_application_type[0]->CODE): ?>
                        <h3 class="panel-title text-center text-white"><b>PERIODIC KHIRAJ PATTA</b></h3>
                    <?php else: ?>
                        <h3 class="panel-title text-center text-white"><b>ANNUAL KHIRAJ PATTA</b></h3>
                    <?php endif; ?>
                </div>
                <div class="panel-body p-0" style="border-radius: 5px">
                    <form class="form-horizontal" method='post' id="co_save_patta_application" autocomplete="off">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <input type="hidden" value="<?= $this->session->userdata('dist_code') ?>" id="dist_code"
                                       name="dist_code">
                                <input type="hidden" value="<?= $patta_basic->case_no ?>" id="case_no"
                                       name="case_no">
                                <input type="hidden" value="<?= $patta_basic->petition_no ?>" id="petition_no"
                                       name="petition_no">
                                <input type="hidden" value="<?= $patta_basic->patta_type ?>" id="application_type"
                                       name="application_type">
                                <input type="hidden" value="<?= $vill_code ?>" id="vill_code"
                                       name="vill_code">
                                <input type="hidden" value="<?= $patta_basic->patta_type_code ?>" id="patta_type"
                                       name="patta_type">
                                <input type="hidden" value="<?= $patta_basic->patta_no ?>" id="patta_no"
                                       name="patta_no">

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">
                                            Location Details
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>District :</th>
                                        <th class="red"><?= $this->utilityclass->getDistrictName($dist_code) ?></th>
                                        <th>Sub Division :</th>
                                        <th class="red"><?= $this->utilityclass->getSubDivName($dist_code, $subdiv_code) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Circle :</th>
                                        <th class="red"><?= $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code) ?></th>
                                        <th>Mouza :</th>
                                        <th class="red"><?= $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Lot :</th>
                                        <th class="red"><?= $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no ) ?></th>
                                        <th>Village :</th>
                                        <th class="red"><?= $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,$lot_no,$vill_code ) ?></th>
                                    </tr>
                                    </thead>
                                </table>
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff" colspan="8">
                                            Application Details
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="25%">Case No :</th>
                                        <th width="25%" class="red"><?= $patta_basic->case_no ?></th>
                                        <th width="25%">Date :</th>
                                        <th width="25%" class="red"><?= date('d-m-Y', strtotime($patta_basic->created_date)) ?></th>
                                    </tr>
                                    </thead>
                                </table>
                                <?php $patta_application_type = json_decode(PATTA_APPLICATION_TYPE);
                                if($patta_basic->patta_type == $patta_application_type[0]->CODE): ?>
                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #136a6f; color: #fff" colspan="8">
                                                Periodic Khiraj Patta Details
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="25%">For How Many Years(s) : </th>
                                            <th width="25%" class="red"><?= $patta_basic->time_period ?></th>
                                            <th width="25%">Upto which Date :</th>
                                            <?php if (!isset($patta_basic->upto_date) || $patta_basic->upto_date=="" || $patta_basic->upto_date==NULL) :?>
                                                <th width="25%" class="red"></th>
                                            <?php else : ?>
                                                <th width="25%" class="red"><?= date('d-m-Y', strtotime($patta_basic->upto_date)) ?></th>
                                            <?php endif ?>                                            
                                        </tr>
                                        <tr>
                                            <th width="25%">First Installment Date : </th>
                                            <?php if (!isset($patta_basic->installment1) || $patta_basic->installment1=="" || $patta_basic->installment1==NULL) :?>
                                                <th width="25%" class="red"></th>
                                            <?php else : ?>
                                                <th width="25%" class="red"><?= date('d-m-Y', strtotime($patta_basic->installment1)) ?></th>                                                
                                            <?php endif ?>
                                            <th width="25%">Revenue to be Paid : </th>
                                            <th width="25%" class="red"><?= $patta_basic->revenue_to_be_paid1 ?></th>
                                        </tr>
                                        <tr>
                                            <th width="25%">Second Installment Date: </th>
                                            <?php if (!isset($patta_basic->installment2) || $patta_basic->installment2=="" || $patta_basic->installment2==NULL) :?>
                                                <th width="25%" class="red"></th>
                                            <?php else : ?>
                                                <th width="25%" class="red"><?= date('d-m-Y', strtotime($patta_basic->installment2)) ?></th>                                                
                                            <?php endif ?>                                            
                                            <th width="25%">Revenue to be Paid : </th>
                                            <th width="25%" class="red"><?= $patta_basic->revenue_to_be_paid2 ?></th>
                                        </tr>
                                        </thead>
                                    </table>
                                <?php else: ?>
                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #136a6f; color: #fff" colspan="6">
                                                Annual Khiraj Patta Details
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="25%">For How Many Years(s) : </th>
                                            <th width="25%" class="red"><?= $patta_basic->time_period ?></th>
                                            <th width="25%">Upto which Date :</th>
                                            <th width="25%" class="red"><?= date('d-m-Y', strtotime($patta_basic->upto_date)) ?></th>
                                        </tr>
                                        <tr>
                                            <th width="25%">Revenue to be Paid :</th>
                                            <th width="25%" class="red"><?= $patta_basic->revenue_to_be_paid1 ?></th>
                                            <th colspan="2"></th>
                                        </tr>
                                        </thead>
                                    </table>
                                <?php endif; ?>
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff" colspan="8">
                                            Applicant Dag and Land Area
                                        </th>
                                    </tr>
                                    <?php foreach ($patta_basic_dag as $key=>$d): ?>
                                    <tr>
                                        <th colspan="1">SL No #<?= ++$key; ?></th>
                                        <th colspan="2" width="20%">Dag No : <span class="red"><?= $d->dag_no ?></span></th>
                                        <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                            <th colspan="2">Appiled Dag Area (B-K-C-G-Kr)</th>
                                            <th colspan="3">B <?= $d->dag_area_b ?> - K <?= $d->dag_area_k ?> -
                                                C <?= $d->dag_area_lc ?> - G <?= $d->dag_area_g ?> - Kr <?= $d->dag_area_kr ?></th>
                                        <?php else: ?>
                                            <th colspan="2">Appiled Dag Area (B-K-L)</th>
                                            <th colspan="3" class="red">B <?= $d->dag_area_b ?> - K <?= $d->dag_area_k ?> -
                                                L <?= $d->dag_area_lc ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    </thead>
                                </table>
                                

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #136a6f; color: #fff" colspan="6">
                                                Pattadar Details
                                            </th>
                                        </tr>
                                        <tr style="background-color: #919191; color: #fff">
                                            <th width="25%">Pattadar Name</th>
                                            <th width="25%">Guardian Name</th>
                                            <th class="hide" width="25%">Mobile</th>  
                                        </tr>
                                        <?php foreach ($pattadar as $pattadar_details):?>     
                                            <tr>
                                                <th width="25%"><?=$pattadar_details->pdar_name?></th>
                                                <th width="25%"><?=$pattadar_details->pdar_father?></th>                    
                                                <th class="hide" width="25%"><?=$pattadar_details->pdar_mobile?></th>
                                            </tr>
                                        <?php endforeach;?>                               
                                    </thead>
                                </table>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff">LM
                                            Report
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>LM Report: <?= $patta_basic->lm_report ?></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">CO
                                            Report
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>CO Report: <span style="color:red;font-weight:bold; font-size: 18px;">*</span></td>
                                        <th colspan="5">
                                                <textarea class="form-control"
                                                          placeholder='CO Report' rows=3
                                                          name="co_report" required></textarea>
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-12" id="save_form_error_div"
                                     style="display: none;">
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        <strong class="text-left"
                                                style="color:red !important; font-weight: bold: !important;"
                                                id="form_errors">
                                        </strong>
                                    </div>
                                </div>
                                <div class="form-group" style="width: 100%;text-align: center;">
                                    <button type="submit" class="btn uni_text btn-primary"><i
                                            class='fa fa-check'></i> Order Pass
                                    </button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#reject"><i
                                                class='fa fa-close'></i> Reject Case
                                    </button>
                                </div>
                                <div class="col-lg-12 text-center mt-3" id="save_success_div"
                                     style="display: none;">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong class="text-left"
                                                style="color:blue !important; font-weight: bold: !important;"
                                                id="form_success">
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="reject" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Case No: <?= $patta_basic->case_no ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reject_case" method='post'>
                <input type="hidden" value="<?= $patta_basic->case_no ?>"
                       name="case_no" readonly>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required"> Reason of Reject</label>
                        <textarea class="form-control"
                                  placeholder='Reason of Reject' rows=3
                                  name="co_report" required></textarea>
                    </div>
                </div>
                <div class="col-lg-12" id="save_form_error_div4"
                     style="display: none;">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-left"
                                style="color:red !important; font-weight: bold: !important;"
                                id="form_errors4">
                        </strong>
                    </div>
                </div>
                <div class="col-lg-12 text-center mt-3" id="save_success_div4"
                     style="display: none;">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong class="text-left"
                                style="color:blue !important; font-weight: bold: !important;"
                                id="form_success4">
                        </strong>
                    </div>
                </div>
                <div class="modal-footer" id="final_submit_div4">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class='fa fa-close'></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i
                                class='fa fa-check'></i> Reject Case
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script> let BARAK_VALLEY = <?php echo BARAK_VALLEY ?> </script>
<script src="<?php echo base_url(); ?>application/views/js/patta.js"></script>