<div class="container-fluid ">
    <div class="row">
        <div class="col-lg-12" style="margin-top:10px" >
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: #2e4d8e">Village-Wise Land Scenario</h2>
                <h4 style="text-align: center;"><?php echo $this->lang->line('vill_town');?> : <code><?php echo $namedata[4]->village; ?></code>  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('district');?> : <code><?php echo $namedata[0]->district; ?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <code><?php echo $namedata[1]->subdiv; ?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <code><?php echo $namedata[2]->circle; ?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('mouza');?> : <kbd><?php echo $namedata[3]->mouza; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('lot_no');?> : <kbd><?php echo $lot_num['lot_no']; ?></kbd></h4>
            </div>

            <div id="chart-container"></div>
            <?php
            $value = "";
            $category = "";
            $count = sizeof($scenario_count);
            $i = 0;
            //var_dump($scenario_count);
            foreach ($scenario_count as $d) {
                if ($i < $count - 1) {
                    $value .= "{\"label\":\"$d[label]\", ";
                    $value .= "\"value\":\"$d[value]\"},";
                } else {
                    $value .= "{\"label\":\"$d[label]\",";
                    $value .= "\"value\":\"$d[value]\"}";
                }
                $i++;
                //echo $value;
            }
            ?>

            <table id="example" class="table table-striped table-bordered" width="100%">
                <tr class="info">
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('land_class');?></td>
                    <td class="center" width="148" rowspan="2"><?php echo $this->lang->line('dag_no');?></td>
                    <td class="center" width="148" rowspan="2"><?php echo $this->lang->line('patta_no');?></td>
                    <td class="center" width="263" colspan="5"><?php echo $this->lang->line('land_area');?></td>
                    <td class="center" width="189" rowspan="2"><?php echo $this->lang->line('revenue');?> (Rs/-)</td>
                </tr>
                <tr class="info">
                    <td class="center"><?php echo $this->lang->line('bigha');?></td>
                    <td class="center"><?php echo $this->lang->line('katha');?></td>
                    <td class="center"><?php echo $this->lang->line('lesa');?></td>
                    <td class="center"><?php echo $this->lang->line('ganda');?></td>
                    <td class="center"><?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                <?php
                $array_class = array();

                $c = 0;
                //echo count($scenario);
                //create an array to insert all the dag nos 
                $noArr = array();
                foreach ($scenario AS $row2) {
                    $type_of_land = $row2->type_of_land;
                    $noArr[].=$type_of_land;
                }
                // print_r($noArr);
                // echo  count($noArr);
                //convert this array into an unique array
                $noArr1 = array_unique($noArr);
                $noArr22 = array_merge($noArr1);
                //var_dump($noArr22);

                $cnt = count($noArr22);
                //counting the no of ocurance in  $noArr Array
                $xx = array();
                for ($i = 0; $i < $cnt; $i++) {
                    $xx[].=count(array_keys($noArr, $noArr22[$i]));
                }
                //var_dump($xx);
                $count = count($xx);



                //array_push($scenario, $obj);
                //print_r($scenario);
                //exit;

                foreach ($scenario as $row1):

                    $type_of_land = $row1->type_of_land;

                    $key = in_array($type_of_land, $array_class);

                    if ($key == '') {
                        $array_class[].= $type_of_land;

                        $l = $type_of_land;
                    } else {
                        $l = '';
                    }
                    if (($key == '') && ($c > 0)) {
                        ?>


                        <tr class="alert danger">
                            <td class="center" colspan="3">TOTAL LAND AREA</td>


                            <td class="center">B</td>
                            <td class="center">K</td>
                            <td class="center">L</td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                        </tr>

        <?php
    }

    $bigha = $row1->bigha;
    $katha = $row1->kotha;
    $lessa = $row1->lessa;
    $dag_no = $row1->dag_no;
    $patta_no = $row1->patta_no;
    $ganda = $row1->ganda;
    $dag_revenue = $row1->dag_revenue;
    ?>
                    <tr>
                    <?php ///if($c<$count){ ?>
                        <td class="center" style="text-align:center;vertical-align:middle;" rowspan="<?php //echo $xx[$c];?>"><?php echo $l; ?></td>
                    <?php //}else{ ?>


                        <?php // }?>
                        <td class="center"><?php echo $dag_no; ?></td>
                        <td class="center"><?php echo $patta_no; ?></td>
                        <td class="center"><?php echo $bigha; ?></td>
                        <td class="center"><?php echo $katha; ?></td>
                        <td class="center"><?php echo $lessa; ?></td>
                        <td class="center"><?php echo $ganda; ?></td>
                        <td class="center"><?php echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa); ?></td>
                        <td class="center"><?php echo $dag_revenue; ?></td>

                    </tr>

    <?php
    $c++;
endforeach;
?>

                <tr>
                    <td class="text-center" colspan="9">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/VillageLandScenarioOnLandClass' ?>";
    };
    FusionCharts.addEventListener('ready', function () {
    //FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'pie2d',
            renderAt: 'chart-container',
            width: '90%',
            height: '500',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Class Wise Land Area Coverage (Hec)",
                    "captionFontSize" : "20",
                    "formatnumberscale": "0",
                    "showBorder": "0",
                    "showLegend": "1",
                    "theme": "fint",
                    "showPercentValues": "1",
                    "showPercentInToolTip": "0",
                    //Setting legend to appear on right side
                    "legendPosition": "right",
                    "legendItemFontSize" : "18",
                    //Caption for legend
                    "legendCaption": "Land Class Type ",
                    //Customization for legend scroll bar cosmetics
                    "legendScrollBgColor": "#cccccc",
                    "valueFontSize": "18",
                    "legendScrollBarColor": "#999999"
                },
                "data": [<?php echo $value ?> ]
            }
        });

        revenueChart.render();
    });
    $('#chart-container').bind('fusionchartsdataplotclick', function(event, args) {
    $('#messageView').text("You selected " + args.toolText);
});
</script>



