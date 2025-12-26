<style>
.unicode label, tr {
    font-size: 14px !important;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Report on the changes made through backlog office / field mutation in Chitha & Jamabandi
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Report - Village / Town Wise</h3>
                    </div>
                    <div class="panel-body">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <th class="center"><label class="control-label">Location Details</label></th>
                                    <th class="center"><label class="control-label">Order Type</label></th>
                                    <th class="center"><label class="control-label">Dag No</label></th>
                                    <th class="center"><label class="control-label">Final Order</label></th>
                                </thead>        
                                <?php
                                foreach ($data as $chithainf):
                                $hukum_no = 1;
                                if (isset($chithainf['col8'])) {
                                    $size_of_order=sizeof($chithainf['col8']);
                                    foreach ($chithainf['col8'] as $clmn8):
                                        $co_order_date1 = $clmn8['co_ord_date'];
                                        $case_no = $clmn8['case_no'];
                                        $col8order_cron_no = $clmn8['col8order_cron_no'];
                                        $order_type = $clmn8['order_type'];
                                        $co_order_date = strtotime($co_order_date1);
                                        $formatDate = date("d/m/Y", $co_order_date);
                                        $order_type_code = $clmn8['order_type_code'];
                                        $nature_trans_code = $clmn8['nature_trans_code'];
                                        $mut_land_area_b = $clmn8['mut_land_area_b'];
                                        $mut_land_area_k = $clmn8['mut_land_area_k'];
                                        $mut_land_area_lc = $clmn8['mut_land_area_lc'];
                                        $operation = $clmn8['operation'];
                                        $co_name = $clmn8['co_name'];
                                        ?>
                                        <tr>
                                                <td class='center' width="20%">
                                                    <?php 
                                                    $districtdata =  $this->utilityclass->getDistrictName($clmn8['dist_code']);
                                                    $subdivdata = $this->utilityclass->getSubDivName($clmn8['dist_code'], $clmn8['subdiv_code']);
                                                    $circledata =  $this->utilityclass->getCircleName($clmn8['dist_code'], $clmn8['subdiv_code'], $clmn8['cir_code']);
                                                    $mouzadata = $this->utilityclass->getMouzaName($clmn8['dist_code'], $clmn8['subdiv_code'], $clmn8['cir_code'], $clmn8['mouza_pargona_code']);
                                                    $lotdata = $this->utilityclass->getLotName($clmn8['dist_code'], $clmn8['subdiv_code'], $clmn8['cir_code'], $clmn8['mouza_pargona_code'], $clmn8['lot_no']);
                                                    $villdata = $this->utilityclass->getVillageName($clmn8['dist_code'], $clmn8['subdiv_code'], $clmn8['cir_code'], $clmn8['mouza_pargona_code'], $clmn8['lot_no'], $clmn8['vill_townprt_code']);
                                                    echo $districtdata."<br>".$subdivdata."<br>".$circledata."<br>".$mouzadata."<br>".$lotdata."<br>".$villdata; 
                                                    ?>
                                                </td>
                                                <td class='center' width="20%">Field Mutation / <?php echo $clmn8['order_type']; ?></td>
                                                <td class='center' width="10%"><span class="badge badge-danger"><?php echo $clmn8['dag_no']; ?></span></td>
                                                <td>
                                        <?php
                                        if($order_type_code!=='03'){
                                        ?>
                                        <p>চক্ৰ বিষয়াৰ  <br> <?php echo $this->utilityclass->cassnum($formatDate); ?> তাৰিখৰ 
                                            <?php
                                            $bigha = 0;
                                            $katha = 0;
                                            $lesa = 0;
                                            if ($order_type_code == "01") {
                                                if ($mut_land_area_b != '0') {
                                                    $bigha = $this->utilityclass->cassnum($mut_land_area_b) . 'বিঘা ';
                                                } else {
                                                    $bigha = "";
                                                }
                                                if ($mut_land_area_k != '0') {
                                                    $katha = $this->utilityclass->cassnum($mut_land_area_k) . 'কঠা ';
                                                } else {
                                                    $katha = "";
                                                }
                                                if ($mut_land_area_lc != '0') {
                                                    $lesa = $this->utilityclass->cassnum($mut_land_area_lc) . 'লেছা ';
                                                } else {
                                                    $lesa = "";
                                                }
                                            } else if ($order_type_code == "02") {
                                                if ($mut_land_area_b != '0') {
                                                    $bigha = $this->utilityclass->cassnum($mut_land_area_b) . 'বিঘা ';
                                                } else {
                                                    $bigha = "";
                                                }

                                                if ($mut_land_area_k != '0') {
                                                    $katha = $this->utilityclass->cassnum($mut_land_area_k) . 'কঠা ';
                                                } else {
                                                    $katha = "";
                                                }
                                                if ($mut_land_area_lc != '0') {
                                                    $lesa = $this->utilityclass->cassnum($mut_land_area_lc) . 'লেছা ';
                                                } else {
                                                    $lesa = "";
                                                }
                                            }
                                            echo $order_type . ' নং ' . $case_no . '-ৰ ' . ' হুকুমমৰ্মে এই দাগৰ ' . $bigha . $katha . $lesa . ' মাটি ';
                                            if ($order_type_code != "02" and $clmn8['nature_trans_code'] != null) {
                                                echo " " . $this->utilityclass->getTransferType($clmn8['nature_trans_code']) . " ";
                                            }
                                            $count = 1;
                                            $howmanys = sizeof($clmn8['inplace']) - 1;
                                            foreach ($clmn8['inplace'] as $in) {
                                                echo $in['inplace_of_name'] . "'ৰ";
                                                if ($count < sizeof($clmn8['inplace']) - 1) {
                                                    switch ($in['inplaceof_alongwith']) {
                                                        case 'i':
                                                            echo " স্হলত ";
                                                            break;
                                                        case 'a':
                                                            echo " লগত  ";
                                                            break;
                                                    }
                                                    echo " , ";
                                                    $count++;
                                                } elseif ($count == sizeof($clmn8['inplace']) - 1) {
                                                    switch ($in['inplaceof_alongwith']) {
                                                        case 'i':
                                                            echo " স্হলত ";
                                                            break;
                                                        case 'a':
                                                            echo " লগত  ";
                                                            break;
                                                    }
                                                    echo " আৰু ";
                                                    $count++;
                                                } else {
                                                    switch ($in['inplaceof_alongwith']) {
                                                        case 'i':
                                                            echo " স্হলত ";
                                                            break;
                                                        case 'a':
                                                            echo " লগত  ";
                                                            break;
                                                    }
                                                    echo " ";
                                                }
                                            }


                                            $count = 1;
                                            $howmany = sizeof($clmn8['occup']) - 1;
                                            foreach ($clmn8['occup'] as $in) {
                                                $r = "";
                                                switch ($in['occupant_fmh_flag']) {
                                                    case 'm':
                                                        $r = "মাতৃ";
                                                        break;
                                                    case 'f':
                                                        $r = "পিতৃ";
                                                        break;
                                                    case 'h':
                                                        $r = "পতি";
                                                        break;
                                                    case 'w':
                                                        $r = "পত্নী";
                                                        break;
                                                    case 'a':
                                                        $r = "অধ্যক্ষ মাতা";
                                                        break;
                                                    default:
                                                        $r = "অভিভাৱক";
                                                }
                                                echo $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                                                if ($count < sizeof($clmn8['occup']) - 1) {
                                                    echo " , ";
                                                    $count++;
                                                } elseif ($count == sizeof($clmn8['occup']) - 1) {
                                                    echo " আৰু ";
                                                    $count++;
                                                } else {
                                                    echo " ";
                                                }
                                            }
                                            if ($clmn8['order_type_code'] == '01') {
                                                echo " নামত নামজাৰী কৰা হ’ল | ";
                                            } else if ($clmn8['order_type_code'] == '02') {
                                                echo " নামত " . $clmn8['occup'][0]['new_dag_no'] . " নং দাগ " .
                                                $clmn8['occup'][0]['new_patta_no'] . " ম্যাদী পট্টা কৰা হল | ";
                                            }

                                            if (($clmn8['rajah'] != 0) || ($clmn8['rajah'] == 'y')) {
                                                echo "<p style='color:blue'>( ৰাজহ আদলত )</p>";
                                            }
                                            ?>   
                                            <?php
                                            if (($clmn8['deed_reg_no'] != "")) {
                                                if($clmn8['nature_trans_code']=='08'){
                                                    $lebel_one="উইল / প্ৰবেট নং : ";
                                                    $label_two="উইল / প্ৰবেট তাৰিখ : ";
                                                } else {
                                                    $lebel_one="Deed No : ";
                                                    $lebel_two="Deed No : ";
                                                }
                                                echo "<p class='text-danger'>Registration</p>";
                                                echo $lebel_one . $clmn8['deed_reg_no'] . "<br>";
                                                if($clmn8['nature_trans_code']!='08'){
                                                    echo "Deed Value:" . $this->utilityclass->cassnum(number_format($clmn8['deed_value'], 2)) . "<br>";
                                                }
                                                $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));
                                                if ($interval->days > 0) {
                                                    echo $lebel_two . $this->utilityclass->cassnum(date('d-m-y', strtotime($clmn8['deed_date']))) . " ";
                                                }
                                            }
                                            ?>
                                            <p><u class='text-danger'>লাট মণ্ডল :</u><br>(<?php echo $clmn8['lm_name']; ?>)</p>
                                            <p><u class='text-danger'>চক্ৰ বিষয়া :</u><br>(<?php echo $clmn8['username']; ?>)</p>
                                            <?php
                                            // B is for back log report
                                            if (($operation == 'B') and ($order_type_code == "01")){
                                                echo "লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                                                echo "<br><u class='text-danger'> চঃ বিঃ –  ".$co_name."</u>";
                                            }elseif (($operation == 'B') and ($order_type_code == "02")){
                                                echo "লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত আপোচ বাটোৱাৰা ও নথি সংশোধন  কৰা হ’ল ।  ";
                                                echo "<br><u class='text-danger'> চঃ বিঃ –  ".$co_name."</u>";
                                            }
                                            ?>
                                            <?php
                                            if ($hukum_no < $size_of_order) {
                                                echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
                                            }
                                            }
                                            $hukum_no++;
                                            ?>
                                            </tr>
                                            <?php
                                        endforeach;
                                        }
                                endforeach;
                                ?>
                            </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>