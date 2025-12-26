<style>
.buttons-excel {
  left: 15%;
  background-color: green;
  color: white!important;
}
.buttons-csv {
  left: 15%;
  background-color: blue;
  color: white!important;
}
</style>
<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" />
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaDoulController/viewDoulForAllMouza'?>">DOUL VIEW CIRCLE WISE</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">DOUL</li>
  </ol>
</nav>
<div class="row container" style='margin-top:10px'>				     
  <div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-primary text-center font-weight-bold">
        <h3 class="panel-title font-weight-bold">
            YEAR WISE DOUL
        </h3>
    </div>
    <div style="padding:0px;">
      <table class="table table-bordered table-dark">
        <tbody>
          <tr style="font-size:16px;">
              <td>DISTRICT: <?=$district_name?></td>
              <td>SUB-DIVISION : <?=$subdiv_name?></td>
              <td>CIRCLE: <?=$circle_name?></td>
              <td>MOUZA : <?=$mouza_name?></td>
          </tr>
        </tbody>                
      </table>
    </div>
    <div class="card-body">
        <div class="card-body shadow-lg bg-white rounded">                              
            <div class = "card-body">            
                <table id="mouzdar_view_doul_table" class="table table-hover" style="width:100%;">            
                    <thead class="thead-dark">                            
                        <tr style="background-color: #515151; color: #fff;font-size:18px;">
                            <td >পট্টাৰ প্ৰকাৰ</td>
                            <td>পট্টাৰ সংখ্যা</td>
                            <td>মাটি কালি</td>
                            <td>ৰাজহ</td>
                            <td>স্হানীয় কৰ</td>
                            <!-- <td>অতিৰিক্ত কৰ</td> -->
                        </tr>                                                        
                    </thead>
                    <tbody>
                        <?php foreach ($doul_data as $doul_detail):?>   
                          <tr>
                            <td>
                              <span class="font-weight-bold text-primary">
                                <?=$this->utilityclass->getPattaType($doul_detail['patta_type_code'])?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-success">
                                <?=$doul_detail['patta_count']?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-success">
                                <?php 
                                    $sum_total_lessa = $this->utilityclass->Total_Lessa($doul_detail['total_bigha'],$doul_detail['total_katha'],$doul_detail['total_lessa']);
                                    $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                    echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ "; 
                                ?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-success">
                                <?=number_format((float)$doul_detail['revenue'], 2, '.', '')?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-success">
                                <?=number_format((float)$doul_detail['local_tax'], 2, '.', '')?>                              
                              </span>
                            </td>
                            <!-- <td>--</td> -->
                          </tr>
                        <?php endforeach;?> 
                        <!-- total -->
                        <tr>
                            <td>
                              <span class="font-weight-bold text-danger">মুঠ</span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-danger">
                                <?=$total_patta_all?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-danger">
                                <?php 
                                    $sum_total_lessa = $this->utilityclass->Total_Lessa($total_bigha_all,$total_katha_all,$total_lessa_all);
                                    $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                    echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ "; 
                                ?>
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-danger">
                                <?=number_format((float)$total_revenue_all, 2, '.', '')?>                                
                              </span>
                            </td>
                            <td>
                              <span class="font-weight-bold text-danger">
                                <?=number_format((float)$total_local_tax_all, 2, '.', '')?>
                              </span>
                            </td>
                          </tr>
                    </tbody>
                </table>
            </div>
        </div>        
    </div>    
</div>  
<div class="panel panel-form p-1">
    <div class="col-lg-12 mt-1 text-center">
        <a href="http://localhost/DharitreeSVN/index.php/MouzadarArrearUpdateController/index" class="btn btn-danger btn-sm text-white" role="button" style="padding: 7px !important;font-size: 14px;font-weight: bold;">
            <i class="glyphicon glyphicon-remove-sign"></i>
            BACK TO HOME PAGE
        </a>
    </div>                
</div>
<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script>    
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_doul.js"></script>
</div>
