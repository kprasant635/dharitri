<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Land Area Records of Chitha/JamaBandi land class edit</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?php echo base_url() . "index.php/LegacyDataUpdation/FinalupdateLandClass" ?>">
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Old Land Class</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control"  readonly=""  value="<?php echo $old_land_classes; ?>" name="">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->present_land_class; ?>" name="present_land_class">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->patta_type_code; ?>" name="patta_type_code">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->dag_no; ?>" name="dag_no">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->mouza_pargona_code; ?>" name="mouza">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->lot_no; ?>" name="lot">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->vill_townprt_code; ?>" name="vill">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->patta_no; ?>" name="patta_no">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->case_no; ?>" name="case_no">
                            </div> 
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>New Land Class</label>
                            <div class="col-sm-3">
                                <select class="form-control" name='new_land_class' required>
                                    <?php
                                    foreach ($classes as $landclass) {
                                        echo"<option value='$landclass->class_code'>$landclass->land_type</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>

                        <hr>
                        <div class="form-group" style="width: 100%;text-align: center;">
                            <input class="btn btn-danger btn-sm" type="submit" value="Update Records"/>
                        </div>
                    </form>
                    <hr>
                    <a href='<?php echo base_url(); ?>index.php/home' class='btn btn-success btn-sm' >Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>