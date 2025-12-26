<div class="col-lg-6 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Appeal Case U/S 147</p>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td colspan="2">Register a Fresh Caase </td>
                                    <td><a href="<?php echo base_url() . 'index.php/Appealcase/register_step_1' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                
                                <tr>
                                    <td>Print Notice passed by DC</td>
                                    <td>
                                        <?php
                                        $apshowcause =0 ;//count($countAPCaseShowCauseForAST);
                                        if ($apshowcause != '0') {
                                            echo "<span class=\"badge badge-primary\">$apshowcause</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/AppealCase/PrintNoticeList'; ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr>
                                    <td>Submit Action Taken Report</td>
                                    <td>
                                        <?php
                                        $apshowcause = 0;//count($countAPCaseShowCauseForAST);
                                        if ($apshowcause != '0') {
                                            echo "<span class=\"badge badge-primary\">$apshowcause</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/AppealCase/ActionTakenList'; ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>