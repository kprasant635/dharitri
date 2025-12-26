<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <table class="table table-striped table-bordered" width="100%">
                <tr class="active">
                    <td colspan="10" class="text-center"><h2><?php echo $this->lang->line('irrigated_and_non_irrigated_land_area');?>  <?php echo $this->lang->line('mouza');?> : <code>
                                <?php echo $namedata[3]->mouza; ?>

                            </code>

                        </h2>
                        <h3><?php echo $this->lang->line('agricultural_crop_land_area');?></h3>
                    </td>
                </tr>
                <tr class="success">
                    <td colspan="3" class="text-center"><h6><?php echo $this->lang->line('district');?> : <?php echo $namedata[0]->district; ?></h6></td>
                    <td colspan="4" class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <?php echo $namedata[1]->subdiv; ?></h6></td>
                    <td colspan="3" class="text-center"><h6><?php echo $this->lang->line('circle');?> : <?php echo $namedata[2]->circle; ?></h6></td>
                </tr>


                <tr class="danger">
                    <td colspan="5" class="text-center"><?php echo $this->lang->line('irrigated_land');?></td>
                    <td colspan="5" class="text-center"><?php echo $this->lang->line('non_irrigated_land');?></td>
                </tr>
                <tr class="success">
                    <td  class="text-center"><?php echo $this->lang->line('total_dags');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('bigha');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('katha');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('lesa');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('hec_are_care');?></td>

                    <td  class="text-center"><?php echo $this->lang->line('total_dags');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('bigha');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('katha');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('lesa');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('hec_are_care');?></td>

                </tr>
                <tr>
                    <td class="text-center" colspan="5">
                        <table class="table table-striped table-bordered" width="100%">
                            <?php
                            $irrow = count($crop);
                            if ($irrow > 0) {
                                foreach ($crop as $row):

                                    $bigha = $row->bigha;
                                    $katha = $row->katha;
                                    $lessa = $row->lessa;

                                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                                    $irrigated=$total_lessa;
                                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                                    ?>
                                    <tr class="danger">
                                        <td class="text-center" style="width:95px;"><?php echo $row->dag_no; ?></td>
                                        <td class="text-center" style="width:67px;">
                                    <?php
                                    echo $measure[0];
                                    ?>
                                        </td>
                                        <td class="text-center" style="width:67px;">
                                    <?php
                                    echo $measure[1];
                                    ?>
                                        </td>
                                        <td class="text-center"  style="width:60px;">
                                    <?php
                                    echo $measure[2];
                                    ?>
                                        </td>
                                        <td class="text-center" style="width:120px;">

                                    <?php
                                    echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                                    ?>
                                        </td>

                                    </tr>
                                    <?php
                                    endforeach;
                                    }
                            else {
                                ?>
                                <tr class="danger">
                                    <td colspan="5" style="color: red;text-align: center;"><?php echo $this->lang->line('no_records_found');?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td class="text-center" colspan="5">
                        <table class="table table-striped table-bordered" width="100%">
                            <?php
                            $nirrow = count($noncrop);
                            if ($noncrop > 0) {
                                foreach ($noncrop as $row1):
                                    $bigha = $row1->bigha;
                                    $katha = $row1->katha;
                                    $lessa = $row1->lessa;

                                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                                    $nonirrigated=$total_lessa;
                                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);

                                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                                    ?>
                                    <tr class="danger">
                                        <td class="text-center" style="width:95px;"><?php echo $row1->dag_no; ?></td>
                                        <td class="text-center" style="width:67px;">
                                            <?php
                                            echo $measure[0];
                                            ?>
                                        </td>
                                        <td class="text-center" style="width:67px;">
                                            <?php
                                            echo $measure[1];
                                            ?>
                                        </td>
                                        <td class="text-center"  style="width:60px;">
                                            <?php
                                            echo $measure[2];
                                            ?>
                                        </td>
                                        <td class="text-center" style="width:120px;">

                                            <?php
                                            echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                                            ?>

                                        </td>

                                    </tr>
                                <?php
                                endforeach;
                            }
                            else {
                                ?>
                                <tr class="danger">
                                    <td colspan="5" style="color: red;text-align: center;"><?php echo $this->lang->line('no_records_found');?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="10">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div id="chart1" style="min-height: 500"></div>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReport/";
    };
    $(document).ready(function(){
        var data = [
          ['Irrigated Land',<?php echo $irrigated ?>],['Non-Irrigated Land', <?php echo $nonirrigated; ?>]
        ];
        var plot1 = jQuery.jqplot ('chart1', [data], 
          { 
            seriesDefaults: {
              // Make this a pie chart.
              renderer: jQuery.jqplot.PieRenderer, 
              rendererOptions: {
                // Put data labels on the pie slices.
                // By default, labels show the percentage of the slice.
                showDataLabels: true
              }
            }, 
            legend: { show:true, location: 'e' }
          }
        );
      });
</script>