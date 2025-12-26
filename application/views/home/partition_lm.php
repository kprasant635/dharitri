<div class="row login" style='margin-top:40px'>
<div class="col-lg-2">
</div>

                <div class="col-lg-6" >
                    <div class="panel casedisplay">
                       
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">OFFICE PARTITION</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Partition</td>
                                    <td><?php
                                        if ($ofcPartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$ofcPartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficePartitionCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Byay Prak Kalan (Office Partition)</td>
                                    <td><?php
                                        if ($ofcByayPrak != '0') {
                                            echo "<span class=\"badge badge-primary\">$ofcByayPrak</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficeByayPrakCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Co-Pattadar Consent (Partition)</td>
                                    <td><?php
                                        if ($ConsentPattadar != '0') {
                                            echo "<span class=\"badge badge-primary\">$ConsentPattadar</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/partition/ConsentPendingCase" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending Case(s) for Map Partition</td>
                                    <td><?php
                                        if ($mappartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$mappartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/partition/MapPartPendingCase" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
				
				
</div>