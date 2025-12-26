<div class="row" style='margin-top:40px'>
    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
<div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_partition') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($FirstPro != '0') {
                                            echo "<span class=\"badge badge-primary\">$FirstPro</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/CoPendingFirst'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($SecondPro != '0') {
                                            echo "<span class=\"badge badge-primary\">$SecondPro</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/partition/CoPendingSecond'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>


                                <tr>
                                    <td><?php echo $this->lang->line('co_resume_case') ?></td>
                                    <td></td>
                                    <td><a class="pull-right green " href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?> </td>
                                    <td>
                                        <?php
                                        if ($proceedingPartRpt != '0') {
                                            echo "<span class=\"badge badge-primary\">$proceedingPartRpt</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/partition/ActionTakenRpt'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td>Office Partition</td>
                                    <td>
                                        <?php
                                        if ($partchithaupdate != '0') {
                                            echo "<span class=\"badge badge-primary\">$partchithaupdate</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/Partition/MapPartitionUpdate' ?>" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>