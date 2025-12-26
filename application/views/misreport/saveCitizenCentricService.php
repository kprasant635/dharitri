<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <?php
           $month_name = $this->utilityclass->getMonth($namedata['month']);
            ?>
            <div class="alert alert-info" role="alert">
				<h2 class='uni_text' style="text-align: center; color: #2e4d8e"> Monthly Statement on Citizen Centric Services </h2>
                <h4><?php echo $this->lang->line('district');?> : <kbd><kbd><?php echo $namedata[0]->district; ?></kbd></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <kbd><?php echo $namedata[1]->subdiv; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $namedata[2]->circle; ?></kbd> <?php echo $this->lang->line('year');?> : <code><?php echo $namedata['year'];  ?></code> <?php echo $this->lang->line('month');?> : <code><?php echo $month_name;  ?></code></h4>
            </div>
            <?php 
            $tot_case = 0;
            $tot_amt = 0; //print_r($query);  
            ?>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="center info">
                        <th><?php echo $this->lang->line('sl_no');?> </th>
                        <th><?php echo $this->lang->line('certificate_type');?></th>
                        <th><?php echo $this->lang->line('no_of_application');?></th>
                        <th><?php echo $this->lang->line('fee_per_copy');?></th>
                        <th><?php echo $this->lang->line('total_amount_received');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($query as $row):
                        ?>
                        <tr class="center">
                            <td><?php echo $i; ?></td><td><?php echo $row['cert_name']; ?></td><td><?php echo $row['cases']; ?></td><td><?php echo number_format($row['fee'],2); ?></td><td><?php echo number_format( $row['t_amt'],2); ?></td>
                        </tr>
                        <?php
                        $tot_amt = $tot_amt + $row['t_amt'];
                        $tot_case = $tot_case + $row['cases'];
                        $i++;
                        ?>
                    <?php endforeach; ?>
                    <tr class="success">
                        <td colspan="2" class="center">Grand Total</td>
                        <td class="center"><?php echo $tot_case; ?></td>
                        <td></td>
                        <td class="center"><?php echo number_format($tot_amt,2); ?></td>
                    </tr>
                <td class="text-center" colspan="9">
                    <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-10 col-lg-offset-3" >
    <div class="row " id="piegraph">
        <div class="col-lg-6 col-lg-offset-2"  id="Graph" style="min-height: 500px;margin: 0;padding: 0; border: none"></div>

    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/MonthlyCitizenCentricService' ?>";
    };
    $(document).ready(function(){
                       jQuery.jqplot.config.enablePlugins = true;
                            plot1 = jQuery.jqplot('Graph', 
								
                                [[      <?php foreach ($query as $row) : ?>
                                        ['<?php echo $row['cert_name']; ?>', <?php echo $row['cases']; ?>],
                                        <?php endforeach; ?>
                                ]], 
                                {
                                    title: 'Statement of Monthly Amount Received for Cityzen Centric Service ', 
                                    seriesDefaults: {
								seriesColors:['#D011ED', '#E80422', '#1707FA', '#FAF445', '#17A617', '#958c12', '#953579', '#4b5de4', '#d8b83f', '#ff5800', '#0085cc', '#c747a3', '#cddf54', '#FBD178', '#26B4E3', '#bd70c7'],
                                shadow: true, 
                                renderer: jQuery.jqplot.PieRenderer, 
                                rendererOptions: { padding: 2, sliceMargin: 1, showDataLabels: true } 
                              }, 
                                    legend: { renderer:jQuery.jqplot.EnhancedLegendRenderer,show:true, location: 'e'}
                                }
                            );
                    });
</script>
