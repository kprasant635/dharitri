<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Demand Notice Generation)</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">E-Khajana</td>
                    </tr>
                    <tr>
                        <td>Generate Demand Notice(DP estate)</td>
                        <td>
                            <span class="badge badge-warning"><?=$generate_count?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaDemandNoticeController/index_directPaying' ?>" class="green" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>View Generated Demand Notice(DP estate)</td>
                        <td>
                            <span class="badge badge-danger"><?=$view_count?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaDemandNoticeController/viewDemandNoticeGenerated' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>               
</div>


