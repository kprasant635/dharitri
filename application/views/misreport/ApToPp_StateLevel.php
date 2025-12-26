<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
            <div class='center'>
                <table class='table table-bordered'>
                    <tr>
                        <td class="alert-new" rowspan="2" width='20%'>District Name</td>
                        <td class="alert-new" colspan="6">from A.P to P.P</td>
                        <td class="alert-new" rowspan="2">View District Wise Data</td>
                    </tr>
                    <tr>
                        <td class="alert-new">Order Passed</td>
                        <td class="alert-new">Chitha Corrected</td>
                        <td class="alert-new">Total Patta Converted</td>
                        <td class="alert-new">Converted Area</td>
                        <td class="alert-new">Total Patta Yet to be Converted</td>
                        <td class="alert-new">Converted Area</td>
                    </tr>
                    <?php
                    foreach ($result as $row1) {
                        ?>
                        <tr>
                            <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_DistrictLevel?dist_code=<?php echo $row1['dist_code']; ?>"><?php echo $name = $this->utilityclass->getDistrictNamebydbload($row1['dist_code']); ?></a></td>
                            <td><?php echo $row1['order_passesd']->count; ?></td>
                            <td><?php echo $row1['chitha_corrected']->count; ?></td>
                            <td><?php echo $row1['total_patta']; ?></td>
                            <td><?php echo $row1['total_bigha'] . " B - " . $row1['total_bigha'] . " K - " . $row1['total_bigha'] . " L"; ?></td>
                            <td><?php echo $row1['total_patta_l']; ?></td>
                            <td><?php echo $row1['total_bigha_l'] . " B - " . $row1['total_bigha_l'] . " K - " . $row1['total_bigha_l'] . " L"; ?></td>
                            <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_DistrictLevel?dist_code=<?php echo $row1['dist_code']; ?>" class="btn btn-danger">
                                    <?php echo $this->lang->line('view'); ?>&nbsp;<i class="fa fa-arrow-right"></i>
                                </a></td>
                        </tr>
                    <?php } ?>
                </table>  

                <table class='table table-bordered'>
                    <tr>
                        <td class="alert-new" rowspan="2" width='20%'>District Name</td>
                        <td class="alert-new" colspan="6">From Allotment Certificate to P.P</td>
                        <td class="alert-new" rowspan="2">View District Wise Data</td>
                    </tr>
                    <tr>
                        <td class="alert-new">Order Passed</td>
                        <td class="alert-new">Chitha Corrected</td>
                        <td class="alert-new">Total Patta Converted</td>
                        <td class="alert-new">Converted Area</td>
                        <td class="alert-new">Allotment Certificate Yet to be Converted</td>
                        <td class="alert-new">Converted Area</td>

                    </tr>
                    <?php 
                    foreach ($result as $row1) {
                        ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_DistrictLevel?dist_code=<?php echo $row1['dist_code']; ?>"><?php echo $name = $this->utilityclass->getDistrictNamebydbload($row1['dist_code']); ?></a></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0 B - 0 K - 0 L</td>
                        <td>0</td>
                        <td>0 B - 0 K - 0 L</td>
                        <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_DistrictLevel?dist_code=<?php echo $row1['dist_code']; ?>" class="btn btn-danger">
                                    <?php echo $this->lang->line('view'); ?>&nbsp;<i class="fa fa-arrow-right"></i>
                            </a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <br>
        </div>
    </div>

</div>