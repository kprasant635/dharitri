<?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>

<div class="col-lg-6 col-lg-offset-2">
    <div class="panel casedisplay">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular">Name Correction</p>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <tr>
                    <td>Pending Name Correction Proposals for Final Order</td>
                    <td>
                        <?php
                        if ($namecorrect_adc != '0') {
                            echo "<span class=\"badge badge-primary\">$namecorrect_adc</span>";
                        }
                        ?>
                    </td>
                    <td><a href="<?php echo base_url(); ?>index.php/NameCorrectionV2/adcPending" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                </tr>
            </table>
        </div>
    </div>
</div>