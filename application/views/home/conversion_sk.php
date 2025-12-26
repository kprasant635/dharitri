<div class="col-lg-6 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">OFFICE MUT / PART / CONV</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write Report on Office Mutation</td>
                                    <td>
                                        <?php
                                        if ($omutation != '0') {
                                            echo "<span class=\"badge badge-primary\" >$omutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=03' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Partition</td>
                                    <td>
                                        <?php
                                        if ($opartition != '0') {
                                            echo "<span class=\"badge badge-primary\" >$opartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=04' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Conversion </td>
                                    <td>
                                        <?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/SKconversionPartha/GoToSK?pro=1" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>