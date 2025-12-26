            <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
             <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_partition'); ?> </p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                <tr>
                                    <td colspan="2"><?php echo $this->lang->line('asstt_ofc_partition_reg'); ?></td>
                                    <td><a href="<?php echo base_url() . 'index.php/partition/mutation' ?>" class="text-danger" style='float:right'><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_noticegeneration_concerparty'); ?></td>
                                    <td>
                                        <?php
                                        if ($NoticeGen != '0') {
                                            echo "<span class=\"badge badge-primary\">$NoticeGen</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/getPendingNoticeGeneration'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('Notice_generation_clearing_payment'); ?></td>
                                    <td>
                                        <?php
                                        if ($PayNoticeGen != '0') {
                                            echo "<span class=\"badge badge-primary\">$PayNoticeGen</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/getPendingPayNoticeGeneration'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_confirmation_party'); ?></td>
                                    <td>
                                        <?php
                                        if ($byayPrak != '0') {
                                            echo "<span class=\"badge badge-primary\">$byayPrak</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/getPendingPayCases' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt'); ?></td>
                                    <td>
                                        <?php
                                        if ($ProceedingOrder != '0') {
                                            echo "<span class=\"badge badge-primary\">$ProceedingOrder</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/getPendingProceeReport'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_isthar_generate'); ?></td>
                                    <td>
                                        <?php
                                        if ($Isthar != '0') {
                                            echo "<span class=\"badge badge-primary\">$Isthar</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/getPendingIstharReport'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Regenerate Old Notice's</td>
                                    <td>    
                                    </td>
                                    <td><a class="pull-right red "  href="<?php echo base_url() . 'index.php/partition/old_notice'; ?>"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
								<tr>
                                    <td>Register New Partition Application from Online Services </td>
                                    <td> 
										<?php
                                        if ($CountPartitionOnline != '0') {
                                            echo "<span class=\"badge badge-primary\">$CountPartitionOnline</span>";
                                        }
                                        ?>									
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/serviceplus/office_partition_cases'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
               
        