<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($data);?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
                <div class="panel panel-primary panel-form">
                <p class="text-center uni_text"><?php echo $this->lang->line('citizen_apply_form')?> (<?php echo $this->utilityclass->getCertName($this->session->userdata('cert_codeNo')  ); ?> <?php echo $this->lang->line('applied_for_post')?>) </p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>  :<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?>  :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?>  :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                </div>
                <hr>
                <div class="center">
                    <div class="col-lg-offset-3 btn btn-primary uni_text" id="jamabandiRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('jamabandi_for_patta');?></div>
                    <div class="btn btn-warning uni_text" id="PageRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('chitha_for_patta');?></div>
                </div>
                <hr>
                
                <form class="form-inline" action="<?php echo base_url(); ?>index.php/CitizenController/LMPPSubmit"  method="post">
                    
                    <div class="form-group col-lg-6">
                        <label class="col-lg-5 control-label uni_text"><?php echo $this->lang->line('how_may_years');?> </label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control input-width"  required="" id="no_year" name="no_year" />
                        </div>
                    </div>
                    
                    <div class="form-group col-lg-6">
                        <label class="col-lg-5 control-label uni_text"><?php echo $this->lang->line('how_may_years');?> </label>
                        <div class="col-lg-2 display_year">
                            <input type="text" readonly="" required="" class="form-control" name="date_upto" />
                        </div>
                    </div>
                    <p></p>
                    <div style="margin-top: 20px"></div>
                    <div class="form-group col-lg-6">
                        <p class="uni_text text-center"><?php echo $this->lang->line('installment_date');?></p>
                    </div><div class="form-group col-lg-6">
                        <p class="uni_text text-center"><?php echo $this->lang->line('revenue_to_paid');?></p>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="col-lg-4 uni_text"><?php echo $this->lang->line('first_installment');?></label>
                        <div class="form-group">
                            <input type="text" id="ddmmyy" required="" name="f_install" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group col-lg-6 center">
                        <div class="form-group">
                            <input type="text"  name="f_ins_rs" required="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-12"></div>
                    <div class="form-group col-lg-6">
                        <label class="col-lg-4 uni_text"><?php echo $this->lang->line('second_installment');?></label>
                        <div class="form-group">
                            <input type="text" id="ddmmyy1" required="" name="s_install" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group col-lg-6 center">
                        <div class="form-group">
                            <input type="text" required="" name="s_ins_rs" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin-bottom: 15px"></div>
                    <hr>
                    <p class="uni_text text-center"><?php echo $this->lang->line('applicant_dag_dtls'); ?> </p>
                    <p id='showdata'  class="text-danger uni_text col-lg-offset-4" role="alert" ></p>
                    <div id="itemRows"  style="margin-bottom: 15px; margin-top: 20px; margin-left: 100px">
                        <?php echo $this->lang->line('dag_no'); ?> : 
                        <select class="form-control dag_no_change" required="" id='dag_no_change' name='dag'>
                            <option><?php echo $this->lang->line('select_dag'); ?></option>
                            <?php foreach ($dags as $d): ?>
                                <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo $this->lang->line('bigha'); ?>: <input type="text" readonly="" class="form-control input-width"  id="appliedbigha" name="bigha" value="0" />
                        <?php echo $this->lang->line('katha'); ?> : <input type="text" readonly="" name="katha" class="form-control input-width" id="appliedkatha"  value="0" /> 
                        <?php echo $this->lang->line('lesa'); ?>: <input type="text" name="lessa" readonly="" class="form-control input-width" id="appliedlessa" value="0" /> <br>
                        <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                         <?php echo $this->lang->line('ganda'); ?>: <input type="text" name="ganda" readonly="" class="form-control input-width" id="appliedganda" value="0" />   
                    <?php }?> 
                       
                    </div>
                    <?php if ($this->session->flashdata('message')): ?>
                    <?php 
                        echo '<div class="">
                            <p style="color:red;">'.$this->session->flashdata('message').'</p>
                        </div>';
                    ?>
                    <?php endif; ?>
                    <button style="margin-bottom: 10px" class="btn btn-success btn-sm col-lg-offset-5" type="submit"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                 </form>
                </div>
        </div>
    </div>
</div>
<script>
$('#PageRedirect').click(function(){
   window.open("<?php echo base_url(); ?>index.php/CitizenController/ChithaSelectPatta", "MsgWindow", "width=1000,height=900")
});
$('#jamabandiRedirect').click(function(){
	window.open("<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>", "MsgWindow", "width=1000,height=900")
});
</script>


