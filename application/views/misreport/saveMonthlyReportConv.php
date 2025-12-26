<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10  panel panel-default panel-body  col-lg-offset-1">
            <div class="alert alert-success" role="alert">
                <h2 style="text-align: center; color: #fff" class="bold"><?php echo $this->lang->line('district'); ?> : <kbd>
				<?php  echo $namedata[0]->district;?></kbd> <?php echo $this->lang->line('subdivision'); ?> : <kbd>
				<?php  echo $namedata[1]->subdiv;?></kbd>  <?php echo $this->lang->line('circle'); ?> : <kbd><?php  echo $namedata[2]->circle;?></kbd><br><br>  Year : <code><?php  echo $year['year'];?></code> Month : <code><?php echo $this->utilityclass->getMonth($month_name['month_name']); ?></code></h2>
            </div>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="center info">
                        <th>Sl No. </th><th>Conversion Details</th><th>No Of Cases for which Order has been Passed</th><th>No Of Cases for which Chitha has been Corrected</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="center">
                        <td>1</td><td>No of Conversion</td>
                        <?php
                            $order_cases=($conv['order_passes']);
                            foreach ($order_cases AS $row):
                            $order_passed=$row->total_case;
                        ?>
                        <td><?php echo $order_passed; ?></td>
                        <?php endforeach;?>
                        <?php
                            $chita_cases=($conv['chitha_corrected']);
                            foreach ($chita_cases AS $row1):
                            $Chitha_corrected=$row1->total_case;
                        ?>
                        <td><?php echo $Chitha_corrected; ?></td>
                        <?php endforeach;?>
                    </tr>
                </tbody>
            </table>
            <hr>
            *Please Note : In some cases the no of order passed cases can be less than the no of chitha updated
            <hr>
            <table class="table table-bordered">
                <tbody>
                    <tr class="center">
                        <td></td><td></td><td>Bigha(s)</td><td>Ktha(s)</td><td>Lessa(s)</td><td>Hec-Are-CAre</td>
                    </tr>
                    <?php
                    $as=($conv['final_result']);
                    $bigha=$as['total_bigha'];
                    $katha=$as['total_kotha'];
                    $lessa=$as['total_lessa'];
                    
                    $total_lessa=$this->utilityclass->Total_Lessa($bigha,$katha,$lessa);
                    $get_Hec_Are_CAre=$this->utilityclass->get_Hec_Are_CAre($bigha, $katha, $lessa);
                    $measure=$this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    ?>
                    <tr class="center">
                        <td>2</td><td>Converted Land Area</td>
                        <td><?php echo $measure[0]; ?></td>
                        <td><?php echo $measure[1]; ?></td>
                        <td><?php echo $measure[2]; ?></td>
                        <td><?php echo $get_Hec_Are_CAre; ?></td>
                    </tr>
                    <tr class="center">
                        <td>3</td><td colspan="4">No of Patta Converted</td>
                        <td><?php echo $as['total_patta'];?></td>
                    </tr>
                    <tr class="center">
                        <td>4</td><td colspan="4">Premium Realized</td>
                        <td><?php echo $as['total_premium'];?></td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="6">
                            <button id="backButton" class="btn  btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
                    
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport/MonthlyReportConversion' ?>";
    };
</script>
