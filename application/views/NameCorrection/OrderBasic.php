<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 style="text-align: center;"><?php echo $this->lang->line('co_order'); ?></h2>
            <hr style="border-bottom: 2px solid #000;">
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('case_no'); ?> : <?php echo $misc_case_no = $this->session->userdata('misc_case_no'); ?> </div>
            <div class="col-lg-4 uni_text center"><?php echo $this->lang->line('sl_no'); ?> : <?php echo $orderNo + 1; ?> </div>
            <div class="col-lg-4 uni_text"><span style="float:right;"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></span></div>
            <hr style="border-bottom: 2px solid #000;">
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/NameCorrection/OrderBasic_save">
                    <h2><mark><?php echo $this->lang->line('basic_order_details'); ?></mark></h2>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_no'); ?> *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='ord_no' value="<?php echo $misc_case_no; ?>" >
                            <input type="hidden" name="misc_case_petition_no" value="<?php echo $this->session->userdata('misc_case_petition_no'); ?>"/>
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_date'); ?> *</label>
                        <div class="col-lg-4">
                            <input type="text"  readonly="" class="form-control" name="ord_date" value="<?php echo date('d-m-Y'); ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_type'); ?> *</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="ord_type_code" >
                                <option value="05"><?php echo $this->lang->line('name_correction'); ?></option>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('order_passed_by_sign_yn'); ?> *</label>
                        <div class="col-lg-2" >
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn"  value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn"  value="N" >
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='case_no' value="<?php echo $misc_case_no; ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('ref_letter_no'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_ref_let_no" >
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_passed_by'); ?></label>
                        <div class="col-lg-4" >
                            <select class="form-control" name="ord_passby_desig" >
                                <option value="CO"><?php echo $this->lang->line('co'); ?>CO</option>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('type_of_govt_land'); ?></label>
                        <div class="col-lg-4">
                            <select class="form-control" name="ord_on_gl_type" >
                                <?php foreach ($landtype AS $land) { ?>
                                    <option value="<?php echo $land->type_code; ?>"><?php echo $land->type; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <h2><mark><?php echo $this->lang->line('lot_mondols_details'); ?></mark></h2>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_name'); ?> *</label>
                        <?php //var_dump($LMList); ?>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" name="" value="<?php echo $LMList_selected->lm_name;   ?>" >
                            <input class="form-control" type="hidden" name="lm_code" value="<?php echo $LMList_selected->lm_code;   ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_sign'); ?> *</label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign"  value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign"  value="N" >
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_sign_date'); ?> </label>
                        <div class="col-lg-4">
                            <input type="text" id="popup3Datepicker" value="<?php echo date("d-m-Y", strtotime($LmSignDate)); ?>"  class="form-control" name="lm_sign_date" >
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <h2><mark><?php echo $this->lang->line('sk_details'); ?></mark></h2>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_name'); ?></label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" name="" value="<?php echo $SKList->username;?>">
                            <input class="form-control" type="hidden" name="sk_code" value="<?php echo $miscCaseInfo->user_code;?>">
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign'); ?> *</label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign"  value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign"  value="N" >
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign_date'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="popup2Datepicker" value="<?php echo date("d-m-Y", strtotime($SkSignDate)); ?>" name="sk_sign_date" >
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <h2><mark><?php echo $this->lang->line('co_details'); ?></mark></h2>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_name'); ?></label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" name="" value="<?php echo $COList->username; ?>" >
                            <input class="form-control" type="hidden" name="co_code" value="<?php echo $COList->user_code; ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_sign'); ?> </label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="co_sign"  value="Y" checked="">
                                <?php echo $this->lang->line('yes'); ?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="co_sign"  value="N" >
                                <?php echo $this->lang->line('no'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_sign_date'); ?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="DatepickerCO" value="<?php echo date("d-m-Y", strtotime($COSignDate)); ?>" name="co_sign_date" >
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <div>
                            <h2><mark><?php echo $this->lang->line('reference_of_court_order_no'); ?></mark></h2>
                        </div>
                        <br/>
                        <div class="col-lg-3">
                            <p class="center"><?php echo $this->lang->line('wrt_order1'); ?></p>
                            <input type="text" class="form-control" name="wrt1" >
                        </div>
                        <div class="col-lg-3">
                            <p class="center"><?php echo $this->lang->line('wrt_order2'); ?></p>
                            <input type="text" class="form-control" name="wrt2" >
                        </div>
                        <div class="col-lg-3">
                            <p class="center"><?php echo $this->lang->line('wrt_order3'); ?></p>
                            <input type="text" class="form-control" name="wrt3" >
                        </div>
                        <div class="col-lg-3">
                            <p class="center"><?php echo $this->lang->line('wrt_order4'); ?></p>
                            <input type="text" class="form-control" name="wrt4" >
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <center>
                        <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button> 
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>