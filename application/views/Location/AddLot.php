<style>
    .panel .panel-heading .nav-tabs {
        margin-bottom: -11px;
    }

    select {
        font-size: 25px;
    }
</style>

<div class="bg-white">
    <div id="exTab2" class="container py-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <ul class="nav nav-tabs">
                        <?php if($this->session->userdata('user_desig_code')=='ADC' || $this->session->userdata('user_desig_code')=='DC'): ?>
                        <li><a href="<?= base_url();?>index.php/AddLocationController/viewSubdivisionForm" style="text-decoration:none;">Add Sub Division</a>
                        </li>
                        <li><a href="<?= base_url();?>index.php/AddLocationController/viewCircleForm" style="text-decoration:none;">Add Circle</a>
                        </li>
                        <?php elseif ($this->session->userdata('user_desig_code')=='CO'): ?>
                        <li><a href="<?= base_url();?>index.php/AddLocationController/viewMouzaForm" style="text-decoration:none;">Add Mouza</a>
                        </li>
                        <li class="active"><a href="#6" data-toggle="tab" style="text-decoration:none;">Add Lot</a>
                        </li>
                        <li><a href="<?= base_url();?>index.php/AddLocationController/viewVillageForm" style="text-decoration:none;">Add Village</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content ">
                    <div class="tab-pane active" id="6">
                        <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif">
                        </div>
                        <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

                        <div class="form-row">
                            <div class="col-lg-12 ">
                                <div class="panel panel-primary shadow-lg">
                                    <div class="panel-heading bg-secondary text-white">
                                        <h3 class="panel-title text-center font-weight-bold">ADD LOT</h3>
                                    </div>
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center"><?php echo $this->lang->line('select_location') ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-horizontal">
                                            <div class="col-md-4 mb-3">
                                                <label><?php echo $this->lang->line('district') ?>
                                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                                </label>
                                                <select class="form-control form-control-lg" id="district_code"
                                                        name="dist_code"
                                                        required readonly="">
                                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                                    <option value="<?php echo $dist_code; ?>" selected>
                                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>  <?php echo $this->lang->line('subdivision') ?>
                                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                                </label>
                                                <select class="form-control form-control-lg" id="subdiv_code"
                                                        name="subdiv_code"
                                                        required readonly="">
                                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                                    <option value="<?php echo $subdiv_code; ?>" selected>
                                                        <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>
                                                    <?php echo $this->lang->line('circle') ?>
                                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                                </label>
                                                <select class="form-control form-control-lg" id="circle_code"
                                                        name="circle_code"
                                                        required readonly="">
                                                    <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                                    <option value="<?php echo $cir_code; ?>" selected>
                                                        <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code,$cir_code); ?>
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label>
                                                    <?php echo $this->lang->line('mouza') ?>
                                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                                </label>
                                                <select class="form-control form-control-lg" id="mouza_code"
                                                        name="mouza_code"
                                                        required>
                                                    <option disabled selected>--Select Mouza--</option>
                                                    <?php $mouza_list = $this->utilityclass->getAllMouzaDetails($dist_code,$subdiv_code,$cir_code); ?>
                                                    <?php foreach ($mouza_list as $mouza):?>
                                                        <option value="<?php echo $mouza->mouza_pargona_code; ?>">
                                                            <?php echo $mouza->loc_name?>
                                                        </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="col-lg-12" id="location_form_error_div"
                                                 style="display: none;">
                                                <div class="alert alert-warning alert-dismissible" role="alert">
                                                    <strong class="text-left"
                                                            style="color:red !important; font-weight: bold: !important;"
                                                            id="location_errors">
                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 py-3 text-center">
                                                <button type="button" onclick="validate_lot_data()"
                                                        class="btn uni_text btn-primary">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                    VALIDATE LOCATION
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--************ MAIN FORM DIV **********-->
                        <div class="form-row hide" id="add_data_div">
                            <div class="col-lg-12 ">
                                <div class="panel panel-primary shadow-lg">
                                    <div class="panel-heading bg-success text-white">
                                        <h3 class="panel-title text-center">LOT DETAILS</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Lot Assamese Name
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <input class="form-control form-control-lg"
                                                   id="lot_as_name"
                                                   placeholder="Lot Assamese Name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Lot English Name
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <input class="form-control form-control-lg"
                                                   id="lot_eng_name"
                                                   placeholder="Lot English Name">
                                        </div>
                                        <div class="col-lg-12" id="save_form_error_div"
                                             style="display: none;">
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                <strong class="text-left"
                                                        style="color:red !important; font-weight: bold: !important;"
                                                        id="form_errors">
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center pt-3"
                                             id="add_village_submit_div">
                                            <button onclick="add_lot_form_submit()"
                                                    class="btn uni_text btn-success"><i
                                                    class="fa fa-check" aria-hidden="true"></i> SAVE NEW LOT
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 bg-white rounded">
                                <div class="panel panel-primary shadow-lg p-2">
                                    <table id="data_table" class="dataTable border table table-hover">
                                        <thead>
                                        <tr>
                                            <th>SL NO.</th>
                                            <th>LOT ASSAMESE NAME</th>
                                            <th>LOT ENGLISH NAME</th>
                                            <th>UNIQUE CODE</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ifExist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red bold">LOT NAME ALREADY EXISTED..!</h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 bg-white rounded ">
                    <div class="panel panel-primary shadow-lg">
                        <table id="existTable" class="border table table-hover">
                            <thead>
                            <tr>
                                <th>SL NO.</th>
                                <th>LOT ASSAMESE NAME</th>
                                <th>LOT ENGLISH NAME</th>
                                <th>UNIQUE CODE</th>
                            </tr>
                            </thead>
                            <tbody id="exist_table_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="modal_close()" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button type="button" onclick="comfirm_add_lot_form_submit()" class="btn btn-primary">
                    <i class="fa fa-check" aria-hidden="true"></i> SAVE ANYWAY
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="EditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold">EDIT LOT DETAILS</h5>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">

                    <input class="form-control" type="hidden" id="e_uuid"/>
                    <input class="form-control" type="hidden" id="e_district_code"/>
                    <input class="form-control" type="hidden" id="e_subdiv_code"/>
                    <input class="form-control" type="hidden" id="e_circle_code"/>
                    <input class="form-control" type="hidden" id="e_mouza_code"/>
                    <input class="form-control" type="hidden" id="e_lot_code"/>
                    <input class="form-control" type="hidden" id="e_vill_townprt_code"/>

                    <div class="col-md-4 mb-3">
                        <label>
                            Lot Assamese Name
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input class="form-control form-control-lg" id="e_lot_as_name"
                               placeholder="Lot Assamese Name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            Lot English Name
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input class="form-control form-control-lg" id="e_lot_eng_name"
                               placeholder="Lot English Name">
                    </div>
                    <div class="col-lg-12" id="edit_form_error_div" style="display: none;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-left" style="color:red !important; font-weight: bold: !important;"
                                    id="edit_form_errors">
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="edit_modal_close()" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i> CLOSE
                </button>
                <button type="button" onclick="edit_lot_form_submit()" class="btn btn-primary">
                    <i class="fa fa-check" aria-hidden="true"></i> UPDATE
                </button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>application/views/js/add_location.js"></script>

