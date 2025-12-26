<div class="col-lg-6 col-lg-offset-2">
    <div class="panel casedisplay">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular"><?php echo $this->lang->line('asstt_annual_patta_canc') ?> </p>
            </div>

        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <tr>
                    <td colspan="2"><?php echo $this->lang->line('asstt_annual_patta_canc_reg') ?> </td>
                    <td><a href="<?php echo base_url() . 'index.php/APCancellation/AST' ?>" class="text-danger"
                            style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                </tr>

                <tr>
                    <td><?php echo $this->lang->line('asstt_show_case_notice') ?> </td>
                    <td>
                        <?php
                        $apshowcause = count($countAPCaseShowCauseForAST);
                        if ($apshowcause != '0') {
                            echo "<span class=\"badge badge-primary\">$apshowcause</span>";
                        }
                        ?>
                    </td>
                    <td><a href="<?php echo base_url() . 'index.php/APCancellation/ASTAPShowCauseStep1'; ?>"
                            class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                </tr>

                <tr>
                    <td><?php echo $this->lang->line('regenerate_notice') ?> </td>
                    <td>

                    </td>
                    <td><a href="<?php echo base_url() . 'index.php/APCancellation/regenerateOldNotice'; ?>"
                            class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                </tr>
            </table>
        </div>
    </div>
</div>