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
        <div class="col-lg-10 ">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">ALONG WITH EDIT</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post">
                        
                         <input type="hidden" class="form-control" value="<?php echo $all->alongwith_id ?>"  required   name="alongwith_id" id="applicantNam" required
                                       placeholder="">
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD NO</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $all->ord_no ?>" class="form-control"  required   name="ord_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar" value="<?php echo $all->ord_date ?>" required   name="ord_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD CRON NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $all->ord_cron_no ?>"  required   name="ord_cron_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                             <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ALONGWITH NAME</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required value="<?php echo $all->alongwith_name ?>"   name="alongwith_name" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                           
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ALONGWITH GUARDIAN</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required value="<?php echo $all->alongwith_guardian ?>"  name="alongwith_guardian" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ALONGWITH REL GUR</label>
                            <div class="col-sm-4">
                                <select name="alongwith_rel_gur" class="form-control" required>
                                    <?php foreach ($relation as $r): ?>
                                        <?php if($all->alongwith_rel_gur == $r->guard_rel):?>
                                            <option selected value="<?php echo $r->guard_rel; ?>" ><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php else:?>
                                            <option selected value="<?php echo $r->guard_rel; ?>" ><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                         <div style="text-align: center">
                                <input type="submit" name="submit" value="Submit"  class="btn btn-danger"/>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>