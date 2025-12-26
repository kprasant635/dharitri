<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success text-center" role="alert">
                <h2 style="text-align: center; color: rgb(143, 28, 28);font-weight: bold !important;">Deatils Arrear Premium Of Conversion for Mouza
                     :
                     <?php echo $namedata[3]->mouza; ?></h2>
                <h4><?php echo $this->lang->line('district');?> : <code><?php  echo $namedata[0]->district;?></code>  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <code><?php  echo $namedata[1]->subdiv;?></code> 
                    &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <code><?php  echo $namedata[2]->circle;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('month');?> : <kbd>
				<?php  echo $this->utilityclass->getMonth($namedata['month_name']);?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('year');?> : <kbd><?php  echo $namedata['year'];?></kbd></h4>
            </div>
            <table class="table table-striped table-bordered" width="100%">
                <tr class="info">
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('sl_no');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('lot_no');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('vill_town');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('conversion_no');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('patta_no');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('dag_no');?></td>
                    <td class="center" width="88" rowspan="2"><?php echo $this->lang->line('pattadar_name');?></td>
                    <td class="center" width="100" colspan="3"><?php echo $this->lang->line('land_area');?></td>
                    <td class="center" width="189" rowspan="2"><?php echo $this->lang->line('premium_to_be_released_as_arrear');?></td>
                </tr>
                <tr class="info">
                    <td class="center"><?php echo $this->lang->line('bigha');?></td>
                    <td class="center"><?php echo $this->lang->line('katha');?></td>
                    <td class="center"><?php echo $this->lang->line('lesa');?></td>
                </tr>
                <?php
                $i='1';
                foreach ($conv as $row1):
                    //$i='1';
                ?>
                <tr>
                    <td class="center"><?php echo $i;?></td>
                    <td class="center"><?php echo $row1['lot_no'];?></td>
                    <td class="center"><?php echo $row1['vill_townprt_code'];?></td>
                    <td class="center"><?php echo $row1['case_no'];?></td>
                    <td class="center"><?php echo $row1['patta_no'];?></td>
                    <td class="center"><?php echo $row1['new_dag_no'];?></td>
                    <td class="center" width='30%'>
                        <?php 
                        $c=0;
                        //var_dump($row1['pattadars']);
                        foreach ($row1['pattadars'] as $pdars):
                        foreach ($pdars As $pd){
                        echo "<p>".$pdars->pdars."</p>";
                        }
                        $c++;
                        endforeach;
                        ?></td>
                    <td class="center"><?php echo $row1['m_dag_area_b'];?></td>
                    <td class="center"><?php echo $row1['m_dag_area_k'];?></td>
                    <td class="center"><?php echo $row1['m_dag_area_lc'];?></td>
                    <td class="center"><?php echo $row1['min_revenue'];?></td>
                </tr>
                <?php 
                $i=$i+1;
                endforeach;?>
                <?php
                if($i=='0')
                {
                    echo "<tr><td class='center' colspan='11'>No Records Found</td></tr>";
                }
                ?>
                 <tr>
                    <td class="text-center" colspan="11">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/ConversionArrearPremium'?>";
    };
</script>

