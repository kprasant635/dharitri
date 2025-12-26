<div class="row" style="min-height: 500px;">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid" style="color: #315b75;"><u>The contents of Master <b><u> LM Code </u></b></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">

                        <table class="table table-striped table-bordered tablesorter pageshowpage">
                            <thead>
                                <th><b><?php echo $this->lang->line('location_code');?></b></th>
                                <th><b><?php echo $this->lang->line('lm_name');?></b></th>
                                <th><b><?php echo $this->lang->line('lm_code');?></b></th>
                            </thead>
                            <?php foreach($table_result as $m_result): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $dist_name = $this->utilityclass->getDistrictName($m_result->dist_code);
                                    $sub_div_name = $this->utilityclass->getSubDivName($m_result->dist_code, $m_result->subdiv_code);
                                    $cir_name = $this->utilityclass->getCircleName($m_result->dist_code, $m_result->subdiv_code, $m_result->cir_code);
                                    $mouza_pargona_code = $this->utilityclass->getMouzaName($m_result->dist_code, $m_result->subdiv_code, $m_result->cir_code, $m_result->mouza_pargona_code);
                                    $lot_no = $this->utilityclass->getLotName($m_result->dist_code, $m_result->subdiv_code, $m_result->cir_code, $m_result->mouza_pargona_code, $m_result->lot_no);
                                    echo $dist_name."-".$sub_div_name."-".$cir_name."-".$mouza_pargona_code."-".$lot_no."<br>";
                                    echo $m_result->dist_code."-".$m_result->subdiv_code."-".$m_result->cir_code."-".$m_result->mouza_pargona_code."-".$m_result->lot_no ;
                                    ?>
                                </td>
                                <td><?php echo $m_result->lm_name; ?></td>
                                <td><?php echo $m_result->lm_code; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <hr>
                        <p align='center'>
                            [ <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><?php echo $this->lang->line('home');?></a> ]
                        </p>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>


