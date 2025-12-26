<?php //var_dump($this->session->all_userdata()) ?>
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('write_petition_information');?></h3>
                </div>
                <div class="panel-body">
                 
                    <table class="table table-striped table-hover">
                        <tr class="success">
                            <td><?php echo $this->lang->line('district'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></td>
                            <td><?php echo $this->lang->line('subdivision'); ?> :<?php  echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')); ?></td>
                            <td><?php echo $this->lang->line('circle'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')); ?></td>
                        </tr>
                        <tr class="warning">
                            <td><?php echo $this->lang->line('mouza'); ?> :<?php  echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code')); ?></td>
                            <td><?php echo $this->lang->line('lot_no'); ?> :<?php  echo $this->utilityclass->getLotName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no')); ?></td>
                            <td><?php echo $this->lang->line('vill_town'); ?> :<?php  echo $this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'),$this->session->userdata('vill_code')); ?></td>
                        </tr>
                        <tr class="info">
                            <td><?php echo $this->lang->line('dag_no'); ?> :<?php  echo $this->session->userdata('dag_no'); ?></td>
                            <td><?php echo $this->lang->line('mutation_type'); ?> :<?php   $d=$this->utilityclass->getMutationTypeObject($this->session->userdata('mut_type')); 
                            echo $d->order_type; ?></td>
                        <td></td>
                        </tr>
                    </table>
                  
                    <hr>
                    <h4>Please Fill-Up details :</h4>
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url()."index.php/objection/registerconfirm";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('Report_Date'); ?></label>
                            <div class="col-lg-4">
                                <input class="form-control " name='current_date' readonly=""  value="<?php echo date('d-m-Y') ?>" />
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('object_petition_no'); ?></label>
                            <div class="col-lg-5">
                                <input class="form-control " name='case_no'  value="<?php echo $this->session->userdata('case_no'); ?>"/>
                            </div>
                            <div class="col-lg-2">
                              <div class="btn btn-primary uni_text">
                                <a href="<?php echo base_url()."index.php/ChithaReport/generateChitha" ?>?case_no=0" style="color: #fff" target="_blank" >
                                    <i class="fa fa-book"></i>&nbsp;<?php echo $this->lang->line('show_chitha') ?></a>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('previous_case_no'); ?> </label>
                                <div class="col-lg-5">
                                    <input class="form-control" required name='previous_case_no'  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('previous_date'); ?>  </label>
                             <div class="col-lg-5">
                                 <input class="form-control" required id='popupDatepicker' name='previous_date' placeholder="dd-mm-yyyy" />
                                  <span class="help-block">Provide Date Format dd-mm-yyy only  </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('applicant_name'); ?> </label>
                                 <div class="col-lg-5">
                                <input class="form-control " required name='applicant_name' />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('address'); ?> </label>
                                 <div class="col-lg-5">
                                <input class="form-control " required name='address' />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('reason_objection'); ?></label>
                            <div class="col-lg-7">
                                <textarea  class="form-control " required rows="6" name='reason_objection' > </textarea  >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-7 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary  uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>