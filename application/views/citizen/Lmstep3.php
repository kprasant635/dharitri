<div class="container-fluid form-top">
    <div class='row'>
        <?php //var_dump($data);?>
        <div class='col-lg-8' style="margin: 0 auto;float: none;">
                <div class="panel panel-primary panel-form">
                <p class="text-center uni_text"><?php echo $this->lang->line('citizen_apply_form')?></p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>:<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-offset-3 btn btn-primary uni_text" id="jamabandiRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('jamabandi_for_patta');?></div>
                    <div class="btn btn-warning uni_text" id="PageRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('chitha_for_patta');?></div>
                </div>
                <hr>
                <p class="uni_text text-center"><?php echo $this->lang->line('applicant_dag_dtls')?> </p>
                <form class="form-inline" action="<?php echo base_url(); ?>index.php/CitizenController/LmStep4"  method="post">
                    <div id="itemRows"  style="margin-bottom: 15px; margin-top: 20px;">
                            <?php echo $this->lang->line('dag_no')?>: <input type="text" class="form-control input-width" name="dag" />
                            <?php echo $this->lang->line('bigha')?>: <input type="text" class="form-control input-width" name="bigha" value="0" />
                            <?php echo $this->lang->line('katha')?>: <input type="text" name="katha" class="form-control input-width" value="0" /> 
                            <?php echo $this->lang->line('lesa')?>: <input type="text" name="lessa" class="form-control input-width" value="0" /> 
                            <?php echo $this->lang->line('ganda')?>: <input type="text" name="gonda" class="form-control input-width" value="0" /> 
                            <?php echo $this->lang->line('kranti')?>: <input type="text" name="kranti" class="form-control input-width" value="0" /> 
                    </div>
                    <button style="margin-bottom: 10px" class="btn btn-success uni_text  btn-lg col-lg-offset-5" type="submit"><?php echo $this->lang->line('submit_button')?></button>
                 </form>
                </div>
        </div>
    </div>
</div>
<script>
$('#PageRedirect').click(function(){
   location.href="<?php echo base_url(); ?>index.php/CitizenController/ChithaSelectPatta";
});
$('#jamabandiRedirect').click(function(){
   location.href="<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>";
});</script>
