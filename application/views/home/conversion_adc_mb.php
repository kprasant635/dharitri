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
                                        if ($first_proceeding_for_adc != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding_for_adc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/AdcConversionMb/GoToDC_ADC?pro=4" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Conversion ( Second Proceeding )</td>
                                    <td>
                                        <?php
                                        if ($second_proceeding_for_adc != '0') {
                                            echo "<span class=\"badge badge-primary\">$second_proceeding_for_adc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/AdcConversionMb/GoToDC_ADC?pro=2" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                

                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_clear') ?></td>
                                    <td><?php
                                        if ($premium != '0') {
                                            echo "<span class=\"badge badge-primary\">$premium</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/AdcConversionMb/adcPaymentConfirmation?pro=3"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_confirm') ?></td>
                                    <td><?php
                                        if ($payment != '0') {
                                            echo "<span class=\"badge badge-primary\">$payment</span>";
                                        }
                                        ?>
                                    </td>
                                    <td ><a class="pull-right green " href="<?php echo base_url(); ?>index.php/AdcConversionMb/adcPaymentConfirmation?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                               
                                <!--<tr>
                                    <td colspan="2">Regenerate Old Notice's</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/AdcConversionMb/regenerate_notice" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>-->
                            </table>
                        </div>
                    </div>
                </div>