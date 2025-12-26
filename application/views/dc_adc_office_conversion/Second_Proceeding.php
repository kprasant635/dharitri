<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">DC / ADC's Conversion Order</h2>
                </div>
            </div>
            <div class="col-lg-12">
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
                        <form class="" method='post' action="<?php echo base_url($post_url); ?>">
                        <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                            <table class='table table-striped table-bordered rasid-t' style="font-size: 20px;">
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    foreach ($premium as $p) {
                                        $presence = $p->prem_pay_method;
                                    }
                                    foreach ($lm_details_final as $lm):
                                        $p=round($lm->prim_per_bigha, 2);
                                        $pt=round($lm->prim_tot, 2);
                                        if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
                                            if ((($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'o')) || (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm')) || (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'r')) || ($lm->dist_frm_town == '3') || (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm'))) {
                                                if (trim($lm->premium_assesment) == '40' || trim($lm->premium_assesment) == '20') {
                                                    $prem_percent="বিঘাই প্রতি ".$lm->premium_assesment." টকা";
                                                }else{
                                                    $prem_percent=$lm->premium_assesment." %";
                                                }
                                            }else{
                                                $prem_percent=$lm->premium_assesment." %";
                                            }
                                        }
                                        else if($lm_details['premium_new_yn'] == 1) {
                                            if($conversion_premium_rate->amount != 0 && $conversion_premium_rate->rate == 0) {
                                                $prem_percent = 'বিঘাই প্রতি ' . $conversion_premium_rate->amount . ' টকা';
                                            }
                                            else if ($conversion_premium_rate->amount == 0 && $conversion_premium_rate->rate != 0) {
                                                $prem_percent = $conversion_premium_rate->rate . ' %';
                                            }
                                        }

                                    endforeach;
                                    if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                    {
                                        $msg="";
                                        $abedon_kari="";
                                    }
                                    else{
                                        $msg="আৰু ২৫% ৰেহাই পাচত";
                                        $abedon_kari="এই মাটিৰ আবেদনকাৰী";
                                    }
                                    $jati_janajati='';
                                    $freedom_fighter='';
                                    $widow='';
                                    if($lm_details_final[0]->jati_janajati_yn == 'Y'){
                                        $jati_janajati='অনুসুচিত জাতি / জনজাতি জনা যায় |';
                                    }
                                    if($lm_details_final[0]->freedom_fighter_yn == 'Y'){
                                        $freedom_fighter='ভূমিহীণ মুক্তিযোদ্ধা জনা যায় |';
                                    }
                                    if($lm_details_final[0]->widow_yn == 'Y'){
                                        $widow='বিধবা হয় যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই |';
                                    }
                                    
                                    
                                    
                                    if ($presence == '') {
                                        ?>
                                        লাঃমঃ/চুঃকাঃ/চক্ৰ বিষয়া/শাখা বিষয়াৰ প্ৰতিবেদন চোৱা হ’ল ৷ <?php echo $abedon_kari." ".$jati_janajati." ".$freedom_fighter." ".$widow;?> প্ৰতিবেদন পৰীক্ষণ মৰ্মে ম্যাদীকৰণৰ বাবে আবেদিত জমী অসম ভূমিলেখ্য নিয়মাৱলী, 
                                        ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি উপযুক্ত বিবেচিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                        <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> 
                                            নং দাগৰ</span> <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণ প্ৰিমিয়াম মাটিৰ মান্ডলিক মুল্যৰ <span style='color:red;'> <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷<br>
                                        <span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br><?php echo $location['add_off_designation']; ?>, <?php echo $location['dist']; ?></span>
                                        
                                        <input type="hidden" name="dc_adc_notice" class="form-control" value="লাঃমঃ/চুঃকাঃ/চক্ৰ বিষয়া/শাখা বিষয়াৰ প্ৰতিবেদন চোৱা হ’ল ৷ প্ৰতিবেদন পৰীক্ষণ মৰ্মে ম্যাদীকৰণৰ বাবে আবেদিত জমী অসম ভূমিলেখ্য নিয়মাৱলী, ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি উপযুক্ত বিবেচিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ</span> <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণ প্ৰিমিয়াম মাটিৰ মান্ডলিক মুল্যৰ <span style='color:red;'> <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা</span> আদায়ৰ হুকুম দিয়া হ’ল ৷ আবেদনকাৰীক প্ৰিমিয়াম আদায়ৰ বাবে অবগত কৰোৱা হওঁক ৷<br>
                                        <span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br><?php echo $location['add_off_designation']; ?>, <?php echo $location['dist']; ?></span>"/>
                                        <?php
                                    } else {
                                        If(($lm_details_final[0]->applicant_patta_yn=='Y') && ($lm_details_final[0]->occupied_yn=='Y'))
                                        {
                                            $applicants_patta_occupied="আবেদন কৰা মাটি আবেদনকাৰীৰ পট্টাৰ মাটি বা দখলত থকা মাটি হয় |";
                                        }
                                        else{
                                            $applicants_patta_occupied="আবেদন কৰা মাটি আবেদনকাৰীৰ পট্টাৰ মাটি বা দখলত থকা মাটি নহয় |";
                                        }
                                        If(($lm_details_final[0]->val_tree_yn=='Y'))
                                        {
                                            $val_tree_yn = "এই মাটি ". $lm_details['land_class_code']. "মাটি হ'য় আৰু ইয়াত মূল্যবান গছ-গছনি আছে |";
                                        }
                                        else{
                                            $val_tree_yn = "এই মাটি ". $lm_details['land_class_code']. "মাটি হ'য় আৰু ইয়াত মূল্যবান গছ-গছনি নাই |";
                                        }
                                        
                                        If(($lm_details_final[0]->roadside_rsv_b !='0')||($lm_details_final[0]->roadside_rsv_k !='0')||($lm_details_final[0]->roadside_rsv_lc !='0'))
                                        {
                                            $roadside = "উক্ত মাটিৰ ৰাস্তাৰ কাষৰ সংৰক্ষণ ".$lm_details_final[0]->roadside_rsv_b. " বিঃ, ".$lm_details_final[0]->roadside_rsv_k." কঃ, ".$lm_details_final[0]->roadside_rsv_lc." লেঃ |";
                                        }
                                        else{
                                            $roadside = "উক্ত মাটিৰ ৰাস্তাৰ কাষৰ সংৰক্ষণ নাই |";
                                        }
                                        If(($lm_details_final[0]->near_river_yn=='Y'))
                                        {
                                            $riverside = "এই মাটি নদীৰ কাষৰ মাটি হয় |";
                                        }
                                        else{
                                            $riverside = "এই মাটি নদীৰ কাষৰ মাটি নহয় |";
                                        }
                                        
                                        ?>
                                        চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰই দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> 
                                        নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ/চক্ৰ বিষয়া/শাখা বিষয়াই এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷ 
                                        <?php echo $abedon_kari." ".$jati_janajati." ".$freedom_fighter." ".$widow;?> <?php echo $applicants_patta_occupied." ".$val_tree_yn." ".$roadside." ".$riverside; ?>
                                        অসম ভুমিলেখ্য নিয়মাৱলী 
                                        ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে উপযুক্ত বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত 
                                        হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ 
                                        <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> 
                                            নং দাগৰ</span> <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা 
                                                <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণ প্ৰিমিয়াম মাটিৰ মান্ডলিক মুল্যৰ <span style='color:red;'> 
                                                    <?php echo $prem_percent; ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $pt; ?> টকা |</span> 
                                                এই জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br>
                                        <span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br><?php echo $location['add_off_designation']; ?>, <?php echo $location['dist']; ?></span>
                                        
                                        <input type="hidden" name="dc_adc_notice" class="form-control" value="চক্ৰ বিষয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰই দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰণৰ প্ৰস্তাৱ আৰু লাঃমঃ/চুঃকাঃ/চক্ৰ বিষয়া/শাখা বিষয়াই এই প্ৰস্তাৱ সন্দৰ্ভত দাখিল কৰা প্ৰতিবেদন চোৱা হ’ল ৷<?php echo $abedon_kari." ".$jati_janajati." ".$freedom_fighter." ".$widow;?> <?php echo $applicants_patta_occupied." ".$val_tree_yn." ".$roadside." ".$riverside; ?> অসম ভুমিলেখ্য নিয়মাৱলী ১৯০৬ৰ ১০৫ নং নিয়ম অনুসৰি ম্যাদীকৰণৰ বাবে উপযুক্ত বিবেচিত হোৱাত তথা অসম চৰকাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত হাৰত প্ৰিমিয়াম আদায় নিশ্চিত হোৱাত <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ</span> <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণৰ হুকুম দিয়া হ’ল ৷<br>
                                        <span style='float:right;margin-right:50px; text-align: center'><?php echo $location['add_to']; ?><br><?php echo $location['add_off_designation']; ?>, <?php echo $location['dist']; ?></span>"/>
                                        
                                        <?php
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <!-- check current user is dc/adc  -->
                                <?php
                                    $display_type="";
                                    if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
                                        if(($lm_details_final[0]->inside_outside_town=='d') || ($lm_details_final[0]->inside_outside_town=='r' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='m' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='g' && $lm_details_final[0]->dist_frm_town=='0')){
                                        
                                            if($petition_basic->dept_note_yn !='Y'){
                                                $add_off_desig_session = $this->session->userdata('user_desig_code');
                                                if(trim($add_off_desig_session)=='ADC') {
                                                    $display_type="none";
                                            ?>
                                    
    
                                            <tr colspa="2">
                                                <td colspan="2" class="text-center">
                                                <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion/PassToDc?case_no=<?php echo $location['case_no']."&dist_code=".$petition_basic->dist_code."&subdiv_code=".$petition_basic->subdiv_code."&cir_code=".$petition_basic->cir_code."&mouza_pargona_code=".$petition_basic->mouza_pargona_code."&lot_no=".$petition_basic->lot_no."&vill_townprt_code=".$petition_basic->vill_townprt_code; ?>">Forward To DC</a>
                                            </td>
    
                                        </tr>
                                        <?php } else{
                                                $display_type="";
                                        }
                                        } }
                                    }
                                    else {
                                        if($petition_basic->dept_note_yn !='Y'){
                                            $add_off_desig_session = $this->session->userdata('user_desig_code');
                                            if(trim($add_off_desig_session)=='ADC') {
                                                $display_type="none";
                                        ?>
                                

                                            <tr colspa="2">
                                                <td colspan="2" class="text-center">
                                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion/PassToDc?case_no=<?php echo $location['case_no']."&dist_code=".$petition_basic->dist_code."&subdiv_code=".$petition_basic->subdiv_code."&cir_code=".$petition_basic->cir_code."&mouza_pargona_code=".$petition_basic->mouza_pargona_code."&lot_no=".$petition_basic->lot_no."&vill_townprt_code=".$petition_basic->vill_townprt_code; ?>">Forward To DC</a>
                                                </td>

                                            </tr>
                                            <?php } else{
                                                    $display_type="";
                                            }
                                        }
                                    }
                                     ?>
                                <tr style="display:<?=$display_type?>">
                                    <td colspan="2">
                                        <?php
                                        if ($presence == '') {
                                            ?>
                                            <label class="control-label"><?php echo $this->lang->line('next_hearing_date'); ?> &nbsp;
                                                <input type="text" name="hearing_date" id="popupDatepicker" style="width: 200px;" readonly required>
                                                &nbsp; (dd/mm/yyyy)</label> 
                                            <?php
                                        } else {
                                            ?>
                                            <label class="control-label"><?php echo $this->lang->line('final_order_date'); ?> &nbsp;
                                                <input type="text" name="hearing_date" id="popupDatepicker" style="width: 200px;" required>
                                                &nbsp; (dd/mm/yyyy)</label> 
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if(!empty($dept_order)) { ?>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label">Dept Order No: &nbsp;
                                                    <?php echo $petition_basic->dept_order_no; ?></label> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label">Dept Note: &nbsp;
                                                    <?php echo $dept_order->note_on_order; ?></label> 
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr style="display:<?=$display_type?>">
                                    <td colspan="2" style="text-align: center;">
                                    <?php $is_dept=0;
                                    if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
                                        if((($lm_details_final[0]->inside_outside_town=='d') || ($lm_details_final[0]->inside_outside_town=='r' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='m' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='g' && $lm_details_final[0]->dist_frm_town=='0')) ){
                                            if($petition_basic->dept_note_yn !='Y'){
                                                $is_dept=1;
                                            ?>
                                            <label class="control-label">
                                                <?php
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="checkbox" id="frwd_dept" name='frwd_dept' value="Y" required>
                                                    <?php
                                                } 
                                                ?>
                                                Forward to Dept &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
                                        <?php } else { ?>
    
                                            <label class="control-label">
                                                <?php
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="checkbox" id="remove" name='prepare_premium' value="Y" required>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="checkbox" id="inlineCheckbox1" name='prepare_premium' value="Y" disabled>
                                                    <?php
                                                }
                                                ?>
                                                <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
                                            
                                        <?php } } else {  ?>
    
                                            <label class="control-label">
                                                <?php
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="checkbox" id="remove" name='prepare_premium' value="Y" required>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="checkbox" id="inlineCheckbox1" name='prepare_premium' value="Y" disabled>
                                                    <?php
                                                }
                                                ?>
                                                <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
    
                                        <?php }
                                    }
                                    else {
                                        if($conversion_premium_rate->approval_level == 'gov') {
                                            if($petition_basic->dept_note_yn !='Y'){
                                                $is_dept=1;
                                            ?>
                                            <label class="control-label">
                                                <?php
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="checkbox" id="frwd_dept" name='frwd_dept' value="Y" required>
                                                    <?php
                                                } 
                                                ?>
                                                Forward to Dept &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
                                            <?php }
                                            else { ?>
        
                                                <label class="control-label">
                                                    <?php
                                                    if ($presence == '') {
                                                        ?>
                                                        <input type="checkbox" id="remove" name='prepare_premium' value="Y" required>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <input type="checkbox" id="inlineCheckbox1" name='prepare_premium' value="Y" disabled>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </label>
                                                
                                            <?php }
                                        }
                                        else {
                                            ?>
    
                                            <label class="control-label">
                                                <?php
                                                if ($presence == '') {
                                                    ?>
                                                    <input type="checkbox" id="remove" name='prepare_premium' value="Y" required>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="checkbox" id="inlineCheckbox1" name='prepare_premium' value="Y" disabled>
                                                    <?php
                                                }
                                                ?>
                                                <?php echo $this->lang->line('generate_notice_for_premium_by_astt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
    
                                            <?php
                                        }
                                    }
                                    
                                    ?>



                                    <?php if($petition_basic->status !='W' && $petition_basic->add_off_desig !='DPT' ) { ?>
                                        <label class="control-label">
                                            <?php if($petition_basic->dept_note_yn == 'Y') { ?>
                                            <input type="checkbox" id="inlineCheckbox1 ree" name='re_co_note' value="Y" onClick="return ConfResent(this)" disabled>
                                            <?php } else { ?>
                                                <input type="checkbox" id="inlineCheckbox1 ree" name='re_co_note' value="Y" onClick="return ConfResent(this)">
                                            <?php } ?>
                                            <?php echo "Send Back for Re-verification by Circle Officer" ?> 
                                        </label>
                                        <?php }?>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="row" style="display:<?=$display_type?>">
                                <div class="col-sm-12">
                                    <!-- new department forward addition -->
                                    <label class="rasid col-sm-4">
                                        <?php
                                        $aactive_desig_session = $this->session->userdata('user_desig_code');
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        if ($presence == '') {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio1" value="finalhukum" disabled> <?php echo $this->lang->line('final_order'); ?>
                                            <?php
                                        } else {
                                            if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
                                                if(($lm_details_final[0]->inside_outside_town=='d') || ($lm_details_final[0]->inside_outside_town=='r' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='m' && $lm_details_final[0]->dist_frm_town=='0') || ($lm_details_final[0]->inside_outside_town=='g' && $lm_details_final[0]->dist_frm_town=='0')){
                                                
                                                    if($petition_basic->dept_note_yn !='Y'){
                                                    ?>
                                                    <input type="radio" name="order_type" checked id="inlineRadio1" value="frwddept" onclick="return confirm('Are you sure you want to forawd the case to Department?')"> Forward To Department
                                                    <?php 
                                                    } else {
                                                     if($aactive_desig_session=='DC'){
                                                    ?>
                                                    <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php
                                                    }
                                                    }
                                                } else {
                                                    if($aactive_desig_session=='DC'){
                                                    ?>
                                                    <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                    <?php }
                                                } 
                                            }
                                            else {
                                                if($conversion_premium_rate->approval_level == 'gov') {
                                                    if($petition_basic->dept_note_yn !='Y'){
                                                        ?>
                                                        <input type="radio" name="order_type" checked id="inlineRadio1" value="frwddept" onclick="return confirm('Are you sure you want to forawd the case to Department?')"> Forward To Department
                                                        <?php 
                                                        } else {
                                                         if($aactive_desig_session=='DC'){
                                                        ?>
                                                        <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                        <?php
                                                        }
                                                    }
                                                }
                                                else {
                                                    if($aactive_desig_session=='DC'){
                                                        ?>
                                                        <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                                        <?php }
                                                }
                                            }

                                        }
                                        ?>
                                    </label>
                                    <!-- department forward addition end -->
                                
                                    <!-- <label class="rasid col-sm-3">
                                        <?php
                                        foreach ($premium as $p) {
                                            $presence = $p->prem_pay_method;
                                        }
                                        if ($presence == '') {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio1" value="finalhukum" disabled> <?php echo $this->lang->line('final_order'); ?>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="radio" name="order_type" checked id="inlineRadio1" value="finalhukum" onclick="return confirm('Are you sure you want to pass the final order?')"> <?php echo $this->lang->line('final_order'); ?>
                                            <?php
                                        }
                                        ?>
                                    </label> -->
                                    <!-- <label class="rasid col-sm-4">
                                        <input type="radio" name="order_type" id="inlineRadio2" value="closecase" onclick="return confirm('Are you sure you want to cancel this case order?')"> <?php //echo $this->lang->line('cancel_order'); ?>
                                    </label> -->
                                    <label class="rasid col-sm-4">
                                        <?php
                                        if ($presence == '') {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="radio" name="order_type" id="inlineRadio3" value="continuehearing" onclick="return confirm('Are you sure you want to continue hearing?')" disabled> <?php echo $this->lang->line('continue_hearings'); ?>
                                            <?php
                                        }
                                        ?>

                                    </label>
                                </div>
                                <center>
                                <?php
                                if ($is_dept == 0){
                                if ($presence == '') {
                                ?>
                                <span class="red"><b>Note : Please Select the Assigning Branch Officer from the drop down below.</b></span>
                                <?php
                                }
                                ?>
                                <div class="col-lg-12">
                                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                                    <?php
                                    if ($presence == '') {
                                        
                                        ?>
                                        <label class="rasid btn">Please Select Branch Officer &nbsp;&nbsp;</label>
                                        <label class="btn btn-success">
                                            <select class="form-control" name='bo_code' required>
                                            <?php 
                                                foreach ($branch_officer as $bo) {
                                                    $user_desig_code = $bo->user_desig_code;
                                                    $username = $bo->username." ( ".$user_desig_code." )";
                                                    $user_code = $bo->user_code;
                                                    echo"<option value='$user_code'>$username</option>";
                                                }
                                            ?>
                                            </select>
                                        </label>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <?php if($petition_basic->status !='W' && $petition_basic->add_off_desig !='DPT' ) { ?>
                                    <button type="submit" name="submit" id="onsubmit" class="btn btn-danger uni_text"><i class='fa fa-check'></i>  <?php echo "Submit"; ?> </button>
                                    <?php } ?>
                                </div>
                                </center>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php
                                    if($basundharaAttachment){
                                        echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
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
                                    echo "</div>";
                                    ?>
                        </form>
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <button type="" class="btn btn-info uni_text" value="2" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;<?php echo $this->lang->line('lm_report'); ?></button>
                                <button type="" class="btn btn-active uni_text" value="3" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;  AST & CO Report</button>
                                <button type="" class="btn btn-default uni_text" value="4" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('sk_report'); ?></button>
                                <button type="" class="btn btn-primary uni_text" value="6" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; BO Report</button>
                                <button type="" class="btn btn-warning uni_text" value="5" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('view_premiun_report'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=2"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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
                                                <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=4&dist=" . $l_data['dist_code'] ."&sub_div=".$l_data['subdiv_code']."&cir=".$l_data['cir_code']."&m=".$l_data['mouza_pargona_code']."&l=".$l_data['lot_no']."&v=".$l_data['vill_code']."&p=".$land_details['patta_type']."&dag=".$land_details['dag']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
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
                                                </tr>
                                            </thead>
                                            <?php $count = 1; ?>
                                            <?php
                                            foreach ($pattadar as $p):
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
                                                            <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ </label>
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
                                                                if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                                                {
                                                                    $msg="";
                                                                    echo " - এই আবেদনত উপযোগী নহয় |";
                                                                }
                                                                else{
                                                                    $msg="আৰু ২৫% ৰেহাই পাচত";
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
                                                                <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?=round($bigha_prem, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা</label>
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
                                                                    if (($lm->jati_janajati_yn != 'Y') && ($lm->freedom_fighter_yn != 'Y') && ($lm->widow_yn != 'Y'))
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
                                                                    <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?=round($bigha_prem, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা</label>
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
                            <!--div 6-->            
                            <div id="notice6" style='display: none'>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <p class='center bold uni_text'><u>BRANCH OFFICER REPORT</u></p>
                                        <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                                        <br>
                                        <p class='center bold uni_text'><span class="">Order Sheet, dated from <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['date'])); ?></span> To <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['next_date'])); ?></span> District <?php echo $location['dist']; ?> <br>
                                                Case No <?php echo $location['case_no']; ?></span></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                            <table class='table table-striped unicode'>
                                                <?php
                                                if (count($bo_details_final) != 0) {
                                                    foreach ($bo_details_final as $bo):
                                                        ?>
                                                <?php
                                                if ((($bo_details['dist_frm_town'] == 3) && ($bo_details['inside_outside_town'] == 'i')) || (($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'm'))) {
                                                    //"This is within 3km from the boundry of town.";
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                        <?php if($bo_details['dist_frm_town'] == 3) { ?>
                                                            <label class="control-label" >A. ১) অবেদিত মাটি চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp;</label>
                                                        <?php } elseif(($bo_details['dist_frm_town'] == 5) && ($bo_details['inside_outside_town'] == 'i')) { ?>
                                                            <label class="control-label" >A. ১) অবেদিত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ? </label>
                                                        <?php } elseif(($bo_details['dist_frm_town'] == 5) && ($bo_details['inside_outside_town'] == 'm')) { ?>
                                                            <label class="control-label" >A. ১) অবেদিত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                                
                                                        <?php } ?>
                                                            
                                                            <?php
                                                            if ($bo->land_scenario == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->prim_assesed == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->approved == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if(!empty($bo->reason))
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                                        <td>
                                                            <?php echo $bo->reason; ?>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                } elseif ((($bo_details['dist_frm_town'] == 10) && ($bo_details['inside_outside_town'] == 'i')) || (($bo_details['dist_frm_town'] == 15) && ($bo_details['inside_outside_town'] == 'i'))) {
                                                    //"This is within 10km from the boundry of town.";
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                        <?php
                                                        if ($bo_details['dist_frm_town'] == 10) { ?>
                                                            <label class="control-label" >A. ১) অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp;</label>
                                                            <?php } else { ?>
                                                            <label class="control-label" >A. ১) অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে ?  &nbsp;</label>
                                                            <?php } ?>

                                                            <?php
                                                            if (trim($bo->land_scenario) == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->prim_assesed == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->approved == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if(!empty($bo->reason))
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                                        <td>
                                                            <?php echo $bo->reason;?>
                                                        </td>
                                                    </tr> 
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                } elseif (($bo_details['dist_frm_town'] == 0) && ($bo_details['inside_outside_town'] == 'o')) {
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">

                                                            <label class="control-label" >A. ১) অবেদিত মাটি গাওৰ মাটি হয়নে ?  &nbsp;</label>

                                                            <?php
                                                            if ($bo->land_scenario == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->prim_assesed == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->approved == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if(!empty($bo->reason))
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                                        <td>
                                                            <?php echo $bo->reason;?>
                                                        </td>
                                                    </tr> 
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                } elseif ((($bo_details['dist_frm_town'] == 0) && ($bo_details['inside_outside_town'] == 'i')) || (($bo_details['dist_frm_town'] == 0) && ($bo_details['inside_outside_town'] == 'd'))) {
                                                    //"This is within Town Land.";
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <?php if($bo_details['inside_outside_town'] == 'd') { ?>
                                                            <label class="control-label" >A. ১) উক্ত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে ?  &nbsp; </label>
                                                            <?php } else { ?>
                                                            <label class="control-label" >A. ১) উক্ত মাটি নগৰ/চহৰৰ ভিতৰৰ মাটি হয়নে ?  &nbsp;</label>
                                                            <?php } ?>

                                                            <?php
                                                            echo $bo->land_scenario;
                        
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ২) একচনা পট্টাখনৰ এটা অংশ বিক্ৰী কৰা হৈছে নেকি আৰু যদি হৈছে, তেন্তে যিখিনি মাটিৰ ওপৰত স্বত্ত উপভোগ কৰি আছে, তাৰেই ম্যদীকৰনৰ বাবে আবেদন কৰা হৈছে নেকি ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->prt_transfer == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ৩) যদি (২) নং টো সছা হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->prim_assesed == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="control-label" > ৪) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                                            <?php
                                                            if ($bo->sent_to_govt == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if(!empty($bo->reason))
                                                    {
                                                        ?>
                                                    <tr>
                                                        <td><label class="control-label" > ৫) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                                        <td>
                                                            <?php echo $bo->reason; ?>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                }
                                                else {
                                                    if($lm_details['premium_new_yn'] == 1) {
                                                        ?>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">
                                                                        A. ১) <?php echo $conversion_premium_area->ass_name . ' '; ?>মাটি হয়নে ? &nbsp; 
                                                                    </label>
                                                                    <?php
                                                                        if (trim($bo->land_scenario) == 'Y') {
                                                                            echo " - হয়";
                                                                        } else {
                                                                            echo " - নহয়";
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">
                                                                    ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;
                                                                    </label>
                                                                    <?php
                                                                        if ($bo->prim_assesed == 'Y') {
                                                                            echo " - হয়";
                                                                        } else {
                                                                            echo " - নহয়";
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label class="control-label">
                                                                    ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;
                                                                    </label>
                                                                    <?php
                                                                        if ($bo->approved == 'Y') {
                                                                            echo " - হয়";
                                                                        } else {
                                                                            echo " - নহয়";
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <?php if(!empty($bo->reason)): ?>
                                                                    <td colspan="2">
                                                                        <label class="control-label">
                                                                            ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;
                                                                        </label>
                                                                        <?php echo $bo->reason; ?>
                                                                    </td>
                                                                   
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php
                                                    }
                                                }

                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <label class="control-label" >B. নদীৰ / ৰাস্তাৰ কাষৰ সংৰক্ষণৰ হনদৰ্ভত পৰীক্ষা কৰি সঠিক পোৱা গৈছেনে ? &nbsp;</label>
                                                        <?php
                                                            if ($bo->road_rvr_rerservation == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label class="control-label" >C. প্রতিবেদন পুণৰ পৰীক্ষণৰ প্ৰয়োজন আছে নেকি ? &nbsp;</label>
                                                        <?php
                                                            if ($bo->reverify == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><label class="control-label" >D. অন্যান্য তথ্য ও মন্তব্য &nbsp;</label></td>
                                                    <td>
                                                        <?php echo $bo->bo_note; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label class="control-label" > স্বাক্ষৰ (সাখা কর্মকর্তা) &nbsp;</label>
                                                        <?php
                                                            if ($bo->bo_sign_yn == 'Y') {
                                                                echo " - হয়";
                                                            } else {
                                                                echo " - নহয়";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label class="control-label" > সাখা কর্মকর্তাৰ নাম &nbsp; - <?php echo $bo_boname; ?></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label class="control-label" >তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($bo->bo_sign_date)); ?></label>
                                                    </td>
                                                </tr>
                                                <?php
                                                endforeach;
                                            }
                                            ?>
                                            </table>
                                            
                                            <table class="table table-bordered" style="font-size: 16px;">
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>Date of Order</td>
                                                    <td width="40%">DC / ADC (s) Recommendation Note</td>
                                                    <td width="40%">Note Of Action Taken on Order</td>
                                                </tr>
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>১</td>
                                                    <td>২</td>
                                                    <td>৩</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($dc_adc_order as $d_a_order):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo date('d-m-Y', strtotime($d_a_order->date_of_hearing)); ?></td>
                                                        <td>
                                                            <?php echo $d_a_order->co_order; ?></td>
                                                        <td>
                                                            <?php echo $d_a_order->note_on_order; ?>
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
                                                                        <td colspan="4">
                                                                        <?php // muzammil : new include file added for premium per bigha 
                                                                        include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                                                            <label class="control-label">বিঘাই প্রতি <?=round($bigha_prem, 2); ?> টকা হাৰে <?php echo $lm->dag_no; ?> নং দাগৰ <?php echo $lm->conv_b; ?> বিঘা, <?php echo $lm->conv_k; ?> কঠা, <?php echo round($lm->conv_lc, 2); ?> লেছা মাটিৰ প্রিমিয়াম হয় = <?php echo round($lm->prim_tot, 2); ?> টকা ।</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="text-align: center;">
                                                                        <td colspan="4"><label class="control-label">মুঠ প্রিমিয়াম = <?php echo round($lm->prim_tot, 2); ?></label></td>
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
                                                            echo "<span class='rasid' style='color: red;'>Waiting for DC / ADC's instruction/order for Generating and serving Notice for Premium.</span>";
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
                                                <span class='rasid'>Waiting for DC / ADC's instruction/order for Generating and serving Notice for Premium</span>
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
    function ConfResent(val) {
        var theInput = document.getElementById("remove");
        if(val.checked == true) {
            if(confirm('Are you sure you want Circle Officer to rewrite report?')) {
                theInput.removeAttribute("required");
                theInput.checked = false;
                theInput.disabled = true;
                // return (true);
            }
            else{
                return false;
            }
        }
        else{
            theInput.required = true;
            theInput.disabled = false;

        }
        // if (!confirm('Are you sure you want Circle Officer to rewrite report?'))
        // {
        //     return (false);
        // }
        // else
        // {
        //     var theInput = document.getElementById("remove");
        //     theInput.removeAttribute("required");
        //     return (true);
        // }
    }
    
    function modaldiva(objButton) {
        if (objButton == 1)
        {
            document.getElementById('notice1').style.display = 'block';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 2)
        {
            document.getElementById('notice2').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 3)
        {
            document.getElementById('notice3').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 4)
        {
            document.getElementById('notice4').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 5)
        {
            document.getElementById('notice5').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 6)
        {
            document.getElementById('notice6').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
    }


</script>