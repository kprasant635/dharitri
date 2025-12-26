



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
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=1"><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td> All Revarted Cases By DC</td>
                                    <td>
                                        <?php
                                        if ($rejected_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$rejected_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=5"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($conversion_proceeding_report != '0') {
                                            echo "<span class=\"badge badge-primary\">$conversion_proceeding_report</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Waiting For Chitha Updation</td>
                                    <td>
                                        <?php
                                        if ($third_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$third_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=6"><?php echo $this->lang->line('view') ?></a></td>
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
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/CoToLMFD?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Order Passed but Chitha Not Updated</td>
                                    <td></td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/penidngForChithaUpdate"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>