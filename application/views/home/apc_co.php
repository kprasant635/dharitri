<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_annual_patta_canc') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_non_renewal_proceeding') ?></td>
                                    <td>
                                        <?php
                                        $CAPCOC = count($countAPCaseforCO);
                                        if ($CAPCOC != '0') {
                                            echo "<span class=\"badge badge-primary\">$CAPCOC</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_recom_nrcase') ?></td>
                                    <td>
                                        <?php
                                        $CNH = count($countNoteHearingAPCaseforCO);
                                        if ($CNH != '0') {
                                            echo "<span class=\"badge badge-primary\">$CNH</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep2_1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_ap_orderpass') ?></td>
                                    <td>
                                        <?php
                                        $GOAPC = count($getOrderAPCancellation);
                                        if ($GOAPC != '0') {
                                            echo "<span class=\"badge badge-primary\">$GOAPC</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep4_1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>

                                </tr>

                            </table>
                        </div>
                    </div>
                </div>