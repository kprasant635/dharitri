<div class="row" style="min-height: 500px;">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid" style="color: #315b75;"><u>The contents of Master <b><u> Users </u></b></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        
                        <table class='table table-striped table-bordered tablesorter pageshowpage'>
                            <thead>
                                <th><b><?php echo $this->lang->line('location_code');?></b></th>
                                <th><b><?php echo $this->lang->line('user_name');?></b></th>
                                <th><b><?php echo $this->lang->line('code');?></b></th>
                            </thead>
                            <?php foreach($table_result as $m_result): ?>
                            <tr>
                                <td>
                                    <?php
                                    $loc2 = $m_result->subdiv_code;
                                    if($m_result->subdiv_code == ' ')
                                    {
                                        $loc2 = '00';
                                    }
                                    $loc3 = $m_result->cir_code;
                                    if($m_result->cir_code == ' ')
                                    {
                                        $loc3 = '00';
                                    }
                                    $dist_name = $this->utilityclass->getDistrictName($m_result->dist_code);
                                    $sub_div_name = $this->utilityclass->getSubDivName($m_result->dist_code, $loc2);
                                    $cir_name = $this->utilityclass->getCircleName($m_result->dist_code, $loc2, $loc3);
                                    if(($loc2 == '00') && ($loc3 == '00'))
                                    {
                                        echo $dist_name."<br>";
                                        echo $m_result->dist_code."-".$loc2."-".$loc3;
                                    }
                                    else {
                                        echo $dist_name."-".$sub_div_name."-".$cir_name."<br>";
                                        echo $m_result->dist_code."-".$loc2."-".$loc3;
                                    }
                                    ?>
                                </td>
                                <td style="font-family:ASBW-TTBidisha;font-size: 18pt"><?php echo $m_result->username; ?></td>
                                <td align='center'><?php echo $m_result->user_code; ?></td>
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





