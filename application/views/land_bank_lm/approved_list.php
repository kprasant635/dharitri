<div id="displayBoxLB" style="display: none;"><img src="<?= base_url(); ?>assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
document.onreadystatechange = function(e)
{
    $.blockUI({
        message: $('#displayBoxLB'),
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
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Approved-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Approved-List) <br>
                <?php echo $this->lang->line('mouza') ?> :
                <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$circle_code,$mouza_code); ?>, 
                <?php echo $this->lang->line('lot_no') ?> : 
                <?php echo $this->utilityclass->getLotName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no); ?>
            </u>                        
        </h3>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="landBank_approved_list_dt" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Village-Name</td>
                                <td>Dag-No</td>
                                <td>Approve-Time</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($approved_list as $approved):?>                                    
                                <tr>
                                    <td>
                                        <span class="text-primary font-weight-bold" id="lb_view_village_name_<?=$approved->id?>">
                                            <?= $this->utilityclass->getVillageName($approved->dist_code, $approved->subdiv_code, 
                                            $approved->cir_code, $approved->mouza_pargona_code, $approved->lot_no, $approved->vill_townprt_code)?>
                                        </span>                                     
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            <?= $approved->dag_no?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary font-weight-bold">
                                            <?= $approved->created_at?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary btn-sm text-white" onclick="lbViewModal('<?=$approved->id?>', 'approve_list')">
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
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_lm.js"></script>