<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order');?></h2>
            <hr>
            <div class="col-lg-4 "> <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no=$this->session->userdata('misc_case_no'); ?> </div>
            <div class="col-lg-4"><?php echo $this->lang->line('order_sl_no');?> : <?php echo $orderNo+1;?> </div>
            <div class="col-lg-4"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y') ?></div>
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/NameCancellation/OrderBasic_save">
                    <h2>Basic Order Details</h2>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_no');?> *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='ord_no' value="<?php echo $misc_case_no; ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_date');?> *</label>
                        <div class="col-lg-4">
                            <input type="text" id="popupDatepicker" class="form-control" name="ord_date" value="<?php echo date('d-m-Y'); ?>" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_type');?> *</label>
                        <div class="col-lg-4">
                            
                            <select class="form-control" name="ord_type_code" >
                                <option value="05"><?php echo $this->lang->line('others');?></option>
                            </select>
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_passed_by_sign');?> *</label>
                        <div class="col-lg-4" >
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn"  value="Y" checked="">
                                <?php echo $this->lang->line('yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="ord_passby_sign_yn"  value="N" >
                                <?php echo $this->lang->line('no');?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='case_no' value="<?php echo $misc_case_no; ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('ref_letter_no');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_ref_let_no" >
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_passed_by');?></label>
                        <div class="col-lg-4" >
                            <select class="form-control" name="ord_passby_desig" >
                                <option value="CO"><?php echo $this->lang->line('co');?></option>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-2 hide control-label"><?php echo $this->lang->line('type_of_govt_land');?></label>
                        <div class="col-lg-4 hide">
                           <select class="form-control" name="ord_on_gl_type" >
                               <?php foreach($landtype AS $land){?>
                                <option value="<?php echo $land->type_code;?>"><?php echo $land->type;?></option>
                               <?php }?>
                            </select>
                        </div>
 
                    </div>
                    <hr>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_name');?> *</label>
                        <div class="col-lg-4">
                             <select class="form-control" name="lm_code" >
                               <?php foreach($LMList AS $lm){?>
                                <option value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                               <?php }?>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_sign');?> *</label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign"  value="Y" checked="">
                                YES
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lm_sign"  value="N" >
                                NO
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('mondal_sign_date');?> </label>
                        <div class="col-lg-4">
                            <input type="text" id="popup3Datepicker" value="<?php echo date("d-m-Y", strtotime($LmSignDate)); ?>"  class="form-control" name="lm_sign_date" >
                        </div>
                    </div>
                    <hr>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_name');?></label>
                        <div class="col-lg-4">
                            <select class="form-control" name="sk_code" >
                               <?php foreach($SKList AS $sk){?>
                                <option value="<?php echo $sk->user_code;?>"><?php echo $sk->username;?></option>
                               <?php }?>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign');?>  *</label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign"  value="Y" checked="">
                               <?php echo $this->lang->line('yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sk_sign"  value="N" >
                               <?php echo $this->lang->line('no');?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sk_sign_date');?>  </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="popup2Datepicker" value="<?php  echo date("d-m-Y", strtotime($SkSignDate)); ?>" name="sk_sign_date" >
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                         <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_name');?>CO's Name </label>
                        <div class="col-lg-4">
                            <select class="form-control" name="co_code" >
                                <option value="<?php echo $COList->user_code;?>"><?php echo $COList->username;?></option>
                            </select>
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_sign');?>  </label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="co_sign"  value="Y" checked="">
                                 <?php echo $this->lang->line('yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="co_sign"  value="N" >
                                 <?php echo $this->lang->line('no');?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('co_sign_date');?>  </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="DatepickerCO" value="<?php echo date("d-m-Y", strtotime($COSignDate));?>" name="co_sign_date" >
                        </div>
                    </div>
                    <hr>
                    <div class='hide'>
                        <h3><?php echo $this->lang->line('reference_of_court_order_no');?> </h3>
                    </div>
                    <br/>
                    <div class="col-lg-3 hide">
                        <p class="center"><?php echo $this->lang->line('wrt_order1');?></p>
                        <input type="text" class="form-control" name="wrt1" >
                    </div>
                    <div class="col-lg-3 hide">
                        <p class="center"><?php echo $this->lang->line('wrt_order2');?></p>
                        <input type="text" class="form-control" name="wrt2" >
                    </div>
                    <div class="col-lg-3 hide">
                        <p class="center"><?php echo $this->lang->line('wrt_order3');?></p>
                        <input type="text" class="form-control" name="wrt3" >
                    </div>
                    <div class="col-lg-3 hide">
                        <p class="center"><?php echo $this->lang->line('wrt_order4');?></p>
                        <input type="text" class="form-control" name="wrt4" >
                    </div>
                    <div class="col-lg-3 hide">
                        <p class="center"><?php echo $this->lang->line('wrt_order5');?></p>
                        <input type="text" class="form-control" name="wrt5" >
                    </div>
                    <button class="btn btn-primary col-lg-offset-5"  type="submit"><?php echo $this->lang->line('submit_button');?> </button> 

                </form>
            </div>
        </div>
    </div>
</div>
