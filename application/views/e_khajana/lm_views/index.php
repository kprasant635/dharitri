<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana</li>
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
                        
                        <td>Pending-List (Tehsildari Area)</td>
                        <td>
                            <span class="badge badge-warning"><?=$pending_count_tehsiladari_area?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaLmController/pendingList' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <?php if(EKHAJANA_LM_MOUZADARI_SYSTEM == 1): ?>
                    <tr>
                        <td>Pending-List (Mouzadari-Area)</td>
                        <td>
                            <span class="badge badge-success"><?=$pending_count_mouzadari_area?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaLmController/LmPendingListformouzadarisystem' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if(EKHAJANA_LM_DP_ESTATE_SYSTEM == 1): ?>
                    <tr>
                        <td>Pending-List (Direct Paying Estate)</td>
                        <td>
                            <span class="badge badge-success"><?=$pending_count_dpEstate?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaLmController/LmPendingListforDpEstate' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr> 
                    <?php endif; ?> 
                </table>
            </div>
        </div>
    </div>               
</div>
