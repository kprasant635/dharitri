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
                <div class="card-header text-center">
                    <h5>CO Report For Case No. <?php echo $petition_basic->case_no; ?></h5>
                </div>
                <div class="card-body">
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
                                            // $prem_percent=$petition_lm_note_details->premium_assesment.((trim($petition_lm_note_details->premium_assesment)=='40') || (trim($petition_lm_note_details->premium_assesment)=='20') ? ' টকা ': ' % ');

                                        if (($petition_lm_note_details->jati_janajati_yn != 'Y') && ($petition_lm_note_details->freedom_fighter_yn != 'Y') && ($petition_lm_note_details->widow_yn != 'Y'))
                                        {
                                            $msg="";
                                        }
                                        else{
                                            $msg="আৰু ২৫% ৰেহাই পাচত";
                                        }
                                        
                                        if($premium_rate_details->approval_level == 'circle')
                                        {
                                            if ($presence == '') {
                                                ?>
                                                লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                ?> 
                                                জমী হয় |<br><br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
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
                                                
                                                <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে | প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ 
                                                <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                    }
                                                    else {
                                                        echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                    }
                                                    
                                                ?> জমী হয় |<br><br>
                                                লাঃমঃ ৰ প্ৰতিবেদনৰ মতে নিৰ্দ্ধাৰিত প্ৰিমিয়াম আদায় সাপেক্ষে আবেদিত জমীৰ ম্যাদীকৰন হুকুম দিব পৰা যায় |<br><br>
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
                                                <?php
                                            } else {
                                                ?>
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
                                        else{
                                            $msg_report = $premium_area_details->ass_name;
                                            // if(($petition_lm_note_details->dist_frm_town==3) && ($petition_lm_note_details->inside_outside_town=='i'))
                                            // {
                                            //     $msg_report = "চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয় | ";
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
                                            লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                            <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                }
                                                
                                            ?> 
                                            জমী হয় | <br>
                                            লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্যৰ <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                            <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>   
                                            
                                            <input type="hidden" name="co_notice" id="co_notice" class="form-control" value="লাঃমঃ/চুঃকাঃই প্ৰতিবেদন দাখিল কৰিছে |  প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাওঁৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা 
                                            <?php
                                                if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                    echo $petition_dag_details->m_dag_area_lc . ' লেছা';
                                                }
                                                else {
                                                    echo $petition_dag_details->m_dag_area_lc . ' ছটাক ' . $petition_dag_details->m_dag_area_g . ' গোণ্ডা';
                                                } 
                                            ?> 
                                            জমী হয় | <br>
                                            লাঃমঃ ৰ প্ৰতিবেদনৰ মতে এই মাটি <?php echo $msg_report; ?> সেয়েহে ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি আৰু অসম চৰকাৰৰ শেহতীয়া নিৰ্দ্দশণ অনুমতি প্ৰতি বিঘা মাঢিৰ মান্ডলিক মুল্য <span style='color:red;'><?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> প্ৰিমিয়াম আদায় মৰ্মে অবেদিত জমীত ম্যদীকৰন কৰিব পৰা যায় । বিহিত ব্যৱস্থাৰ বাবে দাখিল কৰা হ'ল ।
                                            <br><span style='float:right;margin-right:50px; text-align: center'><?php echo $co_details->username; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></span>"/>
                                            <?php
                                        }

                                        ?>
                                    </td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                        
                       
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

</script>
