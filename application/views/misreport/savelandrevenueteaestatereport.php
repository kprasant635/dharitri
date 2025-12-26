<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="alert alert-success" role="alert">
                <h4>Land Revenue of Direct Paying Tea Estate for Mouza : <code><?php echo $namedata[3]->mouza; ?></code></h4>
            </div>
             <?php //print_r($query); 
             $null=sizeof($query); ?>   
                                        
                                    
            <div class="alert alert-info" role="alert">
                <h4><?php echo $this->lang->line('district');?> : <kbd><?php echo $namedata[0]->district; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <kbd><?php echo $namedata[1]->subdiv; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $namedata[2]->circle; ?></kbd> </h4>
            </div>
             <table class="table table-striped table-bordered" width="100%">
                
                <tr class="danger">
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('sl_no');?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('Name_oftheteaestate');?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('patta_no');?></strong></td>
                    <td rowspan="2" class="text-center"><strong<?php echo $this->lang->line('dag_no');?></strong></td>
                    <td colspan="4" class="text-center"><strong><?php echo $this->lang->line('land_area');?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('revenue');?> (Rs/-)</strong></td>
                </tr>
                <tr class="danger">
                   <td> <?php echo $this->lang->line('bigha');?></td>
                    <td> <?php echo $this->lang->line('katha');?></td>
                    <td> <?php echo $this->lang->line('lesa');?></td>
                    <td> <?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                
                <?php
                $i=1;
                foreach ($query as $row):
                    //function created for  converting total lessa from bigha katha and lessa
                                function Total_Lessa($bigha,$katha,$lessa){
                                    $total_lessa=$lessa+$katha*20+$bigha*100;
                                    return $total_lessa;
                                }
                                
                                //function created for  converting Hec-Are-CAre from total lessa
                                function get_Hec_Are_CAre($bigha, $katha, $lesa) {

                                        $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lesa;
                                        $centiarr = (10000 / 747) * $total_lesa;
                                        $hectar = $centiarr / 10000;

                                        $whole = floor($hectar);      // 1
                                        $fraction1 = $hectar - $whole; // .25
                                        $arr= 100*$fraction1;
                                        $whole2=  floor($arr);
                                        
                                        $fraction2 = $arr - $whole2;
                                        $arr2=$fraction2*100;
                                        $whole3=  floor($arr2);
                                        
                                        $hec_are_care=$whole."-".$whole2."-".$whole3;
                                        return $hec_are_care;
                                }
                                
                                //function created for converting total bigha katha and lessa
                                
                                function Total_Bigha_Katha_Lessa($total_lessa){
                                    $bigha=$total_lessa/100;
                                    $rem_lessa=$total_lessa%100;
                                    $katha=$rem_lessa/20;
                                    $r_lessa=$rem_lessa%20;
                                    $mesaure=array();
                                    $mesaure[].=floor($bigha);
                                    $mesaure[].=floor($katha);
                                    $mesaure[].=round($r_lessa,2);
                                    
                                    return $mesaure;
                                }
                                $bigha=$row->dag_area_b;
                                $katha=$row->dag_area_k;
                                $lessa=$row->dag_area_lc;
                                $total_lessa=Total_Lessa($bigha,$katha,$lessa);
                                $get_Hec_Are_CAre=get_Hec_Are_CAre($bigha, $katha, $lessa);
                                $measure=Total_Bigha_Katha_Lessa($total_lessa);
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++ ; ?></td>
                  <td class="text-center"><?php echo $row->pdar_name; ?></td>
                  <td class="text-center"><?php echo $row->patta_no; ?></td>
                  <td class="text-center"><?php echo $row->dag_no; ?></td>
                  <td class="text-center"><?php echo $measure[0]; ?></td>
                  <td class="text-center"><?php echo $measure[1]; ?></td>
                  <td class="text-center"><?php echo $measure[2]; ?></td>
                  <td class="text-center"><?php echo get_Hec_Are_CAre($bigha, $katha, $lessa);; ?></td>
                  <td class="text-center"><?php echo $row->dag_revenue; ?></td>
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
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport'?>";
    };
</script>