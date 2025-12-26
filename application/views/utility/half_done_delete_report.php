<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-form" style="min-height: 500px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold uni_text'><u>Sorry ( দুঃখিত )</u></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px; color:red;">
                            Unable to Delete the Case no.<?php echo $case; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <a href="<?php echo base_url(); ?>index.php/utility/delete_half_donecase_o" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>