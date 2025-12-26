 <div class="col-lg-6">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_misc_case') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_name_correction') ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/ASTStep1' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_object_petition_53a') ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/Objection/index' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_name_cancellation'); ?></td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCancellation/ASTStep1' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
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
                                <tr>
                                    <td colspan="2">Allotment Certificate to PP</td>
                                    <td><a href="<?php echo base_url() . 'index.php/Allotment/index' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>