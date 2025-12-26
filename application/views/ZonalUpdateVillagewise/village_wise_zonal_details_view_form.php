<!-- Modal for Villagewise Zonal Details View by CO -->
<!-- land bank details view modal  -->
<div class="modal" id="zone_details_view_modal" role="dialog">
    <form method="post" id="zone_details_view_form">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-primary">
                    <h5 class="modal-title w-100">
                        <!-- Vill Code: -->
                        <input type="hidden" value="" id="zd_view_form_vill_code" name="zd_view_form_vill_code">
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5 col-lg-12 col-sm-12 col-md-12">
                        <div class="text-center bg-secondary text-white p-1">
                            <h5 class="mb-0">Zonal Value Details</h5>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-striped table-bordered" id="indivisual_view_details_table">
                                <thead>
                                    <tr>
                                        <td width="30%">Zone Name</td>
                                        <td width="30%">Subclass Name</td>
                                        <td width="40%">Zonal Value</td>
                                    </tr>
                                </thead>
                                <tbody id="TextBoxContainerViewForm"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="zone_details_view_modal_close()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for Villagewise Zonal Details View by CO  End-->