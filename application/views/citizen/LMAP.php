<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($this->session->all_userdata());?>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
                <div class="panel panel-primary panel-form">
                <p class="text-center uni_text"><?php echo $this->lang->line('citizen_apply_form')?> (<?php echo $this->utilityclass->getCertName($this->session->userdata('cert_codeNo')  ); ?><?php echo $this->lang->line('applied_for_post')?>) </p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>:<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                </div>
                <hr>
                <div class="center">
                      <div class="col-lg-offset-3 btn btn-primary uni_text" id="jamabandiRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('jamabandi_for_patta');?></div>
                    <div class="btn btn-warning uni_text" id="PageRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('chitha_for_patta');?></div>
                </div>
                <hr>
                
                <form class="form-inline" action="<?php echo base_url();?>index.php/CitizenController/LMSubmitAP"  method="post">
                    <div class="form-group" >
                        <div class="col-lg-5">
                        <label class="control-label"><?php echo $this->lang->line('how_may_years')?></label>
                        </div>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" name="no_year" value="1" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-5 control-label"><?php echo $this->lang->line('which_date')?></label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" id="ddmmyy" name="date_revenue" value="<?php echo date('d/m/Y') ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-7 control-label"><?php echo $this->lang->line('revenue_paid_year')?></label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control input-width" name="rev_year" value="<?php echo date('Y') ?>" >
                        </div>
                    </div>
                    
                    <div id="itemRows"  style="margin-bottom: 15px; margin-top: 20px; margin-left: 120px">
                        <?php echo $this->lang->line('dag_no'); ?> : 
                        <select class="form-control dag_no_change" required="" id='dag_no_change' name='dag'>
                            <option><?php echo $this->lang->line('select_dag'); ?></option>
                            <?php foreach ($dags as $d): ?>
                                <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo $this->lang->line('bigha'); ?>: <input type="text" readonly="" class="form-control input-width"  id="appliedbigha" name="bigha" value="0" />
                        <?php echo $this->lang->line('katha'); ?> : <input type="text" name="katha" readonly="" class="form-control input-width" id="appliedkatha"  value="0" /> 
                        <?php echo $this->lang->line('lesa'); ?>: <input type="text" name="lessa" readonly="" class="form-control input-width" id="appliedlessa" value="0" /> 
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
                    <hr>
                    <button style="margin-bottom: 10px; margin-top: 10px"  class="btn btn-success btn-sm col-lg-offset-5" type="submit"><?php echo $this->lang->line('submit_button')?></button>
                 </form>
                </div>
        </div>
    </div>
</div>
<script>
$('#PageRedirect').click(function(){
   //location.href="";
   window.open("<?php echo base_url(); ?>index.php/CitizenController/ChithaSelectPatta", "MsgWindow", "width=1000,height=900")
});
$('#jamabandiRedirect').click(function(){
	window.open("<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>", "MsgWindow", "width=1000,height=900")
   //location.href="<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>";
});
 

</script>

