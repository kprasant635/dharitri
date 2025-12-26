<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid" style="color: #315b75;"><u>The contents of Master <b><u> Patta Code </u></b></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <table class="table table-striped table-bordered tablesorter pageshowpage">
                            <thead>
                                <tr>
                                    <th rowspan="2">
                                        <b><?php echo $this->lang->line('code');?></b>
                                    </th>
                                    <th rowspan="2">
                                        <b><?php echo $this->lang->line('type');?></b>
                                    </th>
                                    <th colspan="4" style="text-align: center;">
                                        <b><?php echo $this->lang->line('required_for');?></b>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <b><?php echo $this->lang->line('required_for_mutation_cases');?></b>
                                    </th>
                                    <th style="text-align:center">
                                        <b><?php echo $this->lang->line('required_for_conversion_cases');?></b>
                                    </th>
                                    <th style="text-align:center">
                                        <b><?php echo $this->lang->line('required_for_jamabandi');?></b>
                                    </th>
                                    <th style="text-align:center">
                                        <b><?php echo $this->lang->line('apcancellation');?></b>
                                    </th>
                                </tr>
                            </thead>
                            <?php foreach($table_result as $m_result): ?>
                            <tr>
                                <td><?php echo $m_result->type_code; ?></td>
                                <td><?php echo $m_result->patta_type; ?></td>
                                <td style="font-size: 12pt" align="left">
                                    <?php
                                    if($m_result->mutation == 'a')
                                    {
                                        echo "<img border='0' src='".base_url()."application/views/images/correct.gif'> <font color='#008080'>যি কোনো সুত্রে</font>";
                                    }
                                    elseif($m_result->mutation == 'i')
                                    {
                                        echo "<img border='0' src='".base_url()."application/views/images/correct.gif'> <font color='blue'>কেবল উত্তৰাধিকাৰ / উঃ দঃ সুত্রে</font>";
                                    }
                                    else
                                    {
                                        echo "<img border='0' src='".base_url()."application/views/images/wrong.gif'> None";
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if($m_result->conversion == 'y')
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/correct.gif'></u></b>";
                                    }
                                    else
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/wrong.gif'></u></b>";
                                    }
                                    ?>
                                </td>
                                <td width="140" align="center">
                                    <?php
                                    if($m_result->jamabandi == 'y')
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/correct.gif'></u></b>";
                                    }
                                    else 
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/wrong.gif'></u></b>";
                                    }
                                    ?>
                                </td>
                                <td width="140" align="center">
                                    <?php
                                    if($m_result->apcancellation == 'y')
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/correct.gif'></u></b>";
                                    }
                                    else 
                                    {
                                        echo "<b><u><img border='0' src='".base_url()."application/views/images/wrong.gif'></u></b>";
                                    }
                                    ?>
                                </td>
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
