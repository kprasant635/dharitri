
<div class="col-lg-6 col-lg-offset-1">

                    <div class="panel casedisplay" id="citizen_div">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">CITIZEN CENTRIC CERTIFICATE</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Verify Pending Application & Forward to CO</td>
                                    <td><?php
                                        if ($CitizenCentric != '0') {
                                            echo "<span class=\"badge badge-primary\">$CitizenCentric</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/CitizenController/LMStep1" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
				
</div>