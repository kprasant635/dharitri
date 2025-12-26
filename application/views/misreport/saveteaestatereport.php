<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
             <table class="table table-striped table-bordered" width="100%">
                 <tr class="active">
                    <td colspan="8" class="text-center"><h2>Tea Estate Wise Land Area for Mouza : <code><?php echo $namedata[3]->mouza;?></code></h2></td>
                </tr>
                <tr class="success">
                    <td colspan="3" class="text-center"><h4><?php echo $this->lang->line('district');?> : <?php  echo $namedata[0]->district;?></h4></td>
                    <td class="text-center"><h4><?php echo $this->lang->line('subdivision');?> : <?php  echo $namedata[1]->subdiv;?></h4></td>
                    <td colspan="4" class="text-center"><h4><?php echo $this->lang->line('circle');?> : <?php  echo $namedata[2]->circle;?></h4></td>
                </tr>
                <tr class="danger">
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('sl_no');?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('Name_oftheteaestate'); ?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('dag_no');?></strong></td>
                    <td rowspan="2" class="text-center"><strong><?php echo $this->lang->line('patta_no');?></strong></td>
                    <td colspan="4" class="text-center"><strong><?php echo $this->lang->line('land_area');?></strong></td>
                </tr>
                <tr class="danger">
                    <td class="text-center"><?php echo $this->lang->line('bigha');?></td>
                    <td class="text-center"><?php echo $this->lang->line('katha');?></td>
                    <td class="text-center"><?php echo $this->lang->line('lesa');?></td>
                    <td class="text-center"><?php echo $this->lang->line('hec_are_care');?></td>
                </tr>
                <?php 
                $i=0;
                $array_class=array();
                
                foreach($stats as $s):
                    $bigha=$s['b'];
                    $katha=$s['k'];
                    $lessa=$s['l'];
                    $hec=$this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $dag_no=$s['dag_no'];
                    
                    $key=  in_array($dag_no, $array_class);
                    
                    if($key=='')
                    {
                        $i++;
                        $array_class[].= $dag_no;
                        $l=$dag_no;
                        $b=$bigha;
                        $k=$katha;
                        $lc=$lessa;
                        $hc=$hec;
                       
                       
                    }
                    else 
                    {
                        
                        $l='';
                        $b='';
                        $k='';
                        $lc='';
                        $hc='';
                    }
                    
                ?>
                 <tr>
                  <td class="text-center">
                    <?php echo $i;?></td>
                  <td class="text-center"><?php echo $s['estatename'];?></td>
                  <td class="text-center"><?php echo $l; ?></td>
                  <td class="text-center"><?php echo $s['patta_no'];?></td>
                  <td class="text-center"><?php echo $b;?></td>
                  <td class="text-center"><?php echo $k;?></td>
                  <td class="text-center"><?php echo $lc;?></td>
                  <td class="text-center"><?php echo $hc;?></td>
                </tr>
               <?php 
               $i = 1+$i;
               endforeach;?>
                <tr>
                    <td class="text-center" colspan="8">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/MisTeaReport'?>";
    };
</script>