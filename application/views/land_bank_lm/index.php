<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">VILLAGE LAND BANK</td>
                    </tr>
                    <tr class="bg-danger" style="background: #1fa100 !important;">
                        <td colspan="2">No Of VGR Dag's To Be Updated(For-Type Of Encroacher) </td>
                        <td class="text-right">
                            <span class="badge badge-info" style="background-color:#000000;"><?=$vgrPendingCount?></span>                                        
                        </td>
                    </tr>
                    <tr class="bg-danger" style="background: #cc0b0b !important;">
                        <td colspan="2">No Of PGR Dag's To Be Updated(For-Type Of Encroacher)</td>
                        <td class="text-right">
                            <span class="badge badge-primary" style="background-color:#000000;"><?=$pgrPendingCount?></span>                                        
                        </td>
                    </tr>
                    <tr>
                        <td>Add-Details</td>
                        <td>
                            <span class="badge badge-primary"><?=$add_count?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/LandBankLM/VillageList?flag=1' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Update-Details</td>
                        <td>
                            <span class="badge badge-primary"><?=$update_count?></span>                                        
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/LandBankLM/VillageList?flag=2' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Pending-Lists</td>
                        <td>
                            <span class="badge badge-warning"><?=$pending_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankLM/PendingList' ?>" class="green" style="float:right">view</a></td>
                    </tr>    
                    <tr>
                        <td>Rejected-Lists</td>
                        <td>
                            <span class="badge badge-danger"><?=$rejected_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankLM/RevertedList' ?>" class="red" style="float:right">view</a></td>
                    </tr>
                    <tr>
                        <td>Approved-Lists</td>
                        <td>
                            <span class="badge badge-success"><?=$approved_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankLM/ApprovedList' ?>" class="green" style="float:right">view</a></td>
                    </tr>          
                    <tr>
                        <td>Encroacher-Excel-Format</td>
                        <td>
                            <span class="badge badge-secondary">(Encroacher-Format)</span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_LOCATION."/". LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_NAME.".xlsx" ?>" class="text-primary" style="float:right">DOWNLOAD</a></td>
                    </tr> 
                    <tr>
                        <td>Import Occupiers</td>
                        <td></td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/LandBankLM/VillageListSvamitva' ?>" class="red" style="float:right"><?php echo $this->lang->line('go') ?>
                        </td>
                    </tr>       
                </table>
            </div>
        </div>
    </div>               
</div>
