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
        <div class="col-lg-12 panel-body">
            <h2 class="bold" style="text-align: center;margin-top: 20px;">NOTICE UNDER SECTION 52 of the LAND AND REVENUE REGULATION</h2>
            <h2 class="bold"  style="text-align: center">Case no- <?php echo $case_no; ?> date:<?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?></h2>
            <?php
                if($this->session->flashdata('message1')){
            ?>
                    <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('message1'); ?>
                            </strong>
                        </div>
                    </div>
            <?php
                }
            ?>
            <?php
                if($this->session->flashdata('success1')){
            ?>
                    <div class="error_container">
                        <div class="alert alert-success alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('success1'); ?>
                            </strong>
                        </div>
                    </div>
            <?php
                }
            ?>
            <?php
                $dist_code = $this->session->userdata('dist_code');
                $case_dist_code = $details[0]->dist_code;
                $case_subdiv_code = $details[0]->subdiv_code;
                $case_cir_code = $details[0]->cir_code;
                $case_mouza_pargona_code = $details[0]->mouza_pargona_code;
                $case_lot_no = $details[0]->lot_no;
                $case_vill_townprt_code = $details[0]->vill_townprt_code;
                $case_patta_no = $details[0]->patta_no;
                $case_add_off_name = $details[0]->add_off_name;
                
                $next_hearing_dt = $details[0]->next_date_of_hearing;
                $dag_no_in_notice = $area_detail_in_notice = '';
                foreach($details as $key => $detail){
                    $string_separator = '';
                    if((count($details) - 1) != $key){
                        $string_separator = ', ';
                    }
                    $dag_no_in_notice .= $this->utilityclass->cassnum($detail->dag_no) . $string_separator;
                    $area_detail_in_notice .= $this->utilityclass->cassnum($detail->m_dag_area_b) . ' বিঘা ' . 
                                                $this->utilityclass->cassnum($detail->m_dag_area_k) . ' কাঠা ';
    
                    if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                        $area_detail_in_notice .= $this->utilityclass->cassnum($detail->m_dag_area_lc) . ' ছটাক ' . 
                                                    $this->utilityclass->cassnum(number_format($detail->m_dag_area_g, 2)) . ' গণ্ডা ';
                    }else{
                        $area_detail_in_notice .= $this->utilityclass->cassnum(number_format($detail->m_dag_area_lc, 2)) . ' লেছা ';
                    }
    
                    $area_detail_in_notice .= $string_separator;
                }
            ?>

            <div style="line-height: 30px;margin-top: 30px;margin-bottom: 30px;">
                <p class='uni_text' style="font-size:1em;">যেহেতু <?php
                    echo $this->utilityclass->getMouzaName($case_dist_code, $case_subdiv_code, $case_cir_code, $case_mouza_pargona_code) . " ";
                    echo $this->utilityclass->getVillageName($case_dist_code, $case_subdiv_code, $case_cir_code, $case_mouza_pargona_code, $case_lot_no, $case_vill_townprt_code) . " ";
                    ?>গ্রামের <?php echo $this->utilityclass->cassnum($case_patta_no); ?> নং খেরাজ ম্যাদী পাট্টার <?= $dag_no_in_notice; ?> 
                    নং দাগের অংশে <?= $area_detail_in_notice; ?> ক্ৰমে ভূমিতে নামজারী করার জন্য 
                    দরখাস্তকারীর দাখিল করা দরখাস্তমতে একটি নামজারী কেস নং এই আদালতে রেজিস্টারভূক্ত করা হইয়াছে ৷ 
                    এতদ্বারা সর্ব্বসাধারণকে জানানো যাইতেছে যে , উক্ত নামজারী কেস সম্বন্ধে যদি কেহ বা কাহারো কোন আপওি থাকে
                    তাহা হইলে নিজে অথবা উকিল দ্বারা ইং <?php echo $this->utilityclass->cassnum(date('d-m-y', strtotime($next_hearing_dt))); ?> সকাল 10 ঘটিকার সময় এই আদালতে হাজির হইয়া উপযুক্ত কারণ দর্শাইবেন৷ অন্যথায়, একতরফাভাবে উক্ত কেস এর বিচার ও নিষ্পত্তি করা হইবে ৷
                    <p class='uni_text'>আজি ইং <?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?>  তারিখে আমার সই এবং আদালতের সিল মারিয়া দেওয়া হইল ৷</p>
                </p>
                <!-- <p class='uni_text' style="font-size:1.4em;">যেহেতু <?php
                    echo $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code) . " ";
                    echo $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code) . " ";
                    ?>গ্রামের <?php echo $this->utilityclass->cassnum($details->patta_no); ?> নং খেরাজ ম্যাদী পাট্টার <?php echo $this->utilityclass->cassnum($details->dag_no); ?> 
                    নং দাগের অংশে <?php echo $this->utilityclass->cassnum($details->m_dag_area_b); ?> বিঘা <?php echo $this->utilityclass->cassnum($details->m_dag_area_k); ?> কাঠা <?php echo $this->utilityclass->cassnum($details->m_dag_area_lc); ?>
                    ছটাক <?php echo   $this->utilityclass->cassnum(number_format($details->m_dag_area_g, 2));?> গণ্ডা  ভূমিতে নামজারী করার জন্য 
                    দরখাস্তকারীর দাখিল করা দরখাস্তমতে একটি নামজারী কেস নং এই আদালতে রেজিস্টারভূক্ত করা হইয়াছে ৷ 
                    এতদ্বারা সর্ব্বসাধারণকে জানানো যাইতেছে যে , উক্ত নামজারী কেস সম্বন্ধে যদি কেহ বা কাহারো কোন আপওি থাকে
                    তাহা হইলে নিজে অথবা উকিল দ্বারা ইং <?php echo $this->utilityclass->cassnum(date('d-m-y', strtotime($details->next_date_of_hearing))); ?> সকাল 10 ঘটিকার সময় এই আদালতে হাজির হইয়া উপযুক্ত কারণ দর্শাইবেন৷ অন্যথায়, একতরফাভাবে উক্ত কেস এর বিচার ও নিষ্পত্তি করা হইবে ৷
                <p class='uni_text'>আজি ইং <?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?>  তারিখে আমার সই এবং আদালতের সিল মারিয়া দেওয়া হইল ৷</p></p> -->
            </div>

            <table class="table table-bordered table_black">
                <tr>
                    <td>মৌজা / গ্রাম </td>
                    <td>স্বত্বাধিকাৰী / গন</td>
                    <td>আবেদনকারী</td>
                    <td>বিবরণ</td>
                    <td>বাকী বিবরণ</td>
                </tr>

                <?php
                    foreach($details as $detail):
                ?>
                        <tr>
                            <td>
                                <?php
                                echo
                                $this->utilityclass->getMouzaName($detail->dist_code, $detail->subdiv_code, $detail->cir_code, $detail->mouza_pargona_code) . ",<br>";
                                echo $this->utilityclass->getVillageName($detail->dist_code, $detail->subdiv_code, $detail->cir_code, $detail->mouza_pargona_code, $detail->lot_no, $detail->vill_townprt_code);
                                ?>
                            </td>
                            <td>
                                <?php foreach ($detail->pattadars as $p): ?>
                                    <?php echo $p->pdar_name . "<br>"; ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($detail->applicants as $p): ?>
                                    <?php echo $p->pet_name . "<br>"; ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php
                                echo "পাট্টার  নং:" . $this->utilityclass->cassnum($detail->patta_no) . "," . "<br>";
                                echo "দাগের নং :" . $this->utilityclass->cassnum($detail->dag_no) . "," . "<br>";
                                echo "মাটির কালি: " . $this->utilityclass->cassnum($detail->m_dag_area_b) . " বি: " . $this->utilityclass->cassnum($detail->m_dag_area_k) . " ক: " .
                                $this->utilityclass->cassnum($detail->m_dag_area_lc, 2) . " ছ ". $this->utilityclass->cassnum(number_format($detail->m_dag_area_g,2))."গ";
                                ?>
                            </td>
                            <td></td>
                        </tr>
                <?php
                    endforeach;
                ?>
            </table>
            <p class='uni_text'> বিজ্ঞপ্তি গ্রহণ করা ব্যক্তি/সর্বসাধারণ : 
                <?php
                foreach ($notifyname as $np) {
                    if(!empty($np->notified_name)){
                        echo $np->notified_id . ")" . $np->notified_name . "&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                }
                ?>
            </p>
            <hr>
            <p class='pull-right uni_text'>
                <?php
                // $coname = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->add_off_name);
                $coname = $this->utilityclass->getSelectedCOName($case_dist_code, $case_subdiv_code, $case_cir_code, $case_add_off_name);
                echo $coname->username;
                ?> <br> 
                চক্র আধিকারিক ,<?php
                // echo $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
                echo $this->utilityclass->getCircleName($case_dist_code, $case_subdiv_code, $case_cir_code);;
                ?>
            </p>
            <hr>
            <?php
            $link = base_url() . "index.php/officemutation/issueNotice";
            ?>
            <form method="post" action="<?php echo $link; ?>">
                <div class="form-group no-print" style="text-align: center;">
                    <button type="submit" class="btn btn-primary" onclick="return myFunction()"><i class="fa fa-print"></i>&nbsp;Print Notice and Proceed</button>
                    <a href="<?php echo base_url(); ?>index.php/officemutation/getPendingNoticeGeneration" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                    </a>
                </div>
                
                <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/>  
                <input type="hidden" name="mouza_pargona_code" value="<?php echo $case_mouza_pargona_code; ?>"/>
                <input type="hidden" name="lot_no" value="<?php echo $case_lot_no; ?>"/>
                <input type="hidden" name="vill_townprt_code" value="<?php echo $case_vill_townprt_code; ?>"/>
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