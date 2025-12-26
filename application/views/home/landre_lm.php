
<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">LAND RECLASSIFICATION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                <tr>                                    
                                    <td>First Report by LM </td>
                                    <td>
                                        <?php
                                            if ($count != '0') {
                                                echo "<span class=\"badge badge-primary\">$count</span>";
                                            }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/LandReclassification/getPendingReclassCases' ?>" class="text-danger msg_reclass" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                            
                                </tr>
                                <?php } ?>
                                <tr>
                                    
                                    <td>Write Proposal for Land Reclassification </td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/LandReclassification/LMlocationSelect' ?>" class="text-danger msg_reclass" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                            
                                </tr>
                                <tr>
                                    <td>Modification of Chitha Report</td>
                                    <td>&nbsp;</td>
                                    <td><a href="<?php echo base_url() . 'index.php/LmEntryChitha/menulm' ?>" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Reverted Back From CO</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_returned_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_returned_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=11"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>New SUO MOTO Registration</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_returned_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_returned_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right red"  href="<?php echo base_url(); ?>index.php/SuomotoReclassification/LMlocationSelect"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>