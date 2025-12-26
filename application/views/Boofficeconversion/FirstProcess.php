<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">সাখা কর্মকর্তাৰ প্ৰতিবেদন ( গোচৰ নং : <?php echo $location['case_no']; ?> )</h2>
                    <center><span class="uni_text" style="color: red;">( দাগ নং  : <?php echo $land_details['dag']; ?> )</span></center>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form name="main" class="" method='post' action="<?php echo base_url() . "index.php/BranchOfficerConversion/FirstProceeding_save"; ?>">
                            <table class='table table-striped table-bordered' style="font-size: 20px;">
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label green" >প্ৰতিবেদন দিবৰ সময়ত শাখা বিষয়ায়ে লাঃমঃ/চুঃকাঃ/চক্ৰ বিষয়াৰ প্ৰতিবেদন পৰীক্ষা কৰাৰ লগতে তলৰ বিষয় বিলাকৰ ওপৰত সঠিক তথ্য দিব ।  &nbsp;</label>
                                    </td>
                                </tr>
                                <?php
                                $notice = '<span class="red">যদি নহয় । অই গোচৰ পুনৰ পৰীক্ষনৰ ববে ছক্ৰ বিষয়াৰ লৈ অবগত কৰা হৱ ।</span>';
                                if ((($lm_details_final[0]->dist_frm_town == 3) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 15) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'm'))) {
                                    //"This is within 3km from the boundry of town.";
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php if($lm_details_final[0]->dist_frm_town == 3) { ?>
                                                <label class="control-label" >A. ১) অবেদিত মাটি চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } elseif(($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'i')) { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } elseif(($lm_details_final[0]->dist_frm_town == 5) && ($lm_details_final[0]->inside_outside_town == 'm')) { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } else { ?>
                                                <label class="control-label" >A. ১) অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } ?>
                                            
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio1" class='reasons' value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio2" class='reasons' value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr id='reason'>
                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                        <td>
                                            <textarea name="reason" class="form-control" cols="4" rows="4" placeholder="Write Reason if any"></textarea>
                                        </td>
                                    </tr>
                                    <?php
                                } elseif ((($lm_details_final[0]->dist_frm_town == 10) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 15) && ($lm_details_final[0]->inside_outside_town == 'g'))) {
                                    //"This is within 10km from the boundry of town.";
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php if($lm_details_final[0]->dist_frm_town == 10) { ?>
                                                <label class="control-label" >A. ১) অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                           
                                            <?php } elseif(($lm_details_final[0]->dist_frm_town == 15) && ($lm_details_final[0]->inside_outside_town == 'g')) { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            
                                            <?php } ?>
                                            
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio1" class='reasons' value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio2" class='reasons' value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr id='reason'>
                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                        <td>
                                            <textarea name="reason" class="form-control" cols="4" rows="4" placeholder="Write Reason if any"></textarea>
                                        </td>
                                    </tr>
                                    <?php
                                } elseif (($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'o')) {
                                    //"This is within 10km from the boundry of town.";
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" >A. ১) অবেদিত মাটি গাওৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio1" class='reasons' value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="approved" id="inlineRadio2" class='reasons' value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr id='reason'>
                                        <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                        <td>
                                            <textarea name="reason" class="form-control" cols="4" rows="4" placeholder="Write Reason if any"></textarea>
                                        </td>
                                    </tr>
                                    <?php
                                } elseif ((($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'i')) || (($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'd')) || (($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'm')) || (($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'g')) || (($lm_details_final[0]->dist_frm_town == 0) && ($lm_details_final[0]->inside_outside_town == 'r'))) {
                                    //"This is within Town Land.";
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php if($lm_details_final[0]->inside_outside_town == 'd') { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } elseif($lm_details_final[0]->inside_outside_town == 'm') { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি পৌৰ নগৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } elseif($lm_details_final[0]->inside_outside_town == 'g') { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি গুৱাহাটী মহানগৰী মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } elseif($lm_details_final[0]->inside_outside_town == 'r') { ?>
                                                <label class="control-label" >A. ১) উক্ত মাটি ৰাজহ নগৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } else { ?>
                                            <label class="control-label" >A. ১) উক্ত মাটি নগৰ/চহৰৰ ভিতৰৰ মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>
                                            <?php } ?>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="land_scenario" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ২) একচনা পট্টাখনৰ এটা অংশ বিক্ৰী কৰা হৈছে নেকি আৰু যদি হৈছে, তেন্তে যিখিনি মাটিৰ ওপৰত স্বত্ত উপভোগ কৰি আছে, তাৰেই ম্যদীকৰনৰ বাবে আবেদন কৰা হৈছে নেকি ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="prt_transfer" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="prt_transfer" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৩) যদি ক্ৰ্মিক নং (২) টো সছা হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="prim_assesed" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৪) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                            <label>
                                                <input type="radio" name="sent_to_govt" id="inlineRadio1" class='reasons' value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="sent_to_govt" id="inlineRadio2" class='reasons' value="N" required>  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr id='reason'>
                                        <td><label class="control-label" > ৫) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                        <td>
                                            <textarea name="reason" class="form-control" cols="4" rows="4" placeholder="Write Reason if any"></textarea>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else {
                                    if($lm_details['premium_new_yn'] == 1) {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" >A. ১) <?php echo $conversion_premium_area->ass_name . ' '; ?>মাটি হয়নে ?  &nbsp; <?php echo $notice;?> &nbsp;</label>

                                                <label>
                                                    <input type="radio" name="land_scenario" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="land_scenario" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ২) যদি হয়, তেন্তে প্ৰিমিয়ামৰ পৰিমাণ সঠিককৈ নিৰ্ধাৰণ / গণনা কৰা হ'লনে ? &nbsp;</label>
                                                <label>
                                                    <input type="radio" name="prim_assesed" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="prim_assesed" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৩) এই প্রতিবেদন চৰকাৰৰ অনুমোদনৰ বাবে পঠাব পাৰিনে ? &nbsp;</label>
                                                <label>
                                                    <input type="radio" name="approved" id="inlineRadio1" class='reasons' value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="approved" id="inlineRadio2" class='reasons' value="N" required>  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr id='reason'>
                                            <td><label class="control-label" > ৪) যদি নোৱাৰি, তেন্তে কি কাৰনে নোৱাৰি ? &nbsp;</label></td>
                                            <td>
                                                <textarea name="reason" class="form-control" cols="4" rows="4" placeholder="Write Reason if any"></textarea>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >B. নদীৰ / ৰাস্তাৰ কাষৰ সংৰক্ষণৰ হনদৰ্ভত পৰীক্ষা কৰি সঠিক পোৱা গৈছেনে ? &nbsp;</label>
                                        <label>
                                            <input type="radio" name="road_rvr_rerservation" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                        </label>
                                        <label>
                                            <input type="radio" name="road_rvr_rerservation" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >C. প্রতিবেদন পুণৰ পৰীক্ষণৰ প্ৰয়োজন আছে নেকি ? &nbsp;</label>
                                        <label>
                                            <input type="radio" name="reverify" id="inlineRadio1" value="Y" required>   <?php echo $this->lang->line('yes'); ?>
                                        </label>
                                        <label>
                                            <input type="radio" name="reverify" id="inlineRadio2" value="N" required>  <?php echo $this->lang->line('no'); ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%"><label class="control-label" >D. অন্যান্য তথ্য ও মন্তব্য &nbsp;</label></td>
                                    <td>
                                        <?php
                                        foreach ($lm_details_final as $lm):
                                            $p=round($lm->prim_per_bigha, 2);
                                            $pt=round($lm->prim_tot, 2);
                                            // $prem_percent=$lm->premium_assesment."%";
                                            if($lm->premium_new_yn == 0 || $lm->premium_new_yn == null) {
                                                if ((($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'o')) || (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm')) || (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'r')) || ($lm->dist_frm_town == '3') || (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm'))) {
                                                    if (trim($lm->premium_assesment) == '40' || trim($lm->premium_assesment) == '20') {
                                                        $prem_percent=$lm->premium_assesment." টকা";
                                                    }else{
                                                        $prem_percent=$lm->premium_assesment." %";
                                                    }
                                                } else{
                                                    $prem_percent=$lm->premium_assesment." %";
                                                }
                                            }
                                            else {
                                                if($conversion_premium_rate->rate != 0 && $conversion_premium_rate->amount == 0) {
                                                    $prem_percent=$conversion_premium_rate->rate." %";
                                                }
                                                else if($conversion_premium_rate->rate == 0 && $conversion_premium_rate->amount != 0) {
                                                    $prem_percent=$conversion_premium_rate->amount." টকা";
                                                }
                                                
                                            }
                                        endforeach;
                                        if (($lm_details['jati_janajati_yn'] == '0') && ($lm_details['freedom_fighter_yn'] == '0') && ($lm_details['widow_yn'] == '0'))
                                        {
                                            $msg="";
                                            //$msg="২৫% ৰেহাই পাচত";
                                        }
                                        else{
                                            $msg="২৫% ৰেহাই পাচত";
                                        }
                                        ?>
                                        <input type="hidden" name="bo_notice_predefined" value="চক্ৰ বিযয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰৰ পৰা <?php echo $location['case_no']; ?> নং ম্যাদীকৰনৰ প্ৰস্তাব পৰীক্ষা কৰি চোৱা হল | আবেদিত জমী অসম ভূমিলেখ নিয়মাবলী, ১৯০৬ ৰ ১০৫ নং নিয়ম অনুসৰি আবেদিত জমী ম্যাদী উপযোগী হোৱাত অসম চৰকাৰা শেহতীয়া নিৰ্দ্দেশনা অনুসৰি আবেদিত জমীৰ ম্যাদীকৰন প্ৰিমিয়াম বিঘাই প্ৰতি <?php echo $prem_percent; ?> হিচাপে <?php echo $msg;?> মুঠ <?php echo $pt; ?> টকা আদায় মৰ্মে ম্যাদীকৰন হুকুম দিব পাৰে | শাখা বিষয়া ">
                                        <textarea name="bo_notice" class="form-control" cols="8" rows="8"></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" > স্বাক্ষৰ (সাখা কর্মকর্তা) &nbsp;</label>
                                        <label>
                                            <input type="radio" name="bo_sign_yn" id="inlineRadio1" value="Y" checked>   <?php echo $this->lang->line('yes'); ?>
                                        </label>
                                        <label>
                                            <input type="radio" name="bo_sign_yn" id="inlineRadio2" value="N">  <?php echo $this->lang->line('no'); ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" > সাখা কর্মকর্তাৰ নাম &nbsp;</label>
                                        <input type="hidden" name="bo_code" value="<?php echo $land_details['bo_code']; ?>"/>
                                        <input type="text" name="bo_name" style="width: 200px;" value="<?php echo $land_details['bo_name']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >তাৰিখ &nbsp;</label>
                                        <input type="text" name="date_of_entry" id="popupDatepicker" style="width: 200px;" required>
                                        &nbsp; (dd/mm/yyyy)
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                            <input type="hidden" name="dag_no" value="<?php echo $land_details['dag']; ?>"/>
                            <?php if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) { ?>
                            <input type="hidden" name="dist_frm_town" value="<?php echo $lm_details_final[0]->dist_frm_town; ?>"/>
                            <input type="hidden" name="inside_outside_town" value="<?php echo $lm_details_final[0]->inside_outside_town; ?>"/>
                            <?php } ?>
                            <center>
                                <button type="submit" name="submit" class="btn btn-danger uni_text"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                            </center>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>

                        <!--------------------------Newly discarded--------------------------->
                        <!-- <form name="revert_form" method='post' action="<?php echo base_url() . "index.php/BranchOfficerConversion/revert_to_co"; ?>">
                        <input type="hidden" name="bo_code" value="<?php echo $land_details['bo_code']; ?>"/>
                        <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                        <center>
                        <button type="submit" name="submitrevert" class="btn btn-danger uni_text"><i class="fa fa-check"></i>&nbsp;Send Back for Re-verification by Circle Officer</button>
                        </center>
                        </form> -->
                        <!--------------------------------------------------------------------->
                        <!-- <a  class="btn btn-danger uni_text" href='<?php echo base_url() . "index.php/BranchOfficerConversion/revert_to_co?case_no=" . $location['case_no']; ?>'><i class="fa fa-list-alt"></i>&nbsp; Send Back for Re-verification by Circle Officer</a> -->
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <a  class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=4&dist=" . $l_data['dist_code'] . "&sub_div=" . $l_data['subdiv_code'] . "&cir=" . $l_data['cir_code'] . "&m=" . $l_data['mouza_pargona_code'] . "&l=" . $l_data['lot_no'] . "&v=" . $l_data['vill_code'] . "&p=" . $land_details['patta_type'] . "&dag=" . $land_details['dag']; ?>" target="_blank"><i class="fa fa-list-alt"></i>&nbsp; চিঠা চাওক</a>
                                <a  class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><i class="fa fa-list-alt"></i>&nbsp; জমাবন্দী চাওক</a>
                                <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-envelope-o '></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <button type="" class="btn btn-active uni_text" value="2" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope-o "></i> &nbsp;<?php echo $this->lang->line('lm_report'); ?></button>
                                <button type="" class="btn btn-info uni_text" value="3" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope-o "></i> &nbsp; AST & CO Report</button>
                                <button type="" class="btn btn-default uni_text" value="4" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope-o "></i> &nbsp; <?php echo $this->lang->line('sk_report'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/BranchOfficerConversion/GoToBO?pro=2"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
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
                                                <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=4&dist=" . $l_data['dist_code'] . "&sub_div=" . $l_data['subdiv_code'] . "&cir=" . $l_data['cir_code'] . "&m=" . $l_data['mouza_pargona_code'] . "&l=" . $l_data['lot_no'] . "&v=" . $l_data['vill_code'] . "&p=" . $land_details['patta_type'] . "&dag=" . $land_details['dag']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
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
                                                                if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                                                {
                                                                    $msg="";
                                                                    echo " - এই আবেদনত উপযোগী নহয় |";
                                                                }
                                                                else{
                                                                    $msg="আৰু ২৫% ৰেহাই পাচত";
                                                                }
                                                                if ($lm_details_final[0]->jati_janajati_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';

                                                                        if(empty($lm_details_final[0]->jati_janajati_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm_details_final[0]->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                } 
                                                                if ($lm_details_final[0]->freedom_fighter_yn == 'Y') {
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
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                if ($lm_details_final[0]->widow_yn == 'Y') {
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
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
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
                                                            <td colspan="2"><label class="control-label" >
                                                                    ৯) 
                                                                    <?php
                                                                    if (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'o')) {
                                                                        echo "উক্ত মাটি গাওঁৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি নগৰ/চহৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'r')) {
                                                                        echo "অবেদিত মাটি ৰাজহ নগৰ মাটি হয়নে - হয়";
                                                                    } elseif ($lm->dist_frm_town == '3') {
                                                                        echo "অবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'd')) {
                                                                        echo "অবেদিত মাটি জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'm')) {
                                                                        echo "অবেদিত মাটি পৌৰ নগৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm')) {
                                                                        echo "অবেদিত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰী মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town == 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town != 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা সদৰ, উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '10') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    }
                                                                    else {
                                                                        if($lm_details['premium_new_yn'] == 1) {
                                                                            echo $conversion_premium_area->ass_name . ' মাটি হয়নে - হয়';
                                                                        }
                                                                    }
                                                                    
                                                                    ?></label>
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
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
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
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
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
                                                                                <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0)" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
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
                                                                <label class="control-label" >
                                                                    ৯) 
                                                                    <?php
                                                                    if (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'o')) {
                                                                        echo "উক্ত মাটি গাওঁৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি নগৰ/চহৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'r')) {
                                                                        echo "অবেদিত মাটি ৰাজহ নগৰ মাটি হয়নে - হয়";
                                                                    } elseif ($lm->dist_frm_town == '3') {
                                                                        echo "অবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'd')) {
                                                                        echo "অবেদিত মাটি জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'm')) {
                                                                        echo "অবেদিত মাটি পৌৰ নগৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm')) {
                                                                        echo "অবেদিত মাটি পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰী মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town == 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town != 'g')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা সদৰ, উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে - হয়";
                                                                    } elseif (($lm->dist_frm_town == '10') && ($lm->inside_outside_town == 'i')) {
                                                                        echo "অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                                                    }
                                                                    else {
                                                                        if($lm_details['premium_new_yn'] == 1) {
                                                                            echo $conversion_premium_area->ass_name . ' মাটি হয়নে - হয়';
                                                                        }
                                                                    }
                                                                    ?></label>

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
                                        <p class='center bold uni_text'><u>CIRCLE OFFICER REPORT</u></p>
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
                                                    <td>Date of Order</td>
                                                    <td width="60%">DC / ADC (s) Recommendation Note</td>
                                                </tr>
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>১</td>
                                                    <td>২</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($dc_adc_order as $d_a_order):
                                                    ?>
                                                    <tr>
                                                        <td class="center"><?php echo date('d-m-Y', strtotime($d_a_order->date_of_hearing)); ?></td>
                                                        <td>
                                                            <?php echo $d_a_order->dc_order; ?>
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
                                                                        <td colspan="4"><label class="control-label">বিঘাই প্রতি <?php echo round($lm->prim_per_bigha, 2); ?> টকা হাৰে <?php echo $lm->dag_no; ?> নং দাগৰ <?php echo $lm->conv_b; ?> বিঘা, <?php echo $lm->conv_k; ?> কঠা, <?php echo round($lm->conv_lc, 2); ?> লেছা মাটিৰ প্রিমিয়াম হয় = <?php echo round($lm->prim_tot, 2); ?> টকা ।</label></td>
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
    $("#reason").hide();
    $('.reasons').change(function () {
        var selected_value = $('.reasons:checked').val();
        if(selected_value=='N') {
            $("#reason").show();
        }
        else
        {
            $("#reason").hide();
        }
    });
    
    function ConfResent() {
        if (!confirm('Are you sure you want Circle Officer to rewrite report?'))
        {
            return (false);
        }
        else
        {
            var theInput = document.getElementById("remove");
            theInput.removeAttribute("required");
            return (true);
        }
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
