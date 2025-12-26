<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Khajana-Update)</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">E-Khajana-(CO-Khajana-Approve)</td>
                    </tr>
                    <tr>
                        <td>Pending-List (Tehsildari Area)</td>
                        <td>
                            <span class="badge badge-warning"><?=$pendingCount?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingList' ?>" class="green" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Reverted-Case-List(Tehsildari Area)</td>
                        <td>
                            <span class="badge badge-danger"><?=$revertedCount?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/revertedList' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <?php if(EKHAJANA_CO_MOUZADARI_SYSTEM == 1): ?>
                    <tr>
                        <td>Pending-List(Mouzadari Area)</td>
                        <td>
                            <span class="badge badge-success"><?=$pendingCountMouzadari?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingListMouzadari' ?>" class="green" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <td>Mouzadar's Objection Cases List</td>
                        <td>
                            <span class="badge badge-primary"><?=$mouzadarObjectionCount?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/mouzadarObjectionList' ?>" class="yellow" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr class="hide">
                        
                        <td>Approved-List</td>
                        <td>
                            <span class="badge badge-success">--</span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/approvedList' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <?php if(EKHAJANA_CO_DP_ESTATE_SYSTEM == 1): ?> 
                    <tr>
                        <td>Pending List(Direct Paying Estate)</td>
                        <td>
                            <span class="badge badge-info"><?=$pendingCountDpEstate?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/dpEstatePendingList' ?>" class="yellow" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr> 
                    <?php endif; ?>  
                </table>
            </div>
        </div>
    </div>               
</div>


