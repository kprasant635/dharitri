    <?php if($user_desig_code == 'CO'): ?>
        <div class="col-lg-6 col-lg-offset-2">
            <div class="panel casedisplay">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"> Suo-moto Hydrocarbon Reclassification</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>Information on auto-reclassified cases</td>
                            <td>
                                <?php
                                if ($cases_no != '0') {
                                    echo "<span class=\"badge badge-primary\">$cases_no</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="pull-right green " href="<?php echo base_url() . 'index.php/HydrocarbonReclass/index'; ?>"><?php echo $this->lang->line('view') ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Pending Partition cum Reclassification Cases</td>
                            <td>
                                <?php
                                if ($casef_no != '0') {
                                    echo "<span class=\"badge badge-primary\">$casef_no</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="pull-right green " href="<?php echo base_url() . 'index.php/HydrocarbonReclass/partitionCases'; ?>"><?php echo $this->lang->line('view') ?></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
