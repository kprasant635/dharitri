<div class="row login" style='margin-top:40px'>
    
<?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
                
                <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                
                                




                                <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">MISCELLANEOUS & FIELD VISITS DATA</td>
                                    <td></td>
                                </tr>

                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                <tr>
                                    <td>Write Report on Escalated Miscellaneous Cases</td>
                                    <td><?php
                                        $countMiscCaseEscalation = count($countMiscCaseEscalation);
                                        if ($countMiscCaseEscalation != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseEscalation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrectionV2/LMEscStep1' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            <?php }?>
                                
                                <tr>
                                    <td>Write Report on Miscellaneous Cases</td>
                                    <td><?php
                                        $countMiscCase = count($countMiscCase);
                                        if ($countMiscCase != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCase</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/LMStep1' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Citizen Centric Applications</td>
                                    <td></td>
                                    <td><a href="#" class="green" style="float:right">view</a></td>
                                </tr>

                                <tr>
                                    <td>Write Proposal for Land Reclassification </td>
                                    <td></td>
                                    <td><a href="<?php echo base_url() . 'index.php/LandReclassification/LMlocationSelect' ?>" class="text-danger msg_reclass hide" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Modification of Chitha Report</td>
                                    <td>&nbsp;</td>
                                    <td><a href="<?php echo base_url() . 'index.php/LmEntryChitha/menulm' ?>" class="text-danger hide" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Write Report on Reverted Name Correction Cases</td>
                                    <td>
                                        <?php
                                        $countMiscCaseRevert = count($countMiscCaseRevert);
                                        if ($countMiscCase != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseRevert</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrection/LMStepRe' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Write Report on Reverted Name Cancellation Cases</td>
                                    <td>
                                        <?php
                                        $countMiscCaseRevertNC = count($countMiscCaseRevertNC);
                                        if ($countMiscCaseRevertNC != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseRevertNC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCancellation/LMStepRe' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                <tr>
                                    <td>Write Report on Escalated Reverted Name Correction Cases</td>
                                    <td><?php
                                        $countMiscCaseRevertEsc = count($countMiscCaseRevertEsc);
                                        if ($countMiscCaseRevertEsc != '0') {
                                            echo "<span class=\"badge badge-primary\">$countMiscCaseRevertEsc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/NameCorrectionV2/LMStepReEsc' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            <?php }?>

                            </table>
                        </div>
                    </div>
                </div>
				
</div>