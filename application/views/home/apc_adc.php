  <div class="col-lg-4 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">APPROVAL ON A. P. CANCELLATION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write report on Cancellation Matter</td>
                                    <td>
                                        <?php
                                        $getDCAP = count($getDCAPCancellation);
                                        if ($getDCAP != '0') {
                                            echo "<span class=\"badge badge-primary\">$getDCAP</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/DCAPStep1" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>