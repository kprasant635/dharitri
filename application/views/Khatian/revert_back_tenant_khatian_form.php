<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 px-0">
    <div class="panel panel-info">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="panel-heading bg-success text-white">
                    <h3 class="panel-title text-center text-white"><b>KHATIAN MODULE</b></h3>
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs border bold">
                        <li class="active">
                            <a href="#tenant" class="tenant" data-toggle="tab"
                               style="pointer-events:none;text-decoration: none">Tenant(s)
                            </a>
                        </li>
                        <li>
                            <a href="#khatian_basic" class="khatian_basic" data-toggle="tab"
                               style="pointer-events:none;text-decoration: none">Khatian Basic Data
                            </a>
                        </li>
                        <li>
                            <a href="#preview" class="preview" data-toggle="tab"
                               style="pointer-events:none;text-decoration: none">Khatian Preview
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tenant">
                            <div class="panel-body p-0" style="border-radius: 5px">
                                <form class="form-horizontal" method='post' id="add_tenant" autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                            <table class="table table-striped table-bordered text-bold">
                                                <thead>
                                                <th style="background-color: #136a6f; color: #fff" colspan="6">Tenant
                                                    Details
                                                </th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="required uni_text control-label">Khatian
                                                            No.:</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="number" class="form-control"
                                                               style="font-weight: bold;" value="<?= $khatian_no ?>"
                                                               id="khatian_no"
                                                               name="khatian_no" readonly>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_khatian_no" class="error_class"></span>
                                                    </td>
                                                    <td colspan="3"></td>

                                                </tr>
                                                <tr>
                                                    <td width="15%"><label
                                                                class="required uni_text control-label">Name:</label>
                                                    </td>
                                                    <td width="20%" colspan="2">
                                                        <input type='text' name='tenant_name' placeholder='Tenant Name'
                                                               class="form-control input-lg"/>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_tenant_name" class="error_class"></span>
                                                    </td>
                                                    <td width="15%"><label class="required uni_text control-label">Tenant
                                                            Gurdian:</label></td>
                                                    <td width="20%" colspan="2">
                                                        <input type='text' name='tenant_gurdian'
                                                               placeholder='Gurdian Name'
                                                               class="form-control input-lg"/>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_tenant_gurdian" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label class="required uni_text control-label">Address:</label>
                                                    </td>
                                                    <td width="80%" colspan="5">
                                                        <textarea class="form-control" placeholder='Type Address' rows=3
                                                                  name="tenant_add1"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_tenant_add1" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label class="uni_text control-label">Second
                                                            Address:</label></td>
                                                    <td width="80%" colspan="5">
                                                        <textarea class="form-control" placeholder='Optional Address'
                                                                  rows=3 name="tenant_add2"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_tenant_add2" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                                    <tr>
                                                        <td width="15%"><label class="required uni_text control-label">Land
                                                                Possession Area:</label></td>
                                                        <td> Bigha
                                                            <input type='number' name='bigha' placeholder='Bigha'
                                                                   class="form-control">
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_bigha" class="error_class"></span>
                                                        </td>
                                                        <td> Katha
                                                            <input type='number' max="19" maxlength="2" name='katha'
                                                                   placeholder='Katha' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_katha" class="error_class"></span>
                                                        </td>
                                                        <td> Chatak
                                                            <input type='number' max="14" maxlength="2" name='lessa'
                                                                   placeholder='Lessa' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_lessa" class="error_class"></span>
                                                        </td>
                                                        <td> Ganda
                                                            <input type='number' max="19" maxlength="2" name='ganda'
                                                                   placeholder='Ganda' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_ganda" class="error_class"></span>
                                                        </td>
                                                        <td> Kranti
                                                            <input type='number' maxlength="2" name='kranti'
                                                                   placeholder='Kranti' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_kranti" class="error_class"></span>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td width="15%"><label class="required uni_text control-label">Land
                                                                Possession Area:</label></td>
                                                        <td colspan="2"> Bigha
                                                            <input type='number' name='bigha' placeholder='Bigha'
                                                                   class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_bigha" class="error_class"></span>
                                                        </td>
                                                        <td> Katha
                                                            <input type='number' max="4" maxlength="1" name='katha'
                                                                   placeholder='Katha' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_katha" class="error_class"></span>
                                                        </td>
                                                        <td colspan="2"> Lessa
                                                            <input type='number' max="19" maxlength="2" name='lessa'
                                                                   placeholder='Lessa' class="form-control"/>
                                                            <span style="color:red; font-size: 14px; padding-top:5px;"
                                                                  id="error_lessa" class="error_class"></span>
                                                        </td>
                                                        <input type='hidden' max="19" maxlength="2" name='ganda'
                                                               value="0"
                                                               placeholder='Ganda' class="form-control"/>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_ganda" class="error_class"></span>
                                                        <input type='hidden' maxlength="2" name='kranti' value="0"
                                                               placeholder='Kranti' class="form-control"/>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_kranti" class="error_class"></span>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td>
                                                        <label class="required uni_text control-label">Tenant
                                                            Type</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <select class="form-select" name='tenant_type' required>
                                                            <?php foreach ($tenant_type as $tp): ?>
                                                                <option value="<?= $tp->type_code ?>"><?= $tp->tenant_type; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_teant_type" class="error_class"></span>
                                                    </td>
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
                                            <input type="hidden" value="<?= $vill_code ?>" id="vill_code"
                                                   name="vill_code">
                                            <input type="hidden" value="<?= $app_id ?>" id="app_id"
                                                   name="app_id">

                                            <div class="form-group" style="width: 100%;text-align: center;">
                                                <div class="">
                                                    <button type="submit" class="btn uni_text btn-primary"><i
                                                                class='fa fa-check'></i> Add Tenant
                                                    </button>
                                                    <button type="button" class="btn uni_text btn-success"
                                                            id="add_tenant_next"><i
                                                                class='fa fa-arrow-circle-right'></i> Proceed To Next
                                                        Stage
                                                    </button>
                                                </div>
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

                            <div class="col-md-12 px-0">
                                <div class="panel-heading px-0">
                                    <div class="panel-title text-primary px-0">List of Tenant(s)</div>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" style="overflow:auto;">
                                <thead style="white-space:nowrap; width:100%;">
                                <tr class="text-bold table-success ">
                                    <th align='center' style="background-color: #136a6f; color: #fff">#</th>
                                    <th style="background-color: #136a6f; color: #fff">Khatian No</th>
                                    <th style="background-color: #136a6f; color: #fff">Tenant Name</th>
                                    <th style="background-color: #136a6f; color: #fff">Tenant Gurdian</th>
                                    <th style="background-color: #136a6f; color: #fff">Tenant Type</th>
                                    <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                        <th style="background-color: #136a6f; color: #fff">Land Possession Area
                                            (B-K-C-G-Kr)
                                        </th>
                                    <?php else: ?>
                                        <th style="background-color: #136a6f; color: #fff">Land Possession Area
                                            (B-K-L)
                                        </th>
                                    <?php endif; ?>
                                    <th style="background-color: #136a6f; color: #fff">Address 1</th>
                                    <th style="background-color: #136a6f; color: #fff">Address 2</th>
                                    <th style="background-color: #136a6f; color: #fff">Action</th>
                                </tr>
                                </thead>
                                <tbody id="tenant_table_show">
                                <?php foreach ($tenants as $key => $t): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $t->khatian_no ?></td>
                                        <td><?= $t->tenant_name ?></td>
                                        <td><?= $t->tenants_father ?></td>
                                        <td><?= $t->tenant_type ?></td>
                                        <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                            <td><b>
                                                    <?= $t->bigha ?>B- <?= $t->katha ?>K- <?= $t->lessa ?>
                                                    C- <?= $t->ganda ?>G- <?= $t->kranti ?>Kr
                                                </b>
                                            </td>
                                        <?php else: ?>
                                            <td><b>
                                                    <?= $t->bigha ?>B- <?= $t->katha ?>K- <?= $t->lessa ?>C
                                                </b>
                                            </td>
                                        <?php endif; ?>
                                        <td><?= $t->tenants_add1 ?></td>
                                        <td><?= $t->tenants_add2 ?></td>
                                        <td>
                                        <span data-id="<?= $t->id ?>" class="text-center delete_tenant">
                                        <button class="btn btn-danger" type="button"><i
                                                    class="fa fa-trash"></i></button></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="khatian_basic">
                            <div class="panel-body p-0" style="border-radius: 5px">
                                <form class="form-horizontal" method='post' id="add_khatian_basic" autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                            <table class="table table-striped table-bordered text-bold">
                                                <thead>
                                                <th style="background-color: #136a6f; color: #fff" colspan="6">Khatian
                                                    Basic Details
                                                </th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="required uni_text control-label">Khatian
                                                            No.:</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="number" class="form-control"
                                                               style="font-weight: bold;" value="<?= $khatian_no ?>"
                                                               id="khatian_no"
                                                               name="khatian_no" readonly>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_khatian_no" class="error_class"></span>
                                                    </td>
                                                    <td>
                                                        <label class="required uni_text control-label">Dag No.:</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <select class="form-select" name='dag_no' id="dag_no" required>
                                                        </select>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_dag_no" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><label class="required uni_text control-label" style="text-align: left">Length
                                                            of Possession (In Years):</label>
                                                    </td>
                                                    <td width="80%" colspan="5">
                                                        <input type="number" class="form-control input-lg" placeholder='Length of Possession'
                                                               name="length_posession">
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_length_posession" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label class="required uni_text control-label">Status
                                                            of Tenant(s):</label>
                                                    </td>
                                                    <td width="80%" colspan="5">
                                                        <textarea class="form-control" placeholder='Status of Tenant(s)'
                                                                  rows=3
                                                                  name="tenant_status"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_tenant_status" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label
                                                                class="required uni_text control-label">Paid Cash
                                                            Kind:</label>
                                                    </td>
                                                    <td colspan="5">
                                                        <textarea class="form-control" placeholder='Paid Cash Kind'
                                                                  rows=3
                                                                  name="paid_cash_kind"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_paid_cash_kind" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label
                                                                class="required uni_text control-label">Payable
                                                            Cash/Kind:</label>
                                                    </td>
                                                    <td width="20%" colspan="5">
                                                        <textarea class="form-control" placeholder='Payable Cash/Kind'
                                                                  rows=3
                                                                  name="payable_cash_kind"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_payable_cash_kind" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label class="required uni_text control-label" style="text-align: left">Special
                                                            Conditions and incidence, right of way casement etc:</label>
                                                    </td>
                                                    <td width="80%" colspan="5">
                                                        <textarea class="form-control" placeholder='Type Here' rows=3
                                                                  name="special_conditions"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_special_conditions" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><label class="required uni_text control-label">Remarks
                                                            :</label>
                                                    </td>
                                                    <td width="80%" colspan="5">
                                                        <textarea class="form-control" placeholder='Remarks' rows=3
                                                                  name="remarks"></textarea>
                                                        <span style="color:red; font-size: 14px; padding-top:5px;"
                                                              id="error_remarks" class="error_class"></span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <?php include(APPPATH.'views/Khatian/multipleUpload.php')?>

                                            <div class="col-lg-12" id="save_form_error_div2"
                                                 style="display: none;">
                                                <div class="alert alert-warning alert-dismissible" role="alert">
                                                    <strong class="text-left"
                                                            style="color:red !important; font-weight: bold: !important;"
                                                            id="form_errors2">
                                                    </strong>
                                                </div>
                                            </div>
                                            <input type="hidden" value="<?= $vill_code ?>" id="vill_code"
                                                   name="vill_code">
                                            <input type="hidden" value="<?= $app_id ?>" id="app_id"
                                                   name="app_id">
                                            <div class="form-group" style="width: 100%;text-align: center;">
                                                <div class="">
                                                    <button type="button" class="btn uni_text btn-danger"
                                                            id="khatian_back_button"><i
                                                                class='fa fa-arrow-circle-left'></i> Back to Tenant
                                                    </button>
                                                    <button type="submit" class="btn uni_text btn-primary"><i
                                                                class='fa fa-check'></i> Add Khatian Basic Data
                                                    </button>
                                                    <button type="button" class="btn uni_text btn-success"
                                                            id="add_khatian_basic_next"><i
                                                                class='fa fa-arrow-circle-right'></i> Proceed To Preview
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center mt-3" id="save_success_div2"
                                                 style="display: none;">
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <strong class="text-left"
                                                            style="color:blue !important; font-weight: bold: !important;"
                                                            id="form_success2">
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 px-0">
                                <div class="panel-heading px-0">
                                    <div class="panel-title text-primary px-0">List of Khatian Basic Data</div>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" style="overflow:auto;">
                                <thead style="white-space:nowrap; width:100%;">
                                <tr class="text-bold table-success ">
                                    <th align='center' style="background-color: #136a6f; color: #fff">#</th>
                                    <th style="background-color: #136a6f; color: #fff">Khatian No</th>
                                    <th style="background-color: #136a6f; color: #fff">Dag No.</th>
                                    <th style="background-color: #136a6f; color: #fff">Length of Possession (Years)</th>
                                    <th style="background-color: #136a6f; color: #fff">Paid Cash</th>
                                    <th style="background-color: #136a6f; color: #fff">Payable Cash</th>
                                    <th style="background-color: #136a6f; color: #fff">Special Conditions</th>
                                    <th style="background-color: #136a6f; color: #fff">Tenant Status</th>
                                    <th style="background-color: #136a6f; color: #fff">Remarks</th>
                                    <th style="background-color: #136a6f; color: #fff">Action</th>
                                </tr>
                                </thead>
                                <tbody id="khatian_basic_table_show">
                                <?php foreach ($khatians as $key => $k): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $k->khatian_no ?></td>
                                        <td><?= $k->dag_no ?></td>
                                        <td><?= $k->length_posession ?></td>
                                        <td><?= $k->paid_cash_kind ?></td>
                                        <td><?= $k->payable_cash_kind ?></td>
                                        <td><?= $k->special_conditions ?></td>
                                        <td><?= $k->tenant_status ?></td>
                                        <td><?= $k->remarks ?></td>
                                        <td><span data-id="<?= $k->id ?>" class="text-center delete_khatian">
                                        <button class="btn btn-danger" type="button"><i
                                                    class="fa fa-trash"></i></button></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="preview">
                            <div class="panel-body p-0" style="border-radius: 5px">
                                <form class="form-horizontal" method='post' id="khatian_final_submit"
                                      autocomplete="off">
                                    <input type="hidden" value="<?= $khatian_no ?>"
                                           name="khatian_no" readonly>
                                    <input type="hidden" value="<?= $vill_code ?>" id="vill_code"
                                           name="vill_code">
                                    <input type="hidden" value="<?= $app_id ?>" id="app_id"
                                           name="app_id">
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
                                                    <th style="background-color: #136a6f; color: #fff" colspan="6">
                                                        Khatian
                                                        Basic Details
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Khatian No.:</th>
                                                    <th><b> <?= $khatian_no ?> </b></th>
                                                </tr>
                                                </thead>
                                                <tbody id="khatian_preview_table">
                                                </tbody>
                                            </table>

                                            <table class="table table-striped table-bordered text-bold">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color:rgb(39, 171, 21); color: #fff" colspan="6">Uploaded Khatians</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="khatian_updated_data">   
                                                </tbody>
                                            </table>

                                            <table class="table table-striped table-bordered text-bold">
                                                <thead>
                                                <th style="background-color: #136a6f; color: #fff" colspan="6">Tenant
                                                    Details
                                                </th>
                                                </thead>
                                                <tbody id="tenant_preview_table">
                                                </tbody>
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
                                                    <td>LM Report:</td>
                                                    <td colspan="5">
                                                <textarea class="form-control"
                                                          placeholder='LM Report' rows=3
                                                          name="lm_note" required></textarea>
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
                                                <button type="button" class="btn uni_text btn-danger"
                                                        id="preview_back_button"><i
                                                            class='fa fa-arrow-circle-left'></i> Back to Khatian
                                                    Basic
                                                </button>
                                                <button type="submit" class="btn uni_text btn-primary"><i
                                                            class='fa fa-check'></i> Final Submit
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
                    </div>
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>
    </div>
</div>

<script> let BARAK_VALLEY = <?php echo BARAK_VALLEY ?> </script>
<script src="<?php echo base_url(); ?>application/views/js/khatian.js"></script>