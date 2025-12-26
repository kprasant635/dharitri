<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order');?></h2>
            <?php
            //var_dump($lmnote);
            $lm_sign_yn=$lmnote->lm_sign_yn;
            $sk_sign_yn=$lmnote->sk_sign_yn;
            $lm_sign_date=date('d/m/Y', strtotime($lmnote->lm_sign_date) );
            $sk_note_date=date('d/m/Y',  strtotime($lmnote->sk_note_date));
            if($sk_sign_yn==null)
            {
                $sk_note_date='';
            }         
            ?>
            <hr>
            <div class="col-lg-4 uni_text"> <?php echo $this->lang->line('case_no');?> : <?php echo $this->session->userdata('case_no'); ?> </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('order_srno')?> : 4 </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('date')?> : <?php echo date('d-m-Y') ?></div>
            <hr>
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/partition/COSelectDag">
                    <legend><h4 class="text-center text-primary"><?php echo $this->lang->line('order_details_rpt')?> </h4></legend>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('order_no')?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='case_no' readonly="" value="<?php echo $this->session->userdata('case_no') ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('order_date')?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly="" name="orderDate" value="<?php echo date('d/m/Y',  strtotime($pb->submission_date)) ?>" >
                        </div>
                    </div>               
                    <div class="form-group ">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('order_type')?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly="" name="orderType" value='Partition' >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label hide">Order Passed By Sign (Y/N) *</label>
                        <div class="col-lg-4 hide" >
                            <label class="radio-inline">
                                <input type="radio" name="OrderPassSign"  value="Y" checked="">
                                YES
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="OrderPassSign"  value="N" >
                                NO
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('case_no')?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly="" name='orderNo' value="<?php echo $this->session->userdata('case_no') ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('Reference_letter_no');?></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="refLtrNo" >
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label for="inputEmail" class="col-lg-2 control-label">Type Of Govt. Land</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="GovtLand" disabled="" >
                        </div>
 
                    </div>
                    <hr>
                    <?php
                   // print_r($getSelectedMondalsName);
                    ?>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name')?> </label>
                        <div class="col-lg-4">
                           <input type="text" readonly="" class="form-control" value="<?php echo $getSelectedMondalsName->lm_name; ?>" >
                           <input type="hidden" value="<?php echo $getSelectedMondalsName->lm_code ?>" name="lmName" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign')?> </label>
                        <?php
                        if($lm_sign_yn=='Y')
                        {
                        ?>                  
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="lmSign"  value="Y" checked="">
                                <?php echo $this->lang->line('consent_yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lmSign" disabled=""  value="N" >
                               <?php echo $this->lang->line('consent_no');?>
                            </label>
                        </div>
                        <?php
                        }
                        else{
                        ?>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="lmSign" disabled=""  value="Y">
                                <?php echo $this->lang->line('consent_yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lmSign" checked=""  value="N" >
                               <?php echo $this->lang->line('consent_no');?>
                            </label>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date');?> </label>
                        <div class="col-lg-4">
                            <input type="text" readonly="" value="<?php echo $lm_sign_date; ?>"  class="form-control"  >
                            <input type="hidden" value="<?php echo $lmnote->lm_sign_date; ?>" name="lmSignDate" >
                        </div>
                    </div>
                    <hr>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sk_name');?> </label>
                        <div class="col-lg-4">
                            <?php
                            if($sk_sign_yn==null)
                                {
                            ?>
                            <input type="text" class="form-control" placeholder="SK Not Found" name="skName" value="" >
                                <?php }else { ?>
                            <input type="text" readonly="" class="form-control" value="<?php echo $getSelectedSKName->username ;?>" >
                            <input type="hidden" class="form-control" name="skName" value="<?php echo $getSelectedSKName->user_code ;?>" >
                                <?php }?>
                        </div>
                        <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign');?></label>
                        <?php
                        if($sk_sign_yn=='Y')
                        {
                        ?>   
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="skSign"  value="Y" checked="">
                                <?php echo $this->lang->line('consent_yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="skSign" disabled="" value="N" >
                                <?php echo $this->lang->line('consent_no');?>
                            </label>
                        </div>
                        <?php } 
                        else {?>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="skSign" disabled=""  value="Y" >
                                <?php echo $this->lang->line('consent_yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="skSign" checked=""  value="N" >
                                <?php echo $this->lang->line('consent_no');?>
                            </label>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                         <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign_date');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly="" value="<?php echo $sk_note_date; ?>" >
                            <input type="hidden" class="form-control" value="<?php echo $lmnote->sk_note_date; ?>" name="skSignDate" >
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                         <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name');?></label>
                        <div class="col-lg-4">
                            <input type="text" readonly="" class="form-control" value="<?php echo $getSelectedCOName->username; ?>" >
                            <input type="hidden" class="form-control" name="coName" value="<?php echo $getSelectedCOName->user_code; ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign');?> </label>
                        <div class="col-lg-4">
                            <label class="radio-inline">
                                <input type="radio" name="COSign"  value="Y" checked="">
                                <?php echo $this->lang->line('consent_yes');?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="COSign"  value="N" >
                               <?php echo $this->lang->line('consent_no');?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group ">
                         <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date');?></label>
                        <div class="col-lg-4">
                            <input type="text" readonly="" class="form-control" id="ddmmyy" value="<?php echo date('d/m/Y') ?>" name="coSignDate" >
                        </div>
                    </div>
                    <hr>
					<div class='hide'>
                    <div>
                        <h3 class="uni_text"><?php echo $this->lang->line('Reference_of_Court_Order')?></h3>
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order1')?></p>
                        <input type="text" class="form-control" name="wrt1" >
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order2')?></p>
                        <input type="text" class="form-control" name="wrt2" >
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order3')?></p>
                        <input type="text" class="form-control" name="wrt3" >
                    </div>
                    <div class="col-lg-3">
                        <p class="center"><?php echo $this->lang->line('wrt_order4')?></p>
                        <input type="text" class="form-control" name="wrt4" >
                    </div>
					</div>
                    <div class="col-lg-12" style="margin-top: 10px" ></div>
                    
                    <button class="btn btn-primary col-lg-offset-5 uni_text" style="margin-top: 20px" type="submit"><?php echo $this->lang->line('submit_button')?> &nbsp;<i class="fa fa-arrow-circle-o-right"></i> </button> 

                </form>
            </div>
        </div>
    </div>
</div>
