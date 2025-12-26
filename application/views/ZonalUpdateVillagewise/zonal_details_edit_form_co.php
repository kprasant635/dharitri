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
<div class="modal" id="zonal_details_edit_modal_co" role="dialog">
    <form method="post" id="zonal_details_edit_form_co">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-success">
                    <h5 class="modal-title w-100">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        UPDATE VILLAGE WISE ZONAL DETAILS <br>
                        ( Mouza :
                        <strong style="color: #0F2027;" id="mouza_name_header_co"></strong>,
                        Lot :
                        <strong style="color: #0F2027;" id="lot_name_header_co"></strong>,
                        Village :
                        <strong style="color: #0F2027;" id="village_name_header_co" name="village_name_header_co"></strong> )
                        <input type="hidden" value="" id="zd_edit_form_vill_code_co" name="zd_edit_form_vill_code_co">
                        <input type="hidden" value="" id="no_of_rows_update_form" name="no_of_rows_update_form">

                    </h5>
                </div>
                <span class="text-danger p-3"> <b>*** N.B:</b> Please Make sure that all Land Rates are Filled , If Land Rates remain blank for any Zone and Subclass Combination </br>then zonal value of the Dags residing in that particular Zone and Subclass will not show up <b>***</b></span>
                <div class="modal-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-bordered " class="fl-table" id="zonal_details_edit_table">
                            <thead>
                                <tr>
                                    <td class="text-center" width="20%"><strong>Zone Name</strong></td>
                                    <td class="text-center" width="30%"><strong>Subclass Name</strong></td>
                                    <td class="text-center" width="20%"><strong>Zonal Value (Land Rate)</strong></td>
                                </tr>
                            </thead>
                            <tbody id="TextBoxContainerEditFormCo"></tbody>
                        </table>

                    </div>
                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" id="btn_update_zonal_details_co" class="btn btn-primary" onclick="zonal_details_update_form_co_submit()">
                            <!-- <i class="fa-fa-close"></i> -->
                            Update
                        </button>
                        <button type="button" class="btn btn-danger" onclick="zonal_details_edit_modal_co_close()">
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