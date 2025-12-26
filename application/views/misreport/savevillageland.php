<div class="container-fluid ">
    <div class="row">
        <div class="col-lg-12 panel panel-body panel-default" >
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; color: #2e4d8e">Village-Wise Land Scenarion</h2>
                <h4 style="text-align: center;"><?php echo $this->lang->line('vill_town'); ?>: <code><?php  echo $namedata[4]->village;?></code>  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('district'); ?> : <code><?php  echo $namedata[0]->district;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision'); ?> : <code><?php  echo $namedata[1]->subdiv;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle'); ?> : <code><?php  echo $namedata[2]->circle;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('mouza'); ?> : <kbd><?php  echo $namedata[3]->mouza;?></kbd> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('lot_no'); ?> : <kbd><?php  echo $lot_num['lot_no'];?></kbd></h4>
            </div>
            <table class="table table-striped table-bordered" width="100%">
                <tr class="info">
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('sl_no'); ?></td>
                    <td class="center" width="148" rowspan="2"><?php echo $this->lang->line('dag_no'); ?></td>
            <td class="center" width="148" rowspan="2"><?php echo $this->lang->line('patta_no'); ?></td>
                    <td class="center" width="263" colspan="5"><?php echo $this->lang->line('land_area'); ?></td>
                    <td class="center" width="189" rowspan="2"><?php echo $this->lang->line('revenue'); ?> (Rs/-)</td>
                </tr>
                <tr class="info">
                    <td class="center"><?php echo $this->lang->line('bigha'); ?></td>
                    <td class="center"><?php echo $this->lang->line('katha'); ?></td>
                    <td class="center"><?php echo $this->lang->line('lesa'); ?></td>
                    <td class="center"><?php echo $this->lang->line('ganda'); ?></td>
                    <td class="center"><?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                <?php
                $i='1';
                foreach ($scenario as $row1):
                    $bigha=$row1->bigha;
                    $katha=$row1->kotha;
                    $lessa=$row1->lessa;
                    $dag_no=$row1->dag_no;
                    $patta_no=$row1->patta_no;
                    $ganda=$row1->ganda;
                    $dag_revenue=$row1->dag_revenue;
                ?>
                <tr>
                    <td class="center"><?php echo $i;?></td>
                    <td class="center"><?php echo $dag_no;?></td>
                    <td class="center"><?php echo $patta_no;?></td>
                    <td class="center"><?php echo $bigha;?></td>
                    <td class="center"><?php echo $katha;?></td>
                    <td class="center"><?php echo $lessa;?></td>
                    <td class="center"><?php echo $ganda;?></td>
                    <td class="center"><?php echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);?></td>
                    <td class="center"><?php echo $dag_revenue;?></td>
                    
                </tr>
                <?php 
                $i=$i+1;
                endforeach;?>
                <?php
                foreach ($scenario_count as $row):
                    $bigha=$row->total_bigha;
                    $katha=$row->total_kotha;
                    $lessa=$row->total_lessa;
                    $dag_no=$row->total_dag;
                    $patta_no=$row->total_patta;
                    $ganda=$row->total_ganda;
                    $dag_revenue=$row->total_revenue;
                    
                    $total_lessa=$this->utilityclass->Total_Lessa($bigha,$katha,$lessa);
                    $get_Hec_Are_CAre=$this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $measure=$this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                ?>
                <tr>
                    <td class="center">Total =</td>
                    <td class="center"><?php echo $dag_no;?></td>
                    <td class="center"><?php echo $patta_no;?></td>
                    <td class="center"><?php echo $measure[0];?></td>
                    <td class="center"><?php echo $measure[1];?></td>
                    <td class="center"><?php echo $measure[2];?></td>
                    <td class="center"><?php echo $ganda;?></td>
                    <td class="center"><?php echo $this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);?></td>
                    <td class="center"><?php echo $dag_revenue;?></td>
                </tr>
                <?php endforeach;?>
                 <tr>
                    <td class="text-center" colspan="10">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/VillageLandScenario'?>";
    };
</script>

