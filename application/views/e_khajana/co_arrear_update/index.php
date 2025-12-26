<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">ARREAR-UPDATE(CO)</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">ARREAR UPDATE(CO)</td>
                    </tr>
                    <tr class="hide">
                        <td>View-Doul</td>
                        <td>
                            <span class="badge badge-success">DOUL</span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaDoulController/viewDoulForAllMouza' ?>" class="green" style="float:right">view</a></td> 
                        </td>
                    </tr>
                    <tr>
                        <td>Update-Arrear-Details</td>
                        <td>
                            <span class="badge badge-primary"><?=$pending_count?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCoArrearUpdateController/ArrearUpdateForm' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>View-Updated-Arrear</td>
                        <td>
                            <span class="badge badge-warning"><?=$updated_patta_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/EkhajanaCoArrearUpdateController/ViewUpdatedArrear' ?>" class="green" style="float:right">view</a></td> 
                    </tr>             
                </table>
            </div>
        </div>
    </div>               
</div>
