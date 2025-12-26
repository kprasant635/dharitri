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
                    <tr>
                        <td>Pending-Lists</td>
                        <td>
                            <span class="badge badge-warning"><?=$pending_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankCO/PendingList' ?>" class="text-warning" style="float:right">view</a></td>
                    </tr>
                    <tr>
                        <td>Approved-Lists</td>
                        <td>
                            <span class="badge badge-success"><?=$approve_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankCO/getApprovedList' ?>" class="green" style="float:right">view</a></td>
                    </tr>
                    <tr>
                        <td>Village Report</td>
                        <td>
                            <span class="badge badge-primary">Village-Wise</span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankReport/index' ?>" class="text-primary" style="float:right">view</a></td>
                    </tr> 
                    <tr>
                        <td>Land Bank Report</td>
                        <td>
                            <span class="badge badge-info">Lot-Wise/Village-Wise</span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankReport/LotWiseReport' ?>" class="text-info" style="float:right">view</a></td>
                    </tr>
                    <tr>
                        <td>VGR/PGR Dag's Report<br>(For-Type Of Encroacher)</td>
                        <td>
                            <span class="badge badge-danger">Lot-Wise</span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankReport/LotWiseVgrPgrReport' ?>" class="text-info" style="float:right">view</a></td>
                    </tr>

                    <tr>
                        <td>Dag's Details Report<br>(Status of Dag Update)</td>
                        <td>
                            <span class="badge badge-warning">Dag-Wise</span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/LandBankCO/vlbDagDetails' ?>" class="text-info" style="float:right">view</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>               
</div>