<style>
    .modal {
        text-align: center;
    }

    .modal-dialog {
        max-height: 500px;
        overflow-y: auto;
    }
</style>

<!-- Modal for Zonal Details ReUpdate by CO -->
<div class="modal" role="dialog" id="dag_details_edit_modal_lm" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white text-bold text-center bg-orange">

                <h6 class="modal-title w-100">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                    Edit Dagwise Zonal Information <br>
                    <hr>
                    ( Mouza :
                    <strong style="color: #0F2027;" id="mouza_name_header_lm"></strong>,
                    Lot :
                    <strong style="color: #0F2027;" id="lot_name_header_lm"></strong>,
                    Village :
                    <strong style="color: #0F2027;" id="village_name_header_lm"></strong>,
                    Dag-No :
                    <strong style="color: #0F2027;" id="zv_update_dag_no_header"></strong>,
                    Land-Type :
                    <strong style="color: #0F2027;" id="chitha_class_name_header_lm"></strong>)

                </h6>
            </div>



            <form id="dag_details_edit_form_lm">
                <div class="modal-body">
                    <input type='hidden' name="dag_no_lm_reupdate" id='dag_no_lm_reupdate'>
                    <input type='hidden' name="vill_code_lm_reupdate" id='vill_code_lm_reupdate'>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Zone : <strong class="text-primary" id="zone_name_header_lm"></strong></label>
                        <select class="form-control" id="zone_name_reupdate_lm" name="zone_name_reupdate_lm">
                            <option selected disabled>----------------------Select New Land Zone----------------------</option>
                            <?php foreach ($getZone as $zone) : ?>
                                <option value="<?php echo  $zone['zone_code'] ?>"><?php echo  $zone['zone_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Land Class : <strong class="text-primary" id="subclass_name_header_lm"></strong></label>
                        <select class="form-control" id="lclass_name_reupdate_lm" name="lclass_name_reupdate_lm">
                            <option selected disabled>----------------------Select New Land Class --------------------</option>
                            <?php foreach ($getSubclass as $subclass) : ?>
                                <option value="<?php echo  $subclass['subclass_code'] ?>"><?php echo  $subclass['subclass_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="dag_edit_lm_reset_modal()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="reupdateDagDetailsLM()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Zonal Details ReUpdate by LM  End-->