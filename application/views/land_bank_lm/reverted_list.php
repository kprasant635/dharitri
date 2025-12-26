<div id="displayBoxLB" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
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
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Reverted-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-danger text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Reverted-List) <br>
                <?php echo $this->lang->line('mouza') ?> :
                <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$circle_code,$mouza_code); ?>, 
                <?php echo $this->lang->line('lot_no') ?> : 
                <?php echo $this->utilityclass->getLotName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no); ?>
            </u>                        
        </h3>
    </div>
    <div class="panel-heading bg-secondary text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            NOTE : DETAILS CAN BE RESEND FOR THE FOLLOWING DAG'S IN THE 'UPDATE-DETAILS' SECTION OF LAND BANK
        </h6>
    </div>
    <div class="card-body">
        <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                <table id="landBank_reverted_list_dt" class="table table-hover text-center" style="width:100%">            
                    <thead class="thead-dark">                            
                        <tr style="background-color: black; color: #fff;">
                            <td>Village-Name</td>
                            <td>Dag-No</td>
                            <td>Rejected By</td>
                            <td>Rejected-Time</td>
                            <td>View-Details</td>
                            <td>View-Remark</td>
                        </tr>                                                        
                    </thead>
                    <tbody>
                        <?php foreach ($reverted_list as $reverted):?>                                    
                            <tr>
                                <td>
                                    <span class="text-primary font-weight-bold" id="lb_view_village_name_<?=$reverted->id?>">
                                        <?= $this->utilityclass->getVillageName($reverted->dist_code, $reverted->subdiv_code, 
                                        $reverted->cir_code, $reverted->mouza_pargona_code, $reverted->lot_no, $reverted->vill_townprt_code)?>
                                    </span>                                     
                                </td>
                                <td>
                                    <span class="text-success font-weight-bold" id="lb_rejected_dag_no_<?=$reverted->id?>">
                                        <?= $reverted->dag_no?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success font-weight-bold" id="lb_rejected_dag_no_<?=$reverted->id?>">
                                        <?= $reverted->reverted_person == 'CO' ? 'CO' :
                                        ($reverted->reverted_person == 'DC' ? 'DC' : 'NA')?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-danger font-weight-bold font-weight-bold">
                                        <?= $reverted->created_at?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm text-white" onclick="lbViewModal('<?=$reverted->id?>','')">
                                        <i class="fa fa-eye"></i>
                                        View Details
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="viewRejectedRemark('<?=$reverted->id?>')">
                                        <i class="fa fa-eye"></i>
                                        View Remark
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
<?php include 'lb_view_form.php'; ?>
<!-- land bank approve remark modal  -->
<?php include 'lb_revert_rmk_display_modal.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_lm.js"></script>