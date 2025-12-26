<?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>
<div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Allotment Certificate to PP</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table hide table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_object_petition') ?></td>
                                    <td>&nbsp;</td>
                                    <td><a class="pull-right green "   href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write 1st Proceeding (Fresh)</td>
                                    <td>
                                        <?php
                                        if ($allotment_first != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_first</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "   href="<?php echo base_url() . 'index.php/allotment/copendingfirstlist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write 2nd Proceeding</td>
                                    <td>
                                        <?php
                                        if ($allotment_second != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_second</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"   href="<?php echo base_url() . 'index.php/allotment/copendingseclist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Proceeding Report of All Case(s)</td>
                                    <td>&nbsp;</td>
                                    <td><a class="pull-right green" href="<?php echo base_url() . 'index.php/allotment/proceeding' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Update AC to PP Passed By DC </td>
                                    <td>
                                        <?php
                                        if ($allotment_final != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_final</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/allotment/cofinalpendingcase' ?>"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Bulk Forward to LM 1st Proceeding (Fresh)</td>
                                    <td>
                                        <?php
                                        if ($allotment_first != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_first</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "   href="<?php echo base_url() . 'index.php/allotment/coBulkFDAPTOPP' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>