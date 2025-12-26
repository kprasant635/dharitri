<?php //var_dump($pdarinfo->pdar_name);?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('second_party_details');?></h2>
            <hr>
            <div class="col-lg-4 "> <?php echo $this->lang->line('case_no');?> : <?php echo $case_no=$this->session->userdata('case_no'); ?> </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y') ?></div>
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo base_url(); ?>index.php/NameCancellation/SecondParty_save">
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no');?> *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_no" readonly="readonly" value="<?php echo $case_no; ?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_date');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ord_date" value="<?php echo date('Y-m-d'); ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('order_reference_letter_no');?> </label>
                        <div class="col-lg-4">
                           <input type="text" class="form-control" name="ord_ref_let_no" value="" >
                        </div>
                    </div>
                    <?php
                    foreach($pdarinfo as $p){  
                    ?>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('name');?></label>
                        <div class="col-lg-4" >
                            <input type="text" class="form-control" name='name_for' value="<?php echo $p->pdar_name;?>" >
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('guardian_name');?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name_for_guardian" value="<?php echo $p->pdar_father;?>" />
                        </div>
 
                    </div>
                    <?php } ?>
                    <hr>
                     <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Order Type</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="case_type_code" >
                                <option value="07"><?php echo $this->lang->line('name_cancellation');?></option>
                            </select>
                        </div>
                     
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no');?>  </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infav_of_guar_relation" value="<?php echo $this->session->userdata('dag_no'); ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no');?>  </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="infav_of_guar_relation" value="<?php echo $this->session->userdata('patta_no'); ?>" />
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
