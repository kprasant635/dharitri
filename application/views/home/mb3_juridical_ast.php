<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo NJS_TAGLINE; ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
							 
                             
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_noticegeneration_concerparty') ?></td>
                                    <td><?php
                                        if ($Pcases != '0') {
                                            echo "<span class=\"badge badge-primary\">$Pcases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/GoToAST?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_actiontakenRpt') ?></td>
                                    <td><?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/GoToAST?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>