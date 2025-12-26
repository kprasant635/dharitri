<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="alert alert-success" role="alert">
                <?php //print_r($namedata);?>
                <h4>Cropwise Landarea For Mouza :- <kbd> <?php echo $namedata[3]->mouza; ?></kbd></h4>
                <h4><?php echo $this->lang->line('district');?> : <code><?php echo $namedata[0]->district; ?></code> &nbsp;&nbsp;&nbsp;&nbsp; 
                    <?php echo $this->lang->line('subdivision');?> : <code><?php echo $namedata[1]->subdiv; ?></code> &nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $this->lang->line('circle');?> : <code><?php echo $namedata[2]->circle; ?></code></h4>
            </div>
            <div class="alert alert-warning" role="alert">
                <h4><?php echo $this->lang->line('year_of_cultivation');?> : <code><?php echo $namedata['year']; ?></code></h4>
            </div>

            <table class="table table-striped table-bordered" width="100%">
                <tr class="danger center">
                    <th width="140" rowspan="2"><?php echo $this->lang->line('sl_no');?></th>
                    <th width="253" rowspan="2"><?php echo $this->lang->line('crop_name');?></th>
                    <th width="190" rowspan="2"><?php echo $this->lang->line('rich_general_class');?></th>
                    <th colspan="4"><?php echo $this->lang->line('land_area');?></th>
                </tr>
                <tr class="danger center">
                    <th width="92"><?php echo $this->lang->line('bigha');?></th>
                    <th width="88"><?php echo $this->lang->line('katha');?></th>
                    <th width="78"><?php echo $this->lang->line('lesa');?></th>
                    <th width="134" class="text-center"><?php echo $this->lang->line('hec_are_care');?></th>
                </tr>
                <?php
                // print_r($query);
                //var_dump($query);
                $i = 1;
                foreach($result as $r){
                   ?>
                <tr>
                    <td rowspan="2"><?php echo $i ?></td>
                    <td rowspan="2"><?php echo $r->crop_name; ?></td>   
                <?php
                foreach ($query[$r->crop_name] as $row):
                    // var_dump($row);
                    $bigha = $row['bigha'];
                    $katha = $row['katha'];
                    $lessa = $row['lessa'];
                    $total_lessa = 0;
                    $mesaure = 0;
                    $total_lessa = $this->utilityclass->Total_Lessa($bigha, $katha, $lessa);
                    $get_Hec_Are_CAre = $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $measure = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    //$cropname=$r->crop_name;
                    ?>
                    
                        <td><?php echo $row['category'];?></td>
                        <td><?php echo $measure[0]; ?></td>
                        <td><?php echo $measure[1]; ?></td>
                        <td><?php echo $measure[2]; ?></td>
                        <td><?php echo $get_Hec_Are_CAre; ?></td>
                         </tr>
                    <?php 
                endforeach; 
                ?>
                        
                        <?php
                        $i++;
                }
                ?>
                <tr>
                    <td class="text-center" colspan="10">
                        <button id="backButton" class="btn  btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="chartContainer">
<?php //var_dump($query) ?>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/' ?>";
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
              "caption": "Crop Wise Land Area",
              "xAxisName": "Crop Name",
              "yAxisName": "Lessa",
              "baseFontSize": "16",
              "baseFontColor": "#0066cc",
           },
          "data": [
              <?php foreach($query as $d): ?>
              {
                 "label": "<?php echo $d['crop_name'] ?>",
                 "value": "<?php echo $d['total'] ?>"
              },
              <?php endforeach; ?>
           ]
        }
    });

    revenueChart.render();
})
</script>

