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
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankLM/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank-(Village-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            <u>
                Village Land Bank - (Village-List) <br>
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
                    <table id="landBank_district_wise" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Village Name</td>
                                <?php if ($flag == 2): ?>
                                    <td>All Dag's</td>
                                    <td>VGR Dag's</td>
                                    <td>PGR Dag's</td>
                                <?php else :?>  
                                    <td>Action</td>
                                <?php endif ?>  
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($villageList as $village):?>                                    
                                <tr>                                    
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?= $village['village_name']?>
                                        <span>
                                    </td>
                                    <?php if ($flag == 2): ?>
                                        <td>
                                            <a class="btn btn-success btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/LandBankLM/DagList/'. $village['village_code'].'?flag='.$flag?>" 
                                            role="button" style="font-size: 16px;">
                                                View All Dag List
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/LandBankLM/VGRdagList/'. $village['village_code'].'?flag='.$flag?>" 
                                            role="button" style="font-size: 16px;">
                                                View VGR Dag List
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/LandBankLM/PGRdagList/'. $village['village_code'].'?flag='.$flag?>" 
                                            role="button" style="font-size: 16px;">
                                                View PGR Dag List
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    <?php else :?>  
                                        <td>
                                            <a class="btn btn-success btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/LandBankLM/DagList/'. $village['village_code'].'?flag='.$flag?>" 
                                            role="button" style="font-size: 16px;">
                                                View All Dag List
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
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
</div>
<script src="<?php echo base_url(); ?>application/views/js/land_bank/land_bank_lm.js"></script>