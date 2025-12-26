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
                    <h3 class="panel-title">ADD INFAVOUR</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post">

                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $this->session->userdata('ord_no'); ?>" required   name="ord_no" id="applicantNam" required
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar" value="<?php echo $this->session->userdata('ord_date'); ?>"   required   name="ord_date" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>ORD CRON NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $this->session->userdata('ord_cron_no'); ?>" required   name="ord_cron_no" id="applicantNam" required
                                       placeholder="">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>PATTA TYPE CODE</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="patta_type_code" required>
                                    <option selected disabled>Patta Type</option>
                                    <?php foreach ($patta_types as $pt): ?>
                                        <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Patta No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="" required   name="patta_no" id="applicantNam" required
                                       placeholder="">
                            </div>


                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>INFAVOR OF NAME</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="infavor_of_name" id="applicantNam" required
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>INFAVOR OF GUARDIAN</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="infavor_of_guardian" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>INFAV OF GUAR RELATION</label>
                            <div class="col-sm-4">

                                <select name="infav_of_guar_relation" class="form-control" required>
                                      <option disabled selected>Select Relation</option>
                                    <?php foreach ($relation as $r): ?>
                                        <option value="<?php echo $r->guard_rel; ?>" ><?php echo $r->guard_rel_desc_as; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>INFAVOR OF ADD1</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"     name="infavor_of_add1" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>INFAVOR OF ADD2</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"     name="infavor_of_add2" id="applicantNam" 
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>BY RIGHT OF</label>
                            <div class="col-sm-4">

                                <select class="form-control" name="by_right_of" required> 
                                    <option>Select Transfer Type</option>
                                    <?php foreach ($trans_codes as $type): ?>
                                        <?php if ($order->nature_trans_code == $type->trans_code): ?>
                                            <option selected value="<?php echo $type->trans_code; ?>"><?php echo $type->trans_desc_as; ?></option>
                                        <?php else: ?>
                                            <option  value="<?php echo $type->trans_code; ?>"><?php echo $type->trans_desc_as; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>BIGHA</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="land_area_b" id="applicantNam" required
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>KATHA</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="land_area_k" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>LESSA</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  required   name="land_area_lc" id="applicantNam" required
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>GANDA</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"   value="0"  name="land_area_g" id="applicantNam" required
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>KRANTIK</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"     name="land_area_kr" id="applicantNam" 
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>REG DEED NO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"     name="reg_deal_no" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" style="width: 100%;">

                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>REG DATE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dating calendar"     name="reg_date" id="applicantNam" 
                                       placeholder="">
                            </div>


                            <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>SUB REG OFFICE</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"     name="sub_reg_office" id="applicantNam" 
                                       placeholder="">
                            </div>
                        </div>
                        <hr>

                        <div style="text-align: center">
                                <input type="submit" name="submit" value="Submit"  class="btn btn-danger"/>
                                <a  href="<?php echo base_url();?>index.php/chithaeditentry/step3" class="btn btn-danger">NEXT</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>