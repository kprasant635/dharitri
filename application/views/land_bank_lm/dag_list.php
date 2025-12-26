<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
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

<style type="text/css">
    .modal-body{
        max-height: calc(100vh - 300px);
        overflow-y: auto;
    }
    .nav-item.show .nav-link, .nav-link.active
    {
        background-color: orange!important;
        color: black;
    }
    .blockUI{
        z-index: 1100!important;
    }
    .datepick-popup{
        position: fixed;
        left:0 px;
        right:0 px;
        z-index:10000;
    }
</style>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="<?php echo base_url() . 'index.php/LandBankLM/VillageList'.'?flag='.$flag?>">
        Village Land Bank-(Village-list)</a>
    </li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">
        Village Land Bank-(Dag-list)
    </li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            <u>
                <?php echo $this->lang->line('land_bank_header') ?> -
                <?php echo $this->lang->line('land_bank_table_header'); ?><br>
                <?php echo $this->lang->line('mouza') ?> :
                <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$circle_code,$mouza_code); ?>, 
                <?php echo $this->lang->line('lot_no') ?> : 
                <?php echo $this->utilityclass->getLotName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no); ?>, 
                <?php echo $this->lang->line('vill_town') ?> : 
                <?php echo $this->utilityclass->getVillageName($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code); ?>
            </u>        
            
        </h3>
    </div>
    <div class="panel-heading bg-warning text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            NOTE : SOME DAG'S WILL BE AVAILABLE IN THE PENDING LIST
        </h6>
    </div>
    <div class="card-body">
        <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                <table id="landBank_dag_list" class="table table-hover text-center" style="width:100%">            
                    <thead class="thead-dark">                            
                        <tr>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_dag_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_class'); ?></label></th>
                            <?php if ($dist_code !==21): ?>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_area_bigha'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_area_katha'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_area_lessa'); ?></label></th>
                            <?php else: ?>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_area_gonda'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_land_area_kranti'); ?></label></th>
                            <?php endif ?>    
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('land_bank_table_header_action'); ?></label></th>
                        </tr>                                                        
                    </thead>
                    <tbody>
                        <?php foreach ($land_details as $land_detail):?>
                            <?php if ($this->utilityclass->checkUpdateStatus($dist_code, $subdiv_code, $circle_code, $mouza_code,$lot_no, $vill_code, $land_detail->dag_no, $flag)): ?>                                
                                <td>
                                    <span class="font-weight-bold text-primary">
                                        <?=$land_detail->dag_no?>
                                    </span>
                                </td>
                                <td><?=$this->utilityclass->getLandClassCode($land_detail->land_class_code)?></td>
                                <?php if ($dist_code !==21): ?>
                                    <td><?=$land_detail->dag_area_b?></td>
                                    <td><?=$land_detail->dag_area_k?></td>
                                    <td><?=$land_detail->dag_area_lc?></td>
                                <?php else: ?>
                                    <!-- <td><?=$land_detail->dag_area_g?></td>
                                    <td><?=$land_detail->dag_area_kr?></td> -->
                                <?php endif ?>  
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="getLbLmUpdateForm('<?=$land_detail->dag_no?>')">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        Add Details
                                    </button>
                                </td>
                            <?php endif ?>  
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- land bank details add modal  -->
<?php include 'lm_update_form.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_lm.js"></script>