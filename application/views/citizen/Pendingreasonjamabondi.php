<div class="container-fluid form-top">
    <div class="row">
        <?php //var_dump($certapp) ;?>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="uni_text center">জমাবন্দীৰ নকল ৰ  বাবে আবেদন </h2>
                    <div class="col-lg-4 uni_text"><?php echo $this->lang->line('sr_no')?> : <?php echo $certapp->cert_no; ?> </div>
                    <div class="col-lg-4 uni_text"><?php echo $this->lang->line('apply_date')?> : <?php echo $certapp->apply_date; ?> </div>
                    <div class="col-lg-4 uni_text"><?php echo $this->lang->line('delivery_date')?> : <?php echo date('d/m/Y', strtotime($certapp->next_due_date)) ?> </div>
                    <hr>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>index.php/CitizenController/UpdateJamabandingpending">
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('reason_keep_pending');?></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="pendingreason" rows="5" id="textArea"></textarea>
                                <input type="hidden" value="<?php echo $certapp->cert_no ?>"  name="cert_no">
                                <!--#START PLB-->
                                <input type="hidden" value="<?php echo $certapp->basundhara ?>"  name="application_no">
                                <!--#END PLB-->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" name="submit" class="btn btn-primary"><?php echo $this->lang->line('submit_button');?></button>
                            </div>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
   </div>
</div>
        