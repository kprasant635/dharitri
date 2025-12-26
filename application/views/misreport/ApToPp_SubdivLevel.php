<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class="col-lg-12">
        <div class='center'>
            <table class='table table-bordered'>
                <tr>
                    <td class="alert-new" rowspan="2" width='20%'>District Name</td>
                    <td class="alert-new" colspan="6">from A.P to P.P</td>
                </tr>
                <tr>
                    <td class="alert-new">Order Passed</td>
                    <td class="alert-new">Chitha Corrected</td>
                    <td class="alert-new">Total Patta Converted</td>
                    <td class="alert-new">Converted Area</td>
                    <td class="alert-new">Total Patta Yet to be Converted</td>
                    <td class="alert-new">Converted Area</td>
                </tr>
                <?php var_dump($subdiv_data);?>
                <?php foreach ($subdiv_data as $value): ?>
                <tr>
                    <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_CircletLevel?dist_code=<?php echo $this->session->userdata('dist_code'); ?>"><?php echo $name=$this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></a></td>
                    <td><?php //echo $value->order_passed; ?></td>
                    <td><?php //echo $value->chitha_corrected; ?></td>
                    <td><?php echo $value['total_patta']; ?></td>
                    <td><?php echo $value->total_bigha." B - ".$value->total_kotha." K - ".$value->total_lessa." L "; ?></td>
                    <td><?php echo $value->total_patta_l; ?></td>
                    <td><?php echo $value->total_bigha_l." B - ".$value->total_kotha_l." K - ".$value->total_lessa_l." L "; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>  
            
            <table class='table table-bordered'>
                <tr>
                    <td class="alert-new" rowspan="2" width='20%'>District Name</td>
                    <td class="alert-new" colspan="6">From Allotment Certificate to P.P</td>
                </tr>
                <tr>
                    <td class="alert-new">Order Passed</td>
                    <td class="alert-new">Chitha Corrected</td>
                    <td class="alert-new">Total Patta Converted</td>
                    <td class="alert-new">Converted Area</td>
                    <td class="alert-new">Allotment Certificate Yet to be Converted</td>
                    <td class="alert-new">Converted Area</td>
                    
                </tr>
                <tr>
                    <td><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/ApToPp_CircletLevel?dist_code=<?php echo $this->session->userdata('dist_code'); ?>"><?php echo $name=$this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></a></td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                    <td>14 B - 6 K - 9 L</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </table>
        </div>

        <br>
    </div>
    </div>

</div>
