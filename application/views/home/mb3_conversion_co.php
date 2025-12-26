
<div class="row" style='margin-top:40px'>


<?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
    
<div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_conversion') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($first_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url('index.php/go_to_co?pro=1'); ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($second_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$second_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Payment Declined by assistant</td>
                                    <td>
                                        <?php
                                        if ($ast_payment_declined != '0') {
                                            echo "<span class=\"badge badge-primary\">$ast_payment_declined</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=11"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>

                                <tr>
                                    <td>Waiting For Final Order/Chitha Update (Rural)</td>
                                    <td>
                                        <?php
                                        if ($rural_final_order != '0') {
                                            echo "<span class=\"badge badge-primary\">$rural_final_order</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=7"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td> All Reverted Cases By ADC/DC</td>
                                    <td>
                                        <?php
                                        if ($rejected_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$rejected_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=5"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td> ALL Circle Cases (Only for Missing File Upload)</td>
                                    <td>
                                        <?php
                                        if ($all_circle_cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$all_circle_cases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=8"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <!--
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($conversion_proceeding_report != '0') {
                                            echo "<span class=\"badge badge-primary\">$conversion_proceeding_report</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/go_to_co?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr> -->
                                <!-- <tr>
                                    <td>Waiting For Chitha Updation</td>
                                    <td>
                                        <?php
                                        if ($third_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$third_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/go_to_co?pro=6"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Bulk Forward to LM (1st Proceeding)</td>
                                    <td>
                                        <?php
                                        if ($first_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/co_bulk_forward_to_lra?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Order Passed but Chitha Not Updated</td>
                                    <td></td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/co_chitha_not_updated_cases"><?php echo $this->lang->line('view') ?></a></td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>