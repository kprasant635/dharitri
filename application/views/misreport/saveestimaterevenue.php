<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <div class="alert alert-success" role="alert">
                <?php //echo print_r($query); ?>
                <h4>Land Area and Estimated Revenue for Mouza : <code><?php echo $namedata[3]->mouza;?></code></h4>
            </div>
            <div class="alert alert-info" role="alert">
                <h4><?php echo $this->lang->line('district');?> : <code><?php echo $namedata[0]->district;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision'); ?> : <code><?php   echo $namedata[1]->subdiv;?></code> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle'); ?> : <code><?php   echo $namedata[2]->circle;?></code></h4>
            </div>
            <table class="table table-striped table-bordered" width="100%" border="1">

                <tr class="danger">
                    <th class="text-center uni_text" rowspan="2"><?php echo $this->lang->line('total_dag_area'); ?></th>
                    <th class="text-center uni_text" rowspan="2"><?php echo $this->lang->line('total_patta'); ?></th>
                    <th class="text-center uni_text" colspan="4"><?php echo $this->lang->line('land_area_b_k_l'); ?></th>
                    <th class="text-center uni_text" rowspan="2"><?php echo $this->lang->line('total_revenue');?> (Rs/-)</th>
                    <th class="text-center uni_text" rowspan="2"><?php echo $this->lang->line('local_tax');?> (Rs/-)</th>
                    
                </tr>
                <tr class="danger">
                    <th class="text-center uni_text"><?php echo $this->lang->line('bigha'); ?></th>
                    <th class="text-center uni_text"><?php echo $this->lang->line('katha'); ?></th>
                    <th class="text-center uni_text"><?php echo $this->lang->line('lesa'); ?></th>
                    <th class="text-center uni_text"><?php echo $this->lang->line('Hec-Are-CAre'); ?></th>
                </tr>
                <?php
                                $bigha=$query[2]->bigha;
                                $katha=$query[2]->ktha;
                                $lessa=$query[2]->lessa;
                                $total_lessa=$this->utilityclass->Total_Lessa($bigha,$katha,$lessa);
                                $get_Hec_Are_CAre=$this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                                $measure=$this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                ?>
                <tr>
                    <td class="text-center"><?php echo $query[0]->dag; ?></td>
                    <td class="text-center"><?php echo $query['1']->patta;  ?></td>
                    <td class="text-center"><?php echo $measure[0]; ?></td>
                    <td class="text-center"><?php echo $measure[1];  ?></td>
                    <td class="text-center"><?php echo $measure[2];  ?></td>
                    <td class="text-center"><?php echo $get_Hec_Are_CAre;?></td>
                    <td class="text-center"><?php echo number_format($query[2]->revenue,2);  ?></td>
                    <td class="text-center"><?php echo number_format($query[2]->localtax,2);  ?></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="8">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/LandRevenueEstimateRevenue' ?>";
    };
</script>
