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
                        <td colspan="3">E-Khajana CFR Details</td>
                    </tr>
                    <tr>
                        <td>Update-CFR-Details</td>
                        <td>
                            <span class="badge badge-warning"></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCFR/updatCFRdetailsForm' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>  
                    <tr>
                        <td>View-Updated-CFR-Details</td>
                        <td>
                            <span class="badge badge-warning"></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/EkhajanaCFR/viewCfrDetails' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>  
                </table>
            </div>
        </div>
    </div>               
</div>


