<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: landscape; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">DOUL VIEW CIRCLE WISE</li>
  </ol>
</nav>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading text-center mt-1 bg-info">
                        <h3 class="panel-title text-white">
                            CURRENT DOUL DEMAND
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?=$this->utilityclass->getDistrictName($doul_data_mouza_wise[0]['dist_code'])?></td>
                                <td colspan="2">Subdivision : 
                                  <?=$this->utilityclass->getSubDivName($doul_data_mouza_wise[0]['dist_code'], 
                                  $doul_data_mouza_wise[0]['subdiv_code'])?>
                                </td>
                                <td colspan="2">Circle : 
                                    <?=$this->utilityclass->getCircleName($doul_data_mouza_wise[0]['dist_code'], 
                                    $doul_data_mouza_wise[0]['subdiv_code'], $doul_data_mouza_wise[0]['cir_code'])?>
                                </td>
                                <td colspan="2">Year : <?=$doul_data_mouza_wise[0]['year']?></td>
                            </tr>                          
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <table class="table table-bordered">
                            <tr class="hope info font-weight-bold h6 bg-dark">
                                <td class="text-danger">মৌজাৰ নাম</td>
                                <td class="text-danger">পট্টাৰ সংখ্যা</td>
                                <td class="text-danger">মাটি কালি</td>
                                <td class="text-danger">ৰাজহ</td>
                                <td class="text-danger">স্হানীয় কৰ</td>
                                <td class="text-danger">অতিৰিক্ত কৰ</td>
                                <td class="dontshow">&nbsp;</td>
                            </tr>
                            <?php foreach ($doul_data_mouza_wise as $doul_details):?> 
                              <tr class="font-weight-bold h6">
                                <td class="text-success"><?=$doul_details['mouza_Name']?></td>
                                <td class="text-success"><?=$doul_details['no_of_patta']?></td>
                                <td class="text-success">
                                    <?php 
                                        $sum_total_lessa = $this->utilityclass->Total_Lessa($doul_details['total_bigha'],$doul_details['total_katha'],$doul_details['total_lessa']);
                                        $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                        echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ "; 
                                    ?>
                                </td>
                                <td class="text-success"><?=$doul_details['revenue']?></td>
                                <td class="text-success"><?=$doul_details['local_tax']?></td>
                                <td class="text-danger">--</td>
                                <td class="dontshow">
                                  <a href="<?php echo base_url(); ?>index.php/EkhajanaDoulController/viewDoulMouzaWise/<?=$doul_details['mouza_code']?>"
                                    class="btn btn-warning btn-sm">
                                      &nbsp;View Mouza Doul&nbsp;<i class="fa fa-arrow-right"></i>
                                  </a>
                                </td>
                              </tr>
                            <?php endforeach;?>
                            <tr class="hope info font-weight-bold h6">
                                <td class="text-danger">মুঠ</td>
                                <td class="text-danger"><?=$total_patta?></td>
                                <td class="text-danger">                      
                                    <?php 
                                        $sum_total_lessa = $this->utilityclass->Total_Lessa($total_cir_area_bigha,$total_cir_area_katha,$total_cir_area_lessa);
                                        $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                        echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ "; 
                                    ?>
                                </td>
                                <td class="text-danger">
                                  <?=$total_cir_revenue?>
                                </td>
                                <td class="text-danger">
                                  <?=$total_cir_local_tax?>
                                </td>
                                <td>--</td>
                                <td class="dontshow"></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/EkhajanaCoArrearUpdateController/index?>"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
