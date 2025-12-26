 <div class="col-lg-6 col-lg-offset-2">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Trace Map Cases</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                              <!--   <tr>
                                    <td>Pending Trace Map request</td>
                                    <td>
                                    <?php
                                        if ($MisCases != '0') {
                                            //echo "<span class=\"badge badge-primary\">$MisCases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php// echo base_url() . 'index.php/Tracemap/COstep1' ?>"><?php //echo $this->lang->line('view') ?></a></td>
                                </tr> -->
                                
                                
                                 <tr>
                                    <td>Trace Map Request for Final Order</td>
                                    <td>
                                       <?php
                                        if ($MisCasesF != '0') {
                                            echo "<span class=\"badge badge-primary\">$MisCasesF</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/Tracemap/COFinalorder' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>