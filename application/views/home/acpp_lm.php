<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>

<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Allotment Certificate to PP</p>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on AC to PP cases</td>
                                    <td><?php
                                        if ($allotment_lm != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_lm</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/Allotment/lmpending";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								
                                <tr>
                                    <td>Report on Correction Of Land Records as per Civil Court</td>
                                    <td><?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/LMFirstOrder";
                                    ?>
                                    <td><a href="<?php echo $link; ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>


                    </div>
                </div>