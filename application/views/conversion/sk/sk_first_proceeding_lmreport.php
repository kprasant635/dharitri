
<div class="row mt-2">
    <div class="col-md-12 col-lg-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-center">
                <h5>LM Report for                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php echo $this->lang->line('case_no'); ?> :<?php echo $petition_basic->case_no; ?></h5>
            </div>
            <div class="card-body">

            <div class="row">
                    <div class="col-md-12">
                    <table width="100%" class="table table-striped table-bordered" style=" overflow:auto;">
                        <thead style="white-space:nowrap; ">
                            <tr class="text-bold table-success">
                                <th align='center'>#</th>
                                <th>Applicant Name</th>
                                <th>Guardian Name</th>
                                <th>Relation</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="applicant_table_show_conv">
                            <?php
                                $i = 1;
                                foreach ($pattadars as $row): //get pattadar list
                                ?>
																			                                    <tr>
																			                                        <td align='center'><?php echo $i ?></td>
																			                                        <td><?php echo $row->pdar_name ?></td>
																			                                        <td><?php echo $row->pdar_guardian ?></td>
																			                                        <td><?php echo $this->utilityclass->get_relation($row->pdar_rel_guar) ?></td>
																			                                        <td><?php echo $this->utilityclass->gender($row->pdar_gender) ?></td>
																			                                        <td><?php echo $row->pdar_add1 ?> <br><?php echo $row->pdar_add2 ?></td>
																			                                        <td>
																			                                            <?php
                                                                                                                                foreach ($unique_pattadars as $pid): //get duplicate pdar_id
                                                                                                                                    if ($row->pdar_id == $pid->pdar_id) {
                                                                                                                                    ?>
																																						                                                    <button type="button"
																																						                                                    id="<?php echo $row->pdar_id ?>,<?php echo $row->pdar_cron_no ?>,<?php echo $pid->dag_no ?>,<?php echo $pid->patta_no ?>,<?php echo $pid->dist_code ?>,<?php echo $pid->subdiv_code ?>,<?php echo $pid->cir_code ?>,<?php echo $pid->mouza_pargona_code ?>,<?php echo $pid->lot_no ?>,<?php echo $pid->vill_townprt_code ?>,<?php echo $pid->patta_type_code ?>"
																																						                                                    class="btn btn-sm btn-danger btnDelApplConv">
																																						                                                    <i class="fa fa-trash"></i></button>

																																						                                            <?php }
                                                                                                                                                                                                            endforeach; //end of get duplicate pdar_id                    
                                                                                                                                                                                                        ?>
																			                                        </td>
																			                                    </tr>
																			                            <?php
                                                                                                                $i++;
                                                                                                            endforeach; //end of get pattadar list
                                                                                                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->applicant_patta_yn == 'Y') {
                                                echo "আছে";
                                            } else {
                                                echo "নাই";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->occupied_yn == 'Y') {
                                                echo "আছে";
                                            } else {
                                                echo "নাই";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->val_tree_yn == 'Y') {
                                                echo "আছে";
                                            } else {
                                                echo "নাই";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $land_class_details->land_type; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->issuit_forconv_under105 == 'Y') {
                                                echo "হয়";
                                            } else {
                                                echo "নহয়";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))): ?>
                                            <label class="control-label" >৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ -<?php echo $petition_lm_note_details->roadside_rsv_b; ?> বিঃ,<?php echo $petition_lm_note_details->roadside_rsv_k; ?> কঃ,<?php echo $petition_lm_note_details->roadside_rsv_lc; ?> লেঃ </label>
                                        <?php else: ?>
                                            <label class="control-label" >৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ -<?php echo $petition_lm_note_details->roadside_rsv_b; ?> বিঃ,<?php echo $petition_lm_note_details->roadside_rsv_k; ?> কঃ,<?php echo $petition_lm_note_details->roadside_rsv_lc; ?> ছ
                                            <?php echo $petition_lm_note_details->roadside_rsv_g; ?> গো</label>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ৭) উক্ত মাটি ভূমি নিতীৰ মতে নদীৰ কাষৰ মাটি &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->near_river_yn == 'Y') {
                                                echo "হয়";
                                            } else {
                                                echo "নহয়";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / শাৰিৰীক ভাবে অক্ষম হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label>
                                        <ul>
                                        <?php
                                            if (($petition_lm_note_details->jati_janajati_yn == '0' || $petition_lm_note_details->jati_janajati_yn == null) && ($petition_lm_note_details->freedom_fighter_yn == '0' || $petition_lm_note_details->freedom_fighter_yn == null) && ($petition_lm_note_details->widow_yn == '0' || $petition_lm_note_details->widow_yn == null)) {
                                                echo " - এই আবেদনত উপযোগী নহয় |";
                                                $msg = "";
                                            } else {
                                                // $msg="২৫% ৰেহাই পাচত";
                                                $msg = "";
                                            }
                                            if ($petition_lm_note_details->jati_janajati_yn == 'Y') {
                                                echo '<li>
                                                <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                <div id="jati_janajatie" class="alert alert-info">';
                                            ?>
                                                <!-- echo file_get_contents(base_url($file_path_location)); -->
                                                    <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="<?php echo base_url(UPLOAD_BASE_CONVERSIONDOCS . '/' . $petition_lm_note_details->jati_janajati_upload); ?>" data-path="<?php echo search_file_location('ConversionDocs/' . $petition_lm_note_details->jati_janajati_upload); ?>" class="preview__file" target="_blank">View</a></span>
                                                <?php
                                                    echo '</div>
                                            </li>';
                                                    }
                                                    if ($petition_lm_note_details->freedom_fighter_yn == 'Y') {
                                                        echo '<li>
                                                <label class="control-label" >খ. শাৰিৰীক ভাবে অক্ষম হয় &nbsp;</label>
                                                <div id="jati_janajatie" class="alert alert-info">';
                                                    ?>
                                                    <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="<?php echo base_url(UPLOAD_BASE_CONVERSIONDOCS . '/' . $petition_lm_note_details->freedom_fighter_upload); ?>" data-path="<?php echo search_file_location('ConversionDocs/' . $petition_lm_note_details->freedom_fighter_upload); ?>" class="preview__file" target="_blank">View</a></span>
                                                <?php
                                                    echo '</div>
                                            </li>';
                                                    }
                                                    if ($petition_lm_note_details->widow_yn == 'Y') {
                                                        echo '<li>
                                                <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                <div id="jati_janajatie" class="alert alert-info">';
                                                    ?>
                                                    <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="<?php echo base_url(UPLOAD_BASE_CONVERSIONDOCS . '/' . $petition_lm_note_details->widow_upload); ?>"  class="preview__file" target="_blank">View</a></span>
                                                <?php
                                                    echo '</div>
                                            </li>';
                                                    }
                                                ?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                    <?php if ($rtps_tag == BASUNDHARA_CHECK) {?>

                                        <label class="control-label" >
                                            ৯)
                                            <?php
                                                echo $conversion_areas->ass_name . ' - হয়';
                                                    // if ($petition_lm_note_details->dist_frm_town == '0') {
                                                    //     echo "অবেদিত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে ? - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'd')) {
                                                    //     echo "অবেদিত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '3') && ($petition_lm_note_details->inside_outside_town == 'i')) {
                                                    //     echo "উক্ত মাটি জিলা মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধি অঞ্চল মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '1') && ($petition_lm_note_details->inside_outside_town == 'o')) {
                                                    //     echo "উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ
                                                    //     পৰিধি অঞ্চল মাটি হয়নে  - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '15') && ($petition_lm_note_details->inside_outside_town == 'i')) {
                                                    //     echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে ? - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'o')) {
                                                    //     echo "অবেদিত মাটি গাওৰ মাটি হয়নে - হয়";
                                                    // } elseif ($petition_lm_note_details->dist_frm_town == '1') {
                                                    //     echo "উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে - হয়";
                                                // }
                                                 ?></label>
                                        <?php } else {?>
                                            <label class="control-label" >
                                            ৯)
                                            <?php
                                                echo $conversion_areas->ass_name . ' - হয়';
                                                    // if (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'o')) {
                                                    //     echo "উক্ত মাটি গাওঁৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'i')) {
                                                    //     echo "অবেদিত মাটি নগৰ/চহৰৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'r')) {
                                                    //     echo "অবেদিত মাটি ৰাজহ নগৰ মাটি হয়নে - হয়";
                                                    // } elseif ($petition_lm_note_details->dist_frm_town == '3') {
                                                    //     echo "অবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'd')) {
                                                    //     echo "অবেদিত মাটি জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '5') && ($petition_lm_note_details->inside_outside_town == 'i')) {
                                                    //     echo "অবেদিত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'm')) {
                                                    //     echo "অবেদিত মাটি পৌৰ নগৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '5') && ($petition_lm_note_details->inside_outside_town == 'm')) {
                                                    //     echo "অবেদিত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'g')) {
                                                    //     echo "অবেদিত মাটি গুৱাহাটী মহানগৰী মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '15') && ($petition_lm_note_details->inside_outside_town == 'g')) {
                                                    //     echo "অবেদিত মাটি গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '15') && ($petition_lm_note_details->inside_outside_town != 'g')) {
                                                    //     echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা সদৰ, উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে - হয়";
                                                    // } elseif (($petition_lm_note_details->dist_frm_town == '10') && ($petition_lm_note_details->inside_outside_town == 'i')) {
                                                    //     echo "অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                    // }
                                                 ?>
                                            </label>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                        <?php
                                            if ($conversion_rates->amount != 0 && $conversion_rates->rate == 0) {
                                                $bigha_prem = $conversion_rates->amount;
                                            } else if ($conversion_rates->amount == 0 && $conversion_rates->rate != 0) {
                                                $bigha_prem = $petition_lm_note_details->prim_per_bigha * ($conversion_rates->rate / 100);
                                            }
                                            // if ((($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'o')) || (($petition_lm_note_details->dist_frm_town == '5') && ($petition_lm_note_details->inside_outside_town == 'm')) || (($petition_lm_note_details->dist_frm_town == '0') && ($petition_lm_note_details->inside_outside_town == 'r')) || ($petition_lm_note_details->dist_frm_town == '3') || (($petition_lm_note_details->dist_frm_town == '5') && ($petition_lm_note_details->inside_outside_town == 'm'))) {//rural, 5km, rajah, 3 km
                                            //         if (trim($petition_lm_note_details->premium_assesment) == '40' || trim($petition_lm_note_details->premium_assesment) == '20') {
                                            //             $bigha_prem=$petition_lm_note_details->premium_assesment;
                                            //         }else {
                                            //             $bigha_prem = $petition_lm_note_details->prim_per_bigha;
                                            //         }
                                            //     }else{
                                            //         $bigha_prem = $petition_lm_note_details->prim_per_bigha;
                                            //     }

                                        ?>

                                        <label class="control-label" >১০) বিঘাই প্রতি <span style="color: red;"><?php echo $petition_lm_note_details->lm_note_type == 1 || $petition_lm_note_details->lm_note_type == null ? $bigha_prem : 'Not Recommeded' ?></span> টকা (Zonal value=> Rs.<?php echo $petition_lm_note_details->lm_note_type == 1 || $petition_lm_note_details->lm_note_type == null ? $petition_lm_note_details->prim_per_bigha : 'Not Recommended' ?>/-) হাৰে <span style="color: red;"><?php echo $petition_lm_note_details->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $petition_lm_note_details->conv_k; ?></span> কঃ
                                        <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))): ?>
                                            <span style="color: red;"><?php echo $petition_lm_note_details->conv_lc; ?></span> লেঃ
                                        <?php else: ?>
                                            <span style="color: red;"><?php echo $petition_lm_note_details->conv_lc; ?></span> ছ
                                            <span style="color: red;"><?php echo $petition_lm_note_details->conv_g; ?></span> গো
                                        <?php endif; ?>
                                        মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg . " " . $petition_lm_note_details->lm_note_type == 1 || $petition_lm_note_details->lm_note_type == null ? $petition_lm_note_details->prim_tot : 'Not Recommended'; ?></span> টকা  &nbsp; <a href="<?php echo base_url(); ?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%"><label class="control-label" >১১) ভূমিলেখ্য সহায়কৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                    <td><label class="control-label" ><?php echo $petition_lm_note_details->partition_info; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >
                                        ১২) ভূমিলেখ্য সহায়ক ৰ চহী &nbsp; -
                                        <?php
                                            if ($petition_lm_note_details->lm_sign_yn == 'Y') {
                                                echo "আছে";
                                            } else {
                                                echo "নাই";
                                        }
                                        ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >১৩) ভূমিলেখ্য সহায়কৰ নাম &nbsp; -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo $lm_details->lm_name; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >১৪) ভূমিলেখ্য সহায়ক এ টোকা লিখাৰ তাৰিখ &nbsp; -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php echo date('d-m-Y', strtotime($petition_lm_note_details->date_entry)); ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="control-label" >১৫) স্থানান্তৰ নকৰা কালি -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $petition_lm_note_details->partial_untrans_b; ?> বিঃ,<?php echo $petition_lm_note_details->partial_untrans_k; ?> কঃ,
                                    <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))): ?>
<?php echo $petition_lm_note_details->partial_untrans_lc; ?> লেঃ </label></td>
                                    <?php else: ?>
<?php echo $petition_lm_note_details->partial_untrans_lc; ?> ছ
                                        <?php echo $petition_lm_note_details->partial_untrans_g; ?> গো </label></td>
                                    <?php endif; ?>
                                </tr>
                                <?php if ($patta_type_details->type_code == '0208'): ?>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label">১৬) Is the Nisfi Kheraz Land Transferred? -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php if ($petition_lm_note_details->land_trans_yn == 'Y') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     echo 'হয়';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 echo 'নহয়';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             }?></label>
                                        <label class="control-label" ><a href="<?php echo base_url(); ?>assets/nisfi_kheraz_notice.pdf" target="_blank">View Nisfi Kheraz Notice </a></label>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Input for case number -->
                        <input type="hidden" id="case_no" value="<?php echo $petition_basic->case_no; ?>" placeholder="Enter Case Number">
                        <!-- <button id="fetchFiles">Fetch Files</button> -->

                        <!-- Display list of files -->
                        <table width="100%" class="table table-striped table-bordered" style=" overflow:auto;">
                            <thead>
                                <tr>
                                    View Files Uploaded by LRA
                                </tr>
                            </thead>
                            <tbody style="white-space:nowrap;" id="fileList">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery CDN (include this if not already included) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
  function loadFiles(caseNo) {
    if (!caseNo) {
      $('#fileList').html('<li>No case number provided.</li>');
      return;
    }

    // if baseurl doesnot have index.php then add it to base url
    if (!baseurl.includes("index.php")) {
        if (!baseurl.endsWith("/")) {
            baseurl += "/";
        }
        baseurl += "index.php/";
    }

    console.log("Loading files for case " + caseNo);



    $.ajax({
      url: baseurl + 'get-lra-files', // Replace with your real backend route
      type: 'GET',
      data: { case_no: caseNo },
      success: function (response) {
        console.log(response);
        $('#fileList').empty();

        if (!response || response.length === 0) {
          $('#fileList').append('<li>No files found for this case.</li>');
          return;
        }

       response.forEach(function(file) {
  const dagInfo = file.dag_no
    ? `<span class="alert-danger"><small> for Dag no: <strong>${file.dag_no}</strong></small></span>`
    : '';

  $('#fileList').append(`
    <tr>
      <th>
        <a target="_blank" href="${baseurl}${file.file_path}">
          <i class="fa fa-paperclip"></i> ${file.file_name}
          ${dagInfo}
        </a>
      </th>
    </tr>
  `);
        });
      },
      error: function () {
        $('#fileList').html('<li>Error loading files.</li>');
      }
    });
  }

  // Automatically call on DOM ready
  $(document).ready(function () {
    console.log("Leading....    ");
    const caseNo = $('#case_no').val(); // Or set manually
    loadFiles(caseNo);
  });
</script>