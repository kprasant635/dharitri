<div class="row" style="min-height: 500px;">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid" style="color: #315b75;"><u>The contents of Master <b><u> <?php echo $table_name; ?> </u></b></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        
                        <table class="table table-striped table-bordered tablesorter pageshowpage">
                            <thead>
                                <th><b><?php echo $this->lang->line('code');?></b></th>
                                <th><b><?php echo $this->lang->line('type');?></b></th>
                            </thead>
                            <?php foreach($master_result as $m_result): ?>
                            <tr>
                                <td style="font-family:ASBW-TTBidisha;font-size: 18pt"><?php echo $m_result->code; ?></td>
                                <td style="font-family:ASBW-TTBidisha;font-size: 18pt"><?php echo $m_result->type; ?></td>
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
