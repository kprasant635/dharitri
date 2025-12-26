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
                                    <td>Branch Officer Report On PP</td>
                                    <td><?php
                                        if ($allote_bo != '0') {
                                            echo "<span class=\"badge badge-primary\">$allote_bo</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/Allotment/bopending"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('asstt_ofc_con_premium_clear') ?></td>
                                    <td><?php
                                        if ($premium != '0') {
                                            echo "<span class=\"badge badge-primary\">$premium</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBo?pro=3"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Regenerate Old Notice's</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/regenerate_notice" class="text-danger" style="float:right"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>