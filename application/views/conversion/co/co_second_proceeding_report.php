<?php //echo '<pre>'; var_dump($co_details); die(); ?>

<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-12 col-lg-12">
            <?php
                // if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                // {
                //     include 'application/views/common/input_hidden_fields_and_func.php';
                // }
            ?>
            <div class="card card-success">
                <div class="card-header d-flex justify-content-between">
                    <p>Case No: <?php echo $petition_basic->case_no; ?></p>
                    <p>Second Proceeding Conversion Order</p>
                    <p>Date: <?php echo date('d-m-Y'); ?></p>
                </div>
                <div class="card-body">
                    <form action="" id="mainform">
                        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="case_no" id="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                                        <?php 
                                            $presence = $petition_lm_note_details->prem_pay_method;
                                            $p=round($petition_lm_note_details->prim_per_bigha, 2);
                                            $pt=round($petition_lm_note_details->prim_tot, 2);
                                            if($premium_rate_details->amount != 0 && $premium_rate_details->rate == 0) {
                                                $prem_percent = $premium_rate_details->amount . ' টকা ';
                                            }
                                            else if ($premium_rate_details->amount == 0 && $premium_rate_details->rate != 0) {
                                                $prem_percent = $premium_rate_details->rate . ' % ';
                                            }

                                        if (($petition_lm_note_details->jati_janajati_yn != 'Y') && ($petition_lm_note_details->freedom_fighter_yn != 'Y') && ($petition_lm_note_details->widow_yn != 'Y'))
                                        {
                                            $msg="";
                                        }
                                        else{
                                            $msg="আৰু ২৫% ৰেহাই পাচত";
                                        }
                                        if($premium_rate_details->approval_level == 'circle') {
                                            if($presence == '') {?>
                                                ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |<br><br>
                                                প্ৰতিবেদনৰ মতে 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                সেয়েহে <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php 
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>
                                                
                                                <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                    
                                                ?> জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |<br><br>
                                                প্ৰতিবেদনৰ মতে 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
                                                সেয়েহে <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                লেছা মাঢিৰ ম্যাদীকৰণ প্ৰিমিয়াম <span style='color:red;'>বিঘাই প্ৰতি <?php echo $prem_percent; ?> টকা হাৰত মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷ 
                                                <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>"/>
                                            <?php }
                                            else { ?>
                                                <span style='color:red;'><?php echo $petition_basic->case_no; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location_details->cir_name; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <span style='color:red;'><?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা'; 
                                                    } 
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা'; 
                                                    }
                                                ?> 
                                                </span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>
                                                
                                                <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="সহায়কে দাখিল কৰা <span style='color:red;'><?php echo $petition_basic->case_no; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে চক্ৰ বিষয়া <?php echo $location_details->cir_name; ?> ৰাজহ চক্ৰ, বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <span style='color:red;'><?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }  
                                                ?> 
                                                </span> জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>"/>
                                            <?php
                                            }
                                        }
                                        else {
                                            $msg_report = $premium_area_details->ass_name;
                                            // if($premium_rate_details->premium_area_id == 2) {
                                                
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 3) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 4) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 5) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 6) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 7) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 8) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if ($premium_rate_details->premium_area_id == 9) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // else if($premium_rate_details->premium_area_id == 10) {
                                            //     $msg_report = $premium_area_details->ass_name;
                                            // }
                                            // {
                                            //     $msg_report = "চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয় | ";
                                            // }
                                            // else if ($premium_rate_details->premium_area_id == 'gov') {

                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==10) && ($petition_lm_note_details->inside_outside_town=='i'))
                                            // {
                                            //     $msg_report = "গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='i'))
                                            // {
                                            //     $msg_report = "নগৰ/চহৰৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='r'))
                                            // {
                                            //     $msg_report = "ৰাজহ নগৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='d'))
                                            // {
                                            //     //$msg_report = "নগৰ/চহৰৰ মাটি হয় | ";
                                            //     $msg_report = "জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='o'))
                                            // {
                                            //     $msg_report = "গাওৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==15) && ($petition_lm_note_details->inside_outside_town=='i'))
                                            // {
                                            //     $msg_report = "গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==5) && ($petition_lm_note_details->inside_outside_town=='i'))
                                            // {
                                            //     $msg_report = "জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='m'))
                                            // {
                                            //     $msg_report = "পৌৰ নগৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==5) && ($petition_lm_note_details->inside_outside_town=='m'))
                                            // {
                                            //     $msg_report = "পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==0) && ($petition_lm_note_details->inside_outside_town=='g'))
                                            // {
                                            //     $msg_report = "গুৱাহাটী মহানগৰী মাটি হয় | ";
                                            // }
                                            // elseif(($petition_lm_note_details->dist_frm_town==15) && ($petition_lm_note_details->inside_outside_town=='g'))
                                            // {
                                            //     $msg_report = "গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয় | ";
                                            // }
                                            
                                            ?>
                                            <!-- ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                            <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                }
                                                
                                            ?> 
                                            জমী হয় | <br>
                                            প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> এলেকাৰ অন্তর্গত হয় | সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং বিধি অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণা অনুসৰি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম । <br> শুনানিৰ তথ্য ? <br> চক্ৰ বিষয়াৰ মন্তব্য ?
                                            <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>    -->
                                            
                                            <textarea name="co_notice" id="co_notice" class="form-control" cols="15" rows="15" required>ভূমিলেখ্য সহায়কে আৰু ভূমিলেখ্য পৰ্যবেক্ষকে প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                } 
                                            ?> জমী হয় | উক্ত মাটি পট্টাদাৰ আবেদনকাৰী এ হস্তান্তৰ কৰা নাই আৰু নিজে স্থায়ী ভাবে ভোগ দখল কৰি আছে আৰু ALRM ৰ ১০৫ ডফা মতে ম্যদীকৰনৰ উপযোগী বুলি প্রতিবেদনত প্ৰকাশ। জাননী ৰিতি মতে জাৰি হৈছে |

শুনানিৰ তথ্য ?

চক্ৰ বিষয়াৰ মন্তব্য ?

প্ৰতিবেদনৰ মতে এই মাটি 15-10-2024 তাৰিখৰ ৰাজহ বিভাগৰ অধিসূচনা eCF No. 565802/I/772771/2024 মতে <?php echo $msg_report; ?> এলেকাৰ অন্তর্গত হয় | সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং বিধি অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণা অনুসৰি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা প্ৰিমিয়াম ।


<?php echo $co_details->username; ?>

চক্র বিষয়া, <?php echo $location_details->cir_name; ?></textarea>
                                            
                                            
                                        
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        if($premium_rate_details->approval_level == 'circle')
                                        {
                                            if ($presence == '') {
                                                ?>
                                                <label class="control-label"><?php echo $this->lang->line('next_hearing_date'); ?> &nbsp;<span class="red">*</span>
                                                    <input type="text" name="hearing_date" id="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                    &nbsp; (dd/mm/yyyy)</label>
                                                <?php
                                            } else {
                                                ?>
                                                <label class="control-label"><?php echo $this->lang->line('final_order_date'); ?> &nbsp;<span class="red">*</span>
                                                    <input type="text" name="hearing_date" id="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                    &nbsp; (dd/mm/yyyy)</label>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <label class="control-label">Forwarding Date / Next Date of Hearing &nbsp;<span class="red">*</span>
                                                <input type="text" name="hearing_date" id="hearing_date" value="<?php echo date('d-m-Y');?>" id="popupDatepicker" style="width: 200px;" required>
                                                &nbsp; (dd/mm/yyyy)</label>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <?php if($petition_lm_note_details->lm_note_type == '2'): ?>

                                        <?php else: ?>
                                            <label class="control-label">
                                            <?php
                                            // foreach ($premium as $p) {
                                            //     $presence = $p->prem_pay_method;
                                            // }
                                            if($premium_rate_details->approval_level == 'circle')
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
                                                <input type="radio" name="order_type" value="forwardtodc" checked="checked"> Forward to ADC  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                            }
                                            ?>
                                            </label>
                                            <label class="control-label">
                                                <input type="radio" name="order_type" value="re_lm_note"> Send Back to LM for Re Submitting Report
                                            </label>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="row" id="re_lm_note" style="display:none;">
                            <div class="col-sm-12">
                                <label class="control-label">Reason For Re Submitting Report<span class="red">*</span></label>
                                <textarea name="co_reason_note" id="co_reason_note" class="form-control" rows="5" required>&nbsp;&nbsp;</textarea>
                                <br>
                                <label class="control-label">
                                    <?php echo "Re Hearing Date"; ?><span class='red'>*</span> &nbsp; 
                                    <input type="date" name="re_hearing_date" id="re_hearing_date" id="popupDatepicker" style="width: 200px;" required>
                                    &nbsp; (dd/mm/yyyy)
                                </label>
                            </div>
                        </div>
                        <div class="row" id="show_div">
                            <div class="col-sm-12">
                                <?php if($petition_lm_note_details->lm_note_type == '2'): ?>

                                <?php else: ?>
                                    <label class="rasid col-sm-4">
                                        <?php
                                        // foreach ($premium as $p) {
                                        //     $presence = $p->prem_pay_method;
                                        // }
                                        if($premium_rate_details->approval_level == 'circle')
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
                                        ?>
                                    </label>
                                <?php endif; ?>
                                <?php if($petition_lm_note_details->lm_note_type == '2'): ?>

                                <?php else: ?>
                                    <label class="rasid col-sm-4">
                                        <?php
                                        if($premium_rate_details->approval_level == 'circle')
                                        {
                                            if ($presence == '') {
                                                ?>
                                                <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" onclick="return confirm('Are you sure you want to continue hearing?')"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                <?php
                                            }
                                        }
                                        else {
                                            if ($presence == '') {
                                                ?>
                                                <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" onclick="return confirm('Are you sure you want to continue hearing?')"> <?php echo $this->lang->line('continue_hearings'); ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-12">
                                <!-- <hr> -->
                                <?php
                                if($premium_rate_details->approval_level != 'circle'){
                                   
                                        ?>
                                        <?php if($petition_lm_note_details->lm_note_type == '2'): ?>

                                        <?php else: ?>
                                            <label class="rasid btn">Please Select ADC &nbsp;&nbsp;<span class="red">*</span></label>
                                            <label class="btn btn-success">
                                                <select class="form-control" name='adc_dc_code' id="adc_dc_code" required>
                                                <?php
                                                ///department case condition check
                                                if ($premium_rate_details->approval_level == 'gov') {
                                                    $loops=$adc;
                                                } else {
                                                    $loops=$adc_dc;
                                                }
                                                foreach ($loops as $dcadc) {
                                                        $user_desig_code = $dcadc->user_desig_code;
                                                        $username = $dcadc->username." ( ".$user_desig_code." )";
                                                        $user_code = $dcadc->user_code;
                                                        echo "<option value='$user_code'>$username</option>";
                                                    }
                                                ?>
                                                </select>
                                            </label>
                                        <?php endif ?>

                                        <?php
                                    
                                }
                                ?>
                            </div>
                        </div>     
                    </form>
                    <hr style="border-bottom: 2px solid #000;">
                    <?php
                        // if($basundhar_application){
                        //     echo '<h6 class="red">Other Attachments</h6>';
                        //     foreach ($basundhara_attachment  as $attachment):
                        //     ?>
                        <!--         <p><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red fs-6" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></p> -->
                             <?php 
                        //     endforeach; 
                        // }
                        // else{
                        //     echo '<h6 class="red">Other Attachments</h6>';
                        //     foreach($supportive_documents as $docs):
                        //     ?>
                        <!-- //         <p><a class="red fs-6" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></p> -->
                             <?php
                        //     endforeach;
                        // }
                    ?>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <?php $buttonEnabledFlag =1; 
                    if($buttonEnabledFlag) { ?>
                        <?php if($petition_lm_note_details->land_trans_yn != 'N') { ?>
                            <?php if(ENABLE_BUTTON_CO_ACTION_AP != 0){?>
                                <?php if($petition_lm_note_details->lm_note_type == '2'): ?>
                                    <p style="color:red; margin-right: 1rem;">This is a "Not Recommended" Case by LRA</p>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$petition_basic->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <?php else: ?>
                                    <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                                <?php endif; ?>
                        <?php } } else { ?>
                            <?php if($patta_type_details->type_code == '0208') { ?>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$petition_basic->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <p style="color:red;">Nisfi Kheraz with non transferred land</p>
                            <?php } else { ?>
                                <?php if(ENABLE_BUTTON_CO_ACTION_AP != 0){?>
                                    <?php if($petition_lm_note_details->lm_note_type == '2'): ?>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$petition_basic->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                    <?php else: ?>
                                        <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                                    <?php endif ?>
                            <?php } } ?>
                        <?php } ?>
                        <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                        <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '#mainFormSubmit', (e) => {
        var case_no = $('#case_no').val();
        var co_notice = $('#co_notice').val();
        var hearing_date = $('#hearing_date').val();
        var order_type = $('input[name="order_type"]:checked').val();
        if(case_no == '' || co_notice == '' || hearing_date == '' || order_type == '' || co_notice == undefined || hearing_date == undefined || order_type == undefined) {
            swal.fire("", "Required Parameters are empty", "error")
            .then((value) => {
                
            });
            return false;
        }
        if(order_type == "re_lm_note") {
            var co_reason_note = $('#co_reason_note').val();
            var re_hearing_date = $('#re_hearing_date').val();
            if(co_reason_note == '' || re_hearing_date == '' || co_reason_note == undefined || re_hearing_date == undefined) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {
                    
                });
                return false;
            }
        }
        else if (order_type == "forwardtodc") {
            var adc_dc_code = $('#adc_dc_code').val();
            if(adc_dc_code == '' || adc_dc_code == undefined) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {
                    
                });
                return false;
            }
        }

        var form = document.getElementById("mainform");
        console.log(form);
        var formData = new FormData(form);
        var baseurl = $('#baseurl').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/co_second_proceeding_post',
            method: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.status == 'SUCCESS') {
                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if (response.status == 'FAILED') {
                    swal.fire("", response.msg, "error;")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(err) {
                $.unblockUI();
                console.log(err);
            }
        });

        
        console.log(order_type);
    });

    $("input[name='order_type']").click(function() {
        if($(this).val() == 're_lm_note') {
            if(confirm('Are you sure you want Lot Mondol to rewrite report?')) {
                $('#show_div').hide();
                $('#re_lm_note').show();
                // $('#re_lm_note1').show();
            }
            else{
                $(this).prop('checked', false);
                $('#re_lm_note').hide();
                // $('#re_lm_note1').hide();
                $('#show_div').show();
                $('#co_reason_note').val('');
                $('#re_hearing_date').val('');
            }
        }
        else{
            $('#re_lm_note').hide();
            // $('#re_lm_note1').hide();
            $('#show_div').show();
            $('#co_reason_note').val('');
            $('#re_hearing_date').val('');
        }
    });



    // $('.btn-file').on('click', (e)=>{
    //     console.log(e.currentTarget.id);
    // });
</script>
