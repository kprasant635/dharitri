<div id="editOccModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="edit-enc-close px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5>Edit Occupiers in DAG <strong>
                            <span id="edit_dag_label_add_occ"></span>
                        </strong></h5>
                </div>
            </div>
            <input type="hidden" id="edit_enc_application_no">
            <input type="hidden" id="edit_enc_land_bank_details_id">
            <input type="hidden" id="edit_enc_id_land_bank">
            <input type="hidden" id="edit_enc_case_no">
            <input type="hidden" id="edit_enc_uuid">
            <input type="hidden" id="edit_enc_dag_no">
            <input type="hidden" id="edit_riotee_id">
            <?php
            $add_enc_count = 1;
            ?>
            <div class="alternate_div">
                <hr>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="edit_lb_lm_update_form_en_name" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Father Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="edit_lb_lm_update_form_en_father_name" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Gender</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_gender" class="form-control">
                            <option value="">Select...</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment From</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" id="edit_lb_lm_update_form_en_from_date" class="form-control ymd" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment To</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" id="edit_lb_lm_update_form_en_to_date" class="form-control ymd" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless Indigenous</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landless_indigenuous" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landless" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Caste</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_lb_lm_update_form_en_caste">
                            <option value="">Select...</option>
                            <?php
                            foreach(json_decode(CASTE) as $add_cast_cat):
                                ?>
                                <option value="<?=$add_cast_cat->CODE?>"><?=$add_cast_cat->NAME?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Erosion effected?</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_erosion" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landslide prone area?</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landslide" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type Of Land Use</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_lb_lm_update_form_type_of_land_use">
                            <option value="">Select...</option>
                            <?php
                            foreach(json_decode(LB_ENC_TYPE_OF_LAND_USE) as $land_use):
                                ?>
                                <option value="<?=$land_use->CODE?>"><?=$land_use->NAME?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_lb_lm_update_form_type_of_encroacher">
                            <option value="">Select...</option>
                            <?php
                            foreach(json_decode(TYPE_OF_ENCROACHER) as $enc_type):
                                ?>
                                <option value="<?=$enc_type->CODE?>"><?=$enc_type->NAME?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center mt-3">
                    <button type="button" onclick="updateEncDetails()" class="col-md-3 btn btn-primary">Update</button>
                </div>
            </div>
        </div>
        </p>
    </div>
</div>