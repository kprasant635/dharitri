<div class="container-fluid login form-top"> 
    <div class="row">
        <div class="alert col-lg-10 col-lg-offset-1 alert-success" role="alert">
					<h2 class="center"><?php echo $this->lang->line('statement_of_yearly_amount_received_for_citizen_centric_services');?></h2>
					<h5 class="center"><?php echo $this->lang->line('district');?> : <kbd><?php echo $namedata[0]->district; ?></kbd> <?php echo $this->lang->line('subdivision');?> : <kbd><?php echo $namedata[1]->subdiv; ?></kbd>  <?php echo $this->lang->line('circle');?> : <kbd><?php echo $namedata[2]->circle; ?></kbd> <?php echo $this->lang->line('year');?> : <code><?php echo $namedata['year'];  ?> </code></h5>
			</div>
        
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
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
                    $tot_case = 0;
                    $tot_amt = 0; 
                    $i = 1;
                    foreach ($query as $row):
                        ?>
                        <tr class="center">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['cert_name']; ?></td>
                            <td><?php echo $row['cases']; ?></td>
                            <td><?php echo number_format($row['fee'],2); ?></td>
                            <td><?php echo number_format( $row['t_amt'],2); ?></td>
                        </tr>
                        <?php
                        $tot_amt = $tot_amt + $row['t_amt'];
                        $tot_case = $tot_case + $row['cases'];
                        $i++;
                        ?>
                    <?php endforeach; ?>
                    <tr class="center danger">
                        <td></td><td><?php echo $this->lang->line('total');?></td><td><?php echo $tot_case; ?></td><td></td><td><?php echo number_format($tot_amt,2); ?></td>
                    </tr>
                    
                    <td class="text-center" colspan="9">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
                </tbody>
            </table>
			
            <div class="col-lg-10 col-lg-offset-2 " id="piegraph">
                <div class="col-lg-9 "  id="Graph" style="min-height: 500px;margin: 0;padding: 0"></div>
            </div>
        </div>
    
    </div>
</div>

    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/MisReport/MonthlyCitizenCentricServiceYearly' ?>";
        };
        
        
        $(document).ready(function(){
                       jQuery.jqplot.config.enablePlugins = true;
                            plot1 = jQuery.jqplot('Graph', 
                                [[      <?php foreach ($query as $row) : ?>
                                        ['<?php echo $row['cert_name']; ?>', <?php echo $row['cases']; ?>],
                                        <?php endforeach; ?>
                                ]], 
                                {
                                    title: 'Statement of Yearly Amount Received for Cityzen Centric Service ', 
                                    seriesDefaults: {
                                shadow: false, 
                                renderer: jQuery.jqplot.PieRenderer, 
                                rendererOptions: { padding: 2, sliceMargin: 1, showDataLabels: true } 
                              }, 
                                    legend: { renderer:jQuery.jqplot.EnhancedLegendRenderer,show:true, location: 'e'}
                                }
                            );
                    });
    </script>
