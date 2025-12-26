<!--<?php // KKB0008: Improvement of Land Share Details 
    ?> -->
<!-- land share pattadar details add modal  -->
<div class="modal" id="land_share_add_details_modal" role="dialog">
    <form method="post" id="land_share_add_details_form">
        <input type="hidden" value="<?= $dist_code ?>" name="dist_code">
        <input type="hidden" value="<?= $subdiv_code ?>" name="subdiv_code">
        <input type="hidden" value="<?= $circle_code ?>" name="circle_code">
        <input type="hidden" value="<?= $mouza_code ?>" name="mouza_code">
        <input type="hidden" value="<?= $lot_no ?>" name="lot_no">
        <input type="hidden" value="<?= $vill_code ?>" name="vill_code">
        <input type="hidden" value="" id="land_share_add_form_dag_no" name="land_share_add_form_dag_no">
        <input type="hidden" value="" id="land_share_add_form_patta_no" name="land_share_add_form_patta_no">
        <input type="hidden" value="" id="land_share_add_form_dag_area_b" name="land_share_add_form_dag_area_b">
        <input type="hidden" value="" id="land_share_add_form_dag_area_k" name="land_share_add_form_dag_area_k">
        <input type="hidden" value="" id="land_share_add_form_dag_area_lc" name="land_share_add_form_dag_area_lc">
        <input type="hidden" value="" id="no_of_indivisuals_add_form" name="no_of_indivisuals_add_form">
        <div class="modal-dialog" style="max-width:95%">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-success">
                    <h5 class="modal-title w-100">
                        <?php echo $this->lang->line('land_share_header') ?>
                        <?php echo $this->lang->line('land_share_add_details_modal_header'); ?><br>
                        <?php echo $this->lang->line('mouza') ?> :
                        <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code); ?>,
                        <?php echo $this->lang->line('lot_no') ?> :
                        <?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no); ?>,
                        <?php echo $this->lang->line('vill_town') ?> :
                        <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code); ?>,
                        <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> Dag No:
                        <span class="text-white" id="lb_add_dag_no_header"></span>
                        <p>[
                            <span>Total Dag Area:</span>
                            <span class="text-white" id="land_share_add_form_dag_area_b_header"></span> Bigha,
                            <span class="text-white" id="land_share_add_form_dag_area_k_header"></span> Katha,
                            <span class="text-white" id="land_share_add_form_dag_area_lc_header"></span> Lessa
                            ]
                        </p>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <div class="modal-header text-center mb-3 p-0">
                            <h6 class="modal-title w-100 text-danger mb-1">
                                <strong>NOTE:</strong> Please Re Verify the Land Area Before Updation </br> (Enter 0 insted of Blank field in Share Area Bigha, Katha and Lecha.)
                            </h6>
                        </div>
                    </div>
                    <div class="form-group mb-5 col-lg-12 col-sm-12 col-md-12">
                        <div class="text-center bg-secondary text-white p-1">
                            <h5 class="mb-0">Land Share Individual Pattadar Details</h5>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-striped table-bordered" id="pattadar_add_details_table">
                                <thead>
                                    <tr>
                                        <td width="15%">Pattadar Name</td>
                                        <td width="15%">Pattadar Name in English</td>
                                        <td width="15%">Father's Name</td>
                                        <td width="15%">Father's Name in English</td>
                                        <td width="10%">Date Of Birth</td>
                                        <td width="8%">Gender</td>
                                        <td width="3%">Area(Bigha)</td>
                                        <td width="10%">Area(Katha)</td>
                                        <td width="10%">Area(Lessa)</td>
                                    </tr>
                                </thead>
                                <tbody id="TextBoxContainerAddForm">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- validation-errors-div -->
                    <div class="col-lg-12" id="lb_validation_error_div_add_form" style="display:none;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-center" style="color:red !important" id="lb_validation_error_msg_add_form">
                            </strong>
                        </div>
                    </div>
                    <!-- validation-error-div-end -->
                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-success" onclick="land_share_add_form_submit()">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Add Details
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="land_share_add_details_modal_close()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>