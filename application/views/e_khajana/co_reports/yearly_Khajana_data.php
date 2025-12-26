<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaLmController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<?php $circle_name = $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
<?php $rev_year = $year;?>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana- Monthly revenue receievd for the Revenue year: <span style="color:yellow"> <?=$rev_year?></span></b><br>
            </u>                        
        </h3>
    </div>
    <input type="hidden" id="revenue-year" value="<?=$rev_year?>">
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="co_yearly_amount_data" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Circle Name</td>
                                <td>Month</td>
                                <td>Amount Received</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($yearly_amount as $row):?>                                    
                                <tr>                                    
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?= $circle_name?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$row->case?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                        Rs <?=$row->amount_recv?>
                                        <span>
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
<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>

