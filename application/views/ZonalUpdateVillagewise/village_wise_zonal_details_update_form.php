<!-- land bank details update modal  -->
<div class="modal" id="zonal_value_update_details_modal" role="dialog">
    <form method="post" id="zonal_value_update_details_form">
        <input type="hidden" value="<?= $dist_code ?>" name="dist_code">
        <input type="hidden" value="<?= $subdiv_code ?>" name="subdiv_code">
        <input type="hidden" value="<?= $cir_code ?>" name="circle_code">
        <input type="hidden" value="<?= $mouza_pargona_code ?>" name="mouza_code">
        <input type="hidden" value="<?= $lot_no ?>" name="lot_no">
        <input type="hidden" value="<?= $select ?>" name="vill_code">
        <input type="hidden" value="<?php echo $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select); ?>" name="unique_village_code">
        <input type="hidden" value="" id="zone_details_update_form_zone_code" name="zone_details_update_form_zone_code">
        <input type="hidden" value="" id="no_of_subclass_update_form" name="no_of_subclass_update_form">
        <div class="modal-dialog" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-warning">
                    <h5 class="modal-title w-100">

                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <div class="modal-header text-center mb-3 p-0">
                            <h6 class="modal-title w-100 text-danger mb-1">
                                <u><strong>NOTE:</strong> Fileds marks with (*) are mandatory</u>
                            </h6>
                        </div>
                    </div>

                    <div class="form-group mb-5 col-lg-12 col-sm-12 col-md-12">
                        <div class="text-center bg-secondary text-white p-1">
                            <h5 class="mb-0">Zonal Value Reupdate</h5>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-striped table-bordered" id="indivisual_update_details_table">
                                <thead>
                                    <tr>
                                        <td width="50%">Subclass Name</td>
                                        <td width="40%">Zonal Value</td>
                                    </tr>
                                </thead>
                                <tbody id="TextBoxContainerUpdateForm">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-success" onclick="zonal_value_update_form_submit()">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Update
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="zonal_value_update_details_modal_close()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>