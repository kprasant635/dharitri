<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
              <div class="alert alert-success" role="alert">
                <h4>Land Area Revenue of La-Kheraj for Mouza  : <code><?php echo $namedata[3]->mouza;?></code></h4>
            </div>
            <div class="alert alert-info" role="alert">
                <h4><?php echo $this->lang->line('district'); ?> : <code><?php echo $namedata[0]->district;?></code> &nbsp;&nbsp;&nbsp;&nbsp; 
				<?php echo $this->lang->line('subdivision')?> : <code><?php   echo $namedata[1]->subdiv;?></code> &nbsp;&nbsp;&nbsp;&nbsp; 
				<?php echo $this->lang->line('circle'); ?> : <code><?php   echo $namedata[2]->circle;?></code></h4>
            </div>
            <table class="table table-striped table-bordered" width="100%" border="1">
             
                <tr class="danger">
                    <th class="text-center" rowspan="2"><?php echo $this->lang->line('sl_no');?></th>
                    <th class="text-center" rowspan="2"><?php echo $this->lang->line('patta_no');?></th>
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
				$j=1;
                $null=sizeof($query);
				//var_dump($query);
                foreach ($query as $row):
				
                                $bigha=$row['bigha'];
                                $katha=$row['katha'];
                                $lessa=$row['lessa'];
                                $total_lessa=$this->utilityclass->Total_Lessa($bigha,$katha,$lessa);
                                $get_Hec_Are_CAre=$this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                                $measure=$this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                ?>
               <tr>
                  <td class="text-center"><?php echo $i++ ; ?></td>
                  <td class="text-center"><?php echo $row['patta_no']; ?></td>
                 
                  <td class="text-center"><?php echo $measure[0]; ?></td>
                  <td class="text-center"><?php echo $measure[1]; ?></td>
                  <td class="text-center"><?php echo $measure[2]; ?></td>
                  <td class="text-center"><?php echo $get_Hec_Are_CAre; ?></td>
				   <td class="text-center"><?php echo number_format($row['revenue'],2) ; ?></td>
                </tr>
                <?php $j++; endforeach; ?>
                
                <?php
                    if($null==0)
                    {
                        echo "<tr><td class=\"center\" colspan='9'><h2>No Matching Data are Found</h2></td></tr>";
                    }
                ?>
               <tr>
                    <td class="text-center" colspan="7">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/MisReport/LandRevenueLaKheEstate' ?>";
        };
    </script>
