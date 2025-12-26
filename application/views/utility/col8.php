<td valign="top" id="chitha_col_8" rowspan="3" width="15%" ><!--DAKHALDAR-->


    <?php
    if (isset($chithainf['col8'])) {
        foreach ($chithainf['col8'] as $clmn8):
            //echo "<hr>";
            //var_dump($clmn8);
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
            ?>
            <div class="hilight_box">
            <p>চক্ৰ বিষয়াৰ  <br> <?php echo $formatDate; ?> তাৰিখৰ 
                <?php
                $bigha = 0;
                $katha = 0;
                $lesa = 0;
                if ($order_type_code == "01") {

                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . 'বিঘা ';
                    } else {
                        $bigha = "";
                    }

                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . 'কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . 'লেছা ';
                    } else {
                        $lesa = "";
                    }
                } else if ($order_type_code == "02") {

                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . 'বিঘা ';
                    } else {
                        $bigha = "";
                    }

                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . 'কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . 'লেছা ';
                    } else {
                        $lesa = "";
                    }
                }
                echo $order_type . ' নং ' . $case_no . '-ৰ ' . ' হুকুমমৰ্মে এই দাগৰ ' . $bigha . $katha . $lesa . ' মাটি ';
                //var_dump($clmn8['inplace']);

                if ($order_type_code != "02") {
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
                    echo "<p class='text-danger'>Registration</p>";
                    echo "Deed No:" . $clmn8['deed_reg_no'] . "<br>";
                    echo "Deed Value:" . $clmn8['deed_value'] . "<br>";
                    $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));
                    if ($interval->days > 0) {
                        echo "Deed Date:" . date('d-m-y', strtotime($clmn8['deed_date'])) . ") ";
                    }
                }
                ?>
            <p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u><br>(<?php echo $clmn8['lm_name']; ?>)</p>
        <p><u class='text-danger'>চক্ৰ বিষয়া :</u><br>(<?php echo $clmn8['username']; ?>)</p>
        <a href="<?php echo base_url(); ?>index.php/utility/DeleteCol8Order?orderno=<?php echo $col8order_cron_no; ?>" onClick="return confirmDelete();" class="btn btn-sm btn-danger btn-block"><font size=2><b>Click to Delete Order</b></font></a>
        </div>
        <?php
    endforeach;
    }
    //  var_dump($objection['']);
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
        }
        $coname = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $co_id);
        //var_dump($coname);
        echo $coname->username;
        $mut_name = $this->utilityclass->getMutationTypeObject($mut_type);
        //var_dump($mut_name);
        echo "<hr>";
        echo $obj_name;
        echo " ৰ নামত " . date('d-m-y', strtotime($regist_date)) . " তাৰিখে দিয়া চিঠি " . $mut_name->order_type . "  হুকুম " . $objection_case_no . " নং অভিযোগ সাপেক্ষে আজিৰ তাৰিখত (" . date('d-m-y', strtotime($submission_date)) . ") জাৰী কৰা হ’ল  |
    ";
        echo "<br><u class='text-danger'>স্বা (চক্ৰ বিষয়া )</u><br>";
        echo $coname->username;
    }
?>

</td>
