<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <form class="form-horizontal unicode" method="POST" action="<?php echo base_url(); ?>index.php/partition/UpdateByaPrak">
                <div class="col-lg-12 alert alert-warning">
                    <p class="uni_text text-center">ভূমি আৰু ৰাজহ আইনৰ ১১৪ ধাৰা মতে বাটোৱাৰা গোচৰৰ পাব লগা খৰচ </p><br><br>
                    <p class="text-center uni_text">Petition Number <?php echo $details->petition_no; ?> / Case Number <?php echo $details->case_no; ?></p>
                </div>
                <div class="panel panel-info panel-form">
                    <?php //print_r($details); ?>           
                    <!----form start---->
                    <div class="form-group">
                        <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('payment_byapplicant') ?>: </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" readonly="" value="<?php echo $values->exp_details_total; ?>" name="" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('payment_byconsent') ?> : </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" readonly="" value="<?php echo $values->copdar_amt_total; ?>" name="" >
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $details->petition_no; ?>" name="petition_no" >
                <div class="panel-footer" style="margin-top: -20px">
                    <button class="btn btn-primary uni_text col-lg-offset-4" type="submit" name="submit" ><i class="fa fa-thumbs-up "></i> <?php echo $this->lang->line('payment_received') ?> </button>
                    <div class="btn btn-warning uni_text" id="backMain" ><i class="fa fa-thumbs-down "></i>  <?php echo $this->lang->line('payment_notreceived') ?> </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home/index";
    };
</script>
    
