<div class="container-fluid form-top login">
    <div class="row">
        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Conversion Order</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "2"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="" method='post' action="<?php echo base_url() . "index.php/COconversionPartha/Regenerate"; ?>">

                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                    include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>

                            <table class='table table-striped table-bordered unicode rasid-t' style="font-size: 20px;">
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                                        <?php
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        //var_dump($lm_details_final);
                                        foreach ($lm_details_final as $lm):
                                            $p=round($lm->prim_per_bigha, 2);
                                            $pt=round($lm->prim_tot, 2);
                                            //$perRs=($lm->premium_assesment=='40'?' Rs./- ': ' % ');
                                            if($lm->premium_new_yn == 0 || $lm->premium_new_yn == null) {
                                                $prem_percent=$lm->premium_assesment.((trim($lm->premium_assesment)=='40') || (trim($lm->premium_assesment)=='20')? ' টকা ': ' % ');
                                            }
                                            else if($lm->premium_new_yn == 1) {

                                                $prem_percent = $lm_details['effective_premium_amount'] . (($lm_details['is_percent'] == 1) ? ' % ' : ' টকা ');
                                            }
                                        endforeach;
                                        if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                        {
                                            $msg="";
                                        }
                                        else{
                                            $msg="আৰু ২৫% ৰেহাই পাচত";
                                        }
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                            {
                                                if ($presence == '') {
                                                    ?>
                                                    লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |<br><br>
                                                    লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                    সেয়েহে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                    <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>
                                                    
                                                    <input type="hidden" name="Co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |<br><br>
                                                    লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                    সেয়েহে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> টকা হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                    <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
                                                    <?php
                                                } else {
                                                    ?>
    
                                                    <?php if ($land_details["patta_type"]=='0208') { ?>
                                                    
                                                        <!-- <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span> -->
                                                    <textarea cols='20' rows='10' name="Co_notice" class="form-control">সহায়কে দাখিল কৰা <?php echo $location['case_no']; ?> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷
                                                    
                                                    <?php echo $location['add_to']; ?>
                                                    
                                                    চক্র বিষয়া, <?php echo $location['cir']; ?>
                                                    </textarea>
                                                    <!-- <input type="text" name="Co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/> -->
                                                    <?php } else {?>
    
                                                    <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>
                                                    
                                                    <input type="hidden" name="Co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
    
                                                    <?php }?>
                                                    
                                                    <?php
                                                }
                                            }
                                            else{
                                                
                                                if(($lm_details_final[0]->dist_frm_town==3) && ($lm_details_final[0]->inside_outside_town=='i'))
                                                {
                                                    $msg_report = "চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==10) && ($lm_details_final[0]->inside_outside_town=='i'))
                                                {
                                                    $msg_report = "গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='i'))
                                                {
                                                    $msg_report = "নগৰ/চহৰৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='r'))
                                                {
                                                    $msg_report = "ৰাজহ নগৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='d'))
                                                {
                                                    //$msg_report = "নগৰ/চহৰৰ মাটি হয় | ";
                                                    $msg_report = "জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='o'))
                                                {
                                                    $msg_report = "গাওৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==15) && ($lm_details_final[0]->inside_outside_town=='i'))
                                                {
                                                    $msg_report = "গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==5) && ($lm_details_final[0]->inside_outside_town=='i'))
                                                {
                                                    $msg_report = "জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='m'))
                                                {
                                                    $msg_report = "পৌৰ নগৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==5) && ($lm_details_final[0]->inside_outside_town=='m'))
                                                {
                                                    $msg_report = "পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==0) && ($lm_details_final[0]->inside_outside_town=='g'))
                                                {
                                                    $msg_report = "গুৱাহাটী মহানগৰী মাটি হয় | ";
                                                }
                                                elseif(($lm_details_final[0]->dist_frm_town==15) && ($lm_details_final[0]->inside_outside_town=='g'))
                                                {
                                                    $msg_report = "গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয় | ";
                                                }
                                                
                                                ?>
    
                                                <?php if ($land_details["patta_type"]=='0208') { ?>
                                                
                                                
                                                    <textarea cols='20' rows='10' name="Co_notice" class="form-control">লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |
    
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্য <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                
                                                চক্র বিষয়া, <?php echo $location['cir']; ?></textarea>
                                                <?php } else {?>
    
                                                    লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় | <br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>   
                                                
                                                <input type="hidden" name="Co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় | <br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্য <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
    
                                                <?php }?>
                                               
                                                <?php
                                            }
                                        }
                                        else if($lm_details_final[0]->premium_new_yn == 1) {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level == 'circle') {
                                                if($presence == '') {
                                                    ?>
                                                    লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |<br><br>
                                                    লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                    সেয়েহে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                    <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>
                                                    
                                                    <input type="hidden" name="Co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |<br><br>
                                                    লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                    সেয়েহে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                                    <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> টকা হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                    <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
                                                    <?php
                                                }
                                                else {
                                                    ?>
    
                                                    <?php if ($land_details["patta_type"]=='0208') { ?>
                                                    
                                                        <!-- <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span> -->
                                                    <textarea cols='20' rows='10' name="Co_notice" class="form-control">সহায়কে দাখিল কৰা <?php echo $location['case_no']; ?> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷
                                                    
                                                    <?php echo $location['add_to']; ?>
                                                    
                                                    চক্র বিষয়া, <?php echo $location['cir']; ?>
                                                    </textarea>
                                                    <!-- <input type="text" name="Co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/> -->
                                                    <?php } else {?>
    
                                                    <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>
                                                    
                                                    <input type="hidden" name="Co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা</span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
    
                                                    <?php }?>
                                                    
                                                    <?php
                                                }
                                            }
                                            else {
                                                $msg_report = $premium_area_details->ass_name;
                                                ?>

                                                <?php if ($land_details["patta_type"]=='0208') { ?>
                                                
                                                    <textarea cols='20' rows='10' name="Co_notice" class="form-control">লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় |
    
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্য <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                
                                                চক্র বিষয়া, <?php echo $location['cir']; ?></textarea>
                                                <?php } else {?>
    
                                                    লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় | <br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>   
                                                
                                                <input type="hidden" name="Co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমী হয় | <br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্য <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php //echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></span>"/>
    
                                                <?php }?>
                                               
                                                <?php
                                            }
                                        }

                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                            {
                                                if ($presence == '') {
                                                    ?>
                                                    <label class="control-label"><?php echo $this->lang->line('next_hearing_date'); ?> &nbsp;
                                                        <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                        &nbsp; (dd/mm/yyyy)</label>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <label class="control-label"><?php echo $this->lang->line('final_order_date'); ?> &nbsp;
                                                        <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                        &nbsp; (dd/mm/yyyy)</label>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <label class="control-label">Forwarding Date &nbsp;
                                                    <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                    &nbsp; (dd/mm/yyyy)</label>
                                                <?php
                                            }
                                        }
                                        else {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level == 'circle') {
                                                if ($presence == '') {
                                                    ?>
                                                    <label class="control-label"><?php echo $this->lang->line('next_hearing_date'); ?> &nbsp;
                                                        <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                        &nbsp; (dd/mm/yyyy)</label>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <label class="control-label"><?php echo $this->lang->line('final_order_date'); ?> &nbsp;
                                                        <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                        &nbsp; (dd/mm/yyyy)</label>
                                                    <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                <label class="control-label">Forwarding Date &nbsp;
                                                    <input type="text" name="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                    &nbsp; (dd/mm/yyyy)</label>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <label class="control-label">
                                        <?php
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                            {
                                                ?>
                                                <?php
                                                if ($presence == '' || $presence == null) {
                                                    ?>
                                                    <input type="radio" name="order_type" value="prepare_premium" checked="checked">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="order_type" value="prepare_premium" disabled>
                                                    <?php
                                                }
                                                ?>
                                                <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <input type="radio" name="order_type" value="forwardtodc" checked="checked"> Forward to DC / ADC  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                            }
                                        }
                                        else {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level == 'circle') {
                                                ?>
                                                <?php
                                                if ($presence == '' || $presence == null) {
                                                    ?>
                                                    <input type="radio" name="order_type" value="prepare_premium" checked="checked">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="order_type" value="prepare_premium" disabled>
                                                    <?php
                                                }
                                                ?>
                                                <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <input type="radio" name="order_type" value="forwardtodc" checked="checked"> Forward to DC / ADC  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                            }
                                        }
                                        
                                        ?>
                                        </label>
                                        <label class="control-label">    
                                            <!-- <input type="radio" name="order_type" value="re_lm_note" onclick="return confirm('Are you sure you want Lot Mondol to rewrite report?')"> Send Back to LM for Re Submitting Report -->
                                            <input type="radio" name="order_type" value="re_lm_note"> Send Back to LM for Re Submitting Report
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="row" id="re_lm_note" style="display:none;">
                                <div class="col-sm-12">
                                    <label class="control-label">Reason For Re Submitting Report</label>
                                    <textarea name="co_reason_note" class="form-control" rows="5" required>&nbsp;&nbsp;</textarea>
                                    <br>
                                    <label class="control-label">
                                        <?php echo "Re Hearing Date"; ?><span class='red'>*</span> &nbsp; 
                                        <input type="text" name="re_hearing_date" id="popupDatepicker" style="width: 200px;" required>
                                        &nbsp; (dd/mm/yyyy)
                                    </label>
                                </div>
                            </div>
                            <div class="row" id="show_div">
                                <div class="col-sm-12">
                                    <label class="rasid col-sm-4">
                                        <?php
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                            {
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio1" value="finalhukum" disabled> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php
                                                }
                                            }
                                        }
                                        else {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level == 'circle') {
                                                if($presence == '') {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio1" value="finalhukum" disabled> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php
                                                }
                                            }
                                        }
                                        
                                        ?>
                                    </label>
                                    <!-- <label class="rasid col-sm-4">
                                        <?php
                                        if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                        {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio2" value="closecase" onclick="return confirm('Are you sure you want to cancel this case order?')"> <?php //echo $this->lang->line('cancel_order'); ?>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            Note : Please Select the Forwarding Officer (Deputy Commissioner / Assistant Deputy Commissioner) 
                                            <?php
                                        }
                                        ?>
                                    </label> -->
                                    <label class="rasid col-sm-4">
                                        <?php
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town == 'o') || ($lm_details_final[0]->inside_outside_town == '') || ($lm_details_final[0]->inside_outside_town == null))
                                            {
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" onclick="return confirm('Are you sure you want to continue hearing?')"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                    <?php
                                                }
                                            }
                                        }
                                        else {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level == 'circle') {
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" onclick="return confirm('Are you sure you want to continue hearing?')"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                    <?php
                                                }
                                            }
                                        }
                                        
                                        ?>
                                    </label>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <center>
                                        <?php
                                        if($lm_details_final[0]->premium_new_yn == 0 || $lm_details_final[0]->premium_new_yn == null) {
                                            if(($lm_details_final[0]->inside_outside_town != '') || ($lm_details_final[0]->inside_outside_town != null)){
                                                if(($lm_details_final[0]->inside_outside_town == 'i') || ($lm_details_final[0]->inside_outside_town == 'd') || ($lm_details_final[0]->inside_outside_town == 'r') || ($lm_details_final[0]->inside_outside_town == 'm') || ($lm_details_final[0]->inside_outside_town == 'g')){
                                                    ?>
                                                    <label class="rasid btn">Please Select DC/ADC &nbsp;&nbsp;</label>
                                                    <label class="btn btn-success">
                                                        <select class="form-control" name='dc_code' required>
                                                        <?php
                                                        ///department case condition check
                                                        if ((($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'm')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'g') )) {
                                                            $loops=$adc_only;
                                                        } else {
                                                            $loops=$dc_adc;
                                                        }
                                                        foreach ($loops as $dcadc) {
                                                                $user_desig_code = $dcadc->user_desig_code;
                                                                $username = $dcadc->username." ( ".$user_desig_code." )";
                                                                $user_code = $dcadc->user_code;
                                                                echo"<option value='$user_code'>$username</option>";
                                                            }
                                                        ?>
                                                        </select>
                                                    </label>
                                                    <?php
                                                }
                                            }
                                        }
                                        else {
                                            if(!empty($premium_rate_details) && $premium_rate_details->approval_level != 'circle') {
                                                ?>
                                                <label class="rasid btn">Please Select DC/ADC &nbsp;&nbsp;</label>
                                                <label class="btn btn-success">
                                                    <select class="form-control" name='dc_code' required>
                                                    <?php
                                                    ///department case condition check
                                                    if ($premium_rate_details->approval_level == 'gov') {
                                                        $loops=$adc_only;
                                                    } else {
                                                        $loops=$dc_adc;
                                                    }
                                                    foreach ($loops as $dcadc) {
                                                            $user_desig_code = $dcadc->user_desig_code;
                                                            $username = $dcadc->username." ( ".$user_desig_code." )";
                                                            $user_code = $dcadc->user_code;
                                                            echo"<option value='$user_code'>$username</option>";
                                                        }
                                                    ?>
                                                    </select>
                                                </label>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <?php 
                                    if($buttonEnabledFlag == 1){ ?>
                                        <?php if($lm_details['land_trans_yn'] != 'N') { ?>
                                        <button type="submit" name="submit" id="onsubmit"   class="btn btn-danger uni_text"><i class='fa fa-check'></i>  <?php echo "Submit"; ?> </button>
                                        <?php } else { ?>
                                            <?php if($land_details['patta_type'] == '0208') { ?>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$location['case_no']?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                                <p style="color:red;">Nisfi Kheraz with non transferred land</p>
                                            <?php } else { ?>
                                                <button type="submit" name="submit" id="onsubmit"   class="btn btn-danger uni_text"><i class='fa fa-check'></i>  <?php echo "Submit"; ?> </button>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    </center>
                                    <br>
                                </div>
                            </div>
                            <div class="row" id="re_lm_note1" style="display:none;">
                                <hr>
                                <div class="col-lg-12">
                                    <center>
                                        <button type="submit" name="submit" id="onsubmit" class="btn btn-danger uni_text"><i class='fa fa-check'></i>  <?php echo "Re Submit"; ?> </button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <?php
                            if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                            }
                            else{
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach($supportiveDocs as $docs):
                                ?>
                                    <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
                                <?php
                                endforeach;
                            }
                        ?>
                        <hr style="border-bottom: 2px solid #000;">
                        
                        
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <!-- <a class="btn btn-sm btn-danger uni_text" href="<?php //echo base_url();?>index.php/COconversionPartha/RejectOrder?case_no=<?=$location['case_no']?>&dist_code=<?=$premium[0]->dist_code?>&subdiv_code=<?=$premium[0]->subdiv_code?>&cir_code=<?=$premium[0]->cir_code?>&mouza_pargona_code=<?=$premium[0]->mouza_pargona_code?>&lot_no=<?=$premium[0]->lot_no?>&vill_townprt_code=<?=$premium[0]->vill_townprt_code?>"><i class='fa fa-hand-paper-o'></i> Click Here to Reject Order</a> -->
                                <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <button type="" class="btn btn-info uni_text" value="2" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;<?php echo $this->lang->line('lm_report'); ?></button>
                                <button type="" class="btn btn-active uni_text" value="3" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;  AST & CO Report</button>
                                <button type="" class="btn btn-default uni_text" value="4" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('sk_report'); ?></button>
                                <button type="" class="btn btn-warning uni_text" value="5" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('view_premiun_report'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=2"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title uni_text"><?php echo $this->lang->line('application_description'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row panel-form">
                    <div class="col-lg-12 center-col">
                        <div class="panel">
                            <!--div 1-->            
                            <div id="notice1" style='display: none'>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <p class='center uni_text'> <?php echo $this->lang->line('application_description'); ?></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                                        <table class='table table-bordered unicode'>
                                            <tr>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                                <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $location['add_to']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($location['date'])); ?></label></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                                        <table class="table table-bordered  unicode">
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td><label class="control-label"><?php echo $land_details['dag']; ?></label></td>
                                                <td><label class="control-label"><?php echo $land_details['m_dag_area_b'] . " বিঘা " . $land_details['m_dag_area_k'] . " কঠা " . $land_details['m_dag_area_lc'] . " লেছা " ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $land_details['patta_no']; ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">জমাবন্দী চাওক</span></button></a></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                                        <table class='table table-bordered  unicode'>
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                                    <th>AADHAAR/PAN Status</th>
                                                </tr>
                                            </thead>
                                            <?php $count = 1; ?>
                                            <?php
                                            foreach ($pattadar as $p):
                                                $flag = 'N/A';
                                                if($p->auth_type == 'AADHAAR'){
                                                    $flag = 'AADHAAR Verified';
                                                }else if($p->auth_type == 'PAN'){
                                                    $flag = 'PAN Verified';
                                                }
                                                $pattadar = $p->pdar_name;
                                                //$relation=$p->pdar_rel_guar;
                                                $relation = 'f';
                                                $relationship = $this->utilityclass->get_relation($relation);
                                                ?>
                                                <tr>
                                                    <td><label class="control-label"><?php echo $count++; ?></label></td>
                                                    <td><label class="control-label"><?php echo $pattadar; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->pdar_guardian; ?></label></td>
                                                    <td><label class="control-label"><?php echo $relationship; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->pdar_add1 . " " . $p->pdar_add2; ?></label></td>
                                                    <td><?=$flag;?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <!--div 2-->            
                            <div id="notice2" style='display: none'>
                                <?php
                                if (count($lm_details_final) != 0) {
                                    foreach ($lm_details_final as $lm):
                                        ?>
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> (<?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                                <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?>  <?php echo $land_details['dag']; ?>)</span></p>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class='table table-striped unicode'>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; - 
                                                                    <?php
                                                                    if ($lm->applicant_patta_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                                                    <?php
                                                                    if ($lm->occupied_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                                                    <?php
                                                                    if ($lm->val_tree_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী - <?php echo $lm_details['land_class_code']; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                                                    <?php
                                                                    if ($lm->issuit_forconv_under105 == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ, </label>
                                                            <!-- added by hridayjit -->
                                                            <?php if($lm->roadside_old_new_dag_reservation != null) {?>
                                                                </label class="control-label"> <b>Roadside Reservation: </b> 
                                                                    <?php 
                                                                        if($lm->roadside_old_new_dag_reservation == 'newdagreservation')
                                                                        {
                                                                            echo 'New Dag Reservation';
                                                                        } 
                                                                        else if($lm->roadside_old_new_dag_reservation == 'olddagreservation') 
                                                                        {
                                                                            echo 'Old Dag Reservation';
                                                                        }; 
                                                                    ?>
                                                                </label>
                                                            <?php } ?>
                                                            <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৭) উক্ত মাটি নদীৰ কাষৰ মাটি &nbsp; -
                                                                    <?php
                                                                    if ($lm->near_river_yn == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                                    <!-- added by hridayjit -->
                                                                    <?php if($lm->riverside_old_new_dag_reservation != null) { ?>
                                                                        <label class="control-label"> <b>Riverside Reservation: </b>
                                                                            <?php 
                                                                                if($lm->riverside_old_new_dag_reservation == 'newdagreservation')
                                                                                {
                                                                                    echo 'New Dag Reservation';
                                                                                } 
                                                                                else if($lm->riverside_old_new_dag_reservation == 'olddagreservation') 
                                                                                {
                                                                                    echo 'Old Dag Reservation';
                                                                                }; 
                                                                            ?>
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label> 
                                                                <ul>
                                                                <?php
                                                                if (($lm_details['jati_janajati_yn'] != 'Y') && ($lm_details['freedom_fighter_yn'] != 'Y') && ($lm_details['widow_yn'] != 'Y'))
                                                                {
                                                                    echo " - এই আবেদনত উপযোগী নহয় |";
                                                                }
                                                                if ($lm->jati_janajati_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                    
                                                                        if(empty($lm->jati_janajati_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                } 
                                                                if ($lm->freedom_fighter_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->freedom_fighter_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                if ($lm->widow_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->widow_yn_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <?php 
                                                                    // muzammil : new include file added for premium condition 
                                                                    include(APPPATH."views/inc/conversion_premium.php");?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <?php // muzammil : new include file added for premium per bigha 
                                                                    include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                                                <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?= round($bigha_prem, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা  &nbsp;<a href="<?= base_url(); ?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%"><label class="control-label">১১) মন্ডলৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                            <td><label class="control-label"><?php echo $lm->partition_info; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১২) লাঃ মঃ ৰ চহী &nbsp; - 
                                                                    <?php
                                                                    if ($lm->lm_sign_yn == 'Y' || $lm->lm_sign_yn == 'y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৩) লাঃ মঃ ৰ নাম &nbsp; - <?php echo $lm_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৪) লাঃ মঃ এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->date_entry)); ?></label>
                                                            </td>
                                                        </tr>
                                                        <?php if($land_details['patta_type'] == '0208') { ?>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">Is the Nisfi Kheraz Land Transferred? -<?php echo ($lm_details['land_trans_yn'] != '' && $lm_details['land_trans_yn'] != null) ? $lm_details['land_trans_yn'] : ''; ?></label>&nbsp;
                                                                    <label class="control-label" ><a href="<?= base_url(); ?>assets/nisfi_kheraz_notice.pdf" target="_blank">View Nisfi Kheraz Notice </a></label>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Pattadar Name</th>
                                                                            <th>Inplace / Alongwith</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($p_in_order as $pdar) { ?>
                                                                            <tr>
                                                                                <td><?php echo $pdar->pdar_name; ?></td>
                                                                                <td><?php echo $pdar->inplace_alongwith; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> ( <?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                            <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?> <?php echo $land_details['dag']; ?>)</span></p>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        No Report found
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--div 3-->            
                            <div id="notice3" style='display: none'>
                                <div class="panel-heading">
                                    <p align="left" class="uni_text"> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ </p><br>
                                    <p align="right" style="margin-top: 0; margin-bottom: 0">
                                        <font size="3" face="courier">
                                        <?php echo $this->lang->line('name'); ?> : 
                                        <?php
                                        foreach ($p_in_order as $pop):
                                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                        endforeach;
                                        ?>
                                        </font>
                                    </p>
                                    <div class="panel-title">
                                        <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                                        <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                                        <br>
                                        <p class='center bold uni_text'><span class="">Order Sheet, dated from <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['date'])); ?></span> To <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['next_date'])); ?></span> District <?php echo $location['dist']; ?> <br>
                                                Case No <?php echo $location['case_no']; ?></span></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                            <table class="table table-bordered" style="font-size: 16px;">
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>Serial No and Date of Order</td>
                                                    <td width="40%">Order and Signature of Officer</td>
                                                    <td width="40%">Note Of Action Taken on Order</td>
                                                </tr>
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>১</td>
                                                    <td>২</td>
                                                    <td>৩</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($cases as $case):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                                        <td>
                                                            <?php echo $case->co_order; ?></td>
                                                        <td>
                                                            <?php echo $case->note_on_order; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
//$i = $i+1;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--div 4-->            
                            <div id="notice4" style='display: none'>
                                <?php
                                if (count($lm_details_final) != 0) {
                                    foreach ($lm_details_final as $lm):
                                        ?>
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <p class='center bold uni_text'><u><?php echo $this->lang->line('lm_report'); ?> ( <?php echo $this->lang->line('case_no'); ?> : <?php echo $lm_details['case_no']; ?>)</u><br>
                                                    <span style="color: red;">(<?php echo $this->lang->line('dag_no'); ?> <?php echo $lm_details['dag_no']; ?>)</span></p>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <table class='table table-striped unicode'>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; - 
                                                                        <?php
                                                                        if ($lm->applicant_patta_yn == 'Y') {
                                                                            echo "আছে";
                                                                        } else {
                                                                            echo "নাই";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                                                        <?php
                                                                        if ($lm->occupied_yn == 'Y') {
                                                                            echo "আছে";
                                                                        } else {
                                                                            echo "নাই";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                                                        <?php
                                                                        if ($lm->val_tree_yn == 'Y') {
                                                                            echo "আছে";
                                                                        } else {
                                                                            echo "নাই";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী - <?php echo $lm_details['land_class_code']; ?></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                                                        <?php
                                                                        if ($lm->issuit_forconv_under105 == 'Y') {
                                                                            echo "হয়";
                                                                        } else {
                                                                            echo "নহয়";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ </label></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ৭) উক্ত মাটি নদীৰ কাষৰ মাটি &nbsp; -
                                                                        <?php
                                                                        if ($lm->near_river_yn == 'Y') {
                                                                            echo "হয়";
                                                                        } else {
                                                                            echo "নহয়";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label> 
                                                                    <ul>
                                                                    <?php
                                                                    if (($lm_details['jati_janajati_yn'] != 'Y') && ($lm_details['freedom_fighter_yn'] != 'Y') && ($lm_details['widow_yn'] != 'Y'))
                                                                    {
                                                                        echo " - এই আবেদনত উপযোগী নহয় |";
                                                                    }
                                                                    if ($lm->jati_janajati_yn == 'Y') {
                                                                        echo '<li>
                                                                            <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                                            <div id="jati_janajatie" class="alert alert-info">';

                                                                            if(empty($lm->jati_janajati_upload)){
                                                                            ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                            <?php
                                                                            }
                                                                            else{
                                                                                ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
                                                                                <?php
                                                                            }
                                                                            echo'</div>
                                                                        </li>';
                                                                    } 
                                                                    if ($lm->freedom_fighter_yn == 'Y') {
                                                                        echo '<li>
                                                                            <label class="control-label" >খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয় &nbsp;</label>
                                                                            <div id="jati_janajatie" class="alert alert-info">';
                                                                            if(empty($lm->freedom_fighter_upload)){
                                                                            ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                            <?php
                                                                            }
                                                                            else{
                                                                                ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
                                                                                <?php
                                                                            }
                                                                            echo'</div>
                                                                        </li>';
                                                                    }
                                                                    if ($lm->widow_yn == 'Y') {
                                                                        echo '<li>
                                                                            <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                                            <div id="jati_janajatie" class="alert alert-info">';
                                                                            if(empty($lm->widow_yn_upload)){
                                                                            ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                            <?php
                                                                            }
                                                                            else{
                                                                                ?>
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
                                                                                <?php
                                                                            }
                                                                            echo'</div>
                                                                        </li>';
                                                                    }
                                                                    ?>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                <?php 
                                                                    // muzammil : new include file added for premium condition 
                                                                    include(APPPATH."views/inc/conversion_premium.php");?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                <?php // muzammil : new include file added for premium per bigha 
                                                                    include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                                                
                                                                    <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?=round($bigha_prem, 2) ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা  &nbsp;<a href="<?= base_url(); ?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="50%"><label class="control-label">১১) মন্ডলৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                                <td><label class="control-label"><?php echo $lm->partition_info; ?></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><label class="control-label">
                                                                        ১২) লাঃ মঃ ৰ চহী &nbsp; - 
                                                                        <?php
                                                                        if ($lm->lm_sign_yn == 'Y' || $lm->lm_sign_yn == 'y') {
                                                                            echo "আছে";
                                                                        } else {
                                                                            echo "নাই";
                                                                        }
                                                                        ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">১৩) লাঃ মঃ ৰ নাম &nbsp; - <?php echo $lm_name; ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">১৪) লাঃ মঃ এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->date_entry)); ?></label>
                                                                </td>
                                                            </tr>
                                                            <?php if($land_details['patta_type'] == '0208') { ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <label class="control-label">Is the Nisfi Kheraz Land Transferred?-<?php echo ($lm_details['land_trans_yn'] != '' && $lm_details['land_trans_yn'] != null) ? $lm_details['land_trans_yn'] : ''; ?></label>&nbsp;
                                                                        <label class="control-label" ><a href="<?= base_url(); ?>assets/nisfi_kheraz_notice.pdf" target="_blank">View Nisfi Kheraz Notice </a></label>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($lm->sk_sign_yn == 'Y' || $lm->sk_sign_yn == 'y') {
                                            ?>
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <p class='center bold uni_text'><span style="color: red;"><u><?php echo $this->lang->line('sk_report'); ?> </u></span></p>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <table class='table table-striped unicode'>
                                                                <tr>
                                                                    <td><label class="control-label">১) কাননগুহৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                                    <td width="50%"><label class="control-label"><?php echo $lm->sk_note; ?></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"><label class="control-label">
                                                                            ২) কাননগুহৰ চহী &nbsp; - 
                                                                            <?php
                                                                            if ($lm->sk_sign_yn == 'N' || $lm->sk_sign_yn == 'n' || $lm->sk_sign_yn == '') {
                                                                                echo "নাই";
                                                                            } else {
                                                                                echo "আছে";
                                                                            }
                                                                            ?></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <label class="control-label">৩) কাননগুহৰ নাম &nbsp; - <?php echo $sk_skname; ?></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <label class="control-label">৪) কাননগুহৰ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->sk_note_date)); ?> &nbsp;</label>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <p class='center bold uni_text'><span style="color: red;"><u><?php echo $this->lang->line('sk_report'); ?> </u></span></p>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        No Report found
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--div 5-->            
                            <div id="notice5" style='display: none'>
                                <?php
                                if (count($premium) != 0) {
                                    foreach ($premium as $lm):
                                        ?>
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <p class='center bold uni_text'>সহায়কৰ  <?php echo $location['case_no']; ?> নং ম্যাদীকৰণ গোচৰৰ প্রিমিয়ামৰ বিৱৰণ</p>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <center>
                                                    <?php
                                                    if ($lm->prem_pay_method != '') {
                                                        if ($lm->recpt_number != 'N') {
                                                            ?>
                                                            <table class='table table-striped unicode'>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;</td>
                                                                </tr>
                                                                <tr style="text-align: center;">
                                                                    <td colspan="4"><label class="control-label">বিঘাই প্রতি <?php echo round($lm->prim_per_bigha, 2); ?> টকা হাৰে <?php echo $lm->dag_no; ?> নং দাগৰ <?php echo $lm->conv_b; ?> বিঘা, <?php echo $lm->conv_k; ?> কঠা, <?php echo round($lm->conv_lc, 2); ?> লেছা মাটিৰ প্রিমিয়াম হয় = <?php echo round($lm->prim_tot, 2); ?> টকা ।</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;</td>
                                                                </tr>
                                                                <tr style="text-align: center;">
                                                                    <td colspan="4"><label class="control-label">মুঠ প্রিমিয়াম = <?php
                                                                        if($lm->prem_pay_method!='300'){
                                                                             echo round($lm->prim_tot, 2);
                                                                         }
                                                                         else{
                                                                            echo "বসুন্ধৰাৰ বাবে বিনামূলীয়া সেৱা ";
                                                                         }
                                                                     ?></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">
                                                                    <center>
                                                                        <label class="control-label">
                                                                            <?php
                                                                            if ($lm->prem_pay_method != '003') {
                                                                                echo "<span class=\"rasid\" style=\"color: green;\">প্রিমিয়াম পোৱা হ'ল </span></td>";
                                                                            } else {
                                                                                echo "<span class=\"rasid\" style=\"color: green;\">প্রিমিয়াম ৰাজহৰ বকেয়া হিচাপে আদায় লোৱা হব ।</span></td>";
                                                                            }
                                                                            ?>
                                                                        </label>
                                                                    </center>
                                                                </tr>
                                                            </table>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <center><span class="rasid" style="color: red;">প্রিমিয়াম পোৱা নাই</span></center>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "<span class='rasid' style='color: red;'>Waiting for Circle Officers instruction/order for Generating and serving Notice for Premium.</span>";
                                                    }
                                                    ?>
                                                </center>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <p class='center bold uni_text'><span style="color: red;"><u>সহায়কৰ  <?php echo $location['case_no']; ?> নং ম্যাদীকৰণ গোচৰৰ প্রিমিয়ামৰ বিৱৰণ</u></span></p>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                            <span class='rasid'>Waiting for Circle Officers instruction/order for Generating and serving Notice for Premium</span>
                                            </center>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default uni_text" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modaldiva(objButton) {
        if (objButton == 1)
        {
            document.getElementById('notice1').style.display = 'block';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
        else if (objButton == 2)
        {
            document.getElementById('notice2').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
        else if (objButton == 3)
        {
            document.getElementById('notice3').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
        else if (objButton == 4)
        {
            document.getElementById('notice4').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
        else if (objButton == 5)
        {
            document.getElementById('notice5').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
        }
    }

    $("input[name$='order_type']").click(function() {
        if($(this).val() == 're_lm_note') {
            if(confirm('Are you sure you want Lot Mondol to rewrite report?')) {
                $('#show_div').hide();
                $('#re_lm_note').show();
                $('#re_lm_note1').show();
            }
            else{
                $(this).prop('checked', false);
                $('#re_lm_note').hide();
                $('#re_lm_note1').hide();
                $('#show_div').show();
            }
        }
        else{
            $('#re_lm_note').hide();
            $('#re_lm_note1').hide();
            $('#show_div').show();
        }

        // if ($(this).val()=='re_lm_note'){
        //     //alert("edit");
        //     $('#re_lm_note').show();
        //     $('#show_div').hide();
        //     $('#re_lm_note1').show();
        // } else {
        //     //alert("new");
        //     $('#show_div').show();
        //     $('#re_lm_note').hide();
        //     $('#re_lm_note1').hide();
        // }
    });

    $('.btn-file').on('click', (e)=>{
        console.log(e.currentTarget.id);
    });
</script>