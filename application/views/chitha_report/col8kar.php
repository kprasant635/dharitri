<td valign="top" id="chitha_col_8" rowspan="3" width="15%" ><!--DAKHALDAR-->              
    <?php
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
			$mut_land_area_g = $clmn8['mut_land_area_g'];  // for bengali version
			if($order_type_code!=='03'){
            ?>
            <p>চক্ৰ আধিকারিকের <br> <?php echo $this->utilityclass->cassnum($formatDate); ?> তারিখের  
                <?php
                $bigha = 0;
                $katha = 0;
                $lesa = 0;
                $ganda= 0;
                if ($order_type_code == "01") {

                    if ($mut_land_area_b != '0') {
                        $bigha = $this->utilityclass->cassnum($mut_land_area_b) . 'বিঘা ';
                    } else {
                        $bigha = "";
                    }

                    if ($mut_land_area_k != '0') {
                        $katha = $this->utilityclass->cassnum($mut_land_area_k) . 'কাঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $this->utilityclass->cassnum($mut_land_area_lc) . 'ছটাক ';
                     } else {
                        $lesa = "";
                     }
					 if ($mut_land_area_g != '0') {
                          $ganda = $this->utilityclass->cassnum($mut_land_area_g) . 'গণ্ডা ';
                     } else {
					 	$ganda = "";
					}
				} else if ($order_type_code == "02") {

                    if ($mut_land_area_b != '0') {
                        $bigha = $this->utilityclass->cassnum($mut_land_area_b) . 'বিঘা ';
                    } else {
                        $bigha = "";
                    }

                    if ($mut_land_area_k != '0') {
                        $katha = $this->utilityclass->cassnum($mut_land_area_k) . 'কাঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $this->utilityclass->cassnum($mut_land_area_lc) . 'ছটাক';
                    } else {
                        $lesa = "";
                    }
					 if ($mut_land_area_g != '0') {
                        $ganda = $this->utilityclass->cassnum($mut_land_area_g) . 'গণ্ডা ';
                    } else {
                        $ganda = "";
                    }
					
                }
                //echo $order_type . ' নং ' . $case_no . '-ৰ ' . ' হুকুমমৰ্মে এই দাগৰ ' . $bigha . $katha . $lesa . ' মাটি ';
				echo $order_type . ' নং ' . $case_no . '-এর  ' . ' হুকুমমৰ্মে এই দাগের  ' . $bigha . $katha . $lesa. $ganda . ' মাটি ';
                //var_dump($clmn8['inplace']);

                if ($order_type_code != "02" and $clmn8['nature_trans_code'] != null) {
                    //echo $clmn8['nature_trans_code'];
                    echo " " . $this->utilityclass->getTransferType($clmn8['nature_trans_code']) . " ";
                }
                $count = 1;
                $howmanys = sizeof($clmn8['inplace']) - 1;
                foreach ($clmn8['inplace'] as $in) {
                    if(MULTIGENERATION_ACTIVE ==1 && $clmn8['occup'][0]['multigenFlagVal'] =='M')
                    {
                        
                    }
                    else
                    {
                        echo $in['inplace_of_name'] ."'এর";
                    }
                    if ($count < sizeof($clmn8['inplace']) - 1) {
                        switch ($in['inplaceof_alongwith']) {
                            case 'i':
                                echo " স্থলে ";
                                break;
                            case 'a':
                                echo " সামিলে ";
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
                                echo " সামিলে ";
                                break;
                        }
                        echo " এবং ";
                        $count++;
                    } else {
                        switch ($in['inplaceof_alongwith']) {
                            case 'i':
                                echo " স্থলে ";
                                break;
                            case 'a':
                                echo " সামিলে ";
                                break;
                        }
                        echo " ";
                    }
                }


                $count = 1;
                $howmany = sizeof($clmn8['occup']) - 1;
                foreach ($clmn8['occup'] as $in) {

                    if(MULTIGENERATION_ACTIVE ==1 && $in['multigenFlagVal'] =='M')
                    {
                        if($in['occp_generation'] == "GP"){

                        echo $in['occupant_fmh_name'] . "'ৰ"; echo " স্থলে ";
                        }
                        if($in['occp_generation'] == "P"){
                            echo $in['occupant_fmh_name'] . "'ৰ"; echo " স্থলে ";
                        }
                        if($in['occp_generation'] == "A"){
                            echo $in['occupant_fmh_name'] . "'ৰ"; echo " স্থলে ";
                        }
                    }


                    $r = "";
                    switch ($in['occupant_fmh_flag']) {
                        case 'm':
                            $r = "মাতা";
                            break;
                        case 'f':
                            $r = "পিং";
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

                    //code changed for multigeneration--------
                    if(MULTIGENERATION_ACTIVE ==1  && $in['occp_generation'] != null)
                    {
                        $searchForValue = ',';
                        $stringValue = $in['occupant_name'];
                        if( strpos($stringValue, $searchForValue) !== false ) {
                            $stringValue = str_replace(","," আৰু ",$stringValue);
                        }
                        echo $stringValue . " ($r " . $in['occupant_fmh_name'] . ")";
                        //end--------04052023
                    }
                    else
                    {
                        echo $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                    }


                    // echo $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                    if ($count < sizeof($clmn8['occup']) - 1) {
                        echo " , ";
                        $count++;
                    } elseif ($count == sizeof($clmn8['occup']) - 1) {
                        echo " এবং ";
                        $count++;
                    } else {
                        echo " ";
                    }
                }
                if ($clmn8['order_type_code'] == '01') {
                    echo " এর নামে নামজারী করা হইল| ";
                } else if ($clmn8['order_type_code'] == '02') {
                    echo " নামে " . $clmn8['occup'][0]['new_dag_no'] . " নং দাগ " .
                    $clmn8['occup'][0]['new_patta_no'] . " ম্যাদী পাট্টা করা হইল | ";
                }

                if (($clmn8['rajah'] != 0) || ($clmn8['rajah'] == 'y')) {
                    echo "<p style='color:blue'>( রাজস্ব আদলত )</p>";
                }
                ?>   
                <?php
                if (($clmn8['deed_reg_no'] != "")) {
                    if($clmn8['nature_trans_code']=='08'){
                        $lebel_one="উইল / প্ৰবেট নং : ";
                        $label_two="উইল / প্ৰবেট তাৰিখ : ";
                    } else {
                        $lebel_one="Deed No : ";
                        $lebel_two="Deed Date : ";
                    }
                    echo "<p class='text-danger'>Registration</p>";
                    echo $lebel_one . $clmn8['deed_reg_no'] . "<br>";
                    if($clmn8['nature_trans_code']!='08'){
                        echo "Deed Value:" . $this->utilityclass->cassnum(number_format($clmn8['deed_value'], 2)) . "<br>";
                    }
                    $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));
                    if ($interval->days > 0) {
                        echo $lebel_two . $this->utilityclass->cassnum(date('d-m-Y', strtotime($clmn8['deed_date']))) . " ";
                    }
                }
                ?>
            <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $clmn8['lm_name']; ?>)</p>
        <p><u class='text-danger'>চক্ৰ আধিকারিক  :</u><br>(<?php echo $clmn8['username']; ?>)</p>

        <?php
        if ($hukum_no < $size_of_order) {
            echo "<hr style='border-bottom: 2px solid #b3b0b0;'>";
        }
		}
        $hukum_no++;
        ?>
        <?php
    endforeach;
}

//var_dump($objection['']);
//var_dump($chithainf['objection']);
if (isset($chithainf['objection'])) {
    foreach ($chithainf['objection'] as $objection) {
        //var_dump($objection);
        $mut_type = $objection['mut_type'];
        $objection_case_no = $objection['objection_case_no'];
        $prev_fm_ca_no = $objection['prev_fm_ca_no'];
        $submission_date = $objection['submission_date'];
        $obj_name = $objection['obj_name'];
        $co_id = $objection['co_id'];
        $regist_date = $objection['regist_date'];
		$occupant=$objection['occupant'];
    }
    $coname = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $co_id);
    //var_dump($coname);
    //echo $coname->username;
    $mut_name = $this->utilityclass->getMutationTypeObject($mut_type);
    //var_dump($mut_name);
   // echo "<hr>";
    echo "চক্ৰ আধিকারিকের ". date('d-m-y', strtotime($regist_date)) . " তারিখের  বিবিধ মামলা নং ". $objection_case_no  ." হুকুমমৰ্মে  ". $obj_name ." য়ে দিয়া চিঠি  অভিযোগ সাপেক্ষে ". $prev_fm_ca_no . " নং ". date('d-m-y', strtotime($submission_date)) ." তারিখের হুকুম নাকচ কৰা হয় আৰু ";
    echo $occupant ." নাম  কৰ্তন কৰা  হয়  | ";
	//echo $obj_name ." ৰ নাম পুনৰ বাহাল ৰখা হয় | ";
    // echo " ৰ নামত " . date('d-m-y', strtotime($regist_date)) . " তাৰিখে দিয়া চিঠি " . $mut_name->order_type . "  হুকুম " . $objection_case_no . " নং অভিযোগ সাপেক্ষে আজিৰ তাৰিখত (" . date('d-m-y', strtotime($submission_date)) . ") জাৰী কৰা হ’ল  |
	// ";
    echo "<br><u class='text-danger'>স্বা (চক্ৰ আধিকারিক)</u><br>";
    echo $coname->username;
}

//echo "backlog orders";
foreach ($chithainf['backlogs'] as $backlog) {
    foreach ($backlog as $b) {
        echo "<p>$b->remark</p>";
    }
}
?>

</td>

