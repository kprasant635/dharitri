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
                        <td colspan="3">E-Khajana(Arrear-Update)</td>
                    </tr>
                    <tr>
                        <td>Pending-List</td>
                        <td>
                            <span class="badge badge-warning"><?=$pendingCount?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaAstController/pendingList' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr class="hide">
                        <td>Updated-List</td>
                        <td>
                            <span class="badge badge-success">--</span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaLmController/forwardedToCoList' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>    
                </table>
            </div>
        </div>
    </div>               
</div>