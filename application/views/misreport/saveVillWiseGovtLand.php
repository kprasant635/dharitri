<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10  panel panel-default panel-body  col-lg-offset-1">
            <div class="alert alert-success text-center" role="alert">
                <h4>Government Land Area for Villlage : <code><?php echo $namedata[4]->village; ?></code></h4>
            </div>
            <div class="alert alert-info text-center" role="alert">
                <h4><?php echo $this->lang->line('district') ?> : <code><?php echo $namedata[0]->district; ?></code> 
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision') ?> : <code><?php echo $namedata[1]->subdiv; ?></code> 
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle'); ?> : <code><?php echo $namedata[2]->circle; ?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('mouza'); ?> : <kbd><?php echo $namedata[3]->mouza; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('lot_no'); ?> : <kbd><?php echo $lot_num['lot_no']; ?></kbd></h4>
            </div>

            <div id="chart-container"></div>
            <?php
            $value = "";
            $category = "";
            $count = sizeof($govt);
            $i = 0;
            foreach ($govt as $d) {
                $bigha = $d['bigha'];
                $katha = $d['kotha'];
                $lessa = $d['lessa'];
                $type = $d['type'];

                $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                if ($i < $count - 1) {
                    $value .= "{\"label\":\"$type\", ";
                    $value .= "\"value\":\"$measure[0]\"},";
                } else {
                    $value .= "{\"label\":\"$type\",";
                    $value .= "\"value\":\"$measure[0]\"}";
                }
                $i++;
                //echo $value;
            }
            ?>

            <table class="table table-striped table-bordered" width="100%" border="1">

                <tr class="danger">
                    <td class="text-center" rowspan="2"><?php echo $this->lang->line('TypeOfGovLand') ?></td>
                    <td class="text-center" colspan="4"><?php echo $this->lang->line('land_area'); ?></td>

                </tr>
                <tr class="danger">
                    <td class="text-center"><?php echo $this->lang->line('bigha') ?></td>
                    <td class="text-center"><?php echo $this->lang->line('katha') ?></td>
                    <td class="text-center"><?php echo $this->lang->line('lesa') ?></td>
                    <td class="text-center"><?php echo $this->lang->line('hec_are_care') ?></td>
                </tr>
                <?php
                            var_dump($govt);
                foreach ($govt as $row1):
                    $bigha = $row1['bigha'];
                    $katha = $row1['kotha'];
                    $lessa = $row1['lessa'];
                    $type = $row1['type'];

                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $type; ?></td>
                        <td class="text-center"><?php echo $measure[0]; ?></td>
                        <td class="text-center"><?php echo $measure[1]; ?></td>
                        <td class="text-center"><?php echo $measure[2]; ?></td>
                        <td class="text-center"><?php echo $get_Hec_Are_CAre; ?></td>
                    </tr>

                <?php endforeach; ?>
                <tr>
                    <td class="text-center" colspan="7">
                        <button id="backButton" class="btn btn-danger">
						<i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu') ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/VillWiseGovtLand' ?>";
    };

    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'pie2d',
            renderAt: 'chart-container',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Split of Government Land Area by Bigha",
                    "captionFontSize" : "20",
                    "subCaption": "<?php echo $namedata[4]->village; ?>",
                    "numberPrefix": "",
                    "startingAngle": "20",
                    "showPercentValues": "1",
                    "showPercentInTooltip": "0",
                    "showLegend": "1",
                    "decimals": "1",
                    "legendItemFontSize" : "18",
                    "valueFontSize": "18",
                    //Theme
                    "theme": "fint"
                },
                "data": [<?php echo $value; ?> ]
            }
        }).render();

    });
</script>
