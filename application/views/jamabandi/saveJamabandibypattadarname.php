<?php
//print_r($jamapdarnme);
?>
<div class="container-fluid form-top">
    <div class="row">
        <div align="center" class="col-lg-12">
            <table align="center" width="80%" >
                <h1><p align ="center">জৰীপ হোৱা গাঁওৰ জমাবন্দী(Jamabandi for Surveyed Village)</p></h1>
                <tr>
                    <td align="center"><?php
                        echo "<h2>" . "District Name:" . "<br>" . $namedata[0]->district;
                        "<br></h2>";
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Subdivision Name:" . "<br>" . "/" . $namedata[1]->subdiv;
                        "<br></h2>";
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Circle Name:" . "<br>" . "/" . $namedata[2]->circle;
                        "<br></h2>";
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Mouza Name:" . "<br>" . "/" . $namedata[3]->mouza;
                        "<br></h2>";
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Lot Number:" . "<br>" . "/" . $namedata[4]->lot_no;
                        "<br></h2>";
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Village/Town Name:" . "<br>" . "/" . $namedata[5]->village;
                        "<br></h2>;"
                        ?></td>
                    <td align="center"><?php
                        echo "<h2>" . "Pattatype:" . "<br>" . "/" . $patta_type->patta_type;
                        "<br>" . "<br></h3>";
                        ?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered" width="100%" >
                <thead>
                    <tr>
                        <td align="center" colspan="2" height="24"> <h3> পট্টা নং </h3> </td>
                        <td align= "center" rowspan="2" height="78" width="200">  <h3> পট্টাদাৰৰ  নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা <h3> </td>
                                    <td align="center" colspan="4" height="34">  <h3>&nbsp;&nbsp;প্ৰত্যেক দাগৰ মাটিৰ &nbsp; <h3> </td>
                                                <td align="center" rowspan="2" height="73"> <h3> ৰাজহ<br></h3> </td>
                                                <td align="center" rowspan="2" height="73"> <h3> স্হানীয় কৰ<br> <h3> </td>
                                                            <td align="center" rowspan="2" height="100" width="300"> <h3> মন্তব্য </h3> </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" height="48"> পুৰণি </td>
                                                                <td align="center" height="48"> নতুন </td>
                                                                <td align="center" height="48"> নং</td>
                                                                <td align="center" height="48"> কালি<br>(বি-ক-লে) </td>
                                                                <td align="center" height="48"> শ্রেণী </td>
                                                                <td align="center" height="48"> কালি<br>(হে-আৰ-ছে) </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="middle" height="24"> 1 </td>
                                                                <td  align="center" height="24"> 2 </td>
                                                                <td align="center" height="24"> 3</td>
                                                                <td align="center" height="24"> 4 </td>
                                                                <td  align="center" height="24"> 5 </td>
                                                                <td  align="center" height="24"> 6 </td>
                                                                <td  align="center" height="24"> 7 </td>
                                                                <td  align="center"  height="24"> 8 </td>
                                                                <td  align="center"  height="24"> 9 </td>
                                                                <td width ="20" align="center"  height="24"> 10 </td>
                                                            </tr>
                                                            <?php
                                                            $GrandlocaltaxTotal = '';
                                                            $GrandrevenueTotal = '';
                                                            $Grandbigha_total = '';
                                                            $Grandkatha_total = '';
                                                            $Grandlesa_total = '';
                                                            //  $details="";
                                                            $GrandtotalHAC1 = "";
                                                            ?>
                                                            <?php
//var_dump($details);



                                                            $localtaxTotal = '';
                                                            $revenueTotal = '';
                                                            $bigha_total = '';
                                                            $katha_total = '';
                                                            $lesa_total = '';
                                                            ?>
                                                            <?php foreach ($jamapdarnme as $info): ?>

                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        <?php echo $info['patta_no'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
// $numpattadars = count($pno['pattadarinf'] );


                                                                        $pdarflag = $info['pflg'];
                                                                        $newpdar_name = $info['new_pnme'];
                                                                        if (($pdarflag == '1') and ( $newpdar_name == null)) {

                                                                            $pattadarName = '<div style="Color:#ff0000;text-decoration: line-through;">' . $info['pnme'] . '</div>';
                                                                        } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                                                                            $pattadarName = '<div style="Color:#ff0000;">' . $info['pnme'] . '</div>';
                                                                        } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                                                                            $pattadarName = '<div style="Color:#ff0000;">' . $info['pnme'] . '</div>';
                                                                        } elseif ($newpdar_name == "N") {
                                                                            $pattadarName = '<div style="Color:#ff0000;">' . $info['pnme'] . '</div>';
                                                                        } elseif ($newpdar_name != "N") {
                                                                            $pattadarName = '<div style="Color:black;">' . $info['pnme'] . '</div>';
                                                                        }
                                                                        echo $pattadarName . ",(" . $info['pfather'] . ")" . '<br>' . $info['padd1'] . "," . $info['padd2'] . "," . $info['padd3'];
                                                                        ?> </p>
                                                                    </td>

                                                                    <td><?php echo $this->utilityclass->cassnumfordags($info['dag_no']); ?></td>
                                                                    <td>
                                                                        <p><?php echo $info['dag_area_b'] . "-" . $info['dag_area_k'] . "-" . round($info['dag_area_lc'], 2); ?> </p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo $info['land_type']; ?> </p>
                                                                    </td>
                                                                    <td>

                                                                        <?php
                                                                        $bigha_total = $bigha_total + $info['dag_area_b'];
                                                                        $katha_total = $katha_total + $info['dag_area_k'];
                                                                        $lesa_total = $lesa_total + $info['dag_area_lc'];

                                                                        if ($lesa_total > 20) {
                                                                            $lesa = ($lesa_total / 20);

//$whole = floor($hectar);      // 1
//$fraction1 = $hectar - $whole; // .25
                                                                            $lesa_whole = floor($lesa);
                                                                            $lesa_fraction = $lesa - $lesa_whole;
                                                                            $lesa_fraction = $lesa_fraction * 20;
                                                                            $katha_total = $katha_total + $lesa_whole;

// $grand_katha=$katha_total+$to_be_added_to_katha;
                                                                        } else {
                                                                            $lesa_fraction = $lesa_total;
                                                                        }
                                                                        if ($katha_total > 4) {
                                                                            $katha = ($katha_total / 5);
                                                                            $katha_whole = floor($katha);
                                                                            $katha_fraction = $katha - $katha_whole;
                                                                            $katha_fraction = $katha_fraction * 5;
                                                                            $bigha_total = $bigha_total + $katha_whole;
//$to_be_added_to_bigha=($grand_katha/5);
//$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                                                                        } else {
                                                                            $katha_fraction = $katha_total;
                                                                        }

                                                                        $GrandtotalHAC = $this->utilityclass->get_Hec_Are_CAre($bigha_total, $katha_fraction, $lesa_fraction);
                                                                        ?>
                                                                        <?php
                                                                        $H_A_C = $this->utilityclass->get_Hec_Are_CAre($info['dag_area_b'], $info['dag_area_k'], $info['dag_area_lc']);
                                                                        echo $H_A_C . '<br>';
                                                                        ?>




                                                                    </td>
                                                                    <td>

                                                                        <?php $revenueTotal = $revenueTotal + $info['dag_revenue']; ?>
                                                                        <p><?php echo $info['dag_revenue']; ?> </p>


                                                                    </td>
                                                                    <td>

                                                                        <?php $localtaxTotal = $localtaxTotal + $info['dag_localtax']; ?>
                                                                        <p><?php echo $info['dag_localtax']; ?> </p>

                                                                    </td>

                                                                    <td>

                                                                        <p><?php echo strip_tags($info['remark']); ?> </p>


            <!--                             <p><?php //echo $remark->remark;            ?> </p>-->


                                                                    </td>

                                                                </tr>                    <tr>
                                                                    <td>

                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo $bigha_total . '-' . $katha_fraction . '-' . $lesa_fraction;
                                                                        $Grandbigha_total = $Grandbigha_total + $bigha_total;
                                                                        $Grandkatha_total = $Grandkatha_total + $katha_fraction;
                                                                        $Grandlesa_total = $Grandlesa_total + $lesa_fraction;

                                                                        if ($Grandlesa_total > 20) {
                                                                            $lesa = ($Grandlesa_total / 20);

//$whole = floor($hectar);      // 1
//$fraction1 = $hectar - $whole; // .25
                                                                            $lesa_whole = floor($lesa);
                                                                            $lesa_fraction = $lesa - $lesa_whole;
                                                                            $lesa_fraction = $lesa_fraction * 20;
                                                                            $Grandkatha_total = $Grandkatha_total + $lesa_whole;

// $grand_katha=$katha_total+$to_be_added_to_katha;
                                                                        } else {
                                                                            $lesa_fraction = $Grandlesa_total;
                                                                        }
                                                                        if ($Grandkatha_total > 4) {
                                                                            $katha = ($Grandkatha_total / 5);
                                                                            $katha_whole = floor($katha);
                                                                            $katha_fraction = $katha - $katha_whole;
                                                                            $katha_fraction = $katha_fraction * 5;
                                                                            $Grandbigha_total = $Grandbigha_total + $katha_whole;
//$to_be_added_to_bigha=($grand_katha/5);
//$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                                                                        } else {
                                                                            $katha_fraction = $Grandkatha_total;
                                                                        }

                                                                        $GrandtotalHAC1 = $this->utilityclass->get_Hec_Are_CAre($Grandbigha_total, $katha_fraction, $lesa_fraction);
                                                                        ?>



                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo $GrandtotalHAC ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo $revenueTotal;
                                                                        $GrandrevenueTotal = $GrandrevenueTotal + $revenueTotal;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo $localtaxTotal;
                                                                        $GrandlocaltaxTotal = $GrandlocaltaxTotal + $localtaxTotal;
                                                                        ?>
                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>




                                                            </table>
                                                            </div>
                                                            </div>
                                                            </div>
