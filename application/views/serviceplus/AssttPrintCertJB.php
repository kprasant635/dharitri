<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <p class="uni_text">
                        <span class="pull-left"><?php echo $this->utilityclass->getCertName($certDtls->cert_type); ?></span>
                        <span class="pull-right"><?php echo $this->lang->line('sr_no'); ?>:<?php echo $certDtls->cert_no; ?></span>
                    </p>
                    <?php //var_dump($users); ?>
                    <hr>
                    <div class="col-lg-6 update">
                        <div class="alert alert-info" style="min-height: 160px;">
                            <form class="form-inline" action="<?php echo base_url(); ?>index.php/CitizenController/saveJamabandi" method="POST" >
                                <legend class="uni_text text-center"><?php echo $this->lang->line('print_jamabandi_generated'); ?><br>&nbsp;</legend>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success clickenable col-lg-offset-4" name="Submit">Please Click here to <?php echo $this->lang->line('generate_jamabandi') ?></button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="cert_no" >
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="alert alert-info" style="min-height: 160px;">
                            <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/CitizenController/pendingJamaBondi" method="POST">
                                <legend class="uni_text"><?php echo $this->lang->line('keeping_pending_reason'); ?> </legend>
                                <div class="form-group col-lg-offset-4">
                                    <button type="submit" class="btn btn-success col-lg-offset-4"><?php echo $this->lang->line('reason_keep_pending'); ?></button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" />
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
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
