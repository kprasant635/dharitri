<td valign="top" height="409" width="15%"  rowspan=3 id=chitha_col_31><!--REMARKS-->
    <?php
    //var_dump($chithainf['col31']);
    ?>

    <?php
    $sro_hukum_no = 1;
    if (isset($chithainf['sro'])) {
        $size_of_sro_order = sizeof($chithainf['sro']);
        echo "<u class='text-danger'>SRO টোকা</u>";
        foreach ($chithainf['sro'] as $key => $sr):
            $newDatesro = date("d-m-Y", strtotime($chithainf['sro'][$key]['date_of_deed']));
            $headingsro = '(SR -' . $chithainf['sro'][$key]['name_of_sro'] . ')';
            ?>
            <p><?php //echo  $headingsro.'&nbsp;'.'&nbsp;' . $newDatesro . 'তারিখে' . '&nbsp;'.'&nbsp;'.'Deed No.'.'&nbsp;' . $chithainf['sro'][$key]['deed_no'] . 'নং দলিল যোগে' . '&nbsp;'.'&nbsp;' . $chithainf['sro'][$key]['reg_from_name'] .'&nbsp;'. 'পরা' . '&nbsp;' . $chithainf['sro'][$key]['reg_to_name'] . 'র নামত' . '(B' . $chithainf['sro'][$key]['dag_area_b'] . '- K' . $chithainf['sro'][$key]['dag_area_k'] . '- L' . $chithainf['sro'][$key]['dag_area_lc'] . ')' . 'মাটি' . '&nbsp;' . 'হস্তান্তর ' . '&nbsp;' . 'হয়.'               ?></p>
            <p><?php echo $headingsro . '&nbsp;' . '&nbsp;' . 'এই দাগের (' . $chithainf['sro'][$key]['dag_no'] . ' নং)  জমিতে পটাদার ' . $chithainf['sro'][$key]['reg_from_name'] . ' এবং ক্রেতা / দানগ্রহীতা ' . $chithainf['sro'][$key]['reg_to_name'] . ' এর মধ্যে ' . '<br>(' . $chithainf['sro'][$key]['dag_area_b'] . 'B - ' . $chithainf['sro'][$key]['dag_area_k'] . 'K - ' . $chithainf['sro'][$key]['dag_area_lc'] . 'L)' . $chithainf['sro'][$key]['dag_area_g'] . 'G)' . ' জমির <br> রে: দলিল <br>( Deed No.) ' . $chithainf['sro'][$key]['deed_no'] . ' নং Deed type: <br>'. $chithainf['sro'][$key]['deed_type'] .'<br>' . $newDatesro . ' তারিখে ' . ' পঞ্জীয়ন হয় |' ?></p>

            <?php
            if ($chithainf['sro'][$key]['status'] == '1') {
                echo "<p class='red'><u>Status :</u><br> ( চক্র আধিকারিক নামজারী নিবন্ধিকরণের জন্য আদেশ দেন | )";
            } elseif ($chithainf['sro'][$key]['status'] == '2') {
                echo "<p class='red'><u>Status :</u><br> ( সহায়ক নিবন্ধিকরণ করিলে | )";
            } elseif ($chithainf['sro'][$key]['status'] == '3') {
                echo "<p class='red'><u>Status :</u><br> ( নামজারী হইয়াছে | )";
            }
            ?>
            <?php
            if ($sro_hukum_no < $size_of_sro_order) {
                echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
            }
            $sro_hukum_no++;
            ?>   
            <?php
        endforeach;
    }
    ?>


    <?php
    $order_count = 1;
    foreach ($chithainf['col31'] as $remark):
        ?>
        <?php foreach ($remark as $r): ?>

            <?php if (sizeof($r) > 0): ?>
                <!-- Name Correction Start-->
                <?php if ($r['ord_type_code'] == '06'): ?>
                    <?php echo "<p class='text-danger'><u>চক্র আধিকারিকের : </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তারিখের" . $r['innerdata52'][0]->ord_no . " নাম সংশোধনীকরণ হুকুমমর্মে এই দাগের " . $r['innerdata52'][0]->infavor_of_name . "'এর  নামের পরিবর্তে " . $r['innerdata52'][0]->infavor_of_corrected_name . " করা হইল  |</p>" ?>
                    <p class='hide'>ভূমিলেখ্য সহায়ক : <?php echo $r['lmname']; ?></p>
                    <p><u class='text-danger'>চক্র আধিকারিক:</u><br>(<?php echo $r['username']; ?>)</p>    
            <?php endif; ?>
            <!-- Name Correction End-->
            <!-- Name Cancellation-->
            <?php
			//var_dump($r);
			if ($r['ord_type_code'] == '07'): ?>
                    <?php echo "<p class='text-danger'><u>চক্র আধিকারিকের : </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তারিখের " . $r['order_no'] . " নাম সংশোধনীকরণ হুকুমমর্মে এই দাগের " . $r['infavor_of_name'] . "'  র  আবেদন মর্মে পটাদার " . $r['name_delete'] . "র  নাম কর্তন করা হইল  |</p>" ?>
                    <p class=''>ভূমিলেখ্য সহায়ক : <?php echo $r['lmname']; ?></p>
                    <p><u class='text-danger'>চক্র আধিকারিক:</u><br>(<?php echo $r['username']; ?>)</p>    
            <?php endif; ?>
            <!-- Name Cancellation End-->
			
            <!-- Reclassification Start-->
            <?php if ($r['remark_type_code'] == '08'): ?>
                <?php
                // echo $r['ord_passby_desig'];
                echo "<p class='text-danger'><u>হুকুম নং : </u></p><p>" . $r['case_no'] . " শ্রেণী সংশোধনীকরণ প্রস্তাব উপায়ুক্ত মহোদয়ে " . date('d-m-Y', strtotime($r['dc_approval_date'])) . " তারিখে দেয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পাট্টার " . $r['dag_no'] . " নং দাগের শ্রেণী " . $r['present_land_class'] . " হইতে " . $r['proposed_land_class'] . " তে পরিবৰ্তন করা হইল ।</p>";
                ?>
            <?php endif; ?>
            <!-- Reclassification End-->

            <!-- NR Start-->
            <?php if ($r['remark_type_code'] == '09'): ?>
                <?php
                echo "<p class='text-danger'><u>হুকুম নং : </u></p><p> চক্র আধিকারিকের " . $r['case_no'] . " নং NR গোচরের প্ৰস্তাবের "
                . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . "  তারিখে দেয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পট্টা এবং " . $r['dag_no'] . "   নং দাগের পপাট্টার প্ৰকার একসণা হইতে সরকারীতে পরিবৰ্তন করার হুকুম  ।<hr>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['final_date']))) . " দেওয়া হইল ।</p>";
                ?>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র আধিকারিক :</u><br>(<?php echo $r['username']; ?>)</p>
            <?php endif; ?>
            <!-- NR End-->

            <!-- Office Mutation Start-->
            <?php if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')): ?>
                <u class='text-danger'><?php echo "হুকুম নং: " . $order_count++; ?><br></u>
                <p>চক্র আধিকারিকের<br>  
                    <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> 
					তারিখের  
                    <?php
                    $order_type = $r['ord_type_code'];
                    echo $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                    ?>
                    <?php echo $r['ord_no'] . " এর হুকুমমৰ্মে এই দাগের "; ?>

                    <?php
                    //var_dump($r);
                    if ($r['by_right_of'] == '11' || $r['by_right_of'] == '01' || $r['by_right_of'] == '02') {
                        echo " অংশের জমিতে ";
                    } else {
                        //var_dump($r);
                        echo $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                        echo $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                        echo $this->utilityclass->cassnum($r['lessa']) . " ছটাক ";
						echo $this->utilityclass->cassnum(number_format($r['ganda'], 2)) . " গণ্ডা মাটি "; 
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
                            echo " এবং ";
                            $count++;
                        } else {
                            echo " ";
                        }
                        ?>


                        <?php
                    endforeach;
                    if (sizeof($r['alongwith_name']) != '0') {
                        echo "' এর সামিলে ";
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
                            echo " এবং ";
                            $count++;
                        } else {
                            echo " ";
                        }
                        ?>


                        <?php
                    endforeach;
                    if (sizeof($r['inplace_of_name']) != '0') {
                        echo " র স্থলে ";
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
                            echo " এবং ";
                            $count++;
                        } else {
                            echo " ";
                        }
                        ?>
                    <?php endforeach; ?>

                    <?php if ($r['ord_type_code'] == '03'): ?>
                        র নামে নামজারী করা হইল |
                    <?php endif; ?>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র আধিকারিক :</u><br>(<?php echo $r['username']; ?>)</p>
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
                <hr>
            <?php endif; ?>
            <?php if ($r['ord_type_code'] == '01'): ?>

                <u class='text-danger'><?php echo "হুকুম নং: " . $order_count++; ?></u><br>
                <p><?php echo $r['ord_passby_desig']; ?>র  </p><p>
                    <?php echo $r['ord_no'] . "  নং  "; ?>
                    <?php
                    $order_type = $r['ord_type_code'];
                    echo $this->utilityclass->getOfficeMutType($order_type) . " মামলার ";
                    ?>

                    <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> তারিখের হুকুম মৰ্মে


                    <?php if ($r['premi_chal_recpt'] != '003'): ?>
                        <?php echo $this->utilityclass->cassnum($r['patta_no']) . " নং একসনার পাট্টার এবং " . $this->utilityclass->cassnum($r['dag_no']) . " নং দাগের  "; ?>
                        <?php 
                        if(($r['premi_chal_name'] == "") || ($r['premi_chal_name'] == "None")){
                            echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum($r['land_area_lc']) . " ছটাক " . $this->utilityclass->cassnum(number_format($r['land_area_g'], 2)) . " গণ্ডা মাটির প্রিমিয়াম " . round($r['premium'], 2) . " টাকা মাধ্যমে ";
                        } else {
                            echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum($r['land_area_lc']) . " ছটাক " . $this->utilityclass->cassnum(number_format($r['land_area_g'], 2)) . " গণ্ডা মাটির প্রিমিয়াম " . round($r['premium'], 2) . " টাকা " . $r['premi_chal_recpt_no'] . " নং " . $r['premi_chal_name'] . " মাধ্যমে ";
                        }
                         ?> 
                        <?php
                        $count = 1;
                        $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                        foreach ($r['ord_onbehalf_of'] as $in):
                            ?>
                            <?php
                            echo $in['app_name'];
                            if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                                echo " , ";
                                $count++;
                            } elseif ($count == sizeof($r['ord_onbehalf_of']) - 1) {
                                echo " এবং ";
                                $count++;
                            } else {
                                echo " ";
                            }
                            ?>
                        <?php endforeach; ?>   
                        র হইতে সংগ্রহ হওয়ায় 
                    <?php endif; ?>
                    <?php
                    $count = 1;
                    $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                    foreach ($r['ord_onbehalf_of'] as $in):
                        ?>
                        <?php
                        echo $in['app_name'];
                        if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                            echo " , ";
                            $count++;
                        } elseif ($count == sizeof($r['ord_onbehalf_of']) - 1) {
                            echo " এবং ";
                            $count++;
                        } else {
                            echo " ";
                        }
                        ?>
                    <?php endforeach; ?>
                    র নামত <?php echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum($r['land_area_lc']) . " ছটাক " . $this->utilityclass->cassnum(number_format($r['land_area_g'], 2)) . " গণ্ডা "; ?> মাটি  পৃঠক
                    <?php echo $this->utilityclass->cassnum($r['new_patta_no']) . " নং " . $r['patta_type'] . " পাট্টা এবং " . $this->utilityclass->cassnum($r['new_dag_no']); ?> নং দাগে ম্যাদীকরণ করা হইল | </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র আধিকারিক :</u><br>(<?php echo $r['username']; ?>)</p>
            <?php endif; ?>
			<?php  if (($r['remark_type_code'] == '10') && ($r['ord_type_code'] == '10')): ?>
                <p>হুকুম নং :<?=$r['history_no'];?><br>
				উপায়ুক্ত মহোদয়র <?=$r['ord_no']?> নং আৱন্টন বন্দৱস্তী গোচরের  <?php echo date('d/m/Y',strtotime($r['date_entry']))?>  ইং তারিখের হুকুম মতে চরকারী  <?=$r['old_dag']?>  নং দাগের  <?=$r['allottee_land_b']?> বিঘা  <?=$r['allottee_land_k']?>  কঠা  <?=$r['allottee_land_lc']?> ছটাক <?=$r['allottee_land_g']?> গণ্ডা মাটির  <?=$r['new_dag']?>  নং দাগ এবং <?=$r['new_patta']?> নং নতুন খেরাজ ম্যাদী পট্টা ভূক্ত করা হইল । <?php echo date('Y')?> চনত দৌল ভূক্ত হবে । </p>
				<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র আধিকারিক  :</u><br>(<?php echo $r['username']; ?>)</p>
            <?php endif; ?>
            <?php
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '04')):
                $howmany = sizeof($r['infav']);
                if ($howmany != null) {
                    ?>

                    <p><u class="text-danger"><?php echo "হুকুম নং: " . $order_count++; ?></u></p>
                    <p>চক্র আধিকারিকের   
                        <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> 
                        তারিখের   
                        <?php
                        $order_type = $r['ord_type_code'];
                        echo $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                        ?>
                        <?php echo $r['ord_no'] . " র হুকুমমর্মে এই দাগের "; ?>

                        <?php
                        echo $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                        echo $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                        echo $this->utilityclass->cassnum($r['lessa']) . " ছটাক ";
						echo $this->utilityclass->cassnum(number_format($r['ganda'], 2)) . " গণ্ডা মাটি   ";
                        ?>
                        <?php
                        $count = 1;
                        $howmany = sizeof($r['infav']);
                        foreach ($r['infav'] as $in):
                            ?>
                            <?php
                            echo $in['infavor_of_name'];
                            if ($count < sizeof($r['infav']) - 1) {
                                echo " , ";
                                $count++;
                            } elseif ($count == sizeof($r['infav']) - 1) {
                                echo " এবং  ";
                                $count++;
                            } else {
                                echo " ";
                            }
                            ?>
                        <?php endforeach; ?>'র নামে
                        <?php echo $this->utilityclass->cassnum($r['new_patta_no']) . " নং  পট্টা আরু " . $this->utilityclass->cassnum($r['new_dag_no']); ?> নং দাগ করা হইল |
                        <?php if ($r['ord_type_code'] == '04'): ?>

                        <?php endif; ?>
                    <p><u class="text-danger">ভূমিলেখ্য সহায়ক :-</u><br>(<?php echo $r['lm_name']; ?>)</p>
                    <p><u class="text-danger">চক্র আধিকারিক :-</u><br>(<?php echo $r['username']; ?>)</p>
                    <!--                        <p>Reg No (<?php //echo $r['reg_deal_no'];              ?>)</p>
                    <p>Reg Date (<?php //echo date('d-m-Y',strtotime($r['reg_date']));             ?>)</p>-->
                    <hr>
                <?php } ?>
            <?php endif; ?>
            <?php if ($r['ord_type_code'] == '01'): ?>
                <?php if ($r['premi_chal_recpt'] == '003'): ?>
                    <?php echo "<hr><p class='text-danger'><u>টোকা :</u></p> আবেদনকারী প্রিমিয়াম জমা না দেওয়ার জন্য " . round($r['premium'], 2) . " টাকা রাজস্ব বকেয়া হিসাবে জমা লওয়া হউক ।।" ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    <?php endforeach; ?> 
<?php endforeach; ?>


<?php
if (isset($chithainf['lmnote'])) {
    echo "<u class='text-danger'>ভূমিলেখ্য সহায়কর টুকা</u>";
    foreach ($chithainf['lmnote'] as $key => $enc):
        ?>
        <p><?php echo $chithainf['lmnote'][$key]['lm_note']."----".$chithainf['lmnote'][$key]['lm_code']; ?></p>
        <?php
    endforeach;
}
?>


<?php
if (isset($chithainf['encro'])) {
    $encro_hukum_no = 1;
    $size_of_encro_order=sizeof($chithainf['encro']);
    echo "<u class='text-danger'>বেদখলকারীর টুকা</u>";
    foreach ($chithainf['encro'] as $key => $enc):
        $newDate = date("d-m-Y", strtotime($chithainf['encro'][$key]['encro_since']));
        ?>
        <p><?php echo $chithainf['encro'][$key]['encro_name'] . 'য়ে' . '&nbsp;' . '(' . $chithainf['encro'][$key]['encro_land_b'] . '-' . $chithainf['encro'][$key]['encro_land_k'] . '-' . $chithainf['encro'][$key]['encro_land_lc'] . '-' . $chithainf['encro'][$key]['encro_land_g'] . ')' . 'মাটি' . '&nbsp;' . $newDate . 'তারিখ হইতে' . '&nbsp;' . $chithainf['encro'][$key]['land_used_by_encro'] . 'এই উদ্দেশ্যে ব্যবহার করা হয় '; ?></p>
        <?php
    endforeach;
    if ($encro_hukum_no < $size_of_encro_order) {
        echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
    }
    $encro_hukum_no++;
}
?>



<?php
foreach ($chithainf['archeo'] as $key => $archeo):
    echo '<u>' . $chithainf['archeo'][$key]['hist_description_nme'] . ': </u><br>'. $chithainf['archeo'][$key]['archeo_decribed'] . '<br>' . '(' . $chithainf['archeo'][$key]['archeo_b'] . '-' . $chithainf['archeo'][$key]['archeo_k'] . '-' . $chithainf['archeo'][$key]['archeo_lc'] . ')' . '';
endforeach;
// foreach ($chithainf['appeal147'] as $appeal147) {
    // foreach ($appeal147 as $b) {
		// echo "<u class='red'>"."Appeal case U/S 147 "."</u><br>";
        // echo "<p>$b->dcfinal_note</p>";
		// echo "-----------------------------";
		// echo "<br>";
    // }
// }
foreach ($chithainf['backlogs31'] as $backlog) {
    foreach ($backlog as $b) {
		echo "<u>"." সরাসরি 31 তম স্তম্ভে প্রৱেশ"."</u><br>";
        echo "<p>$b->remark</p>";
		echo "-----------------------------";
    }
}

foreach ($chithainf['backlog_court_order'] as $court_order) {
    foreach ($court_order as $b) {
		echo "<u>"."১১৮ Court Order"."</u><br>";
        echo "<p>$b->remark</p>";
		echo "-----------------------------";
    }
}
?>
</td>
<style>
    p{
        line-height:120%;
    }
</style>