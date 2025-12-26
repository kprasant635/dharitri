<?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>


 <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_misc_case') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <?php if(ESCALATION_ENABLE == 1){?>

                                <tr>
                                    <td>Pending Escalated Name Correction</td>
                                    <td><?php
                                        $countMiscCaseEscalation = count($countMiscCaseEscalation);
                                        if ($countMiscCaseEscalation != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseEscalation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrectionV2/COEscStep1' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            <?php }?>
                                <tr>
                                    <td>Pending Name Correction</td>
                                    <td>
                                        <?php
                                        if ($MisCases != '0') {
                                            echo "<span class=\"badge badge-primary\">$MisCases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/NameCorrection/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending Name Cancellation</td>
                                    <td>
                                        <?php
                                        if ($MisCasesNC != '0') {
                                            echo "<span class=\"badge badge-primary\">$MisCasesNC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/NameCancellation/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_objectpetition') ?></td>
                                    <td>
                                        <?php
                                        if ($pending_objection != '0') {
                                            echo "<span class=\"badge badge-primary\">$pending_objection</span>";
                                        }
                                        ?></td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/objection/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                               <!--  <tr>
                                    <td><?php echo $this->lang->line('co_misc_finalorder') ?></td>
                                    <td>
                                        <?php
                                        $FOMIS = count($FinalOrderMisc);
                                        if ($FOMIS != '0') {
                                            echo "<span class=\"badge badge-primary\">$FOMIS</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/NameCorrection/COFinalOrderMiscCase1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr> -->
                                <tr>
                                    <td>Final order of Name correction</td>
                                    <td>
                                        <?php
                                        $FOMIS = count($FinalOrderMisc);
                                        if ($FOMIS != '0') {
                                            echo "<span class=\"badge badge-primary\">$FOMIS</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/NameCorrection/COFinalOrderMiscCase1/06' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Final order for Name Cancellation</td>
                                    <td>
                                        <?php
                                        $FOMIS = count($FinalOrderMiscDel);
                                        if ($FOMIS != '0') {
                                            echo "<span class=\"badge badge-primary\">$FOMIS</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/NameCancellation/COFinalOrderMiscCase1/07' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                <tr>
                                    <td>Write Report on Escalated Reverted Name Correction Cases</td>
                                    <td><?php
                                        $countMiscCaseRevertEsc = count($countMiscCaseRevertEsc);
                                        if ($countMiscCaseRevertEsc != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseRevertEsc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrectionV2/COEscStep1Rvt' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            <?php }?>
                            </table>
                        </div>
                    </div>
                </div>