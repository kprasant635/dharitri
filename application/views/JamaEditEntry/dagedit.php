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
                    <h3 class="panel-title">Update Records of JamaBandi</h3>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Dag No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  readonly=""  value="<?php echo $dag->dag_no; ?>" name="dag_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>NLRG No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    value="<?php echo $dag->dag_nlrg_no; ?>" name="dag_nlrg_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required " id='applicant_name_label'>Land Class</label>
                            <div class="col-sm-4">
                                <select  class="form-control"   required name="dag_class_code">
                                    
                                    <?php foreach ($classes as $land): ?>

                                        <?php if ($land->class_code === $dag->dag_class_code): ?>
                                            <option selected value="<?php echo $land->class_code; ?>">
                                                <?php echo $land->land_type; ?>
                                            </option>
                                        <?php endif; ?>
                                            <option value="<?php echo $land->class_code; ?>">
                                                <?php echo $land->land_type; ?>
                                            </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Bigha</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    value="<?php echo $dag->dag_area_b; ?>" name="dag_area_b" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required"  id='applicant_name_label'>Katha</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" required   value="<?php echo $dag->dag_area_k; ?>" name="dag_area_k" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Lessa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required  value="<?php echo $dag->dag_area_lc; ?>" name="dag_area_lc" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text required control-label " id='applicant_name_label'>Revenue</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   value="<?php echo $dag->dag_revenue; ?>" name="dag_revenue" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required "  id='applicant_name_label'>Local Tax</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required  value="<?php echo $dag->dag_localtax; ?>" name="dag_localtax" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;text-align: center;">
                            <input class="btn btn-danger btn-sm" type="submit" value="Update Records"/>
                        </div>
                    </form>
					<hr>
					<a href='<?php echo base_url();?>index.php/JamaEditEntry/displaybasic/<?php echo $this->session->userdata('patta_no');?>/<?php echo $this->session->userdata('patta_type_code');?>' class='btn btn-success btn-sm' >Back to JamaBandi Home</a>
                </div>
            </div>
        </div>
    </div>
</div>