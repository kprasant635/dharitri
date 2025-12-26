<div class="row" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('all_location_codes_details');?></u></span></p>
                </div>
                <center><a href="#anchor"><span style="color: red"><?php echo $this->lang->line('summary');?></span></a></center>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <table width="100%"  class="table table-bordered" style="text-align: center"> 
                                <tr>
                                    <td colspan="6" style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('location_code');?></font></b></td>
                                    <td rowspan="2" style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('location_name');?></font></b></td>
                                    <td rowspan="2" style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('type');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana">Total <?php echo $this->lang->line('dag_no');?></font></b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('district');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('subdivision');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('circle');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('mouza');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('lot_no');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana"><?php echo $this->lang->line('vill_town');?></font></b></td>
                                    <td style="background-color: #6699FF"><b><font color="#FFFFFF" face="Verdana">( <?php echo $this->lang->line('in_vill_town');?>)</font></b></td>
                                </tr>
                                <?php foreach ($table_result as $tables): ?>
                                    <tr>
                                        <td style='background-color: #DDEEFF'><b><?php echo $tables['dist_code']; ?></b></td>
                                        <?php
                                        if ($tables['subdiv_code'] == '00') {
                                            echo "<td><b>" . $tables['subdiv_code'] . "</b></td>";
                                        } else {
                                            echo "<td style='background-color: #DDEEFF'><b>" . $tables['subdiv_code'] . "</b></td>";
                                        }
                                        ?>
                                        <?php
                                        if ($tables['cir_code'] == '00') {
                                            echo "<td><b>" . $tables['cir_code'] . "</b></td>";
                                        } else {
                                            echo "<td style='background-color: #DDEEFF'><b>" . $tables['cir_code'] . "</b></td>";
                                        }
                                        ?>
                                        <?php
                                        if ($tables['mouza_pargona_code'] == '00') {
                                            echo "<td><b>" . $tables['mouza_pargona_code'] . "</b></td>";
                                        } else {
                                            echo "<td style='background-color: #DDEEFF'><b>" . $tables['mouza_pargona_code'] . "</b></td>";
                                        }
                                        ?>
                                        <?php
                                        if ($tables['lot_no'] == '00') {
                                            echo "<td><b>" . $tables['lot_no'] . "</b></td>";
                                        } else {
                                            echo "<td style='background-color: #DDEEFF'><b>" . $tables['lot_no'] . "</b></td>";
                                        }
                                        ?>
                                        <?php
                                        if ($tables['vill_townprt_code'] == '0000') {
                                            echo "<td><b>" . $tables['vill_townprt_code'] . "</b></td>";
                                        } else {
                                            echo "<td style='background-color: #DDEEFF'><b>" . $tables['vill_townprt_code'] . "</b></td>";
                                        }
                                        ?>
                                        <td><b><?php echo $tables['loc_name']; ?></b></td>
                                        <td><b><?php echo $tables['loc_type']; ?></b></td>
                                        <td><b><?php echo $tables['dags']; ?></b></td>
                                    </tr>
                                    <?php endforeach; ?>
                            </table>
                            <centre>
							<table id="anchor" width="50%" style="text-align: center; border: 1px dashed #0F5CA9">
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('dag_no');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_dags']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('vill_town');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalvillage']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('lot_no');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totallot']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('mouza');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalmouza']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('circle');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['totalcir']; ?></td></tr>
                                <tr><td style='background-color: #DDEEFF' width='25%'><?php echo $this->lang->line('subdivision');?> :</td><td style='background-color: #DDEEFF' width='25%'><?php echo $totalresult['total_subdivs']; ?></td></tr>
                            </table>
                            </centre>
                            
                            <?php 
                            if (($totalresult['usercode'] == 'ADC') || ($totalresult['usercode'] == 'DC') || ($totalresult['usercode'] == 'CO')) {
                            ?>
                            [ <a href="<?php echo base_url(); ?>index.php/initialization/location"><?php echo $this->lang->line('home');?></a> ]
                            <?php
                            }
                            ?>
                        </center>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
