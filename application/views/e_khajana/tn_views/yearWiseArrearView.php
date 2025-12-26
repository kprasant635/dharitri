<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajna-(Year Wise Arrear)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>Financial Year</td>
                                <td>Revenue</td>
                                <td>Local Tax</td>
                                <td>Surcharge</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($year_wise_arrear as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$row->financial_year?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->year_revenue?>
                                        <span>
                                    </td>
                                    <td>
                                    <span class="font-weight-bolder text-success">
                                            <?=$row->year_tax?>
                                        <span>
                                    </td>
                                    <td>
                                    <span class="font-weight-bolder text-success">
                                            <?=$row->year_surcharge?>
                                        <span>
                                    </td>
                                            
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <center>
                        <a href="<?=base_url('index.php/EkhajanaTn/viewPreUpdatedArrear')?>" type="button" class="btn btn-danger btn-sm mt-5 text-white">
                                BACK
                            </a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>


