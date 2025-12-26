<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="alert alert-success" role="alert">
                <h4>Land Revenue of Nisfi Kheraj for Mouza : <code><?php echo $namedata[3]->mouza;?></code></h4>
            </div>
            <div class="alert alert-info" role="alert">
                <h4>District : <code><?php echo $namedata[0]->district;?></code> &nbsp;&nbsp;&nbsp;&nbsp; Sub-Division : <code><?php   echo $namedata[1]->subdiv;?></code> &nbsp;&nbsp;&nbsp;&nbsp; Circle : <code><?php   echo $namedata[2]->circle;?></code></h4>
            </div>
             <table class="table table-striped table-bordered" width="100%">
              
                 <tr class="danger">
                    <th class="text-center" rowspan="2"><?php echo $this->lang->line('sl_no');?></th>
                    <th class="text-center" rowspan="2"><?php echo $this->lang->line('total_patta');?></th>
                    <th class="text-center" colspan="4"><?php echo $this->lang->line('land_area');?></th>
                    <th class="text-center" rowspan="2"><?php echo $this->lang->line('revenue');?> (Rs/-)</th>
                </tr>
                <tr class="danger">
                    <td> <?php echo $this->lang->line('bigha'); ?></td>
                    <td> <?php echo $this->lang->line('katha'); ?></td>
                    <td> <?php echo $this->lang->line('lesa'); ?></td>
                    <td> <?php echo $this->lang->line('hec_are_care'); ?></td>
                </tr>
								<?php
								$i=1;
								$null=sizeof($query);
								foreach ($query as $row):
                                $bigha=$row->dag_area_b;
                                $katha=$row->dag_area_k;
                                $lessa=$row->dag_area_lc;
                                $total_lessa=Total_Lessa($bigha,$katha,$lessa);
                                $get_Hec_Are_CAre=get_Hec_Are_CAre($bigha, $katha, $lessa);
                                $measure=Total_Bigha_Katha_Lessa($total_lessa);
								?>
                <tr>
                  <td class="text-center"><?php echo $i++ ; ?></td>
                  <td class="text-center"><?php echo $row->patta_no; ?></td>
                  <td class="text-center"><?php echo $row->dag_no; ?></td>
                  <td class="text-center"><?php echo $measure[0]; ?></td>
                  <td class="text-center"><?php echo $measure[1]; ?></td>
                  <td class="text-center"><?php echo $measure[2]; ?></td>
                  <td class="text-center"><?php echo $get_Hec_Are_CAre; ?></td>
                </tr>
                <?php $i++; endforeach; ?>
                
                <?php
                    if($null==0)
                    {
                        echo "<tr><td class=\"center\" colspan='9'><h2>No Matching Data are Found</h2></td></tr>";
                    }
                ?>
                <tr>
                    <td class="text-center" colspan="9">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;Back to Main Meu</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/LandRevenueNisKheEstate'?>";
    };
</script>