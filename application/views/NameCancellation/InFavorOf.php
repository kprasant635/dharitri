<?php //var_dump($pdarinfo->pdar_name);?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('in_favor_of_details');?></h2>
            <hr>
            <div class="col-lg-4 "><?php echo $this->lang->line('case_no');?> : <?php echo $case_no=$this->session->userdata('case_no'); ?> </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y') ?></div>
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/NameCancellation/InFavorOf_save">
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('sl_no');?> *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name='infavor_of_id' readonly="readonly" value="<?php echo ($inFavID+1); ?>" >
                        </div>

                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no');?> *</label>
                        <div class="col-lg-4">
                            <input type="text" id="popupDatepicker" class="form-control" name="ord_no" readonly="readonly" value="<?php echo $case_no; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_date');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_ref_let_no" value="<?php echo date('d-m-Y'); ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type');?></label>
                        <div class="col-lg-4">
                            <input type="hidden" name='patta_type_code' value="<?php echo $this->session->userdata('patta_type_code'); ?>" >
                            <input type="text" class="form-control" name='name_for' value="<?php echo $landType->patta_type; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no');?></label>
                        <div class="col-lg-4" >
                            <input type="text" class="form-control" name='patta_no' value="<?php echo $this->session->userdata('patta_no'); ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no');?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="dag_no" value="<?php echo $this->session->userdata('dag_no'); ?>" />
                        </div>
 
                    </div>
                    <hr>
                     <div class="form-group">
                         
                         <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('in_favor_of_name');?> </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_name" value="<?php echo $pdarinfo->petition_pdar_name_old;?>" />
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('in_favor_of_guardian_name');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" disabled name="infavor_of_guardian" value="<?php //echo $pdarinfo->pdar_father;?>" />
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php //echo $this->lang->line('relation');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" disabled name="infav_of_guar_relation" value="<?php //echo $pdarinfo->pdar_guard_reln;?>" />
                        </div>
                    </div>
                    <hr>
                     <div class="form-group">
                       <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('address1');?></label>
                        <div class="col-lg-4">
                           <input type="text" class="form-control" name="infavor_of_add1" disabled value="<?php //echo $pdarinfo->pdar_add1;?>" />
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('address2');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infavor_of_add2" disabled value="<?php //echo $pdarinfo->pdar_add2;?>" />
                        </div>
                    </div>
                   
                   
                    <hr>
                    
                    <br/>
                    <button name="formsubmit" class="btn btn-primary col-lg-offset-5" style="margin-top: 20px" type="submit"><?php echo $this->lang->line('submit_button');?> </button> 

                </form>
            </div>
        </div>
    </div>
</div>
