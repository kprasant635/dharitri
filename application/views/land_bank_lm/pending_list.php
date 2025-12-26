
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-warning text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Pending-List) <br>
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
                    <table id="landBank_pending_list_dt" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Village-Name</td>
                                <td>Dag-No</td>
                                <td>Pending With</td>
                                <td>Created-At</td>
                                <td>Action</td>
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
                                        <span class="text-success font-weight-bold">
                                            <?= $pending->dag_no?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            <?= $pending->status == LAND_BANK_STATUS_PENDING ? 'CO' : 
                                                ($pending->status == LAND_BANK_STATUS_FORWARD ? 'DC' : 'NA')
                                             ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary font-weight-bold">
                                            <?= $pending->created_at?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm text-white" onclick="lbViewModal('<?=$pending->id?>', '')">
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