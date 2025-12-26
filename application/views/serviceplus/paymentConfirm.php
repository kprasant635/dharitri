<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <?php  if($status[0]->status=='FP'){ ?>
			<form class="form-horizontal unicode" method="POST" action="<?php echo base_url(); ?>index.php/serviceplus/ConfirmPayment">
                <div class="col-lg-12 alert alert-warning">
                    <p class="uni_text text-center">ভূমি আৰু ৰাজহ আইনৰ ১১৪ ধাৰা মতে বাটোৱাৰা গোচৰৰ পাব লগা খৰচ </p><br><br>
                    <p class="text-center uni_text">Petition Number <?php echo $payment->petition_no; ?> / Case Number <?php echo $payment->case_no; ?></p>
                </div>
                <div class="panel panel-info panel-form">
                    <?php // var_dump($status); ?>           
                    <!----form start---->
					
                    <div class="form-group">
                        <label for="select" class="col-sm-4 control-label">Payment Confirmed on RTPS Portal </label>                      
                    </div>
                </div>
                <input type="hidden" value="<?php echo $payment->petition_no; ?>" name="petition_no" >
                <div class="panel-footer" style="margin-top: -20px">
                    <button class="btn btn-primary uni_text col-lg-offset-4" type="submit" name="submit" ><i class="fa fa-thumbs-up "></i> <?php echo $this->lang->line('payment_received') ?> </button>
                    <div class="btn btn-warning uni_text" id="backMain" ><i class="fa fa-thumbs-down "></i>  <?php echo $this->lang->line('payment_notreceived') ?> </div>
                </div>
            </form>
				<?php 
                }else {			
					?>
					<div class="col-lg-12 alert alert-warning">
                    <p class="uni_text text-center">ভূমি আৰু ৰাজহ আইনৰ ১১৪ ধাৰা মতে বাটোৱাৰা গোচৰৰ পাব লগা খৰচ </p><br><br>
                    <p class="text-center uni_text">Petition Number <?php echo $payment->petition_no; ?> / Case Number <?php echo $payment->case_no; ?></p>
					<h3 class='red'>Byayprak payment not received yet. Please pay through RTPS portal.</h3>
					</div>
				<?php  }?>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home/index";
    };
</script>
    
