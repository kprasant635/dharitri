<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
 <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Allotment Certificate to PP</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Pending Case(s) Forwarded by CO 
									</td>
									<td>
                                        <?php
                                        if ($allote_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$allote_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/Allotment/passtobo" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr>
                                    <td>Pending Case(s) Forwarded by BO </td>
									<td>
                                        <?php
                                        if ($allote_dc_bo != '0') {
                                            echo "<span class=\"badge badge-primary\">$allote_dc_bo</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/Allotment/pendingfinalorder" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>