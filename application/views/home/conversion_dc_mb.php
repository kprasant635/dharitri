<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
<div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">RECLASSIFICATION / CONVERSION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                
                                <tr>
                                    <td>Conversion ( First Proceeding )</td>
                                    <td>
                                        <?php
                                        if ($first_proceeding_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/GoToDC?pro=1" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                
                                <tr>
                                    <td>Conversion ( Cases Pending at Department )</td>
                                    <td>
                                        <?php
                                        if ($dpt_proceeding_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$dpt_proceeding_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/GoToDC?pro=5" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Conversion ( Second Proceeding )</td>
                                    <td>
                                        <?php
                                        if ($second_proceeding_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$second_proceeding_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/GoToDC?pro=2" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Conversion ( Department Approved Cases )</td>
                                    <td>
                                        <?php
                                        if ($dpt_app_proceeding_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$dpt_app_proceeding_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/GoToDC?pro=6" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Conversion ( Cases Reverted from Department )</td>
                                    <td>
                                        <?php
                                        if ($dpt_revert_cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$dpt_revert_cases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/GoToDC?pro=7" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>


                                <?php if(PULL_BACK_CASES_AP_TO_PP_MB3 == 1): ?>
                                <tr>
                                    <td>Cases For Pull Back (Pending with Department)</td>
                                    <td>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/pullBackCasesFromDepartmentForDCApToPp" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <?php endif; ?>


                            </table>
                        </div>
                    </div>
                </div>