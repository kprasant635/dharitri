
<style>
    td{
        font-size: .7em !important;
    }
    .onTopNotification{
        display:none;
    }
    @media print {
        body { font-size: 10pt }
    }
    @media screen {
        body { font-size: 13px }
    }
    @media screen, print {
        body { line-height: 1.2 }
    }
</style> 
<div class="container-fluid form-top" style="display:inline-block; width: 100%;">
    <div class="row">
        <div align="center" class="col-lg-12">
            <table align="center table_black" width="100%" >
                <tr>
                    <td align="center">জরীপ হওয়া গ্রামের জমাবন্দী (Jamabandi for Surveyed Village)</td> 
                </tr>
                <tr>
                    <td align="center"><?php echo $namedata[0]->district . "/" . $namedata[1]->subdiv . "/" . $namedata[2]->circle . "/" . $namedata[3]->mouza . "/" . $namedata[4]->lot_no . "/" . $namedata[5]->village . "/" . $namedata[6]->patta_type; ?></td> 
                </tr>
            </table>
            
            <table class="table table-striped table-bordered" width="100%" >
                <tr>
                    <td align="center" colspan="2" height="24">  পাট্টা নং  </td>
                    <td align= "center" rowspan="3" height="78" width="200">   পাট্টাদারের  নাম,পিতার নাম/স্বামীর নাম এবং ঠিকানা  </td>
                    <td align="center" colspan=5 height="34">  &nbsp;&nbsp;প্ৰত্যেক দাগের জমি &nbsp;   </td>
                    <td align="center" rowspan="3" height="73">  রাজস্ব<br> </td>
                    <td align="center" rowspan="3" height="73">  স্হানীয় কর<br>  </td>
                    <td align="center" rowspan="3" height="100" width="300">  মন্তব্য  </td>
                </tr>
                <tr>
                    <td align="center" rowspan="2" height="48"> পুরাতন </td>
                    <td align="center" rowspan="2" height="48"> নতুন </td>
                    <td align="center" rowspan="2" height="48"> নং</td>
                    <td align="center" rowspan="2" height="48"> কালি<br>(বি-ক-ছ-গ) </td>
                    <td align="center" height="48" colspan="2"> শ্রেণী </td>
                    <td align="center" rowspan="2" height="48"> কালি<br>(হে-আৰ-ছে) </td>
                </tr>
                <tr>
                    <td align="middle">
                        কৃষি
                    </td>
                    <td align="middle">
                        অকৃষি
                    </td>
                </tr>
                <tr>
                    <td align="middle" height="24"> <?php echo $this->utilityclass->cassnum('1');?> </td>
                    <td  align="center" height="24"> <?php echo $this->utilityclass->cassnum('2');?> </td>
                    <td align="center" height="24"> <?php echo $this->utilityclass->cassnum('3');?> </td>
                    <td align="center" height="24"> <?php echo $this->utilityclass->cassnum('4');?> </td>
                    <td  align="center" height="24"> <?php echo $this->utilityclass->cassnum('5');?> </td>
                    <td  align="center" height="24" colspan="2"> <?php echo $this->utilityclass->cassnum('6');?> </td>
                    <td  align="center" height="24"> <?php echo $this->utilityclass->cassnum('7');?> </td>
                    <td  align="center"  height="24"> <?php echo $this->utilityclass->cassnum('8');?> </td>
                    <td  align="center"  height="24"> <?php echo $this->utilityclass->cassnum('9');?> </td>
                    <td width ="20" align="center"  height="24"> <?php echo $this->utilityclass->cassnum('10');?> </td>
                </tr> 
                <?php
                $GrandlocaltaxTotal = '';
                $GrandrevenueTotal = '';
                $Grandbigha_total = '';
                $Grandkatha_total = '';
                $Grandlesa_total = '';
                $GrandtotalHAC1 = "";
                ?>
                <?php
                $grand_total_land_area_lessa = "0";
                foreach ($details as $detail => $pno):
                ?>
                <?php
                $localtaxTotal = '';
                $revenueTotal = '';
                $bigha_total = '';
                $katha_total = '';
                $lesa_total = '';
                ?>
                <tr>
                    <td align="middle">
                        <?php
                        foreach ($pno['oldpattano'] as $p):
                        $old_pno = $p->old_patta_no;
                        if ($old_pno == '') {
                            $old_pno = '0';
                        }
                        ?>
                        <p><?php echo $this->utilityclass->cassnum($p->old_patta_no);?></p>
                        <?php endforeach; ?>
                    </td>
                    <td align="middle"><?php echo $detail;?></td>
                    <td>
                        <?php
                        if (!empty($pno['pattadarinf'])) {
                        $i = 1;
                        foreach ($pno['pattadarinf'] as $p):
                        ?>
                        <p>
                            <?php
                            $pdarflag = $p->p_flag;
                            $newpdar_name = $p->new_pdar_name;
                            if ((($p->pdar_land_b) != '0') || (($p->pdar_land_k) != '0') || (($p->pdar_land_lc) != '0') ||($p->pdar_land_g !='0')) {
                                        $bkl = "(" . $p->pdar_land_b . "B-" . $p->pdar_land_k . "K-" . round($p->pdar_land_lc, 2) . "L-". round($p->pdar_land_g, 2) . "G) ";
                            } else {
                                $bkl = "";
                            }
                            if ($pdarflag == '1') {
                                $pattadarName = '<span style="Color:#ff0000;text-decoration: line-through;">' . $p->pdar_name . '</span>';
                            } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                                $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                            } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                                $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                            } elseif ($newpdar_name == "N") {
                                $pattadarName = '<span style="Color:#ff0000;">' . $p->pdar_name . '</span>';
                            } elseif ($newpdar_name != "N") {
                                $pattadarName = '<span style="Color:black;">' . $p->pdar_name . '</span>';
                            }

                            if (($p->pdar_add1 != '') || ($p->pdar_add2 != '') || ($p->pdar_add3 != '')) {
                                echo $i++.') ' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3 . "<br>" . $bkl;
                            } else {
                                echo $i++.') ' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                            }
                            ?> 
                        </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                            <p><?php echo $this->utilityclass->cassnum($p->dag_no); ?> </p>
                            <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">  
                        <?php
                        $total_lesa = '0';
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p):
                            ?>
                            <p><?php
                                $les = round($p->dag_area_lc, 2);
                                $bkl_ass = $p->dag_area_b . "-" . $p->dag_area_k . "-" . $p->dag_area_lc. "-" . number_format($p->dag_area_g, 2);
                                echo $this->utilityclass->cassnum($bkl_ass);
                                $converted_to_lessa = ($p->dag_area_b) * 6400 + ($p->dag_area_k) * 320 + ($p->dag_area_lc) * 20 + $p->dag_area_g;
                                $total_lesa = $total_lesa + $converted_to_lessa;
                                ?> 
                            </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                                <?php if ($p->class_code_cat == '01') { ?>
                                <p><?php
                                    echo $p->land_type . '<br>';
                                }
								if($p->class_code_cat != '01'){
									print "-"; }
								?>
                                </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                            <?php if ($p->class_code_cat == '02') { ?>
                                <p><?php
                                    echo $p->land_type . '<br>';
                                }
								if($p->class_code_cat != '02'){
									print "-"; }
                                ?> </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                            <p><?php
                                $each_land_area_hectr = $this->utilityclass->get_Hec_Are_CAre2($p->dag_area_b, $p->dag_area_k, $p->dag_area_lc,$p->dag_area_g);
                                echo $this->utilityclass->cassnum($each_land_area_hectr);
                                ?> 
                            </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                            <?php $revenueTotal = $revenueTotal + $p->dag_revenue; ?>
                            <p><?php
                                $rajah = number_format($p->dag_revenue, 2);
                                echo $this->utilityclass->cassnum($rajah);
                                ?>
                            </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td align="middle">
                        <?php 
                        if (!empty($pno['daginfo'])) {
                            foreach ($pno['daginfo'] as $p): ?>
                            <?php $localtaxTotal = $localtaxTotal + $p->dag_localtax; ?>
                            <p><?php
                                $local = number_format($p->dag_localtax, 2);
                                echo $this->utilityclass->cassnum($local);
                                ?> 
                            </p>
                        <?php endforeach; 
                        }
                        ?>
                    </td>
                    <td>
                        <?php foreach ($pno['remarkinf'] as $p): ?>
                        <p><?php echo strip_tags($p->remark); ?></p>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="middle">
                        <?php
                        $single_land_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lesa);
                        if (!empty($pno['daginfo'])) {
                            echo $this->utilityclass->cassnum($single_land_area[0]) . '-' . $this->utilityclass->cassnum($single_land_area[1]) . '-' . $this->utilityclass->cassnum($single_land_area[2]). '-'. $this->utilityclass->cassnum($single_land_area[3]) ;
                            $single_land_area_hectr = $this->utilityclass->get_Hec_Are_CAre2($single_land_area[0], $single_land_area[1], $single_land_area[2], $single_land_area[3]);
                            
                        } else {
                            echo "0-0-0-0";
                            $single_land_area_hectr = "0-0-0-0";
                        }
                        $grand_total_land_area_lessa = $grand_total_land_area_lessa + $total_lesa;
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="middle">
                    <?php
                    echo $this->utilityclass->cassnum($single_land_area_hectr);
                    ?>
                    </td>
                    <td align="middle">
                    <?php
                    $lessa_ass_g = round($revenueTotal, 2);
                    echo $this->utilityclass->cassnum($lessa_ass_g);
                    $GrandrevenueTotal = $GrandrevenueTotal + $revenueTotal;
                    ?>
                    </td>
                    <td align="middle">
                    <?php
                    $localtax_assa_g = round($localtaxTotal, 2);
                    echo $this->utilityclass->cassnum($localtax_assa_g);
                    $GrandlocaltaxTotal = $GrandlocaltaxTotal + $localtaxTotal;
                    ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td align="middle"><?php echo 'Grand total' ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="middle">
                    <?php
                    $all_land_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($grand_total_land_area_lessa);
                    echo $this->utilityclass->cassnum($all_land_area[0]) . '-' . $this->utilityclass->cassnum($all_land_area[1]) . '-' . $this->utilityclass->cassnum($all_land_area[2]) . '-' . $this->utilityclass->cassnum($all_land_area[3]);
                    $All_land_area_hectr = $this->utilityclass->get_Hec_Are_CAre2($all_land_area[0], $all_land_area[1], $all_land_area[2], $all_land_area[3]);
                    ?> 
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="middle">
                    <?php
                    echo $this->utilityclass->cassnum($All_land_area_hectr);
                    ?>
                    </td>
                    <td align="middle">
                    <?php
                    $grand_revenue_assamese = number_format($GrandrevenueTotal, 2);
                    echo $this->utilityclass->cassnum($grand_revenue_assamese);
                    ?>
                    </td>
                    <td align="middle">
                    <?php
                    $grand_local_ass = number_format($GrandlocaltaxTotal, 2);
                    echo $this->utilityclass->cassnum($grand_local_ass);
                    ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
</div>