<div id="addOccModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close-enc-modal px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5>Add Occupiers in DAG <strong><span id="dag_label_add_occ"></span></strong></h5>
                </div>
            </div>
            <input type="hidden" id="add_riotee_id">
            <input type="hidden" id="dist_code" name="dist_code" value="<?=$basic["dist_code"];?>">
            <input type="hidden" id="subdiv_code" name="subdiv_code" value="<?=$basic["subdiv_code"];?>">
            <input type="hidden" id="circle_code" name="circle_code" value="<?=$basic["cir_code"];?>">
            <input type="hidden" id="mouza_code" name="mouza_code" value="<?=$basic["mouza_pargona_code"];?>">
            <input type="hidden" id="lot_no" name="lot_no" value="<?=$basic["lot_no"];?>">
            <input type="hidden" id="vill_code" name="vill_code" value="<?=$basic["vill_townprt_code"];?>">
            <input type="hidden" id="v_uuid" name="v_uuid" value="<?=$basic["uuid"];?>">
            <input type="hidden" name="v_dag_no" id="v_dag_no" class="form-control">
            <?php foreach ($applicants_buyers as $settlement):
                if($settlement->is_applicant == 1):
                    $add_enc_count = 1;
                    // echo "<pre>";
                    // var_dump($settlement);
                ?>

            <div class="alternate_div">
                <hr>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="lb_lm_update_form_en_name[]" id="lb_lm_update_form_en_name" class="form-control" value="<?=$settlement->pdar_name?>">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Father Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="lb_lm_update_form_en_father_name[]" id="lb_lm_update_form_en_father_name" class="form-control" value="<?=$settlement->pdar_guardian?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Gender</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_gender[]" id="lb_lm_update_form_en_gender" class="form-control">
                            <option value="">Select...</option>
                            <option value="1" <?php if($settlement->pdar_gender == '1'){echo 'selected';}?>>Male</option>
                            <option value="2" <?php if($settlement->pdar_gender == '2'){echo 'selected';}?>>Female</option>
                            <option value="3" <?php if($settlement->pdar_gender == '3'){echo 'selected';}?>>Others</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment From</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" name="lb_lm_update_form_en_from_date[]" id="lb_lm_update_form_en_from_date" class="form-control ymd" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment To</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" name="lb_lm_update_form_en_to_date[]" id="lb_lm_update_form_en_to_date" class="form-control ymd" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless Indigenous</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_landless_indigenuous[]" id="lb_lm_update_form_en_landless_indigenuous" class="form-control">
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
                        <select name="lb_lm_update_form_en_landless[]" id="lb_lm_update_form_en_landless" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Caste</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="lb_lm_update_form_en_caste[]" id="lb_lm_update_form_en_caste">
                            <option value="">Select...</option>
                            <?php
                                foreach(json_decode(CASTE) as $add_cast_cat):
                            ?>
                                <option value="<?=$add_cast_cat->CODE?>" <?php if($settlement->caste == $add_cast_cat->CODE){echo "selected";}?>><?=$add_cast_cat->NAME?></option>
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
                        <select name="lb_lm_update_form_en_erosion[]" id="lb_lm_update_form_en_erosion" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landslide prone area?</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_landslide[]" id="lb_lm_update_form_en_landslide" class="form-control">
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

                        <select class="form-control" name="lb_lm_update_form_type_of_land_use[]" id="lb_lm_update_form_type_of_land_use">
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
                        <select class="form-control" name="lb_lm_update_form_type_of_encroacher[]" id="lb_lm_update_form_type_of_encroacher">
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
                    <button type="button" onclick="addEncSubmit()" class="col-md-3 btn btn-primary">Submit</button>
                </div>
            </div>

            <?php endif; endforeach;?>
        </div>
        </p>
    </div>

</div>