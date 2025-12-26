<div class="container-fluid form-top">
    <div class="row">
        <div align="center" class="col-lg-12">
            <table align="center" width="100%" >
                <h1><p align ="center">জৰীপ হোৱা গাঁওৰ জমাবন্দী(Jamabandi for Surveyed Village)</p></h1>
                <tr>
                    <td align="center"><?php echo "<h2>" . "District Name:" . "<br>" . $namedata[0]->district;"<br></h2>";?></td> 
                    <td align="center"><?php echo "<h2>" . "Subdivision Name:" . "<br>" . "/" . $namedata[1]->subdiv;"<br></h2>";?></td> 
                    <td align="center"><?php echo "<h2>" . "Circle Name:" . "<br>" . "/" . $namedata[2]->circle; "<br></h2>";?></td> 
                    <td align="center"><?php echo "<h2>" . "Mouza Name:" . "<br>" . "/" . $namedata[3]->mouza;"<br></h2>";?></td> 
                    <td align="center"><?php echo "<h2>" . "Lot Number:" . "<br>" . "/" . $namedata[4]->lot_no; "<br></h2>";?></td> 
                    <td align="center"><?php echo "<h2>" . "Village/Town Name:" . "<br>" . "/" . $namedata[5]->village; "<br></h2>;"?></td> 
                    <td align="center"><?php echo "<h2>" . "Pattatype:" . "<br>" . "/" . $namedata[6]->patta_type;"<br>" . "<br></h3>";?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered" width="100%" >
                <thead>
                    <tr>
                        <td align="center" colspan="2" height="24"> <h3> পট্টা নং </h3> </td>
                        <td align= "center" rowspan="2" height="78">  <h3> পট্টাদাৰৰ  নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা <h3> </td>
                                    <td align="center" colspan="4" height="34">  <h3>&nbsp;&nbsp;প্ৰত্যেক দাগৰ মাটিৰ &nbsp; <h3> </td>
                                                <td align="center" rowspan="2" height="73"> <h3> ৰাজহ<br></h3> </td>
                                                <td align="center" rowspan="2" height="73"> <h3> স্হানীয় কৰ<br> <h3> </td>
                                                            <td align="center" rowspan="2" height="100"> <h3> মন্তব্য </h3> </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="center" height="48"> পুৰণি </td>
                                                                <td align="center" height="48"> নতুন </td>

                                                                <td align="center" height="48"> নং</td>
                                                                <td align="center" height="48"> কালি<br>(বি-ক-লে) </td>
                                                                <td align="center" height="48"> শ্রেণী </td>
                                                                <td align="center" height="48"> কালি<br>(হে-আৰ-ছে) </td>
                                                            <thead>
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
                                                                <tr>
                                                                    <td><?php
                                                                        $pp = $this->session->userdata('patta_no');
                                                                        echo $pp;
                                                                        ?></td>
                                                                    <td></td>
                                                                    <td>
                                                                            <?php
                                                                            // $numpattadars = count($pno['pattadarinf'] );
                                                                            $i = 1;
                                                                            foreach ($pattadarinf as $p):
                                                                                ?>
                                                                            <p><?php
                                                                                $pdarflag = $p->p_flag;
                                                                                $newpdar_name = $p->new_pdar_name;
                                                                                if (($pdarflag == '1') and ( $newpdar_name == null)) {
                                                                                    $pattadarName = '<div style="Color:#ff0000;text-decoration: line-through;">' . $p->pdar_name . '</div>';
                                                                                } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                                                                                    $pattadarName = '<div style="Color:#ff0000;">' . $p->pdar_name . '</div>';
                                                                                } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                                                                                    $pattadarName = '<div style="Color:#ff0000;">' . $p->pdar_name . '</div>';
                                                                                } elseif ($newpdar_name == "N") {
                                                                                    $pattadarName = '<div style="Color:#ff0000;">' . $p->pdar_name . '</div>';
                                                                                } elseif ($newpdar_name != "N") {
                                                                                    $pattadarName = '<div style="Color:black;">' . $p->pdar_name . '</div>';
                                                                                }
                                                                                echo $i++ . ')' . $pattadarName . ",(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3;
                                                                                ?> </p>
                                                                        <?php endforeach;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                            <?php foreach ($daginfo as $p): ?>
                                                                            <p><?php echo $p->dag_no; ?> </p>
                                                                        <?php endforeach; ?>
                                                                    </td>
                                                                    <td>  
                                                                            <?php foreach ($daginfo as $p): ?>
                                                                            <p><?php echo $p->dag_area_b . "-" . $p->dag_area_k . "-" . round($p->dag_area_lc, 2); ?> </p>
                                                                        <?php endforeach; ?>
                                                                    </td>
                                                                    <td>
                                                                            <?php foreach ($daginfo as $p): ?>
                                                                            <p><?php echo $p->land_type; ?> </p>
                                                                            <?php endforeach; ?>


                                                                    </td>
                                                                    <td>
                                                                        <?php foreach ($daginfo as $p): ?>
                                                                            <?php
                                                                            $bigha_total = $bigha_total + $p->dag_area_b;
                                                                            $katha_total = $katha_total + $p->dag_area_k;
                                                                            $lesa_total = $lesa_total + $p->dag_area_lc;

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
                                                                            <?php $H_A_C = $this->utilityclass->get_Hec_Are_CAre($p->dag_area_b, $p->dag_area_k, $p->dag_area_lc);
                                                                            echo $H_A_C . '<br>';
                                                                            ?>
                                                                        <?php endforeach; ?>



                                                                    </td>
                                                                    <td>
                                                                            <?php foreach ($daginfo as $p): ?>
                                                                            <?php $revenueTotal = $revenueTotal + $p->dag_revenue; ?>
                                                                            <p><?php echo $p->dag_revenue; ?> </p>
                                                                        <?php endforeach; ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php foreach ($daginfo as $p): ?>
                                                                            <?php $localtaxTotal = $localtaxTotal + $p->dag_localtax; ?>
                                                                            <p><?php echo $p->dag_localtax; ?> </p>
                                                                        <?php endforeach; ?>
                                                                    </td>
                                                                    <td>
                                                                            <?php foreach ($remarkinf as $p): ?>
                                                                            <p><?php echo $p->remark; ?> </p>

                                                                            <?php endforeach; ?>
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

                                                                </table>
                                                                </div>
                                                                </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="row">
                                                                            <div class="col-lg-3"><?php  $data = explode(",",$qrcode)[1];
                                                                    echo '<img src="data:image/png;base64,' . $data . '" />'; ?></div>
																	
                                                                            <div class="col-lg-3"><?php  $data = explode(",",$qrBasic)[1];
                                                                    echo '<img src="data:image/png;base64,' . $data . '" />';?></div>
                                                                            <div class="col-lg-3"><?php  $data = explode(",",$qrCONAME)[1];
                                                                    echo '<img src="data:image/png;base64,' . $data . '" />'; ?></div>
                                                                        </div>
                                                                        
                                                                         </div>
                                                                    <div class="col-lg-4">
                                                                        <p class="uni_text"> কতৃত্বপ্রাপ্ত বিষয়াৰ   :  <?php echo $username->username; ?> <br>
                                                                            Designation :   চক্ৰ বিষয়া<br>
                                                                            Dated :  <?php echo date('d/m/Y'); ?>
                                                                        </p>
                                                                    </div>
                                                                    <button onclick="myFunction()">Print this page</button>
                                                      </div>
                                                        <script>
                                                        function myFunction() {
                                                            window.print();
                                                        }
                                                        </script>