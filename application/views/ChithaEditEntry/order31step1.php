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
        <div class="col-lg-12 ">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Select Location</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post">
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>RMK TYPE HIST NO</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $max_no;?>" readonly class="form-control"  required  name="rmk_type_hist_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD NO</label>
                            <div class="col-sm-4">
                                <input type="text" readonly="" class="form-control"    name="ord_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar"  required  name="ord_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD TYPE CODE</label>
                            <div class="col-sm-4">
                                <select name='ord_type_code' class="form-control" required>
                                    <option selected disabled>Select Order Type</option>

                                    <?php foreach ($ord_types as $type): ?>
                                      
                                            <option  value="<?php echo $type->order_type_code; ?>"><?php echo $type->order_type; ?></option>
                    
                                    <?php endforeach; ?>
                                </select>
                            </div>
                           
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD CRON NO</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $max_cron_no;?>" class="form-control"  required  name="ord_cron_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>CASE NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required  name="case_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>ORD PASSBY SIGN YN</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="ord_passby_sign_yn" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="ord_passby_sign_yn" value="">No</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD PASSBY DESIG</label>
                            <div class="col-sm-4">
                                <select name='ord_passby_desig' class="form-control" required>
                                    <option selected disabled>Select Designation</option>
                                    <option>ADC</option>
                                    <option>DC</option>
                                    <option>CO</option>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>ORD REF LET NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="ord_ref_let_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LM SIGN YN</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="lm_sign_yn" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="lm_sign_yn" value="">No</label>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LM CODE</label>
                            <div class="col-sm-4">
                                 <select class="form-control" name="lm_code" required>
                                     <option selected="disabled">Select Mondal</option>
                                    <?php foreach ($mandals as $type): ?>
                                        <?php if ($order->lm_code == $type->user_code): ?>
                                            <option selected value="<?php echo $type->lm_code; ?>"><?php echo $type->lm_name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $type->lm_code; ?>"><?php echo $type->lm_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LM SIGN DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar"  required  name="lm_sign_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>SK CODE</label>
                            <div class="col-sm-4">
                                 <select name='sk_code' class="form-control" required>
                                    <option selected disabled>Select SK</option>
                                    <?php foreach ($sks as $sk): ?>
                                        <option  value="<?php echo $sk->user_code; ?>"><?php echo $sk->username; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>SK SIGN YN</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="sk_sign_yn" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="sk_sign_yn" value="">No</label>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>SK SIGN DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar"  required  name="sk_sign_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>CO CODE</label>
                            <div class="col-sm-4">
                                <select name='co_code' class="form-control" required >
                                    <option selected disabled>Select CO</option>
                                      <?php foreach ($cos as $type): ?>
                                        <?php if ($order->co_code == $type->user_code): ?>
                                            <option selected value="<?php echo $type->user_code; ?>"><?php echo $type->username; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $type->user_code; ?>"><?php echo $type->username; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>CO SIGN YN</label>
                            <div class="col-sm-4">
                                <label class="checkbox-inline"><input type="radio" checked="" name="co_sign_yn" value="Y">Yes</label>
                                <label class="checkbox-inline"><input type="radio" name="co_sign_yn" value="">No</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>CO ORD DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar"  required  name="co_ord_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>WRT ORDER1</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="wrt_order1" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>WRT ORDER2</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="wrt_order2" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>WRT ORDER3</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="wrt_order3" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">
                            
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>WRT ORDER4</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="wrt_order4" id="applicantNam" 
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>WRT ORDER5</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"    name="wrt_order5" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                         <div style="text-align: center">
                          
                            <input type="submit" name="submit"  class="btn btn-danger"/>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>