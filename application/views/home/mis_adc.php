<div class="col-lg-6 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">MIS REPORTS</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Dispose and Pending Cases - At a Glance</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeGalanceDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Dispose and  Pending Cases - For a Particular Period</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForPPDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Cases Pending more than 2-3 months</td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForMonthsDCLAO" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Monthly Account of - Mutation / Partition / Conversion Cases </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/MisReportController1/MonthlyAccMutPartConv_REV" class='green' style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>