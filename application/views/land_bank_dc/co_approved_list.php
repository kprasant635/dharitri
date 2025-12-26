<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
document.onreadystatechange = function(e)
{
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });    
};
window.onload = function(){   
    $.unblockUI();
}
</script>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankCO/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Approved-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Approved-List) : District - <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$circle_code); ?>, 
            </u>                        
        </h3>
    </div>
    <div class="panel-heading bg-secondary text-center">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="form-group">
                    <form action="<?php echo base_url() . 'index.php/LandBankDC/getApprovedList' ?>" method="post" id="lb_pagination_form">
                        <label for="exampleFormControlSelect1">-PLEASE SELECT A RANGE-</label>
                        <select class="form-control text-center" name="lbCoPageOffset" id="lbCoPageOffset">
                            <?php
                                $start = 0;
                                for ($x = 0; $x < $no_of_pagination_optinos; $x++) {                                 
                                    $end = $start+(int)LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
                                    $y= (int)$x * (int)LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
                                    if($y == $offset){
                                        echo '<option value="'.$y.'" selected>DISPLAYING-('.$start.'-'.$end.')-ROWS</option>';
                                    }else{
                                        echo '<option value="'.$y.'">DISPLAYING-('.$start.'-'.$end.')-ROWS</option>';
                                    }
                                    $start = $start +(int)LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT; 
                                }
                            ?>    
                        </select>
                        <button class="btn btn-primary btn-sm mt-1"><i class="fa fa-paper-plane" aria-hidden="true"></i> SUBMIT</button>
                    </form>                    
                </div>

                <div class="form-group">
                    <form action="<?php echo base_url() . 'index.php/LandBankDC/searchApprovedListByDag' ?>" method="post" id="lb_pagination_form">
                        <label for="exampleFormControlSelect1">ENTER DAG NO TO SEARCH</label>
                        <input type='text' class="form-control text-center" name="lbsearchdag" id="lbsearchdag"/>
                            
                        <button class="btn btn-primary btn-sm mt-1"><i class="fa fa-paper-plane" aria-hidden="true"></i> SEARCH</button>
                    </form>                    
                </div>
            </div>
        </div>        
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="landBank_pending_list_dt" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Village-Name</td>
                                <td>Dag-No</td>
                                <td>Created-By</td>
                                <td>Created-At</td>
                                <td>View</td>                                
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($pending_list as $pending):?>                                    
                                <tr>
                                    <td>
                                        <span class="text-primary font-weight-bold" id="lb_view_village_name_<?=$pending->id?>">
                                            <?= $this->utilityclass->getVillageName($pending->dist_code, $pending->subdiv_code, 
                                            $pending->cir_code, $pending->mouza_pargona_code, $pending->lot_no, $pending->vill_townprt_code)?>
                                        </span>                                     
                                    </td>
                                    <td>
                                        <span class="text-secondary font-weight-bold">
                                            <?= $pending->dag_no?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-primary font-weight-bold">
                                            <?= $this->utilityclass->getDefinedMondalsName($pending->dist_code, $pending->subdiv_code, 
                                            $pending->cir_code, $pending->mouza_pargona_code, $pending->lot_no,$pending->user_code)->lm_name?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary font-weight-bold">
                                            <?= $pending->created_at?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm text-white" onclick="lbViewModalByDC('<?=$pending->id?>', '' )">
                                            <i class="fa fa-eye"></i>
                                            View
                                        </button>
                                    </td>                                                                
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- land bank details add modal  -->
<?php include 'lb_view_form.php'; ?>
<!-- land bank approve remark modal  -->
<?php include 'lb_approve_rmk_modal.php'; ?>
<!-- land bank revert remark modal  -->
<?php include 'lb_revert_rmk_modal.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_dc.js"></script>