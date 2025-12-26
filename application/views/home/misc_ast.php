<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
 <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_misc_case') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                    <td><?php echo $this->lang->line('asstt_name_correction') ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/ASTStep1' ?>" class=" text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                <?php }?>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_object_petition_53a') ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/Objection/index' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                    <td><?php echo $this->lang->line('asstt_name_cancellation'); ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCancellation/ASTStep1' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                <?php }?>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_misc_case_notice') ?></td>
                                    <td>
                                        <?php
                                        if ($NameCorrectionNoticeGenerate != '0') {
                                            echo "<span class=\"badge badge-primary\">$NameCorrectionNoticeGenerate</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/ASTNoticeGenerate' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class='hide'>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt_misc_case') ?></td>
                                    <td>
                                        <?php
                                        if ($NameCorrectionActionTaken != '0') {
                                            echo "<span class=\"badge badge-primary\">$NameCorrectionActionTaken</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/ASTOrderSheet' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <?php if(ESCALATION_ENABLE == 1){  ?>
                                    <tr>
                                        <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt'); ?></td>
                                        <td>
                                            <?php
                                            if ($pactiontaken != '0') {
                                                echo "<span class=\"badge badge-primary\">$pactiontaken</span>";
                                            }
                                            ?>
                                        </td>
                                        <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/NameCancellation/getPendingactionTakenReport'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                    </tr>
                                <?php } ?>
                                 <tr>
                                    <td>Regenerate Old Notices</td>
                                     <td>
                                       <!-- <?php
                                         if ($NameCorrectionNoticeReGenerate != '0') {
                                         echo "<span class=\"badge badge-primary\">$NameCorrectionNoticeReGenerate</span>";
                                         }
                                         ?> -->
                                        </td>
                                     <td><a href="<?php echo base_url() . 'index.php/NameCorrection/ASTNoticeReGenerate' ?>" class=" text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                

                            </table>
                        </div>
                    </div>
                </div>