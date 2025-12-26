<style>
    .modal {
        text-align: center;
    }

    .modal-dialog {
        max-height: 500px;
        overflow-y: auto;
    }

    /* .modal-content {
        width: 80%;
    } */
</style>
<!-- Modal for Villagewise Zonal Details Edit by CO -->
<div class="modal" id="zonal_details_missing_modal_co" role="dialog">
    <form method="post" id="zonal_details_missing_form_co">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-yellow">
                    <h5 class="modal-title w-100">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        Add Missing Zonal Combination <br>
                        ( Mouza :
                        <strong style="color: #0F2027;" id="mouza_name_header_co_1"></strong>,
                        Lot :
                        <strong style="color: #0F2027;" id="lot_name_header_co_1"></strong>,
                        Village :
                        <strong style="color: #0F2027;" id="village_name_header_co_1"></strong> )

                        <input type="hidden" value="" id="zd_missing_form_dist_code_co" name="zd_missing_form_dist_code_co">
                        <input type="hidden" value="" id="zd_missing_form_subdiv_code_co" name="zd_missing_form_subdiv_code_co">
                        <input type="hidden" value="" id="zd_missing_form_cir_code_co" name="zd_missing_form_cir_code_co">

                        <input type="hidden" value="" id="zd_missing_form_mouza_code_co" name="zd_missing_form_mouza_code_co">
                        <input type="hidden" value="" id="zd_missing_form_lot_no_co" name="zd_missing_form_lot_no_co">
                        <input type="hidden" value="" id="zd_missing_form_vill_code_co" name="zd_missing_form_vill_code_co">
                        <input type="hidden" value="" id="zd_missing_form_vill_townprt_co" name="zd_missing_form_vill_townprt_co">
                        <input type="hidden" value="" id="no_of_rows_missing_form" name="no_of_rows_missing_form">

                    </h5>
                </div>
                <div class="modal-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-bordered " class="fl-table" id="zonal_details_missing_table">
                            <thead>
                                <tr>
                                    <td class="text-center" width="20%"><strong>Zone Name</strong></td>
                                    <td class="text-center" width="30%"><strong>Subclass Name</strong></td>
                                    <td class="text-center" width="20%"><strong>Zonal Value (Land Rate)</strong></td>
                                </tr>
                            </thead>
                            <tbody id="TextBoxContainerMissingFormCo"></tbody>
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
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" id="btn_update_zonal_details_co" class="btn btn-primary" onclick="zonal_details_missing_form_co_submit()">
                            <!-- <i class="fa-fa-close"></i> -->
                            Add
                        </button>
                        <button type="button" class="btn btn-danger" onclick="zonal_details_missing_modal_co_close()">
                            <i class="fa-fa-close"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal for Villagewise Zonal Details View by CO  End-->