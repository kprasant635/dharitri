

   
        <div class="col-lg-8 col-lg-offset-2">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Jamabandi Auto Update</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
             </div>
             <div class="col-lg-8 col-lg-offset-2">    
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                        <h6 class="red uni_text"><b>NOTE : Update old patta and new patta in case of partition and partial conversion.</b></h6>
                    </div>
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . 'index.php/Jamabandi/step2' ?>">
                    
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" onchange="this.form.submit();" name="patta_no" required>
                                    <?php if($patta_no):?>
                                        <option><?php echo $patta_no;?></option>
                                    <?php else:?>
                                         <option disabled selected>Select Patta No</option>
                                        <?php foreach($pattas as $p):?>
                                           <option><?php echo $p->patta_no;?></option>
                                       <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" name="locationsess" value='<?=@$datasession?>'>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type')?></label>
                            <div class="col-lg-5">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="patta_type">
                                    <option disabled selected>Select Patta Type</option>
                                    <?php if($type):?>
                                    <?php foreach ($type as $t):?>
                                        <option value="<?php echo $t->type_code;?>"><?php echo $t->patta_type;?></option>
                                    <?php endforeach;?>
                                   <?php endif;?>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/Jamabandi" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

