<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <table class="table table-striped table-bordered" width="100%">
                <tr class="active">
                    <td colspan="6" class="text-center">
                        <h2>Land Area of Annual Patta(A.P), Periodic Patta(P.P), Special Periodic Patta(S.P.P), Special Annual Patta(S.A.P) </h2>
                        <h3><?php echo $this->lang->line('land_area_for_village');?> : 
                            <code><?php echo $namedata[5]->village; ?></code>
                        </h3>
                    </td>
                </tr>
                <tr >
                    <td colspan="1" class="text-center"><h6><?php echo $this->lang->line('district');?> : <?php echo $namedata[0]->district; ?></h6></td>
                    <td colspan="2" class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <?php echo $namedata[1]->subdiv; ?></h6></td>
                    <td colspan="1" class="text-center"><h6><?php echo $this->lang->line('circle');?> : <?php echo $namedata[2]->circle; ?></h6></td>
                    <td colspan="1" class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <?php echo $namedata[3]->mouza; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <?php echo $namedata[4]->lot_no; ?></h6></td>
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

                $tbigha0216 = 0;
                $tkatha0216 = 0;
                $tlessa0216 = 0;

                $tbigha0217 = 0;
                $tkatha0217 = 0;
                $tlessa0217 = 0;

                $tbigha0223 = 0;
                $tkatha0223 = 0;
                $tlessa0223 = 0;

                $tbigha0230 = 0;
                $tkatha0230 = 0;
                $tlessa0230 = 0;

                $tbigha0231 = 0;
                $tkatha0231 = 0;
                $tlessa0231 = 0;

                $tbigha0232 = 0;
                $tkatha0232 = 0;
                $tlessa0232 = 0;

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
                    } elseif ($patta_type == '0216') {
                        $tbigha0216 = $tbigha0216 + $bigha;
                        $tkatha0216 = $tkatha0216 + $katha;
                        $tlessa0216 = $tlessa0216 + $katha;
                    } elseif ($patta_type == '0217') {
                        $tbigha0217 = $tbigha0217 + $bigha;
                        $tkatha0217 = $tkatha0217 + $katha;
                        $tlessa0217 = $tlessa0217 + $katha;
                    } elseif ($patta_type == '0223') {
                        $tbigha0223 = $tbigha0223 + $bigha;
                        $tkatha0223 = $tkatha0223 + $katha;
                        $tlessa0223 = $tlessa0223 + $katha;
                    } elseif ($patta_type == '0230') {
                        $tbigha0230 = $tbigha0230 + $bigha;
                        $tkatha0230 = $tkatha0230 + $katha;
                        $tlessa0230 = $tlessa0230 + $katha;
                    } elseif ($patta_type == '0231') {
                        $tbigha0231 = $tbigha0231 + $bigha;
                        $tkatha0231 = $tkatha0231 + $katha;
                        $tlessa0231 = $tlessa0231 + $katha;
                    } elseif ($patta_type == '0232') {
                        $tbigha0232 = $tbigha0232 + $bigha;
                        $tkatha0232 = $tkatha0232 + $katha;
                        $tlessa0232 = $tlessa0232 + $katha;
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

                //for 0216
                $total_lessa0216 = $this->utilityclass->Total_Lessa($tbigha0216, $tkatha0216, $tlessa0216);
                $get_Hec_Are_CAre0216 = $this->utilityclass->get_Hec_Are_CAre($tbigha0216, $tkatha0216, $tlessa0216);
                $measure0216 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0216);
                //for 0217
                $total_lessa0217 = $this->utilityclass->Total_Lessa($tbigha0217, $tkatha0217, $tlessa0217);
                $get_Hec_Are_CAre0217 = $this->utilityclass->get_Hec_Are_CAre($tbigha0217, $tkatha0217, $tlessa0217);
                $measure0217 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0217);

                //for 0223
                $total_lessa0223 = $this->utilityclass->Total_Lessa($tbigha0223, $tkatha0223, $tlessa0223);
                $get_Hec_Are_CAre0223 = $this->utilityclass->get_Hec_Are_CAre($tbigha0223, $tkatha0223, $tlessa0223);
                $measure0223 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0223);

                //for 0230
                $total_lessa0230 = $this->utilityclass->Total_Lessa($tbigha0230, $tkatha0230, $tlessa0230);
                $get_Hec_Are_CAre0230 = $this->utilityclass->get_Hec_Are_CAre($tbigha0230, $tkatha0230, $tlessa0230);
                $measure0230 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0230);
                //for 0231
                $total_lessa0231 = $this->utilityclass->Total_Lessa($tbigha0231, $tkatha0231, $tlessa0231);
                $get_Hec_Are_CAre0231 = $this->utilityclass->get_Hec_Are_CAre($tbigha0231, $tkatha0231, $tlessa0231);
                $measure0231 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0231);
                //for 0232
                $total_lessa0232 = $this->utilityclass->Total_Lessa($tbigha0232, $tkatha0232, $tlessa0232);
                $get_Hec_Are_CAre0232 = $this->utilityclass->get_Hec_Are_CAre($tbigha0232, $tkatha0232, $tlessa0232);
                $measure0232 = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa0232);

                $patta_type = $land['patta_type'];
                ?>

                <tr>
                    <td colspan="2">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="text-center danger">
                                <td ><?php echo $this->lang->line('sl_no');?></td>
                                <td><?php echo $this->lang->line('land_class');?></td>
                            </tr>

                            <?php
                            $c = 1;
                            foreach ($patta_type AS $p):
                                ?>
                                <tr>
                                    <td class="text-center" style="width:70px;"><?php echo $c; ?></td>
                                    <td class="text-center" style="width: 210px;"><?php echo $p->patta_type; ?></td>
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
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0216[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0216[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0216[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0216;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0217[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0217[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0217[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0217;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0223[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0223[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0223[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0223;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0230[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0230[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0230[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0230;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0231[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0231[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0231[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0231;
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td >
                                    <?php
                                    echo $measure0232[0];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $measure0232[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $measure0232[2];
                                    ?>
                                </td>
                                <td style="width: 140px;">
                                    <?php
                                    echo $get_Hec_Are_CAre0232;
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td class="text-center" colspan="7">
                        <button id="backButton" class="btn  btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="chartContainer">FusionCharts will render here</div>
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
              "caption": "Land Area of Annual Patta(A.P), Periodic Patta(P.P), Special Periodic Patta(S.P.P), Special Annual Patta(S.A.P) ",
              "xAxisName": "Land Class",
              "yAxisName": "Lessa",
           },
          "data": [
                    {
                        "label": "খেৰাজ ম্যাদী",
                        "value": "<?php echo $total_lessa0201 ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0201 ?>"
                    },
                    {
                        "label": "একচনা",
                        "value": "<?php echo $total_lessa0202; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0202 ?>"
                    },
                    {
                        "label": "বিশেষ ম্যাদী",
                        "value": "<?php echo $total_lessa0203;?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0203 ?>"
                    },
                    {
                        "label": "বিশেষ একচনা",
                        "value": "<?php echo $tbigha0204; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0204 ?>"
                    },
                    {
                        "label": "চাহ ম্যাদী",
                        "value": "<?php echo $total_lessa0216;?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0216; ?>"
                    },
                    {
                        "label": "হ্ৰস্ব ম্যাদী",
                        "value": "<?php echo $total_lessa0217; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0217; ?>"
                    },
                    {
                        "label": "গ্ৰামদান ম্যাদী",
                        "value": "<?php echo $total_lessa0223; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0223; ?>"
                    },
                    {
                        "label": "খেৰাজ একচনা",
                        "value": "<?php echo $tbigha0230; ?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0230; ?>"
                    },
                    {
                        "label": "গ্ৰামসভা একচনা",
                        "value": "<?php echo $total_lessa0231;?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0231; ?>"
                    },
                    {
                        "label": "গ্ৰামসভা ম্যাদী",
                        "value": "<?php echo $total_lessa0232;?>",
                        "tooltext": "Total Land Area <?php echo $total_lessa0232; ?>"
                    }
                ]
        }
    });

    revenueChart.render();
})
</script>