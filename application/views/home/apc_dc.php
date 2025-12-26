 <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">APPROVAL ON A. P. CANCELLATION</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write report on Cancellation Matter</td>
                                    <td><span class="badge badge-primary"><?php echo count($getDCAPCancellation); ?></span></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/APCancellation/DCAPStep1" style='float:right' class='green'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Generate Transmission files for Approved A.P. Cancellation Cases</td>
                                    <td><span class="badge" style="background:red;"></span></td>
                                    <td><a href="#" style='float:right'>GO</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
</div>