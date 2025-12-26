<td valign="top" height="409" width="15%"  rowspan=3 id=chitha_col_31><!--REMARKS-->
<?php
    $order_count = 1;
    foreach ($chithainf['col31'] as $remark):
        ?>
        <?php foreach ($remark as $r):
         ?>
           <?php if (sizeof($r) > 0): ?>
                <!-- Name Correction Start-->
                <?php if ($r['ord_type_code'] == '06'): ?>
                    <?php if($r['strikeout']=='Y')
                            {
                                $strike='<s>';
                                $strike_close='</s>';
                            }
                          else
                            {
                                $strike=null;
                                $strike_close=null;
                            }
                     ?>
                    <?php echo "<p class='text-danger'>".$strike."<u>চক্র বিষয়া'ৰ : </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তাৰিখ'ৰ " . $r['innerdata52'][0]->ord_no . " হুকুম নং নাম সংশোধনীকৰণ হুকুমমৰ্মে এই দাগৰ " . $r['innerdata52'][0]->infavor_of_name . "'ৰ  নাম  " . $r['innerdata52'][0]->infavor_of_corrected_name . " কৰা হ'ল  |</s></p>" ?>
                    <!-- <p class='hide'>ভূমিলেখ্য সহায়ক : <?php echo $r['lmname']; ?></p> -->
                    <p><u class='text-danger'>চক্র বিষয়া :</u><br>(<?php echo $r['username'].$strike_close; ?>)</p> 
                    <hr style='border-bottom: 2px solid #b3b0b0;'>              
            <?php endif; ?>
            <!-- Name Correction End-->
            <!-- Name Cancellation-->
            <?php
            //var_dump($r);
            if ($r['ord_type_code'] == '07'): ?>
                    <?php echo "<p class='text-danger'><u>চক্র বিষয়া'ৰ : </u></p><p>" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['orderdate']))) . " তাৰিখ'ৰ " . $r['order_no'] . " হুকুম নং নাম কৰ্তন  হুকুমমৰ্মে এই দাগৰ পটাদাৰ " . $r['infavor_of_name'] . "'  ৰ  আবেদন মৰ্মে পটাদাৰ " . $r['name_delete'] . "ৰ  নাম কৰ্তন কৰা হ'ল  |</p>" ?>
                    <!--<p class=''>ভূমিলেখ্য সহায়ক : <?php echo $r['lmname']; ?></p>-->
                    <p><u class='text-danger'>চক্র বিষয়া :</u><br>(<?php echo $r['username']; ?>)</p> 
                    <hr style='border-bottom: 2px solid #b3b0b0;'>
            <?php endif; ?>
            <!-- Name Cancellation End-->
            
            <!-- Reclassification Start-->
            <?php if ($r['remark_type_code'] == '08'): ?>
                <?php
                echo "<p class='text-danger'><u>হুকুম নং : </u></p><p>" . $r['case_no'] . " শ্রেণী সংশোধনীকৰণ প্রস্তাব  উপায়ুক্ত মহোদয়ে " . date('d-m-Y', strtotime($r['dc_approval_date'])) . " তাৰিখে দিয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পট্টাৰ " . $r['dag_no'] . " নং দাগৰ শ্রেণী " . $r['present_land_class'] . "'ৰ পৰা " . $r['proposed_land_class'] . " লৈ পৰিবৰ্তন কৰা হ'ল ।</p>";

               ?>
                <hr style='border-bottom: 2px solid #b3b0b0;'>
            <?php endif; ?>
            <!-- Reclassification End-->

            <!-- NR Start-->
            <?php if ($r['remark_type_code'] == '09'): ?>
                <?php
                echo "<p class='text-danger'><u>হুকুম নং : </u></p><p> চক্র বিষয়া'ৰ " . $r['case_no'] . " নং NR গোচৰৰ প্ৰস্তাৱৰ "
                . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))) . "  তাৰিখে দিয়া অনুমোদন মৰ্মে " . $r['patta_no'] . " নং পট্টা আৰু " . $r['dag_no'] . "  নং দাগৰ পট্টাৰ প্ৰকাৰ একচণাৰ পৰা চৰকাৰীলৈ পৰিবৰ্ত্তন কৰাৰ হুকুম " . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['final_date']))) . " তাৰিখে দিয়া হল ।</p>";
                ?>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র বিষয়া :</u><br>(<?php echo $r['username']; ?>)</p>
                <hr style='border-bottom: 2px solid #b3b0b0;'>
            <?php endif; ?>
            <!-- NR End-->

            <!-- Office Mutation Start-->
            <?php if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')): ?>
                <?php if($r['strikeout']=='Y')
                        {
                            $strike='<s>';
                            $strike_close='</s>';
                        }
                      else
                        {
                            $strike=null;
                            $strike_close=null;
                        }
                ?>
                <u class='text-danger'><?php echo $strike."হুকুম নং: " . $order_count++; ?><br></u>
                <p>চক্র বিষয়া'ৰ  <br>  
                    <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> 
                    তাৰিখ'ৰ   
                    <?php
                    $order_type = $r['ord_type_code'];
                    echo $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                    ?>
                    <?php echo $r['ord_no'] . " 'ৰ হুকুমমৰ্মে এই দাগৰ "; ?>

                    <?php
                    //var_dump($r);
                    if ($r['by_right_of'] == '11' || $r['by_right_of'] == '01' || $r['by_right_of'] == '02') {
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
                   if (!in_array($r['by_right_of'], ['11', '01', '02'])) {
                        echo "Reg No (" . $this->utilityclass->cassnum($r['reg_deal_no']) . ") <br>";
                        echo "Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")".$strike_close;
                    }
                    ?>
                </p>
                <hr style='border-bottom: 2px solid #b3b0b0;'>
                <p>
                    <?php
                    if ($r['operation'] == "B") {
                        echo "চঃ বিঃ – ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল  ";
                        echo "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                    }
                    ?>
                </p>
                <hr>
            <?php endif; ?>
            <!-- /////////////////////////////// -->
            <?php if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == SETTLEMENT_TENANT_ID)): 
            if($r['full_dag']==0){
                $new_tent_dag="নতুন দাগ নং ".$r['dag'] ." আৰু ";
            }else{
                $new_tent_dag=" ";
            }
            ?>
            <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
            <p><?=$this->utilityclass->dateFormat($r['rtps_app_date'],'dMY')?> তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ <?=$r['rtps_no']?> ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী কেছ নম্বৰ <?=$r['order_no']?> ৰ ওপৰত ভিত্তি কৰি ও জিলা  আয়ুক্ত মহোদয়ৰ <?=$this->utilityclass->dateFormat($r['dc_order_date'],'dMY')?> তাৰিখৰ  <?=$r['dc_order_no']?> নং হুকুম মৰ্মে ,দখলিস্বত্ব থকা ৰায়তে/ দখলিস্বত্ব থকা ৰায়তৰ আইনী উত্তৰাধিকাৰী <?=$r['infavor_of_name']?>, অসম অস্থায়ী বন্দৱস্তী এলেকাৰ ৰায়তী আইন ১৯৭১ ৰ ধাৰা ২৩ অনুসৰি মালিকী স্বত্ব পোৱাত <?=$r['old_patta_no']?> নং পট্টাৰ অধীনত <?=$r['old_dag']?> নং দাগৰ <?=$r['khatian_no']?> নং খতিয়ানৰ মুঠ  <?=$r['mdagareab']?> বিঘা <?=$r['mdagareak']?> কঠা <?=$r['mdagarealc'] ?> লেচা ভূমিত <?=$this->utilityclass->dateFormat($r['payment_date'],'dMY')?> তাৰিখৰ <?=$r['grn_no']?> যোগে সম্পূৰ্ণ ক্ষতিপূৰণৰ পৰিমাণ <?=$r['paid_amount']?>/ টকা আদায় হোৱাত 
            <?=$new_tent_dag?> নতুন ম্যাদী পট্টা নং <?=$r['newpatta_no']?> সৃষ্টি কৰি ভূমি নথি  সংশোধন  কৰা হল। <br>

            <p><u class='text-danger'>তাৰিখ :</u><?=$this->utilityclass->dateFormat($r['ord_date'],'dMY') ?></p>
            <p><u class='text-danger'>ভুমিলেখ্য সহায়ক :</u><?=$r['lm_name'] ?></p>
            <p><u class='text-danger'>চক্ৰ বিষয়া : </u> <?=$r['co_name'] ?></p> 
            </p>
            <?php endif; ?> 
            <!-- //////////////////////////////// -->
            <?php if (($r['remark_type_code'] == '01') && (in_array($r['ord_type_code'],[SETTLEMENT_KHAS_LAND_ID,SETTLEMENT_TRIBAL_COMMUNITY_ID,SETTLEMENT_SPECIAL_CULTIVATORS_ID,SETTLEMENT_AP_TRANSFER_ID,SETTLEMENT_SVAMITVA]))): ?>
                <?php 
                $m2servicename=$this->utilityclass->mb2ServiceName($r['ord_type_code']);
                ?>
                <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
                <?php
                    // var_dump($r);
                    $previousDag=$partial_final_complete="";
                    $purpose=($r['home_agri']==1)?' , বাসস্থান ':' , কৃষি' ;
                    $count = 1;
                    if($r['rural_urban']==1){
                        $urban_add="অসম চৰকাৰৰ ".$this->utilityclass->dateFormat($r['dept_order_date'],'dMY')." তাৰিখৰ অনুমোদন নং ".$r['dept_order_no']." ও";
                    }else{
                        $urban_add="";
                    }
                    // echo $r['partial_pay_status'];
                    if($r['full_dag']==0 && $r['partial_pay_status']==0){
                        $total_word="মুঠ ".$r['oldarea_b']." বিঘা ".$r['oldarea_k']." কঠা ".$r['oldarea_lc']." লেচা";
                        $fullPartial=" নতুন  দাগ নং ".$r['dag']." সৃষ্টি কৰি ";
                        $new_area="ৰ পৰা <b>".$r['mdagareab']." বিঘা ".$r['mdagareak']." কঠা ".$r['mdagarealc']." লেচা </b> ভূমি <b>".$purpose."</b> ৰ বাবে ";
                    }else{
                        $total_word= $r['mdagareab']." বিঘা ".$r['mdagareak']." কঠা ".$r['mdagarealc']." লেচা";
                        $new_area= "";
                        $fullPartial="";
                        $previousDag="<b>".$purpose."</b> ৰ বাবে ";
                    }
                    // echo $r['full_partial'];
                    if($r['full_partial']=='1'){
                        if($r['final_premium_amount'] > $r['paid_amount']){
                        echo "<p> ". "আংশিক প্ৰিমিয়াম  ".$r['paid_amount']." টকা ".$this->utilityclass->dateFormat($r['payment_date'],'dMY') ." তাৰিখৰ ".$r['grn_no']." যোগে আদায় পোৱা গ’ল। বাকী থকা প্ৰিমিয়ামৰ পৰিমাণ হ’ল ".($r['final_premium_amount']- $r['total_paid_amount'])." টকা। সম্পূৰ্ণ প্ৰিমিয়াম আদায় পোৱাৰ পিছতহে চুড়ান্ত বন্দৱস্তী কাৰ্যকৰী কৰা হ’ব। </p> <hr>";
                        }
                        $remarksFull=$r['paid_amount']." টকাৰ সম্পূৰ্ণ  আৰু চুড়ান্ত প্ৰিমিয়াম ".$this->utilityclass->dateFormat($r['payment_date'],'dMY') ." তাৰিখৰ ".$r['grn_no']." যোগে আদায় সম্পূৰ্ণ হোৱাত বন্দৱস্তী দিয়া হ’ল। সেই অনুযায়ী ".$fullPartial.$partial_final_complete." নতুন  ".$r['newpatta_type']." পাট্টা নং ".$r['newpatta_no']." সৃষ্টি কৰি ভূমি নথি সংশোধন কৰা হ’ল।" ;
                    }else{
                        // $previousDag=  " ,<b>".$purpose."</b> ৰবাবে ";
                        $remarksFull = "<u>".$m2servicename."</u> অধীনত ".$r['final_premium_amount']." টকাৰ সম্পূৰ্ণ আৰু চুড়ান্ত প্ৰিমিয়াম আদায় পোৱাৰ সাপেক্ষে ". $fullPartial ."  বন্দৱস্তীৰ বাবে প্ৰস্তুৱত অনুমোদন দিয়া হয় ।  আংশিক প্ৰিমিয়াম ". $r['paid_amount'] ." টকা ". $this->utilityclass->dateFormat($r['payment_date'],'dMY') ." তাৰিখৰ ".$r['grn_no']." যোগে আদায় পোৱা গ’ল। বাকী থকা প্ৰিমিয়ামৰ পৰিমাণ হ’ল ".($r['final_premium_amount']-$r['paid_amount'])." টকা। সম্পূৰ্ণ প্ৰিমিয়াম আদায় পোৱাৰ পিছতহে চুড়ান্ত বন্দৱস্তী কাৰ্যকৰী কৰা হ’ব।";
                    }
                    // echo $remarksFull;
                    if($r['partial_pay_status']==1){
                        echo "<p> ".$this->utilityclass->dateFormat($r['rtps_app_date'],'dMY') ." তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ ".$r['rtps_no'] ." ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ ". $r['order_no'] ." ৰ ওপৰত ভিত্তি কৰি উপৰোক্ত ১ নং হুকুম মৰ্মে, ".$r['infavor_of_name']." ৰ নামত ".$r['final_premium_amount']."  টকাৰ সম্পূৰ্ণ আৰু চুড়ান্ত প্ৰিমিয়াম আদায় সম্পূৰ্ণ হোৱাত নতুন  ".$r['newpatta_type']." পাট্টা নং ".$r['newpatta_no']." ত বন্দৱস্তী দিয়া হ’ল  আৰু ভূমিনথি সংশোধন কৰা হ’ল। ";
                    }else{
                        echo "<p>" . $this->utilityclass->dateFormat($r['rtps_app_date'],'dMY')." তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ ". $r['rtps_no'] . " ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ ".$r['order_no']." ৰ ওপৰত ভিত্তি কৰি, আৱেদনকাৰীৰ ". $this->utilityclass->dateFormat($r['possession_from'],'dMY') ." তাৰিখ ৰ পৰা দখল থকা অনুসৰি আৰু ".$urban_add." জিলা আয়ুক্তৰ ".$this->utilityclass->dateFormat($r['dc_order_date'],'dMY')." তাৰিখৰ ".$r['dc_order_no']." নং হুকুম মৰ্মে, ".$r['old_dag']." নং দাগৰ ".$total_word." চৰকাৰী ভূমি".$new_area.$previousDag." ".$r['infavor_of_name']." ৰ নামত ".$remarksFull."  </p>";
                    }
                    echo "<p><u class='text-danger'>তাৰিখ :</u>".$this->utilityclass->dateFormat($r['ord_date'],'dMY') ."</p>";
                    echo "<p><u class='text-danger'>ভুমিলেখ্য সহায়ক :</u>".$r['lm_name'] ."</p>";
                    echo "<p><u class='text-danger'>চক্ৰ বিষয়া – </u> ".$r['co_name'] ."</p>"; 
            ?>
            <?php endif; ?>  
            <?php  if (($r['remark_type_code'] == '01') && (in_array($r['ord_type_code'],[SLIJE_ID]))):
            // var_dump($r);
             ?>
                <?php 
                $m2servicename=$this->utilityclass->mb2ServiceName($r['ord_type_code']);
                if($r['dept_order_no']){
                        $urban_add="অসম চৰকাৰৰ ".$this->utilityclass->dateFormat($r['dept_order_date'],'dMY')." তাৰিখৰ অনুমোদন নং ".$r['dept_order_no']." ও";
                }else{
                    $urban_add="";
                }
                // echo $r['partial_pay_status'];
                if($r['grn_no']!='NA'){
                  $premium= $r['paid_amount']." টকা ". $this->utilityclass->dateFormat($r['payment_date'],'dMY') ." তাৰিখৰ ". $r['grn_no'] ." যোগে আদায় হোৱাত ,";  
                }else{
                   $premium=null; 
                }
                if($r['new_patta_no']){
                    $newpatta = " নতুন বিশেষ ম্যাদী পাট্টা নং ". $r['new_patta_no'] ." সৃষ্টি কৰি";
                }else{
                    $newpatta = null;
                }
                if($r['full_dag']==0){
                    $fullPartial=" নতুন ". $r['dag_no'] ." নং দাগভুক্ত কৰি ভূমি নথি সংশোধন কৰা হ’ল।";
                    $part=" অংশ "; 
                }else{
                    $fullPartial=" ভূমি নথি সংশোধন কৰা হ’ল। ";
                    $part=" ";
                }
                ////////////
                if($r['is_settlement']==1 || in_array($r['rural_urban'],['cg'])){
                    $allot_settle = "  বন্দৱস্তী দিয়া মৰ্মে ";
                }else{
                    $allot_settle = " আবন্টন দিয়া মৰ্মে ";
                }
                if(in_array($r['rural_urban'],['cg','cgu'])){
                    $central=" ভূমি হস্তান্তৰ নীতিত ";
                }else{
                    $central="";
                }
                if(in_array($r['rural_urban'],['sgu','cgu'])){
                    $orginasation= " উদ্যোগৰ  ";
                }else{
                    $orginasation= " প্ৰতিষ্ঠান/অনুষ্ঠানৰ ";
                }

                ?>
                <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
                <p><?=$this->utilityclass->dateFormat($r['rtps_app_date'],'dMY')?> তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ <?=$r['rtps_no']?> ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ <?=$r['order_no']?> ৰ ওপৰত ভিত্তি কৰি ও <?=$urban_add?> জিলা  আয়ুক্ত মহোদয়ৰ <?=$this->utilityclass->dateFormat($r['dc_order_date'],'dMY')?> তাৰিখৰ  <?=$r['dc_order_no']?> নং হুকুম মৰ্মে ,<?=$r['old_dag']?> নং দাগৰ <?=$part?> <?=$r['mdagareab']?> বিঘা <?=$r['mdagareak']?> কঠা <?=$r['mdagarealc'] ?> লেচা চৰকাৰী ভূমি 
                <b><?=$r['infavor_of_name']?></b> <?=$orginasation?> নামত <b><?=$r['purpose']?></b> উদ্দেশ্যে, <?=$premium?> <?=$central?> <?=$allot_settle?> <?=$newpatta?> <?=$fullPartial?> 
                <br>

                <p><u class='text-danger'>তাৰিখ :</u><?=$this->utilityclass->dateFormat($r['ord_date'],'dMY') ?></p>
                <p><u class='text-danger'>ভুমিলেখ্য সহায়ক :</u><?=$r['lm_name'] ?></p>
                <p><u class='text-danger'>চক্ৰ বিষয়া : </u> <?=$r['co_name'] ?></p> 
                 <?php endif; ?>  
            <!-- /////////////////////// -->
            <?php  if (($r['remark_type_code'] == '01') && (in_array($r['ord_type_code'],[RECLASS_ID]))):
            // var_dump($r);
            ?>
            <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
            <p> <?php if($r['full_partial']=='P') {
                $partial="বাটোৱাৰা কৰি ".$r['dag_no']." নং দাগভুক্ত কৰি";
            }else{
                $partial='';
            }
            if($r['dept_order_no']){
                $dept_order="অসম চৰকাৰৰ ".$r['dept_order_date']." তাৰিখৰ অনুমোদন নং ".$r['dept_order_no']. " ও";
            }else{
                $dept_order = "";
            }
            if($r['new_patta_no']){
                $pattaName="ম্যাদী পট্টা নং ".$r['new_patta_no'] ." সৃষ্টি কৰি ";
            }else{
                $pattaName= "";
            }
            ?>
                <?=$r['rtps_app_date']?> তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ <?=$r['rtps_no']?> ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ <?=$r['order_no']?> ৰ ওপৰত ভিত্তি কৰি, জিলা পৰ্যায়ৰ কমিটিৰ অনুমোদন মৰ্মে <?=$dept_order?> ও জিলা আয়ুক্তৰ <?=$r['dc_order_date']?> তাৰিখৰ <?=$r['dc_order_no']?> নং হুকুম মৰ্মে, <?=$r['old_dag']?> নং দাগৰ <?=$r['mdagareab']?> বিঘা <?=$r['mdagareak']?> কঠা <?=$r['mdagarealc']?> লেচা <b><?=$r['present_land_class']?></b> শ্ৰেণীভূক্ত  ভূমি সম্পূৰ্ণ প্ৰিমিয়াম <?=$r['payment_date']?> তাৰিখৰ <?=$r['grn_no']?> যোগে আদায় হোৱাত <b><?=$r['proposed_land_class']?></b> শ্ৰেণীলৈ পৰিবৰ্তন কৰি, <?=$r['pdar_name']?> ৰ নামত <?=$partial?> <?=$pattaName?> ভূমি নথি সংশোধন কৰা হ’ল।    
            </p>
            <br>
                <p><u class='text-danger'>তাৰিখ :</u><?=$this->utilityclass->dateFormat($r['ord_date'],'dMY') ?></p>
                <p><u class='text-danger'>ভুমিলেখ্য সহায়ক :</u><?=$r['lm_name'] ?></p>
                <p><u class='text-danger'>চক্ৰ বিষয়া : </u> <?=$r['co_name'] ?></p>
            <?php endif; ?> 
            <?php  if (($r['remark_type_code'] == '01') && (in_array($r['ord_type_code'],[RECLASS_HYDRO]))):
            ?> 
            <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
            <p>
            অসম চৰকাৰৰ <?=$r['dept_order_date']?> তাৰিখৰ <?=$r['dept_order_no']?> নং জাননী মতে আৱেদন নম্বৰ 
            <?=$r['rtps_no']?> 
            ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ <?=$r['order_no']?>  ওপৰত ভিত্তি কৰি  <?=$r['old_dag']?> দাগৰ <?=$r['mdagareab']?> বিঘা <?=$r['mdagareak']?> কঠা <?=$r['mdagarealc']?> লেচা <b><?=$r['present_land_class']?></b> 
            শ্ৰেণী ভুক্ত ভূমিৰ সম্পূৰ্ণ প্ৰিমিয়াম <?=$r['payment_date']?> তাৰিখৰ <?=$r['grn_no']?> GRN No.-ৰ যোগে আদায় হোৱাত 
            <b><?=$r['proposed_land_class']?></b> শ্ৰেণী লৈ স্বয়ংক্ৰিয়ভাৱে ভূমি শ্ৰেণী পৰিৱৰ্তন কৰি নথি সংশোধন কৰা হ’ল।
            </p>
            <p><u class='text-danger'>তাৰিখ :</u><?=$this->utilityclass->dateFormat($r['ord_date'],'dMY') ?></p>
            <?php endif; ?>  
            
            <!-- /////////////////////// -->
            <?php  if (($r['remark_type_code'] == '01') && (in_array($r['ord_type_code'],[SERVICE_CONVERSION_MB3]))):
            // var_dump($r);
            ?>
            <u class='text-danger'><?php echo " হুকুম নং: " . $order_count++; ?><br></u>
            <p> <?php 
            if($r['dept_order_no']){
                $dept_order="অসম চৰকাৰৰ ".$r['dept_order_date']." তাৰিখৰ অনুমোদন নং ".$r['dept_order_no']. ", জিলা আয়ুক্তৰ অনুমোদন মৰ্মে ও ";
            }else{
                $dept_order = "";
            }
            ?>
                <?=$r['rtps_app_date']?> তাৰিখৰ মিছন বসুন্ধৰাৰ আৱেদন নম্বৰ <?=$r['rtps_no']?> ৰ সৈতে সম্পৰ্কিত ধৰিত্ৰী গোচৰ নম্বৰ <?=$r['order_no']?> ৰ ওপৰত ভিত্তি কৰি, <?=$dept_order?> চক্ৰ বিষয়াৰ অনুমোদন মৰ্মে <?=date('Y-m-d',strtotime($r['orderdate']));?> তাৰিখৰ হুকুম মৰ্মে, <?=$r['old_dag']?> নং দাগৰ <?=$r['mdagareab']?> বিঘা <?=$r['mdagareak']?> কঠা <?=$r['mdagarealc']?> লেচা  ভূমি সম্পূৰ্ণ প্ৰিমিয়াম <?=$r['payment_date']?> তাৰিখৰ <?=$r['grn_no']?> যোগে আদায় হোৱাত <?=$r['pdar_name']?> ৰ নামত <?=$r['dag_no']?> নং দাগভুক্ত কৰি ম্যাদী পট্টা নং <?=$r['new_patta_no']?> সৃষ্টি ভূমি নথি সংশোধন কৰা হ’ল।    
            </p>
            <br>
                <p><u class='text-danger'>তাৰিখ :</u><?=$this->utilityclass->dateFormat($r['ord_date'],'dMY') ?></p>
                <p><u class='text-danger'>ভুমিলেখ্য সহায়ক :</u><?=$r['lm_name'] ?></p>
                <p><u class='text-danger'>চক্ৰ বিষয়া : </u> <?=$r['co_name'] ?></p>
            <?php endif; ?>  
            <!-- //////////RECLS END//////////// -->
            <?php if ($r['ord_type_code'] == '01'): ?>

                <u class='text-danger'><?php echo "হুকুম নং: " . $order_count++; ?></u><br>
                <p><?php echo $r['ord_passby_desig']; ?>ৰ  </p><p>
                    <?php echo $r['ord_no'] . "  নং  "; ?>
                    <?php
                    $order_type = $r['ord_type_code'];
                    echo $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                    ?>

                    <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?>  তাৰিখৰ হুকুমমৰ্মে


                    <?php if ($r['premi_chal_recpt'] != '003'): ?>
                        <?php echo $this->utilityclass->cassnum($r['patta_no']) . " নং একচনা পট্টাৰ আৰু " . $this->utilityclass->cassnum($r['dag_no']) . " নং দাগৰ  "; ?>
                        <?php 
                        if(($r['premi_chal_name'] == "") || ($r['premi_chal_name'] == "None")){
                            echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা মাটিৰ প্রিমিয়াম " . round($r['premium'], 2) . " টকা যোগে ";
                        } else {
                            echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা মাটিৰ প্রিমিয়াম " . round($r['premium'], 2) . " টকা " . $r['premi_chal_recpt_no'] . " নং " . $r['premi_chal_name'] . " যোগে ";
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
                                echo " আৰু ";
                                $count++;
                            } else {
                                echo " ";
                            }
                            ?>
                        <?php endforeach; ?>   
                        ৰ পৰা আদায় হোৱাত 
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
                            echo " আৰু ";
                            $count++;
                        } else {
                            echo " ";
                        }
                        ?>
                    <?php endforeach; ?>
                    ৰ নামত <?php echo $this->utilityclass->cassnum($r['land_area_b']) . " বিঘা  " . $this->utilityclass->cassnum($r['land_area_k']) . " কঠা  " . $this->utilityclass->cassnum(number_format($r['land_area_lc'], 2)) . " লেছা "; ?> মাটি  পৃঠক
                    <?php echo $this->utilityclass->cassnum($r['new_patta_no']) . " নং " . $r['patta_type'] . "  পট্টা আৰু " . $this->utilityclass->cassnum($r['new_dag_no']); ?> নং দাগে ম্যাদীকৰণ কৰা হল | </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র বিষয়া :</u><br>(<?php echo $r['username']; ?>)</p>
                <hr style='border-bottom: 2px solid #b3b0b0;'>
            <?php endif; ?>
            <?php  if (($r['remark_type_code'] == '10') && ($r['ord_type_code'] == '10')): ?>
                <p>হুকুম নং :<?=$r['history_no'];?><br>
                উপায়ুক্ত মহোদয়ৰ <?=$r['ord_no']?> নং আৱন্টন বন্দৱস্তী গোচৰৰ  <?php echo date('d/m/Y',strtotime($r['date_entry']))?>  ইং তাৰিখৰ হুকুম মতে চৰকাৰী  <?=$r['old_dag']?>  নং দাগৰ  <?=$r['allottee_land_b']?> বিঘা  <?=$r['allottee_land_k']?>  কঠা  <?=$r['allottee_land_lc']?> লেছা মাটিৰ  <?=$r['new_dag']?>  নং দাগ আৰু  <?=$r['new_patta']?> নং নতুন খেৰাজ ম্যাদী পট্টা ভূক্ত কৰা হল । <?php echo date('Y')?> চনত দৌল ভূক্ত হব । </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র বিষয়া  :</u><br>(<?php echo $r['username']; ?>)</p>
            <?php endif; ?>

            <?php  if (($r['remark_type_code'] == '11')): ?>
                <p>হুকুম নং :<?=$r['history_no'];?><br>
                উপায়ুক্ত মহোদয়ৰ <?=$r['ord_no']?> নং আৱন্টন বন্দৱস্তী গোচৰৰ  <?php echo date('d/m/Y',strtotime($r['date_entry']))?>  ইং তাৰিখৰ হুকুম মতে চৰকাৰী  <?=$r['old_dag']?>  নং দাগৰ  <?=$r['allottee_land_b']?> বিঘা  <?=$r['allottee_land_k']?>  কঠা  <?=$r['allottee_land_lc']?> লেছা মাটিৰ  <?=$r['new_dag']?>  নং দাগ আৰু  <?=$r['new_patta']?> নং নতুন খেৰাজ ম্যাদী পট্টা ভূক্ত কৰা হল । <?php echo date('Y')?> চনত দৌল ভূক্ত হব । </p>
                <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $r['lm_name']; ?>)</p>
                <p><u class='text-danger'>চক্র বিষয়া  :</u><br>(<?php echo $r['username']; ?>)</p>
            <?php endif; ?>
            
            

            
            <?php
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '04')):
                $howmany = sizeof($r['infav']);
                if ($howmany != null) {
                    ?>

                    <p><u class="text-danger"><?php echo "হুকুম নং: " . $order_count++; ?></u></p>
                    <p>চক্র বিষয়া'ৰ   
                        <?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['order_date']))); ?> 
                        তাৰিখৰ   
                        <?php
                        $order_type = $r['ord_type_code'];
                        echo $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                        ?>
                        <?php echo $r['ord_no'] . " ৰ হুকুমমৰ্মে এই দাগৰ "; ?>

                        <?php
                        echo $this->utilityclass->cassnum($r['bigha']) . " বিঘা ";
                        echo $this->utilityclass->cassnum($r['katha']) . " কঠা ";
                        echo $this->utilityclass->cassnum(number_format($r['lessa'], 2)) . " লেছা মাটি   ";
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
                                echo " আৰু ";
                                $count++;
                            } else {
                                echo " ";
                            }
                            ?>
                        <?php endforeach; ?>'ৰ নামত 
                        <?php echo $this->utilityclass->cassnum($r['new_patta_no']) . " নং  পট্টা আৰু " . $this->utilityclass->cassnum($r['new_dag_no']); ?> নং দাগ কৰা হল |
                        <?php if ($r['ord_type_code'] == '04'): ?>

                        <?php endif; ?>
                    <p><u class="text-danger">ভূমিলেখ্য সহায়ক :-</u><br>(<?php echo $r['lm_name']; ?>)</p>
                    <p><u class="text-danger">চক্র বিষয়া :-</u><br>(<?php echo $r['username']; ?>)</p>
                    <p>
                    <?php
                    if ($r['operation'] == "B") {
                        echo "চঃ বিঃ – ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বাটোৱাৰা ও নথি সংশোধন  কৰা হ’ল  ";
                        echo "<br><u class='text-danger'> চঃ বিঃ –  ".$r['co_name']."</u>";
                    }
                    ?>
                </p>
                    <!--                        <p>Reg No (<?php //echo $r['reg_deal_no'];              ?>)</p>
                    <p>Reg Date (<?php //echo date('d-m-Y',strtotime($r['reg_date']));             ?>)</p>-->
                    <hr style='border-bottom: 2px solid #b3b0b0;'>
                <?php } ?>
            <?php endif; ?>
            <?php if ($r['ord_type_code'] == '01'): ?>
                <?php if ($r['premi_chal_recpt'] == '003'): ?>
                    <?php echo "<hr><p class='text-danger'><u>টোকা :</u></p> আবেদনকাৰীয়ে প্রিমিয়াম আদায় নিদিয়া বাবে " . round($r['premium'], 2) . " টকা ৰাজহৰ বকেয়া হিচাবে আদায় লোৱা হওঁক ।" ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    <?php endforeach; ?> 
<?php endforeach; ?>
<?php
    $sro_hukum_no = 1;
    if (isset($chithainf['sro'])) {
        $size_of_sro_order = sizeof($chithainf['sro']);
        echo "<u class='text-danger'>SRO টোকা</u>";
        foreach ($chithainf['sro'] as $key => $sr):
            $newDatesro = date("d-m-Y", strtotime($chithainf['sro'][$key]['date_of_deed']));
            $headingsro = '(SR -' . $chithainf['sro'][$key]['name_of_sro'] . ')';
            ?>
          <p><?php echo  $headingsro.'&nbsp;'.'&nbsp;' . $newDatesro . 'তাৰিখে' . '&nbsp;'.'&nbsp;'.'Deed No.'.'&nbsp;' . $chithainf['sro'][$key]['deed_no'] . 'নং দলিল যোগে' . '&nbsp;'.'&nbsp;' . $chithainf['sro'][$key]['reg_from_name'] .'&nbsp;'. 'পৰা' . '&nbsp;' . $chithainf['sro'][$key]['reg_to_name'] . 'ৰ নামত' . '(B' . $chithainf['sro'][$key]['dag_area_b'] . '- K' . $chithainf['sro'][$key]['dag_area_k'] . '- L' . $chithainf['sro'][$key]['dag_area_lc'] . ')' . 'মাটি' . '&nbsp;' . 'হস্তান্তৰ ' . '&nbsp;' . 'হয়.'               ?></p>
           <p><?php echo $headingsro . '&nbsp;' . '&nbsp;' . 'এই দাগৰ (' . $chithainf['sro'][$key]['dag_no'] . ' নং)  জমীত পটাদাৰ ' . $chithainf['sro'][$key]['reg_from_name'] . ' আৰু ক্ৰেতা / দানলওঁতা ' . $chithainf['sro'][$key]['reg_to_name'] . ' ৰ মাজত ' . '<br>(' . $chithainf['sro'][$key]['dag_area_b'] . 'B - ' . $chithainf['sro'][$key]['dag_area_k'] . 'K - ' . $chithainf['sro'][$key]['dag_area_lc'] . 'L)' . ' মাটিৰ <br> ৰেঃ দলিল <br>( Deed No.) ' . $chithainf['sro'][$key]['deed_no'] . ' নং Deed type: <br>'. $chithainf['sro'][$key]['deed_type'] .'<br>' . $newDatesro . ' তাৰিখে ' . ' পঞ্জীয়ন হয় |' ?></p>

            <?php
            if ($chithainf['sro'][$key]['status'] == '1') {
                echo "<p class='red'><u>Status :</u><br> ( চক্র বিষয়াই নামজাৰীৰ পঞ্জীয়নৰ বাবে আদেশ দিছে | )";
            } elseif ($chithainf['sro'][$key]['status'] == '2') {//
                echo "<p class='red'><u>Status :</u><br> ( সহায়কে পঞ্জীয়ন কৰিলে | )";
            } elseif ($chithainf['sro'][$key]['status'] == '3') {
                echo "<p class='red'><u>Status :</u><br> ( নামজাৰী হৈ গৈছে | )";
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

if (isset($chithainf['lmnote'])) {
    echo "<u class='text-danger'>ভূমিলেখ্য সহায়কৰ টোকা</u>";
    foreach ($chithainf['lmnote'] as $key => $enc):
        ?>
        <p><?php echo $chithainf['lmnote'][$key]['lm_note']."----".$chithainf['lmnote'][$key]['lm_code']; ?></p>
        <hr style='border-bottom: 2px solid #b3b0b0;'>
        <?php
    endforeach;
}
if (isset($chithainf['classRemark']) && !empty($chithainf['classRemark'])) {
    echo "<u class='text-danger'></u>";
    // var_dump($chithainf['classRemark']->land_class_code);
    $oldLandClass= $chithainf['classRemark']->land_class_code ;
    if($chithainf['classRemark']->status=='P'){
        $newLandClass = $chithainf['classRemark']->land_class_code_new;
    }else if ($chithainf['classRemark']->status=='F'){
        $newLandClass = $chithainf['classRemark']->update_land_class_code;
    }
    echo '<p> চৰকাৰ ০৭-০৯-২০২৩ তাৰিখৰ নং ECF.265646/2023/22 ওএমৰ মাধ্যমে উল্লেখ কৰা অনুসৰি উক্ত দাগৰ ভূমিৰ শ্ৰেণী '. $this->utilityclass->getLandClassCode($oldLandClass) . " ৰ পৰা ". $this->utilityclass->getLandClassCode($newLandClass) . ' শ্ৰেণিলৈ নামংকন কৰা হল আৰু ৰেকৰ্ডত ব্যৱহাৰ '. $this->utilityclass->getLandClassCode($oldLandClass) .' হিচাপে গণ্য কৰা হব।</p>';
}
if (isset($chithainf['encro'])) {
    $encro_hukum_no = 1;
    $size_of_encro_order=sizeof($chithainf['encro']);
    echo "<u class='text-danger'>বেদখলকাৰীৰ টোকা</u>";
    foreach ($chithainf['encro'] as $key => $enc):
        $newDate = date("d-m-Y", strtotime($chithainf['encro'][$key]['encro_since']));
        ?>
        <p><?php echo $chithainf['encro'][$key]['encro_name'] . 'য়ে' . '&nbsp;' . '(' . $chithainf['encro'][$key]['encro_land_b'] . '-' . $chithainf['encro'][$key]['encro_land_k'] . '-' . $chithainf['encro'][$key]['encro_land_lc'] . ')' . 'মাটি' . '&nbsp;' . $newDate . 'তাৰিখৰ পৰা' . '&nbsp;' . $chithainf['encro'][$key]['land_used_by_encro'] . 'কাৰণত ব্যৱহাৰ কৰি আছে'; ?></p>
        <?php
    endforeach;
    if ($encro_hukum_no < $size_of_encro_order) {
        echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
    }
    $encro_hukum_no++;
}
foreach ($chithainf['archeo'] as $key => $archeo):
    echo '<u>' . $chithainf['archeo'][$key]['hist_description_nme'] . ': </u><br>'. $chithainf['archeo'][$key]['archeo_decribed'] . '<br>' . '(' . $chithainf['archeo'][$key]['archeo_b'] . '-' . $chithainf['archeo'][$key]['archeo_k'] . '-' . $chithainf['archeo'][$key]['archeo_lc'] . ')' . '';
endforeach;
foreach ($chithainf['backlogs31'] as $backlog) {
    foreach ($backlog as $b) {
        //var_dump($b);
        echo "<p class='text-danger'><u>"."৩১ নং স্তম্ভত পোনপটীয়া প্ৰৱেশ"."</u></p>";
        echo "<p>$b->remark</p>";
         echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
    }
}

foreach ($chithainf['backlog_court_order'] as $court_order) {
    foreach ($court_order as $b) {
        echo "<u>"."১১৮ Court Order"."</u><br>";
        echo "<p>$b->remark</p>";
         echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
    }
}
if(isset($co_note)){
    foreach ($co_note as $note){
        if($chithainf['dag_no'] == $note->dag_no)
        {
            if(empty($note->chitha_remarks)){
                echo "<p> ".$note->co_note. "</p>";
            }else{
                echo "<p> ".$note->chitha_remarks. "</p>";
            }

            echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
        }
    }
}
?>
</td>
<style>
    p{
        line-height:120%;
        fint-size:.8em !important;
    }
</style>
