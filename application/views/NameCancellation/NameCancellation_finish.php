<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order');?></h2>
            <hr>
            <div class="col-lg-4 "><?php echo $this->lang->line('case_no');?> : <?php echo $case_no = $this->session->userdata('case_no'); ?> </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y') ?></div>
            <div class="col-lg-12">
                <hr>
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-2" style="text-align: center;">
                       <p class='uni_text'> You have successfully entered all the data. Thank You! <br/><br/>
                        Chitha Has been Updated !! Please Check Chitha Now...
						</p>
                    </div>
                    <br/>
                </div>
                <br/>
                <hr/>
               <center> 
			   <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                </a></center>
            </div>
        </div>
    </div>
</div>
