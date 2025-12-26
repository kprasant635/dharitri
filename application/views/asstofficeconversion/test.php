<div class="row login panel-form" style="min-height: 500px;">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u>Thank You ( ধন্যবাদ ).</u></span></p>
                </div>
                <div class="col-lg-6 uni_text"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?> </div>
                <div class="col-lg-6 uni_text"><span style="float:right;"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></div>
                <hr style="border-bottom: 2px solid #000;">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="rasid table">
                            <tr>
                                <td style="text-align: center;"><label class="control-label uni_text red"> <?php echo $case_no; ?> নং গোচৰ ম্যাদীকৰণ পঞ্জীকৰণ প্রক্রিয়া সম্পূর্ণ হ'ল ।</label></td>
                            </tr>
                            <tr>
                                <td style="text-align: center; font-size: 28px;">The Registration Process for Land Conversion By Assistant (to CO) Completed.</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <a href="<?php echo base_url();?>index.php/home/" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
