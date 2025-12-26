 <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">A.P CANCELLATION & MISC CASES</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write NOTE on NR Cases</td>
                                    <td><?php
                                        $countAPCaseforSK = count($countAPCaseforSK);
                                        if ($countAPCaseforSK != '0') {
                                            echo "<span class=\"badge badge-primary\">$countAPCaseforSK</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/SKAPStep1" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Misc Cases</td>
                                    <td>
                                        <?php
                                        $countMissCaseforSK = count($countMiscCaseSK);
                                        if ($countMissCaseforSK != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMissCaseforSK</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/SKStep1' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>