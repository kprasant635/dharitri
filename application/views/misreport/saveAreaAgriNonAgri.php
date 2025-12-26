<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="alert alert-success text-center" role="alert">
                <h4> Area of Agricultural and Non-Agricultural Land :--<?php echo $this->lang->line('mouza');?> :  <?php echo $namedata[3]->mouza; ?> &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('from');?> <code><?php echo (date('Y', strtotime($years['start_year']))); ?></code> <?php echo $this->lang->line('to');?> <code> <?php echo (date('Y', strtotime($years['end_year']))); ?></code> 
                </h4> 
            </div>
            <div class="alert alert-info text-center" role="alert">
                <h4> <?php echo $this->lang->line('district');?> : <?php echo $namedata[0]->district; ?> &nbsp;&nbsp;--&nbsp;&nbsp;  <?php echo $this->lang->line('subdivision');?> : <?php echo $namedata[1]->subdiv; ?>&nbsp;&nbsp;--&nbsp;&nbsp;  <?php echo $this->lang->line('circle');?> : <?php echo $namedata[2]->circle; ?></h4>
            </div>
            <div id="chart-container"></div> 
            <?php
            //var_dump($graph_display) ;
            $value1 = "";
            $value2 = "";
            $category = "";
            $count = sizeof($graph_display);
            $i = 0;
            foreach ($graph_display as $d) {
                $dates =  $d['dates'];
                $bigha_A = $d['bigha_A'];
                $bigha_N = $d['bigha_N'];
                if ($i < $count - 1) {
                    $category .= "{\"label\":\"$dates\"}, ";
                    $value1 .= "{\"value\":\"$bigha_A\"}, ";
                    $value2 .= "{\"value\":\"$bigha_N\"},";
                } else {
                    $category .= "{\"label\":\"$dates\"}";
                    $value1 .= "{\"value\":\"$bigha_A\"}";
                    $value2 .= "{\"value\":\"$bigha_N\"}";
                }
                $i++;
            }
            
            ?>
            <table class="table table-striped table-bordered" style="width: 50%; float: left">
                <tr class="center danger">
                    <td rowspan="2">  <?php echo $this->lang->line('year');?> </td>
                    <td colspan="4"> <?php echo $this->lang->line('area_of_agricultural_land');?></td>
                </tr>
                <tr class="center danger">
                    <td> <?php echo $this->lang->line('bigha');?></td>
                    <td> <?php echo $this->lang->line('katha');?></td>
                    <td> <?php echo $this->lang->line('lesa');?></td>
                    <td> <?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                <?php
                foreach ($rs_crop_stat as $row1):
                    $bigha = $row1['bigha'];
                    $katha = $row1['kotha'];
                    $lessa = $row1['lesa'];
                    $year = $row1['dates'];

                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $tot_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    ?>
                    <tr class="center">
                        <td><?php echo $year; ?></td>
                        <td><?php echo $tot_b_k_l[0]; ?></td>
                        <td><?php echo $tot_b_k_l[1]; ?></td>
                        <td><?php echo $tot_b_k_l[2]; ?></td>
                        <td><?php echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <table class="table table-striped table-bordered" style="width: 50%; float: left;">
                <tr class="center danger">
                    <td rowspan="2">  <?php echo $this->lang->line('year');?> </td>
                    <td colspan="4"> <?php echo $this->lang->line('area_of_non_agricultural_land');?></td>
                </tr>
                <tr class="center danger">
                    <td> <?php echo $this->lang->line('bigha');?></td>
                    <td> <?php echo $this->lang->line('katha');?></td>
                    <td> <?php echo $this->lang->line('lesa');?></td>
                    <td> <?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                <?php
                foreach ($noncrop as $row):
                    $bigha = $row['bigha'];
                    $katha = $row['kotha'];
                    $lessa = $row['lesa'];
                    $year = $row['dates'];

                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $tot_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    ?>
                    <tr class="center">
                        <td><?php echo $year; ?></td>
                        <td><?php echo $tot_b_k_l[0]; ?></td>
                        <td><?php echo $tot_b_k_l[1]; ?></td>
                        <td><?php echo $tot_b_k_l[2]; ?></td>
                        <td><?php echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <table class="table table-striped table-bordered" width="100%">
                <tr>
                    <td class="text-center" colspan="10">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
         window.history.back();
    };
    
    FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'mscolumn2d',
        renderAt: 'chart-container',
        width: '100%',
        height: '400',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Comparison of Agricultural and Non-Agricultural Land Area",
                "xAxisname": "Years",
                "yAxisName": "Total Land Area (In Bigha)",
                "numberPrefix": "bigha ",
                "plotFillAlpha" : "80",

                //Cosmetics
                "paletteColors" : "#0075c2,#1aaf5d",
                "baseFontColor" : "#333333",
                "baseFont" : "Helvetica Neue,Arial",
                "captionFontSize" : "14",
                "subcaptionFontSize" : "14",
                "subcaptionFontBold" : "0",
                "showBorder" : "0",
                "bgColor" : "#ffffff",
                "showShadow" : "0",
                "canvasBgColor" : "#ffffff",
                "canvasBorderAlpha" : "0",
                "divlineAlpha" : "100",
                "divlineColor" : "#999999",
                "divlineThickness" : "1",
                "divLineIsDashed" : "1",
                "divLineDashLen" : "1",
                "divLineGapLen" : "1",
                "usePlotGradientColor" : "0",
                "showplotborder" : "0",
                "valueFontColor" : "#ffffff",
                "placeValuesInside" : "1",
                "showHoverEffect" : "1",
                "rotateValues" : "1",
                "showXAxisLine" : "1",
                "xAxisLineThickness" : "1",
                "xAxisLineColor" : "#999999",
                "showAlternateHGridColor" : "0",
                "legendBgAlpha" : "0",
                "legendBorderAlpha" : "0",
                "legendShadow" : "0",
                "legendItemFontSize" : "20",
                "legendItemFontColor" : "#666666"                
            },
            "categories": [
                {
                    "category": [<?php echo $category; ?> ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Area Of Agricultural Land",
                    "data": [<?php echo $value1; ?> ]
                }, 
                {
                    "seriesname": "Area Of Non Agricultural Land",
                    "data": [<?php echo $value2; ?> ]
                }
            ],
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "12250",
                            "color": "#0075c2",
                            "displayvalue": "Previous{br}Average",
                            "valueOnRight" : "1",
                            "thickness" : "1",
                            "showBelow" : "1",
                            "tooltext" : "Previous year quarterly target  : "
                        },
                        {
                            "startvalue": "25950",
                            "color": "#1aaf5d",
                            "displayvalue": "Current{br}Average",
                            "valueOnRight" : "1",
                            "thickness" : "1",
                            "showBelow" : "1",
                            "tooltext" : "Current year quarterly target  : "
                        }
                    ]
                }
            ]
        }
    });
    
    revenueChart.render();
});
</script>