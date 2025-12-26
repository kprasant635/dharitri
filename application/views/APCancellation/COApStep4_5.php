<?php
// var_dump($pattadars);die;
$pattadarNo = count($pattadars);
if ($pattadarNo == 0) {
    redirect(base_url() . "index.php/APCancellation/COAPStep4_6_finish");
} else {
?>
    <div class="container-fluid login form-top">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 panel-form">
                <h2 class="uni_text center"><?php echo $this->lang->line('co_order'); ?></h2>

                <hr style="border-bottom: 2px solid #000;">
                <div class="col-lg-6 uni_text"> <?php echo $this->lang->line('case_no'); ?> : <?php echo $this->session->userdata('case_no'); ?> </div>

                <div class="col-lg-6 uni_text" style="text-align:right"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></div>
                <div class="col-lg-12">
                    <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                        <hr>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sl_no'); ?> *</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name='name_for_id' value="<?php echo ($name_for_id + 1); ?>">
                            </div>

                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_no'); ?> *</label>
                            <div class="col-lg-4">
                                <input type="text" readonly class="form-control" name="ord_no" value="<?php echo $this->session->userdata('ord_no'); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('name'); ?></label>
                            <div class="col-lg-4">

                                <input type="hidden" class="form-control" name='pdar_id' value="<?php echo $pattadars->pdar_id ?>">

                                <input type="text" class="form-control" name='name_for' value="<?php echo $pattadars->pdar_name ?>">
                            </div>
                            <label for="inputEmail" class="col-lg-2 control-label hide"><?php echo $this->lang->line('ref_letter_no'); ?></label>
                            <div class="col-lg-4 hide">
                                <input type="text" class="form-control" name="ord_ref_let_no" value="<?php echo $this->session->userdata('ord_ref_let_no'); ?>">
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('guardian_name'); ?></label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name='name_for_guardian' value="<?php echo $pattadars->pdar_guardian ?>">
                            </div>
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('relation'); ?></label>
                            <div class="col-lg-4">
                                <select class="form-control" name="name_for_guar_relation">
                                    <?php foreach ($relation as $rel) { ?>
                                        <option value="<?php echo $rel->guard_rel; ?>"><?php echo $rel->guard_rel_desc; ?> [<?php echo $rel->guard_rel_desc_as; ?>]</option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_type'); ?></label>
                            <div class="col-lg-4">
                                <select class="form-control" name="case_type_code">
                                    <option value="04">পট্টা ৰদ (একচনা পট্টা)<?php //echo $this->lang->line('patta_rod'); 
                                                                                ?></option>
                                </select>
                            </div>

                            <label class="col-lg-2 control-label"><?php echo $this->lang->line('purpose'); ?> </label>
                            <div class="col-lg-4">
                                <input type="text" value="" class="form-control" name="purpose">
                            </div>

                        </div>
                        <div class="form-group hide">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('against_which_order'); ?></label>
                            <div class="col-lg-4">
                                <input type="text" value="" class="form-control" name="against_which_order">
                            </div>
                        </div>
                        <div class="form-group hide">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('conversion_type'); ?></label>
                            <div class="col-lg-4">
                                <select class="form-control" name="conversation_type">
                                    <option value="0"><?php echo $this->lang->line('full'); ?></option>
                                    <option value="1"><?php echo $this->lang->line('partial'); ?></option>
                                </select>
                            </div>
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('land_area_bigha'); ?></label>
                            <div class="col-lg-4">
                                <input type="text" value="0" class="form-control" name="name_for_land_b">
                            </div>
                        </div>
                        <div class="form-group hide">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('land_area_katha'); ?></label>
                            <div class="col-lg-4">
                                <input type="text" value="0" class="form-control" name="name_for_land_k">
                            </div>
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('land_area_lessa'); ?></label>
                            <div class="col-lg-4">
                                <input type="text" value="0" class="form-control" name="name_for_land_lc">
                            </div>
                        </div>

                        <hr>
                        <center>
                            <button name="formsubmit" class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?> </button>
                            <a href="javascript:history.back()" class="btn btn-md btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back'); ?>
                            </a>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } ?>