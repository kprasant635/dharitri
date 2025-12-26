<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <table class="table table-striped table-bordered" width="100%">
                <tr class="active">
                    <td colspan="6" class="text-center">
                        <h2>LAND AREA OF ANNUAL PATTA (A.P), PERIODIC PATTA (P.P), <br/>SPECIAL PERIODIC PATTA (S.P.P) AND SPECIAL ANNUAL PATTA (S.A.P)</h2>
                        <h3><?php echo $this->lang->line('land_area_for_mouza');?> : 
                            <code><?php echo $namedata[3]->mouza; ?></code>
                        </h3>
                    </td>
                </tr>
                <tr >
                    <td colspan="2" class="text-center"><h6><?php echo $this->lang->line('district');?> : <?php echo $namedata[0]->district; ?></h6></td>
                    <td colspan="2" class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <?php echo $namedata[1]->subdiv; ?></h6></td>
                    <td colspan="2" class="text-center"><h6><?php echo $this->lang->line('circle');?> : <?php echo $namedata[2]->circle; ?></h6></td>
                </tr>
                <tr class="success">
                    <td colspan="2" class="text-center" style="vertical-align: middle;"></td>
                    <td colspan="4" class="text-center"><?php echo $this->lang->line('land_area');?></td>
                </tr>

                <?php
                $AreaLand = $land['AreaLand'];

                $tbigha0201 = 0;
                $tkatha0201 = 0;
                $tlessa0201 = 0;

                $tbigha0202 = 0;
                $tkatha0202 = 0;
                $tlessa0202 = 0;

                $tbigha0203 = 0;
                $tkatha0203 = 0;
                $tlessa0203 = 0;

                $tbigha0204 = 0;
                $tkatha0204 = 0;
                $tlessa0204 = 0;

                
                //var_dump($AreaLand);
                foreach ($AreaLand AS $row) {
                    $patta_type = $row->patta_type_code;
                    $bigha = $row->dag_area_b;
                    $katha = $row->dag_area_k;
                    $lessa = $row->dag_area_lc;

                    //'0201','0202','0203','0204','0216','0217','0223','0230','0231','0232'

                    if ($patta_type == '0201') {
                        $tbigha0201 = $tbigha0201 + $bigha;
                        $tkatha0201 = $tkatha0201 + $katha;
                        $tlessa0201 = $tlessa0201 + $katha;
                    } elseif ($patta_type == '0202') {
                        $tbigha0202 = $tbigha0202 + $bigha;
                        $tkatha0202 = $tkatha0202 + $katha;
                        $tlessa0202 = $tlessa0202 + $katha;
                    } elseif ($patta_type == '0203') {
                        $tbigha0203 = $tbigha0203 + $bigha;
                        $tkatha0203 = $tkatha0203 + $katha;
                        $tlessa0203 = $tlessa0203 + $katha;
                    } elseif ($patta_type == '0204') {
                        $tbigha0204 = $tbigha0204 + $bigha;
                        $tkatha0204 = $tkatha0204 + $katha;
                        $tlessa0204 = $tlessa0204 + $katha;
                    } 
                }

                //'0201','0202','0203','0204','0216','0217','0223','0230','0231','0232'
                //
                //
                //for 0201
                $total_lessa0201 = $this->utilityclass->Total_Lessa($tbigha0201, $tkatha0201, $tlessa0201);
                $get_Hec_Are_CAre0201 = $this->utilityclass->get_Hec_Are_CAre($tbigha0201, $tkatha0201, $tlessa0201);

                $measure0201 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0201);
                //for 0202
                $total_lessa0202 = $this->utilityclass->Total_Lessa($tbigha0202, $tkatha0202, $tlessa0202);
                $get_Hec_Are_CAre0202 = $this->utilityclass->get_Hec_Are_CAre($tbigha0202, $tkatha0202, $tlessa0202);
                $measure0202 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0202);
                //for 0203
                $total_lessa0203 = $this->utilityclass->Total_Lessa($tbigha0203, $tkatha0203, $tlessa0203);
                $get_Hec_Are_CAre0203 = $this->utilityclass->get_Hec_Are_CAre($tbigha0203, $tkatha0203, $tlessa0203);
                $measure0203 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0203);

                //for 0204
                $total_lessa0204 = $this->utilityclass->Total_Lessa($tbigha0204, $tkatha0204, $tlessa0204);
                $get_Hec_Are_CAre0204 = $this->utilityclass->get_Hec_Are_CAre($tbigha0204, $tkatha0204, $tlessa0204);
                $measure0204 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0204);

                

                $patta_type = $land['patta_type'];
                ?>

                <tr>
                    <td colspan="2">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="text-center danger">
                                <td ><?php echo $this->lang->line('sl_no');?></td>
                                <td><?php echo $this->lang->line('patta_type');?></td>
                            </tr>
                            <?php
                            $c = 1;
                            foreach ($patta_type AS $p):
                                ?>
                                <tr>
                                    <td class="text-center" style="width:70px;"><?php echo $c; ?></td>
                                    <td class="text-center" style="width: 210px;">
                                        <?php 
                                            switch ($p->type_code) {
                                                case '0201':
                                                    echo "Periodic Patta (P.P)";
                                                    break;
                                                case '0202':
                                                    echo "Annual Patta (A.P)";
                                                    break;
                                                case '0203':
                                                    echo "Special Periodic Patta (S.P.P)";
                                                    break;
                                                case '0204':
                                                    echo "Special Annual Patta (S.A.P)";
                                                    break;
                                            }
                                         ?>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            endforeach;
                            ?>
                        </table>
                    </td>
                    <td colspan="4">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="text-center danger">
                                <th class="text-center"><?php echo $this->lang->line('bigha');?> </th>
                                <th class="text-center"><?php echo $this->lang->line('katha');?></th>
                                <th><?php echo $this->lang->line('lesa');?></th>
                                <th class="text-center"><?php echo $this->lang->line('hec_are_care');?></th>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 123px;">
                                    <?php
                                    echo $measure0201[0];
                                    ?>
                                </td>
                                <td class="text-center" style="width: 134px;">
                                    <?php
                                    echo $measure0201[1];
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    echo $measure0201[2];
                                    ?>
                                </td>
                                <td class="text-center" style="width: 184px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0201;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0202[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0202[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0202[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0202;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0203[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0203[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0203[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0203;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0204[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0204[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0204[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0204;
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td class="text-center" colspan="5">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="chartContainer">Fusion Charts will render here</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReport/";
    };
    FusionCharts.ready(function(){
      var revenueChart = new FusionCharts({
        "type": "column2d",
        "renderAt": "chartContainer",
        "width": "100%",
        "height": "600",
        "dataFormat": "json",
        "dataSource": {
          "chart": {
              "caption": "LAND AREA OF ANNUAL PATTA (A.P), PERIODIC PATTA (P.P), <br/>SPECIAL PERIODIC PATTA (S.P.P) AND SPECIAL ANNUAL PATTA (S.A.P)",
              "xAxisName": "Patta Type",
              "yAxisName": "Lessa",
           },
          "data": [
                    {
                        "label": "Periodic Patta (P.P)",
                        "value": "<?php echo $total_lessa0201 ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0201 ?>"
                    },
                    {
                        "label": "Annual Patta (A.P)",
                        "value": "<?php echo $total_lessa0202; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0202 ?>"
                    },
                    {
                        "label": "Special Periodic Patta (S.P.P)",
                        "value": "<?php echo $total_lessa0203;?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0203 ?>"
                    },
                    {
                        "label": "Special Annual Patta (S.A.P)",
                        "value": "<?php echo $tbigha0204; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0204 ?>"
                    }
                ]
        }
    });

    revenueChart.render();
})
</script>