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
                    <h3 class="panel-title">Update Land Area Records of Chitha/JamaBandi</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?php echo base_url() . "index.php/LegacyDataUpdation/FinalupdateLandArea" ?>">
                        <div class="form-group" style="width: 100%;">
							<label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Dag No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  readonly=""  value="<?php echo $dag->dag_no; ?>" name="dag_no">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->mouza_pargona_code; ?>" name="mouza">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->lot_no; ?>" name="lot">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->vill_townprt_code; ?>" name="vill">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->patta_no; ?>" name="patta_no">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->patta_type_code; ?>" name="patta_type_code">
                                <input type="hidden" class="form-control"  readonly=""  value="<?php echo $dag->case_no; ?>" name="case_no">
                            </div> 
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Bigha</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"    value="<?php echo $dag->dag_area_b; ?>" name="dag_area_b" id="applicantNam" 
                                       placeholder="">
                            </div>
                        
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required"  id='applicant_name_label'>Katha</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" required   value="<?php echo $dag->dag_area_k; ?>" name="dag_area_k" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Lessa</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  required  value="<?php echo $dag->dag_area_lc; ?>" name="dag_area_lc" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group" style="width: 100%;text-align: center;">
                            <input class="btn btn-danger btn-sm" type="submit" value="Update Records"/>
                        </div>
                    </form>
					<hr>
					<a href='<?php echo base_url();?>index.php/home' class='btn btn-success btn-sm' >Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>