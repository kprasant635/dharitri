<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 ">
                <div class="well well-sm mis_report">
                    <h4 style="text-align: center;">
                        <?php 
                            if($details->mut_type=='02')
                            {
                                echo "Field Partition ";
                            }else{
                                echo "Field Mutation  ";
                            }
                        ?> Order details
                    </h4>
                </div>
            </div>
           <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="col-lg-12">
                                <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                                <label class="col-sm-4 rasid">Basic Details</label>
                                <label class="col-sm-4 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y',strtotime(date('d-m-Y'))); ?></label>
                            </div>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
							<?php if($details->mut_type=='02')
                                {
                                    $action='savecoorderNew';
                                }else{
                                    $action='savecoorder';
                                }
                            ?>
                            <form class="form-horizontal" method="post"  action="<?php echo base_url() . 'index.php/cofieldmutation/'.$action; ?>">
                                <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                                <input type="hidden" name='dist_code' value="<?php echo $dist_code; ?>"/>
                                <input type="hidden" name='subdiv_code' value="<?php echo $subdiv_code; ?>"/>
                                <input type="hidden" name='cir_code' value="<?php echo $cir_code; ?>"/>
                                <input type="hidden" name='mouza_pargona_code' value="<?php echo $mouza_pargona_code; ?>"/>
                                <input type="hidden" name='lot_no' value="<?php echo $lot_no; ?>"/>
                                <input type="hidden" name='vill_townprt_code' value="<?php echo $vill_townprt_code; ?>"/>
                                <div class="col-lg-12">
                                    <label class="col-sm-4 uni_text">
                                        <?php echo $this->lang->line('pass_order');?> : 
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='order_pass_yn' checked="" id="inlineCheckbox1" value="y"><i class='glyphicon glyphicon-ok-sign green'></i>
                                        </label>
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='order_pass_yn' id="inlineCheckbox2" value="n"><i class='glyphicon glyphicon glyphicon-remove red'></i>
                                        </label>
                                    </label>
                                    <label class="col-sm-4 rasid" style="padding-left: 0px !important;" >
                                        <?php echo $this->lang->line('order_type');?> : 
                                        <?php
                                            $mut_type_name;
                                            if ($details->mut_type == '01')
                                                $mut_type_name = 'Mutation';
                                            else
                                                $mut_type_name = 'Partition';
                                        ?>
                                        <input type="text" readonly="" value="<?php echo $mut_type_name; ?>"/>
                                    </label>
                                    <?php
                                    if($details->mut_type == 01){?>
                                    <label class="col-sm-4 rasid">
                                        Transfer : 
                                        <input type="text" name="" value="<?php echo $this->utilityclass->getTransferType($details->trans_code);?>" readonly=""/>
                                        <input type="hidden" name="nature_trans_code" value="<?php echo $details->trans_code; ?>" readonly=""/>
                                    </label>
                                    <?php } ?>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <label class="col-sm-4 uni_text">
                                        <?php echo $this->lang->line('mondal_name');?> : 
                                        <?php $data = $details->lm_name;?>
                                        <input type="hidden" class="form-control" value="<?php echo $details->lm_code; ?>" name="lm_code" readonly=""/>
                                        <?php $lms = $this->utilityclass->getDefinedMondalsName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no,$details->lm_code);?>
                                        <?php echo $lms->lm_name;?>
                                    </label>
                                    <label class="col-sm-4 rasid">
                                        <?php echo $this->lang->line('mondal_sign');?> : 
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='lm_sign_yn' checked="" id="inlineCheckbox1" value="y">
                                            <i class='glyphicon glyphicon-ok-sign green'></i>
                                        </label>
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='lm_sign_yn' id="inlineCheckbox2" value="n">
                                            <i class='glyphicon glyphicon glyphicon-remove red'></i>
                                        </label>
                                    </label>
                                    <label class="col-sm-4 rasid">
                                        <?php echo $this->lang->line('lm_note_date');?> : <?php echo date('d-m-Y', strtotime($details->date_entry)); ?>
                                    </label>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <label class="col-sm-12 uni_text"><?php echo $this->lang->line('lm_note');?> : <?php echo $remark->remark; ?></label>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <label class="col-sm-4 uni_text">
                                        <?php echo $this->lang->line('co_name');?> : 
                                        <?php $coname = $this->utilityclass->getCOCode($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('user_code')); ?>
                                        <input type="hidden" class="form-control" value="<?php echo $coname->user_code; ?>" name="co_code" readonly=""/>
                                        <?php echo $coname->username; ?>
                                    </label>
                                    <label class="col-sm-4 rasid">
                                        <?php echo $this->lang->line('co_sign');?> : 
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='co_sign_yn' checked="" id="inlineCheckbox1" value="y">
                                            <i class='glyphicon glyphicon-ok-sign green'></i>
                                        </label>
                                        <label class="checkbox-inline radio-inline-no-padding">
                                            <input type="radio" name='co_sign_yn' id="inlineCheckbox2" value="n">
                                            <i class='glyphicon glyphicon glyphicon-remove red'></i>
                                        </label>
                                    </label>
                                    <label class="col-sm-4 rasid">
                                        <?php echo $this->lang->line('co_order_date'); ?> : 
                                        <input type="hidden" class="form-control" name="co_ord_date" value ='<?php echo date('d-m-Y'); ?>' readonly=""/>
                                        <?php echo date('d-m-Y',strtotime(date('d-m-Y'))); ?>
                                    </label>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-4">
                                        <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Submit / Proceed</button>
                                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                        <button class="btn btn-warning" id='backtoLists'><i class="fa fa-arrow-left"></i> Back To Previous Case List(s)</button>
                                    </div>
                                </div>
                            </form>   
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $('#backtoLists').click(function(e){
        e.preventDefault();
        window.location.href=baseurl +'cofieldmutation/getPendingFMCases';
    });
</script>