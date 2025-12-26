<div class="container-fluid form-top login">
    <div class='row'>
        
    </div>        
</div> 
<div id="boxes">
    <div id="dialog" class="window">
        
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <p class="uni_text">
                        <span class="pull-left"><?php echo $this->utilityclass->getCertName($certDtls->cert_type); ?></span>
                        <span class="pull-right"><?php echo $this->lang->line('sr_no'); ?>:<?php echo $certDtls->cert_no; ?></span>
                    </p>
                    <?php //var_dump($users); ?>
                    <hr>
                    <p class='uni_text red center'>Please Upload the saved ror to deliver it directly to the customer.</p>
                    <div class="col-lg-12 update ">
                        <div class="alert alert-info">
                            <form class="form-horizontal unicode" action="<?php echo base_url(); ?>index.php/serviceplus/UpdateJamaBondi" method="POST" enctype="multipart/form-data">
								<div class="col-lg-12"><input type="file" name="myFile"></div>
								<hr>
                                <div class="form-group col-lg-offset-4">
                                    <button type="submit" id="button" class="btn btn-danger col-lg-offset-4">Deliver Certificate Now</button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>"  name="cert_no" >
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
  <div id="mask" style="display: fixed !important; background-color: black !important;"></div>
</div>
