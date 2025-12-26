<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 px-0">
    <div class="panel panel-info">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="panel-heading bg-success text-white">
                    <?php $patta_application_type = json_decode(PATTA_APPLICATION_TYPE);
                    if($application_type == $patta_application_type[0]->CODE): ?>
                        <h3 class="panel-title text-center text-white"><b>PERIODIC KHIRAJ PATTA(GOALPARA)</b></h3>
                    <?php else: ?>
                        <h3 class="panel-title text-center text-white"><b>ANNUAL KHIRAJ PATTA</b></h3>
                    <?php endif; ?>
                </div>
                <div class="panel-body p-0" style="border-radius: 5px">
                    <form class="form-horizontal" method='post' id="save_patta_application_goalpara" autocomplete="off">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <input type="hidden" value="<?= $this->session->userdata('dist_code') ?>" id="dist_code"
                                       name="dist_code">
                                <input type="hidden" value="<?= $case_no ?>" id="case_no"
                                       name="case_no">
                                <input type="hidden" value="<?= $petition_no ?>" id="petition_no"
                                       name="petition_no">
                                <input type="hidden" value="<?= $application_type ?>" id="application_type"
                                       name="application_type">
                                <input type="hidden" value="<?= $vill_code ?>" id="vill_code"
                                       name="vill_code">
                                <input type="hidden" value="<?= $patta_type ?>" id="patta_type"
                                       name="patta_type">
                                <input type="hidden" value="<?= $patta_no ?>" id="patta_no"
                                       name="patta_no">
                                <input type="hidden" value="2" id="row_id"
                                       name="row_id">

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
                                        <th class="bg-secondary text-white" colspan="8">
                                            Patta No - <?= $patta_no ?>
                                        </th>
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
                                        <th width="25%"><?= $case_no ?></th>
                                        <th width="25%">Date :</th>
                                        <th width="25%"><?= date('d-m-Y') ?></th>
                                    </tr>
                                    </thead>
                                </table>
                                <?php $patta_application_type = json_decode(PATTA_APPLICATION_TYPE);
                                if($application_type == $patta_application_type[0]->CODE): ?>
                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #136a6f; color: #fff" colspan="8">
                                                Periodic Khiraj Patta Details
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="25%">For How Many Years(s) :</th>
                                            <th width="25%"> <input type='number' name='time_period' id="time_period" placeholder='For How Many Years(s)'
                                                        class="form-control"/></th>
                                            <th width="25%">Upto which Date :</th>
                                            <th width="25%"><input type='text' name='upto_date' id="upto_date" placeholder='To Date'
                                                                   class="form-control" readonly/>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="25%">First Installment Date :</th>
                                            <th width="25%"> <input type='text' name='installment1' placeholder='First Installment'
                                                                    class="form-control dateNew" readonly/></th>
                                            <th width="25%">Revenue to be Paid : </th>
                                            <th width="25%"><input type='number' name='revenue_to_be_paid1' placeholder='Revenue to be Paid'
                                                                   class="form-control"/></th>
                                        </tr>
                                        <tr>
                                            <th width="25%">Second Installment Date :</th>
                                            <th width="25%"> <input type='text' name='installment2' placeholder='Second Installment'
                                                                    class="form-control dateNew" readonly/></th>
                                            <th width="25%">Revenue to be Paid :</th>
                                            <th width="25%"><input type='number' name='revenue_to_be_paid2' placeholder='Revenue to be Paid'
                                                                   class="form-control"/></th>
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
                                            <th width="25%"> <input type='number' name='time_period' id="time_period" placeholder='For How Many Years(s)'
                                                                    class="form-control" min="0"/></th>
                                            <th width="25%">Upto which Date : <span style="color:red;font-weight:bold; font-size: 18px;">*</span></th>
                                            <th width="25%"><input type='text' name='upto_date' id="upto_date" placeholder='To Date'
                                                                   class="form-control" readonly/>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="25%">Revenue to be Paid :</th>
                                            <th width="25%"><input type='number' name='revenue_to_be_paid1' placeholder='Revenue to be Paid'
                                                                   class="form-control"/></th>
                                            <th colspan="2"></th>
                                        </tr>
                                        </thead>
                                    </table>
                                <?php endif; ?>
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #136a6f; color: #fff" colspan="10">
                                            Applicant Dag and Land Area
                                        </th>
                                    </tr>
                                    <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                        <tr style="background-color: #919191; color: #fff">
                                            <th colspan="2">Daag No</th>
                                            <th colspan="2">Bigha</th>
                                            <th colspan="2">Katha</th>
                                            <th colspan="2">Chatak</th>
                                            <th colspan="2">Ganda</th>
                                            <th colspan="2">Kranti</th>
                                        </tr>
                                    <?php else: ?>
                                        <tr style="background-color: #919191; color: #fff">
                                            <th colspan="2">Daag No</th>
                                            <th colspan="3">Bigha :</th>
                                            <th colspan="3">Katha</th>
                                            <th colspan="4">Lessa</th>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                        <?php foreach ($dag_no as $dag):?> 
                                            <tr>
                                                <th colspan="2"><?=$dag->dag_no?></th>
                                                <th colspan="2"><?=$dag->dag_area_b?></th>
                                                <th colspan="2"><?=$dag->dag_area_k?></th>
                                                <th colspan="2"><?=$dag->dag_area_lc?></th>
                                                <th colspan="2"><?=$dag->dag_area_g?></th>
                                                <th colspan="2"><?=$dag->dag_area_kr?></th>
                                            </tr>
                                        <?php endforeach;?>  
                                    <?php else: ?>
                                        <?php foreach ($dag_no as $dag):?> 
                                            <tr id="dag_area">
                                            <th colspan="2"><?=$dag->dag_no?></th>
                                            <th colspan="3"><?=$dag->dag_area_b?></th>
                                            <th colspan="3"><?=$dag->dag_area_k?></th>
                                            <th colspan="4"><?=$dag->dag_area_lc?></th>
                                        </tr>
                                        <?php endforeach;?>  
                                    <?php endif; ?>
                                    </thead>
                                </table>
                                <div id="add_more_dag"></div>
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
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">LM
                                            Report
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>LM Report: </td>
                                        <th colspan="5">
                                                <textarea class="form-control"
                                                          placeholder='LM Report' rows=3
                                                          name="lm_report" required></textarea>
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-12" id="save_form_error_div"
                                     style="display: none;">
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        <strong class="text-left"
                                                style="color:red !important; font-weight: bold;"
                                                id="form_errors">
                                        </strong>
                                    </div>
                                </div>
                                <div class="form-group" style="width: 100%;text-align: center;">
                                    <button type="submit" class="btn uni_text btn-primary"><i
                                            class='fa fa-check'></i> Save Application
                                    </button>
                                </div>
                                <div class="col-lg-12 text-center mt-3" id="save_success_div"
                                     style="display: none;">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong class="text-left"
                                                style="color:blue !important; font-weight: bold;"
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

<script> let BARAK_VALLEY = <?php echo BARAK_VALLEY ?> </script>
<script src="<?php echo base_url(); ?>application/views/js/patta.js"></script>