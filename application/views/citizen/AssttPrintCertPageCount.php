<div class="container-fluid form-top login">
    <div class='row'>
        
    </div>        
</div> 
<div id="boxes">
    <div id="dialog" class="window">
        
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <p class="uni_text">
                        <span class="pull-left"><?php echo $this->utilityclass->getCertName($certDtls->cert_type); ?></span>
                        <span class="pull-right"><?php echo $this->lang->line('sr_no'); ?>:<?php echo $certDtls->cert_no; ?></span>
                    </p>
                    <?php //var_dump($users); ?>
                    <hr>
                    <p class='uni_text red center'>Please enter the number of pages after printout.</p>
                    <div class="col-lg-12 update ">
                        <div class="alert alert-info">
                            <form class="form-horizontal unicode" action="<?php echo base_url(); ?>index.php/CitizenController/UpdateJamaBondi" method="POST">

                                <legend class="uni_text"><?php echo $this->lang->line('confirm_if_generated') ?></legend>
                                <div class="col-lg-6 ">
                                    <label class="" for="exampleInputAmount">Number Of Pages</label>
                                    <input type="number" id='num_page' class="form-control col-lg-3" name="number_of_pages" required placeholder="No. of Pages">
                                </div>
                                <div class="col-lg-6">
                                    <label class="" for="exampleInputAmount">Amount (in Rupees)</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="text" class="form-control" name='fee_amt' readonly id='fees' required placeholder="Amount">
                                        <div class="input-group-addon">.00</div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group col-lg-offset-4">
                                    <button type="submit" id="button" class="btn btn-danger col-lg-offset-4">Print Payment Reciept</button>
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
<script>
    $('#num_page').keyup(function () {
        if ($("#num_page").val() == "0")
        {
            alert("Please type number of pages");
            var fees = 20;
            $('#fees').val(fees);
            $('#button').prop('disabled', true);
            return false;
        }

        if ($(this).val().length == 0) {
            $('#button').prop('disabled', true);
        } else {
            $('#button').prop('disabled', false);
            var fees = 0;
            var num_page = parseInt($('#num_page').val()) || 0;
            var count = num_page - 1;
            var fees = count * 10 + 20;
            $('#fees').val(fees);
        }
    });
    $('#button').prop('disabled', true);
    $('.clickenable').click(function () {
        $('#button').prop('disabled', false);

    });
</script>
