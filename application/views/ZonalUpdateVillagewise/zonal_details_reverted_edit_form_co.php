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
<!-- Modal for Villagewise Zonal Details Edit Revreted by ADC to CO -->
<div class="modal" id="zonal_details_edit_modal_co_reverted" role="dialog">
    <form method="post" id="zonal_details_edit_form_co_reverted">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-warning">
                    <h5 class="modal-title w-100">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        REVERTED VILLAGE WISE ZONAL DETAILS BY ADC <br>
                        ( Mouza :
                        <strong style="color: #0F2027;" id="mouza_name_header_co_reverted"></strong>,
                        Lot :
                        <strong style="color: #0F2027;" id="lot_name_header_co_reverted"></strong>,
                        Village :
                        <strong style="color: #0F2027;" id="village_name_header_co_reverted" name="village_name_header_co_reverted"></strong> )
                        <input type="hidden" value="" id="zd_edit_form_vill_code_co_reverted" name="zd_edit_form_vill_code_co_reverted">
                        <input type="hidden" value="" id="no_of_rows_update_form_reverted" name="no_of_rows_update_form_reverted">

                    </h5>
                </div>

                <div class="modal-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-bordered " class="fl-table" id="zonal_details_edit_table_reverted">
                            <thead>
                                <tr>
                                    <td class="text-center" width="20%"><strong>Zone Name</strong></td>
                                    <td class="text-center" width="30%"><strong>Subclass Name</strong></td>
                                    <td class="text-center" width="20%"><strong>Zonal Value (By LM)</strong></td>
                                    <td class="text-center" width="20%"><strong>Zonal Value (By CO)</strong></td>
                                </tr>
                            </thead>
                            <tbody id="TextBoxContainerEditFormCoReverted"></tbody>
                        </table>

                    </div>
                    <div class="row" id="searchData">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center">
                            <!-- <hr> -->
                            <div class="col-lg-12 col-md-12" id="zonalValueDetailsDivReverted">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" id="btn_update_zonal_details_co_reverted" class="btn btn-primary" onclick="zonal_details_update_form_co_reverted_submit()">
                            <!-- <i class="fa-fa-close"></i> -->
                            Update & Sent to ADC
                        </button>
                        <button type="button" class="btn btn-danger" onclick="zonal_details_edit_modal_co_reverted_close()">
                            <i class="fa-fa-close"></i>
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal for Villagewise Zonal Details Reverted by ADC to  CO  End-->