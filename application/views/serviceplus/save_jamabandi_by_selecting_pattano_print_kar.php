<style>
    .table_black tr td{
        color: #000;
        border: 1px solid #000 !important;
    }
    p{font-size: 1em !important;display: block;padding-bottom: 1em;
      margin-bottom: 10px;}

</style>

<div  id='printPage' class="container-fluid form-top">
    <div class="row">
        <div align="center" style="display:inline-block; width: 100%;" class="col-lg-12">
            <p align ="center">জৰীপ হোৱা গাঁওৰ জমাবন্দী(Jamabandi for Surveyed Village)</p>
            <p>Case Number : <?php echo $this->session->userdata('case_no'); ?>   Printed Dated : <?php echo date('d/m/Y'); ?> </p>
            <table class="table table_black" border='1' style='color:black' align="center" width="100%;" style="margin-bottom: 10px; padding: 2px" >
                <tr>
                    <td align="center"><?php echo "District :" . $namedata[0]->district; ?></td> 
                    <td align="center"><?php echo "Subdivision :" . $namedata[1]->subdiv; ?></td> 
                    <td align="center"><?php echo "Circle :" . $namedata[2]->circle; ?></td> 
                    <td align="center"><?php echo "Mouza :" . $namedata[3]->mouza; ?></td> 
                </tr>
                <tr>
                    <td align="center"><?php echo "Lot Number:" . $namedata[4]->lot_no; ?></td> 
                    <td align="center"><?php echo "Village/Town :" . $namedata[5]->village; ?></td> 
                    <td align="center"><?php echo"Pattatype:" . $namedata[6]->patta_type; ?></td> 
                </tr>
            </table>
            <table class="table table_black" border='1' style='color:black' width="100%" >

                <tr>
                    <td align="center" colspan="2" height="24">  পট্টা নং </td>
                    <td align= "center" width=80 rowspan="2" height="78"> পট্টাদাৰৰ  নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা  </td>
                    <td align="center" colspan="4" height="34">  &nbsp;&nbsp;প্ৰত্যেক দাগৰ মাটিৰ &nbsp;  </td>
                    <td align="center" rowspan="2" height="73">  ৰাজহ<br> </td>
                    <td align="center" rowspan="2" height="73">  স্হানীয় কৰ<br> </td>
                    <td align="center" rowspan="2" height="100">  মন্তব্য </td>

                </tr>
                <tr>
                    <td align="center" height="48"> পুৰণি </td>
                    <td align="center" height="48"> নতুন </td>

                    <td align="center" height="48"> নং</td>
                    <td align="center" height="48"> কালি<br>( বি-কা-ছ-গ ) </td>
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
                    <td align="center"  height="24"> 10 </td>
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
                $bigha_totall = '';
                $katha_totall = '';
                $lesa_totall = '';
                $ganda_total='';
                $ganda_totall='';
                ?>
                <tr>
                    <td><?php foreach ($oldpno as $p): ?> 
                            <p><?php echo $p->old_patta_no; ?> </p>
                        <?php endforeach; ?></td>
                    <td><?php
                        $pp = $this->session->userdata('patta_no');
                        echo $this->utilityclass->cassnum($pp);
                        ?></td>
                    <td>
                        <?php
                        if (!empty($pattadarinf)) {
                            $i = 1;
                            foreach ($pattadarinf as $p):
                                //var_dump($p);
                                $pdarflag = $p->p_flag;
                                $newpdar_name = $p->new_pdar_name;
                                ?>
                                <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php
                                    if ((($p->pdar_land_b) != '0') || (($p->pdar_land_k) != '0') || (($p->pdar_land_lc) != '0') || (($p->pdar_land_g) != '0')) {
                                        $bkl = "(" . $p->pdar_land_b . "B-" . $p->pdar_land_k . "K-" . round($p->pdar_land_lc, 2) . "C-".$p->pdar_land_g."G  ) ";
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

                                    $pdar_serial_no = $p->pdar_sl_no . ") ";

                                    if (($p->pdar_sl_no == '0') || ($p->pdar_sl_no == '') || ($p->pdar_sl_no == null)) {
                                        $pdar_serial_no = $p->pdar_id . ") ";
                                    }

                                    if (($p->pdar_add1 != '') || ($p->pdar_add2 != '') || ($p->pdar_add3 != '') || ($p->pdar_add1 != '0') || ($p->pdar_add2 != '0') || ($p->pdar_add3 != '0')) {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3 . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . "(" . $p->pdar_father . ")" . '<br>' . $p->pdar_add1 . "," . $p->pdar_add2 . "," . $p->pdar_add3 . "<br>" . $bkl;
                                        }
                                    } else {
                                        if ($sort_pdar_by == '1') {
                                            // 1 means sort by serial no
                                            echo $pdar_serial_no . '' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        } else {
                                            echo $i++ . ') ' . $pattadarName . ",(" . $p->pdar_father . ")" . "<br>" . $bkl;
                                        }
                                    }
                                    ?></p>
                                <?php
                            endforeach;
                        }
                        ?>

                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnumfordags($p->dag_no); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td>  
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum($p->dag_area_b) . "-" . $this->utilityclass->cassnum($p->dag_area_k) . "-" . $this->utilityclass->cassnum($p->dag_area_lc, 2)."-".$this->utilityclass->cassnum($p->dag_area_g); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $p->land_type; ?> </p>
                        <?php endforeach; ?>


                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php
                            $bigha_total = (int)$bigha_total + (int)$p->dag_area_b;
                            $katha_total = (int)$katha_total + (int)$p->dag_area_k;
                            $lesa_total = (float)$lesa_total + (float)$p->dag_area_lc;
                            $ganda_total = (float)$ganda_total + (float)$p->dag_area_g;


                            $bigha_totall = (int)$bigha_totall + (int)$p->dag_area_b;
                            $katha_totall = (int)$katha_totall + (int)$p->dag_area_k;
                            $lesa_totall = (float)$lesa_totall + (float)$p->dag_area_lc;
                            $ganda_totall = (float)$ganda_totall + (float)$p->dag_area_g;

                            if ($ganda_total > 20) {
                                $ganda = ($ganda_total / 20);

                                //$whole = floor($hectar);      // 1
                                //$fraction1 = $hectar - $whole; // .25
                                $ganda_whole = floor($ganda);
                                $ganda_fraction = $ganda - $ganda_whole;
                                $ganda_fraction = $ganda_fraction * 20;
                                $lesa_total = $lesa_total + $ganda_whole;

                                // $grand_katha=$katha_total+$to_be_added_to_katha;
                            } else {
                                $ganda_fraction = $ganda_total;
                            }

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
                            if ($katha_total > 15) {
                                $katha = ($katha_total / 16);
                                $katha_whole = floor($katha);
                                $katha_fraction = $katha - $katha_whole;
                                $katha_fraction = $katha_fraction * 16;
                                $bigha_total = $bigha_total + $katha_whole;
                                //$to_be_added_to_bigha=($grand_katha/5);
                                //$grand_bigha=$bigha_total+$to_be_added_to_bigha;
                            } else {
                                $katha_fraction = $katha_total;
                            }

                            $GrandtotalHAC = $this->utilityclass->get_Hec_Are_CAre2($bigha_total, $katha_fraction, $lesa_fraction,$ganda_fraction);
                            ?>
                            <?php
                            $H_A_C = $this->utilityclass->get_Hec_Are_CAre2($p->dag_area_b, $p->dag_area_k, $p->dag_area_lc,$p->dag_area_g);
                            echo $this->utilityclass->cassnum($H_A_C) . '<br>';
                            ?>
                        <?php endforeach; ?>



                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php $revenueTotal = (float)$revenueTotal + (float)$p->dag_revenue; ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum(number_format($p->dag_revenue, 2)); ?> </p>
                        <?php endforeach; ?>

                    </td>
                    <td>
                        <?php foreach ($daginfo as $p): ?>
                            <?php $localtaxTotal = (float)$localtaxTotal + (float)$p->dag_localtax; ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo $this->utilityclass->cassnum(number_format($p->dag_localtax, 2)); ?> </p>
                        <?php endforeach; ?>
                    </td>
                    <td style='margin-bottom:10px;'>
                        <?php foreach ($remarkinf as $p): ?>
                            <p style='display: block;padding-bottom: 1em;
      margin-bottom: 10px;'><?php echo strip_tags($p->remark); ?> </p>

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
                        $total_ganda = $this->utilityclass->Total_ganda($bigha_totall, $katha_totall, $lesa_totall,$ganda_totall);
                        $tbkl = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_ganda);
                        //var_dump($tbkl);
                        echo $this->utilityclass->cassnum($tbkl[0]) . "-" . $this->utilityclass->cassnum($tbkl[1]) . "-" . $this->utilityclass->cassnum($tbkl[2]. "-". $tbkl[3]);

                        //echo $this->utilityclass->cassnum(number_format($bigha_total)) . '-' . $this->utilityclass->cassnum(number_format($katha_fraction)) . '-' . $this->utilityclass->cassnum(number_format($lesa_fraction,2));
                        $Grandbigha_total = (int)$Grandbigha_total + (int)$bigha_total;
                        $Grandkatha_total = (int)$Grandkatha_total + (int)$katha_fraction;
                        $Grandlesa_total = (float)$Grandlesa_total + (float)$lesa_fraction;

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

                        $GrandtotalHAC1 = $this->utilityclass->get_Hec_Are_CAre2($bigha_totall, $katha_totall, $lesa_totall,$ganda_totall);
                        ?>



                    </td>
                    <td>

                    </td>
                    <td>
                        <?php echo $this->utilityclass->cassnum($GrandtotalHAC1) ?>
                    </td>
                    <td>
                        <?php
                        echo $this->utilityclass->cassnum($revenueTotal);
                        $GrandrevenueTotal = (float)$GrandrevenueTotal + (float)$revenueTotal;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->utilityclass->cassnum($localtaxTotal);
                        $GrandlocaltaxTotal = (float)$GrandlocaltaxTotal + (float)$localtaxTotal;
                        ?>
                    </td>
                    <td>

                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div class="col-lg-9 col-md-10 col-sm-12">
        <p class='red uni_text center'>** Please note this is a system generated certificate and does not need any signature **</p>
        <div class="row">
            <?php
            $data = explode(",", $qrcode)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?>
            <?php
            $data = explode(",", $qrBasic)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?><?php
            $data = explode(",", $qrCONAME)[1];
            echo '<img class="col-lg-2" src="data:image/png;base64,' . $data . '" />';
            ?>
            <p class="uni_text pull-right"> কতৃত্বপ্রাপ্ত বিষয়া   :  <?php echo $username->username; ?> <br>
                Designation :   চক্ৰ বিষয়া<br>
                Generated Date :  <?php echo date('d/m/Y'); ?>
            </p>

        </div>

    </div>
    <div class="col-lg-3 col-sm-12">

    </div>


</div>


<div class='' >
    <div class="form-group" style="text-align: center">
        <div class="col-sm-10" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">                     
            <br>
           <?php
           
            if(!empty($application_ref_no)){?>

            <button class='btn btn-success' id="print"><i class='fa fa-file'></i> Click to Generate Jamabandi for Digital Signature</button>
           <?php }?>
            <a href="<?php echo base_url(); ?>index.php/serviceplus/PrintForAsts?cert_no=<?php echo $this->session->userdata('case_no'); ?>&certtype=01" class="btn btn-info"  onclick="myFunction5644()"><i class='fa fa-print'></i> Send to Ast. for Print & Manual Signature</a>   
        </div>
    </div>
</div>

 <form action="<?php echo base_url(); ?>index.php/serviceplus/mpdf" id="pdf_certificate" enctype='multipart/form-data'  style="display:none" method="post">                    
        <textarea id="htmlstring_text" name="htmlstring_text"></textarea>
</form>

<script src="<?php echo base_url(); ?>application/views/resources/js/jspdf.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/jquery-2.1.3.js"></script>

<script src="<?php echo base_url(); ?>application/views/js/jquery.base64.min.js"></script>
<script>
            $( "#print" ).click(function() {                
                var htmlString =$( "#printPage" ).html();
                //htmlString = $.base64.encode(htmlString);
                var htmlString = b64EncodeUnicode(htmlString);
                //console.log(htmlString);
                //alert(htmlString);
                 $( "#print_html" ).text( htmlString );
                 $( "#htmlstring" ).val( htmlString );
                 $( "#htmlstring_text" ).text( htmlString );
                 $("#pdf_certificate").submit();
                //alert(htmlString);
              });
              function b64EncodeUnicode(str) {    
                return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                    function toSolidBytes(match, p1) {
                        return String.fromCharCode('0x' + p1);
                }));
}

function myFunction564() {
    window.print();
    $( ".dontshow" ).hide();
}

    // function windowClose() {
        // window.open('', '_parent', '');
        // window.close();
    // }

    document.onkeydown = function () {
        var x = event.keyCode;
        if (((x == 70) || (x == 78) || (x == 79) || (x == 80)) && (event.ctrlKey) || (x > 111 && x < 124)) {
            //alert ("No new window")
            event.cancelBubble = true;
            event.returnValue = false;
            event.keyCode = false;
            return false;
        }
    }
</script>