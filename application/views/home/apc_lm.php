<div class="col-lg-6 col-lg-offset-2">
    <div class="panel casedisplay">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular">ANNUAL PATTA CANCELLATION</p>
            </div>

        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <tr>
                    <td>Write Report on NR Cases</td>
                    <td><?php
                        $countAPCase = count($countAPCase);
                        if ($countAPCase != '0') {
                            echo "<span class=\"badge badge-primary\">$countAPCase</span>";
                        }
                        ?>
                    </td>
                    <?php
                    $link = base_url() . "index.php/APCancellation/LMAPRStep1";
                    ?>
                    <td><a href="<?php echo $link; ?>" class="green"
                            style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                </tr>
                <tr>
                    <td colspan="2">Write suo-Moto Report on NR Cases</td>

                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/LMAP" class="text-danger"
                            style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                </tr>

            </table>
        </div>


    </div>
</div>