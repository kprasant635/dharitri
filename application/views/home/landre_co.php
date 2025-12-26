
<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('land_reclassification') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_reclass_recommen') ?></td>
                                    <td>
                                        <?php
                                        if ($land_proposals != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="hide">
                                    <td><?php echo $this->lang->line('co_reclass_dc_adc_approve') ?></td>
                                    <td>
                                        <?php
                                        if ($g_trans_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$g_trans_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Reverted Back From DC / ADC</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_returned_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_returned_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=6"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending For Jamabandi Updation</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_for_jamaupdate != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_for_jamaupdate</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=7"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Pending Applications for Suomoto-Reclass</td>
                                    <td>
                                        <?php
                                        if ($suomoto_reclass != '0') {
                                            echo "<span class=\"badge badge-primary\">$suomoto_reclass</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/SuomotoReclassification/GoToRE?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Chitha Updation for Suomoto-Reclass</td>
                                    <td>
                                        <?php
                                        if ($cusuomoto_reclass != '0') {
                                            echo "<span class=\"badge badge-primary\">$cusuomoto_reclass</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/SuomotoReclassification/updateChitha"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>