<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Chitha Flag Mapping</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>               
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">Chitha Flag Mapping</td>
                    </tr>
                    <tr>
                        <td>Pending-Lists</td>
                        <td>
                            <span class="badge badge-warning"><?=$pending_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/ChithaFlag/ChithaFlagPendingList' ?>" class="text-warning" style="float:right">view</a></td>
                    </tr>
                    <tr>
                        <td>Approved-Lists</td>
                        <td>
                            <span class="badge badge-success"><?=$approve_count?></span>                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/ChithaFlag/ChithaFlagApprovedList' ?>" class="green" style="float:right">view</a></td>
                    </tr>

                    <tr>
                        <td>Chitha Dag Flag Report</td>
                        <td>
                                                        
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/ChithaFlag/generateFlaggingReport' ?>" class="red" style="float:right">Generate Report</a></td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>               
</div>