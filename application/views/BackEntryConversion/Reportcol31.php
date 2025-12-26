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
                                $sro_hukum_no = 1;
                                $order_count = 1;
                                foreach ($data as $chithainf):
                                    foreach ($chithainf['col31'] as $remark):
                                ?>
                                <?php foreach ($remark as $r): ?>
                                <?php if (sizeof($r) > 0): ?>
                                <!-- Office Mutation Start-->
                                <tr>
                                <td class='center' width="20%">
                                    <?php 
                                    $districtdata =  $this->utilityclass->getDistrictName($r['dist_code']);
                                    $subdivdata = $this->utilityclass->getSubDivName($r['dist_code'], $r['subdiv_code']);
                                    $circledata =  $this->utilityclass->getCircleName($r['dist_code'], $r['subdiv_code'], $r['cir_code']);
                                    $mouzadata = $this->utilityclass->getMouzaName($r['dist_code'], $r['subdiv_code'], $r['cir_code'], $r['mouza_pargona_code']);
                                    $lotdata = $this->utilityclass->getLotName($r['dist_code'], $r['subdiv_code'], $r['cir_code'], $r['mouza_pargona_code'], $r['lot_no']);
                                    $villdata = $this->utilityclass->getVillageName($r['dist_code'], $r['subdiv_code'], $r['cir_code'], $r['mouza_pargona_code'], $r['lot_no'], $r['vill_townprt_code']);
                                    echo $districtdata."<br>".$subdivdata."<br>".$circledata."<br>".$mouzadata."<br>".$lotdata."<br>".$villdata; 
                                    ?>
                                </td>
                                <td class='center' width="20%">Office Mutation / নামজাৰী</td>
                                <td class='center' width="10%"><span class="badge badge-danger"><?php echo $r['dag_no']; ?></span></td>
                                <td>
                                    <?php if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')): ?>
                                        <u class='text-danger'><?php echo "হুকুম নং: " . $order_count++; ?><br></u>
                                        <p>চক্র বিষয়া'ৰ  <br>  
                                        <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> তাৰিখ'ৰ   
                                        <?php
                                        $order_type = $r['ord_type_code'];
                                        echo $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                                        ?>
                                        <?php echo $r['ord_no'] . " 'ৰ হুকুমমৰ্মে এই দাগৰ "; ?>
                                        <?php
                                        if ($r['by_right_of'] == '11') {
                                            echo " অংশৰ জমিত ";
                                        } else {
                                            //var_dump($r);
                                            echo $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                                            echo $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                                            echo $this->utilityclass->cassnum(number_format($r['lessa'], 2)) . " লেছা মাটি ";
                                        }
                                        ?>
                                        <?php echo $this->utilityclass->getTransferType($r['by_right_of']) . " "; ?>
                                        <?php
                                        $count = 1;
                                        $howmany = sizeof($r['alongwith_name']) - 1;
                                        foreach ($r['alongwith_name'] as $al):
                                            ?>
                                            <?php
                                            echo $al['alongwithname'];
                                            if ($count < sizeof($r['alongwith_name']) - 1) {
                                                echo " , ";
                                                $count++;
                                            } elseif ($count == sizeof($r['alongwith_name']) - 1) {
                                                echo " আৰু ";
                                                $count++;
                                            } else {
                                                echo " ";
                                            }
                                            ?>
                                            <?php
                                        endforeach;
                                        if (sizeof($r['alongwith_name']) != '0') {
                                            echo "' ৰ লগত ";
                                        }
                                        ?>
                                        <?php
                                        $count = 1;
                                        $howmany = sizeof($r['inplace_of_name']) - 1;
                                        foreach ($r['inplace_of_name'] as $al):
                                            ?>
                                            <?php
                                            echo $al['inplace_of_name'];
                                            if ($count < sizeof($r['inplace_of_name']) - 1) {
                                                echo " , ";
                                                $count++;
                                            } elseif ($count == sizeof($r['inplace_of_name']) - 1) {
                                                echo " আৰু ";
                                                $count++;
                                            } else {
                                                echo " ";
                                            }
                                            ?>
                                            <?php
                                        endforeach;
                                        if (sizeof($r['inplace_of_name']) != '0') {
                                            echo "'ৰ স্হলত ";
                                        }
                                        ?>
                                        <?php
                                        $count = 1;
                                        $howmany = sizeof($r['infav']) - 1;
                                        foreach ($r['infav'] as $in):
                                            ?>
                                            <?php
                                            echo $in['infavor_of_name'];
                                            if ($count < sizeof($r['infav']) - 1) {
                                                echo " , ";
                                                $count++;
                                            } elseif ($count == sizeof($r['infav']) - 1) {
                                                echo " আৰু ";
                                                $count++;
                                            } else {
                                                echo " ";
                                            }
                                            ?>
                                        <?php endforeach; ?>

                                        <?php if ($r['ord_type_code'] == '03'): ?>
                                            'ৰ নামত নামজাৰী কৰা হ’ল |
                                        <?php endif; ?>
                                        <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                                        <p><u class='text-danger'>চক্র বিষয়া :</u><br>(<?php echo $r['username']; ?>)</p>
                                        <p>
                                            <?php
                                            if ($r['reg_deal_no'] != "") {
                                                echo "Reg No (" . $this->utilityclass->cassnum($r['reg_deal_no']) . ")";
                                            }
                                            ?>
                                        </p>
                                        <p>
                                            <?php
                                            if ($r['reg_date'] != "") {
                                                echo "Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                                            }
                                            ?>
                                        </p>
                                        <hr style='border-bottom: 2px solid #b3b0b0;'>
                                        <p>
                                            <?php
                                            if ($r['operation'] == "B") {
                                                echo "চঃ বিঃ – লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল  ";
                                                echo "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                                            }
                                            ?>
                                        </p>
                                    <?php endif; ?>
                            </td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?> 
<?php endforeach; ?>
                            <?php endforeach; ?>

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