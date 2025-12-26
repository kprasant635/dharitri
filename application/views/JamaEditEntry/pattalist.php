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
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location'); ?></h3>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>PATTA TYPE CODE</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="patta_type_code" required>
                                    <option selected disabled>Patta Type</option>
                                    <?php foreach ($patta_types as $pt): ?>
                                        <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>PATTA NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="patta_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>OLD PATTA NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"   name="old_patta_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div style="text-align: center">
                            <input type="submit" name="next" value="next" class="btn btn-danger"/>
                            <input type="submit" name="submit" value="submit" class="btn btn-danger"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>