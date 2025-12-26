
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
                                    <td>Pending Reclassification Proposals.</td>
                                    <td>
                                        <?php
                                        if ($recommended_reclassification_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$recommended_reclassification_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=3" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Reverted Reclassification Proposals.</td>
                                    <td>
                                        <?php
                                        if ($reverted_reclassification_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$reverted_reclassification_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=8" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Conversion ( First Proceeding )</td>
                                    <td>
                                        <?php
                                        if ($first_proceeding_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=3" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=1" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=5" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=7" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=6" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Pending Suo-moto Reclassification Proposals.</td>
                                    <td>
                                        <?php
                                        if ($suomoto_reclass != '0') {
                                            echo "<span class=\"badge badge-primary\">$suomoto_reclass</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/GoToRE?pro=3" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>