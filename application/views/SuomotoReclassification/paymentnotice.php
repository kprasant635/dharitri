<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        //border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
        
    }
    .unicode{
        font-size: 5px !important;
    }
</style>
<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-12 panel-body ">
            <h2 class="bold" style="text-align: center;margin-top: 20px;">PAYMENT NOTICE FOR SUOMOTO RECLASSIFICATION</h2>
            <h2 class="bold"  style="text-align: center">Case no- <?php echo $case_no; ?> date:<?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?></h2>

          <?php
          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
            <div style="line-height: 30px;margin-top: 30px;margin-bottom: 30px;">
                <p class='uni_text' style="font-size:1em;">যেহেতু <?php
                    echo $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code) . " ";
                    echo $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code) . " ";
                    ?>গ্রামের <?php echo $this->utilityclass->cassnum($details->patta_no); ?> নং খেরাজ ম্যাদী পাট্টার <?php echo $this->utilityclass->cassnum($details->dag_no); ?> 
                    নং দাগের অংশে <?php echo $this->utilityclass->cassnum($details->m_dag_area_b); ?> বিঘা <?php echo $this->utilityclass->cassnum($details->m_dag_area_k); ?> কাঠা <?php echo $this->utilityclass->cassnum($details->m_dag_area_lc); ?>
                    ছটাক <?php echo   $this->utilityclass->cassnum(number_format($details->m_dag_area_g, 2));?> গণ্ডা  ভূমিতে নামজারী করার জন্য 
                    দরখাস্তকারীর দাখিল করা দরখাস্তমতে একটি নামজারী কেস নং এই আদালতে রেজিস্টারভূক্ত করা হইয়াছে ৷ 
                    এতদ্বারা সর্ব্বসাধারণকে জানানো যাইতেছে যে , উক্ত নামজারী কেস সম্বন্ধে যদি কেহ বা কাহারো কোন আপওি থাকে
                    তাহা হইলে নিজে অথবা উকিল দ্বারা ইং <?php echo $this->utilityclass->cassnum(date('d-m-y', strtotime($details->next_date_of_hearing))); ?> সকাল 10 ঘটিকার সময় এই আদালতে হাজির হইয়া উপযুক্ত কারণ দর্শাইবেন৷ অন্যথায়, একতরফাভাবে উক্ত কেস এর বিচার ও নিষ্পত্তি করা হইবে ৷
                <p class='uni_text'>আজি ইং <?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?>  তারিখে আমার সই এবং আদালতের সিল মারিয়া দেওয়া হইল ৷</p></p>
            </div>
            <?php }else{?>
            <div style="line-height: 30px;margin-top: 30px;margin-bottom: 30px;">
                
            </div>
        <?php }?>
            <table class="table table-bordered table_black" style="font-size:1em;">
            <?php
              $dist_code = $this->session->userdata('dist_code');
              if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                <tr>
                    <td>মৌজা / গ্রাম </td>
                    <td>স্বত্বাধিকাৰী / গন</td>
                    <td>আবেদনকারী</td>
                    <td>বিবরণ</td>
                    <td>বিবরণ</td>
                </tr>
            <?php }else{?>
                <tr>
                    <td>মৌজা / গাঁও</td>
                    <td>স্বত্বাধিকাৰী / গৰাকী</td>
                    <td>আবেদনকাৰী</td>
                    <td>বিৱৰণ</td>
                    <td>বিৱৰণ</td>
                </tr>
            <?php }?>
                <tr>
                    <td>
                        <?php
                        echo
                        $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code) . ",<br>";
                        echo $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
                        ?>
                    </td>
                    <td>
                        <?php foreach ($notifyname as $p): ?>
                            <?php echo $p->notified_name . "<br>"; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($applicants as $p): ?>
                            <?php echo $p->pdar_name . "<br>"; echo "<i class='fa fa-phone'></i> " ?>
                        <?php endforeach; ?>
                    </td>
                  <?php
                  $dist_code = $this->session->userdata('dist_code');
                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                    <td>
                        <?php
                        echo "পাট্টার  নং:" . $this->utilityclass->cassnum($details->patta_no) . "," . "<br>";
                        echo "দাগের নং :" . $this->utilityclass->cassnum($details->dag_no) . "," . "<br>";
                        echo "মাটির কালি: " . $this->utilityclass->cassnum($details->m_dag_area_b) . " বি: " . $this->utilityclass->cassnum($details->m_dag_area_k) . " ক: " .
                        $this->utilityclass->cassnum($details->m_dag_area_lc, 2) . " ছ ". $this->utilityclass->cassnum(number_format($details->m_dag_area_g,2))."গ";
                        ?>
                    </td>
                <?php }else{?>
                    <td>
                        <?php
                        echo "পাট্টা  নং:" . $this->utilityclass->cassnum($details->patta_no) . "," . "<br>";
                        echo "দাগ  নং :" . $this->utilityclass->cassnum($details->dag_no) . "," . "<br>";
                        echo "মাটিৰ কালি : " . $this->utilityclass->cassnum($details->dag_area_b) . " বি: " . $this->utilityclass->cassnum($details->dag_area_k) . " ক: " .
                        $this->utilityclass->cassnum(number_format($details->dag_area_lc, 2)) . " লে: ";
                        ?>
                    </td>
                <?php }?>
                    <td>
                        <?php echo $details->payment_amount;?>
                        
                    </td>
                </tr>
            </table>
            <?php
              $dist_code = $this->session->userdata('dist_code');
              if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
            <p class='uni_text'> বিজ্ঞপ্তি গ্রহণ করা ব্যক্তি/সর্বসাধারণ : 
             <?php }else{?>
            <p class='uni_text' style="font-size:1em;">জাননী পাবলগীয়া গৰাকী /সৰ্বসাধাৰণ : 
                 <?php }?>

                <?php
                foreach ($notifyname as $np) {
                    if(!empty($np->notified_name)){
                        echo $np->notified_id . ")" . $np->notified_name . "&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                }
                ?>
            </p>
            <hr>
            <p class='pull-right uni_text' style="font-size:1em;">
                <?php
                $user_code=$this->session->userdata('user_code');
                $coname = $this->utilityclass->getDefinedBOName($details->dist_code, $user_code);
                echo $coname->username;
                ?> <br> 
                শাখা বিষয়া ,<?php
                
                ?>
            </p>
            <hr>
            <?php
            $link = base_url() . "index.php/SuomotoReclassification/paymentNotice";
            ?>
            <form method="post" action="<?php echo $link; ?>">
                <div class="form-group no-print" style="text-align: center;">
                    <button type="submit" class="btn btn-primary" onclick="return myFunction()"><i class="fa fa-print"></i>&nbsp;Print Notice and Proceed</button>
                    <a href="<?php echo base_url(); ?>index.php/officemutation/getPendingNoticeGeneration" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                    </a>
                </div>
                
                <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/>  
                <input type="hidden" name="mouza_pargona_code" value="<?php echo $details->mouza_pargona_code; ?>"/>
                <input type="hidden" name="lot_no" value="<?php echo $details->lot_no; ?>"/>
                <input type="hidden" name="vill_townprt_code" value="<?php echo $details->vill_townprt_code; ?>"/>
            </form>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();
		
        window.print();
        $(".dontshow").show();
        document.getElementById("mainMenu").disabled = false;
    }
</script>