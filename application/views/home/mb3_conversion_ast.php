<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_conversion') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
							 
                                <!-- <tr>
                                    <?php if(RTPS_CERT_ON_OFF!='1'){ ?>
                                    <td colspan="2"><?php echo $this->lang->line('asstt_ofc_conversion_reg') ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/Conversion" class="text-danger msg" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                <?php }?>
                                </tr>-->
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_noticegeneration_concerparty') ?></td>
                                    <td><?php
                                        if ($Pcases != '0') {
                                            echo "<span class=\"badge badge-primary\">$Pcases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/AsistantConversionMb/GoToAST?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt') ?></td>
                                    <td><?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/AsistantConversionMb/GoToAST?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_clear') ?></td>
                                    <td><?php
                                        if ($premium != '0') {
                                            echo "<span class=\"badge badge-primary\">$premium</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_ast?pro=3"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_confirm') ?></td>
                                    <td><?php
                                        if ($payment != '0') {
                                            echo "<span class=\"badge badge-primary\">$payment</span>";
                                        }
                                        ?>
                                    </td>
                                    <td ><a class="pull-right green " href="<?php echo base_url(); ?>index.php/go_to_ast?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="2">Regenerate Old Notice's</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/regenerate_notice" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr> -->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>