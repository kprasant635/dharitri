<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 px-0">
    <div class="panel panel-info">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="panel-heading bg-success text-white">
                    <h3 class="panel-title text-center text-white"><b>KHATIAN MODULE</b></h3>
                </div>
                <div class="tab-pane" id="preview">
                    <div class="panel-body " style="border-radius: 5px">
                        <form class="form-horizontal" method='post' id="khatian_co_final_submit"
                              autocomplete="off">
                            <input type="hidden" value="<?= $khatians[0]->khatian_no ?>"
                                   name="khatian_no" readonly>
                            <input type="hidden" value="<?= $khatians[0]->app_id ?>" id="app_id"
                                   name="app_id">
                            <input type="hidden" value="<?= $khatians[0]->uuid ?>" id="uuid"
                                   name="uuid">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
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
                                            <th style="background-color: #136a6f; color: #fff" colspan="6">Khatian
                                                Basic Details
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Khatian No.:</th>
                                            <th><b> <?= $khatians[0]->khatian_no ?> </b></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($khatians as $key => $k): ?>
                                            <tr style="background-color: #f55d42; color: #fff">
                                                <td>SL No.:</td>
                                                <td width="70%"><b>  <?= ++$key; ?>  </b></td>
                                            </tr>
                                            <tr>
                                                <td>Dag No.:</td>
                                                <td width="70%"><b> <?= $k->dag_no ?> </b></td>
                                            </tr>
                                            <tr>
                                                <td>Chitha Land Area:</td>
                                                <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                                    <td width="70%"><b> <?= $k->dag_area_b ?> B - <?= $k->dag_area_k ?> K
                                                            - <?= $k->dag_area_lc ?> L - <?= $k->dag_area_g ?> G
                                                            - <?= $k->dag_area_kr ?> Kr </b></td>
                                                <?php else: ?>
                                                    <td width="70%"><b> <?= $k->dag_area_b ?> B - <?= $k->dag_area_k ?> K
                                                            - <?= $k->dag_area_lc ?> L </b></td>
                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <td>Length of Possession (In Year):</td>
                                                <td width="70%">  <?= $k->length_posession ?>  </td>
                                            </tr>
                                            <tr>
                                                <td>Status of Tenant(s):</td>
                                                <td width="70%">  <?= $k->tenant_status ?>  </td>
                                            </tr>
                                            <tr>
                                                <td>Paid Cash Kind:</td>
                                                <td width="70%">  <?= $k->paid_cash_kind ?>  </td>
                                            </tr>
                                            <tr>
                                                <td>Payable Cash/Kind:</td>
                                                <td width="70%">  <?= $k->payable_cash_kind ?> </td>
                                            </tr>
                                            <tr>
                                                <td>Special Conditions and incidence, right of way casement etc:</td>
                                                <td width="70%">  <?= $k->special_conditions ?>  </td>
                                            </tr>
                                            <tr>
                                                <td>Remarks:</td>
                                                <td width="70%">  <?= $k->remarks ?>  </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">Tenant
                                            Details
                                        </th>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($tenants as $key => $t): ?>
                                            <tr style="background-color: #f55d42; color: #fff">
                                                <td>SL No.:</td>
                                                <td colspan="5"><b>  <?= ++$key; ?> </b></td>
                                            </tr>
                                            <tr>
                                                <td>Name:</td>
                                                <td colspan="2"> <?= $t->tenant_name ?>  </td>
                                                <td>Tenant Gurdian:</td>
                                                <td colspan="2">  <?= $t->tenants_father ?></td>
                                            </tr>
                                            <tr>
                                                <td>Address:</td>
                                                <td colspan="5"> <?= $t->tenants_add1 ?></td>
                                            </tr>
                                            <tr>
                                                <td>Second Address:</td>
                                                <td colspan="5"> <?= $t->tenants_add2 ?> </td>
                                            </tr>
                                            <tr>
                                                <td>Land Possession Area:</td>
                                                <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                                    <td colspan="5"><b> <?= $t->bigha ?> B - <?= $t->katha ?> K
                                                            - <?= $t->lessa ?> L - <?= $t->ganda ?> G
                                                            - <?= $t->kranti ?> Kr </b></td>
                                                <?php else: ?>
                                                    <td colspan="5"><b> <?= $t->bigha ?> B - <?= $t->katha ?> K
                                                            - <?= $t->lessa ?> L </b></td>

                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <td>Tenant Type:</td>
                                                <td colspan="5"> <?= $t->tenant_type ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    
                                        <table class="table table-striped table-bordered text-bold">
                                            <thead>
                                                <tr>
                                                    <th style="background-color:rgb(39, 171, 21); color: #fff" colspan="6">Uploaded Khatians</th>
                                                </tr>
                                            </thead>
                                            <tbody>   
                                                <?php foreach ($documents as $document): ?>
                                                    <?php 
                                                        $randomPrefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5); 
                                                        $randomSuffix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);                                             
                                                        $fileLink = base_url('index.php/MultipleFileUpload/viewfile/' . $randomPrefix . $document['id'] . $randomSuffix);
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo htmlspecialchars($document['file_name'])?></td>
                                                        <td colspan="5">
                                                            <a href="<?php echo $fileLink; ?>" target="_blank">VIEW FILE</a></b>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    

                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #136a6f; color: #fff" colspan="6">CO Report
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>CO Report:</td>
                                            <td colspan="5">
                                                <textarea class="form-control"
                                                          placeholder='CO Report' rows=3
                                                          name="co_note" required></textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-lg-12" id="save_form_error_div3"
                                         style="display: none;">
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <strong class="text-left"
                                                    style="color:red !important; font-weight: bold: !important;"
                                                    id="form_errors3">
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="form-group" id="final_submit_div"
                                         style="width: 100%;text-align: center;">
                                        <button type="submit" class="btn uni_text btn-primary"><i
                                                    class='fa fa-check'></i> Final Order
                                        </button>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#revert_back"><i
                                                    class='fa fa-arrow-circle-up'></i> Revert Back to LM
                                        </button>
                                    </div>
                                    <div class="col-lg-12 text-center mt-3" id="save_success_div3"
                                         style="display: none;">
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <strong class="text-left"
                                                    style="color:blue !important; font-weight: bold: !important;"
                                                    id="form_success3">
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- nav-tabs-custom -->
        </div>
    </div>
</div>

<div class="modal" id="revert_back" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reverted Back to LM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="revert_back_to_lm" method='post'>
                <input type="hidden" value="<?= $khatians[0]->khatian_no ?>"
                       name="khatian_no" readonly>
                <input type="hidden" value="<?= $khatians[0]->app_id ?>" id="app_id"
                       name="app_id">
                <input type="hidden" value="<?= $khatians[0]->uuid ?>" id="uuid"
                       name="uuid">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required">Reason of Revert Back</label>
                        <textarea class="form-control"
                                  placeholder='Reason of Revert Back' rows=3
                                  name="co_reason" required></textarea>
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
                                class='fa fa-check'></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script> let BARAK_VALLEY = <?php echo BARAK_VALLEY ?> </script>
<script src="<?php echo base_url(); ?>application/views/js/khatian.js"></script>