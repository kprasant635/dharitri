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
                        <li><a href="<?= base_url();?>index.php/AddLocationController/viewLotForm" style="text-decoration:none;">Add Lot</a>
                        </li>
                        <li class="active"><a href="#6" data-toggle="tab" style="text-decoration:none;">Add Village</a>
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
                                        <h3 class="panel-title text-center font-weight-bold">ADD VILLAGE</h3>
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

                                            <div class="col-md-4 mb-3">
                                                <label>
                                                    <?php echo $this->lang->line('lot_no') ?>
                                                    <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                                </label>
                                                <select class="form-control form-control-lg" id="lot_code" name="lot_no"
                                                        required>
                                                    <option disabled selected>--Select Lot Number--</option>
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
                                                <button type="button" onclick="validate_data()"
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
                                        <h3 class="panel-title text-center">VILLAGE DETAILS</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Village Assamese Name
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <input class="form-control form-control-lg" name="vill_as_name"
                                                   id="vill_as_name"
                                                   placeholder="Village Assamese Name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Village English Name
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <input class="form-control form-control-lg" name="vill_eng_name"
                                                   id="vill_eng_name"
                                                   placeholder="Village English Name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Rural / Urban
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="rural_urban"
                                                    name="rural_urban" required>
                                                <option disabled selected>--Select Rural/Urban--
                                                </option>
                                                <option value="R">Rural</option>
                                                <option value="U">Urban</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Village Type
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="village_status"
                                                    name="village_status" required>
                                                <option disabled selected>--Select Village Type--
                                                </option>
                                                <option value="<?= NC_VILLAGE ?>"><?= NC_VILLAGE_TEXT ?></option>
                                                <option value="<?= REVENUE_VILLAGE ?>"><?= REVENUE_VILLAGE_TEXT ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Municipal Corporation
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="is_mc" name="is_mc"
                                                    required>
                                                <option disabled selected>--Select Municipal Corporation--</option>
                                                <option value="<?= MUNICIPALITY_BOARD ?>"><?= MUNICIPALITY_BOARD_TEXT ?></option>
                                                <option value="<?= TOWN_COMMITTEE ?>"><?= TOWN_COMMITTEE_TEXT ?></option>
                                                <option value="<?= MUNICIPALITY_CORPORATION ?>"><?= MUNICIPALITY_CORPORATION_TEXT ?></option>
                                                <option value="<?= MUNICIPALITY ?>"><?= MUNICIPALITY_TEXT ?></option>
                                                <option value="<?= NA ?>"><?= NA_TEXT ?></option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>
                                                Is Map Updated
                                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="is_map" name="is_map"
                                                    required>
                                                <option disabled selected>--Select Is Map Updated--
                                                </option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                            <span class="red text-sm">(If map updated then map partition will be compulsory for new partition.)</span>
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
                                            <button onclick="add_village_form_submit()"
                                                    class="btn uni_text btn-success"><i
                                                        class="fa fa-check" aria-hidden="true"></i> SAVE NEW VILLAGE
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
                                    <table id="villagesTable" class="dataTable border table table-hover">
                                        <thead>
                                        <tr>
                                            <th>SL NO.</th>
                                            <th>VILLAGE ASSAMESE NAME</th>
                                            <th>VILLAGE ENGLISH NAME</th>
                                            <th>VILLAGE UNIQUE CODE</th>
                                            <th>RURAL/URBAN</th>
                                            <th>ACTION</th>
                                            <th></th>
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

<div class="modal" id="ifExist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red bold">VILLAGE NAME ALREADY EXISTED..!</h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 bg-white rounded ">
                    <div class="panel panel-primary shadow-lg">
                        <table id="villagesTable" class="border table table-hover">
                            <thead>
                            <tr>
                                <th>SL NO.</th>
                                <th>VILLAGE ASSAMESE NAME</th>
                                <th>VILLAGE ENGLISH NAME</th>
                                <th>VILLAGE UNIQUE CODE</th>
                            </tr>
                            </thead>
                            <tbody id="vill_table_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="modal_close()" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button type="button" onclick="comfirm_add_village_form_submit()" class="btn btn-primary">
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
                <h5 class="modal-title bold">EDIT VILLAGE</h5>
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
                            Village Assamese Name
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input class="form-control form-control-lg" id="e_vill_as_name"
                               placeholder="Village Assamese Name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            Village English Name
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input class="form-control form-control-lg" id="e_vill_eng_name"
                               placeholder="Village English Name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            Rural / Urban
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="e_rural_urban" required>
                            <option disabled selected>--Select Rural/Urban--
                            </option>
                            <option value="R">Rural</option>
                            <option value="U">Urban</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>
                            Village Type
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="e_village_status" required>
                            <option disabled selected>--Select Village Type--
                            </option>
                            <option value="<?= NC_VILLAGE ?>"><?= NC_VILLAGE_TEXT ?></option>
                            <option value="<?= REVENUE_VILLAGE ?>"><?= REVENUE_VILLAGE_TEXT ?></option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            Municipal Corporation
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="e_is_mc"
                                required>
                            <option disabled selected>--Select Municipal Corporation--</option>
                            <option value="<?= MUNICIPALITY_BOARD ?>"><?= MUNICIPALITY_BOARD_TEXT ?></option>
                            <option value="<?= TOWN_COMMITTEE ?>"><?= TOWN_COMMITTEE_TEXT ?></option>
                            <option value="<?= MUNICIPALITY_CORPORATION ?>"><?= MUNICIPALITY_CORPORATION_TEXT ?></option>
                            <option value="<?= MUNICIPALITY ?>"><?= MUNICIPALITY_TEXT ?></option>
                            <option value="<?= NA ?>"><?= NA_TEXT ?></option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>
                            Is Map Updated
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="e_is_map"
                                required>
                            <option disabled selected>--Select Is Map Updated--
                            </option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                        <span class="red text-sm">(If map updated then map partition will be compulsory for new partition.)</span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            Select Village Status
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="nc_btad" required>
                            <option>None</option>
                            <?php foreach (json_decode(NC_BTAD_OPTIONS) as $option) :  ?>
                                <option value="<?php echo ($option->CODE) ?>"><?php echo ($option->NAME) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            IS PERIPHARY
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="is_periphary" required>
                            <option disabled selected>--Select--</option>
                            <option value="yes">Yes</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>
                            IS TRIBAL
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select class="form-control form-control-lg" id="is_tribal" required>
                            <option disabled selected>--Select--
                            </option>
                            <option value="yes">Yes</option>
                            <option value="no">NO</option>
                        </select>
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
                <button type="button" onclick="edit_village_form_submit()" class="btn btn-primary">
                    <i class="fa fa-check" aria-hidden="true"></i> UPDATE
                </button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>application/views/js/add_location.js?v=1.1"></script>

